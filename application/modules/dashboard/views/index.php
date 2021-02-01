<?php
	main_header(['dashboard']);	
?>
<!-- ############ PAGE START-->
<link rel="stylesheet" href="<?= base_url()?>assets/css/global.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url()?>assets/css/tables.css" type="text/css" />
<div class="padding">	
	<div id="pageMessages"></div>
	<div class='box p-a'>
		<div class="row">		
			<div class="box box-body">
				<div class="row">
					<div class="b-b nav-active-bg">
						<div class="b-b nav-active-bg">
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link active" href data-toggle="tab" data-target="#menu">MENUS</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href data-toggle="tab" data-target="#order-history">ORDERS</a>
								</li>
							</ul>
						</div>
						<div class="tab-content p-a m-b-md">
							<div class="tab-pane animated fadeIn active text-muted" id="menu">
								<div class="row">
									<div class="col-sm-7">
										<div class="row">
											<div class="box" style="background-color:#e6e6e6;">							
												<select id="prod-category" class="form-control" style="width: 100%;" class="input-property form-control select2-multiple" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
													<option disabled selected>Select Category</option>	
													<?php foreach ($category as $key => $value) {
														?><option value="<?=@$value->ID?>"><?=@$value->product_category_name?></option><?php
													}?>															
												</select>
											</div>
										</div>
										<div class="row" id="load-product-category">																					
										</div>
									</div>

									<div class="col-sm-5">
										<div class="box" style="background-color:#e6e6e6;">
											<div class="box-header" style="background-color:#5590ed;">
												<h4 style="font-weight:bold;">ORDER LISTS</h4>							
											</div>
											<div class="body">
												<table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="10">													
													<tr style="font-weight:bold">
														<td>Prod.</td>
														<td>Qty.</td>
														<td>Price</td>
														<td></td>
														<td></td>
														<td></td>
													</tr>

													<tbody id="load-order-list">
													</tbody>

													<tfoot class="hide-if-no-paging">
														<tr>
															<td colspan="5" class="text-center">
																<ul class="pagination"></ul>
															</td>
														</tr>
													</tfoot>
												</table>
												<div class="box-body">
													<h6 id="cred-limit" style="display:none; color:red;">* You've reached the maximum credit limit per day</h6>
													<button class="form-control btn-primary" id="confirm-order">CONFIRM ORDER</button>
												</div>								
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane animated fadeIn text-muted" id="order-history">
								<div class="row">
									<div class="box-body">
										<label class="font" style="font-weight:bold;">Filter <i class="fa fa-filter"></i></label>
										<div class="row">
											<div class="col-xs-12 col-sm-3">
												<input type="date" class="form-control" id="start-order-date">
											</div>
											<div class="col-xs-12 col-sm-3">
												<input type="date" class="form-control" id="end-order-date">
											</div>
											
											<div class="col-xs-12 col-sm-2">
												<button class="form-control btn-primary" id="view-order-histo">VIEW</button>
											</div>
										</div><hr>
										<div class="row">
											<div class="col-xs-12 col-sm-6">
												<div class="box" style="background-color:#e6e6e6;">
													<div class="box-header" style="background-color:#5590ed;">
														<h4 style="font-weight:bold;">ORDER HISTORY</h4>							
													</div>
													<table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="10">
														<thead>
															<th style="width:10px"></th>
															<th>Order No.</th>																										
															<th class="text-muted">Order Date</th>
															<th class="text-muted">Status</th>
														</thead>
														<tbody id="load-order-history">
														</tbody>
													</table>
												</div>												
											</div>
											<div class="col-xs-12 col-sm-6">
												<div class="box" style="background-color:#e6e6e6;">
													<div class="box-header" style="background-color:#5590ed;">
														<h4 style="font-weight:bold; text-align:center;">STATEMENT OF ACCOUNT</h4>							
													</div>
													<div class="row">														
														<div class="box-body" id="load-statement"></div>
																																									
													</div>
												</div>											
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>															
				</div>																										
			</div>				
		</div>			
	</div>
</div>

<!-- Modal order summary -->
<div class="modal fade" id="history-modal" role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h5 class="modal-title"><i class="fa fa-file-text-o"></i> ORDER SUMMARY</h5>
			
		</div>
        <div class="modal-body">			
			<div>				
				<table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="10">					
					<tr style="font-weight:bold;">
						<td>Qty</td>
						<td>Name</td>
						<td>Price</td>
						<td>Total</td>
					</tr>
					<tbody id="load-history-modals"></tbody>
				</table>
			</div>													
        </div>
		<div class="text-center"><span><b style="color:red;">Reminder ***</b> order can be cancel within 3 hours</span></div>
        <div class="modal-footer">   
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<button type="button" class="form-control btn-warning pull-left" id="cancel-order"><i class="fa fa-times"></i> CANCEL ORDER</button>
				</div>
				<div class="col-xs-12 col-sm-6">
					<button class="form-control btn btn-primary" id="view-receipt"><i class="fa fa-file-text-o"></i> GENERATE RECEIPT</button>
				</div>
			</div>															  	
        </div>
      </div>      
    </div>
  </div>

<!-- ############ PAGE END-->

<!-- modal fo pincode -->
<div class="modal fade" id="pin-modal" role="dialog">
    <div class="modal-dialog modal-sm">    
      <!-- Modal content-->
      <div class="modal-content">
	  	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>	
			<h5>INPUT SECURITY PIN</h5>		
		</div>	
        <div class="modal-body">			
			<div>				
				<input type="password" class="form-control" id="pin-number" placeholder="PIN">
			</div>													
        </div>		
        <div class="modal-footer">          																
		  	<button type="button" class="form-control btn-warning" id="proceed-order">PROCEED</button>
        </div>
      </div>      
    </div>
  </div>
<!-- page end -->
<?php
	main_footer();
?>
<script>
	var cred_limit = <?php echo json_encode(@$credits);?>;
</script>
<script src="<?php echo base_url()?>/assets/js/dashboard/index.js"></script>
<script src="<?php echo base_url()?>/assets/js/dashboard/orders.js"></script>
<script src="<?php echo base_url()?>/assets/js/dashboard/order_history.js"></script>