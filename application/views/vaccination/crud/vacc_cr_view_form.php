<?php 
date_default_timezone_set('Asia/Karachi');
$current_date = date('d-m-Y');
if(isset($formB_Result)){ 
	$year=substr($formB_Result->fmonth,0,4);
	$month=substr($formB_Result->fmonth,5,7);
	$facode=$formB_Result->facode;
}
$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true,array("nature"=>"nature")):false;
?>
<!--start of page content or body-->
<div class="container bodycontainer">  
	<div class="row">
		<div class="panel panel-primary">
			<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
			<div class="panel-heading">Health Facility Monthly Vaccination & Consumption Form</div>
			<div class="panel-body">
				<table class="table table-bordered table-striped table-hover  mytable">
					<tr>
						<td><label style="margin-top: 7px;">Province</label></td>
						<td><?php echo $this -> session -> provincename; ?></td>
						<td><label style="margin-top: 7px;">District</label></td>
						<td><?php echo get_District_Name($formB_Result -> distcode); ?></td>
						<td><label style="margin-top: 7px;">Date (MM/YY)</label></td>
						<td><?php echo monthname($month); ?> <?php echo $year; ?></td>
					</tr>
					<tr>
						<td><label style="margin-top: 7px;">Tehsil</label></td>
						<td><?php echo get_Tehsil_Name($formB_Result -> tcode); ?></td>
						<td><label style="margin-top: 7px;">UC</label></td>
						<td><?php echo get_UC_Name($formB_Result -> uncode); ?></td>
						<td><label style="margin-top: 7px;">Health Facility/Store</label></td>
						<td><?php echo get_Facility_Name($formB_Result -> facode).' - '.$formB_Result -> facode; ?></td>
					</tr>
					<tr>
						<td colspan="2"><label>Monthly Target For Children 0-11</label></td>
						<td><label>Male</label></td>
						<td><?php echo isset($vacc_Result)?$vacc_Result->tc_male:0; ?></td>
						<td><label>Female</label></td>
						<td><?php echo isset($vacc_Result)?$vacc_Result->tc_female:0; ?></td>
					</tr>
					<tr>
						<td><label>Monthly Target for Pregnant Women</label></td>
						<td><?php echo isset($vacc_Result)?$vacc_Result->pw_monthly_target:0; ?></td>
						<td><label>Total LHWs Attached</label></td>
						<td><?php echo isset($vacc_Result)?$vacc_Result->tot_lhw_attached:0; ?></td>
						<td><label>Total LHWs Involved in Vaccination</label></td>
						<td><?php echo isset($vacc_Result)?$vacc_Result->tot_lhw_involved_vacc:0; ?></td>
					</tr> 
				</table>
				<table class="table table-bordered table-condensed table-striped table-hover mytable3">
					<thead>
						<tr>
							<th colspan="10" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">EPI Services</th>
						</tr>
						<tr>
							<th colspan="2">Fixed Vaccination Session by Vaccinator/s</th>
							<th colspan="2">Outreach Vaccination Session by Vaccinator/s</th>
							<th colspan="2">Mobile Vaccination Session by Vaccinator/s</th>
							<th colspan="2">Health House Vaccination Session by LHWs</th>
						</tr>
						<tr>
							<th>Planned</th>
							<th>Actually held</th>
							<th>Planned</th>
							<th>Actually held</th>
							<th>Planned</th>
							<th>Actually held</th>
							<th>Planned</th>
							<th>Actually held</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center"><?php echo isset($vacc_Result)?$vacc_Result->fixed_vacc_planned:0; ?></td>
							<td class="text-center"><?php echo isset($vacc_Result)?$vacc_Result->fixed_vacc_held:0; ?></td>
							<td class="text-center"><?php echo isset($vacc_Result)?$vacc_Result->or_vacc_planned:0; ?></td>
							<td class="text-center"><?php echo isset($vacc_Result)?$vacc_Result->or_vacc_held:0; ?></td>
							<!-- ======================================== -->
							<td class="text-center"><?php echo isset($vacc_Result)?$vacc_Result->mv_vacc_planned:0; ?></td>
							<td class="text-center"><?php echo isset($vacc_Result)?$vacc_Result->mv_vacc_held:0; ?></td>
							<!-- ========================================= -->
							<td class="text-center"><?php echo isset($vacc_Result)?$vacc_Result->hh_vacc_planned:0; ?></td>
							<td class="text-center"><?php echo isset($vacc_Result)?$vacc_Result->hh_vacc_held:0; ?></td>
						</tr>
					</tbody>
				</table>
				<div id="datasharigdiv">
					<table id="datasharigtbl" class="fixTable22 table table-bordered table-condensed table-striped table-hover mytable3">
						<thead>
							<tr>
								<th colspan="6"><label>OUT UC DATA</label></th>
							</tr>
							<tr>
								<th><label>Country</label></th>
								<th><label>Province</label></th>
								<th><label>District</label></th>
								<th><label>Tehsil</label></th>
								<th><label>Union Council</label></th>
								<th><label>Action</label></th>
							</tr>
						</thead>
						<tbody id="datasharigbody" class="default">
							<tr class="text-center defaultrow">
								<td colspan="6" style="font-size:20px"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right">
							<input type="checkbox" id="outchkbox">Show Outside Columns
						</div>
					</div>
				</div>
				<div id="parent">
					<table id="fixTable" class="fixTable22 table table-bordered table-condensed table-striped table-hover mytable3">
						<thead>
							<tr>
								<th rowspan="6" style="width:14%;"><label>Product</label></th>
								<th rowspan="6"><label>#</label></th>
								<th colspan="78" class="mergedvaccinatedcells"><label>Vaccinated</label></th>
								<th rowspan="6" style="width:7%;"><label class="rotateheaderlabels">Batch number</label></th>
								<th rowspan="6" style="width:1%;"><label class="rotateheaderlabels">Doses Per Vial</label></th>
								<th rowspan="5"><label>Opening Balance</label></th>
								<th rowspan="5"><label>Received</label></th>
								<th colspan="2" rowspan="5"><label>Used</label></th>
								<th colspan="2" rowspan="5"><label>Unusable</label></th>
								<!--<th colspan="3" rowspan="5"><label>Adjustment</label></th>-->
								<th colspan="2" rowspan="5"><label>Closing Balance</label></th>
							</tr>
							<tr>
								<th colspan="26" class="hidden14"><label>Number of Children Vaccinated (0-11 months)</label></th>
								<th colspan="26" class="hidden14"><label>Number of Children Vaccinated (12-23 months)</label></th>
								<th colspan="26" class="hidden14"><label>02 Years and above</label></th>
								<!--<th rowspan="5" class="datasharing"><label>Data Sharing</label></th>-->
							</tr>
							<tr>
								<th colspan="6" class="hidden2"><label>Fixed</label></th>
								<th colspan="6" class="hidden4"><label>Outreach</label></th>
								<th colspan="6" class="hidden4"><label>Mobile</label></th>
								<th colspan="6" class="hidden4"><label>Health House</label></th>
								<th rowspan="4" class="hidden8"><label>Total Defaulter</label></th>
								<th rowspan="4" class="hidden8"><label>Defaulter Covered</label></th>
								<th colspan="6" class="hidden2"><label>Fixed</label></th>
								<th colspan="6" class="hidden4"><label>Outreach</label></th>
								<th colspan="6" class="hidden4"><label>Mobile</label></th>
								<th colspan="6" class="hidden4"><label>Health House</label></th>
								<th rowspan="4" class="hidden8"><label>Total Defaulter</label></th>
								<th rowspan="4" class="hidden8"><label>Defaulter Covered</label></th>
								<th colspan="6" class="hidden2"><label>Fixed</label></th>
								<th colspan="6" class="hidden4"><label>Outreach</label></th>
								<th colspan="6" class="hidden4"><label>Mobile</label></th>
								<th colspan="6" class="hidden4"><label>Health House</label></th>
								<th rowspan="4" class="hidden8"><label>Total Defaulter</label></th>
								<th rowspan="4" class="hidden8"><label>Defaulter Covered</label></th>
							</tr>
							<tr class="text-center">
								<th colspan="2">Inside Uc</th>
								<th colspan="2">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2" class="outsidecol">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2" class="outsidecol">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2" class="outsidecol">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2" class="outsidecol">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2" class="outsidecol">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2" class="outsidecol">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2" class="outsidecol">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2" class="outsidecol">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
								<th colspan="2">Inside Uc</th>
								<th colspan="2" class="outsidecol">Outside Uc</th>
								<th colspan="2" class="outsidecol">Outside District</th>
							</tr>
							<tr class="text-center">
								<th>M</th>
								<th>F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th>M</th>
								<th>F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
								<th class="outsidecol">M</th>
								<th class="outsidecol">F</th>
							</tr>
							<tr>
								<th>Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th>Nos.</th>
								<th>Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>
								<th class="outsidecol">Nos.</th>									
								<th>Doses</th>
								<th>Doses</th>
								<th>Vials</th>
								<th>Doses</th>
								<th>Vials</th>
								<th>Doses</th>
								<th>Vials</th>
								<th>Doses</th>
								<!--<th style="width:1%">Action</th>
								<th>Vials</th>
								<th>Doses</th>-->
							</tr>
							<tr style="background: white none repeat scroll 0% 0%; color: black;">
								<th></th>
								<th></th>
								<th  style="color: White;" colspan="78" class="mergedvaccinatedcells">D</th>
								<th></th>
								<th style="color: White;">A</th>
								<th style="color: White;">B</th>
								<th style="color: White;">C</th>
								<th colspan="2"  style="color: White;">E</th>
								<th colspan="2"  style="color: White;">F</th>
								<!--<th></th>
								<th></th>
								<th></th>-->
								<th colspan="2"  style="color: White;">G</th>
							</tr>
						</thead>
						<tbody id="myTable" class="consumptionitems default">
							<?php 
							$disabledstyle = 'background-color:#eee;';
							$toppadding = 'padding-top:11px;';
							$leftpadding = 'padding-left:10px;';
							$rightpadding = 'padding-right:10px;';
							$previtemname = $finaloutput = $lastrow = $batches = $dosespervial = $openingdoses = $receiveddoses =$usedvials = $useddoses = $unusedvials = $unuseddoses = $closingvials = $closingdoses =  $fmcells = "";
							$vaccinated = array();
							//$datasharingicon = '<img src="/assets/svgs/dooricon.svg" alt="Data Sharing Action" data-toggle="modal" data-target="#DataSharingModal" height="35" class="sharedata">';
							//$ttdatasharingicon = '<img src="/assets/svgs/dooricon.svg" alt="Data Sharing Action" data-toggle="modal" data-target="#TTDataSharingModal" height="35" class="sharedata">';
							if(isset($cr_items["product"])){
								$vaccinated = $cr_items["product"];
								unset($cr_items["product"]);
							}
							foreach($cr_items as $key=>$singleVacc){
								$batch=$singleVacc["batch"];
								$dosepervial=$singleVacc["doses"];
								$moonitemname = ($singleVacc["item_category_id"]!=1)?trim($singleVacc["item_name"]):trim($singleVacc["itemname"]);
								$vaccnum = (isset($singleVacc["multiplier"]) && isset($singleVacc["item_category_id"]) && $singleVacc["item_category_id"]==1)?$singleVacc["multiplier"]:1;
								if($previtemname == $moonitemname){
									$itemnamecell = $childvaccinatedcell = '';
									$batches .= '<br>'.$batch;
									$dosespervial .= '<br>'.$dosepervial;
									$openingdoses .= '<br>'.$singleVacc["opening"];
									$receiveddoses .= '<br>'.$singleVacc["recdoses"];
									$usedvials .= '<br>'.(($singleVacc["used_vials"])?$singleVacc["used_vials"]:'');
									$useddoses .= '<br>'.(($singleVacc["used_doses"])?$singleVacc["used_doses"]:'');
									$unusedvials .= '<br>'.(($singleVacc["unused_vials"])?$singleVacc["unused_vials"]:'');
									$unuseddoses .= '<br>'.(($singleVacc["unused_doses"])?$singleVacc["unused_doses"]:'');
									$closingvials .= '<br>'.$singleVacc["closing_vials"];
									$closingdoses .= '<br>'.$singleVacc["closing_doses"];
								}else{
									if($lastrow!=""){
										//parse last row and add batches
										$lastrow = str_replace('{batcheshere}', $batches, $lastrow);
										$lastrow = str_replace('{doseshere}', $dosespervial, $lastrow);
										$lastrow = str_replace('{openinghere}', $openingdoses, $lastrow);
										$lastrow = str_replace('{receivedhere}', $receiveddoses, $lastrow);
										$lastrow = str_replace('{usedvialshere}', $usedvials, $lastrow);
										$lastrow = str_replace('{useddoseshere}', $useddoses, $lastrow);
										$lastrow = str_replace('{unusedvialshere}', $unusedvials, $lastrow);
										$lastrow = str_replace('{unuseddoseshere}', $unuseddoses, $lastrow);
										$lastrow = str_replace('{closingvialshere}', $closingvials, $lastrow);
										$lastrow = str_replace('{closingdoseshere}', $closingdoses, $lastrow);
										$finaloutput .= $lastrow;
										$lastrow = "";
									}
									//first initialization
									$batches = $batch;
									$dosespervial = $dosepervial;
									$openingdoses = $singleVacc["opening"];
									$receiveddoses = $singleVacc["recdoses"];
									$usedvials = (($singleVacc["used_vials"])?$singleVacc["used_vials"]:'');
									$useddoses = (($singleVacc["used_doses"])?$singleVacc["used_doses"]:'');
									$unusedvials = (($singleVacc["unused_vials"])?$singleVacc["unused_vials"]:'');
									$unuseddoses = (($singleVacc["unused_doses"])?$singleVacc["unused_doses"]:'');
									$closingvials = $singleVacc["closing_vials"];
									$closingdoses = $singleVacc["closing_doses"];
									//add new column for item name
									$prevrowspan = 1*$vaccnum;
									$itemnamecell = '<td style="'.$leftpadding.$rightpadding.'" class="itemname" data-moon="temp" rowspan="'.$prevrowspan.'"><label>'.$moonitemname.'</label>
									</td>';
									if($singleVacc["item_id"] == "6"){
										$lastrow .= '
										<tr class="" style="background:#008d4c;color:white;">
											<th class="text-center" rowspan="4"><label>Product</label></th>
											<th class="text-center" rowspan="4"><label>#</label></th>
											<th colspan="18" class="hidden6 text-center"><label>Fixed</label></th>
											<th colspan="18" class="hidden12 text-center"><label>Outreach</label></th>
											<th colspan="18" class="hidden12 text-center"><label>Mobile</label></th>
											<th colspan="18" class="hidden12 text-center"><label>Health House</label></th>
											
											<th style="width:7%;" rowspan="4"><label>Batch number</label></th>
											<th style="width:1%;" rowspan="4"><label>Doses Per Vial</label></th>
											<th rowspan="3"><label>Opening Balance</label></th>
											<th rowspan="3"><label>Received</label></th>
											<th colspan="2" rowspan="3"><label>Used</label></th>
											<th colspan="2" rowspan="3"><label>Unusable</label></th>
											<th colspan="2" rowspan="3"><label>Closing Balance</label></th>
										</tr>
										<tr class="" style="background:#008d4c;color:white;">
											<th colspan="6" class="text-center text-center">Inside Uc</th>
											<th colspan="6" class="text-center text-center">Outside Uc</th>
											<th colspan="6" class="outsidecol">Outside District</th>
											<th colspan="6" class="text-center text-center">Inside Uc</th>
											<th colspan="6" class="outsidecol">Outside Uc</th>
											<th colspan="6" class="outsidecol">Outside District</th>
											<th colspan="6" class="text-center text-center">Inside Uc</th>
											<th colspan="6" class="outsidecol text-center">Outside Uc</th>
											<th colspan="6" class="outsidecol text-center">Outside District</th>
											<th colspan="6" class="text-center">Inside Uc</th>
											<th colspan="6" class="outsidecol text-center">Outside Uc</th>
											<th colspan="6" class="outsidecol text-center">Outside District</th>
										</tr>
										<tr class="" style="background:#008d4c;color:white;">
											<th colspan="3" class="text-center">Pregnant Women</th>
											<th colspan="3" class="text-center">Non-Pregnant</th>
											<th colspan="3" class="text-center">Pregnant Women</th>
											<th colspan="3" class="text-center">Non-Pregnant</th>
											<th colspan="3" class="outsidecol text-center">Pregnant Women</th>
											<th colspan="3" class="outsidecol text-center">Non-Pregnant</th>
											
											<th colspan="3" class="text-center">Pregnant Women</th>
											<th colspan="3" class="text-center">Non-Pregnant</th>				
											<th colspan="3" class="outsidecol text-center">Pregnant Women</th>
											<th colspan="3" class="outsidecol text-center">Non-Pregnant</th>
											<th colspan="3" class="outsidecol text-center">Pregnant Women</th>
											<th colspan="3" class="outsidecol text-center">Non-Pregnant</th>
											
											<th colspan="3" class="text-center">Pregnant Women</th>
											<th colspan="3" class="text-center">Non-Pregnant</th>
											<th colspan="3" class="outsidecol text-center">Pregnant Women</th>
											<th colspan="3" class="outsidecol text-center">Non-Pregnant</th>				
											<th colspan="3" class="outsidecol text-center">Pregnant Women</th>
											<th colspan="3" class="outsidecol text-center">Non-Pregnant</th>
											
											<th colspan="3" class="text-center">Pregnant Women</th>
											<th colspan="3" class="text-center">Non-Pregnant</th>
											<th colspan="3" class="outsidecol text-center">Pregnant Women</th>
											<th colspan="3" class="outsidecol text-center">Non-Pregnant</th>
											<th colspan="3" class="outsidecol text-center">Pregnant Women</th>
											<th colspan="3" class="outsidecol text-center">Non-Pregnant</th>
										</tr>
										<tr class="" style="background:#008d4c;color:white;">
											<th colspan="3" class="text-center">Nos.</th>
											<th colspan="3" class="text-center">Nos.</th>
											<th colspan="3" class="text-center">Nos.</th>
											<th colspan="3" class="text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											
											<th colspan="3" class="text-center">Nos.</th>
											<th colspan="3" class="text-center">Nos.</th>				
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											
											<th colspan="3" class="text-center">Nos.</th>
											<th colspan="3" class="text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>				
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											
											<th colspan="3" class="text-center">Nos.</th>
											<th colspan="3" class="text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											<th colspan="3" class="outsidecol text-center">Nos.</th>
											
											<th class="text-center">Doses</th>
											<th class="text-center">Doses</th>
											<th class="text-center">Vials</th>
											<th class="text-center">Doses</th>
											<th class="text-center">Vials</th>
											<th class="text-center">Doses</th>
											<th class="text-center">Vials</th>
											<th class="text-center">Doses</th>
										</tr>';
										$ttSec = True;
									}else{
										$ttSec = False;
									}
									for($repeat = 0;$repeat<$vaccnum;$repeat++ ){
										if($repeat==0){
											$initialclass="cst-item-row";
											$initial = $itemnamecell;
											$mid = 
												'<td style="'.$toppadding.'" class="prodbatch" rowspan="'.$vaccnum.'">{batcheshere}</td>
												<td class="text-center doses" rowspan="'.$vaccnum.'" style="'.$toppadding.' '.(($dosepervial>0)?'':$disabledstyle).'">{doseshere}</td>
												<td class="text-center ob" rowspan="'.$vaccnum.'" style="'.$toppadding.' '.$disabledstyle.'">{openinghere}</td>
												<td class="text-center received" rowspan="'.$vaccnum.'" style="'.$toppadding.' '.$disabledstyle.'">{receivedhere}</td>
												';
											$last = '
												<td rowspan="'.$vaccnum.'">{usedvialshere}</td>
												<td rowspan="'.$vaccnum.'">{useddoseshere}</td>
												<td rowspan="'.$vaccnum.'">{unusedvialshere}</td>
												<td rowspan="'.$vaccnum.'">{unuseddoseshere}</td>
												<td rowspan="'.$vaccnum.'">{closingvialshere}</td>
												<td rowspan="'.$vaccnum.'">{closingdoseshere}</td>';
										}else{
											$initialclass="";
											$initial = '';
											$mid = '';
											$last = '';
										}
										if($ttSec){
											$childvaccinatedcell = getVaccinatedCellsTT($singleVacc,$vaccinated,$repeat);			
										}else{
											$childvaccinatedcell = getVaccinatedCells($singleVacc,$vaccinated,$repeat,$fmcells);
										}
										$childvaccinatedcellsrow = str_replace('moonrownum', $repeat, $childvaccinatedcell);
										
										$antigenNum = (($vaccnum>1)?$repeat+1:'');
										if($singleVacc["item_id"]=="15"){
											$antigenNum = $repeat;
										}
										$lastrow .= '
											<tr class="onebatch '.$initialclass.'" data-prodrow="'.$singleVacc["item_id"].'">
												'.$initial.
												'
												<td class="text-center vaccnum" '.$disabledstyle.'"><b>'.($antigenNum).'</b></td>'.					
												$childvaccinatedcellsrow.''.$mid.
												$last.'
											</tr>';
									}
								}
								$previtemname = $moonitemname;
							}
							//for fully immunized row
							$sumffullyimmunized=((isset($vaccinated["vaccinated"][9999][0]['iufm1'])?$vaccinated["vaccinated"][9999][0]['iufm1']:0)+(isset($vaccinated["vaccinated"][9999][0]['iuff1'])?$vaccinated["vaccinated"][9999][0]['iuff1']:0));
							$fullyimmunized .= '
								<tr class="cst-item-row" data-prodrow="9999">
									<td style="padding-left: 10px; padding-right: 10px; background-color: whitesmoke; position: relative; left: 0px;" class="itemname" data-moon="temp"><label>Fully Immunized</label></td>
									<td class="text-center vaccnum" background-color:#eee;"="" style="background-color: whitesmoke; position: relative; left: 0px;"></td>
									<td colspan="5">
										<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;    font-weight: bold">M:</span>
										'.(isset($vaccinated["vaccinated"][9999][0]["iufm1"])?$vaccinated["vaccinated"][9999][0]["iufm1"]:0).'
									</td >
									<td colspan="5">
										<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;font-weight: bold">F:</span>
										'.(isset($vaccinated["vaccinated"][9999][0]["iuff1"])?$vaccinated["vaccinated"][9999][0]["iuff1"]:0).'
									</td>
									<td colspan="5">
										<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;font-weight: bold">Total:</span>
										'.$sumffullyimmunized.'
									</td>
									<td class="prodbatch" colspan="10"></td>
								</tr>';
							$finaloutput .= $fullyimmunized;
							
							//for dtp booster row
							$sumdtpbooster=((isset($vaccinated["vaccinated"][9998][0]['iufm1'])?$vaccinated["vaccinated"][9998][0]['iufm1']:0)+(isset($vaccinated["vaccinated"][9998][0]['iuff1'])?$vaccinated["vaccinated"][9998][0]['iuff1']:0));
							$dtpbooster .= '
								<tr class="cst-item-row" data-prodrow="9998">
									<td style="padding-left: 10px; padding-right: 10px; background-color: whitesmoke; position: relative; left: 0px;" class="itemname" data-moon="temp"><label>DTP Booster</label></td>
									<td class="text-center vaccnum" background-color:#eee;"="" style="background-color: whitesmoke; position: relative; left: 0px;"></td>
									<td colspan="5">
										<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;    font-weight: bold">M:</span>
										'.(isset($vaccinated["vaccinated"][9998][0]["iufm1"])?$vaccinated["vaccinated"][9998][0]["iufm1"]:0).'
									</td >
									<td colspan="5">
										<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;font-weight: bold">F:</span>
										'.(isset($vaccinated["vaccinated"][9998][0]["iuff1"])?$vaccinated["vaccinated"][9998][0]["iuff1"]:0).'
									</td>
									<td colspan="5">
										<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;font-weight: bold">Total:</span>
										'.$sumdtpbooster.'
									</td>
									<td class="prodbatch" colspan="10"></td>
								</tr>';
							$finaloutput .= $dtpbooster;
							
							//parse last row and add batches
							$lastrow = str_replace('{batcheshere}', $batches, $lastrow);
							$lastrow = str_replace('{doseshere}', $dosespervial, $lastrow);
							$lastrow = str_replace('{openinghere}', $openingdoses, $lastrow);
							$lastrow = str_replace('{receivedhere}', $receiveddoses, $lastrow);
							$lastrow = str_replace('{usedvialshere}', $usedvials, $lastrow);
							$lastrow = str_replace('{useddoseshere}', $useddoses, $lastrow);
							$lastrow = str_replace('{unusedvialshere}', $unusedvials, $lastrow);
							$lastrow = str_replace('{unuseddoseshere}', $unuseddoses, $lastrow);
							$lastrow = str_replace('{closingvialshere}', $closingvials, $lastrow);
							$lastrow = str_replace('{closingdoseshere}', $closingdoses, $lastrow);
							echo $finaloutput .= $lastrow;

							function getVaccinatedCells($singleVacc,$vaccinated,$rownum,$fmcells){
								$item_id = $singleVacc["item_id"];
								$item_category_id = $singleVacc["item_category_id"];
								$childvaccinatedcell = '';
								$vaccinatedcells = $fmcells = array("iufm1","iuff1","oufm1","ouff1","odfm1","odff1","iuom1","iuof1","ouom1","ouof1","odom1","odof1","iumm1","iumf1","oumm1","oumf1","odmm1","odmf1","iuhm1","iuhf1","ouhm1","ouhf1","odhm1","odhf1","iutd1","iudc1","iufm2","iuff2","oufm2","ouff2","odfm2","odff2","iuom2","iuof2","ouom2","ouof2","odom2","odof2","iumm2","iumf2","oumm2","oumf2","odmm2","odmf2","iuhm2","iuhf2","ouhm2","ouhf2","odhm2","odhf2","iutd2","iudc2","iufm3","iuff3","oufm3","ouff3","odfm3","odff3","iuom3","iuof3","ouom3","ouof3","odom3","odof3","iumm3","iumf3","oumm3","oumf3","odmm3","odmf3","iuhm3","iuhf3","ouhm3","ouhf3","odhm3","odhf3","iutd3","iudc3");
								foreach($vaccinatedcells as $moonind=>$value){
									if(isset($vaccinated["vaccinated"][$item_id][$rownum][$value])){
										$vaccinatedval = $vaccinated["vaccinated"][$item_id][$rownum][$value];
									}else{
										$vaccinatedval = 0;
									}
									$sectionclass = "";
									$localmoonind = $moonind;
									if($moonind<26){
										//$sectionclass = "insideuc";
									}elseif($moonind<52){
										//$sectionclass = "outsideuc";
										$localmoonind = $moonind-26;
									}else{
										$localmoonind = $moonind-52;
									}
									if(in_array($localmoonind,array_merge(range(4,5),range(8,11),range(14,17),range(20,23)))){
										$sectionclass = "outsidecol";
									}
									if(in_array($localmoonind,array_merge(range(2,3),range(8,9),range(14,15),range(20,21)))){
										$sectionclass .= " outuccol";
									}
									if(in_array($localmoonind,array_merge(range(4,5),range(10,11),range(16,17),range(22,23)))){
										$sectionclass .= " outdistcol";
									}									
									// 
									$childvaccinatedcell .= '
										<td  class="'.$sectionclass.' '.(($item_category_id!=1)?'mergedvaccinatedcells':'').'" '.(($item_category_id!=1)?'colspan = "78"':'' ).'>
											'.($vaccinatedval).'
										</td>';
									if($item_category_id!=1){break;}
								}
								return $childvaccinatedcell;
							}
							function getVaccinatedCellsTT($singleVacc,$vaccinated,$rownum){
								$item_id = $singleVacc["item_id"];
								$item_category_id = $singleVacc["item_category_id"];
								$childvaccinatedcell = '';
								$vaccinatedcells = array("iufp","iufnp","oufp","oufnp","odfp","odfnp","iuop","iuonp","ouop","ouonp","odop","odonp","iump","iumnp","oump","oumnp","odmp","odmnp","iuhp","iuhnp","ouhp","ouhnp","odhp","odhnp");
								foreach($vaccinatedcells as $moonind=>$value){
									if(isset($vaccinated["vaccinated"][$item_id][$rownum][$value])){
										$vaccinatedval = $vaccinated["vaccinated"][$item_id][$rownum][$value];
									}else{
										$vaccinatedval = 0;
									}
									$sectionclass = "";
									$localmoonind = $moonind;
									/* if($moonind<8){
										//$sectionclass = "insideuc";
									}elseif($moonind<16){
										//$sectionclass = "outsideuc";
										//$localmoonind = $moonind-8;
									}else{
										//$sectionclass = "outsidedist";
										//$localmoonind = $moonind-16;
									} */
									if(in_array($localmoonind,array_merge(range(4,5),range(8,11),range(14,17),range(20,23)))){
										$sectionclass = "outsidecol";
									}
									$childvaccinatedcell .= '
										<td class="'.$sectionclass.' '.(($item_category_id!=1)?'mergedvaccinatedcells':'').'" '.(($item_category_id!=1)?'colspan = "24"':'colspan = "3"').'>
											'.($vaccinatedval).'
										</td>';
									if($item_category_id!=1){break;}
								}
								return $childvaccinatedcell;
							}?>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered table-striped">
							<tr>
								<td><label style="margin-top: 7px;">Prepared by</label></td>
								<td><input readonly="readonly"  class="form-control" name="prepare_by" id="prepare_by"  value="<?php if(isset($formB_Result)){ echo $formB_Result->prepared_by; } ?>" type="text"></td>
							   
								<td><label style="margin-top: 7px;">Medical Officer / In-charge Name</label></td>
								<td><input readonly="readonly"  class="form-control" name="incharge" id="incharge" value="<?php if(isset($formB_Result)){ echo $formB_Result->hf_incharge; } ?>" type="text">
								<input class="form-control" name="inchargeid" id="inchargeid" value="<?php if(isset($formB_Result)){ echo $formB_Result->hf_incharge; } ?>" type="hidden">
								</td>
								<td><label style="margin-top: 7px;">Date</label></td>
								<td><input class="form-control" readonly="readonly" name="date_submitted" id="date_submitted" value="<?php if(isset($formB_Result)){ if($formB_Result->created_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($formB_Result->created_date)); }else{ echo $current_date; } } else{ echo $current_date; }?>" type="text"></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<hr>
					<div style="text-align: right;" class="col-md-12 col-sm-12 col-xs-12">
						<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;"  class="btn btn-primary btn-md" id="update"><i class="fa fa-floppy-o "></i> Update </button>
						<a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel</a>
					</div>
				</div>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->

