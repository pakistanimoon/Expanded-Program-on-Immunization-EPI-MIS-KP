<?php
   date_default_timezone_set('Asia/Karachi'); // CDT
   $current_date = date('d-m-Y');
?>
<div class="container bodycontainer">
   <div class="row">
      <div class="panel panel-primary">
         <?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
         <div class="panel-heading"> <?php if(isset($afp_Result)){ ?> Update Acute Flaccid Paralysis Case Form <?php }else{ ?> Add Acute Flaccid Paralysis Case <?php } ?>
            <?php if(!isset($afp_Result)){ ?>
               <div style="display: inline-block;float: right;">
                   <span style="font-size: 15px;color:#F0FF00;">Cross Notify</span>&nbsp;&nbsp;
                   <input id="cb_cross_notified" style="display: inline-block;float: right;margin-top: 9px;" type="checkbox">
               </div>
            <?php } ?>
         </div>
         <div class="panel-body">
            <form class="form-horizontal" method="post" onsubmit="return confirm('Are you sure you want to save/submit this form?')" action="<?php echo base_url(); ?>Investigation_forms/afp_save">
               <?php if(isset($afp_Result)){ ?>
               <input type="hidden" name="edit" id="edit" value="edit" />
               <input type="hidden" name="id" id="id" value="<?php echo $afp_Result-> id; ?>" />
               <input type="hidden" name="cross_case_id" value="<?php echo $afp_Result-> cross_case_id; ?>" />
               <input type="hidden" name="case_epi_no" value="<?php echo $afp_Result-> case_epi_no; ?>" />
                  <?php if($afp_Result->cross_notified==1){echo '<input type="hidden" id="cross_notified" name="cross_notified" value="1" />';} ?>
                  <?php }else{ ?>
                     <input type="hidden" id="cross_notified" name="cross_notified" />
                  <?php } ?>
                  <?php if(isset($afp_Result->rb_distcode) && $afp_Result->rb_distcode>0 && $afp_Result-> cross_notified == 1){ ?> 
                  <table id="rb_info" class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
                     <thead>
                        <tr>
                           <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Case Refering Facility Information</th>
                        </tr>
                     </thead>
                     <tbody>           
                        <tr>
                           <td><label>Province / Area</label></td>
                           <!-- <td><input class="form-control"  readonly="readonly" placeholder="<?php //echo $this -> session -> provincename ?>" type="text"></td> -->
                           <td>
                              <?php 
                                 if(isset($afp_Result)){
                                    $rb_pcode = substr($afp_Result-> rb_distcode, 0,1);
                                 } 
                              ?>
                              <p><?php echo get_Province_Name($rb_pcode); ?></p>
                           </td>
                           <td><label>District</label></td>
                           <td>
                              <input type="hidden" id="rb_distcode" name="rb_distcode" required="required" value="<?php $distcode = (isset($afp_Result))?$afp_Result->rb_distcode:$this -> session -> District;  echo $distcode; ?>">
                              <p><?php echo CrossProvince_DistrictName($afp_Result->rb_distcode); ?></p>
                           </td>            
                        </tr>
                        <tr>
                           <td><label>Tehsil/City <span style="color:red;">*</span></label></td>
                           <td><select id="rb_tcode" name="rb_tcode" required="required" class="form-control">
                              <?php if(isset($afp_Result) && $afp_Result -> rb_tcode != ""){ ?>
                              <option value="<?php echo $afp_Result -> rb_tcode; ?>"><?php echo CrossProvince_TehsilName($afp_Result -> rb_tcode); ?></option>
                              <?php }else{ ?> 
                              <?php getCrossProvince_TehsilOptions(false); } ?>
                              </select>
                           </td>
                           <td><label>Union Council <span style="color:red;">*</span></label></td>
                           <input id="module" type="hidden" value="disease_surveillance">
                           <td>
                              <select id="rb_uncode" name="rb_uncode" required="required" class="form-control">
                              <?php if(isset($afp_Result)){ ?>
                                 <option value="<?php echo $afp_Result->rb_uncode; ?>" <?php if(validation_errors() != false) { echo set_select(false,$afp_Result->rb_uncode); }?> > <?php echo CrossProvince_UCName($afp_Result->rb_uncode); ?> </option>
                              <?php }else{} ?>
                              </select>
                           </td>
                        </tr>
                        <tr>
                           <td><label>Name of Reporting Health Facility <span style="color:red;">*</span></label></td>
                           <td>
                              <?php if(isset($afp_Result)){ ?>
                              <select class="form-control" required="required" name="rb_facode" id="rb_facode">
                                 <option value="<?php echo $afp_Result->rb_facode; ?>"><?php echo CrossProvince_FacilityName($afp_Result->rb_facode); ?></option>
                              </select>
                              <?php }else{ ?>
                              <select class="form-control" required name="rb_facode" id="rb_facode"></select>
                              <?php } ?>
                           </td>
                           <td><label>Address of Health Facility</label></td>
                           <td><input class="form-control" name="rb_faddress" id="rb_faddress" value="<?php if(isset($afp_Result)){ echo $afp_Result->rb_faddress; } ?>" type="text"></td>
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
                           <td><label>Province <span style="color:red;">*</span></label></td>
                           <td>
                              <!-- <input class="form-control" readonly="readonly" placeholder="<?php echo $this -> session -> provincename ?>" type="text"> -->
                              <label class="pt7"><?php echo $this -> session -> provincename ?></label>
                           </td>
                           <td><label>District <span style="color:red;">*</span></label></td>
                           <td>
                              <input type="hidden" id="rb_distcode" name="rb_distcode" value="<?php $distcode = (isset($afp_Result))?$afp_Result->rb_distcode:$this -> session -> District;  echo $distcode; ?>">
                              <!-- <p><?php //echo get_District_Name($this->session->District); ?></p> -->
                              <label class="pt7"><?php echo get_District_Name($this-> session-> District); ?></label>
                           </td>            
                        </tr>
                        <tr>
                           <td><label>Tehsil <span style="color:red;">*</span></label></td>
                           <td>
                              <select id="rb_tcode" name="rb_tcode" class="form-control">
                              <?php if(isset($afp_Result) && $afp_Result -> rb_tcode != ""){ ?>
                              <option value="<?php echo $afp_Result -> rb_tcode; ?>"><?php echo getTehsils_options(false,$afp_Result -> rb_tcode); ?></option>
                              <?php }else{ ?> 
                              <?php getTehsils_options(false); } ?>
                              </select>
                           </td>
                           <td><label>Union Council <span style="color:red;">*</span></label></td>
                           <input id="module" type="hidden" value="disease_surveillance">
                           <td>
                              <select id="rb_uncode" name="rb_uncode" class="form-control">
                              <?php if(isset($afp_Result) && $afp_Result->rb_uncode != " "){ getUCs(false,$afp_Result->rb_uncode); }else{ ?>
                              <?php getUCs_options(false); } ?>
                              </select>
                           </td>
                        </tr>
                        <tr>
                           <td><label>Name of Reporting Health Facility <span style="color:red;">*</span></label></td>
                           <td>
                              <?php if(isset($afp_Result)){ ?>
                              <select class="form-control" name="rb_facode" id="rb_facode">
                                 <option value="<?php echo $afp_Result->rb_facode; ?>"><?php echo $facility; ?></option>
                              </select>
                              <?php }else{ ?>
                              <select class="form-control" name="rb_facode" id="rb_facode"></select>
                              <?php } ?>
                           </td>
                           <td><label>Address of Health Facility</label></td>
                           <td><input class="form-control" name="rb_faddress" id="rb_faddress" value="<?php if(isset($afp_Result)){ echo $afp_Result->rb_faddress; } ?>" type="text"></td>
                        </tr>
                     </tbody>
                  </table>
                  <?php } ?>
                  <!-- <table class="table table-bordered  table-striped table-hover mytable3 hideTable"> -->
                  <table class="table table-bordered  table-striped table-hover mytable3">
                     <thead>
                        <tr>
                           <th colspan="7" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">PART I : For Use by Reporting Facility and DHO</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr id="proTd1">
   								<td><label class="pt7">Province <span style="color:red;">*</span></label></td>
   								<td>
                              <label class="pt7"><?php echo $this -> session -> provincename ?></label>
                           </td>
   								<td><label class="pt7">District <span style="color:red;">*</span></label></td>
   								<td id="districttd">
   									<input type="hidden" id="distcode" name="distcode" value="<?php $distcode = (isset($afp_Result))?$afp_Result->distcode:$this -> session -> District;  echo $distcode; ?>">
   									<label class="pt7"><?php echo get_District_Name($distcode); ?></label>
   								</td>
                        </tr>
                        <tr id="proTd2">
   								<td><label class="pt7">Tehsil <span style="color:red;">*</span></label></td>
   								<td><?php if(isset($afp_Result)){ ?>
   									<select class="form-control" name="tcode" id="tcode" required="required">
   									  <option value="<?php echo $afp_Result->tcode; ?>"><?php echo $tehsil; ?></option>
   									</select>
   									<?php }else{ ?>
   									<select class="form-control" name="tcode" id="tcode" required="required"></select>
   									<?php } ?>
   								</td>
                           <td><label class="pt7">Union Council <span style="color:red;">*</span></label></td>
                           <input id="module" type="hidden" value="disease_surveillance">
                           <td><?php if(isset($afp_Result)){ ?>
                              <select class="form-control" name="uncode" id="uncode">
                              <option value="<?php echo $afp_Result->uncode; ?>"><?php echo $unioncouncil; ?></option>
                              </select>
                              <?php }else{ ?>
                              <select class="form-control" name="uncode" id="uncode"></select>
                              <?php } ?>
                           </td>
							   </tr>
							   <tr>   								
                        <?php if(isset($afp_Result) && $afp_Result->cross_notified == 1 && $afp_Result -> cross_notified_from_distcode == $this -> session -> District){}else{ ?>
                           <td id="healthFacilityTd1"><label class="pt7">Health Facility <span style="color:red;">*</span></label></td>
                           <td id="healthFacilityTd2">
                              <?php if(isset($afp_Result)){ ?>
                                 <select class="form-control" required name="facode" id="facode">
                                    <option value="<?php echo $afp_Result->facode; ?>"><?php echo $facility; ?></option>
                                 </select>
                              <?php }else{ ?>
                              <select class="form-control" required name="facode" id="facode"></select>
                              <?php } ?>
                           </td>
                           <td id="healthFacilityAddressTd1"><label>Address of Health Facility</label></td>
                           <td id="healthFacilityAddressTd2"><input class="form-control" name="faddress" id="faddress" value="<?php if(isset($afp_Result)){ echo $afp_Result->faddress; } ?>" type="text"></td>
                           <?php } ?>
   								<!-- <td><label class="pt7">Year <span style="color:red;">*</span></label></td>
   								<td>
   									<select class="form-control text-center" required name="year" id="year">
   									<?php if(isset($afp_Result)){ ?>
   										<option value="<?php echo $afp_Result->year; ?>"><?php echo $afp_Result->year; ?></option>
   									<?php }else{ ?>
   									<?php echo $years; } ?>
   									</select>
   								</td> -->
   							</tr>
							<!-- <tr>
								<td><label class="pt7">Epid Week No <span style="color:red;">*</span></label></td>
								<td>
									<select class="form-control" required name="week" id="week">
										<?php if(isset($afp_Result)){ ?>
											<option value="<?php echo sprintf("%02d",$afp_Result->week); ?>">Week <?php echo sprintf("%02d",$afp_Result->week); ?></option>
										<?php }else{ ?>
										<option>--Select Week No--</option>
										<?php } ?>
									</select>
								</td>
								<td><label class="pt7">Date From <span style="color:red;">*</span></label></td>
								<td><input class="form-control text-center" required="required" readonly="readonly" name="datefrom" id="datefrom" value="<?php if(isset($afp_Result)){ echo date('d-m-Y',strtotime($afp_Result->datefrom)); }else { if(validation_errors() != false) { echo set_value('datefrom');} else{ } } ?>"  placeholder="From" type="text"></td>

								<td><label class="pt7">Date To <span style="color:red;">*</span></label></td>
								<td><input class="form-control text-center" required="required" readonly="readonly" name="dateto" id="dateto" value="<?php if(isset($afp_Result)){ echo date('d-m-Y',strtotime($afp_Result->dateto)); }else { if(validation_errors() != false) { echo set_value('dateto');} else{ } } ?>" placeholder="To" type="text"></td>
							</tr> -->
                  <!-- </tbody>
               </table>
               <table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
                  <thead>
                     <tr>
                        <th colspan="8" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Basic Information</th>
                     </tr>
                  </thead>
                  <tbody> -->           
               <tr>
                  <td><label class="pt7">Year <span style="color:red;">*</span></label></td>
                  <td>
                     <select class="form-control text-center" required name="year" id="year">
                     <?php if(isset($afp_Result)){ ?>
                        <option value="<?php echo $afp_Result->year; ?>"><?php echo $afp_Result->year; ?></option>
                     <?php }else{ ?>
                     <?php echo $years; } ?>
                     </select>
                  </td>
                  <td><label class="pt7">Epid Week No <span style="color:red;">*</span></label></td>
                  <td>
                     <select class="form-control" required name="week" id="week">
                        <?php if(isset($afp_Result)){ ?>
                           <option value="<?php echo sprintf("%02d",$afp_Result->week); ?>">Week <?php echo sprintf("%02d",$afp_Result->week); ?></option>
                        <?php }else{ ?>
                        <option>--Select Week No--</option>
                        <?php } ?>
                     </select>
                  </td>
               </tr> 
               <tr>
                  <td><label class="pt7">Date From <span style="color:red;">*</span></label></td>
                  <td><input class="form-control text-center" required="required" readonly="readonly" name="datefrom" id="datefrom" value="<?php if(isset($afp_Result)){ echo date('d-m-Y',strtotime($afp_Result->datefrom)); }else { if(validation_errors() != false) { echo set_value('datefrom');} else{ } } ?>"  placeholder="From" type="text"></td>

                  <td><label class="pt7">Date To <span style="color:red;">*</span></label></td>
                  <td><input class="form-control text-center" required="required" readonly="readonly" name="dateto" id="dateto" value="<?php if(isset($afp_Result)){ echo date('d-m-Y',strtotime($afp_Result->dateto)); }else { if(validation_errors() != false) { echo set_value('dateto');} else{ } } ?>" placeholder="To" type="text"></td>
               </tr>
                <?php if(isset($afp_Result) && $afp_Result->cross_notified == 1 && $afp_Result -> cross_notified_from_distcode == $this -> session -> District){}else{ ?>
               <tr id="epidNumberTR">
                  <td colspan="8">
                     <table>
                        <tbody>
                           <tr>
                              <td style="width: 25%;"><label style="margin-top: 7px;">EPID Number</label></td>
                              <td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">PAK</label></td>
                              <td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">/</label></td>
                              <td style="text-align: center; width: 1%;"><label style="margin-top: 7px;"><?php echo $_SESSION["shortname"]; ?></label></td>
                              <td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">/</label></td>                    
                              <td style="text-align: center; width: 3%;"><input type="hidden" name="dcode" id="dcode" value="<?php if(isset($distCode)){ echo $distCode; } ?>" /><label class="epid_code" style="margin-top: 7px;"><?php if(isset($distCode)){ echo $distCode; } ?></label></td>                   
                              <td style="width: 12%;">
                                 <select name="epid_year" id="epid_year"  class="form-control text-center epid_year">
                                    <?php if(isset($afp_Result) && $afp_Result->epid_year != ''){ ?>
                                    <option value="<?php echo $afp_Result -> epid_year; ?>"><?php echo $afp_Result -> epid_year; ?></option>
                                    <?php }else{ } //getAllYearsOptions(false); ?>   
                                 </select>
                              </td>
                              <td style="text-align: center; width: 3%;"><label>/</label></td> 
                              <td style="width: 4%;"><input class="form-control numberclass" name="a1" id="a1" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($afpNumber)){ echo $afpNumber[0]; } ?>" type="text"></td>
                              <td style="width: 4%;"><input class="form-control numberclass" name="a2" id="a2" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($afpNumber)){ echo $afpNumber[1]; } ?>" type="text"></td>
                              <td style="width: 4%;"><input class="form-control numberclass" name="a3" id="a3" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($afpNumber)){ echo $afpNumber[2]; } ?>" type="text"></td>
                              <td style="width: 4%;"><input class="form-control numberclass" name="a4" id="a4" maxlength="1" required="required" onchange="validateMeasleNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($afpNumber)){ echo $afpNumber[3]; } ?>" type="text"></td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            <?php } ?>
	            <tr>
                  <td><label>Patient's Name <span style="color:red;">*</span></label></td>
                  <td><input class=" form-control" required="required" name="patient_name" id="patient_name" value="<?php if(isset($afp_Result)){ echo $afp_Result->patient_name; } ?>" type="text"></td>
                  <td><label>Gender</label></td>
                  <td style="width: 22%;">
                     <table style="width:60%;margin-top: 6px;">
                        <tbody>
                           <tr>
                              <td>Male&nbsp;<input type="radio" id="patient_gender" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="patient_gender" <?php if(isset($afp_Result) && $afp_Result->patient_gender == '1'){ echo 'checked="checked"'; } ?> value="1" ></td>
                              <td>Female&nbsp;<input type="radio" id="patient_gender" name="patient_gender" <?php echo (isset($afp_Result) && $afp_Result->patient_gender == 0)?'checked="checked"':''; ?> value="0" ></td>
                           </tr>
                        </tbody>
                     </table>
                  </td>                  
               </tr>
               <tr>                  
                  <td><label>Father's Name <span style="color:red;">*</span></label></td>
                  <td><input class=" form-control" required="required" name="patient_fathername" id="patient_fathername" value="<?php if(isset($afp_Result)){ echo $afp_Result->patient_fathername; } ?>" type="text"></td>
                  <td><p>Contact Number</p></td>
                        <td><input class="numberclass form-control" name="contact_numb" id="contact_numb" value="<?php if(isset($afp_Result)){ echo $afp_Result->contact_numb; } ?>" type="text"></td>
               </tr>
               <tr>
                  <td><label>Date of Birth <span style="color:red;">*</span></label></td>
                  <td><input class="dp form-control" onchange="ageCalculater(this.value);" name="patient_dob" id="patient_dob" value="<?php if(isset($afp_Result)){ if($afp_Result->patient_dob!= '1969-12-31' && $afp_Result->patient_dob!= NULL){ echo date('d-m-Y',strtotime($afp_Result->patient_dob)); }else{ echo ''; } } ?>" type="text"></td>
                  <td><label>Age (M)</label></td>
                  <td><input class="numberclass form-control" name="age_months" id="months" value="<?php if(isset($afp_Result)){ echo $afp_Result->age_months; } ?>" type="text"></td>
               </tr>
              
            </tbody>
         </table>
         <table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
            <thead>
               <tr>
                  <th colspan="8" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Address of Patient</th>
               </tr>
            </thead>
            <tbody>						
					<tr class="otherProvinceAddress">	
						<td><label>Province <span style="color:red;">*</span></label></td>
						<td>
                  <?php if(isset($afp_Result) && $afp_Result-> cross_notified == 1 ){ ?>
                     <p><?php echo get_Province_Name($afp_Result-> procode); ?></p> 
                     <input type="hidden" name="procode" value="<?php if(isset($afp_Result)) { echo $afp_Result-> procode; } ?>">
                  <?php } else { ?> 
						   <select name="procode" id="other_procode" class="form-control allprocodes" required="required">
							
						   </select>
                  <?php } ?>
						</td>
						<td><label>District <span style="color:red;">*</span></label></td>
						<td>
                  <?php if(isset($afp_Result) && $afp_Result-> cross_notified == 1 ){ ?>	 
                     <select name="patient_address_distcode" id="other_pro_district" class="otherprocode form-control">
                        <?php if(isset($afp_Result) && $afp_Result -> patient_address_distcode > 0){ ?>
                           <option selected="selected" value="<?php echo $afp_Result -> patient_address_distcode; ?>"><?php echo CrossProvince_DistrictName($afp_Result -> patient_address_distcode); ?></option>
                        <?php }else{ ?>
                           <?php getCrossProvince_DistrictsOptions(false,NULL,'Yes'); ?>
                        <?php } ?>

                     </select>

                     <select name="patient_address_distcode" id="other_pro_distcode" class="procodekp form-control">
                        <?php if(isset($afp_Result) && $afp_Result -> patient_address_distcode > 0){ ?>
                           <option selected="selected" value="<?php echo $afp_Result -> patient_address_distcode; ?>"><?php echo CrossProvince_DistrictName($afp_Result -> patient_address_distcode); ?></option>
                        <?php }else{ ?>
                           <?php getCrossProvince_DistrictsOptions(false,NULL,'Yes'); ?>
                        <?php } ?>

                     </select>

                  <?php } else { ?>    
							<select name="patient_address_distcode" id="other_pro_district" class="otherprocode form-control hide">										
							</select>

							<select name="patient_address_distcode" id="other_pro_distcode" class="procodekp form-control hide">
								<option selected="selected" value="">--Select--</option>
								<?php getDistricts_options(false,NULL,'Yes'); ?>
							</select>
                  <?php } ?>   
						</td>
					</tr>
					<tr class="otherProvinceAddress">	
						<td><label>Tehsil <span style="color:red;">*</span></label></td>
						<td>
                  <?php if(isset($afp_Result) && $afp_Result-> cross_notified == 1 ){ ?>	
                     <select name="patient_address_tcode" id="other_pro_tehsil" class="otherprocode form-control">
                     <?php echo getCrossProvince_TehsilOptions(false,$afp_Result-> patient_address_tcode,$afp_Result-> patient_address_distcode); ?>                              
                     </select>

                     <select name="patient_address_tcode" id="other_pro_tcode" class="procodekp form-control">
                        <?php echo getCrossProvince_TehsilOptions(false,$afp_Result-> patient_address_tcode,$afp_Result-> patient_address_distcode); ?>                              
                     </select>

                  <?php } else { ?>								
							<select name="patient_address_tcode" id="other_pro_tehsil" class="otherprocode form-control hide">										
							</select>

							<select name="patient_address_tcode" id="other_pro_tcode" class="procodekp form-control hide">										
							</select>
                  <?php } ?>
						</td>
						<td><label>UC <span style="color:red;">*</span></label></td>
						<td>
                  <?php if(isset($afp_Result) && $afp_Result-> cross_notified == 1 ){ ?>  							
                     <select name="patient_address_uncode" id="other_pro_uc" class="otherprocode form-control">
                        <?php echo getCrossProvince_UCsOptions(false,$afp_Result-> patient_address_uncode,$afp_Result-> patient_address_tcode); ?>

                     </select>

                     <select name="patient_address_uncode" id="other_pro_uncode" class="procodekp form-control">
                        <?php echo getCrossProvince_UCsOptions(false,$afp_Result-> patient_address_uncode,$afp_Result-> patient_address_tcode); ?>

                     </select>

                  <?php } else { ?> 	
							<select name="patient_address_uncode" id="other_pro_uc" class="otherprocode form-control hide">										
							</select>

							<select name="patient_address_uncode" id="other_pro_uncode" class="procodekp form-control hide">										
							</select>
                  <?php } ?>
						</td>
					</tr>
            <?php if(!isset($afp_Result) OR (isset($afp_Result) && $afp_Result-> cross_notified == 0)){ ?>  
					<tr id='patient1stTr' class="crossNotify">
						<td><label>Province <span style="color:red;">*</span></label></td>
						<td>
							<p><?php echo $this -> session -> provincename; ?></p>
							<input class="form-control" name="patient_address_procode" value="<?php echo $this -> session -> Province; ?>" readonly="readonly" id="patient_address_procode" placeholder="Khyber Pakhtunkhwa" type="hidden">
						</td>
						<td><label>District <span style="color:red;">*</span></label></td>
						<td id="patientDistcodeTd">
							<select id="patient_address_distcode" name="patient_address_distcode" class="form-control">
								<?php if(isset($afp_Result) && $afp_Result -> patient_address_distcode > 0){ ?>
								<option value="<?php echo $afp_Result -> patient_address_distcode; ?>"><?php echo getDistricts_options(false,$afp_Result -> patient_address_distcode,'No'); ?></option>
								<?php }else{ ?>
								<?php echo getDistricts_options(false,$distcode,'No'); ?>
								<?php } ?>
							</select>
						</td>            
					</tr>
					<tr id='patient2ndTr' class="crossNotify">
						<td><label>Tehsil <span style="color:red;">*</span></label></td>
						<td>									
							<select id="patient_address_tcode" name="patient_address_tcode" class="form-control" readonly>
								<?php if(isset($afp_Result) && $afp_Result -> patient_address_tcode > 0){ ?>
								<option value="<?php echo $afp_Result -> patient_address_tcode; ?>"><?php echo getTehsils_options(false,$afp_Result -> patient_address_tcode,$afp_Result -> patient_address_distcode); ?></option>
								<?php }else{ ?> 
								<?php getTehsils_options(false); } ?>
							</select>									
						</td>
						<td><label>Union Council <span style="color:red;">*</span></label></td>
						<td>
   						<select id="patient_address_uncode" name="patient_address_uncode" class="form-control" readonly>
   						<?php if(isset($afp_Result) && $afp_Result->patient_address_uncode > 0){ echo getUCs(false,$afp_Result->patient_address_uncode,$afp_Result -> patient_address_tcode); }else{ ?>
   						<?php getUCs_options(false); } ?>
   						</select>
                  </td>
					</tr>
            <?php } ?>						
					<tr>
						<td><label>Village / Street / Mohallah <span style="color:red;">*</span></label></td>
						<td colspan="3"><input class=" form-control" name="patient_address" id="patient_address" value="<?php if(isset($afp_Result)){ echo $afp_Result->patient_address; } ?>" type="text"></td>
					</tr>
				</tbody>
         </table>
         <table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
            <thead>
               <tr>
                  <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Disease Information</th>
               </tr>
            </thead>
               <tbody>
                  <tr>
                     <td>
                        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                           <tbody>
                              <tr>
                                 <td><label>Data of Onset Paralysis</label></td>
                                 <td>
                                    <table style="width:100%;margin-top: 6px;">
                                       <tbody>
                                          <tr>
                                             <td><input class="dp form-control" onchange="getdate();" name="case_date_onset" id="case_date_onset" value="<?php if(isset($afp_Result) && $afp_Result->case_date_onset != NULL){ echo date('d-m-Y',strtotime($afp_Result->case_date_onset)); }else{} ?>" type="text" required="required"></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td><label>Date of Notification</label></td>
                                 <td>
                                    <table style="width:100%;margin-top: 6px;">
                                       <tbody>
                                          <tr>
                                             <td><input class="dp form-control" placeholder="" name="case_date_notification" id="case_date_notification" value="<?php if(isset($afp_Result) && $afp_Result->case_date_notification != NULL){ echo date('d-m-Y',strtotime($afp_Result->case_date_notification)); } ?>" type="text"></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td><label>Date of Investigation</label></td>
                                 <td>
                                    <table style="width:100%;margin-top: 6px;">
                                       <tbody>
                                          <tr>
                                             <td><input class="dp form-control" placeholder="" name="case_date_investigation" id="case_date_investigation" value="<?php if(isset($afp_Result) && $afp_Result->case_date_investigation != NULL){ echo date('d-m-Y',strtotime($afp_Result->case_date_investigation)); } ?>" type="text"></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td><label>Clinical Representation</label></td>
                                 <td><input class="form-control text-center" readonly="readonly" name="clinical_representation" id="clinical_representation" value="<?php if(isset($afp_Result)){ echo ($afp_Result->clinical_representation); } else{ echo "Floppy Paralysis"; }?>" type="text"></td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                     <td>
                     <table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
                        <tbody>
                           <tr>
                              <td><label>Fever at onset</label></td>
                              <td>
                                 <table style="width:100%;margin-top: 6px;">
                                    <tbody>
                                       <tr>
                                          <td>Yes&nbsp;<input type="radio" id="fever_onset" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="fever_onset" <?php if(isset($afp_Result) && $afp_Result->fever_onset == '1'){ echo 'checked="checked"'; } ?> value="1" ></td>
                                          <td>No&nbsp;<input type="radio" id="fever_onset" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="fever_onset" <?php if(isset($afp_Result) && $afp_Result->fever_onset == '0'){ echo 'checked="checked"'; } ?> value="0" ></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                           <tr>
                              <td><label>Rapid progression</label></td>
                              <td>
                                 <table style="width:100%;margin-top: 6px;">
                                    <tbody>
                                       <tr>
                                          <td>Yes&nbsp;<input type="radio" id="rapid_progression" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="rapid_progression" <?php if(isset($afp_Result) && $afp_Result->rapid_progression == '1'){ echo 'checked="checked"'; } ?> value="1" ></td>
                                          <td>No&nbsp;<input type="radio" id="rapid_progression" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="rapid_progression" <?php if(isset($afp_Result) && $afp_Result->rapid_progression == '0'){ echo 'checked="checked"'; } ?> value="0" ></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                           <tr>
                              <td><label>Asymm paralysis</label></td>
                              <td>
                                 <table style="width:100%;margin-top: 6px;">
                                    <tbody>
                                       <tr>
                                          <td>Yes&nbsp;<input type="radio" id="asymm_paralysis" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="asymm_paralysis" <?php if(isset($afp_Result) && $afp_Result->asymm_paralysis == '1'){ echo 'checked="checked"'; } ?> value="1" ></td>
                                          <td>No&nbsp;<input type="radio" id="asymm_paralysis" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="asymm_paralysis" <?php if(isset($afp_Result) && $afp_Result->asymm_paralysis == '0'){ echo 'checked="checked"'; } ?> value="0" ></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
                  <td>
                     <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                        <thead>
                           <tr>
                              <th colspan="2">OPV Doses</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><label>Routine <span style="color:red;">*</span></label></td>
                              <td><input class=" form-control numberclass" required="required" name="doses_received" id="routine_doses" value="<?php if(isset($afp_Result)){ echo $afp_Result->doses_received; } ?>" type="text">
                              </td>
                           </tr>
                           <tr>
                              <td><label>SIA <span style="color:red;">*</span></label></td>
                              <td><input class="form-control numberclass" required="required" name="sia" id="sia" value="<?php if(isset($afp_Result)){ echo $afp_Result->sia; } ?>" type="text">
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
         <table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
            <thead>
               <tr>
                  <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Stool Samples</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>
                     <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                        <thead>
                           <tr>
                              <th colspan="2">Sample 1</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><label>Date of Collection</label></td>
                              <td><input class="dp form-control" placeholder="" name="date_collection_s1" id="date_collection_s1" value="<?php if(isset($afp_Result) && $afp_Result->date_collection_s1 != NULL){ echo date('d-m-Y',strtotime($afp_Result->date_collection_s1)); }else{} ?>" <?php if(validation_errors() != false) { echo 'set_value("date_collection_s1","date_collection_s1")';} ?> type="text">
                              </td>
                           </tr>
                           <tr>
                              <td><label>Date sent to Lab</label></td>
                              <td><input class="dp form-control" placeholder="" name="date_sent_lab_s1" id="date_sent_lab_s1" value="<?php if(isset($afp_Result) && $afp_Result->date_sent_lab_s1 != NULL){ echo date('d-m-Y',strtotime($afp_Result->date_sent_lab_s1)); }else{} ?>" <?php if(validation_errors() != false) { echo 'set_value("date_sent_lab_s1","date_sent_lab_s1")';} ?> type="text">
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
                  <td>
                     <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                        <thead>
                           <tr>
                              <th colspan="2">Sample 2</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><label>Date of Collection</label></td>
                              <td><input class="dp form-control" placeholder="" name="date_collection_s2" id="date_collection_s2" value="<?php if(isset($afp_Result) && $afp_Result->date_collection_s2 != NULL){ echo date('d-m-Y',strtotime($afp_Result->date_collection_s2)); }else{} ?>" <?php if(validation_errors() != false) { echo 'set_value("date_collection_s2","date_collection_s2")';} ?> type="text">
                              </td>
                           </tr>
                           <tr>
                              <td><label>Date sent to Lab</label></td>
                              <td><input class="dp form-control" placeholder="" name="date_sent_lab_s2" id="date_sent_lab_s2" value="<?php if(isset($afp_Result) && $afp_Result->date_sent_lab_s2 != NULL){ echo date('d-m-Y',strtotime($afp_Result->date_sent_lab_s2)); }else{} ?>" <?php if(validation_errors() != false) { echo 'set_value("date_sent_lab_s2","date_sent_lab_s2")';} ?> type="text">
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>    
         </table>
         <table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
            <thead>
               <tr>
                  <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Lab Results (&condition)</th>
               </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                    <thead>
                      <tr>
                        <th colspan="2">Sample 1</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><label>Condition</label></td>
                        <td><input class=" form-control" name="condition_s1" id="condition_s1" value="<?php if(isset($afp_Result)){ echo $afp_Result->condition_s1; } ?>" type="text">
                        </td>
                      </tr>
                      <tr>
                        <td><label>Final Result</label></td>
                        <td><input class=" form-control" name="final_result_s1" id="final_result_s1" value="<?php if(isset($afp_Result)){ echo $afp_Result->final_result_s1; } ?>" type="text">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
                <td>
                  <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                     <thead>
                        <tr>
                        <th colspan="2">Sample 2</th>
                        </tr>
                     </thead>
                     <tbody>
                     <tr>
                        <td><label>Condition</label></td>
                        <td><input class=" form-control" name="condition_s2" id="condition_s2" value="<?php if(isset($afp_Result)){ echo $afp_Result->condition_s2; } ?>" type="text">
                        </td>
                        </tr>
                        <tr>
                        <td><label>Final Result</label></td>
                        <td><input class=" form-control" name="final_result_s2" id="final_result_s2" value="<?php if(isset($afp_Result)){ echo $afp_Result->final_result_s2; } ?>" type="text">
                        </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      <table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
         <thead>
            <tr>
               <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Follow Up</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>
                  <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                     <thead>
                        <tr>
                        <th colspan="2">60 day follow up</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td><label>Date</label></td>
                           <td><input class="dp form-control" placeholder="" name="date_follow_up" id="date_follow_up" value="<?php if(isset($afp_Result) && $afp_Result->date_follow_up != NULL){ echo date('d-m-Y',strtotime($afp_Result->date_follow_up)); }else{} ?>" <?php if(validation_errors() != false) { echo 'set_value("date_follow_up","date_follow_up")';} ?> type="text">
                           </td>
                        </tr>
                        <tr>
                           <td><label>Residual paralysis weakness</label></td>
                           <td>
                              <table style="width:100%;margin-top: 6px;">
                                 <tbody>
                                    <tr>
                                    <td>Yes&nbsp;<input type="radio" id="residual_paralysis" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="residual_paralysis" <?php if(isset($afp_Result) && $afp_Result->residual_paralysis == '1'){ echo 'checked="checked"'; } ?> value="1" ></td>
                                    <td>No&nbsp;<input type="radio" id="residual_paralysis" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="residual_paralysis" <?php if(isset($afp_Result) && $afp_Result->residual_paralysis == '0'){ echo 'checked="checked"'; } ?> value="0" ></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
               <td>
                  <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                     <thead>
                        <tr>
                        <th colspan="4">Classification</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td><label>Confirmed</label></td>
                           <td>
                              <table style="width:100%;margin-top: 6px;">
                                 <tbody>
                                    <tr>
                                       <td><input type="radio" id="classification" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="classification" <?php if(isset($afp_Result) && $afp_Result->classification == '1'){ echo 'checked="checked"'; } ?> value="1" ></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td><label>Compatible</label></td>
                           <td>
                              <table style="width:100%;margin-top: 6px;">
                                 <tbody>
                                    <tr>
                                       <td><input type="radio" id="classification" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="classification" <?php if(isset($afp_Result) && $afp_Result->classification == '2'){ echo 'checked="checked"'; } ?> value="2" ></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td><label>Discarded</label></td>
                           <td>
                              <table style="width:100%;margin-top: 6px;">
                                 <tbody>
                                    <tr>
                                    <td><input type="radio" id="classification" <?php if(!isset($afp_Result)){ echo 'checked="checked"'; } ?> name="classification" <?php if(isset($afp_Result) && $afp_Result->classification == '3'){ echo 'checked="checked"'; } ?> value="3" ></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
               <td>
                  <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                     <thead>
                        <tr>
                           <th colspan="2"> </th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td><label>Final diagnosis</label></td>
                           <td>
                              <select id="final_diagnosis" name="final_diagnosis" class="form-control">
                                 <option value="">-- Select --</option>
                                 <option <?php if(isset($afp_Result) && $afp_Result->final_diagnosis == 'Injection Neuritis') { echo 'selected="selected"'; } else { echo ''; } ?> value="Injection Neuritis">Injection Neuritis</option>
                                 <option <?php if(isset($afp_Result) && $afp_Result->final_diagnosis  == 'Injection Trauma') { echo 'selected="selected"'; } else { echo ''; } ?> value="Injection Trauma">Injection Trauma</option>
                                 <option <?php if(isset($afp_Result) && $afp_Result->final_diagnosis  == 'Cyprus Malaria') { echo 'selected="selected"'; } else { echo ''; } ?> value="Cyprus Malaria">Cyprus Malaria</option>
                                 <option <?php if(isset($afp_Result) && $afp_Result->final_diagnosis  == 'Hemiplegia') { echo 'selected="selected"'; } else { echo ''; } ?> value="Hemiplegia">Hemiplegia</option>
                              </select>
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
               <td style="width:50%;" class="text-center"><label>Submission Date</label></td>
               <?php if(isset($afp_Result)) { ?>
               <td class="text-center" id="get_date"><?php if(isset($afp_Result)){ echo $current_date; } ?></td>
               <input type="hidden" id="editted_date" name="editted_date" value="<?php if(isset($afp_Result)){ echo date('d-m-Y',strtotime($afp_Result->editted_date)); } else{ echo $current_date; } ?>" type="date">
               <?php } else{ ?>
               <td class="text-center"><?php echo $current_date; ?> </td>
               <td><input type="hidden" name="submitted_date" value="<?php echo $current_date; ?>" type="date"></td>
               <?php } ?>
            </tr>
         </tbody>
		</table>
      <div class="row">
         <hr>
         <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
            <button style="background: #008d4c;" type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save  </button>
            <button style="background: #008d4c;" type="submit" name="is_temp_saved" value="0" id="myCoolForm" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit  </button>
            <button onclick="javascript:disablebuttons();" style="background: #008d4c;" class="btn btn-primary btn-md" type="reset">
            <i class="fa fa-repeat"></i> Reset </button>
            <a href="<?php echo base_url(); ?>AFP-CIF/List" style="background: #008d4c" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
         </div>
      </div>
   </form>
   </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--end of body container-->


