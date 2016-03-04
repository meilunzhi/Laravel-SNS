<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return 'Hello World!';
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['prefix'=>'admin','namespace'=>'Admin'], function () {

    /** 后台管理 **/
    Route::controllers([
        'dashboard' => 'DashboardController',
        'user' => 'UserController',
        'article' => 'ArticleController',
        'category' => 'CategoryController'
    ]);
});

/** API接口 **/
Route::group(['prefix'=>'api','namespace'=>'Api'],function(){
    /**
     * 用户相关
     */
    Route::post('user/sign', 'UserController@sign');   //用户签到
    Route::post('user/login', 'UserController@login');     //用户登录
    Route::get('user/{id}/articles','UserController@articles');  //用户帖子
    Route::get('user/{id}/focus','UserController@focus');  //用户关注的社区
    Route::get('user/{id}/attentions','UserController@attention');     //用户关注的用户
    Route::get('user/{id}/followers','UserController@follower');  //该用户的关注者
    Route::get('user/{id}/collects','UserController@collects');  //该用户收藏文章
    Route::post('user/attention','UserController@attentionUser');   //关注用户
    Route::post('user/unattention','UserController@unAttentionUser');   //取消关注用户
    Route::get('user/{userId}/attention_user/{attentionId}/isattention','UserController@isAttentionUser');   //是否关注用户
    Route::post('user/focus','UserController@focusCategory');   //关注社区
    Route::post('user/unfocus','UserController@unFocusCategory');   //取消关注社区
    Route::get('category/{categoryId}/user/{userId}/isfocus','UserController@isFocusCategory');   //是否关注社区
    Route::get('user/{userId}/easemob','UserController@easemob');
    Route::resource('user','UserController');

    /**
     * 分类相关
     */
    Route::resource('categories','CategoryController');
    Route::get('categories/{id}/articles','ArticleController@index'); //获取某个分类下帖子

    /**
     * 帖子相关
     */
    Route::post('article/comment','ArticleController@comment');    //帖子评论
    Route::resource('article','ArticleController');
    Route::post('article/reward','ArticleController@reward');  //打赏
    Route::post('article/praise','ArticleController@praise');  //点赞
    Route::post('article/unpraise','ArticleController@unPraise');  //取消点赞
    Route::get('article/{articleId}/user/{userId}/ispraise','ArticleController@isPraise');     //是否点赞
    Route::get('article/{articleId}/user/{userId}/iscollect','ArticleController@isCollect');     //是否收藏
    Route::post('article/collect','ArticleController@collect');    //收藏文章
    Route::post('article/uncollect','ArticleController@unCollect');    //取消收藏
    Route::post('article/reward','ArticleController@reward');  //文章打赏
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
//    $this->get('/admin','Admin\AdminController@index');

    Route::get('admin/login', 'Admin\AuthController@getLogin');
    Route::post('admin/login', 'Admin\AuthController@postLogin');
    Route::get('admin/register', 'Admin\AuthController@getRegister');
    Route::post('admin/register', 'Admin\AuthController@postRegister');
    Route::get('admin', 'Admin\AdminController@index');
});
