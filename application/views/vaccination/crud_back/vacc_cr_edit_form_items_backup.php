<?php 
$disabledstyle = 'background-color:#eee;';
$toppadding = 'padding-top:11px;';
$leftpadding = 'padding-left:10px;';
$rightpadding = 'padding-right:10px;';
$previtemname = $finaloutput = $lastrow = $batches = $dosespervial = $openingdoses = $receiveddoses =$usedvials = $useddoses = $unusedvials = $unuseddoses = $closingvials = $closingdoses = "";
$vaccinated = array();//global
if(isset($cr_items["product"])){
	$vaccinated = $cr_items["product"];
	unset($cr_items["product"]);
}
//print_r($vaccinated);exit;
foreach($cr_items as $key=>$singleVacc){
	//$keyparts 		= explode("moon",$key);
	//$batch 			= isset($keyparts[1])?$keyparts[1]:'BB2019';
	$batch=$singleVacc["batch"];
	//$dosepervial 	= (isset($keyparts[2]) && $keyparts[2]>1)?$keyparts[2]:'';
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
				<td colspan="2"></td>
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
				<td colspan="10"></td>
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
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iufm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iufm1"])?$vaccinated["vaccinated"][17][0]["iufm1"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuff1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuff1"])?$vaccinated["vaccinated"][17][0]["iuff1"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iufm2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iufm2"])?$vaccinated["vaccinated"][17][0]["iufm2"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuff2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuff2"])?$vaccinated["vaccinated"][17][0]["iuff2"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iufm3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iufm3"])?$vaccinated["vaccinated"][17][0]["iufm3"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuff3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuff3"])?$vaccinated["vaccinated"][17][0]["iuff3"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuom1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuom1"])?$vaccinated["vaccinated"][17][0]["iuom1"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuof1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuof1"])?$vaccinated["vaccinated"][17][0]["iuof1"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuom2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuom2"])?$vaccinated["vaccinated"][17][0]["iuom2"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuof2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuof2"])?$vaccinated["vaccinated"][17][0]["iuof2"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuom3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuom3"])?$vaccinated["vaccinated"][17][0]["iuom3"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuof3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuof3"])?$vaccinated["vaccinated"][17][0]["iuof3"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iumm1"])?$vaccinated["vaccinated"][17][0]["iumm1"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumf1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iumf1"])?$vaccinated["vaccinated"][17][0]["iumf1"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumm2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iumm2"])?$vaccinated["vaccinated"][17][0]["iumm2"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumf2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iumf2"])?$vaccinated["vaccinated"][17][0]["iumf2"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumm3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iumm3"])?$vaccinated["vaccinated"][17][0]["iumm3"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iumf3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iumf3"])?$vaccinated["vaccinated"][17][0]["iumf3"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuhm1"])?$vaccinated["vaccinated"][17][0]["iuhm1"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhf1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuhf1"])?$vaccinated["vaccinated"][17][0]["iuhf1"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhm2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuhm2"])?$vaccinated["vaccinated"][17][0]["iuhm2"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhf2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuhf2"])?$vaccinated["vaccinated"][17][0]["iuhf2"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhm3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuhm3"])?$vaccinated["vaccinated"][17][0]["iuhm3"]:0).'">
		</td>
		<td class="insideuc ">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][iuhf3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["iuhf3"])?$vaccinated["vaccinated"][17][0]["iuhf3"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oufm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["oufm1"])?$vaccinated["vaccinated"][17][0]["oufm1"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouff1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouff1"])?$vaccinated["vaccinated"][17][0]["ouff1"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oufm2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["oufm2"])?$vaccinated["vaccinated"][17][0]["oufm2"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouff2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouff2"])?$vaccinated["vaccinated"][17][0]["ouff2"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oufm3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["oufm3"])?$vaccinated["vaccinated"][17][0]["oufm3"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouff3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouff3"])?$vaccinated["vaccinated"][17][0]["ouff3"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouom1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouom1"])?$vaccinated["vaccinated"][17][0]["ouom1"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouof1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouof1"])?$vaccinated["vaccinated"][17][0]["ouof1"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouom2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouom2"])?$vaccinated["vaccinated"][17][0]["ouom2"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouof2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouof2"])?$vaccinated["vaccinated"][17][0]["ouof2"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouom3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouom3"])?$vaccinated["vaccinated"][17][0]["ouom3"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouof3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouof3"])?$vaccinated["vaccinated"][17][0]["ouof3"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["oumm1"])?$vaccinated["vaccinated"][17][0]["oumm1"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumf1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["oumf1"])?$vaccinated["vaccinated"][17][0]["oumf1"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumm2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["oumm2"])?$vaccinated["vaccinated"][17][0]["oumm2"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumf2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["oumf2"])?$vaccinated["vaccinated"][17][0]["oumf2"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumm3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["oumm3"])?$vaccinated["vaccinated"][17][0]["oumm3"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][oumf3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["oumf3"])?$vaccinated["vaccinated"][17][0]["oumf3"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouhm1"])?$vaccinated["vaccinated"][17][0]["ouhm1"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhf1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouhf1"])?$vaccinated["vaccinated"][17][0]["ouhf1"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhm2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouhm2"])?$vaccinated["vaccinated"][17][0]["ouhm2"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhf2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouhf2"])?$vaccinated["vaccinated"][17][0]["ouhf2"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhm3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouhm3"])?$vaccinated["vaccinated"][17][0]["ouhm3"]:0).'">
		</td>
		<td class="outsideuc " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][ouhf3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["ouhf3"])?$vaccinated["vaccinated"][17][0]["ouhf3"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odfm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odfm1"])?$vaccinated["vaccinated"][17][0]["odfm1"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odff1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odff1"])?$vaccinated["vaccinated"][17][0]["odff1"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odfm2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odfm2"])?$vaccinated["vaccinated"][17][0]["odfm2"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odff2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odff2"])?$vaccinated["vaccinated"][17][0]["odff2"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odfm3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odfm3"])?$vaccinated["vaccinated"][17][0]["odfm3"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odff3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odff3"])?$vaccinated["vaccinated"][17][0]["odff3"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odom1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odom1"])?$vaccinated["vaccinated"][17][0]["odom1"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odof1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odof1"])?$vaccinated["vaccinated"][17][0]["odof1"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odom2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odom2"])?$vaccinated["vaccinated"][17][0]["odom2"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odof2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odof2"])?$vaccinated["vaccinated"][17][0]["odof2"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odom3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odom3"])?$vaccinated["vaccinated"][17][0]["odom3"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odof3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odof3"])?$vaccinated["vaccinated"][17][0]["odof3"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odmm1"])?$vaccinated["vaccinated"][17][0]["odmm1"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmf1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odmf1"])?$vaccinated["vaccinated"][17][0]["odmf1"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmm2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odmm2"])?$vaccinated["vaccinated"][17][0]["odmm2"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmf2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odmf2"])?$vaccinated["vaccinated"][17][0]["odmf2"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmm3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odmm3"])?$vaccinated["vaccinated"][17][0]["odmm3"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odmf3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odmf3"])?$vaccinated["vaccinated"][17][0]["odmf3"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhm1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odhm1"])?$vaccinated["vaccinated"][17][0]["odhm1"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhf1]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odhf1"])?$vaccinated["vaccinated"][17][0]["odhf1"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhm2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odhm2"])?$vaccinated["vaccinated"][17][0]["odhm2"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhf2]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odhf2"])?$vaccinated["vaccinated"][17][0]["odhf2"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhm3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odhm3"])?$vaccinated["vaccinated"][17][0]["odhm3"]:0).'">
		</td>
		<td class="outsidedist " style="display: none;">
			<input class="form-control numberclass " name="product[vaccinated][9999][0][odhf3]" type="text" data-prodgroup="9999" value="'.(isset($vaccinated["vaccinated"][17][0]["odhf3"])?$vaccinated["vaccinated"][17][0]["odhf3"]:0).'">
		</td>
		<td class="prodbatch" colspan="10"></td>
	</tr>';
$finaloutput .= $fullyimmunized;
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
				<input class="form-control numberclass childvacc " name="product[vaccinated]['.$item_id.']['.$rownum.']['.$value.']" type="text" data-prodgroup="'.$item_id.'" '.(($item_category_id!=1)?'disabled="disabled"':'').' value="'.($vaccinatedval).'">
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
				<input class="form-control numberclass childvacc " name="product[vaccinated]['.$item_id.']['.$rownum.']['.$value.']" type="text" data-prodgroup="'.$item_id.'" '.(($item_category_id!=1)?'disabled="disabled"':'').' value="'.($vaccinatedval).'">
			</td>';
		if($item_category_id!=1){break;}
	}
	return $childvaccinatedcell;
}
?>
