<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> AEFI Case Investigation Form</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover    ">
          <tbody>
             <tr>
              <td colspan="4">
                <table>
                  <tr>
                    <td style="width: 20%;"><label style="padding-top: 5px;">EPID Number</label></td>
                    <td style="text-align: right; width: 10%;"><label style="padding-top: 5px;"><?php if(isset($a)){ echo $a->case_epi_no; } ?></label></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>Date AEFI reported</td>
              <td><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->date_reported));} ?></td>
              <td>Date investigation started</td>
              <td><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->date_investigation_started));} ?></td>
             </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Demographic data of the patient</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Name of the child</td>
              <td><?php if(isset($a)){ echo $a -> child_name;} ?></td>
              <td>Date of Birth/Age</td>
              <td><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->dob));} ?></td>
             </tr>
            <tr>
              <td>Gender</td>
              <td>
                <?php if(isset($a)){ echo $a -> gender;} ?>
              </td>
              <td>Name and cast of Father</td>
              <td> <?php if(isset($a)){ echo $a -> name_cast_father;} ?></td>
            </tr>
            <tr>
              <td>Address House/Street No</td>
              <td> <?php if(isset($a)){ echo $a -> address;} ?>
              </td>
              <td>Village</td>
              <td> <?php if(isset($a)){ echo $a -> village;} ?></td>
            </tr>
            <tr>
              <td>Union Council</td>
              <td> <?php if(isset($a)){ echo $a -> uncode;} ?>
              </td>
              <td>Tehsil/Tauka/Town</td>
              <td> <?php if(isset($a)){ echo $a -> tcode;} ?>
            </tr>
            <tr>
              <td>District</td>
              <td> <?php if(isset($a)){ echo $a -> distcode;} ?>
              </td>
             <td>Contact No</td>
              <td> <?php if(isset($a)){ echo $a -> contact_no;} ?>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Most Recent Immunization History</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Date and time of vaccine</td>
              <td><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->datetime_vaccination));} ?></td>
              <td>Vaccine & dose number</td>
              <td><?php if(isset($a)){ echo $a -> vacc_and_dose_no;} ?></td>
            </tr>
            <tr>
              <td>Site of administration</td>
              <td><?php if(isset($a)){ echo $a -> site_administration;} ?></td>
              <td>Vaccination center</td>
              <td><?php if(isset($a)){ echo $a -> vaccination_center;} ?></td>
            </tr>
            <tr>
              <td>Vaccinated by</td>
              <td><?php if(isset($a)){ echo $a -> vaccinated_by;} ?></td>
              <td> </td>
              <td> </td>
            </tr>             
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Information about the vaccines and diluents administered to the patient</th>
            </tr>
          </thead>
          <tbody>
             <tr>
              <td>
                <table style="width:100%;" class="table table-bordered   table-striped table-hover    ">
                  <tr>
                    <td style="text-align:center;">Vaccines</td>
                    <td style="text-align:center;">Manufacturer</td>
                    <td style="text-align:center;">Lot no./batch no</td>
                    <td style="text-align:center;">Expiry Date</td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r1_name;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r1_f1;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r1_f2;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->vacc_r1_f3));} ?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r2_name;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r2_f1;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r2_f2;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->vacc_r2_f3));} ?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r3_name;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r3_f1;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r3_f2;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->vacc_r3_f3));} ?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r4_name;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r4_f1;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> vacc_r4_f2;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->vacc_r4_f3));} ?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;">Diluents</td>
                    <td style="text-align:center;">Manufacturer</td>
                    <td style="text-align:center;">Lot no./batch no</td> 
                    <td style="text-align:center;">Expiry Date</td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> dil_r1_name;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> dil_r1_f1;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> dil_r1_f2;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->dil_r1_f3));} ?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> dil_r2_name;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> dil_r2_f1;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo $a -> dil_r2_f2;} ?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->dil_r2_f3));} ?></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
            </tr>          
          </tbody> 
        </table>
        
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="3" style="text-align:center;vertical-align: middle;">Suspected vaccine which cased AEFI</th>
              <td><?php if(isset($a)){ echo $a -> suspected_vaccine;} ?></td>
            </tr>
          </thead>
          <tbody>
                          
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;vertical-align: middle;">Describe the adverse event in detail</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4"><?php if(isset($a)){ echo $a -> adv_evt_detail;} ?></td>
            </tr>
            <tr>
              <td>H/O present illness</td>
              <td colspan="3"><?php if(isset($a)){ echo $a -> ho_present_illness;} ?></td>
            </tr>
            <tr>
              <td>Date of onset of AEFI</td>
              <td><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->date_onset));} ?></td>
              <td>Time of onset of AEFI</td>
              <td><?php if(isset($a)){ echo date('g:i a',strtotime($a->time_onset));} ?></td>
            </tr>
            <tr>
              <td>Date of hospitalization</td>
              <td><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->date_hospitalization));} ?></td>
              <td>Time of hospitalization</td>
              <td><?php if(isset($a)){ echo date('g:i a',strtotime($a->time_hospitalization));} ?></td>
            </tr>
            <tr>
              <td>Date of death</td>
              <td><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->date_death));} ?></td>
              <td>Time of death</td>
              <td><?php if(isset($a)){ echo date('g:i a',strtotime($a->time_death));} ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Examination Findings</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Pulse</td>
              <td><?php if(isset($a)){ echo $a -> pulse;} ?><span> (/min)</span></td>
              <td>Temp</td>
              <td><?php if(isset($a)){ echo $a -> temp;} ?><span style="vertical-align: text-bottom;"> o</span><span>F</span> </td>
            </tr>
            <tr>
              <td>BP</td>
              <td><?php if(isset($a)){ echo $a -> bp;} ?><span> mm of Hg</span></td>
              <td>Heart Rate</td>
              <td><?php if(isset($a)){ echo $a -> heart_rate;} ?><span> /min</span></td>
            </tr>
            <tr>
              <td>Resp Rate</td>
              <td><?php if(isset($a)){ echo $a -> resp_rate;} ?><span> /min</span></td>
              <td>Lungs (wheeze, creps, ronchi)</td>
              <td><?php if(isset($a)){ echo $a -> lungs;} ?></td>
            </tr>
            <tr>
              <td>Skin change</td>
              <td><?php if(isset($a)){ echo $a -> skin_change;} ?></td>
              <td>Size of skin lesion</td>
              <td><?php if(isset($a)){ echo $a -> size_skin_lesion;} ?><span> cm</span></td>
            </tr>
            <tr>
              <td>Cyanosis</td>
              <td><?php if(isset($a)){ echo $a -> cyanosis;} ?></td>
              <td>Pupil (reaction to light)</td>
              <td><?php if(isset($a)){ echo $a -> pupil;} ?></td>
            </tr>
            <tr>
              <td>Kernig's sign</td>
              <td><?php if(isset($a)){ echo $a -> kernigs_sign;} ?></td>
              <td>Neck stiffness</td>
              <td><?php if(isset($a)){ echo $a -> neck_stiffness;} ?></td>
            </tr>
            <tr>
              <td>Level of Consciousness</td>
              <td><?php if(isset($a)){ echo $a -> level_consciousness;} ?></td>
              <td>Lymph Node</td>
              <td><?php if(isset($a)){ echo $a -> lymph_node;} ?></td>
            </tr>
            <tr>
              <td>Jerks</td>
              <td><?php if(isset($a)){ echo $a -> jerks;} ?></td>
              <td>Cranial nerve abnormality</td>
              <td><?php if(isset($a)){ echo $a -> cranial_nerve_abnormality;} ?></td>
            </tr>
            <tr>
              <td colspan="1"><label>Other Abnormal Signs (if any)</label></td>
              <td colspan="3"><?php if(isset($a)){ echo $a -> other_abnormal_signs;} ?></td>
            </tr>
            <tr>
              <td colspan="1"><label>Treatment</label></td>
              <td colspan="3"><?php if(isset($a)){ echo $a -> treatment;} ?></td>
            </tr>
            <tr>
              <td colspan="1"><label>Provisional Diagnosis</label></td>
              <td colspan="3"><?php if(isset($a)){ echo $a -> provisional_diagnosis;} ?></td>
            </tr>
            <tr>
              <td colspan="1"><label>Outcome</label></td>
              <td colspan="3"><?php if(isset($a)){ echo $a -> outcome;} ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Additional information about the patient: (write yes or no, if yes please specify)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Past H/O similar events</td>
              <td><?php if(isset($a)){ echo $a -> past_similar_event;} ?></td>
            </tr>
            <tr>
              <td>Reaction after previous vaccination</td>
              <td><?php if(isset($a)){ echo $a -> reaction_previous_vaccination;} ?></td>
            </tr>
            <tr>
              <td>H/O allergy</td>
              <td><?php if(isset($a)){ echo $a -> no_allergy;} ?></td>
            </tr>
            <tr>
              <td>Pre-existing illness/disorder</td>
              <td><?php if(isset($a)){ echo $a -> pre_existing;} ?></td>
            </tr>
            <tr>
              <td>Current medication (for other than AEFI)</td>
              <td><?php if(isset($a)){ echo $a -> current_medication;} ?></td>
            </tr>
            <tr>
              <td>H/O hospitalization in last 30 days with cause</td>
              <td><?php if(isset($a)){ echo $a -> ho_hosp_cause;} ?></td>
            </tr>
            <tr>
              <td>Recent H/O trauma with date, time, site and mode</td>
              <td><?php if(isset($a)){ echo $a -> recent_ho_trauma;} ?></td>
            </tr>
            <tr>
              <td>Family history of any disease or allergy</td>
              <td><?php if(isset($a)){ echo $a -> family_history;} ?></td>
            </tr>
            <tr>
              <td colspan="4"><label>Community investigation</label></td>
            </tr>
            <tr>
              <td>No. of cases immunized with suspected vaccine in same session</td>
              <td><?php if(isset($a)){ echo $a -> no_cases_immunized;} ?></td>
            </tr>
            <tr>
              <td>No. of cases of same adverse events found in immunized children/women</td>
              <td><?php if(isset($a)){ echo $a -> no_cases_sae_immunized;} ?></td>
            </tr>
            <tr>
              <td>No. of cases of same adverse events found in non-immunized population</td>
              <td><?php if(isset($a)){ echo $a -> no_cases_sae_non_immunized;} ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">EPI Management Practice: (fill up this section by asking and observing practice) write yes or no where applicable, if yes please specify)</th>
            </tr>
          </thead>
          <tbody>
            <tr><td colspan="4"><label>EPI store</label></td></tr>
            <tr>
              <td><p style="display: inline-block;">Temp inside ILR (<p style="display: inline; vertical-align: top;">  oC)</td>
              <td><?php if(isset($a)){ echo $a -> store_temp_inside_ilr;} ?></td>
            </tr>
            <tr>
              <td><p style="display: inline-block;">Temp of freezer (<p style="display: inline; vertical-align: top;">  oC)</td>
              <td><?php if(isset($a)){ echo $a -> store_temp_freezer;} ?></td>
            </tr>
            <tr>
              <td>Correct procedure of storing vaccines, diluents and syringes followed</td>
              <td><?php if(isset($a)){ echo $a -> store_correct_procedure;} ?></td>
            </tr>
            <tr>
              <td>Any other object (other than EPI vaccines and diluents) in the ILR or freezer</td>
              <td><?php if(isset($a)){ echo $a -> store_other_object_in_ilr;} ?></td>
            </tr>
            <tr>
              <td>Partially used reconstituted vaccines in the ILR</td>
              <td><?php if(isset($a)){ echo $a -> store_reconstituted_vaccines;} ?></td>
            </tr>
            <tr>
              <td>Unusable vaccines (expired, no label, VVM stage 3&4, Frozen) in the ILR</td>
              <td><?php if(isset($a)){ echo $a -> store_unusable_vaccine;} ?></td>
            </tr>
            <tr>
              <td>Unusable diluents (expired, manufacturer not matched, cracked, dirty ampoule) in the store</td>
              <td><?php if(isset($a)){ echo $a -> store_unusable_diluents;} ?></td>
            </tr>
            <tr><td colspan="4"><label>Transportation</label></td></tr>
            <tr>
              <td>Type of vaccine carrier used</td>
              <td><?php if(isset($a)){ echo $a -> trans_type_vacc_carrier_used;} ?></td>
            </tr>
            <tr>
              <td>Vaccine carrier packed properly</td>
              <td><?php if(isset($a)){ echo $a -> trans_vaccine_carrier_packed;} ?></td>
            </tr>
            <tr>
              <td>Vaccine carrier sent to the EPI site on the same day of vaccination</td>
              <td><?php if(isset($a)){ echo $a -> trans_vaccine_carrier_sent;} ?></td>
            </tr>
            <tr>
              <td>Vaccine carrier returned from the EPI site on the same day of vaccination</td>
              <td><?php if(isset($a)){ echo $a -> trans_vacc_carrier_from_epi;} ?></td>
            </tr>
            <tr>
              <td>Conditioned ice-pack used</td>
              <td><?php if(isset($a)){ echo $a -> trans_conditioned_icepack;} ?></td>
            </tr>
            <tr><td colspan="4"><label>Reconstitution</label></td></tr>
            <tr>
              <td>Correct procedure followed</td>
              <td><?php if(isset($a)){ echo $a -> rec_procedure_followed;} ?></td>
            </tr>
            <tr>
              <td>Correct amount of diluent used</td>
              <td><?php if(isset($a)){ echo $a -> rec_correct_amount_diluent;} ?></td>
            </tr>
            <tr>
              <td>Used separate syringe for each vial</td>
              <td><?php if(isset($a)){ echo $a -> rec_used_separate_syringe;} ?></td>
            </tr>
            <tr>
              <td>Matching diluent used</td>
              <td><?php if(isset($a)){ echo $a -> rec_matching_diluent_used;} ?></td>
            </tr>
            <tr><td colspan="4"><label>Injection technique</label></td></tr>
            <tr>
              <td>Correct dose and route</td>
              <td><?php if(isset($a)){ echo $a -> inj_correct_dose_rate;} ?></td>
            </tr>
            <tr>
              <td>Non-touch technique followed</td>
              <td><?php if(isset($a)){ echo $a -> inj_non_touch_techniques;} ?></td>
            </tr>
            <tr>
              <td>Vial shaked before each injection</td>
              <td><?php if(isset($a)){ echo $a -> inj_vial_shaked_before_inj;} ?></td>
            </tr>
            <tr>
              <td>Contraindication assessed</td>
              <td><?php if(isset($a)){ echo $a -> inj_contraindication_assessed;} ?></td>
            </tr>
            <tr>
              <td>How many AEFI reported from vaccination sites of the same worker in last 30 days?</td>
              <td><?php if(isset($a)){ echo $a -> inj_aefi_reported_last30_days;} ?></td>
            </tr>
            <tr>
              <td>Training on EPI received by the vaccinator (specify the last training including date)</td>
              <td><?php if(isset($a)){ echo $a -> inj_training_by_vaccinator;} ?></td>
            </tr>
            <tr>
              <td><label>Laboratory investigation(s) conducted? (if yes, mention the tests)</label></td>
              <td><?php if(isset($a)){ echo $a -> lab_inv_conducted;} ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Assessment</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <table style="width:100%;" class="table table-bordered   table-striped table-hover    ">
                  <tr><td colspan="5">Conclusion about cause of AEFI (tick categories, rank if more than one cause)</td></tr>
                  <tr>
                    <td style="text-align:center;">Programme error</td>
                    <td style="text-align:center;">Vaccine Reaction</td>
                    <td style="text-align:center;">Coincidental</td>
                    <td style="text-align:center;">Injection Reaction</td>
                    <td style="text-align:center;">Unknown</td>
                  </tr>
                  <tr>
                    <td> Non-sterile injection <?php if(isset($a)){ if($a -> pe_f1 == '0'){ echo "&#10006"; }else{if($a -> pe_f1 == '1') { echo "&#10004"; } } }?></td>
                    <td> Known vaccine reaction at expected rate <?php if(isset($a)){ if($a -> vcr_f1 == '0'){ echo "&#10006"; }else{if($a -> vcr_f1 == '1') { echo "&#10004"; } } }?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ if($a -> coincidental == '0'){ echo "&#10006"; }else{if($a -> coincidental == '1') { echo "&#10004"; } } }?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ if($a -> inj_reaction == '0'){ echo "&#10006"; }else{if($a -> inj_reaction == '1') { echo "&#10004"; } } }?></td>
                    <td style="text-align:center;"><?php if(isset($a)){ if($a -> unknown == '0'){ echo "&#10006"; }else{if($a -> unknown == '1') { echo "&#10004"; } } }?></td>
                  </tr>
                  <tr>
                    <td>Vaccine prepared incorrectly <?php if(isset($a)){ if($a -> pe_f2 == '0'){ echo "&#10006"; }else{if($a -> pe_f2 == '1') { echo "&#10004"; } } }?></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td>Faulty administration technique/site <?php if(isset($a)){ if($a -> pe_f3 == '0'){ echo "&#10006"; }else{if($a -> pe_f3 == '1') { echo "&#10004"; } } }?></td>
                    <td>Vaccine lot problem <?php if(isset($a)){ if($a -> vcr_f2 == '0'){ echo "&#10006"; }else{if($a -> vcr_f2 == '1') { echo "&#10004"; } } }?></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td>Faulty vaccine transportation <?php if(isset($a)){ if($a -> pe_f4 == '0'){ echo "&#10006"; }else{if($a -> pe_f4 == '1') { echo "&#10004"; } } }?></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td>Faulty vaccine storage <?php if(isset($a)){ if($a -> pe_f5 == '0'){ echo "&#10006"; }else{if($a -> pe_f5 == '1') { echo "&#10004"; } } }?></td>
                    <td>others <?php if(isset($a)){ if($a -> vcr_f3 == '0'){ echo "&#10006"; }else{if($a -> vcr_f3 == '1') { echo "&#10004"; } } }?></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td>Other <?php if(isset($a)){ if($a -> pe_f6 == '0'){ echo "&#10006"; }else{if($a -> pe_f6 == '1') { echo "&#10004"; } } }?></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                  </tr>
                  <tr>
                    <td>Confidence about conclusion on main cause of AEFI</td>
                    
                    <td style="text-align:center;"><?php if($a -> confidence_conclusion == 'Certain') { echo "Certain"; } else{ if($a -> confidence_conclusion == 'Probable') { echo "Probable"; } else { if ($a -> confidence_conclusion == 'Possible') { echo "Possible"; } else{if ($a -> confidence_conclusion == '0') { echo "None"; }}  } } ?></td>
                    <td style="text-align:center;" colspan="3"></td>
                  </tr>
                  <tr>
                    <td>Reason(s) for conclusion</td>
                    <td style="text-align:center;" colspan="4"><?php if(isset($a)){ echo $a -> conclusion_reason;} ?></td>
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Corrective Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="text-align:center;" colspan="4"><?php if(isset($a)){ echo $a -> recommendation;} ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Additional Notes</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="text-align:center;" colspan="4"><?php if(isset($a)){ echo $a -> additional_notes;} ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    ">
          <thead>
            <tr>
              <th colspan="5" style="text-align:center;">Investigation Team Details</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Name</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r1_name;} ?></td>
              <td>Designation</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r1_desg;} ?></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Name</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r2_name;} ?></td>
              <td>Designation</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r2_desg;} ?></td>
            </tr>
            <tr>
              <td>3</td>
              <td>Name</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r3_name;} ?></td>
              <td>Designation</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r3_desg;} ?></td>
            </tr>
            <tr>
              <td>4</td>
              <td>Name</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r4_name;} ?></td>
              <td>Designation</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r4_desg;} ?></td>
            </tr>
            <tr>
              <td>5</td>
              <td>Name</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r5_name;} ?></td>
              <td>Designation</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r5_desg;} ?></td>
            </tr>
            <tr>
              <td>6</td>
              <td>Name</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r6_name;} ?></td>
              <td>Designation</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r6_desg;} ?></td>
            </tr>
            <tr>
              <td>7</td>
              <td>Name</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r7_name;} ?></td>
              <td>Designation</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo $a -> itd_r7_desg;} ?></td>
            </tr>
            <tr>
              <td>Date Investigation Completed</td>
              <td style="text-align:center;"><?php if(isset($a)){ echo date('d-m-Y',strtotime($a->date_investigation_completed));} ?></td>
              <td colspan="3"> </td>
            </tr>
          </tbody>
        </table>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a href="<?php echo base_url(); ?>AEFI-CIF/Edit/<?php echo $a->id; ?>" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>        
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->
