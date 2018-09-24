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



    		return redirect('/admin/add-banner')->with('flash_message_success', 'Your Banner successfully Created');
    	}
    	return view('admin.banners.add_banner');
    }
}
