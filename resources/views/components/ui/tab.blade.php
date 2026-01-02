@props([
    'options' => [], // Format: ['value' => 'Label']
    'active' => null,
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-8 overflow-x-auto scrollbar-hide py-2']) }}>
    @foreach($options as $val => $label)
        <button 
            wire:click="$set('status', '{{ $val }}')" 
            type="button"
            class="group relative flex flex-col items-center gap-1.5 transition-all outline-none"
        >
            {{-- Label --}}
            <span class="text-[10px] font-black uppercase tracking-[0.2em] transition-colors
                {{ $active === $val 
                    ? 'text-tosca-600 dark:text-tosca-400' 
                    : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-200' 
                }}">
                {{ $label }}
            </span>
            
            {{-- Indikator Titik --}}
            <div class="h-1.5 w-1.5 rounded-full transition-all duration-300
                {{ $active === $val 
                    ? 'bg-tosca-500 scale-100 shadow-[0_0_8px_rgba(20,184,166,0.6)]' 
                    : 'bg-transparent scale-0 group-hover:bg-slate-300 group-hover:scale-50' 
                }}">
            </div>
        </button>
    @endforeach
</div>