<?php 
//echo "<pre>";print_r($data);exit;
 //echo $datefromReport;  exit(); ?>
<div class="" style="font-size:12px;">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"> Line List of Coronavirus Cases</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<table class="table table-bordered table-striped table-hover mytable">
						<tr>
							<td><label>Province/Region</label></td>
							<!-- <td><?php //echo $provName; ?></td> -->
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
							<td><label>Disease Name:</label></td>                           
							<td><label><?php echo "Coronavirus (Covid-19)"; ?></label></td>
							<td><label># of Reported Cases</label></td>
							<td><?php if(isset($ReportedCases)){ echo $ReportedCases; } ?></td>  
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
									<th rowspan="2">Reporting Week</th>
									<th rowspan="2">Reporting Year</th>
									<th rowspan="2">Reporting HF</th>
									<th rowspan="2">Reporting District</th>
									<th rowspan="2">EPID Number</th>
									<th rowspan="2">Name of Patient</th>
									<th rowspan="2">Age in Years</th>
									<th rowspan="2">Gender</th>
									<th rowspan="2">Occupation</th>
									<th rowspan="2">Nationality</th>
									<!-- if Pakistani-->
									<th colspan="5">Address of the Patient</th>
									<!-- <th rowspan="2">Province</th>
									<th rowspan="2">District</th>
									<th rowspan="2">Tehsil</th>
									<th rowspan="2">Union Council</th>
									<th rowspan="2">Village/Muhallah</th> -->
									<!-- if non Pakistani-->
									<!-- <th rowspan="2">Country</th>
									<th rowspan="2">City/State</th> -->
									<th colspan="2">Contact Number</th>

									<th rowspan="2">Have Travel History?</th>									
									<th rowspan="2">Have Travelled Within Country?</th>
									<th rowspan="2">If Travelled Within Country <br>(then mention)</th>
									<th rowspan="2">Have Travelled Abroad?</th>
									<th colspan="3">If Travelled Abroad <br>(then mention)</th>
									<!-- <th colspan="12">History of Travel <br> (Have been to)</th> -->
									<!-- <th rowspan="2">Visit Purpose</th>
									<th rowspan="2">Stay Duration</th>
									<th rowspan="2">Address During Stay</th> -->
									<th rowspan="2">Influenza Vaccine</th>
									<th rowspan="2">Know Any Person With Symptoms</th>
									<th rowspan="2">Date of Onset of Symptoms</th>
									<th rowspan="2">Date Patient Visited Hospital</th>
									<th rowspan="2">Date of Notification</th>
									<th rowspan="2">Date of Investigation</th> 
									<th rowspan="2">Date of Qaurantine</th>
									<th rowspan="2">Date Reported</th>									
									<th rowspan="2">Have Sample Collected?</th>									
									<th rowspan="2">Type of Sample</th>
									<th rowspan="2">Date of Sampling/Collection</th>
									<th rowspan="2">Date of Shipment to NIH</th>
									<th rowspan="2">Test Result</th>
									<th rowspan="2">Outcome</th>							
								</tr>
								<tr>
									<!-- <th>Village/Muhalla</th>
									<th>UC</th>
									<th>Tehsil/Taluka</th> -->
									<th>Village/muhalla</th>
									<th>UC</th>
									<th>Tehsil/Taluka</th>
									<th>District</th>
									<th>Province/Area</th> 

									<th>Mobile</th>
									<th>Telephone</th>									

									<!-- <th>From Province</th>
									<th>From District</th>
									<th>From Tehsil</th>
									<th>From Union Council</th>
									<th>From Address</th>
									<th>To Province</th>
									<th>To District</th>
									<th>To Tehsil</th>
									<th>To Union Council</th>
									<th>To Address</th> -->
									<!-- <th>From Date</th>
									<th>To Date</th> -->

									<th>Country</th>
									<th>Departed Date</th>
									<th>Transit Site</th>

									<!-- <th>USA</th>
									<th>China</th>
									<th>Italy</th>
									<th>Spain</th>
									<th>Germany</th>
									<th>Iran</th>
									<th>France</th>
									<th>Switzerland</th>
									<th>UK</th>
									<th>South Korea</th>
									<th>Netherlands</th>
									<th>Austria</th> -->
									
									<!-- <th>Quantity Adequate</th>
									<th>Cold Chain OK</th> -->
									<!-- <th>Measles</th>
									<th>Rubella</th> -->                            
								</tr>           
							</thead>
							<tbody>        
							<?php 
								$previousWeekNumber = 0;
								$startpoint = isset($startpoint)?$startpoint:0;
								if($this->input->post('export_excel')){
									$startpoint=0;
								}

								//print_r($corona);exit();
								foreach($corona as $key => $row){						
									if($row['gender']=='1')       
										$gender= 'Male';           
									else if($row['gender']=='0')      
										$gender= 'Female';                
									else                          
										$gender= '';
								?>
								<tr class="DrillDownRow">
									<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ ?>
										<td>	
											<a href="<?php echo base_url(); ?>Coronavirus_investigation/coronavirus_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
										</td>
									<?php } ?>
									<td data-id="<?php echo $row['id']; ?>" data-year="<?php echo $row['year']; ?>" data-casetype="<?php echo $row['case_type']; ?>"><?php echo ++$startpoint; ?></td> 
									<td class="text-center"><?php echo sprintf('%02d',$row['week']); ?></td>
									<td><?php echo $row['year']; ?></td>  
									<td><?php echo $row['facility']; ?></td>
									<td><?php echo (isset($row['rb_district']) && $row['rb_district'] != '')?$row['rb_district']:$row['patient_district']; ?></td>
									<td style="width: "><?php echo $row['case_epi_no']; ?></td>
									<td><?php echo $row['name']; ?></td>  
									<td><?php echo $row['age_in_year']; ?></td>
									<td><?php echo $gender; ?></td>
									<td><?php echo $row['occupation']; ?></td>
									<td><?php echo $row['nationality']; ?></td>
									<td><?php echo $row['patient_address']; ?></td>
									<td><?php echo $row['patient_unname']; ?></td> 
									<td><?php echo $row['patient_tehsil']; ?></td>
									<td><?php echo $row['patient_district']; ?></td> 
									<td><?php echo $row['province']; ?></td>
									<td><?php echo $row['mobile']; ?></td>
									<td><?php echo $row['telephone']; ?></td>
									<td><?php echo (($row['have_travel_history']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['have_travel_within_country']==1)?"Yes":"No"); ?></td>

									<!-- <td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td>
									<td><?php //echo $row['transit_site']; ?></td> -->
									<?php 
										$abroadCases = getWithinCountryTravelHistory(true, $row['id']);
										if($abroadCases != '') 
											echo $abroadCases;
										else{
											echo '<td>-</td>';
										}
									?>

									<td><?php echo (($row['have_travel_abroad']==1)?"Yes":"No"); ?></td>
									<?php 
										$abroadCases = getAbroadTravelHistory(true, $row['id']);
										if($abroadCases != '') 
											echo $abroadCases;
										else{
											echo '<td>-</td><td>-</td><td>-</td>';
										}
									?>
									<!-- <td><?php //echo $row['country']; ?></td>
									<td><?php //echo isset($row['departed_date']) ? date('d-M-Y',strtotime($row['departed_date'])) :'-'; ?></td>  
									<td><?php //echo $row['transit_site']; ?></td> -->	

									<!-- <td><?php echo (($row['country_1']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_2']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_3']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_4']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_5']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_6']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_7']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_8']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_9']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_10']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_11']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['country_12']==1)?"Yes":"No"); ?></td> -->
									
									<!-- <td><?php echo $row['visit_purpose']; ?></td>
									<td><?php echo $row['stay_duration']; ?></td>
									<td><?php echo $row['address_during_stay']; ?></td> -->
									<td><?php echo (($row['influenza_vaccine']==1)?"Yes":"No"); ?></td>
									<td><?php echo (($row['know_any_person_with_symptons']==1)?"Yes":"No"); ?></td>
									<td><?php echo isset($row['date_of_onset']) ? date('d-M-Y',strtotime($row['date_of_onset'])) :'-'; ?></td> 
									<td><?php echo isset($row['pvh_date']) ? date('d-M-Y',strtotime($row['pvh_date'])) :'-'; ?></td> 
									<td><?php echo isset($row['date_of_notification']) ? date('d-M-Y',strtotime($row['date_of_notification'])) :'-'; ?></td>
									<td><?php echo isset($row['date_of_investigation']) ? date('d-M-Y',strtotime($row['date_of_investigation'])) :'-'; ?></td>
									<td><?php echo isset($row['date_of_quarantine']) ? date('d-M-Y',strtotime($row['date_of_quarantine'])) : '-'; ?></td> 
									<td><?php echo isset($row['date_reported']) ? date('d-M-Y',strtotime($row['date_reported'])) : '-';?></td> 
									<td><?php echo (($row['sample_collected']==1)?"Yes":"No"); ?></td>
									<td><?php echo $row['sample_type']; ?></td>
									<td><?php echo isset($row['date_of_collection']) ? date('d-M-Y',strtotime($row['date_of_collection'])) : '';?></td>   
									<td><?php echo isset($row['date_of_shipment_to_nih']) ? date('d-M-Y',strtotime($row['date_of_shipment_to_nih'])) : '-';?></td>
									<td>
										<?php if(isset($row['test_result']) && $row['test_result'] == "Pending"){ ?>
											<?php echo "Pending/Awaited"; ?>
										<?php } else { ?>
											<?php echo $row['test_result']; ?>
										<?php } ?>	
									</td>
									<td><?php echo $row['outcome']; ?></td>							
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
			 $("#fixTable").tableHeadFixer({"left" : 10}); 
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
			url = "<?php echo base_url();?>Coronavirus_investigation/coronavirus_investigation_view/"+id+"/"+year;
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
	/*  */
    </script>
<?php } exit; ?> 