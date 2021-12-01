<?php
class Coverage_consumption extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Coverage_consumption_model');
		$this -> load -> helper('epi_functions_helper');
		$code = md5(date("Y-n-d"));
		if(isset($_REQUEST['code']) && $_REQUEST['code'] == $code){
			$provinceCode = $_REQUEST['procode']; // procode during drilldown from Federal EPI
			$provinceName = get_Province_Name($provinceCode); // province name based on procode
			$sessionData = array(
				'username'  => "EPI Manager",
				'User_Name' => "EPI Manager",
				'federaluser' => true,
				'UserAuth'  => "Yes",
				'UserLevel' => '2',
				'UserType' => 'Manager',
				'utype' => 'Manager',
				'provincename' => $provinceName,
				'Province' => $provinceCode,
				'loginfrom' => "Pakistan EPI"
			);
			$this -> session -> set_userdata($sessionData);
		}else{
			if($this -> session -> UserAuth == 'Yes'){}else{
				authentication();
			}
		}
		//authentication();
		$this -> load -> model('Common_model');
	}
	
	//====================== Constructor Function Ends Here ==========================//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	public function Reports_Filters($reportName){
		//echo "i am here";exit;
		$data['data'] = $this -> Coverage_consumption_model -> Create_Reporting_Filters($reportName);
		//$data['data']=$data;
		if($data != 0){
            $data['fileToLoad'] = 'reports/reports_filters';
			$data['pageTitle']='Report Filters';
			$this -> load -> view('template/epi_template',$data);
		}
		else{
			$data['message']="You must have rights to access this page.";
			$this -> load -> view("message",$data);
		}
	}

	public function coverage_and_consumption()
	{
		// print_r($_POST); exit();
		if($this->input->get_post('distcode') && $this->input->get_post('year') && $this->input->get_post('month'))
		{
			$data['distcode'] = $this->input->get_post('distcode');
			$data['year'] = $this->input->get_post('year');
			$data['month'] = $this->input->get_post('month');
			//$data['distdrilldown'] = $drilldown = $this->input->get_post('distdrilldown');
		}
		else
		{
			$data = $this -> getPostedData();
		}

		if($this->uri->segment(3) != '' && strlen($this->uri->segment(3))==3)
		{
			$data['distcode'] = (null !== $this->uri->segment(3))?$this->uri->segment(3):$this->input->post('distcode');
			$data['year'] = (null !== $this->uri->segment(4))?$this->uri->segment(4):$this->input->post('year');
			$data['month'] = (null !== $this->uri->segment(5))?$this->uri->segment(5):$this->input->post('month');
		}
		$data['data']  = $this-> Coverage_consumption_model-> coverage_and_consumption($data);
		//print_r($data); exit();
		$data['data']['exportIcons']=exportIcons($_REQUEST);
        $data['fileToLoad'] = 'reports/coverage_and_consumption';
		$data['pageTitle']='Coverage and Consumption Report';
		$this -> load -> view('template/reports_template',$data);
	}
	
	function reportTitle($functionName){
		$title = "";
		//print_r($functionName);exit();
		switch($functionName){
			case "HR-Summary-Report":
				$title = "HR Summary Report";
				break;
		}		
		return $title;
	}
	
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
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