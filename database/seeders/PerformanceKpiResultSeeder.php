<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\PerformanceKpiName;
use App\Models\PerformanceKpiResult;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PerformanceKpiResultSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Ambil Admin sebagai penanggung jawab input
        $admin = User::first() ?? User::factory()->create(['name' => 'Admin System']);

        // 2. Buat Template Master KPI (Misal berdasarkan departemen)
        $kpiTemplates = [];
        $categories = [
            'Digital Marketing' => ['Lead Generation', 'Conversion Rate', 'Ads Efficiency'],
            'Web Development'   => ['Sprints Completed', 'Bug Rate', 'Uptime Server'],
            'Sales'             => ['Revenue Target', 'Client Retention', 'New Leads'],
        ];

        foreach ($categories as $catName => $indicators) {
            $template = PerformanceKpiName::create(['name' => $catName]);
            
            foreach ($indicators as $indicator) {
                $template->indicators()->create([
                    'aspect' => $indicator,
                    'weight'         => 100 / count($indicators), // Bagi rata bobotnya
                    'target'         => $faker->numberBetween(80, 100),
                ]);
            }
            $kpiTemplates[] = $template;
        }

        // 3. Ambil Employee yang sudah ada atau buat baru
        // Kita asumsikan menggunakan data dari loop untuk simulasi 20 orang
        for ($i = 0; $i < 20; $i++) {
            $selectedTemplate = collect($kpiTemplates)->random();
            
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

            // 4. Buat Hasil KPI untuk Januari, Februari, dan Maret 2026
            foreach ([1, 2, 3] as $month) {
                $totalScore = 0;
                
                // Buat Parent Result terlebih dahulu
                $kpiResult = PerformanceKpiResult::create([
                    'employee_id'  => $employee->id,
                    'kpi_id'  => $selectedTemplate->id,
                    'month'        => $month,
                    'year'         => 2026,
                    'grade'  => 0, // Akan diupdate setelah detail dibuat
                    'user_created' => $admin->id,
                ]);

                // 5. Buat Detail KPI (Realisasi per Indikator)
                foreach ($selectedTemplate->indicators as $indicator) {
                    $realization = $faker->numberBetween(60, 110); // Bisa over-target
                    
                    // Hitung skor per indikator: (Realisasi / Target) * Bobot
                    $score = ($realization / $indicator->target) * $indicator->weight;
                    $totalScore += $score;

                    $kpiResult->details()->create([
                        'kpi_results_id' => $indicator->indicator_name,
                        'weight'         => $indicator->weight,
                        'target'         => $indicator->target,
                        'achievement'    => $realization,
                        'result'          => min($score, $indicator->weight * 1.2), // Cap score di 120% bobot
                    ]);
                }

                // Update total skor akhir di parent
                $kpiResult->update(['grade' => $totalScore]);
            }
        }

        $this->command->info('KPI Results untuk 20 karyawan berhasil di-generate!');
    }
}