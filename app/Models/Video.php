<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Video extends Model
{
    //laravel traits
    use SoftDeletes, Searchable, Orderable;

    protected $fillable = [
        'title',
        'description',
        'uid',
        'video_filename',
        'video_id',
        'processed',
        'visibility',
        'allow_votes',
        'allow_comments',
        'processed_percentage',
    ];

    public function toSearchableArray()
    {
        $record = $this->toArray();

        $record['public'] = $this->isPublic() && $this->isProcessed() ;

        return $record;
    }

    public function isPublic ()
    {
        return $this->visibility === 'public' ;
    }

    public function getRouteKeyName ()
    {
        return 'uid';
    }

    public function channel ()
    {
        return $this->belongsTo(Channel::class);
    }

    public function votesAllowed ()
    {
        return (bool) $this->allow_votes ;
    }

    public function commentsAllowed ()
    {
        return (bool) $this->allow_comments ;
    }

    public function isPrivate ()
    {
        return $this->visibility === 'private';
    }

    public function ownedByUser (User $user)
    {
        return $this->channel->user->id === $user->id ;
    }

    public function isProcessed ()
    {
        return $this->processed ;
    }

    public function canBeAccessed ($user = null)
    {
        if(!$user && $this->isPrivate() ) {
            return false ;
        }
        elseif ($user && $this->isPrivate() && $user->id !== $this->channel->user_id ) {
            return false ;
        }
        return true ;
    }

    public function views ()
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount ()
    {
        return $this->views->count();
    }

    public function votes ()
    {
        return $this->morphMany('App\Models\Vote', 'voteable');
    }

    // if you use votes on any other model like you better move,
    // this to a trade to apply DRY don't repeat your self
    public function upVotes ()
    {
        return $this->votes()->where('type', '=','up')->get();
    }

    public function downVotes ()
    {
        return $this->votes()->where('type', '=','down')->get();
    }
    // i mean this two witch are between comments

    public function voteFromUser (User $user)
    {
        return $this->votes()->where('user_id', $user->id)->first();
    }

    public function comments ()
    {
        //you can use both of this they have the same meaning as ( IS NULL ) in mysql
        //return $this->morphMany(Comment::class, 'commentable')->whereNull('reply_id');
        return $this->morphMany(Comment::class, 'commentable')->where('reply_id', null);

    }

    public function scopeProcessed ($query)
    {
        return $query->where('processed', true);
    }
    public function scopePublic ($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeVisible ($query)
    {
        return $query->processed()->public();
    }
}