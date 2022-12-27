<?php

// use Google\Service\Docs\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test', function () {
    $hi = Storage::disk('google')->put("hi.txt", "");
    return $hi;
});

Route::get('/d', function () {
    return view('drive');
});

Route::post('/upload', function (Request $request) {
    $path = Storage::disk("google")->putFileAs("", $request->file("thing"), "file_name.jpg");

    return $path;
})->name('upload');

Route::get('/p', function () {
    $file = Storage::disk("google")->allFiles();
    $firstFileName = $file[0];
    dump("file name : " . $firstFileName);
    $url = Storage::disk("google")->url($firstFileName);
    dump("download link : ");
    dump($url);
});

require __DIR__ . '/auth.php';
