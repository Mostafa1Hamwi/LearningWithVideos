<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Achievements\CompleteFirstUnit;
use Assada\Achievements\Event\Unlocked;
use App\Http\Controllers\QuestionController;

class UnitController extends Controller
{
    public function index($id)
    {
        $units = Unit::where('language_id', $id)->where('unit_status', 'Done')->get();

        return response($units, 200);
    }

    //For Admin
    public function all($id)
    {
        $units = Unit::where('language_id', $id)->get();

        return response($units, 200);
    }

    public function content($id)
    {

        $questions = Question::where('unit_id', $id)->get();
        foreach ($questions as $question) {
            foreach ($question->choices as $choice) {
                $choices = $choice;
            }
        }

        $content = [
            'unit_overview' => Unit::where('id', $id)->pluck('unit_overview'),
            'videos' => Video::where('unit_id', $id)->get(),
            'lessons' => Lesson::where('unit_id', $id)->get(),
            'questions' => $questions
        ];


        return response($content, 200);
    }

    public function userUnitComplete($id)
    {
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();

        $unitt = Unit::find($id);
        $new_id = $id + 1;

        $user->units()->detach($unitt, ['status' => 0]);
        $user->units()->attach($unitt, ['status' => 1]);

        $user->unlock(new CompleteFirstUnit());

        return response($unitt, 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'unit_name' => 'required|string|unique:units,unit_name',
            'unit_overview' => 'required|string|unique:units,unit_overview',
            'unit_level' => 'required|string|in:Beginner,Intermediate,Advanced',
            'unit_status' => 'required|string|in:Done,Undone',
            'language_id' => 'required|exists:languages,id'
        ]);

        $unit = Unit::create($fields);

        $response = [
            'unit' => $unit,
            'message' => 'Unit Created Successfully'
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        if ($unit)
            $unit->delete();
        else {
            $response = [
                'message' => 'Unit not found'
            ];
            return response($response, 400);
        }
        return response()->json('Unit Deleted Successfully');
    }
}
