<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
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
}
