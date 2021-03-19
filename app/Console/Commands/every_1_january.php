<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class every_1_january extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:1jan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CRON update when 1 january';

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
        return 0;
    }
}
