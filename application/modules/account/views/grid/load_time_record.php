<?php
    if(!empty(@$result)){
        foreach (@$result as $key => $value) {
            ?><tr>
                <td><?=@$value->temperature?></td>
                <td><?=date('M-d-Y, H:i A', strtotime(@$value->created_at))?></td>
            </tr><?php
        }
    }
?>