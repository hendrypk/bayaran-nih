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

    // use HasFactory;
    // use Notifiable;
    // use SoftDeletes, InteractsWithMedia;

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


    // public function getProfilePhotoThumbAttribute(): string
    // {
    //     $thumb = $this->getFirstMediaUrl('profile_photos', 'thumb');
    //     return $thumb ?: asset('assets/images/placeholder/profile.jpg');
    // }

    // public function getProfilePhotoUrlAttribute(): string
    // {
    //     return $this->getFirstMediaUrl('profile_photos') ?: asset('assets/images/placeholder/profile.jpg');
    // }

    public function getProfilePhotoAttribute(): string
{
    return $this->getFirstMediaUrl('profile_photos') ?: asset('default-profile.jpg');
}



    // public function registerMediaCollections(): void
    // {
    //     $this->addMediaCollection('profile_photos')
    //         ->useDisk('public')
    //         ->singleFile()
    //         ->registerMediaConversions(function (Media $media) {
    //             $this->addMediaConversion('thumb')
    //                 ->fit(Manipulations::FIT_CROP, 100, 100)
    //                 ->optimize()
    //                 ->performOnCollections('profile_photos');
    //         });
    // }

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
        return $this->belongsToMany(WorkScheduleGroup::class, 'employee_work_schedules', 'employee_id', 'work_schedule_group_id');
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

    public function pas()
    {
        return $this->belongsTo(AppraisalName::class, 'pa_id');
    }

    public function performanceKpis()
    {
        return $this->belongsTo(PerformanceKpi::class, 'kpi_id');
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
            'genders' => self::GENDERS,
            'bloods' => self::BLOODS,
            'marriages' => self::MARRIAGES,
            'religions' => self::RELIGIONS,
            'educations' => self::EDUCATIONS,
            'banks' => self::BANKS,
        ];
    }


}
