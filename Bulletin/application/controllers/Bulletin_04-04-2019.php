<?php
class Bulletin extends CI_Controller {
	
	public function __construct() {
		parent::__construct();		
	}
	public function index(){		
    $data= $this -> getPostedData();  
      $year=$data['year'];
		$week=sprintf("%02d", $data['week']);
       		if( ! $this -> getPostedData()){
			$data['fweek'] = currentWeek();
			$this -> load -> view('bulletin',$data);
		}else{  
           			 $data['fweek']= $year."-".$week;
			$this -> load -> view('bulletin',$data);
		}	
}     
 function getPostedData(){		
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
				if($data[$key] == NULL || $data[$key]=="0")
				unset($data[$key]);
		}
		return $data;
	}
}
?>