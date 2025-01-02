<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Home > Employee List
Breadcrumbs::for('employee_list', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Employee List', route('employee.list'));
});

// Home > Employee List > Employee Detail
Breadcrumbs::for('employee_detail', function (BreadcrumbTrail $trail, $employee) {
    $trail->parent('home');
    $trail->push('Employee', route('employee.list'));
    $trail->push('Employee Detail: ' . $employee->name , route('employee.list'));
});

// Home > Employee Resignation
Breadcrumbs::for('employee_resignation', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Resignation', route('resignation.index'));
});

// Home > Employee Position Change
Breadcrumbs::for('employee_position_change', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Employee Position Change', route('position.change.index'));
});

// Home > Presence Summary
Breadcrumbs::for('presence_summary', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Presence Summary', route('presenceSummary.list'));
});

// Home > Presence
Breadcrumbs::for('presence', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Presence', route('presence.list.admin'));
});

// Home > Overtime
Breadcrumbs::for('overtime', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Overtime', route('overtime.list'));
});

// Home > Leave
Breadcrumbs::for('leave', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Leave', route('leaves.index'));
});

// Home > Employee Grade
Breadcrumbs::for('employee_grade', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Employee Grade', route('performance.grade'));
});

// Home > KPI
Breadcrumbs::for('kpi', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('KPI', route('kpi.list'));
});

// Home > KPI > Create KPI Report
Breadcrumbs::for('create_kpi', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('KPI', route('kpi.list'));
    $trail->push('Create KPI', route('kpi.add'));
});

// Home > KPI > KPI Detail
Breadcrumbs::for('kpi_detail', function (BreadcrumbTrail $trail, $gradeKpi) {
    $trail->push('Home', route('home'));
    $trail->push('KPI', route('kpi.list'));
    $trail->push('KPI Detail', route('kpi.detail', [
        'employee_id' => $gradeKpi->employee_id,
        'month' => $gradeKpi->month,
        'year' => $gradeKpi->year]));
});

// Home > KPI > Edit KPI Report
Breadcrumbs::for('edit_kpi', function (BreadcrumbTrail $trail, $gradeKpi) {
    $trail->push('Home', route('home'));
    $trail->push('KPI', route('kpi.list'));
    $trail->push('Edit KPI', route('kpi.edit', [
        'employee_id' => $gradeKpi->employee_id,
        'month' => $gradeKpi->month,
        'year' => $gradeKpi->year]));
});

// Home > Appraisal
Breadcrumbs::for('pa', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Performance Appraisal', route('pa.list'));
});

// Home > Appraisal > Detail
Breadcrumbs::for('pa_detail', function (BreadcrumbTrail $trail, $employees, $month, $year) {
    $trail->push('Home', route('home'));
    $trail->push('Performance Appraisal', route('pa.list'));
    $trail->push('PA Detail', route('pa.detail', [
        'employee_id' => $employees->id,
        'month' => $month,
        'year' => $year]));
});