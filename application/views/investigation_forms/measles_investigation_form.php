<!--start of page content or body-->
<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('d-m-Y');
	//print_r($measles_Result);exit();
	if(isset($measles_Result))
	{
		$startDate = date('d-m-Y',strtotime($measles_Result->datefrom));
		$endDate = date('d-m-Y',strtotime($measles_Result->dateto));
		//echo $startDate.' -- '.$endDate;exit();
	}
	$districtCode = $this -> session -> District;
	$query = "SELECT epid_code from districts where distcode='{$districtCode}'";
	$result = $this -> db -> query($query);
	$result = $result -> row_array();
	$epid_code = $result['epid_code'];
	//$fourdigit_number = sprintf('%04u', ($result['case_number'] + 1)); 
?>
<div class="container bodycontainer">
	<div class="row">
 		<div class="panel panel-primary">
 			<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
	   	<div class="panel-heading"><?php if(isset($measles_Result)){?> Update Measles Investigation Form <?php }else{ ?> Add Measles Investigation Form <?php } ?>
	   		<?php if(!isset($measles_Result)){ ?>
				<div style="display: inline-block;float: right;">
					<span style="font-size: 15px;color:#F0FF00;">Cross Notify</span>&nbsp;&nbsp;
					<input id="cb_cross_notified" style="display: inline-block;float: right;margin-top: 9px;" type="checkbox">
				</div>
	   		<?php } ?>
   		</div>
     		<div class="panel-body">
      		<form class="form-horizontal" id="measles" onsubmit="return confirm('Are you sure you want to save/submit this form?')" action="<?php echo base_url(); ?>Measles_investigation/measles_investigation_save" method="post">
	   			<?php if(isset($measles_Result)){ ?>
          			<input type="hidden" name="edit" id="edit" value="edit" />
          			<input type="hidden" name="id" id="id" value="<?php echo $measles_Result->id; ?>" />
         	 	<?php if($measles_Result->cross_notified==1){echo '<input type="hidden" id="cross_notified" name="cross_notified" value="1" />';} ?>
        			<?php }else{ ?>
					<input type="hidden" id="cross_notified" name="cross_notified" />
					<?php } ?>
					<?php if(isset($measles_Result->rb_distcode) && $measles_Result->rb_distcode>0 && $measles_Result-> cross_notified == 1 ){ ?>	
					<table id="rb_info" class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Case Refering Facility Information</th>
							</tr>
						</thead>
						<tbody>           
							<tr>
								<td><p>Province/Area <span style="color:red;">*</span></p></td>
								<td><p><?php echo $this -> session -> provincename ?></p></td>
								<td><p>District <span style="color:red;">*</span></p></td>
								<td>
									<input type="hidden" id="rb_distcode" required="required" name="rb_distcode" value="<?php $distcode = (isset($measles_Result))?$measles_Result->rb_distcode:$this -> session -> District;  echo $distcode; ?>">
									<p><?php echo get_District_Name($measles_Result->rb_distcode); ?></p>
								</td>            
							</tr>
							<tr>
								<td><p>Tehsil/City <span style="color:red;">*</span></p></td>
								<td>
									<select id="rb_tcode" required="required" name="rb_tcode" class="form-control">
									<?php if(isset($measles_Result) && $measles_Result -> rb_tcode != ""){ ?>
									<option value="<?php echo $measles_Result -> rb_tcode; ?>"><?php echo get_Tehsil_Name($measles_Result -> rb_tcode); ?></option>
									<?php }else{ ?> 
									<?php getTehsils_options(false); } ?>
									</select>
								</td>
								<td><p>Union Council <span style="color:red;">*</span></p></td>
								<input id="module" type="hidden" value="disease_surveillance">
								<td>
									<select id="rb_uncode" required="required" name="rb_uncode" class="form-control">
										<?php if(isset($measles_Result)){ ?>
										<option value="<?php echo $measles_Result->rb_uncode; ?>" <?php if(validation_errors() != false) { echo set_select('rb_uncode',$measles_Result->rb_uncode); }?> > <?php echo get_UC_Name($measles_Result->rb_uncode); ?> </option>
										<?php }else{} ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><p>Name of Reporting Health Facility <span style="color:red;">*</span></p></td>
								<td>
									<?php if(isset($measles_Result)){ ?>
									<select class="form-control" required="required" name="rb_facode" id="rb_facode">
									<option value="<?php echo $measles_Result->rb_facode; ?>"><?php echo $rbfacility; ?></option>
									</select>	
									<?php }else{ ?>
									<select class="form-control" required name="rb_facode" id="rb_facode"></select>
									<?php } ?>
								</td>
								<td><p>Address of Health Facility <span style="color:red;">*</span></p></td>
								<td><input class="form-control" name="rb_faddress" id="rb_faddress" value="<?php if(isset($measles_Result)){ echo $measles_Result->rb_faddress; } ?>" type="text"></td>
							</tr>
						</tbody>
					</table>
				<?php } else { ?>
					<table id="rb_info" class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass hide">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Case Refering Facility Information</th>
							</tr>
						</thead>
						<tbody>           
							<tr>
								<td><p>Province/Area <span style="color:red;">*</span></p></td>
								<td><p><?php echo $this -> session -> provincename ?></p></td>
								<td><p>District <span style="color:red;">*</span></p></td>
								<td>
									<input type="hidden" id="rb_distcode" name="rb_distcode" value="<?php $distcode = (isset($measles_Result))?$measles_Result->rb_distcode:$this -> session -> District;  echo $distcode; ?>">
									<p><?php echo get_District_Name($this->session->District); ?></p>
								</td>            
							</tr>
							<tr>
								<td><p>Tehsil/City <span style="color:red;">*</span></p></td>
								<td>
									<select id="rb_tcode" name="rb_tcode" class="form-control">
										<?php if(isset($measles_Result) && $measles_Result -> rb_tcode != ""){ ?>
										<option value="<?php echo $measles_Result -> rb_tcode; ?>"><?php echo getTehsils_options(false,$measles_Result -> rb_tcode); ?></option>
										<?php }else{ ?> 
										<?php getTehsils_options(false); } ?>
									</select>
								</td>
								<td><p>Union Council <span style="color:red;">*</span></p></td>
								<input id="module" type="hidden" value="disease_surveillance">
								<td>
									<select id="rb_uncode" name="rb_uncode" class="form-control">
										<?php if(isset($measles_Result) && $measles_Result->rb_uncode != " "){ getUCs(false,$measles_Result->rb_uncode); }else{ ?>
										<?php getUCs_options(false); } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><p>Name of Reporting Health Facility <span style="color:red;">*</span></p></td>
								<td>
									<?php if(isset($measles_Result)){ ?>
									<select class="form-control" name="rb_facode" id="rb_facode">
										<option value="<?php echo $measles_Result->rb_facode; ?>"><?php echo $facility; ?></option>
									</select>
									<?php }else{ ?>
									<select class="form-control" required name="rb_facode" id="rb_facode"></select>
									<?php } ?>
								</td>
								<td><p>Address of Health Facility <span style="color:red;">*</span></p></td>
								<td><input class="form-control" name="rb_faddress" id="rb_faddress" value="<?php if(isset($measles_Result)){ echo $measles_Result->rb_faddress; } ?>" type="text"></td>
							</tr>
						</tbody>
					</table>
				<?php } ?>

        			<table class="table table-bordered   table-striped table-hover mytable2 mytable3">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">PART I : For Use by the case Investigator/Reporting Health Facility</th>
							</tr>
						</thead>
						<tbody>           
							<tr class="crossNotify">
								<td><p>Province/Area <span style="color:red;">*</span></p></td>
								<td><p><?php echo $this -> session -> provincename ?></p></td>
								<td><p>District <span style="color:red;">*</span></p></td>
								<td id="districttd">
									<input type="hidden" id="distcode" name="distcode" value="<?php $distcode = (isset($measles_Result))?$measles_Result->distcode:$this -> session -> District; echo $distcode; ?>">
									<p><?php echo get_District_Name($distcode); ?></p>
								</td>
							</tr>
							<tr class="crossNotify">
								<td><p>Tehsil/City <span style="color:red;">*</span></p></td>
								<td>
									<?php if(isset($measles_Result)){ ?>
										<select class="form-control" name="tcode" id="tcode" required="required">
											<option value="<?php echo $measles_Result->tcode; ?>"><?php echo $tehsil; ?></option>
											</select>
											<?php }else{ ?>
										<select class="form-control" name="tcode" id="tcode" required="required"></select>
									<?php } ?>
								</td>
								<td><p>Union Council <span style="color:red;">*</span></p></td>
								<input id="module" type="hidden" value="disease_surveillance">
								<td>
								    
									<?php if(isset($measles_Result)){ ?>
										<select class="form-control" required="required" name="uncode" id="uncode">
											<option value="<?php echo $measles_Result->uncode; ?>"><?php echo $unioncouncil; ?></option>
										</select>
									<?php }else{ ?>
										<select class="form-control" name="uncode" id="uncode"></select>
									<?php } ?>
								</td>
							</tr>
							<?php if(isset($measles_Result) && $measles_Result->cross_notified == 1 && $measles_Result -> cross_notified_from_distcode == $this -> session -> District){}else{ ?>
							<tr id="healthFacilityTr">
								<td><p>Name of Reporting Health Facility <span style="color:red;">*</span></p></td>
								<td>
									<?php if(isset($measles_Result)){ ?>
										<select class="form-control facodecase" required="required" name="facode" id="facode">
											<option value="<?php echo $measles_Result->facode; ?>"><?php echo $facility; ?></option>
										</select>
									<?php }else{ ?>
										<select class="form-control" required name="facode" id="facode"></select>
									<?php } ?>
								</td>
								<td><p>Address of Health Facility <span style="color:red;">*</span></p></td>
								<td><input class="form-control" name="faddress" id="faddress" value="<?php if(isset($measles_Result)){ echo $measles_Result->faddress; } ?>" type="text"></td>
							</tr>
							<?php } ?>
							<tr>
								<td><p>Year <span style="color:red;">*</span></p></td>
								<td>
									<select class="form-control text-center" required="required" name="year" id="year">
										<?php if(isset($measles_Result)){ ?>
										<option value="<?php echo $measles_Result->year; ?>"><?php echo $measles_Result->year; ?></option>
										<?php }else{ ?>
										<?php echo $years; } ?>
									</select>
								</td>
								<td><p>EPI Week No <span style="color:red;">*</span></p></td>
								<td>
									<select class="form-control" required="required"  name="week" id="week">
										<?php if(isset($measles_Result)){ ?>
										<option value="<?php echo sprintf("%02d",$measles_Result->week); ?>">Week <?php echo sprintf("%02d",$measles_Result->week); ?></option>
										<?php }else{ ?>
										<option>--Select Week No--</option>
										<?php } ?>
									</select>
								</td>
							</tr>
            				<tr>
								<td><p>Date From <span style="color:red;">*</span></p></td>
								<td><input class="form-control text-center" readonly="readonly" name="datefrom" id="datefrom" value="<?php if(isset($measles_Result)){ echo date('d-M-Y',strtotime($measles_Result->datefrom)); }?>"  placeholder="From" type="text"></td>
								<td><p>Date To <span style="color:red;">*</span></p></td>
								<td><input class="form-control text-center" readonly="readonly" name="dateto" id="dateto" value="<?php if(isset($measles_Result)){ echo date('d-M-Y',strtotime($measles_Result->dateto)); }?>" placeholder="To" type="text"></td>
							</tr>
            			<tr>								
								<td><p>Date Patient Visited Hospital <span style="color:red;">*</span></p></td>
								<td class="disabledclass"><input class="dp form-control" required="required" name="pvh_date" id="pvh_date" value="<?php if(isset($measles_Result)){ if($measles_Result->pvh_date!= '1969-12-31' && $measles_Result->pvh_date!= '1970-01-01' && $measles_Result->pvh_date!= NULL){ echo date('d-m-Y',strtotime($measles_Result->pvh_date)); }else{ echo ''; } } ?>"  type="text"></td>
								
								<td><label>Type of Case <span style="color:red;">*</span></label></td>
								<td>
									<select class="form-control case_type" name="case_type" id="cases" required="required">
									<?php echo (isset($measles_Result) && $measles_Result->case_type != '')?'':'<option value="">--Select--</option>'; ?>
									<?php echo (isset($measles_Result))?getMeaslesCaseTypes(true,$measles_Result->case_type):getMeaslesCaseTypes(false); ?>
									</select>
								</td>							
							</tr>
							<?php if(isset($measles_Result) && $measles_Result->cross_notified == 1 && $measles_Result -> cross_notified_from_distcode == $this -> session -> District){}else{ ?>			
							<tr id="epidNumberTR">
								<td colspan="4">
									<table class="disabledclass">
										<tbody>
											<tr>
												<td style="width: 25%;"><label style="margin-top: 7px;">EPID Number</label></td>
												<td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">PAK</label></td>
												<td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">/</label></td>
												<td style="text-align: center; width: 1%;"><label style="margin-top: 7px;"><?php echo $_SESSION["shortname"]; ?></label></td>
												<td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">/</label></td>                    
												<td style="text-align: center; width: 3%;"><input type="hidden" name="dcode" id="dcode" value="<?php if(isset($distCode)){ echo $distCode; } ?>" /><label class="epid_code" style="margin-top: 7px;"><?php if(isset($distCode)){ echo $distCode; } ?></label></td>                   
												<td style="width: 12%;">
													<select name="epid_year" id="epid_year" class="form-control text-center epid_year" readonly>
														<?php if(isset($measles_Result) && $measles_Result->epid_year != ''){ ?>
														<option value="<?php echo $measles_Result -> epid_year; ?>"><?php echo $measles_Result -> epid_year; ?></option>
														<?php }else{} //getAllYearsOptionsIncludingCurrent(false); 	 ?> 
													</select>
												</td>
												<?php if(isset($measles_Result) && $measles_Result->case_type != '' && $measles_Result->facode != '') { ?>
													<td style="text-align: center; width: 3%;" id="case_code"><label><?php echo $measles_Result -> case_type; ?></label></td> 
													<?php } else { ?>
												<td style="text-align: center; width: 3%;" id="case_code"><label>***</label></td>
												<?php } ?> 
												<td style="width: 4%;"><input class="form-control numberclass" name="a1" id="a1" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[0]; } ?>" type="text" readonly></td>
												<td style="width: 4%;"><input class="form-control numberclass" name="a2" id="a2" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[1]; } ?>" type="text" readonly></td>
												<td style="width: 4%;"><input class="form-control numberclass" name="a3" id="a3" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[2]; } ?>" type="text" readonly></td>
												<td style="width: 4%;"><input class="form-control numberclass" name="a4" id="a4" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[3]; } ?>" type="text" readonly></td>												
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<?php } ?>							
							<tr>
								<td><p>Patient's Name <span style="color:red;">*</span></p></td>
								<td class="disabledclass"><input class="form-control" required="required" name="patient_name" id="patient_name" value="<?php if(isset($measles_Result)){ echo $measles_Result->patient_name; } ?>" type="text"></td>
								<td><p>Gender</p></td>
								<td class="disabledclass"> 
									Male <input type="radio" id="patient_gender" <?php if(!isset($measles_Result)){ echo 'checked="checked"'; } ?> name="patient_gender" <?php if(isset($measles_Result) && $measles_Result->patient_gender == '1'){ echo 'checked="checked"'; } ?> value="1" >
									Female <input type="radio" id="patient_gender" name="patient_gender" <?php echo (isset($measles_Result) && $measles_Result->patient_gender == 0)?'checked="checked"':''; ?> value="0" >
								</td>
							</tr>
							<tr>
								<td><p>Father's Name <span style="color:red;">*</span></p></td>
								<td class="disabledclass"><input class=" form-control" name="patient_fathername" id="patient_fathername" value="<?php if(isset($measles_Result)){ echo $measles_Result->patient_fathername; } ?>" type="text"></td>
								<td><p>Contact Number</p></td>
								<td class="disabledclass"><input class="numberclass form-control" name="contact_numb" id="contact_numb" value="<?php if(isset($measles_Result)){ echo $measles_Result->contact_numb; } ?>" type="text"></td>
							<tr>
							<td><p>Date of Birth <span style="color:red;">*</span></p></td>
								<td class="disabledclass"><input class="dp form-control" onchange="ageCalculater(this.value);" name="patient_dob" id="patient_dob" readonly="readonly" value="<?php if(isset($measles_Result)){ if($measles_Result->patient_dob!= '1969-12-31' && $measles_Result->patient_dob!= NULL){ echo date('d-m-Y',strtotime($measles_Result->patient_dob)); }else{ echo ''; } } ?>" type="text"></td>
								<td><p>Age in Months</p></td>
								<td class="disabledclass"><input class="numberclass form-control" required="required" onkeypress="return !(event.charCode == 46)" name="age_months" id="age_months" value="<?php if(isset($measles_Result)){ echo $measles_Result->age_months; } ?>" type="text"></td>
							</tr>
            		</tbody>
      			</table>
      			<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Address of Patient</th>
							</tr>
						</thead>
						<tbody>						
							<tr class="otherProvinceAddress">	
								<td><p>Province <span style="color:red;">*</span></p></td>
								<td>
									<select name="procode" id="other_procode" class="form-control allprocodes" required="required">
										
									</select>
								</td>
								<td><p>District <span style="color:red;">*</span></p></td>
								<td>									
									<select name="patient_address_distcode" id="other_pro_district" class="otherprocode form-control hide">										
									</select>

									<select name="patient_address_distcode" id="other_pro_distcode" class="procodekp form-control hide">
										<option selected="selected" value="">--Select--</option>
										<?php getDistricts_options(false,NULL,'Yes'); ?>
									</select>
								</td>
							</tr>
							<tr class="otherProvinceAddress">	
								<td><p>Tehsil/City <span style="color:red;">*</span></p></td>
								<td>									
									<select name="patient_address_tcode" id="other_pro_tehsil" class="otherprocode form-control hide">										
									</select>

									<select name="patient_address_tcode" id="other_pro_tcode" class="procodekp form-control hide">										
									</select>
								</td>
								<td><p>UC <span style="color:red;">*</span></p></td>
								<td>									
									<select name="patient_address_uncode" id="other_pro_uc" class="otherprocode form-control hide">										
									</select>

									<select name="patient_address_uncode" id="other_pro_uncode" class="procodekp form-control hide">										
									</select>
								</td>
							</tr>
							<tr id='patient1stTr' class="crossNotify">
								<td><p>Province/Area <span style="color:red;">*</span></p></td>
								<td>
									<p><?php echo $this -> session -> provincename ?></p>
									<input class="form-control" name="patient_address_procode"  readonly="readonly" id="patient_address_procode" placeholder="Khyber Pakhtunkhwa" type="hidden">
								</td>
								<td><p>District <span style="color:red;">*</span></p></td>
								<td id="patientDistcodeTd">
									<select id="patient_address_distcode" name="patient_address_distcode" class="form-control">
										<?php if(isset($measles_Result) && $measles_Result -> patient_address_distcode > 0){ ?>
										<option value="<?php echo $measles_Result -> patient_address_distcode; ?>"><?php echo getDistricts_options(false,$measles_Result -> patient_address_distcode,'No'); ?></option>
										<?php }else{ ?>
										<?php echo getDistricts_options(false,$distcode,'No'); ?>
										<?php } ?>
									</select>
								</td>            
							</tr>
							<tr id='patient2ndTr' class="crossNotify">
								<td><p>Tehsil/City <span style="color:red;">*</span></p></td>
								<td>									
									<select id="patient_address_tcode" name="patient_address_tcode" class="form-control" readonly>
										<?php if(isset($measles_Result) && $measles_Result -> patient_address_tcode > 0){ ?>
										<option value="<?php echo $measles_Result -> patient_address_tcode; ?>"><?php echo getTehsils_options(false,$measles_Result -> patient_address_tcode,$measles_Result -> patient_address_distcode); ?></option>
										<?php }else{ ?> 
										<?php getTehsils_options(false); } ?>
									</select>									
								</td>
								<td><p>Union Council <span style="color:red;">*</span></p></td>
								<td>
								<select id="patient_address_uncode" name="patient_address_uncode" class="form-control" readonly>
								<?php if(isset($measles_Result) && $measles_Result->patient_address_uncode > 0){ echo getUCs(false,$measles_Result->patient_address_uncode,$measles_Result -> patient_address_tcode); }else{ ?>
								<?php getUCs_options(false); } ?>
								</select></td>
							</tr>						
							<tr>
								<td><p>Village / Street / Mohallah <span style="color:red;">*</span></p></td>
								<td colspan="3"><input class=" form-control" name="patient_address" id="patient_address" value="<?php if(isset($measles_Result)){ echo $measles_Result->patient_address; } ?>" type="text"></td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Disease Information</th>
							</tr>
						</thead>
						<tbody>							
							<tr>
								<td><p>Clinical Representation</p></td> 
								<td>
									<!-- <input class="form-control text-center" readonly="readonly" name="clinical_representation" id="case_representation" value="<?php //if(isset($measles_Result)){ echo ($measles_Result->clinical_representation); } ?>" type="text"> -->
									<?php
									$chklist=array();
									if(isset($measles_Result))
									{
										$chklist= explode(',', $measles_Result ->clinical_representation); 
									}?>										
									<select id="case_representation" name="clinical_representation[]" class="form-control text-center">						
									 <?php  
										if(isset($measles_Result)){ 
										  foreach($chklist as $row){              
												echo $row; ?>
										<option value="<?php echo $row; ?>"><?php echo ($row=='999')?'NA':(($row=='1000')?'Other':get_CaseRepresentation_Value($row)); ?></option>
										  <?php }  } ?>
									</select>
								</td>
								<td><label class="pt7">Other</label><input type="checkbox" id="other"  />
								</td>
								<td>
									<input type="text" id="other_rep" readonly  name="other_case_representation" size="35" class="form-control text-left" col span="2" value ="<?php if(isset($measles_Result ->other_case_representation)) { echo $measles_Result->other_case_representation;} ?>" />
								</td>
							</tr>
							<tr>
								<td><p>Complications</p></td> 
								<td>
									<select name="complications" id="complications" class="form-control">
										<!-- <option value="">--Select Complication--</option> -->
										<option <?php echo (isset($measles_Result) && $measles_Result->complications == 'No')?'selected="selected"':''; ?> value="No">Nil</option>
										<option <?php echo (isset($measles_Result) && $measles_Result->complications == 'Pneumonia')?'selected="selected"':''; ?> value="Pneumonia">Pneumonia</option>
										<option <?php echo (isset($measles_Result) && $measles_Result->complications == 'Diarrhea')?'selected="selected"':''; ?> value="Diarrhea">Diarrhea</option>
										<option <?php echo (isset($measles_Result) && $measles_Result->complications == 'Otitis Media')?'selected="selected"':''; ?> value="Otitis Media">Otitis Media</option>
										<option <?php echo (isset($measles_Result) && $measles_Result->complications == 'Corneal Scarring')?'selected="selected"':''; ?> value="Corneal Scarring">Corneal Scarring</option>
										<option <?php echo (isset($measles_Result) && $measles_Result->complications == 'Acute Malnutrition')?'selected="selected"':''; ?> value="Acute Malnutrition">Acute Malnutrition</option>
										<option <?php echo (isset($measles_Result) && $measles_Result->complications == 'Other')?'selected="selected"':''; ?> value="Other">Other</option>
									</select>
								</td>
								<td class="complicationbox hide"><p>Specify Other</p></td>
								<td class="complicationbox hide">
									<input class="form-control text-center" name="other_complication" id="other_complication" value="<?php if(isset($measles_Result) && isset($measles_Result->other_complication)){ echo ($measles_Result->other_complication); } else{ echo ""; }?>" type="text">
								</td>
							</tr>
							<tr>
								<td><p>Date of Rash onset</p></td>
								<td><input class="dp form-control"  name="date_rash_onset" id="date_rash_onset" value="<?php if(isset($measles_Result) && $measles_Result->date_rash_onset != NULL){ if($measles_Result->date_rash_onset!= '1969-12-31'){ echo date('d-m-Y',strtotime($measles_Result->date_rash_onset)); }else{ echo ''; } } ?>" type="text" required="required"></td>
								<td><p>Date of Notification</p></td>
								<td class="disabledclass"><input class="dp form-control" required="required" name="notification_date" id="notification_date" readonly="readonly" value="<?php if(isset($measles_Result)){ if($measles_Result->notification_date!= '1969-12-31' && $measles_Result->notification_date!= NULL){ echo date('d-m-Y',strtotime($measles_Result->notification_date)); }else{ echo ''; } } ?>"  type="text"></td>
				         </tr>
							<tr>
								<td><p>Date of Investigation</p></td>
								<td><input class="dp form-control" name="date_investigation" id="date_investigation" readonly="readonly" value="<?php if(isset($measles_Result) && $measles_Result->date_investigation != NULL){ if($measles_Result->date_investigation!= '1969-12-31'){ echo date('d-m-Y',strtotime($measles_Result->date_investigation)); }else{ echo ''; } } ?>" type="text"></td>
							</tr>
							<tr>
								<td><p>Number of vaccine doses received </p></td>
								<td>
									<select id="doses_received" name="doses_received" class="form-control text-center">
										<option <?php if(isset($measles_Result)){ if($measles_Result->doses_received  == "0"){ echo 'selected="selected"';} } ?> value="0">0</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->doses_received  == "1"){ echo 'selected="selected"';} } ?> value="1">1</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->doses_received  == "2"){ echo 'selected="selected"';} } ?> value="2">2</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->doses_received  == "99"){ echo 'selected="selected"';} } ?> value="99">>2</option>
									</select>
								</td>
								<td><p>Date of Last Dose of Vaccination</p></td>
								<td><input class="form-control" readonly="true"  name="last_dose_date" id="last_dose_date" readonly="readonly" value="<?php if(isset($measles_Result)){ if($measles_Result->last_dose_date!= '1969-12-31' && $measles_Result->last_dose_date != NULL){ echo date('d-m-Y',strtotime($measles_Result->last_dose_date)); }else{ echo ''; } } ?>" type="text"></td>
							</tr>
							<tr>
								<td id="withdays"><p>Travel history within 21 days prior to rash onset *</p></td>
								<td id="plain"><p>Travel history <span style="color:red;">*</span></p></td>
								<td>
									<select name="travel_history" id="travel_history" class="form-control" required="required">
										<option value="">--Select--</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->travel_history  == "1"){ echo 'selected="selected"';} } ?> value="1">Yes</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->travel_history  == "2"){ echo 'selected="selected"';} } ?> value="2">No</option>
									</select>
								</td>
								<td><p>Province</p></td>
								<td>
									<select name="th_procode" id="th_procode" class="form-control hide">
										<option value="">--Select--</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->th_procode == "1"){ echo 'selected="selected"';} } ?> value="1">Punjab</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->th_procode == "2"){ echo 'selected="selected"';} } ?> value="2">Sindh</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->th_procode == "3"){ echo 'selected="selected"';} } ?> value="3">Khyber Pakhtunkhwa</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->th_procode == "4"){ echo 'selected="selected"';} } ?> value="4">Balochistan</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->th_procode == "5"){ echo 'selected="selected"';} } ?> value="5">AJK</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->th_procode == "8"){ echo 'selected="selected"';} } ?> value="8">FATA</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->th_procode == "6"){ echo 'selected="selected"';} } ?> value="6">Gilgit Baltistan</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->th_procode == "7"){ echo 'selected="selected"';} } ?> value="7">Islamabad</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><p>District</p></td>
								<td>
									<select name="th_distcode" id="th_district" class="otherprovince form-control hide">
										
									</select>

									<select name="th_distcode" id="th_distcode" class="kptravel_history form-control hide">
										<option selected="selected" value="">--Select--</option>
										<?php getDistricts_options(false,NULL,'Yes'); ?>
									</select>
								</td>
								<td><p>Tehsil/Town</p></td>
								<td>
									<select name="th_tcode" id="th_tehsil" class="otherprovince form-control hide">										
									</select>
									<select name="th_tcode" id="th_tcode" class="kptravel_history form-control hide">										
									</select>
								</td>
							</tr>
							<tr>
								<td><p>UC</p></td>
								<td>
									<select name="th_uncode" id="th_uc" class="otherprovince form-control hide">										
									</select>
									<select name="th_uncode" id="th_uncode" class="kptravel_history form-control hide">										
									</select>
								</td>
								<td><p>Village/Muhallah</p></td>
								<td>
									<input name="th_muhallah" id="th_muhallah" readonly="readonly" class="form-control" value="<?php if(isset($measles_Result) && isset($measles_Result->th_muhallah)){ echo ($measles_Result->th_muhallah); } else{ echo ""; }?>">
								</td>
							</tr>
							<tr>
								<td><p>Specimen Collected?</p></td>
				            	<td>
				            		<span>
				            			<input class="specimen_collected" type="radio" id="sc_yes" name="specimen_collected" value="1" style="cursor: pointer;"><span style="padding-left: 2px;">Yes</span>
				            		</span>
				            		<span style="padding-left: 10px;">
				            			<input class="specimen_collected" type="radio" id="sc_no" name="specimen_collected" value="0" style="cursor: pointer;" checked="checked"><span style="padding-left: 2px;">No</span>
				            		</span>
				            	</td>
							</tr>
							<tr>
								<td><p>Type of Specimen </p></td>
								<td>
									<select name="type_specimen[]" id="type_specimen" class="form-control">
										<!-- <option value="">--Select--</option> -->
										<option <?php if(isset($measles_Result)){ if($measles_Result->type_specimen == "Blood"){ echo 'selected="selected"'; } } ?> value="Blood">Blood</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->type_specimen == "Oral Swab"){ echo 'selected="selected"'; } } ?> value="Oral Swab">Oral Swab</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->type_specimen == "Throat Swab"){ echo 'selected="selected"'; } } ?> value="Throat Swab">Throat Swab</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->type_specimen == "Serum"){ echo 'selected="selected"'; } } ?> value="Serum">Serum</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->type_specimen == "Urine"){ echo 'selected="selected"'; } } ?> value="Urine">Urine</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->type_specimen == "Oral Fluid"){ echo 'selected="selected"'; } } ?> value="Oral Fluid">Oral Fluid</option>
										<!-- <option <?php //if(isset($measles_Result)){ if($measles_Result->type_specimen  == "Other"){ echo 'selected="selected"'; } } ?> value="Other">Other</option>
										<option <?php //if(isset($measles_Result)){ if($measles_Result->type_specimen  == "None"){ echo 'selected="selected"'; } } ?> value="None">Not Collected</option> -->
									</select>
								</td>
								<!-- <td class="other_specimen"><p>Other Specimen Type</p></td>
								<td>
									<input class="form-control other_specimen" name="other_specimen" id="other_specimen" value="<?php if(isset($measles_Result)){ echo $measles_Result->other_specimen; } ?>" type="text">
								</td> -->
								<td class="specimen_adequate"><p>Specimen Quantity Adequate</p></td>
				            	<td class="specimen_adequate">
				            		<span>
				            			<input class="specimen_quantity_adequate" type="radio" id="sqa_yes" name="specimen_quantity_adequate" value="1" style="cursor: pointer;"><span style="padding-left: 2px;">Yes</span>
				            		</span>
				            		<span style="padding-left: 10px;">
				            			<input class="specimen_quantity_adequate" type="radio" id="sqa_no" name="specimen_quantity_adequate" value="2" style="cursor: pointer;"><span style="padding-left: 2px;">No</span>
				            		</span>
				            	</td>
							</tr>
							<tr>
								<td class="final_classification"><p>Final Classification <span style="color:red;"></span></p>
								</td>
								<td>
									<select name="final_classification" id="final_classification" class="form-control final_classification">
										<option value="">--Select--</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->final_classification == "Clinically Compatible"){ echo 'selected="selected"'; } } ?> value="Clinically Compatible">Clinically Compatible</option>	
										<option <?php if(isset($measles_Result)){ if($measles_Result->final_classification == "Epi Linked"){ echo 'selected="selected"'; } } ?> value="Epi Linked">Epi Linked</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->final_classification == "Discarded"){ echo 'selected="selected"'; } } ?> value="Discarded">Discarded Case</option>
									</select>
								</td>
								<td class="linked_epid_number"><p>Linked EPID Number</p></td>
								<td class="linked_epid_number">
									<input name="linked_epid_number" id="linked_epid_number" class="form-control linked_epid_number" value="<?php if(isset($measles_Result) && isset($measles_Result->linked_epid_number)){ echo ($measles_Result->linked_epid_number); } else{ echo ""; }?>" placeholder="PAK/KP/<?php echo $epid_code; ?>/<?php echo date('Y'); ?>/Msl/1234" style="width: 70%; height: 37px; display: inline;">
									<span id="site_response"></span>
									<span style="position: relative;top: -2px;background: #008d4c;" id="Ok11" class="btn btn-primary btn-md">Retrieve</span>
								</td>
								<td class="clinically_compatible_with"><p>Clinically Compatible with</p></td>
								<td class="clinically_compatible_with">
									<select name="clinically_compatible_with" id="clinically_compatible_with" class="form-control clinically_compatible_with">
										<option value="">--Select--</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->clinically_compatible_with == "Measles"){ echo 'selected="selected"'; } } ?> value="Measles">Measles</option>
										<option <?php if(isset($measles_Result)){ if($measles_Result->clinically_compatible_with == "Rubella"){ echo 'selected="selected"'; } } ?> value="Rubella">Rubella</option>
									</select>
								</td>
							</tr>
	<th colspan="6">
		<table id="noEpidNumber" style="width: 80%; margin: auto; margin-top: 10px; margin-bottom: 10px;">
			<th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px; background-color: #A8A8A8;"><strong>The EPID Number you entered is either invalid or does not exist!</strong>
			</th>			
		</table>
		<table id="caseInformation" style="width: 80%; margin: auto; margin-top: 10px; margin-bottom: 10px;">
			<th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px; background-color: #A8A8A8;"><strong>Information of Epi Linked Case</strong>
			</th>
			<tr>
				<td><p>Name</p></td>
				<td><input class="form-control" id="a" readonly="readonly" type="text"></td>
				<td><p>Test Result</p></td>
				<td><input class="form-control" id="b" readonly="readonly" type="text"></td>
			</tr>
			<tr>
				<td><p>Father Name</p></td>
				<td><input class="form-control" id="c" readonly="readonly" type="text"></td>
				<td><p>Gender</p></td>
				<td><input class="form-control" id="d" readonly="readonly" type="text"></td>
			</tr>
			<tr>				
				<td><p>Contact Number</p></td>
				<td><input class="form-control" id="e" readonly="readonly" type="text"></td>
				<td><p>Year-Week</p></td>
				<td><input class="form-control" id="f" readonly="readonly" type="text"></td>
			</tr>
			<tr>
				<td><p>District / Tehsil / UC</p></td>
				<td><input class="form-control" id="g" readonly="readonly" type="text"></td>
				<td><p>Village/Muhallah/Address</p></td>
				<td><input class="form-control" id="h" readonly="readonly" type="text"></td>
			</tr>
		</table>
	</th>
							<tr>								
								<td><p>Date of Specimen Collection</p></td>
								<td><input class="dp form-control noSpecimen" name="date_collection" id="date_collection" readonly="readonly" value="<?php if(isset($measles_Result)){ if($measles_Result->date_collection!= '1969-12-31' && $measles_Result->date_collection != NULL){ echo date('d-m-Y',strtotime($measles_Result->date_collection)); }else{ echo ''; } } ?>" type="text"></td>
							</tr>
							<tr>
								<td><p>Date of Specimen Sent to Lab</p></td>
								<td><input class="dp form-control noSpecimen" name="date_sent_lab" id="date_sent_lab" readonly="readonly" value="<?php if(isset($measles_Result) && $measles_Result->date_sent_lab != NULL){ if($measles_Result->date_sent_lab!= '1969-12-31'){ echo date('d-m-Y',strtotime($measles_Result->date_sent_lab)); }else{ echo ''; } } ?>" type="text"></td>
								<td><p>Lab result to be sent to <span style="color:red;">*</span></p></td>
								<td>District Health Officer									
									<select name="labresult_tobesentto_district" id="labresult_tobesentto_district" class="form-control hide noSpecimen">
										
									</select>
									<select name="labresult_tobesentto" id="labresult_tobesentto" class="form-control noSpecimen" required="required">
										<option value="">--Select District--</option>
										<?php if(isset($measles_Result) && $measles_Result->labresult_tobesentto  != ""){ ?>
											<?php getDistricts_options(false,$measles_Result->labresult_tobesentto,'Yes'); ?> 
										<?php }else{ ?>
											<?php getDistricts_options(false,NULL,'Yes'); ?>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><p>Investigator Name</p></td>
								<td>
									<input class="form-control" name="investigator_name" id="investigator_name" value="<?php if(isset($measles_Result)){ echo $measles_Result->investigator_name; } ?>" type="text">
								</td>
								<td><p>Designation</p></td>
								<td>
									<input class="form-control" name="investigator_designation" id="investigator_designation" value="<?php if(isset($measles_Result)){ echo $measles_Result->investigator_designation; } ?>" type="text">
								</td>
							</tr>
						</tbody>
     				</table>
     				
      			<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass" id="hideLabPart">
						<thead>
							<tr>
								<th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Part II: For use by receiving laboratory</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><p>Date Specimen Received at lab</p></td>
								<td><input class="dp form-control noSpecimen" name="specimen_received_date" id="specimen_received_date" readonly="readonly" type="text"></td>
								<!-- <td><p></p></td> -->
								<!-- <td><p>Condition of Specimen</p></td>
								<td><p></p></td> -->
							</tr>
							<tr>
					            <td><p style="display: inline-block;">Condition of Specimen</p><span style="float: right;">Quantity Adequate:</span></td>
					            <td style="padding-left: 50px;">
					            	<input class="noSpecimen" type="radio" id="qyes" name="quantity_adequate" value="1">Yes
					            </td>
					            <td>
					            	<input class="noSpecimen" type="radio" name="quantity_adequate" id="qno" value="2">No
					            </td>
					        </tr>
					        <tr>
					            <td><span style="float: right;">Cold Chain OK:</span></td>
					            <td style="padding-left: 50px;">
					            	<input type="radio" name="cold_chain_ok" id="ccyes" class="testpossible noSpecimen" value="1">Yes
					            </td>
					            <td>
					            	<input type="radio" name="cold_chain_ok" id="ccno" class="testpossible noSpecimen" value="2">No
					            </td>
					        </tr>
					        <tr id="lb">
					            <td><span style="float: right;">Leakage/Broken Container:</span></td>
					            <td style="padding-left: 50px;">
					            	<input class="noSpecimen" type="radio" name="leakage_broken" id="leekyes" value="1">Yes
					            </td>
					            <td>
					            	<input class="noSpecimen" type="radio" name="leakage_broken" id="leekno" value="2">No
					            </td>
					        </tr>
					        <tr id="itp">
					            <td><span style="float: right;">Test Possible:</span></td>
					            <td style="padding-left: 50px;">
					            	<input class="noSpecimen" type="radio" id="testyes" name="test_possible" value="1">Yes
					            </td>
					            <td>
					            	<input class="noSpecimen" type="radio" id="testno" name="test_possible" value="2">No
					            </td>
					        </tr>				         
							<tr>
								<td><p>Specimen Received by: Name</p></td>
								<td><input type="text" name="specimen_received_by" class="form-control testpossibleno noSpecimen" maxlength="30"></td>
								<!-- <td><p></p></td> -->
								<td><p>Designation</p></td>
								<td><input type="text" name="received_by_designation" class="form-control testpossibleno noSpecimen" maxlength="20"></td>
								<!-- <td><p></p></td> -->
							</tr>
							<tr>
								<td><p>Lab ID Number</p></td>
								<td><input type="text" name="lab_id_number" class="form-control testpossibleno noSpecimen" maxlength="25"></td>
								<!-- <td><p></p></td> -->
								<td><p>Date of Lab Test Done</p></td>
								<td><input type="text" name="lab_testdone_date" class="form-control dp testpossibleno noSpecimen" readonly="readonly"></td>
								<!-- <td><p></p></td> -->
							</tr>
							<tr>
								<td><p>Type of Specimen</p></td>
								<td>
									<select colspan="3" name="type_of_test" class="form-control testpossibleno othertype noSpecimen" id="other">
										<option value="">--Select--</option>
										<option value="Blood">Blood</option>
										<option value="Serum">Serum</option>
										<option value="Urine">Urine</option>
										<option value="Oral Fluid">Oral Fluid</option>
										<option value="Other">Other</option>
									</select>
								</td>
								<td><label>Other Specimen: </label></td>
								<td colspan="3" >
									<input type="text" id="other_specimen" class="form-control testpossibleno otherspecimen noSpecimen" name="other_specimen_lab" maxlength="30"> 
								</td>
							</tr>
							<tr>
								<td><p>Test Result</p></td>
								<td id="testInput" class="hide">
									<input type="text" class="form-control noSpecimen" maxlength="30" readonly="readonly"> 
								</td>
								<td id="mslmsl" class="hide">
									<select colspan="3" name="specimen_result" class="form-control testpossibleno othertest measles noSpecimen" id="other">
										<option value="">--Select--</option>
										<option value="Positive Measles">Positive Measles</option>
										<option value="Negative Measles">Negative Measles</option>
										<option value="Positive Rubella">Positive Rubella</option>
										<option value="Negative Rubella">Negative Rubella</option>
										<option value="Result Awaited">Result Awaited</option>
									</select>									
								</td>
								<td id="otherddd" class="hide">
									<select colspan="3" name="specimen_result" class="form-control testpossibleno othertest otherdiseases noSpecimen" id="other">
										<option value="">--Select--</option>
										<option value="Positive">Positive</option>
										<option value="Negative">Negative</option>
										<option value="Other">Other</option>
									</select>
								</td>
								<td id="otherTD" class="hide"><label>Other Result: </label></td>
								<td colspan="3" >
									<input type="text" id="other_result" class="form-control testpossibleno otherresult noSpecimen" name="other_specimen_result" maxlength="30"> 
								</td>
							</tr>
							<tr>
								<td><p>Lab Final Classification</p></td>
								<td>
									<select colspan="3" name="lab_final_classification" class="form-control lab_final_classification" id="lab_final_classification">
										<option value="">--Select--</option>
										<option value="Lab Confirmed Measles">Lab Confirmed Measles</option>
										<option value="Lab Confirmed Rubella">Lab Confirmed Rubella</option>
										<option value="Discarded">Discarded</option>
										<option value="Epi Linked">Epi Linked</option>
									</select>									
								</td>
							</tr>
							<tr>
								<td><p>Comment</p></td>
								<td><input type="text" class="form-control testpossibleno noSpecimen" name="comments" maxlength="100"></td>
								<!-- <td><p></p></td> -->
								<td><p>Date of lab report sent/submitted</p></td>
								<td><input class="form-control dp testpossibleno noSpecimen" name="lab_report_sent_date" readonly="readonly"></td>
								<!-- <td><p></p></td> -->
							</tr>
							<tr>
								<td><p>Report Submitted by: Name</p></td>
								<td><input type="text" class="form-control noSpecimen" name="report_sent_by" maxlength="30"></td>
								<!-- <td><p></p></td> -->
								<td><p>Designation</p></td>
								<td colspan="3"><input type="text" name="sent_by_designation" class="form-control noSpecimen" maxlength="20"></td>
								<!-- <td><p></p></td> -->
							</tr>							
          			</tbody>
      			</table>      
      			<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
					<thead>
						<tr>
							<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">PART III : 30-day Follow up (to be filled for outbreak cases)</th>
						</tr>
					</thead>
          			<tbody>
						<tr>
							<td style="width: 25%;"><p>Date of Follow UP</p></td>
							<td style="width: 50%;"><input class="dp form-control" name="followup_date" id="followup_date" readonly="readonly" value="<?php if(isset($measles_Result)){ if($measles_Result->followup_date!= '1969-12-31' && $measles_Result->followup_date != NULL){ echo date('d-m-Y',strtotime($measles_Result->followup_date)); }else{ echo ''; } } ?>" type="text"></td>
						</tr>
	            		<tr>
							<tr>
							<td style="width: 25%;"><p>Outcome</p></td>
							<td style="width: 50%;">
								<select id="outcome" name="outcome" class="form-control text-center">
									<option <?php if(isset($measles_Result)){ if($measles_Result->outcome  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select Outcome --</option>
									<option <?php if(isset($measles_Result)){ if($measles_Result->outcome  == "Cured"){ echo 'selected="selected"';} } ?> value="Cured">Cured</option>
									<option <?php if(isset($measles_Result)){ if($measles_Result->outcome  == "Complication"){ echo 'selected="selected"';} } ?> value="Complication">Complication</option>
									<option <?php if(isset($measles_Result)){ if($measles_Result->outcome  == "Death"){ echo 'selected="selected"';} } ?> value="Death">Death</option>
									<option <?php if(isset($measles_Result)){ if($measles_Result->outcome  == "Lost to Follow-up"){ echo 'selected="selected"';} } ?> value="Lost to Follow-up">Lost to Follow-up</option>
								</select>
							</td>             
							<tr>
								<td class="showComplication <?php if(isset($measles_Result)){ if($measles_Result->complication  != ""){}else{ echo "hide"; }}else{ echo "hide"; } ?>" style="width: 50%;margin-left: 100%;">
									<table class="mytable2 disabledclass" style="width:100%;">
										<tbody>
											<tr>
												<td style="width: 25%;"><p>Type of Complication</p></td>
												<td style="width: 50%;">
													<select id="complication" name="complication" class="form-control text-left" >
													<option <?php if(isset($measles_Result)){ if($measles_Result->complication  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select Complication --</option>
													<option <?php if(isset($measles_Result)){ if($measles_Result->complication  == "Pneumonia"){ echo 'selected="selected"';} } ?> value="Pneumonia">Pneumonia</option>
													<option <?php if(isset($measles_Result)){ if($measles_Result->complication  == "Diarrhea"){ echo 'selected="selected"';} } ?> value="Diarrhea">Diarrhea</option>
													<option <?php if(isset($measles_Result)){ if($measles_Result->complication  == "Otitis media"){ echo 'selected="selected"';} } ?> value="Otitis media">Otitis media</option>
													<option <?php if(isset($measles_Result)){ if($measles_Result->complication  == "Corneal scaring"){ echo 'selected="selected"';} } ?> value="Corneal scaring">Corneal scaring</option>
													<option <?php if(isset($measles_Result)){ if($measles_Result->complication  == "Acute malnutrition"){ echo 'selected="selected"';} } ?> value="Acute malnutrition">Acute malnutrition</option>
													</select>
												</td>                     
											</tr>
										</tbody>
									</table>
								</td>              
	            		</tr>            
							<tr>               
								<td class="showDate <?php if(isset($measles_Result)){ if($measles_Result->death_date  != "" && $measles_Result->death_date  != "1969-12-31"){}else{ echo "hide"; }}else{ echo "hide"; } ?>" style="width: 50%;margin-left: 100%;">
									<table class="mytable2 disabledclass" style="width:100%;">
										<tbody>
											<tr>
												<td style="width: 25%;"><p>Date of Death</p></td>                      
												<td style="width: 50%;">
													<input class="dp form-control" name="death_date" id="death_date" readonly="readonly" value="<?php if(isset($measles_Result) && $measles_Result->death_date != NULL){ if($measles_Result->death_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($measles_Result->death_date)); }else{ echo ''; } } ?>" type="text">                     	
												</td>
											</tr>
										</tbody>
									</table>
								</td>            
							</tr>
	          		</tbody>
      			</table>
					<table class="table table-bordered table-condensed table-striped table-hover mytable3 ">
						<thead>
							<tr>
								<th colspan="8" style="text-align: center; padding-top: 10px; padding-bottom: 10px;"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="width:50%;" class="text-center">Submission Date</td>
								<?php if(isset($measles_Result)) { ?>
								<td class="text-center" id="get_date"><?php if(isset($measles_Result)){ echo $current_date; } ?></td>
								<input type="hidden" id="editted_date" name="editted_date" value="<?php if(isset($measles_Result)){ echo date('d-m-Y',strtotime($measles_Result->editted_date)); } else{ echo $current_date; } ?>" type="date">
								<?php } else{ ?>
								<td class="text-center"><?php echo $current_date; ?> </td>
								<input type="hidden" name="submitted_date" value="<?php echo $current_date; ?>" type="date">
								<?php } ?>
							</tr>
						</tbody>
					</table>
			      <div class="row">
						<hr>
						<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
							<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
							<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" name="is_temp_saved" value="0" class="btn btn-primary btn-md" role="button" id="myCoolForm"><i class="fa fa-floppy-o "></i> Submit Form  </button>
							<button onclick="javascript:disablebuttons();" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset">
							<i class="fa fa-repeat"></i> Reset Form </button>
							<a href="<?php echo base_url(); ?>Measles_investigation/measles_investigation_list" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
							<!-- <a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a> -->
						</div>
					</div> 
				</form>
   		</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>
<script src="<?php echo base_url(); ?>includes/js/moment.js"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
<script src="<?php echo base_url(); ?>includes/js/bootstrap-multiselect.js" type="text/javascript"></script>
<link   href="<?php echo base_url(); ?>includes/css/bootstrap-multiselect.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>includes/js/moment.js"></script>
<script type="text/javascript">
	var referingFacilityInfo="";
	$(document).ready(function()
	{
		referingFacilityInfo = $('#rb_info').html();
		<?php if(isset($measles_Result)){ ?>	
		//$('#rb_info').html('');
			var startDate = '<?php echo $startDate; ?>';
			var endDate = '<?php echo $endDate; ?>';
			dateSettingsForEdit(startDate, endDate);
			$('#pvh_date').trigger('change');
			<?php } else{ ?> 
			$('#rb_info').html('');
			<?php } ?> 	
			<?php if(isset($measles_Result)){ ?>
			var outcome = '<?php echo $measles_Result->outcome; ?>';
			$('.showComplication').addClass("hide");
			if (outcome == 'Complication') {
				$('.showComplication').removeClass("hide");
				$('.showDate').addClass("hide");
			}			
			if(outcome != 'Death'){
				$('.showDate').addClass("hide");
			}
		<?php } ?> 
		<?php if(!isset($measles_Result)){ ?>
			var year = $("#year").val();
			var newOption = $('<option value="'+year+'">'+year+'</option>');
			$('#epid_year').append(newOption);
			$('.epid_year').trigger('change');
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksforCurrentYear',
				data:'year='+year,
				success: function(response){
					$('#week').html(response);
					document.getElementById("year").style.borderColor = "";
					$('#week').trigger("change");
				}
			});
		<?php } ?>
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
	
		var get_date = $('#get_date').text();
		$('#editted_date').val(get_date);	
		var distcode = '<?php echo $this -> session -> District; ?>';
		$('#case_epi_no').val(distcode);               
		var case_epi_no  = $('#case_epi_no').val();
		$.ajax({
			type: "GET",
			data: "case_epi_no="+distcode,
			url: "<?php echo base_url(); ?>Ajax_calls/generate_measles_case_code",
			success: function(result){
				$('#case_epi_no').val(result);
				case_epi_no  = $('#case_epi_no').val();
				var newVal = case_epi_no;
				$('#case_epi_no').val(newVal);
			}
		});
		$(document).on('change','#outcome', function(){
			var selected = $(this).val();
			if (selected == 'Complication') { 
				$('.showComplication').removeClass("hide");
				$('.showDate').addClass("hide");
				$('#death_date').val('');
			}
			if (selected == 'Death') {  
				$('.showComplication').addClass("hide");
				$('.showDate').removeClass("hide"); 
				$('#complication').val("0");
			}
			if (selected == 'Lost to Follow-up') { 
				$('.showComplication').addClass("hide");
				$('.showDate').addClass("hide");
				$('#complication').val("0");
				$('#death_date').val('');
			}
			if (selected == '0') { 
				$('.showComplication').addClass("hide");
				$('.showDate').addClass("hide");
				$('#complication').val("0");
				$('#death_date').val('');
			}
		});

		selecteduncode = '<?php echo isset($measles_Result)?$measles_Result->uncode:0; ?>';
		if($('#patient_dob').val() != ''){
			var fromdate = $('#patient_dob').val();
			var todate;
			fromdate= moment(fromdate, "DD-MM-YYYY").format("MM/DD/YYYY");
			if(todate) todate= new Date(todate);
			else todate= new Date();
			var age= [], fromdate= new Date(fromdate),
			y= [todate.getFullYear(), fromdate.getFullYear()], 
			ydiff= y[0]-y[1],
			m= [todate.getMonth(), fromdate.getMonth()],
			mdiff= m[0]-m[1],
			d= [todate.getDate(), fromdate.getDate()],
			ddiff= d[0]-d[1];

			if(mdiff < 0 || (mdiff=== 0 && ddiff<0))--ydiff;
			if(mdiff<0) mdiff+= 12;
			if(ddiff<0){
				fromdate.setMonth(m[1]+1, 0);
				ddiff= fromdate.getDate()-d[1]+d[0];
				--mdiff;
			}
			if(ydiff> 0){ $('#years').val(ydiff);}else{ $('#years').val('0'); };
			if(mdiff> 0){ $('#months').val(mdiff); }else{ $('#months').val('0'); };
		}
	});
	//***************************************code to disable save starts here*********************************//
	function disablebuttons()
	{
		$('#myCoolForm').prop('disabled', true);
	  	$('#save').prop('disabled', true);
	}
	<?php if(!isset($measles_Result)) { ?>
		$('#save').prop('disabled', 'disabled');
		$('#myCoolForm').prop('disabled', 'disabled');
		$(document).on('change','#facode,#rb_facode',function(){
			if (buttonsDisable($(this).val())) {
				/* if($(this).val().length===0){
				$('#myCoolForm').prop('disabled', true);
				$('#save').prop('disabled', true);
				}
				else
				{ */
				$('#myCoolForm').prop('disabled', false);
				$('#save').prop('disabled', false);
				//}
			} else {
				$('#myCoolForm').prop('disabled', true);
				$('#save').prop('disabled', true);
			}
		});
		function buttonsDisable(e) {
			if (e > 0) {
				return true;
			} else {
				return false
			}
		}
	<?php } ?>
	//***************************************code to disable save ends here*********************************//
	
	//***************************************code to disable submit ends here*********************************//
	$(document).on('change','#year',function(){
		var year = $("#year").val();
		$('#epid_year').find('option').remove().end().append('<option value="'+year+'">'+year+'</option>').val(year);
		//var newOption = $('<option value="'+year+'">'+year+'</option>');
		//$('#epid_year').append(newOption);
		$('.epid_year').trigger('change');
		if(year == ""){
			$("#week").html("");
			$('#datefrom').val("");
			$('#dateto').val("");
		}else{
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksforCurrentYear',
				data:'year='+year,
				success: function(response){
					if(response == 1){
						var curr_year = new Date().getFullYear(); //Exchange year with current year.
						document.getElementById("year").style.borderColor = "red";
						alert("Year is restricted to current and previous!");
						var cases = $("#cases").val();
						var yrs = $("#year").val();
						var distcode = $("#distcode").val();
						$('#epid_year').html('<option value="'+curr_year+'" >'+curr_year+'</option>');
						// if(cases == ''){
						// 	$('#a1').val("");
						// 	$('#a2').val("");
						// 	$('#a3').val("");
						// 	$('#a4').val("");
						// }						
						$.ajax({
							type: "POST",
							data: {distcode:distcode,cases:cases,year:curr_year},
							dataTyp: 'JSON',
							//data: "short_name="+cases,
							//data:'distcode='+distcode+'&short_name='+cases+'&year='+year,
							url: "<?php echo base_url(); ?>Ajax_red_rec/generateEPI_case_code",
							success: function(result){
								var response= JSON.parse(result); 
								$('#a1').val(response[0]);
								$('#a2').val(response[1]);
								$('#a3').val(response[2]);
								$('#a4').val(response[3]);
							}
						});
						$.ajax({
							type: 'POST',
							url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksforCurrentYear',
							data:'year='+curr_year,
							success: function(response){
								$('#week').html(response);
								$('#year').val(curr_year);
								// $('#epid_year').val(curr_year);
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

function calEndDate(endDate)
{	
	alert(endDate);
	endDate = endDate.substring(6,10) + '-' + endDate.substring(3,5) + '-' + endDate.substring(0,2);
	var eDate = endDate;
	endDate = new Date(endDate);
	current_date = '<?php echo $current_date; ?>';
	currentDate = new Date();
	if(currentDate < endDate)
	{
		return current_date;
	}
	else
	{
		return eDate;
	}	
}
// function dateSettingsForAdd(startDate, endDate)
// {
// 	//endDate = calEndDate(endDate);
// 	$("#pvh_date").datepicker('setStartDate', startDate);
// 	$("#pvh_date").datepicker('setEndDate', endDate);
// 	$("#notification_date").datepicker('setEndDate', '+0d');
// 	$("#patient_dob").datepicker('setEndDate', '+0d');
// 	$("#date_collection").datepicker('setEndDate', '+0d');
// 	$("#date_sent_lab").datepicker('setEndDate', '+0d');
// 	$("#date_investigation").datepicker('setEndDate', '+0d');
// }

function dateSettingsForEdit(startDate, endDate)
{
	$("#pvh_date").datepicker({format: 'dd-mm-yyyy',startDate: startDate, endDate: endDate});
	$("#notification_date").datepicker({format: 'dd-mm-yyyy', endDate: '+0d'});
	$("#patient_dob").datepicker({format: 'dd-mm-yyyy', endDate: '+0d'});
	$("#date_collection").datepicker({format: 'dd-mm-yyyy', endDate: '+0d'});
	$("#date_sent_lab").datepicker({format: 'dd-mm-yyyy', endDate: '+0d'});
	$("#date_investigation").datepicker({format: 'dd-mm-yyyy', endDate: '+0d'});
	$("#date_rash_onset").datepicker({format: 'dd-mm-yyyy'});
	$("#date_investigation").datepicker({format: 'dd-mm-yyyy'});
	$("#date_collection").datepicker({format: 'dd-mm-yyyy'});
	$("#followup_date").datepicker({format: 'dd-mm-yyyy'});
	$("#date_sent_lab").datepicker({format: 'dd-mm-yyyy'});
	if($('#doses_received').val() != '0')
	{
		$("#last_dose_date").datepicker({format: 'dd-mm-yyyy'});
	}
}

function fromDate(start_date_id, end_date_id, $gt=false)
{
	var from_date = $('#'+start_date_id).datepicker().val();
	var to_date = $("#"+end_date_id).datepicker().val();
	if(!$gt)
	{
		$("#"+end_date_id).datepicker('setStartDate', from_date);
	}
	else
	{
		$("#"+end_date_id).datepicker('setEndDate', from_date);
	}
   //$("#"+end_date_id).datepicker('setEndDate', '+2y');
   if(from_date != '')
	{
    	from_date = from_date.substring(6,10) + '-' + from_date.substring(3,5) + '-' + from_date.substring(0,2);
    	from_date = new Date(from_date.toString());
    }
    if(to_date != '')
    {
    	to_date = to_date.substring(6,10) + '-' + to_date.substring(3,5) + '-' + to_date.substring(0,2);
    	to_date = new Date(to_date.toString());
    	if(to_date < from_date && $gt == false)
	   {
	      $("#"+end_date_id).val('');
	      $("#"+end_date_id).datepicker('setEndDate', '+0d');
	   }
	   if(to_date > from_date && $gt == true)
	   {
	      $("#"+end_date_id).val('');
	   }
    }
}

	function toDate(start_date_id, end_date_id){
		$('#'+start_date_id).datepicker('setStartDate', "1925-01-01");
	 	$('#'+start_date_id).datepicker('setEndDate', '+0d');
	}

	function addDays(start_date_id, end_date_id, numberOfDays=30)
	{
		var from_date = $('#'+start_date_id).datepicker().val();
		from_date = from_date.substring(6,10) + '-' + from_date.substring(3,5) + '-' + from_date.substring(0,2);
    	from_date = new Date(from_date.toString());
		from_date.setDate(from_date.getDate() + numberOfDays);
		var dd = from_date.getDate();
		var mm = from_date.getMonth() + 1;
		var y = from_date.getFullYear();
		var formattedDate = dd + '-'+ mm + '-'+ y;
		$("#"+end_date_id).datepicker('setStartDate', from_date);
	}

	$("#pvh_date").on( "change", function() {
		//console.log(startDate);
	    fromDate('pvh_date', 'notification_date');//For Restrictions on notification date
	    fromDate('pvh_date', 'date_rash_onset',true);//For Restrictions on rash onset date
	    fromDate('pvh_date', 'date_collection');//For Restrictions on specimen collection date
	   // addDays('pvh_date', 'followup_date', 45);//For Restrictions on specimen collection date

	 //    if($('#doses_received').val() != '0')
		// {
		// 	fromDate('pvh_date', 'last_dose_date',true);//For Restrictions on last dose date
		// }
	});
	//condition by usama for follow up AND SAMPLE COLLECTION 
	$("#date_investigation").on( "change", function() {
		//console.log(startDate);
	    addDays('date_investigation', 'followup_date', 30);//For Restrictions on specimen collection date
	});
	$("#date_rash_onset").on( "change", function() {
		//console.log(startDate);
	    addDays('date_rash_onset');//For Restrictions on specimen collection date
	    //addDays('date_rash_onset', 'date_collection', 2);//For Restrictions on specimen collection date
	});
	////end ////
	$("#date_collection").on( "change", function() {
	   fromDate('date_collection', 'date_sent_lab');
	});	

	if($('#doses_received').val() == '0')
	{
		$('#last_dose_date').removeClass('dp');
	}
	$('#doses_received').on('change', function(){
		var date_investigation = $("#date_investigation").val();
		if(this.value == '0'){
			$('#last_dose_date').removeClass('dp');
			$('#last_dose_date').val('');
			$('#last_dose_date').prop('readonly', true);
			$("#last_dose_date").datepicker('remove');
		}
		else{
			$("#last_dose_date").datepicker('remove');
			$('#last_dose_date').addClass('dp');
			$('#last_dose_date').prop('readonly', false);
			$("#last_dose_date").datepicker({format: 'dd-mm-yyyy'});
			//fromDate('pvh_date', 'last_dose_date',true);//For Restrictions on last dose date
			$('#last_dose_date').datepicker('setStartDate', "1925-01-01");
			$('#last_dose_date').datepicker('setEndDate', date_investigation);
		}
	});

	$(document).on('change','#week,#facode,#rb_facode',function(){
		var week = $("#week").val();
		var year = $('#year').val();		
		if($('#cb_cross_notified:checked').val() == 'on'){
			var facode= $('#rb_facode').val();
		}else{
			var facode= $('#facode').val();
		}
		var disease="malaria";
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
					var startDate = obj.sDate;
					var endDate = obj.eDate;
					$("#pvh_date").val('');
					//dateSettingsForAdd(startDate, endDate);
				}
			});
		}
	});
	$(document).on('change','#patient_address_distcode', function(){
		var distcode = $('#distcode').val();
		//to get tehsils of selected distcrict
		if($("#tcode").length == 0) {
		  //it doesn't exist
		}else{
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#patient_address_tcode').html(result);
				}
			});
		}							
	});
	$(document).on('change','#patient_address_tcode', function(){
		var tcode = $('#patient_address_tcode').val();
		//to get ucs of selected distcrict
		if(tcode != 0) {
		  	$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC/"+tcode,
				success: function(result){
					$('#patient_address_uncode').html(result);							
					//
					if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
					{
						$('#patient_address_uncode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
				}
			});
		}else{
			$('#patient_address_uncode').html('');
			//it doesn't exist
		}						
	});
	$(document).on('change','#rb_tcode', function(){
		var tcode = $('#rb_tcode').val();
		$('#rb_facode').html('');
		//to get ucs of selected distcrict
		if(tcode != 0) {
		  	$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC/"+tcode,
				success: function(result){
					$('#rb_uncode').html(result);							
					//
					if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
					{
						$('#rb_uncode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
				}
			});
		}else{
			$('#rb_uncode').html('');
			$('#rb_facode').html('');
			//it doesn't exist
		}						
	});
	 $(document).on('change','#rb_uncode', function(){
		var uncode = $('#rb_uncode').val();
		var module = $('#module').val();
		//to get facilities of selected UC
		if(uncode =="") {
		  $('#rb_facode').html('');
		  //it doesn't exist
		}else{
			$.ajax({
				type: "POST",
				data: "uncode="+uncode+"&module="+module,
				url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
				success: function(result){
					$('#rb_facode').html(result);
					set_hfcode();
				}
			});			
		}
	}); 
	//------- ABCDEFGHIJKLMNOPQRSTUVWXYZ ---------//
	$(document).ready(function(){
		$(document).on('change','.case_type',function(){
			var year = $('#year').val();
			var case_type = $(".case_type :selected").val();
			//var short_code = $('#distCode').text();			
			var case_type = $(this).val();
			if(case_type != '-Select-'){
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_red_rec/getcase_definition',
					data:'case_type='+$(this).val(),
					success: function(data){
						if(case_type == 'Msl' || case_type == 'Diph' || case_type == 'Anth'){
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
			// $('#show_year').text(year);
			// $('#case_type_shortcode').text(case_type);
		});
	});
	$("#other").on('change',function(){
		if(this.checked){
		   $('#other_rep').attr('readonly',false);
			$('#other_rep').attr('placeholder',"Enter Other Clinical Representation of the Case");
		}
		else{
			$('#other_rep').val('');
			$('#other_rep').attr('placeholder',"");
			$('#other_rep').attr('readonly','readonly');				
		}
	});	

	function ageCalculater(fromdate,todate){
		fromdate= moment(fromdate, "DD-MM-YYYY").format("MM/DD/YYYY");
	    if(todate) todate= new Date(todate);
	    else todate= new Date();
		 
	    var age= [], fromdate= new Date(fromdate),
	    y= [todate.getFullYear(), fromdate.getFullYear()],
	    ydiff= y[0]-y[1],
	    m= [todate.getMonth(), fromdate.getMonth()],
	    mdiff= m[0]-m[1],
	    d= [todate.getDate(), fromdate.getDate()],
	    ddiff= d[0]-d[1];
	    if(mdiff < 0 || (mdiff=== 0 && ddiff<0))--ydiff;
	    if(mdiff<0) mdiff+= 12;
	    if(ddiff<0){
	        fromdate.setMonth(m[1]+1, 0);
	        ddiff= fromdate.getDate()-d[1]+d[0];
	        --mdiff;
	    }
	    if(ydiff> 0){ $('#years').val(ydiff);}else{ $('#years').val('0'); };
	    if(mdiff> 0){ $('#months').val(mdiff); }else{ $('#months').val('0'); };
	}
	$(document).on('submit','#measles',function(e){
		//e.preventDefault();
		var uncode = $('#uncode').val();
		var Puncode = $('#patient_address_uncode').val();
		var facode = $('#facode').val();
		var case_reported = $('#case_reported').val();
		var ptcode = $('#patient_address_tcode').val();
		if(uncode==0){
			$('#uncode').val('');
		}
		if(ptcode==0){
			$('#patient_address_tcode').val('');
		}
		if(Puncode==0){
			$('#patient_address_uncode').val('');
		}
		if(facode==0){
			$('#facode').val('');
		}
		if(case_reported != 0){
			$("#patient_address_tcode").attr("required", true);
			$("#patient_address_uncode").attr("required", true);
		}
		$('#measles')[0].submit();
		//$('form')[0].unbind('submit').submit();
		 //$('#measles')[0].unbind('submit').submit();
	});
	
	////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
	var case_type_history  = $('#cases').val();
	if(case_type_history == 'ChTB' || case_type_history == 'Diph' || case_type_history == 'Men' || case_type_history == 'Pert' || case_type_history == 'Msl' || case_type_history == 'Pneu'){
		$('#withdays').removeClass('hide');
		$('#plain').addClass('hide');
	}else{
		$('#withdays').addClass('hide');
		$('#plain').removeClass('hide');
	}
	$(document).on('change','#cases',function(){
		if($(this).val() == 'ChTB' || $(this).val() == 'Diph' || $(this).val() == 'Men' || $(this).val() == 'Pert' || $(this).val() == 'Msl' || $(this).val() == 'Pneu'){
			$('#withdays').removeClass('hide');
			$('#plain').addClass('hide');
		}else{
			$('#withdays').addClass('hide');
			$('#plain').removeClass('hide');
		}
	});

	// var type_specimen  = $('#type_specimen').val();
	// if(type_specimen == 'Other'){
	// 	$('#other_specimen').removeClass('hide');
	// }else{
	// 	$('#other_specimen').addClass('hide');
	// }
	// $(document).on('change','#type_specimen',function(){
	// 	if($(this).val() == 'Other'){
	// 		$('#other_specimen').removeClass('hide');
	// 	}else{
	// 		$('#other_specimen').addClass('hide');
	// 	}
	// });
	if($('#cb_cross_notified').not(':checked').length){
		$('.crossNotify').removeClass('hide');
		$('.otherProvinceAddress').addClass('hide');
		$('#other_procode').removeAttr('required','required');
		$('#cases').attr('required','required');
		$('#case_representation').attr('required','required');
		$('#labresult_tobesentto').removeClass('hide');
		$('#labresult_tobesentto_district').removeAttr('required','required');
	}
	var tdHtml = "";var epidNumberHtml = "";var patient1stTr = "";var patient2ndTr = "";var healthFacilityTr="";
	$(document).on('click','#cb_cross_notified',function(){
		$('#save').attr('disabled', 'disabled');
	 	$('#myCoolForm').attr('disabled', 'disabled');
		$('#cb_cross_notified').attr('disabled','disabled');
		if(this.checked == true){
			$('#rb_info').html(referingFacilityInfo);
			$('#rb_info').removeClass('hide');
			$('#cross_notified').val('1');
			tdHtml = $('#districttd').html();
			epidNumberHtml = $('#epidNumberTR').html();
			patient1stTr = $('#patient1stTr').html();
			patient2ndTr = $('#patient2ndTr').html();
			healthFacilityTr = $('#healthFacilityTr').html();
			$('#epidNumberTR').html('');
			$('#districttd').html('');
			$('#healthFacilityTr').html('');
			$('#tcode').empty();
			$('#pvh_date').attr('required','required');
			$('#patient_address_distcode').empty();
			$('#patient_address_tcode').empty();
			$('#patient_address_uncode').empty();
			$('.crossNotify').addClass('hide');
			$('#labresult_tobesentto').addClass('hide');
			$('#labresult_tobesentto_district').removeClass('hide');
			$('#labresult_tobesentto').removeAttr('required','required');
			$('#other_procode').attr('required','required');
			$('.otherProvinceAddress').removeClass('hide');
			$('.allprocodes').val('');
			$('#tcode').removeAttr('required','required');
			$('#uncode').removeAttr('required','required');
			$('#patient_address').attr('required','required');
			$('#cases').attr('required','required');
			$('#case_representation').attr('required','required');			
			$('#patient_address').val('');
			$.ajax({ 
				type: 'POST',
				data: '',
				url: '<?php echo base_url();?>Ajax_red_rec/getDistricts_options',
				success: function(data){		
					$('#districttd').html(data);
					$('#cb_cross_notified').removeAttr('disabled','disabled');
				}
			});
			$.ajax({ 
				type: 'POST',
				data: '',
				url: '<?php echo base_url();?>Ajax_red_rec/getProvinces_options',
				success: function(data){		
					$('#other_procode').html(data);
					//$('#cb_cross_notified').removeAttr('disabled','disabled');
				}
			});
			$('#uncode').empty();
			$('#facode').empty();			
		}else{
			referingFacilityInfo = $('#rb_info').html();
			$('#rb_info').html('');
			//$('#rb_info').addClass('hide');
			$('#cross_notified').val('0');
			$('#districttd').html(tdHtml);
			$('#patient1stTr').html(patient1stTr);
			$('#patient2ndTr').html(patient2ndTr);
			$('#epidNumberTR').html(epidNumberHtml);
			$('#healthFacilityTr').html(healthFacilityTr);			
			$('#distcode').trigger('change');
			$('#cb_cross_notified').removeAttr('disabled','disabled');
			$('#patient_address').removeAttr('readonly','readonly');
			$('#other_procode').empty();
			$('#other_procode').removeAttr('required','required');
			$('#labresult_tobesentto').removeClass('hide');
			$('#labresult_tobesentto_district').addClass('hide');
			$('#labresult_tobesentto_district').removeAttr('required','required');
			$('#cases').attr('required','required');
			$('#case_representation').attr('required','required');
			$('#patient_address').val('');
			$('#pvh_date').attr('required','required');
			$('#facode').empty();
			$('#cases').val('');
			$('#case_code').empty('');
			$('#case_representation').empty();
			$('#rb_info').html('');
			$('.crossNotify').removeClass('hide');
			$('.otherProvinceAddress').addClass('hide');
		}		
	});
	$(document).on('change','#distcode',function(){
		if($("#cb_cross_notified").is(':checked')){
			$('#patient_address_uncode').empty();
			var dist = $('#distcode').val();
			$.ajax({ 
				type: 'POST',
				data: 'distcode='+dist,
				url: '<?php echo base_url();?>Ajax_red_rec/getDistricts_options',
				success: function(data){
					$('#patientDistcodeTd').html(data);
					$('#patient_address_distcode').trigger('change');
				}
			});
		}
		$('#facode').empty();
	});
	$(document).on('change','#complications',function(){
		if($(this).val() == 'Other'){
			$('.complicationbox').removeClass('hide');
		}else{
			$('.complicationbox').addClass('hide');
		}
	});
	$(document).on('change','#travel_history',function(){
		if($(this).val() == '1'){
			$('#th_procode').removeClass('hide');
			$('#th_procode').val('');
			$('#th_muhallah').attr('readonly','readonly');
		}else{
			$('#th_procode').addClass('hide');
			$('.otherprovince').addClass('hide');
			$('.kptravel_history').addClass('hide');
			$('#th_muhallah').attr('readonly','readonly');
		}
	});
	$(document).on('change','#th_procode',function(){
		if($(this).val() == '<?php echo $_SESSION["Province"]; ?>'){
			$('.kptravel_history').removeClass('hide');
			$('.kptravel_history').val('');
			$('.otherprovince').addClass('hide');
			$('.otherprovince').val('');
			$('#th_muhallah').removeAttr('readonly','readonly');
		}else if($(this).val() != '<?php echo $_SESSION["Province"]; ?>'){
			$('.kptravel_history').addClass('hide');
			$('.otherprovince').removeClass('hide');
			$('.kptravel_history').val('');
			$('.otherprovince').val('');
			$('#th_muhallah').removeAttr('readonly','readonly');
		}
	});
	$(document).on('change','#other_procode',function(){
		if($(this).val() == '<?php echo $_SESSION["Province"]; ?>'){
			$('.procodekp').removeClass('hide');
			$('.procodekp').val('');
			$('.otherprocode').addClass('hide');
			$('.otherprocode').val('');
			$('#patient_address').removeAttr('readonly','readonly');
			$('#labresult_tobesentto').removeClass('hide');
			$('#labresult_tobesentto_district').addClass('hide');
			$('#labresult_tobesentto').attr('required','required');
			$('#labresult_tobesentto_district').removeAttr('required','required');
			$('#other_pro_distcode').attr('required','required');
			$('#other_pro_tcode').attr('required','required');
			$('#other_pro_uncode').attr('required','required');			
			$('#other_pro_district').removeAttr('required','required');
			$('#other_pro_tehsil').removeAttr('required','required');
			$('#other_pro_uc').removeAttr('required','required');			
			//$('#labresult_tobesentto_district').removeAttr('required','required');
		}else if($(this).val() != '<?php echo $_SESSION["Province"]; ?>' && $(this).val() != ''){
			$('.procodekp').addClass('hide');
			$('.otherprocode').removeClass('hide');
			$('.procodekp').val('');
			$('.otherprocode').val('');
			$('#patient_address').removeAttr('readonly','readonly');
			$('#labresult_tobesentto').addClass('hide');
			$('#labresult_tobesentto_district').removeClass('hide');
			$('#labresult_tobesentto').removeAttr('required','required');
			$('#labresult_tobesentto_district').attr('required','required');
			$('#other_pro_distcode').removeAttr('required','required');
			$('#other_pro_tcode').removeAttr('required','required');
			$('#other_pro_uncode').removeAttr('required','required');			
			$('#other_pro_district').attr('required','required');
			$('#other_pro_tehsil').attr('required','required');
			$('#other_pro_uc').attr('required','required');
		}
		else if( $(this).val() == ''){
			$('.procodekp').addClass('hide');
			$('.otherprocode').addClass('hide');
			$('.procodekp').val('');
			$('.otherprocode').val('');
			$('#patient_address').attr('readonly','readonly');
			$('#other_pro_distcode').removeAttr('required','required');
			$('#other_pro_tcode').removeAttr('required','required');
			$('#other_pro_uncode').removeAttr('required','required');			
			$('#other_pro_district').removeAttr('required','required');
			$('#other_pro_tehsil').removeAttr('required','required');
			$('#other_pro_uc').removeAttr('required','required');
		}
	});
	$(document).on('change','#th_distcode', function(){
		var distcode = $('#th_distcode').val();
		//to get tehsils of selected distcrict
		if($("#th_tcode").length == 0) {
		  //it doesn't exist
		}else{
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#th_tcode').html(result);
					$('#th_tcode').trigger('change');
				}
			});
		}
							
	});
	$(document).on('change','#th_tcode', function(){
		var tcode = this.value;
		//to get ucs of selected distcrict
		if(tcode != 0) {
		  $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC/"+tcode,
				success: function(result){
					$('#th_uncode').html(result);							
					//
					if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
					{
						$('#th_uncode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
					$('#th_uncode').trigger('change');
				}
			});
		}else{
			$('#th_uncode').html('');
			//it doesn't exist
		}
						
	});
	//-----------------

	$(document).on('change','#other_pro_distcode', function(){
		var distcode = $('#other_pro_distcode').val();
		//to get tehsils of selected district
		if($("#other_pro_tcode").length == 0) {
		  //it doesn't exist
		}else{
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#other_pro_tcode').html(result);
					$('#other_pro_tcode').trigger('change');
				}
			});
		}							
	});
	$(document).on('change','#other_pro_tcode', function(){
		var tcode = this.value;
		//to get ucs of selected distcrict
		if(tcode != 0) {
		  $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC/"+tcode,
				success: function(result){
					$('#other_pro_uncode').html(result);							
					//
					if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
					{
						$('#other_pro_uncode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
					$('#other_pro_uncode').trigger('change');
				}
			});
		}else{
			$('#other_pro_uncode').html('');
			//it doesn't exist
		}						
	});
	// $('#patient_address_distcode').on('change', function() {
	// 	var distcode = $("#patient_address_distcode").val();
	// 	//$('#labresult_tobesentto').val(distcode);
	// 	$("#labresult_tobesentto option[value="+distcode+"]").prop("selected",true);		
	// });
	$('#tcode').on('change', function() {
		var tcode = $("#tcode").val();
		//$('#patient_address_tcode').val(tcode);
		$("#patient_address_tcode option[value="+tcode+"]").prop("selected",true);		
	});
	$('#uncode').on('change', function() {
		var uncode = $("#uncode").val();
		//alert(uncode);
		if(uncode > 0){
			$("#patient_address_uncode option[value="+uncode+"]").prop("selected",true);
		}
		//$("#patient_address_uncode").prop('disabled', 'disabled');		
	});
	
	//$('#cases').on('change', function() {
	$(document).on('change','#cases, #year',function(){
		var cases = $("#cases").val();
		var year = $("#year").val();
		var distcode = $("#distcode").val();
		//alert(cases);
		if(cases != '' && year !=''){	
			$.ajax({
				type: "POST",
				data: "short_name="+cases,
				url: "<?php echo base_url(); ?>Ajax_red_rec/getCaseCode",
				success: function(result){
					$('#case_code').text(result);
					//$('#facode').trigger('change');
					//$('#th_tcode').trigger('change');
				}
			});
			$.ajax({
				type: "POST",
				data: {distcode:distcode,cases:cases,year:year},
				dataTyp: 'JSON',
				//data: "short_name="+cases,
				//data:'distcode='+distcode+'&short_name='+cases+'&year='+year,
				url: "<?php echo base_url(); ?>Ajax_red_rec/generateEPI_case_code",
				success: function(result){
					var response= JSON.parse(result); 
					$('#a1').val(response[0]);
					$('#a2').val(response[1]);
					$('#a3').val(response[2]);
					$('#a4').val(response[3]);
					//$('#facode').trigger('change');
					//$('#th_tcode').trigger('change');
				}
			});
		}		
	});
	
	var typespecimen  = $('.othertype').val();
	if(typespecimen == 'Other'){
		$('.otherspecimen').removeClass('hide');
	}
	else{
		$('.otherspecimen').addClass('hide');
	}
	$(document).on('change','.othertype',function(){
		if($(this).val() == 'Other'){
			$('.otherspecimen').removeClass('hide');
		}else{
			$('.otherspecimen').addClass('hide');
		}
	});

	var testresult  = $('.othertest').val();
	if(testresult == 'Other'){
		$('.otherresult').removeClass('hide');
	}else{
		$('.otherresult').addClass('hide');
	}
	$(document).on('change','.othertest',function(){
		if($(this).val() == 'Other'){
			$('.otherresult').removeClass('hide');
		}else{
			$('.otherresult').addClass('hide');
		}
	});
	var opt = $('input:radio[name=quantity_adequate]').val();
	if(opt == 1){
		$('#lb').addClass('hide');
		$('#itp').addClass('hide');
		// $('#leekyes').prop('checked',false);
		// $('#leekno').prop('checked',true);
		// $('#testyes').prop('checked',true);
		// $('#testno').prop('checked',false);
	}
	$(document).ready(function(){
		$('input:radio[name=quantity_adequate]').change(function() {
			if (this.value == 2) {
				//alert("abc");
				$('#lb').removeClass('hide');
				$('#itp').removeClass('hide');
				// $('#leekyes').prop('checked',true);
				// $('#leekno').prop('checked',false);
			}
			else if(this.value == 1){
				$('#lb').addClass('hide');
				$('#itp').addClass('hide');
				// $('#leekyes').prop('checked',false);
				// $('#leekno').prop('checked',true);
				// $('#testyes').prop('checked',true);
				// $('#testno').prop('checked',false);
			}
		});		
	});

	$('input:radio[name=test_possible]').change(function() {
		if (this.value == 2){
			$('.testpossibleno').attr('disabled','disabled');			
		}
		else if(this.value == 1){
			$('.testpossibleno').removeAttr('disabled','disabled');
		}
	});
	$('#testInput').removeClass('hide');
	//----------------Epidemiology Part-------------------//
	

	$(document).ready(function(){
		$('.linked_epid_number').attr('disabled','disabled');	
		$('.linked_epid_number').addClass('hide');
		$('.clinically_compatible_with').attr('disabled','disabled');	
		$('.clinically_compatible_with').addClass('hide');
		$('#Ok11').addClass('hide');
		$('#caseInformation').addClass('hide');
		$('#noEpidNumber').addClass('hide');

		$('.other_specimen').addClass('hide');
		$('.noSpecimen').attr('disabled','disabled');
		$('.noSpecimen').val('');
		$('#final_classification').removeAttr('disabled','disabled');
		$('#final_classification').attr('required','required');			
		$('.final_classification').removeClass('hide');
		$('.specimen_adequate').addClass('hide');
		$('.specimenButton').attr('disabled','disabled');
		$('.specimenButton').removeAttr('required','required');
		// $('.linked_epid_number').attr('disabled','disabled');	
		// $('.linked_epid_number').addClass('hide');
		// $('.clinically_compatible_with').attr('disabled','disabled');	
		// $('.clinically_compatible_with').addClass('hide');
		$('#Ok11').addClass('hide');
		$('.specimen_quantity_adequate').removeAttr('required','required');
		$('input:radio[name=specimen_quantity_adequate]').change(function() {
			if(this.value == 2){
				// $('.linked_epid_number').attr('disabled','disabled');	
				// $('.linked_epid_number').addClass('hide');
				$('.noSpecimen').attr('disabled','disabled');
				$('#final_classification').removeAttr('disabled','disabled');
				$('#final_classification').attr('required','required');
				$('.final_classification').removeClass('hide');
				$('#final_classification').val('');
				$('#linked_epid_number').val('');
				$('.linked_epid_number').addClass('hide');
				$('#clinically_compatible_with').val('');
				$('.clinically_compatible_with').addClass('hide');
				$('#caseInformation').addClass('hide');
				$('#noEpidNumber').addClass('hide');
				$('#Ok11').addClass('hide');
			}
			else if(this.value == 1){
				// $('.linked_epid_number').removeAttr('disabled','disabled');
				// $('.linked_epid_number').removeClass('hide');
				$('.noSpecimen').removeAttr('disabled','disabled');
				$('#final_classification').attr('disabled','disabled');
				$('#final_classification').removeAttr('required','required');
				$('.final_classification').addClass('hide');
				$('#final_classification').val('');
				$('#linked_epid_number').val('');
				$('.linked_epid_number').attr('disabled','disabled');	
				$('.linked_epid_number').addClass('hide');
				$('#clinically_compatible_with').val('');
				$('.clinically_compatible_with').attr('disabled','disabled');	
				$('.clinically_compatible_with').addClass('hide');
				$('#caseInformation').addClass('hide');
				$('#noEpidNumber').addClass('hide');
				$('#Ok11').addClass('hide');
			}
		});
		$('input:radio[name=specimen_collected]').change(function() {
			if(this.value == 0){
				// $('.linked_epid_number').attr('disabled','disabled');	
				// $('.linked_epid_number').addClass('hide');
				$('.noSpecimen').attr('disabled','disabled');
				$('#final_classification').removeAttr('disabled','disabled');
				$('#final_classification').attr('required','required');
				$('.final_classification').removeClass('hide');
				$('#final_classification').val('');
				$('#linked_epid_number').val('');
				$('.linked_epid_number').addClass('hide');
				$('#clinically_compatible_with').val('');
				$('.clinically_compatible_with').addClass('hide');
				$('#caseInformation').addClass('hide');
				$('#noEpidNumber').addClass('hide');
				$('#Ok11').addClass('hide');
				$('.specimen_adequate').addClass('hide')
				$('.specimenButton').attr('disabled','disabled');
				$('.specimenButton').removeAttr('required','required');
				$('#type_specimen').multiselect("deselectAll", false).multiselect("refresh");
			}
			else if(this.value == 1){
				// $('.linked_epid_number').removeAttr('disabled','disabled');
				// $('.linked_epid_number').removeClass('hide');
				$('.noSpecimen').removeAttr('disabled','disabled');
				$('#final_classification').attr('disabled','disabled');
				$('#final_classification').removeAttr('required','required');
				$('.final_classification').addClass('hide');
				$('#final_classification').val('');
				$('#linked_epid_number').val('');
				$('.linked_epid_number').attr('disabled','disabled');	
				$('.linked_epid_number').addClass('hide');
				$('#clinically_compatible_with').val('');
				$('.clinically_compatible_with').attr('disabled','disabled');	
				$('.clinically_compatible_with').addClass('hide');
				$('#caseInformation').addClass('hide');
				$('#noEpidNumber').addClass('hide');
				$('#Ok11').addClass('hide');
				$('.specimenButton').removeAttr('disabled','disabled');
				$('.specimenButton').attr('required','required');
			}
		});		
	});

	$("#type_specimen").multiselect('destroy');
	document.getElementById("type_specimen").setAttribute("multiple", "multiple");
	// $('#type_specimen').html(data);
	$('#type_specimen').multiselect({
		includeSelectAllOption: true,
		buttonClass: 'form-control specimenButton',
		buttonWidth: '550px'// here you need to specify width value
	});
	$('#type_specimen').multiselect('rebuild');
	$('#type_specimen').multiselect("deselectAll", false).multiselect("refresh");

	$('#type_specimen').change(function(){
		selectedOptions = $(this).val();
		$('.specimenButton').text(selectedOptions);
	});

	$('#caseInformation').addClass('hide');
	$('#noEpidNumber').addClass('hide');
	var type_specimen  = $('#type_specimen').val();
	if(type_specimen == 'Other'){
		$('.other_specimen').removeClass('hide');
	}
	else{
		$('.other_specimen').addClass('hide');
		$('#final_classification').attr('disabled','disabled');
		$('.final_classification').addClass('hide');
		$('.specimen_adequate').addClass('hide');
	}
		
	$(document).on('change','#type_specimen',function(){
		$('#sqa_yes').prop('checked',false);
		$('#sqa_no').prop('checked',false);
		$('#final_classification').val('');
		if($(this).val() == 'Other'){
			$('.other_specimen').removeClass('hide');
			$('.noSpecimen').removeAttr('disabled','disabled');
			$('#final_classification').attr('disabled','disabled');
			$('#final_classification').removeAttr('required','required');
			$('.final_classification').addClass('hide');
			$('.specimen_adequate').removeClass('hide');
			$('.linked_epid_number').attr('disabled','disabled');	
			$('.linked_epid_number').addClass('hide');
			$('#linked_epid_number').val('');
			$('.clinically_compatible_with').attr('disabled','disabled');	
			$('.clinically_compatible_with').addClass('hide');
			$('#clinically_compatible_with').val('');
			$('#Ok11').addClass('hide');
			$('#linked_epid_number').removeAttr('required','required');
			$('.specimen_quantity_adequate').removeAttr('required','required');
			//$('#hideLabPart').removeClass('hide');
		}
		else if($(this).val() == 'None'){
			$('.other_specimen').addClass('hide');
			$('.noSpecimen').attr('disabled','disabled');
			$('.noSpecimen').val('');
			$('#final_classification').removeAttr('disabled','disabled');
			$('#final_classification').attr('required','required');			
			$('.final_classification').removeClass('hide');
			$('.specimen_adequate').addClass('hide');
			$('.linked_epid_number').attr('disabled','disabled');	
			$('.linked_epid_number').addClass('hide');
			$('.clinically_compatible_with').attr('disabled','disabled');	
			$('.clinically_compatible_with').addClass('hide');
			$('#Ok11').addClass('hide');
			$('.specimen_quantity_adequate').removeAttr('required','required');
			//$('#hideLabPart').addClass('hide');
		}
		else{
			$('.other_specimen').addClass('hide');
			$('.noSpecimen').removeAttr('disabled','disabled');
			$('#final_classification').attr('disabled','disabled');
			$('#final_classification').removeAttr('required','required');
			$('.final_classification').addClass('hide');
			$('.specimen_adequate').removeClass('hide');
			$('.linked_epid_number').attr('disabled','disabled');	
			$('.linked_epid_number').addClass('hide');
			$('#linked_epid_number').val('');
			$('.clinically_compatible_with').attr('disabled','disabled');	
			$('.clinically_compatible_with').addClass('hide');
			$('#clinically_compatible_with').val('');
			$('#Ok11').addClass('hide');
			$('#linked_epid_number').removeAttr('required','required');	
			$('.specimen_quantity_adequate').attr('required','required');		
			//$('#hideLabPart').removeClass('hide');
		}
	});
	$(document).on('change','#final_classification',function(){
		if($(this).val() == 'Epi Linked'){
			$('.other_specimen').removeClass('hide');
			$('.noSpecimen').attr('disabled','disabled');
			$('.linked_epid_number').removeAttr('disabled','disabled');	
			$('.linked_epid_number').removeClass('hide');
			$('#linked_epid_number').attr('required','required');	
			$('#linked_epid_number').val('');
			$('#caseInformation').addClass('hide');
			$('#noEpidNumber').addClass('hide');
			$('#Ok11').removeClass('hide');
			$('.clinically_compatible_with').attr('disabled','disabled');	
			$('.clinically_compatible_with').addClass('hide');
			//$('#final_classification').attr('required','required');
			//$('#hideLabPart').removeClass('hide');
		}
		else if($(this).val() == 'Clinically Compatible'){		
			$('.other_specimen').addClass('hide');
			$('.noSpecimen').attr('disabled','disabled');
			$('.clinically_compatible_with').removeAttr('disabled','disabled');	
			$('.clinically_compatible_with').removeClass('hide');
			$('.linked_epid_number').attr('disabled','disabled');	
			$('.linked_epid_number').addClass('hide');
			$('#linked_epid_number').val('');
			$('#linked_epid_number').removeAttr('required','required');
			$('#caseInformation').addClass('hide');
			$('#noEpidNumber').addClass('hide');
			$('#Ok11').addClass('hide');
			//$('#final_classification').removeAttr('required','required');
			//$('#hideLabPart').removeClass('hide');
		}
		else if($(this).val() == 'Discarded'){
			$('.other_specimen').removeClass('hide');
			$('.noSpecimen').attr('disabled','disabled');			
			$('.linked_epid_number').attr('disabled','disabled');	
			$('.linked_epid_number').addClass('hide');
			$('#linked_epid_number').removeAttr('required','required');
			$('#linked_epid_number').val('');
			$('#caseInformation').addClass('hide');
			$('#noEpidNumber').addClass('hide');
			$('#Ok11').addClass('hide');
			$('.clinically_compatible_with').attr('disabled','disabled');	
			$('.clinically_compatible_with').addClass('hide');
			//$('#final_classification').removeAttr('required','required');
			//$('#hideLabPart').removeClass('hide');
		}
		else{			
			$('.other_specimen').addClass('hide');
			$('.noSpecimen').attr('disabled','disabled');
			$('.linked_epid_number').attr('disabled','disabled');	
			$('.linked_epid_number').addClass('hide');
			$('#linked_epid_number').val('');
			$('#linked_epid_number').removeAttr('required','required');
			$('#caseInformation').addClass('hide');
			$('#noEpidNumber').addClass('hide');
			$('#Ok11').addClass('hide');
			$('.clinically_compatible_with').attr('disabled','disabled');	
			$('.clinically_compatible_with').addClass('hide');
			//$('#final_classification').removeAttr('required','required');
			//$('#hideLabPart').removeClass('hide');
		}
	});
	$(document).on('change','#cases',function(){
		if($(this).val() == 'Msl'){
			$('#mslmsl').removeClass('hide');
			$('#otherddd').addClass('hide');	
			$('#testInput').addClass('hide');
			$('#otherTD').addClass('hide');	
			$('.measles').removeAttr('disabled','disabled');
			$('.otherdiseases').attr('disabled','disabled');			
		}
		else{
			$('#mslmsl').addClass('hide');
			$('#otherddd').removeClass('hide');
			$('#testInput').addClass('hide');
			$('#otherTD').removeClass('hide');	
			$('.measles').attr('disabled','disabled');
			$('.otherdiseases').removeAttr('disabled','disabled');		
		}
	});

	function fromDate(start_date_id, end_date_id){
    var from_date = $('#'+start_date_id).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
    var to_date = $("#"+end_date_id).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
    $("#"+end_date_id).datepicker('setStartDate', from_date);
    $("#"+end_date_id).datepicker('setEndDate', '+2y');
    if(to_date < from_date){
      $("#"+end_date_id).val('');
    }
  }
	function toDate(start_date_id, end_date_id){
		$('#'+start_date_id).datepicker('setStartDate', "1925-01-01");
		$('#'+start_date_id).datepicker('setEndDate', '+0d');
	}
	function setNewDate(start_date_id){
		$('#'+start_date_id).datepicker('setEndDate', '+0d');
	}
	$("#pvh_date").on( "click", function() {
		setNewDate('pvh_date');
	});
 /* $("#pvh_date").on( "click", function() {
        setNewDate('date_rash_onset');
      });*/

     /*$("#date_rash_onset").on( "change", function() {
        fromDate('date_rash_onset', 'date_rash_onset');
      });*/
    	$("#pvh_date").on( "change", function() {
        $('#date_rash_onset').datepicker('setStartDate', "1925-01-01");
   		$('#date_rash_onset').datepicker('setEndDate', $(this).val());
      });
      $("#pvh_date").on( "change", function() {
        $('#notification_date').datepicker('setStartDate', $(this).val());
   		$('#notification_date').datepicker('setEndDate');
      });
       $("#notification_date").on( "change", function() {
        $('#date_investigation').datepicker('setStartDate', $(this).val());
   		$('#date_investigation').datepicker('setEndDate');
      });

   //-------- Javascript for Cross Notification to other Provinces -------//
   $(document).on('change','#other_procode', function(){
		var procode = $('#other_procode').val();
		//if($("#other_procode").length == 0)
		if(procode == '<?php echo $_SESSION["Province"]; ?>') {
			//alert("abc");
		//not session province
		}else{
			//alert("xyz");
			$.ajax({
				type: "POST",
				data: "procode="+procode,
				url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
				success: function(result){
					$('#other_pro_district').html(result);
					$('#labresult_tobesentto_district').html(result);
					// $('#other_pro_district').trigger('change');
					// $('#labresult_tobesentto_district').trigger('change');
				}
			});
		}							
	});
	$(document).on('change','#other_pro_district', function(){
		var distcode = $('#other_pro_district').val();
		//to get tehsils of selected district
		//if($("#other_procode").length == 0)
		//alert(distcode);
		if(distcode == '<?php echo $_SESSION['District']; ?>') {
			//alert("abc");
		//not session province
		}else{
			//alert("xyz");
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceTehsils",
				success: function(result){
					$('#other_pro_tehsil').html(result);
					//$('#labresult_tobesentto_district').html(result);
					$('#other_pro_tehsil').trigger('change');
					//$('#labresult_tobesentto_district').trigger('change');
				}
			});
		}							
	});
	$(document).on('change','#other_pro_tehsil', function(){
		var tcode = $('#other_pro_tehsil').val();
		var other_pro_district = $('#other_pro_district').val();
		//to get tehsils of selected district
		//if($("#other_procode").length == 0)
		//alert(other_pro_district);
		if(other_pro_district == '<?php echo $_SESSION['District']; ?>' || tcode == "") {
			//alert("abc");
		//not session province
		}else{
			//alert("xyz");
			$.ajax({
				type: "POST",
				data: "tcode="+tcode,
				url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceUCs",
				success: function(result){
					$('#other_pro_uc').html(result);
					//$('#labresult_tobesentto_district').html(result);
					$('#other_pro_uc').trigger('change');
					//$('#labresult_tobesentto_district').trigger('change');
				}
			});
		}							
	});
	$(document).on('change','#th_procode',function(){
		if($(this).val() != '<?php echo $_SESSION["Province"]; ?>'){
			$('.kptravel_history').addClass('hide');
			$('.otherprovince').removeClass('hide');
			$('.kptravel_history').val('');
			$('.otherprovince').val('');
			$('#th_muhallah').removeAttr('readonly','readonly');
		}
	});
	 $(document).on('change','#th_procode', function(){
		var procode = $('#th_procode').val();
		//if($("#other_procode").length == 0)
		if(procode == '<?php echo $_SESSION["Province"]; ?>') {
			//alert("abc");
		//not session province
		}else{
			//alert("xyz");
			$.ajax({
				type: "POST",
				data: "procode="+procode,
				url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
				success: function(result){
					$('#th_district').html(result);
					//$('#labresult_tobesentto_district').html(result);
					// $('#other_pro_district').trigger('change');
					// $('#labresult_tobesentto_district').trigger('change');
				}
			});
		}							
	});
	$(document).on('change','#th_district', function(){
		var distcode = $('#th_district').val();
		//to get tehsils of selected district
		//if($("#other_procode").length == 0)
		//alert(distcode);
		if(distcode == '<?php echo $_SESSION['District']; ?>') {
			//alert("abc");
		//not session province
		}else{
			//alert("xyz");
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceTehsils",
				success: function(result){
					$('#th_tehsil').html(result);
					//$('#labresult_tobesentto_district').html(result);
					$('#th_tehsil').trigger('change');
					//$('#labresult_tobesentto_district').trigger('change');
				}
			});
		}							
	});
	$(document).on('change','#th_tehsil', function(){
		var tcode = $('#th_tehsil').val();
		var th_district = $('#th_district').val();
		//to get tehsils of selected district
		//if($("#other_procode").length == 0)
		//alert(th_district);
		if(th_district == '<?php echo $_SESSION['District']; ?>' || tcode == "") {
			//alert("abc");
		//not session province
		}else{
			//alert("xyz");
			$.ajax({
				type: "POST",
				data: "tcode="+tcode,
				url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceUCs",
				success: function(result){
					$('#th_uc').html(result);
					//$('#labresult_tobesentto_district').html(result);
					$('#th_uc').trigger('change');
					//$('#labresult_tobesentto_district').trigger('change');
				}
			});
		}							
	});

