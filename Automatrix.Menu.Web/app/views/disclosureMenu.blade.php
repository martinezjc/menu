@extends('masterFinance')

@section('content')

<?php

// if(!isset($_SESSION)) 
// { 
//     session_start(); 
// } 
    
$WebService = Session::get('WebServiceInfo');
$UserSessionInfo = Session::get('UserSessionInfo');
$AcceptedArray = explode(",",$Accepted);
$RejectedArray = explode(",",$Rejected);
$TypeAcceptedArray = explode(",",$AcceptedType);
$TypeRejectedArray = explode(",",$RejectedType);
$TermAcceptedArray = explode(",",$AcceptedTerm);
$TermRejectedArray = explode(",",$RejectedTerm);
$DeductibleAcceptedArray = explode(",",$AcceptedDeductible);
$DeductibleRejectedArray = explode(",",$RejectedDeductible);
$OrderAcceptedArray = explode(",",$OrderAccepted);
$OrderRejectedArray = explode(",",$OrderRejected);
$AcceptedArrayPrice = explode(",",$AcceptedPrice);
$RejectedArrayPrice = explode(",",$RejectedPrice);
$MonthlyPaymentFinance = Input::get('MonthlyPaymentFinance');
$AdditionalPaymentFinance = Input::get('AdditionalPaymentFinance');
$CostPerDayFinance = Input::get('CostPerDayFinance');

$MileageAcceptedArray = explode(",",$AcceptedMileage);
$MileageRejectedArray = explode(",",$RejectedMileage);

$TireRotationAcceptedArray = explode(",",$acceptedTireRotation);
$TireRotationRejectedArray = explode(",",$rejectedTireRotation);

$IntervalAcceptedArray = explode(",",$acceptedInterval);
$IntervalRejectedArray = explode(",",$rejectedInterval);

$DescriptionAcceptedArray = explode(",",$acceptedDescription);
$DescriptionRejectedArray = explode(",",$rejectedDescription);

// print_r($Products);
// echo "<br>";
// print_r($MileageAcceptedArray);
//     echo "<br>";
//     die();
   

if (is_null($UserSessionInfo)) {
?>
<script>
    window.location.href = 'login';
</script>
<?php
    exit();
}
?>

<script type="text/javascript">

  // Getting product rates information
    var productRates = eval('productRates = <?php echo json_encode(Session::get("productRates")); ?>');
    //var countproductRates = Object.keys(productRates.product21).length;

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
   
  function utilForPage()
  {
    $('#deal-form').hide();

    $('#toBottom').on('click', function(){
        var target = $('html, body');
        target.animate({scrollTop : target.height()},1600);
            return false;                
        });

      $('#toTop').on('click', function(){
        $('html, body').animate({scrollTop : 0},800);
            return false;       
        });
  }

  window.addEventListener('DOMContentLoaded', utilForPage, false);
</script>

<!-- Dealer Tax Rate -->
<input type="hidden" id="dealerTaxRate" value="{{$taxRate}}"/>

<!-- By default the second option of the footer template will has the same apr and term of the first option -->
<input type="hidden" id="footer-apr" value="{{$apr}}"/>
<input type="hidden" id="footer-term" value="{{$term}}"/>
<input type="hidden" id="DownPaymentDeal" value="{{$downPayment}}"/>
<input type="hidden" id="original-downpayment" value="{{$WebService->DownPayment}}"/>
<input type="hidden" id="original-financedamount" value="{{$WebService->FinancedAmount}}"/>

