<?php

namespace App\Http\Controllers;

use App\Models\Daily;
use Illuminate\Http\Request;

class DailyController extends Controller
{
    public function show()
    {
        $daily = Daily::inRandomOrder()->first();

        return response($daily, 200);
    }

    public function store(Request $request)
    {

        $fields = $request->validate([
            'content' => 'required|string|unique:dailies,content',
            'category' => 'required|string|in:trick,quote,information,motivation',

        ]);

        $daily = Daily::create($fields);

        $response = [
            'daily' => $daily,
            'message' => 'daily Created Successfully'
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $daily = Daily::find($id);
        if ($daily)
            $daily->delete();
        else {
            $response = [
                'message' => 'daily not found'
            ];
            return response($response, 400);
        }
        return response()->json('daily Deleted Successfully');
    }
}
