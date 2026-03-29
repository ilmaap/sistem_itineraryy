<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use Illuminate\Http\Request;

class DestinasiController extends Controller
{
    /**
     * Normalisasi input uang agar format Indonesia seperti "15.000" -> "15000"
     * (dan "1.234.567,89" -> "1234567.89") sebelum validasi + simpan.
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

        // Hanya izinkan digit dan separator '.' ','
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
            // "1.234.567,89" => "1234567.89"
            $clean = str_replace('.', '', $clean);
            $clean = str_replace(',', '.', $clean);
        } elseif ($hasComma) {
            // "123,45" => "123.45"
            $clean = str_replace(',', '.', $clean);
        } else {
            // Hanya titik: bisa jadi "15.000" (ribuan) atau "15.50" (desimal).
            $parts = explode('.', $clean);
            if (count($parts) === 2 && strlen($parts[1]) === 3) {
                // Contoh: "15.000" -> "15000"
                $clean = $parts[0] . $parts[1];
            } elseif (count($parts) >= 3) {
                // Jika semua bagian kecuali terakhir panjangnya 3, anggap ribuan.
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
                    // Tidak ada separator ribuan lagi, desimal mengikuti format asli.
                }
            }
        }

        // Pastikan minimal masih ada digit
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
     * Menampilkan daftar destinasi
     */
    public function index(Request $request)
    {
        $query = Destinasi::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        // Pagination
        $destinasi = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.index_destinasi', [
            'destinasi' => $destinasi,
            'search' => $request->search ?? ''
        ]);
    }

    /**
     * Menampilkan form untuk membuat destinasi baru
     */
    public function create()
    {
        return view('admin.kelola_destinasi');
    }

    /**
     * Menyimpan destinasi baru
     */
    public function store(Request $request)
    {
        $request->merge([
            'biaya' => $this->normalizeMoneyToDotDecimal($request->input('biaya')),
        ]);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Wisata Alam,Wisata Buatan,Wisata Budaya,Wisata Minat Khusus',
            'alamat' => 'required|string',
            'lokasi' => 'required|in:solo,yogyakarta',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            // DB kolom time biasanya dibaca Eloquent sebagai "HH:MM:SS".
            // Pastikan validasi menerima keduanya: "HH:MM" dan "HH:MM:SS".
            'jam_buka' => ['nullable', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'jam_tutup' => ['nullable', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'rating' => 'nullable|numeric|min:0|max:5',
            'biaya' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Destinasi::create($validated);

        return redirect()->route('admin.destinasi.index')
            ->with('success', 'Destinasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit destinasi
     */
    public function edit($id)
    {
        $destinasi = Destinasi::findOrFail($id);
        return view('admin.kelola_destinasi', compact('destinasi'));
    }

    /**
     * Update destinasi
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'biaya' => $this->normalizeMoneyToDotDecimal($request->input('biaya')),
        ]);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Wisata Alam,Wisata Buatan,Wisata Budaya,Wisata Minat Khusus',
            'alamat' => 'required|string',
            'lokasi' => 'required|in:solo,yogyakarta',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            // DB kolom time biasanya dibaca Eloquent sebagai "HH:MM:SS".
            // Pastikan validasi menerima keduanya: "HH:MM" dan "HH:MM:SS".
            'jam_buka' => ['nullable', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'jam_tutup' => ['nullable', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'rating' => 'nullable|numeric|min:0|max:5',
            'biaya' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $destinasi = Destinasi::findOrFail($id);
        $destinasi->update($validated);

        return redirect()->route('admin.destinasi.index')
            ->with('success', 'Destinasi berhasil diperbarui.');
    }

    /**
     * Hapus destinasi
     */
    public function destroy($id)
    {
        $destinasi = Destinasi::findOrFail($id);
        $destinasi->delete();

        return redirect()->route('admin.destinasi.index')
            ->with('success', 'Destinasi berhasil dihapus.');
    }
}

