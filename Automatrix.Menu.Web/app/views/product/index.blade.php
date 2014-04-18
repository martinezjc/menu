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
			<td>${{ $product->Cost }}</td>
			<td>${{ $product->SellingPrice }}</td>
			<td>{{ link_to_route('products.edit', 'Modify', array($product->ProductId), array('class' => 'btn btn-warning')) }}</td>
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