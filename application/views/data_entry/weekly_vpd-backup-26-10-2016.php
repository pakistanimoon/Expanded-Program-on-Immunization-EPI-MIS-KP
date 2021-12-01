<!--start of page content or body-->
<?php
date_default_timezone_set('Asia/Karachi'); // CDT
$current_date = date('d-m-Y');?>
<div class="container bodycontainer">
	<div class="row">
		<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-danger text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
		<div class="panel panel-primary">
			<div class="panel-heading"> Data Entry for Disease Surveillance</div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Data_entry/weekly_vpd_save">
					<?php if(isset($weeklyVPD)){
					?> <input type="hidden" name="recid" id="recid" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->recid; }else {  } ?>">
					<?php } ?>
					<table class="table table-bordered table-striped table-hover  mytable3">
						<tbody>
							<tr>
								<td><label class="pt7">Province</label></td>
								<td><label class="pt7">Khyber Pakhtunkhwa</label>
								<td><label class="pt7">District</label></td>
								<td>
									<input type="hidden" id="distcode" name="distcode" value="<?php $distcode = (isset($weeklyVPD))?$weeklyVPD->distcode:$this -> session -> District;  echo $distcode; ?>">
									<label class="pt7"><?php echo get_District_Name($distcode); ?></label>
								</td>
								<td><label class="pt7">Tehsil</label></td>
								<td><?php if(isset($weeklyVPD)){ ?>
									<select class="form-control" name="tcode" id="tcode" required="required">
									  <option value="<?php echo $weeklyVPD->tcode; ?>"><?php echo $tehsil; ?></option>
									</select>
									<?php }else{ ?>
									<select class="form-control" name="tcode" id="tcode" required="required"></select>
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td><label class="pt7">Union Council</label></td>
								<td><?php if(isset($weeklyVPD)){ ?>
									<select class="form-control" name="uncode" id="uncode">
										<option value="<?php echo $weeklyVPD->uncode; ?>"><?php echo $unioncouncil; ?></option>
									</select>
									<?php }else{ ?>
									<select class="form-control" name="uncode" id="uncode"></select>
									<?php } ?>
								</td>
								<td><label class="pt7">Health Facility</label></td>
								<td>
									<?php if(isset($weeklyVPD)){ ?>
									<select class="form-control" required name="facode" id="facode">
										<option value="<?php echo $weeklyVPD->facode; ?>"><?php echo $facility; ?></option>
									</select>
									<?php }else{ ?>
									<select class="form-control" required name="facode" id="facode"></select>
									<?php } ?>
								</td>
								<td><label class="pt7">Year</label></td>
								<td>
									<select class="form-control text-center" required name="year" id="year">
									<?php if(isset($weeklyVPD)){ ?>
										<option value="<?php echo $weeklyVPD->year; ?>"><?php echo $weeklyVPD->year; ?></option>
									<?php }else{ ?>
									<?php echo $years; } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label class="pt7">EPI Week No</label></td>
								<td>
									<select class="form-control" required name="week" id="week">
										<?php if(isset($weeklyVPD)){ ?>
											<option value="<?php echo sprintf("%02d",$weeklyVPD->week); ?>">Week <?php echo sprintf("%02d",$weeklyVPD->week); ?></option>
										<?php }else{ ?>
										<option>--Select Week No--</option>
										<?php } ?>
									</select>
								</td>
								<td><label class="pt7">Date From</label></td>
								<td><input class="form-control text-center datefrom" required="required" readonly="readonly" name="datefrom" id="datefrom" value="<?php if(isset($weeklyVPD)){ echo date('d-M-Y',strtotime($weeklyVPD->datefrom)); }else { if(validation_errors() != false) { echo set_value('datefrom');} else{ } } ?>"  placeholder="From" type="text"></td>
								<td><label class="pt7">Date To</label></td>
								<td><input class="form-control text-center dateto" required="required" readonly="readonly" name="dateto" id="dateto" value="<?php if(isset($weeklyVPD)){ echo date('d-M-Y',strtotime($weeklyVPD->dateto)); }else { if(validation_errors() != false) { echo set_value('dateto');} else{ } } ?>" placeholder="To" type="text"></td>
							</tr>
							<!--<tr>
								<td><label class="pt7">Case Reported</label></td>
								<td>
									Yes <input type="radio" id="case_reported" <?php if(!isset($weeklyVPD)){ echo 'checked="checked"'; } ?> name="case_reported" <?php if(isset($weeklyVPD) && $weeklyVPD->case_reported == '1'){ echo 'checked="checked"'; } ?> value="1" >
									No <input type="radio" id="case_reported" name="case_reported" <?php echo (isset($weeklyVPD) && $weeklyVPD->case_reported == 0)?'checked="checked"':''; ?> value="0" >
								</td>
							</tr>-->
						</tbody>
					</table>
					<table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Basic Information</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><label class="pt7">Name of Case</label></td>
								<td><input class="form-control text-center" pattern="[a-zA-Z]+[a-zA-Z ]+" style="text-transform: capitalize;" title="Only characters are allowed" name="name_case" required="required" id="name_case" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->name_case; }else { if(validation_errors() != false ) { echo set_value('name_case');} else { } } ?>" type="text"></td>
								<td><label class="pt7">Gender</label></td>
								<td>
									<table style="width:60%;margin-top: 6px;">
										<tbody>
											<tr>
											<td>
												Male <input type="radio" id="gender" <?php if(!isset($weeklyVPD)){ echo 'checked="checked"'; } ?> name="gender" <?php if(isset($weeklyVPD) && $weeklyVPD->gender == '1'){ echo 'checked="checked"'; } ?> value="1" >
												Female <input type="radio" id="gender" name="gender" <?php echo (isset($weeklyVPD) && $weeklyVPD->gender == 0)?'checked="checked"':''; ?> value="0" >
											</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td><label class="pt7">Age Months</label></td>
								<td><input class="form-control text-center numberclass" name="age_months" id="case_age" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->age_months; }else { if(validation_errors() != false ) { echo set_value('age_months');} else { } } ?>" type="text"></td>
							</tr>
							<tr>
								<td><label class="pt7">Father Name</label></td>
								<td><input class="form-control text-center " pattern="[a-zA-Z]+[a-zA-Z ]+" style="text-transform: capitalize;" title="Only characters are allowed" name="case_father_name" id="case_father_name" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->case_father_name; }else { if(validation_errors() != false ) { echo set_value('case_father_name');} else { } } ?>" type="text"></td>
								<td><label class="pt7">Father CNIC</label></td>
								<td><input class="form-control text-center numberclass" name="case_father_nic" id="case_father_nic" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->case_father_nic; }else { if(validation_errors() != false ) { echo set_value('case_father_nic');} else { } } ?>" type="text"></td>
								<td><label class="pt7">Cell No</label></td>
								<td><input class="form-control text-center numberclass" name="case_cell" id="case_cell" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->case_cell; }else { if(validation_errors() != false ) { echo set_value('case_cell');} else { } } ?>" type="text"></td>
							</tr>
							<tr>
								<td><label class="pt7">Address</label></td>
								<td><input class="form-control text-center" name="case_address" style="text-transform: capitalize;" id="case_address" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->case_address; }else { if(validation_errors() != false ) { echo set_value('case_address');} else { } } ?>" type="text"></td>
								<td><label class="pt7">District</label></td>
								<td>
									<select class="form-control" required id="case_distcode" name="case_distcode">
									<?php if(isset($weeklyVPD) && $weeklyVPD->case_distcode > 0){ ?>
										<option value="<?php echo $weeklyVPD->case_distcode; ?>"><?php echo get_District_Name($weeklyVPD->case_distcode); ?></option>
									<?php }else if(isset($weeklyVPD) && $weeklyVPD->case_distcode==""){ ?>
										<option>--Select District--</option>
										<?php echo getDistricts_options('','','Yes'); ?>
									<?php }else{ ?>
									<option>--Select District--</option>
									 <?php echo getDistricts_options('','','Yes'); ?>
									 <?php } ?>
									</select>
								</td>
								<td><label class="pt7">Tehsil</label></td>
								<td>
									<select required id="case_tcode" name="case_tcode" class="form-control">
									  <?php if(isset($weeklyVPD)){ ?>
										<option value="<?php echo $weeklyVPD->case_tcode; ?>" > <?php echo get_Tehsil_Name($weeklyVPD->case_tcode); ?> </option>
										<?php }else{} ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label class="pt7">Union Council</label></td>
								<td>
									<select id="case_uncode" name="case_uncode" class="form-control">
									  <?php if(isset($weeklyVPD)){ ?>
										<option value="<?php echo $weeklyVPD->case_uncode; ?>" <?php if(validation_errors() != false) { echo set_select('case_uncode',$weeklyVPD->case_uncode); }?> > <?php echo get_UC_Name($weeklyVPD->case_uncode); ?> </option>
										<?php }else{} ?>
									</select>
								</td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="8" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Disease Information</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><label class="pt7">Type of Case</label></td>
								<td>
									<select class="form-control case_type" required name="case_type">
										<?php echo (isset($weeklyVPD) && $weeklyVPD->case_type != '')?'':'<option>-Select-</option>'; ?>
										<?php echo (isset($weeklyVPD))?getCasesType(true,$weeklyVPD->case_type):getCasesType(false); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label class="pt7">Date of onset</label></td>
								<td><input class="dp form-control" placeholder="" onchange="getdate();" name="case_date_onset" id="case_date_onset" value="<?php if(isset($weeklyVPD) && $weeklyVPD->case_date_onset != NULL){ echo date('d-m-Y',strtotime($weeklyVPD->case_date_onset)); }else{} ?>" <?php if(validation_errors() != false) { echo 'set_value("case_date_onset","case_date_onset")';} ?> type="text"></td>
								<td><label class="pt7">Date of Investigation</label></td>
								<td><input class="dp form-control" placeholder="" name="case_date_investigation" id="case_date_investigation" value="<?php if(isset($weeklyVPD) && $weeklyVPD->case_date_investigation != NULL){ echo date('d-m-Y',strtotime($weeklyVPD->case_date_investigation)); } ?>" type="text"></td>
								
								<td><label class="pt7">Total No. of vaccine doses Received</label></td>
								<td>
								<select id="case_tot_vacc_received" name="doses_received" class="form-control text-center" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->doses_received; } ?>">
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->doses_received  == "0"){ echo 'selected="selected"';} } ?> value="0" class="text-center">-- Select --</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->doses_received  == "Zero Doze"){ echo 'selected="selected"';} } ?> value="Zero Doze">Zero Doze</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->doses_received  == "Partialy Immunized"){ echo 'selected="selected"';} } ?> value="Partialy Immunized">Partialy Immunized</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->doses_received  == "Fully Immunized"){ echo 'selected="selected"';} } ?> value="Fully Immunized">Fully Immunized</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->doses_received  == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->doses_received  == "N/A"){ echo 'selected="selected"';} } ?> value="N/A">N/A</option>
										
									</select>
								
								</td>
								
								
							</tr>
							<tr>
								<td><label class="pt7">Date of last dose Received</label></td>
								<td><input class="dp form-control" placeholder="" name="case_date_last_dose_received" id="case_date_last_dose_received" value="<?php if(isset($weeklyVPD) && $weeklyVPD->case_date_last_dose_received != NULL){ echo date('d-m-Y',strtotime($weeklyVPD->case_date_last_dose_received)); }else{} ?>" type="text"></td>
								
								
								<td><label class="pt7">Type of Specimen Collection</label></td>
								<td>
									<select id="case_type_speceicman" name="case_type_speceicman" class="form-control text-center" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->case_type_speceicman; } ?>">
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->case_type_speceicman  == "0"){ echo 'selected="selected"';} } ?> value="0" class="text-center">-- Select --</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->case_type_speceicman  == "Nasopharyngeal Swab"){ echo 'selected="selected"';} } ?> value="Nasopharyngeal swab">Nasopharyngeal Swab</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->case_type_speceicman  == "Throat Swab"){ echo 'selected="selected"';} } ?> value="Throat Swab">Throat Swab</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->case_type_speceicman  == "Urine"){ echo 'selected="selected"';} } ?> value="Urine">Urine</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->case_type_speceicman  == "CSF"){ echo 'selected="selected"';} } ?> value="CSF">CSF</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->case_type_speceicman  == "Stool"){ echo 'selected="selected"';} } ?> value="Stool">Stool</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->case_type_speceicman  == "Blood"){ echo 'selected="selected"';} } ?> value="Blood">Blood</option>	
									</select>
								</td>
								<td><label class="pt7">Date of Specimen Collection</label></td>
								<td><input class="dp form-control" placeholder="" name="case_date_specieman" id="case_date_specieman" value="<?php if(isset($weeklyVPD) && $weeklyVPD->case_date_specieman != NULL){ echo date('d-m-Y',strtotime($weeklyVPD->case_date_specieman)); }else{} ?>" <?php if(validation_errors() != false) { echo 'set_value("case_date_specieman","case_date_specieman")';} ?> type="text"></td>
							</tr>
							<tr>
								<td><label class="pt7">Clinical Representation of the Case</label></td>
								<td>
								  <?php  
								
									$chklist=array();
										$chklist= explode(',', $weeklyVPD ->case_representation); ?>
										
								<select id="case_representation" required="required" name="case_representation[]" class="form-control text-center">
						
								 <?php  
									if(isset($weeklyVPD)){ 
									  foreach($chklist as $row){              
											echo $row;   ?>
									<option value="<?php echo $row; ?>"><?php echo ($row=='999')?'NA':(($row=='1000')?'Other':get_CaseRepresentation_Value($row)); ?></option>
									  <?php }  } ?>
								</select>
				
								</td>
								<td><label class="pt7">Other</label>
								<input type="checkbox" id="other" /></td>
								<td>
								<input type="text" id="other_rep" readonly  name="other_case_representation" size="35" class="form-control text-left" col span="2" value ="<?php if(isset($weeklyVPD ->other_case_representation)) { echo $weeklyVPD->other_case_representation;} ?>" />
								</td>
								
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Lab Information</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="width:50%;"><label class="pt7">Specimen Result</label></td>
								<td>
									<select id="specieman_result" name="specieman_result" class="form-control text-center">
										<option value="0" class="text-center">--Select One--</option>
										<?php if(isset($weeklyVPD) && $weeklyVPD->case_type=="Msl"){ ?>
										<option <?php if(isset($weeklyVPD)){ if($weeklyVPD->specieman_result  == "Positive Measles"){ echo 'selected="selected"';} } ?> value="Positive Measles" class="text-center">Positive Measles</option>
										<option <?php if(isset($weeklyVPD)){ if($weeklyVPD->specieman_result  == "Positive Rubella"){ echo 'selected="selected"';} } ?> value="Positive Rubella" class="text-center">Positive Rubella</option>
										<option <?php if(isset($weeklyVPD)){ if($weeklyVPD->specieman_result  == "Negative"){ echo 'selected="selected"';} } ?> value="Negative" class="text-center">Negative</option>
										<?php }else{ ?>
										<option <?php if(isset($weeklyVPD)){ if($weeklyVPD->specieman_result  == "Positive"){ echo 'selected="selected"';} } ?> value="Positive" class="text-center">Positive</option>
										<option <?php if(isset($weeklyVPD)){ if($weeklyVPD->specieman_result  == "Negative"){ echo 'selected="selected"';} } ?> value="Negative" class="text-center">Negative</option>
										<option <?php if(isset($weeklyVPD)){ if($weeklyVPD->specieman_result  == "NA"){ echo 'selected="selected"';} } ?> value="NA" class="text-center">NA</option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Follow-up Information</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><label class="pt7">Date of follow-up</label></td>
								<td><input class="dp form-control" name="case_date_follow" id="case_date_follow" value="<?php if(isset($weeklyVPD) && $weeklyVPD->case_date_follow != NULL){ echo date('d-m-Y',strtotime($weeklyVPD->case_date_follow)); }else{} ?>" <?php if(validation_errors() != false) { echo 'set_value("case_date_follow","case_date_follow")';} ?> type="text"></td>
								<td><label class="pt7">Outcomes</label></td>
								
								<td>
									<select id="outcomes" name="outcomes" class="form-control text-center" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->outcomes; } ?>">
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->outcomes  == "0"){ echo 'selected="selected"';} } ?> value="0" class="text-center">-- Select --</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->outcomes  == "Partialy Recovered"){ echo 'selected="selected"';} } ?> value="Partialy Recovered">Partialy Recovered</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->outcomes  == "Fully Recovered"){ echo 'selected="selected"';} } ?> value="Fully Recovered">Fully Recovered</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->outcomes  == "Complication"){ echo 'selected="selected"';} } ?> value="Complication">Complication</option>
										<option  <?php if(isset($weeklyVPD)){ if($weeklyVPD->outcomes  == "Died"){ echo 'selected="selected"';} } ?> value="Died">Died</option>
										
									</select>
								</td>
							</tr>
							<tr id="complication_type" style="display: none;">	
								
								<td style="width:10%"><label class="pt7">Complication Type</label></td>
								<td style="width:40%"><input class="form-control" placeholder="Enter Complications" name="complication_type" id="complication_type" value="<?php if(isset($weeklyVPD)){ echo $weeklyVPD->complication_type; }else{"";} ?>" <?php if(validation_errors() != false) { echo 'set_value("complication_type","complication_type")';} ?> type="text"></td>
								
							</tr>
							
							<tr id="death_date" style="display: none;">	
								
								<td><label class="pt7">Death Date</label></td>
								<td><input class="dp form-control" placeholder="Enter Death Date" name="death_date_follow" id="death_date_follow" value="<?php if(isset($weeklyVPD)){ echo date('d-m-Y',strtotime($weeklyVPD->death_date_follow)); }else{"";} ?>" <?php if(validation_errors() != false) { echo 'set_value("death_date_follow","death_date_follow")';} ?> type="text"></td>
								
							</tr>
							
						</tbody>
					</table>
					<table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="8" style="text-align: center; padding-top: 10px; padding-bottom: 10px;"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="width:50%;" class="text-center"><label>Submission Date</label></td>
								<?php if(isset($weeklyVPD)) { ?>
								<td class="text-center get_date"><?php if(isset($weeklyVPD)){ echo $current_date; } ?></td>
								<input type="hidden" id="editted_date" name="editted_date" value="<?php if(isset($weeklyVPD)){ echo date('d-m-Y',strtotime($weeklyVPD->editted_date)); } ?>">
								<?php } else{ ?>
								<td class="text-center get_date"><?php echo $current_date; ?> </td>
								<td<input type="hidden" name="submitted_date" value="<?php echo $current_date; ?>"></td>
								<?php } ?>
							</tr>
						</tbody>
					</table>
					<div class="row">
						<hr>
						<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
							<button style="background:#008d4c;" type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
							
							<button style="background:#008d4c;" type="submit" name="is_temp_saved" value="0" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit Form  </button>
							<button style="background: #008d4c;" class="btn btn-primary btn-md" type="reset">
								<i class="fa fa-repeat"></i> Reset Form 
							</button>
							<a href="<?php echo base_url(); ?>Disease-Surveillance/List" style="background: #008d4c" class="btn btn-primary btn-md">
								<i class="fa fa-times"></i> Cancel 
							</a>
						</div>
					</div>
				</form>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--end of body container-->
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>includes/css/bootstrap-multiselect.css" type="text/css"/>
<script src="<?php echo base_url(); ?>includes/js/moment.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#other").on('change',function(){
			if(this.checked){
			    $('#other_rep').attr('readonly',false);
				$('#other_rep').attr('placeholder',"Enter Clinical Representation of the Case");
			}
			else{
				$('#other_rep').val('');
				$('#other_rep').attr('placeholder',"");
				$('#other_rep').attr('readonly','readonly');
				
				
			}
		});
		
       
		<?php if(isset($weeklyVPD)){ ?>
		var selected = '<?php echo $weeklyVPD->outcomes; ?>';
			if (selected == 'Complication') {  
					$('#complication_type').css('display', 'block');
					$('#death_date').css('display', 'none');
				}
			if (selected == 'Died') { 
					$('#complication_type').css('display', 'none');
					//$('#recovered_date').css('display', 'none');
					$('#death_date').css('display', 'block'); 			
				}
		<?php  } ?>
	$("#outcomes").bind('change', function(){
		var selected = $(this).val();
    
			if (selected == 'Complication') {  
					$('#complication_type').css('display', 'block');
					$('#death_date').css('display', 'none');
					
				}
			if (selected == 'Died') { 
					$('#complication_type').css('display', 'none');
					//$('#recovered_date').css('display', 'none');
					$('#death_date').css('display', 'block'); 			
				}
			if (selected == 'Partialy Recovered') { 
					$('#complication_type').css('display', 'none');
					$('#death_date').css('display', 'none');		
				}
			if (selected == 'Fully Recovered') { 
					$('#complication_type').css('display', 'none');
					$('#death_date').css('display', 'none');		
				}
			if (selected == '0') {  
					$('#complication_type').css('display', 'none');
					$('#death_date').css('display', 'none');
					
				}
	
   
    //etc ...
	});
		$( ".datefrom" ).datepicker({ minDate: -20, maxDate: "+1M +10D" });
		var year = $("#year").val();
			$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeks',
					data:'year='+year,
					success: function(response){
						$('#week').html(response);
							document.getElementById("year").style.borderColor = "";
							$('#week').trigger("change");
					}
				});
		
		
		if($("input[name = 'case_reported']:checked").val()=='0'){
			$('.disabledclass').find('input, textarea, button, select').attr('disabled','disabled');
		}else{
			$('.disabledclass').find('input, textarea, button, select').attr('disabled',false);
		}
		$(document).on('change','#case_reported',function(){
			if($(this).val()=='0'){
				$('.disabledclass').find('input, textarea, button, select').attr('disabled','disabled');
			}else{
				$('.disabledclass').find('input, textarea, button, select').attr('disabled',false);
			}
		});
		
			
		
		var get_date = $('.get_date').text();
		$('#editted_date').val(get_date);
		
		$(document).on('change','#case_distcode',function(){
			$.ajax({
				type: "POST",
				data: "distcode="+$(this).val(),
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#case_tcode').html(result);
					if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
					{
						$('#case_tcode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
				}
			});
		});
		$(document).on('change','#case_tcode',function(){
			$.ajax({
				type: "POST",
				data: "tcode="+$(this).val(),
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC",
				success: function(result){
					$('#case_uncode').html(result);
					if( typeof selectedtcode !== 'undefined' && selectedtcode>0)
					{
						$('#case_uncode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
				}
			});
		});
		$(document).on('change','#case_representation',function(){
			if($(this).val()=='1000'){
				$('#other_case_representation').removeClass('hide');
			}else{
				$('#other_case_representation').addClass('hide');
			}
		});
		$("#case_father_nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only
		/*if ($('[name="complication_follow"]:checked').val() === "No") {
			$(".complication_type").hide();
		}
		var case_type = $(".case_type :selected").val();
		 if (case_type !="AFP") {
			$(".epid_no").hide();
			$(".epid_no").val(''); 
		} */
		/* if ($('[name="complication_follow"]:checked').val() === "No") {
			$(".complication_type").hide();
		}
		if ($('[name="death_follow"]:checked').val() === "No") {
			$(".death_date").hide();
		}
		var weeklyvpd= "<?php echo isset($weeklyVPD); ?>";
	    if(weeklyvpd!=1){
	     	$(".complication_type").hide();
	     	$(".death_date").hide();
	     	$(function() {
			    var $radios = $('input:radio[name=complication_follow],input:radio[name=death_follow]');
			    if($radios.is(':checked') === false) {
			        $radios.filter('[value=No]').prop('checked', true);
			    }
			});
	    }
	    $('[name="complication_follow"]').change(function () {
		    if ($('[name="complication_follow"]:checked').val() === "Yes") {
			    $('.complication_type').show();
			}
			else {
				$('.complication_type').hide();
				$('#complication_type').val('');
			}
		});
		$('[name="death_follow"]').change(function () {
		    if ($('[name="death_follow"]:checked').val() === "Yes") {
			    $('.death_date').show();
			}
			else {
				$('.death_date').hide();
				$('#death_date_follow').val('');
			}
		}); */
		$(document).on('change','#year',function(){
		var year = $("#year").val();
		if(year == ""){
			$("#week").html("");
			$('#datefrom').val("");
			$('#dateto').val("");
		}else{
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeks',
				data:'year='+year,
				success: function(response){
					if(response == 1){
						var curr_year = new Date().getFullYear(); //Exchange year with current year.
						document.getElementById("year").style.borderColor = "red";
						alert("Year is restricted to current and previouse!");
						$.ajax({
							type: 'POST',
							url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeks',
							data:'year='+curr_year,
							success: function(response){
								$('#week').html(response);
								$('#year').val(curr_year);
								document.getElementById("year").style.borderColor = "";
								$('#week').trigger("change");
							}
						});
					}else{
						$('#week').html(response);
						document.getElementById("year").style.borderColor = "";
						$('#week').trigger("change");
						}
					}
				});
			}
		});
		$(document).on('change','#week',function(){
			var week = $("#week").val();
			var year = $('#year').val();
			if(week == 0 && year !=""){
				$('#datefrom').val("");
				$('#dateto').val("");
			}else{
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksDates', 
					data:'epiweek='+week+'&year='+year,
					success: function(response){
						var obj = JSON.parse(response);
							$('#datefrom').val(obj.startDate);
							$('#dateto').val(obj.EndDate);
					}
				});
			}
		});
		
		$(document).on('change','.datefrom',function(){
		var week = $("#epi_week").val();
		var date_from = $(this).val();
		var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/get_idsWeeks', 
				data:'date_from='+date_from+'&year='+year,
				success: function(response){
					//var obj = JSON.parse(response);
					$('#week').html(response);
					$('#week').trigger("change");
				
				}
			});
	});
		$(document).on('change','.dateto',function(){
		var week = $("#epi_week").val();
		var date_to = $(this).val();
		var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/get_idsWeeks', 
				data:'date_to='+date_to+'&year='+year,
				success: function(response){
					//var obj = JSON.parse(response);
					$('#week').html(response);
					$('#week').trigger("change");
				}
			});
	});
		$(document).on('change','.case_type',function(){
			var year = $('#year').val();
			var case_type = $(".case_type :selected").val();
			var short_code = $('#distCode').text();
			/* if(case_type=="AFP"){
				$('.epid_no').show();
				$.ajax({
				type: 'POST',
				data: "year="+year+"&case_type="+case_type+"&short_code="+short_code,
				dataType: 'json',
				url: '<?php echo base_url();?>Ajax_calls/getepi_number',
				success: function(data){
					$('#a1').text(data[0]);
					$('#a2').text(data[1]);
					$('#a3').text(data[2]);
					$('#a4').text(data[3]); 
					var epid_text = $('#epid_text').text();
					epid_text1 = epid_text.replace(/\s/g, '')
					epid_text2 =epid_text1.split('/');
					var dist_shortcode=epid_text2[2];
					var case_code=epid_text2[4];
					$('#epi_number').val(case_code);
					$('#dist_shortcode').val(dist_shortcode);
					$('#epi_no').val(epid_text1);
					//alert(epid_text1);
				}
			});
			}else{
				$('.epid_no').hide();
			} */
			var case_type = $(this).val();
			if(case_type!= '-Select-'){
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getcase_definition',
					data:'case_type='+$(this).val(),
					success: function(data){
						if(case_type == 'Diphtheria' || case_type == 'Leishmaniosis'){
							$("#case_representation").multiselect('destroy');
							document.getElementById("case_representation").setAttribute("multiple", "multiple"); 
							$('#case_representation').html(data);
							$('#case_representation').multiselect({
								includeSelectAllOption: true,
								buttonClass: 'form-control',
								buttonWidth: '311px'// here you need to specify width value
							});
							$('#case_representation').multiselect('rebuild');
						}else{
							var spans = $('span.hide-native-select');
							spans.contents().unwrap();
							$('#case_representation').html(data);
							$('.btn-group').remove();
							document.getElementById("case_representation").removeAttribute("multiple"); 
						}
					}
					
				});
			}
			else{
				$('#case_representation').html('');
			}
			$('#show_year').text(year);
			$('#case_type_shortcode').text(case_type);
		});
	});
	function getdate() {
		//adding 60 days to the date.
		var tt = $("#case_date_onset").val(); 
			tt= moment(tt, "DD-MM-YYYY").format("MM/DD/YYYY");
		var date = new Date(tt);
		var newdate = new Date(date);
			newdate.setDate(newdate.getDate() + 60);
		var dd = newdate.getDate();
		var mm = newdate.getMonth() + 1;
		var y = newdate.getFullYear();
		var someFormattedDate = dd + '-' + mm + '-' + y;
			someFormattedDate= moment(someFormattedDate, "DD-MM-YYYY").format("DD-MM-YYYY");
		$('#case_date_follow').val(someFormattedDate);
	}
	
	$(document).ready(function(){
		

	    $("#case_date_onset").datepicker({
	        todayBtn:  1,
	        autoclose: true,
	        format: 'dd-mm-yyyy',
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
			$('#case_date_investigation').datepicker('setStartDate', minDate);
			$('#case_date_last_dose_received').datepicker('setStartDate', minDate);
			$('#case_date_specieman').datepicker('setStartDate', minDate);
			$('#case_date_follow').datepicker('setStartDate', minDate);
	    });

	    $("#case_date_investigation").datepicker({ format: 'dd-mm-yyyy' })
	        .on('changeDate', function (selected) {
	            var minDate = new Date(selected.date.valueOf());
	            $('#case_date_onset').datepicker('setEndDate', minDate);
	        });
		$("#case_date_last_dose_received").datepicker({ format: 'dd-mm-yyyy' })
	        .on('changeDate', function (selected) {
	            var minDate = new Date(selected.date.valueOf());
	            $('#case_date_onset').datepicker('setEndDate', minDate);
	        });
		$("#case_date_specieman").datepicker({ format: 'dd-mm-yyyy' })
	        .on('changeDate', function (selected) {
	            var minDate = new Date(selected.date.valueOf());
	            $('#case_date_onset').datepicker('setEndDate', minDate);
	        });
		$("#case_date_follow").datepicker({ format: 'dd-mm-yyyy' })
	        .on('changeDate', function (selected) {
	            var minDate = new Date(getdate());
	            $('#case_date_onset').datepicker('setEndDate', minDate);
	        });
	});
	////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
</script>