<div class="row" id="Top">
    <div class="col-md-3 space">
        <div class="base">
        <div class="basePayment">
        <table class="tableheaders" style="width: 100%;">           
            <tr>
            <td style="float: left;text-align:right;width:40%;" >            
           <h4><strong>Buyer:</strong></h4>
            </td>
            <td style="float:right;text-align:left;padding-left:10px;width:60%;">            
           <h4 class="largeText"><strong> <?php echo $WebService->Buyer; ?></strong></h4>
            </td>
           </tr>
           <tr>
            <td style="float: left;text-align:right;width:40%;" >
           <h4><strong>Co Buyer: </strong></h4>
            </td>
            <td style="float:right;text-align:left;padding-left:10px;width:60%;">
            <h4><strong><?php echo $WebService->CoBuyer; ?></strong></h4>
            </td>
           </tr>
        </table>
        </div>
        </div>
    </div>
    <div class="col-md-3 space">
        <div class="base">
        <table class="tableheaders"  style="width: 100%;">
            <tr>
            <td style="float: left;text-align:right;width:30%;" >
            <h5><strong>Prepared for:</strong></h5>                         
            </td>
            <td style="float:right;text-align:left;padding-left:10px;width:70%;">
            <h5 class="largeText"><strong><?php echo $WebService->Buyer; ?></strong></h5>
            </td>
           </tr>
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
        </table>
        </div>
    </div>
    <div class="col-md-3 space">
        <div class="base">
        <label id="BasePaymentHidden" hidden><?php echo number_format((float)$WebService->BasePayment, 2, '.', ''); ?></label>
        <h4  id="FinancedAmountHidden" hidden><?php echo number_format((float)$WebService->FinancedAmount, 2, '.', ''); ?></h4>
        <input id="AprHidden" type="hidden" value="{{$apr}}"/>
        <input id="TermHidden" type="hidden"value="{{$term}}" />
        <table class="tableheaders" style="width: 100%;">           
            <tr>
            <td style="float: left;text-align:right;width:40%;" >            
            <h5><strong>Amount Financed:</strong></h5>
            </td>
            <td style="float:right;text-align:left;padding-left:10px;width:60%;">            
            <h5><strong>$<?php echo number_format((float)(($WebService->FinancedAmount + $WebService->DownPayment) - $downPayment), 2, '.', ','); ?></strong></h5>
            </td>
           </tr>
           <tr>
            <td style="float: left;text-align:right;width:40%;" >
                <h5><strong>APR:</strong></h5>
            </td>
            <td style="float:right;text-align:left;padding-left:10px;width:60%;">
                <h5><strong><?php echo $apr; ?></strong></h5>
            </td>
           </tr>
            <tr>
            <td style="float: left;text-align:right;width:40%;" >
                <h5><strong>Term:</strong></h5>
            </td>
            <td style="float:right;text-align:left;padding-left:10px;width:60%;">
                <h5><strong><?php echo $term; ?></strong></h5>
            </td>
           </tr>
        </table>
        </div>
    </div>
    <div class="col-md-3 space">
        <div>
        <table class="tableheaders" style="width: 100%;">           
            <tr>
            <td style="float: left;text-align:right;width:40%;" >            
            <h5><strong>Down Payment:</strong></h5>
            </td>
            <td style="float:right;text-align:left;padding-left:10px;width:60%;">            
            <h5><strong>$<?php echo number_format((float)$downPayment, 2, '.', ','); ?></strong></h5>
            </td>
           </tr>          
        </table>            
        </div>
    </div>
