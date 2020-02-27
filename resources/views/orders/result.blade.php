@extends('layouts.app')
@section('content')
	<div class="row">
		<div class="col-lg-6 offset-lg-3 text-center">
			<h4>You're order {{$refNo}} has been successfully created</h4>
			<a href="/products" class="btn btn-primary">Back to Catalog</a>	
		</div>
	</div>
	
@endsection