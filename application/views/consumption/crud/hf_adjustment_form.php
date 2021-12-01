<?php 
date_default_timezone_set('Asia/Karachi');
$current_date = date('d-m-Y');
if(isset($formB_Result)){ 
	$year=substr($formB_Result->fmonth,0,4);
	$month=substr($formB_Result->fmonth,5,7);
}
$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true,array("nature"=>"nature")):false;
?>
<!--start of page content or body-->
<div class="container bodycontainer">  
	<div class="row">
		<div class="panel panel-primary">
			<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
			<div class="panel-heading">Health Facility Stock Adjustment Form</div>
			<div class="panel-body">
				<?php echo form_open(base_url().'hfadjustment/save',array("id"=>"consumptionform","class"=>"form-horizontal")); ?>
					<?php if(isset($formB_Result)){ ?>
						<input type="hidden" name="edit" id="edit" value="edit" />
						<input type="hidden" name="id" id="id" value="<?php echo $formB_Result->id; ?>" />
					<?php } ?>
					<table class="table table-bordered table-striped table-hover  mytable">
						<tr>
							<td><label style="margin-top: 7px;">Province</label></td>
							<td><input class="form-control" name="procode"  readonly="readonly" id="procode" placeholder=" <?php echo $this -> session -> provincename ?>" type="text"></td>
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
								<select id="tcode" name="tcode" class="form-control">
									<?php if(isset($formB_Result)){ ?>
										<option value="<?php echo $formB_Result -> tcode; ?>"><?php echo get_Tehsil_Name($formB_Result -> tcode); ?></option>
									<?php }else{ ?> 
									<?php getTehsils_options(false); } ?>
								</select>
							</td>
							<td><label style="margin-top: 7px;">UC</label></td>
							<td>
							<input id="module" type="hidden" value="vaccine">
								<select id="uncode" name="uncode" class="form-control">
									<?php if(isset($formB_Result)){ ?>
									<option value="<?php echo $formB_Result -> uncode; ?>"><?php echo get_UC_Name($formB_Result -> uncode); ?></option>
									<?php }else{ ?> 
									<?php getUCs_options(false); } ?>
								</select>
							</td>
							<td><label style="margin-top: 7px;">Health Facility/Store</label></td>
							<td>
								<select id="facode" name="facode" class="form-control">
									<?php if(isset($formB_Result)){ ?>
							<option value="<?php echo $formB_Result -> facode; ?>"><?php echo get_Facility_Name($formB_Result -> facode); ?></option>
									<?php }else{ ?>
									<?php }//getFacilities_options(false); } ?>
								</select>
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
								<!--<th><label>Children Vaccinated</label></th>-->
								<th colspan="2"><label>Used</label></th>
								<th colspan="2"><label>Unusable</label></th>
								<th colspan="3"><label>Adjustment</label></th>
								<th colspan="2"><label>Closing Balance</label></th>
							</tr>
							<tr>
								<th>Doses</th>
								<th>Doses</th>
								<!--<th>Nos.</th>-->
								<th>Vials</th>
								<th>Doses</th>
								<th>Vials</th>
								<th>Doses</th>
								<th style="width:1%">Action</th>
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
								<!--<th>D</th>-->
								<th>E</th>
								<th></th>
								<th>F</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th>G</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="myTable" class="consumptionitems default">
							<tr class="text-center">
								<td colspan="15" style="font-size:20px">Please Select criteria from above section, Item(s) will be loaded automatically.</td>								
							</tr>
						</tbody>
					</table>
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-bordered table-striped">
								<tr>
									<td><label style="margin-top: 7px;">Prepared by</label></td>
									<td><input class="form-control" name="prepare_by" id="prepare_by"  value="<?php if(isset($formB_Result)){ echo $formB_Result->prepared_by; } ?>" type="text"></td>
								   
									<td><label style="margin-top: 7px;">Medical Officer / In-charge Name</label></td>
									<td><input class="form-control" name="incharge" id="incharge" value="<?php if(isset($formB_Result)){ echo $formB_Result->hf_incharge; } ?>" type="text">
									<input class="form-control" name="inchargeid" id="inchargeid" value="<?php if(isset($formB_Result)){ echo $formB_Result->hf_incharge; } ?>" type="hidden">
									</td>
									<td><label style="margin-top: 7px;">Date</label></td>
									<td><input class="form-control" readonly="readonly" name="date_submitted" id="date_submitted" value="<?php if(isset($formB_Result)){ if($formB_Result->created_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($formB_Result->created_date)); }else{ echo $current_date; } } else{ echo $current_date; }?>" type="text"></td>
								</tr>
							</table>
						</div>
					</div>					
					<div class="row">      
						<div style="text-align: right;" class="col-md-12">
							<span style="color:red" class="pull-left"><b>Note: </b>Only those products/batches are showing in above table which have atleast 1 vials/dose/pieces available in stock for respective HF in selected month.</span>
						</div>
					</div>
					<div class="row">
						<hr>
						<div style="text-align: right;" class="col-md-12 col-sm-12 col-xs-12">
							<span style="color:red;padding-top:8px;" class="pull-left"><input type="checkbox" id="accepted" value="1"> I confirm that data entered against each product is correct and I want to submit report.</span>
							<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" disabled="disabled" id="savebtn"><i class="fa fa-floppy-o "></i> Save </button>
							<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset"><i class="fa fa-repeat"></i> Reset </button>
							<a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->


