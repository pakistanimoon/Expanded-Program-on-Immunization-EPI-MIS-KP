
<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
 	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
   <div class="panel-heading"> Monthly Vaccination Reporting Form</div>
     <div class="panel-body">
     	<?php
		
		if(isset($fmvrf_info) && validation_errors() == false ){
			$path = base_url()."data_entry/fmvrf_update/".$fmvrf_info["id"];
		}
		else if(isset($id)){
			$path = base_url()."data_entry/fmvrf_update/".$id;
		}else{ 
			$path = base_url()."data_entry/fmvrf_save";
		} ?>
      <form class="form-horizontal" id="fmvrf" method="post" enctype="multipart/form-data" action="<?php echo $path; ?>">
        <table class="table table-bordered   table-striped table-hover  mytable3">
          <tbody>
          <tr>
            <td><label>Year</label></td>
            <td><?php if(isset($fmvrf_info)){
				$fmonthArr = explode("-",$fmvrf_info["fmonth"]);
				echo $fmonthArr[0];
				echo '<input class="form-control" name="old_fmonth" id="old_fmonth" value="'.$fmvrf_info["fmonth"].'" type="hidden">';
			}else{ ?>
				<select id="year" name="year" class="form-control">
					<?php echo getAllYearsOptions(); ?>
				</select>
			<?php } ?></td>
            <td><label>Month</label></td>
            <td>
              <?php if(isset($fmvrf_info)){
				echo $fmonthArr[1];
			}else{ ?>
				<select id="month" name="month" class="form-control">
					<?php echo getAllMonthsOptionsIncludingCurrent(); ?>
				</select>
			<?php } ?>
            </select>
            </td>
            <td><label>District</label></td>
            <td>
              <select id="distcode" name="distcode" class="form-control">
			<?php 
				if(isset($fmvrf_info)){ ?>
					<option value="<?php echo $fmvrf_info['distcode']; ?>"> <?php echo $district; ?></option>
			<?php	}else{
				
					echo getDistricts();
				}
			?>
            </select>
            </td>
          </tr>
          <tr>
            <td><label>Tehsil</label></td>
            <td><select id="tcode" name="tcode" class="form-control">
			<?php 
				if(isset($fmvrf_info)){?>
					<option value="<?php echo $fmvrf_info['tcode']; ?>"<?php if(validation_errors() != false) { echo set_select('tcode',$fmvrf_info['tcode']); }?> > <?php echo $tehsil; ?> </option>
				<?php }else{?>
					  <option value="" >-- Select --</option> 
					  <?php echo getTehsils(); 
					}
			?> 
			</select></td>
            <td><label>UC</label></td>
            <td>
              <select required id="uncode" name="uncode" class="form-control">
              <?php if(isset($fmvrf_info)){ ?>
                <option value="<?php echo $fmvrf_info['uncode']; ?>" <?php if(validation_errors() != false) { echo set_select('uncode',$fmvrf_info['uncode']); }?> > <?php echo get_UC_Name($fmvrf_info['uncode']); ?> </option>
                <?php }else{ ?> 
				<option value="0">--Select--</option>
                <?php   } ?>
            </select>
            </td>
            <td><label>Health Facility Name</label></td>
            <td>
              <?php	
        				if(isset($fmvrf_info)){
        					echo '<input class="form-control" name="old_facode" id="old_facode" value="'.$fmvrf_info["facode"].'" type="hidden">';
        				}
        			?>
            <select id="facode" name="facode" class="form-control">
              <?php if(isset($fmvrf_info)){?>
				      	<option value="<?php echo $fmvrf_info['facode']; ?>" > <?php echo $facility; ?></option>
					
				    <?php }else{ ?>
              <option value="0" required="required" >-- Select --</option>
	                   <?php 	
	                  		} ?>
            </select>
            	<?php echo form_error('facode'); ?>
            </td>
          </tr>
          <tr>
            <td><label>Health Facility Code</label></td>
            <td><input type="text" id="hfcode" name="hfcode" readonly="readonly" value="<?php if(validation_errors() != false) {echo set_value('hfcode'); } else { if(isset($fmvrf_info)){ echo $fmvrf_info['facode']; }} ?>" class="form-control" ></td>
            <td colspan="2"><label>Monthly Target For Children 0-11</label></td>
            <td>
              <input class="form-control numberclass" name="tc_male" id="tc_male" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('tc_male'); }else{ echo $fmvrf_info["tc_male"]; } } else {if(validation_errors() != false) {echo set_value('tc_male'); } else{echo '0';} } ?>" placeholder="Number" type="text">
          	<?php echo form_error('tc_male'); ?>
            </td>
            <td>
              <input class="form-control numberclass" name="tc_female" id="tc_female" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('tc_female'); }else{ echo $fmvrf_info["tc_female"]; } } else {if(validation_errors() != false) {echo set_value('tc_female'); } else{echo '0';} } ?>" placeholder="Number" type="text">
            </td>
          </tr>
          <tr>
            <td><label>Monthly Target for Pregnant Women</label></td>
            <td><input class="form-control numberclass" name="pw_monthly_target" id="pw_monthly_target" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('pw_monthly_target'); }else{ echo $fmvrf_info["pw_monthly_target"]; } } else {if(validation_errors() != false) {echo set_value('pw_monthly_target'); } else{echo '0';} } ?>" placeholder="Number" type="text"></td>
            <td><label>Total LHWs Attached</label></td>
            <td>
              <input class="form-control numberclass" name="tot_lhw_attached" id="tot_lhw_attached" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('tot_lhw_attached'); }else{ echo $fmvrf_info["tot_lhw_attached"]; } } else {if(validation_errors() != false) {echo set_value('tot_lhw_attached'); } else{echo '0';} } ?>" placeholder="Number" type="text">
            </td>
            <td><label>Total LHWs Involved in Vaccination</label></td>
            <td>
              <input class="form-control numberclass" name="tot_lhw_involved_vacc" id="tot_lhw_involved_vacc" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('tot_lhw_involved_vacc'); }else{ echo $fmvrf_info["tot_lhw_involved_vacc"]; } } else {if(validation_errors() != false) {echo set_value('tot_lhw_involved_vacc'); } else{echo '0';} } ?>" placeholder="Number" type="text">
            </td>
          </tr>
      </tbody>
    </table>
    
    <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">EPI Services</th>
            </tr>
            <tr>
              <th></th>
              <th>Fixed EPI Centers</th>
              <th colspan="2">Outreach Vaccination Session by Vaccinator/s</th>
              <th colspan="2">HH Vaccination Session by LHWs</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>Total</p></label>
              <td><input class="form-control numberclass" name="tot_fixed_centers" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('tot_fixed_centers'); }else{ echo $fmvrf_info["tot_fixed_centers"]; } } else {if(validation_errors() != false) {echo set_value('tot_fixed_centers'); } else{echo '0';} } ?>" placeholder="Number" type="text"></td>
              <td style="text-align: center;"><label>Planned</label></td>
              <td style="text-align: center;"><label>Actually Held</label></td>
              <td style="text-align: center;"><label>Planned</label></td>
              <td style="text-align: center;"><label>Actually Held</label></td>
            </tr>
            <tr>
              <td><label>Functioning</label><br>
                  <label>Reporting</label>
              </td>
              <td>
                <input class="form-control numberclass" name="functioning_centers" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('functioning_centers'); }else{ echo $fmvrf_info["functioning_centers"]; } } else {if(validation_errors() != false) {echo set_value('functioning_centers'); } else{echo '0';} } ?>" placeholder="Number" type="text">
                <input class="form-control numberclass" name="reporting" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('reporting'); }else{ echo $fmvrf_info["reporting"]; } } else {if(validation_errors() != false) {echo set_value('reporting'); } else{echo '0';} } ?>"  type="text">
              </td>
              <td><input class="form-control numberclass" style="height: 68px;" name="or_vacc_planned" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('or_vacc_planned'); }else{ echo $fmvrf_info["or_vacc_planned"]; } } else {if(validation_errors() != false) {echo set_value('or_vacc_planned'); } else{echo '0';} } ?>" placeholder="Number" type="text"></td>
              <td><input class="form-control numberclass" style="height: 68px;" name="or_vacc_held" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('or_vacc_held'); }else{ echo $fmvrf_info["or_vacc_held"]; } } else {if(validation_errors() != false) {echo set_value('or_vacc_held'); } else{echo '0';} } ?>" placeholder="Number" type="text"></td>
              <td><input class="form-control numberclass" style="height: 68px;" name="hh_vacc_planned" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('hh_vacc_planned'); }else{ echo $fmvrf_info["hh_vacc_planned"]; } } else {if(validation_errors() != false) {echo set_value('hh_vacc_planned'); } else{echo '0';} } ?>" placeholder="Number" type="text"></td>
              <td><input class="form-control numberclass" style="height: 68px;" name="hh_vacc_held" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('hh_vacc_held'); }else{ echo $fmvrf_info["hh_vacc_held"]; } } else {if(validation_errors() != false) {echo set_value('hh_vacc_held'); } else{echo '0';} } ?>" placeholder="Number" type="text"></td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
             <tr>
                <th colspan="15" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">A. Childhood Routine Immunization</th>
              </tr> 
              <tr>
                <th rowspan="4">Vaccines</th>
                <th colspan="6">Vaccination by Vaccinator</th>
                <th colspan="6">House Hold (LHW)</th>
                <th rowspan="3" colspan="2">Total Children<br> Vaccinated</th>
              </tr>
              <tr>
                <th colspan="6">Vaccination Given to Children</th>
                <th colspan="6">Vaccination Given to Children</th>
              </tr>
              <tr>
                <th colspan="2">0-11 Months</th>
                <th colspan="2">12-23 Months</th>
                <th colspan="2">2 Years and Above</th>
                <th colspan="2">0-11 Months</th>
                <th colspan="2">12-23 Months</th>
                <th colspan="2">2 Years and Above</th>
              </tr> 
            <tr>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
            </tr>
          </thead>
          <tbody id="tbodyvacc">
          	<?php $names = array("BCG","Hep B","OPV-0","OPV-1","OPV-2","OPV-3","PENTA-1","PENTA-2","PENTA-3","PCV10-1","PCV10-2","PCV10-3","IPV","ROTA-1","ROTA-2","Measles-1","Measles-2","Fully Immunized"); 
		          for($i=1; $i<=count($names); $i++){?>
             <tr>
              <td><label><?php echo $names[$i-1]; ?></label></td> 
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f1'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r17_f1'){ echo 'readonly="readonly"'; } ?>  ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f2'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r17_f2'){ echo 'readonly="readonly"'; } ?> ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f3'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r1_f3' || $var =='cri_r2_f3' || $var =='cri_r3_f3' || $var =='cri_r13_f3'){ echo 'readonly="readonly"'; } ?> ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f4'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r1_f4' || $var =='cri_r2_f4' || $var =='cri_r3_f4' || $var =='cri_r13_f4'){ echo 'readonly="readonly"'; } ?> ></td>
         	    <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f5'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r1_f5' || $var =='cri_r2_f5' || $var =='cri_r3_f5' || $var =='cri_r10_f5' || $var =='cri_r11_f5' || $var =='cri_r12_f5' || $var =='cri_r13_f5'){ echo 'readonly="readonly"'; } ?> ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f6'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r1_f6' || $var =='cri_r2_f6' || $var =='cri_r3_f6' || $var =='cri_r10_f6' || $var =='cri_r11_f6' || $var =='cri_r12_f6' || $var =='cri_r13_f6'){ echo 'readonly="readonly"'; } ?> ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f7'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r17_f7'){ echo 'readonly="readonly"'; } ?> ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f8'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r17_f8'){ echo 'readonly="readonly"'; } ?> ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f9'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r1_f9' || $var =='cri_r2_f9' || $var =='cri_r3_f9' || $var =='cri_r13_f9' || $var =='cri_r17_f9'){ echo 'readonly="readonly"'; } ?> ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f10'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r1_f10' || $var =='cri_r2_f10' || $var =='cri_r3_f10' || $var =='cri_r13_f10' || $var =='cri_r17_f10'){ echo 'readonly="readonly"'; } ?> ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f11'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r1_f11' || $var =='cri_r2_f11' || $var =='cri_r3_f11' || $var =='cri_r10_f11' || $var =='cri_r11_f11' || $var =='cri_r12_f11' || $var =='cri_r13_f11' || $var =='cri_r17_f11'){ echo 'readonly="readonly"'; } ?> ></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f12'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" type="text" <?php if($var== 'cri_r1_f12' || $var =='cri_r2_f12' || $var =='cri_r3_f12' || $var =='cri_r10_f12' || $var =='cri_r11_f12' || $var =='cri_r12_f12' || $var =='cri_r13_f12' || $var =='cri_r17_f12'){ echo 'readonly="readonly"'; } ?> ></td> 
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f13'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" readonly="readonly" type="text"></td>
              <td><input class="form-control numberclass" name="<?php echo $var='cri_r'.$i.'_f14'; ?>" id="<?php echo $var;  ?>" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value($var); }else{ echo $fmvrf_info[$var]; } } else {if(validation_errors() != false) {echo set_value($var); } else{echo '0';} } ?>" readonly="readonly" type="text"></td>
             </tr>
             <?php } ?>
             <?php echo form_error("cri_r17_f1"); ?>
        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
              <tr>
                <th colspan="9" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">B. TT Routine Immunization</th>
              </tr>
              <tr>
                <th rowspan="2">Vaccination</th>
                <th colspan="2">Fixed Centers</th>
                <th colspan="2">House Hold(LHW)</th>
                <th colspan="2">Total Vaccinated</th>
              </tr>
              <tr>
              <th>Pregnant Women</th>
              <th>Non-Pregnant Women (15-49 Years)</th>
              <th>Pregnant Women</th>
              <th>Non-Pregnant Women (15-49 Years)</th>
              <th>PL</th>
              <th>Non-PL</th>
            </tr>
          </thead>
          <tbody id="tbodyimmun">
          	<?php $labels = array("TT-1","TT-2","TT-3","TT-4","TT-5","Children Protected at Birth"); 
		foreach($labels as $key => $value){?>
            <tr>
              <td><label><?php echo $value; ?></label></td>
              <td><input class="form-control numberclass" name="<?php echo $var='ttri_r'.($key+1).'_f1'; ?>" value="<?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?>" type="text"></td>
              <td><input class="form-control numberclass" name="<?php echo $var='ttri_r'.($key+1).'_f2'; ?>" value="<?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?>" <?php if($var== 'ttri_r6_f2'){ echo 'disabled="disabled"'; } ?> type="text"></td> 
              <td><input class="form-control numberclass" name="<?php echo $var='ttri_r'.($key+1).'_f3'; ?>" value="<?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?>" type="text"></td> 
              <td><input class="form-control numberclass" name="<?php echo $var='ttri_r'.($key+1).'_f4'; ?>" value="<?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?>" <?php if($var== 'ttri_r6_f4'){ echo 'disabled="disabled"'; } ?> type="text"></td>
              <td><input class="form-control numberclass" name="<?php echo $var='ttri_r'.($key+1).'_f5'; ?>" value="<?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?>" readonly="readonly" type="text"></td> 
              <td><input class="form-control numberclass" name="<?php echo $var='ttri_r'.($key+1).'_f6'; ?>" value="<?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?>" readonly="readonly" type="text"></td>
            </tr>
            <?php } ?>
            
         
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <tbody>
            <tr>
              <td><label>Name of Vaccinator</label></td>
              <td style="text-align:center;"><input class="form-control" name="vacc_name" id="vacc_name" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('vacc_name'); }else{ echo $fmvrf_info["vacc_name"]; } } else {if(validation_errors() != false) {echo set_value('vacc_name'); } else{} } ?>" placeholder="Name of Vaccinator" type="text"></td>
              <input type="hidden" id="techniciancode" name="techniciancode">
			        <td><label>Name of LHS</label></td> 
              <td style="text-align:center;"><input class="form-control" name="lhsname" id="lhsname" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('lhsname'); }else{ echo $fmvrf_info["lhsname"]; } } else {if(validation_errors() != false) {echo set_value('lhsname'); } else{} } ?>" placeholder="Name of LHS" type="text"></td>
              <td><label>Name of Facility Incharge</label></td>
              <td style="text-align:center;"><input class="form-control" name="incharge_name" id="incharge_name" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('incharge_name'); }else{ echo $fmvrf_info["incharge_name"]; } } else {if(validation_errors() != false) {echo set_value('incharge_name'); } else{} } ?>" placeholder="Name of Facility Incharge" type="text"></td>
            </tr>
          </tbody>
        </table>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
                
              <button style="background: #008d4c;" class="btn btn-primary btn-md" type="reset">
                <i class="fa fa-repeat"></i> Reset Form </button>
             
              <a href="<?php echo base_url() ?>HFMVRF/List" style="background: #008d4c" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>
      </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--end of body container-->
