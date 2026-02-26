// Itinerary Form JavaScript
// Global variables
let currentLocationData = null;
let selectedDestinasiIds = [];
let currentPage = 1;
let searchTimeout = null;

// Data lokasi populer dummy (sama dengan backend)
const lokasiPopulerData = {
    'hotel-grand-mercure-yogyakarta': {
        name: 'Hotel Grand Mercure Yogyakarta',
        address: 'Jl. Jend. Sudirman No.9, Yogyakarta',
        lat: -7.7833,
        lng: 110.3690
    },
    'hotel-phoenix-yogyakarta': {
        name: 'Hotel Phoenix Yogyakarta',
        address: 'Jl. Jend. Sudirman No.9, Yogyakarta',
        lat: -7.7829,
        lng: 110.3687
    },
    'hotel-santika-premier-yogyakarta': {
        name: 'Hotel Santika Premier Yogyakarta',
        address: 'Jl. Jend. Sudirman No.2, Yogyakarta',
        lat: -7.7850,
        lng: 110.3710
    },
    'hotel-solo': {
        name: 'Hotel Solo',
        address: 'Jl. Slamet Riyadi No.324, Solo',
        lat: -7.5667,
        lng: 110.8167
    },
    'hotel-kusuma-sahid-solo': {
        name: 'Hotel Kusuma Sahid Solo',
        address: 'Jl. Sugiyopranoto No.20, Solo',
        lat: -7.5633,
        lng: 110.8217
    },
    'malioboro': {
        name: 'Malioboro',
        address: 'Jl. Malioboro, Yogyakarta',
        lat: -7.7956,
        lng: 110.3694
    },
    'stasiun-tugu-yogyakarta': {
        name: 'Stasiun Tugu Yogyakarta',
        address: 'Jl. Mangkubumi No.1, Yogyakarta',
        lat: -7.7894,
        lng: 110.3633
    },
    'bandara-adisucipto': {
        name: 'Bandara Adisucipto Yogyakarta',
        address: 'Jl. Solo, Maguwoharjo, Yogyakarta',
        lat: -7.7882,
        lng: 110.4319
    },
    'stasiun-purwosari-solo': {
        name: 'Stasiun Purwosari Solo',
        address: 'Jl. Slamet Riyadi, Solo',
        lat: -7.5717,
        lng: 110.8017
    },
    'bandara-adisumarmo-solo': {
        name: 'Bandara Adisumarmo Solo',
        address: 'Jl. Raya Solo - Yogyakarta, Solo',
        lat: -7.5161,
        lng: 110.7572
    },
    'keraton-yogyakarta': {
        name: 'Keraton Yogyakarta',
        address: 'Jl. Rotowijayan, Yogyakarta',
        lat: -7.8052,
        lng: 110.3647
    },
    'candi-prambanan': {
        name: 'Candi Prambanan',
        address: 'Jl. Raya Solo - Yogyakarta, Prambanan',
        lat: -7.7520,
        lng: 110.4915
    },
    'keraton-solo': {
        name: 'Keraton Solo',
        address: 'Jl. Slamet Riyadi, Solo',
        lat: -7.5747,
        lng: 110.8247
    },
    'taman-sari': {
        name: 'Taman Sari Yogyakarta',
        address: 'Jl. Taman, Yogyakarta',
        lat: -7.8100,
        lng: 110.3589
    },
    'malioboro-mall': {
        name: 'Malioboro Mall',
        address: 'Jl. Malioboro No.52-58, Yogyakarta',
        lat: -7.7931,
        lng: 110.3647
    },
    'plaza-ambarrukmo': {
        name: 'Plaza Ambarrukmo',
        address: 'Jl. Laksda Adisucipto No.81, Yogyakarta',
        lat: -7.7831,
        lng: 110.4075
    },
    'solo-grand-mall': {
        name: 'Solo Grand Mall',
        address: 'Jl. Slamet Riyadi, Solo',
        lat: -7.5661,
        lng: 110.8189
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeForm();
    setupEventListeners();
});

// Initialize form
function initializeForm() {
    // Set min date to today
    const tanggalInput = document.getElementById('tanggalKeberangkatan');
    if (tanggalInput) {
        const today = new Date().toISOString().split('T')[0];
        tanggalInput.setAttribute('min', today);
        
        // Update tanggal info on change
        tanggalInput.addEventListener('change', updateTanggalInfo);
        if (tanggalInput.value) {
            updateTanggalInfo();
        }
    }
    
    // Rating slider
    const ratingSlider = document.getElementById('minRating');
    const ratingDisplay = document.getElementById('ratingDisplay');
    if (ratingSlider && ratingDisplay) {
        ratingSlider.addEventListener('input', function() {
            ratingDisplay.textContent = parseFloat(this.value).toFixed(1);
        });
    }
    
    // Use current location radio button
    const useCurrentLocation = document.getElementById('useCurrentLocation');
    const usePopularLocation = document.getElementById('usePopularLocation');
    const lokasiPopuler = document.getElementById('lokasiPopuler');
    
    // Function to handle location type change
    function handleLocationTypeChange() {
        const lokasiAwalType = document.querySelector('input[name="lokasi_awal_type"]:checked');
        
        if (lokasiAwalType) {
            if (lokasiAwalType.value === 'current') {
                // Current location selected
                const infoDiv = document.getElementById('currentLocationInfo');
                if (infoDiv) {
                    infoDiv.classList.remove('hidden');
                }
                
                // Disable lokasi populer
                if (lokasiPopuler) {
                    lokasiPopuler.disabled = true;
                    lokasiPopuler.value = '';
                }
                
                // Clear selected location info
                const selectedInfo = document.getElementById('selectedLocationInfo');
                if (selectedInfo) {
                    selectedInfo.classList.remove('show');
                }
            } else if (lokasiAwalType.value === 'popular') {
                // Popular location selected
                if (lokasiPopuler) lokasiPopuler.disabled = false;
                
                // Hide current location info
                const currentInfo = document.getElementById('currentLocationInfo');
                if (currentInfo) {
                    currentInfo.classList.add('hidden');
                }
                currentLocationData = null;
            }
        }
    }
    
    if (useCurrentLocation) {
        useCurrentLocation.addEventListener('change', handleLocationTypeChange);
        
        // Check initial state
        if (useCurrentLocation.checked) {
            handleLocationTypeChange();
        }
    }
    
    if (usePopularLocation) {
        usePopularLocation.addEventListener('change', handleLocationTypeChange);
        
        // Check initial state
        if (usePopularLocation.checked) {
            handleLocationTypeChange();
        }
    }
    
    // Lokasi populer select
    if (lokasiPopuler) {
        lokasiPopuler.addEventListener('change', function() {
            const value = this.value;
            if (value && lokasiPopulerData[value]) {
                const lokasi = lokasiPopulerData[value];
                const infoDiv = document.getElementById('selectedLocationInfo');
                const nameSpan = document.getElementById('selectedLocationName');
                const addressSpan = document.getElementById('selectedLocationAddress');
                
                if (infoDiv) infoDiv.classList.add('show');
                if (nameSpan) nameSpan.textContent = lokasi.name;
                if (addressSpan) addressSpan.textContent = lokasi.address;
                
                // Set radio button to popular
                if (usePopularLocation) usePopularLocation.checked = true;
                if (useCurrentLocation) useCurrentLocation.checked = false;
                handleLocationTypeChange();
                
                // Set location data
                currentLocationData = {
                    lat: lokasi.lat,
                    lng: lokasi.lng,
                    name: lokasi.name,
                    address: lokasi.address
                };
            } else {
                const infoDiv = document.getElementById('selectedLocationInfo');
                if (infoDiv) infoDiv.classList.remove('show');
                currentLocationData = null;
            }
        });
    }
    
    // Manual selection toggle
    const enableManualSelection = document.getElementById('enableManualSelection');
    if (enableManualSelection) {
        enableManualSelection.addEventListener('change', function() {
            const section = document.getElementById('manualDestinasiSection');
            if (this.checked) {
                if (section) section.classList.add('show');
                loadDestinasiList();
            } else {
                if (section) section.classList.remove('show');
                selectedDestinasiIds = [];
                updateSelectedDestinasiInfo();
            }
        });
    }
    
    // Search input with debounce
    const searchInput = document.getElementById('searchDestinasi');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                loadDestinasiList();
            }, 300);
        });
    }
    
    // Sort and items per page
    const sortSelect = document.getElementById('sortDestinasi');
    const itemsPerPage = document.getElementById('itemsPerPage');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            currentPage = 1;
            loadDestinasiList();
        });
    }
    if (itemsPerPage) {
        itemsPerPage.addEventListener('change', function() {
            currentPage = 1;
            loadDestinasiList();
        });
    }
}

