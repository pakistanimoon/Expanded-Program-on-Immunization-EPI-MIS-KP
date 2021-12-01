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
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Health Facility Workplan for a Quarter (3 months) Update Form</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Facility_quarterplan/hf_quarterplan_save">
					<div class="row" style="width:100%; padding:4px 17px">
						<input type="hidden" name="edit" value="edit">
						<input type="hidden" name="submitted_date" value="<?php echo $data[0]['submitted_date']; ?>">
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
							<label>Year:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['year']; ?></p>
							<input type="hidden" value="<?php echo $data[0]['year']; ?>" name="year"/>
						</div>			
					</div>
					<div class="row" style="width:100%; padding:4px 17px">					
						<div class="col-md-2 col-md-offset-1">						
							<label>Quarter:</label>
						</div>
						<div class="col-md-3">
							<p><?php echo $data[0]['quarter']; ?></p>
							<input type="hidden" value="<?php echo $data[0]['quarter']; ?>" name="quarter"/>
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
										<input type="text" name="area1_name" value="<?php echo $data[0]['area1_name']; ?>" class="form-control">
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" name="area1_num_sessions"  value="<?php echo $data[0]['area1_num_sessions']; ?>" class="form-control text-center numberclass">
									</td>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area1_dateschedule_m<?php echo $i; ?>" value="<?php if(isset($data[0]['area1_dateschedule_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area1_dateschedule_m'.$i])); } ?>" class="form-control text-center calendar" readonly></td>									
								<?php } ?> 									
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area1_dateheld_m<?php echo $i; ?>" value="<?php if(isset($data[0]['area1_dateheld_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area1_dateheld_m'.$i])); } ?>" class="form-control text-center calendar" readonly></td>
								<?php } ?> 
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" name="area1_transport_m<?php echo $i; ?>" value="<?php echo $data[0]['area1_transport_m'.$i]; ?>" class="form-control"></td>
								<?php } ?> 
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" name="area1_resperson_m<?php echo $i; ?>" value="<?php echo $data[0]['area1_resperson_m'.$i]; ?>" class="form-control"></td>
								<?php } ?> 
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area1_distsupport_m<?php echo $i; ?>">
											<option value="0">-- Select --</option>
											<option <?php if($data[0]['area1_distsupport_m'.$i] == "No") echo 'selected="selected"'; ?> value="No">No</option>
											<option <?php if($data[0]['area1_distsupport_m'.$i] == "Yes") echo 'selected="selected"'; ?> value="Yes">Yes</option>											
										</select>
									</td>
								<?php } ?> 
								</tr>
								<!--- Area2 -->
								<tr>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" name="area2_name" value="<?php echo $data[0]['area2_name']; ?>" class="form-control">
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" name="area2_num_sessions" value="<?php echo $data[0]['area2_num_sessions']; ?>" class="form-control text-center numberclass">
									</td>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
										<td><input type="text" name="area2_dateschedule_m<?php echo $i; ?>" value="<?php if(isset($data[0]['area2_dateschedule_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area2_dateschedule_m'.$i])); } ?>" class="form-control text-center calendar" readonly></td>									
									<?php } ?>
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
										<td><input type="text" name="area2_dateheld_m<?php echo $i; ?>" value="<?php if(isset($data[0]['area2_dateheld_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area2_dateheld_m'.$i])); } ?>" class="form-control text-center calendar" readonly></td>
									<?php } ?> 
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
										<td><input type="text" name="area2_transport_m<?php echo $i; ?>" value="<?php echo $data[0]['area2_transport_m'.$i]; ?>" class="form-control"></td>
									<?php } ?> 									
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
										<td><input type="text" name="area2_resperson_m<?php echo $i; ?>" value="<?php echo $data[0]['area2_resperson_m'.$i]; ?>" class="form-control"></td>
									<?php } ?>
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area2_distsupport_m<?php echo $i; ?>">
											<option value="0">-- Select --</option>
											<option <?php if($data[0]['area2_distsupport_m'.$i] == "No") echo 'selected="selected"'; ?> value="No">No</option>
											<option <?php if($data[0]['area2_distsupport_m'.$i] == "Yes") echo 'selected="selected"'; ?> value="Yes">Yes</option>											
										</select>
									</td>
								<?php } ?> 
								</tr>
								<!--- Area3 -->
								<tr>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" name="area3_name" value="<?php echo $data[0]['area3_name']; ?>" class="form-control">
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" name="area3_num_sessions" value="<?php echo $data[0]['area3_num_sessions']; ?>" class="form-control text-center numberclass">
									</td>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
										<td><input type="text" name="area3_dateschedule_m<?php echo $i; ?>" value="<?php if(isset($data[0]['area3_dateschedule_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area3_dateschedule_m'.$i])); } ?>" class="form-control text-center calendar" readonly></td>									
									<?php } ?>
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
										<td><input type="text" name="area3_dateheld_m<?php echo $i; ?>" value="<?php if(isset($data[0]['area3_dateheld_m'.$i])) { echo date('d-m-Y', strtotime($data[0]['area3_dateheld_m'.$i])); } ?>" class="form-control text-center calendar" readonly></td>
									<?php } ?> 
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
										<td><input type="text" name="area3_transport_m<?php echo $i; ?>" value="<?php echo $data[0]['area3_transport_m'.$i]; ?>" class="form-control"></td>
									<?php } ?> 									
								</tr>
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>
										<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
										<td><input type="text" name="area3_resperson_m<?php echo $i; ?>" value="<?php echo $data[0]['area3_resperson_m'.$i]; ?>" class="form-control"></td>
									<?php } ?>
								</tr>
								<tr>
								<?php for($i=1; $i<=3; $i++) { ?>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area3_distsupport_m<?php echo $i; ?>">
											<option value="0">-- Select --</option>
											<option <?php if($data[0]['area3_distsupport_m'.$i] == "No") echo 'selected="selected"'; ?> value="No">No</option>
											<option <?php if($data[0]['area3_distsupport_m'.$i] == "Yes") echo 'selected="selected"'; ?> value="Yes">Yes</option>											
										</select>
									</td>
								<?php } ?> 
								</tr>
								<tr>
									<td colspan="2" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Activities  for hard to reach and problem areas<br><span class="urdu">مشکل گزار علاقوں کىلئے اقدامات</span></label></td>
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
									<td colspan="2" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Regular Activitites<br><span class="urdu">باقاعدہ اقدامات</span></label></td>
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
									<td colspan="2" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Monitoring of session implementation<br><span class="urdu">حفاظتى ٹیکہ جات کے سیشن کے نفاذ کى نگرانى</span></label></td>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="session_jan">No. of sessions held<br><span class="urdu"> شبڈول سیشن کى تعداد</span></label></td>
										<td><input type="text" name="msi_numheld_m<?php echo $i; ?>" value="<?php echo $data[0]['msi_numheld_m'.$i]; ?>" class="form-control text-center numberclass"></td>
									<?php } ?>
								</tr>	
								<tr>
									<?php for($i=1; $i<=3; $i++) { ?>										
										<td><label for="plain_jan">No of sessions planned<br><span class="urdu"> منعقد کیے گئے سیشن کى تعداد</span></label></td>
										<td><input type="text" name="msi_numplan_m<?php echo $i; ?>" value="<?php echo $data[0]['msi_numplan_m'.$i]; ?>" class="form-control text-center numberclass"></td>
									<?php } ?>									
								</tr>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url();?>red_microplan/Facility_quarterplan/hf_quarterplan_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>
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
		$(document).ready(function(){
			var options = {
				format : "dd-mm-yyyy",
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
	</script>