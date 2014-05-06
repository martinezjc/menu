@extends('layouts.scaffold')

@section('main')

<h1>Show Product</h1>

<p>{{ link_to_route('Products.index', 'Return to all Products') }}</p>

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
		<tr>
			<td>{{{ $Product->ProductName }}}</td>
					<td>{{{ $Product->DisplayName }}}</td>
					<td>${{{ number_format($Product->Cost, 2}}}</td>
					<td>${{{ number_format($Product->SellingPrice, 2) }}}</td>
                    <td>{{ link_to_route('Products.edit', 'Edit', array($Product->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('Products.destroy', $Product->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
