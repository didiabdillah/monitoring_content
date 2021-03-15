<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait RequestPingNotif
{
    private function sendMessageWhatsapp($number, $message)
    {
        $BOT_TOKEN = DB::table('settings')->where('setting_id', 1)->first()->setting_api_whatsapp;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.pingnotif.com/api-whatsapp",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "number_phone=" . $number . "&message=" . $message,
            CURLOPT_HTTPHEADER => array(
                "key: " . $BOT_TOKEN,
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));
        $response = curl_exec($curl);

        if ($response === false) {
            curl_close($curl);
            return false;
        }

        curl_close($curl);
        $response = json_decode($response, true);

        if ($response['error'] != false) {
            return false;
        }
        $response = $response['status'];
        return $response;
    }
}
