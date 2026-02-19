<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Menampilkan daftar restaurant
     */
    public function index(Request $request)
    {
        $query = Restaurant::query();

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
        $restaurant = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.index_restaurant', [
            'restaurant' => $restaurant,
            'search' => $request->search ?? ''
        ]);
    }

    /**
     * Menampilkan form untuk membuat restaurant baru
     */
    public function create()
    {
        return view('admin.kelola_restaurant');
    }

    /**
     * Menyimpan restaurant baru
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

        Restaurant::create($validated);

        return redirect()->route('admin.restaurant.index')
            ->with('success', 'Restaurant berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit restaurant
     */
    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('admin.kelola_restaurant', ['restaurant' => $restaurant]);
    }

    /**
     * Mengupdate restaurant
     */
    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

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

        $restaurant->update($validated);

        return redirect()->route('admin.restaurant.index')
            ->with('success', 'Restaurant berhasil diperbarui.');
    }

    /**
     * Menghapus restaurant
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();

        return redirect()->route('admin.restaurant.index')
            ->with('success', 'Restaurant berhasil dihapus.');
    }
}

