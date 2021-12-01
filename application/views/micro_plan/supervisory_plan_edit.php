<?php  //print_r($m1);exit; ?>
<div class="container">
	<div class="row">
	<div class="panel panel-primary">
		<ol class="breadcrumb">
			<!-- <ul class="breadcrumb"><li><a href="http://epimis.kphealth.pk/">Home</a> <span class="divider"></span></li><li class="active">Facility Monthly Vaccination Reports</li></ul>
 			-->		
 			<ul class="breadcrumb">
 				<li><a href="http://pace-tech.com/dev/epimis/">Home</a><span class="divider"></span></li>
				<li class="active"></li>
			</ul>
		</ol> 
		<div class="panel-heading">Supervisory Micro Plan
		</div>
		<div class="panel-body">
			<!--it is use for show message-->
			<form class="form-inline table-supervisor" method="post" action="<?php echo base_url();?>micro_plan/Micro_plan_controller/supervisory_plan_save"  >
				<input type="hidden" value="edit" name="edit" >
				<div class="row">
					<div class="col-md-3">
						<label for="Supervisor_designation">Supervisor Designation</label>
					</div>
					<div class="col-md-3">
						<select required class="form-control" id="supervisor_type" name="supervisor_type">
							<?php
								$i=1;
								foreach($m1 as $row=>$val){ ?>
									<option value="<?php echo $val['designation'];?>" ><?php echo $val['designation'];?></option>
							<?php if($i==1) break; } ?>
						</select>
					</div>
					<div class="col-md-3">
						<label for="Supervisor_Name">Supervisor Name</label>
					</div>
					<div class="col-md-3">
						<select required class="form-control" id="supervisor_name" name="supervisor_name">
							<?php
								$i=1;
								foreach($m1 as $row=>$val){ 
							?>
							<option value="<?php echo $val['supervisorcode'];?>" >
								<?php
									if(isset($val)){
									echo get_supervisor_Name($val['supervisorcode']); 
									}
								?>
							</option>
							<?php if($i==1) break; } ?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label for="ReportYear">year</label>
					</div>
					<div class="col-md-3">
						<select required class="form-control" id="year_id" name="date_year">
							<option value="<?php echo substr($m1[0]['fmonth'],0,4); ?>" ><?php echo  substr($m1[0]['fmonth'],0,4);?></option>                       
						</select>
					</div>
					<div class="col-md-3">
						<label for="QuarterList">Quarter</label>
					</div>
					<div class="col-md-3">
						<select required class="form-control" id="quarter" name="quarter">
							<option value="<?php echo $m1[0]['quarter']; ?>"><?php echo $m1[0]['case'];?></option>                       
						</select>
					</div>
				</div>
			
				<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
					<thead>
					 	<tr>
							<?php if($m1[0]['quarter'] == 1) {?>
								<th colspan="7" class="qtr" id="m1">January</th>
							<?php } else if($m1[0]['quarter'] == 2) { ?>
								<th colspan="7" class="qtr" id="m1">April</th>
							<?php } else if($m1[0]['quarter'] == 3) { ?>
								<th colspan="7" class="qtr" id="m1">July</th>
							<?php } else if($m1[0]['quarter'] == 4) { ?>
								<th colspan="7" class="qtr" id="m1">October</th>
							<?php } else  { ?>
								<th colspan="7" class="qtr" id="m1">January</th>
							<?php } ?>				
							<input type="hidden" id="month1" name="monthm1"  value="<?php echo substr($m1[0]['fmonth'],5,6); ?>">
						</tr>
						<tr>
							<th>S.No.</th>
							<th>Union Council</th>
							<th>Session Type</th>
							<th>Village/HF name</th>
							<th>Date Visit Planned</th>
							<!--<th>Conducted</th>-->
							<th>Remarks</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="trRow">
					<?php 
						$i=1;
					    $array=count($m1);
				        foreach($m1 as $key=>$val) 
						{
							//print_r($val); exit;
							//$next=1+$i;?>
			         	<tr>						    
							<td>
								<input type="hidden" value="<?php echo $val['id']; ?>" name="id[]" />
								<label class="srno-lbl" name="lb[]"><?php echo $i; ?></label>
							</td>
							<td>
								<select class="form-control uncode" required  id="uncode" name="uncodem1[<?php echo $key+1; ?>]">
							     	<?php
										/* if(isset($val)){
										echo getUCs_options(false,$val['uncode']); 
										}
										else{echo'';} */
									    echo isset($val['uncode'])?getUCs_options(false,$val['uncode']): '';
									?>
								</select>
							</td>
							<td>
								<select class="form-control session_type" required  id="session_type" name="sessionm1[<?php echo $key+1; ?>]">
									<option value="">--Select--</option>
									<option   <?php if($val['session_type'] == "Fixed")  echo 'selected="selected"';   ?> value="Fixed">Fixed</option>
									<option   <?php if($val['session_type'] == "Outreach")  echo 'selected="selected"';   ?> value="Outreach">Outreach</option>
									<option   <?php if($val['session_type'] == "Mobile")  echo 'selected="selected"';   ?> value="Mobile">Mobile</option>
								</select>
							</td>
							<td class="tds">							
								<select class="form-control vilage_hf_name " required id="hf_id" name="vilage_hf_namem1[<?php echo $key+1; ?>]" >                      
									<?php 
										echo getred_rec_village_options($val['session_type'],$val['uncode'],$val['area_name']);
									?>
								</select>					
		                    </td>
						    <td>
								<!-- <input type="date" required class="form-control" value="<php echo $val['planned_date']; ?>" id="visit_date" name="datedm1[<php echo $key+1; ?>]" > -->
								<input type="text" required class="form-control text-center calendar1" value="<?php echo $val['planned_date']; ?>" name="datedm1[<?php echo $key+1; ?>]" id="visit_date" readonly>
							</td>
							<td>
								<input type="text" class="form-control" id="remarks_id" placeholder="Remarks" value="<?php echo $val['remarks']; ?>" name="remarksm1[<?php echo $key+1; ?>]" >
							</td>
							<td>
						        <?php if($array > $i) { ?>
                                    <button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                <?php } else { ?>
                                    <button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                <?php } ?>
							</td>
						</tr>
					<?php $i++; } 	?> 

					</tbody>
				</table>
				
								<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
					<thead>
					 <tr>
					                <?php if($m2[0]['quarter'] == 1) {?>
										<th colspan="7" class="qtr" id="m2">February</th>
									<?php } else if($m2[0]['quarter'] == 2) { ?>
										<th colspan="7" class="qtr" id="m2">May</th>
									<?php } else if($m2[0]['quarter'] == 3) { ?>
										<th colspan="7" class="qtr" id="m2">August</th>
									<?php } else if($m2[0]['quarter'] == 4) { ?>
										<th colspan="7" class="qtr" id="m2">November</th>
									<?php } else  { ?>
										<th colspan="7" class="qtr" id="m2">February</th>
									<?php } ?>
								    <input type="hidden" id="month1" name="monthm2"  value="<?php echo substr($m2[0]['fmonth'],5,6); ?>" >
								</tr>
						<tr>
							<th>S.No.</th>
							<th>Union Council</th>
							<th>Session Type</th>
							<th>Village/HF name</th>
							<th>Date Visit Planned</th>
							<!--<th>Conducted</th>-->
							<th>Remarks</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="trRow1">
				<?php 
					$i=1;
				    $array=count($m2);
			        foreach($m2 as $key=>$val) 
				{ 
				    
					//print_r($array);
				//	$next=1+$i;?>

						<tr>
						    
							<td>
							<input type="hidden" value="<?php echo $val['id']; ?>" name="id[]" />
							
							<label class="srno-lbl" name="lb[<?php echo $key+1; ?>]"><?php echo$i; ?></label>
							</td>
							<td>
								<select class="form-control uncode" required  id="uncode" name="uncodem2[<?php echo $key+1; ?>]">
							     <!--<option value="<?php echo get_UC_Name($val['uncode']); ?>" <?php if($val['uncode'] !='')  echo 'selected="selected"';   ?>  ><?php echo get_UC_Name($val['uncode']); ?></option>-->
								 <?php
									/* if(isset($val)){
									echo getUCs_options(false,$val['uncode']); 
									}
									else{
										echo'';
									} */
									echo isset($val['uncode'])?getUCs_options(false,$val['uncode']): '';
								   ?>
								</select>
							</td>
							<td>
								<select class="form-control session_type" required  id="session_type" name="sessionm2[<?php echo $key+1; ?>]">
									<option value="">--Select--</option>
									 <option   <?php if($val['session_type'] == "Fixed")  echo 'selected="selected"';   ?> value="Fixed">Fixed</option>
									 <option   <?php if($val['session_type'] == "Outreach")  echo 'selected="selected"';   ?> value="Outreach">Outreach</option>
									 <option   <?php if($val['session_type'] == "Mobile")  echo 'selected="selected"';   ?> value="Mobile">Mobile</option>
									
								</select>
							</td>
							<td class="tds">
								<select class="form-control vilage_hf_name " required id="hf_id" name="vilage_hf_namem2[<?php echo $key+1; ?>]" >                      
									<?php 
									echo getred_rec_village_options($val['session_type'],$val['uncode'],$val['area_name']);
									?>
									 
								</select>
	
		                    </td>
						    <td>
								<!-- <input type="date" required class="form-control" value="<php echo $val['planned_date']; ?>" id="visit_date" name="datedm2[<php echo $key+1; ?>]" > -->
									<input type="text" required class="form-control text-center calendar2" value="<?php echo $val['planned_date']; ?>" name="datedm2[<?php echo $key+1; ?>]" id="visit_date" readonly>
							</td>
							<td>
								<input type="text" class="form-control" id="remarks_id" placeholder="Remarks" value="<?php echo $val['remarks']; ?>" name="remarksm2[<?php echo $key+1; ?>]" >
							</td>
							<td>
							        <?php 
                                         if($array > $i)
                                       { ?>
                                          <button type="button" onclick="deleteRow1(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                          <?php } else { ?>
                                          <button onclick="addRow1(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    <?php } ?>
							
								
							</td>
						</tr>
	<?php $i++; }	?>

					</tbody>
				</table>
				
								<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
					<thead>
					 <tr>
					                       <?php if($m3[0]['quarter'] == 1) {?>
										<th colspan="7" class="qtr" id="m3" style="border-right-color:black;">March</th>
									<?php } else if($m3[0]['quarter'] == 2) { ?>
										<th colspan="7" class="qtr" id="m3" style="border-right-color:black;">June</th>
									<?php } else if($m3[0]['quarter'] == 3) { ?>
										<th colspan="7" class="qtr" id="m3" style="border-right-color:black;">September</th>
									<?php } else if($m3[0]['quarter'] == 4) { ?>
										<th colspan="7" class="qtr" id="m3" style="border-right-color:black;">December</th>
									<?php } else  { ?>
										<th colspan="7" class="qtr" id="m3" style="border-right-color:black;">March</th>
									<?php } ?>
								    <input type="hidden" id="month1" name="monthm3"  value="<?php echo substr($m3[0]['fmonth'],5,6); ?>" >
								</tr>
						<tr>
							<th>S.No.</th>
							<th>Union Council</th>
							<th>Session Type</th>
							<th>Village/HF name</th>
							<th>Date Visit Planned</th>
							<!--<th>Conducted</th>-->
							<th>Remarks</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="trRow2">
				<?php 
					$i=1;
				    $array=count($m3);
			        foreach($m3 as $key=>$val) 
				{ 
				    
					//print_r($array);
				//	$next=1+$i;?>

						<tr>
						    
							<td>
							<input type="hidden" value="<?php echo $val['id']; ?>" name="id[]" />
							
							<label class="srno-lbl" name="lb[<?php echo $key+1; ?>]"><?php echo$i; ?></label>
							</td>
							<td>
								<select class="form-control uncode" required  id="uncode" name="uncodem3[<?php echo $key+1; ?>]">
							     <!--<option value="<?php echo get_UC_Name($val['uncode']); ?>" <?php if($val['uncode'] !='')  echo 'selected="selected"';   ?>  ><?php echo get_UC_Name($val['uncode']); ?></option>-->
							<?php
									/* if(isset($val)){
									echo getUCs_options(false,$val['uncode']); 
									}
									else{
										echo'';
									} */
									echo isset($val['uncode'])?getUCs_options(false,$val['uncode']): '';
								   ?>
								</select>
							</td>
							<td>
								<select class="form-control session_type" required  id="session_type" name="sessionm3[<?php echo $key+1; ?>]">
									<option value="">--Select--</option>
									 <option   <?php if($val['session_type'] == "Fixed")  echo 'selected="selected"';   ?> value="Fixed">Fixed</option>
									 <option   <?php if($val['session_type'] == "Outreach")  echo 'selected="selected"';   ?> value="Outreach">Outreach</option>
									 <option   <?php if($val['session_type'] == "Mobile")  echo 'selected="selected"';   ?> value="Mobile">Mobile</option>
									
								</select>
							</td>
							<td class="tds">
								<select class="form-control vilage_hf_name " required id="hf_id" name="vilage_hf_namem3[<?php echo $key+1; ?>]" >                      
									<!--<option value="">--Select--</option>-->
									<!--<option value="<?php echo $val['area_name']; ?>"><?php echo get_Village_Name($val['area_name']); ?></option>-->
									<!--<option value="<?php echo $val['area_name']; ?>" <?php if($val['area_name'] !='')  echo 'selected="selected"';   ?>  ><?php echo $val['area_name']; ?></option>-->
									 <?php 
									echo getred_rec_village_options($val['session_type'],$val['uncode'],$val['area_name']);
									?>
								</select>
		                    </td>
						    <td>
								<!-- <input type="date" required class="form-control" value="<php echo $val['planned_date']; ?>" id="visit_date" name="datedm3[<php echo $key+1; ?>]" > -->
								<input type="text" required value="<?php echo $val['planned_date']; ?>" class="form-control text-center calendar3" name="datedm3[<?php echo $key+1; ?>]" id="visit_date" readonly>
							</td>
							<td>
								<input type="text" class="form-control" id="remarks_id" placeholder="Remarks" value="<?php echo $val['remarks']; ?>" name="remarksm3[<?php echo $key+1; ?>]" >
							</td>
							<td>
							        <?php 
                                         if($array > $i)
                                       { ?>
                                          <button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                          <?php } else { ?>
                                          <button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    <?php } ?>
							
								
							</td>
						</tr>
	<?php $i++; }	?>

					</tbody>
				</table>
				<!--<div class="form-group" style="display:block;">
					<label for="Percentage">
								Percentage supervisory visits conducted: (Number Conducted x 100 / Number Planned) = ________%
					</label>
				</div>-->
				
				<div class="form-group">
					<label for="Date">
								Date :
					</label>
				</div>
				<div class="form-group">
					<label for="Date" class="form-control">
								<script> document.write(new Date().toLocaleDateString()); </script>
					</label>
				</div>
				<div class="row">
					<div class="col-md-11">
						<div class="save_cancel">
							<button role="button" type="submit" id="save_form"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Upddate Form</button>
						<!--	<button role="button"type="submit" id="submit_form"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Submit Form</button>-->
							<button type="reset" id="reset_form"><i class="fa fa-repeat" aria-hidden="true"></i>  Reset Form</button>
							<a href="<?php echo base_url();?>micro_plan/Micro_plan_controller/supervisory_plan">	<button type="button" id="form_cancel"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>
						</div>
					</div>
				</div>
			</form>			
		</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<script type="text/javascript">	
$(document).ready(function(){
    $(document).on('change','#supervisor_type',function(){
		var $supervisor_type = $(this).val();
 		if($supervisor_type=="")
			alert('You are entering Invalid Supervisor Type!');
		else{
			$.ajax({
					type:"POST",
					data:"supervisor_type="+$supervisor_type,
					url:"<?php echo base_url(); ?>Ajax_calls/getSupervisor",
				success: function(result){
					var data = jQuery.parseJSON(result.trim());
					$('#supervisor_name').html(data);
				}
			});
		}
	});
});

</script>
	<script type="text/javascript">

		$(document).ready(function(){
		$(document).on('change','.session_type',function(){
			
			var sessiontype = this.value;
			var uncode= $(this).closest('tr').find('.uncode').val();
			var selectedobj = $(this);
			//alert(sessiontype);
			$.ajax({
				type: "POST",
				data: "sessiontype="+sessiontype+"&uncode="+uncode,
				url: "<?php echo base_url(); ?>Ajax_calls/getred_rec_village",
				success: function(result){
                $(selectedobj).closest("tr").find("td:nth-child(4)").find('select').html(result);					
				}
			});
			
        });	
	});
   ////////////END//////////////////
////////////////this Ready function for 1st time page load datepicker/////////////////////////			
	 
	function dateBasedonQuarter(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var qua = $("#quarter").find("option:selected").val();
		var year = $("#year_id").find("option:selected").val();
		if(qua == 01){
				var month1 = '01';
				var month2 = '02';
				var month3 = '03';
		}else if(qua == 02){
				var month1 = '04';
				var month2 = '05';
				var month3 = '06';
		}else if(qua == 03){
				var month1 = '07';
				var month2 = '08';
				var month3 = '09';
		}else if(qua == 04){
				var month1 = '10';
				var month2 = '11';
				var month3 = '12';
		}
		console.log(qua);
		console.log(month1);
		console.log(month2);
		console.log(month3);
		if(month1 != 0 ){
			var minDate = new Date(year, month1-1, 1);
			var maxDate = new Date(year, month1, 0);
			$('.calendar1').each(function(){
				$('.calendar1').datepicker({
					format : "yyyy-mm-dd",
					startDate: minDate,
					endDate: maxDate,
					autoclose:true
				});
			});
		}
		if(month2 != 0 ){
		   
			 var minDate = new Date(year, month2-1, 1);
		     var maxDate = new Date(year, month2, 0);
			  $('.calendar2').each(function(){
				$('.calendar2').datepicker({
					format : "yyyy-mm-dd",
					startDate: minDate,
					endDate: maxDate
				});
			});
		}
		if(month3 != 0 ){
			 
			 var minDate = new Date(year, month3-1, 1);
		     var maxDate = new Date(year, month3, 0);
			$('.calendar3').each(function(){
				$('.calendar3').datepicker({
					format : "yyyy-mm-dd",
					startDate: minDate,
					endDate: maxDate
				});
			});
		}				
	}
///////////////END////////////////////
///////////////Call on page load ////////////////////
	$( function(){
		dateBasedonQuarter();
	}); 
////////////finel//////////////////

 //    function addRow(obj){
	// 			var row = $(obj).closest("tr").clone(true);
	// 		    row.find('input').val('');
	// 		   row.find('select').each(function(){
	// 				$(this).find('option:first').prop('selected',true);
	// 			}); 
	// 			/*var lastRowIndex = $('#trRow').find('tr:last').index();
	// 		    console.log(lastRowIndex);
	// 			var currentIndex = lastRowIndex+1; */
	// 				row.find("td:nth-child(1)").find('label').val('');
	// 				row.find("td:nth-child(2)").find('select').val('0');
	// 				row.find("td:nth-child(3)").find('select').val('');
	// 				row.find("td:nth-child(4)").find('select').val('');
	// 				row.find("td:nth-child(5)").find('input').val('');
	// 				row.find("td:nth-child(6)").find('input').val('');
	// 			$(obj).closest("tr").after(row);
	// 			$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
	// 			$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
	// 			reindex_serialnumber_and_trainingCompleted();
				
	// }
	function addRow(obj){
		 var row = $(obj).closest("tr").clone();
		row.find('input').val('');
		//var lastRowIndex = $('#trRow').find('tr:last').index();
		row.find("td:nth-child(1)").find('label').val('');
		row.find("td:nth-child(2)").find('select').val('0');
		row.find("td:nth-child(3)").find('select').val('');
		row.find("td:nth-child(4)").find('select').val('');
		row.find("td:nth-child(5)").find('input').val('');
		row.find("td:nth-child(6)").find('input').val('');
		$(obj).closest("#trRow").append(row);
		$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
		$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		reindex_serialnumber_and_trainingCompleted();
		
	}
    function deleteRow(obj) {
				/* $(obj).closest("tr").remove();
				reindex_serialnumber_and_trainingCompleted(); */
			var index = $('#trRow').find('tr:last').index();
			//alert(index);
		  $(obj).closest("tr").remove();
			if(index=='1'){
				$('#trRow').find('tr:last').find('td:last').html('<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}else{
				$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}
		  reindex_serialnumber_and_trainingCompleted();
	}
	
	// function addRow1(obj){
	// 			var row = $(obj).closest("tr").clone(true);
	// 		    row.find('input').val('');
	// 			/* var lastRowIndex = $('#trRow').find('tr:last').index();
	// 		    console.log(row);
	// 			var currentIndex = lastRowIndex+1; */
	// 				//row.find("td:nth-child(1)").find('label').attr('name','lb['+currentIndex+']');
	// 				row.find("td:nth-child(1)").find('label').val('');
	// 				//row.find("td:nth-child(2)").find('select').attr('name','uncode['+currentIndex+']');
	// 				row.find("td:nth-child(2)").find('select').val('0');
	// 				//row.find("td:nth-child(3)").find('select').attr('name','uncode['+currentIndex+']');
	// 				row.find("td:nth-child(3)").find('select').val('0');
	// 				//row.find("td:nth-child(4)").find('select').attr('name','vilage_hf_name['+currentIndex+']');
	// 				row.find("td:nth-child(4)").find('select').val('0');
	// 				//row.find("td:nth-child(5)").find('input').attr('name','dated['+currentIndex+']');
	// 				row.find("td:nth-child(5)").find('input').val('');
	// 				//row.find("td:nth-child(6)").find('input').attr('name','remarks['+currentIndex+']');
	// 				row.find("td:nth-child(6)").find('input').val('');
	// 			$(obj).closest("tr").after(row);
	// 			$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow1(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
	// 			$('#trRow1').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow1(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow1(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
	// 			reindex_serialnumber_and_trainingCompleted1();
				
	// }

	function addRow1(obj){
		var row = $(obj).closest("tr").clone();
		   row.find('input').val('');
		row.find("td:nth-child(1)").find('label').val('');
		row.find("td:nth-child(2)").find('select').val('0');
		row.find("td:nth-child(3)").find('select').val('0');
		row.find("td:nth-child(4)").find('select').val('0');
		row.find("td:nth-child(5)").find('input').val('');
		row.find("td:nth-child(6)").find('input').val('');
		$(obj).closest("#trRow1").append(row);
		$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow1(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
		$('#trRow1').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow1(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow1(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		reindex_serialnumber_and_trainingCompleted1();
		
	}

    function deleteRow1(obj) {
				/* $(obj).closest("tr").remove();
				reindex_serialnumber_and_trainingCompleted(); */
				 var index = $('#trRow1').find('tr:last').index();
		  $(obj).closest("tr").remove();
			if(index=='1'){
				$('#trRow1').find('tr:last').find('td:last').html('<button onclick="addRow1(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}else{
				$('#trRow1').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow1(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow1(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}
		  reindex_serialnumber_and_trainingCompleted1();
	}
	
	// function addRow2(obj){
	// 			var row = $(obj).closest("tr").clone(true);
	// 		    row.find('input').val('');
	// 			/* var lastRowIndex = $('#trRow').find('tr:last').index();
	// 		    console.log(row);
	// 			var currentIndex = lastRowIndex+1; */
	// 				//row.find("td:nth-child(1)").find('label').attr('name','lb['+currentIndex+']');
	// 				row.find("td:nth-child(1)").find('label').val('');
	// 				//row.find("td:nth-child(2)").find('select').attr('name','uncode['+currentIndex+']');
	// 				row.find("td:nth-child(2)").find('select').val('0');
	// 				//row.find("td:nth-child(3)").find('select').attr('name','uncode['+currentIndex+']');
	// 				row.find("td:nth-child(3)").find('select').val('0');
	// 				//row.find("td:nth-child(4)").find('select').attr('name','vilage_hf_name['+currentIndex+']');
	// 				row.find("td:nth-child(4)").find('select').val('0');
	// 				//row.find("td:nth-child(5)").find('input').attr('name','dated['+currentIndex+']');
	// 				row.find("td:nth-child(5)").find('input').val('');
	// 				//row.find("td:nth-child(6)").find('input').attr('name','remarks['+currentIndex+']');
	// 				row.find("td:nth-child(6)").find('input').val('');
	// 			$(obj).closest("tr").after(row);
	// 			$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
	// 			$('#trRow2').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
	// 			reindex_serialnumber_and_trainingCompleted2();
				
	// }

	function addRow2(obj){
				var row = $(obj).closest("tr").clone();
			    row.find('input').val('');
				row.find("td:nth-child(1)").find('label').val('');
				row.find("td:nth-child(2)").find('select').val('0');
				row.find("td:nth-child(3)").find('select').val('0');
				row.find("td:nth-child(4)").find('select').val('0');
				row.find("td:nth-child(5)").find('input').val('');
				row.find("td:nth-child(6)").find('input').val('');
				$(obj).closest("tr").after(row);
				$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
				$('#trRow2').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
				reindex_serialnumber_and_trainingCompleted2();
	}
    function deleteRow2(obj) {
				/* $(obj).closest("tr").remove();
				reindex_serialnumber_and_trainingCompleted(); */
				 var index = $('#trRow2').find('tr:last').index();
		  $(obj).closest("tr").remove();
			if(index=='1'){
				$('#trRow2').find('tr:last').find('td:last').html('<button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}else{
				$('#trRow2').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}
		  reindex_serialnumber_and_trainingCompleted2();
	}
	
    function reindex_serialnumber_and_trainingCompleted(){
		$('#trRow > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('select').attr('name','uncodem1['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','sessionm1['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','vilage_hf_namem1['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','datedm1['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('name','remarksm1['+i+']');
			
		});
		dateBasedonQuarter();
	}
	 function reindex_serialnumber_and_trainingCompleted1(){
		$('#trRow1 > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('select').attr('name','uncodem2['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','sessionm2['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','vilage_hf_namem2['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','datedm2['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('name','remarksm2['+i+']');
		});
		dateBasedonQuarter();
	}
	 function reindex_serialnumber_and_trainingCompleted2(){
		$('#trRow2 > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('select').attr('name','uncodem3['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','sessionm3['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','vilage_hf_namem3['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','datedm3['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('name','remarksm3['+i+']');
		});
		dateBasedonQuarter();
	}
    /* $(document).ready(function(){
		$(document).on('change','.session_type',function(){
			// $('#tdv').hide(); 
			if($(this).closest('tr').find('.session_type').val() == '2') {
				$(this).closest('tr').find('.tdv').show();
				$(this).closest('tr').find('.tds').hide();
			
			} 
			if ($(this).closest('tr').find('.session_type').val() == '1'){
			   $(this).closest('tr').find('.tds').show();
			   $(this).closest('tr').find('.tdv').hide();
			   
			} 
        });	
	}); */
	/* $(document).ready(function(){
		//$(document).on('change','.session_type',function(){
			// $('#tdv').hide(); 
		<?php	if($val['session_type'] =='1') { ?>
			alert("cxxx");
				$(this).closest('tr').find('.tdv').show();
				$(this).closest('tr').find('.tds').hide();
			
				
		<?php }	elseif($val['session_type'] =='2') { ?>
			alert("sxxx");
			   $(this).closest('tr').find('.tds').show();
			   $(this).closest('tr').find('.tdv').hide();
			<?php } ?>
        //});	
	}); */
	$(document).ready(function(){
    $(document).on('change','.uncode',function(){
		var val1 =$(this).closest('tr').find('.session_type').val('');
        var val2 = $(this).closest('tr').find('.vilage_hf_name').val('');

	});
});
	
</script>
		</body>
</html>