@extends('layouts.admin') 

@section("scripts")
    {{ HTML::script('scripts/dealer.js'); }}
@stop

@section('toolbar')
<div class="row">
	<div class="col-md-7">
		<a class="btn btn-success" id="savedealer"><i class="fa fa-save"></i> Save</a>
		@if ($dealer->DealerId)
		  <a class="btn btn-success" href="{{URL::action('AccountController@show', array('id' => $dealer->DealerId))}}"><i class="fa fa-users"></i> Users</a>
		  <a class="btn btn-success" href="{{URL::action('ProductController@index', array('id' => $dealer->DealerId))}}"><i class="fa fa-th"></i> Products</a>
		@endif 
		<a class="btn btn-success" id="generaldealer"
			@if(empty($currentUser->DealerId)) 
				href="{{ URL::action('DealerController@index'); }} " 
			@else
				href="{{ $baseUrl }}/dealers/{{ $currentUser->DealerId }}/plan" 
			@endif><i class="fa fa-times"></i> Cancel
		</a>
	</div>
	<div class="col-md-5"></div>
</div>
@stop 
@section('content')

<div id="redirectAction" hidden> @if (!$currentUser->DealerId) {{ $baseUrl }}/dealers @else {{ $baseUrl }}/settings-page @endif</div>

