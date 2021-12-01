<?php
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('d-m-Y');
?>
	<div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
			<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
			<div class="panel-heading"> <?php if(isset($nntForm_Result)){ ?> Update NNT Investigation Form <?php }else{ ?> Add NNT Investigation Form <?php } ?>
				<?php if(!isset($nntForm_Result)){ ?>
					<div style="display: inline-block;float: right;">
						<span style="font-size: 15px;color:#F0FF00;">Cross Notify</span>&nbsp;&nbsp;
						<input id="cb_cross_notified" style="display: inline-block;float: right;margin-top: 9px;" type="checkbox">
					</div>
				<?php } ?>
   		</div>
     		<div class="panel-body">       
       		<form class="form-horizontal"  action="<?php echo base_url(); ?>Investigation_forms/nnt_investigation_Save" method="post" onsubmit="return confirm('Are you sure you want to save/submit this form?')" id="whereEntry">
					<?php if(isset($nntForm_Result)){ ?>
					<input type="hidden" name="edit" id="edit" value="edit" />
					<input type="hidden" name="id" id="id" value="<?php echo $nntForm_Result-> id; ?>" />
					<input type="hidden" name="cross_case_id" value="<?php echo $nntForm_Result-> cross_case_id; ?>" />
					<?php if($nntForm_Result->cross_notified==1){echo '<input type="hidden" id="cross_notified" name="cross_notified" value="1" />';} ?>
					<?php }else{ ?>
						<input type="hidden" id="cross_notified" name="cross_notified" />
					<?php } ?>
				<?php if(isset($nntForm_Result->rb_distcode) && $nntForm_Result->rb_distcode>0 && $nntForm_Result-> cross_notified == 1){ ?>	
					<table id="rb_info" class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
						<thead>
							<tr>
								<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Case Refering Facility Information</th>
							</tr>
						</thead>
						<tbody>           
							<tr>
								<td><p>Province/Area <span style="color:red;">*</span></p></td>
								<td>
                              <?php 
                                 if(isset($nntForm_Result)){
                                    $rb_pcode = substr($nntForm_Result-> rb_distcode, 0,1);
                                 } 
                              ?>
                              <p><?php echo get_Province_Name($rb_pcode); ?></p>
                           </td>
								<td><p>District <span style="color:red;">*</span></p></td>
								<td>
									<input type="hidden" id="rb_distcode" name="rb_distcode" required="required" value="<?php $distcode = (isset($nntForm_Result))?$nntForm_Result->rb_distcode:$this -> session -> District;  echo $distcode; ?>">
									<p><?php echo CrossProvince_DistrictName($nntForm_Result->rb_distcode); ?></p>
								</td>            
							</tr>
							<tr>
								<td><p>Tehsil/City <span style="color:red;">*</span></p></td>
								<td><select id="rb_tcode" name="rb_tcode" required="required" class="form-control">
								<?php if(isset($nntForm_Result) && $nntForm_Result -> rb_tcode != ""){ ?>
								<option value="<?php echo $nntForm_Result -> rb_tcode; ?>"><?php echo CrossProvince_TehsilName($nntForm_Result -> rb_tcode); ?></option>
								<?php }else{ ?> 
								<?php getTehsils_options(false); } ?>
								</select></td>
								<td><p>Union Council <span style="color:red;">*</span></p></td>
								<input id="module" type="hidden" value="disease_surveillance">
								<td><select id="rb_uncode" name="rb_uncode" required="required" class="form-control">
								<!-- <?php if(isset($nntForm_Result) && $nntForm_Result->rb_uncode != " "){ getUCs(false,$nntForm_Result->rb_uncode,$nntForm_Result -> rb_tcode); }else{ ?>
									<?php getUCs_options(false); } ?> -->
									<?php if(isset($nntForm_Result)){ ?>
									<option value="<?php echo $nntForm_Result->rb_uncode; ?>" <?php if(validation_errors() != false) { echo set_select(false,$nntForm_Result->rb_uncode); }?> > <?php echo CrossProvince_UCName($nntForm_Result->rb_uncode); ?> </option>
									<?php }else{} ?>
								</select></td>
							</tr>
							<tr>
								<td><p>Name of Reporting Health Facility <span style="color:red;">*</span></p></td>
								<td>
									<?php if(isset($nntForm_Result)){ ?>
									<select class="form-control" required="required" name="rb_facode" id="rb_facode">
										<option value="<?php echo $nntForm_Result->rb_facode; ?>"><?php echo CrossProvince_FacilityName($nntForm_Result->rb_facode); ?></option>
									</select>
									<?php }else{ ?>
									<select class="form-control" required name="rb_facode" id="rb_facode"></select>
									<?php } ?>
								</td>
								<td><p>Address of Health Facility <span style="color:red;">*</span></p></td>
								<td><input class="form-control" name="rb_faddress" id="rb_faddress" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->rb_faddress; } ?>" type="text"></td>
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
								<td>
									<!-- <input class="form-control"  readonly="readonly" placeholder="<?php echo $this -> session -> provincename ?>" type="text"> -->
									<p class="pt7"><?php echo $this -> session -> provincename ?></p>
								</td>
								<td><p>District <span style="color:red;">*</span></p></td>
								<td>
									<input type="hidden" id="rb_distcode" name="rb_distcode" value="<?php $distcode = (isset($nntForm_Result))?$nntForm_Result->rb_distcode:$this -> session -> District;  echo $distcode; ?>">
									<p><?php echo get_District_Name($this->session->District); ?></p>
								</td>            
							</tr>
							<tr>
								<td><p>Tehsil/City <span style="color:red;">*</span></p></td>
								<td>
									<select id="rb_tcode" name="rb_tcode" class="form-control">
										<?php if(isset($nntForm_Result) && $nntForm_Result -> rb_tcode != ""){ ?>
										<option value="<?php echo $nntForm_Result -> rb_tcode; ?>"><?php echo getTehsils_options(false,$nntForm_Result -> rb_tcode); ?></option>
										<?php }else{ ?> 
										<?php getTehsils_options(false); } ?>
									</select>
								</td>
								<td><p>Union Council <span style="color:red;">*</span></p></td>
								<input id="module" type="hidden" value="disease_surveillance">
								<td>
									<select id="rb_uncode" name="rb_uncode" class="form-control">
									<?php if(isset($nntForm_Result) && $nntForm_Result->rb_uncode != " "){ getUCs(false,$nntForm_Result->rb_uncode); }else{ ?>
									<?php getUCs_options(false); } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><p>Name of Reporting Health Facility <span style="color:red;">*</span></p></td>
								<td>
									<?php if(isset($nntForm_Result)){ ?>
									<select class="form-control" name="rb_facode" id="rb_facode">
										<option value="<?php echo $nntForm_Result->rb_facode; ?>"><?php echo $facility; ?></option>
									</select>
									<?php } else { ?>
										<select class="form-control" required name="rb_facode" id="rb_facode"></select>
									<?php } ?>
								</td>
								<td><p>Address of Health Facility <span style="color:red;">*</span></p></td>
								<td><input class="form-control" name="rb_faddress" id="rb_faddress" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->rb_faddress; } ?>" type="text"></td>
							</tr>
						</tbody>
					</table>
				<?php } ?>
        	<table class="table table-bordered table-striped table-hover mytable2 mytable3"> 
				<thead>
					<tr>
						<th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">PART I : For Use by Reporting Facility and DHO</th>
					</tr>
				</thead>
          	<tbody>
					<tr id="proTd1">
						<td><p>Province/Area <span style="color:red;">*</span></p></td>
						<td><p><?php echo $this -> session -> provincename ?></p></td>
						<td><p>District <span style="color:red;">*</span></p></td>
						<td id="districttd">
							<input type="hidden" id="distcode" name="distcode" value="<?php $distcode = (isset($nntForm_Result))?$nntForm_Result->distcode:$this -> session -> District;  echo $distcode; ?>">
							<p><?php echo get_District_Name($distcode); ?></p>
						</td>
					</tr>
					<tr id="proTd2">
						<td><p>Tehsil/City <span style="color:red;">*</span></p></td>
						<td>
							<?php if(isset($nntForm_Result)){ ?>
							<select class="form-control" name="tcode" id="tcode" required="required">
								<option value="<?php echo $nntForm_Result->tcode; ?>"><?php echo $tehsil; ?></option>
								</select>
								<?php }else{ ?>
							<select class="form-control" name="tcode" id="tcode"></select>
							<?php } ?>
						</td>
						<td><p>Union Council <span style="color:red;">*</span></p></td>
						<input id="module" type="hidden" value="disease_surveillance">
						<td>
							<?php if(isset($nntForm_Result)){ ?>
							<select class="form-control" required="required" name="uncode" id="uncode">
								<option value="<?php echo $nntForm_Result->uncode; ?>"><?php echo $unioncouncil; ?></option>
							</select>
								<?php }else{ ?>
							<select class="form-control" name="uncode" id="uncode"></select>
							<?php } ?>
						</td>
					</tr>
            <?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 && $nntForm_Result -> cross_notified_from_distcode == $this -> session -> District){}else{ ?>
					<tr id="healthFacilityTr">
						<td><p>Name of Reporting Health Facility <span style="color:red;">*</span></p></td>
               	<td>
							<?php if(isset($nntForm_Result)){ ?>
								<select class="form-control" required="required" name="facode" id="facode">
									<option value="<?php echo $nntForm_Result->facode; ?>"><?php echo get_Facility_Name($nntForm_Result -> facode); ?></option>
								</select>
							<?php }else{ ?>
								<select class="form-control" name="facode" id="facode"></select>
							<?php } ?>
						</td>       
						<td><p>Reported From <span style="color:red;">*</span></p></td>
						<td><input class="form-control" required="required" name="reported_from" id="reported_from" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->reported_from; } ?>" type="text"></td>
					</tr>
            <?php } ?>
					<tr>
						<td><p>Year <span style="color:red;">*</span></p></td>
						<td>
							<select class="form-control text-center" required="required" name="year" id="year">
								<?php if(isset($nntForm_Result)){ ?>
								<option value="<?php echo $nntForm_Result->year; ?>"><?php echo $nntForm_Result->year; ?></option>
								<?php }else{ ?>
								<?php echo $years; } ?>
							</select>
						</td>
						<td><p>Epid Week No <span style="color:red;">*</span></p></td>
						<td>
							<select class="form-control" required="required" name="week" id="week">
								<?php if(isset($nntForm_Result)){ ?>
									<option value="<?php echo sprintf("%02d",$nntForm_Result->week); ?>">Week <?php echo sprintf("%02d",$nntForm_Result->week); ?></option>
								<?php }else{ ?>
								<option>--Select Week No--</option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><p>Date From <span style="color:red;">*</span></p></td>
						<td><input class="form-control text-center" readonly="readonly" name="datefrom" id="datefrom" value="<?php if(isset($nntForm_Result)){ echo date('d-M-Y',strtotime($nntForm_Result->datefrom)); }?>"  placeholder="From" type="text"></td>
						<td><p>Date To <span style="color:red;">*</span></p></td>
						<td><input class="form-control text-center" readonly="readonly" name="dateto" id="dateto" value="<?php if(isset($nntForm_Result)){ echo date('d-M-Y',strtotime($nntForm_Result->dateto)); }?>" placeholder="To" type="text"></td>
					</tr>
					<tr>
						<!--<td><p>Case Reported</p></td>
						<td>
						Yes <input type="radio" id="case_reported" <?php if(!isset($nntForm_Result)){ echo 'checked="checked"'; } ?> name="case_reported" <?php if(isset($nntForm_Result) && $nntForm_Result->case_reported == '1'){ echo 'checked="checked"'; } ?> value="1" >
						No <input type="radio" id="case_reported" name="case_reported" <?php echo (isset($nntForm_Result) && $nntForm_Result->case_reported == 0)?'checked="checked"':''; ?> value="0" >
						</td>-->
					</tr>
					<tr>
						<td><p>Date of notification <span style="color:red;">*</span></p></td>
						<td class="disabledclass"><input class="dp form-control" required="required" name="date_notification" id="date_notification" value="<?php if(isset($nntForm_Result) && $nntForm_Result->date_notification != ""){ if($nntForm_Result->date_notification!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->date_notification)); }else{ echo ''; } } ?>" type="text"></td>
						<td><p>Reported By</p></td>
						<td class="disabledclass"><input class="form-control" name="reported_by" id="reported_by" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->reported_by; } ?>" type="text"></td>
					</tr>
					<tr>              
						<td><p>Diagnosed By</p></td>
						<td class="disabledclass"><input class="form-control" name="diagnosed_by" id="diagnosed_by" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->diagnosed_by; } ?>" type="text"></td>
						<td></td>
						<td class="disabledclass"></td>
					</tr>
					<tr>
						<td><p>Mode of reporting</p></td>
						<td class="disabledclass"><input class="form-control" name="mode_reporting" id="mode_reporting" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->mode_reporting; } ?>" type="text"></td>
						<td><p>Active surveillance to the hospital</p></td>
						<td class="disabledclass">
							<input <?php if(isset($nntForm_Result)){ if($nntForm_Result->active_sur_visit  == "1"){ echo 'checked="checked"';} } ?> value="1" name="active_sur_visit" id="active_sur_visit" type="radio"> Yes
							<input <?php if(isset($nntForm_Result)){ if($nntForm_Result->active_sur_visit  == "0"){ echo 'checked="checked"';} } ?> value="0" name="active_sur_visit" id="active_sur_visit" type="radio"> No
						</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align:center;"><p>Passive Reporting</p></td>
					</tr>
					<tr>
						<td><p>Informed by telephone call/SMS</p></td>
						<td class="disabledclass">
							<input <?php if(isset($nntForm_Result)){ if($nntForm_Result->informed_by_call  == "1"){ echo 'checked="checked"';} } ?> value="1" name="informed_by_call" id="informed_by_call" type="radio"> Yes
							<input <?php if(isset($nntForm_Result)){ if($nntForm_Result->informed_by_call  == "0"){ echo 'checked="checked"';} } ?> value="0" name="informed_by_call" id="informed_by_call" type="radio" class="active"> No
						</td>
						<td><p>Identified in weekly data</p></td>
						<td class="disabledclass">
							<input <?php if(isset($nntForm_Result)){ if($nntForm_Result->identified_weekly_data  == "1"){ echo 'checked="checked"';} } ?> value="1" name="identified_weekly_data" id="identified_weekly_data" type="radio"> Yes
							<input <?php if(isset($nntForm_Result)){ if($nntForm_Result->identified_weekly_data  == "0"){ echo 'checked="checked"';} } ?> value="0" name="identified_weekly_data" id="identified_weekly_data" type="radio" class="active"> No
						</td>
					</tr>
					<tr>
						<td><p>Date of Investigation</p></td>
						<td class="disabledclass"><input class="dp form-control" name="date_investigation" id="date_investigation" value="<?php if(isset($nntForm_Result) && $nntForm_Result->date_investigation != ""){ if($nntForm_Result->date_investigation!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->date_investigation)); }else{ echo ''; } } ?>" type="text"></td>         
						<td><p>Place of Investigation</p></td>
						<td id="placeInvestigationTd">
							<select id="place_investigation_facode" name="place_investigation_facode" class="form-control text-center"> -->
								<?php if(isset($nntForm_Result)){ ?>
								<option value="<?php echo $nntForm_Result->place_investigation_facode; ?>"><?php echo get_Facility_Name($nntForm_Result -> place_investigation_facode); ?></option>
								<?php }else{ ?>
								<?php getFacilities_options(false); } ?>                   
							</select>
						</td>
					</tr>
					<tr> 
						<td><p>Date of Onset</p></td>
						<td class="disabledclass"><input class="dp form-control" name="date_onset" id="date_onset" value="<?php if(isset($nntForm_Result) && $nntForm_Result->date_onset != ""){ if($nntForm_Result->date_onset!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->date_onset)); }else{ echo ''; } } ?>" type="text" required="required"></td>
						<td><p>Clinical Representation</p></td>
						<td><input class="form-control text-center" readonly="readonly" name="clinical_representation" id="clinical_representation" value="<?php if(isset($nntForm_Result)){ echo ($nntForm_Result->clinical_representation); } else{ echo "Unable to Suck & cry become stiff or has spasms"; }?>" type="text"></td>
					</tr>
					<tr>
						<td><p>Investigated by <span style="color:red;">*</span></p></td>
						<td class="disabledclass"><input class="form-control" required="required" name="investigated_by" id="investigated_by" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->investigated_by; } ?>" type="text"></td>

						<td class="disabledclass"><p>Date of notification at Federal level</p></td>
						<td><input class="dp form-control" name="date_notification_level" id="date_notification_level" value="<?php if(isset($nntForm_Result) && $nntForm_Result->date_notification_level !=""){ if($nntForm_Result->date_notification_level!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->date_notification_level)); }else{ echo ''; } } ?>" type="text"></td>
					</tr>
	            <tr>
	              <td><p>Cases</p></td>
	              <td class="disabledclass"><input class="form-control" name="cases" id="cases" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->cases; } ?>" type="text"></td>
	             
	              <td><p>Deaths</p></td>
	              <td class="disabledclass"><input class="form-control" name="deaths" id="deaths" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->deaths; } ?>" type="text"></td>
	            </tr>
	            <tr>
	              <td><p>Mothers Full name <span style="color:red;">*</span></p></td>
	              <td class="disabledclass"><input class="form-control" name="full_mother_name" id="full_mother_name" required="required" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->full_mother_name; } ?>" type="text"></td>
	             
	              <td><p>Head of household full name</p></td>
	              <td class="disabledclass"><input class="form-control" name="head_full_name" id="head_full_name" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->head_full_name; } ?>" type="text"></td>
	            </tr>
	            <tr>						
						<td class="disabledclass"><p>Baby date of birth <span style="color:red;">*</span></p></td>
						<td>
							<input class="dp form-control" name="baby_dob" id="baby_dob" value="<?php if(isset($nntForm_Result) && $nntForm_Result->baby_dob != ""){ if($nntForm_Result->baby_dob!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->baby_dob)); }else{ echo ''; } } ?>" type="text" required>
						</td>
						<td><p>Gender</p></td>
						<td class="disabledclass">
							<input <?php if(isset($nntForm_Result)){ if($nntForm_Result->gender  == "Male"){ echo 'checked="checked"';} } ?> value="Male" name="gender" id="gender" type="radio"> Male
							<input <?php if(isset($nntForm_Result)){ if($nntForm_Result->gender  == "Female"){ echo 'checked="checked"';} } ?> value="Female" name="gender" id="gender" type="radio" > Female
						</td>
					</tr>           
					<tr>						
						<td><p>Ethnic group</p></td>
						<td class="disabledclass"><input class="form-control" name="ethnic_group" id="ethnic_group" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->ethnic_group; } ?>" type="text"></td>
						<td><p>Contact Number</p></td>
						<td><input class="numberclass form-control" name="contact_numb" id="contact_numb" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->contact_numb; } ?>" type="text"></td>
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
							<?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 ){ ?>
	                     <p><?php echo get_Province_Name($nntForm_Result-> procode); ?></p> 
	                     <input type="hidden" name="procode" value="<?php if(isset($nntForm_Result)) { echo $nntForm_Result-> procode; } ?>">
	                  <?php } else { ?> 
								<select name="procode" id="other_procode" class="form-control allprocodes" required="required">
									
								</select>
							<?php } ?>
						</td>
						<td><p>District <span style="color:red;">*</span></p></td>
						<td>
							<?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 ){ ?>	 
                     <select name="nnt_distcode" id="other_pro_district" class="otherprocode form-control">
                        <?php if(isset($nntForm_Result) && $nntForm_Result -> nnt_distcode > 0){ ?>
                           <option selected="selected" value="<?php echo $nntForm_Result -> nnt_distcode; ?>"><?php echo CrossProvince_DistrictName($nntForm_Result -> nnt_distcode); ?></option>
                        <?php }else{ ?>
                           <?php getCrossProvince_DistrictsOptions(false,NULL,'Yes'); ?>
                        <?php } ?>

                     </select>

                     <select name="nnt_distcode" id="other_pro_distcode" class="procodekp form-control">
                        <?php if(isset($nntForm_Result) && $nntForm_Result -> nnt_distcode > 0){ ?>
                           <option selected="selected" value="<?php echo $nntForm_Result -> nnt_distcode; ?>"><?php echo CrossProvince_DistrictName($nntForm_Result -> nnt_distcode); ?></option>
                        <?php }else{ ?>
                           <?php getCrossProvince_DistrictsOptions(false,NULL,'Yes'); ?>
                        <?php } ?>

                     </select>

                  <?php } else { ?>   
							<select name="nnt_distcode" id="other_pro_district" class="otherprocode form-control hide">										
							</select>
							
							<select name="nnt_distcode" id="other_pro_distcode" class="procodekp form-control hide">
								<option selected="selected" value="">--Select--</option>
								<?php getDistricts_options(false,NULL,'Yes'); ?>
							</select>
						<?php } ?>   
						</td>
					</tr>
					<tr class="otherProvinceAddress">	
						<td><p>Tehsil/City <span style="color:red;">*</span></p></td>
						<td>
							<?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 ){ ?>	
	                     <select name="nnt_tcode" id="other_pro_tehsil" class="otherprocode form-control">
	                     <?php echo getCrossProvince_TehsilOptions(false,$nntForm_Result-> nnt_tcode,$nntForm_Result-> nnt_distcode); ?>                              
	                     </select>

	                     <select name="nnt_tcode" id="other_pro_tcode" class="procodekp form-control">
	                        <?php echo getCrossProvince_TehsilOptions(false,$nntForm_Result-> nnt_tcode,$nntForm_Result-> nnt_distcode); ?>                              
	                     </select>

                  	<?php } else { ?>		
								<select name="nnt_tcode" id="other_pro_tehsil" class="otherprocode form-control hide">										
								</select>
								
								<select name="nnt_tcode" id="other_pro_tcode" class="procodekp form-control hide">										
								</select>
							<?php } ?>
						</td>
						<td><p>UC <span style="color:red;">*</span></p></td>
						<td>
							<?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 ){ ?>  							
                     <select name="nnt_uncode" id="other_pro_uc" class="otherprocode form-control">
                        <?php echo getCrossProvince_UCsOptions(false,$nntForm_Result-> nnt_uncode,$nntForm_Result-> nnt_tcode); ?>

                     </select>

                     <select name="nnt_uncode" id="other_pro_uncode" class="procodekp form-control">
                        <?php echo getCrossProvince_UCsOptions(false,$nntForm_Result-> nnt_uncode,$nntForm_Result-> nnt_tcode); ?>

                     </select>

                  <?php } else { ?>
							<select name="nnt_uncode" id="other_pro_uc" class="otherprocode form-control hide">										
							</select>
							
							<select name="nnt_uncode" id="other_pro_uncode" class="procodekp form-control hide">										
							</select>
						<?php } ?>
						</td>
					</tr>
					<tr class="otherProvinceAddress">
						<td><p>Village / Street / Mohallah <span style="color:red;">*</span></p></td>
						<td colspan="3"><input class=" form-control" name="house_hold_address" id="patient_address" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->house_hold_address; } ?>" type="text"></td>
					</tr>
				<?php if(!isset($nntForm_Result) OR (isset($nntForm_Result) && $nntForm_Result-> cross_notified == 0)){ ?>  
					<tr id='patient1stTr' class="crossNotify">
						<td><p>Province <span style="color:red;">*</span></p></td>
						<td>
							<p><?php echo $this -> session -> provincename; ?></p>
							<input class="form-control" name="nnt_procode" value="<?php echo $this -> session -> Province; ?>" readonly="readonly" id="nnt_procode" placeholder="Khyber Pakhtunkhwa" type="hidden">
						</td>
						<td><p>District <span style="color:red;">*</span></p></td>
						<td id="patientDistcodeTd" class="disabledclass">
							<select class="form-control"  id="nnt_distcode" name="nnt_distcode">										
								<?php if(isset($nntForm_Result) && $nntForm_Result -> nnt_distcode > 0){ ?>
								<option value="<?php echo $nntForm_Result->nnt_distcode; ?>"><?php echo getDistricts_options(false,$nntForm_Result -> nnt_distcode,'No'); ?></option>
								<?php }else{ ?>
								<?php echo getDistricts_options(false,$distcode,'No'); ?>
								<?php } ?>
							</select>
						</td>           
					</tr>
					<tr id='patient2ndTr' class="crossNotify">
						<td><p>Tehsil <span style="color:red;">*</span></p></td>
						<td>
							<select class="form-control" id="nnt_tcode" name="nnt_tcode">
								<!-- <?php //if(isset($nntForm_Result) && $nntForm_Result -> nnt_tcode > 0){ ?>
								<option value="<?php //echo $nntForm_Result -> nnt_tcode; ?>"><?php //echo getTehsils_options(false,$nntForm_Result -> nnt_tcode,$nntForm_Result -> nnt_distcode); ?></option>
								<?php //}else{ ?> 
								<?php //getTehsils_options(false); } ?> -->

								<?php if(isset($nntForm_Result) && $nntForm_Result-> nnt_tcode > 0){ echo getTehsils_options(false,$nntForm_Result-> nnt_tcode, $nntForm_Result-> nnt_distcode); } else { ?>
   							<?php getTehsils_options(false); } ?>
							</select>
						</td>
						<td><p>Union Council <span style="color:red;">*</span></p></td>
						<td>
							<!-- <select class="form-control" id="nnt_uncode" name="nnt_uncode">
								<?php //if(isset($nntForm_Result)){ ?>
								<option value="<?php //echo $nntForm_Result->nnt_uncode; ?>" <?php //if(validation_errors() != false) { echo set_select('nnt_uncode',$nntForm_Result->nnt_uncode); }?> > <?php //echo get_UC_Name($nntForm_Result->nnt_uncode); ?> </option>
								<?php //}else{} ?>
							</select> -->

							<select class="form-control" id="nnt_uncode" name="nnt_uncode">
   						<?php if(isset($nntForm_Result) && $nntForm_Result->nnt_uncode > 0){ echo getUCs(false,$nntForm_Result->nnt_uncode,$nntForm_Result -> nnt_tcode); }else{ ?>
   						<?php getUCs_options(false); } ?>
   						</select>
						</td>
					</tr>
					<tr id='patient3rdTr' class="crossNotify">
						<td><p>Health Facility <span style="color:red;">*</span></p></td>
						<td class="disabledclass">
							<?php if(isset($nntForm_Result)){ ?>
								<select class="form-control" required name="nnt_facode" id="nnt_facode">
									<option value="<?php echo $nntForm_Result->nnt_facode; ?>"><?php echo $nnt_facility; ?></option>
								</select>
							<?php }else{ ?>
							<select class="form-control" required name="nnt_facode" id="nnt_facode"></select>
							<?php } ?>
						</td>
	            	<td><p>Household full address</p></td>
						<td class="disabledclass"><input class="form-control" name="house_hold_address" id="house_hold_address" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->house_hold_address; } ?>" type="text">
						</td>
					</tr>	
				<?php } ?>
				</tbody>
			</table>

        	<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass" style="width:100%">
				<thead>
					<tr>
						<th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Mothers Immunization Status</th> 
					</tr>
				</thead>
          	<tbody>
					<tr>
						<td style="width:30%"><p>Total number of TT doses received by the mother</p></td>
						<td style="width:30%">
							<select name="doses_received" id="tt_doses_rec_by_mother" class="form-control numberclass" > 
								<option value="0" <?php if(isset($nntForm_Result)){ if($nntForm_Result->doses_received  == "0"){ echo 'selected="selected"';} } ?>>Nil</option>
								<option value="1" <?php if(isset($nntForm_Result)){ if($nntForm_Result->doses_received  == "1"){ echo 'selected="selected"';} } ?>>1</option>
								<option value="2" <?php if(isset($nntForm_Result)){ if($nntForm_Result->doses_received  == "2"){ echo 'selected="selected"';} } ?>>2</option>
								<option value="3" <?php if(isset($nntForm_Result)){ if($nntForm_Result->doses_received  == "3"){ echo 'selected="selected"';} } ?>>3</option>
								<option value="4" <?php if(isset($nntForm_Result)){ if($nntForm_Result->doses_received  == "4"){ echo 'selected="selected"';} } ?>>4</option>
								<option value="5" <?php if(isset($nntForm_Result)){ if($nntForm_Result->doses_received  == "5"){ echo 'selected="selected"';} } ?>>5</option>
							</select>
						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p>Is her immunization history reported by</p></td>
						<td colspan="3" style="padding-top:7px;">
							<table style="width:100%;margin-top: 7px;">
								<tr>
									<td><input <?php if(isset($nntForm_Result)){ if($nntForm_Result->immunization_history == "1"){ echo 'checked="checked"';} } ?> value="1" name="immunization_history" id="immunization_history" class="group11" type="checkbox"> Doses</td>
									<td><input <?php if(isset($nntForm_Result)){ if($nntForm_Result->immunization_history == "2"){ echo 'checked="checked"';} } ?> value="2" name="immunization_history" id="immunization_history" class="group12" type="checkbox"> Card</td>
									<td><input <?php if(isset($nntForm_Result)){ if($nntForm_Result->immunization_history == "3"){ echo 'checked="checked"';} } ?> value="3" name="immunization_history" id="immunization_history" class="group11" type="checkbox"> Memory</td>
									<td><input <?php if(isset($nntForm_Result)){ if($nntForm_Result->immunization_history == "4"){ echo 'checked="checked"';} } ?> value="4" name="immunization_history" id="immunization_history" class="group12" type="checkbox"> Both</td>
									<td><input <?php if(isset($nntForm_Result)){ if($nntForm_Result->immunization_history == "5"){ echo 'checked="checked"';} } ?> value="5" name="immunization_history" id="immunization_history" class="group11" type="checkbox"> Unknown</td>
								</tr>
							</table>
						</td>              
					</tr>
            	<tr>
              		<td><p>If she has a card, copy the dates of all TT immunizations recorded on the card</p></td>
						<td colspan="3"> 
							<table style="width:100%">
								<tr>
									<td>1.</td>
									<td><input class="group16 dp form-control" name="card_date1" id="card_date1" value="<?php if(isset($nntForm_Result) && $nntForm_Result->card_date1 != ""){ if($nntForm_Result->card_date1!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->card_date1)); }else{ echo ''; } } ?>" type="text"></td>
									<td>2.</td>
									<td><input class="group17 dp form-control" name="card_date2" id="card_date2" value="<?php if(isset($nntForm_Result) && $nntForm_Result->card_date2 != ""){ if($nntForm_Result->card_date2!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->card_date2)); }else{ echo ''; } } ?>" type="text"></td>
									<td>3.</td>
									<td><input class="group18 dp form-control" name="card_date3" id="card_date3" value="<?php if(isset($nntForm_Result) && $nntForm_Result->card_date3 != ""){ if($nntForm_Result->card_date3!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->card_date3)); }else{ echo ''; } } ?>" type="text"></td>
									<td>4.</td>
									<td><input class="group19 dp form-control" name="card_date4" id="card_date4" value="<?php if(isset($nntForm_Result) && $nntForm_Result->card_date4 != ""){ if($nntForm_Result->card_date4!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->card_date4)); }else{ echo ''; } } ?>" type="text"></td>
									<td>5.</td>
									<td><input class="group20 dp form-control" name="card_date5" id="card_date5" value="<?php if(isset($nntForm_Result) && $nntForm_Result->card_date5 != ""){ if($nntForm_Result->card_date5!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->card_date5)); }else{ echo ''; } } ?>" type="text"></td>
								</tr>
							</table>
						</td>
            	</tr>
          	</tbody>
        	</table>
        	<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass" style="width:100%">
				<thead>
					<tr>
						<th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Mother's Antenatal Care</th>
					</tr>
				</thead>
         	<tbody>
					<tr>
						<td colspan="2"><p>How many visits did the mother make to a health facility during her pregnancy?</p></td>
						<td>
							<input class="numberclass form-control" name="pregnancy_visits" id="pregnancy_visits" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->pregnancy_visits; } ?>" required="required" type="text" style="width:90%;float:right;">
						</td>
						<td><p>Visits</p></td>
					</tr>
					<tr id="facilitiesVisistedTr">
						<td><p>List health facilities she visited</p></td>
						<td>
							<p style="display: inline;vertical-align: middle;">1 <span style="color:red;">*</span></p>
							<select id="facode1" name="facode1" class="form-control group2 " style="float: right;width: 90%;" required>
								<?php if(isset($nntForm_Result) && $nntForm_Result -> facode1 > 0 && $nntForm_Result -> procode == $_SESSION["Province"]){ ?>
								<option value="<?php echo $nntForm_Result -> facode1; ?>"><?php echo get_Facility_Name($nntForm_Result -> facode1); ?></option>
								<?php }else if (isset($nntForm_Result) && $nntForm_Result -> facode1 > 0 && $nntForm_Result -> procode != $_SESSION["Province"]){ ?>
									<option value="<?php echo $nntForm_Result -> facode1; ?>"><?php echo CrossProvince_FacilityName($nntForm_Result -> facode1); ?></option>
								<?php }else { ?>	
								<?php getFacilities_options(false); } ?>
							</select>
						</td>
						<td>
							<p style="display: inline;vertical-align: middle;">2 <span style="color:red;">*</span></p>
							<select id="facode2" name="facode2" class="form-control group2 " style="float: right;width: 90%;" required>
								<?php if(isset($nntForm_Result) && $nntForm_Result -> facode2 > 0 && $nntForm_Result -> procode == $_SESSION["Province"]){ ?>
								<option value="<?php echo $nntForm_Result -> facode2; ?>"><?php echo get_Facility_Name($nntForm_Result -> facode2); ?></option>
								<?php }else if (isset($nntForm_Result) && $nntForm_Result -> facode2 > 0 && $nntForm_Result -> procode != $_SESSION["Province"]){ ?>
									<option value="<?php echo $nntForm_Result -> facode2; ?>"><?php echo CrossProvince_FacilityName($nntForm_Result -> facode2); ?></option>
								<?php }else { ?>	
								<?php getFacilities_options(false); } ?>
							</select>
						</td>
						<td>
							<p style="display: inline;vertical-align: middle;">3 <span style="color:red;">*</span></p>
							<select id="facode3" name="facode3" class="form-control group2" style="float: right;width: 90%;" required>
								<?php if(isset($nntForm_Result) && $nntForm_Result -> facode3 > 0 && $nntForm_Result -> procode == $_SESSION["Province"]){ ?>
								<option value="<?php echo $nntForm_Result -> facode3; ?>"><?php echo get_Facility_Name($nntForm_Result -> facode3); ?></option>
								<?php }else if (isset($nntForm_Result) && $nntForm_Result -> facode3 > 0 && $nntForm_Result -> procode != $_SESSION["Province"]){ ?>
									<option value="<?php echo $nntForm_Result -> facode3; ?>"><?php echo CrossProvince_FacilityName($nntForm_Result -> facode3); ?></option>
								<?php }else { ?>	
								<?php getFacilities_options(false); } ?>
							</select>
						</td>  
					</tr>
          	</tbody>
        	</table>
			<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass" style="width:100%">
				<thead>
					<tr>
						<th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Delivery Practice</th>
					</tr>
				</thead>
          	<tbody>
					<tr>
						<td><p>Where was the baby delivered?</p></td>
						<td>
							<select id="where_baby_delivered" name="where_baby_delivered" class="form-control text-center" required="required">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->where_baby_delivered == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->where_baby_delivered == "Health facility"){ echo 'selected="selected"';} } ?> value="Health facility">Health facility</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->where_baby_delivered == "Home with trained attendent"){ echo 'selected="selected"';} } ?> value="Home with trained attendent">Home with trained attendent</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->where_baby_delivered == "Home without trained assistance"){ echo 'selected="selected"';} } ?> value="Home without trained assistance">Home without trained assistance</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->where_baby_delivered == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option>
							</select>
						</td>
						<td><p>How was the cord stump treated or dressed?</p></td>
						<td><input class="form-control" name="cord_treated" id="cord_treated" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result-> cord_treated; } ?>" type="text"></td>
					</tr>
					<tr>
						<td><p>If the delivery was in health facility, record the facility name and address</p></td>
						<td id="deliveryFacilityTd">
						<select id="n_facode" name="n_facode" class="group3 form-control">
							<?php if(isset($nntForm_Result)){ ?>
							<?php ($nntForm_Result -> n_facode > 0)?getFacilities_options(false,$nntForm_Result -> n_facode):getFacilities_options(false); ?>
							<?php }else{ ?>
							<?php getFacilities_options(false); } ?>
						</select></td>
						<td colspan="2"><input class="group3 form-control" name="address" id="address" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result-> address; } ?>" type="text"></td>
					</tr>
					<tr>
						<td><p>Medical record number</p></td>
						<td><input class="group3 form-control" name="med_record_number" id="med_record_number" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result-> med_record_number; } ?>" type="text"></td>
						<td><p>Date of admission</p></td>
						<td><input class="group3 dp form-control" name="date_admission" id="date_admission" value="<?php if(isset($nntForm_Result) && $nntForm_Result-> date_admission != ""){ if($nntForm_Result-> date_admission!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result-> date_admission)); }else{ echo ''; } } ?>" type="text"></td>
					</tr>
					<tr>              
						<td><p>Date of Delivery</p></td>
						<td class="disabledclass"><input class="dp form-control" name="date_delivery" id="date_delivery" value="<?php if(isset($nntForm_Result) && $nntForm_Result-> date_delivery != ""){ if($nntForm_Result-> date_delivery!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result-> date_delivery)); }else{ echo ''; } } ?>" type="text"></td>
						<td><p>Instrument Used</p></td>
						<td class="disabledclass"><input class="form-control" name="instrument_used" id="instrument_used" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result-> instrument_used; } ?>" type="text"></td>
            	</tr>
          	</tbody>
        	</table>
        	<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass" style="width:100%">
				<thead>
					<tr>
						<th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Baby's Symptoms</th>
					</tr>
				</thead>
          	<tbody>
					<tr>
						<td><p>Was the baby normal at birth?</p></td>
						<td style="width: 13%;">
							<select id="bs_normal_birth" name="bs_normal_birth" class="form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result-> bs_normal_birth == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result-> bs_normal_birth == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result-> bs_normal_birth == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result-> bs_normal_birth == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option>
							</select>
						</td>
						<td><p>How old (in days) was the baby when symptoms began?</p></td>
						<td>
							<table style="width:100%">
								<tr>
									<td>Days</td>
									<td style="width:50%"><input class="numberclass form-control" name="bs_days" id="bs_days" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->bs_days; } ?>" type="text" style="width: 90%;"></td>
									<td><input <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_days_unknown  == "1"){ echo 'checked="checked"';} } ?> value="1" name="bs_days_unknown" id="bs_days_unknown" type="checkbox">Unknown</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td><p>Baby had normal cry and suck during first 2 days?</p></td>
						<td>
							<select id="bs_cry" name="bs_cry" class="gr form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_cry  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_cry  == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_cry  == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_cry  == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option>
							</select>
						</td>
						<td><p>Baby stopped sucking after 2 days?</p></td>
						<td>
							<select id="bs_stop_sucking" name="bs_stop_sucking" class="gr form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_stop_sucking  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_stop_sucking  == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_stop_sucking  == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_stop_sucking  == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option>  
							</select>
						</td>   
					</tr>
            	<tr>
	              	<td><p>Stiffness</p></td>
	              	<td>
							<select id="bs_stiffness" name="bs_stiffness" class="gr form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_stiffness == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_stiffness == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_stiffness == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_stiffness == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option> 
							</select>
	               </td>
	              	<td><p>Spasms or convulsions</p></td>
						<td>
							<select id="bs_spasms" name="bs_spasms" class="gr form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_spasms == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_spasms == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_spasms == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_spasms == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option> 
							</select>
						</td>   
	            </tr>
	            <tr>
						<td><p>Was case confirmed as neonatal tetanus</p></td>
						<td>
							<select id="bs_case_confirmed" name="bs_case_confirmed" class="group9 form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_case_confirmed  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_case_confirmed  == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->bs_case_confirmed  == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
							</select>
						</td>
						<td><p>If yes to last 4 statements, tick Yes to show case confirmed as Neonaltal Tetanus</p></td>
						<td  style="padding-top: 12px;"><input <?php if(isset($nntForm_Result)){ if($nntForm_Result->nnt_confirmed  == "1"){ echo 'checked="checked"';} } ?> value="1" name="nnt_confirmed" id="nnt_confirmed" type="checkbox" class="group9"> Yes case is Neonatal Tetanus</td>   
	            </tr>
         	</tbody>
       	</table>
			<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass" style="width:100%">
				<thead>
					<tr>
						<th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Treatment</th>
					</tr>
				</thead>
       		<tbody>
            	<tr>
						<td><p>Was sick baby cared for in a health facility?</p></td>
						<td style="width: 13%;">
							<select id="tr_cared" name="tr_cared" class="form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_cared  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_cared  == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_cared  == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_cared  == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option> 
							</select>
						</td>
              		<td><p>If yes, record the name of health facility and district</p></td> 
						<td>
							<table style="width:100">
								<tr>
									<td id="facodeTd">
										<select id="tr_facode" name="tr_facode" class="group4 form-control text-center">
											<?php if(isset($nntForm_Result)){ ?>
											<option value="<?php echo $nntForm_Result -> tr_facode; ?>"><?php echo CrossProvince_FacilityName($nntForm_Result -> tr_facode); ?></option>
											<?php }else{ ?>
											<?php getFacilities_options(false); } ?>
										</select>
									</td>                  
									<td id="treatmentDistcodeTd">
										<select id="tr_distcode" name="tr_distcode" class="group4 form-control text-center">											
											<?php if(isset($nntForm_Result) && $nntForm_Result -> tr_distcode > 0){ ?>
											<option value="<?php echo $nntForm_Result->tr_distcode; ?>"><?php echo getCrossProvince_DistrictsOptions(false,$nntForm_Result -> tr_distcode,'No'); ?></option>
											<?php }else{ ?>
											<?php echo getDistricts_options(false,$distcode,'No'); ?>
											<?php } ?>
										</select>
									</td>
								</tr>
							</table>
						</td>   
            	</tr>
            	<tr>
						<td><p>Did the sick baby die</p></td>
						<td>
							<select id="tr_baby_died" name="tr_baby_died" class="form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_baby_died  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_baby_died  == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_baby_died  == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_baby_died  == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option> 
							</select>
						</td>
						<td><p>If died , date of death</p></td> 
						<td><input class="group5 dp form-control" name="b_death_date" id="b_death_date" value="<?php if(isset($nntForm_Result) && $nntForm_Result->b_death_date != ""){ if($nntForm_Result->b_death_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->b_death_date)); }else{ echo ''; } } ?>" type="text"></td>   
					</tr>
					<tr>
						<td><p>Did the mother die</p></td>
						<td>
							<select id="tr_mother_died" name="tr_mother_died" class="form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_mother_died  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_mother_died  == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_mother_died  == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->tr_mother_died  == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option> 
							</select>
						</td>
						<td><p>If died , date of death</p></td> 
						<td><input class="group6 dp form-control" name="m_death_date" id="m_death_date" value="<?php if(isset($nntForm_Result) && $nntForm_Result->m_death_date != ""){ if($nntForm_Result->m_death_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->m_death_date)); }else{ echo ''; } } ?>" type="text"></td>   
					</tr>
          	</tbody>
        	</table>
        	<table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass" style="width:100%">
				<thead>
					<tr>
						<th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Case Response</th>
					</tr>
				</thead>
          	<tbody>
					<tr>
						<td><p>Mother immunized in response to NT?</p></td>
						<td style="width: 13%;">
							<select id="cr_mother_immunized" name="cr_mother_immunized" class="form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_mother_immunized == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_mother_immunized == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_mother_immunized == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_mother_immunized == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option> 
							</select>
						</td>
						<td><p>If yes, date of Immunization </p></td>
						<td><input class="group7 dp form-control" name="cr_immunized_date" id="cr_immunized_date" value="<?php if(isset($nntForm_Result) && $nntForm_Result->cr_immunized_date != ""){ if($nntForm_Result->cr_immunized_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($nntForm_Result->cr_immunized_date)); }else{ echo ''; } } ?>" type="text"></td>
					</tr>
					<tr>
						<td><p>Did a case response take place in her locality?</p></td>
						<td>
							<select id="cr_case_response" name="cr_case_response" class="form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_case_response == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_case_response == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_case_response == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_case_response == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option> 
							</select>
						</td>
						<td><p>If yes, number of women vaccinated </p></td>
						<td><input class="group8 numberclass form-control" name="cr_numb_women_vaccinated" id="cr_numb_women_vaccinated" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->cr_numb_women_vaccinated; } ?>" type="text"></td>
					</tr>
					<tr>
						<td><p>Was an active case search done?</p></td>
						<td>
							<select id="cr_case_search" name="cr_case_search" class="form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_case_search == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_case_search == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_case_search == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_case_search == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option> 
							</select>
						</td>
						<td><p>Number of NT cases with onset within the past 12 months identified during active case search in the community </p></td>
						<td><input class="numberclass form-control" name="cr_numb_nt_cases" id="cr_numb_nt_cases" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->cr_numb_nt_cases; } ?>" type="text"></td>
					</tr>
					<tr>
						<td><p>Health education imparted regarding vaccine importance and clean delivery practice from health worker</p></td>
						<td>
							<select id="cr_vaccine_importance" name="cr_vaccine_importance" class="form-control text-center">
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_vaccine_importance == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_vaccine_importance == "Yes"){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_vaccine_importance == "No"){ echo 'selected="selected"';} } ?> value="No">No</option>
								<option <?php if(isset($nntForm_Result)){ if($nntForm_Result->cr_vaccine_importance == "Unknown"){ echo 'selected="selected"';} } ?> value="Unknown">Unknown</option> 
							</select>
						</td>
						<td><p>Follow up visit</p></td>
						<td><input class="numberclass form-control" name="follow_up_visits" id="follow_up_visits" value="<?php if(isset($nntForm_Result)){ echo $nntForm_Result->follow_up_visits; } ?>" type="text"></td>
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
						<?php if(isset($nntForm_Result)) { ?>
						<td class="text-center" id="get_date"><?php if(isset($nntForm_Result)){ echo $current_date; } ?></td>
						<input type="hidden" id="editted_date" name="editted_date" value="<?php if(isset($nntForm_Result)){ echo date('d-m-Y',strtotime($nntForm_Result->editted_date)); } else{ echo $current_date; } ?>" type="date">
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
					<button style="background:#008d4c;" id="save" type="submit" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save </button>
					<button style="background:#008d4c;" type="submit" name="is_temp_saved" value="0" id="myCoolForm" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit </button>
					<button onclick="javascript:disablebuttons();" style="background:#008d4c;" class="btn btn-primary btn-md" type="reset">
					<i class="fa fa-repeat"></i> Reset</button>
					<a href="<?php echo base_url(); ?>NNT-CIF/List" style="background:#008d4c;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        	</div>
		</form>
	</div>   <!-- For Control+Save Event -->
	</div> <!--end of panel body-->
</div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->
<script type="text/javascript">
var referingFacilityInfo="";
$(document).ready(function(){
		referingFacilityInfo = $('#rb_info').html();
		<?php if(isset($nntForm_Result)){ ?>	
		//$('#rb_info').html('');
		<?php } else{ ?> 
		$('#rb_info').html('');
		<?php } ?> 
		/* <?php if(isset($nntForm_Result)){ ?>
		var outcome = '<?php echo $nntForm_Result->outcome; ?>';
		  $('.showComplication').addClass("hide");
			if (outcome == 'Complication') { 
			  $('.showComplication').removeClass("hide");
			  $('.showDate').addClass("hide");
			}
		<?php } ?> */ 
		<?php if(!isset($nntForm_Result)){  ?>
			var year = $("#year").val();
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
	
	var Nil = $('#where_baby_delivered').val();
	if(Nil == 0){
		$("input.group3").prop("disabled", !this.checked);
		$(".group3").prop("disabled", !this.checked);
	}
	var tr_cared = document.getElementById('tr_cared');
	if(tr_cared.value == '0'){
		$(".group4").prop("disabled", !this.checked);
	}
	var tr_baby_died = document.getElementById('tr_baby_died');
	if(tr_cared.value == '0'){
		$(".group5").prop("disabled", !this.checked);
	}
	var tr_mother_died = document.getElementById('tr_mother_died');
	if(tr_mother_died.value == '0'){
		$(".group6").prop("disabled", !this.checked);
	}
	var cr_mother_immunized = document.getElementById('cr_mother_immunized');
	if(cr_mother_immunized.value == '0'){
		$(".group7").prop("disabled", !this.checked);
	}
	var cr_case_response = document.getElementById('cr_case_response');
	if(cr_case_response.value == '0'){
		$(".group8").prop("disabled", !this.checked);
	}
	
		// code for set radio button on page load 
	<?php if(!isset($nntForm_Result)){  ?>
		$('input:radio[name="gender"][value="Male"]').attr('checked', true);
		$('input:radio[name="active_sur_visit"][value="0"]').attr('checked', true);
		$('input:radio[name="identified_weekly_data"][value="0"]').attr('checked', true);
		$('input:radio[name="informed_by_call"][value="0"]').attr('checked', true);
	<?php } ?>
		if($("input[name = 'case_reported']:checked").val()=='0'){
			$('.disabledclass').find('input, textarea, button, select').attr('disabled','disabled');
			//$("input.disabledclass").attr("disabled", true);
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
		
	$(document).on('change','#year',function(){
		var year = $("#year").val();
		if(year == ""){
			$("#week").html("");
			$('#datefrom').val("");
			$('#dateto').val("");
		}
		else{
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
	$(document).on('change','#week,#facode,#rb_facode',function(){
		var week = $("#week").val();
		var year = $('#year').val();
		if($('#cb_cross_notified:checked').val() == 'on'){
			var facode= $('#rb_facode').val();
		}else{
			var facode= $('#facode').val();
		}
		var disease="nnt";
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
/* 		if(week != null && week > 0 && facode != null && facode > 0)
		{
			$.ajax({
				//traditional: true,
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/facode_validation',
				data: {
					week : week,
					year : year,
					facode : facode,
					disease : disease
				},
				success: function(response){
					
					if(response == 1)
					{
						var r = confirm("Either you have already submitted required number of Case Investigation Forms of NNT for the selected WEEK, YEAR & FACILITY!\n\nOR you have not submitted Zero Report for selected Week and Facility! \n\nClick OK to go back! \n\nClick Cancel to select different Week and Facility!  ");
						if(r!=true)
						{
							$('#week').val('');
							$('#facode').val('');
							$('#week option:first').prop('selected', true);							
							$('#facode option:first').prop('selected', true);
						}
						else
						{
							window.location.href = '<?php echo base_url(); ?>NNT-CIF/List';
						}
					}
				}
			});
		} */
	});
	$(document).on('change','#distcode',function(){
		$.ajax({
			type: "POST",
			data: "distcode="+$(this).val(),
			url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
			success: function(result){
				$('#place_investigation_facode').html(result);
				$('#facode1').html(result);
				$('#facode2').html(result);
				$('#facode3').html(result);
				$('#n_facode').html(result);
				$('#tr_facode').html(result);
				if( typeof selectedfacode !== 'undefined' && selectedfacode>0)
				{
					$('#place_investigation_facode option[value="' + selectedfacode + '"]').prop('selected', true);	
					$('#facode1 option[value="' + selectedfacode + '"]').prop('selected', true);	
					$('#facode2 option[value="' + selectedfacode + '"]').prop('selected', true);	
					$('#facode3 option[value="' + selectedfacode + '"]').prop('selected', true);
					$('#n_facode option[value="' + selectedfacode + '"]').prop('selected', true);
					$('#tr_facode option[value="' + selectedfacode + '"]').prop('selected', true);	
				}	
			}
		});
	});
	$(document).on('change','#tr_distcode',function(){
		$.ajax({
			type: "POST",
			data: "distcode="+$(this).val(),
			url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
			success: function(result){
				$('#tr_facode').html(result);
				if( typeof selectedfacode !== 'undefined' && selectedfacode>0)
				{	
					$('#tr_facode option[value="' + selectedfacode + '"]').prop('selected', true);
					
				}
			}
		});
	});
	$(document).on('change','#nnt_distcode',function(){
		$.ajax({
			type: "POST",
			data: "distcode="+$(this).val(),
			url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
			success: function(result){
				$('#nnt_tcode').html(result);
				if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
				{
					$('#nnt_tcode option[value="' + selecteduncode + '"]').prop('selected', true);
				}
			}
		});
	});
	$(document).on('change','#nnt_uncode',function(){
		$.ajax({
			type: "POST",
			data: "uncode="+$(this).val(),
			url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
			success: function(result){
				$('#nnt_facode').html(result);		
				
				if( typeof selectedfacode !== 'undefined' && selectedfacode>0)
				{
					$('#nnt_facode option[value="' + selectedfacode + '"]').prop('selected', true);					
				}
			}
		});
	});
	$(document).on('change','#nnt_tcode',function(){
		$.ajax({
			type: "POST",
			data: "tcode="+$(this).val(),
			url: "<?php echo base_url(); ?>Ajax_calls/getUnC",
			success: function(result){
				$('#nnt_uncode').html(result);
				if( typeof selectedtcode !== 'undefined' && selectedtcode>0)
				{
					$('#nnt_uncode option[value="' + selecteduncode + '"]').prop('selected', true);
				}
			}
		});
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

	var Nil = document.getElementById('tt_doses_rec_by_mother');
	if(Nil.value == '0'){
		$("input.group11").prop("disabled", !this.checked);
		$("input.group12").prop("disabled", !this.checked);		
		$("input.group16").prop("disabled", !this.checked);
		$("input.group17").prop("disabled", !this.checked);
		$("input.group18").prop("disabled", !this.checked);
		$("input.group19").prop("disabled", !this.checked);
		$("input.group20").prop("disabled", !this.checked);
	}
	if(Nil.value != '0'){
		$("input.group11").removeAttr("disabled", !this.checked);
		$("input.group12").removeAttr("disabled", !this.checked);
		
	}

	$(document).on('change','#tt_doses_rec_by_mother',function(){
		var doses = $(this).val();
		if(doses == '0'){
			$("input.group11").prop("disabled", !this.checked);
			$("input.group11").val('');
			$("input.group11").attr('checked', false);
			$("input.group12").prop("disabled", !this.checked);
			$("input.group12").val('');
			$("input.group12").attr('checked', false);			
			$("input.group16").removeAttr("disabled", "disabled");			
			$("input.group17").removeAttr("disabled", "disabled");			
			$("input.group18").removeAttr("disabled", "disabled");			
			$("input.group19").removeAttr("disabled", "disabled");			
			$("input.group20").removeAttr("disabled", "disabled");
		}		
		else{
			$("input.group11").removeAttr("disabled", "disabled");			
			$("input.group12").removeAttr("disabled", "disabled");		
			
		}
	});
	
	$(document).on('change','.group12',function(){
		var immunization_history = $(this).val();
		var status = $('#tt_doses_rec_by_mother').val();
		//alert(immunization_history);
		if(this.checked && status == '1'){
			$("input.group16").removeAttr("disabled", "disabled");			
			$("input.group17").attr("disabled", "disabled");			
			$("input.group18").attr("disabled", "disabled");			
			$("input.group19").attr("disabled", "disabled");			
			$("input.group20").attr("disabled", "disabled");			
		}
		else if(this.checked && status == '2'){
			$("input.group16").removeAttr("disabled", "disabled");			
			$("input.group17").removeAttr("disabled", "disabled");			
			$("input.group18").attr("disabled", "disabled");			
			$("input.group19").attr("disabled", "disabled");			
			$("input.group20").attr("disabled", "disabled");			
		}
		else if(this.checked && status == '3'){
			$("input.group16").removeAttr("disabled", "disabled");			
			$("input.group17").removeAttr("disabled", "disabled");			
			$("input.group18").removeAttr("disabled", "disabled");			
			$("input.group19").attr("disabled", "disabled");			
			$("input.group20").attr("disabled", "disabled");			
		}
		else if(this.checked && status == '4'){
			$("input.group16").removeAttr("disabled", "disabled");			
			$("input.group17").removeAttr("disabled", "disabled");			
			$("input.group18").removeAttr("disabled", "disabled");			
			$("input.group19").removeAttr("disabled", "disabled");			
			$("input.group20").attr("disabled", "disabled");			
		}
		else if(this.checked && status == '5'){
			$("input.group16").removeAttr("disabled", "disabled");			
			$("input.group17").removeAttr("disabled", "disabled");			
			$("input.group18").removeAttr("disabled", "disabled");			
			$("input.group19").removeAttr("disabled", "disabled");			
			$("input.group20").removeAttr("disabled", "disabled");			
		}
		else{
			$("input.group16").attr("disabled", "disabled");			
			$("input.group17").attr("disabled", "disabled");			
			$("input.group18").attr("disabled", "disabled");			
			$("input.group19").attr("disabled", "disabled");			
			$("input.group20").attr("disabled", "disabled");		
		}
		
	});
	$(document).on('change','.group11',function(){		
		
			$("input.group16").attr("disabled", "disabled");			
			$("input.group17").attr("disabled", "disabled");			
			$("input.group18").attr("disabled", "disabled");			
			$("input.group19").attr("disabled", "disabled");			
			$("input.group20").attr("disabled", "disabled");
	});

	$(document).on('change','#tt_doses_rec_by_mother',function(){
		var immunization_history = $(this).val();
		//var status = $('#tt_doses_rec_by_mother').val();
		//alert(immunization_history);
		if(immunization_history >= '1'){
			$("input.group16").attr("disabled", "disabled");			
			$("input.group17").attr("disabled", "disabled");			
			$("input.group18").attr("disabled", "disabled");			
			$("input.group19").attr("disabled", "disabled");			
			$("input.group20").attr("disabled", "disabled");
			$(".group11").prop("checked", false);
			$(".group12").prop("checked", false);			
		}		
		else{
			$("input.group16").attr("disabled", "disabled");			
			$("input.group17").attr("disabled", "disabled");			
			$("input.group18").attr("disabled", "disabled");			
			$("input.group19").attr("disabled", "disabled");			
			$("input.group20").attr("disabled", "disabled");		
		}		
	});
	

//***************************************code to disable submit ends here*********************************//
	
	
	$(document).on('change','#where_baby_delivered',function(){
		var delivery = $(this).val();
		if(delivery == 'Home with trained attendent' || delivery == 'Home without trained assistance' || delivery == 'Unknown' || delivery == '0'){
			$("input.group3").prop("disabled", !this.checked);
			$(".group3").prop("disabled", !this.checked);
			$("input.group3").val('');
			$(".group3").val('');
		}
		else{
			$("input.group3").removeAttr("disabled", !this.checked);
			$(".group3").removeAttr("disabled", !this.checked);
		}
	});
	
});
//function for enable/disable 
function disablebuttons()
{
	$('#myCoolForm').prop('disabled', true);
    $('#save').prop('disabled', true);
}
<?php if(!isset($nntForm_Result)){?>
	$('#save').prop('disabled', 'disabled');
	$('#myCoolForm').prop('disabled', 'disabled');
	$(document).on('change','#facode,#rb_facode,#place_investigation_facode,#facode1,#facode2,#facode3,#n_facode,#tr_facode',function(){
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

	$(document).on('change keyup copy paste cut','#pregnancy_visits',function(){
		var visits = $(this).val();
		if(visits == 0 || visits ==null || visits ==""){
			$(".group2").prop("disabled", !this.checked);
			$(".group2").prop("disabled", !this.checked);
			$(".group2").prop("disabled", !this.checked);
		}
		else{
			$(".group2").removeAttr("disabled", !this.checked);
			$(".group2").removeAttr("disabled", !this.checked);
			$(".group2").removeAttr("disabled", !this.checked);
		}
	});

	$(document).on('change keyup copy paste cut','#bs_days',function(){
		var days = $(this).val();
		if(days >= 1){
			$("#bs_days_unknown").prop("disabled", !this.checked);			
		}
		else{
			$("#bs_days_unknown").removeAttr("disabled", !this.checked);			
		}
	}); 

	$(document).on('click','#bs_days_unknown',function(){
		var bs_days_unknown = $(this).val();		
		if(bs_days_unknown == 1){
			$("#bs_days").prop("disabled", this.checked);
		}		
		else{
			$("#bs_days").removeAttr("disabled", !this.checked);
		}		
	});
	
		
	$(document).on('change','#tr_cared',function(){
		var cared = $(this).val();
		if(cared != 'Yes'){
			$(".group4").prop("disabled", !this.checked);
			$(".group4").val('');
		}
		else{
			$(".group4").removeAttr("disabled", !this.checked);	
		}
	});
	$(document).on('change','#tr_baby_died',function(){
		var tr_baby_died = $(this).val();
		if(tr_baby_died != 'Yes'){
			$(".group5").prop("disabled", !this.checked);
			$(".group5").val('');
		}
		else{
			$(".group5").removeAttr("disabled", !this.checked);	
		}
	});
	$(document).on('change','#tr_mother_died',function(){
		var tr_mother_died = $(this).val();
		if(tr_mother_died != 'Yes'){
			$(".group6").prop("disabled", !this.checked);
			$(".group6").val('');
		}
		else{
			$(".group6").removeAttr("disabled", !this.checked);	
		}
	});
	$(document).on('change','#cr_mother_immunized',function(){
		var cr_mother_immunized = $(this).val();
		if(cr_mother_immunized != 'Yes'){
			$(".group7").prop("disabled", !this.checked);
			$(".group7").val('');
		}
		else{
			$(".group7").removeAttr("disabled", !this.checked);	
		}
	});
	$(document).on('change','#cr_case_response',function(){
		var cr_case_response = $(this).val();
		if(cr_case_response != 'Yes'){
			$(".group8").prop("disabled", !this.checked);
			$(".group8").val('');
		}
		else{
			$(".group8").removeAttr("disabled", !this.checked);	
		}
	});
	$(document).on('change','.gr',function(){
		var bs_stop_sucking = $(this).val();
		var bs_cry = $('#bs_cry').val();
		var bs_stiffness = $('#bs_stiffness').val();
		var bs_spasms = $('#bs_spasms').val();
		if(bs_stop_sucking == 'Yes' && bs_cry == 'Yes' && bs_stiffness == 'Yes' && bs_spasms == 'Yes'){
			$(".group9").prop("checked", true);
			$(".group9").val("Yes");
		}
		else{
			$(".group9").prop( "checked", false );
			$(".group9").val("");
		}
	});

	$("#baby_dob").on('change',function(){
   		$("#date_delivery").val($(this).val());
	});
   
/*	$(document).ready(function(){
	    $("#date_onset").datepicker({
	        todayBtn:  1,
	        autoclose: true,
	        format: 'dd-mm-yyyy',
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
	        $('#date_notification').datepicker('setStartDate', minDate);
	    });

	    $("#date_notification").datepicker({ format: 'dd-mm-yyyy' })
	        .on('changeDate', function (selected) {
	            var minDate = new Date(selected.date.valueOf());
	            $('#date_onset').datepicker('setEndDate', minDate);
	        });
	});
	$(document).ready(function(){
	    $("#date_notification").datepicker({
	        todayBtn:  1,
	        autoclose: true,
	        format: 'dd-mm-yyyy',
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
	        $('#date_investigation').datepicker('setStartDate', minDate);
	    });

	    $("#date_investigation").datepicker({ format: 'dd-mm-yyyy' })
	        .on('changeDate', function (selected) {
	            var minDate = new Date(selected.date.valueOf());
	            $('#date_notification').datepicker('setEndDate', minDate);
	        });

	});*/
	
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
	$("#date_investigation").on( "click", function() {
		setNewDate('date_investigation');
	});
	$("#date_admission").on( "click", function() {
		setNewDate('date_admission');
	});
	$("#date_investigation").on( "change", function() {
		fromDate('date_investigation', 'date_onset');
	});
	$("#date_onset").on( "change", function() {
		toDate('date_investigation', 'date_onset');
	});
	$("#date_onset").on( "change", function() {
		fromDate('date_onset', 'date_notification_level');
	});
	$("#date_notification_level").on( "change", function() {
		toDate('date_onset', 'date_notification_level');
	});

	$("#date_onset").on( "change", function() {
		fromDate('date_onset', 'date_investigation');
	});
	$("#date_investigation").on( "change", function() {
		toDate('date_onset', 'date_investigation');
	});
	
	$("#date_admission").on( "change", function() {
		fromDate('date_admission', 'date_delivery');
	});
	$("#date_delivery").on( "change", function() {
		toDate('date_admission', 'date_delivery');
	});
// the selector will match all input controls of type :checkbox
// and attach a click event handler 
$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }

});
	// $('#tcode').on('change', function() {
	//    var tcode = $("#tcode").val();     
	//    $("#nnt_tcode option[value="+tcode+"]").prop("selected",true);          
	// });
	// $('#uncode').on('change', function() {
	//    var uncode = $("#uncode").val();
	//    $("#nnt_uncode option[value="+uncode+"]").prop("selected",true);
	// });
////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
<?php if(!isset($nntForm_Result)) { ?>
   $(document).ready(function(){
   	$('#tcode').attr('required','required');
      $('#uncode').attr('required','required');
      $('#facode').attr('required','required');
   	$('#nnt_tcode').attr('required','required');
      $('#nnt_uncode').attr('required','required');
      $('#nnt_facode').attr('required','required');
      $('#other_procode').removeAttr('required','required');
      $('#other_procode').addClass('hide');
      $('#nnt_distcode').removeClass('hide');
      $('#nnt_distcode').attr('required','required');
      $('#other_pro_district').addClass('hide');         
      $('#other_pro_district').removeAttr('required','required');
      $('#other_pro_distcode').addClass('hide');         
      $('#other_pro_distcode').removeAttr('required','required');
   });
<?php } ?>
<?php if(!isset($nntForm_Result)) { ?>
   if($('#cb_cross_notified').not(':checked').length){
		$('.crossNotify').removeClass('hide');
		$('.otherProvinceAddress').addClass('hide');
		$('#other_procode').removeAttr('required','required');
		$('#tcode').attr('required','required');
      $('#uncode').attr('required','required');
      $('#facode').attr('required','required');
   	$('#nnt_tcode').attr('required','required');
      $('#nnt_uncode').attr('required','required');
      $('#nnt_facode').attr('required','required');
	}
<?php } ?>
var tdHtml = "";var epidNumberHtml = "";var patient1stTr = "";var patient2ndTr = "";var patient3rdTr = ""; var healthFacilityTr="";var placeInvestigationTd="";var facilitiesVisistedTr=""; var proTd1=""; var proTd2="";
	$(document).on('click','#cb_cross_notified',function(){
		$('#save').attr('disabled', 'disabled');
		$('#myCoolForm').attr('disabled', 'disabled');
		$('#cb_cross_notified').attr('disabled','disabled');
		if(this.checked == true){
			$('#rb_info').html(referingFacilityInfo);
			$('#rb_info').removeClass('hide');
			$('#cross_notified').val('1');
			tdHtml = $('#districttd').html();
			// epidNumberHtml = $('#epidNumberTR').html();
			patient1stTr = $('#patient1stTr').html();
			patient2ndTr = $('#patient2ndTr').html();
			patient3rdTr = $('#patient3rdTr').html();
			placeInvestigationTd = $('#placeInvestigationTd').html();
			facilitiesVisistedTr = $('#facilitiesVisistedTr').html();
			healthFacilityTr = $('#healthFacilityTr').html();
			deliveryFacilityTd = $('#deliveryFacilityTd').html();
			facodeTd = $('#facodeTd').html();
			proTd1 = $('#proTd1').html();
         proTd2 = $('#proTd2').html();
			// $('#epidNumberTR').html('');
			$('#districttd').html('');
			$('#healthFacilityTr').html('');
			$('#nnt_distcode').empty();
			$('#nnt_tcode').empty();
			$('#nnt_uncode').empty();
			$('#tr_distcode').empty();
			$('.crossNotify').addClass('hide');
			$('#proTd1').html('');
         $('#proTd2').html('');
         $('#tcode').empty();
         $('#facode').empty();
         $('#tcode').removeAttr('required','required');
	      $('#uncode').removeAttr('required','required');
	      $('#facode').removeAttr('required','required');
	   	$('#nnt_tcode').removeAttr('required','required');
	      $('#nnt_uncode').removeAttr('required','required');
	      $('#nnt_facode').removeAttr('required','required');
         $('#other_procode').attr('required','required');
         $('#other_procode').removeClass('hide');
         $('.otherProvinceAddress').removeClass('hide');
			$.ajax({ 
				type: 'POST',
				data: '',
				url: '<?php echo base_url();?>Ajax_calls/getDistricts_optionsNNT',
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
			$('#patient3rdTr').html(patient3rdTr);
			$('#placeInvestigationTd').html(placeInvestigationTd);
			$('#facilitiesVisistedTr').html(facilitiesVisistedTr);
			$('#deliveryFacilityTd').html(deliveryFacilityTd);
			$('#facodeTd').html(facodeTd);
			$('.crossNotify').removeClass('hide');
			$('#proTd1').html(proTd1);
         $('#proTd2').html(proTd2);
         $('#other_procode').removeAttr('required','required');
         $('#other_procode').addClass('hide');
         $('.otherProvinceAddress').addClass('hide');
			// $('#epidNumberTR').html(epidNumberHtml);
			$('#healthFacilityTr').html(healthFacilityTr);							
			$('#distcode').trigger('change');
			$('#cb_cross_notified').removeAttr('disabled','disabled');
			$('#facode').empty();
			$('#rb_info').html('');
			$('#tcode').attr('required','required');
	      $('#uncode').attr('required','required');
	      $('#facode').attr('required','required');
	   	$('#nnt_tcode').attr('required','required');
	      $('#nnt_uncode').attr('required','required');
	      $('#nnt_facode').attr('required','required');
		}		
	});

	<?php if(!isset($nntForm_Result)){ ?>
      $(document).on('change','#other_procode',function(){
         if($(this).val() == '<?php echo $_SESSION["Province"]; ?>'){
            $('.procodekp').removeClass('hide');
            $('.procodekp').val('');
            $('.otherprocode').addClass('hide');
            $('.otherprocode').val('');
            $('#patient_address').attr('required','required');
            $('#house_hold_address').removeAttr('required','required');
            $('#patient_address').removeAttr('disabled','disabled');
            $('#house_hold_address').attr('disabled','disabled');
            $('#nnt_distcode').addClass('hide');
            $('#nnt_distcode').removeAttr('required','required');
            $('#other_pro_district').addClass('hide');         
            $('#other_pro_distcode').attr('required','required');
            $('#other_pro_tcode').attr('required','required');
            $('#other_pro_uncode').attr('required','required');         
            $('#other_pro_district').removeAttr('required','required');
            $('#other_pro_tehsil').removeAttr('required','required');
            $('#other_pro_uc').removeAttr('required','required'); 
            $('#other_pro_distcode').removeAttr('disabled','disabled'); 
            $('#other_pro_tcode').removeAttr('disabled','disabled'); 
            $('#other_pro_uncode').removeAttr('disabled','disabled');
            $('#other_pro_district').attr('disabled','disabled'); 
            $('#other_pro_tehsil').attr('disabled','disabled'); 
            $('#other_pro_uc').attr('disabled','disabled'); 
            $('#nnt_uncode').attr('disabled','disabled');
            $('#distcode').removeAttr('required','required');
            $('#tcode').removeAttr('required','required');
            $('#uncode').removeAttr('required','required'); 
            $('#facode').removeAttr('required','required');
            $('#distcode').attr('disabled','disabled'); 
            $('#tcode').attr('disabled','disabled'); 
            $('#uncode').attr('disabled','disabled');
            $('#facode').attr('disabled','disabled');

            //$('#labresult_tobesentto_district').removeAttr('required','required');
         }else if($(this).val() != '<?php echo $_SESSION["Province"]; ?>' && $(this).val() != ''){
            $('#nnt_distcode').addClass('hide');
            $('#nnt_distcode').removeAttr('required','required');
            $('#other_pro_district').removeClass('hide');         
            $('#other_pro_district').attr('required','required');
            $('.procodekp').addClass('hide');
            $('.otherprocode').removeClass('hide');
            $('.procodekp').val('');
            $('.otherprocode').val('');         
            $('#other_pro_distcode').removeAttr('required','required');
           	$('#patient_address').attr('required','required');
            $('#house_hold_address').removeAttr('required','required');
             $('#patient_address').removeAttr('disabled','disabled');
            $('#house_hold_address').attr('disabled','disabled');
            $('#other_pro_tcode').removeAttr('required','required');
            $('#other_pro_uncode').removeAttr('required','required');         
            $('#other_pro_district').attr('required','required');
            $('#other_pro_tehsil').attr('required','required');
            $('#other_pro_uc').attr('required','required');

            $('#other_pro_distcode').attr('disabled','disabled'); 
            $('#other_pro_tcode').attr('disabled','disabled'); 
            $('#other_pro_uncode').attr('disabled','disabled');
            $('#other_pro_district').removeAttr('disabled','disabled'); 
            $('#other_pro_tehsil').removeAttr('disabled','disabled'); 
            $('#other_pro_uc').removeAttr('disabled','disabled');
            $('#nnt_uncode').attr('disabled','disabled');
            $('#nnt_procode').attr('disabled','disabled');

            $('#distcode').removeAttr('required','required');
            $('#tcode').removeAttr('required','required');
            $('#uncode').removeAttr('required','required'); 
            $('#facode').removeAttr('required','required');
            $('#distcode').attr('disabled','disabled'); 
            $('#tcode').attr('disabled','disabled'); 
            $('#uncode').attr('disabled','disabled');
            $('#facode').attr('disabled','disabled');
         }
         else if( $(this).val() == ''){
            $('#nnt_distcode').removeClass('hide');
            $('#nnt_distcode').attr('required','required');
            $('#other_pro_district').addClass('hide');         
            $('#other_pro_district').removeAttr('required','required');
            $('.procodekp').addClass('hide');
            $('.otherprocode').addClass('hide');
            $('.procodekp').val('');
            $('.otherprocode').val('');  
            $('#patient_address').removeAttr('required','required');
            $('#house_hold_address').removeAttr('required','required');
            $('#distcode').attr('required','required');
            $('#tcode').attr('required','required');
            $('#uncode').attr('required','required'); 
            $('#facode').attr('required','required');
            $('#distcode').removeAttr('disabled','disabled'); 
            $('#tcode').removeAttr('disabled','disabled'); 
            $('#uncode').removeAttr('disabled','disabled');
            $('#facode').removeAttr('disabled','disabled');       
         }
      });
   <?php } ?>
   <?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 && $nntForm_Result-> procode == $_SESSION["Province"] && (substr($nntForm_Result-> cross_notified_from_distcode, 0,1) == $_SESSION["Province"]) && $nntForm_Result-> approval_status == 'Approved'){ ?>
      $('.procodekp').removeClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').addClass('hide');
      $('.otherprocode').val('');
      //$('#patient_address').removeAttr('readonly','readonly');
      $('#distcode').removeAttr('required','required');
      $('#tcode').removeAttr('required','required');
      $('#uncode').removeAttr('required','required');
      $('#facode').removeAttr('required','required');
      $('#distcode').attr('disabled','disabled'); 
      $('#tcode').attr('disabled','disabled'); 
      $('#uncode').attr('disabled','disabled');
      $('#facode').attr('disabled','disabled');
      $('#proTd1').html('');
      $('#proTd2').html('');
      $('#nnt_distcode').addClass('hide');
      $('#nnt_distcode').removeAttr('required','required');
      $('#nnt_tcode').removeAttr('required','required');
      $('#nnt_uncode').removeAttr('required','required');
      $('#nnt_distcode').attr('disabled','disabled'); 
      $('#nnt_tcode').attr('disabled','disabled'); 
      $('#nnt_uncode').attr('disabled','disabled');
      $('#other_pro_district').addClass('hide');         
      $('#other_pro_distcode').attr('required','required');
      $('#other_pro_tcode').attr('required','required');
      $('#other_pro_uncode').attr('required','required');         
      $('#other_pro_district').removeAttr('required','required');
      $('#other_pro_tehsil').removeAttr('required','required');
      $('#other_pro_uc').removeAttr('required','required'); 
      $('#other_pro_distcode').removeAttr('disabled','disabled'); 
      $('#other_pro_tcode').removeAttr('disabled','disabled'); 
      $('#other_pro_uncode').removeAttr('disabled','disabled');
      $('#other_pro_district').attr('disabled','disabled'); 
      $('#other_pro_tehsil').attr('disabled','disabled'); 
      $('#other_pro_uc').attr('disabled','disabled'); 
      $('#nnt_uncode').attr('disabled','disabled');
      $('.otherProvinceAddress').removeClass('hide');
      nnt_distcode = '<?php echo $nntForm_Result-> nnt_distcode; ?>';
      nnt_tcode = '<?php echo $nntForm_Result-> nnt_tcode; ?>';
      nnt_uncode = '<?php echo $nntForm_Result-> nnt_uncode; ?>';
      $('#other_pro_distcode').val(nnt_distcode);
      $('#other_pro_tcode').val(nnt_tcode);
      $('#other_pro_uncode').val(nnt_uncode);
   <?php } ?>
   <?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 && $nntForm_Result-> procode != $_SESSION["Province"] && (substr($nntForm_Result-> cross_notified_from_distcode, 0,1) != $_SESSION["Province"]) && $nntForm_Result-> approval_status == 'Approved' ){ ?>
      $('#nnt_distcode').addClass('hide');
      $('#nnt_distcode').removeAttr('required','required');
      $('#nnt_tcode').removeAttr('required','required');
      $('#nnt_uncode').removeAttr('required','required');
      $('#nnt_distcode').attr('disabled','disabled'); 
      $('#nnt_tcode').attr('disabled','disabled'); 
      $('#nnt_uncode').attr('disabled','disabled');
      $('#other_pro_district').removeClass('hide');         
      $('#other_pro_district').attr('required','required');
      $('.procodekp').addClass('hide');
      $('.otherprocode').removeClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').val('');
      $('#distcode').removeAttr('required','required');
      $('#tcode').removeAttr('required','required');
      $('#uncode').removeAttr('required','required');
      $('#facode').removeAttr('required','required');
      $('#distcode').attr('disabled','disabled'); 
      $('#tcode').attr('disabled','disabled'); 
      $('#uncode').attr('disabled','disabled');
      $('#facode').attr('disabled','disabled');
      $('#proTd1').html('');
      $('#proTd2').html('');         
      $('#other_pro_distcode').removeAttr('required','required');
      $('#other_pro_tcode').removeAttr('required','required');
      $('#other_pro_uncode').removeAttr('required','required');         
      $('#other_pro_district').attr('required','required');
      $('#other_pro_tehsil').attr('required','required');
      $('#other_pro_uc').attr('required','required');
      $('#other_pro_distcode').attr('disabled','disabled'); 
      $('#other_pro_tcode').attr('disabled','disabled'); 
      $('#other_pro_uncode').attr('disabled','disabled');
      $('#other_pro_district').removeAttr('disabled','disabled'); 
      $('#other_pro_tehsil').removeAttr('disabled','disabled'); 
      $('#other_pro_uc').removeAttr('disabled','disabled');
      $('#nnt_uncode').attr('disabled','disabled');
      $('#nnt_procode').attr('disabled','disabled');
      $('.otherProvinceAddress').removeClass('hide');
      nnt_distcode = '<?php echo $nntForm_Result-> nnt_distcode; ?>';
      nnt_tcode = '<?php echo $nntForm_Result-> nnt_tcode; ?>';
      nnt_uncode = '<?php echo $nntForm_Result-> nnt_uncode; ?>';
      $('#other_pro_district').val(nnt_distcode);
      $('#other_pro_tehsil').val(nnt_tcode);
      $('#other_pro_uc').val(nnt_uncode);    
   <?php } ?>

   <?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 && $nntForm_Result-> cross_notified_from_distcode == $this -> session -> District && (substr($nntForm_Result-> cross_notified_from_distcode, 0,1) == $_SESSION["Province"]) && $nntForm_Result-> approval_status == 'Pending'){ ?>
      $('.procodekp').removeClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').addClass('hide');
      $('.otherprocode').val('');
      //$('#patient_address').removeAttr('readonly','readonly');
      $('#distcode').removeAttr('required','required');
      $('#tcode').removeAttr('required','required');
      $('#uncode').removeAttr('required','required');
      $('#facode').removeAttr('required','required');
      $('#distcode').attr('disabled','disabled'); 
      $('#tcode').attr('disabled','disabled'); 
      $('#uncode').attr('disabled','disabled');
      $('#facode').attr('disabled','disabled');
      $('#proTd1').html('');
      $('#proTd2').html('');
      $('#nnt_distcode').addClass('hide');
      $('#nnt_distcode').removeAttr('required','required');
      $('#nnt_tcode').removeAttr('required','required');
      $('#nnt_uncode').removeAttr('required','required');
      $('#nnt_distcode').attr('disabled','disabled'); 
      $('#nnt_tcode').attr('disabled','disabled'); 
      $('#nnt_uncode').attr('disabled','disabled');
      $('#other_pro_district').addClass('hide');         
      $('#other_pro_distcode').attr('required','required');
      $('#other_pro_tcode').attr('required','required');
      $('#other_pro_uncode').attr('required','required');         
      $('#other_pro_district').removeAttr('required','required');
      $('#other_pro_tehsil').removeAttr('required','required');
      $('#other_pro_uc').removeAttr('required','required'); 
      $('#other_pro_distcode').removeAttr('disabled','disabled'); 
      $('#other_pro_tcode').removeAttr('disabled','disabled'); 
      $('#other_pro_uncode').removeAttr('disabled','disabled');
      $('#other_pro_district').attr('disabled','disabled'); 
      $('#other_pro_tehsil').attr('disabled','disabled'); 
      $('#other_pro_uc').attr('disabled','disabled'); 
      $('.otherProvinceAddress').removeClass('hide');
      nnt_distcode = '<?php echo $nntForm_Result-> nnt_distcode; ?>';
      nnt_tcode = '<?php echo $nntForm_Result-> nnt_tcode; ?>';
      nnt_uncode = '<?php echo $nntForm_Result-> nnt_uncode; ?>';
      $('#other_pro_distcode').val(nnt_distcode);
      $('#other_pro_tcode').val(nnt_tcode);
      $('#other_pro_uncode').val(nnt_uncode);
   <?php } ?>
   <?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 && $nntForm_Result-> cross_notified_from_distcode != $this -> session -> District && (substr($nntForm_Result-> cross_notified_from_distcode, 0,1) != $_SESSION["Province"]) && $nntForm_Result-> approval_status == 'Pending' ){ ?>
      $('#nnt_distcode').addClass('hide');
      $('#nnt_distcode').removeAttr('required','required');
      $('#nnt_tcode').removeAttr('required','required');
      $('#nnt_uncode').removeAttr('required','required');
      $('#nnt_distcode').attr('disabled','disabled'); 
      $('#nnt_tcode').attr('disabled','disabled'); 
      $('#nnt_uncode').attr('disabled','disabled');
      $('#other_pro_district').removeClass('hide');         
      $('#other_pro_district').attr('required','required');
      $('.procodekp').addClass('hide');
      $('.otherprocode').removeClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').val('');
      $('#distcode').removeAttr('required','required');
      $('#tcode').removeAttr('required','required');
      $('#uncode').removeAttr('required','required');
      $('#facode').removeAttr('required','required');
      $('#distcode').attr('disabled','disabled'); 
      $('#tcode').attr('disabled','disabled'); 
      $('#uncode').attr('disabled','disabled');
      $('#facode').attr('disabled','disabled');
      $('#proTd1').html('');
      $('#proTd2').html('');         
      $('#other_pro_distcode').removeAttr('required','required');
      $('#other_pro_tcode').removeAttr('required','required');
      $('#other_pro_uncode').removeAttr('required','required');         
      $('#other_pro_district').attr('required','required');
      $('#other_pro_tehsil').attr('required','required');
      $('#other_pro_uc').attr('required','required');
      $('#other_pro_distcode').attr('disabled','disabled'); 
      $('#other_pro_tcode').attr('disabled','disabled'); 
      $('#other_pro_uncode').attr('disabled','disabled');
      $('#other_pro_district').removeAttr('disabled','disabled'); 
      $('#other_pro_tehsil').removeAttr('disabled','disabled'); 
      $('#other_pro_uc').removeAttr('disabled','disabled');
      $('#nnt_procode').attr('disabled','disabled');
      $('.otherProvinceAddress').removeClass('hide');
      nnt_distcode = '<?php echo $nntForm_Result-> nnt_distcode; ?>';
      nnt_tcode = '<?php echo $nntForm_Result-> nnt_tcode; ?>';
      nnt_uncode = '<?php echo $nntForm_Result-> nnt_uncode; ?>';
      $('#other_pro_district').val(nnt_distcode);
      $('#other_pro_tehsil').val(nnt_tcode);
      $('#other_pro_uc').val(nnt_uncode);    
   <?php } ?>
   <?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 && $nntForm_Result-> procode == $_SESSION["Province"] && (substr($nntForm_Result-> cross_notified_from_distcode, 0,1) != $_SESSION["Province"]) && $nntForm_Result-> approval_status == 'Approved' ){ ?>
      $('#nnt_distcode').addClass('hide');
      $('#nnt_distcode').removeAttr('required','required');
      $('#nnt_tcode').removeAttr('required','required');
      $('#nnt_uncode').removeAttr('required','required');
      $('#nnt_distcode').attr('disabled','disabled'); 
      $('#nnt_tcode').attr('disabled','disabled'); 
      $('#nnt_uncode').attr('disabled','disabled');
      $('#other_pro_district').removeClass('hide');         
      $('#other_pro_district').attr('required','required');
      $('.procodekp').addClass('hide');
      $('.otherprocode').removeClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').val('');
      $('#distcode').removeAttr('required','required');
      $('#tcode').removeAttr('required','required');
      $('#uncode').removeAttr('required','required');
      $('#facode').removeAttr('required','required');
      $('#distcode').attr('disabled','disabled'); 
      $('#tcode').attr('disabled','disabled'); 
      $('#uncode').attr('disabled','disabled');
      $('#facode').attr('disabled','disabled');
      $('#proTd1').html('');
      $('#proTd2').html('');
      $('#other_pro_uncode').html('');         
      $('#other_pro_distcode').removeAttr('required','required');
      $('#other_pro_tcode').removeAttr('required','required');
      $('#other_pro_uncode').removeAttr('required','required');         
      $('#other_pro_district').attr('required','required');
      $('#other_pro_tehsil').attr('required','required');
      $('#other_pro_uc').attr('required','required');
      $('#other_pro_distcode').attr('disabled','disabled'); 
      $('#other_pro_tcode').attr('disabled','disabled'); 
      $('#other_pro_uncode').attr('disabled','disabled');
      $('#other_pro_district').removeAttr('disabled','disabled'); 
      $('#other_pro_tehsil').removeAttr('disabled','disabled'); 
      $('#other_pro_uc').removeAttr('disabled','disabled');      
      $('#nnt_procode').attr('disabled','disabled');
      $('.otherProvinceAddress').removeClass('hide');
      nnt_distcode = '<?php echo $nntForm_Result-> nnt_distcode; ?>';
      nnt_tcode = '<?php echo $nntForm_Result-> nnt_tcode; ?>';
      nnt_uncode = '<?php echo $nntForm_Result-> nnt_uncode; ?>';
      $('#other_pro_district').val(nnt_distcode);
      $('#other_pro_tehsil').val(nnt_tcode);
      $('#other_pro_uc').val(nnt_uncode);    
   <?php } ?>
   <?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 0){ ?>
      $('#nnt_distcode').removeClass('hide');
      $('#nnt_distcode').attr('required','required');
      $('#other_pro_district').addClass('hide');         
      $('#other_pro_district').removeAttr('required','required');
      $('.procodekp').addClass('hide');
      $('.otherprocode').addClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').val(''); 
      $('.otherProvinceAddress').addClass('hide');
      $('#other_procode').removeAttr('required','required'); 
      $('#other_procode').attr('disabled','disabled');
      $('#other_pro_distcode').removeAttr('required','required');
      $('#other_pro_tcode').removeAttr('required','required');
      $('#other_pro_uncode').removeAttr('required','required')
      $('#other_pro_distcode').attr('disabled','disabled'); 
      $('#other_pro_tcode').attr('disabled','disabled'); 
      $('#other_pro_uncode').attr('disabled','disabled');
      $('#other_pro_district').removeAttr('required','required');
      $('#other_pro_tehsil').removeAttr('required','required');
      $('#other_pro_uc').removeAttr('required','required'); 
      $('#other_pro_district').attr('disabled','disabled'); 
      $('#other_pro_tehsil').attr('disabled','disabled'); 
      $('#other_pro_uc').attr('disabled','disabled');
   <?php } ?>
	$(document).on('change','#distcode',function(){
		if($("#cb_cross_notified").is(':checked')){
			$('#nnt_uncode').empty();
			var dist = $('#distcode').val();
			$.ajax({ 
				type: 'POST',
				data: 'distcode='+dist,
				url: '<?php echo base_url();?>Ajax_calls/getDistricts_optionsNNT',
				success: function(data){
					$('#patientDistcodeTd').html(data);
					$('#nnt_distcode').trigger('change');
				}
			});
		}
		$('#facode').empty();
	});
	$(document).on('change','#distcode',function(){
		if($("#cb_cross_notified").is(':checked')){
			$('#tr_uncode').empty();
			var dist = $('#distcode').val();
			$.ajax({ 
				type: 'POST',
				data: 'distcode='+dist,
				url: '<?php echo base_url();?>Ajax_calls/getDistricts_optionsNNTX',
				success: function(data){
					$('#treatmentDistcodeTd').html(data);
					$('#tr_distcode').trigger('change');
				}
			});
		}
		$('#facode').empty();
	});



	//-------- Javascript for Cross Notification to other Provinces -------//
<?php if(isset($nntForm_Result) && $nntForm_Result-> cross_notified == 1 ){ ?>
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
   // $(document).on('change','#other_pro_tcode', function(){
   //    var tcode = this.value;
   //    //to get ucs of selected distcrict
   //    if(tcode != 0) {
   //      $.ajax({
   //          type: "POST",
   //          url: "<?php echo base_url(); ?>Ajax_calls/getUnC/"+tcode,
   //          success: function(result){
   //             $('#other_pro_uncode').html(result);                     
   //             //
   //             if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
   //             {
   //                $('#other_pro_uncode option[value="' + selecteduncode + '"]').prop('selected', true);
   //             }
   //             $('#other_pro_uncode').trigger('change');
   //          }
   //       });
   //    }else{
   //       $('#other_pro_uncode').html('');
   //       //it doesn't exist
   //    }                 
   // });
   $(document).on('change','#other_pro_tcode', function(){
      var tcode = $('#other_pro_tcode').val();
      var other_pro_distcode = $('#other_pro_distcode').val();
      //to get tehsils of selected district
      //if($("#other_procode").length == 0)
      //alert(other_pro_district);
      // if(other_pro_distcode == '<?php echo $_SESSION['District']; ?>' || tcode == "") {
      //    //alert("abc");
      // //not session province
      // }else{
         //alert("xyz");
         $.ajax({
            type: "POST",
            data: "tcode="+tcode,
            url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceUCs",
            success: function(result){
               $('#other_pro_uncode').html(result);
               //$('#labresult_tobesentto_district').html(result);
               $('#other_pro_uncode').trigger('change');
               //$('#labresult_tobesentto_district').trigger('change');
            }
         });
      //}                    
   });
   $(document).on('change','#other_procode', function(){
      var procode = $('#other_procode').val();
      //if($("#other_procode").length == 0)
      if(procode == '<?php echo $_SESSION["Province"]; ?>') {
         //alert("abc");
         $.ajax({
            type: "POST",
            data: "procode="+procode,
            url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
            success: function(result){
               //$('#nnt_distcode').html(result);
               $('#other_pro_distcode').html(result);
               //$('#labresult_tobesentto_district').html(result);
               // $('#other_pro_district').trigger('change');
               // $('#labresult_tobesentto_district').trigger('change');
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
               $('#other_pro_district').html(result);
               //$('#labresult_tobesentto_district').html(result);
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

<?php } else { ?>
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
   $(document).on('change','#other_procode', function(){
      var procode = $('#other_procode').val();
      //if($("#other_procode").length == 0)
      if(procode == '<?php echo $_SESSION["Province"]; ?>') {
         //alert("abc");
         $.ajax({
            type: "POST",
            data: "procode="+procode,
            url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
            success: function(result){
               //$('#nnt_distcode').html(result);
               $('#other_pro_distcode').html(result);
               //$('#labresult_tobesentto_district').html(result);
               // $('#other_pro_district').trigger('change');
               // $('#labresult_tobesentto_district').trigger('change');
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
               $('#other_pro_district').html(result);
               //$('#labresult_tobesentto_district').html(result);
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
<?php } ?>   
</script>