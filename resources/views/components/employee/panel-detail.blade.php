<template x-if="showDetail && selectedEmployee">
    <div 
        class="hidden lg:block lg:w-1/3 sticky top-6 z-20"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-12">
        
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border-2 border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/50 dark:shadow-none overflow-hidden">
            
            {{-- 1. Mini Header (Sangat Ringkas) --}}
            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-cyan-600 flex-shrink-0 flex items-center justify-center text-white font-black text-sm shadow-inner">
                    <span x-text="selectedEmployee.name.substring(0,2).toUpperCase()"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-black text-slate-800 dark:text-white truncate" x-text="selectedEmployee.name"></h4>
                    <p class="text-[10px] font-bold text-slate-400 tracking-tighter" x-text="'EID: ' + selectedEmployee.eid"></p>
                </div>
                <button @click="showDetail = false; selectedEmployee = null" class="text-slate-300 hover:text-rose-500 transition-colors">
                    <iconify-icon icon="mdi:close-circle" width="20"></iconify-icon>
                </button>
            </div>

            <div class="p-4 space-y-3">
                
                {{-- 2. Row Masa Kerja & Rekening (Data Paling Dicari) --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="p-3 bg-cyan-50 dark:bg-cyan-900/20 rounded-2xl border border-cyan-100 dark:border-cyan-800/50">
                        <div class="flex items-center gap-1.5 text-cyan-600 dark:text-cyan-400 mb-1">
                            <iconify-icon icon="mdi:clock-fast" width="14"></iconify-icon>
                            <span class="text-[9px] font-black uppercase">Masa Kerja</span>
                        </div>
                        <p class="text-xs font-black text-slate-700 dark:text-slate-200" x-text="calculateDuration(selectedEmployee.joining_date)"></p>
                    </div>
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800/50">
                        <div class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 mb-1">
                            <iconify-icon icon="mdi:bank" width="14"></iconify-icon>
                            <span class="text-[9px] font-black uppercase" x-text="selectedEmployee.bank || 'Bank'"></span>
                        </div>
                        <p class="text-xs font-black text-slate-700 dark:text-slate-200 truncate" x-text="selectedEmployee.bank_number || '-'"></p>
                    </div>
                </div>

                {{-- 3. Info Pekerjaan (Full Width) --}}
                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-800/50 rounded-2xl space-y-2">
                    <div class="flex items-start gap-3">
                        <iconify-icon icon="mdi:tie" class="text-slate-400 mt-0.5" width="16"></iconify-icon>
                        <div>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">Jabatan & Struktur</p>
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-200 leading-tight">
                                {{-- Mengambil Nama Jabatan --}}
                                <span x-text="selectedEmployee.position?.name || '-'"></span>
                            </p>
                            {{-- Mengambil Division dan Department melalui relasi Position --}}
                            <p class="text-[10px] text-slate-500 italic mt-0.5">
                                <span x-text="selectedEmployee.position?.division?.name || '-'"></span>
                                <span class="mx-1">›</span>
                                <span x-text="selectedEmployee.position?.department?.name || '-'"></span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 border-t border-slate-200 dark:border-slate-700 pt-2">
                        <iconify-icon icon="mdi:whatsapp" class="text-emerald-500 mt-0.5" width="16"></iconify-icon>
                        <div class="flex-1 flex justify-between items-center">
                            <div>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">WhatsApp</p>
                                <p class="text-xs font-bold text-slate-700 dark:text-slate-200" x-text="selectedEmployee.whatsapp"></p>
                            </div>
                            <a :href="'https://wa.me/'+selectedEmployee.whatsapp" target="_blank" class="bg-emerald-500 text-white p-1 rounded-lg shadow-sm">
                                <iconify-icon icon="mdi:arrow-top-right-bold-box" width="14"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 4. Grid Data Pribadi (Compact 3-Columns) --}}
                <div class="grid grid-cols-3 gap-2 py-2">
                    <div class="text-center p-2 rounded-xl border border-slate-50 dark:border-slate-800">
                        <p class="text-[8px] text-slate-400 font-bold uppercase">Goldar</p>
                        <p class="text-[10px] font-black text-rose-600" x-text="selectedEmployee.blood_type || '-'"></p>
                    </div>
                    <div class="text-center p-2 rounded-xl border border-slate-50 dark:border-slate-800">
                        <p class="text-[8px] text-slate-400 font-bold uppercase">Gender</p>
                        <p class="text-[10px] font-black text-slate-700 dark:text-slate-200" x-text="selectedEmployee.gender === 'Laki-laki' ? 'L' : 'P'"></p>
                    </div>
                    <div class="text-center p-2 rounded-xl border border-slate-50 dark:border-slate-800">
                        <p class="text-[8px] text-slate-400 font-bold uppercase">Agama</p>
                        <p class="text-[10px] font-black text-slate-700 dark:text-slate-200" x-text="selectedEmployee.religion || '-'"></p>
                    </div>
                </div>

                {{-- 5. Domisili (Text Area) --}}
                <div class="p-3 bg-slate-50 dark:bg-slate-800/30 rounded-2xl border-l-4 border-cyan-500">
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">Alamat Tinggal</p>
                    <p class="text-[11px] font-medium text-slate-600 dark:text-slate-300 leading-relaxed italic" x-text="selectedEmployee.domicile || selectedEmployee.city"></p>
                </div>

                {{-- 6. Footer Buttons (Side by Side) --}}
                <div class="flex gap-2 pt-2">
                    {{-- <x-action-button type="view" href="'/employee/detail/' + selectedEmployee.id" /> --}}
                    <a :href="'/employee/detail/' + selectedEmployee.id" class="flex-1 bg-slate-800 hover:bg-black text-white text-center py-2.5 rounded-xl text-[10px] font-black transition-all">
                        PROFIL PENUH
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>