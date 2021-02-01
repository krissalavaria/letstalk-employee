$(document).ready(function(){
    load_order_list();
    load_product_list();
    load_order_history();
    load_statement();
    if(cred_limit == 150 || cred_limit >= 150){
        document.getElementById('cred-limit').style.display = "block";
        $("#confirm-order").prop('disabled', true);
    }
});
var load_order_history = () => {
    $(document).gmLoadPage({
        url: baseUrl + 'dashboard/load_order_history',
        data: { ID: null },
        load_on: '#load-order-history'
    });
}
/** load default product list */
var load_product_list = () => {
    $(document).gmLoadPage({
        url: baseUrl + 'dashboard/get_all_menus',
        data: { ID: null },
        load_on: '#load-product-category'
    });
}
/** filter products by category */
$(document).on('change', '#prod-category', function(){    
    $(document).gmLoadPage({
        url: baseUrl + 'dashboard/get_all_menus',
        data: { ID: $(this).val() },
        load_on: '#load-product-category'
    });
}); 
/** add products to cart */
$(document).on('click', '.add-order', function(){    
    $(document).gmPostHandler({
        url: 'dashboard/service/dashboard_service/add_order',
        data: { 
            productID: $(this).data('id'),
            prodUnit: $(this).data('unit'),
            prodCatID: $(this).data('category'), 
            prodPrice: $(this).data('price')
        },
        function_call: true,
        function: load_order_list,
        parameter: true,
        alert_on_error: false,
        errorsend: true,
        errorsend_function: [{
            function: error_connection,
            msg: "Please check your connection and try again."
        }],
        function_call_on_error: true,
        error_function: [{
            function: error,
            parameter: true,
        }]
    });
});
/** load all order list by teacher */
var load_order_list = () => {    
    $(document).gmLoadPage({
        url: baseUrl + 'dashboard/load_order_lists',        
        load_on: '#load-order-list'
    });
}
/** view order receipt */
$(document).on('click', '#view-receipt', function(){    
    window.location = baseUrl + "dashboard/order_receipt?id=" + orderID + "&num=" + orderNo;
});
