<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function products(){
    	//if products() method of Category has been called, it will pull ALL the products for theat category and we can also pull their respective properties
    	return $this->hasMany('App\Product');
    }
}
