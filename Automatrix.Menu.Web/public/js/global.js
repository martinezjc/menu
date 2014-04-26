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
var changeFirstOnly = false;
var GlobalTaxRate;

$(document).ready(function () {
    StartToastMessage();
    DisableFailedProducts();
    
    GlobalTaxRate = $("#dealerTaxRate").val();    

    if (!($(document).height() > $(window).height())) {
        $('footer').removeClass('footerApp');
    } 
});

(function($) {
    $.fn.hasScrollBar = function() {
        return this.get(0).scrollHeight > this.height();
    }
})(jQuery);

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

function getCurrentFinancedAmount()
{
    var originalFinancedAmount = getFloat($('#original-financedamount').val());
    var originalDownPayment = getFloat($('#original-downpayment').val());
    var newDowPayment = getFloat($('#DownPaymentDeal').val());

    return (originalFinancedAmount + originalDownPayment) - newDowPayment;
}

function getCurrentAPR() {
    return getFloat($("#AprHidden").val());
}

function getCurrentTerm() {
    return getInt($("#TermHidden").val());
}

function getCurrentDownPayment () {
    return getFloat($('#DownPaymentDeal').val());
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
    var Type = $(GlobalSectionProduct).find( '.ProductType' ).attr('name');
    var Term = $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name');
    var Deductible = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    $('#TermFinance').val(Term);
    $('#DeductibleFinance').val(Deductible);
    $('#TypeFinance').val(Type);
    $('#ApplyChanges').prop('checked', true);

});

function ValidationEmptyDeal () {
    var text = $("#ModelValidate").html();
    if (text.length < 10) {
       $("#Deal").focus();
       toastr.error("Please enter a deal.", "Message");
        return true;
    }
    return false;
}

$("#ButtonReset").click(function () { 
    if ($("#ApplyChanges").prop("checked")) {
            location.reload();    
    } else {    
           RetrieveInfoProductModal(GlobalSectionProduct.attr('id'));
           if (GlobalValidatePage == 0) {
                 calculatePlans();
            }else{
                calculateCheckedProducts();
            }
    }
    
    $('#myModal1').modal('hide');    
})
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
                if (GlobalValidatePage == 0) {
                    $(GlobalSectionProduct).find( '.price-product' ).text('$'+ sellingPrice.toFixed(2));
                }
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
        },
        failure: function (msg) {
        }
    });
}

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

$(".UsingWebService").on('click',function() {
    var RangePricing = $(GlobalSectionProduct).find( ':checkbox' ).attr('RangePricing');  
    var ShowType = $(GlobalSectionProduct).find( '.UseType' ).val();
    var ShowTerm = $(GlobalSectionProduct).find( '.UseTerm' ).val();
    var ShowDeductible = $(GlobalSectionProduct).find( '.UseDeductible' ).val();
    var ProductBaseType = $(GlobalSectionProduct).find( '.ProductBaseType' ).attr('name');

    LoadOptionDefault();

   if (ShowType == 0) {
        $('#ModalType').hide();
   } else {
        $('#ModalType').show();
   };

   if (ShowTerm == 0) {
        $('#ModalTerm').hide();
   } else {
        $('#ModalTerm').show();
   };

   if (ShowDeductible == 0) {
        $('#ModalDeductible').hide();
   } else {
        $('#ModalDeductible').show();   
   };

    $('#ModalPrice').hide();
    GlobalValidatePrice = 1;

    ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
    
    if ( ProductBaseId == 4 ){
        $('#ModalTireRotation').show();
        $('#ModalInterval').show();
    } else {
        $('#ModalInterval').hide();
        $('#ModalTireRotation').hide();    
    }
    
    if (ProductBaseId == 12 ) {
        ReadSurchargesValues();
        $('.Protective').show();        
    }else{
        $('.Protective').hide();
   }

    if (ProductBaseId == 12 || ProductBaseId == 2 || ProductBaseId == 4) {
        $('#ModalMileage').show();
    } else {
        $('#ModalMileage').hide();
    }

    if (ProductBaseId == 11) {
        $('#ModalTerm').hide();
        //$('#TermFinance').hide();
        //$('#TermFinance2').show();

    } else {
        $('#TermFinance').show();
        $('#TermFinance2').hide();
    }

    if (ProductBaseType == 'GAP') {
         $('#ModalPrice').show();
    } else {
         $('#ModalPrice').hide();
    }

    if (RangePricing == 1) {
        LoadManualPriceOption();
        $('#TypeFinance').attr("disabled", "disabled");
        $('#TermFinance2').attr("disabled", "disabled");
    }else{
        $('#TypeFinance').removeAttr("disabled");
        $('#TermFinance2').removeAttr("disabled");
    }
});

