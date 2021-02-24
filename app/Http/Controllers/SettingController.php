<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

use App\Models\Setting;

class SettingController extends Controller
{
    //Setting
    public function index()
    {
        $setting = Setting::find(1);

        return view('setting.setting', ['setting' => $setting]);
    }

    public function update(Request $request)
    {
        // Input Validation
        $request->validate([
            'api_wa'  => 'required|max:255',
            'api_tg'  => 'required|max:255',
            'host'  => 'required|max:255',
            'port'  => 'required|max:5',
            'user'  => 'required|max:255',
            'password'  => 'required|max:255',
        ]);

        //Update Data
        $data = [
            'setting_api_whatsapp' => htmlspecialchars($request->api_wa),
            'setting_api_telegram' => htmlspecialchars($request->api_tg),
            'setting_smtp_host' => htmlspecialchars($request->host),
            'setting_smtp_port' => htmlspecialchars($request->port),
            'setting_smtp_user' => htmlspecialchars($request->user),
            'setting_smtp_password' => htmlspecialchars($request->password),
        ];

        $old = Setting::where('setting_id', 1)->first();

        if ($old) {
            Setting::where('setting_id', 1)
                ->update($data);
        } else {
            Setting::create($data);
        }

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Update Success', //Alert Message 
            'Settings Changed' //Sub Alert Message
        );

        return redirect()->back();
    }

    public function logo(Request $request)
    {
        // Input Validation
        $request->validate([
            'logo'  => 'required|mimetypes:image/png,image/jpeg,image/gif',
        ], [
            'logo.mimetypes' => "The image must be a file of type: png, jpeg, jpg, gif."
        ]);

        $file = $request->file('logo');
        $destination = "assets/img/logo/";

        $logoOld =  Setting::where('setting_id', 1)->first();

        //Update Data
        $data = [
            'setting_logo' => $file->hashName(),
        ];

        if ($logoOld) {
            $image_path = public_path($destination . $logoOld->setting_logo);

            Setting::where('setting_id', 1)
                ->update($data);

            $file->move($destination, $file->hashName());

            if ($logoOld->setting_logo != 'default-logo.png') {
                File::delete($image_path);
            }
        } else {
            Setting::create($data);

            $file->move($destination, $file->hashName());
        }

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Update Success', //Alert Message 
            'Logo Changed' //Sub Alert Message
        );

        return redirect()->back();
    }

    public function favicon(Request $request)
    {
        // Input Validation
        $request->validate(
            [
                'favicon'  => 'required|mimetypes:image/vnd.microsoft.icon',
            ],
            [
                'favicon.mimetypes' => "The image must be a file of type: ico."
            ]
        );

        $file = $request->file('favicon');
        $destination = "assets/img/favicon/";
        $extension = $file->getClientOriginalExtension();
        $faviconOld =  Setting::where('setting_id', 1)->first();

        //Update Data
        $data = [
            'setting_favicon' => $file->hashName(),
        ];

        if ($faviconOld) {
            $image_path = public_path($destination . $faviconOld->setting_favicon);

            if ($extension == "ico") {

                Setting::where('setting_id', 1)
                    ->update($data);

                $file->move($destination, $file->hashName());

                if ($faviconOld->setting_favicon != 'default-favicon.ico') {
                    File::delete($image_path);
                }
            }
            // else {
            //     $file1 = (string) Image::make($file)->resize(128, 128)->encode('ico');
            //     dd($file1);
            //     $save_name = pathinfo($file->hashName(), PATHINFO_FILENAME) . ".ico";

            //     //Update Data
            //     $data = [
            //         'setting_favicon' => $save_name,
            //     ];

            //     Setting::where('setting_id', 1)
            //         ->update($data);

            //     (string) Image::make($file)->resize(128, 128)->encode('ico', 75)->save($destination . $save_name);

            //     if ($faviconOld->setting_favicon != 'default-favicon.ico') {
            //         File::delete($image_path);
            //     }
            // }
        } else {
            Setting::create($data);

            $file->move($destination, $file->hashName());
        }

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Update Success', //Alert Message 
            'Favicon Changed' //Sub Alert Message
        );

        return redirect()->back();
    }
}
