<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoViewController extends Controller
{
    const BUFFER = 30 ;

    public function store (Request $request, Video $video)
    {

        if (!$video->canBeAccessed($request->user())) {
            return null;
        }
        if ($request->user()) {
            $lastUserView = $video->views()->latestByUser($request->user())->first();
            if ($this->withinBuffer($lastUserView)) {
                return null;
            }
        }
        $lastIpView = $video->views()->latestByIp($request->ip())->first();
        if ($this->withinBuffer($lastIpView)) {
            return null;
        }

        $video->views()->create([
            'user_id' => $request->user() ? $request->user()->id : null ,
            'ip_address' => $request->ip(),
        ]);
        return response()->make(null, 200) ;
    }

    protected function withinBuffer ($videoView)
    {
        // you can increase or decrease time between two views to be recorded as you wish
        return $videoView && $videoView->created_at->diffInSeconds(Carbon::now()) < self::BUFFER ;
    }
}
