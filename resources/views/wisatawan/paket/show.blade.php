@extends('layout.app')

@section('title', $paket->nama . ' - Paket Wisata')

@section('content')
<div class="container">
    <div class="page-header">
        <div class="header-title-wrapper">
            <a href="{{ route('wisatawan.paket.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Paket
            </a>
            <h1><i class="fas fa-box"></i> {{ $paket->nama }}</h1>
        </div>
    </div>

    <div class="paket-detail-wrapper">
        <!-- Paket Header -->
        <div class="paket-header">
            <div class="paket-image-section">
                @if($paket->image)
                    <img src="{{ asset('storage/' . $paket->image) }}" alt="{{ $paket->nama }}" class="paket-main-image">
                @else
                    <div class="no-image-large">
                        <i class="fas fa-image"></i>
                        <span>No Image</span>
                    </div>
                @endif
            </div>
            <div class="paket-info-section">
                <div class="paket-badges">
                    <span class="badge badge-primary">
                        <i class="fas fa-calendar-day"></i> {{ $paket->durasi }} Hari
                    </span>
                    <span class="badge badge-success">
                        <i class="fas fa-map-marked-alt"></i> {{ $paket->destinasi->count() }} Destinasi
                    </span>
                </div>
                <h2>{{ $paket->nama }}</h2>
                @if($paket->deskripsi)
                    <div class="paket-description">
                        <p>{{ $paket->deskripsi }}</p>
                    </div>
                @endif
                <div class="paket-price-section">
                    <div class="price-label">Harga Paket</div>
                    <div class="price-value">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                </div>
                <div class="paket-cta-section">
                    @php
                        // Nomor WhatsApp (format: 6281215384432 tanpa + dan spasi)
                        // Ganti dengan nomor WhatsApp yang sebenarnya
                        $whatsappNumber = env('WHATSAPP_NUMBER', '6281392189055');
                        
                        // Format pesan WhatsApp
                        $whatsappMessage = "Halo, saya tertarik dengan paket wisata:\n\n";
                        $whatsappMessage .= "*{$paket->nama}*\n";
                        $whatsappMessage .= "Durasi: {$paket->durasi} Hari\n";
                        $whatsappMessage .= "Harga: Rp " . number_format($paket->harga, 0, ',', '.') . "\n\n";
                        $whatsappMessage .= "Saya ingin mendapatkan informasi lebih lanjut tentang paket ini.";
                        
                        // Encode message untuk URL
                        $encodedMessage = urlencode($whatsappMessage);
                        
                        // Generate WhatsApp URL
                        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";
                    @endphp
                    <a href="{{ $whatsappUrl }}" target="_blank" class="cta-button btn-whatsapp">
                        <i class="fab fa-whatsapp"></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Destinasi per Hari -->
        @if($destinasiPerHari->count() > 0)
            <div class="destinasi-schedule">
                <h3><i class="fas fa-route"></i> Rute Perjalanan</h3>
                @foreach($destinasiPerHari as $hari => $destinasiList)
                    <div class="hari-section">
                        <div class="hari-header">
                            <div class="hari-number">
                                <span>Hari {{ $hari }}</span>
                            </div>
                            <div class="hari-destinasi-count">
                                {{ $destinasiList->count() }} Destinasi
                            </div>
                        </div>
                        <div class="destinasi-list">
                            @foreach($destinasiList as $index => $destinasi)
                                <div class="destinasi-item">
                                    <div class="destinasi-number">{{ $index + 1 }}</div>
                                    <div class="destinasi-content">
                                        <h4>{{ $destinasi->nama }}</h4>
                                        <div class="destinasi-meta">
                                            <span class="destinasi-kategori">
                                                <i class="fas fa-tag"></i> {{ $destinasi->kategori }}
                                            </span>
                                            @if($destinasi->rating)
                                                <span class="destinasi-rating">
                                                    <i class="fas fa-star"></i> {{ number_format($destinasi->rating, 1) }}
                                                </span>
                                            @endif
                                            @if($destinasi->biaya)
                                                <span class="destinasi-biaya">
                                                    <i class="fas fa-money-bill-wave"></i> Rp {{ number_format($destinasi->biaya, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($destinasi->alamat)
                                            <div class="destinasi-alamat">
                                                <i class="fas fa-map-marker-alt"></i> {{ $destinasi->alamat }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <div class="destinasi-connector">
                                        <i class="fas fa-arrow-down"></i>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-map-marked-alt"></i>
                <h3>Belum Ada Destinasi</h3>
                <p>Paket ini belum memiliki destinasi yang ditambahkan.</p>
            </div>
        @endif
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detailpaketwisatawan.css') }}">
@endpush
@endsection

