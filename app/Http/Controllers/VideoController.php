<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index($id)
    {
        $videos = Video::where('unit_id', $id)->get();

        return response($videos, 200);
    }

    public function store(Request $request)
    {
        $folder_name = $request->video_title;
        //Uploading Video to Google Drive
        $video = $request->file('video_link');
        $video_name = $video->getClientOriginalName();
        $video_path = Storage::disk("google")->putFileAs("LearnWithVideos/Videos/$folder_name", $video, $video_name);
        $video_url = Storage::disk("google")->url($video_path);

        //Uploading Subtitles to Google Drive
        $subtitle = $request->file('video_subtitle');
        $subtitle_name = $subtitle->getClientOriginalName();
        $subtitle_path = Storage::disk("google")->putFileAs("LearnWithVideos/Subtitles/$folder_name", $subtitle, $subtitle_name);
        $subtitle_url = Storage::disk("google")->url($subtitle_path);


        $fields = $request->validate([
            'video_title' => 'required|string|unique:videos,video_title',
            'video_link' => 'required',
            'video_description' => 'required|min:5',
            'video_subtitle' => 'required',
            'unit_id' => 'required|exists:units,id',

        ]);

        $fields['video_link'] = $video_url;
        $fields['video_subtitle'] = $subtitle_url;

        $video = Video::create($fields);

        $response = [
            'video' => $video,
            'message' => 'Video Created Successfully'
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $video = Video::find($id);
        if ($video)
            $video->delete();
        else {
            $response = [
                'message' => 'Video not found'
            ];
            return response($response, 400);
        }
        return response()->json('Video Deleted Successfully');
    }
}
