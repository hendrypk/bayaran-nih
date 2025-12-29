<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\OfficeLocation;
use App\Models\PerformanceKpiName;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat 10 karyawan dummy
        $employees = Employee::factory()->count(10)->create();

        // Ambil ID dari tabel relasi
        $officeIds = OfficeLocation::pluck('id');
        $kpiIds = PerformanceKpiName::pluck('id');

        foreach ($employees as $employee) {
            // 2. Pasangkan ke Office Location (Many to Many)
            if ($officeIds->isNotEmpty()) {
                // Ambil nilai terkecil antara angka random (1-2) dengan jumlah data yang ada
                $takeOffice = min($officeIds->count(), rand(1, 2));
                $employee->officeLocations()->attach(
                    $officeIds->random($takeOffice)
                );
            }

            // 3. Pasangkan ke KPI (Many to Many)
            if ($kpiIds->isNotEmpty()) {
                // Ambil nilai terkecil antara angka random (1-3) dengan jumlah data yang ada
                $takeKpi = min($kpiIds->count(), rand(1, 3));
                $employee->kpis()->attach(
                    $kpiIds->random($takeKpi)
                );
            }

            // 4. Buat data Presensi dummy
            for ($i = 0; $i < 5; $i++) {
                $employee->presences()->create([
                    'date' => now()->subDays($i)->format('Y-m-d'),
                    'check_in' => '08:00:00',
                    'check_out' => '17:00:00',
                    'status' => 'presence',
                ]);
            }
        }
    }
}