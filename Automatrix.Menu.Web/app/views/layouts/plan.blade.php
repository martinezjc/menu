<?php

$UserSessionInfo = Session::get('UserSessionInfo');

if (is_null($UserSessionInfo->DealerId)) {
?>
<script>
    window.location.href = 'dealer-settings';
</script>
<?php  
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title', 'Finance Menu')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ HTML::style('packages/awesome/css/font-awesome.min.css'); }}
    {{-- Bootstrap --}}
    {{ HTML::style('packages/bootstrap/css/bootstrap.min.css', array('media' => 'screen')) }}
    {{ HTML::style('css/styleApp.css', array('media' => 'screen')) }}
    {{ HTML::style('css/toggle-switch.css', array('media' => 'screen')) }}
    {{ HTML::style('packages/toastr/css/toastr.min.css'); }}
    
    {{ HTML::style('css/pricingPlansStyle.css', array('media' => 'screen')) }}
    {{-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    <!--[if lt IE 9]>
        {{ HTML::script('assets/js/html5shiv.js') }}
        {{ HTML::script('assets/js/respond.min.js') }}
    <![endif]-->
    <!-- script src="js/xml2jsobj.js"></script -->
    {{ HTML::script('js/xml2jsobj.js');}}    
    <style type="text/css">
        .navbar-brand  {
            margin: 5px 0px 0px 10px;
            background: url(uploads/dealer/{{ $UserSessionInfo->DealerLogo }}) 0 0 no-repeat;        
            background-size: 300px 50px;
            background-position:center; 
            display: block;
            height: 50px;
            width: 300px;
        }

        .navbar-brand-noImage {
            margin: 5px 0px 0px 10px;
            vertical-align: middle;
            display: block;
            border: dashed 1px;
            font-size: 35px;
            text-align: center;
            color: rgba(190, 189, 189, 0.28);
            height: 50px;
            width: 300px;
        }

        .navbar-brand-noImage:hover {
            color: rgba(190, 189, 189, 0.28);
            text-decoration: none;
        }
    </style>
    {{ HTML::script('js/helper.js') }}
</head>
<body>

	<nav class="navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      @if ($UserSessionInfo->DealerLogo != null)
      <a class="navbar-brand" alt="{{ $UserSessionInfo->DealerName }}" href="home"></a>
      @else
      <a class="navbar-brand-noImage" alt="{{ $UserSessionInfo->DealerName }}" href="home"> Your logo here!</a>
      @endif
    </div>
	<form  id="deal-form" class="form-inline"   role="form" action="" method:"GET" style="">

			    <div class="input-group " style="width:68%; float: left;">
			            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
			            <input type="text" name="Deal" class="form-control" id="Deal" pattern="[0-9]+" placeholder="Enter deal number" value="<?php if(isset($_GET["Deal"])){ echo $_GET["Deal"];} ?>">
			    </div>
				<button id="FindDeal" type="submit" class="btn btn-primary"  style="margin-left:5px;"><i class="fa fa-search"></i> Find deal</button>
	</form>
    <div class="header-right pull-right">
        <ul class="toolbar-icons list-inline">
            <li><a href="home" style="color:white;"><i class="fa fa-list-alt fa-6" title="Menu Page"></a></i></li>
            @if($UserSessionInfo->Administrator == 1)
                <li><a href="settings-page" style="color:white;" ><i class="fa fa-cogs" title="Settings Page"></a></i></li>
            @endif
            @if($ShowPrintButton == true)
            <li>        
            <form method="get" action="export" target="_blank">
                <input type="hidden" name="newapr" value="{{$apr}}"/>
                <input type="hidden" name="newterm" value="{{$term}}"/>
                <input type="hidden" name="newdownpayment" value="{{$downPayment}}"/>
                <input type="hidden" id="acceptedarray" name="acceptedarray" value=''></input>
                <input type="hidden" id="rejectedarray" name="rejectedarray" value=''></input>
                <input type="hidden" id="UpdatedPayment" name="UpdatedPayment" value=''></input>
                <input type="hidden" id="CostPerDay" name="CostPerDay" value=''></input>
                <input type="hidden" id="AdditionalPayment" name="AdditionalPayment" value=''></input>
                <input type="hidden" id="costbydayarray" name="costbydayarray" value=''></input>
                <input type="hidden" id="accepteddescription" name="accepteddescription" value=''></input>
                <input type="hidden" id="rejecteddescription" name="rejecteddescription" value=''></input>
                <button id="exportpdf" name="exportpdf" type="submit"><i class="fa fa-print" title="export pdf"></a></i></button>
            </form></li>
            @endif
            @if($ShowMenuPrintButton == true)
            <?php $WebServiceDeal = Input::get('Deal');?>
              
            <li>        
            <form method="get" action="printmenu" target="_blank">
                <input type="hidden" id="premiumarray" name="premiumarray" value=''></input>
                <input type="hidden" id="preferredarray" name="preferredarray" value=''></input>
                <input type="hidden" id="economyarray" name="economyarray" value=''></input>
                <input type="hidden" id="basicarray" name="basicarray" value=''></input>
                <input type="hidden" id="premiumacceptedarray" name="premiumacceptedarray" value=''></input>
                <input type="hidden" id="preferredacceptedarray" name="preferredacceptedarray" value=''></input>
                <input type="hidden" id="economyacceptedarray" name="economyacceptedarray" value=''></input>
                <input type="hidden" id="basicacceptedarray" name="basicacceptedarray" value=''></input>
                <!-- <input type="hidden" id="costbyproductarray" name="costbyproductarray" value=''></input> -->
                <input type="hidden" id="costpremiumarray" name="costpremiumarray" value=''></input>
                <input type="hidden" id="costpreferredarray" name="costpreferredarray" value=''></input>
                <input type="hidden" id="costeconomyarray" name="costeconomyarray" value=''></input>
                <input type="hidden" id="costbasicarray" name="costbasicarray" value=''></input>
                <input type="hidden" id="costfooterarray" name="costfooterarray" value=''></input>
                <input type="hidden" id="facefooter" name="facefooter" value=''></input>
                <input type="hidden" id="premiumdescription" name="premiumdescription" value=''></input>
                <input type="hidden" id="preferreddescription" name="preferreddescription" value=''></input>
                <input type="hidden" id="economydescription" name="economydescription" value=''></input>
                <input type="hidden" id="basicdescription" name="basicdescription" value=''></input>
                <input type="hidden" id="visibleproducts" name="visibleproducts" value=''></input>
                @if(!empty($WebServiceDeal))  
                     <button class ="printpdf" id="printmenupdf" name="printmenupdf" type="submit"><i class="fa fa-print" title="Print menu in pdf"></a></i></button>
                @endif
               
            </form></li>
            @endif
	     <li><a href="" style="color:white;" ><i class="fa fa-pencil-square-o" title="Notepad"></a></i></li>
        </ul>
        <p>Logged as <a @if (Session::has('UserId')) href="profile?UserId={{$UserSessionInfo->UserId}}" @endif>{{ $UserSessionInfo->FirstName }}</a> <a href="close-session"><i class="fa fa-sign-out"></i> Logout</a></p>
    </div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

    <div id="main-container" class="container-fluid">
          @yield('content')
     </div>
	
	{{-- jQuery (necessary for Bootstrap's JavaScript plugins) --}}
    <!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    {{-- Include all compiled plugins (below), or include individual files as needed --}}
    {{ HTML::script('packages/bootstrap/js/bootstrap.min.js') }}
    {{ HTML::script('packages/toastr/js/toastr.min.js'); }}
    {{ HTML::script('packages/blockUI/blockUI.js'); }}
    {{ HTML::script('js/global.js'); }}    
    
    @yield('scripts')

    <div id='toTop'><i class="fa fa-chevron-circle-up">&nbsp;</i></div>
    <div id='toBottom'><i class="fa fa-chevron-circle-down">&nbsp;</i></div>
    <div id='unZoom'>
        <i class="fa fa-search-minus"></i>        
    </div>
    <footer class="footerApp">
        <div class="col-md-3 space">
            <span class="poweredBy"> Powered by </span>
            <span><a href="http://www.automatrixdms.com" class="automatrixLogo"></a></span>
        </div>
    </footer>
</body>
</html>
