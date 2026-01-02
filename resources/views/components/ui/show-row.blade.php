@props([
    'options' => [10, 25, 50, 100],
    'model' => 'perPage'
])

<div class="flex items-center gap-2 group">
    {{-- Label mungil yang muncul pas di-hover --}}
    <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] hidden md:block group-hover:text-tosca-500 transition-colors">
        Baris:
    </span>
    
    <div class="relative">
        <select 
            wire:model.live="{{ $model }}"
            class="appearance-none pl-3 pr-8 py-1.5 bg-slate-50 dark:bg-slate-800/50 border-none rounded-xl text-[11px] font-black text-slate-700 dark:text-slate-200 cursor-pointer focus:ring-2 focus:ring-tosca-500/20 transition-all shadow-sm hover:bg-slate-100 dark:hover:bg-slate-800"
        >
            @foreach($options as $val)
                <option value="{{ $val }}">{{ $val }}</option>
            @endforeach
        </select>
        
        {{-- Custom Arrow Icon --}}
        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none text-slate-400 group-hover:text-tosca-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </div>
    </div>
</div>