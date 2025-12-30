    <div class="px-4 py-2 mx-4 mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-1 bg-cyan-500 h-6 rounded-full"></div>
            <h5 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-tight">
                {{ $slot }}
            </h5>
        </div>
    </div>

{{-- <div class="px-4 py-2 mx-4 mb-4 flex items-center justify-between group">
    <div class="flex items-center gap-3">
        <div class="w-1.5 bg-cyan-500 h-8 rounded-full shadow-[0_0_10px_rgba(6,182,212,0.4)] transition-all group-hover:h-10"></div>
        
        <div class="flex flex-col">
            <h5 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-wider leading-none">
                {{ $slot }}
            </h5>
            
            @if(isset($description))
                <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 mt-1.5 italic leading-tight">
                    {{ $description }}
                </p>
            @endif
        </div>
    </div>

    @if(isset($actions))
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div> --}}