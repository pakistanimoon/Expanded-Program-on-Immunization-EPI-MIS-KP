<style>
    .row:nth-of-type(even) {
    background: #f4f4f4;
}

</style>
<div class="panel panel-primary">
	<div class="panel-heading">Voltage Regulator View Form</div>
	<div class="panel-body" style="width:70%; position:relative; left:15%; border:1px solid lightgray; box-shadow:1px 1px 5px lightgray; margin-top:3px;">
		<div class="row" style="margin-bottom:20px">
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Make</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['make_name']; ?></text>
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Working Since (Year)">Model</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['model_name']; ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->
				<div class="row" style="margin-bottom:20px">
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Working Since (Year)">Input Voltage Range (vAC)</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['input_voltage_range']; ?></text>
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Output Voltage Range (vAC)</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['output_voltage_range']; ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->	
								<!--- row --->
				<div class="row" style="margin-bottom:20px">
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Working Since (Year)">Cost(US$)</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['product_price']; ?></text>
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Frequency(Hz)</label>
									</div>
									<div class="col-md-8">
									<text><?php echo $data['frequency']; ?></text>
									</div>
								</div>
						</div>
				</div>
				<!--- row --->	
					<div class="row" style="margin-bottom:20px">
						<div class="col-md-5  col-md-offset-1">
								<div class="row">
									<div class="col-md-4">
										<label for="Serial Number">Placed at</label>
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
	var url="<?php echo base_url();?>Coldchain/voltageRegulatorEdit/";
	url+=asset_id;
	window.open(url);
});
$('#cancel').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/voltageregulator_list/23";
	window.location.href=url;
});
</script>								
								