<!DOCTYPE html>
	<html>
		<head>
			<title>EPI-MIS Facility Status</title>
		</head> 
		<?php if (! $this -> input -> post('export_excel')) { ?>
			<div class="row" style="background: white;position: relative;top: -30px;text-align: right">
				<div class="col-xs-10"></div>	
				<?php echo $data['exportIcons']; ?>		
			</div>
		<?php } ?>
		<div class="container">
			<div class="row">
				<div class="panel panel-primary">		
					<div class="panel-heading">Supervisory Micro Plan</div>
					<div class="panel-body">
						<!-- it is used for showing message -->
						<form class="form-inline table-supervisor" method="post" action="<?php echo base_url();?>micro_plan/Micro_plan_controller/supervisory_plan_save"  >
							<div class="row">
								<div class="col-md-3">
									<label for="Supervisor_designation">Supervisor Designation:</label>
								</div>
								<div class="col-md-3">					
									<?php
										$i=1;
										foreach($m1 as $row=>$val){ ?>
										<?php echo $val['designation']; ?>
									<?php if($i==1) break; } ?>					
								</div>
								<div class="col-md-3">
									<label for="Supervisor_Name">Supervisor Name:</label>
								</div>
								<div class="col-md-3">						
									<?php
										$i=1;
										foreach($m1 as $row=>$val){ 
									?>
									
									<?php
										if(isset($val)){
											echo get_supervisor_Name($val['supervisorcode']); 
										}
									?>							
									<?php if($i==1) break; } ?>						
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<label for="ReportYear">Year:</label>
								</div>
								<div class="col-md-3">						
									<?php echo substr($m1[0]['fmonth'],0,4); ?>
								</div>
								<div class="col-md-3">
									<label for="MonthList">Quarter:</label>
								</div>
								<div class="col-md-3">	
								   <?php echo $m1[0]['case']; ?>
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
										<th>Date Visit Planned</th>
										<th>Remarks</th>
										<th>Conduct</th>
										<th>Date Visit Conduct</th>
										<th>Conduct Remarks</th>
									</tr>
								</thead>
								<tbody id="trRow">
									<?php 
										$i=1;
										$array=count($m1);
										foreach($m1 as $key=>$val){ 
									?>
									<tr>
										<td>
											<label class="srno-lbl" name="lb[]"><?php echo$i; ?></label>
										</td>
										<td>
											<p class="uncode" name="uncodem1[]"><?php echo get_UC_Name($val['uncode']); ?></p>
										</td>
										<td>
											<p class="session_type" name="sessionm1[]"><?php echo $val['session_type']; ?></p>
										</td>								
										<td class="tds">
											<!--<p class="vilage_hf_name" name="vilage_hf_namem3[]"><?php echo get_Village_Name($val['area_name']); ?></p>-->
											<?php if($val['session_type']=='Fixed'){?>
											<p class="vilage_hf_name" name="vilage_hf_namem1[]"><?php echo get_Facility_Name($val['area_name']); ?></p>	
		                                   <?php } else  { ?>
										    <p class="vilage_hf_name" name="vilage_hf_namem1[]"><?php echo get_Village_Name($val['area_name']); ?></p>
										   <?php } ?>
										</td>
										<td>
											<p class="dated" name="datedm1[]"><?php echo $val['planned_date']; ?></p>
										</td>
										<td>
											<p class="dated" name="remarksm1[]"><?php echo $val['remarks']; ?></p>
										</td>
										<td>
											<p class="session_type" name="sessionm1[]"><?php if($val['is_conducted'] == 1){echo "Yes";}elseif($val['is_conducted'] == 0){echo "NO";}else{echo "";}  ?></p>
										</td>
										<td>
											<p class="dated" name="datedm1[]"><?php echo $val['conduct_date']; ?></p>
										</td>
										<td>
											<p class="dated" name="remarksm1[]"><?php echo $val['conduct_remarks']; ?></p>
										</td>								
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
								<th>Date Visit Planned</th>
								<th>Remarks</th>
								<th>Conduct</th>
								<th>Date Visit Conduct</th>
								<th>Conduct Remarks</th>
							</tr>
						</thead>
						<tbody id="trRow1">
							<?php 
								$i=1;
								$array=count($m2);
								foreach($m2 as $key=>$val){ 
						    ?>
							<tr>
								<td>
									<label class="srno-lbl" name="lb[]"><?php echo$i; ?></label>
								</td>
								<td>
									<p class="uncode" name="uncodem2[]"><?php echo get_UC_Name($val['uncode']); ?></p>
								</td>
								<td>
									<p class="session_type" name="sessionm2[]"><?php echo $val['session_type']; ?></p>
								</td>
								
								<td class="tds">
									<!--<p class="vilage_hf_name" name="vilage_hf_namem3[]"><?php echo get_Village_Name($val['area_name']); ?></p>-->
									<?php if($val['session_type']=='Fixed'){?>
									<p class="vilage_hf_name" name="vilage_hf_namem2[]"><?php echo get_Facility_Name($val['area_name']); ?></p>	
                                   <?php } else  { ?>
								    <p class="vilage_hf_name" name="vilage_hf_namem2[]"><?php echo get_Village_Name($val['area_name']); ?></p>
								   <?php } ?>		
								</td>
								<td>
									<p class="dated" name="datedm2[]"><?php echo $val['planned_date']; ?></p>
								</td>
								<td>
									<p class="dated" name="remarksm2[]"><?php echo $val['remarks']; ?></p>
								</td>
								<td>
									<p class="session_type" name="sessionm2[]"><?php if($val['is_conducted'] == 1){echo "Yes";}elseif($val['is_conducted'] == 0){echo "NO";}else{echo "";}  ?></p>
								</td>
								<td>
									<p class="dated" name="datedm2[]"><?php echo $val['conduct_date']; ?></p>
								</td>
								<td>
									<p class="dated" name="remarksm2[]"><?php echo $val['conduct_remarks']; ?></p>
								</td>								
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
							<th>Date Visit Planned</th>
							<th>Remarks</th>
							<th>Conduct</th>
							<th>Date Visit Conduct</th>
							<th>Conduct Remarks</th>
						</tr>
					</thead>
					<tbody id="trRow2">
						<?php 
							$i=1;
							$array=count($m3);
							foreach($m3 as $key=>$val){ 
						?>
						<tr>
							<td>
								<label class="srno-lbl" name="lb[]"><?php echo$i; ?></label>
							</td>
							<td>
								<p class="uncode" name="uncodem3[]"><?php echo get_UC_Name($val['uncode']); ?></p>
							</td>
							<td>
								<p class="session_type" name="sessionm3[]"><?php echo $val['session_type']; ?></p>
							</td>								
							<td class="tds">
								<!--<p class="vilage_hf_name" name="vilage_hf_namem3[]"><?php echo get_Village_Name($val['area_name']); ?></p>-->
								<?php if($val['session_type']=='Fixed'){?>
								<p class="vilage_hf_name" name="vilage_hf_namem3[]"><?php echo get_Facility_Name($val['area_name']); ?></p>	
                               <?php } else  { ?>
							    <p class="vilage_hf_name" name="vilage_hf_namem3[]"><?php echo get_Village_Name($val['area_name']); ?></p>
							   <?php } ?>
							</td>
							<td>
								<p class="dated" name="datedm3[]"><?php echo $val['planned_date']; ?></p>
							</td>
							<td>
								<p class="dated" name="remarksm3[]"><?php echo $val['remarks']; ?></p>
							</td>
							<td>
								<p class="session_type" name="sessionm3[]"><?php if($val['is_conducted'] == 1){echo "Yes";}elseif($val['is_conducted'] == 0){echo "NO";}else{echo "";}  ?></p>
							</td>
							<td>
								<p class="dated" name="datedm3[]"><?php echo $val['conduct_date']; ?></p>
							</td>
							<td>
								<p class="dated" name="remarksm3[]"><?php echo $val['conduct_remarks']; ?></p>
							</td>								
						</tr>
						<?php $i++; } ?>
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
						<!-- 07-12-2017 -->
						<?php echo date('d-m-Y'); ?>
					</label>
				</div>
				<div class="row">
					<div class="col-md-11">
						<div class="save_cancel">
							<?php 
						 		if($filter_view == 1) { ?>							
									<a href="<?php echo base_url();?>Compliance-Filter/HF-Supervisoryplan">	<button type="button" id="form_cancel"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
								<?php } else { ?>
									<a href="<?php echo base_url();?>micro_plan/Micro_plan_controller/supervisory_plan">	<button type="button" id="form_cancel"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
							<?php } ?>						
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
				var lastRowIndex = $('#trRow').find('tr:last').index();
			    console.log(row);
				var currentIndex = lastRowIndex+1;
				    row.find("td:nth-child(1)").find('label').attr('name','lb['+currentIndex+']');
					row.find("td:nth-child(1)").find('label').val('');
					row.find("td:nth-child(2)").find('select').attr('name','uncode['+currentIndex+']');
					row.find("td:nth-child(2)").find('select').val('0');
					row.find("td:nth-child(3)").find('select').attr('name','session['+currentIndex+']');
					row.find("td:nth-child(3)").find('select').val('0');
					row.find("td:nth-child(4)").find('input').attr('name','vilage_hf['+currentIndex+']');
					row.find("td:nth-child(4)").find('input').val('');
					row.find("td:nth-child(5)").find('select').attr('name','vilage_hf_name['+currentIndex+']');
					row.find("td:nth-child(5)").find('select').val('0');
					row.find("td:nth-child(6)").find('input').attr('name','dated['+currentIndex+']');
					row.find("td:nth-child(6)").find('input').val('');
					row.find("td:nth-child(7)").find('select').attr('name','conducted['+currentIndex+']');
					row.find("td:nth-child(7)").find('select').val('');
					row.find("td:nth-child(8)").find('input').attr('name','remarks['+currentIndex+']');
					row.find("td:nth-child(8)").find('input').val('');
				$(obj).closest("tr").after(row);
				$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
				reindex_serialnumber_and_trainingCompleted();
				
	}
    function deleteRow(obj) {
				$(obj).closest("tr").remove();
				reindex_serialnumber_and_trainingCompleted();
	}
    function reindex_serialnumber_and_trainingCompleted(){
		$('.srno').each(function(i,v){
				$(this).val(parseInt(i)+1);
	    });
		$('.srno-lbl').each(function(i,v){
				$(this).text(parseInt(i)+1);
		});
	}
   /*  $(document).ready(function(){
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
   

</script>
		</body>
</html>