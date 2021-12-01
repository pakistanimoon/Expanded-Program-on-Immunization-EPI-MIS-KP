
<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
    //print_r($row);exit;
?>
   <?php  foreach($row as $key => $val){
			 $numarea = $key+1;
		  ?>
	
	<tr>
		<td rowspan="5" style="vertical-align:middle">
			<input type="text" id="area1_name"  name="area_name[<?php echo $numarea; ?>]" value="<?Php print_r (get_Village_Name($val['area_name'])); ?>" class="form-control" readonly>
			<input type="text" hidden="hidden" id="area1_code"  name="area_code[<?php echo $numarea; ?>]" value="<?Php print_r ($val['area_name']); ?>">
			<input type="text" hidden id="numarea" name="numarea" value="<?Php echo $numarea ; ?>">
			<input type="text" hidden id="numarea" name="numarea" value="<?Php echo $numarea ; ?>">
		</td>
		<td rowspan="5" style="vertical-align:middle">
			<input type="text" name="area_num_sessions[<?php echo $numarea; ?>]" value="<?Php print_r ($val['f3_actual_sessions_plan']); ?>" class="form-control text-center numberclass" readonly>
			<input type="hidden" class="type" name="session_type_nm[<?php echo $numarea; ?>]" value="<?Php print_r ($val['f3_session_type']); ?>"  >
		</td>
		<!--<td rowspan="5" style="vertical-align:middle">
			<input type="text" name="sessions_type[<?php echo $numarea; ?>]" value="<?Php print_r ($val['f3_session_type']); ?>" class="form-control text-center numberclass" readonly>
		</td>-->
	<?php if($val['f3_session_type']=='Fixed'){?>
		<td colspan="2">  <!-- this td for table -->		
			<table>
					<tbody>
						 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
						<tr>
							<!--<td><input type="text" name="area_dateheld_m1[<?php echo $index; echo $numarea; ?>]"  class="form-control text-center calendar"  ></td>-->
							<td style="height: 62px;"><input type="text" name="sitename_s[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r (get_Facility_Name($val['facode'])); ?>"   class="form-control text-center " readonly  ></td>
							<input   type="hidden" name="sitecode_s[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['facode']); ?>">
						</tr>
					 <?php } ?>
					</tbody>
			</table>
		</td>
   <?php } else{ ?>
		<td colspan="2">  <!-- this td for table -->		
			<table class="tbl-placeholder">
					<tbody>
						 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
						<tr>
							<td style="height: 62px;"><input type="text" name="sitecode_s[<?php echo $numarea; ?>][<?php echo $index; ?>]"  placeholder="Site Name Scheduled "   class="form-control text-center test"></td>
						</tr>
					 <?php } ?>
					</tbody>
			</table>
		</td>
   <?php } ?>
		
		<td colspan="2">  <!-- this td for table -->
		
		<table>
				<tbody>
					
					 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
					<tr>
						
						<td>
						<input type="hidden" class="type1" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['f3_session_type']); ?>"  >
						<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_name']); ?>"  >
						<label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label>
						</td>
						<td><input type="text" name="area_dateschedule_m1[<?php echo $numarea; ?>][<?php echo $index; ?>]"  class="form-control text-center calendar1 <?php if($val['f3_session_type']=='Fixed'){echo "date-shedule-f1";}else if($val['f3_session_type']=='Outreach'){echo "date-shedule-o1";}else{echo "date-shedule-m1";}?>" data-date-format="yyyy-mm-dd" readonly></td>
						
					</tr>
					
				 <?php } ?>
				</tbody>
			</table>
			
		</td> <!-- close -->
		
		
		<td colspan="2">  <!-- this td for table -->
			<table>
				<tbody>
					
					 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
					<tr>
						<input type="hidden" class="type2" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['f3_session_type']); ?>"  >
						<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_name']); ?>"  >
						<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
						<td><input type="text" name="area_dateschedule_m2[<?php echo $numarea; ?>][<?php echo $index; ?>]" class="form-control text-center calendar2 <?php if($val['f3_session_type']=='Fixed'){echo "date-shedule-f2";}else if($val['f3_session_type']=='Outreach'){echo "date-shedule-o2";}else{echo "date-shedule-m2";}?>"  data-date-format="yyyy-mm-dd"  readonly></td>
						
					</tr>
					<tr></tr>
				 <?php } ?>
				</tbody>
			</table>
			
		</td> <!-- close -->
		<td colspan="2">  <!-- this td for table -->
			<table>
				<tbody>
					
					 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
					<tr>
							<input type="hidden" class="type3" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['f3_session_type']); ?>"  >
							<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_name']); ?>"  >
						<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
						<td><input type="text" name="area_dateschedule_m3[<?php echo $numarea; ?>][<?php echo $index; ?>]" class="form-control text-center calendar3 <?php if($val['f3_session_type']=='Fixed'){echo "date-shedule-f3";}else if($val['f3_session_type']=='Outreach'){echo "date-shedule-o3";}else{echo "date-shedule-m3";}?>"  data-date-format="yyyy-mm-dd" readonly></td>
						
					</tr>
					<tr></tr>
				 <?php } ?>
				</tbody>
			</table>
			
		</td> <!-- close -->
		
		
		<!--
		<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
		<td><input type="text" name="area1_dateschedule_m1" class="form-control text-center calendar" readonly></td>
		<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
		<td><input type="text" name="area1_dateschedule_m2" class="form-control text-center calendar" readonly></td>
		<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
		<td><input type="text" name="area1_dateschedule_m3" class="form-control text-center calendar" readonly></td>
			-->
	</tr>
		
	<tr>
		
		<?php if($val['f3_session_type']=='Fixed'){?>
		<td colspan="2">  <!-- this td for table -->		
			<table>
					<tbody>
						 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
						<tr>
							<!--<td><input type="text" name="area_dateheld_m1[<?php echo $numarea; ?>] [<?php echo $index; ?>]"  class="form-control text-center calendar"  ></td>-->
							<td style="height: 80px;"><input type="text" name="sitename_h[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r (get_Facility_Name($val['facode'])); ?>"   class="form-control text-center" readonly  ></td>
							<input   type="hidden" name="sitecode_h[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['facode']); ?>">
						</tr>
					 <?php } ?>
					</tbody>
			</table>
		</td>
   <?php } else{ ?>
		<td colspan="2">  <!-- this td for table -->		
			<table class="tbl-placeholder" >
					<tbody id="tbl1">
						 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
						<tr>
							<td style="height: 80px;"><input type="text" name="sitecode_h[<?php echo $numarea; ?>][<?php echo $index; ?>]" placeholder="Site Name Held"  class="form-control text-center testo"  ></td>
						</tr>
					 <?php } ?>
					</tbody>
			</table>
		</td>
   <?php } ?>
		<td colspan="2">  <!-- this td for table -->
		
			<table>
					<tbody>
						
						 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
						<tr>
						    <input type="hidden" class="type1" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['f3_session_type']); ?>"  >
							<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_name']); ?>"  >
							<td><label for="date_of_scheduled" style="margin-right: 6px;">Date(s) <br> Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
							<td><input type="text" name="area_dateheld_m1[<?php echo $numarea; ?>][<?php echo $index; ?>]"  class="form-control text-center calendar1  <?php if($val['f3_session_type']=='Fixed'){echo "date-held-f1";}else if($val['f3_session_type']=='Outreach'){echo "date-held-o1";}else{echo "date-held-m1";}?>"  data-date-format="yyyy-mm-dd" readonly></td>
							
						</tr>
						<tr></tr>
					 <?php } ?>
					</tbody>
				</table>
				
		</td>
		<td colspan="2">  <!-- this td for table -->
			<table>
					<tbody>
						
						 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
						<tr>
							<input type="hidden" class="type2" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['f3_session_type']); ?>"  >
							<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_name']); ?>"  >
							<td><label for="date_of_scheduled" style="margin-right: 6px;">Date(s) <br> Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
							<td><input type="text" name="area_dateheld_m2[<?php echo $numarea; ?>][<?php echo $index; ?>]" class="form-control text-center calendar2  <?php if($val['f3_session_type']=='Fixed'){echo "date-held-f2";}else if($val['f3_session_type']=='Outreach'){echo "date-held-o2";}else{echo "date-held-m2";}?>"  data-date-format="yyyy-mm-dd" readonly></td>
							
						</tr>
						<tr></tr>
					 <?php } ?>
					</tbody>
				</table>
				
		</td>
		<td colspan="2">  <!-- this td for table -->
			<table>
					<tbody>
						 <?php for($index=1;$index<=$val['f3_actual_sessions_plan'];$index++) { ?>
						<tr>
							<input type="hidden" class="type3" name="session_type[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['f3_session_type']); ?>"  >
							<input type="hidden" class="type1" name="area_code_dt[<?php echo $numarea; ?>][<?php echo $index; ?>]" value="<?Php print_r ($val['area_name']); ?>"  >
							<td><label for="date_of_scheduled" style="margin-right: 6px;">Date(s) <br> Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
							<td><input type="text" name="area_dateheld_m3[<?php echo $numarea; ?>][<?php echo $index; ?>]" class="form-control text-center calendar3  <?php if($val['f3_session_type']=='Fixed'){echo "date-held-f3";}else if($val['f3_session_type']=='Outreach'){echo "date-held-o3";}else{echo "date-held-m3";}?>"  data-date-format="yyyy-mm-dd" readonly></td>
							
						</tr>
						<tr></tr>
					 <?php } ?>
					</tbody>
				</table>
				
		</td>
		
		<!--<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
		<td><input type="text" name="area1_dateheld_m1" class="form-control text-center calendar" readonly></td>
		<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
		<td><input type="text" name="area1_dateheld_m2" class="form-control text-center calendar" readonly></td>
		<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
		<td><input type="text" name="area1_dateheld_m3" class="form-control text-center calendar" readonly></td>-->
		
	</tr>
	
    	<?php if($val['f3_session_type']=='Fixed'){?>
	<tr>
		<td colspan="2" rowspan="3" ></td>
		<td colspan="1"><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
		<td colspan="1"> <input type="text" id="area_transport_m1" name="area_transport_m1[<?php echo $numarea; ?>]" class="form-control" disabled readonly></td>
		<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
		<td><input type="text" id="area_transport_m2" name="area_transport_m2[<?php echo $numarea; ?>]" class="form-control" disabled readonly></td>
		<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
		<td><input type="text" id="area_transport_m3" name="area_transport_m3[<?php echo $numarea; ?>]" class="form-control" disabled readonly></td>
	</tr>
		<?php }else{ ?>
	<tr>
		<td colspan="2" rowspan="3" ></td>
		<td colspan="1"><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
		<td colspan="1"> <input type="text" id="area_transport_m1" name="area_transport_m1[<?php echo $numarea; ?>]" class="form-control" ></td>
		<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
		<td><input type="text" id="area_transport_m2" name="area_transport_m2[<?php echo $numarea; ?>]" class="form-control" ></td>
		<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
		<td><input type="text" id="area_transport_m3" name="area_transport_m3[<?php echo $numarea; ?>]" class="form-control" ></td>
	</tr>
		<?php }?>
	<tr>
		
		<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
		<td><input type="text" id="area1_resperson_m1" value="<?Php print_r ($val['technicianname']); ?>" name="area_resperson_m1[<?php echo $numarea; ?>]" class="form-control"></td>
		<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
		<td><input type="text" id="area1_resperson_m2" value="<?Php print_r ($val['technicianname']); ?>" name="area_resperson_m2[<?php echo $numarea; ?>]" class="form-control"></td>
		<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
		<td><input type="text" id="area1_resperson_m3" value="<?Php print_r ($val['technicianname']); ?>" name="area_resperson_m3[<?php echo $numarea; ?>]" class="form-control"></td>
	</tr>
	<tr>
	    
		<td>
			<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
		</td>
		<td>
			<select class="form-control text-center" name="area_distsupport_m1[<?php echo $numarea; ?>]">
				<option value="">-- Select --</option>
				<option value="No">No</option>
				<option value="Yes">Yes</option>							
			</select>
		</td>
		<td>
			<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
		</td>
		<td>
			<select class="form-control text-center" name="area_distsupport_m2[<?php echo $numarea; ?>]">
				<option value="">-- Select --</option>
				<option value="No">No</option>
				<option value="Yes">Yes</option>							
			</select>
		</td>
		<td>
			<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
		</td>
		<td>
			<select class="form-control text-center" name="area_distsupport_m3[<?php echo $numarea; ?>]">
				<option value="">-- Select --</option>
				<option value="No">No</option>
				<option value="Yes">Yes</option>							
			</select>
		</td>
	</tr>
	
	<?php } ?>
		<tr class="bottr">
			<td colspan="4" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Activities  for hard to reach and problem areas<br><span class="urdu">مشکل گزار علاقوں کىلئے اقدامات</span></label></td>
			<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
			<td><input type="text" id="ahtr_activities_m1"  name="ahtr_activities_m1" class="form-control" ></td>
			<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
			<td><input type="text" id="ahtr_activities_m2" name="ahtr_activities_m2" class="form-control" ></td>
			<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
			<td><input type="text" id="ahtr_activities_m3" name="ahtr_activities_m3" class="form-control" ></td>
		</tr>
		<tr class="bottr">
			<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
			<td><input type="text" id="ahtr_resperson_m1" value="<?Php print_r ($val['technicianname']); ?>"  name="ahtr_resperson_m1" class="form-control"></td>
			<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
			<td><input type="text" id="ahtr_resperson_m2" value="<?Php print_r ($val['technicianname']); ?>"  name="ahtr_resperson_m2" class="form-control"></td>
			<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
			<td><input type="text" id="ahtr_resperson_m3" value="<?Php print_r ($val['technicianname']); ?>"  name="ahtr_resperson_m3" class="form-control"></td>
		</tr>
		<tr class="bottr">
			<td colspan="4" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Regular Activitites<br><span class="urdu">باقاعدہ اقدامات</span></label></td>
			<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
			<td><input type="text" id="ra_activities_m1" name="ra_activities_m1" class="form-control"></td>
			<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
			<td><input type="text" id="ra_activities_m2" name="ra_activities_m2" class="form-control"></td>
			<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
			<td><input type="text" id="ra_activities_m3" name="ra_activities_m3" class="form-control"></td>
		</tr>
		<tr class="bottr">
			<td><label for="Person responsible ">Person Responsible <br><span class="urdu">ذمہ دار شخص کا نام</span></label></td>
			<td><input type="text" id="ra_resperson_m1" value="<?Php print_r ($val['technicianname']); ?>"  name="ra_resperson_m1" class="form-control"></td>
			<td><label for="Person responsible ">Person Responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
			<td><input type="text" id="ra_resperson_m2" value="<?Php print_r ($val['technicianname']); ?>"  name="ra_resperson_m2" class="form-control"></td>
			<td><label for="Person responsible ">Person Responsible<br><span class="urdu">ذمہ دار شخص کا نام</span></label></td>
			<td><input type="text" id="ra_resperson_m3" value="<?Php print_r ($val['technicianname']); ?>"  name="ra_resperson_m3" class="form-control"></td>
		</tr>
		<tr class="bottr">
		<td colspan="4" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Monitoring of session implementation<br><span class="urdu">حفاظتى ٹیکہ جات کے سیشن کے نفاذ کى نگرانى</span></label></td>
			<td><label for="plain_jan">No of sessions planned<br><span class="urdu"> منعقد کیے گئے سیشن کى تعداد</span></label></td>
			<!--<td><input type="text" id="msi_numplan_m1" name="msi_numplan_m1" class="form-control text-center numberclass"></td>-->
			<td style="width: 100px;">
				<input type="text" id="sp_Fixed_m1"    name="sp_Fixed_m1"    value="0"  placeholder="Fixed"  class="form-control text-center numberclass">
				<input type="text" id="sp_Outreach_m1" name="sp_Outreach_m1" value="0"  placeholder="Outreach" class="form-control text-center numberclass">
				<input type="text" id="sp_Mobile_m1"   name="sp_Mobile_m1"   value="0"  placeholder="Mobile"  class="form-control text-center numberclass">
			</td>
			<td><label for="plain_feb">No of sessions planned<br><span class="urdu"> منعقد کبے گئے سبشن کى تعداد</span></label></td>
			<td style="width: 100px;">
				<input type="text" id="sp_Fixed_m2"    name="sp_Fixed_m2"    value="0" placeholder="Fixed"  class="form-control text-center numberclass">
				<input type="text" id="sp_Outreach_m2" name="sp_Outreach_m2" value="0" placeholder="Outreach" class="form-control text-center numberclass">
				<input type="text" id="sp_Mobile_m2"   name="sp_Mobile_m2"   value="0" placeholder="Mobile"  class="form-control text-center numberclass">
			</td>
			<td><label for="plain_mar">No of sessions planned<br><span class="urdu"> منعقد کیے گئے سیشن کى تعداد</span></label></td>
			<td style="width: 100px;">
				<input type="text" id="sp_Fixed_m3"    name="sp_Fixed_m3"    value="0" placeholder="Fixed"  class="form-control text-center numberclass">
				<input type="text" id="sp_Outreach_m3" name="sp_Outreach_m3" value="0" placeholder="Outreach" class="form-control text-center numberclass">
				<input type="text" id="sp_Mobile_m3"   name="sp_Mobile_m3"   value="0" placeholder="Mobile"  class="form-control text-center numberclass">
			</td>                                             
		</tr>
		<tr class="bottr">
			
			<td><label for="session_jan">No. of sessions held<br><span class="urdu"> شبڈول سیشن کى تعداد</span></label></td>
			<td style="width: 100px;">
				<input type="text" id="sh_Fixed_m1"    name="sh_Fixed_m1"    value="0" placeholder="Fixed" class="form-control text-center numberclass">
				<input type="text" id="sh_Outreach_m1" name="sh_Outreach_m1" value="0" placeholder="Outreach" class="form-control text-center numberclass">
				<input type="text" id="sh_Mobile_m1"   name="sh_Mobile_m1"   value="0" placeholder="Mobile" class="form-control text-center numberclass">
			</td>
			<td><label for="session_feb">No. of sessions held<br><span class="urdu"> شبڈول سبشن کى تعداد</span></label></td>
			<td style="width: 100px;">
				<input type="text" id="sh_Fixed_m2"    name="sh_Fixed_m2"    value="0" placeholder="Fixed" class="form-control text-center numberclass">
				<input type="text" id="sh_Outreach_m2" name="sh_Outreach_m2" value="0" placeholder="Outreach" class="form-control text-center numberclass">
				<input type="text" id="sh_Mobile_m2"   name="sh_Mobile_m2"   value="0" placeholder="Mobile" class="form-control text-center numberclass">
			</td>
			<td><label for="session_mar">No. of sessions held<br><span class="urdu"> شبڈول سبشن کى تعداد</span> </label></td>
			
			<td style="width: 100px;">
				<input type="text" id="sh_Fixed_m3"    name="sh_Fixed_m3"    value="0" placeholder="Fixed"  class="form-control text-center numberclass">
				<input type="text" id="sh_Outreach_m3" name="sh_Outreach_m3" value="0" placeholder="Outreach" class="form-control text-center numberclass">
				<input type="text" id="sh_Mobile_m3"   name="sh_Mobile_m3"   value="0" placeholder="Mobile"  class="form-control text-center numberclass">
			</td>
		</tr>
		
	
	
	
	
	

	<script type="text/javascript">
	/* $('.test').on('keyup' , function (){
			 
			 var colvalue=this.value;
			 var index = $(this).closest("tr").index();
			 ranknum = index+1;
			 $("#tbl1").find("tr:nth-child("+ranknum+")").find("td:nth-child(1)").find('input').val(colvalue);
	
		}); */
		////////////finel//////////////////
		  $(document).on('change','#quarter', function(){	
		        var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var quarter = this.value;
				//alert(quarter);
				var year = $('#year').val();
				var month1 = $('#m1').attr('month');
				var month2 = $('#m2').attr('month');
				var month3 = $('#m3').attr('month');
				if(month1 != 0 ){
					var minDate = new Date(year, month1-1, 1);
					var maxDate = new Date(year, month1, 0);
					$('.calendar1').each(function(){	 
					  $(this).datepicker('setStartDate', minDate); 
					});
					$('.calendar1').each(function(){
						$(this).datepicker('setEndDate', maxDate);
					}); 
				}
				if(month2 != 0 ){
					var minDate = new Date(year, month2-1, 1);
					var maxDate = new Date(year, month2, 0);
					$('.calendar2').each(function(){ 
						$(this).datepicker('setStartDate', minDate);
					});	  
					$('.calendar2').each(function(){
						$(this).datepicker('setEndDate', maxDate);
					});
				}
				if(month3 != 0 ){
					var minDate = new Date(year, month3-1, 1);
					var maxDate = new Date(year, month3, 0);
					$('.calendar3').each(function(){
						$(this).datepicker('setStartDate', minDate);
					});	  
					$('.calendar3').each(function(){
						$(this).datepicker('setEndDate', maxDate);
					});
				} 
		 }); 
				////////////final //////////////////	
