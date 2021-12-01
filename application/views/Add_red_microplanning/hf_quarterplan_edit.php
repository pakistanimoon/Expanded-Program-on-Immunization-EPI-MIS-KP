<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
	///print_r(count($datat2));
	//echo 'test';
	//print_r($datat3);exit;
	//print_r($data[0]);exit;
?>
<!-- <div class="content-wrapper"> -->
<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:17px; border-color:white !important;">
					Health Facility Workplan for a Quarter (3 months)<span class="urdu" style="font-size:12px; font-weight:400;">مرکز صحت کى سہ ماہى منصوبہ بندى برائے حفاظتى ٹیکہ جات</span>
				</div>
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Health Facility Workplan for a Quarter (3 months) Update Form</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_save">
					<div class="row" style="width:100%; padding:4px 17px">
						<input type="hidden" name="edit" value="edit">
						<input type="hidden" name="submitted_date" value="<?php echo $data[0]['submitted_date']; ?>">
						<input type="hidden" name="recid" value="<?php echo $data[0]['pk_id']; ?>">
						<input type="hidden" name="updated_date" value="<?php echo $current_date; ?>">
						<div class="col-md-2 col-md-offset-1">
							<label>Tehsil:</label>
						</div>
						<div class="col-md-3">							
							<p><?php echo $data[0]['tehsil']; ?></p>
							<input type="hidden" value="<?php echo $data[0]['tcode']; ?>" name="tcode"/>
						</div>
						<div class="col-md-2">
							<label>Union Council:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['uc_name']; ?></p>
							<input type="hidden" value="<?php echo $data[0]['uncode']; ?>" name="uncode"/>
						</div>
					</div>
					<div class="row" style="width:100%; padding:4px 17px">					
						<div class="col-md-2 col-md-offset-1">
							<label>Health Facility:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['facility']; ?></p>
							<input type="hidden" value="<?php echo $data[0]['facode']; ?>" name="facode"/>
						</div>
						<div class="col-md-2">
							<label>Technician:</label>
						</div>
						<div class="col-md-3">
						<?php if($data[0]['year']=='2019' || $data[0]['year']=='2018'){ ?>
							<p><?php echo get_Technician_Name($data[0]['techniciancode']); ?></p>
							<?php }else{ ?>
							<p><?php echo get_Hr_Name($data[0]['techniciancode'],'01'); ?></p>
							<input type="hidden" value="<?php echo $data[0]['techniciancode']; ?>" id="techniciancode" name="techniciancode"/>
							<?php } ?>
						</div>			
					</div>
					<div class="row" style="width:100%; padding:4px 17px">					
						<div class="col-md-2 col-md-offset-1">
							<label>Year:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['year']; ?></p>
							<input type="hidden" value="<?php echo $data[0]['year']; ?>" id="year" name="year"/>
						</div>
						
						<div class="col-md-2 ">						
							<label>Quarter:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['quarter']; ?></p>
							<input type="hidden" value="<?php echo $data[0]['quarter']; ?>" id="quarter" name="quarter"/>
						</div>			
					</div>					
					<div class="panel-body" style="padding-top:1px;">
						<table class="table table-bordered plan_table" >
							<thead>
								<tr>
									<th style="border-left-color:black; width:12%;">Area Name <br><span class="urdu">علاقہ کا نام </span></th>
									<th style="width:12%;">No of sessions per month <br><span class="urdu">ماہانہ سیشن کی تعداد</span></th>
									<th colspan="2" class="qtr" id="">Site Name</th>
									<?php if($data[0]['quarter'] == 1) {?>
										<th colspan="2" class="qtr" id="m1">January</th>
										<th colspan="2" class="qtr" id="m2">February</th>
										<th colspan="2" class="qtr" id="m3" style="border-right-color:black;">March</th>
									<?php } else if($data[0]['quarter'] == 2) { ?>
										<th colspan="2" class="qtr" id="m1">April</th>
										<th colspan="2" class="qtr" id="m2">May</th>
										<th colspan="2" class="qtr" id="m3" style="border-right-color:black;">June</th>
									<?php } else if($data[0]['quarter'] == 3) { ?>
										<th colspan="2" class="qtr" id="m1">July</th>
										<th colspan="2" class="qtr" id="m2">August</th>
										<th colspan="2" class="qtr" id="m3" style="border-right-color:black;">September</th>
									<?php } else if($data[0]['quarter'] == 4) { ?>
										<th colspan="2" class="qtr" id="m1">October</th>
										<th colspan="2" class="qtr" id="m2">November</th>
										<th colspan="2" class="qtr" id="m3" style="border-right-color:black;">December</th>
									<?php } else  { ?>
										<th colspan="2" class="qtr" id="m1">January</th>
										<th colspan="2" class="qtr" id="m2">February</th>
										<th colspan="2" class="qtr" id="m3" style="border-right-color:black;">March</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
							
		<!---------------------------------------------------------------row add------------------------------------------------>
		<!---------------------------------------------------------------row add------------------------------------------------>
		<!---------------------------------------------------------------row add------------------------------------------------>
		<!---------------------------------------------------------------row add------------------------------------------------>
			<?php  
					$var1=$moon2 = $moon = 0;
					$var1=$moon3 = $moon4 = 0;
				foreach($datat2 as $key => $val){
					$numarea = $key+1;
					$numar = $var1;
			?>
									
							<tr>
								<td rowspan="5" style="vertical-align:middle">
									<input type="text" id="area1_name" name="area_name[<?php echo $numarea; ?>]" value="<?php echo get_Village_Name($datat2[$numar]['area_code']); ?>" readonly  class="form-control">
									<input type="text" hidden id="area1_name" name="area_code[<?php echo $numarea; ?>]" value="<?php  echo $datat2[$numar]['area_code']; ?>" >
									<input type="text" hidden id="numarea" name="numarea" value="<?Php echo $numarea ; ?>">
									<input type="text" hidden id="numarea" name="numarea" value="<?Php echo $numarea ; ?>">
								</td>
								<td rowspan="5" style="vertical-align:middle">
									<input type="text" name="area_num_sessions[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_num_sessions']; ?>" readonly class="form-control text-center numberclass">
									<input type="hidden" name="session_type_nm[<?php echo $numarea; ?>]" value="<?Php echo $datat2[$numar]['session_type']; ?>" >
								
								</td>
								<!--site-->
								<?php if($datat2[$numar]['session_type']=='Fixed'){?>
								<td colspan="2">  <!-- this td for table -->
								<table>
										<tbody>
											
											 <?php 
												$moon=$moon2;
												 for($index=1;$index<=$val['area_num_sessions'];$index++)
												 { $var = $index - 1; 
											 ?>
											<tr>
												<td><input type="text" name="sitename_s[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon]['sitename_s'])) { echo get_Facility_Name($datat3[$moon]['sitename_s']); } ?>" class="form-control text-center " readonly>
												<input type="text" hidden name="sitecode_s[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon]['sitename_s'])) {echo $datat3[$moon]['sitename_s']; } ?>"></td>
												
											</tr>
											<tr></tr>
										 <?php $moon++;} ?>
										</tbody>
								</table>
									
								</td> 
								<?php }else{ ?>
										<td colspan="2">  <!-- this td for table -->
											<table>
													<tbody>
														
														 <?php 
															$moon=$moon2;
															 for($index=1;$index<=$val['area_num_sessions'];$index++)
															 { $var = $index - 1; 
														 ?>
														<tr>
															<td><input type="text" name="sitecode_s[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon]['sitename_s'])) { echo $datat3[$moon]['sitename_s']; } ?>" class="form-control text-center test " ></td>
															
														</tr>
														<tr></tr>
													 <?php $moon++;} ?>
													</tbody>
											</table>
												
										</td>

								<?php } ?>
								<!--end-->
								<td colspan="2">  <!-- this td for table -->
								<table>
										<tbody>
											
											 <?php 
												$moon=$moon2;
												 for($index=1;$index<=$val['area_num_sessions'];$index++)
												 { $var = $index - 1; 
											 ?>
											<tr>
											    <input type="hidden" class="type1" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($datat3[$moon]['session_type']); ?>"  >
												<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_code']); ?>"  >
												<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
												<td><input type="text" name="area_dateschedule_m1[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon]['area_dateschedule_m1'])) { echo date('Y-m-d', strtotime($datat3[$moon]['area_dateschedule_m1'])); } ?>" data-date-format="yyyy-mm-dd" class="form-control text-center calendar1 <?php if($datat2[$numar]['session_type']=='Fixed'){echo "date-shedule-f1";}else if($datat2[$numar]['session_type']=='Outreach'){echo "date-shedule-o1";}else{echo "date-shedule-m1";}?>" readonly></td>
												
											</tr>
											<tr></tr>
										 <?php $moon++;} ?>
										</tbody>
								</table>
									
								</td> <!-- close -->
								<td colspan="2">  <!-- this td for table -->
									<table>
										<tbody>
											
											 <?php 
											 $moon=$moon2;
											 for($index=1;$index<=$val['area_num_sessions'];$index++) 
											 { $var = $index - 1; 
										 ?>
											<tr>
												<input type="hidden" class="type2" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($datat3[$moon]['session_type']); ?>"  >
												<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_code']); ?>"  >
												<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
												<td><input type="text" name="area_dateschedule_m2[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon]['area_dateschedule_m2'])) { echo date('Y-m-d', strtotime($datat3[$moon]['area_dateschedule_m2'])); } ?>" data-date-format="yyyy-mm-dd" class="form-control text-center calendar2 <?php if($datat2[$numar]['session_type']=='Fixed'){echo "date-shedule-f";}else if($datat2[$numar]['session_type']=='Outreach'){echo "date-shedule-o2";}else{echo "date-shedule-m2";}?>" readonly></td>
												
											</tr>
											<tr></tr>
										 <?php $moon++;} ?>
										</tbody>
									</table>
									
								</td> <!-- close -->
								<td colspan="2">  <!-- this td for table -->
									<table>
										<tbody>
											
											 <?php 
											 $moon=$moon2;
											 for($index=1;$index<=$val['area_num_sessions'];$index++) 
											 {	$var = $index - 1; 					 ?>
											<tr>
												<input type="hidden" class="type3" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($datat3[$moon]['session_type']); ?>"  >
												<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_code']); ?>"  >
												<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
												<td><input type="text" name="area_dateschedule_m3[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon]['area_dateschedule_m3'])) { echo date('Y-m-d', strtotime($datat3[$moon]['area_dateschedule_m3'])); } ?>" data-date-format="yyyy-mm-dd" class="form-control text-center calendar3 <?php if($datat2[$numar]['session_type']=='Fixed'){echo "date-shedule-f3";}else if($datat2[$numar]['session_type']=='Outreach'){echo "date-shedule-o2";}else{echo "date-shedule-m3";}?>" readonly></td>
												
											</tr>
											<tr></tr>
										 <?php $moon++;} $moon2=$moon2+$val['area_num_sessions'];?>
										</tbody>
									</table>
									
								</td> <!-- close -->
							</tr>
								
							<tr>
								<!--site he-->
								<?php if($datat2[$numar]['session_type']=='Fixed'){?>
								<td colspan="2">  <!-- this td for table -->
									<table>
											<tbody>
												
												 <?php 
												 $moon3=$moon4;
												 for($index=1;$index<=$val['area_num_sessions'];$index++)  
												 { $var = $index - 1;  ?>
												<tr>
												
													<td><input type="text" name="sitename_h[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon3]['sitename_h'])) { echo get_Facility_Name($datat3[$moon3]['sitename_h']); } ?>"  class="form-control text-center " readonly>
													<input type="text" hidden name="sitecode_h[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon3]['sitename_h'])) { echo $datat3[$moon3]['sitename_h']; } ?>"  ></td>
													
												</tr>
												<tr></tr>
											 <?php $moon3++;}?>
											</tbody>
										</table>
										
								</td> 
								<?php }else{ ?>
									<td colspan="2">  <!-- this td for table -->
										<table>
												<tbody  id="tbl1">
													
													 <?php 
													 $moon3=$moon4;
													 for($index=1;$index<=$val['area_num_sessions'];$index++)  
													 { $var = $index - 1;  ?>
													<tr>
													
														<td><input type="text" name="sitecode_h[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon3]['sitename_h'])) { echo $datat3[$moon3]['sitename_h']; } ?>"  class="form-control text-center " ></td>
														
													</tr>
													<tr></tr>
												 <?php $moon3++;}?>
												</tbody>
											</table>
											
									</td>
								<?php } ?>
								<!--site he-->
								<td colspan="2">  <!-- this td for table -->
									<table>
											<tbody>
												
												 <?php 
												 $moon3=$moon4;
												 for($index=1;$index<=$val['area_num_sessions'];$index++)  
												 { $var = $index - 1;  ?>
												<tr>
													<input type="hidden" class="type1" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($datat3[$moon3]['session_type']); ?>"  >
													<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_code']); ?>"  >
													<td><label for="date_of_scheduled" style="margin-right: 6px;">Date(s) <br> Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
													<td><input type="text" name="area_dateheld_m1[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon3]['area_dateheld_m1'])) { echo date('Y-m-d', strtotime($datat3[$moon3]['area_dateheld_m1'])); } ?>"  data-date-format="yyyy-mm-dd" class="form-control text-center calendar1 <?php if($datat2[$numar]['session_type']=='Fixed'){echo "date-held-f1";}else if($datat2[$numar]['session_type']=='Outreach'){echo "date-held-o1";}else{echo "date-held-m1";}?>" readonly></td>
													
												</tr>
												<tr></tr>
											 <?php $moon3++;}?>
											</tbody>
										</table>
										
								</td>
								<td colspan="2">  <!-- this td for table -->
									<table>
											<tbody>
												
												 <?php 
												 $moon3=$moon4;
												 for($index=1;$index<=$val['area_num_sessions'];$index++)  
												 { $var = $index - 1; ?>
												<tr>
													<input type="hidden" class="type2" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($datat3[$moon3]['session_type']); ?>"  >
													<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_code']); ?>"  >
													<td><label for="date_of_scheduled" style="margin-right: 6px;">Date(s) <br> Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
													<td><input type="text" name="area_dateheld_m2[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon3]['area_dateheld_m2'])) { echo date('Y-m-d', strtotime($datat3[$moon3]['area_dateheld_m2'])); } ?>"  data-date-format="yyyy-mm-dd" class="form-control text-center calendar2 <?php if($datat2[$numar]['session_type']=='Fixed'){echo "date-held-f2";}else if($datat2[$numar]['session_type']=='Outreach'){echo "date-held-o2";}else{echo "date-held-m2";}?>" readonly></td>
													
												</tr>
												<tr></tr>
											 <?php $moon3++;} ?>
											</tbody>
										</table>
										
								</td>
								<td colspan="2">  <!-- this td for table -->
									<table>
											<tbody>
												 <?php
													$moon3=$moon4;
												 for($index=1;$index<=$val['area_num_sessions'];$index++) 
												 { $var = $index - 1;  ?>
												<tr>
												    <input type="hidden" class="type3" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($datat3[$moon3]['session_type']); ?>"  >
													<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_code']); ?>"  >
													<td><label for="date_of_scheduled" style="margin-right: 6px;">Date(s) <br> Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
													<td><input type="text" name="area_dateheld_m3[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?php if(isset($datat3[$moon3]['area_dateheld_m3'])) { echo date('Y-m-d', strtotime($datat3[$moon3]['area_dateheld_m3'])); } ?>" data-date-format="yyyy-mm-dd" class="form-control text-center calendar3 <?php if($datat2[$numar]['session_type']=='Fixed'){echo "date-held-f3";}else if($datat2[$numar]['session_type']=='Outreach'){echo "date-held-o3";}else{echo "date-held-m3";}?>" readonly></td>
													
												</tr>
												<tr></tr>
											 <?php $moon3++;} $moon4=$moon4+$val['area_num_sessions']; ?>
											</tbody>
										</table>
										
								</td>
							</tr>
							<?php if($datat2[$numar]['session_type']=='Fixed'){?>
							<tr>
							    <td colspan="2" rowspan="3" ></td>
								<td colspan="1"><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
								<td colspan="1"> <input type="text" id="area_transport_m1" name="area_transport_m1[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_transport_m1']; ?>" class="form-control" disabled readonly></td>
								<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
								<td><input type="text" id="area_transport_m2" name="area_transport_m2[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_transport_m2']; ?>" class="form-control" disabled readonly></td>
								<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
								<td><input type="text" id="area_transport_m3" name="area_transport_m3[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_transport_m3']; ?>" class="form-control" disabled readonly></td>
							</tr>
							<?php } else {?>
							<tr>
							<td colspan="2" rowspan="3" ></td>
								<td colspan="1"><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
								<td colspan="1"> <input type="text" id="area_transport_m1" name="area_transport_m1[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_transport_m1']; ?>" class="form-control"></td>
								<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
								<td><input type="text" id="area_transport_m2" name="area_transport_m2[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_transport_m2']; ?>" class="form-control"></td>
								<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
								<td><input type="text" id="area_transport_m3" name="area_transport_m3[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_transport_m3']; ?>" class="form-control"></td>
							</tr>
							<?php } ?>
							<tr>
								<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
								<td><input type="text" id="area1_resperson_m1" name="area_resperson_m1[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_resperson_m1']; ?>" class="form-control"></td>
								<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
								<td><input type="text" id="area1_resperson_m2" name="area_resperson_m2[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_resperson_m2']; ?>" class="form-control"></td>
								<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
								<td><input type="text" id="area1_resperson_m3" name="area_resperson_m3[<?php echo $numarea; ?>]" value="<?php echo $datat2[$numar]['area_resperson_m3']; ?>" class="form-control"></td>
							</tr>
							<tr>
								<td>
									<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
								</td>
								<td>
									<select class="form-control text-center" name="area_distsupport_m1[<?php echo $numarea; ?>]" >
										<option value="">-- Select --</option>
										<option <?php if($datat2[$numar]['area_distsupport_m1'] == "No") echo 'selected="selected"'; ?>  value="No">No</option>
										<option <?php if($datat2[$numar]['area_distsupport_m1'] == "Yes") echo 'selected="selected"'; ?> value="Yes">Yes</option>							
									</select>
								</td>
								<td>
									<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
								</td>
								<td>
									<select class="form-control text-center" name="area_distsupport_m2[<?php echo $numarea; ?>]" >
										<option value="">-- Select --</option>
										<option <?php if($datat2[$numar]['area_distsupport_m2'] == "No") echo 'selected="selected"'; ?> value="No">No</option>
										<option <?php if($datat2[$numar]['area_distsupport_m2'] == "Yes") echo 'selected="selected"'; ?>  value="Yes">Yes</option>							
									</select>
								</td>
								<td>
									<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
								</td>
								<td>
									<select class="form-control text-center" name="area_distsupport_m3[<?php echo $numarea; ?>]">
										<option value="">-- Select --</option>
										<option <?php if($datat2[$numar]['area_distsupport_m3'] == "No") echo 'selected="selected"'; ?>  value="No">No</option>
										<option <?php if($datat2[$numar]['area_distsupport_m3'] == "Yes") echo 'selected="selected"'; ?> value="Yes">Yes</option>							
									</select>
								</td>
							</tr>
	
<?php $var1++;  } ?>
							
<!--------------------------------------row add end-------------------------------->
<!--------------------------------------row add end-------------------------------->
<!--------------------------------------row add end-------------------------------->
<!--------------------------------------row add end-------------------------------->

							
								
								<tr>
									<td colspan="4" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Activities  for hard to reach and problem areas<br><span class="urdu">مشکل گزار علاقوں کىلئے اقدامات</span></label></td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>										
										<td><input type="text" name="ahtr_activities_m<?php echo $i; ?>" value="<?php echo $data[0]['ahtr_activities_m'.$i]; ?>" class="form-control"></td>
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
										<td><input type="text" name="ahtr_resperson_m<?php echo $i; ?>" value="<?php echo $data[0]['ahtr_resperson_m'.$i]; ?>" class="form-control"></td>
									<?php } ?>									
								</tr>
								<tr>
									<td colspan="4" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Regular Activitites<br><span class="urdu">باقاعدہ اقدامات</span></label></td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>										
										<td><input type="text" name="ra_activities_m<?php echo $i; ?>" value="<?php echo $data[0]['ra_activities_m'.$i]; ?>" class="form-control"></td>
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
										<td><input type="text" name="ra_resperson_m<?php echo $i; ?>" value="<?php echo $data[0]['ra_resperson_m'.$i]; ?>" class="form-control"></td>
									<?php } ?>									
								</tr>
								<tr>
									<td colspan="4" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Monitoring of session implementation<br><span class="urdu">حفاظتى ٹیکہ جات کے سیشن کے نفاذ کى نگرانى</span></label></td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="session_jan">No. of sessions held<br><span class="urdu"> شبڈول سیشن کى تعداد</span></label></td>
										<!--<td><input type="text" name="msi_numheld_m<?php echo $i; ?>" value="<?php echo $data[0]['msi_numheld_m'.$i]; ?>" class="form-control text-center numberclass"></td>-->
										<td>
											
										    <input type="text" id="sh_Fixed_m1"    name="sh_Fixed_m<?php echo $i; ?>"    value="<?php echo $data[0]['sh_fixed_m'.$i]; ?>" class="form-control text-center numberclass">
											<input type="text" id="sh_Outreach_m1" name="sh_Outreach_m<?php echo $i; ?>" value="<?php echo $data[0]['sh_outreach_m'.$i]; ?>" class="form-control text-center numberclass">
											<input type="text" id="sh_Mobile_m1"   name="sh_Mobile_m<?php echo $i; ?>"   value="<?php echo $data[0]['sh_mobile_m'.$i]; ?>" class="form-control text-center numberclass">
										</td>
									
									
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="plain_jan">No of sessions planned<br><span class="urdu"> منعقد کیے گئے سیشن کى تعداد</span></label></td>
										<!--<td><input type="text" name="msi_numplan_m<?php echo $i; ?>" value="<?php echo $data[0]['msi_numplan_m'.$i]; ?>" class="form-control text-center numberclass"></td>-->
										<td>
											<input type="text" id="sp_Fixed_m1"    name="sp_Fixed_m<?php echo $i; ?>"    value="<?php echo $data[0]['sp_fixed_m'.$i]; ?>" class="form-control text-center numberclass">
											<input type="text" id="sp_Outreach_m1" name="sp_Outreach_m<?php echo $i; ?>" value="<?php echo $data[0]['sp_outreach_m'.$i]; ?>" class="form-control text-center numberclass">
											<input type="text" id="sp_Mobile_m1"   name="sp_Mobile_m<?php echo $i; ?>"   value="<?php echo $data[0]['sp_mobile_m'.$i]; ?>" class="form-control text-center numberclass">
										</td>
									<?php } ?>									
								</tr>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url();?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>
								<button type="reset" class="form-btn"><i class="fa fa-recycle" aria-hidden="true"></i> Reset Form</button>								
								<button type="submit" class="form-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit Form</button>								
							</div>
						</div>
					</div> <!--end of panel body-->
				</form>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->

	<script type="text/javascript">
	///////////////this Ready function for 1st time page load datepicker////////////////////
	$(document).ready(function(){
					 var today = new Date();
					 var dd = today.getDate();
					 var mm = today.getMonth()+1; //January is 0!
					// alert(dd);
					 //alert(mm);
					 var year = $('#year').val();
					 function quarter_of_the_year(date){
							var month = date.getMonth() + 1;
							return (Math.ceil(month / 3));
					}
					//var  qua = '0'+quarter_of_the_year(new Date());
					var qua = $('#quarter').val();
					//alert(qua);
					if(qua == 1){
							var month1 = '01';
							var month2 = '02';
							var month3 = '03';
					}
					else if(qua == 2){
							var month1 = '04';
							var month2 = '05';
							var month3 = '06';
					}
					else if(qua == 3){
							var month1 = '07';
							var month2 = '08';
							var month3 = '09';
				   }
				   else if(qua == 4){
							var month1 = '10';
							var month2 = '11';
							var month3 = '12';
				   }
				   
				   if(month1 != 0 ){
					   /* if (month1 == mm ){
						   var eday = dd;
					   }
					   else{
						   var eday = '31';
					   } */
						var day = '01';
						var eday = '31';
						
						var date1 = year+'-'+month1+'-'+day;
						var edate1 = year+'-'+month1+'-'+eday;
						var minDate = new Date(date1);
						var maxDate = new Date(edate1);
						$('.calendar1').each(function(){	 
							$(this).datepicker('setStartDate', minDate); 
						});
						$('.calendar1').each(function(){
							$(this).datepicker('setEndDate', maxDate);
						}); 	 
				  }
			   if(month2 != 0 ){
					 /* if(month2 == mm){
						 var eday = dd;
					 }
					 else  */
				   if(month2 == '02'){
					 	 var eday = '28';
					 }else{
					 	 var eday='31'
					 }
					 var date2 = year+'-'+month2+'-'+day;
			         var edate2 = year+'-'+month2+'-'+eday;
					 var minDate = new Date(date2);
				     var maxDate = new Date(edate2);
					  $('.calendar2').each(function(){ 
						  $(this).datepicker('setStartDate', minDate);
					  });	  
					  $('.calendar2').each(function(){
						$(this).datepicker('setEndDate', maxDate);
				      });
				}
				if(month3 != 0 ){
					/* if(month3 == mm ){
						 var eday = dd;
					 }else{
						   var eday = '31';
					 } */
					 var day = '01';
					  var eday = '31';
					 var date3 = year+'-'+month3+'-'+day;
			         var edate3 = year+'-'+month3+'-'+eday;
					 var minDate = new Date(date3);
				     var maxDate = new Date(edate3);
					 $('.calendar3').each(function(){
						$(this).datepicker('setStartDate', minDate);
					 });	  
				     $('.calendar3').each(function(){
						 $(this).datepicker('setEndDate', maxDate);
				   	 });
				}
					///////////////this Ready function for 1st time page load datepicker////////////////////	
	});
