<x-layouts.app>
    <x-slot:title>
        @lang('sidebar.label.user')
    </x-slot>
        <div class="px-4 py-2 m-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <h5 class="text-lg font-bold text-slate-800 dark:text-white">
                {{ __('option.label.user') }}
            </h5>
            
            @can('create user')
            <x-modal-trigger
                modal="user-modal"
                title="{{ __('user.label.add_user') }}"
                size="max-w-7xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9s-9-1.8-9-9s1.8-9 9-9m3 9H9m3-3v6"/></svg>
            </x-modal-trigger>
            @endcan
        </div>
    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">

        <x-ui.datatable 
            id="usersTable" 
            :headers="['#','Nama','Username','Email','Role','Edit','Hapus']">

            @foreach($users as $no => $user)
                <tr>
                    <td>{{ $no+1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ $role->name ?? '-' }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        @can('update user')
                        <x-modal-trigger
                            class="inline-flex items-center p-1 bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white rounded-lg transition-all"
                            modal="user-modal"
                            :args="['id' => $user->id]"
                            title="{{ __('user.label.add_user') }}"
                            size="max-w-7xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3"/><path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6"/></g></svg>

                        </x-modal-trigger>
                        @endcan
                    </td>
                    <td>
                        @can('delete user')
                            <button type="button" 
                                onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}', 'user')"
                                class="inline-flex items-center p-1 bg-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-900/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white rounded-lg transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m-5 5l4 4m0-4l-4 4"/></svg>
                            </button>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </x-ui.datatable>
    </div>
</x-layouts.app>
