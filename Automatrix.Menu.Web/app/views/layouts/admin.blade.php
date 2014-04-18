<!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
    
    <!-- Frameworks -->
   	{{ HTML::style('//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css'); }}
   	{{ HTML::style('packages/awesome/css/font-awesome.min.css'); }} 
   	{{ HTML::style('packages/bootstrap/css/bootstrap.min.css'); }}
   	{{ HTML::style('packages/bootstrap/css/summernote.css'); }}
   	{{ HTML::style('packages/toastr/css/toastr.min.css'); }}
	
   	<!-- Webkit Styles -->
    {{ HTML::style('packages/webkit/css/layout.css') }}
    {{ HTML::style('packages/webkit/css/layout.style.css') }}
   	{{ HTML::style('packages/webkit/css/navigation.css') }}

   	<!-- Frameworks -->
   	{{ HTML::script('http://code.jquery.com/jquery-1.9.1.js'); }}
    {{ HTML::script('http://code.jquery.com/ui/1.10.4/jquery-ui.js'); }}
    {{ HTML::script('packages/bootstrap/js/bootstrap.min.js'); }}
    {{ HTML::script('packages/bootstrap/js/summernote.min.js'); }}
   	{{ HTML::script('packages/toastr/js/toastr.min.js'); }}
    {{ HTML::script('packages/blockUI/blockUI.js'); }}
   	{{ HTML::script('js/jquery.uploadify.min.js'); }}
    
    <!-- Utitilies -->
    {{ HTML::script('js/helper.js'); }}
       
    <!-- Custom Scripts -->
    @yield("scripts")
    
    <!-- 
    
   	{{ HTML::script('js/settings.js'); }}
   	{{ HTML::script('js/app.js'); }}
   	{{ HTML::script('js/user.js'); }}
   	
   	{{ HTML::script('js/company.js'); }}
   	 -->
        
    <!-- Webkit Scripts -->
    {{ HTML::script('packages/webkit/js/cross-browser.js') }}
    
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
    	<div class="pull-right">
    		<a href="close-session"><i class="fa fa-sign-out"></i> Logout</a></p>
    	</div>
    </header>
    <div id="container" class="x-flexbox x-flex-1">
        <nav id="nav" class="x-flexbox-v x-nav">
            <ul class="x-flex-1">
                <li class="x-active"><a href="{{ URL::action('DealerController@index'); }} ">Dealers</a></li>
                <li><a href="{{ URL::action('CompanyController@index'); }} ">Companies</a></li>
            </ul>
        </nav>
        <div id="article" class="x-flexbox-v x-flex-2">
            <div id="toolbar">
            	@yield('toolbar')
            </div>
            <div id="content" class="x-flex-1">
                @yield('content')
            </div>
        </div>
        <aside id="aside">Aside</aside>
    </div>
</body>
</html>