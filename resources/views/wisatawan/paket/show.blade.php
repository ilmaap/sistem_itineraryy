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

<style>
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    margin-bottom: 1rem;
    transition: color 0.3s ease;
}

.btn-back:hover {
    color: #5568d3;
}

.paket-detail-wrapper {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.paket-header {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 2rem;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid #e2e8f0;
}

.paket-image-section {
    width: 100%;
}

.paket-main-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.no-image-large {
    width: 100%;
    height: 400px;
    background: #f7fafc;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #a0aec0;
    gap: 1rem;
    font-size: 1.5rem;
}

.paket-info-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.paket-badges {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.badge-primary {
    background: #667eea;
    color: #fff;
}

.badge-success {
    background: #48bb78;
    color: #fff;
}

.paket-info-section h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.paket-description {
    color: #4a5568;
    line-height: 1.8;
    font-size: 1rem;
}

.paket-description p {
    margin: 0;
}

.paket-price-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem;
    border-radius: 12px;
    color: #fff;
}

.price-label {
    font-size: 0.875rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.price-value {
    font-size: 2rem;
    font-weight: 700;
}

.paket-cta-section {
    margin-top: 1.5rem;
}

.cta-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    padding: 1rem 1.5rem;
    background: #25D366;
    color: #fff;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
}

.cta-button:hover {
    background: #20BA5A;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 211, 102, 0.4);
    color: #fff;
}

.cta-button:active {
    transform: translateY(0);
}

.btn-whatsapp {
    background: #25D366;
}

.btn-whatsapp:hover {
    background: #20BA5A;
}

.cta-button i {
    font-size: 1.5rem;
}

.cta-button span {
    font-size: 1rem;
}

.destinasi-schedule {
    margin-top: 2rem;
}

.destinasi-schedule h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.hari-section {
    margin-bottom: 2.5rem;
    padding: 1.5rem;
    background: #f7fafc;
    border-radius: 12px;
    border-left: 4px solid #667eea;
}

.hari-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e2e8f0;
}

.hari-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: #667eea;
}

.hari-destinasi-count {
    color: #718096;
    font-size: 0.875rem;
    font-weight: 600;
}

.destinasi-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.destinasi-item {
    display: flex;
    gap: 1rem;
    background: #fff;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.destinasi-number {
    width: 40px;
    height: 40px;
    background: #667eea;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
}

.destinasi-content {
    flex: 1;
}

.destinasi-content h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 0.75rem 0;
}

.destinasi-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 0.75rem;
}

.destinasi-meta span {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #4a5568;
}

.destinasi-meta i {
    color: #667eea;
}

.destinasi-rating {
    color: #f6ad55 !important;
}

.destinasi-rating i {
    color: #f6ad55 !important;
}

.destinasi-biaya {
    color: #48bb78 !important;
}

.destinasi-biaya i {
    color: #48bb78 !important;
}

.destinasi-alamat {
    color: #718096;
    font-size: 0.875rem;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.destinasi-alamat i {
    color: #cbd5e0;
    margin-top: 0.25rem;
}

.destinasi-connector {
    display: flex;
    justify-content: center;
    color: #cbd5e0;
    padding: 0.5rem 0;
}

@media (max-width: 768px) {
    .paket-header {
        grid-template-columns: 1fr;
    }
    
    .paket-main-image,
    .no-image-large {
        height: 250px;
    }
    
    .paket-info-section h2 {
        font-size: 1.5rem;
    }
    
    .price-value {
        font-size: 1.5rem;
    }
    
    .hari-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .destinasi-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
@endsection

