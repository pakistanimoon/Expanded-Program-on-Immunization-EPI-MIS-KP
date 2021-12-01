<?php 
class Child_model extends CI_Model {
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
	function delete_child_record($recno){
		$result = $this -> db -> query("update cerv_child_registration set deleted_at=now() where recno={$recno}");
		$recnoUpdateResult = $this -> db -> query("update cerv_child_registration set recno=nextval('child_registration_seq') where recno={$recno}");
		if($this -> db -> affected_rows() > 0)
			return true;
		return false;
	}
	
	function updateSequence($recno){
		$this -> db -> query("UPDATE cerv_child_registration SET recno=nextval('child_registration_seq') where recno = '{$recno}'");
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function Child_Registration($title,$data,$per_page,$startpoint){
		//$wc = $data;
		//	print_r($facode);exit; 
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=permanent_register.xls");
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
		$defaultersWc = ' AND
							deleted_at IS NULL';
		if($data['defaulters'] == 1){
			$date = date('Y-m-d');
			$defaultersWc = "
								AND
								deleted_at IS NULL
								AND 
								((opv1 IS NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								(rota1 IS NULL AND rota2 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								(pcv1 IS NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								(penta1 IS NULL AND penta2 IS NULL AND penta3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								
								(opv1 IS NOT NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= opv1 + interval '30' day) OR
								(rota1 is NOT NULL AND rota2 IS NULL AND '{$date}'::date >= rota1 + interval '30' day) OR
								(pcv1 IS NOT NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv1 + interval '30' day) OR
								(penta1 IS NOT NULL AND penta2 IS NULL AND penta3 is NULL AND '{$date}'::date >= penta1 + interval '30' day) OR
								
								(opv2 IS NOT NULL AND opv3 IS NULL AND '{$date}'::date >= opv2 + interval '30' day) OR
								(ipv IS NULL AND '{$date}'::date >= dateofbirth + interval '99' day) OR
								(pcv2 IS NOT NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv2 + interval '30' day) OR
								(penta2 IS NOT NULL AND penta3 IS NULL AND '{$date}'::date >= penta2 + interval '30' day) OR
								
								(measles1 IS NULL AND measles2 IS NULL AND '{$date}'::date >= dateofbirth + interval '1 month'*9 + interval '1' day) OR
								(measles1 IS NOT NULL AND measles2 IS NULL AND '{$date}'::date >= measles1 + interval '30' day AND '{$date}'::date >= dateofbirth + interval '1 year' + interval '1 month'*3 + interval '1' day))
			";
		}
		$query="select recno,child_registration_no,cardno as childcode, nameofchild as name_of_child, dateofbirth as date_of_birth,
		unname(uncode) as unioncouncil, contactno, villagename (villagemohallah) as villagemohallah,(case when gender='m' then 'Male' else 'Female' end) as \"Gender\", fathername as fname,
		address as address, bcg, hepb, opv0, opv1, penta1, pcv1 as pcv10_1, opv2, penta2,
		pcv2 as pcv10_2, opv3, penta3, pcv3 as pcv10_3, ipv, rota1, rota2, measles1, measles2 
		from cerv_child_registration where ".$wc." {$defaultersWc} 
		ORDER BY 
			CASE 
				WHEN date_part('year', bcg) IS NOT NULL 
					THEN date_part('year', bcg) 
				WHEN date_part('year', opv1) IS NOT NULL
					THEN date_part('year', opv1)
				ELSE
					date_part('year', dateofbirth)
				END ASC, NULLIF(regexp_replace(cardno, '\D', '', 'g'), '')::int ";
			
		//date_part('year', bcg), NULLIF(regexp_replace(cardno, '\D', '', 'g'), '')::int  "; //date_part('year', bcg) DESC, bcg DESC, date_of_birth DESC ";
		/* WHEN date_part('year', opv2) IS NOT NULL
					THEN date_part('year', opv2)
				WHEN date_part('year', opv3) IS NOT NULL
					THEN date_part('year', opv3)
				WHEN date_part('year', measles1) IS NOT NULL
					THEN date_part('year', measles1) */ 
		if( ! $this -> input -> post('export_excel')){
			$query .= "LIMIT {$per_page} OFFSET {$startpoint}"; 
		}
		$result=$this->db->query($query);
        //$str = $this->db->last_query();
		//print_r($str); exit;
		$dataReturned["PVRresult"]=$result->result_array();
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$queryTotal = 'select count(*) as total from cerv_child_registration';
		$resultTotal=$this->db->query($queryTotal);
		$data['allDataTotal']=$resultTotal->result_array();
		$dataReturned['pageTitle']='Children Registration';
		//$dataReturned['reportdate']=getListingReportTable($dataReturned["tableData"],'',$data['allDataTotal'],'');
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		$dataReturned["defaulters"]=$data['defaulters'];
		//$dataReturned['year'] = $data['year'];
		return $dataReturned;
	}
	public function child_cardview($child_registration_no){
		$query="select *,villagename(villagemohallah) as villagename, coalesce(unname(uncode),'') as unioncouncil,coalesce(districtname(distcode),'') as district, coalesce(tehsilname(tcode),'') as tehsil,facilityname(reg_facode) as facilityname,hr_name(techniciancode) as technicianname from cerv_child_registration where child_registration_no = '$child_registration_no'";
		$result = $this -> db -> query($query);
		$data['childDataview'] = $result -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
        return $data;
	}
	public function map_view($data,$longitude){
		//print_r($data); exit; 
		$latitude = substr($data, 0, 8);
		$longitude = substr($longitude, 8, 16);
	    $query="select * from cerv_child_registration where latitude='$latitude' or longitude='$longitude'";
		$result = $this -> db -> query($query);
		$data = $result -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
        return $data; 
	}

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