@props([
    'label' => 'Stats',
    'value' => 0,
    'icon' => 'mdi:chart-bar',
    'color' => 'tosca',
    'trend' => null,
    'trendUp' => null
])

@php
    $colors = [
        'tosca' => 'bg-tosca-500 text-tosca-500',
        'emerald' => 'bg-emerald-500 text-emerald-500',
        'rose' => 'bg-rose-500 text-rose-500',
        'blue' => 'bg-blue-500 text-blue-500',
        'amber' => 'bg-amber-500 text-amber-500',
    ];
    $currentColor = $colors[$color] ?? $colors['tosca'];
    $bgOpacity = str_replace('bg-', 'bg-opacity-10 bg-', $currentColor);
@endphp

<div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-[2rem] p-6 border-2 border-slate-50 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 group"
     x-data="{ current: 0, target: {{ $value }} }"
     x-init="setTimeout(() => { 
        let start = 0;
        let duration = 1000;
        let step = Math.ceil(target / (duration / 16));
        let timer = setInterval(() => {
            start += step;
            if (start >= target) {
                current = target;
                clearInterval(timer);
            } else {
                current = start;
            }
        }, 16);
     }, 200)">
    
    <div class="flex items-start justify-between">
        <div class="space-y-3">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">
                {{ $label }}
            </p>
            
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl font-black text-slate-800 dark:text-white" 
                    x-text="current.toLocaleString()">
                    0
                </h3>
                
                @if($trend)
                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full {{ $trendUp === 'true' ? 'bg-emerald-100 text-emerald-600' : ($trendUp === 'false' ? 'bg-rose-100 text-rose-600' : 'bg-slate-100 text-slate-500') }}">
                        {{ $trend }}
                    </span>
                @endif
            </div>
        </div>

        <div class="p-4 rounded-2xl transition-transform duration-500 group-hover:scale-110 {{ $bgOpacity }}">
            <iconify-icon icon="{{ $icon }}" width="28" class="{{ explode(' ', $currentColor)[1] }}"></iconify-icon>
        </div>
    </div>

    {{-- Decorative Background Element --}}
    <div class="absolute -right-4 -bottom-4 opacity-[0.03] dark:opacity-[0.05] group-hover:opacity-[0.08] transition-opacity">
        <iconify-icon icon="{{ $icon }}" width="120"></iconify-icon>
    </div>
</div>