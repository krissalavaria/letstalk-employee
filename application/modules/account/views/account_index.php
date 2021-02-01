<?=main_header(['account']);?>
<!-- ############ PAGE START-->
<link rel="stylesheet" href="<?= base_url()?>assets/css/global.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url()?>assets/css/tables.css" type="text/css" />
<div class="padding">	
    <div id="pageMessages"></div>
	<div class='box p-a'>
		<div class="row">		
			<div class="box box-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="img-container">
                            <span style="margin: 0 auto;">
                                <?php if(!empty(@$details->picture)):?>
                                    <div id="person-image" style="transition: all 0.3s ease; background-image: url('<?php echo base_url()?>assets/images/Logo/Profile/<?=@$details->picture.'?'.time()?>')"></div>									                                        
                                <?php endif;?>
                                <?php if(empty(@$details->picture)):?>
                                    <div id="person-image" style="transition: all 0.3s ease; background-image: url('<?php echo base_url()?>assets/images/Logo/Profile/default.png')"></div>									                                        
                                <?php endif;?>
                            </span>                                                       
                        </div>                        
                        <div class="box-body" style="margin-top:20%; display:none;" id="btn-save-imgs"><button class="form-control btn-sm btn-success">SAVE</button></div>                    
                        <div class="box-body text-left">
                            <br><h6>Employee ID:</h6>   
                            <input type="text" class="form-control" readonly value="<?=@$details->employee_no?>">                   

                            <h6>Name:</h6>
                            <input type="text" class="form-control" readonly value="<?=ucwords(@$details->first_name).' '.ucwords(@$details->middle_name[0]).'. '.ucwords(@$details->last_name)?>">

                            <h6>Address:</h6>                            
                            <textarea cols="30" rows="5" class="form-control" readonly><?=ucwords(@$details->street).' '.@$details->barangay.', '.@$details->city.', '.@$details->province?></textarea>                                                      
                            <?php if(empty(@$details->picture)):?>
                            <div class="middle btn-save-img" id="camera-btn" style="display:block;">
                                <div class="file-upload btn btn-lg md-btn md-fab m-b-sm blue">
                                    <span> <i class="fa fa-camera"></i> </span>
                                    <input type="file" id="choose-image-logo" class="upload" accept="image/*">
                                </div>
                            </div>       
                            <?php endif;?>                      
                        </div>
                        <input type="hidden" id="token" value="<?=@$details->auth_token?>">                        
                    </div>

                    <div class="col-xs-12 col-sm-9">
                        <div class="b-b nav-active-bg">
                            <div class="b-b nav-active-bg">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href data-toggle="tab" data-target="#information">Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href data-toggle="tab" data-target="#classes">Classes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href data-toggle="tab" data-target="#timerecord">Time Record</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content p-a m-b-md">
                                <div class="tab-pane animated fadeIn active text-muted" id="information">
                                    <div class="row"></br>
                                        <div class="col-xs-12 col-sm-3">
                                            <h6>First Name</h6>
                                            <input type="text" class="form-control edit-user-data" id="fname" readonly value="<?=@$details->first_name?>"> 
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <h6>Middle Name</h6>
                                            <input type="text" class="form-control edit-user-data" readonly value="<?=@$details->middle_name?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <h6>Last Name</h6>
                                            <input type="text" class="form-control edit-user-data" readonly value="<?=@$details->last_name?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <h6 class="">Ext. Name</h6>
                                            <input type="text" class="form-control edit-user-data" readonly value="<?=@$details->ext_name?>">
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
                                            <input type="text" class="form-control edit-user-data" readonly value="<?=@$details->contact_number?>">
                                        </div>
                                    </div></br>                    

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-3">
                                            <h6>Contact Person</h6>
                                            <input type="text" class="form-control edit-user-data" readonly value="<?=@$details->contact_person?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <h6>Contact Person Number</h6>
                                            <input type="text" class="form-control edit-user-data" readonly value="<?=@$details->contact_person_number?>">
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
                                            <input type="text" class="form-control" value="<?=@$details->street?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <h6>Province</h6>
                                            <select data-field="province-edit" id="edit-province" style="width: 100%;" class="form-control select2-multiple" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
                                                <?php foreach (@$provinces as $key => $value) {
                                                    ?><option value="<?=$value->ID?>" <?=$value->ID === $details->province_id ? 'selected' : ''?>><?=$value->prov_desc?></option><?php
                                                }?>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <h6>City/Municipality</h6>
                                            <select data-field="citie-edit" id="cities-edit" style="width: 100%;" class="form-control select2-multiple" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
                                                <option disabled selected>City/Municipality</option>                                                                                                                           
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <h6>Barangay</h6>
                                            <select data-field="barangay-edit" id="barangays-edit" style="width: 100%;" class="form-control select2-multiple" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
                                                <option disabled selected>Barangay</option>                                                                                                                    
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane animated fadeIn text-muted" id="classes">
                                    <div class="row">                                        
                                        <div class="row"></br>                                            
                                            <div class="col-xs-12 col-sm-3">
                                                <!-- <label>Date</label> -->
                                                <input type="date" class='form-control cl-form' data-field="cl-date" id="cl-date">
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <!-- <label>No. Classes</label> -->
                                                <input type="number" class='form-control cl-form' data-field="cl-no-class" id="cl-class" placeholder="No. Classes">
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <!-- <label>No. Hours</label> -->
                                                <input type="number" readonly class='form-control cl-form' data-field="cl-no-hours" id="cl-hours" placeholder="No. Hours">
                                            </div>
                                            <div class="col-xs-12 col-sm-2">
                                                <!-- <label>.</label> -->
                                                <button class="form-control btn-md btn-success" id="save-class">SAVE</button>
                                            </div>
                                        </div>
                                    </div></br>
                                    <div class="row">
                                        <label class="font" style="font-weight:bold;">Filter <i class="fa fa-filter"></i></label>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-3">
                                                <input type="date" class="form-control cl-date" data-field="start_date" id="start_date">
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <input type="date" class="form-control cl-date" data-field="end_date" id="end_date">
                                            </div>
                                            <div class="col-xs-12 col-sm-2">
                                                <button class="form-control btn-primary" id="view-classes">VIEW</button>
                                            </div>
                                        </div>
                                    </div></br>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-8">
                                            <table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="15">
                                                <tr style="font-weight:bold;">
                                                    <td>Date</td>
                                                    <td>No. Classes</td>
                                                    <td>Amount</td>
                                                </tr>                                               

                                                <tbody id="load-classes">
                                                </tbody>

                                                <tfoot class="hide-if-no-paging">
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            <ul class="pagination"></ul>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="box" style="background-color:#e6e6e6;">
                                                <div class="box-header" style="background-color:#5590ed;">
                                                    <h4 style="font-weight:bold; text-align:center;">TOTAL INCOME</h4>							
                                                </div>
                                                <div class="row">						
                                                    <div class="box-body" id="load-users-income">								                                                             
                                                    </div>                                           																										
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane animated fadeIn text-muted" id="timerecord">
                                    <div class="row"></br>
                                        <label class="font" style="font-weight:bold;">Filter <i class="fa fa-filter"></i></label>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-3">
                                                <input type="date" class="form-control" id="time-start-date">
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <input type="date" class="form-control" id="time-end-date">
                                            </div>
                                            <div class="col-xs-12 col-sm-2">
                                                <button class="form-control btn-primary" id="view-time">VIEW</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-8">
                                            <table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="15">
                                                <thead>
                                                    <th style="width:40px;">Temperature</th>
                                                    <th style="width:50px;" class="text-muted">Date</th>
                                                </thead>
                                                <tbody id="load-time-record"></tbody>
                                            </table>
                                        </div>
                                    </div>
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
<script src="<?php echo base_url()?>/assets/js/account/class.js"></script>
<script src="<?php echo base_url()?>/assets/js/account/index.js"></script>
<script src="<?php echo base_url()?>/assets/js/account/time_record.js"></script>
