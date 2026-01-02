<div>
    <x-ui.modal>

        <div class="space-y-4">
            <div class="group flex items-center gap-4">
                <x-ui.label for="user-name" class="w-1/3" required>
                    {{ __('general.label.name') }}
                </x-ui.label>
                <x-ui.input id="user-name" type="text" wire:model="name" placeholder="Name"/>
            </div>
            <div class="group flex items-center gap-4">
                <x-ui.label for="user-username" class="w-1/3" required>
                    {{ __('user.label.username') }}
                </x-ui.label>
                <x-ui.input id="user-username" type="text" wire:model="username" placeholder="username"/>
            </div>
            <div class="group flex items-center gap-4">
                <x-ui.label for="user-email" class="w-1/3" required>
                    {{ __('user.label.email') }}
                </x-ui.label>
                <x-ui.input id="user-email" type="email" wire:model="email" placeholder="email"/>
            </div>
            <div x-data="{ show: false }" class="group flex items-center gap-4">
                <x-ui.label for="user-password" class="w-1/4">
                    {{ __('user.label.password') }}
                </x-ui.label>
                <div class="relative flex items-center justify-between w-3/4">
                    <x-ui.input 
                        id="user-password"
                        x-bind:type="show ? 'text' : 'password'" 
                        wire:model="password" 
                        placeholder="Isi untuk ubah password"/>
                    <x-ui.show-password />

                </div>
            </div>            
            <div x-data="{ show: false }" class="group group flex items-center gap-4">
                <label for="user-confirm-password" class="w-1/4 form-label-puffy">
                    {{ __('user.label.confirm_password') }}
                </label>
                <div class="relative flex items-center justify-between w-3/4">
                    <x-ui.input 
                        id="user-confirm-password"
                        x-bind:type="show ? 'text' : 'password'" 
                        wire:model="confirmPassword" 
                        placeholder="Isi ulang password"/>
                    <x-ui.show-password />

                </div>
            </div>
            <div class="group group flex items-center gap-4">
                <label for="user-role" class="w-1/4 form-label-puffy">
                    {{ __('user.label.role') }}
                </label>
                <div class="relative flex items-center justify-between w-3/4">
                    <x-ui.select2 
                        name="roleId"
                        id="roleId"
                        class="block w-full"
                        wire:model.live="roleId"
                        :options="collect($roles)->pluck('name', 'id')"
                        placeholder="{{ __('user.placeholder.select_role') }}"
                    />
                </div>
            </div>


        </div>
        @if($isEditing)
            <x-slot:footer_left>
                <x-swal-confirm 
                    title="Hapus Presensi?" 
                    text="Data Presensi Akan Dihapus Permanen..."
                    callback="delete"
                    :id="$userId" 
                />
            </x-slot:footer_left>
        @endif
    </x-ui.modal>
</div>
