<?php echo form_open(base_url().'searchAssets',array("class"=>"form-horizontal")); ?>
	<table class="table table-bordered table-condensed mytable3">
		<thead>
			<tr>
				<th colspan="4" style="padding-top: 10px; padding-bottom: 10px;">Filters</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="padding-left:10px;">
					<label>Asset Sub Type</label>
					<select class="form-control text-center" id="assets">
						<option value="0" >--Select Asset--</option>
						<optgroup label="Active Containers">
							<?php
							foreach($assetTypesActiveContainers as $val)
							{
								echo $option="<option value='".$val['pk_id']."-".$val['asset_type_name']."'>".$val['asset_type_name']."</option>";
							}
							?>
						</optgroup>
						<optgroup label="Passive Containers">
							<?php
							foreach($assetTypesPassiveContainers as $val)
							{
								echo $option="<option value='".$val['pk_id']."-".$val['asset_type_name']."'>".$val['asset_type_name']."</option>";
							}
							?>
						</optgroup>
					</select>
				</td>
				<td>
					<label>Source of Supply </label>
					<select id="activity" name="activity" class="form-control">
						<option value="">--Select--</option>
						
					</select>
				</td>
				<td style="padding-left:10px;">
					<label>Working Status </label>
					<select id="product" name="product" class="form-control">
						<option value=""> All </option>	
					</select>
				</td>
				<td style="padding-left:10px;">
					<label>Asset Id / Equipment Code</label>
					<select id="product" name="product" class="form-control">
						<option value=""> All </option>	
					</select>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px;">
					<label>Catalogue ID</label>
					<select id="from_warehouse_type_id" name="from_warehouse_type_id" class="form-control">
						
					</select>
				</td>
				<td>
					<label>Make</label>
					<select id="activity" name="activity" class="form-control">
						<option value="">--Select--</option>
						
					</select>
				</td>
				<td style="padding-left:10px;">
					<label>Model</label>
					<select id="product" name="product" class="form-control">
						<option value=""> All </option>	
					</select>
				</td>
				<td style="padding-left:10px;">
					<label>Serial Number</label>
					<select id="product" name="product" class="form-control">
						<option value=""> All </option>	
					</select>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px;">
					<label>Gross Capacity From</label>
					<select id="from_warehouse_type_id" name="from_warehouse_type_id" class="form-control">
						
					</select>
				</td>
				<td>
					<label>Gross Capacity To</label>
					<select id="activity" name="activity" class="form-control">
						<option value="">--Select--</option>
						
					</select>
				</td>
				<td style="padding-left:10px;">
					<label>Working Since From</label>
					<select id="product" name="product" class="form-control">
						<option value=""> All </option>	
					</select>
				</td>
				<td style="padding-left:10px;">
					<label>Working Since To</label>
					<select id="product" name="product" class="form-control">
						<option value=""> All </option>	
					</select>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px;">
					<label>&nbsp;</label><br>
					<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-search "></i> Search </button>
					<button type="reset" class="btn btn-info btn-md" role="button"><i class="fa fa-repeat"></i> Reset </button>
				</td>
			</tr>
		</tbody>
	</table>
<?php echo form_close(); ?>