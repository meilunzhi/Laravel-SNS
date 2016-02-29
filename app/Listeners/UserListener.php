<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Sign;
use Log;

class UserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * 初始化用户积分
     *
     * @param $user
     */
    public function creating($user)
    {
        $user->score = 0;
    }

    /**
     * 初始化用户签到数据
     * @param $user
     */
    public function created($user){
        $sign = Sign::create(['user_id'=>$user->id,'sign_count' => 0]);
        Log::info('Created user success:'.$user->toJson());
        Log::info('Created user sign success:'.$sign->toJson());
    }

}
