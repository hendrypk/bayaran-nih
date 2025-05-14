<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\LaporHr;
use App\Models\WorkDay;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\OfficeLocation;
use App\Models\LaporHrCategory;
use App\Models\LaporHrAttachment;
use Illuminate\Support\Facades\Log;
use App\Traits\PresenceSummaryTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeAppController extends Controller
{

    use PresenceSummaryTrait;

    //About
    public function about()
    {
        return view('_employee_app.about');
    }

    //Dashboard
    public function index()
    {
        $employeeId = Auth::id();
        $employee = Employee::with('workDay')->findOrFail($employeeId);
        $workDay = $employee->workDay;

        $today = Carbon::today()->toDateString();
        $presenceToday = Presence::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->whereNull('leave_status')
            ->first();

        $leaveAccepted = Presence::where('employee_id', $employeeId)
            ->where('date', $today)
            ->where('leave_status', 1)
            ->first();

        $pastPresence = Presence::where('employee_id', $employeeId)
            ->orderBy('date', 'desc')
            ->whereNull('leave_status')
            ->first();

        $overtimeToday = Overtime::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();

        // switch (true) {
        //     case empty($pastPresence->check_out) && !empty($pastPresence->check_in);
        //         echo (1);
        //         break;
        //     case !empty($pastPresence->check_out) && empty($presenceToday->check_in);
        //         echo(2);
        //         break;
        //     case !empty($leaveAccepted);
        //         echo(3);
        //         break;
        //     case empty($presenceToday->check_in);
        //         echo(4);
        //         break;
        // }

        $employees = collect([$employee]); // Gunakan koleksi untuk 1 karyawan
        $employees = $this->calculatePresenceSummary($employees, Carbon::now()->startOfMonth(), Carbon::now());

        $chartData = [
            'labels' => ['Hadir', 'Libur', 'Sakit', 'Izin', 'Izin Setengah Hari', 'Cuti', 'Alpha'], // Use the actual labels
            'data' => [
                $employee->presence,
                $employee->holiday,
                $employee->sick_permit,
                $employee->full_day_permit,
                $employee->half_day_permit,
                $employee->annual_leave,
                $employee->alpha,
            ]
        ];

        return view('_employee_app.index', compact('employee', 'workDay', 'presenceToday', 'leaveAccepted', 'pastPresence', 'overtimeToday', 'chartData'));
    }

    //Create Presence In
    public function presenceIn()
    {
        $employeeId = Auth::id();
        $employee = Employee::with('workDay', 'officeLocations')->findOrFail($employeeId);
        $workDay = $employee->workDay;
        $lokasi = $employee->officeLocations->first();
        $officeLatitude = $lokasi->latitude;
        $officeLongitude = $lokasi->longitude;
        $radius = $lokasi->radius;
        return view('_employee_app.presence.presence_in', compact('employee', 'officeLatitude', 'officeLongitude', 'radius'));
    }

    //Create Presence Out
    public function presenceOut()
    {
        $employeeId = Auth::id();
        $employee = Employee::with('workDay', 'officeLocations')->findOrFail($employeeId);
        $today = Carbon::today()->toDateString();
        $existPresence = Presence::where('employee_id', $employeeId)->orderBy('date', 'desc')->first();
        $pastPresence = Presence::where('employee_id', $employeeId)
            ->orderBy('date', 'desc')
            ->whereNull('deleted_at')
            ->whereNull('leave')
            ->first();

        $workDay = $pastPresence->work_day_id;
        $workDayName = WorkDay::where('id', $workDay)->first()->name;

        $lokasi = $employee->officeLocations->first();
        $officeLatitude = $lokasi->latitude;
        $officeLongitude = $lokasi->longitude;
        $radius = $lokasi->radius;

        // $workDay = $employee->workDay;
        return view('_employee_app.presence.presence_out', compact('employee', 'workDay', 'workDayName', 'officeLatitude', 'officeLongitude', 'radius'));
    }

    //Store Image
    public function imageStore(Request $request)
    {
        $request->validate([
            'image' => 'required|string'
        ]);

        // Extract base64 image string and decode it
        $imageData = $request->input('image');

        // Remove the data:image/jpeg;base64, part
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);

        // Decode base64 to binary
        $imageData = base64_decode($imageData);

        // Create unique file name
        $eid = Auth::id();
        $datePhoto = now()->toDateString();
        $timePhoto = now()->toTimeString();
        $fileName = $eid . '-' . $datePhoto . '-' . $timePhoto . '.jpg';

        // Save the image to storage/app/public folder
        $path = storage_path('app/public/presences/' . $fileName);
        file_put_contents($path, $imageData);

        return response()->json(['success' => 'Image saved successfully!']);
    }

    //Calculate Presence Radius
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) +
            (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters', 'kilometers', 'miles');
    }

    //try save presence with new logic
    public function save(Request $request)
    {
        $request->validate([
            // 'note' => 'required',
            'location' => 'required',
            // 'workDay' => 'interger',
            'image' => 'required|string'
        ], [
            'note.required' => __('messages.note_required'),
            'location.required' => __('messages.location_required'),
        ]);

        //Get employee and work day data
        $employeeId = Auth::id();
        $employee = Employee::with('workDay')->findOrFail($employeeId);

        $date = Carbon::parse(now()->toDateString());
        $today = strtolower($date->format('l'));
        $workDayData = WorkDay::find($request->workDay);
        $workDay = WorkDay::where('name', $workDayData->name)->where('day', $today)->first();
        $day_off = $workDay->day_off;
        $break = $workDay->break;
        $isCountLate = $workDay->count_late;

        //Get Office Location From Table
        $ol = $request->officeLocations;
        $location = OfficeLocation::where('name', $request->officeLocations)->first();
        $latOffice = $location->latitude;
        $lonOffice = $location->longitude;
        $maxRadius = $location->radius;

        //Get Location User
        $loc = $request->input('location');
        $location = explode(',', $loc);
        $latUser = $location[0];
        $lonUser = $location[1];
        $distance = $this->distance($latOffice, $lonOffice, $latUser, $lonUser);
        $radius = round($distance["meters"]);
        $radiusKM = round($distance["kilometers"]);

        // Validasi jika user di luar radius
        if ($radius > $maxRadius) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.outside_radius', ['meters' => $radius]),
            ]);
        };

        //process image data
        $datePhoto = now()->toDateString();
        $timePhoto = now()->toTimeString();
        $photoName = $employeeId . '-' . $datePhoto . '-' . $timePhoto . '.jpg';
        $imageData = $request->input('image');
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $imageData = base64_decode($imageData);

        $parseTime = function ($time) {
            return $time && $time !== 'N/A' ? Carbon::parse($time) : null;
        };

        //Get from Work Day table
        $arrival = $workDay ? $parseTime($workDay->arrival) : null;
        $check_in = $workDay ? $parseTime($workDay->check_in) : null;
        $check_out = $workDay ? $parseTime($workDay->check_out) : null;
        $break_in =  $workDay ? $parseTime($workDay->break_in) : null;
        $break_out =  $workDay ? $parseTime($workDay->break_out) : null;
        $excldueBreak = $break == 1;

        //Break Duration
        $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);

        //Get From Form
        $now = $parseTime(now()->toTimeString());
        $presence = Presence::where('employee_id', $employeeId)
            ->where('date', now()->toDateString())
            ->first();

        $pastPresence = Presence::where('employee_id', $employeeId)
            ->orderBy('date', 'desc')
            ->whereNull('leave_status')
            ->whereNull('leave')
            ->first();
        // dd($pastPresence);
        if ($now && $check_in) {
            switch (true) {
                case $isCountLate == 0:
                    $lateCheckIn = 0;
                    $lateArrival = 0;
                    break;

                case $excldueBreak:
                    $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
                    $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false) > 1 ? 1 : 0) : 0;
                    $lateArrival = intval($lateArrival);
                    break;

                case $now->between($break_in, $break_out):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($break_in, false)), 0);
                    $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false) > 1 ? 1 : 0) : 0;
                    $lateArrival = intval($lateArrival);
                    break;

                case $break_in->lt($now):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)) - $breakDuration, 0);
                    $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false) > 1 ? 1 : 0) : 0;
                    $lateArrival = intval($lateArrival);
                    break;

                case $now->lt($break_in):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
                    $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false) > 1 ? 1 : 0) : 0;
                    $lateArrival = intval($lateArrival);
                    break;
            }
        }

        $message = '';

        switch (true) {
            case !is_null($pastPresence) && is_null($pastPresence->check_out):
                $checkOutEarly = 0;
                $path = storage_path('app/public/presences/' . $photoName);
                file_put_contents($path, $imageData);

                $pastPresence->update([
                    'check_out' => now()->toTimeString(),
                    'check_out_early' => $checkOutEarly,
                    // 'note_out' => $request->note,
                    'photo_out' => $photoName,
                    'location_out' => $loc
                ]);

                $message = __('messages.early_check_out', ['minutes' => $checkOutEarly]);
                break;

            case (!empty($presence) && !is_null($presence->check_in) && is_null($presence->check_out)) || (!empty($pastPresence) && is_null($pastPresence->check_out)):

                // case !is_null($presence->check_in) && is_null($presence->check_out) || !is_null($pastPresence) && is_null($pastPresence->check_out):

                if ($now && $check_out) {
                    $workDayId = $presence->work_day_id;
                    $lastWorkDayData = WorkDay::find($workDayId);
                    $lastWorkDay = WorkDay::where('name', $lastWorkDayData->name)->where('day', $today)->first();
                    $forCheckIn = $lastWorkDay->check_in;
                    $forCheckOut = $lastWorkDay->check_out;
                    $break = $lastWorkDay->break;

                    switch (true) {
                        case $isCountLate == 0:
                            $checkOutEarly = 0;
                            break;

                        case $excldueBreak:
                            $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)), 0);
                            break;

                        case $now->lt($forCheckIn):
                            $checkOutEarly = 0;
                            break;

                        case $now->lt($break_in):
                            $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)) - 60, 0);
                            break;

                        case $now->between($break_in, $break_out):
                            $checkOutEarly = max(intval($break_out->diffInMinutes($forCheckOut, false)), 4);
                            break;

                        default:
                            $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)), 0);
                            break;
                    }
                }

                $path = storage_path('app/public/presences/' . $photoName);
                file_put_contents($path, $imageData);

                $presence->update([
                    'check_out' => now()->toTimeString(),
                    'check_out_early' => $checkOutEarly,
                    // 'note_out' => $request->note,
                    'photo_out' => $photoName,
                    'location_out' => $loc
                ]);

                $message = __('messages.early_check_out', ['minutes' => $checkOutEarly]);
                break;

            case is_null($presence) || !is_null($presence) && is_null($presence->leave_status):
                $path = storage_path('app/public/presences/' . $photoName);
                file_put_contents($path, $imageData);

                $presence = Presence::updateOrcreate([
                    'id' => optional($presence)->id
                ], [
                    'employee_id' => $employeeId,
                    'work_day_id' => $request->workDay,
                    'date' => $datePhoto,
                    'check_in' => $timePhoto,
                    'late_check_in' => $lateCheckIn,
                    'late_arrival' => $lateArrival,
                    // 'note_in' => $request->note,
                    'photo_in' => $photoName,
                    'location_in' => $loc
                ]);

                $message = __('messages.late_check_in', ['minutes' => $lateCheckIn]);
                break;

            case !is_null($presence->check_in) && !is_null($presence->check_out):
                $message = __('messages.already_check_in');
                return redirect()->back()->with('error', $message);
                break;

            default:
                $message = __('messages.system_error');
                return redirect()->back()->with('error', $message);
                break;
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'redirectUrl' => route('employee.app')
        ]);
    }

    //Store Presence
    // public function store(Request $request){
    //     $request->validate([
    //         'note' => 'required',
    //         'location' => 'required'
    //     ],[
    //         'note.required' => __('messages.note_required'),
    //         'location.required' => __('messages.location_required'),
    //     ]);

    //     //Get employee data
    //     $employeeId = Auth::id();
    //     $eid = Auth::user()->eid;
    //     $employeeName = Auth::user()->name;
    //     $employee = Employee::with('workDay')->findOrFail($employeeId);
    //     $date = Carbon::parse(now()->toDateString());
    //     $today = strtolower($date->format('l'));

    //     $workDayData = WorkDay::find($request->workDay);
    //     $workDay = WorkDay::where('name', $workDayData->name)->where('day', $today)->first();
    //     $day_off = $workDay->day_off;
    //     $break = $workDay->break;
    //     $isCountLate = $workDay->count_late;

    //     // \Log::info('Data $isCountLate:', ['workDay' => $request->workDay, 'today' => $today, 'workDayData'=>$workDayData, 'workDay' => $workDay, ]);

    //     //Get photo data
    //     $request->validate([
    //         'image' => 'required|string'
    //     ]);
    //     $datePhoto = now()->toDateString();
    //     $timePhoto = now()->toTimeString();
    //     $photoName = $employeeId . '-' . $datePhoto . '-' . $timePhoto . '.jpg';
    //     $imageData = $request->input('image');
    //     $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
    //     $imageData = base64_decode($imageData);

    //     //Get Office Location From Table
    //     $ol = $request->officeLocations;
    //     $location = OfficeLocation::where('name', $request->officeLocations)->first();
    //     $latOffice = $location->latitude;
    //     $lonOffice = $location->longitude;
    //     $maxRadius = $location->radius;

    //     //Get Location User
    //     $loc = $request->input('location');
    //     $location = explode(',', $loc);
    //     $latUser = $location[0];
    //     $lonUser = $location[1];

    //     $distance = $this->distance($latOffice, $lonOffice, $latUser, $lonUser);
    //     $radius = round($distance["meters"]);
    //     $radiusKM = round($distance["kilometers"]);

    //     if($maxRadius < $radius) {
    //         $message = 'Posisimu kadoan ' . $radiusKM . ' km seko pabrik, nek ora coba cek GPSmu!';
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $message,
    //         ]);
    //     } else {        

    //     if($day_off == 1){
    //         $message = 'Dino iki jatahmu prei. Nek awakmu tetep kerjo, absen lembur.';
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $message,
    //         ]);
    //         // return redirect()->back()->with('error', $message);
    //     }

    //     $parseTime = function($time) {
    //         return $time && $time !== 'N/A' ? Carbon::parse($time) : null;
    //     };

    //     //Get from Work Day table
    //     $arrival = $workDay ? $parseTime($workDay->arrival) : null;
    //     $check_in = $workDay ? $parseTime($workDay->check_in) : null;
    //     $check_out = $workDay ? $parseTime($workDay->check_out) : null;
    //     $break_in =  $workDay ? $parseTime($workDay->break_in) : null;
    //     $break_out =  $workDay ? $parseTime($workDay->break_out) : null;
    //     $excldueBreak = $break == 1;
    //     $noCountLate = $isCountLate == 0;

    //     //Break Duration
    //     $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);

    //     //Get From Form
    //     $now = $parseTime (now()->toTimeString());

    //     if($now && $check_in) {
    //         switch(true) {
    //             case $isCountLate == 0:
    //                 $lateCheckIn = 0;
    //                 $lateArrival = 0;
    //                 break;

    //             case $excldueBreak:
    //                 $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
    //                 // $lateCheckIn = 'exclude break';
    //                 $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false)> 1 ? 1 : 0) :0;
    //                 $lateArrival = intval($lateArrival);
    //                 break;

    //             case $now->between($break_in, $break_out):
    //                 $lateCheckIn = max(intval($check_in->diffInMinutes($break_in, false)), 0);
    //                 // $lateCheckIn = 'when break';
    //                 $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false)> 1 ? 1 : 0) :0;
    //                 $lateArrival = intval($lateArrival);
    //                 break;

    //             case $break_in->lt($now):
    //                 $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)) - $breakDuration, 0);
    //                 // $lateCheckIn = 'after break out';
    //                 $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false)> 1 ? 1 : 0) :0;
    //                 $lateArrival = intval($lateArrival);
    //                 break;

    //             case $now->lt($break_in):
    //                 $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
    //                 // $lateCheckIn = 'normal';
    //                 $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false)> 1 ? 1 : 0) :0;
    //                 $lateArrival = intval($lateArrival);
    //                 break;
    //         }
    //     }

    //         // Find existing presence for today
    //         $presence = Presence::where('employee_id', $employeeId)
    //             ->where('date', now()->toDateString())
    //             ->first();

    //         $pastPresence = Presence::where('employee_id', $employeeId)
    //             ->orderBy('date', 'desc')
    //             ->where('leave_status', 0)
    //             ->first();

    //         $message = '';

    //         // Switch case to handle presence states
    //         switch (true) {
    //             // Case when there is no presence record for today (Check-in)
    //             case is_null($presence):

    //                 // Save the image to storage/app/public folder
    //                 $path = storage_path('app/public/presences/' . $photoName);
    //                 file_put_contents($path, $imageData);

    //                 $presence =Presence::create([
    //                         'employee_id' => $employeeId,
    //                         // 'eid' => $eid,
    //                         // 'employee_name' => $employeeName,
    //                         'work_day_id' => $request->workDay,
    //                         'date' => $datePhoto,
    //                         'check_in' => $timePhoto,
    //                         'late_check_in' => $lateCheckIn,
    //                         'late_arrival' => $lateArrival,
    //                         'note_in' => $request->note,
    //                         'photo_in' => $photoName,
    //                         'location_in' => $loc
    //                 ]);

    //                 $message = __('messages.late_check_in', ['minutes' => $lateCheckIn]);
    //                 break;

    //             // Case when the employee has checked in but not checked out (Check-out)
    //             case !is_null($presence->check_in) && is_null($pastPresence->check_out):
    //                 $workDayId = $presence->work_day_id;
    //                 $lastWorkDayData = WorkDay::find($workDayId);
    //                 $lastWorkDay = WorkDay::where('name', $lastWorkDayData->name)->where('day', $today)->first();
    //                 // $lastWorkDay = WorkDay::find($lastedWorkDay)->where('day', $today)->first();
    //                 $forCheckIn = $lastWorkDay->check_in;
    //                 $forCheckOut = $lastWorkDay->check_out;
    //                 $break = $lastWorkDay->break;

    //     // \Log::info('Data $isCountLate:', ['forCheckOut' => $forCheckOut, 'noCountLate' => $noCountLate]);

    //                 if($now && $check_out){

    //                     switch(true) {
    //                         case $isCountLate == 0:
    //                             $checkOutEarly = 0;
    //                             break;

    //                         case $excldueBreak:
    //                             $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)), 0);
    //                             break;

    //                         case $now->lt($forCheckIn):
    //                             $checkOutEarly = 0;
    //                             break;

    //                         case $now->lt($break_in):
    //                             $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false))-60, 0);
    //                             break;

    //                         case $now->between($break_in, $break_out):
    //                             $checkOutEarly = max(intval($break_out->diffInMinutes($forCheckOut, false)), 4);
    //                             break;

    //                         default:
    //                             $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)), 0);
    //                             break;
    //                     }
    //                 }

    //                 // Save the image to storage/app/public folder
    //                 $path = storage_path('app/public/presences/' . $photoName);
    //                 file_put_contents($path, $imageData);

    //                 $presence->update([
    //                     'check_out' => now()->toTimeString(),
    //                     'check_out_early' => $checkOutEarly,
    //                     'note_out' => $request->note,
    //                     'photo_out' => $photoName,
    //                     'location_out' => $loc
    //                 ]);

    //                 $message = __('messages.early_check_out', ['minutes' => $checkOutEarly]);
    //                 break;

    //             // Case when both check-in and check-out are already recorded
    //             case !is_null($presence->check_in) && !is_null($presence->check_out):
    //                 $message = __('messages.already_check_in');
    //                 return redirect()->back()->with('error', $message);
    //                 break;

    //             // Default case to catch any unexpected scenarios
    //             default:
    //                 $message = __('messages.system_error');
    //                 return redirect()->back()->with('error', $message);
    //                 break;
    //         }
    //     }
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => $message,
    //         'redirectUrl' => route('employee.app') 
    //     ]);
    // }

    //Presences History
    public function history(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $employeeId = Auth::id();
        $employee = Employee::findOrFail($employeeId);
        $query = Presence::where('employee_id', $employeeId)->whereNull('leave_status')->whereNotNull('work_day_id');
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }
        $presences = $query->get();
        return view('_employee_app.history', compact('presences'));
    }

    //Overtime Form
    public function overtime()
    {
        $employeeId = Auth::id();
        $employee = Employee::with('workDay')->findOrFail($employeeId);

        $lokasi = $employee->officeLocations->first();
        $officeLatitude = $lokasi->latitude;
        $officeLongitude = $lokasi->longitude;
        $radius = $lokasi->radius;

        return view('_employee_app.overtime.overtime_in', compact('employee', 'officeLatitude', 'officeLongitude', 'radius'));
    }

    public function overtimeOut()
    {
        $employeeId = Auth::id();
        $employee = Employee::with('workDay')->findOrFail($employeeId);
        $lokasi = $employee->officeLocations->first();
        $officeLatitude = $lokasi->latitude;
        $officeLongitude = $lokasi->longitude;
        $radius = $lokasi->radius;

        return view('_employee_app.overtime.overtime_out', compact('employee', 'officeLatitude', 'officeLongitude', 'radius'));
    }

    // Overtime Store
    public function overtimeStore(Request $request)
    {
        $employeeId = Auth::id();
        $date = Carbon::parse(now()->toDateString());
        $today = strtolower($date->format('l'));

        //Get photo data
        $request->validate([
            'image' => 'required|string'
        ]);
        $datePhoto = now()->toDateString();
        $timePhoto = now()->toTimeString();
        $photoName = $employeeId . '-' . $datePhoto . '-' . $timePhoto . '.jpg';
        $imageData = $request->input('image');
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $imageData = base64_decode($imageData);

        //Get Office Location From Table
        $ol = $request->officeLocations;
        $location = OfficeLocation::where('name', $request->officeLocations)->first();
        $latOffice = $location->latitude;
        $lonOffice = $location->longitude;
        $maxRadius = $location->radius;

        //Get Location User
        $loc = $request->input('location');
        $location = explode(',', $loc);
        $latUser = $location[0];
        $lonUser = $location[1];

        $distance = $this->distance($latOffice, $lonOffice, $latUser, $lonUser);
        $radius = round($distance["meters"]);
        $radiusKM = round($distance["kilometers"]);

        if ($maxRadius < $radius) {
            $message = 'Posisimu kadoan ' . $radiusKM . ' km seko pabrik, nek ora coba cek GPSmu!';
            return response()->json([
                'success' => 'false',
                'message' => $message,
            ]);
        }

        //find existing overtime today
        $overtime = overtime::where('employee_id', $employeeId)
            ->where('date', $date)
            ->first();

        $parseTime = function ($time) {
            return $time && $time !== 'N/A' ? Carbon::parse($time) : null;
        };

        $start_at = $overtime ? $parseTime($overtime->start_at) : null;
        $now = $parseTime(now()->toTimeString());
        $total_overtime = $now && $start_at ? max(intval($start_at->diffInMinutes($now, false)), 0) : '0';

        switch (true) {
            case is_null($overtime):
                $path = storage_path('app/public/overtimes/' . $photoName);
                file_put_contents($path, $imageData);

                $overtime = Overtime::create([
                    'employee_id' => $employeeId,
                    'date' => $date,
                    'start_at' => now()->toTimeString(),
                    'photo_in' => $photoName,
                    'note_in' => $request->note,
                    'location_in' => $loc,
                ]);
                $message = __('messages.overtime_in_success');
                break;

            case !is_null($overtime->start_at) && is_null($overtime->end_at):
                $path = storage_path('app/public/overtimes/' . $photoName);
                file_put_contents($path, $imageData);

                $overtime->update([
                    'end_at' => now()->toTimeString(),
                    'photo_out' => $photoName,
                    'note_out' => $request->note,
                    'location_out' => $loc,
                    'total' => $total_overtime,
                ]);
                $message = __('messages.overtime_out_success');
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'redirectUrl' => route('employee.app')
        ]);
    }

    //Overtime History
    public function overtimeHistory(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $employeeId = Auth::id();
        $query = Overtime::where('employee_id', $employeeId);
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }
        $overtime = $query->get();

        return view('_employee_app.overtime-history', compact('overtime'));
    }

    //Overtime
    public function profileIndex()
    {
        return view('_employee_app.profile.index');
    }


    //Reset username
    public function resetUsername()
    {
        return view('_employee_app.profile.username');
    }

    public function resetUsernameStore(Request $request)
    {
        $request->validate([
            'username' => 'required|string|regex:/^\S*$/|unique:employees,username',
            'currentPassword' => 'required|string',
        ], [
            'username.required' => 'Please fill the username',
            'username.regex' => 'Username contains invalid character',
            'username.unique' => 'Username already exists',
            'currentPassword.required' => 'Please enter your current password',
        ]);

        $username = $request->username;
        $currentPassword = $request->currentPassword;
        $employee = Auth::user();
        if (Hash::check($currentPassword, $employee->password)) {
            $employee->update([
                'username' => $username,
            ]);
            session()->flash('success', 'Username updated successfully!');
        } else {
            session()->flash('error', 'Password is incorrect. Please reenter the current password!');
        }

        return redirect()->route('change.username')->withInput();
    }

    //Reset Password
    public function resetPassword()
    {
        return view('_employee_app.profile.password');
    }

    public function resetPasswordStore(Request $request)
    {
        // Validasi input
        $request->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:6',
            'confirmPassword' => 'required|string|same:newPassword',
        ], [
            'currentPassword.required' => 'Current password is required!',
            'newPassword.required' => 'New password is required!',
            'newPassword.min' => 'Minimum password is 6 characters!',
            'confirmPassword.required' => 'Confirm password is required!',
            'confirmPassword.same' => 'Confirmation password must match the new password!',
        ]);

        $currentPassword = $request->currentPassword;
        $newPassword = $request->newPassword;

        // Ambil password saat ini dari user
        $employee = Auth::user();
        $storedPassword = $employee->password;

        // Cek apakah current password benar
        if (Hash::check($currentPassword, $storedPassword)) {
            // Update password baru setelah dienkripsi
            $employee->update([
                'password' => Hash::make($newPassword),
            ]);

            session()->flash('success', 'Password updated successfully!');
        } else {
            session()->flash('error', 'Current password is incorrect. Please try again!');
        }

        return redirect()->route('change.password')->withInput();
    }

    //Leave
    public function leaveIndex()
    {
        $employeeId = Auth::id();
        $leaves = Presence::where('employee_id', $employeeId)->whereNotNull('leave')->get();
        return view('_employee_app.leave.index', compact('leaves'));
    }

    public function leaveApply()
    {
        $category = [
            PRESENCE::LEAVE_ANNUAL,
            PRESENCE::LEAVE_SICK,
            PRESENCE::LEAVE_FULL_DAY_PERMIT,
            PRESENCE::LEAVE_HALF_DAY_PERMIT,
        ];
        return view('_employee_app.leave.modal', compact('category'));
    }

    public function leaveStore(Request $request)
    {
        $request->validate([
            'leave_dates' => 'required|array',
            'category' => 'required|string',
            'note' => 'required|string',
        ]);

        $employeeId = Auth::id();
        $employee = Auth::user();  // Jika ada relasi 'employee' pada model User
        $eid = $employee->eid;

        $leaveDates = $request->input('leave_dates');
        $leaveDates = explode(',', $leaveDates[0]);
        $leaveDates = array_map('trim', $leaveDates);
        $category = $request->input('category');
        $note = $request->input('note');

        $existLeave = Presence::where('employee_id', $employeeId)
            ->whereIn('date', $leaveDates)
            ->whereNotNull('leave')
            ->pluck('date')->toArray();
        $existPresence = Presence::where('employee_id', $employeeId)
            ->whereIn('date', $leaveDates)
            ->whereNotNull('check_in')
            ->pluck('date')->toArray();

        switch (true) {
            case $existLeave;
                return redirect()->back()->withErrors(['leave_dates' => 'There have been applications for leave on several dates.']);
                break;
            case !empty($existPresence);
                return redirect()->back()->withErrors('Kamu hadir pada tanggal tersebut');
                break;
            default;
                foreach ($leaveDates as $date) {
                    $leave = Presence::create([
                        'eid' => $eid,
                        'employee_id' => $employeeId,
                        'date' => $date,
                        'leave' => $category,
                        'leave_note' => $note,
                        // 'leave_status' => 0,
                    ]);
                }
        }

        // if($existLeave) {
        //     return redirect()->back()->withErrors(['leave_dates' => 'There have been applications for leave on several dates.']);
        // } elseif(empty($pastPresence->check_out)) {
        //     return redirect()->back()->withErrors('Silahkan absen keluar terlebih dahulu');
        // }
        // foreach ($leaveDates as $date) {
        //     $leave = Presence::create([
        //         'eid' => $eid,
        //         'employee_id' => $employeeId,
        //         'date' => $date,
        //         'leave' => $category,
        //         'leave_note' => $note,
        //         'leave_status' => 0,
        //     ]);
        // }

        return redirect()->route('leave.index')->with('success', 'Cuti berhasil dibuat!');
    }
    //Gaji
    public function payslipIndex()
    {
        return view('_employee_app.payslip.index');
    }

    //Lapor HR
    public function laporHrIndex()
    {
        $laporHr = LaporHr::with('attachments')
            ->where('employee_id', Auth::id())
            ->get();
        $reportCategory = LaporHrCategory::get();
        $laporHr->map(function ($report) {
            // Pastikan berupa koleksi, walaupun kosong
            $report->report_attachments = $report->attachments
                ? $report->attachments->where('type', LaporHrAttachment::TYPE_REPORT)->values()
                : collect();

            $report->solve_attachments = $report->attachments
                ? $report->attachments->where('type', LaporHrAttachment::TYPE_SOLVE)->values()
                : collect();

            return $report;
        });
        return view('_employee_app.lapor_hr.index', compact('laporHr', 'reportCategory'));
    }

    public function laporHrAdd() {
        $reportCategory = LaporHrCategory::get();
        $status = ['open' => 'open', 'on progress' => 'on progress', 'close' => 'close'];
        return view('_employee_app.lapor_hr.modal', compact('reportCategory', 'status'));
    }

    public function laporHrSubmit (Request $request) {
        $request->validate([
            'report_attachment' => 'required|array',
            'report_attachment.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4,mov,avi,mkv|max:5120',
        
            // 'solve_attachment' => 'nullable|array',
            // 'solve_attachment.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4,mov,avi,mkv|max:5120',
        ], [
            'report_attachment.*.file' => 'Setiap file harus berupa file yang valid.',
            'report_attachment.*.mimes' => 'File harus berformat: jpg, jpeg, png, pdf, mp4, mov, avi, atau mkv.',
            'report_attachment.*.max' => 'Ukuran maksimal file adalah 5MB.',
        
            // 'solve_attachment.*.file' => 'Setiap file harus berupa file yang valid.',
            // 'solve_attachment.*.mimes' => 'File harus berformat: jpg, jpeg, png, pdf, mp4, mov, avi, atau mkv.',
            // 'solve_attachment.*.max' => 'Ukuran maksimal file adalah 5MB.',
        ]);       

        $laporHr = LaporHr::updateOrCreate(
            ['id' => $request->id],
            [
            'employee_id' => Auth::id(),
            'category_id' => $request->report_category,
            'report_date' => $request->report_date,
            'report_description' => $request->report_description,
        ]);
        if ($request->hasFile('report_attachment')) {
            foreach ($request->file('report_attachment') as $file) {
                $ext = $file->getClientOriginalExtension() ?: 'jpg';
                $filename = time() . '_' . uniqid() . '.' . $ext;
                $path = $file->storeAs('lapor-hr', $filename, 'public');
        
                LaporHrAttachment::create([
                    'lapor_hr_id' => $laporHr->id,
                    'file_path' => $path,
                    'type' => LaporHrAttachment::TYPE_REPORT
                ]);
            }
        }   
        return redirect()->route('laporHrIndex')->with('success', 'Lapor HR berhasil dibuat.');

    }
}
