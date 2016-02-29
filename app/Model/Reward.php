<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model{
    protected $table = 'rewards';

    protected $fillable = ['user_id','article_id','score'];

    public function user(){
        return $this->hasOne('App\Model\User','id','user_id');
    }
}
