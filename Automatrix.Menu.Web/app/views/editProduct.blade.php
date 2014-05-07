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
	  <a class="btn btn-success" id="updateInfo"><i class="fa fa-floppy-o"></i> Update</a>
	  <a class="btn btn-success" id="generalSettings" href="settings-page"><i class="fa fa-times"></i> Cancel</a>
	  <div style="margin-bottom:2%"></div>
	</div> <!-- ends container class -->
	<div class="col-md-3">
	</div>
</div>

<div class="row">
	<div class="col-md-6">
    <div class="form-group">
      <label for="CompanyIdModified">Company Name</label>
      <div>
        <select name="CompanyIdModified" id="CompanyIdModified" class="form-control" style="width:40%">
          @foreach ($Companies as $Company)
          <option value="{{{ $Company->id }}}" @if ($Company->id == $CompanySelected) selected @endif >{{{ $Company->CompanyName }}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <input type="hidden" name="idModified" id="idModified" value="{{$ProductData->id}}">
    <div class="form-group">
      <label for="productNameModified">Product Name</label>
      <!-- <div id="ProductsListModified"></div> -->
      <select name="productNameModified" id="productNameModified" class="form-control" style="width:40%">

          @foreach ($Products as $Product)
          <option value="{{{ $Product->ProductBaseId }}}" @if ( $Product->ProductBaseId == $ProductSelected ) selected="selected" @endif>{{{ $Product->ProductName }}}</option>
          @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="displayNameModified">Display Name</label>
      <input id="displayNameModified" name="displayNameModified" type="text" class="form-control" value="{{ $ProductData->DisplayName }}" required>
    </div>
    <div class="form-group">
      <label for="ProductDescriptionModified">Product Description</label>
      <input id="ProductDescriptionModified" type="text" class="form-control" value="{{ $ProductData->ProductDescription }}" required>
    </div>
    <?php
    $arrayBullets = array();
    if ($ProductData->Bullets) {
        $arrayBullets = explode(',', $ProductData->Bullets);
    }
    ?>
    <div class="form-group">
      <label for="bulletsPoints">Bullets Points</label>
      <div class="form-group">
        <input id="bulletPoint1Modified" type="text" class="form-control" @if ( array_key_exists( '0' ,$arrayBullets) ) value="{{ $arrayBullets[0] }}" @endif required>
      </div>
      <div class="form-group">
        <input id="bulletPoint2Modified" type="text" class="form-control" @if ( array_key_exists( '1' ,$arrayBullets) ) value="{{ $arrayBullets[1] }}" @endif required>
      </div>
      <div class="form-group">
        <input id="bulletPoint3Modified" type="text" class="form-control" @if ( array_key_exists( '2' ,$arrayBullets) ) value="{{ $arrayBullets[2] }}" @endif required>
      </div>
      <div class="form-group">
        <input id="bulletPoint4Modified" type="text" class="form-control" @if ( array_key_exists( '3' ,$arrayBullets) ) value="{{ $arrayBullets[3] }}" @endif required>
      </div>
      <input id="bulletPoint5Modified" type="text" class="form-control" @if ( array_key_exists( '4' ,$arrayBullets) ) value="{{ $arrayBullets[4] }}" @endif required>
    </div>
    </div>
    <div class="col-md-6">
    <ul class="nav nav-tabs" id="optionsCostPrice">
      <li id="manual" @if ($ProductData->UsingWebService == 0) class="active" @endif><a href="#manualtab" data-toggle="tab" id="manuallink">Manual</a></li>
      <li id="webservice" @if ($ProductData->UsingWebService == 1) class="active" @endif><a href="#webservicetab" id="webservicelink" data-toggle="tab">Web Service</a></li>
    </ul>
    <!-- starts tab content -->
    <div class="tab-content" style="padding-top:10px; padding-left:10px;">

      <div @if ($ProductData->UsingWebService == 0) class="tab-pane active" @else class="tab-pane" @endif id="manualtab"><!-- starts manual tab -->
        <div ng-app="app">
         <div ng-controller="Ctrl">
          <div id="CostModifiedProduct"  class="form-group">
            <label for="costModified">Cost</label>
            <label id="costHidden" hidden></label>
            <input id="costModified" ng-model='val' decimal-places type="text" style="text-align:right; width:40%;" class="form-control" required>
          </div>
        </div>
        <div ng-controller="Ctrl">
          <div id="PriceModifiedProduct"  class="form-group">
            <label for="sellingPriceModified">Selling Price</label>
            <label id="sellingPriceHidden" hidden></label>
            <input id="sellingPriceModified" ng-model='val' decimals-places type="text" style="text-align:right; width:40%;" class="form-control" required>
          </div>
        </div>
        </div>
        
        @if ($CompanySelected == 2 && $ProductSelected == 11)
        <fieldset id="range">
          <legend></legend>
          <div class="form-group">
            <label for="useManualPricing"><input type="checkbox" name="useManualPricing" id="useManualPricing" @if ($ProductData->UseRangePricing == true) checked @endif > Range Pricing</label>
          </div>
          <div class="form-group">
            <label for="TypeRange">Type</label>
            <select name="TypeRange" id="TypeRange" class="form-control" style="width:40%;">
              <option value="Gap Purchase" @if ($ProductData->Type == 'Gap Purchase') selected="selected" @endif >Gap Purchase</option>
              <option value="Gap Lease" @if ($ProductData->Type == 'Gap Lease') selected="selected" @endif >Gap Lease</option>
              <option value="Gap Balloon" @if ($ProductData->Type == 'Gap Balloon') selected="selected" @endif >Gap Balloon</option>
            </select>
          </div>

          <div class="form-group">
            <a href="#RangePricingModal" data-dismiss="modal" data-toggle="modal" class="btn btn-default btn-sm" id="btnSetPrices">Set prices</a> 
          </div>
        </fieldset>
        @endif

      </div><!-- ends manual tab -->

      <!-- starts modal for manual range pricing -->
      <div class="modal fade" id="RangePricingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" @if ($ProductData->UseRangePricing == 0) hidden @endif >
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
                    <tr class="x-headerRange">
                      <th colspan="2">Term</th>
                      <th>Gap Purchase</th>
                      <th>Gap Lease</th>
                      <th>Gap Balloon</th>
                    </tr>
                    <tr class="x-headerRange">
                      <th>From</th>
                      <th>To</th>
                      <th>Cost</th>
                      <th>Cost</th>
                      <th>Cost</th>
                      <th>Selling Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Ranges'][0]->TermFrom}}" @endif name="TermFrom" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Ranges'][0]->TermTo}}" @endif name="TermTo" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Gap Purchase'][0]->PricingCost}}" @endif name="CostPurchase" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Gap Lease'][0]->PricingCost}}" @endif name="CostLease" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Gap Balloon'][0]->PricingCost}}" @endif name="CostBalloon" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['SellingPrice'][0]}}" @endif name="SellingPrice" class="form-control" style="text-align:right;"></td>
                    </tr>
                    <tr>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Ranges'][1]->TermFrom}}" @endif name="TermFrom" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Ranges'][1]->TermTo}}" @endif name="TermTo" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Gap Purchase'][1]->PricingCost}}" @endif name="CostPurchase" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Gap Lease'][1]->PricingCost}}" @endif name="CostLease" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Gap Balloon'][1]->PricingCost}}" @endif name="CostBalloon" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['SellingPrice'][1]}}" @endif name="SellingPrice" class="form-control" style="text-align:right;"></td>
                    </tr>
                    <tr>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Ranges'][2]->TermFrom}}" @endif name="TermFrom" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Ranges'][2]->TermTo}}" @endif name="TermTo" class="form-control ignore pull-left"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Gap Purchase'][2]->PricingCost}}" @endif name="CostPurchase" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Gap Lease'][2]->PricingCost}}" @endif name="CostLease" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['Gap Balloon'][2]->PricingCost}}" @endif name="CostBalloon" class="form-control" style="text-align:right;"></td>
                      <td><input type="text" @if (array_key_exists('prices', $product)) value="{{$product->prices['SellingPrice'][2]}}" @endif name="SellingPrice" class="form-control" style="text-align:right;"></td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" id="restoreDefaults" data-dismiss="modal" class="btn btn-default">Close</button>
              <button type="button" id="saveRangePricing" class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal for manual range pricing -->
        <div @if ($ProductData->UsingWebService == 1) class="tab-pane active" @else class="tab-pane" @endif id="webservicetab">
        <!-- start web service tab -->

          <div id="TypeModifiedProduct" class="form-group">
            <label for="Type">Type</label>
            <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseTypeModified" name="UseTypeModified" @if ( $ProductData->UseType ) checked @endif > Use option</span>
            <select name="TypeModified" id="TypeModified" class="form-control" style="width:40%" @if ( $ProductData->UseType == 0 ) disabled @endif >
            @if (!empty($Types))
              @if ($ProductData->ProductBaseId == 4)
                @if (count($Types[0]['type']) >= 2)
                  @foreach ($Types[0]['type'] as $key => $value)
                    <option value="{{ $value['value'] }}" @if ($value['value'] == $ProductData->Type) selected="selected" @endif>{{ $value['text'] }}</option>
                  @endforeach
                @else
                  <option value="{{ $Types[0]['type']['value'] }}">{{ $Types[0]['type']['text'] }}</option>
                @endif
              @else
                @if (count($Types[0]['type']) > 2)
                  @foreach ($Types[0]['type'] as $key => $value)
                    <option value="{{ $value['value'] }}" @if ($value['value'] == $ProductData->Type) selected="selected" @endif>{{ $value['text'] }}</option>
                  @endforeach
                @else
                  <option value="{{ $Types[0]['type']['value'] }}">{{ $Types[0]['type']['text'] }}</option>
                @endif
              @endif
            @else
                <option value="None">None</option>
            @endif
           </select>
         </div>

         <div id="TermModifiedProduct" class="form-group">
          <label for="TermModified">Term</label>
          <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseTermModified" name="UseTermModified" @if ( $ProductData->UseTerm ) checked @endif > Use option</span>
          <select name="TermModified" id="TermModified" class="form-control" style="width:40%" @if ( $ProductData->UseTerm == 0 ) disabled @endif >
          @if (!empty($Terms))
          @if ($ProductData->ProductBaseId == 9)
            @if (count($Terms[0]['term']) >= 2)
              @foreach ($Terms[0]['term'] as $key => $value)
                <option value="{{ $value['value'] }}" @if ( $value['value'] == $ProductData->Term ) selected="selected" @endif>{{$value['text'] }}</option>
              @endforeach
            @else
              <option value="{{ $Terms[0]['term']['value'] }}">{{ $Terms[0]['term']['text'] }}</option>
            @endif
          @else
            @if (count($Terms[0]['term']) > 2)
              @foreach ($Terms[0]['term'] as $key => $value)
                <option value="{{ $value['value'] }}" @if ( $value['value'] == $ProductData->Term ) selected="selected" @endif>{{$value['text'] }}</option>
              @endforeach
            @else
              <option value="{{ $Terms[0]['term']['value'] }}">{{ $Terms[0]['term']['text'] }}</option>
            @endif
          @endif
          
          @else
            <option value="0">None</option>
          @endif
          </select>
        </div>

        <div id="DeductibleModifiedProduct" class="form-group">
          <label for="Deductible">Deductible </label>
          <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseDeductibleModified" name="UseDeductibleModified" @if ( $ProductData->UseDeductible ) checked @endif > Use option</span>
          <select id="DeductibleModified" name="DeductibleModified" class="form-control"  style="width:40%" @if ($ProductData->UseDeductible == 0) disabled @endif>
          @if (!empty($Deductibles))
          @if (count($Deductibles[0]['deductible']) > 2)
            @foreach ($Deductibles[0]['deductible'] as $key => $value)
              <option value="{{ $value['value'] }}" @if ( $value['value'] == $ProductData->Deductible ) selected="selected" @endif >{{$value['text'] }}</option>
            @endforeach
          @else
            <option value="{{ $Deductibles[0]['deductible']['value'] }}">{{ $Deductibles[0]['deductible']['text'] }}</option>
          @endif
          @else
            <option value="0">None</option>
          @endif
          </select>
        </div>
        
        <div id="VehiclePlanModifiedProduct" class="form-group WSUage2" @if ($ProductSelected != 12) hidden @endif>
          <label for="Deductible">Vehicle Plan</label>
          <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseVehiclePlanModified" name="UseVehiclePlanModified" @if ( $ProductData->UseVehiclePlan ) checked @endif > Use option</span>
          <select id="VehiclePlanModified" name="VehiclePlanModified" class="form-control"  style="width:40%" @if ($ProductData->UseVehiclePlan == 0) disabled @endif >
           <option value="New" @if ($ProductData->VehiclePlan == "New") selected="selected" @endif>New</option>                                
           <option value="PreOwned" @if ($ProductData->VehiclePlan == "PreOwned") selected="selected" @endif>Pre Owned</option>
           <option value="ExtendedEligibilityProgram" @if ($ProductData->VehiclePlan == "ExtendedEligibilityProgram") selected="selected" @endif>Extended Eligibility Program</option>
           <option value="VehiclesWith6monthManufacturersWarranty" @if ($ProductData->VehiclePlan == "VehiclesWith6monthManufacturersWarranty") selected="selected" @endif>Vehicles With 6 month Manufacturers Warranty</option>
           <option value="WrapNew" @if ($ProductData->VehiclePlan == "WrapNew") selected="selected" @endif>Wrap New</option>
           <option value="WrapOemCpo" @if ($ProductData->VehiclePlan == "WrapOemCpo") selected="selected" @endif>Wrap Oem Cpo</option>
           <option value="WrapPreOwned" @if ($ProductData->VehiclePlan == "WrapPreOwned") selected="selected" @endif>Wrap Pre Owned</option>
         </select>
       </div>

       <div id="MileageModifiedProduct" class="form-group WSUage2"@if ($ProductSelected != 2 && $ProductSelected != 4 && $ProductSelected != 12) hidden @endif>
         <label for="Mileage">Mileage</label>
          <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseMileageModified" name="UseMileageModified" @if ( $ProductData->UseMileage == 1 ) checked @endif > Use option</span>
          <select id="MileageModified" name="MileageModified" class="form-control"  style="width:40%" @if ( $ProductData->UseMileage == 0 ) disabled @endif >
          @if ( $ProductData->ProductBaseId == 4 )
            <option value="12" @if ($ProductData->Mileage == 12) selected="selected" @endif >12</option>
            <option value="15" @if ($ProductData->Mileage == 15) selected="selected" @endif >15</option>
            <option value="24" @if ($ProductData->Mileage == 24) selected="selected" @endif >24</option>
            <option value="30" @if ($ProductData->Mileage == 30) selected="selected" @endif >30</option>
            <option value="36" @if ($ProductData->Mileage == 36) selected="selected" @endif>36</option>
            <option value="39" @if ($ProductData->Mileage == 39) selected="selected" @endif>39</option>
            <option value="45" @if ($ProductData->Mileage == 45) selected="selected" @endif>45</option>
            <option value="48" @if ($ProductData->Mileage == 48) selected="selected" @endif>48</option>
            <option value="60" @if ($ProductData->Mileage == 60) selected="selected" @endif>60</option>
            <option value="75" @if ($ProductData->Mileage == 75) selected="selected" @endif>75</option>
          @else
            <option value="6" @if ($ProductData->Mileage == 6) selected="selected" @endif >6</option>
            <option value="12" @if ($ProductData->Mileage == 12) selected="selected" @endif >12</option>
            <option value="24" @if ($ProductData->Mileage == 24) selected="selected" @endif >24</option>
            <option value="36" @if ($ProductData->Mileage == 36) selected="selected" @endif >36</option>
            <option value="45" @if ($ProductData->Mileage == 45) selected="selected" @endif>45</option>
            <option value="48" @if ($ProductData->Mileage == 48) selected="selected" @endif>48</option>
            <option value="50" @if ($ProductData->Mileage == 50) selected="selected" @endif>50</option>
            <option value="60" @if ($ProductData->Mileage == 60) selected="selected" @endif>60</option>
            <option value="70" @if ($ProductData->Mileage == 70) selected="selected" @endif>70</option>
            <option value="75" @if ($ProductData->Mileage == 75) selected="selected" @endif>75</option>
            <option value="100" @if ($ProductData->Mileage == 100) selected="selected" @endif>100</option>
            <option value="120" @if ($ProductData->Mileage == 120) selected="selected" @endif>120</option>
            <option value="125" @if ($ProductData->Mileage == 125) selected="selected" @endif>125</option>
            <option value="150" @if ($ProductData->Mileage == 150) selected="selected" @endif>150</option>
          @endif
          </select>
       </div>

       <div id="TireRotationModifiedProduct" class="form-group WSUage2" @if ($ProductSelected != 4) hidden @endif>
         <label for="UseTireRotationModified">Tire Rotation</label>
         <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseTireRotationModified" name="UseTireRotationModified" @if ( $ProductData->UseTireRotation == 1 ) checked @endif > Use option</span>
         <select id="TireRotationModified" name="TireRotationModified" class="form-control"  style="width:40%" @if ( $ProductData->UseTireRotation == 0 ) disabled @endif >
          <option value="5000" @if ( $ProductData->TireRotation == 5000 ) selected="selected" @endif >5000</option>
          <option value="6000" @if ( $ProductData->TireRotation == 6000 ) selected="selected" @endif >6000</option>
          <option value="7500" @if ( $ProductData->TireRotation == 7500 ) selected="selected" @endif >7500</option>
        </select>
      </div>

      <div id="IntervalModifiedProduct" class="form-group WSUage2" @if ($ProductSelected != 4) hidden @endif>
         <label for="UseIntervalModified">Interval</label>
         <span class="pull-right alignText" style="margin-right: 40%;"><input type="checkbox" id="UseIntervalModified" name="UseIntervalModified" @if ( $ProductData->UseInterval == 1 ) checked @endif > Use option</span>
         <select id="IntervalModified" name="IntervalModified" class="form-control"  style="width:40%" @if ( $ProductData->UseInterval == 0 ) disabled @endif >
          <option value="1" @if ( $ProductData->Interval == 1 ) selected="selected" @endif >1</option>
          <option value="2" @if ( $ProductData->Interval == 2 ) selected="selected" @endif >2</option>
          <option value="3" @if ( $ProductData->Interval == 3 ) selected="selected" @endif >3</option>
          <option value="4" @if ( $ProductData->Interval == 4 ) selected="selected" @endif >4</option>
          <option value="5" @if ( $ProductData->Interval == 5 ) selected="selected" @endif >5</option>
        </select>
      </div>
       
      <div id="NotRegulatedModifiedProduct" class="form-group WSUage2">
        <label for="NotRegulatedModified">
        <input type="checkbox" id="NotRegulatedModified" name="NotRegulatedModified" @if($ProductData->NotRegulated == 1) checked @endif> Not Regulated</label> 
      </div>

   </div><!-- Ends tab content -->
   <div class="form-group">
    <label for="useWS"><input type="checkbox" id="useWS" name="useWS" @if ($ProductData->UsingWebService == 1) checked @endif > Use web service to obtain the cost and price</label>
  </div>
  <div id="IsTaxableModifiedProduct" class="form-group WSUage2">
    <label for="IsTaxableModified"><input type="checkbox" name="IsTaxableModified" id="IsTaxableModified" @if ($ProductData->IsTaxable == 1) checked @endif > Is Taxable</label>
  </div>
      <fieldset>
      <legend></legend>
      <div class="form-group">
        <label for="BrochureImageModified">Brochure</label>
        <div id="brochureOptionModified">
          <input type="hidden" id="BrochureImageData">
          <input type="button" id="BrochureImageModified"  class="pull-right" style="float:right; margin-right:20px;">
          <input id="BrochureImageReferModified" name="BrochureImageReferModified" type="text" placeholder="File" class="form-control pull-left" @if ($ProductData->BrochureImage) value="{{ $ProductData->BrochureImage }}" @endif style="width:80%">
        </div>
        <div id="videoOptionModified" style="display:none;">
          <input type="text" name="urlVideoModified" id="urlVideoModified" placeholder="URL" class="form-control"><br/>
        </div>
        <a href="#" id="showOptionsModified" class="pull-left">Picture/Video Size</a>
        <div class="pull-right">
        <label class="radio-inline">
            <input type="radio" name="mediaTypeModified" id="image_radio" value="Image" checked> Picture | 
          </label> 
          <label class="radio-inline">
            <input type="radio" name="mediaTypeModified" id="video_radio" value="VideoURL">Video
          </label>
         </div>
        </div>
        <div class="form-group">&nbsp;</div>
        <div id="sizeOptionsModified" style="display:none;">
          <label for="BrochureHeightModified">Height: <input type="text" name="BrochureHeightModified" id="BrochureHeightModified" class="form-control"></label>
          <label for="BrochureWidthModified">Width: <input type="text" name="BrochureWidthModified" id="BrochureWidthModified" class="form-control"></label>
        </div>
        <div class="form-group">&nbsp;</div>
       <div class="form-group">
        <label for="PDFContratorModified">Add PDF contract for this product</label>
        <input id="PDFContratorModified" name="PDFContratorModified" type="file" class="form-control" class="form-control">
        <input type="hidden" id="PDFSelected" />
      </div>
      @if ($ProductData->PDFContrator)
      <div class="form-group">
        <img src="images/pdf.png" >&nbsp;{{$ProductData->PDFContrator}} (<a href="uploads/pdf/{{$ProductData->PDFContrator}}"> Download </a>)
      </div>
      @endif
      </fieldset>
    </div>
