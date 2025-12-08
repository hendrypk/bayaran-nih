<div>
    <x-ui.modal>
        <div>
            <div class="mb-3">
                <label class="form-label">@lang('general.label.name')</label>
                <input type="text" wire:model="name" class="form-control">
            </div>

            <h6>@lang('performance.label.indicator')</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="aspect-col">@lang('performance.label.aspect')</th>
                            <th class="description-col">@lang('performance.label.description')</th>
                            <th class="target-col">@lang('performance.label.target')</th>
                            <th class="unit-col">@lang('performance.label.unit')</th>
                            <th class="weight-col">@lang('performance.label.weight')</th>
                            <th class="active-col">@lang('general.label.active')</th>
                            <th class="action-col">@lang('general.label.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($indicators as $index => $item)
                        <tr class="{{ $item['locked'] ? 'table-secondary' : '' }}">
                            <td class="aspect-col">
                                <input type="text"
                                    class="form-control"
                                    @if($item['locked']) disabled @endif
                                    wire:model="indicators.{{ $index }}.aspect"
                                    placeholder="Aspect">
                            </td>
                            <td class="description-col">
                                <textarea class="form-control"
                                        @if($item['locked']) disabled @endif
                                        wire:model="indicators.{{ $index }}.description"
                                        rows="2"
                                        placeholder="Description"></textarea>
                            </td>
                            <td class="target-col">
                                <input type="text"
                                    class="form-control"
                                    wire:model="indicators.{{ $index }}.target"
                                    placeholder="Target">
                            </td>
                            <td class="unit-col">
                                <select class="form-control"
                                        wire:model="indicators.{{ $index }}.unit_id">
                                    <option value="">Pilih Satuan</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="weight-col">
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control"
                                        wire:model.lazy="indicators.{{ $index }}.weight"
                                        placeholder="Weight">
                                    <span class="input-group-text text">%</span>
                                </div>
                            </td>
                            <td class="active-col">
                                <input type="checkbox"
                                    class="form-check-input"
                                    wire:model="indicators.{{ $index }}.active">
                            </td>
                            <td class="action-col">
                                @if(empty($item['locked']))
                                    <button class="btn btn-danger btn-sm"
                                            wire:click="removeIndicator({{ $index }})">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="ri-lock-fill"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="d-flex justify-content-between align-items-center mt-3">
                <strong>Total Weight: {{ $totalWeight }}%</strong>
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
