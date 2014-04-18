var selectedTab = $('ul#optionsCostPrice li.active').text();

$(document).ready(function () {
    StartToastMessage();
});

$("body").on("click", "a", function (event) {
    globalProductId = $(this).attr('name');
});

$(document).on('change', 'select[id^="CompanyId"]', function () {
    $('#range').hide();
    $('#MileageAddProduct').hide();
    $('#TireRotationAddProduct').hide();
    $('#IntervalAddProduct').hide();
    loadCompanyProducts($(this).val(), 'addLabel');
});

$(document).on('change', 'select[id^="CompanyIdModified"]', function () {
    $('#range').hide();
    $('#MileageModifiedProduct').hide();
    $('#TireRotationModifiedProduct').hide();
    $('#IntervalModifiedProduct').hide();
    if ($(this).val() != 2 && $('#productNameModified option:selected').val() != 12) {
        $('#VehiclePlanModifiedProduct').hide();
    }

    loadCompanyProducts($(this).val(), 'modifyLabel');
});

$(document).on('change', 'select[id^="ProductName"]', function () {
    $('#displayName').val($('#ProductName option:selected').text());

    if ($('#CompanyId option:selected').val() == 2) {
        createSelectProtectiveNew($('#ProductName option:selected').text());

        switch ($('#ProductName option:selected').val()) {
            case '12': $('#VehiclePlanAddProduct').show(); $('#MileageAddProduct').show(); $('#range').hide(); break;
            case '11': $('#VehiclePlanAddProduct').hide(); $('#MileageAddProduct').hide(); $('#range').show(); break;
            default: $('#VehiclePlanAddProduct').hide(); $('#MileageAddProduct').hide(); $('#range').hide(); break;
        }

    } else {
        if ($('#CompanyId option:selected').val() == 1 && $('#ProductName option:selected').val() == 2 || $('#ProductName option:selected').val() == 4) {
            $('#MileageAddProduct').show();
        } else {
            $('#MileageAddProduct').hide();
        }

        if ( $('#ProductName option:selected').val() == 4 )
        {
            $('#TireRotationAddProduct').show();
            $('#IntervalAddProduct').show();
        } else {
            $('#TireRotationAddProduct').hide();
            $('#IntervalAddProduct').hide();
        }

        createSelectNew($('#ProductName option:selected').text());
    }
});

$(document).on('change', 'select[id^="productNameModified"]', function () {
    $('#displayNameModified').val($('#productNameModified option:selected').text());
    if ($('#CompanyIdModified option:selected').val() == 2) {
        createSelectProtectiveModified($('#productNameModified option:selected').text());
        switch ($('#productNameModified option:selected').val()) {
            case '12': $('#VehiclePlanModifiedProduct').show(); $('#MileageModifiedProduct').show(); $('#range').hide(); break;
            case '11': $('#VehiclePlanModifiedProduct').hide(); $('#MileageModifiedProduct').hide(); $('#range').show(); break;
            default: $('#VehiclePlanModifiedProduct').hide(); $('#MileageModifiedProduct').hide(); $('#range').hide(); break;
        }
    } else {
        if ($('#CompanyIdModified option:selected').val() == 1 && $('#productNameModified option:selected').val() == 2 || $('#productNameModified option:selected').val() == 4) {
            $('#MileageModifiedProduct').show();
        } else {
            $('#MileageModifiedProduct').hide();
        }

        if ( $('#productNameModified option:selected').val() == 4 )
        {
            $('#TireRotationModifiedProduct').show();
            $('#IntervalModifiedProduct').show();
        } else {
            $('#TireRotationModifiedProduct').hide();
            $('#IntervalModifiedProduct').hide();
        }

        createSelect($('#productNameModified option:selected').text());
    }
});

onCheckToggle('#UseType', "#Type");
onCheckToggle('#UseTypeModified', "#TypeModified");
onCheckToggle('#UseTerm', "#Term");
onCheckToggle('#UseTermModified', "#TermModified");
onCheckToggle('#UseDeductible', "#Deductible");
onCheckToggle('#UseDeductibleModified', "#DeductibleModified");
onCheckToggle('#UseVehiclePlan', "#VehiclePlan");
onCheckToggle('#UseVehiclePlanModified', "#VehiclePlanModified");
onCheckToggle('#UseMileage', "#Mileage");
onCheckToggle('#UseMileageModified', "#MileageModified");
onCheckToggle('#UseTireRotation', "#TireRotation");
onCheckToggle('#UseTireRotationModified', "#TireRotationModified");

