<div class="step-content" id="step2">
    <h3>Hasil Itinerary</h3>
    
    <div id="itineraryResult">
        <div class="loading-state">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Sistem sedang memproses dan menyusun itinerary optimal...</p>
        </div>
    </div>
    
    <div class="step-actions">
        <button type="button" class="btn btn-outline" onclick="prevStep(1)">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <button type="button" class="btn btn-primary" onclick="nextStep(3)">
            Simpan Itinerary <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>

<!-- Modal Tambah Destinasi -->
<div id="modalTambahDestinasi" class="modal-overlay hidden">
    <div class="modal-card">
        <div class="modal-header">
            <h4>Tambah Destinasi</h4>
            <button type="button" class="modal-close" onclick="tutupModalTambahDestinasi()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="selectDestinasiBaru">
                    <i class="fas fa-map-marker-alt"></i> Pilih Destinasi
                </label>
                <select id="selectDestinasiBaru" class="form-select">
                    <option value="">-- Pilih Destinasi --</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline" onclick="tutupModalTambahDestinasi()">
                Batal
            </button>
            <button type="button" class="btn btn-primary" onclick="simpanDestinasiBaru()">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
    </div>
</div>

<!-- Modal Rekomendasi Restaurant -->
<div id="modalRekomendasiRestaurant" class="modal-overlay hidden">
    <div class="modal-card modal-large">
        <div class="modal-header">
            <h4><i class="fas fa-utensils"></i> Rekomendasi Tempat Makan</h4>
            <button type="button" class="modal-close" onclick="tutupModalRekomendasiRestaurant()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="restaurantLoading" class="loading-state">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Memuat rekomendasi tempat makan...</p>
            </div>
            <div id="restaurantList" class="recommendation-list"></div>
        </div>
    </div>
</div>

<!-- Modal Rekomendasi Akomodasi -->
<div id="modalRekomendasiAkomodasi" class="modal-overlay hidden">
    <div class="modal-card modal-large">
        <div class="modal-header">
            <h4><i class="fas fa-hotel"></i> Rekomendasi Akomodasi</h4>
            <button type="button" class="modal-close" onclick="tutupModalRekomendasiAkomodasi()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="akomodasiLoading" class="loading-state">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Memuat rekomendasi akomodasi...</p>
            </div>
            <div id="akomodasiList" class="recommendation-list"></div>
        </div>
    </div>
</div>

