<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Collection;

class UserScore extends Event
{
    use SerializesModels;

    private $user;
    private $score;

    /**
     * Create a new event instance.
     *
     */
    public function __construct($user,$score)
    {
        $this->user = $user;
        $this->score = $score;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

    /**
     * 事件处理
     */
    public function handle(){
        if(!$this->check()){
            return $this->user;
        }
        return $this->change();
    }

    /**
     * 操作用户积分
     */
    public function change(){
        $this->user->score = $this->user->score + $this->score;
        $this->user->save();
        return $this->user;
    }

    /**
     * 确定用户是否可以执行改变积分事件
     */
    private function check(){
        if($this->score < 0){   //减积分
            return $this->user->score >= abs($this->score);
        }
        return true;
    }
}
