@extends('layouts.admin') 

@section('toolbar')
<div class="row">
	<div class="col-md-9">
        <a class="btn btn-success" href="{{URL::action('ProductController@add', array('id' => $dealerId))}}">Add new product</a>
	</div>
	<div class="col-md-3"></div>
</div>
@stop
@section('content')
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Company</th>
			<th>Product</th>
			<th>Display Name</th>
			<th>Cost</th>
			<th>Price</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($products as $product)
		<tr>
			<td>{{ $product->CompanyName }}</td>
			<td>{{ $product->ProductName }}</td>
			<td>{{ $product->DisplayName }}</td>
			<td>${{ number_format($product->Cost, 2, '.', ',') }}</td>
			<td>${{ number_format($product->SellingPrice, 2, '.', ',') }}</td>
			@if (!$currentUser->DealerId)
			<td>
			   <a class="btn btn-warning" href="{{action('ProductController@view', array('id' => $product->DealerId, 'productId' => $product->ProductId))}}"><i class="fa fa-pencil-square-o"></i> Modify</a>
			</td>
			@else
			  <a class="btn btn-warning" href="{{action('ProductController@view', array('id' => $currentUser->DealerId, 'productId' => $product->ProductId))}}"><i class="fa fa-pencil-square-o"></i> Modify</a>
			@endif
			<td>
				{{ Form::open(array('method' => 'DELETE', 'route' => array('products.destroy', $product->ProductId))) }} 
				{{Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
				{{Form::close() }}
			</td>
		</tr>
		@endforeach 
	</tbody>
</table>
@stop