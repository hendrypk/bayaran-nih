@props([
    'options' => [], // Format: ['value' => 'Label']
    'active' => null,
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-8 overflow-x-auto scrollbar-hide py-2']) }}>
@foreach ($options as $val => $option)
    @php
        $label = is_array($option) ? $option['label'] : $option;
        $count = is_array($option) ? ($option['count'] ?? null) : null;
    @endphp

    <button
        wire:click="$set('status', '{{ $val }}')"
        class="group relative flex flex-col items-center gap-1"
    >
        {{-- LABEL --}}
        <span class="relative text-[10px] font-black uppercase tracking-[0.2em] transition-colors
            {{ $active === $val 
                ? 'text-tosca-600 dark:text-tosca-400' 
                : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-200' 
            }}">
            {{ $label }}

            {{-- COUNT BADGE (OPSIONAL) --}}
            @if(!is_null($count))
                <span class="absolute -top-1.5 -right-3
                             min-w-[14px] h-[14px] px-1
                             rounded-full flex items-center justify-center
                             text-[9px] font-black text-white
                             transition-all duration-300
                    {{ $active === $val
                        ? 'bg-tosca-500 shadow-[0_0_6px_rgba(20,184,166,0.6)]'
                        : 'bg-slate-300 group-hover:bg-slate-400'
                    }}">
                    {{ $count > 99 ? '99+' : $count }}
                </span>
            @endif
        </span>

        {{-- DOT (HANYA ACTIVE) --}}
        @if($active === $val)
            <span class="h-1.5 w-1.5 rounded-full bg-tosca-500
                         shadow-[0_0_8px_rgba(20,184,166,0.6)]">
            </span>
        @endif
    </button>
@endforeach

</div>