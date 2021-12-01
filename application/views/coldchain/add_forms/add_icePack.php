<div class="panel panel-primary cst-label">
  <div class="panel-heading">Add Ice Packs</div>
	<div class="panel-body">
		<form method="post" action="<?php echo base_url() ?>Coldchain/icePackSave" onsubmit="return checkRequired();" enctype="multipart/form-data">
			<input type="hidden" id="edit_quantity" name="edit" class="form-control numberclass edit_quantity" />
			<div class="add_refrigerator inside-page">
				<div class="row" style="margin-bottom:10px">
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-4">
											<label for="Date"> Date <span style="color:red;">*</span></label>
									</div>
										<div class="col-md-8">
											<input type="text" id="date" class="icpdate form-control" readonly="true"/>
										</div>
									</div>
								</div>
						</div><!--- row --->	
					<?php
					$data['form']= "AICP";
					$data['offset'] = "No";
					$this -> load -> view('coldchain/add_forms/storesSection',$data) ?>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th style="width:11%:">Ice Pake Size</th>
										<th>Quantity</th>
										<th style="width:11%:">Ice Pake Size</th>
										<th>Quantity</th>
										<th style="width:11%:">Ice Pake Size</th>
										<th>Quantity</th>
										<th style="width:11%:">Ice Pake Size</th>
										<th>Quantity</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><label>0.2</label></td>
										<td><input type="text" id="2quantity" name="2quantity" class="form-control numberclass quantity" required/></td>
										<td><label>0.3</label></td>
										<td><input type="text" id="3quantity" name="3quantity" class="form-control numberclass quantity" required/></td>
										<td><label>0.4</label></td>
										<td><input type="text" id="4quantity" name="4quantity" class="form-control numberclass quantity" required/></td>
										<td><label>0.5</label></td>
										<td><input type="text" id="5quantity" name="5quantity" class="form-control numberclass quantity" required/></td>
									</tr>
									<tr>
										<td><label>0.6</label></td>
										<td><input type="text" id="6quantity" name="6quantity" class="form-control numberclass quantity" required/></td>
										<td><label>0.7</label></td>
										<td><input type="text" id="7quantity" name="7quantity" class="form-control numberclass quantity"required/></td>
										<td><label>0.8</label></td>
										<td><input type="text" id="8quantity" name="8quantity" class="form-control numberclass quantity" required/></td>
										<td><label>0.9</label></td>
										<td><input type="text" id="9quantity" name="9quantity" class="form-control numberclass quantity" required/></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div><!--- row --->
					<div class="row" style="margin-bottom:10px">
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary btn-md" style="background:#008d4c none repeat scroll 0% 0%; float: right;"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
					</div>
				</div>
				<!--<div class="text-right">
						<div class="row">
							<div class="col-md-5 col-md-offset-7">
							<button type="submit" style="background-color:#00a65a;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="Button" class="btn-background box1" id="cancel"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div>
				</div>-->
				<!--- row --->			  
				</div><!-- col-md-12 -->
			</form>
			</div><!--- row --->	
		
	</div>

<script type="text/javascript">
$(function () {
	$('.icpdate').datetimepicker({
		format : 'yyyy-mm-dd hh:ii:ss',
		color: "green",
		startView : 2,
		viewDate: new Date(),
		endDate : new Date(),
		todayHighlight : true,
		todayBtn : true
	});
});
/* $('#cancel').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/Add-assets/27";
	window.location.href=url;
}); */
</script>