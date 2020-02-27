<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	public function user(){
		return $this->belongsTo('App\User');
	}

	public function status(){
		return $this->belongsTo('App\Status');
	}

	//belongsToMany links this order to the products table via the products_orders pivot table
	//withPivot contains ALL the colums that are not foreign keys and are not id's nor timestamps in the pivot table
		//we can separate multiple columns in the pivot table that are not id's or foreign keys or timestapms with commas
	//with Timestapms() automatically populates the timestamps as soon as an entry for products_orders is created
	//the table doesn't need to be specified IF AND ONLY IF the following criteria are satisfied:
		//name of the pivot should have components that are SINGULAR
		//the order of the related tables in the pivot are in ALPHABETICAL ORDER
		//e.g order_product ->belongsToMany('\App\Product')->withPivot...
	public function products(){
		return $this->belongsToMany('App\Product', 'products_orders')->withPivot('quantity', 'subtotal')->withTimestamps();
	}
}
