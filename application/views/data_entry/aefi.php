<?php
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('d-m-Y');
?>
<div class="container bodycontainer">  
	<div class="row">
 		<div class="panel panel-primary">
   			<div class="panel-heading"> Adverse Events Following Immunisation (AEFI) Report Form</div>
     		<div class="panel-body">
				<?php 
					if(isset($aefi_info)){
						$path = base_url()."data_entry/aefi_update/".$aefi_info["id"];
					}
					else if(isset($id))
					{
						$path = base_url()."data_entry/aefi_update/".$id;
					}
					else 
					{ 
						$path = base_url()."data_entry/aefi_save";
					} 
				?>
      			<form class="form-horizontal" method="post" onsubmit="return confirm('Are you sure you want to save/submit this form?')" enctype="multipart/form-data" action="<?php echo $path; ?>">
        			<table class="table table-bordered   table-striped table-hover  mytable3">
          				<tbody>
          					<tr>
            					<td><label>Name of Case</label></td>
					            <td>
					            	<input class="form-control" required="required" placeholder="Name of Case" value="<?php if(isset($aefi_info)) {if(validation_errors() != false) { echo set_value('casename'); }  else { echo $aefi_info["casename"]; } }  else {if(validation_errors() != false){ echo set_value('casename'); } else {  } }?>" name="casename" id="casename" type="text">
									<?php echo form_error('casename') ?>
								</td>
            					<td><label>Gender</label></td>
					            <td>
								    <select class="form-control" name="gender" id="gender" required="required">
										<option value="">-- Select --</option>
										<option <?php if(isset($aefi_info) && $aefi_info["gender"]=="1"){ if(validation_errors() != false) {echo set_select('gender','1');} else { echo 'selected="selected"';} }else {if(validation_errors() != false) { echo set_select('gender', '1');} else{ } }?> value="1">Male</option>
										<option <?php if(isset($aefi_info) && $aefi_info["gender"]=="2") {if(validation_errors() != false) {echo set_select('gender','2');} else { echo 'selected="selected"';} } else {if(validation_errors() != false) { echo set_select('gender', '2');} else{ } }?> value="2">Female</option>
									</select>
					            </td>
								<td><label>Date of birth</label></td>
								<td>
									<input placeholder="Date" onchange="ageCalculater(this.value);" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('dob'); }else { echo date("d-m-Y",strtotime($aefi_info["dob"])); } } else {if(validation_errors() != false) { echo set_value('dob'); } else { echo ''; } }?><?php echo form_error('dob'); ?>" class="dp form-control" name="dob" id="dob" type="text" readonly>
								</td>
          					</tr>
							<tr>
								<td><label>Age<small> (in years)</small></label></td>
								<td>
									<input readonly="readonly" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('age'); } else { echo $aefi_info["age"]; } } else {if(validation_errors() != false) { echo set_value('Age'); } else { echo ''; } } ?>" class="form-control" name="age" id="age" placeholder="Age" type="text">
								</td>
								<td><label>Years</label></td>
								<td>
									<input readonly="readonly" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('years'); } else { echo $aefi_info["years"]; } } else {if(validation_errors() != false) { echo set_value('Age'); } else { echo ''; } } ?>" class="form-control" name="years" id="years" placeholder="Years" type="text">
								</td>
								<td><label>Months</label></td>
								<td>
									<input readonly="readonly" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('months'); } else { echo $aefi_info["months"]; } } else {if(validation_errors() != false) { echo set_value('Age'); } else { echo ''; } } ?>" class="form-control" name="months" id="months" placeholder="Months" type="text">
								</td>
							</tr>
							<tr>
								<td><label>Weeks</label></td>
								<td>
									<input readonly="readonly" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('weeks'); } else { echo $aefi_info["weeks"]; } } else {if(validation_errors() != false) { echo set_value('Age'); } else { echo ''; } } ?>" class="form-control" name="weeks" id="weeks" placeholder="Weeks" type="text">
								</td>
								<td><label>Father's name</label></td>
								<td>
									<input class="form-control" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('fathername'); } else { echo $aefi_info["fathername"]; } } else {if(validation_errors() != false) { echo set_value('fathername'); } else { echo ''; } } ?>" name="fathername" id="fathername" placeholder="Father's name" type="text">
									<?php echo form_error('fathername'); ?>
								</td>
								</td>
								<td><label>Husband's name </label></td>
								<td>
									<input class="form-control" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('husbandname'); } else { echo $aefi_info["husbandname"]; } } else {if(validation_errors() != false) { echo set_value('husbandname'); } else { echo ''; } } ?>" name="husbandname" id="husbandname" placeholder="Husband's name" type="text">
								</td>
							</tr>
							<tr>
								<td><label>Cell Number</label></td>
								<td>
									<input  id="cellnumber" name="cellnumber" placeholder="Cell Number "  class="form-control " value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('cellnumber'); } else { echo $aefi_info["cellnumber"]; } } else {if(validation_errors() != false) { echo set_value('cellnumber'); } else { echo ''; } } ?>"/>
									<?php echo form_error('cellnumber'); ?>
								</td>
								<td><label>Village</label></td>
								<td>
									<input class="form-control" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('village'); } else { echo $aefi_info["village"]; } } else {if(validation_errors() != false) { echo set_value('village'); } else { echo ''; } } ?>" name="village" id="village"  placeholder="Village" type="text">
								</td>
								<td><label>Province</label></td>
								<td>
									<input readonly="readonly" class="form-control" placeholder="<?php echo $this -> session -> provincename ?>" type="text">
								</td>
							</tr>
							<tr>
								<td><label>District</label></td>
								<td>
									<select class="form-control" name="distcode" id="distcode" required="required">
										<?php 
											if(isset($aefi_info)){
												echo getDistricts(false,$aefi_info["distcode"]);
											}else{
												echo getDistricts();
											}
										?>
									</select>
								</td>
								<td><label>Tehsil/Taluka</label></td>
								<td>
									<?php if(isset($aefi_info)){ ?>
									<select class="form-control" name="tcode" id="tcode">
										<option value="<?php echo $aefi_info["tcode"]; ?>"><?php echo $tehsil; ?></option>
									</select>
									<?php } else { ?>
									<select class="form-control" name="tcode" id="tcode" required="required"><?php getTehsils_options(false); } ?>
									</select>
								</td>
								<td><label>UC</label></td>
								<input id="module" type="hidden" value="disease_surveillance">
								<td>
									<select  class="form-control" required="required"  name="uncode" id="uncode"> 
										<?php if(isset($aefi_info)) { ?>
											<option value="<?php echo $aefi_info['uncode']; ?>" <?php if(validation_errors() != false) { echo set_select('uncode',$aefi_info['uncode']);} ?> > <?php echo $un_name; ?></option>
										<?php }else{ ?>
											<option  value="">-- Select --</option> 					 
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label>Health Facility</label></td>
								<td>
									<select class="form-control" required="required" name="facode" id="facode"> 
										<?php if(isset($aefi_info)) { ?>
											<option value="<?php echo $aefi_info['facode']; ?>" <?php if(validation_errors() != false) { echo set_select('facode',$aefi_info['facode']);} ?>> <?php echo $facility; ?></option>
										<?php }else{ ?>
											<option  value="">-- Select --</option>
										<?php } ?>
									</select>
								</td>
								<td><label class="pt7">Year</label></td>
								<td>
									<select class="form-control text-center" required name="year" id="year">
										<?php if(isset($aefi_info)){ ?>
											<option value="<?php echo $aefi_info["year"]; ?>"><?php echo $aefi_info["year"]; ?></option>
										<?php } else { ?>
										<?php echo $years; } ?>
									</select>
								</td>
								<td><label class="pt7">EPI Week No</label></td>
								<td>
									<select class="form-control" required name="week" id="week">
										<?php if(isset($aefi_info)){ ?>
											<option value="<?php echo sprintf("%02d", $aefi_info["week"]); ?>">Week <?php echo sprintf("%02d", $aefi_info["week"]); ?></option>
										<?php }else{ ?>
											<option>--Select Week No--</option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label class="pt7">Date From</label></td>
								<td>
									<input class="form-control text-center" required="required" readonly="readonly" name="datefrom" id="datefrom" value="<?php if(isset($aefi_info)){ echo date('d-m-Y',strtotime($aefi_info["datefrom"])); }else { if(validation_errors() != false) { echo set_value('datefrom');} else{ } } ?>"  placeholder="From" type="text"></td>
								<td><label class="pt7">Date To</label></td>
								<td>
									<input class="form-control text-center" required="required" readonly="readonly" name="dateto" id="dateto" value="<?php if(isset($aefi_info)){ echo date('d-m-Y',strtotime($aefi_info["dateto"])); }else { if(validation_errors() != false) { echo set_value('dateto');} else{ } } ?>" placeholder="To" type="text">
								</td>
							</tr>
      					</tbody>
    				</table>
    				<table class="table table-bordered table-condensed table-striped table-hover mytable3">
						<thead>
							<tr>
								<th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Clinical Information (Major complaints put tick as appropriate)</th>
							</tr>
						</thead>
         				<tbody>
	                		<tr>
				                <td><label>a) BCG Lymphadenitis</label></td>
				                <td>
				                    <input name="mc_bcg" id="mc_bcg" value="0" <?php if(isset($aefi_info) && $aefi_info["mc_bcg"]==0)  { echo 'unchecked="unchecked"'; } else {}?> type="hidden">
				                    <input name="mc_bcg" id="mc_bcg" value="1" <?php if(isset($aefi_info) && $aefi_info["mc_bcg"]==1) {if(validation_errors() != false) { echo set_checkbox('mc_bcg','1');} else { echo 'checked="checked"'; } }else {if(validation_errors() != false) { echo set_checkbox('mc_bcg','1');} } ?> style="margin-top: 11px;" type="checkbox">
				                </td>
								<td><label>b) Severe Local Reaction</label></td>
								<td>
									<input name="mc_severe" id="mc_severe" value="0" <?php if(isset($aefi_info) && $aefi_info["mc_severe"]==0)  { echo 'unchecked="unchecked"'; } else {}?> type="hidden">
									<input name="mc_severe" id="mc_severe" value="1" <?php if(isset($aefi_info) && $aefi_info["mc_severe"]==1) {if(validation_errors() != false) { echo set_checkbox('mc_severe','1');} else { echo 'checked="checked"'; } }else {if(validation_errors() != false) { echo set_checkbox('mc_severe','1');} } ?> style="margin-top: 11px;" type="checkbox">
								</td>
	              				<td><label>c) Injection site abscess</label></td>
								<td>
									<input name="mc_abscess" id="mc_abscess" value="0" <?php if(isset($aefi_info) && $aefi_info["mc_abscess"]==0)  { echo 'unchecked="unchecked"'; } else {}?> type="hidden">
									<input name="mc_abscess" id="mc_abscess" value="1" <?php if(isset($aefi_info) && $aefi_info["mc_abscess"]==1) {if(validation_errors() != false) { echo set_checkbox('mc_abscess','1');} else { echo 'checked="checked"'; } }else {if(validation_errors() != false) { echo set_checkbox('mc_abscess','1');} } ?> style="margin-top: 11px;" type="checkbox">
								</td>
	            			</tr>
							<tr>
								<td><label>d) Fever</label></td>
								<td>
									<input name="mc_fever" id="mc_fever" value="0" <?php if(isset($aefi_info) && $aefi_info["mc_fever"]==0)  { echo 'unchecked="unchecked"'; } else {}?> type="hidden">
									<input name="mc_fever" id="mc_fever" value="1" <?php if(isset($aefi_info) && $aefi_info["mc_fever"]==1) {if(validation_errors() != false) { echo set_checkbox('mc_fever','1');} else { echo 'checked="checked"'; } }else {if(validation_errors() != false) { echo set_checkbox('mc_fever','1');} } ?> style="margin-top: 11px;" type="checkbox">
								</td>
								<td><label>e) Rash</label></td>
								<td>
									<input name="mc_rash" id="mc_rash" value="0" <?php if(isset($aefi_info) && $aefi_info["mc_rash"]==0)  { echo 'unchecked="unchecked"'; } else {}?> type="hidden">
									<input name="mc_rash" id="mc_rash" value="1" <?php if(isset($aefi_info) && $aefi_info["mc_rash"]==1) {if(validation_errors() != false) { echo set_checkbox('mc_rash','1');} else { echo 'checked="checked"'; } }else {if(validation_errors() != false) { echo set_checkbox('mc_rash','1');} } ?> style="margin-top: 11px;" type="checkbox">
								</td>
								<td><label>f) Convulsion</label>
								</td>
								<td>
									<input name="mc_convulsion" id="mc_convulsion" value="0" <?php if(isset($aefi_info) && $aefi_info["mc_convulsion"]==0)  { echo 'unchecked="unchecked"'; } else {}?> type="hidden">
									<input name="mc_convulsion" id="mc_convulsion" value="1" <?php if(isset($aefi_info) && $aefi_info["mc_convulsion"]==1) {if(validation_errors() != false) { echo set_checkbox('mc_convulsion','1');} else { echo 'checked="checked"'; } }else {if(validation_errors() != false) { echo set_checkbox('mc_convulsion','1');} } ?> style="margin-top: 11px;" type="checkbox">
								</td>
							</tr>
							<tr>
								<td><label>g) Unconsciousness</label>
								</td>
								<td>
									<input name="mc_unconscious" id="mc_unconscious" value="0" <?php if(isset($aefi_info) && $aefi_info["mc_unconscious"]==0)  { echo 'unchecked="unchecked"'; } else {}?> type="hidden">
									<input name="mc_unconscious" id="mc_unconscious" value="1" <?php if(isset($aefi_info) && $aefi_info["mc_unconscious"]==1) {if(validation_errors() != false) { echo set_checkbox('mc_unconscious','1');} else { echo 'checked="checked"'; } }else {if(validation_errors() != false) { echo set_checkbox('mc_unconscious','1');} } ?> style="margin-top: 11px;" type="checkbox">
								</td>
								<td><label>h) Respiratory Distress</label></td>
								<td>
									<input name="mc_respiratory" id="mc_respiratory" value="0" <?php if(isset($aefi_info) && $aefi_info["mc_respiratory"]==0)  { echo 'unchecked="unchecked"'; } else {}?> type="hidden">
									<input name="mc_respiratory" id="mc_respiratory" value="1" <?php if(isset($aefi_info) && $aefi_info["mc_respiratory"]==1) {if(validation_errors() != false) { echo set_checkbox('mc_respiratory','1');} else { echo 'checked="checked"'; } }else {if(validation_errors() != false) { echo set_checkbox('mc_respiratory','1');} } ?> style="margin-top: 11px;" type="checkbox">
								</td>
								<td><label>i) Swelling of body or face</label>
								</td>
								<td>
									<input name="mc_swelling" id="mc_swelling" value="0" <?php if(isset($aefi_info) && $aefi_info["mc_swelling"]==0)  { echo 'unchecked="unchecked"'; } else {}?> type="hidden">
									<input name="mc_swelling" id="mc_swelling" value="1" <?php if(isset($aefi_info) && $aefi_info["mc_swelling"]==1) {if(validation_errors() != false) { echo set_checkbox('mc_swelling','1');} else { echo 'checked="checked"'; } }else {if(validation_errors() != false) { echo set_checkbox('mc_swelling','1');} } ?> style="margin-top: 11px;" type="checkbox">
								</td>
							</tr>
							<tr>
								<td><label>j) Others</label>
								</td>
								<td>
									<input class="form-control" name="mc_other" id="mc_other" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('mc_other'); } else { echo $aefi_info["mc_other"]; } } else {if(validation_errors() != false) { echo set_value('mc_other'); } else { echo ''; } } ?>" placeholder="Please Specify" type="text">
									<?php echo form_error('mc_other'); ?>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><label>Emergency / initial treatment given(in case where b,e,f,g,h or j)</label>
								</td>
								<td>
									<table style="width:100%;margin-top: 6px;">
										<tr>
											<td>
												Yes<input name="mc_treatment" <?php if(isset($aefi_info) && $aefi_info["mc_treatment"]==1){if(validation_errors() != false) { echo set_checkbox('mc_treatment','1');} else { echo 'checked="checked"'; } } else {if(validation_errors() != false) { echo set_checkbox('mc_treatment','1');} } ?> value="1" type="radio">
											</td>
											<td>
												No<input name="mc_treatment" <?php if(isset($aefi_info) && $aefi_info["mc_treatment"]==0 || $aefi_info["mc_treatment"]==""){ if(validation_errors() != false) { echo set_checkbox('mc_treatment','0');} else { echo 'checked="checked"'; } } ?> value="0" type="radio">
											</td>
										</tr>
									</table>
								</td>
								<td><label>Is the case hospitalized</label></td>
								<td>
									<table style="width:100%;margin-top: 6px;">
										<tr>
											<td>
											Yes<input name="mc_hospitalized" <?php if(isset($aefi_info) && $aefi_info["mc_hospitalized"]==1){if(validation_errors() != false) { echo set_checkbox('mc_hospitalized','1');} else { echo 'checked="checked"'; } } else {if(validation_errors() != false) { echo set_checkbox('mc_hospitalized','1');} } ?> value="1"  type="radio">
											</td>
											<td>
											No<input name="mc_hospitalized" <?php if(isset($aefi_info) && $aefi_info["mc_hospitalized"]==0 || $aefi_info["mc_hospitalized"]==""){ if(validation_errors() != false) { echo set_checkbox('mc_hospitalized','0');} else { echo 'checked="checked"'; } } ?> value="0" type="radio">
											</td>
										</tr>
									</table>
								</td> 
								<td><label>If Yes, Name and address of the hospital</label></td>
								<td>
									<input class="form-control" name="mc_hosp_address" id="mc_hosp_address" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('mc_hosp_address'); } else { echo $aefi_info["mc_hosp_address"]; } } else {if(validation_errors() != false) { echo set_value('mc_hosp_address'); } else { echo ''; } } ?>" placeholder="Name and address of the hospital" type="text">
								</td>
							</tr>
	          			</tbody>
	        		</table>
	        		<table class="table table-bordered table-condensed table-striped table-hover mytable3">
						<thead>
							<tr>
								<th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Information regarding vaccine and vaccination</th>
							</tr>
						</thead>
	          			<tbody>
			<tr>
  				<td><label>Date of vaccination</label></td>
	            <td>
	            	<input placeholder="Date of vaccination" name="vacc_date" id="vacc_date" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('vacc_date'); }else { echo date("d-m-Y",strtotime($aefi_info["vacc_date"])); } } else {if(validation_errors() != false) { echo set_value('vacc_date'); } else { echo ''; } } ?>" class="dp form-control" type="text">
	            </td>
				<td><label>Name of vaccine(s) received on this day</label></td>
	            <td>
	            	<?php
            			if(isset($aefi_info)){
            				if($aefi_info["vacc_name"]>=1 && $aefi_info["vacc_name"]<=100000) { ?>
				            	<select class="form-control" name="vacc_name" id="vacc_id">
			            			<option>---- Select Vaccine ----</option>
			            			<?php echo get_vaccineslist(true, $aefi_info["vacc_name"]); ?>
			            		</select>
			            	<?php } else { ?>
			            		<input class="form-control" name="vacc_name" id="vacc_name" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('vacc_name'); } else { echo $aefi_info["vacc_name"]; } } else {if(validation_errors() != false) { echo set_value('vacc_name'); } else { echo ''; } } ?>" placeholder="Name of vaccine(s) received on this day" type="text">
			            	<?php } ?>
			            <?php } else { ?>
			            	<select class="form-control" name="vacc_name" id="vacc_id">
			            		<option>---- Select Vaccine ----</option>
			            		<?php echo get_vaccineslist(); ?>
			            	</select>
			        <?php } ?>
	            	<!-- <input class="form-control" name="vacc_name" id="vacc_name" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('vacc_name'); } else { echo $aefi_info["vacc_name"]; } } else {if(validation_errors() != false) { echo set_value('vacc_name'); } else { echo ''; } } ?>" placeholder="Name of vaccine(s) received on this day" type="text"> -->
	            </td>
			</tr>
            <tr>
            	<td><label>Name of manufacturer & Batch/Lot no. of vaccine(s)</label></td>
            	<td>
            		<?php
            			if(isset($aefi_info)){
            				if($aefi_info["id"]>92) { ?>
			            		<select class="form-control" name="vacc_manufacturer" id="batch_number">
			            			<option>---- Select batch number ----</option>
									<?php echo get_batcheslist(true, $aefi_info["vacc_manufacturer"]); ?>
			            		</select>
			            	<?php } else { ?>
			            		<input class="form-control" name="vacc_manufacturer" id="vacc_manufacturer" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('vacc_manufacturer'); } else { echo $aefi_info["vacc_manufacturer"]; } } else {if(validation_errors() != false) { echo set_value('vacc_manufacturer'); } else { echo ''; } } ?>" placeholder="Name of manufacturer & Batch/Lot no. of vaccine(s)" type="text">
			            	<?php } ?>
			           	<?php } else { ?>
			           		<select class="form-control" name="vacc_manufacturer" id="batch_number">
								<option>---- Select batch number ----</option>
								<?php echo get_batcheslist(); ?>
			            	</select>
			           	<?php } ?>
            		<!-- <input class="form-control" name="vacc_manufacturer" id="vacc_manufacturer" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('vacc_manufacturer'); } else { echo $aefi_info["vacc_manufacturer"]; } } else {if(validation_errors() != false) { echo set_value('vacc_manufacturer'); } else { echo ''; } } ?>" placeholder="Name of manufacturer & Batch/Lot no. of vaccine(s)" type="text"> -->
            	</td>
	            <td><label>Expiry date of vaccine(s)</label></td>
	            <td>
	            	<input type="" name="vacc_exp" placeholder="Expiry date of vaccine(s)" id="vacc_exp" class="form-control" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('vacc_exp'); } else { echo date("d-m-Y",strtotime($aefi_info["vacc_exp"])); } } else {if(validation_errors() != false) { echo set_value('vacc_exp'); } else { echo ''; } } ?>" readonly>
	            	<!-- <input placeholder="Expiry date of vaccine(s)" name="vacc_exp" id="vacc_exp" value="<?php //if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('vacc_exp'); } else { echo date("d-m-Y",strtotime($aefi_info["vacc_exp"])); } } else {if(validation_errors() != false) { echo set_value('vacc_exp'); } else { echo ''; } } ?>" class="form-control" type="text" readonly> -->
	            </td>
			</tr>
							<tr>
								<td><label>Name and address of vaccination center</label></td>
								<td>
									<input class="form-control" name="vacc_center" id="vacc_center" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('vacc_center'); } else { echo $aefi_info["vacc_center"]; } } else {if(validation_errors() != false) { echo set_value('vacc_center'); } else { echo ''; } } ?>" placeholder="Name and address of vaccination center" type="text">
								</td>
								<td><label>Name & designation of person who vaccinated</label></td>
								<td>
									<input class="form-control" name="vacc_vaccinator" id="vacc_vaccinator" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('vacc_vaccinator'); } else { echo $aefi_info["vacc_vaccinator"]; } } else {if(validation_errors() != false) { echo set_value('vacc_vaccinator'); } else { echo ''; } } ?>" placeholder="Name & designation of person who vaccinated" type="text">
								</td>
							</tr>
	          			</tbody>
	        		</table>
					<table class="table table-bordered table-condensed table-striped table-hover mytable3">
						<thead>
							<tr>
								<th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><label>Name of the reporting person</label></td>
								<td>
									<input class="form-control" name="rep_person" id="rep_person" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('rep_person'); } else { echo $aefi_info["rep_person"]; } } else {if(validation_errors() != false) { echo set_value('rep_person'); } else { echo ''; } } ?>" placeholder="Name of the reporting person" type="text">
								</td>
								<td><label>Designation of the reporting person</label></td>
								<td>
									<input class="form-control" name="rep_desg" id="rep_desg" value="<?php if(isset($aefi_info)){ if(validation_errors() != false){ echo set_value('rep_desg'); } else { echo $aefi_info["rep_desg"]; } } else {if(validation_errors() != false) { echo set_value('rep_desg'); } else { echo ''; } } ?>" placeholder="Designation of the reporting person" type="text">
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
								<?php if(isset($aefi_info)) { ?>
									<td class="text-center" id="get_date">
										<?php if(isset($aefi_info)){ echo $current_date; } ?>
									</td>
									<input type="hidden" id="editted_date" name="editted_date" value="<?php if(isset($aefi_info)){ echo date('d-m-Y',strtotime($aefi_info->editted_date)); } else { echo $current_date; } ?>" type="date">
								<?php } else { ?>
									<td class="text-center"><?php echo $current_date; ?> </td>
									<input type="hidden" name="submitted_date" value="<?php echo $current_date; ?>" type="date">
								<?php } ?>
							</tr>
						</tbody>
					</table>
					<div class="row">
						<hr>
						<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
							<?php if(isset($aefi_info)) { ?>
								<button style="background: #008d4c;" type="submit" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save </button>
								<button style="background: #008d4c;" type="submit" name="is_temp_saved" value="0" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit </button>
							<?php } else { ?>
								<button style="background: #008d4c;" type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save </button>
								<button style="background: #008d4c;" type="submit" name="is_temp_saved" value="0" id="myCoolForm" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit </button>
							<?php } ?>
							<button onclick="javascript:disablebuttons();" type="reset" style="background: #008d4c;" class="btn btn-primary btn-md">
							<i class="fa fa-repeat"></i> Reset</button>
							<!-- <a href="#" onclick="history.go(-1);" style="background: #008d4c" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a> -->
							<a href="<?php echo base_url(); ?>AEFI-CIF/List" style="background: #008d4c" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
						</div>
					</div>      
      			</form>
    		</div> <!--end of panel body-->
 		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--end of body container-->

