<?php

namespace App\Http\Controllers\Admin;

use App\Model\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\Reward;

class ArticleController extends Controller{
    public function getArticles(){
        return $this->render('article.article');
    }

    public function getDelete($articleId){
        Article::destroy($articleId);
        return $this->render('article.article');
    }

    public function getReward($articleId){
        $rewards = Reward::where('article_id',$articleId)->with(['user'])->paginate(10);
        $title = Article::find($articleId)->title;
        return $this->render('article.reward')->with('rewards',$rewards)->with('title',$title);
    }

    public function getComment($articleId){
        $comments = Comment::where('article_id',$articleId)->where('parent_comment_id',0)->with('childComment')->get();
        $title = Article::find($articleId)->title;
        return $this->render('article.comment')->with('comments',$comments)->with('title',$title);
    }
}
