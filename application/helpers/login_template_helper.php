<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  function login_header() {
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
  <title><?=SYSTEM_NAME?></title>

  <meta name="description" content="Admin Monitoring, COVID-19 Contact Tracing System ">
  <meta name="keywords" content="Admin Monitoring, Contracovid, COVID-19, Contact Tracing System, Contact Tracing application, Contact Tracing Software, Contact Tracing QR Code, Contact Tracing ID System, Fight against Covid-19, Filipino made, Bacolod Contact Tracing, Bacolod City, Philippines">
  <meta name="author" content="Let's Talk Information Technology Solutions">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">


  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <!-- <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="../assets/images/logo.png">
  <meta name="apple-mobile-web-app-title" content="Flatkit"> -->
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <!-- <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.png"> -->
  
  <!-- style -->
  <link rel="stylesheet" href="<?= base_url()?>assets/theme/animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/theme/animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/theme/glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/theme/font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/theme/material-design-icons/material-design-icons.css" type="text/css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/theme/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <!-- build:css <?= base_url()?>assets/theme/styles/app.min.css -->
  <link rel="stylesheet" href="<?= base_url()?>assets/theme/styles/app.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="<?= base_url()?>assets/theme/styles/font.css" type="text/css" />
  <link rel="shortcut icon" href="<?= base_url()?>assets/images/Logo/logo-cafe.png">
<body>
  <style>
  html{
    background-color:#f0f0f0;
  }
  /* body, .app{
    height:100vh;
  } */
  .navbar-custom{
    height:50px;
    background: rgb(102, 153, 255);
  }
  .footer{
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color:#091f39;
    color: white;
    text-align: center;
  }
  .web-title{
      padding:6px;
      font-family: "AANTICORONA";
      color: white;
  }
  .mobile-size{
    display:none;
  }
  #letstalklogin{
      background-color: #1d3d7c;
  }
  .center-block {
    margin-top:10%;
  }
    /*###Desktops, big landscape tablets and laptops(Large, Extra large)####*/
    @media screen and (min-width: 1024px){
    /*Style*/
    }

    /*###Tablet(medium)###*/
    @media screen and (min-width : 768px) and (max-width : 1023px){

    }

    /*### Smartphones (portrait and landscape)(small)### */
    @media screen and (min-width : 0px) and (max-width : 767px){
      .footer{
        display:none;
      }
      .mobile-size{
        display: block;
      }
      .center-block {
        margin-top:0%;
      }
    }
  </style>
<?php
}

function login_footer(){

?>
<script type="text/javascript">
  var base_url = '<?=base_url()?>';
</script>
<!-- jQuery -->
<script src="<?= base_url()?>assets/theme/libs/jquery/jquery/dist/jquery.js"></script>
  <script src="<?= base_url()?>assets/js/service.js"></script>
<!-- Bootstrap -->
  <script src="<?= base_url()?>assets/theme/libs/jquery/tether/dist/js/tether.min.js"></script>
  <script src="<?= base_url()?>assets/theme/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
  <script src="<?= base_url()?>assets/theme/libs/jquery/underscore/underscore-min.js"></script>
  <script src="<?= base_url()?>assets/theme/libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="<?= base_url()?>assets/theme/libs/jquery/PACE/pace.min.js"></script>

  <script src="<?= base_url()?>assets/theme/html-version/scripts/config.lazyload.js"></script>

  <script src="<?= base_url()?>assets/theme/html-version/scripts/palette.js"></script>
  <script src="<?= base_url()?>assets/theme/html-version/scripts/ui-load.js"></script>
  <script src="<?= base_url()?>assets/theme/html-version/scripts/ui-jp.js"></script>
  <script src="<?= base_url()?>assets/theme/html-version/scripts/ui-include.js"></script>
  <script src="<?= base_url()?>assets/theme/html-version/scripts/ui-device.js"></script>
  <script src="<?= base_url()?>assets/theme/html-version/scripts/ui-form.js"></script>
  <script src="<?= base_url()?>assets/theme/html-version/scripts/ui-nav.js"></script>
  <script src="<?= base_url()?>assets/theme/html-version/scripts/ui-screenfull.js"></script>
  <script src="<?= base_url()?>assets/theme/html-version/scripts/ui-scroll-to.js"></script>
  <script src="<?= base_url()?>assets/theme/html-version/scripts/ui-toggle-class.js"></script>

  <script src="<?= base_url()?>assets/theme/html-version/scripts/app.js"></script>
  <script src="<?= base_url()?>assets/js/noPostBack.js"></script>
  <!-- ajax -->
  <script src="<?= base_url()?>assets/theme/libs/jquery/jquery-pjax/jquery.pjax.js"></script>
<!-- endbuild -->
</body>
</html>
<?php
}