<script src="<?php echo base_url(); ?>includes/js/moment.js"></script>
<script type="text/javascript">
   var referingFacilityInfo="";
   $(document).ready(function(){
      referingFacilityInfo = $('#rb_info').html();
      <?php if(isset($afp_Result)){ ?>  
      //$('#rb_info').html('');
      <?php } else{ ?> 
         $('#rb_info').html('');
      <?php } ?> 
    
      <?php if(!isset($afp_Result)){ ?>
         var year = $("#year").val();
         var newOption = $('<option value="'+year+'">'+year+'</option>');
         $('#epid_year').append(newOption);
         //$('.epid_year').trigger('change');
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

//***************************************code to disable submit ends here*********************************//

	// code for set radio button on page load
	$('input:radio[name="gender"][value="Male"]').attr('checked', true);
	$('input:radio[name="active_sur_visit"][value="0"]').attr('checked', true);
	$('input:radio[name="identified_weekly_data"][value="0"]').attr('checked', true);
	$('input:radio[name="informed_by_call"][value="0"]').attr('checked', true);

	if($("input[name = 'case_reported']:checked").val()=='0'){
		$('.disabledclass').find('input, textarea, button, select').attr('disabled','disabled');
		//$("input.disabledclass").attr("disabled", true);
	}else{
		$('.disabledclass').find('input, textarea, button, select').attr('disabled',false);
	}

	var get_date = $('#get_date').text();
	$('#editted_date').val(get_date);
	$(document).on('change','#case_reported',function(){
		if($(this).val()=='0'){
			$('.disabledclass').find('input, textarea, button, select').attr('disabled','disabled');
		}else{
			$('.disabledclass').find('input, textarea, button, select').attr('disabled',false);
		}
	});

	$(document).on('change','#year',function(){
  		var year = $("#year").val();
  		$('#epid_year').find('option').remove().end().append('<option value="'+year+'">'+year+'</option>').val(year);
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

	$(document).on('change','#week,#facode,#rb_facode',function(){
		var week = $("#week").val();
		var year = $('#year').val();
		if($('#cb_cross_notified:checked').val() == 'on'){
			var facode= $('#rb_facode').val();
		}else{
			var facode= $('#facode').val();
		}			var disease="afp";
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
/* 			if(week!=null && week > 0 && facode!=null && facode > 0)
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
						var r = confirm("Either you have already submitted required number of Case Investigation Forms of AFP for the selected WEEK, YEAR & FACILITY!\n\nOR you have not submitted Zero Report for selected Week and Facility! \n\nClick OK to go back! \n\nClick Cancel to select different Week and Facility!  ");
						if(r!=true)
						{
							$('#week').val('');
							$('#facode').val('');
							$('#week option:first').prop('selected', true);							
							$('#facode option:first').prop('selected', true);
						}
						else
						{
							window.location.href = '<?php echo base_url(); ?>AFP-CIF/List';
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
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#patient_address_tcode').html(result);
					if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
					{
						$('#patient_address_tcode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
				}
			});
		});

		$(document).on('change','#patient_address_uncode',function(){
			$.ajax({
				type: "POST",
				data: "uncode="+$(this).val(),
				url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
				success: function(result){
					$('#patient_address_facode').html(result);
					if( typeof selectedfacode !== 'undefined' && selectedfacode>0)
					{
						$('#patient_address_facode option[value="' + selectedfacode + '"]').prop('selected', true);
					}
				}
			});
		});

		$(document).on('change','#patient_address_tcode',function(){
			$.ajax({
				type: "POST",
				data: "tcode="+$(this).val(),
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC",
				success: function(result){
					$('#patient_address_uncode').html(result);
					if( typeof selectedtcode !== 'undefined' && selectedtcode>0)
					{
						$('#patient_address_uncode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
				}
			});
		});
	});
   
   // $('#distcode').on('change', function() {
   //    var distcode = $("#distcode").val();
   //    //$('#patient_address_tcode').val(tcode);
   //    $("#patient_address_distcode option[value="+distcode+"]").prop("selected",true);    
   // });
   $('#tcode').on('change', function() {
      var tcode = $("#tcode").val();     
      $("#patient_address_tcode option[value="+tcode+"]").prop("selected",true);          
   });
   // $('#uncode').on('change', function() {
   //    var uncode = $("#uncode").val();
   //    $("#patient_address_uncode option[value="+uncode+"]").prop("selected",true);
   // });

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
		function validateMeasleNumber(){

		    var measleNumber = "PAK/KP/"+$('#dcode').val()+"/"+$('.epid_year').val()+$('#a1').val()+$('#a2').val()+$('#a3').val()+$('#a4').val();
		    var epid_code =$('.epid_code').text();
		    var year = $('.epid_year').val();
		    if ($('#a4').val()==0 && $('#a3').val()==0 && $('#a2').val()==0 && $('#a1').val()==0) {
				document.getElementById("a1").style.borderColor = "red";
				document.getElementById("a2").style.borderColor = "red";
				document.getElementById("a3").style.borderColor = "red";
				document.getElementById("a4").style.borderColor = "red";
				alert("AFP Number Should Not be Zero!");

				$.ajax({ 
					type: 'POST',
					data: "&year="+year+"&epid_code="+epid_code,
					//data: "year="+$('#year').val(),
					url: '<?php echo base_url();?>Ajax_calls/getAfpNumber',

					success: function(data){
						var response= JSON.parse(data);
						$('#a1').val(response[0]);
						$('#a2').val(response[1]);
						$('#a3').val(response[2]);
						$('#a4').val(response[3]);
						document.getElementById("a1").style.borderColor = "";
						document.getElementById("a2").style.borderColor = "";
						document.getElementById("a3").style.borderColor = "";
						document.getElementById("a4").style.borderColor = "";
					} 
				});
		    }
            else{

			    $.ajax({
					type: 'POST',
					//data: "measleNumber="+measleNumber,
					data:{measleNumber:measleNumber},
					url: '<?php echo base_url();?>Ajax_calls/validateAfpNumber',
					success: function(data){
						if(data==1){
							document.getElementById("a1").style.borderColor = "red";
							document.getElementById("a2").style.borderColor = "red";
							document.getElementById("a3").style.borderColor = "red";
							document.getElementById("a4").style.borderColor = "red";
							alert("AFP Number Already Exists!");

							$.ajax({ 
								type: 'POST',
								data: "&year="+year+"&epid_code="+epid_code,
								//data: "year="+$('#year').val(),
								url: '<?php echo base_url();?>Ajax_calls/getAfpNumber',
								success: function(data){
									var response= JSON.parse(data);
									$('#a1').val(response[0]);
									$('#a2').val(response[1]);
									$('#a3').val(response[2]);
									$('#a4').val(response[3]);
									document.getElementById("a1").style.borderColor = "";
									document.getElementById("a2").style.borderColor = "";
									document.getElementById("a3").style.borderColor = "";
									document.getElementById("a4").style.borderColor = "";
								}
							});
						}

						if(data=="Correct"){
							document.getElementById("a1").style.borderColor = "";
							document.getElementById("a2").style.borderColor = "";
							document.getElementById("a3").style.borderColor = "";
							document.getElementById("a4").style.borderColor = "";
    						$.ajax({ 
    							type: 'POST',
    							data: "&year="+year+"&epid_code="+epid_code,
    							//data: "year="+$('#year').val(),
    							url: '<?php echo base_url();?>Ajax_calls/getAfpNumber',
    							success: function(data){
    								var response= JSON.parse(data);
    								$('#a1').val(response[0]);
    								$('#a2').val(response[1]);
    								$('#a3').val(response[2]);
    								$('#a4').val(response[3]);
    							}
    						});
					    }					
				    }
		        });
	        }
        }

	$('.epid_year').on('change', function() {
	    //var year = ( this.value ); // or $(this).val()
	    var epid_code =$('.epid_code').text();
	    var year = $('.epid_year').val();
		$.ajax({ 
			type: 'POST',
			//data: "fmonth="+fmonth,
			data: "&year="+year+"&epid_code="+epid_code,
			url: '<?php echo base_url();?>Ajax_calls/getAfpNumber',
			success: function(data){
			    var response= JSON.parse(data); 
			    $('#a1').val(response[0]);
			    $('#a2').val(response[1]);
			    $('#a3').val(response[2]);
			    $('#a4').val(response[3]);
			    document.getElementById("a1").style.borderColor = "";
			    document.getElementById("a2").style.borderColor = "";
			    document.getElementById("a3").style.borderColor = "";
			    document.getElementById("a4").style.borderColor = "";
			}
		}); 
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
		$('#date_follow_up').val(someFormattedDate);
	}
	//function for enable/disable 
function disablebuttons()
{
	$('#myCoolForm').prop('disabled', true);
   $('#save').prop('disabled', true);
}
<?php if(!isset($afp_Result)){?>
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

    $(document).ready(function(){
        $("#case_date_onset").datepicker({
            todayBtn:  1,
            autoclose: true,
            format: 'dd-mm-yyyy',
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#case_date_notification').datepicker('setStartDate', minDate);
        });

        $("#case_date_notification").datepicker({ format: 'dd-mm-yyyy' })
        .on('changeDate', function (selected) {   
            var minDate = new Date(selected.date.valueOf());
            $('#case_date_onset').datepicker('setEndDate', minDate);
        });
    });

    $(document).ready(function(){
        $("#case_date_notification").datepicker({
            todayBtn:  1,
            autoclose: true,
            format: 'dd-mm-yyyy',
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#case_date_investigation').datepicker('setStartDate', minDate);
        }); 

        $("#case_date_investigation").datepicker({ format: 'dd-mm-yyyy' })
        .on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#case_date_notification').datepicker('setEndDate', minDate);
        });

         // $('#other_procode').removeAttr('required','required');
         // $('#other_procode').addClass('hide');
         // $('#patient_address_distcode').removeClass('hide');
         // $('#patient_address_distcode').attr('required','required');
         // $('#other_pro_district').addClass('hide');         
         // $('#other_pro_district').removeAttr('required','required');
    });

	$(document).on('keydown', function(e){
		if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
    		$("#save").click();
			e.preventDefault();
			return false;
		}
	});
<?php if(!isset($afp_Result)) { ?>
   $(document).ready(function(){
      $('#other_procode').removeAttr('required','required');
      $('#other_procode').addClass('hide');
      $('#patient_address_distcode').removeClass('hide');
      $('#patient_address_distcode').attr('required','required');
      $('#other_pro_district').addClass('hide');         
      $('#other_pro_district').removeAttr('required','required');
      $('#other_pro_distcode').addClass('hide');         
      $('#other_pro_distcode').removeAttr('required','required');
   });
<?php } ?>
   if($('#cb_cross_notified').not(':checked').length){
		$('.crossNotify').removeClass('hide');
		$('.otherProvinceAddress').addClass('hide');
		$('#other_procode').removeAttr('required','required');
	}
   var tdHtml = "";var epidNumberHtml = ""; var patient1stTr=""; var patient2ndTr = "";var healthFacilityTd1="";var healthFacilityTd2=""; var healthFacilityAddressTd1=""; var healthFacilityAddressTd2=""; var proTd1=""; var proTd2="";
    $(document).on('click','#cb_cross_notified',function(){
         $('#save').attr('disabled', 'disabled');
         $('#myCoolForm').attr('disabled', 'disabled');
         $('#cb_cross_notified').attr('disabled','disabled');
         if(this.checked == true){
            $('#rb_info').html(referingFacilityInfo);
            $('#rb_info').removeClass('hide');
            $('#cross_notified').val('1');
            $('.hideTable').addClass('hide');
            tdHtml = $('#districttd').html();
            epidNumberHtml = $('#epidNumberTR').html();
            patient1stTr = $('#patient1stTr').html();
            patient2ndTr = $('#patient2ndTr').html();
            healthFacilityTd1 = $('#healthFacilityTd1').html();
            healthFacilityTd2 = $('#healthFacilityTd2').html();
            healthFacilityAddressTd1 = $('#healthFacilityAddressTd1').html();
            healthFacilityAddressTd2 = $('#healthFacilityAddressTd2').html();
            proTd1 = $('#proTd1').html();
            proTd2 = $('#proTd2').html();
            $('#epidNumberTR').html('');
            $('#districttd').html('');
            $('#healthFacilityTd1').html('');
            $('#healthFacilityTd2').html('');
            $('#healthFacilityAddressTd1').html('');
            $('#healthFacilityAddressTd2').html('');
            $('.crossNotify').addClass('hide');
            $('#proTd1').html('');
            $('#proTd2').html('');
            $('#tcode').empty();
            $('#patient_address_distcode').val('');
            $('#patient_address_tcode').val('');
            $('#patient_address_uncode').val('');
            $('#other_procode').attr('required','required');
            $('#other_procode').removeClass('hide');
            $('.otherProvinceAddress').removeClass('hide');
            $('#patient_address_procode').attr('disabled','disabled');
            
            $.ajax({ 
                type: 'POST',
                data: '',
                url: '<?php echo base_url();?>Ajax_calls/getDistricts_optionsAFP',
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
            $('.hideTable').removeClass('hide');
            $('#districttd').html(tdHtml);
            $('#patient1stTr').html(patient1stTr);
            $('#patient2ndTr').html(patient2ndTr);
            $('#epidNumberTR').html(epidNumberHtml);
            $('#healthFacilityTd1').html(healthFacilityTd1);
            $('#healthFacilityTd2').html(healthFacilityTd2);
            $('#healthFacilityAddressTd1').html(healthFacilityAddressTd1);
            $('#healthFacilityAddressTd2').html(healthFacilityAddressTd2);
            $('#proTd1').html(proTd1);
            $('#proTd2').html(proTd2);
            $('#distcode').trigger('change');
            $('#cb_cross_notified').removeAttr('disabled','disabled');
            $('#facode').empty();
            $('#rb_info').html('');
            $('#other_procode').removeAttr('required','required');
            $('#other_procode').addClass('hide');
            $('.otherProvinceAddress').addClass('hide');
            $('.crossNotify').removeClass('hide');
            $('#patient_address_procode').removeAttr('disabled','disabled');
        }       
    });
    $(document).on('change','#distcode',function(){
        if($("#cb_cross_notified").is(':checked')){
            $('#patient_address_uncode').empty();
            var dist = $('#distcode').val();
            $.ajax({ 
                type: 'POST',
                data: 'distcode='+dist,
                url: '<?php echo base_url();?>Ajax_calls/getDistricts_optionsAFP',
                success: function(data){
                    $('#patientDistcodeTd').html(data);
                    $('#patient_address_distcode').trigger('change');
                }
            });
        }
  
        $('#facode').empty();
    });
	//function start
	function fromDate(start_date_id, end_date_id)
	{
		var from_date = $('#'+start_date_id).datepicker({ dateFormat: 'dd-mm-yyyy' }).val();
		//var to_date = $("#"+end_date_id).datepicker({ dateFormat: 'dd-mm-yyyy' }).val();
		$("#"+end_date_id).datepicker('setStartDate', from_date);
		//$("#"+end_date_id).datepicker('setEndDate', '+2y');
		/* if(to_date < from_date){
			$("#"+end_date_id).val('');
		} */
	}
	function toDate(start_date_id, end_date_id){
		$('#'+start_date_id).datepicker('setStartDate', "01-01-1925");
		$('#'+start_date_id).datepicker('setEndDate', '+0d');
	}
	$("#case_date_investigation").on( "change", function() {
		$('#date_collection_s1').val('');
		$('#date_collection_s2').val('');
		$('#date_sent_lab_s1').val('');
		$('#date_sent_lab_s2').val('');
	});
	/* $("#case_date_notification").on( "change", function() {
		toDate('case_date_onset', 'case_date_notification');
    }); */
	$("#case_date_notification").on( "change", function() {
		fromDate('case_date_notification', 'case_date_investigation');
    });
	//investigation
	/* $("#case_date_investigation").on( "change", function() {
        toDate('case_date_notification', 'case_date_investigation');
    }); */
	$("#case_date_investigation").on( "change", function() {
		fromDate('case_date_investigation', 'date_collection_s1');
    });
	$("#case_date_investigation").on( "change", function() {
		fromDate('case_date_investigation', 'date_collection_s2');
    });	  
	$("#date_collection_s1").on( "change", function() {
		fromDate('case_date_investigation','date_collection_s1');
		$('#date_sent_lab_s1').val('');
    });
	$("#date_collection_s2").on( "change", function() {
		fromDate('case_date_investigation','date_collection_s2');
		$('#date_sent_lab_s2').val('');
    });
	$("#date_collection_s1").on( "change", function() {
		fromDate('date_collection_s1','date_sent_lab_s1');
    });
	$("#date_collection_s2").on( "change", function() {
		fromDate('date_collection_s2','date_sent_lab_s2');
    });
    /* $("#date_sent_lab_s1").on( "change", function() {
        toDate('date_collection_s1', 'date_sent_lab_s1');
    }); */
	/* $("#date_sent_lab_s2").on( "change", function() {
        toDate('date_collection_s2', 'date_sent_lab_s2');
    }); */
	//date of collection and send to lab  ending there
	//function end
    <?php if(!isset($afp_Result)){ ?>
      $(document).on('change','#other_procode',function(){
         if($(this).val() == '<?php echo $_SESSION["Province"]; ?>'){
            $('.procodekp').removeClass('hide');
            $('.procodekp').val('');
            $('.otherprocode').addClass('hide');
            $('.otherprocode').val('');
            //$('#patient_address').removeAttr('readonly','readonly');
            $('#patient_address_distcode').addClass('hide');
            $('#patient_address_distcode').removeAttr('required','required');
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
            $('#patient_address_uncode').attr('disabled','disabled');

            //$('#labresult_tobesentto_district').removeAttr('required','required');
         }else if($(this).val() != '<?php echo $_SESSION["Province"]; ?>' && $(this).val() != ''){
            $('#patient_address_distcode').addClass('hide');
            $('#patient_address_distcode').removeAttr('required','required');
            $('#other_pro_district').removeClass('hide');         
            $('#other_pro_district').attr('required','required');
            $('.procodekp').addClass('hide');
            $('.otherprocode').removeClass('hide');
            $('.procodekp').val('');
            $('.otherprocode').val('');         
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
            $('#patient_address_uncode').attr('disabled','disabled');
            $('#patient_address_procode').attr('disabled','disabled');
         }
         else if( $(this).val() == ''){
            $('#patient_address_distcode').removeClass('hide');
            $('#patient_address_distcode').attr('required','required');
            $('#other_pro_district').addClass('hide');         
            $('#other_pro_district').removeAttr('required','required');
            $('.procodekp').addClass('hide');
            $('.otherprocode').addClass('hide');
            $('.procodekp').val('');
            $('.otherprocode').val('');         
         }
      });
   <?php } ?>
   <?php if(isset($afp_Result) && $afp_Result-> cross_notified == 1 && $afp_Result-> procode == $_SESSION["Province"] && (substr($afp_Result-> cross_notified_from_distcode, 0,1) == $_SESSION["Province"]) && $afp_Result-> approval_status == 'Approved'){ ?>
      $('.procodekp').removeClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').addClass('hide');
      $('.otherprocode').val('');
      //$('#patient_address').removeAttr('readonly','readonly');
      $('#distcode').removeAttr('required','required');
      $('#tcode').removeAttr('required','required');
      $('#uncode').removeAttr('required','required');
      $('#distcode').attr('disabled','disabled'); 
      $('#tcode').attr('disabled','disabled'); 
      $('#uncode').attr('disabled','disabled');
      $('#proTd1').html('');
      $('#proTd2').html('');
      $('#patient_address_distcode').addClass('hide');
      $('#patient_address_distcode').removeAttr('required','required');
      $('#patient_address_tcode').removeAttr('required','required');
      $('#patient_address_uncode').removeAttr('required','required');
      $('#patient_address_distcode').attr('disabled','disabled'); 
      $('#patient_address_tcode').attr('disabled','disabled'); 
      $('#patient_address_uncode').attr('disabled','disabled');
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
      $('#patient_address_uncode').attr('disabled','disabled');
      $('.otherProvinceAddress').removeClass('hide');
      patient_address_distcode = '<?php echo $afp_Result-> patient_address_distcode; ?>';
      patient_address_tcode = '<?php echo $afp_Result-> patient_address_tcode; ?>';
      patient_address_uncode = '<?php echo $afp_Result-> patient_address_uncode; ?>';
      $('#other_pro_distcode').val(patient_address_distcode);
      $('#other_pro_tcode').val(patient_address_tcode);
      $('#other_pro_uncode').val(patient_address_uncode);
   <?php } ?>
   <?php if(isset($afp_Result) && $afp_Result-> cross_notified == 1 && $afp_Result-> procode != $_SESSION["Province"] && (substr($afp_Result-> cross_notified_from_distcode, 0,1) != $_SESSION["Province"]) && $afp_Result-> approval_status == 'Approved' ){ ?>
      $('#patient_address_distcode').addClass('hide');
      $('#patient_address_distcode').removeAttr('required','required');
      $('#patient_address_tcode').removeAttr('required','required');
      $('#patient_address_uncode').removeAttr('required','required');
      $('#patient_address_distcode').attr('disabled','disabled'); 
      $('#patient_address_tcode').attr('disabled','disabled'); 
      $('#patient_address_uncode').attr('disabled','disabled');
      $('#other_pro_district').removeClass('hide');         
      $('#other_pro_district').attr('required','required');
      $('.procodekp').addClass('hide');
      $('.otherprocode').removeClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').val('');
      $('#distcode').removeAttr('required','required');
      $('#tcode').removeAttr('required','required');
      $('#uncode').removeAttr('required','required');
      $('#distcode').attr('disabled','disabled'); 
      $('#tcode').attr('disabled','disabled'); 
      $('#uncode').attr('disabled','disabled');
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
      $('#patient_address_uncode').attr('disabled','disabled');
      $('#patient_address_procode').attr('disabled','disabled');
      $('.otherProvinceAddress').removeClass('hide');
      patient_address_distcode = '<?php echo $afp_Result-> patient_address_distcode; ?>';
      patient_address_tcode = '<?php echo $afp_Result-> patient_address_tcode; ?>';
      patient_address_uncode = '<?php echo $afp_Result-> patient_address_uncode; ?>';
      $('#other_pro_district').val(patient_address_distcode);
      $('#other_pro_tehsil').val(patient_address_tcode);
      $('#other_pro_uc').val(patient_address_uncode);    
   <?php } ?>



   <?php if(isset($afp_Result) && $afp_Result-> cross_notified == 1 && $afp_Result-> cross_notified_from_distcode == $this -> session -> District && (substr($afp_Result-> cross_notified_from_distcode, 0,1) == $_SESSION["Province"]) && $afp_Result-> approval_status == 'Pending'){ ?>
      $('.procodekp').removeClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').addClass('hide');
      $('.otherprocode').val('');
      //$('#patient_address').removeAttr('readonly','readonly');
      $('#distcode').removeAttr('required','required');
      $('#tcode').removeAttr('required','required');
      $('#uncode').removeAttr('required','required');
      $('#distcode').attr('disabled','disabled'); 
      $('#tcode').attr('disabled','disabled'); 
      $('#uncode').attr('disabled','disabled');
      $('#proTd1').html('');
      $('#proTd2').html('');
      $('#patient_address_distcode').addClass('hide');
      $('#patient_address_distcode').removeAttr('required','required');
      $('#patient_address_tcode').removeAttr('required','required');
      $('#patient_address_uncode').removeAttr('required','required');
      $('#patient_address_distcode').attr('disabled','disabled'); 
      $('#patient_address_tcode').attr('disabled','disabled'); 
      $('#patient_address_uncode').attr('disabled','disabled');
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
      $('#patient_address_uncode').attr('disabled','disabled');
      $('.otherProvinceAddress').removeClass('hide');
      patient_address_distcode = '<?php echo $afp_Result-> patient_address_distcode; ?>';
      patient_address_tcode = '<?php echo $afp_Result-> patient_address_tcode; ?>';
      patient_address_uncode = '<?php echo $afp_Result-> patient_address_uncode; ?>';
      $('#other_pro_distcode').val(patient_address_distcode);
      $('#other_pro_tcode').val(patient_address_tcode);
      $('#other_pro_uncode').val(patient_address_uncode);
   <?php } ?>
   <?php if(isset($afp_Result) && $afp_Result-> cross_notified == 1 && $afp_Result-> cross_notified_from_distcode != $this -> session -> District && (substr($afp_Result-> cross_notified_from_distcode, 0,1) != $_SESSION["Province"]) && $afp_Result-> approval_status == 'Pending' ){ ?>
      $('#patient_address_distcode').addClass('hide');
      $('#patient_address_distcode').removeAttr('required','required');
      $('#patient_address_tcode').removeAttr('required','required');
      $('#patient_address_uncode').removeAttr('required','required');
      $('#patient_address_distcode').attr('disabled','disabled'); 
      $('#patient_address_tcode').attr('disabled','disabled'); 
      $('#patient_address_uncode').attr('disabled','disabled');
      $('#other_pro_district').removeClass('hide');         
      $('#other_pro_district').attr('required','required');
      $('.procodekp').addClass('hide');
      $('.otherprocode').removeClass('hide');
      $('.procodekp').val('');
      $('.otherprocode').val('');
      $('#distcode').removeAttr('required','required');
      $('#tcode').removeAttr('required','required');
      $('#uncode').removeAttr('required','required');
      $('#distcode').attr('disabled','disabled'); 
      $('#tcode').attr('disabled','disabled'); 
      $('#uncode').attr('disabled','disabled');
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
      $('#patient_address_uncode').attr('disabled','disabled');
      $('#patient_address_procode').attr('disabled','disabled');
      $('.otherProvinceAddress').removeClass('hide');
      patient_address_distcode = '<?php echo $afp_Result-> patient_address_distcode; ?>';
      patient_address_tcode = '<?php echo $afp_Result-> patient_address_tcode; ?>';
      patient_address_uncode = '<?php echo $afp_Result-> patient_address_uncode; ?>';
      $('#other_pro_district').val(patient_address_distcode);
      $('#other_pro_tehsil').val(patient_address_tcode);
      $('#other_pro_uc').val(patient_address_uncode);    
   <?php } ?>
   <?php if(isset($afp_Result) && $afp_Result-> cross_notified == 0){ ?>
      $('#patient_address_distcode').removeClass('hide');
      $('#patient_address_distcode').attr('required','required');
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
   //-------- Javascript for Cross Notification to other Provinces -------//
<?php if(isset($afp_Result) && $afp_Result-> cross_notified == 1 ){ ?>
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
               //$('#patient_address_distcode').html(result);
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
               //$('#patient_address_distcode').html(result);
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

       