<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class CompleteFirstUnit extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Completed Your First Unit';

    /*
     * A small description for the achievement
     */
    public $description = 'Congrats you have finished your first language';
}
