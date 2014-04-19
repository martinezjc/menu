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

<div class="container">
<div class="row">
	<div class="col-md-9">
	  <a class="btn btn-success" id="saveProduct"><i class="fa fa-file-o"></i> Save</a>
	  <a class="btn btn-success" id="generalSettings" href="settings-page"><i class="fa fa-times"></i> Cancel</a>
	  <div style="margin-bottom:2%"></div>
	</div> <!-- ends container class -->
	<div class="col-md-3">
	</div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="CompanyId">Company Name</label>
      <select name="CompanyId" id="CompanyId" class="form-control" style="width:40%">
        @foreach ($Companies as $Company)
        <option value="{{{ $Company->id }}}">{{{ $Company->CompanyName }}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="ProductName">Product Name</label>
      <!-- <div id="ProductsList"></div> -->
      <select name="ProductName" id="ProductName" class="form-control" style="width:40%">
          @foreach ($Products as $Product)
          <option value="{{ $Product->ProductBaseId }}">{{ $Product->ProductName }}</option>
          @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="displayName">Display Name</label>
      <input id="displayName" type="text"class="form-control" class="form-control" >
    </div>
    <div class="form-group">
      <label for="ProductDescription">Product Description</label>
      <input id="ProductDescription" type="text"class="form-control" class="form-control" >
    </div> 
    <div class="form-group">
      <label for="bulletsPoints">Bullets Points</label>
      <div class="form-group">
        <input id="bulletPoint1" type="text"class="form-control" class="form-control">
      </div>
      <div class="form-group">
        <input id="bulletPoint2" type="text"class="form-control" class="form-control">
      </div>
      <div class="form-group">
        <input id="bulletPoint3" type="text"class="form-control" class="form-control">
      </div>
      <div class="form-group">
        <input id="bulletPoint4" type="text"class="form-control" class="form-control">
      </div>
      <input id="bulletPoint5" type="text"class="form-control" class="form-control">
    </div>
  </div>
  <div  class="col-md-6">
    <!-- Starts tabs -->
    <ul class="nav nav-tabs" id="optionsCostPrice">
      <li id="manual" class="active"><a href="#manualtab" data-toggle="tab" id="manuallink">Manual</a></li>
      <li id="webservice"><a id="webservicelink" href="#webservicetab" data-toggle="tab">Web Service</a></li>
    </ul>
    <div class="tab-content" style="padding-top:10px; padding-left:10px;">
      <div class="tab-pane active" id="manualtab"><!-- starts manual tab -->
        <div ng-app="app">
         <div ng-controller="Ctrl">
          <div id="CostAddProduct" class="form-group ">
            <label for="cost">Cost</label>
            <input id="cost" ng-model='val' decimal-places type="text" class="form-control" class="form-control" style="text-align:right; width: 40%;">
          </div>
        </div>
        <div ng-controller="Ctrl">
          <div id="PriceAddProduct" class="form-group ">
            <label for="sellingPrice">Selling Price</label>
            <input id="sellingPrice" ng-model='val' decimals-places type="text"class="form-control" class="form-control" style="text-align:right; width: 40%;">
          </div>
        </div>
      </div>
      
      <fieldset id="range">
        <legend></legend>
        <div class="form-group">
          <label for="useManualPricing"><input type="checkbox" name="useManualPricing" id="useManualPricing"> Range Pricing</label>
        </div>
        <div class="form-group">
          <label for="TypeRange">Type</label>
          <select name="TypeRange" id="TypeRange" class="form-control" style="width:40%;">
            <option value="Gap Purchase">Gap Purchase</option>
            <option value="Gap Lease">Gap Lease</option>
            <option value="Gap Ballon">Gap Ballon</option>
          </select>
        </div>

        <div class="form-group">
          <a href="#RangePricingModal" data-dismiss="modal" data-toggle="modal" class="btn btn-default btn-sm" id="btnSetPrices">Set prices</a> 
        </div>
      </fieldset>

      
    </div><!-- end manual tab -->

    <!-- starts modal for manual range pricing -->
    <div class="modal fade" id="RangePricingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Manual range pricing</h4>
          </div>
          <div class="modal-body row">
            <div class="col-md-12">
              <table class="table table-striped">
                <thead>
                  <tr class="headerRange">
                    <th>Term<br/><br/>From</th>
                    <th>To</th>
                    <th>Gap Purchase<br/><br/>Cost</th>
                    <th>Gap Lease<br/><br/>Cost</th>
                    <th>Gap Ballon<br/><br/>Cost</th>
                    <th>Selling Price</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Ranges'][0]->TermFrom}}" @endif name="TermFrom" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Ranges'][0]->TermTo}}" @endif name="TermTo" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Gap Purchase'][0]->PricingCost}}" @endif name="CostPurchase" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Gap Lease'][0]->PricingCost}}" @endif name="CostLease" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Gap Balloon'][0]->PricingCost}}" @endif name="CostBalloon" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['SellingPrice'][0]}}" @endif name="SellingPrice" class="form-control" style="text-align:right;"></td>
                    </tr>
                    <tr>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Ranges'][1]->TermFrom}}" @endif name="TermFrom" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Ranges'][1]->TermTo}}" @endif name="TermTo" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Gap Purchase'][1]->PricingCost}}" @endif name="CostPurchase" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Gap Lease'][1]->PricingCost}}" @endif name="CostLease" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Gap Balloon'][1]->PricingCost}}" @endif name="CostBalloon" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['SellingPrice'][1]}}" @endif name="SellingPrice" class="form-control" style="text-align:right;"></td>
                    </tr>
                    <tr>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Ranges'][2]->TermFrom}}" @endif name="TermFrom" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Ranges'][2]->TermTo}}" @endif name="TermTo" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Gap Purchase'][2]->PricingCost}}" @endif name="CostPurchase" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Gap Lease'][2]->PricingCost}}" @endif name="CostLease" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['Gap Balloon'][2]->PricingCost}}" @endif name="CostBalloon" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $Products)) value="{{$Products->prices['SellingPrice'][2]}}" @endif name="SellingPrice" class="form-control" style="text-align:right;"></td>
                    </tr>
                </tbody>
              </table>

            </div>
          </div>

          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            <button type="button" id="saveRangePricing" class="btn btn-primary">Save</button>
            <!-- <button type="button" id="saveRangePricing" class="btn btn-primary">Save</button> -->
          </div>
        </div>
      </div>
    </div>  
    <!-- end modal for manual range pricing -->

    <div class="tab-pane" id="webservicetab"><!-- start web service tab -->

     <div id="TypeAddProduct" class="form-group WSUage2">
      <label for="Type">Type</label>
      <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseType" name="UseType"> Use option</span>
      <select name="Type" id="Type" class="form-control" style="width:40%">
       <option value="Platinum">Platinum</option>
       <option value="Gold">Gold</option>
       <option value="Silver">Silver</option>
       <option value="Powertrain">Powertrain</option>
     </select>
   </div>

   <div id="TermAddProduct" class="form-group WSUage2">
    <label for="Term">Term</label>
    <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseTerm" name="UseTerm" > Use option</span>
    <select name="Term" id="Term" class="form-control" style="width:40%">
      <option value="36">36</option>
      <option value="48">48</option>  
      <option value="60">60</option>
      <option value="72">72</option>
    </select>  
  </div>

  <div id="DeductibleAddProduct" class="form-group WSUage2">
    <label for="Deductible">Deductible</label>
    <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseDeductible" name="UseDeductible" > Use option</span>
    <select id="Deductible" name="Deductible" class="form-control"  style="width:40%" >
     <option value="50">$50</option>                                
     <option value="100">$100</option>
     <option value="200">$200</option>
     <option value="300">$300</option>
   </select>

   
 </div>

 <div id="VehiclePlanAddProduct" class="form-group WSUage2">
  <label for="Deductible">Vehicle Plan</label>
  <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseVehiclePlan" name="UseVehiclePlan" > Use option</span>
  <select id="VehiclePlan" name="VehiclePlan" class="form-control"  style="width:40%" >
   <option value="None">Select one</option>
   <option value="New">New</option>                                
   <option value="PreOwned">Pre Owned</option>
   <option value="ExtendedEligibilityProgram">Extended Eligibility Program</option>
   <option value="VehiclesWith6monthManufacturersWarranty">Vehicles With 6 month Manufacturers Warranty</option>
   <option value="WrapNew">Wrap New</option>
   <option value="WrapOemCpo">Wrap Oem Cpo</option>
   <option value="WrapPreOwned">Wrap Pre Owned</option>
 </select>
