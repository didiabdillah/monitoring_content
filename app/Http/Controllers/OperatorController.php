<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Models\User;
use App\Models\Missed_upload;
use App\Models\Content;

class OperatorController extends Controller
{
    //Operator
    public function index()
    {
        $user = User::where('user_role', '!=', 'admin')
            ->where('user_id', '!=', Session::get('user_id'))->orderBy('user_name', 'asc')->get();

        return view('operator.operator', ['user' => $user]);
    }

    public function insert()
    {
        $user = User::orderBy('user_name', 'asc')->get();

        return view('operator.insert', ['user' => $user]);
    }

    public function store(Request $request)
    {
        // Input Validation
        $request->validate(
            [
                'name'  => 'required|max:255',
                'email'  => 'required|max:255',
                'phone'  => 'required|max:15|min:11',
                'password'  => 'required|max:100|min:8',
                'daily_target'  => 'required|numeric',
            ]
        );

        $id = str_replace('-', '', Str::uuid());
        $name = htmlspecialchars($request->name);
        $email = htmlspecialchars($request->email);
        $phone = htmlspecialchars($request->phone);
        $password = htmlspecialchars($request->password);
        $daily_target = htmlspecialchars($request->daily_target);
        $image = "default.jpg";

        //check is email exist in DB
        if (User::where('user_email', $email)->count() > 0) {
            //Flash Message
            flash_alert(
                __('alert.icon_error'), //Icon
                'Add Failed', //Alert Message 
                'User Email Already Exist' //Sub Alert Message
            );

            return redirect()->back();
        }

        //check is phone number exist in DB
        if (User::where('user_phone', $phone)->count() > 0) {
            //Flash Message
            flash_alert(
                __('alert.icon_error'), //Icon
                'Add Failed', //Alert Message 
                'Phone Number Already Exist' //Sub Alert Message
            );

            return redirect()->back();
        }

        $data = [
            'user_id' => $id,
            'user_password' => Hash::make($password),
            'user_name' => $name,
            'user_email' => $email,
            'user_phone' => $phone,
            'user_daily_target' => $daily_target,
            'user_role' => 'operator',
            'user_image' => $image,
        ];

        //Insert Data
        User::create($data);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Add Success', //Alert Message 
            'User Added' //Sub Alert Message
        );

        return redirect()->route('operator');
    }

    public function edit($id)
    {
        $user = User::where('user_id', $id)->first();

        return view('operator.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        // Input Validation
        if (htmlspecialchars($request->password) != NULL) {
            $request->validate([
                'name'  => 'required|max:255',
                'email'  => 'required|max:255',
                'phone'  => 'required|max:15|min:11',
                'password'  => 'max:100|min:8',
                'daily_target'  => 'required|numeric',
            ]);
        } else {
            $request->validate([
                'name'  => 'required|max:255',
                'email'  => 'required|max:255',
                'phone'  => 'required|max:15|min:11',
                'daily_target'  => 'required|numeric',
            ]);
        }

        $user = User::where('user_id', $id)->first();

        $name = htmlspecialchars($request->name);
        $email = htmlspecialchars($request->email);
        $phone = htmlspecialchars($request->phone);
        $daily_target = htmlspecialchars($request->daily_target);
        $password = (htmlspecialchars($request->password) != NULL) ? Hash::make($request->password) : $user->user_password;

        //check is Email exist in DB
        if (User::where('user_email', $email)->where('user_id', '!=', $user->user_id)->count() > 0) {
            //Flash Message
            flash_alert(
                __('alert.icon_error'), //Icon
                'Update Failed', //Alert Message 
                'Email Already Exist' //Sub Alert Message
            );

            return redirect()->back();
        }

        //check is Phone Number exist in DB
        if (User::where('user_phone', $phone)->where('user_id', '!=', $user->user_id)->count() > 0) {
            //Flash Message
            flash_alert(
                __('alert.icon_error'), //Icon
                'Update Failed', //Alert Message 
                'Phone Number Already Exist' //Sub Alert Message
            );

            return redirect()->back();
        }

        $data = [
            'user_password' => $password,
            'user_name' => $name,
            'user_email' => $email,
            'user_phone' => $phone,
            'user_daily_target' => $daily_target,
        ];

        //Update Data
        User::where('user_id', $id)
            ->update($data);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Update Success', //Alert Message 
            'User Updated' //Sub Alert Message
        );

        return redirect()->route('operator');
    }

    public function destroy($id)
    {
        $destination = "assets/img/profile/";

        $imageOld =  User::where('user_id', $id)->first();
        $image_path = public_path($destination . $imageOld->user_image);

        User::destroy('user_id', $id);

        if ($imageOld->user_image != "default.jpg") {
            File::delete($image_path);
        }

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Remove Success', //Alert Message 
            'User Removed' //Sub Alert Message
        );

        return redirect()->route('operator');
    }

    //Operator Detail
    public function detail($id)
    {
        $user = User::where('user_id', $id)->first();

        $userId = $id;

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


        return view('operator.detail', ['user' => $user, 'total_missed_day' => $total_missed_day, 'daily_target' => $daily_target->target, 'today_upload_remaining' => $today_upload_remaining, 'total_upload_missed' => $total_upload_missed]);
    }
}
