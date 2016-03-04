<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\Category;
use App\Model\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;

class DashboardController extends Controller{

    public function getDashboard(){
        return $this->render('dashboard.dashboard')->with([
            'users'=>User::count(),
            'articles'=>Article::count(),
            'comments'=>Comment::count(),
            'categories'=>Category::count()
        ]);
    }
}
