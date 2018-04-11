<?php

namespace App\Providers;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\Video;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Channel::class => 'App\Policies\ChannelPolicy',
        Video::class => 'App\Policies\VideoPolicy',
        Comment::class => 'App\Policies\CommentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
