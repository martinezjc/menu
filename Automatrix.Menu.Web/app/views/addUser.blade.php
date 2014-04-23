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

<div class="row "  style="padding-top:1%;">

  <!--<div @if ( !$UserSessionInfo->DealerId ) class="col-md-5" @else class="col-md-9" @endif> -->
  <div class="col-md-9">
	@if($MyAccount == 0)
			<a class="btn btn-success" id="userModalLink" data-dismiss="modal" data-toggle="modal" href="#userModal"><i class="fa fa-file-o"></i> Add new user</a>
	@endif
	@if (!$UserSessionInfo->DealerId && $MyAccount ==1 )
	    <a class="btn btn-success" id="updateAdminAccount" href="#"><i class="fa fa-floppy-o"></i> Update</a>
	@endif
	<a class="btn btn-success" id="generalSettings" href="<?php if (empty($UserSessionInfo->DealerId)) {
		
		echo "dealer-settings";
	} else {
		echo "general-settings?DealerId=".$UserSessionInfo->DealerId;
	}
	?>"><i class="fa fa-times"></i> Cancel</a>
  </div>
  <div class="col-md-3">
  </div>
</div>



<div class="row">

  <!--<div @if ( !$UserSessionInfo->DealerId ) class="col-md-5" @else class="col-md-9" @endif>-->
  <div class="col-md-9">
  @if($MyAccount == 1)
  		    <div class="col-md-9">
		    	<div class="form-group">
		    		<input type="hidden" name="UserId2" id="UserId2" value="{{ $Users->UserId }}">
		    		<label for="FirstNameModified2">First Name</label>
		    		<input type="text" name="FirstNameModified2" value="{{ $Users->FirstName }}" id="FirstNameModified2" class="form-control" required>
		    	</div>
		    	<div class="form-group">
		    		<label for="LastNameModified2">Last Name</label>
		    		<input type="text" name="LastNameModified2" id="LastNameModified2" value="{{ $Users->LastName }}" class="form-control" required>
		    	</div>
		    	<div class="form-group">
		    		<label for="EmailModified2">Email</label>
		    		<input type="text" name="EmailModified2" id="EmailModified2" value="{{ $Users->Email }}" class="form-control" required>
		    	</div>
		    	<div class="form-group">
		    		<label for="UsernameModified2">Username</label>
		    		<input type="text" name="UsernameModified2" id="UsernameModified2" value="{{ $Users->Username }}" class="form-control" required>
		    	</div>
		    	<div class="form-group">
		    		<label for="PasswordModified2">Password</label>
		    		<input type="password" name="PasswordModified2" id="PasswordModified2" value="{{ $Users->Password }}" class="form-control" required>
		    		<input type="hidden" name="PasswordRemember2" value="{{ $Users->Password }}" id="PasswordRemember2">
		    	</div>
		    	@if ( is_null($UserSessionInfo->DealerId) )
		    	<div class="form-group">
		    		<label for="isAdministratorModified2">Administrator </label>
		    		<input type="checkbox" name="isAdministratorModified2" id="isAdministratorModified2" @if ( $Users->Administrator == True ) checked @endif >
		    	</div>
		    	@endif
		    </div>
</div>
 @else
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>First Name</th>
          <th>Username</th>
        </tr>
      </thead>
      <tbody>
       @foreach ($Users as $User => $UserInfo)
        <tr>
          <td>{{{ ++ $User }}}</td>
          <td>{{{ $UserInfo->FirstName }}}</td>
          <td>{{{ $UserInfo->Username }}}</td>
          <td style="width:10%"><a href="#userUpdateModal" data-dismiss="modal" data-toggle="modal" class="btn btn-warning" name="{{ $UserInfo->UserId }}"><i class="fa fa-pencil-square-o"></i> Modify</a></td>
          @if(!(empty($UserSessionInfo->DealerId)))
        	  <td style="width:10%"><a href="#" class="btn btn-danger" id="deleteUser" onClick="deleteUser({{ $UserInfo->UserId }}); return false;"><i class="fa fa-trash-o"></i> Delete</a></td>
          @else
          		@if(!(empty($DealerIdHidden)))
          		 <td style="width:10%"><a href="#" class="btn btn-danger" id="deleteUser" onClick="deleteUser({{ $UserInfo->UserId }}); return false;"><i class="fa fa-trash-o"></i> Delete</a></td>
         		@endif
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  </div>
  <div class="col-md-1">
  </div>
