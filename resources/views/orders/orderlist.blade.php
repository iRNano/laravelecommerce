@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-lg-6 offset-lg-3">
		
		<table class="table table-striped">
			<thead>
				<th>Reference Number</th>
				<th>User</th>
				<th>Total</th>
				<th>Status</th>
				<th>Details</th>
				@if(Auth::user()->isAdmin)
				<th>Actions</th>
				@endif
			</thead>

			<tbody>
				@foreach($orders as $order)
				<tr>
					<td>{{$order->refNo}}</td>
					<td>{{$order->user->name}}</td>
					<td>{{$order->total}}</td>
					<td>{{$order->status->name}}</td>
					<td>
						@foreach($order->products as $product)
						{{-- $order->products used the pivot table products_orders to look at the details of ALL the products linked to the order  --}}
							<p>Name: {{$product->name}}</p>
							<p>Price: {{$product->price}}</p>
							<p>Qty: {{$product->pivot->quantity}}</p>
							{{-- pivot refers to the columns associated to the product in the pivot table --}}
						@endforeach
					</td>
					@if(Auth::user()->isAdmin && $order->status_id == 1)
						<td>
							<form action="/orders/{{$order->id}}" method="POST">
								@csrf
								{{method_field('PATCH')}}
								<select name="status">
									<option selected>Select action</option>
									@foreach(App\Status::all() as $status)
										@if($status->id > 1)
											<option value="{{$status->id}}">{{$status->name}}</option>
										@endif
									@endforeach
								</select>
								<button type="submit" class="btn btn-success">Apply</button>
							</form>
				{{-- 			<form action="/orders/{{$order->id}}" method="POST">
								@csrf
								{{method_field('DELETE')}}
								<button type="submit" class="btn btn-danger">Cancel Order</button>
							</form> --}}
						</td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
		
	</div>
</div>
@endsection