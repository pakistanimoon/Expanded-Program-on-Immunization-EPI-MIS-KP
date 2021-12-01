<!--start of page content or body-->
 
 <div class="container bodycontainer">
  
<div class="row">
	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
 <div class="panel panel-primary">
   <div class="panel-heading"> Management Of EPI Vaccines In Routine Immunization</div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>data_entry/manage_epi_vacc_save">
		<?php if(isset($vaccManagment)){ ?>
		<input type="hidden" name="recid" id="recid" value="<?php echo $vaccManagment->recid; ?>"  />
		<?php } ?>
        <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>Month:</label>
          </div>
          <div class="col-md-2 col-sm-2">
          	<select name="month" id="month" class="form-control">
          	<?php if(isset($vaccManagment)){
          		?><option value="<?php echo $vaccManagment->month; ?>"><?php echo monthname($vaccManagment->month); ?></option><?php
          	}else{ ?>
            <?php echo $months; 
            } ?>
            </select>
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>Year:</label>
          </div>
          <div class="col-md-2 col-sm-2">
            <select id="year" name="year" class="form-control">
            <?php if(isset($vaccManagment)){
            ?><option value="<?php echo $vaccManagment->year; ?>"><?php echo $vaccManagment->year; ?></option><?php
          	}else{ ?>
            <?php echo $years; 
            } ?>
            </select>
          </div>
        </div>
          <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>Union Council:</label>
          </div>
          <div class="col-md-2 col-sm-2">
            <select id="uncode" name="uncode" class="form-control">
            <?php if(isset($vaccManagment)){
            ?><option value="<?php echo $vaccManagment->uncode; ?>"><?php echo $unioncouncil; ?></option><?php
          	}else{  } ?>
            </select>
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Total Population:</label>
          </div>
          <div class="col-md-2 col-sm-2">
            <input class="form-control numberclass" name="uc_tot_pop" id="uc_tot_pop" value="<?php if(isset($vaccManagment)){ echo $vaccManagment->uc_tot_pop; }else{ echo '0'; } ?>" placeholder="Number" type="number">            
          </div>
        </div>
          <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>District:</label>
          </div>
          <div class="col-md-2 col-sm-2">
            <select id="distcode" name="distcode" class="form-control">
            <?php if(isset($vaccManagment)){
            ?><option value="<?php echo $vaccManagment->distcode; ?>"><?php echo $district; ?></option><?php
          	}else{ ?>
              <?php echo getDistricts_options(true); 
			} ?>
            </select>
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Annual Target Population (Children &lt;1 Year):</label>
          </div>
          <div class="col-md-2 col-sm-2">
            <input class="form-control numberclass" name="uc_annual_pop_less_1year" id="uc_annual_pop_less_1year" value="<?php if(isset($vaccManagment)){ echo $vaccManagment->uc_annual_pop_less_1year; } else { if(validation_errors() != false) { echo set_value('uc_annual_pop_less_1year'); } else{ echo '0'; } } ?>" placeholder="Number" type="number">
          </div>
        </div>

            <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>Names of Vaccinators:</label>
          </div>
          <div class="col-md-2 col-sm-2">
            <input class="form-control" name="vaccinators_names" id="vaccinators_names" placeholder="Names of Vaccinators" value="<?php if(isset($vaccManagment)){ echo $vaccManagment->vaccinators_names; }else { if(validation_errors() != false) { echo set_value('vaccinators_names'); } else{ } } ?>" type="text">
          <?php echo form_error('vaccinators_names'); ?>
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Monthly Target Population(Children &lt;1 Year):</label>
          </div>
          <div class="col-md-2 col-sm-2">
            <input class="form-control numberclass" name="uc_monthly_pop_less_1year" id="uc_monthly_pop_less_1year" value="<?php if(isset($vaccManagment)){ echo $vaccManagment->uc_monthly_pop_less_1year; }else { if(validation_errors() != false) { echo set_value('uc_monthly_pop_less_1year'); } else{ } } ?>" placeholder="Number" type="number">
          </div>
        </div>
            <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Annual Target Population (Pregnant Women):</label>
          </div>
          <div class="col-md-2 col-sm-2">
            <input class="form-control numberclass" name="uc_annual_target_pop_women" id="uc_annual_target_pop_women" value="<?php if(isset($vaccManagment)){ echo $vaccManagment->uc_annual_target_pop_women; }else { if(validation_errors() != false) { echo set_value('uc_annual_target_pop_women'); } else{ echo '0'; } } ?>" placeholder="Number" type="number">
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Monthly Target Population(Pregnant Women):</label>
          </div>
          <div class="col-md-2 col-sm-2">
            <input class="form-control numberclass" name="uc_monthly_target_pop_women" id="uc_monthly_target_pop_women" value="<?php if(isset($vaccManagment)){ echo $vaccManagment->uc_monthly_target_pop_women; }else { if(validation_errors() != false) { echo set_value('uc_monthly_target_pop_women'); } else{ echo '0'; } } ?>" placeholder="Number" type="number">
          </div>
        </div>

