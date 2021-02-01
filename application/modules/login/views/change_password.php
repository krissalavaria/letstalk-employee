<?php
	login_header();
?>
<!-- ############ LAYOUT START-->
    <div class="navbar-custom">
      <h5 class="web-title "> 
        <a class="btn btn btn-succes  border" href="<?php echo base_url()?>" role="button"><i class="fa fa-angle-double-left"></i> back </a>                
      </h5>
    </div>
    
  <div class="center-block w-xxl w-auto-md  ">
    
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
      <div class="m-b text-sm text-center">
	  	  <h5>Change Password</h5>
      </div>
      <form name="form">
        <div class="md-form-group float-label">
            <input type="hidden" id="token" value="<?=@$token?>">
          <input type="password" class="md-input" id="new-pass" ng-model="user.newpassword" required>
          <label>Enter Password</label>
        </div>
        <div class="md-form-group float-label">
          <input type="password" class="md-input" id="re-new-passs" ng-model="user.renewpassword" required>
          <label>Enter Password Again</label>
        </div>      
        
        <button type="button" id="letstalk-change-password" class="form-control primary btn-block p-x-md">Sign in</button>
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
