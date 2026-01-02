@props([
    'id' => 'datatable',
    'headers' => [],
    'collection' => null 
])

<div class="puffy-table-wrapper bg-white dark:bg-slate-900 rounded-2xl overflow-hidden shadow-sm border border-slate-100 dark:border-slate-800">
    <div class="overflow-x-auto">
        <table id="{{ $id }}" class="dataTable min-w-full">
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if($collection && method_exists($collection, 'hasPages') && $collection->hasPages())
        <div class="px-6 py-4 bg-slate-50/30 dark:bg-slate-800/20 border-t border-slate-100 dark:border-slate-800">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    {{ $collection->firstItem() }}-{{ $collection->lastItem() }} dari {{ $collection->total() }}
                </div>
                
                {{-- Separator --}}
                <div class="h-4 w-[1px] bg-slate-200 dark:bg-slate-700"></div>

                <div class="flex items-center gap-2 group">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] hidden md:block">Baris:</span>
                    <div class="relative">
                        <select 
                            wire:model.live="perPage"
                            class="appearance-none pl-3 pr-8 py-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-[11px] font-black text-slate-700 dark:text-slate-200 cursor-pointer focus:ring-2 focus:ring-tosca-500/20 transition-all shadow-sm"
                        >
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                </div>
            </div>
                
                <div class="puffy-pagination">
                    <div class="flex items-center gap-1">
                        <button wire:click="previousPage" @disabled($collection->onFirstPage()) 
                                class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 disabled:opacity-30 transition-all hover:bg-tosca-500 hover:text-white">
                            <iconify-icon icon="lucide:chevron-left"></iconify-icon>
                        </button>

                        @foreach ($collection->getUrlRange(max(1, $collection->currentPage() - 1), min($collection->lastPage(), $collection->currentPage() + 1)) as $page => $url)
                            <button wire:click="gotoPage({{ $page }})" 
                                    class="w-9 h-9 rounded-xl text-[11px] font-black transition-all {{ $page == $collection->currentPage() ? 'bg-tosca-500 text-white shadow-lg shadow-tosca-500/20' : 'bg-white dark:bg-slate-800 text-slate-500 hover:bg-slate-100' }}">
                                {{ $page }}
                            </button>
                        @endforeach

                        <button wire:click="nextPage" @disabled(!$collection->hasMorePages())
                                class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 disabled:opacity-30 transition-all hover:bg-tosca-500 hover:text-white">
                            <iconify-icon icon="lucide:chevron-right"></iconify-icon>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>