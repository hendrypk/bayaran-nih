@props([
    'type' => 'edit', // edit, delete, save, cancel
    'onclick' => '',
])

@php
    $config = [
        'edit' => [
            'class' => 'bg-emerald-100 text-emerald-600 hover:bg-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-600',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3"/><path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6"/></g></svg>'
        ],
        'delete' => [
            'class' => 'bg-rose-100 text-rose-600 hover:bg-rose-600 dark:bg-rose-900/30 dark:text-rose-400 dark:hover:bg-rose-600',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18m-2 0v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6m3 0V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2m-6 9h4"/></svg>'
        ],
        'save' => [
            'class' => 'bg-cyan-500 text-white hover:bg-cyan-600 shadow-sm shadow-cyan-500/30',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>'
        ],
        'cancel' => [
            'class' => 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-slate-700',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
        ]
    ];

    $currentConfig = $config[$type] ?? $config['edit'];
    $isIconOnly = empty($slot->toHtml());
@endphp

<button 
    {{ $attributes->merge([
        'type' => ($type === 'save' ? 'submit' : 'button'),
        'onclick' => $onclick,
        'class' => 'inline-flex items-center justify-center transition-all duration-200 active:scale-95 ' . 
                   ($isIconOnly ? 'p-2 rounded-lg ' : 'px-4 py-2 rounded-xl font-semibold text-sm gap-2 ') . 
                   $currentConfig['class']
    ]) }}>
    
    {!! $currentConfig['icon'] !!}
    
    @if(!$isIconOnly)
        <span>{{ $slot }}</span>
    @endif
</button>