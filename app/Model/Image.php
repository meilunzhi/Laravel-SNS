<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['article_id','url'];
    /**
     * 定义属于关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article(){
        return $this->belongsTo('App\Mode\Article');
    }
}
