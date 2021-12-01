<?php
date_default_timezone_set('Asia/Karachi'); // CDT
$current_date = date('d-m-Y');?>
<div class="container bodycontainer">  
<div class="row">
 <div class="panel panel-primary">
	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
   <div class="panel-heading"> Facility Monthly Vaccination Reporting Form</div>
     <div class="panel-body">
     <?php
		//print_r($data['fmvrf_info']);exit();
		if(isset($fmvrf_info) && validation_errors() == false ){
			$path = base_url()."data_entry/fac_mvrf_update/".$fmvrf_info["id"];
		}
		else if(isset($id)){
			$path = base_url()."data_entry/fac_mvrf_update/".$id;
		}else{ 
			$path = base_url()."data_entry/fac_mvrf_save";
		} ?>
      <form class="form-horizontal" id="form" method="post" enctype="multipart/form-data" action="<?php echo $path; ?>" >
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
					<?php echo getAllMonthsOptions(); ?>
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
            <td><label>Union Council</label></td>
            <td>
			<input id="module" type="hidden" value="vaccine">
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
              <label>Male</label>
              <input class="form-control numberclass" name="tc_male" id="tc_male" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('tc_male'); }else{ echo $fmvrf_info["tc_male"]; } } else {if(validation_errors() != false) {echo set_value('tc_male'); } else{echo '0';} } ?>" placeholder="Number" style="width: 65%;display: inline;margin-left: 5%;" type="text">
          	<?php echo form_error('tc_male'); ?>
            </td>
            <td>
              <label>Female</label>
              <input class="form-control numberclass" name="tc_female" id="tc_female" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('tc_female'); }else{ echo $fmvrf_info["tc_female"]; } } else {if(validation_errors() != false) {echo set_value('tc_female'); } else{echo '0';} } ?>" style="width: 65%;display: inline;margin-left: 5%;" placeholder="Number" type="text">
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
      </tbody></table>
 
    
    <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="10" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">EPI Services</th>
            </tr>
            <tr>
             
              <!-- <th>Fixed EPI Centers</th> -->
              <th colspan="2">Fixed Vaccination Session by Vaccinator/s</th>
              <th colspan="2">Outreach Vaccination Session by Vaccinator/s</th>
              <th colspan="2">Mobile Vaccination Session by Vaccinator/s</th>
              <th colspan="2">Health House Vaccination Session by LHWs</th>
            </tr>
            <tr>
              <!-- <th>Total</th> -->
             <!--  <th><input class="form-control numberclass" name="tot_fixed_centers" id="tot_fixed_centers" type="text"  value="<?php //if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('tot_fixed_centers'); }else{ echo $fmvrf_info["tot_fixed_centers"]; } } else {if(validation_errors() != false) {echo set_value('tot_fixed_centers'); } else{echo '0';} } ?>" style="width: 93%;margin: 2px;margin-left: 5px;margin-top: 2px;margin-bottom: 2px;"></th> -->
              <th>Planned</th>
              <th>Actually held</th>
              <th>Planned</th>
              <th>Actually held</th>
              <th>Planned</th>
              <th>Actually held</th>
              <th>Planned</th>
              <th>Actually held</th>
            </tr>
            
          </thead>
          <tbody>
            <tr>
             <!--  <td><label>Functioning</label><br>
                  <label>Reporting</label>
              </td> -->
             <!--  <td><input class="form-control numberclass" name="functioning_centers" id="functioning_centers" value="<?php //if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('functioning_centers'); }else{ echo $fmvrf_info["functioning_centers"]; } } else {if(validation_errors() != false) {echo set_value('functioning_centers'); } else{echo '0';} } ?>" type="text">
                <input class="form-control numberclass" name="reporting_centers" id="reporting_centers" readonly="readonly" value="<?php// if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('reporting_centers'); }else{ echo $fmvrf_info["reporting_centers"]; } } else {if(validation_errors() != false) {echo set_value('reporting_centers'); } else{echo '0';} } ?>" type="text">
              </td> -->
              <td><input class="form-control numberclass" name="fixed_vacc_planned" id="fixed_vacc_planned" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('fixed_vacc_planned'); }else{ echo $fmvrf_info["fixed_vacc_planned"]; } } else {if(validation_errors() != false) {echo set_value('fixed_vacc_planned'); } else{echo '0';} } ?>" type="text" style="height: 68px;"></td>
              <td><input class="form-control numberclass" name="fixed_vacc_held" id="fixed_vacc_held" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('fixed_vacc_held'); }else{ echo $fmvrf_info["fixed_vacc_held"]; } } else {if(validation_errors() != false) {echo set_value('fixed_vacc_held'); } else{echo '0';} } ?>" type="text" style="height: 68px;"></td>
              <td><input class="form-control numberclass" name="or_vacc_planned" id="or_vacc_planned" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('or_vacc_planned'); }else{ echo $fmvrf_info["or_vacc_planned"]; } } else {if(validation_errors() != false) {echo set_value('or_vacc_planned'); } else{echo '0';} } ?>"  type="text" style="height: 68px;"></td>
              <td><input class="form-control numberclass" name="or_vacc_held" id="or_vacc_held" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('or_vacc_held'); }else{ echo $fmvrf_info["or_vacc_held"]; } } else {if(validation_errors() != false) {echo set_value('or_vacc_held'); } else{echo '0';} } ?>" type="text" style="height: 68px;"></td>
              <!-- ======================================== -->
              <td><input class="form-control numberclass" name="mv_vacc_planned" id="mv_vacc_planned" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('mv_vacc_planned'); }else{ echo $fmvrf_info["mv_vacc_planned"]; } } else {if(validation_errors() != false) {echo set_value('mv_vacc_planned'); } else{echo '0';} } ?>" type="text" style="height: 68px;"></td>
              <td><input class="form-control numberclass" name="mv_vacc_held" id="mv_vacc_held" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('mv_vacc_held'); }else{ echo $fmvrf_info["mv_vacc_held"]; } } else {if(validation_errors() != false) {echo set_value('mv_vacc_held'); } else{echo '0';} } ?>" type="text" style="height: 68px;"></td>
              <!-- ========================================= -->
              <td><input class="form-control numberclass" name="hh_vacc_planned" id="hh_vacc_planned" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('hh_vacc_planned'); }else{ echo $fmvrf_info["hh_vacc_planned"]; } } else {if(validation_errors() != false) {echo set_value('hh_vacc_planned'); } else{echo '0';} } ?>" type="text" style="height: 68px;"></td>
              <td><input class="form-control numberclass" name="hh_vacc_held" id="hh_vacc_held" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('hh_vacc_held'); }else{ echo $fmvrf_info["hh_vacc_held"]; } } else {if(validation_errors() != false) {echo set_value('hh_vacc_held'); } else{echo '0';} } ?>" type="text" style="height: 68px;"></td>
            </tr>
          </tbody>
        </table>
