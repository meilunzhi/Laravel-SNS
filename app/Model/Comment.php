<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['article_id','user_id','parent_comment_id','content'];

    /**
     * 属于关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article(){
        return $this->belongsTo('App\Model\Article');
    }

    /**
     * 属于关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Model\User');
    }

    public function parentComment(){
        return $this->belongsTo('App\Model\Comment','parent_comment_id','id');
    }

    public function childComment(){
        return $this->hasMany('App\Model\Comment','parent_comment_id','id');
    }
}
