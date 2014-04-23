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


<div>

@if ( !$UserSessionInfo->DealerId )
<div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li><a href="dealer-settings" style="background: rgba(255,255,255,0.2);">Dealers</a>
                </li>
                <li><a href="company-settings">Companies</a>
                </li>
            </ul>
</div>
@endif

<div class="row" style="padding-top: 10px;">
	<div class="col-md-7">
	  <a class="btn btn-success" id="saveSettings"><i class="fa fa-save"></i> Save</a>
	  @if ( !$UserSessionInfo->DealerId && $settings)
          <a class="btn btn-success" id="" href="settings-dealercode?DealerId={{$settings->DealerId}}">Warranty Companies</a>
      @endif
	  <a class="btn btn-success" id="userManagement" 
	              @if ($UserSessionInfo)
		            @if ($UserSessionInfo->DealerId) 
		              href="users?DealerId={{ $UserSessionInfo->DealerId }}"
		            @else
                      @if ($settings)
				          @if ($settings->DealerId) 
				              href="users?DealerId={{ $settings->DealerId }}"
				          @endif
				      @else
		              		style="display:none;"
				       @endif
		            @endif		            
		          @endif ><i class="fa fa-users"></i> Users</a>
	  <a class="btn btn-success" id="generalSettings" 
					@if(empty($UserSessionInfo->DealerId))
						href="dealer-settings"
					@else
						href="settings-page"
					@endif  ><i class="fa fa-times"></i> Cancel</a>
	  <div style="margin-bottom:2%"></div>
	</div> <!-- ends container class -->
	<div class="col-md-5">
	</div>
</div>