<!--start of footer-->
<br>
<br>
<script type="text/javascript">
	$(window).load(function () {
		selectedfacode = '<?php echo isset($fmvrf_info)?$fmvrf_info["facode"]:0; ?>';
	});
	
	$('#facode').on('change', function(){
		var facode = $('#facode').val();
			$.ajax({
				type: "POST",
				data: "facode="+facode,
				url: "<?php echo base_url(); ?>Ajax_calls/getIncharge",
				success: function(result){
					 var data = jQuery.parseJSON(result);
					$('#incharge_name').val(data.incharge);
				}
			});
			
			$.ajax({
				type: "POST",
				data: "facode="+facode,
				url: "<?php echo base_url(); ?>Ajax_calls/getVccname",
				success: function(result){
					 var data = jQuery.parseJSON(result);
					$('#vacc_name').val(data.technicianname);
					$('#techniciancode').val(data.techniciancode);
				}
			});
			
			$.ajax({
				type: "POST",
				data: "facode="+facode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTargetChildern",
				success: function(result){
					var data = jQuery.parseJSON(result);
					$('#tc_male').val(data.male);
					$('#tc_female').val(data.female);
					$('#pw_monthly_target').val(data.monthly_PregnantW);
				}
			});
	});
	$(document).on('submit','#fmvrf',function(e){
		e.preventDefault();
		$(':input').each(function(){
			if($(this).val()==''){
				$(this).val('0');
				$(this).keyup();
				$('#cri_r10_f5').val("0");
				$('#cri_r11_f5').val("0");
				$('#cri_r12_f5').val("0");
				$('#cri_r10_f6').val("0");
				$('#cri_r11_f6').val("0");
				$('#cri_r12_f6').val("0");
				$('#cri_r10_f11').val("0");
				$('#cri_r11_f11').val("0");
				$('#cri_r12_f11').val("0");
				$('#cri_r10_f12').val("0");
				$('#cri_r11_f12').val("0");
				$('#cri_r12_f12').val("0");
			}
		});
		$('#fmvrf')[0].submit();
	});
	$('#tbodyvacc tr:eq(15) td :input').keyup(function(e){
		$('#tbodyvacc tr:eq(17) td:eq('+$(this).parent().index()+') :input').val($(this).val());
		var thisName = $('#tbodyvacc tr:eq(17) td:eq('+$(this).parent().index()+') :input').attr("name");
		var parts = thisName.split("_");
		var row = parts[1];
		var toaddM=0;var toaddF=0;
		for(i=1; i<=12; i++){
			var toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddM = toaddM + toadd;
			i++;
			toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddF = toaddF + toadd;
		}
		$("input[name=cri_"+row+"_f13]").val(toaddM);
		$("input[name=cri_"+row+"_f14]").val(toaddF);
	});
	
	$('#tbodyimmun tr:eq(1) td :input').keyup(function(e){
		var indexNo = $(this).parent().index();
		if($(this).parent().index() !=2){
			if($(this).parent().index() !=4){
				$('#tbodyimmun tr:eq(5) td:eq('+indexNo+') :input').val($(this).val());
				var thisName = $('#tbodyimmun tr:eq(5) td:eq('+indexNo+') :input').attr("name");
				var parts = thisName.split("_");
				var row = parts[1];
				var toaddPL=0;var toaddNPL=0;
				for(i=1; i<=4; i++){
					var toadd = ($("input[name=ttri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=ttri_"+row+"_f"+i+"]").val()):0;
					toaddPL = toaddPL + toadd;
					i++;
					toadd = ($("input[name=ttri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=ttri_"+row+"_f"+i+"]").val()):0;
					toaddNPL = toaddNPL + toadd;
				}
				$("input[name=ttri_"+row+"_f5]").val(toaddPL); 
				$("input[name=ttri_"+row+"_f6]").val(toaddNPL);	
			}				
		}
	});
	$('#tbodyvacc tr:eq(3) td :input').keyup(function(e){
		$('#tbodyvacc tr:eq(6) td:eq('+$(this).parent().index()+') :input').val($(this).val());
		var thisName = $('#tbodyvacc tr:eq(6) td:eq('+$(this).parent().index()+') :input').attr("name");
		var parts = thisName.split("_");
		var row = parts[1];
		var toaddM=0;var toaddF=0;
		for(i=1; i<=12; i++){
			var toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddM = toaddM + toadd;
			i++;
			toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddF = toaddF + toadd;
		}
		$("input[name=cri_"+row+"_f13]").val(toaddM);
		$("input[name=cri_"+row+"_f14]").val(toaddF);
		if($(this).parent().index() < 11 || $(this).parent().index() > 12){
			if($(this).parent().index() < 5 || $(this).parent().index() > 6){
				$('#tbodyvacc tr:eq(9) td:eq('+$(this).parent().index()+') :input').val($(this).val());
				var thisName1 = $('#tbodyvacc tr:eq(9) td:eq('+$(this).parent().index()+') :input').attr("name");
				var parts = thisName1.split("_");
				var row = parts[1];
				var toaddM=0;var toaddF=0;
				for(i=1; i<=12; i++){
					var toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
					toaddM = toaddM + toadd;
					i++;
					toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
					toaddF = toaddF + toadd;
				}
				$("input[name=cri_"+row+"_f13]").val(toaddM);
				$("input[name=cri_"+row+"_f14]").val(toaddF);
			}
		}
	});
	$('#tbodyvacc tr:eq(4) td :input').keyup(function(e){
		$('#tbodyvacc tr:eq(7) td:eq('+$(this).parent().index()+') :input').val($(this).val());
		var thisName = $('#tbodyvacc tr:eq(7) td:eq('+$(this).parent().index()+') :input').attr("name");
		var parts = thisName.split("_");
		var row = parts[1];
		var toaddM=0;var toaddF=0;
		for(i=1; i<=12; i++){
			var toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddM = toaddM + toadd;
			i++;
			toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddF = toaddF + toadd;
		}
		$("input[name=cri_"+row+"_f13]").val(toaddM);
		$("input[name=cri_"+row+"_f14]").val(toaddF);
		
		if($(this).parent().index() < 11 || $(this).parent().index() > 12){
			if($(this).parent().index() < 5 || $(this).parent().index() > 6){
				$('#tbodyvacc tr:eq(10) td:eq('+$(this).parent().index()+') :input').val($(this).val());
				var thisName1 = $('#tbodyvacc tr:eq(10) td:eq('+$(this).parent().index()+') :input').attr("name");
				var parts = thisName1.split("_");
				var row = parts[1];
				var toaddM=0;var toaddF=0;
				for(i=1; i<=12; i++){
					var toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
					toaddM = toaddM + toadd;
					i++;
					toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
					toaddF = toaddF + toadd;
				}
				$("input[name=cri_"+row+"_f13]").val(toaddM);
				$("input[name=cri_"+row+"_f14]").val(toaddF);
			}
		}
	});
	$('#tbodyvacc tr:eq(5) td :input').keyup(function(e){
		$('#tbodyvacc tr:eq(8) td:eq('+$(this).parent().index()+') :input').val($(this).val());
		var thisName = $('#tbodyvacc tr:eq(8) td:eq('+$(this).parent().index()+') :input').attr("name");
		var parts = thisName.split("_");
		var row = parts[1];
		var toaddM=0;var toaddF=0;
		for(i=1; i<=12; i++){
			var toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddM = toaddM + toadd;
			i++;
			toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddF = toaddF + toadd;
		}
		$("input[name=cri_"+row+"_f13]").val(toaddM);
		$("input[name=cri_"+row+"_f14]").val(toaddF);
		
		if($(this).parent().index() < 11 || $(this).parent().index() > 12){
			if($(this).parent().index() < 5 || $(this).parent().index() > 6){
				$('#tbodyvacc tr:eq(11) td:eq('+$(this).parent().index()+') :input').val($(this).val());
				var thisName1 = $('#tbodyvacc tr:eq(11) td:eq('+$(this).parent().index()+') :input').attr("name");
				var parts = thisName1.split("_");
				var row = parts[1];
				var toaddM=0;var toaddF=0;
				for(i=1; i<=12; i++){
					var toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
					toaddM = toaddM + toadd;
					i++;
					toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
					toaddF = toaddF + toadd;
				}
				$("input[name=cri_"+row+"_f13]").val(toaddM);
				$("input[name=cri_"+row+"_f14]").val(toaddF);
			}
		}	
	});
</script> 