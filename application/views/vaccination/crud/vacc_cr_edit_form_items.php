<?php 
$disabledstyle = 'background-color:#eee;';
$toppadding = 'padding-top:11px;';
$leftpadding = 'padding-left:10px;';
$rightpadding = 'padding-right:10px;';
$previtemname = $finaloutput = $lastrow = $batches = $dosespervial = $openingdoses = $receiveddoses =$usedvials = $useddoses = $unusedvials = $unuseddoses = $closingvials = $closingdoses = $fmcells = "";
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
		$hiddenfields .= '<br>'.'<!-- for detail pk_id to update data -->
			<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][detail_id]" value="'.$singleVacc["detail_id"].'" type="hidden" >
			<!-- master id for report for update -->
			<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][master_id]" value="'.$singleVacc["pk_id"].'" type="hidden" >
			<!-- adjust  id for report for update -->
			<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][adjust_id]" value="'.$singleVacc["adjust_id"].'" type="hidden" >';
		$batches .= '<br>'.'<label class="form-control" disabled="disabled">'.$batch.'</label>';
		$dosespervial .= '<br>'.'<label class="form-control" disabled="disabled">'.$dosepervial.'</label>';
		$openingdoses .= '<br>'.'<label class="form-control" disabled="disabled">'.$singleVacc["opening"].'</label>';
		$receiveddoses .= '<br>'.'<label class="form-control" disabled="disabled">'.$singleVacc["recdoses"].'</label>';
		$usedvials .= '<br>'.'<input class="form-control numberclass usedinv" name="product['.$singleVacc["itemid"].']['.$batch.'][usedvials]" type="text" '.(($singleVacc["in_doses"])?'disabled="disabled"':'').' value="'.(($singleVacc["used_vials"])?$singleVacc["used_vials"]:'').'">';
		$useddoses .= '<br>'.'<input class="form-control numberclass usedind" name="product['.$singleVacc["itemid"].']['.$batch.'][useddoses]" type="text" '.(($singleVacc["in_doses"])?'':'disabled="disabled"').' value="'.(($singleVacc["used_doses"])?$singleVacc["used_doses"]:'').'">';
		$unusedvials .= '<br>'.'<input class="form-control numberclass unusedinv" name="product['.$singleVacc["itemid"].']['.$batch.'][unusedvials]" type="text" '.(($singleVacc["in_doses"])?'disabled="disabled"':'').' value="'.(($singleVacc["unused_vials"])?$singleVacc["unused_vials"]:'').'">';
		$unuseddoses .= '<br>'.'<input class="form-control numberclass unusedind" name="product['.$singleVacc["itemid"].']['.$batch.'][unuseddoses]" type="text" '.(($singleVacc["in_doses"])?'':'disabled="disabled"').' value="'.(($singleVacc["unused_doses"])?$singleVacc["unused_doses"]:'').'">';
		$closingvials .= '<br>'.'<input class="form-control numberclass closinginv" name="product['.$singleVacc["itemid"].']['.$batch.'][closingvials]" type="text" disabled="disabled" value="'.$singleVacc["closing_vials"].'">';
		$closingdoses .= '<br>'.'<input class="form-control numberclass closingind" name="product['.$singleVacc["itemid"].']['.$batch.'][closingdoses]" type="text" disabled="disabled" value="'.$singleVacc["closing_doses"].'">
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
			$lastrow = str_replace('{hiddenfieldshere}', $hiddenfields, $lastrow);
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
		$hiddenfields = '<!-- for detail pk_id to update data -->
			<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][detail_id]" value="'.$singleVacc["detail_id"].'" type="hidden" >
			<!-- master id for report for update -->
			<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][master_id]" value="'.$singleVacc["pk_id"].'" type="hidden" >
			<!-- adjust  id for report for update -->
			<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][adjust_id]" value="'.$singleVacc["adjust_id"].'" type="hidden" >';
		$usedvials = '<!--Used Vials-->
					<input class="form-control numberclass usedinv" name="product['.$singleVacc["itemid"].']['.$batch.'][usedvials]" type="text" '.(($singleVacc["in_doses"])?'disabled="disabled"':'').' value="'.(($singleVacc["used_vials"])?$singleVacc["used_vials"]:'').'">';
		$useddoses = '<!--Used Doses-->
					<input class="form-control numberclass usedind" name="product['.$singleVacc["itemid"].']['.$batch.'][useddoses]" type="text" '.(($singleVacc["in_doses"])?'':'disabled="disabled"').' value="'.(($singleVacc["used_doses"])?$singleVacc["used_doses"]:'').'">';
		$unusedvials = '<!--Unused Vials-->
					<input class="form-control numberclass unusedinv" name="product['.$singleVacc["itemid"].']['.$batch.'][unusedvials]" type="text" '.(($singleVacc["in_doses"])?'disabled="disabled"':'').' value="'.(($singleVacc["unused_vials"])?$singleVacc["unused_vials"]:'').'">';
		$unuseddoses = '<!--Unused Doses-->
					<input class="form-control numberclass unusedind" name="product['.$singleVacc["itemid"].']['.$batch.'][unuseddoses]" type="text" '.(($singleVacc["in_doses"])?'':'disabled="disabled"').' value="'.(($singleVacc["unused_doses"])?$singleVacc["unused_doses"]:'').'">';
		$closingvials = '<!--Closing Vials-->
					<input class="form-control numberclass closinginv" name="product['.$singleVacc["itemid"].']['.$batch.'][closingvials]" type="text" disabled="disabled" value="'.$singleVacc["closing_vials"].'">';
		$closingdoses = '<!--Closing Doses-->
					<input class="form-control numberclass closingind" name="product['.$singleVacc["itemid"].']['.$batch.'][closingdoses]" type="text" disabled="disabled" value="'.$singleVacc["closing_doses"].'">
					<input class="form-control" name="product['.$singleVacc["itemid"].']['.$batch.'][batch]" value="'.$batch.'" type="hidden" >
					<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][doses]" value="'.(($dosepervial>0)?$dosepervial:1).'" type="hidden" >
					<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][ob]" value="'.$singleVacc["opening"].'" type="hidden" >
					<input class="form-control numberclass" name="product['.$singleVacc["itemid"].']['.$batch.'][received]" value="'.$singleVacc["recdoses"].'" type="hidden" >
					<input class="form-control numberclass adjustnature" name="product['.$singleVacc["itemid"].']['.$batch.'][adjustnature]" value="'.(($singleVacc["nature"])?$singleVacc["nature"]:'').'" type="hidden" >
					<input class="form-control numberclass adjusttype" name="product['.$singleVacc["itemid"].']['.$batch.'][adjusttype]" value="'.(($singleVacc["adjustment_type"])?$singleVacc["adjustment_type"]:'').'" type="hidden" >
					<input class="form-control numberclass adjustcomments" name="product['.$singleVacc["itemid"].']['.$batch.'][adjustcomments]" value="'.($singleVacc["comments"]).'" type="hidden" >';
		//add new column for item name
		$prevrowspan = 1*$vaccnum;
		$itemnamecell = '<td style="'.$leftpadding.$rightpadding.'" class="itemname" data-moon="temp" rowspan="'.$prevrowspan.'"><label>'.$moonitemname.'</label>
		{hiddenfieldshere}
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
				
				<th style="vertical-align: middle;" rowspan="4" class="text-center"><label class="rotateheaderlabels">Batch number</label></th>
				<th style="vertical-align: middle;" rowspan="4" class="text-center"><label class="rotateheaderlabels">Doses Per Vial</label></th>
				<th rowspan="3" class="text-center"><label>Opening Balance</label></th>
				<th rowspan="3" class="text-center"><label>Received</label></th>
				<th colspan="2" rowspan="3" class="text-center"><label>Used</label></th>
				<th colspan="2" rowspan="3" class="text-center"><label>Unusable</label></th>
				<th colspan="2" rowspan="3" class="text-center"><label>Closing Balance</label></th>
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
				<tr class="onebatch '.$initialclass.'" data-prodrow="'.$singleVacc["item_id"].'" data-prodrowindex="'.$repeat.'">
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
if($fmcells!==""){
	$vaccinatedcell = "";
	foreach($fmcells as $key=>$value){
		$sectionclass = "";
		$localmoonind = $key;
		if($key<26){
			//$sectionclass = "insideuc";
		}elseif($key<52){
			//$sectionclass = "outsideuc";
			$localmoonind = $key-26;
		}else{
			$localmoonind = $key-52;
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
		$vaccinatedcell .= '
			<td class="'.$sectionclass.' ">
				<input class="form-control numberclass " name="product[vaccinated][9999][0]['.$value.']" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][9999][0][$value])?$vaccinated["vaccinated"][9999][0][$value]:0).'">
			</td>';
	}
	$sumffullyimmunized=((isset($vaccinated["vaccinated"][9999][0]['iufm1'])?$vaccinated["vaccinated"][9999][0]['iufm1']:0)+(isset($vaccinated["vaccinated"][9999][0]['iuff1'])?$vaccinated["vaccinated"][9999][0]['iuff1']:0));
	$fullyimmunized .= '
		<tr class="cst-item-row" data-prodrow="9999" data-prodrowindex="0">
			<td style="padding-left: 10px; padding-right: 10px; background-color: whitesmoke; position: relative; left: 0px;" class="itemname" data-moon="temp"><label>Fully Immunized</label></td>
			<td class="text-center vaccnum" background-color:#eee;"="" style="background-color: whitesmoke; position: relative; left: 0px;"></td>
			<td colspan="5">
				<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;    font-weight: bold">M:</span>
				<input class="form-control numberclass " id="txt1fully" name="product[vaccinated][9999][0][iufm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][9999][0]['iufm1'])?$vaccinated["vaccinated"][9999][0]['iufm1']:0).'" onkeyup="sumfully()" style="width: Calc(100% - 25px);display: inline;">
			</td >
			<td colspan="5">
				<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;font-weight: bold">F:</span>
				<input class="form-control numberclass " id="txt2fully" name="product[vaccinated][9999][0][iuff1]" type="text" data-prodgroup="9999"  value="'.(isset($vaccinated["vaccinated"][9999][0]['iuff1'])?$vaccinated["vaccinated"][9999][0]['iuff1']:0).'" onkeyup="sumfully()" style="width: Calc(100% - 25px);display: inline;">
			</td>
			<td colspan="5">
				<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;font-weight: bold">Total:</span>
				<input class="form-control numberclass "  id="totalfully" name="totalfully" type="text" data-prodgroup="9999" value="'.$sumffullyimmunized.'" style="width: Calc(100% - 45px);display: inline;" disabled="disabled">
			</td>
			
			<td class="prodbatch" colspan="10"></td>
		</tr>';
	$finaloutput .= $fullyimmunized;
}
//for dtp booster row
if($fmcells!==""){
	$vaccinatedcell = "";
	foreach($fmcells as $key=>$value){
		$sectionclass = "";
		$localmoonind = $key;
		if($key<26){
			//$sectionclass = "insideuc";
		}elseif($key<52){
			//$sectionclass = "outsideuc";
			$localmoonind = $key-26;
		}else{
			$localmoonind = $key-52;
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
		$vaccinatedcell .= '
			<td class="'.$sectionclass.' ">
				<input class="form-control numberclass " name="product[vaccinated][9998][0]['.$value.']" type="text" data-prodgroup="9998" value="'.(isset($vaccinated["vaccinated"][9998][0][$value])?$vaccinated["vaccinated"][9998][0][$value]:0).'"> 
			</td>';
	}
	$sumdtpbooster=((isset($vaccinated["vaccinated"][9998][0]['iufm1'])?$vaccinated["vaccinated"][9998][0]['iufm1']:0)+(isset($vaccinated["vaccinated"][9998][0]['iuff1'])?$vaccinated["vaccinated"][9998][0]['iuff1']:0));
	$dtpbooster .= '
		<tr class="cst-item-row" data-prodrow="9998" data-prodrowindex="0">
			<td style="padding-left: 10px; padding-right: 10px; background-color: whitesmoke; position: relative; left: 0px;" class="itemname" data-moon="temp"><label>DTP Booster</label></td>
			<td class="text-center vaccnum" background-color:#eee;"="" style="background-color: whitesmoke; position: relative; left: 0px;"></td>
			<td colspan="5">
				<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;    font-weight: bold">M:</span>
				<input class="form-control numberclass " id="txt1dtp" name="product[vaccinated][9998][0][iufm1]" type="text" data-prodgroup="9998" value="'.(isset($vaccinated["vaccinated"][9998][0]['iufm1'])?$vaccinated["vaccinated"][9998][0]['iufm1']:0).'" onkeyup="sumdtp()" style="width: Calc(100% - 25px);display: inline;">
			</td >
			<td colspan="5">
				<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;font-weight: bold">F:</span>
				<input class="form-control numberclass " id="txt2dtp" name="product[vaccinated][9998][0][iuff1]" type="text" data-prodgroup="9998"  value="'.(isset($vaccinated["vaccinated"][9998][0]['iuff1'])?$vaccinated["vaccinated"][9998][0]['iuff1']:0).'" onkeyup="sumdtp()" style="width: Calc(100% - 25px);display: inline;">
			</td>
			<td colspan="5">
				<span style="padding-top: 4px;padding-left: 3px;padding-right: 3px;font-weight: bold">Total:</span>
				<input class="form-control numberclass "  id="totaldtp" name="totaldtp" type="text" data-prodgroup="9998" value="'.$sumdtpbooster.'" style="width: Calc(100% - 45px);display: inline;" disabled="disabled">
			</td>
			
			<td class="prodbatch" colspan="10"></td>
		</tr>';
	$finaloutput .= $dtpbooster;
}
//parse last row and add batches
$lastrow = str_replace('{hiddenfieldshere}', $hiddenfields, $lastrow);
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

function getVaccinatedCells($singleVacc,$vaccinated,$rownum,&$fmcells){
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
			<td class="'.$sectionclass.' '.(($item_category_id!=1)?'mergedvaccinatedcells':'').'" '.(($item_category_id!=1)?'colspan = "78"':'').'>
				<input class="'.(($value=='iutd1' || $value=='iutd2' || $value=='iutd3') ? "form-control numberclass dotcounttd" : (($value=='iudc1' || $value=='iudc2' || $value=='iudc3') ?  "form-control numberclass dotcountdc" : "form-control numberclass childvacc ")).'" name="product[vaccinated]['.$item_id.']['.$rownum.']['.$value.']" type="text" data-prodgroup="'.$item_id.'" '.(($item_category_id!=1)?'disabled="disabled"':'').' value="'.($vaccinatedval).'">
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
		if(in_array($localmoonind,array_merge(range(4,5),range(8,11),range(14,17),range(20,23)))){
			$sectionclass = "outsidecol";
		}
		if(in_array($localmoonind,array_merge(range(2,3),range(8,9),range(14,15),range(20,21)))){
			$sectionclass .= " outuccol";
		}
		if(in_array($localmoonind,array_merge(range(4,5),range(10,11),range(16,17),range(22,23)))){
			$sectionclass .= " outdistcol";
		}
		$childvaccinatedcell .= '
			<td class="'.$sectionclass.' '.(($item_category_id!=1)?'mergedvaccinatedcells':'').'" '.(($item_category_id!=1)?'colspan = "24"':'colspan = "3"').'>
				<input class="form-control numberclass childvacc " name="product[vaccinated]['.$item_id.']['.$rownum.']['.$value.']" type="text" data-prodgroup="'.$item_id.'" '.(($item_category_id!=1)?'disabled="disabled"':'').' value="'.($vaccinatedval).'">
			</td>';
		if($item_category_id!=1){break;}
	}
	return $childvaccinatedcell;
}
?>
