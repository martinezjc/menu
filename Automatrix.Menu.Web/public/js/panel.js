$(window).load(function () {
    if ($('#SortableTable').length) {
        FillSortableTable();
    };    
});

$(document).ready(function () {
	StartToastMessage();
    retrieveListProducts();

	if (!($(document).height() > $(window).height())) {
        $('footer').removeClass('footerApp');
    }
});

function onProductsLoad(result) {
	var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    $('#productsTable').html(result);

    $('#productsTable').delegate(':checkbox', 'click', function () {
        var id = $(this).attr('id');
        if (!$(this).prop("checked")) {
            deleteProduct(id);
        } else {
            insertProduct(id);
        }

        if (msie > 0) {
            //retrieveListProducts();
            FillSortableTable();
            return;
        } else {
        	//setTimeout(function () {
	            retrieveListProducts();
	            FillSortableTable();
	        //}, 1000);
        }
	        
    });
}

$('#productsTable').delegate(':checkbox', 'click', function () {
        var id = $(this).attr('id');
        if (!$(this).prop("checked")) {
            deleteProduct(id);
        } else {
            insertProduct(id);
        }
});

$('#productsTable').delegate(':button', 'click', function () {
        var id = $(this).attr('value');
        removeProduct(id);

        setTimeout(function () {
            retrieveListProducts();
            FillSortableTable();
        }, 1000);
    });

/*function retrieveListProducts() {
    $.ajax({
        type: "GET",
        url: "getTable",
        success: onProductsLoad,
        failure: function (msg) {
            toastr.error('Table could not be loaded', "Message");
        }
    });
}*/

function retrieveListProducts() {
    $.ajax({
        type: "GET",
        url: "getTable",
        success: function(msg){
            $('#productsTable').html(msg);
        },
        failure: function (msg) {
            toastr.error('Table could not be loaded', "Message");
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
          retrieveListProducts();
          FillSortableTable();
        },
        failure: function (msg) {
            toastr.error('Table could not be loaded', "Message");
        }
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

function insertProduct(idProduct) {
    $.ajax({
        type: "GET",
        url: "insertProduct",
        data: {
            id: idProduct
        },
        success: function (msg) {
          retrieveListProducts();
          FillSortableTable();
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
