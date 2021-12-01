<?php 
$disabledstyle = 'background-color:#eee;';
$toppadding = 'padding-top:11px;';
foreach($cr_items as $key=>$singleVacc){
	$batch=$singleVacc["batch"];
	$dosepervial=$singleVacc["doses"];?>
	<tr class="onebatch">
		<td style="<?php echo $toppadding; ?>"  class="itemname" ><?php echo ($singleVacc["item_category_id"]!=1)?trim($singleVacc["item_name"]):trim($singleVacc["itemname"]); ?>
			<!-- for detail pk_id to update data -->
			<input class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][detail_id]" value="<?php echo $singleVacc["detail_id"]; ?>" type="hidden" >
			<!-- master id for report for update -->
			<input class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][master_id]" value="<?php echo $singleVacc["pk_id"]; ?>" type="hidden" >
			<!-- adjust  id for report for update -->
			<input class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][adjust_id]" value="<?php echo $singleVacc["adjust_id"]; ?>" type="hidden" >			
			
		</td>
		<td style="<?php echo $toppadding; ?>" class="prodbatch"><?php echo $batch; ?></td>
		<td class="text-center doses" style="<?php echo $toppadding.' '.(($dosepervial>0)?'':$disabledstyle); ?>"><?php echo $dosepervial; ?></td>
		<td class="text-center ob" style="<?php echo $toppadding.' '.$disabledstyle; ?>"><?php echo $singleVacc["opening"]; ?></td>
		<td class="text-center received" style="<?php echo $toppadding.' '.$disabledstyle; ?>"><?php echo $singleVacc["recdoses"]; ?></td>
		<td>
			<!--Children Vaccinated-->
			<input class="form-control numberclass childvacc" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][vaccinated]" type="text" <?php echo ($singleVacc["item_category_id"]!=1)?'disabled="disabled"':''; ?> value="<?php echo ($singleVacc["vaccinated"])?$singleVacc["vaccinated"]:''; ?>">
		</td>
		<td>
			<!--Used Vials-->
			<input class="form-control numberclass usedinv" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][usedvials]" type="text" <?php echo ($singleVacc["in_doses"])?'disabled="disabled"':''; ?> value="<?php echo ($singleVacc["used_vials"])?$singleVacc["used_vials"]:''; ?>">
		</td>
		<td>
			<!--Used Doses-->
			<input class="form-control numberclass usedind" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][useddoses]" type="text" <?php echo ($singleVacc["in_doses"])?'':'disabled="disabled"'; ?> value="<?php echo ($singleVacc["used_doses"])?$singleVacc["used_doses"]:''; ?>">
		</td>
		<td>
			<!--Unused Vials-->
			<input class="form-control numberclass unusedinv" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][unusedvials]" type="text" <?php echo ($singleVacc["in_doses"])?'disabled="disabled"':''; ?> value="<?php echo ($singleVacc["unused_vials"])?$singleVacc["unused_vials"]:''; ?>">
		</td>
		<td>
			<!--Unused Doses-->
			<input class="form-control numberclass unusedind" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][unuseddoses]" type="text" <?php echo ($singleVacc["in_doses"])?'':'disabled="disabled"'; ?> value="<?php echo ($singleVacc["unused_doses"])?$singleVacc["unused_doses"]:''; ?>">
		</td>
		<!--<td>
			<!--Adjusted Vials--
			<div class="input-group">
			<input class="form-control numberclass adjustinv" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][adjustvials]" type="text" disabled="disabled" value="<?php echo ($singleVacc["adjustment_quantity_vials"])?$singleVacc["adjustment_quantity_vials"]:''; ?>">
			<?php if(isset($singleVacc["nature"]))
			{
						if($singleVacc["nature"]!="")
						{
						echo ($singleVacc["nature"]=='1')?'<span class="input-group-addon" data-nature="positive" style="padding:1px;color:green;"><i class="glyphicon glyphicon-circle-arrow-up"></i></span>':'<span class="input-group-addon" data-nature="negative" style="padding:1px;color:red;"><i class="glyphicon glyphicon-circle-arrow-down"></i></span>';
						}
			}?>
		</div>	
		</td>
		<td>
			<!--Adjusted Doses--
			<div class="input-group">
			<input class="form-control numberclass adjustind" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][adjustdoses]" type="text" disabled="disabled"  value="<?php echo ($singleVacc["adjustment_quantity_doses"])?$singleVacc["adjustment_quantity_doses"]:''; ?>">
			<?php if(isset($singleVacc["nature"]))
			{
						if($singleVacc["nature"]!="")
						{
						echo ($singleVacc["nature"]=='1')?'<span class="input-group-addon" data-nature="positive" style="padding:1px;color:green;"><i class="glyphicon glyphicon-circle-arrow-up"></i></span>':'<span class="input-group-addon" data-nature="negative" style="padding:1px;color:red;"><i class="glyphicon glyphicon-circle-arrow-down"></i></span>';
						}
			}?>
			</div>
		</td>
		<td>
			<!--Adjustment--
			<button type="button" class="form-control btn btn-danger btn-xs adjustadd" data-quantitytype="<?php echo ($singleVacc["in_doses"])?'d':'v'; ?>" data-original-title="Add an adjustment" data-toggle="modal" data-target="#AddAdjustmentModal"><i class="fa fa-arrow-up"></i><i class="fa fa-arrow-down"></i></button>
		</td>-->
		<td>
			<!--Closing Vials-->
			<input class="form-control numberclass closinginv" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][closingvials]" type="text" disabled="disabled" value="<?php echo $singleVacc["closing_vials"]; ?>">
		</td>
		<td>
			<!--Closing Doses-->
			<input class="form-control numberclass closingind" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][closingdoses]" type="text" disabled="disabled" value="<?php echo $singleVacc["closing_doses"]; ?>">
			<input class="form-control" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][batch]" value="<?php echo $batch; ?>" type="hidden" >
			<input class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][doses]" value="<?php echo ($dosepervial>0)?$dosepervial:1; ?>" type="hidden" >
			<input class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][ob]" value="<?php echo $singleVacc["opening"]; ?>" type="hidden" >
			<input class="form-control numberclass" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][received]" value="<?php echo $singleVacc["recdoses"]; ?>" type="hidden" >
			<input class="form-control numberclass adjustnature" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][adjustnature]" value="<?php echo ($singleVacc["nature"])?$singleVacc["nature"]:''; ?>" type="hidden" >
			<input class="form-control numberclass adjusttype" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][adjusttype]" value="<?php echo ($singleVacc["adjustment_type"])?$singleVacc["adjustment_type"]:''; ?>" type="hidden" >
			<input class="form-control numberclass adjustcomments" name="product[<?php echo $singleVacc["itemid"]; ?>][<?php echo $batch; ?>][adjustcomments]" value="<?php echo $singleVacc["comments"]; ?>" type="hidden" >
		</td>
	</tr>
	<?php 
}?>