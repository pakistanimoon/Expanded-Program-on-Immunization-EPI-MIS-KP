<?php 
//live backup
	//print_r($data);
	//echo $datefromReport;  exit(); 
	$caseTypePagination = $this-> input-> get_post('case_type');
	//echo $caseTypePagination;
?>
<div class="" style="font-size:12px;">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"> Line List of Suspected Cases</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<table class="table table-bordered table-striped table-hover mytable">
						<tr>
							<td><label>Province/Region</label></td>
							<!-- <td><?php echo $provName; ?></td> -->
							<td><?php echo $this -> session -> provincename ?></td>
							<td><label>District</label></td>
							<td><?php echo $districtName; ?></td>
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
							<?php if ((isset($week_from) && $week_from < 1) && (isset($week_to) && $week_to >= 1)) { ?>
								<td><label>Epi Week From</label></td>
								<td><?php echo (isset($week_from))?$year.'-01':''; ?>
								</td>
								<td><label>Epi Week To</label></td>
								<td><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
								</td>
							<?php } else if ((isset($week_from) && $week_from >= 1) && (isset($week_to) && $week_to < 1)) { ?>
								<td><label>Epi Week From</label></td>
								<td><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
								</td>
								<td><label>Epi Week To</label></td>
								<td><?php echo (isset($week_to))?$year.'-'.date('W'):''; ?>
								</td>
							<?php } else if ((isset($week_from) && $week_from >= 1) && (isset($week_to) && $week_to >= 1)) { ?>
								<td><label>Epi Week From</label></td>
								<td><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
								</td>
								<td><label>Epi Week To</label></td>
								<td><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
								</td>
							<?php } ?>
						</tr>
						<tr>
						<?php if((isset($week_from) && $week_from < 1) && (isset($week_to) && $week_to < 1)) { ?>
							<td><label>Year</label></td>
							<td><?php echo $year; ?></td>
						<?php } ?>
						<?php if(isset($week_from) && $week_from < 1 && $year == date('Y')) { ?>
							<td><label>Date From</label></td>
							<td id="datefrom"><?php echo "31-Dec-".(date('Y') - 1); ?>
							</td>
						<?php } else { ?>							
							<td><label>Date From</label></td>
							<td id="datefrom"><?php echo (isset($datefromReport))?$datefromReport:''; ?>
							</td>
						<?php } ?>
						<?php if(isset($week_to) && $week_to < 1 && $year < date('Y')) { ?>
							<td><label>Date To</label></td>
							<td id="dateto"><?php echo "31-Dec-".$year; ?>
							</td>
						<?php } else { ?>	
							<td><label>Date To</label></td>
							<td id="dateto"><?php echo (isset($datetoReport))?$datetoReport:''; ?>
							</td>
						<?php } ?>
						</tr> 
					</table>
					<div id="parent">      
						<table id="fixTable" class="table table-bordered table-condensed table-striped table-hover mytable">
							<thead>
								<tr>
								<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ ?>
									<th rowspan="2">Action</th>
								<?php }?>
									<th rowspan="2">Sr #</th>
									<th rowspan="2">Reporting Province/Area</th>
									<th rowspan="2">Reporting Epi Week</th>
									<th rowspan="2">Reporting Month/Year</th>
									<th rowspan="2">Name of reporting HF</th>
									<th rowspan="2">Reporting district</th>
									<th rowspan="2">Epid number</th>
									<th rowspan="2">Name of the case</th>
									<th rowspan="2">Father's name</th>
									<th rowspan="2">Contact number</th>
									<!-- <th colspan="5">Address of the case</th> -->
									<th rowspan="2">Village/mahalla</th>
									<th rowspan="2">UC</th>
									<th rowspan="2">Tehsil/Taluka/Town</th>
									<th rowspan="2">District</th>
									<th rowspan="2">Age in Month</th>
									<th rowspan="2">Sex</th>
									<?php
									if($this -> uri -> segment(6) == 'Msl' || $caseTypePagination == 'Msl'){ 
									//if($this -> uri -> segment(6) == 'Msl'){ ?>
									<th rowspan="2">D/rash onset</th>
									<?php } else if ($this -> uri -> segment(6) == 'Diph' ){ ?>
									<th rowspan="2">D/adherent membrance onset</th>
									<?php } else { ?>
									<th rowspan="2">D/onset</th>
									<?php } ?>	
									<th rowspan="2">D/notification</th>
									<th rowspan="2">D/investigation</th> 
									<?php
									if($this -> uri -> segment(6) == 'Msl' || $caseTypePagination == 'Msl'){ ?>
									<th rowspan="2">Total number of msl vaccine doses received</th>
									<th rowspan="2">D/last dose of msl vaccine received</th>
									<?php } else { ?>
									<th rowspan="2"># of Vaccine doses received</th>
									<th rowspan="2">Date of last vaccine dose</th>
									<?php } ?>									
									<!-- <th rowspan="2">Date of Specimen Collection</th>
									<th rowspan="2">Type of Specimen</th>
									<th rowspan="2">Date Specimen Sent to Lab</th> 
									<th rowspan="2">Date Specimen Received in Lab</th> -->
									<?php
									if($this -> uri -> segment(6) == 'Msl' || $caseTypePagination == 'Msl'){ ?>
									<!-- <th rowspan="2">Date of Specimen-I (SERUM) collection</th>
									<th rowspan="2">Date of Specimen-II (THROAT SWAB) collection</th> -->
									<th rowspan="2">Type of specimen</th>
									<th rowspan="2">Date of specimen collection</th>
									<?php } ?>
									<th rowspan="2">D/specimen received in lab</th>
									<th colspan="2">Condition of Specimen</th>
									<th rowspan="2">Date of results received by the district</th>
									<th rowspan="2">Lab ID number</th>
									<th rowspan="2">D/report sent</th>
									<th rowspan="2">H/o travel during 21 days prior to rash onset</th>
									<th rowspan="2">Clinical Presentation of the case</th>
									<th rowspan="2">Complications</th>
									<th rowspan="2">Outcome</th>
									<!-- <th rowspan="2">Date of Specimen Collection</th>
									<th rowspan="2">Type of Specimen</th>
									<th rowspan="2">Date Specimen Sent to Lab</th> 
									<th rowspan="2">Lab result</th> -->
									<!-- <th rowspan="2">EPI Linked (Msl/Rub/N0)</th> -->
									<?php if($this -> uri -> segment(6) == 'Msl' || $caseTypePagination == 'Msl') { ?>
										<th rowspan="2">Lab Result Measles</th>
										<th rowspan="2">Lab Result Rubella</th>
										<th rowspan="2">Epi linked (Msl/Rub/No)</th>
										<th rowspan="2">Final classification</th>
									<?php } ?>
									<!-- <th rowspan="2">Action</th> -->
								</tr>
								<tr>
									<!-- <th>Village/muhalla</th>
									<th>UC</th>
									<th>Tehsil/Taluka</th>
									<th>District</th>
									<th>Province/Area</th> -->
									<th>Quantity Adequate</th>
									<th>Cold Chain OK</th>
									<!-- <th>Measles</th>
									<th>Rubella</th> --> 
									<!-- <th>Edit</th>
									<th>View</th> -->                             
								</tr>           
							</thead>
							<tbody>        
							<?php 
								$previousWeekNumber = 0;
								$startpoint = isset($startpoint)?$startpoint:0;
								//print_r($measles);exit();
								foreach($measles as $key => $row){						
									if($row['patient_gender']=='1')       
										$patient_gender= 'Male';           
									else if($row['patient_gender']=='0')      
										$patient_gender= 'Female';                
									else                          
										$patient_gender= '';
								?>
								<tr class="DrillDownRow">
									<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ ?>
										<?php if($row['case_type']=='Msl') {?>
											<td>
												<!-- <a href="<?php //echo base_url(); ?>Measles_investigation/measles_investigation_view/<?php //echo $row['id']; ?>/<?php //echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a> -->	
												<a href="<?php echo base_url(); ?>Measles_investigation/measles_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
											</td>										
										<?php } else { ?>
											<td>
												<!-- <a href="<?php //echo base_url(); ?>Case_investigation/case_investigation_view/<?php //echo $row['id']; ?>/<?php //echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a> -->
												<a href="<?php echo base_url(); ?>Case_investigation/case_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
											</td>										
										<?php } ?>
									<?php } ?>	
									<td data-id="<?php echo $row['id']; ?>" data-year="<?php echo $row['year']; ?>" data-casetype="<?php echo $row['case_type']; ?>"><?php echo ++$startpoint; ?></td>
									<td><?php echo (isset($row['rb_distcode']) && $row['rb_distcode'] != '')?get_Province_Name(substr($row['rb_distcode'],0,1)):$row['province']; ?></td>
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
									<!-- <td><?php //echo $row['province']; ?></td> --> 
									<td><?php echo $row['age_months']; ?></td> 
									<td><?php echo $patient_gender; ?></td>
									<td><?php echo isset($row['date_rash_onset']) ? date('d-M-Y',strtotime($row['date_rash_onset'])) :'-'; ?></td>  
									<td><?php echo isset($row['notification_date']) ? date('d-M-Y',strtotime($row['notification_date'])) :'-'; ?></td>  
									<td><?php echo isset($row['pvh_date']) ? date('d-M-Y',strtotime($row['pvh_date'])) :'-'; ?></td>
									<td><?php echo $row['doses_received']; ?></td> 
									<td><?php echo isset($row['last_dose_date']) ? date('d-M-Y',strtotime($row['last_dose_date'])) : '-'; ?></td> 
									<?php if(isset($this -> uri -> segment(6)) && ($this -> uri -> segment(6) == 'Msl' || $caseTypePagination == 'Msl')){ ?>
										<td><?php echo $row['type_specimen']; ?></td>
										<td><?php echo isset($row['date_collection']) ? date('d-M-Y',strtotime($row['date_collection'])) : '-';?></td>
									<?php } ?>
									<td><?php echo isset($row['specimen_received_date']) ? date('d-M-Y',strtotime($row['specimen_received_date'])) : '-';?></td> 
									<!-- <td><?php echo isset($row['date_collection']) ? date('d-M-Y',strtotime($row['date_collection'])) : '-';?></td> 
									<td><?php echo $row['type_specimen']; ?></td>
									<td><?php echo isset($row['date_sent_lab']) ? date('d-M-Y',strtotime($row['date_sent_lab'])) : '';?></td>   
									<td><?php echo isset($row['specimen_received_date']) ? date('d-M-Y',strtotime($row['specimen_received_date'])) : '-';?></td> --> 
									<td><?php echo (($row['quantity_adequate']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['cold_chain_ok']==1)?"Yes":"No"); ?></td> 
									<td><?php //echo $row['lab_id_number']; ?></td> 
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
									<!-- <td><?php echo isset($row['date_collection']) ? date('d-M-Y',strtotime($row['date_collection'])) : '-';?></td> 
									<td><?php echo (($row['type_specimen'] == 'None')?"Not Collected":$row['type_specimen']); ?></td>
									<td><?php echo isset($row['date_sent_lab']) ? date('d-M-Y',strtotime($row['date_sent_lab'])) : '';?></td>   
									
									<td><?php echo $row['specimen_result']; ?></td> -->
									<?php if($row['case_type'] == 'Msl' || $caseTypePagination == 'Msl') { ?>
										<td>
											<?php 
												if($row['specimen_result'] == 'Positive Measles' || $row['clinically_compatible_with'] == 'Measles' || $row['linked_epid_number'] != '') {
													echo "Positive Measles";
											  	}
											  	else if($row['specimen_result'] == 'Negative Measles') {
													echo "Negative Measles";
											  	}
											  	else if($row['specimen_result'] == 'Positive Rubella' || $row['clinically_compatible_with'] == 'Rubella' || $row['specimen_result'] == 'Negative Rubella' || $row['specimen_result'] == '') {
													echo "";
											  	}
												else{
													echo "Result Awaited";
											  	}
											?>
										</td>
										<td>
											<?php 
												if($row['specimen_result'] == 'Positive Rubella' || $row['clinically_compatible_with'] == 'Rubella') {
													echo "Positive Rubella";
											  	}
											  	else if($row['specimen_result'] == 'Negative Rubella') {
													echo "Negative Rubella";
											  	}
												else if($row['specimen_result'] == 'Positive Measles' || $row['clinically_compatible_with'] == 'Measles' || $row['specimen_result'] == 'Negative Measles' || $row['specimen_result'] == '') {
													echo "";
											  	}
												else{
													echo "Result Awaited";
											  	}
											?>
										</td>
										<td>
											<?php 
												if($row['linked_epid_number'] != '') {
													echo "Msl";
											  	}
												else{
													echo "No";
											  	}
												//echo $row['linked_epid_number'];
											?>
										</td>
										<td>
											<?php 
											if($row['clinically_compatible_with'] != ''){
												if($row['final_classification'] == 'Clinically Compatible'){
													echo 'Clinically Compatible'; echo ' ('; echo $row['clinically_compatible_with']; echo ')';
												}
												else{
													echo $row['final_classification'];
												}
											}												
											?>											
										</td>
									<?php } ?>
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
			 $("#fixTable").tableHeadFixer({"left" : 8}); 
		});
		$('.DrillDownRow').css('cursor','pointer');
		$(document).on('click',".DrillDownRow", function(){
			var ulevel = '<?php echo $_SESSION['UserLevel']; ?>';
			if(ulevel==3){
				var id = $(this).find("td:nth-child(2)").data('id');
				var year = $(this).find("td:nth-child(2)").data('year');
				var casetype = $(this).find("td:nth-child(2)").data('casetype');
			}
			else{
				var id = $(this).find("td:first-child").data('id');
				var year = $(this).find("td:first-child").data('year');
				var casetype = $(this).find("td:first-child").data('casetype');
			}
			var url = '';
			if(casetype == 'Msl'){
				url = "<?php echo base_url();?>Measles_investigation/measles_investigation_view/"+id+"/"+year;
			}
			else{
				url = "<?php echo base_url();?>Case_investigation/case_investigation_view/"+id+"/"+year;
			}			       
			var win = window.open(url,'_blank');
			if(win){
				//Browser has allowed it to be opened
				win.focus();
			}
			else{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			}
		});
	/*  */
    </script>
<?php } exit; ?> 