</div>
<div class="row" id="SectionTables">
<table class="disclosureTable">
    <tr>
      <td></td>
    <td class="disclosureTDLeft">
            <div class="Acepted">
                <div class="gantry-width-block">
                    <div class="gantry-width-spacer">
                        <ul class="rt-pricing-table3">
                            <li class="rt-table-title-productsAccepted">Products Accepted</li>
                            <li class="rt-table-description">
                                <div id="AcceptedTable" class="bodyTable">

                                    <?php  $j=0; $WebIndex = 0;?>
                                    @for( $i = 0; $i < count($Products); $i++)
                                     <?php $Product = $Products[$i]; ?>
                                    @if($Product->UseRangePricing == 1)
                                         <?php $Product->UsingWebService = 1; ?> 
                                    @endif
                                    @if(in_array($Product->id,$AcceptedArray))
                                    <?php $Taxable = 0; ?>
                                    <?php if ($Product->IsTaxable == 1) {$Taxable = 1;}?>
                                    <section class="products" id="{{{ $Product->id }}}" name="{{{ $Product->ProductBaseId }}}"  company="{{{ $Product->CompanyId }}}">
                                        <div  class="product-header-container">
                                            <div class="title-product">
                                                <input type="checkbox" value="<?php echo $AcceptedArrayPrice[$j]; ?>"   tax="{{ $Taxable }}" name="Accepted" RangePricing="<?php try { echo $Product->UseRangePricing;} catch (Exception $e) { echo "0";} ?>" OrderNumber = "<?php echo $OrderAcceptedArray[$j]; ?>" checked>
                                                {{{ $Product->DisplayName }}}
                                            </div>

                                            <div hidden class="price-product"><?php /*echo number_format((float)$AcceptedArrayPrice[$j], 2, '.', '');*/ ?></div>
                                         <div class="displayname-product"><?php try { echo str_replace('%', ',', $DescriptionAcceptedArray[$WebIndex]); } catch (Exception $e) { echo "";} ?></div>
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
                                                  @if ($Product->UsingWebService == 0)
                                                            <a style="padding-right:5px;" id="modal1" class="linkmodal1 NotUsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
                                                            
                                                  @else
                                                            <a style="padding-right:5px;" id="modal1" class="linkmodal1 UsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
                                                            
                                                  @endif
                                                  <input type="hidden" class="UseTerm" value="{{{ $Product->UseTerm }}}">
                                                  <input type="hidden" class="UseType" value="{{{ $Product->UseType }}}">
                                                  <input type="hidden" class="UseDeductible" value="{{{ $Product->UseDeductible }}}">
                                                  <input type="hidden" class="TermValue" value="">
                                                  <a style="padding-right:5px;" id="modal2" class="linkmodal2"data-toggle="modal" data-target="#myModal2" ><i class="fa fa-file-text-o" title="Brochure"></i></a>    
                                                  <a style="padding-right:5px;" href="CreatePDF?ProductId={{{ $Product->id }}}" target="_blank" title="PDF contract" name="{{{ $Product->id }}}" class="PdfContract"><i class="fa fa-file-text"></i></a>
                                                                                                                   
                                        </div>  
                                               <input class="ProductSellingPrice" name="${{{ number_format($Product->SellingPrice, 2) }}}" type="text"  hidden>
                                               <input class="ProductType" name="<?php echo $TypeAcceptedArray[$WebIndex]; ?>" type="text" hidden>
                                               <input class="ProductTerm" name="<?php echo $TermAcceptedArray[$WebIndex]; ?>" type="text" hidden>
                                               <input class="ProductDeductible" name="<?php echo $DeductibleAcceptedArray[$WebIndex]; ?>" type="text" hidden>                                               
                                               <input class="ProductBaseType" name="{{{ $Product->ProductType }}}" type="text" hidden>
                                               <input class="ProductMileage" name="<?php try {echo $MileageAcceptedArray[$WebIndex];} catch (Exception $e) {echo "0";} ?>" type="text" hidden>
                                               @if($Product->UseTireRotation == 1)
                                                 <input type="hidden" class="ProductTireRotation" name="<?php try {echo str_replace('-',',',$TireRotationAcceptedArray[$WebIndex]);} catch (Exception $e) {echo "0";} ?>" >
                                               @else
                                                  <input type="hidden" class="ProductTireRotation" name="<?php echo "0"; ?>" >
                                               @endif
                                               @if($Product->UseInterval == 1)
                                                 <input type="hidden" class="ProductInterval" name="<?php try {echo trim($IntervalAcceptedArray[$WebIndex]);} catch (Exception $e) {echo "0";} ?>" >
                                               @else
                                                 <input type="hidden" class="ProductInterval" name="<?php echo "0"; ?>" >
                                               @endif
                                               <?php $WebIndex= $WebIndex+1; ?>
                                    <input type="hidden" class="BrochureImage" value="{{{$Product->BrochureImage}}}" name="{{{$Product->BrochureHeight}}}-{{{$Product->BrochureWidth}}}">
                                    </section>
                                    <?php $j= $j+1; ?>
                                    @endif 
                                    @endfor
                        
                                </div>
                        </ul>
                      
                    </div>
                </div>
            </div>        
    </td>
    <td class="disclosureTDCenter">
        <div class="Rejected">
                <div class="gantry-width-block">
                    <div class="gantry-width-spacer">
                        <ul class="rt-pricing-table3">
                            <li class="rt-table-title-productsRejected">Products Rejected</li>
                            <li class="rt-table-description">
                                <div id="RejectedTable" class="bodyTable">
                                    <?php  $j=0; $WebIndex = 0;?>                                    
                                    @for( $i = 0; $i < count($Products); $i++)
                                                         <?php $Product = $Products[$i]; ?>
                                    @if(in_array($Product->id,$RejectedArray))
                                    <?php $Taxable = 0; ?>
                                    <?php if ($Product->IsTaxable == 1) {$Taxable = 1;}?>
                                    <section class="products" id="{{{ $Product->id }}}"  name="{{{ $Product->ProductBaseId }}}"  company="{{{ $Product->CompanyId }}}">
                                        <div class="product-header-container">
                                            <div class="title-product">
                                                <input type="checkbox" value="<?php echo $RejectedArrayPrice[$j]; ?>"   tax="{{ $Taxable }}" name="Rejected" RangePricing="<?php try { echo $Product->UseRangePricing;} catch (Exception $e) { echo "0";} ?>" OrderNumber = "<?php echo $OrderRejectedArray[$j]; ?>" >
                                                {{{ $Product->DisplayName }}}
                                            </div>
                                            <div class="price-product"><?php/* echo number_format((float)$RejectedArrayPrice[$j], 2, '.', ''); */?></div>
                                         <div class="displayname-product"><?php try { echo str_replace('%', ',', $DescriptionRejectedArray[$WebIndex]); } catch (Exception $e) { echo ""; } ?></div>
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
                                                  @if ($Product->UsingWebService == 0)
                                                            <a style="padding-right:5px;" id="modal1" class="linkmodal1 NotUsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
                                                  @else
                                                            <a style="padding-right:5px;" id="modal1" class="linkmodal1 UsingWebService"data-toggle="modal" data-target="#myModal1" ><i class="fa fa-cog" title="Options"></i></a>
                                                  @endif
                                                  <input type="hidden" class="UseTerm" value="{{{ $Product->UseTerm }}}">
                                                  <input type="hidden" class="UseType" value="{{{ $Product->UseType }}}">
                                                  <input type="hidden" class="UseDeductible" value="{{{ $Product->UseDeductible }}}">
                                                   
                                                  <a style="padding-right:5px;" id="modal2" class="linkmodal2"data-toggle="modal" data-target="#myModal2" ><i class="fa fa-file-text-o" title="Brochure"></i></a>  
                                                   @if($Product->UsingWebService == 1)
                                                            <a style="padding-right:5px;" href="CreatePDF?ProductId={{{ $Product->id }}}" target="_blank" title="PDF contract" name="{{{ $Product->id }}}" class="PdfContract"><i class="fa fa-file-text"></i></a>
                                                  @endif                                                                      
                                        </div>
                                               <input class="ProductSellingPrice" name="${{{ number_format($Product->SellingPrice, 2) }}}" type="text"  hidden>
                                               <input class="ProductType" name="<?php echo $TypeRejectedArray[$WebIndex]; ?>" type="text" hidden>
                                               <input class="ProductTerm" name="<?php echo $TermRejectedArray[$WebIndex]; ?>" type="text" hidden>
                                               <input class="ProductDeductible" name="<?php echo $DeductibleRejectedArray[$WebIndex]; ?>" type="text" hidden>                                               
                                               <input class="ProductBaseType" name="{{{ $Product->ProductType }}}" type="text" hidden>
                                               <input class="ProductMileage" name="<?php echo $MileageRejectedArray[$WebIndex]; ?>" type="text" hidden>
                                               @if($Product->UseTireRotation == 1)
                                                  <input type="hidden" class="ProductTireRotation" name="<?php echo str_replace('-',',',$TireRotationRejectedArray[$WebIndex]); ?>" >
                                               @else
                                                  <input type="hidden" class="ProductTireRotation" name="<?php echo "0"; ?>" >
                                               @endif
                                               @if($Product->UseInterval == 1)
                                                  <input type="hidden" class="ProductInterval" name="<?php echo trim($IntervalRejectedArray[$WebIndex]); ?>" >
                                               @else
                                                 <input type="hidden" class="ProductInterval" name="<?php echo "0"; ?>" >
                                               @endif
                                              <?php $WebIndex= $WebIndex+1; ?>
                                    <input type="hidden" class="BrochureImage" value="{{{$Product->BrochureImage}}}" name="{{{$Product->BrochureHeight}}}-{{{$Product->BrochureWidth}}}">
                                    </section>
                                      <?php $j= $j+1; ?>
                                    @endif   
                                            @endfor
                                </div>

                        </ul>                       
                    </div>
                </div>
        </div>                    
    </td>
    <td class="disclosureTDRight">        
        <div class="Disclosure">
                <div class="gantry-width-block">
                    <div class="gantry-width-spacer">
                        <ul class="rt-pricing-table3">
                            <li class="rt-table-title-disclosure">Disclosure</li>                               
                            <li class="rt-table-description">
                            <div class="bodyTable"> 
                              <br>
                                     <?php 
                                    //$data = Session::get('WebServiceInfo');
                                    echo $WebService->Disclosure;
                                    
                                    ?>
                            </div>                  
                        </ul>               
                    </div>
                 </div>

             </div>           
        </div>    
    </td>
    <td></td>
    </tr>
    <tr class="footer">
      <td></td>
    <td class="disclosureTDLeft">
          
        <div class="footerTableDisclosure">
        <table style="width: 100%;">
            <tr>
            <td style="float: left;" >
            <h4><strong>Updated Payment: </strong></h4>
            </td>
            <td style="float:right;">
            <h4><strong><label id="TotalAccepted">{{ $MonthlyPaymentFinance }}</label></strong></h4>
            </td>
            </tr>
            <tr><td style="float:left;"><h4><strong>Initials:</strong></h4></td>
            <td style="width:70%; float:right;border-bottom: 2px solid #000; height:30px; vertical-align: bottom;">
            <h4><strong></strong></h4></td>
            </tr>
        </table>
        </div>

    </td>
    <td class="disclosureTDCenter">
        
        <div class="footerTableDisclosure">
         <table style="width: 100%;">
         <tr>
         <td style="float:left; text-align: right;  width:50%;">
            <h2><strong>Cost Per Day: </strong></h2>
            </td>
            <td style="float:right; text-align: left; width:30%;"><h2><strong> <label id="TotalRejected">{{ $CostPerDayFinance }}</label></strong></h2>
            </td>
            </tr>
            <tr>
            <td style="float:left; text-align: right; width:50%; ">
            <h5><strong>Additional Payment: </strong></h5>
            </td>
            <td style="float:right; text-align: left; width:30%;"><h5><strong> <label id="TotalPayment">{{ $AdditionalPaymentFinance }}</label></strong></h5></td>
            </tr>            
            </table>
        </div>

    </td>
    <td class="disclosureTDRight">
       
        <div class="footerTableDisclosure">

        <table style="width: 100%;">
            <tr style="height:40px;">
                <td style="float: left;width:50%;" >

                         <table style="width: 100%;">
                            <tr>
                                <td style="float: left; width:40%; text-align: right;" >
                                <h4><strong>Buyer:&nbsp;</strong></h4>
                                </td>
                                <td style="width:60%; float:right;border-bottom: 2px solid #000; height:30px; vertical-align: bottom;">
                                <h4><strong></strong></h4>
                                </td>               
                            </tr>                                       
                        </table>     
                </td>        
                <td style="float: right;width:50%;" >

                         <table style="width: 100%;">
                            <tr>
                                <td style="float: left;text-align:right; width:30%;" >
                                <h4><strong>Date:&nbsp;</strong></h4>
                                </td>
                                <td style="width:70%; float:right;border-bottom: 2px solid #000; height:30px; vertical-align: bottom;">
                                <h4><strong></strong></h4>
                                </td>               
                            </tr>                                       
                        </table>     
                </td>        
            </tr>    
             <tr >
                 <td style="float: left;width:50%;" >

                         <table style="width: 100%;">
                            <tr>
                                <td style="float: left; width:40%; text-align:right;height:30px;" >
                                <h4><strong>CoBuyer:&nbsp;</strong></h4>
                                </td>
                                <td style="width:60%; float:right;border-bottom: 2px solid #000; height:30px; vertical-align: bottom;">
                                <h4><strong></strong></h4>
                                </td>               
                            </tr>                                       
                        </table>     
                </td>        
                <td style="float: right;width:50%;">

                         <table style="width: 100%;">
                            <tr>
                                <td style="float: left;text-align:right;width:30%;height:40px;" >
                                <h4><strong>Date:&nbsp;</strong></h4>
                                </td>
                                <td style="width:70%; float:right;border-bottom: 2px solid #000; height:30px; vertical-align: bottom;">
                                <h4><strong></strong></h4>
                                </td>               
                            </tr>                                       
                        </table>     
                </td>      
            </tr>           
        </table> 
        </div>
    
    </td>
    <td></td>
    </tr>

