<?php
	login_header();
?>
<!-- ############ LAYOUT START-->
    <div class="navbar-custom">
      <h5 class="web-title "> 
        <a class="btn btn btn-succes  border" href="http://live.contracovid.com.ph/contravid" role="button"><i class="fa fa-angle-double-left"></i> back </a>                
      </h5>
    </div>
    
  <div class="center-block w-xxl w-auto-md  ">
    
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
      <div class="m-b text-sm text-center">
	  	  <h5><?=SYSTEM_MODULE?></h5>
      </div>
      <form name="form">
        <div class="md-form-group float-label">
          <input type="text" class="md-input" id="username" ng-model="user.username" required>
          <label>Username</label>
        </div>
        <div class="md-form-group float-label">
          <input type="password" class="md-input" id="password" ng-model="user.password" required>
          <label>Password</label>
        </div>      
        
        <button type="button" id="letstalklogin" class="form-control primary btn-block p-x-md">Sign in</button>
      </form>
    </div>
    <div class="p-v-lg text-center mobile-size">
      <b>Powered by Let's Talk Information Technology Solutions &copy; 2021. All rights reserved.</b>
    </div>
  </div>

<!-- ############ LAYOUT END-->
    <div class="footer">
     <span>Powered by Let's Talk Information Technology Solutions &copy; 2021. All rights reserved.</span>
    </div>
  </div>

<?php
	login_footer();	
?>
