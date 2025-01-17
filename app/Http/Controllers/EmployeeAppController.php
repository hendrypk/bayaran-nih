<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\WorkDay;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\OfficeLocation;
use App\Traits\PresenceSummaryTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeAppController extends Controller
{

    use PresenceSummaryTrait;
    
//About
    public function about(){
        return view('_employee_app.about');
    }
//Dashboard
    public function index(){
        $employeeId = Auth::id();
        $employee = Employee::with('workDay')->findOrFail($employeeId);
        $workDay = $employee->workDay;

        $today = Carbon::today()->toDateString();
        $presenceToday = Presence::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();
        $overtimeToday = Overtime::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();
            
        $employees = collect([$employee]); // Gunakan koleksi untuk 1 karyawan
        $employees = $this->calculatePresenceSummary($employees, Carbon::now()->startOfMonth(), Carbon::now());

        // Prepare data for chart
        // $chartData = [
        //     [
        //         'name' => 'Alpha',
        //         'data' => [$employee->alpha],
        //     ],
        //     [
        //         'name' => 'Hadir',
        //         'data' => [$employee->presence],
        //     ],
        //     [
        //         'name' => 'Sakit',
        //         'data' => [$employee->sick_leave],
        //     ],
        //     [
        //         'name' => 'Izin',
        //         'data' => [$employee->permit_leave],
        //     ],
        //     [
        //         'name' => 'Cuti',
        //         'data' => [$employee->annual_leave],
        //     ],
        // ];
        
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

        // return response()->json($chartData);

        return view('_employee_app.index', compact('employee', 'workDay', 'presenceToday', 'overtimeToday', 'chartData'));
    }

//Create Presence In
    public function presenceIn(){
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
public function presenceOut(){
    $employeeId = Auth::id();
    $employee = Employee::with('workDay', 'officeLocations')->findOrFail($employeeId);
    $today = Carbon::today()->toDateString();
    $existPresence = Presence::where('employee_id', $employeeId)->where('date', $today)->first();

    $workDay = $existPresence->work_day_id;
    $workDayName = WorkDay::find($workDay)->first()->name;

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
function distance($lat1, $lon1, $lat2, $lon2){
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

//Store Presence
    public function store(Request $request){
        $request->validate([
            'note' => 'required',
            'location' => 'required'
        ],[
            'note.required' => __('messages.note_required'),
            'location.required' => __('messages.location_required'),
        ]);

        //Get employee data
        $employeeId = Auth::id();
        $eid = Auth::user()->eid;
        $employeeName = Auth::user()->name;
        $employee = Employee::with('workDay')->findOrFail($employeeId);
        $date = Carbon::parse(now()->toDateString());
        $today = strtolower($date->format('l'));
        $workDay = WorkDay::find($request->workDay)->where('day', $today)->first();
        $day_off = $workDay->day_off;
        $break = $workDay->break;
        $isCountLate = $workDay->count_late;
        
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

        if($maxRadius < $radius) {
            $message = 'Posisimu kadoan ' . $radiusKM . ' km seko pabrik, nek ora coba cek GPSmu!';
            // return redirect()->back()->with('error', $message);
            return response()->json([
                'status' => 'error',
                'message' => $message,
            ]);
        } else {        
        
        if($day_off == 1){
            $message = 'Dino iki jatahmu prei. Nek awakmu tetep kerjo, absen lembur.';
            return redirect()->back()->with('error', $message);
        }

        $parseTime = function($time) {
            return $time && $time !== 'N/A' ? Carbon::parse($time) : null;
        };

        //Get from Work Day table
        $arrival = $workDay ? $parseTime($workDay->arrival) : null;
        $check_in = $workDay ? $parseTime($workDay->check_in) : null;
        $check_out = $workDay ? $parseTime($workDay->check_out) : null;
        $break_in =  $workDay ? $parseTime($workDay->break_in) : null;
        $break_out =  $workDay ? $parseTime($workDay->break_out) : null;
        $excldueBreak = $break == 1;
        $noCountLate = $isCountLate == 0;

        //Break Duration
        $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);

        //Get From Form
        $now = $parseTime (now()->toTimeString());
        // $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false)> 1 ? 1 : 0) :0;
        // $lateArrival = intval($lateArrival);
        // $lateCheckIn = $now && $check_in ? max(intval($check_in->diffInMinutes($now, false)), 0) : '0';

        
        if($now && $check_in) {
            switch(true) {
                case $noCountLate:
                    $lateCheckIn = 0;
                    $lateArrival = 0;
                    break;

                case $excldueBreak:
                    $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
                    // $lateCheckIn = 'exclude break';
                    $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false)> 1 ? 1 : 0) :0;
                    $lateArrival = intval($lateArrival);
                    break;

                case $now->between($break_in, $break_out):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($break_in, false)), 0);
                    // $lateCheckIn = 'when break';
                    $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false)> 1 ? 1 : 0) :0;
                    $lateArrival = intval($lateArrival);
                    break;

                case $break_in->lt($now):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)) - $breakDuration, 0);
                    // $lateCheckIn = 'after break out';
                    $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false)> 1 ? 1 : 0) :0;
                    $lateArrival = intval($lateArrival);
                    break;

                case $now->lt($break_in):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($now, false)), 0);
                    // $lateCheckIn = 'normal';
                    $lateArrival = $now && $arrival ? ($arrival->diffInMinutes($now, false)> 1 ? 1 : 0) :0;
                    $lateArrival = intval($lateArrival);
                    break;
            }
        }

            // Find existing presence for today
            $presence = Presence::where('employee_id', $employeeId)
            ->where('date', now()->toDateString())
            ->first();
            
            $message = '';

            // Switch case to handle presence states
            switch (true) {
                // Case when there is no presence record for today (Check-in)
                case is_null($presence):
            
                    // Save the image to storage/app/public folder
                    $path = storage_path('app/public/presences/' . $photoName);
                    file_put_contents($path, $imageData);

                    $presence =Presence::create([
                            'employee_id' => $employeeId,
                            'eid' => $eid,
                            'employee_name' => $employeeName,
                            'work_day_id' => $request->workDay,
                            'date' => $datePhoto,
                            'check_in' => $timePhoto,
                            'late_check_in' => $lateCheckIn,
                            'late_arrival' => $lateArrival,
                            'note_in' => $request->note,
                            'photo_in' => $photoName,
                            'location_in' => $loc
                    ]);

                    $message = __('messages.late_check_in', ['minutes' => $lateCheckIn]);
                    break;
        
                // Case when the employee has checked in but not checked out (Check-out)
                case !is_null($presence->check_in) && is_null($presence->check_out):
                    $lastedWorkDay = $presence->work_day_id;
                    $lastWorkDay = WorkDay::find($lastedWorkDay)->where('day', $today)->first();
                    $forCheckIn = $lastWorkDay->check_in;
                    $forCheckOut = $lastWorkDay->check_out;
                    $break = $lastWorkDay->break;
                    
                    if($now && $check_out){
                        $cutStart = Carbon::parse($check_out->format('Y-m-d' . ' 12:00:00 '));
                        $cutEnd = Carbon::parse($check_out->format('Y-m-d' . ' 13:00:00 '));
            
                        switch(true) {
                            case $noCountLate:
                                $checkOutEarly = 0;
                                break;

                            case $excldueBreak:
                                $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)), 0);
                                break;

                            case $now->lt($forCheckIn):
                                $checkOutEarly = 0;
                                break;
            
                            case $now->lt($break_in):
                                $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false))-60, 0);
                                break;
                            
                            case $now->between($break_in, $break_out):
                                $checkOutEarly = max(intval($break_out->diffInMinutes($forCheckOut, false)), 4);
                                break;

                        
                            default:
                                $checkOutEarly = max(intval($now->diffInMinutes($forCheckOut, false)), 0);
                                break;
                        }
                    }
                    
                    // Save the image to storage/app/public folder
                    $path = storage_path('app/public/presences/' . $photoName);
                    file_put_contents($path, $imageData);

                    $presence->update([
                        'check_out' => now()->toTimeString(),
                        'check_out_early' => $checkOutEarly,
                        'note_out' => $request->note,
                        'photo_out' => $photoName,
                        'location_out' => $loc
                    ]);

                    $message = __('messages.early_check_out', ['minutes' => $checkOutEarly]);
                    break;
        
                // Case when both check-in and check-out are already recorded
                case !is_null($presence->check_in) && !is_null($presence->check_out):
                    $message = __('messages.already_check_in');
                    return redirect()->back()->with('error', $message);
                    break;
        
                // Default case to catch any unexpected scenarios
                default:
                    $message = __('messages.system_error');
                    return redirect()->back()->with('error', $message);
                    break;
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'redirectUrl' => route('employee.app') 
        ]);
    }

