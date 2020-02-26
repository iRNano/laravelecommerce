@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-lg-8 offset-lg-2">
		<h2 class="text-center">My Cart</h2>
		<table class="table table-striped">
			<thead>
				<th>Name</th>
				<th>Description</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Subtotal</th>
				<th>Actions</th>
			</thead>
			<tbody>
				{{-- {{Use a foreach loop to display the items in their corresponding cells}} --}}
				@if(!empty($details_of_items_in_cart))
					@foreach($details_of_items_in_cart as $product)
					<tr>
						<td>{{$product->name}}</td>
						<td>{{$product->description}}</td>
						<td>{{$product->price}}</td>
						<td>
							<form action="/cart/{{$product->id}}" method="POST">
								@csrf
								{{method_field('PATCH')}}
								<input type="number" name="quantity" value="{{$product->quantity}}" onchange="this.form.submit()" min="1">
							</form>
						</td>
						<td>{{$product->subtotal}}</td>
						<td>
							<form action="/cart/{{$product->id}}" method="POST">
								@csrf
								{{method_field('DELETE')}}
								<input type="hidden" name="product_id" value="{{$product->id}}">
								<button class="btn btn-danger" type="submit">Remove Item</button>
							</form>
						</td>
					</tr>
					@endforeach
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>Total: </td>
						<td>{{$total}}</td>
						<td></td>
					</tr>
				@else
					<tr>
						<td colspan="5" class="text-center">No items to display</td>
					</tr>
				@endif
			</tbody>
		</table>
		<div>
			<a href="" class="btn btn-success">Checkout</a>
			<a href="/products" class="btn btn-primary">Add more items</a>
			<form action="/cart/empty" method="POST">
				@csrf
				{{method_field('DELETE')}}
				<button type="submit" class="btn btn-danger">Empty Cart</button>
			</form>
			
		</div>
		
	</div>
</div>

@endsection()