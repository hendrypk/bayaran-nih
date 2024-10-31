<?php

namespace App\Http\Controllers;

use App\Models\GradePa;
use App\Models\Employee;
use Illuminate\Http\Request;

class Test extends Controller
{
    public function test(){
        return view('test');        
    }

    
}
