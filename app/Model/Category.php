<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //use SoftDeletes;

    protected $table = 'categories';

    /**
     * 属性隐藏
     * @var array
     */
    protected $hidden = ['created_at','updating_at','deleted_at'];

    protected $fillable = ['parent_id','name'];

    /**
     * 定义一对多关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Model\Article');
    }

    public function subCategories(){
        return $this->hasMany('App\Model\Category','parent_id','id');
    }
}
