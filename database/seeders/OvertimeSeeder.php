<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OvertimeSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        // Ambil ID karyawan secara acak (asumsi tabel employees sudah ada isinya)
        $employeeIds = DB::table('employees')->pluck('id')->toArray();

        if (empty($employeeIds)) {
            $this->command->warn('Tabel employees kosong! Masukkan data employee terlebih dahulu.');
            return;
        }

        $overtimes = [
            [
                'employee_id' => $employeeIds[0],
                'date' => $now->format('Y-m-d'),
                'start_at' => '17:00:00',
                'end_at' => '20:00:00',
                'total' => 180, // dalam menit (3 jam)
                'status' => 1, // Approved
                'note_in' => 'Lembur selesaikan modul payroll',
                'note_out' => 'Selesai tepat waktu',
                'location_in' => '-6.2088,106.8456',
                'location_out' => '-6.2088,106.8456',
                'photo_in' => 'overtime_in_1.jpg',
                'photo_out' => 'overtime_out_1.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'employee_id' => $employeeIds[1] ?? $employeeIds[0],
                'date' => $now->subDay()->format('Y-m-d'),
                'start_at' => '18:30:00',
                'end_at' => '21:00:00',
                'total' => 150, // 2.5 jam
                'status' => 1,
                'note_in' => 'Meeting klien luar kota',
                'note_out' => 'Meeting selesai',
                'location_in' => '-6.4025,106.7942',
                'location_out' => '-6.4025,106.7942',
                'photo_in' => 'overtime_in_2.jpg',
                'photo_out' => 'overtime_out_2.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'employee_id' => $employeeIds[2] ?? $employeeIds[0],
                'date' => Carbon::now()->format('Y-m-d'),
                'start_at' => '17:00:00',
                'end_at' => null, // Belum checkout
                'total' => null,
                'status' => 0, // Pending
                'note_in' => 'Maintenance server rutin',
                'note_out' => null,
                'location_in' => '-6.1751,106.8272',
                'location_out' => null,
                'photo_in' => 'overtime_in_3.jpg',
                'photo_out' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('overtimes')->insert($overtimes);
        $this->command->info('Berhasil membuat 3 data dummy Overtime.');
    }
}