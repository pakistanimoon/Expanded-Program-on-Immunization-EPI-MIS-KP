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
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Situation_analysis/situation_analysis_save">
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
					</div>
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
									<th rowspan="3"  style="border-right-color:black;">Action</th>
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
									<td></td>
								</tr>
								<tr>		
									<td><label class="srno-lbl" name="lb[1]" >1</label></td>
									<td><input type="text" name="area_name[1]" class="form-control areaName" required="required"></td>
									<td><input type="text" name="less_one_year[1]" class="form-control text-center numberclass calculation less_one_year"></td>
									<td><input type="text" name="penta1[1]" class="form-control text-center numberclass calculation penta1"></td>
									<td><input type="text" name="penta3[1]" class="form-control text-center numberclass calculation penta3 try prt"></td>
									<td><input type="text" name="measles[1]" class="form-control text-center numberclass calculation measles  prt"></td>
									<td><input type="text" name="tt2[1]" class="form-control text-center numberclass calculation tt2"></td>
									<td><input type="text" name="penta1_percent[1]" class="form-control text-center calculation penta1_percent" readonly></td>
									<td><input type="text" name="penta3_percent[1]" class="form-control text-center calculation penta3_percent" readonly></td>
									<td><input type="text" name="measles_percent[1]" class="form-control text-center calculation measles_percent" readonly></td>
									<td><input type="text" name="tt2_percent[1]" class="form-control text-center calculation tt2_percent" readonly></td>
									<td><input type="text" name="penta3_not[1]" class="form-control text-center calculation penta3_not" readonly></td>
									<td><input type="text" name="measles_not[1]" class="form-control text-center calculation measles_not" readonly></td>
									<td><input type="text" name="penta1penta3[1]" class="form-control text-center calculation penta1penta3" readonly></td>
									<td><input type="text" name="penta1measles[1]" class="form-control text-center calculation penta1measles" readonly></td>
									<td><input type="text" name="access[1]" class="form-control text-center access" readonly></td>
									<td><input type="text" name="utilization[1]" class="form-control text-center utilization" readonly></td>
									<td><input type="text" name="category[1]" class="form-control text-center category" readonly></td>									
									<td><input type="text" name="priority[1]" class="form-control text-center priority" readonly></td>		
									<td>
										<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url();?>red_microplan/Situation_analysis/situation_analysis_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>
								<button type="reset" class="form-btn"><i class="fa fa-recycle" aria-hidden="true"></i> Reset Form</button>								
								<button type="submit" class="form-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit Form</button>								
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
		var lastRowIndex = $('#trRow').find('tr:last').index();
		console.log(row);
		var currentIndex = lastRowIndex+1;
		row.find("td:nth-child(1)").find('label').attr('name','lb['+currentIndex+']');
		row.find("td:nth-child(1)").find('label').val('');
		row.find("td:nth-child(2)").find('input').attr('name','area_name['+currentIndex+']');
		row.find("td:nth-child(2)").find('input').val('');
		row.find("td:nth-child(3)").find('input').attr('name','less_one_year['+currentIndex+']');
		row.find("td:nth-child(3)").find('input').val('');
		row.find("td:nth-child(4)").find('input').attr('name','penta1['+currentIndex+']');
		row.find("td:nth-child(4)").find('input').val('');
		row.find("td:nth-child(5)").find('input').attr('name','penta3['+currentIndex+']');
		row.find("td:nth-child(5)").find('input').val('');
		row.find("td:nth-child(6)").find('input').attr('name','measles['+currentIndex+']');
		row.find("td:nth-child(6)").find('input').val('');
		row.find("td:nth-child(7)").find('input').attr('name','tt2['+currentIndex+']');
		row.find("td:nth-child(7)").find('input').val('');
		row.find("td:nth-child(8)").find('input').attr('name','penta1_percent['+currentIndex+']');
		row.find("td:nth-child(8)").find('input').val('');
		row.find("td:nth-child(9)").find('input').attr('name','penta3_percent['+currentIndex+']');
		row.find("td:nth-child(9)").find('input').val('');
		row.find("td:nth-child(10)").find('input').attr('name','measles_percent['+currentIndex+']');
		row.find("td:nth-child(10)").find('input').val('');
		row.find("td:nth-child(11)").find('input').attr('name','tt2_percent['+currentIndex+']');
		row.find("td:nth-child(11)").find('input').val('');
		row.find("td:nth-child(12)").find('input').attr('name','penta3_not['+currentIndex+']');
		row.find("td:nth-child(12)").find('input').val('');
		row.find("td:nth-child(13)").find('input').attr('name','measles_not['+currentIndex+']');
		row.find("td:nth-child(13)").find('input').val('');
		row.find("td:nth-child(14)").find('input').attr('name','penta1penta3['+currentIndex+']');
		row.find("td:nth-child(14)").find('input').val('');
		row.find("td:nth-child(15)").find('input').attr('name','penta1measles['+currentIndex+']');
		row.find("td:nth-child(15)").find('input').val('');
		row.find("td:nth-child(16)").find('input').attr('name','access['+currentIndex+']');
		row.find("td:nth-child(16)").find('input').val('');
		row.find("td:nth-child(17)").find('input').attr('name','utilization['+currentIndex+']');
		row.find("td:nth-child(17)").find('input').val('');
		row.find("td:nth-child(18)").find('input').attr('name','category['+currentIndex+']');
		row.find("td:nth-child(18)").find('input').val('');
		row.find("td:nth-child(19)").find('input').attr('name','priority['+currentIndex+']');
		row.find("td:nth-child(19)").find('input').val('');					
		$(obj).closest("tr").after(row);
		$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>');
		reindex_serialnumber_and_trainingCompleted();
		getPriority();			
	}
   function deleteRow(obj) {
		$(obj).closest("tr").remove();
		reindex_serialnumber_and_trainingCompleted();
		getPriority();	
	}
   function reindex_serialnumber_and_trainingCompleted(){
		$('.srno-lbl').each(function(i,v){
			$(this).text(parseInt(i)+1);
		});
	}
	$(document).ready(function(){
		$(document).on('keyup','.calculation',function(e){			
			//Percentage Calculations............ columns g,h,i j //	
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
	function getPriority(){
		var KL = [];
		var duplicate = [];
   	var name = $(this).closest('tr').find(".areaName").val();    	
   	$(".areaName").each(function() {
   		var index = $(this).closest("tr").index();
			var d = parseInt($(this).closest('tr').find(".penta3").val());
			var k = parseInt($(this).closest('tr').find(".penta3_not").val());
			var l = parseInt($(this).closest('tr').find(".measles_not").val());
			var value = parseInt(k)+parseInt(l);
			var newarr = [index,value];
			KL.push(newarr);
			//KL[value];									
		});           
				
		// var duplicate = [];
		// for (var i = 0; i < KL.length; i++) {
		// 	if (KL[i + 1] == KL[i]) {
		// 		duplicate.push(KL[i]);
		// 	}
		// }	
		// console.log(duplicate);


   	KL.sort(function(a, b) {
			return b[1] - a[1];
		});
		var index, entry;
		for(index = 0; index < KL.length; ++index) {
			entry = KL[index];
			//console.log(index + ": " + entry[0] + " - " + entry[1]);
			ranknum = index+1;
			rownum = entry[0]+1;
			//console.log(ranknum + ": " + rownum + " - " + entry[1]);
			$("#trRow").find("tr:nth-child("+rownum+")").find("td:nth-child(19)").find('input').val(ranknum);
		}
	}////////randum try ////////priority///////////////////
	$(document).ready(function(){
		$(document).on('change','.try',function(){				
			var d = parseInt($(this).closest('tr').find(".penta3").val());
			//var e = parseInt($(this).closest('tr').find(".measles").val());	
			if(d == d){
				alert('Year');	
				}	
				else{		
				alert('month');
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
</script>	