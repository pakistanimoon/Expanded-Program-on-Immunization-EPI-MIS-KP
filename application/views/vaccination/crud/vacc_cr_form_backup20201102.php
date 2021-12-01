<?php 
date_default_timezone_set('Asia/Karachi');
$current_date = date('d-m-Y');
if(isset($formB_Result)){ 
	$year=substr($formB_Result->fmonth,0,4);
	$month=substr($formB_Result->fmonth,5,7);
}
$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true,array("nature"=>"nature")):false;
?>
<style>
	.rotateheaderlabels{
		transform: rotate(270deg);
		white-space: nowrap;
	}
</style>
<!--start of page content or body-->
<div class="container bodycontainer">  
	<div class="row">
		<div class="panel panel-primary">
			<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
			<div class="panel-heading">Health Facility Monthly Vaccination & Consumption Form</div>
			<div class="panel-body">
				<?php echo form_open(base_url().'vaccination/save',array("id"=>"vacc_cr_form","class"=>"form-horizontal")); ?>
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
											<?php if(isset($formB_Result)){ ?> <option value="<?php echo $year; ?>"><?php echo $year; ?></option> <?php }else{ getAllYearsOptions(false);} ?>
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
						<tr>
							<td colspan="2"><label>Monthly Target For Children 0-11</label></td>
							<td><label>Male</label></td>
							<td><input class="form-control numberclass" name="tc_male" id="tc_male" value="<?php echo isset($vacc_Result)?$vacc_Result->tc_male:0; ?>" placeholder="Number" type="text"></td>
							<td><label>Female</label></td>
							<td><input class="form-control numberclass" name="tc_female" id="tc_female" value="<?php echo isset($vacc_Result)?$vacc_Result->tc_female:0; ?>" placeholder="Number" type="text"></td>
						</tr>
						<tr>
							<td><label>Monthly Target for Pregnant Women</label></td>
							<td><input class="form-control numberclass" name="pw_monthly_target" id="pw_monthly_target" value="<?php echo isset($vacc_Result)?$vacc_Result->pw_monthly_target:0; ?>" placeholder="Number" type="text"></td>
							<td><label>Total LHWs Attached</label></td>
							<td><input class="form-control numberclass" name="tot_lhw_attached" id="tot_lhw_attached" value="<?php echo isset($vacc_Result)?$vacc_Result->tot_lhw_attached:0; ?>" placeholder="Number" type="text"></td>
							<td><label>Total LHWs Involved in Vaccination</label></td>
							<td><input class="form-control numberclass" name="tot_lhw_involved_vacc" id="tot_lhw_involved_vacc" value="<?php echo isset($vacc_Result)?$vacc_Result->tot_lhw_involved_vacc:0; ?>" placeholder="Number" type="text"></td>
						</tr> 
					</table>
					<table class="table table-bordered table-condensed table-striped table-hover mytable3">
						<thead>
							<tr>
								<th colspan="10" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">EPI Services</th>
							</tr>
							<tr>
								<th colspan="2">Fixed Vaccination Session by Vaccinator/s</th>
								<th colspan="2">Outreach Vaccination Session by Vaccinator/s</th>
								<th colspan="2">Mobile Vaccination Session by Vaccinator/s</th>
								<th colspan="2">Health House Vaccination Session by LHWs</th>
							</tr>
							<tr>
								<th>Planned</th>
								<th>Actually held</th>
								<th>Planned</th>
								<th>Actually held</th>
								<th>Planned</th>
								<th>Actually held</th>
								<th>Planned</th>
								<th>Actually held</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input class="form-control numberclass" name="fixed_vacc_planned" id="fixed_vacc_planned" value="<?php echo isset($vacc_Result)?$vacc_Result->fixed_vacc_planned:0; ?>" type="text" style="height: 68px;"></td>
								<td><input class="form-control numberclass" name="fixed_vacc_held" id="fixed_vacc_held" value="<?php echo isset($vacc_Result)?$vacc_Result->fixed_vacc_held:0; ?>" type="text" style="height: 68px;"></td>
								<td><input class="form-control numberclass" name="or_vacc_planned" id="or_vacc_planned" value="<?php echo isset($vacc_Result)?$vacc_Result->or_vacc_planned:0; ?>" type="text" style="height: 68px;"></td>
								<td><input class="form-control numberclass" name="or_vacc_held" id="or_vacc_held" value="<?php echo isset($vacc_Result)?$vacc_Result->or_vacc_held:0; ?>" type="text" style="height: 68px;"></td>
								<!-- ======================================== -->
								<td><input class="form-control numberclass" name="mv_vacc_planned" id="mv_vacc_planned" value="<?php echo isset($vacc_Result)?$vacc_Result->mv_vacc_planned:0; ?>" type="text" style="height: 68px;"></td>
								<td><input class="form-control numberclass" name="mv_vacc_held" id="mv_vacc_held" value="<?php echo isset($vacc_Result)?$vacc_Result->mv_vacc_held:0; ?>" type="text" style="height: 68px;"></td>
								<!-- ========================================= -->
								<td><input class="form-control numberclass" name="hh_vacc_planned" id="hh_vacc_planned" value="<?php echo isset($vacc_Result)?$vacc_Result->hh_vacc_planned:0; ?>" type="text" style="height: 68px;"></td>
								<td><input class="form-control numberclass" name="hh_vacc_held" id="hh_vacc_held" value="<?php echo isset($vacc_Result)?$vacc_Result->hh_vacc_held:0; ?>" type="text" style="height: 68px;"></td>
							</tr>
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-12">
							<div class="pull-right">
								<input type="checkbox" id="outchkbox">Show Outside Columns
							</div>
						</div>
					</div>
					<div id="parent">
						<table id="fixTable" class="fixTable22 table table-bordered table-condensed table-striped table-hover mytable3">
							<thead>
								<tr>
									<th rowspan="6" style="width:14%;"><label>Product</label></th>
									<th rowspan="6"><label>#</label></th>
									<th colspan="73" class="mergedvaccinatedcells"><label>Vaccinated</label></th>
									<th rowspan="6" style=""><label class="rotateheaderlabels">Batch number</label></th>
									<th rowspan="6" style=""><label class="rotateheaderlabels">Doses Per Vial</label></th>
									<th rowspan="5"><label>Opening Balance</label></th>
									<th rowspan="5"><label>Received Stock</label></th>
									<th colspan="2" rowspan="5"><label>Used Stock</label></th>
									<th colspan="2" rowspan="5"><label>Unusable Stock</label></th>
									<!--<th colspan="3" rowspan="5"><label>Adjustment</label></th>-->
									<th colspan="2" rowspan="5"><label>Closing Balance</label></th>
								</tr>
								<tr>
									<th colspan="24" class="hidden14"><label>Number of Children Vaccinated (0-11 months)</label></th>
									<th colspan="24" class="hidden14"><label>Number of Children Vaccinated (12-23 months)</label></th>
									<th colspan="24" class="hidden14"><label>02 Years and above</label></th>
									<th rowspan="5" class="datasharing"><label>Data Sharing</label></th>
								</tr>
								<tr>
									<th colspan="6" class="hidden2"><label>Fixed</label></th>
									<th colspan="6" class="hidden4"><label>Outreach</label></th>
									<th colspan="6" class="hidden4"><label>Mobile</label></th>
									<th colspan="6" class="hidden4"><label>Health House</label></th>
									<th colspan="6" class="hidden2"><label>Fixed</label></th>
									<th colspan="6" class="hidden4"><label>Outreach</label></th>
									<th colspan="6" class="hidden4"><label>Mobile</label></th>
									<th colspan="6" class="hidden4"><label>Health House</label></th>
									<th colspan="6" class="hidden2"><label>Fixed</label></th>
									<th colspan="6" class="hidden4"><label>Outreach</label></th>
									<th colspan="6" class="hidden4"><label>Mobile</label></th>
									<th colspan="6" class="hidden4"><label>Health House</label></th>
								</tr>
								<tr class="text-center">
									<th colspan="2">Inside Uc</th>
									<th colspan="2">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2" class="outsidecol">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2" class="outsidecol">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2" class="outsidecol">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2" class="outsidecol">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2" class="outsidecol">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2" class="outsidecol">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2" class="outsidecol">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2" class="outsidecol">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
									<th colspan="2">Inside Uc</th>
									<th colspan="2" class="outsidecol">Outside Uc</th>
									<th colspan="2" class="outsidecol">Outside District</th>
								</tr>
								<tr class="text-center">
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th>M</th>
									<th>F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
									<th class="outsidecol">M</th>
									<th class="outsidecol">F</th>
								</tr>
								<tr>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>
									<th class="outsidecol">Nos.</th>									
									<th>Doses</th>
									<th>Doses</th>
									<th>Vials</th>
									<th>Doses</th>
									<th>Vials</th>
									<th>Doses</th>
									<th>Vials</th>
									<th>Doses</th>
									<!--<th style="width:1%">Action</th>
									<th>Vials</th>
									<th>Doses</th>-->
								</tr>
								<tr style="background: white none repeat scroll 0% 0%; color: black;">
									<th></th>
									<th></th>
									<th  style="color: White;" colspan="73" class="mergedvaccinatedcells">D</th>
									<th></th>
									<th style="color: White;">A</th>
									<th style="color: White;">B</th>
									<th style="color: White;">C</th>
									<th colspan="2"  style="color: White;">E</th>
									<th colspan="2"  style="color: White;">F</th>
									<!--<th></th>
									<th></th>
									<th></th>-->
									<th colspan="2"  style="color: White;">G</th>
								</tr>
							</thead>
							<tbody id="myTable" class="consumptionitems default">
								<tr class="text-center">
									<td colspan="86" class="mergedvaccinatedcells" style="font-size:20px">Please Select criteria from above section, Item(s) will be loaded automatically.</td>
								</tr>
							</tbody>
						</table>
					</div>
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
		<!--<form class="modalForm" id="modalForm-adjustment">-->
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
		<!--</form>-->
	</div>
