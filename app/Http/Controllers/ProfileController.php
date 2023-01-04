<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public static function increasePoints($p)
    {
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();
        $user->update(['points' => $user->points + $p]);
    }


    public function update(User $user)
    {

        $attributes = request()->validate([
            'first_name' => 'required|string|min:2|max:10',
            'last_name' => 'required|string|min:1|max:10',
            'gender' => 'required|string|in:m,f',
            'birth_date' => 'required|date',
            'user_photo' => 'required|string',

        ]);

        // //thumbnail processsing
        // if (isset($attributes['profilePic'])) {
        //     $attributes['profilePic'] = request()->file('profilePic')->store('profilePic');
        // }

        $user->update([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'gender' => $attributes['gender'],
            'birth_date' => $attributes['birth_date'],
            'user_photo' => $attributes['user_photo'],

        ]);

        return response('done', 200);
    }

    public function setFavourite(Request $request)
    {
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();

        $response = 'The word is already in this user library';

        $exist = Favourite::where('user_id', $user->id)->where('vocabulary', $request->vocabulary)->first();

        if ($exist == null) {
            $fields = $request->validate([
                'vocabulary' => 'required',
            ]);
            $fields['user_id'] = $user->id;

            $word = Favourite::create($fields);

            $response = [
                'message' => 'Word added to user library successfully'
            ];
        }
        return response($response, 200);
    }

    public function deleteFavourite(Request $request)
    {
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();

        $response = 'The word does not exist in user library';

        $exist = Favourite::where('user_id', $user->id)->where('vocabulary', $request->vocabulary)->first();
        if ($exist) {
            Favourite::destroy($exist->id);
            $response = [
                'message' => 'Word deleted from user library successfully'
            ];
        }
        return response($response, 200);
    }

    public function getFavourites()
    {
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();

        $words = Favourite::where('user_id', $user->id)->get();

        return response($words, 200);
    }
}
