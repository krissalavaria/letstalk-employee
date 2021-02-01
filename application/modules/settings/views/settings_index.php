<?=main_header(['settings']);?>
<!-- ############ PAGE START-->
<link rel="stylesheet" href="<?= base_url()?>assets/css/global.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url()?>assets/css/tables.css" type="text/css" />
<div class="padding">	
    <div id="pageMessages"></div>
	<div class='box p-a'>
		<div class="row">		
			<div class="box box-body">
                <div class="b-b nav-active-bg">
                    <div class="b-b nav-active-bg">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href data-toggle="tab" data-target="#information">Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href data-toggle="tab" data-target="#setting">Setting</a>
                            </li>                           
                        </ul>
                    </div>

                    <div class="tab-content p-a m-b-md">
                        <div class="tab-pane animated fadeIn active text-muted" id="information">
                            <br><div class="row">
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Employee ID:</h6>   
                                    <input type="text" class="form-control" readonly value="<?=@$details->employee_no?>">
                                </div>
                            </div>
                            <div class="row"></br>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>First Name</h6>
                                    <input type="hidden" class="form-control edit-user-data" data-field="token" value="<?=@$details->auth_token?>">
                                    <input type="text" class="form-control edit-user-data" data-field="fName" id="fname" readonly value="<?=@$details->first_name?>"> 
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Middle Name</h6>
                                    <input type="text" class="form-control edit-user-data" data-field="mName" readonly value="<?=@$details->middle_name?>">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Last Name</h6>
                                    <input type="text" class="form-control edit-user-data" data-field="lName" readonly value="<?=@$details->last_name?>">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6 class="">Ext. Name</h6>
                                    <input type="text" class="form-control edit-user-data" data-field="xtName" readonly value="<?=@$details->ext_name?>">
                                </div>
                            </div></br>          

                            <div class="row">
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Gender</h6>
                                    <input type="text" class="form-control" readonly value="<?=@$details->gender?>">
                                </div>
                                <div class='col-xs-12 col-sm-3'>
                                    <?php $birthday_timestamp = strtotime(@$details->birthday);
                                        $Age = date('md', $birthday_timestamp) > date('md') ? date('Y') - date('Y', $birthday_timestamp) - 1 : date('Y') - date('Y', $birthday_timestamp);?>                                            
                                    <h6>Age</h6>
                                        <input type="text" class="form-control" readonly value="<?=@$Age?>">
                                    </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Birthday</h6>
                                    <input type="text" class="form-control" readonly value="<?=date('F d, Y', strtotime(@$details->birthday))?>">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Contact Number</h6>
                                    <input type="text" class="form-control edit-user-data" data-field="contact_no" readonly value="<?=@$details->contact_number?>">
                                </div>
                            </div></br>                    

                            <div class="row">
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Contact Person</h6>
                                    <input type="text" class="form-control edit-user-data" data-field="contact-person" readonly value="<?=@$details->contact_person?>">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Contact Person Number</h6>
                                    <input type="text" class="form-control edit-user-data" data-field="contact-person-number" readonly value="<?=@$details->contact_person_number?>">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Account Type</h6>
                                    <input type="text" class="form-control" readonly value="<?=@$details->account_name?>">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Department</h6>
                                    <input type="text" class="form-control" readonly value="<?=@$details->department_name?>">
                                </div>
                            </div><br>

                            <div class="row" id="edit-address" style="display:none;">
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Street</h6>
                                    <input type="text" class="form-control edit-user-data" data-field="edit-street" value="<?=@$details->street?>">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Province</h6>
                                    <select data-field="province-edit" id="edit-province" style="width: 100%;" class="form-control edit-user-data select2-multiple" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
                                        <?php foreach (@$provinces as $key => $value) {
                                            ?><option value="<?=$value->prov_code?>" data-provid="<?=@$value->ID?>" <?=$value->ID === $details->province_id ? 'selected' : ''?>><?=$value->prov_desc?></option><?php
                                        }?>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>City/Municipality</h6>
                                    <select data-field="citie-edit" id="cities-edit" style="width: 100%;" class="form-control edit-user-data select2-multiple" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
                                        <option disabled selected>City/Municipality</option>                                                                                                                           
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Barangay</h6>
                                    <select data-field="barangay-edit" id="barangays-edit" style="width: 100%;" class="form-control edit-user-data select2-multiple" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
                                        <option disabled selected>Barangay</option>                                                                                                                    
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="box-body">
                                        <div class="col-xs-12 col-sm-3">
                                            <br><h6>Block / Door</h6>
                                            <input type="text" class="form-control edit-user-data" data-field="blk-door" readonly value="<?=@$details->blk_door?>">
                                        </div>
                                    </div>
                                </div>                   
                            </div>                
                            <hr style="border-top: 1px dashed black;">  
                            <div class="row" id="edit-buttons" style="display: block;">
                                <div class="col-xs-12 col-sm-2">
                                    <button class="form-control btn-primary btn-md" style="width:70%;" id="edit-data">EDIT</button>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                    <button class="form-control btn-warning btn-md" style="width:70%;" id="cancel-edit">CANCEL</button>
                                </div>
                                <div class="col-xs-12 col-sm-2" id="save-edit-btn" style="display:none;">
                                    <button class="form-control btn-success btn-md" style="width:70%;" id="edit-save">SAVE</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane animated fadeIn text-muted" id="setting">
                            <div class="row">
                                <br><div class="col-xs-12 col-sm-3">
                                    <h6>Username</h6>
                                    <input type="text" class="form-control" id="user-name" readonly value="<?=@$details->username?>"><br>
                                    <button class="form-control btn-success btn-md" id="btn-save-changes" style="width:50%; display:none;">SAVE</button>
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h6>Change Password</h6>
                                    <input type="password" class="form-control" id="change-pass" value=""><br>
                                    <input type="checkbox" id="show-pass">Show Password
                                </div>
                            </div>           
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
<?=main_footer();?>
<script src="<?php echo base_url()?>assets/js/settings/settings.js"></script>
<script>
    var verified = <?php echo json_encode($details->verified);?>;
    if(verified == 1){
        document.getElementById('edit-buttons').style.display = "none";
    }
</script>