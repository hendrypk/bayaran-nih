<div class="appBottomMenu">
        <a href="{{ route('employee.app') }}" class="item {{ request()->is('app') ? 'active' : '' }}">
            <div class="col">
                <ion-icon role="img" class="md hydrated ri-home-4-line"
                    aria-label="file tray full outline"></ion-icon>
                <strong>{{ __('app.label.home') }}</strong>
            </div>
        </a>
        <a href="{{ route('payslip.index') }}" class="item">
            <div class="col">
                <ion-icon role="img" class="md hydrated ri-money-dollar-box-line"
                    aria-label="calendar outline"></ion-icon>
                <strong>{{ __('app.label.my_slip') }}</strong>
            </div>
        </a>

        <a href="{{ route('profileIndex') }}" class="item">
            <div class="col">
                <ion-icon role="img" class="md hydrated ri-settings-3-line" aria-label="people outline"></ion-icon>
                <strong>{{ __('app.label.setting') }}</strong>
            </div>
        </a>
        <a href="{{ route('about.app') }}" class="item">
            <div class="col">
                <ion-icon role="img" class="md hydrated ri-information-line"
                    aria-label="document text outline"></ion-icon>
                <strong>{{ __('app.label.about') }}</strong>
            </div>
        </a>

    </div>