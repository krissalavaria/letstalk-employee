$(document).ready(function() {

    $('#letstalklogin').on('click', function() {
        $.ajax({
            url: base_url + 'login/service/login_service/login',
            type: "POST",
            dataType: "JSON",
            data: {
                username: $('#username').val(),
                password: $('#password').val(),
            },
            success: function(response) {
                if (response.has_error) {
                    alert(response.error_message);
                } else {   
                    if(response.change_pass == 0){
                        window.location = base_url + "login/service/login_service/change?tok=" + response.auth_token;
                    }else{
                        window.location = base_url + "dashboard";
                    }                                     
                }
            }
        });
    });
    
    $('#password').on('keyup', function(e) {
        if (e.keyCode == 13)
            $('#letstalklogin').click();
    });

    $('#letstalk-change-password').on('click', function(){
        $.ajax({
            url: base_url + 'login/service/login_service/update_password',
            type: "POST",
            dataType: "JSON",
            data: {
                token: $('#token').val(),
                first_password: $('#new-pass').val(),
                second_password: $('#re-new-passs').val(),
            },
            success: function(response) {
                if (response.has_error) {
                    alert(response.error_message);
                } else {   
                    window.location = base_url + "dashboard";                                   
                }
            }
        });
    });
});