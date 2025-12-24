<div>
    <x-ui.modal>
        <div class="space-y-4 bg-blue-50 dark:bg-slate-800 text-slate-800 dark:text-gray-100">

            <!-- Input Nama -->
            <div>
                <x-ui.label label="{{ __('general.label.name') }}" name="name" />
                <x-ui.input type="text" wire:model="name" placeholder="Input your KPI name" />
            </div>

            <!-- Tabel indikator -->
            <h6 class="text-base font-semibold text-slate-700 dark:text-slate-300">
                @lang('performance.label.indicator')
            </h6>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                    <thead class="bg-slate-100 dark:bg-slate-700">
                        <tr>
                            <th class="px-2 py-2">@lang('performance.label.aspect')</th>
                            <th class="px-2 py-2">@lang('performance.label.description')</th>
                            <th class="px-2 py-2">@lang('performance.label.target')</th>
                            <th class="px-2 py-2">@lang('performance.label.unit')</th>
                            <th class="px-2 py-2 w-24">@lang('performance.label.weight')</th>
                            <th class="px-2 py-2 text-center">@lang('general.label.active')</th>
                            <th class="px-2 py-2 text-center">@lang('general.label.action')</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($indicators as $index => $item)
                        <tr class="{{ $item['locked'] ? 'bg-slate-100 dark:bg-slate-800' : '' }}">
                            <td class="px-2 py-2">
                                <input type="text"
                                       class="px-3 py-2 w-full rounded-md border-slate-300 shadow-sm 
                                              focus:border-tosca-500 focus:ring focus:ring-tosca-200 
                                              dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100"
                                       @if($item['locked']) disabled @endif
                                       wire:model="indicators.{{ $index }}.aspect"
                                       placeholder="Aspect">
                            </td>
                            <td class="px-2 py-2">
                                <textarea rows="2"
                                          class="px-3 py-2 w-full rounded-md border-slate-300 shadow-sm 
                                                 focus:border-tosca-500 focus:ring focus:ring-tosca-200 
                                                 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100"
                                          @if($item['locked']) disabled @endif
                                          wire:model="indicators.{{ $index }}.description"
                                          placeholder="Description"></textarea>
                            </td>
                            <td class="px-2 py-2">
                                <x-ui.input type="number" wire:model="indicators.{{ $index }}.target" placeholder="Target"/>
                            </td>
                            <td class="px-2 py-2">
                                <select class="px-3 py-2 w-full rounded-md border-slate-300 shadow-sm 
                                               focus:border-tosca-500 focus:ring focus:ring-tosca-200 
                                               dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100"
                                        wire:model="indicators.{{ $index }}.unit_id">
                                    <option value="">Pilih Satuan</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-2 py-2">
                                <div class="flex items-center">
                                    <x-ui.input 
                                        type="text" 
                                        wire:model.lazy="indicators.{{ $index }}.weight"
                                        placeholder="Bobot" />
                                    <span class="ml-2 text-slate-600 dark:text-slate-400">%</span>
                                </div>
                            </td>
                            <td class="px-2 py-2 text-center">
                                    <x-ui.input type="checkbox" wire:model="indicators.{{ $index }}.active"/>
                            </td>
                            <td class="px-2 py-2 text-center">
                                @if(empty($item['locked']))
                                    <button wire:click="removeIndicator({{ $index }})"
                                        class="inline-flex items-center px-3 py-2 bg-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-900/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m-5 5l4 4m0-4l-4 4"/></svg>
                                    </button>
                                @else
                                    <button 
                                        class="inline-flex items-center px-3 py-2 bg-slate-100 text-slate-400 rounded-lg cursor-not-allowed transition-all dark:bg-slate-800/30 dark:text-slate-500" 
                                        disabled
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            width="24" height="24" viewBox="0 0 24 24">
                                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                <path d="M5 13a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2z"/>
                                                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 1 0-2 0m-3-5V6a4 4 0 0 1 8 0"/>
                                            </g>
                                        </svg>
                                    </button>

                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between gap-4 mt-2">
                <strong class="text-slate-700 dark:text-slate-300 text-sm leading-none">
                    Total Weight: {{ $totalWeight }}%
                </strong>

                <button class="inline-flex items-center px-2 py-1 bg-tosca-600 text-white rounded hover:bg-tosca-700"
                        wire:click="addIndicator">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9s-9-1.8-9-9s1.8-9 9-9m3 9H9m3-3v6"/>
                    </svg>
                </button>
            </div>


            <hr class="my-4 border-slate-200 dark:border-slate-700">

            <div class="mt-3 flex items-center justify-between">
                @if($isEditing)
                    <x-swal-confirm 
                        title="Hapus KPI?" 
                        text="Apakah Anda yakin ingin menghapus KPI {{ $name }}?"
                        callback="delete"
                        :id="$editingId"
                        class="inline-flex items-center p-2 bg-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-900/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white rounded-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m-5 5l4 4m0-4l-4 4"/></svg>

                    </x-swal-confirm>
                @else
                    <div></div>
                @endif

                <div class="flex gap-2">
                    <x-action-button type="cancel" @click="onClose()">
                        @lang('general.label.cancel')
                    </x-action-button>

                    <x-action-button type="save" wire:click="save">
                        @lang('general.label.save')
                    </x-action-button>
                </div>
            </div>
        </div>
    </x-ui.modal>
</div>
