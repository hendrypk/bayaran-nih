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
                continue; 
            }

            try {
                $eid = $row[0] ?? null;
                $date = $row[1] ?? null;
                $check_in = $row[2] ?? null;
                $check_out = $row[3] ?? null;
                $late_arrival = $row[4] ?? null;
                $late_check_in = $row[5] ?? null;
                $check_out_early = $row[6] ?? null;

                $note_in = 'dicatat dari import presensi';
                $note_out = 'dicatat dari import presensi';
                $employee = Employee::where('eid', $eid)->first();
                $employee_name = $employee->name;
                $employee_id = $employee->id;

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
                if (!empty($check_in)) {
                    $check_in = $this->convertExcelTime($check_in);
                } else {
                    $this->errors[] = "Baris {$index}: Format check-in tidak valid.";
                    continue;
                }

                // Validasi dan konversi waktu check-out
                if (!empty($check_out)) {
                    $check_out = $this->convertExcelTime($check_out);
                } else {
                    $this->errors[] = "Baris {$index}: Format check-out tidak valid.";
                    continue;
                }

                $exist = Presence::where('date', $date)->where('employee_id', $employee_id)->first();
                if(empty($exist)) {
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
                } else {
                    $this->errors[] = "Baris {$index}: presensi {$employee_name} ({$eid}) pada tanggal {$date} sudah ada";
                }
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

    private function convertExcelTime($excelTime) {
        try {
            // Jika waktu dalam format Excel (numerik)
            if (is_numeric($excelTime)) {
                $excelTime = rtrim($excelTime, "'"); 
                $secondsInDay = 86400; // 24 * 60 * 60
                $seconds = $excelTime * $secondsInDay;
                return gmdate('H:i:s', $seconds);
            }
    
            // Jika waktu dalam format string, pastikan format 'H:i' atau 'H:i:s'
            $formattedTime = null;
            if (strtotime($excelTime)) {
                $formattedTime = Carbon::parse($excelTime)->format('H:i:s');
            } else {
                $excelTime = rtrim($excelTime, "'"); 
                if (preg_match('/^(\d{2}):(\d{2})$/', $excelTime)) {
                    $formattedTime = Carbon::createFromFormat('H:i', $excelTime)->format('H:i:s');
                }
            }
    
            return $formattedTime;
    
        } catch (\Exception $e) {
            \Log::error('Invalid time format:', ['time' => $excelTime, 'error' => $e->getMessage()]);
            return null;
        }
    }
    
    

    // Helper untuk konversi tanggal Excel
    private function convertExcelDate($excelDate){
        try {
            if (is_numeric($excelDate)) {
                return Carbon::createFromFormat('Y-m-d', '1970-01-01')
                             ->addDays($excelDate - 25569)
                             ->format('Y-m-d');
            } 
            elseif (strtotime($excelDate)) {
                return Carbon::parse($excelDate)->format('Y-m-d');
            } 
            else {
                throw new \Exception('Invalid date value.');
            }
        } catch (\Exception $e) {
            Log::error('Invalid date format:', ['date' => $excelDate, 'error' => $e->getMessage()]);
            return null;
        }
    }
}
