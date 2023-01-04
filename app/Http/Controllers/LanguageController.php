<?php

namespace App\Http\Controllers;

use PDO;
use App\Models\Unit;
use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Assada\Achievements\Event\Unlocked;
use Illuminate\Validation\Rules\Exists;
use App\Achievements\ChooseFirstLanguage;
use Assada\Achievements\Model\AchievementDetails;
use Assada\Achievements\Model\AchievementProgress;
use Illuminate\Database\Eloquent\Collection;

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

        $state = DB::table('unit_user')->updateOrInsert([
            'unit_id' => $unit->id,
            'user_id' => $user->id,
        ]);


        //Unlock Achievement
        if ($state == 1) {
            $details = $user->achievementStatus(new ChooseFirstLanguage());
            if ($details->unlocked_at == null) {
                $user->unlock(new ChooseFirstLanguage());
            }
            // $details = $user->achievementStatus(new ChooseFirstLanguage());
            // Unlocked::dispatch($details);
            $response = [
                "message" => "Language Added successfully",
            ];
        } else
            $response = [
                "message" => "Error"
            ];


        return response($response, 200);
    }

    public static function getUserUnits()
    {
        $user = User::where(
            'id',
            auth('api')->user()->id

        )->first();
        $units = DB::table('languages')->leftJoin(
            DB::raw("(select language_id,COUNT(*) as counter FROM units JOIN unit_user on unit_user.unit_id=units.id where user_id=$user->id AND status=1 GROUP BY language_id) b"),
            function ($join) {
                $join->on('languages.id', '=', 'b.language_id');
            }
        )->select(DB::raw('languages.id, COALESCE(b.counter, 0) as units_count'))
            ->get();

        return $units;
    }

    public static function countUnitsInLanguages()
    {
        $units = DB::table('languages')->leftJoin('units', 'languages.id', '=', 'units.language_id')->select(DB::raw('languages.id, count(units.id) as units_count'))
            ->groupBy('languages.id')
            ->get();

        return $units;
    }

    public static function getUserProgress()
    {
        $user_count = LanguageController::getUserUnits();
        $language_count = LanguageController::countUnitsInLanguages();

        $collection = collect();
        foreach ($language_count as $language) {
            foreach ($user_count as $user) {
                if ($language->id == $user->id) {
                    if ($language->units_count == 0) {
                        $languagee = [
                            'id' => $language->id,
                            'progress' => 0
                        ];
                    } else {
                        $e = ($user->units_count * 100) / $language->units_count;
                        settype($e, "integer");
                        $languagee = [
                            'language id' => $language->id,
                            'progress' => $e
                        ];
                    }
                    $collection->push($languagee);
                }
            }
        }


        return $collection;
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
