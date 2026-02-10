<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($liburNasional) ? 'Edit' : 'Tambah' }} Hari Libur - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/liburnasionalkelolaadmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="content-wrapper">
        <div class="libur-nasional-form-container">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-calendar-alt"></i> {{ isset($liburNasional) ? 'Edit' : 'Tambah' }} Hari Libur
                </h1>
                <h4 class="page-subtitle">{{ isset($liburNasional) ? 'Ubah informasi hari libur nasional' : 'Tambahkan hari libur nasional baru' }}</h4>
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
                <form action="{{ isset($liburNasional) ? route('admin.libur_nasional.update', $liburNasional->id) : route('admin.libur_nasional.store') }}" method="POST">
                    @csrf
                    @if (isset($liburNasional))
                        @method('PUT')
                    @endif

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tanggal">
                                <i class="fas fa-calendar"></i> Tanggal <span style="color: #e53e3e;">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="tanggal" 
                                name="tanggal" 
                                class="form-control" 
                                required 
                                value="{{ old('tanggal', isset($liburNasional) ? $liburNasional->tanggal->format('Y-m-d') : '') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="tahun">
                                <i class="fas fa-calendar-year"></i> Tahun <span style="color: #e53e3e;">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="tahun" 
                                name="tahun" 
                                class="form-control" 
                                required 
                                min="2000"
                                max="2100"
                                value="{{ old('tahun', $liburNasional->tahun ?? date('Y')) }}"
                                placeholder="Masukkan tahun"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama">
                            <i class="fas fa-tag"></i> Nama Hari Libur <span style="color: #e53e3e;">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            class="form-control" 
                            required 
                            value="{{ old('nama', $liburNasional->nama ?? '') }}"
                            placeholder="Masukkan nama hari libur (contoh: Hari Raya Idul Fitri)"
                        >
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.libur_nasional.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ isset($liburNasional) ? 'Update Hari Libur' : 'Simpan Hari Libur' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-fill tahun based on tanggal
        document.getElementById('tanggal').addEventListener('change', function() {
            const tanggal = new Date(this.value);
            const tahun = tanggal.getFullYear();
            document.getElementById('tahun').value = tahun;
        });
    </script>
</body>
</html>

