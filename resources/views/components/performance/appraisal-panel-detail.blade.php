
<template x-if="showDetail">
    <div class="w-full lg:w-1/3 sticky top-6 transition-all duration-500">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden w-full sticky top-6">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800 dark:text-white text-lg">Detail Hasil PA</h3>
                    <p class="text-xs text-slate-400" x-text="`Periode: ${selectedPA?.month}/${selectedPA?.year}`"></p>
                </div>
                <button @click="showDetail = false" class="p-2 hover:bg-rose-50 dark:hover:bg-rose-900/20 text-slate-400 hover:text-rose-500 rounded-full transition-all">
                    <iconify-icon icon="lucide:x" width="20"></iconify-icon>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[calc(100vh-200px)]">
                {{-- Info Karyawan --}}
                <div class="flex items-center gap-4 mb-8 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                    <div class="w-14 h-14 rounded-2xl bg-tosca-600 flex items-center justify-center text-white text-xl font-black shadow-lg shadow-tosca-200 dark:shadow-none">
                        <span x-text="selectedPA?.employees?.name.substring(0,2).toUpperCase()"></span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white text-base" x-text="selectedPA?.employees?.name"></h4>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-0.5 rounded-md bg-slate-200 dark:bg-slate-700 text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tighter" x-text="selectedPA?.appraisal_name?.name"></span>
                        </div>
                    </div>
                </div>

                {{-- Skor Akhir --}}
                <div class="bg-gradient-to-br from-tosca-500 to-emerald-600 rounded-3xl p-6 text-center text-white shadow-lg shadow-tosca-100 dark:shadow-none mb-8">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-1">Final Performance Grade</p>
                    <h2 class="text-5xl font-black" x-text="selectedPA?.grade"></h2>
                </div>

                {{-- List Detail Aspek --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between px-1">
                        <h5 class="text-xs font-black text-slate-400 uppercase tracking-widest">Rincian Penilaian</h5>
                        <span class="text-[10px] text-slate-400" x-text="`${selectedPA?.details?.length || 0} Aspek`"></span>
                    </div>
                    
                    <template x-for="detail in selectedPA?.details" :key="detail.id">
                        <div class="group p-4 border border-slate-100 dark:border-slate-800 rounded-2xl hover:border-tosca-200 dark:hover:border-tosca-800 transition-all">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tight" x-text="detail.aspect"></span>
                                <div class="bg-tosca-50 dark:bg-tosca-900/30 text-tosca-600 px-3 py-1 rounded-lg text-sm font-black" x-text="detail.achievement"></div>
                            </div>
                            <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed" x-text="detail.description"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>