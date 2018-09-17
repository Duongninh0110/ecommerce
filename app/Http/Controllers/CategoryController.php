<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $request){

    	if($request->isMethod('post')){


    		$data = $request->all();


    		// echo '<pre>'; print_r($data); die;

    		$category = new Category;
            $category->parent_id = $data['parent_id'];
    		$category->name = $data['category_name'];
    		$category->description = $data['description'];
    		$category->url = $data['url'];

            if(empty($data['status'])){
                $status = 0;

            }else {
                $status = 1;
            }


            $category->status = $status;
    		$category->save();



    		return redirect('/admin/view-categories')->with('flash_message_success', 'Your Category successfully Created');
    	}

        $levels = Category::where(['parent_id'=>0])->get();
    	return view ('admin.categories.add_category')->with('levels', $levels);

    }

    public function viewCategories(){

    	$categories = Category::get();

    	return view('admin.categories.view_categories')->with('categories', $categories);
    }


    public function editCategory(Request $request, $id=null ){

        if($request->isMethod('post')){

            $data=$request->all();

            // dd($data);

            $category = Category::find($id);

            $category->name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->description = $data['description'];
            $category->url = $data['url'];

            if(empty($data['status'])){
                $status = 0;

            }else {
                $status = 1;
            }

            $category->status = $status;

            $category->save();
            return redirect('/admin/view-categories')->with('flash_message_success', 'Your Category successfully updated');
        }
        $levels = Category::where(['parent_id'=>0])->get();

        $categoryDetails=Category::where(['id'=>$id])->first();

        return view('/admin.categories.edit_category')->with('categoryDetails',$categoryDetails )->with('levels', $levels) ;


    }

    public function deleteCategory($id=null){

        if(!empty($id)){
            $category = Category::find($id);
            $category ->delete();

            return redirect('/admin/view-categories')->with('flash_message_success', 'Your Category successfully deleted');

        }

    }



}
