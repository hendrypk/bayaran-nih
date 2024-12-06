<?php

namespace App\Models;

use App\Models\Sales;
use App\Models\WorkDay;
use App\Models\GradeKpi;
use App\Models\Overtime;
use App\Models\Position;
use App\Models\Department;
use App\Models\KpiOptions;
use App\Models\WorkCalendar;
use App\Models\WorkSchedule;
use App\Models\PayrollOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\EmployeeResetPasswordNotification;

class Employee extends Authenticatable 
{
    use HasFactory;
    use Notifiable;

    protected $table = 'employees';
    protected $fillable = [
        'eid', 'email', 'username', 'password', 'name', 'city', 'domicile', 'place_birth', 'date_birth',
        'blood_type', 'gender', 'religion', 'marriage', 'education', 'whatsapp', 'bank', 'bank_number',
        'position_id', 'job_title_id', 'division_id', 'department_id', 'joining_date', 'employee_status',
        'sales_status', 'pa_id', 'kpi_id', 'bobot_kpi', 'role', 'resignation', 'resignation_date'];
    protected $hidden = ['password']; 

    //relation table position
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    //relation table division
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    //relation table department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    //relation table job_title
    public function job_title()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id', 'id');
    }

    public function workDay()
    {
        return $this->belongsToMany(WorkDay::class, 'employee_work_day', 'employee_id', 'work_day_id');
    }      

    // public function positionKpi()
    // {
    //     return $this->belongsTo(KpiOptions::class);
    // }

    //relation table grade_pa
    public function gradePas()
    {
        return $this->hasMany(GradePa::class, 'employee_id');
    }

    //relation table grade_kpi
    public function gradeKpis()
    {
        return $this->hasMany(GradeKpi::class, 'employee_id');
    }

    //relasi ke Payroll
    public function payroll()
    {
        return $this->belongsTo(PayrollOption::class, 'id', 'name');
    }

    public function kpis()
    {
        return $this->belongsTo(KpiAspect::class, 'kpi_id');
    }

    public function performanceKpis()
    {
        return $this->belongsTo(PerformanceKpi::class, 'kpi_id');
    }

    public function overtimes(){
        return $this->belongsTo(Overtime::class, 'employee_id');
    }

    public function sales(){
        return $this->hasMany(Sales::class, 'id', 'employee_id');
    }

    public function presences(){
        return $this->belongsTo(Presence::class,'employee_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmployeeResetPasswordNotification($token));
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
    
    public function officeLocations()
    {
        return $this->belongsToMany(OfficeLocation::class, 'employee_office_location');
    }

    public function employeeStatus()
    {
        return $this->belongsTo(EmployeeStatus::class, 'employee_status');
    }
      
  

}
