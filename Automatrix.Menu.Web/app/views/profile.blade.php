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
                <li><a href="dealer-settings" style="background: rgba(255,255,255,0.2);">Dealers</a>
                </li>
                <li><a href="company-settings">Companies</a>
                </li>
            </ul>
</div>
@endif

<div class="row">
	<div class="col-md-9">
		<a class="btn btn-success" id="updateUser"><i class="fa fa-file-o"></i> Update</a>
		<a href="home" class="btn btn-success">Cancel</a>
	</div>
</div>
<div class="row" style="padding-top:1%;">
	<div class="col-md-9">
		    	<div class="form-group">
		    		<input type="hidden" name="UserId" id="UserId" value="{{ $Users->UserId }}">
		    		<label for="FirstNameModified">First Name</label>
		    		<input type="text" name="FirstNameModified" value="{{ $Users->FirstName }}" id="FirstNameModified" style="width:40%;" class="form-control" required>
		    	</div>
		    	<div class="form-group">
		    		<label for="LastNameModified">Last Name</label>
		    		<input type="text" name="LastNameModified" id="LastNameModified" value="{{ $Users->LastName }}" style="width:40%;" class="form-control" required>
		    	</div>
		    	<div class="form-group">
		    		<label for="EmailModified">Email</label>
		    		<input type="text" name="EmailModified" id="EmailModified" value="{{ $Users->Email }}" style="width:40%;" class="form-control" required>
		    	</div>
		    	<div class="form-group">
		    		<label for="UsernameModified">Username</label>
		    		<input type="text" name="UsernameModified" id="UsernameModified" value="{{ $Users->Username }}" style="width:40%;" class="form-control" required>
		    	</div>
		    	<div class="form-group">
		    		<label for="PasswordModified">Password</label>
		    		<input type="password" name="PasswordModified" id="PasswordModified" value="{{ $Users->Password }}" style="width:40%;" class="form-control" required>
		    		<input type="hidden" name="PasswordRemember" value="{{ $Users->Password }}" id="PasswordRemember">
		    	</div>
		    	@if ( is_null($UserSessionInfo->DealerId) )
		    	<div class="form-group">
		    		<label for="isAdministratorModified">Administrator </label>
		    		<input type="checkbox" name="isAdministratorModified" id="isAdministratorModified" @if ( $Users->Administrator == True ) checked @endif >
		    	</div>
		    	@endif
	</div>
	<div class="col-md-3"></div>
</div>
<script src="js/user.js"></script>
@stop