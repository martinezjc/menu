$(document).ready(function () {
    checkWebService();

    $(':checkbox').click(function (event) {
        if (!$(this).prop("checked")) {
            $(this).prop("checked", true);

        } else {
            $(this).prop("checked", false);

        }
       checkName = $(this).attr('name');
       switch (checkName) {
            case 'ApplyChanges': 
                    if (!$(this).prop("checked")) {
                    $(this).prop("checked", true);
                    } else {
                    $(this).prop("checked", false);
                    }
                    break;  
            case 'protective': 
                    if (!$(this).prop("checked")) {
                    $(this).prop("checked", true);
                    } else {
                    $(this).prop("checked", false);
                    }
                    break;           
        } 

    });

    $('.products input[type="checkbox"]').click(function () {
        //var checkbox = $(this).find("input[type='checkbox']");
        //var checkbox = ($(this));
        checkName = $(this).attr('name');
        if (flagBottonsModal==1) {
            flagBottonsModal=0;
            return;
        };
        switch (checkName) {
            case 'Accepted': $(this).parent().parent().parent().css("opacity", "1");
                break;

            case 'Rejected': $(this).parent().parent().parent().css("opacity", "1");
                break;

            default:
                if (!($(this).prop("checked"))) {
                    $(this).prop("checked", true);
                    $(this).parent().parent().parent().css("opacity", "1");
                    calculatePlans();
                } else {
                    $(this).prop("checked", false);
                    $(this).parent().parent().parent().css("opacity", "0.7");
                    $('.footerTable').css("opacity", "1");
                    calculatePlans();

                }
        }

    });

    $('.productsDealSettings input[type="checkbox"]').click(function () {
        if (!($(this).prop("checked"))) 
        {
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", false);
        } 
    });
    
    

    flagBottonsModal=0;
    calculatePlans(); 
});

// Checks connection for web service request
function checkWebService(){
    var FailWebService = parseInt($('#FailWebService').val());
    if (FailWebService == 1) {
        toastr.error('We were unable to get the rates for some products, please try again.', "Message");
    };
}

$("#ButtonNext").click(function () {
    DefineId(GlobalPlanChoosed);
    var text = $("#ModelValidate").html();
    DefineId(GlobalPlanChoosed)
    if (ValidationEmptyDeal ()) {
        return false;
    };
});

// Calculates the total of each plan
function calculatePlans() {
    
    var currentFinancedAmount = getCurrentFinancedAmount();

    var apr = getCurrentAPR();
    var apr2 = getFooterAPR();
    var term = getCurrentTerm();
    var term2 = getFooterTerm();
    
    // Calculate the base payment
    $("#BasePaymentHidden").text(getAmount(getMonthlyPayment(currentFinancedAmount, term, apr)));
    
    setPlanAmounts('Premium', currentFinancedAmount, term, apr, term2, apr2);
    setPlanAmounts('Preferred', currentFinancedAmount, term, apr, term2, apr2);
    setPlanAmounts('Economy', currentFinancedAmount, term, apr, term2, apr2);
    setPlanAmounts('Basic', currentFinancedAmount, term, apr, term2, apr2);
}

function setPlanAmounts(plan, financedAmount, term, apr, term2, apr2)
{
    var group = document.getElementsByName(plan);
    var sum = 0.00;

    for (var i = 0; i < group.length; i++) {
        var IsTaxable = group[i].getAttribute("tax");
        if (group[i].checked == true) {
            if (IsTaxable == 1) {
                sum = sum + getFloat(ApplyTaxRate(group[i].value));
            } else{
               sum = sum + getFloat(group[i].value);    
            }           
        }
    }

    var totalAmount = financedAmount + sum;

    // First term and apr
    var basePayment = getMonthlyPayment(financedAmount, term, apr);
    var monthlyPayment1 = getMonthlyPayment(totalAmount, term, apr);
    var additionalPayment = monthlyPayment1 - basePayment;
    var costPerDay = additionalPayment / 30;

    $('#Monthly' + plan).text(getAmount(monthlyPayment1));
    $('#Additional' + plan).text(getAmount(additionalPayment));
    $('#CostDay' + plan).text(getAmount(costPerDay));
    $('#SpanPayment' + plan).text(getAmount(monthlyPayment1));

    // Second term and apr
    var monthlyPayment2 = getMonthlyPayment(totalAmount, term2, apr2);
    
    $('#SpanPayment' + plan + '2').text(getAmount(monthlyPayment2));

    sortMonthlyPaymentOptions(plan, monthlyPayment1 < monthlyPayment2 ? 1 : 2);
}

