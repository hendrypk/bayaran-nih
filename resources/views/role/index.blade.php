<x-layouts.app>
    <x-slot:title>
        @lang('sidebar.label.role')
    </x-slot>
        <div class="px-4 py-2 m-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <h5 class="text-lg font-bold text-slate-800 dark:text-white">
                {{ __('option.label.role') }}
            </h5>
            
            @can('create role')
                <a href="{{ route('role.form') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-cyan-500 text-white hover:bg-cyan-600 transition font-semibold shadow-sm active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" class="w-5 h-5">
                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9s-9-1.8-9-9s1.8-9 9-9m3 9H9m3-3v6"/>
                    </svg>
                    {{ __('role.label.add_role') }}
                </a>
            @endcan
        </div>
    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">

        <x-ui.datatable 
            id="rolesTable" 
            :headers="['#','Nama','Edit', 'Total User']">

            @foreach($roles as $no => $role)
                <tr>
                    <td>{{ $no+1 }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @can('update role')
                            <a href="{{ route('role.detail', $role->id) }}" 
                                class="inline-flex items-center p-1 bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white rounded-lg transition-all"
                                title="Edit Role">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3"/><path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6"/></g></svg>
                        </a>
                        @endcan
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-400">
                            {{ $role->users_count }} User
                        </span>
                    </td>
                </tr>
            @endforeach
        </x-ui.datatable>
    </div>
    
    <script>
        @if(session('swal'))
            document.addEventListener('DOMContentLoaded', () => {
                showSwal(@json(session('swal')));
            });
        @endif

        window.addEventListener('confirm-action', event => {
            if (event.detail.method === 'delete') {
                // Contoh: Redirect ke route delete atau submit form manual
                console.log('Menghapus ID:', event.detail.id);
                // window.location.href = '/role/delete/' + event.detail.id;
            }
        });
    </script>
</x-layouts.app>
