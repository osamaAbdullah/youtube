<?php

namespace App\Jobs;

use Faker\Provider\File;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class UploadVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filename;

    public function __construct($filename)
    {
        $this->filename = $filename ;
    }

    public function handle()
    {
        $file = storage_path() . '/uploads/videos/' . $this->filename ;
        if (Storage::disk('s3drop')->put($this->filename, fopen($file, 'r+'))) {
            File::delete($file);
        }
    }
}
