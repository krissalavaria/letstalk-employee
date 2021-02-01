<?php
    if(!empty($result)){
        $total = 0;
        foreach ($result as $key => $value) {            
            ?>
                <tr>    
                    <td class="prod-ids" data-qty="<?=@$value->qty?>" data-id="<?=@$value->product_id?>"><?=substr(@$value->product_name, 0, 5)?>.</td>
                    <td><?=@$value->qty?></td>
                    <td>&#8369; <?=@$value->total_amount?>.00</td>
                    <td><button class="btn btn-xs btn-block minus-qty" style="width:100%;" data-id="<?=@$value->ID?>" data-price="<?=@$value->price?>"><i class="fa fa-minus-square"></i></button></td>
                    <td><button class="btn btn-xs btn-warning add-qty" style="width:100%;" data-id="<?=@$value->ID?>" data-price="<?=@$value->price?>"><i class="fa fa-plus-square"></i></button></td>
                    <td><button class="btn btn-xs btn-danger del-order" style="width:100%;" data-orderno="<?=@$value->order_no?>" data-id="<?=@$value->ID?>"><i class="fa fa-trash"></i></button></td>
                </tr>                        
            <?php
            $total+=@$value->total_amount;
        }                        
        ?><tr style="color:black; font-weight:bold;">
            <td colspan="2" style="background-color:#1ae854;" class=text-right style="font-weight:bold">TOTAL</td>
            <td colspan="4" style="background-color:#1ae854;">&#8369; <span id="total-amount"><?=number_format($total, 2)?></span></td>
        </tr><?php
    }else{
        ?><tr>
            <td colspan='3'>Empty Order Lists</td>
        </tr><?php
    }    
?>
<script>
    var order_number = <?php echo json_encode(@$result[0]->order_no);?>;
    var Total = <?php echo json_encode(@$total);?>;    
</script>