<?php

namespace App\Listeners;

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Assada\Achievements\Achievement;
use Assada\Achievements\Event\Unlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AchievementUnlocked
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Unlocked $event)
    {

        ProfileController::increasePoints(200);

        // $achievement = [
        //     'Achievement' => $event->progress,
        // ];

        // return response($achievement, 200);
    }
}
