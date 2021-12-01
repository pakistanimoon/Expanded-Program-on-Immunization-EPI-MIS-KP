<?php 
class Women_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> helper('my_functions_helper');
		$this -> load -> model('Filter_model');
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> helper('indicator_functions_helper');
		$this -> load -> model('Common_model');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function Women_Registration($title,$data,$per_page,$startpoint){
		//$wc = $data;
		//	print_r($facode);exit; 
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=registeredwomen.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here 
        }
        
		//unset($wc['export_excel']);
		$facode = $data['facode'];
		$uncode = $data['uncode'];
		$distcode = $data['distcode'];
 	  	if (isset($_SESSION['Province'])) {
			$wc = "  procode = '" . $_SESSION['Province'] . "' ";
		}
		if($distcode > 0)
		{	
			$wc = "distcode= '".$data['distcode']."'";
		}
		if(isset($data['tcode']) AND $data['tcode'] > 0){
			$wc = "tcode= '".$data['tcode']."'";
		}
		if(isset($data['uncode']) AND $data['uncode'] > 0){
			$wc = "uncode= '".$data['uncode']."'";
		}
		if(isset($data['facode']) AND $data['facode'] > 0){
			$wc = "reg_facode= '".$data['facode']."'";
		}
		if(isset($data['technician']) AND $data['technician'] > 0){
			$wc = "techniciancode= '".$data['technician']."'";
		}
		$data['techniciancode'] = $data['technician'];
		//echo $wc;exit;

		$defaultersWc = '';
		//echo $defaultersWc; exit;
		if($data['defaulters'] == 1){
			$date = date('Y-m-d');
			$defaultersWc = "
					AND ((tt1 is null and tt2 is null and tt3 is null and tt4 is null and tt5 is null) or
					(tt1 is not null and tt2 is null and tt3 is null and tt4 is null and tt5 is null  AND '{$date}'::date >= tt1) or
					(tt2 is not null and tt3 is null and tt4 is null and tt5 is null  AND '{$date}'::date >= tt1 + interval '30' day) or
					(tt3 is not null and tt4 is null and tt5 is null AND '{$date}'::date >= tt2 + interval '1 month'*6) or
					(tt4 is not null and tt5 is null AND '{$date}'::date >= tt3 + interval '1 year')					
					)";
		}
		
		$query="select recno,mother_registration_no,cardno as mothercode, mother_name, mother_age, unname(uncode) as unioncouncil, contactno, village, husband_name,
		house as address, tt1,tt2,tt3,tt4,tt5
		from cerv_mother_registration where ".$wc." {$defaultersWc} order by cardno LIMIT {$per_page} OFFSET {$startpoint}"; 
		$result=$this->db->query($query);
        // $str = $this->db->last_query();
		// print_r($str); exit();
		$dataReturned["PVRresult"]=$result->result_array();
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$queryTotal = 'select count(*) as total from cerv_mother_registration';
		$resultTotal=$this->db->query($queryTotal);
		$data['allDataTotal']=$resultTotal->result_array();
		$dataReturned['pageTitle']='Women Registration';
		//$dataReturned['reportdate']=getListingReportTable($dataReturned["tableData"],'',$data['allDataTotal'],'');
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		$dataReturned["defaulters"]=$data['defaulters'];
		//$dataReturned['year'] = $data['year'];
		return $dataReturned;
	}
	// public function women_cardview($child_registration_no){
	// 	$query="select *,coalesce(unname(uncode),'') as unioncouncil,coalesce(districtname(distcode),'') as district, coalesce(tehsilname(tcode),'') as tehsil,facilityname(reg_facode) as facilityname,hr_name(techniciancode) as technicianname from cerv_child_registration where child_registration_no = '$child_registration_no'";
	// 	$result = $this -> db -> query($query);
	// 	$data['childDataview'] = $result -> result_array();
	// 	//$str = $this->db->last_query();
	// 	//print_r($str); exit;
    //     return $data;
	// }
	// public function map_view($data,$longitude){
	// 	//print_r($data); exit; 
	// 	$latitude = substr($data, 0, 8);
	// 	$longitude = substr($longitude, 8, 16);
	//     $query="select * from cerv_child_registration where latitude='$latitude' or longitude='$longitude'";
	// 	$result = $this -> db -> query($query);
	// 	$data = $result -> result_array();
	// 	//$str = $this->db->last_query();
	// 	//print_r($str); exit;
    //     return $data; 
	// }

