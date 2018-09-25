<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use App\Banner;

class BannersController extends Controller
{
    public function addBanner(Request $request){

    	if($request->isMethod('post')){
    		$data = $request->all();
    		$banner = new Banner;    		
    		$banner->title = $data['title'];
    		$banner->link = $data['link'];

    		if($request->hasFile('image')){
    			$image_tmp = Input::file('image');
    			if($image_tmp->isvalid()){

    				$extensions = $image_tmp->getClientOriginalExtension();
    				$filename = time().'.'.$extensions;
    				// echo $filename; die;
    				$banner_path = 'images/frontend_images/banners/'.$filename;

    				//resize images

    				Image::make($image_tmp)->resize(1140,411)->save($banner_path);
    				
    				//store images

    				$banner->image = $filename;
    			}
    		}

    		if(empty($data['status'])){
                $status = 0;

            }else {
                $status = 1;
            }

            $banner->status = $status;

    		$banner->save();



    		return redirect('/admin/view-banners')->with('flash_message_success', 'Your Banner successfully Created');
    	}
    	return view('admin.banners.add_banner');
    }

    public function viewBanners(){
    	$allBanners = Banner::get();

    	return view('admin.banners.view_banners')->with('allBanners', $allBanners);

    }

    public function editBanner(Request $request, $id = null){

    	$banner = Banner::find($id);

    	$data = $request->all();

    	if($request->isMethod('post')){
    		$data = $request->all();
    		   		
    		$banner->title = $data['title'];
    		$banner->link = $data['link'];

    		if($request->hasFile('image')){
    			$image_tmp = Input::file('image');
    			if($image_tmp->isvalid()){

    				$extensions = $image_tmp->getClientOriginalExtension();
    				$filename = time().'.'.$extensions;
    				// echo $filename; die;
    				$banner_path = 'images/frontend_images/banners/'.$filename;

    				//resize images

    				Image::make($image_tmp)->resize(1140,411)->save($banner_path);
    				
    				//store images

    				$banner->image = $filename;
    			}
    		}

    		if(empty($data['status'])){
                $status = 0;

            }else {
                $status = 1;
            }

            $banner->status = $status;

    		$banner->save();



    		return redirect('/admin/view-banners')->with('flash_message_success', 'Your Banner successfully Edited');
    	}

    	return view('admin.banners.edit_banner')->with('banner', $banner);

    }

    public function deleteBanner($id = null){
    	$banner = Banner::find($id);
    	$banner ->delete();
    	return redirect()->back()->with('flash_message_success', 'Your Banner successfully deleted!');  
    }
}