</div>

<!-- Modal for new User -->
	<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Add New User</h4>
	      </div>
	      <div class="modal-body row">
	        <div class="col-md-9">
			  <div class="form-group">
			    <label for="FirstName">First Name</label>
			  	<input type="text" name="FirstName" id="FirstName" class="form-control" required>
			  </div>
			  <div class="form-group">
			    <label for="LastName">Last Name</label>
			  	<input type="text" name="LastName" id="LastName" class="form-control" required>
			  </div>
			  <div class="form-group">
			    <label for="Email">Email</label>
			  	<input type="text" name="Email" id="Email" class="form-control" required>
			  </div>
			  <div class="form-group">
			    <label for="Username">Username</label>
			  	<input type="text" name="Username" id="Username" class="form-control" required>
			  </div>
			  <div class="form-group">
			    <label for="Password">Password</label>
			  	<input type="password" name="Password" id="Password" class="form-control" required>
			  </div>
			  @if (!(empty($UserSessionInfo->DealerId))) 
			    <input type="hidden"  name="DealerId" id="DealerId" class="form-control" value="{{$UserSessionInfo->DealerId}}">
			  @else
				@if(!(empty($DealerIdHidden)))
					<input type="hidden"  name="DealerId" id="DealerId" class="form-control" value="{{$DealerIdHidden}}">
				@else
					<input type="hidden"  name="DealerId" id="DealerId" class="form-control" value="">
				@endif
			  @endif
			  @if ( is_null($UserSessionInfo->DealerId) )
			  <div class="form-group">
			    <label for="Administrator">Administrator </label>
			    <input type="checkbox" name="isAdministrator" id="isAdministrator">
			  </div>
			  @endif
			</div>
	      </div>
	       
	      <div class="modal-footer">
	      	<label style="float:left;line-height: 2em;">All fields are required. </label>
	        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
	        <button type="button" id="insertUser" class="btn btn-primary">Save</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- ends modal for new User -->

    <!-- Modal for edit User -->
	<div class="modal fade" id="userUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Edit User</h4>
	      </div>
	      <div class="modal-body row">
	        <div class="col-md-9">
			  <div class="form-group">
			    <input type="hidden" name="UserId" id="UserId">
			    <label for="FirstNameModified">First Name</label>
			  	<input type="text" name="FirstNameModified" id="FirstNameModified" class="form-control" required>
			  </div>
			  <div class="form-group">
			    <label for="LastNameModified">Last Name</label>
			  	<input type="text" name="LastNameModified" id="LastNameModified" class="form-control" required>
			  </div>
			  <div class="form-group">
			    <label for="EmailModified">Email</label>
			  	<input type="text" name="EmailModified" id="EmailModified" class="form-control" required>
			  </div>
			  <div class="form-group">
			    <label for="UsernameModified">Username</label>
			  	<input type="text" name="UsernameModified" id="UsernameModified" class="form-control" required>
			  </div>
			  <div class="form-group">
			    <label for="PasswordModified">Password</label>
			  	<input type="password" name="PasswordModified" id="PasswordModified" class="form-control" required>
			  	<input type="hidden" name="PasswordRemember" id="PasswordRemember">
			  </div>
			  @if (!(empty($UserSessionInfo->DealerId))) 
			    <input type="hidden"  name="DealerId" id="DealerIdModified" class="form-control" value="{{$UserSessionInfo->DealerId}}">
			  @else
				@if(!(empty($DealerIdHidden)))
					<input type="hidden"  name="DealerId" id="DealerIdModified" class="form-control" value="{{$DealerIdHidden}}">
				@else
					<input type="hidden"  name="DealerId" id="DealerIdModified" class="form-control" value="">
				@endif
			  @endif
			  @if ( is_null($UserSessionInfo->DealerId) )
			  <div class="form-group">
			    <label for="isAdministratorModified">Administrator </label>
			    <input type="checkbox" name="isAdministratorModified" id="isAdministratorModified">
			  </div>
			  @endif
			  <input type="hidden" name="DealerIdHidden" id="DealerIdHidden" >
			</div>
	      </div>
	       
	      <div class="modal-footer">
	        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
	        <button type="button" id="updateUser" class="btn btn-primary">Save</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- ends modal for edit User -->


</div>
<script src="js/user.js"></script>
@stop