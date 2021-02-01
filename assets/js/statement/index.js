$(document).ready(function(){
    load_statement_class();        
});
/** load all classes in statement of account */
var load_statement_class = () =>{
    $(document).gmLoadPage({
        url: baseUrl + 'statement/load_statement_classes',        
        load_on: '#load-statement'
    });
}

/** load statement of account history */
$(document).on('click', '#filter-statement', function(){
    $(document).gmLoadPage({
        url: baseUrl + 'statement/load_statement_history',  
        data: {
            start_date: $('#histo-start-date').val(),  
            end_date: $('#histo-end-date').val()
        },   
        load_on: '#load-statement-histo'
    });
});