$(".NotUsingWebService").on('click',function() {
    $('#ModalTerm').hide();    
    $('#ModalDeductible').hide();
    $('#ModalType').hide();
    $('#TermFinance2').hide();
    $('#ModalPrice').show();
    $('#ModalMileage').hide();
    $('#ModalTireRotation').hide();
    $('#ModalInterval').hide();
    GlobalValidatePrice = 0;

    LoadManualPriceOption();

    ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
    if (ProductBaseId == 12 ) {
        ReadSurchargesValues();
        $('.Protective').show();        
    }else{
        $('.Protective').hide();
   }

});

function GetValueWebService (type,term,mileage,tireRotation,interval,deductible,productBaseId) {
    var SellingPrice = 0;
    var flagDeductible = 0;
    
    if (deductible == '100D') {
        flagDeductible = 1;
        deductible = deductible.replace("D","");
    };

    idSave= GlobalSectionProduct.attr('id');
    eval("var countproductRates = Object.keys(productRates.product" + idSave + ").length;");
    for(var i = 0; i < countproductRates; i++) {
            eval("var obj = productRates.product" + idSave + "[i];");

            if (type == obj.Type) {
                if (term == obj.Term) {
                        if (productBaseId == 12) {
                            if (mileage == obj.Mileage) {
                                SellingPrice = obj.SellingPrice;
                                    if (deductible == obj.Deductible) {
                                            SellingPrice = obj.SellingPrice;
                                            if (flagDeductible == 1) {
                                                if (obj.DisappearingDeductible == true) {
                                                    return obj.SellingPrice;
                                                };
                                            }else{
                                                return SellingPrice;
                                            }
                                    };
                            };
                        };// end productBaseId == 12
                        
                        if (productBaseId == 4) {
                            if (mileage == obj.Mileage) {
                                if ( tireRotation = obj.TireRotation) {
                                    if ( interval == obj.Interval ) {
                                        SellingPrice = obj.SellingPrice;
                                        return SellingPrice;
                                    }
                                }
                            }
                        };

                        if (productBaseId == 2) {
                            if (deductible == parseInt(obj.Deductible)) {
                                if (mileage == obj.Mileage) {
                                    return obj.SellingPrice;
                                };                                    
                            };
                        };
                        
                };
            };
     }

     return SellingPrice;
}

function LoadManualPriceOption () {
    ProductCompanyId = parseInt(GlobalSectionProduct.attr('company'));
    ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));

    var selectTerm = document.getElementById("TermFinance");
    selectTerm.options.length = 0;
    var selectType = document.getElementById("TypeFinance");
    selectType.options.length = 0;
    var selectMileage = document.getElementById("MileageFinance");
    selectMileage.options.length = 0;
    var selectDeductible = document.getElementById("DeductibleFinance");
    selectDeductible.options.length = 0;

    var SelectedTerm = $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name');
    var SelectedType = $(GlobalSectionProduct).find( '.ProductType' ).attr('name');
    var SelectedDeductible = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    var SelectedMileage = $(GlobalSectionProduct).find( '.ProductMileage' ).attr('name');
    var SelectedTireRotation = $(GlobalSectionProduct).find( '.ProductTireRotation' ).attr('name');
    

    var objData = new Object();


    for(var index in window.objXml.Company) { 
           var obj = window.objXml.Company[index];
           if (obj.ID == ProductCompanyId) {
                for (var index2 in obj.ProductBase) {
                    if (obj.ProductBase[index2].Id == ProductBaseId) {
                        objData = obj.ProductBase[index2];
                        break;
                    }                                       
                }                
           }
    }

    for (var index in objData.types.type) {
        var types = objData.types.type[index];
        (selectType.options[selectType.options.length] = new Option(types.text, types.value)); 
    }
     for (var index in objData.terms.term) {
        var terms = objData.terms.term[index];
        (selectTerm.options[selectTerm.options.length] = new Option(terms.text, terms.value)).setAttribute('OrderNumber',index);
    }
     for (var index in objData.deductibles.deductible) {
        var deductibles = objData.deductibles.deductible[index];
        (selectDeductible.options[selectDeductible.options.length] = new Option(deductibles.text, deductibles.value)); 
    }

    $("#TypeFinance option").filter(function() {
            return $(this).val() == SelectedType; 
    }).prop('selected', true);

    $("#TermFinance option").filter(function() {
            return $(this).val() == SelectedTerm; 
    }).prop('selected', true);

    $("#DeductibleFinance option").filter(function() {
            return $(this).val() == SelectedDeductible; 
    }).prop('selected', true);

    $("#TypeFinance option").attr("disabled", "disabled");
    $("#TermFinance option").attr("disabled", "disabled");
    $("#DeductibleFinance option").attr("disabled", "disabled");
}