<!--- Modal for show Data sharing-->
<div class="modal fade" id="DataSharingModal" role="dialog" style="display: none;" onfocusin="resetstyle(this)">
	<div class="modal-dialog" style="width: auto;margin: 30px 35px;padding: 20px;">
		<!-- Modal content-->
		<form class="modalForm" id="modalForm-dataSharing">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-adjustment">Data Sharing (Out UC / Out District)</h4>
				</div>
				<div class="modal-body">
					<div class="row pb15">
						<div class="col-md-1"></div>
						<div class="col-md-2">
							<input class="countrycode form-control " name="datasharingcountry" type="text" value="" disabled="disabled">
						</div>
						<div class="col-md-2">
							<input class="procode form-control " name="datasharingprocode" type="text" value="" disabled="disabled">
						</div>
						<div class="col-md-2">
							<input class="district form-control " name="datasharingdistcode" type="text" value="" disabled="disabled">
						</div>
						<div class="col-md-2">
							<input class="tehsil form-control " name="datasharingtcode" type="text" value="" disabled="disabled">
						</div>
						<div class="col-md-2">
							<input class="unioncouncil form-control " name="datasharinguncode" type="text" value="" disabled="disabled">
						</div>
						<div class="col-md-1"></div>
					</div>
					<div class="row">
						<table id="datasharingtbl" class="fixTable22 table table-bordered table-condensed table-striped table-hover">
							<thead style="background:#008d4c;color:white;">
								<tr>
									<th rowspan="5"><label>Product</label></th>
									<th rowspan="5"><label>Antigen</label></th>
									<th colspan="24"><label>Vaccinated Children</label></th>
								</tr>
								<tr>
									<th colspan="8"><label>Number of Children Vaccinated (0-11 months)</label></th>
									<th colspan="8"><label>Number of Children Vaccinated (12-23 months)</label></th>
									<th colspan="8"><label>02 Years and above</label></th>
								</tr>
								<tr>
									<th colspan="2"><label>Fixed</label></th>
									<th colspan="2"><label>Outreach</label></th>
									<th colspan="2"><label>Mobile</label></th>
									<th colspan="2"><label>Health House</label></th>
									<th colspan="2"><label>Fixed</label></th>
									<th colspan="2"><label>Outreach</label></th>
									<th colspan="2"><label>Mobile</label></th>
									<th colspan="2"><label>Health House</label></th>
									<th colspan="2"><label>Fixed</label></th>
									<th colspan="2"><label>Outreach</label></th>
									<th colspan="2"><label>Mobile</label></th>
									<th colspan="2"><label>Health House</label></th>
								</tr>
								<tr class="text-center">
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
									<th>M</th>
									<th>F</th>
								</tr>
								<tr>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
								</tr>
							</thead>
							<tbody id="sharingdatatblebody" class="default">
								<?php
									$fmcells = array("fm1","ff1","om1","of1","mm1","mf1","hm1","hf1","fm2","ff2","om2","of2","mm2","mf2","hm2","hf2","fm3","ff3","om3","of3","mm3","mf3","hm3","hf3");
									if($fmcells!==""){
										$vaccinatedcellhtml = '<tr class="text-center modaldatasharingrow" data-productid=""><td class="prodname">Product Name</td><td class="antigennum">Antigen</td>';
										foreach($fmcells as $key=>$value){
											$sectionclass = "";
											$vaccinatedcellhtml .= '
												<td class="'.$sectionclass.' ">
													<input class="form-control numberclass childvacc " name="datasharing[vaccinated]['.$value.'][]" type="text"  disabled="disabled">
												</td>';
										}
										$vaccinatedcellhtml .= "</tr>";
									}
									$ttheader = '<tr class="text-center" style="background:#008d4c;color:white;">
										<th rowspan="4"><label>Product</label></th>
										<th rowspan="4"><label>Antigen</label></th>
										<th colspan="24"><label>Vaccinated Women</label></th>
									</tr>
									<tr class="text-center" style="background:#008d4c;color:white;">
										<th colspan="6"><label>Fixed</label></th>
										<th colspan="6"><label>Outreach</label></th>
										<th colspan="6"><label>Mobile</label></th>
										<th colspan="6"><label>Health House</label></th>
									</tr>
									<tr class="text-center" style="background:#008d4c;color:white;">
										<th colspan="3">Pregnant Women</th>
										<th colspan="3">Non-Pregnant</th>
										<th colspan="3">Pregnant Women</th>
										<th colspan="3">Non-Pregnant</th>
										<th colspan="3">Pregnant Women</th>
										<th colspan="3">Non-Pregnant</th>
										<th colspan="3">Pregnant Women</th>
										<th colspan="3">Non-Pregnant</th>
									</tr>
									<tr class="text-center" style="background:#008d4c;color:white;">
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
										<th colspan="3">Nos.</th>
									</tr>';
									$fmcells = array("fp","fnp","op","onp","mp","mnp","hp","hnp");
									$ttvaccinatedcellhtml = '<tr class="text-center modaldatasharingrow" data-productid=""><td class="prodname">Product Name</td><td class="antigennum">Antigen</td>';										
									foreach($fmcells as $key=>$value){
										$ttvaccinatedcellhtml .= '
											<td colspan="3">
												<input class="form-control numberclass childvacc " name="datasharing[vaccinated]['.$value.'][]" type="text"  disabled="disabled">
											</td>';
									}
									$ttvaccinatedcellhtml .= '</tr>';
								?>
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-6" style="margin-left: 65%;">
							<button class="btn-background box1" type="button" data-dismiss="modal" style="margin-left: 135px;"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							<input type="hidden" id="clickedrownum" name="rownum" value="" />
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="TTDataSharingModal" role="dialog" style="display: none;" onfocusin="resetstyle(this)">
	<div class="modal-dialog" style="width: auto;margin: 30px 35px;padding: 20px;">
		<!-- Modal content-->
		<form class="modalForm" id="modalForm-dataSharing">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-adjustment">Data Sharing (Out UC + Out District)</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-3">
							<label>Product</label>
						</div>
						<div class="col-md-3">
							<span id="ds-productname"></span>
						</div>
						<div class="col-md-3">
							<label>Antigen #</label>
						</div>
						<div class="col-md-3">
							<span id="ds-antigen"></span>
						</div>
					</div>
					<div class="row">
						<table id="datasharingtbl" class="fixTable22 table table-bordered table-condensed table-striped table-hover">
							<thead style="background:#008d4c;color:white;">
								<tr>
									<th rowspan="4"><label>Country</label></th>
									<th rowspan="4"><label>Province</label></th>
									<th rowspan="4"><label>District</label></th>
									<th rowspan="4"><label>Tehsil</label></th>
									<th rowspan="4"><label>UC</label></th>
									<th colspan="8"><label>Vaccinated Women</label></th>
								</tr>
								<tr>
									<th colspan="2"><label>Fixed</label></th>
									<th colspan="2"><label>Outreach</label></th>
									<th colspan="2"><label>Mobile</label></th>
									<th colspan="2"><label>Health House</label></th>
								</tr>
								<tr class="text-center">
									<th>Pregnant Women</th>
									<th>Non-Pregnant</th>
									<th>Pregnant Women</th>
									<th>Non-Pregnant</th>
									<th>Pregnant Women</th>
									<th>Non-Pregnant</th>
									<th>Pregnant Women</th>
									<th>Non-Pregnant</th>
								</tr>
								<tr>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
									<th>Nos.</th>
								</tr>
							</thead>
							<tbody id="sharingdatatblebody" class="default">
								<tr class="text-center">
									<td>
										<input class="countrycode form-control " name="datasharing[countrycode][]" type="text" value="" disabled="disabled">
									</td>
									<td>
										<input class="procode form-control " name="datasharing[procode][]" type="text" value="" disabled="disabled">
									</td>
									<td>
										<input class="district form-control " name="datasharing[distcode][]" type="text" value="" disabled="disabled">
									</td>
									<td>
										<input class="tehsil form-control " name="datasharing[tcode][]" type="text" value="" disabled="disabled">
									</td>
									<td>
										<input class="unioncouncil form-control " name="datasharing[uncode][]" type="text" value="" disabled="disabled">
									</td>
									<?php
										$vaccinatedcells = $fmcells = array("fp","fnp","op","onp","mp","mnp","hp","hnp");
										if($fmcells!==""){
											$vaccinatedcell = "";
											foreach($fmcells as $key=>$value){
												$vaccinatedcell .= '
													<td>
														<input class="form-control numberclass childvacc " name="datasharing[vaccinated]['.$value.'][]" type="text" disabled="disabled">
													</td>';
											}
										}
										echo $vaccinatedcell;
									?>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="row pt10">
						<div class="col-md-6" style="margin-left: 80%;">
							<button class="btn-background box1" type="button" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!---End Data Sharing-->

