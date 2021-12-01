<?php 
$outputdata = '';
$batchexist = (isset($draftdata) and count($draftdata["batch"]))?true:false;
$checksum = array();
if($batchexist){
	foreach($draftdata["batch"] as $key=>$onebatch){
		$catid = $onebatch["item_category_id"];
		if(isset($checksum[$catid])){
			$checksum[$catid]["vials"] = $checksum[$catid]["vials"]+$onebatch["quantity"];
			$checksum[$catid]["doses"] = $checksum[$catid]["doses"]+($onebatch["quantity"]*$onebatch["number_of_doses"]);
		}else{
			$checksum[$catid]["vials"] = $onebatch["quantity"];
			$checksum[$catid]["doses"] =($onebatch["quantity"]*$onebatch["number_of_doses"]);
		}
		$outputdata .= '<tr>
			<td>'.date("Y-m-d",strtotime($draftdata["master"]->transaction_date)).'</td>
			<td>'.get_funding_source_name(TRUE,$draftdata["master"]->from_warehouse_code).'</td>
			<td>'.get_product_name(TRUE,$onebatch["item_pack_size_id"]).'</td>
			<td>'.$onebatch["number"].'</td>
			<td>'.$onebatch["quantity"].'</td>
			<td>'.$draftdata["detail"][$key]["item_unit_name"].'</td>
			<td>'.get_manufacturer_name(TRUE,$onebatch["stakeholder_id"]).'</td>
			<td>'.(isset($onebatch["ccm_id"])?get_ccm_name(TRUE,$onebatch["ccm_id"]):get_non_ccm_name(TRUE,$onebatch["non_ccm_id"])).'</td>
			<td>'.$onebatch["expiry_date"].'</td>
			<td><span data-id="'.$onebatch["pk_id"].'" data-masterid="'.$draftdata["master"]->pk_id.'" class="fa fa-times cursor-hand actiondel" style="cursor:pointer"></span></td>
		</tr>';
	}
	$outputdata .='<tr>
		<td colspan="10"><b>Checksum (All Products)</b><br>';
		foreach($checksum as $key=>$val){
			$title = "";
			switch($key){
				case "1":
					$title="Vaccine";
					break;
				case "2":
					$title="Non-Vaccines";
					break;
				case "3":
					$title="Diluent";
					break;
				case "4":
					$title="Inactive Vaccines";
					break;
			}
			$outputdata .= '<br><b>'.$title.' [Vials/Pcs: '.$val["vials"].' Doses: '.$val["doses"].']</b>';
		}
	$outputdata .= '</td>
	</tr>
	<tr>
		<td colspan="10" ></br><form name="receive_stock" id="receive_stock" action="'.base_url().'" method="POST">
		<b>Comments (Max 300 Char)</b>
		<textarea name="comments" id="comments" class="form-control" rows="2" maxlength="300" cols="80"></textarea>
		<div class="row">      
			<div style="text-align: right;margin-top:10px" class="col-md-6 col-md-offset-6 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
				<button style="background:#008d4c;" type="button" id="stock_recieveFrom_supplier_list" class="btn btn-primary btn-md" role="button"><i class="fa fa-print "></i> Print</button>
				<button style="background:#008d4c;" type="button" id="savebtn"  class="btn btn-primary btn-md" role="button" ></i> Save</button>
				
			</div>
		</div>
		</td>
	</tr>';
}
if(isset($return) && $return){
	return $outputdata;
}else{
	echo $outputdata;
}?>