@extends('master-login')

@section('content')

<div class="container">
  <div class="col-md-4"></div>
    <div class="col-md-4">
      <h3>Change Password <span class="extra-title muted"></span></h3>
      <div class="form-group">
        <label for="password">Please type your new password</label>
        <input type="password" placeholder="New Password" name="password" id="password" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password">Please confirm your password</label>
        <input type="password" placeholder="Confirm Password" name="passwordConfirm" id="passwordConfirm" class="form-control" required>
      </div>
      <div class="form-group">
        <button id="changePassword" class="btn">Change</button> 
      </div>
    </div>
  <div class="col-md-4"></div>
</div>

@stop