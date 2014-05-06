<!DOCTYPE html>
<html>
<head>
    <title>Administration @if ($title) - {{ $title }} @endif</title>
    
    <!-- Frameworks -->
   	{{ HTML::style('css/jquery-ui.css'); }}
   	{{ HTML::style('packages/awesome/css/font-awesome.min.css'); }} 
   	{{ HTML::style('packages/bootstrap/css/bootstrap.min.css'); }}
   	{{ HTML::style('packages/bootstrap/css/summernote.css'); }}
   	{{ HTML::style('packages/toastr/css/toastr.min.css'); }}
    {{ HTML::style('css/uploadify.css'); }}
	
   	<!-- Webkit Styles -->
    {{ HTML::style('packages/webkit/css/layout.css') }}
    {{ HTML::style('packages/webkit/css/layout.style.css') }}
   	{{ HTML::style('packages/webkit/css/navigation.css') }}
    {{ HTML::style('css/pricingPlansStyle.css'); }}
    {{ HTML::style('css/styleApp.css'); }}
    
    <!-- JQuery library -->
   	{{ HTML::script('js/jquery.min.js'); }}
    {{ HTML::script('js/jquery-ui.js'); }}
    
   <!--[if lt IE 9]>
        {{ HTML::script('assets/js/html5shiv.js') }}
        {{ HTML::script('assets/js/respond.min.js') }}
   <![endif]-->
</head>
<body class="x-flexbox-v">
    <header id="header">
    	<div class="x-brand">
    	<a href="#">
    		{{HTML::image('images/logo.png')}}
    	</a>
    	</div>
    	<!-- <div class="pull-right">
    		<a href="close-session"><i class="fa fa-sign-out"></i> Logout</a></p>
    	</div> -->
      <div class="header-right pull-right">
        <ul class="toolbar-icons list-inline">
          <li><a href="{{$baseUrl}}/plans/home" style="color:white;"><i class="fa fa-list-alt fa-6" title="Menu Page"></a></i></li>
          @if($currentUser->DealerId) <li><a href="{{$baseUrl}}/dealers/{{ $currentUser->DealerId }}/plan" style="color:white;" ><i class="fa fa-cogs" title="Settings Page"></a></i></li> @endif
        </ul>
        <p>Logged as <a href="{{$baseUrl}}/profile?UserId={{$currentUser->UserId}}">{{ $currentUser->FirstName }}</a> <a href="{{ URL::action('LoginController@post_closeSession'); }}"><i class="fa fa-sign-out"></i> Logout</a></p>
      </div>
    </header>
    <div id="container" class="x-flexbox x-flex-1">
        @if (!$currentUser->DealerId)
        <nav id="nav" class="x-flexbox-v x-nav">
            <ul class="x-flex-1">
                <li id="dealersitem" class="x-active"><a href="{{ URL::action('DealerController@index'); }} ">Dealers</a></li>
                <li id="companiesitem"><a href="{{ URL::action('CompanyController@index'); }} ">Companies</a></li>
            </ul>
        </nav>
        @endif
        <div id="article" class="x-flexbox-v x-flex-2">
            <div id="toolbar">
            	@yield('toolbar')
            </div>
            <div id="content" class="x-flex-1">
                @yield('content')
            </div>
        </div>
        <!-- <aside id="aside">Aside</aside> -->
    </div>

    <!-- Frameworks -->
    {{ HTML::script('packages/bootstrap/js/bootstrap.min.js'); }}
    {{ HTML::script('packages/bootstrap/js/summernote.min.js'); }}
    {{ HTML::script('packages/toastr/js/toastr.min.js'); }}
    {{ HTML::script('packages/blockUI/blockUI.js'); }}
    {{ HTML::script('js/jquery.uploadify.min.js'); }}
    <!-- Utitilies -->
    {{ HTML::script('js/helper.js'); }}
    <!-- Webkit Scripts -->
    {{ HTML::script('packages/webkit/js/cross-browser.js') }}
    <!-- Custom Scripts -->
    <script>
    eval('var currentUrl = "<?php echo $baseUrl; ?>";');
    </script>
    @yield("scripts")
</body>
</html>