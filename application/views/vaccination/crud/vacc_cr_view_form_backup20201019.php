<?php 
date_default_timezone_set('Asia/Karachi');
$current_date = date('d-m-Y');
if(isset($formB_Result)){ 
	$year=substr($formB_Result->fmonth,0,4);
	$month=substr($formB_Result->fmonth,5,7);
	$facode=$formB_Result->facode;
}
//$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true,array("nature"=>"nature")):false;
?>
<!--start of page content or body-->
<div class="container bodycontainer">  
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">Health Facility Monthly Vaccination & Consumption</div>
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
				<div id="parent" style="overflow:auto;">
					<div class="pull-right">
						<input type="checkbox" id="outucchkbox">Outside UC
						<input type="checkbox" id="outdistchkbox">Outside District
					</div>
					<table class="table table-bordered table-condensed table-striped table-hover mytable3">
						<thead>
							<tr>
								<th rowspan="6" style="width:14%;"><label>Product</label></th>
								<th rowspan="6" style="width:7%;"><label>Batch number</label></th>
								<th rowspan="6" style="width:1%;"><label>Doses Per Vial</label></th>
								<th rowspan="5"><label>Opening Balance</label></th>
								<th rowspan="5"><label>Received</label></th>
								<th rowspan="6"><label>#</label></th>
								<th colspan="72" class="mergedvaccinatedcells"><label>Vaccinated</label></th>
								<th colspan="2" rowspan="5"><label>Used</label></th>
								<th colspan="2" rowspan="5"><label>Unusable</label></th>
								<th colspan="2" rowspan="5"><label>Closing Balance</label></th>
							</tr>
							<tr>
								<th colspan="24"><label>Inside UC</label></th>
								<th colspan="24" class="outsideuc"><label>Outside UC</label></th>
								<th colspan="24" class="outsidedist"><label>Out District</label></th>
							</tr>
							<tr>
								<th colspan="6"><label>Fixed</label></th>
								<th colspan="6"><label>Outreach</label></th>
								<th colspan="6"><label>Mobile</label></th>
								<th colspan="6"><label>Health House</label></th>
								<th colspan="6" class="outsideuc"><label>Fixed</label></th>
								<th colspan="6" class="outsideuc"><label>Outreach</label></th>
								<th colspan="6" class="outsideuc"><label>Mobile</label></th>
								<th colspan="6" class="outsideuc"><label>Health House</label></th>
								<th colspan="6" class="outsidedist"><label>Fixed</label></th>
								<th colspan="6" class="outsidedist"><label>Outreach</label></th>
								<th colspan="6" class="outsidedist"><label>Mobile</label></th>
								<th colspan="6" class="outsidedist"><label>Health House</label></th>
							</tr>
							<tr class="text-center">
								<td colspan="2">0-11</td>
								<td colspan="2">12-23</td>
								<td colspan="2">>23</td>
								<td colspan="2">0-11</td>
								<td colspan="2">12-23</td>
								<td colspan="2">>23</td>
								<td colspan="2">0-11</td>
								<td colspan="2">12-23</td>
								<td colspan="2">>23</td>
								<td colspan="2">0-11</td>
								<td colspan="2">12-23</td>
								<td colspan="2">>23</td>
								<td colspan="2" class="outsideuc">0-11</td>
								<td colspan="2" class="outsideuc">12-23</td>
								<td colspan="2" class="outsideuc">>23</td>
								<td colspan="2" class="outsideuc">0-11</td>
								<td colspan="2" class="outsideuc">12-23</td>
								<td colspan="2" class="outsideuc">>23</td>
								<td colspan="2" class="outsideuc">0-11</td>
								<td colspan="2" class="outsideuc">12-23</td>
								<td colspan="2" class="outsideuc">>23</td>
								<td colspan="2" class="outsideuc">0-11</td>
								<td colspan="2" class="outsideuc">12-23</td>
								<td colspan="2" class="outsideuc">>23</td>
								<td colspan="2" class="outsidedist">0-11</td>
								<td colspan="2" class="outsidedist">12-23</td>
								<td colspan="2" class="outsidedist">>23</td>
								<td colspan="2" class="outsidedist">0-11</td>
								<td colspan="2" class="outsidedist">12-23</td>
								<td colspan="2" class="outsidedist">>23</td>
								<td colspan="2" class="outsidedist">0-11</td>
								<td colspan="2" class="outsidedist">12-23</td>
								<td colspan="2" class="outsidedist">>23</td>
								<td colspan="2" class="outsidedist">0-11</td>
								<td colspan="2" class="outsidedist">12-23</td>
								<td colspan="2" class="outsidedist">>23</td>
							</tr>
							<tr class="text-center">
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td>M</td>
								<td>F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsideuc">M</td>
								<td class="outsideuc">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
								<td class="outsidedist">M</td>
								<td class="outsidedist">F</td>
							</tr>
							<tr>
								<th>Doses</th>
								<th>Doses</th>
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
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsideuc">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th class="outsidedist">Nos.</th>
								<th>Vials</th>
								<th>Doses</th>
								<th>Vials</th>
								<th>Doses</th>
								<th>Vials</th>
								<th>Doses</th>
							</tr>
							<tr style="background: white none repeat scroll 0% 0%; color: black;">
								<th></th>
								<th></th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th></th>
								<th colspan="72" class="mergedvaccinatedcells">D</th>
								<th colspan="2">E</th>
								<th colspan="2">F</th>
								<th colspan="2">G</th>
							</tr>
						</thead>
						<tbody id="myTable" class="consumptionitems default"><?php 
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
									$usedvials .= '<br>'.$singleVacc["used_vials"];
									$useddoses .= '<br>'.$singleVacc["used_doses"];
									$unusedvials .= '<br>'.$singleVacc["unused_vials"];
									$unuseddoses .= '<br>'.$singleVacc["unused_doses"];
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
									$usedvials = '<!--Used Vials-->
												 '.(($singleVacc["used_vials"])?$singleVacc["used_vials"]:'').' ';
									$useddoses = '<!--Used Doses-->
												'.(($singleVacc["used_doses"])?$singleVacc["used_doses"]:'').' ';
									$unusedvials = '<!--Unused Vials-->
												'.(($singleVacc["unused_vials"])?$singleVacc["unused_vials"]:'').' ';
									$unuseddoses = '<!--Unused Doses-->
												'.(($singleVacc["unused_doses"])?$singleVacc["unused_doses"]:'').' ';
									$closingvials = '<!--Closing Vials-->
												'.$singleVacc["closing_vials"].' ';
									$closingdoses = '<!--Closing Doses-->
												'.$singleVacc["closing_doses"].' ';
									//add new column for item name
									$prevrowspan = 1*$vaccnum;
									$itemnamecell = '<td style="'.$leftpadding.$rightpadding.'" class="itemname" data-moon="temp" rowspan="'.$prevrowspan.'"><label>'.$moonitemname.'</label>
									</td>';
									if($singleVacc["item_id"] == "6"){
										$lastrow .= '
										<tr class="" style="background:#008d4c;color:white;">
											<td colspan="6"></td>
											<td colspan="3" class="text-center"><label>Pregnant Women</label></label></td>
											<td colspan="3" class="text-center"><label>Non-Pregnant</label></td>
											<td colspan="3" class="text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="text-center"><label>Non-Pregnant</label></td>
											<td colspan="3" class="text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="text-center"><label>Non-Pregnant</label></td>
											<td colspan="3" class="text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="text-center"><label>Non-Pregnant</label></td>
											
											<td colspan="3" class="outsideuc text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="outsideuc text-center"><label>Non-Pregnant</label></td>
											<td colspan="3" class="outsideuc text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="outsideuc text-center"><label>Non-Pregnant</label></td>
											<td colspan="3" class="outsideuc text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="outsideuc text-center"><label>Non-Pregnant</label></td>
											<td colspan="3" class="outsideuc text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="outsideuc text-center"><label>Non-Pregnant</label></td>
											
											<td colspan="3" class="outsidedist text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="outsidedist text-center"><label>Non-Pregnant</label></td>
											<td colspan="3" class="outsidedist text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="outsidedist text-center"><label>Non-Pregnant</label></td>
											<td colspan="3" class="outsidedist text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="outsidedist text-center"><label>Non-Pregnant</label></td>
											<td colspan="3" class="outsidedist text-center"><label>Pregnant Women</label></td>
											<td colspan="3" class="outsidedist text-center"><label>Non-Pregnant</label></td>
											<td colspan="6"></td>
										</tr>';
										$ttSec = True;
									}else{
										$ttSec = False;
									}
									for($repeat = 0;$repeat<$vaccnum;$repeat++ ){
										if($repeat==0){
											$initial = 
												$itemnamecell.'
												<td style="'.$toppadding.'" class="prodbatch" rowspan="'.$vaccnum.'">{batcheshere}</td>
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
											$initial = '';
											$last = '';
										}
										if($ttSec){
											$childvaccinatedcell = getVaccinatedCellsTT($singleVacc,$vaccinated,$repeat);			
										}else{
											$childvaccinatedcell = getVaccinatedCells($singleVacc,$vaccinated,$repeat);
										}
										$childvaccinatedcellsrow = str_replace('moonrownum', $repeat, $childvaccinatedcell);
										$lastrow .= '
											<tr class="onebatch">
												'.$initial.
												'<!--Children Vaccinated-->
												<td class="text-center vaccnum" '.$disabledstyle.'">'.(($vaccnum>1)?$repeat+1:'').'</td>'.$childvaccinatedcellsrow.$last.'
											</tr>';
									}
								}
								$previtemname = $moonitemname;
							}
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
								$vaccinatedcells = array("iufm1","iuff1","iufm2","iuff2","iufm3","iuff3","iuom1","iuof1","iuom2","iuof2","iuom3","iuof3","iumm1","iumf1","iumm2","iumf2","iumm3","iumf3","iuhm1","iuhf1","iuhm2","iuhf2","iuhm3","iuhf3","oufm1","ouff1","oufm2","ouff2","oufm3","ouff3","ouom1","ouof1","ouom2","ouof2","ouom3","ouof3","oumm1","oumf1","oumm2","oumf2","oumm3","oumf3","ouhm1","ouhf1","ouhm2","ouhf2","ouhm3","ouhf3","odfm1","odff1","odfm2","odff2","odfm3","odff3","odom1","odof1","odom2","odof2","odom3","odof3","odmm1","odmf1","odmm2","odmf2","odmm3","odmf3","odhm1","odhf1","odhm2","odhf2","odhm3","odhf3");
								foreach($vaccinatedcells as $moonind=>$value){
									if(isset($vaccinated["vaccinated"][$item_id][$rownum][$value])){
										$vaccinatedval = $vaccinated["vaccinated"][$item_id][$rownum][$value];
									}else{
										$vaccinatedval = 0;
									}
									$sectionclass = "";
									if($moonind<24){
										$sectionclass = "insideuc";
									}elseif($moonind<48){
										$sectionclass = "outsideuc";
									}else{
										$sectionclass = "outsidedist";
									}
									// 
									$childvaccinatedcell .= '
										<td class="'.$sectionclass.' '.(($item_category_id!=1)?'mergedvaccinatedcells':'').'" '.(($item_category_id!=1)?'colspan = "24"':'').'>
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
								$vaccinatedcells = array("iufp","iufnp","iuop","iuonp","iump","iumnp","iuhp","iuhnp","oufp","oufnp","ouop","ouonp","oump","oumnp","ouhp","ouhnp","odfp","odfnp","odop","odonp","odmp","odmnp","odhp","odhnp");
								foreach($vaccinatedcells as $moonind=>$value){
									if(isset($vaccinated["vaccinated"][$item_id][$rownum][$value])){
										$vaccinatedval = $vaccinated["vaccinated"][$item_id][$rownum][$value];
									}else{
										$vaccinatedval = 0;
									}
									$sectionclass = "";
									if($moonind<8){
										$sectionclass = "insideuc";
									}elseif($moonind<16){
										$sectionclass = "outsideuc";
									}else{
										$sectionclass = "outsidedist";
									}
									$childvaccinatedcell .= '
										<td class="'.$sectionclass.' '.(($item_category_id!=1)?'mergedvaccinatedcells':'').'" '.(($item_category_id!=1)?'colspan = "24"':'colspan = "3"').'>
											'.($vaccinatedval).'
										</td>';
									if($item_category_id!=1){break;}
								}
								return $childvaccinatedcell;
							}
							?>
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
				<!--<div class="row">      
					<div style="text-align: right;" class="col-md-12">
						<span style="color:red" class="pull-left"><b>Note: </b>Only those products/batches are showing in above table which have atleast 1 vials/dose/pieces available in stock for respective HF in selected month.</span>
					</div>
				</div>-->
				<div class="row">
					<hr>
					<div style="text-align: right;" class="col-md-12 col-sm-12 col-xs-12">
						<!--<span style="color:red;padding-top:8px;" class="pull-left"><input type="checkbox" id="accepted" value="1"> I confirm that data entered against each product is correct and I want to submit report.</span>
						<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" disabled="disabled" id="savebtn"><i class="fa fa-floppy-o "></i> Save </button>
						<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset"><i class="fa fa-repeat"></i> Reset </button>-->
						<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;"  class="btn btn-primary btn-md" id="update"><i class="fa fa-floppy-o "></i> Update </button>
						<a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel</a>
					</div>
				</div>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<!--<div class="modal fade" id="AddAdjustmentModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-adjustment">Add Adjustment</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-3">
							<label>Product</label>
						</div>
						<div class="col-md-3">
							<span id="productmodal"></span>
						</div>
						<div class="col-md-3">
							<label>Batch</label>
						</div>
						<div class="col-md-3">
							<span id="batchmodal"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Doses Per Vial</label>
						</div>
						<div class="col-md-3">
							<span id="productmodaldoses"></span>
						</div>
						<div class="col-md-3">
							<label id="availablequantitytitle">Balance (Doses)</label>
						</div>
						<div class="col-md-3">
							<span id="availablequantitymodal"></span>
						</div>
					</div>
					<label>Adjustment Type <span style="color:red">*</span></label>
					<select name="adjustmenttype" id="adjustmenttype" required="required" class="form-control">
						<option value=""> Select </option>
						<option value="5" data-nature="0">Lost</option>
						<option value="6" data-nature="1">Lost Recovered</option>
						<option value="9" data-nature="1">Physically Found</option>
						<option value="11" data-nature="0">Physically Not Found</option>
						<option value="3" data-nature="0">Theft</option>
					</select>
					<label id="quantitytitle"> Quantity to Adjust (Doses)<span style="color:red">*</span></label>
					<input class="form-control numberclass" name="quantitymodal" id="quantitymodal" required="required" type="text">
					<label>Comments<span style="color:red">*</span></label>
					<textarea class="form-control" id="comments" name="comments" required="required"></textarea>
					<div class="row pt10">
						<div class="col-md-6" style="margin-left: 65%;">
							<button id="submitAdjustment" class="btn-background box1" type="button" data-dismiss="modal"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
							<button id="cancelmodal" class="btn-background box1" type="button" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							<input type="hidden" id="rownum" name="rownum" value="" />
						</div>
					</div>
				</div>
			</div>
	</div>