</div>

<div id="MileageAddProduct" class="form-group WSUage2" hidden>
 <label for="Mileage">Mileage</label>
 <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseMileage" name="UseMileage"> Use option</span>
 <select id="Mileage" name="Mileage" class="form-control"  style="width:40%" >
  <option value="36">36</option>
  <option value="45">45</option>
  <option value="48">48</option>
  <option value="50">50</option>
  <option value="60">60</option>
  <option value="70">70</option>
  <option value="75">75</option>
  <option value="100">100</option>
  <option value="120">120</option>
  <option value="125">125</option>
  <option value="150">150</option>
</select>
</div>

<div id="TireRotationAddProduct" class="form-group WSUage2" hidden>
   <label for="UseTireRotation">Tire Rotation</label>
   <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseTireRotation" name="UseTireRotation"> Use option</span>
   <select id="TireRotation" name="TireRotation" class="form-control"  style="width:40%" >
    <option value="5000">5000</option>
    <option value="6000">6000</option>
    <option value="7500">7500</option>
  </select>
</div>

<div id="IntervalAddProduct" class="form-group WSUage2" hidden>
 <label for="UseInterval">Interval</label>
 <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseInterval" name="UseInterval" > Use option</span>
 <select id="Interval" name="Interval" class="form-control"  style="width:40%" >
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select>
</div>

