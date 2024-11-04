<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CheckController extends Controller
{
    //check page
    public function check()
    {
        $scan = Hash::make(date('Y-m-d'));
        return view('checkin-checkout', compact('scan'));
    }

    // checkin
    public function checkInOut($pinCode)
    {
        if (now()->format('D') == 'Sat' || now()->format('D') == 'Sun') {
            return back()->with(['error' => 'Today is off day']);
        }
        $user = User::where('pin_code', $pinCode)->first();
        if (!$user) {
            return ['status' => 404, 'msg' => 'Pin code incorrect!'];
        }

        $check = Check::firstOrCreate([
            'user_id' => $user->id,
            'date' => now()->format('Y-m-d'),
        ]);

        if (is_null($check->checkin)) {
            Check::where('user_id', $user->id)->update(['checkin' => now()->format('H:i:s')]);
            return ['status' => 200, 'msg' => 'Successfully Check In' . now()];
        } elseif (is_null($check->checkout)) {
            Check::where('user_id', $user->id)->update(['checkout' => now()->format('H:i:s')]);
            return ['status' => 200, 'msg' => 'Successfully Check Out' . now()];
        }

        if (!is_null($check->checkin) && !is_null($check->checkin)) {
            return ['status' => 404, 'msg' => 'Already check in check out at today'];
        }

    }
}
