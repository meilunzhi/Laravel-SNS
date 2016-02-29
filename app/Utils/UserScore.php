<?php
/**
 * 用户积分构件
 * User: USER
 * Date: 2016/1/14
 * Time: 16:35
 */
namespace App\Utils;
use App\Model\User;
trait UserScore{
    /**
     * 获取用户签到增加积分
     */
    public function getSignInScore(){
        return 10;
    }
    /**
     * 获取用户发帖增加积分
     */
    public function getWriteScore(){
        return 10;
    }

    /**
    *   获取用户评论增加积分
    */
    public function getCommentScore(){
        return 10;
    }

    /**
     * 获取用户点赞积分
     */
    public function getPraiseScore(){
        return 10;
    }
}