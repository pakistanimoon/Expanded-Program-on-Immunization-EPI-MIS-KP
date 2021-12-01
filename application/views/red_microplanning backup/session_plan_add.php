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
					Session Plan Template <br><span class="urdu" style="font-size:12px; font-weight:400;">حفاظتی ٹیکہ جات کے سیشن کی منصوبہ بندی</span>
				</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Session_plan/session_plan_save">
					<div class="row" style="width:100%; padding:4px 17px">						<input type="hidden" name="submitted_date" id="submitted_date" value="<?php echo $current_date; ?>" class="form-control">											<div class="col-md-2 col-md-offset-1">							<label>Tehsil:</label>						</div>						<div class="col-md-3">							<input type="text" value="<?php echo $data[0]['tehsil']; ?>" class="form-control" readonly>							<input type="hidden" name="tcode" value="<?php echo $data[0]['tcode']; ?>" class="form-control">													</div>						<div class="col-md-2">							<label>Union Council:</label>						</div>						<div class="col-md-3">							<input type="text" value="<?php echo $data[0]['uc_name']; ?>" class="form-control" readonly>							<input type="hidden" name="uncode" value="<?php echo $data[0]['uncode']; ?>" class="form-control">														</div>					</div>					<div class="row" style="width:100%; padding:4px 17px">												<div class="col-md-2 col-md-offset-1">							<label>Health Facility:</label>						</div>						<div class="col-md-3">							<input type="text" value="<?php echo $data[0]['facility']; ?>" class="form-control" readonly>							<input type="hidden" name="facode" value="<?php echo $data[0]['facode']; ?>" class="form-control">						</div>						<div class="col-md-2">							<label>Year:</label>						</div>						<div class="col-md-3">							<input type="text" name="year" value="<?php echo $data[0]['year']; ?>" class="form-control area_name" readonly="readonly">													</div>					</div>
					<div class="panel-body" style="padding-top:1px;">
						<table class="table table-bordered plan_table" >
							<thead>
								<tr>
									<th colspan="20" style="border-left-color:black; border-right-color:black;">Form 3</th>
								</tr>
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
								<?php $i=1;	
								$rowcount=count($data);
								foreach($data as $key=>$val) {
								//print_r($data);exit;	?>	
									<tr>	
										<td><input type="text" value="<?php echo $val['area_name']; ?>" name="area_name[<?php echo $key+1; ?>]" class="form-control"></td>
										<input type="hidden" name="fk[<?php echo $key+1; ?>]" value="<?php echo $val['foreign_key']; ?>">
										<td><input type="text" name="total_population[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation total_population"></td>	
										<td><input type="text" name="target_population[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation target_population"></td>
										<td>
											<select class="form-control text-center session_type" name="session_type[<?php echo $key+1; ?>]" id="session_type" required>
												<option value="">-- Select --</option>	
												<option value="Fixed">Fixed</option>
												<option value="Outreach">Outreach</option>
												<option value="Mobile">Mobile</option>	
											</select>
										</td>	
										<td><input type="text" name="injections_per_year[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation injections_per_year" readonly="readonly"></td>
										<td><input type="text" name="injections_per_month[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation injections_per_month" readonly="readonly"></td>
										<td><input type="text" name="estimated_sessions[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation estimated_sessions"></td>					
										<td><input type="text" name="sessions_per_month[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation sessions_per_month" readonly="readonly"></td>									
										<td><input type="text" name="actual_sessions_plan[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation actual_sessions_plan"></td>					
										<td><input type="text" name="child_survival_interventions[<?php echo $key+1; ?>]" class="form-control"></td>									
										<td>
											<select class="form-control text-center hard_to_reach" name="hard_to_reach[<?php echo $key+1; ?>]" required="required">
												<option value="">-- Select --</option>
												<option value="No">No</option>
												<option value="Yes">Yes</option>
											</select>
										</td>
										<td><input type="text" name="hard_to_reach_population[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation hard_to_reach_population"></td>
									</tr>	
								<?php } ?>								
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-12">
								<!--<a href="<?php echo base_url();?>red_microplan/Session_plan/session_plan_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>-->
								<button type="reset" class="form-btn"><i class="fa fa-recycle" aria-hidden="true"></i> Reset Form</button>								
								<button type="submit" id="spt_form" class="form-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit Form</button>								
							</div>
						</div>		
					</div> <!--end of panel body-->
				</form>	
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->	

	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('change','#fyear', function(){
				var year = this.value;
				//to get facilities of selected UC
				if(year =="") {
				  	$('#facode').html('');				  	
				  //it doesn't exist
				}else{
					$.ajax({
						type: "POST",
						data: "year="+year,
						url: "<?php echo base_url(); ?>Ajax_red_rec/getFacilitiesforForm3",
						success: function(result){
							$('#facode').html(result);						
							set_hfcode();
						}
					});				
				}
			});

	//		function getFacRecord(){
