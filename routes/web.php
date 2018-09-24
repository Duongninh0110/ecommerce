<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');

// Route::get('/admin', 'AdminController@login');

Route::match(['get','post'],'/admin', 'AdminController@login');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Category/Listing pages

Route::get('/products/{url}', 'ProductsController@products');

// Product Details route
Route::get('/product/{id}', 'ProductsController@product');

//get Product attribute price

Route::get('/get-product-price', 'ProductsController@getProductPrice');

Route::group(['middleware' => ['auth']], function(){

	Route::get('admin/dashboard', 'AdminController@dashboard');
	Route::get('admin/settings', 'AdminController@settings');
	Route::get('admin/check-pwd','AdminController@chkPassword');
	Route::match(['get','post'], 'admin/update-pwd', 'AdminController@updatePassword');

	// Categories route

	Route::match(['post', 'get'],'admin/add-category','CategoryController@addCategory');
	Route::get('/admin/view-categories','CategoryController@viewCategories');
	Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
	Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');

	// Products route


	
	Route::match(['post', 'get'],'admin/add-product','ProductsController@addProduct');
	Route::get('admin/view-products', 'ProductsController@viewProducts');
	Route::match(['post', 'get'],'admin/edit-product/{id}','ProductsController@editProduct');
	Route::match(['get','post'],'/admin/delete-product/{id}','ProductsController@deleteProduct');
	Route::match(['get','post'],'/admin/delete-product-image/{id}','ProductsController@deleteProductImage');
	Route::get('admin/delete-alt-image/{id}', 'ProductsController@deleteAltImage');

	//Products attributes route

	Route::match(['post', 'get'],'admin/add-attributes/{id}','ProductsController@addAttributes');
	Route::match(['post', 'get'],'admin/edit-attributes/{id}','ProductsController@editAttributes');
	Route::match(['post', 'get'],'admin/add-images/{id}','ProductsController@addImages');
	Route::get('/admin/delete-attribute/{id}','ProductsController@deleteAttribute');

	//Coupons Routes
	Route::match(['post', 'get'],'admin/add-coupon','CouponsController@addCoupon');
	Route::match(['post', 'get'],'admin/edit-coupon/{id}','CouponsController@editCoupon');
	Route::get('admin/view-coupons', 'CouponsController@viewCoupons');
	Route::get('admin/delete-coupon/{id}', 'CouponsController@deleteCoupon');
	Route::post('cart/apply-coupon', 'ProductsController@applyCoupon');

	//Banner Routes
	Route::match(['post', 'get'],'admin/add-banner','BannersController@addBanner');



});



Route::get('logout', 'AdminController@logout');
Route::match(['post', 'get'], 'add-cart', 'ProductsController@addtocart');
Route::match(['post', 'get'], 'cart', 'ProductsController@cart');
Route::get('/cart/delete-product/{id}', 'ProductsController@deleteCartProduct');
Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductsController@updateCartQuantity');

