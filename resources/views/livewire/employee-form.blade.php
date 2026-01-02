<div class="flex flex-col md:flex-row gap-6"
    x-data="{ 
        tab: 0, 
        version: 0,
        steps: ['personal', 'job', 'kpi', 'payroll'],
        
        isStepComplete(stepIndex) {
            this.version; 
            
            const inputs = Array.from(document.querySelectorAll(`[data-step='${stepIndex}'][required]`));
            if (inputs.length === 0) return false;

            return inputs.every(input => {
                if (input.type === 'radio' || input.type === 'checkbox') {
                    const name = input.getAttribute('name');
                    return document.querySelector(`input[name='${name}']:checked`) !== null;
                }
                return input.value.trim() !== '';
            });
        }
    }"
    @input.window="version++"
    @change.window="version++" 
>
    
    
    <div class="w-full md:w-64 flex-shrink-0 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 flex flex-col h-full space-y-4">
        
        <div class="flex-1 space-y-2">
            <template x-for="(step, index) in steps">
                <button @click="tab = index" 
                    :class="tab === index ? 
                        'dark:text-white text-slate-700 shadow-lg shadow-cyan-500/30' : 
                        'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300'"
                    class="w-full text-left px-4 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center gap-3 group">
                    
                    <span class="flex items-center justify-center w-7 h-7 rounded-full border-2 transition-all duration-300" 
                        :class="tab === index 
                            ? 'border-white bg-cyan-500 shadow-lg shadow-cyan-500/50 scale-110 z-10 text-white' 
                            : (isStepComplete(index) 
                                ? 'border-cyan-500/50 bg-cyan-500/20 text-cyan-600 dark:text-cyan-400' 
                                : 'border-slate-300 dark:border-slate-600 text-slate-500')"
                    >
                        <iconify-icon x-show="isStepComplete(index)" 
                            :class="tab === index ? 'text-lg' : 'text-base'" 
                            icon="mdi:check-all" 
                            width="24" height="24"></iconify-icon>

                        <span x-show="!isStepComplete(index)" 
                                x-text="index + 1" 
                                class="text-xs font-bold"></span>
                    </span>

                    <span x-text="step === 'personal' ? 'Info Pribadi' : (step === 'job' ? 'Kepegawaian' : (step === 'kpi' ? 'Performance' : 'Payroll'))"></span>
                </button>
            </template>
        </div>

        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 space-y-2">
            
            {{-- JIKA DALAM MODE VIEW (READ ONLY) --}}
            @if($isReadOnly)
                <a href="{{ route('employee.edit', $editingId) }}" 
                class="w-full inline-flex items-center justify-center px-3 py-2.5 bg-amber-500 text-white rounded-xl font-bold shadow-lg shadow-amber-500/30 transition active:scale-95 hover:bg-amber-600">
                    <i class="mdi mdi-pencil text-xl mr-2"></i>
                    Edit Data Karyawan
                </a>
            @else
                {{-- JIKA DALAM MODE CREATE ATAU EDIT (FORM AKTIF) --}}
                <div class="flex gap-2">
                    <button type="button" 
                        x-show="tab > 0" 
                        @click="tab--" 
                        class="flex-1 inline-flex items-center justify-center px-3 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl font-bold transition active:scale-95 hover:bg-slate-200">
                        <i class="mdi mdi-chevron-left text-xl mr-1"></i>
                        Back
                    </button>

                    <button type="button" 
                        x-show="tab < steps.length - 1" 
                        @click="tab++" 
                        class="flex-1 inline-flex items-center justify-center px-3 py-2.5 bg-cyan-500 text-white rounded-xl font-bold shadow-lg shadow-cyan-500/30 transition active:scale-95 hover:bg-cyan-600">
                        Next
                        <i class="mdi mdi-chevron-right text-xl ml-1"></i>
                    </button>
                </div>

                <button type="submit" 
                    wire:click='save'
                    x-show="tab === steps.length - 1" 
                    class="w-full inline-flex items-center justify-center px-3 py-2.5 bg-emerald-500 text-white rounded-xl font-bold shadow-lg shadow-emerald-500/30 transition active:scale-95 hover:bg-emerald-600">
                    <i class="mdi mdi-check-all text-xl mr-2"></i>
                    {{ $isEditing ? 'Simpan Perubahan' : 'Save New Employee' }}
                </button>
            @endif
        </div>
    </div>

    <div class="flex-1 w-full flex flex-col gap-6">
            
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm min-h-[650px]">   
            <div x-show="tab === 0">

                <!-- Header -->
                <div class="mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">Informasi Pribadi</h3>
                    <p class="text-sm text-slate-500">Lengkapi biodata dasar karyawan.</p>
                </div>

                <!-- Row 1: Nama & Kelahiran -->
                <div class="grid grid-cols-1 md:grid-cols-2 my-3 gap-6">
                    <div class="group">
                        <x-ui.label for="full_name" required>
                            {{ __('employee.label.full_name') }}
                        </x-ui.label>
                        <input 
                            type="text" 
                            name="name" 
                            wire:model="name"
                            class="form-input-puffy" 
                            placeholder="Masukkan nama lengkap sesuai identitas">
                    </div>
                    <div class="group">
                        <x-ui.label for="ttl" required>
                            Tempat & Tanggal Lahir
                        </x-ui.label>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input 
                                type="text" 
                                name="place_birth" 
                                wire:model="placeBirth"
                                class="form-input-puffy flex-1" 
                                placeholder="Kota">
                            <x-ui.datepicker 
                                name="date_birth" 
                                wire:model="dateBirth" />
                        </div>
                    </div>
                </div>

                <!-- Row 2: Gender, Religion, Blood -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 my-3 gap-6">
                    <div class="group">
                        <x-ui.select2 
                            label="Jenis Kelamin"
                            name="genders"
                            wire:model="genders"
                            :options="$gendersOptions"
                        />
                    </div>
                    <div class="group">
                        <x-ui.select2 
                            label="Agama"
                            name="religions"
                            wire:model="religions"
                            :options="$religionsOptions"
                            placeholder="Pilih Agama"
                        />
                    </div>
                    <div class="group">
                        <x-ui.select2 
                            label="Golongan Darah"
                            name="bloods"
                            wire:model="bloods"
                            :options="$bloodsOptions"
                            placeholder="Pilih Golongan Darah"
                        />
                    </div>
                </div>

                <!-- Row 3: Pendidikan & Status Perkawinan -->
                <div class="grid grid-cols-1 md:grid-cols-2 my-3 gap-6">
                    <div class="group">
                        <x-ui.select2 
                            label="Pendidikan"
                            name="educations"
                            wire:model="educations"
                            :options="$educationsOptions"
                            placeholder="Pilih Pendidikan"
                        />
                    </div>
                    <div class="group">
                        <x-ui.select2 
                            label="Status"
                            name="marriages"
                            wire:model="marriages"
                            :options="$marriagesOptions"
                            placeholder="Pilih Status"
                        />
                    </div>
                </div>

                <!-- Row 4: Kontak -->
                <div class="grid grid-cols-1 md:grid-cols-2 my-3 gap-6">
                    <div class="group">
                        <x-ui.label for="email" required>
                            {{ __('employee.label.email') }}
                        </x-ui.label>
                        <input 
                            type="email" 
                            name="email" 
                            wire:model="email" 
                            class="form-input-puffy" 
                            placeholder="email@perusahaan.com">
                    </div>
                    <div class="group">
                        <x-ui.label for="whatsapp" required>
                            {{ __('employee.label.whatsapp') }}
                        </x-ui.label>
                        <input 
                            type="number" 
                            name="whatsapp" 
                            wire:model="whatsapp" 
                            class="form-input-puffy" 
                            placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <!-- Row 5: Address Management -->
                <div class="grid grid-cols-1 md:grid-cols-2 my-3 gap-6">
                    <div class="group">
                        <x-ui.label for="identity_address" required>
                            {{ __('employee.label.identity_address') }} (KTP)
                        </x-ui.label>
                        <textarea 
                            name="identity_address" 
                            wire:model="city"
                            rows="3" 
                            class="form-input-puffy" 
                            placeholder="Alamat sesuai dokumen negara..."></textarea>
                    </div>
                    <div class="group">
                        <div class="flex items-center justify-between">
                        <x-ui.label for="current_address" required>
                            {{ __('employee.label.current_address') }}
                        </x-ui.label>
                            <button type="button"
                                    @click="$wire.domicile = $wire.city"
                                    class="text-xs font-semibold text-cyan-600 hover:bg-cyan-600 hover:text-white px-3 py-1 rounded-lg border border-cyan-200 dark:border-cyan-800 transition">
                                Sama dengan KTP
                            </button>
                        </div>
                        <textarea 
                            name="current_address" 
                            wire:model="domicile"
                            rows="3" 
                            class="form-input-puffy" 
                            placeholder="Alamat tinggal saat ini..."></textarea>
                    </div>
                </div>
                </div>
            <div x-show="tab === 1">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">Penempatan & Jabatan</h3>
                    <p class="text-sm text-slate-500">Lengkapi detail jabatan, jadwal, dan status kontrak karyawan.</p>
                    </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-ui.select2 
                                label="Jabatan"
                                name="positionId"
                                wire:model="positionId"
                                data-step="1" required
                                :options="$positionsOptions->pluck('name', 'id')"
                                placeholder="Pilih Jabatan"
                            />
                            </div>
                        <div class="group">
                            <x-ui.select2 
                                label="Status Karyawan"
                                name="statuses"
                                wire:model="statuses"
                                data-step="1" required
                                :options="$statusesOptions->pluck('name', 'id')"
                                placeholder="Pilih Status" 
                            />
                            </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-ui.select2 
                                label="Jadwal Kerja"
                                name="work_day"
                                wire:model="workDay"
                                data-step="1" required
                                :options="$workDayOptions->pluck('name', 'id')"
                                placeholder="Pilih Jadwal"
                                multiple 
                            />
                            </div>
                        <div class="group">
                            <x-ui.select2 
                                label="Lokasi Kantor"
                                name="office_locations"
                                wire:model="officeLocations"
                                data-step="1" required
                                :options="$officeLocationsOptions->pluck('name', 'id')"
                                placeholder="Pilih Lokasi"
                                multiple 
                            />
                            </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="group">
                            <x-ui.label for="joining_date" required>Tanggal Bergabung</x-ui.label>
                            <x-ui.datepicker
                                id="joining_date" 
                                name="joining_date"
                                wire:model="joining_date" 
                                data-step="1" 
                                required 
                                />
                            </div>
                        
                        <div class="group">
                            <x-ui.label for="leave">Cuti Tahunan (Hari)</x-ui.label>
                            <input type="number" 
                                name="leave_count"
                                wire:model="leaveStock" 
                                data-step="1" 
                                class="form-input-puffy w-full" 
                                placeholder="Contoh: 12">
                            </div>

                        <div class="group">
                            <x-ui.label for="leave_date">Cuti Berlaku Sampai</x-ui.label>
                            <x-ui.datepicker 
                                id="leave_date" 
                                name="leave_date" 
                                data-step="1" 
                                wire:model="dueLeave" />
                            </div>
                        </div>
                        </div>
                    </div>

            <div x-show="tab === 2">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">Manajemen Kinerja</h3>
                    <p class="text-sm text-slate-500">Tentukan indikator kinerja karyawan.</p>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-ui.select2 
                                label="Penilai Utama (Reviewer)"
                                wire:model="managers"
                                data-step="2" required
                                :options="$managersOptions->pluck('name', 'id')"
                                placeholder="Pilih Atasan Langsung"
                            />
                            <p class="mt-1 text-xs text-slate-400 italic">Atasan yang bertanggung jawab memberikan penilaian rutin.</p>
                        </div>
                        <div class="group">
                            <x-ui.select2 
                                label="Periode Penilaian"
                                name="kpi_period"
                                
                                data-step="2" required
                                :options="['monthly' => 'Bulanan', 'quarterly' => 'Per Kuartal', 'yearly' => 'Tahunan']"
                                placeholder="Pilih Frekuensi Review" 
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-9 group">
                            <x-ui.label for="kpi_category" required>Key Performance Indicators (KPI)</x-ui.label>
                            <x-ui.select2 
                                name="kpi_category"
                                wire:model="kpis"
                                data-step="2" required
                                :options="$kpiCategories->pluck('name', 'id')"
                                placeholder="Pilih KPI"
                                multiple
                            />
                        </div>
                        <div class="md:col-span-3 group">
                            <x-ui.label for="kpi_weight" required>Bobot KPI (%)</x-ui.label>
                            <div class="relative">
                                <input type="text" name="kpi_weight" data-step="2" required
                                    class="form-input-puffy w-full" placeholder="0">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-9 group">
                            <x-ui.label for="appraisal_category" required>Performance Appraisal (PA)</x-ui.label>
                            <x-ui.select2 
                                name="appraisal_category"
                                wire:model="pas"
                                data-step="2" required
                                :options="$appraisalCategories->pluck('name', 'id')"
                                placeholder="Pilih PA"
                                multiple
                            />
                        </div>
                        <div class="md:col-span-3 group">
                            <x-ui.label for="pa_weight" required>Bobot PA (%)</x-ui.label>
                            <div class="relative">
                                <input type="text" name="pa_weight" data-step="2" required
                                    class="form-input-puffy w-full" placeholder="0">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="tab === 3"  class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-4">Payroll & Banking</h3>
                </div>
        </div>


    </div>
</div>