<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Position;
use App\Models\PerformanceAppraisalName;
use App\Models\PerformanceAppraisalResult;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PerformanceAppraisalResultSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Ambil atau buat Admin sebagai creator
        $admin = User::first() ?? User::factory()->create(['name' => 'Admin System']);

        // 2. Buat Template PA/KPI
        $templates = [];
        $templateNames = ['Standar Operasional', 'Key Performance IT', 'Sales Target'];
        
        foreach ($templateNames as $name) {
            $template = PerformanceAppraisalName::create(['name' => $name]);
            // Buat aspek penilaian
            for ($i = 1; $i <= 3; $i++) {
                $template->appraisals()->create([
                    'aspect' => "Aspek Penilaian $i",
                    'description' => $faker->sentence(5),
                ]);
            }
            $templates[] = $template;
        }

        // 3. Buat 20 Employee Random sesuai struktur tabel kamu
        for ($i = 0; $i < 20; $i++) {
            $selectedTemplate = collect($templates)->random();
            
            $employee = Employee::create([
                'eid'           => $faker->unique()->numberBetween(100000, 999999),
                'name'          => $faker->name,
                'email'         => $faker->unique()->safeEmail,
                'username'      => $faker->unique()->userName,
                'password'      => Hash::make('password'),
                'city'          => $faker->city,
                'domicile'      => $faker->address,
                'place_birth'   => $faker->city,
                'date_birth'    => $faker->date('Y-m-d', '2000-01-01'),
                'blood_type'    => $faker->randomElement(['A', 'B', 'AB', 'O']),
                'gender'        => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'religion'      => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Budha', 'Hindu']),
                'marriage'      => $faker->randomElement(['Lajang', 'Menikah']),
                'education'     => $faker->randomElement(['SMA', 'D3', 'S1', 'S2']),
                'whatsapp'      => $faker->phoneNumber,
                'joining_date'  => $faker->date('Y-m-d', '2023-01-01'),
                'employee_status' => 'Permanen',
                'position_id'   => 1, // Pastikan ID ini ada di tabel positions
                'division_id'   => 1, // Pastikan ID ini ada di tabel divisions
                'department_id' => 1, // Pastikan ID ini ada di tabel departments
                'pa_id'         => $selectedTemplate->id,
                'role'          => 'user',
                'resignation'   => null,
                'bank'   => 'BNCA',
                'bank_number'   => '2324232',
                'annual_leave'  => 12,
                'sales_status'  => true,
            ]);

            // 4. Buat Hasil Appraisal (Result) untuk setiap employee
            // Kita buat data untuk bulan 2 (Februari) dan 3 (Maret) agar bisa di-filter
            foreach ([2, 3] as $month) {
                $grade = $faker->randomFloat(2, 75, 100);

                $result = PerformanceAppraisalResult::create([
                    'employee_id'  => $employee->id,
                    'pa_id'        => $employee->pa_id,
                    'month'        => $month,
                    'year'         => 2026,
                    'grade'        => $grade,
                    'user_created' => $admin->id,
                    'created_at'   => now(),
                ]);

                // 5. Buat Detail dari Aspek Template
                foreach ($selectedTemplate->appraisals as $appraisal) {
                    $result->details()->create([
                        'aspect'      => $appraisal->aspect,
                        'description' => $appraisal->description,
                        'achievement' => $faker->randomFloat(2, 70, 100),
                    ]);
                }
            }
        }

        $this->command->info('20 Employee & Appraisal Results berhasil dibuat!');
    }
}