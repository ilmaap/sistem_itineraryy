@extends('layout.app')

@section('title', 'Buat Itinerary Baru - Itinerary Wisata')

@push('styles')
<meta name="destinations-route" content="{{ route('wisatawan.itinerary.destinations') }}">
<meta name="generate-route" content="{{ route('wisatawan.itinerary.generate') }}">
<meta name="holiday-info-route" content="{{ route('wisatawan.api.holiday-info') }}">
@endpush

@section('content')
<div class="container">
    <h2>Buat Itinerary Baru</h2>
    
    <!-- Steps Indicator -->
    <div class="steps-indicator">
        <div class="step-indicator active" id="step1-indicator">
            <div class="step-circle">1</div>
            <div>Lokasi & Konfigurasi</div>
        </div>
        <div class="step-indicator" id="step2-indicator">
            <div class="step-circle">2</div>
            <div>Hasil Itinerary</div>
        </div>
        <div class="step-indicator" id="step3-indicator">
            <div class="step-circle">3</div>
            <div>Simpan</div>
        </div>
    </div>
    
    <!-- Step Contents -->
    @include('wisatawan.itinerary.steps.step1')
    @include('wisatawan.itinerary.steps.step2')
    @include('wisatawan.itinerary.steps.step3')
</div>
@endsection

