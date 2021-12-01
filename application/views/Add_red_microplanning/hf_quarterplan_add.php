<style>
 .tr-procceed{
     position:absolute;
    width:81%;
    background:#b2b9c8b3 !important;
    color:white;
   }
   .tr-procceed td{
    display:inherit;
    text-align:center;
    height:512px;
    
   }
   .tr-procceed td span{
    position: relative;
    top: 224px;
    font-size:40px;
   }
 </style>
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
					Health Facility Workplan for a Quarter (3 months) <span class="urdu" style="font-size:12px; font-weight:400;">مرکز صحت کى سہ ماہى منصوبہ بندى برائے حفاظتى ٹیکہ جات</span>
				</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_save">
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
								<label>Year:</label>						
							</div>						
							<div class="col-md-3">							
							<select class="form-control" name="year" id="year">								
							<?php echo getAllYearsOptionsIncludingNext(); ?>						
							</select>						
							</div>
						<div class="col-md-2 ">
							<label>Health Facility:</label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="facode" id="facode" required="required">
								<option value="">-- Select --</option>
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
								<option value="01">Quarter 1</option>
								<option value="02">Quarter 2</option>
								<option value="03">Quarter 3</option>
								<option value="04">Quarter 4</option>
							</select>
						</div>
                        
						<div class="col-md-2 ">								
							<label>Technician:</label>						
						</div>
							<div class="col-md-3">								
								<select class="form-control" name="techniciancode" id="technician">								        
									<option value="">-- Select --</option>									
									</select>						
							</div>

						
					</div>
					<div class="panel-body" style="padding-top:1px;">
						<table id="hfTable" class="table table-bordered plan_table" >
							<thead>
								<tr>
									<th colspan="20" style="border-left-color:black; border-right-color:black;">Form 5</th>
								</tr>
								<tr>
									<th style="border-left-color:black; width:10%;">Area Name <br><span class="urdu">علاقہ کا نام </span></th>
									<th style="width:10%;">No of sessions per month <br><span class="urdu">ماہانہ سیشن کی تعداد</span></th>
									<!--<th style="width:12%;">Session type (Fixed, outreach, mobile)<br><span class="urdu"> سیشن کی قسم مثلاِ مرکز صحت موبائیل سم وغیرہ</span></th>-->
									<th colspan="2"  class="qtr" id="">Site Name</th>
									<th colspan="2" class="qtr" id="m1">January</th>
									<th colspan="2" class="qtr" id="m2">February</th>
									<th colspan="2" class="qtr" id="m3" style="border-right-color:black;">March</th>
								</tr>
							</thead>
						
							<tbody>
							
							<tr class="tr-procceed" id="procceed-1">
								<td colspan="20"><span>Select Above Dropdown To Proceed</span></td>
							</tr>
								<!--- Area1 -->
								
								<tr class="toptr">
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" id="area1_name" class="form-control">
									</td>
									<td rowspan="5" style="vertical-align:middle">
										<input type="text" class="form-control text-center numberclass">
									</td>
									<!--<td rowspan="5" style="vertical-align:middle">
										<input type="text" class="form-control text-center numberclass">
									</td>-->
									<td colspan="2"><input type="text"  class="form-control text-center " ></td>
									<td><label for="date_of_scheduled">Date of Scheduled <br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text"  class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text"  class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date of Scheduled<br><span class="urdu">تاریخ(شیڈول)</span></label></td>
									<td><input type="text"  class="form-control text-center calendar" readonly></td>
								</tr>
								<tr class="toptr">
									<td colspan="2"><input type="text"  class="form-control text-center " ></td>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text"  class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text"  class="form-control text-center calendar" readonly></td>
									<td><label for="date_of_scheduled">Date(s) Held<br><span class="urdu">تاریخ(جس دن سیشن منعقد کیا گیا)</span></label></td>
									<td><input type="text"  class="form-control text-center calendar" readonly></td>
								</tr>
								<tr class="toptr" >
									<td colspan="2" rowspan="3"></td>
									<td ><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area1_transport_m1"  class="form-control"></td>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area1_transport_m2"  class="form-control"></td>
									<td><label for="date_of_scheduled">Transport<br><span class="urdu">نقل وحمل /ٹرانسپورٹ</span></label></td>
									<td><input type="text" id="area1_transport_m3" class="form-control"></td>
								</tr>
								<tr class="toptr">
									
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area1_resperson_m1"  class="form-control"></td>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area1_resperson_m2"  class="form-control"></td>
									<td><label for="date_of_scheduled">Person Responsible<br><span class="urdu">ذمہ دارشخص کا نام</span></label></td>
									<td><input type="text" id="area1_resperson_m3"  class="form-control"></td>
								</tr>
								<tr class="toptr">
									
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" >
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" >
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
									<td>
										<label for="date_of_scheduled">District support (Y/N)<br><span class="urdu">ضلع کی مدد (ہاں /نہیں)</span></label>
									</td>
									<td>
										<select class="form-control text-center" >
											<option value="">-- Select --</option>
											<option value="No">No</option>
											<option value="Yes">Yes</option>							
										</select>
									</td>
								</tr>		
								<tr class="bottr">
									<td colspan="4" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Activities  for hard to reach and problem areas<br><span class="urdu">مشکل گزار علاقوں کىلئے اقدامات</span></label></td>
									<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
									<td><input type="text" id="ahtr_activities_m1" name="ahtr_activities_m1" class="form-control" ></td>
									<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
									<td><input type="text" id="ahtr_activities_m2" name="ahtr_activities_m2" class="form-control" ></td>
									<td><label for="activities">Activities<br><span class="urdu">  اقدامات  </span></label></td>
									<td><input type="text" id="ahtr_activities_m3" name="ahtr_activities_m3" class="form-control" ></td>
								</tr>
								<tr class="bottr">
									<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
									<td><input type="text" id="ahtr_resperson_m1" name="ahtr_resperson_m1" class="form-control"></td>
									<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
									<td><input type="text" id="ahtr_resperson_m2" name="ahtr_resperson_m2" class="form-control"></td>
									<td><label for="Person responsible ">Person responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
									<td><input type="text" id="ahtr_resperson_m3" name="ahtr_resperson_m3" class="form-control"></td>
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
									<td><input type="text" id="ra_resperson_m1" name="ra_resperson_m1" class="form-control"></td>
									<td><label for="Person responsible ">Person Responsible<br><span class="urdu">ذمہ دار شخص کا نام</span> </label></td>
									<td><input type="text" id="ra_resperson_m2" name="ra_resperson_m2" class="form-control"></td>
									<td><label for="Person responsible ">Person Responsible<br><span class="urdu">ذمہ دار شخص کا نام</span></label></td>
									<td><input type="text" id="ra_resperson_m3" name="ra_resperson_m3" class="form-control"></td>
								</tr>
								<tr class="bottr">
									<td colspan="4" rowspan="2" style="vertical-align:middle;"><label for="act_for_hard_reach">Monitoring of session implementation<br><span class="urdu">حفاظتى ٹیکہ جات کے سیشن کے نفاذ کى نگرانى</span></label></td>
									<td><label for="session_jan">No. of sessions held<br><span class="urdu"> شبڈول سیشن کى تعداد</span></label></td>
									<td><input type="text" id="msi_numheld_m1" name="msi_numheld_m1" class="form-control text-center numberclass"></td>
									<td><label for="session_feb">No. of sessions held<br><span class="urdu"> شبڈول سبشن کى تعداد</span></label></td>
									<td><input type="text" id="msi_numheld_m2" name="msi_numheld_m2" class="form-control text-center numberclass"></td>
									<td><label for="session_mar">No. of sessions held<br><span class="urdu"> شبڈول سبشن کى تعداد</span> </label></td>
									<td><input type="text" id="msi_numheld_m3" name="msi_numheld_m3" class="form-control text-center numberclass"></td>
								</tr>
								<tr class="bottr">
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
								<a href="<?php echo base_url();?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>
								<button type="reset" class="form-btn"><i class="fa fa-recycle" aria-hidden="true"></i> Reset Form</button>								
								<button id="submit"  type="submit"  class="form-btn btn" disabled="disabled"><i class="fa fa-floppy-o " aria-hidden="true"></i> Submit Form</button>								
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
			$(document).on('change','#facode', function(){
				var facode = this.value;
				var year = $('#year :selected').text();
				//to get facilities of selected UC
				if(facode =="") {
				  $('#facode').html('');
				  //it doesn't exist
				}
				else{
					$.ajax({
						type: "POST",
						data: "facode="+facode+"&year="+year,
						url: "<?php echo base_url(); ?>Ajax_red_rec/getTechredrec",
						success: function(result){
							$('#technician').html(result);
						}
					});
				}
			});	
			$(document).on('change','#technician', function(){		
				var techniciancode = this.value;
				var year = $('#year :selected').text();
				var quarter=$('#quarter :selected').val();
				//alert(quarter);
				var table = $('#hfTable');
				
				table.find("tbody").html('');
				if(techniciancode == ""){
					$('#techniciancode').html('');
				}
				else{
					$.ajax({	
						type: "POST",
						data: "techniciancode="+techniciancode+"&year="+year+"&quarter="+quarter,
						url: "<?php echo base_url(); ?>Ajax_red_rec/getAreaAndSession",
						success: function(result){	
							$("tbody").html(result);
							//$('.bottr').show();
							//$('.toptr').remove();
							$("#submit").removeAttr('disabled');
							
						}
					});
				}				
			});			
			
			$(document).on('change','#quarter', function(){
				var quarter = this.value;
				//////////////////
					var techniciancode =$("#technician option:selected").val();
					var facode =$("#facode option:selected").val();
					var year = $("#year option:selected").val();
					$.ajax({
							type: 'post',
							data: "techniciancode="+techniciancode+ "&quarter="+quarter+ "&facode="+facode+ "&year="+year,
							//url: "<?php echo base_url(); ?>Ajax_red_rec/checkQuarter_avalible_list",
							url: "<?php echo base_url(); ?>Ajax_red_rec/checkQuarter_avalible_list",
							success: function (data) {
								var check = JSON.parse(data);
								//alert(check);
										if( check == "yes" ){ 
										alert("Cannot save data because data already exists for this Quarter!");
										  location.reload();
										$("#quarter").css("background-color","#FF0000");
										}else if(check == "no" ){
											$("#quarter").css("background-color","#FFF");
										}
							}
					}); 
                /////////////////////////				
				
				
				
				//alert(quarter);
				if(quarter == '01'){
					$('#m1').text('January').attr('month','01');
					$('#m2').text('February').attr('month','02');
					$('#m3').text('March').attr('month','03');
				}
				else if(quarter == '02'){
					$('#m1').text('April').attr('month','04');
					$('#m2').text('May').attr('month','05');
					$('#m3').text('June').attr('month','06');
				}
				else if(quarter == '03'){
					$('#m1').text('July').attr('month','07');
					$('#m2').text('August').attr('month','08');
					$('#m3').text('September').attr('month','09');
				}
				else if(quarter == '04'){
					$('#m1').text('October').attr('month','10');
					$('#m2').text('November').attr('month','11');
					$('#m3').text('December').attr('month','12');
				}
				else{
					/* $('#m1').text('January').attr('month','01');
					$('#m2').text('February').attr('month','02');
					$('#m3').text('March').attr('month','03'); */
					
							if(qua == '01'){
							$('#m1').text('January').attr('month','01');
							$('#m2').text('February').attr('month','02');
							$('#m3').text('March').attr('month','03');
						}
						else if(qua == '02'){
							$('#m1').text('April').attr('month','04');
							$('#m2').text('May').attr('month','05');
							$('#m3').text('June').attr('month','06');
						}
						else if(qua == '03'){
							$('#m1').text('July').attr('month','07');
							$('#m2').text('August').attr('month','08');
							$('#m3').text('September').attr('month','09');
						}
						else if(qua == '04'){
							$('#m1').text('October').attr('month','10');
							$('#m2').text('November').attr('month','11');
							$('#m3').text('December').attr('month','12');
						}
				}
			});		
					function quarter_of_the_year(date) 
						{
							var month = date.getMonth() + 1;
							return (Math.ceil(month / 3));
						}
						var  qua = '0'+quarter_of_the_year(new Date());
						//alert(qua);		
				//////////////////// Cehck Technician Record already Enter //////////////////////////////
			 	$(document).on('change', '#technician', function(){
					var techniciancode = this.value;
					var facode =$("#facode option:selected").val();
					var year = $("#year option:selected").val();
					var quarter = $("#quarter option:selected").val();				
					 $.ajax({
							type: 'post',
							data: "techniciancode="+techniciancode+ "&quarter="+quarter+ "&facode="+facode+ "&year="+year,
							//url: "<?php echo base_url(); ?>Ajax_red_rec/checkTechnician_avalible",
							url: "<?php echo base_url(); ?>Ajax_red_rec/checkTechnician_avalible_list",
							success: function (data) {
								var check = JSON.parse(data);
								//alert(check);
										if( check == "yes" ){ 
										alert("Cannot save data because data already exists for this Technician!");
										  location.reload();
										$("#technician").css("background-color","#FF0000");
										}else if(check == "no" ){
											$("#technician").css("background-color","#FFF");
										}
							}
					}); 
				}); 
				//////////////////// END //////////////////////////////
			
				//////////////////// END //////////////////////////////
				
				
 						
		});					
	</script>