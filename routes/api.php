<?php

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\VideoController;

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

//Units Routes
Route::get('/{languages:id}/units', [UnitController::class, 'index']);
Route::post('/unitAdd', [UnitController::class, 'store']);
Route::delete('/unitDelete/{id}', [UnitController::class, 'destroy']);

//Videos Routes
Route::get('/{units:id}/videos', [VideoController::class, 'index']);
Route::post('/videoAdd', [VideoController::class, 'store']);
Route::delete('/videoDelete/{id}', [VideoController::class, 'destroy']);

//Questions Routes
Route::get('/{units:id}/questions', [QuestionController::class, 'index']);
Route::post('/questionAdd', [QuestionController::class, 'store']);
Route::delete('/questionDelete/{id}', [QuestionController::class, 'destroy']);

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