<script src="https://cdn.jsdelivr.net/npm/alasql@0.6"></script>
<script type="text/javascript">
alasql("CREATE TABLE defaultmodalData (pkid string, htmldata string)");
$(document).ready(function(){
	$(document).on('click','#update',function(){
		var year='<?php echo $year;?>';
		var month='<?php echo $month;?>';
		var facode='<?php echo $facode;?>';
		var fmonth=year+'-'+month;
		window.location.href="<?php echo base_url();?>vaccination/edit/"+fmonth+"/"+facode+"";
	});	
	$(document).on('change','#outchkbox',function(e){
		if($(this).is(":checked")){
			//checked
			$(".outsidecol,.outsidecolTT").removeClass("hide");
			$(".mergedvaccinatedcells").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+42;
				$(this).attr("colspan",newval);
			});
			//for 2 columns hidden class
			$(".hidden2").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+2;
				$(this).attr("colspan",newval);
			});
			//for 4 columns hidden class
			$(".hidden4").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+4;
				$(this).attr("colspan",newval);
			});
			//for 6 columns hidden class
			$(".hidden6").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+6;
				$(this).attr("colspan",newval);
			});
			//for 12 columns hidden class
			$(".hidden12").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+12;
				$(this).attr("colspan",newval);
			});
			//for 14 columns hidden class
			$(".hidden14").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+14;
				$(this).attr("colspan",newval);
			});
			//for TT section
			$(".mergedvaccinatedcellsTT").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+8;
				$(this).attr("colspan",newval);
			});
		}else{
			//unchecked
			//alert($(".outsidecol").addClass("hide"));
			$(".outsidecol,.outsidecolTT").addClass("hide");
			$(".mergedvaccinatedcells").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-42;
				$(this).attr("colspan",newval);
			});
			//for 2 columns hidden class
			$(".hidden2").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-2;
				$(this).attr("colspan",newval);
			});
			//for 4 columns hidden class
			$(".hidden4").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-4;
				$(this).attr("colspan",newval);
			});
			//for 6 columns hidden class
			$(".hidden6").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-6;
				$(this).attr("colspan",newval);
			});
			//for 12 columns hidden class
			$(".hidden12").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-12;
				$(this).attr("colspan",newval);
			});
			//for 14 columns hidden class
			$(".hidden14").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-14;
				$(this).attr("colspan",newval);
			});
			//for TT section
			$(".mergedvaccinatedcellsTT").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-8;
				$(this).attr("colspan",newval);
			});
		}
	});
	$(document).ready(function(){
		$("#outchkbox").trigger("change");
		/* $("#outucchkbox").trigger("change");
		$("#outdistchkbox").trigger("change"); */
	});
	/* $(document).on('click','.sharedata',function(){ 
		var prodid = $(this).closest("tr").data("prodrow");
		var modalobj = $("#DataSharingModal");
		var pkid = "moon";
		if(prodid=="6"){
			modalobj = $("#TTDataSharingModal");
			pkid = "moontt";
		}
		var oldprodname = $(modalobj).find("#ds-productname").text();		
		var oldantigen = $(modalobj).find("#ds-antigen").text();
		var name = $(".cst-item-row[data-prodrow="+prodid+"]").find(".itemname").text();
		var antigen = $(this).closest("tr").find(".vaccnum").text();
		$(modalobj).find("#ds-productname").text(name);
		$(modalobj).find("#ds-antigen").text(antigen);
		$("#clickedrownum").val((parseInt($(this).closest("tr").index()) || 0)+1);		
		if(oldprodname==name && oldantigen==antigen){
			//same row clicked
		}else{
			var clickedrow = $("#clickedrownum").val();
			var rowobj = $(".consumptionitems tr:nth-child("+clickedrow+")");
			var year='<?php echo $year;?>';
			var month='<?php echo $month;?>';
			var facode='<?php echo $facode;?>';
			var fmonth=year+'-'+month;
			if(antigen==''){
				antigen='';
			}else{
				antigen=antigen;
			}
			//check if data exist in db table.
			var defaultval = alasql("SELECT * FROM defaultmodalData WHERE pkid = '"+pkid+"'");
			$.ajax({
				type: "post",
				data: {fmonth:fmonth,facode:facode,antigen:antigen,prodid:prodid},
				url: "<?php echo base_url(); ?>vaccination/CRUD/view_monthly_outuc_coverage",
				success: function(result){
					var resultarray = JSON.parse(result);
					if(resultarray === undefined || resultarray.length == 0){ //alert('a');
						$(modalobj).find("#sharingdatatblebody").html($.parseHTML(defaultval[0].htmldata));
					}else{
						for(var iter = 0; iter<resultarray.length;iter++){
							modalselectedteh=resultarray[iter]["tcode"];
							modalselecteduc=resultarray[iter]["uncode"];
							if(iter==0){ //alert('b');
								$(modalobj).find("#sharingdatatblebody").html($.parseHTML(defaultval[0].htmldata));
							}else{ //alert('c');
								//$(".cloneadd").trigger("click");
								$(modalobj).find("#sharingdatatblebody tr:last").after($.parseHTML(defaultval[0].htmldata));
							}
							//write code to set values 
							if(prodid==6){ 
								var fmcells = ["fp","fnp","op","onp","mp","mnp","hp","hnp"];
								modalobj = $("#TTDataSharingModal");
							}else{
								var fmcells = ["fm1","ff1","om1","of1","mm1","mf1","hm1","hf1","fm2","ff2","om2","of2","mm2","mf2","hm2","hf2","fm3","ff3","om3","of3","mm3","mf3","hm3","hf3"];
							}
							var modalrowobj = $(modalobj).find("#sharingdatatblebody").find("tr:nth-child("+((parseInt(iter) || 0)+1)+")");
							//console.log(resultarray[iter]["distcode"]);
							$(modalrowobj).find('input[name^="datasharing[countrycode]"]').val(resultarray[iter]["countryname"]);
							$(modalrowobj).find('input[name^="datasharing[countrycode]"]').trigger("change");
							
							$(modalrowobj).find('input[name^="datasharing[procode]"]').val(resultarray[iter]["provincename"]);
							$(modalrowobj).find('input[name^="datasharing[procode]"]').trigger("change");
							
							$(modalrowobj).find('input[name^="datasharing[distcode]"]').val(resultarray[iter]["distname"]);
							$(modalrowobj).find('input[name^="datasharing[distcode]"]').trigger("change");
							
							$(modalrowobj).find('input[name^="datasharing[tcode]"]').val(resultarray[iter]["tehsilname"]);
							$(modalrowobj).find('input[name^="datasharing[tcode]"]').trigger("change");
							
							$(modalrowobj).find('input[name^="datasharing[uncode]"]').val(resultarray[iter]["unname"]);
							$.each( fmcells, function( i, val ) {
								var fieldval = resultarray[iter][val];
								$(modalrowobj).find('input[name^="datasharing[vaccinated]['+val+']"]').val(fieldval);
							});
						}
					} 	 
				}
			});
		}
	});	 */
