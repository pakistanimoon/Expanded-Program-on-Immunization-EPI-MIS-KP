<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
?>
<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:17px;border-color:white !important;"> 
					Planning special activities for hard to reach and problem areas <br><span class="urdu" style="font-size:12px; font-weight:400;">پلان برائے مشکل گزار اور دور دراز علاقہ جات</span>
				</div>
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Planning Special Activities Form View</div>
				<div class="row" style="width:100%; padding:4px 17px">						
					<div class="col-md-2 col-md-offset-1">
						<label>Year:</label>
					</div>
					<div class="col-md-3">
						<p><?php echo $data[0]['year']; ?></p>
					</div>
					<div class="col-md-2">
						<label>Health Facility:</label>
					</div>
					<div class="col-md-3">
						<p><?php echo $data[0]['facility']; ?></p>
					</div>						
				</div>
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
				<div class="panel-body" style="padding-top:1px;">
					<table class="table table-bordered plan_table" >
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
								<td><p style="margin-top: 6px;"><?php echo $val['area_name']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['category']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['hard_to_reach']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['reached_last_year']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['activities_improve_hf']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['activities_need_support']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['interventions_delivered']; ?></p></td>
							</tr>
							<?php $i++; } ?>
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-12">
							<a href="<?php echo base_url();?>red_microplan/Special_activities/special_activities_list"><button type="button" class="form-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
							<!--<a href="<?php echo base_url();?>red_microplan/Special_activities/special_activities_edit/<?php echo $data[0]['facode']; ?>/<?php echo $data[0]['year']; ?>"><button type="button" class="form-btn"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button></a>-->								
							<a href="<?php echo base_url(); ?>red_microplan/Session_plan/session_plan_view/<?php echo $data[0]['facode']; ?>/<?php echo $data[0]['year']; ?>"><button type="button" class="form-btn"><i class="fa fa-search" aria-hidden="true"></i> Session Plan Form View</button></a>	
						</div>
					</div>	
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->