<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 			= 'login/index';
$route['404_override'] 					= '';
$route['translate_uri_dashes'] = FALSE;
$route['Logout'] 						= 'login/logout';
$route['Downloads'] 					= 'contents/downloads';
////////////////////////////////EPI Vaccination Routing///////////////////////////
$route['HFMVRF/List'] 					= 'Data_entry/fmvrf_list';
$route['HFMVRF/Add'] 					= 'Data_entry/fmvrf';
$route['HFMVRF/Edit/(:num)/(:any)'] 	= 'Data_entry/fmvrf_edit/$1/$1';
$route['HFMVRF/View/(:num)/(:any)'] 	= 'Data_entry/fmvrf_view/$1/$1';

$route['FLCF-MVRF/List'] 				= 'Data_entry/fac_mvrf_list';
$route['FLCF-MVRF/Add'] 				= 'Data_entry/fac_mvrf';
$route['FLCF-MVRF/Edit/(:num)/(:any)'] 	= 'Data_entry/fac_mvrf_edit/$1/$1';
$route['FLCF-MVRF/View/(:num)/(:any)'] 	= 'Data_entry/fac_mvrf_view/$1/$1';
$route['FLCF-MVRF1/View/(:num)/(:any)'] 	= 'Data_entry/fac_mvrf_view_for_dd/$1/$2';
////////////////////////////////Line Lists Routing///////////////////////////
$route['NNT-LineList'] 					= 'Linelists/nnt_linelist_list';
$route['Measles-LineList'] 				= 'Linelists/measles_linelist_list';
$route['Diphtheria-LineList'] 			= 'Linelists/diphtheria_linelist_list';
$route['Pneumonia-LineList'] 			= 'Linelists/pneumonia_linelist_list';
$route['Pertussis-LineList'] 			= 'Linelists/pertussis_linelist_list';
$route['AFP-LineList'] 					= 'Linelists/afp_linelist_list';
$route['ChildhoodTB-LineList'] 			= 'Linelists/childhood_tb_linelist_list'; 
//////////////////////////////Inventory Forms Routing////////////////////////
$route['Form-AI'] 						= 'Data_entry/Form_A1_list';
$route['Form-AII'] 						= 'Data_entry/Form_A2_list';
$route['Fedral-Form-AII'] 				= 'Data_entry/Form_A1_fed_list';
$route['Form-B'] 						= 'Data_entry/Form_B_list';
$route['Form-C'] 						= 'Data_entry/Form_C_list';
/////////////////////////Routing for Case Investigation Forms/////////////////
$route['NNT-Investigation']				= 'Investigation_forms/nnt_investigation_list';
$route['Measles-Investigation']			= 'data_entry/measles_list';
$route['AEFI-Investigation']			= 'Investigation_forms/aefi_investigation_list';
////////////////////////////Routing for Reporting Forms//////////////////////
$route['Facility-Monthly-Vaccination-Report'] = 'Data_entry/fmvrf_list';
$route['Weekly-VPD-Surveillance-Report'] = 'Data_entry/weekly_vpd_list';
$route['AEFI-Weekly-Compilation-Form']	= 'Data_entry/aefiWeeklyCompilationForm';
$route['AEFI-Report-Form']				= 'Data_entry/aefi_list';
//////////////////////////////Routing For Basic Setup////////////////////////
// Routing for Add HR
$route['HRList']				        = 'system_setup/AddHR_list';
$route['AddHR/Add'] 				    = 'System_setup/AddHR_add';
$route['AddHR/View/(:num)'] 		    = 'System_setup/AddHR_view/$1';
$route['AddHR/Edit/(:num)'] 		    = 'System_setup/AddHR_edit/$1';
// Routing for Technician
$route['TechnicianList']				= 'system_setup/technician_list';
$route['Technician/Add']				= 'System_setup/technician_add';
$route['Technician/Edit/(:num)']		= 'System_setup/technician_edit/$1';
$route['Technician/View/(:num)']		= 'System_setup/technician_view/$1';
// Routing for Medical Technician 
$route['HF-Incharge/List']				= 'system_setup/med_technician_list';
$route['HF-Incharge/Add']				= 'System_setup/med_technician_add';
$route['HF-Incharge/Edit/(:num)']		= 'System_setup/med_technician_edit/$1';
$route['HF-Incharge/View/(:num)']		= 'System_setup/med_technician_view/$1';
// Routing for Supervisor
$route['Supervisor/Add'] 				= 'System_setup/supervisor_add';
$route['Supervisor/View/(:num)'] 		= 'System_setup/supervisor_view/$1';
$route['Supervisor/Edit/(:num)'] 		= 'System_setup/supervisor_edit/$1';
$route['Supervisor/Delete/(:num)'] 		= 'System_setup/supervisor_delete/$1';
$route['SupervisorList']				= 'system_setup/supervisor_list';
// Routing for Computer-Operator
$route['Computer-Operator/Add'] 		= 'System_setup/codb_add';
$route['Computer-Operator/View/(:num)'] = 'System_setup/codb_view/$1';
$route['Computer-Operator/Edit/(:num)'] = 'System_setup/codb_edit/$1';
$route['Computer-Operator-List']		= 'system_setup/codb_list';
// Routing for Measles Focal Person
$route['Measles-Focal-Person/Add'] 		= 'System_setup/mfpdb_add';
$route['Measles-Focal-Person/View/(:num)'] = 'System_setup/mfpdb_view/$1';
$route['Measles-Focal-Person/Edit/(:num)'] = 'System_setup/mfpdb_edit/$1';
$route['Measles-Focal-Person-List']		= 'system_setup/mfpdb_list';
// Routing for District Surveillance Officer
$route['DSO/Add'] 						= 'System_setup/dsodb_add';
$route['DSOList'] 						= 'System_setup/dsodb_list';
$route['DSO/Edit/(:num)'] 				= 'System_setup/dsodb_edit/$1';
$route['DSO/View/(:num)'] 				= 'System_setup/dsodb_view/$1';
// Routing for Data Entry-Operator
$route['DataEntry-Operator/Add'] 		= 'System_setup/deodb_add';
$route['DataEntry-Operator/View/(:num)']= 'System_setup/deodb_view/$1';
$route['DataEntry-Operator/Edit/(:num)']= 'System_setup/deodb_edit/$1';
$route['DataEntry-Operator-List']		= 'system_setup/deodb_list';
// Routing for Store Keeper
$route['Store-keeper/Add'] 				= 'System_setup/skdb_add';
$route['Store-keeper/View/(:num)'] 		= 'System_setup/skdb_view/$1';
$route['Store-keeper/Edit/(:num)'] 		= 'System_setup/skdb_edit/$1';
$route['Store-keeper']					= 'system_setup/skdb_list';
//routing for Cold chain Mechanic
$route['Cold-Chain-Mechanic/Add'] 		= 'System_setup/cc_mechanic_add';
$route['Cold-Chain-Mechanic/View/(:num)']	= 'System_setup/cc_mechanic_view/$1';
$route['Cold-Chain-Mechanic/Edit/(:num)']	= 'System_setup/cc_mechanic_edit/$1';
$route['Cold-Chain-Mechanic/List'] 		= 'System_setup/cc_mechanic_list';
//routing for Cold chain Mechanic
$route['Generator-Operator/Add'] 		= 'System_setup/go_add';
$route['Generator-Operator/View/(:num)']= 'System_setup/go_view/$1';
$route['Generator-Operator/List'] 		= 'System_setup/go_list';
$route['Generator-Operator/Edit/(:num)']= 'System_setup/go_edit/$1';
//routing for Cold chain operator
$route['Cold-Chain-Operator/Add'] 		= 'System_setup/cco_add';
$route['Cold-Chain-Operator/View/(:num)']	= 'System_setup/cco_view/$1';
$route['Cold-Chain-Operator/List'] 		= 'System_setup/cco_list';
$route['Cold-Chain-Operator/Edit/(:num)']	= 'System_setup/cco_edit/$1';
//routing for Cold chain Technician
$route['Cold-Chain-Technician/Add'] 	= 'System_setup/cc_technician_add';
$route['Cold-Chain-Technician/View/(:num)'] = 'System_setup/cc_technician_view/$1';
$route['Cold-Chain-Technician/List'] 	= 'System_setup/cc_technician_list';
$route['Cold-Chain-Technician/Edit/(:num)'] = 'System_setup/cc_technician_edit/$1';