<div id="parent"> 
			
      <table id="fixTable" class="table table-bordered table-condensed table-striped table-hover mytable3">
         <thead>
							 <tr>
                <th colspan="5"  style="width:45%; border-right:0;">
								<ul class="nav nav-tabs" style="border-bottom:none;">
									<li class="active">
										<a href="#tab-1" data-toggle="tab" aria-expanded="true" style="color:black; font-size: 10px;font-family: initial;font-style: normal;font-weight: bold;color: #030303;text-transform: uppercase;" >
										Inside UC</a>
									</li>
									<li class="">
										<a href="#tab-2" data-toggle="tab" aria-expanded="false" style="color:black; font-size: 10px;font-family: initial;font-style: normal;font-weight: bold;color: #030303;text-transform: uppercase;">
										OutSide UC</a>
									</li>	
                                    <li class="">
										<a href="#tab-3" data-toggle="tab" aria-expanded="false" style="color:black; font-size: 10px;font-family: initial;font-style: normal;font-weight: bold;color: #030303;text-transform: uppercase;">
										Out District</a>
									</li>										
									<!--<li>
                                     <input type="radio" name="direction" value="horizontal"> <span class="wrap">Horizantel</span><br>
                                     <input type="radio" name="direction" value="vertical" > <span class="wrap">Vertical</span> <br>
									</li>-->
                            	</ul>
								</th>
								<th colspan="15" style="text-align: left; padding-top: 10px; padding-bottom: 10px;border-left: 0;">A. Childhood Routine Immunization</th>
              </tr>
          </thead>
						<tbody>
							<tr>
								<td colspan="20">
									<div class="tab-content">
										
										<div class="tab-pane active" id="tab-1">
												<table class="table table-bordered table-condensed table-striped table-hover mytable3" style="border-collapse: inherit !important;">
														<thead class="trans">
														              <tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2">Vaccination<br>Given to<br>Children</th>
                <th colspan="18">Vaccines</th>
              </tr>
              <tr>
                <th>&nbsp;&nbsp;BCG&nbsp;&nbsp;</th>
                <th>Hep B-Birth</th>
                <th>OPV-0</th>
                <th>OPV-1</th>
                <th>OPV-2</th>
                <th>OPV-3</th>
				<th>Rota-1</th>
                <th>Rota-2</th>
                <th>&nbsp;&nbsp;IPV&nbsp;&nbsp;</th>
                <th>PCV10<br>-1</th>
                <th>PCV10<br>-2</th>
                <th>PCV10<br>-3</th>
                <th>PENTA<br>-1</th>
                <th>PENTA<br>-2</th>
                <th>PENTA<br>-3</th>                
                <th>Measles<br>-1</th>
                <th>Fully Immun<br>-ized</th>
                <th>Measles<br>-2</th>
              </tr>
														</thead>
														<tbody>	

<!--////////////////////start new array setting /////////////////  -->
<?php 
			$productsArray = array(
				
                "bcg"=>array(
					"col"=>1,
					"blocked_cols"=> Array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24)
				),
                "hep_b"=>array(
					"col"=>2,
					"blocked_cols"=> Array(3,4,5,6,9,10,11,12,15,16,17,18,21,22,23,24)
				),
				"opv-0"=>array(
					"col"=>3,
					"blocked_cols"=> Array(3,4,5,6,9,10,11,12,15,16,17,18,21,22,23,24)
				),
				"opv-1"=>array(
					"col"=>4,
					"blocked_cols"=> Array()
				),
				"opv-2"=>array(
					"col"=>5,
					"blocked_cols"=> Array()
				),
				"opv-3"=>array(
					"col"=>6,
					"blocked_cols"=> Array()
				),
				"rota-1"=>array(
					"col"=>14,
					"blocked_cols"=> Array()
				),
				"rota-2"=>array(
					"col"=>15,
					"blocked_cols"=> Array()
				),
				"ipv"=>array(
					"col"=>13,
					"blocked_cols"=> Array(/* 3,4, */5,6,/* 9,10, */11,12,/* 15,16, */17,18,21,22,23,24)
				),
                "pcv10-1"=>array(
					"col"=>10,
					"blocked_cols"=> Array(5,6,11,12,17,18,23,24)
				),
				"pcv10-2"=>array(
					"col"=>11,
					"blocked_cols"=> Array(5,6,11,12,17,18,23,24)
				),
				"pcv10-3"=>array(
					"col"=>12,
					"blocked_cols"=> Array(5,6,11,12,17,18,23,24)
				),
				"penta-1"=>array(
					"col"=>7,
					"blocked_cols"=> Array()
				),
				"penta-2"=>array(
					"col"=>8,
					"blocked_cols"=> Array()
				),
				"penta-3"=>array(
					"col"=>9,
					"blocked_cols"=> Array()
				),
				"measal-1"=>array(
					"col"=>16,
					"blocked_cols"=> Array(19,20,21,22,23,24)
				),
				"Fully-Immun"=>array(
					"col"=>17,
					"blocked_cols"=> Array(19,20,21,22,23,24)
				),
				"measal-2"=>array(
					"col"=>18,
					"blocked_cols"=> Array(1,2,7,8,13,14,19,20)
				)
			);
