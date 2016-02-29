<?php

namespace App\Http\Controllers\Api;

use App\Jobs\Push;
use App\Model\Article;
use App\Model\AttentionCategory;
use App\Model\Easemob;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Model\AttentionUser;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;
use Response;
use Log;
use App\Model\Sign;
use Event;
use App\Events\UserScore;
use App\Utils\Utils;
use App\Model\Collection as Collect;
use Cache;
use Storage;
use App\Model\Behavior;
use JPush;

class UserController extends Controller
{
    use \App\Utils\UserScore;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Utils::success(User::all()->toArray());
    }

    /**
     * 保存新用户
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('uid',(string)$request->input('uid'))->get()->get(0);
        if(!is_null($user)){
            return Utils::error($user->toArray());
        }
        $user = User::create($request->all());
        Easemob::create([   //环信 极光用户名
            'user_id' => $user->id,
            'easemob_name' => $request->input('easemob_name'),
            'jpush_id' => $request->input('jpush_id')
        ]);
        return Utils::success($user->toArray());
    }

    /**
     * 显示用户信息
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('sign','easemob')->find($id);
        return $user?Utils::success($user->toArray()):Utils::error();
    }

    /**
     * 更新用户信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->nickname = $request->input('nickname')?:$user->nickname;
        $user->phone = $request->input('phone')?:$user->phone;
        if($imgUrl = $this->uploadImg($request)){
            $user->profile_img = $imgUrl;
        }
        if($password = $request->input('password')){
            $user->password = $password;
        }
        $user->save();
        return Utils::success($user->toArray());
    }

    /**
     * 删除用户
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Utils::success(User::destroy($id));
    }

    /**
     * 用户签到
     * @param $request
     * @return mixed
     */
    public function sign(Request $request){
        $user = User::find($request->input('id'));
        $sign = $user->sign;
        if(!Cache::has('user:sign:'.$request->input('id'))){  //用户今天未签到
            Cache::put('user:sign:'.$request->input('id'),true,intval( (strtotime(date('Y-m-d',strtotime('+1 day')))-time()) / 60 ));
            $this->doSign($sign);
            return $this->doScore($user);
        }
        return Utils::error($user->toArray());
    }

    /**
     * 用户登录
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request){
        $phone = $request->input('phone');
        $password = md5($request->input('password'));
        $user = User::with('easemob')->where('phone',$phone)->where('password',$password)->get()->get(0);
        if(!is_null($user)){
            return Utils::success($user->toArray());
        }
        return Utils::error('用户名或密码错误');
    }

    /**
     * 获取用户关注的社区
     * @param $id
     * @return array
     */
    public function focus($id){
        return ($user = User::with('focus')->find($id))?Utils::success($user->toArray()):Utils::error();
    }

    /**
     * 获取用户关注的用户
     * @param $id
     * @return array
     */
    public function attention($id){
        return ($user = User::with('attentions')->find($id)) ? Utils::success($user->toArray()) : Utils::error();
    }

    /**
     * 获取用户的关注者
     * @param $id
     * @return array
     */
    public function follower($id){
        return ($user = User::with('followers')->find($id))?Utils::success($user->toArray()) : Utils::error();
    }

    /**
     * 获取用户发表的帖子
     * @param $id
     * @return array
     */
    public function articles($id){
        $articles = Article::with('comments','images','category')->where('user_id',$id)->get();
        return !$articles->isEmpty()?Utils::success($articles->toArray()):Utils::error();
    }

    /**
     * 获取用户收藏的文章
     * @param $id
     * @return array
     */
    public function collects($id){
        $user = User::with('collects')->find($id);
        return Utils::success($user->toArray());
    }

    /**
     * 用户关注用户
     * @param Request $request
     * @return array
     */
    public function attentionUser(Request $request){
        $userId = $request->input('user_id');
        $attentionUserId = $request->input('attention_user_id');
        if(!AttentionUser::where('user_id',$userId)->where('attention_user_id',$attentionUserId)->get()->isEmpty()){
            return Utils::error('is attention!');
        }
        if(is_null(User::find($userId)) || is_null(User::find($attentionUserId))){
            return Utils::error('user not exists!');
        }
        $behavior = new Behavior([
            'user_id' => intval($request->input('user_id')),
            'behavior_id' => intval($request->input('attention_user_id')),
            'behavior_type' => Push::ATTENTION
        ]);
        $this->dispatch(new Push($behavior));
        return AttentionUser::create([
            'user_id' => intval($request->input('user_id')),
            'attention_user_id' => intval($request->input('attention_user_id'))
        ])?Utils::success():Utils::error();
    }

    /**
     * 取消关注用户
     * @param Request $request
     * @return array
     */
    public function unAttentionUser(Request $request){
        $coll = AttentionUser::where('user_id',$request->input('user_id'))->where('attention_user_id',$request->input('attention_user_id'))->get();
        return $coll->isEmpty()?Utils::error('no attention!!'):($coll->get(0)->delete()?Utils::success('no attention success!'):Utils::error('no attention falise!'));
    }
    /**
     * 判断用户是否关注某个用户
     * @param $userId
     * @param $attentionId
     * @return array
     */
    public function isAttentionUser($userId,$attentionId){
        return AttentionUser::where('user_id',$userId)->where('attention_user_id',$attentionId)->get()->isEmpty()?
        Utils::success('no attention!'):
        Utils::error('is attention!');
    }

    /**
     * 用户关注社区
     * @param Request $request
     * @return array
     */
    public function focusCategory(Request $request){
        if(!AttentionCategory::where('user_id',$request->input('user_id'))->where('category_id',$request->input('category_id'))->get()->isEmpty()){
            return Utils::error('is focus!');
        }
        return AttentionCategory::create([
            'user_id' => $request->input('user_id'),
            'catefoty_id' => $request->input('category_id')
        ])?Utils::success():Utils::error();
    }

    /**
     * 取消关注社区
     * @param Request $request
     * @return array
     */
    public function unFocusCategory(Request $request){
        $coll = AttentionCategory::where('user_id',$request->input('user_id'))->where('category_id',$request->input('category_id'))->get();
        return $coll->isEmpty()?Utils::error('未关注!'):($coll->get(0)->delete()?Utils::success('取关成功!'):Utils::error('取关失败!'));
    }

    /**
     * 判断用户是否关注过社区
     * @param $categoryId
     * @param $userId
     * @return array
     */
    public function isFocusCategory($categoryId,$userId){
        return (!AttentionCategory::where('user_id',$userId)->where('category_id',$categoryId)->get()->isEmpty())?
         Utils::error('已经关注过了!'):
         Utils::success('还未关注！');
    }

    /**
     * 获取用户的环信 用户名
     * @param $userId
     * @return array
     */
    public function easemob($userId){
        $coll = Easemob::where('user_id',$userId)->get();
        return !$coll->isEmpty()?Utils::success($coll->get(0)->toArray()):Utils::error();
    }

    /**
     * 用户头像上传
     * @param Request $request
     * @return string
     */
    private function uploadImg(Request $request){
        $filename = date('Y-m-d').'/'.uniqid().'.jpg';
        if($data = $request->input('photo')){
            $ret = Storage::put($filename,base64_decode($data));
            return $ret?$filename:false;
        }
        return false;
    }

    /**
     * 执行签到
     * @param Sign $sign
     * @return Boolean
     */
    private function doSign(Sign $sign){
        $sign->sign_count = $sign->sign_count + 1;
        return (boolean)$sign->save();
    }

    /**
     * 执行积分操作
     * @param User $user
     * @return mixed
     */
    private function doScore(User $user){
        $result = Event::fire(new UserScore($user,$this->getSignInScore()))[0];
        $result->sign;
        return Utils::success($result->toArray());
    }

}