// Routing for Cold Chain Technician
$route['CCT/Add'] 						= 'System_setup/cc_technician_add';
$route['CCTList'] 						= 'System_setup/cc_technician_list';
$route['CCT/Edit/(:num)'] 				= 'System_setup/cc_technician_edit/$1';
$route['CCT/View/(:num)'] 				= 'System_setup/cc_technician_view/$1';
// Routing for Cold Chain Mechanic
$route['CCM/Add'] 						= 'System_setup/ccmdb_add';
$route['CCMList'] 						= 'System_setup/ccmdb_list';
$route['CCM/Edit/(:num)'] 				= 'System_setup/ccmdb_edit/$1';
$route['CCM/View/(:num)'] 				= 'System_setup/ccmdb_view/$1';
// Routing for Cold Chain Generator Operator
$route['CCG/Add'] 						= 'System_setup/ccgdb_add';
$route['CCGList'] 						= 'System_setup/ccgdb_list';
$route['CCG/Edit/(:num)'] 				= 'System_setup/ccgdb_edit/$1';
$route['CCG/View/(:num)'] 				= 'System_setup/ccgdb_view/$1';
// Routing for Cold Chain Driver
$route['CCD/Add'] 						= 'System_setup/ccddb_add';
$route['CCDList'] 						= 'System_setup/ccddb_list';
$route['CCD/Edit/(:num)'] 				= 'System_setup/ccddb_edit/$1';
$route['CCD/View/(:num)'] 				= 'System_setup/ccddb_view/$1';
// Routing for CC-Operator
$route['CC-OperatorList']				= 'system_setup/ccoperatordb_list';
$route['CC-Operator/Add']				= 'System_setup/ccoperatordb_add';
$route['CC-Operator/View/(:num)'] 		= 'System_setup/ccoperatordb_view/$1';
$route['CC-Operator/Edit/(:num)'] 		= 'System_setup/ccoperatordb_edit/$1';
// Routing for Driver
$route['DriverList']				    = 'system_setup/driverdb_list';
$route['Driver/Add'] 					= 'System_setup/driverdb_add';
$route['Driver/View/(:num)'] 			= 'System_setup/driverdb_view/$1';
$route['Driver/Edit/(:num)'] 			= 'System_setup/driverdb_edit/$1';
// Routing for HealthFacility
$route['EPICentersList']				= 'system_setup/flcf_list';
$route['EPICenters/Add']				= 'system_setup/flcf_add';
$route['EPICenters/Mark']				= 'system_setup/flcf_marker_list';
// Routing for Reports Filters
$route['Reports/Filter/(:any)'] 		= 'Reports/Reports_Filters/$1';
// Routing for Listing Pages
/* $route['Setup/Listing/(:any)'] 			= 'setup_listing/district_listing/$1';
$route['Setup/Listing/(:any)'] 			= 'setup_listing/tehsil_listing/$1'; */
$route['Setup/Listing/(:any)'] 			= 'setup_listing/listing/$1';
/////////////////Routing for Cold Chain Questionnaires/////////////////////////
///Routing for Health Facility Questionnaire///
$route['HF-Questionnaire/List'] 		= 'Coldchain/rev_health_facility_questionnaire_pak_list'; 
$route['HF-Questionnaire/Add']			= 'Coldchain/rev_health_facility_questionnaire_pak';
$route['HF-Questionnaire/View/(:num)']	= 'Coldchain/rev_health_facility_questionnaire_pak_view/$1';  
$route['HF-Questionnaire/Edit/(:num)']	= 'Coldchain/rev_health_facility_questionnaire_pak_edit/$1';  
///Routing for Refrigerator Questionnaire///
$route['Refrigerator-Questionnaire/List']	= 'Coldchain/refrigerator_questionnaire_list'; 
$route['Refrigerator-Questionnaire/Add']	= 'Coldchain/refrigerator_questionnaire';
$route['Refrigerator-Questionnaire/View/(:num)']	= 'Coldchain/refrigerator_questionnaire_view/$1';  
$route['Refrigerator-Questionnaire/Edit/(:num)']	= 'Coldchain/refrigerator_questionnaire_edit/$1'; 
///Routing for Vaccine Carriers Questionnaire///
$route['Vaccine-Carriers/List'] 		= 'Coldchain/vacc_carriers_list'; 
$route['Vaccine-Carriers/Add']			= 'Coldchain/vacc_carriers';
$route['Vaccine-Carriers/View/(:num)']	= 'Coldchain/vacc_carriers_view/$1';  
$route['Vaccine-Carriers/Edit/(:num)']	= 'Coldchain/vacc_carriers_edit/$1';  
///Routing for Coldroom Questionnaire///
$route['Coldroom-Questionnaire/List'] 	= 'Coldchain/coldroom_questionnaire_list'; 
$route['Coldroom-Questionnaire/Add']	= 'Coldchain/coldroom_questionnaire';
$route['Coldroom-Questionnaire/View/(:num)']	= 'Coldchain/coldroom_questionnaire_view/$1';  
$route['Coldroom-Questionnaire/Edit/(:num)']	= 'Coldchain/coldroom_questionnaire_edit/$1';  
///Routing for Voltage Questionnaire///
$route['Voltage-Questionnaire/List'] 	= 'Coldchain/voltage_questionnaire_list'; 
$route['Voltage-Questionnaire/Add']		= 'Coldchain/voltage_questionnaire';
$route['Voltage-Questionnaire/View/(:num)']		= 'Coldchain/voltage_questionnaire_view/$1';  
$route['Voltage-Questionnaire/Edit/(:num)']		= 'Coldchain/voltage_questionnaire_edit/$1';
///Routing for Generator Questionnaire///
$route['Generator-Questionnaire/List'] 	= 'Coldchain/generator_questionnaire_list'; 
$route['Generator-Questionnaire/Add']	= 'Coldchain/generator_questionnaire';
$route['Generator-Questionnaire/View/(:num)']	= 'Coldchain/generator_questionnaire_view/$1';  
$route['Generator-Questionnaire/Edit/(:num)']	= 'Coldchain/generator_questionnaire_edit/$1'; 
///Routing for Transport Questionnaire///
$route['Transport-Questionnaire/List'] 	= 'Coldchain/transport_questionnaire_list'; 
$route['Transport-Questionnaire/Add']	= 'Coldchain/transport_questionnaire';
$route['Transport-Questionnaire/View/(:num)']	= 'Coldchain/transport_questionnaire_view/$1';  
$route['Transport-Questionnaire/Edit/(:num)']	= 'Coldchain/transport_questionnaire_edit/$1';
///Routing for Disease Surveillance Report///
$route['Disease-Surveillance/List'] 	= 'Data_entry/weekly_vpd_list'; 
$route['Disease-Surveillance/Add']		= 'Data_entry/weekly_vpd_add';
$route['Disease-Surveillance/View/(:num)']			= 'Data_entry/weekly_vpd_view/$1';  
$route['Disease-Surveillance/Edit/(:num)']			= 'Data_entry/weekly_vpd_edit/$1'; 
///Routing for Measles-CIF///
$route['Measles-CIF/List'] 				= 'Investigation_forms/measles_list'; 
$route['Measles-CIF/Add']				= 'Investigation_forms/measles_case_investigation';
$route['Measles-CIF/View/(:num)/(:any)']= 'Investigation_forms/measles_view/$1/$1';  
$route['Measles-CIF/Edit/(:num)/(:any)']= 'Investigation_forms/measles_edit/$1/$1';
$route['Measles-CIF/View/(:num)']		= 'Investigation_forms/measles_view/$1';
$route['Measles-CIF/Edit/(:num)']		= 'Investigation_forms/measles_edit/$1';
///Routing for NNT-CIF///
$route['NNT-CIF/List'] 					= 'Investigation_forms/nnt_investigation_list';
$route['NNT-CIF/List/(:any)'] 			= 'Investigation_forms/nnt_investigation_list/$1';  
$route['NNT-CIF/Add']					= 'Investigation_forms/nnt_investigation';
$route['NNT-CIF/View/(:num)']			= 'Investigation_forms/nnt_investigation_view/$1';  
$route['NNT-CIF/Edit/(:num)']			= 'Investigation_forms/nnt_investigation_edit/$1'; 
///Routing for AEFI-CIF///
$route['AEFI-CIF/List'] 				= 'Data_entry/aefi_list'; 
$route['AEFI-CIF/Add']					= 'Data_entry/aefi';
$route['AEFI-CIF/View/(:num)']			= 'Data_entry/aefi_view/$1';  
$route['AEFI-CIF/Edit/(:num)']			= 'Data_entry/aefi_edit/$1'; 
$route['Integrated-Disease-Surveillance-Report'] = 'Data_entry/ids_report_list';
///Routing for Federal Issue & Receipt///
$route['Federal-Issue-Receipt/List'] 	= 'Data_entry/form_a1_fed_list'; 
$route['Federal-Issue-Receipt/Add']		= 'Data_entry/form_A1_fed';
$route['Federal-Issue-Receipt/View/(:num)']			= 'Data_entry/form_A1_fed_view/$1';  
$route['Federal-Issue-Receipt/Edit/(:num)']			= 'Data_entry/form_A1_fed_edit/$1'; 
///Routing for Province Issue & Receipt///
$route['Province-Issue-Receipt/List'] 	= 'Data_entry/form_a1_list'; 
$route['Province-Issue-Receipt/Add']	= 'Data_entry/form_A1';
$route['Province-Issue-Receipt/View/(:num)/(:any)']		= 'Data_entry/form_A1_view/$1/$1';  
$route['Province-Issue-Receipt/Edit/(:num)/(:any)']		= 'Data_entry/form_A1_edit/$1/$1';
//Routing for new consumption module added by imran (2019-01-24)
//on 2020-12-04 imran commented some of the following routes to disable data entry in old forms
//$route['consumption'] 						= 'consumption/CRUD/index';
//$route['consumption/add'] 					= 'consumption/CRUD/create';
$route['consumption/edit/(:any)/(:num)']	= 'consumption/CRUD/consumption_edit/$1/$2';
$route['consumption/view/(:any)/(:any)']	= 'consumption/CRUD/consumption_view/$1/$2';
//$route['consumption/save'] 					= 'consumption/CRUD/create';
$route['consumption/delete/(:any)/(:num)'] 	= 'consumption/CRUD/consumption_delete/$1/$2';
$route['consumptionitems'] 					= 'consumption/CRUD/itemslist';
$route['consumption/reports/indicator'] 	= 'consumption/reports/Indicator';
$route['consumption/reports/indicator/preview'] 	= 'consumption/reports/Indicator/preview';
$route['hfcurrentstock'] 					= 'consumption/reports/Stock';
$route['hfcurrentstock/preview'] 					= 'consumption/reports/Stock/preview';
$route['hfadjustment'] 						= 'consumption/CRUD/hfadjustment';
$route['hfadjustment/edit/(:any)/(:num)']	= 'consumption/CRUD/hfadjustment_edit/$1/$2';
$route['hfadjustmentitems'] 					= 'consumption/CRUD/hfadjustmentitemslist';
$route['hfadjustment/save'] 					= 'consumption/CRUD/saveadjustment';
$route['hfadjustment/view/(:any)/(:any)']	= 'consumption/CRUD/hfadjustment_view/$1/$2';
//Routing for new merged vaccination & consumption module added by imran (2019-12-31), last updated:2020-12-27
$route['vaccination'] 						= 'vaccination/CRUD/index';
$route['vaccination/add'] 					= 'vaccination/CRUD/create';
$route['vaccination/edit/(:any)/(:num)']	= 'vaccination/CRUD/consumption_edit/$1/$2';
$route['vaccination/view/(:any)/(:any)']	= 'vaccination/CRUD/consumption_view/$1/$2';
$route['vaccination/save'] 					= 'vaccination/CRUD/create';
$route['vaccination/saveDataShare'] 		= 'vaccination/CRUD/createDataShare';
$route['fetchDataShareUcs'] 	= 'vaccination/CRUD/getDataShareUcList';
$route['vaccination/delete/(:any)/(:num)'] 	= 'vaccination/CRUD/consumption_delete/$1/$2';
$route['vaccinationitems'] 					= 'vaccination/CRUD/itemslist';
$route['Commulative-Coverage'] 			= 'vaccination/reports/Coverage';
$route['Commulative-Coverage/preview'] 			= 'vaccination/reports/Coverage/preview';
//$route['vaccination/reports/indicator'] 			= 'vaccination/reports/Indicator';
//$route['vaccination/reports/indicator/preview'] 	= 'vaccination/reports/Indicator/preview';
///Routing for HF Consumption & Requisition///
$route['HF-Consumption-Requisition/List'] 					= 'Data_entry/form_B_list';
$route['HF-Consumption-Requisition/Add']= 'Data_entry/form_B';
$route['HF-Consumption-Requisition/View/(:any)/(:num)']		= 'Data_entry/form_B_view/$1/$1';  
$route['HF-Consumption-Requisition/Edit/(:any)/(:num)']		= 'Data_entry/form_B_edit/$1/$1';
///Routing for District Issue & Receipt///
$route['District-Issue-Receipt/List'] 	= 'Data_entry/form_A2_new_list'; 
$route['District-Issue-Receipt/Add']	= 'Data_entry/form_A2_new';
$route['District-Issue-Receipt/View/(:any)']		= 'Data_entry/form_A2_new_view/$1';  
$route['District-Issue-Receipt/Edit/(:any)']		= 'Data_entry/form_A2_new_edit/$1';
///Routing for UC Demand, Consumption & Receipt///
$route['UC-Demand-Consumption/List'] 	= 'Data_entry/form_C_new_list'; 
$route['UC-Demand-Consumption/Add']		= 'Data_entry/form_C_new';
$route['UC-Demand-Consumption/View/(:num)']		= 'Data_entry/form_C_new_view/$1';  
$route['UC-Demand-Consumption/Edit/(:num)']		= 'Data_entry/form_C_new_edit/$1';  
//Routing for Compliances and their Filters
$route['Compliance-Filter/HFMVRF'] 								= 'Compliances/compliancesFilters';
$route['Compliance-Filter/HFMVRFTest'] 							= 'CompliancesTest/compliancesFilters'; 
$route['Compliance-Filter/HF-Consumption-Requisition'] 	     	= 'Compliances/compliancesFilters';
$route['Compliance-Filter/HF-Consumption-Requisition-Test'] 	= 'CompliancesTest/compliancesFilters';
$route['Compliance-Filter/Issue-Receipt'] 						= 'Compliances/compliancesFilters';
$route['Compliance-Filter/Demand-Consumption-Receipt'] 			= 'Compliances/compliancesFilters';
$route['Compliance-Filter/Zero-Compliance'] 			= 'Compliances/compliancesFilters';
$route['Compliance-Filter/Measles-Compliance'] 			= 'Compliances/compliancesFilters';
$route['Compliance-Filter/Coronavirus-Compliance'] 		= 'Compliances/compliancesFilters';
$route['Compliance-Filter/NNT-Compliance'] 				= 'Compliances/compliancesFilters'; 
$route['Compliance-Filter/AFP-Compliance'] 				= 'Compliances/compliancesFilters';
$route['Compliance-Filter/Other-Compliance'] 			= 'Compliances/compliancesFilters';
$route['Compliance-Filter/AEFI-Compliance'] 			= 'Compliances/compliancesFilters';
$route['Compliance-Filter/Response-Compliance'] 		= 'Compliances/compliancesFilters';
//--$route['Compliance-Filter/MSLResponse-Compliance'] 		= 'Compliances/compliancesFilters';
$route['Compliances/Export'] 			= 'Compliances/export_excel';
//Routing for Indicators Reports
$route['Indicator-Report/Filters/HFMVRF'] 				= 'Indicator_Reports/reportFilters';
$route['Indicator-Report/HFMVRF']		= 'Indicator_Reports/HFMVRF';
//Converted to new module named as consumption
/* $route['Indicator-Report/Filters/Vaccine'] 				= 'Indicator_Reports/reportFilters';
$route['Indicator-Report/Vaccine']		= 'Indicator_Reports/Vaccine'; */
$route['Indicator-Report/Filters/Disease'] 				= 'Indicator_Reports/customizereportFilters';//reportFilters
$route['Indicator-Report/Disease']		= 'Indicator_Reports/Disease';
$route['Indicator-Report/priority-diseases']			= 'Indicator_Reports/priority_diseases';
$route['Indicator-Report/IdsrsFilters/priority-diseases']    = 'Indicator_Reports/idsrsReportFilters/priority_diseases';
$route['Indicator-Report/IdsrsFilters/morbidity']    = 'Indicator_Reports/idsrsReportFilters/morbidity';
$route['Indicator-Report/morbidity']    = 'Indicator_Reports/morbidity';
//Routing for Advance Reports
$route['Advance-Report/Filters/HFMVRF-Advance-Report']	= 'Advance_Reports/reportFilters';
$route['Advance-Report/HFMVRF-Advance-Report']			= 'Advance_Reports/HFMVRF_Advance_Report';
$route['Advance-Report/Filters/HFCR-Advance-Report']	= 'Advance_Reports/reportFilters';
$route['Advance-Report/HFCR-Advance-Report']			= 'Advance_Reports/HFCR_Advance_Report';
$route['Advance-Report/Filters/HR-Advance-Report']	= 'Advance_Reports/reportFilters';
$route['Advance-Report/HR-Advance-Report']			= 'Advance_Reports/HR_Advance_Report';
$route['Advance-Report/Filters/Disease-Surveillance-Advance-Report']	= 'Advance_Reports/reportFilters';
$route['Advance-Report/Disease-Surveillance-Advance-Report']			= 'Advance_Reports/Disease_Surveillance_Advance_Report';
//$route['Advance-Report/HF-Consumption-Requisition-Report']	= 'Advance_Reports/HFCR_Advance_Report';
//Routing for AFP-CIF///
$route['AFP-CIF/List'] 					= 'Investigation_forms/afp_list'; 
$route['AFP-CIF/List/(:any)'] 			= 'Investigation_forms/afp_list/$1'; 
$route['AFP-CIF/Add']					= 'Investigation_forms/afp_investigation';
$route['AFP-CIF/View/(:num)/(:any)']	= 'Investigation_forms/afp_investigation_view/$1/$1';  
$route['AFP-CIF/Edit/(:num)/(:any)']	= 'Investigation_forms/afp_investigation_edit/$1/$1';
$route['AFP-CIF/View/(:num)']			= 'Investigation_forms/afp_investigation_view/$1';
$route['AFP-CIF/Edit/(:num)']			= 'Investigation_forms/afp_investigation_edit/$1';
//Routing for Consolidated FLCF Wise Vaccination Reports///
$route['Reports/Filters/Facility-Wise-Vaccination'] 			= 'Reports/Reports_Filters/flcf_wise_vaccination';
$route['Reports/Filters/Facility-Wise-Vaccination-Coverage'] 	= 'Reports/Reports_Filters/flcf_wise_vaccination_coverage';
$route['Reports/Filters/Facility-Wise-Vaccination-Coverage_MaleFemale'] = 'Reports/Reports_Filters/flcf_wise_vaccination_malefemale_coverage';
$route['Reports/Filters/Session-planned-conducted'] = 'Reports/Reports_Filters/sessionInfoReport';
$route['Reports/Filters/Vaccine-Demand'] = 'Reports/Reports_Filters/vaccine_demand';
$route['Reports/Filters/Dropout']                               = 'Reports/Reports_Filters/all_dropout';
$route['Reports/Filters/Accessutilization']                               = 'Reports/Reports_Filters/access_utilization';
$route['Reports/Filters/Measle-Coverage-Dropout']               = 'Reports/Reports_Filters/measle_coverage_dropout';
$route['Reports/HF-Consumption-Requisition-Report'] = 'Reports/hf_cr/hf_consumption_requisition';
//Routing for HR Summary Report///
$route['Reports/Filters/HR-Summary-Report'] 			= 'Reports/summaryReports/hr_summary_report';
$route['Reports/HR-Summary-Report'] 	= 'Reports/HR_Summary_Report';
//Routing for Other Reports
$route['Surveillance/Filters/MSR'] 		= 'Other_Reports/reportFilters';
$route['Surveillance/Filters/EPID'] 	= 'Other_Reports/reportFilters';
$route['Surveillance/Filters/VPD'] 		= 'Other_Reports/reportFilters';
$route['Surveillance/Filters/OUTBREAK'] = 'Other_Reports/reportFilters';
$route['Surveillance/Filters/Outbreak_Response'] 		= 'Other_Reports/reportFilters';
$route['Surveillance/Outbreak_Response']= 'Other_Reports/Outbreak_Response';
$route['Surveillance/MSR'] 				= 'Other_Reports/MSR';
$route['Surveillance/EPID'] 			= 'Other_Reports/EPID_Count';
$route['Surveillance/VPD'] 				= 'Other_Reports/VPD_Count';
$route['Surveillance/EPID/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'Other_Reports/EPID_Count/$1/$2/$3/$4/$5/$6/$7';
$route['Surveillance/VPD/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'Other_Reports/VPD_Count/$1/$2/$3/$4/$5/$6';
$route['Surveillance/VPD/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'Other_Reports/VPD_Count/$1/$2/$3/$4/$5';
$route['Surveillance/OUTBREAK'] 		= 'Other_Reports/disease_outbreak';
$route['Surveillance/OUTBREAK/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'Other_Reports/disease_outbreak/$1/$2/$3/$4/$5';
//Routing for Other Pending Cross Notified Cases
$route['CrossNotifiedCases/Filters/PendingCases'] 		= 'Pending_Cases/reportFilters';
$route['CrossNotifiedCases/PendingCases'] 		= 'Pending_Cases/Pending_cases_report';
// Routing for Case Response Forms
$route['CaseResponse/Measles'] 			= 'Case_response/measles_case_response';
$route['CaseResponse/Diphtheria'] 		= 'Case_response/diphtheria_case_response';
// Routing for Zero Reporting Form 
$route['Zero-Reporting'] 				= 'Investigation_forms/zero_reporting_list';
$route['Zero-Reporting-Add']			= 'investigation_forms/zero_reporting';
$route['Zero-Reporting/View/(:any)/(:any)']				= 'Investigation_forms/zero_reporting_view/$1/$1';
$route['Zero-Reporting/Edit/(:any)/(:any)']				= 'Investigation_forms/zero_reporting_edit/$1/$1';
// Routing for Home Page
$route['Home'] 							= 'login/index';
$route['Home']							= 'Login/login';
// Routing for Admin Configuration
$route['Adjustment-Vaccines'] 			= 'Admin_Configuration/adjustment';
$route['Purpose-Type'] 					= 'Admin_Configuration/type_purpose';
$route['Vaccines-Manufacturers'] 		= 'Admin_Configuration/manufacturer';
$route['Stake-Holder'] 					= 'Admin_Configuration/stakeholder';
$route['Warehouse-Information'] 		= 'Admin_Configuration/warehouse';
$route['Manage-Warehouse'] 				= 'Admin_Configuration/manage_warehouse';
$route['Coldchain-Asset'] 				= 'Admin_Configuration/cc_asset';
$route['Coldchain-MakeModel']			= 'Coldchain/coldchain_make_model';
$route['Coldchain-main'] 				= 'Coldchain/coldchain_main_list';
$route['Update-status'] 				= 'Admin_Configuration/status_history';
$route['Update-status/(:num)'] 			= 'Admin_Configuration/status_history/$1';
$route['Update-status/(:num)/(:num)'] 	= 'Admin_Configuration/status_history/$1/$2';
$route['Update-status/(:num)/(:num)/(:num)'] = 'Admin_Configuration/status_history/$1/$2/$3';
$route['Update-status/(:num)/(:num)/(:num)/(:num)/(:num)'] = 'Admin_Configuration/status_history/$1/$2/$3/$4/$5';
// Routing for Error Reports 
$route['tehsils-with-zero-population']	= 'Error_Reports/index';
$route['ucs-with-zero-population']		= 'Error_Reports/index';
$route['duplicate-technician-records']	= 'Error_Reports/index';
$route['facilities-with-zero-technicians']	= 'Error_Reports/index';
$route['facilities-with-zero-population']	= 'Error_Reports/index';
$route['ucs-with-no-attached-facilities'] = 'Error_Reports/index';
$route['empty-consumption-reports'] = 'Error_Reports/index';
//Routing for Facility Status
$route['Status/View/(:num)']            = 'Facility_status/fac_status_view/$1';
$route['Status/Save/(:num)']            = 'Facility_status/fac_status_save/$1';
$route['Status/Delete/(:any)/(:num)/(:any)']  = 'Facility_status/fac_status_delete/$1/$2';
$route['translate_uri_dashes'] 			= FALSE;
//Routin for supervisory micro plan 
$route['Supervisor-Micro-plan'] 		= 'micro_plan/Micro_plan_controller/supervisory_plan';
#work by moon, routes of inventory management module
$route['voucher/(:any)']  				= 'inventory/Reports/voucher_detail/$1';
$route['federalvoucherfetch']  			= 'inventory/Federal/fetch_fed_voucher_history';
$route['StockReceivefromSupplier']  	= 'inventory/Provincial/stock_receive_from_supplier';
$route['StockReceivefromSupplierList']  = 'inventory/Provincial/stock_receive_from_supplier_list';
$route['StockReceivefromStore']  		= 'inventory/Provincial/stock_receive_from_store';
$route['StockReceivefromStore/(:any)']  = 'inventory/Provincial/stock_receive_from_store/$1';
//-----------------------------
$route['fedIssue']                      = 'inventory/Federal/fetch_fed_issuance';
$route['Delete-fedIssue'] 				= 'inventory/Federal/delete_fetch_fed_issuance';
//-----------------------------
$route['productsByActivities']          = 'inventory/Provincial/get_invn_products';
$route['relatedProductsByActivity']     = 'inventory/Provincial/get_invn_related_products';
$route['manufacturerByProduct']         = 'inventory/Provincial/get_invn_manufacturer';
$route['priorityDetailsByProduct']      = 'inventory/Provincial/get_invn_priority_details';
$route['vvmStageByProduct']             = 'inventory/Provincial/get_invn_vvmStage';
$route['invnSuppReceive']               = 'inventory/Provincial/set_invn_supp_receive';
$route['saveInvnSuppReceive']           = 'inventory/Provincial/save_invn_supp_receive';
$route['StockReceivefromStoreSave']     = 'inventory/Provincial/save_invn_store_receive';
$route['delinvnSupp']                   = 'inventory/Provincial/del_invn_supp';
//------------------
$route['StockIssue']                    = 'inventory/Provincial/stock_issue';
$route['invnissue']                     = 'inventory/Provincial/stock_issue_bulk';
$route['issuebulkitems']                = 'inventory/Provincial/stock_issue_bulk_items';
$route['getstoreloc']                   = 'inventory/Provincial/get_store_locations';
$route['getfacstoreloc']                = 'inventory/Provincial/get_fac_store_locations';
$route['invnStockIssueSave']            = 'inventory/Provincial/set_invn_supp_issue';
$route['saveInvnIssue']                 = 'inventory/Provincial/save_invn_supp_issue';
$route['delinvnIssue']                  = 'inventory/Provincial/del_invn_issue';
$route['editinvnIssue/(:any)']          = 'inventory/Provincial/edit_invn_issue/$1';
//------------------
$route['vvmManagement']                 = 'inventory/Provincial/stock_vvm_management';
$route['updatevvmstage']                = 'inventory/Provincial/stock_vvm_update';
$route['stockTransfer']                 = 'inventory/Provincial/stock_transfer';
$route['stockTransferSave']             = 'inventory/Provincial/stock_transfer_save';
$route['stockTransferSearch']           = 'inventory/Search/stock_transfer_search';
$route['adjustmentSearch']              = 'inventory/Search/stock_adjustment_search';
$route['stockAdjustment']               = 'inventory/Provincial/stock_adjustment';
$route['delinvnAdjustment']             = 'inventory/Provincial/del_invn_adjustment';
$route['stockIssueSearch']              = 'inventory/Search/stock_issue_search';
$route['batchManagement']               = 'inventory/Provincial/stock_batch_management';
$route['stockReceiveSearch']            = 'inventory/Search/stock_receive_search';
$route['stockBatchSearch']              = 'inventory/Search/stock_batch_search';
//new-
$route['getBatchLocation']              = 'inventory/Provincial/get_batch_location';
$route['DetailsByProduct']              = 'inventory/Provincial/get_batch_detail';
$route['stockReceiveFromSupplierRecNo'] = 'inventory/Provincial/stock_receive_from_supplierRecNo';
$route['StockRecieveFromSupplier']      = 'inventory/Provincial/stock_receive_from_supplierReport';
$route['chckFacIssuedb']                = 'inventory/Provincial/chckfac_issue_db';
$route['batchDetail']                   = 'inventory/Provincial/get_batch_Adjustment_detail';
$route['stockReceiveSearchRecNo/(:any)']= 'inventory/Search/Stock_Receive_Search_RecNo';
$route['StockReceiveSearchSummaryProd'] = 'inventory/Search/Stock_Receive_Search_SummaryProd';
$route['StockReceiveSearchDetailProd']  = 'inventory/Search/Stock_Receive_Search_DetailProd';
$route['stockIssueSearchIssueNo/(:any)']= 'inventory/Search/stock_issue_search_issueNo';
$route['StockIssueSearchSummaryProd']   = 'inventory/Search/stock_issue_search_SummaryProd';
$route['StockIssueSearchDetailProd']    = 'inventory/Search/stock_issue_search_DetailProd';
$route['StockAdjustmentDetail']         = 'inventory/Search/stock_adjustment_search_detail';
$route['batchDetailReport']             = 'inventory/Search/stock_batch_report';
$route['batchVaccineSummary']           = 'inventory/Search/stock_batch_vacchine_summary';
$route['batchwisesummary']              = 'inventory/search/stock_batch_wise_Summary';
$route['batch_nonwisesummary']          = 'inventory/search/batch_nonwise_summary';
$route['batchNonVaccineSummary']        = 'inventory/Search/stock_batch_Nonvacchine_summary';
$route['batchVaccinePriority']          = 'inventory/Search/stock_batch_vacchine_priority';
$route['batchNonVaccinePriority']       = 'inventory/Search/stock_batch_nonvacchine_priority';
$route['StockIssueDispatch']            = 'inventory/Search/stock_issue_dispatch_report';
$route['stockIssueDispatchTransNo']     = 'inventory/Search/stock_issue_dispatch_tranNo';
$route['batchManufacturer']             = 'inventory/Search/stock_batch_manufacturer';
$route['StockTransferReport']           = 'inventory/Search/Stock_Transfer_Report';
//------------------- Routing for Cold Chain Capacity===Dashboard
$route['cold-chain-capacity']           = 'dashboard/ColdChainCapacity/cold_chain_capacity';
$route['capacity-by-vaccine']           = 'dashboard/ColdChainCapacity/capacity_by_vaccine';
//------------------- Routing for Dashboard====Provincial Level
$route['dashboard-provincial']          = 'dashboard/provincial/Inventory_Management/stock_status';

//------------------- Routing for stock placement
$route['ccmLocStatus']              	= 'inventory/Placement/ccm_loc_status';
$route['dryStoreStatus']            	= 'inventory/Placement/dry_store_status';
$route['stock-in-bin']              	= 'inventory/Placement/stock_in_bin';
$route['stock-in-bin-vaccine']      	= 'inventory/Placement/stock_in_bin_vaccine';
$route['TransferStock']             	= 'inventory/Placement/transfer_Stock';
$route['batchInformation']          	= 'inventory/Placement/batch_information';
$route['DryStorebatchInformation']  	= 'inventory/Placement/drystorebatch_information';
$route['dryStoreTransferStock']     	= 'inventory/Placement/dry_store_transfer_Stock';
//-------------------
$route['invnStockAdjustSave']   		= 'inventory/Provincial/save_invn_stock_adjust';
$route['invnAddAdjustBatch']    		= 'inventory/Provincial/save_stock_adjust_batch';
//------------------- routing for inventory reports
$route['Reports/Vaccine-Distribution']  = 'inventory/Reports/vaccine_distribution';
$route['vaccine_distribution_report']   = 'inventory/Reports/vaccine_distribution/preview';
$route['Reports/Yearly-Status']         = 'inventory/Reports/yearly_status';
$route['yearly_status_report']          = 'inventory/Reports/yearly_status/preview';
$route['Reports/Inventory-Status']      = 'inventory/Reports/inventory_status';
$route['inventory_status_report']       = 'inventory/Reports/inventory_status/preview';
$route['inventory_status_detail']       = 'inventory/Reports/inventory_status/detail';
$route['Reports/Expiry-Rate-Report']    = 'inventory/Reports/expiry_rate_report';
$route['expiry_rate_report']            = 'inventory/Reports/expiry_rate_report/preview';
$route['Reports/Stock-Movement-Report'] = 'inventory/Reports/stock_movement_report';
$route['Stock_movement_report']         = 'inventory/Reports/stock_movement_report/preview';
$route['Reports/Stock-Ledger']          = 'inventory/Reports/stock_ledger';
$route['stock-ledger']                  = 'inventory/Reports/stock_ledger/preview';
$route['Reports/Detail_Vacc_Distribution']  = 'inventory/Reports/detail_vacc_distribution';
$route['Reports/Current-Stock']         = 'inventory/Reports/current_stock'; 
$route['current_stock']                 = 'inventory/Reports/current_stock/preview';
$route['Reports/Adjustment-report']     = 'inventory/Reports/adjustment_report'; 
$route['adjustment_report']             = 'inventory/Reports/adjustment_report/preview';
$route['autoProdRequisition'] 	        = 'inventory/Suggestion/autoProdRequisition';
$route['requisition'] 	        		= 'inventory/Suggestion/auto_req_cache';
$route['requisition_refresh'] 	        = 'inventory/Suggestion/requisition_refresh';
$route['fetch_req_cache'] 	            = 'inventory/Suggestion/fetch_req_cache';
//---------------------Routing for case response
 $route['Case-List']                	= 'Case_response/list_case_response'; 
 $route['Add-case']	                	= 'Case_response/add_case_response';
 $route['Case-View/(:num)/(:any)']  	= 'Case_response/case_view/$1/$2';  
 $route['Case-Edit/(:num)/(:any)']  	= 'Case_response/case_edit/$1/$2';
/* Routing of Child Registration Reports */
$route['Reports/ChildRegistrationFilter']             = 'childs/Reports/child_reg_filter';
$route['Reports/ChildRegistration']            		  = 'childs/Reports/child_reg';
$route['Reports/ChildVaccinationMap/(:any)/(:any)']   = 'childs/MapReports/map_view/$1/$1';
$route['Reports/ChildRegistrationList']               = 'childs/Reports_list/child_list';
$route['Reports/ChildRegistrationView/(:num)'] 		  = 'childs/Reports_list/child_view/$1';
$route['Reports/ChildRegistrationAdd']               = 'childs/Reports_list/child_add';
$route['Reports/motherRegistrationList']              = 'childs/Reports_list/mother_list';
$route['Reports/ChildRegistrationEdit/(:num)'] 		  = 'childs/Reports_list/child_edit/$1';
$route['Reports/MotherRegistrationEdit/(:num)'] 		  = 'childs/Reports_list/mother_edit/$1';
$route['Reports/MotherRegistrationView/(:num)'] 		  = 'childs/Reports_list/mother_view/$1';
$route['Reports/ChildRegistrationSave'] 			  = 'childs/Reports_list/child_update';
$route['Reports/MotherRegistrationSave'] 			  = 'childs/Reports_list/mother_update';
$route['Reports/ChildRegistrationSaveAdd'] 			  = 'childs/Reports_list/child_add_save';
$route['Reports/MotherRegistrationSaveAdd'] 			  = 'childs/Reports_list/mother_add_save';
$route['Reports/DailyChildRegistrationFilter']   	  = 'childs/DailyRegisterChildReport/reportFilters';
$route['Reports/DataEntry']   	                      = 'childs/DailyRegisterChildReport/reportFilters';
$route['Reports/DailyChildRegistrationReport']   	  = 'childs/DailyRegisterChildReport/daily_report';
$route['Reports/MonthlyRegisterFilter']   			  = 'childs/MonthlyRegisterReport/reportFilters';
$route['Reports/MonthlyRegisterReport']   			  = 'childs/DailyRegisterChildReport/daily_report';
$route['CervReports/zero_dose'] 					  = 'Cerv/Reports/zero_dose_children_filters/zero_dose';
$route['CervReports/dropouts'] 						  = 'Cerv/Reports/dropout_filters/dropouts';
//--------------------Routing for Cold-chain module
$route['Coldchain/refrigerator_list/(:any)']   = 'Coldchain/refrigerator_list';
$route['Coldchain/Search-assets']       = 'Coldchain/coldchainSearch';
$route['Coldchain/Search-assets/(:any)/(:num)'] = 'Coldchain/coldchainSearch'; 
$route['refrigeratorModalSave']         = 'Coldchain/refrigeratorModalSave';
//-------------------Routing For Cold-chain reports
$route['ColdChainReports/AssetsReports']= 'Coldchain_reports/hf_cr/coldchain_Report';
//-------------------Routing for Outbreak response list report

 $route['Outbreak-Response-Report'] 	= 'Outbreak_response_list_report/outbreak_response_list_report';
 $route['Outbreak-Report']          	= 'Outbreak_response_list_report/outbreak_report';

 //------------Routing for village management 

$route['Village-List']                  = 'Villages/village_list';
$route['Add-village']	                = 'Villages/village_add';
$route['Edit-village/(:num)']           = 'Villages/village_edit/$1';
$route['View-village/(:num)']           = 'Villages/village_view/$1';
$route['Delete-village/(:num)']           = 'Villages/village_delete/$1';
//-------------Routing for RedRec complaince 
$route['Compliance-Filter/HF-Microplan']= 'red_rec_microplan/RedRec_compliances/compliancesFilters'; 
$route['Compliance-Filter/HF-Quarterplan'] 			= 'red_rec_microplan/RedRec_compliances/compliancesFilters';
$route['Compliance-Filter/HF-Supervisoryplan'] 		= 'red_rec_microplan/RedRec_compliances/compliancesFilters';
$route['Compliance-Filter/HF-Supervisoryvisit'] 	= 'red_rec_microplan/RedRec_compliances/compliancesFilters';
$route['Surveillance/Filters/Outbreak_Response'] 	= 'Other_Reports/reportFilters';
$route['Surveillance/Outbreak_Response']= 'Other_Reports/Outbreak_Response';
//-------------Routing for Suggestions/Auto Filling etc
//-------------new red rec routs---------
$route['Micro-plan/yearly']= 'redrec/dataentry/Microplan_yearly/microplan_yearly_add';
$route['Micro-plan/yearly_list']= 'redrec/dataentry/Microplan_yearly/microplan_yearly_list';
/* Custom Dashboard Routing */
$route['custom-dashboard'] 				= 'customdashboard/Custom_Dashboard';
//-------------Routing for HR Management Level(Admin)----------------
$route['Hr_management/level_list'] 			= 'cpanel/hr_management/Hr_management/level_list';
$route['Hr_management/level_add'] 			= 'cpanel/hr_management/Hr_management/level_add';
$route['Hr_management/level_edit_get'] 		= 'cpanel/hr_management/Hr_management/level_edit_get';
$route['Hr_management/level_edit'] 			= 'cpanel/hr_management/Hr_management/level_edit';
$route['Hr_management/level_del/(:any)'] 	= 'cpanel/hr_management/Hr_management/level_del/$1';
//-------------Routing for HR Management Type(Admin)----------------
$route['Hr_management/type_list'] 			= 'cpanel/hr_management/Hr_management/type_list';
$route['Hr_management/type_add'] 			= 'cpanel/hr_management/Hr_management/type_add';
$route['Hr_management/type_edit_get'] 		= 'cpanel/hr_management/Hr_management/type_edit_get';
$route['Hr_management/type_edit'] 			= 'cpanel/hr_management/Hr_management/type_edit';
$route['Hr_management/type_del/(:any)'] 	= 'cpanel/hr_management/Hr_management/type_del/$1';
//-------------Routing for HR Management Subtype(Admin)----------------
$route['Hr_management/subtype_list'] 		= 'cpanel/hr_management/Hr_management/subtype_list';
$route['Hr_management/subtype_add'] 		= 'cpanel/hr_management/Hr_management/subtype_add';
$route['Hr_management/subtype_edit_get'] 	= 'cpanel/hr_management/Hr_management/subtype_edit_get';
$route['Hr_management/subtype_edit'] 		= 'cpanel/hr_management/Hr_management/subtype_edit';
$route['Hr_management/subtype_del/(:any)'] 	= 'cpanel/hr_management/Hr_management/subtype_del/$1';
//-------------Routing for HR Management Training (Admin)----------------
$route['Hr_management/training_list'] 		= 'cpanel/hr_management/Hr_management/training_list';
$route['Hr_management/training_add'] 		= 'cpanel/hr_management/Hr_management/training_add';
$route['Hr_management/training_edit_get'] 	= 'cpanel/hr_management/Hr_management/training_edit_get';
$route['Hr_management/training_edit'] 		= 'cpanel/hr_management/Hr_management/training_edit';
$route['Hr_management/training_del/(:any)'] = 'cpanel/hr_management/Hr_management/training_del/$1';
//-------------Routing for HR Management (DEO)----------------
$route['Hr_management/hr_list'] 			= 'system_set/hr_management/Hr_management/hr_list';
$route['Hr_management/hr_add'] 				= 'system_set/hr_management/Hr_management/hr_add';
$route['Hr_management/hr_save'] 			= 'system_set/hr_management/Hr_management/hr_save';
$route['Hr_management/hr_view/(:any)'] 		= 'system_set/hr_management/Hr_management/hr_view/$1';
$route['Hr_management/hr_edit_get/(:any)'] 	= 'system_set/hr_management/Hr_management/hr_edit_get/$1';
$route['Hr_management/hr_edit'] 			= 'system_set/hr_management/Hr_management/hr_edit';
$route['Hr_management/hr_del/(:any)'] 		= 'system_set/hr_management/Hr_management/hr_del/$1';
$route['Hr_management/hr_status_edit/(:any)'] 		         = 'system_set/hr_management/Hr_management/hr_status_edit/$1';
$route['Hr_management/hr_status_save'] 			             = 'system_set/hr_management/Hr_management/hr_status_save';
$route['Hr_management/hr_status_del/(:any)/(:any)/(:any)'] 	 = 'system_set/hr_management/Hr_management/hr_status_del/$1/$2/$3';  
$route['Hr_management/get_training/(:any)'] = 'system_set/hr_management/Hr_management/get_training/$1';
//-------------Routing for Ajax HR Management (DEO)----------------
$route['Ajax_hr_management/hr_list_filter'] 	= 'system_set/hr_management/Ajax_hr_management/hr_list_filter';
$route['Ajax_hr_management/hr_list_search'] 	= 'system_set/hr_management/Ajax_hr_management/hr_list_search';
$route['Ajax_hr_management/sub_type_options'] 	= 'system_set/hr_management/Ajax_hr_management/sub_type_options';
//-------------Routing for Disease Surveillance--------------------
$route['Disease_Surveillance/Diseases_List']  = 'cpanel/disease_surveillance/Disease_surveillance/diseases_list';
$route['Disease_Surveillance/Disease_add']  = 'cpanel/disease_surveillance/Disease_surveillance/disease_add';
//-------------Routing for Lookups Management (Admin)----------------
$route['Lookups_management/lookups_list'] 		= 'cpanel/lookups_management/Lookups_management/lookups_list';
$route['Lookups_management/lookups_add'] 		= 'cpanel/lookups_management/Lookups_management/lookups_add';
$route['Lookups_management/lookups_edit_get'] 	= 'cpanel/lookups_management/Lookups_management/lookups_edit_get';
$route['Lookups_management/lookups_edit'] 		= 'cpanel/lookups_management/Lookups_management/lookups_edit';
$route['Lookups_management/lookups_del/(:any)'] = 'cpanel/lookups_management/Lookups_management/lookups_del/$1';
$route['Ajax_hr_management/gl_list_search'] 	= 'system_set/hr_management/Ajax_hr_management/gl_list_search';
//-------------Routing for Cold Chain Management (Admin)----------------
//List routes
$route['Coldchain/Catalogue_Refrigerator_List/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_refrigerator_list'; 
$route['Coldchain/Catalogue_Coldroom_List/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_coldroom_list'; 
$route['Coldchain/Catalogue_Voltageregulator_List/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_voltageregulator_list'; 
$route['Coldchain/Catalogue_Generator_List/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_generator_list'; 
$route['Coldchain/Catalogue_Transport_List/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_transport_list'; 
$route['Coldchain/Catalogue_Vaccinecarriers_List/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_vaccinecarriers_list'; 
$route['Coldchain/Catalogue_Coldbox_List/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_coldbox_list'; 
//add routes
$route['Coldchain/Catalogue_refrigeratorAdd']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_refrigerator_add';
$route['Coldchain/Catalogue_coldroomAdd']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_coldroom_add';
$route['Coldchain/Catalogue_voltageregulatorAdd']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_voltageregulator_add';
$route['Coldchain/Catalogue_generatorAdd']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_generator_add';
$route['Coldchain/Catalogue_transportAdd']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_transport_add';
$route['Coldchain/Catalogue_vaccineCarriersAdd']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_vaccineCarriers_add';
$route['Coldchain/Catalogue_coldBoxAdd']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_coldbox_add';
//Edit routes
$route['Coldchain/Catalogue_refrigeratorEdit/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_refrigerator_edit';
$route['Coldchain/Catalogue_coldroomEdit/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_coldroom_edit';
$route['Coldchain/Catalogue_voltageRegulatorEdit/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_voltageregulator_edit';
$route['Coldchain/Catalogue_generatorEdit/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/Catalogue_generator_edit';
$route['Coldchain/Catalogue_transportEdit/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/Catalogue_transport_edit';
$route['Coldchain/Catalogue_vaccineCarriersEdit/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/Catalogue_vaccineCarriers_edit';
$route['Coldchain/Catalogue_coldBoxEdit/(:any)']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/Catalogue_coldBox_edit';
//save routes
$route['Coldchain/Catalogue_refrigeratorSave']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_refrigeratorsave';
$route['Coldchain/Catalogue_coldroomSave']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_coldroomsave';
$route['Coldchain/Catalogue_voltageregulatorSave']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_voltageregulatorsave';
$route['Coldchain/Catalogue_generatorSave']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_generatorsave';
$route['Coldchain/Catalogue_transportSave']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_transportsave';
$route['Coldchain/Catalogue_vaccinecarriersSave']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_vaccinecarrierssave';
$route['Coldchain/Catalogue_coldBoxSave']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_coldboxsave';
//updated routes
$route['Coldchain/Catalogue_refrigeratorUpdate']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_refrigeratorUpdate';
$route['Coldchain/Catalogue_coldroomUpdate']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_coldroomUpdate';
$route['Coldchain/Catalogue_voltageregulatorUpdate']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_voltageregulatorUpdate';
$route['Coldchain/Catalogue_generatorUpdate']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_generatorUpdate';
$route['Coldchain/Catalogue_transportUpdate']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_transportUpdate';
$route['Coldchain/Catalogue_vaccinecarriersUpdate']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_vaccinecarriersUpdate';
$route['Coldchain/Catalogue_coldBoxUpdate']	= 'cpanel/coldchain_catalogue/Coldchain_catalogue/catalogues_coldboxUpdate';
//-------------Routing for ColdChain Reports----------------
$route['Reports/ColdchainReportsFilter']  = 'cold_chain/Reports/reportFilters'; 
$route['Reports/AssetAvailability']   	  = 'cold_chain/Reports/asset_availability'; 
$route['Reports/ColdchainReportsAssetFilter']  = 'cold_chain/Reports/assetreportFilters';
$route['Reports/AssetAvailabilityReport']   	  = 'cold_chain/Reports/asset_availability_report'; 
$route['Assets/View/(:any)']	                  = 'cold_chain/Reports/allassets_Views/$1';  
//-------------Routing for User Searching----------------
$route['Ajax_hr_management/user_list_search'] 	= 'system_set/hr_management/Ajax_hr_management/user_list_search';
//Routing for New HR Reports///
//New HR Summary Report///
$route['HRReports/Filter/HR-Summary-Report'] 	= 'HR_Reports/summaryreport/hr_summary_report'; 
$route['HR_Reports/HR-Summary-Report'] 	= 'HR_Reports/HR_Summary_Report';
$route['HRReports/hr-view/(:any)'] 		= 'HR_Reports/hr_view_status/$1';

$route['Coverage_consumption/Filters/Coverage-and-Consumption'] = 'Coverage_consumption/Reports_Filters/coverage_and_consumption';
//-------------Routing for Item management----------------
$route['Item_management/item_list'] 		= 'cpanel/item_management/Item_management/item_list';
$route['Item_management/item_add'] 		= 'cpanel/item_management/Item_management/item_add';
$route['Ajax_hr_management/item_list_search'] 	= 'system_set/hr_management/Ajax_hr_management/item_list_search';
$route['Item_management/item_edit/(:any)'] 	 = 'cpanel/item_management/Item_management/item_edit/$1';
$route['Item_management/item_del/(:any)'] 	 = 'cpanel/item_management/Item_management/item_del/$1';  
$route['Ajax_hr_management/role_list_search'] 	= 'system_set/hr_management/Ajax_hr_management/role_list_search';
//-------------Routing for Suppliers management----------------
$route['Suppliers_management/suppliers_list'] 		= 'cpanel/suppliers_management/Suppliers_management/suppliers_list';
$route['Suppliers_management/suppliers_add'] 		= 'cpanel/suppliers_management/Suppliers_management/suppliers_add';
$route['Ajax_hr_management/suppliers_list_search'] 	= 'system_set/hr_management/Ajax_hr_management/suppliers_list_search';
$route['Suppliers_management/suppliers_edit/(:any)'] 	 = 'cpanel/suppliers_management/Suppliers_management/suppliers_edit/$1';
$route['Suppliers_management/suppliers_del/(:any)'] 	 = 'cpanel/suppliers_management/Suppliers_management/suppliers_del/$1';   
//-------------Routing for Donors management----------------
$route['Donors_management/donors_list'] 		= 'cpanel/donors_management/Donors_management/donors_list';
$route['Donors_management/donors_add'] 		= 'cpanel/donors_management/Donors_management/donors_add';
$route['Ajax_hr_management/donors_list_search'] 	= 'system_set/hr_management/Ajax_hr_management/donors_list_search';
$route['Donors_management/donors_edit/(:any)'] 	 = 'cpanel/donors_management/Donors_management/donors_edit/$1';
$route['Donors_management/donors_del/(:any)'] 	 = 'cpanel/donors_management/Donors_management/donors_del/$1'; 
//-------------Routing for Stakeholder_activities management----------------
$route['Stakeholder_activities_management/stakeholder_activities_list'] 		= 'cpanel/stakeholder_activities_management/Stakeholder_activities_management/stakeholder_activities_list';
$route['Stakeholder_activities_management/stakeholder_activities_add'] 		= 'cpanel/stakeholder_activities_management/Stakeholder_activities_management/stakeholder_activities_add';
$route['Ajax_hr_management/stakeholder_activities_list_search'] 	= 'system_set/hr_management/Ajax_hr_management/stakeholder_activities_list_search';
$route['Stakeholder_activities_management/stakeholder_activities_edit/(:any)'] 	 = 'cpanel/stakeholder_activities_management/Stakeholder_activities_management/stakeholder_activities_edit/$1';
$route['Stakeholder_activities_management/stakeholder_activities_del/(:any)'] 	 = 'cpanel/stakeholder_activities_management/Stakeholder_activities_management/stakeholder_activities_del/$1';  