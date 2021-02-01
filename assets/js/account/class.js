var ID;
var classDate;
var classNo;

/** save edit of classes */
$(document).on('click', '.edit-class', function(){
    ID = $(this).data('id');
    classDate = $(this).data('date');
    classNo = $(this).data('class');
    classHrs = $(this).data('hours');
    document.getElementById('cl-class').value = classNo;   
    document.getElementById('cl-hours').value = classHrs;
});