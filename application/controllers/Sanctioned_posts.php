<?php
	class Sanctioned_posts extends CI_Controller {
		//================ Constructor function starts==================//
		public function __construct() {
			parent::__construct();

			$this -> load -> model('Sanctioned_posts_model');
			$this -> load -> model('Common_model');
			$this -> load -> helper('my_functions_helper');
			$this -> load -> helper('date');
		}
		//================ Constructor function ends ================//
		//-----------------------------------------------------------//
		//================ sanctionedPosts function starts ==========//
		public function sanctionedPosts(){
			//dataEntryValidator(0);
			if($this -> session -> District){
				$whereCondition = " WHERE distcode = '{$this -> session -> District}' AND procode = '".$_SESSION["Province"]."'";
			}else{
				$whereCondition = " WHERE distcode = 'pro' AND procode = '".$_SESSION["Province"]."'";
			}
			$rowcount = "SELECT count(*) as rows FROM sanctioned_posts_db {$whereCondition}";
			$result = $this -> db ->query($rowcount);
			$record = $result->row_array();
			$rows = $record['rows'];
			if($rows > 0){
				$data['data']='';
				$query="SELECT * FROM sanctioned_posts_db {$whereCondition}";
				$result=	$this -> db -> query($query);
				$data['districtsdata'] = $result->row();
				if(empty($data['districtsdata'])){
					echo "Some Error Occured";exit;
				}
				$data['fileToLoad'] = 'system_setup/sanctioned_posts_update';
				$data['pageTitle']='EPI-MIS | Sanctioned Post';
				$this->load->view('template/epi_template',$data);
			}
			else{
				$data['data']='';
				if($data != 0){
					$data['data']='';
					$data['fileToLoad'] = 'system_setup/sanctioned_posts';
					$data['pageTitle']='EPI-MIS | Sanctioned Posts';
					$this->load->view('template/epi_template',$data);
				}
				else{
					$data['message'] ="You must have rights to access this page.";
					$this -> load -> view ('message',$data);
				}
			}
		}
		//================ sanctionedPosts function ends ====================//		
		//-------------------------------------------------------------------//
		//================ save_sanctionedPosts function starts =============//
		public function save_sanctionedPosts(){			
			$data = array();
			if($this -> session -> District){
				$sanctionedposts_data['distcode'] = $distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> session -> District;
				$whereCondition = " WHERE distcode = '{$distcode}' AND procode = '".$_SESSION["Province"]."'";
			}else{
				$sanctionedposts_data['distcode'] = $distcode = 'pro';
				$whereCondition = " WHERE distcode IS NULL AND procode = '".$_SESSION["Province"]."'";
			}
			$sanctionedposts_data['dso'] = $this -> input -> post('dso');
			$sanctionedposts_data['dso_fill'] = $this -> input -> post('dso_fill');
			$sanctionedposts_data['computer_operator'] = $this->input->post('computer_operator');
			$sanctionedposts_data['computer_operator_fill'] = $this->input->post('computer_operator_fill');
			$sanctionedposts_data['hf_incharge'] = $this->input->post('hf_incharge');
			$sanctionedposts_data['hf_incharge_fill'] = $this->input->post('hf_incharge_fill');
			$sanctionedposts_data['store_keeper'] = $this->input->post('store_keeper');
			$sanctionedposts_data['store_keeper_fill'] = $this->input->post('store_keeper_fill');
			$sanctionedposts_data['epi_tech'] = $this->input->post('epi_tech');
			$sanctionedposts_data['epi_tech_fill'] = $this->input->post('epi_tech_fill');
			$sanctionedposts_data['driver'] = $this->input->post('driver');
			$sanctionedposts_data['driver_fill'] = $this->input->post('driver_fill');
			$sanctionedposts_data['epi_coordinator'] = $this->input->post('epi_coordinator');
			$sanctionedposts_data['epi_coordinator_fill'] = $this->input->post('epi_coordinator_fill');
			$sanctionedposts_data['dsv'] = $this->input->post('dsv');
			$sanctionedposts_data['dsv_fill'] = $this->input->post('dsv_fill');
			$sanctionedposts_data['tsv'] = $this->input->post('tsv');
			$sanctionedposts_data['tsv_fill'] = $this->input->post('tsv_fill');
			$sanctionedposts_data['asv'] = $this->input->post('asv');
			$sanctionedposts_data['asv_fill'] = $this->input->post('asv_fill');
			$sanctionedposts_data['cc_technician'] = $this->input->post('cc_technician');
			$sanctionedposts_data['cc_technician_fill'] = $this->input->post('cc_technician_fill');
			$sanctionedposts_data['cc_operator'] = $this->input->post('cc_operator');
			$sanctionedposts_data['cc_operator_fill'] = $this->input->post('cc_operator_fill');
			$sanctionedposts_data['cc_mechanic'] = $this->input->post('cc_mechanic');
			$sanctionedposts_data['cc_mechanic_fill'] = $this->input->post('cc_mechanic_fill');
			$sanctionedposts_data['cc_generator'] = $this->input->post('cc_generator');
			$sanctionedposts_data['cc_generator_fill'] = $this->input->post('cc_generator_fill');
			$rowcount = "SELECT count(*) as rows FROM sanctioned_posts_db {$whereCondition}";
			$result = $this -> db ->query($rowcount);
			$record = $result->row_array();
			$rows = $record['rows'];
			//print_r($rows);exit();
			if($rows > 0){
				if(isset($sanctionedposts_data)){
					$query = "DELETE FROM sanctioned_posts_db {$whereCondition}";
					$this -> db -> query($query);
					$this -> Common_model -> insert_record('sanctioned_posts_db',$sanctionedposts_data);
				}
			}
			else{
				if(isset($sanctionedposts_data)){
					$this -> Common_model -> insert_record('sanctioned_posts_db',$sanctionedposts_data);
				}	
			}
			redirect('Sanctioned_posts/sanctionedPosts');
		}
		//================ save_sanctionedPosts function ends ===================//
	}
?>