/* 	$('.test').on('keyup' , function (){
			 
			 var colvalue=this.value;
			 var index = $(this).closest("tr").index();
			 ranknum = index+1;
			 $("#tbl1").find("tr:nth-child("+ranknum+")").find("td:nth-child(1)").find('input').val(colvalue);
	
		}); */
		$(document).ready(function(){
			var options = {
				format : "yyyy-mm-dd",
				todayHighlight: true,
				autoclose: true,
				color: "green"
			};
			$('.calendar').datepicker(options);

			$(document).on('change','#quarter', function(){
				var quarter = this.value;
				//alert(quarter);
				if(quarter == 1){
					$('#m1').text('January');
					$('#m2').text('February');
					$('#m3').text('March');
				}
				else if(quarter == 2){
					$('#m1').text('April');
					$('#m2').text('May');
					$('#m3').text('June');
				}
				else if(quarter == 3){
					$('#m1').text('July');
					$('#m2').text('August');
					$('#m3').text('September');
				}
				else if(quarter == 4){
					$('#m1').text('October');
					$('#m2').text('November');
					$('#m3').text('December');
				}
				else{
					$('#m1').text('January');
					$('#m2').text('February');
					$('#m3').text('March');
				}
			});			
		});
///////////for date shedule count for m1/////////////			
					
					$(document).on('change','.date-shedule-f1',function(){
						var type = $(this).closest('tr').find(".type1").val();
						var counterf =0;
						$('.date-shedule-f1').each(function(){
							var date_shedule = this.value;
							if(date_shedule != "" && type=="Fixed"){
									counterf = counterf + 1;
									$('#sp_Fixed_m1').val(counterf);
							}
						});
                    });
					$(document).on('change','.date-shedule-o1',function(){
						var type = $(this).closest('tr').find(".type1").val();
						var countero =0;
						$('.date-shedule-o1').each(function(){
							var date_shedule = this.value;
							if(date_shedule != "" && type=="Outreach" ){
									countero = countero + 1;
									$('#sp_Outreach_m1').val(countero);	
							}				
					    }); 
                    });
					$(document).on('change','.date-shedule-m1',function(){
						var type = $(this).closest('tr').find(".type1").val();
						var counterm =0;
						$('.date-shedule-m1 ').each(function(){
							var date_shedule = this.value;
							if(date_shedule != "" && type=="Mobile" ){
									counterm = counterm + 1;
									$('#sp_Mobile_m1').val(counterm);	
							}				
					    }); 
                    });
					
