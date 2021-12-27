<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FirstJob;

class FirstQueueCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:first';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is my first message notification with Queue and CronJob';

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
        // Execute from method dispatch
        FirstJob::dispatch();

        // Or like this ( With Helper Laravel )
        // dispatch(new FirstJob);
    }
}
