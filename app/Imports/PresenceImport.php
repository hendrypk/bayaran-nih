<?php
namespace App\Imports;

use Carbon\Carbon;
use App\Models\WorkDay;
use App\Models\Employee;
use App\Models\Presence;
use App\Models\WorkSchedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class PresenceImport implements ToCollection
{
    private $errors = []; // Menyimpan error

    // Proses setiap baris data
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue; // Skip header row
            }

            try {
                // Ambil data dari baris Excel
                $eid = $row[0] ?? null;
                $date = $row[1] ?? null;
                $check_in = $row[2] ?? null;
                $check_out = $row[3] ?? null;
                $late_arrival = $row[4] ?? null;
                $late_check_in = $row[5] ?? null;
                $check_out_early = $row[6] ?? null;

                $note_in = 'dicatat dari import presensi';
                $note_out = 'dicatat dari import presensi';

            // Validasi jika eid, date, check_in, dan check_out tidak boleh kosong
            if (empty($eid)) {
                $this->errors[] = "Baris {$index}: Employee ID tidak boleh kosong.";
                continue;
            }

            if (empty($date)) {
                $this->errors[] = "Baris {$index}: Tanggal tidak boleh kosong.";
                continue;
            }

            if (empty($check_in)) {
                $this->errors[] = "Baris {$index}: Waktu check-in tidak boleh kosong.";
                continue;
            }

            if (empty($check_out)) {
                $this->errors[] = "Baris {$index}: Waktu check-out tidak boleh kosong.";
                continue;
            }

            // Validasi Employee ID
            $employee = Employee::where('eid', $eid)->first();
            if (!$employee) {
                $this->errors[] = "Baris {$index}: Employee ID {$eid} tidak ditemukan.";
                continue;
            }


                // Validasi Employee ID
                $employee = Employee::where('eid', $eid)->first();
                if (!$employee) {
                    $this->errors[] = "Baris {$index}: Employee ID {$eid} tidak ditemukan.";
                    continue;
                }

                // Validasi dan konversi tanggal
                try {
                    if (!empty($date)) {
                        $date = $this->convertExcelDate($date);
                    } else {
                        throw new \Exception("Format tanggal tidak valid.");
                    }
                } catch (\Exception $e) {
                    $this->errors[] = "Baris {$index}: Format tanggal tidak valid ({$date}).";
                    continue;
                }

                // Validasi dan konversi waktu check-in
                if (!empty($check_in) && is_numeric($check_in)) {
                    $check_in = $this->convertExcelTime($check_in);
                } else {
                    $this->errors[] = "Baris {$index}: Format check-in tidak valid.";
                    continue;
                }

                // Validasi dan konversi waktu check-out
                if (!empty($check_out) && is_numeric($check_out)) {
                    $check_out = $this->convertExcelTime($check_out);
                } else {
                    $this->errors[] = "Baris {$index}: Format check-out tidak valid.";
                    continue;
                }

                // Simpan data ke database
                Presence::create([
                    'employee_id' => $employee->id,
                    'date' => $date,
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'note_in' => $note_in,
                    'note_out' => $note_out,
                    'late_arrival' => $late_arrival,
                    'late_check_in' => $late_check_in,
                    'check_out_early' => $check_out_early,
                ]);
            } catch (\Exception $e) {
                $this->errors[] = "Baris {$index}: Terjadi kesalahan - " . $e->getMessage();
            }
        }
    }

    // Fungsi untuk mendapatkan error
    public function getErrors()
    {
        return $this->errors;
    }

    // Helper untuk konversi waktu Excel
    // private function convertExcelTime($excelTime)
    // {
    //     $secondsInADay = 86400; // Jumlah detik dalam sehari
    //     $seconds = $excelTime * $secondsInADay;
    //     return gmdate('H:i:s', $seconds);
    // }

    private function convertExcelTime($excelTime) {
        try {
            if (is_numeric($excelTime)) {
                // Convert Excel time fraction to H:i:s format
                $secondsInDay = 86400; // 24*60*60
                $seconds = $excelTime * $secondsInDay;
                return gmdate('H:i:s', $seconds);
            }
            return Carbon::parse($excelTime)->format('H:i:s');
        } catch (\Exception $e) {
            \Log::error('Invalid time format:', ['time' => $excelTime, 'error' => $e->getMessage()]);
            return null;
        }
    }

    // Helper untuk konversi tanggal Excel
    private function convertExcelDate($excelDate)
    {
        try {
            // Cek jika formatnya adalah Excel serial date (numeric)
            if (is_numeric($excelDate)) {
                // Mengonversi tanggal serial Excel ke format Y-m-d
                return Carbon::createFromFormat('Y-m-d', '1970-01-01')
                             ->addDays($excelDate - 25569)
                             ->format('Y-m-d');
            } 
            // Cek jika tanggal sudah dalam format string yang dapat diparse
            elseif (strtotime($excelDate)) {
                // Parse tanggal dengan Carbon dan ubah ke format Y-m-d
                return Carbon::parse($excelDate)->format('Y-m-d');
            } 
            else {
                // Jika tanggal tidak valid
                throw new \Exception('Invalid date value.');
            }
        } catch (\Exception $e) {
            // Log error jika format tidak valid
            Log::error('Invalid date format:', ['date' => $excelDate, 'error' => $e->getMessage()]);
            return null;
        }
    }
    
    

    // private $errors = []; // Menyimpan error

    // // Proses setiap baris data
    // public function collection(Collection $rows)
    // {
    //     DB::beginTransaction(); // Mulai transaksi
    
    //     // Menyimpan flag untuk menandakan apakah ada error di semua baris
    //     $hasError = false;
    
    //     foreach ($rows as $index => $row) {
    //         if ($index === 0) {
    //             continue; // Skip header row
    //         }
    
    //         try {
    //             // Ambil data dari baris Excel
    //             $eid = $row[0] ?? null;
    //             $date = $row[1] ?? null;
    //             $check_in = $row[2] ?? null;
    //             $check_out = $row[3] ?? null;
    //             $late_arrival = $row[4] ?? null;
    //             $late_check_in = $row[5] ?? null;
    //             $check_out_early = $row[6] ?? null;
    
    //             $note_in = 'dicatat dari import presensi';
    //             $note_out = 'dicatat dari import presensi';
    
    //             // Validasi Employee ID
    //             $employee = Employee::where('eid', $eid)->first();
    //             if (!$employee) {
    //                 $this->errors[] = "Baris {$index}: Employee ID {$eid} tidak ditemukan.";
    //                 $hasError = true; // Tandai ada error
    //             }
    
    //             // Validasi dan konversi tanggal
    //             if (!empty($date)) {
    //                 try {
    //                     $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    //                 } catch (\Exception $e) {
    //                     $this->errors[] = "Baris {$index}: Format tanggal tidak valid ({$date}).";
    //                     $hasError = true; // Tandai ada error
    //                 }
    //             } else {
    //                 $this->errors[] = "Baris {$index}: Format tanggal tidak valid.";
    //                 $hasError = true; // Tandai ada error
    //             }
    
    //             // Validasi dan konversi waktu check-in
    //             if (!empty($check_in) && is_numeric($check_in)) {
    //                 $check_in = $this->convertExcelTime($check_in);
    //             } else {
    //                 $this->errors[] = "Baris {$index}: Format check-in tidak valid.";
    //                 $hasError = true; // Tandai ada error
    //             }
    
    //             // Validasi dan konversi waktu check-out
    //             if (!empty($check_out) && is_numeric($check_out)) {
    //                 $check_out = $this->convertExcelTime($check_out);
    //             } else {
    //                 $this->errors[] = "Baris {$index}: Format check-out tidak valid.";
    //                 $hasError = true; // Tandai ada error
    //             }
    
    //             // Jika ada error, jangan simpan data dan hentikan
    //             if ($hasError) {
    //                 throw new \Exception("Terjadi kesalahan pada baris {$index}. Semua data tidak akan disimpan.");
    //             }
    
    //             // Simpan data ke database jika tidak ada error
    //             Presence::create([
    //                 'employee_id' => $employee->id,
    //                 'date' => $date,
    //                 'check_in' => $check_in,
    //                 'check_out' => $check_out,
    //                 'note_in' => $note_in,
    //                 'note_out' => $note_out,
    //                 'late_arrival' => $late_arrival,
    //                 'late_check_in' => $late_check_in,
    //                 'check_out_early' => $check_out_early,
    //             ]);
    
    //         } catch (\Exception $e) {
    //             // Rollback jika ada error dan simpan pesan kesalahan
    //             DB::rollBack();
    //             $this->errors[] = "Baris {$index}: " . $e->getMessage();
    //             break; // Hentikan pengolahan baris jika ada error
    //         }
    //     }
    
    //     // Jika tidak ada error, commit perubahan ke database
    //     if (!$hasError) {
    //         DB::commit(); // Commit perubahan jika tidak ada error pada semua baris
    //     }
    // }
    
    // // Fungsi untuk mendapatkan error
    // public function getErrors()
    // {
    //     return $this->errors;
    // }
    
    // // Helper untuk konversi waktu Excel
    // private function convertExcelTime($excelTime)
    // {
    //     $secondsInADay = 86400; // Jumlah detik dalam sehari
    //     $seconds = $excelTime * $secondsInADay;
    //     return gmdate('H:i:s', $seconds);
    // }
    
    


}
