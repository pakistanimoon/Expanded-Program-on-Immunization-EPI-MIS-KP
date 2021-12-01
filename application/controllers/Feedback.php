<?php
class Feedback extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this-> load-> model('Common_model');		
		$this-> load-> library('breadcrumbs');
	}

	public function feedbackForm()
	{	
		$data['data'] = '';
		$data['fileToLoad'] = 'feedback_form';
		$data['pageTitle'] = 'EPI-MIS | Feedback';		
		$this->load->view('template/epi_template',$data);
	}
		
	public function sendFeedback()
	{			
		$date = date('Y-m-d');
		$have_any_difficulty= ($this-> input-> post('have_any_difficulty'))? $this-> input-> post('have_any_difficulty') : 'No';
		$use_any_report= ($this-> input-> post('use_any_report'))? $this-> input-> post('use_any_report') : 'No';
		$comments= ($this-> input-> post('comments'))? $this-> input-> post('comments') : '';
		$submitted_date= $date;
		//print_r($data['feedBackData']);exit();
		//$this-> Common_model-> insert_record('feedback_db', $feedbackData);

		$messagetemplate = '<html><body>';
		$messagetemplate .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
		$messagetemplate .= "<tr style='background: #eee;'><td width='30%''><strong>Please give us your valuable feedback</strong></td><td><strong>EPI - MIS User Feedback</strong></td></tr>";
		$messagetemplate .= "<tr><td><strong>Do you have any difficulty with data entry?</strong> </td><td>" . $have_any_difficulty . "</td></tr>";
		$messagetemplate .= "<tr><td><strong>Do you use any report?</strong> </td><td>" . $use_any_report . "</td></tr>";
		$messagetemplate .= "<tr><td><strong>Any Comments/ Improvement/ Problems:</strong> </td><td>" . $comments . "</td></tr>";
		$messagetemplate .= "</table>";
		$messagetemplate .= "</body></html>";
		//echo $messagetemplate;exit();

		$this-> load-> database();
		$config = Array(
			'protocol' => 'mail',
			'smtp_host' => 'mail.epimis.pacetec.net',//lpmail08.lunariffic.com
			'smtp_port' => '25',
			'smtp_user' => 'support@epimis.pacetec.net',
			'smtp_pass' => '$upp0Rt123',	
	      'mailtype' => 'html'
	      //'priority' => '1'
    	);
		//print_r($config);exit();
		$this-> load-> library('email', $config);
		$this-> load-> helper('path');
		
		$data['data'] = '';
		$data['pageTitle'] = 'EPI-MIS | Feedback';
		
		$this-> email-> from('support@epimis.pacetec.net');// should be same as smtp_user
		$this-> email-> to('nasir@pace-tech.com');		
		//$this-> email-> cc('rizwan.farooq@rebeltechnology.io');
		//$this-> email-> bcc('uzair@pace-tech.com');
		$this-> email-> subject('EPI Feedback');
		$this-> email-> message($messagetemplate, $data);
		$location = base_url(). "Feedback/feedbackForm/";
		if($this->email->send()){			
			echo '<script language="javascript" type="text/javascript"> alert("Your feedback has been sent.....");	window.location="'.$location.'"</script>';
		}         
      	else{
      		echo '<script language="javascript" type="text/javascript"> alert("Your feedback has not been sent.....");	window.location="'.$location.'"</script>';
      	}      	
	}	
}