</script>

<script>
	function autocomplete(inp, arr) {
		/*the autocomplete function takes two arguments,
		the text field element and an array of possible autocompleted values:*/
		var currentFocus;
		/*execute a function when someone writes in the text field:*/
		inp.addEventListener("input", function(e) {
			var a, b, i, val = this.value;
			/*close any already open lists of autocompleted values*/
			closeAllLists();
			if (!val) { return false;}
			currentFocus = -1;
			/*create a DIV element that will contain the items (values):*/
			a = document.createElement("DIV");
			a.setAttribute("id", this.id + "autocomplete-list");
			a.setAttribute("class", "autocomplete-items");
			/*append the DIV element as a child of the autocomplete container:*/
			this.parentNode.appendChild(a);
			/*for each item in the array...*/
			for (i = 0; i < arr.length; i++) {
				/*check if the item starts with the same letters as the text field value:*/
				if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
					/*create a DIV element for each matching element:*/
					b = document.createElement("DIV");
					/*make the matching letters bold:*/
					b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
					b.innerHTML += arr[i].substr(val.length);
					/*insert a input field that will hold the current array item's value:*/
					b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
					/*execute a function when someone clicks on the item value (DIV element):*/
					b.addEventListener("click", function(e) {
						/*insert the value for the autocomplete text field:*/
						inp.value = this.getElementsByTagName("input")[0].value;
						/*close the list of autocompleted values,
						(or any other open lists of autocompleted values:*/
						closeAllLists();
					});
					a.appendChild(b);
				}
			}
		});
		/*execute a function presses a key on the keyboard:*/
		inp.addEventListener("keydown", function(e) {
			var x = document.getElementById(this.id + "autocomplete-list");
			if (x) x = x.getElementsByTagName("div");
			if (e.keyCode == 40) {
				/*If the arrow DOWN key is pressed,
				increase the currentFocus variable:*/
				currentFocus++;
				/*and and make the current item more visible:*/
				addActive(x);
			} else if (e.keyCode == 38) { //up
					/*If the arrow UP key is pressed,
					decrease the currentFocus variable:*/
					currentFocus--;
					/*and and make the current item more visible:*/
					addActive(x);
			} else if (e.keyCode == 13) {
					/*If the ENTER key is pressed, prevent the form from being submitted,*/
					e.preventDefault();
				if (currentFocus > -1) {
					/*and simulate a click on the "active" item:*/
					if (x) x[currentFocus].click();
				}
			}
		});
		function addActive(x) {
			/*a function to classify an item as "active":*/
			if (!x) return false;
			/*start by removing the "active" class on all items:*/
			removeActive(x);
			if (currentFocus >= x.length) currentFocus = 0;
			if (currentFocus < 0) currentFocus = (x.length - 1);
			/*add class "autocomplete-active":*/
			x[currentFocus].classList.add("autocomplete-active");
		}
		function removeActive(x) {
			/*a function to remove the "active" class from all autocomplete items:*/
			for (var i = 0; i < x.length; i++) {
				x[i].classList.remove("autocomplete-active");
			}
		}
		function closeAllLists(elmnt) {
			/*close all autocomplete lists in the document,
			except the one passed as an argument:*/
			var x = document.getElementsByClassName("autocomplete-items");
			for (var i = 0; i < x.length; i++) {
				if (elmnt != x[i] && elmnt != inp) {
					x[i].parentNode.removeChild(x[i]);
				}
			}
		}
		/*execute a function when someone clicks in the document:*/
		document.addEventListener("click", function (e) {
			closeAllLists(e.target);
		});
	}
	
		//alert("xyz");
	var distcode = '<?php echo $this-> session-> District; ?>';
	//alert(distcode);
	$.ajax({
		type: "POST",
		data: "distcode="+distcode,
		url: "<?php echo base_url(); ?>Ajax_cross_notified/getLinked_EpidNumber",
		success: function(result){
			var epidnumbers = jQuery.parseJSON(result);
			if(epidnumbers == ""){
				epidnumbers = "Empty";
			}
			//console.log(epidnumbers);			
			autocomplete(document.getElementById("linked_epid_number"), epidnumbers);
		}
		//epidnumbers = epidnumbers;
	});
	//alert(epidnumbers);
	
	$('#linked_epid_number').on('keyup', function() {
		$('#caseInformation').addClass('hide');
		$('#noEpidNumber').addClass('hide');
	});
	$('#Ok11').on('click', function() {
		var linked_epid_number = $('#linked_epid_number').val();
		//alert(linked_epid_number);
		$.ajax({
			type: "POST",
			data: "linked_epid_number="+linked_epid_number,
			url: "<?php echo base_url(); ?>Ajax_cross_notified/getLinked_CaseInformation",
			success: function(result){
				//var caseInformation = JSON.parse(result);
				//var caseInformation = jQuery.parseJSON(result);
				//console.log(result);
				if(result=='[]'){
					$('#caseInformation').addClass('hide');
					$('#noEpidNumber').removeClass('hide');
					$('#linked_epid_number').val('');
					$('#a').val('');
					$('#b').val('');
					$('#c').val('');
					$('#d').val('');
					$('#e').val('');
					$('#f').val('');
					$('#g').val('');
					$('#h').val('');
					$('.site_response').css('display','block');
					$('.site_response').css('color','red');
					$('#linked_epid_number').css('border-color','red');
				}
				else{
					var resultAwaited = "Result Awaited";
					$('#caseInformation').removeClass('hide');
					$('#noEpidNumber').addClass('hide');
					var obj = JSON.parse(result);
					$('#a').val(obj[0].patient_name);
					if(obj[0].specimen_result == null){
						$('#b').val(resultAwaited);	
					}else{
						$('#b').val(obj[0].specimen_result);	
					}				
					$('#c').val(obj[0].patient_fathername);
					$('#d').val(obj[0].patient_gender);
					$('#e').val(obj[0].contact_numb);
					$('#f').val(obj[0].fweek);					
					$('#g').val(obj[0].uc);
					$('#h').val(obj[0].patient_address);					
					$(".site_response").html('');
					$('.site_response').css('display','block');
					$('#linked_epid_number').css('border-color','#66AFE9');
				}
			}			
		});
	});
</script>