<div>
    <x-ui.modal>
        <div>
            <div class="mb-3">
                <label class="form-label">@lang('general.label.name')</label>
                <input type="text" wire:model="name" class="form-control">
            </div>

            <h6>@lang('performance.label.indicator')</h6>

            @foreach($indicators as $index => $item)
                <div class="row d-flex mb-3 justify-content-between align-items-center">

                    <div class="col-md-4">
                        <input type="text"
                               class="form-control"
                               wire:model="indicators.{{ $index }}.aspect"
                               placeholder="@lang('performance.label.aspect')">
                    </div>

                    <div class="col-md-4">
                        <input type="text"
                               class="form-control"
                               wire:model="indicators.{{ $index }}.description"
                               placeholder="@lang('performance.label.description')">
                    </div>

                    <div class="col-md-2">
                        <input type="text"
                               class="form-control"
                               wire:model="indicators.{{ $index }}.target"
                               placeholder="@lang('performance.label.target')">
                    </div>

                    <div class="col-md-1">
                        <input type="text"
                               class="form-control"
                               wire:model.lazy="indicators.{{ $index }}.weight"
                               placeholder="@lang('performance.label.weight')">
                    </div>

                    <div class="col-md-1 d-flex justify-content-end">
                        <button class="btn btn-red btn-sm ms-auto"
                                wire:click="removeIndicator({{ $index }})">
                                <i class="ri-delete-bin-fill"></i>
                        </button>
                    </div>

                </div>
            @endforeach

            <div class="d-flex mt-2 justify-content-between align-items-center">
                <strong>@lang('performance.label.total_weight') : {{ $totalWeight }}%</strong>

                <button class="btn btn-tosca btn-sm" wire:click="addIndicator">
                    <i class="ri-add-circle-line"></i>
                </button>
            </div>

            <hr>
            <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    @if($isEditing)
                        <x-swal-confirm 
                            title="Hapus KPI?" 
                            text="Apakah Anda yakin ingin menghapus KPI {{ $name }}?"
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
