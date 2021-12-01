<?php
class Filter_model extends CI_Model {
	private $dbf;
	function __construct(){
		parent::__construct();
			$this -> load -> helper('epi_functions_helper'); 
	}
	function createFilter($filterNames, $dataArray, $fileName,$UserLevel){
		$finalString = '<form method="post" id="filter-form" action="'.$fileName.'">
		<div class="form-group">';
			if($UserLevel == 2 && array_key_exists("districts", $dataArray)){
				
				$finalString .= '   <label class="col-xs-1 control-label"  for = "facode" >District:</label>
				<div class="col-xs-2">
					<select id="distcode" name="distcode" class="filter-status  form-control">
						<option value="0"></option>';
						while($row=$this->db->result_array($dataArray['districts'])){
							$finalString .= '<option '.(isset($_REQUEST['distcode']) && $_REQUEST['distcode'] ==  $row['distcode'] ? 'selected = "selected"' : '').' value="'.$row['distcode'].'" >'.$row['district'].'</option>';
						}
					}
					$finalString .= '</select></div>';
					if(array_key_exists("tehsil", $dataArray)){
						$finalString .= '        <label class="col-xs-2 control-label"  for = "facode" >Tehsil:</label>
						<div class="col-xs-2"><select id="tcode" name="tcode" class="filter-status  form-control">
							<option value="0"></option>';
							while($row=$this->db->result_array($dataArray['tehsil'])){
								$finalString .= '<option '.(isset($_REQUEST['tcode']) && $_REQUEST['tcode'] ==  $row['tcode'] ? 'selected = "selected"' : '').'  value="'.$row['tcode'].'" >'.$row['tehsil'].'</option>';
							}
							$finalString .= '</select></div>';
						}if(($UserLevel == 2 || $UserLevel == 3 ) && array_key_exists("flcf", $dataArray)){
							$finalString .= '<label class="col-xs-2 control-label"  for = "facode" >EPI Center Name:</label>
							<div class="col-xs-2">
								<select id="facode" name="facode" class="filter-status form-control">
									<option value="0"></option>';
									while($row=$this->db->result_array($dataArray['flcf'])){
										$finalString .= '<option  '.(isset($_REQUEST['facode']) && $_REQUEST['facode'] ==  $row['facode'] ? 'selected = "selected"' : '').' value="'.$row['facode'].'" >'.$row['fac_name'].'</option>';
									}
									$finalString .= '</select></div>';
								}
								if(array_key_exists("unioncouncil", $dataArray)){
									$finalString .= '  <label class="col-xs-2 control-label"  for = "facode" >Union Council:</label>
									<div class="col-xs-2">
										<select id="uncode" name="uncode" class="filter-status form-control">
											<option value="0"></option>';
											while($row=$this->db->result_array($dataArray['unioncouncil'])){
												$finalString .= '<option '.(isset($_REQUEST['uncode']) && $_REQUEST['uncode'] ==  $row['uncode'] ? 'selected = "selected"' : '').' value="'.$row['uncode'].'" >'.$row['un_name'].'</option>';
											}
											$finalString .= '</select></div>';
										}if(array_key_exists("lhs", $dataArray)){
											$finalString .= '<label class="col-xs-2 control-label"  for = "facode" >LHS Name:</label>
											<div class="col-xs-2">
												<select id="lhscode" name="lhscode" class="filter-status form-control">
													<option value="0"></option>';
													while($row=$this->db->result_array($dataArray['lhs'])){
														$finalString .= '<option '.(isset($_REQUEST['tcode']) && $_REQUEST['tcode'] ==  $row['tcode'] ? 'selected = "selected"' : '').' value="'.$row['lhscode'].'" >'.$row['lhsname'].'</option>';
													}
													$finalString .= '</select></div>';
												}if(array_key_exists("fatype", $dataArray)){
													$finalString .= '<label class="col-xs-2 control-label"  for = "facode" >Health Facility Type:</label>
													<div class="col-xs-2">
														<select id="fatype" name="fatype" class="filter-status form-control">
															<option value=""></option>';
															while($row=$this->db->result_array($dataArray['fatype'])){
																$finalString .= '<option '.(isset($_REQUEST['fatype']) && $_REQUEST['fatype'] ==  $row['fatype'] ? 'selected = "selected"' : '').' value="'.$row['fatype'].'" >'.$row['fatype'].'</option>';
															}
															$finalString .= '</select></div>';
														}
														if(array_key_exists("flcf_type", $dataArray)){
															$finalString .= '<label class="col-xs-1 control-label"  for = "facode" >Area Type:</label>
															<div class="col-xs-2">
																<select id="report_type" name="flcf_type" class="filter-status  form-control">
																	<option selected="selected" value=""></option>';
																	$finalString .= '<option value="Rural"'.(isset($_REQUEST['flcf_type']) && $_REQUEST['flcf_type']=='Rural' ? 'selected="selected"': '').'>Rural</option>';
																	$finalString .= '<option value="Urban"'.(isset($_REQUEST['flcf_type']) && $_REQUEST['flcf_type']=='Urban' ? 'selected="selected"': '').'>Urban</option>';
																	$finalString .= '<option value="Semi Urban"'.(isset($_REQUEST['flcf_type']) && $_REQUEST['flcf_type']=='Semi Urban' ? 'selected="selected"': '').'>Semi Urban</option>';
																	$finalString .= '<option value="Slum"'.(isset($_REQUEST['flcf_type']) && $_REQUEST['flcf_type']=='Slum' ? 'selected="selected"': '').'>Slum</option>
																</select>
															</div>';
														}
														
														if(array_key_exists("years", $dataArray)){
															$finalString .= '<label class="col-xs-1 control-label paddingzero"  for = "facode" >Year:</label>
															<div class="col-xs-2 paddingzero">
																<select id="report_year" name="report_year" class="filter-status  form-control">';
																	$finalString .= getYearsOptions();
																	$finalString .= '</select>
																</div>
																';
															}
															$finalString .= '<div class="col-xs-1">
															<button class="btn btn-success" type="submit" name="submit">Preview</button>
														</div>
														<div class="col-xs-1">
															<button type="submit" name="export_excel"><img src="../../images/excel.jpg" alt="Excel Export" /></button>
														</div>	
														<div class="col-xs-1">
															<a href="#" onclick="window.print();"><img src="../../images/ico_print.gif" border="0"></a>
														</div></div></form>';
														return $finalString;
													}
							
							
	function createListingFilter($filterNames, $dataArray, $fileName,$UserLevel,$title='Report Filters'){
	//print_r($dataArray); exit;
	/*echo '<hr>';
		
		 var_dump($dataArray);echo '<hr>';
		
		var_dump($UserLevel);echo '<hr>';
		exit();*/
        
		$finalString = 
		'
		<div class="container bodycontainer">
			<div class="row">
		 		<div class="col-xs-6 col-xs-offset-3">	
		  			<div class="panel panel-primary">
		   				 <div class="panel-heading text-center">'.str_replace("_", " ", $title).'</div>
							<div class="panel-body">
							<form method="post" name="theForm" target="_blank" id="filter-form" class="form-horizontal form-bordered" action="'.$fileName.'">';
							if(($UserLevel == 2 || $UserLevel == 3 ) && array_key_exists("districts", $dataArray))
							{
								$finalString .= '
									 <div class="row">
										<div class="form-group">
											<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >District:</label>
												<div class="col-xs-7">
													<select id="distcode" name="distcode" class="filter-status  form-control" >';
													if($UserLevel == 2)
													{
														$finalString .= '<option value="0">-- ALL --</option>';
													}																	
													foreach($dataArray['districts'] as $row)	
													{		
													
														$finalString .= '<option '.($this->input->post('distcode') && $this->input->post('distcode') ==  $row['distcode'] ? 'selected = "selected"' : '').' value="'.$row['distcode'].'" >'.$row['district'].'</option>';
													}
													$finalString .= 
													'</select>
												</div> 
										</div>
									</div>';
									
							}
							if(array_key_exists("acces_type", $dataArray)){
								$finalString .= 
												'<div class="row">
													
												<div class="form-group" id="acces_type">
													<label class="col-xs-3 col-xs-offset-1 control-label" for = "acces_type" >Report Type</label>
													<div class="col-xs-7">
														<select  name="acces_type" class="filter-status form-control" >
															<option value="ucwise" selected="selected" >UC Wise</option>
															<option value="facilitywise" >Facility Wise</option>
														</select>
													</div>
													</div>
												</div>';
							}
							if(array_key_exists("supervisortype", $dataArray)){
                               if($this -> session -> UserLevel==4){
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "supervisor_type" >Supervisor Type:</label>
										<div class="col-xs-7">
											<select class="form-control" name="supervisor_type" id="supervisor_type">
												<option value="0">--Select--</option>
												<option value="EPI Coordinator">EPI Coordinator</option>
												<option value="Assistant Superintendent Vaccinator">Assistant Superintendent Vaccinator</option>
												<option value="Tehsil Superintendent Vaccinator">Tehsil Superintendent Vaccinator</option>
												<option value="Field Superintendent Vaccinator">Field Superintendent Vaccinator</option>
												<option value="Monitoring and Evaluation Supervisor">Monitoring and Evaluation Supervisor</option>
												<option value="Assistant Director M&E">Assistant Director M&E</option>
												<option value="Assistant Director Surveillance">Assistant Director Surveillance</option>
												<option value="Assistant Director Training">Assistant Director Training</option>
											</select>
										</div>
									</div>
								</div>';}else{
									$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "supervisor_type" >Supervisor Type:</label>
										<div class="col-xs-7">
											<select class="form-control" name="supervisor_type" id="supervisor_type">
												<option value="0">--Select--</option>
												<option value="EPI Coordinator">EPI Coordinator</option>
												<option value="District Superintendent Vaccinator">District Superintendent Vaccinator</option>
												<option value="District Health coordinator">District Health coordinator</option>
												<option value="Assistant Superintendent Vaccinator">Assistant Superintendent Vaccinator</option>
												<option value="Tehsil Superintendent Vaccinator">Tehsil Superintendent Vaccinator</option>
												<option value="Field Superintendent Vaccinator">Field Superintendent Vaccinator</option>
												<option value="Monitoring and Evaluation Supervisor">Monitoring and Evaluation Supervisor</option>
												<option value="District Health Officer">District Health Officer</option>
												<option value="Assistant Director M&E">Assistant Director M&E</option>
												<option value="Assistant Director Surveillance">Assistant Director Surveillance</option>
												<option value="Assistant Director Training">Assistant Director Training</option>
											</select>
										</div>
									</div>
								</div>';
								}
								$finalString .= 
								'<div class="row hide" id="hiddenTehsilRow">
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Tehsil:</label>
									<div class="col-xs-7">
										<select id="tcode" name="tcode" class="filter-status form-control" >
											<option value="0">-- ALL --</option>';
											foreach($dataArray['tehsil'] as $row){
											
												$finalString .= '<option '.($this->input->post('tcode') && $this->input->post('tcode') ==  $row['tcode'] ? 'selected = "selected"' : '').' value="'.$row['tcode'].'" >'.$row['tehsil'].'</option>';
											}
											$finalString .= '
										</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("retiredHRreport", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "hr_type" >HR Type:</label>
										<div class="col-xs-7">
											<select class="form-control" name="hr_type" id="hr_type">
												<option value="0"></option>
												<option value="Supervisor">Supervisor</option>
												<option value="District Surveillance Officer">District Surveillance Officer</option>
												<option value="Computer Operator">Computer Operator</option>
												<option value="HF Incharge">HF Incharge</option>
												<option value="Data Entry Operator">Data Entry Operator</option>
												<option value="Store Keeper">Store Keeper</option>
												<option value="EPI Technicians">EPI Technicians</option>
												<option value="Driver">Driver</option>
											</select>
										</div>
									</div>
								</div>';
							}
					if(array_key_exists("tehsil", $dataArray) && !array_key_exists("supervisortype", $dataArray)){
								if($this -> session -> UserLevel==4){
									  $finalString .= 
								'<div class="row">
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Tehsil:</label>
									<div class="col-xs-7">
										<select id="tcode" name="tcode" class="filter-status form-control" >';
											foreach($dataArray['tehsil'] as $row){
											
												$finalString .= '<option '.($this->input->post('tcode') && $this->input->post('tcode') ==  $row['tcode'] ? 'selected = "selected"' : '').' value="'.$row['tcode'].'" >'.$row['tehsil'].'</option>';
											}
											$finalString .= '
										</select>
									</div>
									</div>
								</div>';
								}else{
								      $finalString .= 

								'<div class="row">
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Tehsil:</label>
									<div class="col-xs-7">
										<select id="tcode" name="tcode" class="filter-status form-control" >
											<option value="0">-- ALL --</option>';
											foreach($dataArray['tehsil'] as $row){
											
												$finalString .= '<option '.($this->input->post('tcode') && $this->input->post('tcode') ==  $row['tcode'] ? 'selected = "selected"' : '').' value="'.$row['tcode'].'" >'.$row['tehsil'].'</option>';
											}
											$finalString .= '
										</select>
									</div>
									</div>
								</div>';	
								}

							}
							if(array_key_exists("unioncouncil", $dataArray)){
								$finalString .= 
								'<div class="row">
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Union Council:</label>
									<div class="col-xs-7">
										<select id="uncode" name="uncode" class="filter-status form-control" >
											<option value="0">-- ALL --</option>';
											foreach($dataArray['unioncouncil'] as $row){
											
												$finalString .= '<option '.($this->input->post('uncode') && $this->input->post('uncode') ==  $row['uncode'] ? 'selected = "selected"' : '').' value="'.$row['uncode'].'" >'.$row['un_name'].'</option>';
											}
											$finalString .= '
										</select>
									</div>
									</div>
								</div>';
							}
							if(($UserLevel == 2 || $UserLevel == 3 ) && array_key_exists("flcf", $dataArray)){
								$finalString .= 
								'<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >EPI Center Name:</label>
											<div class="col-xs-7">
												<select id="facode" name="facode" class="filter-status form-control" >
													<option value="0">-- ALL --</option>';
													foreach($dataArray['flcf'] as $row){
														$finalString .= '<option  '.($this->input->post('facode') && $this->input->post('facode') ==  $row['facode'] ? 'selected = "selected"' : '').' value="'.$row['facode'].'" >'.$row['fac_name'].'</option>';
													}
	  
													$finalString .= '
												</select>
											</div>
									</div>
								</div>';
							}
							if(array_key_exists("lhs", $dataArray)){
								
								$finalString .= 
								'<div class="row">
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >LHS Name:</label>
									<div class="col-xs-7">
										<select id="lhscode" name="lhscode" class="filter-status form-control" >
											<option value="0">-- ALL --</option>';
											foreach($dataArray['lhs'] as $row){
										
												$finalString .= '<option '.($this->input->post('tcode') && $this->input->post('tcode') ==  $row['tcode'] ? 'selected = "selected"' : '').' value="'.$row['lhscode'].'" >'.$row['lhsname'].'</option>';
											}
											$finalString .= 
										'</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("fatype", $dataArray)){
								$finalString .= 
								'<div class="row">
									<div class="form-group">
								
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Health Facility Type:</label>
									<div class="col-xs-7">
										<select id="fatype" name="fatype" class="filter-status form-control" >
											<option value="">-- ALL --</option>';
											foreach($dataArray['fatype'] as $row){
											
												$finalString .= '<option '.($this->input->post('fatype') && $this->input->post('fatype') ==  $row['fatype'] ? 'selected = "selected"' : '').' value="'.$row['fatype'].'" >'.$row['fatype'].'</option>';
											}
											$finalString .= 
										'</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("flcf_type", $dataArray)){
								$finalString .= 
								'<div class="row">
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Area Type:</label>
									<div class="col-xs-7">
										<select id="report_type" name="flcf_type" class="filter-status  form-control" >
											<option selected="selected" value="">-- ALL --</option>';
											$finalString .= '<option value="Rural"'.($this->input->post('flcf_type') && $this->input->post('flcf_type')=='Rural' ? 'selected="selected"': '').'>Rural</option>';
											$finalString .= '<option value="Urban"'.($this->input->post('flcf_type') && $this->input->post('flcf_type')=='Urban' ? 'selected="selected"': '').'>Urban</option>';
											$finalString .= '<option value="Semi Urban"'.($this->input->post('flcf_type') && $this->input->post('flcf_type')=='Semi Urban' ? 'selected="selected"': '').'>Semi Urban</option>';
											$finalString .= '<option value="Slum"'.($this->input->post('flcf_type') && $this->input->post('flcf_type')=='Slum' ? 'selected="selected"': '').'>Slum</option>
										</select>
									</div>
									</div>
								</div>';
							}
								if(array_key_exists("indicators", $dataArray)){
								$finalString .= 
								'<div class="row">
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >indicator:</label>
									<div class="col-xs-7">
										<select id="indicator" name="indicator" class="filter-status  form-control" >';
										foreach($dataArray['indicators'] as $row){
										
												$finalString .= '<option value="'.$row["indid"].'" '.($this->input->post('indicator') && ($this->input->post('indicator') == $row['indid'])?'selected="selected"':'').' >'.$row["ind_name"].'</option>';
											}
										$finalString .= '</select>
									</div>
									</div>
								</div>';
							}
					
							if(array_key_exists("demand_type", $dataArray)){
								$finalString .= 
								'<div class="row">
									
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "demand_type" >Demand Type</label>
									<div class="col-xs-7">
										<select id="demand_type" name="demand_type" class="filter-status  form-control">
											<option value="f4" selected="selected">Vials Used</option>
											<option value="f5">Unusable Vials</option>
										</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("consumption_type", $dataArray)){
								$finalString .= 
								'<div class="row">								
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "consumption_type" >Indicator</label>
									<div class="col-xs-7">
										<select id="consumption_type" name="consumption_type" class="filter-status  form-control">
											<option value="used_vials" selected="selected">Vials Used</option>
											<option value="used_doses" selected="selected">Doses Used</option>
											<option value="unused_vials">Unusable Vials</option>
											<option value="unused_doses">Unusable Doses</option>
										</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("yearMonthWise", $dataArray)){
									$finalString .= 
												'<div class="row">
													
												<div class="form-group" id="yearMonthWise">
													<label class="col-xs-3 col-xs-offset-1 control-label" for = "yearMonthWise" >Period</label>
													<div class="col-xs-7">
														<input type="radio" value="yearly" required="required" name="report_type" id="report_type" /> Yearly
														<input type="radio" value="quarterly" required="required" name="report_type" id="report_type" /> Quarterly
														<input type="radio" value="monthly" required="required" name="report_type" id="report_type" /> Monthly
													</div>
													</div>
												</div>';
							}
							if(array_key_exists("vaccines", $dataArray)){
								$finalString .= 
								'<div class="row">
									
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "vaccine" >Products</label>
									<div class="col-xs-7">
										<select id="vaccine" name="vaccine" class="filter-status  form-control">
											<option value="cr_r1_" selected="selected">BCG</option>
											<option value="cr_r2_">DIL BCG</option>
											<option value="cr_r3_">bOPV</option>
											<option value="cr_r4_">Pentavalent</option>
											<option value="cr_r5_">Pneumococcal (PCV10)</option>
											<option value="cr_r6_">Measles</option>
											<option value="cr_r7_">DIL Measles</option>
											<option value="cr_r8_">TT 10</option>
											<option value="cr_r9_">TT 20</option>
											<option value="cr_r10_">HBV (Birth dose)</option>
											<option value="cr_r11_">IPV</option>
											<option value="cr_r12_">AD Syringes 0.5 ml</option>
											<option value="cr_r13_">AD Syringes 0.05 ml</option>
											<option value="cr_r14_">Recon. Syringes (2 ml)</option>
											<option value="cr_r15_">Recon. Syringes (5 ml)</option>
											<option value="cr_r16_">Safety Boxes</option>
											<option value="cr_r17_">Other</option>
										</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("years", $dataArray)){
								$finalString .= 
								'<div class="row">									
									<div id="year_div" class="form-group" >
									<label id="year_label" class="col-xs-3 col-xs-offset-1 control-label" for = "tcode">Year:</label>
									<div class="col-xs-7">
										<select id="year" name="year" class="filter-status  form-control">';
											$finalString .= getAllYearsOptionsIncludingCurrent(true);
											$finalString .= '</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("epiyears", $dataArray)){
								$finalString .= 
								'<div class="row">
									
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Year:</label>
									<div class="col-xs-7">
										<select id="year" name="year" class="filter-status  form-control">';
											$finalString .= '<option value="">--Select Year--</option>';
											foreach ($dataArray['epiyears'] as $oneyear) { 
												$finalString .= '<option value="'.$oneyear["year"].'">'.$oneyear["year"].'</option>';
											}
											$finalString .= '</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("epiyears_select", $dataArray)){
								$finalString .= 
								'<div class="row">
									
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Year:</label>
									<div class="col-xs-7">
										<select id="year" name="year" class="filter-status  form-control">';
											foreach ($dataArray['epiyears_select'] as $oneyear) { 
												$finalString .= '<option value="'.$oneyear["year"].'">'.$oneyear["year"].'</option>';
											}
											$finalString .= '</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("quarterwise", $dataArray)){ 
									$finalString .= 
												'<div class="row">
													
												<div class="form-group" id="quarterwise">
													<label class="col-xs-3 col-xs-offset-1 control-label" for = "quarter" >Quarter</label>
													<div class="col-xs-7">
														<select name="quarter" id="quarterly" class="form-control">
															<option selected="selected" value="Q1">Quarter 01</option>
															<option value="Q2">Quarter 02</option>
															<option value="Q3">Quarter 03</option>
															<option value="Q4">Quarter 04</option>
														</select>
													</div>
													</div>
												</div>';
							}
							if(array_key_exists("month-from-to-current", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label for="monthfrom" class="col-xs-3 col-xs-offset-1 control-label" id="monthfrom-label">Period From</label>
										<div class="col-xs-7">
											<input name="monthfrom" value="" id="monthfrom" class="form-control dp-my" required="required" data-date-end-date="+0m" type="text">
										</div>  					
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label for="monthto" class="col-xs-3 col-xs-offset-1 control-label" id="monthto-label">Period To</label>
										<div class="col-xs-7">
											<input name="monthto" value="" id="monthto" class="form-control dp-my" required="required" data-date-end-date="+0m" type="text">
										</div>  					
									</div>
								</div>';
							}
							if(array_key_exists("month-from-to-previous", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label for="monthfrom" class="col-xs-3 col-xs-offset-1 control-label" id="monthfrom-label">Period From</label>
										<div class="col-xs-7">
											<input name="monthfrom" value="" id="monthfrom" class="form-control dp-my" required="required" data-date-end-date="-1m" type="text">
										</div>  					
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label for="monthto" class="col-xs-3 col-xs-offset-1 control-label" id="monthto-label">Period To</label>
										<div class="col-xs-7">
											<input name="monthto" value="" id="monthto" class="form-control dp-my" required="required" data-date-end-date="-1m" type="text">
										</div>  					
									</div>
								</div>';
							}
							if(array_key_exists("months", $dataArray)){
								$finalString .= 
								'<div class="row">
								
									
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Month:</label>
									<div class="col-xs-7">
										<select id="month" name="month" class="filter-status  form-control" >';
										$finalString .= getAllMonthsOptions(true);
										$finalString .= '</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("months_aug2020", $dataArray)){ 
								$finalString .= 
								'<div class="row">
								
									
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Month:</label>
									<div class="col-xs-7">
										<select id="month" name="month" class="filter-status  form-control" >';
										$finalString .= getAllMonthsOptions_aug2020(true);
										$finalString .= '</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("current-month-included", $dataArray)){
								$finalString .= 
								'<div class="row">
								
									
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Month:</label>
									<div class="col-xs-7">
										<select id="month" name="month" class="filter-status  form-control" >';
										$finalString .= getAllMonthsOptionsIncludingCurrent(true);
										$finalString .= '</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("fmonthsfrom", $dataArray)){
								$finalString .= 
								'<div class="row">
									<div class="form-group">
								
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Month From:</label>
									<div class="col-xs-7">
										<select id="fmonth_from" name="fmonth_from" class="filter-status form-control">';
											$finalString .=  $this -> getFMonthsOptions(true);
											$finalString .= '</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("fmonthsto", $dataArray)){
								$finalString .= 
								'<div class="row">
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Month To:</label>
									<div class="col-xs-7">
										<select id="fmonth_to" name="fmonth_to" class="filter-status form-control">';
											$finalString .=  $this -> getFMonthsOptions(true);
											$finalString .= '</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("report_source", $dataArray)){
								$finalString .= 
								'<div class="row">
									
								<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Report Source:</label>
									<div class="col-xs-7">
										<select id="report_source" name="report_source" class="filter-status form-control" >
											<option value="flcfmr" >Facilities Monthly Reports</option>
											<option value="lhwmr" >LHW Monthly Reports</option>
										</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("hr_sub_type", $dataArray)){
								$finalString .= 
								'<div class="row">
									<div class="form-group">
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >HR Type:</label>
									<div class="col-xs-7">
										<select id="sub_type" name="sub_type" class="filter-status form-control" >
											<option value="0">-- ALL --</option>';
											foreach($dataArray['hr_sub_type'] as $row){
											
												$finalString .= '<option '.($this->input->post('type_id') && $this->input->post('type_id') ==  $row['type_id'] ? 'selected = "selected"' : '').' value="'.$row['type_id'].'" >'.$row['title'].'</option>';
											}
											$finalString .= '
										</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("status", $dataArray)){
								$finalString .= 
								'<div class="row">
									<div class="form-group">
									
									<label class="col-xs-3 col-xs-offset-1 control-label" >Status:</label>
									<div class="col-xs-7">
										 <select id="status" name="status" class="form-control" size="1" >';
											foreach($dataArray['status'] as $row){
											
												$finalString .= '<option '.($this->input->post('value') && $this->input->post('value') ==  $row['value'] ? 'selected = "selected"' : '').' value="'.$row['value'].'" >'.$row['caption'].'</option>';
											}
											$finalString .= '
										  </select>
									</div>
									<div class="col-xs-2"></div>
								</div></div>';
							}
							if(array_key_exists("advReport", $dataArray)){
								$finalString .= 
								'<div class="row">
								<div class="form-group">
									
									<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Report:</label>
									<div class="col-xs-7">
										<select id="advRptTitle" name="advRptTitle" class="filter-status form-control" >';
											while($row=$this->db->result_array("psql",$dataArray['advReport'])){
												$finalString .= '<option value="'.$row['report_id'].'" >'.$row['report_title'].'</option>';
											}
											$finalString .= 
										'</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("comp_report_type", $dataArray)){
								
								$finalString .= 
								'<div class="row">
								<div class="form-group">
								<label class="col-xs-3 col-xs-offset-1 control-label" for = "tcode" >Report Type:</label>
									<div class="col-xs-7">
									<select id="report_type" name="report_type" class="filter-status  form-control" >
										<option value="flcf">Facility wise</option>
										<option value="lhw" >LHW wise</option>
									</select>
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("lhwcolumns", $dataArray)){	
								$finalString .= '
								<div class="row">
								<div class="form-group">
									<label class="col-xs-3 control-label paddingzero" >Report Type:</label>
									<div class="col-xs-7 cmargin17">
								
										<input type="radio" name="repType" id="basicBtn" checked="checked" />Basic
										<input type="radio" name="repType" id="customBtn" />Custom
									</div>
									</div>
								</div>';
							}
							if(array_key_exists("epi_weeks", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "epiweekno" >EPI Week:</label>
										<div class="col-xs-7">
											<select name="week" id="week" class="filter-status  form-control">
											<option value="">Select Week</option>';
											
												for($i=1;$i<54;$i++){
												$finalString .= '<option value="'.$i.'">Week '.sprintf("%02d",$i).'</option>';
												}
											$finalString .= '
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("epi_weeks_select", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "epiweekno" >EPI Week:</label>
										<div class="col-xs-7">
											<select name="week" id="week" class="filter-status  form-control">';
											
												for($i=1;$i<54;$i++){
												$finalString .= '<option value="'.$i.'">Week '.sprintf("%02d",$i).'</option>';
												}
											$finalString .= '
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("epi_week_from_to", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "epiweekno" >EPI Week From:</label>
										<div class="col-xs-4">
											<select name="from_week" id="week_from" class="filter-status  form-control">';
												$finalString .= '<option> --Select--</option>';
												foreach ($dataArray['epi_week_from_to'] as $key=>$week){
													$finalString .= '<option value="'.$week['epi_week_numb'].'">Week '.sprintf("%02d",$week['epi_week_numb']).'</option>';
												}
											$finalString .= '
											</select>
										</div>
										<div class="col-xs-3">
											<input type="text" name="datefrom" id="datefrom" class="form-control" readonly="readonly">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "epiweekno" >EPI Week To:</label>
										<div class="col-xs-4">
											<select name="to_week" id="week_to" class="filter-status  form-control">';
												$finalString .= '<option> --Select--</option>';
												foreach ($dataArray['epi_week_from_to'] as $key=>$week){
													$finalString .= '<option value="'.$week['epi_week_numb'].'">Week '.sprintf("%02d",$week['epi_week_numb']).'</option>';
												}
											$finalString .= '
											</select>
										</div>
										<div class="col-xs-3">
											<input type="text" name="dateto" id="dateto" class="form-control" readonly="readonly">
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("month-from-to", $dataArray)){	
								$finalString .= '
								<div class="row"> 
									<div class="form-group">
										<label for="monthfrom" class="col-xs-3 col-xs-offset-1 control-label" id="monthfrom-label">Period From</label>
										<div class="col-xs-7">
											<input name="monthfrom" value="" id="monthfrom" class="form-control dp-my" required="required" data-date-end-date="-1m" type="text">
										</div>  					
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label for="monthto" class="col-xs-3 col-xs-offset-1 control-label" id="monthto-label">Period To</label>
										<div class="col-xs-7">
											<input name="monthto" value="" id="monthto" class="form-control dp-my" required="required" data-date-end-date="-1m" type="text">
										</div>  					
									</div>
								</div>';
							}
							if(array_key_exists("measles", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "disease" >Type of Case:</label>
										<div class="col-xs-7">
											<select class="form-control" name="case_type" id="case_type">
												<option value="Measles_other">Suspected Cases</option>
												<option value="Measles_cross_notified">Cross Notified</option>
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("afp", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "disease" >Type of Case:</label>
										<div class="col-xs-7">
											<select class="form-control" name="case_type" id="case_type">
												<option value="AFP">Acute Flaccid Paralysis</option>
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("nnt", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "disease" >Type of Case:</label>
										<div class="col-xs-7">
											<select class="form-control" name="case_type" id="case_type">
												<option value="NT">Neonatal Tetanus</option>
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("coronavirus", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "disease" >Type of Case:</label>
										<div class="col-xs-7">
											<select class="form-control" name="case_type" id="case_type">
												<option value="Covid">Coronavirus (COVID-19)</option>
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("case_type", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "disease" >Type of Case:</label>
										<div class="col-xs-7">
											<select class="form-control" name="case_type" id="case_type">

												<option value="Msl">Measles</option>
												<option value="Diph">Diphtheria</option>
												<option value="AFP">AFP</option>
												<option value="AEFI">AEFI</option>
												<option value="NT">NNT</option>
												<option value="AWD/Chol<5">Acute watery diarrhea < 5</option>
												<option value="HepB<5">Hepatitis B(Under 5 years)</option>
												<option value="CL">Cutaneous Leishmaniosis</option>
												<option value="Anth">Anthrax</option>
												<option value="VL">Visceral Leishmaniasis</option>
												<option value="SARI">Severe Acute Respiratory Illness(SARI)</option>
												<option value="DF">Dengue Fever</option>
												<option value="DHF">Dengue Hemorrhagic Fever (DHF)</option>
												<option value="CCHF">Crimean Congo Hemorrhagic Fever(CCHF)</option>
												<option value="ChTB">Childhood TB</option>
												<option value="Men">Meningitis</option>
												<option value="Pert">Pertussis</option>											
												<option value="Mal">Malaria</option>
												<option value="Pneu">Pneumonia</option>
												<option value="DogBite">Dog Bite</option>
												<option value="B Diar">Bloody Diarrhea</option>
												<option value="AIDS">HIV/AIDS</option>
												<option value="Typh">Typhoid</option>
												<option value="Scab">Scabies</option>
												<option value="AWD/Chol>5">Acute watery diarrhea > 5</option>
												<option value="Polio">Poliomyelitis</option>
												<option value="AVHep">Acute Viral Hepatitis (Acute Jaundice Syndrome)</option>
												<option value="Other">Others</option>
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("case_category", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label id = "cross_notify" name = "cross_notify" class="col-xs-3 col-xs-offset-1 control-label" for = "disease" >Case Category:</label>
										<div class="col-xs-7">
											<select class="form-control" name="cross_notified" id="cross_notified">
												<option value="0">Suspected Cases</option>
												<option value="1">Cross Notified Cases ( Pending Cases )</option>
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("lab_result", $dataArray)){	
								$finalString .= '
								<div class="row measles_result_dd" >
									<div class="form-group">
										<label id="lab_result" class="col-xs-3 col-xs-offset-1 control-label" for = "disease" >Lab Result:</label>
										<div class="col-xs-7">
											<select class="form-control" name="specimen_result" id="specimen_result">
												<option value="0">ALL</option>
												<option value="Positive">Positive</option>
												<option value="Negative">Negative</option>
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("test_result", $dataArray)){	
								$finalString .= '
								<div class="row measles_result_dd" >
									<div class="form-group">
										<label id="lab_result" class="col-xs-3 col-xs-offset-1 control-label" for = "disease" >Test Result:</label>
										<div class="col-xs-7">
											<select class="form-control" name="test_result" id="test_result">
												<option value="0">--Select--</option>
												<option value="Positive">Positive</option>
												<option value="Negative">Negative</option>
												<option value="Pending">Pending/Awaited</option>
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("disease", $dataArray)){	
								$finalString .= '
								<div class="row">
									<div class="form-group">
										<label class="col-xs-3 col-xs-offset-1 control-label" for = "disease" >Type of Case:</label>
										<div class="col-xs-7">
											<select class="form-control" name="case_type" id="case_type">
												<option value="">All Diseases</option>
												<option value="ILI">Influenza Like Illness(ILI)</option>
												<option value="SARI">Severe Acute Respiratory Illness(SARI)</option>
												<option value="AWD">Acute watery diarrhea / Cholera</option>
												<option value="DF">Dengue Fever</option>
												<option value="DHF">Dengue Hemorrhagic Fever (DHF)</option>
												<option value="CCHF">Crimean Congo Hemorrhagic Fever(CCHF)</option>
												<option value="Childhood TB">Childhood TB</option>
												<option value="Diarrhea">Diarrhea</option>
												<option value="Diphtheria">Diphtheria</option>
												<option value="Hepatitis">Hepatitis</option>
												<option value="Meningitis">Meningitis</option>
												<option value="Pertussis">Pertussis</option>
												<option value="Pneumonia">Pneumonia</option>
												<option value="Poliomyelitis">Poliomyelitis</option>
												<!--<option value="NT">Neonatal Tetanus</option>-->
												<!--<option value="Measles">Measles</option>-->
												<option value="Hepatitis (B)">Hepatitis (B)</option>
												<option value="MM">Meningococcal Meningitis</option>
												<option value="AURI">Acute Upper Respiratory Infection</option>
												<option value="AD">Acute Diarrhea (non-cholera)</option>
												<option value="BD">Bloody Diarrhea</option>
												<option value="AVH">Acute Viral Hepatitis (A&amp;E)</option>
												<option value="Malaria">Malaria</option>
												<option value="Leishmaniosis">Leishmaniosis</option>
												<option value="Typhoid fever">Typhoid fever</option>
												<option value="PUO">Pyrexia of Unknown Origin (PUO)</option>
												<option value="Scabies">Scabies</option>
												
											</select>
										</div>
									</div>
								</div>';
							}
							if(array_key_exists("in_out_coverage_dist", $dataArray)){
								$finalString .= 
												'<div class="row">
													
												<div class="form-group" id="in_out_coverage_dist">
													<label class="col-xs-3 col-xs-offset-1 control-label" for = "in_out_coverage" >Coverage Area:</label>
													<div class="col-xs-7">
														<select id="coverage_dist" name="in_out_coverage" class="filter-status form-control" >
															<option value="in_uc" selected="selected" >Inside UC</option>
															<option value="out_uc" >Outside UC</option>
															<option value="total_ucs" >Inside UC + Outside UC</option>
														</select>
													</div>
													</div>
												</div>';
							}
							if(array_key_exists("in_out_coverage_pro", $dataArray)){
								$finalString .= 
												'<div class="row">
													
												<div class="form-group" id="in_out_coverage_pro">
													<label class="col-xs-3 col-xs-offset-1 control-label" for = "in_out_coverage" >Coverage Area:</label>
													<div class="col-xs-7">
														<select id="coverage_pro" name="in_out_coverage" class="filter-status form-control" >
															<option value="in_district" selected="selected" >Inside District</option>
															<option value="out_district" >Outside District</option>
															<option value="total_districts" >Inside District + Outside District</option>
														</select>
													</div>
													</div>
												</div>';
							}
							if(array_key_exists("vaccinationType", $dataArray)){
								$finalString .= 
												'<div class="row">
													
												<div class="form-group">
													<label class="col-xs-3 col-xs-offset-1 control-label" for = "vaccinationType" >Vaccinated by:</label>
													<div class="col-xs-7">
														<select id="vaccinationType" name="vaccination_type" class="filter-status form-control" >
															<option value="all" selected="selected" >--All--</option>
															<option value="fixed" >Vaccinator (Fixed)</option>
															<option value="outreach" >Vaccinator (Outreach)</option>
															<option value="mobile" >Vaccinator (Mobile)</option>
															<option value="lhw" >Health House (LHW)</option>
														</select>
													</div>
													</div>
												</div>';
							}						
							if(array_key_exists("vaccinationTypeSession", $dataArray)){
								$finalString .= 
											'<div class="row">
												
											<div class="form-group">
												<label class="col-xs-3 col-xs-offset-1 control-label" for = "session_type" >Vaccinated by:</label>
												<div class="col-xs-7">
													<select id="session_type" name="session_type" class="filter-status form-control" >
														<option value="ALL" >ALL</option>
														<option value="Fixed" >Vaccinator (Fixed)</option>
														<option value="Outreach" >Vaccinator (Outreach)</option>
														<option value="Mobile" >Vaccinator (Mobile)</option>
														<option value="LHW" >Health House (LHW)</option>
													</select>
												</div>
												</div>
											</div>';
							}
							if(array_key_exists("period_wise", $dataArray)){
								$finalString .= 
											'<div class="row">
												
											<div class="form-group" id="period_wise">
												<label class="col-xs-3 col-xs-offset-1 control-label" for = "period_wise" >Period Wise</label>
												<div class="col-xs-7">
													<select  id="period_wisee" name="period_wise" class="filter-status form-control" >
														<option value="monthly" selected="selected" >Month Wise </option>
														<option value="quarterly" >Quarter Wise</option>
														
														
													</select>
												</div>
												</div>
											</div>';
							}														 
							if(array_key_exists("typeWise", $dataArray)){
								$finalString .= 
											'<div class="row">
												
											<div class="form-group" id="typeWise">
												<label class="col-xs-3 col-xs-offset-1 control-label" for = "typeWise" >Type Wise</label>
												<div class="col-xs-7">
													<select  name="typeWise" class="filter-status form-control" >
														<option value="facility" selected="selected" >Facility Wise</option>
														<option value="uc" >Union Council</option>
														<option value="tehsil" >Tehsil Wise</option>
													</select>
												</div>
												</div>
											</div>';
							}	
							if(array_key_exists("vacc_to", $dataArray)){
								$finalString .= 
												'<div class="row">
													
												<div class="form-group" id="vacc_to">
													<label class="col-xs-3 col-xs-offset-1 control-label" for = "vacc_to" >Vaccination To</label>
													<div class="col-xs-7">
														<select  name="vacc_to" class="filter-status form-control" >
															<option value="total_children" selected="selected" >Total Children</option>
															<option value="gender" >Gender Wise</option>
														</select>
													</div>
													</div>
												</div>';
							}	
							if(array_key_exists("age_wise", $dataArray)){
								$finalString .= 
												'<div class="row">
													
												<div class="form-group" id="age_wise">
													<label class="col-xs-3 col-xs-offset-1 control-label" for = "age_wise" >Age Group</label>
													<div class="col-xs-7">
														<select  name="age_wise" class="filter-status form-control" >
															<option value="all" selected="selected" >--ALL--</option>
															<option value="0to11" >0-11 Months</option>
															<option value="12to23" >12-23 Months</option>
															<!--<option value="under2" >Under 2 years</option>-->
															<option value="above2" >2 years and above</option>
														</select>
													</div>
													</div>
												</div>';
							}
							if(array_key_exists("lhwcolumns", $dataArray)){	
								$finalString .= '<hr /><div id="ColumnsDiv" class="form-group">
									
										<div class="row">
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="tcode" />
												<label class="control-label"  for = "tcode" > Tehsil </label>
											</div>									
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="facode" />
												<label class="control-label"  for = "facode" > Facility Name </label>
											</div>																			
										</div>
										<div class="row">
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="husbandname" />
												<label class="control-label"  for = "husbandname" > Husband Name </label>
											</div>									
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="fathername" />
												<label class="control-label"  for = "fathername" > Father Name </label>
											</div>									
										</div>
									
										<div class="row">
											
										<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="bankbranch" />
												<label class="control-label"  for = "nic" > Bank Branch </label>
											</div>
											
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="bankaccount" />
												<label class="control-label"  for = "bankaccount" >Bank Account #</label>
											</div>									
										</div>
										
										<div class="row">
											
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="lhscode" />
												<label class="control-label"  for = "lhscode" > LHS Name</label>
											</div>
											
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="nic" />
												<label class="control-label"  for = "nic" > NIC # </label>
											</div>
																		
										</div>
										
										<div class="row">
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="date_of_birth" />
												<label class="control-label"  for = "date_of_birth" > Date of Birth </label>
											</div>	
											
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="distcode" />
												<label class="control-label"  for = "distcode" > District </label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="uncode" />
												<label class="control-label"  for = "uncode" > Union Council </label>
											</div>
											
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="catch_area_pop" />
												<label class="control-label"  for = "catch_area_pop" > Catchment Area Population </label>
											</div>
										</div>
									
										<div class="row">
											
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="catch_area_name" />
												<label class="control-label"  for = "catch_area_name" > Catchment Area Name </label>
											</div>
											
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="permanent_address" />
												<label class="control-label"  for = "permanent_address" > Permanent Address </label>
											</div>
											
											
										</div>
										
										<div class="row">
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="present_address" />
												<label class="control-label"  for = "present_address" > Present Address </label>
											</div>
											
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="lastqualification" />
												<label class="control-label"  for = "lastqualification" > Last Qualification </label>
											</div>
											</div>
										
										<div class="row">
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="passing
		" />
												<label class="control-label"  for = "passingyear" > Passing Year </label>
											</div>
											
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="institutename" />
												<label class="control-label"  for = "institutename" > Institute Name </label>
											</div>									
										</div>
									
										<div class="row">
											
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="date_joining" />
												<label class="control-label"  for = "date_joining" > Date Of Joining </label>
											</div>
											
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="place_of_joining" />
												<label class="control-label"  for = "place_of_joining" > Place of Joining </label>
											</div>
																			
										</div>
										
										<div class="row">
										<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="date_termination" />
												<label class="control-label"  for = "date_termination" > Date Termination </label>
											</div>	
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="status" />
												<label class="control-label"  for = "status" > Status </label>
											</div>
										</div>
										
										<div class="row">
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="areatype" />
												<label class="control-label"  for = "areatype" > Area Type </label>
											</div>
											
											<div class="col-xs-5">
												<input type="checkbox" name="SelectedColumn[]" value="basic_training_end_date" />
												<label class="control-label"  for = "basic_training_start_date" > Basic Training Start Date </label>
											</div>
										</div>
									
										<div class="row">
											
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="basic_training_start_date" />
												<label class="control-label"  for = "basic_training_end_date" > Basic Training End Date </label>
											</div>
											
											<div class="col-xs-6">
												<input type="checkbox" name="SelectedColumn[]" value="tenmonth_training_start_date" />
												<label class="control-label"  for = "tenmonth_training_start_date" > Ten Month Training Start Date </label>
											</div>
											
										</div>
										<div class="row">
											<div class="col-xs-5 col-xs-offset-1">
												<input type="checkbox" name="SelectedColumn[]" value="tenmonth_training_end_date" />
												<label class="control-label"  for = "tenmonth_training_end_date" > Ten Month Training End Date </label>
											</div>
											<div class="col-xs-5"></div>
										</div>
										
									<input type="hidden" id="ReportType" name="ReportType" value="basic">
								</div>';
							}
							$finalString .= '<hr>
									<div class="row">
										<div class="col-xs-3" style="margin-left: 71%;">
											<button type="submit" name="submit1" id="pre-btn" class="task task__content btn btn-md btn-success"><i class="fa fa-search"></i> Preview </button>
											<div class="col-xs-6" style="margin-left: 73%;">
												<nav id="context-menu" class="context-menu">
													<ul class="context-menu__items">
														<li class="context-menu__item">
															<button type="submit" name="submit2" class="context-menu__link" data-action="View" value="1">Open in New Tab</button>
															<button type="submit" name="submit3" class="context-menu__link" data-action="Edit" value="2">Open in Same Tab</button>
														</li>
													</ul>
												</nav>
											</div>
										</div>
									</div><br>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>';
		return $finalString;
	}
	function getFMonthsOptions($isreturn=false){
		$months = array(12 => 'December', 11 => 'November', 10 => 'October', 9 => 'September', 8 => 'August', 7 => 'July', 6 => 'June', 5 => 'May', 4 => 'April', 3 => 'March', 2 => 'February', 1 => 'January');
		$years=date('Y');
		$output = '';
		$preyears=2014;
		for($x=$years;$x>=$preyears;$x--){
			foreach ($months as $num => $monthitem) { 
				if(($x==$years) && ($num > date('m'))){}
				else{
					if($num<10){$month='0'.$num;}else{$month=$num;}
					$val = $x."-".$month;
					$output .= '<option value="'.$val.'" >'.$val.'</option>';								
				}
			}
		}	
		if($isreturn)
			return $output;
		echo $output;
	}
}
?>