$('.tables .header').hover(
  function () {
      $(this).parent().addClass("hover");
  }, function () {
      $(this).parent().removeClass("hover");
  }
);

$('.header').click(function () {
    $(this).parent().css("border-color", "black");
    $("#ButtonNext").prop("disabled", false);
    var id = $(this).attr('name');
    var id2 = $(this).parent().attr('id');
    $('#HiddenId').val(id);
    GetIdProducts(id2);
    $("#ButtonNext").focus();
});

$(".months").click(function () {
    var month = $(this).html();
});

$(".rt-pricing-table").css({ 'height': ($("#SectionTables").height() - $('.rt-table-price-premium').height() + 'px') });
$('#btnPremium, #btnPremiumBack').on('click', function () {

     if (ValidationEmptyDeal ()) {
        return false;
    };

    $('#btnPreferred').removeClass('active');
    $('#btnEconomy').removeClass('active');
    $('#btnBasic').removeClass('active');

    $('.rt-table-price-preferred').removeClass('activeFooterPreferred');
    $('.rt-table-price-economy').removeClass('activeFooterEconomy');
    $('.rt-table-price-basic').removeClass('activeFooterBasic');

    $('#btnPreferredBack').removeClass('active');
    $('#btnEconomyBack').removeClass('active');
    $('#btnBasicBack').removeClass('active');

    if (!$(this).hasClass('active')) {
        $('#btnPremium').addClass('active');
        $('#btnPremiumBack').addClass('active');
        $('.rt-table-price-premium').addClass('activeFooterPremium');
    }
    DefineId(1);

});

$('#btnPreferred, #btnPreferredBack').on('click', function () {

     if (ValidationEmptyDeal ()) {
        return false;
    };

    $('#btnPremium').removeClass('active');
    $('#btnEconomy').removeClass('active');
    $('#btnBasic').removeClass('active');    

    $('.rt-table-price-premium').removeClass('activeFooterPremium');
    $('.rt-table-price-economy').removeClass('activeFooterEconomy');
    $('.rt-table-price-basic').removeClass('activeFooterBasic');

    $('#btnPremiumBack').removeClass('active');
    $('#btnEconomyBack').removeClass('active');
    $('#btnBasicBack').removeClass('active');   

    if (!$(this).hasClass('active')) {
        $('#btnPreferred').addClass('active');
        $('#btnPreferredBack').addClass('active');
        $('.rt-table-price-preferred').addClass('activeFooterPreferred');
    }
    DefineId(2);
});

$('#btnEconomy, #btnEconomyBack').on('click', function () {

     if (ValidationEmptyDeal ()) {
        return false;
    };

    $('#btnPreferred').removeClass('active');
    $('#btnPremium').removeClass('active');
    $('#btnBasic').removeClass('active');

    $('.rt-table-price-preferred').removeClass('activeFooterPreferred');
    $('.rt-table-price-premium').removeClass('activeFooterPremium');
    $('.rt-table-price-basic').removeClass('activeFooterBasic');    

    $('#btnPreferredBack').removeClass('active');
    $('#btnPremiumBack').removeClass('active');
    $('#btnBasicBack').removeClass('active');

    if (!$(this).hasClass('active')) {
        $('#btnEconomy').addClass('active');
        $('#btnEconomyBack').addClass('active');
        $('.rt-table-price-economy').addClass('activeFooterEconomy');        
    }
    DefineId(3);
});

$('#btnBasic, #btnBasicBack').on('click', function () {

     if (ValidationEmptyDeal ()) {
        return false;
    };

    $('#btnPreferred').removeClass('active');
    $('#btnPremium').removeClass('active');
    $('#btnEconomy').removeClass('active');

    $('.rt-table-price-preferred').removeClass('activeFooterPreferred');
    $('.rt-table-price-premium').removeClass('activeFooterPremium');
    $('.rt-table-price-economy').removeClass('activeFooterEconomy');
    
    $('#btnPreferredBack').removeClass('active');
    $('#btnPremiumBack').removeClass('active');
    $('#btnEconomyBack').removeClass('active');

    if (!$(this).hasClass('active')) {
        $('#btnBasic').addClass('active');
        $('#btnBasicBack').addClass('active');
        $('.rt-table-price-basic').addClass('activeFooterBasic');
    }
    DefineId(4);
})

