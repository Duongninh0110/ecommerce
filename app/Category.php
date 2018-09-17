<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Category extends Model
{
    public function categories (){
    	return $this->hasMany('App\Category', 'parent_id');
    }
}
