<x-ui.modal> {{-- Batas lebar ideal 1280px --}}
    <div class="flex flex-col max-h-[90vh]"> {{-- Bungkus seluruh isi modal --}}
        <x-slot name="title">
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-cyan-500/10 text-cyan-500 rounded-lg">
                        <iconify-icon icon="lucide:settings-2" width="24"></iconify-icon>
                    </div>
                    <span class="font-bold text-slate-800 dark:text-white">Konfigurasi Pola Kerja</span>
                </div>
                <div class="text-[10px] bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full text-slate-500 font-bold uppercase tracking-widest">
                    ID: {{ $selectedId ?? 'NEW' }}
                </div>
            </div>
        </x-slot>

        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Row Atas Tetap Sama --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50 dark:bg-slate-800/40 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                <div class="space-y-2">
                    <label class="form-label-puffy">Nama Pola</label>
                    <input type="text" wire:model="name" class="form-input-puffy" placeholder="Shift Kantor">
                </div>
                <div class="space-y-2">
                    <label class="form-label-puffy">Toleransi (Menit)</label>
                    <input type="number" wire:model="tolerance" class="form-input-puffy">
                </div>
                <div class="space-y-2">
                    <label class="form-label-puffy">Hitung Terlambat</label>
                    <select wire:model="count_late" class="form-input-puffy">
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>
            </div>

            {{-- Table dengan Tombol Apply To All --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2.5rem] overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-900 dark:bg-slate-950 text-white">
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest w-40">Hari</th>
                                <th class="px-4 py-5 text-[10px] font-black uppercase tracking-widest text-center w-24">Libur</th>
                                
                                {{-- Header dengan Action --}}
                                @php
                                    $headers = [
                                        ['label' => 'Arrival', 'key' => 'arrival'],
                                        ['label' => 'Jam Masuk', 'key' => 'start_time'],
                                        ['label' => 'Jam Pulang', 'key' => 'end_time'],
                                        ['label' => 'Mulai Istirahat', 'key' => 'break_start'],
                                        ['label' => 'Selesai Istirahat', 'key' => 'break_end'],
                                    ];
                                @endphp

                                @foreach($headers as $h)
                                <th class="px-4 py-4 min-w-[140px]">
                                    <div class="flex flex-col gap-2">
                                        <span class="text-[10px] font-black uppercase tracking-widest">{{ $h['label'] }}</span>
                                        <button type="button" 
                                            wire:click="applyToAll('{{ $h['key'] }}')"
                                            class="flex items-center gap-1.5 w-fit bg-white/10 hover:bg-cyan-500 text-[9px] py-1 px-2 rounded-md transition-all group">
                                            <iconify-icon icon="lucide:copy-check" class="group-hover:animate-bounce"></iconify-icon>
                                            Samakan
                                        </button>
                                    </div>
                                </th>
                                @endforeach
                                <th class="px-4 py-5 text-[10px] font-black uppercase tracking-widest text-center">
                                    <div class="group relative flex justify-center items-center gap-1 cursor-pointer">
                                        <span>EXC. BREAK</span>
                                        <iconify-icon icon="lucide:help-circle" width="12" class="text-slate-400"></iconify-icon>
                                        
                                        <div class="absolute top-full right-0 mt-2 hidden group-hover:block w-56 p-2.5 bg-slate-800 text-[9px] text-white rounded-lg shadow-2xl z-[9999] normal-case font-medium leading-relaxed pointer-events-none border border-slate-700">
                                            <div class="relative z-10 text-left">
                                                Durasi istirahat **tidak akan memotong** total jam kerja harian jika opsi ini dicentang.
                                            </div>
                                            <div class="absolute bottom-full right-3 border-4 border-transparent border-b-slate-800"></div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        @php
                            $headers = [
                                ['label' => 'Arrival', 'key' => 'arrival'],
                                ['label' => 'Jam Masuk', 'key' => 'start_time'],
                                ['label' => 'Jam Pulang', 'key' => 'end_time'],
                                ['label' => 'Mulai Istirahat', 'key' => 'break_start'],
                                ['label' => 'Selesai Istirahat', 'key' => 'break_end'],
                            ];
                        @endphp

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            {{-- WAJIB: Tambahkan wire:key agar Livewire bisa melacak perubahan DOM --}}
                            <tr wire:key="workday-row-{{ $day }}-{{ $selectedId }}" 
                                class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all" 
                                x-data="{ isOff: @entangle('daysData.'.$day.'.is_offday') }">
                                
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-700 dark:text-slate-200">{{ $day }}</span>
                                </td>

                                {{-- Toggle Libur --}}
                                <td class="px-4 py-4 text-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" x-model="isOff" class="sr-only peer">
                                        <div class="w-11 h-6 bg-slate-200 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:bg-rose-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all shadow-inner"></div>
                                    </label>
                                </td>
                                
                                {{-- Dynamic Row Inputs --}}
                                @foreach($headers as $h)
                                <td class="px-4 py-4">
                                    <div class="relative" x-bind:class="isOff && 'opacity-20 grayscale pointer-events-none'">
                                        <input type="time" 
                                            wire:model="daysData.{{ $day }}.{{ $h['key'] }}" 
                                            class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl py-2 px-3 text-xs focus:ring-2 focus:ring-cyan-500 transition-all font-medium">
                                    </div>
                                </td>
                                @endforeach

                        <td class="px-4 py-4 text-center">
                            <div class="group relative flex justify-center" 
                                title="Exclude Break: Istirahat tidak memotong jam kerja"> {{-- Tooltip bawaan browser --}}
                                
                                <input type="checkbox" 
                                    wire:model="daysData.{{ $day }}.is_break" 
                                    x-bind:disabled="isOff"
                                    class="w-5 h-5 rounded-lg border-slate-300 text-cyan-500 focus:ring-cyan-500 
                                        dark:bg-slate-800 dark:border-slate-700 transition-transform hover:scale-110 cursor-pointer">
                                
                                <span class="absolute -top-8 hidden group-hover:block bg-cyan-600 text-white text-[9px] px-2 py-1 rounded whitespace-nowrap shadow-lg">
                                    Potong jam kerja?
                                </span>
                            </div>
                        </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                            <p class="text-xs text-slate-500 italic">
                    * Klik tombol <strong>"Samakan"</strong> di header untuk menyalin nilai hari Senin ke semua hari.
                </p>
        @if($isEditing)
            <x-slot:footer_left>
                <x-swal-confirm 
                    title="Hapus Presensi?" 
                    text="Data Presensi Akan Dihapus Permanen..."
                    callback="delete"
                    :id="$selectedId" 
                />
            </x-slot:footer_left>
        @endif
        </form>
    </div>
</x-ui.modal>