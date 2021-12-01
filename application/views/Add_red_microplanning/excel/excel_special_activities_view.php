
				
					<table class="table table-bordered plan_table" border="1">
						<thead>
							<tr>
								<th style="border-left-color:black;">List of areas (according to priority) <br><span class="urdu">فوقیت کے اعتبار سے علاقوں کے نام</span></th>
								<th>Category of problem i.e 1,2,3,4 (refer to table 1) <br><span class="urdu">مسلئے کی درجہ بندی( ٹیبل نمبر ۱ سے رجوع کریں)</span></th>
								<th>Hard to reach (Y/N)<br><span class="urdu">(Y/N)مشکل گزار علاقہ </span></th>
								<th>How many times were they reached last year<br><span class="urdu">پچهلے سال کتنى بار ان مشکل گزار علاقوں تک رسائى ممکن ہوئى</span></th>
								<th>Activities that can be conducted by HF level to improve access and utilization<br><span class="urdu">وہ اقدامات جو مرکز صحت کی سطح سے کیے جا سکتے ہو ں تا کہ حفاظتى ٹیکہ جات کی پہنچ اور اس کا استعمال بہتر بنایا جاسکے</span></th>
								<th>Activities that need support by district or higher level<br><span class="urdu">وہ اقدامات جو ضلعى سطح سے کیے جاسکتے ہوں تاکہ حفاظتى ٹیکہ جات کى پہنچ اور اس کا استعمال بہتر بناىا جاسکے</span></th>
								<th style="border-right-color:black;">What other interventions can be delivered at same time as immunization<br><span class="urdu">مزید ایسے اقدامات جو حفاظتى ٹیکہ جات کے ساتھ مشکل گزار علاقوں میں کیے جاسکتے ہوں جیسا کہ وٹامنA وغیرہ</span></th>
							</tr>
						</thead>
						<tbody id="tableplanbody">
							<tr>
								<td>a</td>
								<td>b</td>
								<td>c</td>
								<td>d</td>
								<td>e</td>
								<td>f</td>
								<td>g</td>
							</tr>
							<?php 
								$i=1;
								foreach($data as $key=>$val) {
							?>
							<tr>
								<td><p style="margin-top: 6px;"><?php echo get_Village_Name($val['area_name']); ?></p></td>
								<input type="hidden" value="<?php echo $val['techniciancode']; ?>" name="techniciancode" id="techniciancodeh" class="form-control text-center category">
								<input type="hidden" value="<?php echo $val['year']; ?>" name="year" id="yearh" class="form-control text-center category" > 
								<td><p style="margin-top: 6px;"><?php echo $val['category']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f2_hard_to_reach']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f2_reached_last_year']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f2_activities_improve_hf']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f2_activities_need_support']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['f2_interventions_delivered']; ?></p></td>
							</tr>
							<?php $i++; } ?>
						</tbody>
					</table>
					