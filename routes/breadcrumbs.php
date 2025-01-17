<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
});

// Home > Employee List
Breadcrumbs::for('employee_list', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.employee_list'), route('employee.list'));
});

// Home > Employee List > Employee Detail
Breadcrumbs::for('employee_detail', function (BreadcrumbTrail $trail, $employee) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.employee_list'), route('employee.list'));
    $trail->push(__('breadcrumb.employee_detail'), route('employee.list'));
});

// Home > Employee List > Employee Detail > Edit
Breadcrumbs::for('employee_edit', function (BreadcrumbTrail $trail, $employee) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.employee_list'), route('employee.list'));
    $trail->push(__('breadcrumb.employee_detail'), route('employee.list'));
    $trail->push(__('general.label.edit'), route('employee.list'));
});

// Home > Add Employee
Breadcrumbs::for('add_employee', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.employee_list'), route('employee.list'));
    $trail->push(__('general.label.add'), route('employee.add'));
});

// Home > Employee Resignation
Breadcrumbs::for('employee_resignation', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.resignation'), route('resignation.index'));
});

// Home > Employee Position Change
Breadcrumbs::for('employee_position_change', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.employee_position_change'), route('position.change.index'));
});

// Home > Presence Summary
Breadcrumbs::for('presence_summary', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.presence_summary'), route('presenceSummary.list'));
});

// Home > Presence
Breadcrumbs::for('presence', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.presence'), route('presence.list.admin'));
});

// Home > Presence > Impor
Breadcrumbs::for('presence_import', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.presence'), route('presence.list.admin'));
    $trail->push(__('breadcrumb.presence_import'), route('presence.import'));
});

// Home > Overtime
Breadcrumbs::for('overtime', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.overtime'), route('overtime.list'));
});

// Home > Leave
Breadcrumbs::for('leave', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.leave'), route('leaves.index'));
});

// Home > Employee Grade
Breadcrumbs::for('employee_grade', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.employee_grade'), route('performance.grade'));
});

// Home > KPI
Breadcrumbs::for('kpi', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.kpi'), route('kpi.list'));
});

// Home > KPI > Create KPI Report
Breadcrumbs::for('create_kpi', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.kpi'), route('kpi.list'));
    $trail->push(__('breadcrumb.create_kpi'), route('kpi.add'));
});

// Home > KPI > KPI Detail
Breadcrumbs::for('kpi_detail', function (BreadcrumbTrail $trail, $gradeKpi) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.kpi'), route('kpi.list'));
    $trail->push(__('breadcrumb.kpi_detail'), route('kpi.detail', [
        'employee_id' => $gradeKpi->employee_id,
        'month' => $gradeKpi->month,
        'year' => $gradeKpi->year]));
});

// Home > KPI > Edit KPI Report
Breadcrumbs::for('edit_kpi', function (BreadcrumbTrail $trail, $gradeKpi) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.kpi'), route('kpi.list'));
    $trail->push(__('breadcrumb.edit_kpi'), route('kpi.edit', [
        'employee_id' => $gradeKpi->employee_id,
        'month' => $gradeKpi->month,
        'year' => $gradeKpi->year]));
});

// Home > Appraisal
Breadcrumbs::for('pa', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.kpi'), route('pa.list'));
});

// Home > Appraisal > Detail
Breadcrumbs::for('pa_detail', function (BreadcrumbTrail $trail, $employees, $month, $year) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.performance_appraisal'), route('pa.list'));
    $trail->push('PA Detail', route('pa.detail', [
        'employee_id' => $employees->id,
        'month' => $month,
        'year' => $year]));
});

// Home > Appraisal > Edit
Breadcrumbs::for('edit_pa', function (BreadcrumbTrail $trail, $employees, $month, $year) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.performance_appraisal'), route('pa.list'));
    $trail->push('Edit PA', route('pa.edit', [
        'employee_id' => $employees->id,
        'month' => $month,
        'year' => $year]));
});

// Home > Settinng KPI & PA
Breadcrumbs::for('setting_kpi_pa', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.setting_kpi_pa'), route('kpi.pa.options.index'));
});

// Home > Settinng KPI & PA > KPI Detail
Breadcrumbs::for('option_kpi_detail', function (BreadcrumbTrail $trail, $kpi_id) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.setting_kpi_pa'), route('kpi.pa.options.index'));
    $trail->push(__('breadcrumb.kpi_detail'), route('indicator.edit', ['id' => $kpi_id]));
});

// Home > Settinng KPI & PA > PA Detail
Breadcrumbs::for('option_pa_detail', function (BreadcrumbTrail $trail, $appraisal_id) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.setting_kpi_pa'), route('kpi.pa.options.index'));
    $trail->push(__('breadcrumb.pa_detail]'), route('appraisal.edit', ['id' => $appraisal_id]));
});

// Home > Option
Breadcrumbs::for('option', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.option'), route('options.list'));
});

// Home > Work Day
Breadcrumbs::for('work_day', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.work_day'), route('workDay.index'));
});

// Home > Work Day > Detail
Breadcrumbs::for('work_day_detail', function (BreadcrumbTrail $trail, $name) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.work_day'), route('workDay.index'));
    $trail->push(__('breadcrumb.work_day_detail'), route('workDay.edit', $name));
});

// Home > Role
Breadcrumbs::for('role', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.role'), route('role.index'));
});

// Home > Role Detail
Breadcrumbs::for('role_detail', function (BreadcrumbTrail $trail, $role) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.role'), route('role.index'));
    $trail->push(__('general.label.detail'), route('role.detail', $role));
});

// Home > user
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumb.home'), route('home'));
    $trail->push(__('breadcrumb.user'), route('user.index'));
});