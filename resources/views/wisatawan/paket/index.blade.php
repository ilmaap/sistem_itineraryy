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
    <div class="filter-section" style="background: #fff; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <form action="{{ route('wisatawan.paket.index') }}" method="GET" class="filter-form">
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 1rem; align-items: end;" class="filter-row-responsive">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.875rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-search" style="color: #14b8a6;"></i> Cari Paket
                    </label>
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Cari nama atau deskripsi paket..."
                        value="{{ $search }}"
                        style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem;"
                    >
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.875rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-calendar-day" style="color: #14b8a6;"></i> Durasi
                    </label>
                    <select name="durasi" class="form-control" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem;">
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
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.875rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-money-bill-wave" style="color: #14b8a6;"></i> Harga Min
                    </label>
                    <input 
                        type="number" 
                        name="harga_min" 
                        class="form-control" 
                        placeholder="Min"
                        value="{{ $harga_min }}"
                        style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem;"
                    >
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.875rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-money-bill-wave" style="color: #14b8a6;"></i> Harga Max
                    </label>
                    <input 
                        type="number" 
                        name="harga_max" 
                        class="form-control" 
                        placeholder="Max"
                        value="{{ $harga_max }}"
                        style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem;"
                    >
                </div>
                <div style="display: flex; gap: 0.5rem; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.875rem; border-radius: 8px;">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('wisatawan.paket.index') }}" class="btn btn-outline" style="padding: 0.75rem 1.5rem; font-size: 0.875rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;">
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

@push('styles')
<link rel="stylesheet" href="{{ asset('css/paketwisatawan.css') }}">
@endpush
@endsection

