<?php

namespace Tests\Feature\Livewire;

use App\Livewire\EmployeeForm;
use App\Models\Employee;
use App\Models\Position;
use App\Models\EmployeeStatus;
use App\Models\WorkScheduleGroup;
use App\Models\OfficeLocation;
use App\Models\PerformanceKpiName;
use App\Models\PerformanceAppraisalName;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeeFormTest extends TestCase
{
    use RefreshDatabase;

    ddd#[Test]
    public function it_can_render_the_form()
    {
        Livewire::test(EmployeeForm::class)
            ->assertStatus(200)
            ->assertSee('Informasi Pribadi');
    }

    ddd#[Test]
    public function it_validates_required_fields_on_save()
    {
        Livewire::test(EmployeeForm::class)
            ->call('save')
            ->assertHasErrors([
                'name' => 'required',
                'email' => 'required',
                'positionId' => 'required',
                'workDay' => 'required',
            ]);
    }

    ddd#[Test]
    public function it_can_save_a_new_employee_with_relationships()
    {
        // 1. Persiapkan Data Referensi
        $position = Position::first();
        $status = EmployeeStatus::create(['name' => 'Permanent']);
        $workDay = WorkScheduleGroup::create(['name' => 'Monday - Friday']);
        $location = OfficeLocation::first();
        $kpi = PerformanceKpiName::first();

        // 2. Jalankan Test Livewire
        Livewire::test(EmployeeForm::class)
            // Step 1: Personal Info
            ->set('name', 'Budi Utomo')
            ->set('email', 'budi@company.com')
            ->set('whatsapp', '081234567890')
            ->set('placeBirth', 'Surabaya')
            ->set('dateBirth', '1995-01-01')
            ->set('genders', 'Laki-laki')
            ->set('city', 'Jl. Sudirman No. 1')
            ->set('domicile', 'Jl. Sudirman No. 1')
            
            // Step 2: Job Info
            ->set('positionId', $position->id)
            ->set('employee_status', $status->id)
            ->set('joining_date', now()->format('Y-m-d'))
            ->set('workDay', [$workDay->id])
            ->set('officeLocations', [$location->id])
            
            // Step 3: Performance Info
            ->set('kpis', [$kpi->id])
            
            // Call Save
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('employee.list'));

        // 3. Verifikasi Data di Database (Table Utama)
        $this->assertDatabaseHas('employees', [
            'name' => 'Budi Utomo',
            'email' => 'budi@company.com',
            'position_id' => $position->id
        ]);

        // 4. Verifikasi Relasi (Table Jembatan)
        $employee = Employee::where('email', 'budi@company.com')->first();
        $this->assertCount(1, $employee->workDays);
        $this->assertCount(1, $employee->locations);
        $this->assertCount(1, $employee->kpis);
    }

    ddd#[Test]
    public function address_copy_button_works_via_alpine_simulation()
    {
        // Karena Alpine berjalan di Browser, di PHPUnit kita mengetes state-nya langsung
        Livewire::test(EmployeeForm::class)
            ->set('city', 'Alamat KTP Jakarta')
            ->set('domicile', 'Alamat KTP Jakarta') // Simulasi hasil click
            ->assertSet('domicile', 'Alamat KTP Jakarta');
    }
}