// Setup event listeners
function setupEventListeners() {
    // Step navigation buttons
    const processBtn = document.querySelector('#step1 .btn-primary');
    if (processBtn) {
        processBtn.addEventListener('click', function() {
            if (validateStep1()) {
                generateItinerary();
            }
        });
    }
    
    const backBtn2 = document.querySelector('#step2 .btn-outline');
    if (backBtn2) {
        backBtn2.addEventListener('click', function() {
            showStep(1);
        });
    }
    
    const saveBtn2 = document.querySelector('#step2 .btn-primary');
    if (saveBtn2) {
        saveBtn2.addEventListener('click', function() {
            showStep(3);
        });
    }
    
    const backBtn3 = document.querySelector('#step3 .btn-outline');
    if (backBtn3) {
        backBtn3.addEventListener('click', function() {
            prevStep(2);
        });
    }
    
    // Handle form submit untuk memastikan semua perubahan tersimpan
    const formStep3 = document.querySelector('#step3 form');
    if (formStep3) {
        formStep3.addEventListener('submit', function(e) {
            // Simpan semua perubahan sebelum submit
            saveStep1Changes();
            saveStep2Changes();
            
            // Update hidden fields dengan data terbaru
            const dataInput = document.getElementById('itineraryData');
            const configInput = document.getElementById('itineraryConfig');
            if (dataInput && window.itineraryData) {
                dataInput.value = JSON.stringify(window.itineraryData);
            }
            if (configInput && window.itineraryConfig) {
                configInput.value = JSON.stringify(window.itineraryConfig);
            }
        });
    }
}

// HTML5 Geolocation API
function getCurrentLocation() {
    const infoDiv = document.getElementById('currentLocationInfo');
    const textSpan = document.getElementById('currentLocationText');
    
    if (!navigator.geolocation) {
        if (textSpan) {
            textSpan.textContent = 'Geolocation tidak didukung oleh browser Anda';
            textSpan.style.color = '#ef4444';
        }
        return;
    }
    
    if (textSpan) {
        textSpan.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendeteksi lokasi...';
        textSpan.style.color = 'var(--primary-color)';
    }
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            currentLocationData = {
                lat: lat,
                lng: lng,
                name: 'Lokasi Saat Ini',
                address: `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`
            };
            
            if (textSpan) {
                textSpan.innerHTML = '<i class="fas fa-check-circle"></i> Lokasi berhasil dideteksi';
                textSpan.style.color = '#10b981';
            }
            
            // Show coordinates
            if (infoDiv) {
                let coordInfo = infoDiv.querySelector('.coord-info');
                if (!coordInfo) {
                    coordInfo = document.createElement('div');
                    coordInfo.className = 'coord-info';
                    coordInfo.style.marginTop = '0.5rem';
                    coordInfo.style.fontSize = '0.85rem';
                    coordInfo.style.color = '#64748b';
                    infoDiv.appendChild(coordInfo);
                }
                coordInfo.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
            }
        },
        function(error) {
            if (textSpan) {
                textSpan.innerHTML = '<i class="fas fa-exclamation-circle"></i> Tidak dapat mendeteksi lokasi. Gunakan pilihan lokasi populer.';
                textSpan.style.color = '#ef4444';
            }
        }
    );
}

// Update tanggal info (AJAX ke Backend)
function updateTanggalInfo() {
    const tanggalInput = document.getElementById('tanggalKeberangkatan');
    const infoDiv = document.getElementById('tanggalInfo');
    const infoText = document.getElementById('tanggalInfoText');
    const infoDetail = document.getElementById('tanggalInfoDetail');
    
    if (!tanggalInput || !tanggalInput.value) {
        if (infoDiv) infoDiv.classList.remove('show');
        return;
    }
    
    const tanggal = tanggalInput.value;
    const route = document.querySelector('meta[name="holiday-info-route"]')?.content || 
                  '/wisatawan/api/holiday-info';
    
    // AJAX request ke backend
    fetch(`${route}?tanggal=${tanggal}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (infoText) {
            infoText.textContent = data.tanggal_formatted;
        }
        if (infoDetail) {
            infoDetail.innerHTML = `
                <strong>${data.is_high_season ? 'High Season' : 'Low Season'}</strong> - ${data.jenis_hari}<br>
                Kecepatan rata-rata: <strong>${data.kecepatan} km/jam</strong>
            `;
        }
        if (infoDiv) {
            infoDiv.classList.add('show');
            // Update warna berdasarkan season
            if (data.is_high_season) {
                infoDiv.style.borderLeftColor = '#f59e0b';
                infoDiv.style.background = '#fef3c7';
            } else {
                infoDiv.style.borderLeftColor = '#10b981';
                infoDiv.style.background = '#d1fae5';
            }
        }
    })
    .catch(error => {
        console.error('Error fetching holiday info:', error);
    });
}

// Load destinasi list (AJAX)
function loadDestinasiList() {
    const searchInput = document.getElementById('searchDestinasi');
    const sortSelect = document.getElementById('sortDestinasi');
    const itemsPerPage = document.getElementById('itemsPerPage');
    const lokasiWisata = document.getElementById('lokasiWisata');
    const minRating = document.getElementById('minRating');
    const kategoriCheckboxes = document.querySelectorAll('input[name="kategori[]"]:checked');
    
    const params = new URLSearchParams();
    if (searchInput && searchInput.value) params.append('search', searchInput.value);
    if (sortSelect && sortSelect.value) params.append('sort', sortSelect.value);
    if (itemsPerPage && itemsPerPage.value) params.append('per_page', itemsPerPage.value);
    if (lokasiWisata && lokasiWisata.value) params.append('lokasi', lokasiWisata.value);
    if (minRating && minRating.value) params.append('min_rating', minRating.value);
    
    const kategori = Array.from(kategoriCheckboxes).map(cb => cb.value);
    if (kategori.length > 0) {
        params.append('kategori', kategori.join(','));
    }
    
    params.append('page', currentPage);
    
    const route = document.querySelector('meta[name="destinations-route"]')?.content || 
                  '/wisatawan/itinerary/destinations';
    
    fetch(`${route}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        renderDestinasiList(data.data);
        updatePagination(data);
        updateResultsInfo(data);
    })
    .catch(error => {
        console.error('Error loading destinations:', error);
    });
}

// Render destinasi list
function renderDestinasiList(destinasi) {
    const container = document.getElementById('destinasiList');
    if (!container) return;
    
    container.innerHTML = '';
    
    if (destinasi.length === 0) {
        container.innerHTML = '<p style="text-align: center; color: #64748b; padding: 2rem;">Tidak ada destinasi ditemukan.</p>';
        return;
    }
    
    destinasi.forEach(dest => {
        const card = document.createElement('div');
        card.className = 'destinasi-card';
        card.style.cssText = 'border: 2px solid #e2e8f0; border-radius: 12px; padding: 1rem; background: white; transition: all 0.3s;';
        
        const isSelected = selectedDestinasiIds.includes(dest.id);
        if (isSelected) {
            card.style.borderColor = '#14b8a6';
            card.style.background = '#f0f9ff';
        }
        
        card.innerHTML = `
            <label style="display: flex; align-items: flex-start; gap: 1rem; cursor: pointer;">
                <input type="checkbox" 
                       value="${dest.id}" 
                       ${isSelected ? 'checked' : ''}
                       onchange="toggleDestinasi(${dest.id}, this.checked)"
                       style="margin-top: 0.25rem; width: 20px; height: 20px; cursor: pointer;">
                <div style="flex: 1;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #0f172a; font-size: 1.1rem;">${dest.nama}</h4>
                    <p style="margin: 0 0 0.5rem 0; color: #64748b; font-size: 0.9rem;">
                        <i class="fas fa-map-marker-alt"></i> ${dest.alamat || '-'}
                    </p>
                    <div style="display: flex; gap: 1rem; font-size: 0.85rem; color: #64748b;">
                        <span><i class="fas fa-star" style="color: #f59e0b;"></i> ${dest.rating || 0}</span>
                        <span><i class="fas fa-tag"></i> Rp ${(dest.biaya || 0).toLocaleString('id-ID')}</span>
                    </div>
                </div>
            </label>
        `;
        
        container.appendChild(card);
    });
}

