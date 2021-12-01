
					<table class="table table-bordered plan_table" border="1" >
						<thead>
							<tr>
								<th style="border-left-color:black;">Area Name<br><span class="urdu">علاقہ کا نام</span></th>
								<th>Total population  <br><span class="urdu">کل آبادی</span></th>
								<th>Target population <br><span class="urdu">آبادی کا حدف </span></th>
								<th>Session type (Fixed, outreach, mobile)<br><span class="urdu">سیشن کی قسم مثلاِ مرکز صحت موبائیل سم وغیرہ</span></th>
								<th>No of injections per year ( target population x 11)<br><span class="urdu">سالانہ تعدادحفاظتى ٹیکہ جات (11xہدف)</span></th>
								<th>No of injections per month<br><span class="urdu">ماہانہ تعداد حفاظتى ٹیکہ جات</span></th>
								<!--<th>Number of Estimated sessions <br><span class="urdu">سیشنز کى متوقع تعداد</span></th>-->
								<th>Estimated sessions per month (divided by 80 for fixed site and 40 for outreach) <br><span class="urdu">ماہانہ سیشنز کى متوقع تعداد مرکز صحت کیلئے 80 سے ضرب دیں آوٹ رىچ کیلئے40 سے ضرب دیں</span></th>
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
								<!--<td>VII</td>-->
								<td>VII</td>
								<td>VIII</td>
								<td>IX</td>
								<td>X</td>
								<td>XI</td>
							</tr>
							<?php 
								$i=1;
								foreach($data as $key=>$val) {
							?>	
							<tr>
								<td><p style="margin-top: 6px;"><?php echo get_Village_Name($val['area_name']); ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f3_total_population']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f3_target_population']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f3_session_type']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f3_injections_per_year']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f3_injections_per_month']; ?></p></td>
								<!--<td><p style="margin-top: 6px;"><?php echo $val['f3_estimated_sessions']; ?></p></td>-->
								<td><p style="margin-top: 6px;"><?php echo $val['f3_sessions_per_month']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f3_actual_sessions_plan']; ?></p></td>
								
								<td><p style="margin-top: 6px;"><?php echo $val['f3_child_survival_interventions']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f3_hard_to_reach']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f3_hard_to_reach_population']; ?></p></td>
							</tr>
							<?php $i++; } ?>	
						</tbody>
					</table>
					