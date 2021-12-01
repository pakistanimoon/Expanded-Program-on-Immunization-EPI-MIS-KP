<?php 
class Common_model extends CI_Model {
	//---------------- Constructor function Starts Here -------------------//
	public function __construct() {
		parent::__construct();
	}
	//---------------- Constructor Function Ends Here ---------------------//
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
		//$result = array_column($records, "transaction_number");
		return $records;
	}
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
	public function insert_record($table, $data,$sequencename=NULL){
		//echo "<pre>"; print_r($data);exit;
		$this->db->insert($table,$data);
		return $this->db->insert_id($sequencename);
	}
//============== Function to fetch row ends===========//
	//=============update record from table function starts=============//
	public function update_record($table, $data,$where){
		$this->db->where($where);
		$update=$this->db->update($table,$data);
	
	}
} //class ends
?>