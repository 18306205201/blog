<?php

namespace App\Providers;

use App\Models\Link;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Observers\LinkObserver;
use App\Observers\ReplyObserver;
use App\Observers\TopicObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Horizon::auth(function ($request) {
            // 是否是站长
            return \Auth::user()->hasRole('Founder');
        });
        Schema::defaultStringLength(191);
        User::observe(UserObserver::class);
        Topic::observe(TopicObserver::class);
        Reply::observe(ReplyObserver::class);
        Link::observe(LinkObserver::class);
    }
}
