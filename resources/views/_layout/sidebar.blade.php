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
      <a class="nav-link collapsed" href="{{ route('home') }}">
        <i class="ri-home-smile-fill"></i>
        <span>{{ __('sidebar.label.dashboard') }}</span>
      </a>
    </li>

    @can('view employee')
    <a class="nav-link collapsed" data-bs-target="#employee-nav" data-bs-toggle="collapse" href="#">
      <i class="ri-account-pin-circle-fill"></i>
      <span>{{ __('sidebar.label.employee') }}</span>
      <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="employee-nav" class="nav-content collapse {{ request()->routeIs($activeEmployee) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
      @can('create employee')
      <li class="nav-item {{ request()->routeIs('employee.add') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('employee.add') }}">
          <span>{{ __('sidebar.label.add_employee') }}</span>
        </a>
      </li>
      @endcan
      @can('view employee')
      <li class="nav-item {{ request()->routeIs('employee.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('employee.list') }}">
          <span>{{ __('sidebar.label.employee_list') }}</span>
        </a>
      </li>
      @endcan
      @can('view resignation')
      <li class="nav-item {{ request()->routeIs('resignation.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('resignation.index') }}">
          <span>{{ __('sidebar.label.resignation') }}</span>
        </a>
      </li>
      @endcan
      @can('view position change')
      <li class="nav-item {{ request()->routeIs('position.change.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('position.change.index') }}">
          <span>{{ __('sidebar.label.position_change') }}</span>
        </a>
      </li>
      @endcan
    </ul>
    @endcan

    <a class="nav-link collapsed" data-bs-target="#attendance-nav" data-bs-toggle="collapse" href="#">
      <i class="ri-time-fill"></i>
      <span>{{ __('sidebar.label.attendance') }}</span>
      <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="attendance-nav" class="nav-content collapse {{ request()->routeIs($activeAttendance) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
      @can('view presence summary')
      <li class="nav-item {{ request()->routeIs('presenceSummary.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('presenceSummary.list') }}">
          <span>{{ __('sidebar.label.presence_summary') }}</span>
        </a>
      </li>
      @endcan
      @can('view presence')
      <li class="nav-item {{ request()->routeIs('presence.list.admin') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('presence.list.admin') }}">
          <span>{{ __('sidebar.label.presences') }}</span>
        </a>
      </li>
      @endcan
      @can('view overtime')
      <li class="nav-item {{ request()->routeIs('overtime.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('overtime.list') }}">
          <span>{{ __('sidebar.label.overtime') }}</span>
        </a>
      </li>
      @endcan
      @can('view leave')
      <li class="nav-item {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('leaves.index') }}">
          <span>{{ __('sidebar.label.leave') }}</span>
        </a>
      </li>
      @endcan
    </ul>

    <a class="nav-link collapsed" data-bs-target="#performance-nav" data-bs-toggle="collapse" href="#">
      <i class="ri-medal-fill"></i>
      <span>{{ __('sidebar.label.performance') }}</span>
      <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="performance-nav" class="nav-content collapse {{ request()->routeIs($activePerformance) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
      @can('view employee grade')
        <li>
            <a class="nav-link collapsed {{ request()->routeIs('performance.grade') ? 'active' : '' }}" href="{{ route('performance.grade') }}">
                <span>{{ __('sidebar.label.employee_grade') }}</span>
            </a>
        </li>
      @endcan
      @can('view kpi')
        <li>
            <a class="nav-link collapsed {{ request()->routeIs('kpi.list') ? 'active' : '' }}" href="{{ route('kpi.list') }}">
                <span>{{ __('sidebar.label.kpi') }}</span>
            </a>
        </li>
      @endcan
      @can('view pa')
        <li>
            <a class="nav-link collapsed {{ request()->routeIs('pa.list') ? 'active' : '' }}" href="{{ route('pa.list') }}">
                <span>{{ __('sidebar.label.performance_appraisal') }}</span>
            </a>
        </li>
      @endcan
      @can('view pm')
        <li>
            <a class="nav-link collapsed {{ request()->routeIs('kpi.pa.index') ? 'active' : '' }}" href="{{ route('kpi.pa.options.index') }}">
                <span>{{ __('sidebar.label.setting_kpi_pa') }}</span>
            </a>
        </li>
      @endcan
    </ul>

    @can('view sales')
    <li class="nav-item {{ request()->routeIs('sales.list') ? 'active' : '' }}">
      <a class="nav-link collapsed" href="{{ route('sales.list') }}">
        <i class="ri-shopping-bag-fill"></i>
        <span>{{ __('sidebar.label.sales_summary') }}</span>
      </a>
    </li>
    @endcan

    <a class="nav-link collapsed" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
      <i class="ri-settings-4-fill"></i>
      <span>{{ __('sidebar.label.data_master') }}</span>
      <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="master-nav" class="nav-content collapse {{ request()->routeIs($activeDataMaster) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
      @can('view options')
      <li class="nav-item {{ request()->routeIs('options.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('options.list') }}">
          <span>{{ __('sidebar.label.options') }}</span>
        </a>
      </li>
      @endcan
      @can('view work pattern')
      <li class="nav-item {{ request()->routeIs('workDay.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('workDay.index') }}">
          <span>{{ __('sidebar.label.work_day') }}</span>
        </a>
      </li>
      @endcan
      @can('view role')
      <li class="nav-item {{ request()->routeIs('role.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('role.index') }}">
          <span>{{ __('sidebar.label.role') }}</span>
        </a>
      </li>
      @endcan
      @can('view user')
      <li class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('user.index') }}">
          <span>{{ __('sidebar.label.user') }}</span>
        </a>
      </li>
      @endcan
    </ul>
    <li class="nav-item {{ request()->routeIs('auth.logout') ? 'active' : '' }}">
      <a class="nav-link collapsed" href="{{ route('auth.logout') }}">
        <i class="ri-logout-box-r-fill"></i>
        <span>{{ __('sidebar.label.log_out') }}</span>
      </a>
    </li>
  </ul>
