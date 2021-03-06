<?php

namespace App\Http\Controllers;

use App\Models\Channel;

class ChannelController extends Controller
{
    public function show (Channel $channel)
    {
        return view('channels.show', [
            'channel' => $channel,
            'videos' => $channel->videos()->latestFirst()->paginate(5),
        ]);
    }
}
