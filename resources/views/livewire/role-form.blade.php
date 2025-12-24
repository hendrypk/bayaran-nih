<div class="flex flex-col lg:flex-row gap-8 items-start h-[calc(100vh-160px)] overflow-hidden">
    
    <div class="flex-1 w-full h-full flex flex-col min-w-0 space-y-6">
        
    <div class="flex flex-col md:flex-row md:items-center gap-6">
        <div class="p-4 bg-cyan-500/10 rounded-2xl flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>

        <div class="flex-1 group relative">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1 block">
                {{ __('Nama Peran / Role') }}
            </label>
            
            <div class="relative flex items-center">
                <input type="text" wire:model.defer="name"
                    class="w-full text-2xl font-bold bg-white dark:bg-slate-800/50 rounded-xl px-4 py-2 
                           border border-transparent transition-all duration-300
                           focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/20 focus:outline-none
                           text-slate-800 dark:text-white placeholder-slate-300"
                    placeholder="Contoh: Superadmin">
                
                <div class="absolute right-4 text-slate-300 group-focus-within:text-cyan-500 transition-colors pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/>
                    </svg>
                </div>
            </div>
        </div>

        @if($isEditing)
            <div class="flex-shrink-0">
                <x-swal-confirm 
                    title="Hapus Peran?" 
                    text="Data ini akan hilang permanen. Lanjutkan?"
                    callback="delete"
                    :id="$roleId"
                    class="p-3 bg-rose-50 dark:bg-rose-900/10 text-rose-500 hover:bg-rose-500 hover:text-white rounded-2xl transition-all duration-300 shadow-sm active:scale-90">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </x-swal-confirm>
            </div>
        @endif
    </div>

        <div class="flex-1 min-h-0 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col overflow-hidden">
            
            <div class="flex-shrink-0 p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/30">
                <div>
                    <h3 class="font-bold text-slate-800 dark:text-white">Hak Akses Peran</h3>
                    <p class="text-xs text-slate-500">Tentukan tindakan peran ini.</p>
                </div>
                <div class="flex items-center gap-3 bg-white dark:bg-slate-900 px-4 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                    <input type="checkbox" id="select_all_permissions" onclick="toggleAllPermissions(this)" class="w-4 h-4 rounded text-cyan-500 focus:ring-cyan-400 border-slate-300">
                    <label for="select_all_permissions" class="text-xs font-bold text-slate-600 dark:text-slate-400 cursor-pointer select-none">Pilih Semua</label>
                </div>
            </div>

            <div class="flex-1 min-h-0 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800 custom-scrollbar">
                @foreach($groupedPermissions as $group => $permissions)
                    <div class="p-6 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="md:w-48 flex-shrink-0">
                                <span class="text-sm font-extrabold text-slate-400 uppercase tracking-tighter">{{ $group }}</span>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                @foreach($permissions as $permission)
                                    <label class="group relative flex items-center gap-3 px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:border-cyan-400 dark:hover:border-cyan-500 transition-all cursor-pointer has-[:checked]:bg-cyan-50 has-[:checked]:border-cyan-500 dark:has-[:checked]:bg-cyan-500/10">
                                        <input type="checkbox" wire:model.defer="permissions.{{ $permission->id }}" class="rounded-full permission-checkbox border-slate-300 text-cyan-500 focus:ring-cyan-400 w-4 h-4 transition-transform group-active:scale-90">
                                        <span class="text-xs font-semibold text-slate-600 dark:text-slate-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                            {{ ucfirst(explode(' ', $permission->name)[0]) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex-shrink-0 p-6 bg-slate-50 dark:bg-slate-800/50 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100 dark:border-slate-800">
                <p class="text-xs text-slate-400 italic">Klik simpan setelah mengubah hak akses.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('role.index') }}" 
                        class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                            {{ __('general.label.back') }}
                    </a>
                    
                    <button type="submit" wire:click="save" wire:loading.attr="disabled"
                        class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg font-bold text-sm shadow-lg shadow-cyan-500/30 transition-all flex items-center">
                        <span wire:loading.remove wire:target="save">
                            {{ __('general.label.save') }}
                        </span>
                        <span wire:loading wire:target="save" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @if($isEditing)
        <aside class="w-full lg:w-80 space-y-6 lg:sticky lg:top-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-cyan-500 rounded-3xl p-5 text-white shadow-lg shadow-cyan-500/30">
                    <div class="text-2xl font-black">{{ count($assignedUsers) }}</div>
                    <div class="text-[10px] font-bold uppercase tracking-widest opacity-80">Total User</div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700">
                    <div class="text-2xl font-black text-slate-800 dark:text-white">{{ collect($permissions)->filter()->count() }}</div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Hak Akses</div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
                <h6 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center justify-between">
                    <span>User Terkait</span>
                    <span class="bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-md text-[10px]">{{ count($assignedUsers) }}</span>
                </h6>

                @if(count($assignedUsers) > 0)
                    <div class="space-y-4 max-h-[50vh] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($assignedUsers as $user)
                            <x-modal-trigger modal="user-modal" :args="['id' => $user->id]" title="Detail User" size="max-w-7xl" class="w-full group">
                                <div class="flex items-center gap-4 p-3 rounded-2xl transition-all duration-300 border border-transparent group-hover:bg-slate-50 dark:group-hover:bg-slate-700/50 group-hover:border-slate-100 dark:group-hover:border-slate-600">
                                    <div class="relative">
                                        <div class="w-11 h-11 rounded-2xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-sm font-bold text-slate-600 dark:text-slate-300 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-300">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
                                    </div>
                                    
                                    <div class="flex flex-col min-w-0 text-left">
                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200 truncate">{{ $user->name }}</span>
                                        <span class="text-[10px] text-slate-400 truncate">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </x-modal-trigger>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center space-y-3">
                        <div class="w-16 h-16 bg-slate-50 dark:bg-slate-700/30 rounded-full flex items-center justify-center mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        </div>
                        <p class="text-xs text-slate-400 font-medium italic">Tidak ada user aktif.</p>
                    </div>
                @endif
                
                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700">
                    <button class="w-full py-3 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl text-xs font-bold text-slate-400 hover:border-cyan-400 hover:text-cyan-500 transition-all">
                        + Assign User Baru
                    </button>
                </div>
            </div>
        </aside>
    @endif
