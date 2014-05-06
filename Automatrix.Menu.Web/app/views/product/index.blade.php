@extends('layouts.admin') 

@section('toolbar')
<div class="row space">
	<div class="col-md-9 space">
        <a class="btn btn-success" href="{{URL::action('ProductController@add', array('id' => $dealerId))}}">Add new product</a>
        <a @if (!$currentUser->DealerId) href="{{$baseUrl}}/dealers/{{$products[0]->DealerId}}/edit" @else href="{{$baseUrl}}/dealers/{{$currentUser->DealerId}}/edit" @endif class="btn btn-success" ><i class="fa fa-times"></i> Cancel</a>
	</div>
	<div class="col-md-3"></div>
</div>
@stop
@section('content')
<div class="col-md-12 space">
<table class="table table-striped table-bordered space">
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
			<td width="5%">
			   <a class="btn btn-warning" href="{{action('ProductController@view', array('id' => $product->DealerId, 'productId' => $product->ProductId))}}"><i class="fa fa-pencil-square-o"></i> Modify</a>
			</td>
			<td width="5%">
			   <a class="btn btn-danger" href="{{URL::action('ProductController@delete', array('id' => $product->DealerId, 'productId' => $product->ProductId))}}"> Delete</a> 
			</td>
			@else
			<td width="5%">
			  <a class="btn btn-warning" href="{{action('ProductController@view', array('id' => $currentUser->DealerId, 'productId' => $product->ProductId))}}"><i class="fa fa-pencil-square-o"></i> Modify</a>
			</td>
			<td width="5%">
			  <a class="btn btn-danger" href="{{URL::action('ProductController@delete', array('id' => $currentUser->DealerId, 'productId' => $product->ProductId))}}"> Delete</a> 
			</td>
			@endif
		</tr>
		@endforeach 
	</tbody>
</table>
</div>
@stop