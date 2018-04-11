<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use function Symfony\Component\Debug\Tests\testHeader;

class Channel extends Model
{

    use Searchable;

    protected $fillable =[
        'name',
        'slug',
        'description',
        'image'
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
    public function videos ()
    {
        return $this->hasMany(Video::class);
    }

    public function getRouteKeyName ()
    {
        return 'slug';
    }
    public function subscriptions ()
    {
        return $this->hasMany(Subscription::class);
    }
    public function subscriptionsCount ()
    {
        return $this->subscriptions()->count();
    }
    public function totalVideoViews ()
    {
//        $count = 0;
//        foreach ($this->videos as $video) {
//            $count += $video->viewCount();
//        }
        return $this->hasManyThrough(VideoView::class, Video::class)->count();
    }
}