</div>
@push('scripts')
    <script>
    function toggleAllPermissions(source) {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = source.checked;
            checkbox.dispatchEvent(new Event('input'));
        });
    }
</script>
@endpush

{{-- <div class="space-y-6">
    <div class="flex items-center justify-between w-full gap-4">
        <div class="flex-1">
            <input type="text" wire:model.defer="name"
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 px-3 py-2 focus:ring-2 focus:ring-cyan-400 focus:outline-none"
                required>
        </div>

        @if($isEditing)
            <div class="flex-shrink-0">
                <x-swal-confirm 
                    title="Hapus Peran?" 
                    text="Apakah Anda yakin ingin menghapus peran {{ $name }}?"
                    callback="delete"
                    :id="$roleId"
                    class="inline-flex items-center p-2 bg-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white 
                    dark:bg-rose-900/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white rounded-lg transition-all shadow-sm active:scale-95">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" 
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M4 7h16M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m-5 5l4 4m0-4l-4 4"/>
                    </svg>
                </x-swal-confirm>
            </div>
        @endif
    </div>

    <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">
        {{ __('option.label.role_permissions') }}
    </label>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <tbody>
                <tr class="border-b border-slate-200 dark:border-slate-700">
                    <td class="py-2 font-semibold text-slate-700 dark:text-slate-200">Root Access</td>
                    <td class="py-2">
                        <input type="checkbox" id="select_all_permissions"
                                onclick="toggleAllPermissions(this)"
                                class="rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                        <label for="select_all_permissions" class="ml-2 text-slate-600 dark:text-slate-300">
                            {{ __('general.label.select_all') }}
                        </label>
                    </td>
                </tr>
                @foreach($groupedPermissions as $group => $permissions)
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <td class="py-2 font-semibold text-slate-500 dark:text-slate-400">
                            {{ ucfirst($group) }}
                        </td>
                        <td class="py-2">
                            <div class="grid grid-cols-5 gap-2">
                                @foreach($permissions as $permission)
                                    <label class="flex items-center space-x-2 text-slate-700 dark:text-slate-300">
                                    <input type="checkbox" 
                                            wire:model.defer="permissions.{{ $permission->id }}" 
                                            class="rounded permission-checkbox border-slate-300 text-cyan-500 focus:ring-cyan-400">
                                    <span>{{ ucfirst(explode(' ', $permission->name)[0]) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-8 flex items-center justify-end space-x-3 border-t border-slate-200 dark:border-slate-700 pt-6">
            <a href="{{ route('role.index') }}" 
            class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                {{ __('general.label.back') }}
            </a>
            
            <button type="submit" wire:click="save" wire:loading.attr="disabled"
                class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg font-bold text-sm shadow-lg shadow-cyan-500/30 transition-all flex items-center">
                <span wire:loading.remove wire:target="save">
                    {{ __('general.label.save') }}
                </span>
                <span wire:loading wire:target="save" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    function toggleAllPermissions(source) {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = source.checked;
            checkbox.dispatchEvent(new Event('input'));
        });
    }
</script>
@endpush --}}