<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index($id)
    {
        $questions = Question::where('unit_id', $id)->get();

        return response($questions, 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'type' => 'required|string|in:t,p,v',
            'question' => 'required|string|unique:questions,question',
            'answer' => 'required|string',
            'choices' => 'required|string',
            'unit_id' => 'required|exists:units,id',

        ]);

        $question = Question::create($fields);

        $response = [
            'question' => $question,
            'message' => 'question Created Successfully'
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        if ($question)
            $question->delete();
        else {
            $response = [
                'message' => 'Question not found'
            ];
            return response($response, 400);
        }
        return response()->json('Question Deleted Successfully');
    }
}
