@extends('layouts.admin')

@section('scripts')
{{ HTML::script('scripts/user.js'); }}
@stop

@section('toolbar')
<div class="row">
	<div class="col-md-9">
		<a class="btn btn-success" id="userModalLink" data-dismiss="modal" data-toggle="modal" href="#userModal">
			<i class="fa fa-file-o"></i> Add new user
		</a> 
		<a class="btn btn-success" id="generalSettings" href="edit"><i class="fa fa-times"></i> Cancel</a>
	</div>
	<div class="col-md-3"></div>
</div>
@stop @section('content')
<div class="row">
	<div class="col-md-9">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>Username</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
				<tr>
					<td></td>
					<td>{{{ $user->FirstName }}}</td>
					<td>{{{ $user->Username }}}</td>
					<td style="width: 10%"><a href="#" class="btn btn-warning"
						onclick="showUser({{ $user->UserId }})"><i class="fa fa-pencil-square-o"></i>
							Modify</a></td> @if(!(empty($currentUser->DealerId)))
					<td style="width: 10%"><a href="#" class="btn btn-danger"
						id="deleteUser"
						onClick="deleteUser({{ $user->UserId }}); return false;"><i
							class="fa fa-trash-o"></i> Delete</a></td> @else
					@if(!(empty($DealerIdHidden)))
					<td style="width: 10%"><a href="#" class="btn btn-danger"
						id="deleteUser"
						onClick="deleteUser({{ $user->UserId }});"><i
							class="fa fa-trash-o"></i> Delete</a></td> @endif @endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="col-md-1"></div>
</div>
<!-- Modal for new User -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class="fa fa-user"></i> Add New User
				</h4>
			</div>
			<div class="modal-body row">
				<div class="col-md-9">
					<div class="form-group">
					    <input type="hidden" id="UserId" >
						<label for="FirstName">First Name</label> <input type="text"
							name="FirstName" id="FirstName" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="LastName">Last Name</label> <input type="text"
							name="LastName" id="LastName" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="Email">Email</label> <input type="text" name="Email"
							id="Email" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="Username">Username</label> <input type="text"
							name="Username" id="Username" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="Password">Password</label> <input type="password"
							name="Password" id="Password" class="form-control" required>
						    <input type="hidden" id="PasswordRemember">
					</div>
					@if (!(empty($currentUser->DealerId))) <input type="hidden"
						name="DealerId" id="DealerId" class="form-control"
						value="{{$currentUser->DealerId}}"> @else
					@if(!(empty($DealerIdHidden))) <input type="hidden" name="DealerId"
						id="DealerId" class="form-control" value="{{$DealerIdHidden}}">
					@else <input type="hidden" name="DealerId" id="DealerId"
						class="form-control" value=""> @endif @endif @if (
					is_null($currentUser->DealerId) )
					<div class="form-group">
						<label for="Administrator">Administrator </label> <input
							type="checkbox" name="isAdministrator" id="isAdministrator">
					</div>
					@endif
				</div>
			</div>
			<div class="modal-footer">
			    <label style="float:left;line-height: 2em;">All fields are required. </label>
				<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
				<button type="button" id="saveUserData" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>
<!-- ends modal for new User -->

@stop