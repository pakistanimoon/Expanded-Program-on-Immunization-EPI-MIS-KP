<section class="content">
<div class="container bodycontainer">  
 <div class="row">
  <div class="panel panel-primary">
   <div class="panel-heading">Asset Add Form</div>
    <div class="panel-body">
	<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Coldchain/coldchain_main_save">
				<?php if(isset($id)) { ?>
					<input type="hidden" id="edit" name="edit">
					<input type="hidden" id="id" name="id" value = "<?php echo $id;   ?>">
				<?php } ?>
				<table class="table table-bordered   table-striped table-hover  mytable3">
					<tbody>
						<tr>
								<td><label>WareHouse</label></td>
							<?php if(isset($result)) { ?>
								<td><label> <?php echo $result[0]['warehouse_name']; ?> </label></td>
							<?php }else { ?>
								<td>
								<select id="warehouse_id" required name="warehouse_id" class="form-control">
							<?php foreach($warehouseQ as $key=>$val) { ?>
								<option value="<?php echo $val['pk_id'] ?>"><?php echo $val['warehouse_name']; ?></option>
							<?php } ?>
								</select>
								</td>
							<?php } ?>
						    	<td><label>Asset Type</label></td>
							<?php if(isset($result)) { ?>
								<td><label> <?php echo $result[0]['asset_type_name']; ?> </label></td>
							<?php } else { ?>
								<td>
								<select id="asset_type" required name="asset_type" class="form-control">
								<option value="">--Select--</option>
								<?php foreach($assetTypeQ as $key=>$val) { ?>
								<option value="<?php echo $val['pk_id'] ?>"><?php echo $val['asset_type_name']; ?></option>
								<?php } ?>
								</select>
								</td>
							<?php } ?>
								<td><label>Auto Asset Id</label></td>
								<td>
								<input type="text" <?php if(isset($result)) { ?> value="<?php echo $result[0]['auto_asset_id']; ?>"<?php } ?> id="auto_asset_id" name="auto_asset_id" readonly class="form-control">
								</td>
						</tr>
						<tr>
								<td><label>Status</label></td>
							<?php if(isset($result)) { ?>
								<td><label> <?php echo $result[0]['status']; ?> </label></td>
							<?php } else { ?>
								<td>
								<select  id="status" name="status" class="form-control status">
								<option value="1" selected="selected">Working</option>
								<option value="2">Not Working</option>
								<option value="3">Maintenance Needed</option>
								<option value="12">Working well but fuel not available</option>
								<option value="13">Working well  fuel available</option>
								</select>
								</td>
							<?php } ?>
								<td><label>Reason</label></td>
								<td class="table-td-1">
								<select disabled="disabled" class="form-control text-center reason" name="reason" id="reason" >
								<option  value="0" >Select reason</option>	
								<option value="1">Spare parts are not available for repair/maintenance</option>
								<option  value="2">Finance is not available for repair/maintenance</option>
								<option  value="3">Not in use because electricity or fuel is not available</option>
								<option value="4">Equipment needs to be boarded off</option>					  					  
								<option  value="5">Waiting repair technician</option>					  					  
								<option  value="6">Waiting spare parts</option>					  					  
								<option  value="7">Awaiting finances</option>					  					  
								<option  value="8">Awaiting boarding off</option>					  					  
								<option  value="9">Awaiting boarding off</option>					  					  
								<option  value="10">Unknown</option>
								</select>
								</td>
								<td><label>Utilization</label></td>
								<td class="table-td-1">
								<select class="form-control text-center" name="utilization" id="case_type">
								<option value="12" >In Use</option>
								<option  value="13">Not in use and available for re-allocation</option>
								<option  value="14">Not in use and not available for re-allocation</option>
								<option  value="15">In storage</option>
								</select>
								</td>
						</tr>
						<tr>
								<td><label>Serial No. </label></td>
								<td>
								<input  class="form-control" <?php if(isset($result)) { ?> value="<?php echo $result[0]['serial_no']; ?>"<?php } ?> name="sr_no" id="sr_no" type="text">
								</td>
								<td><label>Expected Life(Years)</label></td>
								<td>
								<input class="form-control" <?php if(isset($result)) { ?> value="<?php echo $result[0]['estimate_life']; ?>"<?php } ?> name="expected_life" id="expected_life" min="1" max="10" type="number">
								</td>
								<td><label>Quantity</label></td>
								<td>
								<input class="form-control" name="quantity" id="quantity"  type="number">
								</td>
                        </tr>
						<tr>
								<td><label>Manufacturing Year</label></td>
								<td>
								<select id="manufacturing_years" required name="manufacturing_years" class="form-control">
							<?php if(isset($result)) { ?> 
								<option value="<?php echo $optionsY; ?>" ></option>                       
							<?php }else{ getYearsOptions(); } ?>
								</select> 
								</td>
								<td><label>Make</label></td>
								<td>
									<select name="maker" required class="form-control" id="maker"></select>
								</td>
								<td><label>Model</label></td>
								<td>
									<select name="model" required class="form-control" id="model"></select>
								</td>
                        </tr>
		                <tr id="model_id">
							<td><label>Working Since</label></td>
							<!-- <td><input class="form-control numberclass" name="working_since" id="working_since" type="number"></td> -->
							<td>
								<select id="manufacturing_years" required name="manufacturing_years" class="form-control">
							<?php if(isset($result)) { ?> 
								<option value="<?php echo $optionsY; ?>" ></option>                       
							<?php }else{ getYearsOptions(); } ?>
								</select> 
								</td>
		                </tr>
					</tbody>
				</table>
        <div class="row">
								<hr>
								<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
								<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
								<button style="background: #008d4c;" class="btn btn-primary btn-md">
								<i class="fa fa-repeat"></i> Reset Form </button>
								<a style="background: #008d4c" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
								</div>
        </div>
    </form>
   </div> <!--end of panel body-->
  </div> <!--end of panel panel-primary-->
 </div><!--end of row-->
</div><!--end of body container-->
</section><!-- /.content -->
<script type="text/javascript">
//call for getting auto asset id
	$(document).on('change','#asset_type',function(){
		var asset_type= $('#asset_type').val();
		var asset_name = $("option:selected",'#asset_type').text();
		var warehouse_id = $('#warehouse_id').val();
		$.ajax({
			type:'post',
			data:'asset_type='+asset_type+'&warehouse_id='+warehouse_id+'&asset_name='+asset_name,
			url:'<?php echo base_url(); ?>Ajax_calls/auto_asset',
			success:function(response){
				$('#auto_asset_id').val(response);
			}
		});
		$.ajax({
			type:'post',
			dataType:'json',
			data:'asset_type='+asset_type,
			url:'<?php echo base_url(); ?>Ajax_calls/get_makers',
			success:function(response1){
				$('#maker').html(response1);
			}
		});
	});
	$(document).on('change','#maker',function(){
		var asset_type = parseInt($('#asset_type').val());
		var makerId = parseInt($('#maker').val());
		if(asset_type > 0 && makerId > 0)
		$.ajax({
			type:'post',
			dataType:'json',
			data:'asset_type='+asset_type+'&makerid='+makerId,
			url:'<?php echo base_url(); ?>Ajax_calls/get_models',
			success:function(responsemodel){
				$('#model').html(responsemodel);
			}
		});
	});
$(document).ready(function(){
	$(document).on('change','.status',function(){
		var $status = $(this).val();
		if($status == '2'){
			$(this).closest('tr').find('.reason').removeAttr('disabled');
		}
		else{
			$(this).closest('tr').find('.reason').prop("disabled", true);
		}	
	});
});
</script>