@php
    $menus = [
        [
            'id' => 'employee',
            'label' => __('sidebar.label.employee'),
            'icon' => 'M22 3H2c-1.09.04-1.96.91-2 2v14c.04 1.09.91 1.96 2 2h20c1.09-.04 1.96-.91 2-2V5a2.074 2.074 0 0 0-2-2m0 16H2V5h20zm-8-2v-1.25c0-1.66-3.34-2.5-5-2.5s-5 .84-5 2.5V17zM9 7a2.5 2.5 0 0 0-2.5 2.5A2.5 2.5 0 0 0 9 12a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 9 7m5 0v1h6V7zm0 2v1h6V9zm0 2v1h4v-1z',
            'sub' => [
                ['route' => 'employee.add', 'label' => __('sidebar.label.add_employee')],
                ['route' => 'employee.list', 'label' => __('sidebar.label.employee_list')],
                ['route' => 'resignation.index', 'label' => __('sidebar.label.resignation')],
                ['route' => 'position.change.index', 'label' => __('sidebar.label.position_change')],
            ]
        ],
        [
            'id' => 'attendance',
            'label' => __('sidebar.label.attendance'),
            'icon' => 'M10.54 14.53L8.41 12.4l-1.06 1.06l3.18 3.18l6-6l-1.06-1.06zM12 20a7 7 0 0 1-7-7a7 7 0 0 1 7-7a7 7 0 0 1 7 7a7 7 0 0 1-7 7m0-16a9 9 0 0 0-9 9a9 9 0 0 0 9 9a9 9 0 0 0 9-9a9 9 0 0 0-9-9m-4.12-.61L6.6 1.86L2 5.71l1.29 1.53zM22 5.72l-4.6-3.86l-1.29 1.53l4.6 3.86z',
            'sub' => [
                ['route' => 'presenceSummary.list', 'label' =>__('sidebar.label.presence_summary')],
                ['route' => 'presence.list.admin', 'label' =>__('sidebar.label.presences')],
                ['route' => 'overtime.list', 'label' =>__('sidebar.label.overtime')],
                ['route' => 'leaves.index', 'label' =>__('sidebar.label.leave')],
            ]
        ],
        [
            'id' => 'performance',
            'label' => __('sidebar.label.performance'),
            'icon' => 'M21 8c-1.5 0-2.3 1.4-1.9 2.5l-3.6 3.6c-.3-.1-.7-.1-1 0l-2.6-2.6c.4-1.1-.4-2.5-1.9-2.5c-1.4 0-2.3 1.4-1.9 2.5L3.5 16c-1.1-.3-2.5.5-2.5 2c0 1.1.9 2 2 2c1.4 0 2.3-1.4 1.9-2.5l4.5-4.6c.3.1.7.1 1 0l2.6 2.6c-.3 1 .5 2.5 2 2.5s2.3-1.4 1.9-2.5l3.6-3.6c1.1.3 2.5-.5 2.5-1.9c0-1.1-.9-2-2-2m-6 1l.9-2.1L18 6l-2.1-.9L15 3l-.9 2.1L12 6l2.1.9zM3.5 11L4 9l2-.5L4 8l-.5-2L3 8l-2 .5L3 9z',
            'sub' => [
                ['route' => 'performance.grade', 'label' =>__('sidebar.label.employee_grade')],
                ['route' => 'kpi.list', 'label' =>__('sidebar.label.kpi')],
                ['route' => 'pa.list', 'label' =>__('sidebar.label.performance_appraisal')],
                ['route' => 'kpi.pa.options.index', 'label' =>__('sidebar.label.setting_kpi_pa')],
            ]
        ],
        [
            'id' => 'lapor_hr',
            'label' => __('option.label.lapor_hr'),
            'icon' => 'M13 13h-2V7h2m-2 8h2v2h-2m4.73-14H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27z',
            'route' => 'lapor_hr.index'
        ],
        [
            'id' => 'setting',
            'label' => __('sidebar.label.setting'),
            'icon' => 'M11.7 20h-.4l-.4-2.6c-1.2-.2-2.2-.9-3-1.8l-2.4 1l-.8-1.3l2.1-1.6q-.6-1.8 0-3.6L4.7 8.7l.8-1.3l2.4 1q1.2-1.35 3-1.8l.3-2.6h1.5l.4 2.6c1.2.2 2.3.9 3 1.8l2.4-1l.8 1.3l-2.1 1.5q.3.9.3 1.8h.5c.5 0 1 .1 1.5.2V12l-.1-1l2.1-1.6c.2-.2.2-.4.1-.6l-2-3.5c-.1-.3-.3-.3-.6-.3l-2.5 1c-.5-.4-1.1-.7-1.7-1l-.4-2.7c.1-.1-.2-.3-.4-.3h-4c-.2 0-.5.2-.5.4l-.4 2.7c-.6.2-1.1.6-1.7.9L5 5c-.3 0-.5 0-.7.3l-2 3.5c-.1.2 0 .4.2.6L4.6 11l-.1 1l.1 1l-2.1 1.7c-.2.2-.2.4-.1.6l2 3.5c.1.2.3.2.6.2l2.5-1c.5.4 1.1.7 1.7 1l.4 2.7c0 .2.2.4.5.4h2.5c-.5-.7-.7-1.4-.9-2.1m4.3-7.7V12c0-2.2-1.8-4-4-4s-4 1.8-4 4s1.8 4 4 4c.7-1.7 2.2-3.1 4-3.7m-6-.3c0-1.1.9-2 2-2s2 .9 2 2s-.9 2-2 2s-2-.9-2-2m8 2.5V13l-2.2 2.2l2.2 2.2V16c1.4 0 2.5 1.1 2.5 2.5c0 .4-.1.8-.3 1.1l1.1 1.1c1.2-1.8.7-4.3-1.1-5.5c-.6-.5-1.4-.7-2.2-.7m0 6.5c-1.4 0-2.5-1.1-2.5-2.5c0-.4.1-.8.3-1.1l-1.1-1.1c-1.2 1.8-.7 4.3 1.1 5.5c.7.4 1.4.7 2.2.7V24l2.2-2.2l-2.2-2.3z',
            'sub' => [
                ['route' => 'options.list', 'label' =>__('sidebar.label.options')],
                ['route' => 'workDay.index', 'label' =>__('sidebar.label.work_day')],
                ['route' => 'role.index', 'label' =>__('sidebar.label.role')],
                ['route' => 'user.index', 'label' =>__('sidebar.label.user')],
            ]
        ],
        [
            'id' => 'log',
            'label' => 'Log',
            'icon' => 'M18 7c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2v-4h-2v4h-2V9h4V7zM2 7v10h6v-2H4V7zm9 0c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm0 2h2v6h-2z',
            'route' => 'log'
        ],
        // [
        //     'id' => 'logout',
        //     'label' => __('sidebar.label.log_out'),
        //     'icon' => 'm17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5M4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4z',
        //     'route' => 'auth.logout'
        // ],
    ];
