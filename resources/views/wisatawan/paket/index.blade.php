@extends('layout.app')

@section('title', 'Paket Wisata - Itinerary Wisata')

@section('content')
<div class="container">
    <div class="page-header">
        <div class="header-title-wrapper">
            <h1><i class="fas fa-box"></i> Paket Wisata</h1>
            <p>Pilih paket wisata siap pakai dengan destinasi lengkap</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form action="{{ route('wisatawan.paket.index') }}" method="GET" class="filter-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="search">
                        <i class="fas fa-search"></i> Cari Paket
                    </label>
                    <input 
                        type="text" 
                        id="search" 
                        name="search" 
                        class="form-control" 
                        placeholder="Cari nama atau deskripsi paket..."
                        value="{{ $search }}"
                    >
                </div>
                <div class="filter-group">
                    <label for="durasi">
                        <i class="fas fa-calendar-day"></i> Durasi
                    </label>
                    <select id="durasi" name="durasi" class="form-control">
                        <option value="">Semua Durasi</option>
                        <option value="1" {{ $durasi == '1' ? 'selected' : '' }}>1 Hari</option>
                        <option value="2" {{ $durasi == '2' ? 'selected' : '' }}>2 Hari</option>
                        <option value="3" {{ $durasi == '3' ? 'selected' : '' }}>3 Hari</option>
                        <option value="4" {{ $durasi == '4' ? 'selected' : '' }}>4 Hari</option>
                        <option value="5" {{ $durasi == '5' ? 'selected' : '' }}>5 Hari</option>
                        <option value="6" {{ $durasi == '6' ? 'selected' : '' }}>6 Hari</option>
                        <option value="7" {{ $durasi == '7' ? 'selected' : '' }}>7 Hari</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="harga_min">
                        <i class="fas fa-money-bill-wave"></i> Harga Min
                    </label>
                    <input 
                        type="number" 
                        id="harga_min" 
                        name="harga_min" 
                        class="form-control" 
                        placeholder="Min"
                        value="{{ $harga_min }}"
                    >
                </div>
                <div class="filter-group">
                    <label for="harga_max">
                        <i class="fas fa-money-bill-wave"></i> Harga Max
                    </label>
                    <input 
                        type="number" 
                        id="harga_max" 
                        name="harga_max" 
                        class="form-control" 
                        placeholder="Max"
                        value="{{ $harga_max }}"
                    >
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('wisatawan.paket.index') }}" class="btn btn-outline">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($paket->count() > 0)
        <div class="paket-grid">
            @foreach($paket as $item)
                <div class="paket-card">
                    <div class="paket-card-image">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->nama }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                                <span>No Image</span>
                            </div>
                        @endif
                        <div class="paket-badge">
                            <i class="fas fa-calendar-day"></i> {{ $item->durasi }} Hari
                        </div>
                    </div>
                    <div class="paket-card-body">
                        <h3>{{ $item->nama }}</h3>
                        @if($item->deskripsi)
                            <p class="paket-description">{{ Str::limit($item->deskripsi, 100) }}</p>
                        @endif
                        <div class="paket-info">
                            <div class="info-item">
                                <i class="fas fa-map-marked-alt"></i>
                                <span>{{ $item->destinasi->count() }} Destinasi</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <span class="paket-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="paket-card-footer">
                        <a href="{{ route('wisatawan.paket.show', $item->id) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $paket->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h3>Tidak Ada Paket Wisata</h3>
            <p>{{ $search || $durasi || $harga_min || $harga_max ? 'Tidak ditemukan paket wisata yang sesuai dengan filter.' : 'Belum ada paket wisata yang tersedia.' }}</p>
            @if($search || $durasi || $harga_min || $harga_max)
                <a href="{{ route('wisatawan.paket.index') }}" class="btn btn-primary">
                    <i class="fas fa-redo"></i> Reset Filter
                </a>
            @endif
        </div>
    @endif
</div>

<style>
.filter-section {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.filter-form {
    width: 100%;
}

.filter-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr auto;
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #4a5568;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-group label i {
    color: #667eea;
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
    align-items: flex-end;
}

.paket-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.paket-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
}

.paket-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.paket-card-image {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f7fafc;
}

.paket-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.paket-card-image .no-image {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #a0aec0;
    gap: 0.5rem;
}

.paket-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(102, 126, 234, 0.9);
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.paket-card-body {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.paket-card-body h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.paket-description {
    color: #718096;
    font-size: 0.875rem;
    line-height: 1.6;
    margin: 0;
    flex: 1;
}

.paket-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
    font-size: 0.875rem;
}

.info-item i {
    color: #667eea;
    width: 20px;
}

.paket-price {
    font-weight: 700;
    color: #667eea;
    font-size: 1rem;
}

.paket-card-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.btn-block {
    width: 100%;
    text-align: center;
    justify-content: center;
}

@media (max-width: 1024px) {
    .filter-row {
        grid-template-columns: 1fr;
    }
    
    .filter-actions {
        width: 100%;
    }
    
    .filter-actions .btn {
        flex: 1;
    }
}

@media (max-width: 768px) {
    .paket-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

