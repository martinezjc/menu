<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reset Password</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 {{ HTML::style('packages/awesome/css/font-awesome.min.css'); }}
	 {{ HTML::style('packages/bootstrap/css/bootstrap.min.css'); }}
</head>
<body>

<div class="container">
<div class="col-md-4"></div>
<div class="col-md-4">
  <h3>Change Password <span class="extra-title muted"></span></h3>
  <div class="form-group">
    <label for="password">Please type your new password</label>
    <input type="text" name="password" id="password" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="password">Please confirm your password</label>
    <input type="text" name="passwordConfirm" id="passwordConfirm" class="form-control" required>
  </div>
  <div class="form-group">
    <input type="button" class="">
  </div>
</div>
<div class="col-md-4"></div>
</div>

{{ HTML::script('packages/bootstrap/js/bootstrap.min.js'); }}
{{ HTML::script('packages/toastr/js/toastr.min.js'); }}
</body>
</html>