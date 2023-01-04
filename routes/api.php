<?php

use App\Http\Controllers\AchievementController;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\YouTubeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Profile
Route::get('/info', [AuthController::class, 'info']);
Route::patch('/profile/{user:id}', [ProfileController::class, 'update']);

//User manipulation route
Route::get('/users', [AuthController::class, 'index']);

//Roles Routes
Route::post('/roleAdd', [RoleController::class, 'store']);
Route::delete('/roleDelete/{id}', [RoleController::class, 'destroy']);

//Languages Routes
Route::get('/languages', [LanguageController::class, 'index']);
Route::post('/languageAdd', [LanguageController::class, 'store']);
Route::delete('/languageDelete/{id}', [LanguageController::class, 'destroy']);
// User Add Language
Route::post('/user/languageAdd/{languages:id}', [LanguageController::class, 'addUserLanguage']);
//Get Languages Progress
Route::get('/user/languages/progress', [LanguageController::class, 'getUserProgress']);
//Get User Languages
Route::get('/user/languages', [LanguageController::class, 'getUserUnits']);

Route::get('/languages/count', [LanguageController::class, 'countUnitsInLanguages']);


//Units Routes
Route::get('/{languages:id}/units', [UnitController::class, 'index']);
Route::post('/unitAdd', [UnitController::class, 'store']);
Route::delete('/unitDelete/{id}', [UnitController::class, 'destroy']);
//Get all units (ready or not)
Route::get('/{languages:id}/unitsAll', [UnitController::class, 'all']);
//Get unit content
Route::get('/units/{units:id}', [UnitController::class, 'content']);
//Set unit completed for a specific user
Route::post('/setUnitComplete/{units:id}', [UnitController::class, 'userUnitComplete']);
//Toggle
Route::patch('/toggle/{units:id}', [UnitController::class, 'toggle']);

//Videos Routes
Route::get('/{units:id}/videos', [VideoController::class, 'index']);
Route::post('/videoAdd', [VideoController::class, 'store']);
Route::delete('/videoDelete/{id}', [VideoController::class, 'destroy']);

//Lessons Routes
Route::get('/{units:id}/lessons', [LessonController::class, 'index']);
Route::post('/lessonAdd', [LessonController::class, 'store']);
Route::delete('/lessonDelete/{id}', [LessonController::class, 'destroy']);

//Questions Routes
Route::get('/{units:id}/questions', [QuestionController::class, 'index']);
Route::post('/questionAdd', [QuestionController::class, 'store']);
Route::delete('/questionDelete/{id}', [QuestionController::class, 'destroy']);
//Get question with answers
Route::get('/questions/{questions:id}', [QuestionController::class, 'getQuestionWithAnswers']);

//Achievements Routes
Route::get('/achievements/user', [AchievementController::class, 'getUserAchievements']);
Route::get('/achievements/latest', [AchievementController::class, 'UnlockedLastTwoMinutes']);
Route::get('/achievements/{id}', [AchievementController::class, 'show']);
Route::get('/achievements', [AchievementController::class, 'index']);
//Leadboards
Route::get('/leadboards', [AchievementController::class, 'leadboards']);

//User Favourites
Route::get('/user/favourites', [ProfileController::class, 'getFavourites']);
Route::delete('/user/favourites/delete', [ProfileController::class, 'deleteFavourite']);
Route::post('/user/favourites/add', [ProfileController::class, 'setFavourite']);


//Youtube Subtitles
Route::post('/youtube', YouTubeController::class);


//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/hi', function () {
    return ['status' => 'success'];
})->middleware('cors');
