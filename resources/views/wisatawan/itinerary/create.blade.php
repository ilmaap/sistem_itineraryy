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
    @php
        $jsonItineraryData = json_encode($itineraryData ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $jsonItineraryConfig = json_encode($itineraryConfig ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $itineraryId = $itinerary->id ?? 0;
        // Encode ke base64 untuk menghindari masalah escape di HTML attribute
        $base64ItineraryData = base64_encode($jsonItineraryData);
        $base64ItineraryConfig = base64_encode($jsonItineraryConfig);
    @endphp
    <div id="edit-mode-data" 
         data-itinerary-data="{{ $base64ItineraryData }}"
         data-itinerary-config="{{ $base64ItineraryConfig }}"
         data-itinerary-id="{{ $itineraryId }}"
         style="display: none;"></div>
    <script>
        // Pre-fill data untuk edit mode
        (function() {
            try {
                var dataElement = document.getElementById('edit-mode-data');
                if (dataElement) {
                    // Decode dari base64
                    var itineraryDataBase64 = dataElement.getAttribute('data-itinerary-data');
                    var itineraryConfigBase64 = dataElement.getAttribute('data-itinerary-config');
                    var itineraryId = parseInt(dataElement.getAttribute('data-itinerary-id'), 10);
                    
                    // Decode base64 dan parse JSON
                    var itineraryDataStr = atob(itineraryDataBase64);
                    var itineraryConfigStr = atob(itineraryConfigBase64);
                    var itineraryDataJson = JSON.parse(itineraryDataStr);
                    var itineraryConfigJson = JSON.parse(itineraryConfigStr);
                    
                    window.editModeData = {
                        itineraryData: itineraryDataJson,
                        itineraryConfig: itineraryConfigJson,
                        itineraryId: itineraryId
                    };
                    
                    console.log('Edit mode: Data berhasil di-set', {
                        hasItineraryData: !!window.editModeData.itineraryData,
                        hasItineraryConfig: !!window.editModeData.itineraryConfig,
                        itineraryDataLength: Array.isArray(window.editModeData.itineraryData) ? window.editModeData.itineraryData.length : 0
                    });
                }
            } catch (e) {
                console.error('Error setting edit mode data:', e);
                window.editModeData = {
                    itineraryData: {},
                    itineraryConfig: {},
                    itineraryId: 0
                };
            }
        })();
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

