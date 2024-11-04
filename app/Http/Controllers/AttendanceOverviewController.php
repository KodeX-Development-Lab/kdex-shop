<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceOverviewController extends Controller
{
    //attendance overview
    public function attendanceOverview()
    {
        // permission
        if (!Auth::user()->can('view_attendance_overview')) {
            return back();
        }
        $employee = User::get();
        return view('employeeManagement.attendance.attendanceOverview', compact('employee'));
    }

    public function attendanceOverviewTable(Request $request)
    {
        // json blade attendance table data render
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
        $period = new CarbonPeriod($request->year . '-' . $request->month . '-' . '01', $request->year . '-' . $request->month . '-' . $numberOfDays);
        $employee = User::where('group', 'employee')->where('name', 'like', '%' . $request->userName . '%')->get();
        $company = CompanySetting::findOrFail(1);
        $check = Check::whereYear('date', $request->year)->whereMonth('date', $request->month)->get();
        return view('components.attendanceOverviwTable', compact('company', 'period', 'employee', 'check'))->render();
    }
}