</aside>


{{-- <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('home')}}">
          <i class="ri-home-smile-fill"></i>
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
            <span>Add Employee</span>
          </a>
        </li>
        @endcan
        @can('view employee')
        <li class="nav-item {{ request()->routeIs('employee.list') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{ route('employee.list') }}">
            <span>Employee List</span>
          </a>
        </li>
        @endcan
        @can('view resignation')
        <li class="nav-item {{ request()->routeIs('resignation.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('resignation.index')}}">
            <span>Resignation</span>
          </a>
        </li>
        @endcan
        @can('view resignation')
        <li class="nav-item {{ request()->routeIs('position.change.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('position.change.index')}}">
            <span>Position Change</span>
          </a>
        </li>
        @endcan
      </ul>
      @endcan

      <a class="nav-link collapsed" data-bs-target="#attendance-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-time-fill"></i>
        <span>Attendance</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="attendance-nav" class="nav-content collapse {{ request()->routeIs($activeAttendance) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        @can('view presence summary')
        <li class="nav-item {{ request()->routeIs('presenceSummary.list') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('presenceSummary.list')}}">
            <span>Summary</span>
          </a>
        </li>
        @endcan
        @can('view presence')
        <li class="nav-item {{ request()->routeIs('presence.list.admin') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{ route('presence.list.admin') }}">
            <span>Presences</span>
          </a>
        </li>
        @endcan
        @can('view overtime')
        <li class="nav-item {{ request()->routeIs('overtime.list') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('overtime.list')}}">
            <span>Overtime</span>
          </a>
        </li>
        @endcan
        @can('view leave')
        <li class="nav-item {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('leaves.index')}}">
            <span>Leave</span>
          </a>
        </li>
        @endcan
      </ul>

      <a class="nav-link collapsed" data-bs-target="#performance-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-medal-fill"></i>
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
        <i class="ri-settings-4-fill"></i>
        <span>Data Master</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="master-nav" class="nav-content collapse {{ request()->routeIs($activeDataMaster) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        @can('view options')
        <li class="nav-item {{ request()->routeIs('options.list') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('options.list')}}">
            <span>Options</span>
          </a>
        </li>
        @endcan
        @can('view work pattern')
        <li class="nav-item {{ request()->routeIs('workDay.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('workDay.index')}}">
            <span>Work Day</span>
          </a>
        </li>
        @endcan
        @can('view role')
        <li class="nav-item {{ request()->routeIs('role.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('role.index')}}">
            <span>Role</span>
          </a>
        </li>
        @endcan
        @can('view user')
        <li class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="{{route('user.index')}}">
            <span>User</span>
          </a>
        </li>
        @endcan
      </ul>
      <li class="nav-item {{ request()->routeIs('auth.logout') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('auth.logout')}}">
          <i class="ri-logout-box-r-fill"></i>
          <span>Log Out</span>
        </a>
      </li>
    </ul>
</aside> --}}