<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

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

    public function getRouteKeyName ()
    {
        return 'uid';
    }

    public function channel ()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeLatestFirst ($query)
    {
        return $query->orderBy('created_at','desc');
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
}