function onCheckToggle(checkId, fieldId)
{
    $(checkId).click(function () {
        if ($(this).prop("checked")) {
            $(fieldId).prop("disabled", false);
        } else {
            $(fieldId).prop("disabled", true);
        }
    });
}

$('input[name=mediaType]').change(
    function () {
        var radioOption = $(this).val();

        if (radioOption == 'VideoURL') {
            $('#BrochureImage').uploadify('cancel');
            $('#BrochureImageRefer').val('');
            $('#showOptions').css('padding-top', '9px');
            $('#radios').css('padding-top', '9px');
            $("#optionsBlock").removeAttr("style");
            $('#brochureOption').hide();
            $('#videoOption').show();
            $('#urlVideo').val('');
            $('#urlVideo').focus();
        } else {
            $('#showOptions').css('padding-top', '9px');
            $('#optionsBlock').css('padding-top', '34px');
            $('#radios').css('padding-top', '9px');
            $('#brochureOption').show();
            $('#videoOption').hide();
        }
    }
);

$('input[name=mediaTypeModified]').change(
    function () {
        var radioOption = $(this).val();

        if (radioOption == 'VideoURL') {
            $('#BrochureImageModified').uploadify('cancel');
            $('#BrochureImageReferModified').val('');
            $('#showOptionsModified').css('padding-top', '2px');
            $('#brochureOptionModified').hide();
            $('#videoOptionModified').show();
            $('#urlVideoModified').focus();
        } else {
            $('#showOptionsModified').css('padding-top', '9px');
            $('#brochureOptionModified').show();
            $('#videoOptionModified').hide();
        }
    }
);

$('#showOptions').click(function () {
    if ($('#sizeOptions').is(':visible')) {
        $('#sizeOptions').hide();
        $('#showOptions').text('Show Options');
        if ($("input[name=mediaType]:checked").val() == 'Image') {
            $('#optionsBlock').css('padding-top', '34px');
        }
    } else {
        $('#sizeOptions').show();
        if ($("input[name=mediaType]:checked").val() == 'Image') {
            $('#optionsBlock').css('padding-top', '34px');
        }
        $('#showOptions').text('Hide Options');
    }
});

$('#showOptionsModified').click(function () {
    if ($('#sizeOptionsModified').is(':visible')) {
        $('#sizeOptionsModified').hide();
        $('#showOptionsModified').text('Show Options');
    } else {
        $('#sizeOptionsModified').show();
        $('#showOptionsModified').text('Hide Options');
    }
});

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
        $("#TypeRange").prop("disabled", false);
        $("#btnSetPrices").prop("disabled", false);
        $("#useWS").prop("checked", false);
        $('#webservicelink').removeAttr('data-toggle');
    } else {
        $("#cost").prop('disabled', false);
        $("#cost").val($("#costHidden").text());
        $("#cost").focus();
        $("#sellingPrice").prop('disabled', false);
        $("#sellingPrice").val($("#sellingPriceHidden").text());
        $("#TypeRange").prop("disabled", true);
        $("#costModified").prop('disabled', false);
        $("#costModified").val($("#costHidden").text());
        $("#costModified").focus();
        $("#sellingPriceModified").prop('disabled', false);
        $("#sellingPriceModified").val($("#sellingPriceHidden").text());
        $("#TypeRange").prop("disabled", true);
        $("#btnSetPrices").prop("disabled", true);
    }
})

$("#useWS").click(function () {
    if ($(this).prop("checked")) {
        if ($('#webservicetab').hasClass('disabled')) {
            $('#webservicetab').removeClass('disabled');
        }
        $("#useManualPricing").prop("checked", false);
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
        $("#TypeRange").prop("disabled", true);
        $("#btnSetPrices").prop("disabled", true);
        $('#manuallink').removeAttr('data-toggle');
        $('#webservicelink').attr('data-toggle', 'tab');
        $('#webservice').addClass('active');
        $('#webservicetab').addClass('active');
        $('#manual').removeClass('active');
        $('#manualtab').removeClass('active');
    } else {
        $('#manuallink').attr('data-toggle', 'tab');
        $('#manualtab').addClass('active');
        $('#webservicetab').removeClass('active');
        $('#manual').addClass('active');
        $('#webservice').removeClass('active');
        $('#webservicelink').removeAttr('data-toggle');
        $("#cost").prop('disabled', false);
        $("#cost").val($("#costHidden").text());
        $("#cost").focus();
        $("#sellingPrice").prop('disabled', false);
        $("#sellingPrice").val($("#sellingPriceHidden").text());
        $("#TypeRange").prop("disabled", true);
        $("#costModified").prop('disabled', false);
        $("#costModified").val($("#costHidden").text());
        $("#costModified").focus();
        $("#sellingPriceModified").prop('disabled', false);
        $("#sellingPriceModified").val($("#sellingPriceHidden").text());
    }
});

