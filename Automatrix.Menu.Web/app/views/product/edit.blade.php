@extends('layouts.admin') 
@section('toolbar')
<div class="row">
	<div class="col-md-9">
		<a class="btn btn-success" id="updateInfo"><i class="fa fa-floppy-o"></i> Update</a> 
		<a class="btn btn-success" id="generalSettings" href="{{URL::action('DealerController@displayProducts', array('id' => $dealerId))}}"><i class="fa fa-times"></i> Cancel</a>
	</div>
	<div class="col-md-3"></div>
</div>
@stop 
@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="CompanyIdModified">Company Name</label>
			<div>
				<select name="CompanyIdModified" id="CompanyIdModified" class="form-control" style="width: 40%"> 
					@foreach ($companies as $company)
					<option value="{{ $company->id }}">{{ $company->CompanyName }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<input type="hidden" name="idModified" id="idModified">
		<div class="form-group">
			<label for="productNameModified">Product Name</label>
			<div id="ProductsListModified"></div>
		</div>
		<div class="form-group">
			<label for="displayNameModified">Display Name</label> <input
				id="displayNameModified" name="displayNameModified" type="text"
				class="form-control" required>
		</div>
		<div class="form-group">
			<label for="ProductDescriptionModified">Product Description</label> <input
				id="ProductDescriptionModified" type="text" class="form-control"
				required>
		</div>
		<div class="form-group">
			<label for="bulletsPoints">Bullets Points</label>
			<div class="form-group">
				<input id="bulletPoint1Modified" type="text" class="form-control"
					required>
			</div>
			<div class="form-group">
				<input id="bulletPoint2Modified" type="text" class="form-control"
					required>
			</div>
			<div class="form-group">
				<input id="bulletPoint3Modified" type="text" class="form-control"
					required>
			</div>
			<div class="form-group">
				<input id="bulletPoint4Modified" type="text" class="form-control"
					required>
			</div>
			<input id="bulletPoint5Modified" type="text" class="form-control"
				required>
		</div>
	</div>
	<div class="col-md-6">
		<div ng-app="app">
			<div ng-controller="Ctrl">
				<div id="CostModifiedProduct" class="form-group">
					<label for="costModified">Cost</label> 
					<label id="costHidden" hidden></label> 
					<input id="costModified" ng-model='val' decimal-places type="text" style="text-align: right; width: 40%;" class="form-control" required>
				</div>
			</div>
			<div ng-controller="Ctrl">
				<div id="PriceModifiedProduct" class="form-group">
					<label for="sellingPriceModified">Selling Price</label> 
					<label id="sellingPriceHidden" hidden></label> 
					<input id="sellingPriceModified" ng-model='val' decimals-places type="text" style="text-align: right; width: 40%;" class="form-control" required>
				</div>
			</div>
			<legend></legend>

			<div class="form-group">
				<label for="WSUsage">Use Web Service to obtain pricing <input type="checkbox" id="WSUsageModified" name="WSUsageModified"></label>
			</div>
			<fieldset id="extraFields">
				<div id="TypeModifiedProduct" class="form-group">
					<label for="Type">Type</label> 
						<span class="pull-right alignText" style="margin-right: 40%;">
							<input type="checkbox" id="UseTypeModified" name="UseTypeModified"> Use option
						</span> 
						<select name="TypeModified" id="TypeModified" class="form-control" style="width: 40%">
							<option value="Platinum">Platinum</option>
							<option value="Gold">Gold</option>
							<option value="Silver">Silver</option>
							<option value="Powertrain">Powertrain</option>
						</select>
				</div>

				<div id="TermModifiedProduct" class="form-group">
					<label for="TermModified">Term</label>
					<span class="pull-right alignText" style="margin-right: 40%;">
						<input type="checkbox" id="UseTermModified" name="UseTermModified"> Use option
					</span> 
					<select name="TermModified" id="TermModified" class="form-control" style="width: 40%">
						<option value="36">36</option>
						<option value="48">48</option>
						<option value="60">60</option>
						<option value="72">72</option>
					</select>
				</div>

				<div id="DeductibleModifiedProduct" class="form-group">
					<label for="Deductible">Deductible </label> 
					<span class="pull-right alignText" style="margin-right: 40%;">
					<input type="checkbox" id="UseDeductibleModified" name="UseDeductibleModified"> Use option</span> 
					<select id="DeductibleModified" name="DeductibleModified" class="form-control" style="width: 40%">
						<option value="50">$50</option>
						<option value="100">$100</option>
						<option value="200">$200</option>
						<option value="300">$300</option>
					</select>
				</div>

				<div id="VehiclePlanModifiedProduct" class="form-group WSUage2">
					<label for="Deductible">Vehicle Plan</label> 
					<span class="pull-right alignText" style="margin-right: 40%;">
					<input type="checkbox" id="UseVehiclePlanModified" name="UseVehiclePlanModified"> Use option</span> 
					<select id="VehiclePlanModified" name="VehiclePlanModified" class="form-control" style="width: 40%">
						<option value="New">New</option>
						<option value="PreOwned">Pre Owned</option>
						<option value="ExtendedEligibilityProgram">Extended Eligibility Program</option>
						<option value="VehiclesWith6monthManufacturersWarranty">Vehicles With 6 month Manufacturers Warranty</option>
						<option value="WrapNew">Wrap New</option>
						<option value="WrapOemCpo">Wrap Oem Cpo</option>
						<option value="WrapPreOwned">Wrap Pre Owned</option>
					</select>
				</div>
			</fieldset>
			<fieldset>
				<legend></legend>
				<div class="form-group">
					<label for="BrochureImageModified">Brochure</label>
					<div id="brochureOptionModified">
						<input type="hidden" id="BrochureImageData"> 
						<input type="button" id="BrochureImageModified" class="pull-right" style="float: right; margin-right: 20px;">
						<input id="BrochureImageReferModified" name="BrochureImageReferModified" type="text" placeholder="File" class="form-control pull-left" style="width: 80%">
					</div>
					<div id="videoOptionModified" style="display: none;">
						<input type="text" name="urlVideoModified" id="urlVideoModified" placeholder="URL" class="form-control"><br />
					</div>
					<a href="#" id="showOptionsModified" class="pull-left">Show options</a>
					<div class="pull-right">
						<label class="radio-inline"> 
						<input type="radio" name="mediaTypeModified" id="image_radio" value="Image" checked>Picture | </label> 
						<label class="radio-inline"> <input type="radio" name="mediaTypeModified" id="video_radio" value="VideoURL">Video</label>
					</div>
				</div>
				<div class="form-group">&nbsp;</div>
				<div id="sizeOptionsModified" style="display: none;">
					<label for="BrochureHeightModified">Height: <input type="text" name="BrochureHeightModified" id="BrochureHeightModified" class="form-control"></label> 
					<label for="BrochureWidthModified">Width: <input type="text" name="BrochureWidthModified" id="BrochureWidthModified" class="form-control"></label>
				</div>
				<div class="form-group">&nbsp;</div>
				<div class="form-group">
					<label for="PDFContratorModified">Add PDF contract for this product</label>
					<input id="PDFContratorModified" name="PDFContratorModified" type="file" class="form-control" class="form-control" />
				</div>
			</fieldset>
		</div>
	</div>
</div>
@stop
