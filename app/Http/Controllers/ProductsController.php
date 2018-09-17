<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;

use Auth;
use Session;
use App\Category;
use App\Product;

use App\products_attribute;

class ProductsController extends Controller
{
    public function addProduct(Request $request){

    	if($request->isMethod('post')){
    		$data = $request->all();

    		// echo '<pre>'; print_r($data); die;

    		$product = new Product;
            
            if(!empty($data['category_id'])){
            	$product->category_id = $data['category_id'];

            }else{
            	return redirect('/admin/add-product')->with('flash_message_error', '!Under Category is not set');
            }
    		$product->product_name = $data['product_name'];
    		$product->product_code = $data['product_code'];
    		$product->product_color = $data['product_color'];
    		if(!empty($data['description'])){
    			$product->description = $data['description'];
    		}else{
    			$product->description = '';
    		}
    		$product->price = $data['price'];
    		//Upload images
    		if($request->hasFile('image')){
    			$image_tmp = Input::file('image');
    			if($image_tmp->isvalid()){

    				$extensions = $image_tmp->getClientOriginalExtension();
    				$filename = time().'.'.$extensions;
    				$large_image_path = 'images/backend_images/products/large/'.$filename;
    				$medium_image_path = 'images/backend_images/products/medium/'.$filename;
    				$small_image_path = 'images/backend_images/products/small/'.$filename;
    				//resize images
    				Image::make($image_tmp)->resize(1200,1200)->save($large_image_path);
    				Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
    				Image::make($image_tmp)->resize(300,300)->save($small_image_path);
    				//store images

    				$product->image = $filename;
    			}
    		}
    		



    		$product->save();



    		return redirect('/admin/view-products')->with('flash_message_success', 'Your Product successfully Created');
    	}

    	$categories = Category::where(['parent_id'=>0])->get();
    	$categories_dropdown = "<option selected disabled>Select</option>";
    	foreach ($categories as $cat){

    		$categories_dropdown .= "<option value=".$cat->id.">".$cat->name."</option>";
    		$subcategories = Category::where(['parent_id'=>$cat['id']])->get();
    		foreach ($subcategories as $subcat){

    			$categories_dropdown .= "<option value=".$subcat->id.">--".$subcat->name."</option>";

    		}

    	}

    	// echo "<pre>"; print_r($categories_dropdown); die;


        
    	return view ('admin.products.add_product')->with ('categories_dropdown', $categories_dropdown);

    }


    public function viewProducts(){



    	$products = Product::get();

    	$products = json_decode(json_encode($products));

    	foreach ($products as $key=>$value){

    		$category_name = Category::where(['id'=>$value->category_id])->first();
    		$products[$key]->category_name = $category_name->name;  
    	}

    	// echo  "<pre>"; print_r($products); die;
    	return view('admin.products.view_products')->with ('products',$products);
    }

    public function editProduct(Request $request, $id=null){

        if($request->isMethod('post')){
            $data = $request->all();

            // echo '<pre>'; print_r($data); die;

            $product = Product::find($id);
            
            if(!empty($data['category_id'])){
                $product->category_id = $data['category_id'];

            }else{
                return redirect('/admin/add-product')->with('flash_message_error', '!Under Category is not set');
            }
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else{
                $product->description = '';
            }
            $product->price = $data['price'];
            //Upload images
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isvalid()){

                    $extensions = $image_tmp->getClientOriginalExtension();
                    $filename = time().'.'.$extensions;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    //resize images
                    Image::make($image_tmp)->resize(1200,1200)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                    //store images

                    $product->image = $filename;
                }
            }else{
              $product->image = $data['current_image'];  
            }
            



            $product->save();



            return redirect('/admin/view-products')->with('flash_message_success', 'Your Product successfully Updated');

            }

        $productDetails=Product::find($id);

        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option selected disabled>Select</option>";
        foreach ($categories as $cat){

            if($cat->id == $productDetails->category_id ){

                $select='selected';

            }else {

                $select = '';
            }

            $categories_dropdown .= "<option value='".$cat->id."'". $select.">".$cat->name."</option>";
            $subcategories = Category::where(['parent_id'=>$cat['id']])->get();
            foreach ($subcategories as $subcat){

                if($subcat->id == $productDetails->category_id ){

                $select='selected';

                }else {

                    $select = '';
                }

                $categories_dropdown .= "<option value='".$subcat->id."'". $select.">--".$subcat->name."</option>";

            }

        }

        // echo "<pre>"; print_r($categories_dropdown); die;

        


        
        return view ('admin.products.edit_product')->with ('categories_dropdown', $categories_dropdown)->with ('productDetails', $productDetails);




        
    }

    public function deleteProduct($id=null){

        $product=Product::find($id);
        $product->delete();

        return redirect('/admin/view-products')->with('flash_message_success', 'Your Product successfully deleted');


    }

    public function deleteProductImage($id = null){
        $product=Product::where(['id'=>$id])->update(['image'=>'']);
        

        return redirect()->back()->with('flash_message_success', 'Your Product image successfully deleted');
    }

    public function addAttributes(Request $request, $id ){

        $productDetails = Product::find($id);

        $attributes = $productDetails->attributes()->get();
        // dd($attributes);


        if($request->isMethod('post')){

            $data=$request->all();
            // echo "<pre>"; print_r($data); die;

            foreach ($data['sku'] as $key => $value) {
                $products_attribute =New products_attribute;
                $products_attribute->product_id = $id;
                $products_attribute->sku = $value;
                $products_attribute->size = $data['size'][$key];
                $products_attribute->price = $data['price'][$key];
                $products_attribute->stock = $data['stock'][$key];
                $products_attribute->save();
            }

            return redirect('admin/add-attributes/'.$id)->with('flash_message_success', 'Your Product Attribute successfully added');

            

        }

        


        return view ('admin.products.add_attributes')->with ('productDetails', $productDetails)->with('attributes', $attributes);



    }


    public function deleteAttribute($id = null){

        $attribute=products_attribute::find($id);
        $attribute-> delete();

        return redirect()->back()->with('flash_message_success', 'Your Product Attribute successfully deleted');

    }


    public function products($url){
        $countCategories=Category::where(['url'=>$url])->count();
        // echo $countCategories; die;
        if($countCategories==0){
            return view('products.404');die;
        }

        $allCategories=Category::with('categories')->where(['parent_id'=>'0'])->get();
        $categoryDetails = Category::where('url', $url)->first();

        if ($categoryDetails->parent_id==0){

            $subCategories=Category::where(['parent_id'=> $categoryDetails->id])->get();

            $subcat_ids = [];
            foreach ($subCategories as  $subcat) {
                $subcat_ids[] =$subcat->id;
            }
           

            $products = Product::whereIn('category_id', $subcat_ids)->get();
            

        }else

        {
                $products = Product::where(['category_id'=> $categoryDetails->id])->get();}

        return view ('products.listing')->with('categoryDetails', $categoryDetails)->with('products', $products)->with('allCategories',$allCategories );


    }
}
