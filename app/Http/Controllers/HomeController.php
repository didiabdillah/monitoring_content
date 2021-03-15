<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use DateTime;
use Illuminate\Support\Facades\DB;

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

            if ($total_upload_missed->total_missed == NULL) {
                $total_upload_missed->total_missed = 0;
            }

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

    public function user_missed(Request $request)
    {
        $missed_upload =  Missed_upload::select('user_name', Missed_upload::raw('SUM(missed_upload_total) as total'))
            ->join('users', 'missed_uploads.missed_upload_user_id', '=', 'users.user_id')
            ->groupBy('users.user_name')
            ->groupBy('users.user_id')
            ->orderBy('users.user_name', 'asc')
            ->get();

        $missed_upload = (count($missed_upload) != 0) ? $missed_upload : NULL;

        return view('home.list_template.user_missed_list', ['missed_upload' => $missed_upload]);
    }

    public function content_chart(Request $request)
    {
        die;
        $domain = Domain::where('domain_id', $domain_id)->first();

        $provider = Provider::where('provider_id', $provider_id)->first();

        $chart = [];
        for ($i = 0; $i <= 6; $i++) {
            $data = Domain_detail::where('domain_detail_domain_id', $domain_id)
                ->where('domain_detail_provider_id', $provider_id)
                ->where('domain_detail_month', date('n', strtotime("-" . $i . "months")))
                ->where('domain_detail_year', date('Y', strtotime("-" . $i . "months")))
                ->latest('created_at')
                ->first();

            if ($data == null) {
                $chart[$i] = 0;
            } else {
                $chart[$i] = $data->domain_detail_price;
            }
        }

        $chart_data['chartData'] = [
            $chart[6],
            $chart[5],
            $chart[4],
            $chart[3],
            $chart[2],
            $chart[1],
            $chart[0],
        ];

        $chart_data['providerName'] = $provider->provider_name;

        $chart_data['domainName'] = $domain->domain_name;

        return json_encode($chart_data);
    }
}
