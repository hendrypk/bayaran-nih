<x-layouts.app>
    <x-slot:title>
        @lang('sidebar.label.presences')
    </x-slot>

<div x-data="{ 
      selectedPresence: null,
      showDetail: false,
      toggleDetail(data) {
          this.showDetail = !(this.selectedPresence && this.selectedPresence.id === data.id);
          this.selectedPresence = this.showDetail ? data : null;
      }
  }" class="flex flex-col lg:flex-row gap-6 px-4 pb-10 items-start">

    <div :class="showDetail ? 'lg:w-2/3' : 'w-full'" class="transition-all duration-500 ease-in-out">

    <div class="px-4 py-4 m-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            
            {{-- Bagian Kiri: Judul --}}
            <div class="flex-shrink-0">
                <h5 class="text-lg font-bold text-slate-800 dark:text-white">
                    {{ __('attendance.label.presence_list') }}
                </h5>
                <p class="text-sm text-slate-500">Monitoring kehadiran karyawan secara real-time.</p>
            </div>

            {{-- Bagian Kanan: Filter & Actions --}}
            <div class="flex flex-col md:flex-row flex-wrap items-center gap-4 w-full lg:justify-end">
                
                {{-- Date Range Picker --}}
                <div class="w-full md:w-auto">
                    <livewire:date-range-picker :ranges="[1,2,7,8,3,4,9,10,11]" :defaultRange="7" :updateUrl="true" :dateLimit="360"
                        :maxDate="0" startDate="{{ app('request')->input('startDate') }}"
                        endDate="{{ app('request')->input('endDate') }}"/>
                </div>

                {{-- Status & Search --}}
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <select id="status" class="w-full md:w-40 px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-tosca-500 outline-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="presence" selected>Presence</option>
                        <option value="leave">Leave</option>
                        <option value="sick">Sick</option>
                        <option value="permit">Permit</option>
                        <option value="absence">Absence</option>
                    </select>

                    <div class="relative w-full md:w-48">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </span>
                        <input type="text" id="search" placeholder="Cari..." 
                            class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-tosca-500 outline-none">
                    </div>
                </div>

                {{-- Buttons Action --}}
                <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                    <button id="downloadExcel" title="{{ __('general.label.export') }}" class="inline-flex items-center justify-center p-2 bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 11l5 5l5-5m-5-7v12"/></svg>
                    </button>

                    <a href="{{ route('presence.import') }}" title="{{ __('general.label.import') }}"
                        class="inline-flex items-center justify-center p-2 bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-900/30 dark:text-blue-400 rounded-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2m-4-11l-4-4l-4 4m4-4v12"/></svg>
                    </a>

                    @can('create presence')
                    <x-modal-trigger
                        class="inline-flex items-center justify-center p-2 bg-tosca-100 text-tosca-600 hover:bg-tosca-600 hover:text-white dark:bg-tosca-900/30 dark:text-tosca-400 rounded-lg transition-all"
                        modal="presence-manual-modal"
                        title="{{ __('attendance.label.add_manual_presence') }}"
                        size="max-w-4xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9s-9-1.8-9-9s1.8-9 9-9m3 9H9m3-3v6"/></svg>
                    </x-modal-trigger>
                    @endcan
                </div>
            </div>
            
        </div>
    </div>
    <div class="px-4 pb-4">
        @livewire('presence-table')
</div>
    </div>
    <x-presence.panel-detail />

</div>
    


</x-layouts.app>