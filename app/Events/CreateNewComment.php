<?php

namespace App\Events;

use App\Models\Comment;
use App\Transformers\CommentTransformer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateNewComment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $comment;
    private $uid;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, $uid)
    {
        $this->comment = $comment ;
        $this->uid =$uid ;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('videos' . $this->uid);
    }

    public function broadcastWith ()
    {
        return fractal()->item($this->comment)
                ->parseIncludes(['channel', 'replies'])
                ->transformWith(new CommentTransformer)
                ->toArray();
    }
}
