<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('app_api/api_helper');
		$this -> load -> model('API/app_api_model/Common_model','common');
		$this -> load -> model('API/app_api_model/Login_model','login');
		$this->output->set_content_type('application/json');
	}
		
	public function login()
	{
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');
		$row = $this->login->login($username, $password);
		if($row > 0)
		{
			switch ($row['level']) {
					case '1' :
						$row['curr_wh_type'] = 1;
						$row['curr_wh_code'] = 0;
						break;
					case '2' :
						if ($row['procode'] != "") {
							$row['curr_wh_type'] = 2;
							$row['curr_wh_code'] = $row['procode'];
						}
						break;
					case '3' :
						if ($row['procode'] != "" && $row['distcode'] != "") {
							$row['curr_wh_type'] = 4;
							$row['curr_wh_code'] = $row['distcode'];
						}
						break;
					case '4' :
						if ($row['procode'] != "" && $row['distcode'] != "" && $row['tcode'] != "") {
							$row['curr_wh_type'] = 5;
							$row['curr_wh_code'] = $row['tcode'];
						}
						
						break;
					case '6' :
						if($row['procode'] != "" && $row['distcode'] != "" && $row['facode'] != "") {
							$row['curr_wh_type'] = 6;
							$row['curr_wh_code'] = $row['facode'];
						}
						break;
						default :
						# code...
						break;
				}
			$response['userdata'] = array(
					'username'  => $row['username'],
					'User_Name' => $row['username'],
					'UserAuth'  => 'Yes',
					'UserLevel' => $row['level'],
					'UserType' => $row['utype'],
					'curr_wh_type' => $row['curr_wh_type'],
					'curr_wh_code' => $row['curr_wh_code'],
					//'shortname' => $row['shortname'],
					//'liveURL' => $row['liveURL'],
					//'localURL' => $row['localURL']
				);
			// [curr_wh_type] => 4 [curr_wh_code] => 351
			//[curr_wh_type] => 2 [curr_wh_code] => 3
			//$wh_whrarr = array("epi_stock_batch.status !="=>'Finished',"epi_stock_batch.warehouse_type_id"=>$this->session->curr_wh_type,"epi_stock_batch.code"=>$this->session->curr_wh_code,"epi_stock_master.draft"=>0,"epi_stock_master.transaction_type_id"=>2);
			$wh_whrarr = array("epi_stock_batch.status !="=>'Finished',"epi_stock_batch.warehouse_type_id"=>$row['curr_wh_type'],"epi_stock_batch.code"=>$row['curr_wh_code'],"epi_stock_master.draft"=>0,"epi_stock_master.transaction_type_id"=>2);
			$result = $this->common->fetchall("epi_stock_master",array("table"=>"epi_stock_batch","tablecol"=>"batch_master_id","id"=>"pk_id"),"DISTINCT ON (epi_stock_master.transaction_number) epi_stock_master.transaction_number",$wh_whrarr,NULL,array("by"=>"epi_stock_master.transaction_number","type"=>"ASC"));
			$response['vouchers'] = array_column($result, "transaction_number");
			$response['success'] = "yes";
			//$response['usernmae'] = $username;
		}
		else
		{
			$response['success'] = "no";	
		}
		return $this->output->set_output(json_encode($response));
	}
	
}