function LoadOptionDefault() {
    var ArrayTerm = [];
    var ArrayType = [];
    var ArrayMileage = [];
    var ArrayTireRotation = [];
    var ArrayInterval = [];
    var ArrayDeductible = [];
    var ArrayDisappearing = [];

    var selectTerm = document.getElementById("TermFinance");
    selectTerm.options.length = 0;

    var selectType = document.getElementById("TypeFinance");
     selectType.options.length = 0;

    var selectMileage = document.getElementById("MileageFinance");
     selectMileage.options.length = 0;

     var selectTireRotation = document.getElementById("TireRotation");
     selectTireRotation.options.length = 0;

    var selectDeductible = document.getElementById("DeductibleFinance");
    selectDeductible.options.length = 0;

    var selectInterval = document.getElementById("Interval");
    selectInterval.options.length = 0;
    
    idSave = GlobalSectionProduct.attr('id');
    ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
    var SelectedTerm = $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name');
    var SelectedType = $(GlobalSectionProduct).find( '.ProductType' ).attr('name');
    var SelectedDeductible = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    var SelectedMileage = $(GlobalSectionProduct).find( '.ProductMileage' ).attr('name');
    var SelectedTireRotation = $(GlobalSectionProduct).find( '.ProductTireRotation' ).attr('name');
    var SelectedInterval = $(GlobalSectionProduct).find( '.ProductInterval' ).attr('name');
    var ProductBaseType = $(GlobalSectionProduct).find( '.ProductBaseType' ).attr('name');

    // //load Deductible
    // (selectDeductible.options[selectDeductible.options.length] = new Option('$0', '0')); 
    // (selectDeductible.options[selectDeductible.options.length] = new Option('$50', '50')); 
    // (selectDeductible.options[selectDeductible.options.length] = new Option('$100', '100')); 
    // (selectDeductible.options[selectDeductible.options.length] = new Option('$100 Disappearing', '100D')); 
    // (selectDeductible.options[selectDeductible.options.length] = new Option('$200', '200')); 

    // if (ProductBaseId == 12) {
    //     $("#DeductibleFinance option[value='100D']").hide();
    // } else{
    //     $("#DeductibleFinance option[value='100D']").show();
    // };

    // $("#DeductibleFinance option").filter(function() {
    //         return $(this).val() == SelectedDeductible; 
    // }).prop('selected', true);

    eval("var countproductRates = Object.keys(productRates.product" + idSave + ").length;");
    
    eval("var obj = productRates.product" + idSave);
    var typeFind = SearchObjType( obj, SelectedType );
    for(var i = 0; i < countproductRates; i++) {
            eval("var obj = productRates.product" + idSave + "[i];");
             validate = ArrayTerm.indexOf(obj.Term);
             validate2 = ArrayType.indexOf(obj.Type);
             validate3 = ArrayMileage.indexOf(obj.Mileage);
             validate4 = ArrayTireRotation.indexOf(obj.Mileage);
             validate5 = ArrayInterval.indexOf(obj.Interval);
             validate6= ArrayDeductible.indexOf(obj.Deductible)

             if (validate2 < 0) {
                        ArrayType[i] = obj.Type;
                        (selectType.options[selectType.options.length] = new Option(obj.Type, obj.Type)).setAttribute('OrderNumber',obj.OrderNumber);                 
             };

             if (SelectedType == 'none' || SelectedType == 'None'  || typeFind==0) {
                SelectedType =  obj.Type;
                typeFind = 1;
             };              

             if (SelectedType == obj.Type) {
                     $("#TypeFinance option").filter(function() {
                           return $(this).text() == obj.Type; 
                        }).prop('selected', true);

                     if (validate < 0) {
                        ArrayTerm[i] = obj.Term; 
                        (selectTerm.options[selectTerm.options.length] = new Option(obj.Term, obj.SellingPrice)).setAttribute('OrderNumber', obj.OrderNumber);
                     };
                    if(validate6 < 0){
                    if (ProductBaseId == 12) {
                            if(obj.Deductible == 100){
                              validateDisappearing = ArrayDisappearing.indexOf(obj.DisappearingDeductible);
                              if (validateDisappearing >= 0) {  // if deductible 100 with same disappearing , continue next iteration
                                    continue; 
                              }
                              ArrayDisappearing[i] = obj.DisappearingDeductible;
                            }else{
                              ArrayDeductible[i] = obj.Deductible;
                            }
                           if (obj.DisappearingDeductible == true) {
                                (selectDeductible.options[selectDeductible.options.length] = new Option("$"+parseInt(obj.Deductible)+" Disappearing", parseInt(obj.Deductible)+"D")).setAttribute('Disappearing', obj.DisappearingDeductible);
                            }else{
                                (selectDeductible.options[selectDeductible.options.length] = new Option("$"+parseInt(obj.Deductible), parseInt(obj.Deductible))).setAttribute('Disappearing', obj.DisappearingDeductible);
                            }
                        } else{
                            ArrayDeductible[i] = obj.Deductible;
                            (selectDeductible.options[selectDeductible.options.length] = new Option("$"+parseInt(obj.Deductible), parseInt(obj.Deductible))).setAttribute('Disappearing', 'false');
                        }

                    } // end validate 6  
                     
             }; 
    }
    ChangeTermOrder(SelectedTerm); 
    ChangeDeductibleOrder(SelectedDeductible);
    
    var FindType = $("#TypeFinance :selected").text();
    var FindTerm = $("#TermFinance :selected").text();
    var FindMileage = $("#MileageFinance :selected").text();
    for (var i = 0; i < countproductRates; i++) {
        eval("var obj = productRates.product" + idSave + "[i];");
        validate3 = ArrayMileage.indexOf(obj.Mileage);
        validate4 = ArrayTireRotation.indexOf(obj.TireRotation);
        validate5 = ArrayInterval.indexOf(obj.Interval);
        if (FindType == obj.Type) {
            if (FindTerm == obj.Term) {
                // only for VSC ---------------
                if (ProductBaseId == 12 || ProductBaseId == 2 || ProductBaseId == 4) {
                    if (validate3 < 0 ) {
                        ArrayMileage[i] = obj.Mileage; 
                        selectMileage.options[selectMileage.options.length] = new Option(obj.Mileage, obj.Mileage);                                                       
                    };                         
                };

                if ( ProductBaseId == 4 ){
                    if ( validate4 <= 0 ){
                        ArrayTireRotation[i] = obj.TireRotation;
                        selectTireRotation.options[selectTireRotation.options.length] = new Option(obj.TireRotation, obj.TireRotation);
                    }
                };
                
                if ( ProductBaseId == 4 ){
                    if ( validate5 < 0 ){
                        ArrayInterval[i] = obj.Interval;
                        selectInterval.options[selectInterval.options.length] = new Option(obj.Interval, obj.Interval);
                    }
                };

                // ends 
            };
        };

    };
    
    ChangeMileageOrder(SelectedMileage);
    ChangeTireRotationOrder(SelectedTireRotation);
    ChangeIntervalOrder(SelectedInterval);
  
}

