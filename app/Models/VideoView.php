<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
    ];

    public function video ()
    {
        return $this->belongsTo(Video::class);
    }

    public function scopeByUser ($query, User $user)
    {
        return $query->where('user_id', $user->id) ;
    }

    public function scopeLatestByUser ($query, User $user)
    {
        return $query->byUser($user)->orderBy('created_at', 'DESC')->take(1);
    }

    public function scopeLatestByIp ($query, $ip_address)
    {
        return $query->where('ip_address', $ip_address)->orderBy('created_at', 'DESC')->take(1);
    }

}