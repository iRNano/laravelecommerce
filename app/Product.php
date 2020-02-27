<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
    	return $this->belongsTo('App\Category');
    	// establishes the many-to-one relationship of Products to a category.
    	//naming convention: singular
    }

    public function orders(){
    	return $this->belongsToMany('App\Order','products_orders')->withPivot('quantity', 'subtotal')->withTimestamps();
    }
}


