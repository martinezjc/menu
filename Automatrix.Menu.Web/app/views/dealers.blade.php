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

@if ( !$UserSessionInfo->DealerId )
<div>
<div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li><a href="dealer-settings" style="background: rgba(255,255,255,0.2);">Dealers</a>
                </li>
                <li><a href="company-settings">Companies</a>
                </li>
            </ul>
</div>
@endif

<div class="row">

    <div class="col-md-9">
  	<a class="btn btn-success" id="userModalLink" href="general-settings"><i class="fa fa-file-o"></i> Add new dealer</a>
  	<!-- <a class="btn btn-success" id="generalSettings" href="settings-page"><i class="fa fa-times"></i> Cancel</a> -->
    
    </div>
    <div class="col-md-3">
    </div>
  </div>

  <div class="row">   
    <div class="col-md-9">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Dealer Name</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($Dealers as $Deal => $DealerInfo)
          <tr>
            <td>{{{ ++ $Deal }}}</td>
            <td>{{{ $DealerInfo->DealerName }}}</td>
            <td style="width:10%"><a class="btn btn-warning" href="general-settings?DealerId={{ $DealerInfo->DealerId }}"><i class="fa fa-pencil-square-o"></i> Modify</a></td>
            <td style="width:10%"><a href="#" class="btn btn-danger deleteDealer"  name="{{ $DealerInfo->DealerId }}"><i class="fa fa-trash-o"></i> Delete</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="col-md-3">
    </div>
  </div>

<script src="js/dealer.js" type="text/javascript"></script>

@stop
