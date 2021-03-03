<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use DateTime;

use App\Models\User;
use App\Models\Notification;
use App\Models\Content;

class HomeController extends Controller
{
    public function index()
    {
        // $notification = Notification::where('notification_status', 0)->count();
        // $domain = Domain::all()->count();
        // $hosting = Hosting::all()->count();
        // $user = User::all()->count();
        // $provider = Provider::all()->count();
        // $domain_list = Domain::orderBy('domain_name', 'asc')->get();
        // $hosting_list = Hosting::orderBy('hosting_type', 'asc')->get();

        // $cheapest_hosting =  Hosting_detail::join('hostings', 'hosting_details.hosting_detail_hosting_id', '=', 'hostings.hosting_id')
        //     ->join('providers', 'hosting_details.hosting_detail_provider_id', '=', 'providers.provider_id')
        //     ->where('hosting_detail_month', date('n'))
        //     ->where('hosting_detail_year', date('Y'))
        //     ->orderBy('hosting_detail_price', 'asc')
        //     ->limit(10)
        //     ->get();
        // $cheapest_hosting = (count($cheapest_hosting) != 0) ? $cheapest_hosting : NULL;

        $role = Session::get('user_role');
        $userId = Session::get('user_id');

        if ($role == "admin") {
            $total_target = User::select(User::raw('SUM(user_daily_target) as total_target'))->first();
            $total_user = User::count();

            return view('home.admin.home', ['total_target' => $total_target->total_target, 'total_user' => $total_user]);
        } else if ($role == "operator") {
            $user_register_interval = $this->countIntervalUserDays($userId);


            $daily_target = User::where('user_id', $userId)->select('user_daily_target as target')->first();
            $today_uploaded = Content::where('content_user_id', $userId)
                // ->where('content_status', __('content_status.content_status_success'))
                ->where('content_date', date('Y-m-d'))
                ->whereBetween('created_at', [date('Y-m-d') . " 08:00:00", date('Y-m-d') . " 17:00:00"])
                ->count();

            $today_upload_remaining = $daily_target->target - $today_uploaded;

            // if ($today_uploaded == 0) {
            //     $today_upload_remaining = $daily_target->target;
            // } else {
            //     $today_upload_remaining = $daily_target->target - $today_uploaded;
            // }

            return view('home.operator.home', ['daily_target' => $daily_target->target, 'today_upload_remaining' => $today_upload_remaining]);
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
