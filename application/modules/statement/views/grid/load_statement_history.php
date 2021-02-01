<?php
    if(empty(@$details)){
        ?><div class="box-body"><h6 style="color:red;">No data found.</h6></div><?php
    }else{
        ?><div class="row">               
            <div class="box-body">                
                <div class="col-xs-12 col-sm-6">
                    <label><b>Name:</b> <?=@$details->first_name.' '.@$details->middle_name.'. '.@$details->last_name?></label><br>
                    <label><b>Address:</b> <?=@$details->street.' '.@$details->barangay.', '.@$details->city.', '.@$details->province?></label><br>
                    <label><b>Contact No:</b> <?=@$details->contact_number?></label>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <label><b>Date Coverage: </b> <?=date('F', strtotime(@$details->cycle_date)).' ['.date('d', strtotime(@$details->cycle_date)).'-'.date('d', strtotime(@$details->cycle_date_end)).']'?></label><br>
                    <label><b>Teacher ID: </b> <?=@$details->employee_no?></label><br>
                    <?php if(@$details->is_cleared == 0):?>
                        <label><b>Status: </b><span style="color:green"><u>ON GOING</u></span></label>
                    <?php endif;?>
                </div>
            </div>
        </div><hr style="border-top: 1px dashed black;">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <table class="table">
                    <tr style="font-weight:bold;">
                        <td>Hour Rate</td>
                        <td>Date</td>
                        <td>No. Class</td>
                        <td>No. Hours</td>
                        <td>Amount</td>
                    </tr>
                    <tbody id="load-statement"></tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-4">
                <table class="table">
                    <tr>
                        <td>Desc.</td>                                
                        <td>Amount</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Total Income</td>
                        <td style="background-color:#d5dbd6;">&#8369; <?=number_format(@$total_amount, 2);?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Total Credits</td>
                        <td style="background-color:#d5dbd6;">&#8369; <?=number_format(@$Credits, 2);?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Current Balance</td>
                        <td style="background-color:#d5dbd6;">&#8369; <?=number_format(@$Balance, 2);?></td>
                    </tr>
                </table>
            </div>
        </div><?php
    }
?>