<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

use App\Models\Notification;
use App\Models\Missed_upload;

class CalendarController extends Controller
{
    //Calendar
    public function index()
    {
        return view('calendar.calendar');
    }

    public function detail($date)
    {
        // $data = Missed_upload::join('users', 'missed_uploads.missed_upload_user_id', '=', 'users.user_id')
        //     ->select('missed_uploads.*', 'users.user_name', 'users.user_image')
        //     ->where('missed_uploads.missed_upload_date', $date)
        //     ->orderBy('missed_uploads.created_at', 'asc')
        //     ->get();

        $data =  Missed_upload::join('users', 'missed_uploads.missed_upload_user_id', '=', 'users.user_id')
            ->select('users.user_name', 'users.user_image as avatar', Missed_upload::raw('SUM(missed_upload_total) as total', 'missed_upload_date'))
            ->where('missed_uploads.missed_upload_date', $date)
            ->groupBy('users.user_name')
            ->groupBy('users.user_image')
            ->groupBy('users.user_id')
            ->orderBy('users.user_name', 'asc')
            ->get();

        return view('calendar.detail', ['data' => $data]);
    }

    public function get_data(Request $request)
    {
        $total_missed_day = Missed_upload::where('missed_upload_total', '!=', 0)
            ->orderBy('missed_upload_date', 'desc')->get()->groupBy(function ($item) {
                return $item->missed_upload_date;
            });

        $data = [];
        $no = 1;
        foreach ($total_missed_day as $tmd) {
            $data[] = [
                'title' => 'Missed : ' . $tmd->count(),
                'start' => $tmd[0]->missed_upload_date,
                'backgroundColor' => '#f56954',
                'borderColor' => '#f56954',
                'url' => route('calendar_detail', $tmd[0]->missed_upload_date),
                'allDay' => true,
            ];
            $no++;
        }
        return json_encode($data);

        // {
        //     title: 'All Day Event',
        //     start: '2021-03-01',
        //     backgroundColor: '#f56954', //red
        //     borderColor: '#f56954', //red
        //     url: 'https://www.google.com/',
        //     allDay: true
        // }
    }
}
