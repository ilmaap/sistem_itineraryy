<?php

namespace App\Http\Controllers;

use App\Models\LiburNasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LiburNasionalController extends Controller
{
    /**
     * Menampilkan daftar libur nasional
     */
    public function index(Request $request)
    {
        $query = LiburNasional::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('tahun', 'like', '%' . $search . '%')
                  ->orWhereDate('tanggal', 'like', '%' . $search . '%');
            });
        }

        // Pagination
        $liburNasional = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('admin.index_libur_nasional', [
            'liburNasional' => $liburNasional,
            'search' => $request->search ?? ''
        ]);
    }

    /**
     * Menampilkan form untuk membuat libur nasional baru
     */
    public function create()
    {
        return view('admin.kelola_libur_nasional');
    }

    /**
     * Menyimpan libur nasional baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2100',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'nama.required' => 'Nama hari libur wajib diisi.',
            'nama.max' => 'Nama hari libur maksimal 255 karakter.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal 2000.',
            'tahun.max' => 'Tahun maksimal 2100.',
        ]);

        LiburNasional::create($validated);

        return redirect()->route('admin.libur_nasional.index')
            ->with('success', 'Hari libur nasional berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit libur nasional
     */
    public function edit($id)
    {
        $liburNasional = LiburNasional::findOrFail($id);
        return view('admin.kelola_libur_nasional', ['liburNasional' => $liburNasional]);
    }

    /**
     * Mengupdate libur nasional
     */
    public function update(Request $request, $id)
    {
        $liburNasional = LiburNasional::findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2100',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'nama.required' => 'Nama hari libur wajib diisi.',
            'nama.max' => 'Nama hari libur maksimal 255 karakter.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal 2000.',
            'tahun.max' => 'Tahun maksimal 2100.',
        ]);

        $liburNasional->update($validated);

        return redirect()->route('admin.libur_nasional.index')
            ->with('success', 'Hari libur nasional berhasil diperbarui.');
    }

    /**
     * Menghapus libur nasional
     */
    public function destroy($id)
    {
        $liburNasional = LiburNasional::findOrFail($id);
        $liburNasional->delete();

        return redirect()->route('admin.libur_nasional.index')
            ->with('success', 'Hari libur nasional berhasil dihapus.');
    }
}

