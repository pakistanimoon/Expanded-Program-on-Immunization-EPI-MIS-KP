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
					Situation Analysis <span class="urdu" style="font-size:12px; font-weight:400;"> (حفاظتى ٹیکہ جات کے اعدادوشمار کا تجزیہ)</span>
				</div>
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Situation Analysis Update Form</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Situation_analysis/situation_analysis_save">
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
									<th rowspan="3" style="border-left-color:black;">Sr. No</th>
									<th rowspan="3" style="border-left-color:black;">Area Name</th>
									<th colspan="9">Compile population, <br>imunization coverage data in the previous 12 months <br><span class="urdu">پچهلے بارہ ماہ کے اعداد و شمار</span></th>
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
								<?php 
									$i=1;
									$rowcount=count($data);
									foreach($data as $key=>$val) {
								?>				
								<tr>
									<td>
									    <input type="hidden" name="recid[<?php echo $key+1; ?>]" value="<?php echo $val['recid']; ?>" class="form-control sr-recid">
										<label class="srno-lbl"  ><?php echo $i; ?></label>
									</td>                                        
									<td><input type="text" name="area_name[<?php echo $key+1; ?>]" value="<?php echo $val['area_name']; ?>" class="form-control areaName" required></td>
									<td><input type="text" name="less_one_year[<?php echo $key+1; ?>]" value="<?php echo $val['less_one_year']; ?>" class="form-control text-center numberclass calculation less_one_year"></td>
									<td><input type="text" name="penta1[<?php echo $key+1; ?>]" value="<?php echo $val['penta1']; ?>" class="form-control text-center numberclass calculation penta1"></td>
									<td><input type="text" name="penta3[<?php echo $key+1; ?>]" value="<?php echo $val['penta3']; ?>" class="form-control text-center numberclass calculation penta3 prt"></td>
									<td><input type="text" name="measles[<?php echo $key+1; ?>]" value="<?php echo $val['measles']; ?>" class="form-control text-center numberclass calculation measles prt"></td>
									<td><input type="text" name="tt2[<?php echo $key+1; ?>]" value="<?php echo $val['tt2']; ?>" class="form-control text-center numberclass calculation tt2"></td>
									<td><input type="text" name="penta1_percent[<?php echo $key+1; ?>]" value="<?php echo $val['penta1_percent']; ?>" class="form-control text-center calculation penta1_percent" readonly></td>
									<td><input type="text" name="penta3_percent[<?php echo $key+1; ?>]" value="<?php echo $val['penta3_percent']; ?>" class="form-control text-center calculation penta3_percent" readonly></td>
									<td><input type="text" name="measles_percent[<?php echo $key+1; ?>]" value="<?php echo $val['measles_percent']; ?>" class="form-control text-center calculation measles_percent" readonly></td>
									<td><input type="text" name="tt2_percent[<?php echo $key+1; ?>]" value="<?php echo $val['tt2_percent']; ?>" class="form-control text-center calculation tt2_percent" readonly></td>
									<td><input type="text" name="penta3_not[<?php echo $key+1; ?>]" value="<?php echo $val['penta3_not']; ?>" class="form-control text-center calculation penta3_not" readonly></td>
									<td><input type="text" name="measles_not[<?php echo $key+1; ?>]" value="<?php echo $val['measles_not']; ?>" class="form-control text-center calculation measles_not" readonly></td>
									<td><input type="text" name="penta1penta3[<?php echo $key+1; ?>]" value="<?php echo $val['penta1penta3']; ?>" class="form-control text-center calculation penta1penta3" readonly></td>
									<td><input type="text" name="penta1measles[<?php echo $key+1; ?>]" value="<?php echo $val['penta1measles']; ?>" class="form-control text-center calculation penta1measles" readonly></td>
									<td><input type="text" name="access[<?php echo $key+1; ?>]" value="<?php echo $val['access']; ?>" class="form-control text-center access" readonly></td>
									<td><input type="text" name="utilization[<?php echo $key+1; ?>]" value="<?php echo $val['utilization']; ?>" class="form-control text-center utilization" readonly></td>
									<td><input type="text" name="category[<?php echo $key+1; ?>]" value="<?php echo $val['category']; ?>" class="form-control text-center category" readonly></td>									
									<td><input type="text" name="priority[<?php echo $key+1; ?>]" value="<?php echo $val['priority']; ?>" class="form-control text-center priority" readonly></td>		
									<td>
									<?php 
										if($rowcount > $i)
										{ ?>
										<button onclick="deleteRow(this)" class="minus" type="button"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
										<?php } else { ?>
										<button onclick="addRow(this)" class="plus" type="button" id="addButton1" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
									<?php } ?>
									</td>
								</tr>
								<?php $i++; } ?>
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
		//alert(lastRowIndex);
		row.find("td:nth-child(1)").find('label').attr('name','lb[]');
		row.find("td:nth-child(1)").find('label').val('');
		row.find("td:nth-child(1)").find('input').attr('name','recid[]');
		row.find("td:nth-child(1)").find('input').val('0');
		row.find("td:nth-child(2)").find('input').attr('name','area_name[]');
		row.find("td:nth-child(2)").find('input').val('');
		row.find("td:nth-child(3)").find('input').attr('name','less_one_year[]');
		row.find("td:nth-child(3)").find('input').val('');
		row.find("td:nth-child(4)").find('input').attr('name','penta1[]');
		row.find("td:nth-child(4)").find('input').val('');
		row.find("td:nth-child(5)").find('input').attr('name','penta3[]');
		row.find("td:nth-child(5)").find('input').val('');
		row.find("td:nth-child(6)").find('input').attr('name','measles[]');
		row.find("td:nth-child(6)").find('input').val('');
		row.find("td:nth-child(7)").find('input').attr('name','tt2[]');
		row.find("td:nth-child(7)").find('input').val('');
		row.find("td:nth-child(8)").find('input').attr('name','penta1_percent[]');
		row.find("td:nth-child(8)").find('input').val('');
		row.find("td:nth-child(9)").find('input').attr('name','penta3_percent[]');
		row.find("td:nth-child(9)").find('input').val('');
		row.find("td:nth-child(10)").find('input').attr('name','measles_percent[]');
		row.find("td:nth-child(10)").find('input').val('');
		row.find("td:nth-child(11)").find('input').attr('name','tt2_percent[]');
		row.find("td:nth-child(11)").find('input').val('');
		row.find("td:nth-child(12)").find('input').attr('name','penta3_not[]');
		row.find("td:nth-child(12)").find('input').val('');
		row.find("td:nth-child(13)").find('input').attr('name','measles_not[]');
		row.find("td:nth-child(13)").find('input').val('');
		row.find("td:nth-child(14)").find('input').attr('name','penta1penta3[]');
		row.find("td:nth-child(14)").find('input').val('');
		row.find("td:nth-child(15)").find('input').attr('name','penta1measles[]');
		row.find("td:nth-child(15)").find('input').val('');
		row.find("td:nth-child(16)").find('input').attr('name','access[]');
		row.find("td:nth-child(16)").find('input').val('');
		row.find("td:nth-child(17)").find('input').attr('name','utilization[]');
		row.find("td:nth-child(17)").find('input').val('');
		row.find("td:nth-child(18)").find('input').attr('name','category[]');
		row.find("td:nth-child(18)").find('input').val('');
		row.find("td:nth-child(19)").find('input').attr('name','priority[]');
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
		/* $('.sr-recid').each(function(i,v){
			var id = $(this).text(parseInt(i)+1);
			$(this).closest('tr').find(".input").attr('name','recid['+id+']');	
			
		}); */
		
	}
	$(document).ready(function(){
		$(document).on('keyup','.calculation',function(e){
			//Percentage Calculations............ columns g,h,i j //	
			var g = Math.round((parseFloat($(this).closest('tr').find(".penta1").val())/parseFloat($(this).closest('tr').find(".less_one_year").val()))*100);		
			if( ! isNaN(g)){
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

	function getPriority(){
		var KL = [];
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
	}

	$(document).on('change','#ticode', function(){
		var tcode = this.value;
		//to get ucs of selected distcrict
		if(tcode != 0) {
		  $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Ajax_red_rec/getUnC/"+tcode,
				success: function(result){
					$('#unicode').html(result);							
					//
					if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
					{
						$('#unicode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
					$('#unicode').trigger('change');
				}
			});
		}else{
			$('#unicode').html('');
			//it doesn't exist
		}
						
	});
	$(document).on('change','#unicode', function(){
		var uncode = this.value;
		//to get facilities of selected UC
		if(uncode =="") {
			$('#facode').html('');
		  	//it doesn't exist
		}else{
			$.ajax({
				type: "POST",
				data: "uncode="+uncode,
				url: "<?php echo base_url(); ?>Ajax_red_rec/getFacilities",
				success: function(result){
					$('#facode').html(result);
					set_hfcode();
				}
			});			
		}
	});

</script>	