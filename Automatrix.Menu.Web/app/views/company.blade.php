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

<div>

@if ( !$UserSessionInfo->DealerId )
<div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li><a href="dealer-settings">Dealers</a>
                </li>
                <li><a href="company-settings" style="background: rgba(255,255,255,0.2);">Companies</a>
                </li>
            </ul>
</div>
@endif

<div class="row">
	<div class="col-md-9">
	  <a class="btn btn-success" id="newCompany" data-dismiss="modal" data-toggle="modal" href="#companyModal"><i class="fa fa-file-o"></i> Add New Company</a>
	  <div style="margin-bottom:2%"></div>
	</div> <!-- ends container class -->
	<div class="col-md-3">
	</div>
</div>

<div class="row">
	<div class="col-md-10">
		<table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Company Name</th>
          <th>URL</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @foreach($Companies as $Company => $CompanyInfo)
        <tr>
          <td>{{ ++ $Company }}</td>
          <td>{{ $CompanyInfo->CompanyName }}</td>
          <td>{{ $CompanyInfo->URL }}</td>
          <td style="width:10%"><a href="#companyUpdateModal" data-dismiss="modal" data-toggle="modal" class="btn btn-warning" name="{{ $CompanyInfo->id }}"><i class="fa fa-pencil-square-o"></i> Modify</a></td>
          <td style="width:10%"><a href="#" class="btn btn-danger" id="deleteCompany" onClick="deleteCompany({{ $CompanyInfo->id }}); return false;"><i class="fa fa-trash-o"></i> Delete</a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
	</div>
	<div class="col-md-2">
		
	</div>

	<!-- Modal for new company -->
	<div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Add New Company</h4>
	      </div>
	      <div class="modal-body row-fluid">
	        <div class="span6">
	          <div class="form-group">
	            <label for="CompanyId">Company Name</label>
	            <input type="text" name="CompanyName" id="CompanyName" class="form-control" style="width:40%" required>
	          </div>
                   <div class="form-group">
                    <label for="URL">URL</label>
                    <input type="text" name="URL" id="URL" class="form-control" style="width:40%" required>
                  </div>
                  <div class="form-group">
                    <label for="Username">Username</label>
                    <input type="text" name="Username" id="Username" class="form-control" style="width:40%" required>
                  </div>
                  <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="text" name="Password" id="Password" class="form-control" style="width:40%" required>
                  </div>
	        </div>
	      </div>
	       
	      <div class="modal-footer">
	        <button type="button" id="cancelCompany" data-dismiss="modal" class="btn btn-default">Cancel</button>
	        <button type="button" id="saveCompanyInfo" class="btn btn-primary">Save Company</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- ends modal for new company -->

	<!-- Modal for update company -->
	<div class="modal fade" id="companyUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Update Company</h4>
	      </div>
	      <div class="modal-body row-fluid">
	        <div class="span6">
	          <div class="form-group">
	            <label for="CompanyId">Company Name</label>
	            <input type="text" name="CompanyNameUpdate" id="CompanyNameUpdate" class="form-control" style="width:40%" required>
                  </div>
                  <div class="form-group">    
                    <label for="URLUpdate">URL</label>
                    <input type="text" name="URLUpdate" id="URLUpdate" class="form-control" style="width:40%" required>
                  </div>
                  <div class="form-group">
                    <label for="UsernameUpdate">Username</label>
                    <input type="text" name="UsernameUpdate" id="UsernameUpdate" class="form-control" style="width:40%" required>
                  </div>
                  <div class="form-group">
                    <label for="PasswordUpdate">Password</label>
                    <input type="text" name="PasswordUpdate" id="PasswordUpdate" class="form-control" style="width:40%" required> 
                  </div>
	        </div>
	      </div>
	       
	      <div class="modal-footer">
	        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
	        <button type="button" id="updateCompanyInfo" class="btn btn-primary">Update</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- ends modal for new company -->
</div>
<script src="js/company.js" type="text/javascript"></script>
@stop
