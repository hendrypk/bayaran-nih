<?php

namespace App\Http\Controllers;

use App\Models\WorkDay;
use Illuminate\Http\Request;

class WorkDayController extends Controller
{
//Work Day List
    public function index(){
        $workDays = WorkDay::select('name')->groupBy('name')->get();
        return view('work_day.index', compact('workDays'));
    }

//Work Day Detail
public function detail($name) {
    // Ambil semua work days dengan nama yang sama
    $workDays = WorkDay::where('name', $name)->get();
    
    return view('work_day.detail', compact('workDays'));
}

//Work Day Edit
public function edit(Request $request, $name) {
    // Ambil semua work days dengan nama yang sama
    $workDays = WorkDay::where('name', $name)->get();
    
    return view('work_day.edit', compact('workDays', 'name'));
}

//Work Day Update
public function update(Request $request, $name) {
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
