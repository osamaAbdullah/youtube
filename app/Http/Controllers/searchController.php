<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class searchController extends Controller
{
    public function index (Request $request)
    {
        if (!$request->query) {
            return redirect()->back();
        }
        $channels = Channel::search($request->query)->take(2)->get();
        $videos = Video::search($request->query)->get();

        return view('search.index',[
            'channels' => $channels,
            'videos' => $videos,
        ]);
    }
}
