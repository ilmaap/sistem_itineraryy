<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
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

