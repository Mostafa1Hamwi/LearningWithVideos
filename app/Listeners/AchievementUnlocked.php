<?php

namespace App\Listeners;

use Assada\Achievements\Achievement;
use Assada\Achievements\Event\Unlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $achievement = [
            'Achievement' => $event->progress,
        ];

        // return response($achievement, 200);
    }
}
