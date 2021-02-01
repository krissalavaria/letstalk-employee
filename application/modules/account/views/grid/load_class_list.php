<?php
    if(!empty($result)){
        $total = 0;
        foreach ($result as $key => $value) {
            ?><tr>
                <td><?=date('M-d, Y', strtotime(@$value->class_date))?></td>
                <td><?=@$value->no_classes?></td>            
                <td><?=number_format(@$value->total_amount, 2)?></td>
                <?php if(date('M-d-Y', strtotime(@$value->class_date)) === date('M-d-Y')):?>
                    <td><button class="btn btn-sm btn-warning edit-class" data-id="<?=@$value->ID?>" data-date="<?=date('M-d, Y', strtotime(@$value->class_date))?>" data-class="<?=@$value->no_classes?>" data-hours="<?=@$value->no_hours?>"><i class="fa fa-edit"></i></button></td>
                <?php endif;?>
            </tr><?php
            $total+=@$value->total_amount;
        }
        ?><tr style="font-weight:bold; color:black;">
            <td class="text-right" style="background-color:#1ae854;" colspan="2">TOTAL</td>
            <td class="text-left" style="background-color:#1ae854;" colspan="1"><?=number_format(@$total, 2)?></td>
        </tr><?php
    }else{

    }
?>