@props([
    'id' => 'datatable',
    'headers' => [],
    'collection' => null // Tambahkan ini untuk data pagination
])

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="{{ $id }}" class="datatable min-w-full table-auto text-sm text-left border-collapse">
            <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400">
                <tr class="border-b border-slate-200 dark:border-slate-700">
                    @foreach($headers as $header)
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    {{-- Footer Otomatis --}}
    @if($collection && method_exists($collection, 'hasPages') && $collection->hasPages())
        <div class="px-6 py-4 bg-slate-50/30 dark:bg-slate-800/20 border-t border-slate-100 dark:border-slate-800">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                {{-- Info Data --}}
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    {{ $collection->firstItem() }}-{{ $collection->lastItem() }} dari {{ $collection->total() }}
                </div>
                
                {{-- Navigasi --}}
                <div class="flex items-center gap-1">
                    {{-- Prev --}}
                    <button wire:click="previousPage" wire:loading.attr="disabled"
                            @if($collection->onFirstPage()) disabled @endif
                            class="px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 text-[10px] font-black transition-all {{ $collection->onFirstPage() ? 'opacity-30 cursor-not-allowed' : 'hover:bg-tosca-500 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
                    </button>

                    {{-- Angka --}}
                    <div class="flex items-center gap-1 mx-1">
                        @foreach ($collection->getUrlRange(1, $collection->lastPage()) as $page => $url)
                            @if ($page == 1 || $page == $collection->lastPage() || abs($page - $collection->currentPage()) <= 1)
                                <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled"
                                        class="min-w-[32px] h-8 rounded-lg text-[10px] font-black transition-all border {{ $page == $collection->currentPage() ? 'bg-tosca-500 border-tosca-500 text-white shadow-sm' : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:border-tosca-500' }}">
                                    {{ $page }}
                                </button>
                            @elseif ($page == 2 || $page == $collection->lastPage() - 1)
                                <span class="px-1 text-slate-400 text-[10px]">...</span>
                            @endif
                        @endforeach
                    </div>

                    {{-- Next --}}
                    <button wire:click="nextPage" wire:loading.attr="disabled"
                            @if(!$collection->hasMorePages()) disabled @endif
                            class="px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 text-[10px] font-black transition-all {{ !$collection->hasMorePages() ? 'opacity-30 cursor-not-allowed' : 'hover:bg-tosca-500 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>