function SearchObjType( obj, SelectedType ){
   for( var key in obj ) {
        if( typeof obj[key] === 'object' ){
            SearchObjType( obj[key] );
        }
        if( obj[key]["Type"] === SelectedType){
            return 1;
        }
    }  
    return 0;
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
    arr.sort(function(a, b) { return a.text - b.text; });
    var selectTerm = document.getElementById("TermFinance");
    selectTerm.options.length = 0;

    for (var i = 0; i < arr.length; i++) {
        (selectTerm.options[selectTerm.options.length] = new Option(arr[i].text, arr[i].value)).setAttribute('OrderNumber', arr[i].order);
        if (SelectedTerm == arr[i].text) {
            $("#TermFinance option").filter(function() {
            return $(this).text() == arr[i].text; 
            }).prop('selected', true);
        }
    };
}

function ChangeDeductibleOrder(SelectedDeductible) {
    var options = $('#DeductibleFinance option');
    var arr = options.map(function(_, o) {
        return {
            text: $(o).text(),
            value: o.value,
            Disappearing: $(o).attr('Disappearing')
        };
    }).get();
    arr.sort(function(a, b) { return a.text - b.text; });
    var selectDeductible = document.getElementById("DeductibleFinance");
    selectDeductible.options.length = 0;

    for (var i = 0; i < arr.length; i++) {
        if (arr[i].Disappearing == true) {
            (selectDeductible.options[selectDeductible.options.length] = new Option(arr[i].text, arr[i].value)).setAttribute('Disappearing', arr[i].Disappearing);
        } else{
            (selectDeductible.options[selectDeductible.options.length] = new Option(arr[i].text, arr[i].value)).setAttribute('Disappearing', arr[i].Disappearing);
        }
        if (SelectedDeductible == arr[i].value) {
            $("#DeductibleFinance option").filter(function() {
            return $(this).text() == arr[i].text; 
            }).prop('selected', true);
        }
    };
}

function ChangeMileageOrder(SelectedMileage) {
    var options = $('#MileageFinance option');
    var arr = options.map(function(_, o) {
        return {
            text: $(o).text(),
            value: o.value
        };
    }).get();
    arr.sort(function(a, b) { return a.text - b.text;});

    var selectMileage = document.getElementById("MileageFinance");
    selectMileage.options.length = 0;

    for (var i = 0; i < arr.length; i++) {
        selectMileage.options[selectMileage.options.length] = new Option(arr[i].text, arr[i].value);

        if (SelectedMileage == arr[i].text) {
            $("#MileageFinance option").filter(function() {
            return $(this).text() == arr[i].text; 
            }).prop('selected', true);
        }; 
    };
}