<div class="modal fade" id="AddAdjustmentModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form class="modalForm" id="modalForm-adjustment">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-adjustment">Add Adjustment</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-3">
							<label>Product</label>
						</div>
						<div class="col-md-3">
							<span id="productmodal"></span>
						</div>
						<div class="col-md-3">
							<label>Batch</label>
						</div>
						<div class="col-md-3">
							<span id="batchmodal"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Doses Per Vial</label>
						</div>
						<div class="col-md-3">
							<span id="productmodaldoses"></span>
						</div>
						<div class="col-md-3">
							<label id="availablequantitytitle">Balance (Doses)</label>
						</div>
						<div class="col-md-3">
							<span id="availablequantitymodal"></span>
						</div>
					</div>
					<label>Adjustment Type <span style="color:red">*</span></label>
					<select name="adjustmenttype" id="adjustmenttype" required="required" class="form-control">
						<option value=""> Select </option>
						<option value="5" data-nature="0">Lost</option>
						<option value="6" data-nature="1">Lost Recovered</option>
						<option value="9" data-nature="1">Physically Found</option>
						<option value="11" data-nature="0">Physically Not Found</option>
						<option value="3" data-nature="0">Theft</option>
						<?php //echo $adjsttypeshtml; ?>
					</select>
					<label id="quantitytitle"> Quantity to Adjust (Doses)<span style="color:red">*</span></label>
					<input class="form-control numberclass" name="quantitymodal" id="quantitymodal" required="required" type="text">
					<label>Comments<span style="color:red">*</span></label>
					<textarea class="form-control" id="comments" name="comments" required="required"></textarea>
					<div class="row pt10">
						<div class="col-md-6" style="margin-left: 65%;">
							<button id="submitAdjustment" class="btn-background box1" type="button" data-dismiss="modal"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
							<button id="cancelmodal" class="btn-background box1" type="button" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							<input type="hidden" id="rownum" name="rownum" value="" />
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>


