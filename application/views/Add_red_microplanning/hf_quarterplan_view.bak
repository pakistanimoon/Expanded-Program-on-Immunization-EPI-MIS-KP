<style>
table{
	width:100%;
}
table.none-td-border{
	width:90%;
	position:relative;
	left:11%;
}
table.none-td-border tbody td{
	border:1px solid transparent;
	text-align:left;
}
</style>

	<a href="<?php echo base_url(); ?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_view/<?php echo $data[0]['facode']; ?>/<?php echo $data[0]['year']; ?>/<?php echo $data[0]['quarter']; ?>/<?php echo $data[0]['techniciancode'];?>/<?php echo 'excel'; ?>" data-toggle="tooltip" title="Excel" class="btn btn-xs btn-default" style="float: right;"><img src="<?php echo base_url(); ?>/includes/images/excel.png" style="width:37px;" ">
	</a>
<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
?>
<!-- <div class="content-wrapper"> -->
<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:17px; border-color:white !important;">
					Health Facility Workplan for a Quarter (3 months)<span class="urdu" style="font-size:12px; font-weight:400;">مرکز صحت کى سہ ماہى منصوبہ بندى برائے حفاظتى ٹیکہ جات</span>
				</div>
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Health Facility Workplan for a Quarter (3 months) Form View</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Facility_quarterplan/hf_quarterplan_save">
					<div>
						<table class="none-td-border">
							<tbody>
								<tr>
									<td><label>Tehsil:</label></td>
									<td><label><?php echo $data[0]['tehsil']; ?></label></td>
									<td><label>Union Council:</label></td>
									<td><label><?php echo $data[0]['uc_name']; ?></label></td>
								</tr>
								<tr>
									<td><label>Health Facility:</label></td>
									<td><label><?php echo $data[0]['facility']; ?></label></td>
									<td><label>Technician:</label></td>
									<td><label><?php echo get_Technician_Name($data[0]['techniciancode']); ?></label></td>
								</tr>
								<tr>
									<td><label>Year:</label></td>
									<td><label><?php echo $data[0]['year']; ?></label></td>
									<td><label>Quarter::</label></td>
									<td><label><?php echo $data[0]['quarter']; ?></label></td>
								</tr>
							</tbody>
						</table>
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
			// echo $datat2[$numar]['area_name'];
		  ?>
							
								<tr>
									<td rowspan="5" style="vertical-align:middle">
										<p><?php echo get_Village_Name($datat2[$numar]['area_code']); ?></p>
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<p><?php echo $datat2[$numar]['area_num_sessions']; ?></p>
									</td>
								<?php if(isset($datat3[$numar]['session_type']) AND $datat3[$numar]['session_type']=='Fixed'){?>
								<td colspan="2">  <!-- this td for table -->
									<table>
										<tbody>
											<?php 
											    $moon=$moon2;
												for($index=1;$index<=$val['area_num_sessions'];$index++)
												{ $var = $index - 1; 
											?>
										    <tr>
												<td>
													<label><?php if(isset($datat3[$moon]['sitename_s'])) { echo get_Facility_Name($datat3[$moon]['sitename_s']); } ?></label>
											    </td>
												
											</tr>
											<tr></tr>
										 <?php $moon++;} ?>
										</tbody>
									</table>
								</td> 
								<?php }else{ ?>
										<td colspan="2">  <!-- this td for table -->
											<table style="width:100%;">
													<tbody>
														<?php 
															$moon=$moon2;
															 for($index=1;$index<=$val['area_num_sessions'];$index++)
															 { $var = $index - 1; 
														?>
														<tr>
															<td style="font-weight:600;">
																<label><?php if(isset($datat3[$moon]['sitename_s'])) { echo $datat3[$moon]['sitename_s']; } ?></label>
															</td>
														</tr>
														<tr></tr>
													 <?php $moon++;} ?>
													</tbody>
											</table>
												
										</td>

								<?php } ?>
								<!--end-->
									<td colspan="2">  <!-- this td for table -->
										<table style="width:100%;">
											<tbody>
												 <?php 
													$moon=$moon2;
													 for($index=1;$index<=$val['area_num_sessions'];$index++)
													 { $var = $index - 1; 
												 ?>
												<tr>
													<td>
														<label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label>
													</td>
													<td>
														<label><?php if(isset($datat3[$moon]['area_dateschedule_m1'])) { echo date('Y-m-d', strtotime($datat3[$moon]['area_dateschedule_m1'])); } ?></label>
													</td>
												</tr>
												<tr></tr>
											 <?php $moon++;} ?>
											</tbody>
										</table>
									</td> <!-- close -->
									<td colspan="2">  <!-- this td for table -->
										<table style="width:100%;">
											<tbody>
												
												 <?php 
												 $moon=$moon2;
												 for($index=1;$index<=$val['area_num_sessions'];$index++) 
												 { $var = $index - 1; 
											 ?>
												<tr>
													<td>
														<label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label>
													</td>
													<td>
														<label><?php if(isset($datat3[$moon]['area_dateschedule_m2'])) { echo date('Y-m-d', strtotime($datat3[$moon]['area_dateschedule_m2'])); } ?></label>
													</td>													
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
													<td>
														<label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label>
													</td>
													<td>
														<label><?php if(isset($datat3[$moon]['area_dateschedule_m3'])) { echo date('Y-m-d', strtotime($datat3[$moon]['area_dateschedule_m3'])); } ?></label>
													</td>
												</tr>
												<tr></tr>
											 <?php $moon++;} $moon2=$moon2+$val['area_num_sessions'];?>
											</tbody>
										</table>
									</td> <!-- close -->
								</tr>
								<tr>
										<!--site he-->
									<?php if(isset($datat3[$numar]['session_type']) AND $datat3[$numar]['session_type']=='Fixed'){ ?>
									<td colspan="2">  <!-- this td for table -->
										<table>
											<tbody>
												 <?php 
												 $moon3=$moon4;
												 for($index=1;$index<=$val['area_num_sessions'];$index++)  
												 { $var = $index - 1;  ?>
												<tr>
													<td>
														<label><?php if(isset($datat3[$moon3]['sitename_h'])) { echo get_Facility_Name($datat3[$moon3]['sitename_h']); } ?></label>
													</td>
												</tr>
												<tr></tr>
											 <?php $moon3++;} ?>
											</tbody>
										</table>	
									</td> 
									<?php }else{ ?>
									<td colspan="2">  <!-- this td for table -->
										<table>
												<tbody>
													<?php 
													 $moon3=$moon4;
													 for($index=1;$index<=$val['area_num_sessions'];$index++)  
													 { $var = $index - 1;  ?>
													<tr>
														<td>
															<label><?php if(isset($datat3[$moon3]['sitename_h'])) { echo $datat3[$moon3]['sitename_h']; } ?></label>
														</td>
													</tr>
													<tr></tr>
												 <?php $moon3++;} ?>
												</tbody>
										</table>
									</td>
									<?php } ?>
									<td colspan="2">  <!-- this td for table -->
										<table>
											<tbody>
												<?php 
													 $moon3=$moon4;
													 for($index=1;$index<=$val['area_num_sessions'];$index++)  
													 { $var = $index - 1;  
												?>
													<tr>
														<td>
															<label for="date_of_scheduled" style="margin-right: 6px;">Date(s) <br> Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label>
														</td>
														<td>
														    <label><?php if(isset($datat3[$moon3]['area_dateheld_m1'])) { echo date('Y-m-d', strtotime($datat3[$moon3]['area_dateheld_m1'])); } ?></label>
														</td>
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
													 { $var = $index - 1; 
												?>
													<tr>
														<td>
															<label for="date_of_scheduled" style="margin-right: 6px;">Date(s) <br> Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label>
														</td>
														<td>
															<label><?php if(isset($datat3[$moon3]['area_dateheld_m2'])) { echo date('Y-m-d', strtotime($datat3[$moon3]['area_dateheld_m2'])); } ?></label>
														</td>
													</tr>
													<tr></tr>
												 <?php $moon3++; } ?>
											</tbody>
										</table>	
									</td>
									<td colspan="2">  <!-- this td for table -->
										<table>
											<tbody>
												<?php
														$moon3=$moon4;
													 for($index=1;$index<=$val['area_num_sessions'];$index++) 
													 { $var = $index - 1;  
												?>
													<tr>
														<td>
															<label for="date_of_scheduled" style="margin-right: 6px;">Date(s) <br> Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label>
														</td>
														<td>
															<label><?php if(isset($datat3[$moon3]['area_dateheld_m3'])) { echo date('Y-m-d', strtotime($datat3[$moon3]['area_dateheld_m3'])); } ?></label>
														</td>
													</tr>
													<tr></tr>
												 <?php $moon3++;} $moon4=$moon4+$val['area_num_sessions']; ?>
											</tbody>
										</table>	
									</td>
								</tr>
								<?php if(isset($datat3[$numar]['session_type']) AND $datat3[$numar]['session_type']=='Fixed'){ ?>
							<tr>
							    <td colspan="2" rowspan="3" ></td>
								<td colspan="1">
									<label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label>
								</td>
								<td colspan="1"> 
									<label><?php echo $datat2[$numar]['area_transport_m1']; ?></label>
								</td>
								<td>
									<label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label>
								</td>
								<td>
									<label><?php echo $datat2[$numar]['area_transport_m2']; ?></label>
								</td>
								<td>
									<label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label>
								</td>
								<td>
									<label><?php echo $datat2[$numar]['area_transport_m3']; ?></label>
								</td>
							</tr>
							<?php } else { ?>
							<tr>
								<td colspan="2" rowspan="3" ></td>
								<td colspan="1">
									<label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label>
								</td>
								<td colspan="1"> 
									<p style="margin-top: 6px;"><?php echo $datat2[$numar]['area_transport_m1']; ?></p>
								</td>
								 
								<td>
									<label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label>
								</td>
								<td>
									<p style="margin-top: 6px;"><?php echo $datat2[$numar]['area_transport_m2']; ?></p>
								</td>
								<td>
									<label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label>
								</td>
								<td>
									<p style="margin-top: 6px;"><?php echo $datat2[$numar]['area_transport_m3']; ?></p>
								</td>
							</tr>
							<?php } ?>
								<tr>
									<td>
										<label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label>
									</td>
									<td>
									    <p style="margin-top: 6px;"><?php echo $datat2[$numar]['area_resperson_m1']; ?></p>
									</td>
									<td>
										<label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label>
									</td>
									<td>
										<p style="margin-top: 6px;"><?php echo $datat2[$numar]['area_resperson_m2']; ?></p>
									</td>
									<td>
										<label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label>
									</td>
									<td>
										<p style="margin-top: 6px;"><?php echo $datat2[$numar]['area_resperson_m3']; ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<p><?php echo $datat2[$numar]['area_distsupport_m1']; ?></p>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<p><?php echo $datat2[$numar]['area_distsupport_m2']; ?></p>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<p><?php echo $datat2[$numar]['area_distsupport_m3']; ?></p>
									</td>
								</tr>
	
	<?php $var1++; } ?>
							
