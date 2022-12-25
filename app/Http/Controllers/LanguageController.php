<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Assada\Achievements\Event\Unlocked;
use Illuminate\Validation\Rules\Exists;
use App\Achievements\ChooseFirstLanguage;
use Assada\Achievements\Model\AchievementDetails;
use Assada\Achievements\Model\AchievementProgress;

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
            'language_name' => 'required|string|unique:languages,language_name',
            'language_photo' => 'string'
        ]);


        $language = Language::create($fields);

        $response = [
            'language' => $language,
            'message' => 'Language Created Successfully'
        ];
        return response($response, 201);
    }


    public function addUserLanguage($id)
    {
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();

        $response = [
            "message" => "Language does not exist"
        ];


        if ($language = Language::find($id))
            $unit = $language->units->first();
        else
            return response($response, 200);

        $state = DB::table('unit_user')->insert([
            'unit_id' => $unit->id,
            'user_id' => $user->id,
        ]);

        if ($state == 1) {
            $user->unlock(new ChooseFirstLanguage());
            $details = $user->achievementStatus(new ChooseFirstLanguage());
            Unlocked::dispatch($details);
            $response = [
                "message" => "Language Added successfully",
            ];
        } else
            $response = [
                "message" => "Error"
            ];


        return response($response, 200);
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
