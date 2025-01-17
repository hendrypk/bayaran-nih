<?php

use App\Models\User;
use App\Models\Options;
use App\Http\Controllers\Test;
use Spatie\Permission\Models\Role;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Models\EmployeePositionChange;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SalesController;
use App\Http\Middleware\LocaleMiddleware;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\WorkDayController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\AppraisalController;
use App\Http\Controllers\FinalGradeController;
use App\Http\Controllers\EmployeeAppController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\KpiPaOptionsController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\PresenceSummaryController;
use App\Http\Controllers\EmployeePositionChangeController;

//error page
Route::get('/test',[Test::class, 'test'])->name('test');

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

//Get API
Route::get('/github/releases', [ApiController::class, 'getReleases']);

//Language Switcher
// Route::middleware([LocaleMiddleware::class])->group(function () {
//     Route::get('language/{lang}', function ($lang) {
//         if (in_array($lang, ['en', 'id'])) {
//             session()->put('locale', $lang); // Pastikan ini terjadi
//         }
    
//         // // Debugging setelah perubahan
//         // dd(session()->all());  // Memastikan bahwa 'locale' sudah berubah
    
//         return redirect()->back();
//     })->name('locale.switch');
    
// });

// Route::middleware([LocaleMiddleware::class])->group(function () {
//     Route::get('/switch-language/{lang}', function ($lang) {
//         if (in_array($lang, ['en', 'id'])) { // Pastikan hanya menerima 'en' atau 'id'
//             session(['locale' => $lang]); // Simpan bahasa di session
//             app()->setLocale($lang); // Ubah bahasa aktif di aplikasi
//         }
//         return redirect()->back(); // Kembali ke halaman sebelumnya
//     })->name('switch.language');
// });

Route::middleware([LocaleMiddleware::class])->group(function () {
    Route::get('switch-language/{lang}', function ($lang) {
        if (in_array($lang, ['en', 'id'])) {
            session(['locale' => $lang]);
        }
        return redirect()->back();
    })->name('locale.switch');
});

