<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PetStatus;

class DecreasePetStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pets:decrease-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decrease pet stats every X minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $statuses = PetStatus::all();

        foreach ($statuses as $status) {
            $status->hunger = max(0, $status->hunger - 2);
            $status->thirst = max(0, $status->thirst - 3);
            $status->sleepiness = max(0, $status->sleepiness - 1);
            $status->cleanliness = max(0, $status->cleanliness - 2);
            $status->save();
        }

        $this->info('Pet stats decreased successfully.');
    }
}