var year='<?php echo $year;?>';
var month='<?php echo $month;?>';
var facode='<?php echo $facode;?>';
var fmonth=year+'-'+month;
$.ajax({
	type: "post",
	data: {fmonth:fmonth,facode:facode},//1 for routine
	url: "<?php echo base_url(); ?>vaccination/CRUD/getDataShareUcList_view",
	success: function(result){
		$("#datasharigbody").find(".defaultrow").remove();
		//code here to append row in table
		$("#datasharigbody").append(result);
	}
});

//starts//
var fullyimmunizedappended = false;
var rowhtml = '<?php echo preg_replace("/\s\s+/", "", $vaccinatedcellhtml ); ?>';
$(".onebatch").each(function(){
	//check if row is disabled for vaccinated record entry
	if($(this).find('.mergedvaccinatedcells').length > 0){}else{
		var prodid = $(this).data("prodrow");
		var prodrowindex = $(this).data("prodrowindex");
		if(prodid==6){
			if(!fullyimmunizedappended){
				$("#sharingdatatblebody").append(rowhtml);
				$("#sharingdatatblebody tr:last-child").attr("data-productid","9999");
				$("#sharingdatatblebody tr:last-child").attr("data-antigen","");
				$("#sharingdatatblebody tr:last-child").attr("data-prodrowindex","0");
				$("#sharingdatatblebody tr:last-child").find(".prodname").html("<label>Fully Immunized</label>");
				$("#sharingdatatblebody tr:last-child").find(".antigennum").text("");
				fullyimmunizedappended = true;
				//TT header
				var ttheaderhtml = '<?php echo preg_replace("/\s\s+/", "", $ttheader ); ?>';
				$("#sharingdatatblebody").append(ttheaderhtml);
			}
			rowhtml = '<?php echo preg_replace("/\s\s+/", "", $ttvaccinatedcellhtml ); ?>';
		}
		var name = $(".cst-item-row[data-prodrow="+prodid+"]").find(".itemname").text();
		var antigen = $(this).find(".vaccnum").text();
		$("#sharingdatatblebody").append(rowhtml);
		$("#sharingdatatblebody tr:last-child").attr("data-productid",prodid);
		$("#sharingdatatblebody tr:last-child").attr("data-antigen",antigen);
		$("#sharingdatatblebody tr:last-child").attr("data-prodrowindex",prodrowindex);
		$("#sharingdatatblebody tr:last-child").find(".prodname").html("<label>"+name+"</label>");
		$("#sharingdatatblebody tr:last-child").find(".antigennum").text(antigen);
	}
});
//End//

