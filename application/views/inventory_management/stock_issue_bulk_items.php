<?php 
$showreq = $showbothavailable = false;
$rowspan = $colspan = $noOfDays = "";
$currwhtype = $this->session->curr_wh_type;
if(($currwhtype==4 && $towhtype==6) || ($currwhtype==2 && $towhtype==4)){
	$showreq = true;
	$rowspan="2";
	$colspan = "3";
	$noOfDays = "45";
	if($currwhtype==2 && $towhtype==4){
		$rowspan="3";
		$colspan = "4";
		$showbothavailable = true;
		$noOfDays = "60";
	}
} ?>
<div class="row mt10">
	<div class="col-md-12">
		<table class="table table-bordered table-hover table-striped table-vcenter tbl-listing">
			<thead>
				<tr>
					<th rowspan="<?php echo $rowspan; ?>" style="width:14%;"><label>Product</label></th>
					<th rowspan="<?php echo $rowspan; ?>" style="width:23%;"><label>Manufacturer | Batch | Quantity | Priority <span style="color:red">*</span></label></th>
					<th rowspan="<?php echo $rowspan; ?>" style="width:5%;"><label>Location</label></th>
					<th rowspan="<?php echo $rowspan; ?>" style="width:6%;"><label>VVM Stage</label></th>
					<th rowspan="<?php echo $rowspan; ?>" style="width:8%"><label>Expiry Date</label></th>
					<?php if($showreq){?>
						<th colspan="<?php echo $colspan; ?>" style="background-color: #105f4e;width:28%"><label>Automatic Stock Requisition</label></th>
					<?php }?>
					<th rowspan="<?php echo $rowspan; ?>" style="#105f4e;width:11%"><label>Issuance Quantity <span style="color:red">*</span></label></th>
					<th rowspan="<?php echo $rowspan; ?>" style="width:4%"><label>Action</label></th>
				</tr>
				<?php if($showreq){?>
					<tr>
						<th style="background-color: #105f4e;" rowspan="<?php echo ceil($rowspan/2); ?>"><label>Suggested <span title="Maximum stock level at selected store for apprx <?php echo $noOfDays; ?> days." class="glyphicon glyphicon-info-sign moonicon" style="top:3px;" aria-hidden="true"></span></label></th>
						<th style="background-color: #105f4e;" colspan="<?php echo $colspan/2; ?>"><label>Available <span title="Available balance in selected store" class="glyphicon glyphicon-info-sign moonicon" style="top:3px;" aria-hidden="true"></span></label></th>
						<th style="background-color: #105f4e;" rowspan="<?php echo ceil($rowspan/2); ?>"><label>Requisition <span title="Stock Needed at selected store to fullfill basic requirement of available stock." class="glyphicon glyphicon-info-sign moonicon" style="top:3px;" aria-hidden="true"></span></label></th>
					</tr>
				<?php }?>
				<?php if($showbothavailable){?>
					<tr>
						<th style="background-color: #105f4e;"><label>District <span title="Available balance in district store" class="glyphicon glyphicon-info-sign moonicon" style="top:3px;" aria-hidden="true"></span></label></th>
						<th style="background-color: #105f4e;"><label>Facility <span title="Available balance in facilitiy stores according to last submitted report" class="glyphicon glyphicon-info-sign moonicon" style="top:3px;" aria-hidden="true"></span></label></th>
					</tr>
				<?php }?>
			</thead>
			<tbody>
				<?php foreach($vaccinesDetails as $key=>$singleVacc){
					$prodid = $singleVacc["pk_id"]; ?>
					<tr>
						<td>
							<span class="pull-left prodtitle"><?php echo trim($singleVacc["item_name"]); ?></span>
							<input 
								name="product[<?php echo $prodid; ?>][id]" 
								id="product<?php echo $prodid; ?>" 
								value="<?php echo $prodid; ?>"
								class="product" 
								data-unitid="<?php echo $singleVacc["item_unit_id"]; ?>" 
								data-unittitle="<?php echo $singleVacc["unitname"]; ?>" 
								data-formrownum="<?php echo $singleVacc["cr_table_row_numb"]; ?>" 
								data-doses="<?php echo $singleVacc["number_of_doses"]; ?>" 
								data-categoryid="<?php echo $singleVacc["item_category_id"]; ?>" 
								type="hidden" >
						</td>
						<td>
							<select name="batch[<?php echo $prodid; ?>][]" class="batch form-control" required="required">
								<?php echo $singleVacc["mnfctrhtml"]; ?>
							</select>
						</td>
						<td>
							<span class="location pull-left"></span>
							<input name="vvm_loc[<?php echo $prodid; ?>][]" class="vvm_locinput form-control" type="hidden"></select>
							<!--<select name="vvm_loc[<?php //echo $prodid; ?>][]" class="vvm_loc form-control" required="required"></select>-->
						</td>
						<td>
							<span class="vvmstage pull-left"></span>
						</td>
						<td>
							<span class="expiry_date"></span>
						</td>
						<?php if($showreq){?>
							<td style="background-color: #c7dad6; ">
								<span class="requiredcard">0</span>
							</td>
							<?php if($showbothavailable){?>
								<td style="background-color: #c7dad6; ">
									<span class="diststoreavail">0</span>
								</td>
								<td style="background-color: #c7dad6; ">
									<span class="facstoreavail">0</span>
								</td>
							<?php }else{?>
								<td style="background-color: #c7dad6; ">
									<span class="availablecard">0</span>
								</td>
							<?php }?>
							<td style="background-color: #c7dad6; ">
								<span class="requestcard">0</span>
							</td>
						<?php }?>
						<td>
							<input name="quantity[<?php echo $prodid; ?>][]" class="form-control numberclass quantity" required="required" type="text">
							<span  class="unittext" style="float: right;margin-top: -27px;margin-right: 2px;"><?php echo $singleVacc["unitname"]; ?></span>
							<input type="hidden" class="item_unit_id" name="item_unit_id[<?php echo $prodid; ?>][]" value="<?php echo $singleVacc["item_unit_id"]; ?>" >
						</td>
						<td>
							<button type="button" class="btn btn-success btn-xs cloneadd" data-original-title="add new Batch"><i class="fa fa-plus"></i></button>
						</td>
					</tr><?php 
				}?>
			</tbody>
		</table>
	</div>
</div>
<div class="row">      
	<div style="text-align: right;" class="col-md-12">
		<span style="color:red" class="pull-left"><b>Note: </b>Only those products/batches are showing in above table which have atleast 1 vials/pieces available in stock.</span>
		<button style="background:#008d4c;" type="button" id="issuebtn" class="btn btn-primary btn-md" role="button"><i class="fa fa-plus "></i> Add Issue </button>
	</div>
</div>