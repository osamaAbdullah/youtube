<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    public function index ()
    {
        return view('videos.upload');
    }
    public function store (Request $request)
    {
        $channel = $request->user()->channels()->first();
        $video = $channel->videos()->where('uid',$request->uid)->firstOrFail();
        $request->file('video')->move(storage_path() . '/uploads/videos' , $video->video_filename);
//        $this->dispatch(new UploadVideo($video->video_filename));
        return response()->json(null,200);
    }
}
