<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destinasi;
use App\Models\Itinerary;
use App\Models\ItineraryDestinasi;
use App\Models\LiburNasional;
use App\Models\Kategori;
use App\Models\Restaurant;
use App\Models\Akomodasi;
use Illuminate\Support\Facades\DB;

class ItineraryController extends Controller
{
    /**
     * Show the form for creating a new itinerary.
     */
    public function create()
    {
        // Ambil kategori dari database
        $kategoriList = Kategori::all();
        $kategori = [];
        foreach ($kategoriList as $kat) {
            // Mapping nama_kategori ke kode (alam, budaya, buatan, minat)
            $kode = strtolower(str_replace(' ', '', $kat->nama_kategori));
            if (strpos($kode, 'alam') !== false) $kode = 'alam';
            elseif (strpos($kode, 'budaya') !== false) $kode = 'budaya';
            elseif (strpos($kode, 'buatan') !== false) $kode = 'buatan';
            elseif (strpos($kode, 'minat') !== false) $kode = 'minat';
            else $kode = 'alam'; // default
            
            $kategori[$kode] = $kat->nama_kategori;
        }
        
        // Jika tidak ada kategori di database, gunakan default
        if (empty($kategori)) {
            $kategori = [
                'alam' => 'Wisata Alam',
                'budaya' => 'Wisata Budaya',
                'buatan' => 'Wisata Buatan',
                'minat' => 'Wisata Minat Khusus'
            ];
        }
        
        // Data lokasi populer dummy (hardcoded sementara)
        $lokasiPopuler = [
            'hotel' => [
                ['value' => 'hotel-grand-mercure-yogyakarta', 'nama' => 'Hotel Grand Mercure Yogyakarta', 'alamat' => 'Jl. Jend. Sudirman No.9, Yogyakarta', 'lat' => -7.7833, 'lng' => 110.3690],
                ['value' => 'hotel-phoenix-yogyakarta', 'nama' => 'Hotel Phoenix Yogyakarta', 'alamat' => 'Jl. Jend. Sudirman No.9, Yogyakarta', 'lat' => -7.7829, 'lng' => 110.3687],
                ['value' => 'hotel-santika-premier-yogyakarta', 'nama' => 'Hotel Santika Premier Yogyakarta', 'alamat' => 'Jl. Jend. Sudirman No.2, Yogyakarta', 'lat' => -7.7850, 'lng' => 110.3710],
                ['value' => 'hotel-solo', 'nama' => 'Hotel Solo', 'alamat' => 'Jl. Slamet Riyadi No.324, Solo', 'lat' => -7.5667, 'lng' => 110.8167],
                ['value' => 'hotel-kusuma-sahid-solo', 'nama' => 'Hotel Kusuma Sahid Solo', 'alamat' => 'Jl. Sugiyopranoto No.20, Solo', 'lat' => -7.5633, 'lng' => 110.8217],
            ],
            'landmark' => [
                ['value' => 'malioboro', 'nama' => 'Malioboro', 'alamat' => 'Jl. Malioboro, Yogyakarta', 'lat' => -7.7956, 'lng' => 110.3694],
                ['value' => 'stasiun-tugu-yogyakarta', 'nama' => 'Stasiun Tugu Yogyakarta', 'alamat' => 'Jl. Mangkubumi No.1, Yogyakarta', 'lat' => -7.7894, 'lng' => 110.3633],
                ['value' => 'bandara-adisucipto', 'nama' => 'Bandara Adisucipto Yogyakarta', 'alamat' => 'Jl. Solo, Maguwoharjo, Yogyakarta', 'lat' => -7.7882, 'lng' => 110.4319],
                ['value' => 'stasiun-purwosari-solo', 'nama' => 'Stasiun Purwosari Solo', 'alamat' => 'Jl. Slamet Riyadi, Solo', 'lat' => -7.5717, 'lng' => 110.8017],
                ['value' => 'bandara-adisumarmo-solo', 'nama' => 'Bandara Adisumarmo Solo', 'alamat' => 'Jl. Raya Solo - Yogyakarta, Solo', 'lat' => -7.5161, 'lng' => 110.7572],
            ],
            'wisata' => [
                ['value' => 'keraton-yogyakarta', 'nama' => 'Keraton Yogyakarta', 'alamat' => 'Jl. Rotowijayan, Yogyakarta', 'lat' => -7.8052, 'lng' => 110.3647],
                ['value' => 'candi-prambanan', 'nama' => 'Candi Prambanan', 'alamat' => 'Jl. Raya Solo - Yogyakarta, Prambanan', 'lat' => -7.7520, 'lng' => 110.4915],
                ['value' => 'keraton-solo', 'nama' => 'Keraton Solo', 'alamat' => 'Jl. Slamet Riyadi, Solo', 'lat' => -7.5747, 'lng' => 110.8247],
                ['value' => 'taman-sari', 'nama' => 'Taman Sari Yogyakarta', 'alamat' => 'Jl. Taman, Yogyakarta', 'lat' => -7.8100, 'lng' => 110.3589],
            ],
            'mall' => [
                ['value' => 'malioboro-mall', 'nama' => 'Malioboro Mall', 'alamat' => 'Jl. Malioboro No.52-58, Yogyakarta', 'lat' => -7.7931, 'lng' => 110.3647],
                ['value' => 'plaza-ambarrukmo', 'nama' => 'Plaza Ambarrukmo', 'alamat' => 'Jl. Laksda Adisucipto No.81, Yogyakarta', 'lat' => -7.7831, 'lng' => 110.4075],
                ['value' => 'solo-grand-mall', 'nama' => 'Solo Grand Mall', 'alamat' => 'Jl. Slamet Riyadi, Solo', 'lat' => -7.5661, 'lng' => 110.8189],
            ]
        ];

        return view('wisatawan.itinerary.create', compact('kategori', 'lokasiPopuler'));
    }