</table>
    
   

</div>

<div class="row" style="margin-top: 5%; margin-bottom: 3%;">
    <div class="col-md-2 col-md-offset-10" style="padding-left: 3%; display:none;">
         <button id="SaveConfig" class="btn btn-lg btn-primary"><i class="fa fa-check-square-o"></i> Save to DMS</button> 
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
                     <option value="Platinum">Platinum</option>
                     <option value="Gold">Gold</option>
                     <option value="Silver">Silver</option>
                     <option value="Powertrain">Powertrain</option>
                  </select>
               </div>

              <div  id="ModalTerm"  class="form-group">
                  <label for="displayName">Term</label>
                  <!-- <input id="displayName" type="text"class="form-control" class="form-control" style="width:40%"> -->
                  <select name="Term" id="TermFinance" class="form-control" style="width:90%;">
                    <option value="36">36</option>
                    <option value="48">48</option>  
                    <option value="60">60</option>
                    <option value="72">72</option>
                  </select> 
                  <input type="text" id="TermFinance2" class="form-control" style="width:90%;" value="{{{$WebService->Term}}}">   
                </div>

                <div  id="ModalMileage"  class="form-group">
                  <label for="displayName">Mileage</label>
                  <!-- <input id="displayName" type="text"class="form-control" class="form-control" style="width:40%"> -->
                  <select name="Mileage" id="MileageFinance" class="form-control" style="width:90%;">
                    <option value="36">36</option>
                    <option value="48">48</option>      
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
                
                <div  id="ModalDeductible" class="form-group">
                  <label for="Deductible">Deductible</label>
                  <select id="DeductibleFinance" name="Deductible" class="form-control"  style="width:90%;" >
                         <option value="0">$0</option>
                         <option value="50">$50</option>                                                  
                         <option value="100">$100</option>
                         <option value="100D">$100 Disappearing</option>
                         <option value="200">$200</option>
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
        <button type="button" id="saveModalDisclosure" class="btn btn-primary pull-left"><i class="fa fa-check-circle"></i> Update Pricing</button>
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
         <button  id="CloseModal" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>               
      </div>
    </div>
  </div>
</div>
</div>
<!-- End modal for manual entry --> 
<input type="hidden" id="ValidatePage" value="1">
<input name="ProtectiveVsc" id="HiddenProtectiveVsc" value="<?php echo $surcharges;?>" type="hidden"/>
@stop

@section('scripts')
{{ HTML::script('js/disclosure.js'); }} 
@stop