$("#saveModal1").click(function () {
    var Type = $('#TypeFinance :selected').val();
    var Term = $('#TermFinance :selected').val(); 
    var TermText =  $('#TermFinance :selected').text();
    var OrderNumber = $('#TermFinance :selected').attr('OrderNumber');    
    var Deductible = $("#DeductibleFinance :selected").val();
    var SellingPrice = $("#PriceProduct").val();
    var ValidatePrice = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    var ProductBaseType = $(GlobalSectionProduct).find( '.ProductBaseType' ).attr('name');
    SellingPrice = SellingPrice.replace('$','');
    var Mileage = 0;
    var tireRotation = 0;
    var interval = 0;
    var  ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
    var ProductId= GlobalSectionProduct.attr('id');
    var newDescription;
    
    if (eval("productRates.product" + ProductId )) {
        if ((ProductBaseId == 12 || ProductBaseId == 2 ) && ($("#TypeFinance").is(':visible'))) {
            Mileage = $('#ModalMileage :selected').val();
            Term = new String(GetValueWebService(Type,TermText,Mileage,tireRotation,interval,Deductible,ProductBaseId));
        }

        if ( ProductBaseId == 4 ) {
            Mileage = $('#ModalMileage :selected').val();
            tireRotation = $('#TireRotation :selected').val();
            interval = $('#Interval :selected').val();

            Term = new String(GetValueWebService(Type,TermText,Mileage,tireRotation,interval,Deductible,ProductBaseId));
        }
    }  

    if (ProductBaseId == 12) {
        var Surcharges = GetSurchargesValues();
        $('#HiddenProtectiveVsc').val(Surcharges);
    };  
   
   if ($("#DeductibleFinance").is(':visible') && Deductible != null) {
        Deductible2 = Deductible.replace('D','');
   }
    
    if (!ValidateExpression(SellingPrice,'Money')) {            
            toastr.error('Invalid selling price format.', "Message");
            return false;
    }
    SellingPrice = GetFloat(SellingPrice).toFixed(2); 
    

    if (ProductBaseType == 'GAP') {
        var years;
        var description = $(GlobalSectionProduct).find( '.description-product' ).text();
        

        if (!TermText){
            years = $('#TermFinance2').val() / 12;
        } else if( $('#TermFinance2').val() != '' ) {
            years = $('#TermFinance2').val() / 12;
        } else {
            years = TermText / 12;
        }
        
        if(years%1!==0)
            years=years.toFixed(1);
        
        if ( description != '' ) 
        {
            newDescription = years + ' Years / ' + '$' + Deductible.replace('D','') + ' Deductible - ' + description;
            if ($("#ApplyChanges").prop("checked")) {
                $(".products").each(function () {
                    idEvaluate = $(this).attr('id');
                    idSave = GlobalSectionProduct.attr('id');
                    if (idEvaluate == idSave) {
                        $(this).find( '.displayname-product' ).text( newDescription );
                    };
                });    
            } else {
                $(GlobalSectionProduct).find( '.displayname-product' ).text( newDescription );
            }
            
        }
        else
        {
            newDescription = years + ' Years / ' + '$' + Deductible.replace('D','') + ' Deductible';
            if ($("#ApplyChanges").prop("checked")) {
                $(".products").each(function () {
                    idEvaluate = $(this).attr('id');
                    idSave = GlobalSectionProduct.attr('id');
                    if (idEvaluate == idSave) {
                        $(this).find( '.displayname-product' ).text( newDescription );
                    };
                });    
            } else {
                $(GlobalSectionProduct).find( '.displayname-product' ).text( newDescription );
            }
        }

        
        Term = $("#PriceProduct").val();
    };

    

    if (ProductBaseType == 'WARRANTY') {
        var years = TermText / 12;
        var description = $(GlobalSectionProduct).find( '.description-product' ).text();

        if ( description != '' ) 
        {
            newDescription = years + ' Years / ' 
            + $('#ModalMileage :selected').val() 
            + ',000 Miles / ' + '$' + Deductible.replace('D','') + ' Deductible - '  + description;
            if ($("#ApplyChanges").prop("checked")) {
                $(".products").each(function () {
                    idEvaluate = $(this).attr('id');
                    idSave = GlobalSectionProduct.attr('id');
                    if (idEvaluate == idSave) {
                        $(this).find( '.displayname-product' ).text( newDescription );
                    };
                });    
            } else {
                $(GlobalSectionProduct).find( '.displayname-product' ).text( newDescription );
            }
        }
        else
        {
            newDescription = years + ' Years / ' 
            + $('#ModalMileage :selected').val() 
            + ',000 Miles / ' + '$' + Deductible.replace('D','') + ' Deductible.';
            if ($("#ApplyChanges").prop("checked")) {
                $(".products").each(function () {
                    idEvaluate = $(this).attr('id');
                    idSave = GlobalSectionProduct.attr('id');
                    if (idEvaluate == idSave) {
                        $(this).find( '.displayname-product' ).text( newDescription );
                    };
                });    
            } else {
                $(GlobalSectionProduct).find( '.displayname-product' ).text( newDescription );
            }
        }
    }


    if ($("#ApplyChanges").prop("checked")) {
            if ( ($("#PriceProduct").is(':visible')) || ($("#TermFinance").is(':visible')) ) {
                UpdatePriceAllColumns(SellingPrice); 
                if (GlobalValidatePrice == 1) {
                    UpdatePriceWebServicesProductAllColumns(Term);
                }            
                
            } 

            UpdateFieldsWebservicesProducts(Type,TermText,Deductible, OrderNumber, Mileage,tireRotation, interval);
               
                        
    } else { 
            if ( ($("#PriceProduct").is(':visible')) || ($("#TermFinance").is(':visible')) ) {
                var manualPrice = GetFloat(SellingPrice).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $(GlobalSectionProduct).find( '.price-product' ).text('$'+ manualPrice);
                $(GlobalSectionProduct).find(':checkbox').val(SellingPrice);              
                if (GlobalValidatePrice == 1) {
                    UpdatePriceWebServicesProduct(Term);                
                } 
            }
            if (GlobalValidatePrice == 1) {
                 $(GlobalSectionProduct).find( ':checkbox' ).attr('OrderNumber', OrderNumber);  
                                
            } 

           $(GlobalSectionProduct).find( '.ProductType' ).attr('name', Type);
           $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name', TermText);
           $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name', Deductible);           
           $(GlobalSectionProduct).find( '.ProductMileage' ).attr('name', Mileage);
           $(GlobalSectionProduct).find( '.ProductTireRotation' ).attr('name', tireRotation);
           $(GlobalSectionProduct).find( '.ProductInterval' ).attr('name', interval);
            
    }
    calculatePlans();
    $('#myModal1').modal('hide');
});

