<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
	///print_r($data);exit;
	
?>
<!-- <div class="content-wrapper"> -->
<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:15px;">
					Using the RED Strategy for Problem Solving edit <br><span class="urdu" style="font-size:12px; font-weight:400;">حفاظتى ٹىکہ جات کے مسائل کو حل کرنے کىلئے RED حکمت عملى کا استعمال</span>
				</div>
				<!--<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Red_strategy/red_strategy_save">-->
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

					</div>

					

					</div> -->
					
					<!-- <br> -->
					<form>
					<input type="hidden" name="edit" value="edit">
					<div class="panel-body" style="padding-top:1px;">
						<table class="table table-bordered plan_table" >
							<thead>
								<tr>
									<th colspan="20" style="border-left-color:black; border-right-color:black;">Form 4</th>
								</tr>
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
								//foreach($data as $key=>$val) {
								for($index=1;$index<=count($labels);$index++) { ?>
								<tr>
									<td><?php echo $labels[$index-1]; ?></td>
									<td><textarea type="text"  id="abc" value="<?php if ($data != 'undefined'){ echo $data[0]['f4_problems_r'.$index.'_c1']; }else { echo '';} ?>" name="problems_r<?php echo $index; ?>_c1" class="form-control" rows="3" cols="5"><?php if ($data != 'undefined'){ echo $data[0]['f4_problems_r'.$index.'_c1']; }else { echo '';} ?></textarea></td>
									<td><textarea type="text"  id="abc" value="<?php if ($data != 'undefined'){ echo $data[0]['f4_actlimitres_r'.$index.'_c2']; }else { echo '';} ?>" name="actlimitres_r<?php echo $index; ?>_c2" class="form-control" rows="3" cols="5"><?php if ($data != 'undefined'){ echo $data[0]['f4_actlimitres_r'.$index.'_c2']; }else { echo '';} ?></textarea></td>
									<td><textarea type="text"  id="abc" value="<?php if ($data != 'undefined'){ echo $data[0]['f4_actneedresources_r'.$index.'_c3']; }else { echo '';} ?>" name="actneedresources_r<?php echo $index; ?>_c3" class="form-control" rows="3" cols="5"><?php if ($data != 'undefined'){ echo $data[0]['f4_actneedresources_r'.$index.'_c3']; }else { echo '';} ?></textarea></td>
									<td><input type="text"  id="abc" value="<?php if ($data != 'undefined'){ echo $data[0]['f4_date_r'.$index.'_c4']; }else { echo '';} ?>" name="date_r<?php echo $index; ?>_c4" class="form-control text-center calendar" readonly ></td>
									<td><textarea type="text"  id="abc" value="<?php if ($data != 'undefined'){ echo $data[0]['f4_area_r'.$index.'_c5']; }else { echo '';} ?>" name="area_r<?php echo $index; ?>_c5" class="form-control" required rows="3" cols="5"><?php if ($data != 'undefined'){ echo $data[0]['f4_area_r'.$index.'_c5']; }else { echo '';} ?></textarea></td>
									<td><textarea type="text"  id="abc" value="<?php if ($data != 'undefined'){ echo $data[0]['f4_person_r'.$index.'_c6']; }else { echo '';} ?>" name="person_r<?php echo $index; ?>_c6" class="form-control" rows="3" cols="5"><?php if ($data != 'undefined'){ echo $data[0]['f4_person_r'.$index.'_c6']; }else { echo '';} ?></textarea></td>
								</tr>
															
								<?php } //}?>
								 
							</tbody>							
						</table>
						<div class="row">
							<div class="col-md-12">
							<!--	<a href="<?php echo base_url();?>red_rec_microplan/Special_activities/special_activities_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>-->
								<button type="reset" class="form-btn"><i class="fa fa-recycle" aria-hidden="true"></i> Reset Form</button>								
						<!--	<button type="submit" name="submit" value="Submit" id="spt_form" class="form-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit Form</button>-->	
								<button type="submit" name="submit" value="submit" id="close" class="form-btn clos "><i class="fa fa-floppy-o" aria-hidden="true"></i> Update and Close </button>								
								<button type="submit" name="submit" value="submit" id="next" class="form-btn next "><i class="fa fa-floppy-o" aria-hidden="true"></i> Update and Next </button>						
							</div>
						</div>				
					</div> <!--end of panel body-->
				</form>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->

	<script type="text/javascript">
		$(document).ready(function(){
			//"<?php echo base_url(); ?>red_rec_microplan/Red_strategy/red_strategy_save",
				/*	$(function () {
			var x;
        $('form').on('submit', function (e) {
alert("submit");
          e.preventDefault();
          $.ajax({
            type: 'post',
             url: "<?php echo base_url(); ?>red_rec_microplan/Red_strategy/red_strategy_save",
            data: $('form').serialize(),
            success: function (data) {
            	      // x = data;
            	        // console.log(x);
						 //$("b").html(x);
alert("test2");             
 //window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
             // $('#b').trigger("click");
			  //$( "#f").trigger( "click", [x] );
              //$(".b").html(x);              
            }
          });

        });

      });*/
			  $(function () {
				var x;
				$( ".clos" ).click(function(e) {
					var save_next    = document.getElementById("close").value = "sclose";
					//alert(save_next);
					e.preventDefault();
					$.ajax({
						type: 'post',
						  url: "<?php echo base_url(); ?>red_rec_microplan/Red_strategy/red_strategy_save",
						data: $('form').serialize(),
						success: function (data) {
								
									   if(save_next == "sclose" ) { 
										   window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
										}
									
						}
					});
				});
		});
	  $(function () {
			var x;
			$( ".next" ).click(function(e) {
			var save_next    = document.getElementById("next").value = "snext";
			e.preventDefault();
			$.ajax({
            type: 'post',
             url: "<?php echo base_url(); ?>red_rec_microplan/Red_strategy/red_strategy_save",
            data: $('form').serialize(),
            success: function (data) {
                              if(data == "yes"){
							alert("Cannot save data because data already exists for this Technician and Year!")
							window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
						   }                             
						   /* else if(data == "HTR>TP"){
							alert("Cannot save data because Target Population and Hard to Reach Population are greater than Total Population!")
							window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
						   } */
						  /*  else if(data == "TP>TP"){
							alert("Cannot save data because Target Population is greater than Total Population!")
							window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
						   } */
						  /*  else if(data == "HRP>TP"){
							alert("Cannot save data because Hard to Reach Population is greater than Total Population!")
							window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
						   } */
						   /* else if(data == "ASP>SPM"){
							alert("Cannot save data because Actual sessions planned is greater than Actual sessions planned!")
							window.location = "<?php echo base_url(); ?>red_rec_microplan/Situation_analysis/Situation_analysis_list";
						   }    */    
						   else{
							//   x = data;
							 
							 $( "#f").trigger( "click", [x] ); 
						   }	
						
            }
          });
        });
      }); 
			
			
			
			
			$(document).on('change','#ticode', function(){
				var tcode = this.value;
				if(tcode == "") {
				  $('#unicode').html('');
				  $('#facode').html('');
				  //it doesn't exist
				}
				else{
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
			var options = {
				clearBtn:true,
				format : "yyyy-mm-dd",
				todayHighlight: true,
				autoclose: true,
				color: "green"
			};
			$('.calendar').datepicker(options);		
		});
	