<?php

namespace App\Console\Commands;

use App\Http\Helper\ReadLog;
use App\Models\Log\Log;
use Illuminate\Console\Command;

class VirtualDjCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'virtualdj:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate virtual DJ log';

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
        $time_to_run = 1;

        $interval = 60; //minutes

        set_time_limit(0);
        // a while loop to listen to changes on virtual dj log
        while (1) {
            if ($time_to_run <= 0) {

                $time_to_run = 1;

                $newRecords = ReadLog::VirtualDJ();

                if (count($newRecords) > 0) {
                    // $this->info(print_r($newRecords));
                    Log::insert($newRecords);
                    unset($newRecords);
                    ReadLog::VirtualDJ(1);
                }

                sleep(60 * 1);
            }

            $time_to_run--;
        }
    }
}
