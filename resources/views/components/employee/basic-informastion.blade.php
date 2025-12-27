            <!-- Row 1: Nama & Kelahiran -->
            <div class="grid grid-cols-1 md:grid-cols-2 my-3 gap-6">
                <div class="group">
                    <x-ui.label for="full_name" required>
                        {{ __('employee.label.full_name') }}
                    </x-ui.label>
                    <input type="text" name="name" class="form-input-puffy" placeholder="Masukkan nama lengkap sesuai identitas">
                </div>
                <div class="group">
                    <x-ui.label for="ttl" required>
                        Tempat & Tanggal Lahir
                    </x-ui.label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="place_birth" class="form-input-puffy flex-1" placeholder="Kota">
                        {{-- <input type="date" name="date_birth" class="form-input-puffy flex-1"> --}}
                        <x-ui.datepicker name="date_birth" wire:model="date_birth" />
                    </div>
                </div>
            </div>

            <!-- Row 2: Gender, Religion, Blood -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 my-3 gap-6">
                <div class="group">
                    <x-ui.label for="gender" required>
                        {{ __('employee.label.gender') }}
                    </x-ui.label>
                    <select name="gender" class="form-input-puffy">
                        <option selected disabled>Pilih Gender</option>
                        @foreach (__('employee.options.gender') as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="group">
                    <x-ui.label for="religion" required>
                        {{ __('employee.label.religion') }}
                    </x-ui.label>
                    <select name="religion" class="form-input-puffy">
                        @foreach (__('employee.options.religion') as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="group">
                    <x-ui.label for="blood_type" required>
                        {{ __('employee.label.blood_type') }}
                    </x-ui.label>
                    <select name="blood_type" class="form-input-puffy">
                        @foreach($bloods as $blood)
                            <option value="{{ $blood }}">{{ $blood }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 3: Pendidikan & Status Perkawinan -->
            <div class="grid grid-cols-1 md:grid-cols-2 my-3 gap-6">
                <div class="group">
                    <x-ui.label for="last_education" required>
                        {{ __('employee.label.last_education') }}
                    </x-ui.label>
                    <select name="education" class="form-input-puffy">
                        <option selected disabled>Pilih Pendidikan</option>
                        @foreach (__('employee.options.education') as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="group">
                    <x-ui.label for="marital_status" required>
                        {{ __('employee.label.marital_status') }}
                    </x-ui.label>
                    <select name="marital_status" class="form-input-puffy">
                        <option selected disabled>Pilih Status</option>
                        @foreach (__('employee.options.marital_status') as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 4: Kontak -->
            <div class="grid grid-cols-1 md:grid-cols-2 my-3 gap-6">
                <div class="group">
                    <x-ui.label for="email" required>
                        {{ __('employee.label.email') }}
                    </x-ui.label>
                    <input type="email" name="email" class="form-input-puffy" placeholder="email@perusahaan.com">
                </div>
                <div class="group">
                    <x-ui.label for="whatsapp" required>
                        {{ __('employee.label.whatsapp') }}
                    </x-ui.label>
                    <input type="number" name="whatsapp" class="form-input-puffy" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <!-- Row 5: Address Management -->
            <div class="grid grid-cols-1 md:grid-cols-2 my-3 gap-6">
                <div class="group">
                    <x-ui.label for="identity_address" required>
                        {{ __('employee.label.identity_address') }} (KTP)
                    </x-ui.label>
                    <textarea name="identity_address" rows="3" class="form-input-puffy" placeholder="Alamat sesuai dokumen negara..."></textarea>
                </div>
                <div class="group">
                    <div class="flex items-center justify-between">
                    <x-ui.label for="current_address" required>
                        {{ __('employee.label.current_address') }}
                    </x-ui.label>
                        <button type="button"
                                @click="current_address = identity_address"
                                class="text-xs font-semibold text-cyan-600 hover:bg-cyan-600 hover:text-white px-3 py-1 rounded-lg border border-cyan-200 dark:border-cyan-800 transition">
                            Sama dengan KTP
                        </button>
                    </div>
                    <textarea name="current_address" rows="3" class="form-input-puffy" placeholder="Alamat tinggal saat ini..."></textarea>
                </div>
            </div>