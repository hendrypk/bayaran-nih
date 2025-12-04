<!-- Modal Gabungan -->
<div class="modal fade" id="locationPhotoModal" tabindex="-1" aria-labelledby="locationPhotoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="locationPhotoModalLabel">Lokasi & Foto Presensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Kolom Map -->
          <div class="col-md-6">
            <div id="mapPresence" style="height:400px; width:100%; border-radius:8px;"></div>
          </div>
          <!-- Kolom Foto -->
          <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img id="modalPhoto" src="" alt="Foto Presensi" class="img-fluid rounded" style="max-height:400px;">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