?>

<!--////////////////////end  new array setting /////////////////  -->
<?php
		
		$mainHeadingArr = array("Vaccinator (Fixed)","Vaccinator (Outreach)","Vaccinator (Mobile)","Health House (LHW)");
		$otherHeadingsArr = array("0-11 Months","12-23 Months","2 Years and Above");
		$row = 1;
		$index=2;
			for($main=1;$main<=4;$main++){ 
			?>
			<tr>
              <td><label style="padding-top: 112px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;">
                <?php for($ind=0;$ind < 3;$ind++){ ?>
				<table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -6px;">
                  <tbody>
                    <tr>
                      <td><label style="padding-top: 18px;"><?php echo $otherHeadingsArr[$ind]; ?></label></td>
                      <td style="padding: 0px;">
                        <table class="table table-condensed table-bordered" style="width:100%;margin-bottom:-1px;">
                          <tbody>
                            <tr>
                              <td><label style="padding-top: 9px;">M</label></td>
                            </tr>
                            <tr>
                              <td><label style="padding-top: 8px; padding-bottom: 6px;">F</label></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
				<?php } ?>
              </td><?php
				foreach($productsArray as $key => $value){
					if($main == 2)
						$row = 7;
					else if($main == 3)
						$row = 13;
					else if($main == 4)
						$row = 19;
					else
						$row = 1;
					 ?>
					<td style="padding-left: 0px; padding-right: 0px;">
						<table class="table table-condensed" style="width: 100%;margin-bottom: -1px;margin-top: -5px;">
							<tbody class="inputwidthc">
							<?php	for($row;$row<=24;$row++){ ?>
										<tr>
											<td class="test">
												<input class="form-control zp text-center numberclass cri"   data-row="<?php echo $row; ?>" data-col="<?php echo $value['col']; ?>" <?php $var="cri_r".$row."_f".$value['col']; echo (in_array($row,$value['blocked_cols']))?'readonly="readonly"':''; ?> value="<?php if(isset($fmvrf_info)){ echo $fmvrf_info[$var]; } else { echo '0'; } ?>" name="<?php echo $var; ?>" id="<?php echo $var; ?>" type="text">
											</td>
										</tr>
										<?php
										if($row%6==0){
											break;
										}
									}	?>
							</tbody>
						</table>
					</td>
		<?php 	} ?>
			</tr>
		<?php $index++; } ?>
            <tr><!--Last table loops for TCV-->
              <td><label>Total Children Vaccinated</label></td>
              <td style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -6px;">
                  <tbody>
                    <tr>
                       
                      <td style="padding: 0px;">
                        <table class="table table-condensed table-bordered" style="width:100%;margin-bottom:-1px;">
                          <tbody>
                            <tr>
                              <td><label style="padding-top: 9px;">Male</label></td>
                            </tr>
                            <tr>
                              <td><label style="padding-top: 8px; padding-bottom: 1px;">Female</label></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
			  <?php foreach($productsArray as $key => $value){ ?>
              <td style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-condensed" style="width: 100%;margin-bottom: -1px;margin-top: -5px;">
                  <tbody class="inputwidthc">
				  <?php	for($row=25;$row<=26;$row++){ ?>
                    <tr>
                      <td><input class="form-control zp text-center numberclass" readonly="readonly" <?php $var="cri_r".$row."_f".$value['col']; ?> value="<?php if(isset($fmvrf_info)){ echo $fmvrf_info[$var]; } else { echo '0'; } ?>" name="<?php echo $var; ?>" id="<?php echo $var; ?>" type="text"></td>
                    </tr>
				  <?php } ?>                     
                  </tbody>
                </table>
              </td>
			  <?php } ?>
            </tr>
    </tbody>
				</table>
			</div>
			
				<div class="tab-pane" id="tab-2">
													<table class="table table-bordered table-condensed table-striped table-hover mytable3" style="border-collapse:inherit;">
														<thead class="trans">
														              <tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2">Vaccination<br>Given to<br>Children</th>
                <th colspan="18">Vaccines</th>
              </tr>
              <tr>
               <th>&nbsp;&nbsp;BCG&nbsp;&nbsp;</th>
                <th>Hep B-Birth</th>
                <th>OPV-0</th>
                <th>OPV-1</th>
                <th>OPV-2</th>
                <th>OPV-3</th>
				<th>Rota-1</th>
                <th>Rota-2</th>
                <th>&nbsp;&nbsp;IPV&nbsp;&nbsp;</th>
                <th>PCV10<br>-1</th>
                <th>PCV10<br>-2</th>
                <th>PCV10<br>-3</th>
                <th>PENTA<br>-1</th>
                <th>PENTA<br>-2</th>
                <th>PENTA<br>-3</th>                
                <th>Measles<br>-1</th>
                <th>Fully Immun<br>-ized</th>
                <th>Measles<br>-2</th>
              </tr>
														</thead>
														<tbody>	
			<?php
		
		$mainHeadingArr = array("Vaccinator (Fixed)","Vaccinator (Outreach)","Vaccinator (Mobile)","Health House (LHW)");
		$otherHeadingsArr = array("0-11 Months","12-23 Months","2 Years and Above");
		$row = 1;
		$index=2;
			for($main=1;$main<=4;$main++){ 
			?>
			<tr>
              <td><label style="padding-top: 112px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;">
                <?php for($ind=0;$ind < 3;$ind++){ ?>
				<table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -6px;">
                  <tbody>
                    <tr>
                      <td><label style="padding-top: 18px;"><?php echo $otherHeadingsArr[$ind]; ?></label></td>
                      <td style="padding: 0px;">
                        <table class="table table-condensed table-bordered" style="width:100%;margin-bottom:-1px;">
                          <tbody>
                            <tr>
                              <td><label style="padding-top: 9px;">M</label></td>
                            </tr>
                            <tr>
                              <td><label style="padding-top: 8px; padding-bottom: 6px;">F</label></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
				<?php } ?>
              </td><?php
			  
				foreach($productsArray as $key => $value){
					if($main == 2)
						$row = 7;
					else if($main == 3)
						$row = 13;
					else if($main == 4)
						$row = 19;
					else
						$row = 1;
					 ?>
					<td style="padding-left: 0px; padding-right: 0px;">
						<table class="table table-condensed" style="width: 100%;margin-bottom: -1px;margin-top: -5px;">
							<tbody class="inputwidthc">
							<?php	for($row;$row<=24;$row++){ ?>
										<tr>
											<td>
												<input class="form-control zp text-center numberclass oui "     data-row="<?php echo $row; ?>" data-col="<?php echo $value['col']; ?>" <?php $var="oui_r".$row."_f".$value['col']; echo (in_array($row,$value['blocked_cols']))?'readonly="readonly"':''; ?> value="<?php if(isset($fmvrf_info)){ echo $fmvrf_info[$var]; } else { echo '0'; } ?>" name="<?php echo $var; ?>" id="<?php echo $var; ?>" type="text">
											</td>
										</tr>
										<?php
										if($row%6==0){
											break;
										}
									}	?>
							</tbody>
						</table>
					</td>
		<?php 	  } ?>
			</tr>
		<?php $index++; } ?>
            <tr><!--Last table loops for TCV-->
              <td><label>Total Children Vaccinated</label></td>
              <td style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -6px;">
                  <tbody>
                    <tr>
                       
                      <td style="padding: 0px;">
                        <table class="table table-condensed table-bordered" style="width:100%;margin-bottom:-1px;">
                          <tbody>
                            <tr>
                              <td><label style="padding-top: 9px;">Male</label></td>
                            </tr>
                            <tr>
                              <td><label style="padding-top: 8px; padding-bottom: 1px;">Female</label></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
			  <?php foreach($productsArray as $key => $value){ ?>
              <td style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-condensed" style="width: 100%;margin-bottom: -1px;margin-top: -5px;">
                  <tbody class="inputwidthc">
				  <?php	for($row=25;$row<=26;$row++){ ?>
                    <tr>
                      <td><input class="form-control zp text-center numberclass"  readonly="readonly" <?php $var="oui_r".$row."_f".$value['col'];; ?> value="<?php if(isset($fmvrf_info)){ echo $fmvrf_info[$var]; } else { echo '0'; } ?>" name="<?php echo $var; ?>" id="<?php echo $var; ?>" type="text"></td>
                    </tr>
				  <?php } ?>                     
                  </tbody>
                </table>
              </td>
			  <?php } ?>
            </tr>
          </tbody>
				</table>
			</div>
			<!--////////////////////////////////////////3rd tab/////////////////-->
			<div class="tab-pane" id="tab-3">
			<table class="table table-bordered table-condensed table-striped table-hover mytable3" style="border-collapse:inherit;">
				<thead class="trans">
			<tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2">Vaccination<br>Given to<br>Children</th>
                <th colspan="18">Vaccines</th>
			</tr>
			<tr>
                <th>&nbsp;&nbsp;BCG&nbsp;&nbsp;</th>
                <th>Hep B-Birth</th>
                <th>OPV-0</th>
                <th>OPV-1</th>
                <th>OPV-2</th>
                <th>OPV-3</th>
				<th>Rota-1</th>
                <th>Rota-2</th>
                <th>&nbsp;&nbsp;IPV&nbsp;&nbsp;</th>
                <th>PCV10<br>-1</th>
                <th>PCV10<br>-2</th>
                <th>PCV10<br>-3</th>
                <th>PENTA<br>-1</th>
                <th>PENTA<br>-2</th>
                <th>PENTA<br>-3</th>                
                <th>Measles<br>-1</th>
                <th>Fully Immun<br>-ized</th>
                <th>Measles<br>-2</th>
			</tr>
			</thead>
			<tbody>	
			<?php

					$mainHeadingArr = array("Vaccinator (Fixed)","Vaccinator (Outreach)","Vaccinator (Mobile)","Health House (LHW)");
					$otherHeadingsArr = array("0-11 Months","12-23 Months","2 Years and Above");
					$row = 1;
					$index=2;
					for($main=1;$main<=4;$main++){ 
				?>
			<tr>
              <td><label style="padding-top: 112px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;">
                <?php for($ind=0;$ind < 3;$ind++){ ?>
				<table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -6px;">
                  <tbody>
                    <tr>
                      <td><label style="padding-top: 18px;"><?php echo $otherHeadingsArr[$ind]; ?></label></td>
                      <td style="padding: 0px;">
                        <table class="table table-condensed table-bordered" style="width:100%;margin-bottom:-1px;">
                          <tbody>
                            <tr>
                              <td><label style="padding-top: 9px;">M</label></td>
                            </tr>
                            <tr>
                              <td><label style="padding-top: 8px; padding-bottom: 6px;">F</label></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
				<?php } ?>
              </td><?php
			  
				foreach($productsArray as $key => $value){
					
					if($main == 2)
						$row = 7;
					else if($main == 3)
						$row = 13;
					else if($main == 4)
						$row = 19;
					else
						$row = 1;
					 ?>
					<td style="padding-left: 0px; padding-right: 0px;">
						<table class="table table-condensed" style="width: 100%;margin-bottom: -1px;margin-top: -5px;">
							<tbody class="inputwidthc">
							<?php	for($row;$row<=24;$row++){ ?>
										<tr>
											<td>
												<input class="form-control zp text-center numberclass od "   data-row="<?php echo $row; ?>" data-col="<?php echo $value['col']; ?>" <?php $var="od_r".$row."_f".$value['col']; echo (in_array($row,$value['blocked_cols']))?'readonly="readonly"':''; ?> value="<?php if(isset($fmvrf_info_od)){ echo $fmvrf_info_od[$var]; } else { echo '0'; } ?>" name="<?php echo $var; ?>" id="<?php echo $var; ?>" type="text">
											</td>
										</tr>
										<?php
										//echo $indexc==1;
										if($row%6==0){
											break;
										}
									}?>
							
							</tbody>
						</table>
					</td>
		<?php 	  } ?>
			</tr>
		<?php $index++; } ?>
            <tr><!--Last table loops for TCV-->
              <td><label>Total Children Vaccinated</label></td>
              <td style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -6px;">
                  <tbody>
                    <tr>
                       
                      <td style="padding: 0px;">
                        <table class="table table-condensed table-bordered" style="width:100%;margin-bottom:-1px;">
                          <tbody>
                            <tr>
                              <td><label style="padding-top: 9px;">Male</label></td>
                            </tr>
                            <tr>
                              <td><label style="padding-top: 8px; padding-bottom: 1px;">Female</label></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
			  <?php foreach($productsArray as $key => $value){ ?>
              <td style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-condensed" style="width: 100%;margin-bottom: -1px;margin-top: -5px;">
                  <tbody class="inputwidthc">
				  <?php	for($row=25;$row<=26;$row++){ ?>
                    <tr>
                      <td><input class="form-control zp text-center numberclass"  readonly="readonly" <?php $var="od_r".$row."_f".$value['col']; ?> value="<?php if(isset($fmvrf_info_od)){ echo $fmvrf_info_od[$var]; } else { echo '0'; } ?>" name="<?php echo $var; ?>" id="<?php echo $var; ?>" type="text"></td>
                    </tr>
				  <?php } ?>                     
                  </tbody>
                </table>
              </td>
			  <?php } ?>
            </tr>
          </tbody>
				</table>
			</div>
			
			
			
			
										
									</div>
								</td>
								
							</tr>	
						</tbody>
					</table>	
							
        
        
      </div>			
								
								
								
						
        
      
        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
              <tr>
                <th colspan="3" style="border-right:0;">
									<ul class="nav nav-tabs" style="border-bottom:none;">
										<li class="active">
											<a href="#tab-4" data-toggle="tab" aria-expanded="true" style="color:black; font-size: 10px;font-family: initial;font-style: normal;font-weight: bold;color: #030303;text-transform: uppercase;">
											InSide UC</a>
										</li>
										<li class="">
											<a href="#tab-5" data-toggle="tab" aria-expanded="false" style="color:black; font-size: 10px;font-family: initial;font-style: normal;font-weight: bold;color: #030303;text-transform: uppercase;">
											OutSide UC</a>
										</li>   
                                        <li class="">
											<a href="#tab-6" data-toggle="tab" aria-expanded="false" style="color:black; font-size: 10px;font-family: initial;font-style: normal;font-weight: bold;color: #030303;text-transform: uppercase;">
											OUT District</a>
										</li>   										
									</ul>
								</th>
								<th colspan="6" style="text-align: left; padding-top: 10px; padding-bottom: 10px; border-left:0;">B. TT Routine Immunization</th>
              </tr>
          </thead>
          <tbody>
						<tr>
							<td colspan="9" style="padding:0px;">
								<div class="tab-content">
									 <div class="tab-pane active in" id="tab-4">
											<table class="table table-bordered table-condensed table-striped table-hover mytable3">
												<thead class="trans">
													    <tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2" style="min-width: 230px;">Vaccination Given to Children</th>
                <th colspan="6">Vaccines</th>
              </tr>
              <tr>
                <th>TT-1</th>
                <th>TT-2</th>
                <th>TT-3</th>
                <th>TT-4</th>
                <th>TT-5</th>
                <th>Children Protected<br>at Birth</th>
              </tr>
												</thead>
												<tbody>
			<?php
			$mainHeadingArr = array("Fixed","Outreach","Mobile","Health House (LHW)","Total Vaccinated");
			$Nrow = 1;
			for($main=1;$main<=5;$main++){ 
		?>
            <tr>
              <td><label style="padding-top: 30px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -5px;">
                  <tbody>
                    <tr><td><label style="padding-top: 9px;">Pregnant Women</label></td></tr>
                    <tr><td><label style="padding-top: 9px;">Non-Pregnant Women (15-49 Years)</label></td>
                    </tr>
                  </tbody>
                </table>
              </td>
			  <?php
			  for($col=1;$col<=6;$col++){
					if($main == 2)
						$Nrow = 3;
					else if($main == 3)
						$Nrow = 5;
					else if($main == 4)
						$Nrow = 7;
					else if($main == 5)
						$Nrow = 9;
					else
						$Nrow = 1;
					?>
				  <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
					<table class="table table-condensed" style="width: 100%;margin-bottom: 0px;margin-top: -5px;">
					  <tbody>
						<?php	
							for($Nrow;$Nrow<=10;$Nrow++){ ?>
								<tr>
									<td><input class="form-control numberclass ttri" <?php echo ($main == 5)?'readonly="readonly"':''; ?> data-row="<?php echo $Nrow; ?>" data-col="<?php echo $col; ?>" <?php $var="ttri_r".$Nrow."_f".$col; ?> name="<?php echo $var; ?>" id="<?php echo $var; ?>" value="<?php if(isset($fmvrf_info)){ echo $fmvrf_info[$var]; } else { echo '0'; } ?>" type="text"></td>
								</tr>
								<?php
								if($Nrow%2==0){
									break;
								}
								?>
					<?php	}	?>              
					  </tbody>
					</table>
				  </td>
			<?php } ?>
			  </tr>
			<?php }  ?>
			</tbody>	
											</table>
									</div>
									 <div class="tab-pane" id="tab-5">
																	<table class="table table-bordered table-condensed table-striped table-hover mytable3">
												<thead class="trans">
													    <tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2" style="min-width: 230px;">Vaccination Given to Children</th>
                <th colspan="6">Vaccines</th>
              </tr>
              <tr>
                <th>TT-1</th>
                <th>TT-2</th>
                <th>TT-3</th>
                <th>TT-4</th>
                <th>TT-5</th>
                <th>Children Protected<br>at Birth</th>
              </tr>
												</thead>
												<tbody>
			<?php
			$mainHeadingArr = array("Fixed","Outreach","Mobile","Health House (LHW)","Total Vaccinated");
			$Nrow = 1;
			for($main=1;$main<=5;$main++){ 
		?>
            <tr>
              <td><label style="padding-top: 30px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -5px;">
                  <tbody>
                    <tr><td><label style="padding-top: 9px;">Pregnant Women</label></td></tr>
                    <tr><td><label style="padding-top: 9px;">Non-Pregnant Women (15-49 Years)</label></td>
                    </tr>
                  </tbody>
                </table>
              </td>
			  <?php
			  for($col=1;$col<=6;$col++){
					if($main == 2)
						$Nrow = 3;
					else if($main == 3)
						$Nrow = 5;
					else if($main == 4)
						$Nrow = 7;
					else if($main == 5)
						$Nrow = 9;
					else
						$Nrow = 1;
					?>
				  <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
					<table class="table table-condensed" style="width: 100%;margin-bottom: 0px;margin-top: -5px;">
					  <tbody>
						<?php	
							for($Nrow;$Nrow<=10;$Nrow++){ ?>
								<tr>
									<td><input class="form-control numberclass ttoui" <?php echo ($main == 5)?'readonly="readonly"':''; ?> data-row="<?php echo $Nrow; ?>" data-col="<?php echo $col; ?>" <?php $var="ttoui_r".$Nrow."_f".$col; ?> name="<?php echo $var; ?>" id="<?php echo $var; ?>" value="<?php if(isset($fmvrf_info)){ echo $fmvrf_info[$var]; } else { echo '0'; } ?>" type="text"></td>
								</tr>
								<?php
								if($Nrow%2==0){
									break;
								}
								?>
					<?php	}	?>              
					  </tbody>
					</table>
				  </td>
			<?php } ?>
			  </tr>
			<?php }  ?>
			</tbody>	
											</table>
									</div>
									<div class="tab-pane" id="tab-6">
																	<table class="table table-bordered table-condensed table-striped table-hover mytable3">
												<thead class="trans">
													    <tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2" style="min-width: 230px;">Vaccination Given to Children</th>
                <th colspan="6">Vaccines</th>
              </tr>
              <tr>
                <th>TT-1</th>
                <th>TT-2</th>
                <th>TT-3</th>
                <th>TT-4</th>
                <th>TT-5</th>
                <th>Children Protected<br>at Birth</th>
              </tr>
												</thead>
												<tbody>
			<?php
			$mainHeadingArr = array("Fixed","Outreach","Mobile","Health House (LHW)","Total Vaccinated");
			$Nrow = 1;
			for($main=1;$main<=5;$main++){ 
		?>
            <tr>
              <td><label style="padding-top: 30px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -5px;">
                  <tbody>
                    <tr><td><label style="padding-top: 9px;">Pregnant Women</label></td></tr>
                    <tr><td><label style="padding-top: 9px;">Non-Pregnant Women (15-49 Years)</label></td>
                    </tr>
                  </tbody>
                </table>
              </td>
			  <?php
			  for($col=1;$col<=6;$col++){
					if($main == 2)
						$Nrow = 3;
					else if($main == 3)
						$Nrow = 5;
					else if($main == 4)
						$Nrow = 7;
					else if($main == 5)
						$Nrow = 9;
					else
						$Nrow = 1;
					?>
				  <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
					<table class="table table-condensed" style="width: 100%;margin-bottom: 0px;margin-top: -5px;">
					  <tbody>
						<?php	
							for($Nrow;$Nrow<=10;$Nrow++){ ?>
								<tr>
									<td><input class="form-control numberclass ttod" <?php echo ($main == 5)?'readonly="readonly"':''; ?> data-row="<?php echo $Nrow; ?>" data-col="<?php echo $col; ?>" <?php $var="ttod_r".$Nrow."_f".$col; ?> name="<?php echo $var; ?>" id="<?php echo $var; ?>" value="<?php if(isset($fmvrf_info_od)){ echo $fmvrf_info_od[$var]; } else { echo '0'; } ?>" type="text"></td>
								</tr>
								<?php
								if($Nrow%2==0){
									break;
								}
								?>
					<?php	}	?>              
					  </tbody>
					</table>
				  </td>
			<?php } ?>
			  </tr>
			<?php }  ?>
			</tbody>	
											</table>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
	
	
  
        
		
		<table class="table table-bordered table-condensed table-striped table-hover mytable3 ">
          <tbody>
            <tr>
              <td><label>Name of Vaccinator</label></td>
              <td style="text-align:center;"><input class="form-control" required="required" name="vacc_name" id="vacc_name" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('vacc_name'); }else{ echo $fmvrf_info["vacc_name"]; } } else {if(validation_errors() != false) {echo set_value('vacc_name'); } else{} } ?>" placeholder="Name of Vaccinator" type="text"></td>
              <input type="hidden" id="techniciancode" name="techniciancode">
			
              <td><label>Name of LHS</label></td> 
              <td style="text-align:center;"><input class="form-control" name="lhsname" id="lhsname" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('lhsname'); }else{ echo $fmvrf_info["lhsname"]; } } else {if(validation_errors() != false) {echo set_value('lhsname'); } else{} } ?>" placeholder="Name of LHS" type="text"></td>
              <td><label>Name of Facility Incharge</label></td>              
              <td style="text-align:center;"><input class="form-control" name="incharge_name" id="incharge_name" value="<?php if(isset($fmvrf_info)){ if(validation_errors() != false) { echo set_value('incharge_name'); }else{ echo $fmvrf_info["incharge_name"]; } } else {if(validation_errors() != false) {echo set_value('incharge_name'); } else{} } ?>" placeholder="Name of Facility Incharge" type="text"></td>
            </tr>
          </tbody>
        </table>
		
         <table class="table table-bordered   table-striped table-hover    mytable2">
          <tbody>
            <tr>
	            <td style="width:35%;"><strong>Submission Date</strong></td>
      				<?php if(isset($fmvrf_info)) { ?>
      				<td id="get_date"><?php if(isset($fmvrf_info)){ echo $current_date; } ?></td>
      				<td><input type="hidden" id="editted_date" name="editted_date" value="<?php if(isset($fmvrf_info)){ echo date('d-m-Y',strtotime($fmvrf_info->editted_date)); } else{ echo $current_date; } ?>" type="date"></td>
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
                <button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
                
              <button style="background: #008d4c;" class="btn btn-primary btn-md" type="reset">
                <i class="fa fa-repeat"></i> Reset Form </button>
             
              <a href="<?php echo base_url() ?>FLCF-MVRF/List" style="background: #008d4c" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>
      </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--end of body container-->
<script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(window).on('load', function() {
		selectedfacode = '<?php echo isset($fmvrf_info)?$fmvrf_info["facode"]:0; ?>';
		$("#facode").change();
	//alert(selectedfacode);
	});
	$(document).ready(function(){
		$(".cri").on('keyup',function(){
			//alert("Test");
			var row = $(this).data("row");
			var col = $(this).data("col");
			var maleVal=0;
			var femaleVal=0;
			for(var i=1;i<=24;i++){
				if(i%2==0){
					femaleVal += parseInt($("input[name=cri_r"+i+"_f"+col+"]").val());
					//alert(femaleVal);
				}else{
					maleVal += parseInt($("input[name=cri_r"+i+"_f"+col+"]").val());
				}
			}
			$("input[name=cri_r26_f"+col+"]").val(femaleVal);
			$("input[name=cri_r25_f"+col+"]").val(maleVal);
		});
		$(".oui").on('keyup',function(){
			
			var row = $(this).data("row");
			var col = $(this).data("col");
		    

			var maleVal=0;
			var femaleVal=0;
			for(var i=1;i<=24;i++){
				if(i%2==0){
					femaleVal += parseInt($("input[name=oui_r"+i+"_f"+col+"]").val());
					//alert(femaleVal);
				}else{
					maleVal += parseInt($("input[name=oui_r"+i+"_f"+col+"]").val());
					//alert(maleVal);
				}
			}
			$("input[name=oui_r26_f"+col+"]").val(femaleVal);
			$("input[name=oui_r25_f"+col+"]").val(maleVal);
		});
		$(".od").on('keyup',function(){
			
			var row = $(this).data("row");
			var col = $(this).data("col");
		    

			var maleVal=0;
			var femaleVal=0;
			for(var i=1;i<=24;i++){
				if(i%2==0){
					femaleVal += parseInt($("input[name=od_r"+i+"_f"+col+"]").val());
					//alert(femaleVal);
				}else{
					maleVal += parseInt($("input[name=od_r"+i+"_f"+col+"]").val());
					//alert(maleVal);
				}
			}
			$("input[name=od_r26_f"+col+"]").val(femaleVal);
			$("input[name=od_r25_f"+col+"]").val(maleVal);
		});
		$(".ttri").on('keyup',function(){
			var row = $(this).data("row");
			var col = $(this).data("col");
			var nonPregnantWomen=0;
			var pregnantWomen=0;
			for(var m=1;m<=8;m++){
				if(m%2==0){
					nonPregnantWomen += parseInt($("input[name=ttri_r"+m+"_f"+col+"]").val());
				}else{
					pregnantWomen += parseInt($("input[name=ttri_r"+m+"_f"+col+"]").val());
				}
			}
			$("input[name=ttri_r9_f"+col+"]").val(pregnantWomen);
			$("input[name=ttri_r10_f"+col+"]").val(nonPregnantWomen);
		});
	    $(".ttoui").on('keyup',function(){
			var row = $(this).data("row");
			var col = $(this).data("col");
			var nonPregnantWomen=0;
			var pregnantWomen=0;
			for(var m=1;m<=8;m++){
				if(m%2==0){
					nonPregnantWomen += parseInt($("input[name=ttoui_r"+m+"_f"+col+"]").val());
				}else{
					pregnantWomen += parseInt($("input[name=ttoui_r"+m+"_f"+col+"]").val());
				}
			}
			$("input[name=ttoui_r9_f"+col+"]").val(pregnantWomen);
			$("input[name=ttoui_r10_f"+col+"]").val(nonPregnantWomen);
		});
		$(".ttod").on('keyup',function(){
			var row = $(this).data("row");
			var col = $(this).data("col");
			var nonPregnantWomen=0;
			var pregnantWomen=0;
			for(var m=1;m<=8;m++){
				if(m%2==0){
					nonPregnantWomen += parseInt($("input[name=ttod_r"+m+"_f"+col+"]").val());
				}else{
					pregnantWomen += parseInt($("input[name=ttod_r"+m+"_f"+col+"]").val());
				}
			}
			$("input[name=ttod_r9_f"+col+"]").val(pregnantWomen);
			$("input[name=ttod_r10_f"+col+"]").val(nonPregnantWomen);
		});
	
	
	});
  
	var get_date = $('#get_date').text();
  $('#editted_date').val(get_date);

	$('#facode').on('change', function(){
		var year = $('#year').val();
		
		var facode = $('#facode').val();
		$.ajax({
			type: "POST",
			data: "facode="+facode,
			url: "<?php echo base_url(); ?>Ajax_calls/getIncharge",
			success: function(result){
				 var data = jQuery.parseJSON(result.trim());
				 if(data != null){
					$('#incharge_name').val(data.incharge);
				 }else{
					$('#incharge_name').val('');
				 }
			}
		});
		
		$.ajax({
			type: "POST",
			data: "facode="+facode,
			url: "<?php echo base_url(); ?>Ajax_calls/getVccname",
			success: function(result){
				var data = jQuery.parseJSON(result.trim());
				if(data != null){
					$('#vacc_name').val(data.technicianname);
					$('#techniciancode').val(data.techniciancode);
				}else{
					$('#vacc_name').val('');
					$('#techniciancode').val('');
				}
			}
		});
		
		$.ajax({
			//alert(year);
			type: "POST",
			data: "facode="+facode+"&year="+year,
			url: "<?php echo base_url(); ?>Ajax_calls/getTargetChildern",
			success: function(result){
				var data = jQuery.parseJSON(result.trim());
        <?php if(isset($edit) && $edit=='No') { ?>
				$('#tc_male').val(data.male);
				$('#tc_female').val(data.female);
				$('#pw_monthly_target').val(data.monthly_PregnantW);
      <?php } ?>
			}
		});
		
		if(facode!='0'){
		var year = $('#year').val();
		var monthEdit = '<?php if(isset($fmvrf_info)){ echo $fmonthArr[1]; } ?>';
		var yearEdit = '<?php if(isset($fmvrf_info)){ $fmonthArr = explode("-",$fmvrf_info["fmonth"]);echo $fmonthArr[0]; }?>';
		var table = 'fac_mvrf_db';
		var month =  $('#month').val();
		var edit = 0;
		if(monthEdit>0){
			month = monthEdit;
			edit = 1;
		}
		if(yearEdit>0)
			year = yearEdit;
		/* alert(facode);
		alert(year);
		alert(month); */
		/* $.ajax({
			type: "POST",
			data: "facode="+facode+"&year="+year+"&month="+month+"&edit="+edit+"&table="+table,
			url: "<?php echo base_url(); ?>Ajax_calls/validateExistRecord",
			success: function(result){
				var result = result.trim()
				if(result == 'Yes'){
					//$('#facode').val([]);
					//window.confirm("Report Freezed! You can not Add/Edit");
					if (confirm("Report Freezed! You can not Add/Edit")==true) {
						window.location.href = "<?php echo base_url(); ?>Data_entry/fac_mvrf_list";
					} else {
						window.location.reload();
					} 
				}			 
			}
		}); */
		}
	});
	$('#month').on('change', function(){
		var facode = $('#facode').val();
		if(facode!='0'){
		var year = $('#year').val();
		var month = $('#month').val();
		var table = 'fac_mvrf_db';
		$.ajax({
			type: "POST",
			data: "facode="+facode+"&year="+year+"&month="+month+"&table="+table,
			url: "<?php echo base_url(); ?>Ajax_calls/validateExistRecord",
			success: function(result){
				var result = result.trim()
				if(result == 'Yes'){
					alert("Report already exist for Selected Year and Month....");
				}			 
			}
		});
		}
	});
	

</script>
<script type="text/javascript">
            $(document).ready(function () {
                $("input[type='radio']").on('change', function () {
                    var selectedValue = $("input[name='direction']:checked").val();
					var horizontal = 'horizontal';
					var vertical = 'vertical';
					
                    //alert(selectedValue);
					if(vertical == selectedValue) {	
					    alert("tabindex vertical =");
						$('.test').find('input').removeAttr('tabindex');
						
						
						
						//var hr = parseInt($('.test').find('input').attr('data-tabindexhorizantal'));
						//var currentIndex = hr+1;
						//$('.test').find('input').attr('tabindex','['+currentIndex+']');
					    //	var hr2 =$('.test').find('input').attr('tabindex');
						//alert(hr2);
						/* }); */
						/* alert("tabindex horizontal =");
						$(document).on('change','.test',function(){ */
                        
						
                    }
					if(horizontal == selectedValue){
						
						$('.test').each(function (tabindex, value) { 
     	                var hr = ('.test' + tabindex + ':' + $(this).attr('tabindex')); 
                        console.log(hr);                        
						});
						alert("tabindex Horizantel =");
						$('.test').find('input').prop('tabindex',true).val();
						
						/* $(document).on('keyup','.test',function(){
							var hr = parseInt($('.test').find('input').attr('data-tabindexhorizantal'));
				            console.log(hr);
						}); */
						/* var hr = parseInt($('.test').find('input').attr('data-tabindexhorizantal'));
						$('.test').find('input').attr('tabindex',hr);
						alert(hr); */
						//var hr = parseInt($('.test').find('input').attr('data-tabindexhorizantal'));
						//$('.test').find('input').attr('tabindex',hr);
						//.prop("disabled", true);
                        
                    }
                });
			/* 	$('.test').each(function () {
                // $(this).addClass('c2');
				var hr = parseInt($('.test').find('input').attr('data-tabindexhorizantal'));
				console.log(hr);
               //  $('.test').append($(this).text());
        }); */
            });
            //enter key press code
            $(document).keypress(function(e)  {
        if (event.keyCode == 13) {
           var res=confirm("Are you sure to save Form ?");
           if(res){
            $('#form').submit();
           }
           else{
            return false;
           }
        }
    });

</script>