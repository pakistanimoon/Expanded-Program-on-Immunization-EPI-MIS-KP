<?php
	class Login extends CI_Controller {
		//================ Constructor function starts==================//
		public function __construct() {
			parent::__construct();
			$this -> load -> model('Login_model');
			$this -> load -> helper('date');
			$this -> load -> helper('epi_functions_helper');
			$this -> load -> helper('my_functions_helper');
		}
		//================ Constructor function ends=================//
		//----------------------------------------------------------//
		//================ Index function starts====================//
		public function index() {
			if($this -> session -> UserAuth == 'Yes' ){
				$data['data']=NULL;
				$data['fileToLoad'] = 'main';
				$data['pageTitle'] = 'EPI-MIS | ' . $this -> session -> provincename;
				$this -> load -> model('Common_model','common');
				$wh_whrarr = array("epi_stock_batch.status !="=>'Finished',"epi_stock_batch.warehouse_type_id"=>$this->session->curr_wh_type,"epi_stock_batch.code"=>$this->session->curr_wh_code,"epi_stock_master.draft"=>0,"epi_stock_master.transaction_type_id"=>2);
				$data['data']['vouchers'] = $this->common->fetchall("epi_stock_master",array("table"=>"epi_stock_batch","tablecol"=>"batch_master_id","id"=>"pk_id"),"DISTINCT ON (epi_stock_master.transaction_number) epi_stock_master.transaction_number",$wh_whrarr,NULL,array("by"=>"epi_stock_master.transaction_number","type"=>"ASC"));
				$this->load->view('template/epi_template',$data);
			}else{
				$data['msg']="Sorry , you have entered invalid security code.";
				$this -> load -> view('index',$data);
			}
		}
		//================ Index function ends======================//
		//----------------------------------------------------------//
		//================ Login function starts====================//
		public function login() {
			$username = $this -> input -> post('username');
			$password = $this -> input -> post('password');
			date_default_timezone_set("Asia/Karachi");
			$curr_date = date("Y-m-d");
			$ip = $_SERVER['REMOTE_ADDR'];
			$this -> session -> expire = time() + (120 * 120);
			$row=$this->Login_model->login($username,$password);
			if($row > 0){
				$sessionData = array(
					'username'  => $row['username'],
					'User_Name' => $row['username'],
					'UserAuth'  => 'Yes',
					'UserLevel' => $row['level'],
					'UserType' => $row['utype'],
					'shortname' => $row['shortname'],
					'liveURL' => $row['liveURL'],
					'localURL' => $row['localURL']
				);
				
				$this -> session -> set_userdata($sessionData);
				switch ($this -> session -> UserLevel) {
					case '99' :
						if ($row['procode'] != "") {
							$this -> session -> Province = $row['procode'];
							$this -> session -> login_yes = "logged in";
							$this -> session -> curr_wh_type = 99;
							$this -> session -> curr_wh_code = $row['procode'];
						}
						switch($row['procode']){
							case 3: 
								$this -> session -> loginfrom = "Khyber Pakhtunkhwa";
								break;
							case 4: 
								$this -> session -> loginfrom = "Balochistan";
								break;
							case 5: 
								$this -> session -> loginfrom = "AJK";
								break;
							case 6: 
								$this -> session -> loginfrom = "Gilgit Baltistan";
								break;
							case 7: 
								$this -> session -> loginfrom = "Islamabad";
								break;
							case 8: 
								$this -> session -> loginfrom = "FATA";
								break;
						}
						break;
					case '1' :
						$this -> session -> curr_wh_type = 1;
						$this -> session -> curr_wh_code = 0;
						break;
					case '2' :
						if ($row['procode'] != "") {
							$this -> session -> Province = $row['procode'];
							$this -> session -> login_yes = "logged in";
							$this -> session -> curr_wh_type = 2;
							$this -> session -> curr_wh_code = $row['procode'];
						}
						switch($row['procode']){
							case 3: 
								$this -> session -> loginfrom = "Khyber Pakhtunkhwa";
								break;
							case 4: 
								$this -> session -> loginfrom = "Balochistan";
								break;
							case 5: 
								$this -> session -> loginfrom = "AJK";
								break;
							case 6: 
								$this -> session -> loginfrom = "Gilgit Baltistan";
								break;
							case 7: 
								$this -> session -> loginfrom = "Islamabad";
								break;
							case 8: 
								$this -> session -> loginfrom = "FATA";
								break;
						}
						break;
					case '3' :
						if ($row['procode'] != "" && $row['distcode'] != "") {
							$this -> session -> District = $row['distcode'];
							$this -> session -> Province = $row['procode'];
							$this -> session -> shortname = get_Province_ShortName($row['procode']);
							$this -> session -> liveURL = get_Region_Live_Url($row['procode']);
							$this -> session -> localURL = get_Region_Local_Url($row['procode']);
							$this -> session -> login_yes = "logged in";
							$this -> session -> curr_wh_type = 4;
							$this -> session -> curr_wh_code = $row['distcode'];
							$this -> session -> loginfrom = DistrictName($row['distcode']);
							syncComplianceDataWithFederalEPIMIS('vaccinationcompliance');
							syncComplianceDataWithFederalEPIMIS('consumptioncompliance');
							syncComplianceDataWithFederalEPIMIS('zeroreportcompliance');
						}
						break;
					case '4' :
						if ($row['procode'] != "" && $row['distcode'] != "" && $row['tcode'] != "") {
							$this -> session -> distcode = $row['distcode'];
							$this -> session -> tcode = $row['tcode'];
							$this -> session -> Tehsil = $row['tcode'];
							$this -> session -> District = $row['distcode'];
							$this -> session -> Province = $row['procode'];
							$this -> session -> login_yes = "logged in";
							$this -> session -> curr_wh_type = 5;
							$this -> session -> curr_wh_code = $row['tcode'];
							$this -> session -> loginfrom = TehsilName($row['tcode']);
						}
						break;
					case '6' :
						if ($row['procode'] != "" && $row['distcode'] != "" && $row['facode'] != "") {
							$this -> session -> distcode = $row['distcode'];
							$this -> session -> tcode = $row['tcode'];
							$this -> session -> facode = $row['facode'];
							$this -> session -> Tehsil = $row['tcode'];
							$this -> session -> District = $row['distcode'];
							$this -> session -> Province = $row['procode'];
							$this -> session -> login_yes = "logged in";
							$this -> session -> curr_wh_type = 6;
							$this -> session -> curr_wh_code = $row['facode'];
							$this -> session -> loginfrom = FacilityName($row['facode']);
						}
						break;
						default :
						# code...
						break;
				}
				$this -> session -> TehsilCode = $row['tcode'];
				$this -> session -> utype = $row['utype'];
				$data['data']="";
				if ($this -> session -> UserLevel=='1'){
				}
				elseif($this -> session -> UserLevel=='2'){
				}
				elseif($this -> session -> UserLevel=='3'){
					$this -> session -> loginfrom = $row['loginfrom'];
				}
				switch($row['procode']){
					case 3: 
						$this -> session -> provincename = "Khyber Pakhtunkhwa";
						break;
					case 4: 
						$this -> session -> provincename = "Balochistan";
						break;
					case 5: 
						$this -> session -> provincename = "AJK";
						break;
					case 6: 
						$this -> session -> provincename = "Gilgit Baltistan";
						break;
					case 7: 
						$this -> session -> provincename = "Islamabad";
						break;
					case 8: 
						$this -> session -> provincename = "FATA";
						break;
				}
				//print_r($_SESSION);exit;
			}
			else{
				$this -> session -> set_flashdata('message', 'Sorry, you enter wrong Username or Password! Login Again!');
				}
			redirect(base_url());
		}
		//================ Login function ends======================//
		//----------------------------------------------------------//
		//================ Log out function starts==================//
		public function logout() {
			$this->db->set('active', 0)->where('username', $this -> session -> username)->update('epiusers');
			$this->session->sess_destroy();
			redirect(base_url()); 
		}
		//================ Log out function ends==================//
		//----------------------------------------------------------//
		//================ Change Password function starts==================//
		public function change_password() {
			dataEntryValidator();
			$data['edit']="Yes";
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/change_pass';
			$data['pageTitle'] = 'EPI Technician-MIS | Add New EPI Technician Form';
			$this -> load -> view('template/epi_template', $data);
			
		}
//================ Change Password function ends==================//
	}
?>