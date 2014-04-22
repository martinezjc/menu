$(document).ready(function() {
	calculateCheckedProducts();
});

function calculateCheckedProducts() {
	var financedAmount = getCurrentFinancedAmount();
	var apr = getCurrentAPR();
	var term = getCurrentTerm();

	calculateAcceptedProducts(financedAmount, term, apr);
	calculateRejectedProducts(financedAmount, term, apr);
}

function calculateAcceptedProducts(financedAmount, term, apr)
{
    var total = getAcceptedProductsAmount(), originalMonthlyPayment = getMonthlyPayment(financedAmount, term, apr);
	
    $("#BasePaymentHidden").text(getAmount(originalMonthlyPayment));
    
    var newMonthlyPayment = getMonthlyPayment(financedAmount + total, term, apr);
    var additionalMonthlyPayment = newMonthlyPayment - originalMonthlyPayment;
    var costPerDay = (additionalMonthlyPayment / 30).toFixed(2);
        
    $("#TotalAccepted").text(getAmount(newMonthlyPayment));  

    // Required for PDF export
    $("#UpdatedPayment").val(newMonthlyPayment);
}

function calculateRejectedProducts(financedAmount, term, apr)
{
    
	var productPrice = 0, originalMonthlyPayment = getMonthlyPayment(financedAmount, term, apr);
	var monthlyProductPayment = 0, additionalProductPayment = 0, dailyRejectedCost = 0;
	var totalMonthlyRejectedPayment = 0, totalDailyRejectedPayment = 0;
	
    $('#RejectedTable .products').each(function () {
        
        var IsTaxable = $(this).find( ':checkbox' ).attr('tax');
        productPrice = getFloat($(this).find(':checkbox').val());
        
        if (IsTaxable == 1) {
            productPrice = ApplyTaxRate(productPrice);
        }

        monthlyProductPayment = getMonthlyPayment(financedAmount + productPrice, term, apr);
        additionalProductPayment = monthlyProductPayment - originalMonthlyPayment;
        dailyProductCost = additionalProductPayment / 30;
        totalMonthlyRejectedPayment += additionalProductPayment;
        totalDailyRejectedPayment += dailyProductCost;
        
        $(this).find('.price-product').text(getAmount(dailyProductCost) + '/Day');
        $(this).find('.price-product').append('  ' + getAmount(additionalProductPayment) + '/MTH');
    });
    
    $("#TotalRejected").text(getAmount(totalDailyRejectedPayment));
    $("#TotalPayment").text(getAmount(totalMonthlyRejectedPayment));

    // Required for PDF export
    $("#CostPerDay").val(totalDailyRejectedPayment);
    $("#AdditionalPayment").val(totalMonthlyRejectedPayment);
}

function getAcceptedProductsAmount() {
	var total = 0;

	$("#AcceptedTable :checkbox").each(function () {
        var IsTaxable = $(this).attr("tax");
        if (IsTaxable == 1) {
            total += getFloat(ApplyTaxRate($(this).val()));
        } else{
            total += getFloat($(this).val());
        };
    });
	
	return total;
}

$(':checkbox').click(function(event) {
	checkName = $(this).attr('name');
	GlobalCkeckboxClicked = $(this);
	var id = $(this).parent().parent().parent().attr('id');

	switch (checkName) {
	case 'Accepted':
		value = $(this).val();
		$(this).prop("checked", false);
		$(this).attr('name', 'Rejected');
		$('#AcceptedTable #' + id).detach().appendTo('#RejectedTable');
		break;

	case 'Rejected':
		value = $(this).val();
		$(this).attr('name', 'Accepted');
		$('#RejectedTable #' + id).detach().appendTo('#AcceptedTable');
		$(this).prop("checked", true);
		break;
	}

	calculateCheckedProducts();
	var countProducts = 0;

	$('#AcceptedTable .products').each(function() {
		countProducts++;
		$(this).find('.price-product').text('');
		$(this).find('.price-product').append('');
	});

	if (countProducts == 0)
		$('#SaveConfig').attr('disabled', true);
	else
		$('#SaveConfig').attr('disabled', false);

});

//updateSaveDMSButton();

function updateSaveDMSButton() {
	var countProducts = 0;
	$('#AcceptedTable .products').each(function() {
		countProducts++;
	});

	if (countProducts == 0)
		$('#SaveConfig').attr('disabled', true);
	else
		$('#SaveConfig').attr('disabled', false);
}

$("#exportpdf").click(function() {
	UpdateArray();
});