<div class="row">
	<div class="col-md-6">
		<fieldset>
	          <legend>General Information</legend>
	          <table>
			      <tbody>
			        <tr>
			          <td style="width: 30%"><b>Dealer Name &#42;</b></td>
			          <td></td>
			          <td style="width: 70%"><input type="text" name="DealerName" id="DealerName" class="form-control float-right" 
			          @if ($dealer)
			          @if ($dealer->DealerName) 
			              value="{{ $dealer->DealerName }}" />
			          @endif
			          @endif 

			           
			          @if ($dealer)
			          @if ($dealer->DealerName) 
			              <input type="hidden" id="DealerIdHidden" value="{{ $dealer->DealerId }}" />
			          @endif
			          @endif </td>
			        </tr>
			        <tr>
			          <td style="width: 30%"><b>Company Code</b></td>
			          <td></td>
			          <td style="width: 70%"><input type="text" name="CompanyCode" id="CompanyCode" class="form-control float-right"
			          @if ($dealer)
			          @if ($dealer->CompanyCode) 
			              value="{{ $dealer->CompanyCode }}"
			          @endif
			          @endif ></td>
			        </tr>
			        <tr>
			          <td style="width: 30%"><b>Tax Rate &#42;</b></td>
			          <td></td>
			          <td style="width: 70%"><input type="text" name="TaxRate" placeholder="Tax Rate field from DMS webservice" id="TaxRate" class="form-control" @if ($dealer) @if ($dealer->TaxRate) value="{{$dealer->TaxRate }}%" @endif @endif style="width:60%"></td>
			        </tr>
			        <tr>
			          <td style="width: 30%"><b>Logo &#42;</b></td>
			          <td></td>
			          <td style="width: 70%">
			            <input type="button" id="DealerLogo" class="pull-right" style="float:right;">
			            <input type="text" name="DealerLogoField" id="DealerLogoField" class="form-control pull-left"
			            @if ($dealer)
			            @if ($dealer->DealerLogo) 
			                value="{{ $dealer->DealerLogo }}"
			            @endif
			            @endif style="width:60%;" ></td>
                                    <input type="hidden" id="logoSelected">
			        </tr>
			        <tr>
			          <td style="width: 30%"></td>
			          <td></td>
			          <td style="width: 70%; font-size: 11px;">Image size should be 300x50 to look nice!</td>		            
			        </tr>
			      </tbody>
			  </table>
	        </fieldset>
		<div class="clear">&nbsp;</div>
		<fieldset>
			<legend>Display</legend>

			<table>
				<tbody>
					<tr>
						<td><b>Buyer Name</b></td>
						<td></td>
						<td width="50%" class="pull-right"><input type="checkbox"
							id="DisplayBuyer" name="display" value="DisplayBuyer"
							@if ($dealer) @if ($dealer->DisplayBuyer == 1) checked @endif
							@endif></td>
					</tr>
					<tr>
						<td><b>Co Buyer Name</b></td>
						<td></td>
						<td width="50%" class="pull-right"><input type="checkbox"
							id="DisplayCoBuyer" name="display" value="DisplayCoBuyer"
							@if ($dealer) @if ($dealer->DisplayCoBuyer == 1) checked
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Down Payment</b></td>
						<td></td>
						<td width="50%" class="pull-right"><input type="checkbox"
							id="DisplayDownPayment" name="display" value="DisplayDownPayment"
							@if ($dealer) @if ($dealer->DisplayDownPayment == 1) checked
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Amount Financied</b></td>
						<td></td>
						<td width="50%" class="pull-right"><input type="checkbox"
							id="DisplayFinancedAmount" name="display"
							value="DisplayFinancedAmount" @if ($dealer) @if ($dealer->DisplayFinancedAmount
							== 1) checked @endif @endif ></td>
					</tr>
					<tr>
						<td><b>APR</b></td>
						<td></td>
						<td width="50%" class="pull-right"><input type="checkbox"
							id="DisplayAPR" name="display" value="DisplayAPR"
							@if ($dealer) @if ($dealer->DisplayAPR == 1) checked @endif
							@endif ></td>
					</tr>
					<tr>
						<td><b>Term</b></td>
						<td></td>
						<td width="50%" class="pull-right"><input type="checkbox"
							id="DisplayTerm" name="display" value="DisplayTerm"
							@if ($dealer) @if ($dealer->DisplayTerm == 1) checked @endif
							@endif ></td>
					</tr>
					<tr>
						<td><b>Trade In</b></td>
						<td></td>
						<td width="50%" class="pull-right"><input type="checkbox"
							id="DisplayTradeIn" name="display" value="DisplayTradeIn"
							@if ($dealer) @if ($dealer->DisplayTradeIn == 1) checked
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Pay Off</b></td>
						<td></td>
						<td width="50%" class="pull-right"><input type="checkbox"
							id="DisplayPayOff" name="display" value="DisplayPayOff"
							@if ($dealer) @if ($dealer->DisplayPayOff == 1) checked
							@endif @endif ></td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</div>

	<div class="col-md-6 pull-right">

		<fieldset>
			        <legend>Parameters</legend>

			          <table width="98%">
					      <tbody>
					        <tr>
					          <td><b>Deal &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Deal" id="Deal" placeholder="Deal number field from DMS webservice" class="form-control" 
					          @if ($dealer)
					          @if ($dealer->Deal) 
					              value="{{ $dealer->Deal }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>URL &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="URL" placeholder = "DMS webservice url to retrieve deal information" id="URL" class="form-control"
					          @if ($dealer)
					          @if ($dealer->URL) 
					              value="{{ $dealer->URL }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Year &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Year" placeholder="Year field from DMS webservice" id="Year" class="form-control"
					          @if ($dealer)
					          @if ($dealer->Year) 
					              value="{{ $dealer->Year }}"
					          @endif 
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Make &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Make" placeholder="Make field from DMS webservice" id="Make" class="form-control"
					          @if ($dealer)
					          @if ($dealer->Make) 
					              value="{{ $dealer->Make }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Model &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Model" placeholder="Model field from DMS webservice" id="Model" class="form-control"
					          @if ($dealer)
					          @if ($dealer->Model) 
					              value="{{ $dealer->Model }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Financed Amount &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="FinancedAmount" placeholder="Financed amount field from DMS webservice" id="FinancedAmount" class="form-control"
					          @if ($dealer)
					          @if ($dealer->FinancedAmount) 
					              value="{{ $dealer->FinancedAmount }}"
					          @endif 
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Base Payment &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="BasePayment" placeholder="Base payment field from DMS webservice" id="BasePayment" class="form-control"
					          @if ($dealer)
					          @if ($dealer->BasePayment) 
					              value="{{ $dealer->BasePayment }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>APR &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="APR" placeholder="Amount percentage rate field from DMS webservice" id="APR" class="form-control"
					          @if ($dealer)
					          @if ($dealer->APR) 
					              value="{{ $dealer->APR }}"
					          @endif 
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Term &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Term" placeholder="Term field from DMS webservice"  id="Term" class="form-control"
					          @if ($dealer)
					          @if ($dealer->Term) 
					              value="{{ $dealer->Term }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Down Payment &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="DownPayment" placeholder="Down Payment field from DMS webservice" id="DownPayment" class="form-control"
					          @if ($dealer)
					          @if ($dealer->DownPayment) 
					              value="{{ $dealer->DownPayment }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Buyer &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Buyer" placeholder="Buyer field from DMS webservice" id="Buyer" class="form-control"
					          @if ($dealer)
					          @if ($dealer->Buyer) 
					              value="{{ $dealer->Buyer }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Co Buyer &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="CoBuyer" placeholder="Co Buyer field from DMS webservice" id="CoBuyer" class="form-control"
					          @if ($dealer)
					          @if ($dealer->CoBuyer) 
					              value="{{ $dealer->CoBuyer }}"
					          @endif
					          @endif ></td>
					        </tr>
			                <tr>
			                  <td><b>Trim &#42;</b></td>
			                  <td></td>
			                  <td style="width: 70%"><input type="text" name="Trim" id="Trim" placeholder="Trim field from DMS webservice" class="form-control"
			                  @if ($dealer)
			                  @if ($dealer->Trim)
			                      value="{{ $dealer->Trim }}"
			                  @endif
			                  @endif ></td>
			                </tr>
			                <tr>
			                  <td><b>Vin &#42;</b></td>
			                  <td></td>
			                  <td style="width: 70%"><input type="text" name="Vin" placeholder="VIN field from DMS webservice" id="Vin" class="form-control"
			                  @if ($dealer)
			                  @if ($dealer->Vin)
			                      value="{{ $dealer->Vin }}"
			                  @endif
			                  @endif ></td>
			                </tr>
			                <tr>
			                  <td><b>Trade Allowance &#42;</b></td>
			                  <td></td>
			                  <td style="width: 70%"><input type="text" name="TradeAllowance" placeholder="Trade allowanse field from DMS webservice" id="TradeAllowance" class="form-control"
			                  @if ($dealer)
			                  @if ($dealer->TradeAllowance)
			                      value="{{ $dealer->TradeAllowance }}"
			                  @endif
			                  @endif ></td>
			                </tr>
			                <tr>
			                  <td><b>Trade Pay-Off &#42;</b></td>
			                  <td></td>
			                  <td style="width: 70%"><input type="text" name="TradePayOff" placeholder="Trade pay off field from DMS webservice" id="TradePayOff" class="form-control"
			                  @if ($dealer)
			                  @if ($dealer->TradePayOff)
			                      value="{{ $dealer->TradePayOff }}"
			                  @endif
			                  @endif ></td>
			                </tr>
			                <tr>
							  <td><b>Beginning Odometer &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="BeginningOdometer" placeholder="Beginning Odometer field from DMS webservice"
								id="BeginningOdometer" class="form-control"
								@if ($dealer)
				                  @if ($dealer->BeginningOdometer) value="{{
								$dealer->BeginningOdometer }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>First Name &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="FirstName" placeholder="First Name field from DMS webservice"
								id="FirstName" class="form-control"
								@if ($dealer)
				                  @if ($dealer->FirstNameParameter) value="{{
								$dealer->FirstNameParameter }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Middle Name &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="MiddleName" placeholder="Middle Name field from DMS webservice"
								id="MiddleName" class="form-control"
								@if ($dealer)
				                  @if ($dealer->MiddleNameParameter) value="{{
								$dealer->MiddleNameParameter }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Last Name &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LastName" placeholder="Last Name field from DMS webservice"
								id="LastName" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LastNameParameter) value="{{
								$dealer->LastNameParameter }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Address 1 &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Address1" placeholder="Address 1 field from DMS webservice"
								id="Address1" class="form-control"
								@if ($dealer)
				                  @if ($dealer->Address1) value="{{
								$dealer->Address1 }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Address 2 &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Address2" placeholder="Address 2 field from DMS webservice"
								id="Address2" class="form-control"
								@if ($dealer)
				                  @if ($dealer->Address2) value="{{
								$dealer->Address2 }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>City &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="City" placeholder="City field from DMS webservice"
								id="City" class="form-control"
								@if ($dealer)
				                  @if ($dealer->City) value="{{
								$dealer->City }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>State &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="State" placeholder="State field from DMS webservice"
								id="State" class="form-control"
								@if ($dealer)
				                  @if ($dealer->State) value="{{
								$dealer->State }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>State Code &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="StateCode" placeholder="State Code field from DMS webservice"
								id="StateCode" class="form-control"
								@if ($dealer)
				                  @if ($dealer->StateCode) value="{{
								$dealer->StateCode }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Zip Code &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="ZipCode" placeholder="Zip Code field from DMS webservice"
								id="ZipCode" class="form-control"
								@if ($dealer)
				                  @if ($dealer->ZipCode) value="{{
								$dealer->ZipCode }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Country &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Country" placeholder="Country field from DMS webservice"
								id="Country" class="form-control"
								@if ($dealer)
				                  @if ($dealer->Country) value="{{
								$dealer->Country }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Country Code &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="CountryCode" placeholder="Country Code field from DMS webservice"
								id="CountryCode" class="form-control"
								@if ($dealer)
				                  @if ($dealer->CountryCode) value="{{
								$dealer->CountryCode }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Telephone &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Telephone" placeholder="Telephone field from DMS webservice"
								id="Telephone" class="form-control"
								@if ($dealer)
				                  @if ($dealer->Telephone) value="{{
								$dealer->Telephone }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Email &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Email" placeholder="Email field from DMS webservice"
								id="Email" class="form-control"
								@if ($dealer)
				                  @if ($dealer->Email) value="{{
								$dealer->Email }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Name &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderName" placeholder="Lien Holder Name field from DMS webservice"
								id="LienHolderName" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderName) value="{{
								$dealer->LienHolderName }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Address &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderAddress" placeholder="Lien Holder Address field from DMS webservice"
								id="LienHolderAddress" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderAddress) value="{{
								$dealer->LienHolderAddress }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Country &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderCountry" placeholder="Lien Holder Country field from DMS webservice"
								id="LienHolderCountry" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderCountry) value="{{
								$dealer->LienHolderCountry }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder City &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderCity" placeholder="Lien Holder City field from DMS webservice"
								id="LienHolderCity" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderCity) value="{{
								$dealer->LienHolderCity }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder State &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderState" placeholder="Lien Holder State field from DMS webservice"
								id="LienHolderState" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderState) value="{{
								$dealer->LienHolderState }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Zip &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderZip" placeholder="Lien Holder Zip field from DMS webservice"
								id="LienHolderZip" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderZip) value="{{
								$dealer->LienHolderZip }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Email &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderEmail" placeholder="Lien Holder Email field from DMS webservice"
								id="LienHolderEmail" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderEmail) value="{{
								$dealer->LienHolderEmail }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Phone &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderPhone" placeholder="Lien Holder Phone field from DMS webservice"
								id="LienHolderPhone" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderPhone) value="{{
								$dealer->LienHolderPhone }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Fax &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderFax" placeholder="Lien Holder Fax field from DMS webservice"
								id="LienHolderFax" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderFax) value="{{
								$dealer->LienHolderFax }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Type &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderType" placeholder="Lien Holder Type field from DMS webservice"
								id="LienHolderType" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderType) value="{{
								$dealer->LienHolderType }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Contact &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderContact" placeholder="Lien Holder Contact field from DMS webservice"
								id="LienHolderContact" class="form-control"
								@if ($dealer)
				                  @if ($dealer->LienHolderContact) value="{{
								$dealer->LienHolderContact }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Vehicle Purchase Price &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="VehiclePurchasePrice" placeholder="Vehicle Purchase Price field from DMS webservice" id="VehiclePurchasePrice" class="form-control" @if ($dealer)
				                  @if ($dealer->VehiclePurchasePrice) value="{{
								$dealer->VehiclePurchasePrice }}" @endif @endif></td>
						    </tr>
						    <tr>
							  <td><b>Vehicle Purchase Date &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="VehiclePurchaseDate" placeholder="Vehicle Purchase Date field from DMS webservice" id="VehiclePurchaseDate" class="form-control" @if ($dealer)
				                  @if ($dealer->VehiclePurchaseDate) value="{{
								$dealer->VehiclePurchaseDate }}" @endif @endif></td>
						    </tr>
					      </tbody>
			        </table>
			    	 
			    </fieldset>


	</div>

