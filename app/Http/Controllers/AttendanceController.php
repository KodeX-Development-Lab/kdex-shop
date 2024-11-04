<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\createAttendance;
use App\Http\Requests\updateAttendance;
use App\Models\Check;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{

    public function index()
    {
        // permission
        if (!Auth::user()->can('view_attendance')) {
            return back();
        }
        // year for filter
        $year = [date('Y')];
        for ($i = 1; $i < 5; $i++) {
            $year[] = date('Y', strtotime("-$i year"));
        }
        return view('employeeManagement.attendance.index', compact('year'));
    }

    public function create()
    {
        // permission
        if (!Auth::user()->can('create_attendance')) {
            return back();
        }
        // json blade create attendance form render
        $user = User::all();
        return view('components.createAttendanceForm', compact('user'))->render();
    }

    // all employee attendance
    public function dataTable(Request $request)
    {

        $check = Check::with('user');
        if ($request->month) {
            $check = $check->whereMonth('date', $request->month);
        }
        if ($request->year) {
            $check = $check->whereYear('date', $request->year);
        }

        return DataTables::of($check)
            ->addColumn('employee', function ($each) {
                return $each->user->name;
            })
            ->filterColumn('employee', function ($query, $keyword) {
                $query->whereHas('user', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('check', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })
            ->addColumn('action', function ($each) {
                return '<a href="" data-id="' . $each->id . '" class="editBtn btn btn-sm btn-info"  data-toggle="modal" data-target=".editModel"><i class=" fas fa-edit"></i></a>
        <a href="" data-id="' . $each->id . '" class="deleteBtn btn btn-sm btn-danger"><i class=" fas fa-trash-alt"></i></a>';
            })
            ->rawColumns(['check', 'action'])
            ->make(true);
    }

    // my attendance overview
    public function myAttendanceOverview(Request $request)
    {
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
        $period = new CarbonPeriod($request->year . '-' . $request->month . '-' . '01', $request->year . '-' . $request->month . '-' . $numberOfDays);
        $employee = User::where('id', Auth::user()->id)->first();
        $company = CompanySetting::findOrFail(1);
        $check = Check::whereYear('date', $request->year)->whereMonth('date', $request->month)->get();
        return view('components.myAttendnaceOverview', compact('company', 'period', 'employee', 'check'))->render();
    }

    // my attendance
    public function myAttendance(Request $request)
    {
        $check = Check::where('user_id', Auth::user()->id);
        if ($request->month) {
            $check = $check->whereMonth('date', $request->month);
        }
        if ($request->year) {
            $check = $check->whereYear('date', $request->year);
        }
        return DataTables::of($check)
            ->addColumn('employee', function ($each) {
                return $each->user->name;
            })
            ->filterColumn('employee', function ($query, $keyword) {
                $query->whereHas('user', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->make(true);
    }

    // create attendance
    public function store(createAttendance $request)
    {
        // permission
        if (!Auth::user()->can('create_attendance')) {
            return back();
        }
        $check = Check::where('user_id', $request->user_id)->where('date', $request->date)->first();
        if ($check) {
            return back()->with(['error' => 'Already defined']);
        }
        Check::firstOrCreate([
            'user_id' => $request->user_id,
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
        ], [
            'checkin' => Carbon::parse($request->checkin)->format('H:i:s'),
            'checkout' => Carbon::parse($request->checkout)->format('H:i:s'),
        ]);

        return back()->with(['success' => 'Check Successfully created']);
    }

    // attendance edit
    public function edit(string $id)
    {
        // permission
        if (!Auth::user()->can('edit_attendance')) {
            return back();
        }
        // json blade  edit attendance form render
        $user = User::all();
        $check = Check::where('id', $id)->first();
        return view('components.cupdateAttendanceForm', compact('user', 'check'))->render();
    }

    // attendance update
    public function updateAttendance(updateAttendance $request)
    {
        // permission
        if (!Auth::user()->can('edit_attendance')) {
            return back();
        }
        Check::where('id', $request->id)->update([
            'user_id' => $request->user_id,
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'checkin' => Carbon::parse($request->checkin)->format('H:i:s'),
            'checkout' => Carbon::parse($request->checkout)->format('H:i:s'),
        ]);

        return back()->with(['success' => 'Employee Attendance successfully updated']);
    }

    public function destroy(string $id)
    {
        // permission
        if (!Auth::user()->can('delete_attendance')) {
            return back();
        }
        Check::where('id', $id)->delete();
        return 'success';
    }

    // deleteSelectedAttendance
    public function deleteSelectedAttendance(Request $request)
    {
        // permission
        if (!Auth::user()->can('delete_attendance')) {
            return back();
        }
        Check::whereIn('id', $request->ids)->delete();
        return 'success';
    }
}
