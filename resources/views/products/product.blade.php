@extends('layouts.app')

@section('content')

{{-- Put all the details of the item including the image --}}

	<div class="col-lg-8 mx-auto pt-5" >
		@if(Session::has('message'))
			<h4>{{Session::get('message')}}</h4>
		@endif
		
		<div class="card">
			<h5 class="card-title text-center pt-5">{{$product->name}}</h5>	
			<img class="img-card-top" src="{{asset($product->img_path)}}" style="max-height: 500px">	
			<div class="card-body">
			
			<p class="card-text">Description: {{$product->description}}</p>
			<p class="card-text">PHP {{$product->price}}</p>
			<p class="card-text">{{$product->category->name}}</p>
			
			</div>
			@if(Auth::check() && Auth::user()->isAdmin)
				<div class="card-footer mx-auto" style="display: flex">
					<a href="/products/{{$product->id}}/edit" class="btn btn-warning">Edit</a>
					<form method="POST" action="/products/{{$product->id}}">
						@csrf
						{{method_field('DELETE')}}
						{{-- POST and GET are the HTTP verbs that are supported by method, we override it to become DELETE --}}
						<button type="submit" class="btn btn-danger">Delete</button>
					</form>
				</div>
			@endif
		</div>
	</div>


@endsection