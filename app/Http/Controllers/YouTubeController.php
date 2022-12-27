<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteSubtitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class YouTubeController extends Controller
{
    public function __invoke(Request $request)
    {
        //Uploading Subtitles to Google Drive
        $subtitle = $request->file('subtitle');
        $subtitle_name = $subtitle->getClientOriginalName();

        $subtitle_path = Storage::disk("google")->putFileAs("LearnWithVideos/Subtitles/YouTube", $subtitle, $subtitle_name . ".srt");
        $subtitle_url = Storage::disk("google")->url($subtitle_path);
        Storage::disk("google")->delete($subtitle_path);

        // DeleteSubtitle::dispatch($subtitle_path)->delay(now()->addSeconds(30));;
        // Artisan::queue(Storage::disk("google")->delete($subtitle_path))->delay(30);

        return response($subtitle_url, 200);
    }
}
