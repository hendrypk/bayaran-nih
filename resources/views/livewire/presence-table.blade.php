<div class="bg-white dark:bg-slate-900 shadow-sm rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    <x-ui.datatable 
        id="presenceTable" 
        :headers="['Tanggal', 'Karyawan', 'Status', 'In/Out', 'Late/Early']">
        
        @foreach($presences as $data)
            @php 
                $isAbsence = is_array($data); 
                $emp = $isAbsence ? $data['employee'] : $data->employee;
                $date = $isAbsence ? $data['date'] : $data->date;
                $status = $isAbsence ? 'absence' : $data->status;

                $statusMap = [
                    'presence' => 'bg-emerald-100 text-emerald-700',
                    'absence'  => 'bg-rose-100 text-rose-700',
                    'leave'    => 'bg-blue-100 text-blue-700',
                    'sick'     => 'bg-amber-100 text-amber-700',
                    'permit'   => 'bg-indigo-100 text-indigo-700',
                    'halfday'  => 'bg-purple-100 text-purple-700',
                ];
            @endphp

            <tr @click="toggleDetail({{ json_encode($data) }})"
                :class="selectedPresence && selectedPresence.id === '{{ $data['id'] ?? $data->id }}' ? 'bg-tosca-50 dark:bg-tosca-900/20 ring-1 ring-inset ring-tosca-500' : ''"
                class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-all cursor-pointer border-b border-slate-100 dark:border-slate-800 last:border-0">
                
                {{-- Column: Tanggal --}}
                <td class="py-3 px-4">
                    <div class="text-sm font-bold text-slate-700 dark:text-slate-200">
                        {{ formatDate($date) }} {{-- Menggunakan helper helpers.php --}}
                    </div>
                    <div class="text-[10px] text-slate-400 font-medium uppercase tracking-tighter">
                        {{ \Carbon\Carbon::parse($date)->isoFormat('dddd') }}
                    </div>
                </td>

                {{-- Column: Karyawan --}}
                <td class="py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 font-bold border border-slate-200 dark:border-slate-700 text-xs">
                            {{ substr($emp->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-bold text-slate-700 dark:text-slate-200 group-hover:text-tosca-600 truncate transition-colors">{{ $emp->name }}</div>
                            <div class="text-[10px] text-slate-400 font-medium tracking-tight">EID: {{ $emp->eid }}</div>
                        </div>
                    </div>
                </td>

                {{-- Column: Status --}}
                <td>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $statusMap[$status] ?? 'bg-slate-100 text-slate-600' }}">
                        {{ $status }}
                    </span>
                </td>

                {{-- Column: In/Out --}}
                <td class="text-center">
                    <div class="text-xs font-bold text-slate-700 dark:text-slate-200">{{ $data->check_in ?? '--:--' }}</div>
                    <div class="text-[10px] font-bold text-slate-400">{{ $data->check_out ?? '--:--' }}</div>
                </td>

                {{-- Column: Late/Early --}}
                <td>
                    @if(!$isAbsence)
                        <div class="flex flex-col leading-tight">
                            @if(($data->late_check_in ?? 0) > 0)
                                <span class="text-[10px] font-bold text-rose-500">L: {{ $data->late_check_in }}m</span>
                            @endif
                            @if(($data->check_out_early ?? 0) > 0)
                                <span class="text-[10px] font-bold text-amber-500">E: {{ $data->check_out_early }}m</span>
                            @endif
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
    </x-ui.datatable>
</div>