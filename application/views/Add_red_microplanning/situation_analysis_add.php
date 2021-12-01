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
					Situation Analysis <span class="urdu" style="font-size:12px; font-weight:400;"> (حفاظتى ٹیکہ جات کے اعدادوشمار کا تجزیہ)</span>
				</div>
				<form id="myform">
					<!-- <div class="row" style="width:100%; padding:4px 17px">
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
							<label>Health Facility:</label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="facode" id="facode" required="required">
								<option value="">-- Select --</option>
							</select>
						</div>
						<div class="col-md-2">
							<label>Year:</label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="year" id="year">
								<?php echo getAllYearsOptionsIncludingCurrent(); ?>
							</select>
						</div>				
					</div> -->
					<div class="panel-body">
						<table class="table table-bordered plan_table">
							<thead>
								<tr>
									<th colspan="20" style="border-left-color:black; border-right-color:black;">Form 1</th>
								</tr>
								<tr>									
									<th rowspan="4" style="border-left-color:black;">Sr. No</th>
									<th rowspan="3" style="border-left-color:black;">Area Name</th>
									<th colspan="9">Compile population, <br>immunization coverage data in the previous 12 months <br><span class="urdu">پچهلے بارہ ماہ کے اعداد و شمار</span></th>
									<th colspan="7">Analyze problem<br><span class="urdu">مسئلے کى جانچ پڑتال</span></th>
									<th rowspan="2">Prioritize area</th>
									<th rowspan="3" colspan="2"  style="border-right-color:black;">Action</th>
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
									<td>a <span style="color:red;">*</span></td>
									<td>b <span style="color:red;">*</span></td>
									<td>c <span style="color:red;">*</span></td>
									<td>d <span style="color:red;">*</span></td>
									<td>e <span style="color:red;">*</span></td>
									<td>f <span style="color:red;">*</span></td>
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
									<td></td>
								</tr>
								<?php 
									$i=1;
									$rowcount=count($data);
                                   if($rowcount == 0){
										 
							    ?>
								<tr>		
									<td><label class="srno-lbl" name="lb[1]" >1</label></td>
									<td>
									<select class="form-control village"   id="village" name="area_name[1]"  >
												<?php echo get_Village_Name($val['area_name']); ?> 
									</select>
											<!--<input type="text" name="area_name[1]" class="form-control areaName" required="required">-->
									</td>
									<td><input type="text" readonly id="population_less_year[1]"  name="less_one_year[1]" class="form-control text-center numberclass calculation less_one_year">
										<input type="hidden"  id="f3_total_population[1]"  name="f3_total_population[1]" class="form-control text-center numberclass calculation f3_total_population">
									</td>
									<td><input type="text" id="penta1"  name="penta1[1]"  class="form-control text-center numberclass calculation penta1"></td>
									<td><input type="text" id="penta3"  name="penta3[1]" class="form-control text-center numberclass calculation penta3 try prt"></td>
									<td><input type="text" id="measles"  name="measles[1]" class="form-control text-center numberclass calculation measles  prt"></td>
									<td><input type="text" id="tt2"  name="tt2[1]" class="form-control text-center numberclass calculation tt2"></td>
									<td><input type="text" name="penta1_percent[1]" class="form-control numberclass text-center calculation penta1_percent" readonly></td>
									<td><input type="text" name="penta3_percent[1]" class="form-control numberclass text-center calculation penta3_percent" readonly></td>
									<td><input type="text" name="measles_percent[1]" class="form-control numberclass text-center calculation measles_percent" readonly></td>
									<td><input type="text" name="tt2_percent[1]" class="form-control numberclass text-center calculation tt2_percent" readonly></td>
									<td><input type="text" name="penta3_not[1]" class="form-control numberclass text-center calculation penta3_not" readonly></td>
									<td><input type="text" name="measles_not[1]" class="form-control numberclass text-center calculation measles_not" readonly></td>
									<td><input type="text" name="penta1penta3[1]" class="form-control numberclass text-center calculation penta1penta3" readonly></td>
									<td><input type="text" name="penta1measles[1]" class="form-control numberclass text-center calculation penta1measles" readonly></td>
									<td><input type="text" name="access[1]" class="form-control numberclass text-center access" readonly></td>
									<td><input type="text" name="utilization[1]" class="form-control numberclass text-center utilization" readonly></td>
									<td><input type="text" name="category[1]" class="form-control numberclass text-center category" readonly></td>									
									<td><input type="text" name="priority[1]" class="form-control numberclass text-center priority" readonly></td>		
									<td>
										<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
										
									</td>
								</tr>
							
							  
										  
										 <?php }else { ?> 
									
									<?php foreach($data as $key=>$val) {
								?>
								<tr>		
									<td><label class="srno-lbl" name="lb[1]" ><?php echo $key+1; ?></label>
									<?php if($val['recid'] > 0 ) { ?>
									 <input type="hidden" id="recid" name="recid[<?php echo $key+1; ?>]" value="<?php echo $val['recid']; ?>" class="form-control areaName">
									 <input type="hidden" id="add_edit" name="add_edit[<?php echo $key+1; ?>]" value="add_edit" class="form-control ">
									<?php }?>
									</td>
									<td>
									<select class="form-control village "   id="village" name="area_name[<?php echo $key+1; ?>]" class="form-control areaName" >
									<?php echo getVillage_options(false,$val['area_name'],$val['uncode']); ?>
								    </select>
									<!--<input type="text" name="area_name[1]" class="form-control areaName" required="required">-->
									</td>
									<td><input type="text" readonly value="<?php echo $val['less_one_year']; ?>" id="population_less_year[1]"  name="less_one_year[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation  less_one_year">
									    <input type="hidden"  value="<?php echo $val['f3_total_population']; ?>" id="f3_total_population[1]"  name="f3_total_population[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation f3_total_population">
									</td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['penta1']; }else { echo '';} ?>" name="penta1[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation penta1"></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['penta3']; }else { echo '';} ?>" name="penta3[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation penta3 try prt"></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['measles']; }else { echo '';}  ?>" name="measles[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation measles  prt"></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['tt2']; }else { echo '';} ?>" name="tt2[<?php echo $key+1; ?>]" class="form-control text-center numberclass calculation tt2"></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['penta1_percent']; }else { echo '';} ?>" name="penta1_percent[<?php echo $key+1; ?>]" class="form-control numberclass text-center calculation penta1_percent" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['penta3_percent']; }else { echo '';} ?>" name="penta3_percent[<?php echo $key+1; ?>]" class="form-control numberclass text-center calculation penta3_percent" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['measles_percent']; }else { echo '';} ?>" name="measles_percent[<?php echo $key+1; ?>]" class="form-control numberclass text-center calculation measles_percent" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['tt2_percent']; }else { echo '';} ?>" name="tt2_percent[<?php echo $key+1; ?>]" class="form-control numberclass text-center calculation tt2_percent" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['penta3_not']; }else { echo '';} ?>" name="penta3_not[<?php echo $key+1; ?>]" class="form-control  numberclass text-center calculation penta3_not" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['measles_not']; }else { echo '';} ?>" name="measles_not[<?php echo $key+1; ?>]" class="form-control numberclass text-center calculation measles_not" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['penta1penta3']; }else { echo '';} ?>" name="penta1penta3[<?php echo $key+1; ?>]" class="form-control numberclass text-center calculation penta1penta3" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['penta1measles']; }else { echo '';} ?>" name="penta1measles[<?php echo $key+1; ?>]" class="form-control numberclass text-center calculation penta1measles" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['access']; }else { echo '';} ?>" name="access[<?php echo $key+1; ?>]" class="form-control numberclass text-center access" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['utilization']; }else { echo '';} ?>" name="utilization[<?php echo $key+1; ?>]" class="form-control numberclass text-center utilization" readonly></td>
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['category']; }else { echo '';} ?>" name="category[<?php echo $key+1; ?>]" class="form-control numberclass text-center category" readonly></td>									
									<td><input type="text" value="<?php if ($data != 'undefined'){ echo $val['priority']; }else { echo '';} ?>" name="priority[<?php echo $key+1; ?>]" class="form-control numberclass text-center priority" readonly></td>		
									<td>
										<?php 
                                         if($rowcount > $i)
                                       { ?>
								   
								    <button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
									   <?php }else{ ?>
										
										 <button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
									   <?php }?>
									</td>
								</tr>
										 <?php $i++;   }
										         }  ?>			
							</tbody>
							
						</table>
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url();?>red_rec_microplan/Situation_analysis/situation_analysis_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>
								<button type="reset" class="form-btn"><i class="fa fa-recycle" aria-hidden="true"></i> Reset Form</button>								
								<button type="submit" name="submit" value="submit" id="close" class="form-btn clos"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save and Close </button>								
								<button type="submit" name="submit" value="submit" id="next" class="form-btn next "><i class="fa fa-floppy-o" aria-hidden="true"></i> Save and Next </button>
						   	</div>
						</div>				
					</div> <!--end of panel body-->				
				</form>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->
