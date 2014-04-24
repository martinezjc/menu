var productIdGlobal;
var AccountNumberGlobal;

$(document).ready(function () {
    loadListCompanyProducts( $('#CompanyIdSetting option').eq(0).val() );
    StartToastMessage();
    $(':checkbox').click(function (event) {
        checkName = $(this).attr('name');
        switch (checkName) {
            case 'WSUsageModified':if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                                break; 
            case 'WSUsage':if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                                break;
            case 'UseType': if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                            break;
            case 'UseTerm': if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                            break;
            case 'UseDeductible': if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                                  break;                   
            case 'UseTypeModified': if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                            break;
            case 'UseTermModified': if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                            break;
            case 'UseDeductibleModified': if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                                  break;
            case 'isAdministrator': if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                                  break;
            case 'isAdministratorModified': if (!$(this).prop("checked")) {
                                    $(this).prop("checked", true);
                                    } else {
                                    $(this).prop("checked", false);
                                    } 
                                  break;
            case 'remember': 
                            break;

            default:if (!$(this).prop("checked")) {
                        $(this).prop("checked", true);
                        //updateDisplayedFields($(this).val(), 1);
                    } else {
                        $(this).prop("checked", false);
                        //updateDisplayedFields($(this).val(), 0);
                    }
                break;           
        } 
        
    });

});

function updateDisplayedFields(checkOpt, checkVal) {
    $.ajax({
        type: "GET",
        url: "updateDisplayedFields",
        data: {
            DealerId: $('#DealerIdHidden').val(),
            CheckOption: checkOpt,
            CheckValue: checkVal
        },
        success: function (msg) {
        },
        failure: function (msg) {
        }
    });
}

