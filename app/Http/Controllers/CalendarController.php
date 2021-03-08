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
    public function detail($date)
    {
        echo $date;
    }

    public function get_data(Request $request)
    {
        $total_missed_day = Missed_upload::orderBy('missed_upload_date', 'desc')->get()->groupBy(function ($item) {
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
