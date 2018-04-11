<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class searchController extends Controller
{
    public function index (Request $request)
    {

        if (!$request->term) {
            return redirect()->back();
        }
        $channels = Channel::search($request->term)->get();
        $videos = Video::search($request->term)->where('public', true)->get();

        return view('search.index',[
            'channels' => $channels,
            'videos' => $videos,
        ]);
    }
}
