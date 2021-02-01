<?php
    if(!empty($result)){
        foreach ($result as $key => $value) {
            ?><tr>
                <td><?=@$value->employee_no?></td>
                <td><?=@$value->first_name.' '.@$value->middle_name.'. '.@$value->last_name?></td>
                <td style="width:10%; text-align:center;"><a href="<?php echo base_url()?>management/teacher_account?get=<?=@$value->auth_token?>" class="form-control btn-primary btn-md">OPEN</a></td>
            </tr><?php
        }
    }else{
        ?><tr>
            <td colspan="2">No data found.</td>
        </tr><?php
    }
?>