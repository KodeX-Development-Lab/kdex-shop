<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TransferNotificationCOntroller extends Controller
{
    //transferNotification page
    public function transferNotification()
    {
        $notification = Auth::user()->notifications()->paginate(4);
        return view('transferNotification', compact('notification'));
    }
    // transferNotificationDetail
    public function transferNotificationDetail($id)
    {
        $notification = Auth::user()->notifications->where('id', $id)->first();
        $notification->markAsRead();
        return view('transferNotificationDetail', compact('notification'));
    }
}