</div>
</div>

<script src="js/product.js"></script>
<script src="js/angular.min.js"></script>
<script src="js/angular.js" type="text/javascript"></script>
<script src="js/jquery.uploadify.min.js" type="text/javascript"></script>

<script>
<?php $timestamp = time();?>

     $.ajax({
        type: "GET",
        url: "infoProduct",
        data: {
            ProductId: <?php echo Input::get('ProductId'); ?>
        },
        success: function (msg) {
            
            var data = JSON.parse(msg);
            var extensiones = new Array(".gif", ".jpg", ".png");
            var extension;
            var isURL = false;
            var BrochureInfo = data[0].BrochureImage;
            var TermValue;
            var TypeValue;
            var DeductibleValue;

            $('#idModified').val(data[0].idModified);
            $('#disclaimerModified').val(data[0].Disclaimer);
            $('#costHidden').text(data[0].Cost);
            $("#sellingPriceHidden").text(data[0].SellingPrice);
            $("#DescriptionModified").val(data[0].Description);
            var costData = data[0].Cost;
            var SellingPriceData = data[0].SellingPrice;
            $('#costModified').val(GetFloat(costData).toFixed(2));
            $('#sellingPriceModified').val(GetFloat(SellingPriceData).toFixed(2));
            $('#BrochureHeightModified').val(data[0].BrochureHeight);
            $('#BrochureWidthModified').val(data[0].BrochureWidth);
            $('#BrochureImageData').val(data[0].BrochureImage);

            if(BrochureInfo) {
            extension = (BrochureInfo.substring(BrochureInfo.lastIndexOf("."))).toLowerCase();
            for (var i = 0; i < extensiones.length; i++) { 
                if (extensiones[i] == extension) { 
                    isURL = true; 
                    break; 
                } 
            }

            if (!isURL) {
                $("#video_radio").prop("checked", true);
                $('#brochureOptionModified').hide();
                $('#videoOptionModified').show();
                $('#urlVideoModified').focus();
                $('#urlVideoModified').val(data[0].BrochureImage);
                $('#showOptionsModified').css('padding-top','2px');
            } else {
                $("#image_radio").prop("checked", true);
                $('#brochureOptionModified').show();
                $('#videoOptionModified').hide();
            }
        }

            if (data[0].UsingWebService == 1) {
                $("#costModified").prop('disabled', true);
                $("#costHidden").text($("#costModified").val());
                $("#costModified").val('0.00');
                $("#sellingPriceModified").prop('disabled', true);
                $("#sellingPriceHidden").text($("#sellingPriceModified").val());
                $("#sellingPriceModified").val('0.00');
                $("#useManualPricing").prop("checked", false);
                $('#manuallink').removeAttr('data-toggle');
                $('#webservicelink').attr('data-toggle','tab');
                $('#webservice').addClass('active');
                $('#webservicetab').addClass('active');
                $('#manual').removeClass('active');
                $('#manualtab').removeClass('active');
            } else {
                $('#manuallink').attr('data-toggle','tab');
                $('#manualtab').addClass('active');
                $('#webservicetab').removeClass('active');
                $('#manual').addClass('active');
                $('#webservice').removeClass('active');
                $('#webservicelink').removeAttr('data-toggle');
                $("#costModified").prop('disabled', false);
                $("#costModified").val($("#costHidden").text());
                $("#sellingPriceModified").prop('disabled', false);
                $("#sellingPriceModified").val($("#sellingPriceHidden").text());

            }

            var cost = '$'+ $('#costModified').val();
            var price = '$'+ $('#sellingPriceModified').val();
            $('#costModified').val(cost);
            $('#sellingPriceModified').val(price);
            
            if (data[0].UseRangePricing == 1) {
              $("#useManualPricing").prop("checked", true);
              $("#costModified").prop("disabled", true);
              $("#sellingPriceModified").prop("disabled", true);
            } else {
              $("#useManualPricing").prop("checked", false);
              $("#costModified").prop("disabled", false);
              $("#sellingPriceModified").prop("disabled", false);
            }

            if ( data[0].UseVehiclePlan == 1 ) {
                $("#UseVehiclePlanModified").prop("checked", true);
            } else {
                $("#UseVehiclePlanModified").prop("checked", false);
            }
        },
        failure: function (msg) {
        }
    });

