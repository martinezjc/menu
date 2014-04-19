@extends('master-login')

@section('content')

<div class="container" id="login-block">
	<div class="row">
	    <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
	       <div class="login-box clearfix animated flipInY">
	       		<div class="page-icon animated bounceInDown">
	       			{{ HTML::image("images/user-icon.png", "Logo Login") }}
	       		</div>
	        	<div class="login-logo">
                            {{ HTML::image("images/logo.png", "Logo", array('width' => '90%')  ) }}                                
	                    <h2>Menu App</h2>

	                    <div id="circleG" style="display:none;">
							<div id="circleG_1" class="circleG">
							</div>
							<div id="circleG_2" class="circleG">
							</div>
							<div id="circleG_3" class="circleG">
							</div>
						</div>	                    
	        	</div> 
	        	

	        	<hr />
	        	
	        	<div class="login-form">
	        		<!-- Start Error box -->
	        		<div id="message" class="alert" style="display:none; text-align:center;"></div> <!-- End Error box -->
				   <input type="text" id="Username" placeholder="Username" class="input-field" value="<?php if (isset($_COOKIE['User'])) { echo Crypt::decrypt($_COOKIE['User']); } ?>" required/> 
				   <input type="password"  placeholder="Password" id="Password" class="input-field" value="<?php if (isset($_COOKIE['Pass'])) { echo Crypt::decrypt($_COOKIE['Pass']);} ?>" required/> 
				    <div class="login-links"> 
			           <a href="#resetPasswordModal" data-dismiss="modal" data-toggle="modal">
			            Forgot password?
			            </a>
			           <!-- <br />
			            <a href="sign-up.html">
			              Don't have an account? <strong>Sign Up</strong>
			            </a>-->
					</div> 
	        	</div> 	
	        	<label style="padding-left:32%;"><input id="remeberme" type="checkbox" name="remember" <?php if (isset($_COOKIE['User'])) { echo 'checked'; } ?> > Remember Me</label>
				<button id="loginPlan" class="btn btn-login">Login</button> 

				   		        	
	       </div>
	        
	    </div>
	</div>

	<div style="color:#333;" class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Password Lookup</h4>
	      </div>
	      <div class="modal-body row-fluid">
	        <div class="span6">
	          <div class="control-group">
	              <label for="Email">Email</label>
	              <div class="controls">
	                <input type="text" name="Email" id="Email" class="form-control" style="width:40%" placeholder="your@email.com" required>
	              </div>
	              <span class="help-block"><small>Enter the email address you used to sign-up.</small></span>
	          </div>
	        </div>
	      </div>
	       
	      <div class="modal-footer pull-center">
	        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
	        <button type="button" id="resetPassword" class="btn btn-success">Reset Password</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
@stop
