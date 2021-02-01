<?php        
    if(!empty($Creditss)){        
        ?><table class="table m-b-none" ui-jp="footable">
            <tr>
                <td>Coverage</td>
                <td>Total Income</td>
                <td>Credits</td>
                <td>Accnt. Balance</td>
            </tr>
            <tr style="color: black; font-weight:bold;">
                <td style="background-color:#1ae854;"><?=date('M (d-', strtotime(@$Coverage->cycle_date)).''.date('d', strtotime(@$Coverage->cycle_date_end)).')'?></td>
                <td style="background-color:#1ae854;">&#8369; <?=number_format(@$Incomes, 2)?></td>
                <td style="background-color:#1ae854;">&#8369; <?=number_format(@$Creditss, 2)?></td>
                <td style="background-color:#1ae854;">&#8369; <?=number_format(@$Balances, 2)?></td>
            </tr>
        </table><?php
    }else{
        
    }
?>