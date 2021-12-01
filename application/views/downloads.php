<style type="text/css">
	a.a-link{
		display: block;
		background: #008d4ccc;
		padding-left: 32px;
		color: #fff;
		font-weight: bold;
	}
	.p-0{
		padding:0px !important;
	}
	.mt-1{
		margin-top:1px !important;
	}
	.pl-5{
		padding-left:45px !important;
	}
</style>
<?php 
	$basePath = base_url();
	$assetsPath = base_url()."assets/";
?>
		<div class="container">
		  	<div ></div>
	  		<div class="row" style="padding-top: 25px; padding-bottom: 25px;">
				<div class="col-xs-12 text-center">
		  			<h2 style="font-weight:bold; text-shadow: 0px 1px 1px !important;">Downloadable Helping Material</h2>
				</div>
	  		</div>

	  		<div class="row">
				<div class="col-xs-8 col-xs-offset-2">
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading pheadingchecklists">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsevp">
										<span class="glyphicon glyphicon-plus"></span>
										System Setup Module
									</a>
								</h4>
							</div>
							<div id="collapsevp" class="panel-collapse collapse mt-1">
								<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapsevp" href="#collapsevp1">
									<span class="glyphicon glyphicon-edit"></span>
									Data Entry Forms
								</a>
							  	<div class="panel-body p-0 pl-5">			
									<div id="collapsevp1" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/hr_forms/Supervisor Form.docx">- Supervisor Form </a>
								  		<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/hr_forms/Supervisor Form.docx">
									  		<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
									  		<a href="<?php echo $assetsPath; ?>files/hr_forms/Supervisor Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
								  		</span><br>
										<a href="<?php echo $assetsPath; ?>files/hr_forms/EPI Technician.docx">- EPI Technician Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/hr_forms/EPI Technician.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/hr_forms/EPI Technician.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/hr_forms/Other HRs Form.docx">- Other HRs Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/hr_forms/Other HRs Form.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/hr_forms/Other HRs Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
									</div>
		  						</div>
		  						<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapsevp" href="#collapseguidelinesM1">
									<span class="glyphicon glyphicon-book"></span>
									Guidelines
								</a>
								<div class="panel-body p-0 pl-5">
									<div id="collapseguidelinesM1" class="panel-collapse collapse">

									</div>
								</div>
							</div>
	  					</div>
					  	<div class="panel panel-default">
							<div class="panel-heading pheadingchecklists">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										<span class="glyphicon glyphicon-plus"></span>
										EPI Vaccination Module
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse mt-1">
								<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne1">
									<span class="glyphicon glyphicon-edit"></span>
									Data Entry Forms
								</a>
								<div class="panel-body p-0 pl-5">			
									<div id="collapseOne1" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/epi_vaccination/HF Monthly Reporting Form.xlsx">- HF Monthly Reporting Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/epi_vaccination/HF Monthly Reporting Form.xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>
											<!-- <a href="<?php echo $assetsPath; ?>files/vaccine_management/HF Consumption and Requisition Form (Others).pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a> -->
										</span><br>										
									</div>									
		  						</div>
		  						<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapseOne" href="#collapseguidelines1">
									<span class="glyphicon glyphicon-book"></span>
									Guidelines
								</a>
								<div class="panel-body p-0 pl-5">
									<div id="collapseguidelines1" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/epi_vaccination/EPI Indicator_Calculations.docx">- EPI Indicator Calculations</a>
										<span  class="checklists">
											<a href="<?php echo $assetsPath; ?>files/epi_vaccination/EPI Indicator_Calculations.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/epi_vaccination/EPI Indicator_Calculations.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span>
									</div>
								</div>
							</div>
	  					</div>
						<div class="panel panel-default">
							<div class="panel-heading pheadingchecklists">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									<span class="glyphicon glyphicon-plus"></span>
									Vaccine Management Module
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse mt-1">
								<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapseTwo" href="#collapseTwo1">
									<span class="glyphicon glyphicon-edit"></span>
									Data Entry Forms
								</a>
								<div class="panel-body p-0 pl-5">
									<div id="collapseTwo1" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/vaccine_management/HF Consumption and Requisition Form (KPK).xlsx">- HF Consumption and Requisition Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/HF Consumption and Requisition Form (KPK).xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>
											<!-- <a href="<?php echo $assetsPath; ?>files/vaccine_management/HF Consumption and Requisition Form (Others).pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a> -->
										</span><br>
										<!-- <a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-A_I Stock Receipt-Issue Form_03 April 2014 Approved.docx">- Form-A_I Stock Receipt-Issue Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-A_I Stock Receipt-Issue Form_03 April 2014 Approved.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-A_I Stock Receipt-Issue Form_03 April 2014 Approved.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-A_II Stock Receipt-Issue Form_01 July 2014 Revised.docx">- Form-A_II Stock Receipt-Issue Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-A_II Stock Receipt-Issue Form_01 July 2014 Revised.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-A_II Stock Receipt-Issue Form_01 July 2014 Revised.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br> 
										<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-B Monthly Consumption & Requisition Form_RI_03 April 2014 Approved.docx">- Form-B Monthly Consumption & Requisition Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-B Monthly Consumption & Requisition Form_RI_03 April 2014 Approved.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-B Monthly Consumption & Requisition Form_RI_03 April 2014 Approved.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-C Monthly Consumption & Requisition Form_SIA_01 July 2014 Revised.docx">- Form-C Monthly Consumption & Requisition Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-C Monthly Consumption & Requisition Form_SIA_01 July 2014 Revised.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Form-C Monthly Consumption & Requisition Form_SIA_01 July 2014 Revised.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br> -->													 
									</div>
								</div>
								<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapseTwo" href="#collapseguidelines2">
									<span class="glyphicon glyphicon-book"></span>
									Guidelines
								</a>
								<div class="panel-body p-0 pl-5">
									<div id="collapseguidelines2" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/vaccine_management/Guidelines for using EPI forms_01 July 2014 Revised.docx">- Guidelines for Using EPI Vaccine Forms </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Guidelines for using EPI forms_01 July 2014 Revised.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/Guidelines for using EPI forms_01 July 2014 Revised.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>	
										<a href="<?php echo $assetsPath; ?>files/vaccine_management/EPI recording and reporting tools.xls">- EPI Recording & Reporting Tools </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/vaccine_management/EPI recording and reporting tools.xls">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>				
										</span>	
									</div>
								</div>
	  						</div>
	  					</div>
						<div class="panel panel-default">
							<div class="panel-heading pheadingchecklists">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									<span class="glyphicon glyphicon-plus"></span>
									Disease Surveillance Module
									</a>
								</h4>
							</div>
							<div id="collapseThree" class="panel-collapse collapse mt-1">
								<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree1">
									<span class="glyphicon glyphicon-edit"></span>
									Data Entry Forms
								</a>

								<div class="panel-body p-0 pl-5">			
									<div id="collapseThree1" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Zero Reporting Form.xlsx">- Zero Reporting Form </a>
										<span  class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Zero Reporting Form.xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>				
											<!-- <a href="<?php //echo $assetsPath; ?>files/disease_surveillance/Measles Case Investigation Linelist.pdf" target="_blank">
											<img src="<?php //echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a> -->
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Measles Case Investigation Form.xlsx">- Measles Case Investigation Form </a>
										<span  class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Measles Case Investigation Form.xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>				
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Measles Case Investigation Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span>
										<br>
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/NNT Case Investigation Form.docx">- NNT Case Investigation Form </a>
										<span  class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/NNT Case Investigation Form.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>				
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/NNT Case Investigation Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span>	
										<br>
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Diphtheria Case Investigation Form.docx">- Diphtheria Case Investigation Form </a>
										<span  class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Diphtheria Case Investigation Form.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>				
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Diphtheria Case Investigation Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span>	
										<br>
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Pertussis Case Investigation Form.docx">- Pertussis Case Investigation Form.docx </a>
										<span  class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Pertussis Case Investigation Form.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>				
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Pertussis Case Investigation Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Measles Case Investigation Linelist.xls">- Measles Case Investigation Linelist </a>
										<span  class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Measles Case Investigation Linelist.xls">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>				
											<!-- <a href="<?php //echo $assetsPath; ?>files/disease_surveillance/Measles Case Investigation Linelist.pdf" target="_blank">
											<img src="<?php //echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a> -->
										</span><br>										
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Outbreak Response Form.xlsx">- Outbreak Response Form </a>
										<span  class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Outbreak Response Form.xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>				
											<!-- <a href="<?php //echo $assetsPath; ?>files/disease_surveillance/Measles Case Investigation Linelist.pdf" target="_blank">
											<img src="<?php //echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a> -->
										</span><br>	
									</div> 
								</div>

								<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapseThree" href="#collapseguidelines3">
									<span class="glyphicon glyphicon-book"></span>
									Guidelines
								</a>
								<div class="panel-body p-0 pl-5">
									<div id="collapseguidelines3" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Guidelines for Measles case based surveillance and outbreak investigation.pdf">- Guidelines for Measles Case Based Surveillance and Outbreak Investigation</a>
										<span class="checklists">				
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Guidelines for Measles case based surveillance and outbreak investigation.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>			
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/AEFI Surveillance guideline_English_Pak.pdf">- AEFI Surveillance Guideline </a>
										<span  class="checklists">				
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/AEFI Surveillance guideline_English_Pak.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/AEFI.ppt">- AEFI</a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/AEFI.ppt">
											<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/VPD Case Definitions.docx">- VPD Case Definitions</a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/VPD Case Definitions.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/VPD Case Definitions.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Laboratory based Surveillance of Measles and Rubella virus.ppt">- Laboratory based Surveillance of Measles and Rubella virus</a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Laboratory based Surveillance of Measles and Rubella virus.ppt">
											<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
										<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Integrated VPD Surveillance.ppt">- Integrated VPD Surveillance</a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/disease_surveillance/Integrated VPD Surveillance.ppt">
											<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
										</span><br>	
										</span><br>
									</div>												 
								</div>
							</div>
	  					</div>
						<div class="panel panel-default">
							<div class="panel-heading pheadingchecklists">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsefour">
									<span class="glyphicon glyphicon-plus"></span>
									Cold Chain Module
									</a>
								</h4>
							</div>
							<div id="collapsefour" class="panel-collapse collapse mt-1">
								<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapsefour" href="#collapsefour1">
									<span class="glyphicon glyphicon-edit"></span>
									Data Entry Forms
								</a>
								<div class="panel-body p-0 pl-5">			
									<div id="collapsefour1" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/cold_chain/Refrigerator_Freezer_ILR Asset Form.xlsx">- Refrigerator/Freezer/ILR Asset Form </a>
								  		<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Refrigerator_Freezer_ILR Asset Form.xlsx">
									  		<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>
									  		<a href="<?php echo $assetsPath; ?>files/cold_chain/Refrigerator_Freezer_ILR Asset Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
								  		</span><br>
										<a href="<?php echo $assetsPath; ?>files/cold_chain/Generator Form.xlsx">- Generator Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Generator Form.xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Generator Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/cold_chain/Voltage Regulator Form.xlsx">- Voltage Regulator Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Voltage Regulator Form.xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Voltage Regulator Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/cold_chain/Cold Room Form.xlsx">- Cold Room Form </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Cold Room Form.xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Cold Room Form.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
																	
									</div>
		  						</div>
		  						<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapsefour" href="#collapseguidelines4">
									<span class="glyphicon glyphicon-book"></span>
									Guidelines
								</a>
								<div class="panel-body p-0 pl-5">
									<div id="collapseguidelines4" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/cold_chain/Cold Chain.ppt">- Cold Chain</a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Cold Chain.ppt">
											<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/cold_chain/Supplement to Revised Guide to Questionnaires 14-Oct-2013 SSH.docx">- Supplement to Revised Guide to Questionnaires </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Supplement to Revised Guide to Questionnaires 14-Oct-2013 SSH.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Supplement to Revised Guide to Questionnaires 14-Oct-2013 SSH.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/cold_chain/Original Equipment Identification Guide 2010-10-20.docx">- Original Equipment Identification Guide </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Original Equipment Identification Guide 2010-10-20.docx">
											<img src="<?php echo $assetsPath; ?>images/word.png" style="height:22px;"></a>
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Original Equipment Identification Guide 2010-10-20.pdf" target="_blank">
											<img src="<?php echo $assetsPath; ?>images/pdf.png" style="height:20px;"></a>
										</span><br>
										<a href="<?php echo $assetsPath; ?>files/cold_chain/Calculation Sheet Questionnaire Annex SSH.xlsx">- Calculation Sheet Questionnaire Annex SSH </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/cold_chain/Calculation Sheet Questionnaire Annex SSH.xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>
										</span>
									</div>
								</div>
							</div>
	  					</div>
						<div class="panel panel-default">
							<div class="panel-heading pheadingchecklists">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseeight">
									<span class="glyphicon glyphicon-plus"></span>
									RED REC Module
									</a>
								</h4>
							</div>
							<div id="collapseeight" class="panel-collapse collapse mt-1">
								<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapseeight" href="#collapseeight1">
									<span class="glyphicon glyphicon-edit"></span>
									Data Entry Forms
								</a>
								<div class="panel-body p-0 pl-5">
									<div id="collapseeight1" class="panel-collapse collapse">	
										<a href="<?php echo $assetsPath; ?>files/red_rec/RED REC Microplan with Urdu.xlsx">- RED REC Microplan</a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/red_rec/RED REC Microplan with Urdu.xlsx">
											<img src="<?php echo $assetsPath; ?>images/excel.png" style="height:25px;"></a>
										</span><br>	
									</div>							  
								</div>
								<a class="accordion-toggle a-link" data-toggle="collapse" data-parent="#collapseeight" href="#collapseguidelines5">
									<span class="glyphicon glyphicon-book"></span>
									Guidelines
								</a>
								<div class="panel-body p-0 pl-5">
									<div id="collapseguidelines5" class="panel-collapse collapse">
										<a href="<?php echo $assetsPath; ?>files/red_rec/Integrated Micro-planning for Routine Immunization.ppt">- Integrated Micro-planning for Routine Immunization </a>
										<span class="checklists">
											<a href="<?php echo $assetsPath; ?>files/red_rec/Integrated Micro-planning for Routine Immunization.ppt">
											<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
										</span><br>
									</div>
								</div>
							</div>
	  					</div>
	  					<div class="panel panel-default">
							<div class="panel-heading pheadingchecklists">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsenine">
									<span class="glyphicon glyphicon-plus"></span>
									Other Material 
									</a>
								</h4>
							</div>
							<div id="collapsenine" class="panel-collapse collapse">
								<div class="panel-body">
									<a href="<?php echo $assetsPath; ?>files/other_material/Role and responsibility.pptx">- Role and responsibility</a>
									<span class="checklists">
										<a href="<?php echo $assetsPath; ?>files/other_material/Role and responsibility.pptx">
										<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
									</span><br>		
									<a href="<?php echo $assetsPath; ?>files/other_material/Vaccines in EPI.ppt">- Vaccines in EPI</a>
									<span class="checklists">
										<a href="<?php echo $assetsPath; ?>files/other_material/Vaccines in EPI.ppt">
										<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
									</span><br>											
									<a href="<?php echo $assetsPath; ?>files/other_material/Immunization Safety_Injection Techniques_waste disposal.ppt">- Immunization Safety_Injection Techniques_waste disposal</a>
									<span class="checklists">
										<a href="<?php echo $assetsPath; ?>files/other_material/Immunization Safety_Injection Techniques_waste disposal.ppt">
										<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
									</span><br>
									<a href="<?php echo $assetsPath; ?>files/other_material/Basic EPI calculation.ppt">- Basic EPI calculation</a>
									<span class="checklists">
										<a href="<?php echo $assetsPath; ?>files/other_material/Basic EPI calculation.ppt">
										<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
									</span><br>
									<a href="<?php echo $assetsPath; ?>files/other_material/Integrated Micro-planning for Routine Immunization.ppt">- Integrated Micro-planning for Routine Immunization</a>
									<span class="checklists">
										<a href="<?php echo $assetsPath; ?>files/other_material/Integrated Micro-planning for Routine Immunization.ppt">
										<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
									</span><br>
									<a href="<?php echo $assetsPath; ?>files/other_material/Monitoring of RI.pptx">- Monitoring of RI</a>
									<span class="checklists">
										<a href="<?php echo $assetsPath; ?>files/other_material/Monitoring of RI.pptx">
										<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
									</span><br>	
									<a href="<?php echo $assetsPath; ?>files/other_material/EPI Communication.pptx">- EPI Communication</a>
									<span class="checklists">
										<a href="<?php echo $assetsPath; ?>files/other_material/EPI Communication.pptx">
										<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
									</span><br>									
									<a href="<?php echo $assetsPath; ?>files/other_material/Recording_Reporting.pptx">- Recording_Reporting</a>
									<span class="checklists">
										<a href="<?php echo $assetsPath; ?>files/other_material/Recording_Reporting.pptx">
										<img src="<?php echo $assetsPath; ?>images/powerpoint.png" style="height:22px;"></a>
									</span><br>
								</div>
							</div>
	  					</div>					  	
					</div>
				</div>
			</div>
		</div><!--end of container-->		
	</body>
</html>