@endphp

<aside id="sidebar" class="bg-white dark:bg-slate-900 text-slate-800 dark:text-gray-100 min-h-screen fixed top-0 left-0 shadow-lg z-30 transition-all duration-300 w-64 md:w-30">
    <div class="p-4 flex items-center justify-between"> 
        <x-application-logo />
        <x-toggle-sidebar id="sidebarToggle" />
    </div>
    <nav class="mt-2" aria-label="Main" x-data="{ open: {} }" @close-all-sub.window="open = {}">
        <ul class="space-y-2 px-3">
            <li class="{{ Request::routeIs('home*') ? 'rounded text-slate-700 bg-cyan-400 dark:text-slate-700 dark:bg-cyan-400 font-bold' : '' }}">
                <a href="{{ route('home') }}" class="flex sidebar-icon items-center p-2 rounded text-slate-700 dark:text-white  hover:bg-cyan-100 dark:hover:bg-gray-800 transition ">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="currentColor" d="M12 20c-4.4 0-8-3.6-8-8s3.6-8 8-8s8 3.6 8 8s-3.6 8-8 8m0-18C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2m-1 12h2v3h3v-5h2l-6-5l-6 5h2v5h3z"/></svg>
                    <span class="ml-2 sidebar-label">@lang('sidebar.label.dashboard')</span>
                </a>
            </li>

            @foreach($menus as $menu)
                {{-- CASE 1: MENU DENGAN SUBMENU --}}
                @if(isset($menu['sub']))
                    <li class="relative" @mouseenter="open['{{ $menu['id'] }}'] = true" @mouseleave="open['{{ $menu['id'] }}'] = false">
                        <button @click="open['{{ $menu['id'] }}'] = !open['{{ $menu['id'] }}']"
                                class="flex sidebar-icon items-center p-2 rounded hover:bg-cyan-100 dark:hover:bg-gray-800 transition w-full">
                            <span class="flex items-center">
                                <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="currentColor" d="{{ $menu['icon'] }}"/></svg>
                                <span class="ml-2 sidebar-label">{{ $menu['label'] }}</span>
                            </span>
                            <svg class="sub-menu-icon ml-auto w-5 h-5 transition-transform" :class="open['{{ $menu['id'] }}'] ? 'rotate-90' : ''" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m10 17l5-5l-5-5z"/>
                            </svg>
                        </button>

                        <ul x-show="open['{{ $menu['id'] }}']" x-cloak class="sidebar-submenu ml-10 space-y-1 mt-1">
                            @foreach($menu['sub'] as $sub)
                            <li>
                                <a href="{{ ($sub['route'] !== '#') ? route($sub['route']) : '#' }}" 
                                class="block p-2 text-sm rounded hover:bg-cyan-100 dark:hover:bg-gray-800 transition 
                                    {{ Request::routeIs($sub['route']) ? 'text-slate-700 bg-cyan-400 dark:text-slate-700 dark:bg-cyan-400 font-bold' : '' }}">
                                    {{ $sub['label'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                {{-- CASE 2: MENU BIASA (TANPA SUBMENU) --}}
                @else
                    <li class="{{ (isset($menu['route']) && Request::routeIs($menu['route'])) ? 'rounded text-slate-700 bg-cyan-400 dark:text-slate-700 dark:bg-cyan-400 font-bold' : '' }}">
                        <a href="{{ (isset($menu['route']) && $menu['route'] !== '#') ? route($menu['route']) : '#' }}" 
                        class="flex sidebar-icon items-center p-2 rounded text-slate-700 dark:text-white  hover:bg-cyan-100 dark:hover:bg-gray-800 transition ">
                            <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="currentColor" d="{{ $menu['icon'] }}"/></svg>
                            <span class="ml-2 sidebar-label">{{ $menu['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>
</aside>