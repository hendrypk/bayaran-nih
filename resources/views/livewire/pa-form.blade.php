<div class="p-6">
    <x-ui.modal>
        {{-- Header Section --}}
        <div class="mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white uppercase tracking-tight">
                {{ $isEditing ? __('Edit Penilaian Kinerja') : __('Tambah Penilaian Kinerja') }}
            </h3>
            <p class="text-xs text-slate-500 mt-1">
                @lang('performance.label.pa_name') : <span class="font-bold text-tosca-600">{{ $paName }}</span>
            </p>
        </div>

        {{-- Main Content (Tanpa Form Tag) --}}
        <div class="space-y-8">
            
            {{-- Section 1: Data Karyawan & Periode --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-4">
                        <x-ui.select2 
                        label="{{ __('general.label.name') }}" 
                        wire:model.live="employeeId"
                        placeholder="{{ __('performance.placeholders.select_employee') }}"
                        :options="$employees->pluck('name', 'id')"
                        />
                </div>

                <div class="md:col-span-2">
                    <x-ui.input 
                        label="{{ __('employee.label.eid') }}" 
                        wire:model="eid" 
                        readonly disabled 
                        class="bg-slate-50 dark:bg-slate-800 font-bold" />
                </div>

                <div class="md:col-span-6">
                    <x-ui.input 
                        label="{{ __('employee.label.job_title') }}" 
                        wire:model="positionName" 
                        readonly disabled 
                        class="bg-slate-50 dark:bg-slate-800 font-bold" />
                </div>

                <div class="md:col-span-3">
                    <x-ui.select2 label="{{ __('general.label.month') }}" wire:model.live="month">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                        @endforeach
                    </x-ui.select2>
                </div>
                
                <div class="md:col-span-3">
                    <x-ui.select2 label="{{ __('general.label.year') }}" wire:model.live="year">
                        @foreach(range(date('Y') - 1, date('Y') + 5) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </x-ui.select2>
                </div>
            </div>

            {{-- Section 2: Tabel Input Nilai --}}
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm">
                @if($pas && $pas->count())
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">@lang('performance.label.aspect')</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">@lang('performance.label.description')</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center w-32">@lang('performance.label.achievement')</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($pas as $index => $pa)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200">{{ $pa->aspect ?? '—' }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $pa->description ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <x-ui.input 
                                    type="number" 
                                    wire:model.blur="achievement.{{ $index }}"
                                    class="text-center !rounded-xl !py-1 font-bold text-tosca-600 focus:ring-tosca-500" />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-tosca-50 dark:bg-tosca-900/20 border-t border-tosca-100 dark:border-tosca-800">
                            <td colspan="2" class="px-6 py-5 text-sm font-black text-tosca-700 dark:text-tosca-400 text-right uppercase tracking-widest">
                                @lang('performance.label.grade')
                            </td>
                            <td class="px-6 py-5 text-center font-black text-2xl text-tosca-600 dark:text-tosca-400">
                                {{ $this->grade }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                @else
                <div class="p-16 text-center">
                    <iconify-icon icon="lucide:search-x" width="48" class="text-slate-300 mb-4"></iconify-icon>
                    <p class="text-slate-400 italic text-sm font-medium">Silahkan pilih karyawan untuk memulai penilaian.</p>
                </div>
                @endif
            </div>

            {{-- Section 3: Log Activity (Hanya Edit) --}}
            @if($isEditing)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <div class="p-2 bg-white dark:bg-slate-900 rounded-lg shadow-sm text-slate-400">
                        <iconify-icon icon="lucide:plus-circle" width="18"></iconify-icon>
                    </div>
                    <div class="text-[11px]">
                        <span class="block text-slate-400 uppercase font-black tracking-tighter">@lang('general.label.created_by')</span>
                        <span class="font-bold text-slate-700 dark:text-slate-300">{{ $creator ?? '-' }}</span>
                        <span class="text-slate-400 italic font-medium">{{ $created ? ' • ' . $created->format('d M Y H:i') : '' }}</span>
                    </div>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <div class="p-2 bg-white dark:bg-slate-900 rounded-lg shadow-sm text-slate-400">
                        <iconify-icon icon="lucide:refresh-cw" width="18"></iconify-icon>
                    </div>
                    <div class="text-[11px]">
                        <span class="block text-slate-400 uppercase font-black tracking-tighter">@lang('general.label.updated_by')</span>
                        <span class="font-bold text-slate-700 dark:text-slate-300">{{ $updater ?? '-' }}</span>
                        <span class="text-slate-400 italic font-medium">{{ $updated ? ' • ' . $updated->format('d M Y H:i') : '' }}</span>
                    </div>
                </div>
            </div>
            @endif

            {{-- Footer Section --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-slate-100 dark:border-slate-800">
                <div class="w-full sm:w-auto">
                    @if($isEditing)
                        <x-swal-confirm 
                            title="Hapus Penilaian?" 
                            text="Tindakan ini permanen."
                            callback="delete"
                            :id="$paResultId"
                            class="flex items-center gap-2 px-4 py-2 text-rose-500 hover:bg-rose-50 rounded-xl font-bold text-xs transition-all tracking-wide">
                            <iconify-icon icon="lucide:trash-2"></iconify-icon>
                            HAPUS DATA
                        </x-swal-confirm>
                    @endif
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <button type="button" 
                            wire:click="$dispatch('closeModal')"
                            class="flex-1 sm:flex-none px-6 py-2.5 text-slate-400 font-black text-xs uppercase tracking-widest hover:text-slate-600 transition-colors">
                        @lang('general.label.cancel')
                    </button>
                    <button type="button" 
                            wire:click="save"
                            class="flex-1 sm:flex-none px-10 py-3 bg-tosca-600 hover:bg-tosca-700 text-white font-black rounded-2xl text-xs shadow-xl shadow-tosca-100 dark:shadow-none transition-all uppercase tracking-[0.2em]">
                        <span wire:loading.remove wire:target="save">@lang('general.label.save')</span>
                        <span wire:loading wire:target="save">MEMPROSES...</span>
                    </button>
                </div>
            </div>
        </div>
    </x-ui.modal>
</div>