</div>
<div class="modal fade" id="DataSharingModal" role="dialog" style="display: none;" onfocusin="resetstyle(this)">
	<div class="modal-dialog" style="width: auto;margin: 30px 35px;padding: 20px;">
		<!-- Modal content-->
		<form class="modalForm" id="modalForm-dataSharing">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-adjustment">Data Sharing (Out UC + Out District)</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-3">
							<label>Product</label>
						</div>
						<div class="col-md-3">
							<span id="ds-productname"></span>
						</div>
						<div class="col-md-3">
							<label>Antigen #</label>
						</div>
						<div class="col-md-3">
							<span id="ds-antigen"></span>
						</div>
					</div>
					<div class="row">
						<table id="datasharingtbl" class="fixTable22 table table-bordered table-condensed table-striped table-hover">
							<thead style="background:#008d4c;color:white;">
								<tr>
									<th rowspan="5"><label>District</label></th>
									<th rowspan="5"><label>Tehsil</label></th>
									<th rowspan="5"><label>UC</label></th>
									<th colspan="24"><label>Vaccinated Children</label></th>
									<th rowspan="5"><label>Action</label></th>
								</tr>
								<tr>
									<th colspan="8"><label>Number of Children Vaccinated (0-11 months)</label></th>
									<th colspan="8"><label>Number of Children Vaccinated (12-23 months)</label></th>
									<th colspan="8"><label>02 Years and above</label></th>
								</tr>
								<tr>
									<th colspan="2"><label>Fixed</label></th>
									<th colspan="2"><label>Outreach</label></th>
									<th colspan="2"><label>Mobile</label></th>
									<th colspan="2"><label>Health House</label></th>
									<th colspan="2"><label>Fixed</label></th>
									<th colspan="2"><label>Outreach</label></th>
									<th colspan="2"><label>Mobile</label></th>
									<th colspan="2"><label>Health House</label></th>
									<th colspan="2"><label>Fixed</label></th>
									<th colspan="2"><label>Outreach</label></th>
									<th colspan="2"><label>Mobile</label></th>
									<th colspan="2"><label>Health House</label></th>
								</tr>
								<tr class="text-center">
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
								</tr>
								<tr>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
								</tr>
							</thead>
							<tbody id="sharingdatatblebody" class="default">
								<tr class="text-center">
									<td>
										<select name="datasharing[distcode][]" class="district form-control">
											<?php if(isset($formB_Result)){ ?>
												<option value="<?php echo $formB_Result -> distcode; ?>"><?php echo get_District_Name($formB_Result -> distcode); ?></option>
											<?php }else{ getDistricts_options(false,$this -> session -> District,"Yes"); } ?>
										</select>
									</td>
									<td>
										<select name="datasharing[tcode][]" class="tehsil form-control">
											<?php if(isset($formB_Result)){ ?>
												<option value="<?php echo $formB_Result -> tcode; ?>"><?php echo get_Tehsil_Name($formB_Result -> tcode); ?></option>
											<?php }else{ ?> 
											<?php getTehsils_options(false); } ?>
										</select>
									</td>
									<td>
										<select name="datasharing[uncode][]" class="unioncouncil form-control">
											<?php if(isset($formB_Result)){ ?>
											<option value="<?php echo $formB_Result -> uncode; ?>"><?php echo get_UC_Name($formB_Result -> uncode); ?></option>
											<?php }else{ ?> 
											<?php getUCs_options(false); } ?>
										</select>
									</td>
									<?php
										$vaccinatedcells = $fmcells = array("fm1","ff1","om1","of1","mm1","mf1","hm1","hf1","fm2","ff2","om2","of2","mm2","mf2","hm2","hf2","fm3","ff3","om3","of3","mm3","mf3","hm3","hf3");
										if($fmcells!==""){
											$vaccinatedcell = "";
											foreach($fmcells as $key=>$value){
												$sectionclass = "";
												$vaccinatedcell .= '
													<td class="'.$sectionclass.' ">
														<input class="form-control numberclass childvacc " name="datasharing[vaccinated]['.$value.'][]" type="text">
													</td>';
											}
										}
										echo $vaccinatedcell;
									?>
									<td>
										<button type="button" class="btn btn-success btn-xs cloneadd" data-original-title="add new Batch"><i class="fa fa-plus"></i></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="row pt10">
						<div class="col-md-6" style="margin-left: 65%;">
							<button id="submitDataSharing" class="btn-background box1" type="button" data-dismiss="modal"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
							<button class="btn-background box1" type="button" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							<input type="hidden" id="clickedrownum" name="rownum" value="" />
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/alasql@0.6"></script>
<script type="text/javascript">
alasql("CREATE TABLE modalData (prodid string, antigen string, htmldata string)");
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
	//code by moon start here
	$(document).on('change','#facode,#month', function (){
		var facode = $("#facode").val();
		var month = $("#month").val();
		var year = $("#year").val(); 
		var table = 'epi_consumption_master';
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
										window.location.href = "<?php echo base_url(); ?>vaccination/edit/"+fmonth+"/"+facode;
									} else {
										window.location.reload(); 
									} 
								}else if(is_compiled=='1' && data_source=='app'){
									if (confirm("Report Already Exists! Do you want to view it?")==true) {
										window.location.href = "<?php echo base_url(); ?>vaccination/view/"+fmonth+"/"+facode;
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
															window.location.href = "<?php echo base_url(); ?>vaccination";
														}else{
															alert('Date Does not Compiled'); 
															window.location.href = "<?php echo base_url(); ?>vaccination";
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
							window.location.href = "<?php echo base_url(); ?>vaccination";
						} else {
							window.location.reload();
						} 
					}else{
						//validation about basic fields selected or not.------work remaining---- may be skipped as facode,fmonth checked above
						
						//check if table already shown or not
						var eraseAll = false;
						if($(".consumptionitems").hasClass("default")){
							eraseAll = true;
						}else{
							//table already shown confirm from user to refresh.
							eraseAll = confirm("Do you want to reset all items according to new Health Facility and purpose selection?\n It will erase your data.");
						}
						//Allow items data entry by showing items panel
						if(eraseAll){
							//uncheck "outside uc" & "outside district" options first
							/* if($("#outucchkbox").is(":checked")){
								$("#outucchkbox").prop("checked",false);
							}
							if($("#outdistchkbox").is(":checked")){
								$("#outdistchkbox").prop("checked",false);
							} */
							if($("#outchkbox").is(":checked")){
								$("#outchkbox").prop("checked",false);
							}
							$(".mergedvaccinatedcells").each(function(){
								$(this).attr("colspan",73);
							});
							
							
							//for 2 columns hidden class
							$(".hidden2,.hidden4").each(function(){
								$(this).attr("colspan",6);
							});
							//for 6 columns hidden class
							$(".hidden6,.hidden12").each(function(){
								$(this).attr("colspan",18);
							});
							//for 14 columns hidden class
							$(".hidden14").each(function(){
								$(this).attr("colspan",24);
							});
							//for TT section
							$(".mergedvaccinatedcellsTT").each(function(){
								$(this).attr("colspan",24);
							});
							
							
							//show loading in table...----- work remaining
							$.ajax({
								type: "post",
								data: {activity:1,fmonth:fmonth,facode:facode,edit:edit},//1 for routine
								url: "<?php echo base_url("vaccinationitems"); ?>",
								success: function(result){
									try {
										$(".consumptionitems").html(result);
										$(".consumptionitems").removeClass("default");
										//hide some cells which will be shown on request
										$(".outsideuc").hide();
										$(".outsidedist").hide();
										$("#fixTable").tableHeadFixer({'left' : 2, 'head' : true,'z-index' : 1});
										$("#outchkbox").trigger("change");
										//to disable all outuc and out ditrict field because data entry will be done from modal.
										$(".outuccol").find("input").attr("disabled","disabled");
										$(".outdistcol").find("input").attr("disabled","disabled");
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
			$.ajax({
				//alert(year);
				type: "POST",
				data: "facode="+facode+"&year="+year,
				url: "<?php echo base_url(); ?>Ajax_calls/getTargetChildern",
				success: function(result){
					var data = jQuery.parseJSON(result.trim());
				<?php //if(isset($edit) && $edit=='No') { ?>
					$('#tc_male').val(data.male);
					$('#tc_female').val(data.female);
					$('#pw_monthly_target').val(data.monthly_PregnantW);
				<?php //} ?>
				}
			});
			//here set cildren vaccinated against each product from vaccination if needed---------work remaining
			//set_children_vacc();
		}
	});
	//when edit then triggger it
	var edit=$('#edit').val();
	if(edit=="edit"){
		$('#facode').trigger('change');
	}
	function filluseddoses(prodid,objname,nametoreplace){
		//fill used in doses
		var rowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]');
		var dosesinvname = objname.replace("["+nametoreplace+"]","[doses]");
		var usedindname = objname.replace("["+nametoreplace+"]","[useddoses]");
		var usedval = parseInt($(rowobj).find('input[name="'+objname+'"]').val()) || 0;
		var dosesinvial = parseInt($(rowobj).find('input[name="'+dosesinvname+'"]').val()) || 1;
		var indoses = usedval*dosesinvial;
		$(rowobj).find('input[name="'+usedindname+'"][disabled="disabled"]').val(indoses);
	}
	function fillunuseddoses(prodid,objname,nametoreplace){
		//fill unused in doses
		var rowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]');
		var dosesinvname = objname.replace("["+nametoreplace+"]","[doses]");
		var unusedindname = objname.replace("["+nametoreplace+"]","[unuseddoses]");
		var unusedval = parseInt($(rowobj).find('input[name="'+objname+'"]').val()) || 0;
		var dosesinvial = parseInt($(rowobj).find('input[name="'+dosesinvname+'"]').val()) || 1;
		var indoses = unusedval*dosesinvial;
		$(rowobj).find('input[name="'+unusedindname+'"][disabled="disabled"]').val(indoses);
	}
	function fillusedvials(prodid,objname,nametoreplace){
		//fill unused in doses
		var rowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]');
		var dosesinvname = objname.replace("["+nametoreplace+"]","[doses]");
		var usedinvname = objname.replace("["+nametoreplace+"]","[usedvials]");
		var useddoses = parseInt($(rowobj).find('input[name="'+objname+'"]').val()) || 0;
		var dosesinvial = parseInt($(rowobj).find('input[name="'+dosesinvname+'"]').val()) || 1;
		var invials = (useddoses>0)?(useddoses/dosesinvial):0;
		$(rowobj).find('input[name="'+usedinvname+'"][disabled="disabled"]').val(invials);
	}
	function fillunusedvials(prodid,objname,nametoreplace){
		//fill unused in doses
		var rowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]');
		var dosesinvname = objname.replace("["+nametoreplace+"]","[doses]");
		var unusedinvname = objname.replace("["+nametoreplace+"]","[unusedvials]");
		var unuseddoses = parseInt($(rowobj).find('input[name="'+objname+'"]').val()) || 0;
		var dosesinvial = parseInt($(rowobj).find('input[name="'+dosesinvname+'"]').val()) || 1;
		var invials = (unuseddoses>0)?(unuseddoses/dosesinvial):0;
		$(rowobj).find('input[name="'+unusedinvname+'"][disabled="disabled"]').val(invials);
	}
	function getVaccinatedSum(prodid){
		var vaccinated = 0;
		//vaccinated
		$('.consumptionitems').find('input[name^="product[vaccinated]['+prodid+']"]').each(function()
		{
			if(!isNaN(this.value) && this.value.length!=0 && parseFloat(this.value)>0) 
			{
				vaccinated += parseFloat(this.value);            
			}
		});
		return vaccinated;
	}
	function getOpeningSum(prodid){
		var obdoses = 0;
		//ob
		$('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]').find('input[name*="[ob]"]').each(function()
		{
			if(!isNaN(this.value) && this.value.length!=0 && parseFloat(this.value)>0) 
			{
				obdoses += parseFloat(this.value);            
			}
		});
		return obdoses;
	}
	function getReceivedSum(prodid){
		var recdoses = 0;
		//received
		$('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]').find('input[name*="[received]"]').each(function()
		{
			if(!isNaN(this.value) && this.value.length!=0 && parseFloat(this.value)>0) 
			{
				recdoses += parseFloat(this.value);            
			}
		});
		return recdoses;
	}
	function getUsedSum(prodid){
		var useddoses = 0;
		//received
		$('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]').find('input[name*="[useddoses]"]').each(function()
		{
			if(!isNaN(this.value) && this.value.length!=0 && parseFloat(this.value)>0) 
			{
				useddoses += parseFloat(this.value);            
			}
		});
		return useddoses;
	}
	function getUnusedSum(prodid){
		var unuseddoses = 0;
		//received
		$('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]').find('input[name*="[unuseddoses]"]').each(function()
		{
			if(!isNaN(this.value) && this.value.length!=0 && parseFloat(this.value)>0) 
			{
				unuseddoses += parseFloat(this.value);            
			}
		});
		return unuseddoses;
	}
	function calculateBatchClosing(prodid,objname,nametoreplace){
		var currrowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]');
		var dosesinvname = objname.replace("["+nametoreplace+"]","[doses]");
		var obfieldname = objname.replace("["+nametoreplace+"]","[ob]");
		var recfieldname = objname.replace("["+nametoreplace+"]","[received]");
		var usedfieldname = objname.replace("["+nametoreplace+"]","[useddoses]");
		var unusedfieldname = objname.replace("["+nametoreplace+"]","[unuseddoses]");
		var closingdosesfieldname = objname.replace("["+nametoreplace+"]","[closingdoses]");
		var closingvialsfieldname = objname.replace("["+nametoreplace+"]","[closingvials]");
		var vaccinated = getVaccinatedSum(prodid);
		//calculate and fill closing balance in doses and vials
		var obdoses = parseInt($(currrowobj).find('input[name="'+obfieldname+'"]').val()) || 0;
		var recdoses = parseInt($(currrowobj).find('input[name="'+recfieldname+'"]').val()) || 0;
		var totalstock = obdoses+recdoses;
		var useddoses = parseInt($(currrowobj).find('input[name="'+usedfieldname+'"]').val()) || 0;
		var unuseddoses = parseInt($(currrowobj).find('input[name="'+unusedfieldname+'"]').val()) || 0;
		
		///var adjustdoses = parseInt($(currrowobj).find(".adjustind").val()) || 0;
		///var adjustnature = $(currrowobj).find(".input-group-addon").data("nature");
		var totalconsume = useddoses+unuseddoses;
		//var closingdoses = obdoses+recdoses-useddoses-unuseddoses;
		var closingdoses = obdoses+recdoses-totalconsume;
		/* if(adjustnature=="positive"){
			closingdoses = closingdoses+adjustdoses;
		}else if(adjustnature=="negative"){
			closingdoses = closingdoses-adjustdoses;
		} */
		if(closingdoses>=0){
			$(currrowobj).css("background-color","#FFF");
			//set closing balance and calculate closing vials
			$(currrowobj).find('input[name="'+closingdosesfieldname+'"]').val(closingdoses);
			var dosesinvial = parseInt($(currrowobj).find('input[name="'+dosesinvname+'"]').val()) || 1;
			var closingvials = closingdoses/dosesinvial;
			$(currrowobj).find('input[name="'+closingvialsfieldname+'"]').val(closingvials);
			//enable adjustment button.
			///$(currrowobj).find(".adjustadd").removeAttr("disabled");
			
			/* if(vaccinated>0 && vaccinated>totalconsume){
				$(currrowobj).css("background-color","#F54F4F");
				alert("Total Doses Consumed cannot be less than total Children Vaccinated / Doses Administered");
				return false;
			}else{ */
				return true;
			//}
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
	function calculateclosing(prodid){
		var currrowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]');
		
		//first call to batch closing function one by one then check row closing and show error if exist
		/* $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]')
		var currrowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"]');
		var dosesinvname = objname.replace("["+nametoreplace+"]","[doses]");
		var obfieldname = objname.replace("["+nametoreplace+"]","[ob]");
		var recfieldname = objname.replace("["+nametoreplace+"]","[received]");
		var usedfieldname = objname.replace("["+nametoreplace+"]","[useddoses]");
		var unusedfieldname = objname.replace("["+nametoreplace+"]","[unuseddoses]");
		var closingdosesfieldname = objname.replace("["+nametoreplace+"]","[closingdoses]");
		var closingvialsfieldname = objname.replace("["+nametoreplace+"]","[closingvials]"); */
		var vaccinated = getVaccinatedSum(prodid);
		var obdoses = getOpeningSum(prodid);
		var recdoses = getReceivedSum(prodid);
		var useddoses = getUsedSum(prodid);
		var unuseddoses = getUnusedSum(prodid);
		//calculate and fill closing balance in doses and vials
		var totalstock = obdoses+recdoses;
		///var adjustdoses = parseInt($(currrowobj).find(".adjustind").val()) || 0;
		///var adjustnature = $(currrowobj).find(".input-group-addon").data("nature");
		var totalconsume = useddoses+unuseddoses;
		//var closingdoses = obdoses+recdoses-useddoses-unuseddoses;
		var closingdoses = totalstock-totalconsume;
		/* if(adjustnature=="positive"){
			closingdoses = closingdoses+adjustdoses;
		}else if(adjustnature=="negative"){
			closingdoses = closingdoses-adjustdoses;
		} */
		if(closingdoses>=0){			
			$(currrowobj).css("background-color","#FFF");
			//$(currrowobj).find(".closinginv").val(closingvials);
			//enable adjustment button.
			///$(currrowobj).find(".adjustadd").removeAttr("disabled");
			if(vaccinated>0){
				if(vaccinated>useddoses){
					//Error
					$(currrowobj).css("background-color","#F54F4F");
					alert("Total Doses Consumed (Used Doses) cannot be less than total Vaccinated / Doses Administered");
					return false;
				}
				return true;
				
				/* if(vaccinated>totalconsume){
				}
				$(currrowobj).css("background-color","#F54F4F");
				alert("Total Doses Consumed cannot be less than total Children Vaccinated / Doses Administered");
				return false; */
			}else if(vaccinated==0){
				return true;
			}else{
				$(currrowobj).css("background-color","#F54F4F");
				alert("Vaccinated counts cannot be less than Zero");
				return false;
			}
		}/* else{
			//there is some error in balance, it can't be in minus
			$(currrowobj).css("background-color","#F54F4F");
			if(totalconsume > totalstock){
				alert("Used+Unused Doses/Vails cannot be greater than received+Opening balance");
				return false;
			}
			alert("Used+Unused and adjusted Doses/Vails cannot be greater than received+Opening balance");
			return false;
		} */
	}
	$(document).on('change','.childvacc',function(){
		var prodid = $(this).data("prodgroup");
		var vaccinated = getVaccinatedSum(prodid);
		var obdoses = getOpeningSum(prodid);
		var recdoses = getReceivedSum(prodid);
		var totalstock = parseFloat(parseFloat(obdoses)+parseFloat(recdoses));
		if(vaccinated>0 && vaccinated>totalstock){
			$(this).css("background-color","#F54F4F");
			alert("Number of Children Vaccinated cannot be greater than total Available stock in doses.");
		}else{
			$(this).css("background-color","#FFF");
		}
	});
	$(document).on('change','.usedinv',function(){
		var prodid = $(this).closest("tr").data("prodrow");
		filluseddoses(prodid,$(this).attr("name"),"usedvials");
		calculateBatchClosing(prodid,$(this).attr("name"),"usedvials");
	});
	$(document).on('change','.unusedinv',function(){
		var prodid = $(this).closest("tr").data("prodrow");
		fillunuseddoses(prodid,$(this).attr("name"),"unusedvials");
		calculateBatchClosing(prodid,$(this).attr("name"),"unusedvials");
	});
	$(document).on('change','.usedind',function(){
		var prodid = $(this).closest("tr").data("prodrow");
		fillusedvials(prodid,$(this).attr("name"),"useddoses");
		calculateBatchClosing(prodid,$(this).attr("name"),"useddoses");
	});
	$(document).on('change','.unusedind',function(){
		var prodid = $(this).closest("tr").data("prodrow");
		fillunusedvials(prodid,$(this).attr("name"),"unuseddoses");
		calculateBatchClosing(prodid,$(this).attr("name"),"unuseddoses");
	});
	function enablesavedisableentry(){
		$( "#vacc_cr_form input:enabled, #vacc_cr_form select:enabled, .adjustadd:enabled" ).each(function(){
			if($(this).attr("id")!=="accepted"){
				$(this).addClass("moontempdisabled");
				$(this).attr("disabled","disabled");
			}
		});
		$("#savebtn").removeAttr("disabled");				
	}
	function disablesaveenableentry(){
		$( "#vacc_cr_form" ).find(".moontempdisabled").each(function(){
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
				$(".usedind").each(function(){
					var itsValue = parseInt($(this).val());
					if(itsValue > 0){						
					}else{
						$(this).val("0");
					}
					//calculate batch closing for all batches
					var prodid = $(this).closest("tr").data("prodrow");
					fillusedvials(prodid,$(this).attr("name"),"useddoses");
					validated = calculateBatchClosing(prodid,$(this).attr("name"),"useddoses");
					if(validated){}else{return false;}
				});
				if(validated){
					//now batch validated so move on each row and validate used Vs Vaccinated
					var lastprod = "";
					$(".onebatch").each(function(){
						var prodid = $(this).data("prodrow");
						if(prodid==lastprod){
							//do nothing just continue
						}else{
							//first row of product call to calculate closing fun
							validated = calculateclosing(prodid);
							if(validated){}else{return false;}
						}
						lastprod = prodid;
					});
				}
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
		$( "#vacc_cr_form input:disabled, #vacc_cr_form select:disabled" ).each(function(){			
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
	$(document).on('click','.sharedata',function(){
		var prodid = $(this).closest("tr").data("prodrow");
		var name = $(".cst-item-row[data-prodrow="+prodid+"]").find(".itemname").text();
		var antigen = $(this).closest("tr").find(".vaccnum").text();
		
		var oldprodname = $("#ds-productname").text();		
		var oldantigen = $("#ds-antigen").text();
		
		if(oldprodname==name && oldantigen==antigen){
			//same row clicked
		}else{
			//other row clicked
			//check if data exist in memory
			var res = alasql("SELECT * FROM modalData WHERE prodid = '"+prodid+"' and antigen = '"+antigen+"'");			console.log(res);
			if(res === undefined || res.length == 0){
				$("#sharingdatatblebody tr").each(function(ind,val){
					if(ind>0){
						$(this).remove();
					}else{
						//$(this).find(':input').val('');
						//$(this).find('.unioncouncil option').attr('selected', false);
						//$(this).find('.tehsil option').attr('selected', false);
					}
				});
			}else{
				$("#sharingdatatblebody").html($.parseHTML(res[0].htmldata));
			}
		}
		$("#ds-productname").text(name);
		$("#ds-antigen").text(antigen);
		$("#clickedrownum").val((parseInt($(this).closest("tr").index()) || 0)+1);
	});
	
	$(document).on('paste','#quantitymodal',function(e){
		e.preventDefault();
	});
	$(document).on('change','#outchkbox',function(e){
		if($(this).is(":checked")){
			//checked
			$(".outsidecol,.outsidecolTT").removeClass("hide");
			$(".mergedvaccinatedcells").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+42;
				$(this).attr("colspan",newval);
			});
			//for 2 columns hidden class
			$(".hidden2").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+2;
				$(this).attr("colspan",newval);
			});
			//for 4 columns hidden class
			$(".hidden4").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+4;
				$(this).attr("colspan",newval);
			});
			//for 6 columns hidden class
			$(".hidden6").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+6;
				$(this).attr("colspan",newval);
			});
			//for 12 columns hidden class
			$(".hidden12").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+12;
				$(this).attr("colspan",newval);
			});
			//for 14 columns hidden class
			$(".hidden14").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+14;
				$(this).attr("colspan",newval);
			});
			//for TT section
			$(".mergedvaccinatedcellsTT").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+8;
				$(this).attr("colspan",newval);
			});
		}else{
			//unchecked
			//alert($(".outsidecol").addClass("hide"));
			$(".outsidecol,.outsidecolTT").addClass("hide");
			$(".mergedvaccinatedcells").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-42;
				$(this).attr("colspan",newval);
			});
			//for 2 columns hidden class
			$(".hidden2").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-2;
				$(this).attr("colspan",newval);
			});
			//for 4 columns hidden class
			$(".hidden4").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-4;
				$(this).attr("colspan",newval);
			});
			//for 6 columns hidden class
			$(".hidden6").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-6;
				$(this).attr("colspan",newval);
			});
			//for 12 columns hidden class
			$(".hidden12").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-12;
				$(this).attr("colspan",newval);
			});
			//for 14 columns hidden class
			$(".hidden14").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-14;
				$(this).attr("colspan",newval);
			});
			//for TT section
			$(".mergedvaccinatedcellsTT").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-8;
				$(this).attr("colspan",newval);
			});
		}
	});
	$(document).on('click','.cloneadd',function(){
		//check if quantity is filled in this row and batch etc are selected, and more than one batch of same product exists.
		//var quantityincurrrow = $(this).closest("tr").find(".quantity").val();
		//var batchincurrrow = $(this).closest("tr").find(".batch").find("option:selected").val();
		//var batchesofprod = $(this).closest("tr").find(".batch").find("option").length;
		//if(quantityincurrrow>0 && batchincurrrow>0 && batchesofprod>0){
			var clonedhtml = $(this).closest("tr").clone();
			/* $(clonedhtml).find("td:first-child").find(".prodtitle").html("");
			$(clonedhtml).find(".requiredcard").html("");
			$(clonedhtml).find(".diststoreavail").html("");
			$(clonedhtml).find(".facstoreavail").html("");
			$(clonedhtml).find(".requestcard").html("");
			$(clonedhtml).find(".quantity").val(""); */
			$(clonedhtml).find("td:last-child").html('<button type="button" class="btn btn-danger btn-xs clonedel" data-original-title="Delete this Batch"><i class="fa fa-minus"></i></button>');
			$(this).closest("tr").after(clonedhtml);
		//}else{
			//alert("You can only clone row for second batch entry, either you have not filled required fields in current row or you have only 1 batch of current product available so you cannot clone row.");
		//}	
	});
	$(document).on('click','.clonedel',function(){
		//check if quantity is filled in this row and batch etc are selected.
		//var quantityincurrrow = $(this).closest("tr").find(".quantity").val();
		//var batchincurrrow = $(this).closest("tr").find(".batch").find("option:selected").val();
		//if(quantityincurrrow>0 && batchincurrrow>0){
			//confirm before deletion
			var confirmdel = confirm("This will delete current row, Do you really want to remove it?");
			if(confirmdel){
				$(this).closest("tr").remove();
			}
		//}else{
			//just delete row without confirmation
			//$(this).closest("tr").remove();
		//}
	});
});
	
