(function($) {
    $.fn.hasScrollBar = function() {
        return this.get(0).scrollHeight > this.height();
    }
})(jQuery);

var globalProductId;
var Globalorder;
var total = 0;
var premium = 0;
var preferred = 0;
var economy = 0;
var basic = 0;
var GlobalAccepted = [];
var GlobalRejected = [];
var GlobalAcceptedPrice = [];
var GlobalRejectedPrice = [];
var flagBottonsModal = 0;
var GlobalSectionProduct;
var GlobalValidatePrice;
var GlobalPlanChoosed;
var GlobalCkeckboxClicked;
var GlobalValidatePage;
var GlobalOrderNumber;

$(window).load(function () {
    if ($('#SortableTable').length) {
        FillSortableTable();
    };    
});

$(document).ready(function () {
    StartToastMessage();
    retrieveListProducts();
    populateCompanyList();
    resetFields();
    $("#VehiclePlanModifiedProduct").hide();
    checkWebService();
    
    $('#productNameModified option').remove();
    loadCompanyProducts(1, 'editLabel');

    $('#showOptionsModified').css('padding-top','9px');

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
        } 

    });

    $(".products input[type='checkbox").click(function () {
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
    flagBottonsModal=0;
    calculatePlans(); 
    CalculateTotalCheckbox();

    if (!($(document).height() > $(window).height())) {
        $('footer').removeClass('footerApp');
    } 

});

function createSelectProtectiveNew(product){
    var selectTerm = $('#Term');
    var selectDeductible = $('#Deductible');
    var selectType = $('#Type');

    $('#Term option').remove();
    $('#Deductible option').remove();
    $('#Type option').remove();

    var option = product.trim();

    switch(option){
        case 'Total Lost Protection (GAP)': $('<option>').val('12').text('12').appendTo(selectTerm); 
                 $('<option>').val('24').text('24').appendTo(selectTerm); 
                 $('<option>').val('30').text('30').appendTo(selectTerm);
                 $('<option>').val('36').text('36').appendTo(selectTerm); 
                 $('<option>').val('48').text('48').appendTo(selectTerm);
                 $('<option>').val('60').text('60').appendTo(selectTerm);
                 $('<option>').val('72').text('72').appendTo(selectTerm); 
                 $('<option>').val('84').text('84').appendTo(selectTerm);
                 $('<option>').val('96').text('96').appendTo(selectTerm); 
                 $('<option>').val('120').text('120').appendTo(selectTerm);
                 $('<option>').val('0').text('$0').appendTo(selectDeductible);
                 $('<option>').val('50').text('$50').appendTo(selectDeductible);
                 $('<option>').val('100').text('$100').appendTo(selectDeductible);
                 $('<option>').val('200').text('$200').appendTo(selectDeductible);
                 $('<option>').val('Gap Purchase').text('Gap Purchase').appendTo(selectType);
                 $('<option>').val('Gap Balloon').text('Gap Balloon').appendTo(selectType);
                 $('<option>').val('Gap Lease').text('Gap Lease').appendTo(selectType);
                 break;
        case 'Vehicle Service Contract': $('<option>').val('60').text('60').appendTo(selectTerm); 
                    $('<option>').val('72').text('72').appendTo(selectTerm); 
                    $('<option>').val('84').text('84').appendTo(selectTerm); 
                    $('<option>').val('0').text('$0').appendTo(selectDeductible);
                    $('<option>').val('50').text('$50').appendTo(selectDeductible);
                    $('<option>').val('100').text('$100').appendTo(selectDeductible);
                    $('<option>').val('200').text('$200').appendTo(selectDeductible);
                    $('<option>').val('ADVANTAGE').text('ADVANTAGE').appendTo(selectType);
                    $('<option>').val('SELECT NEW').text('SELECT NEW').appendTo(selectType);
                    break;
        default: $('<option>').val(0).text(0).appendTo(selectTerm); 
                    $('<option>').val(0).text(0).appendTo(selectDeductible);
                    $('<option>').val('None').text('None').appendTo(selectType);
                    break;
        
    }
}

function createSelectProtectiveModified(product){
    var selectTerm = $('#TermModified');
    var selectDeductible = $('#DeductibleModified');
    var selectType = $('#TypeModified');

    $('#TermModified option').remove();
    $('#DeductibleModified option').remove();
    $('#TypeModified option').remove();

    var option = product.trim();

    switch(option){
        case 'Total Lost Protection (GAP)': $('<option>').val('12').text('12').appendTo(selectTerm); 
                 $('<option>').val('24').text('24').appendTo(selectTerm); 
                 $('<option>').val('30').text('30').appendTo(selectTerm);
                 $('<option>').val('36').text('36').appendTo(selectTerm); 
                 $('<option>').val('48').text('48').appendTo(selectTerm);
                 $('<option>').val('60').text('60').appendTo(selectTerm);
                 $('<option>').val('72').text('72').appendTo(selectTerm); 
                 $('<option>').val('84').text('84').appendTo(selectTerm);
                 $('<option>').val('96').text('96').appendTo(selectTerm); 
                 $('<option>').val('120').text('120').appendTo(selectTerm);
                 $('<option>').val('0').text('$0').appendTo(selectDeductible);
                 $('<option>').val('50').text('$50').appendTo(selectDeductible);
                 $('<option>').val('100').text('$100').appendTo(selectDeductible);
                 $('<option>').val('200').text('$200').appendTo(selectDeductible);
                 $('<option>').val('Gap Purchase').text('Gap Purchase').appendTo(selectType);
                 $('<option>').val('Gap Balloon').text('Gap Balloon').appendTo(selectType);
                 $('<option>').val('Gap Lease').text('Gap Lease').appendTo(selectType);
                 break;
        case 'Vehicle Service Contract': $('<option>').val('60').text('60').appendTo(selectTerm); 
                    $('<option>').val('72').text('72').appendTo(selectTerm); 
                    $('<option>').val('84').text('84').appendTo(selectTerm); 
                    $('<option>').val('0').text('$0').appendTo(selectDeductible);
                    $('<option>').val('50').text('$50').appendTo(selectDeductible);
                    $('<option>').val('100').text('$100').appendTo(selectDeductible);
                    $('<option>').val('200').text('$200').appendTo(selectDeductible);
                    $('<option>').val('ADVANTAGE').text('ADVANTAGE').appendTo(selectType);
                    $('<option>').val('SELECT NEW').text('SELECT NEW').appendTo(selectType);
                    break;
            default: $('<option>').val(0).text(0).appendTo(selectTerm); 
                    $('<option>').val(0).text(0).appendTo(selectDeductible);
                    $('<option>').val('None').text('None').appendTo(selectType);
                    break;
        
    }
}

function createSelectNew(product){

    var selectTerm = $('#Term');
    var selectDeductible = $('#Deductible');
    var selectType = $('#Type');

    $('#Term option').remove();
    $('#Deductible option').remove();
    $('#Type option').remove();

    var option = product.trim();

    switch(option){
        case 'Total Lost Protection (GAP)': $('<option>').val('60').text('60').appendTo(selectTerm); 
                 $('<option>').val('72').text('72').appendTo(selectTerm); 
                 $('<option>').val('84').text('84').appendTo(selectTerm);
                 $('<option>').val(0).text('None').appendTo(selectDeductible);
                 $('<option>').val('None').text('None').appendTo(selectType);
                 break;
        case 'US Key': $('<option>').val('12').text('12').appendTo(selectTerm); 
                    $('<option>').val('24').text('24').appendTo(selectTerm); 
                    $('<option>').val('36').text('36').appendTo(selectTerm);
                    $('<option>').val('48').text('48').appendTo(selectTerm); 
                    $('<option>').val('60').text('60').appendTo(selectTerm);
                    $('<option>').val(0).text('None').appendTo(selectDeductible);
                    $('<option>').val('None').text('None').appendTo(selectType);
                    break;
        case 'Maintenance Plan': $('<option>').val('12').text('12').appendTo(selectTerm); 
                    $('<option>').val('24').text('24').appendTo(selectTerm); 
                    $('<option>').val('36').text('36').appendTo(selectTerm);
                    $('<option>').val('39').text('39').appendTo(selectTerm);
                    $('<option>').val('48').text('48').appendTo(selectTerm); 
                    $('<option>').val('60').text('60').appendTo(selectTerm);
                    $('<option>').val(0).text('None').appendTo(selectDeductible);
                    $('<option>').val('None').text('None').appendTo(selectType);
                    break;
        case 'Road Hazard': $('<option>').val('36').text('36').appendTo(selectTerm);
                    $('<option>').val('60').text('60').appendTo(selectTerm);
                    $('<option>').val('0').text('0').appendTo(selectDeductible);
                    $('<option>').val('None').text('None').appendTo(selectType);
                    break;
        case 'Vehicle Service Contract': $('<option>').val('6').text('6').appendTo(selectTerm); 
                    $('<option>').val('12').text('12').appendTo(selectTerm); 
                    $('<option>').val('24').text('24').appendTo(selectTerm); 
                    $('<option>').val('36').text('36').appendTo(selectTerm);
                    $('<option>').val('48').text('48').appendTo(selectTerm); 
                    $('<option>').val('0').text('$0').appendTo(selectDeductible);
                    $('<option>').val('50').text('$50').appendTo(selectDeductible);
                    $('<option>').val('100').text('$100').appendTo(selectDeductible);
                    $('<option>').val('200').text('$200').appendTo(selectDeductible);
                    $('<option>').val('Platinum').text('Platinum').appendTo(selectType);
                    $('<option>').val('Gold').text('Gold').appendTo(selectType);
                    $('<option>').val('Silver').text('Silver').appendTo(selectType);
                    $('<option>').val('Powertrain').text('Powertrain').appendTo(selectType);
                    break;
            default: $('<option>').val(0).text(0).appendTo(selectTerm); 
                    $('<option>').val(0).text(0).appendTo(selectDeductible);
                    $('<option>').val('None').text('None').appendTo(selectType);
                    break;
        
    }
}