$("#saveSettings").click(function () {
    var DisplayBuyerValue;
    var DisplayCoBuyerValue;
    var DisplayDownPaymentValue;
    var DisplayFinancedAmountValue;
    var DisplayAPRValue;
    var DisplayTermValue;
    var DisplayTradeInValue;
    var DisplayPayOffValue;


    if( $('#DisplayBuyer').prop('checked') == true ){
        DisplayBuyerValue = 1;
    } else {
        DisplayBuyerValue = 0;
    }

    if($('#DisplayCoBuyer').prop('checked') == true ){
        DisplayCoBuyerValue = 1;
    } else {
        DisplayCoBuyerValue = 0;
    }
    
    if($('#DisplayDownPayment').prop('checked') == true ){
        DisplayDownPaymentValue = 1;
    } else {
        DisplayDownPaymentValue = 0;
    }
    
    if($('#DisplayFinancedAmount').prop('checked') == true ){
        DisplayFinancedAmountValue = 1;
    } else {
        DisplayFinancedAmountValue = 0;
    }
    
    if($('#DisplayAPR').prop('checked') == true ){
        DisplayAPRValue = 1;
    } else {
        DisplayAPRValue = 0;
    }

    if($('#DisplayTerm').prop('checked') == true ){
        DisplayTermValue = 1;
    } else {
        DisplayTermValue = 0;
    }
    
    if($('#DisplayTradeIn').prop('checked') == true ){
        DisplayTradeInValue = 1;
    } else {
        DisplayTradeInValue = 0;
    }

    if($('#DisplayPayOff').prop('checked') == true ){
        DisplayPayOffValue = 1;
    } else {
        DisplayPayOffValue = 0;
    }
    
    if ( $('#CompanyCode').val() != '') {
        if ( !$.isNumeric( $('#CompanyCode').val() ) ) {
            toastr.error("The Company Code must be a number.", "Message");
            $('#CompanyCode').focus();
            return false;
        }
    }

    if (!($('#DealerName').val())) {
        toastr.error("Enter a dealer name.", "Message");
        $('#DealerName').focus();
        return false;
    };

    if (!($('#Deal').val())) {
        toastr.error("Enter a Deal.", "Message");
        $('#Deal').focus();
        return false;
    };

     if (!($('#URL').val())) {
        toastr.error("Enter a URL.", "Message");
        $('#URL').focus();
        return false;
    };

     if (!($('#Year').val())) {
        toastr.error("Enter a Year.", "Message");
        $('#Year').focus();
        return false;
    };
     if (!($('#Make').val())) {
        toastr.error("Enter a Make.", "Message");
        $('#Make').focus();
        return false;
    };
     if (!($('#Model').val())) {
        toastr.error("Enter a Model.", "Message");
        $('#Model').focus();
        return false;
    };

    if (!($('#FinancedAmount').val())) {
        toastr.error("Enter a Financed Amount.", "Message");
        $('#FinancedAmount').focus();
        return false;
    };

    if (!($('#BasePayment').val())) {
        toastr.error("Enter a Base Payment.", "Message");
        $('#BasePayment').focus();
        return false;
    };

    if (!($('#APR').val())) {
        toastr.error("Enter a APR.", "Message");
        $('#APR').focus();
        return false;
    };

    if (!($('#Term').val())) {
        toastr.error("Enter a Term.", "Message");
        $('#Term').focus();
        return false;
    };

    if (!($('#DownPayment').val())) {
        toastr.error("Enter a Down Payment.", "Message");
        $('#DownPayment').focus();
        return false;
    };

    if (!($('#Buyer').val())) {
        toastr.error("Enter a Buyer.", "Message");
        $('#Buyer').focus();
        return false;
    };
    if (!($('#CoBuyer').val())) {
        toastr.error("Enter a Co Buyer.", "Message");
        $('#CoBuyer').focus();
        return false;
    };

    if(!($('#Trim').val())) {
        toastr.error("Enter a Trim.", "Message");
        $('#Trim').focus();
        return false;
    };

    if (!($('#Vin').val())) {
        toastr.error("Enter a Vin.", "Message");
        $('#Vin').focus();
        return false;
    };
    
    $.ajax({
        type: "GET",
        url: "saveSettings",
        data: {
            DealerId: $('#DealerIdHidden').val(),
            Deal: $('#Deal').val(),
            DealerName: $('#DealerName').val(),
            DealerCode: $('#DealerCode').val(),
            CompanyCode: $('#CompanyCode').val(),
            URL: $('#URL').val(),
            Year: $('#Year').val(),
            Make: $('#Make').val(),
            Model: $('#Model').val(),
            FinancedAmount: $('#FinancedAmount').val(),
            BasePayment: $('#BasePayment').val(),
            APR: $('#APR').val(),
            Term: $('#Term').val(),
            DownPayment: $('#DownPayment').val(),
            Buyer: $('#Buyer').val(),
            CoBuyer: $('#CoBuyer').val(),
            Trim: $('#Trim').val(),
            Vin: $('#Vin').val(),
            DisplayPayOff: DisplayPayOffValue,
            DisplayTerm: DisplayTermValue,
            DisplayAPR: DisplayAPRValue,
            DisplayFinancedAmount: DisplayFinancedAmountValue,
            DisplayDownPayment: DisplayDownPaymentValue,
            DisplayCoBuyer: DisplayCoBuyerValue,
            DisplayBuyer: DisplayBuyerValue,
            DisplayTradeIn: DisplayTradeInValue,
            TradeAllowance: $('#TradeAllowance').val(),
            TradePayOff: $('#TradePayOff').val(),
            Disclosure: $('#Disclosure').code()
        },
        success: function (msg) {
            saveLogo($('#DealerIdHidden').val(), function(callback){
                if(callback==true)
                {

                }
            });
            toastr.success("Dealer settings has been saved.", "Success");
        },
        error: function (msg) {
            toastr.error(msg);
        }
    });
});

function TestDealerCode (code) {
     $.ajax({
        type: "GET",
        url: "TestDealerCode",
        data: {
                DealerCode: code
             },
        success: function (msg) {
            alert(msg);
        },
        failure: function (msg) {
        }
    });
}

$(".deleteDealer").click(function () {
    var id = $(this).attr('name');
    deleteDealer(id);
})

function deleteDealer(DealerIdValue){
    $.ajax({
        type: "GET",
        url: "deleteDealer",
        data: {
            DealerId: DealerIdValue
        },
        success: function (msg) {
            if (msg==1) {
                window.location.href = 'dealer-settings';
            } else{
                toastr.error("Please delete user and products before.","Message");
            };
        },
        error: function (msg) {
            toastr.error("Please delete user before.","Message");
        }
    });
}

$("body").on("click", "a", function (event) {
    companyId = $(this).attr('name');
    AccountNumberGlobal = $(this).attr('name');
    productIdGlobal = $(this).attr('name');
});

function deleteCompany(id) {
    $.ajax({
        type: "GET",
        url: "deleteCompany",
        data: {
            CompanyId: id
        },
        success: function (msg) {
            window.location.href = 'company-settings';
        },
        failure: function (msg) {
        }
    });
}

$('#companyUpdateModal').on('show.bs.modal', function () {
    $.ajax({
        type: "GET",
        url: "loadCompanyInfo",
        data: {
            CompanyId: companyId
        },
        success: function (msg) {
            var data = JSON.parse(msg);
            $('#CompanyNameUpdate').val(data[0].CompanyName);
            $('#URLUpdate').val(data[0].URL);
            $('#UsernameUpdate').val(data[0].Username);
            $('#PasswordUpdate').val(data[0].Password);            
        },
        failure: function (msg) {
            toastr.error('Error :' + msg + '.', "Message");

        }
    });
});

$('#updateCompanyInfo').click(function () {
    if (!($('#CompanyNameUpdate').val())) {
        $('#CompanyNameUpdate').focus();
        toastr.error('Please enter a company name.', "Message");
        return false;
    };
    if ($('#URLUpdate').val()) {
        if (!(validateURL($('#URLUpdate').val()))) {
            $('#URLUpdate').focus();
            toastr.error('Please enter a valid URL.', "Message");
            return false;
        }        
    };
    
    if (!($('#UsernameUpdate').val()) && ($('#PasswordUpdate').val())) {
        $('#UsernameUpdate').focus();
        toastr.error('Please enter a Username.', "Message");
        return false;
    };
    $.ajax({
        type: "GET",
        url: "updateCompanyInfo",
        data: {
            CompanyId: companyId,
            CompanyName: $('#CompanyNameUpdate').val(),
            URL: $('#URLUpdate').val(),
            Username: $('#UsernameUpdate').val(),
            Password: $('#PasswordUpdate').val()
        },
        success: function (msg) {
            $('#companyUpdateModal').modal('hide');            
            window.location.href = 'company-settings';
        },
        failure: function (msg) {
        }
    });
});

$('#saveCompanyInfo').click(function () {
    if (!($('#CompanyName').val())) {
        $('#CompanyName').focus();
        toastr.error('Please enter a company name.', "Message");
        return false;
    };
     if ($('#URL').val()) {
        if (!(validateURL($('#URL').val()))) {
            $('#URL').focus();
            toastr.error('Please enter a valid URL.', "Message");
            return false;
        }        
    };
    if (!($('#Username').val()) && ($('#Password').val())) {
        $('#Username').focus();
        toastr.error('Please enter a username.', "Message");
        return false;
    };
    $.ajax({
        type: "GET",
        url: "createCompany",
        data: {
            CompanyName: $('#CompanyName').val(),
            URL: $('#URL').val(),
            Username:$('#Username').val(),
            Password: $('#Password').val()
        },
        success: function (msg) {
            $('#companyModal').modal('hide');
            window.location.href = 'company-settings';
        }
    });
});

$('#Password').keyup(function (e) {
    if (e.keyCode == 13) {
        $("#circleG").show();
        if ($("#remeberme").prop("checked")) {
            authenticate(1);
        } else{
            authenticate(0);
        };
        return false;
    }
});

$('#loginPlan').click(function () {
    $("#circleG").show();
    if ($("#remeberme").prop("checked")) {
        authenticate(1);
    } else{
        authenticate(0);
    };
});

function authenticate(remeberme) {
    $.ajax({
        type: "GET",
        url: "authenticate",
        data: {
            Username: $('#Username').val(),
            Password: $('#Password').val(),
            Remeberme: remeberme
        },
        success: function (msg) {        
            if (msg == '0') {
               document.getElementById('message').style.display = 'block';
                $('#message').html('<i class="fa fa-exclamation-triangle"></i> Wrong Username or Password');
            } else {
                var data = JSON.parse(msg);
                window.location.href = 'home';//data[0].LastURL;
            }
        },
        failure: function (msg) {
            $("#circleG").hide();
            toastr.error('User not found.', "Message");

        }
    }).always(function() {
      $("#circleG").hide();
    });
    
}

$('input[name=mediaType]').change(
    function(){
        var radioOption = $(this).val();
        
        if (radioOption == 'VideoURL') {
            $('#BrochureImage').uploadify('cancel');
            $('#BrochureImageRefer').val('');
            $('#showOptions').css('padding-top','9px');
            $('#radios').css('padding-top','9px');
            $("#optionsBlock").removeAttr("style");
            $('#brochureOption').hide();
            $('#videoOption').show();
            $('#urlVideo').val('');
            $('#urlVideo').focus();
        } else {
            $('#showOptions').css('padding-top','9px');
            $('#optionsBlock').css('padding-top','34px');
            $('#radios').css('padding-top','9px');
            $('#brochureOption').show();
            $('#videoOption').hide();
        }
    }
);          

$('input[name=mediaTypeModified]').change(
    function(){
        var radioOption = $(this).val();
        
        if (radioOption == 'VideoURL') {
            $('#BrochureImageModified').uploadify('cancel');
            $('#BrochureImageReferModified').val('');
            $('#showOptionsModified').css('padding-top','2px');
            $('#brochureOptionModified').hide();
            $('#videoOptionModified').show();
            $('#urlVideoModified').focus();
        } else {
            $('#showOptionsModified').css('padding-top','9px');
            $('#brochureOptionModified').show();
            $('#videoOptionModified').hide();
        }
    }
);

$('#showOptions').click( function() {
     if ($('#sizeOptions').is(':visible') ){
        $('#sizeOptions').hide();
        $('#showOptions').text('Show Options');
        if ($("input[name=mediaType]:checked").val() == 'Image') {
          $('#optionsBlock').css('padding-top','34px');
        }
     } else {
        $('#sizeOptions').show();
        if ($("input[name=mediaType]:checked").val() == 'Image') {
          $('#optionsBlock').css('padding-top','34px');
        }
        $('#showOptions').text('Hide Options');
     }
});

$('#showOptionsModified').click( function() {
     if ($('#sizeOptionsModified').is(':visible') ){
        $('#sizeOptionsModified').hide();
        $('#showOptionsModified').text('Show Options');
     } else {
        $('#sizeOptionsModified').show();
        $('#showOptionsModified').text('Hide Options');
     }
});

function validateURL(textval) {
      var urlregex = new RegExp(
            "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
      return urlregex.test(textval);
}

$('#CompanyIdSetting').on('change', function () {
    // var optionSelected = $("option:selected", this);
    var CompanySelected = this.value;
    loadListCompanyProducts(CompanySelected);
});

function loadListCompanyProducts(CompanySelected){
    $.ajax({
        delay: 0,
        type: "GET",
        url: "loadCompanyProductsTable",
        data: {
            CompanyId: CompanySelected
        },
        success: function(msg){
          $('#productsCompanyTable').html
          (
              msg
          );
        },
        failure: function (msg) {
            toastr.error('Table could not be loaded.', "Message");
        }
    });
}

$('#productUpdateModal').on('show.bs.modal', function () {
    $.ajax({
        type: "GET",
        url: "loadInfoCompanyProducts",
        data: {
            ProductBaseId: productIdGlobal
        },
        success: function (msg) {
            var data = JSON.parse(msg);
            
            $('#ProductNameModified').val(data[0].ProductName);
            $('#WSMethodModified').val(data[0].WSMethod);
            $('#ParametersModified').val(data[0].Parameters);
            $("#CompanyIdModified option").filter(function() {
               return $(this).val() == data[0].CompanyId; 
            }).prop('selected', true); 
        },
        failure: function (msg) {
        }
    });
});

$('#saveCompanyProductInfo').click( function() {
    $.ajax({
        type: "GET",
        url: "insertCompanyProduct",
        data: {
            ProductName: $('#ProductName').val(),
            WSMethod: $('#WSMethod').val(),
            CompanyId: $('#CompanyIdNew').val(),
            Parameters: $('#Parameters').val(),
        },
        success: function (msg) {
           $('#addProductCompanyModal').modal('hide');
           window.location.href = 'company-products';
        },
        failure: function (msg) {
        }
    });
});

$('#updateCompanyProductInfo').click( function() {
    $.ajax({
        type: "GET",
        url: "updateCompanyProduct",
        data: {
            ProductBaseId: productIdGlobal,
            ProductName: $('#ProductNameModified').val(),
            WSMethod: $('#WSMethodModified').val(),
            CompanyId: $('#CompanyIdModified').val(),
            Parameters: $('#ParametersModified').val(),
        },
        success: function (msg) {
           $('#productUpdateModal').modal('hide');
           loadListCompanyProducts($('#CompanyIdModified').val());
        },
        failure: function (msg) {
        }
    });
});

function deleteProductCompany(ProductBaseIdValue){
    $.ajax({
        type: "GET",
        url: "deleteCompanyProduct",
        data: {
            ProductBaseId: ProductBaseIdValue
        },
        success: function (msg) {
           loadListCompanyProducts($('#CompanyIdSetting').find(":selected").val());
        },
        failure: function (msg) {
        }
    });
}

$('#resetPassword').click( function(){
    $.ajax({
        type: "GET",
        url: "sendMailPassword",
        data: {
            Email: $('#Email').val()
        },
        success: function (msg) {
            toastr.success(msg + '.');
            $('#resetPasswordModal').modal('hide');
        },
        failure: function (msg) {
        }
    });
});

$('#saveCodeInfo').click( function() {
    $.ajax({
        type: "GET",
        url: "save-settingcode",
        data: {
            DealerId: $('#DealerId').val(),
            CompanyId: $('#CompanyId').val(),
            DealerCode: $('#DealerCode').val()
        },
        success: function (msg) {
            $('#DealerId option').eq(1).prop('selected', true);
            $('#CompanyId option').eq(1).prop('selected', true);
            $('#DealerCode').val("");
            toastr.success("The setting has been saved.", "Success");
            $('#addModal').modal('hide');

            window.location.href = "settings-dealercode";
        },
        failure: function (msg) {
        }
    });
});

$('#ModifyModal').on('show.bs.modal', function () {
    $.ajax({
        type: "GET",
        url: "load-settingcode",
        data: {
            AccountNumber: AccountNumberGlobal
        },
        success: function (msg) {
            var data = JSON.parse(msg);
            
            $('#DealerCodeModified').val(data[0].DealerCode);
            $("#CompanyIdModified option").filter(function() {
               return $(this).val() == data[0].CompanyId; 
            }).prop('selected', true); 
            $("#DealerIdModified option").filter(function() {
               return $(this).val() == data[0].DealerId; 
            }).prop('selected', true); 
        },
        failure: function (msg) {
        }
    });
});


function updateSettingCode(AccountNumberValue){
    $.ajax({
        type: "GET",
        url: "update_settingCode",
        data: {
            AccountNumber: AccountNumberValue,
            DealerId: $('#DealerIdModified').val(),
            CompanyId: $('#CompanyIdModified').val(),
            DealerCode: $('#DealerCodeModified').val()
        },
        success: function (msg) {
            toastr.success("The selected setting has been updated.", "Success");
            window.location.href = "settings-dealercode";
        },
        failure: function (msg) {
        }
    });
}

function deleteSettingCode(AccountNumberValue){
    $.ajax({
        type: "GET",
        url: "delete-settingcode",
        data: {
            AccountNumber: AccountNumberValue
        },
        success: function (msg) {
            toastr.success("The selected setting has been removed.", "Success");
            window.location.href = "settings-dealercode";
        },
        failure: function (msg) {
        }
    });
}

function StartToastMessage(){
    toastr.options = {
    "closeButton": false,
    "debug": false,
    "positionClass": "toast-top-left",
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