function UpdateArray() {

	var Accepted2 = [];
	var Rejected2 = [];
	var CostByProduct = [];
	var CostByDayArray = new Array();
	var accepteddescriptionarray = [];
	var rejecteddescriptionarray = [];
	var index = 0;

	$("#AcceptedTable :checkbox").each(function() {
		antonio = $(this).parent().parent().parent();
		Accepted2[index] = $(this).parent().parent().parent().attr('id');
		index = index + 1;
	});
	index = 0;
	$("#RejectedTable :checkbox").each(
			function() {
				CostByProduct[index] = $(this).parent().parent().parent().find(
						'.price-product').text().trim();
				Rejected2[index] = $(this).parent().parent().parent()
						.attr('id');
				index = index + 1;
			});

	var index = 0;
	$('#AcceptedTable div.displayname-product').each(function() {
		accepteddescriptionarray[index] = $(this).text().trim() + "!";
		index = index + 1;
	});

	var index = 0;
	$('#RejectedTable div.displayname-product').each(function() {
		rejecteddescriptionarray[index] = $(this).text().trim() + "!";
		index = index + 1;
	});

	$("#acceptedarray").val(Accepted2);
	$("#rejectedarray").val(Rejected2);
	$('#costbydayarray').val(CostByProduct);
	$('#accepteddescription').val(accepteddescriptionarray);
	$('#rejecteddescription').val(rejecteddescriptionarray);
}

$("#saveModalDisclosure")
		.click(
				function() {
					var Type = $('#TypeFinance :selected').val();
					var Term = $('#TermFinance :selected').val();
					var TermText = $('#TermFinance :selected').text();
					var OrderNumber = $('#TermFinance :selected').attr(
							'OrderNumber');
					var Deductible = $("#DeductibleFinance :selected").val();
					var SellingPrice = $("#PriceProduct").val();
					var ValidatePrice = $(GlobalSectionProduct).find(
							'.ProductDeductible').attr('name');
					var ProductBaseType = $(GlobalSectionProduct).find(
							'.ProductBaseType').attr('name');
					var ProductBaseId = parseInt(GlobalSectionProduct
							.attr('name'));
					var ProductId = GlobalSectionProduct.attr('id');
					var Mileage = 0;
					var tireRotation = 0;
					var interval = 0;
					var newDescription;

					if (eval("productRates.product" + ProductId)) {
						if ((ProductBaseId == 12 || ProductBaseId == 2)
								&& ($("#TypeFinance").is(':visible'))) {
							Mileage = $('#ModalMileage :selected').val();
							Term = new String(GetValueWebService(Type,
									TermText, Mileage, tireRotation, interval,
									Deductible, ProductBaseId));
						}

						if (ProductBaseId == 4) {
							Mileage = $('#ModalMileage :selected').val();
							tireRotation = $('#TireRotation :selected').val();
							interval = $('#Interval :selected').val();

							Term = new String(GetValueWebService(Type,
									TermText, Mileage, tireRotation, interval,
									Deductible, ProductBaseId));
						}
					}

					if (ProductBaseType == 'GAP') {
						var years;
						var description = "";
						var descriptionFull = $(GlobalSectionProduct).find(
								'.displayname-product').text();

						descriptionFull = descriptionFull.split("-");

						
						try{
							description = descriptionFull[1];
						}catch(err){
							description = descriptionFull;
						}
						



						if (!TermText) {
							years = $('#TermFinance2').val() / 12;
						} else if ($('#TermFinance2').val() != '') {
							years = $('#TermFinance2').val() / 12;
						} else {
							years = TermText / 12;
						}

						if(years%1!==0)
            				years=years.toFixed(1);

						if (description != '') {
							newDescription = years + ' Years / ' + '$'
									+ Deductible.replace('D','') + ' Deductible - '
									+ description;
							if ($("#ApplyChanges").prop("checked")) {
								$(".products").each(
										function() {
											idEvaluate = $(this).attr('id');
											idSave = GlobalSectionProduct
													.attr('id');
											if (idEvaluate == idSave) {
												$(this).find(
														'.displayname-product')
														.text(newDescription);
											}
											;
										});
							} else {
								$(GlobalSectionProduct).find(
										'.displayname-product').text(
										newDescription);
							}

						} else {
							newDescription = years + ' Years / ' + '$'
									+ Deductible.replace('D','') + ' Deductible';
							if ($("#ApplyChanges").prop("checked")) {
								$(".products").each(
										function() {
											idEvaluate = $(this).attr('id');
											idSave = GlobalSectionProduct
													.attr('id');
											if (idEvaluate == idSave) {
												$(this).find(
														'.displayname-product')
														.text(newDescription);
											}
											;
										});
							} else {
								$(GlobalSectionProduct).find(
										'.displayname-product').text(
										newDescription);
							}
						}

						Term = $("#PriceProduct").val();
					}
					;

					if (ProductBaseType == 'WARRANTY' && $("#ModalMileage").is(':visible')) {
						var years = TermText / 12;
						var description = $(GlobalSectionProduct).find(
								'.description-product').text();

						if (description != '') {
							newDescription = years + ' Years / '
									+ $('#ModalMileage :selected').val()
									+ ',000 Miles / ' + '$' + Deductible.replace('D','')
									+ ' Deductible - ' + description;
							if ($("#ApplyChanges").prop("checked")) {
								$(".products").each(
										function() {
											idEvaluate = $(this).attr('id');
											idSave = GlobalSectionProduct
													.attr('id');
											if (idEvaluate == idSave) {
												$(this).find(
														'.displayname-product')
														.text(newDescription);
											}
											;
										});
							} else {
								$(GlobalSectionProduct).find(
										'.displayname-product').text(
										newDescription);
							}
						} else {
							newDescription = years + ' Years / '
									+ $('#ModalMileage :selected').val()
									+ ',000 Miles / ' + '$' + Deductible.replace('D','')
									+ ' Deductible.';
							if ($("#ApplyChanges").prop("checked")) {
								$(".products").each(
										function() {
											idEvaluate = $(this).attr('id');
											idSave = GlobalSectionProduct
													.attr('id');
											if (idEvaluate == idSave) {
												$(this).find(
														'.displayname-product')
														.text(newDescription);
											}
											;
										});
							} else {
								$(GlobalSectionProduct).find(
										'.displayname-product').text(
										newDescription);
							}
						}
					}

					SellingPrice = SellingPrice.replace('$', '');

					if (ProductBaseId == 12) {
						var Surcharges = GetSurchargesValues();
						$('#HiddenProtectiveVsc').val(Surcharges);
					}
					;

					if (!ValidateExpression(SellingPrice, 'Money')) {
						toastr.error('Invalid selling price format', "Message");
						return false;
					}
					;

					SellingPrice = GetFloat(SellingPrice).toFixed(2);

					if (ProductBaseType == 'GAP') {
						Term = $("#PriceProduct").val();
					}
					;

					if (($("#PriceProduct").is(':visible'))
							|| ($("#TermFinance").is(':visible'))) {
						$(GlobalSectionProduct).find(':checkbox').val(
								SellingPrice);
						if (GlobalValidatePrice == 1) {
							UpdatePriceWebServicesProductDisclosure(Term);
						}
					}
					if (GlobalValidatePrice == 1) {
						$(GlobalSectionProduct).find(':checkbox').attr(
								'OrderNumber', OrderNumber);

					}

					$(GlobalSectionProduct).find('.ProductType').attr('name',
							Type);
					$(GlobalSectionProduct).find('.ProductTerm').attr('name',
							TermText);
					$(GlobalSectionProduct).find('.ProductDeductible').attr(
							'name', Deductible);
					$(GlobalSectionProduct).find('.ProductMileage').attr(
							'name', Mileage);

					calculateCheckedProducts();
					$('#myModal1').modal('hide');
				})