function createSelect(product){
    var selectTermModified = $('#TermModified');
    var selectDeductibleModified = $('#DeductibleModified');
    var selectTypeModified = $('#TypeModified');

    // Removes previous options loaded
    $('#TermModified option').remove();
    $('#DeductibleModified option').remove();
    $('#TypeModified option').remove();
    var option = product.trim();

    switch(option){
        case 'Total Lost Protection (GAP)': 
                 $('<option>').val('60').text('60').appendTo(selectTermModified); 
                 $('<option>').val('72').text('72').appendTo(selectTermModified); 
                 $('<option>').val('84').text('84').appendTo(selectTermModified);
                 $('<option>').val(0).text('None').appendTo(selectDeductibleModified);
                 $('<option>').val('None').text('None').appendTo(selectTypeModified);
                 break;
        case 'US Key': 
                    $('<option>').val('12').text('12').appendTo(selectTermModified); 
                    $('<option>').val('24').text('24').appendTo(selectTermModified); 
                    $('<option>').val('36').text('36').appendTo(selectTermModified);
                    $('<option>').val('48').text('48').appendTo(selectTermModified); 
                    $('<option>').val('60').text('60').appendTo(selectTermModified);
                    $('<option>').val(0).text('None').appendTo(selectDeductibleModified);
                    $('<option>').val('None').text('None').appendTo(selectTypeModified);
                    break;
        case 'Maintenance Plan':
                    $('<option>').val('12').text('12').appendTo(selectTermModified); 
                    $('<option>').val('24').text('24').appendTo(selectTermModified); 
                    $('<option>').val('36').text('36').appendTo(selectTermModified);
                    $('<option>').val('39').text('39').appendTo(selectTermModified);
                    $('<option>').val('48').text('48').appendTo(selectTermModified); 
                    $('<option>').val('60').text('60').appendTo(selectTermModified);
                    $('<option>').val(0).text('None').appendTo(selectDeductibleModified);
                    $('<option>').val('None').text('None').appendTo(selectTypeModified);
                    break;
        case 'Road Hazard':
                    $('<option>').val('36').text('36').appendTo(selectTermModified);
                    $('<option>').val('60').text('60').appendTo(selectTermModified);
                    $('<option>').val('0').text('0').appendTo(selectDeductibleModified);
                    $('<option>').val('None').text('None').appendTo(selectTypeModified);
                    break;
        case 'Vehicle Service Contract': 
                    $('<option>').val('6').text('6').appendTo(selectTermModified); 
                    $('<option>').val('12').text('12').appendTo(selectTermModified); 
                    $('<option>').val('24').text('24').appendTo(selectTermModified); 
                    $('<option>').val('36').text('36').appendTo(selectTermModified);
                    $('<option>').val('48').text('48').appendTo(selectTermModified); 
                    $('<option>').val('0').text('$0').appendTo(selectDeductibleModified);
                    $('<option>').val('50').text('$50').appendTo(selectDeductibleModified);
                    $('<option>').val('100').text('$100').appendTo(selectDeductibleModified);
                    $('<option>').val('200').text('$200').appendTo(selectDeductibleModified);
                    $('<option>').val('Platinum').text('Platinum').appendTo(selectTypeModified);
                    $('<option>').val('Gold').text('Gold').appendTo(selectTypeModified);
                    $('<option>').val('Silver').text('Silver').appendTo(selectTypeModified);
                    $('<option>').val('Powertrain').text('Powertrain').appendTo(selectTypeModified);
                    break;
            default: 
                    $('<option>').val(0).text('None').appendTo(selectTermModified); 
                    $('<option>').val(0).text('None').appendTo(selectDeductibleModified);
                    $('<option>').val('None').text('None').appendTo(selectTypeModified);
                    break;
        
    }
}

$('#saveProduct').click(function () {
    var UseTypeValue;
    var UseDeductibleValue;
    var UseTermValue;
    var UseVehiclePlanValue;
    var UsingWebServiceInfo;
    var BrochureValue;
    var ProductNameValue;
    var TypeValue;
    var TermValue;
    var DeductibleValue;
    var selectedTab = $('ul#optionsCostPrice li.active').text();
    var rangePricingValue;

    switch(selectedTab){
        case 'Manual':  var SellingPrice = $('#sellingPrice').val().replace('$','');
                        var Cost = $('#cost').val().replace('$','');
                        SellingPrice = GetFloat(SellingPrice);
                        Cost = GetFloat(Cost);
                        UsingWebServiceInfo = 0;
                        TypeValue = null;
                        TermValue = null;
                        DeductibleValue = null; 

                        if ( !$('#useManualPricing').prop("checked") ) {
                           if ( !($('#cost').val()) || !($('#sellingPrice').val()) ) {
                               return false;
                           }

                           if (!ValidateExpression(Cost,'Money')) { 
                               $('#cost').focus();           
                               toastr.error('Invalid cost format', "Message");
                               return false;
                           };

                           if (!ValidateExpression(SellingPrice,'Money')) {
                               $('#sellingPrice').focus();            
                               toastr.error('Invalid selling price format', "Message");
                               return false;
                           };
                        }
                       
                       break;
        case 'Web Service': var SellingPrice = 0;
                            var Cost = 0;
                            SellingPrice = GetFloat(SellingPrice);
                            Cost = GetFloat(Cost); 
                            UsingWebServiceInfo = 1;
                            TermValue = $('#Term').val();
                            DeductibleValue = $('#Deductible').val(); 

                            if ( $('#UseType').prop("checked") ) {
                                UseTypeValue = 1;
                            } else {
                                UseTypeValue = 0;
                            }

                            if ( $('#UseTerm').prop("checked") ) {
                                UseTermValue = 1;
                            } else {
                                UseTermValue = 0;
                            }

                            if ( $('#UseDeductible').prop("checked") ) {
                                UseDeductibleValue = 1;
                            } else {    
                                UseDeductibleValue = 0;
                            }

                            if ( $('#UseVehiclePlan').prop("checked") ) {
                                UseVehiclePlanValue = 1;
                            } else {    
                                UseVehiclePlanValue = 0;
                            }

                            break;
    }

    if ( $('#useManualPricing').prop("checked") ) {
        var SellingPrice = 0;
        var Cost = 0;
        SellingPrice = GetFloat(SellingPrice);
        Cost = GetFloat(Cost);
        UsingWebServiceInfo = 0;
        TypeValue = null;
        TermValue = null;
        DeductibleValue = null;
        rangePricingValue = '1';
    } else {
        rangePricingValue = '0';
    }

    if ( !($('#displayName').val()) || !($('#ProductDescription').val()) )  {
        toastr.error('Please fill all the fields', "Message");
        return false;
    }

    if ( $('#useManualPricing').prop("checked") ) {
        typeValue = $('#TypeRange').val();
    } else {
        TypeValue = $('#Type').val();
    }

    if ( SellingPrice < 0 && Cost < 0 ) {
        toastr.error('The cost and selling price must be positive numbers', "Message");
        return false;
    }

    if ($("input[name=mediaType]:checked").val() == 'VideoURL') {
        if (validateVideoURL($('#urlVideo').val())) {
            BrochureValue = $('#urlVideo').val();          
        }
        else{
            $('#urlVideo').focus();
            toastr.error('Invalid URL', "Message");
            return false;
        }
    }

    $.blockUI();
    $.ajax({
        type: "GET",
        url: "addProduct",
        data: {
            ProductBaseId: $('#ProductName').val(),
            ProductName: $('#ProductName option:selected').text(),
            CompanyId: $('#CompanyId').val(),
            displayName: $('#displayName').val(),
            ProductDescription: $('#ProductDescription').val(),
            Term: TermValue,
            Deductible: DeductibleValue,
            VehiclePlan: $('#VehiclePlan').val(),
            Type: TypeValue,
            bulletPoint1: $('#bulletPoint1').val(),
            bulletPoint2: $('#bulletPoint2').val(),
            bulletPoint3: $('#bulletPoint3').val(),
            bulletPoint4: $('#bulletPoint4').val(),
            bulletPoint5: $('#bulletPoint5').val(),
            disclaimer: $('#disclaimer').val(),
            cost: Cost,
            sellingPrice: SellingPrice,
            UsingWebService: UsingWebServiceInfo,
            UseType: UseTypeValue,
            UseTerm: UseTermValue,
            rangePricing: rangePricingValue,
            PricingArray: dataPrices,
            UseDeductible: UseDeductibleValue,
            UseVehiclePlan: UseVehiclePlanValue,
            BrochureImage: BrochureValue,
            BrochureHeight: $('#BrochureHeight').val(),
            BrochureWidth: $('#BrochureWidth').val()
        },
        success: function (idSaved) {
            $.unblockUI();
           if(idSaved>0)
                msg = "The product has been added";

            retrieveListProducts();
            resetInputs();
            loadCompanyProducts(1, 'addLabel');
            toastr.success("The product has been added", "Success");
            saveDocument(idSaved, function(callback){
                if(callback==true)
                {
                    setTimeout(function(){
                       window.location.href = 'settings-page';
                    }, 2000);      
                }
            });
        },
        failure: function (idSaved) {
            $.unblockUI();
            toastr.error('Error, try again', "Message"); 
            
        }
    });
});

