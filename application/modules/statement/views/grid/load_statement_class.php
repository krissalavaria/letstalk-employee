<?php
    if(!empty(@$result)){
        $total_hour = 0;
        $total_class = 0;  
        $total_amount = 0;      
        foreach ($result as $key => $value) {
            ?>
                <tr>
                    <td>&#8369; <?=number_format(@$value->hourly_rate, 2);?></td>
                    <td><?=date('M-d-Y', strtotime(@$value->class_date))?></td>
                    <td><?=@$value->no_classes?></td>
                    <td><?=@$value->no_hours?></td>
                    <td>&#8369; <?=number_format(@$value->total_amount, 2);?></td>
                </tr>
            <?php
            $total_hour += @$value->no_hours;
            $total_class += @$value->no_classes;
            $total_amount += @$value->total_amount;
        }        
        ?>
            <tr style="font-weight: bold;">                
                <td style="background-color:#d5dbd6;">TOTAL</td>
                <td style="background-color:#d5dbd6;"></td>
                <td style="background-color:#d5dbd6;">&#8369; <?=(@$total_class);?></td>
                <td style="background-color:#d5dbd6;">&#8369; <?=(@$total_hour);?></td>
                <td style="background-color:#d5dbd6;">&#8369; <?=number_format(@$total_amount, 2);?></td>
            </tr>
        <?php        
    }

?>
