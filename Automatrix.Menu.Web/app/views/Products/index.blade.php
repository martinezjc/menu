@extends('layouts.scaffold')

@section('main')

<h1>All Products</h1>

<p>{{ link_to_route('Products.create', 'Add new Product') }}</p>

@if ($Products->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>ProductName</th>
				<th>DisplayName</th>
				<th>Cost</th>
				<th>SellingPrice</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($Products as $Product)
				<tr>
					<td>{{{ $Product->ProductName }}}</td>
					<td>{{{ $Product->DisplayName }}}</td>
					<td>${{{ $Product->Cost }}}</td>
					<td>${{{ $Product->SellingPrice }}}</td>
                    <td>{{ link_to_route('Products.edit', 'Edit', array($Product->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('Products.destroy', $Product->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no Products
@endif

@stop