function ChangeTireRotationOrder(SelectedTireRotation){
    var options = $('#TireRotation option');
    var arr = options.map(function(_, o) {
        return {
            text: $(o).text().replace(',', ''),
            value: o.value.replace(',', '')
        };
    }).get();
    arr.sort(function(a, b) { return a.text - b.text;});

    var selectTireRotation = document.getElementById("TireRotation");
    selectTireRotation.options.length = 0;

    for (var i = 0; i < arr.length; i++) {
        selectTireRotation.options[selectTireRotation.options.length] = new Option(arr[i].text.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"), arr[i].value);

        if (SelectedTireRotation == parseInt( arr[i].text.replace(',','') ) ) {
            $("#TireRotation option").filter(function() {
            return $(this).val() == parseInt( arr[i].text.replace(',','') ); 
            }).prop('selected', true);
        }; 
    };
}

function ChangeIntervalOrder(SelectedInterval){
    //var optionSelected = SelectedTireRotation.toString();
    //SelectedTireRotation = optionSelected.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    SelectedInterval = SelectedInterval.replace(/ +/g, "");
    var options = $('#Interval option');
    var arr = options.map(function(_, o) {
        return {
            text: $(o).text(),
            value: o.value
        };
    }).get();
    arr.sort(function(a, b) { return a.text - b.text;});

    var selectInterval = document.getElementById("Interval");
    selectInterval.options.length = 0;

    for (var i = 0; i < arr.length; i++) {
        selectInterval.options[selectInterval.options.length] = new Option(arr[i].text, arr[i].value);
        
        if (SelectedInterval == arr[i].text.replace(/ +/g, "") ) {
            $("#Interval option").filter(function() {
            return $(this).text() == arr[i].text; 
            }).prop('selected', true);
        }; 
    };
}

function GetFloat (value) {
    if ((typeof value == 'string' || value instanceof String) && value != '')
        value = value.toString().replace('$', '').replace(',', '');
    else
        if (value == null || isNaN(value))
            value = 0;

    return parseFloat(value);
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
            toastr.error('Invalid URL Video.', "Message");
            return false;
        }

        $('#ImgModal2').hide();
        $('.videoPlayer').show();
        $('.videoPlayer').attr('height',height);
        $('.videoPlayer').attr('width',width);
        $('.videoPlayer1').attr('data', url); 
        $('.videoPlayer2').attr('src', url); 
    } else {
        $('.videoPlayer').hide();
        
        var img = path + Brochure;
        

        if (Brochure == '') {
            toastr.error('No brochure.', "Message");
            return false;
        } else {
            $('#ImgModal2').show();
            $('#ImgModal2').attr('src', img); 
            $('#ModalContainer').attr('height',height);
            $('#ModalContainer').attr('width',width);
        }         
    };
});

$(".linkmodal2").on('click',function() {
    flagBottonsModal = 1;

})

$('#myModal2').on('hide.bs.modal', function () {
    var url = $('.videoPlayer1').attr('data'); 
    $('.videoPlayer1').attr('data', url); 
    $('.videoPlayer2').attr('src', url); 
});

$( "#TypeFinance" ).change(function() {
    LoadOptionTypeOnSelect($('#TypeFinance :selected').text());
    LoadOptionTermOnSelect($('#TermFinance :selected').text());
});

$( "#TermFinance" ).change(function() {
    LoadOptionTermOnSelect($('#TermFinance :selected').text());
});

function LoadOptionTypeOnSelect(SelectedType) {

    var ArrayMileage = [];
    var ArrayTerm = [];
    var ArrayType = [];
    
    var selectMileage = document.getElementById("MileageFinance");
     selectMileage.options.length = 0;
    
    var selectTerm = document.getElementById("TermFinance");
    selectTerm.options.length = 0;

    var SelectedType = $('#TypeFinance :selected').val();
    var SelectedMileage = $(GlobalSectionProduct).find( '.ProductMileage' ).attr('name');
    var SelectedTerm = $(GlobalSectionProduct).find( '.ProductTerm' ).attr('name'); 

    var ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
    var idSave = GlobalSectionProduct.attr('id');

    eval("var countproductRates = Object.keys(productRates.product" + idSave + ").length;");
    for(var i = 0; i < countproductRates; i++) {
            eval("var obj = productRates.product" + idSave + "[i];");
            validate = ArrayTerm.indexOf(obj.Term);
            validate2 = ArrayMileage.indexOf(obj.Mileage);
            
            if (SelectedType == obj.Type) {
                if (validate < 0) {
                    ArrayTerm[i] = obj.Term; 
                    (selectTerm.options[selectTerm.options.length] = new Option(obj.Term, obj.SellingPrice)).setAttribute('OrderNumber',obj.OrderNumber);   

                }              
            }               
    } 
   
   ChangeTermOrder(SelectedTerm); 
    
    var FindType = $("#TypeFinance :selected").text();
    var FindTerm = $("#TermFinance :selected").text();
    for (var i = 0; i < countproductRates; i++) {
        eval("var obj = productRates.product" + idSave + "[i];");
        validate3 = ArrayMileage.indexOf(obj.Mileage);
        if (FindType == obj.Type) {
            if (FindTerm == obj.Term) {
                // only for VSC ---------------
                if (ProductBaseId == 12 || ProductBaseId == 2  || ProductBaseId == 4) {
                    if (validate3 < 0 ) {
                        ArrayMileage[i] = obj.Mileage; 
                        selectMileage.options[selectMileage.options.length] = new Option(obj.Mileage, obj.Mileage);                                                       
                    };                            
                }; 
            };
        };

    };
    
    ChangeMileageOrder(SelectedMileage);       
}

