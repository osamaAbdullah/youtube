<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    public function video ()
    {
        return $this->belongsTo(Video::class);
    }
}
