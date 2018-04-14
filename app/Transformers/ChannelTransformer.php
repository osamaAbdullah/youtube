<?php

namespace App\Transformers;

use App\Models\Channel;
use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'channel'
    ];

    public function transform (Channel $channel)
    {

        return [
            'name' => $channel->name,
            'channelUrl' => url('channels/' . $channel->slug . '/show'),
            'image' => url('images/' . $channel->image . '/view'),
        ];
    }

}