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
    // private $errors = []; // Menyimpan error

    // public function collection(Collection $rows)
    // {
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
    //             $employee = Employee::find($eid);
    //             if (!$employee) {
    //                 $this->errors[] = "Baris {$index}: Employee ID {$eid} tidak ditemukan.";
    //                 continue;
    //             }

    //             // Validasi dan konversi tanggal
    //             try {
    //                 if (!empty($date)) {
    //                     $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    //                 } else {
    //                     throw new \Exception("Format tanggal tidak valid.");
    //                 }
    //             } catch (\Exception $e) {
    //                 $this->errors[] = "Baris {$index}: Format tanggal tidak valid ({$date}).";
    //                 continue;
    //             }

    //             // Validasi dan konversi waktu check-in
    //             if (!empty($check_in) && is_numeric($check_in)) {
    //                 $check_in = $this->convertExcelTime($check_in);
    //             } else {
    //                 $this->errors[] = "Baris {$index}: Format check-in tidak valid.";
    //                 continue;
    //             }

    //             // Validasi dan konversi waktu check-out
    //             if (!empty($check_out) && is_numeric($check_out)) {
    //                 $check_out = $this->convertExcelTime($check_out);
    //             } else {
    //                 $this->errors[] = "Baris {$index}: Format check-out tidak valid.";
    //                 continue;
    //             }

    //             // Simpan data ke database
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
    //             $this->errors[] = "Baris {$index}: Terjadi kesalahan - " . $e->getMessage();
    //         }
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

    private $errors = []; // Menyimpan error

    // Proses setiap baris data
    public function collection(Collection $rows)
    {
        DB::beginTransaction(); // Mulai transaksi
    
        // Menyimpan flag untuk menandakan apakah ada error di semua baris
        $hasError = false;
    
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
    
                // Validasi Employee ID
                $employee = Employee::where('eid', $eid)->first();
                if (!$employee) {
                    $this->errors[] = "Baris {$index}: Employee ID {$eid} tidak ditemukan.";
                    $hasError = true; // Tandai ada error
                }
    
                // Validasi dan konversi tanggal
                if (!empty($date)) {
                    try {
                        $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $this->errors[] = "Baris {$index}: Format tanggal tidak valid ({$date}).";
                        $hasError = true; // Tandai ada error
                    }
                } else {
                    $this->errors[] = "Baris {$index}: Format tanggal tidak valid.";
                    $hasError = true; // Tandai ada error
                }
    
                // Validasi dan konversi waktu check-in
                if (!empty($check_in) && is_numeric($check_in)) {
                    $check_in = $this->convertExcelTime($check_in);
                } else {
                    $this->errors[] = "Baris {$index}: Format check-in tidak valid.";
                    $hasError = true; // Tandai ada error
                }
    
                // Validasi dan konversi waktu check-out
                if (!empty($check_out) && is_numeric($check_out)) {
                    $check_out = $this->convertExcelTime($check_out);
                } else {
                    $this->errors[] = "Baris {$index}: Format check-out tidak valid.";
                    $hasError = true; // Tandai ada error
                }
    
                // Jika ada error, jangan simpan data dan hentikan
                if ($hasError) {
                    throw new \Exception("Terjadi kesalahan pada baris {$index}. Semua data tidak akan disimpan.");
                }
    
                // Simpan data ke database jika tidak ada error
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
                // Rollback jika ada error dan simpan pesan kesalahan
                DB::rollBack();
                $this->errors[] = "Baris {$index}: " . $e->getMessage();
                break; // Hentikan pengolahan baris jika ada error
            }
        }
    
        // Jika tidak ada error, commit perubahan ke database
        if (!$hasError) {
            DB::commit(); // Commit perubahan jika tidak ada error pada semua baris
        }
    }
    
    // Fungsi untuk mendapatkan error
    public function getErrors()
    {
        return $this->errors;
    }
    
    // Helper untuk konversi waktu Excel
    private function convertExcelTime($excelTime)
    {
        $secondsInADay = 86400; // Jumlah detik dalam sehari
        $seconds = $excelTime * $secondsInADay;
        return gmdate('H:i:s', $seconds);
    }
    
    
    //     public function collection(Collection $rows) {
    //         foreach ($rows as $row) {
    //             Log::info('Processing row:', $row->toArray());
                
    //             $eid = $row[0] ?? null;
    //             $note_in = 'dicatat dari import presensi';
    //             $note_out = 'dicatat dari import presensi';
    //             $late_arrival = $row[4] ?? null;
    //             $late_check_in = $row[5] ?? null;
    //             $check_out_early = $row[6] ?? null;
        
    //             $employee = Employee::find($eid);
    //             if (!$employee) {
    //                 $errors[] = "Employee ID {$eid} not found for row: " . json_encode($row);
    //                 continue; 
    //             }

    //             try {
    //                 if (isset($row[1]) && is_numeric($row[1])) {
    //                     $date = $this->convertExcelDate($row[1]);
    //                 } else {
    //                     throw new \Exception("Invalid date format at row: " . json_encode($row));
    //                 }
    //             } catch (\Exception $e) {
    //                 $errors[] = "Invalid date format for row: " . json_encode($row);
    //                 continue;
    //             }
        
    //             try {
    //                 if (isset($row[2]) && is_numeric($row[2])) {
    //                     $check_in = $this->convertExcelTime($row[2]);
    //                 } else {
    //                     throw new \Exception("Invalid check-in format at row: " . json_encode($row));
    //                 }
    //             } catch (\Exception $e) {
    //                 $errors[] = "Invalid check-in format for row: " . json_encode($row);
    //                 continue;
    //             }

    //             try {
    //                 if (isset($row[3]) && is_numeric($row[3])) {
    //                     $check_out = $this->convertExcelTime($row[3]); 
    //                 } else {
    //                     throw new \Exception("Invalid check-out format at row: " . json_encode($row));
    //                 }
    //             } catch (\Exception $e) {
    //                 $errors[] = "Invalid check-out format for row: " . json_encode($row);
    //                 continue;
    //             }

    //             if (empty($errors)) {
    //                 try {
    //                     Log::info("Attempting to create presence", [
    //                         'employee_id' => $employee->id,
    //                         'date' => $date,
    //                         'check_in' => $check_in,
    //                         'check_out' => $check_out,
    //                         'late_arrival' => $late_arrival,
    //                         'late_check_in' => $late_check_in,
    //                         'check_out_early' => $check_out_early
    //                     ]);
                        
    //                     $presence = Presence::create([
    //                         'employee_id' => $employee->id,
    //                         'date' => $date,
    //                         'check_in' => $check_in,
    //                         'check_out' => $check_out,
    //                         'note_in' => $note_in,
    //                         'note_out' => $note_out,
    //                         'late_arrival' => $late_arrival,
    //                         'late_check_in' => $late_check_in,
    //                         'check_out_early' => $check_out_early
    //                     ]);
                    
    //                     Log::info('Presence created successfully', ['presence_id' => $presence->id]);
    //                 } catch (\Exception $e) {
    //                     Log::error('Failed to save presence:', [
    //                         'error' => $e->getMessage(),
    //                         'row' => $row->toArray()
    //                     ]);
    //                     $errors[] = "Error saving presence for row: " . json_encode($row);
    //                 }                
    //             }
    //         }
    //     }

    // private function convertExcelDate($excelDate) {
    //     try {
    //         if (is_numeric($excelDate)) {
    //             // Convert Excel serial date to Y-m-d format
    //             return Carbon::createFromFormat('Y-m-d', '1970-01-01')->addDays($excelDate - 25569)->format('Y-m-d');
    //         }
    //         return Carbon::parse($excelDate)->format('Y-m-d');
    //     } catch (\Exception $e) {
    //         \Log::error('Invalid date format:', ['date' => $excelDate, 'error' => $e->getMessage()]);
    //         return null;
    //     }
    // }

    // private function convertExcelTime($excelTime) {
    //     try {
    //         if (is_numeric($excelTime)) {
    //             // Convert Excel time fraction to H:i:s format
    //             $secondsInDay = 86400; // 24*60*60
    //             $seconds = $excelTime * $secondsInDay;
    //             return gmdate('H:i:s', $seconds);
    //         }
    //         return Carbon::parse($excelTime)->format('H:i:s');
    //     } catch (\Exception $e) {
    //         \Log::error('Invalid time format:', ['time' => $excelTime, 'error' => $e->getMessage()]);
    //         return null;
    //     }
    // }

    ///////////////////
    
    // public function collection(Collection $rows) {
    //     foreach ($rows as $row) {
    //         Log::info('Processing row:', $row->toArray());

    //         try {
    //             // Retrieve eid and employee name
    //             $eid = $row[0] ?? null; 
    //             $employeeName = $row[1] ?? null;

    //             // Convert Excel date and times
    //             $date = isset($row[2]) ? $this->convertExcelDate($row[2]) : null;
    //             $checkIn = isset($row[3]) ? $this->convertExcelTime($row[3]) : null;
    //             $checkOut = isset($row[4]) ? $this->convertExcelTime($row[4]) : null;

    //             if (!$eid || !$date) {
    //                 \Log::error('EID or Date is missing or invalid:', $row->toArray());
    //                 continue; // Skip the row if eid or date is missing
    //             }

    //             // Fetch the employee's schedule
    //             $schedule = WorkSchedule::where('eid', $eid)->where('date', $date)->first();
                
    //             // Initialize late check-in, early check-out, and late arrival flag
    //             $lateCheckInMinutes = 0;
    //             $earlyCheckOutMinutes = 0;
    //             $lateArrival = false;

    //             if ($schedule) {
    //                 // Calculate late check-in minutes
    //                 if ($checkIn && $checkIn > $schedule->check_in) {
    //                     $lateCheckInMinutes = Carbon::parse($checkIn)->diffInMinutes(Carbon::parse($schedule->check_in));
    //                     $lateArrival = true; // Set late arrival flag
    //                 }

    //                 // Calculate early check-out minutes
    //                 if ($checkOut && $checkOut < $schedule->check_out) {
    //                     $earlyCheckOutMinutes = Carbon::parse($checkOut)->diffInMinutes(Carbon::parse($schedule->check_out));
    //                 }
    //             }

    //             // Update or create presence record
    //             Presence::updateOrCreate(
    //                 ['eid' => $eid, 'date' => $date],
    //                 [
    //                     'employee_name' => $employeeName,
    //                     'check_in' => $checkIn,
    //                     'check_out' => $checkOut,
    //                     'late_check_in_minutes' => $lateCheckInMinutes,
    //                     'early_check_out_minutes' => $earlyCheckOutMinutes,
    //                     'late_arrival' => $lateArrival ? 1 : 0, // Set 1 for true
    //                 ]
    //             );

    //         } catch (\Exception $e) {
    //             \Log::error('Failed to save row:', ['error' => $e->getMessage(), 'row' => $row->toArray()]);
    //         }
    //     }
    // }

    // public function collection(Collection $rows) {
    //     foreach ($rows as $row) {
    //         Log::info('Processing row:', $row->toArray());
            
    //         // Ambil eid dan work_day
    //         $eid = $row[0] ?? null; 
    //         $employee_name = $row[1] ?? null;
    //         $work_day = $row[2] ?? null;
    
    //         // Validasi eid
    //         $employee = Employee::find($eid);
    //         if (!$employee) {
    //             $errors[] = "Employee ID {$eid} not found for row: " . json_encode($row);
    //             continue; // Skip row jika employee tidak ditemukan
    //         }
    
    //         // Validasi work_day
    //         $workDay = WorkDay::find($work_day);
    //         if (!$workDay) {
    //             $errors[] = "Work Day ID {$work_day} not found for row: " . json_encode($row);
    //             continue; // Skip row jika work_day tidak ditemukan
    //         }
    
    //         // Validasi dan konversi date
    //         try {
    //             if (isset($row[3]) && is_numeric($row[3])) {
    //                 $date = $this->convertExcelDate($row[3]); // Konversi hanya jika valid
    //             } else {
    //                 throw new \Exception("Invalid date format at row: " . json_encode($row));
    //             }
    //         } catch (\Exception $e) {
    //             $errors[] = "Invalid date format for row: " . json_encode($row);
    //             continue;
    //         }
    
    //         // Validasi dan konversi check-in
    //         try {
    //             if (isset($row[4]) && is_numeric($row[4])) {
    //                 $check_in = $this->convertExcelTime($row[4]); // Konversi check_in
    //             } else {
    //                 throw new \Exception("Invalid check-in format at row: " . json_encode($row));
    //             }
    //         } catch (\Exception $e) {
    //             $errors[] = "Invalid check-in format for row: " . json_encode($row);
    //             continue;
    //         }
    
    //         // Validasi dan konversi check-out
    //         try {
    //             if (isset($row[5]) && is_numeric($row[5])) {
    //                 $check_out = $this->convertExcelTime($row[5]); // Konversi check_out
    //             } else {
    //                 throw new \Exception("Invalid check-out format at row: " . json_encode($row));
    //             }
    //         } catch (\Exception $e) {
    //             $errors[] = "Invalid check-out format for row: " . json_encode($row);
    //             continue;
    //         }
    
    //         // Lanjutkan proses penyimpanan jika tidak ada error untuk row ini
    //         // Lakukan validasi tambahan jika diperlukan
    //         if (empty($errors)) {
    //             // Proses penyimpanan ke database
    //             try {
    //                 $presence = Presence::create([
    //                     'employee_id' => $employee->id,
    //                     'work_day_id' => $workDay->id,
    //                     'date' => $date,
    //                     'check_in' => $check_in,
    //                     'check_out' => $check_out,
    //                     // Tambahkan field lain yang diperlukan
    //                 ]);
    
    //                 Log::info('Inserting presence:', [
    //                     'employee_id' => $employee->id,
    //                     'work_day_id' => $workDay->id,
    //                     'date' => $date,
    //                     'check_in' => $check_in,
    //                     'check_out' => $check_out,
    //                 ]);
    //             } catch (\Exception $e) {
    //                 Log::error('Failed to save presence:', ['error' => $e->getMessage(), 'row' => $row->toArray()]);
    //                 $errors[] = "Error saving presence for row: " . json_encode($row);
    //             }
    //         }
    //     }
    
    //     // Jika ada error, tambahkan logika untuk mengelola error lebih lanjut di sini
    // }

    
    

    // public function collection(Collection $rows) {
    //     foreach ($rows as $row) {
    //         Log::info('Processing row:', $row->toArray());

    //         try {
    //             // Retrieve eid and employee name
    //             $eid = $row[0] ?? null; 
    //             $employee_name = $row[1] ?? null;
    //             $work_day = $row[2] ?? null;

    //             // Validasi dan konversi date
    //             try {
    //                 if (isset($row[3]) && is_numeric($row[3])) {
    //                     $date = $this->convertExcelDate($row[3]); // Konversi hanya jika valid
    //                 } else {
    //                     throw new \Exception("Invalid date format at row: " . json_encode($row));
    //                 }
    //             } catch (\Exception $e) {
    //                 $errors[] = "Invalid date format for row: " . json_encode($row);
    //                 continue;
    //             }
                
    //             // Validasi dan konversi check-in
    //             try {
    //                 if (isset($row[4]) && is_numeric($row[4])) {
    //                     $check_in = $this->convertExcelTime($row[4]); // Konversi check_in
    //                 } else {
    //                     throw new \Exception("Invalid check-in format at row: " . json_encode($row));
    //                 }
    //             } catch (\Exception $e) {
    //                 $errors[] = "Invalid check-in format for row: " . json_encode($row);
    //                 continue;
    //             }

    //             // Validasi dan konversi check-out
    //             try {
    //                 if (isset($row[5]) && is_numeric($row[5])) {
    //                     $check_out = $this->convertExcelTime($row[5]); // Konversi check_out
    //                 } else {
    //                     throw new \Exception("Invalid check-out format at row: " . json_encode($row));
    //                 }
    //             } catch (\Exception $e) {
    //                 $errors[] = "Invalid check-out format for row: " . json_encode($row);
    //                 continue;
    //             }

    //             // Lanjutkan proses penyimpanan jika tidak ada error untuk row ini
    //             if (empty($errors)) {
    //                 // Simpan data ke database...
    //             }

    //             $check_eid = Employee::find($eid);
    //             if(!$check_eid) {
    //                 $errors[] = "Employee ID {$check_eid} Not Found or Invalid for row: " . json_encode($row);
    //                 continue;
    //             }
                
    //             $check_work_day = WorkDay::find($work_day);
    //             if(!$check_work_day) {
    //                 $errors[] = "Work Day ID {$work_day} Not Found or Invalid for row: " . json_encode($row);
    //                 continue;
    //             }

    //             // Validasi date
    //             if(!$date || !strtotime($date)) {
    //                 $errors[] = "Invalid date format for row: " . json_encode($row);
    //                 continue;
    //             }

    //             // Validasi check_in
    //             if(!$check_in || !strtotime($check_in)) {
    //                 $errors[] = "Invalid check-in time format for row: " . json_encode($row);
    //                 continue;
    //             }

    //             // Validasi check_out
    //             if(!$check_out || !strtotime($check_out)) {
    //                 $errors[] = "Invalid check-out time format for row: " . json_encode($row);
    //                 continue;
    //             }
                                
    //             $day = strtolower($date->format('l'));
    //             $workDay = WorkDay::where('name', $work_day)->where('day', $day)->first();
    //             $day_off = $work_day->day_off;
    //             $break = $work_day->break;
                
    //             if($day_off == 1) {
    //                 $errors[] = "{{ $date }} for {$employee_name} id Day Off for row: " . json_encode($row);
    //                 continue;
    //             }

    //             $parseTime = function ($time) {
    //                 return $time && $time !== 'N/A' ? Carbon::parse($time) : null;
    //             };

    //             $arrival = $workDay ? $parseTime($workDay->arrival) : null;
    //             $check_in = $workDay ? $parseTime($workDay->check_in) : null;
    //             $check_out = $workDay ? $parseTime($workDay->check_out) : null;
    //             $checked_in = $check_in ? $parseTime($check_in) : null;
    //             $checked_out = $check_out ? $parseTime($check_out) : null;
    //             $lateArrival = $checked_in && $arrival ? ($arrival->diffInMinutes($checked_in, false)> 1 ? 1 : 0) :0;
    //             $lateArrival = intval($lateArrival);
    //             $lateCheckIn = $checked_in && $check_in ? max(intval($check_in->diffInMinutes($checked_in, false)), 0) : '0';

    //             if($checked_out && $check_out){
    //                 $cutStart = Carbon::parse($check_out->format('Y-m-d' . ' 12:00:00 '));
    //                 $cutEnd = Carbon::parse($check_out->format('Y-m-d' . ' 13:00:00 '));
    //                 $excldueBreak = $break == 1;
        
    //                 switch(true) {
    //                     case $excldueBreak:
    //                         $checkOutEarly = max(intval($checked_out->diffInMinutes($check_out, false)), 0);
    //                         break;
        
    //                     case $checked_out->lt($cutStart):
    //                         $checkOutEarly = max(intval($checked_out->diffInMinutes($check_out, false))-60, 0);
    //                         break;
                        
    //                     case $checked_out->between($cutStart, $cutEnd):
    //                         $checkOutEarly = max(intval($cutEnd->diffInMinutes($checked_out, false)), 0);
    //                         break;
                    
    //                     default:
    //                         $checkOutEarly = max(intval($checked_out->diffInMinutes($check_out, false)), 0);
    //                         break;
    //                 }
    //             }

    //             $employee_id = Employee::where('id', $eid)->first();
    //             if (!$employee_id) {
    //                 $errors[] = "Employee with ID {$eid} not found for row: " . json_encode($row);
    //                 continue; // Skip jika employee tidak ditemukan
    //             }
                
    //             $presence = Presence::create([
    //                 'employee_id' => $employee_id,
    //                 'work_day_id' => $work_day,
    //                 'date' => $date,
    //                 'check_in' => $checked_in,
    //                 'check_out' => $checked_out,
    //                 'late_check_in' => $lateCheckIn,
    //                 'late_arrival' => $lateArrival,
    //                 'check_out_early' => $checkOutEarly,
    //             ]);

    //             Log::info('Inserting presence:', [
    //                 'employee_id' => $employee_id,
    //                 'work_day_id' => $work_day,
    //                 'date' => $date,
    //                 'check_in' => $checked_in,
    //                 'check_out' => $checked_out,
    //                 'late_check_in' => $lateCheckIn,
    //                 'late_arrival' => $lateArrival,
    //                 'check_out_early' => $checkOutEarly,
    //             ]);
                
    //         } catch (\Exception $e) {
    //             \Log::error('Failed to save row:', ['error' => $e->getMessage(), 'row' => $row->toArray()]);
    //             $errors[] = "Error processing row: " . json_encode($row);
    //         }
    //     }
    // }


}
