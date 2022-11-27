<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index($id)
    {
        $videos = Video::where('unit_id', $id)->get();

        return response($videos, 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'video_title' => 'required|string|unique:videos,video_title',
            'video_link' => 'required|string',
            'video_description' => 'required|min:5',
            'video_subtitle' => 'required|string',
            'unit_id' => 'required|exists:units,id',

        ]);

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
