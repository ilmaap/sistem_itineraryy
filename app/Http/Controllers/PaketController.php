<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    /**
     * Normalisasi input uang agar format Indonesia seperti "15.000" -> "15000"
     * sebelum validasi + simpan ke kolom decimal.
     */
    private function normalizeMoneyToDotDecimal(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        $negative = false;
        if (isset($value[0]) && $value[0] === '-') {
            $negative = true;
            $value = substr($value, 1);
        }

        $clean = '';
        $len = strlen($value);
        for ($i = 0; $i < $len; $i++) {
            $ch = $value[$i];
            if (($ch >= '0' && $ch <= '9') || $ch === '.' || $ch === ',') {
                $clean .= $ch;
            }
        }

        if ($clean === '') {
            return null;
        }

        $hasDot = strpos($clean, '.') !== false;
        $hasComma = strpos($clean, ',') !== false;

        if ($hasDot && $hasComma) {
            $clean = str_replace('.', '', $clean);
            $clean = str_replace(',', '.', $clean);
        } elseif ($hasComma) {
            $clean = str_replace(',', '.', $clean);
        } else {
            $parts = explode('.', $clean);
            if (count($parts) === 2 && strlen($parts[1]) === 3) {
                // Contoh: "15.000" -> "15000"
                $clean = $parts[0] . $parts[1];
            } elseif (count($parts) >= 3) {
                $assumeThousands = true;
                for ($i = 0; $i < count($parts) - 1; $i++) {
                    if (strlen($parts[$i]) !== 3) {
                        $assumeThousands = false;
                        break;
                    }
                }

                if ($assumeThousands) {
                    $last = end($parts);
                    $clean = '';
                    for ($i = 0; $i < count($parts) - 1; $i++) {
                        $clean .= $parts[$i];
                    }
                    $clean .= $last;
                }
            }
        }

        $digits = str_replace(['.', ','], '', $clean);
        if ($digits === '' || !is_numeric($digits)) {
            return null;
        }

        if ($negative) {
            return '-' . $clean;
        }

        return $clean;
    }

    /**
     * Menampilkan daftar paket
     */
    public function index(Request $request)
    {
        $query = Paket::with('destinasi');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Pagination
        $paket = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.index_paket', [
            'paket' => $paket,
            'search' => $request->search ?? ''
        ]);
    }

    /**
     * Menampilkan form untuk membuat paket baru
     */
    public function create()
    {
        $destinasi = Destinasi::orderBy('nama')->get();
        return view('admin.kelola_paket', compact('destinasi'));
    }

    /**
     * Menyimpan paket baru
     */
    public function store(Request $request)
    {
        $request->merge([
            'harga' => $this->normalizeMoneyToDotDecimal($request->input('harga')),
        ]);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'durasi' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'destinasi' => 'nullable|array',
            'destinasi.*' => 'exists:destinasi,id',
            'hari' => 'nullable|array',
            'hari.*' => 'nullable|integer|min:1',
        ]);

        // Upload gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('paket', 'public');
            $validated['image'] = $imagePath;
        }

        // Simpan paket
        $paket = Paket::create($validated);

        // Simpan relasi destinasi dengan hari (disimpan di kolom order)
        // Urutan sebenarnya mengikuti index array (urutan input)
        if ($request->has('destinasi') && is_array($request->destinasi)) {
            $destinasiData = [];
            $destinasiPerHari = []; // Untuk menghitung jumlah destinasi per hari
            
            foreach ($request->destinasi as $index => $destinasiId) {
                if (!empty($destinasiId)) {
                    // Hari disimpan di kolom 'order' (tanpa menambah kolom baru)
                    $hari = isset($request->hari[$index]) && $request->hari[$index] !== '' ? (int)$request->hari[$index] : 1;
                    // Validasi hari tidak melebihi durasi paket
                    if ($hari > $paket->durasi) {
                        $hari = $paket->durasi;
                    }
                    
                    // Hitung jumlah destinasi per hari
                    if (!isset($destinasiPerHari[$hari])) {
                        $destinasiPerHari[$hari] = 0;
                    }
                    $destinasiPerHari[$hari]++;
                    
                    // Validasi: maksimal 4 destinasi per hari
                    if ($destinasiPerHari[$hari] > 4) {
                        return redirect()->back()
                            ->withErrors(['destinasi' => "Hari ke-{$hari} sudah memiliki 4 destinasi. Maksimal 4 destinasi per hari."])
                            ->withInput();
                    }
                    
                    // Urutan sebenarnya mengikuti index (urutan input)
                    $destinasiData[$destinasiId] = ['order' => $hari];
                }
            }
            if (!empty($destinasiData)) {
                $paket->destinasi()->attach($destinasiData);
            }
        }

        return redirect()->route('admin.paket.index')
            ->with('success', 'Paket berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit paket
     */
    public function edit($id)
    {
        $paket = Paket::with('destinasi')->findOrFail($id);
        $destinasi = Destinasi::orderBy('nama')->get();
        return view('admin.kelola_paket', compact('paket', 'destinasi'));
    }

    /**
     * Update paket
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'harga' => $this->normalizeMoneyToDotDecimal($request->input('harga')),
        ]);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'durasi' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'destinasi' => 'nullable|array',
            'destinasi.*' => 'exists:destinasi,id',
            'hari' => 'nullable|array',
            'hari.*' => 'nullable|integer|min:1',
        ]);

        $paket = Paket::findOrFail($id);

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($paket->image && Storage::disk('public')->exists($paket->image)) {
                Storage::disk('public')->delete($paket->image);
            }
            
            // Upload gambar baru
            $imagePath = $request->file('image')->store('paket', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Jika tidak ada gambar baru, tetap gunakan gambar lama
            $validated['image'] = $paket->image;
        }

        $paket->update($validated);

        // Update relasi destinasi
        if ($request->has('destinasi') && is_array($request->destinasi)) {
            // Validasi: maksimal 4 destinasi per hari
            $destinasiPerHari = [];
            foreach ($request->destinasi as $index => $destinasiId) {
                if (!empty($destinasiId)) {
                    $hari = isset($request->hari[$index]) && $request->hari[$index] !== '' ? (int)$request->hari[$index] : 1;
                    // Validasi hari tidak melebihi durasi paket
                    if ($hari > $paket->durasi) {
                        $hari = $paket->durasi;
                    }
                    
                    // Hitung jumlah destinasi per hari
                    if (!isset($destinasiPerHari[$hari])) {
                        $destinasiPerHari[$hari] = 0;
                    }
                    $destinasiPerHari[$hari]++;
                    
                    // Validasi: maksimal 4 destinasi per hari
                    if ($destinasiPerHari[$hari] > 4) {
                        return redirect()->back()
                            ->withErrors(['destinasi' => "Hari ke-{$hari} sudah memiliki 4 destinasi. Maksimal 4 destinasi per hari."])
                            ->withInput();
                    }
                }
            }
            
            // Hapus semua relasi lama
            $paket->destinasi()->detach();
            
            // Tambahkan relasi baru dengan hari (disimpan di kolom order)
            // Urutan sebenarnya mengikuti index array (urutan input)
            $destinasiData = [];
            foreach ($request->destinasi as $index => $destinasiId) {
                if (!empty($destinasiId)) {
                    // Hari disimpan di kolom 'order' (tanpa menambah kolom baru)
                    $hari = isset($request->hari[$index]) && $request->hari[$index] !== '' ? (int)$request->hari[$index] : 1;
                    // Validasi hari tidak melebihi durasi paket
                    if ($hari > $paket->durasi) {
                        $hari = $paket->durasi;
                    }
                    // Urutan sebenarnya mengikuti index (urutan input)
                    $destinasiData[$destinasiId] = ['order' => $hari];
                }
            }
            if (!empty($destinasiData)) {
                $paket->destinasi()->attach($destinasiData);
            }
        } else {
            // Jika tidak ada destinasi yang dipilih, hapus semua relasi
            $paket->destinasi()->detach();
        }

        return redirect()->route('admin.paket.index')
            ->with('success', 'Paket berhasil diperbarui.');
    }

    /**
     * Hapus paket
     */
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        
        // Hapus gambar dari storage jika ada
        if ($paket->image && Storage::disk('public')->exists($paket->image)) {
            Storage::disk('public')->delete($paket->image);
        }
        
        $paket->delete();

        return redirect()->route('admin.paket.index')
            ->with('success', 'Paket berhasil dihapus.');
    }
}