</div>-->
<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click','#update',function(){
		var year='<?php echo $year;?>';
		var month='<?php echo $month;?>';
		var facode='<?php echo $facode;?>';
		var fmonth=year+'-'+month;
		window.location.href="<?php echo base_url();?>vaccination/edit/"+fmonth+"/"+facode+"";
	});	
	//for sho
	$(document).on('change','#outucchkbox',function(e){
		if($(this).is(":checked")){
			//checked
			$(".outsideuc,.outsideucTT").show();
			$(".mergedvaccinatedcells").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+24;
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
			$(".outsideuc,.outsideucTT").hide();
			$(".mergedvaccinatedcells").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-24;
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
	$(document).on('change','#outdistchkbox',function(e){
		if($(this).is(":checked")){
			//checked
			$(".outsidedist,.outsidedistTT").show();
			$(".mergedvaccinatedcells").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val+24;
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
			$(".outsidedist,.outsidedistTT").hide();
			$(".mergedvaccinatedcells").each(function(){
				//hide outside section
				var val = parseInt($(this).attr("colspan"));
				var newval = val-24;
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
		$("#outucchkbox").trigger("change");
		$("#outdistchkbox").trigger("change");
		//uncheck "outside uc" & "outside district" options first
		$(".mergedvaccinatedcells").each(function(){
			$(this).attr("colspan",24);
		});
	});
});

</script>
