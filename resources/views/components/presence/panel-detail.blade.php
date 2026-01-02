<template x-if="active && selected">
    <div 
        class="hidden lg:block lg:w-1/4 sticky top-6 z-20"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-12">
        
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border-2 border-slate-100 dark:border-slate-800 shadow-2xl overflow-hidden">
            
            {{-- 1. Mini Header --}}
            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-tosca-500 flex-shrink-0 flex items-center justify-center text-white font-black text-sm shadow-inner"
                     x-text="selected.employee.name.substring(0,2).toUpperCase()">
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-black text-slate-800 dark:text-white truncate" x-text="selected.employee.name"></h4>
                    <p class="text-[10px] font-bold text-slate-400 tracking-tighter" x-text="selected.date"></p>
                </div>
                <button @click="active = false; selected = null" class="text-slate-300 hover:text-rose-500 transition-colors">
                    <iconify-icon icon="mdi:close-circle" width="20"></iconify-icon>
                </button>
            </div>

            <div class="p-4 space-y-3 max-h-[70vh] overflow-y-auto scrollbar-hide">
                
                {{-- 2. In/Out Status Summary --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100">
                        <p class="text-[8px] font-black text-emerald-600 uppercase">Masuk</p>
                        <p class="text-sm font-black text-slate-700 dark:text-emerald-400" x-text="selected.check_in || '--:--'"></p>
                    </div>
                    <div class="p-2 bg-rose-50 dark:bg-rose-900/20 rounded-2xl border border-rose-100">
                        <p class="text-[8px] font-black text-rose-600 uppercase">Keluar</p>
                        <p class="text-sm font-black text-slate-700 dark:text-rose-400" x-text="selected.check_out || '--:--'"></p>
                    </div>
                </div>

                {{-- 3. Group: Check In Detail --}}
                <div class="space-y-2 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex items-center gap-2 text-emerald-500">
                        <iconify-icon icon="mdi:login-variant" width="14"></iconify-icon>
                        <span class="text-[10px] font-black uppercase tracking-wider">Detail Check In</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        {{-- Foto In --}}
                        <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden relative border border-slate-200">
                            <template x-if="selected.photo_in_url">
                                <img :src="selected.photo_in_url" class="w-full h-full object-cover">
                            </template>
                            <div x-show="!selected.photo_in_url" class="flex h-full items-center justify-center text-[8px] text-slate-400 font-bold italic">No Photo</div>
                            </div>
                            {{-- Map In --}}
                            <div :id="'mapIn_' + idSuffix" wire:ignore class="aspect-square rounded-xl bg-slate-100 border"></div>
                    </div>
                </div>

                {{-- 4. Group: Check Out Detail --}}
                <div class="space-y-2" x-show="selected.check_out">
                    <div class="flex items-center gap-2 text-rose-500">
                        <iconify-icon icon="mdi:logout-variant" width="14"></iconify-icon>
                        <span class="text-[10px] font-black uppercase tracking-wider">Detail Check Out</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        {{-- Foto Out --}}
                        <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden relative border border-slate-200">
                            <template x-if="selected.photo_out_url">
                                <img :src="selected.photo_out_url" class="w-full h-full object-cover">
                            </template>
                            <div x-show="!selected.photo_out_url" class="flex h-full items-center justify-center text-[8px] text-slate-400 font-bold italic">No Photo</div>
                        </div>
                        {{-- Map Out --}}
                        <div :id="'mapOut_' + idSuffix" wire:ignore class="aspect-square rounded-xl bg-slate-100 border"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>