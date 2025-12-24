<x-ui.modal>
    <div class="space-y-6">
        <!-- Role Name Input -->
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">
                {{ __('option.label.role_name') }}
            </label>
            <input type="text" wire:model.defer="name"
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 px-3 py-2 focus:ring-2 focus:ring-cyan-400 focus:outline-none"
                required>
        </div>

        <!-- Permissions -->
        <div>
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
                                    class="rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                                <label for="select_all_permissions" class="ml-2 text-slate-600 dark:text-slate-300 cursor-pointer">
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
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                        @foreach($permissions as $permission)
                                            <label class="flex items-center space-x-2 text-slate-700 dark:text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.defer="permissions"
                                                    value="{{ $permission->id }}" name="permissions"
                                                    class="rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                                                <span>{{ ucfirst(explode(' ', $permission->name)[0]) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</x-ui.modal>
