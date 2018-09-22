<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function attributes(){
    	return $this->hasMany('App\products_attribute', 'product_id');
    }

     public function images(){
    	return $this->hasMany('App\products_image', 'product_id');
    }
}
