@extends('layouts.admin')

@section("scripts")
    {{ HTML::script('scripts/dealer.js'); }}
@stop

@section('toolbar')
<div class="row">
	<div class="col-md-9">
	  	<a class="btn btn-success" id="userModalLink" href="{{action('DealerController@add')}}"><i class="fa fa-file-o"></i> Add new dealer</a>
    </div>
    <div class="col-md-3">
    </div>
</div>
@stop

@section('content')
<div class="row">   
	<div class="col-md-9">
	    <table class="table table-striped">
	    	<thead>
	    		<tr>
					<th>#</th>
		            <th>Dealer Name</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($dealers as $dealer => $dealerInfo)
				<tr>
					<td>{{{ ++ $dealer }}}</td>
					<td>{{{ $dealerInfo->DealerName }}}</td>
					<td style="width:10%"><a class="btn btn-warning" href="{{action('DealerController@view', array('id' => $dealerInfo->DealerId))}}"><i class="fa fa-pencil-square-o"></i> Modify</a></td>
					<td style="width:10%"><a href="#" class="btn btn-danger" onclick="deleteDealer({{ $dealerInfo->DealerId }})"><i class="fa fa-trash-o"></i> Delete</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
    </div>
	<div class="col-md-3">
	</div>
</div>

@stop