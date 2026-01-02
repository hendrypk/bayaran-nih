@props([
    'links' => []
])

<nav class="flex" aria-label="Breadcrumb">
    <ol class="flex items-center gap-1.5">
        {{-- Home Icon - Dikecilkan ukurannya --}}
        <li>
            <a href="{{ route('home') }}" class="flex items-center justify-center w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-slate-400 hover:text-tosca-500 transition-all shadow-sm">
                <iconify-icon icon="lucide:home" width="14"></iconify-icon>
            </a>
        </li>

        @foreach($links as $link)
            <li class="flex items-center gap-1.5">
                <iconify-icon icon="lucide:chevron-right" class="text-slate-300 dark:text-slate-600" width="12"></iconify-icon>

                @if($loop->last)
                    <span class="px-2 py-1 rounded-lg bg-slate-100/50 dark:bg-slate-800/50 text-[9px] font-black uppercase tracking-widest text-slate-500 dark:text-slate-400">
                        {{ $link['label'] }}
                    </span>
                @else
                    <a href="{{ $link['url'] ?? '#' }}" class="px-2 py-1 text-[9px] font-black uppercase tracking-widest text-slate-400 hover:text-tosca-500 transition-all">
                        {{ $link['label'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>