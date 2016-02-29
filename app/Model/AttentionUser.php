<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AttentionUser extends Model
{
    protected $table = 'attention_users';
    protected $fillable = ['user_id','attention_user_id'];
}