<!--------------------------------------row add end-------------------------------->
<!--------------------------------------row add end-------------------------------->
<!--------------------------------------row add end-------------------------------->
<!--------------------------------------row add end-------------------------------->
							
							
								
								<tr>
									<td colspan="4" rowspan="2" style="vertical-align:middle;">
										<label for="act_for_hard_reach">Activities  for hard to reach and problem areas<br><span class="urdu">مشکل گزار علاقوں کىلئے اقدامات</span></label>
									</td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td>
											<label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label>
										</td>										
										<td>
											<p style="margin-top: 6px;"><?php echo $data[0]['ahtr_activities_m'.$i]; ?></p>
										</td>
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td>
											<label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label>
										</td>
										<td>
											<p style="margin-top: 6px;"><?php echo $data[0]['ahtr_resperson_m'.$i]; ?></p>
										</td>
									<?php } ?>									
								</tr>
								<tr>
									<td colspan="4" rowspan="2" style="vertical-align:middle;">
										<label for="act_for_hard_reach">Regular Activitites<br><span class="urdu">باقاعدہ اقدامات</span></label>
									</td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td>
											<label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label>
										</td>										
										<td>
											<p style="margin-top: 6px;"><?php echo $data[0]['ra_activities_m'.$i]; ?></p>
										</td>
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td>
											<label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label>
										</td>
										<td>
											<p style="margin-top: 6px;"><?php echo $data[0]['ra_resperson_m'.$i]; ?></p>
										</td>
									<?php } ?>									
								</tr>
								<tr>
									<td colspan="4" rowspan="2" style="vertical-align:middle;">
										<label for="act_for_hard_reach">Monitoring of session implementation<br><span class="urdu">حفاظتى ٹیکہ جات کے سیشن کے نفاذ کى نگرانى</span></label>
									</td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td>
											<label for="session_jan">No. of sessions held<br><span class="urdu"> شبڈول سیشن کى تعداد</span></label>
										</td>
										<td>
											<p style="margin-top: 6px;"><?php echo $data[0]['sh_fixed_m'.$i]; ?></p>
											<p style="margin-top: 6px;"><?php echo $data[0]['sh_outreach_m'.$i]; ?></p>
											<p style="margin-top: 6px;"><?php echo $data[0]['sh_mobile_m'.$i]; ?></p>
										</td>
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td>
											<label for="plain_jan">No of sessions planned<br><span class="urdu"> منعقد کیے گئے سیشن کى تعداد	</span></label>
										</td>
										<td>	
											<p style="margin-top: 6px;"><?php echo $data[0]['sp_fixed_m'.$i]; ?>  </p>
											<p style="margin-top: 6px;"><?php echo $data[0]['sp_outreach_m'.$i]; ?></p>
											<p style="margin-top: 6px;"><?php echo $data[0]['sp_mobile_m'.$i]; ?> </p>
										</td>
									<?php } ?>									
								</tr>
							</tbody>
						</table>						
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url();?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_list"><button type="button" class="form-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
								<a href="<?php echo base_url();?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_edit/<?php echo $data[0]['facode']; ?>/<?php echo $data[0]['year']; ?>/<?php echo $data[0]['quarter'];?>/<?php echo $data[0]['techniciancode'];?>"><button type="button" class="form-btn"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button></a>	
							</div>
						</div>
					</div> <!--end of panel body-->
				</form>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->
	