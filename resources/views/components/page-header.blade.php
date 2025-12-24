    {{-- Header Actions --}}
    <div class="px-4 py-2 mx-4 mb-4 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl border border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <div class="w-1 bg-cyan-500 h-6 rounded-full"></div>
            <h5 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-tight">
                {{ $slot }}
            </h5>
        </div>
        
    </div>