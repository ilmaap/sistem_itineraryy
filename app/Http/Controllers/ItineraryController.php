<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destinasi;
use App\Models\Itinerary;
use App\Models\ItineraryDestinasi;
use App\Models\LiburNasional;
use App\Models\Kategori;
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
        $itinerary = Itinerary::with('itineraryDestinasi.destinasi')
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
        
        return view('wisatawan.itinerary.create', compact('itinerary', 'kategori', 'lokasiPopuler'));
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
            $tanggal
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
     * Store itinerary
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'itinerary_data' => 'required|json',
            'itinerary_config' => 'required|json'
        ]);
        
        // Parse JSON data
        $itineraryData = json_decode($request->itinerary_data, true);
        $itineraryConfig = json_decode($request->itinerary_config, true);
        
        if (!$itineraryData || !$itineraryConfig) {
            return back()->withErrors(['error' => 'Data itinerary tidak valid']);
        }
        
        // Simpan kategori sebagai JSON string (sesuai struktur tabel)
        $kategoriJson = !empty($itineraryConfig['kategori']) ? json_encode($itineraryConfig['kategori']) : null;
        
        // Simpan itinerary
        // Format waktu_mulai ke format time (HH:MM:SS)
        $waktuMulai = $itineraryConfig['waktu_mulai'];
        if (strlen($waktuMulai) == 5) { // Format HH:MM
            $waktuMulai .= ':00'; // Tambah detik menjadi HH:MM:SS
        }
        
        $itinerary = Itinerary::create([
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
            'kategori' => $kategoriJson
        ]);
        
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
        
        return redirect()->route('wisatawan.dashboard')
            ->with('success', 'Itinerary berhasil disimpan!');
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
    private function calculateSchedule($destinasiPerHari, $waktuMulai, $tanggalKeberangkatan)
    {
        $itinerary = [];
        $tanggal = clone $tanggalKeberangkatan;
        
        foreach ($destinasiPerHari as $hari => $destinasi) {
            $hariItinerary = [
                'hari' => $hari,
                'tanggal' => $tanggal->format('Y-m-d'),
                'tanggal_formatted' => $this->formatTanggalIndonesia($tanggal),
                'destinasi' => []
            ];
            
            $waktuSaatIni = $this->parseTime($waktuMulai);
            
            foreach ($destinasi as $index => $dest) {
                // Hitung waktu tempuh dari destinasi sebelumnya
                $waktuTempuh = 0;
                if ($index > 0) {
                    $destSebelumnya = $destinasi[$index - 1];
                    $jarak = $dest['distance'] ?? 0;
                    $waktuTempuh = $this->hitungWaktuTempuhMenit($jarak, $tanggal);
                }
                
                // Waktu mulai = waktu selesai destinasi sebelumnya + waktu tempuh
                $waktuMulaiDestinasi = $waktuSaatIni + ($index > 0 ? $waktuTempuh : 0);
                
                // Durasi kunjungan (default 120 menit / 2 jam)
                $durasi = 120;
                
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
                    'jarak_dari_sebelumnya' => round($dest['distance'] ?? 0, 2),
                    'waktu_tempuh' => $waktuTempuh
                ];
                
                $waktuSaatIni = $waktuSelesai;
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
