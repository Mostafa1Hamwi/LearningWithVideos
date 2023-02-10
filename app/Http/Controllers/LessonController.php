<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    //

    public function index($id)
    {
        $lessons = Lesson::where('unit_id', $id)->get();

        // $response = [
        //     'id' => $lessons->id,
        // ];

        return response($lessons, 200);
    }

    public function show($id)
    {
        $lesson = Lesson::where('id', $id)->get();

        return response($lesson, 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'lesson_title' => 'required|string|unique:lessons,lesson_title',
            'lesson_content' => 'required|string',
            'question' => 'string',
            'answer' => 'string',
            'choice1' => 'string',
            'unit_id' => 'required|exists:units,id',

        ]);

        $lesson = Lesson::create($fields);

        $response = [
            'lesson' => $lesson,
            'message' => 'Lesson Created Successfully'
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $lesson = Lesson::find($id);
        if ($lesson)
            $lesson->delete();
        else {
            $response = [
                'message' => 'Lesson not found'
            ];
            return response($response, 400);
        }
        return response()->json('Lesson Deleted Successfully');
    }
}
