<?php 
$from_warehouse_type_id = $this->session->curr_wh_type;
$from_warehouse_code = $this->session->curr_wh_code;
$outputdata = '';
$batchexist = (isset($draftdata) and count($draftdata["batch"]))?true:false;
if($batchexist){
	foreach($draftdata["batch"] as $key=>$onebatch){
		$outputdata .= '<tr>
			<td>'.date("Y-m-d",strtotime($draftdata["master"]->transaction_date)).'</td>
			<td>'.get_product_name(TRUE,$onebatch["item_pack_size_id"]).'</td>
			<td>'.$draftdata["detail"][$key]["item_unit_name"].'</td>
			<td>'.get_store_name(true,$from_warehouse_type_id,$from_warehouse_code).'</td> 
			<td>'.get_store_name(true,$onebatch["warehouse_type_id"],$onebatch["code"]).'</td>
			<td>'.$onebatch["quantity"].'</td>
			<td>'.$onebatch["number"].'</td>
			<td>'.$onebatch["expiry_date"].'</td>
			<td>';
		if($onebatch["status"]!='Finished'){
			$outputdata .= '<span data-id="'.$onebatch["pk_id"].'" data-masterid="'.$draftdata["master"]->pk_id.'" class="fa fa-times cursor-hand actiondel" style="cursor:pointer"></span>';
		}
		$outputdata .= '</td>
		</tr>';
	}
	$outputdata .='<tr>
		<td colspan="10" ></br>
			<form name="issue_stock" id="issue_stock" action="'.base_url("saveInvnIssue").'" method="POST">
				<b>Comments (Max 300 Char)</b>
				<textarea name="comments" id="comments" class="form-control" rows="2" maxlength="300" cols="80"></textarea>
				<div class="row">
					<div style="text-align: left;margin-top:10px" class="col-md-6 col-sm-6 col-xs-6">
						<a href="'.base_url("StockIssue").'" class="btn btn-info btn-md"><i class="fa fa-arrow-left"></i> Issued List </a>
					</div>
					<div style="text-align: right;margin-top:10px" class="col-md-6 col-sm-6 col-xs-6">
						<button style="background:#008d4c;" id="stock_issue_dispatch_list" type="button" class="btn btn-primary btn-md" role="button"><i class="fa fa-print "></i> Print</button>
						<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button" onclick="return confirm(\'Are you sure you want to save the list?\');"><i class="fa fa-floppy-o"></i> Dispatch </button>
					</div>
				</div>
			</form>
		</td>
	</tr>';
}
if(isset($return) && $return){
	return $outputdata;
}else{
	echo $outputdata;
}?>