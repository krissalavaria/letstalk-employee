<?=main_header(['mgt']);?>
<!-- ############ PAGE START-->
<link rel="stylesheet" href="<?= base_url()?>assets/css/global.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url()?>assets/css/tables.css" type="text/css" />
<div class="padding">	
    <div id="pageMessages"></div>
	<div class='box p-a'>
		<div class="row">		
			<div class="box-header">
				<h5><i class="fa fa-user"></i> TEACHERS LISTS</h5>
			</div>
			<div class="box-body">
				<table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="10">
					<tr style="font-weight:bold;">
						<td>Teacher ID</td>
						<td>Teacher Name</td>
						<td>Option</td>
					</tr>

					<tbody id="load-teachers-list">
					</tbody>

					<tfoot class="hide-if-no-paging">
						<tr>
							<td colspan="5" class="text-center">
								<ul class="pagination"></ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
<?=main_footer();?>
<script src="<?php echo base_url()?>assets/js/management/management.js"></script>