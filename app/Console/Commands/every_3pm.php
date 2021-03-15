<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Content;
use App\Models\Notification;
use App\Models\Telegram_data_source;
use App\Models\Setting;

use App\Traits\RequestTrait;
use App\Traits\RequestPingNotif;

class every_3pm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:3pm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Is There User Upload Yet at 03 PM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('user_role', 'operator')->get();
        $telegram = Telegram_data_source::where('chat_mute', false)->get();
        $setting = Setting::find(1);

        if (date('N') == 6 || date('N') == 7) {
            // Nothing
        } else {
            foreach ($users as $user) {
                $content = Content::where('content_user_id', $user->user_id)
                    ->whereBetween('created_at', [date('Y-m-d') . " 08:00:00", date('Y-m-d') . " 17:00:00"])->count();

                if ($content < $user->user_daily_target) {
                    // Web Notification
                    $message = "<p>Don't Forget To Upload Content For This Day, " . $user->user_daily_target - $content . " Content Remaining To Upload</p>";

                    $data_notif = [
                        'notification_user_id' => $user->user_id,
                        'notification_detail' => $message,
                        'notification_status' => 0,
                        'notification_date' => date('Y-m-d')
                    ];
                    Notification::create($data_notif);

                    // Telegram Message Notif
                    $text_tg = "Don't Forget To Upload Content For This Day, \nUser : " . $user->user_name . "\n"
                        . $user->user_daily_target - $content . " Content Remaining To Upload";

                    if ($telegram) {
                        foreach ($telegram as $tg) {
                            $this->apiRequest('sendMessage', [
                                'chat_id' => $tg->chat_id,
                                'text' => $text_tg,
                                "parse_mode" => "html",
                            ]);
                        }
                    }

                    // Whatsapp Message Notif
                    $text_wa = "Don't Forget To Upload Content For This Day, " . $user->user_daily_target - $content . " Content Remaining To Upload";
                    $number_phone = substr_replace($user->user_phone, "62", 0, 1);
                    $this->sendMessageWhatsapp($number_phone, $text_wa);
                }
            }
        }
    }
}
