<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Assada\Achievements\Achievement;
use Doctrine\DBAL\Schema\Index;

class AchievementController extends Controller
{
    public function show($id)
    {
        $achievement = Achievement::find($id);

        return response($achievement, 200);
    }


    public static function index()
    {
        $achievements = Achievement::all();

        return response($achievements, 200);
    }



    public function getUserAchievements()
    {
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();

        $achievements   = $user->achievements;

        return response($achievements, 200);
    }

    public function UnlockedLastTwoMinutes()
    {
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();

        $unlocked = $user->achievements()->where('unlocked_at', '>=', Carbon::now()->subMinutes(3)->toDateTimeString())->get();

        return response($unlocked, 200);
    }

    public function leadboards()
    {
        $index = 0;
        $users = User::orderByDesc('points')->get(['id', 'first_name', 'last_name', 'user_photo', 'points']);
        $collection = collect();
        foreach ($users as $user) {
            $index = $index + 1;
            $person = [
                'rank' => $index,
                'user' => $user,

            ];
            $collection->push($person);
        }

        return $collection;
    }
}