<script type="text/javascript">
$(document).ready(function(){
	/* Function to get selected facility incharge */
	function getIncharge(){
		var facode = $('#facode').val();
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
						$("#inchargeid").val(resultarray['id']);
						
					}
				}
			});
		}			
	}
	$(document).on('keydown', function(e){
		if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
	//code by moon start here
	$(document).on('change','#facode,#month', function (){		
		var facode = $("#facode").val();
		var month = $("#month").val();
		var year = $("#year").val(); 
		var table = 'epi_consumption_master';
		//'form_b_cr';//old table
		var edit = 0;
		var edit=$("#edit").val();
        if(edit=="edit")
		{
			edit='1';
			$("#prepare_by").attr('disabled','disabled');
			$("#incharge").attr('disabled','disabled');
		}		
		else{
			edit=0;
		}				
		if(facode>0 && month>0 && month<13 && year>2014){
			$.ajax({
				type: 'POST',
				data: "facode="+facode+"&year="+year+"&month="+month+"&edit="+edit+"&table="+table,
				url: "<?php echo base_url(); ?>Ajax_calls/validateExistRecord",
				success: function(result){					
					var fmonth = year+"-"+month;
					var result = result.trim();
					if(result == 'Yes' && edit==0){
						$.ajax({
							type: "post",
							data: {fmonth:fmonth,facode:facode},//check is_compiled 0 or 1
							url: "<?php echo base_url(); ?>Ajax_calls/check_compiled_datasource",
							success: function(compiled){
								var resultarray = JSON.parse(compiled);
								var is_compiled = resultarray.is_compiled;
								var data_source = resultarray.data_source;
								if(is_compiled=='1' && data_source=='web'){
									if (confirm("Report Already Exists! Do you want to edit it?")==true) {
										window.location.href = "<?php echo base_url(); ?>consumption/edit/"+fmonth+"/"+facode;
									} else {
										window.location.reload(); 
									} 
								}else if(is_compiled=='1' && data_source=='app'){
									if (confirm("Report Already Exists! Do you want to view it?")==true) {
										window.location.href = "<?php echo base_url(); ?>consumption/view/"+fmonth+"/"+facode;
									} else {
										window.location.reload(); 
									} 
								}else{
									if (confirm("Report Already Submitted from Mobile App,Do you want to Compile it?")==true) {
										var r = true;
											if (r == true) {
												$.ajax({
													type: "post",
													data: {fmonth:fmonth,facode:facode},
													url:"<?php echo base_url(); ?>Ajax_calls/update_is_compiled",
													success: function(data){
														if(data=='Yes'){
															alert('Date Compiled Successfully');
															window.location.href = "<?php echo base_url(); ?>consumption";
														}else{
															alert('Date Does not Compiled'); 
															window.location.href = "<?php echo base_url(); ?>consumption";
														}
													}
												}); 
											}
										//window.location.href = "<?php echo base_url(); ?>consumption/edit/"+fmonth+"/"+facode;
									} else { 
										window.location.reload(); 
									} 
								}
							}	
						}); 
						
					}else if(result == 1 && edit==0){
						if (confirm("Report Freezed! You can not add/edit record for selected facility, month and year!")==true) {
							//move user to list
							window.location.href = "<?php echo base_url(); ?>consumption";
						} else { 
							window.location.reload();
						} 
					}else{
						//validation about basic fields selected or not.------work remaining---- may be skipped as facode,fmonth checked above
						
						//check if table already shown or not
						var eraseAll = false;
						if($(".consumptionitems").hasClass("default")){ //alert('dd');
							eraseAll = true;
						}else{ //alert('cc');
							//table already shown confirm from user to refresh.
							eraseAll = confirm("Do you want to reset all items according to new Health Facility and purpose selection?\n It will erase your data.");
						}
						//Allow items data entry by showing items panel
						if(eraseAll){ //alert('bb');
							//show loading in table...----- work remaining
							$.ajax({
								type: "post",
								data: {activity:1,fmonth:fmonth,facode:facode,edit:edit},//1 for routine
								url: "<?php echo base_url("hfadjustmentitems"); ?>",
								success: function(result){
									try {
										$(".consumptionitems").html(result);
										$(".consumptionitems").removeClass("default");
									} catch(error) {
										alert("Some Error in data fetching!!");
									}
								}
							});
						}else{ 
							//set health facility dropdown to previously selected state -------- work remaining
							//$(".consumptionitems").addClass("default");
						}						
					}
				}
			});
			getIncharge();
			//here set cildren vaccinated against each product from vaccination if needed---------work remaining
			//set_children_vacc();
		}
	});
	//when edit then triggger it
	var edit=$('#edit').val();
	if(edit=="edit"){
		$('#facode').trigger('change');
	}
	function filluseddoses(currrowobj){
		//fill used in doses
		var usedval = parseInt($(currrowobj).find(".usedinv").val()) || 0;
		var dosesinvial = parseInt($(currrowobj).find(".doses").text()) || 1;
		var indoses = usedval*dosesinvial;
		$(currrowobj).find(".usedind").val(indoses);
	}
	function fillunuseddoses(currrowobj){
		//fill unused in doses
		var unusedval = parseInt($(currrowobj).find(".unusedinv").val()) || 0;
		var dosesinvial = parseInt($(currrowobj).find(".doses").text()) || 1;
		var indoses = unusedval*dosesinvial;
		$(currrowobj).find(".unusedind").val(indoses);
	}
	function fillusedvials(currrowobj){
		//fill used in vials
		var useddoses = parseInt($(currrowobj).find(".usedind").val()) || 0;
		var dosesinvial = parseInt($(currrowobj).find(".doses").text()) || 1;
		var invials = (useddoses>0)?(useddoses/dosesinvial):0;
		$(currrowobj).find(".usedinv").val(invials);
	}
	function fillunusedvials(currrowobj){
		//fill unused in vials
		var unuseddoses = parseInt($(currrowobj).find(".unusedind").val()) || 0;
		var dosesinvial = parseInt($(currrowobj).find(".doses").text()) || 1;
		var invials = (unuseddoses>0)?(unuseddoses/dosesinvial):0;
		$(currrowobj).find(".unusedinv").val(invials);
	}
	function calculateclosing(currrowobj){
		//calculate and fill closing balance in doses and vials
		var obdoses = parseInt($(currrowobj).find(".ob").text()) || 0;
		var recdoses = parseInt($(currrowobj).find(".received").text()) || 0;
		var totalstock = obdoses+recdoses;
		var useddoses = parseInt($(currrowobj).find(".usedind").val()) || 0;
		var unuseddoses = parseInt($(currrowobj).find(".unusedind").val()) || 0;
		var adjustdoses = parseInt($(currrowobj).find(".adjustind").val()) || 0;
		var adjustnature = $(currrowobj).find(".input-group-addon").data("nature");
		var totalconsume = useddoses+unuseddoses;
		var closingdoses = obdoses+recdoses-useddoses-unuseddoses;
		if(adjustnature=="positive"){
			closingdoses = closingdoses+adjustdoses;
		}else if(adjustnature=="negative"){
			closingdoses = closingdoses-adjustdoses;
		}
		if(closingdoses>=0){
			var vaccinated = parseInt($(currrowobj).find(".childvacc").val()) || 0;
			if(vaccinated>0 && vaccinated>totalconsume){
				$(currrowobj).css("background-color","#F54F4F");
				alert("Total Doses Consumed cannot be less than total Children Vaccinated / Doses Administered");
				return false;
			}else{
				$(currrowobj).css("background-color","#FFF");
				//set closing balance and calculate closing vials
				$(currrowobj).find(".closingind").val(closingdoses);
				var dosesinvial = parseInt($(currrowobj).find(".doses").text()) || 1;
				var closingvials = closingdoses/dosesinvial;
				$(currrowobj).find(".closinginv").val(closingvials);
				//enable adjustment button.
				$(currrowobj).find(".adjustadd").removeAttr("disabled");
				return true;
			}
		}else{
			//there is some error in balance, it can't be in minus
			$(currrowobj).css("background-color","#F54F4F");
			if(totalconsume > totalstock){
				alert("Used+Unused Doses/Vails cannot be greater than received+Opening balance");
				return false;
			}
			alert("Used+Unused and adjusted Doses/Vails cannot be greater than received+Opening balance");
			return false;
		}
	}
	$(document).on('change','.childvacc',function(){
		var obdoses = parseInt($(this).closest("tr").find(".ob").text()) || 0;
		var recdoses = parseInt($(this).closest("tr").find(".received").text()) || 0;
		var totalstock = obdoses+recdoses;
		var vaccinated = parseInt($(this).val()) || 0;
		if(vaccinated>0 && vaccinated>totalstock){
			$(this).css("background-color","#F54F4F");
			alert("Number of Children Vaccinated cannot be greater than total Available stock in doses.");
		}else{
			$(this).css("background-color","#FFF");
		}
	});
	$(document).on('change','.usedinv,.unusedinv',function(){
		filluseddoses($(this).closest("tr"));
		fillunuseddoses($(this).closest("tr"));
		calculateclosing($(this).closest("tr"));
	});
	$(document).on('change','.usedind,.unusedind',function(){
		fillusedvials($(this).closest("tr"));
		fillunusedvials($(this).closest("tr"));
		calculateclosing($(this).closest("tr"));
	});
	function enablesavedisableentry(){
		$( "#consumptionform input:enabled, #consumptionform select:enabled, .adjustadd:enabled" ).each(function(){
			if($(this).attr("id")!=="accepted"){
				$(this).addClass("moontempdisabled");
				$(this).attr("disabled","disabled");
			}
		});
		$("#savebtn").removeAttr("disabled");				
	}
	function disablesaveenableentry(){
		$( "#consumptionform" ).find(".moontempdisabled").each(function(){
			if($(this).attr("id")!=="accepted"){
				$(this).removeClass("moontempdisabled");
				$(this).removeAttr("disabled");
			}
		});
		$("#savebtn").attr("disabled","disabled");
	}
	$(document).on('change','#accepted',function(){
		if(this.checked) {
			//check is basic fields selected or not
			//perform client side validation and set variable validated-------- work remaining
			var count = $(".onebatch").length;
			if(count>0){
				var validated = true;
				$(".onebatch").each(function(){
					validated = calculateclosing($(this).closest("tr"));
					if(validated){}else{return false;}
				});				
				if(validated){
					//enable save button and disable data entry
					enablesavedisableentry();
				}else{
					//disable save button and enable data entry again
					disablesaveenableentry();
					$(this).prop("checked",false);
				}
			}else{
				alert("There is no item exist in form, You can't Save form.");
				$(this).prop("checked",false);
			}
		}else{
			//disable save button and enable data entry again
			disablesaveenableentry();
		}
	});
	$(document).on('click','#savebtn',function(){
		$( "#consumptionform input:disabled, #consumptionform select:disabled" ).each(function(){			
			$(this).removeAttr("disabled");
		});
		$("#savebtn").attr("disabled","disabled");
		$(this.form).submit();
	});
	$(document).on('click','.adjustadd',function(){
		//modal open, set field values if basic requirement fullfilled, data in respective row should be filled before this form.
		//basic req check work remaining---------
		var name = $(this).closest("tr").find(".itemname").text();
		$("#productmodal").text(name);
		
		var dosesinvial = parseInt($(this).closest("tr").find(".doses").text()) || 1;
		$("#productmodaldoses").text(dosesinvial);
		
		var batch = $(this).closest("tr").find(".prodbatch").text();
		$("#batchmodal").text(batch);
		
		var closingdoses = parseInt($(this).closest("tr").find(".closingind").val()) || 0;
		var totalstock = closingdoses;
		
		var quantitytype = $(this).data("quantitytype");
		if(quantitytype=="v"){
			$("#quantitytitle").text("Quantity to Adjust (Vials)");
			$("#availablequantitytitle").text("Balance (Vials)");
			var closingvials = parseInt($(this).closest("tr").find(".closinginv").val()) || 0;
			totalstock = closingvials;
		}else{
			$("#quantitytitle").text("Quantity to Adjust (Doses)");
			$("#availablequantitytitle").text("Balance (Doses)");
		}		
		$("#availablequantitymodal").text(totalstock);
		$("#rownum").val((parseInt($(this).closest("tr").index()) || 0)+1);
	});
	$(document).on('click','#submitAdjustment',function(){
		//get modal values and set in row fields, subtract from opening and closing of vials quantity.
		var nature = $("#adjustmenttype option:selected").data("nature");
		var quantitytoadjust = parseInt($("#quantitymodal").val()) || 0;
		if(quantitytoadjust>0){
			var clickedrow = $("#rownum").val();
			var rowobj = $(".consumptionitems tr:nth-child("+clickedrow+")");
			var quantitytype = $(rowobj).find(".adjustadd").data("quantitytype");
			var dosesinvial = parseInt($(rowobj).find(".doses").text()) || 1;
			if(quantitytype=="v"){
				$(rowobj).find(".adjustinv").val(quantitytoadjust);
				var indoses = quantitytoadjust*dosesinvial;
				$(rowobj).find(".adjustind").val(indoses);
			}else{
				$(rowobj).find(".adjustind").val(quantitytoadjust);
				var invials = (quantitytoadjust>0)?(quantitytoadjust/dosesinvial):0;
				$(rowobj).find(".adjustinv").val(invials);
			}
			//reset default icon
			$(rowobj).find('.input-group-addon').remove();
			if(nature==1){
				$(rowobj).find('.input-group').append('<span class="input-group-addon" data-nature="positive" style="padding:1px;color:green;"><i class="glyphicon glyphicon-circle-arrow-up"></i></span>');
				$(rowobj).find('.adjustnature').val(1);
				$(rowobj).find('.adjusttype').val($("#adjustmenttype option:selected").val());
				$(rowobj).find('.adjustcomments').val($("#comments").val());
			}else if(nature==0){
				$(rowobj).find('.input-group').append('<span class="input-group-addon" data-nature="negative" style="padding:1px;color:red;"><i class="glyphicon glyphicon-circle-arrow-down"></i></span>');
				$(rowobj).find('.adjustnature').val(0);
				$(rowobj).find('.adjusttype').val($("#adjustmenttype option:selected").val());
				$(rowobj).find('.adjustcomments').val($("#comments").val());
			}else {
				//reset default values
				$(rowobj).find(".adjustinv").val(0);
				$(rowobj).find(".adjustind").val(0);
				$(rowobj).find('.adjustnature').val('');
				$(rowobj).find('.adjusttype').val('');
				$(rowobj).find('.adjustcomments').val('');
				//
				alert("Sorry, Adjustment cannot be added, Adjustment Type not selected!");
				//empty adjustment type field. recalculate closing balance
			}
			//calculate closing balance
			calculateclosing(rowobj);
		}else{
			alert("Sorry, Adjustment cannot be added, Value in Quantity to Adjust Field is wrong!");
			//empty quantity field. recalculate closing balance
		}
	});
	$(document).on('paste','#quantitymodal',function(e){
		e.preventDefault();
	});
});	

</script>