$('#saveProduct').click(function () {
    var UseTypeValue;
    var UseDeductibleValue;
    var UseTermValue;
    var UseVehiclePlanValue;
    var UsingWebServiceInfo;
    var UseMileageValue;
    var UseTireRotationValue;
    var UseIntervalValue;
    var BrochureValue;
    var ProductNameValue;
    var TypeValue;
    var TermValue;
    var DeductibleValue;
    var selectedTab = $('ul#optionsCostPrice li.active').text();
    var rangePricingValue;
    var IsTaxableValue;

    switch (selectedTab) {
        case 'Manual': var SellingPrice = $('#sellingPrice').val().replace('$', '');
            var Cost = $('#cost').val().replace('$', '');
            SellingPrice = GetFloat(SellingPrice);
            Cost = GetFloat(Cost);
            UsingWebServiceInfo = 0;
            TypeValue = null;
            TermValue = null;
            DeductibleValue = null;

            if (!$('#useManualPricing').prop("checked")) {
                if (!($('#cost').val()) || !($('#sellingPrice').val())) {
                    toastr.error('Enter the cost and price', "Message");
                    return false;
                } else {
                    if (isNaN($('#cost').val()) || isNaN($('#sellingPrice').val())) {
                        if (!ValidateExpression(Cost, 'Money')) {
                            $('#cost').focus();
                            toastr.error('Invalid cost format', "Message");
                            return false;
                        }

                        if (!ValidateExpression(SellingPrice, 'Money')) {
                            $('#sellingPrice').focus();
                            toastr.error('Invalid selling price format', "Message");
                            return false;
                        }
                    }
                }
            }

            break;
        case 'Web Service': var SellingPrice = 0;
            var Cost = 0;
            SellingPrice = GetFloat(SellingPrice);
            Cost = GetFloat(Cost);
            UsingWebServiceInfo = 1;
            TermValue = $('#Term').val();
            DeductibleValue = $('#Deductible').val();

            UseTypeValue = getBitFromCheckBox('#UseType');
            UseTermValue = getBitFromCheckBox('#UseTerm');
            UseDeductibleValue = getBitFromCheckBox('#UseDeductible');
            UseVehiclePlanValue = getBitFromCheckBox('#UseVehiclePlan');
            break;
    }

    if ($('#useManualPricing').prop("checked")) {
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

    if ($('#useManualPricing').prop("checked")) {
        TypeValue = $('#TypeRange').val();
        UsingWebServiceInfo = 0;
    } else {
        TypeValue = $('#Type').val();
        UsingWebServiceInfo = getBitFromCheckBox('#useWS');
    }

    UseMileageValue = getBitFromCheckBox('#UseMileage');
    UseTireRotationValue = getBitFromCheckBox('#UseTireRotation');
    UseIntervalValue = getBitFromCheckBox('#UseInterval');
    IsTaxableValue = getBitFromCheckBox('#IsTaxable');

    if (SellingPrice < 0 && Cost < 0) {
        toastr.error('The cost and selling price must be positive numbers', "Message");
        return false;
    }

    if ($("input[name=mediaType]:checked").val() == 'VideoURL') {
        if (validateURL($('#urlVideo').val())) {
            BrochureValue = $('#urlVideo').val();
        }
        else {
            $('#urlVideo').focus();
            toastr.error('Invalid URL', "Message");
            return false;
        }
    }

    var emptyBullets = true;

    for (i = 1; i <= 5; i++) {
        if ($('#bulletPoint' + i).val() != '') {
            emptyBullets = false;
        }
    }

    if (emptyBullets == true) {
        toastr.error('At least one bullet point must be specified', "Message");
        return false;
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
            Mileage: $('#Mileage').val(),
            TireRotation: $('#TireRotation').val(),
            Interval: $('#Interval').val(),
            IsTaxable: IsTaxableValue,
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
            PricingArray: getRangePricing(),
            UseDeductible: UseDeductibleValue,
            UseVehiclePlan: UseVehiclePlanValue,
            UseMileage: UseMileageValue,
            UseTireRotation: UseTireRotationValue,
            UseInterval: UseIntervalValue,
            BrochureImage: BrochureValue,
            BrochureHeight: $('#BrochureHeight').val(),
            BrochureWidth: $('#BrochureWidth').val()
        },
        success: function (idSaved) {
            resetInputs();
            saveDocument(idSaved, function (callback) {
              if (callback == true) {
                  if ( $('#PDFSelected').val() != 'yes') {
                      $.unblockUI();
                      toastr.success("The product has been added", "Success");
                      setTimeout(function(){
                        window.location.href = 'settings-page';
                      },3000);
                  }
              }
            });
        },
        failure: function (idSaved) {
            $.unblockUI();
            toastr.error('Error, try again', "Message");
        }
    });
});

