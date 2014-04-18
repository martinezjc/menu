@extends('master')

@section('content')

<?php
$UserSessionInfo = Session::get('UserSessionInfo');


if (is_null($UserSessionInfo)) {
?>
<script>
  window.location.href = 'login';
</script>
<?php
    exit();
}
?>

<div id="main-container" class="container">

@if ( !$UserSessionInfo->DealerId )
<div class="container">
<div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li><a href="dealer-settings">Dealers</a>
                </li>
                <li><a href="company-settings" style="background: rgba(255,255,255,0.2);">Companies</a>
                </li>
            </ul>
</div>
@endif

	<div class="col-md-9 space">
	  <a class="btn btn-success" href="#addModal" data-dismiss="modal" data-toggle="modal" id="addCode"><i class="fa fa-plus"></i> Add</a>
	  <a class="btn btn-success" id="generalSettings" href="dealer-settings"><i class="fa fa-times"></i> Cancel</a>
		<table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Warranty Company</th>
          <th>Code</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @foreach($Codes as $Code => $CodeInfo)
        <tr>
          <td>{{ ++ $Code }}</td>
          <td>{{ $CodeInfo->CompanyName }}</td>
          <td>{{ $CodeInfo->DealerCode }}</td>
          <td style="width:10%"><a href="#ModifyModal" data-dismiss="modal" data-toggle="modal" class="btn btn-warning" name="{{ $CodeInfo->AccountNumber }}"><i class="fa fa-pencil-square-o"></i> Modify</a></td>
          <td style="width:10%"><a href="#" class="btn btn-danger" id="deleteCompany" onClick="deleteSettingCode({{ $CodeInfo->AccountNumber }}); return false;"><i class="fa fa-trash-o"></i> Delete</a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
	</div>
</div>

<!-- Modal for add -->
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Add setting</h4>
	      </div>
	      <div class="modal-body row-fluid">
	        <div class="span6">
	        <div class="form-group">    
                <label for="URLUpdate">Dealer</label>
                <select name="DealerId" id="DealerId" class="form-control" style="width:40%">
                	@foreach($Dealers as $Dealer)
                	  <option value="{{ $Dealer->DealerId }}">{{ $Dealer->DealerName }}</option>
                	@endforeach
                </select>
              </div>
	          <div class="form-group">
	            <label for="CompanyId">Company</label>
	            <select name="CompanyId" id="CompanyId" class="form-control" style="width:40%">
	            	@foreach ($Companies as $Company) {
	            	  <option value="{{ $Company->id }}">{{ $Company->CompanyName }}</option>
	            	@endforeach
	            </select>
              </div>
              <div class="form-group">
                <label for="DealerCode">Dealer Code</label>
                <input type="text" name="DealerCode" id="DealerCode" class="form-control" style="width:40%" required>
              </div>
	        </div>
	      </div>
	       
	      <div class="modal-footer">
	        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
	        <button type="button" id="saveCodeInfo" class="btn btn-primary">Save</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- ends modal for new code -->

	<!-- Modal for edit -->
	<div class="modal fade" id="ModifyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Edit setting</h4>
	      </div>
	      <div class="modal-body row-fluid">
	        <div class="span6">
	        <input type="hidden" id="AccountNumberHidden" >
	        <div class="form-group">    
                <label for="DealerIdModified">Dealer</label>
                <select name="DealerIdModified" id="DealerIdModified" class="form-control" style="width:40%">
                	@foreach($Dealers as $Dealer)
                	  <option value="{{ $Dealer->DealerId }}">{{ $Dealer->DealerName }}</option>
                	@endforeach
                </select>
              </div>
	          <div class="form-group">
	            <label for="CompanyIdModified">Company</label>
	            <select name="CompanyIdModified" id="CompanyIdModified" class="form-control" style="width:40%">
	            	@foreach ($Companies as $Company) {
	            	  <option value="{{ $Company->id }}">{{ $Company->CompanyName }}</option>
	            	@endforeach
	            </select>
              </div>
              <div class="form-group">
                <label for="DealerCodeModified">Dealer Code</label>
                <input type="text" name="DealerCodeModified" id="DealerCodeModified" class="form-control" style="width:40%" required>
              </div>
	        </div>
	      </div>
	       
	      <div class="modal-footer">
	        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
	        <button type="button" id="saveCodeInfo" class="btn btn-primary" onclick="updateSettingCode($('#AccountNumberHidden').val());">Save</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- ends modal for new company -->

<script src="js/dealer.js" type="text/javascript"></script>
@stop
