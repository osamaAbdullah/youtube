<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

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
}
