@props([
    'type' => 'edit',
    'onclick' => '',
    'href' => null, // Tambahkan prop href
    'label' => null, // Tambahkan prop label
    'modal' => null,      // Nama ID modal
    'modalTitle' => '',   // Judul modal
    'modalArgs' => [],    // Data tambahan untuk modal
    'modalSize' => '',
])

@php
    $config = [

        'add' => [
            'class' => 'bg-cyan-600 text-white hover:bg-cyan-700 shadow-md shadow-cyan-900/10 dark:shadow-none',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7v14"/></svg>'
        ],
        'save' => [
            'class' => 'bg-cyan-600 text-white hover:bg-cyan-700 shadow-lg shadow-cyan-600/20 dark:shadow-none',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>'
        ],

        // Data Management
        'import' => [
            'class' => 'bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white dark:bg-indigo-900/30 dark:text-indigo-400 dark:hover:bg-indigo-600 border border-indigo-100 dark:border-indigo-800',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>'
        ],
        'download' => [
            'class' => 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-600 border border-emerald-100 dark:border-emerald-800',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>'
        ],

        // Row Actions
        'edit' => [
            'class' => 'bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white dark:bg-amber-900/20 dark:text-amber-400 dark:hover:bg-amber-500 border border-amber-100 dark:border-amber-900/30',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>'
        ],
        'delete' => [
            'class' => 'bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-900/20 dark:text-rose-400 dark:hover:bg-rose-600 border border-rose-100 dark:border-rose-900/30',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18m-2 0v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6m3 0V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2m-6 9h4"/></svg>'
        ],
        'view' => [
            'class' => 'bg-slate-50 text-slate-600 hover:bg-slate-600 hover:text-white dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-slate-600 border border-slate-200 dark:border-slate-700',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>'
        ],

        // Navigation
        'cancel' => [
            'class' => 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-slate-700',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
        ],
        'filter' => [
            'class' => 'bg-white text-slate-600 border border-slate-200 hover:border-cyan-500 hover:text-cyan-600 dark:bg-slate-900 dark:text-slate-300 dark:border-slate-800 dark:hover:border-cyan-500',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>'
        ],
    ];

    $currentConfig = $config[$type] ?? $config['edit'];
    $displayText = $label ?? $slot->toHtml();
    $isIconOnly = empty($displayText);
    $tag = $href ? 'a' : 'button';

    // Logika Alpine untuk Modal
    $alpineClick = $modal 
        ? "\$dispatch('open-x-ilz-modal', { title: '$modalTitle', modal: '$modal', args: " . json_encode($modalArgs) . ", size: '$modalSize' })"
        : $onclick;
@endphp

<{{ $tag }} 
    @if($href) href="{{ $href }}" @endif
    @if($modal) x-data @endif
    {{ $attributes->merge([
        'type' => (!$href && $type === 'save' ? 'submit' : ($href ? null : 'button')),
        'x-on:click' => $modal ? $alpineClick : null,
        'onclick' => !$modal ? $onclick : null,
        'class' => 'inline-flex items-center justify-center transition-all duration-200 active:scale-95 ' . 
                   ($isIconOnly ? 'p-2 rounded-lg ' : 'px-4 py-2 rounded-xl font-semibold text-sm gap-2 ') . 
                   $currentConfig['class']
    ]) }}>
    
    {!! $currentConfig['icon'] !!}
    
    @if(!$isIconOnly)
        <span>{{ $displayText }}</span>
    @endif
</{{ $tag }}>