function UpdatePriceWebServicesProduct(term) {
    var term2 = GetFloat(term).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    if (GlobalValidatePrice == 1) {
        $(GlobalSectionProduct).find( '.price-product' ).text('$'+ term2);
        $(GlobalSectionProduct).find(':checkbox').val(term);
    };
}

function UpdatePriceWebServicesProductAllColumns(term) {
    var term2 = GetFloat(term).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $(".products").each(function () {
                        idEvaluate = $(this).attr('id');
                        if (idEvaluate == idSave) {
                            $(this).find( '.price-product' ).text('$'+ term2);
                            $(this).find(':checkbox').val(term);
                            $(this).find( '').text();
                        };        
     });            
}

function UpdatePriceAllColumns (price) {
    var price2 = GetFloat(price).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $(".products").each(function () {
        idEvaluate = $(this).attr('id');
        idSave= GlobalSectionProduct.attr('id');
        if (idEvaluate == idSave) {
            $(this).find( '.price-product' ).text('$'+ price2);
            $(this).find(':checkbox').val(price);
        };       
    });
}

function UpdateFieldsWebservicesProducts (type, term, deductible, ordernumber, mileage, tireRotation, interval) {
    $(".products").each(function () {
        idEvaluate = $(this).attr('id');
        idSave= GlobalSectionProduct.attr('id');
        if (idEvaluate == idSave) {
           $(this).find( '.ProductType' ).attr('name', type);
           $(this).find( '.ProductTerm' ).attr('name', term);
           $(this).find( '.ProductDeductible' ).attr('name', deductible);
           $(this).find( ':checkbox' ).attr('OrderNumber', ordernumber); 
           $(this).find( '.ProductMileage' ).attr('name', mileage);
           $(this).find( '.ProductTireRotation' ).attr('name', tireRotation);
           $(this).find( '.ProductInterval' ).attr('name', interval);
        };  
    });
}


