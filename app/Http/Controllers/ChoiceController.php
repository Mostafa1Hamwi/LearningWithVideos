<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{

    public static function index($id)
    {
        $choices = Choice::where('question_id', $id)->get();

        return response($choices, 200);
    }

    public static function store($choice, $state, $question)
    {
        $fields = [
            'choice' => $choice,
            'is_correct' => $state,
            'question_id' => $question
        ];
        $choice = Choice::create($fields);
        return $choice;
    }
}
