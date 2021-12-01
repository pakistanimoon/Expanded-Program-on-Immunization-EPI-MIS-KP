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
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Planning Special Activities Update Form</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Special_activities/special_activities_save">
					<div class="row" style="width:100%; padding:4px 17px">
						<input type="hidden" name="edit" value="edit">
						<input type="hidden" name="submitted_date" value="<?php echo $data[0]['submitted_date']; ?>">
						<input type="hidden" name="updated_date" value="<?php echo $current_date; ?>">
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
					<div class="panel-body" style="padding-top:1px;">
						<table class="table table-bordered plan_table" >
							<thead>
								<tr>
									<th style="border-left-color:black;">List of areas (according to priority) <br><span class="urdu">فوقیت کے اعتبار سے علاقوں کے نام</span></th>
									<th>Category of problem i.e 1,2,3,4 (refer to table 1) <br><span class="urdu">مسلئے کی درجہ بندی( ٹیبل نمبر ۱ سے رجوع کریں)</span></th>
									<th>Hard to reach (Yes/No)<br><span class="urdu">(Yes/No)مشکل گزار علاقہ </span></th>
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
									<td><input type="text" name="area_name[<?php echo $key+1; ?>]" value="<?php echo $val['area_name']; ?>" class="form-control" readonly="readonly"></td>
									<td><input type="text" name="category[<?php echo $key+1; ?>]" value="<?php echo $val['category']; ?>" class="form-control text-center" readonly="readonly"></td>									
									<td>
										<select class="form-control text-center" name="hard_to_reach[<?php echo $key+1; ?>]">
											<option value="0">-- Select --</option>
											<option <?php //if($val['hard_to_reach'] == "Yes") echo 'selected="selected"'; ?> value="Yes">Yes</option>
											<option <?php //if($val['hard_to_reach'] == "No") echo 'selected="selected"'; ?> value="No">No</option>
										</select>
									</td>
									<td><input type="text" name="reached_last_year[<?php echo $key+1; ?>]" value="<?php //echo $val['reached_last_year']; ?>" class="form-control text-center"></td>
									<td><input type="text" name="activities_improve_hf[<?php echo $key+1; ?>]" value="<?php //echo $val['activities_improve_hf']; ?>" class="form-control"></td>
									<td><input type="text" name="activities_need_support[<?php echo $key+1; ?>]" value="<?php //echo $val['activities_need_support']; ?>" class="form-control"></td>
									<td><input type="text" name="interventions_delivered[<?php echo $key+1; ?>]" value="<?php //echo $val['interventions_delivered']; ?>" class="form-control"></td>
								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-12">
								<!--<a href="<?php echo base_url();?>red_microplan/Situation_analysis/situation_analysis_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>-->
								<button type="reset" class="form-btn"><i class="fa fa-recycle" aria-hidden="true"></i> Reset Form</button>								
								<button type="submit" class="form-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit Form</button>								
							</div>
						</div>	
					</div> <!--end of panel body-->
				</form>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->
