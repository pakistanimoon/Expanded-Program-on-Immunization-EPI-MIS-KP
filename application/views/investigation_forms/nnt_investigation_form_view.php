
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> NNT Investigation Form</div>
     <div class="panel-body">
        <form class="form-horizontal" method="post" onsubmit="return confirm('Do you really want to Approve this cross notified case?')" action="<?php echo base_url(); ?>Investigation_forms/nnt_Approve">
        <input type="hidden" name="id" value="<?php echo $a-> id; ?>">
        <input type="hidden" name="cross_case_id" value="<?php echo $a-> cross_case_id; ?>" />
     <?php if(isset($a->rb_distcode) && $a->rb_distcode>0){ ?>
     <table id="rb_info" class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
      <thead>
        <tr>
          <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Case Refering Facility Information</th>
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
            <?php if(isset($a)){ echo CrossProvince_DistrictName($a -> rb_distcode);} ?>
          </td>            
        </tr>
        <tr>
          <td><p>Tehsil / City</p></td>
          <td>
            <?php if(isset($a)){ echo CrossProvince_TehsilName($a -> rb_tcode);} ?>
          </td>
          <td><p>Union Council</p></td>
          <td>
            <?php if(isset($a)){ echo CrossProvince_UCName($a -> rb_uncode);} ?>
          </td>
        </tr>
        <tr>
          <td><p>Name of Reporting Health Facility</p></td>
          <td>
            <?php if(isset($a)){ echo CrossProvince_FacilityName($a -> rb_facode);} ?>
          </td>
          <td><p>Address of Health Facility</p></td>
          <td>
            <?php if(isset($a)){ echo $a -> rb_faddress;} ?>
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
              <td><p>Name of Health Facility</p></td>
              <td><?php if(isset($a)){ echo CrossProvince_FacilityName($a -> facode);} ?></td>          
              <td><p>Reported From</p></td>
              <td><?php if(isset($a)){ echo $a -> reported_from;} ?></td>
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
						<input type="hidden" name="doses_received" value="<?php if(isset($a)){ echo $a -> doses_received;} ?>">
					<!--end-->
                  <select name="tcode" id="tcode" required="required" class="form-control">
                     <?php echo getTehsils_options(false,$a-> nnt_tcode,$a-> nnt_distcode); ?>
                  </select>
               </td>
               <td><p>Union Council <span style="color:red;">*</span></p></td>
               <td>
                  <select name="uncode" id="uncode" required="required" class="form-control">
                     <?php echo getUCs(false,$a-> nnt_uncode,$a-> nnt_tcode); ?>
                  </select>   
               </td>
            </tr>
            <tr>
              <td><p>Name of Health Facility</p></td>
              <td>
              <select name="facode" id="facode" required="required" class="form-control">
              <?php echo getFacilities_options(false,'',$a -> uncode); ?>
              </select>
              </td>
              <td><p style="color:#008d4c;">Select Health Facility and approve Below</p></td>
              <!-- <td></td> -->
            </tr>
          <?php } ?>
			       <td><p>Year</p></td>
              <td><?php if(isset($a)){ echo $a -> year;} ?></td>
              <td><p>Epid Week No</p></td>
              <td><?php if(isset($a)){ echo $a -> week;} ?></td>
			</tr>
			<tr>
			<td><p>Date From</p></td>
              <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> datefrom));} ?></td>
              <td><p>Date To</p></td>
              <td><?php if(isset($a)){ echo date('d-M-Y',strtotime($a -> dateto));} ?></td>
			</tr>
			<!-- <tr>
			<td><p>Case Reported</p></td>
              <td><?php echo isset($a)?(($a->case_reported=="0")?'No':'Yes'):''; ?></td> 
			</tr> -->
			<tr>
              <td><p>Date of notification</p></td>
              <td><?php if(isset($a) && $a -> date_notification !=""){ echo date('d-m-Y',strtotime($a -> date_notification));} ?></td>
              <td><p>Reported By</p></td>
              <td><?php if(isset($a)){ echo $a -> reported_by;} ?></td>
            </tr>
            <tr>
              <td><p>Mode of reporting</p></td>
              <td><?php if(isset($a)){ echo $a -> mode_reporting;} ?></td>
              <td><p>Active surveillance to the hospital</p></td>
              <td><?php echo isset($a)?(($a->active_sur_visit=="0")?'No':''):'';echo isset($a)?(($a->active_sur_visit=="1")?'Yes':''):''; ?></td>
            </tr>
            <tr>
              <td colspan="4" style="text-align:center;"><p>Passive Reporting</p></td>
            </tr>
            <tr>
              <td><p>Informed by telephone call/SMS</p></td>
              <td><?php echo isset($a)?(($a->informed_by_call=="0")?'No':''):'';echo isset($a)?(($a->informed_by_call=="1")?'Yes':''):''; ?></td>
             
              <td><p>Identified in weekly data</p></td>
              <td><?php echo isset($a)?(($a->identified_weekly_data=="0")?'No':''):'';echo isset($a)?(($a->identified_weekly_data=="1")?'Yes':''):''; ?></td>
            </tr>
            <tr>
              <td><p>Date of Investigation</p></td>
              <td><?php if(isset($a) && $a->date_investigation != ""){ if($a -> date_investigation != '1969-12-31') {echo date('d-m-Y',strtotime($a->date_investigation)); } } ?></td>
             
              <td><p>Place of Investigation</p></td>
              <td><?php if(isset($a)){ echo $a -> place_investigation;} ?></td>
            </tr>
            <tr>
              <td><p>Investigated by</p></td>
              <td><?php if(isset($a)){ echo $a -> investigated_by;} ?></td>
             
              <td><p>Date of notification at Federal level</p></td>
              <td><?php if(isset($a) && $a->date_notification_level != ""){ if($a -> date_notification_level != '1969-12-31') {echo date('d-m-Y',strtotime($a->date_notification_level)); } } ?></td>
            </tr>
			<tr>
			<td><p>Date of Onset</p></td>
			<td><?php if(isset($a) && $a -> date_onset !=  ""){ echo date('d-m-Y',strtotime($a -> date_onset));} ?></td>
			<td><p>Clinical Representation</p></td>
			<td><?php if(isset($a)){ echo $a -> clinical_representation;} ?></td>
			</tr>
            <tr>
              <td><p>Cases</p></td>
              <td><?php if(isset($a)){ echo $a -> cases;} ?></td>
             
              <td><p>Deaths</p></td>
              <td><?php if(isset($a)){ echo $a -> deaths;} ?></td>
            </tr>
            <tr>
              <td><p>Mothers Full name</p></td>
              <td><?php if(isset($a)){ echo $a -> full_mother_name;} ?></td>
             
              <td><p>Head of household full name</p></td>
              <td><?php if(isset($a)){ echo $a -> head_full_name;} ?></td>
            </tr>
             <tr>                           
              <td><p>Baby date of birth</p></td>
              <td><?php if(isset($a) && $a -> baby_dob != ""){ echo date('d-m-Y',strtotime($a -> baby_dob));} ?></td>
              <td><p>Gender</p></td>
              <td><?php if(isset($a)){ echo $a -> gender;} ?></td>
            </tr>
            <tr>
               
              <td><p>Ethnic group</p></td>
              <td><?php if(isset($a)){ echo $a -> ethnic_group;} ?></td>
			  <td><p>Contact Number</p></td>
               <td><?php if(isset($a)){ echo $a -> contact_numb;} ?></td>
              <td></td>
              <td></td>
            </tr>
            <!-- <tr>
             <td><p>Province</p></td>
             <td>KPK</td>
    			  <td><p>District</p></td>
             <td><?php echo isset($a -> nnt_distcode) ? CrossProvince_DistrictName($a -> nnt_distcode) : '' ; ?></td>
             
            </tr>
			   <tr>
              <td><p>Tehsil/City</p></td>
              <td><?php echo isset($a -> nnt_tcode) ? CrossProvince_TehsilName($a -> nnt_tcode) : '' ; ?></td>            
              <td><p>Union Council</p></td>
              <td><?php echo isset($a -> nnt_uncode) ? CrossProvince_UCName($a -> nnt_uncode) : '' ; ?></td>              
            </tr>
            <tr>
			      <td><p>Name of Health Facility</p></td>
              <td><?php echo isset($a -> nnt_facode) ? CrossProvince_FacilityName($a -> nnt_facode) : '' ; ?></td>              
               <td><p>Household full address</p></td>
              <td><?php if(isset($a)){ echo $a -> house_hold_address;} ?></td>
            </tr>         -->    
          </tbody>
        </table>
        <table class="table table-bordered table-striped table-hover mytable2 mytable3">
           <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Address of Patient</th>
            </tr>
         </thead>
         <tbody> 
           <tr>
             <td><p>Province</p></td>
             <td>              
                  <?php if(isset($a) && ($a -> procode != NULL)) {echo get_Province_Name($a-> procode);} ?>              
               </td>
              <td><p>District</p></td>
             <td><?php echo isset($a -> nnt_distcode) ? CrossProvince_DistrictName($a -> nnt_distcode) : '' ; ?></td>
             
            </tr>
            <tr>
              <td><p>Tehsil/City</p></td>
              <td><?php echo isset($a -> nnt_tcode) ? CrossProvince_TehsilName($a -> nnt_tcode) : '' ; ?></td>            
              <td><p>Union Council</p></td>
              <td><?php echo isset($a -> nnt_uncode) ? CrossProvince_UCName($a -> nnt_uncode) : '' ; ?></td>              
            </tr>
            <?php if($a-> cross_notified == 1) { ?>
                <tr>                               
                  <td><p>Household full address</p></td>
                  <td><?php if(isset($a)){ echo $a -> house_hold_address;} ?></td>
               </tr>
            <?php } else { ?>
               <tr>
                  <td><p>Name of Health Facility</p></td>
                  <td><?php echo isset($a -> nnt_facode) ? CrossProvince_FacilityName($a -> nnt_facode) : '' ; ?></td>              
                  <td><p>Household full address</p></td>
                  <td><?php if(isset($a)){ echo $a -> house_hold_address;} ?></td>
               </tr>  
            <?php } ?>         
         </tbody>
      </table>
        <table class="table table-bordered table-striped table-hover mytable2 mytable3" style="width:100%">
          <thead>
            <tr>
              <th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Mothers Immunization Status</th> 
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="width:30%"><p>Total number of TT doses received by the mother</p></td>
              <td style="width:30%"><?php if(isset($a)){ echo $a -> doses_received;} ?></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td><p>Is her immunization history reported by</p></td>
              <td colspan="3" style="padding-top:7px;">
                <table style="width:100%;margin-top: 7px;">
                  <tr>
                    <td><?php if(isset($a)){ if($a -> immunization_history == '0'){ echo "None"; } if($a -> immunization_history == '1') { echo "Doses"; } if($a -> immunization_history == '2') { echo "Card"; } if($a -> immunization_history == '3') { echo "Memory"; } if($a -> immunization_history == '4') { echo "Card & Memory"; } if($a -> immunization_history == '5') { echo "Unknown"; }} ?></td>
                  </tr>
                </table>
              </td>              
            </tr>
            <tr>
              <td><p>If she has a card, copy the dates of all TT immunizations recorded on the card</p></td>
              <td colspan="3"> 
                <table style="width:100%">
                  <tr>
                    <td>1- </td>
                    <td><?php if(isset($a) && $a->card_date1 !=""){ if($a -> card_date1 != '1969-12-31') {echo date('d-m-Y',strtotime($a->card_date1)); } } ?></td>
                    <td>2- </td>
                    <td><?php if(isset($a) && $a->card_date2 !=""){ if($a -> card_date2 != '1969-12-31') {echo date('d-m-Y',strtotime($a->card_date2)); } } ?></td>
                    <td>3- </td>
                    <td><?php if(isset($a) && $a->card_date3 !=""){ if($a -> card_date3 != '1969-12-31') {echo date('d-m-Y',strtotime($a->card_date3)); } } ?></td>
                    <td>4- </td>
                    <td><?php if(isset($a) && $a->card_date4 !=""){ if($a -> card_date4 != '1969-12-31') {echo date('d-m-Y',strtotime($a->card_date4)); } } ?></td>
                    <td>5- </td>
                    <td><?php if(isset($a) && $a->card_date5 !=""){ if($a -> card_date5 != '1969-12-31') {echo date('d-m-Y',strtotime($a->card_date5)); } } ?></td>
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped table-hover mytable2 mytable3" style="width:100%">
          <thead>
            <tr>
              <th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Mother's Antenatal Care</th>
            </tr>
          </thead>
          <tbody>
             <tr>
              <td colspan="2"><p>How many visits did the mother make to a health facility during her pregnancy?</p></td>
              <td><?php if(isset($a)){ echo $a -> pregnancy_visits;} ?></td>
              <td><p>Visits</p></td>
            </tr>
            <tr>
              <td><p>List health facilities she visited</p></td>
              <td><p style="display: inline;">1-</p><?php if(isset($a)){ echo CrossProvince_FacilityName($a -> facode1);} ?></td>
              <td><p style="display: inline;">2-</p><?php if(isset($a)){ echo CrossProvince_FacilityName($a -> facode2);} ?></td>
              <td><p style="display: inline;">3-</p><?php if(isset($a)){ echo CrossProvince_FacilityName($a -> facode3);} ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped table-hover mytable2 mytable3" style="width:100%">
          <thead>
            <tr>
              <th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Delivery Practice</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p>Where was the baby delivered?</p></td>
              <td><?php if(isset($a)){ echo $a -> where_baby_delivered;} ?></td>
              <td><p>How was the cord stump treated or dresses?</p></td>
              <td><?php if(isset($a)){ echo $a -> cord_treated;} ?></td>
            </tr>
            <tr>
              <td><p>If the delivery was in health facility, record the facility name and address</p></td>
              <td><?php if(isset($a)){ echo CrossProvince_FacilityName($a -> n_facode);} ?></td>
              <td colspan="2"><?php if(isset($a)){ echo $a -> address;} ?></td>
            </tr>
            <tr>
              <td><p>Medical record number</p></td>
              <td><?php if(isset($a)){ echo $a -> med_record_number;} ?></td>
              <td><p>Date of admission</p></td>
              <td><?php if(isset($a) && $a->date_admission !=""){ if($a -> date_admission != '1969-12-31') {echo date('d-m-Y',strtotime($a->date_admission)); } } ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped table-hover mytable2 mytable3" style="width:100%">
          <thead>
            <tr>
              <th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Baby's Symptoms</th>
            </tr>
          </thead>
          <tbody>
             <tr>
              <td><p>Was the baby normal at birth?</p></td>
              <td><?php if(isset($a)){ echo $a -> bs_normal_birth;} ?></td>
              <td><p>How old (in days) was the baby when symptoms began?</p></td>
              <td>
                <table style="width:100%">
                  <tr>
                  <td><?php if(isset($a) && ($a -> bs_days_unknown == '0')){ echo $a -> bs_days;} ?></td>
                  <td><?php if(isset($a) && ($a -> bs_days_unknown == '1')){ echo "Unknown";} ?></td>
                </table>
              </td>
            </tr>
            <tr>
              <td><p>Baby had normal cry and suck during first 2 days?</p></td>
              <td><?php if(isset($a)){ echo $a -> bs_cry;} ?></td>
              <td><p>Baby stopped sucking after 2 days?</p></td>
              <td><?php if(isset($a)){ echo $a -> bs_stop_sucking;} ?></td>   
            </tr>
            <tr>
              <td><p>Stiffness</p></td>
              <td><?php if(isset($a)){ echo $a -> bs_stiffness;} ?></td>
              <td><p>Spasms or convulsions</p></td>
              <td><?php if(isset($a)){ echo $a -> bs_spasms;} ?></td>   
            </tr>
            <tr>
              <td><p>Was case confirmed as neonatal tetanus</p></td>
              <td><?php if(isset($a)){ echo $a -> bs_case_confirmed;} ?></td>
              <td><p>If yes to last 4 statements, tick Yes to show case confirmed as Neonaltal Tetanus</p></td>
              <td  style="padding-top: 12px;"><?php if(isset($a) && $a -> nnt_confirmed){ ?> &#10004; Yes, Case is Neonatal Tetanus <?php } else { ?> &#x2717; No, Case is Not Neonatal Tetanus<?php } ?></td>   

            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped table-hover mytable2 mytable3" style="width:100%">
          <thead>
            <tr>
              <th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Treatment</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p>Was sick baby cared for in a health facility?</p></td>
              <td><?php if(isset($a)){ echo $a -> tr_cared;} ?></td>
              <td><p>If yes, record the name of health facility and district</p></td> 
              <td>
                <table style="width:100">
                  <tr>
                    <td><?php if(isset($a)){ echo CrossProvince_FacilityName($a -> tr_facode);} ?>, <?php if(isset($a)){ echo CrossProvince_DistrictName($a -> tr_distcode);} ?></td>
                  </tr>
                </table>
            </td>   
            </tr>
            <tr>
              <td><p>Did the sick baby die</p></td>
              <td><?php if(isset($a)){ echo $a -> tr_baby_died;} ?></td>
              <td><p>If died , date of death</p></td> 
              <td><?php if(isset($a) && $a->b_death_date != ""){ if($a -> b_death_date != '1969-12-31') {echo date('d-m-Y',strtotime($a->b_death_date)); } } ?></td>   
            </tr>
            <tr>
              <td><p>Did the mother die</p></td>
              <td><?php if(isset($a)){ echo $a -> tr_mother_died;} ?></td>
              <td><p>If died , date of death</p></td> 
              <td><?php if(isset($a) && $a->m_death_date != ""){ if($a -> m_death_date != '1969-12-31') {echo date('d-m-Y',strtotime($a->m_death_date)); } } ?></td>   
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped table-hover mytable2 mytable3" style="width:100%">
          <thead>
            <tr>
              <th colspan="4" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Case Response</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p>Mother immunized in response to NT?</p></td>
              <td><?php if(isset($a)){ echo $a -> cr_mother_immunized;} ?></td>
              <td><p>If yes, date of Immunization </p></td>
              <td><?php if(isset($a) && $a->cr_immunized_date != ""){ if($a -> cr_immunized_date != '1969-12-31') {echo date('d-m-Y',strtotime($a->cr_immunized_date)); } } ?></td>
            </tr>
            <tr>
              <td><p>Did a case response take place in her locality?</p></td>
              <td><?php if(isset($a)){ echo $a -> cr_case_response;} ?></td>
              <td><p>If yes, number of women vaccinated </p></td>
              <td><?php if(isset($a)){ echo $a -> cr_numb_women_vaccinated;} ?></td>
            </tr>
            <tr>
              <td><p>Was an active case search done?</p></td>
              <td><?php if(isset($a)){ echo $a -> cr_case_search;} ?></td>
              <td><p>Number of NT cases with onset within the past 12 months identified during active case search in the community </p></td>
              <td><?php if(isset($a)){ echo $a -> cr_numb_nt_cases;} ?></td>
            </tr>
            <tr>
              <td><p>Health education imparted regarding vaccine importance and clean delivery practice from health worker</p></td>
              <td><?php if(isset($a)){ echo $a -> cr_vaccine_importance;} ?></td>
              <td><p>Follow up visit</p></td>
              <td><?php if(isset($a)){ echo $a -> follow_up_visits;} ?></td>
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
          	<td><p><?php if(isset($a) && $a->editted_date != ""){ echo date('d-m-Y',strtotime($a->editted_date)); } else { if($a->submitted_date != ""){ echo date('d-m-Y',strtotime($a->submitted_date)); } }  ?></p></td>
          </tr>
         </tbody>
        </table>
        <div class="row">
         <hr>
		 <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
              <?php if($a->cross_notified != 1){ ?>
              <a href="<?php echo base_url(); ?>NNT-CIF/Edit/<?php echo $a->id; ?>" style="background:#008d4c;" class="btn btn-primary btn-md"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <?php }else if($a->cross_notified == 1 && $a->distcode == $this -> session -> District && $a->approval_status != "Approved"){ ?>
              <button style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-check"></i> Approve Case</button>
              <?php 
              $this->session->set_flashdata('redirectToCurrent', current_url());
              } ?>

              <a href="<?php echo base_url(); ?>NNT-CIF/List" style="background:#008d4c;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
		 <?php } ?>
        </div> 
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->

<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
 <!--fortooltip-->
 <script type="text/javascript">
  
$("#show").change(function(){
   if($(this).val()=="1")
   {    
       $(".hideshowtd").show();
   }
    else
    {
        $(".hideshowtd").hide();
    }
});
</script>
  



<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

<!--for navbar fixed at top-->
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

var pos = $('#nav').offset().top;
var nav = $('#nav');
$(window).scroll(function () {
        if ($(this).scrollTop() > pos) {
            nav.addClass("f-nav");
        } else {
            nav.removeClass("f-nav");
        }
    });
</script>
<script type="text/javascript">
  $(function () {
    var options = {
      format : "dd-mm-yyyy",
      startDate : "01-01-1925",
      endDate: "12-12-2000"
    };   
    $('#date_of_birth').datepicker(options);
    var options = {
      format : "dd-mm-yyyy"

    };
    $('.dp').datepicker(options);    
  });
</script>
</body>
</html>