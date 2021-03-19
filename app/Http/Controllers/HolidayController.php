<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Holiday;

class HolidayController extends Controller
{
    //content List
    public function index()
    {
        $holiday = Holiday::orderBy('holiday_date', 'asc')
            ->orderBy('holiday_event', 'asc')
            ->get();

        return view('holiday.holiday', ['holiday' => $holiday]);
    }

    public function insert()
    {
        return view('holiday.insert');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'event'  => 'required|max:255',
                'date'  => 'required',
            ]
        );

        $event = htmlspecialchars($request->event);
        $date = htmlspecialchars($request->date);
        $user_id = $request->session()->get('user_id');

        //Insert Data
        $data = [
            'holiday_event' => $event,
            'holiday_date' => $date,
        ];
        Holiday::create($data);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Add Success', //Alert Message 
            'New Holiday Event Added' //Sub Alert Message
        );

        return redirect()->route('holiday');
    }

    public function edit($id)
    {
        $holiday = Holiday::find($id);

        return view('holiday.edit', ['holiday' => $holiday]);
    }

    public function update(Request $request, $id)
    {
        // Input Validation
        $request->validate(
            [
                'event'  => 'required|max:255',
                'date'  => 'required',
            ]
        );

        $event = htmlspecialchars($request->event);
        $date = htmlspecialchars($request->date);
        $user_id = $request->session()->get('user_id');

        //UpdateData
        $data = [
            'holiday_event' => $event,
            'holiday_date' => $date,
        ];

        Holiday::where('holiday_id', $id)
            ->update($data);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Update Success', //Alert Message 
            'Holiday Updated' //Sub Alert Message
        );

        return redirect()->route('holiday');
    }

    public function destroy($id)
    {
        Holiday::destroy('holiday_id', $id);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Remove Success', //Alert Message 
            'Holiday Removed' //Sub Alert Message
        );

        return redirect()->route('holiday');
    }
}
