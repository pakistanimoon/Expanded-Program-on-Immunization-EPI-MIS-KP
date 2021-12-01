<?php // print_r($m1);exit; ?>
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
							<option value="<?php echo substr($m1[0]['fmonth'],0,4); ?>" ><?php echo substr($m1[0]['fmonth'],0,4);?></option>                       
						</select>
					</div>
					<div class="col-md-3">
						<label for="MonthList">Quarter</label>
					</div>
					<div class="col-md-3">
						<select required class="form-control" id="month_id" name="date_month">
							<option value="<?php echo $m1[0]['case']; ?>" ><?php echo  $m1[0]['case']; ?></option>                       
						</select>
					</div>
				</div>
				<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
					<thead>
					<tr>
					                <?php if($m1[0]['quarter'] == 1) {?>
										<th colspan="9" class="qtr" id="m1">January</th>
									<?php } else if($m1[0]['quarter'] == 2) { ?>
										<th colspan="9" class="qtr" id="m1">April</th>
									<?php } else if($m1[0]['quarter'] == 3) { ?>
										<th colspan="9" class="qtr" id="m1">July</th>
									<?php } else if($m1[0]['quarter'] == 4) { ?>
										<th colspan="9" class="qtr" id="m1">October</th>
									<?php } else  { ?>
										<th colspan="9" class="qtr" id="m1">January</th>
									<?php } ?>
				
								    <input type="hidden" id="month1" name="monthm1"  value="<?php echo substr($m1[0]['fmonth'],5,6); ?>" >
								</tr>
						<tr>
							<th>S.No.</th>
							<th>Union Council</th>
							<th>Session Type</th>
							<th>Village/HF name</th>
							<th>Conducted</th>
							<th>Date Visit Conduct</th>
							<th>Conduct Remarks</th>
						</tr>
					</thead>
					<tbody id="trRow">
				<?php 
					$i=1;
				    $array=count($m1);
			        foreach($m1 as $key=>$val) 
				{ 
				    
					//print_r($array);
				//	$next=1+$i;?>

						<tr>
						    
							<td>
							<input type="hidden" value="<?php echo $val['id']; ?>" name="idm1[<?php echo $key+1; ?>]">
							<input type="hidden" value="conduct" name="conduct" >
							<input type="hidden" value="1" name="statusm1[<?php echo $key+1; ?>]" >
							
							<label class="srno-lbl" name="lb[<?php echo $key+1; ?>]"><?php echo$i; ?></label>
							</td>
							<td>
								
								<input type="text" value="<?php echo get_UC_Name($val['uncode']); ?>" readonly id="uncodem1[<?php echo $key+1; ?>]"  name="uncodem1[<?php echo $key+1; ?>]" class="form-control text-center ">
							</td>
							<td>
								
								<input type="text" value="<?php echo $val['session_type']; ?>" readonly id="sessionm1[<?php echo $key+1; ?>]"  name="sessionm1[<?php echo $key+1; ?>]" class="form-control text-center ">
							</td>
							<td class="tds">
								<?php if($val['session_type']=='Fixed'){?>
								<input type="text" value="<?php echo get_Facility_Name($val['area_name']); ?>" readonly id="vilage_hf_namem1[<?php echo $key+1; ?>]"  name="vilage_hf_namem1[<?php echo $key+1; ?>]" class="form-control text-center ">
									<?php } else  { ?>
								   <input type="text" value="<?php echo get_Village_Name($val['area_name']); ?>" readonly id="vilage_hf_namem1[<?php echo $key+1; ?>]"  name="vilage_hf_namem1[<?php echo $key+1; ?>]" class="form-control text-center ">
								    <?php } ?>
								
		                    </td>
							<td>
								<select required class="form-control conducted" name="conductedm1[<?php echo $key+1; ?>]" >
									<option   selected="selected" value="">--Select--</option>
									 <option   <?php if($val['is_conducted'] == '1')  echo 'selected="selected"';   ?> value="1">Yes</option>
									 <option   <?php if($val['is_conducted'] == '0')  echo 'selected="selected"';   ?> value="0">No</option>
									<!--<option value="1">Yes</option>
									<option value="0">No</option>-->
								</select>
							</td>
						    <td>
								<input type="text" readonly required class="form-control text-center calendar1" value="<?php echo $val['conduct_date']; ?>" id="visit_date" name="conduct_datem1[<?php echo $key+1; ?>]" >
							</td>
							<td>
								<input type="text" required class="form-control" id="remarks_id" placeholder="Remarks" value="<?php echo $val['conduct_remarks']; ?>" name="conduct_remarksm1[<?php echo $key+1; ?>]" >
							</td>
							<!--<td>
							        <?php 
                                         if($array > $i)
                                       { ?>
                                          <button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                          <?php } else { ?>
                                          <button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    <?php } ?>
							
								
							</td>-->
						</tr>
	<?php $i++; }	?>

					</tbody>
				</table>
				
								<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
					<thead>
					<tr>
					                        <?php if($m2[0]['quarter'] == 1) {?>
										<th colspan="9" class="qtr" id="m2">February</th>
									<?php } else if($m2[0]['quarter'] == 2) { ?>
										<th colspan="9" class="qtr" id="m2">May</th>
									<?php } else if($m2[0]['quarter'] == 3) { ?>
										<th colspan="9" class="qtr" id="m2">August</th>
									<?php } else if($m2[0]['quarter'] == 4) { ?>
										<th colspan="9" class="qtr" id="m2">November</th>
									<?php } else  { ?>
										<th colspan="9" class="qtr" id="m2">February</th>
									<?php } ?>
								    <input type="hidden" id="month1" name="monthm2"  value="<?php echo substr($m2[0]['fmonth'],5,6); ?>" >
								</tr>
						<tr>
							<th>S.No.</th>
							<th>Union Council</th>
							<th>Session Type</th>
							<th>Village/HF name</th>
							<th>Conducted</th>
							<th>Date Visit Conduct</th>
							<th>Conduct Remarks</th>
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
							<input type="hidden" value="<?php echo $val['id']; ?>" name="idm2[<?php echo $key+1; ?>]">
							<input type="hidden" value="conduct" name="conduct" >
							<input type="hidden" value="1" name="statusm2[<?php echo $key+1; ?>]" >
							
							<label class="srno-lbl" name="lb[<?php echo $key+1; ?>]"><?php echo$i; ?></label>
							</td>
							<td>
								
								<input type="text" value="<?php echo get_UC_Name($val['uncode']); ?>" readonly id="uncodem2[<?php echo $key+1; ?>]"  name="uncodem2[<?php echo $key+1; ?>]" class="form-control text-center ">
							</td>
							<td>
								
								<input type="text" value="<?php echo $val['session_type']; ?>" readonly id="sessionm2[<?php echo $key+1; ?>]"  name="sessionm2[<?php echo $key+1; ?>]" class="form-control text-center ">
							</td>
							<td class="tds">
							<?php if($val['session_type']=='Fixed'){?>
								<input type="text" value="<?php echo get_Facility_Name($val['area_name']); ?>" readonly id="vilage_hf_namem2[<?php echo $key+1; ?>]"  name="vilage_hf_namem1[<?php echo $key+1; ?>]" class="form-control text-center ">
									<?php } else  { ?>
								   <input type="text" value="<?php echo get_Village_Name($val['area_name']); ?>" readonly id="vilage_hf_namem2[<?php echo $key+1; ?>]"  name="vilage_hf_namem1[<?php echo $key+1; ?>]" class="form-control text-center ">
								    <?php } ?>
		                    </td>
							<td>
								<select required class="form-control conducted" name="conductedm2[<?php echo $key+1; ?>]" >
									<option   selected="selected" value="">--Select--</option>
									 <option   <?php if($val['is_conducted'] == '1')  echo 'selected="selected"';   ?> value="1">Yes</option>
									 <option   <?php if($val['is_conducted'] == '0')  echo 'selected="selected"';   ?> value="0">No</option>
									<!--<option value="1">Yes</option>
									<option value="0">No</option>-->
								</select>
							</td>
						    <td>
								<input type="text" readonly required class="form-control text-center calendar2" value="<?php echo $val['conduct_date']; ?>" id="visit_date" name="conduct_datem2[<?php echo $key+1; ?>]" >
							</td>
							<td>
								<input type="text" required class="form-control" id="remarks_id" placeholder="Remarks" value="<?php echo $val['conduct_remarks']; ?>" name="conduct_remarksm2[<?php echo $key+1; ?>]" >
							</td>
							<!--<td>
							        <?php 
                                         if($array > $i)
                                       { ?>
                                          <button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                          <?php } else { ?>
                                          <button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    <?php } ?>
							
								
							</td>-->
						</tr>
	<?php $i++; }	?>

					</tbody>
				</table>
				
										<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
					<thead>
					  <tr>
					                       <?php if($m3[0]['quarter'] == 1) {?>
										<th colspan="9" class="qtr" id="m3" style="border-right-color:black;">March</th>
									<?php } else if($m3[0]['quarter'] == 2) { ?>
										<th colspan="9" class="qtr" id="m3" style="border-right-color:black;">June</th>
									<?php } else if($m3[0]['quarter'] == 3) { ?>
										<th colspan="9" class="qtr" id="m3" style="border-right-color:black;">September</th>
									<?php } else if($m3[0]['quarter'] == 4) { ?>
										<th colspan="9" class="qtr" id="m3" style="border-right-color:black;">December</th>
									<?php } else  { ?>
										<th colspan="9" class="qtr" id="m3" style="border-right-color:black;">March</th>
									<?php } ?>
								    <input type="hidden" id="month1" name="monthm3"  value="<?php echo substr($m3[0]['fmonth'],5,6); ?>" >
								</tr>
						<tr>
							<th>S.No.</th>
							<th>Union Council</th>
							<th>Session Type</th>
							<th>Village/HF name</th>
							<th>Conducted</th>
							<th>Date Visit Conduct</th>
							<th>Conduct Remarks</th>
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
							<input type="hidden" value="<?php echo $val['id']; ?>" name="idm3[<?php echo $key+1; ?>]">
							<input type="hidden" value="conduct" name="conduct" >
							<input type="hidden" value="1" name="statusm3[<?php echo $key+1; ?>]" >
							
							<label class="srno-lbl" name="lb[<?php echo $key+1; ?>]"><?php echo$i; ?></label>
							</td>
							<td>
								
								<input type="text" value="<?php echo get_UC_Name($val['uncode']); ?>" readonly id="uncodem3[<?php echo $key+1; ?>]"  name="uncodem3[<?php echo $key+1; ?>]" class="form-control text-center ">
							</td>
							<td>
								
								<input type="text" value="<?php echo $val['session_type']; ?>" readonly id="sessionm3[<?php echo $key+1; ?>]"  name="sessionm3[<?php echo $key+1; ?>]" class="form-control text-center ">
							</td>
							<td class="tds">
							<?php if($val['session_type']=='Fixed'){?>
								<input type="text" value="<?php echo get_Facility_Name($val['area_name']); ?>" readonly id="vilage_hf_namem1[<?php echo $key+1; ?>]"  name="vilage_hf_namem3[<?php echo $key+1; ?>]" class="form-control text-center ">
									<?php } else  { ?>
								   <input type="text" value="<?php echo get_Village_Name($val['area_name']); ?>" readonly id="vilage_hf_namem3[<?php echo $key+1; ?>]"  name="vilage_hf_namem1[<?php echo $key+1; ?>]" class="form-control text-center ">
								    <?php } ?>
		                    </td>
							<td>
								<select required class="form-control conducted" name="conductedm3[<?php echo $key+1; ?>]" >
									 <option   selected="selected" value="">--Select--</option>
									 <option   <?php if($val['is_conducted'] == '1')  echo 'selected="selected"';   ?> value="1">Yes</option>
									 <option   <?php if($val['is_conducted'] == '0')  echo 'selected="selected"';   ?> value="0">No</option>
									<!--<option value="1">Yes</option>
									<option value="0">No</option>-->
								</select>
							</td>
						    <td>
								<input type="text" readonly required class="form-control text-center calendar3" value="<?php echo $val['conduct_date']; ?>" id="visit_date" name="conduct_datem3[<?php echo $key+1; ?>]" >
							</td>
							<td>
								<input type="text" required class="form-control" id="remarks_id" placeholder="Remarks" value="<?php echo $val['conduct_remarks']; ?>" name="conduct_remarksm3[<?php echo $key+1; ?>]" >
							</td>
							<!--<td>
							        <?php 
                                         if($array > $i)
                                       { ?>
                                          <button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                          <?php } else { ?>
                                          <button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    <?php } ?>
							
								
							</td>-->
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
							<!--<button role="button"type="submit" id="submit_form"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Submit Form</button>-->
							<button role="button" type="submit" id="save_form"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Update Form</button>
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
    function addRow(obj){
				var row = $(obj).closest("tr").clone(true);
			    row.find('input').val('');
			   row.find('select').each(function(){
					$(this).find('option:first').prop('selected',true);
				}); 
				/*var lastRowIndex = $('#trRow').find('tr:last').index();
			    console.log(lastRowIndex);
				var currentIndex = lastRowIndex+1; */
					row.find("td:nth-child(1)").find('label').val('');
					row.find("td:nth-child(2)").find('select').val('');
					row.find("td:nth-child(3)").find('select').val('');
					row.find("td:nth-child(4)").find('select').val('');
					row.find("td:nth-child(5)").find('input').val('');
					row.find("td:nth-child(6)").find('input').val('');
				$(obj).closest("tr").after(row);
				$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
				$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
				reindex_serialnumber_and_trainingCompleted();
				
	}
    function deleteRow(obj) {
				/* $(obj).closest("tr").remove();
				reindex_serialnumber_and_trainingCompleted(); */
			var index = $('#trRow').find('tr:last').index();
		  $(obj).closest("tr").remove();
			if(index=='1'){
				$('#trRow').find('tr:last').find('td:last').html('<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}else{
				$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			}
		  reindex_serialnumber_and_trainingCompleted();
	}
	    function addRow1(obj){
				var row = $(obj).closest("tr").clone(true);
			    row.find('input').val('');
			   row.find('select').each(function(){
					$(this).find('option:first').prop('selected',true);
				}); 
				/*var lastRowIndex = $('#trRow').find('tr:last').index();
			    console.log(lastRowIndex);
				var currentIndex = lastRowIndex+1; */
					row.find("td:nth-child(1)").find('label').val('');
					row.find("td:nth-child(2)").find('select').val('');
					row.find("td:nth-child(3)").find('select').val('');
					row.find("td:nth-child(4)").find('select').val('');
					row.find("td:nth-child(5)").find('input').val('');
					row.find("td:nth-child(6)").find('input').val('');
				$(obj).closest("tr").after(row);
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
		    function addRow2(obj){
				var row = $(obj).closest("tr").clone(true);
			    row.find('input').val('');
			   row.find('select').each(function(){
					$(this).find('option:first').prop('selected',true);
				}); 
				/*var lastRowIndex = $('#trRow').find('tr:last').index();
			    console.log(lastRowIndex);
				var currentIndex = lastRowIndex+1; */
					row.find("td:nth-child(1)").find('label').val('');
					row.find("td:nth-child(2)").find('select').val('');
					row.find("td:nth-child(3)").find('select').val('');
					row.find("td:nth-child(4)").find('select').val('');
					row.find("td:nth-child(5)").find('input').val('');
					row.find("td:nth-child(6)").find('input').val('');
				$(obj).closest("tr").after(row);
				$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
				$('#trRow2').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
				reindex_serialnumber_and_trainingCompleted2();
				
	}
    function deleteRow2obj() {
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
		/* $('.srno').each(function(i,v){
				$(this).val(parseInt(i)+1);
	    });
		$('.srno-lbl').each(function(i,v){
				$(this).text(parseInt(i)+1);
		}); */
		$('#trRow > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('select').attr('name','uncodem1['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','sessionm1['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','vilage_hf_namem1['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','datedm1['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('name','remarksm1['+i+']');
			
		});
	}
	    function reindex_serialnumber_and_trainingCompleted1(){
		/* $('.srno').each(function(i,v){
				$(this).val(parseInt(i)+1);
	    });
		$('.srno-lbl').each(function(i,v){
				$(this).text(parseInt(i)+1);
		}); */
		$('#trRow1 > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('select').attr('name','uncodem2['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','sessionm2['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','vilage_hf_namem2['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','datedm2['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('name','remarksm2['+i+']');
			
		});
	}
	    function reindex_serialnumber_and_trainingCompleted2(){
		/* $('.srno').each(function(i,v){
				$(this).val(parseInt(i)+1);
	    });
		$('.srno-lbl').each(function(i,v){
				$(this).text(parseInt(i)+1);
		}); */
		$('#trRow1 > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('select').attr('name','uncodem3['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','sessionm3['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','vilage_hf_namem3['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','datedm3['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('name','remarksm3['+i+']');
			
		});
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
					//alert(result);
					//console.log(result)
				  //$('.vilage_hf_name').html(result);
				//$(this).find('tr').closest(".vilage_hf_name").html(result);	
				//$("#trRow").find("td:nth-child(3)").find('select').html(result);
                $(selectedobj).closest("tr").find("td:nth-child(4)").find('select').html(result);					
				}
			});
			
			
			
			
			//if($(this).closest('tr').find('.session_type').val() == 'Fixed') {
				/* $(this).closest('tr').find('.tdv').show();
				$(this).closest('tr').find('.tds').hide(); */
			//	alert("Fixed");
			//} 
			//if ($(this).closest('tr').find('.session_type').val() == 'Outreach'){
			  /*  $(this).closest('tr').find('.tds').show();
			   $(this).closest('tr').find('.tdv').hide(); */
			  // 				alert("Outreach");
			//} 
			//if ($(this).closest('tr').find('.session_type').val() == 'Mobile'){
			  /*  $(this).closest('tr').find('.tds').show();
			   $(this).closest('tr').find('.tdv').hide(); */
			 //  				alert("Mobile");
			//} 
        });	
	});
</script>
<script type="text/javascript">
	// <!--For quarter--->	
	$(document).ready(function(){
		 // var options = {
			// 	format : "yyyy-mm-dd",
			// 	todayHighlight: true,
			// 	autoclose: true,
			// 	color: "green"
			// };
			// $('.calendar1').datepicker(options);
			// });	
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var qua = $("#month_id").find("option:selected").val();
		var year = $("#year_id").find("option:selected").val();
		if(qua == 'Quarter 1'){
				var month1 = '01';
				var month2 = '02';
				var month3 = '03';
		}else if(qua == 'Quarter 2'){
				var month1 = '04';
				var month2 = '05';
				var month3 = '06';
		}else if(qua == 'Quarter 3'){
				var month1 = '07';
				var month2 = '08';
				var month3 = '09';
		}else if(qua == 'Quarter 4'){
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
	});
</script>
		</body>
</html>