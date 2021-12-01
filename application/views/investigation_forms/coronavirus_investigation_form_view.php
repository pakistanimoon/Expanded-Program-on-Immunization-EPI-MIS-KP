<?php //print_r($a);exit(); ?> 
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
 <?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-danger text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
   <div class="panel-heading"> Coronavirus Investigation Form View</div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" onsubmit="return confirm('Do you really want to Approve this cross notified case?')" action="<?php echo base_url(); ?>Coronavirus_investigation/coronavirusInvestigation_Approve">
     <input type="hidden" name="id" value="<?php echo $a->id; ?>">
     <input type="hidden" name="cross_case_id" value="<?php echo $a->cross_case_id; ?>" />
        <table class="table table-bordered table-striped table-hover mytable2 mytable3">
            <thead>
                <tr>
                    <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Interview Detail</th>
                </tr>
            </thead>
            <tbody>                                                 
                <tr>
                    <td><p>Interview Date</td>
                    <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> interviewer_date));} ?></td>
                    <td><p>PoE</p></td>
                    <td><?php if(isset($a)){ echo $a -> poe;} ?></td>
                </tr>
                <tr>
                    <td><p>Interviewer Name</p></td>
                    <td><?php if(isset($a)){ echo $a -> interviewer_name;} ?></td>
                    <td><p>Designation</p></td>
                    <td><?php if(isset($a)){ echo $a -> interviewer_designation;} ?></td>                    
                </tr>
                <tr>
                    <td><p>Contact Number</p></td>
                    <td><?php if(isset($a)){ echo $a -> interviewer_contact;} ?></p></td>                   
                </tr>                           
            </tbody>
        </table>
     <?php if(isset($a->rb_distcode) && $a->rb_distcode>0){ ?>
     <table id="rb_info" class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
      <thead>
        <tr>
          <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Case Referring Facility Information</th>
        </tr>
      </thead>
      <tbody>           
        <tr>
          <td><p>Province / Area</p></td>
          <td>
            <p> <?php
            $procode = substr($a->rb_distcode, 0,1);
            echo get_Province_Name($procode);
            
          ?><p>
                 
            </td>
          <td><p>District</p></td>
          <td>
            <p><?php 
                  if(isset($a)){ echo CrossProvince_DistrictName($a -> rb_distcode);} ?></p>
          </td>            
        </tr>
        <tr>
          <td><p>Tehsil / City</p></td>
          <td>
            <p><?php if(isset($a)){ echo CrossProvince_TehsilName($a -> rb_tcode);} ?></p>
          </td>
          <td><p>Union Council</p></td>
          <td>
            <p><?php if(isset($a)){ echo CrossProvince_UCName($a -> rb_uncode);} ?></p>
          </td>
        </tr>
        <tr>
          <td><p>Name of Reporting Health Facility</p></td>
          <td>
            <p><?php if(isset($a)){ echo CrossProvince_FacilityName($a -> rb_facode);} ?></p>
          </td>
          <td><p>Address of Health Facility</p></td>
          <td>
            <p><?php if(isset($a)){ echo $a -> rb_faddress;} ?></p>
          </td>
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
      <?php if($a->cross_notified != 1 && $a->distcode == $this -> session -> District){ ?>
         <?php if($a->distcode != ''){ ?>
      <tr>
        <td><p>Province/Area</p></td>
              <td><?php if(isset($a)){ echo  $this -> session -> provincename; }  ?></td>
              <td><p>District</p></td>
              <td><?php if(isset($a)){ echo CrossProvince_DistrictName($a -> distcode);} ?></td>
            </tr>
            <tr>
              <td><p>Tehsil/City</p></td>
              <td><?php if(isset($a)){ echo CrossProvince_TehsilName($a -> tcode);} ?></td>
              <td><p>Union Council</p></td>
              <td><?php if(isset($a)){ echo CrossProvince_UCName($a -> uncode);} ?></td> 
            </tr>
           <?php } } ?> 
      <?php if($a->facode != ''){ ?>
       <tr>
              <td><p>Name of Reporting Health Facility</p></td>
              <td><?php if(isset($a)){ echo CrossProvince_FacilityName($a -> facode);} ?></td>
              <td><p>Address of Health Facility</p></td>
              <td> <?php if(isset($a)){ echo $a -> faddress;} ?></td>
            </tr>
      <?php }else if($a->facode == '' && $a->cross_notified==1 && $a->distcode == $this -> session -> District){ ?>
         
         <tr>
            <td><p>Tehsil/City <span style="color:red;">*</span></p></td>
            <td>
               <?php //substr($a -> rb_distcode,0,1);
                  //$ttcode = $a-> rb_distcode;
                  $ppcode = substr($a-> rb_distcode,0,1);
                  //echo $ppcode;exit();
               ?>
               <input type="hidden" name="procode" value="<?php echo $ppcode; ?>">
        <!--parameter for sync by usama sher-->
        <input type="hidden" name="distcode" value="<?php if(isset($a)){ echo $a -> distcode;} ?>">
        <input type="hidden" name="year" value="<?php if(isset($a)){ echo $a -> year;} ?>">
        <input type="hidden" name="week" value="<?php if(isset($a)){ echo $a -> week;} ?>">
        <input type="hidden" name="gender" value="<?php if(isset($a)){ echo $a -> gender;} ?>">
        <input type="hidden" name="case_type" value="<?php if(isset($a)){ echo $a -> case_type;} ?>">
        <input type="hidden" value="<?php //if(isset($a)){ echo $a -> doses_received;} ?>">
        <!--end-->
        <select name="tcode" id="tcode" required="required" class="form-control">
                  <?php echo getTehsils_options(false,$a-> patient_address_tcode,$a-> patient_address_distcode); ?>
               </select>
            </td>
            <td><p>Union Council <span style="color:red;">*</span></p></td>
            <td>
               <select name="uncode" id="uncode" required="required" class="form-control">
                  <?php echo getUCs(false,$a-> patient_address_uncode,$a-> patient_address_tcode); ?>
               </select>   
            </td>
         </tr>   
         <tr>            
            <td><p>Name of Reporting Health Facility <span style="color:red;">*</span></p></td>
            <td>
               <select name="facode" id="facode" required="required" class="form-control">
               <?php echo getFacilities_options(false,'',$a -> uncode); ?>
               </select>
            </td>
            <td><p style="color:#008d4c;">Select Health Facility and approve Below</p></td>
            <td></td>
         </tr>
      <?php } ?>
            <tr>
      <td><p>Year</p></td>
              <td><?php if(isset($a)){ echo $a -> year;} ?></td>
              <td><p>EPI Week No</p></td>
              <td><?php if(isset($a)){ echo $a -> week;} ?></td>
      </tr>
      <tr>
                <td><p>Date From</p></td>
                <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> datefrom));} ?></td>
                <td><p>Date To</p></td>
                <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> dateto));} ?></td>
      </tr>
            <tr>
        <!-- <td><p>Case Reported</p></td>
              <td><?php //echo isset($a)?(($a->case_reported=="0")?'No':'Yes'):''; ?></td> -->  
              <td><p>Date Patient Visited Hospital</p></td>
              <td><?php if(isset($a) && $a -> pvh_date != NULL ){ echo date('d-m-Y',strtotime($a -> pvh_date));} ?></td>
              <td><label>Type of Case</label></td>
              <td><?php if(isset($a) && $a -> case_type != ""){ echo get_CaseType_Name($a -> case_type);} ?></td>
            </tr>
            <tr>
              <td colspan="4">
                <table>
                  <tbody>
                     <tr>
                        <?php if($a->case_epi_no != ''){ ?>
                           <td style="width: 25%;"><label style="margin-top: 7px;">EPID Number</label></td>
                           <td style="text-align: right; width: 10%;"><label style="padding-top: 5px;"><?php if(isset($a)){ echo $a->case_epi_no; } ?></label></td>  
                        <?php }else if($a->case_epi_no == '' && $a->case_type != 'Covid' && $a->fweek < '2018-11'){ ?>
                           <td><label></label></td>
                        <?php }else if($a->case_epi_no == '' && $a->distcode == $this -> session -> District && $a->cross_notified_from_distcode != ''){ ?>
                           <td style="width: 25%;"><label style="margin-top: 7px;">EPID Number</label>(Suggested)</td>
                           <td style="text-align: right; width: 10%;">
                              <input type="hidden" name="case_epi_no" class="form-control" value="<?php echo getEpid_no_coronavirusInvestigation(true,$a->year,$a->case_type); ?>" />
                              <input type="hidden" name="case_number" class="form-control" value="<?php echo getEpid_no_coronavirusInvestigation(true,$a->year,$a->case_type,'Yes'); ?>"  />
                              <label style="padding-top: 5px;"><?php echo getEpid_no_coronavirusInvestigation(true,$a->year,$a->case_type); ?></label>
                           </td>  
                        <?php } ?>  
                     </tr>
                  </tbody>
                </table>
               </td>
            </tr>
            <tr>
              <td><p>Patient's Name</p></td>
              <td><?php if(isset($a)){ echo $a -> name;} ?></td>
              <td><p>Gender</p></td>
              <td><?php echo isset($a)?(($a-> gender=="0")?'Female':''):'';echo isset($a)?(($a-> gender=="1")?'Male':''):''; ?></td>
            </tr>
            <tr>
              <td><p>Father's Name</p></td>
              <td><?php if(isset($a)){ echo $a -> fathername;} ?></td>
            </tr>
            <tr>
              <td><p>Age in Years</p></td>
              <td><?php if(isset($a)){ echo $a -> age_in_year;} ?></td>
              <td><p>Occupation</p></td>
              <td><?php if(isset($a)){ echo $a -> occupation;} ?></td>
            <tr>
              <td><p>Nationality</p></td>
              <td><?php if(isset($a)){ echo $a -> nationality;} ?></td>
              <td><p>CNIC #</p></td>
              <td><?php if(isset($a)){ echo $a -> cnic;} ?></td>
            </tr>
            <tr>
              <td><p>Mobile Number</p></td>
              <td><?php if(isset($a)){ echo $a -> mobile;} ?></td>
              <td><p>Telephone Number</p></td>
              <td><?php if(isset($a)){ echo $a -> telephone;} ?></td>
            </tr>
            </tbody>
          </table>
          <table class="table table-bordered table-striped table-hover mytable2 mytable3">
           <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Address of Patient in Pakistan</th>
            </tr>
         </thead>
         <tbody> 
          <?php if(isset($a) && $a->procode == $_SESSION["Province"]) { ?>            
        <tr>
           <td><p>Province / Area</p></td>
               <td><?php if(isset($a)){ echo $this -> session -> provincename; } ?></td>
               <td><p>District</p></td>
               <td><?php if(isset($a) && ($a -> patient_address_distcode != NULL)){ echo CrossProvince_DistrictName($a -> patient_address_distcode);} ?></td>
            </tr>
            <tr>
               <td><p>Tehsil / Taluka / City</p></td>
               <td><?php if(isset($a) && ($a -> patient_address_tcode != NULL)){ echo get_Tehsil_Name($a -> patient_address_tcode);} ?></td>
               <td><p>Union Council</p></td>
               <td><?php if(isset($a) && ($a -> patient_address_uncode != NULL)){ echo get_UC_Name($a -> patient_address_uncode);} ?></td>
            </tr>
         <?php } else { ?>
            <tr>
               <td><p>Province</p></td>
               <td>              
                  <p><?php if(isset($a) && ($a -> procode != NULL)) {echo get_Province_Name($a-> procode);} ?></p>              
               </td>
               <td><p>District</p></td>
               <td>              
                  <p>
                  <?php 
                     if(isset($a) && ($a -> patient_address_distcode != NULL) && strlen($a -> patient_address_distcode) == 3)
                     { 
                        echo CrossProvince_DistrictName($a -> patient_address_distcode);
                     }
                     else{
                        echo "";
                     } 
                  ?> 
                  </p>              
               </td>
            </tr>
            <tr>
               <td><p>Tehsil</p></td>
               <td>              
                  <p>
                     <?php 
                        if(isset($a) && ($a -> patient_address_tcode != NULL) && substr($a -> patient_address_tcode,0,3) == $a -> patient_address_distcode) 
                        {
                           echo CrossProvince_TehsilName($a -> patient_address_tcode);
                        }
                        else{
                           echo "";  
                        }
                     ?>                        
                  </p>              
               </td>
               <td><p>Union Council</p></td>
               <td>              
                  <p>
                     <?php 
                        if(isset($a) && ($a -> patient_address_uncode != NULL) && substr($a -> patient_address_uncode,0,3) == $a -> patient_address_distcode) 
                        {
                           echo CrossProvince_UCName($a -> patient_address_uncode);
                        }
                        else{
                           echo "";  
                        } 
                     ?>                        
                  </p>              
               </td>
            </tr>
         <?php } ?>    
            <tr>
               <td><p>Village / Street / Mahalla</p></td>
               <td colspan="3"><?php if(isset($a)){ echo $a -> patient_address;} ?></td>
            </tr>
      </tbody>
    </table>
    <table class="table table-bordered table-striped table-hover mytable2 mytable3">
           <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Travel History</th>
            </tr>
            </thead>
            <tbody>            
            <tr>          
                <td><p>Has Travel history</p></td>           
                <td>
                    <?php if(isset($a) && $a->have_travel_history == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>          
                <td><p>Has Travelled within country</p></td>           
                <td>
                    <?php if(isset($a) && $a->have_travel_within_country == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <?php if(isset($a) && $a->have_travel_within_country == "1") { ?>
                <?php if(isset($b) && $b->from_procode == $_SESSION["Province"]) { ?>
                    <tr>
                        <td><p>Provice</p></td>
                        <td>              
                            <?php if(isset($b) && ($b -> from_procode != NULL)) {echo get_Province_Name($b -> from_procode); } ?>             
                        </td>
                        <td><p>District</p></td>
                        <td>              
                            <?php if(isset($b) && ($b -> from_distcode != NULL)) {echo get_District_Name($b -> from_distcode); } ?>              
                        </td>
                    </tr>
                    <tr>
                       <td><p>Tehsil</p></td>
                       <td>              
                            <?php if(isset($b) && ($b -> from_tcode != NULL)) {echo get_Tehsil_Name($b -> from_tcode); } ?>              
                       </td>
                       <td><p>Union Council</p></td>
                       <td>              
                            <?php if(isset($b) && ($b -> from_uncode != NULL)) {echo get_UC_Name($b -> from_uncode); } ?>             
                       </td>
                    </tr>
                    <tr>
                        <td><p>Visit Date From</p></td>
                        <td><?php if(isset($b)){ echo date('d-M-Y',strtotime($b -> date_from));} ?></td>
                        <td><p>Visit Date To</p></td>
                        <td><?php if(isset($b)){ echo date('d-M-Y',strtotime($b -> date_to));} ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                       <td><p>Province</p></td>
                       <td>              
                           <?php if(isset($b) && ($b -> from_procode != NULL)) {echo get_Province_Name($b -> from_procode); } ?>              
                       </td>
                       <td><p>District</p></td>
                       <td>
                            <?php 
                                if(isset($b) && ($b -> from_distcode != NULL) && strlen($b -> from_distcode) == 3)
                                { 
                                   echo CrossProvince_DistrictName($b -> from_distcode);
                                }
                                else{
                                   echo "";
                                } 
                            ?>            
                       </td>
                    </tr>
                    <tr>
                       <td><p>Tehsil</p></td>
                       <td>
                            <?php 
                                if(isset($b) && ($b -> from_tcode != NULL || $b -> from_tcode != '') && substr($b -> from_tcode,0,3) == $b -> from_distcode) 
                                {
                                   echo CrossProvince_TehsilName($b -> from_tcode);
                                }
                                else{
                                   echo "";  
                                }
                            ?>            
                       </td>
                       <td><p>Union Council</p></td>
                       <td> 
                            <?php 
                                if(isset($b) && ($b -> from_uncode != NULL) && substr($b -> from_uncode,0,3) == $b -> from_distcode) 
                                {
                                   echo CrossProvince_UCName($b -> from_uncode);
                                }                        
                                else{
                                  echo ""; 
                                } 
                            ?>              
                       </td>
                    </tr>
                    <tr>
                        <td><p>Visit Date From</p></td>
                        <td><?php if(isset($b)){ echo date('d-M-Y',strtotime($b -> date_from));} ?></td>
                        <td><p>Visit Date To</p></td>
                        <td><?php if(isset($b)){ echo date('d-M-Y',strtotime($b -> date_to));} ?></td>
                    </tr>
                <?php } } ?>

            <tr>          
                <td><p>Has Travelled Abroad</p></td>           
                <td>
                    <?php if(isset($a) && $a->have_travel_abroad == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <?php if(isset($a) && $a->have_travel_abroad == "1") { ?>
            <tr>
                <td><p>Country</p></td>       
                <td><?php if(isset($c)){ echo $c -> country;} ?></td>
                <td><p>City / State</p></td>       
                <td><?php if(isset($a)){ echo $a -> city_state;} ?></td>
            </tr>
            <tr>
                <td><p>Departed Date</p></td>       
                <td><?php if(isset($c)){ echo date('d-M-Y',strtotime($c -> departed_date));} ?></td>
                <td><p>Transit Site</p></td>       
                <td><?php if(isset($c)){ echo $c -> transit_site;} ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="4"><strong>Note: </strong> Countries with a "Yes" were visited by the patient in the last 30 days</td>
            </tr>
            <tr colspan="4">          
                <td><p>USA</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_1 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
                <td><p>China</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_2 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>          
                <td><p>Italy</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_3 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
                <td><p>Spain</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_4 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>          
                <td><p>Germany</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_5 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
                <td><p>Iran</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_6 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>          
                <td><p>France</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_7 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
                <td><p>Switzerland</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_8 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>          
                <td><p>UK</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_9 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
                <td><p>South Korea</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_10 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>          
                <td><p>Netherlands</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_11 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
                <td><p>Austria</p></td>           
                <td>
                    <?php if(isset($a) && $a->country_12 == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td><p>Purpose of Visit</p></td>
                <td><?php if(isset($a)){ echo $a -> visit_purpose;} ?></td> 
                <td><p>Stay Duration</p></td>
                <td><?php if(isset($a)){ echo $a -> stay_duration;} ?></td>                 
            </tr>
            <tr>
                <td><p>Address during stay in Pakistan</p></td>
                <td colspan="3"><?php if(isset($a)){ echo $a -> address_during_stay;} ?></td>
            </tr>
            <tr>          
                <td><p>Seasonal Influenza Vaccine?</p></td>           
                <td>
                    <?php if(isset($a) && $a->influenza_vaccine == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
                <td><p>Do you know any persom having cough and fever?</p></td>           
                <td>
                    <?php if(isset($a) && $a->know_any_person_with_symptons == "1"){ ?>
                        <?php echo "Yes"; ?>
                    <?php } else { ?>
                        <?php echo "No"; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td><p>Date of Onset of Symptoms</p></td>       
                <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> date_of_onset));} ?></td>
            </tr>
            <tr>
                <td><p>Date of Notification</p></td>       
                <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> date_of_notification));} ?></td>
                <td><p>Date Reported</p></td>       
                <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> date_reported));} ?></td>
            </tr>
            <tr>
                <td><p>Date of Investigation</p></td>       
                <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> date_of_investigation));} ?></td>
                <td><p>Date of Quarantine</p></td>       
                <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> date_of_quarantine));} ?></td>
            </tr>           
            </tbody>
        </table>
        <table class="table table-bordered table-striped table-hover mytable2 mytable3">
            <thead>
                <tr>
                    <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Signs / Symptoms</th>
                </tr>
            </thead>
            <tbody>            
                <tr>          
                    <td><p>Has Fever?</p></td>           
                    <td>
                        <?php if(isset($a) && $a->is_fever == "1"){ ?>
                            <?php echo "Yes"; ?>
                        <?php } else { ?>
                            <?php echo "No"; ?>
                        <?php } ?>
                    </td>
                    <td><p>Has Cough?</p></td>           
                    <td>
                        <?php if(isset($a) && $a->is_cough == "1"){ ?>
                            <?php echo "Yes"; ?>
                        <?php } else { ?>
                            <?php echo "No"; ?>
                        <?php } ?>
                    </td>
                </tr>
                <tr>          
                    <td><p>Difficulty in Breathing?</p></td>           
                    <td>
                        <?php if(isset($a) && $a->difficulty_breathing == "1"){ ?>
                            <?php echo "Yes"; ?>
                        <?php } else { ?>
                            <?php echo "No"; ?>
                        <?php } ?>
                    </td>
                    <td><p>Any other symptom?</p></td>           
                    <td><?php if(isset($a)){ echo $a -> any_other;} ?></td> 
                </tr>
                <tr>          
                    <td><p>Any Chronic Ailment?</p></td>           
                    <td>
                        <?php if(isset($a) && $a->chronic_ailment == "1"){ ?>
                            <?php echo "Yes"; ?>
                        <?php } else { ?>
                            <?php echo "No"; ?>
                        <?php } ?>
                    </td>
                    <td><p>If yes, mention</p></td>           
                    <td><?php if(isset($a)){ echo $a -> chronic_ailment_desc;} ?></td> 
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-striped table-hover mytable2 mytable3">
            <thead>
                <tr>
                    <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Clinical Screening</th>
                </tr>
            </thead>
            <tbody>            
                <tr>          
                    <td><p>Temperature in Fahrenheit (&#8457)</p></td>           
                    <td><?php if(isset($a)){ echo $a -> temprature;} ?></td>
                    <td><p>Blood Pressure</p></td>           
                    <td><?php if(isset($a)){ echo $a -> bp_from;} ?> / <?php if(isset($a)){ echo $a -> bp_to;} ?> mmhg</td>
                </tr>
                <tr>          
                    <td><p>Pulse/minute</p></td>           
                    <td><?php if(isset($a)){ echo $a -> pulse_rate;} ?></td>
                    <td><p>Chest Auscultation</p></td>           
                    <td><?php if(isset($a)){ echo $a -> chest_asculation;} ?></td>
                </tr>
                <tr>          
                    <td><p>Have person retained at PoE:</p></td>           
                    <td>
                        <?php if(isset($a) && $a->retained_at_poe == "1"){ ?>
                            <?php echo "Yes"; ?>
                        <?php } else { ?>
                            <?php echo "No"; ?>
                        <?php } ?>
                    </td>
                    <td><p>Number of days retained</p></td>           
                    <td><?php if(isset($a)){ echo $a -> no_of_days_retained;} ?></td> 
                </tr>
                <tr>          
                    <td><p>Or shifted to hospital for isolation:</p></td>           
                    <td>
                        <?php if(isset($a) && $a->shifted_for_isolation == "1"){ ?>
                            <?php echo "Yes"; ?>
                        <?php } else { ?>
                            <?php echo "No"; ?>
                        <?php } ?>
                    </td>
                    <td><p>Number of days admitted in isolation</p></td>           
                    <td><?php if(isset($a)){ echo $a -> days_admitted;} ?></td> 
                </tr>
                <tr>          
                    <td><p>Have sample collected:</p></td>           
                    <td>
                        <?php if(isset($a) && $a->sample_collected == "1"){ ?>
                            <?php echo "Yes"; ?>
                        <?php } else { ?>
                            <?php echo "No"; ?>
                        <?php } ?>
                    </td>
                    <td><p>Type of sample/specimen</p></td>           
                    <td><?php if(isset($a)){ echo $a -> sample_type;} ?></td> 
                </tr>
                <tr>
                    <td><p>Date of Sampling/Collection</p></td>       
                    <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> date_of_collection));} ?></td>
                    <td><p>Date of Shipment to NIH</p></td>       
                    <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> date_of_shipment_to_nih));} ?></td>
                </tr>  
                <tr>
                    <td><p>Test Result</p></td>       
                    <td>
                      <?php if(isset($a) && $a -> test_result == "Pending"){ ?>
                          <?php echo "Pending/Awaited"; ?>
                        <?php } else { ?>
                          <?php echo $a-> test_result; ?>
                      <?php } ?>
                    </td> 
                    <td><p>Outcome</p></td>       
                    <td>
                        <?php if(isset($a) && $a-> outcome == "Death"){ ?>
                            <?php echo "Patient Died"; ?>
                        <?php } else { ?>
                            <?php echo $a-> outcome; ?>
                        <?php } ?>
                    </td>
                </tr>
                <?php if(isset($a) && $a-> outcome == "Death") { ?>
                    <td><p>Date of Death</p></td>       
                    <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> date_of_death));} ?></td>
                <?php } ?> 
            </tbody>
        </table>        
      <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center; padding-top: 10px; padding-bottom: 10px;"></th>
            </tr>
          </thead>
          <tbody>
           <tr>
            <td><p>Submission Date</p></td>
            <td><p><?php if(isset($a) && $a->submitted_date != "" && $a->editted_date != ""){ echo date('d-m-Y',strtotime($a->editted_date)); } else { if($a->submitted_date != "" && $a->submitted_date != "1970-01-01"){ echo date('d-m-Y',strtotime($a->submitted_date)); } }  ?></p></td>
          </tr>
         </tbody>
        </table>
      <div class="row">
         <hr>
     <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
        <?php if($a->cross_notified != 1){ ?>
        <a href="<?php echo base_url(); ?>Coronavirus_investigation/coronavirus_investigation_edit/<?php echo $a->id; ?>/<?php echo $a->year; ?>" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" ><i class="fa fa-pencil-square-o"></i> Update </a>
        <?php }else if($a->cross_notified == 1 && $a->distcode == $this -> session -> District && $a->approval_status != "Approved"){ ?>
        <button style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-check"></i> Approve Case</button>
        <?php 
        $this->session->set_flashdata('redirectToCurrent', current_url());
        } ?>
              <a href="<?php echo base_url(); ?>Coronavirus_investigation/coronavirus_investigation_list" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
     <?php } ?>
        </div>
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->