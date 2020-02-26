@extends('layouts.app')

@section('content')
	<div class="row">
		@if(Session::has('message'))
			<h4>{{Session::get('message')}}</h4>
		@endif
	</div>
	<div class="row">
		<a href="/products" class="btn btn-success ml-auto">Back to Catalog</a>
	</div>
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<form method="POST" action="/categories">
				@csrf
				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" name="name" id="id" class="form-control">
				</div>
				<button class="btn btn-success" type="submit">Add new category</button>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<form method="POST" action="/products" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<label for="name">Name: </label>
					<input type="text" name="name" id="name" class="form-control">
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<textarea name="description" id="description" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<label for="price">Price</label>
					<input type="number" name="price" id="price" class="form-control" step="0.01" min="0">
				</div>
				<div class="form-group">
					<label for="image">Upload Image: </label>
					<input type="file" name="image" id="image" class="form-control">
				</div>
				<div class="form-group">
					<select name="category">
						@foreach($categories as $category)
							<option value="{{$category->id}}">{{$category->name}}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-success">Add new product</button>
					
			</form>
		</div>
	</div>
@endsection