function LoadOptionTermOnSelect (SelectedTerm) {
    var ArrayMileage = [];
    var ArrayDeductible = [];
    var ArrayDisappearing = [];

    var selectMileage = document.getElementById("MileageFinance");
    selectMileage.options.length = 0;
    var selectDeductible = document.getElementById("DeductibleFinance");
    selectDeductible.options.length = 0;

    var SelectedDeductible = $(GlobalSectionProduct).find( '.ProductDeductible' ).attr('name');
    
    var SelectedMileage = $(GlobalSectionProduct).find( '.ProductMileage' ).attr('name');

    var ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
    var idSave = GlobalSectionProduct.attr('id');

    var FindType = $("#TypeFinance :selected").text();
    var FindTerm = SelectedTerm;

    eval("var countproductRates = Object.keys(productRates.product" + idSave + ").length;");

    var flag100 = 0;
    
    for (var i = 0; i < countproductRates; i++) {
        eval("var obj = productRates.product" + idSave + "[i];");
        validate3 = ArrayMileage.indexOf(obj.Mileage);
        validate6= ArrayDeductible.indexOf(obj.Deductible)
        
        if (FindType == obj.Type) {
            if (FindTerm == obj.Term) {
                // only for VSC ---------------
                if (ProductBaseId == 12 || ProductBaseId == 2  || ProductBaseId == 4) {
                    if (validate3 < 0 ) {
                        ArrayMileage[i] = obj.Mileage; 
                        selectMileage.options[selectMileage.options.length] = new Option(obj.Mileage, obj.Mileage);                                                       
                    }                            
                }
                if(validate6 < 0){
                    if (ProductBaseId == 12) {
                        if(obj.Deductible == 100){
                          validateDisappearing = ArrayDisappearing.indexOf(obj.DisappearingDeductible);
                          if (validateDisappearing >= 0) {  // if deductible 100 with same disappearing , continue next iteration
                            continue; 
                          }
                          ArrayDisappearing[i] = obj.DisappearingDeductible;
                        }else{
                          ArrayDeductible[i] = obj.Deductible;
                        }
                       if (obj.DisappearingDeductible == true) {
                            (selectDeductible.options[selectDeductible.options.length] = new Option("$"+parseInt(obj.Deductible)+" Disappearing", parseInt(obj.Deductible)+"D")).setAttribute('Disappearing', obj.DisappearingDeductible);
                        }else{
                            (selectDeductible.options[selectDeductible.options.length] = new Option("$"+parseInt(obj.Deductible), parseInt(obj.Deductible))).setAttribute('Disappearing', obj.DisappearingDeductible);
                        }
                    } else{
                        ArrayDeductible[i] = obj.Deductible;
                        (selectDeductible.options[selectDeductible.options.length] = new Option("$"+parseInt(obj.Deductible), parseInt(obj.Deductible))).setAttribute('Disappearing', 'false');
                    }

                } // end validate 6  
            }
        }

    };
    ChangeMileageOrder(SelectedMileage); 
    ChangeDeductibleOrder(SelectedDeductible);

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
    } else {
        return 0;
    }
}

function DefineId(num) {
    $("#ButtonNext").prop("disabled", false);
    var id = num;
    var id2 = num;
    GlobalPlanChoosed = num;
    $('#HiddenId').val(id);
    GetIdProducts(id2);
    $("#ButtonNext").focus();
}

