<?php
namespace App\Imports;

use Log;
use Carbon\Carbon;
use App\Models\WorkDay;

use App\Models\Employee;
use App\Models\Presence;
use App\Models\WorkSchedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PresenceImport implements ToCollection
{
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

    public function collection(Collection $rows) {
        foreach ($rows as $row) {
            Log::info('Processing row:', $row->toArray());
            
            // Ambil eid dan work_day
            $eid = $row[0] ?? null; 
            $employee_name = $row[1] ?? null;
            $work_day = $row[2] ?? null;
    
            // Validasi eid
            $employee = Employee::find($eid);
            if (!$employee) {
                $errors[] = "Employee ID {$eid} not found for row: " . json_encode($row);
                continue; // Skip row jika employee tidak ditemukan
            }
    
            // Validasi work_day
            $workDay = WorkDay::find($work_day);
            if (!$workDay) {
                $errors[] = "Work Day ID {$work_day} not found for row: " . json_encode($row);
                continue; // Skip row jika work_day tidak ditemukan
            }
    
            // Validasi dan konversi date
            try {
                if (isset($row[3]) && is_numeric($row[3])) {
                    $date = $this->convertExcelDate($row[3]); // Konversi hanya jika valid
                } else {
                    throw new \Exception("Invalid date format at row: " . json_encode($row));
                }
            } catch (\Exception $e) {
                $errors[] = "Invalid date format for row: " . json_encode($row);
                continue; // Jika ada error, lewati row ini
            }
    
            // Validasi dan konversi check-in
            try {
                if (isset($row[4]) && is_numeric($row[4])) {
                    $check_in = $this->convertExcelTime($row[4]); // Konversi check_in
                } else {
                    throw new \Exception("Invalid check-in format at row: " . json_encode($row));
                }
            } catch (\Exception $e) {
                $errors[] = "Invalid check-in format for row: " . json_encode($row);
                continue; // Jika ada error, lewati row ini
            }
    
            // Validasi dan konversi check-out
            try {
                if (isset($row[5]) && is_numeric($row[5])) {
                    $check_out = $this->convertExcelTime($row[5]); // Konversi check_out
                } else {
                    throw new \Exception("Invalid check-out format at row: " . json_encode($row));
                }
            } catch (\Exception $e) {
                $errors[] = "Invalid check-out format for row: " . json_encode($row);
                continue; // Jika ada error, lewati row ini
            }
    
            // Lanjutkan proses penyimpanan jika tidak ada error untuk row ini
            // Lakukan validasi tambahan jika diperlukan
            if (empty($errors)) {
                // Proses penyimpanan ke database
                try {
                    $presence = Presence::create([
                        'employee_id' => $employee->id,
                        'work_day_id' => $workDay->id,
                        'date' => $date,
                        'check_in' => $check_in,
                        'check_out' => $check_out,
                        // Tambahkan field lain yang diperlukan
                    ]);
    
                    Log::info('Inserting presence:', [
                        'employee_id' => $employee->id,
                        'work_day_id' => $workDay->id,
                        'date' => $date,
                        'check_in' => $check_in,
                        'check_out' => $check_out,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to save presence:', ['error' => $e->getMessage(), 'row' => $row->toArray()]);
                    $errors[] = "Error saving presence for row: " . json_encode($row);
                }
            }
        }
    
        // Jika ada error, tambahkan logika untuk mengelola error lebih lanjut di sini
    }
    

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
    //                 continue; // Jika ada error, lewati row ini
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
    //                 continue; // Jika ada error, lewati row ini
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
    //                 continue; // Jika ada error, lewati row ini
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

    private function convertExcelDate($excelDate) {
        try {
            if (is_numeric($excelDate)) {
                // Convert Excel serial date to Y-m-d format
                return Carbon::createFromFormat('Y-m-d', '1970-01-01')->addDays($excelDate - 25569)->format('Y-m-d');
            }
            return Carbon::parse($excelDate)->format('Y-m-d');
        } catch (\Exception $e) {
            \Log::error('Invalid date format:', ['date' => $excelDate, 'error' => $e->getMessage()]);
            return null;
        }
    }

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
}
