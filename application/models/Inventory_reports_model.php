<?php
class Inventory_reports_model extends CI_Model {
	// ================ Constructor function Starts Here ================== //
	public function __construct() {
		parent::__construct();
		//$this -> load -> helper('my_functions_helper');
		$this -> load -> model('Filter_model');
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> helper('inventory_helper');
	}
	// ================ Constructor Function Ends Here ==================== //
	public function getprevbalance($startdate,$whtype,$whcode) {

		//$current_whcode=$this->session->curr_wh_code;
		//$current_whcode = substr($current_whcode,0,1);
		$current_whcode = $this -> session -> Province;
		if($whcode=="all")
		{
			$whererec 	="master.to_warehouse_type_id = '".$whtype."' and master.to_warehouse_code like '$current_whcode%'";
			$whereissue ="master.from_warehouse_type_id = '".$whtype."' and master.from_warehouse_code like '$current_whcode%'";
		}else{
			$whererec ="master.to_warehouse_type_id = '".$whtype."' and master.to_warehouse_code='$whcode'";
			$whereissue ="master.from_warehouse_type_id = '".$whtype."' and master.from_warehouse_code='$whcode'";
		}
		//query
		$this->db->select("master.stakeholder_activity_id || '-' || item_pack_size_id as id,sum(case when tt.nature = '1' AND $whererec then batch.quantity else 0 end)-sum(case when tt.nature = '0' AND $whereissue then batch.quantity else 0 end) as balance",FALSE);
		$this->db->from("epi_stock_batch_history batch");
		$this->db->join("epi_stock_master_history master","master.master_id = batch.batch_master_id");
		$this->db->join("epi_transaction_types tt","tt.pk_id = master.transaction_type_id");
		$this->db->join("epi_item_pack_sizes sizes","sizes.pk_id = batch.item_pack_size_id");
		$this->db->where("master.transaction_date < ",$startdate);
	//	$this->db->where("sizes.item_category_id",'1');
		$this->db->where("master.draft",'0');
		$this->db->group_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		$this->db->order_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		$result = $this->db->get()->result_array();
	//	echo "<pre>"; print_r($this->db->last_query());exit;
		return $result;
		
	}
	public function getintervalReceive($startdate,$enddate,$whtype,$whcode) {		
		/*for all province*/
		//$current_whcode=$this->session->curr_wh_code;
		//$current_whcode = substr($current_whcode,0,1);
		$current_whcode = $this -> session -> Province;
		//receive
		if($whcode=="all")
		{
		$whereissue ="master.to_warehouse_type_id = '".$whtype."' and master.to_warehouse_code like '$current_whcode%'";
		}
		else
		{
		$whereissue ="master.to_warehouse_type_id = '".$whtype."' and master.to_warehouse_code='$whcode'";	
		}
		$this->db->select("item_pack_size_id as id,sum(batch.quantity) as balance",FALSE);
		$this->db->from("epi_stock_batch_history batch");
		$this->db->join("epi_stock_master_history master","master.master_id = batch.batch_master_id");
		$this->db->join("epi_transaction_types tt","tt.pk_id = master.transaction_type_id");
		$this->db->join("epi_item_pack_sizes sizes","sizes.pk_id = batch.item_pack_size_id");
		$this->db->where("master.transaction_date >= ",$startdate);
		$this->db->where("master.transaction_date <= ",$enddate);
		//$this->db->where("sizes.item_category_id",'1');
		$this->db->where("master.draft",'0');
		$this->db->where("master.transaction_type_id",'1');
		$this->db->where("tt.nature",'1');
		$this->db->where($whereissue,NULL,FALSE);
		$this -> db -> where("batch.status!='Finished'");
		$this->db->group_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		$this->db->order_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		return $this->db->get()->result_array();
		//print_r($this->db->last_query());exit;
		
	}
	public function getintervalIssue($startdate,$enddate,$whtype,$whcode) {		
		/*for all province*/
		//$current_whcode=$this->session->curr_wh_code;
		//$current_whcode = substr($current_whcode,0,1);
		$current_whcode = $this -> session -> Province;
		//issue
		if($whcode=="all")
		{
		$whereissue ="master.from_warehouse_type_id = '".$whtype."' and master.from_warehouse_code like '$current_whcode%'";
		}
		else
		{
		$whereissue ="master.from_warehouse_type_id = '".$whtype."' and master.from_warehouse_code='$whcode'";	
		}
		
		$this->db->select("item_pack_size_id as id,sum(batch.quantity) as balance",FALSE);
		$this->db->from("epi_stock_batch_history batch");
		$this->db->join("epi_stock_master_history master","master.master_id = batch.batch_master_id");
		$this->db->join("epi_transaction_types tt","tt.pk_id = master.transaction_type_id");
		$this->db->join("epi_item_pack_sizes sizes","sizes.pk_id = batch.item_pack_size_id");
		$this->db->where("master.transaction_date >= ",$startdate);
		$this->db->where("master.transaction_date <= ",$enddate);
	//	$this->db->where("sizes.item_category_id",'1');
		$this->db->where("master.draft",'0');
		$this->db->where("master.transaction_type_id",'2');
		$this->db->where("tt.nature",'0');
		$this->db->where($whereissue,NULL,FALSE);
		//$this -> db -> where("batch.status!='Finished'");
		$this->db->group_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		$this->db->order_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		return $this->db->get()->result_array();
		//print_r($this->db->last_query());exit;
		
	}
	public function getintervaladj_positive($startdate,$enddate,$whtype,$whcode) {		
		/*for all province*/
		//$current_whcode=$this->session->curr_wh_code;
		//$current_whcode = substr($current_whcode,0,1);
		$current_whcode = $this -> session -> Province;
		//issue
		if($whcode=="all")
		{
		$whereissue ="master.to_warehouse_type_id = '".$whtype."' and master.to_warehouse_code like '$current_whcode%'";
		}
		else
		{
		$whereissue ="master.to_warehouse_type_id = '".$whtype."' and master.to_warehouse_code='$whcode'";	
		}
		
		
		$this->db->select("item_pack_size_id as id,sum(batch.quantity) as balance",FALSE);
		$this->db->from("epi_stock_batch_history batch");
		$this->db->join("epi_stock_master_history master","master.master_id = batch.batch_master_id");
		$this->db->join("epi_transaction_types tt","tt.pk_id = master.transaction_type_id");
		$this->db->join("epi_item_pack_sizes sizes","sizes.pk_id = batch.item_pack_size_id");
		$this->db->where("master.transaction_date >= ",$startdate);
		$this->db->where("master.transaction_date <= ",$enddate);
	//	$this->db->where("sizes.item_category_id",'1');
		$this->db->where("master.draft",'0');
		$this->db->where("tt.nature",'1'); 
		$this -> db -> where("master.transaction_type_id NOT IN (1,2)", NULL, FALSE);
		$this->db->where($whereissue,NULL,FALSE);
		//$this -> db -> where("batch.status!='Finished'");
		$this->db->group_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		$this->db->order_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		return $this->db->get()->result_array();
		 
		//echo "<pre>"; print_r($this->db->get()->result_array());exit;
		
	}
	public function getintervaladj_negative($startdate,$enddate,$whtype,$whcode) {		
		/*for all province*/
		//$current_whcode=$this->session->curr_wh_code;
		//$current_whcode = substr($current_whcode,0,1);
		$current_whcode = $this -> session -> Province;
		//issue
		if($whcode=="all")
		{
		$whereissue ="master.to_warehouse_type_id = '".$whtype."' and master.to_warehouse_code like '$current_whcode%'";
		}
		else
		{
		$whereissue ="master.to_warehouse_type_id = '".$whtype."' and master.to_warehouse_code='$whcode'";	
		}
		
		
		$this->db->select("item_pack_size_id as id,sum(batch.quantity) as balance",FALSE);
		$this->db->from("epi_stock_batch_history batch");
		$this->db->join("epi_stock_master_history master","master.master_id = batch.batch_master_id");
		$this->db->join("epi_transaction_types tt","tt.pk_id = master.transaction_type_id");
		$this->db->join("epi_item_pack_sizes sizes","sizes.pk_id = batch.item_pack_size_id");
		$this->db->where("master.transaction_date >= ",$startdate);
		$this->db->where("master.transaction_date <= ",$enddate);
		//$this->db->where("sizes.item_category_id",'1');
		$this->db->where("master.draft",'0');
		$this->db->where("tt.nature",'0'); 
		$this -> db -> where("master.transaction_type_id NOT IN (1,2)", NULL, FALSE);
		$this->db->where($whereissue,NULL,FALSE);
		//$this -> db -> where("batch.status!='Finished'");
		$this->db->group_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		$this->db->order_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		return $this->db->get()->result_array();
		 
		//echo "<pre>"; print_r($this->db->get()->result_array());exit;
		
	}
	public function getinvnStatusRep($year,$whtype,$whcode,$invnRepType,$monthfrom,$monthto,$distcode) {
	
//echo "$distcode";	
		/* $current_whcode=$this->session->curr_wh_code;
		$current_whcode = substr($current_whcode,0,1); */
		if($invnRepType=="monthwise"){
			$group = "to_char(transaction_date,'YYYY-MM')";
			$columntofetch = "to_char(transaction_date,'YYYY-MM')";
			$this->db->where("to_char(transaction_date,'YYYY')",$year);
		}else if($invnRepType=="storewise"){
			$group = "to_warehouse_type_id,to_warehouse_code";
			//$columntofetch = "get_store_name(case when to_warehouse_type_id = '$whtype' then from_warehouse_type_id else to_warehouse_type_id end,case when to_warehouse_code = '$whcode' then from_warehouse_code else to_warehouse_code end)";
			$columntofetch = "case when to_warehouse_type_id = '$whtype' then from_warehouse_type_id else to_warehouse_type_id end||'-'||case when to_warehouse_type_id = '$whtype' then from_warehouse_code else to_warehouse_code end";//when to_warehouse_code = '$whcode'
			//$this->db->where("to_char(transaction_date,'YYYY-MM')",$year.'-'.$month);
			$this -> db -> where("to_char(transaction_date,'YYYY-MM') BETWEEN '$monthfrom' AND '$monthto'", NULL, FALSE);
		}
		$whererec	= "to_warehouse_type_id = '".$whtype."' and to_warehouse_code='$whcode'";
		$whereissue	= "from_warehouse_type_id = '".$whtype."' and from_warehouse_code='$whcode'";
		$this->db->select("$columntofetch as repbyname,
		coalesce(sum(case when $whererec then 1 else 0 end),0) as issuedme,
		coalesce(sum(case when (select count(*) from epi_stock_batch where status !='Finished' and batch_master_id = epi_stock_master.pk_id)<=0 AND $whererec then 1 else 0 end),0) as receivedme,
		
		sum(case when $whereissue then 1 else 0 end) as issuedother,		
		sum(case when (select count(*) from epi_stock_batch where status !='Finished' and batch_master_id = epi_stock_master.pk_id)<=0 AND $whereissue then 1 else 0 end) as receivedother",FALSE);
		$this->db->from("epi_stock_master");
		//transaction_number like 'I'||to_char(transaction_date,'YYMM')||'%' AND 
		$this->db->where("(to_warehouse_type_id = '".$whtype."' OR from_warehouse_type_id = '".$whtype."')");
		$this->db->where("(to_warehouse_code = '".$whcode."' OR from_warehouse_code = '".$whcode."')");
		$this->db->where("draft",'0');
		$this->db->where("transaction_number like 'I%'");
		$this->db->group_by("repbyname");
		$this->db->order_by("repbyname");
		$result = $this->db->get()->result_array();
		//echo $this->db->last_query();exit;
		return $result;
	}
	public function getinvnStatusDetail($monthfrom,$monthto,$type,$whtype,$whcode,$month,$distcode) {
		
		 if(isset($monthfrom) && $monthfrom!="" ){
			$yearmonth = substr(str_replace("-","",$monthfrom),2,2);
		 }else
		 {
			 $yearmonth = substr(str_replace("-","",$month),2); 
		 }
		//$transmonthto = substr(str_replace("-","",$monthto),2);
		/* if($distcode>0){
			$whtype = 4;
			$whcode = $distcode;
		} */
		 if($distcode>0)
					{
						
						$current_whcode=$distcode;
						$current_whtype=4;
						/* $data['wh_type']=$whtype;
						$data['wh_code']=$whcode; */
					}
		else {
			$current_whcode=$this->session->curr_wh_code;
		    $current_whtype=$this->session->curr_wh_type;
		}
		
		
		//$current_whcode = substr($current_whcode,0,1);
		/* if($whcode=="all"){
			$whererec		= "to_warehouse_type_id = '".$whtype."' and to_warehouse_code like '$current_whcode%'";
			$whereissue		= "from_warehouse_type_id = '".$whtype."' and from_warehouse_code like '$current_whcode%'";
		}else{ */
		/* } */
		if($whcode==0){
			$whereissue		= "to_warehouse_type_id = '".$current_whtype."' and to_warehouse_code='".$current_whcode."'";
			$whererec		= "from_warehouse_type_id = '".$current_whtype."' and from_warehouse_code='".$current_whcode."'";
		}else{
			$sendtome		= "to_warehouse_type_id = '".$current_whtype."' and to_warehouse_code='".$current_whcode."'";
			$sendbyme		= "from_warehouse_type_id = '".$current_whtype."' and from_warehouse_code='".$current_whcode."'";
			$whererec		= "to_warehouse_type_id = '".$whtype."' and to_warehouse_code='$whcode'"." AND ".$sendbyme;
			$whereissue		= "from_warehouse_type_id = '".$whtype."' and from_warehouse_code='$whcode'"." AND ".$sendtome;
		}
		if($type=='issuedme'){
			$columns = 'transaction_date,created_date,transaction_number,from_warehouse_type_id,from_warehouse_code,get_store_name(from_warehouse_type_id,from_warehouse_code) as store';
			$wheree = $whereissue;
		}else if($type=='receivedme'){
			$voucher="array_to_string(vouchers(pk_id),',') as recievedvouchers";
			$columns = 'transaction_date,created_date,transaction_number,'.$voucher.',from_warehouse_type_id,from_warehouse_code,get_store_name(from_warehouse_type_id,from_warehouse_code) as store';
			$wheree = $whereissue." AND (select count(*) from epi_stock_batch where status !='Finished' and batch_master_id = epi_stock_master.pk_id)<=0";
		}else if($type=='pendingme'){
			$columns = 'transaction_date,created_date,transaction_number,from_warehouse_type_id,from_warehouse_code,get_store_name(from_warehouse_type_id,from_warehouse_code) as store';
			$wheree = $whereissue." AND (select count(*) from epi_stock_batch where status !='Finished' and batch_master_id = epi_stock_master.pk_id)>0";
		}else if($type=='issuedother'){
			$columns = 'transaction_date,created_date,transaction_number,from_warehouse_type_id,from_warehouse_code,get_store_name(to_warehouse_type_id,to_warehouse_code) as store';
			$wheree = $whererec;
		}else if($type=='receivedother'){
			$columns = 'transaction_date,created_date,transaction_number,from_warehouse_type_id,from_warehouse_code,get_store_name(to_warehouse_type_id,to_warehouse_code) as store';
			$wheree = $whererec." AND (select count(*) from epi_stock_batch where status !='Finished' and batch_master_id = epi_stock_master.pk_id)<=0";
		}else if($type=='pendingother'){
			$columns = 'transaction_date,created_date,transaction_number,from_warehouse_type_id,from_warehouse_code,get_store_name(to_warehouse_type_id,to_warehouse_code) as store';
			$wheree = $whererec." AND (select count(*) from epi_stock_batch where status !='Finished' and batch_master_id = epi_stock_master.pk_id)>0";
		}
		$this->db->select($columns,FALSE);
		$this->db->from("epi_stock_master");
		$this->db->where("transaction_number like 'I'||'".$yearmonth."'||'%'",NULL,FALSE);
		//$this->db->where("transaction_number like 'I'||'".$transmonthto."'||'%'",NULL,FALSE);
		$this->db->where($wheree,NULL,FALSE);
		//from here start 
		//$this->db->where("to_char(transaction_date,'YYYY-MM')",$month);
		 if(isset($monthfrom) && $monthfrom!="" ){
		$this -> db -> where("to_char(transaction_date,'YYYY-MM') BETWEEN '$monthfrom' AND '$monthto'", NULL, FALSE);
		 }
		  if(isset($month) && $month!="" ){
		$this->db->where("to_char(transaction_date,'YYYY-MM')",$month);
		 }
		$this->db->where("draft",'0');
		$this->db->order_by("transaction_number");
		$result = $this->db->get()->result_array();
		//print_r($this->db->last_query());exit;
		return $result;
	}
	public function getYearlyStatusRep($year,$indicator,$whtype,$whcode) {
		$transyear = substr($year,2,2);
		//$current_whcode=$this->session->curr_wh_code;
		//$current_whtype=$this->session->curr_wh_type;
		$sendtome		= "to_warehouse_type_id = '".$whtype."' and to_warehouse_code='".$whcode."'";
		$sendbyme		= "from_warehouse_type_id = '".$whtype."' and from_warehouse_code='".$whcode."'";
		//$current_whcode = substr($current_whcode,0,1);
		//$columns = "i.item_name,to_char(transaction_date,'YYYY-MM') as repmonth,sum(b.quantity) as total";
		$columns = "i.item_name,get_stackholder_activity_name(i.activity_type_id) as activity,
		itemcatname(i.item_category_id) as category,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-01' then b.quantity else 0 end) as totalm1,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-02' then b.quantity else 0 end) as totalm2,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-03' then b.quantity else 0 end) as totalm3,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-04' then b.quantity else 0 end) as totalm4,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-05' then b.quantity else 0 end) as totalm5,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-06' then b.quantity else 0 end) as totalm6,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-07' then b.quantity else 0 end) as totalm7,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-08' then b.quantity else 0 end) as totalm8,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-09' then b.quantity else 0 end) as totalm9,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-10' then b.quantity else 0 end) as totalm10,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-11' then b.quantity else 0 end) as totalm11,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$year-12' then b.quantity else 0 end) as totalm12";
		if($indicator=='2'){
			$this->db->where("transaction_number like 'R'||'".$transyear."'||'%' AND ".$sendtome,NULL,FALSE);
		}else if($indicator=='1'){
			$this->db->where("transaction_number like 'I'||'".$transyear."'||'%' AND ".$sendbyme,NULL,FALSE);
		}else if($indicator=='3'){
			//in stock
			//work remaining
			//$wheree = "to_warehouse_type_id = '".$whtype."' and to_warehouse_code='".$whcode."'";
			//$this->db->where("transaction_number like 'I'||'".$transyear."'||'%'",NULL,FALSE);
		}
		$this->db->select($columns,FALSE);
		$this->db->from("epi_item_pack_sizes i");
		$this->db->join("epi_stock_batch_history b","b.item_pack_size_id=i.pk_id","LEFT OUTER");
		$this->db->join("epi_stock_master_history h","h.master_id=b.batch_master_id","LEFT OUTER");
		//$this->db->where($wheree,NULL,FALSE);
		$this->db->where("to_char(transaction_date,'YYYY')",$year);
		$this->db->where("draft",'0');
		$this->db->group_by("i.item_name,i.activity_type_id,i.item_category_id,i.list_rank");
		$this->db->order_by("i.item_name,i.list_rank");
		$result = $this->db->get()->result_array();
		//print_r($this->db->last_query());exit;
		return $result;
	}
 	public function expiry_rate_report_data($warehouse_type,$warehouse_code,$startdate,$enddate)
	{
		//for province
		//$current_whcode=$this->session->curr_wh_code;
		//$current_whcode = substr($current_whcode,0,1);
		$current_whcode = $this -> session -> Province;
		if($warehouse_code=="all"){
		$where="b.warehouse_type_id='".$warehouse_type."' and b.code like'$current_whcode%'";
		}
		else{
		$where="b.warehouse_type_id='".$warehouse_type."' and b.code='".$warehouse_code."'";	
		}
		$this->db->select("i.item_name, array_to_string(array_agg(b.batch_id),',') as data, sum(b.quantity) as quantity");
		$this->db->from("epi_item_pack_sizes i");
		$this->db->join("epi_stock_batch_history b","b.item_pack_size_id=i.pk_id");
		$this->db->join("epi_stock_master_history h","h.master_id=b.batch_master_id");
		$this->db->join("epi_transaction_types t","t.pk_id=h.transaction_type_id");
		$this->db->where("t.nature",'1');
		$this->db->where("b.status!=",'Finsihed');
		$this->db->where("h.transaction_date >= ",$startdate);
		$this->db->where("h.transaction_date <= ",$enddate); 
		$this->db->where($where,NULL,FALSE);
		$this->db->group_by("i.item_name, i.list_rank");
		$this->db->order_by("i.list_rank");
		return $this->db->get()->result_array();
		//print_r($this->db->last_query());exit;
	} 
	public function expiry_rate_report_batch_data($batch_id)
	{
		$querytext="select 
			((case when outerr.expiry_date < cast(now() as date) and outerr.status!='Finished' then outerr.quantity else 0 end ) + 
			(
			select sum(bhh.quantity) as quantity from epi_stock_batch_history bhh join epi_stock_master_history mhh on bhh.batch_master_id=mhh.master_id where  mhh.transaction_type_id=7 and parent_pk_id = outerr.batch_id group by parent_pk_id))::int as expired_quantity 
			from epi_stock_batch_history outerr where outerr.batch_id ='".$batch_id."'";
		$result = $this->db->query($querytext);
		return $result->row()->expired_quantity;
	}
 
	public function stock_ledger_data($startdate,$enddate,$product,$whtype,$whcode,$purpose)
	{
	/* 	echo 'start date '; echo $startdate;
		echo 'code '; echo $whcode;
		echo 'product'; echo $product; echo $enddate; */
		$created_by=$this->session->username;
		$created_by_where="m.created_by='$created_by'";
		$level=$this->session->UserLevel;
		if($level==2)
			$created_by_where.="or m.created_by='kpk_manager'";
		$querytext="select it.item_name, b.quantity, it.number_of_doses, (b.quantity*it.number_of_doses) as t_quantity, cast(m.transaction_date as date) as transaction_date, m.transaction_number, tt.transaction_type_name, tt.nature, tt.is_adjustment, m.created_by, cast(m.created_date as date) as created_date, b.number, b.expiry_date, (case when tt.nature='1' and tt.is_adjustment='0' then 'From ' || get_store_name(m.from_warehouse_type_id,m.from_warehouse_code) when tt.nature='0' and tt.is_adjustment='0' then 'To ' || get_store_name(m.to_warehouse_type_id,m.to_warehouse_code) else '' end) from epi_stock_master_history m join epi_transaction_types tt on tt.pk_id=m.transaction_type_id join epi_stock_batch_history b on b.batch_master_id=m.master_id join epi_item_pack_sizes it on it.pk_id=b.item_pack_size_id where ((m.to_warehouse_code='".$whcode."' and tt.nature='1') or (m.from_warehouse_code='".$whcode."' and tt.nature='0')  or (m.to_warehouse_code='".$whcode."' and tt.nature='0' and m.transaction_number like 'A%') ) and m.transaction_date >= '".$startdate."' and m.transaction_date <= '".$enddate."' and it.pk_id='".$product."' and it.activity_type_id='".$purpose."' and ($created_by_where) order by m.transaction_date asc";//m.created_date
		$result = $this->db->query($querytext);
		//echo $this->db->last_query(); exit;
		return $result->result_array();
	}
	public function opening_balance_for_stockledger($startdate,$whtype,$whcode,$product,$purpose,$expire_startdate)
	{
		$this->db->select('coalesce(sum(batch.quantity),0) as stock,batch.number');
		$this->db->from("epi_stock_batch_history batch");
		$this->db->join("epi_stock_master_history master","master.pk_id = batch.batch_master_id");
		$this->db->join("epi_transaction_types tt","tt.pk_id = master.transaction_type_id");
		$this->db->join("epi_item_pack_sizes sizes","sizes.pk_id = batch.item_pack_size_id");
		$this->db->where("master.transaction_date <",$startdate);
		$this->db->where("batch.expiry_date >",$expire_startdate);
		$this->db->where("sizes.activity_type_id",$purpose);
		$this->db->where("batch.status !=",'Finsihed');
		$this->db->where("tt.nature",'1');
		$this->db->where("batch.item_pack_size_id",$product);
		$this->db->where("master.draft",'0');
		$this->db->where("master.to_warehouse_type_id",$whtype);
		$this->db->where("master.to_warehouse_code",$whcode);
		$this->db->group_by("batch.number");
		//$this->db->order_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		$result = $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		return $result;
		/* //$startdate = '2018-04-06 00:00:00'; 
		$querytext = "select * from (SELECT item_pack_size_id as id, cast(master.transaction_date as date) as transaction_date,
		batch.number as batch_num, batch.batch_master_id as batch_id, sum(case when tt.nature = '1' AND 
		master.to_warehouse_type_id = '".$whtype."' and master.to_warehouse_code='".$whcode."' then batch.quantity 
		else 0 end)-sum(case when tt.nature = '0' AND master.from_warehouse_type_id = '".$whtype."' and 
		master.from_warehouse_code='".$whcode."' then batch.quantity else 0 end) as balance FROM epi_stock_batch_history batch 
		JOIN epi_stock_master_history master ON master.master_id = batch.batch_master_id 
		JOIN epi_transaction_types tt ON tt.pk_id = master.transaction_type_id 
		JOIN epi_item_pack_sizes sizes ON sizes.pk_id = batch.item_pack_size_id 
		WHERE batch.item_pack_size_id='".$product."' and batch.status!='Finished' AND master.transaction_date < '".$startdate."' 
		AND sizes.item_category_id = '1' AND master.draft = '0' 
		GROUP BY master.transaction_date, master.stakeholder_activity_id, batch.item_pack_size_id, batch.number, 
		batch.batch_master_id 
		ORDER BY batch.number, master.stakeholder_activity_id,master.transaction_date, 
		batch.item_pack_size_id, batch.batch_master_id) as sub  where balance>0";
		$result = $this->db->query($querytext); */
		//echo $this->db->last_query(); exit;return $result->result_array();
		
	}
	public function closing_balance_for_stockledger($enddate,$whtype,$whcode,$product,$purpose,$expire_enddate)
	{
		$this->db->select('coalesce(sum(quantity),0) as stock,batch.number');
		$this->db->from("epi_stock_batch_history batch");
		$this->db->join("epi_stock_master_history master","master.pk_id = batch.batch_master_id");
		$this->db->join("epi_transaction_types tt","tt.pk_id = master.transaction_type_id");
		$this->db->join("epi_item_pack_sizes sizes","sizes.pk_id = batch.item_pack_size_id");
		$this->db->where("master.transaction_date <=",$enddate);
		$this->db->where("batch.expiry_date >",$expire_enddate);
		$this->db->where("sizes.activity_type_id",$purpose);
		//$this->db->where("sizes.item_category_id",$purpose);
		$this->db->where("batch.status !=",'Finsihed');
		$this->db->where("tt.nature",'1');
		$this->db->where("batch.item_pack_size_id",$product);
		$this->db->where("master.draft",'0');
		$this->db->where("master.to_warehouse_type_id",$whtype);
		$this->db->where("master.to_warehouse_code",$whcode);
		$this->db->group_by("batch.number");
		//$this->db->order_by("master.stakeholder_activity_id,batch.item_pack_size_id");
		$result = $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		return $result;
		
		
	}
	public function numberofdossesinproduct($product)
	{
		$querytext = "select number_of_doses from epi_item_pack_sizes where pk_id='".$product."'";
		$result = $this->db->query($querytext);
		return $result->result_array();
	}
	 public function getStockMovementReport($year,$indicator,$whtype,$whcode,$month,$towhtype,$towhcode)
	{
		//echo $month;exit;
		$yearmonth=getMonthsFromEndMonth($year.'-'.$month);
		$transyear = substr($year,2,2);
		//$columns = "i.item_name,to_char(transaction_date,'YYYY-MM') as repmonth,sum(b.quantity) as total";
		$columns = "i.item_name,sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[0]' then b.quantity else 0 end) as totalm1,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[1]' then b.quantity else 0 end) as totalm2,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[2]' then b.quantity else 0 end) as totalm3,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[3]' then b.quantity else 0 end) as totalm4,
		sum(case when to_char(transaction_date, 'YYYY-MM')='=$yearmonth[4]' then b.quantity else 0 end) as totalm5,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[5]' then b.quantity else 0 end) as totalm6,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[6]' then b.quantity else 0 end) as totalm7,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[7]' then b.quantity else 0 end) as totalm8,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[8]' then b.quantity else 0 end) as totalm9,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[9]' then b.quantity else 0 end) as totalm10,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[10]' then b.quantity else 0 end) as totalm11,
		sum(case when to_char(transaction_date, 'YYYY-MM')='$yearmonth[11]' then b.quantity else 0 end) as totalm12";
		//for province 
		//$current_whcode=$this->session->curr_wh_code;
		//$current_whcode = substr($current_whcode,0,1);
		$current_whcode = $this -> session -> Province;
		if($towhcode=="all"){
		$wheree = "from_warehouse_code = '".$whcode."' and to_warehouse_code like '$current_whcode%'";
		}
		else
		{
		$wheree = "from_warehouse_code = '".$whcode."' and to_warehouse_code='".$towhcode."'";
		
		}
		if($indicator=='2'){//receive
			//$wheree = "from_warehouse_code = '".$whcode."' and to_warehouse_code='".$towhcode."'";
			$this->db->where("transaction_number like 'R'||'".$transyear."'||'%'",NULL,FALSE);
		}else if($indicator=='1'){//issue
			//$wheree = "from_warehouse_code = '".$whcode."' and to_warehouse_code='".$towhcode."'";
			$this->db->where("transaction_number like 'I'||'".$transyear."'||'%'",NULL,FALSE);
		}else if($indicator=='3'){//in stock
			//work remaining
			//$wheree = "to_warehouse_type_id = '".$whtype."' and to_warehouse_code='".$whcode."'";
			//$this->db->where("transaction_number like 'I'||'".$transyear."'||'%'",NULL,FALSE);
		}
		$this->db->select($columns,FALSE);
		$this->db->from("epi_item_pack_sizes i");
		$this->db->join("epi_stock_batch_history b","b.item_pack_size_id=i.pk_id","LEFT OUTER");
		$this->db->join("epi_stock_master_history h","h.master_id=b.batch_master_id","LEFT OUTER");
		$this->db->where($wheree,NULL,FALSE);
		$this->db->where("to_char(transaction_date,'YYYY')",$year);
		$this->db->where("draft",'0');
		$this->db->group_by("i.item_name,i.list_rank");
		$this->db->order_by("i.list_rank");
		$result = $this->db->get()->result_array();
		//print_r($this->db->last_query());exit;
		return $result;
	}
	public function vaccine_distribution_detial($startdate,$enddate,$whtype,$whcode)
	{
	
			$result=$this->db->query("SELECT item_pack_size_id as id,master.to_warehouse_code,sum(batch.quantity) as sum FROM epi_stock_batch_history batch JOIN epi_stock_master_history master ON master.master_id = batch.batch_master_id JOIN epi_transaction_types tt ON tt.pk_id = master.transaction_type_id JOIN epi_item_pack_sizes sizes ON sizes.pk_id = batch.item_pack_size_id WHERE master.transaction_date >= '$startdate' AND master.transaction_date <= '$enddate' AND sizes.item_category_id = '1' AND master.draft = '0' AND tt.nature = '0' AND master.from_warehouse_type_id = '$whtype' and master.from_warehouse_code='$whcode' GROUP BY master.stakeholder_activity_id, batch.item_pack_size_id,master.to_warehouse_code ORDER BY master.stakeholder_activity_id, batch.item_pack_size_id")->result_array();	
			return $result;	
	}
	public function voucher_detail($vouchernum)
	{
		$this -> db -> select('batch.pk_id,CAST(master.transaction_date AS DATE),master.transaction_number,master.transaction_reference,get_product_name(batch.item_pack_size_id) as itemname,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as storelocation,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,batch.number,stackholdername(batch.stakeholder_id) as manufacturer,batch.quantity,itemunitname(detail.item_unit_id) as unit,batch.expiry_date,master.created_date,master.from_warehouse_type_id,master.from_warehouse_code,master.to_warehouse_type_id,master.to_warehouse_code');
		$whereCondition = array();
		//$this -> db -> where("master.transaction_date BETWEEN '{$datefrom}' AND '{$dateto}'", NULL, FALSE);
		//$whereCondition['master.transaction_type_id'] = 1;
		//draft zero condition Stock master
		//$whereCondition['master.draft'] =0;
		//$whereCondition['master.to_warehouse_type_id'] = $this -> session -> curr_wh_type;
		//$whereCondition['master.to_warehouse_code'] = $this -> session -> curr_wh_code;
		if($vouchernum){
			$whereCondition['master.transaction_number'] = $vouchernum;
		}
		$this -> db -> where($whereCondition);
		$this -> db -> from('epi_stock_master_history master');
		$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		$output = $this -> db -> get() -> result_array();
		return $output;
	}
	//recieve voucher detail 
	
		public function rec_voucher_detail($vouchernum)
	{
		$this -> db -> select('batch.pk_id,CAST(master.transaction_date AS DATE),master.transaction_number,master.transaction_reference,get_product_name(batch.item_pack_size_id) as itemname,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as storelocation,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,batch.number,stackholdername(batch.stakeholder_id) as manufacturer,batch.quantity,itemunitname(detail.item_unit_id) as unit,batch.expiry_date,master.created_date,master.from_warehouse_type_id,master.from_warehouse_code,master.to_warehouse_type_id,master.to_warehouse_code');
		$whereCondition = array();
		//$this -> db -> where("master.transaction_date BETWEEN '{$datefrom}' AND '{$dateto}'", NULL, FALSE);
		//$whereCondition['master.transaction_type_id'] = 1;
		//draft zero condition Stock master
		//$whereCondition['master.draft'] =0;
		//$whereCondition['master.to_warehouse_type_id'] = $this -> session -> curr_wh_type;
		//$whereCondition['master.to_warehouse_code'] = $this -> session -> curr_wh_code;
		if($vouchernum){
			$whereCondition['master.transaction_number'] = $vouchernum;
		}
		$this -> db -> where($whereCondition);
		$this -> db -> from('epi_stock_master_history master');
		$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		$output = $this -> db -> get() -> result_array();
		return $output;
	}	

	public function adjustment_report($distcode,$tcode,$uncode,$facode,$monthfrom,$monthto)
	{		
		$this -> db -> select('distcode,districtname(distcode) as distname,tcode,tehsilname(tcode) as tehsilnam,uncode,unname(uncode) as unname,facode,facilityname(facode) as facilityname,fmonth,get_product_name(item_id) as item_name,batch_number,adjustmentname(adjustment_type) as adjustmentname,adjustment_quantity_vials,adjustment_quantity_doses,*');
		
		$this -> db -> from('epi_consumption_adjustment');
		
		if($distcode > 0)  
		{
		$this -> db -> where('distcode',$distcode);
		}
		
		if($tcode > 0)
		{
		$this -> db -> where('tcode',$tcode);
		}
		
		if($uncode > 0)
		{
		$this -> db -> where('uncode',$uncode);
		}
		
		if($facode > 0)
		{
		$this -> db -> where('facode',$facode);
		}
		if(isset($monthfrom) && $monthfrom!="" ){
		$this -> db -> where("fmonth BETWEEN '$monthfrom' AND '$monthto'", NULL, FALSE);
		 }	
		$result = $this->db->get()->result_array();
		
		return  $result;
	}
	public function voucher_detail_productwise($vouchernum)
	{
		$this -> db -> select('master.pk_id as master_id,batch.pk_id as batch_id,detail.pk_id as detail_id,CAST(master.transaction_date AS DATE),master.transaction_number,master.transaction_reference,get_product_name(batch.item_pack_size_id) as itemname,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as storelocation,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,batch.number,stackholdername(batch.stakeholder_id) as manufacturer,detail.quantity,itemunitname(detail.item_unit_id) as unit,batch.expiry_date,master.created_date,master.from_warehouse_type_id,master.from_warehouse_code,master.to_warehouse_type_id,master.to_warehouse_code');
		$whereCondition = array();
		if($vouchernum){
			$whereCondition['master.transaction_number'] = $vouchernum;
		}
		$this -> db -> where($whereCondition);
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$output = $this -> db -> get() -> result_array();
		return $output;
	}
	public function master_id_delete($voucher_number,$master_id){
		$query = "SELECT transaction_counter FROM epi_stock_master where transaction_number='$voucher_number' and pk_id='$master_id'";
		$result = $this -> db -> query($query);
		$new_data = $result -> row_array();
		$transaction_counter = $new_data['transaction_counter'];
		if ($transaction_counter > 1) 
		{
			$number =$transaction_counter - 1;
			$this->db->trans_start();
			$data = array(
				'transaction_counter'=>$number,
			);
			$this->db->where('transaction_number', $voucher_number);
			$this->db->where('pk_id', $master_id);
			$this->db->update('epi_stock_master',$data); 
			
			$this->db->where('transaction_number', $voucher_number);
			$this->db->where('master_id', $master_id);
			$this->db->update('epi_stock_master_history',$data); 
			
			$this->db->trans_complete();
		} 
		else 
		{
			$get['epi_stock_master'] =$this->db->delete('epi_stock_master', array('pk_id' => $master_id,'transaction_number' => $voucher_number)); 
			$get['epi_stock_master_history'] =$this->db->delete('epi_stock_master_history', array('master_id' => $master_id,'transaction_number' => $voucher_number)); 
			return $get;
		}
	}
	public function batch_id_delete($batch_id,$master_id){
		$get['epi_stock_batch']=$this->db->delete('epi_stock_batch', array('pk_id' => $batch_id,'batch_master_id' => $master_id)); 
		$get['epi_stock_batch_history']=$this->db->delete('epi_stock_batch_history', array('batch_id' => $batch_id,'batch_master_id' => $master_id)); 
		return $get;
	}
	public function detail_id_delete($detail_id,$master_id){
		$get['epi_stock_detail']=$this->db->delete('epi_stock_detail', array('pk_id' => $detail_id,'stock_master_id' => $master_id)); 
		$get['epi_stock_detail_history']=$this->db->delete('epi_stock_detail_history', array('detail_id' => $detail_id,'stock_master_id' => $master_id)); 
		return $get;
	}
	
}
?>