<?php

namespace App\Http\Controllers;

use Assada\Achievements\Achievement;
use Illuminate\Http\Request;
use App\Models\User;

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
}
