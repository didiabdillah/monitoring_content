<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // if (\Schema::hasTable('mails')) {
        $mail = DB::table('settings')->where('setting_id', 1)->first();
        if ($mail) //checking if table is not empty
        {
            $config = [
                'driver'     => 'smtp',
                'host'       => $mail->setting_smtp_host,
                'port'       => $mail->setting_smtp_port,
                'from'       => ['address' => 'monitoring@email.com', 'name' => 'Monitoring Kompetitor'],
                'encryption' => 'tls',
                'username'   => $mail->setting_smtp_user,
                'password'   => $mail->setting_smtp_password,
                'timeout' => null,
                'auth_mode' => null,
                'sendmail'   => '/usr/sbin/sendmail -bs',
                // 'pretend'    => false,
            ];
            Config::set('mail', $config);
        }
        // }
    }
}
