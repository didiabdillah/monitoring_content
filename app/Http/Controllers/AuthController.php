<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Setting;
use App\Models\Forgot_token;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $setting = Setting::where('setting_id', 1)->first();

        $logo = ($setting) ? $setting->setting_logo : 'default-logo.png';

        return view('auth.login', ['logo' => $logo]);
    }

    public function login_process(Request $request)
    {
        //Validation Form
        $request->validate(
            [
                'login_email'  => 'required|email:rfc,dns|max:255',
                'login_password'  => 'required|max:100|min:8',
            ],
            [
                'login_password.required' => 'The password field is required.',
                'login_email.required' => 'The email field is required.',
                'login_email.email' => 'The email field is wrong format.'
            ]
        );

        $email = htmlspecialchars($request->login_email);
        $password = htmlspecialchars($request->login_password);
        $remember = htmlspecialchars($request->remember);

        $user = User::firstWhere('user_email', $email);

        //Check Email Account Available
        if ($user) {
            //Check Email Match
            if ($email == $user->user_email) {
                //Check Password Match
                if (Hash::check($password, $user->user_password)) {
                    //Check Remember Me
                    if ($remember != NULL) {
                        //Create Cookie
                        Cookie::queue(Cookie::make('account', $user->user_email, 60 * 24));
                        Cookie::queue(Cookie::make('access', $user->user_role, 60 * 24));
                    }

                    //Create Session
                    $data = [
                        'user_id' => $user->user_id,
                        'user_name' => $user->user_name,
                        'user_email' => $user->user_email,
                        'user_role' => $user->user_role,
                        'user_image' => $user->user_image
                    ];
                    $request->session()->put($data);

                    //Goto User Home
                    return redirect()->route('home');
                } else {
                    // Flash Message
                    flash_alert(
                        __('alert.icon_error'), //Icon
                        'Login Failed', //Alert Message 
                        'Wrong Password' //Sub Alert Message
                    );

                    return redirect()->back();
                }
            } else {
                //Flash Message
                flash_alert(
                    __('alert.icon_error'), //Icon
                    'Login Failed', //Alert Message 
                    'Wrong Email' //Sub Alert Message
                );

                return redirect()->back();
            }
        } else {
            //Flash Message
            flash_alert(
                __('alert.icon_error'), //Icon
                'Login Failed', //Alert Message 
                'Account Not Found' //Sub Alert Message
            );

            return redirect()->back();
        }

        //If Bug Not Through Filtering Process Above
        //Flash Message
        flash_alert(
            __('alert.icon_error'), //Icon
            'Login Failed', //Alert Message 
            'Something Wrong' //Sub Alert Message
        );

        return redirect()->back();
    }

    public function logout()
    {
        //Clean Session
        Session::flush();

        //Clean Cookie
        Cookie::queue(Cookie::forget('account'));

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Logout Success', //Alert Message 
            'Login Again For Start Application' //Sub Alert Message
        );

        //Back To Login
        return redirect()->route('login');
    }

    public function forgot_password()
    {
        $setting = Setting::where('setting_id', 1)->first();

        $logo = ($setting) ? $setting->setting_logo : 'default-logo.png';

        return view('auth.forgot_password', ['logo' => $logo]);
    }

    public function forgot_password_process(Request $request)
    {
        //Validation Form
        $request->validate(
            [
                'email'  => 'required|email:rfc,dns|max:255',
            ],
            [
                'email.required' => 'The email field is required.',
                'email.email' => 'The email field is wrong format.'
            ]
        );

        $email = htmlspecialchars($request->email);

        $user = User::where('user_email', $email)->first();

        // Check is email exist
        if (!$user) {
            //Flash Message
            flash_alert(
                __('alert.icon_error'), //Icon
                'Failed', //Alert Message 
                'Email Not Found' //Sub Alert Message
            );

            return redirect()->back();
        }

        $token = Str::uuid();
        $data = $user->toArray();
        $data["token"] = ['token' => $token];

        //Send Email
        Mail::send(
            'email.forgot_password',
            $data,
            function ($message) use ($user) {
                $message->to($user->user_email, $user->user_name)
                    ->subject('Forgot Password');
            }
        );

        Forgot_token::create([
            'forgot_token_user_id' => $user->user_id,
            'forgot_token_user_email' => $user->user_email,
            'forgot_token' => $token,
            'forgot_token_due_time' => strtotime(date('Y-m-d H:i:s')) + 3600 * 24,
        ]);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Email Sent', //Alert Message 
            'Please Check Your Email For Confirmation' //Sub Alert Message
        );

        return redirect()->back();
    }

    public function change_password($email, $token)
    {
        $setting = Setting::where('setting_id', 1)->first();

        //Check Token 
        $row = Forgot_token::where('forgot_token_user_email', $email)->where('forgot_token', $token)->first();
        if (!$row) {
            flash_alert(
                __('alert.icon_error'), //Icon
                'Failed', //Alert Message 
                'Email or Token Not Found' //Sub Alert Message
            );

            return redirect()->route('forgot_password');
        }

        // Check Token Expired
        if (strtotime(date('Y-m-d H:i:s')) > intval($row->forgot_token_due_time)) {

            Forgot_token::where('forgot_token_user_email', $email)->delete();

            flash_alert(
                __('alert.icon_error'), //Icon
                'Failed', //Alert Message 
                'Token Expired' //Sub Alert Message
            );

            return redirect()->route('forgot_password');
        }

        $logo = ($setting) ? $setting->setting_logo : 'default-logo.png';

        return view('auth.change_password', ['logo' => $logo, 'token' => $token, 'email' => $email]);
    }

    public function change_password_process(Request $request, $email, $token)
    {
        //Check Token 
        $row = Forgot_token::where('forgot_token_user_email', $email)->where('forgot_token', $token)->first();
        if (!$row) {
            flash_alert(
                __('alert.icon_error'), //Icon
                'Failed', //Alert Message 
                'Email or Token Not Found' //Sub Alert Message
            );

            return redirect()->route('forgot_password');
        }

        // Check Token Expired
        if (strtotime(date('Y-m-d H:i:s')) > intval($row->forgot_token_due_time)) {

            Forgot_token::where('forgot_token_user_email', $email)->delete();

            flash_alert(
                __('alert.icon_error'), //Icon
                'Failed', //Alert Message 
                'Token Expired' //Sub Alert Message
            );

            return redirect()->route('forgot_password');
        }

        //Validation Form
        $request->validate(
            [
                'new_password'  => 'required|max:100',
                'retype_password'  => 'required|max:100|same:new_password',
            ]
        );

        $password = htmlspecialchars($request->new_password);

        User::where('user_email', $email)->update(['user_password' => Hash::make($password)]);

        Forgot_token::where('forgot_token_user_email', $email)->delete();

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Change Success', //Alert Message 
            'Password Changed' //Sub Alert Message
        );

        return redirect()->route('login');
    }
}