<div id="redirectAction" hidden> @if (!$UserSessionInfo->DealerId) dealer-settings @else settings-page @endif</div>

	<div class="row">

	    <!--<div @if ( !$UserSessionInfo->DealerId ) class="col-md-6" @else class="col-md-7" @endif> -->
	    <div class="col-md-6">
	        <fieldset>
	          <legend>General Information</legend>
	          <table>
			      <tbody>
			        <tr>
			          <td style="width: 30%"><b>Dealer Name &#42;</b></td>
			          <td></td>
			          <td style="width: 70%"><input type="text" name="DealerName" id="DealerName" class="form-control float-right" 
			          @if ($settings)
			          @if ($settings->DealerName) 
			              value="{{ $settings->DealerName }}" />
			          @endif
			          @endif 

			           
			          @if ($settings)
			          @if ($settings->DealerName) 
			              <input type="hidden" id="DealerIdHidden" value="{{ $settings->DealerId }}" />
			          @endif
			          @endif </td>
			        </tr>
			        <tr>
			          <td style="width: 30%"><b>Company Code</b></td>
			          <td></td>
			          <td style="width: 70%"><input type="text" name="CompanyCode" id="CompanyCode" class="form-control float-right"
			          @if ($settings)
			          @if ($settings->CompanyCode) 
			              value="{{ $settings->CompanyCode }}"
			          @endif
			          @endif ></td>
			        </tr>
			        <tr>
			          <td style="width: 30%"><b>Tax Rate &#42;</b></td>
			          <td></td>
			          <td style="width: 70%"><input type="text" name="TaxRate" placeholder="Tax Rate field from DMS webservice" id="TaxRate" class="form-control" @if ($settings) @if ($settings->TaxRate) value="{{$settings->TaxRate }}%" @endif @endif style="width:60%"></td>
			        </tr>
			        <tr>
			          <td style="width: 30%"><b>Logo &#42;</b></td>
			          <td></td>
			          <td style="width: 70%">
			            <input type="button" id="DealerLogo" style="float:right;">
			            <input type="text" name="DealerLogoField" id="DealerLogoField" class="form-control pull-left"
			            @if ($settings)
			            @if ($settings->DealerLogo) 
			                value="{{ $settings->DealerLogo }}"
			            @endif
			            @endif style="width:60%;" ></td>
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
			          <td width="50%" class="pull-right"><input type="checkbox" id="DisplayBuyer" name="display" value="DisplayBuyer" 
			          @if ($settings) @if ($settings->DisplayBuyer == 1) checked @endif @endif></td>
			        </tr>
			        <tr>
			          <td><b>Co Buyer Name</b></td>
			          <td></td>
			          <td width="50%" class="pull-right"><input type="checkbox" id="DisplayCoBuyer" name="display" value="DisplayCoBuyer" 
			          @if ($settings) @if ($settings->DisplayCoBuyer == 1) checked @endif @endif ></td>
			        </tr>
			        <tr>
			          <td><b>Down Payment</b></td>
			          <td></td>
			          <td width="50%" class="pull-right"><input type="checkbox" id="DisplayDownPayment" name="display" value="DisplayDownPayment" 
			          @if ($settings) @if ($settings->DisplayDownPayment == 1) checked @endif @endif ></td>
			        </tr>
			        <tr>
			          <td><b>Amount Financed</b></td>
			          <td></td>
			          <td width="50%" class="pull-right"><input type="checkbox" id="DisplayFinancedAmount" name="display" value="DisplayFinancedAmount" 
			          @if ($settings) @if ($settings->DisplayFinancedAmount == 1) checked @endif @endif ></td>
			        </tr>
			        <tr>
			          <td><b>APR</b></td>
			          <td></td>
			          <td width="50%" class="pull-right"><input type="checkbox" id="DisplayAPR" name="display" value="DisplayAPR" 
			          @if ($settings) @if ($settings->DisplayAPR == 1) checked @endif @endif ></td>
			        </tr>
			        <tr>
			          <td><b>Term</b></td>
			          <td></td>
			          <td width="50%" class="pull-right"><input type="checkbox" id="DisplayTerm" name="display" value="DisplayTerm" 
			          @if ($settings) @if ($settings->DisplayTerm == 1) checked @endif @endif ></td>
			        </tr>
			        <tr>
			          <td><b>Trade In</b></td>
			          <td></td>
			          <td width="50%" class="pull-right"><input type="checkbox" id="DisplayTradeIn" name="display" value="DisplayTradeIn" 
			          @if ($settings) @if ($settings->DisplayTradeIn == 1) checked @endif @endif ></td>
			        </tr>
			        <tr>
			          <td><b>Pay Off</b></td>
			          <td></td>
			          <td width="50%" class="pull-right"><input type="checkbox" id="DisplayPayOff" name="display" value="DisplayPayOff" 
			          @if ($settings) @if ($settings->DisplayPayOff == 1) checked @endif @endif ></td>
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
					          @if ($settings)
					          @if ($settings->Deal) 
					              value="{{ $settings->Deal }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>URL &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="URL" placeholder = "DMS webservice url to retrieve deal information" id="URL" class="form-control"
					          @if ($settings)
					          @if ($settings->URL) 
					              value="{{ $settings->URL }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Year &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Year" placeholder="Year field from DMS webservice" id="Year" class="form-control"
					          @if ($settings)
					          @if ($settings->Year) 
					              value="{{ $settings->Year }}"
					          @endif 
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Make &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Make" placeholder="Make field from DMS webservice" id="Make" class="form-control"
					          @if ($settings)
					          @if ($settings->Make) 
					              value="{{ $settings->Make }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Model &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Model" placeholder="Model field from DMS webservice" id="Model" class="form-control"
					          @if ($settings)
					          @if ($settings->Model) 
					              value="{{ $settings->Model }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Financed Amount &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="FinancedAmount" placeholder="Financed amount field from DMS webservice" id="FinancedAmount" class="form-control"
					          @if ($settings)
					          @if ($settings->FinancedAmount) 
					              value="{{ $settings->FinancedAmount }}"
					          @endif 
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Base Payment &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="BasePayment" placeholder="Base payment field from DMS webservice" id="BasePayment" class="form-control"
					          @if ($settings)
					          @if ($settings->BasePayment) 
					              value="{{ $settings->BasePayment }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>APR &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="APR" placeholder="Amount percentage rate field from DMS webservice" id="APR" class="form-control"
					          @if ($settings)
					          @if ($settings->APR) 
					              value="{{ $settings->APR }}"
					          @endif 
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Term &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Term" placeholder="Term field from DMS webservice"  id="Term" class="form-control"
					          @if ($settings)
					          @if ($settings->Term) 
					              value="{{ $settings->Term }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Down Payment &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="DownPayment" placeholder="Down Payment field from DMS webservice" id="DownPayment" class="form-control"
					          @if ($settings)
					          @if ($settings->DownPayment) 
					              value="{{ $settings->DownPayment }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Buyer &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="Buyer" placeholder="Buyer field from DMS webservice" id="Buyer" class="form-control"
					          @if ($settings)
					          @if ($settings->Buyer) 
					              value="{{ $settings->Buyer }}"
					          @endif
					          @endif ></td>
					        </tr>
					        <tr>
					          <td><b>Co Buyer &#42;</b></td>
					          <td></td>
					          <td style="width: 70%"><input type="text" name="CoBuyer" placeholder="Co Buyer field from DMS webservice" id="CoBuyer" class="form-control"
					          @if ($settings)
					          @if ($settings->CoBuyer) 
					              value="{{ $settings->CoBuyer }}"
					          @endif
					          @endif ></td>
					        </tr>
			                <tr>
			                  <td><b>Trim &#42;</b></td>
			                  <td></td>
			                  <td style="width: 70%"><input type="text" name="Trim" id="Trim" placeholder="Trim field from DMS webservice" class="form-control"
			                  @if ($settings)
			                  @if ($settings->Trim)
			                      value="{{ $settings->Trim }}"
			                  @endif
			                  @endif ></td>
			                </tr>
			                <tr>
			                  <td><b>Vin &#42;</b></td>
			                  <td></td>
			                  <td style="width: 70%"><input type="text" name="Vin" placeholder="VIN field from DMS webservice" id="Vin" class="form-control"
			                  @if ($settings)
			                  @if ($settings->Vin)
			                      value="{{ $settings->Vin }}"
			                  @endif
			                  @endif ></td>
			                </tr>
			                <tr>
			                  <td><b>Trade Allowance &#42;</b></td>
			                  <td></td>
			                  <td style="width: 70%"><input type="text" name="TradeAllowance" placeholder="Trade allowanse field from DMS webservice" id="TradeAllowance" class="form-control"
			                  @if ($settings)
			                  @if ($settings->TradeAllowance)
			                      value="{{ $settings->TradeAllowance }}"
			                  @endif
			                  @endif ></td>
			                </tr>
			                <tr>
			                  <td><b>Trade Pay-Off &#42;</b></td>
			                  <td></td>
			                  <td style="width: 70%"><input type="text" name="TradePayOff" placeholder="Trade pay off field from DMS webservice" id="TradePayOff" class="form-control"
			                  @if ($settings)
			                  @if ($settings->TradePayOff)
			                      value="{{ $settings->TradePayOff }}"
			                  @endif
			                  @endif ></td>
			                </tr>
			                <tr>
							  <td><b>Beginning Odometer &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="BeginningOdometer" placeholder="Beginning Odometer field from DMS webservice"
								id="BeginningOdometer" class="form-control"
								@if ($settings)
				                  @if ($settings->BeginningOdometer) value="{{
								$settings->BeginningOdometer }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>First Name &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="FirstName" placeholder="First Name field from DMS webservice"
								id="FirstName" class="form-control"
								@if ($settings)
				                  @if ($settings->FirstNameParameter) value="{{
								$settings->FirstNameParameter }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Middle Name &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="MiddleName" placeholder="Middle Name field from DMS webservice"
								id="MiddleName" class="form-control"
								@if ($settings)
				                  @if ($settings->MiddleNameParameter) value="{{
								$settings->MiddleNameParameter }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Last Name &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LastName" placeholder="Last Name field from DMS webservice"
								id="LastName" class="form-control"
								@if ($settings)
				                  @if ($settings->LastNameParameter) value="{{
								$settings->LastNameParameter }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Address 1 &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Address1" placeholder="Address 1 field from DMS webservice"
								id="Address1" class="form-control"
								@if ($settings)
				                  @if ($settings->Address1) value="{{
								$settings->Address1 }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Address 2 &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Address2" placeholder="Address 2 field from DMS webservice"
								id="Address2" class="form-control"
								@if ($settings)
				                  @if ($settings->Address2) value="{{
								$settings->Address2 }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>City &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="City" placeholder="City field from DMS webservice"
								id="City" class="form-control"
								@if ($settings)
				                  @if ($settings->City) value="{{
								$settings->City }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>State &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="State" placeholder="State field from DMS webservice"
								id="State" class="form-control"
								@if ($settings)
				                  @if ($settings->State) value="{{
								$settings->State }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>State Code &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="StateCode" placeholder="State Code field from DMS webservice"
								id="StateCode" class="form-control"
								@if ($settings)
				                  @if ($settings->StateCode) value="{{
								$settings->StateCode }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Zip Code &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="ZipCode" placeholder="Zip Code field from DMS webservice"
								id="ZipCode" class="form-control"
								@if ($settings)
				                  @if ($settings->ZipCode) value="{{
								$settings->ZipCode }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Country &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Country" placeholder="Country field from DMS webservice"
								id="Country" class="form-control"
								@if ($settings)
				                  @if ($settings->Country) value="{{
								$settings->Country }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Country Code &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="CountryCode" placeholder="Country Code field from DMS webservice"
								id="CountryCode" class="form-control"
								@if ($settings)
				                  @if ($settings->CountryCode) value="{{
								$settings->CountryCode }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Telephone &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Telephone" placeholder="Telephone field from DMS webservice"
								id="Telephone" class="form-control"
								@if ($settings)
				                  @if ($settings->Telephone) value="{{
								$settings->Telephone }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Email &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="Email" placeholder="Email field from DMS webservice"
								id="Email" class="form-control"
								@if ($settings)
				                  @if ($settings->Email) value="{{
								$settings->Email }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Name &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderName" placeholder="Lien Holder Name field from DMS webservice"
								id="LienHolderName" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderName) value="{{
								$settings->LienHolderName }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Address &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderAddress" placeholder="Lien Holder Address field from DMS webservice"
								id="LienHolderAddress" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderAddress) value="{{
								$settings->LienHolderAddress }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Country &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderCountry" placeholder="Lien Holder Country field from DMS webservice"
								id="LienHolderCountry" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderCountry) value="{{
								$settings->LienHolderCountry }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder City &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderCity" placeholder="Lien Holder City field from DMS webservice"
								id="LienHolderCity" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderCity) value="{{
								$settings->LienHolderCity }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder State &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderState" placeholder="Lien Holder State field from DMS webservice"
								id="LienHolderState" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderState) value="{{
								$settings->LienHolderState }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Zip &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderZip" placeholder="Lien Holder Zip field from DMS webservice"
								id="LienHolderZip" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderZip) value="{{
								$settings->LienHolderZip }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Email &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderEmail" placeholder="Lien Holder Email field from DMS webservice"
								id="LienHolderEmail" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderEmail) value="{{
								$settings->LienHolderEmail }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Phone &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderPhone" placeholder="Lien Holder Phone field from DMS webservice"
								id="LienHolderPhone" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderPhone) value="{{
								$settings->LienHolderPhone }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Fax &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderFax" placeholder="Lien Holder Fax field from DMS webservice"
								id="LienHolderFax" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderFax) value="{{
								$settings->LienHolderFax }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Type &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderType" placeholder="Lien Holder Type field from DMS webservice"
								id="LienHolderType" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderType) value="{{
								$settings->LienHolderType }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Lien Holder Contact &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="LienHolderContact" placeholder="Lien Holder Contact field from DMS webservice"
								id="LienHolderContact" class="form-control"
								@if ($settings)
				                  @if ($settings->LienHolderContact) value="{{
								$settings->LienHolderContact }}" @endif @endif ></td>
						    </tr>
						    <tr>
							  <td><b>Vehicle Purchase Price &#42;</b></td>
							  <td></td>
							  <td style="width: 70%"><input type="text" name="VehiclePurchasePrice" placeholder="Vehicle Purchase Price field from DMS webservice" id="VehiclePurchasePrice" class="form-control" @if ($settings)
				                  @if ($settings->VehiclePurchasePrice) value="{{
								$settings->VehiclePurchasePrice }}" @endif @endif></td>
						    </tr>
					      </tbody>
			        </table>
			    	 
			    </fieldset>  		    	
		
	          
	    </div>    

	</div>

	<div class="row">
	    <!--<div @if ( !$UserSessionInfo->DealerId ) class="col-md-10" @else class="col-md-12" @endif> -->
	    <div class="col-md-11">
	       <div class="form-group">
	           <label for="Disclosure">Disclosure &#42;</label>
	           @if ($settings)
	           @if ($settings->Disclosure) 
	             <textarea id="Disclosure" name="Disclosure" class="form-control" rows="10">{{ $settings->Disclosure }}</textarea>
			   @else
	               <textarea id="Disclosure" name="Disclosure" class="form-control" rows="10"></textarea>
	           @endif
	           @else
	               <textarea id="Disclosure" name="Disclosure" class="form-control" rows="10"></textarea>
	           @endif
	       </div>
		</div>
	</div>

	
