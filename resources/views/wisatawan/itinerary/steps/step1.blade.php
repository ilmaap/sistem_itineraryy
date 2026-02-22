<div class="step-content active" id="step1">
    <h3>Lokasi Awal & Konfigurasi Perjalanan</h3>
    
    <!-- SECTION 1: Lokasi Awal Perjalanan -->
    <div class="form-section">
        <h4>
            <i class="fas fa-map-marker-alt"></i>
            Lokasi Awal Perjalanan
        </h4>
        
        <!-- Opsi Lokasi Saat Ini -->
        <div class="form-group card">
            <label style="display: flex; align-items: flex-start; gap: 1rem; cursor: pointer; margin: 0;">
                <input type="radio" id="useCurrentLocation" name="lokasi_awal_type" value="current" {{ old('lokasi_awal_type', 'current') == 'current' ? 'checked' : '' }} style="margin-top: 0.25rem; width: 20px; height: 20px; cursor: pointer; accent-color: #14b8a6;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-location-dot" style="color: #14b8a6;"></i>
                        <strong style="font-size: 1rem; color: #0f172a;">Gunakan Lokasi Saat Ini</strong>
                    </div>
                    <p style="margin: 0; color: #64748b; font-size: 0.9rem; line-height: 1.5;">Gunakan lokasi GPS Anda saat ini sebagai titik awal perjalanan</p>
                </div>
            </label>
            @php
                $showCurrentLocation = old('lokasi_awal_type', 'current') == 'current';
                $currentLocationClass = $showCurrentLocation ? 'current-location-info' : 'current-location-info hidden';
            @endphp
            <div id="currentLocationInfo" class="{{ $currentLocationClass }}">
                <div style="margin-bottom: 0.75rem;">
                    <i class="fas fa-circle-check" style="color: #14b8a6;"></i>
                    <span id="currentLocationText" style="margin-left: 0.5rem;">Lokasi akan dideteksi saat membuat itinerary</span>
                </div>
                <button type="button" onclick="getCurrentLocation()" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-crosshairs"></i> Deteksi Lokasi Sekarang
                </button>
            </div>
        </div>
        
        <!-- Divider -->
        <div class="divider">
            <span>atau</span>
        </div>
        
        <!-- Input Manual Lokasi Populer -->
        <div class="form-group">
            <label for="lokasiPopuler" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                <i class="fas fa-list" style="color: #14b8a6;"></i>
                <span>Pilih Lokasi dari Daftar Populer</span>
            </label>
            @php
                $isPopularSelected = old('lokasi_awal_type') == 'popular';
                $isPopularDisabled = !$isPopularSelected && old('lokasi_awal_type', 'current') == 'current';
            @endphp
            <div style="margin-bottom: 0.75rem;">
                <label class="popular-location-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: normal; padding: 0.5rem; border-radius: 6px; transition: background 0.2s;">
                    <input type="radio" id="usePopularLocation" name="lokasi_awal_type" value="popular" {{ $isPopularSelected ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer; accent-color: #14b8a6;">
                    <span style="font-size: 0.95rem;">Pilih dari daftar lokasi populer</span>
                </label>
            </div>
            <select id="lokasiPopuler" name="lokasi_populer" class="form-select" {{ $isPopularDisabled ? 'disabled' : '' }}>
                <option value="">-- Pilih Lokasi Populer --</option>
                <optgroup label="Hotel & Penginapan">
                    @foreach($lokasiPopuler['hotel'] ?? [] as $lokasi)
                        <option value="{{ $lokasi['value'] }}" {{ old('lokasi_populer') == $lokasi['value'] ? 'selected' : '' }}>{{ $lokasi['nama'] }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Landmark & Titik Kumpul">
                    @foreach($lokasiPopuler['landmark'] ?? [] as $lokasi)
                        <option value="{{ $lokasi['value'] }}" {{ old('lokasi_populer') == $lokasi['value'] ? 'selected' : '' }}>{{ $lokasi['nama'] }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Destinasi Wisata Populer">
                    @foreach($lokasiPopuler['wisata'] ?? [] as $lokasi)
                        <option value="{{ $lokasi['value'] }}" {{ old('lokasi_populer') == $lokasi['value'] ? 'selected' : '' }}>{{ $lokasi['nama'] }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Mall & Pusat Perbelanjaan">
                    @foreach($lokasiPopuler['mall'] ?? [] as $lokasi)
                        <option value="{{ $lokasi['value'] }}" {{ old('lokasi_populer') == $lokasi['value'] ? 'selected' : '' }}>{{ $lokasi['nama'] }}</option>
                    @endforeach
                </optgroup>
            </select>
            <small>
                <i class="fas fa-info-circle"></i> Pilih lokasi populer dari database sistem
            </small>
            <div id="selectedLocationInfo">
                <i class="fas fa-map-pin"></i>
                <div>
                    <strong id="selectedLocationName">-</strong>
                    <span id="selectedLocationAddress">-</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- SECTION 2: Konfigurasi Perjalanan -->
    <div class="form-section">
        <h4>
            <i class="fas fa-cog"></i>
            Konfigurasi Perjalanan
        </h4>
        
        <!-- Field 1: Tanggal Keberangkatan -->
        <div class="form-group">
            <label for="tanggalKeberangkatan">
                <i class="fas fa-calendar-alt"></i>
                Tanggal Keberangkatan
            </label>
            <input type="date" 
                   id="tanggalKeberangkatan" 
                   name="tanggal_keberangkatan" 
                   required 
                   min="{{ date('Y-m-d') }}"
                   value="{{ old('tanggal_keberangkatan') }}">
            <small>
                <i class="fas fa-info-circle"></i> Pilih tanggal mulai perjalanan untuk perhitungan waktu tempuh yang akurat
            </small>
            <div id="tanggalInfo">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong id="tanggalInfoText"></strong>
                    <small id="tanggalInfoDetail"></small>
                </div>
            </div>
            @error('tanggal_keberangkatan')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Field 2: Jumlah Hari -->
        <div class="form-group">
            <label for="jumlahHari">Jumlah Hari Perjalanan</label>
            <select id="jumlahHari" name="jumlah_hari" class="form-select" required>
                <option value="">-- Pilih --</option>
                @for($i = 1; $i <= 7; $i++)
                    <option value="{{ $i }}" {{ old('jumlah_hari') == $i ? 'selected' : '' }}>
                        {{ $i }} Hari
                    </option>
                @endfor
            </select>
            @error('jumlah_hari')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Field 3: Waktu Mulai -->
        <div class="form-group">
            <label for="waktuMulai">Waktu Mulai Wisata</label>
            <input type="time" 
                   id="waktuMulai" 
                   name="waktu_mulai" 
                   required 
                   value="{{ old('waktu_mulai', '08:00') }}">
            @error('waktu_mulai')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Field 4: Lokasi Wisata -->
        <div class="form-group">
            <label for="lokasiWisata">
                <i class="fas fa-map-marked-alt"></i>
                Lokasi Wisata
            </label>
            <select id="lokasiWisata" name="lokasi_wisata" class="form-select" required>
                <option value="">-- Pilih Lokasi --</option>
                <option value="yogyakarta" {{ old('lokasi_wisata') == 'yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                <option value="solo" {{ old('lokasi_wisata') == 'solo' ? 'selected' : '' }}>Solo</option>
            </select>
            <small>
                <i class="fas fa-info-circle"></i> Pilih lokasi destinasi wisata yang ingin dikunjungi
            </small>
            @error('lokasi_wisata')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Field 5: Jenis Jalur -->
        <div class="form-group">
            <label for="jenisJalur">
                <i class="fas fa-route"></i>
                Jenis Jalur
            </label>
            <select id="jenisJalur" name="jenis_jalur" class="form-select" required>
                <option value="">-- Pilih Jenis Jalur --</option>
                <option value="tol" {{ old('jenis_jalur', 'tol') == 'tol' ? 'selected' : '' }}>Tol</option>
                <option value="non_tol" {{ old('jenis_jalur') == 'non_tol' ? 'selected' : '' }}>Non Tol</option>
            </select>
            <small>
                <i class="fas fa-info-circle"></i> Pilih jenis jalur perjalanan. Tol: menggunakan jalan tol. Non Tol: menggunakan jalan non tol.
            </small>
            @error('jenis_jalur')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Field 6: Minimal Rating -->
        <div class="form-group">
            <label for="minRating">
                <i class="fas fa-star"></i>
                Minimal Rating
            </label>
            <div class="rating-slider">
                <input type="range" 
                       id="minRating" 
                       name="min_rating" 
                       min="0" 
                       max="5" 
                       step="0.1" 
                       value="{{ old('min_rating', 0) }}">
                <div class="rating-display">
                    <span id="ratingDisplay">0.0</span>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <small>
                <i class="fas fa-info-circle"></i> Destinasi yang ditampilkan akan memiliki rating minimal sesuai pilihan Anda
            </small>
        </div>
        
        <!-- Field 7: Kategori Wisata -->
        <div class="form-group">
            <label>Kategori Wisata</label>
            <div class="kategori-list">
                @foreach($kategori as $kode => $nama)
                    @php
                        $iconMap = [
                            'alam' => 'fa-mountain',
                            'budaya' => 'fa-monument',
                            'buatan' => 'fa-building',
                            'minat' => 'fa-star'
                        ];
                        $icon = $iconMap[$kode] ?? 'fa-star';
                    @endphp
                    <label class="kategori-item">
                        <input type="checkbox" 
                               name="kategori[]" 
                               value="{{ $kode }}"
                               onchange="updateDestinasiList()"
                               {{ in_array($kode, old('kategori', [])) ? 'checked' : '' }}>
                        <div class="kategori-content">
                            <i class="fas {{ $icon }}"></i>
                            <span>{{ $nama }}</span>
                        </div>
                    </label>
                @endforeach
            </div>
            @error('kategori')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <!-- SECTION 3: Pilih Destinasi Manual (Opsional) -->
    <div class="form-section">
        <h4>
            <i class="fas fa-map-pin"></i>
            Pilih Destinasi Secara Manual (Opsional)
        </h4>
        
        <!-- Toggle Manual Selection -->
        <div class="form-group card">
            <label>
                <input type="checkbox" id="enableManualSelection" name="enable_manual_selection" value="1" {{ old('enable_manual_selection') ? 'checked' : '' }}>
                <div>
                    <div>
                        <i class="fas fa-hand-pointer"></i>
                        <strong>Aktifkan Pilihan Destinasi Manual</strong>
                    </div>
                    <p>Pilih destinasi wisata sesuai preferensi pribadi Anda. Jika tidak dipilih, sistem akan menyusun itinerary secara otomatis berdasarkan kategori yang dipilih.</p>
                </div>
            </label>
        </div>
        
        <!-- Daftar Destinasi (muncul jika manual selection diaktifkan) -->
        <div id="manualDestinasiSection">
            <!-- Info Box -->
            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Cara Menggunakan:</strong>
                    <ul>
                        <li>Pilih destinasi tambahan yang ingin Anda kunjungi dengan mencentang checkbox</li>
                        <li>Gunakan <strong>pencarian</strong> untuk mencari destinasi berdasarkan nama atau alamat</li>
                        <li>Gunakan <strong>urutkan</strong> untuk mengurutkan destinasi (nama, rating, harga)</li>
                        <li>Atur <strong>jumlah per halaman</strong> untuk menyesuaikan tampilan (12, 24, 48, atau 96)</li>
                    </ul>
                </div>
            </div>
            
            <!-- Search & Filter Bar -->
            <div class="filter-bar">
                <div class="filter-grid">
                    <!-- Search Box -->
                    <div class="form-group">
                        <label for="searchDestinasi">
                            <i class="fas fa-search"></i>
                            Cari Destinasi
                        </label>
                        <input type="text" 
                               id="searchDestinasi" 
                               placeholder="Cari berdasarkan nama atau alamat...">
                    </div>
                    
                    <!-- Sort Options -->
                    <div class="form-group">
                        <label for="sortDestinasi">
                            <i class="fas fa-sort"></i>
                            Urutkan
                        </label>
                        <select id="sortDestinasi" class="form-select">
                            <option value="default">Default</option>
                            <option value="name-asc">Nama A-Z</option>
                            <option value="name-desc">Nama Z-A</option>
                            <option value="rating-desc">Rating Tertinggi</option>
                            <option value="rating-asc">Rating Terendah</option>
                            <option value="price-asc">Harga Terendah</option>
                            <option value="price-desc">Harga Tertinggi</option>
                        </select>
                    </div>
                    
                    <!-- Items Per Page -->
                    <div class="form-group">
                        <label for="itemsPerPage">
                            <i class="fas fa-list"></i>
                            Per Halaman
                        </label>
                        <select id="itemsPerPage" class="form-select">
                            <option value="12">12</option>
                            <option value="24" selected>24</option>
                            <option value="48">48</option>
                            <option value="96">96</option>
                        </select>
                    </div>
                </div>
                
                <!-- Results Info -->
                <div id="destinasiResultsInfo">
                    <span id="destinasiResultsText">Menampilkan 0 destinasi</span>
                    <span id="destinasiPageInfo">Halaman 1 dari 1</span>
                </div>
            </div>
            
            <!-- Destinasi List Container -->
            <div id="destinasiList" class="destinasi-grid">
                <!-- Destinasi cards akan dimuat di sini via JavaScript/AJAX -->
            </div>
            
            <!-- Pagination Controls -->
            <div id="paginationControls">
                <button type="button" id="prevPageBtn" disabled>
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <div id="pageNumbers"></div>
                <button type="button" id="nextPageBtn" disabled>
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <!-- Selected Destinasi Info -->
            <div id="selectedDestinasiInfo">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Destinasi Tambahan Terpilih: <span id="selectedDestinasiCount">0</span></strong>
                    <small>Destinasi tambahan ini akan digabungkan dengan destinasi otomatis dan disusun ulang untuk optimasi rute</small>
                </div>
            </div>
        </div>
        
        <!-- Hidden field untuk selected destinasi IDs -->
        <input type="hidden" name="selected_destinasi_ids" id="selectedDestinasiIds" value="{{ old('selected_destinasi_ids', '') }}">
        
        <!-- Hidden field untuk update destinasi list function -->
        <script>
            function updateDestinasiList() {
                const enableManual = document.getElementById('enableManualSelection');
                if (enableManual && enableManual.checked) {
                    if (typeof loadDestinasiList === 'function') {
                        currentPage = 1;
                        loadDestinasiList();
                    }
                }
            }
        </script>
    </div>
    
    <!-- Tombol Aksi -->
    <div class="step-actions">
        <div></div>
        <button type="button" class="btn btn-primary">
            <i class="fas fa-cog"></i> Proses
        </button>
    </div>
</div>

