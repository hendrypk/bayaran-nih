<div>
    <x-ui.modal>
        <div>
            <div class="mb-3">
                <label class="form-label">@lang('general.label.name')</label>
                <input type="text" wire:model="name" class="form-control">
            </div>

            <h6>@lang('performance.label.appraisal')</h6>

            @foreach($appraisals as $index => $item)
                <div class="row d-flex mb-3 justify-content-between align-items-center">

                    <div class="col-md-4">
                        <input type="text"
                               class="form-control"
                               wire:model="appraisals.{{ $index }}.aspect"
                               placeholder="@lang('performance.label.aspect')">
                    </div>

                    <div class="col-md-7">
                        <input type="text"
                               class="form-control"
                               wire:model="appraisals.{{ $index }}.description"
                               placeholder="@lang('performance.label.description')">
                    </div>

                    <div class="col-md-1 d-flex justify-content-end">
                        <button class="btn btn-red btn-sm ms-auto"
                                wire:click="removeAppraisal({{ $index }})">
                                <i class="ri-delete-bin-fill"></i>
                        </button>
                    </div>

                </div>
            @endforeach

            <div class="d-flex mt-2 justify-content-between align-items-center">
                <button class="btn btn-tosca btn-sm" wire:click="addAppraisal">
                    <i class="ri-add-circle-line"></i>
                </button>
            </div>

            <hr>
            <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    @if($isEditing)
                        <x-swal-confirm 
                            title="Hapus PA?" 
                            text="Apakah Anda yakin ingin menghapus PA {{ $name }}?"
                            callback="delete"
                            :id="$editingId"
                            class="btn btn-red btn-sm">
                            <i class="ri-delete-bin-fill"></i>
                        </x-swal-confirm>
                    @else
                        <div></div>
                    @endif

                    <div class="d-flex gap-2">
                        <button class="btn btn-untosca" wire:click="$dispatch('closeModal')">
                            @lang('general.label.cancel')
                        </button>
                        <button class="btn btn-tosca btn-sm" wire:click="save">
                            @lang('general.label.save')
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </x-ui.modal>
</div>
