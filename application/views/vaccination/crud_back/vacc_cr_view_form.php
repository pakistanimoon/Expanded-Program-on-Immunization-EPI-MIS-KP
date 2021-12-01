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
								<th colspan="72" class="mergedvaccinatedcells"><label>Vaccinated</label></th>
								<th rowspan="6" style="width:7%;"><label>Batch number</label></th>
								<th rowspan="6" style="width:1%;"><label>Doses Per Vial</label></th>
								<th rowspan="5"><label>Opening Balance</label></th>
								<th rowspan="5"><label>Received</label></th>
								<th colspan="2" rowspan="5"><label>Used</label></th>
								<th colspan="2" rowspan="5"><label>Unusable</label></th>
								<!--<th colspan="3" rowspan="5"><label>Adjustment</label></th>-->
								<th colspan="2" rowspan="5"><label>Closing Balance</label></th>
							</tr>
							<tr>
								<th colspan="24" class="hidden14"><label>Number of Children Vaccinated (0-11 months)</label></th>
								<th colspan="24" class="hidden14"><label>Number of Children Vaccinated (12-23 months)</label></th>
								<th colspan="24" class="hidden14"><label>02 Years and above</label></th>
							</tr>
							<tr>
								<th colspan="6" class="hidden2"><label>Fixed</label></th>
								<th colspan="6" class="hidden4"><label>Outreach</label></th>
								<th colspan="6" class="hidden4"><label>Mobile</label></th>
								<th colspan="6" class="hidden4"><label>Health House</label></th>
								<th colspan="6" class="hidden2"><label>Fixed</label></th>
								<th colspan="6" class="hidden4"><label>Outreach</label></th>
								<th colspan="6" class="hidden4"><label>Mobile</label></th>
								<th colspan="6" class="hidden4"><label>Health House</label></th>
								<th colspan="6" class="hidden2"><label>Fixed</label></th>
								<th colspan="6" class="hidden4"><label>Outreach</label></th>
								<th colspan="6" class="hidden4"><label>Mobile</label></th>
								<th colspan="6" class="hidden4"><label>Health House</label></th>
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
								<th  style="color: White;" colspan="72" class="mergedvaccinatedcells">D</th>
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
							$previtemname = $finaloutput = $lastrow = $batches = $dosespervial = $openingdoses = $receiveddoses =$usedvials = $useddoses = $unusedvials = $unuseddoses = $closingvials = $closingdoses = "";
							$vaccinated = array();
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
											$childvaccinatedcell = getVaccinatedCells($singleVacc,$vaccinated,$repeat);
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
							$fullyimmunized .= '
								<tr class="cst-item-row" data-prodrow="9999">
									<td style="padding-left: 10px; padding-right: 10px; background-color: whitesmoke; position: relative; left: 0px;" class="itemname" data-moon="temp"><label>Fully Immunized</label></td>
									<td class="text-center vaccnum" background-color:#eee;"="" style="background-color: whitesmoke; position: relative; left: 0px;"></td>
									<td class="">
										'.(isset($vaccinated["vaccinated"][17][0]["iufm1"])?$vaccinated["vaccinated"][17][0]["iufm1"]:0).'
									</td>
									<td class="">
										'.(isset($vaccinated["vaccinated"][17][0]["iuff1"])?$vaccinated["vaccinated"][17][0]["iuff1"]:0).'
									</td>
									<td class="">
										'.(isset($vaccinated["vaccinated"][17][0]["iufm2"])?$vaccinated["vaccinated"][17][0]["iufm2"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuff2"])?$vaccinated["vaccinated"][17][0]["iuff2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iufm3"])?$vaccinated["vaccinated"][17][0]["iufm3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuff3"])?$vaccinated["vaccinated"][17][0]["iuff3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuom1"])?$vaccinated["vaccinated"][17][0]["iuom1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuof1"])?$vaccinated["vaccinated"][17][0]["iuof1"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuom2"])?$vaccinated["vaccinated"][17][0]["iuom2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuof2"])?$vaccinated["vaccinated"][17][0]["iuof2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuom3"])?$vaccinated["vaccinated"][17][0]["iuom3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuof3"])?$vaccinated["vaccinated"][17][0]["iuof3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["iumm1"])?$vaccinated["vaccinated"][17][0]["iumm1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["iumf1"])?$vaccinated["vaccinated"][17][0]["iumf1"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iumm2"])?$vaccinated["vaccinated"][17][0]["iumm2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iumf2"])?$vaccinated["vaccinated"][17][0]["iumf2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iumm3"])?$vaccinated["vaccinated"][17][0]["iumm3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iumf3"])?$vaccinated["vaccinated"][17][0]["iumf3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuhm1"])?$vaccinated["vaccinated"][17][0]["iuhm1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuhf1"])?$vaccinated["vaccinated"][17][0]["iuhf1"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuhm2"])?$vaccinated["vaccinated"][17][0]["iuhm2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuhf2"])?$vaccinated["vaccinated"][17][0]["iuhf2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuhm3"])?$vaccinated["vaccinated"][17][0]["iuhm3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["iuhf3"])?$vaccinated["vaccinated"][17][0]["iuhf3"]:0).'
									</td>
									<td class=" " >
										'.(isset($vaccinated["vaccinated"][17][0]["oufm1"])?$vaccinated["vaccinated"][17][0]["oufm1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouff1"])?$vaccinated["vaccinated"][17][0]["ouff1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["oufm2"])?$vaccinated["vaccinated"][17][0]["oufm2"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouff2"])?$vaccinated["vaccinated"][17][0]["ouff2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["oufm3"])?$vaccinated["vaccinated"][17][0]["oufm3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouff3"])?$vaccinated["vaccinated"][17][0]["ouff3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouom1"])?$vaccinated["vaccinated"][17][0]["ouom1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouof1"])?$vaccinated["vaccinated"][17][0]["ouof1"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouom2"])?$vaccinated["vaccinated"][17][0]["ouom2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouof2"])?$vaccinated["vaccinated"][17][0]["ouof2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouom3"])?$vaccinated["vaccinated"][17][0]["ouom3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouof3"])?$vaccinated["vaccinated"][17][0]["ouof3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["oumm1"])?$vaccinated["vaccinated"][17][0]["oumm1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["oumf1"])?$vaccinated["vaccinated"][17][0]["oumf1"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["oumm2"])?$vaccinated["vaccinated"][17][0]["oumm2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["oumf2"])?$vaccinated["vaccinated"][17][0]["oumf2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["oumm3"])?$vaccinated["vaccinated"][17][0]["oumm3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["oumf3"])?$vaccinated["vaccinated"][17][0]["oumf3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouhm1"])?$vaccinated["vaccinated"][17][0]["ouhm1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouhf1"])?$vaccinated["vaccinated"][17][0]["ouhf1"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouhm2"])?$vaccinated["vaccinated"][17][0]["ouhm2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouhf2"])?$vaccinated["vaccinated"][17][0]["ouhf2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouhm3"])?$vaccinated["vaccinated"][17][0]["ouhm3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["ouhf3"])?$vaccinated["vaccinated"][17][0]["ouhf3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odfm1"])?$vaccinated["vaccinated"][17][0]["odfm1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odff1"])?$vaccinated["vaccinated"][17][0]["odff1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odfm2"])?$vaccinated["vaccinated"][17][0]["odfm2"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odff2"])?$vaccinated["vaccinated"][17][0]["odff2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odfm3"])?$vaccinated["vaccinated"][17][0]["odfm3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odff3"])?$vaccinated["vaccinated"][17][0]["odff3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odom1"])?$vaccinated["vaccinated"][17][0]["odom1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odof1"])?$vaccinated["vaccinated"][17][0]["odof1"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odom2"])?$vaccinated["vaccinated"][17][0]["odom2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odof2"])?$vaccinated["vaccinated"][17][0]["odof2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odom3"])?$vaccinated["vaccinated"][17][0]["odom3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odof3"])?$vaccinated["vaccinated"][17][0]["odof3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odmm1"])?$vaccinated["vaccinated"][17][0]["odmm1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odmf1"])?$vaccinated["vaccinated"][17][0]["odmf1"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odmm2"])?$vaccinated["vaccinated"][17][0]["odmm2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odmf2"])?$vaccinated["vaccinated"][17][0]["odmf2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odmm3"])?$vaccinated["vaccinated"][17][0]["odmm3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odmf3"])?$vaccinated["vaccinated"][17][0]["odmf3"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odhm1"])?$vaccinated["vaccinated"][17][0]["odhm1"]:0).'
									</td>
									<td class=" ">
										'.(isset($vaccinated["vaccinated"][17][0]["odhf1"])?$vaccinated["vaccinated"][17][0]["odhf1"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odhm2"])?$vaccinated["vaccinated"][17][0]["odhm2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odhf2"])?$vaccinated["vaccinated"][17][0]["odhf2"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odhm3"])?$vaccinated["vaccinated"][17][0]["odhm3"]:0).'
									</td>
									<td class="outsidecol ">
										'.(isset($vaccinated["vaccinated"][17][0]["odhf3"])?$vaccinated["vaccinated"][17][0]["odhf3"]:0).'
									</td>
									<td class="prodbatch" colspan="10"></td>
								</tr>';
							$finaloutput .= $fullyimmunized;
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

							function getVaccinatedCells($singleVacc,$vaccinated,$rownum){
								$item_id = $singleVacc["item_id"];
								$item_category_id = $singleVacc["item_category_id"];
								$childvaccinatedcell = '';
								$vaccinatedcells = array("iufm1","iuff1","oufm1","ouff1","odfm1","odff1","iuom1","iuof1","ouom1","ouof1","odom1","odof1","iumm1","iumf1","oumm1","oumf1","odmm1","odmf1","iuhm1","iuhf1","ouhm1","ouhf1","odhm1","odhf1","iufm2","iuff2","oufm2","ouff2","odfm2","odff2","iuom2","iuof2","ouom2","ouof2","odom2","odof2","iumm2","iumf2","oumm2","oumf2","odmm2","odmf2","iuhm2","iuhf2","ouhm2","ouhf2","odhm2","odhf2","iufm3","iuff3","oufm3","ouff3","odfm3","odff3","iuom3","iuof3","ouom3","ouof3","odom3","odof3","iumm3","iumf3","oumm3","oumf3","odmm3","odmf3","iuhm3","iuhf3","ouhm3","ouhf3","odhm3","odhf3");
								foreach($vaccinatedcells as $moonind=>$value){
									if(isset($vaccinated["vaccinated"][$item_id][$rownum][$value])){
										$vaccinatedval = $vaccinated["vaccinated"][$item_id][$rownum][$value];
									}else{
										$vaccinatedval = 0;
									}
									$sectionclass = "";
									$localmoonind = $moonind;
									if($moonind<24){
										//$sectionclass = "insideuc";
									}elseif($moonind<48){
										//$sectionclass = "outsideuc";
										$localmoonind = $moonind-24;
									}else{
										$localmoonind = $moonind-48;
									}
									if(in_array($localmoonind,array_merge(range(4,5),range(8,11),range(14,17),range(20,23)))){
										$sectionclass = "outsidecol";
									}	
									// 
									$childvaccinatedcell .= '
										<td class="'.$sectionclass.' '.(($item_category_id!=1)?'mergedvaccinatedcells':'').'" '.(($item_category_id!=1)?'colspan = "72"':'').'>
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
<script type="text/javascript">
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
});
</script>