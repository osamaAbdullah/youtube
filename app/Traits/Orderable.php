<?php

namespace App\Traits;

trait Orderable
{
    public function scopeLatestFirst ($query)
    {
        return $query->orderBy('created_at','desc');
    }

    //you can user any think witch orders our result of query back here
}
