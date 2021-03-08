<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use DateTime;

use App\Models\User;
use App\Models\Notification;
use App\Models\Content;
use App\Models\Missed_upload;

class HomeController extends Controller
{
    public function index()
    {
        // $notification = Notification::where('notification_status', 0)->count();
        // $user = User::all()->count();

        $role = Session::get('user_role');
        $userId = Session::get('user_id');

        if ($role == "admin") {
            $total_target = User::select(User::raw('SUM(user_daily_target) as total_target'))->first();
            $total_user = User::where('user_role', '!=', 'admin')->count();

            return view('home.admin.home', ['total_target' => $total_target->total_target, 'total_user' => $total_user]);
        } else if ($role == "operator") {
            $daily_target = User::where('user_id', $userId)->select('user_daily_target as target')->first();
            $today_uploaded = Content::where('content_user_id', $userId)
                // ->where('content_status', __('content_status.content_status_success'))
                ->where('content_date', date('Y-m-d'))
                ->whereBetween('created_at', [date('Y-m-d') . " 08:00:00", date('Y-m-d') . " 17:00:00"])
                ->count();

            $today_upload_remaining = $daily_target->target - $today_uploaded;

            $total_upload_missed = Missed_upload::where('missed_upload_user_id', $userId)
                ->select(User::raw('SUM(missed_upload_total) as total_missed'))->first();

            $total_missed_day = Missed_upload::where('missed_upload_user_id', $userId)
                ->get()->groupBy(function ($item) {
                    return $item->missed_upload_date;
                })->count();

            return view('home.operator.home', ['total_missed_day' => $total_missed_day, 'daily_target' => $daily_target->target, 'today_upload_remaining' => $today_upload_remaining, 'total_upload_missed' => $total_upload_missed]);
        }
    }

    private function countIntervalUserDays($userId)
    {
        $user_registered_date = User::where('user_id', $userId)->first()->created_at;
        $date_now = date('Y-m-d H:i:s');

        $start_date = new DateTime($user_registered_date);
        $end_date = new DateTime($date_now);
        $interval = $start_date->diff($end_date);
        return $interval->days;
    }
}
