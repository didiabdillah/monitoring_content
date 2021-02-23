<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait RequestTrait
{
    private function apiRequest($method, $parameters = [])
    {
        $BOT_TOKEN = DB::table('settings')->where('setting_id', 1)->first()->setting_api_telegram;

        $url = "https://api.telegram.org/bot" . $BOT_TOKEN . "/" . $method;
        // $url = "https://api.telegram.org/bot1346135630:AAHFoyWAwqX_fCYTdNEq_DpAARpSSZtmZ9Q/setWebhook?url=https://f9b44249e8f2.ngrok.io/api/bot/tg";
        $handle = curl_init($url);

        // curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $parameters);
        $response = curl_exec($handle);

        if ($response === false) {
            curl_close($handle);
            return false;
        }
        curl_close($handle);
        $response = json_decode($response, true);

        if ($response['ok'] == false) {
            return false;
        }
        $response = $response['result'];
        return $response;
    }
}
