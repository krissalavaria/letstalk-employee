<?php
    if(!empty($result)){
        $total = 0;
        foreach ($result as $key => $value) {
            ?>
                <tr>                    
                    <td><button class="form-control btn-sm btn-primary view-details" data-status="<?=@$value->order_status?>" data-orderno="<?=@$value->ID?>" data-date="<?=@$value->order_date?>" data-orderid="<?=@$value->order_no?>">DETAILS</button></td>
                    <td><?=@$value->order_no?></td>         
                    <td style="font-size:12px;"><?=date('m-d-Y H:i A', strtotime(@$value->order_date))?></td>     
                    <td style="font-weight:bold;"><?=@$value->order_status?></td>
                </tr>                          
            <?php           
        }
    }else{
        ?><tr>
            <td colspan="4">Empty order lists</td>
        </tr><?php
    }
?>