<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Behavior extends Model{
    protected $table = 'behavior';
    protected $fillable = ['user_id','behavior_id','behavior_type'];
}
