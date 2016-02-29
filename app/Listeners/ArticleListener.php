<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class ArticleListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * 初始化访问量和点赞
     *
     * @param $article
     */
    public function creating($article)
    {
        $article->view = 0;
        $article->praise = 0;
    }

    public function deleting($article){
        $article->images()->delete();
        $article->comments()->delete();
    }

}
