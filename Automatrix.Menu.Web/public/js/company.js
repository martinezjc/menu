var companyId;
var productIdGlobal;

$(document).ready(function () {
    loadListCompanyProducts( $('#CompanyIdSetting option').eq(0).val() );
});

$("body").on("click", "a", function (event) {
    companyId = $(this).attr('name');
    productIdGlobal = $(this).attr('name');
});

// Bindings

$('#CompanyName').bind('keyup', function(e){
    $('#company-name-group').hasClass('has-error') && $('#company-name-group').removeClass('has-error');
})

$('#URL').bind('keyup', function(e){
    $('#company-url-group').hasClass('has-error') && $('#company-url-group').removeClass('has-error');
})

$('#CompanyNameUpdate').bind('keyup', function(e){
    $('#company-name-group-modified').hasClass('has-error') && $('#company-name-group-modified').removeClass('has-error');
})

$('#URLUpdate').bind('keyup', function(e){
    $('#company-url-group-modified').hasClass('has-error') && $('#company-url-group-modified').removeClass('has-error');
})

// End binding

function validateURL(textval) {
      var urlregex = new RegExp(
            "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
      return urlregex.test(textval);
}

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
            toastr.error('Error :' + msg, "Message");

        }
    });
});

$('#updateCompanyInfo').click(function () {
    if (!($('#CompanyNameUpdate').val())) {
        setErrorClass('company-name-group-modified', $('#CompanyNameUpdate'), 'Please enter a company name');
        return false;
    };

    if ($('#URLUpdate').val()) {
        if (!(validateURL($('#URLUpdate').val()))) {
            setErrorClass('company-url-group-modified', $('#URL'), 'Please enter a valid URL');
            return false;
        }
    } else {
        setErrorClass('company-url-group-modified', $('#URL'), 'Please provide the URL for the company');
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
        setErrorClass('company-name-group', $('#CompanyName'), 'Please enter a company name');
        return false;
    };

     if ($('#URL').val()) {
        if (!(validateURL($('#URL').val()))) {
            setErrorClass('company-url-group', $('#URL'), 'Please enter a valid URL');
            return false;
        }
    } else {
        setErrorClass('company-url-group', $('#URL'), 'Please provide the URL for the company');
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
            toastr.error('Table could not be loaded', "Message");
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