<script src="<?php echo base_url(); ?>includes/js/moment.js"></script>
<script type="text/javascript">
	$("input:checkbox").change(function(){
	    var group = ":checkbox[name='"+ $(this).attr("name") + "']";
	    if($(this).is(':checked')){
	      	$(group).not($(this)).attr("checked",false);
	    }
	});
</script>
<script type="text/javascript">
	<?php if(!isset($aefi_info)) { ?>
		$(document).ready(function(){
			$('#batch_number').html('');
		});
		$(document).on('change','#vacc_id', function(){
			var vacc_id = $('#vacc_id').val();
			//alert(vacc_id);
			$.ajax({
				type: 'POST',
				data: 'vacc_id='+vacc_id,
				url: '<?php echo base_url();?>Ajax_red_rec/getVaccine_batchNumber',
				success: function(data){
					$('#batch_number').html(data);
					$('#vacc_exp').val('');
					//$('#patient_address_distcode').trigger('change');
				}
			});
		});

		$(document).on('change','#batch_number', function(){
			var batch_number = $('#batch_number').val();
			//alert(batch_number);
			$.ajax({
				type: 'POST',
				data: 'batch_number='+batch_number,
				url: '<?php echo base_url();?>Ajax_red_rec/get_vaccine_expirydate',
				success: function(data){
					$('#vacc_exp').val(data);
				}
			});
		});
	<?php } else { ?>
		$(document).on('change','#vacc_id', function(){
			var vacc_id = $('#vacc_id').val();
			//alert(vacc_id);
			$.ajax({
				type: 'POST',
				data: 'vacc_id='+vacc_id,
				url: '<?php echo base_url();?>Ajax_red_rec/getVaccine_batchNumber',
				success: function(data){
					$('#batch_number').html(data);
					$('#vacc_exp').val('');
				}
			});
		});

		$(document).on('change','#batch_number', function(){
			var batch_number = $('#batch_number').val();
			//alert(batch_number);
			$.ajax({
				type: 'POST',
				data: 'batch_number='+batch_number,
				url: '<?php echo base_url();?>Ajax_red_rec/get_vaccine_expirydate',
				success: function(data){
					$('#vacc_exp').val(data);
				}
			});
		});
	<?php } ?>

	$(document).ready(function(){
		//alert("usman");
		//***************************code to disable save starts here****************************//
		function disablebuttons()
		{
			$('#myCoolForm').prop('disabled', true);
			$('#save').prop('disabled', true);
		}
		<?php if(!isset($measles_Result)){?>
			$('#save').prop('disabled', 'disabled');
			$('#myCoolForm').prop('disabled', 'disabled');
			$(document).on('change', '#facode,#rb_facode',function(){
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

		//***************************code to disable submit ends here********************************//
		<?php if(!isset($aefi_info)){ ?>
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
		
		var tcode = $('#tcode').val();
		if(tcode==0){
		  	$("select option").each(function(){
				if ($(this).val() == 0){
				   	$(this).val("");
				}		   
		  	});
		}
			
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
							alert("Year is restricted to current and previouse!");
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
						}
						else{
							$('#week').html(response);
							document.getElementById("year").style.borderColor = "";
							$('#week').trigger("change");
						}
					}
				});
			}
		});
		$(document).on('change','#week',function(){
			var week = $("#week").val();
			var year = $('#year').val();
			if(week == 0 && year !=""){
				$('#datefrom').val("");
				$('#dateto').val("");
			}
			else{
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
		});
		
		////Code For Save Form With Control+S Event//////////////
		$(document).on('keydown', function(e){
			if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
				$("#save").click();
				e.preventDefault();
				return false;
			}
		});  
  	});
	$(window).load(function () {
		var get_date = $('#get_date').text();
		$('#editted_date').val(get_date);
		
		selecteduncode = '<?php echo isset($aefi_info)?$aefi_info["uncode"]:0; ?>';
		if($('#dob').val() != ''){
			var fromdate = $('#dob').val();
			var todate;
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
		    if(ydiff> 0) $('#age').val(ydiff);
		    if(ydiff> 0) $('#years').val(ydiff);
		    if(mdiff> 0){ $('#months').val(mdiff); }else{ $('#months').val('0'); };
		    if(ddiff> 0) $('#weeks').val(Math.floor(ddiff/7));
		}
	});
	function disablebuttons()
	{
		$('#myCoolForm').prop('disabled', true);
	    $('#save').prop('disabled', true);
	}
	<?php if(!isset($measles_Result)) { ?>
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
	function ageCalculater(fromdate,todate){
		fromdate = moment(fromdate, "DD-MM-YYYY").format("MM/DD/YYYY");
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
	    if(ydiff> 0) $('#age').val(ydiff);
	    if(ydiff> 0) $('#years').val(ydiff);
	    if(mdiff> 0) { $('#months').val(mdiff); } else { $('#months').val('0'); };
	    if(ddiff> 0) $('#weeks').val(Math.floor(ddiff/7));	   	
	    //return age.join(''); 
	}

	
</script>