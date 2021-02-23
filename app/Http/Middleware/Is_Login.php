<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

use App\Models\User;

use Closure;

class Is_Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::get('user_id') && Session::get('user_role') && Session::get('user_email') && Session::get('user_name') && Session::get('user_image')) {
            return $next($request);
        } else if (Cookie::get('account') && Cookie::get('access')) {
            $user = User::firstWhere('user_email', Cookie::get('account'));

            //Create Session
            $data = [
                'user_id' => $user->user_id,
                'user_name' => $user->user_name,
                'user_role' => $user->user_role,
                'user_email' => $user->user_email,
                'user_image' => $user->user_image
            ];

            Session::put($data);
            return $next($request);
        } else {
            Session::flush();
            Cookie::queue(Cookie::forget('account'));
            Cookie::queue(Cookie::forget('access'));

            return redirect()->route('login');
        }
    }
}
