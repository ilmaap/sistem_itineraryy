<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($paket) ? 'Edit' : 'Tambah' }} Paket - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paketkelolaadmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')
    
    @php
        $destinasiArray = isset($destinasi) && $destinasi ? $destinasi->toArray() : [];
        $destinasiCount = isset($paket) && $paket && $paket->destinasi && $paket->destinasi->count() > 0 ? $paket->destinasi->count() : 0;
    @endphp
    <div id="destinasi-data" 
         data-destinasi='{!! json_encode($destinasiArray) !!}' 
         data-count="{{ $destinasiCount }}" 
         style="display: none;"></div>

    <div class="content-wrapper">
        <div class="paket-form-container">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-box"></i> {{ isset($paket) ? 'Edit' : 'Tambah' }} Paket Wisata
                </h1>
                <h4 class="page-subtitle">{{ isset($paket) ? 'Ubah informasi paket wisata' : 'Tambahkan paket wisata baru' }}</h4>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-container">
                <form action="{{ isset($paket) ? route('admin.paket.update', $paket->id) : route('admin.paket.store') }}" method="POST" enctype="multipart/form-data" id="paketForm" onsubmit="return validateDestinasiPerHari(event)">
                    @csrf
                    @if (isset($paket))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="nama">
                            <i class="fas fa-tag"></i> Nama Paket <span style="color: #e53e3e;">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            class="form-control" 
                            required 
                            value="{{ old('nama', $paket->nama ?? '') }}"
                            placeholder="Masukkan nama paket wisata"
                        >
                    </div>

                    <div class="form-group">
                        <label for="image">
                            <i class="fas fa-image"></i> Gambar Paket <span style="color: #e53e3e;">*</span>
                        </label>
                        <div class="image-upload-container">
                            <input 
                                type="file" 
                                id="image" 
                                name="image" 
                                class="form-control-file" 
                                accept="image/*"
                                @if (!isset($paket)) required @endif
                                onchange="previewImage(this)"
                            >
                            <p class="image-hint">Ukuran gambar yang direkomendasikan: 1200x800px. Format: JPG, PNG, atau WEBP</p>
                            
                            <!-- Preview gambar yang sudah ada (saat edit) -->
                            @if(isset($paket) && $paket->image)
                                <div class="image-preview" id="existing-preview" style="margin-top: 1rem;">
                                    <p style="color: #718096; font-size: 0.875rem; margin-bottom: 0.5rem;">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $paket->image) }}" alt="Preview" id="existing-image" style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); object-fit: cover;">
                                </div>
                            @endif
                            
                            <!-- Preview gambar baru yang dipilih -->
                            <div class="image-preview" id="new-preview" style="margin-top: 1rem; display: none;">
                                <p style="color: #718096; font-size: 0.875rem; margin-bottom: 0.5rem;">Preview gambar baru:</p>
                                <img id="preview-img" src="" alt="Preview" style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="durasi">
                                <i class="fas fa-calendar-day"></i> Durasi (Hari) <span style="color: #e53e3e;">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="durasi" 
                                name="durasi" 
                                class="form-control" 
                                required 
                                min="1"
                                value="{{ old('durasi', $paket->durasi ?? '') }}"
                                placeholder="Contoh: 3"
                                onchange="updateHariMax()"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Berapa hari durasi paket wisata (akan mempengaruhi maksimal hari destinasi)</small>
                        </div>

                        <div class="form-group">
                            <label for="harga">
                                <i class="fas fa-money-bill-wave"></i> Harga <span style="color: #e53e3e;">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="harga" 
                                name="harga" 
                                class="form-control" 
                                required 
                                step="0.01"
                                min="0"
                                value="{{ old('harga', $paket->harga ?? '') }}"
                                placeholder="Contoh: 1500000"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Harga paket wisata (Rp)</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">
                            <i class="fas fa-align-left"></i> Deskripsi
                        </label>
                        <textarea 
                            id="deskripsi" 
                            name="deskripsi" 
                            class="form-control" 
                            rows="5"
                            placeholder="Masukkan deskripsi lengkap tentang paket wisata"
                        >{{ old('deskripsi', $paket->deskripsi ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-map-marked-alt"></i> Destinasi Wisata
                        </label>
                        <div id="destinasi-error" style="display: none; background: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 0.75rem; border: 1px solid #fecaca;">
                            <i class="fas fa-exclamation-circle"></i> <span id="destinasi-error-message"></span>
                        </div>
                        <div class="destinasi-selection-container">
                            <div id="destinasi-list">
                                @if(isset($paket) && $paket->destinasi->count() > 0)
                                    @foreach($paket->destinasi as $index => $dest)
                                        <div class="destinasi-item" data-index="{{ $index }}">
                                            <div style="display: flex; flex-direction: column; flex: 1;">
                                                <label style="font-size: 0.75rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem; white-space: nowrap;">Pilih Destinasi</label>
                                                <div class="searchable-select-wrapper">
                                                    <input type="hidden" name="destinasi[]" class="destinasi-hidden-input" value="{{ $dest->id }}" required>
                                                    <div class="searchable-select">
                                                        <div class="select-display" onclick="toggleSelect(this)">
                                                            <span class="select-text">{{ $dest->nama }} ({{ $dest->kategori }})</span>
                                                            <i class="fas fa-chevron-down select-arrow"></i>
                                                        </div>
                                                        <div class="select-dropdown">
                                                            <div class="select-search">
                                                                <i class="fas fa-search"></i>
                                                                <input type="text" class="select-search-input" placeholder="Cari destinasi..." onkeyup="filterDestinasi(this)">
                                                            </div>
                                                            <div class="select-options">
                                                                <div class="select-option" data-value="" onclick="selectDestinasi(this, '')">Pilih Destinasi</div>
                                                                @foreach($destinasi as $d)
                                                                    <div class="select-option {{ $d->id == $dest->id ? 'selected' : '' }}" 
                                                                         data-value="{{ $d->id }}" 
                                                                         data-text="{{ $d->nama }} ({{ $d->kategori }})"
                                                                         onclick="selectDestinasi(this, '{{ $d->id }}', '{{ $d->nama }} ({{ $d->kategori }})')">
                                                                        <strong>{{ $d->nama }}</strong> <span style="color: #718096;">({{ $d->kategori }})</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: flex; flex-direction: column; min-width: 100px;">
                                                <label style="font-size: 0.75rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem; white-space: nowrap;">Hari Ke-</label>
                                                <input type="number" name="hari[]" class="form-control hari-input" 
                                                       value="{{ $dest->pivot->order ?? 1 }}" 
                                                       placeholder="1" min="1" max="{{ $paket->durasi ?? 1 }}" 
                                                       style="width: 100px;" required onchange="checkDestinasiPerHari()">
                                            </div>
                                            <button type="button" class="btn-remove-destinasi" onclick="removeDestinasi(this)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    @if(isset($destinasi) && $destinasi->count() > 0)
                                        <div class="destinasi-item" data-index="0">
                                            <div style="display: flex; flex-direction: column; flex: 1;">
                                                <label style="font-size: 0.75rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem; white-space: nowrap;">Pilih Destinasi</label>
                                                <div class="searchable-select-wrapper">
                                                    <input type="hidden" name="destinasi[]" class="destinasi-hidden-input" value="">
                                                    <div class="searchable-select">
                                                        <div class="select-display" onclick="toggleSelect(this)">
                                                            <span class="select-text">Pilih Destinasi</span>
                                                            <i class="fas fa-chevron-down select-arrow"></i>
                                                        </div>
                                                        <div class="select-dropdown">
                                                            <div class="select-search">
                                                                <i class="fas fa-search"></i>
                                                                <input type="text" class="select-search-input" placeholder="Cari destinasi..." onkeyup="filterDestinasi(this)">
                                                            </div>
                                                            <div class="select-options">
                                                                <div class="select-option" data-value="" onclick="selectDestinasi(this, '')">Pilih Destinasi</div>
                                                                @foreach($destinasi as $d)
                                                                    <div class="select-option" 
                                                                         data-value="{{ $d->id }}" 
                                                                         data-text="{{ $d->nama }} ({{ $d->kategori }})"
                                                                         onclick="selectDestinasi(this, '{{ $d->id }}', '{{ $d->nama }} ({{ $d->kategori }})')">
                                                                        <strong>{{ $d->nama }}</strong> <span style="color: #718096;">({{ $d->kategori }})</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: flex; flex-direction: column; min-width: 100px;">
                                                <label style="font-size: 0.75rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem; white-space: nowrap;">Hari Ke-</label>
                                                <input type="number" name="hari[]" class="form-control hari-input" 
                                                       value="1" placeholder="1" min="1" 
                                                       max="{{ isset($paket) ? $paket->durasi : 1 }}" 
                                                       style="width: 100px;" required onchange="checkDestinasiPerHari()">
                                            </div>
                                            <button type="button" class="btn-remove-destinasi" onclick="removeDestinasi(this)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @else
                                        <p style="color: #718096; font-size: 0.875rem;">Belum ada destinasi yang tersedia. Silakan tambahkan destinasi terlebih dahulu.</p>
                                    @endif
                                @endif
                            </div>
                            <button type="button" class="btn-add-destinasi" onclick="addDestinasi()">
                                <i class="fas fa-plus"></i> Tambah Destinasi
                            </button>
                        </div>
                        <small style="color: #718096; font-size: 0.875rem;">Pilih destinasi yang akan termasuk dalam paket wisata dan tentukan hari kunjungannya. Maksimal 4 destinasi per hari. Urutan otomatis mengikuti urutan input.</small>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ isset($paket) ? 'Update Paket' : 'Simpan Paket' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const newPreview = document.getElementById('new-preview');
            const existingPreview = document.getElementById('existing-preview');
            const previewImg = document.getElementById('preview-img');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    newPreview.style.display = 'block';
                    
                    // Sembunyikan preview gambar lama jika ada
                    if (existingPreview) {
                        existingPreview.style.display = 'none';
                    }
                };
                
                reader.readAsDataURL(input.files[0]);
            } else {
                newPreview.style.display = 'none';
                
                // Tampilkan kembali preview gambar lama jika ada
                if (existingPreview) {
                    existingPreview.style.display = 'block';
                }
            }
        }

        // Destinasi Management
        const destinasiDataEl = document.getElementById('destinasi-data');
        const destinasiOptions = destinasiDataEl ? JSON.parse(destinasiDataEl.getAttribute('data-destinasi') || '[]') : [];
        let destinasiIndex = destinasiDataEl ? parseInt(destinasiDataEl.getAttribute('data-count') || '0') : 0;

        // Fungsi untuk mendapatkan daftar ID destinasi yang sudah dipilih (kecuali yang sedang diedit)
        function getSelectedDestinasiIds(excludeWrapper = null) {
            const selectedIds = [];
            const allItems = document.querySelectorAll('.destinasi-item');
            
            allItems.forEach(item => {
                const wrapper = item.querySelector('.searchable-select-wrapper');
                // Skip jika ini adalah wrapper yang sedang diedit
                if (excludeWrapper && wrapper === excludeWrapper) {
                    return;
                }
                
                const hiddenInput = wrapper.querySelector('.destinasi-hidden-input');
                if (hiddenInput && hiddenInput.value) {
                    selectedIds.push(parseInt(hiddenInput.value));
                }
            });
            
            return selectedIds;
        }

        // Fungsi untuk update visibility destinasi di semua dropdown
        function updateDestinasiVisibility(excludeWrapper = null) {
            const selectedIds = getSelectedDestinasiIds(excludeWrapper);
            const allDropdowns = document.querySelectorAll('.select-dropdown');
            
            allDropdowns.forEach(dropdown => {
                const wrapper = dropdown.closest('.searchable-select-wrapper');
                // Skip jika ini adalah wrapper yang sedang diedit
                if (excludeWrapper && wrapper === excludeWrapper) {
                    return;
                }
                
                const options = dropdown.querySelectorAll('.select-option[data-value]');
                options.forEach(option => {
                    const value = option.getAttribute('data-value');
                    if (value && selectedIds.includes(parseInt(value))) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        }

        function addDestinasi() {
            const destinasiList = document.getElementById('destinasi-list');
            if (!destinasiList) {
                console.error('Element destinasi-list tidak ditemukan');
                return;
            }

            const newItem = document.createElement('div');
            newItem.className = 'destinasi-item';
            newItem.setAttribute('data-index', destinasiIndex);
            
            // Get durasi paket untuk max hari
            const durasiInput = document.getElementById('durasi');
            const durasiPaket = durasiInput ? parseInt(durasiInput.value) || 1 : 1;
            
            // Get destinasi yang sudah dipilih (kecuali yang baru ditambahkan)
            const selectedIds = getSelectedDestinasiIds();
            
            let optionsHtml = '<div class="select-option" data-value="" onclick="selectDestinasi(this, \'\')">Pilih Destinasi</div>';
            if (destinasiOptions && Array.isArray(destinasiOptions) && destinasiOptions.length > 0) {
                destinasiOptions.forEach(dest => {
                    if (dest && dest.id && dest.nama) {
                        // Skip destinasi yang sudah dipilih
                        if (selectedIds.includes(parseInt(dest.id))) {
                            return;
                        }
                        const text = `${dest.nama} (${dest.kategori || ''})`;
                        optionsHtml += `<div class="select-option" data-value="${dest.id}" data-text="${text}" onclick="selectDestinasi(this, '${dest.id}', '${text}')"><strong>${dest.nama}</strong> <span style="color: #718096;">(${dest.kategori || ''})</span></div>`;
                    }
                });
            }
            
            newItem.innerHTML = `
                <div style="display: flex; flex-direction: column; flex: 1;">
                    <label style="font-size: 0.75rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem; white-space: nowrap;">Pilih Destinasi</label>
                    <div class="searchable-select-wrapper">
                        <input type="hidden" name="destinasi[]" class="destinasi-hidden-input" value="">
                        <div class="searchable-select">
                            <div class="select-display" onclick="toggleSelect(this)">
                                <span class="select-text">Pilih Destinasi</span>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                            <div class="select-dropdown">
                                <div class="select-search">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="select-search-input" placeholder="Cari destinasi..." onkeyup="filterDestinasi(this)">
                                </div>
                                <div class="select-options">
                                    ${optionsHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; min-width: 100px;">
                    <label style="font-size: 0.75rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem; white-space: nowrap;">Hari Ke-</label>
                    <input type="number" name="hari[]" class="form-control hari-input" 
                           value="1" placeholder="1" min="1" max="${durasiPaket}" 
                           style="width: 100px;" required onchange="checkDestinasiPerHari()">
                </div>
                <button type="button" class="btn-remove-destinasi" onclick="removeDestinasi(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            destinasiList.appendChild(newItem);
            destinasiIndex++;
            
            // Validasi setelah menambahkan destinasi
            setTimeout(checkDestinasiPerHari, 100);
        }

        function removeDestinasi(button) {
            if (!button) {
                console.error('Button parameter tidak valid');
                return;
            }

            const destinasiList = document.getElementById('destinasi-list');
            if (!destinasiList) {
                console.error('Element destinasi-list tidak ditemukan');
                return;
            }

            const items = destinasiList.querySelectorAll('.destinasi-item');
            
            // Jangan hapus jika hanya tersisa 1 item
            if (items.length > 1) {
                const itemToRemove = button.closest('.destinasi-item');
                if (itemToRemove) {
                    itemToRemove.remove();
                    // Update visibility setelah menghapus
                    updateDestinasiVisibility();
                }
            } else if (items.length === 1) {
                // Reset item terakhir
                const lastItem = items[0];
                const hiddenInput = lastItem.querySelector('.destinasi-hidden-input');
                const selectText = lastItem.querySelector('.select-text');
                const hariInput = lastItem.querySelector('.hari-input');
                
                if (hiddenInput) {
                    hiddenInput.value = '';
                }
                if (selectText) {
                    selectText.textContent = 'Pilih Destinasi';
                }
                if (hariInput) {
                    hariInput.value = '1';
                }
                // Update visibility setelah reset
                updateDestinasiVisibility();
            }
            
            // Validasi setelah menghapus destinasi
            setTimeout(checkDestinasiPerHari, 100);
        }

        function toggleSelect(element) {
            const wrapper = element.closest('.searchable-select-wrapper');
            const dropdown = wrapper.querySelector('.select-dropdown');
            const allDropdowns = document.querySelectorAll('.select-dropdown');
            
            // Close all other dropdowns
            allDropdowns.forEach(dd => {
                if (dd !== dropdown) {
                    dd.classList.remove('active');
                }
            });
            
            dropdown.classList.toggle('active');
            
            // Update visibility destinasi saat dropdown dibuka
            if (dropdown.classList.contains('active')) {
                updateDestinasiVisibility(wrapper);
                
                // Focus search input when opened
                const searchInput = dropdown.querySelector('.select-search-input');
                if (searchInput) {
                    setTimeout(() => searchInput.focus(), 100);
                }
            }
        }

        function filterDestinasi(input) {
            const searchTerm = input.value.toLowerCase();
            const dropdown = input.closest('.select-dropdown');
            const wrapper = dropdown.closest('.searchable-select-wrapper');
            const options = dropdown.querySelectorAll('.select-option');
            const selectedIds = getSelectedDestinasiIds(wrapper);
            
            options.forEach(option => {
                const value = option.getAttribute('data-value');
                const text = option.textContent.toLowerCase();
                
                // Sembunyikan jika sudah dipilih di dropdown lain
                if (value && selectedIds.includes(parseInt(value))) {
                    option.style.display = 'none';
                } else if (text.includes(searchTerm)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        }

        function selectDestinasi(element, value, text) {
            const wrapper = element.closest('.searchable-select-wrapper');
            const hiddenInput = wrapper.querySelector('.destinasi-hidden-input');
            const selectText = wrapper.querySelector('.select-text');
            const dropdown = wrapper.querySelector('.select-dropdown');
            const searchInput = dropdown.querySelector('.select-search-input');
            
            // Simpan nilai lama untuk update visibility
            const oldValue = hiddenInput ? hiddenInput.value : null;
            
            // Update hidden input
            if (hiddenInput) {
                hiddenInput.value = value;
            }
            
            // Update display text
            if (selectText) {
                selectText.textContent = text || 'Pilih Destinasi';
            }
            
            // Remove selected class from all options
            dropdown.querySelectorAll('.select-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Add selected class to current option
            if (value) {
                element.classList.add('selected');
            }
            
            // Close dropdown
            dropdown.classList.remove('active');
            
            // Clear search
            if (searchInput) {
                searchInput.value = '';
                filterDestinasi(searchInput);
            }
            
            // Update visibility: sembunyikan destinasi yang baru dipilih, tampilkan yang lama jika ada
            updateDestinasiVisibility();
            
            // Validasi setelah memilih destinasi
            setTimeout(checkDestinasiPerHari, 100);
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.searchable-select-wrapper')) {
                document.querySelectorAll('.select-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });

        function updateHariMax() {
            const durasiInput = document.getElementById('durasi');
            if (!durasiInput) {
                return;
            }

            const durasi = parseInt(durasiInput.value) || 1;
            const hariInputs = document.querySelectorAll('.hari-input');
            
            hariInputs.forEach(input => {
                if (input) {
                    const currentValue = parseInt(input.value) || 1;
                    input.setAttribute('max', durasi);
                    if (currentValue > durasi) {
                        input.value = durasi;
                    }
                }
            });
            
            // Validasi ulang setelah update durasi
            checkDestinasiPerHari();
        }

        // Fungsi untuk mengecek jumlah destinasi per hari
        function checkDestinasiPerHari() {
            const destinasiItems = document.querySelectorAll('.destinasi-item');
            const destinasiPerHari = {};
            const errorElement = document.getElementById('destinasi-error');
            const errorMessage = document.getElementById('destinasi-error-message');
            
            // Reset error
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            
            // Hitung destinasi per hari
            destinasiItems.forEach(item => {
                const hiddenInput = item.querySelector('.destinasi-hidden-input');
                const hariInput = item.querySelector('.hari-input');
                
                if (hiddenInput && hariInput && hiddenInput.value) {
                    const hari = parseInt(hariInput.value) || 1;
                    if (!destinasiPerHari[hari]) {
                        destinasiPerHari[hari] = 0;
                    }
                    destinasiPerHari[hari]++;
                }
            });
            
            // Cek apakah ada hari yang melebihi 4 destinasi
            for (const [hari, count] of Object.entries(destinasiPerHari)) {
                if (count > 4) {
                    if (errorElement && errorMessage) {
                        errorElement.style.display = 'block';
                        errorMessage.textContent = `Hari ke-${hari} memiliki ${count} destinasi. Maksimal 4 destinasi per hari.`;
                    }
                    return false;
                }
            }
            
            return true;
        }

        // Validasi sebelum submit form
        function validateDestinasiPerHari(event) {
            if (!checkDestinasiPerHari()) {
                event.preventDefault();
                // Scroll ke error message
                const errorElement = document.getElementById('destinasi-error');
                if (errorElement) {
                    errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return false;
            }
            return true;
        }

        // Initialize updateHariMax saat durasi berubah
        document.addEventListener('DOMContentLoaded', function() {
            const durasiInput = document.getElementById('durasi');
            if (durasiInput) {
                durasiInput.addEventListener('change', updateHariMax);
            }
            
            // Validasi saat input hari berubah
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('hari-input')) {
                    checkDestinasiPerHari();
                }
            });
            
            // Validasi saat destinasi dipilih
            document.addEventListener('click', function(e) {
                if (e.target.closest('.select-option') && e.target.closest('.select-option').getAttribute('data-value')) {
                    setTimeout(checkDestinasiPerHari, 100);
                }
            });
            
            // Update visibility saat halaman dimuat (untuk edit paket)
            updateDestinasiVisibility();
        });
    </script>
</body>
</html>

