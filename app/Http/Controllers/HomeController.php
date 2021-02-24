<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

use App\Models\Domain;
use App\Models\Hosting;
use App\Models\User;
use App\Models\Notification;
use App\Models\Provider;
use App\Models\Domain_detail;
use App\Models\Hosting_detail;

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

        // return view('home.home', [
        //     'domain' => $domain,
        //     'hosting' => $hosting,
        //     'notification' => $notification,
        //     'user' => $user,
        //     'provider' => $provider,
        //     'domain_list' => $domain_list,
        //     'hosting_list' => $hosting_list,
        //     'cheapest_hosting' => $cheapest_hosting
        // ]);

        return view('home.home');
    }
}
