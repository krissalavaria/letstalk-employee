var orderID;
var orderNo;
var orderStat;
/** click to load modal history */
$(document).on('click', '.view-details', function(){
    
    orderStat = $(this).data('status');
    orderID = $(this).data('orderid');
    orderNo = $(this).data('orderno');
    var dateTime = new Date($(this).data('date'));   
    var now = new Date();
    var diffInMS = now - dateTime;
    var msInHour = Math.floor(diffInMS/1000/60);    
    
    if (msInHour < 180) {        
        if(orderStat != "Cancelled"){            
            $("#cancel-order").prop('disabled', false);
        }else{
            $("#cancel-order").prop('disabled', true);
        }
    } else {        
        $("#cancel-order").prop('disabled', true);
    }

    $('#history-modal').modal('show');
    
    $(document).gmLoadPage({
        url: baseUrl + 'dashboard/load_histo_modal',
        data: { orderID: orderID },
        load_on: '#load-history-modals'
    });
});

/** load statement of account */
var load_statement = () => {
    $('#history-modal').modal('hide');
    $(document).gmLoadPage({
        url: baseUrl + 'dashboard/statement_account',        
        load_on: '#load-statement'
    });
}

/** cancel order */
$(document).on('click', '#cancel-order', function(){ 
    var prodData = [];
    $('.confirm-orders').each(function() {
        var data = {
            prodID: $(this).data('prodid'),
            orderID: $(this).data('orderno'),
            orderNo: $(this).data('orderid'),
            Qty: $(this).data('qty')
        }
        prodData.push(data);
    });     
    var Obj = JSON.stringify(prodData);    
    
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
                        url: 'dashboard/service/dashboard_service/cancel_order',
                        data: {          
                            orderData: Obj,
                            orderHiD: orderNo,
                            orderNo: orderID                                                                        
                        },
                        function_call: true,
                        function: success,
                        add_functions: [{
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
});

/** view order history */
$(document).on('click', '#view-order-histo', function(){
    $(document).gmLoadPage({
        url: baseUrl + 'dashboard/load_order_history',
        data: { 
            startDate: $('#start-order-date').val(), 
            endDate: $('#end-order-date').val()
        },
        load_on: '#load-order-history'
    });
});