$("#FindDeal").click(function () {
    $.blockUI();
});

$(".PdfContract").click(function() {
    GlobalSectionProduct = $(this).parent().parent();
    var Id = $(GlobalSectionProduct).attr('id');
    var Type = $(GlobalSectionProduct).find( '.ProductType' ).attr('name');
    var Term = $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name');
    var Deductible = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    var Mileage = $(GlobalSectionProduct).find( '.ProductMileage' ).attr('name');
    var OrderNumber = $(GlobalSectionProduct).find( ':checkbox' ).attr('OrderNumber'); 
    var Price = GetFloat($(GlobalSectionProduct).find( ':checkbox' ).val());

    if (OrderNumber.length == 0) {
        OrderNumber = 0;
    };
    if (Mileage == 0) {
        $(this).attr("href", 'CreatePDF?ProductId='+Id+'&type='+Type+'&term='+Term+'&deductible='+Deductible+'&key='+OrderNumber+'&price='+Price); 
    }else{
        $(this).attr("href", 'CreatePDF?ProductId='+Id+'&type='+Type+'&term='+Term+'&deductible='+Deductible+'&key='+OrderNumber+'&mileage='+Mileage+'&price='+Price); 
    }
       
})

function CreatePDf() {
     $.ajax({
      type: "GET",
      url: "CreatePDF",
      data:{
        data : 58
      },
      success: function (msg) {
      },
      failure: function (msg) {
        toastr.error('User not found.', "Message");
      }
   }); 
}

$('#printmenupdf').click(function(){
    UpdatePlansArray();
});

