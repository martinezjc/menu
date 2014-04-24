@extends('masterFinance')

@section('content')

<?php
//$WebService = Session::get('WebServiceInfo');

$UserSessionInfo = Session::get('UserSessionInfo');
$WebService = $deal;

//print_r(Session::get("WebServiceInfo"));
//die();
// if (isset($_COOKIE['User'])) {
// 	echo "User ".$_COOKIE['User'];
// 	echo "<br>";
// 	echo "Pass ".$_COOKIE['Pass'];
// }

?>
<script type="text/javascript">
	// Getting product rates information
	var productRates = eval('productRates = <?php echo json_encode(Session::get("productRates")); ?>');
	
/* load xml file*/
	// XML file
	var url = "js/SelectParams.xml";
	window.objXml;

	// AJAX request
	var xhr = (window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP"));
	xhr.onreadystatechange = XHRhandler;
	xhr.open("GET", url, true);
	xhr.send(null);

	// handle response
	function XHRhandler() {
		if (xhr.readyState == 4) {		
			var objXml = XML2jsobj(xhr.responseXML.documentElement);
			window.objXml = objXml;
			xhr = null;		
		}
	}     
	
/*MB*/ 

  function flip() {  
  	var card = $('#card,#cardBasic, #cardEconomy, #cardPreferred, #cardPremium');

	  $('#flipArrowLeft, #flipArrowLeftBack').on('click', function(){

	  	if(card.hasClass('hoverFooter'))
	  		card.removeClass('hoverFooter');
	  	else
	  		card.addClass('hoverFooter');
		  });

	  $('#flipArrowRight, #flipArrowRightBack').on('click', function(){
	  	if(card.hasClass('hoverFooter'))
	  		card.removeClass('hoverFooter');
	  	else
	  		card.addClass('hoverFooter');
		  });

	  $('#toBottom').on('click', function(){
	  	var target = $('html, body');
	  	target.animate({scrollTop : target.height()},1600);
  			return false;	  		  	 
		});

	  $('#toTop').on('click', function(){
	  	$('html, body').animate({scrollTop : 0},800);
  			return false;	  	
	  	});



	  $('#unZoom').on('click', function(){
	  	var tables = $('#SectionTables');
	  	if(tables.hasClass('UnZoom')){
	  		tables.removeClass('UnZoom');
	  		$('#unZoom').children().removeClass('fa-search-plus');
	  		$('#unZoom').children().addClass('fa-search-minus');	  		
	  	}
	  	else{
	  		tables.addClass('UnZoom');	  			  		
	  		$('#unZoom').children().removeClass('fa-search-minus');
	  		$('#unZoom').children().addClass('fa-search-plus');
	  	}
		});  

  };

  window.addEventListener('DOMContentLoaded', flip, false);
</script>
<!-- Dealer Tax Rate -->
<input type="hidden" id="dealerTaxRate" value="{{$taxRate}}"/>

<!-- Original Deal Values -->
<input type="hidden" id="original-apr" value="{{$WebService->APR}}"/>
<input type="hidden" id="original-term" value="{{$WebService->Term}}"/>
<input type="hidden" id="original-downpayment" value="{{$WebService->DownPayment}}"/>
<input type="hidden" id="original-financedamount" value="{{$WebService->FinancedAmount}}"/>

<!-- By default the second option of the footer template will has the same apr and term of the first option -->
<input type="hidden" id="footer-apr" value="{{$WebService->APR}}"/>
<input type="hidden" id="footer-term" value="{{$WebService->Term + 12}}"/>

<div class="row">
 <div class="row space" id="Top">
	<div  class="col-md-3 space" >
		<div class="basePayment">
			<h4><strong >Base Payment: <label id="BasePaymentHidden"><?php echo number_format((float)$WebService->BasePayment, 2, '.', ''); ?></label> </strong></h4>
			<h4 style="color:#BD362F;"><strong>No Protection</strong></h4>
			<h4  id="FinancedAmountHidden" hidden><?php echo number_format((float)$WebService->FinancedAmount, 2, '.', ''); ?></h4>
		</div>
	</div>								
	<div  class="col-md-3 space" >
		<div class="base">
		
		<table class="tableheaders"  style="width: 100%;">
		@if ($Settings)
        @if ($Settings->DisplayBuyer == 1) 
            <tr>
            <td style="float: left;text-align:right;width:30%;" >
            <h5><strong>Prepared for:</strong></h5>                         
            </td>
            <td style="float:right;text-align:left;padding-left:10px;width:70%;">
            <h5><strong><?php echo $WebService->Buyer; ?></strong></h5>
            </td>
           </tr>
           @endif
         @endif
         @if ($Settings)
           <tr>
           	<td style="float: left;text-align:right;width:30%;" >
           		<h5><strong >Vehicle:</strong></h5>
           	</td>
           	<td style="float:right;text-align:left;padding-left:10px;width:70%;">
           		<h5><strong id="ModelValidate"><?php echo $WebService->Year.$WebService->Make.$WebService->Model != '' ? ($WebService->Year.' '.$WebService->Make.' '.$WebService->Model) : '--';?></strong></h5>
           	</td>
           </tr>
           <tr>
           	<td style="float: left;text-align:right;width:30%;" >
           		<h5><strong >Mileage:</strong></h5>
           	</td>
           	<td style="float:right;text-align:left;padding-left:10px;width:70%;">
           		<h5><strong id="ModelValidate"><?php try {echo round($WebService->BeginningOdometer);} catch (Exception $e) { echo "--";}?></strong></h5>
           	</td>
           </tr>
           @endif
           </table>
		</div>
	</div>
	<div  class="col-md-3 space" >
		<div class="base">
			<input type="hidden" id="AprHidden" value="{{$WebService->APR}}" />
			<input type="hidden" id="TermHidden" value="{{$WebService->Term}}" />

			<table class="tableheaders" style="width: 100%;">  
			@if ($Settings) @if ($Settings->DisplayFinancedAmount == 1)       
            <tr>
            <td style="float: left;text-align:right;width:40%;" >            
            <h5><strong>Amount Financed:</strong></h5>
            </td>
            <td style="float:right;text-align:left;padding-left:10px;width:60%;">            
            <h5><label id="DealFinancedAmountValue" style="font-weight:bold;">$<?php echo number_format($WebService->FinancedAmount, 2); ?></label></h5>
            </td>
           </tr>
           @endif
           @endif
           @if ($Settings)
           @if ($Settings->DisplayAPR == 1)
           <tr>
           	<td style="float: left;text-align:right;width:40%;" >
           <h5><strong >APR: </strong></h5>
           	</td>
           	<td style="float:right;text-align:left;padding-left:10px;width:60%;">
           	<h5><label id="DealerAPRValue" style="font-weight:bold;"> <?php echo $WebService->APR; ?></label></h5>
           	</td>
           </tr>
           @endif
           @endif
           @if ($Settings)
           @if ($Settings->DisplayTerm == 1) 
           <tr>
           	<td style="float: left;text-align:right;width:40%;" >
           <h5><strong >Term: </strong></h5>
           	</td>
           	<td style="float:right;text-align:left;padding-left:10px;width:60%;">
	           <h5><label id="DealerTermValue"> <?php echo $WebService->Term; ?></label></h5>
           	</td>
           </tr>
            @endif
            @endif
        </table>
		</div>
	</div>
	<div  class="col-md-3 space" >
		<div class="base">
		@if ($Settings)
		@if ($Settings->DisplayDownPayment == 1) 
		 <table class="tableheaders" style="width: 100%;">           
            <tr>
            <td style="text-align:center;font-size:12px;" >            
                <strong>Down Payment:</strong>&nbsp;<label id="DealerDownPaymentValue">$<?php try { echo number_format((float)$WebService->DownPayment, 2, '.', ','); } catch (Exception $e) { echo "0.00"; 	} ?></label>
            </td>
           </tr>
           <tr>
            <td style="text-align:center; font-size: 12px;" colspan="2">
            	@if ($WebService->Deal != 0)
              		<a href="#ModalDealSettings" data-dismiss="modal" data-toggle="modal" id="dealSettingsModal" class="">Deal settings</a>
                @endif
            </td>
           </tr>        
        </table>     
        @endif
        @endif
		</div>
	</div>
</div>
<!-- Starts Dealer Settigns Modal -->
<div class="modal fade" id="ModalDealSettings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Deal Settings</h4>
      </div>
      <div class="modal-body row">

        <div class="col-md-6">
        <fieldset>
          <div id="ModalTermDeal" class="form-group">
	              	<label for="TermDeal">Term</label>
					<input type="text" id="TermDeal" class="form-control" style="width:90%;" value="{{ $WebService->Term }}">
              </div>

              <div  id="ModalAPRDeal" class="form-group">
                  <label for="APRDeal">APR</label>
                  <input type="text" id="APRDeal" class="form-control" style="width:90%;" value="{{ $WebService->APR }}">
              </div>
               
              <div  id="ModalDownPaymentDeal" class="form-group">
                  <label for="DownPaymentDeal">Down Payment</label>
                  <input type="text" id="DownPaymentDeal" class="form-control" style="width:90%;" value="<?php try { echo number_format((float)$WebService->DownPayment, 2, '.', ','); } catch (Exception $e) { echo "0.00"; 	} ?>">
              </div> 
          </fieldset>      
          </div>
          
          <div class="col-md-6"> 
          		<div class="form-group">
			       @for ($i = 0; $i < count($Products); $i++)
									 <?php $Product = $Products[$i]; ?>	
									 	<section class="productsDealSettings" id="ProductDeal{{{ $Product->id }}}"  name="{{{ $Product->ProductBaseId }}}">								
                                            <div class="product-header-container">
											<div class="title-productDealSettings">
											<input id="{{{ $Product->id }}}"  type="checkbox" value="{{{ $Product->SellingPrice }}}" RangePricing="<?php try { echo $Product->UseRangePricing;} catch (Exception $e) { echo "0";} ?>" OrderNumber="<?php try { echo $Product->OrderNumber;} catch (Exception $e) { echo "0";	} ?>" name="PremiumDeal" checked><span class="title-productDealSettings-value"> @if ( $Product->DisplayName == '' ) {{ $Product->ProductName }} @else {{{ $Product->DisplayName }}} @endif </span> 
											</div> 
											<div class="description-product" hidden>{{ $Product->ProductDescription }}</div>
                                            </div>
										</section>
										<br/>									
							@endfor
			    </div>	
          </div>

      </div>
       
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="button" id="saveDealSettings" class="btn btn-primary"><i class="fa fa-check-circle"></i> Update</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Ends Dealer Settigns Modal -->
<div class="row space" id="SectionTables">
	<div id="SectionTables">
		<div class="col-md-3 space">
		<div id="1" class="tables">
			<div class="gantry-width-block">
			<div class="gantry-width-spacer">
				<ul class="rt-pricing-table">
					<li class="rt-table-title-premium">Premium</li>								
					<li class="rt-table-description">
					<div class="bodyTable">	
							@for ($i = 0; $i < count($Products); $i++)
									 <?php $Product = $Products[$i]; ?>
									 <?php $Taxable = 0; ?>
									 <?php if ($Product->IsTaxable == 1) {$Taxable = 1;}?>
									 	<section class="products" id="{{{ $Product->id }}}"  name="{{{ $Product->ProductBaseId }}}"  company="{{{ $Product->CompanyId }}}">								
                                            <div class="product-header-container">
											<div class="title-product">
											<input id="{{{ $Product->id }}}"  type="checkbox" tax="{{ $Taxable }}" value="{{{ $Product->SellingPrice }}}" RangePricing="<?php try { echo $Product->UseRangePricing;} catch (Exception $e) { echo "0";} ?>" OrderNumber="<?php try { echo $Product->OrderNumber;} catch (Exception $e) { echo "0";	} ?>" name="Premium" checked><span class="title-product-value"> @if ( $Product->DisplayName == '' ) {{ $Product->ProductName }} @else {{{ $Product->DisplayName }}} @endif </span> 
											</div> 
											<div class="price-product"><span class="price-product-value">${{{ number_format($Product->SellingPrice, 2) }}}</span></div>
											<div class="description-product" hidden>{{ $Product->ProductDescription }}</div>
											<div class="displayname-product">
											@if ( $Product->UsingWebService == 1)
												@if ( $Product->ProductBaseId == 12 )
													@if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years 
												  / {{ $Product->Mileage }},000 Miles 
												  / ${{ $Product->Deductible }} Deductible
												  @if ($Product->ProductDescription) 
												    - {{$Product->ProductDescription}} 
												  @endif 
												@elseif ( $Product->ProductBaseId == 11 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years 
												  		@if ( $Product->Deductible != 0 ) 
												  		/ ${{ $Product->Deductible }} Deductible 
												  		@endif
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@elseif ( $Product->ProductBaseId == 2 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years 
												  		/ {{ $Product->Mileage }},000 Miles 
												  		/ ${{ $Product->Deductible }} Deductible 
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@elseif ( $Product->ProductBaseId == 3 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years 
												  		@if ( $Product->Deductible != 0 ) 
												  		/ ${{ $Product->Deductible }} Deductible 
												  		@endif
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@endif
											@else
												  @if ( $Product->ProductDescription == '' ) 
												    No description 
												  @else 
												    {{{ $Product->ProductDescription }}} 
												  @endif
											@endif
											</div>
                                            </div>
											  <?php 
                                             		$Bullets = explode(',', $Product->Bullets);                      
                                               ?>
											  @foreach ($Bullets as $Bullet)
											  	@if(!(empty($Bullet)))
											  	    <li class="bulletPoint">{{{ $Bullet }}}</li>
											  	@endif
											  @endforeach	

											  <div class="icons-products">
												  @if ($Product->UsingWebService == 0 )
													    	<a style="padding-right:5px;" id="modal1" class="linkmodal1 NotUsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
											      @else
											      	       	<a style="padding-right:5px;" id="modal1" class="linkmodal1 UsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
											      @endif
												  <a style="padding-right:5px;" id="modal2" class="linkmodal2"data-toggle="modal" data-target="#myModal2" ><i class="fa fa-file-text-o" title="Brochure"></i></a>
												  
												<?php
                                             		$ProductsFail = $FailWebservice->failureProductRates;
                                             		$ProductsMatchingFail = $FailWebservice->failMatchingRate;
                                               	?>
                                                  @foreach ($ProductsMatchingFail as $ProductMatchingFail => $matchFail)
                                                  	@if ( $matchFail['ProductId'] == $Product->ProductId)
                                                  	  <a class="messageWarningMatching" data-toggle="tooltip" data-placement="right" title="{{ $matchFail['Message'] }}"><i style="font-size: 14px;" class="fa fa-exclamation-triangle"></i></a>
                                                  	@endif
                                                  @endforeach
												  @foreach ($ProductsFail as $ProductFail => $pf)
												    @if($pf['ProductId'] ==  $Product->ProductId)
												  	<a style="padding-right:5px;" class="messageWarning" data-toggle="tooltip" data-placement="right" title="{{ $pf['Message'] }}"><i style="font-size: 14px;" class="fa fa-exclamation-triangle"></i></a>
												    @endif
												  @endforeach
											  </div>
											  <input type="hidden" class="UseTerm" value="{{{ $Product->UseTerm }}}">
											  <input type="hidden" class="UseType" value="{{{ $Product->UseType }}}">
											  <input type="hidden" class="UseDeductible" value="{{{ $Product->UseDeductible }}}">
												  
											   <input class="ProductSellingPrice" name="${{{ number_format($Product->SellingPrice, 2) }}}" type="text"  hidden>
											   <input class="ProductType" name="{{{ $Product->Type }}}" type="text" hidden>
											   <input class="ProductTerm" name="{{{ $Product->Term }}}" type="text" hidden>
											   <input class="ProductDeductible" name="{{{ $Product->Deductible }}}" type="text" hidden>	
											   <?php if (empty($Product->ProductType)) { $Product->ProductType = "none";} ?>								   
											   <input class="ProductBaseType" name="{{{ $Product->ProductType }}}" type="text" hidden>
											   <?php if (empty($Product->Mileage)) { $Product->Mileage = 0;} ?>
											   <input class="ProductMileage" name="{{{ $Product->Mileage }}}" type="text" hidden>
											   @if($Product->UseTireRotation == 1)
											       <input type="text" class="ProductTireRotation" name="{{{ $Product->TireRotation }}}" hidden>
											   @else
											       <input type="text" class="ProductTireRotation" name="0" hidden>
											   @endif
											   @if($Product->UseInterval == 1)
											       <input type="text" class="ProductInterval" name="{{{ $Product->Interval }}}" hidden>
											   @else
											       <input type="text" class="ProductInterval" name="0" hidden>
											   @endif
											   
											<input type="hidden" class="BrochureImage" value="{{{$Product->BrochureImage}}}" name="{{{$Product->BrochureHeight}}}-{{{$Product->BrochureWidth}}}">											        
										</section>									
							@endfor
					</div>
				</ul>
				<div class="rt-table-price-premium">
					<div class="footerTable">
						<div id="cardPremium" class="flip-container">
							<div class="flipper">
								<div class="front">							
									<span id="flipArrowLeft"><i class="fa fa-caret-left"></i></span>
									<span id="flipArrowRight"><i class="fa fa-caret-right"></i></span>
									<h2><strong>Cost Per Day: <label  class="CostDay" id="CostDayPremium"></label></strong></h2>									
									<h5><strong>Additional Payment: <label class="Additional" id="AdditionalPremium"></label></strong></h5>
									<h5><strong>Monthly Payment: <label class="Monthly" id="MonthlyPremium"></label></strong></h5>							
									<button id="btnPremium" class="readon2">Choose</button>
									
								</div>
								<div class="back">
									<span id="flipArrowLeftBack"><i class="fa fa-caret-left"></i></span>
         							<span id="flipArrowRightBack"><i class="fa fa-caret-right"></i></span>
									<table style="margin:auto;">										
									<tr>
									<td>
									<input type="radio" name="premiumRadio" value="1"> 
									</td>
									<td>
									<div id="PremiumSpanTermId"><span class="SpanTerm"><?php echo $WebService->Term;?></span> Months of <span id="SpanPaymentPremium">0</span> @ <span class="SpanApr">{{number_format($WebService->APR, 2)}}</span>%</div>
									</td>
									</tr>
									<tr>
									<td>
										<input type="radio" name="premiumRadio" value="2"> 
									</td>
									<td>
									<div id="PremiumSpanTerm2Id">
                                        <a style="color: inherit;" id="modal2" plan= "1" class="linkmodal1 optionsFooter" data-toggle="modal" data-target="#ModalOptionsFooter" >
                                            <span class="SpanTerm2"><?php echo ($WebService->Term)+12;?></span> Months of <span id="SpanPaymentPremium2">0</span> @ <span class="SpanApr2">{{number_format($WebService->APR, 2)}}</span>%
									    </a>
									</div>
									</td>
									</tr>
									</table>
									<button id="btnPremiumBack" class="readon2">Choose</button>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			</div>


		</div>
			
		</div>

		<div class="col-md-3 space">
			<div  id="2" class="tables">
			<div class="gantry-width-block">
			<div class="gantry-width-spacer">
				<ul class="rt-pricing-table">
					<li class="rt-table-title-preferred">Preferred</li>				
					<li class="rt-table-description">
					<div class="bodyTable">
							@for( $i = 0; $i < count($Products) - 1; $i++)
										 <?php $Product = $Products[$i]; ?>
										 <?php $Taxable = 0; ?>
									 	 <?php if ($Product->IsTaxable == 1) {$Taxable = 1;}?>
										<section class="products" id="{{{ $Product->id }}}"  name="{{{ $Product->ProductBaseId }}}"   company="{{{ $Product->CompanyId }}}">	
											<div class="product-header-container">
											<div class="title-product">
											<input id="{{{ $Product->id }}}"  type="checkbox"  tax="{{ $Taxable }}" value="{{{ $Product->SellingPrice }}}"  RangePricing="<?php try { echo $Product->UseRangePricing;} catch (Exception $e) { echo "0";} ?>" OrderNumber="<?php try { echo $Product->OrderNumber;} catch (Exception $e) { echo "0";	} ?>" name="Preferred" checked><span class="title-product-value"> @if ( $Product->DisplayName == '' ) {{ $Product->ProductName }} @else {{{ $Product->DisplayName }}} @endif </span>
											</div> 
											<div class="price-product"><span class="price-product-value">${{{ number_format($Product->SellingPrice, 2) }}}</span></div>
											<div class="description-product" hidden>{{ $Product->ProductDescription }}</div>
											<div class="displayname-product">
											@if ( $Product->UsingWebService == 1)
												@if ( $Product->ProductBaseId == 12 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		/ {{ $Product->Mileage }},000 Miles 
												  / ${{ $Product->Deductible }} Deductible
												  @if ($Product->ProductDescription) 
												    - {{$Product->ProductDescription}} 
												  @endif 
												@elseif ( $Product->ProductBaseId == 11 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		@if ( $Product->Deductible != 0 ) 
												  		/ ${{ $Product->Deductible }} Deductible 
												  		@endif
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@elseif ( $Product->ProductBaseId == 2 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		/ {{ $Product->Mileage }},000 Miles 
												  		/ ${{ $Product->Deductible }} Deductible 
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@elseif ( $Product->ProductBaseId == 3 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		@if ( $Product->Deductible != 0 ) 
												  		/ ${{ $Product->Deductible }} Deductible 
												  		@endif
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@endif
											@else
												  @if ( $Product->ProductDescription == '' ) 
												    No description 
												  @else 
												    {{{ $Product->ProductDescription }}} 
												  @endif
											@endif
											</div>
                                            </div>
											<?php 
                                             		$Bullets = explode(',', $Product->Bullets);                                        
                                               ?>
											  @foreach ($Bullets as $Bullet)
											  	@if(!(empty($Bullet)))
											  	    <li class="bulletPoint">{{{ $Bullet }}}</li>
											  	@endif
											  @endforeach									  
											<div class="icons-products">
												  @if ($Product->UsingWebService == 0 )
													    	<a style="padding-right:5px;" id="modal1" class="linkmodal1 NotUsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>											      @else
											      	       	<a style="padding-right:5px;" id="modal1" class="linkmodal1 UsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>											      	       	
											      @endif
												  <a style="padding-right:5px;" id="modal2" class="linkmodal2"data-toggle="modal" data-target="#myModal2" ><i class="fa fa-file-text-o" title="Brochure"></i></a>				
												  <?php
                                             		$ProductsFail = $FailWebservice->failureProductRates;
                                             		$ProductsMatchingFail = $FailWebservice->failMatchingRate;
                                               	?>
                                                  @foreach ($ProductsMatchingFail as $ProductMatchingFail => $matchFail)
                                                  	@if ( $matchFail['ProductId'] == $Product->ProductId)
                                                  	  <a class="messageWarningMatching" data-toggle="tooltip" data-placement="right" title="{{ $matchFail['Message'] }}"><i style="font-size: 14px;" class="fa fa-exclamation-triangle"></i></a>
                                                  	@endif
                                                  @endforeach
												  @foreach ($ProductsFail as $ProductFail => $pf)
												    @if($pf['ProductId'] ==  $Product->ProductId)
												  	<a style="padding-right:5px;" class="messageWarning" data-toggle="tooltip" data-placement="right" title="{{ $pf['Message'] }}"><i style="font-size: 14px;" class="fa fa-exclamation-triangle"></i></a>
												    @endif
												  @endforeach
											  </div>
											  <input type="hidden" class="UseTerm" value="{{{ $Product->UseTerm }}}">
											  <input type="hidden" class="UseType" value="{{{ $Product->UseType }}}">
											  <input type="hidden" class="UseDeductible" value="{{{ $Product->UseDeductible }}}">
												  
											   <input class="ProductSellingPrice" name="${{{ number_format($Product->SellingPrice, 2) }}}" type="text"  hidden>
											   <input class="ProductType" name="{{{ $Product->Type }}}" type="text" hidden>
											   <input class="ProductTerm" name="{{{ $Product->Term }}}" type="text" hidden>
											   <input class="ProductDeductible" name="{{{ $Product->Deductible }}}" type="text" hidden>											   
											   <?php if (empty($Product->ProductType)) { $Product->ProductType = "none";} ?>								   
											   <input class="ProductBaseType" name="{{{ $Product->ProductType }}}" type="text" hidden>
											   <?php if (empty($Product->Mileage)) { $Product->Mileage = 0;} ?>
											   <input class="ProductMileage" name="{{{ $Product->Mileage }}}" type="text" hidden>
											   @if($Product->UseTireRotation == 1)
											       <input type="text" class="ProductTireRotation" name="{{{ $Product->TireRotation }}}" hidden>
											   @else
											       <input type="text" class="ProductTireRotation" name="0" hidden>
											   @endif
											   @if($Product->UseInterval == 1)
											       <input type="text" class="ProductInterval" name="{{{ $Product->Interval }}}" hidden>
											   @else
											       <input type="text" class="ProductInterval" name="0" hidden>
											   @endif
											   <input type="hidden" class="BrochureImage" value="{{{$Product->BrochureImage}}}" name="{{{$Product->BrochureHeight}}}-{{{$Product->BrochureWidth}}}">											        
										</section>          
							@endfor
					</div>				
				</ul>
				<div class="rt-table-price-preferred">
				<div class="footerTable">						
						<div id="cardPreferred" class="flip-container">
							<div class="flipper">
							<div class="front">							
								<span id="flipArrowLeft"><i class="fa fa-caret-left"></i></span>
								<span id="flipArrowRight"><i class="fa fa-caret-right"></i></span>
								<h2><strong>Cost Per Day: <label class="CostDay" id="CostDayPreferred"></label></strong></h2>								
								<h5><strong>Additional Payment: <label class="Additional" id="AdditionalPreferred"></label></strong></h5>
								<h5><strong>Monthly Payment: <label class="Monthly" id="MonthlyPreferred"></label></strong></h5>
								<button id="btnPreferred" class="readon2">Choose</button>
							</div>
							<div class="back">
								<span id="flipArrowLeftBack"><i class="fa fa-caret-left"></i></span>
         						<span id="flipArrowRightBack"><i class="fa fa-caret-right"></i></span>
								<table style="margin:auto;">										
									<tr>
									<td>
										<input type="radio" name="preferredRadio" value="1">
									</td>
									<td>
										<div id="PreferredSpanTermId"><span class="SpanTerm" ><?php echo $WebService->Term;?></span> Months of <span id="SpanPaymentPreferred">0</span> @ <span class="SpanApr">{{number_format($WebService->APR, 2)}}</span>%</div>
									</td>
									</tr>
									<tr>
									<td>
										<input type="radio" name="preferredRadio" value="2">
									</td>
									<td>
										<div id="PreferredSpanTerm2Id">
                                            <a style="color: inherit;" id="modal2" class="linkmodal1 optionsFooter" data-toggle="modal" data-target="#ModalOptionsFooter" >
                                                <span class="SpanTerm2"><?php echo ($WebService->Term)+12;?></span> Months of <span id="SpanPaymentPreferred2">0</span> @ <span class="SpanApr2">{{number_format($WebService->APR, 2)}}</span>%
										    </a>
										</div>										
									</td>
									</tr>
								</table>
								<button id="btnPreferredBack" class="readon2">Choose</button>
							</div>
						</div>	
						</div>
						
					</div>
				</div>
			</div>
			</div>


			</div>
		</div>
		<div class="col-md-3 space">
			<div  id="3" class="tables">


			<div class="gantry-width-block">
			<div class="gantry-width-spacer">
				<ul class="rt-pricing-table">
					<li class="rt-table-title-economy">Economy</li>				
					<li class="rt-table-description">
					<div class="bodyTable">
							@for ($i = 0; $i < count($Products) - 2; $i++)
										<?php $Product = $Products[$i]; ?>
										<?php $Taxable = 0; ?>
									 	<?php if ($Product->IsTaxable == 1) {$Taxable = 1;}?>
										<section class="products"  id="{{{ $Product->id }}}"  name="{{{ $Product->ProductBaseId }}}"   company="{{{ $Product->CompanyId }}}">	
										<div class="product-header-container"><div class="title-product">
											<input id="{{{ $Product->id }}}"  type="checkbox"  tax="{{ $Taxable }}" value="{{{ $Product->SellingPrice }}}"  RangePricing="<?php try { echo $Product->UseRangePricing;} catch (Exception $e) { echo "0";} ?>" OrderNumber="<?php try { echo $Product->OrderNumber;} catch (Exception $e) { echo "0";	} ?>" name="Economy" checked><span class="title-product-value"> @if ( $Product->DisplayName == '' ) {{ $Product->ProductName }} @else {{{ $Product->DisplayName }}} @endif </span>
											</div> 
											<div class="price-product"><span class="price-product-value">${{{ number_format($Product->SellingPrice, 2) }}}</span></div>
											<div class="description-product" hidden>{{ $Product->ProductDescription }}</div>
											<div class="displayname-product">
											@if ( $Product->UsingWebService == 1)
												@if ( $Product->ProductBaseId == 12 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		/ {{ $Product->Mileage }},000 Miles 
												  / ${{ $Product->Deductible }} Deductible
												  @if ($Product->ProductDescription) 
												    - {{$Product->ProductDescription}} 
												  @endif 
												@elseif ( $Product->ProductBaseId == 11 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		@if ( $Product->Deductible != 0 ) 
												  		/ ${{ $Product->Deductible }} Deductible 
												  		@endif
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@elseif ( $Product->ProductBaseId == 2 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		/ {{ $Product->Mileage }},000 Miles 
												  		/ ${{ $Product->Deductible }} Deductible 
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@elseif ( $Product->ProductBaseId == 3 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		@if ( $Product->Deductible != 0 ) 
												  		/ ${{ $Product->Deductible }} Deductible 
												  		@endif
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@endif
											@else
												  @if ( $Product->ProductDescription == '' ) 
												    No description 
												  @else 
												    {{{ $Product->ProductDescription }}} 
												  @endif
											@endif
											</div>
                                            </div>
											<?php 
                                             		$Bullets = explode(',', $Product->Bullets);                                        
                                               ?>
											  @foreach ($Bullets as $Bullet)
											  	@if(!(empty($Bullet)))
											  	    <li class="bulletPoint">{{{ $Bullet }}}</li>
											  	@endif
											  @endforeach									  
											<div class="icons-products">
												  @if ($Product->UsingWebService == 0 )
													    	<a style="padding-right:5px;" id="modal1" class="linkmodal1 NotUsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
											      @else
											      	       	<a style="padding-right:5px;" id="modal1" class="linkmodal1 UsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
											      @endif
												  <a style="padding-right:5px;" id="modal2" class="linkmodal2"data-toggle="modal" data-target="#myModal2" ><i class="fa fa-file-text-o" title="Brochure"></i></a>
												  <?php
                                             		$ProductsFail = $FailWebservice->failureProductRates;
                                             		$ProductsMatchingFail = $FailWebservice->failMatchingRate;
                                               	?>
                                                  @foreach ($ProductsMatchingFail as $ProductMatchingFail => $matchFail)
                                                  	@if ( $matchFail['ProductId'] == $Product->ProductId)
                                                  	  <a class="messageWarningMatching" data-toggle="tooltip" data-placement="right" title="{{ $matchFail['Message'] }}"><i style="font-size: 14px;" class="fa fa-exclamation-triangle"></i></a>
                                                  	@endif
                                                  @endforeach
												  @foreach ($ProductsFail as $ProductFail => $pf)
												    @if($pf['ProductId'] ==  $Product->ProductId)
												  	<a style="padding-right:5px;" class="messageWarning" data-toggle="tooltip" data-placement="right" title="{{ $pf['Message'] }}"><i style="font-size: 14px;" class="fa fa-exclamation-triangle"></i></a>
												    @endif
												  @endforeach
											  </div>
											  <input type="hidden" class="UseTerm" value="{{{ $Product->UseTerm }}}">
											  <input type="hidden" class="UseType" value="{{{ $Product->UseType }}}">
											  <input type="hidden" class="UseDeductible" value="{{{ $Product->UseDeductible }}}">
												  
											   <input class="ProductSellingPrice" name="${{{ number_format($Product->SellingPrice, 2) }}}" type="text"  hidden>
											   <input class="ProductType" name="{{{ $Product->Type }}}" type="text" hidden>
											   <input class="ProductTerm" name="{{{ $Product->Term }}}" type="text" hidden>
											   <input class="ProductDeductible" name="{{{ $Product->Deductible }}}" type="text" hidden>											   
											   <?php if (empty($Product->ProductType)) { $Product->ProductType = "none";} ?>								   
											   <input class="ProductBaseType" name="{{{ $Product->ProductType }}}" type="text" hidden>
											   <?php if (empty($Product->Mileage)) { $Product->Mileage = 0;} ?>
											   <input class="ProductMileage" name="{{{ $Product->Mileage }}}" type="text" hidden>
											   @if($Product->UseTireRotation == 1)
											       <input type="text" class="ProductTireRotation" name="{{{ $Product->TireRotation }}}" hidden>
											   @else
											       <input type="text" class="ProductTireRotation" name="0" hidden>
											   @endif
											   @if($Product->UseInterval == 1)
											       <input type="text" class="ProductInterval" name="{{{ $Product->Interval }}}" hidden>
											   @else
											       <input type="text" class="ProductInterval" name="0" hidden>
											   @endif
											   <input type="hidden" class="BrochureImage" value="{{{$Product->BrochureImage}}}" name="{{{$Product->BrochureHeight}}}-{{{$Product->BrochureWidth}}}">											        
										</section>          
							@endfor
					</div>				
				</ul>
				<div class="rt-table-price-economy">					
					<div class="footerTable">						
						<div id="cardEconomy" class="flip-container">
							<div class="flipper">
							<div class="front">							
								<span id="flipArrowLeft"><i class="fa fa-caret-left"></i></span>
								<span id="flipArrowRight"><i class="fa fa-caret-right"></i></span>
								<h2><strong>Cost Per Day: <label  class="CostDay" id="CostDayEconomy"></label></strong></h2>								
								<h5><strong>Additional Payment: <label class="Additional" id="AdditionalEconomy"></label></strong></h5>
								<h5><strong>Monthly Payment: <label class="Monthly" id="MonthlyEconomy"></label></strong></h5>								
								<button id="btnEconomy" class="readon2">Choose</button>	
							</div>
							<div class="back">
								<span id="flipArrowLeftBack"><i class="fa fa-caret-left"></i></span>
         						<span id="flipArrowRightBack"><i class="fa fa-caret-right"></i></span>
								<table style="margin:auto;">										
									<tr>
									<td>
										<input type="radio" name="economyRadio" value="1"> 
									</td>
									<td>
										<div id="EconomySpanTermId"><span class="SpanTerm" ><?php echo $WebService->Term;?></span> Months of <span id="SpanPaymentEconomy">0</span> @ <span class="SpanApr">{{number_format($WebService->APR, 2)}}</span>%</div>
									</td>
									</tr>
									<tr>
									<td>
										<input type="radio" name="economyRadio" value="2"> 
									</td>
									<td>
										<div id="EconomySpanTerm2Id">
                                            <a style="color: inherit;" id="modal2" class="linkmodal1 optionsFooter" data-toggle="modal" data-target="#ModalOptionsFooter" >
                                                <span class="SpanTerm2"><?php echo ($WebService->Term)+12;?></span> Months of <span id="SpanPaymentEconomy2">0</span> @ <span class="SpanApr2">{{number_format($WebService->APR, 2)}}</span>% 
										    </a>
										</div>
									</td>
								</table>
								<button id="btnEconomyBack" class="readon2">Choose</button>	
							</div>
						</div>	
						</div>					
					</div>
				</div>
			</div>
			</div>


			</div>
		</div>
		<div class="col-md-3 space">
			<div id="4"  class="tables" height="100%">


			<div class="gantry-width-block">
			<div class="gantry-width-spacer">
				<ul class="rt-pricing-table">
					<li class="rt-table-title-basic">Basic</li>					
					<li class="rt-table-description">
					<div class="bodyTable">
							@for ($i = 0; $i < count($Products) - 3; $i++)
										<?php $Product = $Products[$i]; ?>
										<?php $Taxable = 0; ?>
									 	<?php if ($Product->IsTaxable == 1) {$Taxable = 1;}?>
										<section id="{{{ $Product->id }}}" class="products"  name="{{{ $Product->ProductBaseId }}}"   company="{{{ $Product->CompanyId }}}">	
                                            <div class="product-header-container">
										<div class="title-product">
											<input id="{{{ $Product->id }}}"  type="checkbox"  tax="{{ $Taxable }}" value="{{{ $Product->SellingPrice }}}" RangePricing="<?php try { echo $Product->UseRangePricing;} catch (Exception $e) { echo "0";} ?>" OrderNumber="<?php try { echo $Product->OrderNumber;} catch (Exception $e) { echo "0";	} ?>" name="Basic" checked> <span class="title-product-value">  @if ( $Product->DisplayName == '' ) {{ $Product->ProductName }} @else {{{ $Product->DisplayName }}} @endif </span>
											</div> 
											<div class="price-product"><span class="price-product-value">${{{ number_format($Product->SellingPrice, 2) }}}</span></div>
											<div class="description-product" hidden>{{ $Product->ProductDescription }}</div>		
											<div class="displayname-product">
											@if ( $Product->UsingWebService == 1)
												@if ( $Product->ProductBaseId == 12 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		/ {{ $Product->Mileage }},000 Miles 
												  / ${{ $Product->Deductible }} Deductible
												  @if ($Product->ProductDescription) 
												    - {{$Product->ProductDescription}} 
												  @endif 
												@elseif ( $Product->ProductBaseId == 11 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		@if ( $Product->Deductible != 0 ) 
												  		/ ${{ $Product->Deductible }} Deductible 
												  		@endif
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@elseif ( $Product->ProductBaseId == 2 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		/ {{ $Product->Mileage }},000 Miles 
												  		/ ${{ $Product->Deductible }} Deductible 
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@elseif ( $Product->ProductBaseId == 3 ) 
												  @if(empty($Product->Years)) 
												  		{{ $Product->Term / 12 }} 
												  	@else
												  		{{$Product->Years}}
												  	@endif
												  		Years  
												  		@if ( $Product->Deductible != 0 ) 
												  		/ ${{ $Product->Deductible }} Deductible 
												  		@endif
												  @if ( $Product->ProductDescription ) 
												    - {{ $Product->ProductDescription }} 
												  @endif
												@endif
											@else
												  @if ( $Product->ProductDescription == '' ) 
												    No description 
												  @else 
												    {{{ $Product->ProductDescription }}} 
												  @endif
											@endif
											</div>
                                                </div>
	                                             <?php 
	                                             		$Bullets = explode(',', $Product->Bullets);                                        
	                                               ?>
												  @foreach ($Bullets as $Bullet)
												  	@if(!(empty($Bullet)))
												  	    <li class="bulletPoint">{{{ $Bullet }}}</li>
												  	@endif
												  @endforeach										  
											  <div class="icons-products">
												  @if ($Product->UsingWebService == 0 )
													    	<a style="padding-right:5px;" id="modal1" class="linkmodal1 NotUsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
											      @else
											      	       	<a style="padding-right:5px;" id="modal1" class="linkmodal1 UsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
											      @endif
												  <a style="padding-right:5px;" id="modal2" class="linkmodal2"data-toggle="modal" data-target="#myModal2" ><i class="fa fa-file-text-o" title="Brochure"></i></a>
												  <?php
                                             		$ProductsFail = $FailWebservice->failureProductRates;
                                             		$ProductsMatchingFail = $FailWebservice->failMatchingRate;
                                               	?>
                                                  @foreach ($ProductsMatchingFail as $ProductMatchingFail => $matchFail)
                                                  	@if ( $matchFail['ProductId'] == $Product->ProductId)
                                                  	  <a class="messageWarningMatching" data-toggle="tooltip" data-placement="right" title="{{ $matchFail['Message'] }}"><i style="font-size: 14px;" class="fa fa-exclamation-triangle"></i></a>
                                                  	@endif
                                                  @endforeach
												  @foreach ($ProductsFail as $ProductFail => $pf)
												    @if($pf['ProductId'] ==  $Product->ProductId)
												  	<a style="padding-right:5px;" class="messageWarning" data-toggle="tooltip" data-placement="right" title="{{ $pf['Message'] }}"><i style="font-size: 14px;" class="fa fa-exclamation-triangle"></i></a>
												    @endif
												  @endforeach
											  </div>
											  <input type="hidden" class="UseTerm" value="{{{ $Product->UseTerm }}}">
											  <input type="hidden" class="UseType" value="{{{ $Product->UseType }}}">
											  <input type="hidden" class="UseDeductible" value="{{{ $Product->UseDeductible }}}">
												  
											   <input class="ProductSellingPrice" name="${{{ number_format($Product->SellingPrice, 2) }}}" type="text"  hidden>
											   <input class="ProductType" name="{{{ $Product->Type }}}" type="text" hidden>
											   <input class="ProductTerm" name="{{{ $Product->Term }}}" type="text" hidden>
											   <input class="ProductDeductible" name="{{{ $Product->Deductible }}}" type="text" hidden>											   
											   <?php if (empty($Product->ProductType)) { $Product->ProductType = "none";} ?>								   
											   <input class="ProductBaseType" name="{{{ $Product->ProductType }}}" type="text" hidden>
											   <?php if (empty($Product->Mileage)) { $Product->Mileage = 0;} ?>
											   <input class="ProductMileage" name="{{{ $Product->Mileage }}}" type="text" hidden>
											   @if($Product->UseTireRotation == 1)
											       <input type="text" class="ProductTireRotation" name="{{{ $Product->TireRotation }}}" hidden>
											   @else
											       <input type="text" class="ProductTireRotation" name="0" hidden>
											   @endif
											   @if($Product->UseInterval == 1)
											       <input type="text" class="ProductInterval" name="{{{ $Product->Interval }}}" hidden>
											   @else
											       <input type="text" class="ProductInterval" name="0" hidden>
											   @endif
											   <input type="hidden" class="BrochureImage" value="{{{$Product->BrochureImage}}}" name="{{{$Product->BrochureHeight}}}-{{{$Product->BrochureWidth}}}">											        
										</section>          
							@endfor
					</div>		
							
				</ul>
				<div class="rt-table-price-basic">				
					<div class="footerTable">						
						<div id="cardBasic" class="flip-container">
							<div class="flipper">
							<div class="front">							
								<span id="flipArrowLeft"><i class="fa fa-caret-left"></i></span>
								<span id="flipArrowRight"><i class="fa fa-caret-right"></i></span>
								<h2><strong>Cost Per Day: <label class="CostDay" id="CostDayBasic"></label></strong></h2>								
								<h5><strong>Additional Payment: <label class="Additional"  id="AdditionalBasic"></label></strong></h5>
								<h5><strong>Monthly Payment: <label class="Monthly"  id="MonthlyBasic"></label></strong></h5>
								<button id="btnBasic" class="readon2">Choose</button>
							</div>
							<div class="back">
								<span id="flipArrowLeftBack"><i class="fa fa-caret-left"></i></span>
         						<span id="flipArrowRightBack"><i class="fa fa-caret-right"></i></span>
								<table style="margin:auto;">										
									<tr>
									<td>
										<input type="radio" name="basicRadio" value="1">
									</td>
									<td>
										<div id="BasicSpanTermId"><span class="SpanTerm" ><?php echo $WebService->Term;?></span> Months of <span id="SpanPaymentBasic">0</span> @ <span class="SpanApr">{{number_format($WebService->APR, 2)}}</span>%</div>
									</td>
									</tr>
									<tr>
									<td>
										<input type="radio" name="basicRadio" value="2">
									</td>
									<td>
										<div id="BasicSpanTerm2Id">
                                            <a style="color: inherit;" id="modal2" class="linkmodal1 optionsFooter" data-toggle="modal" data-target="#ModalOptionsFooter" >
                                                <span class="SpanTerm2"><?php echo ($WebService->Term)+12;?></span> Months of <span id="SpanPaymentBasic2">0</span> @ <span class="SpanApr2">{{number_format($WebService->APR, 2)}}</span>%
										    </a>
										</div>
									</td>
									</tr>
								</table>
								<button id="btnBasicBack" class="readon2">Choose</button>
							</div>
						</div>	
						</div>
					</div>
				</div>
			</div>
			</div>

			</div>
		</div>
	</div>
</div>  <!--   END CODE MODESTO -->

<!-- Start Modal Footer Options -->
<div class="modal fade" id="ModalOptionsFooter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Settings</h4>
      </div>
      <div class="modal-body row">
        
        <div class="col-md-6">
        <fieldset>
          <div id="ModalTermFooter" class="form-group">
	              	<label for="TermFooter">Term</label>
					<input type="text" id="TermFooter" class="form-control" style="width:90%;" value="{{ $WebService->Term }}">
              </div>

              <div  id="ModalAPRFooter" class="form-group">
                  <label for="APRFooter">APR</label>
                  <input type="text" id="APRFooter" class="form-control" style="width:90%;" value="{{ $WebService->APR }}">
              </div>
          </fieldset>      
          </div>  
      </div>
       
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="button" id="saveFooterSettings" class="btn btn-primary"><i class="fa fa-check-circle"></i> Update</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- End Modal Footer Options -->

<div class="row" style="margin-top:1%; margin-bottom:1%">
	<div class="col-md-3 space">		
	</div>
	<div class="col-md-6 space">
		
	</div>
	<div class="col-md-3 space">
	<form action="disclosure" method:"GET">
	  <input name="Plan" id="HiddenId" type="text" hidden>
	  <input name="OrderAccepted" id="HiddenOrderAccepted" type="text" hidden>
	  <input name="OrderRejected" id="HiddenOrderRejected" type="text" hidden>
	  <input name="Accepted" id="HiddenAccepted" type="text" hidden>
	  <input name="Rejected" id="HiddenRejected" type="text" hidden>

	  <input name="AcceptedType" id="HiddenTypeAccepted" type="text" hidden>
	  <input name="RejectedType" id="HiddenTypeRejected" type="text" hidden>
	  <input name="AcceptedTerm" id="HiddenTermAccepted" type="text" hidden>
	  <input name="RejectedTerm" id="HiddenTermRejected" type="text" hidden>
	  <input name="AcceptedDeductible" id="HiddenDeductibleAccepted" type="text" hidden>
	  <input name="RejectedDeductible" id="HiddenDeductibleRejected" type="text" hidden>

	  <input name="AcceptedMileage" id="HiddenMileageAccepted" type="text" hidden>
	  <input name="RejectedMileage" id="HiddenMileageRejected" type="text" hidden>

	  <input name="AcceptedTireRotation" id="HiddenTireRotationAccepted" type="hidden" >
	  <input name="RejectedTireRotation" id="HiddenTireRotationRejected" type="hidden" >

	  <input name="AcceptedInterval" id="HiddenIntervalAccepted" type="hidden" >
	  <input name="RejectedInterval" id="HiddenIntervalRejected" type="hidden" >
       
      <input name="AcceptedDescription" id="HiddenDescriptionAccepted" type="hidden" >
      <input name="RejectedDescription" id="HiddenDescriptionRejected" type="hidden" >
      
      <input name="AcceptedPrice" id="HiddenAcceptedPrice" type="text" hidden> 
      <input name="RejectedPrice" id="HiddenRejectedPrice" type="text" hidden>
      <input name="CostPerDayFinance" id="CostPerDayFinance" type="text" hidden>
      <input name="AdditionalPaymentFinance" id="AdditionalPaymentFinance" type="text" hidden>
      <input name="MonthlyPaymentFinance" id="MonthlyPaymentFinance" type="text" hidden>		
      
      <input name="APR" id="HiddenAPR" type="hidden" />
      <input name="Term" id="HiddenTerm" type="hidden" />
      <input name="DownPayment" id="HiddenDownPayment" type="hidden"/>

      <input name="ProtectiveVsc" id="HiddenProtectiveVsc" value="0,0,0,0" type="hidden"/>

      <input name="FailureProductsRates" id="FailureProductsRates" value="{{{  json_encode($FailWebservice->failureProductRates) }}}" type="hidden">

      
		<button id="ButtonNext" type="submit" class="btn btn-lg btn-primary pull-right" disabled style="padding-left:15%; padding-right:15%;margin-bottom:25px;">
	               Next  <i class="fa fa-arrow-right"></i>
		</button>

	</form>
	</div>
</div>    

<!-- Starts modal new product -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Options</h4>
      </div>
      <div class="modal-body row">

        <div class="col-md-6">
        <fieldset>
          <div id="ModalPrice" class="form-group">
	              	<label for="Price">Price</label>
					<input type="text" id="PriceProduct" class="form-control" style="width:90%;">
              </div>

              <div  id="ModalType" class="form-group">
                  <label for="Type">Type</label>
                  <select name="Type" id="TypeFinance" class="form-control" style="width:90%;">
                  </select>
               </div>

              <div  id="ModalTerm"  class="form-group">
                  <label for="displayName">Term</label>
                  <!-- <input id="displayName" type="text"class="form-control" class="form-control" style="width:40%"> -->
                  <select name="Term" id="TermFinance" class="form-control" style="width:90%;">
                   </select>  
                  <input type="text" id="TermFinance2" class="form-control" style="width:90%;" value="{{{$WebService->Term}}}">  
                </div>

                <div  id="ModalMileage"  class="form-group">
                  <label for="displayName">Mileage</label>
                  <!-- <input id="displayName" type="text"class="form-control" class="form-control" style="width:40%"> -->
                  <select name="Mileage" id="MileageFinance" class="form-control" style="width:90%;">
                   </select>               
                </div>

                <div id="ModalTireRotation" class="form-group">
                	<label for="TireRotation">Tire Rotation</label>
                	<select name="TireRotation" id="TireRotation" class="form-control" style="width:90%;">
                	</select>
                </div>

                <div id="ModalInterval" class="form-group">
                	<label for="Interval">Interval</label>
                	<select name="Interval" id="Interval" class="form-control" style="width:90%;">
                	</select>
                </div>
                
                <div id="ModalDeductible" class="form-group">
                  <label for="Deductible">Deductible</label>
               	  <select id="DeductibleFinance" name="Deductible" class="form-control"  style="width:90%;" >
               	  </select>
		 		</div> 

          </fieldset>      
          </div>  
          <div class="col-md-6"> 
          		<div class="form-group">
			       <input type="checkbox" id="ApplyChanges" name="ApplyChanges" ><label for="checkbox" style="margin-left:2%;"> Copy to all menu columns</label>
			    </div>	
			    
			   <div class="Protective">
					   	<div class="form-group" style="margin-top:20%;">
		                 <input type="checkbox" id="BusinessUse" name="protective" ><label for="checkbox" style="margin-left:2%;"> Business Use</label>
		              </div>
		              <div class="form-group">
		                 <input type="checkbox" id="ConversionPackage" name="protective" ><label for="checkbox" style="margin-left:2%;"> Conversion Package</label>
		              </div>
		              <div class="form-group">
		                 <input type="checkbox" id="ElectronicPackage" name="protective" ><label for="checkbox" style="margin-left:2%;"> Electronic Package</label>
		              </div>
		              <div class="form-group">
		                 <input type="checkbox" id="MobilityEquipmentPackage" name="protective" ><label for="checkbox" style="margin-left:2%;"> Mobility Equipment Package</label>
		              </div> 
			   </div>
                         
          </div>     
      </div>

      <div class="modal-footer">
        <button type="button" id="saveModal1" class="btn btn-primary pull-left"><i class="fa fa-check-circle"></i> Update Pricing</button>
        <button id="ButtonReset" class="btn btn-warning "  style="margin-left:5px;"><i class="fa fa-refresh"></i><span> Reset values</span></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>               
      </div>
    </div>
  </div>
</div>
</div>
<!-- End modal for manual entry --> 

<!-- Starts modal new product -->
<div class="modal fade modal-lg" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Brochure</h4>
      </div>
      <div  class="modal-body row">
      	<div id="ModalContainer" style="overflow:hidden;">
      		<?php 
			$path = "/menuapp/public/uploads/brochure/ ";
      			$path = rtrim($path);
      		 ?>
			<img id="ImgModal2" src="" name="<?php echo $path; ?>" class="img-responsive img-rounded" alt="Responsive image">

			<object class="videoPlayer videoPlayer1" data="" width="100%" height="100%">
			    <embed class="videoPlayer videoPlayer2" src="" width="100%" height="100%">
			</object> 
      	</div>      		
      </div>
      <label id="myModal2Label"></label>       
      <div class="modal-footer">
         <button id="CloseModal" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>               
      </div>
    </div>
  </div>
</div>
</div>
<!-- End modal for manual entry --> 
<input type="hidden" id="ValidatePage" value="0">
<input type="hidden" id="FailWebService" value="{{{ $FailWebservice->flag }}}" message="{{ $FailWebservice->message}}">
<!--<input type="hidden" id="FailureProductsRates" value="{{{  json_encode(array('items' => $FailWebservice->failureProductRates), JSON_FORCE_OBJECT) }}}">-->
 

@stop
@section('scripts')
{{ HTML::script('js/menu.js'); }}
@stop
