<?php
class Communication extends CI_Controller 
{	
	public function __construct() 
	{
		parent::__construct();
		$this -> load -> model('Communication_model','communication');
	}	
	public function consumption()
	{
		$date = $this -> input -> get('date');
		//$month = sprintf("%02d", $this -> input -> get('month'));
		//$year = $this -> input -> get('year');
		$distcode = $this -> input -> get('district_code');
		$vlmisToken = $this -> input -> get('token');
		if(/* $month AND $year */ $date AND $distcode AND $vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		}
		$this->form_validation->set_data(array("date"=>$date));
		$this->form_validation->set_rules('date','Transaction Date','trim|required|valid_date[Y-m-d]');
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('success'=>false,'message'=>'This is not a Valid Date!'));exit;
		}
		else
		{
			//$fmonth = $year."-".$month;
			$result = array();
			$products = $this -> communication -> getAllProducts();
			foreach($products as $product){
				$result[] = $this -> communication -> getConsumption(/* $fmonth */ $date,$distcode,$product['id'],$product['item_pack_size_id']);
			}
			//echo $this->db->last_query();exit;
			if($result){
				echo json_encode(array('success'=>true,'message'=>'Successful Response!','hash'=>md5(json_encode($result)),'data'=>$result));exit;
			}else{
				echo json_encode(array('success'=>true,'message'=>'No data found','data'=>$result));exit;
			}
		}
	}
	public function getIssuance()
	{
		$date = $this -> input -> get('date');
		$level = $this -> input -> get('level');
		$vlmisToken = $this -> input -> get('token');
		if($date AND $level AND $vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		}
		$result = array();
		$result = $this -> communication -> getIssuance($date);
		if($result){
			echo json_encode(array('success'=>true,'message'=>'Successful Response!','hash'=>md5(json_encode($result)),'data'=>$result));exit;
		}else{
			echo json_encode(array('success'=>true,'message'=>'No data found','data'=>$result));exit;
		}
	}
	public function getStockReceiving()
	{
		$date = $this -> input -> get('date');
		$level = $this -> input -> get('level');
		$vlmisToken = $this -> input -> get('token');
		if($date AND $level AND $vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		}
		if($level=="province"){
			$this->getProReceiving();
		}else if($level=="district"){
			$this->getReceiving();
		}
	}
	protected function getReceiving()
	{
		$date = $this -> input -> get('date');
		/* $level = $this -> input -> get('level');
		$vlmisToken = $this -> input -> get('token');
		if($date AND $level AND $vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		}
		$result = array(); */
		$result = $this -> communication -> getReceiving($date);
		if($result){
			echo json_encode(array('success'=>true,'message'=>'Successful Response!','hash'=>md5(json_encode($result)),'data'=>$result));exit;
		}else{
			echo json_encode(array('success'=>true,'message'=>'No data found','data'=>$result));exit;
		}
	}
	protected function getProReceiving()
	{
		$date = $this -> input -> get('date');
		/* $level = $this -> input -> get('level');
		$vlmisToken = $this -> input -> get('token');
		if($date AND $level AND $vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		} */
		$result = array();
		$result = $this -> communication -> getProReceiving($date);
		if($result){
			echo json_encode(array('success'=>true,'message'=>'Successful Response!','hash'=>md5(json_encode($result)),'data'=>$result));exit;
		}else{
			echo json_encode(array('success'=>true,'message'=>'No data found','data'=>$result));exit;
		}
	}
	public function getStockAdjustment()
	{
		$date = $this -> input -> get('date');
		$level = $this -> input -> get('level');
		$vlmisToken = $this -> input -> get('token');
		if($date AND $level AND $vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		}
		if($level=="province"){
			$this->getProAdjustment();
		}else if($level=="district"){
			$this->getAdjustment();
		}
	}
	protected function getAdjustment()
	{
		$date = $this -> input -> get('date');
		/* $level = $this -> input -> get('level');
		$vlmisToken = $this -> input -> get('token');
		if($date AND $level AND $vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		} */
		$result = array();
		$result = $this -> communication -> getAdjustment($date);
		if($result){
			echo json_encode(array('success'=>true,'message'=>'Successful Response!','data'=>$result));exit;
		}else{
			echo json_encode(array('success'=>true,'message'=>'No data found','data'=>$result));exit;
		}
	}
	protected function getProAdjustment()
	{
		$date = $this -> input -> get('date');
		/* $level = $this -> input -> get('level');
		$vlmisToken = $this -> input -> get('token');
		if($date AND $level AND $vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		} */
		$result = array();
		$result = $this -> communication -> getProAdjustment($date);
		if($result){
			echo json_encode(array('success'=>true,'message'=>'Successful Response!','data'=>$result));exit;
		}else{
			echo json_encode(array('success'=>true,'message'=>'No data found','data'=>$result));exit;
		}
	}
	public function getFacilities(){
		$vlmisToken = $this -> input -> get('token');
		if($vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		}
		$result = $this -> communication -> getFacilities();
		echo json_encode(array('success' => true,'message'=>'Successful Response','hash'=>md5(json_encode($result)),'data'=>$result));exit;
	}
	public function getTypes(){
		$vlmisToken = $this -> input -> get('token');
		if($vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		}
		$result = $this -> communication -> getTypes();
		echo json_encode(array('success' => true,'message'=>'Successful Response','hash'=>md5(json_encode($result)),'data'=>$result));exit;
	}
	public function getUCsPopulations(){
		echo json_encode(array('success' => true,'message'=>'API expired on 2019-03-26','data'=>array()));exit;
		/* $vlmisToken = $this -> input -> get('token');
		if($vlmisToken){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		}
		$result = $this -> communication -> getUcsPopulations();
		echo json_encode(array('success' => true,'message'=>'Successful Response','data'=>$result));exit; */
	}
	public function getEpiCentersPopulations(){
		echo json_encode(array('success' => true,'message'=>'API expired on 2019-03-26','data'=>array()));exit;
		/* $vlmisToken = $this -> input -> get('token');
		$distcode = $this -> input -> get('district_code');
		if($vlmisToken && $distcode){}else{
			echo json_encode(array('success'=>false,'message'=>'Request need all required parameters!'));exit;
		}
		$epiToken = sha1(md5("epivlmis#,0%$#communication".date("Y-m-d")));
		if($vlmisToken == $epiToken){}else{
			echo json_encode(array('success'=>false,'message'=>'This is not a valid request!'));exit;
		}
		$result = $this -> communication -> getEpiCentersPopulations($distcode);
		echo json_encode(array('success' => true,'message'=>'Successful Response','data'=>$result));exit; */
	}
}
?>