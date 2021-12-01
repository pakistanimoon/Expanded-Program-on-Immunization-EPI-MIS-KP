<?php
class Ajax_hr_management_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('cross_notify_functions_helper');
	}
	public function hr_list_filter($level,$utype,$status)
	{
		$procode = isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
		if($this-> session-> District){
			$distcode = $this-> session-> District;
			$wc = getWC_Array($_SESSION["Province"], $distcode);
		}
		else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 5;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = " hr_db_history ";

		if($distcode > 0){
			$wc[] = " pre_distcode = '$distcode' ";
		}
		if($level != "0"){
			$wc[] = " level = '$level' ";
		}
				
		if($utype != "0"){
			$wc[] = " pre_hr_sub_type_id = '$utype' ";
		}
		if($status != "0"){
			$wc[] = " pre_status = '$status' ";
		}
		//print_r($wc);exit();
		// Change `records` according to your table name.
		//echo		
		$query="SELECT id,name, pre_hr_sub_type_id, phone, nic, pre_status ,employee_type ,created_date ,level FROM hr_db_history " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by created_date DESC LIMIT {$per_page} OFFSET {$startpoint}";
		//print_r($query);exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = '';
		foreach ($result as $row) {
			$i++;
			$link = (isset($row['name']) && $row['name'] != '')?$row['name']: '';			
			$tbody .= '<tr id="row_'.$row['name'].'" class="DrilledDown">
							<td class="text-center  order">'.$i.'</td>
							<td class="text-center">'.$row['name'].'</td>
							<td class="text-center">'.$row['hr_type_id'].'</td>
							<td class="text-center">'.$row['phone'].'</td>    
							<td class="text-center">'.$row['nic'].'</td>    
							<td class="text-center">'.$row['status'].'</td>    
							<td class="text-center">'.$row['employee_type'].'</td>    
							<td class="text-center">'.$row['created_date'].'</td>    
							<td class="text-center">								
								<a href="' .base_url(). 'Hr_management/hr_edit_get/'.$row['id'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
								<a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user(\''.$row['id'].'\');" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>
							</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		//echo $tbody; exit;
		$wc = implode(" AND ", $wc);
		//print_r($wc);exit();
		//$wc = getWC();
		$resultJson["paging"] = $this-> Common_model-> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson,true);
	}
	public function sub_type_options($type_val){
		$query="SELECT id, title, type_id from hr_sub_types where hr_type_id ={$type_val}";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$option = "";
		foreach ($result as $key => $value)
		{
			$option .= '<option value="' . $value['type_id'] . '" >' . $value['title'] .'</option>';
		}
		return $option;
	}
}
