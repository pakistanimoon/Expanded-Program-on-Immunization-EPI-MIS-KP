<?php 
//echo "<pre>";print_r($data);exit;
 //echo $datefromReport;  exit(); ?>
<div class="" style="font-size:12px;">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"> Line List of Suspected Cases</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<table class="table table-bordered table-striped table-hover  mytable">
						<tr>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Province/Area</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $this -> session -> provincename ?></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>District</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $districtName; ?></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Union Council</label></td>
							<?php if($this-> uri-> segment(9) == "outbreak"){ ?>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo get_UC_Name($pa_uncode); ?></td>
							<?php } else { ?>                           
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $ucName; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label># of Reporting Unit</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($allReportingFLCF)){ echo $allReportingFLCF; } ?></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Case Type:</label></td>                           
							<td style="text-align:center; border: 1px solid black;" class="text-center">
							<?php if($this-> input-> post('case_type')){ ?> 
							<label><?php echo get_CaseType_Name($this-> input-> post('case_type')); ?></label>	
							<?php }else{ ?>
							<label><?php echo $this -> uri -> segment(6); ?></label>	
							<?php } ?>                           
							</td>						   						   
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label># of Reported Cases</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($ReportingFLCF)){ echo $ReportingFLCF; } ?></td>  
						</tr>
						<tr>
							<?php //if((isset($week_from) && $week_from < 1) && (isset($week_to) && $week_to < 1)) { ?>
								<!-- <td><label>Year</label></td>
								<td><?php echo $year; ?></td> -->
							<!-- 	<td><label>Date From</label></td>
								<td id="datefrom"><?php echo (isset($datefromReport))?$datefromReport:''; ?>
								</td>
								<td><label>Date To</label></td>
								<td id="dateto"><?php echo (isset($datetoReport))?$datetoReport:''; ?>
								</td> -->
							<?php if ((isset($week_from) && $week_from < 1) && (isset($week_to) && $week_to >= 1)) { ?>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Epi Week From</label></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (isset($week_from))?$year.'-01':''; ?>
								</td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Epi Week To</label></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
								</td>
							<?php } else if ((isset($week_from) && $week_from >= 1) && (isset($week_to) && $week_to < 1)) { ?>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Epi Week From</label></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
								</td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Epi Week To</label></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (isset($week_to))?$year.'-'.date('W'):''; ?>
								</td>
							<?php } else if ((isset($week_from) && $week_from >= 1) && (isset($week_to) && $week_to >= 1)) { ?>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Epi Week From</label></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
								</td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Epi Week To</label></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
								</td>
							<?php } ?>
						</tr>
						<tr>
						<?php if((isset($week_from) && $week_from < 1) && (isset($week_to) && $week_to < 1)) { ?>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Year</label></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $year; ?></td>
						<?php } ?>
						<?php if(isset($week_from) && $week_from < 1 && $year == date('Y')) { ?>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Date From</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center" id="datefrom"><?php echo "31-Dec-".(date('Y') - 1); ?>
							</td>
						<?php } else { ?>							
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Date From</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center" id="datefrom"><?php echo (isset($datefromReport))?$datefromReport:''; ?>
							</td>
						<?php } ?>
						<?php if(isset($week_to) && $week_to < 1 && $year < date('Y')) { ?>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Date To</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center" id="dateto"><?php echo "31-Dec-".$year; ?>
							</td>
						<?php } else { ?>	
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Date To</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center" id="dateto"><?php echo (isset($datetoReport))?$datetoReport:''; ?>
							</td>
						<?php } ?>
						</tr>
					</table>
					<div id="parent">      
						<table id="fixTable" class="table table-bordered table-condensed table-striped table-hover mytable">
							<thead>
								<tr>
								<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ ?>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Action</th>
								<?php }?>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Sr #</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Reporting EPI Week</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Reporting Year</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Reporting HF</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Reporting District</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">EPID Number</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Name of Case</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Father's Name</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Contact Number</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="5">Address of the Case</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Age in Months</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Gender</th>
								<?php
									if(isset($data['case_type']) == 'Msl'){ 
									//if($data['case_type'] == 'Msl'){ ?>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of Rash Onset</th>
									<?php } else if (isset($data['case_type']) == 'Diph' ){ ?>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of Adherent membrance onset</th>
								<?php }  else { ?>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date Onset</th>
								<?php } ?>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of Notification</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of Investigation</th>                              
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2"># of Vaccine doses received</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of last vaccine dose</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of Specimen Collection</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Type of Specimen</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date Specimen Sent to Lab</th> 
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date Specimen Received in Lab</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Condition of Specimen</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Lab ID Number</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date Report Sent</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">History of Travel during 21 days prior to rash onset</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Clinical Presentation of the case</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Complications</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Outcome</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Lab result</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">EPI Linked (Msl/Rub/No)</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Final Classification</th>
									<!-- <th rowspan="2">Action</th> -->
								</tr>
								<tr>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Village/muhalla</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">UC</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Tehsil/Taluka</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">District</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Province/Area</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Quantity Adequate</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Cold Chain OK</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Measles</th>
									<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Rubella</th> 
									<!-- <th>Edit</th>
									<th>View</th> -->                             
								</tr>           
							</thead>
							<tbody>        
							<?php 
								$previousWeekNumber = 0;
								$startpoint = isset($startpoint)?$startpoint:0;
								if($this->input->post('export_excel')){
									$startpoint=0;
								}

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
											<td style="text-align:center; border: 1px solid black;" class="text-center">
												<!-- <a href="<?php //echo base_url(); ?>Measles_investigation/measles_investigation_view/<?php //echo $row['id']; ?>/<?php //echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a> -->	
												<a href="<?php echo base_url(); ?>Measles_investigation/measles_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
											</td>										
										<?php } else { ?>
											<td style="text-align:center; border: 1px solid black;" class="text-center">
												<!-- <a href="<?php //echo base_url(); ?>Case_investigation/case_investigation_view/<?php //echo $row['id']; ?>/<?php //echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a> -->
												<a href="<?php echo base_url(); ?>Case_investigation/case_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
											</td>										
										<?php } ?>
									<?php } ?>	
									<td style="text-align:center; border: 1px solid black;" class="text-center" data-id="<?php echo $row['id']; ?>" data-year="<?php echo $row['year']; ?>" data-casetype="<?php echo $row['case_type']; ?>"><?php echo ++$startpoint; ?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo sprintf('%02d',$row['week']); ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['year']; ?></td>  
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['facility']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (isset($row['rb_district']) && $row['rb_district'] != '')?$row['rb_district']:$row['patient_district']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['case_epi_no']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['patient_name']; ?></td>  
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['patient_fathername']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['contact_numb']; ?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['patient_address']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['patient_unname']; ?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['patient_tehsil']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['patient_district']; ?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['province']; ?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['age_months']; ?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $patient_gender; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo isset($row['date_rash_onset']) ? date('d-M-Y',strtotime($row['date_rash_onset'])) :'-'; ?></td>  
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo isset($row['notification_date']) ? date('d-M-Y',strtotime($row['notification_date'])) :'-'; ?></td>  
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo isset($row['pvh_date']) ? date('d-M-Y',strtotime($row['pvh_date'])) :'-'; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['doses_received']; ?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo isset($row['last_dose_date']) ? date('d-M-Y',strtotime($row['last_dose_date'])) : '-'; ?></td>  
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo isset($row['date_collection']) ? date('d-M-Y',strtotime($row['date_collection'])) : '-';?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['type_specimen']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo isset($row['date_sent_lab']) ? date('d-M-Y',strtotime($row['date_sent_lab'])) : '';?></td>   
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo isset($row['specimen_received_date']) ? date('d-M-Y',strtotime($row['specimen_received_date'])) : '-';?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (($row['quantity_adequate']==1)?"Yes":"No"); ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (($row['cold_chain_ok']==1)?"Yes":"No"); ?></td>  
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['lab_id_number']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo isset($row['lab_report_sent_date']) ? date('d-M-Y',strtotime($row['lab_report_sent_date'])) : '';?></td> 
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (($row['travel_history']==1)?"Yes":"No"); ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['clinical_representation']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['complications']; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center">
									   <?php 
										if($row['outcome'] != '' && $row['outcome'] != '0') {
											echo $row['outcome'];
									  	}
										else{
												echo "-";
										  	}
									   ?>                            
									</td>
								<?php if($row['case_type'] != 'Msl') { ?>
									<td style="text-align:center; border: 1px solid black;" class="text-center">
									   <?php 
										  // 	if($row['specimen_result'] == 'Positive Measles') 
												// {echo "Positive";}
										  // 	elseif($row['specimen_result'] == 'Negative Measles')
												// {echo "Negative";}
										  // 	else
												// echo "";
									   ?>                               
									</td>
									<td style="text-align:center; border: 1px solid black;" class="text-center">
									   <?php 
										  // 	if($row['specimen_result'] == 'Positive Rubella') 
												// {echo "Positive";}
										  // 	elseif($row['specimen_result'] == 'Negative Rubella')
												// {echo "Negative";}
										  // 	else
												// echo "";
									   ?>                            
									</td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo ""; ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo ""; ?></td>
								<?php } else { ?>
									<?php if($row['specimen_result'] == 'Positive Measles' && $row['specimen_result'] != 'Positive Rubella') { ?>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo "Positive"; ?></td>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo "Negative"; ?></td>
									<?php } elseif ($row['specimen_result'] != 'Positive Measles' && $row['specimen_result'] == 'Positive Rubella') {?>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo "Negative"; ?></td>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo "Positive"; ?></td>
									<?php } elseif ($row['specimen_result'] == NULL) { ?>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo ""; ?></td>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo ""; ?></td>
									<?php } else {?>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo "Negative"; ?></td>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo "Negative"; ?></td>
								<?php } ?>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo epiLinked(false, $row['patient_address_uncode'], $row['fweek'], $row['specimen_result']); ?></td>
									<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo finalClassification(false, $row['id']); ?></td>
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
										<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Compiled by</label></td>
									</tr>
									<tr>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Name</label></td>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($downPortion[0]['name'])){ echo $downPortion[0]['name']; }else{ echo 'Manager'; } ?></td>
									</tr>
									<tr>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Designation</label></td>
										<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($downPortion[0]['name'])){ echo $downPortion[0]['designation']; }else{ echo 'EPI Manager'; } ?></td>
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