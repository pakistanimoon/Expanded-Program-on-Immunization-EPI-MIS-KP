<?php
	class Sanctionedposts_report extends CI_Controller {
		//================ Constructor function starts==================//
		public function __construct() {
			parent::__construct();

			$this -> load -> model('Sanctionedposts_report_model');
			$this -> load -> model('Common_model');
			$this -> load -> model('Filter_model');			
			$this -> load -> helper('my_functions_helper');
			$this -> load -> helper('epi_reports_helper');
			$this -> load -> helper('date');
		}
		//================ Constructor function ends ================//
		//-----------------------------------------------------------//
		//================ sanctionedpostsreport function starts ==========//
		public function sanctionedpostsreport(){
			$procode = $_SESSION["Province"];
			$wc = [];
			$wc[] = "procode = '" . $procode . "'";
			$neWc = $wc;
			$replacements = array(0 => "province");
			$neWc[0] = str_replace("procode", "province", $neWc[0]);
			$data = $this-> Sanctionedposts_report_model-> sanctioned_posts_report($neWc);			
			$data['data']=$data;
			//print_r($data);exit();
			if($data != 0){
			   $data['fileToLoad'] = 'system_setup/sanctionedposts_view';
				$data['pageTitle']='EPI-MIS | Sanctioned Posts Report';
				$this->load->view('template/reports_template',$data);
			}
			else{
				$data['message']="You must have rights to access this page.";
				$this->load->view("message",$data);
			}
	   }
		//================ sanctionedPosts function ends ====================//	

	}
?>