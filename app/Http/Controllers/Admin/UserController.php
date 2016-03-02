<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\AttentionUser;
use App\Model\Collection;
use App\Model\User;
use App\Http\Requests\User\UpdateRequest;

class UserController extends Controller{
    public function getUsers(){
        return $this->render('user.user')->with('users',User::paginate(20));
    }

    public function getEdit($userId){
        return $this->render('user.edit')->with('user',User::find($userId));
    }

    public function postUpdate(UpdateRequest $request){
        User::find($request->input('id'))->update($request->all());
        return redirect('admin/user/users');
    }

    public function getAttention($userId){
        $user = $this->getUser($userId);
        return $this->render('user.attention')->with('nickname',$user->nickname)->with('users',$user->attentions);
    }

    public function getFollow($userId){
        $user = $this->getUser($userId);
        return $this->render('user.fan')->with('nickname',$user->nickname)->with('users',$user->followers);
    }

    public function getCollect($userId){
        $user = $this->getUser($userId);
        return $this->render('user.collect')->with('nickname',$user->nickname)->with('articles',$user->collects);
    }

    public function getRemoveAttention($userId,$attentionUserId){
        AttentionUser::where('user_id',$userId)->where('attention_user_id',$attentionUserId)->delete();
        return redirect()->back();
    }

    public function getRemoveCollect($userId,$articleId){
        Collection::where('user_id',$userId)->where('article_id',$articleId)->delete();
        return redirect()->back();
    }

    private function getUser($userId){
        return User::find($userId);
    }
}