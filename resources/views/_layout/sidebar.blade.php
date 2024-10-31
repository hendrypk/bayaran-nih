@php
    $activePerformance = [
        'performance.grade',
        'kpi.list',
        'appraisal.list',
        'kpi.pa.index',
    ];

    $activePayroll = [
      'payroll.option',
      ];
@endphp

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('employee.app')}}">
          <i class="ri-apps-2-fill"></i>
          <span>Presence (beta)</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('employee.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('employee.list')}}">
          <i class="ri-account-pin-circle-fill"></i>
          <span>Employee</span>
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

      <li class="nav-item {{ request()->routeIs('presence.list.admin') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('presence.list.admin') }}">
          <i class="ri-arrow-up-down-fill"></i>
          <span>Presences</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('presenceSummary.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('presenceSummary.list')}}">
          <i class="ri-calendar-check-fill"></i>
          <span>Presences Summary</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('overtime.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('overtime.list')}}">
          <i class="ri-dvd-fill"></i>
          <span>Overtime</span>
        </a>
      </li>

      <a class="nav-link collapsed" data-bs-target="#performance-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-award-fill"></i>
        <span>Performance</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="performance-nav" class="nav-content collapse {{ request()->routeIs($activePerformance) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
              <a class="nav-link collapsed {{ request()->routeIs('performance.grade') ? 'active' : '' }}" href="{{ route('performance.grade') }}">
                  <span>Employee Grade</span>
              </a>
          </li>
          <li>
              <a class="nav-link collapsed {{ request()->routeIs('kpi.list') ? 'active' : '' }}" href="{{ route('kpi.list') }}">
                  <span>Key Performance Indicator</span>
              </a>
          </li>
          <li>
              <a class="nav-link collapsed {{ request()->routeIs('appraisal.list') ? 'active' : '' }}" href="{{ route('appraisal.list') }}">
                  <span>Performance Appraisal</span>
              </a>
          </li>
          <li>
              <a class="nav-link collapsed {{ request()->routeIs('kpi.pa.index') ? 'active' : '' }}" href="{{ route('kpi.pa.options.index') }}">
                  <span>Setting KPI & PA</span>
              </a>
          </li>
      </ul>
    
      <li class="nav-item {{ request()->routeIs('sales.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('sales.list')}}">
          <i class="ri-shopping-bag-fill"></i>
          <span>Sales Summary</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('options.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('options.list')}}">
          <i class="ri-settings-4-fill"></i>
          <span>Options</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('workDay.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('workDay.index')}}">
          <i class="ri-settings-4-fill"></i>
          <span>Work pattern</span>
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