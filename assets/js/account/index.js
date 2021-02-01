$(document).ready(function(){
    load_default_classes();
});
/** laod default classes */
var load_default_classes = () =>{
    $(document).gmLoadPage({
        url: baseUrl + 'account/load_class_list',        
        load_on: '#load-classes'
    });
}
/** load profile page */
var load_account_page = () => {    
    delay(function(){
        window.location = baseUrl + 'account';
    }, 700);    
}

/** click to save classes */
$(document).on('click', '#save-class', function(){    
    $(document).gmPostHandler({
        url: 'account/services/account_services/save_classes',
        selector: '.cl-form',        
        field: 'field',
        data: {ID: ID},
        function_call: true,
        function: success,
        parameter: true,
        add_functions: [{
            function: load_default_classes
        },{
            function: load_user_total_income
        }],
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

/** key up for no of hours */
$(document).on('keyup', '#cl-class', function(){
    var classNumber = Number($('.cl-form[data-field="cl-no-class"]').val());    
    document.getElementById('cl-hours').value = (classNumber / 2);
});

$(document).on('change', '#choose-image-logo', function(){
    document.getElementById('btn-save-imgs').style.display = "block";
    document.getElementById('camera-btn').style.display = "none";
});

/** save logo */
$(document).on('click', '#btn-save-imgs', function(){
    var file = {};
    file.image = $('#choose-image-logo').prop("files")[0];
    $(document).gmPostHandler({
        url: 'account/services/account_services/save_logo',
        errorsend: true,
        data:{
            token: $('#token').val(),
            logo : file.image
        },
        function_call: true,
        function: success,
        parameter: true,
        add_functions: [{
            function: load_account_page
        }],
        beforesend: true,            
        errorsend_function: [
            {
                function: error_connection,
                msg: "Please check your connection and try again."
            }
        ],
        function_call_on_error: true,
        error_function: [
            {
                function: error,
                parameter: true,
            }
        ]
    });
});