<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    //index
    public function index(){
        $job_titles = Option::where('type', 'job_title');
        $positions = Option::where('type', 'position');
        $divisions = Option::where('type', 'division');
        $departments = Option::where('type', 'department');
        $statuses = Option::where('type', 'status');
        return view('option.index', compact('job_titles', 'positions', 'divisions', 'departments', 'statuses'));
    }
}
