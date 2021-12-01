<h3>Update Working Status</h3>
<table class="table table-bordered table-condensed table-striped table-hover mytable3 udpate-table text-center ">
	<thead>
		<tr style="border:1px solid white; background:#008d4c; color:white;">
			<th>Warehouse <br> Name</th>
			<th>Asset ID</th>
			<th>Assets</th>
			<th>Working Status</th>
			<th>Reasons</th>
			<th>Utilizations</th>
			<th>Freeze Alarm</th>
			<th>Heat Alarm</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if(isset($coldChainData) AND sizeof($coldChainData) > 0){
			foreach($coldChainData as $key => $value){ ?>
				<tr>
					<td class="table-td-1"  style="text-align:center;">
						<input type="hidden" value="<?php echo $value['warehouse_type_id']; ?>" name="warehouse_type_id[]">
						<input type="hidden" name="procode[]" value="3">
						<?php if($value['warehouse_type_id'] == 4){ ?>
							<input type="hidden" name="distcode[]" value="<?php echo $value['distcode']; ?>">
						<?php }else if($value['warehouse_type_id'] == 5){ ?>
							<input type="hidden" name="distcode[]" value="<?php echo $value['distcode']; ?>">
							<input type="hidden" name="tcode[]" value="<?php echo $value['tcode']; ?>">
						<?php }else if($value['warehouse_type_id'] == 6){ ?>
							<input type="hidden" name="distcode[]" value="<?php echo $value['distcode']; ?>">
							<input type="hidden" name="tcode[]" value="<?php echo $value['tcode']; ?>">
							<input type="hidden" name="uncode[]" value="<?php echo $value['uncode']; ?>">
							<input type="hidden" name="facode[]" value="<?php echo $value['facode']; ?>">
						<?php } ?>
						<input type="hidden" value="<?php echo $value['ccm_id']; ?>" name="ccm_id[]">
						<input type="hidden" value="<?php echo $value['pk_id']; ?>" name="pk_id[]" />
						<input type="hidden" value="<?php echo $value['assets_type_id']; ?>" name="assets_type_id[]"  />
						<?php echo $value['warehousename']; ?>
					</td>
					<td class="table-td-1" style="text-align:center;">
						<span><?php echo $value['shortname']; ?></span>
					</td>
					<td class="table-td-1" style="text-align:center;">  
						<span><?php echo $value['assetsubtype']; ?></span>
					</td>
					<td class="table-td-1"  style="text-align:center;">
						<select class="form-control text-center status" name="working_status[]"  >
							<?php echo getWorkingstatus($value['status']); ?>
						</select>
					</td>
					<td class="table-td-1"  style="text-align:center;">
						<select class="form-control text-center reason" name="reason[]" id="reason">
							<?php echo getReasons($value['reasons']); ?>
						</select>
					</td>
					<td class="table-td-1"  style="text-align:center;">
						<select class="form-control text-center" name="utilization[]" id="case_type">
							<?php echo getUtilization($value['utilizations']); ?>
						</select>
					</td>
					<td>
						<input  style="text-align:center;" class="form-control" placeholder="" value="<?php echo $value['freeze_alarm']; ?>" name="freeze_alarm[]" id="freeezer"  type="text">
					</td>
					<td>
						<input  style="text-align:center;" class="form-control" placeholder="" value="<?php echo $value['heat_alarm']; ?>" name="heat_alarm[]" id="heater"  type="text">
					</td>
				</tr>
			<?php } ?>
		<?php } ?>
	</tbody>
</table>
<div style="border:1px solid lightgrey; position:relative; top:10px;">
	<?php //print_r($passiveContainerData); ?>
	<table class="table table-bordered table-condensed table-striped table-hover mytable3 udpate-table">
		<thead>
			<tr>
				<th>Assets</th>
				<th>Modal</th>
				<th>Total</th>
				<th>Working Quantity</th>
				<th>Comments</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if(isset($passiveContainerData) AND sizeof($passiveContainerData) > 0){
			foreach($passiveContainerData as $key => $value){ ?>
			<tr>  
				<td class="table-td-1" style="text-align:center;">
				<input type="hidden" value="<?php echo $value['warehouse_type_id']; ?>" name="warehouseIdPassive[]">
				<?php if($value['warehouse_type_id'] == 4){ ?>
						<input type="hidden" name="distcode[]" value="<?php echo $value['distcode']; ?>">
					<?php }else if($value['warehouse_type_id'] == 5){ ?>
						<input type="hidden" name="distcode[]" value="<?php echo $value['distcode']; ?>">
						<input type="hidden" name="tcode[]" value="<?php echo $value['tcode']; ?>">
					<?php }else if($value['warehouse_type_id'] == 6){ ?>
						<input type="hidden" name="distcode[]" value="<?php echo $value['distcode']; ?>">
						<input type="hidden" name="tcode[]" value="<?php echo $value['tcode']; ?>">
						<input type="hidden" name="uncode[]" value="<?php echo $value['uncode']; ?>">
						<input type="hidden" name="facode[]" value="<?php echo $value['facode']; ?>">
					<?php } ?>
					<input type="hidden" value="<?php echo $value['pk_id']; ?>" name="pkId[]">
					<input type="hidden" value="" name="type_name[]" >
					<span><?php echo $value['assetsubtype']; ?></span>
				</td>
				<td class="table-td-1" style="text-align:center;">
					<input type="hidden" value="" name="asset[]">
					<input type="hidden" value="" name="model[]">
					<span><?php echo $value['model_name']; ?></span>
				</td>
				<td style="text-align:center;" data-tl="<?php echo $value['total_quantity']; ?>" class="table-td-1 total" >
					<span><?php echo $value['total_quantity']; ?></span>
				</td>
				<td class="table-td-1" style="text-align:center;">
					<input class="form-control quanitity" placeholder="" name="quantity[]" id="quanitity" value="<?php echo $value['working_quantity']; ?>"  type="text" style="text-align:center;">
				</td>
				<td  style="text-align:center;">
					<input class="form-control" placeholder="Add Comments here..." value="<?php echo $value['comments']; ?>" name="comment[]"   type="text">
				</td>
			</tr>
			<?php } ?>
		<?php } ?>
		</tbody>
	</table>
</div>