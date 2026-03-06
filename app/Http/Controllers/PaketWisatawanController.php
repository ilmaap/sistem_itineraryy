<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketWisatawanController extends Controller
{
    /**
     * Menampilkan daftar paket untuk wisatawan
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

        // Filter by durasi (optional)
        if ($request->has('durasi') && $request->durasi != '') {
            $query->where('durasi', $request->durasi);
        }

        // Filter by harga range (optional)
        if ($request->has('harga_min') && $request->harga_min != '') {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->has('harga_max') && $request->harga_max != '') {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Pagination
        $paket = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('wisatawan.paket.index', [
            'paket' => $paket,
            'search' => $request->search ?? '',
            'durasi' => $request->durasi ?? '',
            'harga_min' => $request->harga_min ?? '',
            'harga_max' => $request->harga_max ?? ''
        ]);
    }

    /**
     * Menampilkan detail paket untuk wisatawan
     */
    public function show($id)
    {
        $paket = Paket::with('destinasi')->findOrFail($id);
        
        // Group destinasi by hari (order)
        $destinasiPerHari = $paket->destinasi->groupBy(function($dest) {
            return $dest->pivot->order ?? 1;
        })->sortKeys();

        return view('wisatawan.paket.show', compact('paket', 'destinasiPerHari'));
    }

    /**
     * Menampilkan daftar paket untuk landing page (public)
     */
    public function publicIndex(Request $request)
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

        // Filter by durasi (optional)
        if ($request->has('durasi') && $request->durasi != '') {
            $query->where('durasi', $request->durasi);
        }

        // Filter by harga range (optional)
        if ($request->has('harga_min') && $request->harga_min != '') {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->has('harga_max') && $request->harga_max != '') {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Pagination
        $paket = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('paket-wisata-index', [
            'paket' => $paket,
            'search' => $request->search ?? '',
            'durasi' => $request->durasi ?? '',
            'harga_min' => $request->harga_min ?? '',
            'harga_max' => $request->harga_max ?? ''
        ]);
    }

    /**
     * Menampilkan detail paket untuk landing page (public)
     */
    public function publicShow($id)
    {
        $paket = Paket::with('destinasi')->findOrFail($id);
        
        // Group destinasi by hari (order)
        $destinasiPerHari = $paket->destinasi->groupBy(function($dest) {
            return $dest->pivot->order ?? 1;
        })->sortKeys();

        return view('paket-wisata-show', compact('paket', 'destinasiPerHari'));
    }
}