//////////for date shedule count end /////////////
//////////for date shedule count for m2/////////////			
					
					$(document).on('change','.date-shedule-f2',function(){
						var type = $(this).closest('tr').find(".type2").val();
						var counterf =0;
						$('.date-shedule-f2').each(function(){
							var date_shedule = this.value;
							if(date_shedule != "" && type=="Fixed"){
									counterf = counterf + 1;
									$('#sp_Fixed_m2').val(counterf);
							}
						});
                    });
					$(document).on('change','.date-shedule-o2',function(){
						var type = $(this).closest('tr').find(".type2").val();
						var countero =0;
						$('.date-shedule-o2').each(function(){
							var date_shedule = this.value;
							if(date_shedule != "" && type=="Outreach" ){
									countero = countero + 1;
									$('#sp_Outreach_m2').val(countero);	
							}				
					    }); 
                    });
					$(document).on('change','.date-shedule-m2',function(){
						var type = $(this).closest('tr').find(".type2").val();
						var counterm =0;
						$('.date-shedule-m2 ').each(function(){
							var date_shedule = this.value;
							if(date_shedule != "" && type=="Mobile" ){
									counterm = counterm + 1;
									$('#sp_Mobile_m2').val(counterm);	
							}				
					    }); 
                    });
					
//////////for date shedule count end /////////////
//////////for date shedule count for m3/////////////			
					
					$(document).on('change','.date-shedule-f3',function(){
						var type = $(this).closest('tr').find(".type3").val();
						var counterf =0;
						$('.date-shedule-f3').each(function(){
							var date_shedule = this.value;
							if(date_shedule != "" && type=="Fixed"){
									counterf = counterf + 1;
									$('#sp_Fixed_m3').val(counterf);
							}
						});
                    });
					$(document).on('change','.date-shedule-o3',function(){
						var type = $(this).closest('tr').find(".type3").val();
						var countero =0;
						$('.date-shedule-o3').each(function(){
							var date_shedule = this.value;
							if(date_shedule != "" && type=="Outreach" ){
									countero = countero + 1;
									$('#sp_Outreach_m3').val(countero);	
							}				
					    }); 
                    });
					$(document).on('change','.date-shedule-m3',function(){
						var type = $(this).closest('tr').find(".type3").val();
						var counterm =0;
						$('.date-shedule-m3 ').each(function(){
							var date_shedule = this.value;
							if(date_shedule != "" && type=="Mobile" ){
									counterm = counterm + 1;
									$('#sp_Mobile_m3').val(counterm);	
							}				
					    }); 
                    });
					
