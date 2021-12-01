<?php $utype=$this -> session -> utype;
 ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
	<!-- /.search form -->
	<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<?php if($this -> session -> username != 'kp_kphis'){ ?>
			<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>"><i class="fa fa-home"></i><span>Home</span></a></li>
			<?php if($this -> session -> UserLevel == '2' && $utype == 'Manager') { ?>
			<li class="parent-uk treeview">
				<a href="#"><i class="fa fa-th"></i>Admin Configuration<i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Adjustment-Vaccines"><i class="fa fa-plus" aria-hidden="true"></i>Add Vaccine Adjustment</a></li> 
					<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Purpose-Type"><i class="fa fa-plus" aria-hidden="true"></i>Add Vaccine Purpose</a></li>
					<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Vaccines-Manufacturers"><i class="fa fa-plus" aria-hidden="true"></i>Add Vaccine Manufacturer</a></li>
					<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Stake-Holder"><i class="fa fa-plus" aria-hidden="true"></i>Add Stake Holder</a></li>
					<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Manage-Warehouse"><i class="fa fa-plus" aria-hidden="true"></i>Manage Warehouse Type</a></li>
				</ul>				
			</li>
			<?php } ?>
			<li class="parent-uk treeview">
				<a href="#">
					<i class="fa fa-th"></i>
					<span>System Setup</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu ">
					<li class="parent-uk">
						<a href="#"><i class="fa fa-circle-o"></i> Human Resource <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<?php if($utype != 'idsrs_manager'){ ?>
							<li class="parent-uk">
								<a href="#"><i class="fa fa-play"></i> Manage HR <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>SupervisorList">Supervisor</a></li> 
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>DSOList">District Surveillance Officer</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Computer-Operator-List">Computer Operator</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>HF-Incharge/List">HF Incharge</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Store-keeper">Store Keeper</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>TechnicianList">EPI Technicians</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Cold-Chain-Technician/List">CC Technician</a></li> 
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Cold-Chain-Operator/List">CC Operator</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Generator-Operator/List">Generator Operator</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Cold-Chain-Mechanic/List">CC Mechanic</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>DriverList">Driver</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Sanctioned_posts/sanctionedPosts">Sanctioned Posts</a></li>
								</ul>
							</li> 
							<?php } ?>
							<li class="parent-uk">
								<a href="#"><i class="fa fa-play"></i>HR Reports<i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/supervisor">Supervisor Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/district_Surveillance_Officer">District Surveillance Officer Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/Computer_Operator">Computer Operator Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/med_technician">HF Incharge Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/StoreKeeper">Store Keeper Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/technician">EPI Technicians Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/Cold_Chain_Technician">CC Technician Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/Cold_Chain_Operator">CC Operator Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/Generator_Operator">Generator Operator Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/Cold_Chain_Mechanic">CC Mechanic Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Setup/Listing/cold_Chain_Driver">Drivers Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Sanctionedposts_report/sanctionedpostsreport">Sanctioned Posts Report</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Reports/Filters/HR-Summary-Report">HR Summary Report</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Reports/retiredHRreport">Retired HR Report</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="parent-uk">
						<a href="#"><i class="fa fa-circle-o"></i>  Health Infrastructure<i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<?php if($utype != 'idsrs_manager'){ ?>
							<li class="parent-uk">
								<a href="#"><i class="fa fa-play"></i>Administrative Setup<i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>EPICentersList">Manage EPI Center</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Villages/village_add">Manage Villages</a></li>
								</ul>
							</li>
							<?php } ?>
							<li class="parent-uk">
								<a href="#"><i class="fa fa-play"></i>Administrative Reports<i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<?php if($this -> session -> UserLevel == '2'){ ?>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>setup_listing/listing/district">District Listing</a></li>
									<?php } ?>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>setup_listing/listing/tehsil">Tehsil Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>setup_listing/listing/union_Council">Union Council Listing</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>setup_listing/listing/EPI_Centers">EPI Center Listing</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<?php if($this -> session -> UserLevel == '3'){ ?>
					<li class="parent-uk treeview">
						<a href="#">
							<i class="fa fa-circle-o"></i> <span>Population Management</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Population/Facilities">EPI Center Population</a></li>
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Population/UC">Union Council Population</a></li>
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Population/Tehsil">Tehsil Population</a></li>
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Population/Districts">District Population</a></li>							
						</ul>
					</li>
					<?php } ?>
				</ul>
			</li>
			<li class="parent-uk treeview">
				<a href="#">
					<i class="fa fa-child"></i> <span>EPI Vaccination</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this -> session -> UserLevel == '3' && $utype != 'idsrs_manager' && $utype != 'Manager'){ ?>
					<li class="parent-uk">
						<a href="#"><i class="fa fa-circle-o"></i>  Data Entry <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>FLCF-MVRF/List">HF Monthly Reporting Form</a></li>
						</ul>
					</li>
					<?php } ?> 
					<li class="parent-uk">
						<a href="#"><i class="fa fa-circle-o"></i> Reports <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<!--<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Reports/Filters/Facility-Wise-Vaccination">Monthly Facility wise Vaccination</a></li> -->
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Reports/Filters/Facility-Wise-Vaccination-Coverage_MaleFemale">Vaccination Coverage</a></li>
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Reports/Filters/Session-planned-conducted">Sessions Planned/Conducted</a></li>
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Reports/Filters/Dropout">Dropouts</a></li>
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Reports/Filters/Measle-Coverage-Dropout">Measles Coverage Vs. Cases</a></li>
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Indicator_Reports_New/reportFilters/HFMVRF">Indicator Report</a></li>
							<?php if($utype != 'idsrs_manager' && $utype != 'Manager'){ ?>
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Advance-Report/Filters/HFMVRF-Advance-Report">Advance Report</a></li>							
							<?php } ?>
						</ul>
					</li>
					<li class="parent-uk">
						<a href="#"><i class="fa fa-circle-o"></i>  Compliance <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Compliance-Filter/HFMVRF">HF Monthly Compliance</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li class="parent-uk treeview">
				<a href="#"><i class="fa fa-tasks"></i> <span>Vaccine Management</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<?php if( $utype != 'idsrs_manager'  ){ ?>
					<?php if(($this -> session -> UserLevel == '3' && $utype=='DEO') || ($this -> session -> UserLevel == '2' && $utype=='Manager')){?>
					<li class="parent-uk">
						<a href="#"><i class="fa fa-circle-o"></i> Data Entry <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="parent-uk"> 
								<a href="#"><i class="fa fa-play"></i> EPI Vaccine<i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
								<?php if($this -> session -> UserLevel == '3' && $utype=='DEO'){ ?>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>HF-Consumption-Requisition/List">HF Consumption & Requisition  </a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Province-Issue-Receipt/List">Province Issue & Receipt </a></li>

								<?php } ?>								
								<?php if($this -> session -> UserLevel == '2' && $utype=='Manager' ){ ?>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Federal-Issue-Receipt/List">Federal Issue & Receipt</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Province-Issue-Receipt/List">Province Issue & Receipt </a></li>
								<?php } ?>
								</ul>
							</li>
							<?php if($this -> session -> UserLevel == '3' && $utype=='DEO'){ ?>
							<li class="parent-uk">
								<a href="#"><i class="fa fa-play"></i>SIA<i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>District-Issue-Receipt/List">District Issue & Receipt</a></li>
									<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>UC-Demand-Consumption/List">UC Demand, Consumption & Receipt</a></li>
								</ul>
							</li>
							<?php } ?>
						</ul>
					</li> 
					<?php } ?>
					<?php } ?>
					<li class="parent-uk">
						<a href="#"><i class="fa fa-circle-o"></i> Reports<i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Reports/HF-Consumption-Requisition-Report">Cumulative  Consumption</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Reports/Filters/Vaccine-Demand">Monthly Consumption</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Indicator-Report/Filters/Vaccine">Indicator Report</a></li>
						<?php if($utype != 'idsrs_manager' && $utype != 'Manager'){ ?>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Advance-Report/Filters/HFCR-Advance-Report">Advance Report</a></li>
						<?php } ?>
						</ul>
					</li>
					<li class="parent-uk">
						<a href="#"><i class="fa fa-circle-o"></i>Compliance<i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Compliance-Filter/HF-Consumption-Requisition">HF Consumption & Requisition <br>Compliance</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li class="parent-uk treeview">
				<a href="#"><i class="fa fa-eye"></i> <span>Disease Surveillance</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<?php if($utype =='idsrs_manager' || $utype=='DEO'){?>
						<li class="parent-uk">
							<a class="anchor-uk" href="<?php echo base_url();?>Zero-Reporting"><i class="fa fa-circle-o"></i>Zero Reporting Form</a>
						</li>
						<li class="parent-uk">
							<a href="#"><i class="fa fa-circle-o"></i>Case Investigation Form<i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Case_investigation/case_investigation_list">Main Case Investigation</a></li>
								<!-- <li class="parent-uk"><a class="anchor-uk" href="<?php //echo base_url();?>Measles-CIF/List">Measles</a></li> -->
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>NNT-CIF/List">NNT</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>AFP-CIF/List">AFP</a></li>
								<!-- <li class="parent-uk"><a class="anchor-uk" href="<?php //echo base_url();?>Disease-Surveillance/List">Other Diseases</a></li> -->
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>AEFI-CIF/List">AEFI</a></li>								
							</ul>
						</li>
						<li class="parent-uk">
							<a href="#"><i class="fa fa-circle-o"></i>Case Response Form<i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Case_response/list_measles_case_response">Measles Case Response</a></li> 
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Case_response/list_diphtheria_case_response">Diphtheria Case Response</a></li>
							</ul>
						</li>
					<?php } ?>
						<li class="parent-uk">
							<a href="#"><i class="fa fa-circle-o"></i> Reports<i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Linelists/Linelists_Filters/Surveillance/cases">Measles Line List</a></li>
								<!-- <li class="parent-uk"><a class="anchor-uk" href="<?php //echo base_url();?>Linelists/Linelists_Filters/Surveillance/measles">Measles Line List</a></li> -->
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Linelists/Linelists_Filters/Surveillance/afp">AFP Line List</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Linelists/Linelists_Filters/Surveillance/nnt">NNT Line List</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Linelists/AEFI_Filters">AEFI Line List</a></li>
								<!-- <li class="parent-uk"><a class="anchor-uk" href="<?php //echo base_url();?>Linelists/Linelists_Filters/Surveillance">Other Diseases Line List</a></li> -->								
								<?php if( ! ($this -> session -> District)){ ?>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Surveillance/Filters/EPID">Age/Gender Wise Count of EPID</a></li>
								<?php } ?>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Surveillance/Filters/OUTBREAK">Disease Outbreak Report</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Surveillance/Filters/VPD">Weekly/ Monthly VPDs</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Indicator-Report/IdsrsFilters/priority-diseases">Diseases with High Rate of Morbidity</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Indicator-Report/IdsrsFilters/morbidity">Diseases with High Rate of Mortality</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Indicator-Report/Filters/Disease">Indicator Report</a></li>
							</ul>
						</li>
						<li class="parent-uk">
							<a href="#"><i class="fa fa-circle-o"></i>Compliance<i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Compliance-Filter/Zero-Compliance">Zero Reporting <br>Timeliness/Completeness</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Compliance-Filter/Measles-Compliance">Measles Weekly Compliance</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Compliance-Filter/NNT-Compliance">NNT Weekly Compliance</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Compliance-Filter/AFP-Compliance">AFP Weekly Compliance</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Compliance-Filter/Other-Compliance">Other Diseases Weekly Compliance</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>Compliance-Filter/AEFI-Compliance">AEFI Weekly Compliance</a></li>
							</ul>
						</li>
				</ul>
			</li>
			<?php if($utype != 'idsrs_manager' ){ ?>
				<li class="parent-uk treeview">
					<a href="#"><i class="fa fa-cubes"></i><span>Inventory Management</span><i class="fa fa-angle-left pull-right"></i></a>           
					<ul class="treeview-menu">
						<?php if($this -> session -> UserLevel == '2' && $utype == 'Manager'){ ?>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>StockReceivefromSupplier"><i class="fa fa-circle-o"></i>Stock Receive (Supplier)</a></li>
						<?php } ?>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>StockReceivefromStore"><i class="fa fa-circle-o"></i>Stock Receive from Store</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>stockReceiveSearch"><i class="fa fa-circle-o"></i>Stock Receive - Search</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>batchManagement"><i class="fa fa-circle-o"></i>Batch Mangement</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>StockIssue"><i class="fa fa-circle-o"></i>Stock Issue/Dispatch</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>stockIssueSearch"><i class="fa fa-circle-o"></i>Stock Issue - Search</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>stockAdjustment"><i class="fa fa-circle-o"></i>Add Adjustment</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>adjustmentSearch"><i class="fa fa-circle-o"></i>Adjustment - Search</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>stockTransferSearch"><i class="fa fa-circle-o"></i>Purpose Transfer</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>vvmManagement"><i class="fa fa-circle-o"></i>VVM Management</a></li>
					</ul>
				</li>
				<li class="parent-uk treeview">
					<a href="#"><i class="fa fa-cubes"></i><span>Cold Chain Management</span><i class="fa fa-angle-left pull-right"></i></a>           
					<ul class="treeview-menu">      
					
						<li class="parent-uk">  
							 <?php if($utype != 'idsrs_manager' && $utype != 'Manager' ){ ?>
							<a href="#"><i class="fa fa-circle-o"></i>Data Entry<i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Refrigerator-Questionnaire/List">Refrigerator/Freezer/ILR <br>Questionnaire</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Vaccine-Carriers/List">Vaccine Carriers, Cold Boxes <br>& Ice Packs</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Coldroom-Questionnaire/List">Cold Room Questionnaire</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Voltage-Questionnaire/List">Voltage Regulators/Stabilizers <br>Questionnaire</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Generator-Questionnaire/List">Generators Questionnaire</a></li>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Transport-Questionnaire/List">Transport Questionnaire</a></li>
							</ul>      
							 <?php  } ?>						
						</li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Coldchain/Add-assets"><i class="fa fa-circle-o"></i>Cold Chain Add Assets</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Coldchain-MakeModel"><i class="fa fa-circle-o"></i>Cold Chain Make Model</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Coldchain-Asset"><i class="fa fa-circle-o"></i>Cold Chain Asset Type</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Update-status<?php echo '/';echo ( ! $this -> session -> District)?2:''; ?>"><i class="fa fa-circle-o"></i>Update Status</a></li>
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>Coldchain_database/filters"><i class="fa fa-circle-o"></i>Cold Chain Database</a></li>
					</ul>
				</li>
				<li class="parent-uk treeview">
					<a href="#"><i class="fa fa-cubes"></i><span>Stock Placement</span><i class="fa fa-angle-left pull-right"></i></a>           
					<ul class="treeview-menu">
						<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>NonCCMLocations/manage_location"><i class="fa fa-circle-o"></i>Manage Location</a></li>
						<!--<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url();?>"><i class="fa fa-circle-o"></i>Location Status</a></li>-->
					</ul>
				</li>
			<?php } 
			}
			?>
			<li class="parent-uk treeview">
				<a href="#"><i class="fa fa-calendar "></i> <span>RED/REC Micro Planning</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">					
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>red_microplan/Situation_analysis/situation_analysis_list"><i class="fa fa-circle-o"></i> Situation Analysis Form</a>					
					</li>
					<!--<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>red_microplan/Special_activities/special_activities_list"><i class="fa fa-circle-o"></i> Planning Special Activities Form</a>					
					</li>
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>red_microplan/Session_plan/session_plan_list"><i class="fa fa-circle-o"></i> Session Plan Template Form</a>					
					</li>-->
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>red_microplan/Red_strategy/red_strategy_list"><i class="fa fa-circle-o"></i> Using The RED Strategy Form</a>					
					</li>
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>red_microplan/Facility_quarterplan/hf_quarterplan_list"><i class="fa fa-circle-o"></i> HF Workplan for Quarter Form</a>					
					</li>
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>Supervisor-Micro-plan"><i class="fa fa-circle-o"></i> Supervisory Plan Form</a>					
					</li>
				</ul>
			</li>
			<li class="parent-uk treeview">
				<a href="#"><i class="fa fa-pie-chart"></i> <span>Dashboard</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li class="parent-uk">
						<a class="anchor-uk" target="_blank" href="<?php echo base_url();?>thematic_maps/ThematicCompliance"><i class="fa fa-circle-o"></i>Maps</a>
					</li>
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>dashboard/Main_page"><i class="fa fa-circle-o"></i>Dashboard Main</a>
					</li>
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>dashboard/AccessToHealthServices"><i class="fa fa-circle-o"></i>Access to Health Services</a>
					</li>
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>dashboard/UtilizationOfServices"><i class="fa fa-circle-o"></i>Utilization of Services</a>
					</li>
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>dashboard/FullyImmunizedCoverage"><i class="fa fa-circle-o"></i>Fully Immunized Coverage</a>
					</li>
					<?php if( ! ($this -> session -> District)){ ?>
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>dashboard/SessionInformation/sessionInfo"><i class="fa fa-circle-o"></i>Session Planned/Conducted</a>
					</li>
					<?php } ?>
					<li class="parent-uk">
						<a class="anchor-uk" href="<?php echo base_url(); ?>dashboard/OutreachServices"><i class="fa fa-circle-o"></i>Outreach Services</a>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-circle-o"></i> Reports Compliance<i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>dashboard/Main_page/FmvrfCompliace">Facility Monthly Reporting Form</a></li>
							<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>dashboard/ConsumptionAndRequistion">HF Consumption and Requisition</a></li>
							<?php if(!$this -> session -> District){ ?>
								<li class="parent-uk"><a class="anchor-uk" href="<?php echo base_url(); ?>dashboard/ZeroReportingCompliance">Zero Report Compliance</a></li>
							<?php } ?>
						</ul>
					</li>
				</ul>
			</li>
			<li class="parent-uk treeview">
				<a href="#"><i class="fa fa-bar-chart"></i> <span>Bulletin</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li class="parent-uk">
						<a class="anchor-uk" target="_blank" href="<?php echo base_url();?>Bulletinreport/bulleitinfillter"><i class="fa fa-circle-o"></i>Bulletin Report</a>
					</li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->        
</aside>
<?php if($this -> session -> flashdata('accessError')){ ?>
<?php if($this -> session -> flashdata('accessError')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('accessError'); ?></strong></div> <?php } ?>
<?php } ?> 