function GetIdProducts(id) {
    var i = 0;
    GlobalAccepted = [];
    OrderNumberAccepted = [];
    OrderNumberRejected = [];
    GlobalRejected = [];
    GlobalAcceptedPrice = [];
    GlobalRejectedPrice = [];
    TypeAccepted = [];
    TypeRejected = [];
    TermAccepted = [];
    TermRejected = [];
    DeductibleAccepted = [];
    DeductibleRejected = [];
    MileageAccepted = [];
    MileageRejected = [];
    TireRotationAccepted = [];
    TireRotationRejected = [];
    IntervalAccepted = [];
    IntervalRejected = [];
    DescriptionAccepted = [];
    DescriptionRejected = [];
    
    $("#" + id + " :checkbox").each(function () {
        var checkbox = $(this);
        var Section = $(this).parent().parent().parent();
        

        if (!checkbox.prop("checked")) {
            if ( checkbox.is(':visible') ) {
                GlobalRejected[i] = $(this).attr('id');
                GlobalRejectedPrice[i] = $(this).val();
                GlobalRejectedPrice[i] = GlobalRejectedPrice[i].replace(',','');
                OrderNumberRejected[i] = $(this).attr('OrderNumber');
                
                if (($(Section).find('.ProductTerm')).length > 0) {
                    TypeRejected[i] = $(Section).find('.ProductType').attr('name');
                    TermRejected[i] = $(Section).find('.ProductTerm').attr('name');
                    DeductibleRejected[i] = $(Section).find('.ProductDeductible').attr('name');
                    MileageRejected[i] = $(Section).find('.ProductMileage').attr('name');
                    TireRotationRejected[i] = $(Section).find('.ProductTireRotation').attr('name').replace(',','-');
                    IntervalRejected[i] = $(Section).find('.ProductInterval').attr('name');
                    DescriptionRejected[i] = $(Section).find('.displayname-product').text().replace(',','%');
                };
            };

        } else {
            if ( checkbox.is(':visible') ) {
                GlobalAccepted[i] = $(this).attr('id');
                GlobalAcceptedPrice[i] = $(this).val();
                GlobalAcceptedPrice[i] = GlobalAcceptedPrice[i].replace(',','');
                OrderNumberAccepted[i] = $(this).attr('OrderNumber');

                 if (($(Section).find('.ProductTerm')).length > 0) {    
                    TypeAccepted[i] = $(Section).find('.ProductType').attr('name');
                    TermAccepted[i] = $(Section).find('.ProductTerm').attr('name');                
                    DeductibleAccepted[i] = $(Section).find('.ProductDeductible').attr('name');
                    MileageAccepted[i] = $(Section).find('.ProductMileage').attr('name');
                    TireRotationAccepted[i] = $(Section).find('.ProductTireRotation').attr('name').replace(',','-');
                    IntervalAccepted[i] = $(Section).find('.ProductInterval').attr('name');
                    DescriptionAccepted[i] = $(Section).find('.displayname-product').text().replace(',','%');
                };
            };
        }
        i = i + 1;
    });
    $("#1 :checkbox").each(function () {
        var checkbox = $(this);
        var Section = $(this).parent().parent().parent();
        var idToEval = $(this).attr('id');
        var ValidateAccepted = GlobalAccepted.indexOf(idToEval);
        var ValidateRejected = GlobalRejected.indexOf(idToEval);

        if ((ValidateAccepted >= 0) || (ValidateRejected >= 0)) {            
        } else{
            if ( checkbox.is(':visible') ) {
                GlobalRejected[i] = idToEval;
                GlobalRejectedPrice[i] = $(this).val();
                GlobalRejectedPrice[i] = GlobalRejectedPrice[i].replace(',','');
                OrderNumberRejected[i] = $(this).attr('OrderNumber');

                if (($(Section).find('.ProductTerm')).length > 0) {
                    TypeRejected[i] = $(Section).find('.ProductType').attr('name');
                    TermRejected[i] = $(Section).find('.ProductTerm').attr('name');                
                    DeductibleRejected[i] = $(Section).find('.ProductDeductible').attr('name');
                    MileageRejected[i] = $(Section).find('.ProductMileage').attr('name');
                    TireRotationRejected[i] = $(Section).find('.ProductTireRotation').attr('name').replace(',','-');
                    IntervalRejected[i] = $(Section).find('.ProductInterval').attr('name');
                    DescriptionRejected[i] = $(Section).find('.displayname-product').text().replace(',','%');
                };
            };
        };
        i = i + 1;
    });


    OrderNumberAccepted = $.grep(OrderNumberAccepted, function (n) { return (n) });
    OrderNumberRejected = $.grep(OrderNumberRejected, function (n) { return (n) });
    GlobalAccepted = $.grep(GlobalAccepted, function (n) { return (n) });
    GlobalRejected = $.grep(GlobalRejected, function (n) { return (n) });
    GlobalAcceptedPrice = $.grep(GlobalAcceptedPrice, function (n) { return (n) });
    GlobalRejectedPrice = $.grep(GlobalRejectedPrice, function (n) { return (n) });
    TypeAccepted = $.grep(TypeAccepted, function (n) { return (n) });
    TypeRejected = $.grep(TypeRejected, function (n) { return (n) });
    TermAccepted = $.grep(TermAccepted, function (n) { return (n) });
    TermRejected = $.grep(TermRejected, function (n) { return (n) });
    DeductibleAccepted = $.grep(DeductibleAccepted, function (n) { return (n) });
    DeductibleRejected = $.grep(DeductibleRejected, function (n) { return (n) });
    MileageAccepted = $.grep(MileageAccepted, function (n) { return (n) });
    MileageRejected = $.grep(MileageRejected, function (n) { return (n) });
    TireRotationAccepted = $.grep(TireRotationAccepted, function (n) { return (n) });
    TireRotationRejected = $.grep(TireRotationRejected, function (n) { return (n) });
    IntervalAccepted = $.grep(IntervalAccepted, function (n) { return (n) });
    IntervalRejected = $.grep(IntervalRejected, function (n) { return (n) });
    DescriptionAccepted = $.grep(DescriptionAccepted, function (n) { return (n) });
    DescriptionRejected = $.grep(DescriptionRejected, function (n) { return (n) });

    
    $("#HiddenAccepted").val(GlobalAccepted.toString());
    $("#HiddenRejected").val(GlobalRejected.toString());

    $("#HiddenTypeAccepted").val(TypeAccepted.toString());
    $("#HiddenTypeRejected").val(TypeRejected.toString());
    $("#HiddenTermAccepted").val(TermAccepted.toString());
    $("#HiddenTermRejected").val(TermRejected.toString());
    $("#HiddenDeductibleAccepted").val(DeductibleAccepted.toString());
    $("#HiddenDeductibleRejected").val(DeductibleRejected.toString());

    $("#HiddenOrderAccepted").val(OrderNumberAccepted.toString());
    $("#HiddenOrderRejected").val(OrderNumberRejected.toString());

    $("#HiddenAcceptedPrice").val(GlobalAcceptedPrice.toString());    
    $("#HiddenRejectedPrice").val(GlobalRejectedPrice.toString());

    $("#HiddenMileageAccepted").val(MileageAccepted.toString());
    $("#HiddenMileageRejected").val(MileageRejected.toString());

    $("#HiddenTireRotationAccepted").val(TireRotationAccepted.toString());
    $("#HiddenTireRotationRejected").val(TireRotationRejected.toString());

    $("#HiddenIntervalAccepted").val(IntervalAccepted.toString());
    $("#HiddenIntervalRejected").val(IntervalRejected.toString());

    $("#HiddenDescriptionAccepted").val(DescriptionAccepted.toString());
    $("#HiddenDescriptionRejected").val(DescriptionRejected.toString());
    
    $("#CostPerDayFinance").val($("#" + id + " .CostDay").text());
    $("#AdditionalPaymentFinance").val($("#" + id + " .Additional").text());
    $("#MonthlyPaymentFinance").val($("#" + id + " .Monthly").text());
    
    $("#HiddenDownPayment").val(getFloat($('#DownPaymentDeal').val()));

    var option = getSelectedPaymentOption();
    $("#HiddenTerm").val(option == "2" ? getFooterTerm() : getCurrentTerm());
    $("#HiddenAPR").val(option == "2" ? getFooterAPR() : getCurrentAPR());
}

