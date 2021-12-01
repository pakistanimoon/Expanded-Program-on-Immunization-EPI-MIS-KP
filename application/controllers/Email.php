<?php
class Email extends CI_Controller {

	public function __construct() {
		parent::__construct();		
		$this-> load-> library('breadcrumbs');
	}
		
	public function sendEmail()
	{	
		//print_r($_POST);exit();
		//phpinfo();exit();
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

		//$this-> email-> set_newline("\r\n");
		//$file = '/D:/AIRLINES/Kenya_Airways_B787-8.jpg';
		$data['data'] = '';
		$data['pageTitle'] = 'EPI-MIS | Email';		
		//$this-> load-> view('template/epi_template',$data);
		//$this-> email-> set_mailtype('html');
		$emailview = $this-> load-> view('email_form',$data, TRUE);
		//print_r($emailview);exit();
		$this-> email-> from('support@epimis.pacetec.net');// should be same as smtp_user
		$this-> email-> to('pace@pace-tech.com');		
		//$this-> email-> cc('rizwan.farooq@rebeltechnology.io');
		//$this-> email-> bcc('uzair@pace-tech.com');
		$this-> email-> subject('EPI Email List');
		$this-> email-> message($emailview, $data);
		$this-> email-> attach('includes/documents/ms_word.docx');
		if($this->email->send())
         echo "Sent";
      else
      	//echo "Not sent";
      	show_error($this->email->print_debugger());
	}

	public function saveEmail()
	{	
		//print_r($_POST);exit();
		$data['data'] = '';
		$data['fileToLoad'] = 'email_form';
		$data['pageTitle'] = 'EPI-MIS | Email';
		$this-> email-> set_mailtype('html');		
		// $this-> load-> view('template/epi_template',$data);
		// $this-> email-> set_mailtype('html');
		// $data['data']=$this->email->from('epi@epimis.com', 'Your Name');
		// $data['data']=$this->email->to('nasir@pace-tech.com');
		// $data['data']=$this->email->cc('another@another-example.com');
		// $data['data']=$this->email->bcc('them@their-example.com');
		// $mailtype	= 'text';
		// $data['data']=$this->email->subject('EPI Email');
		// $data['data']=$this->email->message('EPI notification email.');
		// $data['data']=$this->load->model('Population_model');		
		// $this->email->send();
		$this->load->view('template/epi_template',$data);
	}
}