function resetInputs() {
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

$('#updateInfo').click(function () {
    var UsingWebServiceInfo;
    var UseTypeValue;
    var UseDeductibleValue;
    var UseTermValue;
    var UseVehiclePlanValue;
    var UseMileageValue;
    var UseTireRotationValue;
    var UseIntervalValue;
    var BrochureValue;
    var selectedTab = $('ul#optionsCostPrice li.active').text();
    var SellingPrice = $('#sellingPriceModified').val().replace('$', '');
    var Cost = $('#costModified').val().replace('$', '');
    var typeValue;
    var IsTaxableValue;

    $('#videoOptionModified').hide();
    $('#brochureOptionModified').show();

    switch (selectedTab) {
        case 'Manual':
            if (!$('#useManualPricing').prop("checked")) {
                if (!($('#costModified').val()) || !($('#sellingPriceModified').val())) {
                    toastr.error('Please fill the cost and price fields', "Message");
                    return false;
                }

                if (SellingPrice < 0 && Cost < 0) {
                    toastr.error('The cost and selling price must be positive numbers', "Message");
                    return false;
                }

                if (!ValidateExpression(Cost, 'Money')) {
                    $('#costModified').focus();
                    toastr.error('Invalid cost format', "Message");
                    return false;
                };

                if (!ValidateExpression(SellingPrice, 'Money')) {
                    $('#sellingPriceModified').focus();
                    toastr.error('Invalid selling price format', "Message");
                    return false;
                };

                SellingPrice = GetFloat(SellingPrice);
                Cost = GetFloat(Cost);
            }
            break;
    }

    var emptyBullets = true;

    for (i = 1; i <= 5; i++) {
        if ($('#bulletPoint' + i + 'Modified').val() != '') {
            emptyBullets = false;
        }
    }

    if (emptyBullets == true) {
        toastr.error('At least one bullet point must be specified', "Message");
        return false;
    }

    if ($('#useManualPricing').prop("checked")) {
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

    if ($('#useManualPricing').prop("checked")) {
        typeValue = $('#TypeRange').val();
    } else {
        typeValue = $('#TypeModified').val();
    }
     
    if ($('#useWS').prop("checked")) {
        UsingWebServiceInfo = 1;
        rangePricingValue = '0';
    } else {
        UsingWebServiceInfo = 0;
    }

    UseTypeValue = getBitFromCheckBox('#UseTypeModified');
    UseTermValue = getBitFromCheckBox('#UseTermModified');
    UseDeductibleValue = getBitFromCheckBox('#UseDeductibleModified');
    UseVehiclePlanValue = getBitFromCheckBox('#UseVehiclePlanModified');
    UseMileageValue = getBitFromCheckBox('#UseMileageModified');
    UseTireRotationValue = getBitFromCheckBox('#UseTireRotationModified');
    UseIntervalValue = getBitFromCheckBox('#UseIntervalModified');
    IsTaxableValue = getBitFromCheckBox('#IsTaxableModified');

    if ($("input[name=mediaTypeModified]:checked").val() == 'VideoURL')
    {
        if (validateURL($('#urlVideoModified').val())) {
            BrochureValue = $('#urlVideoModified').val();
        }
        else
        {
            $('#urlVideoModified').focus();
            toastr.error('Invalid URL', "Message");

            return false;
        }
    }
    else
    {
        BrochureValue = $('#BrochureImageData').val();
    }

    $.blockUI();
    $.ajax({
        type: "GET",
        url: "updateProduct",
        data: {
            ProductId: $('#idModified').val(),
            rangePricing: rangePricingValue,
            PricingArray: getRangePricing(),
            ProductBaseId: $('#productNameModified').val(),
            ProductName: $('#productNameModified option:selected').text(),
            displayName: $('#displayNameModified').val(),
            ProductDescription: $('#ProductDescriptionModified').val(),
            Term: $('#TermModified').val(),
            Deductible: $('#DeductibleModified').val(),
            VehiclePlan: $('#VehiclePlanModified').val(),
            Mileage: $('#MileageModified').val(),
            TireRotation: $('#TireRotationModified').val(),
            Interval: $('#IntervalModified').val(),
            IsTaxable: IsTaxableValue,
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
            UseMileage: UseMileageValue,
            UseTireRotation: UseTireRotationValue,
            UseInterval: UseIntervalValue,
            BrochureHeight: $('#BrochureHeightModified').val(),
            BrochureWidth: $('#BrochureWidthModified').val(),
            BrochureImage: BrochureValue
        },
        success: function (msg) {
            uploadModifiedData(function (callback) {
                if (callback == true) {
                  if ( $('#PDFSelected').val() != 'yes') {
                      $.unblockUI(); 
                      toastr.success("The product has been updated", "Success");
                      setTimeout(function(){
                        window.location.href = 'settings-page';
                      },3000);
                  }
                }
            });
        },
        failure: function (msg) {
            $.unblockUI();
        }
    });
});

$('#saveRangePricing').click( function() {
  var rangePricingValue;
  var notnumber = false;
  var empty = false;

  $('#RangePricingModal').find('input[type=text]').each(function() {
    var value = $(this).val();
    
    if ( isNaN(value)) {
      notnumber = true;
    }
    
    if (!value) {
      empty = true;
    }

  });

  if (notnumber == true) {
    toastr.error("The fields must be filled with numbers not letters", "Error");
    return false;
  }

  if ( empty == true) {
    toastr.error("Please complete all the fields", "Error");
    return false;
  }

    if ($('#useManualPricing').prop("checked")) {
        rangePricingValue = '1';
    } else {
        rangePricingValue = '0';
    }

    $.ajax({
        type: "GET",
        url: "saveRangePricing",
        data: {
            ProductId: $('#idModified').val(),
            ProductBaseId: $('#productNameModified').val(),
            rangePricing: rangePricingValue,
            Type: $('#TypeRange').val(),
            PricingArray: getRangePricing()
        },
        success: function (msg) {
            $('#RangePricingModal').modal('hide');
        },
        failure: function (msg) {
            toastr.error(msg, "Message");
        }
    });
})

function loadCompanyProducts(companyId, typeSelected) {
    var ProductList;
    $('#ProductName option').remove();
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
                ProductList = $('#ProductName');
            } else {
                ProductList = $('#productNameModified');
            }

            var data = JSON.parse(msg);
            var i = 0;
            $.each(data, function () {
                $('<option>').val(data[i].ProductBaseId).text(data[i].ProductName).appendTo(ProductList);
                i = i + 1;
            });

            option = $('#ProductName option').val();
            $('.check').val(option).trigger('change');
            $('#displayName').val($('#ProductName option:selected').text());
            if (companyId == 2) {
                createSelectProtectiveModified($('#productNameModified option:selected').text());
                createSelectProtectiveNew($('#ProductName option:selected').text());
                if ($('#ProductName option:selected').text() == 'Total Lost Protection (GAP)' || $('#productNameModified option:selected').text() == 'Total Lost Protection (GAP)') {
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

function createSelectProtectiveNew(product) {
    var selectTerm = $('#Term');
    var selectDeductible = $('#Deductible');
    var selectType = $('#Type');
    var selectMileage = $('#Mileage');

    $('#Term option').remove();
    $('#Deductible option').remove();
    $('#Type option').remove();
    

    var option = product.trim();

    switch (option) {
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
        case 'Vehicle Service Contract': 
            $('#Mileage option').remove();
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
            $('<option>').val('ADVANTAGE').text('ADVANTAGE').appendTo(selectType);
            $('<option>').val('ADVANTAGE ASIAN CERTIFIED').text('ADVANTAGE ASIAN CERTIFIED').appendTo(selectType);
            $('<option>').val('POWERTRAIN').text('POWERTRAIN').appendTo(selectType);
            $('<option>').val('POWERTRAIN PLUS').text('POWERTRAIN PLUS').appendTo(selectType);
            $('<option>').val('PREFERRED').text('PREFERRED').appendTo(selectType);
            $('<option>').val('PREFERRED ASIAN CERTIFIED').text('PREFERRED ASIAN CERTIFIED').appendTo(selectType);
            $('<option>').val('ADVANTAGE WRAP').text('ADVANTAGE WRAP').appendTo(selectType);
            $('<option>').val('PREFERRED WRAP').text('PREFERRED WRAP').appendTo(selectType);
            $('<option>').val('SELECT NEW').text('SELECT NEW').appendTo(selectType);
            $('<option>').val('36').text('36').appendTo(selectMileage);
            $('<option>').val('45').text('45').appendTo(selectMileage);
            $('<option>').val('48').text('48').appendTo(selectMileage);
            $('<option>').val('50').text('50').appendTo(selectMileage);
            $('<option>').val('60').text('60').appendTo(selectMileage);
            $('<option>').val('70').text('70').appendTo(selectMileage);
            $('<option>').val('75').text('75').appendTo(selectMileage);
            $('<option>').val('100').text('100').appendTo(selectMileage);
            $('<option>').val('120').text('120').appendTo(selectMileage);
            $('<option>').val('125').text('125').appendTo(selectMileage);
            $('<option>').val('150').text('150').appendTo(selectMileage);
            break;
        case 'Dent': $('<option>').val('12').text('12').appendTo(selectTerm);
            $('<option>').val('24').text('24').appendTo(selectTerm);
            $('<option>').val('30').text('30').appendTo(selectTerm);
            $('<option>').val('36').text('36').appendTo(selectTerm);
            $('<option>').val('48').text('48').appendTo(selectTerm);
            $('<option>').val('60').text('60').appendTo(selectTerm);
            $('<option>').val('72').text('72').appendTo(selectTerm);
            $('<option>').val('84').text('84').appendTo(selectTerm);
            break;
        case 'Tire and Wheel': $('<option>').val('12').text('12').appendTo(selectTerm);
            $('<option>').val('24').text('24').appendTo(selectTerm);
            $('<option>').val('30').text('30').appendTo(selectTerm);
            $('<option>').val('36').text('36').appendTo(selectTerm);
            $('<option>').val('48').text('48').appendTo(selectTerm);
            $('<option>').val('60').text('60').appendTo(selectTerm);
            $('<option>').val('72').text('72').appendTo(selectTerm);
            $('<option>').val('84').text('84').appendTo(selectTerm);
            break;
        default: $('<option>').val(0).text(0).appendTo(selectTerm);
            $('<option>').val(0).text(0).appendTo(selectDeductible);
            $('<option>').val('None').text('None').appendTo(selectType);
            break;

    }
}

function createSelectProtectiveModified(product) {
    var selectTerm = $('#TermModified');
    var selectDeductible = $('#DeductibleModified');
    var selectType = $('#TypeModified');
    var selectMileageModified = $('#MileageModified');

    $('#TermModified option').remove();
    $('#DeductibleModified option').remove();
    $('#TypeModified option').remove();

    var option = product.trim();

    switch (option) {
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
        case 'Vehicle Service Contract': 
            $('#MileageModified option').remove();
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
            $('<option>').val('ADVANTAGE').text('ADVANTAGE').appendTo(selectType);
            $('<option>').val('ADVANTAGE ASIAN CERTIFIED').text('ADVANTAGE ASIAN CERTIFIED').appendTo(selectType);
            $('<option>').val('POWERTRAIN').text('POWERTRAIN').appendTo(selectType);
            $('<option>').val('POWERTRAIN PLUS').text('POWERTRAIN PLUS').appendTo(selectType);
            $('<option>').val('PREFERRED').text('PREFERRED').appendTo(selectType);
            $('<option>').val('PREFERRED ASIAN CERTIFIED').text('PREFERRED ASIAN CERTIFIED').appendTo(selectType);
            $('<option>').val('ADVANTAGE WRAP').text('ADVANTAGE WRAP').appendTo(selectType);
            $('<option>').val('PREFERRED WRAP').text('PREFERRED WRAP').appendTo(selectType);
            $('<option>').val('SELECT NEW').text('SELECT NEW').appendTo(selectType);
            $('<option>').val('36').text('36').appendTo(selectMileageModified);
            $('<option>').val('45').text('45').appendTo(selectMileageModified);
            $('<option>').val('48').text('48').appendTo(selectMileageModified);
            $('<option>').val('50').text('50').appendTo(selectMileageModified);
            $('<option>').val('60').text('60').appendTo(selectMileageModified);
            $('<option>').val('70').text('70').appendTo(selectMileageModified);
            $('<option>').val('75').text('75').appendTo(selectMileageModified);
            $('<option>').val('100').text('100').appendTo(selectMileageModified);
            $('<option>').val('120').text('120').appendTo(selectMileageModified);
            $('<option>').val('125').text('125').appendTo(selectMileageModified);
            $('<option>').val('150').text('150').appendTo(selectMileageModified);
            break;
        default: $('<option>').val(0).text(0).appendTo(selectTerm);
            $('<option>').val(0).text(0).appendTo(selectDeductible);
            $('<option>').val('None').text('None').appendTo(selectType);
            break;

    }
}

function createSelectNew(product) {
    var selectTerm = $('#Term');
    var selectDeductible = $('#Deductible');
    var selectType = $('#Type');
    var selectMileage = $('#Mileage');

    $('#Term option').remove();
    $('#Deductible option').remove();
    $('#Type option').remove();

    var option = product.trim();

    switch (option) {
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
        case 'Maintenance Plan':
            $('#Mileage option').remove();
            $('<option>').val('12').text('12').appendTo(selectTerm);
            $('<option>').val('24').text('24').appendTo(selectTerm);
            $('<option>').val('36').text('36').appendTo(selectTerm);
            $('<option>').val('39').text('39').appendTo(selectTerm);
            $('<option>').val('48').text('48').appendTo(selectTerm);
            $('<option>').val('60').text('60').appendTo(selectTerm);
            $('<option>').val(0).text('None').appendTo(selectDeductible);
            $('<option>').val('Maintenance - Stand Alone form').text('Maintenance - Stand Alone form').appendTo(selectType);
            $('<option>').val('Maintenance Plus - Stand Alone form').text('Maintenance Plus - Stand Alone form').appendTo(selectType);
            $('<option>').val('12000').text('12,000').appendTo(selectMileage);
            $('<option>').val('15000').text('15,000').appendTo(selectMileage);
            $('<option>').val('24000').text('24,000').appendTo(selectMileage);
            $('<option>').val('30000').text('30,000').appendTo(selectMileage);
            $('<option>').val('36000').text('36,000').appendTo(selectMileage);
            $('<option>').val('39000').text('39,000').appendTo(selectMileage);
            $('<option>').val('48000').text('48,000').appendTo(selectMileage);
            $('<option>').val('60000').text('60,000').appendTo(selectMileage);
            $('<option>').val('75000').text('75,000').appendTo(selectMileage);
            break;
        case 'Road Hazard': $('<option>').val('36').text('36').appendTo(selectTerm);
            $('<option>').val('60').text('60').appendTo(selectTerm);
            $('<option>').val('0').text('0').appendTo(selectDeductible);
            $('<option>').val('Tire and Wheel W Rental - Combo form').text('Tire and Wheel W Rental - Combo form').appendTo(selectType);
            $('<option>').val('Tire and Wheel - Combo form').text('Tire and Wheel - Combo form').appendTo(selectType);
            $('<option>').val('Tire - Combo form').text('Tire - Combo form').appendTo(selectType);
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
        case 'US Dent': $('<option>').val('12').text('12').appendTo(selectTerm);
            $('<option>').val('24').text('24').appendTo(selectTerm);
            $('<option>').val('36').text('36').appendTo(selectTerm);
            $('<option>').val('48').text('48').appendTo(selectTerm);
            $('<option>').val('60').text('60').appendTo(selectTerm);
            $('<option>').val('72').text('72').appendTo(selectTerm);
            $('<option>').val(0).text(0).appendTo(selectDeductible);
            $('<option>').val('None').text('None').appendTo(selectType);
            break;
        default: $('<option>').val(0).text(0).appendTo(selectTerm);
            $('<option>').val(0).text(0).appendTo(selectDeductible);
            $('<option>').val('None').text('None').appendTo(selectType);
            break;
    }
}

function createSelect(product) {
    var selectTermModified = $('#TermModified');
    var selectDeductibleModified = $('#DeductibleModified');
    var selectTypeModified = $('#TypeModified');
    var selectMileageModified = $('#MileageModified');

    // Removes previous options loaded
    $('#TermModified option').remove();
    $('#DeductibleModified option').remove();
    $('#TypeModified option').remove();

    var option = product.trim();

    switch (option) {
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
            $('#MileageModified option').remove();
            $('<option>').val('12').text('12').appendTo(selectTermModified);
            $('<option>').val('24').text('24').appendTo(selectTermModified);
            $('<option>').val('36').text('36').appendTo(selectTermModified);
            $('<option>').val('39').text('39').appendTo(selectTermModified);
            $('<option>').val('48').text('48').appendTo(selectTermModified);
            $('<option>').val('60').text('60').appendTo(selectTermModified);
            $('<option>').val(0).text('None').appendTo(selectDeductibleModified);
            $('<option>').val('Maintenance - Stand Alone form').text('Maintenance - Stand Alone form').appendTo(selectTypeModified);
            $('<option>').val('Maintenance Plus - Stand Alone form').text('Maintenance Plus - Stand Alone form').appendTo(selectTypeModified);
            $('<option>').val('12000').text('12,000').appendTo(selectMileageModified);
            $('<option>').val('15000').text('15,000').appendTo(selectMileageModified);
            $('<option>').val('24000').text('24,000').appendTo(selectMileageModified);
            $('<option>').val('30000').text('30,000').appendTo(selectMileageModified);
            $('<option>').val('36000').text('36,000').appendTo(selectMileageModified);
            $('<option>').val('39000').text('39,000').appendTo(selectMileageModified);
            $('<option>').val('48000').text('48,000').appendTo(selectMileageModified);
            $('<option>').val('60000').text('60,000').appendTo(selectMileageModified);
            $('<option>').val('75000').text('75,000').appendTo(selectMileageModified);
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
        case 'US Dent': $('<option>').val('12').text('12').appendTo(selectTermModified);
            $('<option>').val('24').text('24').appendTo(selectTermModified);
            $('<option>').val('36').text('36').appendTo(selectTermModified);
            $('<option>').val('48').text('48').appendTo(selectTermModified);
            $('<option>').val('60').text('60').appendTo(selectTermModified);
            $('<option>').val('72').text('72').appendTo(selectTermModified);
            $('<option>').val(0).text(0).appendTo(selectDeductibleModified);
            $('<option>').val('None').text('None').appendTo(selectTypeModified);
            break;
        default:
            $('<option>').val(0).text('None').appendTo(selectTermModified);
            $('<option>').val(0).text('None').appendTo(selectDeductibleModified);
            $('<option>').val('None').text('None').appendTo(selectTypeModified);
            break;
    }
}

function getRangePricing()
{
    var termFrom = document.getElementsByName("TermFrom");
    var termTo = document.getElementsByName("TermTo");
    var sellingPrice = document.getElementsByName("SellingPrice");

    var prices = [];

    prices.push(addRangeByType(termFrom, termTo, sellingPrice, 'Lease'));
    prices.push(addRangeByType(termFrom, termTo, sellingPrice, 'Balloon'));
    prices.push(addRangeByType(termFrom, termTo, sellingPrice, 'Purchase'));

    return prices;
}

function addRangeByType(termFrom, termTo, sellingPrice, type)
{
    var data = [], elements = document.getElementsByName('Cost' + type);
    
    for (var i = 0; i < elements.length; i++)
    {
        data[i] = {
            TermFrom: getInt($(termFrom[i]).val()),
            TermTo: getInt($(termTo[i]).val()),
            PricingCost: getFloat($(elements[i]).val()),
            PricingType: getPricingType(type),
            SellingPrice: getFloat($(sellingPrice[i]).val())
        };
    }

    return data;
}

function getPricingType(type)
{
    if (type == "Lease")
        return "Gap Lease";
    else
        if (type == "Balloon")
            return "Gap Balloon";
        else
            if (type == "Purchase")
                return "Gap Purchase";
            else
                return null;
}
