<div class="" style="font-size:12px;">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"> Line List of Suspected Cases</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<table class="table table-bordered   table-striped table-hover  mytable">
						<tr>
							<td><label>Province/Area</label></td>
							<td><?php echo $this -> session -> provincename ?></td>
							<td><label>District</label></td>
							<td><?php echo $districtName; ?></td>
							<td><label>Union Council</label></td>
							<?php if($this-> uri-> segment(9) == "outbreak"){ ?>
								<td><?php echo get_UC_Name($pa_uncode); ?></td>
							<?php } else { ?>                           
								<td><?php echo $ucName; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td><label># of Reporting Unit</label></td>
							<td><?php if(isset($allReportingFLCF)){ echo $allReportingFLCF; } ?></td>
							<td><label>Case Type:</label></td>                           
							<td>
							<?php if($this-> input-> post('case_type')){ ?> 
							<label><?php echo get_CaseType_Name($this-> input-> post('case_type')); ?></label>	
							<?php }else{ ?>
							<label><?php echo $this -> uri -> segment(6); ?></label>	
							<?php } ?>                           
							</td>						   						   
							<td><label># of Reported Cases</label></td>
							<td><?php if(isset($ReportingFLCF)){ echo $ReportingFLCF; } ?></td>  
						</tr>
						<tr>
							<!--<td><label>Year</label></td>
							<td><?php// echo $year; ?></td>
							<td><label>EPI Week No</label></td>
							<td><?php// echo $week; ?></td><td>-->
							<td><label>Epi Week From</label></td>
            <td><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
			</td>
			<td><label>Epi Week To</label></td>
            <td><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
			</td>
						</tr>
					</table>
					<div id="parent">      
						<table id="fixTable" class="table table-bordered table-condensed table-striped table-hover mytable">
							<thead>
								<tr>
									<th rowspan="2">S #</th>
									<th rowspan="2">Reporting EPI Week</th>
									<th rowspan="2">Reporting Year</th>
									<th rowspan="2">Reporting HF</th>
									<th rowspan="2">Reporting District</th>
									<th rowspan="2">EPID Number</th>
									<th rowspan="2">Name of Case</th>
									<th rowspan="2">Father's Name</th>
									<th rowspan="2">Contact Number</th>
									<th colspan="5">Address of the Case</th>
									<th rowspan="2">Age in Months</th>
									<th rowspan="2">Gender</th>
									<th rowspan="2">Date of Rash Onset</th>
									<th rowspan="2">Date of Notification</th>
									<th rowspan="2">Date of Investigation</th>                              
									<th rowspan="2"># of Vaccine doses received</th>
									<th rowspan="2">Date of last vaccine dose</th>
									<th rowspan="2">Date of Specimen Collection</th>
									<th rowspan="2">Type of Specimen</th>
									<th rowspan="2">Date Specimen Sent to Lab</th> 
									<th rowspan="2">Date Specimen Received in Lab</th>
									<th colspan="2">Condition of Specimen</th>
									<th rowspan="2">Lab ID Number</th>
									<th rowspan="2">Date Report Sent</th>
									<th rowspan="2">History of Travel during 21 days prior to rash onset</th>
									<th rowspan="2">Clinical Presentation of the case</th>
									<th rowspan="2">Complications</th>
									<th rowspan="2">Outcome</th>
									<th colspan="2">Lab result</th>
									<th rowspan="2">EPI Linked (Msl/Rub/N0)</th>
									<th rowspan="2">Final Classification</th>
								</tr>
								<tr>
									<th>Village/muhalla</th>
									<th>UC</th>
									<th>Tehsil/Taluka</th>
									<th>District</th>
									<th>Province/Area</th>
									<th>Quantity Adequate</th>
									<th>Cold Chain OK</th>
									<th>Measles</th>
									<th>Rubella</th>                              
								</tr>             
							</thead>
							<tbody>        
								<?php          
								$previousWeekNumber = 0;
								$startpoint = isset($startpoint)?$startpoint:0;
								foreach($measles as $key => $row){						
									if($row['patient_gender']=='1')       
										$patient_gender= 'Male';           
									else if($row['patient_gender']=='0')      
										$patient_gender= 'Female';                
									else                          
										$patient_gender= '';
								?>
								<tr class="DrillDownRow">
									<td data-id="<?php echo $row['id']; ?>" data-year="<?php echo $row['year']; ?>"><?php echo ++$startpoint; ?></td> 
									<td><?php echo sprintf('%02d',$row['week']); ?></td>
									<td><?php echo $row['year']; ?></td>  
									<td><?php echo $row['facility']; ?></td>
									<td><?php echo (isset($row['rb_district']) && $row['rb_district'] != '')?$row['rb_district']:$row['patient_district']; ?></td>
									<td><?php echo $row['case_epi_no']; ?></td>
									<td><?php echo $row['patient_name']; ?></td>  
									<td><?php echo $row['patient_fathername']; ?></td>
									<td><?php echo $row['contact_numb']; ?></td> 
									<td><?php echo $row['patient_address']; ?></td>
									<td><?php echo $row['patient_unname']; ?></td> 
									<td><?php echo $row['patient_tehsil']; ?></td>
									<td><?php echo $row['patient_district']; ?></td> 
									<td><?php echo $row['province']; ?></td> 
									<td><?php echo $row['age_months']; ?></td> 
									<td><?php echo $patient_gender; ?></td>
									<td><?php echo isset($row['date_rash_onset']) ? date('d-M-Y',strtotime($row['date_rash_onset'])) :'-'; ?></td>  
									<td><?php echo isset($row['notification_date']) ? date('d-M-Y',strtotime($row['notification_date'])) :'-'; ?></td>  
									<td><?php echo isset($row['pvh_date']) ? date('d-M-Y',strtotime($row['pvh_date'])) :'-'; ?></td>
									<td><?php echo $row['doses_received']; ?></td> 
									<td><?php echo isset($row['last_dose_date']) ? date('d-M-Y',strtotime($row['last_dose_date'])) : '-'; ?></td>  
									<td><?php echo isset($row['date_collection']) ? date('d-M-Y',strtotime($row['date_collection'])) : '-';?></td> 
									<td><?php echo $row['type_specimen']; ?></td>
									<td><?php echo isset($row['date_sent_lab']) ? date('d-M-Y',strtotime($row['date_sent_lab'])) : '';?></td>   
									<td><?php echo isset($row['specimen_received_date']) ? date('d-M-Y',strtotime($row['specimen_received_date'])) : '-';?></td> 
									<td><?php echo (($row['quantity_adequate']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['cold_chain_ok']==1)?"Yes":"No"); ?></td>  
									<td><?php echo $row['lab_id_number']; ?></td>
									<td><?php echo isset($row['lab_report_sent_date']) ? date('d-M-Y',strtotime($row['lab_report_sent_date'])) : '';?></td> 
									<td><?php echo (($row['travel_history']==1)?"Yes":"No"); ?></td>
									<td><?php echo $row['clinical_representation']; ?></td>
									<td><?php echo $row['complications']; ?></td>
									<td>
									   <?php 
										if($row['outcome'] != '' && $row['outcome'] != '0') {
											echo $row['outcome'];
									  	}
										else{
												echo "-";
										  	}
									   ?>                            
									</td>
									<td>
									   <?php 
										  	if($row['specimen_result'] == 'Positive Measles') 
												{echo "Positive";}
										  	elseif($row['specimen_result'] == 'Negative Measles')
												{echo "Negative";}
										  	else
												echo "-";
									   ?>                               
									</td>
									<td>
									   <?php 
										  	if($row['specimen_result'] == 'Positive Rubella') 
												{echo "Positive";}
										  	elseif($row['specimen_result'] == 'Negative Rubella')
												{echo "Negative";}
										  	else
												echo "-";
									   ?>                            
									</td>
									<td><?php echo "-"; ?></td>
									<td><?php echo "-"; ?></td>
								</tr>
								<?php } ?>    
							</tbody>
						</table>
					</div>
					<?php if(isset($pagination)){ ?>
						<div class="row">
								<div class="col-sm-12" align="center">
									<div id="paging">
										<?php 
										// displaying paginaiton.
										echo $pagination;
										?> 
									</div>
								</div>
						</div>
					<?php } ?>
					<div class="row">
						<div class="col-sm-4">
							<table class="table table-bordered table-striped">
								<tbody>
									<tr>
										<td><label>Compiled by</label></td>
									</tr>
									<tr>
										<td><label>Name</label></td>
										<td><?php if(isset($downPortion[0]['name'])){ echo $downPortion[0]['name']; }else{ echo 'Manager'; } ?></td>
									</tr>
									<tr>
										<td><label>Designation</label></td>
										<td><?php if(isset($downPortion[0]['name'])){ echo $downPortion[0]['designation']; }else{ echo 'EPI Manager'; } ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-sm-4"></div>
						<div class="col-sm-4"></div>
					</div>
					<div class="row">
						<hr>
						<div style="text-align: right;" class="col-md-4 col-md-offset-8">
							<label class="text-right">Compiled Date: <?php echo date('d/m/Y'); ?></label>
						</div>
					</div>
				</form>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body--> 
<?php  if(!$this->input->post('export_excel')){ ?>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
   <script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript">
		$(document).ready(function() {
			 $("#fixTable").tableHeadFixer({"left" : 7}); 
		});
		  $('.DrillDownRow').css('cursor','pointer');
		  $(document).on('click',".DrillDownRow", function(){
			 var id = $(this).find("td:first-child").data('id');
			 var year = $(this).find("td:first-child").data('year');
			 var url = '';
			 url = "<?php echo base_url();?>Case_investigation/case_investigation_view/"+id+"/"+year;       
			 var win = window.open(url,'_self');
			 if(win){
				//Browser has allowed it to be opened
				win.focus();
			 }
			 else{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			 }
		  });
   </script>
<?php } exit; ?> 