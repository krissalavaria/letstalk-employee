/** load time record */
var load_default_record = () =>{
    $(document).gmLoadPage({
        url: baseUrl + 'account/load_time_record',        
        load_on: '#load-time-record'
    });
}

var load_user_total_income = () => {
    $(document).gmLoadPage({
        url: baseUrl + 'account/load_users_income',        
        load_on: '#load-users-income'
    });
}

$(document).ready(function(){
    load_default_record();
    load_user_total_income();
});

/** view classes */
$(document).on('click', '#view-classes', function(){
    $(document).gmLoadPage({
        url: baseUrl + 'account/load_class_list',      
        data: {
            startDate: $('#start_date').val(),
            endDate: $('#end_date').val()
        },  
        load_on: '#load-classes'
    }); 
});

/** click to filter time record */
$(document).on('click', '#view-time', function(){
    $(document).gmLoadPage({
        url: baseUrl + 'account/load_time_record',   
        data: {
            timeStartDate: $('#time-start-date').val(),
            timeEndDate: $('#time-end-date').val()
        },  
        load_on: '#load-time-record'
    });
});
