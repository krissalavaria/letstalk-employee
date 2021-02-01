/** load total amount of price */
var load_total_price = (reponse) => {        
    document.getElementById("total-amount").innerHTML  = reponse.price;
}
/** del oder list */
$(document).on('click', '.del-order', function(){    
    var orderID = $(this).data('id');
    var orderNo = $(this).data('orderno');
    $.confirm({
        containerFluid: true,
        columnClass: 'col-md-5 offset-md-4',
        title: '',
        content: 'Click OKAY Delete',
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        type: 'red',
        alignMiddle: true,
        buttons: {

            okay: {
                btnClass: 'btn-blue',
                keys: [
                    'enter'
                ],
                action: function() {
                    $(document).gmPostHandler({
                        url: 'dashboard/service/dashboard_service/delete_order',
                        data: { 
                            orderID: orderID,
                            orderNo: orderNo
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
                }
            },
            cancel: {

            }
        },
    });
});
/** add quantity of order */
$(document).on('click', '.add-qty', function(){    
    var orderID = $(this).data('id');
    var orderPrice = $(this).data('price');
    $(document).gmPostHandler({
        url: 'dashboard/service/dashboard_service/add_order_quantity',
        data: { 
            orderID: orderID,     
            orderPrice: orderPrice       
        },
        function_call: true,
        function: load_total_price,                
        parameter: true,        
        add_functions: [{
            function: load_order_list
        }],
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
/** subtract quantity or order */
$(document).on('click', '.minus-qty', function(){
    var orderID = $(this).data('id');
    var orderPrice = $(this).data('price');
    $(document).gmPostHandler({
        url: 'dashboard/service/dashboard_service/subtract_quantity',
        data: { 
            orderID: orderID,   
            orderPrice: orderPrice         
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
/** confirm user order */
$(document).on('click', '#confirm-order', function(){  
    $('#pin-modal').modal('show');        
});

/** proceed to confirm order */
$(document).on('click', '#proceed-order', function(){    
    $(document).gmPostHandler({
        url: 'dashboard/service/dashboard_service/check_pin',
        data: {                             
            PIN: $('#pin-number').val(),            
        },
        function_call: true,
        parameter: true,
        function: success,
        add_functions: [{
            function: proceed_function
        }],                
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

/** proceed function to confirm order */
var proceed_function = () => {       
    $('#pin-modal').modal('hide');
    delay(function(){    
        var prodIDs = [];
        $('.prod-ids').each(function() {
            var data = {
                ID: $(this).data('id'),
                Qty: $(this).data('qty')
            }
            prodIDs.push(data);
        });     
        var Obj = JSON.stringify(prodIDs);
        
        $.confirm({
            containerFluid: true,
            columnClass: 'col-md-5 offset-md-4',
            title: '',
            content: 'Click OKAY to confirm',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            alignMiddle: true,
            buttons: {

                okay: {
                    btnClass: 'btn-blue',
                    keys: [
                        'enter'
                    ],
                    action: function() {
                        $(document).gmPostHandler({
                            url: 'dashboard/service/dashboard_service/confirm_order',
                            data: {            
                                total_amount: (Total + cred_limit),                  
                                orderNo: order_number,
                                productIDs: Obj
                            },
                            function_call: true,
                            function: success,
                            add_functions: [{
                                function: load_order_list
                            },{
                                function: load_order_history
                            },{
                                function: load_statement
                            }],
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
                    }
                },
                cancel: {

                }
            },
        });   
    },700);
}