</div>

<div class="row">
	<div class="col-md-11">
		<div class="form-group">
			<label for="Disclosure">Disclosure</label> @if ($dealer) @if
			($dealer->Disclosure)
			<textarea id="Disclosure" name="Disclosure" class="form-control"
				rows="10">{{ $dealer->Disclosure }}</textarea>
			@else
			<textarea id="Disclosure" name="Disclosure" class="form-control"
				rows="10"></textarea>
			@endif @else
			<textarea id="Disclosure" name="Disclosure" class="form-control"
				rows="10"></textarea>
			@endif
		</div>
	</div>
</div>

<script>
    <?php $timestamp = time();?>
    var DealerIdValue;

    function saveLogo(DealerIdSaved,callback){
	<?php
	if ($dealer)
	{
		if (! $dealer->DealerId)
		{
			?>
        
    <?php
		}
		else
		{
			?>
      DealerIdValue = <?php echo $dealer->DealerId; ?>; 
    <?php
		}
	}
	else
	{
		?>
        DealerIdValue = DealerIdSaved;
    <?php
	}
	?>
	  
	  try {
	    $('#DealerLogo').uploadify('upload','*');
	    callback(true);
	  }catch(err){
	     window.location.href = 'dealer-dealer';
	  }
	};

	$(document).ready(function() {
    $('#Disclosure').summernote({
    	height: 200,
	    toolbar: [
	    ['style', ['bold', 'italic', 'underline', 'clear']],
	    ['fontsize', ['fontsize']],
	    ['color', ['color']],
	    ['para', ['ul', 'ol', 'paragraph']],
        ]
    });

    $('#DealerLogo').uploadify({
        'formData'     : {
          'timestamp' : '<?php echo $timestamp;?>',
          'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
        },
        'swf'      : '<?php echo $baseUrl; ?>/js/uploadify.swf',
        'uploader' : '<?php echo $baseUrl; ?>/js/uploadify.php',
        'width'    : 17,
        'height': 19,
        'queueID'        : 'fileBrochureQueue',
        'hideButton': true,
        'wmode'     : 'transparent',
        'buttonImage' : '<?php echo $baseUrl; ?>/images/fileicon.png',
        'fileTypeExts' : '*.gif; *.jpg; *.png',
        'fileTypeDesc' : 'Image Files',
         buttonText : "",
        'auto'     : false,
        'onSelect' : function(file) {
            $("#DealerLogoField").val( file.name );
        },
        'onUploadStart' : function(file) {
          var formData = { 'DealerId': DealerIdValue, 'Option' : 'UpdateDealer', 'type' : 'DealerLogo' }
          $('#DealerLogo').uploadify("dealer", "formData", formData);
        },
        'onUploadSuccess' : function(file, data, response) {
            window.location.href = 'dealer-dealer';
        }
      });
});
</script>
@stop