<?php

namespace App\Jobs;

use App\Models\Channel;
use Faker\Provider\File;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel;
    public $fileId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Channel $channel,$fileId)
    {
        $this->channel = $channel ;
        $this->fileId = $fileId ;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = storage_path() . '/uploads/images/' . $this->fileId ;

        Image::make($path)->encode('png')->fit(40, 40, function ($c){
            $c->upsize();
        })->save();

//        if ( storage::disk('s3Images')->put('profile/' . $this->fileId, fopen($path,'r+')) ){
//            File::delete($path);
//        }

        $this->channel->image = $this->fileId ;
        $this->channel->update();

    }
}
