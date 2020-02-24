@extends('layouts.app')
@section('content')

	<div class="row">
		<div class="col-lg-8 offset-2">
			<form action="/products/{{$product->id}}" method="POST" enctype="multipart/form-data">
				@csrf
				{{method_field('PUT')}}
				<div class="form-group pt-5">
					<label for="name">Name: </label>
					<input type="text" name="name" class="form-control" value="{{$product->name}}">
				</div>
				<div class="form-group">
					<label for="name">Description: </label>
					<textarea name="description" class="form-control">{{$product->description}}</textarea>
				</div>
				<div class="form-group">
					<label for="name">Price: </label>
					<input type="number" name="price" class="form-control" value="{{$product->price}}">
				</div>
				<div class="form-group">
					<img src="{{asset($product->img_path)}}" style="max-height: 200px">
					<label for="image">Upload Image: </label>
					<input type="file" name="image" id="image" class="form-control">
				</div>
				<div class="form-group">
					<select name="category">
						@foreach($categories as $category)
							<option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-success">Update</button>
			</form>
		</div>	
			
			
	</div>

@endsection
