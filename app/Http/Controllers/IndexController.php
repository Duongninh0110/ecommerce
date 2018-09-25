<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\Banner;

class IndexController extends Controller
{
   public function Index(){
   	$products=Product::orderBy('id', 'desc')->where(['status'=>1])->get();

   	// $categories_menu = "";


   	$allCategories=Category::with('categories')->where(['parent_id'=>'0', 'status'=>1])->get();
   	// foreach ($allCategories as $cat) {

   	// 	// $categories_menu = "<div class='panel panel-default'>
				// 	// 				<div class='panel-heading'>
				// 	// 					<h4 class='panel-title'>
				// 	// 						<a data-toggle='collapse' data-parent='#accordian' href='#mens'>
				// 	// 							<span class='badge pull-right'><i class='fa fa-plus'></i></span>

				// 	// 							".$cat->name."
												
				// 	// 						</a>
				// 	// 					</h4>
				// 	// 				</div>
				// 	// 				<div id='mens' class='panel-collapse collapse'>
				// 	// 					<div class='panel-body'>
				// 	// 						<ul>";
				// 	// 						$allSubcategory = Category::where(['parent_id'=> $cat->id])->get();
				// 	// 				   		foreach ($allSubcategory as $subcat) {
				// 	// 				   			$categories_menu .= "<li><a href='#'>".$subcat->name."</a></li>";
				// 	// 				   		}

				// 	// 						$categories_menu .= 

				// 	// 						"


				// 	// 						</ul>
				// 	// 					</div>
				// 	// 				</div>
				// 	// 			</div>



				// 	// 				";
   		
   		
   	// }

   	$banners = Banner::where(['status'=>1])->get();


   	


   	// return view ('/index')->with ('products', $products)->with ('categories_menu', $categories_menu);
   	return view ('/index')->with ('products', $products)->with ('allCategories', $allCategories)->with('banners', $banners);
   }
}
