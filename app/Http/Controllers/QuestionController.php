<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\ChoiceController;
use App\Models\Choice;

class QuestionController extends Controller
{
    public static function index($id)
    {
        $questions = Question::where('unit_id', $id)->get();
        foreach ($questions as $question) {
            foreach ($question->choices as $choice) {
                $choices = $choice;
            }
        }

        $response = [
            'questions' => $questions,

        ];

        return response($response, 200);
    }


    public function store(Request $request)
    {
        $fields = $request->validate([
            'type' => 'required|string|in:t,a,p,v',
            'question_link' => 'string',
            'question' => 'required|string|unique:questions,question',
            'unit_id' => 'required|exists:units,id',
        ]);

        $question = Question::create($fields);

        $q = $question->id;

        $choices = $request->validate([
            'correct_answer' => 'required|string',
            'choice1' => 'required|string',
            'choice2' => 'required|string',
        ]);

        $correct = ChoiceController::store($choices['correct_answer'], 1, $q);
        $choice1 = ChoiceController::store($choices['choice1'], 0, $q);
        $choice2 = ChoiceController::store($choices['choice2'], 0, $q);

        $response = [
            'question' => $question,
            'correct_answer' => $correct,
            'choice1' => $choice1,
            'choice2' => $choice2,
            'message' => 'question Created Successfully'
        ];
        return response($response, 201);
    }

    public function getQuestionWithAnswers($id)
    {
        $response = [
            'question' => Question::where('id', $id)->get(),
            'choices' => Choice::where('question_id', $id)->get()
        ];

        return response($response, 200);
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
