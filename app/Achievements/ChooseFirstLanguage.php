<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class ChooseFirstLanguage extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Your First Language';

    /*
     * A small description for the achievement
     */
    public $description = 'Congrats you have chosen your first language';

    // public function whenUnlocked($progress)
    // {
    //     return response('Ach Umlocked', 200);
    // }
}
