<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ChoiceController;

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
        $file_url = "";
        $unit_id = $request->unit_id;
        //Uploading Quiz Files to Google Drive
        if (request('question_link')) {
            $file = $request->file('question_link');
            $file_name = $file->getClientOriginalName();
            $file_path = Storage::disk("google")->putFileAs("LearnWithVideos/QuizMaterials/$unit_id", $file, $file_name);
            $file_url = Storage::disk("google")->url($file_path);
        }


        if (request('type') == 0) {
            $request['type'] = 'p';
        }

        if (request('type') == 1) {
            $request['type'] = 'v';
        }

        if (request('type') == 2) {
            $request['type'] = 'a';
        }

        if (request('type') == 3) {
            $request['type'] = 't';
        }

        $fields = $request->validate([
            'type' => 'required|string|in:t,a,p,v',
            'question' => 'required|string|unique:questions,question',
            'unit_id' => 'required|exists:units,id',
        ]);

        if ($file_url != null)
            $fields['question_link'] = $file_url;


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