///////////////this Ready function for 1st time page load datepicker////////////////////
	$(document).ready(function(){
					 var today = new Date();
					 var dd = today.getDate();
					 var mm = today.getMonth()+1; //January is 0!
					 var year = $('#year').val();
					 
					 /* function quarter_of_the_year(date){
							var month = date.getMonth() + 1;
							return (Math.ceil(month / 3));
					} */
					//var  qua = '0'+quarter_of_the_year(new Date());
					var qua= <?php  echo $quarter ;?>;
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
						var minDate = new Date(year, month1-1, 1);
						var maxDate = new Date(year, month1, 0);
						$('.calendar1').each(function(){	 
							$(this).datepicker('setStartDate', minDate); 
						});
						$('.calendar1').each(function(){
							$(this).datepicker('setEndDate', maxDate);
						}); 	 
					}
					if(month2 != 0 ){
						var minDate = new Date(year, month2-1, 1);
						var maxDate = new Date(year, month2, 0);
						$('.calendar2').each(function(){ 
						  $(this).datepicker('setStartDate', minDate);
						});	  
						$('.calendar2').each(function(){
							$(this).datepicker('setEndDate', maxDate);
						});
					}
				if(month3 != 0 ){
					 var minDate = new Date(year, month3-1, 1);
				     var maxDate = new Date(year, month3, 0);
					 $('.calendar3').each(function(){
						$(this).datepicker('setStartDate', minDate);
					 });	  
				     $('.calendar3').each(function(){
						 $(this).datepicker('setEndDate', maxDate);
				   	 });
				}
	});
///////////////this Ready function for 1st time page load datepicker////////////////////	
	
	
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