</div><!-- end web service tab -->
</div>
<!-- End tabs -->
<div class="form-group">
  <label for="useWS"><input type="checkbox" id="useWS" name="useWS"> Use web service to obtain the cost and price</label>
</div>

<div id="IsTaxableAddProduct" class="form-group WSUage2">
  <label for="IsTaxable"><input type="checkbox" name="IsTaxable" id="IsTaxable"> Is Taxable</label>
</div>

    <fieldset>
      <legend></legend>
      <div class="form-group">
        <label for="BrochureImage">Brochure</label>
        <div id="brochureOption">
          <input type="button" id="BrochureImage"  class="pull-right">
          <input id="BrochureImageRefer" name="BrochureImageRefer" type="text" placeholder="File" class="form-control pull-left" style="width:80%">
        </div>
        <div id="videoOption" style="display:none;">
          <input type="text" name="urlVideo" id="urlVideo" placeholder="URL" class="form-control">
        </div>
        <div>
          <a href="#" id="showOptions" class="pull-left">Picture/Video Size</a>
          <div id="radios" class="pull-right">
            <label class="radio-inline">
              <input type="radio" name="mediaType" value="Image" checked> Picture | 
            </label> 
            <label class="radio-inline">
              <input type="radio" name="mediaType" value="VideoURL">Video
            </label>
          </div>
        </div>
        <div class="form-group">&nbsp;</div>
        <div id="sizeOptions" style="display:none;">
          <div class="form-group" id="optionsBlock">
            <label for="BrochureHeight">Height: <input type="text" name="BrochureHeight" id="BrochureHeight" class="form-control"></label>
            <label for="BrochureWidth">Width: <input type="text" name="BrochureWidth" id="BrochureWidth" class="form-control"></label>
          </div>
        </div>
        <div class="form-group">&nbsp;</div>
        <div class="form-group">
          <label for="PDFContrator">Add PDF contract for this product</label>
          <input id="PDFContrator" name="PDFContrator" type="file" class="form-control">
          <input type="hidden" id="PDFSelected" />
        </div>
      </fieldset>
    </div>
  </div>
</div> <!-- end row class -->

<script src="js/product.js"></script>
<script src="js/angular.min.js"></script>
<script src="js/angular.js" type="text/javascript"></script>
<script src="js/jquery.uploadify.min.js" type="text/javascript"></script>

<script type="text/javascript">
	<?php $timestamp = time();?>

	var ProductIdvar;
  var gapCost160 = new Object();
  var gapCost6072 = new Object();
  var gapCost7284 = new Object();
  var sellingPriceValues = new Object();
  var dataPrices = new Object();

	function saveDocument(ProductIdSaved,callback){
	  ProductIdvar = ProductIdSaved;
	  
	  try {
      $('#PDFContrator').uploadify('upload','*');
	    $('#BrochureImage').uploadify('upload','*');
	  
	    callback(true);
	  }catch(err){
	     $('#myModal').modal('hide');
	  }
	};

  $(document).ready(function() {
    $('#range').hide();
    $('#webservicelink').removeAttr('data-toggle');
    $('.modal .modal-dialog').css('width', '900px');
    $('#displayName').val($('#ProductName option:selected').text());

    $( "#TypeRange" ).prop( "disabled", true );
    $( "#btnSetPrices" ).prop( "disabled", true );
    $("#VehiclePlanAddProduct").hide();
    $('#showOptions').css('padding-top','9px');
    $('#radios').css('padding-top','9px');
    $('#optionsBlock').css('padding-top','34px');
    $( "#Type" ).prop( "disabled", true );
    $( "#Term" ).prop( "disabled", true );
    $( "#Deductible" ).prop( "disabled", true );
    $( "#VehiclePlan" ).prop( "disabled", true );
    $( "#Mileage" ).prop( "disabled", true );
    $( "#TireRotation" ).prop('disabled', true);

    $('#BrochureImage').uploadify({
        'formData'     : {
          'timestamp' : '<?php echo $timestamp;?>',
          'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
        },
        'swf'      : 'js/uploadify.swf',
        'uploader' : 'js/uploadify.php',
        'width'    : 17,
        'height': 19,
        'queueID'        : 'fileBrochureQueue',
        'hideButton': true,
        'wmode'     : 'transparent',
        'buttonImage' : 'images/fileicon.png',
        'fileTypeExts' : '*.gif; *.jpg; *.png',
        'fileTypeDesc' : 'Image Files',
         buttonText : "",
        'auto'     : false,
        'onSelect' : function(file) {
            $("#BrochureImageRefer").val( file.name );
        },
        'onUploadStart' : function(file) {
          var ProductId = ProductIdvar;
          var formData = { 'ProductId': ProductId, 'Option' : 'UpdateBrochure', 'type' : 'image' }
          $('#BrochureImage').uploadify("settings", "formData", formData);
        },
        'onUploadSuccess' : function(file, data, response) {
        }
      });

      $('#PDFContrator').uploadify({
        'formData'     : {
          'timestamp' : '<?php echo $timestamp;?>',
          'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
        },
        'swf'      : 'js/uploadify.swf',
        'uploader' : 'js/uploadify.php',
        'fileTypeExts' : '*.pdf',
        'fileTypeDesc' : 'PDF Files',
        buttonText : "Select PDF",
        'onError'        : function(event,queueID,fileObj,errorObj){
          console.log(errorObj["type"]+" - "+errorObj["status"]+" - "+errorObj["text"]);
        },
        'auto'     : false,
        'onUploadStart' : function(file) {
          var ProductId = ProductIdvar;
          var pdfData = { 'ProductId': ProductId, 'Option' : 'UpdatePDF', 'type' : 'pdf' }
          $('#PDFContrator').uploadify("settings", "formData", pdfData);
        },
        'onSelect' : function(file) {
          $('#PDFSelected').val('yes');
        },
        'onUploadSuccess' : function(file, data, response) {
          $.unblockUI();
          toastr.success("The product has been added", "Success");
          window.location.href = 'settings-page';
        }
      });
    });

