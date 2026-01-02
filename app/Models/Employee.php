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
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\EmployeeResetPasswordNotification;


class Employee extends Authenticatable implements HasMedia
// class Employee extends Authenticatable Implements HasMedia
{

    use HasFactory, Notifiable, SoftDeletes, InteractsWithMedia;

    protected $table = 'employees';
    protected $fillable = [
        'eid', 'email', 'username', 'password', 'name', 'city', 'domicile', 'place_birth', 'date_birth',
        'blood_type', 'gender', 'religion', 'marriage', 'education', 'whatsapp', 'bank', 'bank_number',
        'position_id', 'job_title_id', 'division_id', 'department_id', 'joining_date', 'employee_status',
        'sales_status', 'pa_id', 'kpi_id', 'bobot_kpi', 'role', 'resignation', 'resignation_date', 'resignation_note',
        'annual_leave', 'due_annual_leave'];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = ['deleted_at']; 

    public function getProfilePhotoAttribute(): string
    {
        return $this->getFirstMediaUrl('profile_photos') ?: asset('default-profile.jpg');
    }

    //relation table position
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function scopeSameOrg($query, $user)
    {
        return $query->whereHas('position', fn ($q) =>
            $user->division_id && $q->where('division_id', $user->division_id) ||
            $user->department_id && $q->where('department_id', $user->department_id)
        );
    }

    public function workDay()
    {
        return $this->belongsToMany(WorkScheduleGroup::class, 'employee_work_schedules', 'employee_id', 'work_schedule_group_id');
    }

    //relasi ke Payroll
    public function payroll()
    {
        return $this->belongsTo(PayrollOption::class, 'id', 'name');
    }

// app/Models/Employee.php

public function kpis()
{
    // foreignId kpi_id merujuk ke table performance_kpi_names
    return $this->belongsToMany(PerformanceKpiName::class, 'employee_kpis', 'employee_id', 'kpi_id')
                ->withTimestamps();
}

public function pas()
{
    // foreignId pa_id merujuk ke table performance_appraisal_name
    return $this->belongsToMany(PerformanceAppraisalName::class, 'employee_pas', 'employee_id', 'pa_id')
                ->withTimestamps();
}

    public function overtimes(){
        return $this->hasMany(Overtime::class, 'employee_id');
    }

    public function sales(){
        return $this->hasMany(Sales::class, 'id', 'employee_id');
    }

    public function presences(){
        return $this->hasMany(Presence::class, 'employee_id', 'id')->with('media');
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
      
    protected const GENDERS = ['Male', 'Female'];

    protected const BLOODS = ['A', 'B', 'AB', 'O'];

    protected const MARRIAGES = ['single', 'married', 'widowed'];

    protected const RELIGIONS = ['buddha', 'catholic', 'christian', 'hindu', 'islam', 'konghuchu'];

    protected const EDUCATIONS = [
        'elementary_school',
        'junior_school',
        'high_school',
        'diploma',
        'bachelor',
        'master',
        'doctorate',
    ];

    protected const BANKS = [
        'Bank Mandiri',
        'Bank BNI',
        'Bank BRI',
        'Bank BCA',
        'Bank BTN',
        'Bank Syariah Indonesia',
        'Bank Danamon',
        'CIMB Niaga',
        'Bank Permata',
        'Bank Mega'
    ];

public static function options(): array
{
    return [
        'genders' => array_combine(self::GENDERS, self::GENDERS),
        'bloods' => array_combine(self::BLOODS, self::BLOODS),
        'marriages' => array_combine(self::MARRIAGES, self::MARRIAGES),
        'religions' => array_combine(self::RELIGIONS, self::RELIGIONS),
        'educations' => array_combine(self::EDUCATIONS, self::EDUCATIONS),
        'banks' => array_combine(self::BANKS, self::BANKS),
    ];
}

    public function positionChange()
    {
        return $this->hasMany(EmployeePositionChange::class, 'employee_id','id');
    }
    
    public function kpiResults()
    {
        return $this->hasMany(PerformanceKpiResult::class, 'employee_id');
    }

    public function paResults()
    {
        return $this->hasMany(PerformanceAppraisalResult::class, 'employee_id');
    }


}