<script type="text/javascript">
   function addRow(obj){
		var row = $(obj).closest("tr").clone(true);
		row.find('input').val('');
		/* var lastRowIndex = $('#trRow').find('tr:last').index();
		console.log(row);
		var currentIndex = lastRowIndex+1; */
		//row.find("td:nth-child(1)").find('label').attr('name','lb['+currentIndex+']');
		row.find("td:nth-child(1)").find('label').val('');
        row.find("td:nth-child(1)").find('input').val('0');
		//row.find("td:nth-child(2)").find('select').attr('name','area_name['+currentIndex+']');
		row.find("td:nth-child(2)").find('select').val('');
		//row.find("td:nth-child(3)").find('input').attr('name','less_one_year['+currentIndex+']');
		//row.find("td:nth-child(3)").find('input').attr('id','population_less_year['+currentIndex+']');
		row.find("td:nth-child(3)").find('input').val('');
		//row.find("td:nth-child(4)").find('input').attr('name','penta1['+currentIndex+']');
		row.find("td:nth-child(4)").find('input').val('');
		//row.find("td:nth-child(5)").find('input').attr('name','penta3['+currentIndex+']');
		row.find("td:nth-child(5)").find('input').val('');
		//row.find("td:nth-child(6)").find('input').attr('name','measles['+currentIndex+']');
		row.find("td:nth-child(6)").find('input').val('');
		//row.find("td:nth-child(7)").find('input').attr('name','tt2['+currentIndex+']');
		row.find("td:nth-child(7)").find('input').val('');
		//row.find("td:nth-child(8)").find('input').attr('name','penta1_percent['+currentIndex+']');
		row.find("td:nth-child(8)").find('input').val('');
	    //row.find("td:nth-child(9)").find('input').attr('name','penta3_percent['+currentIndex+']');
		row.find("td:nth-child(9)").find('input').val('');
		//row.find("td:nth-child(10)").find('input').attr('name','measles_percent['+currentIndex+']');
		row.find("td:nth-child(10)").find('input').val('');
		//row.find("td:nth-child(11)").find('input').attr('name','tt2_percent['+currentIndex+']');
		row.find("td:nth-child(11)").find('input').val('');
		//row.find("td:nth-child(12)").find('input').attr('name','penta3_not['+currentIndex+']');
		row.find("td:nth-child(12)").find('input').val('');
		//row.find("td:nth-child(13)").find('input').attr('name','measles_not['+currentIndex+']');
		row.find("td:nth-child(13)").find('input').val('');
		//row.find("td:nth-child(14)").find('input').attr('name','penta1penta3['+currentIndex+']');
		row.find("td:nth-child(14)").find('input').val('');
		//row.find("td:nth-child(15)").find('input').attr('name','penta1measles['+currentIndex+']');
		row.find("td:nth-child(15)").find('input').val('');
		//row.find("td:nth-child(16)").find('input').attr('name','access['+currentIndex+']');
		row.find("td:nth-child(16)").find('input').val('');
		//row.find("td:nth-child(17)").find('input').attr('name','utilization['+currentIndex+']');
		row.find("td:nth-child(17)").find('input').val('');
		//row.find("td:nth-child(18)").find('input').attr('name','category['+currentIndex+']');
		row.find("td:nth-child(18)").find('input').val('');
		//row.find("td:nth-child(19)").find('input').attr('name','priority['+currentIndex+']');
		row.find("td:nth-child(19)").find('input').val('');					
		$(obj).closest("tr").after(row);//alert(row.index());
  $(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>');
  $('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		reindex_serialnumber_and_trainingCompleted();
		getPriority();			
	}
    function deleteRow(obj)
	{
		/*$(".village").each(function(index,elm)
		{
			$(this).not($currentSelected).find("option[value='"+$selectedValue+"']").remove();
		});*/
		/*var s = $("#village").val();
		//alert(s);
		$(".village").append('<option value='+s+'>'+s+'</option>');*/

		  var index = $('#trRow').find('tr:last').index();
		  $(obj).closest("tr").remove();
			if(index=='2'){
				$('#trRow').find('tr:last').find('td:last').html('<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}else{
				$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}
		  reindex_serialnumber_and_trainingCompleted();
		  getPriority();
	}
    function reindex_serialnumber_and_trainingCompleted(){
		$('#trRow > tr').each(function(i,k){
		
			$(this).find("td:nth-child(1)").find('label').attr('name','lb['+i+']');
			$(this).find("td:nth-child(1)").find('input[id=recid]').attr('name','recid['+i+']');
			$(this).find("td:nth-child(1)").find('input[id=add_edit]').attr('name','add_edit['+i+']');
			$(this).find("td:nth-child(1)").find('label').text(parseInt(i));
			$(this).find("td:nth-child(2)").find('select').attr('name','area_name['+i+']');
			$(this).find("td:nth-child(3)").find('input[type=text]').attr('name','less_one_year['+i+']');
			$(this).find("td:nth-child(3)").find('input[type=text]').attr('id','population_less_year['+i+']');
			$(this).find("td:nth-child(3)").find('input[type=hidden]').attr('name','f3_total_population['+i+']');
			$(this).find("td:nth-child(3)").find('input[type=hidden]').attr('id','f3_total_population['+i+']');
			$(this).find("td:nth-child(4)").find('input').attr('name','penta1['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','penta3['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('name','measles['+i+']');
			$(this).find("td:nth-child(7)").find('input').attr('name','tt2['+i+']');
			$(this).find("td:nth-child(8)").find('input').attr('name','penta1_percent['+i+']');
			$(this).find("td:nth-child(9)").find('input').attr('name','penta3_percent['+i+']');
			$(this).find("td:nth-child(10)").find('input').attr('name','measles_percent['+i+']');
			$(this).find("td:nth-child(11)").find('input').attr('name','tt2_percent['+i+']');
			$(this).find("td:nth-child(12)").find('input').attr('name','penta3_not['+i+']');
			$(this).find("td:nth-child(13)").find('input').attr('name','measles_not['+i+']');
			$(this).find("td:nth-child(14)").find('input').attr('name','penta1penta3['+i+']');
			$(this).find("td:nth-child(15)").find('input').attr('name','penta1measles['+i+']');
			$(this).find("td:nth-child(16)").find('input').attr('name','access['+i+']');
			$(this).find("td:nth-child(17)").find('input').attr('name','utilization['+i+']');
			$(this).find("td:nth-child(18)").find('input').attr('name','category['+i+']');
			$(this).find("td:nth-child(19)").find('input').attr('name','priority['+i+']');				
			//$(this).find("td:nth-child(10)").find('input').attr('name','total_m_f['+i+']');
		});
		
	}
	$(document).ready(function(){
		

		$(function () {
				var x;
				$( ".clos" ).click(function(e) {
					var save_next    = document.getElementById("close").value = "sclose";
					var technician    = $("#technician").val();
					var village    = $("#village").val(); 
					var penta1    = $("#penta1").val(); 
					var penta3    = $("#penta3").val(); 
					var measles    = $("#measles").val(); 
					var tt2    = $("#tt2").val(); 
					if(technician == ""){
						
						alert("Select Technician !");
						$("#technician").css("background-color","#FF0000");
						//window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/situation_main";
					}else{$("#technician").css("background-color","#FFF");}
					if(village == ""){
						
						alert("Select Area Name !");
						$("#village").css("background-color","#FF0000");
						//window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/situation_main";
					}else{$("#village").css("background-color","#FFF");}
					if(penta1 == "" || penta3 == "" || measles == "" || tt2 == "" ){
						
						alert("fill all fields !");
						return false;
						//window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/situation_main";
					}	
					//alert(save_next);
					e.preventDefault();
					$.ajax({
						type: 'post',
						url: "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/situation_analysis_save",
						data: $('form').serialize(),
						success: function (data) {
									 if(data == "yes"){
										alert("Cannot save data because data already exists for this Technician and Year!")
										window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
									}            	        
								   else{ 
									   if(save_next == "sclose" ) { 
										   window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
										}
								}									
						}
					});
				});
		});
	  $(function () {
		function formcheck() {
			var fields = $(".ss-item-required")
				.find("select, textarea, input").serializeArray();	  
			$.each(fields, function(i, field) {
				if (!field.value)
					alert(field.name + ' is required');
			}); 
				console.log(fields);
		}
			var x;
			$( ".next" ).click(function(e) {
			var save_next    = document.getElementById("next").value = "snext";
			var technician    = $("#technician").val();
			var Village    = $("#village").val(); 
			var Penta1    = $("#penta1").val(); 
			var Penta3    = $("#penta3").val(); 
			var Measles    = $("#measles").val(); 
			var TT2    = $("#tt2").val(); 
			if(technician == ""){
				
				alert("Select Technician !");
				$("#technician").css("background-color","#FF0000");
				//window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/situation_main";
			}else{
				$("#technician").css("background-color","#FFF");
				}
            if(Village == "" ){
				alert("Select Area Name !");
				$("#village").css("background-color","#FF0000");
				//window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/situation_main";
			}else{
				//alert("have vlaue");
				$("#village").css("background-color","#FFF");
				}
			 if(Penta1 == "" || Penta3 == "" || Measles == "" || TT2 == "" ){
				
				alert("fill all fields !");
				return false;
				//window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/situation_main";
			} 
								
			
			e.preventDefault();
			$.ajax({
            type: 'post',
             url: "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/situation_analysis_save",
            data: $('form').serialize(),
            success: function (data) {
                         if(data == "yes"){
							alert("Cannot save data because data already exists for this Technician and Year!")
							window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
						}            	        
                       else{ 
						   if(save_next == "snext" ){
							   x = data;
							 $( "#b").trigger( "click", [x] );
						   }
					   }						   
						
            }
          });
        });
      });
	  ////////////////for select area name////////////////////
		 $(document).on('keyup','.calculation',function(e){
		  
			var loy = $(this).closest('tr').find(".less_one_year").val();
				if(loy == ""){
				    alert("Select Area Name !");
					$(this).closest('tr').find(".village").css("background-color","#FF0000");
				}else{
					$(this).closest('tr').find(".village").css("background-color","#FFF");
				}
		}); 
	  //////////////////////////////////////////
////////////////////on change village get target //////////////////////////
$('.village').on('change' , function (){
	var vcode = this.value;
	var year = $('#year').val();
	var selectedobj = $(this);
	if(vcode =="") {
		 	$(selectedobj).closest("tr").find("td:nth-child(3)").find('input[type=text]').val('');
			$(selectedobj).closest("tr").find("td:nth-child(3)").find('input[type=hidden]').val('');
		}
     if(vcode != 0){
	$.ajax({
			type: "POST",
			data: "vcode="+vcode+"&year="+year,
			url: "<?php echo base_url(); ?>Ajax_calls/getTargetPopulation",
			success: function(result){
				var result1= JSON.parse(result);
				if(result1 != null)
				{
					var population_less_year = result1.population_less_year;
					var f3_total_population = result1.population;
					var population1 =(0.0353*f3_total_population);
					population1 =Math.ceil(0.942*population1);
					$(selectedobj).closest("tr").find("td:nth-child(3)").find('input[type=text]').val(population1);
					$(selectedobj).closest("tr").find("td:nth-child(3)").find('input[type=hidden]').val(f3_total_population);
					$(selectedobj).closest("tr").find("td:nth-child(2)").find('select').css("background-color","#FFF");
					//$(this).closest('tr').find(".village").css("background-color","#FFF");
					if(population_less_year !=""){
						$('.calculation').trigger('keyup');
					}
				}else{
					alert('Add Population');
				}	
				
			}
			
		}); 
	
	}
	
	});
////////////////////on change village get target end //////////////////////////	
		$(document).on('keyup','.calculation',function(e){			
			//Percentage Calculations............ columns g,h,i j //	
			//alert($(this).closest('tr').find(".less_one_year").val());
			
			var g = Math.round((parseFloat($(this).closest('tr').find(".penta1").val())/parseFloat($(this).closest('tr').find(".less_one_year").val()))*100);		
			if( ! isNaN(g)){
				//alert(g);
			   $(this).closest('tr').find(".penta1_percent").val(g);
			   if(g >= 80){
			   	$(this).closest('tr').find(".access").val('Good');
			   }
			   else{
			   	$(this).closest('tr').find(".access").val('Poor');	
			   }
			}
			else{
				$(this).closest('tr').find(".penta1_percent").val(0);
			}

			var h = Math.round((parseFloat($(this).closest('tr').find(".penta3").val())/parseFloat($(this).closest('tr').find(".less_one_year").val()))*100);
			if( ! isNaN(h)){
				$(this).closest('tr').find(".penta3_percent").val(h);
			}
			else{
				$(this).closest('tr').find(".penta3_percent").val(0);
			}

			var i = Math.round((parseFloat($(this).closest('tr').find(".measles").val())/parseFloat($(this).closest('tr').find(".less_one_year").val()))*100);
			if( ! isNaN(i)){
				$(this).closest('tr').find(".measles_percent").val(i);
			}
			else{
				$(this).closest('tr').find(".measles_percent").val(0);
			}

			var j = Math.round((parseFloat($(this).closest('tr').find(".tt2").val())/parseFloat($(this).closest('tr').find(".less_one_year").val()))*100);
			if( ! isNaN(j)){
				$(this).closest('tr').find(".tt2_percent").val(j);
			}
			else{
				$(this).closest('tr').find(".tt2_percent").val(0);
			}

			//Subtractions.............. columns k,l //
			var k = parseInt($(this).closest('tr').find(".less_one_year").val())-parseInt($(this).closest('tr').find(".penta3").val());
			if( ! isNaN(k)){
				$(this).closest('tr').find(".penta3_not").val(k);
			}
			else{
				$(this).closest('tr').find(".penta3_not").val(0);
			}

			var l = parseInt($(this).closest('tr').find(".less_one_year").val())-parseInt($(this).closest('tr').find(".measles").val());
			if( ! isNaN(l)){
				$(this).closest('tr').find(".measles_not").val(l);
			}
			else{
				$(this).closest('tr').find(".measles_not").val(0);
			}

			//Percentage and Subtractions.............. columns m,n //
			var m = Math.round(((parseFloat($(this).closest('tr').find(".penta1").val())-parseFloat($(this).closest('tr').find(".penta3").val()))/(parseFloat($(this).closest('tr').find(".penta1").val())))*100);
			if( ! isNaN(m)){
				$(this).closest('tr').find(".penta1penta3").val(m);
				if(m < 10){
			   	$(this).closest('tr').find(".utilization").val('Good');
			   }
			   else{
			   	$(this).closest('tr').find(".utilization").val('Poor');	
			   }
			}
			else{
				$(this).closest('tr').find(".penta1penta3").val(0);
			}

			var n = Math.round(((parseFloat($(this).closest('tr').find(".penta1").val())-parseFloat($(this).closest('tr').find(".measles").val()))/(parseFloat($(this).closest('tr').find(".penta1").val())))*100);
			if( ! isNaN(n)){
				$(this).closest('tr').find(".penta1measles").val(n);
			}
			else{
				$(this).closest('tr').find(".penta1measles").val(0);
			}
			//Good and Poor and Category (1,2,3,4).............. columns o,p,q //
			var access = $(this).closest('tr').find(".access").val();
			var utilization = $(this).closest('tr').find(".utilization").val();			
			if(access == 'Good' && utilization == 'Good'){
		   	$(this).closest('tr').find(".category").val(1);
		   }
		   else if(access == 'Good' && utilization == 'Poor'){
		   	$(this).closest('tr').find(".category").val(2);
		   }
		   else if(access == 'Poor' && utilization == 'Good'){
		   	$(this).closest('tr').find(".category").val(3);
		   }
		   else if(access == 'Poor' && utilization == 'Poor'){
		   	$(this).closest('tr').find(".category").val(4);
		   }
		});
		$(document).on('keyup','.prt', function(){
			getPriority();
		});
	});
	// $(document).on('keyup','.prt',function(){
	// 	var $currentRowIndex = $(this).closest('tr').index();
	// 	var $row = $(this).closest('tr');
	// 	var $k = $row.find('.penta3_not').val();
	// 	var $l = $row.find('.measles_not').val();
	// 	var $d = $row.find('.penta3').val();
	// 	var $sumKL = $row.find()
	// });
	////////////////get priority add/////////////////////
	function getPriority(){
		var KL = [];
		var duplicate = [];
		var name = $(this).closest('tr').find(".srno-lbl").val();  	
		$(".srno-lbl").each(function() { 
			var index = $(this).closest("tr").index();
			var g = parseInt($(this).closest('tr').find(".penta1_percent").val());
			var d = parseInt($(this).closest('tr').find(".penta3").val());
			var k = parseInt($(this).closest('tr').find(".penta3_not").val());
			var l = parseInt($(this).closest('tr').find(".measles_not").val());
			if(l < 0){
				measles_unimmunized= 0;
			}else{
				measles_unimmunized= l;
			}
			if(k < 0){
				penta3_unimmunized= 0;
			}else{
				penta3_unimmunized= k;
			}
			var value = parseInt(penta3_unimmunized)+parseInt(measles_unimmunized);
			var newarr = [index,value,g];
			KL.push(newarr);
			
		});
		KL.sort(function(a, b){
			return (b[1]==a[1])?(a[2] - b[2]):(b[1] - a[1]);
		});
		var index, entry;
		for(index = 0; index < KL.length; ++index) {
			entry = KL[index];
			ranknum = index+1;
			rownum = entry[0]+1;
			$("#trRow").find("tr:nth-child("+rownum+")").find("td:nth-child(19)").find('input').val(ranknum);
		}
	}
		/////////////////////////////////
		////////randum try ////////priority///////////////////
	$(document).ready(function(){
		$(document).on('change','.try',function(){				
			var d = parseInt($(this).closest('tr').find(".penta3").val());
			//var e = parseInt($(this).closest('tr').find(".measles").val());	
			if(d == d){
				//alert('Year');	
				}	
				else{		
				//alert('month');
				}				

		});
	});
		/////////////////////////////////
	
	$(document).on('change','#ticode', function(){
		var tcode = this.value;
	
		//to get ucs of selected district
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
					$('#faicode').html(result);
				}
			});
		}
		else{
			$('#unicode').html('');
			$('#faicode').html('');
			//it doesn't exist
		}								
	});
	$(document).on('change','#unicode', function(){
		
		var uncode = this.value;
		//to get facilities of selected UC
		if(uncode =="") {
		 	$('#faicode').html('');
		 	//it doesn't exist
		}
		else{
			$.ajax({
				type: "POST",
				data: "uncode="+uncode,
				url: "<?php echo base_url(); ?>Ajax_red_rec/getFacilities",
				success: function(result){
					$('#faicode').html(result);
				}
			});
		}
	});
	$('#unicode').on('change' , function (){
			var uncode = this.value;
				  
		$.ajax({
			type: "POST",
			data: "uncode="+uncode,
			url: "<?php echo base_url(); ?>Ajax_calls/getVillages",
			success: function(result){
				//console.log(result)
			  $('.village').html(result);
			}
		});
	});
	
	function uncodevi ()
	{
		var uncode = $("#unicode").val();
		{
			$.ajax({
			type: "POST",
			data: "uncode="+uncode,
			url: "<?php echo base_url(); ?>Ajax_calls/getVillages",
			success: function(result){
				//console.log(result)
			  $('.village').html(result);
			}
		});
			
		}
	}
	/*$(".village").change(function() {
        var status = $(this).val();*/
               
    
	$(document).on('click','.minus', function()
   		{ 	
   			//alert("xxx");
   		//alert(status);
		var currentRow=$(this).closest("tr");
		var text=currentRow.find("td:eq(1)").find('.village option:selected' ).text();
		var value=currentRow.find("td:eq(1)").find('.village option:selected' ).val();
		//alert(value);
		//alert(text);
		if (text=='--Select--'&& value==value) {}
			else{
				$(".village").append('<option value=' + value + '>' + text + '</option>');
			}				
    }); //});
	$(document).on('change','.village', function()
	{
		$currentSelected = $(this);		
		$selectedValue = $(this).val();
		$(".village").each(function(index,elm)
		{
			$(this).not($currentSelected).find("option[value='"+$selectedValue+"']").remove();
		});
	});

	$(document).on('change','#faicode', function(){
		 var facode = this.value;
		//to get facilities of selected UC
		if(facode =="") {
		 	$('#faicode').html('');
		 	//it doesn't exist
		}
		else{
			$.ajax({
				type: "POST",
				data: "facode="+facode,
				url: "<?php echo base_url(); ?>Ajax_red_rec/getTechnicians",
				success: function(result){
					$('#technician').html(result);
				}
			});
		} 
	});
	$(document).on("keydown",".numberclass",function(e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || // Allow: Ctrl+A, Command+A
			(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
				$(this).val('0');
				$(this).select();
			}
		});
		/*  $(document).ready(function () {

    $('#myform').validate({ // initialize the plugin
        rules: {
            penta1: {
                required: true
            },
            penta3: {
                required: true
            }
        },
        submitHandler: function (form) { // for demo
            alert('valid form submitted'); // for demo
            return false; // for demo
        }
    });

});  */

	
</script>	