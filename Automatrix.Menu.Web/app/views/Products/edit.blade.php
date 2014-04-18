@extends('layouts.scaffold')

@section('main')

<h1>Edit Product</h1>
{{ Form::model($Product, array('method' => 'PATCH', 'route' => array('Products.update', $Product->id))) }}
	<ul>
        <li>
            {{ Form::label('ProductName', 'ProductName:') }}
            {{ Form::text('ProductName') }}
        </li>

        <li>
            {{ Form::label('DisplayName', 'DisplayName:') }}
            {{ Form::text('DisplayName') }}
        </li>

        <li>
            {{ Form::label('Cost', 'Cost:') }}
            {{ Form::text('Cost') }}
        </li>

        <li>
            {{ Form::label('SellingPrice', 'SellingPrice:') }}
            {{ Form::text('SellingPrice') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('Products.show', 'Cancel', $Product->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
