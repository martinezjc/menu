@extends('layouts.admin') 

@section('toolbar')
<div class="row">
	<div class="col-md-7">
		<a class="btn btn-success" id="saveSettings"><i class="fa fa-save"></i> Save</a> 
		<a class="btn btn-success" href="{{URL::action('DealerController@displayUsers', array('id' => $dealer->DealerId))}}"><i class="fa fa-users"></i> Users</a>
		<a class="btn btn-success" href="{{URL::action('DealerController@displayProducts', array('id' => $dealer->DealerId))}}"><i class="fa fa-th"></i> Products</a> 
		<a class="btn btn-success" id="generalSettings"
			@if(empty($currentUser->DealerId)) 
				href="{{ URL::action('DealerController@index'); }} " 
			@else
				href="settings-page" 
			@endif><i class="fa fa-times"></i> Cancel
		</a>
	</div>
	<div class="col-md-5"></div>
</div>
@stop 
@section('content')
<div class="row">
	<div class="col-md-6">
		<fieldset>
			<legend>General Information</legend>
			<table>
				<tbody>
					<tr>
						<td style="width: 30%"><b>Dealer Name</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="DealerName"
							id="DealerName" class="form-control float-right"
							@if ($dealer)
			          @if ($dealer->DealerName) value="{{ $dealer->DealerName
							}}" /> @endif @endif @if ($dealer) @if ($dealer->DealerName)
							<input type="hidden" id="DealerIdHidden"
							value="{{ $dealer->DealerId }}" /> @endif @endif</td>
					</tr>
					<tr>
						<td style="width: 30%"><b>Company Code</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="CompanyCode"
							id="CompanyCode" class="form-control float-right"
							@if ($dealer)
			          @if ($dealer->CompanyCode) value="{{
							$dealer->CompanyCode }}" @endif @endif ></td>
					</tr>
					<tr>
						<td style="width: 30%"><b>Logo</b></td>
						<td></td>
						<td style="width: 70%"><input type="button" id="DealerLogo"
							style="float: right;"> <input type="text" name="DealerLogoField"
							id="DealerLogoField" class="form-control pull-left"
							@if ($dealer)
			            @if ($dealer->DealerLogo) value="{{
							$dealer->DealerLogo }}" @endif @endif style="width:55%;" ></td>
					</tr>
					<tr>
						<td style="width: 30%"></td>
						<td></td>
						<td style="width: 70%; font-size: 11px;">Image size should be
							300x50 to look nice!</td>
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

			<table width="90%">
				<tbody>
					<tr>
						<td><b>Deal</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Deal" id="Deal"
							class="form-control"
							@if ($dealer)
					          @if ($dealer->Deal) value="{{ $dealer->Deal }}"
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>URL</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="URL" id="URL"
							class="form-control"
							@if ($dealer)
					          @if ($dealer->URL) value="{{ $dealer->URL }}" @endif
							@endif ></td>
					</tr>
					<tr>
						<td><b>Year</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Year" id="Year"
							class="form-control"
							@if ($dealer)
					          @if ($dealer->Year) value="{{ $dealer->Year }}"
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Make</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Make" id="Make"
							class="form-control"
							@if ($dealer)
					          @if ($dealer->Make) value="{{ $dealer->Make }}"
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Model</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Model" id="Model"
							class="form-control"
							@if ($dealer)
					          @if ($dealer->Model) value="{{ $dealer->Model }}"
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Financed Amount</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="FinancedAmount"
							id="FinancedAmount" class="form-control"
							@if ($dealer)
					          @if ($dealer->FinancedAmount) value="{{
							$dealer->FinancedAmount }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>Base Payment</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="BasePayment"
							id="BasePayment" class="form-control"
							@if ($dealer)
					          @if ($dealer->BasePayment) value="{{
							$dealer->BasePayment }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>APR</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="APR" id="APR"
							class="form-control"
							@if ($dealer)
					          @if ($dealer->APR) value="{{ $dealer->APR }}" @endif
							@endif ></td>
					</tr>
					<tr>
						<td><b>Term</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Term" id="Term"
							class="form-control"
							@if ($dealer)
					          @if ($dealer->Term) value="{{ $dealer->Term }}"
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Down Payment</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="DownPayment"
							id="DownPayment" class="form-control"
							@if ($dealer)
					          @if ($dealer->DownPayment) value="{{
							$dealer->DownPayment }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>Buyer</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Buyer" id="Buyer"
							class="form-control"
							@if ($dealer)
					          @if ($dealer->Buyer) value="{{ $dealer->Buyer }}"
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Co Buyer</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="CoBuyer"
							id="CoBuyer" class="form-control"
							@if ($dealer)
					          @if ($dealer->CoBuyer) value="{{ $dealer->CoBuyer }}"
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Trim</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Trim" id="Trim"
							class="form-control"
							@if ($dealer)
			                  @if ($dealer->Trim) value="{{ $dealer->Trim }}"
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Vin</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Vin" id="Vin"
							class="form-control"
							@if ($dealer)
			                  @if ($dealer->Vin) value="{{ $dealer->Vin }}"
							@endif @endif ></td>
					</tr>
					<tr>
						<td><b>Trade Allowance</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="TradeAllowance"
							id="TradeAllowance" class="form-control"
							@if ($dealer)
			                  @if ($dealer->TradeAllowance) value="{{
							$dealer->TradeAllowance }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>Trade Pay-Off</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="TradePayOff"
							id="TradePayOff" class="form-control"
							@if ($dealer)
			                  @if ($dealer->TradePayOff) value="{{
							$dealer->TradePayOff }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>Beginning Odometer</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="BeginningOdometer"
							id="BeginningOdometer" class="form-control"
							@if ($dealer)
			                  @if ($dealer->BeginningOdometer) value="{{
							$dealer->BeginningOdometer }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>Address 1</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Address1"
							id="Address1" class="form-control"
							@if ($dealer)
			                  @if ($dealer->Address1) value="{{
							$dealer->Address1 }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>Address 2</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Address2"
							id="Address2" class="form-control"
							@if ($dealer)
			                  @if ($dealer->Address2) value="{{
							$dealer->Address2 }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>City</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="City"
							id="City" class="form-control"
							@if ($dealer)
			                  @if ($dealer->City) value="{{
							$dealer->City }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>State</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="State"
							id="State" class="form-control"
							@if ($dealer)
			                  @if ($dealer->State) value="{{
							$dealer->State }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>State Code</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="StateCode"
							id="StateCode" class="form-control"
							@if ($dealer)
			                  @if ($dealer->StateCode) value="{{
							$dealer->StateCode }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>Zip Code</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="ZipCode"
							id="ZipCode" class="form-control"
							@if ($dealer)
			                  @if ($dealer->ZipCode) value="{{
							$dealer->ZipCode }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>Country</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="Country"
							id="Country" class="form-control"
							@if ($dealer)
			                  @if ($dealer->Country) value="{{
							$dealer->Country }}" @endif @endif ></td>
					</tr>
					<tr>
						<td><b>Country Code</b></td>
						<td></td>
						<td style="width: 70%"><input type="text" name="CountryCode"
							id="CountryCode" class="form-control"
							@if ($dealer)
			                  @if ($dealer->CountryCode) value="{{
							$dealer->CountryCode }}" @endif @endif ></td>
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