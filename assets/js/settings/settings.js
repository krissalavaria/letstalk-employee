/** click to edit */
$(document).on('click', '#edit-data', function(){         
    $( ".edit-user-data" ).prop( "readonly", false );
    document.getElementById('edit-address').style.display = "block";
    document.getElementById('save-edit-btn').style.display = "block";
});

/** click to cancel edit */
$(document).on('click', '#cancel-edit', function(){
    $( ".edit-user-data" ).prop( "readonly", true );
    document.getElementById('edit-address').style.display = "none";
    document.getElementById('save-edit-btn').style.display = "none";
});

/** load account */
var load_account = () => {
    delay(function(){
        window.location = baseUrl + "settings";
    }, 700);
}

/** show password */
$(document).on('click', '#show-pass', function(){
    var x = document.getElementById('change-pass');
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
});

/** input change password */
$(document).on('keyup', '#change-pass', function(){
    document.getElementById('btn-save-changes').style.display = "block";
});

/** save edit data */
$(document).on('click', '#edit-save', function(){
    $.confirm({
        containerFluid: true,
        columnClass: 'col-md-5 offset-md-4',
        title: '',
        content: 'Please review all your details before saving once it is save you cannot edit again Click <b>OKAY</b> to save otherwise',
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
                        url: 'settings/services/settings_services/save_edit',
                        selector: '.edit-user-data',
                        data: {                            
                            brgy:  $('.edit-user-data[data-field="barangay-edit"] option:selected').data('brgyid'),
                            city:  $('.edit-user-data[data-field="citie-edit"] option:selected').data('cityid'),
                            province:  $('.edit-user-data[data-field="province-edit"] option:selected').data('provid'),                            
                        },  
                        field: 'field',                    
                        function_call: true,
                        function: success,
                        add_functions: [{
                            function: load_account
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

/** select city */
$(document).on('change', '#edit-province', function() {
    $(document).gmPostHandler({
        url: 'settings/services/settings_services/get_cities',
        data: { prov_code: $('.form-control[data-field="province-edit"]').val() },
        function_call: true,
        function: load_cities,
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

/** load cities */
var load_cities = (cities) => {
    var array_cities = [];

    array_cities.push('<option disabled selected>' + 'Select City' + '</option>');
    cities.forEach(value => {
        array_cities.push('<option value="' + value.citymun_code + '" data-cityid="' + value.ID + '">' + value.citymun_desc + '</option>');
    });
    $('#cities-edit').html(array_cities);
}

/** get barangay by city */
$(document).on('change', '#cities-edit', function() {
    $(document).gmPostHandler({
        url: 'settings/services/settings_services/get_brgy',
        data: { city_code: $('.form-control[data-field="citie-edit"]').val() },
        function_call: true,
        function: load_brgy,
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

/** load barangay per city */
var load_brgy = (brgy) => {
    var array_brgy = [];

    array_brgy.push('<option disabled selected>' + 'Select Barangay' + '</option>');
    brgy.forEach(value => {
        array_brgy.push('<option value="' + value.code + '" data-brgyid="' + value.ID + '">' + value.desc + '</option>');
    });

    $('#barangays-edit').html(array_brgy);
}

/** click to save pass change */
$(document).on('click', '#btn-save-changes', function(){
    $.confirm({
        containerFluid: true,
        columnClass: 'col-md-5 offset-md-4',
        title: '',
        content: 'Click OKAY to update',
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
                        url: 'settings/services/settings_services/update_password',
                        data: {
                            token: $('.edit-user-data[data-field="token"]').val(),
                            password: $('#change-pass').val()
                        },                
                        function_call: true,
                        function: success,
                        add_functions: [{
                            function: load_account
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