function uploadModifiedData(callback){
    try {
      $('#PDFContratorModified').uploadify('upload','*');
      $('#BrochureImageModified').uploadify('upload','*');
    
      callback(true);
    }catch(err){
       window.location.href = 'settings-page';
    }
  };

$(function() {
      $('#BrochureImageModified').uploadify({
        'formData'     : {
          'timestamp' : '<?php echo $timestamp;?>',
          'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
        },
        'swf'      : 'js/uploadify.swf',
        'uploader' : 'js/uploadify.php',
        'fileTypeExts' : '*.gif; *.jpg; *.png',
        'fileTypeDesc' : 'Image Files',
        buttonText : "",
        'width'    : 17,
        'height': 19,
        'queueID'        : 'fileBrochureQueue',
        'buttonImage' : 'images/fileicon.png',
        'wmode'     : 'transparent',
        'hideButton': true,
        //'uploadLimit' : 1,
        'auto'     : false,
        'onSelect' : function(file) {
            $("#BrochureImageReferModified").val( file.name );  // Might need to use .text or .html insteal of .val, depending on element
        },
        'onUploadStart' : function(file) {
          var ProductId = $("#idModified").val();
          var formData = { 'ProductId': ProductId, 'Option' : 'UpdateBrochure', 'type' : 'image' }
          $('#BrochureImageModified').uploadify("settings", "formData", formData);
        },
        'onUploadSuccess' : function(file, data, response ) {
        }
      });

      $('#PDFContratorModified').uploadify({
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
        'onSelect' : function(file){
            $('#PDFSelected').val('yes');
        },
        'onUploadStart' : function(file) {
          var ProductId = $("#idModified").val()
          var pdfData = { 'ProductId': ProductId, 'Option' : 'UpdatePDF', 'type' : 'pdf' }
          $('#PDFContratorModified').uploadify("settings", "formData", pdfData);
        },
        'onUploadSuccess' : function(file, data, response) {
           $.unblockUI();
           toastr.success("The product has been updated", "Success");
           window.location.href = 'settings-page';
        }
      });
    });

$('#restoreDefaults').click( function() {
 /* $('#RangePricingModal input:text:not(".ignore")').val('');
  $('#TermFrom1').val(1);
  $('#TermTo60').val(60);
  $('#TermFrom60').val(60);
  $('#TermTo72').val(72);
  $('#TermFrom72').val(72);
  $('#TermTo84').val(84); */
});

</script>

@stop