// Toggle destinasi selection
function toggleDestinasi(id, checked) {
    if (checked) {
        if (!selectedDestinasiIds.includes(id)) {
            selectedDestinasiIds.push(id);
        }
    } else {
        selectedDestinasiIds = selectedDestinasiIds.filter(did => did !== id);
    }
    updateSelectedDestinasiInfo();
    loadDestinasiList(); // Re-render to update styles
}

// Update selected destinasi info
function updateSelectedDestinasiInfo() {
    const infoDiv = document.getElementById('selectedDestinasiInfo');
    const countSpan = document.getElementById('selectedDestinasiCount');
    const hiddenInput = document.getElementById('selectedDestinasiIds');
    
    if (countSpan) countSpan.textContent = selectedDestinasiIds.length;
    if (hiddenInput) hiddenInput.value = selectedDestinasiIds.join(',');
    
    if (infoDiv) {
        if (selectedDestinasiIds.length > 0) {
            infoDiv.classList.add('show');
        } else {
            infoDiv.classList.remove('show');
        }
    }
}

// Update pagination
function updatePagination(data) {
    const controls = document.getElementById('paginationControls');
    const prevBtn = document.getElementById('prevPageBtn');
    const nextBtn = document.getElementById('nextPageBtn');
    const pageNumbers = document.getElementById('pageNumbers');
    
    if (!controls) return;
    
    if (data.last_page <= 1) {
        controls.classList.remove('show');
        return;
    }
    
    controls.classList.add('show');
    
    if (prevBtn) {
        prevBtn.disabled = data.current_page === 1;
        prevBtn.onclick = () => {
            if (data.current_page > 1) {
                currentPage = data.current_page - 1;
                loadDestinasiList();
            }
        };
    }
    
    if (nextBtn) {
        nextBtn.disabled = data.current_page === data.last_page;
        nextBtn.onclick = () => {
            if (data.current_page < data.last_page) {
                currentPage = data.current_page + 1;
                loadDestinasiList();
            }
        };
    }
    
    if (pageNumbers) {
        pageNumbers.innerHTML = '';
        const maxPages = 7;
        let startPage = Math.max(1, data.current_page - Math.floor(maxPages / 2));
        let endPage = Math.min(data.last_page, startPage + maxPages - 1);
        
        if (endPage - startPage < maxPages - 1) {
            startPage = Math.max(1, endPage - maxPages + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.style.cssText = `padding: 0.5rem 0.75rem; border: 2px solid ${i === data.current_page ? '#14b8a6' : '#e2e8f0'}; background: ${i === data.current_page ? '#14b8a6' : 'white'}; color: ${i === data.current_page ? 'white' : '#0f172a'}; border-radius: 6px; cursor: pointer;`;
            btn.onclick = () => {
                currentPage = i;
                loadDestinasiList();
            };
            pageNumbers.appendChild(btn);
        }
    }
}

// Update results info
function updateResultsInfo(data) {
    const resultsText = document.getElementById('destinasiResultsText');
    const pageInfo = document.getElementById('destinasiPageInfo');
    
    if (resultsText) {
        resultsText.textContent = `Menampilkan ${data.data.length} dari ${data.total} destinasi`;
    }
    if (pageInfo) {
        pageInfo.textContent = `Halaman ${data.current_page} dari ${data.last_page}`;
    }
}

// Validate step 1
function validateStep1() {
    const tanggal = document.getElementById('tanggalKeberangkatan');
    const jumlahHari = document.getElementById('jumlahHari');
    const waktuMulai = document.getElementById('waktuMulai');
    const lokasiWisata = document.getElementById('lokasiWisata');
    const kategori = document.querySelectorAll('input[name="kategori[]"]:checked');
    
    if (!tanggal || !tanggal.value) {
        alert('Harap pilih tanggal keberangkatan');
        return false;
    }
    
    if (!jumlahHari || !jumlahHari.value) {
        alert('Harap pilih jumlah hari');
        return false;
    }
    
    if (!waktuMulai || !waktuMulai.value) {
        alert('Harap pilih waktu mulai');
        return false;
    }
    
    if (!lokasiWisata || !lokasiWisata.value) {
        alert('Harap pilih lokasi wisata');
        return false;
    }
    
    if (kategori.length === 0) {
        alert('Harap pilih minimal satu kategori wisata');
        return false;
    }
    
    // Check jenis jalur
    const jenisJalur = document.getElementById('jenisJalur');
    if (!jenisJalur || !jenisJalur.value) {
        alert('Harap pilih jenis jalur');
        return false;
    }
    
    // Check location
    const lokasiAwalType = document.querySelector('input[name="lokasi_awal_type"]:checked');
    if (!lokasiAwalType) {
        alert('Harap pilih lokasi awal perjalanan (gunakan lokasi saat ini atau pilih dari daftar populer)');
        return false;
    }
    
    if (lokasiAwalType.value === 'current' && !currentLocationData) {
        alert('Harap deteksi lokasi saat ini terlebih dahulu');
        return false;
    }
    
    if (lokasiAwalType.value === 'popular') {
        const lokasiPopuler = document.getElementById('lokasiPopuler');
        if (!lokasiPopuler || !lokasiPopuler.value) {
            alert('Harap pilih lokasi dari daftar populer');
            return false;
        }
    }
    
    return true;
}

// Generate itinerary
function generateItinerary() {
    if (!validateStep1()) return;
    
    // Simpan perubahan dari step 1 terlebih dahulu
    saveStep1Changes();
    
    // Ambil konfigurasi dari window.itineraryConfig (yang sudah di-save) atau dari form
    const tanggal = window.itineraryConfig?.tanggal_keberangkatan || document.getElementById('tanggalKeberangkatan').value;
    const jumlahHari = window.itineraryConfig?.jumlah_hari || parseInt(document.getElementById('jumlahHari').value);
    const waktuMulai = window.itineraryConfig?.waktu_mulai || document.getElementById('waktuMulai').value;
    const lokasiWisata = window.itineraryConfig?.lokasi_wisata || document.getElementById('lokasiWisata').value;
    const minRating = window.itineraryConfig?.min_rating || parseFloat(document.getElementById('minRating').value) || 0;
    const jenisJalur = window.itineraryConfig?.jenis_jalur || document.getElementById('jenisJalur').value;
    const kategori = window.itineraryConfig?.kategori || Array.from(document.querySelectorAll('input[name="kategori[]"]:checked')).map(cb => cb.value);
    
    // Get start location
    let startLat, startLng;
    const lokasiAwalType = document.querySelector('input[name="lokasi_awal_type"]:checked');
    
    if (lokasiAwalType && lokasiAwalType.value === 'current') {
        // Use current location
        if (currentLocationData) {
            startLat = currentLocationData.lat;
            startLng = currentLocationData.lng;
        } else {
            alert('Harap deteksi lokasi saat ini terlebih dahulu atau pilih lokasi dari daftar populer');
            return;
        }
    } else {
        // Use popular location
        const lokasiPopuler = document.getElementById('lokasiPopuler');
        if (lokasiPopuler && lokasiPopuler.value && lokasiPopulerData[lokasiPopuler.value]) {
            const lokasi = lokasiPopulerData[lokasiPopuler.value];
            startLat = lokasi.lat;
            startLng = lokasi.lng;
        } else {
            alert('Harap pilih lokasi dari daftar populer atau gunakan lokasi saat ini');
            return;
        }
    }
    
    // Show loading
    showStep(2);
    const resultDiv = document.getElementById('itineraryResult');
    if (resultDiv) {
        resultDiv.innerHTML = '<div class="loading-state"><i class="fas fa-spinner fa-spin"></i><p>Sistem sedang memproses dan menyusun itinerary optimal...</p></div>';
    }
    
    // AJAX request
    const route = document.querySelector('meta[name="generate-route"]')?.content || 
                  '/wisatawan/itinerary/generate';
    
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
            tanggal_keberangkatan: tanggal,
            jumlah_hari: jumlahHari,
            waktu_mulai: waktuMulai,
            lokasi_wisata: lokasiWisata,
            min_rating: minRating,
            jenis_jalur: jenisJalur,
            kategori: kategori,
            start_lat: startLat,
            start_lng: startLng,
            selected_destinasi_ids: selectedDestinasiIds
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            renderItineraryResult(data.itinerary);
            // Store data for step 3
            window.itineraryData = data.itinerary;
            window.itineraryConfig = data.config;
        } else {
            alert('Gagal membuat itinerary. Silakan coba lagi.');
        }
    })
    .catch(error => {
        console.error('Error generating itinerary:', error);
        alert('Terjadi kesalahan saat membuat itinerary. Silakan coba lagi.');
    });
}

