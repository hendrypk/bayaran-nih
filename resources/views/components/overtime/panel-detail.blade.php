<template x-if="active && selected">
    <div 
        class="hidden lg:block lg:w-1/4 sticky top-6 z-20"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-12">
        
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border-2 border-slate-100 dark:border-slate-800 shadow-2xl overflow-hidden flex flex-col max-h-[85vh]">
            
            {{-- Header Mini (Tetap) --}}
            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-tosca-500 flex-shrink-0 flex items-center justify-center text-white font-black text-sm shadow-inner"
                     x-text="selected.employee.name.substring(0,2).toUpperCase()">
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-black text-slate-800 dark:text-white truncate" x-text="selected.employee.name"></h4>
                    <p class="text-[10px] font-bold text-slate-400 tracking-tighter" x-text="selected.date_display"></p>
                </div>
                <button @click="active = false; selected = null" class="text-slate-300 hover:text-rose-500 transition-colors">
                    <iconify-icon icon="mdi:close-circle" width="20"></iconify-icon>
                </button>
            </div>

            {{-- Content Area --}}
            <div class="flex-1 overflow-y-auto scrollbar-hide p-4 space-y-5">
                
                {{-- Status & Quick Stats (Dibuat lebih compact) --}}
                <div class="space-y-3">
                    <div class="flex justify-center">
                        <span class="px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em]"
                            :class="selected.status === null ? 'bg-amber-100 text-amber-600' : (selected.status ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600')"
                            x-text="selected.status === null ? 'Pending' : (selected.status ? 'Approved' : 'Rejected')">
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="p-2 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-700 text-center">
                            <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest">Durasi</p>
                            <p class="text-xs font-black text-tosca-600" x-text="selected.duration"></p>
                        </div>
                        <div class="p-2 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-700 text-center">
                            <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest">Waktu</p>
                            <p class="text-[9px] font-black text-slate-700 dark:text-slate-300" x-text="selected.start_at_time + '-' + selected.end_at_time"></p>
                        </div>
                    </div>
                </div>

                {{-- Visual Grid (In & Out side by side) --}}
                <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                    {{-- Side In --}}
                    <div class="space-y-2">
                        <div class="flex items-center gap-1 text-tosca-500 font-black text-[9px] uppercase tracking-tighter">
                            <iconify-icon icon="mdi:clock-check" width="12"></iconify-icon> Mulai
                        </div>
                        <div class="space-y-1">
                            <div class="aspect-square rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm">
                                <template x-if="selected.photo_in_url">
                                    <img :src="selected.photo_in_url" class="w-full h-full object-cover">
                                </template>
                                <div x-show="!selected.photo_in_url" class="flex h-full items-center justify-center text-[8px] text-slate-400 italic">No Photo</div>
                            </div>
                            <div :id="'mapIn_' + idSuffix" wire:ignore class="aspect-square rounded-xl bg-slate-100 border"></div>
                        </div>
                    </div>

                    {{-- Side Out --}}
                    <div class="space-y-2">
                        <div class="flex items-center gap-1 text-rose-500 font-black text-[9px] uppercase tracking-tighter">
                            <iconify-icon icon="mdi:clock-out" width="12"></iconify-icon> Selesai
                        </div>
                        <div class="space-y-1">
                            <div class="aspect-square rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm">
                                <template x-if="selected.photo_out_url">
                                    <img :src="selected.photo_out_url" class="w-full h-full object-cover">
                                </template>
                                <div x-show="!selected.photo_out_url" class="flex h-full items-center justify-center text-[8px] text-slate-400 italic">No Photo</div>
                            </div>
                            <div :id="'mapOut_' + idSuffix" wire:ignore class="aspect-square rounded-xl bg-slate-100 border"></div>
                        </div>
                    </div>
                </div>

                {{-- Unified Notes --}}
                <div class="space-y-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <div class="p-2 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-700">
                        <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest mb-1">Catatan Karyawan</p>
                        <div class="space-y-2">
                            <div>
                                <span class="text-[8px] font-bold text-tosca-500">IN:</span>
                                <span class="text-[10px] text-slate-600 dark:text-slate-400" x-text="selected.note_in || '-'"></span>
                            </div>
                            <div x-show="selected.note_out">
                                <span class="text-[8px] font-bold text-rose-500">OUT:</span>
                                <span class="text-[10px] text-slate-600 dark:text-slate-400" x-text="selected.note_out || '-'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800">
                
                <div class="flex gap-2" x-show="selected.status === null">
                    <button 
                        @click="$wire.updateStatus(selected.id, false)" 
                        wire:loading.attr="disabled"
                        wire:target="updateStatus"
                        class="flex-1 py-3 rounded-2xl bg-white dark:bg-slate-900 text-rose-600 border border-rose-100 dark:border-rose-900/30 text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all shadow-sm flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="updateStatus">Reject</span>
                        <span wire:loading wire:target="updateStatus" class="animate-spin"><iconify-icon icon="lucide:loader-2"></iconify-icon></span>
                    </button>

                    <button 
                        @click="$wire.updateStatus(selected.id, true)" 
                        wire:loading.attr="disabled"
                        wire:target="updateStatus"
                        class="flex-1 py-3 rounded-2xl bg-tosca-600 text-white text-[10px] font-black uppercase tracking-widest hover:bg-tosca-700 transition-all shadow-md shadow-tosca-200 flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="updateStatus">Approve</span>
                        <span wire:loading wire:target="updateStatus" class="animate-spin"><iconify-icon icon="lucide:loader-2"></iconify-icon></span>
                    </button>
                </div>

                <div x-show="selected.status !== null" 
                    x-transition:enter="transition ease-out duration-300"
                    class="space-y-3">
                    <div class="text-center p-3 rounded-2xl bg-slate-100 dark:bg-slate-800/50 border border-dashed border-slate-300 dark:border-slate-700">
                        <p class="text-[9px] font-bold text-slate-500 italic">
                            Permintaan ini telah <span x-text="selected.status ? 'Disetujui' : 'Ditolak'"></span>
                        </p>
                        
                        <button @click="selectedData.status = null" 
                            class="mt-2 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-[8px] font-black uppercase tracking-widest hover:text-tosca-600 transition-all shadow-sm">
                            <iconify-icon icon="lucide:rotate-ccw" width="10"></iconify-icon>
                            Ubah Keputusan
                        </button>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</template>