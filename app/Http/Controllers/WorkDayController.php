<?php

namespace App\Http\Controllers;

use App\Models\WorkDay;
use App\Models\WorkScheduleDay;
use App\Models\WorkScheduleGroup;
use Illuminate\Http\Request;

class WorkDayController extends Controller
{
//Work Day List
    public function index(){
        $workDays = WorkScheduleGroup::all();
        return view('work_day.index', compact('workDays'));
    }

//Work Day Detail
public function detail($name) {
    // Ambil semua work days dengan nama yang sama
    $workDays = WorkScheduleGroup::with('days')->where('name', $name)->firstOrFail();

    return view('work_day.detail', compact('workDays'));
}

//Work Day Edit
public function edit(Request $request, $id) {
    // Ambil semua work days dengan id yang sama
    $workDays = WorkScheduleGroup::with('days')->findOrFail($id);
    $name = $workDays->name;

    return view('work_day.edit', compact('workDays', 'name'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'tolerance' => 'nullable|integer',
        'countLate' => 'nullable|integer',
        'dayOff' => 'array',
        'arrival' => 'array',
        'checkIn' => 'array',
        'checkOut' => 'array',
        'break' => 'array',
    ]);

    // Ambil group berdasarkan id
    $group = WorkScheduleGroup::findOrFail($id);

    // Update data group
    $group->update([
        'name'       => $request->name,
        'tolerance'  => $request->tolerance ?? 0,
        'count_late' => $request->countLate ?? 0,
    ]);

    // Update tiap hari
    foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
        WorkScheduleDay::updateOrCreate(
             [
                'work_schedule_group_id' => $group->id,
                'day' => $day
            ],
            [
                'is_offday'   => isset($request->dayOff[$day]) ? 1 : 0,
                'count_break'     => isset($request->break[$day]) ? 1 : 0,
                'arrival'   => isset($request->dayOff[$day]) ? null : ($request->arrival[$day] ?? null),
                'start_time'  => isset($request->dayOff[$day]) ? null : ($request->checkIn[$day] ?? null),
                'end_time' => isset($request->dayOff[$day]) ? null : ($request->checkOut[$day] ?? null),
                'break_start'  => isset($request->dayOff[$day]) ? null : ($request->breakIn[$day] ?? null),
                'break_end' => isset($request->dayOff[$day]) ? null : ($request->breakOut[$day] ?? null),
            ]
        );
    }

    return redirect()->route('workDay.edit', [$id])->with('success', 'Work day schedule updated successfully!');
}

//Work Day Update
public function updateOld(Request $request, $name) {
    $id = $request->id;
    $workDays = WorkDay::where('name', $name)->get();
    $newName = $request->input('name');

    foreach ($workDays as $workDay) {
        $workDay->update([
            'name' => $request->input('name'),
            'day_off' => $request->has("dayOff.{$workDay->day}") ? 1 : 0,
            'tolerance' => $request->input('tolerance') ?? 0,
            'count_late' => $request->input('countLate'),
            'arrival' => $request->has("dayOff.{$workDay->day}") ? null : $request->input("arrival.{$workDay->day}"),
            'check_in' => $request->has("dayOff.{$workDay->day}") ? null : $request->input("checkIn.{$workDay->day}"),
            'check_out' => $request->has("dayOff.{$workDay->day}") ? null : $request->input("checkOut.{$workDay->day}"),
            'break_in' => $request->has("dayOff.{$workDay->day}") ? null : $request->input("breakIn.{$workDay->day}"),
            'break_out' => $request->has("dayOff.{$workDay->day}") ? null : $request->input("breakOut.{$workDay->day}"),
            'break' => $request->input("break.{$workDay->day}") == '1' ? 1 : 0,
        ]);
    }
    return redirect()->route('workDay.edit', [$newName])->with('success', 'Work Day updated successfully.');
}

//Add New Work Day
public function create(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'tolerance' => 'nullable|integer',
        'countLate' => 'nullable|integer',
        'dayOff' => 'array',
        'arrival' => 'array',
        'checkIn' => 'array',
        'checkOut' => 'array',
        'break' => 'array',
    ]);

    // Buat atau update group
    $group = WorkScheduleGroup::updateOrCreate(
        ['name' => $request->name], // kunci unik
        [
            'tolerance' => $request->tolerance ?? 0,
            'count_late' => $request->countLate ?? 0,
        ]
    );

    // Loop semua hari
    foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
        WorkScheduleDay::updateOrCreate(
            [
                'work_schedule_group_id' => $group->id,
                'day' => $day
            ],
            [
                'is_offday'   => isset($request->dayOff[$day]) ? 1 : 0,
                'count_break'     => isset($request->break[$day]) ? 1 : 0,
                'arrival'   => isset($request->dayOff[$day]) ? null : ($request->arrival[$day] ?? null),
                'start_time'  => isset($request->dayOff[$day]) ? null : ($request->checkIn[$day] ?? null),
                'end_time' => isset($request->dayOff[$day]) ? null : ($request->checkOut[$day] ?? null),
                'break_start'  => isset($request->dayOff[$day]) ? null : ($request->breakIn[$day] ?? null),
                'break_end' => isset($request->dayOff[$day]) ? null : ($request->breakOut[$day] ?? null),
            ]
        );
    }

    return redirect()->route('workDay.index')->with('success', 'Work day schedule saved successfully!');
}


public function createOld(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'tolerance' => 'nullable|integer',
        'countLate' => 'nullable|integer',
        'dayOff' => 'array',
        'arrival' => 'array',
        'checkIn' => 'array',
        'checkOut' => 'array',
        'break' => 'array',
    ]);

    // Simpan data untuk setiap hari
    foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
        $workDay = new WorkDay();
        $workDay->name = $request->name;
        $workDay->tolerance = $request->tolerance;
        $workDay->count_late = $request->countLate;
        $workDay->day = $day;
        $workDay->day_off = isset($request->dayOff[$day]) ? 1 : 0;
        $workDay->break = isset($request->break[$day]) ? 1 : 0;

        // Cek apakah ada nilai untuk arrival, checkIn, checkOut
        $workDay->arrival = isset($request->dayOff[$day]) ? null : ($request->arrival[$day] ?? null);
        $workDay->check_in = isset($request->dayOff[$day]) ? null : ($request->checkIn[$day] ?? null);
        $workDay->check_out = isset($request->dayOff[$day]) ? null : ($request->checkOut[$day] ?? null);
        $workDay->break_in = isset($request->dayOff[$day]) ? null : ($request->breakIn[$day] ?? null);
        $workDay->break_out = isset($request->dayOff[$day]) ? null : ($request->breakOut[$day] ?? null);

        $workDay->save();
    }
    return redirect()->route('workDay.index')->with('success', 'Work day schedule saved successfully!');
}

//Work Day Delete
    public function delete(Request $request, $name){
        $workDays = WorkDay::where('name', $name)->delete();
        return response()->json([
            'success' => true,
            'message' => 'The location has been deleted.',
            'redirect' => route('workDay.index')
        ]);
    }


}
