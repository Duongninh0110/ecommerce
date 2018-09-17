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


	//Products attributes route

	Route::match(['post', 'get'],'admin/add-attributes/{id}','ProductsController@addAttributes');
	Route::get('/admin/delete-attribute/{id}','ProductsController@deleteAttribute');

});



Route::get('logout', 'AdminController@logout');


