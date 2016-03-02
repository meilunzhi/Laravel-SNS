<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\AttentionUser;
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
        $data = $request->all();
        $user = User::find($data['id']);
        $user->nickname = $data['nickname'];
        $user->score = $data['score'];
        $user->phone = $data['phone'];
        $user->save();
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

    public function getRemove($userId,$attentionUserId){
        AttentionUser::where('user_id',$userId)->where('attention_user_id',$attentionUserId)->delete();
        return redirect()->back();
    }

    private function getUser($userId){
        return User::find($userId);
    }
}