$(".linkmodal2")
		.click(
				function() {
					GlobalSectionProduct = $(this).parent().parent();
					var Brochure = $(GlobalSectionProduct).find(
							'.BrochureImage').val();
					var dimension = $(GlobalSectionProduct).find(
							'.BrochureImage').attr('name');
					var path = $('#ImgModal2').attr('name');
					var arrayDimension = dimension.split('-');
					$('.videoPlayer1').attr('data', '');
					$('.videoPlayer2').attr('src', '');

					var height = parseInt(arrayDimension[0]);
					var width = parseInt(arrayDimension[1]);

					if (height < 10 || width < 10) {
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
						$('.videoPlayer').attr('height', height);
						$('.videoPlayer').attr('width', width);
						$('.videoPlayer1').attr('data', url);
						$('.videoPlayer2').attr('src', url);
					} else {
						$('.videoPlayer').hide();

						var img = path + Brochure;

						if (Brochure == '') {
							toastr.error('No brochure', "Message");
							return false;
						} else {
							$('#ImgModal2').show();
							$('#ImgModal2').attr('src', img);
							$('#ModalContainer').attr('height', height);
							$('#ModalContainer').attr('width', width);
						}
					}
					;
				});

$("#ButtonNext").click(function() {
	DefineId(GlobalPlanChoosed);
	var text = $("#ModelValidate").html();
	DefineId(GlobalPlanChoosed)
	if (ValidationEmptyDeal()) {
		return false;
	}
	;
});

