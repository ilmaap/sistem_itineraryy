<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($destinasi) ? 'Edit' : 'Tambah' }} Destinasi - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/destinasikelolaadmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="content-wrapper">
        <div class="destinasi-form-container">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-map-marked-alt"></i> {{ isset($destinasi) ? 'Edit' : 'Tambah' }} Destinasi
                </h1>
                <h4 class="page-subtitle">{{ isset($destinasi) ? 'Ubah informasi destinasi wisata' : 'Tambahkan destinasi wisata baru' }}</h4>
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
                <form action="{{ isset($destinasi) ? route('admin.destinasi.update', $destinasi->id) : route('admin.destinasi.store') }}" method="POST">
                    @csrf
                    @if (isset($destinasi))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="nama">
                            <i class="fas fa-map-marker-alt"></i> Nama Destinasi <span style="color: #e53e3e;">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            class="form-control" 
                            required 
                            value="{{ old('nama', $destinasi->nama ?? '') }}"
                            placeholder="Masukkan nama destinasi"
                        >
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="kategori">
                                <i class="fas fa-tags"></i> Kategori <span style="color: #e53e3e;">*</span>
                            </label>
                            <select id="kategori" name="kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Wisata Alam" {{ old('kategori', $destinasi->kategori ?? '') === 'Wisata Alam' ? 'selected' : '' }}>Wisata Alam</option>
                                <option value="Wisata Buatan" {{ old('kategori', $destinasi->kategori ?? '') === 'Wisata Buatan' ? 'selected' : '' }}>Wisata Buatan</option>
                                <option value="Wisata Budaya" {{ old('kategori', $destinasi->kategori ?? '') === 'Wisata Budaya' ? 'selected' : '' }}>Wisata Budaya</option>
                                <option value="Wisata Minat Khusus" {{ old('kategori', $destinasi->kategori ?? '') === 'Wisata Minat Khusus' ? 'selected' : '' }}>Wisata Minat Khusus</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="lokasi">
                                <i class="fas fa-map"></i> Lokasi <span style="color: #e53e3e;">*</span>
                            </label>
                            <select id="lokasi" name="lokasi" class="form-control" required>
                                <option value="">Pilih Lokasi</option>
                                <option value="solo" {{ old('lokasi', $destinasi->lokasi ?? '') === 'solo' ? 'selected' : '' }}>Solo</option>
                                <option value="yogyakarta" {{ old('lokasi', $destinasi->lokasi ?? '') === 'yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">
                            <i class="fas fa-location-dot"></i> Alamat <span style="color: #e53e3e;">*</span>
                        </label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            class="form-control" 
                            required 
                            rows="3"
                            placeholder="Masukkan alamat lengkap destinasi"
                        >{{ old('alamat', $destinasi->alamat ?? '') }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="latitude">
                                <i class="fas fa-globe"></i> Latitude <span style="color: #e53e3e;">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="latitude" 
                                name="latitude" 
                                class="form-control" 
                                required 
                                step="0.00000001"
                                value="{{ old('latitude', $destinasi->latitude ?? '') }}"
                                placeholder="Contoh: -7.565278"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Format: decimal (10,8)</small>
                        </div>

                        <div class="form-group">
                            <label for="longitude">
                                <i class="fas fa-globe"></i> Longitude <span style="color: #e53e3e;">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="longitude" 
                                name="longitude" 
                                class="form-control" 
                                required 
                                step="0.00000001"
                                value="{{ old('longitude', $destinasi->longitude ?? '') }}"
                                placeholder="Contoh: 110.814167"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Format: decimal (11,8)</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="jam_buka">
                                <i class="fas fa-clock"></i> Jam Buka
                            </label>
                            <input 
                                type="time" 
                                id="jam_buka" 
                                name="jam_buka" 
                                class="form-control" 
                                value="{{ old('jam_buka', $destinasi->jam_buka ?? '') }}"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Waktu buka destinasi (opsional)</small>
                        </div>

                        <div class="form-group">
                            <label for="jam_tutup">
                                <i class="fas fa-clock"></i> Jam Tutup
                            </label>
                            <input 
                                type="time" 
                                id="jam_tutup" 
                                name="jam_tutup" 
                                class="form-control" 
                                value="{{ old('jam_tutup', $destinasi->jam_tutup ?? '') }}"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Waktu tutup destinasi (opsional)</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="rating">
                                <i class="fas fa-star"></i> Rating
                            </label>
                            <input 
                                type="number" 
                                id="rating" 
                                name="rating" 
                                class="form-control" 
                                step="0.01"
                                min="0"
                                max="5"
                                value="{{ old('rating', $destinasi->rating ?? '') }}"
                                placeholder="0.00 - 5.00"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Skala 0.00 sampai 5.00</small>
                        </div>

                        <div class="form-group">
                            <label for="biaya">
                                <i class="fas fa-money-bill-wave"></i> Biaya
                            </label>
                            <input 
                                type="number" 
                                id="biaya" 
                                name="biaya" 
                                class="form-control" 
                                step="0.01"
                                min="0"
                                value="{{ old('biaya', $destinasi->biaya ?? '') }}"
                                placeholder="Masukkan biaya masuk (Rp)"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Biaya masuk destinasi (opsional)</small>
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
                            placeholder="Masukkan deskripsi lengkap tentang destinasi wisata"
                        >{{ old('deskripsi', $destinasi->deskripsi ?? '') }}</textarea>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.destinasi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ isset($destinasi) ? 'Update Destinasi' : 'Simpan Destinasi' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
