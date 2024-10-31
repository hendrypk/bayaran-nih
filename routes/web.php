<?php

use App\Models\Options;
use App\Http\Controllers\Test;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\WorkDayController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\AppraisalController;
use App\Http\Controllers\FinalGradeController;
use App\Http\Controllers\EmployeeAppController;
use App\Http\Controllers\KpiPaOptionsController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\PresenceSummaryController;

//error page
Route::get('/test',[Test::class, 'test']);

//error page
Route::get('/error', function() {return view('page-error');})->name('error');
//Under Maintenance
Route::get('/maintenance', function() {return view('maintenance');})->name('maintenance');

//Auth
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('login/submit', [AuthController::class, 'login'])->name('login.process');
Route::get('register',[AuthController::class,'register'])->name('register');
Route::post('register',[AuthController::class,'create'])->name('submitRegister');

//Reset Password
Route::get('password/reset', [ResetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ResetPasswordController::class, 'forgotPassword'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Route::middleware([Authenticate::class])->group(function(){
Route::middleware(['auth'])->group(function(){
    Route::middleware(['auth',  \App\Http\Middleware\RoleMiddleware::class . ':admin,user'])->group(function(){
        //About
        Route::get('/about', [EmployeeAppController::class, 'about'])->name('about.app');
        //Employee App
        Route::get('/', [EmployeeAppController::class, 'index'])->name('employee.app');
        //Presensi 
        Route::get('/presence', [EmployeeAppController::class, 'create'])->name('presence.create');
        Route::post('/presence/submit', [EmployeeAppController::class, 'store'])->name('presence.submit');
        Route::post('/presence/submit/image', [EmployeeAppController::class, 'imageStore'])->name('image.submit');
        //Overtime
        Route::get('/overtime', [EmployeeAppController::class, 'overtime'])->name('overtime.create');
        Route::post('/overtime/submit', [EmployeeAppController::class, 'overtimeStore'])->name('overtime.submit');
        Route::get('overtime/history', [EmployeeAppController::class, 'overtimeHistory'])->name('overtime.history');
        //History
        Route::get('/history', [EmployeeAppController::class, 'history'])->name('presence.history');
        //Profile
        Route::get('/profile', [EmployeeAppController::class, 'profileIndex'])->name('profileIndex');
        Route::get('username/change', [EmployeeAppController::class, 'resetUsername'])->name('change.username');
        Route::get('password/change', [EmployeeAppController::class, 'resetPassword'])->name('change.password');
        //Reset Username or Passord
        // Route::post('profile/reset', [EmployeeAppController::class, 'reset'])->name('reset');
        Route::post('username/reset', [EmployeeAppController::class, 'resetUsernameStore'])->name('reset.username');
        Route::post('/password/reset', [EmployeeAppController::class, 'resetPasswordStore'])->name('reset.password');

        //logout
        Route::get('logout',[AuthController::class,'logout'])->name('auth.logout');
    });

    Route::middleware(['auth',  \App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function(){
    //dashboard
    Route::get('/home', function () {return view('home');})->name('home');

    //Options
        // index
        Route::get('/options', [OptionsController::class,'index'])->name('options.list');
        //position
        Route::post('options/position/submit', [OptionsController::class,'positionAdd'])->name('position.add');  
        Route::post('options/position/{id}/edit', [OptionsController::class,'positionEdit'])->name('position.edit');
        Route::post('options/position/{id}/update', [OptionsController::class,'positionUpdate'])->name('position.update');
        Route::post('options/position/{id}/delete', [OptionsController::class,'positionDelete'])->name('position.delete');

        //jobtitle
        Route::post('options/jobtitle/submit', [OptionsController::class,'jobTitleAdd'])->name('jobTitle.add');
        Route::post('options/jobtitle/{id}/edit', [OptionsController::class,'jobTitleEdit'])->name('jobTitle.edit');
        Route::post('options/jobtitle/{id}/update', [OptionsController::class,'jobTitleUpdate'])->name('jobTitle.update');
        Route::post('options/jobtitle/{id}/delete', [OptionsController::class,'jobTitleDelete'])->name('jobTitle.delete');

        //division
        Route::post('options/division/submit', [OptionsController::class,'divisionAdd'])->name('division.add');
        Route::post('options/division/{id}/edit', [OptionsController::class,'divisionEdit'])->name('division.edit');
        Route::post('options/division/{id}/update', [OptionsController::class, 'divisionUpdate'])->name('division.update');
        Route::post('/options/division/{id}/delete', [OptionsController::class, 'divisionDelete'])->name('division.delete');

        //department
        Route::post('options/department/submit', [OptionsController::class,'departmentAdd'])->name('department.add');
        Route::post('options/department/{id}/edit', [OptionsController::class,'departmentEdit'])->name('department.edit');
        Route::post('options/department/{id}/update', [OptionsController::class, 'departmentUpdate'])->name('department.update');
        Route::post('/options/department/{id}/delete', [OptionsController::class, 'departmentDelete'])->name('department.delete');

        //sales person
        Route::post('options/salesperson/submit', [OptionsController::class,'salesPersonAdd'])->name('salesPerson.add');
        Route::post('options/salesperson/{id}/edit', [OptionsController::class,'salesPersonedit'])->name('salesPerson.edit');
        Route::post('options/salesperson/{id}/update', [OptionsController::class,'salesPersonUpdate'])->name('salesPerson.update');
        Route::post('options/salesperson/{id}/delete',[OptionsController::class, 'salesPersonDelete'])->name('salesPerson.delete');

        //employee status
        Route::post('options/status/submit', [OptionsController::class,'statusAdd'])->name('status.add');
        Route::post('options/status/{id}/edit', [OptionsController::class,'statusEdit'])->name('status.edit');
        Route::post('options/status/{id}/update', [OptionsController::class,'statusUpdate'])->name('status.update');
        Route::post('options/status/{id}/delete',[OptionsController::class, 'statusDelete'])->name('status.delete');

        //schedule
        Route::post('options/schedule/submit', [OptionsController::class, 'scheduleAdd'])->name('schedule.add');
        Route::post('options/schedule/{id}/edit', [OptionsController::class,'scheduletEdit'])->name('schedule.edit');
        Route::post('options/schedule/{id}/update', [OptionsController::class, 'scheduleUpdate'])->name('schedule.update');
        Route::post('options/schedule/{id}/delete', [OptionsController::class, 'scheduleDelete'])->name('schedule.delete');

        //Performance
            //Options   
            Route::get('/setting-kpi-pa', [KpiPaOptionsController::class, 'index'])->name('kpi.pa.options.index');
            //indicator
            Route::post('indicator/submit', [KpiPaOptionsController::class, 'indicatorAdd'])->name('indicator.add');
            Route::post('indicator/{id}/edit', [KpiPaOptionsController::class,'indicatorEdit'])->name('indicator.edit');
            Route::post('indicator/{kpi_id}/update', [KpiPaOptionsController::class, 'indicatorUpdate'])->name('indicator.update');
            Route::post('indicator/{id}/delete', [KpiPaOptionsController::class, 'indicatorDelete'])->name('indicator.delete');
            Route::get('indicator/{kpi_id}/detail', [KpiPaOptionsController::class, 'indicatorDetail'])->name('indicator.detail');

            //appraisal
            Route::post('/options/appraisal/submit', [KpiPaOptionsController::class, 'appraisalAdd'])->name('appraisal.add');
            Route::post('appraisal/{id}/edit', [KpiPaOptionsController::class,'appraisalEdit'])->name('appraisal.edit');
            Route::post('appraisal/{id}/update', [KpiPaOptionsController::class, 'appraisalUpdate'])->name('appraisal.update');
            Route::post('appraisal/{id}/delete', [KpiPaOptionsController::class, 'appraisalDelete'])->name('appraisal.delete');

        //on day calendar
        Route::post('options/onday/submit', [OptionsController::class,'onDayCalendarAdd'])->name('onDayCalendar.add');
        Route::post('options/onday/{id}/delete', [OptionsController::class,'onDayCalendarDelete'])->name('onDayCalendar.delete');
        Route::post('options/onday/{id}/update', [OptionsController::class,'onDayCalendarUpdate'])->name('onDayCalendar.update');

        //Office Location
        Route::post('options/location/submit', [OptionsController::class, 'addLocation'])->name('location.add');
        Route::post('options/location/{id}/update', [OptionsController::class, 'editLocation'])->name('location.edit');
        Route::post('options/location/{id}/delete', [OptionsController::class,'deleteLocation'])->name('location.delete');

        //employee
        Route::get('/employee', [EmployeeController::class,'employeelist'])->name('employee.list'); 
        Route::get('/employee/add', [EmployeeController::class,'create'])->name('employee.add');
        Route::post('/employee/submit', [EmployeeController::class,'submit'])->name('employee.submit'); 
        Route::get('employee/{id}', [EmployeeController::class, 'detail'])->name('employee.detail'); 
        Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit'); 
        Route::post('/employee/{id}/update', [EmployeeController::class, 'update'])->name('employee.update'); 
        Route::post('/employee/{id}/delete', [EmployeeController::class, 'delete'])->name('employee.delete'); 

        //presence
        Route::get('presences-list', [PresenceController::class, 'index'])->name('presence.list.admin');
        Route::get('presences/import', [PresenceController::class, 'import'])->name('presence.import');
        Route::post('presences/import/submit', [PresenceController::class, 'importStore'])->name('import');
        Route::post('presences/{id}/delete', [PresenceController::class, 'delete'])->name('presence.delete');
        Route::post('presences/submit', [PresenceController::class, 'create'])->name('presence.create.admin');
        Route::post('presences/{id}/update', [PresenceController::class, 'update'])->name('presence.update.admin');
        Route::post('presences/export', [PresenceController::class, 'export'])->name('presence.export');

        //presence_summary
        Route::get('/presences/summary', [PresenceSummaryController::class, 'index'])->name('presenceSummary.list');

        //overtime
        Route::get('/overtimes', [OvertimeController::class, 'index'])->name('overtime.list');
        Route::post('/overtimes/submit',[OvertimeController::class,'submit'])->name('overtime.add');
        Route::post('/overtimes/{id}/delete', [OvertimeController::class,'delete'])->name('overtime.delete');
        route::post('/overtimes/{id}/update', [OvertimeController::class,'update'])->name('overtime.update');
        Route::get('/overtimes/summary', [OvertimeController::class, 'recapOvertime'])->name('overtime.summary');
        Route::post('overtimes/export', [OvertimeController::class, 'export'])->name('overtime.export');

        //kpi
        Route::get('kpi', [KpiController::class, 'indexKpi'])->name('kpi.list');
        Route::get('kpi/add', [KpiController::class, 'addKpi'])->name('kpi.add');
        Route::post('kpi/submit', [KpiController::class, 'create'])->name('kpi.create');
        Route::get('/kpi/get-by-kpi-id/{kpiId}', [KpiController::class, 'getKpiByEmployee'])->name('kpi.getByEmployee');
        Route::get('kpi/{employee_id}/{month?}/{year}', [KpiController::class, 'detail'])->name('kpi.detail'); 
        Route::post('kpi/{employee_id}/{month}/{year?}/delete', [KpiController::class, 'delete'])->name('kpi.delete'); 
        Route::get('kpi/{employee_id}/{month?}/{year?}/edit', [KpiController::class, 'edit'])->name('kpi.edit'); 
        Route::post('kpi/{employee_id}/{month}/{year?}/update', [KpiController::class, 'update'])->name('kpi.update');

        Route::post('/kpi/filter', [KpiController::class, 'filterKpisByPosition'])->name('kpi.filter');

        //appraisal
        Route::get('appraisal', [AppraisalController::class, 'index'])->name('appraisal.list');
        Route::post('appraisal/submit', [AppraisalController::class, 'create'])->name('paGrade.add');
        Route::get('appraisal/{employee_id}/{month?}/{year}', [AppraisalController::class, 'detail'])->name('appraisal.detail'); 
        Route::get('appraisal/{employee_id}/{month?}/{year?}/edit', [AppraisalController::class, 'edit'])->name('appraisal.edit'); 
        Route::post('appraisal/{employee_id}/{month}/{year?}/update', [AppraisalController::class, 'update'])->name('appraisalGrade.update'); 
        Route::post('appraisal/{employee_id}/{month}/{year?}/delete', [AppraisalController::class, 'delete'])->name('appraisal.delete'); 

        //FInal Grade
        Route::get('/performance/grade', [FinalGradeController::class, 'index'])->name('performance.grade');

        //sales
        Route::get('/sales', [SalesController::class,'index'])->name('sales.list');
        Route::post('/sales/submit', [SalesController::class,'create'])->name('sales.create');  
        Route::get('/sales/{month}/{year}/detail', [SalesController::class,'detail'])->name('sales.detail');  
        Route::get('/sales/{month}/{year?}/edit', [SalesController::class, 'edit'])->name('sales.edit'); 
        Route::post('/sales/{month}/{year?}/update', [SalesController::class, 'update'])->name('sales.update'); 
        Route::post('/sales/{month}/{year?}/delete', [SalesController::class, 'delete'])->name('sales.delete'); 

        //payroll option
        Route::get('/payroll/option', [PayrollController::class, 'payrollOption'])->name('payroll.option');

        //Work Day
        Route::get('/work-day', [WorkDayController::class, 'index'])->name('workDay.index');
        Route::post('/work-day/submit', [WorkDayController::class, 'create'])->name('workDay.create');
        Route::get('/work-day/detail/{name}', [WorkDayController::class, 'detail'])->name('workDay.detail');
        Route::get('/work-day/edit/{name}', [WorkDayController::class, 'edit'])->name('workDay.edit');
        Route::post('/work-day/{name}/update', [WorkDayController::class, 'update'])->name('workDay.update');
        Route::post('/work-day/{name}/delete', [WorkDayController::class, 'delete'])->name('workDay.delete');

        //Log
        Route::get('/logs', function () {
            $logFile = storage_path('logs/laravel.log');
            $logs = [];
        
            if (file_exists($logFile)) {
                $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            }
        
            return view('logs', ['logs' => array_reverse($logs)]);
        })->name('logs.index');

    });
});