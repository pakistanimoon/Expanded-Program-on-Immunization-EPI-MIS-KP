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
					Using the RED Strategy for Problem Solving <br><span class="urdu" style="font-size:12px; font-weight:400;">حفاظتى ٹىکہ جات کے مسائل کو حل کرنے کىلئے RED حکمت عملى کا استعمال</span>
				</div>
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Using the RED Strategy for Problem Solving Form View</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Red_strategy/red_strategy_save">
					<div class="row" style="width:100%; padding:4px 17px">
						<br>
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
					<!-- <br> -->
					<div class="panel-body" style="padding-top:1px;">
						<table class="table table-bordered plan_table" >
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
								foreach($data as $key=>$val) {
									for($index=1;$index<=count($labels);$index++) { ?>
									<tr>
										<td><?php echo $labels[$index-1]; ?></td>
										<td><p style="margin-top: 6px;"><?php echo $val['problems_r'.$index.'_c1']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $val['actlimitres_r'.$index.'_c2']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $val['actneedresources_r'.$index.'_c3']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo  date('d-m-Y', strtotime($val['date_r'.$index.'_c4'])); ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $val['area_r'.$index.'_c5']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $val['person_r'.$index.'_c6']; ?></p></td>
									</tr>
								<?php } } ?>
							</tbody>							
						</table>
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url();?>red_microplan/Red_strategy/red_strategy_list"><button type="button" class="form-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
								<a href="<?php echo base_url();?>red_microplan/Red_strategy/red_strategy_edit/<?php echo $data[0]['facode']; ?>/<?php echo $data[0]['year']; ?>"><button type="button" class="form-btn"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button></a>	
							</div>
						</div>				
					</div> <!--end of panel body-->
				</form>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->