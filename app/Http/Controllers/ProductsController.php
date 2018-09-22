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
use App\products_image;
use App\Cart;
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
    		
            $product->care = $data['care'];

             if(empty($data['status'])){
                $status = 0;

            }else {
                $status = 1;
            }

            $product->status = $status;

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
            
            $product->care = $data['care'];

            if(empty($data['status'])){
                $status = 0;

            }else {
                $status = 1;
            }

            $product->status = $status;

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

        //get product name

        $productImage=Product::find($id);

        //get product image path

        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        //delete file if exist in large folder

        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        //delete file if exist in medium folder

        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        //delete file if exist in small folder

        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }



        //delete from products table
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
            //check SKU



            foreach ($data['sku'] as $key => $value) {

                $attrCountSKU = products_attribute::where('sku',$value )->count();
                if($attrCountSKU>0){return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'SKU already exist please add another sku');}

                $attrCountSize = products_attribute::where(['product_id'=>$id, 'size'=>$data['size']] )->count();
                if($attrCountSize>0){return redirect('admin/add-attributes/'.$id)->with('flash_message_error', $data['size'][$key].' Size already exist please add another size');}

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


    public function products($url = null){
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
           

            $products = Product::whereIn('category_id', $subcat_ids)->where(['status'=>1])->get();
            

        }else

        {
                $products = Product::where(['category_id'=> $categoryDetails->id])->where(['status'=>1])->get();}

        return view ('products.listing')->with('categoryDetails', $categoryDetails)->with('products', $products)->with('allCategories',$allCategories );
    }


    public function product($id = null){

        //show 404 blade if product is disabled
        $countProduct=Product::where(['id'=>$id, 'status'=>1])->count();
        if($countProduct == 0){
            abort(404);
        }



        $allCategories=Category::with('categories')->where(['parent_id'=>'0'])->get();

        // $productDetails=Product::where('id',$id)->first();

        $productDetails=Product::with('attributes')->where('id',$id)->first();
        $productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>"; print_r($productDetails); die;

        $relatedProducts = Product::where('id', '!=', $id)->where('category_id', $productDetails->category_id)->get();
        // $relatedProducts=json_decode(json_encode($relatedProducts));
        // echo "<pre>"; print_r($relatedProducts); die;

        // foreach ($relatedProducts->chunk(3) as $chunk) {
        //     foreach ($chunk as $product){
        //         echo $product; echo "<br>";
        //     }

        //     echo "<br><br><br>";
        // }
        // die;

        //get Product Alt Images
        $productAltImages = products_image::where('product_id', $id)->get();

        // dd($productAltImages);
        $productAltImages = json_decode(json_encode($productAltImages));
        // echo "<pre>"; print_r($productAltImages); die;
        
        $total_stock = products_attribute::where(['product_id'=>$id])->sum('stock');

        // echo $total_stock; die;



        return view('products.details')->with('productDetails', $productDetails)->with('allCategories',$allCategories)->with('productAltImages',$productAltImages)->with('total_stock', $total_stock)->with('relatedProducts', $relatedProducts);
    }

    public function getProductPrice(Request $request){
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $proArr = explode("-",$data['idSize']);
        // echo $proArr[0]; echo $proArr[1]; die;
        $proAttributes = products_attribute::where(['product_id'=>$proArr[0], 'size'=>$proArr[1]])->first();

        echo $proAttributes->price;
        echo '#';
        echo $proAttributes->stock;
    }

    public function addImages(Request $request, $id = null){

        $productDetails=Product::with('images')->where('id', $id)->first();

        if($request->isMethod('post')){

            
            
 
            if($request->hasFile('image')){

                $Image=new products_image;

                $image_tmp = $request->file('image');

                if($image_tmp->isvalid()){
                $extensions = $image_tmp->getClientOriginalExtension();
                $filename = time().".".$extensions;

                //create image path
                $large_image_path = 'images/backend_images/products/large/'.$filename;
                $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                $small_image_path = 'images/backend_images/products/small/'.$filename;
                

                //resize image

                Image::make($image_tmp)->resize(1200,1200)->save($large_image_path);
                Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                $Image->image = $filename;
                $Image->product_id = $id;
                $Image->save();
                }
            }

            return redirect('admin/add-images/'.$id)->with('flash_message_success', 'Your Product successfully Created');
            

        }


        return view('admin.products.add_images')->with('productDetails', $productDetails)->with('flash_message_success', 'Your Product Images successfully added');
    }

    public function deleteAltImage($id = null){

        $image = products_image::find($id);

        //get product image path

        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        //delete file if exist in large folder

        if(file_exists($large_image_path.$image->image)){
            unlink($large_image_path.$image->image);
        }

        //delete file if exist in medium folder

        if(file_exists($medium_image_path.$image->image)){
            unlink($medium_image_path.$image->image);
        }

        //delete file if exist in small folder

        if(file_exists($small_image_path.$image->image)){
            unlink($small_image_path.$image->image);
        }

        $image->delete();

        return redirect()->back()->with('flash_message_success', 'Your Product Images successfully added');
    }

    public function editAttributes(Request $request, $id = null){

        if($request->isMethod('post')){

            $data = $request->all();
         
            // echo "<pre>"; print_r($data); die;
            foreach ($data['idAttr'] as $key => $value) {
                $productAttribute=products_attribute::where(['id'=>$value])->first();
                $productAttribute->price = $data['price'][$key];
                $productAttribute->stock = $data['stock'][$key];

                $productAttribute->save();
            }

            return redirect()->back()->with('flash_message_success', 'The Attribute is successfully updated!');

        }
    }

    public function addtocart(Request $request){

       

        $data = $request->all();
        // echo "<pre>"; print_r($data); die;

        if(empty($data['user_email'])){
            $data['user_email'] = '';
        }

        if(empty($data['session_id'])){
            $data['session_id'] = '';
        }

        // dd($data['size']);

        $size = explode("-", $data['size']);

        $cart = new Cart;
        $cart->product_id = $data['product_id'];        
        $cart->product_name = $data['product_name'];
        $cart->product_code = $data['product_code'];
        $cart->product_color = $data['product_color'];
        $cart->price = $data['price'];
        $cart->quantity = $data['quantity'];
        $cart->size = $size[1];
        $cart->session_id = $data['session_id'];
        $cart->user_email = $data['user_email'];
        $cart->save();
        
    }


}
