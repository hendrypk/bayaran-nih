<div>
    <x-ui.modal>
        <div class="space-y-4 bg-blue-50 dark:bg-slate-800 text-slate-800 dark:text-gray-100 p-4 rounded-lg">

        <div class="space-y-4">
            <!-- Name -->
            <div class="flex items-center gap-4">
                <label for="user-name" class="w-1/3 text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('general.label.name') }}
                </label>
                <x-ui.input id="user-name" type="text" wire:model="name" placeholder="Name"/>
            </div>
            <!-- username -->
            <div class="flex items-center gap-4">
                <label for="user-username" class="w-1/3 text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('user.label.username') }}
                </label>
                <x-ui.input id="user-username" type="text" wire:model="username" placeholder="username"/>
            </div>
            <!-- email -->
            <div class="flex items-center gap-4">
                <label for="user-email" class="w-1/3 text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('user.label.email') }}
                </label>
                <x-ui.input id="user-email" type="email" wire:model="email" placeholder="email"/>
            </div>
            <!-- password -->
            <div x-data="{ show: false }" class="flex items-center gap-4">
                <label for="user-password" class="w-1/4 text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('user.label.password') }}
                </label>
                <div class="relative flex items-center justify-between w-3/4">
                    <input 
                        id="user-password"
                        x-bind:type="show ? 'text' : 'password'" 
                        wire:model="password" 
                        placeholder="Isi untuk ubah password"
                        class="w-4/5 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 
                            dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100" 
                    />
                    <x-ui.show-password />

                </div>
            </div>            
            <!-- confirm-password -->
            <div x-data="{ show: false }" class="flex items-center gap-4">
                <label for="user-confirm-password" class="w-1/4 text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('user.label.confirm_password') }}
                </label>
                <div class="relative flex items-center justify-between w-3/4">
                    <input 
                        id="user-confirm-password"
                        x-bind:type="show ? 'text' : 'password'" 
                        wire:model="confirmPassword" 
                        placeholder="Isi ulang password"
                        class="w-4/5 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 
                            dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100" 
                    />
                    <x-ui.show-password />

                </div>
            </div>
            <!-- role -->
            <div class="flex items-center gap-4">
                <label for="user-role" class="w-1/3 text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('user.label.role') }}
                </label>
                <select id="roleId"
                        wire:model="roleId"
                        class=" block w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 
                            dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100">
                    <option value="">{{ __('user.placeholder.select_role') }}</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>

            </div>

            <hr class="my-4 border-slate-200 dark:border-slate-700">

                <div class="mt-3 flex justify-between items-center">
                    @if($isEditing)
                        <x-swal-confirm 
                            title="Hapus User?" 
                            text="Apakah Anda yakin ingin menghapus User {{ $name }}?"
                            callback="delete"
                            :id="$userId"
                            class="inline-flex items-center p-2 bg-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white 
                                   dark:bg-rose-900/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white rounded-lg transition-all">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                            viewBox="0 0 24 24"><path fill="none" stroke="currentColor" 
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 7h16M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m-5 5l4 4m0-4l-4 4"/></svg>
                        </x-swal-confirm>
                    @else
                        <div></div>
                    @endif

                    <div class="flex gap-2">
                        <x-action-button type="cancel" @click="onClose()">
                            @lang('general.label.cancel')
                        </x-action-button>

                        <x-action-button type="save" wire:click="save">
                            @lang('general.label.save')
                        </x-action-button>
                    </div>
                </div>

        </div>
    </x-ui.modal>
</div>
