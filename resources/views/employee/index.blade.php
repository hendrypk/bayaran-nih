<x-layouts.app>
    <x-slot:title>{{ __('sidebar.label.employee') }}</x-slot:title>
    <x-page-header>@lang('employee.label.list')</x-page-header>


<div x-data="{ 
      selectedEmployee: null,
      showDetail: false,
      {{-- Fungsi Hitung Masa Kerja --}}
      calculateDuration(dateString) {
          if (!dateString) return '';
          const join = new Date(dateString);
          const now = new Date();
          let years = now.getFullYear() - join.getFullYear();
          let months = now.getMonth() - join.getMonth();
          if (months < 0) { years--; months += 12; }
          return (years > 0 ? years + ' Thn ' : '') + months + ' Bln';
      },
      toggleDetail(data) {
          this.showDetail = !(this.selectedEmployee && this.selectedEmployee.id === data.id);
          this.selectedEmployee = this.showDetail ? data : null;
      }
  }" class="flex flex-col lg:flex-row gap-6 px-4 pb-10 items-start">


  <div :class="showDetail ? 'lg:w-2/3' : 'w-full'" class="transition-all duration-500 ease-in-out">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-4">
        @foreach([
            'all' => ['label' => 'Total Karyawan', 'icon' => 'lucide:users', 'color' => 'blue', 'count' => $counts['all']],
            'active' => ['label' => 'Aktif', 'icon' => 'lucide:user-check', 'color' => 'emerald', 'count' => $counts['active']],
            'inactive' => ['label' => 'Non-Aktif/Resign', 'icon' => 'lucide:user-x', 'color' => 'rose', 'count' => $counts['inactive']]
        ] as $key => $val)
        <a href="{{ route('employee.list', ['status' => $key]) }}" 
           class="bg-white dark:bg-slate-900 p-4 rounded-2xl border {{ ($status ?? 'all') == $key ? 'border-'.$val['color'].'-500 ring-1 ring-'.$val['color'].'-500' : 'border-slate-200 dark:border-slate-800' }} transition-all shadow-sm flex items-center gap-4 group">
            <div class="w-12 h-12 rounded-xl bg-{{ $val['color'] }}-100 dark:bg-{{ $val['color'] }}-900/30 flex items-center justify-center text-{{ $val['color'] }}-600 transition-transform group-hover:scale-110">
                <iconify-icon icon="{{ $val['icon'] }}" width="24"></iconify-icon>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $val['label'] }}</p>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">{{ $val['count'] }}</h3>
            </div>
        </a>
        @endforeach
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-end gap-4 px-4 mb-4">
      <div class="flex items-center gap-2">
          <button onclick="alert('Import Feature (Coming Soon)')" 
              class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 active:scale-95 transition-all dark:bg-slate-900 dark:border-slate-800 dark:text-slate-400 dark:hover:bg-slate-800">
              <iconify-icon icon="lucide:upload" width="18"></iconify-icon>
              <span>Import</span>
          </button>

          <button onclick="alert('Export Feature (Coming Soon)')" 
              class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-amber-600 bg-amber-50 border border-amber-100 rounded-xl hover:bg-amber-600 hover:text-white active:scale-95 transition-all dark:bg-amber-900/20 dark:border-amber-900/30 dark:text-amber-400">
              <iconify-icon icon="lucide:download" width="18"></iconify-icon>
              <span>Export</span>
          </button>

          <a href="{{ route('employee.add') }}" 
              class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-md bg-cyan-500 text-white hover:bg-cyan-600 shadow-sm shadow-cyan-500/30 transition-all dark:shadow-none">
              <iconify-icon icon="lucide:plus" width="18"></iconify-icon>
              <span>Tambah Karyawan</span>
          </a>
      </div>
  </div>
    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden">
      <x-ui.datatable 
          id="employeeTable" 
          :headers="['#', 'Karyawan', 'Posisi', 'Status']"
          :collection="$employee">
          @foreach($employee as $no => $data)
              <tr 
                  @click="toggleDetail({{ json_encode($data) }})"
                  :class="selectedEmployee && selectedEmployee.id === {{ $data->id }} ? 'bg-cyan-50 dark:bg-cyan-900/20 ring-1 ring-inset ring-cyan-500' : ''"
                  class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-all cursor-pointer">
                  
                  <td class="text-center text-xs text-slate-400">{{ $no + 1 }}</td>
                  <td class="py-4">
                      <div class="flex items-center gap-3">
                          <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 font-bold border border-slate-200 dark:border-slate-700">
                              {{ substr($data->name, 0, 2) }}
                          </div>
                          <div>
                              <div class="text-sm font-bold text-slate-700 dark:text-slate-200 group-hover:text-cyan-600">{{ $data->name }}</div>
                              <div class="text-[10px] text-slate-400 font-medium">EID: {{ $data->eid }}</div>
                          </div>
                      </div>
                  </td>
                  <td>
                      <div class="text-[12px] font-bold text-slate-600 dark:text-slate-300">{{ $data->position->name ?? '-' }}</div>
                      <div class="text-[9px] text-slate-400 uppercase tracking-tighter">{{ $data->position->division->name ?? 'N/A' }}</div>
                      <div class="text-[9px] text-slate-400 uppercase tracking-tighter">{{ $data->position->department->name ?? 'N/A' }}</div>
                  </td>
                  <td>
                      <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $data->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                          {{ $data->is_active ? 'Aktif' : 'Off' }}
                      </span>
                  </td>
              </tr>
          @endforeach
      </x-ui.datatable>
    </div>
  </div>
  <x-employee.panel-detail />
</div>
</x-layouts.app>