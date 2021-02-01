<?php
    if(!empty($result)){        
        foreach ($result as $key => $value) {
            ?>
                <div class="col-xs-12 col-sm-4">
                    <div class="box grey-100">
                        <div class="box-header light-blue-200" style="height: 50px;">
                            <h4 style="font-weight:bold;"><?=strtoupper(@$value->product_name)?></h4>							
                        </div>
                        <div class="box-body">
                            <span style="margin: 0 auto;">
                                <div id="person-image" style="transition: all 0.3s ease; background-image: url('<?php echo base_url()?>assets/images/Logo/logo-cafe.png')"></div>																	                                        
                            </span><br>
                            <div>
                                <h6 class="m-a-0 text-center">(&#8369;) <?=@$value->price?>.00</h6></br>
                                <button class="form-control btn-sm btn-default add-order" data-id="<?=@$value->ID?>" data-unit="<?=@$value->product_unit_id?>" data-category="<?=@$value->product_category_id?>" data-price="<?=@$value->price?>"><i class="fa fa-plus-square"></i> ADD</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    }else{
        ?>
            <div class="col-xs-12 col-sm-12">
                <h6>No available menu</h6>
            </div>
        <?php
    }
?>