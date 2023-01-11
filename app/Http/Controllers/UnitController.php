<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        //insert next unit if it does exist
        $unitt = Unit::find($id);
        $user_unit = DB::table('unit_user')->where('unit_id', $id)->where('user_id', $user->id)->first();
        if ($user_unit) {
            //set old unit status to one (completed)
            $user->units()->detach($unitt, ['status' => 0]);
            $user->units()->attach($unitt, ['status' => 1, 'quiz_mark' => request('quiz_mark')]);
        }
        $new_unit = Unit::where('id', '>', $unitt->id)->where('language_id', $unitt->language_id)->first();
        if ($new_unit) {
            $exist = DB::table('unit_user')->where('unit_id', $new_unit->id)->where('user_id', $user->id)->first();
            if ($exist) {
            } else {
                DB::table('unit_user')->insert([
                    'unit_id' => $new_unit->id,
                    'user_id' => $user->id,
                ]);
            }
        }

        ProfileController::increasePoints(100);
        $details = $user->achievementStatus(new CompleteFirstUnit());
        if ($details->unlocked_at == null) {
            $user->unlock(new CompleteFirstUnit());
        }

        return response($new_unit, 200);
    }

    public function storeParagraph($id)
    {
        $response = "Something went wrongs";
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();
        $unit = DB::table('unit_user')->where('unit_id', $id)->where('user_id', $user->id)->first();

        $attributes = request()->validate([
            'content' => 'required',
        ]);

        // User::find($user)->units()->updateExistingPivot($roleId, $attributes);
        if ($unit) {
            $unit->update([
                'paragraph' => $attributes['content'],
            ]);
            $response = "Success";
        }

        return response($response, 200);
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

    public function toggle($id)
    {
        $unit = Unit::find($id);

        if ($unit->unit_status == 'Done') {
            $unit->update([
                'unit_status' => 'Undone'
            ]);
        } else {
            $unit->update([
                'unit_status' => 'Done'
            ]);
        }

        $response = "Toggle operation done successfully";

        return response($response, 200);
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
