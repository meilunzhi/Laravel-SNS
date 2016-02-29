<?php

namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\Model\User
 *
 * @property-write mixed $password
 */
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'uid', 'login_type', 'nickname', 'profile_img', 'score', 'phone', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * 定义密码修改器
     * @param $value
     */
    public function setPasswordAttribute($value){
        $this->attributes['password'] = md5($value);
    }

    /**
     * 定义登录类型修改器
     * @param $value
     */
    public function setLoginTypeAttribute($value)
    {
        $this->attributes['login_type'] = intval($value);
    }

    /**
     * 定义获取器
     * @param $value
     * @return string
     */
    public function getLoginTypeAttribute($value){
        return $value == 1 ? '微博' : ($value == 2 ? '微信' : ($value == 3 ? 'QQ' : '其他'));
    }

    /**
     * 定义签到一对一关联
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sign()
    {
        return $this->hasOne('App\Model\Sign');
    }

    /**
     * 定义一对多关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Model\Article');
    }
    /**
     * 定义一对多关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(){
        return $this->hasMany('App\Model\Article');
    }

    /**
     * 多对多关联,获取用户关注的用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attentions(){
        return $this->belongsToMany('App\Model\User','attention_users','user_id','attention_user_id');
    }
    /**
     * 多对多关联,获取用户的关注者
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers(){
        return $this->belongsToMany('App\Model\User','attention_users','attention_user_id','user_id');
    }

    /**
     * 多对多关联,获取用户关联的社区
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function focus(){
        return $this->belongsToMany('App\Model\Category','attention_categories','user_id','category_id');
    }

    /**
     * 多对多关联,获取用户收藏的帖子
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collects(){
        return $this->belongsToMany('App\Model\Article','collections','user_id','article_id');
    }

    /**
     * 一对一关联，环信用户名
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function easemob(){
        return $this->hasOne('App\Model\Easemob');
    }
}
