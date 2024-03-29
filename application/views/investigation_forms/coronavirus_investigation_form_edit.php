<!--start of page content or body-->
<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('d-m-Y');
	//print_r($coronavirus_Result);exit();
	if(isset($coronavirus_Result))
	{
		$startDate = date('d-m-Y',strtotime($coronavirus_Result->datefrom));
		$endDate = date('d-m-Y',strtotime($coronavirus_Result->dateto));
		//echo $startDate.' -- '.$endDate;exit;
	} 
?>
<div class="container bodycontainer">
	<div class="row">
 		<div class="panel panel-primary">
 			<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
	   	<div class="panel-heading"><?php if(isset($coronavirus_Result)){?> Update Coronavirus Investigation Form <?php }else{ ?> Add Coronavirus Investigation Form <?php } ?>
	   		<?php if(!isset($coronavirus_Result)){ ?>
				<div style="display: inline-block;float: right;">
					<span style="font-size: 15px;color:#F0FF00;">Cross Notify</span>&nbsp;&nbsp;
					<input id="cb_cross_notified" style="display: inline-block;float: right;margin-top: 9px;" type="checkbox">
				</div>
	   		<?php } ?>
   		</div>
     		<div class="panel-body">
      		<form class="form-horizontal" id="measles" onsubmit="return confirm('Are you sure you want to save/submit this form?')" action="<?php echo base_url(); ?>Coronavirus_investigation/coronavirus_investigation_save" method="post">
	   			<?php if(isset($coronavirus_Result)){ ?>
          			<input type="hidden" name="edit" id="edit" value="edit" />
          			<input type="hidden" name="id" id="id" value="<?php echo $coronavirus_Result-> id; ?>" />
          			<input type="hidden" name="cross_case_id" value="<?php echo $coronavirus_Result-> cross_case_id; ?>" />
          			<input type="hidden" name="case_epi_no" value="<?php echo $coronavirus_Result-> case_epi_no; ?>" />
         	 	<?php if($coronavirus_Result->cross_notified==1){echo '<input type="hidden" id="cross_notified" name="cross_notified" value="1" />';} ?>
        			<?php }else{ ?>
					<input type="hidden" id="cross_notified" name="cross_notified" />
					<?php } ?>
					<table class="table table-bordered   table-striped table-hover mytable2 mytable3">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Interview Detail</th>
							</tr>
						</thead>
						<tbody>													
							<tr>
								<td><p>Interview Date</td>
								<td><input class="dp form-control"  name="interviewer_date" id="interviewer_date" value="<?php if(isset($coronavirus_Result) && $coronavirus_Result->interviewer_date != NULL){ if($coronavirus_Result->interviewer_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($coronavirus_Result->interviewer_date)); }else{ echo ''; } } ?>" type="text" required="required" readonly="readonly"></td>
								<td><p>PoE</p></td>
								<td><input class="form-control" name="poe" id="poe" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->poe; } ?>" type="text"></td>
							</tr>
							<tr>
								<td><p>Interviewer Name</p></td>
								<td><input class="form-control" name="interviewer_name" id="interviewer_name" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->interviewer_name; } ?>" type="text" required="required"></td>
								<td><p>Designation</p></td> 
								<td>
									<input class="form-control" name="interviewer_designation" id="interviewer_designation" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->interviewer_designation; } ?>" type="text" required="required">
								</td>
							</tr>
							<tr>
								<td><p>Contact Number</p></td>
								<td><input class="form-control" name="interviewer_contact" id="interviewer_contact" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->interviewer_contact; } ?>" type="text" required="required"></td>
							</tr>							
            			</tbody>
	      			</table>
			<?php if(isset($coronavirus_Result->rb_distcode) && $coronavirus_Result->rb_distcode>0 && $coronavirus_Result-> cross_notified == 1 ){ ?>	
					<table id="rb_info" class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Case Refering Facility Information</th>
							</tr>
						</thead>
						<tbody>           
							<tr>
								<td><p>Province / Area</p></td>
								<!-- <td><p><?php //echo $this -> session -> provincename ?></p></td> -->
								<td>
									<?php 
									 if(isset($coronavirus_Result)){
									 	$rb_pcode = substr($coronavirus_Result->rb_distcode, 0,1);
									 }	
									?>
									<p><?php echo get_Province_Name($rb_pcode); ?></p>
								</td>
								<td><p>District</p></td>
								<td>
									<input type="hidden" id="rb_distcode" required="required" name="rb_distcode" value="<?php $distcode = (isset($coronavirus_Result))?$coronavirus_Result-> rb_distcode:$coronavirus_Result-> rb_distcode; echo $distcode; ?>">
									<p><?php echo CrossProvince_DistrictName($coronavirus_Result->rb_distcode); ?></p>
								</td>            
							</tr>
							<tr>
								<td><p>Tehsil / City</p></td>
								<td>
									<select id="rb_tcode" required="required" name="rb_tcode" class="form-control">
									<?php if(isset($coronavirus_Result) && $coronavirus_Result -> rb_tcode != ""){ ?>
									<option value="<?php echo $coronavirus_Result -> rb_tcode; ?>"><?php echo CrossProvince_TehsilName($coronavirus_Result -> rb_tcode); ?></option>
									<?php }else{ ?> 
									<?php getCrossProvince_TehsilOptions(false); } ?>
									</select>
								</td>
								<td><p>Union Council</p></td>
								<td>
									<select id="rb_uncode" required="required" name="rb_uncode" class="form-control">
									<!-- <?php //if(isset($coronavirus_Result) && $coronavirus_Result->rb_uncode != " "){ getUCs(false,$coronavirus_Result->rb_uncode,$coronavirus_Result -> rb_tcode); }else{ ?>
									<?php //getUCs_options(false); } ?> -->
									<?php if(isset($coronavirus_Result)){ ?>
									<option value="<?php echo $coronavirus_Result->rb_uncode; ?>" <?php if(validation_errors() != false) { echo set_select('rb_uncode',$coronavirus_Result->rb_uncode); }?> > <?php echo CrossProvince_UCName($coronavirus_Result->rb_uncode); ?> </option>
									<?php }else{} ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><p>Name of Reporting Health Facility</p></td>
								<td>
									<?php if(isset($coronavirus_Result)){ ?>
									<select class="form-control" required="required" name="rb_facode" id="rb_facode">
									<option value="<?php echo $coronavirus_Result->rb_facode; ?>"><?php echo CrossProvince_FacilityName($coronavirus_Result->rb_facode); ?></option>
									</select>
									<?php }else{ ?>
									<select class="form-control" required name="rb_facode" id="rb_facode"></select>
									<?php } ?>
								</td>
								<td><p>Address of Health Facility</p></td>
								<td><input class="form-control" name="rb_faddress" id="rb_faddress" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->rb_faddress; } ?>" type="text"></td>
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
								<td><p>Province / Area</p></td>
								<td><p><?php echo $this -> session -> provincename ?></p></td>
								<td><p>District</p></td>
								<td>
									<input type="hidden" id="rb_distcode" name="rb_distcode" value="<?php $distcode = (isset($coronavirus_Result))?$coronavirus_Result-> rb_distcode:$this-> session-> District;  echo $distcode; ?>">
									<p><?php echo CrossProvince_DistrictName($this-> session-> District); ?></p>
								</td>            
							</tr>
							<!-- <tr>
								<td><p>Tehsil / City</p></td>
								<td>
									<select id="rb_tcode" name="rb_tcode" class="form-control">
										<?php if(isset($coronavirus_Result) && $coronavirus_Result -> rb_tcode != ""){ ?>
										<option value="<?php echo $coronavirus_Result -> rb_tcode; ?>"><?php echo getCrossProvince_TehsilOptions(false,$coronavirus_Result -> rb_tcode); ?></option>
										<?php }else{ ?> 
										<?php getCrossProvince_TehsilOptions(false); } ?>
									</select>
								</td>
								<td><p>Union Council</p></td>
								<td>
									<select id="rb_uncode" name="rb_uncode" class="form-control">
										<?php if(isset($coronavirus_Result) && $coronavirus_Result->rb_uncode != " "){ getCrossProvince_UCsOptions(false,$coronavirus_Result->rb_uncode); }else{ ?>
										<?php getCrossProvince_UCsOptions(false); } ?>
									</select>
								</td>
							</tr> -->
							<!-- <tr>
								<td><p>Name of Reporting Health Facility</p></td>
								<td>
									<?php if(isset($coronavirus_Result)){ ?>
									<select class="form-control" name="rb_facode" id="rb_facode">
										<option value="<?php echo $coronavirus_Result->rb_facode; ?>"><?php echo $facility; ?></option>
									</select>
									<?php }else{ ?>
									<select class="form-control" required name="rb_facode" id="rb_facode"></select>
									<?php } ?>
								</td>
								<td><p>Address of Health Facility</p></td>
								<td><input class="form-control" name="rb_faddress" id="rb_faddress" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->rb_faddress; } ?>" type="text"></td>
							</tr> -->
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
						<?php if(isset($coronavirus_Result) && !$coronavirus_Result->rb_distcode>0 && $coronavirus_Result-> cross_notified != 1 ){ ?>	           
							<tr class="crossNotify">
								<td><p>Province/Area</p></td>
								<!-- <td><p><?php //echo $this -> session -> provincename ?></p></td> -->
								<td>
									<?php 
									 	if(isset($coronavirus_Result)){
									 		$rb_pcode = substr($coronavirus_Result->distcode, 0,1);
									  	}
									?>
									<p><?php echo get_Province_Name($rb_pcode); ?></p>
								</td>
								<td><p>District</p></td>
								<td id="districttd">
									<input type="hidden" id="distcode" name="distcode" value="<?php $distcode = (isset($coronavirus_Result))?$coronavirus_Result-> distcode:$coronavirus_Result-> distcode; echo $distcode; ?>">
									<p><?php echo CrossProvince_DistrictName($distcode); ?></p>
								</td>
							</tr>
							<tr class="crossNotify">
								<td><p>Tehsil/City</p></td>
								<td>
									<?php if(isset($coronavirus_Result)){ ?>
										<select class="form-control" name="tcode" id="tcode" required="required">
											<option value="<?php echo $coronavirus_Result->tcode; ?>"><?php echo $tehsil; ?></option>
											</select>
											<?php }else{ ?>
										<select class="form-control" name="tcode" id="tcode" required="required"></select>
									<?php } ?>
								</td>
								<td><p>Union Council</p></td>
								<td>
									<?php if(isset($coronavirus_Result)){ ?>
										<select class="form-control" required="required" name="uncode" id="uncode">
											<option value="<?php echo $coronavirus_Result->uncode; ?>"><?php echo $unioncouncil; ?></option>
										</select>
									<?php }else{ ?>
										<select class="form-control" name="uncode" id="uncode"></select>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
							<?php if(isset($coronavirus_Result) && $coronavirus_Result->cross_notified == 1 && $coronavirus_Result -> cross_notified_from_distcode == $this -> session -> District){}else{ ?>
							<tr id="healthFacilityTr">
								<td><p>Name of Reporting Health Facility</p></td>
								<td>
									<?php if(isset($coronavirus_Result)){ ?>
										<select class="form-control" required="required" name="facode" id="facode">
											<option value="<?php echo $coronavirus_Result->facode; ?>"><?php echo $facility; ?></option>
										</select>
									<?php }else{ ?>
										<select class="form-control" required name="facode" id="facode"></select>
									<?php } ?>
								</td>
								<td><p>Address of Health Facility</p></td>
								<td><input class="form-control" name="faddress" id="faddress" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->faddress; } ?>" type="text"></td>
							</tr>
							<?php } ?>
							<tr>
								<td><p>Year</p></td>
								<td>
									<select class="form-control text-center" required="required" name="year" id="year">
										<?php if(isset($coronavirus_Result)){ ?>
										<option value="<?php echo $coronavirus_Result->year; ?>"><?php echo $coronavirus_Result->year; ?></option>
										<?php }else{ ?>
										<?php echo $years; } ?>
									</select>
								</td>
								<td><p>EPI Week No</p></td>
								<td>
									<select class="form-control" required="required"  name="week" id="week">
										<?php if(isset($coronavirus_Result)){ ?>
										<option value="<?php echo sprintf("%02d",$coronavirus_Result->week); ?>">Week <?php echo sprintf("%02d",$coronavirus_Result->week); ?></option>
										<?php }else{ ?>
										<option>--Select Week No--</option>
										<?php } ?>
									</select>
								</td>
							</tr>
            				<tr>
								<td><p>Date From</p></td>
								<td><input class="form-control text-center" readonly="readonly" name="datefrom" id="datefrom" value="<?php if(isset($coronavirus_Result)){ echo date('d-M-Y',strtotime($coronavirus_Result->datefrom)); }?>"  placeholder="From" type="text"></td>
								<td><p>Date To</p></td>
								<td><input class="form-control text-center" readonly="readonly" name="dateto" id="dateto" value="<?php if(isset($coronavirus_Result)){ echo date('d-M-Y',strtotime($coronavirus_Result->dateto)); }?>" placeholder="To" type="text"></td>
							</tr>
            				<tr>
								<td><p>Date Patient Visited Hospital</p></td>
								<td class="disabledclass"><input class="dp form-control" required="required" name="pvh_date" id="pvh_date" value="<?php if(isset($coronavirus_Result)){ if($coronavirus_Result->pvh_date!= '1969-12-31' && $coronavirus_Result->pvh_date!= '1970-01-01' && $coronavirus_Result->pvh_date!= NULL){ echo date('d-m-Y',strtotime($coronavirus_Result->pvh_date)); }else{ echo ''; } } ?>" type="text"></td>
								<td><label>Type of Case</label></td>
								<td style="padding-top: 5px;">
									<?php echo getCoronaCaseTypes(false,$coronavirus_Result->case_type); ?>
									<input type="hidden" class="form-control text-center" name="case_type" id="cases" value="<?php if(isset($coronavirus_Result)){ echo ($coronavirus_Result->case_type); } ?>">
									<!-- <select class="form-control case_type" name="case_type" id="cases" required="required">
									<?php //echo (isset($coronavirus_Result) && $coronavirus_Result->case_type != '')?'':'<option>-Select-</option>'; ?>
									<?php //echo (isset($coronavirus_Result))?getMeaslesCaseTypes(true,$coronavirus_Result->case_type):getMeaslesCaseTypes(false); ?>
									</select> -->
								</td>
							</tr>
							<?php if(isset($coronavirus_Result) && $coronavirus_Result->cross_notified == 1 && $coronavirus_Result -> cross_notified_from_distcode == $this -> session -> District){}
							else if($coronavirus_Result->case_epi_no == '' && $coronavirus_Result->case_type != 'Msl' && $coronavirus_Result->fweek < '2018-11'){ ?>
								<tr><td><label></label></td></tr>
							<?php } else{ ?>			
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
												<td style="text-align: center; width: 3%;"><input type="hidden" name="dcode" id="dcode" value="<?php if(isset($distCode)){ echo $distCode; } ?>" /><label class="epid_code" style="margin-top: 7px;"><?php if(isset($distCode)){ echo $distCode; } ?></label>
												</td>
												<td style="width: 12%;">
													<select name="year" id="epid_year" class="form-control text-center epid_year" readonly>
														<?php if(isset($coronavirus_Result) && $coronavirus_Result->year != ''){ ?>
														<option value="<?php echo $coronavirus_Result -> year; ?>"><?php echo $coronavirus_Result -> year; ?></option>
														<?php }else{} //getAllYearsOptionsIncludingCurrent(false); 	 ?> 
													</select>
												</td>
												<?php if(isset($coronavirus_Result) && $coronavirus_Result->case_type != '' && $coronavirus_Result->facode != '') { ?>
													<td style="text-align: center; width: 3%;" id="case_code"><label><?php echo $coronavirus_Result -> case_type; ?></label></td> 
													<?php } else { ?>
												<td style="text-align: center; width: 3%;" id="case_code"><label>***</label></td>
												<?php } ?> 
												<td style="width: 4%;"><input class="form-control numberclass" name="a1" id="a1" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[0]; } ?>" type="text" readonly></td>
												<td style="width: 4%;"><input class="form-control numberclass" name="a2" id="a2" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[1]; } ?>" type="text" readonly></td>
												<td style="width: 4%;"><input class="form-control numberclass" name="a3" id="a3" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[2]; } ?>" type="text" readonly></td>
												<td style="width: 4%;"><input class="form-control numberclass" name="a4" id="a4" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[3]; } ?>" type="text" readonly></td>
												<td style="width: 4%;"><input class="form-control numberclass" name="a5" id="a5" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[4]; } ?>" type="text" readonly></td>
												<td style="width: 4%;"><input class="form-control numberclass" name="a6" id="a6" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($measleNumber)){ echo $measleNumber[5]; } ?>" type="text" readonly></td>												
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<?php } ?>							
							<tr>
								<td><p>Patient's Name</p></td>
								<td><input class=" form-control" required="required" name="name" id="name" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->name; } ?>" type="text"></td>
								<td><p>Gender</p></td>
								<td> 
									Male <input type="radio" id="gender" <?php if(!isset($coronavirus_Result)){ echo 'checked="checked"'; } ?> name="gender" <?php if(isset($coronavirus_Result) && $coronavirus_Result->gender == '1'){ echo 'checked="checked"'; } ?> value="1" >
									Female <input type="radio" id="gender" name="gender" <?php echo (isset($coronavirus_Result) && $coronavirus_Result->gender == 0)?'checked="checked"':''; ?> value="0" >
								</td>
							</tr>
							<tr>
								<td><p>Father's Name</p></td> 
								<td>
									<input class="form-control" name="fathername" id="fathername" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->fathername; } ?>" type="text">
								</td>
							</tr>
							<tr>
								<td><p>Age in Years</p></td>
								<td><input class="numberclass form-control" onkeypress="return !(event.charCode == 46)" name="age_in_year" id="age_in_year" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->age_in_year; } ?>" type="text"></td>
								<td><p>Occupation</p></td>
								<td><input class="form-control" name="occupation" id="occupation" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->occupation; } ?>" type="text"></td>
							</tr>
							<tr>
								<td><p>Nationality</p></td> 
								<td>
									<input class="form-control" name="nationality" id="nationality" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->nationality; } ?>" type="text" required="required">
								</td>
								<td><p>CNIC #</p></td> 
								<td>
									<input class="form-control" name="cnic" id="cnic" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->cnic; } ?>" type="text">
								</td>
							</tr>
							<tr>
								<td><p>Mobile Number</p></td>
								<td><input class="form-control" name="mobile" id="mobile" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->mobile; } ?>" type="text" required="required"></td>
								<td><p>Telephone Number</p></td>
								<td><input class="form-control" name="telephone" id="telephone" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->telephone; } ?>" type="text"></td>
							</tr>
            		</tbody>
      			</table>
      			<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Address of Patient in Pakistan</th>
							</tr>
						</thead>
						<tbody>
					<?php if(isset($coronavirus_Result) && $coronavirus_Result-> procode != $_SESSION["Province"] && $coronavirus_Result-> approval_status == 'Pending' && $coronavirus_Result->facode == '' ){ ?>	
							<tr class="otherProvinceAddress">	
								<td><p>Province</p></td>
								<td>
								<p><?php echo get_Province_Name($coronavirus_Result->procode); ?></p>	
									<input type="hidden" name="procode" value="<?php if(isset($coronavirus_Result)) { echo $coronavirus_Result-> procode; } ?>">	
								</td>
								<td><p>District</p></td>
								<td>
									<select name="patient_address_distcode" id="other_pro_district" class="otherprocode form-control">
										<?php if(isset($coronavirus_Result) && $coronavirus_Result -> patient_address_distcode > 0){ ?>
											<option selected="selected" value="<?php echo $coronavirus_Result -> patient_address_distcode; ?>"><?php echo CrossProvince_DistrictName($coronavirus_Result -> patient_address_distcode); ?></option>
										<?php }else{ ?>
											<?php getCrossProvince_DistrictsOptions(false,NULL,'Yes'); ?>
										<?php } ?>

									</select>

									<!-- <select name="patient_address_distcode" id="other_pro_distcode" class="procodekp form-control">
										<?php if(isset($coronavirus_Result) && $coronavirus_Result -> patient_address_distcode > 0){ ?>
											<option selected="selected" value="<?php echo $coronavirus_Result -> patient_address_distcode; ?>"><?php echo CrossProvince_DistrictName($coronavirus_Result -> patient_address_distcode); ?></option>
										<?php }else{ ?>
											<?php getCrossProvince_DistrictsOptions(false,NULL,'Yes'); ?>
										<?php } ?>

									</select> -->
									<!-- <?php //} ?> -->
								</td>
							</tr>
							<tr class="otherProvinceAddress">	
								<td><p>Tehsil/Town</p></td>
								<td>
									<select name="patient_address_tcode" id="other_pro_tehsil" class="otherprocode form-control">
										<?php echo getCrossProvince_TehsilOptions(false,$coronavirus_Result-> patient_address_tcode,$coronavirus_Result-> patient_address_distcode); ?>										
									</select>

									<!-- <select name="patient_address_tcode" id="other_pro_tcode" class="procodekp form-control">
										<?php //echo getCrossProvince_TehsilOptions(false,$coronavirus_Result-> patient_address_tcode,$coronavirus_Result-> patient_address_distcode); ?>										
									</select> -->
									<!-- <?php //} ?> -->
								</td>
								<td><p>UC</p></td>
								<td>	
									<select name="patient_address_uncode" id="other_pro_uc" class="otherprocode form-control">	
										<?php echo getCrossProvince_UCsOptions(false,$coronavirus_Result-> patient_address_uncode,$coronavirus_Result-> patient_address_tcode); ?>

									</select>

									<!-- <select name="patient_address_uncode" id="other_pro_uncode" class="procodekp form-control">	
										<?php //echo getCrossProvince_UCsOptions(false,$coronavirus_Result-> patient_address_uncode,$coronavirus_Result-> patient_address_tcode); ?>

									</select> -->
									<!-- <?php //} ?> -->
								</td>
							</tr>
						<?php } else if(isset($coronavirus_Result) && $coronavirus_Result->facode == '' ){ ?>	
							<tr class="otherProvinceAddress">	
								<td><p>Province</p></td>
								<td>
								<p><?php echo get_Province_Name($coronavirus_Result->procode); ?></p>	
									<input type="hidden" name="procode" value="<?php if(isset($coronavirus_Result)) { echo $coronavirus_Result-> procode; } ?>">								
									<!-- <select name="procode" id="other_procode" class="form-control" readonly>
										<option value="">--Select--</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->procode  == "1"){ echo 'selected="selected"';} } ?> value="1">Punjab</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->procode  == "2"){ echo 'selected="selected"';} } ?> value="2">Sindh</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->procode  == "3"){ echo 'selected="selected"';} } ?> value="3">Khyber Pakhtunkhwa</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->procode  == "4"){ echo 'selected="selected"';} } ?> value="4">Balochistan</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->procode  == "5"){ echo 'selected="selected"';} } ?> value="5">AJK</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->procode  == "8"){ echo 'selected="selected"';} } ?> value="8">FATA</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->procode  == "6"){ echo 'selected="selected"';} } ?> value="6">Gilgit Baltistan</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->procode  == "7"){ echo 'selected="selected"';} } ?> value="7">Islamabad</option>
									</select> -->
								</td>
								<td><p>District</p></td>
								<td>
									<!-- <p class="text-center"><?php echo CrossProvince_DistrictName($coronavirus_Result -> patient_address_distcode); ?></p>
									<input type="hidden" value="<?php echo $coronavirus_Result -> patient_address_distcode; ?>" name="patient_address_distcode" id="other_pro_district"> -->
									<select name="patient_address_distcode" id="other_pro_district" class="otherprocode form-control">
										<?php if(isset($coronavirus_Result) && $coronavirus_Result -> patient_address_distcode > 0){ ?>
											<option selected="selected" value="<?php echo $coronavirus_Result -> patient_address_distcode; ?>"><?php echo CrossProvince_DistrictName($coronavirus_Result -> patient_address_distcode); ?></option>
										<?php }else{ ?>
											<?php getCrossProvince_DistrictsOptions(false,NULL,'Yes'); ?>
										<?php } ?>

									</select>

									<select name="patient_address_distcode" id="other_pro_distcode" class="procodekp form-control">
										<?php if(isset($coronavirus_Result) && $coronavirus_Result -> patient_address_distcode > 0){ ?>
											<option selected="selected" value="<?php echo $coronavirus_Result -> patient_address_distcode; ?>"><?php echo CrossProvince_DistrictName($coronavirus_Result -> patient_address_distcode); ?></option>
										<?php }else{ ?>
											<?php getCrossProvince_DistrictsOptions(false,NULL,'Yes'); ?>
										<?php } ?>

									</select>
									<!-- <?php //} ?> -->
								</td>
							</tr>
							<tr class="otherProvinceAddress">	
								<td><p>Tehsil/Town</p></td>
								<td>
									<select name="patient_address_tcode" id="other_pro_tehsil" class="otherprocode form-control">
										<?php echo getCrossProvince_TehsilOptions(false,$coronavirus_Result-> patient_address_tcode,$coronavirus_Result-> patient_address_distcode); ?>										
									</select>

									<select name="patient_address_tcode" id="other_pro_tcode" class="procodekp form-control">
										<?php echo getCrossProvince_TehsilOptions(false,$coronavirus_Result-> patient_address_tcode,$coronavirus_Result-> patient_address_distcode); ?>										
									</select>
									<!-- <?php //} ?> -->
								</td>
								<td><p>UC</p></td>
								<td>	
									<select name="patient_address_uncode" id="other_pro_uc" class="otherprocode form-control">	
										<?php echo getCrossProvince_UCsOptions(false,$coronavirus_Result-> patient_address_uncode,$coronavirus_Result-> patient_address_tcode); ?>

									</select>

									<select name="patient_address_uncode" id="other_pro_uncode" class="procodekp form-control">	
										<?php echo getCrossProvince_UCsOptions(false,$coronavirus_Result-> patient_address_uncode,$coronavirus_Result-> patient_address_tcode); ?>

									</select>
									<!-- <?php //} ?> -->
								</td>
							</tr>
						<?php } else { ?>
							<tr id='patient1stTr' class="crossNotify">
								<td><p>Province / Area</p></td>
								<td>
									<p><?php echo $this -> session -> provincename ?></p>
									<input class="form-control" name="patient_address_procode"  readonly="readonly" id="patient_address_procode" placeholder="Khyber Pakhtunkhwa" type="hidden">
								</td>
								<td><p>District</p></td>
								<td id="patientDistcodeTd">
									<select id="patient_address_distcode" name="patient_address_distcode" class="form-control" readonly="readonly">
										<?php if(isset($coronavirus_Result) && $coronavirus_Result -> patient_address_distcode > 0){ ?>
										<option value="<?php echo $coronavirus_Result -> patient_address_distcode; ?>"><?php echo get_District_Name($coronavirus_Result -> patient_address_distcode); ?></option>
										<?php }else{ ?>
										<?php echo getDistricts_options(false,$distcode,'No'); ?>
										<?php } ?>
									</select>
								</td>            
							</tr>
							<tr id='patient2ndTr' class="crossNotify">
								<td><p>Tehsil / City</p></td>
								<td>
									<!-- <input id="patient_address_tcode" name="patient_address_tcode" class="form-control" required="readonly"> -->
									<select id="patient_address_tcode" name="patient_address_tcode" class="form-control">
										<?php if(isset($coronavirus_Result) && $coronavirus_Result -> patient_address_tcode > 0){ ?>
											<!-- <option value="<?php //echo $coronavirus_Result -> patient_address_tcode; ?>"> -->
											<?php echo getTehsils_options(false,$coronavirus_Result -> patient_address_tcode,$coronavirus_Result -> patient_address_distcode); ?>	
											<!-- </option> -->
										<?php }else{ ?> 
										<?php getTehsils_options(false); } ?>
									</select>									
								</td>
								<td><p>Union Council</p></td>
								<td>
								<select id="patient_address_uncode" name="patient_address_uncode" class="form-control">
									<?php if(isset($coronavirus_Result) && $coronavirus_Result->patient_address_uncode > 0){ ?>
										<!-- <option value="<?php //echo $coronavirus_Result -> patient_address_uncode; ?>"> -->
										<?php echo getUCs_options(false, $coronavirus_Result -> patient_address_uncode, $coronavirus_Result -> patient_address_tcode); ?>										
										<!-- </option> -->
										<?php }else{ ?>
									<?php getUCs_options(false); } ?>
								</select></td>
							</tr>
						<?php } ?>						
							<tr>
								<td><p>Village / Street / Mohallah</p></td>
								<td colspan="3"><input class=" form-control" name="patient_address" id="patient_address" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->patient_address; } ?>" type="text"></td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Travel History</th>
							</tr>
						</thead>
						<tbody>	
							<tr>
								<td id="plain"><p>Has Travel history <span style="color:red;">*</span></p></td>
								<td>
									<select name="have_travel_history" id="have_travel_history" class="form-control" required="required">
										<option value="">--Select--</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->have_travel_history == "1"){ echo 'selected="selected"';} } ?> value="1">Yes</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->have_travel_history == "0"){ echo 'selected="selected"';} } ?> value="0">No</option>
									</select>
								</td>								
							</tr>
							<tr class="iftravel">
								<td id="plain"><p>Had Travelled within country<span style="color:red;"></span></p></td>
								<td>
									<select name="have_travel_within_country" id="have_travel_within_country" class="form-control" required="required">
										<option value="">--Select--</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->have_travel_within_country == "1"){ echo 'selected="selected"';} } ?> value="1">Yes</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->have_travel_within_country == "0"){ echo 'selected="selected"';} } ?> value="0">No</option>
									</select>
								</td>
								<!-- <td>									
									<select name="have_travel_within_country" id="have_travel_within_country" class="form-control" required="required">
										<option value="">--Select--</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->have_travel_within_country  == "1"){ echo 'selected="selected"';} } ?> value="1">Yes</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->have_travel_within_country  == "2"){ echo 'selected="selected"';} } ?> value="2">No</option>
									</select>
								</td> -->
								<td><p>Province</p></td>
								<!-- <?php //if(isset($country_Visits) && $country_Visits->travel_history == "1") { ?> -->
								<td>
									<select name="from_procode" id="th_procode" class="form-control">
										<option value="">--Select--</option>
										<option <?php if(isset($country_Visits)){ if($country_Visits->from_procode == "1"){ echo 'selected="selected"';} } ?> value="1">Punjab</option>
										<option <?php if(isset($country_Visits)){ if($country_Visits->from_procode == "2"){ echo 'selected="selected"';} } ?> value="2">Sindh</option>
										<option <?php if(isset($country_Visits)){ if($country_Visits->from_procode == "3"){ echo 'selected="selected"';} } ?> value="3">Khyber Pakhtunkhwa</option>
										<option <?php if(isset($country_Visits)){ if($country_Visits->from_procode == "4"){ echo 'selected="selected"';} } ?> value="4">Balochistan</option>
										<option <?php if(isset($country_Visits)){ if($country_Visits->from_procode == "5"){ echo 'selected="selected"';} } ?> value="5">AJK</option>
										<option <?php if(isset($country_Visits)){ if($country_Visits->from_procode == "8"){ echo 'selected="selected"';} } ?> value="8">FATA</option>
										<option <?php if(isset($country_Visits)){ if($country_Visits->from_procode == "6"){ echo 'selected="selected"';} } ?> value="6">Gilgit Baltistan</option>
										<option <?php if(isset($country_Visits)){ if($country_Visits->from_procode == "7"){ echo 'selected="selected"';} } ?> value="7">Islamabad</option>
									</select>
								</td>
								<!-- <?php //} ?>  -->
							</tr>
							<tr>
								<td><p>District</p></td>
								<td>
									<!-- <?php //if(isset($cross_notified_from_distcode) && $cross_notified_from_distcode->th_procode != "3") { ?> -->
									<!-- <input name="th_district" id="th_district" class="otherprovince form-control" value="<?php //if(isset($cross_notified_from_distcode) && isset($cross_notified_from_distcode->th_district)){ echo ($cross_notified_from_distcode->th_district); } else{ echo ""; }?>"> -->
									<select name="from_distcode" id="th_district" class="otherprovince form-control">
										<!-- <option selected="selected" value="">--Select--</option> -->
										<?php getCrossProvince_DistrictsOptions(false,$country_Visits-> from_distcode,'Yes'); ?>										
									</select>									
									<select name="from_distcode" id="th_distcode" class="kptravel_history form-control">
										<!-- <option selected="selected" value="">--Select--</option> -->
										<?php getCrossProvince_DistrictsOptions(false,$country_Visits-> from_distcode,'Yes'); ?>										
									</select>
									<!-- <?php //} ?> -->
								</td>
								<td><p>Tehsil/Town</p></td>
								<td>
									<select name="from_tcode" id="th_tehsil" class="otherprovince form-control">
										<option>
											<?php if(isset($country_Visits-> from_tcode) && $country_Visits-> from_tcode > 0){ 
												//print_r($country_Visits);
												echo getCrossProvince_TehsilOptions(false,$country_Visits-> from_tcode,$country_Visits-> from_distcode); 
											} ?>
										</option>										
									</select>									
									<select name="from_tcode" id="th_tcode" class="kptravel_history form-control">
										<option>
											<?php if(isset($country_Visits-> from_tcode) && $country_Visits-> from_tcode > 0){ 
												echo getCrossProvince_TehsilOptions(false,$country_Visits-> from_tcode,$country_Visits-> from_distcode); } 
											?>
										</option>										
									</select>
								</td>
							</tr>
							<tr>
								<td><p>UC</p></td>
								<td>
									<select name="from_uncode" id="th_uc" class="otherprovince form-control">
										<option>
											<?php if(isset($country_Visits-> from_uncode) && $country_Visits-> from_uncode > 0){
												echo getCrossProvince_UCsOptions(false,$country_Visits-> from_uncode,$country_Visits-> from_tcode);
											} ?>
										</option>
									</select>									
									<select name="from_uncode" id="th_uncode" class="kptravel_history form-control">
										<option>
											<?php if(isset($country_Visits-> from_uncode) && $country_Visits-> from_uncode > 0){
												echo getCrossProvince_UCsOptions(false,$country_Visits-> from_uncode,$country_Visits-> from_tcode); 
											} ?>
										</option>
									</select>    
									<!-- <?php //} ?> -->
								</td>
								<td><p>Village/Muhallah</p></td>
								<td>
									<input name="from_address" id="th_muhallah" class="form-control" value="<?php if(isset($country_Visits) && isset($country_Visits->from_address)){ echo ($country_Visits->from_address); } else{ echo ""; }?>">
								</td>
							</tr>
							<tr class="datefromto">								
								<td><p>Visit Date From</p></td>
								<td><input class="dp form-control" name="date_from" id="date_from" readonly="readonly" value="<?php if(isset($country_Visits)){ if($country_Visits->date_from!= '1969-12-31' && $country_Visits->date_from!= NULL){ echo date('d-m-Y',strtotime($country_Visits->date_from)); }else{ echo ''; } } ?>"  type="text"></td>
								<td><p>Visit Date To</p></td>
								<td><input class="dp form-control" name="date_to" id="date_to" readonly="readonly" value="<?php if(isset($country_Visits)){ if($country_Visits->date_to!= '1969-12-31' && $country_Visits->date_to!= NULL){ echo date('d-m-Y',strtotime($country_Visits->date_to)); }else{ echo ''; } } ?>"  type="text"></td>
				         	</tr>
							<tr class="iftravel">
								<td id="plain"><p>Had Travelled Abroad?<span style="color:red;">*</span></p></td>
								<td>
									<select name="have_travel_abroad" id="have_travel_abroad" class="form-control" required="required">
										<option value="">--Select--</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->have_travel_abroad  == "1"){ echo 'selected="selected"';} } ?> value="1">Yes</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->have_travel_abroad  == "0"){ echo 'selected="selected"';} } ?> value="0">No</option>
									</select>
								</td>							
							</tr>
							<tr class="hadTravelledAbroad">
								<td><p>Country</p></td>
								<td>
									<input type="text" class="form-control" name="country" id="country" required="required" value="<?php if(isset($abroad_Cases)){ echo $abroad_Cases->country; } ?>">
								</td>
								<td><p>City / State</p></td>
								<td>
									<input type="text" class="form-control" name="city_state" id="city_state" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->city_state; } ?>">
								</td>
							</tr>
							<tr class="hadTravelledAbroad">
								<td><p>Departed Date</p></td>
								<td><input class="dp form-control" name="departed_date" id="departed_date" readonly="readonly" value="<?php if(isset($abroad_Cases)){ if($abroad_Cases->departed_date!= '1969-12-31' && $abroad_Cases->departed_date!= NULL){ echo date('d-m-Y',strtotime($abroad_Cases->departed_date)); }else{ echo ''; } } ?>"  type="text" required="required"></td>
								<td><p>Transit Site</p></td>
								<td>
									<input type="text" class="form-control" name="transit_site" id="transit_site" value="<?php if(isset($abroad_Cases)){ echo $abroad_Cases->transit_site; } ?>">
								</td>
							</tr>
							<tr>
								<td colspan="4"><strong>Note: </strong> If you have been to any of the 12 countries mentioned below in the last 30 days please select 'Yes' on all countries visited</td>
							</tr>								
							<tr>
								<td><p>USA</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_1 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_1" id="country_1" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_1 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_1" id="country_1" type="radio" class="active"> No
								</td>
								<td><p>China</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_2 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_2" id="country_2" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_2 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_2" id="country_2" type="radio" class="active"> No
								</td>
							</tr>
							<tr>
								<td><p>Italy</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_3 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_3" id="country_3" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_3 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_3" id="country_3" type="radio" class="active"> No
								</td>
								<td><p>Spain</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_4 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_4" id="country_4" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_4 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_4" id="country_4" type="radio" class="active"> No
								</td>
							</tr>
							<tr>
								<td><p>Germany</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_5 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_5" id="country_5" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_5 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_5" id="country_5" type="radio" class="active"> No
								</td>
								<td><p>Iran</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_6 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_6" id="country_6" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_6 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_6" id="country_6" type="radio" class="active"> No
								</td>
							</tr>
							<tr>
								<td><p>France</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_7 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_7" id="country_7" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_7 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_7" id="country_7" type="radio" class="active"> No
								</td>
								<td><p>Switzerland</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_8 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_8" id="country_8" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_8 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_8" id="country_8" type="radio" class="active"> No
								</td>
							</tr>
							<tr>
								<td><p>UK</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_9 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_9" id="country_9" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_9 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_9" id="country_9" type="radio" class="active"> No
								</td>
								<td><p>South Korea</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_10 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_10" id="country_10" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_10 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_10" id="country_10" type="radio" class="active"> No
								</td>
							</tr>
							<tr>
								<td><p>Netherlands</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_11 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_11" id="country_11" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_11 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_11" id="country_11" type="radio" class="active"> No
								</td>
								<td><p>Austria</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_12 == "1"){ echo 'checked="checked"';} } ?> value="1" name="country_12" id="country_12" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->country_12 == "0"){ echo 'checked="checked"';} } ?> value="0" name="country_12" id="country_12" type="radio" class="active"> No
								</td>
							</tr>							
							<tr>
								<td><p>Purpose of Visit</p></td>
								<td>
									<input type="text" class="form-control" name="visit_purpose" id="visit_purpose" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->visit_purpose; } ?>">
								</td>
								<td><p>Stay Duration</p></td>
								<td>
									<input type="text" class="form-control" name="stay_duration" id="stay_duration" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->stay_duration; } ?>">
								</td>
							</tr>
							<tr>
								<td><p>Address during stay in Pakistan</p></td>
								<td colspan="3">
									<input type="text" class="form-control" name="address_during_stay" id="address_during_stay" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->address_during_stay; } ?>">
								</td>								
							</tr>
							<tr>
								<td><p>Seasonal Influenza Vaccine?</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->influenza_vaccine == "1"){ echo 'checked="checked"';} } ?> value="1" name="influenza_vaccine" id="influenza_vaccine" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->influenza_vaccine == "0"){ echo 'checked="checked"';} } ?> value="0" name="influenza_vaccine" id="influenza_vaccine" type="radio" class="active"> No
								</td>
								<td><p>Do you know any persom having cough and fever?</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->know_any_person_with_symptons == "1"){ echo 'checked="checked"';} } ?> value="1" name="know_any_person_with_symptons" id="know_any_person_with_symptons" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->know_any_person_with_symptons == "0"){ echo 'checked="checked"';} } ?> value="0" name="know_any_person_with_symptons" id="know_any_person_with_symptons" type="radio" class="active"> No
								</td>
							</tr>
							<tr>
								<td><p>Date of Onset of Symptoms</p></td>
								<td><input class="dp form-control"  name="date_of_onset" id="date_of_onset" value="<?php if(isset($coronavirus_Result) && $coronavirus_Result->date_of_onset != NULL){ if($coronavirus_Result->date_of_onset!= '1969-12-31'){ echo date('d-m-Y',strtotime($coronavirus_Result->date_of_onset)); }else{ echo ''; } } ?>" type="text" required="required"></td>
							</tr>
							<tr>								
								<td><p>Date of Notification</p></td>
								<td><input class="dp form-control" required="required" name="date_of_notification" id="date_of_notification" readonly="readonly" value="<?php if(isset($coronavirus_Result)){ if($coronavirus_Result->date_of_notification!= '1969-12-31' && $coronavirus_Result->date_of_notification!= NULL){ echo date('d-m-Y',strtotime($coronavirus_Result->date_of_notification)); }else{ echo ''; } } ?>"  type="text"></td>
								<td><p>Date Reported</p></td>
								<td><input class="dp form-control" required="required" name="date_reported" id="date_reported" readonly="readonly" value="<?php if(isset($coronavirus_Result)){ if($coronavirus_Result->date_reported!= '1969-12-31' && $coronavirus_Result->date_reported!= NULL){ echo date('d-m-Y',strtotime($coronavirus_Result->date_reported)); }else{ echo ''; } } ?>"  type="text"></td>
				         	</tr>
							<tr>
								<td><p>Date of Investigation</p></td>
								<td><input class="dp form-control" name="date_of_investigation" id="date_of_investigation" readonly="readonly" value="<?php if(isset($coronavirus_Result) && $coronavirus_Result->date_of_investigation != NULL){ if($coronavirus_Result->date_of_investigation!= '1969-12-31'){ echo date('d-m-Y',strtotime($coronavirus_Result->date_of_investigation)); }else{ echo ''; } } ?>" type="text"></td>
								<td><p>Date of Quarantine</p></td>
								<td><input class="dp form-control" name="date_of_quarantine" id="date_of_quarantine" readonly="readonly" value="<?php if(isset($coronavirus_Result) && $coronavirus_Result->date_of_quarantine != NULL){ if($coronavirus_Result->date_of_quarantine!= '1969-12-31'){ echo date('d-m-Y',strtotime($coronavirus_Result->date_of_quarantine)); }else{ echo ''; } } ?>" type="text"></td>
							</tr>
						</tbody>
					</table>
     				
      				<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Signs / Symptoms</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><p>Has Fever?</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->is_fever == "1"){ echo 'checked="checked"';} } ?> value="1" name="is_fever" id="is_fever" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->is_fever == "0"){ echo 'checked="checked"';} } ?> value="0" name="is_fever" id="is_fever" type="radio" class="active"> No
								</td>
								<td><p>Has Cough?</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->is_cough == "1"){ echo 'checked="checked"';} } ?> value="1" name="is_cough" id="is_cough" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->is_cough == "0"){ echo 'checked="checked"';} } ?> value="0" name="is_cough" id="is_cough" type="radio" class="active"> No
								</td>
							</tr>	
							<tr>
								<td><p>Difficulty in Breathing?</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->difficulty_breathing == "1"){ echo 'checked="checked"';} } ?> value="1" name="difficulty_breathing" id="difficulty_breathing" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->difficulty_breathing == "0"){ echo 'checked="checked"';} } ?> value="0" name="difficulty_breathing" id="difficulty_breathing" type="radio" class="active"> No
								</td>
								<td><p>Any other symptom?</p></td>
								<td>
									<input class="form-control" type="text" name="any_other" id="any_other" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->any_other; } ?>">
								</td>
							</tr>
							<tr>
								<td><p>Any Chronic Ailment?</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->chronic_ailment == "1"){ echo 'checked="checked"';} } ?> value="1" name="chronic_ailment" id="chronic_ailment" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->chronic_ailment == "0"){ echo 'checked="checked"';} } ?> value="0" name="chronic_ailment" id="chronic_ailment" type="radio" class="active"> No
								</td>
								<td><p>If yes, mention</p></td>
								<td>
									<input class="form-control" type="text" name="chronic_ailment_desc" id="chronic_ailment_desc" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->chronic_ailment_desc; } ?>">
								</td>
							</tr>
						</tbody>
					</table>   
      				<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Clinical Screening</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><p>Temperature in Fahrenheit (&#8457)</p></td>
								<td>
									<input class="numberclass form-control" onkeypress="return !(event.charCode == 46)" type="text" name="temprature" id="temprature" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->temprature; } ?>">
								</td>
								<td><p>Blood Pressure (BP)</p></td>
								<td style="width: 30%;">
									<input style="width: 20%;" class="numberclass" onkeypress="return !(event.charCode == 46)" type="text" name="bp_from" id="bp_from" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->bp_from; } ?>"> / 
									<input style="width: 20%;" class="numberclass" onkeypress="return !(event.charCode == 46)" type="text" name="bp_to" id="bp_to" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->bp_to; } ?>"><strong> mmhg</strong>
								</td>
							</tr>
							<tr>								
								<td><p>Pulse / minute</p></td>
								<td>
									<input class="numberclass form-control" onkeypress="return !(event.charCode == 46)" type="text" name="pulse_rate" id="pulse_rate" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->pulse_rate; } ?>">
								</td>
								<td><p>Chest Auscultation</p></td>
								<td>
									<input class="numberclass form-control" onkeypress="return !(event.charCode == 46)" type="text" name="chest_asculation" id="chest_asculation" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->chest_asculation; } ?>">
								</td>
							</tr>
							<tr>
								<td><p>Have person retained at PoE:</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->retained_at_poe == "1"){ echo 'checked="checked"';} } ?> value="1" name="retained_at_poe" id="retained_at_poe" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->retained_at_poe == "0"){ echo 'checked="checked"';} } ?> value="0" name="retained_at_poe" id="retained_at_poe" type="radio" class="active"> No
								</td>
								<td><p>Number of days retained</p></td>
								<td>
									<input class="numberclass form-control" onkeypress="return !(event.charCode == 46)" type="text" name="no_of_days_retained" id="no_of_days_retained" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->no_of_days_retained; } ?>">
								</td>
							</tr>
							<tr>
								<td><p>Or shifted to hospital for isolation:</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->shifted_for_isolation == "1"){ echo 'checked="checked"';} } ?> value="1" name="shifted_for_isolation" id="shifted_for_isolation" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->shifted_for_isolation == "0"){ echo 'checked="checked"';} } ?> value="0" name="shifted_for_isolation" id="shifted_for_isolation" type="radio" class="active"> No
								</td>
								<td><p>Number of days admitted in isolation</p></td>
								<td>
									<input class="numberclass form-control" onkeypress="return !(event.charCode == 46)" type="text" name="days_admitted" id="days_admitted" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->days_admitted; } ?>">
								</td>
							</tr>
							<tr>
								<td><p>Have sample collected:</p></td>
								<td>
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->sample_collected == "1"){ echo 'checked="checked"';} } ?> value="1" name="sample_collected" id="sample_collected" type="radio"> Yes
									<input <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->sample_collected == "0"){ echo 'checked="checked"';} } ?> value="0" name="sample_collected" id="sample_collected" type="radio" class="active"> No
								</td>
								<td><p>Type of sample/specimen</p></td>
								<td>									
									<select name="sample_type" id="sample_type" class="form-control" required="required">
										<option value="">--Select--</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->sample_type == "Nasopharyngeal Swab (NP)"){ echo 'selected="selected"'; } } ?> value="Nasopharyngeal Swab (NP)">Nasopharyngeal Swab (NP)</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->sample_type == "Oropharyngeal Swab (OP)"){ echo 'selected="selected"'; } } ?> value="Oropharyngeal Swab (OP)">Oropharyngeal Swab (OP)</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->sample_type == "Sputum"){ echo 'selected="selected"'; } } ?> value="Sputum">Sputum</option>
									</select>
								</td>
							</tr>
							<tr>								
								<td><p>Date of Sampling/Collection</p></td>
								<td><input class="dp form-control" required="required" name="date_of_collection" id="date_of_collection" readonly="readonly" value="<?php if(isset($coronavirus_Result)){ if($coronavirus_Result->date_of_collection!= '1969-12-31' && $coronavirus_Result->date_of_collection!= NULL){ echo date('d-m-Y',strtotime($coronavirus_Result->date_of_collection)); }else{ echo ''; } } ?>"  type="text"></td>
								<td><p>Date of Shipment to NIH</p></td>
								<td><input class="dp form-control" required="required" name="date_of_shipment_to_nih" id="date_of_shipment_to_nih" readonly="readonly" value="<?php if(isset($coronavirus_Result)){ if($coronavirus_Result->date_of_shipment_to_nih!= '1969-12-31' && $coronavirus_Result->date_of_shipment_to_nih!= NULL){ echo date('d-m-Y',strtotime($coronavirus_Result->date_of_shipment_to_nih)); }else{ echo ''; } } ?>"  type="text"></td>
				         	</tr>
				         	<tr>
				         		<td><p>Test Result</p></td>
								<td>									
									<select name="test_result" id="test_result" class="form-control" required="required">
										<option value="">--Select--</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->test_result == "Positive"){ echo 'selected="selected"'; } } ?> value="Positive">Positive</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->test_result == "Negative"){ echo 'selected="selected"'; } } ?> value="Negative">Negative</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->test_result == "Pending"){ echo 'selected="selected"'; } } ?> value="Pending">Pending/Awaited</option>
									</select>
								</td>
								<td><p>Outcome</p></td>
								<td>									
									<select name="outcome" id="outcome" class="form-control" required="required">
										<option value="">--Select--</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->outcome == "Recovered"){ echo 'selected="selected"'; } } ?> value="Recovered">Patient Recovered</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->outcome == "Under Treatment"){ echo 'selected="selected"'; } } ?> value="Under Treatment">Patient Under Treatment</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->outcome == "Death"){ echo 'selected="selected"'; } } ?> value="Death">Patient Died</option>
										<option <?php if(isset($coronavirus_Result)){ if($coronavirus_Result->outcome == "Unknown"){ echo 'selected="selected"'; } } ?> value="Unknown">Unknown</option>
									</select>
								</td>
				         	</tr>
				         	<tr class="classOutcome">								
								<td><p>Date of Death</p></td>
								<td><input class="dp form-control" name="date_of_death" id="date_of_death" readonly="readonly" value="<?php if(isset($coronavirus_Result)){ if($coronavirus_Result->date_of_death!= '1969-12-31' && $coronavirus_Result->date_of_death!= NULL){ echo date('d-m-Y',strtotime($coronavirus_Result->date_of_death)); }else{ echo ''; } } ?>"  type="text"></td>								
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
								<?php if(isset($coronavirus_Result)) { ?>
								<td class="text-center" id="get_date"><?php if(isset($coronavirus_Result)){ echo $current_date; } ?></td>
								<input type="hidden" id="editted_date" name="editted_date" value="<?php if(isset($coronavirus_Result)){ echo date('d-m-Y',strtotime($coronavirus_Result->editted_date)); } else{ echo $current_date; } ?>" type="date">
								<input type="hidden" name="submitted_date" value="<?php if(isset($coronavirus_Result)){ echo $coronavirus_Result->submitted_date; } else{ echo $current_date; } ?>" type="date">
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
							<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
							<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" name="is_temp_saved" value="0" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit Form  </button>
							<button onclick="javascript:disablebuttons();" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset">
							<i class="fa fa-repeat"></i> Reset Form </button>
							<a href="<?php echo base_url(); ?>Coronavirus_investigation/coronavirus_investigation_list" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
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
		<?php if(isset($coronavirus_Result)){ ?>	
		//$('#rb_info').html('');
			var startDate = '<?php echo $startDate; ?>';
			var endDate = '<?php echo $endDate; ?>';
			dateSettingsForEdit(startDate, endDate);
			$('#pvh_date').trigger('change');
			<?php } else{ ?> 
			$('#rb_info').html('');
			<?php } ?> 	
			<?php if(isset($coronavirus_Result)){ ?>
			var outcome = '<?php echo $coronavirus_Result->outcome; ?>';
			$('.showComplication').addClass("hide");
			if (outcome == 'Complication') {
				$('.showComplication').removeClass("hide");
				$('.showDate').addClass("hide");
			}			
			if(outcome != 'Death'){
				$('.showDate').addClass("hide");
			}
		<?php } ?> 
		<?php if(!isset($coronavirus_Result)){ ?>
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
	
		// var get_date = $('#get_date').text();
		// $('#editted_date').val(get_date);	
		// var distcode = '<?php //echo $this -> session -> District; ?>';
		// $('#case_epi_no').val(distcode);               
		// var case_epi_no  = $('#case_epi_no').val();
		// $.ajax({
		// 	type: "GET",
		// 	data: "case_epi_no="+distcode,
		// 	url: "<?php //echo base_url(); ?>Ajax_calls/generate_measles_case_code",
		// 	success: function(result){
		// 		$('#case_epi_no').val(result);
		// 		case_epi_no  = $('#case_epi_no').val();
		// 		var newVal = case_epi_no;
		// 		$('#case_epi_no').val(newVal);
		// 	}
		// });
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
			if (selected == 'Unknown') { 
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
		
		selecteduncode = '<?php echo isset($coronavirus_Result)?$coronavirus_Result->uncode:0; ?>';
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
	<?php if(!isset($coronavirus_Result)) { ?>
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
						$.ajax({
							type: 'POST',
							url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksforCurrentYear',
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

function calEndDate(endDate)
{
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
function dateSettingsForAdd(startDate, endDate)
{
	endDate = calEndDate(endDate);
	$("#pvh_date").datepicker('setStartDate', startDate);
	$("#pvh_date").datepicker('setEndDate', endDate);
	$("#notification_date").datepicker('setEndDate', '+0d');
	$("#patient_dob").datepicker('setEndDate', '+0d');
	$("#date_collection").datepicker('setEndDate', '+0d');
	$("#date_sent_lab").datepicker('setEndDate', '+0d');
	$("#date_investigation").datepicker('setEndDate', '+0d');
}

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
	    if($('#doses_received').val() != '0')
		{
			fromDate('pvh_date', 'last_dose_date',true);//For Restrictions on last dose date
		}
	});
	//condition by usama for follow up 
	$("#date_investigation").on( "change", function() {
		//console.log(startDate);
	    addDays('date_investigation', 'followup_date', 30);//For Restrictions on specimen collection date
	});
	$("#date_rash_onset").on( "change", function() {
		//console.log(startDate);
	    addDays('date_rash_onset', 'date_collection', 2);//For Restrictions on specimen collection date
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
			fromDate('pvh_date', 'last_dose_date',true);//For Restrictions on last dose date
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
					dateSettingsForAdd(startDate, endDate);
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
			//it doesn't exist
		}						
	});
	$(document).on('change','#rb_uncode', function(){
		var uncode = $('#rb_uncode').val();
		//to get facilities of selected UC
		if(uncode =="") {
		  $('#rb_facode').html('');
		  //it doesn't exist
		}else{
			$.ajax({
				type: "POST",
				data: "uncode="+uncode,
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
			var case_type = $(".case_type").val();
			//var short_code = $('#distCode').text();			
			var case_type = $(this).val();
			if(case_type!= '-Select-'){
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_red_rec/getcase_definition',
					data:'case_type='+$(this).val(),
					success: function(data){
						if(case_type == 'Diph' || case_type == 'Anth'){
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
		});
		//('.case_type').trigger('change');
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
	var type_specimen  = $('#type_specimen').val();
	if(type_specimen == 'Other'){
		$('#other_specimen').removeClass('hide');
	}else{
		$('#other_specimen').addClass('hide');
	}
	$(document).on('change','#type_specimen',function(){
		if($(this).val() == 'Other'){
			$('#other_specimen').removeClass('hide');
		}else{
			$('#other_specimen').addClass('hide');
		}
	});
	// if($('#cb_cross_notified').not(':checked').length){
	// 	$('.crossNotify').removeClass('hide');
	// 	$('.otherProvinceAddress').addClass('hide');
	// }
	//cross_notified js code.
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

	<?php if(isset($country_Visits) && $country_Visits->from_procode == $_SESSION["Province"]){	?>
		//var proCode = $('#other_procode').val();
		//if(proCode == '3'){
		th_distcode = '<?php echo $country_Visits->from_distcode; ?>';
		th_tcode = '<?php echo $country_Visits->from_tcode; ?>';
		th_uncode = '<?php echo $country_Visits->from_uncode; ?>';
		//alert(patient_address_distcode);
		$('.kptravel_history').removeClass('hide');
		//$('.procodekp').val('');
		$('#th_distcode').prop(th_distcode);
		$('#th_tcode').val(th_tcode);
		$('#th_uncode').val(th_uncode);
		// $('#th_district').val(th_distcode);
		// $('#th_tehsil').val(th_tcode);
		// $('#th_uc').val(th_uncode);
		$('.otherprovince').addClass('hide');
		// $('.otherprocode').val('');
		$('#th_muhallah').removeClass('hide');
	<?php } else if(isset($country_Visits) && $country_Visits->from_procode != $_SESSION["Province"]) { ?>
		//}else if(proCode != '3' && proCode != ''){
		th_district = '<?php echo $country_Visits->from_distcode; ?>';
		th_tehsil = '<?php echo $country_Visits->from_tcode; ?>';
		th_uc = '<?php echo $country_Visits->from_uncode; ?>';
		$('.kptravel_history').addClass('hide');
		$('.otherprovince').removeClass('hide');
		// $('.procodekp').val('');
		$('#th_district').val(th_district);
		$('#th_tehsil').val(th_tehsil);
		$('#th_uc').val(th_uc);
		//$('.otherprocode').val('');
		$('#th_muhallah').removeClass('hide');		
	<?php } ?>
	var th_procode = $('#th_procode').val();
	if(th_procode == '<?php echo $_SESSION["Province"]; ?>'){
		// $('.kptravel_history').attr('disabled','disabled');
		// $('.otherprovince').removeAttr('disabled','disabled');		
		//$('.otherprovince').val('');
		$('#th_distcode').removeAttr('disabled','disabled');
		$('#th_tcode').removeAttr('disabled','disabled');
		$('#th_uncode').removeAttr('disabled','disabled');

		$('#th_district').attr('disabled','disabled');
		$('#th_tehsil').attr('disabled','disabled');
		$('#th_uc').attr('disabled','disabled');
	}
	else{
		// $('.kptravel_history').removeAttr('disabled','disabled');
		// $('.otherprovince').attr('disabled','disabled');
		//$('.kptravel_history').val('');
		$('#th_distcode').attr('disabled','disabled');
		$('#th_tcode').attr('disabled','disabled');
		$('#th_uncode').attr('disabled','disabled');

		$('#th_district').removeAttr('disabled','disabled');
		$('#th_tehsil').removeAttr('disabled','disabled');
		$('#th_uc').removeAttr('disabled','disabled');
	}
	
	// var travel_history = $('#travel_history').val();
	// if(travel_history == '1'){
	// 	$('#th_procode').removeClass('hide');
	// 	$('#th_muhallah').removeClass('hide');
	// 	$('#th_procode').val('');
	// 	$('#th_muhallah').val('');
	// }else{
	// 	$('#th_procode').addClass('hide');
	// 	$('.otherprovince').addClass('hide');
	// 	$('.kptravel_history').addClass('hide');
	// 	$('#th_muhallah').addClass('hide');
	// 	$('#th_procode').val('');
	// 	$('#th_muhallah').val('');
	// }

	<?php if(isset($coronavirus_Result) && $coronavirus_Result->have_travel_within_country == "1") { ?>		
		th_procode = '<?php echo $country_Visits->from_procode; ?>';
		$('#th_procode').prop(th_procode);
	<?php } else if(isset($coronavirus_Result) && $coronavirus_Result->have_travel_within_country != "1") { ?>
		//th_procode = '<?php //echo $country_Visits->from_procode; ?>';
		$('#th_procode').addClass('hide');//prop(th_procode);
		$('#th_procode').addClass('hide');
		$('.otherprovince').addClass('hide');
		$('#th_muhallah').addClass('hide');		
	<?php } ?>
	$(document).on('change','#have_travel_within_country',function(){
		if($(this).val() == '1'){
			$('#th_procode').removeClass('hide');
			//$('#th_muhallah').removeClass('hide');
			$('#th_procode').val('');
			$('#th_muhallah').val('');
		}else{
			$('#th_procode').addClass('hide');
			$('.otherprovince').addClass('hide');
			$('.kptravel_history').addClass('hide');
			$('#th_muhallah').addClass('hide');
			$('.kptravel_history').val('');
			$('.otherprovince').val('');
			$('#th_procode').val('');
			$('#th_muhallah').val('');
		}
	});
	$(document).on('change','#th_procode',function(){
		if($(this).val() == '<?php echo $_SESSION["Province"]; ?>'){
			$('.kptravel_history').removeClass('hide');
			$('.kptravel_history').val('');
			$('#th_muhallah').removeClass('hide');
			$('.otherprovince').addClass('hide');
			$('.otherprovince').val('');
			$('#th_muhallah').val('');
			
		}else if($(this).val() != '<?php echo $_SESSION["Province"]; ?>'){
			$('.kptravel_history').addClass('hide');
			$('.otherprovince').removeClass('hide');
			$('#th_muhallah').removeClass('hide');
			$('.kptravel_history').val('');
			$('.otherprovince').val('');
			$('#th_muhallah').val('');			
		}
	});
	<?php if(isset($coronavirus_Result) && $coronavirus_Result-> procode == $_SESSION["Province"] && $coronavirus_Result-> cross_notified == 0){	?>

		patient_address_distcode = '<?php echo $coronavirus_Result-> patient_address_distcode; ?>';
		patient_address_tcode = '<?php echo $coronavirus_Result-> patient_address_tcode; ?>';
		patient_address_uncode = '<?php echo $coronavirus_Result-> patient_address_uncode; ?>';
		//labresult_tobesentto = '<?php //echo $coronavirus_Result->labresult_tobesentto; ?>';
		//alert(patient_address_distcode);
		$('.procodekp').removeClass('hide');
		//$('.procodekp').val('');
		$('#patient_address_distcode').prop(patient_address_distcode);
		$('#patient_address_tcode').val(patient_address_tcode);
		$('#patient_address_uncode').val(patient_address_uncode);
		//$('#labresult_tobesentto').val(labresult_tobesentto);
		$('.otherprocode').addClass('hide');
		$('.otherprocode').val('');
		$('#patient_address').removeAttr('readonly','readonly');
	<?php } ?>
	<?php //if(isset($coronavirus_Result) && $coronavirus_Result-> procode != $_SESSION["Province"] && $coronavirus_Result-> cross_notified == 1 && $coronavirus_Result-> approval_status == 'Pending' && (substr($coronavirus_Result-> cross_notified_from_distcode, 0,1) == $_SESSION["Province"])) { ?>
				
	<?php //} ?>
	<?php if(isset($coronavirus_Result) && $coronavirus_Result-> procode == $_SESSION["Province"] && (substr($coronavirus_Result-> cross_notified_from_distcode, 0,1) == $_SESSION["Province"])){	?>
		//alert("klm");
		patient_address_distcode = '<?php echo $coronavirus_Result-> patient_address_distcode; ?>';
		patient_address_tcode = '<?php echo $coronavirus_Result-> patient_address_tcode; ?>';
		patient_address_uncode = '<?php echo $coronavirus_Result-> patient_address_uncode; ?>';
		$('.procodekp').removeClass('hide');
		//$('.procodekp').val('');
		$('#patient_address_distcode').prop(patient_address_distcode);
		$('#patient_address_tcode').val(patient_address_tcode);
		$('#patient_address_uncode').val(patient_address_uncode);
		//$('#labresult_tobesentto').val(labresult_tobesentto);
		$('.otherprocode').addClass('hide');
		$('.otherprocode').val('');
		$('#patient_address').removeAttr('readonly','readonly');		
		
	<?php } ?>
	<?php if(isset($coronavirus_Result) && $coronavirus_Result-> procode == $_SESSION["Province"] && $coronavirus_Result-> cross_notified == 1 && $coronavirus_Result-> approval_status == 'Approved' && (substr($cross_notified_from_distcode-> cross_notified_from_distcode, 0,1) != $_SESSION["Province"])) { ?>	
		//alert("csa");
		//}else if(proCode != '3' && proCode != ''){
		patient_address_distcode = '<?php echo $coronavirus_Result-> patient_address_distcode; ?>';
		patient_address_tcode = '<?php echo $coronavirus_Result-> patient_address_tcode; ?>';
		patient_address_uncode = '<?php echo $coronavirus_Result-> patient_address_uncode; ?>';		
		labresult_tobesentto_district = '<?php echo $coronavirus_Result-> labresult_tobesentto_district; ?>';
		$('.procodekp').addClass('hide');
		$('.otherprocode').removeClass('hide');
		$('.procodekp').val('');
		$('#other_pro_district').val(patient_address_distcode);
		$('#other_pro_tehsil').val(patient_address_tcode);
		$('#other_pro_uc').val(patient_address_uncode);
		$('#labresult_tobesentto_district').val(labresult_tobesentto_district);
		$('.otherprocode').val('');		
		$('#patient_address').removeAttr('readonly','readonly');
		// $('#labresult_tobesentto').addClass('hide');
		// $('#labresult_tobesentto_district').removeClass('hide');	
		// $('#labresult_tobesentto').removeAttr('required','required');
		// $('#labresult_tobesentto_district').attr('required','required');
		$('#other_pro_district').attr('required','required');
		$('#other_pro_tehsil').attr('required','required');
		$('#other_pro_uc').attr('required','required');	

		// $('#other_pro_district').removeAttr('disabled','disabled');
		// $('#other_pro_tehsil').removeAttr('disabled','disabled');
		// $('#other_pro_uc').removeAttr('disabled','disabled');
		$('#patient_address_distcode').attr('disabled','disabled');
		$('#patient_address_tcode').attr('disabled','disabled');
		$('#patient_address_uncode').attr('disabled','disabled');

		$('#other_pro_distcode').attr('disabled','disabled');
		$('#other_pro_tcode').attr('disabled','disabled');
		$('#other_pro_uncode').attr('disabled','disabled');
	<?php } ?>
	<?php //if(isset($cross_notified_from_distcode) && $cross_notified_from_distcode-> procode != $_SESSION["Province"]) { ?>
		// patient_address_distcode = '<?php //echo $cross_notified_from_distcode-> patient_address_distcode; ?>';
		// patient_address_tcode = '<?php //echo $cross_notified_from_distcode-> patient_address_tcode; ?>';
		// patient_address_uncode = '<?php //echo $cross_notified_from_distcode-> patient_address_uncode; ?>';
		// labresult_tobesentto_district = '<?php //echo $cross_notified_from_distcode-> labresult_tobesentto_district; ?>';
		
		// $('.procodekp').addClass('hide');
		// $('.otherprocode').removeClass('hide');
		// $('.procodekp').val('');
		// $('#other_pro_district').val(patient_address_distcode);
		// $('#other_pro_tehsil').val(patient_address_tcode);
		// $('#other_pro_uc').val(patient_address_uncode);
		// $('#labresult_tobesentto_district').val(labresult_tobesentto_district);
		// $('.otherprocode').val('');		
		// $('#patient_address').removeAttr('readonly','readonly');
		// $('#labresult_tobesentto').addClass('hide');
		// $('#labresult_tobesentto_district').removeClass('hide');	
		// $('#labresult_tobesentto').removeAttr('required','required');
		// $('#labresult_tobesentto_district').attr('required','required');	
	<?php //} ?>
	$(document).on('change','#other_procode',function(){
		if($(this).val() == '<?php echo $_SESSION["Province"]; ?>'){
			$('.procodekp').removeClass('hide');
			$('.procodekp').val('');
			$('.otherprocode').addClass('hide');
			$('.otherprocode').val('');
			$('#patient_address').val('');
			$('#patient_address').removeAttr('readonly','readonly');
			$('#labresult_tobesentto').removeClass('hide');
			$('#labresult_tobesentto_district').addClass('hide');
			$('#labresult_tobesentto').attr('required','required');
			$('#labresult_tobesentto_district').removeAttr('required','required');
		}else if($(this).val() != '<?php echo $_SESSION["Province"]; ?>' && $(this).val() != ''){
			$('.procodekp').addClass('hide');
			$('.otherprocode').removeClass('hide');
			$('.procodekp').val('');
			$('.otherprocode').val('');
			$('#patient_address').val('');
			$('#patient_address').removeAttr('readonly','readonly');
			$('#labresult_tobesentto').addClass('hide');
			$('#labresult_tobesentto_district').removeClass('hide');	
			$('#labresult_tobesentto').removeAttr('required','required');
			$('#labresult_tobesentto_district').attr('required','required');
		}
		else if( $(this).val() == ''){
			$('.procodekp').addClass('hide');
			$('.otherprocode').addClass('hide');
			$('.procodekp').val('');
			$('.otherprocode').val('');
			$('#patient_address').val('');
			$('#patient_address').attr('readonly','readonly');
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
	// $('#tcode').on('change', function() {
	// 	var tcode = $("#tcode").val();
	// 	$("#patient_address_tcode option[value="+tcode+"]").prop("selected",true);		
	// });
	// $('#uncode').on('change', function() {
	// 	var uncode = $("#uncode").val();
	// 	$("#patient_address_uncode option[value="+uncode+"]").prop("selected",true);
	// });
	$('#cases').on('change', function() {
		var cases = $("#cases").val();
		var year = $("#year").val();
		var distcode = $("#distcode").val();
		//alert(cases);
		$.ajax({
			type: "POST",
			data: "short_name="+cases,
			url: "<?php echo base_url(); ?>Ajax_red_rec/getCaseCode",
			success: function(result){
				$('#case_code').text(result);
				//$('#from_tcode').trigger('change');
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
				//$('#from_tcode').trigger('change');
			}
		});
		
	});

	$(document).ready(function(){
		$('.mselect').multiselect({
			buttonText: function(options, select) {
				if (options.length == 0) {
					return '-- Select --';
				}
				else {
					return options.length + ' ' + this.nSelectedText;
				}
			}
		});
	})
	var typespecimen  = $('.othertype').val();
	if(typespecimen == 'Other'){
		$('.otherspecimen').removeClass('hide');
	}else{
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
		$('#leekyes').prop('checked',false);
		$('#leekno').prop('checked',true);
		$('#testyes').prop('checked',true);
		$('#testno').prop('checked',false);
	}
	$(document).ready(function(){
		$('input:radio[name=quantity_adequate]').change(function() {
			if (this.value == 2) {
				//alert("abc");
				$('#lb').removeClass('hide');
				$('#itp').removeClass('hide');
				$('#leekyes').prop('checked',true);
				$('#leekno').prop('checked',false);
			}
			else if(this.value == 1){
				$('#lb').addClass('hide');
				$('#itp').addClass('hide');
				$('#leekyes').prop('checked',false);
				$('#leekno').prop('checked',true);
				$('#testyes').prop('checked',true);
				$('#testno').prop('checked',false);
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
	$(document).on('change','#cases',function(){
		if($(this).val() == 'Msl'){
			$('#mslmsl').removeClass('hide');
			$('#otherddd').addClass('hide');	
			$('.measles').removeAttr('disabled','disabled');
			$('.otherdiseases').attr('disabled','disabled');			
		}
		else{
			$('#mslmsl').addClass('hide');
			$('#otherddd').removeClass('hide');	
			$('.measles').attr('disabled','disabled');
			$('.otherdiseases').removeAttr('disabled','disabled');		
		}
	});
	var selected = $('#outcome').val();
		if (selected != 'Death') { 
			$('.classOutcome').addClass("hide");
			$('#date_of_death').val('');
		}
		$(document).on('change','#outcome', function(){
			var selected = $(this).val();
			if (selected == 'Recovered') { 
				$('.classOutcome').addClass("hide");
				$('#date_of_death').val('');
			}			
			if (selected == 'Under Treatment') {
				$('.classOutcome').addClass("hide");
				$('#date_of_death').val('');
			}
			if (selected == 'Death') {
				$('.classOutcome').removeClass("hide");
				$('#date_of_death').val(''); 
			}
			if (selected == 'Unknown') {
				$('.classOutcome').addClass("hide");
				$('#date_of_death').val(''); 
			}
			if (selected == '0') { 
				$('.classOutcome').addClass("hide");
				$('#date_of_death').val('');
			}
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

	$(document).on('change','#th_procode', function(){
		var procode = $('#th_procode').val();
		//if($("#other_procode").length == 0)
		if(procode == '<?php echo $_SESSION["Province"]; ?>') {
			$.ajax({
				type: "POST",
				data: "procode="+procode,
				url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
				success: function(result){
					$('#th_distcode').html(result);
					$('#th_distcode').removeAttr('disabled','disabled');
					$('#th_tcode').removeAttr('disabled','disabled');
					$('#th_uncode').removeAttr('disabled','disabled');

					$('#th_district').attr('disabled','disabled');
					$('#th_tehsil').attr('disabled','disabled');
					$('#th_uc').attr('disabled','disabled');
				}
			});
		//not session province
		}else{
			//alert("xyz");
			$.ajax({
				type: "POST",
				data: "procode="+procode,
				url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
				success: function(result){
					$('#th_district').html(result);
					$('#th_distcode').attr('disabled','disabled');
					$('#th_tcode').attr('disabled','disabled');
					$('#th_uncode').attr('disabled','disabled');

					$('#th_district').removeAttr('disabled','disabled');
					$('#th_tehsil').removeAttr('disabled','disabled');
					$('#th_uc').removeAttr('disabled','disabled');
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
		var from_distcode = $('#from_distcode').val();
		//to get tehsils of selected district
		//if($("#other_procode").length == 0)
		//alert(th_district);
		if(from_distcode == '<?php echo $_SESSION['District']; ?>' || tcode == "") {
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
	var have_travel_abroad = $('#have_travel_abroad').val();
	if(have_travel_abroad != 1){
		$('#country').removeAttr('required','required');
		$('#departed_date').removeAttr('required','required');
		$('.hadTravelledAbroad').addClass('hide');			
	}
	else{
		$('#country').attr('required','required');
		$('#departed_date').attr('required','required');
		$('.hadTravelledAbroad').removeClass('hide');
	}
	$(document).on('change','#have_travel_abroad', function(){
		var have_travel_abroad = $('#have_travel_abroad').val();	
			if(have_travel_abroad != 1){
			$('#country').removeAttr('required','required');
			$('#departed_date').removeAttr('required','required');
			$('.hadTravelledAbroad').addClass('hide');		
		}
		else{
			$('#country').attr('required','required');
			$('#departed_date').attr('required','required');
			$('.hadTravelledAbroad').removeClass('hide');
		}
	});	
	$("#cnic").inputmask("99999-9999999-9");
</script>