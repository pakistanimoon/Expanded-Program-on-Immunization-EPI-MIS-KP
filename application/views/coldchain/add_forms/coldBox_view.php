<style>
    .row:nth-of-type(even) {
    background: #f4f4f4;
}
.col-xs-offset-1:nth-of-type(even) {
    background: #f4f4f4;
}

</style>
<div class="panel panel-primary">
	<div class="panel-heading">Cold Box View Form</div>
	<div class="panel-body" style="width:70%; position:relative; left:15%; border:1px solid lightgray; box-shadow:1px 1px 5px lightgray; margin-top:3px;">
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
										<label for="Serial Number">Source Of Supply</label>
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
										<label for="Temperature">Catalog ID<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text><?php echo (isset($data)?$data['catalogue_id']:''); ?></text>						
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Working Status</label>
									</div>
									<div class="col-md-8">
									<text><?php echo (isset($data)?getWorkingstatus($data['status'],TRUe):''); ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->
						<div class="row" style="margin-bottom:20px" >
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Temperature">Make<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text><?php echo (isset($data)?$data['make_name']:''); ?></text>						
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Model</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['source_id']; ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->	
				<div class="row" style="margin-bottom:20px" >
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Temperature">Catalogue ID<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text><?php echo (isset($data)?$data['catalogue_id']:''); ?></text>						
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Working Status</label>
									</div>
									<div class="col-md-8">
									<text><?php echo (isset($data)?getWorkingstatus($data['status'],TRUe):''); ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->	
				<div class="row" style="margin-bottom:20px" >
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Temperature">Dimensions<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<text>Length : <?php echo $data['length'];?> | Width : <?php echo $data['width'];?> | Height : <?php echo $data['height'];?></text>						
									</div>
								</div>
						</div>
						<div class="col-md-6">
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
	var url="<?php echo base_url();?>Coldchain/coldBoxEdit/";
	url+=asset_id;
	window.open(url);
});
$('#cancel').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/coldbox_list/33";
	window.location.href=url;
});
</script>				