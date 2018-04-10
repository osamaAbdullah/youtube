<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVoteRequest;
use App\Models\Video;
use App\Models\Vote;
use Illuminate\Http\Request;

class VideoVoteController extends Controller
{
    public function store (CreateVoteRequest $request, Video $video)
    {
        $this->authorize('vote',$video);
        if ($voteFromUser = $video->voteFromUser($request->user())) {
            $voteFromUser->delete();
        }
//        $video->votes()->create([
//            'type' => $request->type ,
//            'user_id' => $request->user()->id
//        ]);
        //using old way of doing this hahahahahaha
        //ay dunya dunyayachi kawn xaib baxam
        //today doing this only god knows tomorrow what i will
        //alahoma ya mothabital qolobi thabit qolobana 3alal7aqi bi ra7matika ya ar7amara7imin
        $vote = new Vote;
        $vote->type = $request->type ;
        $vote->user_id = $request->user()->id ;
        $video->votes()->save($vote);

        return response()->make(null,200);
    }

    public function delete (Request $request, Video $video)
    {
        $this->authorize('vote',$video);
        $video->voteFromUser($request->user())->delete();
        return response()->make(null, 200);
    }

    public function show (Request $request, Video $video)
    {
        $response = [
            'up' => null,
            'down' => null,
            'canVote' => $video->votesAllowed(),
            'userVote' => null,
        ];

        if ($video->votesAllowed()) {
            $response['up'] = $video->upVotes()->count();
            $response['down'] = $video->downVotes()->count();
        }

        if ($request->user()) {
            $voteFromUser = $video->voteFromUser($request->user());
            $response ['userVote'] = $voteFromUser ? $voteFromUser->type : null ;
        }

        return response()->json([
            'data' => $response
        ], 200);
    }
}