//////////for date shedule count end /////////////
///////////for date held count for m1/////////////			
					
					$(document).on('change','.date-held-f1',function(){
						var type = $(this).closest('tr').find(".type1").val();
						var counterf =0;
						$('.date-held-f1').each(function(){
							var date_held = this.value;
							if(date_held != "" && type=="Fixed"){
									counterf = counterf + 1;
									$('#sh_Fixed_m1').val(counterf);
							}
						});
                    });
					$(document).on('change','.date-held-o1',function(){
						var type = $(this).closest('tr').find(".type1").val();
						var countero =0;
						$('.date-held-o1').each(function(){
							var date_held = this.value;
							if(date_held != "" && type=="Outreach" ){
									countero = countero + 1;
									$('#sh_Outreach_m1').val(countero);	
							}				
					    }); 
                    });
					$(document).on('change','.date-held-m1',function(){
						var type = $(this).closest('tr').find(".type1").val();
						var counterm =0;
						$('.date-held-m1 ').each(function(){
							var date_held = this.value;
							if(date_held != "" && type=="Mobile" ){
									counterm = counterm + 1;
									$('#sh_Mobile_m1').val(counterm);	
							}				
					    }); 
                    });
					
//////////for date shedule count end /////////////
///////////for date held count for m2/////////////			
					
					$(document).on('change','.date-held-f2',function(){
						var type = $(this).closest('tr').find(".type2").val();
						var counterf =0;
						$('.date-held-f2').each(function(){
							var date_held = this.value;
							if(date_held != "" && type=="Fixed"){
									counterf = counterf + 1;
									$('#sh_Fixed_m2').val(counterf);
							}
						});
                    });
					$(document).on('change','.date-held-o2',function(){
						var type = $(this).closest('tr').find(".type2").val();
						var countero =0;
						$('.date-held-o2').each(function(){
							var date_held = this.value;
							if(date_held != "" && type=="Outreach" ){
									countero = countero + 1;
									$('#sh_Outreach_m2').val(countero);	
							}				
					    }); 
                    });
					$(document).on('change','.date-held-m2',function(){
						var type = $(this).closest('tr').find(".type2").val();
						var counterm =0;
						$('.date-held-m2 ').each(function(){
							var date_held = this.value;
							if(date_held != "" && type=="Mobile" ){
									counterm = counterm + 1;
									$('#sh_Mobile_m2').val(counterm);	
							}				
					    }); 
                    });
					
//////////for date shedule count end /////////////
///////////for date held count for m2/////////////			
					
					$(document).on('change','.date-held-f3',function(){
						var type = $(this).closest('tr').find(".type3").val();
						var counterf =0;
						$('.date-held-f3').each(function(){
							var date_held = this.value;
							if(date_held != "" && type=="Fixed"){
									counterf = counterf + 1;
									$('#sh_Fixed_m3').val(counterf);
							}
						});
                    });
					$(document).on('change','.date-held-o3',function(){
						var type = $(this).closest('tr').find(".type3").val();
						var countero =0;
						$('.date-held-o3').each(function(){
							var date_held = this.value;
							if(date_held != "" && type=="Outreach" ){
									countero = countero + 1;
									$('#sh_Outreach_m3').val(countero);	
							}				
					    }); 
                    });
					$(document).on('change','.date-held-m3',function(){
						var type = $(this).closest('tr').find(".type3").val();
						var counterm =0;
						$('.date-held-m3 ').each(function(){
							var date_held = this.value;
							if(date_held != "" && type=="Mobile" ){
									counterm = counterm + 1;
									$('#sh_Mobile_m3').val(counterm);	
							}				
					    }); 
                    });
					
//////////for date shedule count end /////////////		
	</script>