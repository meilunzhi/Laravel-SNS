<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Praise extends Model
{
    protected $table = 'praises';

    protected $fillable = ['user_id','article_id'];
}