$("body").on("click", "a", function (event) {
    globalProductId = $(this).attr('name');
});

function resetFields() {
    $('#productNameModified').val('');
    $('#displayNameModified').val('');
    $('#ProductDescriptionModified').val(''),
    $('#disclaimerModified').val('');
    $('#costModified').val('');
    $('#sellingPriceModified').val('');
    $('#bulletPoint1Modified').val('');
    $('#bulletPoint2Modified').val('');
    $('#bulletPoint3Modified').val('');
    $('#bulletPoint4Modified').val('');
    $('#bulletPoint5Modified').val('');
    $('#urlVideoModified').val('');
}

function resetInputs(){
    $('#productName1').val('');
    $('#displayName').val('');
    $('#ProductDescription').val(''),
    $('#cost').val('');
    $('#sellingPrice').val('');
    $('#bulletPoint1').val('');
    $('#bulletPoint2').val('');
    $('#bulletPoint3').val('');
    $('#bulletPoint4').val('');
    $('#bulletPoint5').val('');
    $('#urlVideo').val('');
    $('#BrochureImageRefer').val('');
    $('#BrochureHeight').val('');
    $('#BrochureWidth').val('');
}

function retrieveListProducts() {
    $.ajax({
        delay: 0,
        type: "GET",
        url: "getTable",
        success: onProductsLoad,
        failure: function (msg) {
            toastr.error('Table could not be loaded', "Message");
        }
    });
}

function onProductsLoad(result) {
    $('#productsTable').html(result);

    $('#productsTable').delegate(':checkbox', 'click', function () {
        var id = $(this).attr('id');
        if (!$(this).prop("checked")) {
            deleteProduct(id);

        } else {
            insertProduct(id);
        }
        setTimeout(function () {
            //retrieveListProducts();
            FillSortableTable();
        }, 1000);
    });

    $('#productsTable').delegate(':button', 'click', function () {
        var id = $(this).attr('value');
        removeProduct(id);

        setTimeout(function () {
            retrieveListProducts();
            FillSortableTable();
        }, 1000);
    });
}

function removeProduct(idProduct) {
    $.ajax({
        type: "GET",
        url: "removeProduct",
        data: {
            ProductId: idProduct
        },
        success: function (msg) {
            toastr.success("The product has been deleted", "Success");
        },
        failure: function (msg) {
            toastr.error('Product could not be removed' , "Message");
        }
    });
}

function deleteProduct(idProduct) {
    $.ajax({
        type: "GET",
        url: "deleteProduct",
        data: {
            id: idProduct
        },
        success: function (msg) {

        },
        failure: function (msg) {
            toastr.error('Table could not be loaded', "Message");
        }
    });
}

function insertProduct(idProduct) {
    $.ajax({
        type: "GET",
        url: "insertProduct",
        data: {
            id: idProduct
        },
        success: function (msg) {

        },
        failure: function (msg) {
            toastr.error('Table could not be loaded', "Message");
        }
    });
}

function FillSortableTable() {
    $.ajax({
        delay: 0,
        type: "GET",
        url: "getSortableTable",
        success: function (msg) {
            $('#SortableTable').html
          (
              msg
          );
            Sortable();
        },
        failure: function (msg) {
            toastr.error('Table could not be loaded', "Message");
        }
    });
}

function Sortable() {
    $(function () {
        $(".sortable").sortable({
            placeholder: "highlight",
            helper: "clone",
            stop: function (event, ui) {
                 Globalorder = $(".sortable").sortable('toArray');
                 UpdatetOrderTable(Globalorder);
                 toastr.success("The product order has been updated", "Success");
            }
        });
        $(".sortable").disableSelection();
    });
}

function UpdatetOrderTable(Order) {
    for (var i = 0; i < Order.length; i++) {
        OrderProduct = i + 1;
        $.ajax({
            delay: 0,
            type: "GET",
            url: "updateOrderProducts",
            data: {
                Order: OrderProduct,
                ProductId: Order[i],
                PlansId: 1
            },
            success: function (msg) {
            },
            failure: function (msg) {
                toastr.error('A error has ocurred', "Message");
            }
        });
    }
}

$('#updateInfo').click(function () {
    var UsingWebServiceInfo;
    var UseTypeValue;
    var UseDeductibleValue;
    var UseTermValue;
    var UseVehiclePlanValue;
    var BrochureValue;
    var selectedTab = $('ul#optionsCostPrice li.active').text();
    var SellingPrice = $('#sellingPriceModified').val().replace('$','');
    var Cost = $('#costModified').val().replace('$','');
    var typeValue;

    $('#videoOptionModified').hide();
    $('#brochureOptionModified').show();

    switch(selectedTab){
        case 'Manual':  
                        if ( !$('#useManualPricing').prop("checked") ) {
                           if ( !($('#costModified').val()) || !($('#sellingPriceModified').val()) ) {
                               toastr.error('Please fill the cost and price fields', "Message");
                               return false;
                           }

                           if ( SellingPrice < 0 && Cost < 0 ) {
                               toastr.error('The cost and selling price must be positive numbers', "Message");
                               return false;
                           }
                           
                           if (!ValidateExpression(Cost,'Money')) { 
                               $('#costModified').focus();           
                               toastr.error('Invalid cost format', "Message");
                               return false;
                           };
                        
                          if (!ValidateExpression(SellingPrice,'Money')) {
                              $('#sellingPriceModified').focus();            
                              toastr.error('Invalid selling price format', "Message");
                              return false;
                          };

                          SellingPrice = GetFloat(SellingPrice);
                          Cost = GetFloat(Cost);  
                       } 
                       break;
    }

    if ( !($('#displayNameModified').val()) || !($('#ProductDescriptionModified').val()) )  {
        toastr.error('Please fill all the fields', "Message");
        return false;
    }

    if ( $('#useManualPricing').prop("checked") ) {
        var SellingPrice = 0;
        var Cost = 0;
        SellingPrice = GetFloat(SellingPrice);
        Cost = GetFloat(Cost);
        UsingWebServiceInfo = 0;
        TypeValue = null;
        TermValue = null;
        DeductibleValue = null;
        rangePricingValue = '1';
    } else {
        rangePricingValue = '0';
    }

    if ( $('#useManualPricing').prop("checked") ) {
        typeValue = $('#TypeRange').val();
    } else {
        typeValue = $('#TypeModified').val();
    }

    if ( $('#useWS').prop("checked") ){
        UsingWebServiceInfo = 1;
        rangePricingValue = '0';
    } else {
        UsingWebServiceInfo = 0;
    }

    if ( $('#UseTypeModified').prop("checked") ) {
        UseTypeValue = 1;
    } else {
        UseTypeValue = 0;
    }

    if ( $('#UseTermModified').prop("checked") ) {
        UseTermValue = 1;
    } else {
        UseTermValue = 0;
    }

    if ( $('#UseDeductibleModified').prop("checked") ) {
        UseDeductibleValue = 1;
    } else {    
        UseDeductibleValue = 0;
    }

    if ( $('#UseVehiclePlanModified').prop("checked") ) {
        UseVehiclePlanValue = 1;
    } else {    
        UseVehiclePlanValue = 0;
    }

    if ($("input[name=mediaTypeModified]:checked").val() == 'VideoURL') {
        if (validateVideoURL($('#urlVideoModified').val())) {
            BrochureValue = $('#urlVideoModified').val();          
        }
        else{
            $('#urlVideoModified').focus();
            toastr.error('Invalid URL', "Message");
            return false;
        }
    } else {
        BrochureValue = $('#BrochureImageData').val();
    }

    $.blockUI();
    $.ajax({
        type: "GET",
        url: "updateProduct",
        data: {
            ProductId : $('#idModified').val(),
            rangePricing : rangePricingValue,
            PricingArray: dataPrices,
            ProductBaseId: $('#productNameModified').val(),
            ProductName: $('#productNameModified option:selected').text(),
            displayName: $('#displayNameModified').val(),
            ProductDescription: $('#ProductDescriptionModified').val(),
            Term: $('#TermModified').val(),
            Deductible: $('#DeductibleModified').val(),
            VehiclePlan: $('#VehiclePlanModified').val(),
            Type: typeValue,
            bulletPoint1: $('#bulletPoint1Modified').val(),
            bulletPoint2: $('#bulletPoint2Modified').val(),
            bulletPoint3: $('#bulletPoint3Modified').val(),
            bulletPoint4: $('#bulletPoint4Modified').val(),
            bulletPoint5: $('#bulletPoint5Modified').val(),
            disclaimer: $('#disclaimerModified').val(),
            cost: Cost,
            UsingWebService: UsingWebServiceInfo,
            sellingPrice: SellingPrice,
            UseType: UseTypeValue,
            UseTerm: UseTermValue,
            UseDeductible: UseDeductibleValue,
            UseVehiclePlan: UseVehiclePlanValue,
            BrochureHeight: $('#BrochureHeightModified').val(),
            BrochureWidth: $('#BrochureWidthModified').val(),
            BrochureImage: BrochureValue            
        },
        success: function (msg) {
             $.unblockUI();
            toastr.success("The product has been updated", "Success"); 
            retrieveListProducts();
            uploadModifiedData(function(callback){
                if(callback==true)
                {
                    setTimeout(function(){
                       window.location.href = 'settings-page';
                    }, 2000);
                }
            });
        },
        failure: function (msg) {
            $.unblockUI();
        }
    });
});

