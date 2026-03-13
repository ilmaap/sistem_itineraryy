@extends('layout.app')

@section('title', 'Detail Itinerary - ' . $itinerary->nama)

@section('content')
<div class="container">
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('wisatawan.itinerary.index') }}" class="btn-back-icon" title="Kembali ke Riwayat">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-title-wrapper">
                <h1><i class="fas fa-map-marked-alt"></i> {{ $itinerary->nama }}</h1>
                <div class="header-date">
                    <small>Diperbarui: {{ \Carbon\Carbon::parse($itinerary->updated_at)->format('d M Y, H:i') }}</small>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <button onclick="window.print()" class="btn btn-outline" title="Cetak">
                <i class="fas fa-print"></i> Cetak
            </button>
            <a href="{{ route('wisatawan.itinerary.edit', $itinerary->id) }}" class="btn btn-outline">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="itinerary-info-card">
        <div class="info-card-grid">
            <div class="info-card-item">
                <label>Tanggal Keberangkatan</label>
                <div class="info-value">{{ \Carbon\Carbon::parse($itinerary->tgl_keberangkatan)->format('d M Y') }}</div>
            </div>
            <div class="info-card-item">
                <label>Waktu Mulai</label>
                <div class="info-value">{{ substr($itinerary->waktu_mulai, 0, 5) }}</div>
            </div>
            <div class="info-card-item">
                <label>Jumlah Hari</label>
                <div class="info-value">{{ $itinerary->total_hari }} Hari</div>
            </div>
            <div class="info-card-item">
                <label>Lokasi</label>
                <div class="info-value">{{ ucfirst($itinerary->lokasi) }}</div>
            </div>
            <div class="info-card-item">
                <label>Jenis Jalur</label>
                <div class="info-value">{{ $itinerary->jenis_jalur == 'tol' ? 'Tol' : 'Non Tol' }}</div>
            </div>
            <div class="info-card-item">
                <label>Rating Minimum</label>
                <div class="info-value">{{ number_format($itinerary->min_rating, 1) }}</div>
            </div>
        </div>
    </div>

    <!-- Daily Itinerary -->
    <div class="itinerary-result">
        @foreach($itineraryData as $day)
            <div class="day-itinerary-card">
                <div class="day-header">
                    <div class="day-badge">{{ $day['hari'] }}</div>
                    <div class="day-title">
                        <h4>Hari {{ $day['hari'] }}</h4>
                        <p>{{ $day['tanggal_formatted'] }} - {{ count($day['destinasi']) }} destinasi</p>
                    </div>
                </div>
                <div class="day-destinasi-list">
                    @foreach($day['destinasi'] as $index => $dest)
                        <div class="destinasi-item-card">
                            <div class="destinasi-time-col">
                                <div class="time-box">
                                    {{ $dest['waktu_mulai'] }} - {{ $dest['waktu_selesai'] }}
                                </div>
                                @if($dest['jarak_dari_sebelumnya'] > 0 || ($index === 0 && $day['hari'] === 1))
                                    <div class="distance-info">
                                        <small>Jarak: {{ number_format($dest['jarak_dari_sebelumnya'], 1) }} km</small>
                                    </div>
                                @endif
                                @if($dest['waktu_tempuh'] > 0)
                                    <div class="travel-time-info">
                                        <i class="fas fa-clock"></i>
                                        <small>Waktu tempuh: 
                                            @if($dest['waktu_tempuh'] < 60)
                                                {{ $dest['waktu_tempuh'] }} menit
                                            @else
                                                {{ floor($dest['waktu_tempuh'] / 60) }} jam 
                                                @if($dest['waktu_tempuh'] % 60 > 0)
                                                    {{ $dest['waktu_tempuh'] % 60 }} menit
                                                @endif
                                            @endif
                                        </small>
                                    </div>
                                @endif
                            </div>
                            <div class="destinasi-content-col">
                                <div class="destinasi-header">
                                    <h5>{{ $dest['nama'] }}</h5>
                                </div>
                                <div class="destinasi-info">
                                    <div class="info-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $dest['alamat'] }}</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-star"></i>
                                        <span>{{ number_format($dest['rating'], 1) }}</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-dollar-sign"></i>
                                        <span>{{ $dest['biaya'] == 0 ? 'Gratis' : 'Rp ' . number_format($dest['biaya'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="destinasi-durasi">
                                    <label>Durasi:</label>
                                    <span class="durasi-value">{{ floor($dest['durasi'] / 60) }} jam {{ $dest['durasi'] % 60 }} menit</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Restaurant yang dipilih untuk hari ini -->
                @php
                    $dayRestaurants = $itinerary->itineraryRestaurant->where('no_hari', $day['hari']);
                @endphp
                @if($dayRestaurants->count() > 0)
                    <div class="day-recommendations-section" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #e2e8f0;">
                        <h5 style="margin: 0 0 1rem 0; color: #0f172a; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-utensils" style="color: #14b8a6;"></i>
                            Tempat Makan yang Dipilih
                        </h5>
                        <div class="recommendation-list" style="display: grid; gap: 1rem;">
                            @foreach($dayRestaurants as $ir)
                                <div class="recommendation-item" style="background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #14b8a6;">
                                    <h6 style="margin: 0 0 0.5rem 0; color: #0f172a;">{{ $ir->restaurant->nama }}</h6>
                                    <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.9rem; color: #64748b;">
                                        <div><i class="fas fa-map-marker-alt"></i> {{ $ir->restaurant->alamat }}</div>
                                        <div><i class="fas fa-star"></i> {{ number_format($ir->restaurant->rating, 1) }}</div>
                                        @if($ir->jarak > 0)
                                            <div><i class="fas fa-route"></i> {{ number_format($ir->jarak, 1) }} km dari destinasi terakhir</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Akomodasi yang dipilih untuk hari ini -->
                @php
                    $dayAkomodasi = $itinerary->itineraryAkomodasi->where('no_hari', $day['hari']);
                @endphp
                @if($dayAkomodasi->count() > 0)
                    <div class="day-recommendations-section" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #e2e8f0;">
                        <h5 style="margin: 0 0 1rem 0; color: #0f172a; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-hotel" style="color: #14b8a6;"></i>
                            Akomodasi yang Dipilih
                        </h5>
                        <div class="recommendation-list" style="display: grid; gap: 1rem;">
                            @foreach($dayAkomodasi as $ia)
                                <div class="recommendation-item" style="background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #14b8a6;">
                                    <h6 style="margin: 0 0 0.5rem 0; color: #0f172a;">{{ $ia->akomodasi->nama }}</h6>
                                    <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.9rem; color: #64748b;">
                                        <div><i class="fas fa-map-marker-alt"></i> {{ $ia->akomodasi->alamat }}</div>
                                        <div><i class="fas fa-star"></i> {{ number_format($ia->akomodasi->rating, 1) }}</div>
                                        @if($ia->jarak > 0)
                                            <div><i class="fas fa-route"></i> {{ number_format($ia->jarak, 1) }} km dari destinasi terakhir</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection

