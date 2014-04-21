var AccountNumberGlobal;

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

    if ( $('#TaxRate').val() != '') {
        if ( isNaN( $('#TaxRate').val() ) ) {
            toastr.error("The Tax Rate must be a decimal number.", "Message");
            $('#TaxRate').focus();
            return false;
        }
    }

    if (!($('#Deal').val())) {
        toastr.error("Enter the name of the 'Deal' field from the webservice response.", "Message");
        $('#Deal').focus();
        return false;
    };

     if (!($('#URL').val())) {
        toastr.error("Enter the name of the 'URL' field from the webservice response.", "Message");
        $('#URL').focus();
        return false;
    };

     if (!($('#Year').val())) {
        toastr.error("Enter the name of the 'Year' field from the webservice response.", "Message");
        $('#Year').focus();
        return false;
    };
     if (!($('#Make').val())) {
        toastr.error("Enter the name of the 'Make' field from the webservice response.", "Message");
        $('#Make').focus();
        return false;
    };
     if (!($('#Model').val())) {
        toastr.error("Enter the name of the 'Model' field from the webservice response.", "Message");
        $('#Model').focus();
        return false;
    };

    if (!($('#FinancedAmount').val())) {
        toastr.error("Enter the name of the 'Financed amount' field from the webservice response.", "Message");
        $('#FinancedAmount').focus();
        return false;
    };

    if (!($('#BasePayment').val())) {
        toastr.error("Enter the name of the 'Base payment' field from the webservice response.", "Message");
        $('#BasePayment').focus();
        return false;
    };

    if (!($('#APR').val())) {
        toastr.error("Enter the name of the 'APR' field from the webservice response.", "Message");
        $('#APR').focus();
        return false;
    };

    if (!($('#Term').val())) {
        toastr.error("Enter the name of the 'Term' field from the webservice response.", "Message");
        $('#Term').focus();
        return false;
    };

    if (!($('#DownPayment').val())) {
        toastr.error("Enter the name of the 'Down payment' field from the webservice response.", "Message");
        $('#DownPayment').focus();
        return false;
    };

    if (!($('#Buyer').val())) {
        toastr.error("Enter the name of the 'Buyer' field from the webservice response.", "Message");
        $('#Buyer').focus();
        return false;
    };
    if (!($('#CoBuyer').val())) {
        toastr.error("Enter the name of the 'Co buyer' field from the webservice response.", "Message");
        $('#CoBuyer').focus();
        return false;
    };

    if(!($('#Trim').val())) {
        toastr.error("Enter the name of the 'Trim' field from the webservice response.", "Message");
        $('#Trim').focus();
        return false;
    };

    if (!($('#Vin').val())) {
        toastr.error("Enter the name of the 'Vin' field from the webservice response.", "Message");
        $('#Vin').focus();
        return false;
    };
    
    // 
    if(!($('#BeginningOdometer').val())) {
        toastr.error("Enter the name of the 'Beginning Odometer' field from the webservice response.", "Message");
        $('#BeginningOdometer').focus();
        return false;
    };

    if (!($('#Address1').val())) {
        toastr.error("Enter the name of the 'Address 1' field from the webservice response.", "Message");
        $('#Address1').focus();
        return false;
    };

    if(!($('#Address2').val())) {
        toastr.error("Enter the name of the 'Address 2' field from the webservice response.", "Message");
        $('#Address2').focus();
        return false;
    };

    if (!($('#City').val())) {
        toastr.error("Enter the name of the 'City' field from the webservice response.", "Message");
        $('#City').focus();
        return false;
    };

    if(!($('#State').val())) {
        toastr.error("Enter the name of the 'State' field from the webservice response.", "Message");
        $('#State').focus();
        return false;
    };

    if(!($('#ZipCode').val())) {
        toastr.error("Enter the name of the 'Zip Code' field from the webservice response.", "Message");
        $('#ZipCode').focus();
        return false;
    };

    if(!($('#Country').val())) {
        toastr.error("Enter the name of the 'Country' field from the webservice response.", "Message");
        $('#Country').focus();
        return false;
    };

    if(!($('#Telephone').val())) {
        toastr.error("Enter the name of the 'Telephone' field from the webservice response.", "Message");
        $('#Telephone').focus();
        return false;
    };

    if (!($('#Email').val())) {
        toastr.error("Enter the name of the 'Email' field from the webservice response.", "Message");
        $('#Email').focus();
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
            BeginningOdometer: $('#BeginningOdometer').val(),
            Address1: $('#Address1').val(),
            Address2: $('#Address2').val(),
            City: $('#City').val(),
            State: $('#State').val(),
            StateCode: $('#StateCode').val(),
            ZipCode: $('#ZipCode').val(),
            Country: $('#Country').val(),
            CountryCode: $('#CountryCode').val(),
            Telephone: $('#Telephone').val(),
            Email: $('#Email').val(),
            LienHolderName: $('#LienHolderName').val(),
            LienHolderAddress: $('#LienHolderAddress').val(),
            LienHolderCity: $('#LienHolderCity').val(),
            LienHolderState: $('#LienHolderState').val(),
            LienHolderZip: $('#LienHolderZip').val(),
            LienHolderEmail: $('#LienHolderEmail').val(),
            LienHolderPhone: $('#LienHolderPhone').val(),
            LienHolderFax: $('#LienHolderFax').val(),
            LienHolderType: $('#LienHolderType').val(),
            LienHolderContact: $('#LienHolderContact').val(),
            TaxRate: $('#TaxRate').val(),
            VehiclePurchasePrice: $('#VehiclePurchasePrice').val(),
            Disclosure: $('#Disclosure').code()
        },
        success: function (msg) {
            saveLogo($('#DealerIdHidden').val(), function(callback){
                if(callback==true)
                {
                    setTimeout(function(){
                       window.location.href = $('#redirectAction').text();
                    }, 2000);  
                }
            });
            toastr.success("Dealer settings has been saved.", "Success");
        },
        error: function (msg) {
            toastr.error(msg);
        }
    });
});

$(".deleteDealer").click(function () {
    var id = $(this).attr('name');
    deleteDealer(id);
});

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
                toastr.error("Please delete user and products before","Message");
            };
        },
        error: function (msg) {
            toastr.error("Please delete user before","Message");
        }
    });
}

$("body").on("click", "a", function (event) {
    AccountNumberGlobal = $(this).attr('name');
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
            if (msg == 'duplicate') {
                toastr.error("Cannot duplicate one existing configuration");
                return false;
            } else {
                $('#addModal').modal('hide');
                $('#DealerId option').eq(1).prop('selected', true);
                $('#CompanyId option').eq(1).prop('selected', true);
                $('#DealerCode').val("");
                toastr.success("The setting has been saved", "Success");
                window.location.href = "settings-dealercode";    
            }
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
            $("#AccountNumberHidden").val(AccountNumberGlobal);
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
        url: "update-settingcode",
        data: {
            AccountNumber: AccountNumberValue,
            DealerId: $('#DealerIdModified').val(),
            CompanyId: $('#CompanyIdModified').val(),
            DealerCode: $('#DealerCodeModified').val()
        },
        success: function (msg) {
            toastr.success("The selected setting has been updated", "Success");
            $('#ModifyModal').modal('hide');
            window.location.href = "settings-dealercode?DealerId=" + $('#DealerIdModified').val();
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
            toastr.success("The selected setting has been removed", "Success");
            window.location.href = "settings-dealercode";
        },
        failure: function (msg) {
        }
    });
}