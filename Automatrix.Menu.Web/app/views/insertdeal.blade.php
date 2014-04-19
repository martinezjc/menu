@extends('masterFinance')


@section('content')


<div class="row" style="margin-top:5%;" >



	<div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1 space" style="border: 1px solid black;padding-top: 2%;padding-bottom: 2%;padding-left: 2%;padding-right: 2%;" >
		<form role="form" action="" method:"GET">
		
			<div class="alert alert-info alert-dismissable">
                        	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                	        <strong>Info!</strong> Please Enter Deal Number.
		         </div>

  			<div class="input-group" style="margin-bottom:3%;">
				<span class="input-group-addon"><i class="fa fa-pencil"></i></span>
    				<input type="text" name="Deal" class="form-control" id="Deal" pattern="[0-9]+" placeholder="Enter Deal Number">
  			</div>
 			 <div class="col-md-2 col-md-offset-7 col-xs-4 col-xs-offset-7 " style="margin-top:4%;">  
  				<button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-arrow-right"></i> Continue</button>
			</div >
		</form>
	</div>

</div>







@stop