$(document).on('click','.view_outucdata',function(){
	var year='<?php echo $year;?>';
	var month='<?php echo $month;?>';
	var facode='<?php echo $facode;?>';
	var fmonth=year+'-'+month;
	var uncode = selectedmodaluncode = $(this).closest("tr").data("uncode");
	var countrycode = selectedmodalcountrycode = $(this).closest("tr").data("countrycode");
	var modalobj = $("#DataSharingModal");
	$.ajax({
		type: "post",
		data: {fmonth:fmonth,facode:facode,countrycode:countrycode,uncode:uncode},
		url: "<?php echo base_url(); ?>vaccination/CRUD/view_monthly_outuc_coverage",
		success: function(result){
			var resultarray = JSON.parse(result);	
			for(var iter = 0; iter<resultarray.length;iter++){
				//write code to set values 
				if(resultarray[iter]["item_id"]==6){ 
					var fmcells = ["fp","fnp","op","onp","mp","mnp","hp","hnp"];
				}else{
					var fmcells = ["fm1","ff1","om1","of1","mm1","mf1","hm1","hf1","fm2","ff2","om2","of2","mm2","mf2","hm2","hf2","fm3","ff3","om3","of3","mm3","mf3","hm3","hf3"];
				}
				var item_id=resultarray[iter]["item_id"];
				if(item_id==2 ||  item_id==19  || item_id==9999){
					var antigen='';
				}else{
					var antigen=resultarray[iter]["antigen"];
				}
				var modalrowobj = $(modalobj).find("#sharingdatatblebody").find('[data-productid='+resultarray[iter]["item_id"]+'][data-antigen="'+antigen+'"]');
				var item_id = resultarray[iter]["item_id"];
				var antigen = resultarray[iter]["antigen"];
				$('input[name^="datasharingcountry"]').val(resultarray[iter]["countryname"]);
				$('input[name^="datasharingcountry"]').trigger("change");
				
				$('input[name^="datasharingprocode"]').val(resultarray[iter]["provincename"]);
				$('input[name^="datasharingprocode"]').trigger("change");
				
				$('input[name^="datasharingdistcode"]').val(resultarray[iter]["distname"]);
				$('input[name^="datasharingdistcode"]').trigger("change");
				
				$('input[name^="datasharingtcode"]').val(resultarray[iter]["tehsilname"]);
				$('input[name^="datasharingtcode"]').trigger("change");
				
				$('input[name^="datasharinguncode"]').val(resultarray[iter]["unname"]);
				$.each( fmcells, function( i, val ) {
					var fieldval = resultarray[iter][val];
					$(modalrowobj).find('input[name^="datasharing[vaccinated]['+val+']"]').val(fieldval);
				});
			}
		}
	});
});
	$(document).on("change","#DataSharingModal .childvacc",function(){
		var distcode = $(this).closest("tr").find(".district").val();
		var tcode = $(this).closest("tr").find(".tehsil").val();
		var uncode = $(this).closest("tr").find(".unioncouncil").val();
		if(parseInt(distcode)>0 && parseInt(tcode)>0 && parseInt(uncode)>0){}else{
			$(this).val(0);
			alert("Please select District, Tehsil and Union Council first.");
		}
	});
	$(document).on("change","#TTDataSharingModal .childvacc",function(){
		var distcode = $(this).closest("tr").find(".district").val();
		var tcode = $(this).closest("tr").find(".tehsil").val();
		var uncode = $(this).closest("tr").find(".unioncouncil").val();
		if(parseInt(distcode)>0 && parseInt(tcode)>0 && parseInt(uncode)>0){}else{
			$(this).val(0);
			alert("Please select District, Tehsil and Union Council first.");
		}
	});
	$(document).on('click','.cloneadd',function(){
		var clonedhtml = $(this).closest("tr").clone();
		$(clonedhtml).find("td:last-child").html('<button type="button" class="btn btn-danger btn-xs clonedel" data-original-title="Delete this Batch"><i class="fa fa-minus"></i></button>');
		$(this).closest("tr").after(clonedhtml);
	});
	$(document).on('click','.clonedel',function(){
		var confirmdel = confirm("This will delete current row, Do you really want to remove it?");
		if(confirmdel){
			$(this).closest("tr").remove();
		}
	});
});
$(document).on('change','.countrycode', function(){
	var countrycode = $(this).val();
	var obj = $(this);
	if(countrycode==92){ 
		$.ajax({ 
			type: 'POST',
			async: false,
			data: '',
			url: '<?php echo base_url();?>Ajax_red_rec/getProvinces_options',
			success: function(data){
				obj.closest('tr').find('.procode').html(data);
				obj.closest('tr').find('.procode').trigger('change');
			}
		});
	}else{   
		obj.closest('tr').find('.procode').html('');
		obj.closest('tr').find('.district').html('');
		obj.closest('tr').find('.tehsil').html('');
		obj.closest('tr').find('.unioncouncil').html('');
	}
	
});
$(document).on('change','.procode', function(){
	var obj = $(this);
	var procode = $(this).val();
	if($(this).closest('tr').find(".district").length == 0) {
	  //it doesn't exist
	}else{
		$.ajax({
			type: "POST",
			async: false,
			data: "procode="+procode,
			url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
			success: function(result){
				obj.closest('tr').find('.district').html(result);
				obj.closest('tr').find('.district').trigger('change');
			}
		});
	}
});
$(document).on('change','.district', function(){
	var obj = $(this);
	var distcode = $(this).val();
	//to get tehsils of selected distcrict
	if($(this).closest('tr').find(".tehsil").length == 0) {
	  //it doesn't exist
	}else{
		$.ajax({
			type: "POST",
			async: false,
			data: "distcode="+distcode,
			url: "<?php echo base_url("Ajax_calls/getTehsils"); ?>",
			success: function(result){
				obj.closest('tr').find('.tehsil').html(result);
				obj.closest('tr').find('.tehsil').trigger('change');
			}
		});
	}
						
});	

