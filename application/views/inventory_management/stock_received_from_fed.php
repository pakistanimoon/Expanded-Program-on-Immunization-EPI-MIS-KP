<section class="content">
    <div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"> Stock Fetched (Federal)</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">							
							<button id="fetchnewvoucherbtn" style="background:#008d4c;" class="btn btn-primary btn-md pull-right" role="button"><i class="fa fa-arrow-down "></i> Fetch New Vouchers </button>
						</div>
					</div>
				</div> <!--end of panel body-->
				<div class="panel-body" id="receive_panel">
					<div class="panel-heading">Fetched List (Most Recent 15)</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-condensed tbl-im">
								<thead>
									<tr>
										<th>Sr No.</th>
										<th>Voucher Number</th>
										<th>Fetched date</th>
										<th>Transaction Date</th>
										<th>Number of Batches</th>
										<th>Voucher Status</th>
										<!--<th>Activity/Purpose</th>-->
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="receive_list"><?php 
									foreach($fetchedrec as $key=>$onerec){
										echo '
											<tr>
												<th>'.($key+1).'</th>
												<th><a href="'.base_url().'voucher/'.$onerec["transaction_number"].'" target="_blank" >'.$onerec["transaction_number"].'</a></th>
												<th>'.$onerec["created_date"].'</th>
												<th>'.$onerec["transaction_date"].'</th>
												<th>'.$onerec["transaction_counter"].'</th>';
												$status=substr($onerec["transaction_number"],0,1); 
												if($status=='I'){
													echo '<th>Pending</th>';
												}else{
													echo '<th>Received</th>';
												}
												foreach($vouchers as $key=>$onevoucher){
													if($onevoucher["transaction_number"]==$onerec["transaction_number"]){
														echo '<th><a id="edit_button" data-original-title="Edit" href="" data-id='.$onerec['transaction_number'].' data-toggle="modal" data-target="#EditLevelModal" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData" ><i class="fa fa-trash-o text-danger"></i></a></th>';
													}
												}
										echo '</tr>
										';
									}?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<!----VoucherDeletepopup------->
<div class="modal fade" id="EditLevelModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form name="data" class="modalForm" id="modalForm-status1" action="<?php echo base_url(); ?>Hr_management/level_edit" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-status">Delete Voucher Products</h4>
				</div>
				<div class="modal-body" id="rowid">
				</div>
			</div>
		</form>
	</div>
</div>
<!------VoucherDeletepopup-------->	
<script type="text/javascript">
	$(document).ready(function(){
		$("#fetchnewvoucherbtn").click(function(){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("fedIssue"); ?>",
				success: function(result){
					alert(result);
					location.reload();
				}
			});
		});
	});
	//VoucherDeletepopup
	$('.editData').on('click', function()
	{
		var id = $(this).data("id");
		$.ajax
		({
			type: "POST",
			data: "id="+id,
			url: "<?php echo base_url(); ?>Delete-fedIssue",
			success: function(response)
			{
				$("#rowid").html(response);
			}
		});
	});
</script>