UpdatePlansArray = function(){
    var premiumarray = [];
    var preferredarray = [];
    var economyarray = [];
    var basicarray = [];
    var costbyproductarray = [];
    var premiumacceptedarray = [];
    var preferredacceptedarray = [];
    var economyacceptedarray = [];
    var basicacceptedarray = [];
    var costfooterarray = [];
    var costpremiumarray = [];
    var costpreferredarray = [];
    var costeconomyarray = [];
    var costbasicarray = [];
    var premiumdescriptionarray = [];
    var preferreddescriptionarray = [];
    var economydescriptionarray = [];
    var basicdescriptionarray = [];
    var visibleproductsarray=[];
    var index = 0;
    var index2 = 0;

    index = 0;
    $('#1 section.products').each(function(){
        console.warn('aqui');
        var currentnode = $(this);
        var styleattibute = currentnode.attr('style');

        if(styleattibute!=undefined)
        {
            if(styleattibute.match('none'))
                visibleproductsarray[index] =  currentnode.attr('id');
        }

        index += 1;

    });

    var index = 0;
    $('#1 div.displayname-product').each(function(){
        premiumdescriptionarray[index] = $(this).text().trim() + "!";
        index = index +1;
    });

    var index = 0;
    $('#2 div.displayname-product').each(function(){
        preferreddescriptionarray[index] = $(this).text().trim() + "!";
        index = index +1;
    });

    var index = 0;
    $('#3 div.displayname-product').each(function(){
        economydescriptionarray[index] = $(this).text().trim() + "!";
        index = index +1;
    });

    var index = 0;
    $('#4 div.displayname-product').each(function(){
        basicdescriptionarray[index] = $(this).text().trim() + "!";
        index = index +1;
    });

    var facefooter = $('#cardPremium').hasClass('hoverFooter');

    var total = $("#1 :checkbox").length;

    index = 0;
    $("#1 :checkbox").each(function () {
        var currentproduct = $(this)[0];

        premiumarray[index] = currentproduct.id;

        if(currentproduct.checked)
        {
            premiumacceptedarray[index2] = currentproduct.id;
            index2= index2 + 1;
        }

        // if(index<total-1)
        //     preferredarray[index] = currentproduct.id;

        // if(index<total-2)
        //     economyarray[index] = currentproduct.id;

        // if(index<total-3)
        //     basicarray[index] = currentproduct.id;

        costpremiumarray[index] = currentproduct.value.replace(',','!');

        index =  index + 1;
    });

    index=0;
    index2 = 0;
    $("#2 :checkbox").each(function () {
        // console.dir($(this));
        var currentproduct = $(this)[0];
        preferredarray[index] = currentproduct.id;

        if(currentproduct.checked)
        {
            preferredacceptedarray[index2] = currentproduct.id;
            index2 =  index2 + 1;
        }

        costpreferredarray[index] = currentproduct.value.replace(',','!');
        index = index + 1 ;
    });

    index=0;
    index2 = 0;
    $("#3 :checkbox").each(function () {
        var currentproduct = $(this)[0];
        economyarray[index] = currentproduct.id;

        if(currentproduct.checked)
        {
            economyacceptedarray[index2] = currentproduct.id;
            index2 =  index2 + 1;
        }

        costeconomyarray[index] = currentproduct.value.replace(',','!');
        index = index + 1 ;
    });

    index=0;
    index2 = 0;
    $("#4 :checkbox").each(function () {
        var currentproduct = $(this)[0];
        basicarray[index] = currentproduct.id;
        
        if(currentproduct.checked)
        {
            basicacceptedarray[index2] = currentproduct.id;
            index2 =  index2 + 1;
        }

        costbasicarray[index] = currentproduct.value.replace(',','!');
        index = index + 1 ;
    });


    costfooterarray[0] = $('#CostDayPremium').text();
    costfooterarray[1] = $('#AdditionalPremium').text();
    costfooterarray[2] = $('#MonthlyPremium').text();
    costfooterarray[3] = $('#PremiumSpanTerm2Id').text().trim();
    costfooterarray[4] = $('#PremiumSpanTermId').text().trim();

    costfooterarray[5] = $('#CostDayPreferred').text();
    costfooterarray[6] = $('#AdditionalPreferred').text();
    costfooterarray[7] = $('#MonthlyPreferred').text();
    costfooterarray[8] = $('#PreferredSpanTerm2Id').text().trim();
    costfooterarray[9] = $('#PreferredSpanTermId').text().trim();

    costfooterarray[10] = $('#CostDayEconomy').text();
    costfooterarray[11] = $('#AdditionalEconomy').text();
    costfooterarray[12] = $('#MonthlyEconomy').text();
    costfooterarray[13] = $('#EconomySpanTerm2Id').text().trim();
    costfooterarray[14] = $('#EconomySpanTermId').text().trim();

    costfooterarray[15] = $('#CostDayBasic').text();
    costfooterarray[16] = $('#AdditionalBasic').text();
    costfooterarray[17] = $('#MonthlyBasic').text(); 
    costfooterarray[18] = $('#BasicSpanTerm2Id').text().trim();
    costfooterarray[19] = $('#BasicSpanTermId').text().trim();

    $("#premiumarray").val(premiumarray);
    $("#preferredarray").val(preferredarray);
    $("#economyarray").val(economyarray);
    $("#basicarray").val(basicarray);
    // $("#costbyproductarray").val(costbyproductarray);
    $("#premiumacceptedarray").val(premiumacceptedarray);
    $("#preferredacceptedarray").val(preferredacceptedarray);
    $("#economyacceptedarray").val(economyacceptedarray);
    $("#basicacceptedarray").val(basicacceptedarray);
    
    $("#costpremiumarray").val(costpremiumarray);
    $("#costpreferredarray").val(costpreferredarray);
    $("#costeconomyarray").val(costeconomyarray)
    $("#costbasicarray").val(costbasicarray);

    $("#costfooterarray").val(costfooterarray);
    $('#facefooter').val(facefooter);  
    $('#premiumdescription').val(premiumdescriptionarray);
    $('#preferreddescription').val(preferreddescriptionarray);
    $('#economydescription').val(economydescriptionarray);
    $('#basicdescription').val(basicdescriptionarray);
    $('#visibleproducts').val(visibleproductsarray);
};

