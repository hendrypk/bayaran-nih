

    {{-- Tabel Utama --}}
        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <x-ui.datatable 
                id="presenceTable" 
                :headers="['Tanggal', 'Karyawan', 'Status', 'In/Out', 'Late/Early']">
                @foreach($presences as $data)
                    @php 
                        $isAbsence = is_array($data); 
                        $emp = $isAbsence ? $data['employee'] : $data->employee;
                        $date = $isAbsence ? $data['date'] : $data->date;
                    @endphp
                    <tr @click="toggleDetail({{ json_encode($data) }})"
                        :class="selectedPresence && selectedPresence.id === {{ $isAbsence ? 'null' : $data->id }} ? 'bg-tosca-50 dark:bg-tosca-900/20 ring-1 ring-inset ring-tosca-500' : ''"
                        class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-all cursor-pointer">
                        
                        <td class="py-4 px-4">
                            <div class="text-sm font-bold text-slate-700 dark:text-slate-200">
                                {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-medium uppercase">{{ \Carbon\Carbon::parse($date)->format('l') }}</div>
                        </td>

                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 font-bold border border-slate-200 dark:border-slate-700">
                                    {{ substr($emp->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-700 dark:text-slate-200 group-hover:text-tosca-600 transition-colors">{{ $emp->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium tracking-tight">EID: {{ $emp->eid }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            @php
                                $statusStyles = [
                                    'presence' => 'bg-emerald-100 text-emerald-700',
                                    'absence'  => 'bg-rose-100 text-rose-700',
                                    'leave'    => 'bg-blue-100 text-blue-700',
                                    'sick'     => 'bg-amber-100 text-amber-700',
                                    'permit'   => 'bg-indigo-100 text-indigo-700',
                                    'halfday'  => 'bg-purple-100 text-purple-700',
                                ];
                                $curStatus = $isAbsence ? 'absence' : $data->status;
                                $style = $statusStyles[$curStatus] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $style }}">
                                {{ $curStatus }}
                            </span>
                        </td>

                        <td class="text-center">
                            @if(!$isAbsence)
                                <div class="text-xs font-bold text-slate-700">{{ $data->check_in ?? '--:--' }}</div>
                                <div class="text-xs font-bold text-slate-400">{{ $data->check_out ?? '--:--' }}</div>
                            @else
                                <span class="text-slate-300">--</span>
                            @endif
                        </td>

                        <td>
                            @if(!$isAbsence)
                                <div class="flex flex-col gap-1">
                                    @if($data->late_check_in > 0)
                                        <span class="text-[10px] font-bold text-rose-500">L: {{ $data->late_check_in }}m</span>
                                    @endif
                                    @if($data->check_out_early > 0)
                                        <span class="text-[10px] font-bold text-amber-500">E: {{ $data->check_out_early }}m</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-ui.datatable>
        </div>

    {{-- Side Panel Detail (Gunakan komponen baru) --}}