<?php //print_r($a);exit(); ?> 
<div class="container bodycontainer">
  
<div class="row">
    <div class="panel panel-primary">
    <?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-danger text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
        <div class="panel-heading"> Measles Investigation Form View</div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" onsubmit="return confirm('Do you really want to Approve this cross notified case?')" action="<?php echo base_url(); ?>Measles_investigation/measlesInvestigation_Approve">
                  <input type="hidden" name="id" value="<?php echo $a->id; ?>">
                    <input type="hidden" name="cross_case_id" value="<?php echo $a->cross_case_id; ?>" />
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
                <p> 
                            <?php
                    $procode = substr($a->rb_distcode, 0,1);
                    echo get_Province_Name($procode);           
                  ?>
                        <p>                
            </td>
          <td><p>District</p></td>
          <td>
            <p><?php if(isset($a)){ echo CrossProvince_DistrictName($a -> rb_distcode);} ?></p>
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
        <input type="hidden" name="gender" value="<?php if(isset($a)){ echo $a -> patient_gender;} ?>">
        <input type="hidden" name="case_type" value="<?php if(isset($a)){ echo $a -> case_type;} ?>">
        <input type="hidden" name="doses_received" value="<?php if(isset($a)){ echo $a -> doses_received;} ?>">
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
                        <?php }else if($a->case_epi_no == '' && $a->case_type != 'Msl' && $a->fweek < '2018-11'){ ?>
                           <td><label></label></td>
                        <?php }else if($a->case_epi_no == '' && $a->distcode == $this -> session -> District && $a->cross_notified_from_distcode != ''){ ?>
                           <td style="width: 25%;"><label style="margin-top: 7px;">EPID Number</label>(Suggested)</td>
                           <td style="text-align: right; width: 10%;">
                              <input type="hidden" name="case_epi_no" class="form-control" value="<?php echo getEpid_no_casesInvestigation(true,$a->year,$a->case_type); ?>" />
                              <input type="hidden" name="case_number" class="form-control" value="<?php echo getEpid_no_casesInvestigation(true,$a->year,$a->case_type,'Yes'); ?>"  />
                              <label style="padding-top: 5px;"><?php echo getEpid_no_casesInvestigation(true,$a->year,$a->case_type); ?></label>
                           </td>  
                        <?php } ?>  
                     </tr>
                  </tbody>
                </table>
               </td>
            </tr>
            <tr>
              <td><p>Patient's Name</p></td>
              <td><?php if(isset($a)){ echo $a -> patient_name;} ?></td>
              <td><p>Gender</p></td>
              <td><?php echo isset($a)?(($a->patient_gender=="0")?'Female':''):'';echo isset($a)?(($a->patient_gender=="1")?'Male':''):''; ?></td>
            </tr>
            <tr>
              <td><p>Father's Name</p></td>
              <td><?php if(isset($a)){ echo $a -> patient_fathername;} ?></td>
              <td><p>Contact Number</p></td>
              <td><?php if(isset($a)){ echo $a -> contact_numb;} ?></td>
            <tr>
              <td><p>Date of Birth</p></td>
              <td><?php if(isset($a)){if($a -> patient_dob) { echo date('d-m-Y',strtotime($a->patient_dob)); } } ?></td>
              <td><p>Age in Months</p></td>
              <td><?php if(isset($a) && $a->case_reported!="0"){ echo $a -> age_months;} ?></td>
            </tr>
            </tbody>
          </table>
          <table class="table table-bordered table-striped table-hover mytable2 mytable3">
           <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Address of Patient</th>
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
                        echo $a -> other_pro_district;
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
                           echo $a -> other_pro_tehsil;  
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
                           echo $a -> other_pro_uc;  
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
                    <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Disease Information</th>
                </tr>
            </thead>
            <tbody>
                <tr>              
                    <td style="width: 30%;"><p>Clinical Representation</p></td>
                    <td style="width: 30%;"><?php if(isset($a) && $a -> clinical_representation != "" && $a -> clinical_representation != NULL){ echo $a -> symptoms;} ?></td>
                </tr>
                <tr>
                    <td><p>Complications </p></td>
                    <td><?php if(isset($a)){ echo $a -> complications;} ?></td>
                    <td><p>Date of Rash onset</p></td>
                    <td><?php if(isset($a)){if($a -> date_rash_onset) {echo date('d-m-Y',strtotime($a->date_rash_onset)); } } ?></td>
                </tr>
                <tr>
                    <td><p>Number of vaccine doses received </p></td>
                    <td><?php if(isset($a)){ echo $a -> doses_received;} ?></td>
                    <td><p>Type of Specimen </p></td>
                    <td><?php echo (isset($a) && $a-> type_specimen == 'None')?"Not Collected":$a-> type_specimen; ?></td>           
                </tr>
                <?php if(isset($a) && $a -> type_specimen != 'None') { ?>
                    <tr>
                        <td><p>Specimen Quantity Adequate</p></td>
                        <td><?php echo (isset($a) && $a -> specimen_quantity_adequate == 2)?"No":"Yes"; ?></td>
                        <?php if(isset($a) && $a -> specimen_quantity_adequate == 2) { ?>
                            <td><p>Final Classification</p></td>
                            <td><?php if(isset($a)){ echo $a -> final_classification;} ?></td>  
                        <?php } ?>
                    </tr>
                    <?php if(isset($a) && $a -> final_classification == 'Epi Linked') { ?>
                        <tr>
                            <td><p>Linked EPID Number</p></td>
                            <td><?php if(isset($a)){ echo $a -> linked_epid_number;} ?></td>  
                        </tr>                            
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td><p>Final Classification</p></td>
                        <td><?php if(isset($a)){ echo $a -> final_classification;} ?></td> 
                        <?php if(isset($a) && $a -> final_classification == 'Epi Linked') { ?>
                            <td><p>Linked EPID Number</p></td>
                            <td><?php if(isset($a)){ echo $a -> linked_epid_number;} ?></td>  
                        <?php } ?>
                    </tr> 
                <?php } ?>
                <tr> 
                    <td><p>Other Specimen Type</p></td>
                    <td><?php if(isset($a)){ echo $a -> other_specimen;} ?></td>        
                    <td><p>Date of Collection</p></td>
                    <td><?php if(isset($a) && $a->date_collection != NULL){if($a) {echo date('d-m-Y',strtotime($a->date_collection)); } } ?></td>
                </tr>
          <tr>
                <td><p>Date Sent to Lab</p></td>
                    <td><?php if(isset($a) && $a->date_sent_lab != NULL){if($a) {echo date('d-m-Y',strtotime($a->date_sent_lab)); } } ?></td>
                <td><p>Date of Investigation</p></td>
                    <td><?php if(isset($a) && $a->date_investigation != NULL){if($a) {echo date('d-m-Y',strtotime($a->date_investigation)); } } ?></td>
          </tr>
      <tr>
                <?php if(isset($a) && ($a ->case_type == 'ChTB' || $a ->case_type == 'Diph' || $a ->case_type == 'Men' || $a ->case_type == 'Pert' || $a ->case_type == 'Msl' || $a ->case_type == 'Pneu')) { ?> 
                    <td><p>Travel history within 21 days prior to rash onset</p></td>
                <?php } else { ?>
                    <td><p>Travel history</p></td>
                <?php } ?>
                <td>
                    <?php if(isset($a) && $a->travel_history == "1"){ ?>
                        <p><?php echo "Yes"; ?></p>
                    <?php } else { ?>
                        <p><?php echo "No"; ?></p>
                    <?php } ?>
                </td>
      </tr>
      <?php if(isset($a) && $a->travel_history == "1") { ?>
         <?php if(isset($a) && $a->th_procode == $_SESSION["Province"]) { ?>
            <tr>
               <td><p>Provice</p></td>
               <td>              
                  <p><?php if(isset($a) && ($a -> th_procode != NULL)) {echo get_Province_Name($a -> th_procode); } ?></p>              
               </td>
               <td><p>District</p></td>
               <td>              
                  <p><?php if(isset($a) && ($a -> th_distcode != NULL)) {echo get_District_Name($a -> th_distcode); } ?></p>              
               </td>
            </tr>
            <tr>
               <td><p>Tehsil</p></td>
               <td>              
                  <p><?php if(isset($a) && ($a -> th_tcode != NULL)) {echo get_Tehsil_Name($a -> th_tcode); } ?></p>              
               </td>
               <td><p>Union Council</p></td>
               <td>              
                  <p><?php if(isset($a) && ($a -> th_uncode != NULL)) {echo get_UC_Name($a -> th_uncode); } ?></p>              
               </td>
            </tr>
      <?php } else { ?>
            <tr>
               <td><p>Province</p></td>
               <td>              
                  <p><?php if(isset($a) && ($a -> th_procode != NULL)) {echo get_Province_Name($a -> th_procode); } ?></p>              
               </td>
               <td><p>District</p></td>
               <td>              
                  <p>
                     <?php 
                        if(isset($a) && ($a -> th_distcode != NULL) && strlen($a -> th_distcode) == 3)
                        { 
                           echo CrossProvince_DistrictName($a -> th_distcode);
                        }
                        else{
                           echo $a -> th_district;
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
                        if(isset($a) && ($a -> th_tcode != NULL || $a -> th_tcode != '') && substr($a -> th_tcode,0,3) == $a -> th_distcode) 
                        {
                           echo CrossProvince_TehsilName($a -> th_tcode);
                        }
                        else{
                           echo $a -> th_tehsil;  
                        }
                     ?> 
                  </p>                 
                  <!-- <p><?php //echo $a -> th_tehsil; ?></p>  -->             
               </td>
               <td><p>Union Council</p></td>
               <td>              
                  <p>
                     <?php 
                        if(isset($a) && ($a -> th_uncode != NULL) && substr($a -> th_uncode,0,3) == $a -> th_distcode) 
                        {
                           echo CrossProvince_UCName($a -> th_uncode);
                        }                        
                        else{
                          echo $a -> th_uc; 
                        } 
                     ?>                  
                  </p>              
               </td>
            </tr>
         <?php } } ?>
            <tr>
               <td><p>Type of Specimen</p></td>
               <td>              
                  <p><?php echo $a -> type_specimen; ?></p>              
               </td>
               <td><p>Lab result to be sent to</p></td>
               <td>              
                  <p>
                    <?php 
                      if(isset($a) && ($a -> labresult_tobesentto != NULL))
                        { echo get_District_Name($a -> labresult_tobesentto);} 
                      else if (strlen($a -> labresult_tobesentto_district) == 3)
                        { echo CrossProvince_DistrictName($a -> labresult_tobesentto_district);}
                        else{
                           echo $a -> labresult_tobesentto_district;
                        }
                    ?>             
                </p> 
               </td>
            </tr>
           <!--<tr>
              <td colspan="4"><label>Lab Result to be Sent to  (DHO, DSC/SO-WHO, Provincial and Federal Officials) and </label></td>
            </tr>
            <tr>
              <td><p>Name</p></td>
              <td><?php //if(isset($a)){ echo $a -> result_sent_to_name;} ?></td>
              <td><p>Address</p></td>
              <td><?php //if(isset($a)){ echo $a -> result_sent_to_address;} ?></td>
            </tr>
            <tr>
              <td><p>Telephone / Fax</p></td>
              <td><?php //if(isset($a)){ echo $a -> result_sent_to_phone;} ?></td>
              <td><p>Email</p></td>
              <td><?php //if(isset($a)){ echo $a -> result_sent_to_email;} ?></td>
            </tr>
            <tr>
              <td><p>Name of person completing the form</p></td>
              <td><?php //if(isset($a)){ echo $a -> person_completing_form_name;} ?></td>
              <td><p>Designation</p></td>
              <td><?php //if(isset($a)){ echo $a -> person_completing_form_desg;} ?></td>
            </tr>
            <tr>
              <td><p>Date</p></td>
              <td><?php //if(isset($a)){if($a -> form_completion_date != '1969-12-31') {echo $a->form_completion_date; } } ?></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">PART II : For Use by Receiving Laboratory</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p>Type of specimen</p></td>
              <td>
                <table style="width: 100%;">
                  <tr>
                    <td><?php //if(isset($a)){ echo $a -> lab_specimen_type;} ?></td>
                  </tr>
                </table>
              </td>
            
            </tr>
            <tr>
              <td><p>Date specimens received at lab</p></td>
              <td><?php //if(isset($a)){if($a -> lab_specimen_received_date != '1969-12-31') {echo $a->lab_specimen_received_date; } } ?></td>
              
            </tr>
            <tr>
              <td><p>Lab Number</p></td>
              <td> <?php //if(isset($a)){ echo $a -> lab_number;} ?></td>
              
            </tr>
            <tr>
              <td><p style="display: inline-block;">Condition of specimen</p><span style="float: right;">Quantity Adequate</span></td>
              <td><?php //if(isset($a)){ echo $a -> quality_adequate;} ?></td>
              
            </tr>
            <tr>
              <td><span style="float: right;">Cold Chain OK</span></td>
              <td><?php //if(isset($a)){ echo $a -> cold_chain_ok;} ?></td>
              
            </tr>
            <tr>
              <td><p style="display: inline-block;">Specimen Received by</p><span style="float: right;">Name</span></td>
              <td> <?php //if(isset($a)){ echo $a -> received_by_name;} ?></td>
              
            </tr>
            <tr>
              <td><span style="float: right;">Designation</span></td>
              <td> <?php //if(isset($a)){ echo $a -> received_by_desg;} ?></td>
              
            </tr>
            <tr>
              <td><p>Date of Lab Test done</p></td>
              <td><?php //if(isset($a)){if($a -> lab_test_date != '1969-12-31') {echo $a->lab_test_date; } } ?></td>
              
            </tr>
            <tr>
              <td><p>Type of test done</p></td>
              <td> <?php //if(isset($a)){ echo $a -> lab_test_type;} ?></td>
             
            </tr>
            <tr>
              <td><p>Test Result</p></td>
              <td> <?php //if(isset($a)){ echo $a -> lab_test_result;} ?></td>
              
            </tr>
            <tr>
              <td><p>Comment</p></td>
              <td> <?php //if(isset($a)){ echo $a -> comment;} ?></td>
              
            </tr>
            <tr>
              <td colspan="4"><label>Report sent by</label></td>
            </tr>
            <tr>
              <td><p>Name</p></td>
              <td> <?php //if(isset($a)){ echo $a -> report_sent_by_name;} ?></td>
              <td><p>Designation</p></td>
              <td> <?php //if(isset($a)){ echo $a -> report_sent_by_desg;} ?></td>
            </tr>
            <tr>
              <td><p>Date</p></td>
              <td><?php //if(isset($a)){if($a -> report_sent_by_date) {echo date('d-m-Y',strtotime($a->report_sent_by_date)); } } ?></td>
            </tr>-->             
        </tbody>
      </table>
      <table class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
      <thead>
        <tr>
          <th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Part II: For use by receiving laboratory</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><p>Date Specimen Received at lab</p></td>
          <td>
            <?php if(isset($a) && $a->specimen_received_date !='') { ?>
              <p><?php echo date("d-m-Y",strtotime($a->specimen_received_date)); ?></p>
            <?php } ?>
          </td>          
         </tr>
         <tr>
            <td><p style="display: inline-block;">Condition of Specimen</p><span style="float: right;">Quantity Adequate:</span></td>
            <td style="padding-left: 50px;"><?php echo (($a->quantity_adequate==1)?"Yes":"No"); ?></td>
         </tr>
         <tr>
            <td><span style="float: right;">Cold Chain OK:</span></td>
            <td style="padding-left: 50px;"><?php echo (($a->cold_chain_ok==1)?"Yes":"No"); ?></td>
         </tr>
      <?php //if($a->quantity_adequate==2) { ?> 
         <tr>
            <td><span style="float: right;">Leekage/Broken Container:</span></td>
            <td style="padding-left: 50px;"><?php echo (($a->leakage_broken==1)?"Yes":"No"); ?></td>
         </tr>
          <tr>
            <td><span style="float: right;">Test Possible:</span></td>
            <td style="padding-left: 50px;"><?php echo (($a->test_possible==1)?"Yes":"No"); ?></td>
         </tr>
      <?php //} ?>
        <tr>
          <td><p>Specimen Received by: Name</p></td>
          <td>
            <?php if(isset($a) && $a->specimen_received_by !='') { ?>
              <p><?php echo $a->specimen_received_by; ?></p>
            <?php } ?>
          </td>
          <td><p>Designation</p></td>
          <td>
            <?php if(isset($a) && $a->received_by_designation !='') { ?>
              <p><?php echo $a->received_by_designation; ?></p>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><p>Lab ID Number</p></td>
          <td>
            <?php if(isset($a) && $a->lab_id_number !='') { ?>
              <p><?php echo $a->lab_id_number; ?></p>
            <?php } ?>
          </td>
          <td><p>Date of Lab Test Done</p></td>
          <td>
            <?php if(isset($a) && $a->lab_testdone_date !='') { ?>
              <p><?php echo date("d-m-Y",strtotime($a->lab_testdone_date)); ?></p>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><p>Type of Specimen</p></td>
          <td>
            <?php if(isset($a) && $a->type_of_test !='') { ?>
              <p><?php echo $a->type_of_test; ?></p>
            <?php } ?>
          </td>
          <td><p>Other Specimen</p></td>
          <td>
            <?php if(isset($a) && $a->other_specimen_lab !='') { ?>
              <p><?php echo $a->other_specimen_lab; ?></p>
            <?php } ?>
          </td>         
        </tr>
        <tr>
          <td><p>Test Result</p></td>
          <td>
            <?php if(isset($a) && $a->specimen_result !='') { ?>
              <p><?php echo $a->specimen_result; ?></p>
            <?php } ?>
          </td>
          <td><p>Other Result</p></td>
          <td>
            <?php if(isset($a) && $a->other_specimen_result !='') { ?>
              <p><?php echo $a->other_specimen_result; ?></p>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><p>Lab Final Classification</p></td>
          <td>
            <?php if(isset($a) && $a->lab_final_classification !='') { ?>
             <?php echo $a->lab_final_classification; ?>
            <?php } ?>
          </td> 
        </tr>
        <tr>
           <td><p>Comment</p></td>
          <td>
            <?php if(isset($a) && $a->comments !='') { ?>
              <p><?php echo $a->comments; ?></p>
            <?php } ?>
          </td>
          <td><p>Date of lab report sent/submitted</p></td>
          <td>
            <?php if(isset($a) && $a->lab_report_sent_date !='') { ?>
              <p><?php echo date("d-m-Y",strtotime($a->lab_report_sent_date)); ?></p>
            <?php } ?>
          </td>                   
        </tr>
        <tr>
          <td><p>Report Sent by: Name</p></td>
          <td>
            <?php if(isset($a) && $a->report_sent_by !='') { ?>
              <p><?php echo $a->report_sent_by; ?></p>
            <?php } ?>
          </td> 
          <td><p>Designation</p></td>
          <td>
            <?php if(isset($a) && $a->sent_by_designation !='') { ?>
              <p><?php echo $a->sent_by_designation; ?></p>
            <?php } ?>
          </td>
          <!-- <td><p>Date</p></td>
          <td>
            <?php if(isset($a) && $a->result_saved_date !='') { ?>
              <p><?php echo date("d-m-Y",strtotime($a->result_saved_date)); ?></p>
            <?php } ?>
          </td> -->
        </tr>
         </tbody>
      </table>      
      <table class="table table-bordered table-striped table-hover mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">PART III : 30-day Follow up (to be filled for outbreak cases)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="width: 25%;"><p>Date of Follow UP</p></td>
              <td style="width: 25%;"><?php if(isset($a)){if($a -> followup_date) { echo date('d-m-Y',strtotime($a->followup_date)); } } ?></td>
              <td style="width: 25%;"><p>Outcome</p></td>
              <td style="width: 25%;"><?php if(isset($a)){ echo $a -> outcome;} ?></td>
            </tr>
             <tr>
             <?php if($a -> outcome == "Complication") {?>
              <td style="width: 25%;"><p>Type of Complication</p></td>
              <td style="width: 25%;"><?php if(isset($a)){ echo $a -> complication;} ?></td>
              <?php } else { ?>
              <td style="width: 25%;"><p>Date of Death</p></td>
              <td style="width: 25%;"><?php if(isset($a)){if($a -> death_date) {  echo date('d-m-Y',strtotime($a->death_date)); } } ?></td>
              <?php }?>
            </tr>
            <!--<tr>
              <td colspan="4"><label>Reported by</label></td>
            </tr>
            <tr>
              <td><p>Name</p></td>
              <td> <?php //if(isset($a)){ echo $a -> reported_by_name;} ?></td>
              <td><p>Designation</p></td>
              <td> <?php //if(isset($a)){ echo $a -> reported_by_desg;} ?></td>
            </tr>
            <tr>
              <td><p>Date</p></td>
              <td><?php //if(isset($a)){if($a -> reported_by_date != '1969-12-31') {echo $a->reported_by_date; } } ?></td>
            </tr>-->
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
        <a href="<?php echo base_url(); ?>Measles_investigation/measles_investigation_edit/<?php echo $a->id; ?>/<?php echo $a->year; ?>" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" ><i class="fa fa-pencil-square-o"></i> Update </a>
        <?php }else if($a->cross_notified == 1 && $a->distcode == $this -> session -> District && $a->approval_status != "Approved"){ ?>
        <button style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-check"></i> Approve Case</button>
        <?php 
        $this->session->set_flashdata('redirectToCurrent', current_url());
        } ?>
              <a href="<?php echo base_url(); ?>Measles_investigation/measles_investigation_list" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
     <?php } ?>
        </div>
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->