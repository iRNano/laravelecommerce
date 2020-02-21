<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	public function user(){
		return $this->belongsTo('App\User');
	}

	pubction function status(){
		return $this->hasOne('App\Status');
	}

	//belongsToMany links this order to the products table via the products_orders pivot table
	//withPivot contains ALL the colums that are not foreign keys and are not id's nor timestamps in the pivot table
		//we can separate multiple columns in the pivot table that are not id's or foreign keys or timestapms with commas
	//with Timestapms() automatically populates the timestamps as soon as an entry for products_orders is created
	public function products(){
		return $this->belongsToMany('App\Product', 'products_orders')->withPivot('quantity', 'subtotal')->withTimestamps();
	}
}
