@extends('layouts.app')

@section('content')

<h1 class="text-center jumbotron">Catalog</h1>
<div class="row ml-auto">
	<div class="col-lg-3 offset-9">
		<div class="mr-auto">
			<a href="/products/create" class="btn btn-success">Add Product</a>
			<a href="/cart" class="btn btn-success">My Cart</a>
		</div>
	</div>
</div>
<div class="filter pb-5">
	{{-- Filtering --}}
	{{-- Add a button for ALL --}}
	<a href="/products" class="btn btn-info">ALL</a>
	{{-- Add buttons for each category --}}
	@foreach(App\Category::all() as $category)
		<a href="/categories/{{$category->id}}" class="btn btn-info">{{$category->name}}</a>
		{{-- This uses the categories route (/categories and needs the show() method of the Category Controller) --}}
	@endforeach



</div>
<div class="row">
	@if(Session::has('message'))
		<h4>{{Session::get('message')}}</h4>
	@endif
</div>
<div class="row">
	@foreach($products as $product)
	<div class="col-lg-4" >
		<div class="card" style="width:100%">
			<div class="card-header">
				<h5 class="card-title">{{$product->name}}</h5>
			</div>
			<img src="{{asset($product->img_path)}}" style="max-height: 300px">
			<div class="card-body">				
				<p class="card-text">Description: {{$product->description}}</p>
				<p class="card-text">PHP {{$product->price}}</p>
				<a href="/products/{{$product->id}}" class="btn btn-info">View Details</a>	
			</div>
								
			@if(!Auth::check() || !Auth::user()->isAdmin)
				<div class="card-footer">					
					<form action="/cart" method="POST">
						@csrf
						<input type="hidden" name="item_id" value="{{$product->id}}">
						<input type="number" name="quantity" class="form-control" min="1" value="1">
						<button type="submit" class="btn btn-success mt-1">Add To Cart</button>	
					</form>				
				</div>				
			@endif
		</div>
	</div>
	@endforeach
</div>
@endsection