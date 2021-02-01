var load_teachers = () => {
    $(document).gmLoadPage({
        url: baseUrl + 'management/load_teachers',       
        load_on: '#load-teachers-list'
    });
}

$(document).ready(function(){
    load_teachers();
});

/** load profile */
var load_profile = (e) => {
    success(e);
    delay(function(){
        window.location = baseUrl + "management/teacher_account?get=" + e.token;
    }, 700);
}

/** click to edit */
var ID;
var Token;
$(document).on('click', '.btn-editing', function(){
    document.getElementById('edit-data').style.display = "block";
    document.getElementById('no-class').value = $(this).data('class');
    document.getElementById('no-hours').value = $(this).data('hour');   
    ID = $(this).data('id');
    Token = $(this).data('token');
});

/** key up for no of hours */
$(document).on('keyup', '#no-class', function(){
    var classNumber = Number($('.cl-form[data-field="cl-no-class"]').val());    
    document.getElementById('no-hours').value = (classNumber / 2);
});

/** click to save edited classes */
$(document).on('click', '#btn-save-edited', function(){    
    $(document).gmPostHandler({
        url: 'management/service/management_service/save_classes',
        selector: '.cl-form',        
        field: 'field',
        data: {ID: ID, Token: Token},
        function_call: true,
        function: load_profile,
        parameter: true,        
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