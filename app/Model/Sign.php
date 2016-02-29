<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
    protected $table = 'signs';

    protected $fillable = ['user_id','sign_count'];

    /**
     * 定义一对一用户从属关联
     */
    public function user(){
        return $this->belongsTo('App\Model\User');
    }

    /**
     * 定义时间获取器
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return explode(' ',$value)[0];
    }
}