$('#saveDealSettings').click( function() {
    if (isNaN($('#APRDeal').val()) || isNaN($('#TermDeal').val()) || isNaN($('#DownPaymentDeal').val().replace(',',''))) {
        toastr.error('The Term and APR must be numbers.','Error');
        return false;
    }

    setAmount('#DealFinancedAmountValue', getCurrentFinancedAmount());
    setAmount('#DealerDownPaymentValue', $('#DownPaymentDeal').val());

    $('#DealerAPRValue').text($('#APRDeal').val());
    $('#DealerTermValue').text(getInt($('#TermDeal').val()));
    $('#APRFooter').val($('#APRDeal').val());
    $('#TermFooter').val($('#TermDeal').val());

    $("#AprHidden").val($('#APRDeal').val());
    $("#TermHidden").val($('#TermDeal').val());
    //$('#APRDealPercent').text($('#APRDeal').val());
    $('.SpanTerm').text($('#TermDeal').val());
    $('.SpanApr').text(getFloat($('#APRDeal').val()).toFixed(2));

    $('.productsDealSettings input[type=checkbox]').each(function () {
        var productId = $(this).attr('id');

        if (!($(this).prop("checked"))) 
        {
            $(this).prop("checked", false);
            $('section[id^="'+productId+'"]').hide();
            $('input:checkbox[id^="'+productId+'"]').prop('checked', false);
            calculatePlans();
        } else {
            $(this).prop("checked", true);
            if ( $(this).prop("checked", true) && $('section[id^="'+productId+'"]').is(":hidden") ) {
                $('input:checkbox[id^="'+productId+'"]').prop('checked', true);
                $('section[id^="'+productId+'"]').css("opacity", "1");
            }
            $('section[id^="'+productId+'"]').show();
            calculatePlans();
        }
    });

    changeFirstOnly = true;
    
    calculatePlans();

    $('#ModalDealSettings').modal('hide');

});

$(".optionsFooter").click(function () {
    showFooterSettings($(this));
} )

function showFooterSettings(element) {
    var apr =  getFloat($('.SpanApr2').text().toString().replace("%", "")).toFixed(2);
    var term = parseInt(element.find('.SpanTerm2').text());
    $('#TermFooter').val(term);
    $('#APRFooter').val(apr);


    $('#ModalOptionsFooter').modal('show');
}

$("#saveFooterSettings").click(function () {
    var term = $('#TermFooter').val(), apr = $('#APRFooter').val();

    if (isNaN(apr) || isNaN(term)) {
        toastr.error('The Term and APR must be numbers.', 'Error');
        return false;
    }

    setFooterAPR(apr);
    setFooterTerm(term);

    $('.SpanTerm2').text(term);
    $('.SpanApr2').text(getFloat(apr).toFixed(2));

    calculatePlans();

    $('#ModalOptionsFooter').modal('hide');
});

function setFooterAPR(value) {
    $('#footer-apr').val(value);
}

/**
 * This is for the second monthly payment option
 */
function getFooterAPR() {
    return getFloat($('#footer-apr').val().toString().replace("%", ""));
}

function setFooterTerm(value) {
    $('#footer-term').val(value);
}

/**
 * This is for the second monthly payment option
 */
function getFooterTerm()
{
    return getInt($('#footer-term').val());
}

function sortMonthlyPaymentOptions(plan, position)
{
    // We always going to move the first option to the top or to the bottom
    var elements = $('[name="' + plan.toString().toLowerCase() + 'Radio"]');
    if (elements != null && elements.length > 0) {
        if (elements[0].value == "1" && position == 1)
            return;
        else
            if (elements[0].value == "1" && position == 2) {
                // Have to move the element at the second position
                var tr = elements[0].parentNode.parentNode, tbody = tr.parentNode;

                $(tr).insertAfter(elements[1].parentNode.parentNode);
            }
            else
                if (elements[1].value == "1" && position == 1) {
                    var tr = elements[1].parentNode.parentNode, tbody = tr.parentNode;

                    $(tr).insertBefore(elements[0].parentNode.parentNode);
                }
    }
}
