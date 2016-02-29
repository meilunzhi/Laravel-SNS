<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Easemob extends Model
{
    protected $table = 'easemobs';
    protected $fillable = ['user_id','easemob_name'];

    /**
     * 属于关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Model\User');
    }
}
