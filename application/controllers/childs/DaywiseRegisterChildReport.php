<?php
class DaywiseRegisterChildReport extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('Daywisechildreport_model');
		$this -> load -> helper('epi_functions_helper'); 
		authentication();
		
	}
	public function DayWisechildRegistrationList(){
		$data['fmonth']=$this->input->post_get('fmonth');
		$data['data'] = $this -> Daywisechildreport_model -> DaywiseChild_report($data);
		$data['fileToLoad'] = 'childs/Day_wise_child_registration_list';	
		$data['pageTitle'] = 'Day Wise Report';	

		$this -> load ->view ('template/epi_template',$data);		
	}
	
	

		function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y","mm-yyyy","yyyy-mm");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}
				else
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