<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use Illuminate\Http\Request;

class DestinasiController extends Controller
{
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
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Wisata Alam,Wisata Buatan,Wisata Budaya,Wisata Minat Khusus',
            'alamat' => 'required|string',
            'lokasi' => 'required|in:solo,yogyakarta',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Wisata Alam,Wisata Buatan,Wisata Budaya,Wisata Minat Khusus',
            'alamat' => 'required|string',
            'lokasi' => 'required|in:solo,yogyakarta',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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