<div class="row bgrow1">
         
        </div>
        <div class="row">
          <div class="col-md-1 col-sm-1 btb flcfvr-c1 text-center" >
            <label>Item</label>
          </div>
          <div class="col-md-2 col-sm-2 ball">
            <div class="row">
              <div class="col-md-12 col-sm-12 bb">
                <label>Opening balance on 1st day of the month</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 flcfvr-c2-r2 text-center">
                <label>Qty in doses/units</label>
              </div>
            </div>
          </div>
          <div class="col-md-5 col-sm-5 btrb">
            <div class="row">
              <div class="col-md-12 col-sm-12 text-center">
                <label>Vaccines,Syringes &amp; Safety Boxes Received From The District/Agency Store during the month</label>
              </div>              
            </div>
            <div class="row bt">
              <div class="col-md-3 col-sm-3 flcfvr-c3-r2-c1 text-center">
                <label>Date</label>
              </div>
              <div class="col-md-3 col-sm-3 brl text-center">
                <label>Qty in Doses/Units</label>
              </div>
              <div class="col-md-3 col-sm-3 br flcfvr-c3-r2-c3 text-center">
                <label>Batch No.</label>
              </div>
              <div class="col-md-3 col-sm-3 flcfvr-c3-r2-c4 text-center">
                <label>Expiry Date</label>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-2 btb flcfvr-c4">
            <label class="lbl-flcfvr-qty-doses">Qty Utlized During the Month in Doses/Units</label>
          </div>
          <div class="col md-2 col-sm-2 ball">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <label>End balance on last day of the month 2+4-7</label>
              </div>
            </div>
            <div class="row bt">
              <div class="col-md-6 col-sm-6">
                <label class="lbl-flcfvr-qty-doses">Qty in Doses/Units</label>
              </div>
              <div class="col-md-6 col-sm-6 bl text-center">
                <label>Expiry Date</label>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-1 btb flcfvr-c6">
            <label>Remarks (If any)</label>
          </div>
        </div>


        <div class="row">
          <div class="col-md-1 col-sm-1 bb text-center">
            <label>1</label>
          </div>
          <div class="col-md-2 col-sm-2 brbl text-center">
           <label>2</label>
          </div>
          <div class="col-md-5 col-sm-5 brb">
         
            <div class="row">
              <div class="col-md-3 col-sm-3 text-center">
                <label>3</label>
              </div>
              <div class="col-md-3 col-sm-3 brl text-center">
                <label>4</label>
              </div>
              <div class="col-md-3 col-sm-3 br text-center">
                <label>5</label>
              </div>
              <div class="col-md-3 col-sm-3 text-center">
                <label>6</label>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-2 bb text-center">
            <label>7</label>
          </div>
          <div class="col md-2 col-sm-2 brlb text-center">
            <div class="row">
              <div class="col-md-6 col-sm-6 bbl text-center">
                <label>8</label>
              </div>
              <div class="col-md-6 col-sm-6 brbl text-center">
                <label>9</label>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-1 bb text-center">
            <label>10</label>
          </div>
        </div>
        <?php
        $vaccTitles = array("BCG","BCG_diluent","tOPV","Pentavalent","Pneumococcal","Measles","Measles_diluent","Tetanus_Toxoid","AD_Syringes_005_ml","AD_Syringes_05_ml","Disposable_Reconstitution_Syringes_2ml","Disposable_Reconstitution_Syringes_5ml","Safety_Boxes"); 
        $i=0;
   		foreach($vaccTitles as $title){
        	$toMatch = str_replace('_', ' ', $title);
			$matchingTitle = str_insert($toMatch,'0','.');
        ?>
        <div class="row">
          <div class="col-md-1 col-sm-1 bb text-center flcfvr-r9-c1">
            <label class="lbl-flcfvr-pnemo"><?php echo $vaccTitelsArray[$i]['vacc_name']; ?></label>
          </div>
          <div class="col-md-2 col-sm-2 brbl text-center">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <input class="form-controlc12 numberclass" value="<?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['opening_balance_quantity']; }else{ echo '0'; } ?>" name="opening_balance_quantity[0][<?php echo str_replace(' ', '_', $title); ?>]" id="opening_balance_quantity" placeholder="Number" type="text">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <input class="form-controlc12 numberclass" value="<?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['opening_balance_quantity']; }else{ echo '0'; } ?>" name="opening_balance_quantity[1][<?php echo str_replace(' ', '_', $title); ?>]" id="opening_balance_quantity" value="0" placeholder="Number" type="text">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <input class="form-controlc12 numberclass" value="<?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['opening_balance_quantity']; }else{ echo '0'; } ?>" name="opening_balance_quantity[2][<?php echo str_replace(' ', '_', $title); ?>]" id="opening_balance_quantity" value="0" placeholder="Number" type="text">
              </div>
            </div>
          </div>
          <div class="col-md-5 col-sm-5 brb">
            <div class="row">
              <div class="col-md-3 col-sm-3 text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input placeholder="Date" value="<?php if(isset($titles[$matchingTitle][0])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][0]['recived_dur_month_date'])); }else{ echo '0'; } ?>" name="recived_dur_month_date[0][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_date" class="dp form-controlc12a" type="date">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input placeholder="Date" value="<?php if(isset($titles[$matchingTitle][1])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][1]['recived_dur_month_date'])); }else{ echo '0'; } ?>" name="recived_dur_month_date[1][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_date" class="dp form-controlc12a" type="date">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input placeholder="Date" value="<?php if(isset($titles[$matchingTitle][2])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][2]['recived_dur_month_date'])); }else{ echo '0'; } ?>" name="recived_dur_month_date[2][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_date" class="dp form-controlc12a" type="date">
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 brl text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input class="form-controlc12a numberclass" value="<?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['recived_dur_month_quantity']; }else{ echo '0'; } ?>" name="recived_dur_month_quantity[0][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_quantity" value="0" placeholder="Number" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input class="form-controlc12a numberclass" value="<?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['recived_dur_month_quantity']; }else{ echo '0'; } ?>" name="recived_dur_month_quantity[1][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_quantity" value="0" placeholder="Number" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input class="form-controlc12a numberclass" value="<?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['recived_dur_month_quantity']; }else{ echo '0'; } ?>" name="recived_dur_month_quantity[2][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_quantity" value="0" placeholder="Number" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 br text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input class="form-controlc12a" value="<?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['recived_dur_month_batch']; }else{ echo '0'; } ?>" name="recived_dur_month_batch[0][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_batch" value="0" placeholder="Number" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input class="form-controlc12a" value="<?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['recived_dur_month_batch']; }else{ echo '0'; } ?>" name="recived_dur_month_batch[1][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_batch" value="0" placeholder="Number" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input class="form-controlc12a" value="<?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['recived_dur_month_batch']; }else{ echo '0'; } ?>" name="recived_dur_month_batch[2][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_batch" value="0" placeholder="Number" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input placeholder="Expiry Date" value="<?php if(isset($titles[$matchingTitle][0])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][0]['recived_dur_month_expiry'])); }else{ echo '0'; } ?>" name="recived_dur_month_expiry[0][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_expiry" class="dp form-controlc12a" type="date">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input placeholder="Expiry Date" value="<?php if(isset($titles[$matchingTitle][1])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][1]['recived_dur_month_expiry'])); }else{ echo '0'; } ?>" name="recived_dur_month_expiry[1][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_expiry" class="dp form-controlc12a" type="date">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input placeholder="Expiry Date" value="<?php if(isset($titles[$matchingTitle][2])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][2]['recived_dur_month_expiry'])); }else{ echo '0'; } ?>" name="recived_dur_month_expiry[2][<?php echo str_replace(' ', '_', $title); ?>]" id="recived_dur_month_expiry" class="dp form-controlc12a" type="date">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-2 bb text-center">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <input class="form-controlc12b numberclass" value="<?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['utilized_during_month']; }else{ echo '0'; } ?>" name="utilized_during_month[0][<?php echo str_replace(' ', '_', $title); ?>]" id="utilized_during_month"  value="0" placeholder="Number" type="text">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <input class="form-controlc12b numberclass" value="<?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['utilized_during_month']; }else{ echo '0'; } ?>" name="utilized_during_month[1][<?php echo str_replace(' ', '_', $title); ?>]" id="utilized_during_month" value="0" placeholder="Number" type="text">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <input class="form-controlc12b numberclass" value="<?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['utilized_during_month']; }else{ echo '0'; } ?>" name="utilized_during_month[2][<?php echo str_replace(' ', '_', $title); ?>]" id="utilized_during_month" value="0" placeholder="Number" type="text">
              </div>
            </div>
          </div>
          <div class="col md-2 col-sm-2 brlb text-center">
            <div class="row">
              <div class="col-md-6 col-sm-6 bbl text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input class="form-controlc12b numberclass" value="<?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['end_balance_quantity']; }else{ echo '0'; } ?>" name="end_balance_quantity[0][<?php echo str_replace(' ', '_', $title); ?>]" id="end_balance_quantity" value="0" placeholder="Number" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input class="form-controlc12b numberclass" value="<?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['end_balance_quantity']; }else{ echo '0'; } ?>" name="end_balance_quantity[1][<?php echo str_replace(' ', '_', $title); ?>]" id="end_balance_quantity" value="0" placeholder="Number" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input class="form-controlc12b numberclass" value="<?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['end_balance_quantity']; }else{ echo '0'; } ?>" name="end_balance_quantity[2][<?php echo str_replace(' ', '_', $title); ?>]" id="end_balance_quantity" value="0" placeholder="Number" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 brbl text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input placeholder="Expiry Date" value="<?php if(isset($titles[$matchingTitle][0])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][0]['end_balance_expiry'])); }else{ echo '0'; } ?>" name="end_balance_expiry[0][<?php echo str_replace(' ', '_', $title); ?>]" id="end_balance_expiry" class="dp form-controlc12b" type="date">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input placeholder="Expiry Date" value="<?php if(isset($titles[$matchingTitle][1])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][1]['end_balance_expiry'])); }else{ echo '0'; } ?>" name="end_balance_expiry[1][<?php echo str_replace(' ', '_', $title); ?>]" id="end_balance_expiry" class="dp form-controlc12b" type="date">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <input placeholder="Expiry Date" value="<?php if(isset($titles[$matchingTitle][2])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][2]['end_balance_expiry'])); }else{ echo '0'; } ?>" name="end_balance_expiry[2][<?php echo str_replace(' ', '_', $title); ?>]" id="end_balance_expiry" class="dp form-controlc12b" type="date">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-1 bb text-center">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <input class="form-controlc12c" value="<?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['remarks']; }else{ echo '0'; } ?>" name="remarks[0][<?php echo str_replace(' ', '_', $title); ?>]" id="remarks" placeholder="Remarks" type="text">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <input class="form-controlc12c" value="<?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['remarks']; }else{ echo '0'; } ?>" name="remarks[1][<?php echo str_replace(' ', '_', $title); ?>]" id="remarks" placeholder="Remarks" type="text">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <input class="form-controlc12c" value="<?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['remarks']; }else{ echo '0'; } ?>" name="remarks[2][<?php echo str_replace(' ', '_', $title); ?>]" id="remarks" placeholder="Remarks" type="text">
              </div>
            </div>
          </div>
        </div>
       <?php $i++; } ?>
        <div class="row rowmsr-filters row-signatures form-group">
          <label class="col-md-2  col-sm-3 cmargin29">Name of Vaccinator:</label>
          <div class="col-md-3 col-sm-3">
            <input class="form-control" name="vacc_code" id="vacc_code" value="<?php if(isset($vaccManagment)){ echo $vaccManagment->vacc_code; }else { if(validation_errors() != false) { echo set_value('vacc_code'); } else{ } } ?>" placeholder="Name of Vaccinator" type="text">
          </div>
          <label class="col-md-1  col-sm-2">Date:</label>
          <div class="col-md-3 col-sm-3">
          	<?php $date=date('Y-m-d'); ?>
            <input readonly="readonly" name="submitted_date" id="submitted_date"  class="form-control" value="<?php echo date('d-m-Y',strtotime($date)); ?>" placeholder="0" type="date">
            
          </div>
        </div>

         
        
        <div class="row">
         <hr>
            <div class="col-md-7 col-sm-7  cmargin21">
                <button type="submit" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save Form  </button>
                <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
                <a href="#" onclick="history.go(-1);" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>
            
        
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->