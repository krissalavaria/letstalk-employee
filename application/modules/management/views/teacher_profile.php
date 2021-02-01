<?=main_header(['mgt']);?>
<!-- ############ PAGE START-->
<link rel="stylesheet" href="<?= base_url()?>assets/css/global.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url()?>assets/css/tables.css" type="text/css" />
<div class="padding">	
    <div id="pageMessages"></div>
	<div class='box p-a'>
		<div class="row">		
			<div class="box-header">
				<h5><i class="fa fa-user"></i> CLASS LISTS </h5>
			</div>
            <div class="box-body">
                <div class="row" id="edit-data" style="display:none;">
                    <div class="col-xs-12 col-sm-3">
                        <label>Date</label>                       
                        <input type="date" class="form-control cl-form" data-field="cl-date" id="class-date">
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <label>No. Class</label>
                        <input type="numebr" class="form-control cl-form" data-field="cl-no-class" id="no-class"> 
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <label>No. Hours</label>
                        <input type="number" readonly class="form-control cl-form" data-field="cl-no-hours" id="no-hours">
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <label>.</label>
                        <button class="form-control btn-success btn-md" id="btn-save-edited">SAVE</button>
                    </div>
                </div>
                <table class="table">
                    <tr style="font-weight:bold;">
                        <td>Date</td>
                        <td>No. Class</td>
                        <td>Amount</td>
                        <td>Option</td>
                    </tr>
                    <tbody>
                        <?php
                            foreach (@$detail as $key => $value) {
                                ?><tr>
                                    <td><?=date('M-d-Y', strtotime(@$value->class_date))?></td>
                                    <td><?=@$value->no_classes?></td>
                                    <td>&#8369; <?=number_format(@$value->total_amount, 2)?></td>
                                    <td style="width:10%; text-align:center;"><button class="form-control btn-warning btn-md btn-editing" data-token="<?=@$value->auth_token?>" data-id="<?=@$value->ID?>" data-class="<?=@$value->no_classes?>" data-hour="<?=@$value->no_hours?>" data-amount="<?=@$value->total_amount?>">EDIT</button></td>
                                </tr><?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?=main_footer();?>
<script src="<?php echo base_url()?>assets/js/management/management.js"></script>