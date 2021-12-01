<button style="float:right;padding:5px;color:white;" id="excel1" ><i class="fa fa-file-excel-o" aria-hidden="true">Excel</i></button>
<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
	//print_r($data);exit;
?>
<!-- <div class="content-wrapper"> -->

<section class="content">	
	
	<div class="container">
		<div class="row">
		
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:17px;border-color:white !important;">
					Situation Analysis view <span class="urdu" style="font-size:12px; font-weight:400;"> (حفاظتى ٹیکہ جات کے اعدادوشمار کا تجزیہ)</span>
				</div>
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Situation Analysis Form View</div>
			<!--	<div class="row" style="width:100%; padding:4px 17px">
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
				<div class="row" style="width:100%; padding:4px 17px">					
					<div class="col-md-2 col-md-offset-1">
						<label>Health Facility:</label>
					</div>
					<div class="col-md-3">
						<p><?php echo $data[0]['facility']; ?></p>
					</div>
					<div class="col-md-2">
						<label>Year:</label>
					</div>
					<div class="col-md-3">
						<p><?php echo $data[0]['year']; ?></p>
					</div>				
				</div>-->
				<div class="panel-body" style="padding-top:1px;">
					<table class="table table-bordered plan_table" >
						<thead>
							<tr>
								<th rowspan="3" style="border-left-color:black;">Sr. No</th>
								<th rowspan="3" style="border-left-color:black;">Area Name</th>
								<th colspan="9">Compile population, <br>imunization coverage data in the previous 12 months <br><span class="urdu">پچهلے بارہ ماہ کے اعداد و شمار</span></th>
								<th colspan="7">Analyze problem<br><span class="urdu">مسئلے کى جانچ پڑتال</span></th>
								<th rowspan="2">Prioritize area</th>
							</tr>
							<tr>
								<th>Target population<br> figures(No.)<br><span class="urdu">ایک سال سے کم عمر کے بچوں کا مطلوبہ ہدف سالانہ</span></th>
								<th colspan="4">Doses of vaccine administered<br><span class="urdu">لگائی جانے والی ویکسین کی تعداد</span></th>
								<th colspan="4">Immunization coverage (%)<br><span class="urdu">حفاظتى ٹیکہ جات کی کوریج</span></th>
								<th colspan="2">Unimmunized (No.)<br><span class="urdu">ویکسین سے محروم بچے</span></th>
								<th colspan="2">Drop-out rates(%)<br><span class="urdu">ڈراپ آوٹ</span></th>
								<th colspan="2">Identify problem (Good/Poor)<br><span class="urdu">مسئلے کى جانچ</span></th>
								<th>Categorize<br>problem<br>according<br>to table<br><span class="urdu">مسئلے کى درجہ بندى</span></th>
							</tr>
							<tr>
								<th><1 year</th>
								<th>Penta1</th>
								<th>Penta3</th>
								<th>Measles</th>
								<th>TT2</th>
								<th>Penta1<br>(c/b x 100)</th>
								<th>Penta3<br>(d/b x 100)</th>
								<th>Measles<br>(e/b x 100) </th>
								<th>TT2 <br>(f/b x 100)</th>
								<th>Penta3<br>(b-d)</th>
								<th>Measles <br>(b-e)</th>
								<th>Penta1-Penta3<br>(c-d)/c x 100</th>
								<th>Penta1-Measles<br>(c-e)/c x 100</th>
								<th>Access<br><span class="urdu">پہنچ</span></th>
								<th>Utilization<br><span class="urdu">استعمال</span></th>
								<th>Category 1,2,3,4</th>
								<th>Priority 1,2,3,….</th>
							</tr>
						</thead>
						<tbody id="trRow">
							<tr>
								<td></td>
								<td>a</td>
								<td>b</td>
								<td>c</td>
								<td>d</td>
								<td>e</td>
								<td>f</td>
								<td>g</td>
								<td>h</td>
								<td>i</td>
								<td>j</td>
								<td>k</td>
								<td>l</td>
								<td>m</td>
								<td>n</td>
								<td>o</td>
								<td>p</td>
								<td>q</td>
								<td>r</td>
							</tr>
							<?php 
								$i=1;
								$rowcount=count($data);
								foreach($data as $key=>$val) {
							?>				
							<tr>				
								<td><label class="srno-lbl" ><?php echo $i; ?></label></td>
								<td><p style="margin-top: 6px;"><?php echo get_Village_Name($val['area_name']); ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['less_one_year']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['penta1']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['penta3']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['measles']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['tt2']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['penta1_percent']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['penta3_percent']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['measles_percent']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['tt2_percent']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['penta3_not']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['measles_not']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['penta1penta3']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['penta1measles']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['access']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['utilization']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['category']; ?></p></td>
								<td><p style="margin-top: 6px;"><?php echo $val['priority']; ?></p></td>
							</tr>
							<?php $i++; } ?>
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-12">
							<a href="<?php echo base_url();?>Compliance-Filter/HF-Microplan"><button type="button" class="form-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>							
							<a href="<?php echo base_url();?>red_rec_microplan/Situation_analysis/situation_analysis_edit/<?php echo $data[0]['techniciancode']; ?>/<?php echo $data[0]['year']; ?>"><button type="button" class="form-btn"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button></a>	
							
						</div>
					</div>				
				</div> <!--end of panel body-->	
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$('#excel1').on('click', function () {
			
	var techniciancode =<?php echo $data[0]['techniciancode']; ?>;
	var year =<?php echo $data[0]['year']; ?>;
		//alert(year);
		 
		 var url="<?php echo base_url(); ?>Ajax_red_rec/excel_situation_analysis_view/"+techniciancode+"/"+year;
		window.open(url,"_blank");
				
	});
</script>