<?php

namespace App\Http\Controllers;

use App\Models\Akomodasi;
use Illuminate\Http\Request;

class AkomodasiController extends Controller
{
    /**
     * Menampilkan daftar akomodasi
     */
    public function index(Request $request)
    {
        $query = Akomodasi::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Pagination
        $akomodasi = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.index_akomodasi', [
            'akomodasi' => $akomodasi,
            'search' => $request->search ?? ''
        ]);
    }

    /**
     * Menampilkan form untuk membuat akomodasi baru
     */
    public function create()
    {
        return view('admin.kelola_akomodasi');
    }

    /**
     * Menyimpan akomodasi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'lokasi' => 'required|in:solo,yogyakarta',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'rating' => 'nullable|numeric|min:0|max:5',
            'deskripsi' => 'nullable|string',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'lokasi.required' => 'Lokasi wajib dipilih.',
            'lokasi.in' => 'Lokasi harus Solo atau Yogyakarta.',
            'latitude.required' => 'Latitude wajib diisi.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.required' => 'Longitude wajib diisi.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
            'rating.min' => 'Rating minimal 0.',
            'rating.max' => 'Rating maksimal 5.',
        ]);

        Akomodasi::create($validated);

        return redirect()->route('admin.akomodasi.index')
            ->with('success', 'Akomodasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit akomodasi
     */
    public function edit($id)
    {
        $akomodasi = Akomodasi::findOrFail($id);
        return view('admin.kelola_akomodasi', ['akomodasi' => $akomodasi]);
    }

    /**
     * Mengupdate akomodasi
     */
    public function update(Request $request, $id)
    {
        $akomodasi = Akomodasi::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'lokasi' => 'required|in:solo,yogyakarta',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'rating' => 'nullable|numeric|min:0|max:5',
            'deskripsi' => 'nullable|string',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'lokasi.required' => 'Lokasi wajib dipilih.',
            'lokasi.in' => 'Lokasi harus Solo atau Yogyakarta.',
            'latitude.required' => 'Latitude wajib diisi.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.required' => 'Longitude wajib diisi.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
            'rating.min' => 'Rating minimal 0.',
            'rating.max' => 'Rating maksimal 5.',
        ]);

        $akomodasi->update($validated);

        return redirect()->route('admin.akomodasi.index')
            ->with('success', 'Akomodasi berhasil diperbarui.');
    }

    /**
     * Menghapus akomodasi
     */
    public function destroy($id)
    {
        $akomodasi = Akomodasi::findOrFail($id);
        $akomodasi->delete();

        return redirect()->route('admin.akomodasi.index')
            ->with('success', 'Akomodasi berhasil dihapus.');
    }
}
