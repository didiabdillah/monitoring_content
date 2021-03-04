<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Content;
use App\Models\Missed_upload;

class every_5pm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:5pm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Is There User Upload Yet at 05 PM';

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
                $data = [
                    'missed_upload_user_id' => $user->user_id,
                    'missed_upload_date' => date('Y-m-d'),
                    'missed_upload_total' => $user->user_daily_target - $content,
                ];

                Missed_upload::create($data);
            }
        }
    }
}
