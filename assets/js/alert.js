function createAlert(title, summary, details, severity, dismissible, autoDismiss, appendToId) {
    var iconMap = {
      info: "fa fa-info-circle",
      success: "fa fa-thumbs-up",
      warning: "fa fa-exclamation-triangle",
      danger: "fa ffa fa-exclamation-circle"
    };
  
    var iconAdded = false;
  
    var alertClasses = ["alert", "animated", "zoomInRight"];
    alertClasses.push("alert-" + severity.toLowerCase());
  
    if (dismissible) {
      alertClasses.push("alert-dismissible");
    }
  
    var msgIcon = $("<i />", {
      "class": iconMap[severity] // you need to quote "class" since it's a reserved keyword
    });
  
    var msg = $("<div />", {
      "class": alertClasses.join(" ") // you need to quote "class" since it's a reserved keyword
    });
  
    if (title) {
      var msgTitle = $("<h4 />", {
        html: title
      }).appendTo(msg);
      
      if(!iconAdded){
        msgTitle.prepend(msgIcon);
        iconAdded = true;
      }
    }
  
    if (summary) {
      var msgSummary = $("<strong />", {
        html: summary
      }).appendTo(msg);
      
      if(!iconAdded){
        msgSummary.prepend(msgIcon);
        iconAdded = true;
      }
    }
  
    if (details) {
      var msgDetails = $("<p />", {
        html: details
      }).appendTo(msg);
      
      if(!iconAdded){
        msgDetails.prepend(msgIcon);
        iconAdded = true;
      }
    }
    
  
    if (dismissible) {
      var msgClose = $("<span />", {
        "class": "close", // you need to quote "class" since it's a reserved keyword
        "data-dismiss": "alert",
        html: "<i class='fa fa-times-circle'></i>"
      }).appendTo(msg);
    }
    
    $('#' + appendToId).prepend(msg);
    
    if(autoDismiss){
      setTimeout(function(){
        msg.addClass("zoomOutRight");
        setTimeout(function(){
          msg.remove();
        },700);
      }, 1800);
    }
}

function success(data){
  // console.log(data);
  createAlert(' Nice','',data.message,'success',true,true,'pageMessages');
}


function error(data){
  // console.log(data);
  delay(function(){
    createAlert(' Opps!!!','',data.error_message,'warning',true,true,'pageMessages');
  }, 800);  
}

function loading(html,display=true){  
  if (display) {
    $(html).addClass('fa fa-spinner fa-spin');
  }else{
    $(html).removeClass('fa fa-spinner fa-spin');
  }
}

function error_connection(msg){
  createAlert('',' Error Connection',msg,'danger',true,true,'pageMessages');
}
