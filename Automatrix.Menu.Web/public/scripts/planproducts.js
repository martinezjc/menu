var Globalorder;

$(document).ready(function () {
	StartToastMessage();

    // $(function() {      
    //     $(".sortable").sortable({
    //         placeholder: "highlight"
    //     });    
    //     $(".sortable").disableSelection();
    // });

	if (!($(document).height() > $(window).height())) 
    {
        $('footer').removeClass('footerApp');
    }
});

$('#productsTable').delegate(':checkbox', 'click', function () 
{
        var id = $(this).attr('id');
        if (!$(this).prop("checked")) 
        {
            deleteProduct(id);
        } else {
            insertProduct(id);
        }
});

function deleteProduct(idProduct)
{
    ajaxBuilder(currentUrl + '/deleteProduct', { id: idProduct } , function(){
        angular.element('#angulardiv').scope().getTable();
        angular.element('#angulardiv').scope().getIncluded();
        Sortable();
    });
}

function insertProduct(idProduct)
{
    ajaxBuilder(currentUrl + '/insertProduct', { id: idProduct } , function(){
        angular.element('#angulardiv').scope().getTable();
        angular.element('#angulardiv').scope().getIncluded();
        Sortable();
    });
}

function Sortable()
{
    $(function () {
        $(".sortable").sortable({
            placeholder: "highlight",
            helper: "clone",
            stop: function (event, ui) {
                Globalorder = $(".sortable").sortable('toArray');
                UpdatetOrderTable(Globalorder);
                toastr.success("The product order has been updated.", "Success");
            }
        });
        $(".sortable").disableSelection();
    });
}

$(function () {
        $(".sortable").sortable({
            placeholder: "highlight",
            helper: "clone",
            stop: function (event, ui) {
                Globalorder = $(".sortable").sortable('toArray');
                UpdatetOrderTable(Globalorder);
                toastr.success("The product order has been updated.", "Success");
            }
        });
        $(".sortable").disableSelection();
});

function UpdatetOrderTable(Order)
{
    var parameters;

    for (var i = 0; i < Order.length; i++)
    {
        OrderProduct = i + 1;
        
        parameters = {
            Order: OrderProduct,
            ProductId: Order[i],
            PlansId: 1
        };

        ajaxBuilder(currentUrl + '/updateOrderProducts', parameters, function(){
        });
    }
}