    /**
     * Show the form for editing an itinerary.
     */
    public function edit($id)
    {
        $itinerary = Itinerary::with([
            'itineraryDestinasi.destinasi',
            'kategori'
        ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        // Ambil kategori dari database
        $kategoriList = Kategori::all();
        $kategori = [];
        foreach ($kategoriList as $kat) {
            $kode = strtolower(str_replace(' ', '', $kat->nama_kategori));
            if (strpos($kode, 'alam') !== false) $kode = 'alam';
            elseif (strpos($kode, 'budaya') !== false) $kode = 'budaya';
            elseif (strpos($kode, 'buatan') !== false) $kode = 'buatan';
            elseif (strpos($kode, 'minat') !== false) $kode = 'minat';
            else $kode = 'alam';
            
            $kategori[$kode] = $kat->nama_kategori;
        }
        
        if (empty($kategori)) {
            $kategori = [
                'alam' => 'Wisata Alam',
                'budaya' => 'Wisata Budaya',
                'buatan' => 'Wisata Buatan',
                'minat' => 'Wisata Minat Khusus'
            ];
        }
        
        // Data lokasi populer dummy (sama seperti create)
        $lokasiPopuler = [
            'hotel' => [
                ['value' => 'hotel-grand-mercure-yogyakarta', 'nama' => 'Hotel Grand Mercure Yogyakarta', 'alamat' => 'Jl. Jend. Sudirman No.9, Yogyakarta', 'lat' => -7.7833, 'lng' => 110.3690],
                ['value' => 'hotel-phoenix-yogyakarta', 'nama' => 'Hotel Phoenix Yogyakarta', 'alamat' => 'Jl. Jend. Sudirman No.9, Yogyakarta', 'lat' => -7.7829, 'lng' => 110.3687],
                ['value' => 'hotel-santika-premier-yogyakarta', 'nama' => 'Hotel Santika Premier Yogyakarta', 'alamat' => 'Jl. Jend. Sudirman No.2, Yogyakarta', 'lat' => -7.7850, 'lng' => 110.3710],
                ['value' => 'hotel-solo', 'nama' => 'Hotel Solo', 'alamat' => 'Jl. Slamet Riyadi No.324, Solo', 'lat' => -7.5667, 'lng' => 110.8167],
                ['value' => 'hotel-kusuma-sahid-solo', 'nama' => 'Hotel Kusuma Sahid Solo', 'alamat' => 'Jl. Sugiyopranoto No.20, Solo', 'lat' => -7.5633, 'lng' => 110.8217],
            ],
            'landmark' => [
                ['value' => 'malioboro', 'nama' => 'Malioboro', 'alamat' => 'Jl. Malioboro, Yogyakarta', 'lat' => -7.7956, 'lng' => 110.3694],
                ['value' => 'stasiun-tugu-yogyakarta', 'nama' => 'Stasiun Tugu Yogyakarta', 'alamat' => 'Jl. Mangkubumi No.1, Yogyakarta', 'lat' => -7.7894, 'lng' => 110.3633],
                ['value' => 'bandara-adisucipto', 'nama' => 'Bandara Adisucipto Yogyakarta', 'alamat' => 'Jl. Solo, Maguwoharjo, Yogyakarta', 'lat' => -7.7882, 'lng' => 110.4319],
                ['value' => 'stasiun-purwosari-solo', 'nama' => 'Stasiun Purwosari Solo', 'alamat' => 'Jl. Slamet Riyadi, Solo', 'lat' => -7.5717, 'lng' => 110.8017],
                ['value' => 'bandara-adisumarmo-solo', 'nama' => 'Bandara Adisumarmo Solo', 'alamat' => 'Jl. Raya Solo - Yogyakarta, Solo', 'lat' => -7.5161, 'lng' => 110.7572],
            ],
            'wisata' => [
                ['value' => 'keraton-yogyakarta', 'nama' => 'Keraton Yogyakarta', 'alamat' => 'Jl. Rotowijayan, Yogyakarta', 'lat' => -7.8052, 'lng' => 110.3647],
                ['value' => 'candi-prambanan', 'nama' => 'Candi Prambanan', 'alamat' => 'Jl. Raya Solo - Yogyakarta, Prambanan', 'lat' => -7.7520, 'lng' => 110.4915],
                ['value' => 'keraton-solo', 'nama' => 'Keraton Solo', 'alamat' => 'Jl. Slamet Riyadi, Solo', 'lat' => -7.5747, 'lng' => 110.8247],
                ['value' => 'taman-sari', 'nama' => 'Taman Sari Yogyakarta', 'alamat' => 'Jl. Taman, Yogyakarta', 'lat' => -7.8100, 'lng' => 110.3589],
            ],
            'mall' => [
                ['value' => 'malioboro-mall', 'nama' => 'Malioboro Mall', 'alamat' => 'Jl. Malioboro No.52-58, Yogyakarta', 'lat' => -7.7931, 'lng' => 110.3647],
                ['value' => 'plaza-ambarrukmo', 'nama' => 'Plaza Ambarrukmo', 'alamat' => 'Jl. Laksda Adisucipto No.81, Yogyakarta', 'lat' => -7.7831, 'lng' => 110.4075],
                ['value' => 'solo-grand-mall', 'nama' => 'Solo Grand Mall', 'alamat' => 'Jl. Slamet Riyadi, Solo', 'lat' => -7.5661, 'lng' => 110.8189],
            ]
        ];
        
        // Format data itinerary untuk pre-fill form
        // Parse kategori dari JSON
        $kategoriSelected = [];
        if ($itinerary->kategori) {
            $kategoriArray = json_decode($itinerary->kategori, true);
            if (is_array($kategoriArray)) {
                $kategoriSelected = $kategoriArray;
            }
        }
        
        // Format destinasi untuk pre-fill (mirip dengan format saat generate)
        $itineraryData = [];
        $destinasiPerHari = $itinerary->itineraryDestinasi->groupBy('no_hari');
        
        $tanggal = new \DateTime($itinerary->tgl_keberangkatan);
        
        foreach ($destinasiPerHari as $hari => $destinasiList) {
            $hariData = [
                'hari' => $hari,
                'tanggal' => $tanggal->format('Y-m-d'),
                'tanggal_formatted' => $this->formatTanggalIndonesia($tanggal),
                'destinasi' => []
            ];
            
            foreach ($destinasiList->sortBy('order') as $itineraryDest) {
                $dest = $itineraryDest->destinasi;
                $hariData['destinasi'][] = [
                    'id' => $dest->id,
                    'nama' => $dest->nama,
                    'kategori' => $dest->kategori,
                    'rating' => (float)$dest->rating,
                    'biaya' => (float)$dest->biaya,
                    'alamat' => $dest->alamat,
                    'lat' => (float)$dest->latitude,
                    'lng' => (float)$dest->longitude,
                    'waktu_mulai' => substr($itineraryDest->waktu_tiba, 0, 5),
                    'waktu_selesai' => substr($itineraryDest->waktu_selesai, 0, 5),
                    'durasi' => $itineraryDest->durasi,
                    'jarak_dari_sebelumnya' => (float)$itineraryDest->jarak_dari_sebelumnya,
                    'waktu_tempuh' => 0
                ];
            }
            
            $itineraryData[] = $hariData;
            $tanggal->modify('+1 day');
        }
        
        // Format config untuk pre-fill
        $itineraryConfig = [
            'tanggal_keberangkatan' => $itinerary->tgl_keberangkatan->format('Y-m-d'), // Format untuk input date
            'jumlah_hari' => $itinerary->total_hari,
            'waktu_mulai' => substr($itinerary->waktu_mulai, 0, 5),
            'lokasi_wisata' => $itinerary->lokasi,
            'jenis_jalur' => $itinerary->jenis_jalur,
            'min_rating' => $itinerary->min_rating,
            'start_lat' => $itinerary->start_location_lat,
            'start_lng' => $itinerary->start_location_lng,
            'kategori' => $kategoriSelected
        ];
        
        // Tentukan lokasi awal type (current atau popular)
        // Cek apakah koordinat cocok dengan lokasi populer
        $lokasiAwalType = 'current';
        $lokasiPopulerValue = null;
        
        if ($itinerary->start_location_lat && $itinerary->start_location_lng) {
            // Cek apakah cocok dengan lokasi populer
            foreach ($lokasiPopuler as $group => $lokasiList) {
                foreach ($lokasiList as $lokasi) {
                    if (abs($lokasi['lat'] - $itinerary->start_location_lat) < 0.01 &&
                        abs($lokasi['lng'] - $itinerary->start_location_lng) < 0.01) {
                        $lokasiAwalType = 'popular';
                        $lokasiPopulerValue = $lokasi['value'];
                        break 2;
                    }
                }
            }
        }
        
        $isEditMode = true;
        
        return view('wisatawan.itinerary.create', compact('itinerary', 'kategori', 'lokasiPopuler', 'itineraryData', 'itineraryConfig', 'kategoriSelected', 'isEditMode', 'lokasiAwalType', 'lokasiPopulerValue'));
    }

    /**
     * Get destinations (AJAX endpoint)
     */
    public function getDestinations(Request $request)
    {
        $query = Destinasi::query();
        
        // Filter by lokasi
        if ($request->lokasi) {
            $query->where('lokasi', $request->lokasi);
        }
        
        // Filter by kategori (multiple)
        // Kategori di database adalah: 'Wisata Alam', 'Wisata Buatan', 'Wisata Budaya', 'Wisata Minat Khusus'
        // Kode dari form: 'alam', 'buatan', 'budaya', 'minat'
        if ($request->kategori) {
            $kategoriArray = is_array($request->kategori) ? $request->kategori : explode(',', $request->kategori);
            if (!empty($kategoriArray)) {
                // Map kode ke nama kategori lengkap
                $kategoriMap = [
                    'alam' => 'Wisata Alam',
                    'buatan' => 'Wisata Buatan',
                    'budaya' => 'Wisata Budaya',
                    'minat' => 'Wisata Minat Khusus'
                ];
                $kategoriNama = array_map(function($kode) use ($kategoriMap) {
                    return $kategoriMap[$kode] ?? null;
                }, $kategoriArray);
                $kategoriNama = array_filter($kategoriNama); // Hapus null
                
                if (!empty($kategoriNama)) {
                    $query->whereIn('kategori', $kategoriNama);
                }
            }
        }
        
        // Filter by rating
        if ($request->min_rating) {
            $query->where('rating', '>=', $request->min_rating);
        }
        
        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sort
        $sortBy = $request->sort ?? 'default';
        switch ($sortBy) {
            case 'name-asc': $query->orderBy('nama', 'asc'); break;
            case 'name-desc': $query->orderBy('nama', 'desc'); break;
            case 'rating-desc': $query->orderBy('rating', 'desc'); break;
            case 'rating-asc': $query->orderBy('rating', 'asc'); break;
            case 'price-asc': $query->orderBy('biaya', 'asc'); break;
            case 'price-desc': $query->orderBy('biaya', 'desc'); break;
            default: $query->orderBy('nama', 'asc');
        }
        
        // Pagination
        $perPage = $request->per_page ?? 24;
        $destinations = $query->paginate($perPage);
        
        return response()->json([
            'data' => $destinations->items(),
            'current_page' => $destinations->currentPage(),
            'last_page' => $destinations->lastPage(),
            'total' => $destinations->total(),
            'per_page' => $destinations->perPage()
        ]);
    }

    /**
     * Generate itinerary (AJAX endpoint) - SEMUA LOGIKA DI SINI
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'tanggal_keberangkatan' => 'required|date|after_or_equal:today',
            'jumlah_hari' => 'required|integer|min:1|max:7',
            'waktu_mulai' => 'required|date_format:H:i',
            'lokasi_wisata' => 'required|in:yogyakarta,solo',
            'min_rating' => 'nullable|numeric|min:0|max:5',
            'jenis_jalur' => 'required|in:tol,non_tol',
            'kategori' => 'required|array|min:1',
            'kategori.*' => 'in:alam,budaya,buatan,minat',
            'start_lat' => 'required|numeric',
            'start_lng' => 'required|numeric',
            'selected_destinasi_ids' => 'nullable|array',
            'selected_destinasi_ids.*' => 'integer|exists:destinasi,id'
        ]);
        
        // 1. Ambil destinasi otomatis
        // Map kode kategori ke nama kategori lengkap
        $kategoriMap = [
            'alam' => 'Wisata Alam',
            'buatan' => 'Wisata Buatan',
            'budaya' => 'Wisata Budaya',
            'minat' => 'Wisata Minat Khusus'
        ];
        $kategoriNama = array_map(function($kode) use ($kategoriMap) {
            return $kategoriMap[$kode] ?? null;
        }, $validated['kategori']);
        $kategoriNama = array_filter($kategoriNama); // Hapus null
        
        $destinasiOtomatis = Destinasi::whereIn('kategori', $kategoriNama)
            ->where('lokasi', $validated['lokasi_wisata'])
            ->when($validated['min_rating'], function($q) use ($validated) {
                $q->where('rating', '>=', $validated['min_rating']);
            })
            ->get()
            ->map(function($dest) {
                return [
                    'id' => $dest->id,
                    'nama' => $dest->nama,
                    'kategori' => $dest->kategori,
                    'rating' => (float)$dest->rating,
                    'biaya' => (float)$dest->biaya,
                    'alamat' => $dest->alamat,
                    'lat' => (float)$dest->latitude,
                    'lng' => (float)$dest->longitude,
                ];
            })
            ->toArray();
        
        // 2. Ambil destinasi manual
        $destinasiManual = collect();
        if (!empty($validated['selected_destinasi_ids'])) {
            $destinasiManual = Destinasi::whereIn('id', $validated['selected_destinasi_ids'])
                ->get()
                ->map(function($dest) {
                    return [
                        'id' => $dest->id,
                        'nama' => $dest->nama,
                        'kategori' => $dest->kategori,
                        'rating' => (float)$dest->rating,
                        'biaya' => (float)$dest->biaya,
                        'alamat' => $dest->alamat,
                        'lat' => (float)$dest->latitude,
                        'lng' => (float)$dest->longitude,
                    ];
                });
        }
        
        // 3. Gabungkan dan hapus duplikat
        $allDestinasi = collect($destinasiOtomatis)
            ->merge($destinasiManual)
            ->unique('id')
            ->values()
            ->toArray();
        
        // 4. Optimasi rute menggunakan Nearest Neighbor
        $optimizedDestinasi = $this->optimizeRoute(
            $validated['start_lat'],
            $validated['start_lng'],
            $allDestinasi
        );
        
        // 5. Bagi destinasi per hari (minimal 3 per hari)
        $destinasiPerHari = $this->distributeDestinations(
            $optimizedDestinasi,
            $validated['jumlah_hari']
        );
        
        // 6. Hitung jadwal dengan waktu tempuh
        $tanggal = new \DateTime($validated['tanggal_keberangkatan']);
        $itinerary = $this->calculateSchedule(
            $destinasiPerHari,
            $validated['waktu_mulai'],
            $tanggal,
            $validated['start_lat'],
            $validated['start_lng']
        );
        
        return response()->json([
            'success' => true,
            'itinerary' => $itinerary,
            'config' => $validated
        ]);
    }

    /**
     * Re-optimize itinerary (AJAX endpoint) - untuk menambah/mengubah destinasi
     */
    public function reoptimize(Request $request)
    {
        $validated = $request->validate([
            'tanggal_keberangkatan' => 'required|date|after_or_equal:today',
            'jumlah_hari' => 'required|integer|min:1|max:7',
            'waktu_mulai' => 'required|date_format:H:i',
            'lokasi_wisata' => 'required|in:yogyakarta,solo',
            'jenis_jalur' => 'required|in:tol,non_tol',
            'start_lat' => 'required|numeric',
            'start_lng' => 'required|numeric',
            'destinasi_ids' => 'required|array|min:1',
            'destinasi_ids.*' => 'integer|exists:destinasi,id',
            'destinasi_durasi' => 'nullable|array', // [destinasi_id => durasi]
            'destinasi_durasi.*' => 'integer|min:60|max:480'
        ]);
        
        // Ambil semua destinasi berdasarkan IDs
        $destinasi = Destinasi::whereIn('id', $validated['destinasi_ids'])
            ->get()
            ->map(function($dest) use ($validated) {
                $durasi = $validated['destinasi_durasi'][$dest->id] ?? 120;
                return [
                    'id' => $dest->id,
                    'nama' => $dest->nama,
                    'kategori' => $dest->kategori,
                    'rating' => (float)$dest->rating,
                    'biaya' => (float)$dest->biaya,
                    'alamat' => $dest->alamat,
                    'lat' => (float)$dest->latitude,
                    'lng' => (float)$dest->longitude,
                    'durasi' => $durasi
                ];
            })
            ->toArray();
        
        // Optimasi rute menggunakan Nearest Neighbor
        $optimizedDestinasi = $this->optimizeRoute(
            $validated['start_lat'],
            $validated['start_lng'],
            $destinasi
        );
        
        // Bagi destinasi per hari (minimal 3 per hari)
        $destinasiPerHari = $this->distributeDestinations(
            $optimizedDestinasi,
            $validated['jumlah_hari']
        );
        
        // Hitung jadwal dengan waktu tempuh
        $tanggal = new \DateTime($validated['tanggal_keberangkatan']);
        $itinerary = $this->calculateSchedule(
            $destinasiPerHari,
            $validated['waktu_mulai'],
            $tanggal,
            $validated['start_lat'],
            $validated['start_lng']
        );
        
        return response()->json([
            'success' => true,
            'itinerary' => $itinerary,
            'config' => $validated
        ]);
    }

    /**
     * Get holiday info (AJAX endpoint)
     */
    public function getHolidayInfo(Request $request)
    {
        $request->validate(['tanggal' => 'required|date']);
        
        $tanggal = new \DateTime($request->tanggal);
        
        // Cek dari database
        $isHoliday = LiburNasional::where('tanggal', $tanggal->format('Y-m-d'))->exists();
        $isWeekend = $this->isWeekend($tanggal);
        $isHighSeason = $isWeekend || $isHoliday;
        $kecepatan = $isHighSeason ? 120 : 140;
        
        // Format tanggal Indonesia
        $tanggalFormatted = $this->formatTanggalIndonesia($tanggal);
        
        // Tentukan jenis hari
        $jenisHari = '';
        if ($isHoliday) {
            $libur = LiburNasional::where('tanggal', $tanggal->format('Y-m-d'))->first();
            $jenisHari = $libur ? $libur->nama : 'Hari Libur Nasional';
        } elseif ($isWeekend) {
            $dayName = $tanggal->format('l');
            $jenisHari = $dayName === 'Sunday' ? 'Minggu' : 'Sabtu';
        } else {
            $jenisHari = 'Hari Biasa (Weekday)';
        }
        
        return response()->json([
            'tanggal_formatted' => $tanggalFormatted,
            'jenis_hari' => $jenisHari,
            'is_high_season' => $isHighSeason,
            'kecepatan' => $kecepatan
        ]);
    }

    /**
     * Get restaurant recommendations for a specific day (AJAX endpoint)
     */
    public function getRestaurantRecommendations(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|integer|min:1',
            'lokasi_wisata' => 'required|in:yogyakarta,solo',
            'destinasi_lat' => 'nullable|numeric',
            'destinasi_lng' => 'nullable|numeric',
            'limit' => 'nullable|integer|min:1|max:20'
        ]);

        $hari = $validated['hari'];
        $lokasi = $validated['lokasi_wisata'];
        $limit = $validated['limit'] ?? 10;
        
        // Query restaurant berdasarkan lokasi
        $query = Restaurant::where('lokasi', $lokasi);
        
        // Jika ada koordinat destinasi, urutkan berdasarkan jarak terdekat
        if (!empty($validated['destinasi_lat']) && !empty($validated['destinasi_lng'])) {
            $lat = $validated['destinasi_lat'];
            $lng = $validated['destinasi_lng'];
            
            // Hitung jarak untuk setiap restaurant menggunakan Haversine
            $restaurants = $query->get()->map(function($restaurant) use ($lat, $lng) {
                $jarak = $this->haversineDistance(
                    $lat,
                    $lng,
                    $restaurant->latitude,
                    $restaurant->longitude
                );
                return [
                    'id' => $restaurant->id,
                    'nama' => $restaurant->nama,
                    'alamat' => $restaurant->alamat,
                    'rating' => (float)$restaurant->rating,
                    'deskripsi' => $restaurant->deskripsi,
                    'latitude' => (float)$restaurant->latitude,
                    'longitude' => (float)$restaurant->longitude,
                    'jarak' => round($jarak, 2)
                ];
            })->sortBy('jarak')->take($limit)->values();
        } else {
            // Jika tidak ada koordinat, urutkan berdasarkan rating
            $restaurants = $query->orderBy('rating', 'desc')
                ->take($limit)
                ->get()
                ->map(function($restaurant) {
                    return [
                        'id' => $restaurant->id,
                        'nama' => $restaurant->nama,
                        'alamat' => $restaurant->alamat,
                        'rating' => (float)$restaurant->rating,
                        'deskripsi' => $restaurant->deskripsi,
                        'latitude' => (float)$restaurant->latitude,
                        'longitude' => (float)$restaurant->longitude,
                        'jarak' => null
                    ];
                });
        }
        
        return response()->json([
            'success' => true,
            'hari' => $hari,
            'data' => $restaurants
        ]);
    }