$(document).on('change','.tehsil', function(){
	var obj = $(this);
	var tcode = $(this).val();
	//to get unioncouncis of selected tehsil
	if($(this).closest('tr').find(".unioncouncil").length == 0) {
	  //it doesn't exist
	}else{
		$.ajax({
			type: "POST",
			async: false,
			url: '<?php echo base_url("Ajax_calls/getUnC/'+tcode+'"); ?>', //"http://epibeta.pacemis.com/Ajax_calls/getTehsils",
			success: function(result){
				obj.closest('tr').find('.unioncouncil').html(result);
			}
		});
	}
						
});
function resetstyle(reff){
	reff.style.paddingRight = "unset";
}
$.fn.deserialize = function (serializedString) 
{
    var $form = $(this);
    $form[0].reset();
    serializedString = serializedString.replace(/\+/g, '%20');
    var formFieldArray = serializedString.split("&");
    $.each(formFieldArray, function(i, pair){
        var nameValue = pair.split("=");
        var name = decodeURIComponent(nameValue[0]);
        var value = decodeURIComponent(nameValue[1]);
        // Find one or more fields
        var $field = $form.find('[name="' + name + '"]');
        console.log(name, value);
        $field.val(value);
    });
}
//var modaldefaulthtml = $("#DataSharingModal").find("#sharingdatatblebody").html();
//var ttmodaldefaulthtml = $("#TTDataSharingModal").find("#sharingdatatblebody").html();
//alasql("INSERT INTO defaultmodalData VALUES ('moon','"+modaldefaulthtml+"'),('moontt','"+ttmodaldefaulthtml+"')");
var modaldefaulthtml = $("#DataSharingModal").find("#sharingdatatblebody").html();
alasql("INSERT INTO defaultmodalData VALUES ('moon','"+modaldefaulthtml+"')");
</script>