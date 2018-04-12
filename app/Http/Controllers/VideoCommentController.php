<?php

namespace App\Http\Controllers;

use App\Events\CreateNewComment;
use App\Http\Requests\createCommentRequest;
use App\Models\Comment;
use App\Models\Video;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;
use Spatie\Fractal\Fractal;

class VideoCommentController extends Controller
{
    public function index (Video $video)
    {
        $this->authorize('comment', $video);
        return response()->json(
            fractal()->collection($video->comments()->latestFirst()->get())
                ->parseIncludes(['channel', 'replies', 'replies.channel'])
                ->transformWith(new CommentTransformer)
                ->toArray()
        );
    }
    public function store (CreateCommentRequest $request, Video $video)
    {
        $this->authorize('comment', $video);
        $comment = $video->comments()->create([
            'body' => $request->body,
            'reply_id' => $request->get('reply_id', null),
            'user_id' => $request->user()->id,
        ]);
        //event(new CreateNewComment($comment, $video->uid)); event will be triggered for all including ur self
        broadcast(new CreateNewComment($comment, $video->uid))->toOthers();
        return response()->json(
            fractal()->item($comment)
            ->parseIncludes(['channel', 'replies'])
            ->transformWith(new CommentTransformer)
            ->toArray()
        );
    }

    public function delete (Video $video, Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->make(null, 200);
    }

}