$(document).on('change','.district', function(){
	var obj = $(this);
	var distcode = $(this).val();
	//to get tehsils of selected distcrict
	if($(this).closest('tr').find(".tehsil").length == 0) {
	  //it doesn't exist
	}else{
		$.ajax({
			type: "POST",
			data: "distcode="+distcode,
			url: "<?php echo base_url("Ajax_calls/getTehsils"); ?>",
			success: function(result){
				obj.closest('tr').find('.tehsil').html(result);
				obj.closest('tr').find('.tehsil').trigger('change');
			}
		});
	}
						
});	
$(document).on('change','.tehsil', function(){
	var obj = $(this);
	var tcode = $(this).val();
	//to get unioncouncis of selected tehsil
	if($(this).closest('tr').find(".unioncouncil").length == 0) {
	  //it doesn't exist
	}else{
		$.ajax({
			type: "POST",
			url: '<?php echo base_url("Ajax_calls/getUnC/'+tcode+'"); ?>', //"http://epibeta.pacemis.com/Ajax_calls/getTehsils",
			success: function(result){
				obj.closest('tr').find('.unioncouncil').html(result);
				//obj.closest('tr').find('.unioncouncil').trigger('change');
			}
		});
	}
						
});
$(document).on('click','#submitDataSharing',function(){
	//get modal values and set in row fields, based on out uc and out district.
	var clickedrow = $("#clickedrownum").val();
	var rowobj = $(".consumptionitems tr:nth-child("+clickedrow+")");
	console.log(clickedrow);
	var fmcells = ["fm1","ff1","om1","of1","mm1","mf1","hm1","hf1","fm2","ff2","om2","of2","mm2","mf2","hm2","hf2","fm3","ff3","om3","of3","mm3","mf3","hm3","hf3"];
	var sessiondist = '<?php echo $this -> session -> District; ?>';
	console.log(sessiondist);
	$(".district").each(function(d,val){
		var distobj = $(this);
		var currdist = distobj.val();
		console.log(distobj);
		$.each( fmcells, function( i, val ) {
			var fieldval = $(distobj).closest("tr").find('input[name^="datasharing[vaccinated]['+val+']"]').val();
			console.log(fieldval);
			if(sessiondist==currdist){
				//out UC
				var prevval = $(rowobj).find('input[name$="[ou'+val+']"]').val();
				$(rowobj).find('input[name$="[ou'+val+']"]').val((d==0)?fieldval:(parseInt(prevval) || 0)+(parseInt(fieldval) || 0));
			}else{
				//out Dist
				var prevval = $(rowobj).find('input[name$="[od'+val+']"]').val();
				$(rowobj).find('input[name$="[od'+val+']"]').val((d==0)?fieldval:(parseInt(prevval) || 0)+(parseInt(fieldval) || 0));
			}
		});
	});
	//code here to sava data into new tables
	var facode = $("#facode").val();
	var month = $("#month").val();
	var year = $("#year").val();
	var item_id = $(rowobj).data("prodrow");
	var antigen = $("#ds-antigen").text();
	$.ajax({
		type: "post",
		data: $("#modalForm-dataSharing").serialize()+"&year="+year+"&month="+month+"&facode="+facode+"&item_id="+item_id+"&antigen="+antigen,
		url: '<?php echo base_url("vaccination/saveDataShare"); ?>',
		success: function(result){
			console.log(result);
		}
	});
	//store into local db
	var modalhtml = $("#sharingdatatblebody").html();
	alasql("INSERT INTO modalData VALUES ('"+item_id+"','"+antigen+"','"+modalhtml+"')");
});
$("#sharingdatatblebody .childvacc").on("change",function(){
	var distcode = $(this).closest("tr").find(".district").val();
	var tcode = $(this).closest("tr").find(".tehsil").val();
	var uncode = $(this).closest("tr").find(".unioncouncil").val();
	if(parseInt(distcode)>0 && parseInt(tcode)>0 && parseInt(uncode)>0){}else{
		$(this).val(0);
		alert("Please select District, Tehsil and Union Council first.");
	}
});
function resetstyle(reff){
	reff.style.paddingRight = "unset";
}
//
</script>