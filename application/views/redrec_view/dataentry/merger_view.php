<?php
if( ! empty($villages)){
	foreach($villages as $key => $village)
	{
		?>
		<tr>
			<td>
				<label class="srno-lbl" name="lb[1]"><?php echo $key+1; ?></label>
				<input type="hidden" id="add_edit" name="add_edit[<?php echo $key; ?>]" value="add_edit" class="form-control ">
				<input type="hidden" id="uncode" name="unicode" value="<?php echo $village['uncode']; ?>" class="form-control ">
				<input type="hidden" id="tcode" name="ticode" value="<?php echo $village['tcode']; ?>" class="form-control ">
				<!--<?php if($village['village_merger_id'] > 0){ ?>
				<input type="hidden" id="tcode" name="ticode" value="<?php echo $village['tcode']; ?>" class="form-control ">
				<input type="hidden" id="uncode" name="unicode" value="<?php echo $village['uncode']; ?>" class="form-control ">
				<input type="hidden" id="facode" name="facode" value="<?php echo $village['facode']; ?>" class="form-control ">
				<input type="hidden" id="techniciancode" name="techniciancode" value="<?php echo $village['techniciancode']; ?>" class="form-control ">
				<input type="hidden" id="year" name="year" value="<?php echo $village['year']; ?>" class="form-control ">
				<?php } ?>-->
			</td>
			<td>
				<label><?php echo get_mergervillage_Name($village['merger_code']); ?></label>
			</td>
			<td>
				<input type="text" readonly value="<?php echo isset($village['less_one_year'])?$village['less_one_year']:get_surviving_infants($village['totalpopulation']); ?>" id="population_less_year[<?php echo $key; ?>]"  name="less_one_year[<?php echo $key; ?>]" class="form-control text-center numberclass calculation  less_one_year">
				<input type="hidden"  value="<?php echo isset($village['f3_total_population'])?$village['f3_total_population']:$village['totalpopulation']; ?>" id="f3_total_population[<?php echo $key; ?>]"  name="f3_total_population[<?php echo $key; ?>]" class="form-control text-center numberclass calculation f3_total_population">
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['penta1'])?$village['penta1']:''; ?>" name="penta1[<?php echo $key; ?>]" class="form-control text-center numberclass calculation penta1">
			</td>
			<td>
				<input type="text" value="<?php echo isset($village['penta3'])?$village['penta3']:''; ?>" name="penta3[<?php echo $key; ?>]" class="form-control text-center numberclass calculation penta3 try prt">
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['measles'])?$village['measles']:''; ?>" name="measles[<?php echo $key; ?>]" class="form-control text-center numberclass calculation measles  prt">
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['tt2'])?$village['tt2']:''; ?>" name="tt2[<?php echo $key; ?>]" class="form-control text-center numberclass calculation tt2">
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['penta1_percent'])?$village['penta1_percent']:''; ?>" name="penta1_percent[<?php echo $key; ?>]" class="form-control numberclass text-center calculation penta1_percent" readonly>
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['penta3_percent'])?$village['penta3_percent']:''; ?>" name="penta3_percent[<?php echo $key; ?>]" class="form-control numberclass text-center calculation penta3_percent" readonly>
			</td>
			<td>
				<input type="text" value="<?php echo isset($village['measles_percent'])?$village['measles_percent']:'';?>" name="measles_percent[<?php echo $key; ?>]" class="form-control numberclass text-center calculation measles_percent" readonly>
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['tt2_percent'])?$village['tt2_percent']:''; ?>" name="tt2_percent[<?php echo $key; ?>]" class="form-control numberclass text-center calculation tt2_percent" readonly>
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['penta3_not'])?$village['penta3_not']:''; ?>" name="penta3_not[<?php echo $key; ?>]" class="form-control  numberclass text-center calculation penta3_not" readonly>
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['measles_not'])?$village['measles_not']:''; ?>" name="measles_not[<?php echo $key; ?>]" class="form-control numberclass text-center calculation measles_not" readonly>
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['penta1penta3'])?$village['penta1penta3']:''; ?>" name="penta1penta3[<?php echo $key; ?>]" class="form-control numberclass text-center calculation penta1penta3" readonly>
			</td>
			<td>
				<input type="text" value="<?php echo isset($village['penta1measles'])?$village['penta1measles']:''; ?>" name="penta1measles[<?php echo $key; ?>]" class="form-control numberclass text-center calculation penta1measles" readonly>
			</td>
			<td>
				<input type="text" value="<?php echo isset($village['access'])?$village['access']:''; ?>" name="access[<?php echo $key; ?>]" class="form-control numberclass text-center access" readonly>
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['utilization'])?$village['utilization']:''; ?>" name="utilization[<?php echo $key; ?>]" class="form-control numberclass text-center utilization" readonly>
			</td>
			<td>
				<input type="text" value="<?php  echo isset($village['category'])?$village['category']:'';?>" name="category[<?php echo $key; ?>]" class="form-control numberclass text-center category" readonly>
			</td>
			<td>
				<input type="text" value="<?php echo isset($village['priority'])?$village['priority']:'';?>" name="priority[<?php echo $key; ?>]" class="form-control numberclass text-center priority" readonly>
			</td>
			<td>
				<!--<input type="checkbox" name="id[<?php echo $key; ?>]" value="<?php echo $village['merger_code']; ?>">-->
				<input type="checkbox" <?php echo isset($village['village_merger_id'])?'checked':''; ?> name="id[<?php echo $key; ?>]" value="<?php echo isset($village['village_merger_id'])?$village['village_merger_id']:$village['merger_group_id']; ?>">
			</td>
		</tr>
	<?php
	}
}else{
	?>
	<tr>
		<td colspan="20">No Village/Population found in selected Union Council!</td>
	</tr>
<?php
}
?>