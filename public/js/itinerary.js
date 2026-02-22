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
            showStep(2);
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
    
    const tanggal = document.getElementById('tanggalKeberangkatan').value;
    const jumlahHari = document.getElementById('jumlahHari').value;
    const waktuMulai = document.getElementById('waktuMulai').value;
    const lokasiWisata = document.getElementById('lokasiWisata').value;
    const minRating = document.getElementById('minRating').value || 0;
    const jenisJalur = document.getElementById('jenisJalur').value;
    const kategori = Array.from(document.querySelectorAll('input[name="kategori[]"]:checked')).map(cb => cb.value);
    
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
    
    let html = '<div class="itinerary-result">';
    
    itinerary.forEach(day => {
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
        
        html += `
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    resultDiv.innerHTML = html;
    return html;
}

// Show step
function showStep(stepNumber) {
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
        
        // Set hidden fields
        const dataInput = document.getElementById('itineraryData');
        const configInput = document.getElementById('itineraryConfig');
        if (dataInput) dataInput.value = JSON.stringify(window.itineraryData);
        if (configInput) configInput.value = JSON.stringify(window.itineraryConfig);
    }
}

