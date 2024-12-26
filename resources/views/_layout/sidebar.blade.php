@php
  $activeEmployee = [
        'employee.add',
        'employee.list',
        'resignation.index',
    ];

    $activePerformance = [
        'performance.grade',
        'kpi.list',
        'pa.list',
        'kpi.pa.index',
    ];

    $activeDataMaster = [
      'options.list',
      'workDay.index',
      'role.index',
      'user.index'
    ];

    $activeAttendance = [
      'presence.list.admin',
      'presenceSummary.list',
      'overtime.list',
      'leaves.index'
    ];

    $activePayroll = [
      'payroll.option',
      ];
@endphp

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('home')}}">
          <i class="ri-account-pin-circle-fill"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <a class="nav-link collapsed" data-bs-target="#payroll-nav" data-bs-toggle="collapse" href="#">
          <i class="ri-money-dollar-box-fill"></i>
          <span>Payroll</span>
          <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="payroll-nav" class="nav-content collapse {{ request()->routeIs($activePayroll) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li class="nav-item">
              <a class="nav-link collapsed {{ request()->routeIs('error') ? 'active' : '' }}" href="{{ route('error') }}">
                  <span>Pay Slip</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link collapsed {{ request()->routeIs('payroll.option') ? 'active' : '' }}" href="{{ route('payroll.option') }}">
                  <span>Pay Item</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link collapsed {{ request()->routeIs('error') ? 'active' : '' }}" href="{{ route('error') }}">
                  <span>Pay Report</span>
              </a>
          </li>
      </ul>

      @can('view employee')
      <a class="nav-link collapsed" data-bs-target="#employee-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-account-pin-circle-fill"></i>
        <span>Employee</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="employee-nav" class="nav-content collapse {{ request()->routeIs($activeEmployee) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        @can('create employee')
        <li class="nav-item {{ request()->routeIs('employee.add') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('employee.add')}}">
            {{-- <i class="ri-calendar-check-fill"></i> --}}
            <span>Add Employee</span>
          </a>
        </li>
        @endcan
        @can('view employee')
        <li class="nav-item {{ request()->routeIs('employee.list') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{ route('employee.list') }}">
            {{-- <i class="ri-arrow-up-down-fill"></i> --}}
            <span>Employee List</span>
          </a>
        </li>
        @endcan
        @can('view resignation')
        <li class="nav-item {{ request()->routeIs('resignation.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('resignation.index')}}">
            {{-- <i class="ri-dvd-fill"></i> --}}
            <span>resignation</span>
          </a>
        </li>
        @endcan
      </ul>
      @endcan

      <a class="nav-link collapsed" data-bs-target="#attendance-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-dvd-fill"></i>
        <span>Attendance</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="attendance-nav" class="nav-content collapse {{ request()->routeIs($activeAttendance) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        @can('view presence summary')
        <li class="nav-item {{ request()->routeIs('presenceSummary.list') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('presenceSummary.list')}}">
            {{-- <i class="ri-calendar-check-fill"></i> --}}
            <span>Summary</span>
          </a>
        </li>
        @endcan
        @can('view presence')
        <li class="nav-item {{ request()->routeIs('presence.list.admin') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{ route('presence.list.admin') }}">
            {{-- <i class="ri-arrow-up-down-fill"></i> --}}
            <span>Presences</span>
          </a>
        </li>
        @endcan
        @can('view overtime')
        <li class="nav-item {{ request()->routeIs('overtime.list') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('overtime.list')}}">
            {{-- <i class="ri-dvd-fill"></i> --}}
            <span>Overtime</span>
          </a>
        </li>
        @endcan
        @can('view leave')
        <li class="nav-item {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('leaves.index')}}">
            {{-- <i class="ri-dvd-fill"></i> --}}
            <span>Leave</span>
          </a>
        </li>
        @endcan
      </ul>

      <a class="nav-link collapsed" data-bs-target="#performance-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-award-fill"></i>
        <span>Performance</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="performance-nav" class="nav-content collapse {{ request()->routeIs($activePerformance) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        @can('view employee grade')
          <li>
              <a class="nav-link collapsed {{ request()->routeIs('performance.grade') ? 'active' : '' }}" href="{{ route('performance.grade') }}">
                  <span>Employee Grade</span>
              </a>
          </li>
        @endcan
        @can('view kpi')
          <li>
              <a class="nav-link collapsed {{ request()->routeIs('kpi.list') ? 'active' : '' }}" href="{{ route('kpi.list') }}">
                  <span>Key Performance Indicator</span>
              </a>
          </li>
        @endcan
        @can('view pa')
          <li>
              <a class="nav-link collapsed {{ request()->routeIs('pa.list') ? 'active' : '' }}" href="{{ route('pa.list') }}">
                  <span>Performance Appraisal</span>
              </a>
          </li>
        @endcan
        @can('view pm')
          <li>
              <a class="nav-link collapsed {{ request()->routeIs('kpi.pa.index') ? 'active' : '' }}" href="{{ route('kpi.pa.options.index') }}">
                  <span>Setting KPI & PA</span>
              </a>
          </li>
        @endauth
      </ul>
      @can('view sales')
      <li class="nav-item {{ request()->routeIs('sales.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('sales.list')}}">
          <i class="ri-shopping-bag-fill"></i>
          <span>Sales Summary</span>
        </a>
      </li>
      @endcan

      <a class="nav-link collapsed" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
        {{-- <i class="ri-award-fill"></i> --}}
        <i class="ri-settings-4-fill"></i>
        <span>Data Master</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="master-nav" class="nav-content collapse {{ request()->routeIs($activeDataMaster) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        @can('view options')
        <li class="nav-item {{ request()->routeIs('options.list') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('options.list')}}">
            {{-- <i class="ri-settings-4-fill"></i> --}}
            <span>Options</span>
          </a>
        </li>
        @endcan
        @can('view work pattern')
        <li class="nav-item {{ request()->routeIs('workDay.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('workDay.index')}}">
            {{-- <i class="ri-settings-4-fill"></i> --}}
            <span>Work pattern</span>
          </a>
        </li>
        @endcan
        @can('view role')
        <li class="nav-item {{ request()->routeIs('role.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('role.index')}}">
            {{-- <i class="ri-settings-4-fill"></i> --}}
            <span>Role</span>
          </a>
        </li>
        @endcan
        @can('view user')
        <li class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('user.index')}}">
            {{-- <i class="ri-settings-4-fill"></i> --}}
            <span>User</span>
          </a>
        </li>
        @endcan
      </ul>
      <li class="nav-item {{ request()->routeIs('auth.logout') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('auth.logout')}}">
          <i class="bi bi-box-arrow-right"></i>
          <span>Log Out</span>
        </a>
      </li>
      {{-- <li class="nav-item {{ request()->routeIs('logs.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('logs.index')}}">
          <i class="ri-settings-4-fill"></i>
          <span>Log</span>
        </a>
      </li> --}}
    </ul>
</aside>