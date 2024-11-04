<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    //notifications
    public function notifications($id)
    {
        $user = User::where('id', $id)->first();
        $notification = $user->notifications()->paginate(4);
        return response()->json([
            'notification' => $notification,
            'notiCount' => count($user->unreadNotifications),
        ]);
    }

    // notification
    public function notification(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $noti = $user->notifications()->where('id', $request->noti)->first();
        $noti->markAsRead();
        return response()->json([
            'notification' => $noti,
            'notiCount' => count($user->unreadNotifications),
        ]);
    }
}