</div>

<script src="js/dealer.js" type="text/javascript"></script>
{{ HTML::script('packages/bootstrap/js/summernote.min.js'); }}
<script src="js/jquery.uploadify.min.js" type="text/javascript"></script>
<script>
    <?php $timestamp = time();?>
    var DealerIdValue;

    function saveLogo(DealerIdSaved,callback){
	<?php
	if ( $settings ) {
      if (!$settings->DealerId){
    ?>
        
    <?php  	
      } else {
    ?>
      DealerIdValue = <?php echo $settings->DealerId; ?>; 
    <?php
      }
    } else {
    ?>
        DealerIdValue = DealerIdSaved;
    <?php	
    }
    ?>
	  
	  try {
	    $('#DealerLogo').uploadify('upload','*');
	    callback(true);
	  }catch(err){
	     window.location.href = 'dealer-settings';
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
            $("#DealerLogoField").val( file.name );
        },
        'onUploadStart' : function(file) {
          var formData = { 'DealerId': DealerIdValue, 'Option' : 'UpdateDealer', 'type' : 'DealerLogo' }
          $('#DealerLogo').uploadify("settings", "formData", formData);
        },
        'onUploadSuccess' : function(file, data, response) {
            window.location.href = 'dealer-settings';
        }
      });
});
</script>
@stop
