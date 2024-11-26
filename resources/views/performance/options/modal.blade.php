<!--Add KPI-->
<div class="modal fade" id="addIndicatorModal" tabindex="-1" aria-labelledby="modalIndicator" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addIndicator">Add Indicator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('indicator.add') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label for="inputPosition" class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div id="indicatorsContainer">
                        <div class="indicator-group mb-3">
                            <div class="row">
                                <div class="col-7">
                                    <label for="inputAspect" class="form-label fw-bold">Indicator</label>
                                    <input type="text" class="form-control" name="indicators[0][aspect]" required>
                                </div>
                                <div class="col-2">
                                    <label for="inputTarget" class="form-label fw-bold">Target</label>
                                    <input type="number" class="form-control" name="indicators[0][target]" step="0.01" required>
                                </div>
                                <div class="col-2">
                                    <label for="inputBobot" class="form-label fw-bold">Bobot (%)</label>
                                    <input type="number" class="form-control bobot-input" name="indicators[0][bobot]" step="0.01" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-9">
                            <button type="button" id="addIndicatorBtn" class="btn btn-secondary">Add Indicator</button>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control fw-bold" id="totalBobot" value="0" readonly>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal PA -->
<div class="modal fade" id="addPa" tabindex="-1" aria-labelledby="modalPa" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPa">Add PA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('appraisal.add')}}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>    
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Appraisal Modal -->
<div class="modal fade" id="paEditModal" tabindex="-1" aria-labelledby="paEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paEditModalLabel">Edit PA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="appraisal">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputName" class="form-label">PA Name</label>
            <input type="text" class="form-control" name="name" id="inputName">
          </div>
          <button type="submit" class="btn btn-tosca">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>