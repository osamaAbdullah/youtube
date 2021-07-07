<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoStoreRequest;
use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function show (Video $video)
    {
        return view('videos.show',[
            'video' => $video
        ]);
    }

    public function index (Request $request)
    {
        $videos = $request->user()->videos()->latestFirst()->paginate(10);
        return view('videos.index',['videos' => $videos]);
    }

    public function edit (Video $video)
    {
        $this->authorize('edit',$video);
        return view('videos.edit',[
            'video' => $video
        ]);
    }

    public function update (VideoUpdateRequest $request, Video $video)
    {
        $this->authorize('update',$video);
        $video->update([
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'allow_votes' => $request->has('allow_votes'),
            'allow_comments' => $request->has('allow_comments'),
        ]);
        if ($request->ajax()) {
            return response()->json(null,200);
        }
        Session::flash('success', 'The Channel was successfully updated');
        return redirect(url('videos/' . $video->uid . '/show'));
    }

    public function store (VideoStoreRequest $request)
    {
        //arbort(500);
        $uid = uniqid(true);
        $channel = $request->user()->channels()->first();
        $channel->videos()->create([
            'uid' => $uid,
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'thumbnail' => 'defaultThumbnail.png',
            'video_filename' => "$uid.$request->extension",
            'processed' => 1, // because those service are not free so im not using them
        ]);
        return response()->json( [
            'data' => [
                'uid' => $uid
            ]
        ] );
    }

    public function delete (Video $video)
    {
        $this->authorize('delete',$video);
        $video->delete();
        return redirect()->back();
    }

    public function getImage ($image)
    {
        $image_get = Storage::disk('image')->get($image);
        return new Response($image_get,200);
    }

    public function getVideo ($video)
    {
        $video_get = Storage::disk('video')->get($video);
        return new Response($video_get,200);
    }
}