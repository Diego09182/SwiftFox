<?php

namespace App\Console\Commands;

use App\Models\Opinion;
use Illuminate\Console\Command;

class UpdateExpiredOpinions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opinions:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of expired opinions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = now();

        Opinion::where('finished_time', '<=', $currentTime)
                ->where('status', '=', 1)
                ->update(['status' => 0]);

        $this->info('Expired opinions updated successfully.');
    }
}