$('a[data-toggle="tab"]').on('shown', function (e) {
  activeTab = e.target;
});

$('#restoreDefaults').click( function() {
  $('#RangePricingModal input:text:not(".ignore")').val('');
  $('#TermFrom1').val(1);
  $('#TermTo60').val(60);
  $('#TermFrom60').val(60);
  $('#TermTo72').val(72);
  $('#TermFrom72').val(72);
  $('#TermTo84').val(84);
});

$('#saveRangePricing').click( function() {
  var notnumber = false;
  var empty = false;

  $('#RangePricingModal').find('input[type=text]').each(function() {
    var value = $(this).val();
    
    if ( isNaN(value)) {
      notnumber = true;
    }
    
    if (!value) {
      empty = true;
    }
  });

  if (notnumber == true) {
    toastr.error("The fields must be filled with numbers not letters", "Error");
    return false;
  }

  if ( empty == true) {
    toastr.error("Please complete all the fields", "Error");
    return false;
  }

  /*
    // Term 60
  gapCost160 = {
      'Gap Purchase' : GetFloat($('#PricingCostPurchase').val()),
      'Gap Lease' :  GetFloat($('#PricingCostLease').val()),
      'Gap Ballon' : GetFloat($('#PricingCostBallon').val())
  };

  gapCost6072 = {
      'Gap Purchase' : GetFloat($('#PricingCostPurchase2').val()),
      'Gap Lease' :  GetFloat($('#PricingCostLease2').val()),
      'Gap Ballon' : GetFloat($('#PricingCostBallon2').val())
  }

  gapCost7284 = {
      'Gap Purchase' : GetFloat($('#PricingCostPurchase3').val()),
      'Gap Lease' :  GetFloat($('#PricingCostLease3').val()),
      'Gap Ballon' : GetFloat($('#PricingCostBallon3').val())
  }
    
  sellingPriceValues = {
      '1-60' : GetFloat($('#SellingPrice').val()),
      '60-72' : GetFloat($('#SellingPrice2').val()),
      '72-84' : GetFloat($('#SellingPrice3').val())
  }

  dataPrices = {
      'Term60' : {
       'TermFrom' : $('#TermFrom1').val(),
       'TermTo' : $('#TermTo60').val(),
       'Cost' : gapCost160,
       'SellingPrice' : sellingPriceValues['1-60']
     },
     'Term72' : {
       'TermFrom' : $('#TermFrom60').val(),
       'TermTo' : $('#TermTo72').val(),
       'Cost' : gapCost6072,
       'SellingPrice' : sellingPriceValues['60-72']
     },
     'Term84' : {
       'TermFrom' : $('#TermFrom72').val(),
       'TermTo' : $('#TermTo84').val(),
       'Cost' : gapCost7284,
       'SellingPrice' : sellingPriceValues['72-84']
     }
  }

  $('#RangePricingModal').modal('hide'); */
});

</script>
@stop
