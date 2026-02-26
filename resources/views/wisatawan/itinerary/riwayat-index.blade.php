@extends('layout.app')

@section('title', 'Riwayat Itinerary - Itinerary Wisata')

@section('content')
<div class="container">
    <div class="page-header">
        <div class="header-title-wrapper">
            <h1><i class="fas fa-history"></i> Riwayat Itinerary</h1>
            <p>Daftar itinerary yang telah Anda buat</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($itineraries->count() > 0)
        <div class="itinerary-grid">
            @foreach($itineraries as $itinerary)
                <div class="itinerary-card">
                    <div class="itinerary-card-header">
                        <h3>{{ $itinerary->nama }}</h3>
                        <span class="itinerary-badge itinerary-badge-{{ strtolower($itinerary->lokasi) }}">
                            {{ ucfirst($itinerary->lokasi) }}
                        </span>
                    </div>
                    <div class="itinerary-card-body">
                        <div class="itinerary-info-row">
                            <div class="info-item">
                                <i class="fas fa-calendar-alt"></i>
                                <div>
                                    <span class="label">Tanggal Keberangkatan</span>
                                    <span class="value">{{ \Carbon\Carbon::parse($itinerary->tgl_keberangkatan)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <span class="label">Waktu Mulai</span>
                                    <span class="value">{{ substr($itinerary->waktu_mulai, 0, 5) }}</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar-day"></i>
                                <div>
                                    <span class="label">Durasi</span>
                                    <span class="value">{{ $itinerary->total_hari }} Hari</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <span class="label">Jenis Jalur</span>
                                    <span class="value">{{ $itinerary->jenis_jalur == 'tol' ? 'Tol' : 'Non Tol' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="itinerary-stats">
                            <div class="stat-item">
                                <i class="fas fa-route"></i>
                                <span>{{ $itinerary->itineraryDestinasi->count() }} Destinasi</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-star"></i>
                                <span>Rating Min: {{ number_format($itinerary->min_rating, 1) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="itinerary-card-footer">
                        <a href="{{ route('wisatawan.itinerary.show', $itinerary->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('wisatawan.itinerary.edit', $itinerary->id) }}" class="btn btn-outline">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $itineraries->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum Ada Itinerary</h3>
            <p>Anda belum membuat itinerary. Mulai buat itinerary pertama Anda sekarang!</p>
            <a href="{{ route('wisatawan.itinerary.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Itinerary Baru
            </a>
        </div>
    @endif
</div>
@endsection

