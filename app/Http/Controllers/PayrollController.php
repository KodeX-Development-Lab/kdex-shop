<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    //attendance overview
    public function payroll()
    {
        if (!Auth::user()->can('view_payroll')) {
            return back();
        }
        $employee = User::where('group', 'employee')->get();
        return view('employeeManagement.payroll.payroll', compact('employee'));
    }

    public function payrollFilter(Request $request)
    {
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
        $month = $request->month;
        $year = $request->year;
        $period = new CarbonPeriod($request->year . '-' . $request->month . '-' . '01', $request->year . '-' . $request->month . '-' . $numberOfDays);
        $request->userName ? $employee = User::where('group', 'employee')->where('name', $request->userName)->get() : $employee = User::where('group', 'employee')->get();
        $company = CompanySetting::findOrFail(1);
        $workingDay = Carbon::parse($request->year . '-' . $request->month . '-' . '01')->diffInDaysFiltered(function ($date) {
            return $date->isWeekday();
        }, Carbon::parse($request->year . '-' . $request->month . '-' . $numberOfDays));
        $check = Check::whereYear('date', $request->year)->whereMonth('date', $request->month)->get();
        return view('components.management.payrollTable', compact('company', 'numberOfDays', 'month', 'year', 'period', 'workingDay', 'employee', 'check'))->render();
    }
}
