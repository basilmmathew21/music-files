<?php

namespace App\Console\Commands;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateNoDriverTrips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'noDriverTrip:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will update all the trips status to 3 which are not accepted by any driver in a stipulated time.';

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
        $idleTripQuery   =   Trip::whereIn('status', ['1', '2'])->where('created_at', '<', Carbon::now()->subMinute()->toDateTimeString());
        $idleTripQuery->update(['status' => '3']);
    }
}
