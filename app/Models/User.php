<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function channels ()
    {
        return $this->hasMany(Channel::class);
    }

    public function videos ()
    {
        return $this->hasManyThrough(Video::class, Channel::class);
    }
    public function subscriptions ()
    {
        return $this->hasMany(Subscription::class);
    }
    public function subscribedChannels ()
    {
        return $this->belongsToMany(Channel::class, 'subscriptions');
    }
    public function isSubscribedTo (Channel $channel)
    {
        return (boolean) $this->subscriptions()->where('channel_id', $channel->id)->count();
    }
    public function ownsChannel (Channel $channel)
    {
        //if user can have many channel this will work as well
        //return (boolean) $this->channels()->where('id', $channel->id)->count() ;
        return $this->id === $channel->user_id ;
    }
}
