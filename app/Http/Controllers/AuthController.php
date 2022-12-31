<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function index()
    {
        $users = User::all();

        return response($users, 200);
    }

    public function register(Request $request)
    {

        $fields = $request->validate([
            'first_name' => 'required|string|min:2|max:10',
            'last_name' => 'required|string|min:1|max:10',
            'gender' => 'required|string|in:m,f',
            'birth_date' => 'required|date',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'role_id' => 'exists:roles,id'
        ]);

        $fields['user_photo'] = 'illustration-1.gif';
        $fields['password'] = bcrypt($fields['password']);
        $fields['role_id'] = '3';

        $user = User::create($fields);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credintials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function info()
    {

        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();

        foreach ($user->units as $unit) {
        }
        $user_progress = LanguageController::getUserProgress();

        return response([
            'user' => $user,
            'user_progress' => $user_progress,
            'message' => 'Retrieved successfully'
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'message' => 'Logged Out'
        ];
    }
}
