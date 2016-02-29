<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class CategoryListener
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
     * @param $category
     */
    public function deleting($category){
        $category->articles()->delete();
    }

}
