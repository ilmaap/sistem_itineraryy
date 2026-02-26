@extends('layout.app')

@section('title', isset($isEditMode) && $isEditMode ? 'Edit Itinerary - ' . $itinerary->nama : 'Buat Itinerary Baru - Itinerary Wisata')

@push('styles')
<meta name="destinations-route" content="{{ route('wisatawan.itinerary.destinations') }}">
<meta name="generate-route" content="{{ route('wisatawan.itinerary.generate') }}">
<meta name="reoptimize-route" content="{{ route('wisatawan.itinerary.reoptimize') }}">
<meta name="holiday-info-route" content="{{ route('wisatawan.api.holiday-info') }}">
<meta name="restaurant-recommendations-route" content="{{ route('wisatawan.api.restaurant-recommendations') }}">
<meta name="akomodasi-recommendations-route" content="{{ route('wisatawan.api.akomodasi-recommendations') }}">
@endpush

@section('content')
<div class="container">
    <h2>{{ isset($isEditMode) && $isEditMode ? 'Edit Itinerary' : 'Buat Itinerary Baru' }}</h2>
    
    @if(isset($isEditMode) && $isEditMode && isset($itineraryData) && isset($itineraryConfig))
    <script>
        // Pre-fill data untuk edit mode
        window.editModeData = {
            itineraryData: @json($itineraryData),
            itineraryConfig: @json($itineraryConfig),
            itineraryId: {{ $itinerary->id }}
        };
    </script>
    @endif
    
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

