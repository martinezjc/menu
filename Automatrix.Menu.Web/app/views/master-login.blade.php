<!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang="en" > 
<!--<![endif]-->
<head>    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <title>Login</title>
    <!-- Bootstrap core CSS -->
    {{ HTML::style('packages/awesome/css/font-awesome.min.css'); }} 
    {{ HTML::style('packages/bootstrap/css/bootstrap.min.css'); }}
    {{ HTML::style('packages/toastr/css/toastr.min.css'); }}
    <!-- Demo CSS -->
    <link href="css/demo.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet" id="fordemo">
    <link href="css/animate-custom.css" rel="stylesheet">
     
     <link href="css/preload.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
<body class="fade-in">

          @yield('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.9.1.min.js"><\/script>')</script> 
{{ HTML::script('packages/bootstrap/js/bootstrap.min.js'); }}
{{ HTML::script('packages/toastr/js/toastr.min.js'); }}
<script src="js/placeholder-shim.min.js"></script>        
<script src="js/custom.js"></script>
{{ HTML::script('packages/blockUI/blockUI.js'); }}    
{{ HTML::script('js/user.js'); }}
</body>
</html>
