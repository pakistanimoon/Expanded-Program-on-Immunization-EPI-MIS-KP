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
							<!--<td><label>Health Facility Code</label></td>
							<td><input type="text" id="hfcode" name="hfcode" readonly="readonly" value="" class="form-control"></td>-->
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
					<div id="datasharigdiv">
						<table id="datasharigtbl" class="fixTable22 table table-bordered table-condensed table-striped table-hover mytable3">
							<thead>
								<tr>
									<th colspan="5"><label>OUT UC DATA</label></th>
									<th><a id="datasharigbtn" href="#" class="submit btn-default btn-sm datasharigbtn" data-toggle="modal" data-target="#DataSharingModal" style="padding:3px 10px;"><i class="fa fa-plus"></i>Add New</a></th>
								</tr>
								<tr>
									<th><label>Country</label></th>
									<th><label>Province</label></th>
									<th><label>District</label></th>
									<th><label>Tehsil</label></th>
									<th><label>Union Council</label></th>
									<th><label>Action</label></th>
								</tr>
							</thead>
							<tbody id="datasharigbody" class="default">
								<tr class="text-center defaultrow">
									<td colspan="6" style="font-size:20px">Please Click on Add New button to enter out uc data</td>
								</tr>
							</tbody>
						</table>
					</div>
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
									<th colspan="78" class="mergedvaccinatedcells"><label>Vaccinated</label></th>
									<th rowspan="6" style=""><label class="rotateheaderlabels">Batch number</label></th>
									<th rowspan="6" style=""><label class="rotateheaderlabels">Doses Per Vial</label></th>
									<th rowspan="5"><label>Opening Balance</label></th>
									<th rowspan="5"><label>Received Stock</label></th>
									<th colspan="2" rowspan="5"><label>Used Stock</label></th>
									<th colspan="2" rowspan="5"><label>Unusable Stock</label></th>
																																																										
									<th colspan="2" rowspan="5"><label>Closing Balance</label></th>
								</tr>
								<tr>
									<th colspan="26" class="hidden14"><label>Number of Children Vaccinated (0-11 months)</label></th>
									<th colspan="26" class="hidden14"><label>Number of Children Vaccinated (12-23 months)</label></th>
									<th colspan="26" class="hidden14"><label>02 Years and above</label></th>
								</tr>
								<tr>
									<th colspan="6" class="hidden2"><label>Fixed</label></th>
									<th colspan="6" class="hidden4"><label>Outreach</label></th>
									<th colspan="6" class="hidden4"><label>Mobile</label></th>
									<th colspan="6" class="hidden4"><label>Health House</label></th>
									<th rowspan="4" class="hidden8"><label>Total Defaulter</label></th>
									<th rowspan="4" class="hidden8"><label>Defaulter Covered</label></th>
									<th colspan="6" class="hidden2"><label>Fixed</label></th>
									<th colspan="6" class="hidden4"><label>Outreach</label></th>
									<th colspan="6" class="hidden4"><label>Mobile</label></th>
									<th colspan="6" class="hidden4"><label>Health House</label></th>
									<th rowspan="4" class="hidden8"><label>Total Defaulter</label></th>
									<th rowspan="4" class="hidden8"><label>Defaulter Covered</label></th>
									<th colspan="6" class="hidden2"><label>Fixed</label></th>
									<th colspan="6" class="hidden4"><label>Outreach</label></th>
									<th colspan="6" class="hidden4"><label>Mobile</label></th>
									<th colspan="6" class="hidden4"><label>Health House</label></th>
									<th rowspan="4" class="hidden8"><label>Total Defaulter</label></th>
									<th rowspan="4" class="hidden8"><label>Defaulter Covered</label></th>
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
								</tr>
								<tr style="background: white none repeat scroll 0% 0%; color: black;">
									<th></th>
									<th></th>
									<th  style="color: White;" colspan="78" class="mergedvaccinatedcells">D</th>
									<th></th>
									<th style="color: White;">A</th>
									<th style="color: White;">B</th>
									<th style="color: White;">C</th>
				  
																																																																						
									<th colspan="2"  style="color: White;">E</th>
									<th colspan="2"  style="color: White;">F</th>
					  
				  
					 
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
<div class="modal fade" id="DataSharingModal" role="dialog" style="display: none;" onfocusin="resetstyle(this)">
	<div class="modal-dialog" style="width: auto;margin: 30px 35px;padding: 20px;">
		<!-- Modal content-->
		<form class="modalForm" id="modalForm-dataSharing">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-adjustment">Data Sharing (Out UC / Out District)</h4>
				</div>
				<div class="modal-body">
					<div class="row pb15">
						<div class="col-md-1"></div>
						<div class="col-md-2">
							<select name="datasharingcountry"  class="countrycode form-control">
								<option value="93">Afghanistan</option>
								<option value="86">China</option>
								<option value="91">India</option>
								<option value="90">Iran</option>
								<option value="92" selected>Pakistan</option>
							</select>
						</div>
						<div class="col-md-2">
							<select name="datasharingprocode"   class="procode form-control">
								<?php getProvinces_options(false); ?>
							</select>
						</div>
						<div class="col-md-2">
							<select name="datasharingdistcode"  class="district form-control">
								<option selected="selected" value="">--Select District--</option>
								<?php getDistricts_options(false,NULL,'Yes'); ?>
							</select>
						</div>
						<div class="col-md-2">
							<select name="datasharingtcode" class="tehsil form-control">
								<?php getTehsils_options(false); ?>
							</select>
						</div>
						<div class="col-md-2">
							<select name="datasharinguncode" class="unioncouncil form-control">
								<?php getUCs_options(false); ?>
							</select>
						</div>
						<div class="col-md-1"></div>
					</div>
					<div class="row">
						<table id="datasharingtbl" class="fixTable22 table table-bordered table-condensed table-striped table-hover">
							<thead style="background:#008d4c;color:white;">
								<tr>
									<th rowspan="5"><label>Product</label></th>
									<th rowspan="5"><label>Antigen</label></th>
									<th colspan="24"><label>Vaccinated Children</label></th>
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
								<?php
									$fmcells = array("fm1","ff1","om1","of1","mm1","mf1","hm1","hf1","fm2","ff2","om2","of2","mm2","mf2","hm2","hf2","fm3","ff3","om3","of3","mm3","mf3","hm3","hf3");
									if($fmcells!==""){
										$vaccinatedcellhtml = '<tr class="text-center modaldatasharingrow" data-productid=""><td class="prodname">Product Name</td><td class="antigennum">Antigen</td>';
										foreach($fmcells as $key=>$value){
											$sectionclass = "";
											$vaccinatedcellhtml .= '
												<td class="'.$sectionclass.' ">
													<input class="form-control numberclass childvacc " name="datasharing[vaccinated]['.$value.'][]" type="text">
												</td>';
										}
										$vaccinatedcellhtml .= "</tr>";
									}
									$ttheader = '<tr class="text-center" style="background:#008d4c;color:white;">
										<th rowspan="4"><label>Product</label></th>
										<th rowspan="4"><label>Antigen</label></th>
										<th colspan="24"><label>Vaccinated Women</label></th>
									</tr>
									<tr class="text-center" style="background:#008d4c;color:white;">
										<th colspan="6"><label>Fixed</label></th>
										<th colspan="6"><label>Outreach</label></th>
										<th colspan="6"><label>Mobile</label></th>
										<th colspan="6"><label>Health House</label></th>
									</tr>
									<tr class="text-center" style="background:#008d4c;color:white;">
										<th colspan="3">Pregnant Women</th>
										<th colspan="3">Non-Pregnant</th>
										<th colspan="3">Pregnant Women</th>
										<th colspan="3">Non-Pregnant</th>
										<th colspan="3">Pregnant Women</th>
										<th colspan="3">Non-Pregnant</th>
										<th colspan="3">Pregnant Women</th>
										<th colspan="3">Non-Pregnant</th>
									</tr>
									<tr class="text-center" style="background:#008d4c;color:white;">
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
									</tr>';
									$fmcells = array("fp","fnp","op","onp","mp","mnp","hp","hnp");
									$ttvaccinatedcellhtml = '<tr class="text-center modaldatasharingrow" data-productid=""><td class="prodname">Product Name</td><td class="antigennum">Antigen</td>';										
									foreach($fmcells as $key=>$value){
										$ttvaccinatedcellhtml .= '
											<td colspan="3">
												<input class="form-control numberclass childvacc " name="datasharing[vaccinated]['.$value.'][]" type="text">
											</td>';
									}
									$ttvaccinatedcellhtml .= '</tr>';
								?>
							</tbody>
						</table>
					</div>
					<div class="row">
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
<div class="modal fade" id="TTDataSharingModal" role="dialog" style="display: none;" onfocusin="resetstyle(this)">
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
									<th rowspan="4"><label>Country</label></th>
									<th rowspan="4"><label>Province</label></th>
									<th rowspan="4"><label>District</label></th>
									<th rowspan="4"><label>Tehsil</label></th>
									<th rowspan="4"><label>UC</label></th>
									<th colspan="8"><label>Vaccinated Women</label></th>
									<th rowspan="4"><label>Action</label></th>
								</tr>
								<tr>
									<th colspan="2"><label>Fixed</label></th>
									<th colspan="2"><label>Outreach</label></th>
									<th colspan="2"><label>Mobile</label></th>
									<th colspan="2"><label>Health House</label></th>
								</tr>
								<tr class="text-center">
									<th>Pregnant Women</th>
									<th>Non-Pregnant</th>
									<th>Pregnant Women</th>
									<th>Non-Pregnant</th>
									<th>Pregnant Women</th>
									<th>Non-Pregnant</th>
									<th>Pregnant Women</th>
									<th>Non-Pregnant</th>
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
								</tr>
							</thead>
							<tbody id="sharingdatatblebody" class="default">
								<tr class="text-center">
									<td>
										<select name="datasharing[countrycode][]"  class="countrycode form-control">
											<option value="93">Afghanistan</option>
											<option value="86">China</option>
											<option value="90">Iran</option>
											<option value="91">India</option>
											<option value="92" selected>Pakistan</option>
										</select>
									</td>
									<td>
										<select name="datasharing[procode][]"  class="procode form-control">
											<?php getProvinces_options(false); ?>
										</select>
									</td>
									<td>
										<select name="datasharing[distcode][]" class="district form-control">
											<option selected="selected" value="">--Select--</option>
											<?php getDistricts_options(false,NULL,'Yes'); ?>
										</select>
									</td>
									<td>
										<select name="datasharing[tcode][]" class="tehsil form-control">
											<?php getTehsils_options(false); ?>
										</select>
									</td>
									<td>
										<select name="datasharing[uncode][]"  class="unioncouncil form-control">
											<?php getUCs_options(false); ?>
										</select>
									</td>
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
																												  
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/alasql@0.6"></script>
<script type="text/javascript">
alasql("CREATE TABLE defaultmodalData (pkid string, htmldata string)");
//alasql("CREATE TABLE modaldataSharing (facode integer, countrycode integer,uncode integer,fmonth integer,item_id integer,antigen integer,fieldname string,fieldval integer)");
var modalhtmlobj = {};
var selectedmodalcountrycode = '';
var selectedmodalprocode = '';
var selectedmodaldistcode = '';
var selectedmodaltcode = '';
var selectedmodaluncode = '';

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
								$(this).attr("colspan",78);
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
								$(this).attr("colspan",26);
							});
							//for TT section
							$(".mergedvaccinatedcellsTT").each(function(){
								$(this).attr("colspan",26);
							});
							//for Defaulter section
							$(".hidden8").each(function(){
								$(this).attr("rowspan",4);
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
										//fetch all product names & ids & antigen & append in modal
										var fullyimmunizedappended = false;
										var rowhtml = '<?php echo preg_replace("/\s\s+/", "", $vaccinatedcellhtml ); ?>';
										$(".onebatch").each(function(){
											//check if row is disabled for vaccinated record entry
											if($(this).find('.mergedvaccinatedcells').length > 0){}else{
												var prodid = $(this).data("prodrow");
												var prodrowindex = $(this).data("prodrowindex");
												if(prodid==6){
													if(!fullyimmunizedappended){
														/* $("#sharingdatatblebody").append(rowhtml);
														$("#sharingdatatblebody tr:last-child").attr("data-productid","9999");
														$("#sharingdatatblebody tr:last-child").attr("data-antigen","");
														$("#sharingdatatblebody tr:last-child").attr("data-prodrowindex","0");
														$("#sharingdatatblebody tr:last-child").find(".prodname").html("<label>Fully Immunized</label>");
														$("#sharingdatatblebody tr:last-child").find(".antigennum").text(""); */
														fullyimmunizedappended = true;
														//TT header
														var ttheaderhtml = '<?php echo preg_replace("/\s\s+/", "", $ttheader ); ?>';
														$("#sharingdatatblebody").append(ttheaderhtml);
													}
													rowhtml = '<?php echo preg_replace("/\s\s+/", "", $ttvaccinatedcellhtml ); ?>';
												}
												var name = $(".cst-item-row[data-prodrow="+prodid+"]").find(".itemname").text();
												var antigen = $(this).find(".vaccnum").text();
												$("#sharingdatatblebody").append(rowhtml);
												$("#sharingdatatblebody tr:last-child").attr("data-productid",prodid);
												$("#sharingdatatblebody tr:last-child").attr("data-antigen",antigen);
												$("#sharingdatatblebody tr:last-child").attr("data-prodrowindex",prodrowindex);
												$("#sharingdatatblebody tr:last-child").find(".prodname").html("<label>"+name+"</label>");
												$("#sharingdatatblebody tr:last-child").find(".antigennum").text(antigen);
											}
										});
										if(!fullyimmunizedappended){
											/* $("#sharingdatatblebody").append(rowhtml);
											$("#sharingdatatblebody tr:last-child").attr("data-productid","9999");
											$("#sharingdatatblebody tr:last-child").attr("data-antigen","");
											$("#sharingdatatblebody tr:last-child").attr("data-prodrowindex","0");
											$("#sharingdatatblebody tr:last-child").find(".prodname").html("<label>Fully Immunized</label>");
											$("#sharingdatatblebody tr:last-child").find(".antigennum").text(""); */
										}
										var modaldefaulthtml = $("#DataSharingModal").find("#sharingdatatblebody").html();
										alasql("INSERT INTO defaultmodalData VALUES ('moon','"+modaldefaulthtml+"')");
									} catch(error) {
										alert("Some Error in data fetching!!");
									}
								}
							});
							if(edit=="1"){
								//fetch uc rows for edit data sharing
								$.ajax({
									type: "post",
									data: {fmonth:fmonth,facode:facode},//1 for routine
									url: "<?php echo base_url("fetchDataShareUcs"); ?>",
									success: function(result){
										$("#datasharigbody").find(".defaultrow").remove();
										//code here to append row in table
										$("#datasharigbody").append(result);
									}
								});
							}
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
			if(!isNaN(this.value) && this.value.length!=0 && parseFloat(this.value)>0 && this.className!='form-control numberclass dotcounttd' && this.className!='form-control numberclass dotcountdc')  
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
	//new checks for defaulter and total defaulter
	function getinputvaccinatedSum(prodid,prodrowindex,lastval,defaultercover){
		var vaccinated = 0;
		var rowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"][data-prodrowindex="'+prodrowindex+'"]')
		$(rowobj).find('input[name$="'+lastval+'"]').each(function()
		{
			if(!isNaN(this.value) && this.value.length!=0 && parseFloat(this.value)>0 && this.className!='form-control numberclass dotcounttd' && this.className!='form-control numberclass dotcountdc')   
			{
				vaccinated += parseFloat(this.value);            
			}
		});  
		//return vaccinated;
		if(!(defaultercover > vaccinated)){ 
			$(rowobj).find('input[name$="'+lastval+'"]').css("background-color","#F54F4F");
			alert("Defaulter Cover cannot be greater than total Vaccinated.");
			return false;
		}else{
			$(rowobj).find('input[name$="'+lastval+'"]').css("background-color","#FFF");
			return true;
		} 
	}
	function calculatetotaldefaulter(prodid,prodrowindex,lastval,defaultercover,totaldefaulter){
		var rowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"][data-prodrowindex="'+prodrowindex+'"]')
		if(!(defaultercover > totaldefaulter)){
			$(rowobj).find('input[name$="'+lastval+'"]').css("background-color","#F54F4F");
			alert("Defaulter Cover cannot be greater than Total Defaulter.");
			return false;
		}else{
			$(rowobj).find('input[name$="'+lastval+'"]').css("background-color","#FFF");
			return true;
		} 
	}
	$(document).on('change','.dotcounttd',function(){
		var totaldefaulter = $(this).val();
		var defaultercover = $(this).closest('td').next().find('.dotcountdc').val();
		var prodid = $(this).data("prodgroup");
		var prodrowindex = $(this).closest('tr').data("prodrowindex");
		var attr_totaldefaulter = $(this).attr('name');
		var lastval = attr_totaldefaulter.slice(-2);
		calculatetotaldefaulter(prodid,prodrowindex,lastval,defaultercover,totaldefaulter); 
		/* if(!(defaultercover > totaldefaulter)){
			$(this).css("background-color","#F54F4F");
			alert("Defaulter Cover cannot be greater than Total Defaulter.");
		}else{
			$(this).css("background-color","#FFF");
		} */ 
	}); 
	$(document).on('change','.dotcountdc',function(){
		var defaultercover = $(this).val();
		var prodid = $(this).data("prodgroup");
		var prodrowindex = $(this).closest('tr').data("prodrowindex");
		var attr_defaultercover = $(this).attr('name');
		var lastval = attr_defaultercover.slice(-2);
		getinputvaccinatedSum(prodid,prodrowindex,lastval,defaultercover); 
		/* var vaccinated = getinputvaccinatedSum(prodid,prodrowindex,lastval); 
		if(!(defaultercover > vaccinated)){
			$(this).css("background-color","#F54F4F");
			alert("Defaulter Cover cannot be greater than total Vaccinated.");
		}else{
			$(this).css("background-color","#FFF");
		}  */
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
		$(".edit_outucdata").css("pointer-events", "none");	
		$(".delete_outucdata").css("pointer-events", "none");	
		$(".datasharigbtn").css("pointer-events", "none");
	}
	function disablesaveenableentry(){
		$( "#vacc_cr_form" ).find(".moontempdisabled").each(function(){
			if($(this).attr("id")!=="accepted"){
				$(this).removeClass("moontempdisabled");
				$(this).removeAttr("disabled");
			}
		});
		$("#savebtn").attr("disabled","disabled");
		$('.edit_outucdata').removeAttr('style');
		$('.delete_outucdata').removeAttr('style');
		$('.datasharigbtn').removeAttr('style');
		
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
						var prodrowindex = $(this).data("prodrowindex");
						if(prodid==lastprod){
							//do nothing just continue
						}else{
							//first row of product call to calculate closing fun
							validated = calculateclosing(prodid);
							if(validated){}else{return false;}
							//
							for (var value = 1; value <= 3; value++){
							  var str1 = "]";
							  var lastval = value+str1;
							  var rowobj = $('.consumptionitems').find('tr[data-prodrow="'+prodid+'"][data-prodrowindex="'+prodrowindex+'"]');
							  var defaultercover = $(rowobj).find('input[name$="c'+lastval+'"]').val();
							  var totaldefaulter = $(rowobj).find('input[name$="d'+lastval+'"]').val();
							  if(defaultercover == '' || defaultercover == undefined || defaultercover == '0'){ 
							  }else{  
								  validated = getinputvaccinatedSum(prodid,prodrowindex,lastval,defaultercover);
								  if(validated){}else{return false;}
							  }
							  if(totaldefaulter == '' || totaldefaulter == undefined || totaldefaulter == '0'){ 
							  }else{  
								  validated = calculatetotaldefaulter(prodid,prodrowindex,lastval,defaultercover,totaldefaulter);
								  if(validated){}else{return false;}
							  }
							  /* if(totaldefaulter == '' || totaldefaulter == undefined || totaldefaulter == '0'){
							  }else{
								  if(!(defaultercover > totaldefaulter)){
									$(rowobj).find('input[name$="'+value+'"]').css("background-color","#F54F4F");
									alert("Defaulter Cover cannot be greater than Total Defaulter.");
									disablesaveenableentry();
								  }else{
									$(rowobj).find('input[name$="'+value+'"]').css("background-color","#FFF");
									enablesavedisableentry();
								  } 
							  } */ 
							} 
							//
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
	/*$(document).on('click','.sharedata',function(){
		var prodid = $(this).closest("tr").data("prodrow");
		var modalobj = $("#DataSharingModal");
		var pkid = "moon";
		if(prodid=="6"){
			modalobj = $("#TTDataSharingModal");
			pkid = "moontt";
		}
		var oldprodname = $(modalobj).find("#ds-productname").text();		
		var oldantigen = $(modalobj).find("#ds-antigen").text();
		var name = $(".cst-item-row[data-prodrow="+prodid+"]").find(".itemname").text();
		var antigen = $(this).closest("tr").find(".vaccnum").text();
		$(modalobj).find("#ds-productname").text(name);
		$(modalobj).find("#ds-antigen").text(antigen);
		$("#clickedrownum").val((parseInt($(this).closest("tr").index()) || 0)+1);		
		if(oldprodname==name && oldantigen==antigen){
			//same row clicked
		}else{
			var clickedrow = $("#clickedrownum").val();
			var rowobj = $(".consumptionitems tr:nth-child("+clickedrow+")");
			var facode = $("#facode").val();
			var month = $("#month").val();
			var year = $("#year").val();
			var fmonth = year+"-"+month;
			if(antigen==''){
				antigen='';
			}else{
				antigen=antigen;
			}
			//check if data exist in db table.
			var defaultval = alasql("SELECT * FROM defaultmodalData WHERE pkid = '"+pkid+"'");
			$.ajax({
				type: "post",
				data: {fmonth:fmonth,facode:facode,antigen:antigen,prodid:prodid},
				url: "<?php echo base_url(); ?>vaccination/CRUD/get_monthly_outuc_coverage",
				success: function(result){
					var resultarray = JSON.parse(result);	
					//console.log(resultarray);
					if(resultarray === undefined || resultarray.length == 0){
						$(modalobj).find("#sharingdatatblebody").html($.parseHTML(defaultval[0].htmldata));
					}else{
						for(var iter = 0; iter<resultarray.length;iter++){
							modalselectedteh=resultarray[iter]["tcode"];
							modalselecteduc=resultarray[iter]["uncode"];
							if(iter==0){
								$(modalobj).find("#sharingdatatblebody").html($.parseHTML(defaultval[0].htmldata));
							}else{
								//$(".cloneadd").trigger("click");
								$(modalobj).find("#sharingdatatblebody tr:last").after($.parseHTML(defaultval[0].htmldata));
							}
							//write code to set values 
							if(prodid==6){ 
								var fmcells = ["fp","fnp","op","onp","mp","mnp","hp","hnp"];
								modalobj = $("#TTDataSharingModal");
							}else{
								var fmcells = ["fm1","ff1","om1","of1","mm1","mf1","hm1","hf1","fm2","ff2","om2","of2","mm2","mf2","hm2","hf2","fm3","ff3","om3","of3","mm3","mf3","hm3","hf3"];
							}
							var modalrowobj = $(modalobj).find("#sharingdatatblebody").find("tr:nth-child("+((parseInt(iter) || 0)+1)+")");
							$(modalrowobj).find('select[name^="datasharing[countrycode]"] option[value="' + resultarray[iter]["countrycode"] + '"]').prop('selected', true);
							$(modalrowobj).find('select[name^="datasharing[countrycode]"]').trigger("change");
							
							$(modalrowobj).find('select[name^="datasharing[procode]"] option[value="' + resultarray[iter]["procode"] + '"]').prop('selected', true);
							$(modalrowobj).find('select[name^="datasharing[procode]"]').trigger("change");
							
							$(modalrowobj).find('select[name^="datasharing[distcode]"] option[value="' + resultarray[iter]["distcode"] + '"]').prop('selected', true);
							$(modalrowobj).find('select[name^="datasharing[distcode]"]').trigger("change");
							
							$(modalrowobj).find('select[name^="datasharing[tcode]"] option[value="' + resultarray[iter]["tcode"] + '"]').prop('selected', true);
							
							$(modalrowobj).find('select[name^="datasharing[tcode]"]').trigger("change");
							
							$(modalrowobj).find('select[name^="datasharing[uncode]"] option[value="' + resultarray[iter]["uncode"] + '"]').prop('selected', true);
							
							$.each( fmcells, function( i, val ) {
								var fieldval = resultarray[iter][val];
								$(modalrowobj).find('input[name^="datasharing[vaccinated]['+val+']"]').val(fieldval);
							});
						}
					}	
				}
			});
		}
	});*/
	/* $(document).on('paste','#quantitymodal',function(e){
		e.preventDefault();
	}); */
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
	/* $(document).on('click','.cloneadd',function(){
		var clonedhtml = $(this).closest("tr").clone();
		$(clonedhtml).find("td:last-child").html('<button type="button" class="btn btn-danger btn-xs clonedel" data-original-title="Delete this Batch"><i class="fa fa-minus"></i></button>');
		$(this).closest("tr").after(clonedhtml);
	}); */
	$(document).on('click','.clonedel',function(){
		//confirm before deletion
		var confirmdel = confirm("This will delete current row, Do you really want to remove it?");
		if(confirmdel){
			$(this).closest("tr").remove();
		}
	});
	$(document).on('click','#datasharigbtn',function(){
		//check if data exist in db table.
		var defaultval = alasql("SELECT * FROM defaultmodalData WHERE pkid = 'moon'");
		if(typeof(defaultval[0]) != "undefined" && defaultval[0] !== null) {
			$("#sharingdatatblebody").html($.parseHTML(defaultval[0].htmldata))
		}
	});
});	
$(document).on('change','.countrycode', function(){
	var countrycode = $(this).val();
	var obj = $(this);
	if(countrycode==92){ 
		$.ajax({ 
			type: 'POST',
			async: false,
			data: '',
			url: '<?php echo base_url();?>Ajax_red_rec/getProvinces_options',
			success: function(data){
				$('#DataSharingModal').find('.procode').html(data);
				if(selectedmodalprocode==''){}else{
					$('select[name^="datasharingprocode"] option[value="' + selectedmodalprocode + '"]').prop('selected', true);
				}
				$('#DataSharingModal').find('.procode').trigger('change');
			}
		});
	}else{   
		$('#DataSharingModal').find('.procode').html('');
		$('#DataSharingModal').find('.district').html('');
		$('#DataSharingModal').find('.tehsil').html('');
		$('#DataSharingModal').find('.unioncouncil').html('');
	}	
});
$(document).on('change','.procode', function(){
	var obj = $(this);
	var procode = $(this).val();
	if($('#DataSharingModal').find(".district").length == 0) {
	  //it doesn't exist
	}else{
		$.ajax({
			type: "POST",
			async: false,
			data: "procode="+procode,
			url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
			success: function(result){
				$('#DataSharingModal').find('.district').html(result);
				if(selectedmodaldistcode==''){}else{
					$('select[name^="datasharingdistcode"] option[value="' + selectedmodaldistcode + '"]').prop('selected', true);
				}
				$('#DataSharingModal').find('.district').trigger('change');
			}
		});
	}
});
$(document).on('change','.district', function(){
	var obj = $(this);
	var distcode = $(this).val(); 
	//to get tehsils of selected distcrict
	if($('#DataSharingModal').find(".tehsil").length == 0) {
	  //it doesn't exist
	}else{
		$.ajax({
			type: "POST",
			async: false,
			data: "distcode="+distcode,
			url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceTehsils",
			success: function(result){
				$('#DataSharingModal').find('.tehsil').html(result);
				if(selectedmodaltcode==''){}else{
					$('select[name^="datasharingtcode"] option[value="' + selectedmodaltcode + '"]').prop('selected', true);
				}
				$('#DataSharingModal').find('.tehsil').trigger('change');
			}
		});
	}						
});
$(document).on('change','.tehsil', function(){
	var obj = $(this);
	var tcode = $(this).val();
	//to get unioncouncis of selected tehsil
	if($('#DataSharingModal').find(".unioncouncil").length == 0) {
	  //it doesn't exist
	}else{
		$.ajax({
			type: "POST",
			async: false,
			data: "tcode="+tcode,
			url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceUCs",
			success: function(result){
				$('#DataSharingModal').find('.unioncouncil').html(result);
				if(selectedmodaluncode==''){}else{
					$('select[name^="datasharinguncode"] option[value="' + selectedmodaluncode + '"]').prop('selected', true);
				}
			}
		});
	}					
});
$(document).on('click','#submitDataSharing', function(){
	//get modal values and set in row fields, based on out uc and out district.
	//var totalrec = 0;
	//var clickedrow = $("#clickedrownum").val();
	//var rowobj = $(".consumptionitems tr:nth-child("+clickedrow+")");
	var country = $('select[name^="datasharingcountry"] option:selected').text();
	var countrycode = $('select[name^="datasharingcountry"]').val();
	var province = $('select[name^="datasharingprocode"] option:selected').text();
	var procode = $('select[name^="datasharingprocode"]').val();
	var district = $('select[name^="datasharingdistcode"] option:selected').text();
	var distcode = $('select[name^="datasharingdistcode"]').val();
	console.log(distcode);
	var tehsil = $('select[name^="datasharingtcode"] option:selected').text();
	var tcode = $('select[name^="datasharingtcode"]').val();
	var uc = $('select[name^="datasharinguncode"] option:selected').text();
	var uncode = $('select[name^="datasharinguncode"]').val();
	if(procode==null){
		procode=0;
	}else{
		procode=procode;
	}
	if(distcode==null){
		distcode=0;
	}else{
		distcode=distcode;
	}
	if(tcode==null){
		tcode=0;
	}else{
		tcode=tcode;
	}
	if(uncode==null){
		uncode=0;
	}else{
		uncode=uncode;
	}
	$("#sharingdatatblebody").find(".modaldatasharingrow").each(function(){
		var singlerowobj = $(this);
		var item_id = $(singlerowobj).data("productid");
		var antigen = (parseInt($(singlerowobj).data("antigen")) || 0);
		var prodrowindex = (parseInt($(singlerowobj).data("prodrowindex")) || 0);
		var facode = $("#facode").val();
		var month = $("#month").val();
		var year = $("#year").val();
		var fmonth = year+"-"+month;
		var modalobj = $("#DataSharingModal");
		if(item_id==6){
			var fmcells = ["fp","fnp","op","onp","mp","mnp","hp","hnp"];
			//modalobj = $("#TTDataSharingModal");
		}else{
			var fmcells = ["fm1","ff1","om1","of1","mm1","mf1","hm1","hf1","fm2","ff2","om2","of2","mm2","mf2","hm2","hf2","fm3","ff3","om3","of3","mm3","mf3","hm3","hf3"];
		}
		var sessiondist = '<?php echo $this -> session -> District; ?>';
		//code here to sava data into new tables and show in columns
		var serializedString = $(this).find(":input").serialize();
		$.ajax({
			type: "post",
			data: serializedString+"&year="+year+"&month="+month+"&facode="+facode+"&item_id="+item_id+"&antigen="+antigen+"&countrycode="+countrycode+"&procode="+procode+"&distcode="+distcode+"&tcode="+tcode+"&uncode="+uncode,
			url: '<?php echo base_url("vaccination/saveDataShare"); ?>', 
			success: function(result){
				//console.log(result);
				var resultarray = JSON.parse(result);	
				for(var iter = 0; iter<resultarray.length;iter++){
					$.each( fmcells, function( i, val ) { 
						var fieldval = resultarray[iter][val];  
						if(sessiondist==distcode){ 
							//out UC
							var fieldname = 'product[vaccinated]['+item_id+']['+prodrowindex+'][ou'+val+']';
							var newval = (parseInt(fieldval) || 0);
							$(".consumptionitems").find('input[name$="'+fieldname+'"]').val(newval);
						}else{
							//out Dist
							var fieldname = 'product[vaccinated]['+item_id+']['+prodrowindex+'][od'+val+']';
							var newval = (parseInt(fieldval) || 0);
							$(".consumptionitems").find('input[name$="'+fieldname+'"]').val(newval);
						}
					});
				}
			}
		});
		/* 
		var antigen = $(modalobj).find("#ds-antigen").text();
		
		//store into local db
		//alasql("INSERT INTO modalData VALUES ('"+item_id+"','"+antigen+"','"+serializedString+"',"+totalrec+")");
		modalhtmlobj[item_id+"moon"+antigen] = $(modalobj).find("#sharingdatatblebody").clone(); */
	});
	//code here to remove default row from table if exist
	$("#datasharigbody").find(".defaultrow").remove();
	//code here to append row in table
	if(uncode==0){
		$("#datasharigbody").find('[data-countrycode='+countrycode+']').remove();
	}else{
		$("#datasharigbody").find('[data-uncode='+uncode+']').remove();
	}
	var dstblrow = '<tr data-countrycode="'+countrycode+'" data-uncode="'+uncode+'"><td>'+country+'</td><td>'+province+'</td><td>'+district+'</td><td>'+tehsil+'</td><td>'+uc+'</td><td><a id="edit_outucdata" href="#" data-toggle="modal" data-target="#DataSharingModal" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default edit_outucdata" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a data-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sureyou want to delete?\')" class="btn btn-xs btn-default delete_outucdata" data-original-title="Delete"><i class="fa fa-close"></i></a></td></tr>';
	$("#datasharigbody").append(dstblrow);
});
$(document).on("change","#DataSharingModal .childvacc",function(){
	var distcode = $('#DataSharingModal').find(".district").val();
	var tcode = $('#DataSharingModal').find(".tehsil").val();
	var uncode = $('#DataSharingModal').find(".unioncouncil").val();
	var procode = $('#DataSharingModal').find(".procode").val();
	var countrycode = $('#DataSharingModal').find(".countrycode").val();
	if(countrycode==92){
		if(parseInt(distcode)>0 && parseInt(tcode)>0 && parseInt(uncode)>0 && parseInt(procode)>0){}else{
			$(this).val(0);
			alert("Please select Province, District, Tehsil and Union Council first.");
		}
	}
});
$(document).on("change","#TTDataSharingModal .childvacc",function(){
	var distcode = $(this).closest("tr").find(".district").val();
	var tcode = $(this).closest("tr").find(".tehsil").val();
	var uncode = $(this).closest("tr").find(".unioncouncil").val();
	var procode = $(this).closest("tr").find(".procode").val();
	var countrycode = $(this).closest("tr").find(".countrycode").val();
	if(countrycode==92){
		if(parseInt(distcode)>0 && parseInt(tcode)>0 && parseInt(uncode)>0 && parseInt(procode)>0){}else{
			$(this).val(0);
			alert("Please select Province, District, Tehsil and Union Council first.");
		}
	}
});
function resetstyle(reff){
	reff.style.paddingRight = "unset";
}
$.fn.deserialize = function (serializedString)
{
    var $form = $(this);
    $form[0].reset();
    serializedString = serializedString.replace(/\+/g, '%20');
    var formFieldArray = serializedString.split("&");
    $.each(formFieldArray, function(i, pair){
        var nameValue = pair.split("=");
        var name = decodeURIComponent(nameValue[0]);
        var value = decodeURIComponent(nameValue[1]);
        // Find one or more fields
        var $field = $form.find('[name="' + name + '"]');
        console.log(name, value);
        $field.val(value);
    });
}
/* var modaldefaulthtml = $("#DataSharingModal").find("#sharingdatatblebody").html();
var ttmodaldefaulthtml = $("#TTDataSharingModal").find("#sharingdatatblebody").html();
alasql("INSERT INTO defaultmodalData VALUES ('moon','"+modaldefaulthtml+"'),('moontt','"+ttmodaldefaulthtml+"')"); */
//
$(document).on('click','.edit_outucdata',function(){
	var facode = $("#facode").val();
	var month = $("#month").val();
	var year = $("#year").val();
	var fmonth = year+"-"+month;
	var uncode = selectedmodaluncode = $(this).closest("tr").data("uncode");
	var countrycode = selectedmodalcountrycode = $(this).closest("tr").data("countrycode");
	var modalobj = $("#DataSharingModal");
	$.ajax({
		type: "post",
		data: {fmonth:fmonth,facode:facode,countrycode:countrycode,uncode:uncode},
		url: "<?php echo base_url(); ?>vaccination/CRUD/get_monthly_outuc_coverage",
		success: function(result){
			//console.log(result);
			var resultarray = JSON.parse(result);	
			for(var iter = 0; iter<resultarray.length;iter++){
				modalselectedteh=resultarray[iter]["tcode"];
				modalselecteduc=resultarray[iter]["uncode"];
				//write code to set values 
				if(resultarray[iter]["item_id"]==6){ 
					var fmcells = ["fp","fnp","op","onp","mp","mnp","hp","hnp"];
				}else{
					var fmcells = ["fm1","ff1","om1","of1","mm1","mf1","hm1","hf1","fm2","ff2","om2","of2","mm2","mf2","hm2","hf2","fm3","ff3","om3","of3","mm3","mf3","hm3","hf3"];
				}
				var item_id=resultarray[iter]["item_id"];
				if(item_id==2 || item_id==29 || item_id==9999){
					var antigen='';
				}else{
					var antigen=resultarray[iter]["antigen"];
				}
				var modalrowobj = $(modalobj).find("#sharingdatatblebody").find('[data-productid='+resultarray[iter]["item_id"]+'][data-antigen="'+antigen+'"]');
				selectedmodalprocode = resultarray[iter]["procode"]; 
				selectedmodaldistcode = resultarray[iter]["distcode"];
				selectedmodaltcode = resultarray[iter]["tcode"];
				var item_id = resultarray[iter]["item_id"];
				var antigen = resultarray[iter]["antigen"];
				$.each( fmcells, function( i, val ) {
					var fieldval = resultarray[iter][val];
					//insert query
					//store into local db
					//alasql("Delete FROM modaldataSharing WHERE facode = '"+facode+"' and countrycode = '"+countrycode+"' and uncode = '"+uncode+"' and fmonth = '"+fmonth+"' and item_id = '"+item_id+"' and antigen = '"+antigen+"' and fieldname = '"+val+"'");
					//alasql("INSERT INTO modaldataSharing VALUES ('"+facode+"','"+countrycode+"','"+uncode+"','"+fmonth+"','"+item_id+"','"+antigen+"','"+val+"','"+fieldval+"')");
					$(modalrowobj).find('input[name^="datasharing[vaccinated]['+val+']"]').val(fieldval);
				});
			}
			$('select[name^="datasharingcountry"] option[value="' + countrycode + '"]').prop('selected', true);
			$('select[name^="datasharingcountry"]').trigger("change");
				
		}
	});
});
//delete monthly_outuc_coverage 
$(document).on('click','.delete_outucdata',function(){
	var facode = $("#facode").val();
	var month = $("#month").val();
	var year = $("#year").val();
	var fmonth = year+"-"+month;
	var uncode = selectedmodaluncode = $(this).closest("tr").data("uncode");
	var countrycode = selectedmodalcountrycode = $(this).closest("tr").data("countrycode");
	$.ajax({
		type: "post",
		data: {fmonth:fmonth,facode:facode,countrycode:countrycode,uncode:uncode},
		url: "<?php echo base_url(); ?>vaccination/CRUD/delete_monthly_outuc",
		success: function(response){ 
			if(response == 'true'){
				if(uncode==0){
					$("#datasharigbody").find('[data-countrycode='+countrycode+']').remove();
				}else{
					$("#datasharigbody").find('[data-uncode='+uncode+']').remove();
				}
           		
			}
  		}
	});	
});	
//for fully immunized
function sumfully() {
    var result=0;
    var txtFirstNumberValue = document.getElementById('txt1fully').value;
    var txtSecondNumberValue = document.getElementById('txt2fully').value;
    if (txtFirstNumberValue !="" && txtSecondNumberValue ==""){
        result = parseInt(txtFirstNumberValue);
    }else if(txtFirstNumberValue == "" && txtSecondNumberValue != ""){
        result= parseInt(txtSecondNumberValue);
    }else if (txtSecondNumberValue != "" && txtFirstNumberValue != ""){
        result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
    }
       if (!isNaN(result)) {
           document.getElementById('totalfully').value = result;
       }
   }
//for dtp booster   
function sumdtp() {
    var result=0;
    var txtFirstNumberValue = document.getElementById('txt1dtp').value;
    var txtSecondNumberValue = document.getElementById('txt2dtp').value;
    if (txtFirstNumberValue !="" && txtSecondNumberValue ==""){
        result = parseInt(txtFirstNumberValue);
    }else if(txtFirstNumberValue == "" && txtSecondNumberValue != ""){
        result= parseInt(txtSecondNumberValue);
    }else if (txtSecondNumberValue != "" && txtFirstNumberValue != ""){
        result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
    }
       if (!isNaN(result)) {
           document.getElementById('totaldtp').value = result;
       }
   }
</script>