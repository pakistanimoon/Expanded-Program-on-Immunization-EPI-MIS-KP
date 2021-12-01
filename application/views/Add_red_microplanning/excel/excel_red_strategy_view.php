
						<table class="table table-bordered plan_table" border="1" >
							<thead>
								<tr>
									<th style="border-left-color:black;">RED components<br><span class="urdu">حکمت عملى کے اجزاء RED</span></th>
									<th>Problems<br><span class="urdu">مسائل</span></th>
									<th>Activities with limited resources<br><span class="urdu">محدود وسائل کے ساتھ اقدامات</span></th>
									<th style="width:18%;">Activities needing resources and assistance from district<br><span class="urdu">وہ اقدامات جن کیلئے وسائل اور ضلعى سطح سے مدد درکار ہوں</span></th>
									<th>When (date)<br><span class="urdu">کب</span></th>
									<th>Area name <br><span class="urdu">علاقے کا نام</span></th>
									<th style="border-right-color:black;">Responsible Person<br><span class="urdu"> ذمہ دار شخص کا نام</span></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$labels = array(
									"Re-establishment of outreach services <br><span class=\"urdu\">آوٹ رىچ کو بہتر بنانا</span>",
									"Supportive supervision <br><span class=\"urdu\">نگرانی برائےاصلاح</span>",
									"Community links with service delivery <br><span class=\"urdu\">حفاظتى ٹیکہ جات کیلئے لوگوں سے روابط</span>",
									"Monitoring and use of data for action <br><span class=\"urdu\">نگرانی اور حفاظتى ٹیکہ جات کے اعدادوشمارکا استعمال</span>",
									"Planning and management of resources <br><span class=\"urdu\">وسائل کی منصوبہ بندی اور ان کا استعمال</span>"
								);
								$i=1;
							//	foreach($data as $key=>$val) {
									for($index=1;$index<=count($labels);$index++) { ?>
									<tr>
										<td><?php echo $labels[$index-1]; ?></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_problems_r'.$index.'_c1']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_actlimitres_r'.$index.'_c2']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_actneedresources_r'.$index.'_c3']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_date_r'.$index.'_c4']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_area_r'.$index.'_c5']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_person_r'.$index.'_c6']; ?></p></td>
									</tr>
								<?php }// } ?>
							</tbody>							
						</table>
					