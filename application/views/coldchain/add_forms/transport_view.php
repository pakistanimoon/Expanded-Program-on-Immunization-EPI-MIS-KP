<style>
    .row:nth-of-type(even) {
    background: #f4f4f4;
}
.col-xs-offset-1:nth-of-type(even) {
    background: #f4f4f4;
}

</style>
<div class="panel panel-primary">
	<div class="panel-heading">Transport View Form</div>
	<div class="panel-body"  style="width:70%; position:relative; left:15%; border:1px solid lightgray; box-shadow:1px 1px 5px lightgray; margin-top:3px;">
			<div class="row" style="margin-bottom:20px" >
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Temperature">Asset ID<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text><?php echo (isset($data)?$data['asset_id']:''); ?></text>						
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Source of Supply</label>
									</div>
									<div class="col-md-8">
									<text><?php echo (isset($data)?getSourceSupply($data['source_id'],TRUe):''); ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->	
				<div class="row" style="margin-bottom:20px" >
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Temperature">Working Status<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text><?php echo (isset($data)?getWorkingstatus($data['status'],TRUe):''); ?></text>						
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Make</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['make_name']; ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->	
				<!--- row --->	
				<div class="row" style="margin-bottom:20px" >
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Temperature">Model<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['model_name']; ?></text>						
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Registration No</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['registration_no']; ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->
				<!--- row --->	
				<div class="row" style="margin-bottom:20px" >
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Temperature">Engine No.<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['engine_no']; ?></text>						
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Chases No.</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['chases_no']; ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->
				<!--- row --->	
				<div class="row" style="margin-bottom:20px" >
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Temperature">Transport Type<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text><?php echo getTransportType($data['transport_type'],TRUe); ?></text>						
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Fuel Type</label>
									</div>
									<div class="col-md-8">
									<text><?php if(isset($data)){ echo getPowerSource($data['fuel_type_id'],TRUe);} ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->		
							<!--- row --->	
				<div class="row" style="margin-bottom:20px" >
						<?php if( isset($data['transport_type']) && $data['transport_type']== 30 ) { 
						$col="col-md-6";
						?>
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Temperature">Capacity<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['used_for_epi']; ?></text>						
									</div>
								</div>
						</div>
						<?php }?>
						<div class="<?php echo (isset($col)?$col:"col-md-5 col-md-offset-1");?>">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Placed At</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['storename']; ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->		
				<div class="text-right">
									<div class="col-md-5 col-md-offset-7">
										<button id="update-view" type="Button" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Update</span></button>
											<button type="Button" class="btn-background box1" id="cancel" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
									</div>
								</div>
	</div>
</div>
<script type="text/javascript">
$('#update-view').on('click', function(e) {
	var asset_id=<?php echo $assetid;?>;
	//alert(asset_id);
	var url="<?php echo base_url();?>Coldchain/transportEdit/";
	url+=asset_id;
	window.open(url);
});
$('#cancel').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/transport_list/25";
	window.location.href=url;
});
</script>