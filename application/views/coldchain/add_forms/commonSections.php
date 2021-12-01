		<div class="row" >
			<!-- <div class="col-md-1">
			<label for="Date"> Date <span style="color:red;">*</span></label>
			</div>
			<div class="col-md-3">
			<input type="date" id="date" name="date" class="form-control" required>
				
			</div>
			-->
			<!--<div class="col-md-4">
				<div class="row">
					<div class="col-md-4">
						<label for="Date"> Date <span style="color:red;">*</span></label>
					</div>
					<div class="col-md-8">
						<input type="text" id="date" name="date" class="dpcct form-control" required >
					</div>
				</div>
			</div>-->
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-4">
						<label for="Date">Equipment Code <span style="color:red;">*</span></label>
					</div>
					<div class="col-md-8">
						<input type="text" id="id_code" name="ccm_user_asset_id" class="form-control" required> 
					</div>
				</div>
			</div>
			<div class="col-md-4">
					<div class="row">
						<div class="col-md-4">
							<label for="Working">Status<span style="color:red;">*</span></label>
						</div>
						<div class="col-md-8">
							<select class="form-control" name="status" id="status_w" required>
						    <option value="1">Working well</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-4">
							<label for="Utilization">Utilization<span style="color:red;">*</span></label>
						</div>
						<div class="col-md-8">
							<select class="form-control" name="utilizations" required>
						<?php echo getUtilization(); ?>
							</select>
						</div>
					</div>
				</div>	
			<!-- <div class="col-md-2">
			<label for="id_code"> Asset Id / Equipment Code</label>
			</div>		
			<div class="col-md-2">
			<input type="text" id="id_code" name="ccm_user_asset_id" class="form-control" required> </div>-->
				
			
			<!-- <div class="col-md-2">
			<label for="SourceOfSupply">Source of Supply<span style="color:red;">*</span>
			</label>
			</div>
			<div class="col-md-2">
					<select class="form-control" name="source_id" required>
						<?php //echo getSourceSupply(); ?>
					</select>
			</div> -->
			<!--<div class="col-md-4">
				<div class="row"> 
					<div class="col-md-4">
						<label for="SourceOfSupply">Source of Supply<span style="color:red;">*</span>
						</label>
					</div>
					<div class="col-md-8">
						<select class="form-control" name="source_id" required>
							<?php //echo getSourceSupply(); ?>
						</select>
					</div>
				</div>
			</div>-->
			</div>
		<!-- row end-->	
		<div class="row" style="margin-bottom:10px">
				<div class="col-md-4">
				<div class="row">
					<div class="col-md-4">
						<label for="SourceOfSupply">Source of Supply<span style="color:red;">*</span>
						</label>
					</div>
					<div class="col-md-8">
						<select class="form-control" name="source_id" required>
							<?php echo getSourceSupply(); ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="AssetSubType">Supply Year<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" id="working_since" name="working_since" class="dpcct form-control date readonly" required />
									</div>
								</div>
						</div>
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="AssetSubType">Manufacture Date<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" id="manufacturer_year" name="manufacturer_year" class="dpcct form-control date readonly" required />	
									</div>
								</div>
						</div>
				<!--<div class="col-md-4">
					<div class="row">
						<div class="col-md-4">
							<label for="Working">Working Status<span style="color:red;">*</span></label>
						</div>
						<div class="col-md-8">
							<select class="form-control" name="status" id="status_w" required>
						<?php echo getWorkingstatus(); ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4" style="display:none" id="res_hid">
								<div class="row">
									<div class="col-md-4">
										<label for="Reasons">Reasons<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<select class="form-control" name="reasons" id='reasons'>
										<?php echo getReasons(); ?>
										</select>
									</div>
								</div>
				</div>-->				
		</div>
		<!-- row end-->
			<!--<div class="col-md-2">
			<label for="Utilization">Utilization<span style="color:red;">*</span></label>
			</div>
			<div class="col-md-2">
					<select class="form-control" name="utilizations" required>
						<?php echo getUtilization(); ?>
					</select>
			</div>
			
			<div class="col-md-2">
			<label for="Working">Working Status<span style="color:red;">*</span></label>
			</div>
			<div class="col-md-2">
			<select class="form-control" name="status" id="status_w" required>
						<?php echo getWorkingstatus(); ?>
			</select>
			</div>
			<div class="col-md-2 res_hid" style="display:none" >
			<label for="Reasons">Reasons<span style="color:red;">*</span></label>
			</div>
			<div class="col-md-2 res_hid" style="display:none" >
			<select class="form-control" name="reasons" id='reasons'>
						<?php echo getReasons(); ?>
					</select>
			</div>
			!-->
<script type="text/javascript">

$(".readonly").keydown(function(e){
        e.preventDefault();
    });
$(function () {
	$('.dpcct').datetimepicker({
		format : 'yyyy-mm-dd hh:ii:ss',
		color: "green",
		startView : 2,
		viewDate: new Date(),
		endDate : new Date(),
		todayHighlight : true,
		todayBtn : true
	});
	$(document).on("change",".dpcct",function(e) {
		var inputdate = $('#working_since').val();
		var inputdate1 = inputdate.split(" ");
		var enterdate = inputdate1[0];
		var d= new Date();
		var month = d.getMonth()+1;
		if(month < 10){
			month = "0"+month;
		}
		var currentdate = d.getFullYear() + "-" + (month) + "-" + d.getDate();
		var currnttime = d.getHours()+ "-" + d.getMinutes() + "-" + d.getSeconds();
		var dateshoul = currentdate +" "+ currnttime;
		if(enterdate > currentdate){
			alert('SORRY! Stricted For Future Entry.');
			$('#working_since').val(dateshoul);
		}						
	})
});	
</script>				
