<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
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
}
