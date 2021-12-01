<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
 	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
   <div class="panel-heading"> <?php if(isset($aefiForm_Result)){?> Update AEFI Case Investigation Form <?php }else{ ?> Add AEFI Case Investigation Form <?php } ?></div>
     <div class="panel-body">
       <form class="form-horizontal" action="<?php echo base_url(); ?>Investigation_forms/aefi_investigation_Save" method="post">
       	<?php if(isset($aefiForm_Result)){ ?>
          <input type="hidden" name="edit" id="edit" value="edit" />
          <input type="hidden" name="id" id="id" value="<?php echo $aefiForm_Result->id; ?>" />
        <?php } ?>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <tbody>
             <tr>
              <td colspan="4">
                <table>
                  <tr>
                    <td style="width: 20%;"><label>EPID Number</label></td> 
                    <td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">PAK</label></td>
                    <td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">/</label></td>
                    <td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">KPK</label></td>
                    <td style="text-align: center; width: 1%;"><label style="margin-top: 7px;">/</label></td>                    
                    <td style="text-align: center; width: 1%;"><input type="hidden" name="dcode" id="dcode" value="<?php if(isset($distCode)){ echo $distCode; } ?>" /><label class="epid_code" style="margin-top: 7px;"><?php if(isset($distCode)){ echo $distCode; } ?></label></td>
                    <td style="text-align: center; width: 1%;"><label style="margin-top: 7px;"></label></td>	
                    <td style="width: 12%;"><select name="year" class="form-control text-center year">
                      <?php if(isset($aefiForm_Result)){ ?>
                    <option value="<?php echo $aefiForm_Result -> year; ?>"><?php echo $aefiForm_Result -> year; ?></option>
                    <?php }else{ getAllYearsOptions(false); } ?>   
                    </select></td>
                  <td style="text-align: center; width: 3%;"><label>AEFI</label></td>
                  <td style="width: 4%;"><input class="form-control numberclass" name="a1" id="a1" maxlength="1" required="required" onchange="validateAefiNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($aefiNumber)){ echo $aefiNumber[0]; } ?>" type="text"></td>
                  <td style="width: 4%;"><input class="form-control numberclass" name="a2" id="a2" maxlength="1" required="required" onchange="validateAefiNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($aefiNumber)){ echo $aefiNumber[1]; } ?>" type="text"></td>
                  <td style="width: 4%;"><input class="form-control numberclass" name="a3" id="a3" maxlength="1" required="required" onchange="validateAefiNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($aefiNumber)){ echo $aefiNumber[2]; } ?>" type="text"></td>
                  <td style="width: 4%;"><input class="form-control numberclass" name="a4" id="a4" maxlength="1" required="required" onchange="validateAefiNumber();" <?php if(isset($edit)){ echo 'readonly="readonly"'; } ?> value="<?php if(isset($aefiNumber)){ echo $aefiNumber[3]; } ?>" type="text"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td><p>Date AEFI reported</p></td>
              <td><input class="dp form-control" name="date_reported" id="date_reported" value="<?php if(isset($aefiForm_Result)){ if($aefiForm_Result->date_reported!= '1969-12-31'){ echo date('d-m-Y',strtotime($aefiForm_Result->date_reported)); }else{ echo ''; } } ?>" type="text"></td>
              <td><p>Date investigation started</p></td>
              <td><input class="dp form-control" name="date_investigation_started" id="date_investigation_started" value="<?php if(isset($aefiForm_Result)){ if($aefiForm_Result->date_investigation_started!= '1969-12-31'){ echo date('d-m-Y',strtotime($aefiForm_Result->date_investigation_started)); }else{ echo ''; } } ?>" type="text"></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Demographic data of the patient</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p>Name of the child</p></td>
              <td><input class="form-control" name="child_name" id="child_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->child_name; } ?>" type="text"></td>
              <td><p>Date of Birth/Age</p></td>
              <td><input class="dp form-control" name="dob" id="dob" value="<?php if(isset($aefiForm_Result)){ if($aefiForm_Result->dob!= '1969-12-31'){ echo date('d-m-Y',strtotime($aefiForm_Result->dob)); }else{ echo ''; } } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Gender</p></td>
              <td>
                <select id="gender" name="gender" class="form-control text-center">
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->gender  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->gender  == "Male"){ echo 'selected="selected"';} } ?> value="Male">Male</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->gender  == "Female"){ echo 'selected="selected"';} } ?> value="Female">Female</option>
                  </select>
              </td>
              <td><p>Name and cast of Father</p></td>
              <td><input class="form-control" name="name_cast_father" id="name_cast_father" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->name_cast_father; } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Address House/Street No</p></td>
              <td><input class="form-control" name="address" id="address" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->address; } ?>" type="text">
              </td>
              <td><p>Village</p></td>
              <td><input class="form-control" name="village" id="village" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->village; } ?>" type="text"></td>
            </tr>
            <tr>
             <td><p>Contact No</p></td>
              <td><input class="form-control" name="contact_no" id="contact_no" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->contact_no; } ?>" type="text">
             <td><p>District</p></td> 
              <td><select id="distcode" name="distcode" class="form-control text-center">
                     <?php getDistricts(false,$this -> session -> District); ?>
                  </select>
              </td>
             </tr>
            <tr>
              <td><p>Tehsil/Tauka/Town</p></td>
              <td><select id="tcode" name="tcode" class="form-control">
                    <?php if(isset($aefiForm_Result)){ getTehsils(false,$aefiForm_Result->tcode); } ?>
                  </select>
            </td> 
            <td><p>Union Council</p></td>
			<input id="module" type="hidden" value="disease_surveillance">
              <td><select id="uncode" name="uncode" class="form-control">
                    <?php if(isset($aefiForm_Result)){ getUCs(false,$aefiForm_Result->uncode); }else{ ?>
                    <?php getUCs_options(false); } ?>
                  </select>
              </td>     
            </tr>
         </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Most Recent Immunization History</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p>Date and time of vaccine</p></td>
              <td><input class="dp form-control" name="datetime_vaccination" id="datetime_vaccination" value="<?php if(isset($aefiForm_Result)){ if($aefiForm_Result->datetime_vaccination!= '1969-12-31'){ echo date('d-m-Y',strtotime($aefiForm_Result->datetime_vaccination)); }else{ echo ''; } } ?>" type="text"></td>
              <td><p>Vaccine & dose number</p></td>
              <td><input class="form-control" name="vacc_and_dose_no" id="vacc_and_dose_no" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_and_dose_no; } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Site of administration</p></td>
              <td><input class="form-control" name="site_administration" id="site_administration" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->site_administration; } ?>" type="text"></td>
              <td><p>Vaccination center</p></td>
              <td><input class="form-control" name="vaccination_center" id="vaccination_center" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vaccination_center; } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Vaccinated by</p></td>
              <td><input class="form-control" name="vaccinated_by" id="vaccinated_by" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vaccinated_by; } ?>" type="text"></td>
              <td> </td>
              <td> </td>
            </tr>             
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Information about the vaccines and diluents administered to the patient</th>
            </tr>
          </thead>
          <tbody>
             <tr>
              <td>
                <table style="width:100%;" class="table table-bordered   table-striped table-hover    mytable2">
                  <tr>
                    <td style="text-align:center;">Vaccines</td>
                    <td style="text-align:center;">Manufacturer</td>
                    <td style="text-align:center;">Lot no./batch no</td>
                    <td style="text-align:center;">Expiry Date</td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r1_name" id="vacc_r1_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r1_name; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r1_f1" id="vacc_r1_f1" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r1_f1; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r1_f2" id="vacc_r1_f2" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r1_f2; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control dp" name="vacc_r1_f3" id="vacc_r1_f3" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r1_f3; } ?>" type="text"></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r2_name" id="vacc_r2_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r2_name; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r2_f1" id="vacc_r2_f1" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r2_f1; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r2_f2" id="vacc_r2_f2" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r2_f2; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control dp" name="vacc_r2_f3" id="vacc_r2_f3" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r2_f3; } ?>" type="text"></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r3_name" id="vacc_r3_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r3_name; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r3_f1" id="vacc_r3_f1" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r3_f1; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r3_f2" id="vacc_r3_f2" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r3_f2; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control dp" name="vacc_r3_f3" id="vacc_r3_f3" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r3_f3; } ?>" type="text"></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r4_name" id="vacc_r4_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r4_name; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r4_f1" id="vacc_r4_f1" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r4_f1; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="vacc_r4_f2" id="vacc_r4_f2" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r4_f2; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control dp" name="vacc_r4_f3" id="vacc_r4_f3" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->vacc_r4_f3; } ?>" type="text"></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;">Diluents</td>
                    <td style="text-align:center;">Manufacturer</td>
                    <td style="text-align:center;">Lot no./batch no</td>
                    <td style="text-align:center;">Expiry Date</td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><input class="form-control" name="dil_r1_name" id="dil_r1_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->dil_r1_name; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="dil_r1_f1" id="dil_r1_f1" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->dil_r1_f1; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="dil_r1_f2" id="dil_r1_f2" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->dil_r1_f2; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control dp" name="dil_r1_f3" id="dil_r1_f3" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->dil_r1_f3; } ?>" type="text"></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><input class="form-control" name="dil_r2_name" id="dil_r2_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->dil_r2_name; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="dil_r2_f1" id="dil_r2_f1" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->dil_r2_f1; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control" name="dil_r2_f2" id="dil_r2_f2" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->dil_r2_f2; } ?>" type="text"></td>
                    <td style="text-align:center;"><input class="form-control dp" name="dil_r2_f3" id="dil_r2_f3" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->dil_r2_f3; } ?>" type="text"></td> 
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
            </tr>          
          </tbody>
        </table>
        
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="3" style="text-align:center;vertical-align: middle;">Suspected vaccine which cased AEFI</th>
              <td><input class="form-control" name="suspected_vaccine" id="suspected_vaccine" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->suspected_vaccine; } ?>" type="text"></td>
            </tr>
          </thead>
          <tbody>
                          
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;vertical-align: middle;">Describe the adverse event in detail</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4"><input class="form-control" name="adv_evt_detail" id="adv_evt_detail" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->adv_evt_detail; } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>H/O present illness</p></td>
              <td colspan="3"><input class="form-control" name="ho_present_illness" id="ho_present_illness" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->ho_present_illness; } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Date of onset of AEFI</p></td>
              <td><input class="dp form-control" name="date_onset" id="date_onset" value="<?php if(isset($aefiForm_Result)){ if($aefiForm_Result->date_onset!= '1969-12-31'){ echo date('d-m-Y',strtotime($aefiForm_Result->date_onset)); }else{ echo ''; } } ?>" type="text"></td>
              <td><p>Time of onset of AEFI</p></td>
              <td><input class="form-control" name="time_onset" id="time_onset" value="<?php if(isset($aefiForm_Result)){ echo date('g:i a' ,strtotime($aefiForm_Result->time_onset)); } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Date of hospitalization</p></td>
              <td><input class="dp form-control" name="date_hospitalization" id="date_hospitalization" value="<?php if(isset($aefiForm_Result)){ if($aefiForm_Result->date_hospitalization!= '1969-12-31'){ echo date('d-m-Y',strtotime($aefiForm_Result->date_hospitalization)); }else{ echo ''; } } ?>" type="text"></td>
              <td><p>Time of hospitalization</p></td>
              <td><input class="form-control" name="time_hospitalization" id="time_hospitalization" value="<?php if(isset($aefiForm_Result)){ echo date('g:i a' ,strtotime ($aefiForm_Result->time_hospitalization)); } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Date of death</p></td>
              <td><input class="dp form-control" name="date_death" id="date_death" value="<?php if(isset($aefiForm_Result)){ if($aefiForm_Result->date_death!= '1969-12-31'){ echo date('d-m-Y',strtotime($aefiForm_Result->date_death)); }else{ echo ''; } } ?>" type="text"></td>
              <td><p>Time of death</p></td>
              <td><input class="form-control" name="time_death" id="time_death" value="<?php if(isset($aefiForm_Result)){ echo date('g:i a' ,strtotime ($aefiForm_Result->time_death)); } ?>" type="text"></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2"> 
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Examination Findings</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p>Pulse</p></td>
              <td><input class="form-control numberclass" name="pulse" id="pulse" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->pulse; } ?>" type="text" style="display: inline; width: 80%;"><span style="float: right; padding-top: 7px;">(/min)</span></td>
              <td><p>Temp</td>
              <td><input class="form-control numberclass" name="temp" id="temp" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->temp; } ?>" type="text" style="display: inline; width: 90%;"><p style="display: inline; vertical-align: top;">  o</p>F<p></p></td>
            </tr>
            <tr>
              <td><p>BP</p></td>
              <td><input class="form-control numberclass" name="bp" id="bp" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->bp; } ?>" type="text" style="display: inline; width: 80%;"><span style="float: right; padding-top: 7px;"> mm of Hg</span></td>
              <td><p>Heart Rate</p></td>
              <td><input class="form-control numberclass" name="heart_rate" id="heart_rate" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->heart_rate; } ?>" type="text" style="display: inline; width: 90%;"><span style="float: right; padding-top: 7px;"> /min</span></td>
            </tr>
            <tr>
              <td><p>Resp Rate</p></td>
              <td><input class="form-control numberclass" name="resp_rate" id="resp_rate" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->resp_rate; } ?>" type="text" style="display: inline; width: 90%;"><span style="float: right; padding-top: 7px;"> /min</span></td>
              <td><p>Lungs (wheeze, creps, ronchi)</p></td>
              <td><input class="form-control" name="lungs" id="lungs" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->lungs; } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Skin change</p></td>
              <td><input class="form-control" name="skin_change" id="skin_change" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->skin_change; } ?>" type="text"></td>
              <td><p>Size of skin lesion</p></td>
              <td><input class="form-control numberclass" name="size_skin_lesion" id="size_skin_lesion" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->size_skin_lesion; } ?>" type="text" style="display: inline; width: 90%;"><span style="float: right; padding-top: 7px;"> cm</span></td>
            </tr>
            <tr>
              <td><p>Cyanosis</p></td>
              <td><input class="form-control" name="cyanosis" id="cyanosis" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->cyanosis; } ?>" type="text"></td>
              <td><p>Pupil (reaction to light)</p></td>
              <td><input class="form-control" name="pupil" id="pupil" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->pupil; } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Kernig's sign</p></td>
              <td><input class="form-control" name="kernigs_sign" id="kernigs_sign" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->kernigs_sign; } ?>" type="text"></td>
              <td><p>Neck stiffness</p></td>
              <td><input class="form-control" name="neck_stiffness" id="neck_stiffness" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->neck_stiffness; } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Level of Consciousness</p></td>
              <td><input class="form-control" name="level_consciousness" id="level_consciousness"  value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->level_consciousness; } ?>" type="text"></td>
              <td><p>Lymph Node</p></td>
              <td><input class="form-control" name="lymph_node" id="lymph_node" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->lymph_node; } ?>" type="text"></td>
            </tr>
            <tr>
              <td><p>Jerks</p></td>
              <td><input class="form-control" name="jerks" id="jerks" type="text"></td>
              <td><p>Cranial nerve abnormality</p></td>
              <td><input class="form-control" name="cranial_nerve_abnormality" id="cranial_nerve_abnormality" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->cranial_nerve_abnormality; } ?>" type="text"></td>
            </tr>
            <tr>
              <td colspan="1"><label>Other Abnormal Signs (if any)</label></td>
              <td colspan="3"><input class="form-control" name="other_abnormal_signs" id="other_abnormal_signs" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->other_abnormal_signs; } ?>" type="text"></td>
            </tr>
            <tr>
              <td colspan="1"><label>Treatment</label></td>
              <td colspan="3"><input class="form-control" name="treatment" id="treatment" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->treatment; } ?>" type="text"></td>
            </tr>
            <tr>
              <td colspan="1"><label>Provisional Diagnosis</label></td>
              <td colspan="3"><input class="form-control" name="provisional_diagnosis" id="provisional_diagnosis" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->provisional_diagnosis; } ?>" type="text"></td>
            </tr>
            <tr>
              <td colspan="1"><label>Outcome</label></td>
              <td colspan="3"><input class="form-control" name="outcome" id="outcome" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->outcome; } ?>" type="text"></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Additional information about the patient: (write yes or no, if yes please specify)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p>Past H/O similar events</p></td>
              <td><select id="pse_dd" name="pse_dd" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->past_similar_event  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->past_similar_event  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="past_similar_event" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->past_similar_event; } ?>" id="past_similar_event" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Reaction after previous vaccination</p></td>
              <td><select id="rpv_dd" name="rpv_dd" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->reaction_previous_vaccination  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->reaction_previous_vaccination  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="reaction_previous_vaccination" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->reaction_previous_vaccination; } ?>" id="reaction_previous_vaccination" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>H/O allergy</p></td>
              <td><select id="hoa_dd" name="hoa_dd" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->no_allergy  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->no_allergy  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="no_allergy" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->no_allergy; } ?>" id="no_allergy" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Pre-existing illness/disorder</p></td>
              <td><select id="peid_dd" name="peid_dd" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->pre_existing  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->pre_existing  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="pre_existing" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->pre_existing; } ?>" id="pre_existing" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Current medication (for other than AEFI)</p></td>
              <td><select id="cm_dd" name="cm_dd" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->current_medication  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->current_medication  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="current_medication" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->current_medication; } ?>" id="current_medication" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>H/O hospitalization in last 30 days with cause</p></td>
              <td><select id="hohil30days_dd" name="hohil30days_dd" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->ho_hosp_cause  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->ho_hosp_cause  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="ho_hosp_cause" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->ho_hosp_cause; } ?>" id="ho_hosp_cause" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Recent H/O trauma with date, time, site and mode</p></td>
              <td><select id="rhotwdt_dd" name="rhotwdt_dd" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->recent_ho_trauma  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->recent_ho_trauma  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="recent_ho_trauma" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->recent_ho_trauma; } ?>" id="recent_ho_trauma" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Family history of any disease or allergy</p></td>
              <td><select id="fhada_dd" name="fhada_dd" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->family_history  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->family_history  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="family_history" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->family_history; } ?>" id="family_history" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td colspan="4"><label>Community investigation</label></td>
            </tr>
            <tr>
              <td><p>No. of cases immunized with suspected vaccine in same session</p></td>
              <td></td>
              <td><input class="form-control" name="no_cases_immunized" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->no_cases_immunized; } ?>" id="no_cases_immunized" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>No. of cases of same adverse events found in immunized children/women</p></td>
              <td></td>
              <td><input class="form-control" name="no_cases_sae_immunized" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->no_cases_sae_immunized; } ?>" id="no_cases_sae_immunized" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>No. of cases of same adverse events found in non-immunized population</p></td>
              <td></td>
              <td><input class="form-control" name="no_cases_sae_non_immunized" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->no_cases_sae_non_immunized; } ?>" id="no_cases_sae_non_immunized" type="text" placeholder="specify"></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">EPI Management Practice: (fill up this section by asking and observing practice) write yes or no where applicable, if yes please specify)</th>
            </tr>
          </thead>
          <tbody>
            <tr><td colspan="4">EPI store</td></tr>
            <tr>
              <td><p style="display: inline-block;">Temp inside ILR (<p style="display: inline; vertical-align: top;">  o</p>C)</td>
              <td><select id="store_dd1" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_temp_inside_ilr  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_temp_inside_ilr  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="store_temp_inside_ilr" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->store_temp_inside_ilr; } ?>" id="store_temp_inside_ilr" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p style="display: inline-block;">Temp of freezer (<p style="display: inline; vertical-align: top;">  o</p>C)</td>
              <td><select id="store_dd2" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_temp_freezer  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_temp_freezer  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="store_temp_freezer" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->store_temp_freezer; } ?>" id="store_temp_freezer" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Correct procedure of storing vaccines, diluents and syringes followed</p></td>
              <td><select id="store_dd3" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_correct_procedure  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_correct_procedure  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="store_correct_procedure" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->store_correct_procedure; } ?>" id="store_correct_procedure" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Any other object (other than EPI vaccines and diluents) in the ILR or freezer</p></td>
              <td><select id="store_dd4" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_other_object_in_ilr  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_other_object_in_ilr  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="store_other_object_in_ilr" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->store_other_object_in_ilr; } ?>" id="store_other_object_in_ilr" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Partially used reconstituted vaccines in the ILR</p></td>
              <td><select id="store_dd5" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_reconstituted_vaccines  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_reconstituted_vaccines  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="store_reconstituted_vaccines" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->store_reconstituted_vaccines; } ?>" id="store_reconstituted_vaccines" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Unusable vaccines (expired, no label, VVM stage 3&4, Frozen) in the ILR</p></td>
              <td><select id="store_dd6" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_unusable_vaccine  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_unusable_vaccine  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="store_unusable_vaccine" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->store_unusable_vaccine; } ?>" id="store_unusable_vaccine" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Unusable diluents (expired, manufacturer not matched, cracked, dirty ampoule) in the store</p></td>
              <td><select id="store_dd7" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_unusable_diluents  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->store_unusable_diluents  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="store_unusable_diluents" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->store_unusable_diluents; } ?>" id="store_unusable_diluents" type="text" placeholder="specify"></td>
            </tr>
            <tr><td colspan="4"><label>Transportation</label></td></tr>
            <tr>
              <td><p>Type of vaccine carrier used</p></td>
              <td><select id="trans_dd1" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_type_vacc_carrier_used  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_type_vacc_carrier_used  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="trans_type_vacc_carrier_used" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->trans_type_vacc_carrier_used; } ?>" id="trans_type_vacc_carrier_used" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Vaccine carrier packed properly</p></td>
              <td><select id="trans_dd2" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_vaccine_carrier_packed  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_vaccine_carrier_packed  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="trans_vaccine_carrier_packed" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->trans_vaccine_carrier_packed; } ?>" id="trans_vaccine_carrier_packed" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Vaccine carrier sent to the EPI site on the same day of vaccination</p></td>
              <td><select id="trans_dd3" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_vaccine_carrier_sent  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_vaccine_carrier_sent  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="trans_vaccine_carrier_sent" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->trans_vaccine_carrier_sent; } ?>" id="trans_vaccine_carrier_sent" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Vaccine carrier returned from the EPI site on the same day of vaccination</p></td>
              <td><select id="trans_dd4" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_vacc_carrier_from_epi  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_vacc_carrier_from_epi  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="trans_vacc_carrier_from_epi" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->trans_vacc_carrier_from_epi; } ?>" id="trans_vacc_carrier_from_epi" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Conditioned ice-pack used</p></td>
              <td><select id="trans_dd5" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_conditioned_icepack  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->trans_conditioned_icepack  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="trans_conditioned_icepack" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->trans_conditioned_icepack; } ?>" id="trans_conditioned_icepack" type="text" placeholder="specify"></td>
            </tr>
            <tr><td colspan="4"><label>Reconstitution</label></td></tr>
            <tr>
              <td><p>Correct procedure followed</p></td>
              <td><select id="rec_dd1" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->rec_procedure_followed  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->rec_procedure_followed  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="rec_procedure_followed" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->rec_procedure_followed; } ?>" id="rec_procedure_followed" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Correct amount of diluent used</p></td>
              <td><select id="rec_dd2" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->rec_correct_amount_diluent  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->rec_correct_amount_diluent  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="rec_correct_amount_diluent" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->rec_correct_amount_diluent; } ?>" id="rec_correct_amount_diluent" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Used separate syringe for each vial</p></td>
              <td><select id="rec_dd4" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->rec_used_separate_syringe  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->rec_used_separate_syringe  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="rec_used_separate_syringe" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->rec_used_separate_syringe; } ?>" id="rec_used_separate_syringe" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Matching diluent used</p></td>
              <td><select id="rec_dd4" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->rec_matching_diluent_used  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->rec_matching_diluent_used  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="rec_matching_diluent_used" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->rec_matching_diluent_used; } ?>" id="rec_matching_diluent_used" type="text" placeholder="specify"></td>
            </tr>
            <tr><td colspan="4"><label>Injection technique</label></td></tr>
            <tr>
              <td><p>Correct dose and route</p></td>
              <td><select id="inj_dd1" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_correct_dose_rate  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_correct_dose_rate  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="inj_correct_dose_rate" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->inj_correct_dose_rate; } ?>" id="inj_correct_dose_rate" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Non-touch technique followed</p></td>
              <td><select id="inj_dd2" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_non_touch_techniques  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_non_touch_techniques  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="inj_non_touch_techniques" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->inj_non_touch_techniques; } ?>" id="inj_non_touch_techniques" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Vial shaked before each injection</p></td>
              <td><select id="inj_dd3" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_vial_shaked_before_inj  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_vial_shaked_before_inj  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="inj_vial_shaked_before_inj" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->inj_vial_shaked_before_inj; } ?>" id="inj_vial_shaked_before_inj" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Contraindication assessed</p></td>
              <td><select id="inj_dd4" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_contraindication_assessed  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_contraindication_assessed  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="inj_contraindication_assessed" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->inj_contraindication_assessed; } ?>" id="inj_contraindication_assessed" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>How many AEFI reported from vaccination sites of the same worker in last 30 days?</p></td>
              <td><select id="inj_dd5" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_aefi_reported_last30_days  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_aefi_reported_last30_days  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="inj_aefi_reported_last30_days" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->inj_aefi_reported_last30_days; } ?>" id="inj_aefi_reported_last30_days" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><p>Training on EPI received by the vaccinator (specify the last training including date)</p></td>
              <td><select id="inj_dd6" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_training_by_vaccinator  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->inj_training_by_vaccinator  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="inj_training_by_vaccinator" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->inj_training_by_vaccinator; } ?>" id="inj_training_by_vaccinator" type="text" placeholder="specify"></td>
            </tr>
            <tr>
              <td><label>Laboratory investigation(s) conducted? (if yes, mention the tests)</label></td>
              <td><select id="lab_inv_conducted" class="form-control text-center">
                    <option value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->lab_inv_tests  != ""){ echo 'selected="selected"';} } ?> value="Yes">Yes</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->lab_inv_tests  == ""){ echo 'selected="selected"';} } ?> value="No">No</option>
                  </select></td>
              <td><input class="form-control" name="lab_inv_tests" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->lab_inv_tests; } ?>" id="lab_inv_tests" type="text" placeholder="mention the tests"></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Assessment</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <table style="width:100%;" class="table table-bordered   table-striped table-hover    mytable2">
                  <tr><td colspan="5"><p>Conclusion about cause of AEFI (tick categories, rank if more than one cause)</p></td></tr>
                  <tr>
                    <td style="text-align:center;">Programme error</td>
                    <td style="text-align:center;">Vaccine Reaction</td>
                    <td style="text-align:center;">Coincidental</td>
                    <td style="text-align:center;">Injection Reaction</td>
                    <td style="text-align:center;">Unknown</td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="pe_f1"<?php if(isset($aefiForm_Result)){ if($aefiForm_Result
              ->pe_f1  == "1"){ echo 'checked="checked"';} } ?> id="pe_f1" value="1" > Non-sterile injection</td>
                    <td><input name="vcr_f1" id="vcr_f1" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->vcr_f1  == "1"){ echo 'checked="checked"';} } ?> value="1" type="checkbox"> Known vaccine reaction at expected rate</td>
                    <td style="text-align:center;"><input name="coincidental" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->coincidental  == "1"){ echo 'checked="checked"';} } ?> id="coincidental" value="1" type="checkbox"></td>
                    <td style="text-align:center;"><input name="inj_reaction" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->inj_reaction  == "1"){ echo 'checked="checked"';} } ?> id="inj_reaction" value="1" type="checkbox"></td>
                    <td style="text-align:center;"><input name="unknown" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->unknown  == "1"){ echo 'checked="checked"';} } ?> id="unknown" value="1" type="checkbox"></td>
                  </tr>
                  <tr>
                    <td><input name="pe_f2" id="pe_f2" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->pe_f2  == "1"){ echo 'checked="checked"';} } ?> value="1" type="checkbox"> Vaccine prepared incorrectly</td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td><input name="pe_f3" id="pe_f3" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->pe_f3  == "1"){ echo 'checked="checked"';} } ?> value="1" type="checkbox"> Faulty administration technique/site</td>
                    <td><input name="vcr_f2" id="vcr_f2" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->vcr_f2  == "1"){ echo 'checked="checked"';} } ?> value="" type="checkbox"> Vaccine lot problem</td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td><input name="pe_f4" id="pe_f4" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->pe_f4  == "1"){ echo 'checked="checked"';} } ?> value="1" type="checkbox"> Faulty vaccine transportation</td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td><input name="pe_f5" id="pe_f5" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->pe_f5  == "1"){ echo 'checked="checked"';} } ?> value="1" type="checkbox"> Faulty vaccine storage</td>
                    <td><input name="vcr_f3" id="vcr_f3" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->vcr_f3  == "1"){ echo 'checked="checked"';} } ?> value="1" type="checkbox"> others</td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td><input name="pe_f6" id="pe_f6" <?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->pe_f6  == "1"){ echo 'checked="checked"';} } ?> value="1" type="checkbox"> Other</td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td><p>Confidence about conclusion on main cause of AEFI</p></td>
                    
                    <td style="text-align:center;"><select id="confidence_conclusion" name="confidence_conclusion"  class="form-control text-center">
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->confidence_conclusion  == "0"){ echo 'selected="selected"';} } ?> value="0">-- Select --</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->confidence_conclusion  == "Certain"){ echo 'selected="selected"';} } ?> value="Certain">Certain</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->confidence_conclusion  == "Probable"){ echo 'selected="selected"';} } ?> value="Probable">Probable</option>
                    <option <?php if(isset($aefiForm_Result)){ if($aefiForm_Result->confidence_conclusion  == "Possible"){ echo 'selected="selected"';} } ?> value="Possible">Possible</option>
                    </select></td>
                    <td style="text-align:center;" colspan="3"></td>
                  </tr>
                  <tr>
                    <td><p>Reason(s) for conclusion</p></td>
                    <td style="text-align:center;" colspan="4"><input class="form-control" name="conclusion_reason" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->conclusion_reason; } ?>" id="conclusion_reason" type="text"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Corrective Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="text-align:center;" colspan="4"><input class="form-control" name="recommendation" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->recommendation; } ?>" id="recommendation" type="text" placeholder="Recommendations"></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Additional Notes</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="text-align:center;" colspan="4"><input class="form-control" name="additional_notes" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->additional_notes; } ?>" id="additional_notes" type="text" placeholder="Additional Notes"></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="5" style="text-align:center;">Investigation Team Details</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p>1</p></td>
              <td><p>Name</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r1_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r1_name; } ?>" id="itd_r1_name" type="text"></td>
              <td><p>Designation</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r1_desg" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r1_desg; } ?>" id="itd_r1_desg" type="text"></td>
            </tr>
            <tr>
              <td><p>2</p></td>
              <td><p>Name</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r2_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r2_name; } ?>" id="itd_r2_name" type="text"></td>
              <td><p>Designation</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r2_desg" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r2_desg; } ?>" id="itd_r2_desg" type="text"></td>
            </tr>
            <tr>
              <td><p>3</p></td>
              <td><p>Name</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r3_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r3_name; } ?>" id="itd_r3_name" type="text"></td>
              <td><p>Designation</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r3_desg" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r3_desg; } ?>" id="itd_r3_desg" type="text"></td>
            </tr>
            <tr>
              <td><p>4</p></td>
              <td><p>Name</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r4_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r4_name; } ?>" id="itd_r4_name" type="text"></td>
              <td><p>Designation</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r4_desg" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r4_desg; } ?>" id="itd_r4_desg" type="text"></td>
            </tr>
            <tr>
              <td><p>5</p></td>
              <td><p>Name</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r5_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r5_name; } ?>" id="itd_r5_name" type="text"></td>
              <td><p>Designation</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r5_desg" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r5_desg; } ?>" id="itd_r5_desg" type="text"></td>
            </tr>
            <tr>
              <td><p>6</p></td>
              <td><p>Name</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r6_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r6_name; } ?>" id="itd_r6_name" type="text"></td>
              <td><p>Designation</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r6_desg" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r6_desg; } ?>" id="itd_r6_desg" type="text"></td>
            </tr>
            <tr>
              <td><p>7</p></td>
              <td><p>Name</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r7_name" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r7_name; } ?>" id="itd_r7_name" type="text"></td>
              <td><p>Designation</p></td>
              <td style="text-align:center;"><input class="form-control" name="itd_r7_desg" value="<?php if(isset($aefiForm_Result)){ echo $aefiForm_Result->itd_r7_desg; } ?>" id="itd_r7_desg" type="text"></td>
            </tr>
            <tr>
              <td><p>Date Investigation Completed</p></td>
              <td style="text-align:center;"><input class="dp form-control" name="date_investigation_completed" value="<?php if(isset($aefiForm_Result
              )){ if($aefiForm_Result
              ->date_investigation_completed!= '1969-12-31'){ echo date('d-m-Y',strtotime($aefiForm_Result
              ->date_investigation_completed)); }else{ echo ''; } } ?>" id="date_investigation_completed" type="text"></td>
              <td colspan="3"> </td>
               
            </tr>
          </tbody>
        </table>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save </button>
                 <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" name="is_temp_saved" value="0" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit </button>
              <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset">
                <i class="fa fa-repeat"></i> Reset</button>
             
              <a href="<?php echo base_url(); ?>AEFI-CIF/List" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>        
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->
<script type="text/javascript">
$(document).ready(function(){
	<?php if(!isset($aefiForm_Result)){ ?>
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
	<?php } ?>
});
function validateAefiNumber(){
	var aefiNumber = "PAK/KPK/"+$('#dcode').val()+"/"+$('#year').val()+"/AEFI/"+$('#a1').val()+$('#a2').val()+$('#a3').val()+$('#a4').val();
	var epid_code =$('.epid_code').text();
	var year = $('.year').val();
		$.ajax({ 
			type: 'POST',
			//data: "aefiNumber="+aefiNumber,
			data:{aefiNumber:aefiNumber, epid_code:epid_code},
			url: '<?php echo base_url();?>Ajax_calls/validateAefiNumber',
			success: function(data){
				if(data=="Error"){
					document.getElementById("a1").style.borderColor = "red";
					document.getElementById("a2").style.borderColor = "red";
					document.getElementById("a3").style.borderColor = "red";
					document.getElementById("a4").style.borderColor = "red";
					alert("AEFI Number Already Exists!");
						$.ajax({ 
						type: 'POST',
						data:{epid_code:epid_code, year:year},
						//data: "year="+$('#year').val(),
						url: '<?php echo base_url();?>Ajax_calls/getAefiNumber',
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
				if ($('#a4').val()==0 && $('#a3').val()==0 && $('#a2').val()==0 && $('#a1').val()==0) {
					document.getElementById("a1").style.borderColor = "red";
					document.getElementById("a2").style.borderColor = "red";
					document.getElementById("a3").style.borderColor = "red";
					document.getElementById("a4").style.borderColor = "red";
					alert("AEFI Number Should Not be Zero!");
						$.ajax({ 
						type: 'POST',
						data:{epid_code:epid_code, year:year},
						//data: "year="+$('#year').val(),
						url: '<?php echo base_url();?>Ajax_calls/getAefiNumber',
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
						data:{epid_code:epid_code, year:year},
						//data: "year="+$('#year').val(),
						url: '<?php echo base_url();?>Ajax_calls/getAefiNumber',
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

$('.year').on('change', function() {
	var epid_code =$('.epid_code').text();
	var year = $('.year').val(); 
		$.ajax({ 
			type: 'POST',
			//data: "fmonth="+fmonth,
			data:{epid_code:epid_code, year:year},
			url: '<?php echo base_url();?>Ajax_calls/getAefiNumber',
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
</script>