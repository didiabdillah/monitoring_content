<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

use App\Models\Notification;

class NotificationController extends Controller
{
    //Notification
    public function index()
    {
        Notification::where('notification_status', 0)->where('notification_user_id', Session::get('user_id'))->update(['notification_status' => 1]);

        $notification = Notification::orderBy('created_at', 'desc')
            ->where('notification_user_id', Session::get('user_id'))
            ->paginate(10);

        return view('notification.notification', ['notification' => $notification]);
    }
}
