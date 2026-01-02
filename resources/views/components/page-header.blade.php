{{-- <div class="py-2 mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
        <div class="w-1 bg-cyan-500 h-6 rounded-full"></div>
        <h5 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-tight">
            {{ $slot }}
        </h5>
    </div>
</div> --}}
@props([
    'links' => []
])

<div class="py-3 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-800/50">
    {{-- SISI KIRI: Judul Halaman --}}
    <div class="flex items-center gap-2.5">
        <div class="w-1 bg-tosca-500 h-5 rounded-full shadow-[0_0_8px_rgba(20,184,166,0.3)]"></div>
        <h1 class="text-sm font-black text-slate-700 dark:text-slate-200 uppercase tracking-tight">
            {{ $slot }}
        </h1>
    </div>

    {{-- SISI KANAN: Breadcrumb --}}
    @if(!empty($links))
        <div class="shrink-0 scale-90 origin-right sm:scale-100"> 
            {{-- scale-90 membuat breadcrumb sedikit lebih kecil lagi di mobile --}}
            <x-ui.breadcrumb :links="$links" />
        </div>
    @endif
</div>