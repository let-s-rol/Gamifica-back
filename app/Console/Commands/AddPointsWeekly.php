<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ranking_User;

class AddPointsWeekly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points:add';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add 1000 points to all users weekly';

    protected $interval = 'weekly';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $users = Ranking_User::all();
        foreach ($users as $user) {
            $user->puntosSemanales += 1000;
            $user->save();
        }
    }
}