//				var year = $('#fyear').val();
			//	var facode = $('#facode').val();
				//$.ajax({
					//type: "POST",				
					//data: {year:year,facode:facode},
					//dataTyp: 'JSON',
					//url: "<?php echo base_url(); ?>Ajax_red_rec/getFacility_RecordForm3",
					//success: function(result){
						//var resultarray = JSON.parse(result);
						//console.log("moon");
						//var htmll = '';						
						///	htmll +='<tr>';
						//		htmll +='<td>I</td>';
						//		htmll +='<td>II</td>';
						//		htmll +='<td>III</td>';
						//		htmll +='<td>IV</td>';
						//		htmll +='<td>V</td>';
						//		htmll +='<td>VI=V/12</td>';
						//		htmll +='<td>VII</td>';
						//		htmll +='<td>VIII</td>';
						//		htmll +='<td>IX</td>';
						//		htmll +='<td>X</td>';
						//		htmll +='<td>XI</td>';
						//		htmll +='<td>XII</td>';								
						//	htmll +='</tr>'
						//for(var i = 0; i < resultarray.length; i++) {						  
						//	$("#tcode").val(resultarray[i].tcode);
						//	$("#th_name").val(resultarray[i].th_name);
						//	$("#uncode").val(resultarray[i].uncode);
						//	$("#uc_name").val(resultarray[i].uc_name);
						//	htmll += '<tr>';
						//	htmll += '<td><input type="text" value="'+resultarray[i].area_name+'" name="area_name['+i+']" class="form-control"></td>';
						//	htmll += '<td><input type="text" name="total_population['+i+']" class="form-control text-center numberclass calculation total_population"></td>';
						//	htmll += '<td><input type="text" name="target_population['+i+']" class="form-control text-center numberclass calculation target_population"></td>';									
						//	htmll += '<td>';
						//	htmll += '<select class="form-control text-center session_type" name="session_type['+i+']" id="session_type" required>';
						//		htmll += '<option value="">-- Select --</option>';
						//		htmll += '<option value="Fixed">Fixed</option>';
						//		htmll += '<option value="Outreach">Outreach</option>';
						//		htmll += '<option value="Mobile">Mobile</option>';
						//	htmll += '</select>';
						//	htmll += '</td>';
						//	htmll += '<td><input type="text" name="injections_per_year['+i+']" class="form-control text-center numberclass calculation injections_per_year" readonly="readonly"></td>';
						//	htmll += '<td><input type="text" name="injections_per_month['+i+']" class="form-control text-center numberclass calculation injections_per_month" readonly="readonly"></td>';
						//	htmll += '<td><input type="text" name="estimated_sessions['+i+']" class="form-control text-center numberclass calculation estimated_sessions"></td>';
						//	htmll += '<td><input type="text" name="sessions_per_month['+i+']" class="form-control text-center numberclass calculation sessions_per_month" readonly="readonly"></td>';
						//	htmll += '<td><input type="text" name="actual_sessions_plan['+i+']" class="form-control text-center numberclass calculation actual_sessions_plan"></td>';
						//	htmll += '<td><input type="text" name="child_survival_interventions['+i+']" class="form-control"></td>';						
						//	htmll += '<td>';
						//	htmll += '<select class="form-control text-center hard_to_reach" name="hard_to_reach['+i+']" required="required">';
						//		htmll += '<option value="">-- Select --</option>';
						//		htmll += '<option value="No">No</option>';
						//		htmll += '<option value="Yes">Yes</option>';								
						//	htmll += '</select>';
						//	htmll += '</td>';
						//	htmll += '<td><input type="text" name="hard_to_reach_population['+i+']" class="form-control text-center numberclass calculation hard_to_reach_population"></td>';
							//htmll += '</tr>';  
						//}
						//$("#tableplanbody").html(htmll);
					//}
				//});
			//}	

			$(document).on('change','#facode', function(){
				getFacRecord();				
			});			

			$(document).on('keyup','.calculation',function(e){
				var v = Math.round(parseFloat($(this).closest('tr').find(".target_population").val())*11);
				//alert(v);		
				if( ! isNaN(v)){
				   $(this).closest('tr').find(".injections_per_year").val(v);
				}
				else{
					$(this).closest('tr').find(".injections_per_year").val(0);
				}

				var vi = Math.round(parseFloat($(this).closest('tr').find(".injections_per_year").val())/12);
				//alert(v);		
				if( ! isNaN(vi)){
				   $(this).closest('tr').find(".injections_per_month").val(vi);
				}
				else{
					$(this).closest('tr').find(".injections_per_month").val(0);
				}

				var tot_pop = parseInt($(this).closest('tr').find(".total_population").val());
				var tar_pop = parseInt($(this).closest('tr').find(".target_population").val());
				
				if(tar_pop > tot_pop){
					alert("Target population cannot be greater than total population");
					$(this).closest('tr').find(".target_population").css("background-color","#FF0000");
				}
				else{
					$(this).closest('tr').find(".target_population").css("background-color","#FFF");
				}
				var htr_pop = parseInt($(this).closest('tr').find(".hard_to_reach_population").val());
				if(htr_pop > tot_pop){
					alert("Hard to reach population cannot be greater than total population");
					$(this).closest('tr').find(".hard_to_reach_population").css("background-color","#FF0000");
				}
				else{
					$(this).closest('tr').find(".hard_to_reach_population").css("background-color","#FFF");
				}

				var est_sessions = parseInt($(this).closest('tr').find(".sessions_per_month").val());
				var actual_sessions = parseInt($(this).closest('tr').find(".actual_sessions_plan").val());
				
				if(actual_sessions > est_sessions){
					alert("Number of actual sessions cannot be greater than estimated sessions");
					$(this).closest('tr').find(".actual_sessions_plan").css("background-color","#FF0000");
				}
				else{
					$(this).closest('tr').find(".actual_sessions_plan").css("background-color","#FFF");
				}				
			});

			$(document).on('change','.session_type',function(){
				var session_type = $(this).val();
				if(session_type !== 'Mobile'){
					if(session_type == 'Fixed'){
						var num_sess = parseInt($(this).closest('tr').find(".estimated_sessions").val());
						var spm = Math.round(parseFloat((num_sess)*80));
						if( ! isNaN(spm)){
						   $(this).closest('tr').find(".sessions_per_month").val(spm);
						}
						else{
							$(this).closest('tr').find(".sessions_per_month").val(0);
						}						
					}
					if(session_type == 'Outreach'){
						var num_sess = parseInt($(this).closest('tr').find(".estimated_sessions").val());
						var spm = Math.round(parseFloat((num_sess)*40));
						if( ! isNaN(spm)){
						   $(this).closest('tr').find(".sessions_per_month").val(spm);
						}
						else{
							$(this).closest('tr').find(".sessions_per_month").val(0);
						}						
					}
					if(session_type == ''){
						$(this).closest('tr').find(".sessions_per_month").val(0);
					}								
				}
				else{
					var num_sess = parseInt($(this).closest('tr').find(".estimated_sessions").val());
					var spm = Math.round(parseFloat((num_sess)*1));
					if( ! isNaN(spm)){
					   $(this).closest('tr').find(".sessions_per_month").val(spm);
					}
					else{
						$(this).closest('tr').find(".sessions_per_month").val(0);
					}	
				}	
			}); 
			$(document).on('keyup','.calculation',function(e){
				var num_sess = parseInt($(this).closest('tr').find(".estimated_sessions").val());
				var session_type = $(this).closest('tr').find(".session_type").val();
				if(session_type !== 'Mobile'){
					if(session_type == 'Fixed'){
						spm = parseInt((num_sess*80));
						if( ! isNaN(spm)){
						   $(this).closest('tr').find(".sessions_per_month").val(spm);
						}
						else{
							$(this).closest('tr').find(".sessions_per_month").val(0);
						}		
					}
					if(session_type == 'Outreach'){
						spm = parseInt((num_sess*40));
						if( ! isNaN(spm)){
						   $(this).closest('tr').find(".sessions_per_month").val(spm);
						}
						else{
							$(this).closest('tr').find(".sessions_per_month").val(0);
						}		
					}
				}
				else{
					spm = parseInt((num_sess*1));
					if( ! isNaN(spm)){
					   $(this).closest('tr').find(".sessions_per_month").val(spm);
					}
					else{
						$(this).closest('tr').find(".sessions_per_month").val(0);
					}
				}
			});
			var hard_to_reach = $(this).closest("tr").find(".hard_to_reach").val();
			if(hard_to_reach == ''){
				$(this).closest("tr").find(".hard_to_reach_population").prop("disabled", !this.checked);
			}
			$(document).on('change','.hard_to_reach',function(){
				var hard_to_reach = $(this).val();
				if(hard_to_reach !== 'Yes'){
					$(this).closest("tr").find(".hard_to_reach_population").val();
					$(this).closest("tr").find(".hard_to_reach_population").attr("disabled", "disabled");
				}
				else{
					$(this).closest("tr").find(".hard_to_reach_population").removeAttr("disabled", "disabled");
					//$(".hard_to_reach_population").removeAttr("disabled", !this.checked);	
				}
			});						
		});
	</script>