function getSelectedPaymentOption()
{
    var plan = "";

    if (GlobalPlanChoosed == 1)
        plan = "premium";
    else
        if (GlobalPlanChoosed == 2)
            plan = "preferred";
        else
            if (GlobalPlanChoosed == 3)
                plan = "economy";
            else
                if (GlobalPlanChoosed == 4)
                    plan = "basic";

    return $('input[name=' + plan + 'Radio]:checked').val();
}

function updateSaveDMSButton(){
     var countProducts = 0;
     $('#AcceptedTable .products').each(function () {
        countProducts++;
    });

     if(countProducts == 0)
        $('#SaveConfig').attr('disabled', true);
     else
        $('#SaveConfig').attr('disabled', false);
}

function GetSurchargesValues() {
    arr = [];
    for (var i = 0; i < 4; i++) {
        arr[i] = 0;
    }

    if ($("#BusinessUse").prop("checked")) {
        arr[0] = 1;
    }
    if ($("#ConversionPackage").prop("checked")) {
        arr[1] = 1;
    }
    if ($("#ElectronicPackage").prop("checked")) {
        arr[2] = 1;
    }
    if ($("#MobilityEquipmentPackage").prop("checked")) {
        arr[3] = 1;
    }
    
    return arr.toString();
}

function ReadSurchargesValues () {
    var Surcharges = $("#HiddenProtectiveVsc").val();   
    var arr = new Array();
    arr = Surcharges.split(","); 

    if (arr[0] == 1) {
        $('#BusinessUse').attr('checked', true);
    } else{
        $('#BusinessUse').attr('checked', false);
    }
    if (arr[1] == 1) {
        $('#ConversionPackage').attr('checked', true);
    } else{
        $('#ConversionPackage').attr('checked', false);
    }
    if (arr[2] == 1) {
        $('#ElectronicPackage').attr('checked', true);
    } else{
        $('#ElectronicPackage').attr('checked', false);
    }
    if (arr[3] == 1) {
        $('#MobilityEquipmentPackage').attr('checked', true);
    } else{
        $('#MobilityEquipmentPackage').attr('checked', false);
    }
}

/**
 * Calculate the base payment of a deal.
 * 
 * @param financedAmount
 * @param term
 * @param apr
 * @returns {Number}
 */
function getMonthlyPayment(financedAmount, term, apr) {
	// Cars that are paid in CASH don't have apr > 0
	if(apr > 0)
		return ((apr / 1200.00) + ((apr / 1200.00) / ((Math.pow(1 + (apr / 1200.00), term)) - 1.00))) * (financedAmount);
	else
		return 0;
}

function ApplyTaxRate(price) {
    price = price * (1 + (GlobalTaxRate / 100));
    return price;
}

// this function disable interactin with product when failed retrieve of rates
function DisableFailedProducts () {
    $(".messageWarning").each(function(){
       var section = $(this).parent().parent();
       section.find(':checkbox').attr('checked', false);
       section.find(':checkbox').attr('disabled', true);
       section.find('.linkmodal1').hide(); 
       section.find('.PdfContract').hide();
    })
}