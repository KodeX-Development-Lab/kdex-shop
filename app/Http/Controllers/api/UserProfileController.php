<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{

//  change password ==================================================>
    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
        ]);
        $user = User::where('id', $request->id)->first();
        if (Hash::check($request->oldPassword, $user->password)) {
            $user->update(['password' => $request->newPassword]);
            return response()->json([
                'status' => 'success',
                'msg' => 'Password Change Successfully',
            ]);
        }
        return response()->json([
            'status' => 'fail',
            'msg' => 'Current Password Incorrect',
        ]);
    }

//  edit profile =====================================================>
    public function editProfile(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $request->validate([
            'name' => 'required',
            'phone' => 'required|min:9|unique:users,phone,' . $user->id,
            'address' => 'required',
        ]);
        $data = $this->profileData($request);
        if ($request->hasFile('image')) {
            $image = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $image);
            $data['image'] = $image;
        } else {
            $data['image'] = $user->image;
        }
        $user->update($data);
        return response()->json([
            'status' => 'success',
            'msg' => 'Profile update successfully',
        ]);

    }

//  data for profile ====================================================>
    private function profileData($request)
    {
        return [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }

}
