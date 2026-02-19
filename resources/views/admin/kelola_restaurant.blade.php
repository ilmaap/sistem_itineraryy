<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($restaurant) ? 'Edit' : 'Tambah' }} Restaurant - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/restaurantkelolaadmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="content-wrapper">
        <div class="restaurant-form-container">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-utensils"></i> {{ isset($restaurant) ? 'Edit' : 'Tambah' }} Restaurant
                </h1>
                <h4 class="page-subtitle">{{ isset($restaurant) ? 'Ubah informasi restaurant' : 'Tambahkan restaurant baru' }}</h4>
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
                <form action="{{ isset($restaurant) ? route('admin.restaurant.update', $restaurant->id) : route('admin.restaurant.store') }}" method="POST">
                    @csrf
                    @if (isset($restaurant))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="nama">
                            <i class="fas fa-utensils"></i> Nama Restaurant <span style="color: #e53e3e;">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            class="form-control" 
                            required 
                            value="{{ old('nama', $restaurant->nama ?? '') }}"
                            placeholder="Masukkan nama restaurant"
                        >
                    </div>

                    <div class="form-group">
                        <label for="alamat">
                            <i class="fas fa-map-marker-alt"></i> Alamat <span style="color: #e53e3e;">*</span>
                        </label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            class="form-control" 
                            required 
                            placeholder="Masukkan alamat restaurant"
                            rows="3"
                        >{{ old('alamat', $restaurant->alamat ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">
                            <i class="fas fa-city"></i> Lokasi <span style="color: #e53e3e;">*</span>
                        </label>
                        <select id="lokasi" name="lokasi" class="form-control" required>
                            <option value="">Pilih Lokasi</option>
                            <option value="solo" {{ old('lokasi', $restaurant->lokasi ?? '') === 'solo' ? 'selected' : '' }}>Solo</option>
                            <option value="yogyakarta" {{ old('lokasi', $restaurant->lokasi ?? '') === 'yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="latitude">
                                <i class="fas fa-map-pin"></i> Latitude <span style="color: #e53e3e;">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="latitude" 
                                name="latitude" 
                                class="form-control" 
                                required 
                                step="any"
                                value="{{ old('latitude', $restaurant->latitude ?? '') }}"
                                placeholder="Contoh: -7.7956"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Nilai antara -90 sampai 90</small>
                        </div>

                        <div class="form-group">
                            <label for="longitude">
                                <i class="fas fa-map-pin"></i> Longitude <span style="color: #e53e3e;">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="longitude" 
                                name="longitude" 
                                class="form-control" 
                                required 
                                step="any"
                                value="{{ old('longitude', $restaurant->longitude ?? '') }}"
                                placeholder="Contoh: 110.3695"
                            >
                            <small style="color: #718096; font-size: 0.875rem;">Nilai antara -180 sampai 180</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="rating">
                            <i class="fas fa-star"></i> Rating
                        </label>
                        <input 
                            type="number" 
                            id="rating" 
                            name="rating" 
                            class="form-control" 
                            step="0.1"
                            min="0"
                            max="5"
                            value="{{ old('rating', $restaurant->rating ?? '') }}"
                            placeholder="Masukkan rating (0-5)"
                        >
                        <small style="color: #718096; font-size: 0.875rem;">Nilai antara 0 sampai 5</small>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">
                            <i class="fas fa-align-left"></i> Deskripsi
                        </label>
                        <textarea 
                            id="deskripsi" 
                            name="deskripsi" 
                            class="form-control" 
                            placeholder="Masukkan deskripsi restaurant"
                            rows="5"
                        >{{ old('deskripsi', $restaurant->deskripsi ?? '') }}</textarea>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.restaurant.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ isset($restaurant) ? 'Update Restaurant' : 'Simpan Restaurant' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

