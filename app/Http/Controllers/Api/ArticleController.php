<?php

namespace App\Http\Controllers\Api;

use App\Events\UserScore;
use App\Model\Comment;
use App\Model\Reward;
use Illuminate\Http\Request;
use App\Model\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Utils\Utils;
use App\Model\Image;
use App\Model\Category;
use App\Model\Praise;
use App\Model\Collection;
use Event;
use Storage;
use Log;

class ArticleController extends Controller
{
    use \App\Utils\UserScore;
    /**
     * 显示帖子
     * @param  $categoryId
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId='')
    {
        if($categoryId != ''){
            return Utils::success(
                Article::where('category_id',$categoryId)
                    ->with('images','user','category','comments.childComment')
                    ->orderBy('id','desc')
                    ->simplePaginate(10)
                    ->items()
            );
        }
       return Utils::success(
           Article::with('images','user','category','comments.childComment')
               ->orderBy('id','desc')
               ->simplePaginate(10)
               ->items()
       );
    }

    /**
     * 发表帖子
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = Article::create($request->all());
        //触发用户发帖事件
        Event::fire(new UserScore(User::find($request->input('user_id')),$this->getWriteScore()));
        try{
            $imgUrlArr = $this->uploadImg($request);
            for($i=0; $i<count($imgUrlArr);$i++){
                Image::create([
                    'article_id'=>$article->id,
                    'url'=>$imgUrlArr[$i]
                ]);
            }
        }catch(\Exception $e){
            Log::info('发表帖子传图异常信息：'.$e->getMessage());
        }finally{
            $article->images;
            return Utils::success($article->toArray());
        }
    }

    /**
     * 显示帖子
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($article = Article::with('images','comments.childComment.user','comments.user','user')->find($id)){
            $articleTmp = Article::find($id);
            $articleTmp->view = $article->view + 1;
            $articleTmp->save();
            return Utils::success($article->toArray());
        }
        return Utils::error();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 帖子删除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Utils::success(Article::destroy($id));
    }

    /**
     * 帖子新增评论
     * @param Request $request
     * @return array
     */
    public function comment(Request $request){
        $comment = Comment::create($request->all());
        if(0 != $comment->id ){
            Event::fire(new UserScore(User::find($request->input('user_id')),$this->getCommentScore()));
            return Utils::success($comment->toArray());
        }
        return Utils::error();
    }

    /**
     * 文章点赞
     * @param Request $request
     * @return array
     */
    public function praise(Request $request){
        $article = Article::find($request->input('article_id'));
        $article->praise = $article->praise + 1;
        $article->save();
        Praise::create([
            'user_id' => $request->input('user_id'),
            'article_id' => $request->input('article_id')
        ]);
        Event::fire(new UserScore(
            User::find($request->input('user_id')),
            $this->getPraiseScore()
        ));
        return !empty($article) ? Utils::success('') : Utils::error();
    }

    /**
     * 取消点赞
     * @param Request $request
     * @return array
     */
    public function unPraise(Request $request){
        $praise = Praise::where('user_id',$request->input('user_id'))->where('article_id',$request->input('article_id'))->delete();
        $article = Article::find($request->input('article_id'));
        $article->praise = $article->praise - 1;
        $article->save();
        return 0!=$praise?Utils::success(''):Utils::error();
    }

    /**
     * 获取用户是否点赞过
     * @param $articleId
     * @param $userId
     * @return array
     */
    public function isPraise($articleId,$userId){
        return Praise::where('article_id',$articleId)->where('user_id',$userId)->get()->isEmpty()?
            Utils::success(''):
            Utils::error();
    }

    /**
     * 文章收藏
     * @param Request $request
     * @return array
     */
    public function collect(Request $request){
        if(is_null(User::find($request->input('user_id'))) || is_null(Article::find($request->input('article_id')))){
            return Utils::error('用户或文章不存在！');
        }
        $coll = Collection::where('user_id',$request->input('user_id'))->where('article_id',$request->input('article_id'))->get();
        if(!$coll->isEmpty()){
            return Utils::error('收藏过了！');
        }
        Collection::create([
            'user_id'   =>  $request->input('user_id'),
            'article_id' => $request->input('article_id')
        ]);
        return Utils::success('');
    }

    /**
     * 文章取消收藏
     * @param Request $request
     * @return array
     */
    public function unCollect(Request $request){
        return Collection::where('user_id',$request->input('user_id'))->where('article_id',$request->input('article_id'))->delete()?
            Utils::success(''):
            Utils::error('');
    }

    /**
     * 判断用户是否收藏过文章
     * @param $articleId
     * @param $userId
     * @return array
     */
    public function isCollect($articleId,$userId){
        return Collection::where('article_id',$articleId)->where('user_id',$userId)->get()->isEmpty()?
            Utils::success(''):
            Utils::error();
    }

    /**
     * 文章打赏
     * @param Request $request
     * @return array
     */
    public function reward(Request $request){
        $user = User::find($request->input('user_id'));
        $article = Article::find($request->input('article_id'));
        $score = intval($request->input('score'));
        Log::info('user_id'.$request->input('user_id').'article'.$request->input('article_id'));
        if(is_null($user) || is_null($article)){
            return Utils::error('user or article not exists');
        }
        if($user->score != Event::fire(new UserScore(clone $user,-$score))[0]->score){    //积分操作成功
            Reward::create($request->all());
            return Utils::success(
                Event::fire(new UserScore($article->user,$score))[0]->toArray()
            );
        }
        return Utils::error('score not enough');
    }

    /**
     * 上传文件
     * @param Request $request
     * @return array
     * @throws
     */
    private function uploadImg(Request $request){
        $imgSize = $request->input('imgSize');  //图片数量
        $imgArr = [];
        for($i = 0; $i < $imgSize; $i++){
            $photo = $request->input('photo'.$i);
            if(!empty($photo)){
                $filename = date('Y-m-d').'/'.uniqid().'.jpg';
                $ret = Storage::put($filename,base64_decode($photo));
                $imgArr[$i] =  $filename;
            }
        }
        if(!empty($imgArr)){
            return $imgArr;
        }
        throw new \Exception('photo not exists');
    }
}