//Presences History
    public function history(Request $request){
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $employeeId = Auth::id();
        $employee = Employee::findOrFail($employeeId);
        $query = Presence::where('employee_id', $employeeId);
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }
        $presences = $query->get();
        return view('_employee_app.history', compact('presences'));
    }

//Overtime Form
    public function overtime(){
        $employeeId = Auth::id();
        $employee = Employee::with('workDay')->findOrFail($employeeId);
        // $workDay = $employee->workDay;
        $lokasi = $employee->officeLocations->first();
        $officeLatitude = $lokasi->latitude; 
        $officeLongitude = $lokasi->longitude;
        $radius = $lokasi->radius;

        return view('_employee_app.overtime.overtime_in', compact('employee', 'officeLatitude', 'officeLongitude', 'radius'));
    }

    public function overtimeOut(){
        $employeeId = Auth::id();
        $employee = Employee::with('workDay')->findOrFail($employeeId);
        // $workDay = $employee->workDay;
        $lokasi = $employee->officeLocations->first();
        $officeLatitude = $lokasi->latitude; 
        $officeLongitude = $lokasi->longitude;
        $radius = $lokasi->radius;

        return view('_employee_app.overtime.overtime_out', compact('employee', 'officeLatitude', 'officeLongitude', 'radius'));
    }

