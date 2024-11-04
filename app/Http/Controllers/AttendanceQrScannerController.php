<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Check;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AttendanceQrScannerController extends Controller
{
    // attendance qr scanner
    public function attendanceScan()
    {
        // permission
        if (!Auth::user()->can('view_QrScan')) {
            return back();
        }
        return view('employeeManagement.attendanceScan');
    }

    //    attendance scan store
    public function attendanceScanStore(Request $request)
    {

        if (now()->format('D') == 'Sat' || now()->format('D') == 'Sun') {
            return back()->with(['error' => 'Today is off day']);
        }

        if (!Hash::check(date('Y-m-d'), $request->value)) {
            return back()->with(['error' => 'Your Qr Code is wrong']);
        }

        $check = Check::firstOrCreate([
            'user_id' => Auth::user()->id,
            'date' => now()->format('Y-m-d'),
        ]);

        if (is_null($check->checkin)) {
            Check::where('user_id', Auth::user()->id)->update(['checkin' => Carbon::parse($request->date)->format('H:i:s')]);
            return ['status' => 200, 'msg' => 'Successfully Check In' . now()];
        } elseif (is_null($check->checkout)) {
            Check::where('user_id', Auth::user()->id)->update(['checkout' => Carbon::parse($request->date)->format('H:i:s')]);
            return ['status' => 200, 'msg' => 'Successfully Check Out' . now()];
        }

        if (!is_null($check->checkin) && !is_null($check->checkin)) {
            return ['status' => 404, 'msg' => 'Already check in check out at today'];
        }
    }
}
