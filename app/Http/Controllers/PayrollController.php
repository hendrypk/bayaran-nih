<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollOption;

class PayrollController extends Controller
{
    public function payrollOption(){
        $options = PayrollOption::get();
        return view('payroll.option', compact('options'));

    }
}
