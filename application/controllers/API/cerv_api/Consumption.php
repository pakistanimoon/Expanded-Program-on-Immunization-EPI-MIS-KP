<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumption extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this -> load -> model ('consumption/Crud_model',"crud");
		$this -> load -> helper('inventory_helper');
		$this -> load -> model ('Common_model',"common");
		$this->output->set_content_type('application/json');
	}
	public function vaccinesDailyRegister(){
		//$token = 'f64261396387defd0fbcade6194c04fd';
		//$userName = '191001469';
		//print_r($this -> input -> post()); exit();
		$post_data = $this -> input -> post();
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		$validationResult = validateToken($userName, $token);
		if($validationResult == TRUE){}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
		}
		if(isset($post_data['data'][0]) && is_array($post_data['data'][0])){
			foreach($post_data['data'] as $key=> $singlerec){
				$this->form_validation->set_data($singlerec);
				$this->form_validation->set_rules('techniciancode','Technician Code','required|min_length[9]|max_length[9]|trim');
				$this->form_validation->set_rules('facode','Facode','required|min_length[6]|max_length[6]|trim');
				$this->form_validation->set_rules('vaccinated','Vaccinated','required|trim');
				$this->form_validation->set_rules('batch_number','Batch Number','required|trim');
				$this->form_validation->set_rules('item_id','Item Id','required|greater_than[0]|max_length[3]|trim');
				$this->form_validation->set_rules('used_vials','Used Vials','required|greater_than_equal_to[0]|numeric|trim');
				$this->form_validation->set_rules('unused_vials','Unused Vials','required|greater_than_equal_to[0]|numeric|trim');
				$this->form_validation->set_rules('used_doses','Used Doses','required|greater_than_equal_to[0]|numeric|trim');
				$this->form_validation->set_rules('unused_doses','Unused Doses','required|greater_than_equal_to[0]|numeric|trim');
				$this->form_validation->set_rules('date','Date','required|callback_valid_date[Y-m-d]|trim');
				if ($this->form_validation->run() === FALSE) 
				{ 
					return $this->output->set_output(json_encode(array("success"=>"no","message"=>$this->form_validation->error_array(),"index"=>$key)));
				}  
				else{
					$fmonth =$post_data['data'][$key]['fmonth']= substr($singlerec['date'],0,7);
					$facode =$singlerec['facode'];
					$post_data['data'][$key]['created_date']= date('Y-m-d h:i:s'); 
				}
				$this->form_validation->reset_validation();
			}
				if(authenticationbyusername($userName)){	
					//print_r($post_data['data']);exit();
					$this->db->trans_start();
					$insert = $this->db->insert_batch('vaccine_vials_daily_record',$post_data['data']);
					$checkdata = $this -> crud -> checkmonthlyconsumption($fmonth,$facode); //check monthly report
					$getdata = $this -> crud -> getvaccinesDailyRegister($fmonth,$facode);
					$prevfmonth = date("Y-m",strtotime($fmonth.'-01'.' first day of previous month'));
					$issueditems = $this-> crud -> get_issued_items("1","6",$facode,$fmonth);
					$existingitems = $this-> crud -> get_existing_items($facode,$prevfmonth); 				
					$resultantarr = array();
					vaccinedailyfillarray($resultantarr,$issueditems);
					vaccinedailyfillarray($resultantarr,$existingitems); 
					vaccinedailyfillarray($resultantarr,$getdata); 
					ksort($resultantarr,SORT_NUMERIC);   
					//print_r($resultantarr); exit(); 
					if($checkdata==1){ 
						$result=$this->crud->consumptionmaster_detail_delete($fmonth,$facode);
					}
					extract($getdata[0], EXTR_SKIP);
					$data = array(
						'distcode' => $distcode,
						'fmonth' => $fmonth,
						'procode' => $procode,
						'tcode' => $tcode,
						'uncode' => $uncode,
						'facode' => $facode,
						'prepared_by' => $techniciancode,
						'created_by' => 'kpk'.$distcode.'_deo',
						'created_date' => date('Y-m-d'),
						'updated_date' => date('Y-m-d'),
						'is_compiled' => '0',
						'data_source' =>'app'
					);
					$recid = $this->common->insert_record("epi_consumption_master",$data,'consumption_master_id_seq');
					foreach($resultantarr as $key => $val){	
						$totalstock = $val['opening']+$val['recdoses'];
						$totalconsume = $val['used_doses']+$val['unused_doses'];
						$closing = $val['opening']+$val['recdoses']-$val['used_doses']-$val['unused_doses'];
						$closing = ($closing>0)?$closing:0; 
						if($val['vaccinated']>0 && $val['vaccinated'] > $totalstock){
							return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Product:".$val['item_name']." and Batch number:".$val['batch']." of Number of Children Vaccinated cannot be greater than total Available stock in doses.")));
							$this->db->trans_rollback();
						}
						if($totalconsume > $totalstock){
							return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Product:".$val['item_name']." and Batch number:".$val['batch']." of Used+Unused Doses/Vails cannot be greater than received+Opening balance")));
							$this->db->trans_rollback();
						}
						if($closing<0){
							return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Product:".$val['item_name']." and Batch number:".$val['batch']." of Used+Unused/Vails cannot be greater than received+Opening balance")));
							$this->db->trans_rollback();
						}
						if($val['vaccinated']>0 && $val['vaccinated'] > $totalconsume){
							return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Product:".$val['item_name']." and Batch number:".$val['batch']." of Total Doses Consumed cannot be less than total Children Vaccinated / Doses Administered")));
							$this->db->trans_rollback();
						}
						if($recid>0){
							$delta['main_id'] = $recid;
							$delta['item_id'] = $val['itemid'];
							$delta['batch_number'] = $val['batch'];
							$delta['batch_doses'] = $val['doses'];
							$delta['opening_doses'] = $val['opening'];
							$delta['received_doses'] = $val['recdoses'];
							$delta['used_doses'] = $val['used_doses'];
							$delta['used_vials'] = round($val['used_doses']/$val['doses'],2);
							$delta['unused_doses'] = $val['unused_doses'];
							$delta['unused_vials'] = round($val['unused_doses']/$val['doses'],2);
							$delta['closing_doses'] = $closing;
							$delta['closing_vials'] = round($closing/$val['doses'],2);
							$delta['vaccinated'] = $val['vaccinated'];
							$this->common->insert_record("epi_consumption_detail",$delta,'consumption_detail_id_seq');
						}
					} 
					$this->db->trans_complete();
				}
				else
				{
					return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed!")));
				}
				return $this->output->set_output(json_encode(array("success"=>"Yes","message"=>"Data Inserted Successfully!")));
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There is no item exist in [data] Key")));
		}	
	}
	public function valid_date($date,$format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}
}
?>	