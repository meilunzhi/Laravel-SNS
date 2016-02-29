<?php

namespace App\Providers;

use App\Listeners\CategoryListener;
use App\Model\Category;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Model\User;
use App\Model\Article;
use App\Listeners\UserListener;
use App\Listeners\ArticleListener;
use Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        /**
         * 用户模型观察
         */
        User::observe(new UserListener);

        /**
         * 帖子模型观察
         */
        Article::observe(new ArticleListener);

        /**
         * 分类模型观察
         */
        Category::observe(new CategoryListener());

        /**
         * 用户积分事件
         */
        Event::listen('App\Events\UserScore', function($event){
            return $event->handle();
        });

    }
}