    /**
     * Get akomodasi recommendations for a specific day (AJAX endpoint)
     */
    public function getAkomodasiRecommendations(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|integer|min:1',
            'lokasi_wisata' => 'required|in:yogyakarta,solo',
            'destinasi_lat' => 'nullable|numeric',
            'destinasi_lng' => 'nullable|numeric',
            'limit' => 'nullable|integer|min:1|max:20'
        ]);

        $hari = $validated['hari'];
        $lokasi = $validated['lokasi_wisata'];
        $limit = $validated['limit'] ?? 10;
        
        // Query akomodasi berdasarkan lokasi
        $query = Akomodasi::where('lokasi', $lokasi);
        
        // Jika ada koordinat destinasi, urutkan berdasarkan jarak terdekat
        if (!empty($validated['destinasi_lat']) && !empty($validated['destinasi_lng'])) {
            $lat = $validated['destinasi_lat'];
            $lng = $validated['destinasi_lng'];
            
            // Hitung jarak untuk setiap akomodasi menggunakan Haversine
            $akomodasi = $query->get()->map(function($akom) use ($lat, $lng) {
                $jarak = $this->haversineDistance(
                    $lat,
                    $lng,
                    $akom->latitude,
                    $akom->longitude
                );
                return [
                    'id' => $akom->id,
                    'nama' => $akom->nama,
                    'alamat' => $akom->alamat,
                    'rating' => (float)$akom->rating,
                    'deskripsi' => $akom->deskripsi,
                    'latitude' => (float)$akom->latitude,
                    'longitude' => (float)$akom->longitude,
                    'jarak' => round($jarak, 2)
                ];
            })->sortBy('jarak')->take($limit)->values();
        } else {
            // Jika tidak ada koordinat, urutkan berdasarkan rating
            $akomodasi = $query->orderBy('rating', 'desc')
                ->take($limit)
                ->get()
                ->map(function($akom) {
                    return [
                        'id' => $akom->id,
                        'nama' => $akom->nama,
                        'alamat' => $akom->alamat,
                        'rating' => (float)$akom->rating,
                        'deskripsi' => $akom->deskripsi,
                        'latitude' => (float)$akom->latitude,
                        'longitude' => (float)$akom->longitude,
                        'jarak' => null
                    ];
                });
        }
        
        return response()->json([
            'success' => true,
            'hari' => $hari,
            'data' => $akomodasi
        ]);
    }

    /**
     * Store itinerary
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'itinerary_data' => 'required|json',
            'itinerary_config' => 'required|json',
            'itinerary_id' => 'nullable|integer|exists:itinerary,id'
        ]);
        
        // Parse JSON data
        $itineraryData = json_decode($request->itinerary_data, true);
        $itineraryConfig = json_decode($request->itinerary_config, true);
        
        if (!$itineraryData || !$itineraryConfig) {
            return back()->withErrors(['error' => 'Data itinerary tidak valid']);
        }
        
        // Simpan kategori sebagai JSON string (sesuai struktur tabel)
        // Pastikan kategori tidak null, gunakan empty array jika kosong
        $kategoriArray = !empty($itineraryConfig['kategori']) && is_array($itineraryConfig['kategori']) 
            ? $itineraryConfig['kategori'] 
            : [];
        // Jika kategori kosong, set null (karena kolom nullable)
        $kategoriJson = !empty($kategoriArray) ? json_encode($kategoriArray) : null;
        
        // Format waktu_mulai ke format time (HH:MM:SS)
        $waktuMulai = $itineraryConfig['waktu_mulai'];
        if (strlen($waktuMulai) == 5) { // Format HH:MM
            $waktuMulai .= ':00'; // Tambah detik menjadi HH:MM:SS
        }
        
        // Jika ada itinerary_id, berarti update
        if (!empty($validated['itinerary_id'])) {
            $itinerary = Itinerary::where('id', $validated['itinerary_id'])
                ->where('user_id', auth()->id())
                ->firstOrFail();
            
            // Update itinerary
            $updateData = [
                'nama' => $validated['nama'],
                'tgl_keberangkatan' => $itineraryConfig['tanggal_keberangkatan'],
                'total_hari' => $itineraryConfig['jumlah_hari'],
                'waktu_mulai' => $waktuMulai,
                'lokasi' => $itineraryConfig['lokasi_wisata'],
                'min_rating' => $itineraryConfig['min_rating'] ?? 0,
                'start_location_lat' => $itineraryConfig['start_lat'],
                'start_location_lng' => $itineraryConfig['start_lng'],
                'jenis_jalur' => $itineraryConfig['jenis_jalur'] ?? 'tol',
            ];
            
            // Hanya update kategori jika ada nilai
            if ($kategoriJson !== null) {
                $updateData['kategori'] = $kategoriJson;
            }
            
            $itinerary->update($updateData);
            
            // Hapus destinasi lama
            ItineraryDestinasi::where('itinerary_id', $itinerary->id)->delete();
            
            $message = 'Itinerary berhasil diperbarui!';
        } else {
            // Create new itinerary
            $createData = [
                'user_id' => auth()->id(),
                'nama' => $validated['nama'],
                'tgl_keberangkatan' => $itineraryConfig['tanggal_keberangkatan'],
                'total_hari' => $itineraryConfig['jumlah_hari'],
                'waktu_mulai' => $waktuMulai,
                'lokasi' => $itineraryConfig['lokasi_wisata'],
                'min_rating' => $itineraryConfig['min_rating'] ?? 0,
                'start_location_lat' => $itineraryConfig['start_lat'],
                'start_location_lng' => $itineraryConfig['start_lng'],
                'jenis_jalur' => $itineraryConfig['jenis_jalur'] ?? 'tol',
            ];
            
            // Set kategori (bisa null jika kosong, karena kolom nullable)
            $createData['kategori'] = $kategoriJson;
            
            $itinerary = Itinerary::create($createData);
            
            $message = 'Itinerary berhasil disimpan!';
        }
        
        // Simpan kategori ke pivot table (relasi many-to-many)
        if (!empty($itineraryConfig['kategori'])) {
            $kategoriMap = [
                'alam' => 'Wisata Alam',
                'buatan' => 'Wisata Buatan',
                'budaya' => 'Wisata Budaya',
                'minat' => 'Wisata Minat Khusus'
            ];
            $kategoriNama = array_map(function($kode) use ($kategoriMap) {
                return $kategoriMap[$kode] ?? null;
            }, $itineraryConfig['kategori']);
            $kategoriNama = array_filter($kategoriNama);
            
            if (!empty($kategoriNama)) {
                $kategoriIds = Kategori::whereIn('nama_kategori', $kategoriNama)->pluck('id');
                $itinerary->kategori()->sync($kategoriIds);
            }
        }
        
        // Simpan destinasi itinerary
        foreach ($itineraryData as $day) {
            foreach ($day['destinasi'] as $index => $dest) {
                ItineraryDestinasi::create([
                    'itinerary_id' => $itinerary->id,
                    'destinasi_id' => $dest['id'],
                    'no_hari' => $day['hari'],
                    'order' => $index + 1,
                    'waktu_tiba' => $dest['waktu_mulai'] . ':00', // Format time: HH:MM:SS
                    'waktu_selesai' => $dest['waktu_selesai'] . ':00', // Format time: HH:MM:SS
                    'durasi' => $dest['durasi'],
                    'jarak_dari_sebelumnya' => $dest['jarak_dari_sebelumnya'],
                    'total_jarak' => $dest['jarak_dari_sebelumnya']
                ]);
            }
        }
        
        return redirect()->route('wisatawan.itinerary.index')
            ->with('success', $message);
    }

    /**
     * Display a listing of the user's itineraries.
     */
    public function index()
    {
        $itineraries = Itinerary::where('user_id', auth()->id())
            ->with('itineraryDestinasi.destinasi')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('wisatawan.itinerary.riwayat-index', compact('itineraries'));
    }

    /**
     * Display the specified itinerary.
     */
    public function show($id)
    {
        $itinerary = Itinerary::with([
            'itineraryDestinasi.destinasi',
            'kategori'
        ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        // Format data untuk ditampilkan (mirip dengan format saat generate)
        $itineraryData = [];
        $destinasiPerHari = $itinerary->itineraryDestinasi->groupBy('no_hari');
        
        $tanggal = new \DateTime($itinerary->tgl_keberangkatan);
        
        $lastDestinasiLat = $itinerary->start_location_lat;
        $lastDestinasiLng = $itinerary->start_location_lng;
        
        foreach ($destinasiPerHari as $hari => $destinasiList) {
            $hariData = [
                'hari' => $hari,
                'tanggal' => $tanggal->format('Y-m-d'),
                'tanggal_formatted' => $this->formatTanggalIndonesia($tanggal),
                'destinasi' => []
            ];
            
            foreach ($destinasiList->sortBy('order') as $index => $itineraryDest) {
                $dest = $itineraryDest->destinasi;
                $jarak = (float)$itineraryDest->jarak_dari_sebelumnya;
                
                // Hitung waktu tempuh berdasarkan jarak dan tanggal
                $waktuTempuh = 0;
                if ($jarak > 0) {
                    // Jika destinasi pertama hari pertama dan ada lokasi awal
                    if ($index === 0 && $hari === 1 && $lastDestinasiLat && $lastDestinasiLng) {
                        $waktuTempuh = $this->hitungWaktuTempuhMenit($jarak, $tanggal);
                    }
                    // Jika destinasi pertama hari berikutnya
                    elseif ($index === 0 && $hari > 1 && $lastDestinasiLat && $lastDestinasiLng) {
                        $waktuTempuh = $this->hitungWaktuTempuhMenit($jarak, $tanggal);
                    }
                    // Destinasi setelah destinasi pertama
                    elseif ($index > 0) {
                        $waktuTempuh = $this->hitungWaktuTempuhMenit($jarak, $tanggal);
                    }
                }
                
                $hariData['destinasi'][] = [
                    'id' => $dest->id,
                    'nama' => $dest->nama,
                    'kategori' => $dest->kategori,
                    'rating' => (float)$dest->rating,
                    'biaya' => (float)$dest->biaya,
                    'alamat' => $dest->alamat,
                    'lat' => (float)$dest->latitude,
                    'lng' => (float)$dest->longitude,
                    'waktu_mulai' => substr($itineraryDest->waktu_tiba, 0, 5), // HH:MM
                    'waktu_selesai' => substr($itineraryDest->waktu_selesai, 0, 5), // HH:MM
                    'durasi' => $itineraryDest->durasi,
                    'jarak_dari_sebelumnya' => $jarak,
                    'waktu_tempuh' => $waktuTempuh
                ];
                
                // Simpan koordinat destinasi terakhir untuk hari berikutnya
                $lastDestinasiLat = (float)$dest->latitude;
                $lastDestinasiLng = (float)$dest->longitude;
            }
            
            $itineraryData[] = $hariData;
            $tanggal->modify('+1 day');
        }
        
        // Parse kategori dari JSON
        $kategoriSelected = [];
        if ($itinerary->kategori) {
            $kategoriArray = json_decode($itinerary->kategori, true);
            if (is_array($kategoriArray)) {
                $kategoriSelected = $kategoriArray;
            }
        }
        
        return view('wisatawan.itinerary.riwayat-show', compact('itinerary', 'itineraryData', 'kategoriSelected'));
    }

    // ========== HELPER METHODS ==========

    /**
     * Optimasi rute menggunakan algoritma Nearest Neighbor
     */
    private function optimizeRoute($startLat, $startLng, $destinasi)
    {
        if (empty($destinasi)) return [];
        
        $visited = [];
        $route = [];
        $currentLat = $startLat;
        $currentLng = $startLng;
        
        while (count($route) < count($destinasi)) {
            $nearest = null;
            $nearestDistance = PHP_INT_MAX;
            $nearestIndex = -1;
            
            foreach ($destinasi as $index => $dest) {
                if (in_array($index, $visited)) continue;
                
                $distance = $this->haversineDistance(
                    $currentLat,
                    $currentLng,
                    $dest['lat'],
                    $dest['lng']
                );
                
                if ($distance < $nearestDistance) {
                    $nearestDistance = $distance;
                    $nearest = $dest;
                    $nearestIndex = $index;
                }
            }
            
            if ($nearest) {
                $nearest['distance'] = $nearestDistance;
                $route[] = $nearest;
                $visited[] = $nearestIndex;
                $currentLat = $nearest['lat'];
                $currentLng = $nearest['lng'];
            } else {
                break;
            }
        }
        
        return $route;
    }

    /**
     * Hitung jarak menggunakan formula Haversine
     */
    private function haversineDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }

    /**
     * Bagi destinasi per hari (minimal 3 per hari)
     */
    private function distributeDestinations($destinasi, $jumlahHari)
    {
        $minPerHari = 3;
        $total = count($destinasi);
        $destinasiPerHari = [];
        
        if ($total >= $jumlahHari * $minPerHari) {
            // Cukup untuk minimal 3 per hari
            $perHari = floor($total / $jumlahHari);
            $sisa = $total % $jumlahHari;
            
            $index = 0;
            for ($hari = 1; $hari <= $jumlahHari; $hari++) {
                $jumlah = $perHari + ($hari <= $sisa ? 1 : 0);
                $jumlah = max($minPerHari, $jumlah); // Minimal 3
                $destinasiPerHari[$hari] = array_slice($destinasi, $index, $jumlah);
                $index += $jumlah;
            }
        } else {
            // Tidak cukup, bagi rata
            $perHari = ceil($total / $jumlahHari);
            $index = 0;
            for ($hari = 1; $hari <= $jumlahHari; $hari++) {
                $sisaDestinasi = $total - $index;
                $sisaHari = $jumlahHari - $hari + 1;
                $jumlah = min($perHari, $sisaDestinasi);
                if ($sisaDestinasi > 0) {
                    $destinasiPerHari[$hari] = array_slice($destinasi, $index, $jumlah);
                    $index += $jumlah;
                } else {
                    $destinasiPerHari[$hari] = [];
                }
            }
        }
        
        return $destinasiPerHari;
    }

    /**
     * Hitung jadwal waktu untuk setiap destinasi
     */
    private function calculateSchedule($destinasiPerHari, $waktuMulai, $tanggalKeberangkatan, $startLat = null, $startLng = null)
    {
        $itinerary = [];
        $tanggal = clone $tanggalKeberangkatan;
        $lastDestinasiLat = $startLat;
        $lastDestinasiLng = $startLng;
        
        foreach ($destinasiPerHari as $hari => $destinasi) {
            $hariItinerary = [
                'hari' => $hari,
                'tanggal' => $tanggal->format('Y-m-d'),
                'tanggal_formatted' => $this->formatTanggalIndonesia($tanggal),
                'destinasi' => []
            ];
            
            // Jika hari pertama, mulai dari waktu_mulai
            // Jika hari berikutnya, mulai dari waktu_mulai juga (reset setiap hari)
            $waktuSaatIni = $this->parseTime($waktuMulai);
            
            foreach ($destinasi as $index => $dest) {
                // Hitung jarak dari destinasi sebelumnya atau lokasi awal
                $jarak = 0;
                $waktuTempuh = 0;
                
                if ($index === 0 && $hari === 1) {
                    // Destinasi pertama hari pertama: hitung dari lokasi awal
                    if ($startLat && $startLng) {
                        $jarak = $this->haversineDistance(
                            $startLat,
                            $startLng,
                            $dest['lat'],
                            $dest['lng']
                        );
                        $waktuTempuh = $this->hitungWaktuTempuhMenit($jarak, $tanggal);
                    }
                } elseif ($index === 0 && $hari > 1) {
                    // Destinasi pertama hari berikutnya: hitung dari destinasi terakhir hari sebelumnya
                    if ($lastDestinasiLat && $lastDestinasiLng) {
                        $jarak = $this->haversineDistance(
                            $lastDestinasiLat,
                            $lastDestinasiLng,
                            $dest['lat'],
                            $dest['lng']
                        );
                        $waktuTempuh = $this->hitungWaktuTempuhMenit($jarak, $tanggal);
                    }
                } else {
                    // Destinasi setelah destinasi pertama: gunakan distance dari optimizeRoute
                    $jarak = $dest['distance'] ?? 0;
                    $waktuTempuh = $this->hitungWaktuTempuhMenit($jarak, $tanggal);
                }
                
                // Waktu mulai = waktu selesai destinasi sebelumnya + waktu tempuh
                // Tambahkan waktu tempuh jika:
                // - Bukan destinasi pertama hari pertama (index > 0)
                // - Atau destinasi pertama hari berikutnya (index === 0 && hari > 1)
                // - Atau destinasi pertama hari pertama dengan lokasi awal (index === 0 && hari === 1 && startLat)
                if ($index > 0) {
                    // Destinasi setelah destinasi pertama dalam hari yang sama
                    $waktuMulaiDestinasi = $waktuSaatIni + $waktuTempuh;
                } elseif ($index === 0 && $hari === 1 && $startLat) {
                    // Destinasi pertama hari pertama dari lokasi awal
                    $waktuMulaiDestinasi = $waktuSaatIni + $waktuTempuh;
                } elseif ($index === 0 && $hari > 1) {
                    // Destinasi pertama hari berikutnya dari destinasi terakhir hari sebelumnya
                    $waktuMulaiDestinasi = $waktuSaatIni + $waktuTempuh;
                } else {
                    // Destinasi pertama hari pertama tanpa lokasi awal (tidak ada waktu tempuh)
                    $waktuMulaiDestinasi = $waktuSaatIni;
                }
                
                // Durasi kunjungan (default 120 menit / 2 jam)
                $durasi = $dest['durasi'] ?? 120;
                
                // Waktu selesai = waktu mulai + durasi
                $waktuSelesai = $waktuMulaiDestinasi + $durasi;
                
                $hariItinerary['destinasi'][] = [
                    'id' => $dest['id'],
                    'nama' => $dest['nama'],
                    'kategori' => $dest['kategori'],
                    'rating' => $dest['rating'],
                    'biaya' => $dest['biaya'] ?? 0,
                    'alamat' => $dest['alamat'],
                    'lat' => $dest['lat'],
                    'lng' => $dest['lng'],
                    'waktu_mulai' => $this->menitKeWaktu($waktuMulaiDestinasi),
                    'waktu_selesai' => $this->menitKeWaktu($waktuSelesai),
                    'durasi' => $durasi,
                    'jarak_dari_sebelumnya' => round($jarak, 2),
                    'waktu_tempuh' => $waktuTempuh
                ];
                
                $waktuSaatIni = $waktuSelesai;
            }
            
            // Simpan koordinat destinasi terakhir hari ini untuk hari berikutnya
            if (!empty($destinasi)) {
                $lastDest = end($destinasi);
                $lastDestinasiLat = $lastDest['lat'];
                $lastDestinasiLng = $lastDest['lng'];
            }
            
            $itinerary[] = $hariItinerary;
            $tanggal->modify('+1 day');
        }
        
        return $itinerary;
    }

    /**
     * Hitung waktu tempuh dalam menit berdasarkan jarak dan tanggal
     */
    private function hitungWaktuTempuhMenit($jarakKm, $tanggal)
    {
        if ($jarakKm <= 0) return 0;
        
        $isHighSeason = $this->isHighSeason($tanggal);
        $kecepatan = $isHighSeason ? 120 : 140; // km/jam
        
        return ceil(($jarakKm / $kecepatan) * 60);
    }

    /**
     * Cek apakah tanggal masuk high season (weekend atau hari libur)
     */
    private function isHighSeason($tanggal)
    {
        return $this->isWeekend($tanggal) || $this->isHoliday($tanggal);
    }

    /**
     * Cek apakah tanggal adalah weekend
     */
    private function isWeekend($tanggal)
    {
        $day = (int)$tanggal->format('w'); // 0 = Minggu, 6 = Sabtu
        return $day === 0 || $day === 6;
    }

    /**
     * Cek apakah tanggal adalah hari libur nasional (dari database)
     */
    private function isHoliday($tanggal)
    {
        $tanggalStr = $tanggal->format('Y-m-d');
        return LiburNasional::where('tanggal', $tanggalStr)->exists();
    }

    /**
     * Parse waktu (HH:MM) ke menit dari tengah malam
     */
    private function parseTime($time)
    {
        list($jam, $menit) = explode(':', $time);
        return (int)$jam * 60 + (int)$menit;
    }

    /**
     * Konversi menit ke format waktu (HH:MM)
     */
    private function menitKeWaktu($totalMenit)
    {
        $jam = floor($totalMenit / 60) % 24;
        $menit = $totalMenit % 60;
        return sprintf('%02d:%02d', $jam, $menit);
    }

    /**
     * Format tanggal Indonesia
     */
    private function formatTanggalIndonesia($tanggal)
    {
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        $dayName = $hari[(int)$tanggal->format('w')];
        $day = $tanggal->format('d');
        $month = $bulan[(int)$tanggal->format('n')];
        $year = $tanggal->format('Y');
        
        return "$dayName, $day $month $year";
    }
}
