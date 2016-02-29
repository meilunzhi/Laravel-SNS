<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function getCategories(){
        $categories = Category::where('parent_id',0)->with('subCategories')->paginate(10);
        return $this->render('category.categories')->with('categories',$categories);
    }

    public function getEdit($categoryId){
        return $this->render('category.edit')->with('category',Category::find($categoryId));
    }

    public function postUpdate(Request $request){
        $this->validate($request,[
            'id'   => 'required',
            'name' => 'required'
        ]);
        $category = Category::find($request->input('id'));
        $category->name = $request->input('name');
        $category->save();
        return redirect('admin/category/categories');
    }

    public function getAdd(){
        return $this->render('category.add')->with('categories',Category::where('parent_id',0)->get());
    }

    public function postStore(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'parent_id'=>'required',
        ]);
        Category::create($request->all());
        return redirect('admin/category/categories');
    }
}