// Overtime Store
    public function overtimeStore(Request $request){
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

        if($maxRadius < $radius) {
            $message = 'Posisimu kadoan ' . $radiusKM . ' km seko pabrik, nek ora coba cek GPSmu!';
            // return redirect()->back()->with('error', $message);
            return response()->json([
                'success' => 'false',
                'message' => $message,
            ]);
        }

        //find existing overtime today
        $overtime = overtime::where('employee_id', $employeeId)
            ->where('date', $date)
            ->first();

        $parseTime = function($time) {
            return $time && $time !== 'N/A' ? Carbon::parse($time) : null;
        };

        $start_at = $overtime ? $parseTime ($overtime->start_at) : null ;
        $now = $parseTime (now()->toTimeString());
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

        // return redirect()->route('employee.app')->with('success', $message);
    }
    
//Overtime History
    public function overtimeHistory(Request $request){
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $employeeId = Auth::id();
        $query = Overtime::where('employee_id', $employeeId);
        if($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }
        $overtime = $query->get();

        return view('_employee_app.overtime-history', compact('overtime'));
    }

//Overtime
    public function profileIndex(){
        return view('_employee_app.profile.index');
    }

    
//Reset username
    public function resetUsername(){
        return view('_employee_app.profile.username');
    }

    public function resetUsernameStore(Request $request){
        $request->validate([
            'username' => 'required|string|regex:/^\S*$/|unique:employees,username',
            'currentPassword' => 'required|string',
        ],[
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
    public function resetPassword(){
        return view('_employee_app.profile.password');
    }

    public function resetPasswordStore(Request $request){
        // Validasi input
        $request->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:6',
            'confirmPassword' => 'required|string|same:newPassword',
        ],[
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
    public function leaveIndex() {
        $employeeId = Auth::id();
        $leaves = Presence::where('employee_id', $employeeId)->whereNotNull('leave')->get();
        return view('_employee_app.leave.index', compact('leaves'));
    }

    public function leaveApply() {
        $category = [
            PRESENCE::LEAVE_ANNUAL,
            PRESENCE::LEAVE_SICK,
            PRESENCE::LEAVE_FULL_DAY_PERMIT,
            PRESENCE::LEAVE_HALF_DAY_PERMIT,
        ];
        return view('_employee_app.leave.modal', compact('category'));
    }

    public function leaveStore(Request $request) {
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
            
        if($existLeave) {
            return redirect()->back()->withErrors(['leave_dates' => 'There have been applications for leave on several dates.']);
        }
        foreach ($leaveDates as $date) {
            $leave = Presence::create([
                'eid' => $eid,
                'employee_id' => $employeeId,
                'date' => $date,
                'leave' => $category,
                'leave_note' => $note,
            ]);
        }

        return redirect()->route('leave.index')->with('success', 'Cuti berhasil dibuat!');
    }
//Gaji
    public function payslipIndex() {
        return view('_employee_app.payslip.index');
    }
}
