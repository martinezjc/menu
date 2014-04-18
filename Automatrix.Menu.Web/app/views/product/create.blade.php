@extends('layouts.scaffold')

@section('main')

<h1>Create Product</h1>

{{ Form::open(array('route' => 'Products.store')) }}
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
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


