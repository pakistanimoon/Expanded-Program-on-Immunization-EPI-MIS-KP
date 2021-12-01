<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
?>
<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:17px;"> 
					Planning special activities for hard to reach and problem areas <br><span class="urdu" style="font-size:12px; font-weight:400;">پلان برائے مشکل گزار اور دور دراز علاقہ جات</span>
				</div>
				<form>
				<!-- 	<div class="row" style="width:100%; padding:4px 17px">
						<input type="hidden" name="submitted_date" id="submitted_date" value="<?php echo $current_date; ?>" class="form-control">					
						<div class="col-md-2 col-md-offset-1">
							<label>Tehsil:</label>
						</div>
						<div class="col-md-3">
							<input type="text" value="<?php echo $data[0]['tehsil']; ?>" class="form-control" readonly>
							<input type="hidden" name="tcode" value="<?php echo $data[0]['tcode']; ?>" class="form-control">							
						</div>
						<div class="col-md-2">
							<label>Union Council:</label>
						</div>
						<div class="col-md-3">
							<input type="text" value="<?php echo $data[0]['uc_name']; ?>" class="form-control" readonly>
							<input type="hidden" name="uncode" value="<?php echo $data[0]['uncode']; ?>" class="form-control">								
						</div>
					</div> -->
				<!-- 	<div class="row" style="width:100%; padding:4px 17px">						
						<div class="col-md-2 col-md-offset-1">
							<label>Health Facility:</label>
						</div>
						<div class="col-md-3">
							<input type="text" value="<?php echo $data[0]['facility']; ?>" class="form-control" readonly>
							<input type="hidden" name="facode" value="<?php echo $data[0]['facode']; ?>" class="form-control">
						</div>
						<div class="col-md-2">
							<label>Year:</label>
						</div>
						<div class="col-md-3">
							<input type="text" name="year" value="<?php echo $data[0]['year']; ?>" class="form-control area_name" readonly="readonly">							
						</div>
					</div> -->
					<div class="panel-body" style="padding-top:1px;">
						<table class="table table-bordered plan_table" >
							<thead>
								<tr>
									<th colspan="20" style="border-left-color:black; border-right-color:black;">Form 2</th>
								</tr>
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
									$rowcount=count($data);
									foreach($data as $key=>$val) {
								?>
								<tr>
								 	<td><input type="text" value="<?php echo get_Village_Name($val['area_name']); ?>" name="sp_area_name[<?php echo $key+1; ?>]" class="form-control area_name" readonly="readonly"></td>
									<td><input type="text" value="<?php echo $val['category']; ?>" name="category[<?php echo $key+1; ?>]" class="form-control text-center category" readonly="readonly"></td>                                   								   
									<input type="hidden" name="fk[<?php echo $key+1; ?>]" value="<?php echo $val['recid']; ?>">
									<input type="hidden" value="<?php echo $val['techniciancode']; ?>" name="techniciancode" id="techniciancodeh" class="form-control text-center category">
									<input type="hidden" value="<?php echo $val['year']; ?>" name="year" id="yearh" class="form-control text-center category" > 
									<input type="hidden" value="<?php echo $val['recid']; ?>" name="recid[<?php echo $key+1; ?>]" id="recidh" class="form-control text-center category" > 
									
								 	<td>
										<select class="form-control text-center htr" name="hard_to_reach[<?php echo $key+1; ?>]" required>
											<option value="">-- Select --</option>
											<option value="Yes">Yes</option>
											<option value="No">No</option>
										</select>
									</td>
									<td><input type="text" name="reached_last_year[<?php echo $key+1; ?>]" class="form-control  text-center numberclass" required></td>
									<td><input type="text" name="activities_improve_hf[<?php echo $key+1; ?>]" class="form-control"></td>
									<td><input type="text" name="activities_need_support[<?php echo $key+1; ?>]" class="form-control "></td>
									<td><input type="text" name="interventions_delivered[<?php echo $key+1; ?>]" class="form-control "></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-12">
								<!--<a href="<?php echo base_url();?>red_microplan/Special_activities/special_activities_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>-->
								<button type="reset" class="form-btn"><i class="fa fa-recycle" aria-hidden="true"></i> Reset Form</button>								
								<button type="submit" name="submit" value="submit" id="close" class="form-btn clos "><i class="fa fa-floppy-o" aria-hidden="true"></i> Save and Close </button>								
								<button type="submit" name="submit" value="submit" id="next" class="form-btn next "><i class="fa fa-floppy-o" aria-hidden="true"></i> Save and Next </button>
							</div>
						</div>	
					</div> <!--end of panel body-->
				</form>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->

	<script type="text/javascript">
		$(document).ready(function(){
			////////////////////
		$(function () {
				var x;
				$( ".clos" ).click(function(e) {
					var save_next    = document.getElementById("close").value = "sclose";
					//alert(save_next);
					e.preventDefault();
					$.ajax({
						type: 'post',
						 url: "<?php echo base_url(); ?>red_rec_microplan/Special_activities/special_activities_save",
						data: $('form').serialize(),
						success: function (data) {      	        
								   
										   window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
									
						}		
					});
				});
		});
	  $(function () {
			var x;
			$( ".next" ).click(function(e) {
			var save_next    = document.getElementById("next").value = "snext";
			var year = $('#yearh').val();
			var techniciancode = $('#techniciancode').val();
			e.preventDefault();
			$.ajax({
            type: 'post',
              url: "<?php echo base_url(); ?>red_rec_microplan/Special_activities/special_activities_save",
            data: $('form').serialize(),
            success: function (data) {
								
								//alert(data);
								if(data == "yes"){
							alert("Cannot save data because data already exists for this Technician and Year!")
							window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
						   }   
							   x = data;
							   //alert(x);
							 $( "#c").trigger( "click", [x] );
						   
            }
          });
        });
      });
	  
	
	   ////////////////////

	/* 	$(function () {
			var x;
        $('form').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'post',
             url: "<?php echo base_url(); ?>red_rec_microplan/Special_activities/special_activities_save",
            data: $('form').serialize(),
            success: function (data) {
            	         x = data;
            	        // console.log(x);
						 //$("b").html(x);

             // $('#b').trigger("click");
			  $( "#c").trigger( "click", [x] );
              //$(".b").html(x);              
            }
          });

        });

      });
	   */
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
	  
	  
	});
	
	
		// $(document).ready(function(){
		// 	$(document).on('change','#fyear', function(){
		// 		var year = this.value;
		// 		//to get facilities of selected UC
		// 		if(year =="") {
		// 		  	$('#facode').html('');				  	
		// 		  //it doesn't exist
		// 		}else{
		// 			$.ajax({
		// 				type: "POST",
		// 				data: "year="+year,
		// 				url: "<?php //echo base_url(); ?>Ajax_red_rec/getFacilitiesforForm2",
		// 				success: function(result){
		// 					$('#facode').html(result);						
		// 					set_hfcode();
		// 				}
		// 			});				
		// 		}
		// 	});

		// 	function getFacRecord(){
		// 		var year = $('#fyear').val();
		// 		var facode = $('#facode').val();
		// 		$.ajax({
		// 			type: "POST",				
		// 			data: {year:year,facode:facode},
		// 			dataTyp: 'JSON',
		// 			url: "<?php //echo base_url(); ?>Ajax_red_rec/getFacility_RecordForm2",
		// 			success: function(result){
		// 				var resultarray = JSON.parse(result);
		// 				//console.log("moon");
		// 				var htmll = '';						
		// 					htmll +='<tr>';
		// 					htmll +='<td>a</td>';
		// 					htmll +='<td>b</td>';
		// 					htmll +='<td>c</td>';
		// 					htmll +='<td>d</td>';
		// 					htmll +='<td>e</td>';
		// 					htmll +='<td>f</td>';
		// 					htmll +='<td>g</td>';
		// 					htmll +='</tr>'
		// 				for(var i = 0; i < resultarray.length; i++) {						  
		// 					$("#tcode").val(resultarray[i].tcode);
		// 					$("#th_name").val(resultarray[i].th_name);
		// 					$("#uncode").val(resultarray[i].uncode);
		// 					$("#uc_name").val(resultarray[i].uc_name);
		// 				  	htmll += '<tr>';
		// 				 	htmll += '<td><input type="text" value="'+resultarray[i].area_name+'" name="area_name['+i+']" class="form-control area_name" readonly="readonly"></td>';
		// 					htmll += '<td><input type="text" value="'+resultarray[i].category+'" name="category['+i+']" class="form-control text-center category" readonly="readonly"></td>';
		// 					htmll += '<td>';
		// 					htmll += '<select class="form-control text-center" name="hard_to_reach['+i+']" required="required">';
		// 						htmll += '<option value="0">-- Select --</option>';
		// 						htmll += '<option value="Yes">Yes</option>';
		// 						htmll += '<option value="No">No</option>';
		// 					htmll += '</select>';
		// 					htmll += '</td>';
		// 					htmll += '<td><input type="text" name="reached_last_year['+i+']" class="form-control text-center numberclass"></td>';
		// 					htmll += '<td><input type="text" name="activities_improve_hf['+i+']" class="form-control"></td>';
		// 					htmll += '<td><input type="text" name="activities_need_support['+i+']" class="form-control"></td>';
		// 					htmll += '<td><input type="text" name="interventions_delivered['+i+']" class="form-control"></td>';
		// 					htmll += '</tr>';
		// 				}
		// 				$("#tableplanbody").html(htmll);
		// 			}
		// 		});
		// 	}
		// 	$(document).on('change','#facode', function(){
		// 		getFacRecord();				
		// 	});
		// });
		
		
	</script>