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
					Health Facility Workplan for a Quarter (3 months)  <span class="urdu" style="font-size:12px; font-weight:400;">مرکز صحت کى سہ ماہى منصوبہ بندى برائے حفاظتى ٹیکہ جات</span>
				</div>
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Health Facility Workplan for a Quarter (3 months) Form View</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Facility_quarterplan/hf_quarterplan_save">
					<div class="row" style="width:100%; padding:4px 17px">
						<div class="col-md-2 col-md-offset-1">
							<label>Tehsil:</label>
						</div>
						<div class="col-md-3">							
							<p><?php echo $data[0]['tehsil']; ?></p>
						</div>
						<div class="col-md-2">
							<label>Union Council:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['uc_name']; ?></p>
						</div>
					</div>
					<div class="row" style="width:100%; padding:4px 17px">					
						<div class="col-md-2 col-md-offset-1">
							<label>Health Facility:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['facility']; ?></p>
						</div>
						<div class="col-md-2">
							<label>Year:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['year']; ?></p>
						</div>			
					</div>
					<div class="row" style="width:100%; padding:4px 17px">					
						<div class="col-md-2 col-md-offset-1">						
							<label>Quarter:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['quarter']; ?></p>
						</div>			
					</div>					
					<div class="panel-body" style="padding-top:1px;">
						<table class="table table-bordered plan_table" >
							<thead>
								<tr>
									<th style="border-left-color:black; width:12%;">Area Name <br><span class="urdu">علاقہ کا نام </span></th>
									<th style="width:12%;">No of sessions per month <br><span class="urdu">ماہانہ سیشن کی تعداد</span></th>
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
								<!--- Area1 -->
								<tr>
									<td rowspan="5" style="vertical-align:middle">
										<p style="margin-top: 6px;"><?php echo $data[0]['area1_name']; ?></p>
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<p style="margin-top: 6px;"><?php echo $data[0]['area1_num_sessions']; ?></p>
									</td>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
										<td><p style="margin-top: 6px;"><?php if(isset($data[0]['area1_dateschedule_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area1_dateschedule_m'.$i])); } ?></p></td>										
									<?php } ?> 									
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
										<td><p style="margin-top: 6px;"><?php if(isset($data[0]['area1_dateheld_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area1_dateheld_m'.$i])); } ?></p></td>
									<?php } ?> 
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><p style="margin-top: 6px;"><?php echo $data[0]['area1_transport_m'.$i]; ?></p></td>
								<?php } ?> 
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><p style="margin-top: 6px;"><?php echo $data[0]['area1_resperson_m'.$i]; ?></p></td>
								<?php } ?> 
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td><p style="margin-top: 6px;"><?php echo $data[0]['area1_distsupport_m'.$i]; ?></p></td>									
								<?php } ?> 
								</tr>
								<!--- Area2 -->
								<tr>
									<td rowspan="5" style="vertical-align:middle">
										<p style="margin-top: 6px;"><?php echo $data[0]['area2_name']; ?></p>
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<p style="margin-top: 6px;"><?php echo $data[0]['area2_num_sessions']; ?></p>
									</td>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
										<td><p style="margin-top: 6px;"><?php if(isset($data[0]['area2_dateschedule_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area2_dateschedule_m'.$i])); } ?></p></td>										
									<?php } ?> 									
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
										<td><p style="margin-top: 6px;"><?php if(isset($data[0]['area2_dateheld_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area2_dateheld_m'.$i])); } ?></p></td>
									<?php } ?> 
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['area2_transport_m'.$i]; ?></p></td>
									<?php } ?> 									
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['area2_resperson_m'.$i]; ?></p></td>
									<?php } ?>
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td>
											<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
										</td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['area2_distsupport_m'.$i]; ?></p></td>										
									<?php } ?> 
								</tr>
								<!--- Area3 -->
								<tr>
									<td rowspan="5" style="vertical-align:middle">
										<p style="margin-top: 6px;"><?php echo $data[0]['area3_name']; ?></p>
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<p style="margin-top: 6px;"><?php echo $data[0]['area3_num_sessions']; ?></p>
									</td>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
										<td><p style="margin-top: 6px;"><?php if(isset($data[0]['area3_dateschedule_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area3_dateschedule_m'.$i])); } ?></p></td>										
									<?php } ?> 									
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
										<td><p style="margin-top: 6px;"><?php if(isset($data[0]['area3_dateheld_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area3_dateheld_m'.$i])); } ?></p></td>
									<?php } ?> 
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['area3_transport_m'.$i]; ?></p></td>
									<?php } ?> 									
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['area3_resperson_m'.$i]; ?></p></td>
									<?php } ?>
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td><p style="margin-top: 6px;"><?php echo $data[0]['area3_distsupport_m'.$i]; ?></p></td>
								<?php } ?> 
								</tr>
								<tr>
									<td colspan="2" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Activities  for hard to reach and problem areas<br><span class="urdu">مشکل گزار علاقوں کىلئے اقدامات</span></label></td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>										
										<td><p style="margin-top: 6px;"><?php echo $data[0]['ahtr_activities_m'.$i]; ?></p></td>
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['ahtr_resperson_m'.$i]; ?></p></td>
									<?php } ?>									
								</tr>
								<tr>
									<td colspan="2" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Regular Activitites<br><span class="urdu">باقاعدہ اقدامات</span></label></td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>										
										<td><p style="margin-top: 6px;"><?php echo $data[0]['ra_activities_m'.$i]; ?></p></td>
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['ra_resperson_m'.$i]; ?></p></td>
									<?php } ?>									
								</tr>
								<tr>
									<td colspan="2" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Monitoring of session implementation<br><span class="urdu">حفاظتى ٹیکہ جات کے سیشن کے نفاذ کى نگرانى</span></label></td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="session_jan">No. of sessions held<br><span class="urdu"> شبڈول سیشن کى تعداد</span></label></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['msi_numheld_m'.$i]; ?></p></td>
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="plain_jan">No of sessions planned<br><span class="urdu"> منعقد کیے گئے سیشن کى تعداد</span></label></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['msi_numplan_m'.$i]; ?></p></td>
									<?php } ?>									
								</tr>
							</tbody>
						</table>						
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url();?>red_microplan/Facility_quarterplan/hf_quarterplan_list"><button type="button" class="form-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
								<a href="<?php echo base_url();?>red_microplan/Facility_quarterplan/hf_quarterplan_edit/<?php echo $data[0]['facode']; ?>/<?php echo $data[0]['year']; ?>/<?php echo $data[0]['quarter']; ?>"><button type="button" class="form-btn"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button></a>	
							</div>
						</div>
					</div> <!--end of panel body-->
				</form>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->

	