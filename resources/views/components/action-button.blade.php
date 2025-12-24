@props([
    'type' => 'edit', // edit, delete, save, cancel
    'onclick' => '',
])

@php
    $config = [
        'view' => [
            'class' => 'bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-600',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>'
        ],
        'add' => [
            'class' => 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm shadow-indigo-500/30',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7v14"/></svg>'
        ],
        'download' => [
            'class' => 'bg-amber-100 text-amber-600 hover:bg-amber-600 hover:text-white dark:bg-amber-900/30 dark:text-amber-400 dark:hover:bg-amber-600',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>'
        ],
        'print' => [
            'class' => 'bg-slate-100 text-slate-600 hover:bg-slate-600 hover:text-white dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-slate-600',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>'
        ],
        'filter' => [
            'class' => 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-300 dark:border-slate-800 dark:hover:bg-slate-800',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>'
        ],
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