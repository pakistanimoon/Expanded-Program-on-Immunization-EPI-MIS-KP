<?php
class Bulletin extends CI_Controller {
	
	public function __construct() {
		parent::__construct();	
		$this -> load -> model('Bulletin_model');
		//$this -> load -> helper('epi_reports_helper');	
	}

	public function index()
	{	
		//print_r($_POST);exit();	
		$data = $this -> getPostedData();
		$year = $data['year'];
		if($data['from_week'] == 0){	
			$data['from_week']=1;
		}
		if($data['to_week'] == 0){
			if($data['year'] == date('Y')){
				$currentweek =	date('W');
				$data['to_week']= $currentweek -1 ;
			}
			else{
				$data['to_week'] = 52;
			}
			
		}
		
		$data['from_week'] = $fromweek = sprintf("%02d", $data['from_week']);
		$data['to_week'] =   $toweek = sprintf("%02d", $data['to_week']);
		
		$data['data'] = $this-> Bulletin_model-> highlight($data);
       	if( ! $this -> getPostedData()){
			$this -> load -> view('bulletin',$data);
		}else{
			$this -> load -> view('bulletin',$data);
		}
	}    

	function getPostedData()
	{		
		$data=array();$dataPosted=array();	
		$dataPosted = $_REQUEST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");		
		foreach($dataPosted as $key => $value){
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format){
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) )
 				{
                }else
				{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
		}
		return $data;
	}
}
?>