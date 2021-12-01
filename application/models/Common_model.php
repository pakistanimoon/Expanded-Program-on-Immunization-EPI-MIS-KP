<?php 
//local
/**************************************************************************/
/******************** This Class will Provide Common   ********************/
/******************** functions containing basic       ********************/
/******************** sketch for CRUD Operation.       ********************/
/******************** Author: Raja Imran Qamer Gakhar  ********************/
/******************** Email: rajaimranqamer@gmail.com  ********************/
/**************************************************************************/
class Common_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
        $this->load->helper('my_functions_helper');
		$this -> load -> helper('epi_functions_helper');
	}
	//================ Constructor Function Ends Here ===========================//
	function authentication()
	{
		if ($_SESSION["UserAuth"]!="Yes"){
			return 404;
			exit();
		}else if($_SESSION['expire'] >=time()){
		 	$timeout1 = $_SESSION['expire'] - time();
			$reset_time = round((3600 - $timeout1));
  			$_SESSION['expire'] = time() + (60 * 120); 
		}else{
			return 404;
			exit();
		}		
	}
	function monthname($month){
		switch($month){
			case "01": return "January";
				break;
			case "02": return "February";
				break;
			case "03": return "March";
				break;
			case "04": return "April";
				break;
			case "05": return "May";
				break;
			case "06": return "June";
				break; 
			case "07": return "July";
				break;
			case "08": return "Auguest";
				break;
			case "09": return "September";
				break;
			case "10": return "October";
				break;
			case "11": return "November";
				break;
			case "12": return "December";				
		}
	}
	function pagination($query,$per_page=100,$page=1,$url='?',$w='',$GroupId = NULL){
		//print_r($w);exit();
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
		//echo $query;exit();
	    $rs=$this->db->query($query);
	    $row=$rs->row_array();
	    $total = $row['num'];
	    //print_r($total);exit;
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
	        if ($lastpage < 7 + ($adjacents * 2)){
	            for ($counter = 1; $counter <= $lastpage; $counter++){
	                if ($counter == $page)
	                    $pagination.= "<li class='active'><a>{$counter} <span class=\"sr-only\">(current)</span></a></li>";
	                else
	                    $pagination.= "<li><a id='$counter' class='paginateMe'  href='{$url}page={$counter}'>{$counter}</a></li>";                    
	            }
	        } elseif($lastpage > 5 + ($adjacents * 2)){
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
	            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
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
	            } else {
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
	//=============Common all the data in dropdowns=============//
	public function dropdown($table , $field,$where=NULL)
	{
		$this->db->select('*');
		if($where){
			$this->db->where($where);
		}
		$records=$this->db->get($table);
		$data=array();
		foreach($records->result() as $row)
		{
			$data[$row->id] = $row->$field;
		}
		return ($data);
	}
	//================== dropdown Common ends==================//
	function browser() {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$browsers = array('Chrome' => array('Google Chrome', 'Chrome/(.*)\s'), 'MSIE' => array('Internet Explorer', 'MSIE\s([0-9\.]*)'), 'Firefox' => array('Firefox', 'Firefox/([0-9\.]*)'), 'Safari' => array('Safari', 'Version/([0-9\.]*)'), 'Opera' => array('Opera', 'Version/([0-9\.]*)'));
		$browser_details = array();
		foreach ($browsers as $browser => $browser_info) {
			if (preg_match('@' . $browser . '@i', $user_agent)) {
				$browser_details['name'] = $browser_info[0];
				preg_match('@' . $browser_info[1] . '@i', $user_agent, $version);
				$browser_details['version'] = $version[1];
				break;
			} else {
				$browser_details['name'] = 'Unknown';
				$browser_details['version'] = 'Unknown';
			}
		}
		return 'Browser: ' . $browser_details['name'] . ' Version: ' . $browser_details['version'];
	}
	//=============List all records function starts=============//
	public function fetchall($table, $arr=NULL, $range=NULL, $where=NULL, $groupby=NULL,$orderby=NULL,$like=NULL,$whereinarr=NULL,$limit=NULL)
		{
		if($range){
			$this->db->select($range);
		}else{
			$this->db->select('*');
		}
		if($arr){
			$rightsidecol = isset($arr['tablecol'])?$arr['tablecol']:"id";
			$type = isset($arr['jointype'])?$arr['jointype']:"left outer";
			$this->db->join($arr['table'], $table.'.'.$arr['id'].' = '.$arr['table'].'.'.$rightsidecol,$type);
		}
		if($where){
			$this->db->where($where);
		}
		if($whereinarr){
			$this->db->where_in($whereinarr['columname'],$whereinarr['valuesarray']);
		}
		if($groupby){
			$this->db->group_by($groupby);
		}
		if($orderby){
			$this->db->order_by($orderby['by'],$orderby['type']);
		}
		if($like){
			$this->db->like($like);
		}
		if($limit){
			$this->db->limit($limit);
		}
		$records = $this->db->get($table)->result_array();
		// echo $this->db->last_query(); exit;
		return $records;
	}
	//=============List all records function ends=============//
	//============== Function to fetch a row starts===========//
	public function get_info($tablename, $id=NULL, $field=NULL,$range=NULL,$whereArray=NULL,$orderby=NULL, $groupby=NULL, $arr=NULL){
		if($range){
			$this->db->select($range);
		}else{
			$this->db->select('*');
		}
		if($arr){
			$rightsidecol = isset($arr['tablecol'])?$arr['tablecol']:"id";
			$this->db->join($arr['table'], $tablename.'.'.$arr['id'].' = '.$arr['table'].'.'.$rightsidecol,'left outer');
		}
		if($whereArray){
			$this->db->where($whereArray);
		}else{
			if($field){
				$this->db->where($field, $id);
			}else{
				$this->db->where('id', $id);
			}
		}
		if($orderby){
			$this->db->order_by($orderby['by'],$orderby['type']);
		}
		if($groupby){
			$this->db->group_by($groupby);
		}
		$query = $this->db->get($tablename)->row();
		return $query;
	}
	//============== Function to fetch row ends===========//
	//=============getlocation function starts=============//
	public function get_by_limit($table,$limit,$start)
	{
		$records = $this->db->get($table,$limit,$start)->result_array();
		//echo $this->db->last_query(); exit;
		return $records;
	}
	//=============getlocation function ends=============//
	//=============count records function starts=============//
	public function count_record($table,$where=NULL, $joinarr=NULL)
	{
		if($joinarr){
			$rightsidecol = isset($joinarr['tablecol'])?$joinarr['tablecol']:"id";
			$this->db->join($joinarr['table'], $table.'.'.$joinarr['id'].' = '.$joinarr['table'].'.'.$rightsidecol,'left outer');
		}
		if($where){
			$this->db->where($where);
		}
		$records = $this->db->get($table);
		return $records->num_rows();
	}
	//=============count records function ends=============//
	//=============Delete record from table function starts=============//
	public function delete_record($table, $id, $field=NULL){
		if($field){
		$this->db->where($field, $id);
		}else{
		$this->db->where('id', $id);
		}
		$delete=$this->db->delete($table);
	}
	//=============update record from table function starts=============//
	
	public function update_record($table, $data,$where){
		$this->db->where($where);
		$update=$this->db->update($table,$data);	
	}
	//=============update record from table function ends===============//
	//=============delete_record_multiple_colum record from table function starts=============//
	public function delete_record_multiple_colum($table,$where){
		$this->db->where($where);
		$update=$this->db->delete($table);
	}
	//=============delete_record_multiple_colum record from table function ends===============//
	public function insert_record($table, $data,$sequencename=NULL){
		$this->db->insert($table,$data);
		return $this->db->insert_id($sequencename);
	}
	public function insert_nonpk_record($table, $data,$col){
		$this->db->insert($table,$data);
		return $data[$col];
	}
	//=============update record from table function ends===============//
	public function insert_batch_record($table, $data){
		$this->db->insert_batch($table, $data);
		return true;
	}
	//=============insert batch record into table function ends===============//
} //class ends
?>