function populateCompanyList() {
    $.ajax({
        delay: 0,
        type: "GET",
        url: "populateCompanyList",
        success: function (msg) {

            $('#CompanyList').html
            (
                msg
            );
        },
        failure: function (msg) {
            toastr.error('Company List could not be loaded', "Message");
        }
    });
}

$('#saveCompany').click(function () {
    $.ajax({
        type: "GET",
        url: "createCompany",
        data: {
            CompanyName: $('#CompanyName').val(),
            URL: $('#URL').val(),
            Username: $('#Username').val(),
            Password: $('#Password').val()
        },
        success: function (msg) {
            populateCompanyList();
            $('#myModal').modal('show');
            $('#CompanyName').val('');
            $('#companyModal').modal('hide');
        }
    });
});

$('#cancelCompany').click(function () {
    $('#CompanyName').val('');
    $('#companyModal').modal('hide');
    $('#myModal').modal('show');
});

function checkWebService(){
    var FailWebService = parseInt($('#FailWebService').val());
    if (FailWebService == 1) {
        toastr.error('Conection refused! try again', "Message");
    };
}

function calculatePlans() {
    var FinancedAmountOrigin = GetFloat($("#FinancedAmountHidden").text());
    var Apr = GetFloat($("#AprHidden").text());
    var Term = GetFloat($("#TermHidden").text());
    Apr = Apr/100;
    var APR12 = Apr/12;
    
    var A = Math.pow(1 + APR12, Term);
    var B = 1 -(1/A);
    var C = FinancedAmountOrigin * APR12; 

    /* calculate cost for SPAN BACK*/
    var ASpan = Math.pow(1 + APR12, (Term+12));
    var BSpan = 1 -(1/ASpan);

      /*  calculo base payment   */
    var BasePayment = (C/B).toFixed(2);
    if (isNaN(BasePayment)) {
        $("#BasePaymentHidden").text('0.00');
    } else{
        $("#BasePaymentHidden").text(BasePayment);
    };
    

    var groupPremium = document.getElementsByName('Premium');

    var sumPremium = 0.00;
    for (var i = 0; i < groupPremium.length; i++) {
        if (groupPremium[i].checked == true) {
             sumPremium = sumPremium + GetFloat(groupPremium[i].value);
            
        }
    }

    C = (FinancedAmountOrigin + sumPremium)  * APR12;   
    premium = (C/B).toFixed(2);
    premiumSpan = (C/BSpan).toFixed(2);
    additionalPremium = (premium - BasePayment).toFixed(2);
    costdayPremium = (additionalPremium / 30).toFixed(2);

    if (isNaN(premium) && isNaN(additionalPremium)  && isNaN(costdayPremium)) {
        $('#MonthlyPremium').text('0.00');
        $('#AdditionalPremium').text('0.00');
        $('#CostDayPremium').text('0.00');
        $('#SpanPaymentPremium').text('0.00');
        $('#SpanPaymentPremium2').text('0.00');
    } else{
        $('#MonthlyPremium').text(premium);
        $('#SpanPaymentPremium').text(premium);
        $('#SpanPaymentPremium2').text(premiumSpan);
        $('#AdditionalPremium').text(additionalPremium);
        $('#CostDayPremium').text(costdayPremium);
    };
        

    // Preferred
    var groupPreferred = document.getElementsByName('Preferred');

    var sumPreferred = 0.00;
    for (var i = 0; i < groupPreferred.length; i++) {
        if (groupPreferred[i].checked == true) {
            sumPreferred = sumPreferred + GetFloat(groupPreferred[i].value);
        }
    }

    C = (FinancedAmountOrigin + sumPreferred)  * APR12;   
    preferred = (C/B).toFixed(2);
    preferredSpan = (C/BSpan).toFixed(2);
    additionalPreferred = (preferred - BasePayment).toFixed(2);
    costdayPreferred = (additionalPreferred / 30).toFixed(2);
    
    if (isNaN(preferred) && isNaN(additionalPreferred) && isNaN(costdayPreferred)) {
        $('#MonthlyPreferred').text('0.00');
        $('#AdditionalPreferred').text('0.00');
        $('#CostDayPreferred').text('0.00');
        $('#SpanPaymentPreferred').text('0.00');
        $('#SpanPaymentPreferred2').text('0.00');

    } else{
        $('#MonthlyPreferred').text(preferred);
        $('#SpanPaymentPreferred').text(preferred);
        $('#SpanPaymentPreferred2').text(preferredSpan);
        $('#AdditionalPreferred').text(additionalPreferred);
        $('#CostDayPreferred').text(costdayPreferred);
    };
    // Economy
    var groupEconomy = document.getElementsByName('Economy');

    var sumEconomy = 0.00;
    for (var i = 0; i < groupEconomy.length; i++) {
        if (groupEconomy[i].checked == true) {
            sumEconomy = sumEconomy + GetFloat(groupEconomy[i].value);
        }
    }

    C = (FinancedAmountOrigin + sumEconomy)  * APR12;   
    economy = (C/B).toFixed(2);
    economySpan = (C/BSpan).toFixed(2);    
    additionalEconomy = (economy - BasePayment).toFixed(2);
    costdayEconomy = (additionalEconomy / 30).toFixed(2);

    if (isNaN(economy) && isNaN(additionalEconomy) && isNaN(costdayEconomy)) {
        $('#MonthlyEconomy').text('0.00');
        $('#AdditionalEconomy').text('0.00');
        $('#CostDayEconomy').text('0.00');
        $('#SpanPaymentEconomy').text('0.00');
        $('#SpanPaymentEconomy2').text('0.00');
        
    } else{
        $('#MonthlyEconomy').text(economy);
        $('#SpanPaymentEconomy').text(economy);
        $('#SpanPaymentEconomy2').text(economySpan);        
        $('#AdditionalEconomy').text(additionalEconomy);
        $('#CostDayEconomy').text(costdayEconomy);
    };
    
    // Basic
    var groupBasic = document.getElementsByName('Basic');

    var sumBasic = 0.00;
    for (var i = 0; i < groupBasic.length; i++) {
        if (groupBasic[i].checked == true) {
            sumBasic = sumBasic + GetFloat(groupBasic[i].value);
        }
    }

    C = (FinancedAmountOrigin + sumBasic)  * APR12;   
    basic = (C/B).toFixed(2);
    basicSpan = (C/BSpan).toFixed(2);
    additionalBasic = (basic - BasePayment).toFixed(2);
    costdayBasic = (additionalBasic / 30).toFixed(2);

    if (isNaN(basic) && isNaN(additionalBasic) && isNaN(costdayBasic)) {
        $('#MonthlyBasic').text('0.00');
        $('#AdditionalBasic').text('0.00');
        $('#CostDayBasic').text('0.00');
        $('#SpanPaymentBasic').text('0.00');
        $('#SpanPaymentBasic2').text('0.00');        
    } else{
        $('#MonthlyBasic').text(basic);
        $('#SpanPaymentBasic').text(basic);
        $('#SpanPaymentBasic2').text(basicSpan);
        $('#AdditionalBasic').text(additionalBasic);
        $('#CostDayBasic').text(costdayBasic);
    };
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

$("#ButtonNext").click(function () {
    DefineId(GlobalPlanChoosed);
    var text = $("#ModelValidate").html();
    DefineId(GlobalPlanChoosed)
    if (ValidationEmptyDeal ()) {
        return false;
    };
});

function GetIdProducts(id) {
    var i = 0;
    GlobalAccepted = [];
    OrderNumberAccepted = [];
    OrderNumberRejected = [];
    GlobalRejected = [];
    GlobalAcceptedPrice = [];
    GlobalRejectedPrice = [];

    
    $("#" + id + " :checkbox").each(function () {
        var checkbox = $(this);
        if (!checkbox.prop("checked")) {
            GlobalRejected[i] = $(this).attr('id');
            GlobalRejectedPrice[i] = $(this).val();
            GlobalRejectedPrice[i] = GlobalRejectedPrice[i].replace(',','');
            OrderNumberRejected[i] = $(this).attr('OrderNumber');
            

        } else {
            GlobalAccepted[i] = $(this).attr('id');
            GlobalAcceptedPrice[i] = $(this).val();
            GlobalAcceptedPrice[i] = GlobalAcceptedPrice[i].replace(',','');
            OrderNumberAccepted[i] = $(this).attr('OrderNumber');
        }
        i = i + 1;
    });
    $("#1 :checkbox").each(function () {
        var idToEval = $(this).attr('id');
        var ValidateAccepted = GlobalAccepted.indexOf(idToEval);
        var ValidateRejected = GlobalRejected.indexOf(idToEval);

        if ((ValidateAccepted >= 0) || (ValidateRejected >= 0)) {            
        } else{
            GlobalRejected[i] = idToEval;
            GlobalRejectedPrice[i] = $(this).val();
            GlobalRejectedPrice[i] = GlobalRejectedPrice[i].replace(',','');
        };
        i = i + 1;
    });

    OrderNumberAccepted = $.grep(OrderNumberAccepted, function (n) { return (n) });
    OrderNumberRejected = $.grep(OrderNumberRejected, function (n) { return (n) });
    GlobalAccepted = $.grep(GlobalAccepted, function (n) { return (n) });
    GlobalRejected = $.grep(GlobalRejected, function (n) { return (n) });
    GlobalAcceptedPrice = $.grep(GlobalAcceptedPrice, function (n) { return (n) });
    GlobalRejectedPrice = $.grep(GlobalRejectedPrice, function (n) { return (n) });
    $("#HiddenAccepted").val(GlobalAccepted.toString());
    $("#HiddenRejected").val(GlobalRejected.toString());



    $("#HiddenOrderAccepted").val(OrderNumberAccepted.toString());
    $("#HiddenOrderRejected").val(OrderNumberRejected.toString());

    $("#HiddenAcceptedPrice").val(GlobalAcceptedPrice.toString());    
    $("#HiddenRejectedPrice").val(GlobalRejectedPrice.toString());
    
    $("#CostPerDayFinance").val($("#" + id + " .CostDay").text());
    $("#AdditionalPaymentFinance").val($("#" + id + " .Additional").text());
    $("#MonthlyPaymentFinance").val($("#" + id + " .Monthly").text());
    
}

$(':checkbox').click(function (event) {
    checkName = $(this).attr('name');
    GlobalCkeckboxClicked = $(this);
    var id = $(this).parent().parent().parent().attr('id');

console.log('entrando aqui');

    switch (checkName) {
        case 'Accepted': value = $(this).val();
            $(this).prop("checked", true);
             $(this).attr('name', 'Rejected');
            $('#AcceptedTable #' + id).detach().appendTo('#RejectedTable');
             break;

        case 'Rejected': value = $(this).val();
            $(this).attr('name', 'Accepted');
            $('#RejectedTable #' + id).detach().appendTo('#AcceptedTable');
            $(this).prop("checked", false);            
            break;
    }
   
    CalculateTotalCheckbox();
    $('#AcceptedTable .products').each(function () {
        $(this).find('.price-product').text('');
        $(this).find('.price-product').append('');
    });           
        
});


// $("#exportpdf").click(function() {
//      UpdateArray();            
// })

// function UpdateArray () {

//     var Accepted2 = [];
//     var Rejected2 = [];
//     var CostByProduct = [];
//     var CostByDayArray = new Array();
//     var index = 0;
//     $("#AcceptedTable :checkbox").each(function () {
//         antonio = $(this).parent().parent().parent();
//         Accepted2[index] = $(this).parent().parent().parent().attr('id');
//         index = index + 1;
//     });
//     index = 0;
//     $("#RejectedTable :checkbox").each(function () {
//         CostByProduct[index]  = $(this).parent().parent().parent().find('.price-product').text().trim();
//         Rejected2[index] = $(this).parent().parent().parent().attr('id');
//         index = index + 1;
//     });
//     $("#acceptedarray").val(Accepted2);
//     $("#rejectedarray").val(Rejected2);
//     $('#costbydayarray').val(CostByProduct);
// }


function CalculateTotalCheckbox() {
    var total1 = 0.00;
    var total2 = 0.00;
    var TotalCostRejectedDay = 0.00;
    var TotalCostRejectedMonth = 0.00;

    var FinancedAmountOrigin = GetFloat($("#FinancedAmountHidden").text());
    var Apr = GetFloat($("#AprHidden").text());
    var Term = GetFloat($("#TermHidden").text());

    Apr = Apr/100;
    var APR12 = Apr/12;
    
    var A = Math.pow(1 + APR12, Term);
    var B = 1 -(1/A);
    var C = FinancedAmountOrigin * APR12;

    var BasePayment = (C/B).toFixed(2);
    if (isNaN(BasePayment)) {
        $("#BasePaymentHidden").text('0.00');
    } else{
        $("#BasePaymentHidden").text(BasePayment);
    };

    var monthpaymentAccepted = 0.00;
    var additionalpaymentAccepted = 0.00;
    var costdayAccepted = 0.00;

    var monthpaymentRejected = 0.00;
    var additionalpaymentRejected = 0.00;
    var costdayRejected = 0.00;

    $("#AcceptedTable :checkbox").each(function () {
        value = $(this).val();
        total1 = total1 + GetFloat(value);
        
    });

    C = (FinancedAmountOrigin + total1)  * APR12;
    monthpaymentAccepted  = (C/B).toFixed(2);
    additionalpaymentAccepted  = (monthpaymentAccepted  - BasePayment).toFixed(2);
    costdayAccepted  = (additionalpaymentAccepted  / 30).toFixed(2);     

    $('#RejectedTable .products').each(function () {
        monthpaymentRejected = 0.00;
        additionalpaymentRejected = 0.00;
        costdayRejected = 0.00;

        value = $(this).find(':checkbox').val();
        total2 = GetFloat(value);

        C = (FinancedAmountOrigin + total2)  * APR12;
        monthpaymentRejected = (C/B);
        additionalpaymentRejected = (monthpaymentRejected - BasePayment);
        costdayRejected = (additionalpaymentRejected / 30);

        TotalCostRejectedMonth = TotalCostRejectedMonth + additionalpaymentRejected;
        TotalCostRejectedDay = TotalCostRejectedDay + costdayRejected;

        costdayRejected = costdayRejected.toFixed(2);
        additionalpaymentRejected = additionalpaymentRejected.toFixed(2);
        
        labelDay = '  $'+costdayRejected+'/Day'; 
        labelMonth = '  $'+additionalpaymentRejected+'/MTH'; 
        $(this).find('.price-product').text(labelDay);
        $(this).find('.price-product').append(labelMonth);
        
    });

    TotalCostRejectedMonth = TotalCostRejectedMonth.toFixed(2);
    TotalCostRejectedDay = TotalCostRejectedDay.toFixed(2);
    
     $("#TotalAccepted").text(monthpaymentAccepted);  
     $("#TotalRejected").text(TotalCostRejectedDay);
     $("#TotalPayment").text(TotalCostRejectedMonth);

          //Save to PDF
    $("#CostPerDay").val(TotalCostRejectedDay);
    $("#UpdatedPayment").val(monthpaymentAccepted);
    $("#AdditionalPayment").val(TotalCostRejectedMonth);
}

$("#SaveConfig").click(function (event) {
    // $("#AcceptedTable .PdfContract").each(function () {
    //       $(this).click();
    //       var href = $(this).attr("href"); 
    //       window.open(href, '_blank');
    //  });
    // $("#RejectedTable .PdfContract").each(function () {
    //       $(this).hide();
    //  });
    // toastr.success('Pdf contract is available', "Message");
    products = new Array();

    $("#AcceptedTable section").each(function () {
            product = new Object();
            product.ID = $(this).attr('name');
            product.OrderNumber = $(this).find(':checkbox').attr('OrderNumber');
            product.Amount = GetFloat($(this).find(':checkbox').val());
            products.push(product);
    });    
    products = JSON.stringify(products);
    SavetoDMS(products);

});

function SavetoDMS (products) {
    $.ajax({
      type: "GET",
      url: "SavetoDMS",
      data:{
        products : products
      },
      success: function (msg) {
        try {
          var jsonObject = JSON.parse(msg);
          SendToDMS(msg);
        }catch(e){
              toastr.error(msg, "Message");
        }
        
      },
      failure: function (msg) {
        toastr.error('error', "Message");
      }
   }); 
}

function SendToDMS (data) {
    var url  = "http://webservice.automatrix.co/api/deal/";
    $.ajax({
        type: "PUT",
        url: url,
        //data: JSON.stringify(data),
        data: data,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(msg){
             toastr.success(msg, "Message");
        },
        failure: function(msg) {
            toastr.error('error', "Message");
        }
    });
}

$(document).on('change', 'select[id^="CompanyId"]', function () {
    $('#range').hide();
    loadCompanyProducts($(this).val(), 'addLabel');
});

$(document).on('change', 'select[id^="CompanyIdModified"]', function () {
    loadCompanyProducts($(this).val(), 'modifyLabel');
});

$(document).on('change', 'select[id^="ProductName"]', function () {
    $('#displayName').val($('#ProductName option:selected').text());
    if ($('#CompanyId option:selected').val() == 2) {
      createSelectProtectiveNew($('#ProductName option:selected').text());
      switch($('#ProductName option:selected').text()){
        case 'Vehicle Service Contract':  $('#VehiclePlanAddProduct').show(); $('#range').hide(); break;
        case 'Total Lost Protection (GAP)': $('#VehiclePlanAddProduct').hide(); $('#range').show(); break;
        default: $('#VehiclePlanAddProduct').hide(); $('#range').hide(); break;
      }
    } else {
      createSelectNew($('#ProductName option:selected').text());
    }
});

$(document).on('change', 'select[id^="productNameModified"]', function () {
    $('#displayNameModified').val($('#productNameModified option:selected').text());
    if ($('#CompanyIdModified option:selected').val() == 2) {
        createSelectProtectiveModified($('#productNameModified option:selected').text());
        switch($('#productNameModified option:selected').text()) {
            case 'Vehicle Service Contract': $('#VehiclePlanModifiedProduct').show(); $('#range').hide(); break;
            case 'Total Lost Protection (GAP)': $('#VehiclePlanModifiedProduct').hide(); $('#range').show();  break;
            default: $('#VehiclePlanModifiedProduct').hide(); $('#range').hide(); break;
        }
    } else {
        createSelect($('#productNameModified option:selected').text());
    }
});

$("#ProductName1").keyup(function () {
    $("#displayName").val($(this).val());
});

function loadCompanyProducts(companyId, typeSelected) {
     $('#productNameModified option').remove();
    $.ajax({
        delay: 0,
        type: "GET",
        url: "loadCompanyProducts",
        data: {
            CompanyId: companyId,
            type: typeSelected
        },
        success: function (msg) {
            if (typeSelected == 'addLabel') {
                $('#ProductsList').html
                 (
                     msg
                 );
            } else {
                $('#ProductsListModified').html
                 (
                     msg
                 ); 
            }
            option = $('#ProductName option').val();
            $('.check').val(option).trigger('change');
            $('#displayName').val($('#ProductName option:selected').text());
            if (companyId == 2) {
                createSelectProtectiveModified($('#productNameModified option:selected').text());
                createSelectProtectiveNew($('#ProductName option:selected').text());
                if ( $('#ProductName option:selected').text() == 'Total Lost Protection (GAP)' || $('#productNameModified option:selected').text() == 'Total Lost Protection (GAP)') {
                    $('#range').show();
                }
            } else {
                createSelect($('#productNameModified option:selected').text());
                createSelectNew($('#ProductName option:selected').text());
            }
        },
        failure: function (msg) {
            toastr.error('Company List could not be loaded', "Message");
        }
    });
}


$(".months").click(function () {
    var month = $(this).html();
});

/*add by MB*---------------------------------------------------------------------------------------------------------- */

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

function DefineId(num) {
    $("#ButtonNext").prop("disabled", false);
    var id = num;
    var id2 = num;
    GlobalPlanChoosed = num;
    $('#HiddenId').val(id);
    GetIdProducts(id2);
    $("#ButtonNext").focus();
}

$(".linkmodal1").on('click',function() {
    if (ValidationEmptyDeal ()) {
        return false;
    };

    GlobalValidatePage = $("#ValidatePage").val();
    
    flagBottonsModal = 1;
    GlobalSectionProduct = $(this).parent().parent();

    if (GlobalValidatePage == 0) {
        var SellingPrice = $(GlobalSectionProduct).find( '.price-product' ).text();    
    } else{
        var SellingPrice = $(GlobalSectionProduct).find( ':checkbox' ).val(); 
        SellingPrice = '$'+ GetFloat(SellingPrice);   
    };
    $("#PriceProduct").val(SellingPrice);   
    //RetrieveInfoProductModal(GlobalSectionProduct.attr('id'));
    var Type = $(GlobalSectionProduct).find( '.ProductType' ).attr('name');
    var Term = $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name');
    var Deductible = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    $('#TermFinance').val(Term);
    $('#DeductibleFinance').val(Deductible);
    $('#TypeFinance').val(Type);
    $('#ApplyChanges').prop('checked', true);

})
$(".linkmodal2").on('click',function() {
    flagBottonsModal = 1;

})

$( "#TypeFinance" ).change(function() {
    LoadOptionTypeOnSelect($('#TypeFinance :selected').text());
});

function LoadOptionTypeOnSelect(SelectedType) {

    var ArrayMileage = [];
    var selectMileage = document.getElementById("MileageFinance");
     selectMileage.options.length = 0;
     ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
      
         
    var ArrayTerm = [];
    var ArrayType = [];
    var selectTerm = document.getElementById("TermFinance");
    selectTerm.options.length = 0;
    var SelectedType = $('#TypeFinance :selected').val();
    
    idSave= GlobalSectionProduct.attr('id');
    eval("var countproductRates = Object.keys(productRates.product" + idSave + ").length;");
    for(var i = 0; i < countproductRates; i++) {
            eval("var obj = productRates.product" + idSave + "[i];");
            validate = ArrayTerm.indexOf(obj.Term);
            validate2 = ArrayMileage.indexOf(obj.Mileage);

            if (SelectedType == obj.Type) {
                if (validate < 0) {
                    ArrayTerm[i] = obj.Term; 
                    (selectTerm.options[selectTerm.options.length] = new Option(obj.Term, obj.SellingPrice)).setAttribute('OrderNumber',obj.OrderNumber);   

                };   
                 // only for GAP ---------------
                        if (ProductBaseId = 12) {
                            if (validate2 < 0) {
                                ArrayMileage[i] = obj.Mileage; 
                                selectMileage.options[selectMileage.options.length] = new Option(obj.Mileage, obj.Mileage);                                                       
                             };                            
                        }; 
                        
                     //--------------------------                 
             };               
   } 
   var SelectedTerm = $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name'); 
   ChangeTermOrder(SelectedTerm); 
   ChangeMileageOrder();        
}

$("#saveModal1").click(function () {
    var Type = $('#TypeFinance :selected').val();
    var Term = $('#TermFinance :selected').val(); 
    var TermText =  $('#TermFinance :selected').text();
    var OrderNumber = $('#TermFinance :selected').attr('OrderNumber');    
    var Deductible = $("#DeductibleFinance").val();
    var SellingPrice = $("#PriceProduct").val();
    var ValidatePrice = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    var ProductBaseType = $(GlobalSectionProduct).find( '.ProductBaseType' ).attr('name');
    SellingPrice = SellingPrice.replace('$','');

    if (!ValidateExpression(SellingPrice,'Money')) {            
            toastr.error('Invalid selling price format', "Message");
            return false;
    };
    SellingPrice = GetFloat(SellingPrice).toFixed(2); 

    if (ProductBaseType == 'GAP') {
        Term = $("#PriceProduct").val();
    };   
    if ($("#ApplyChanges").prop("checked")) {
            if ( ($("#PriceProduct").is(':visible')) || ($("#TermFinance").is(':visible')) ) {
                UpdatePriceAllColumns(SellingPrice); 
                if (GlobalValidatePrice == 1) {
                    UpdatePriceWebServicesProductAllColumns(Term);
                }            
                
            } 
            if (GlobalValidatePrice == 1) {
                    UpdateFieldsWebservicesProducts(Type,TermText,Deductible, OrderNumber);
            }   
                        
        } else { 
            if ( ($("#PriceProduct").is(':visible')) || ($("#TermFinance").is(':visible')) ) {
                $(GlobalSectionProduct).find( '.price-product' ).text('$'+ SellingPrice);
                $(GlobalSectionProduct).find(':checkbox').val(SellingPrice);              
                if (GlobalValidatePrice == 1) {
                    UpdatePriceWebServicesProduct(Term);                
                } 
            }
            if (GlobalValidatePrice == 1) {
                 $(GlobalSectionProduct).find( '.ProductType' ).attr('name', Type);
                 $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name', TermText);
                 $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name', Deductible); 
                 $(GlobalSectionProduct).find( ':checkbox' ).attr('OrderNumber', OrderNumber);  
            } 
                              
        }
    calculatePlans();
    $('#myModal1').modal('hide');
})

function UpdatePriceWebServicesProduct(term) {
    var term2 = GetFloat(term).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    if (GlobalValidatePrice == 1) {
        $(GlobalSectionProduct).find( '.price-product' ).text('$'+ term2);
        $(GlobalSectionProduct).find(':checkbox').val(term);
        // var Term = $('#TermFinance').val(); 
        // idSave= GlobalSectionProduct.attr('id'); 
        // eval("var countproductRates = Object.keys(productRates.product" + idSave + ").length;");  

        // for(var i = 0; i < countproductRates; i++) {
        //     eval("var obj = productRates.product" + idSave + "[i];");
        //      if (obj.Term == term) {
        //         $(GlobalSectionProduct).find( '.price-product' ).text('$'+ obj.SellingPrice);
        //         $(GlobalSectionProduct).find(':checkbox').val(obj.SellingPrice);
        //      }          
        // }                
    };
    
}
function UpdatePriceWebServicesProductAllColumns(term) {
    var term2 = GetFloat(term).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $(".products").each(function () {
                        idEvaluate = $(this).attr('id');
                        if (idEvaluate == idSave) {
                            $(this).find( '.price-product' ).text('$'+ term2);
                            $(this).find(':checkbox').val(term);
                        };        
     });            
}


function UpdatePriceAllColumns (price) {
    $(".products").each(function () {
        idEvaluate = $(this).attr('id');
        idSave= GlobalSectionProduct.attr('id');
        if (idEvaluate == idSave) {
            $(this).find( '.price-product' ).text('$'+ price);
            $(this).find(':checkbox').val(price);

        };        
    });
}

function UpdateFieldsWebservicesProducts (type, term, deductible, ordernumber) {
    $(".products").each(function () {
        idEvaluate = $(this).attr('id');
        idSave= GlobalSectionProduct.attr('id');
        if (idEvaluate == idSave) {
            console.debug(ordernumber);
           $(this).find( '.ProductType' ).attr('name', type);
           $(this).find( '.ProductTerm' ).attr('name', term);
           $(this).find( '.ProductDeductible' ).attr('name', deductible);
           $(this).find( ':checkbox' ).attr('OrderNumber', ordernumber); 

        };  

    });
}


function RetrieveInfoProductModal (id) {
     $.ajax({
        type: "GET",
        url: "infoProduct",
        data: {
            ProductId: id
        },
        success: function (msg) {
            var data = JSON.parse(msg);
            var sellingPrice = GetFloat(data[0].SellingPrice);
            if (GlobalValidatePrice == 0) {
                $(GlobalSectionProduct).find( '.price-product' ).text('$'+ sellingPrice.toFixed(2));
                $(GlobalSectionProduct).find(':checkbox').val(sellingPrice.toFixed(2));            
            };
            if (GlobalValidatePrice == 1) {
                if (GlobalValidatePage == 0) {
                    var SellingPrice = $(GlobalSectionProduct).find( '.ProductSellingPrice' ).attr('name');
                    $(GlobalSectionProduct).find('.price-product').text(SellingPrice);  
                    $(GlobalSectionProduct).find(':checkbox').val(SellingPrice);
                }
            };
            $(GlobalSectionProduct).find( '.ProductType' ).attr('name', data[0].Type);
            $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name', data[0].Term);
            $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name', data[0].Deductible);
            calculatePlans();
        
        },
        failure: function (msg) {
        }
    });
}

$("#ButtonReset").click(function () { 
    //$(this).find( 'i' ).addClass('fa-spin');
    //$(this).find( 'span' ).text(' Processing... ');
    if ($("#ApplyChanges").prop("checked")) {
            location.reload();    
    } else {    
           RetrieveInfoProductModal(GlobalSectionProduct.attr('id'));
    }
    
    $('#myModal1').modal('hide');    
})
/*END*/

$(".NotUsingWebService").on('click',function() {
    $('#ModalTerm').hide();
    $('#ModalDeductible').hide();
    $('#ModalType').hide();
    $('#ModalPrice').show();
    $('#ModalMileage').hide();
    GlobalValidatePrice = 0;
    
})
$(".UsingWebService").on('click',function() {
   
    var ShowType = $(GlobalSectionProduct).find( '.UseType' ).val();
    var ShowTerm = $(GlobalSectionProduct).find( '.UseTerm' ).val();
    var ShowDeductible = $(GlobalSectionProduct).find( '.UseDeductible' ).val();
    var ProductBaseType = $(GlobalSectionProduct).find( '.ProductBaseType' ).attr('name');

    LoadOptionTermOnSelect();

   if (ShowType == 0) {
        $('#ModalType').hide();
   } else{
        $('#ModalType').show();
   };
   if (ShowTerm == 0) {
        $('#ModalTerm').hide();
   } else{
        $('#ModalTerm').show();
   };
   if (ShowDeductible == 0) {
        $('#ModalDeductible').hide();
   } else{
        $('#ModalDeductible').show();   
   };
    $('#ModalPrice').hide();
    GlobalValidatePrice = 1;

    ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
    if (ProductBaseId == 12) {
        $('#ModalMileage').show();
    }else{
        $('#ModalMileage').hide();
    }

    if (ProductBaseId == 11) {
        $('#TermFinance').hide();
        $('#TermFinance2').show();
    }else{
        $('#TermFinance').show();
        $('#TermFinance2').hide();
    }

    if (ProductBaseType == 'GAP') {
         $('#ModalPrice').show();
     }else{
         $('#ModalPrice').hide();
     }
    
})

function LoadOptionTermOnSelect() {
      
    var ArrayTerm = [];
    var ArrayType = [];
    var ArrayMileage = [];
    var selectTerm = document.getElementById("TermFinance");
    selectTerm.options.length = 0;

    var selectType = document.getElementById("TypeFinance");
     selectType.options.length = 0;

    var selectMileage = document.getElementById("MileageFinance");
     selectMileage.options.length = 0;
    
    idSave= GlobalSectionProduct.attr('id');
    ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
    var SelectedTerm = $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name');
    var SelectedType = $(GlobalSectionProduct).find( '.ProductType' ).attr('name');
    var ProductBaseType = $(GlobalSectionProduct).find( '.ProductBaseType' ).attr('name');

    eval("var countproductRates = Object.keys(productRates.product" + idSave + ").length;");
    for(var i = 0; i < countproductRates; i++) {
            eval("var obj = productRates.product" + idSave + "[i];");
             validate = ArrayTerm.indexOf(obj.Term);
             validate2 = ArrayType.indexOf(obj.Type);
             validate3 = ArrayMileage.indexOf(obj.Mileage);

             if (validate2 < 0) {
                        ArrayType[i] = obj.Type;
                        (selectType.options[selectType.options.length] = new Option(obj.Type, obj.Type)).setAttribute('OrderNumber',obj.OrderNumber);;                 
             };
             if (SelectedType == 'none' || SelectedType == 'None'  ) {
                SelectedType =  obj.Type;
             }; 

             if (SelectedType == obj.Type) {
                                         
                     $("#TypeFinance option").filter(function() {
                           return $(this).text() == obj.Type; 
                        }).prop('selected', true);

                     if (validate < 0) {
                        ArrayTerm[i] = obj.Term; 
                        (selectTerm.options[selectTerm.options.length] = new Option(obj.Term, obj.SellingPrice)).setAttribute('OrderNumber', obj.OrderNumber);
                        //$('#TermFinance option').eq(0).attr('OrderNumber', obj.OrderNumber);                                              
                     };

                     // only for GAP ---------------
                        if (ProductBaseId = 12) {
                            if (validate3 < 0) {
                                ArrayMileage[i] = obj.Mileage; 
                                selectMileage.options[selectMileage.options.length] = new Option(obj.Mileage, obj.Mileage);                                                       
                             };                            
                        }; 
                        
                     //--------------------------
                     
             }; 

    }
    ChangeTermOrder(SelectedTerm); 
    ChangeMileageOrder();  
     
            
}
function ChangeTermOrder(SelectedTerm) {
    var options = $('#TermFinance option');
    var arr = options.map(function(_, o) {
        return {
            text: $(o).text(),
            value: o.value,
            order: $(o).attr('OrderNumber')
        };
    }).get();
    arr.sort(function(a, b) { return b.text - a.text; });

    var selectTerm = document.getElementById("TermFinance");
    selectTerm.options.length = 0;

    for (var i = 0; i < arr.length; i++) {
        (selectTerm.options[selectTerm.options.length] = new Option(arr[i].text, arr[i].value)).setAttribute('OrderNumber', arr[i].order);

        if (SelectedTerm == arr[i].text) {
            $("#TermFinance option").filter(function() {
            return $(this).text() == arr[i].text; 
            }).prop('selected', true);
        }; 
    };
}

function ChangeMileageOrder() {
    
    var options = $('#MileageFinance option');
    var arr = options.map(function(_, o) {
        return {
            text: $(o).text(),
            value: o.value
        };
    }).get();
    arr.sort(function(a, b) { return b.text - a.text; });

    var selectMileage = document.getElementById("MileageFinance");
    selectMileage.options.length = 0;

    for (var i = 0; i < arr.length; i++) {
        selectMileage.options[selectMileage.options.length] = new Option(arr[i].text, arr[i].value);
    };
    
}

$("#useManualPricing").click(function () {
     if ($(this).prop("checked")) {           
          $("#cost").prop('disabled', true);
          $("#costModified").prop('disabled', true);
          $("#costHidden").text($("#cost").val());
          $("#cost").val('0.00');
          $("#costModified").val('0.00');
          $("#sellingPrice").prop('disabled', true);
          $("#sellingPriceModified").prop('disabled', true);
          $("#sellingPriceHidden").text($("#sellingPrice").val());
          $("#sellingPrice").val('0.00');
          $("#sellingPriceModified").val('0.00');
          $( "#TypeRange" ).prop( "disabled", false );
          $( "#btnSetPrices" ).prop( "disabled", false );
          $("#useWS").prop("checked", false);
          $('#webservicelink').removeAttr('data-toggle');
    } else {
          $("#cost").prop('disabled', false);
          $("#cost").val($("#costHidden").text());
          $("#cost").focus();
          $("#sellingPrice").prop('disabled', false);
          $("#sellingPrice").val($("#sellingPriceHidden").text());
          $( "#TypeRange" ).prop( "disabled", true );
          $("#costModified").prop('disabled', false);
          $("#costModified").val($("#costHidden").text());
          $("#costModified").focus();
          $("#sellingPriceModified").prop('disabled', false);
          $("#sellingPriceModified").val($("#sellingPriceHidden").text());
          $( "#TypeRange" ).prop( "disabled", true );
          $( "#btnSetPrices" ).prop( "disabled", true );
    }
})

$("#useWS").click(function () {
     if ($(this).prop("checked")) {
        if ($('#webservicetab').hasClass('disabled')) {
            $('#webservicetab').removeClass('disabled');
            
        }
        $("#useManualPricing").prop("checked", false);
        $('#webservicelink').attr('data-toggle','tab');
        $("#cost").prop('disabled', true);
        $("#costModified").prop('disabled', true);
        $("#costHidden").text($("#cost").val());
        $("#cost").val('0.00');
        $("#costModified").val('0.00');
        $("#sellingPrice").prop('disabled', true);
        $("#sellingPriceModified").prop('disabled', true);
        $("#sellingPriceHidden").text($("#sellingPrice").val());
        $("#sellingPrice").val('0.00');
        $("#sellingPriceModified").val('0.00');
        $( "#TypeRange" ).prop( "disabled", true );
        $( "#btnSetPrices" ).prop( "disabled", true );
     } else {
        $('#webservicelink').removeAttr('data-toggle');
        $("#cost").prop('disabled', false);
        $("#cost").val($("#costHidden").text());
        $("#cost").focus();
        $("#sellingPrice").prop('disabled', false);
        $("#sellingPrice").val($("#sellingPriceHidden").text());
        $( "#TypeRange" ).prop( "disabled", true );
        $("#costModified").prop('disabled', false);
        $("#costModified").val($("#costHidden").text());
        $("#costModified").focus();
        $("#sellingPriceModified").prop('disabled', false);
        $("#sellingPriceModified").val($("#sellingPriceHidden").text());
     }
});

$(window).scroll(function() {    
    if ($(this).scrollTop()) {
        $('#toTop').fadeIn();
        $('footer').fadeIn();
        $('#toBottom').fadeOut();
        $('#unZoom').fadeOut();
    } else {
        $('#toTop').fadeOut();
        $('#toBottom').fadeIn();
        $('#unZoom').fadeIn();
        $('footer').fadeOut();
    }
});

$("#saveModalDisclosure").click(function () {
    var Type = $('#TypeFinance').val();
    var Term = $('#TermFinance').val(); 
    var TermText =  $('#TermFinance :selected').text();
    var OrderNumber = $('#TermFinance :selected').attr('OrderNumber');    
    var Deductible = $("#DeductibleFinance").val();
    var SellingPrice = $("#PriceProduct").val();
    var ValidatePrice = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    var ProductBaseType = $(GlobalSectionProduct).find( '.ProductBaseType' ).attr('name');

    SellingPrice = SellingPrice.replace('$','');
    

    if (!ValidateExpression(SellingPrice,'Money')) {            
            toastr.error('Invalid selling price format', "Message");
            return false;
    };
    SellingPrice = GetFloat(SellingPrice).toFixed(2);    
    
    if (ProductBaseType == 'GAP') {
        Term = $("#PriceProduct").val();
    };   
    
    if ( ($("#PriceProduct").is(':visible')) || ($("#TermFinance").is(':visible')) ) {
                $(GlobalSectionProduct).find(':checkbox').val(SellingPrice);              
                if (GlobalValidatePrice == 1) {
                    UpdatePriceWebServicesProductDisclosure(Term);                
                } 
    }
    if (GlobalValidatePrice == 1) {
                 $(GlobalSectionProduct).find( '.ProductType' ).attr('name', Type);
                 $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name', TermText);
                 $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name', Deductible); 
                 $(GlobalSectionProduct).find( ':checkbox' ).attr('OrderNumber', OrderNumber);  
    }

    CalculateTotalCheckbox();
    $('#myModal1').modal('hide');
})

function UpdatePriceWebServicesProductDisclosure(term) {
    if (GlobalValidatePrice == 1) {
        $(GlobalSectionProduct).find(':checkbox').val(term);                   
    };
    
}

$(".linkmodal2").click(function () {
    GlobalSectionProduct = $(this).parent().parent();
    var Brochure = $(GlobalSectionProduct).find( '.BrochureImage' ).val();
    var dimension = $(GlobalSectionProduct).find( '.BrochureImage' ).attr('name');
    var path = $('#ImgModal2').attr('name');
    var arrayDimension = dimension.split('-');
    $('.videoPlayer1').attr('data', ''); 
    $('.videoPlayer2').attr('src', ''); 

    var height = parseInt(arrayDimension[0]);
    var width = parseInt(arrayDimension[1]);

    if( height < 10 || width < 10){
        width = 320;
        height = 240;
    }

    if (isUrl(Brochure) == true) {
        var url = FixURL(Brochure);
        if (url == 0) {
            toastr.error('Invalid URL Video', "Message");
            return false;
        }
        $('#ImgModal2').hide();
        $('.videoPlayer').show();
        $('.videoPlayer').attr('height',height);
        $('.videoPlayer').attr('width',width);
        $('.videoPlayer1').attr('data', url); 
        $('.videoPlayer2').attr('src', url); 
    } else{
        $('.videoPlayer').hide();
        $('#ImgModal2').show();
        var img = path + Brochure;
        $('#ImgModal2').attr('src', img); 
        $('#ModalContainer').attr('height',height);
        $('#ModalContainer').attr('width',width);

        if (Brochure == '') {
            toastr.error('No brochure', "Message");
            return false;
        }         
    };
});

$('#myModal2').on('hide.bs.modal', function () {
    var url = $('.videoPlayer1').attr('data'); 
    $('.videoPlayer1').attr('data', url); 
    $('.videoPlayer2').attr('src', url); 
})


function isUrl(s) {
    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
    return regexp.test(s);
}

function FixURL (url) {
    var ReturnUrl;
    var idVideo;
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    
    if (match&&match[7].length==11){
        idVideo =match[7];
        return ReturnUrl = 'http://www.youtube.com/embed/' + idVideo;
    }
    else{        
        return 0;
    }
    
}

function validateVideoURL(textval) {
      var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
      return regExp.test(textval);
}


function ValidationEmptyDeal () {
    var text = $("#ModelValidate").html();
    if (text.length < 10) {
       $("#Deal").focus();
       toastr.error("Please enter a deal", "Message");
        return true;
    }
    return false;
}

function ValidateExpression (text, type) {
    text = text.replace(',','')
    var res;
    var NumberOnly = new RegExp('^[0-9]');
    var NumberFloat = new RegExp("^-?(?:[0-9]+|[0-9]*\.[0-9]+)$");
    if (type == 'Number') {
        res = NumberOnly.test(text);    
    };
    if (type == 'Money') {
        res = NumberFloat.test(text);
    };

    return res;
}

$("#UseType").click(function () {
    if ($(this).prop("checked")) {
        $( "#Type" ).prop( "disabled", false );
    } else {
        $( "#Type" ).prop( "disabled", true );
    }
});

$("#UseTerm").click(function () {
    if ($(this).prop("checked")) {
        $( "#Term" ).prop( "disabled", false );
    } else {
        $( "#Term" ).prop( "disabled", true );
    }
});

$("#UseDeductible").click(function () {
    if ($(this).prop("checked")) {
        $( "#Deductible" ).prop( "disabled", false );
    } else {
        $( "#Deductible" ).prop( "disabled", true );
    }
});

$("#UseVehiclePlan").click(function () {
    if ($(this).prop("checked")) {
        $( "#VehiclePlan" ).prop( "disabled", false );
    } else {
        $( "#VehiclePlan" ).prop( "disabled", true );
    }
});


function StartToastMessage(){
    toastr.options = {
    "closeButton": false,
    "debug": false,
    "positionClass": "toast-center-screen",
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
}

$("#FindDeal").click(function () {
    $.blockUI();
})

$(".PdfContract").click(function() {
    GlobalSectionProduct = $(this).parent().parent();
    var Id = $(GlobalSectionProduct).attr('id');
    var Type = $(GlobalSectionProduct).find( '.ProductType' ).attr('name');
    var Term = $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name');
    var Deductible = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    var OrderNumber = $(GlobalSectionProduct).find( ':checkbox' ).attr('OrderNumber'); 
    if (OrderNumber.length == 0) {
        OrderNumber = 0;
    };
    $(this).attr("href", 'CreatePDF?ProductId='+Id+'&type='+Type+'&term='+Term+'&deductible='+Deductible+'&key='+OrderNumber);    
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
        toastr.error('User not found', "Message");
      }
   }); 
}
