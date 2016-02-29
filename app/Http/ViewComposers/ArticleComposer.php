<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Model\Article;

class ArticleComposer {

    /**
     * Create a new article composer.
     *
     * @param  Article  $article
     * @return void
     */
    public function __construct(Article $article)
    {
        // service container 会自动解析所需的参数
        $this->article = $article;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('articles', Article::with('user','category','comments')->paginate(20));
    }

}