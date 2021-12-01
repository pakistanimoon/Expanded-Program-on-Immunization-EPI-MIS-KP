<?php 
$disabledstyle = 'background-color:#eee;';
$toppadding = 'padding-top:11px;';
$leftpadding = 'padding-left:10px;';
$rightpadding = 'padding-right:10px;';
$previtemname = $finaloutput = $lastrow = $batches = $dosespervial = $openingdoses = $receiveddoses =$usedvials = $useddoses = $unusedvials = $unuseddoses = $closingvials = $closingdoses = "";
foreach($cr_items as $key=>$singleVacc){
	$keyparts 		= explode("moon",$key);
	$batch 			= isset($keyparts[1])?$keyparts[1]:'BB2019';
	$dosepervial 	= (isset($keyparts[2]) && $keyparts[2]>1)?$keyparts[2]:'';	
	$moonitemname = ($singleVacc["item_category_id"]!=1)?trim($singleVacc["item_name"]):trim($singleVacc["itemname"]);
	$vaccnum = (isset($singleVacc["multiplier"]) && isset($singleVacc["item_category_id"]) && $singleVacc["item_category_id"]==1)?$singleVacc["multiplier"]:1;
	if($previtemname == $moonitemname){
		$itemnamecell = $childvaccinatedcell = '';
		$batches .= '<br>'.'<label class="form-control" disabled="disabled">'.$batch.'</label>';
		$dosespervial .= '<br>'.'<label class="form-control" disabled="disabled">'.$dosepervial.'</label>';
		$openingdoses .= '<br>'.'<label class="form-control" disabled="disabled">'.$singleVacc["opening"].'</label>';
		$receiveddoses .= '<br>'.'<label class="form-control" disabled="disabled">'.$singleVacc["recdoses"].'</label>';
		$usedvials .= '<br>'.'<input class="form-control numberclass usedinv" name="product['.$singleVacc["itemid"].']['.$batch.'][usedvials]" type="text" '.(($singleVacc["in_doses"])?'disabled="disabled"':'').'>';
		$useddoses .= '<br>'.'<input class="form-control numberclass usedind" name="product['.$singleVacc["itemid"].']['.$batch.'][useddoses]" type="text" '.(($singleVacc["in_doses"])?'':'disabled="disabled"').'>';
		$unusedvials .= '<br>'.'<input class="form-control numberclass unusedinv" name="product['.$singleVacc["itemid"].']['.$batch.'][unusedvials]" type="text" '.(($singleVacc["in_doses"])?'disabled="disabled"':'').'>';
		$unuseddoses .= '<br>'.'<input class="form-control numberclass unusedind" name="product['.$singleVacc["itemid"].']['.$batch.'][unuseddoses]" type="text" '.(($singleVacc["in_doses"])?'':'disabled="disabled"').'>';
		$closingvials .= '<br>'.'<input class="form-control numberclass closinginv" name="product['.$singleVacc["itemid"].']['.$batch.'][closingvials]" type="text" disabled="disabled">';
		$closingdoses .= '<br>'.'<input class="form-control numberclass closingind" name="product['.$singleVacc["itemid"].']['.$batch.'][closingdoses]" type="text" disabled="disabled">
						<input class="form-control" name="product['.$singleVacc["itemid"].']['.$batch.'][batch]" value="'.$batch.'" type="hidden" >
						<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][doses]" value="'.(($dosepervial>0)?$dosepervial:1).'" type="hidden" >
						<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][ob]" value="'.$singleVacc["opening"].'" type="hidden" >
						<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][received]" value="'.$singleVacc["recdoses"].'" type="hidden" >
						<input class="form-control numberclass adjustnature" name="product['.$singleVacc["itemid"].']['.$batch.'][adjustnature]" value="" type="hidden" >
						<input class="form-control numberclass adjusttype" name="product['.$singleVacc["itemid"].']['.$batch.'][adjusttype]" value="" type="hidden" >
						<input class="form-control numberclass adjustcomments" name="product['.$singleVacc["itemid"].']['.$batch.'][adjustcomments]" value="" type="hidden" >';
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
		$batches = '<label class="form-control" disabled="disabled">'.$batch.'</label>';
		$dosespervial = '<label class="form-control" disabled="disabled">'.$dosepervial.'</label>';
		$openingdoses = '<label class="form-control" disabled="disabled">'.$singleVacc["opening"].'</label>';
		$receiveddoses = '<label class="form-control" disabled="disabled">'.$singleVacc["recdoses"].'</label>';
		$usedvials = '<!--Used Vials-->
					<input class="form-control numberclass usedinv" name="product['.$singleVacc["itemid"].']['.$batch.'][usedvials]" type="text" '.(($singleVacc["in_doses"])?'disabled="disabled"':'').'>';
		$useddoses = '<!--Used Doses-->
					<input class="form-control numberclass usedind" name="product['.$singleVacc["itemid"].']['.$batch.'][useddoses]" type="text" '.(($singleVacc["in_doses"])?'':'disabled="disabled"').'>';
		$unusedvials = '<!--Unused Vials-->
					<input class="form-control numberclass unusedinv" name="product['.$singleVacc["itemid"].']['.$batch.'][unusedvials]" type="text" '.(($singleVacc["in_doses"])?'disabled="disabled"':'').'>';
		$unuseddoses = '<!--Unused Doses-->
					<input class="form-control numberclass unusedind" name="product['.$singleVacc["itemid"].']['.$batch.'][unuseddoses]" type="text" '.(($singleVacc["in_doses"])?'':'disabled="disabled"').'>';
		$closingvials = '<!--Closing Vials-->
					<input class="form-control numberclass closinginv" name="product['.$singleVacc["itemid"].']['.$batch.'][closingvials]" type="text" disabled="disabled">';
		$closingdoses = '<!--Closing Doses-->
					<input class="form-control numberclass closingind" name="product['.$singleVacc["itemid"].']['.$batch.'][closingdoses]" type="text" disabled="disabled">
					<input class="form-control" name="product['.$singleVacc["itemid"].']['.$batch.'][batch]" value="'.$batch.'" type="hidden" >
					<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][doses]" value="'.(($dosepervial>0)?$dosepervial:1).'" type="hidden" >
					<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][ob]" value="'.$singleVacc["opening"].'" type="hidden" >
					<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][received]" value="'.$singleVacc["recdoses"].'" type="hidden" >
					<input class="form-control numberclass adjustnature" name="product['.$singleVacc["itemid"].']['.$batch.'][adjustnature]" value="" type="hidden" >
					<input class="form-control numberclass adjusttype" name="product['.$singleVacc["itemid"].']['.$batch.'][adjusttype]" value="" type="hidden" >
					<input class="form-control numberclass adjustcomments" name="product['.$singleVacc["itemid"].']['.$batch.'][adjustcomments]" value="" type="hidden" >';
		//add new column for item name
		$prevrowspan = 1*$vaccnum;
		$itemnamecell = '<td style="'.$leftpadding.$rightpadding.'" class="itemname" data-moon="temp" rowspan="'.$prevrowspan.'"><label>'.$moonitemname.'</label></td>';
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
				
				<th colspan="3" class="text-center">Doses</th>
				<th colspan="3" class="text-center">Doses</th>
				<th colspan="3" class="text-center">Vials</th>
				<th colspan="3" class="text-center">Doses</th>
				<th colspan="3" class="text-center">Vials</th>
				<th colspan="3" class="text-center">Doses</th>
				<th colspan="3" class="text-center">Vials</th>
				<th colspan="3" class="text-center">Doses</th>
			</tr>';
			//for inner cells
			$childvaccinatedcell = '';
			$vaccinatedcells = array("iufp","iufnp","oufp","oufnp","odfp","odfnp","iuop","iuonp","ouop","ouonp","odop","odonp","iump","iumnp","oump","oumnp","odmp","odmnp","iuhp","iuhnp","ouhp","ouhnp","odhp","odhnp");
			foreach($vaccinatedcells as $moonind=>$value){
				$sectionclass = "";
				$localmoonind = $moonind;
				/* if($moonind<8){
					$sectionclass = "insideuc";
				}elseif($moonind<16){
					$sectionclass = "outsideuc";
				}else{
					$sectionclass = "outsidedist";
				} */
				if(in_array($localmoonind,array_merge(range(4,5),range(8,11),range(14,17),range(20,23)))){
					$sectionclass = "outsidecol";
				}
				$childvaccinatedcell .= '
					<td class="'.$sectionclass.' '.(($singleVacc["item_category_id"]!=1)?'mergedvaccinatedcells':'').'" '.(($singleVacc["item_category_id"]!=1)?'colspan = "24"':'colspan = "3"').'>
						<input class="form-control numberclass childvacc " name="product[vaccinated]['.$singleVacc["item_id"].'][moonrownum]['.$value.']" type="text" data-prodgroup="'.$singleVacc["item_id"].'" '.(($singleVacc["item_category_id"]!=1)?'disabled="disabled"':'').'>
					</td>';
				if($singleVacc["item_category_id"]!=1){break;}
			}
		}else{
			//for inner cells
			$childvaccinatedcell = '';
			$vaccinatedcells = array("iufm1","iuff1","oufm1","ouff1","odfm1","odff1","iuom1","iuof1","ouom1","ouof1","odom1","odof1","iumm1","iumf1","oumm1","oumf1","odmm1","odmf1","iuhm1","iuhf1","ouhm1","ouhf1","odhm1","odhf1","iufm2","iuff2","oufm2","ouff2","odfm2","odff2","iuom2","iuof2","ouom2","ouof2","odom2","odof2","iumm2","iumf2","oumm2","oumf2","odmm2","odmf2","iuhm2","iuhf2","ouhm2","ouhf2","odhm2","odhf2","iufm3","iuff3","oufm3","ouff3","odfm3","odff3","iuom3","iuof3","ouom3","ouof3","odom3","odof3","iumm3","iumf3","oumm3","oumf3","odmm3","odmf3","iuhm3","iuhf3","ouhm3","ouhf3","odhm3","odhf3");
			foreach($vaccinatedcells as $moonind=>$value){
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
				$childvaccinatedcell .= '
					<td class="'.$sectionclass.' '.(($singleVacc["item_category_id"]!=1)?'mergedvaccinatedcells':'').'" '.(($singleVacc["item_category_id"]!=1)?'colspan = "72"':'').'>
						<input class="form-control numberclass childvacc " name="product[vaccinated]['.$singleVacc["item_id"].'][moonrownum]['.$value.']" type="text" data-prodgroup="'.$singleVacc["item_id"].'" '.(($singleVacc["item_category_id"]!=1)?'disabled="disabled"':'').'>
					</td>';
				if($singleVacc["item_category_id"]!=1){break;}
			}
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
					<!--
					<td rowspan="'.$vaccnum.'">
						<!--Adjusted Vials--
						<div class="input-group">
							<input class="form-control numberclass adjustinv" name="product[<?php //echo $singleVacc["itemid"]; ?>][<?php //echo $batch; ?>][adjustvials]" type="text" disabled="disabled">
						</div>			
					</td>
					<td rowspan="'.$vaccnum.'">
						<!--Ajusted Doses--
						<div class="input-group">
							<input class="form-control numberclass adjustind" name="product[<?php //echo $singleVacc["itemid"]; ?>][<?php //echo $batch; ?>][adjustdoses]" type="text" disabled="disabled">
						</div>
					</td>
					<td rowspan="'.$vaccnum.'">
						<!--Adjustment--
						<button type="button" class="form-control btn btn-danger btn-xs adjustadd" data-quantitytype="<?php //echo ($singleVacc["in_doses"])?"d":"v"; ?>" data-original-title="Add an adjustment" data-toggle="modal" data-target="#AddAdjustmentModal"><i class="fa fa-arrow-up"></i><i class="fa fa-arrow-down"></i></button>
					</td>-->
					<td rowspan="'.$vaccnum.'">{closingvialshere}</td>
					<td rowspan="'.$vaccnum.'">{closingdoseshere}</td>';
			}else{
				$initialclass="";
				$initial = '';
				$mid = '';
				$last = '';
			}
			$childvaccinatedcellsrow = str_replace('moonrownum', $repeat, $childvaccinatedcell);
			
			$antigenNum = (($vaccnum>1)?$repeat+1:'');
			if($singleVacc["item_id"]=="15"){
				$antigenNum = $repeat;
			}
			$lastrow .= '
				<tr class="onebatch '.$initialclass.'" data-prodrow="'.$singleVacc["item_id"].'">
					'.$initial.
					'<!--Children Vaccinated-->
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
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iufm1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuff1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iufm2]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuff2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iufm3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuff3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuom1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuof1]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuom2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuof2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuom3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuof3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumm1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumf1]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumm2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumf2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumm3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumf3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhm1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhf1]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhm2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhf2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhm3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhf3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oufm1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouff1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oufm2]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouff2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oufm3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouff3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouom1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouof1]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouom2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouof2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouom3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouof3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumm1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumf1]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumm2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumf2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumm3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumf3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhm1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhf1]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhm2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhf2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhm3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhf3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odfm1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odff1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odfm2]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odff2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odfm3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odff3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odom1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odof1]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odom2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odof2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odom3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odof3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmm1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmf1]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmm2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmf2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmm3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmf3]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhm1]" type="text" data-prodgroup="9999">
		</td>
		<td class=" ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhf1]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhm2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhf2]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhm3]" type="text" data-prodgroup="9999">
		</td>
		<td class="outsidecol ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhf3]" type="text" data-prodgroup="9999">
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
?>