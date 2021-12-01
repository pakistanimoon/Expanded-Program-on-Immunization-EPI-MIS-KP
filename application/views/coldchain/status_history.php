<!-- Main content -->
<?php 
	if($this -> session -> flashdata('message')){  ?>
		<div class="row mb3">
			<div class="col-sm-12 filters-selection" style="Background-color:#008d4c;">
				<div class="text-center pt5 pb5" role="alert" style="color:white;">
					<strong><?php echo $this -> session -> flashdata('message'); ?></strong>
				</div> 
			</div>
		</div>
<?php 
	} 
?>
<section class="content">
	<div class="container bodycontainer">  
		<div class="row">  
			<div class="panel panel-primary">
				<div class="panel-heading">Update Cold Chain Assets Working Status</div>
				<div class="panel-body">
					<form class="form-horizontal" method="post" action="<?php echo base_url();?>Admin_Configuration/status_history_update">
						<div class="row" style="width:100%; margin:0 auto;">
							<div class="col-md-4" style="margin-top:6px;">
								<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px; width:100%;">
									<label for="Warehouse-Type" style="margin:10px 0px 0xp 10px">Warehouse Type : </label>
									<input name="idd" id="idd" type="hidden">
									<select class="form-control" name="warehouse_type_id" id="store_id" required>
										<option value="0">Select</option>
										<?php if($this -> session -> District){ ?>
										<option value="4">District</option>
										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<?php }else{ ?>
										<option value="2">Provincial</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-4" style="margin-top:6px;display:none" id="dist_hid">
								<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px;width:100%;">
									<label for="Make" style="margin:10px 0px 0xp 10px">District : </label>
									<select class="form-control" name="distcode" id="distcodeSH">
										<option value="">--Select Warehouse Type First--</option>
									</select>
								</div>
							</div>
							<div class="col-md-4" style="margin-top:6px;display:none" id="tcode_hid">
								<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px;width:100%;">
									<label for="Make" style="margin:10px 0px 0xp 10px">Tehsil : </label>
									<select class="form-control" name="tcode" id="tcodeSH">
										<option value="">--Select Warehouse Type First--</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="width:100%; margin:0 auto;">
							<div class="col-md-4" style="margin-top:6px;display:none" id="uncode_hid">
								<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px; width:100%;">
									<label for="Make" style="margin:10px 0px 0xp 10px">Union Council : </label>
									<select class="form-control" name="uncode" id="uncodeSH">
										<option value="">--Select Warehouse Type First--</option>
									</select>
								</div>
							</div>
							<div class="col-md-4" style="margin-top:6px;display:none" id="facode_hid">
								<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px;width:100%;">
									<label for="Make" style="margin:10px 0px 0xp 10px">Select Warehouse : </label>
									<select class="form-control" name="facode" id="facode">
										<option value="">--Select Warehouse Type First--</option>
									</select>
								</div>
							</div>
						</div>
						<?php $this -> load -> view('coldchain/statustoupdate_list'); ?>
						<div class="row">
							<hr>
							<div style="text-align: left;" class="col-md-2 ">
								<p>
									<h4 style="font-size: 13px;background: #d6d6fe;padding: 10px 4px;text-align: center;">Today Date(<script> document.write(new Date().toLocaleDateString()); </script> )</h4>
								</p>
							</div>
						</div>
						<div class="row">
							<hr>
							<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
								<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button" id="update" ><i class="fa fa-floppy-o "></i> Update  </button>
							</div>
						</div>      
					</form>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->		
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change','.status',function(){
			var status = $(this).val();
			if(status == '3')
			{
				$(this).closest('tr').find('.reason').removeAttr('disabled');
				
			}
			else
			{
				$(this).closest('tr').find('.reason').prop("disabled", true);
			}
		});
		$(document).on('keyup','.quanitity',function(){
			var entervalue = $(this).val();
			var total= $(this).closest('tr').find('.total').data('tl');
			if (entervalue > total)
			{
				alert("greater then  Total ");
				$(this).closest('td').find('#quanitity').val(total);
			}
		});
		<?php if($this -> session -> District){ ?>
			$(document).on('change','#store_id',function(){
				var id=$(this).val();
				if(id==4){
					$("#dist_hid").hide();
					$("#tcode_hid").hide();
					$("#uncode_hid").hide();
					$("#facode_hid").hide();
					$("#tcodeSH").text('');
					$("#uncodeSH").text('');
					$("#facode").text('');
				}
				if(id!=0){
					$.ajax({
						type: "POST",
						data:"distcode="+"",
						async:false,
						url: "<?php echo base_url(); ?>Ajax_calls/getDistricts_options",
						success: function(result){
							$('#distcodeSH').html(result);
							$("#dist_hid").show();
							$('#distcodeSH').attr('required',true);
							$('#distcodeSH').trigger('change');
							if(id==4){
								var base_url = '<?php echo base_url(); ?>';
								var DistrictCode = $('#distcodeSH').val();
								var location=base_url+'Update-status/'+id+'/'+DistrictCode;
								window.location.href = location;
							}else if(id==5){
								$("#tcodeSH").text('');
								$("#uncodeSH").text('');
								$("#facode").text('');
								$("#tcode_hid").show();
								$("#uncode_hid").hide();
								$("#facode_hid").hide();
							}else if(id==6){
								$("#tcodeSH").text('');
								$("#tcode_hid").show();
								$("#uncodeSH").text('');
								$("#uncode_hid").show();
								$('#tcodeSH').attr('required',true);
								$('#uncodeSH').attr('required',true);
							}
						}
					});
				}else{
					$("#dist_hid").hide();
					$("#tcode_hid").hide();
					$("#uncode_hid").hide();
					$("#facode_hid").hide();
				}
			});
		<?php }else{ ?>
			$(document).on('change','#store_id',function(){
				var base_url = '<?php echo base_url(); ?>';
				if(parseInt($(this).val()) == 2){
					window.location.href = base_url+'Update-status/2';
				}
			});
		<?php } ?>
		$(document).on('change','#distcodeSH', function(){
			var storeID = $("#store_id").val();
			var distcode = $('#distcodeSH').val();
			$("#tcodeSH").val('');
			if(storeID==5 || storeID==6){
				if(distcode == 0) {
				  $("#tcode_hid").hide();
				  $("#uncode_hid").hide();
				  $("#facode_hid").hide();
				}else{
					$.ajax({
						type: "POST",
						data: "distcode="+distcode,
						url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
						success: function(result){
							$('#tcodeSH').html(result);
							if(storeID==5){
								$("#tcode_hid").show();
							}
							if(storeID==6){
								$("#tcode_hid").show();
								$("#uncodeSH").val('');
								$("#uncode_hid").show();
							}
						}
					});
				}
			}							
		});
		$(document).on('change','#tcodeSH', function(){
			var storeID = $("#store_id").val();
			var tcode = $('#tcodeSH').val();
			var DistrictCode = $('#distcodeSH').val();
			var base_url = '<?php echo base_url(); ?>';
			if(storeID==6){
				$("#facode_hid").hide();
				if(tcode!=0) {
					$.ajax({
						type: "POST",
						data: "tcode="+tcode,
						url: "<?php echo base_url(); ?>Ajax_calls/getUnC",
						success: function(result){
							$('#uncodeSH').html(result);
							if(storeID==6){
								$("#uncode_hid").show();
							}
						}
					});
				}else{
					$("#uncode_hid").hide();
					$("#facode_hid").hide();
				}
			}else if(storeID == 5){
				var location=base_url+'Update-status/'+storeID+'/'+DistrictCode+'/'+tcode;
				window.location.href = location;
			}									
		});
		$(document).on('change','#uncodeSH', function(){
			var uncode = $('#uncodeSH').val();
			if(uncode == 0) {
			  $("#facode_hid").hide();
			}else{
				$.ajax({
						type: "POST",
						data: "uncode="+uncode,
						url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
						success: function(result){
							$('#facode').html(result);
							$("#facode_hid").show();
						}
					});
			}
									
		});
		$(document).on('change','#facode', function(){
			var base_url = '<?php echo base_url(); ?>';
			var storeID = $("#store_id").val();
			var DistrictCode = $('#distcodeSH').val();
			var TehsilCode = $('#tcodeSH').val();
			var UCCode = $('#uncodeSH').val();
			var FacilityCode = $('#facode').val();
			var location=base_url+'Update-status/'+storeID+'/'+DistrictCode+'/'+TehsilCode+'/'+UCCode+'/'+FacilityCode;
			window.location.href = location;
		});
	});
</script>