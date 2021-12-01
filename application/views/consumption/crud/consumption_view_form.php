<?php 
date_default_timezone_set('Asia/Karachi');
$current_date = date('d-m-Y');
 if(isset($formB_Result)){ 
 $year=substr($formB_Result->fmonth,0,4);
 $month=substr($formB_Result->fmonth,5,7);
 $facode=$formB_Result->facode;
 
 }

?>
<!--start of page content or body-->
<div class="container bodycontainer">  
	<div class="row">
		<div class="panel panel-primary">
			<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
			<div class="panel-heading">Health Facility Monthly Consumption View Form</div>
			<div class="panel-body">				
				<?php if(isset($formB_Result)){ ?>
					<input readonly="readonly"  type="hidden" name="edit" id="edit" value="edit" />
					<input readonly="readonly"  type="hidden" name="id" id="id" value="<?php echo $formB_Result->id; ?>" />
				<?php } ?>
				<table class="table table-bordered table-striped table-hover  mytable">
					<tr>
						<td><label style="margin-top: 7px;">Province</label></td>
						<td><input readonly="readonly"  class="form-control" name="procode"  readonly="readonly" id="procode" placeholder=" <?php echo $this -> session -> provincename ?>" type="text"></td>
						<td><label style="margin-top: 7px;">District</label></td>
						<td>
							<select id="distcode" name="distcode" class="form-control">
								<?php if(isset($formB_Result)){ ?>
									<option value="<?php echo $formB_Result -> distcode; ?>"><?php echo get_District_Name($formB_Result -> distcode); ?></option>
								<?php }else{ getDistricts(false,$this -> session -> District); } ?>
							</select>
						</td>
						<td><label style="margin-top: 7px;">Date (MM/YY)</label></td>
						<td>
							<table style="width: 100%;">
								<tr>
									<td>
										<select name="month" id="month" class="form-control">
										<?php if(isset($formB_Result)){ ?> <option value="<?php echo $month; ?>"><?php echo monthname($month); ?></option> <?php }else{ getAllMonthsOptions(false); } ?>
										</select>
									</td>
									<td>
										<select name="year" id="year" class="form-control">
										<?php if(isset($formB_Result)){ ?> <option value="<?php echo $year; ?>"><?php echo $year; ?></option> <?php }else{ getAllYearsOptions(false); /* getAllYearsOptionsIncludingCurrent(false); */ } ?>
										</select>
									</td>
								</tr>
							</table>             	
						</td>
					</tr>
					<tr>
						<td><label style="margin-top: 7px;">Tehsil</label></td>
						<td>
							<?php if(isset($formB_Result)){
								 echo get_Tehsil_Name($formB_Result -> tcode);
								 } ?>
						</td>
						<td><label style="margin-top: 7px;">UC</label></td>
						<td>
						<?php if(isset($formB_Result)){
						echo get_UC_Name($formB_Result -> uncode);
						}?>
						</td>
						<td><label style="margin-top: 7px;">Health Facility/Store</label></td>
						<td>
						<?php if(isset($formB_Result)){ 
						echo get_Facility_Name($formB_Result -> facode);
								}?>
						</td>
					</tr>  
				</table>
				<table class="table table-bordered table-condensed table-striped table-hover mytable">
					<thead>
						<tr>
							<th rowspan="2" style="width:14%;"><label>Product</label></th>
							<th rowspan="2" style="width:7%;"><label>Batch number</label></th>
							<th rowspan="2" style="width:1%;"><label>Doses Per Vial</label></th>
							<th><label>Opening Balance</label></th>
							<th><label>Received</label></th>
							<th><label>Children Vaccinated</label></th>
							<th colspan="2"><label>Used</label></th>
							<th colspan="2"><label>Unusable</label></th>
							<th colspan="2"><label>Adjustment</label></th>
							<th colspan="2"><label>Closing Balance</label></th>
						</tr>
						<tr>
							<th>Doses</th>
							<th>Doses</th>
							<th>Nos.</th>
							<th>Vials</th>
							<th>Doses</th>
							<th>Vials</th>
							<th>Doses</th>
							<th>Vials</th>
							<th>Doses</th>
							<th>Vials</th>
							<th>Doses</th>
						</tr>
						<tr style="background: white none repeat scroll 0% 0%; color: black;">
							<th></th>
							<th></th>
							<th>A</th>
							<th>B</th>
							<th>C</th>
							<th>D</th>
							<th>E</th>
							<th></th>
							<th>F</th>
							<th></th>
							<th></th>
							<th></th>
							<th>G</th>
							<th></th>
						</tr>
					</thead>
					<tbody><?php 
						$disabledstyle = 'background-color:#eee;';
						$toppadding = 'padding-top:11px;';
						foreach($viewdata as $key=>$singleVacc){
							$batch=$singleVacc["batch"];
							$dosepervial=$singleVacc["doses"];?>
							<tr class="onebatch">
								<td style="<?php echo $toppadding; ?>"><?php echo ($singleVacc["item_category_id"]!=1)?trim($singleVacc["item_name"]):trim($singleVacc["itemname"]); ?>
									<!-- for detail pk_id to update data -->
									<input readonly="readonly"  class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][detail_id]" value="<?php echo $singleVacc["detail_id"]; ?>" type="hidden" >
									<!-- master id for report for update -->
									<input readonly="readonly"  class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][master_id]" value="<?php echo $singleVacc["pk_id"]; ?>" type="hidden" > 
								</td>
								<td style="<?php echo $toppadding; ?>"><?php echo $batch; ?></td>
								<td class="text-center doses" style="<?php echo $toppadding.' '.(($dosepervial>0)?'':$disabledstyle); ?>"><?php echo $dosepervial; ?></td>
								<td class="text-center ob" style="<?php echo $toppadding.' '.$disabledstyle; ?>"><?php echo $singleVacc["opening"]; ?></td>
								<td class="text-center received" style="<?php echo $toppadding.' '.$disabledstyle; ?>"><?php echo $singleVacc["recdoses"]; ?></td>
								<td>
									<!--Children Vaccinated-->
									<input readonly="readonly"  class="form-control numberclass childvacc" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][vaccinated]" type="text" <?php echo ($singleVacc["item_category_id"]!=1)?'disabled="disabled"':''; ?> value="<?php echo ($singleVacc["vaccinated"])?$singleVacc["vaccinated"]:''; ?>">
								</td>
								<td>
									<!--Used Vials-->
									<input readonly="readonly"  class="form-control numberclass usedinv" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][usedvials]" type="text" <?php echo ($singleVacc["in_doses"])?'disabled="disabled"':''; ?> value="<?php echo ($singleVacc["used_vials"])?$singleVacc["used_vials"]:''; ?>">
								</td>
								<td>
									<!--Used Doses-->
									<input readonly="readonly"  class="form-control numberclass usedind" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][useddoses]" type="text" <?php echo ($singleVacc["in_doses"])?'':'disabled="disabled"'; ?> value="<?php echo ($singleVacc["used_doses"])?$singleVacc["used_doses"]:''; ?>">
								</td>
								<td>
									<!--Unused Vials-->
									<input readonly="readonly"  class="form-control numberclass unusedinv" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][unusedvials]" type="text" <?php echo ($singleVacc["in_doses"])?'disabled="disabled"':''; ?> value="<?php echo ($singleVacc["unused_vials"])?$singleVacc["unused_vials"]:''; ?>">
								</td>
								<td>
									<!--Unused Doses-->
									<input readonly="readonly"  class="form-control numberclass unusedind" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][unuseddoses]" type="text" <?php echo ($singleVacc["in_doses"])?'':'disabled="disabled"'; ?> value="<?php echo ($singleVacc["unused_doses"])?$singleVacc["unused_doses"]:''; ?>">
								</td>
								<td>
								<div class="input-group">
									<!--Adjusted Vials-->
									<input readonly="readonly"  class="form-control numberclass" type="text" value="<?php echo ($singleVacc["adjustment_quantity_vials"])?$singleVacc["adjustment_quantity_vials"]:''; ?>">
									<?php if(isset($singleVacc["nature"]))
								{
										if($singleVacc["nature"]!="")
										{
										echo ($singleVacc["nature"]=='1')?'<span class="input-group-addon" data-nature="positive" style="padding:1px;color:green;"><i class="glyphicon glyphicon-circle-arrow-up"></i></span>':'<span class="input-group-addon" data-nature="negative" style="padding:1px;color:red;"><i class="glyphicon glyphicon-circle-arrow-down"></i></span>';
										}
								}?>
								</div>
								</td>
								<td>
								<div class="input-group">
									<!--Adjusted Doses-->
									<input readonly="readonly"  class="form-control numberclass" type="text" value="<?php echo ($singleVacc["adjustment_quantity_doses"])?$singleVacc["adjustment_quantity_doses"]:''; ?>">
									<?php if(isset($singleVacc["nature"]))
									{
												if($singleVacc["nature"]!="")
												{
												echo ($singleVacc["nature"]=='1')?'<span class="input-group-addon" data-nature="positive" style="padding:1px;color:green;"><i class="glyphicon glyphicon-circle-arrow-up"></i></span>':'<span class="input-group-addon" data-nature="negative" style="padding:1px;color:red;"><i class="glyphicon glyphicon-circle-arrow-down"></i></span>';
												}
									}?>
								</div>	
								</td>
								<td>
									<!--Closing Vials-->
									<input readonly="readonly"  class="form-control numberclass closinginv" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][closingvials]" type="text" disabled="disabled" value="<?php echo $singleVacc["closing_vials"]; ?>">
								</td>
								<td>
									<!--Closing Doses-->
									<input readonly="readonly"  class="form-control numberclass closingind" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][closingdoses]" type="text" disabled="disabled" value="<?php echo $singleVacc["closing_doses"]; ?>">
									<input readonly="readonly"  class="form-control" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][batch]" value="<?php echo $batch; ?>" type="hidden" >
									<input readonly="readonly"  class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][doses]" value="<?php echo ($dosepervial>0)?$dosepervial:1; ?>" type="hidden" >
									<input readonly="readonly"  class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][ob]" value="<?php echo $singleVacc["opening"]; ?>" type="hidden" >
									<input readonly="readonly"  class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][received]" value="<?php echo $singleVacc["recdoses"]; ?>" type="hidden" >
								</td>
							</tr>
							<?php 
						}?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered table-striped">
							<tr>
								<td><label style="margin-top: 7px;">Prepared by</label></td>
								<td><input readonly="readonly"  class="form-control" name="prepare_by" id="prepare_by"  value="<?php if(isset($formB_Result)){ echo $formB_Result->prepared_by; } ?>" type="text"></td>
							   
								<td><label style="margin-top: 7px;">Medical Officer / In-charge Name</label></td>
								<td><input readonly="readonly"  class="form-control" name="incharge" id="incharge" value="<?php if(isset($formB_Result)){ echo $formB_Result->hf_incharge; } ?>" type="text"></td>
							  
								<td><label style="margin-top: 7px;">Date</label></td>
								<td><input readonly="readonly"  class="form-control" readonly="readonly" name="date_submitted" id="date_submitted" value="<?php if(isset($formB_Result)){ if($formB_Result->created_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($formB_Result->created_date)); }else{ echo $current_date; } } else{ echo $current_date; }?>" type="text"></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<hr>
					<div style="text-align: right;" class="col-md-12 col-sm-12 col-xs-12">
						<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;"  class="btn btn-primary btn-md" id="update"><i class="fa fa-floppy-o "></i> Update </button>
						<a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md">Back </a>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
$(document).on('click','#update',function(){
	var year='<?php echo $year;?>';
	var month='<?php echo $month;?>';
	var facode='<?php echo $facode;?>';
	var fmonth=year+'-'+month;
	window.location.href="<?php echo base_url();?>consumption/edit/"+fmonth+"/"+facode+"";
		});	
	//for showing hf incharge.for future get it by function name
	getIncharge();
	function getIncharge(){
		var facode='<?php echo $facode;?>';
		if(facode!=0){
			$.ajax({
				type: "POST",
				data: {facode:facode},
				url: "<?php echo base_url(); ?>Ajax_calls/getIncharge",
				success: function(result){
					var resultarray = JSON.parse(result);
					if(resultarray== null){
						$("#incharge").val('');
					}
					else{
						$("#incharge").val(resultarray['incharge']);
						
						
					}
				}
			});
		}			
	}
});	
</script>