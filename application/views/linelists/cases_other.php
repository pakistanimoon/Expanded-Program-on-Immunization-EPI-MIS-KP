<?php 
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
							<td style="text-align:center; border: 1px solid black; "><label>Province/Region</label></td>
							<!-- <td><?php echo $provName; ?></td> -->
							<td style="text-align:center; border: 1px solid black;"><?php echo $this -> session -> provincename ?></td>
							<td style="text-align:center; border: 1px solid black;"><label>District</label></td>
							<td style="text-align:center; border: 1px solid black;"><?php echo $districtName; ?></td>
						</tr>
						<tr>
							<td style="text-align:center; border: 1px solid black;"><label># of Reporting Unit</label></td>
							<td style="text-align:center; border: 1px solid black;"><?php if(isset($allReportingFLCF)){ echo $allReportingFLCF; } ?></td>
							<td style="text-align:center; border: 1px solid black;"><label>Case Type:</label></td>                           
							<td style="text-align:center; border: 1px solid black;">
							<?php if($this-> input-> post('case_type')){ ?> 
							<label><?php echo get_CaseType_Name($this-> input-> post('case_type')); ?></label>	
							<?php }else{ ?>
							<label><?php echo $this -> uri -> segment(6); ?></label>	
							<?php } ?>                           
							</td>						   						   
							<td style="text-align:center; border: 1px solid black;"><label># of Reported Cases</label></td>
							<td style="text-align:center; border: 1px solid black;"><?php if(isset($ReportingFLCF)){ echo $ReportingFLCF; } ?></td>  
						</tr>
						<tr>							
							<?php if ((isset($week_from) && $week_from < 1) && (isset($week_to) && $week_to >= 1)) { ?>
								<td style="text-align:center; border: 1px solid black;"><label>Epi Week From</label></td>
								<td style="text-align:center; border: 1px solid black;"><?php echo (isset($week_from))?$year.'-01':''; ?>
								</td>
								<td style="text-align:center; border: 1px solid black;"><label>Epi Week To</label></td>
								<td style="text-align:center; border: 1px solid black;"><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
								</td>
							<?php } else if ((isset($week_from) && $week_from >= 1) && (isset($week_to) && $week_to < 1)) { ?>
								<td style="text-align:center; border: 1px solid black;"><label>Epi Week From</label></td>
								<td style="text-align:center; border: 1px solid black;"><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
								</td>
								<td style="text-align:center; border: 1px solid black;"><label>Epi Week To</label></td>
								<td style="text-align:center; border: 1px solid black;"><?php echo (isset($week_to))?$year.'-'.date('W'):''; ?>
								</td>
							<?php } else if ((isset($week_from) && $week_from >= 1) && (isset($week_to) && $week_to >= 1)) { ?>
								<td style="text-align:center; border: 1px solid black;"><label>Epi Week From</label></td>
								<td style="text-align:center; border: 1px solid black;"><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
								</td>
								<td style="text-align:center; border: 1px solid black;"><label>Epi Week To</label></td>
								<td style="text-align:center; border: 1px solid black;"><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
								</td>
							<?php } ?>
						</tr>
						<tr>
						<?php if((isset($week_from) && $week_from < 1) && (isset($week_to) && $week_to < 1)) { ?>
							<td style="text-align:center; border: 1px solid black;"><label>Year</label></td>
							<td style="text-align:center; border: 1px solid black;"><?php echo $year; ?></td>
						<?php } ?>
						<?php if(isset($week_from) && $week_from < 1 && $year == date('Y')) { ?>
							<td style="text-align:center; border: 1px solid black;"><label>Date From</label></td>
							<td style="text-align:center; border: 1px solid black;" id="datefrom"><?php echo "31-Dec-".(date('Y') - 1); ?>
							</td>
						<?php } else { ?>							
							<td style="text-align:center; border: 1px solid black;"><label>Date From</label></td>
							<td style="text-align:center; border: 1px solid black;" id="datefrom"><?php echo (isset($datefromReport))?$datefromReport:''; ?>
							</td>
						<?php } ?>
						<?php if(isset($week_to) && $week_to < 1 && $year < date('Y')) { ?>
							<td style="text-align:center; border: 1px solid black;"><label>Date To</label></td>
							<td style="text-align:center; border: 1px solid black;" id="dateto"><?php echo "31-Dec-".$year; ?>
							</td>
						<?php } else { ?>	
							<td style="text-align:center; border: 1px solid black;"><label>Date To</label></td>
							<td style="text-align:center; border: 1px solid black;" id="dateto"><?php echo (isset($datetoReport))?$datetoReport:''; ?>
							</td>
						<?php } ?>
						</tr>
					</table>
					<div id="parent">      
						<table id="fixTable" class="table table-bordered table-condensed table-striped table-hover mytable">
							<thead>
								<tr>
								<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ ?>
									<th rowspan="2" style="text-align:center; border: 1px solid black;">Action</th>
								<?php }?>
									<th rowspan="2" style="text-align:center; border: 1px solid black; background-color: #008D4C !important; color: #fff !important;">Sr #</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Reporting Province/Area</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Reporting Epi Week</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Reporting Month/Year</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Name of reporting HF</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Reporting district</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Epid number</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Name of the case</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Father's name</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Contact number</th>
									<!-- <th colspan="5">Address of the case</th> -->
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Village/mahalla</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">UC</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Tehsil/Taluka/Town</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">District</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Age in Month</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Sex</th>
									<?php
									if(isset($data['case_type']) == 'Msl' || $caseTypePagination == 'Msl'){ 
									//if($data['case_type'] == 'Msl'){ ?>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">D/rash onset</th>
									<?php } else if ($data['case_type'] == 'Diph' ){ ?>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">D/adherent membrance onset</th>
									<?php } else { ?>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">D/onset</th>
									<?php } ?>	
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">D/notification</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">D/investigation</th> 
									<?php
									if($data['case_type'] == 'Msl' || $caseTypePagination == 'Msl'){ ?>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Total number of msl vaccine doses received</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">D/last dose of msl vaccine received</th>
									<?php } else { ?>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;"># of Vaccine doses received</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Date of last vaccine dose</th>
									<?php } ?>									
									<!-- <th rowspan="2">Date of Specimen Collection</th>
									<th rowspan="2">Type of Specimen</th>
									<th rowspan="2">Date Specimen Sent to Lab</th> 
									<th rowspan="2">Date Specimen Received in Lab</th> -->
									<?php
									if($data['case_type'] == 'Msl' || $caseTypePagination == 'Msl'){ ?>
									<!-- <th rowspan="2">Date of Specimen-I (SERUM) collection</th>
									<th rowspan="2">Date of Specimen-II (THROAT SWAB) collection</th> -->
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Type of specimen</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Date of specimen collection</th>
									<?php } ?>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">D/specimen received in lab</th>
									<th colspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Condition of Specimen</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Date of results received by the district</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Lab ID number</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">D/report sent</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">H/o travel during 21 days prior to rash onset</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Clinical Presentation of the case</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Complications</th>
									<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Outcome</th>
									<!-- <th rowspan="2">Date of Specimen Collection</th>
									<th rowspan="2">Type of Specimen</th>
									<th rowspan="2">Date Specimen Sent to Lab</th> 
									<th rowspan="2">Lab result</th> -->
									<!-- <th rowspan="2">EPI Linked (Msl/Rub/N0)</th> -->
									<?php if($data['case_type'] == 'Msl' || $caseTypePagination == 'Msl') { ?>
										<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Lab Result Measles</th>
										<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Lab Result Rubella</th>
										<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Epi linked (Msl/Rub/No)</th>
										<th rowspan="2" style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Final classification</th>
									<?php } ?>
									<!-- <th rowspan="2">Action</th> -->
								</tr>
								<tr>
									<!-- <th>Village/muhalla</th>
									<th>UC</th>
									<th>Tehsil/Taluka</th>
									<th>District</th>
									<th>Province/Area</th> -->
									<th style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Quantity Adequate</th>
									<th style="text-align:center; border: 1px solid black;background-color: #008D4C !important; color: #fff !important;">Cold Chain OK</th>
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
											<td style="text-align:center; border: 1px solid black;">
												<!-- <a href="<?php //echo base_url(); ?>Measles_investigation/measles_investigation_view/<?php //echo $row['id']; ?>/<?php //echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a> -->	
												<a href="<?php echo base_url(); ?>Measles_investigation/measles_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
											</td>										
										<?php } else { ?>
											<td style="text-align:center; border: 1px solid black;">
												<!-- <a href="<?php //echo base_url(); ?>Case_investigation/case_investigation_view/<?php //echo $row['id']; ?>/<?php //echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a> -->
												<a href="<?php echo base_url(); ?>Case_investigation/case_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
											</td>										
										<?php } ?>
									<?php } ?>	
									<td style="text-align:center; border: 1px solid black;" data-id="<?php echo $row['id']; ?>" data-year="<?php echo $row['year']; ?>" data-casetype="<?php echo $row['case_type']; ?>"><?php echo ++$startpoint; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo (isset($row['rb_distcode']) && $row['rb_distcode'] != '')?get_Province_Name(substr($row['rb_distcode'],0,1)):$row['province']; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo sprintf('%02d',$row['week']); ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['year']; ?></td>  
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['facility']; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo (isset($row['rb_district']) && $row['rb_district'] != '')?$row['rb_district']:$row['patient_district']; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['case_epi_no']; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['patient_name']; ?></td>  
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['patient_fathername']; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['contact_numb']; ?></td> 
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['patient_address']; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['patient_unname']; ?></td> 
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['patient_tehsil']; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['patient_district']; ?></td> 
									<!-- <td><?php //echo $row['province']; ?></td> --> 
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['age_months']; ?></td> 
									<td style="text-align:center; border: 1px solid black;"><?php echo $patient_gender; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo isset($row['date_rash_onset']) ? date('d-M-Y',strtotime($row['date_rash_onset'])) :'-'; ?></td>  
									<td style="text-align:center; border: 1px solid black;"><?php echo isset($row['notification_date']) ? date('d-M-Y',strtotime($row['notification_date'])) :'-'; ?></td>  
									<td style="text-align:center; border: 1px solid black;"><?php echo isset($row['pvh_date']) ? date('d-M-Y',strtotime($row['pvh_date'])) :'-'; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['doses_received']; ?></td> 
									<td style="text-align:center; border: 1px solid black;"><?php echo isset($row['last_dose_date']) ? date('d-M-Y',strtotime($row['last_dose_date'])) : '-'; ?></td> 
									<?php if(isset($data['case_type']) && ($data['case_type'] == 'Msl' || $caseTypePagination == 'Msl')){ ?>
										<td style="text-align:center; border: 1px solid black;"><?php echo $row['type_specimen']; ?></td>
										<td style="text-align:center; border: 1px solid black;"><?php echo isset($row['date_collection']) ? date('d-M-Y',strtotime($row['date_collection'])) : '-';?></td>
									<?php } ?>
									<td style="text-align:center; border: 1px solid black;"><?php echo isset($row['specimen_received_date']) ? date('d-M-Y',strtotime($row['specimen_received_date'])) : '-';?></td> 
									<!-- <td><?php echo isset($row['date_collection']) ? date('d-M-Y',strtotime($row['date_collection'])) : '-';?></td> 
									<td><?php echo $row['type_specimen']; ?></td>
									<td><?php echo isset($row['date_sent_lab']) ? date('d-M-Y',strtotime($row['date_sent_lab'])) : '';?></td>   
									<td><?php echo isset($row['specimen_received_date']) ? date('d-M-Y',strtotime($row['specimen_received_date'])) : '-';?></td> --> 
									<td style="text-align:center; border: 1px solid black;"><?php echo (($row['quantity_adequate']==1)?"Yes":"No"); ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo (($row['cold_chain_ok']==1)?"Yes":"No"); ?></td> 
									<td style="text-align:center; border: 1px solid black;"><?php //echo $row['lab_id_number']; ?></td> 
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['lab_id_number']; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo isset($row['lab_report_sent_date']) ? date('d-M-Y',strtotime($row['lab_report_sent_date'])) : '';?></td> 
									<td style="text-align:center; border: 1px solid black;"><?php echo (($row['travel_history']==1)?"Yes":"No"); ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['clinical_representation']; ?></td>
									<td style="text-align:center; border: 1px solid black;"><?php echo $row['complications']; ?></td>
									<td style="text-align:center; border: 1px solid black;">
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
										<td style="text-align:center; border: 1px solid black;">
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
										<td style="text-align:center; border: 1px solid black;">
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
										<td style="text-align:center; border: 1px solid black;">
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
										<td style="text-align:center; border: 1px solid black;">
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