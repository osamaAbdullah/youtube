<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index (Request $request)
    {

        if (!$request->term) {
            return redirect()->back();
        }

        $channels = Channel::where('name', 'like', '%'. $request->term .'%')->get();
        $videos = Video::where('title', 'like', '%'. $request->term .'%')->orWhere('description', 'like', '%'. $request->term .'%')->where('visibility', 'public')->get();

        return view('search.index',[
            'channels' => $channels,
            'videos' => $videos,
        ]);
    }
}
