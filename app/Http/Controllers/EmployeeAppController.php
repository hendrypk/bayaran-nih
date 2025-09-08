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
use App\Services\AttendanceService;
use App\Services\PresenceService;

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
            ->orderBy('created_at', 'desc')
            ->first();

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

        return view('_employee_app.index', compact('employee', 'workDay', 'presenceToday', 'leaveAccepted', 'pastPresence', 'chartData', 'overtimeToday'));
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

    private function storePhoto(string $imageBase64): string
    {
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageBase64);
        $imageData = base64_decode($imageData);

        // buat file sementara yang tetap ada
        $tempPath = tempnam(sys_get_temp_dir(), 'presence_') . '.jpg';
        file_put_contents($tempPath, $imageData);

        return $tempPath;
    }

    private function savePresencePhotoIn(Presence $presence, string $imageBase64): void
    {
        $tempPath = $this->storePhoto($imageBase64);
        $presence->addMedia($tempPath)
            ->toMediaCollection('presence-in');
    }

    private function savePresencePhotoOut(Presence $presence, string $imageBase64): void
    {
        $tempPath = $this->storePhoto($imageBase64);
        $presence->addMedia($tempPath)
            ->toMediaCollection('presence-out');
    }

    public function save(Request $request, PresenceService $presenceService)
    {
        $request->validate([
            'location' => 'required',
            'workDay' => 'required',
            'photo' => 'required|string'
        ], [
            'location.required' => __('messages.location_required'),
            'workDay.required' => __('messages.work_day_required'),
            'photo.required' => __('messages.photo_required'),
        ]);

        $day = strtolower(now()->format('l'));
        $workDayData = WorkDay::find($request->workDay)
            ->where('day', $day)
            ->first();
        
        //Get Office Location From Table
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

        // Validate radius
        if ($radius > $maxRadius) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.outside_radius', ['meters' => $radius]),
            ]);
        };

        if (!$workDayData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Work day data not found for today...',
            ], 404);
        }

        if($workDayData->day_off == 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hari ini adalah hari libur...',
            ], 404);
        };

        // Get work day times
        $parseTime = function ($time) {
            return $time && $time !== 'N/A' ? Carbon::parse($time) : null;
        };

        $arrival   = $workDayData?->arrival   ? $parseTime($workDayData->arrival)   : null;
        $check_in  = $workDayData?->check_in  ? $parseTime($workDayData->check_in)  : null;
        $check_out = $workDayData?->check_out ? $parseTime($workDayData->check_out) : null;
        $break_in  = $workDayData?->break_in  ? $parseTime($workDayData->break_in)  : null;
        $break_out = $workDayData?->break_out ? $parseTime($workDayData->break_out) : null;
        $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);
        $isCountLate = $workDayData->count_late;
        $excludeBreak = $workDayData->break;
        
        // Get today presence
        $today = now()->toDateString();
        $now   = $parseTime(now()->toTimeString());

        $presence = Presence::with('workDay')
            ->where('employee_id', Auth::id())
            ->where('date', $today)
            ->first();

        $presenceIn     = $presence?->check_in;
        $presenceOut    = $presence?->check_out;
        $presenceWorkDay = $presence?->workDay; 

        $pastPresence = Presence::where('employee_id', auth::id())
            ->where('date', '<', $today)
            ->orderByDesc('date')
            ->first();
        $pastPresenceIn = $pastPresence?->check_in;
        $pastPresenceOut = $pastPresence?->check_out;
        $dayCheckIn = $pastPresence->workDay->check_in;
        $dayCheckOut = $pastPresence->workDay->check_out;

        [$lateCheckIn, $lateArrival] = $presenceService->calculateLate(
            $now,
            $check_in,
            $check_out,
            $arrival,
            $break_in,
            $break_out,
            $breakDuration,
            $isCountLate,
            $excludeBreak
        );

        $earlyResult = $presenceService->calculateCheckOutEarly(
            $now,
            $break_in,
            $break_out,
            $isCountLate,
            $excludeBreak,
            $check_out,
            $check_in,
            $breakDuration
        );

        $lateCheckIn;
        $lateArrival;
        $earlyResult;
        $lateResult = [
            'lateCheckIn' => $lateCheckIn,
            'lateArrival' => $lateArrival,
            'checkOutEarly' => $earlyResult
        ];
        
        $message = '';

        switch (true) {
            case !is_null($pastPresence) && is_null($pastPresenceOut) && is_null($presence):
                $media = $this->savePresencePhotoOut($pastPresence, $request->photo);
                $fileName = $media->file_name ?? null;
                $pastPresence->update([
                    'check_out'       => now()->toTimeString(),
                    'check_out_early' => $lateResult['checkOutEarly'] ?? 0,
                    'location_out'    => $loc,
                    'photo_out'       => $fileName,
                ]);

                $message = __('messages.early_check_out', ['minutes' => $lateResult['checkOutEarly'] ?? 0]);
                break;

            case (!is_null($presenceIn) && is_null($presenceOut)) && !is_null($pastPresenceOut):
                $media = $this->savePresencePhotoOut($presence, $request->photo);
                $fileName = $media->file_name ?? null;
                $presence->update([
                    'check_out' => now()->toTimeString(),
                    'check_out_early' => $lateResult['checkOutEarly'] ?? 0,
                    'photo_out' => 'presence-out',
                    'location_out' => $loc
                ]);

                $message = __('messages.early_check_out', ['minutes' => $lateResult['checkOutEarly'] ?? 0]);
                break;

            case is_null($presence) || (!is_null($presence) && is_null($presence->leave_status)):
                $presence = Presence::updateOrCreate(
                    [
                        'employee_id' => Auth::id(),
                        'date' => $today,
                    ],
                    [
                        'work_day_id' => $request->workDay,
                        'check_in' => $now->toTimeString(),
                        'late_check_in' => $lateResult['lateCheckIn'] ?? 0,
                        'late_arrival' => $lateResult['lateArrival'] ?? 0,
                        'photo_in' => 'presence-in',
                        'location_in' => $loc,
                    ]
                );

                $media = $this->savePresencePhotoIn($presence, $request->photo);
                $fileName = $media->file_name ?? null;

                $message = __('messages.late_check_in', ['minutes' => $lateResult['lateCheckIn'] ?? 0]);
                break;

            case !is_null($presence) && !is_null($presenceIn) && !is_null($presenceOut):

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

    //try save presence with new logic
    public function savePresence(Request $request)
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
            
        //Calculate Late Arrival and Late Check In
        if ($now && $check_in) {
            list($lateCheckIn, $lateArrival) = $this->calculateLate($now, $check_in, $arrival, $break_in, $break_out, $breakDuration, $isCountLate, $excldueBreak);
        } else {
            $lateCheckIn = 0;
            $lateArrival = 0;
        }

        if($now && $check_out) {
            $checkOutEarly = $this->calculateCheckOutEarly($now, $check_in, $check_out, $break_in, $break_out, $isCountLate, $excldueBreak);
        } else {
            $checkOutEarly = 0;
        }
         
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


                //Calculate Early Check Out                
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


                $path = storage_path('app/public/presences/' . $photoName);
                file_put_contents($path, $imageData);

                $presence->update([
                    'check_out' => now()->toTimeString(),
                    'check_out_early' => $checkOutEarly,
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

    public function overtimeStore(Request $request)
    {
        $employeeId = Auth::id();
        $date = Carbon::now()->toDateString();

        $request->validate(['image' => 'required|string']);
        
        // Simpan foto
        $photoName = "$employeeId-$date-" . now()->format('His') . '.jpg';
        $imageData = base64_decode(str_replace('data:image/jpeg;base64,', '', $request->input('image')));
        $photoPath = storage_path("app/public/overtimes/$photoName");

        // Ambil lokasi kantor
        $office = OfficeLocation::where('name', $request->officeLocations)->firstOrFail();
        $latOffice = $office->latitude;
        $lonOffice = $office->longitude;
        $maxRadius = $office->radius;

        // Lokasi user
        [$latUser, $lonUser] = explode(',', $request->input('location'));
        $distance = $this->distance($latOffice, $lonOffice, $latUser, $lonUser);
        $radiusMeters = round($distance['meters']);

        if ($radiusMeters > $maxRadius) {
            return response()->json([
                'success' => false,
                'message' => 'Posisimu kadoan ' . round($distance['kilometers']) . ' km seko pabrik, nek ora coba cek GPSmu!',
            ]);
        }

        $overtime = Overtime::where('employee_id', $employeeId)
            ->where('date', $date)
            ->orderBy('created_at', 'desc')
            ->first();
            
        $now = now();

        file_put_contents($photoPath, $imageData);

        if($overtime && !$overtime->end_at) {
            $start = Carbon::parse($overtime->start_at);
            $totalMinutes = max($start->diffInMinutes($now, false), 0);

            $overtime->update([
                'end_at' => $now->toTimeString(),
                'photo_out' => $photoName,
                'note_out' => $request->note,
                'location_out' => $request->input('location'),
                'total' => $totalMinutes,
            ]);

            $message = __('messages.overtime_out_success');
        } else {

            Overtime::create([
                'employee_id' => $employeeId,
                'date' => $date,
                'start_at' => $now->toTimeString(),
                'photo_in' => $photoName,
                'note_in' => $request->note,
                'location_in' => $request->input('location'),
            ]);

            $message = __('messages.overtime_in_success');
        }


        // if (!$overtime || $overtime->end_at) {
        //     file_put_contents($photoPath, $imageData);

        //     Overtime::create([
        //         'employee_id' => $employeeId,
        //         'date' => $date,
        //         'start_at' => $now->toTimeString(),
        //         'photo_in' => $photoName,
        //         'note_in' => $request->note,
        //         'location_in' => $request->input('location'),
        //     ]);

        //     $message = __('messages.overtime_in_success');
        // } elseif ($overtime->start_at && !$overtime->end_at) {
        //     file_put_contents($photoPath, $imageData);

        //     $start = Carbon::parse($overtime->start_at);
        //     $totalMinutes = max($start->diffInMinutes($now, false), 0);

        //     $overtime->update([
        //         'end_at' => $now->toTimeString(),
        //         'photo_out' => $photoName,
        //         'note_out' => $request->note,
        //         'location_out' => $request->input('location'),
        //         'total' => $totalMinutes,
        //     ]);

        //     $message = __('messages.overtime_out_success');
        // }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'redirectUrl' => route('employee.app'),
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
        $employee = Auth::user();
        $eid = $employee->eid;

        $leaveDates = $request->input('leave_dates');
        $leaveDates = explode(',', $leaveDates[0]);
        $leaveDates = array_map('trim', $leaveDates);
        $category = $request->input('category');
        $note = $request->input('note');

        $existLeave = Presence::where('employee_id', $employeeId)
            ->whereIn('date', $leaveDates)
            ->whereNotNull('leave_status')
            ->pluck('date')->toArray();
        $existPresence = Presence::where('employee_id', $employeeId)
            ->whereIn('date', $leaveDates)
            ->whereNotNull('check_in')
            ->pluck('date')->toArray();
        
        $leaveCount = count($leaveDates);
        if ($category === Presence::LEAVE_ANNUAL) {
            if ($employee->annual_leave < $leaveCount) {
                return redirect()->back()->withErrors('Sisa cuti tahunan tidak mencukupi untuk pengajuan ini.');
            }
        }
        
        switch (true) {
            case $existLeave;
                return redirect()->back()->withErrors(['leave_dates' => 'Kamu punya pengajuan cuti/ijin pada tanggal tersebut']);
                break;
            case !empty($existPresence);
                return redirect()->back()->withErrors('Kamu masuk kerja pada tanggal tersebut');
                break;
            default;
                foreach ($leaveDates as $date) {
                    Presence::create([
                        'eid' => $eid,
                        'employee_id' => $employeeId,
                        'date' => $date,
                        'leave' => $category,
                        'leave_note' => $note,
                    ]);
                }
        }

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
        ], [
            'report_attachment.*.file' => 'Setiap file harus berupa file yang valid.',
            'report_attachment.*.mimes' => 'File harus berformat: jpg, jpeg, png, pdf, mp4, mov, avi, atau mkv.',
            'report_attachment.*.max' => 'Ukuran maksimal file adalah 5MB.',
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

    //direct upload profile
    public function upload(Request $request)
    {
        $request->validate(
            [
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            ],
            [
                'profile_photo.mimes' => 'Format invalid',
                'profile_photo.max' => 'Ukuran gambar terlalu besar, maksimal 5 MB',

            ]
        );

        $employee = Employee::find(Auth::id());
        // dd($id);
        if (!$employee->exists) {
        return back()->with('error', 'Employee not found.');
            }

        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
            $employee->clearMediaCollection('profile_photos');
            $employee->addMediaFromRequest('profile_photo')->toMediaCollection('profile_photos', 'public');
        }
                
        return back()->with('success', 'Foto berhasil diunggah!');
    }
}