function UpdatePriceWebServicesProductDisclosure(term) {
	if (GlobalValidatePrice == 1) {
		$(GlobalSectionProduct).find(':checkbox').val(term);
	}
	;
}

$("#SaveConfig").click(function(event) {
	$("#SaveConfig").attr("disabled", "disabled");
	products = new Array();
	$("#AcceptedTable section").each(function() {
		product = new Object();
		product.ID = $(this).attr('name');
		product.OrderNumber = $(this).find(':checkbox').attr('OrderNumber');
		product.Amount = GetFloat($(this).find(':checkbox').val());
		products.push(product);
	});
	products = JSON.stringify(products);
	SavetoDMS(products);
});

function SavetoDMS(products) {
	$.ajax({
		type : "GET",
		url : "SavetoDMS",
		data : {
			products : products
		},
		success : function(msg) {
			try {
				var jsonObject = JSON.parse(msg);
				SendToDMS(msg);
			} catch (e) {
				$("#SaveConfig").removeAttr("disabled");
				toastr.error(msg, "Message");
			}
		},
		failure : function(msg) {
			$("#SaveConfig").removeAttr("disabled");
			toastr.error('error', "Message");
		}
	});
}

function SendToDMS(data) {
	var url = "http://webservice.automatrix.co/api/deal/";
	$.ajax({
		type : "PUT",
		url : url,
		data : data,
		contentType : "application/json; charset=utf-8",
		dataType : "json",
		success : function(msg) {
			toastr.success(msg, "Message");
			$("#SaveConfig").removeAttr("disabled");
		},
		error : function(msg) {
			toastr.error(msg.responseJSON.Message, "Message");
			$("#SaveConfig").removeAttr("disabled");
		}
	});
	$("#SaveConfig").removeAttr("disabled");
}

$(".PdfContract").click(
		function() {
			GlobalSectionProduct = $(this).parent().parent();
			var ProductBaseId = parseInt(GlobalSectionProduct.attr('name'));
			var Id = $(GlobalSectionProduct).attr('id');
			var Type = $(GlobalSectionProduct).find('.ProductType')
					.attr('name');
			var Term = $(GlobalSectionProduct).find('.ProductTerm')
					.attr('name');
			var Deductible = $(GlobalSectionProduct).find('.ProductDeductible')
					.attr('name');
			var Mileage = $(GlobalSectionProduct).find('.ProductMileage').attr(
					'name');
			var OrderNumber = $(GlobalSectionProduct).find(':checkbox').attr(
					'OrderNumber');
			var Price = GetFloat($(GlobalSectionProduct).find(':checkbox')
					.val());
			
			var financedAmount = getCurrentFinancedAmount() + getAcceptedProductsAmount();

			var apr = getCurrentAPR();

			var downpayment = getCurrentDownPayment();
			
			if (OrderNumber.length == 0) {
				OrderNumber = 0;
			}
			
			if (ProductBaseId == 12) 
			{
				var Surcharges = $('#HiddenProtectiveVsc').val();
				if (Mileage == 0) {
					$(this).attr(
							"href",
							'CreatePDF?ProductId=' + Id + '&type=' + Type
									+ '&term=' + Term + '&deductible='
									+ Deductible + '&key=' + OrderNumber
									+ '&price=' + Price + '&surcharges='
									+ Surcharges);
				} else {
					$(this).attr(
							"href",
							'CreatePDF?ProductId=' + Id + '&type=' + Type
									+ '&term=' + Term + '&deductible='
									+ Deductible + '&key=' + OrderNumber
									+ '&mileage=' + Mileage + '&price=' + Price
									+ '&surcharges=' + Surcharges);
				}
			} 
			else 
			{
				//alert('aqui');
				if (Mileage == 0) 
				{
					$(this).attr(
							"href",
							'CreatePDF?ProductId=' + Id + '&type=' + Type
									+ '&term=' + Term 
									+ '&deductible=' + Deductible 
									+ '&financedAmount=' + financedAmount
									+ '&downpayment=' + downpayment
									+ '&apr=' + apr
									+ '&key=' + OrderNumber
									+ '&price=' + Price);
				} 
				else 
				{
					$(this)
							.attr(
									"href",
									'CreatePDF?ProductId=' + Id + '&type='
											+ Type + '&term=' + Term
											+ '&deductible=' + Deductible
											+ '&key=' + OrderNumber
											+ '&financedAmount=' + financedAmount
											+ '&downpayment=' + downpayment
											+ '&apr=' + apr
											+ '&mileage=' + Mileage + '&price='
											+ Price);
				}
			}

		})

