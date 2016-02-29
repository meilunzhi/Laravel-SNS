<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use JPush;
use App\Model\Behavior;

class Push extends Job implements SelfHandling,ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    const ATTENTION = 'AttentionUser';
    const PRAISE = 'Article';
    const REVIEW = 'Article';
    const REWARD = 'Reward';

    private $behavior;

    /**
     * Create a new job instance.
     *
     */
    public function __construct(Behavior $behavior){
        $this->behavior = $behavior;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(JPush $jPush)
    {
        $this->behavior();
        $jPush->push()
            ->setPlatform('android')
            ->addAlias('123456')
            ->setNotificationAlert('Hi JPush!Hi JPush!')
            ->addAndroidNotification('Hi JPush!Hi JPush!','Hi title',1,[])
            ->setMessage('msg content','msg title','msg type',[])
            ->send();
    }

    private function behavior(){
        $this->behavior->save();
    }
}
