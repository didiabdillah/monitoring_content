<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Content;
use App\Models\Notification;

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

        foreach ($users as $user) {
            $content = Content::where('content_user_id', $user->user_id)
                ->whereBetween('created_at', [date('Y-m-d') . " 08:00:00", date('Y-m-d') . " 17:00:00"])->count();

            if ($content < $user->user_daily_target) {
                $message = "<p>Don't Forget To Upload Content For This Day, " . $user->user_daily_target - $content . " Content Remaining To Upload</p>";

                $data_notif = [
                    'notification_user_id' => $user->user_id,
                    'notification_detail' => $message,
                    'notification_status' => 0,
                    'notification_date' => date('Y-m-d')
                ];
                Notification::create($data_notif);
            }
        }
    }
}
