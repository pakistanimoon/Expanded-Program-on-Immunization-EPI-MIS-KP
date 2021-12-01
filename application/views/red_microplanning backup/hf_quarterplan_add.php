<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
?>
<!-- <div class="content-wrapper"> -->
<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:15px;">
					Health Facility Workplan for a Quarter (3 months)  <span class="urdu" style="font-size:12px; font-weight:400;">مرکز صحت کى سہ ماہى منصوبہ بندى برائے حفاظتى ٹیکہ جات</span>
				</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Facility_quarterplan/hf_quarterplan_save">
					<div class="row" style="width:100%; padding:4px 17px">
						<input type="hidden" name="submitted_date" id="submitted_date" value="<?php echo $current_date; ?>" class="form-control">					
						<div class="col-md-2 col-md-offset-1">
							<label>Tehsil:</label>
						</div>
						<div class="col-md-3">
							<?php
								$distcode = $this-> session-> District; 
								$query="SELECT tcode, tehsilname(tcode) as tehsil from tehsil where distcode='{$distcode}'";
								$result = $this->db->query($query)->result_array();
							?>
							<select class="form-control" name="tcode" id="ticode" required="required">
								<option value="">-- Select --</option>
							<?php foreach ($result as $key => $value) { ?>
								<option value="<?php echo $value['tcode'] ?>"><?php echo $value['tehsil'] ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-2">
							<label>Union Council:</label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="uncode" id="unicode">
								<option value="">-- Select --</option>
							</select>
						</div>
					</div>
					<div class="row" style="width:100%; padding:4px 17px">					
						<div class="col-md-2 col-md-offset-1">
							<label>Health Facility:</label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="facode" id="facode" required="required">
								<option value="">-- Select --</option>
							</select>
						</div>
						<div class="col-md-2">
							<label>Year:</label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="year" id="year">
								<?php echo getAllYearsOptionsIncludingCurrent(); ?>
							</select>
						</div>				
					</div>
					<div class="row" style="width:100%; padding:4px 17px">
						<div class="col-md-2 col-md-offset-1">
							<label>Quarter:</label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="quarter" id="quarter" required="required">
								<option value="">-- Select --</option>
								<option value="1">Quarter 1</option>
								<option value="2">Quarter 2</option>
								<option value="3">Quarter 3</option>
								<option value="4">Quarter 4</option>
							</select>
						</div>				
					</div>
					<div class="panel-body" style="padding-top:1px;">
						<table class="table table-bordered plan_table" >
							<thead>
								<tr>
									<th colspan="20" style="border-left-color:black; border-right-color:black;">Form 5</th>
								</tr>
								<tr>
									<th style="border-left-color:black; width:12%;">Area Name <br><span class="urdu">علاقہ کا نام </span></th>
									<th style="width:12%;">No of sessions per month <br><span class="urdu">ماہانہ سیشن کی تعداد</span></th>
									<th colspan="2" class="qtr" id="m1">January</th>
									<th colspan="2" class="qtr" id="m2">February</th>
									<th colspan="2" class="qtr" id="m3" style="border-right-color:black;">March</th>
								</tr>
							</thead>
							<tbody>
								<!--- Area1 -->
								<tr>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" id="area1_name" name="area1_name" class="form-control">
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" name="area1_num_sessions" class="form-control text-center numberclass">
									</td>
									<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area1_dateschedule_m1" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area1_dateschedule_m2" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area1_dateschedule_m3" class="form-control text-center calendar" readonly></td>
								</tr>
								<tr>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area1_dateheld_m1" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area1_dateheld_m2" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area1_dateheld_m3" class="form-control text-center calendar" readonly></td>
								</tr>
								<tr>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area1_transport_m1" name="area1_transport_m1" class="form-control"></td>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area1_transport_m2" name="area1_transport_m2" class="form-control"></td>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area1_transport_m3" name="area1_transport_m3" class="form-control"></td>
								</tr>
								<tr>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area1_resperson_m1" name="area1_resperson_m1" class="form-control"></td>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area1_resperson_m2" name="area1_resperson_m2" class="form-control"></td>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area1_resperson_m3" name="area1_resperson_m3" class="form-control"></td>
								</tr>
								<tr>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area1_distsupport_m1">
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area1_distsupport_m2">
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area1_distsupport_m3">
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
								</tr>
								<!--- Area2 -->
								<tr>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" id="area2_name" name="area2_name" class="form-control">
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" id="area2_num_sessions" name="area2_num_sessions" class="form-control text-center numberclass">
									</td>
									<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area2_dateschedule_m1" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area2_dateschedule_m2" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area2_dateschedule_m3" class="form-control text-center calendar" readonly></td>
								</tr>
								<tr>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area2_dateheld_m1" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area2_dateheld_m2" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area2_dateheld_m3" class="form-control text-center calendar" readonly></td>
								</tr>
								<tr>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area2_transport_m1" name="area2_transport_m1" class="form-control"></td>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area2_transport_m2" name="area2_transport_m2" class="form-control"></td>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area2_transport_m3" name="area2_transport_m3" class="form-control"></td>
								</tr>
								<tr>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area2_resperson_m1" name="area2_resperson_m1" class="form-control"></td>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area2_resperson_m2" name="area2_resperson_m2" class="form-control"></td>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area2_resperson_m3" name="area2_resperson_m3" class="form-control"></td>
								</tr>
								<tr>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area2_distsupport_m1">
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area2_distsupport_m2">
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area2_distsupport_m3">
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
								</tr>
								<!--- Area3 -->
								<tr>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" id="area3_name" name="area3_name" class="form-control">
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" id="area3_num_sessions" name="area3_num_sessions" class="form-control text-center numberclass">
									</td>
									<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area3_dateschedule_m1" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area3_dateschedule_m2" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text" name="area3_dateschedule_m3" class="form-control text-center calendar" readonly></td>
								</tr>
								<tr>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area3_dateheld_m1" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area3_dateheld_m2" class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text" name="area3_dateheld_m3" class="form-control text-center calendar" readonly></td>
								</tr>
								<tr>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area3_transport_m1" name="area3_transport_m1" class="form-control"></td>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area3_transport_m2" name="area3_transport_m2" class="form-control"></td>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area3_transport_m3" name="area3_transport_m3" class="form-control"></td>
								</tr>
								<tr>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area3_resperson_m1" name="area3_resperson_m1" class="form-control"></td>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area3_resperson_m2" name="area3_resperson_m2" class="form-control"></td>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area3_resperson_m3" name="area3_resperson_m3" class="form-control"></td>
								</tr>
								<tr>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area3_distsupport_m1">
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area3_distsupport_m2">
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" name="area3_distsupport_m3">
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
								</tr>					
								<tr>
									<td colspan="2" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Activities  for hard to reach and problem areas<br><span class="urdu">مشکل گزار علاقوں کىلئے اقدامات</span></label></td>
									<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
									<td><input type="text" id="ahtr_activities_m1" name="ahtr_activities_m1" class="form-control" ></td>
									<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
									<td><input type="text" id="ahtr_activities_m2" name="ahtr_activities_m2" class="form-control" ></td>
									<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
									<td><input type="text" id="ahtr_activities_m3" name="ahtr_activities_m3" class="form-control" ></td>
								</tr>
								<tr>
									<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
									<td><input type="text" id="ahtr_resperson_m1" name="ahtr_resperson_m1" class="form-control"></td>
									<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
									<td><input type="text" id="ahtr_resperson_m2" name="ahtr_resperson_m2" class="form-control"></td>
									<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
									<td><input type="text" id="ahtr_resperson_m3" name="ahtr_resperson_m3" class="form-control"></td>
								</tr>
								<tr>
									<td colspan="2" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Regular Activitites<br><span class="urdu">باقاعدہ اقدامات</span></label></td>
									<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
									<td><input type="text" id="ra_activities_m1" name="ra_activities_m1" class="form-control"></td>
									<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
									<td><input type="text" id="ra_activities_m2" name="ra_activities_m2" class="form-control"></td>
									<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
									<td><input type="text" id="ra_activities_m3" name="ra_activities_m3" class="form-control"></td>
								</tr>
								<tr>
									<td><label for="Person responsible ">Person Responsible <br><span class="urdu">ذمہ دار شخص کا نام</span></label></td>
									<td><input type="text" id="ra_resperson_m1" name="ra_resperson_m1" class="form-control"></td>
									<td><label for="Person responsible ">Person Responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
									<td><input type="text" id="ra_resperson_m2" name="ra_resperson_m2" class="form-control"></td>
									<td><label for="Person responsible ">Person Responsible<br><span class="urdu">ذمہ دار شخص کا نام</span></label></td>
									<td><input type="text" id="ra_resperson_m3" name="ra_resperson_m3" class="form-control"></td>
								</tr>
								<tr>
									<td colspan="2" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Monitoring of session implementation<br><span class="urdu">حفاظتى ٹیکہ جات کے سیشن کے نفاذ کى نگرانى</span></label></td>
									<td><label for="session_jan">No. of sessions held<br><span class="urdu"> شبڈول سیشن کى تعداد</span></label></td>
									<td><input type="text" id="msi_numheld_m1" name="msi_numheld_m1" class="form-control text-center numberclass"></td>
									<td><label for="session_feb">No. of sessions held<br><span class="urdu"> شبڈول سبشن کى تعداد</span></label></td>
									<td><input type="text" id="msi_numheld_m2" name="msi_numheld_m2" class="form-control text-center numberclass"></td>
									<td><label for="session_mar">No. of sessions held<br><span class="urdu"> شبڈول سبشن کى تعداد</span> </label></td>
									<td><input type="text" id="msi_numheld_m3" name="msi_numheld_m3" class="form-control text-center numberclass"></td>
								</tr>
								<tr>
									<td><label for="plain_jan">No of sessions planned<br><span class="urdu"> منعقد کیے گئے سیشن کى تعداد</span></label></td>
									<td><input type="text" id="msi_numplan_m1" name="msi_numplan_m1" class="form-control text-center numberclass"></td>
									<td><label for="plain_feb">No of sessions planned<br><span class="urdu"> منعقد کبے گئے سبشن کى تعداد</span></label></td>
									<td><input type="text" id="msi_numplan_m2" name="msi_numplan_m2" class="form-control text-center numberclass"></td>
									<td><label for="plain_mar">No of sessions planned<br><span class="urdu"> منعقد کیے گئے سیشن کى تعداد</span></label></td>
									<td><input type="text" id="msi_numplan_m3" name="msi_numplan_m3" class="form-control text-center numberclass"></td>
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
			$(document).on('change','#ticode', function(){
				var tcode = this.value;
				//to get ucs of selected distcrict
				if(tcode != 0) {
					$.ajax({
						type: "POST",
						data: "tcode="+tcode,
						url: "<?php echo base_url(); ?>Ajax_red_rec/getUnC",
						success: function(result){
							$('#unicode').html(result);
						}
					});
					$.ajax({
						type: "POST",
						data: "tcode="+tcode,
						url: "<?php echo base_url(); ?>Ajax_red_rec/getFacTehsils",
						success: function(result){
							$('#facode').html(result);
						}
					});
				}
				else{
					$('#unicode').html('');
					$('#facode').html('');
					//it doesn't exist
				}								
			});
			$(document).on('change','#unicode', function(){
				var uncode = this.value;
			//to get facilities of selected UC
				if(uncode =="") {
				  $('#facode').html('');
				  //it doesn't exist
				}
				else{
					$.ajax({
						type: "POST",
						data: "uncode="+uncode,
						url: "<?php echo base_url(); ?>Ajax_red_rec/getFacilities",
						success: function(result){
							$('#facode').html(result);
						}
					});
				}
			});

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