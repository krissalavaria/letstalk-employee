<?php    
    if(!empty($result)){
        $total = 0;
        foreach ($result as $key => $value) {
            ?><tr>
                <td class="confirm-orders" data-prodid="<?=@$value->product_id?>" data-orderno="<?=@$value->ID?>" data-qty="<?=@$value->qty?>" data-orderid="<?=@$value->order_no?>"><?=@$value->qty?></td>
                <td><?=substr(@$value->product_name, 0, 10)?></td>
                <td>&#8369; <?=number_format(@$value->product_price, 2)?></td>
                <td style="font-weight:bold;">&#8369; <?=number_format(@$value->total_amount, 2)?></td>
            </tr><?php
            $total+=@$value->total_amount;
        }
        ?><tr style="color:black;">
            <td colspan="3" class="text-right" style="font-weight:bold; background-color:#1ae854;">TOTAL</td>
            <td colspan="1" class="text-left" style="font-weight:bold; background-color:#1ae854;">&#8369; <?=number_format($total, 2)?></td>
        </tr><?php
    }
?>