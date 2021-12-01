 <?php
/*    
@ Author:                 Raja Imran Qamer    
@ Email:                  rajaimranqamer@gmail.com    
@ Class:                 Receiver    
@ Description:          This class will be used to receive incoming API calls, verify them, and return needed information depending upon provided parameters.    
@                        It will be used for receiving agent for federal epimis System*/
class Receiver extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //verify incoming call here
        $this->verifyRequest();
        $this->load->model('API/Receiver_model', 'rcvr_mdl');
        $this->load->model('Common_model', 'common');
    }
    /*
    @ Author:                 Raja Imran Qamer        
    @ Email:                  rajaimranqamer@gmail.com        
    @ Class:                 get_cc_equipments_count        
    @ Description:          This function will return counts of all coldchain equipments available, according to parameters    */
    public function get_cc_equipments_count(){
        $status         = ($this->input->post('status')) ? $this->input->post('status') : 'Active';
        $data["error"]  = false;
        $data["result"] = $this->rcvr_mdl->get_cc_equipments_count($status);
        //send response to client.
        echo json_encode($data);exit;
    }
    /*
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 get_cc_capacity        
	@ Description:          This function will return capacity in litres of all coldchain equipments available, according to parameters    */
    public function get_cc_capacity(){
        $type           = ($this->input->post('type')) ? $this->input->post('type') : 'coldroom';
        $typeId         = $this->getCCTypeId($type);
        $data["error"]  = false;
        $data["result"] = $this->rcvr_mdl->get_cc_capacity($typeId);
        //send response to client.        
        echo json_encode($data);exit;
    }
    /*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_cc_assetType_counts
		@ Description:  		This function will return type wise Available Assets count, according to parameters
   */
	public function get_cc_assetType_counts(){
        $type           = ($this->input->post('type')) ? $this->input->post('type') : 'coldroom';
        $typeId         = $this->getCCTypeId($type);
        $data["error"]  = false;
        $data["result"] = $this->rcvr_mdl->get_cc_assetType_counts($typeId);
        //send response to client.
        echo json_encode($data);exit;
    }
    /*        
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 get_cc_levelWise_counts        
	@ Description:          This function will return Level wise Available Assets count, according to parameters    */
    public function get_cc_levelWise_counts(){
        $type           = ($this->input->post('type')) ? $this->input->post('type') : 'coldroom';
        $typeId         = $this->getCCTypeId($type);
        $data["error"]  = false;
        $data["result"] = $this->rcvr_mdl->get_cc_levelWise_counts($typeId);
        //send response to client.
        echo json_encode($data);exit;
    }
    /*        
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 get_cc_wsWise_counts        
	@ Description:          This function will return Level wise Available Assets count, according to parameters    */
    public function get_cc_wsWise_counts(){
        $type           = ($this->input->post('type')) ? $this->input->post('type') : 'coldroom';
        $typeId         = $this->getCCTypeId($type);
        $data["error"]  = false;
        $data["result"] = $this->rcvr_mdl->get_cc_wsWise_counts($typeId);
        //send response to client.
        echo json_encode($data);exit;
    }
	public function get_cc_ysWise_counts(){
        $type           = ($this->input->post('type')) ? $this->input->post('type') : 'coldroom';
        $typeId         = $this->getCCTypeId($type);
        $data["error"]  = false;
        $data["result"] = $this->rcvr_mdl->get_cc_ysWise_counts($typeId);
        //send response to client.
        echo json_encode($data);exit;
    }
    /*        
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 get_cc_hfFunAsset_counts        
	@ Description:          This function will return hf rate havinf at least one item of given category exist, according to parameters    */
    public function get_cc_hfFunAsset_counts(){
        $type           = ($this->input->post('type')) ? $this->input->post('type') : 'refrigerator';
        $typeId         = $this->getCCTypeId($type);
        $data["error"]  = false;
        $data["result"] = 5;
        //$this->rcvr_mdl->get_cc_hfFunAsset_counts($typeId);
        //send response to client.
        echo json_encode($data);exit;
    }
    /*        @ Author:                 Raja Imran Qamer        @ Email:                  rajaimranqamer@gmail.com        @ Class:                 get_str_stock_in_hand        @ Description:          This function will return Level wise Available Assets count, according to parameters    */
    public function get_str_stock_in_hand(){
        $storecode        = ($this->input->post('storecode')) ? $this->input->post('storecode') : '3';
        $whtype           = ($this->input->post('level')) ? $this->input->post('level') : '2';
        $itemCategory     = $this->getItemCategoryId(($this->input->post('typeofitems')) ? $this->input->post('typeofitems') : '1');
        $whcode           = $storecode;
        $mastercolumnname = $this->getMasterColumnName($storecode);
        $enddate          = date("Y-m-d H:i:s");
        if ($whtype == 6) {            
			$items = $this->common->fetchall("epi_item_pack_sizes", NULL, "pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_pro_level_all_fac_closing_bal(pk_id,'$storecode','procode') as stock", array(
				"item_category_id" => $itemCategory,
				"cr_table_row_numb !=" => NULL
			), NULL, array(
				"by" => "activity_type_id || 'moon' || pk_id",
				"type" => "asc"
			));
        } else {            
			$items = $this->common->fetchall("epi_item_pack_sizes", NULL, "pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('" . $enddate . "','" . $whtype . "','$storecode',pk_id) as stock", array(
				"item_category_id" => $itemCategory,
				"cr_table_row_numb !=" => NULL
			), NULL, array(
				"by" => "activity_type_id || 'moon' || pk_id",
				"type" => "asc"
			));
        }
        $data["error"]  = false;
        $data["result"] = $items;
        //$this->rcvr_mdl->get_str_stock_in_hand();
        //send response to client.
        echo json_encode($data);exit;
    }
    /*        
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 get_items_stock_out_data        
	@ Description:          This function will return Level wise Stock out facilities count, according to parameters    */
    public function get_items_stock_out_data()
    {
        $storecode      = ($this->input->post('storecode')) ? $this->input->post('storecode') : '3';
        $whtype         = ($this->input->post('level')) ? $this->input->post('level') : '2';
        $vaccitems   = ($this->input->post('items')) ? explode(',',$this->input->post('items')) : array();
        $reportingmonth = date('Y-m', strtotime('-1 month', time()));
        $items = $this->rcvr_mdl->get_items_stock_out_data($reportingmonth, $vaccitems, $storecode);
        $data["error"]  = false;
        $data["result"] = $items;
        echo json_encode($data);exit;
    }
    /*        
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 get_str_stock_out_data        
	@ Description:          This function will return Level wise Stock out facilities count, according to parameters    */
    public function get_str_stock_out_data()
    {
        $storecode      = ($this->input->post('storecode')) ? $this->input->post('storecode') : '3';
        $whtype         = ($this->input->post('level')) ? $this->input->post('level') : '2';
        $itemCategory   = $this->getItemCategoryId(($this->input->post('typeofitems')) ? $this->input->post('typeofitems') : '1');
        $reportingmonth = date('Y-m', strtotime('-1 month', time()));
		$items = $this->rcvr_mdl->get_str_stock_out_data_new($reportingmonth, $itemCategory, $storecode);
        $data["error"]  = false;
        $data["result"] = $items;
        echo json_encode($data);exit;
    }
    /*
    @ Author:                 Raja Imran Qamer        
    @ Email:                  rajaimranqamer@gmail.com        
    @ Class:                 get_vacc_stock_out_data        
    @ Description:          This function will return province wise Stock out facilities count for one vaccine, according to parameters    */
    public function get_vacc_stock_out_data()
    {
        $selecteditem   = ($this->input->post('itemid')) ? $this->input->post('itemid') : '2'; //default 2 for BCG        
        $reportingmonth = ($this->input->post('fmonth')) ? $this->input->post('fmonth') : date('Y-m', strtotime("first day of previous months", time()));     
		$items = $this->rcvr_mdl->get_vacc_stock_out_data($reportingmonth,$selecteditem);
        //$items = $this->rcvr_mdl->get_str_stock_out_data_new($reportingmonth,$selecteditem);
        $data["error"]  = false;
        $data["result"] = $items;
        echo json_encode($data);exit;
    }
    /*        
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 verifyRequest        
	@ Description:          This function will be used as validator of incoming requests, just update it for validation purposes.    */
    public function verifyRequest()
    {
        $clientcode = $this->input->post('hackerinfo');
        $code       = $this->input->post('code');
        $servercode = md5('fedEp1m1$' . date("Y-m-d") . 'to' . $code . 'regEp1m1$');
        if ($servercode == $clientcode) { 
			//do nothing, call is verified        
		}else{
			$data["error"] = "UnAuthorised Access, Please check your authentication call.";
            //send response to client.
            echo json_encode($data);exit;
        }
    }
    /*        
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 getCCTypeId        
	@ Description:          This function will be used to return id of cold chin asset type, currently supporting only two.    */
    public function getCCTypeId($type)
    {
        switch ($type) {
            case "refrigrator":
                return "1";
                break;
            case "coldroom":
                return "21";
                break;
            case "voltageregulator":
                return "23";
                break;
            case "generator":
                return "24";
                break;
            case "transport":
                return "25";
                break;
            case "vaccinecarrier":
                return "26";
                break;
            case "icepack":
                return "27";
                break;
            case "coldbox":
                return "33";
                break;
            default:
                return "1";
                break;
        }
    }
    /*        
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 getCCTypeId        
	@ Description:          This function will be used to return id of cold chin asset type, currently supporting only two.    */
    public function getItemCategoryId($type)
    {
        switch ($type) {
            case "vaccines":
                return "1";
                break;
            case "diluents":
                return "3";
                break;
            case "nonvaccines":
                return "2";
                break;
            default:
                return "1";
                break;
        }
    }
    /*        
	@ Author:                 Raja Imran Qamer        
	@ Email:                  rajaimranqamer@gmail.com        
	@ Class:                 getMasterColumnName        
	@ Description:          This function will be used to return column name of consumption mater table which will be matched with value in query.    */
    public function getMasterColumnName($storecode)
    {
        $length = strlen($storecode);
        switch ($length) {
            case "1":
                return "procode";
                break;
            case "3":
                return "distcode";
                break;
            case "6":
                return "facode";
                break;
            default:
                return "procode";
                break;
        }
    }
    /*        
	@ Author:                 zoahib        
	@ Class:                 getCCTypeId        
	@ Description:          This function will be used to return Active Technician count and province population    */
    public function get_technicians_data()
    {
        $year           = ($this->input->post('year')) ? $this->input->post('year') : '2018';
        $data["error"]  = false;
        $data["result"] = $this->rcvr_mdl->get_technicians_data($year);
        //send response to client.
        echo json_encode($data);exit;
    }
    public function get_stock_ledger_data() //print_r($_POST);
    {
        $monthfrom = $this->input->post('monthfrom');
        $monthto   = $this->input->post('monthto');
        $startdate = $monthfrom . '-01 00:00:00';
        $lastday   = date('t', strtotime($monthto . '-01'));
        if ($monthto >= date('Y-m')) {
            $enddate = date('Y-m-d H:i:s');
        } else {
            $enddate = $monthto . '-' . $lastday . ' 23:59:59';
        }
        $whcode         = $this->input->post('procode');
        $product        = $this->input->post('prodcut');
        $purpose        = $this->input->post('purpose');
        $code           = $whcode;
        //print_r($whcodearr[0]['warehouse_code']);exit;
        //$code=$whcodearrp[0]['warehouse_code'];
        $querytext      = "select it.item_name, b.quantity, it.number_of_doses, (b.quantity*it.number_of_doses) as t_quantity, 
			ast(m.transaction_date as date) as transaction_date, m.transaction_number, tt.transaction_type_name, tt.nature, 
			tt.is_adjustment, m.created_by, cast(m.created_date as date) as created_date, b.number, b.expiry_date, 
			(case when tt.nature='1' and tt.is_adjustment='0' then 'From ' || get_store_name(m.from_warehouse_type_id,m.from_warehouse_code) when tt.nature='0' and tt.is_adjustment='0' then 'To ' || get_store_name(m.to_warehouse_type_id,m.to_warehouse_code) else '' end)
			from epi_stock_master_history m 
			join epi_transaction_types tt on tt.pk_id=m.transaction_type_id 
			join epi_stock_batch_history b on b.batch_master_id=m.master_id 
			join epi_item_pack_sizes it on it.pk_id=b.item_pack_size_id  
			where ((m.to_warehouse_code='" . $code . "' and tt.nature='1') or (m.from_warehouse_code='" . $code . "' and tt.nature='0')  
			or (m.to_warehouse_code='" . $code . "' and tt.nature='0' and m.transaction_number like 'A%') ) 
			and m.transaction_date >= '" . $startdate . "' and m.transaction_date <= '" . $enddate . "' and it.pk_id=$product  
			order by m.transaction_date asc";
        $data["result"] = $this->db->query($querytext)->result_array();
        echo json_encode($data);exit;
    }
    //plz don't remove following code    
    //commented old code, it was used to fetch current balance from inventory    
    /*    public function get_str_stock_in_hand(){        
    $storecode =$this -> input -> post('storecode');
    $whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
    $itemCategory = $this->getItemCategoryId(($this -> input -> post('typeofitems'))?$this -> input -> post('typeofitems'):'1');
    //$whcode = $storecode;
    //true for case when  provinces have one record in vlmisstores table and we use equal condition.
    //for Punjab its two for LHR & MULTAN. for that we use IN condition for vlmisstores code
    $pro_check=1;
    if($storecode==1){
    $pro_check=0;
    }
    //var_dump($pro_check);exit;
    $enddate = date("Y-m-d H:i:s");
    if($whtype==6){            $items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_pro_level_all_fac_closing_bal(pk_id) as stock",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
    }else{            $items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','$storecode',pk_id,$pro_check::boolean) as stock",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
    }            //        $data["error"] = false;
    $data["result"] = $items;
    //$this->rcvr_mdl->get_str_stock_in_hand();
    //send response to client.        echo json_encode($data);
    exit;
    }    */
}
?>