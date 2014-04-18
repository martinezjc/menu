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

<div class="container">
    <div class="row">
    	<div class="col-md-12">
    	  <div class="form-group">
    	   <label for="CompanyIdSetting">Company: </label> <a href="#addProductCompanyModal" data-dismiss="modal" data-toggle="modal" class="pull-right btn btn-success" style="margin-top:20px;"><i class="fa fa-file-o"></i> Add new Product</a>
            	<select name="CompanyIdSetting" id="CompanyIdSetting" class="form-control" style="width:40%;"> 
    			@foreach ($Companies as $Company)
    			  <option value="{{{ $Company->id }}}">{{{ $Company->CompanyName }}}</option>
    			@endforeach
    		</select>
    	  </div>
          
          <div id="productsCompanyTable"></div>

    	</div>
    </div>

    <!-- Modal for new company product -->
	<div class="modal fade" id="addProductCompanyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Add Product</h4>
	      </div>
	      <div class="modal-body row-fluid">
	        <div class="span6">
	          <div class="form-group">
	            <label for="CompanyIdNew">Company Name</label>
	            <select name="CompanyIdNew" id="CompanyIdNew" class="form-control" style="width:40%;">
	               @foreach ($Companies as $Company)
    			     <option value="{{{ $Company->id }}}">{{{ $Company->CompanyName }}}</option>
    			   @endforeach
	            </select>
	          </div>
                   <div class="form-group">
                    <label for="ProductName">Product Name</label>
                    <input type="text" name="ProductName" id="ProductName" class="form-control" style="width:40%" required>
                  </div>
                  <div class="form-group">
                    <label for="WSMethod">Webservice Method</label>
                    <input type="text" name="WSMethod" id="WSMethod" class="form-control" style="width:40%" required>
                  </div>
                  <div class="form-group">
                    <label for="Parameters">Parameters (separate values with commas)</label>
                    <input type="text" name="Parameters" id="Parameters" class="form-control" style="width:60%" required>
                  </div>
	        </div>
	      </div>
	       
	      <div class="modal-footer">
	        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
	        <button type="button" id="saveCompanyProductInfo" class="btn btn-primary">Save</button>
	      </div>
	    </div>
	  </div>
	</div>

    <!-- Modal for edit company product -->
	<div class="modal fade" id="productUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Edit Product</h4>
	      </div>
	      <div class="modal-body row-fluid">
	        <div class="span6">
	          <div class="form-group">
	            <label for="CompanyIdModified">Company Name</label>
	            <select name="CompanyIdModified" id="CompanyIdModified" class="form-control" style="width:40%;">
	               @foreach ($Companies as $Company)
    			     <option value="{{{ $Company->id }}}">{{{ $Company->CompanyName }}}</option>
    			   @endforeach
	            </select>
	          </div>
                   <div class="form-group">
                    <label for="ProductNameModified">Product Name</label>
                    <input type="text" name="ProductNameModified" id="ProductNameModified" class="form-control" style="width:40%" required>
                  </div>
                  <div class="form-group">
                    <label for="WSMethodModified">Webservice Method</label>
                    <input type="text" name="WSMethodModified" id="WSMethodModified" class="form-control" style="width:40%" required>
                  </div>
                  <div class="form-group">
                    <label for="ParametersModified">Parameters (separate values with commas)</label>
                    <input type="text" name="ParametersModified" id="ParametersModified" class="form-control" style="width:60%" required>
                  </div>
	        </div>
	      </div>
	       
	      <div class="modal-footer">
	        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
	        <button type="button" id="updateCompanyProductInfo" class="btn btn-primary">Update</button>
	      </div>
	    </div>
	  </div>
	</div>   
</div>
<script src="js/company.js" type="text/javascript"></script>
@stop