function pagination($query,$per_page=100,$page=1,$url='?',$w='',$GroupId = NULL){   
	if($w==''){
	    $wc=getWC();
	}else
		{
  		$wc=$w;
		}
	if($GroupId)
		$query = "select count(DISTINCT ".$GroupId.") as num  FROM {$query} WHERE  ".$wc;
	else
		$query = "select count(*) as num  FROM {$query} WHERE  ".$wc;
		//echo $query;exit;
		$rs=$this->db->query($query);
		$row=$rs->row_array();
		$total = $row['num'];
		/*  print_r($total);
		exit;  */
		$adjacents = "2"; 
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$lastlabel = "Last &rsaquo;&rsaquo;";
		$page = ($page == 0 ? 1 : $page);  
		$start = ($page - 1) * $per_page;                               
		$prev = $page - 1;                          
		$next = $page + 1;
		$lastpage = ceil($total/$per_page);
		//$lastpageid = $lastpage + 1;
		$lpm1 = $lastpage - 1; // //last page minus 1
		$pagination = "";
    if($lastpage > 1){   
        $pagination .= '<div class="row"><div align="center" class="col-sm-12"><ul class="pagination">';
        //$pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";
        if ($page > 1) $pagination.= "<li><a id='$prev' class='paginateMe' href='{$url}page={$prev}'>{$prevlabel}</a></li>";
        if($lastpage < 7 + ($adjacents * 2)){   
        for ($counter = 1; $counter <= $lastpage; $counter++){
        if ($counter == $page)
        $pagination.= "<li class='active'><a>{$counter} <span class=\"sr-only\">(current)</span></a></li>";
        else
        $pagination.= "<li><a id='$counter' class='paginateMe'  href='{$url}page={$counter}'>{$counter}</a></li>";                    
        }
        }elseif($lastpage > 5 + ($adjacents * 2)){
        if($page < 1 + ($adjacents * 2)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
		if ($counter == $page)
		$pagination.= "<li class='active'><a>{$counter}</a></li>";
		else
		$pagination.= "<li><a  id='$counter' class='paginateMe'  href='{$url}page={$counter}'>{$counter}</a></li>";                    
		}
		$pagination.= "<li class='dot'>...</li>";
		$pagination.= "<li><a id='$lpm1' class='paginateMe'  href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
		$pagination.= "<li><a id='$lastpage' class='paginateMe'  href='{$url}page={$lastpage}'>{$lastpage}</a></li>";  
	}elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
		$pagination.= "<li><a id='1' class='paginateMe'  href='{$url}page=1'>1</a></li>";
		$pagination.= "<li><a  id='2' class='paginateMe'  href='{$url}page=2'>2</a></li>";
		$pagination.= "<li class='dot'>...</li>";
		for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page)
		$pagination.= "<li class='active'><a>{$counter} <span class=\"sr-only\">(current)</span></a></li>";
		else
		$pagination.= "<li><a id='$counter' class='paginateMe'  href='{$url}page={$counter}'>{$counter}</a></li>";                    
		}
		$pagination.= "<li class='dot'>..</li>";
		$pagination.= "<li><a id='$lpm1' class='paginateMe'  href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
		$pagination.= "<li><a id='$lastpage' class='paginateMe'  href='{$url}page={$lastpage}'>{$lastpage}</a></li>";      
	}else {
		$pagination.= "<li><a id='1' class='paginateMe'  href='{$url}page=1'>1</a></li>";
		$pagination.= "<li><a id='2' class='paginatemM'  href='{$url}page=2'>2</a></li>";
		$pagination.= "<li class='dot'>..</li>";
		for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
		if ($counter == $page)
		$pagination.= "<li class='active'><a>{$counter} <span class=\"sr-only\">(current)</span></a></li>";
		else
		$pagination.= "<li><a id='$counter' class='paginateMe'  href='{$url}page={$counter}'>{$counter}</a></li>";                    
	}
		} 
			}
        if ($page < $counter - 1) {
        $pagination.= "<li><a id='$next' class='paginateMe'  href='{$url}page={$next}'>{$nextlabel}</a></li>";
        $pagination.= "<li><a id='$lastpage' class='paginateMe'  href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
    }
        $pagination.= "</ul></div></div>";        
		}
    return $pagination;
	}
	
		}
?>