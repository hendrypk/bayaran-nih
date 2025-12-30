@props(['type' => 'neutral'])

@php
    $colors = [
        'success' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400',
        'danger'  => 'bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400',
        'warning' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400',
        'info'    => 'bg-cyan-50 text-cyan-600 dark:bg-cyan-900/20 dark:text-cyan-400',
        'neutral' => 'bg-slate-50 text-slate-600 dark:bg-slate-800 dark:text-slate-400',
    ];
@endphp

<span {{ $attributes->merge(['class' => "text-center px-1 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {$colors[$type]}"]) }}>
    {{ $slot }}
</span>