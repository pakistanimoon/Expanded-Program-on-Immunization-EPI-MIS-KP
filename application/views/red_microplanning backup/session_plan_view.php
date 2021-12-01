<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
?>
<!-- <div class="content-wrapper"> -->
<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:17px;border-color:white !important;">
					Session Plan Template <br><span class="urdu" style="font-size:12px; font-weight:400;">حفاظتی ٹیکہ جات کے سیشن کی منصوبہ بندی</span>
				</div>
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Session Plan Template Form View</div>
				<div class="row" style="width:100%; padding:4px 17px">
					<div class="col-md-2 col-md-offset-1">
						<label>Year:</label>
					</div>
					<div class="col-md-3">
						<p><?php echo $data[0]['year']; ?></p>
						<input type="hidden" value="<?php echo $data[0]['year']; ?>" name="year"/>
					</div>
					<div class="col-md-2">
						<label>Health Facility:</label>
					</div>
					<div class="col-md-3">
						<p><?php echo $data[0]['facility']; ?></p>
						<input type="hidden" value="<?php echo $data[0]['facode']; ?>" name="facode"/>
					</div>						
				</div>
				<div class="row" style="width:100%; padding:4px 17px">					
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
				<br>
				<div class="panel-body" style="padding-top:1px;">
					<table class="table table-bordered plan_table" >
						<thead>
							<tr>
								<th style="border-left-color:black;">Area Name<br><span class="urdu">علاقہ کا نام</span></th>
								<th>Total population  <br><span class="urdu">کل آبادی</span></th>
								<th>Target population <br><span class="urdu">آبادی کا حدف </span></th>
								<th>Session type (Fixed, outreach, mobile)<br><span class="urdu">سیشن کی قسم مثلاِ مرکز صحت موبائیل سم وغیرہ</span></th>
								<th>No of injections per year ( target population x 11)<br><span class="urdu">سالانہ تعدادحفاظتى ٹیکہ جات (11xہدف)</span></th>
								<th>No of injections per month<br><span class="urdu">ماہانہ تعداد حفاظتى ٹیکہ جات</span></th>
								<th>Number of Estimated sessions <br><span class="urdu">سیشنز کى متوقع تعداد</span></th>
								<th>Estimated sessions per month (multiply by 80 for fixed site and 40 for outreach) <br><span class="urdu">ماہانہ سیشنز کى متوقع تعداد مرکز صحت کیلئے 80 سے ضرب دیں آوٹ رىچ کیلئے40 سے ضرب دیں</span></th>
								<th>Actual sessions planned per month (realistic judgment)<br><span class="urdu">ماہانہ سیشنز کى حقیقى تعداد</span></th>
								<th>Other child survival interventions planned<br><span class="urdu">بچوں کى صحت و تندرستى کیلئے مزید اقدامات</span></th>
								<th>Hard to reach area (refer to table 3) <br><span class="urdu"> دور افتادہ آبادى ٹیبل نمبر 3 سے رجوع کریں۔</span></th>
								<th style="border-right-color:black;">Hard to reach population<br><span class="urdu">دور افتادہ آبادى ٹیبل نمبر 3 سے رجوع کریں۔</span></th>
							</tr>
						</thead>
						<tbody id="tableplanbody">
							<tr>
								<td>I</td>
								<td>II</td>
								<td>III</td>
								<td>IV</td>
								<td>V</td>
								<td>VI=V/12</td>
								<td>VII</td>
								<td>VIII</td>
								<td>IX</td>
								<td>X</td>
								<td>XI</td>
								<td>XII</td>
							</tr>
							<?php 
								$i=1;
								foreach($data as $key=>$val) {
							?>	
							<tr>
								<td><p style="margin-top: 6px;"><?php echo $val['area_name']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['total_population']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['target_population']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['session_type']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['injections_per_year']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['injections_per_month']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['estimated_sessions']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['sessions_per_month']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['actual_sessions_plan']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['child_survival_interventions']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['hard_to_reach']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['hard_to_reach_population']; ?></p></td>
							</tr>
							<?php $i++; } ?>	
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-12">
							<a href="<?php echo base_url();?>red_microplan/Situation_analysis/situation_analysis_list"><button type="button" class="form-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
							<!--<a href="<?php echo base_url();?>red_microplan/Session_plan/session_plan_edit/<?php echo $data[0]['facode']; ?>/<?php echo $data[0]['year']; ?>"><button type="button" class="form-btn"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button></a>-->	
						</div>
					</div>								
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->