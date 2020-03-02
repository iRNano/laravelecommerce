<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//to be able to use laravel's softdeletes

class Product extends Model
{
	use SoftDeletes; //tells the model that all entries should be soft deleted
    public function category(){
    	return $this->belongsTo('App\Category');
    	// establishes the many-to-one relationship of Products to a category.
    	//naming convention: singular
    }

    public function orders(){
    	return $this->belongsToMany('App\Order','products_orders')->withPivot('quantity', 'subtotal')->withTimestamps();
    }
}


