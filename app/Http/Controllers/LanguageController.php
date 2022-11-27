<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function index()
    {
        $languages = Language::get();

        return response($languages, 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'language_name' => 'required|string|unique:languages,language_name'
        ]);

        $language = Language::create($fields);

        $response = [
            'language' => $language,
            'message' => 'Language Created Successfully'
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $language = Language::find($id);
        if ($language)
            $language->delete();
        else {
            $response = [
                'message' => 'Language not found'
            ];
            return response($response, 400);
        }

        return response()->json('Language Deleted Successfully');
    }
}