//Administrator Middleware Group
Route::middleware(['auth:web'])->group(function () {
    //Dashboard
    // Route::get('/home', function () {return view('home');})->name('home');
    Route::get('home', [HomeController::class, 'index'])->name('home');

    //Options
    Route::prefix('options')->group(function () {
        Route::group(['middleware' => ['permission:view options']], function() {
            // index
            Route::get('', [OptionsController::class,'index'])->name('options.list');
            //position
            Route::post('position/submit', [OptionsController::class,'positionAdd'])->name('position.add');  
            Route::post('position/{id}/edit', [OptionsController::class,'positionEdit'])->name('position.edit');
            Route::post('position/{id}/update', [OptionsController::class,'positionUpdate'])->name('position.update');
            Route::post('position/{id}/delete', [OptionsController::class,'positionDelete'])->name('position.delete');
    
            //jobtitle
            Route::post('jobtitle/submit', [OptionsController::class,'jobTitleAdd'])->name('jobTitle.add');
            Route::post('jobtitle/{id}/edit', [OptionsController::class,'jobTitleEdit'])->name('jobTitle.edit');
            Route::post('jobtitle/{id}/update', [OptionsController::class,'jobTitleUpdate'])->name('jobTitle.update');
            Route::post('jobtitle/{id}/delete', [OptionsController::class,'jobTitleDelete'])->name('jobTitle.delete');
    
            //division
            Route::post('division/submit', [OptionsController::class,'divisionAdd'])->name('division.add');
            Route::post('division/{id}/edit', [OptionsController::class,'divisionEdit'])->name('division.edit');
            Route::post('division/{id}/update', [OptionsController::class, 'divisionUpdate'])->name('division.update');
            Route::post('division/{id}/delete', [OptionsController::class, 'divisionDelete'])->name('division.delete');
    
            //department
            Route::post('department/submit', [OptionsController::class,'departmentAdd'])->name('department.add');
            Route::post('department/{id}/edit', [OptionsController::class,'departmentEdit'])->name('department.edit');
            Route::post('department/{id}/update', [OptionsController::class, 'departmentUpdate'])->name('department.update');
            Route::post('department/{id}/delete', [OptionsController::class, 'departmentDelete'])->name('department.delete');
    
            //sales person
            Route::post('salesperson/submit', [OptionsController::class,'salesPersonAdd'])->name('salesPerson.add');
            Route::post('salesperson/{id}/edit', [OptionsController::class,'salesPersonedit'])->name('salesPerson.edit');
            Route::post('salesperson/{id}/update', [OptionsController::class,'salesPersonUpdate'])->name('salesPerson.update');
            Route::post('salesperson/{id}/delete',[OptionsController::class, 'salesPersonDelete'])->name('salesPerson.delete');
    
            //employee status
            Route::post('status/submit', [OptionsController::class,'statusAdd'])->name('status.add');
            Route::post('status/{id}/edit', [OptionsController::class,'statusEdit'])->name('status.edit');
            Route::post('status/{id}/update', [OptionsController::class,'statusUpdate'])->name('status.update');
            Route::post('status/{id}/delete',[OptionsController::class, 'statusDelete'])->name('status.delete');
    
            //schedule
            Route::post('schedule/submit', [OptionsController::class, 'scheduleAdd'])->name('schedule.add');
            Route::post('schedule/{id}/edit', [OptionsController::class,'scheduletEdit'])->name('schedule.edit');
            Route::post('schedule/{id}/update', [OptionsController::class, 'scheduleUpdate'])->name('schedule.update');
            Route::post('schedule/{id}/delete', [OptionsController::class, 'scheduleDelete'])->name('schedule.delete');

            //Office Location
            Route::post('location/submit', [OptionsController::class, 'addLocation'])->name('location.add');
            Route::post('location/{id}/update', [OptionsController::class, 'editLocation'])->name('location.update');
            Route::post('location/{id}/delete', [OptionsController::class,'deleteLocation'])->name('location.delete');

            //Holiday
            Route::post('holiday/submit', [OptionsController::class, 'holidayAdd'])->name('holiday.add');
            Route::post('holiday/{id}/update', [OptionsController::class, 'holidayUpdate'])->name('holiday.update');
            Route::post('holiday/{id}/delete', [OptionsController::class,'holidayDelete'])->name('holiday.delete');
        });
    });


    //Performance
    Route::group(['middleware' => ['permission:view pm']], function() {
        //Options   
        Route::get('/setting-kpi-pa', [KpiPaOptionsController::class, 'index'])->name('kpi.pa.options.index');
        //indicator
        Route::post('indicator/submit', [KpiPaOptionsController::class, 'indicatorAdd'])->name('indicator.add');
        Route::post('indicator/{id}/edit', [KpiPaOptionsController::class,'indicatorEdit'])->name('indicator.edit');
        Route::post('indicator/{kpi_id}/update', [KpiPaOptionsController::class, 'indicatorUpdate'])->name('indicator.update');
        Route::post('indicator/{id}/delete', [KpiPaOptionsController::class, 'indicatorDelete'])->name('indicator.delete');
        Route::get('indicator/{kpi_id}/detail', [KpiPaOptionsController::class, 'indicatorDetail'])->name('indicator.detail');
        Route::post('aspect/{id}/delete', [KpiPaOptionsController::class, 'aspectDelete'])->name('aspect.delete');

        //appraisal
        Route::post('/options/appraisal/submit', [KpiPaOptionsController::class, 'appraisalAdd'])->name('appraisal.add');
        Route::get('/appraisal/add', [KpiPaOptionsController::class, 'addAppraisalForm'])->name('add.appraisal.form');
        Route::get('/appraisal/{appraisal_id}', [KpiPaOptionsController::class, 'appraisalDetail'])->name('appraisal.detail');
        Route::post('appraisal/{id}/edit', [KpiPaOptionsController::class,'appraisalEdit'])->name('appraisal.edit');
        Route::post('appraisal/{appraisal_id}/update', [KpiPaOptionsController::class, 'appraisalUpdate'])->name('appraisal.update');
        Route::post('appraisal/{id}/delete', [KpiPaOptionsController::class, 'appraisalDelete'])->name('appraisal.delete');
    });

    //employee
    Route::group(['middleware' => ['permission:view employee']], function() {
        Route::prefix('employee')->group(function () {
            Route::get('', [EmployeeController::class,'employeelist'])->name('employee.list'); 
            Route::get('add', [EmployeeController::class,'create'])->name('employee.add');
            Route::post('submit', [EmployeeController::class,'submit'])->name('employee.submit'); 
            Route::get('{id}', [EmployeeController::class, 'detail'])->name('employee.detail'); 
            Route::get('{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit'); 
            Route::post('{id}/update', [EmployeeController::class, 'update'])->name('employee.update'); 
            Route::post('{id}/delete', [EmployeeController::class, 'delete'])->name('employee.delete'); 
            Route::post('{id}/account-reset', [EmployeeController::class, 'resetUsernamePassword'])->name('employee.account.reset');
            Route::get('custom-columns', [EmployeeController::class, 'customColumns'])->name('employee.customColumns');
            Route::post('update-columns', [EmployeeController::class, 'updateTableColumns'])->name('employee.updateTableColumns');

        });
    });

    //presence
    Route::group(['middleware' => ['permission:view presence']], function() {
        Route::prefix('presences')->group(function () {
            Route::get('', [PresenceController::class, 'index'])->name('presence.list.admin');
            Route::get('import', [PresenceController::class, 'import'])->name('presence.import');
            Route::post('import/submit', [PresenceController::class, 'importStore'])->name('import');
            Route::post('{id}/delete', [PresenceController::class, 'delete'])->name('presence.delete');
            Route::post('submit', [PresenceController::class, 'create'])->name('presence.create.admin');
            Route::post('{id}/update', [PresenceController::class, 'update'])->name('presence.update.admin');
            Route::post('export', [PresenceController::class, 'export'])->name('presence.export');
            Route::get('import/template', [PresenceController::class, 'template'])->name('template.import');
            //presence_summary
            Route::get('summary', [PresenceSummaryController::class, 'index'])->name('presenceSummary.list');
        });
    });
    
    //overtime
    Route::group(['middleware' => ['permission:view overtime']], function() {
        Route::prefix('overtimes')->group(function () {
            Route::get('', [OvertimeController::class, 'index'])->name('overtime.list');
            Route::post('submit',[OvertimeController::class,'submit'])->name('overtime.add');
            Route::post('{id}/delete', [OvertimeController::class,'delete'])->name('overtime.delete');
            route::post('{id}/update', [OvertimeController::class,'update'])->name('overtime.update');
            Route::get('summary', [OvertimeController::class, 'recapOvertime'])->name('overtime.summary');
            Route::post('export', [OvertimeController::class, 'export'])->name('overtime.export');
        });
    });

    //kpi
    Route::group(['middleware' => ['permission:view kpi']], function() {
        Route::prefix('kpi')->group(function () {
            Route::get('', [KpiController::class, 'indexKpi'])->name('kpi.list');
            Route::get('add', [KpiController::class, 'addKpi'])->name('kpi.add');
            Route::post('submit', [KpiController::class, 'create'])->name('kpi.create');
            Route::get('get-by-kpi-id/{kpiId}', [KpiController::class, 'getKpiByEmployee'])->name('kpi.getByEmployee');
            Route::get('{employee_id}/{month?}/{year}', [KpiController::class, 'detail'])->name('kpi.detail'); 
            Route::post('{employee_id}/{month}/{year?}/delete', [KpiController::class, 'delete'])->name('kpi.delete'); 
            Route::get('{employee_id}/{month?}/{year?}/edit', [KpiController::class, 'edit'])->name('kpi.edit'); 
            Route::post('{employee_id}/{month}/{year?}/update', [KpiController::class, 'update'])->name('kpi.update');
            Route::post('filter', [KpiController::class, 'filterKpisByPosition'])->name('kpi.filter');
        });
    });
    
    //appraisal
    Route::group(['middleware' => ['permission:view pa']], function() {
        Route::prefix('appraisal')->group(function () {
            Route::get('', [AppraisalController::class, 'index'])->name('pa.list');
            Route::post('submit', [AppraisalController::class, 'create'])->name('pa.add');
            Route::get('get-by-pa-id/{paId}', [AppraisalController::class, 'getPaByEmployee'])->name('pa.getByEmployee');
            Route::get('{employee_id}/{month?}/{year}', [AppraisalController::class, 'detail'])->name('pa.detail'); 
            Route::get('{employee_id}/{month?}/{year?}/edit', [AppraisalController::class, 'edit'])->name('pa.edit'); 
            Route::post('{employee_id}/{month}/{year?}/update', [AppraisalController::class, 'update'])->name('pa.update'); 
            Route::post('{employee_id}/{month}/{year?}/delete', [AppraisalController::class, 'delete'])->name('pa.delete'); 
        });
    });

    //FInal Grade
    Route::group(['middleware' => ['permission:view employee grade']], function() {
        Route::get('/performance/grade', [FinalGradeController::class, 'index'])->name('performance.grade');
        Route::get('/performance/export', [FinalGradeController::class, 'export'])->name('performance.export');

    });
    
    //sales
    Route::group(['middleware' => ['permission:view sales']], function() {
        Route::prefix('sales')->group(function () {
            Route::get('', [SalesController::class,'index'])->name('sales.list');
            Route::post('submit', [SalesController::class,'create'])->name('sales.create');  
            Route::get('{month}/{year}/detail', [SalesController::class,'detail'])->name('sales.detail');  
            Route::get('{month}/{year?}/edit', [SalesController::class, 'edit'])->name('sales.edit'); 
            Route::post('{month}/{year?}/update', [SalesController::class, 'update'])->name('sales.update'); 
            Route::post('{month}/{year?}/delete', [SalesController::class, 'delete'])->name('sales.delete'); 
        });
    });

    //payroll option
    Route::get('/payroll/option', [PayrollController::class, 'payrollOption'])->name('payroll.option');

    //Work Pattern
    Route::group(['middleware' => ['permission:view work pattern']], function() {
        Route::prefix('work-pattern')->group(function () {
            Route::get('', [WorkDayController::class, 'index'])->name('workDay.index');
            Route::post('submit', [WorkDayController::class, 'create'])->name('workDay.create');
            Route::get('detail/{name}', [WorkDayController::class, 'detail'])->name('workDay.detail');
            Route::get('edit/{name}', [WorkDayController::class, 'edit'])->name('workDay.edit');
            Route::post('{name}/update', [WorkDayController::class, 'update'])->name('workDay.update');
            Route::post('{name}/delete', [WorkDayController::class, 'delete'])->name('workDay.delete');
        });
    });

    //User
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::post('/{id}/update', [UserController::class, 'update'])->name('user.update');
        Route::post('{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    });

    //Role
    Route::group(['middleware' => ['permission:view role']], function() {
        Route::prefix('role')->group(function () {
            Route::get('', [RoleController::class, 'index'])->name('role.index');
            Route::get('{id}/detail', [RoleController::class, 'detail'])->name('role.detail');
            Route::get('{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
            Route::get('create', [RoleController::class, 'create'])->name('role.create');
            Route::post('store', [RoleController::class, 'store'])->name('role.store');
            Route::post('{id}/form/store', [RoleController::class, 'update'])->name('role.update');
            Route::post('{id}/delete', [RoleController::class, 'delete'])->name('role.delete');
            // Route::get('loadModal', [RoleController::class, 'loadModal'])->name('role.load_modal');
        });
    });
    
    Route::group(['middleware' => ['permission:view leave']], function() {
        Route::prefix('leaves')->group(function () {
            Route::get('', [LeaveController::class, 'ind'])->name('leaves.index');
            Route::post('submit', [LeaveController::class, 'save'])->name('leaves.create');
            Route::post('{id}/delete', [LeaveController::class, 'destroy'])->name('leaves.delete');
        });
    });

    //Log
    Route::get('/logs', function () {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];
    
        if (file_exists($logFile)) {
            $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }
    
        return view('logs', ['logs' => array_reverse($logs)]);
    })->name('logs.index');

    //Resignation
    Route::prefix('resignation')->group(function () {
        Route::get('', [ResignationController::class, 'index'])->name('resignation.index');
        Route::post('store', [ResignationController::class, 'store'])->name('resignation.store');
        Route::post('update', [ResignationController::class, 'update'])->name('resignation.update');
        Route::post('{id}/delete', [ResignationController::class, 'delete'])->name('resignation.delete');
    });

    //Employee Position Change
    Route::prefix('position-change')->group(function () {
        Route::get('', [EmployeePositionChangeController::class, 'index'])->name('position.change.index');
        Route::post('store', [EmployeePositionChangeController::class, 'store'])->name('position.change.store');
        Route::post('{id}/delete', [EmployeePositionChangeController::class, 'delete'])->name('position.change.delete');
    });

    
});

//Employee Middleware Group
Route::middleware(['auth:employee'])->group(function () {
    //logout
    Route::get('logout',[AuthController::class,'logout'])->name('auth.logout');
    // Employee App
    Route::get('/', [EmployeeAppController::class, 'index'])->name('employee.app');

    // About
    Route::get('/about', [EmployeeAppController::class, 'about'])->name('about.app');

    // Presence Routes
    Route::prefix('presence')->group(function () {
        Route::get('/in', [EmployeeAppController::class, 'presenceIn'])->name('presence.in');
        Route::get('/out', [EmployeeAppController::class, 'presenceOut'])->name('presence.out');
        Route::post('/submit', [EmployeeAppController::class, 'store'])->name('presence.submit');
        Route::post('/submit/image', [EmployeeAppController::class, 'imageStore'])->name('image.submit');
    });
    
    // Overtime Routes
    Route::prefix('overtime')->group(function () {
        Route::get('/in', [EmployeeAppController::class, 'overtime'])->name('overtime.in');
        Route::get('/out', [EmployeeAppController::class, 'overtimeOut'])->name('overtime.out');
        Route::post('/submit', [EmployeeAppController::class, 'overtimeStore'])->name('overtime.submit');
        Route::get('/history', [EmployeeAppController::class, 'overtimeHistory'])->name('overtime.history');
    });
    
    // History
    Route::get('/history', [EmployeeAppController::class, 'history'])->name('presence.history');
    
    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [EmployeeAppController::class, 'profileIndex'])->name('profileIndex');
        Route::get('/username/change', [EmployeeAppController::class, 'resetUsername'])->name('change.username');
        Route::get('/password/change', [EmployeeAppController::class, 'resetPassword'])->name('change.password');
        
        // Reset Username or Password
        Route::post('/username/reset', [EmployeeAppController::class, 'resetUsernameStore'])->name('reset.username');
        Route::post('/password/reset', [EmployeeAppController::class, 'resetPasswordStore'])->name('reset.password');
    });

    //Leave
    Route::prefix('leave')->group(function () {
        Route::get('', [EmployeeAppController::class, 'leaveIndex'])->name('leave.index');
        Route::get('add', [EmployeeAppController::class, 'leaveApply'])->name('leave.apply');
        Route::post('add/submit', [EmployeeAppController::class, 'leaveStore'])->name('leave.create');
    });

    //Payslip
    Route::prefix('payslip')->group(function () {
        Route::get('', [EmployeeAppController::class, 'payslipIndex'])->name('payslip.index');
    });
    
    // Route::get('/', [EmployeeAppController::class, 'index'])->name('employee.app');
    // //About
    // Route::get('/about', [EmployeeAppController::class, 'about'])->name('about.app');
    //         //Employee App
            
    //         //Presensi 
    //         Route::get('/presence', [EmployeeAppController::class, 'create'])->name('presence.create');
    //         Route::post('/presence/submit', [EmployeeAppController::class, 'store'])->name('presence.submit');
    //         Route::post('/presence/submit/image', [EmployeeAppController::class, 'imageStore'])->name('image.submit');
    //         //Overtime
    //         Route::get('/overtime', [EmployeeAppController::class, 'overtime'])->name('overtime.create');
    //         Route::post('/overtime/submit', [EmployeeAppController::class, 'overtimeStore'])->name('overtime.submit');
    //         Route::get('overtime/history', [EmployeeAppController::class, 'overtimeHistory'])->name('overtime.history');
    //         //History
    //         Route::get('/history', [EmployeeAppController::class, 'history'])->name('presence.history');
    //         //Profile
    //         Route::get('/profile', [EmployeeAppController::class, 'profileIndex'])->name('profileIndex');
    //         Route::get('username/change', [EmployeeAppController::class, 'resetUsername'])->name('change.username');
    //         Route::get('password/change', [EmployeeAppController::class, 'resetPassword'])->name('change.password');
    //         //Reset Username or Passord
    //         // Route::post('profile/reset', [EmployeeAppController::class, 'reset'])->name('reset');
    //         Route::post('username/reset', [EmployeeAppController::class, 'resetUsernameStore'])->name('reset.username');
    //         Route::post('/password/reset', [EmployeeAppController::class, 'resetPasswordStore'])->name('reset.password');
    

});

// Route::middleware([Authenticate::class])->group(function(){
// Route::middleware(['auth'])->group(function(){
//     Route::middleware(['auth',  \App\Http\Middleware\RoleMiddleware::class . ':admin,user'])->group(function(){

//     });

//     Route::middleware(['auth',  \App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function(){
//     //dashboard
    
//     });
// });


Route::get('createpermission', function() {
    try {
        $role = Role::create(['name' => 'admin']);
        $permission = Permission::create(['name' => 'update overtime']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);

    } catch (\Exception $e) {
        echo "Error" . $e->getMessage();
    }
});

Route::get('giveusersrole', function() {
    try {
        $user = User::findOrFail(3); // Ensure the user exists
        $user->assignRole(5);
        echo "Suukses";
    } catch(\Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    
});


Route::get('giveuserpermission', function() {
    try {
        $user = User::findOrFail(3);
        $user->givePermissionTo(5);
        echo "Berhasil";
    } catch(\Exception $e) {
        echo $e->getMessage();
    }
});
