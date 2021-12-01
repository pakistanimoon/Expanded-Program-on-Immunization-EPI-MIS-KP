
<div class="container bodycontainer">
<div class="row">
 <div class="panel panel-primary">
 <?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-danger text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
   <div class="panel-heading">Acute Flaccid Paralysis Case</div>
    <div class="panel-body">      
    <form class="form-horizontal" method="post" onsubmit="return confirm('Do you really want to Approve this cross notified case?')" action="<?php echo base_url(); ?>Investigation_forms/afp_Approve">
     <input type="hidden" name="id" value="<?php echo $a-> id; ?>">
     <input type="hidden" name="cross_case_id" value="<?php echo $a-> cross_case_id; ?>" />
     <?php if(isset($a->rb_distcode) && $a->rb_distcode>0){ ?>
     <table id="rb_info" class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
      <thead>
        <tr>
          <th colspan="7" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Case Refering Facility Information</th>
        </tr>
      </thead>
      <tbody>           
        <tr>
          <td><p>Province / Area</p></td>
          <!-- <td><?php //echo $this -> session -> provincename ?></td> -->
          <td>
            <?php 
              $procode = substr($a -> rb_distcode,0,1);
              echo get_Province_Name($procode);
              //echo $this -> session -> provincename; 
            ?>              
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
        <table class="table table-bordered   table-striped table-hover  mytable3">
          <thead>
            <tr>
              <th colspan="7" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">PART I : For Use by Reporting Facility and DHO</th>
            </tr>
          </thead>
            <tbody>
            <?php if($a->cross_notified != 1 && $a->distcode == $this -> session -> District){ ?>
               <?php if($a->distcode != ''){ ?>
               <tr>
                  <td><label class="pt7">Province</label></td>
                  <td><?php echo $this -> session -> provincename ?></td>
                  <td><label class="pt7">District</label></td>
                  <td><?php if(isset($a)){ echo CrossProvince_DistrictName($a -> distcode);} ?></td>
               </tr>
              <tr>
					<td><label class="pt7">Tehsil</label></td>
					<td><?php if(isset($a)){ echo CrossProvince_TehsilName($a -> tcode);} ?></td>
               <td><label class="pt7">Union Council</label></td>
               <td><?php if(isset($a)){ echo CrossProvince_UCName($a -> uncode);} ?></td>
					</tr>
            <?php } } ?> 
            <?php if($a->facode != ''){ ?>
					<tr>								
              
                  <td><label class="pt7">Name of Reporting Health Facility</label></td>
                  <td><?php if(isset($a)){ echo CrossProvince_FacilityName($a -> facode);} ?></td>
                  <td><label>Address of Health Facility</label></td>
                  <td><?php if(isset($a)){ echo $a -> faddress;} ?></td>
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
                </tr>               
              <?php } ?>
             
               <tr>
                  <td><label class="pt7">Year</label></td>
                  <td><?php if(isset($a)){ echo $a -> year;} ?></td>
                  <td><label class="pt7">EPI Week No</label></td>
                  <td><?php if(isset($a)){ echo $a -> week;} ?></td>
               </tr>
               <tr>               
                  <td><label class="pt7">Date From</label></td>
                  <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> datefrom));} ?></td>
                  <td><label class="pt7">Date To</label></td>
                  <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> dateto));} ?></td>
               </tr>
					<!--  <tr>
						<td><label class="pt7">Case Reported</label></td>
						<td><?php echo isset($a)?(($a->case_reported=="0")?'No':'Yes'):''; ?></td>  
					</tr> -->
     <!--  </tbody>
    </table>
    <table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Basic Information</th>
            </tr>
          </thead>
      <tbody> -->
           <tr>
              <td colspan="4">
                <table>
                  <tbody>
                     <tr>
                  <?php if($a->case_epi_no != ''){ ?>
                    <td style="width: 25%;"><label style="margin-top: 7px;">EPID Number</label></td>
                    <td style="text-align: right; width: 10%;"><label style="padding-top: 5px;"><?php if(isset($a)){ echo $a->case_epi_no; } ?></label></td>
                  <?php }else if($a->case_epi_no == '' && $a->distcode == $this -> session -> District){ ?>
                    <td style="width: 25%;"><label style="margin-top: 7px;">EPID Number</label>(Suggested)</td>
                    <td style="text-align: right; width: 10%;">
                    <input type="hidden" name="case_epi_no" class="form-control" value="<?php echo getEpid_no_afp(true,$a->year); ?>" />
                    <input type="hidden" name="afp_number" class="form-control" value="<?php echo getEpid_no_afp(true,$a->year,'Yes'); ?>"  />
                    <label style="padding-top: 5px;"><?php echo getEpid_no_afp(true,$a->year); ?></label>
                    </td>  
                  <?php } ?>
                  </tr>
                </tbody></table>
               </td>
            </tr>
			 
            <tr>
               <td><label>Patient's Name</label></td>
               <td><?php if(isset($a)){ echo $a -> patient_name;} ?></td>
               <td><label>Gender</label></td>
               <td><?php echo isset($a)?(($a->patient_gender=="0")?'Female':''):'';echo isset($a)?(($a->patient_gender=="1")?'Male':''):''; ?></td>                                
            </tr>
             <tr>
               <td><label>Father's Name</label></td>
               <td><?php if(isset($a)){ echo $a -> patient_fathername;} ?></td>       
               <td><label>Contact Number</label></td>
               <td><?php if(isset($a)){ echo $a -> contact_numb;} ?></td>       
            </tr>
            <tr>
               <td><label>Date of Birth</label></td>
               <td><?php if(isset($a)){if($a -> patient_dob) { echo date('d-m-Y',strtotime($a->patient_dob)); } } ?></td>            
               <td><label>Age in Months</label></td>
               <td><?php if(isset($a) && $a->case_reported!="0"){ echo $a -> age_months;} ?></td>              
            </tr>
           
            <!-- <tr>
               <td><label style="padding-top: 7px;">Address</label></td>
               <td><?php if(isset($a)){ echo $a -> patient_address;} ?></td>
               <td><label>District</label></td>
               <td><?php if(isset($a) && ($a -> patient_address_distcode != NULL)){ echo get_District_Name($a -> patient_address_distcode);} ?></td>
               <td><label>Tehsil / Taluka / City</label></td>
               <td><?php if(isset($a) && ($a -> patient_address_tcode != NULL)){ echo get_Tehsil_Name($a -> patient_address_tcode);} ?></td>

               <td><label>Union Council</label></td>
               <td><?php if(isset($a) && ($a -> patient_address_uncode != NULL)){ echo get_UC_Name($a -> patient_address_uncode);} ?></td>
            </tr> -->

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
               <td><label>Province / Area</label></td>
               <td><?php if(isset($a)){ echo $this -> session -> provincename; } ?></td>
               <td><label>District</label></td>
               <td><?php if(isset($a) && ($a -> patient_address_distcode != NULL)){ echo CrossProvince_DistrictName($a -> patient_address_distcode);} ?></td>
            </tr>
            <tr>
               <td><label>Tehsil / Taluka / City</label></td>
               <td><?php if(isset($a) && ($a -> patient_address_tcode != NULL)){ echo get_Tehsil_Name($a -> patient_address_tcode);} ?></td>
               <td><label>Union Council</label></td>
               <td><?php if(isset($a) && ($a -> patient_address_uncode != NULL)){ echo get_UC_Name($a -> patient_address_uncode);} ?></td>
            </tr>
         <?php } else { ?>
            <tr>
               <td><label>Province</label></td>
               <td>              
                  <p><?php if(isset($a) && ($a -> procode != NULL)) {echo get_Province_Name($a-> procode);} ?></p>              
               </td>
               <td><label>District</label></td>
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
               <td><label>Tehsil</label></td>
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
               <td><label>Union Council</label></td>
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
               <td><label>Village / Street / Mahalla</label></td>
               <td colspan="3"><?php if(isset($a)){ echo $a -> patient_address;} ?></td>
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
				   <td><?php if(isset($a)){if($a -> case_date_onset) {echo date('d-m-Y',strtotime($a->case_date_onset)); } } ?></td>
                  
                </tr>
                <tr>
                  <td><label>Date of Notification</label></td>
				  <td><?php if(isset($a)){if($a -> case_date_notification) {echo date('d-m-Y',strtotime($a->case_date_notification)); } } ?></td>
                
                </tr>
                <tr>
                  <td><label>Date of Investigation</label></td>
				  <td><?php if(isset($a)){if($a -> case_date_investigation) {echo date('d-m-Y',strtotime($a->case_date_investigation)); } } ?></td>
                  
                </tr>
				<tr>
				<td><label>Clinical Representation</label></td>
				<td><?php if(isset($a)){ echo $a -> clinical_representation;} ?></td>
				</tr>

              </tbody>
             
            </table>
          </td>
          <td>
            <table class="table table-bordered table-condensed table-striped table-hover mytable3 disabledclass">
              <tbody>
                <tr>
                     <td><label>Fever at onset</label>
                     <td><?php echo (isset($a) && $a -> fever_onset=="1")?'Yes':'No'; ?></td>
                  </tr>
                  <tr>
                     <td><label>Rapid progression</label></td>                 
                     <td><?php echo (isset($a) && $a -> rapid_progression=="1")?'Yes':'No'; ?></td>
                  </tr>
                  <tr>
                     <td><label>Asymm paralysis</label></td>
                     <td><?php echo (isset($a) && $a -> asymm_paralysis=="1")?'Yes':'No'; ?></td>            
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
                  <td><label>Routine</label></td>
				   <td><?php if(isset($a)){ echo $a -> doses_received;} ?></td>
                 
                </tr>
                <tr>
                  <td><label>SIA</label></td>
				   <td><?php if(isset($a)){ echo $a -> sia;} ?></td>
                 
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
                  <th colspan="2">S1</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><label>Date of Collection</label></td>
				  <td><?php if(isset($a)){if($a -> date_collection_s1) {echo date('d-m-Y',strtotime($a->date_collection_s1)); } } ?></td>
                   
                </tr>
                <tr>
                  <td><label>Date sent to Lab</label></td>
				   <td><?php if(isset($a)){if($a -> date_sent_lab_s1) {echo date('d-m-Y',strtotime($a->date_sent_lab_s1)); } } ?></td>
                 
                </tr>
              </tbody>
            </table>
          </td>
          <td>
            <table class="table table-bordered table-condensed table-striped table-hover mytable3">
              <thead>
                <tr>
                  <th colspan="2">S2</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><label>Date of Collection</label></td>
				  <td><?php if(isset($a)){if($a -> date_collection_s2) {echo date('d-m-Y',strtotime($a->date_collection_s2)); } } ?></td>
               
                </tr>
                <tr>
                  <td><label>Date sent to Lab</label></td>
				   <td><?php if(isset($a)){if($a -> date_sent_lab_s2) {echo date('d-m-Y',strtotime($a->date_sent_lab_s2)); } } ?></td>
              
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
                  <th colspan="2">S1</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><label>Condition</label></td>
				  <td><?php if(isset($a)){ echo $a -> condition_s1;} ?></td>
                  
                </tr>
                <tr>
                  <td><label>Final Result</label></td>
				   <td><?php if(isset($a)){ echo $a -> final_result_s1;} ?></td>

                </tr>
              </tbody>
            </table>
          </td>
          <td>
            <table class="table table-bordered table-condensed table-striped table-hover mytable3">
              <thead>
                <tr>
                  <th colspan="2">S2</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><label>Condition</label></td>
				   <td><?php if(isset($a)){ echo $a -> condition_s2;} ?></td>
                 
                </tr>
                <tr>
                  <td><label>Final Result</label></td>
				   <td><?php if(isset($a)){ echo $a -> date_sent_lab_s2;} ?></td>
                 
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
				  <td><?php if(isset($a)){ echo $a -> date_follow_up;} ?></td>
                 
                </tr>
                <tr>
                  <td><label>Residual paralysis weakness</label></td>
				   <td><?php if(isset($a)){ echo $a -> residual_paralysis;} ?></td>
                  
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
                  <td><?php echo isset($a)?(($a->classification=="1")?'Confirmed':''):'';echo isset($a)?(($a->classification=="2")?'Compatible':''):''; echo isset($a)?(($a->patient_gender=="3")?'Discarded':''):'';?></td>
                 
                  
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
				    <td><?php if(isset($a)){ echo $a -> final_diagnosis;} ?></td>
                 
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
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
          	<td><label>Submission Date</label></td>
          	<td><p><?php if(isset($a) && $a->editted_date != ""){ echo date('d-m-Y',strtotime($a->editted_date)); } else { if($a->submitted_date != ""){ echo date('d-m-Y',strtotime($a->submitted_date)); } else {} }  ?></p></td>
        
         </tr>
         </tbody>
        </table>
        <div class="row">
         <hr>
		 <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
           <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <!-- <a href="<?php echo base_url(); ?>AFP-CIF/Edit/<?php echo $a->facode; ?>/<?php echo $a->id; ?>" style="background:  #008d4c;" class="btn btn-primary btn-md"><i class="fa fa-pencil-square-o"></i> Update </a> -->
               <?php if($a->cross_notified != 1){ ?>
                <a href="<?php echo base_url(); ?>AFP-CIF/Edit/<?php echo $a->facode; ?>/<?php echo $a->id; ?>" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" ><i class="fa fa-pencil-square-o"></i> Update </a>
                <?php }else if($a->cross_notified == 1 && $a->distcode == $this -> session -> District && $a->approval_status != "Approved"){ ?>
                <button style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-check"></i> Approve Case</button>
                <?php 
                $this->session->set_flashdata('redirectToCurrent', current_url());
                } ?>
              <a onclick="history.go(-1);" style="background:  #008d4c;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
		 <?php } ?>
        </div>
           
      </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--end of body container-->

  