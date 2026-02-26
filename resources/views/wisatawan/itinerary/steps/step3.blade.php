<div class="step-content" id="step3">
    <h3>Simpan Itinerary</h3>
    
    <!-- Preview Itinerary -->
    <div id="itineraryPreview">
        <div class="loading-state">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Memuat preview itinerary...</p>
        </div>
    </div>
    
    <!-- Form Nama Itinerary -->
    <form method="POST" action="{{ route('wisatawan.itinerary.store') }}">
        @csrf
        @if(isset($isEditMode) && $isEditMode && isset($itinerary))
            <input type="hidden" name="itinerary_id" value="{{ $itinerary->id }}">
        @endif
        
        <div class="form-group">
            <label for="namaItinerary">Nama Itinerary</label>
            <input type="text" 
                   id="namaItinerary" 
                   name="nama" 
                   placeholder="Contoh: Wisata Yogyakarta 2 Hari" 
                   required
                   value="{{ old('nama', isset($itinerary) ? $itinerary->nama : '') }}">
            @error('nama')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Hidden fields untuk data itinerary -->
        <input type="hidden" name="itinerary_data" id="itineraryData">
        <input type="hidden" name="itinerary_config" id="itineraryConfig">
        
        <div class="step-actions">
            <button type="button" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan Itinerary
            </button>
        </div>
    </form>
</div>