// Render itinerary result
function renderItineraryResult(itinerary) {
    const resultDiv = document.getElementById('itineraryResult');
    if (!resultDiv) return '';
    
    if (!itinerary || itinerary.length === 0) {
        resultDiv.innerHTML = '<div class="error-message"><p>Tidak ada itinerary yang dihasilkan.</p></div>';
        return;
    }
    
    // Calculate totals
    const jumlahHari = itinerary.length;
    const waktuMulai = window.itineraryConfig?.waktu_mulai || '08:00';
    const totalDestinasi = itinerary.reduce((sum, day) => sum + day.destinasi.length, 0);
    const totalJarak = itinerary.reduce((sum, day) => {
        return sum + day.destinasi.reduce((daySum, dest) => {
            return daySum + (parseFloat(dest.jarak_dari_sebelumnya) || 0);
        }, 0);
    }, 0);
    
    let html = '<div class="itinerary-result">';
    
    // Info Card
    html += `
        <div class="itinerary-info-card">
            <div class="info-card-header">
                <h4>Informasi Itinerary</h4>
                <button type="button" class="btn btn-sm btn-primary" onclick="tambahDestinasi()">
                    <i class="fas fa-plus"></i> Tambah Destinasi
                </button>
            </div>
            <div class="info-card-grid">
                <div class="info-card-item">
                    <label>Jumlah Hari</label>
                    <div class="info-value">${jumlahHari} Hari</div>
                </div>
                <div class="info-card-item">
                    <label>Waktu Mulai</label>
                    <div class="info-value">${waktuMulai}</div>
                </div>
                <div class="info-card-item">
                    <label>Jumlah Destinasi</label>
                    <div class="info-value">${totalDestinasi} Destinasi</div>
                </div>
                <div class="info-card-item">
                    <label>Total Jarak</label>
                    <div class="info-value">${totalJarak.toFixed(1)} km</div>
                </div>
            </div>
        </div>
    `;
    
    // Daily Itinerary
    itinerary.forEach(day => {
        html += `
            <div class="day-itinerary-card">
                <div class="day-header">
                    <div class="day-badge">${day.hari}</div>
                    <div class="day-title">
                        <h4>Hari ${day.hari}</h4>
                        <p>${day.destinasi.length} destinasi</p>
                    </div>
                </div>
                <div class="day-destinasi-list">
        `;
        
        day.destinasi.forEach((dest, index) => {
            const waktuTibaStr = dest.waktu_mulai || dest.waktu_tiba || '08:00';
            const waktuSelesaiStr = dest.waktu_selesai || '10:00';
            const jarakKm = parseFloat(dest.jarak_dari_sebelumnya) || 0;
            const waktuTempuhMenit = parseInt(dest.waktu_tempuh) || 0;
            const waktuTempuhStr = formatWaktuTempuh(waktuTempuhMenit);
            const durasi = dest.durasi || 120;
            
            // Tampilkan jarak dan waktu tempuh jika ada (untuk semua destinasi termasuk yang pertama)
            const showDistanceInfo = jarakKm > 0 || waktuTempuhMenit > 0;
            
            html += `
                <div class="destinasi-item-card" data-dest-id="${dest.id}">
                    <div class="destinasi-time-col">
                        <div class="time-box">
                            ${waktuTibaStr} - ${waktuSelesaiStr}
                        </div>
                        ${showDistanceInfo ? `
                            <div class="distance-info">
                                <small>Jarak: ${jarakKm.toFixed(1)} km</small>
                            </div>
                            <div class="travel-time-info">
                                <i class="fas fa-clock"></i>
                                <small>Waktu tempuh: ${waktuTempuhStr}</small>
                            </div>
                        ` : ''}
                    </div>
                    <div class="destinasi-content-col">
                        <div class="destinasi-header">
                            <h5>${dest.nama}</h5>
                            <button type="button" class="btn-delete-destinasi" onclick="hapusDestinasi(${dest.id}, ${day.hari})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="destinasi-info">
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>${dest.alamat || '-'}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-star"></i>
                                <span>${dest.rating || 0}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-dollar-sign"></i>
                                <span>${dest.biaya === 0 || !dest.biaya ? 'Gratis' : 'Rp ' + parseFloat(dest.biaya).toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                        <div class="destinasi-durasi">
                            <label>Durasi:</label>
                            <select class="durasi-select" name="durasi_destinasi_${dest.id}" onchange="ubahDurasiDestinasi(${dest.id}, ${day.hari}, this.value)">
                                <option value="60" ${durasi == 60 ? 'selected' : ''}>1 jam</option>
                                <option value="90" ${durasi == 90 ? 'selected' : ''}>1.5 jam</option>
                                <option value="120" ${durasi == 120 ? 'selected' : ''}>2 jam</option>
                                <option value="180" ${durasi == 180 ? 'selected' : ''}>3 jam</option>
                                <option value="240" ${durasi == 240 ? 'selected' : ''}>4 jam</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += `
                </div>
                <div class="day-recommendations">
                    <button type="button" class="btn-recommendation" onclick="lihatRekomendasiMakanan(${day.hari})">
                        <i class="fas fa-utensils"></i> Rekomendasi Tempat Makan
                    </button>
                    <button type="button" class="btn-recommendation" onclick="lihatRekomendasiAkomodasi(${day.hari})">
                        <i class="fas fa-hotel"></i> Rekomendasi Akomodasi
                    </button>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    resultDiv.innerHTML = html;
    return html;
}

// Show step
function showStep(stepNumber, skipSave = false) {
    // Simpan perubahan sebelum pindah step (jika tidak di-skip)
    if (!skipSave) {
        const currentStep = getCurrentStep();
        if (currentStep === 1 && stepNumber !== 1) {
            saveStep1Changes();
        } else if (currentStep === 2 && stepNumber !== 2) {
            saveStep2Changes();
        }
    }
    
    // Hide all steps
    document.querySelectorAll('.step-content').forEach(step => {
        step.classList.remove('active');
    });
    
    // Show selected step
    const step = document.getElementById(`step${stepNumber}`);
    if (step) {
        step.classList.add('active');
    }
    
    // Update indicators
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
        if (index + 1 < stepNumber) {
            indicator.classList.add('completed');
            indicator.classList.remove('active');
        } else if (index + 1 === stepNumber) {
            indicator.classList.add('active');
            indicator.classList.remove('completed');
        } else {
            indicator.classList.remove('active', 'completed');
        }
    });
    
    // Load data ke step yang dituju (hanya jika tidak di-skip)
    if (!skipSave) {
        if (stepNumber === 1 && window.itineraryConfig) {
            setTimeout(() => {
                loadStep1FromConfig();
            }, 100);
        } else if (stepNumber === 2 && window.itineraryData) {
            setTimeout(() => {
                renderItineraryResult(window.itineraryData);
            }, 100);
        }
    }
    
    // If step 3, populate form
    if (stepNumber === 3 && window.itineraryData) {
        const previewDiv = document.getElementById('itineraryPreview');
        if (previewDiv && window.itineraryData) {
            let html = '<div class="itinerary-preview">';
            window.itineraryData.forEach(day => {
                html += `
                    <div class="day-itinerary" style="margin-bottom: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 12px;">
                        <h3 style="margin: 0 0 1rem 0; color: #0f172a; font-size: 1.3rem;">
                            Hari ${day.hari} - ${day.tanggal_formatted}
                        </h3>
                        <div class="destinasi-list">
                `;
                day.destinasi.forEach((dest, index) => {
                    html += `
                        <div class="destinasi-item" style="background: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #14b8a6;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                <h4 style="margin: 0; color: #0f172a; font-size: 1.1rem;">${dest.nama}</h4>
                                <span style="color: #64748b; font-size: 0.9rem;">
                                    <i class="fas fa-star" style="color: #f59e0b;"></i> ${dest.rating}
                                </span>
                            </div>
                            <p style="margin: 0 0 0.5rem 0; color: #64748b; font-size: 0.9rem;">
                                <i class="fas fa-map-marker-alt"></i> ${dest.alamat}
                            </p>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.5rem; font-size: 0.85rem; color: #64748b;">
                                <div><i class="fas fa-clock"></i> Mulai: <strong>${dest.waktu_mulai}</strong></div>
                                <div><i class="fas fa-clock"></i> Selesai: <strong>${dest.waktu_selesai}</strong></div>
                                <div><i class="fas fa-hourglass-half"></i> Durasi: <strong>${dest.durasi} menit</strong></div>
                                ${index > 0 ? `<div><i class="fas fa-route"></i> Jarak: <strong>${dest.jarak_dari_sebelumnya} km</strong></div>` : ''}
                                ${index > 0 ? `<div><i class="fas fa-car"></i> Waktu tempuh: <strong>${dest.waktu_tempuh} menit</strong></div>` : ''}
                            </div>
                        </div>
                    `;
                });
                html += '</div></div>';
            });
            html += '</div>';
            previewDiv.innerHTML = html;
        }
        
        // Set hidden fields - pastikan semua perubahan sudah tersimpan
        const dataInput = document.getElementById('itineraryData');
        const configInput = document.getElementById('itineraryConfig');
        
        // Simpan perubahan terakhir sebelum set hidden fields
        saveStep1Changes();
        saveStep2Changes();
        
        if (dataInput && window.itineraryData) {
            dataInput.value = JSON.stringify(window.itineraryData);
        }
        if (configInput && window.itineraryConfig) {
            configInput.value = JSON.stringify(window.itineraryConfig);
        }
    }
}

// ========== STEP 2 FUNCTIONS ==========

// Tambah destinasi (buka modal)
function tambahDestinasi() {
    const modal = document.getElementById('modalTambahDestinasi');
    const select = document.getElementById('selectDestinasiBaru');
    
    if (!modal || !select) return;
    
    // Get all selected destinasi IDs from current itinerary
    const selectedIds = new Set();
    if (window.itineraryData) {
        window.itineraryData.forEach(day => {
            day.destinasi.forEach(dest => {
                selectedIds.add(dest.id);
            });
        });
    }
    
    // Load available destinations (not yet selected)
    const route = document.querySelector('meta[name="destinations-route"]')?.content || 
                  '/wisatawan/itinerary/destinations';
    
    const lokasiWisata = document.getElementById('lokasiWisata')?.value || 'yogyakarta';
    const params = new URLSearchParams({
        lokasi: lokasiWisata,
        per_page: 100
    });
    
    fetch(`${route}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        select.innerHTML = '<option value="">-- Pilih Destinasi --</option>';
        
        data.data.forEach(dest => {
            if (!selectedIds.has(dest.id)) {
                const option = document.createElement('option');
                option.value = dest.id;
                option.textContent = `${dest.nama} - ${dest.alamat} (Rating: ${dest.rating})`;
                option.dataset.dest = JSON.stringify(dest);
                select.appendChild(option);
            }
        });
        
        if (select.options.length === 1) {
            select.innerHTML = '<option value="">Tidak ada destinasi tersedia</option>';
        }
    })
    .catch(error => {
        console.error('Error loading destinations:', error);
        select.innerHTML = '<option value="">Error memuat destinasi</option>';
    });
    
    modal.classList.remove('hidden');
}

// Tutup modal tambah destinasi
function tutupModalTambahDestinasi() {
    const modal = document.getElementById('modalTambahDestinasi');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Simpan destinasi baru
function simpanDestinasiBaru() {
    const select = document.getElementById('selectDestinasiBaru');
    if (!select || !select.value) {
        alert('Pilih destinasi terlebih dahulu');
        return;
    }
    
    const destData = JSON.parse(select.options[select.selectedIndex].dataset.dest);
    if (!destData) {
        alert('Data destinasi tidak valid');
        return;
    }
    
    if (!window.itineraryData || !window.itineraryConfig) {
        alert('Itinerary tidak ditemukan');
        return;
    }
    
    // Collect all destinasi IDs (existing + new)
    const allDestinasiIds = [];
    const destinasiDurasi = {};
    
    window.itineraryData.forEach(day => {
        day.destinasi.forEach(dest => {
            allDestinasiIds.push(dest.id);
            destinasiDurasi[dest.id] = dest.durasi || 120;
        });
    });
    
    // Add new destinasi ID
    allDestinasiIds.push(parseInt(destData.id));
    destinasiDurasi[destData.id] = 120; // Default durasi
    
    // Show loading
    const resultDiv = document.getElementById('itineraryResult');
    if (resultDiv) {
        resultDiv.innerHTML = '<div class="loading-state"><i class="fas fa-spinner fa-spin"></i><p>Mengoptimalkan ulang itinerary...</p></div>';
    }
    
    // Call reoptimize API
    const route = document.querySelector('meta[name="reoptimize-route"]')?.content || 
                  '/wisatawan/itinerary/reoptimize';
    
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
            tanggal_keberangkatan: window.itineraryConfig.tanggal_keberangkatan,
            jumlah_hari: window.itineraryConfig.jumlah_hari,
            waktu_mulai: window.itineraryConfig.waktu_mulai,
            lokasi_wisata: window.itineraryConfig.lokasi_wisata,
            jenis_jalur: window.itineraryConfig.jenis_jalur,
            start_lat: window.itineraryConfig.start_lat,
            start_lng: window.itineraryConfig.start_lng,
            destinasi_ids: allDestinasiIds,
            destinasi_durasi: destinasiDurasi
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.itineraryData = data.itinerary;
            window.itineraryConfig = data.config;
            renderItineraryResult(data.itinerary);
            tutupModalTambahDestinasi();
        } else {
            alert('Gagal mengoptimalkan ulang itinerary. Silakan coba lagi.');
        }
    })
    .catch(error => {
        console.error('Error reoptimizing itinerary:', error);
        alert('Terjadi kesalahan saat mengoptimalkan ulang itinerary. Silakan coba lagi.');
    });
}

// Hapus destinasi
function hapusDestinasi(destId, hari) {
    if (!confirm('Yakin ingin menghapus destinasi ini dari itinerary?')) {
        return;
    }
    
    if (!window.itineraryData || !window.itineraryConfig) return;
    
    // Collect all destinasi IDs (excluding the one to be deleted)
    const allDestinasiIds = [];
    const destinasiDurasi = {};
    
    window.itineraryData.forEach(day => {
        day.destinasi.forEach(dest => {
            if (dest.id !== destId) {
                allDestinasiIds.push(dest.id);
                destinasiDurasi[dest.id] = dest.durasi || 120;
            }
        });
    });
    
    if (allDestinasiIds.length === 0) {
        alert('Minimal harus ada 1 destinasi dalam itinerary');
        return;
    }
    
    // Show loading
    const resultDiv = document.getElementById('itineraryResult');
    if (resultDiv) {
        resultDiv.innerHTML = '<div class="loading-state"><i class="fas fa-spinner fa-spin"></i><p>Mengoptimalkan ulang itinerary...</p></div>';
    }
    
    // Call reoptimize API
    const route = document.querySelector('meta[name="reoptimize-route"]')?.content || 
                  '/wisatawan/itinerary/reoptimize';
    
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
            tanggal_keberangkatan: window.itineraryConfig.tanggal_keberangkatan,
            jumlah_hari: window.itineraryConfig.jumlah_hari,
            waktu_mulai: window.itineraryConfig.waktu_mulai,
            lokasi_wisata: window.itineraryConfig.lokasi_wisata,
            jenis_jalur: window.itineraryConfig.jenis_jalur,
            start_lat: window.itineraryConfig.start_lat,
            start_lng: window.itineraryConfig.start_lng,
            destinasi_ids: allDestinasiIds,
            destinasi_durasi: destinasiDurasi
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.itineraryData = data.itinerary;
            window.itineraryConfig = data.config;
            renderItineraryResult(data.itinerary);
        } else {
            alert('Gagal mengoptimalkan ulang itinerary. Silakan coba lagi.');
        }
    })
    .catch(error => {
        console.error('Error reoptimizing itinerary:', error);
        alert('Terjadi kesalahan saat mengoptimalkan ulang itinerary. Silakan coba lagi.');
    });
}

// Ubah durasi destinasi
function ubahDurasiDestinasi(destId, hari, durasiMenit) {
    if (!window.itineraryData || !window.itineraryConfig) return;
    
    const durasi = parseInt(durasiMenit);
    
    // Update durasi langsung ke window.itineraryData SEBELUM API call
    // Ini memastikan perubahan tersimpan meskipun user langsung pindah step
    window.itineraryData.forEach(day => {
        day.destinasi.forEach(dest => {
            if (dest.id === destId) {
                dest.durasi = durasi;
            }
        });
    });
    
    // Collect all destinasi IDs and durasi
    const allDestinasiIds = [];
    const destinasiDurasi = {};
    
    window.itineraryData.forEach(day => {
        day.destinasi.forEach(dest => {
            allDestinasiIds.push(dest.id);
            // Use durasi from window.itineraryData (already updated above)
            destinasiDurasi[dest.id] = dest.durasi || 120;
        });
    });
    
    // Show loading
    const resultDiv = document.getElementById('itineraryResult');
    if (resultDiv) {
        const loadingHtml = resultDiv.innerHTML;
        resultDiv.innerHTML = '<div class="loading-state"><i class="fas fa-spinner fa-spin"></i><p>Menghitung ulang jadwal...</p></div>';
    }
    
    // Call reoptimize API to recalculate schedule
    const route = document.querySelector('meta[name="reoptimize-route"]')?.content || 
                  '/wisatawan/itinerary/reoptimize';
    
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
            tanggal_keberangkatan: window.itineraryConfig.tanggal_keberangkatan,
            jumlah_hari: window.itineraryConfig.jumlah_hari,
            waktu_mulai: window.itineraryConfig.waktu_mulai,
            lokasi_wisata: window.itineraryConfig.lokasi_wisata,
            jenis_jalur: window.itineraryConfig.jenis_jalur,
            start_lat: window.itineraryConfig.start_lat,
            start_lng: window.itineraryConfig.start_lng,
            destinasi_ids: allDestinasiIds,
            destinasi_durasi: destinasiDurasi
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Simpan durasi yang sudah diubah sebelum update dari API
            const durasiMap = {};
            window.itineraryData.forEach(day => {
                day.destinasi.forEach(dest => {
                    durasiMap[dest.id] = dest.durasi;
                });
            });
            
            // Update dari API response
            window.itineraryData = data.itinerary;
            window.itineraryConfig = data.config;
            
            // Restore durasi yang sudah diubah user (jika ada)
            window.itineraryData.forEach(day => {
                day.destinasi.forEach(dest => {
                    if (durasiMap[dest.id] && durasiMap[dest.id] !== dest.durasi) {
                        // Jika user sudah mengubah durasi, gunakan durasi dari user
                        dest.durasi = durasiMap[dest.id];
                    }
                });
            });
            
            renderItineraryResult(window.itineraryData);
        } else {
            alert('Gagal menghitung ulang jadwal. Silakan coba lagi.');
        }
    })
    .catch(error => {
        console.error('Error recalculating schedule:', error);
        alert('Terjadi kesalahan saat menghitung ulang jadwal. Silakan coba lagi.');
    });
}

// Lihat rekomendasi makanan
function lihatRekomendasiMakanan(hari) {
    if (!window.itineraryData || !window.itineraryConfig) {
        alert('Data itinerary tidak ditemukan');
        return;
    }
    
    // Cari destinasi di hari tersebut untuk mendapatkan koordinat
    const dayData = window.itineraryData.find(d => d.hari === hari);
    if (!dayData || dayData.destinasi.length === 0) {
        alert('Tidak ada destinasi di hari ini');
        return;
    }
    
    // Ambil koordinat destinasi terakhir di hari tersebut (atau destinasi pertama)
    const lastDest = dayData.destinasi[dayData.destinasi.length - 1];
    const destLat = lastDest.lat;
    const destLng = lastDest.lng;
    
    // Buka modal
    const modal = document.getElementById('modalRekomendasiRestaurant');
    const loadingDiv = document.getElementById('restaurantLoading');
    const listDiv = document.getElementById('restaurantList');
    
    if (!modal || !loadingDiv || !listDiv) return;
    
    modal.classList.remove('hidden');
    loadingDiv.style.display = 'block';
    listDiv.innerHTML = '';
    
    // Panggil API
    const route = document.querySelector('meta[name="restaurant-recommendations-route"]')?.content || 
                  '/wisatawan/api/restaurant-recommendations';
    
    const params = new URLSearchParams({
        hari: hari,
        lokasi_wisata: window.itineraryConfig.lokasi_wisata,
        destinasi_lat: destLat,
        destinasi_lng: destLng,
        limit: 10
    });
    
    fetch(`${route}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        loadingDiv.style.display = 'none';
        
        if (data.success && data.data.length > 0) {
            let html = `<div class="recommendation-header"><p>Rekomendasi untuk <strong>Hari ${hari}</strong></p></div>`;
            
            data.data.forEach((restaurant, index) => {
                html += `
                    <div class="recommendation-item">
                        <div class="recommendation-number">${index + 1}</div>
                        <div class="recommendation-content">
                            <h5>${restaurant.nama}</h5>
                            <div class="recommendation-info">
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>${restaurant.alamat}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-star"></i>
                                    <span>${restaurant.rating || 0}</span>
                                </div>
                                ${restaurant.jarak !== null ? `
                                    <div class="info-item">
                                        <i class="fas fa-route"></i>
                                        <span>${restaurant.jarak.toFixed(1)} km</span>
                                    </div>
                                ` : ''}
                            </div>
                            ${restaurant.deskripsi ? `<p class="recommendation-desc">${restaurant.deskripsi}</p>` : ''}
                        </div>
                    </div>
                `;
            });
            
            listDiv.innerHTML = html;
        } else {
            listDiv.innerHTML = '<p style="text-align: center; color: var(--text-gray); padding: 2rem;">Tidak ada rekomendasi tempat makan tersedia.</p>';
        }
    })
    .catch(error => {
        console.error('Error loading restaurant recommendations:', error);
        loadingDiv.style.display = 'none';
        listDiv.innerHTML = '<p style="text-align: center; color: var(--error); padding: 2rem;">Terjadi kesalahan saat memuat rekomendasi.</p>';
    });
}

// Tutup modal rekomendasi restaurant
function tutupModalRekomendasiRestaurant() {
    const modal = document.getElementById('modalRekomendasiRestaurant');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Lihat rekomendasi akomodasi
function lihatRekomendasiAkomodasi(hari) {
    if (!window.itineraryData || !window.itineraryConfig) {
        alert('Data itinerary tidak ditemukan');
        return;
    }
    
    // Cari destinasi di hari tersebut untuk mendapatkan koordinat
    const dayData = window.itineraryData.find(d => d.hari === hari);
    if (!dayData || dayData.destinasi.length === 0) {
        alert('Tidak ada destinasi di hari ini');
        return;
    }
    
    // Ambil koordinat destinasi terakhir di hari tersebut (atau destinasi pertama)
    const lastDest = dayData.destinasi[dayData.destinasi.length - 1];
    const destLat = lastDest.lat;
    const destLng = lastDest.lng;
    
    // Buka modal
    const modal = document.getElementById('modalRekomendasiAkomodasi');
    const loadingDiv = document.getElementById('akomodasiLoading');
    const listDiv = document.getElementById('akomodasiList');
    
    if (!modal || !loadingDiv || !listDiv) return;
    
    modal.classList.remove('hidden');
    loadingDiv.style.display = 'block';
    listDiv.innerHTML = '';
    
    // Panggil API
    const route = document.querySelector('meta[name="akomodasi-recommendations-route"]')?.content || 
                  '/wisatawan/api/akomodasi-recommendations';
    
    const params = new URLSearchParams({
        hari: hari,
        lokasi_wisata: window.itineraryConfig.lokasi_wisata,
        destinasi_lat: destLat,
        destinasi_lng: destLng,
        limit: 10
    });
    
    fetch(`${route}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        loadingDiv.style.display = 'none';
        
        if (data.success && data.data.length > 0) {
            let html = `<div class="recommendation-header"><p>Rekomendasi untuk <strong>Hari ${hari}</strong></p></div>`;
            
            data.data.forEach((akomodasi, index) => {
                html += `
                    <div class="recommendation-item">
                        <div class="recommendation-number">${index + 1}</div>
                        <div class="recommendation-content">
                            <h5>${akomodasi.nama}</h5>
                            <div class="recommendation-info">
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>${akomodasi.alamat}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-star"></i>
                                    <span>${akomodasi.rating || 0}</span>
                                </div>
                                ${akomodasi.jarak !== null ? `
                                    <div class="info-item">
                                        <i class="fas fa-route"></i>
                                        <span>${akomodasi.jarak.toFixed(1)} km</span>
                                    </div>
                                ` : ''}
                            </div>
                            ${akomodasi.deskripsi ? `<p class="recommendation-desc">${akomodasi.deskripsi}</p>` : ''}
                        </div>
                    </div>
                `;
            });
            
            listDiv.innerHTML = html;
        } else {
            listDiv.innerHTML = '<p style="text-align: center; color: var(--text-gray); padding: 2rem;">Tidak ada rekomendasi akomodasi tersedia.</p>';
        }
    })
    .catch(error => {
        console.error('Error loading akomodasi recommendations:', error);
        loadingDiv.style.display = 'none';
        listDiv.innerHTML = '<p style="text-align: center; color: var(--error); padding: 2rem;">Terjadi kesalahan saat memuat rekomendasi.</p>';
    });
}

// Tutup modal rekomendasi akomodasi
function tutupModalRekomendasiAkomodasi() {
    const modal = document.getElementById('modalRekomendasiAkomodasi');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Prev step
// Simpan perubahan dari step 1 ke window.itineraryConfig
function saveStep1Changes() {
    if (!window.itineraryConfig) {
        window.itineraryConfig = {};
    }
    
    // Simpan semua field dari step 1
    const tanggalInput = document.getElementById('tanggalKeberangkatan');
    const jumlahHariSelect = document.getElementById('jumlahHari');
    const waktuMulaiInput = document.getElementById('waktuMulai');
    const lokasiWisataSelect = document.getElementById('lokasiWisata');
    const jenisJalurSelect = document.getElementById('jenisJalur');
    const minRatingInput = document.getElementById('minRating');
    
    if (tanggalInput) window.itineraryConfig.tanggal_keberangkatan = tanggalInput.value;
    if (jumlahHariSelect) window.itineraryConfig.jumlah_hari = parseInt(jumlahHariSelect.value);
    if (waktuMulaiInput) window.itineraryConfig.waktu_mulai = waktuMulaiInput.value;
    if (lokasiWisataSelect) window.itineraryConfig.lokasi_wisata = lokasiWisataSelect.value;
    if (jenisJalurSelect) window.itineraryConfig.jenis_jalur = jenisJalurSelect.value;
    if (minRatingInput) window.itineraryConfig.min_rating = parseFloat(minRatingInput.value) || 0;
    
    // Simpan kategori
    const kategoriCheckboxes = document.querySelectorAll('input[name="kategori[]"]:checked');
    window.itineraryConfig.kategori = Array.from(kategoriCheckboxes).map(cb => cb.value);
    
    // Simpan lokasi awal
    const useCurrentLocation = document.getElementById('useCurrentLocation');
    const usePopularLocation = document.getElementById('usePopularLocation');
    const lokasiPopulerSelect = document.getElementById('lokasiPopuler');
    
    if (useCurrentLocation && useCurrentLocation.checked && currentLocationData) {
        window.itineraryConfig.start_lat = currentLocationData.lat;
        window.itineraryConfig.start_lng = currentLocationData.lng;
    } else if (usePopularLocation && usePopularLocation.checked && lokasiPopulerSelect && lokasiPopulerSelect.value) {
        const lokasi = lokasiPopulerData[lokasiPopulerSelect.value];
        if (lokasi) {
            window.itineraryConfig.start_lat = lokasi.lat;
            window.itineraryConfig.start_lng = lokasi.lng;
        }
    }
}

// Simpan perubahan dari step 2 ke window.itineraryData
function saveStep2Changes() {
    if (!window.itineraryData) return;
    
    // Simpan durasi destinasi yang diubah dari semua select yang ada di DOM
    // Gunakan selector yang lebih fleksibel untuk menemukan semua select durasi
    const allDurasiSelects = document.querySelectorAll('select.durasi-select, select[name^="durasi_destinasi_"]');
    
    allDurasiSelects.forEach(select => {
        // Extract dest ID from name attribute
        const name = select.getAttribute('name');
        if (name && name.startsWith('durasi_destinasi_')) {
            const destId = parseInt(name.replace('durasi_destinasi_', ''));
            const durasi = parseInt(select.value) || 120;
            
            // Update window.itineraryData
            window.itineraryData.forEach(day => {
                day.destinasi.forEach(dest => {
                    if (dest.id === destId) {
                        dest.durasi = durasi;
                    }
                });
            });
        } else {
            // Fallback: cari berdasarkan onchange attribute
            const onchange = select.getAttribute('onchange');
            if (onchange) {
                const match = onchange.match(/ubahDurasiDestinasi\((\d+)/);
                if (match) {
                    const destId = parseInt(match[1]);
                    const durasi = parseInt(select.value) || 120;
                    
                    window.itineraryData.forEach(day => {
                        day.destinasi.forEach(dest => {
                            if (dest.id === destId) {
                                dest.durasi = durasi;
                            }
                        });
                    });
                }
            }
        }
    });
}

// Helper function untuk mendapatkan step saat ini
function getCurrentStep() {
    const activeStep = document.querySelector('.step-content.active');
    if (activeStep) {
        const stepId = activeStep.id;
        if (stepId === 'step1') return 1;
        if (stepId === 'step2') return 2;
        if (stepId === 'step3') return 3;
    }
    return 1;
}

// Load data dari window.itineraryConfig ke step 1
function loadStep1FromConfig() {
    if (!window.itineraryConfig) return;
    
    const tanggalInput = document.getElementById('tanggalKeberangkatan');
    const jumlahHariSelect = document.getElementById('jumlahHari');
    const waktuMulaiInput = document.getElementById('waktuMulai');
    const lokasiWisataSelect = document.getElementById('lokasiWisata');
    const jenisJalurSelect = document.getElementById('jenisJalur');
    const minRatingInput = document.getElementById('minRating');
    const ratingDisplay = document.getElementById('ratingDisplay');
    
    if (tanggalInput && window.itineraryConfig.tanggal_keberangkatan) {
        tanggalInput.value = window.itineraryConfig.tanggal_keberangkatan;
    }
    if (jumlahHariSelect && window.itineraryConfig.jumlah_hari) {
        jumlahHariSelect.value = window.itineraryConfig.jumlah_hari;
    }
    if (waktuMulaiInput && window.itineraryConfig.waktu_mulai) {
        waktuMulaiInput.value = window.itineraryConfig.waktu_mulai;
    }
    if (lokasiWisataSelect && window.itineraryConfig.lokasi_wisata) {
        lokasiWisataSelect.value = window.itineraryConfig.lokasi_wisata;
    }
    if (jenisJalurSelect && window.itineraryConfig.jenis_jalur) {
        jenisJalurSelect.value = window.itineraryConfig.jenis_jalur;
    }
    if (minRatingInput && window.itineraryConfig.min_rating !== undefined) {
        minRatingInput.value = window.itineraryConfig.min_rating;
        if (ratingDisplay) {
            ratingDisplay.textContent = parseFloat(window.itineraryConfig.min_rating).toFixed(1);
        }
    }
    
    // Load kategori
    if (window.itineraryConfig.kategori && Array.isArray(window.itineraryConfig.kategori)) {
        window.itineraryConfig.kategori.forEach(kode => {
            const checkbox = document.querySelector(`input[name="kategori[]"][value="${kode}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }
}

function prevStep(stepNumber) {
    // Simpan perubahan sebelum pindah step
    const currentStep = getCurrentStep();
    if (currentStep === 2) {
        saveStep2Changes();
    } else if (currentStep === 3) {
        saveStep2Changes(); // Step 3 juga perlu save step 2
    }
    
    // Panggil showStep dengan skipSave=false agar data di-load
    showStep(stepNumber, false);
}

// Next step
function nextStep(stepNumber) {
    // Simpan perubahan sebelum pindah step
    const currentStep = getCurrentStep();
    if (currentStep === 1) {
        saveStep1Changes();
    } else if (currentStep === 2) {
        saveStep2Changes();
    }
    
    // Panggil showStep dengan skipSave=false agar data di-load
    showStep(stepNumber, false);
}

// Format waktu tempuh dari menit ke string yang readable
function formatWaktuTempuh(menit) {
    if (!menit || menit === 0) {
        return '0 menit';
    }
    
    const jam = Math.floor(menit / 60);
    const sisaMenit = menit % 60;
    
    if (jam === 0) {
        return `${menit} menit`;
    } else if (sisaMenit === 0) {
        return `${jam} ${jam === 1 ? 'jam' : 'jam'}`;
    } else {
        return `${jam} ${jam === 1 ? 'jam' : 'jam'} ${sisaMenit} menit`;
    }
}

// Pre-fill data untuk edit mode
if (window.editModeData) {
    document.addEventListener('DOMContentLoaded', function() {
        const editData = window.editModeData;
        
        // Pre-fill step 1 fields (hanya jika belum terisi dari server-side)
        const tanggalInput = document.getElementById('tanggalKeberangkatan');
        const jumlahHariSelect = document.getElementById('jumlahHari');
        const waktuMulaiInput = document.getElementById('waktuMulai');
        const lokasiWisataSelect = document.getElementById('lokasiWisata');
        const jenisJalurSelect = document.getElementById('jenisJalur');
        const minRatingInput = document.getElementById('minRating');
        const ratingDisplay = document.getElementById('ratingDisplay');
        
        // Hanya set jika belum terisi (untuk memastikan data dari server-side tidak di-override)
        if (tanggalInput && editData.itineraryConfig.tanggal_keberangkatan && !tanggalInput.value) {
            tanggalInput.value = editData.itineraryConfig.tanggal_keberangkatan;
        }
        if (jumlahHariSelect && editData.itineraryConfig.jumlah_hari && !jumlahHariSelect.value) {
            jumlahHariSelect.value = editData.itineraryConfig.jumlah_hari;
        }
        if (waktuMulaiInput && editData.itineraryConfig.waktu_mulai && !waktuMulaiInput.value) {
            waktuMulaiInput.value = editData.itineraryConfig.waktu_mulai;
        }
        if (lokasiWisataSelect && editData.itineraryConfig.lokasi_wisata && !lokasiWisataSelect.value) {
            lokasiWisataSelect.value = editData.itineraryConfig.lokasi_wisata;
        }
        if (jenisJalurSelect && editData.itineraryConfig.jenis_jalur && !jenisJalurSelect.value) {
            jenisJalurSelect.value = editData.itineraryConfig.jenis_jalur;
        }
        if (minRatingInput && editData.itineraryConfig.min_rating !== undefined) {
            // Untuk rating, selalu update karena mungkin perlu sync dengan display
            minRatingInput.value = editData.itineraryConfig.min_rating;
            if (ratingDisplay) {
                ratingDisplay.textContent = parseFloat(editData.itineraryConfig.min_rating).toFixed(1);
            }
        }
        
        // Pre-fill kategori checkboxes (hanya yang belum checked)
        if (editData.itineraryConfig.kategori && Array.isArray(editData.itineraryConfig.kategori)) {
            editData.itineraryConfig.kategori.forEach(kode => {
                const checkbox = document.querySelector(`input[name="kategori[]"][value="${kode}"]`);
                if (checkbox && !checkbox.checked) {
                    checkbox.checked = true;
                }
            });
        }
        
        // Set lokasi awal (gunakan popular location jika ada start_lat dan start_lng)
        // Tunggu sebentar untuk memastikan DOM sudah ready dan server-side sudah terisi
        setTimeout(() => {
            const usePopularLocation = document.getElementById('usePopularLocation');
            const useCurrentLocation = document.getElementById('useCurrentLocation');
            const lokasiPopulerSelect = document.getElementById('lokasiPopuler');
            
            // Cek apakah sudah terisi dari server-side (radio button sudah checked)
            const isPopularAlreadySet = usePopularLocation && usePopularLocation.checked;
            const isCurrentAlreadySet = useCurrentLocation && useCurrentLocation.checked;
            
            // Jika sudah terisi dari server-side, hanya perlu enable/disable select dan set location data
            if (isPopularAlreadySet && lokasiPopulerSelect && lokasiPopulerSelect.value) {
                // Lokasi populer sudah terisi dari server-side
                handleLocationTypeChange();
                
                // Set location data berdasarkan value yang sudah terisi
                const selectedValue = lokasiPopulerSelect.value;
                if (lokasiPopulerData[selectedValue]) {
                    const lokasi = lokasiPopulerData[selectedValue];
                    currentLocationData = {
                        lat: lokasi.lat,
                        lng: lokasi.lng,
                        name: lokasi.name,
                        address: lokasi.address
                    };
                    
                    // Update selected location info
                    const infoDiv = document.getElementById('selectedLocationInfo');
                    const nameSpan = document.getElementById('selectedLocationName');
                    const addressSpan = document.getElementById('selectedLocationAddress');
                    if (infoDiv) infoDiv.classList.add('show');
                    if (nameSpan) nameSpan.textContent = lokasi.name;
                    if (addressSpan) addressSpan.textContent = lokasi.address;
                }
            } else if (isCurrentAlreadySet) {
                // Current location sudah terisi dari server-side
                handleLocationTypeChange();
                
                // Set location data dari config
                if (editData.itineraryConfig.start_lat && editData.itineraryConfig.start_lng) {
                    currentLocationData = {
                        lat: editData.itineraryConfig.start_lat,
                        lng: editData.itineraryConfig.start_lng
                    };
                }
            } else if (editData.itineraryConfig.start_lat && editData.itineraryConfig.start_lng) {
                // Belum terisi dari server-side, cek apakah cocok dengan lokasi populer
                let foundPopular = false;
                for (const key in lokasiPopulerData) {
                    const lokasi = lokasiPopulerData[key];
                    if (Math.abs(lokasi.lat - editData.itineraryConfig.start_lat) < 0.01 &&
                        Math.abs(lokasi.lng - editData.itineraryConfig.start_lng) < 0.01) {
                        if (lokasiPopulerSelect && usePopularLocation) {
                            // Set value
                            lokasiPopulerSelect.value = key;
                            
                            // Set radio button
                            usePopularLocation.checked = true;
                            if (useCurrentLocation) useCurrentLocation.checked = false;
                            
                            // Panggil handleLocationTypeChange untuk enable select
                            handleLocationTypeChange();
                            
                            // Update selected location info
                            const infoDiv = document.getElementById('selectedLocationInfo');
                            const nameSpan = document.getElementById('selectedLocationName');
                            const addressSpan = document.getElementById('selectedLocationAddress');
                            if (infoDiv) infoDiv.classList.add('show');
                            if (nameSpan) nameSpan.textContent = lokasi.name;
                            if (addressSpan) addressSpan.textContent = lokasi.address;
                            
                            // Set location data
                            currentLocationData = {
                                lat: lokasi.lat,
                                lng: lokasi.lng,
                                name: lokasi.name,
                                address: lokasi.address
                            };
                            
                            foundPopular = true;
                            break;
                        }
                    }
                }
                
                // Jika tidak cocok dengan lokasi populer, gunakan current location
                if (!foundPopular && useCurrentLocation) {
                    useCurrentLocation.checked = true;
                    if (usePopularLocation) usePopularLocation.checked = false;
                    handleLocationTypeChange();
                    
                    currentLocationData = {
                        lat: editData.itineraryConfig.start_lat,
                        lng: editData.itineraryConfig.start_lng
                    };
                }
            }
        }, 300);
        
        // Pre-fill step 2 dengan data itinerary
        if (editData.itineraryData && editData.itineraryData.length > 0) {
            window.itineraryData = editData.itineraryData;
            window.itineraryConfig = editData.itineraryConfig;
            
            // Render itinerary result
            renderItineraryResult(editData.itineraryData);
            
            // Auto move to step 2
            setTimeout(() => {
                showStep(2);
            }, 500);
        }
    });
}

