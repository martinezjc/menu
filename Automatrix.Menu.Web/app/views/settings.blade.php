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

<!-- <div id="grid"></div>  apply grid column  -->
<div id="main-container" class="container">

@if ( !$UserSessionInfo->DealerId )
<div class="container">
<div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li><a href="dealer-settings">Dealers</a>
                </li>
                <li><a href="company-settings" style="background: rgba(255,255,255,0.2);">Companies</a>
                </li>
            </ul>
</div>
@endif

@if ( !$UserSessionInfo->DealerId )
  <div class="col-md-2"></div>
@endif

<div @if ( !$UserSessionInfo->DealerId ) class="col-md-7 space" @else class="col-md-9 space" @endif>

<?php 
    if (!empty($UserSessionInfo->DealerId)) {
      $content = '<a class="btn btn-success" href="new-product" id="addProduct"><i class="fa fa-plus"></i> Add Product</a> ';
      $content .= ' <a class="btn btn-success" id="generalSettings" href="general-settings"><i class="fa fa-gears"></i> General Settings</a>';

      echo $content;
    }
    else{
      if ($UserSessionInfo->Administrator == 1) {
        $content = '<a class="btn btn-success" id="generalSettings" href="company-settings"><i class="fa fa-building-o"></i> Companies</a> ';
        $content .= ' <a class="btn btn-success" id="generalSettings" href="dealer-settings"><i class="fa fa-angle-double-right"></i> Dealers</a>';
        echo $content;
      }
    }
 ?>

<div id="productsTable"></div>
</div>
<!--/div -->
{{-- END OF GRID COLUMN 9 --}}

<div id="SortableTable" class="col-md-3 space">    
</div>

</div>
{{-- end container --}}
{{ HTML::script('js/panel.js'); }}
@stop
