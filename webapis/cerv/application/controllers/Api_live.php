<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Apis_model','apis');
		$this -> load -> helper('apis_helper');
		$this->output->set_content_type('application/json');
	}
	
	public function login(){
		$data = json_encode($this -> input -> post());
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');
		$imeino = $this -> input -> post('imei_no');
		$action = $this -> input -> post('action');
		$model_no = $this -> input -> post('model_no');
		if(authentication($username, $password)){
			updateimei($username, $imeino);
			$response = json_encode(loginresponsejson($username));
			loginlog($username, "Success", $data, $_SERVER['REMOTE_ADDR'], $imeino, "Mobile", "", $response);
			if($model_no != '')
				updateTechnicianModelNo($username,$model_no);
		}else{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));
			loginlog($username, "Failed", $data, $_SERVER['REMOTE_ADDR'], $imeino, "Mobile", "Authentication Closed", $response);
		}
		return $this->output->set_output($response);
	}
	
	public function register_child()
	{
		date_default_timezone_set("Asia/Karachi");
		$userName = $this -> input -> post('username');
		// Configuration Keys
		$insertData['reg_facode'] = $registeringFacilityCode = $this -> input -> post('reg_facode');
		$insertData['year'] = $year = $this -> input -> post('year');
		$insertData['techniciancode'] = $techniciancode = $this -> input -> post('techniciancode');
		$insertData['child_registration_no'] = $childRegistrationNo = $this -> input -> post('child_registration_no');
		$insertData['cardno'] = $cardNo = $this -> input -> post('cardno');
		if($cardNo < 1)
		{
			$tempRegistrationCode = $this -> input -> post('temp_no');
			$maxCardNo = getMaxCardNoforChild($techniciancode);
			$newCardNo = sprintf("%05d", ($maxCardNo + 1));
			$insertData['child_registration_no'] = $newRegistrationNumb = $techniciancode.'-'.$year.'-'.$newCardNo;
			$insertData['cardno'] = $newCardNo;
			$response['reg_id'] = $newRegistrationNumb;
			$response['temp_no'] = $tempRegistrationCode;
		}
		
		$insertData['procode'] = $this -> input -> post('procode');
		$insertData['distcode'] = $this -> input -> post('distcode');
		$insertData['tcode'] = $this -> input -> post('tcode');
		$insertData['uncode'] = $this -> input -> post('uncode');
		$insertData['imei'] = $imeiNo = $this -> input -> post('imei');
		// Basic Information Keys
		$insertData['nameofchild'] = $this -> input -> post('nameofchild');
		$insertData['gender'] = $this -> input -> post('gender');
		$insertData['dateofbirth'] = $this -> input -> post('dateofbirth');
		$insertData['fathername'] = $this -> input -> post('fathername');
		$insertData['fathercnic'] = $this -> input -> post('fathercnic');
		$insertData['mothername'] = $this -> input -> post('mothername');
		$insertData['mothercnic'] = $this -> input -> post('mothercnic');
		$insertData['contactno'] = $this -> input -> post('contactno');
		$insertData['housestreet'] = $this -> input -> post('housestreet');
		$insertData['villagemohallah'] = $this -> input -> post('villagemohallah');
		$insertData['fingerprint'] = $this -> input -> post('fingerprint');
		$insertData['latitude'] = $this -> input -> post('latitude');
		$insertData['longitude'] = $this -> input -> post('longitude');
		// Vaccines Administered Keys
		$insertData['bcg'] = $this -> input -> post('bcg');
		$insertData['hepb'] = $this -> input -> post('hepb');
		$insertData['opv0'] = $this -> input -> post('opv0');
		$insertData['opv1'] = $this -> input -> post('opv1');
		$insertData['opv2'] = $this -> input -> post('opv2');
		$insertData['opv3'] = $this -> input -> post('opv3');
		$insertData['penta1'] = $this -> input -> post('penta1');
		$insertData['penta2'] = $this -> input -> post('penta2');
		$insertData['penta3'] = $this -> input -> post('penta3');
		$insertData['pcv1'] = $this -> input -> post('pcv1');
		$insertData['pcv2'] = $this -> input -> post('pcv2');
		$insertData['pcv3'] = $this -> input -> post('pcv3');
		$insertData['ipv'] = $this -> input -> post('ipv');
		$insertData['rota1'] = $this -> input -> post('rota1');
		$insertData['rota2'] = $this -> input -> post('rota2');
		$insertData['measles1'] = $this -> input -> post('measles1');
		$insertData['measles2'] = $this -> input -> post('measles2');
		// Vaccine Administered on Epi Center Keys
		$insertData['bcg_facode'] = $this -> input -> post('bcg_facode');
		$insertData['hepb_facode'] = $this -> input -> post('hepb_facode');
		$insertData['opv0_facode'] = $this -> input -> post('opv0_facode');
		$insertData['opv1_facode'] = $this -> input -> post('opv1_facode');
		$insertData['opv2_facode'] = $this -> input -> post('opv2_facode');
		$insertData['opv3_facode'] = $this -> input -> post('opv3_facode');
		$insertData['penta1_facode'] = $this -> input -> post('penta1_facode');
		$insertData['penta2_facode'] = $this -> input -> post('penta2_facode');
		$insertData['penta3_facode'] = $this -> input -> post('penta3_facode');
		$insertData['pcv1_facode'] = $this -> input -> post('pcv1_facode');
		$insertData['pcv2_facode'] = $this -> input -> post('pcv2_facode');
		$insertData['pcv3_facode'] = $this -> input -> post('pcv3_facode');
		$insertData['ipv_facode'] = $this -> input -> post('ipv_facode');
		$insertData['rota1_facode'] = $this -> input -> post('rota1_facode');
		$insertData['rota2_facode'] = $this -> input -> post('rota2_facode');
		$insertData['measles1_facode'] = $this -> input -> post('measles1_facode');
		$insertData['measles2_facode'] = $this -> input -> post('measles2_facode');
		// Vaccine Administered by EPI Technicians
		$insertData['bcg_techniciancode'] = $this -> input -> post('bcg_techniciancode');
		$insertData['hepb_techniciancode'] = $this -> input -> post('hepb_techniciancode');
		$insertData['opv0_techniciancode'] = $this -> input -> post('opv0_techniciancode');
		$insertData['opv1_techniciancode'] = $this -> input -> post('opv1_techniciancode');
		$insertData['opv2_techniciancode'] = $this -> input -> post('opv2_techniciancode');
		$insertData['opv3_techniciancode'] = $this -> input -> post('opv3_techniciancode');
		$insertData['penta1_techniciancode'] = $this -> input -> post('penta1_techniciancode');
		$insertData['penta2_techniciancode'] = $this -> input -> post('penta2_techniciancode');
		$insertData['penta3_techniciancode'] = $this -> input -> post('penta3_techniciancode');
		$insertData['pcv1_techniciancode'] = $this -> input -> post('pcv1_techniciancode');
		$insertData['pcv2_techniciancode'] = $this -> input -> post('pcv2_techniciancode');
		$insertData['pcv3_techniciancode'] = $this -> input -> post('pcv3_techniciancode');
		$insertData['ipv_techniciancode'] = $this -> input -> post('ipv_techniciancode');
		$insertData['rota1_techniciancode'] = $this -> input -> post('rota1_techniciancode');
		$insertData['rota2_techniciancode'] = $this -> input -> post('rota2_techniciancode');
		$insertData['measles1_techniciancode'] = $this -> input -> post('measles1_techniciancode');
		$insertData['measles2_techniciancode'] = $this -> input -> post('measles2_techniciancode');
		// Vaccine Administered Latitude Longitude Keys
		$insertData['bcg_lat'] = $this -> input -> post('bcg_lat');
		$insertData['bcg_long'] = $this -> input -> post('bcg_long');
		$insertData['hepb_lat'] = $this -> input -> post('hepb_lat');
		$insertData['hepb_long'] = $this -> input -> post('hepb_long');
		$insertData['opv0_lat'] = $this -> input -> post('opv0_lat');
		$insertData['opv0_long'] = $this -> input -> post('opv0_long');
		$insertData['opv1_lat'] = $this -> input -> post('opv1_lat');
		$insertData['opv1_long'] = $this -> input -> post('opv1_long');
		$insertData['opv2_lat'] = $this -> input -> post('opv2_lat');
		$insertData['opv2_long'] = $this -> input -> post('opv2_long');
		$insertData['opv3_lat'] = $this -> input -> post('opv3_lat');
		$insertData['opv3_long'] = $this -> input -> post('opv3_long');
		$insertData['penta1_lat'] = $this -> input -> post('penta1_lat');
		$insertData['penta1_long'] = $this -> input -> post('penta1_long');
		$insertData['penta2_lat'] = $this -> input -> post('penta2_lat');
		$insertData['penta2_long'] = $this -> input -> post('penta2_long');
		$insertData['penta3_lat'] = $this -> input -> post('penta3_lat');
		$insertData['penta3_long'] = $this -> input -> post('penta3_long');
		$insertData['pcv1_lat'] = $this -> input -> post('pcv1_lat');
		$insertData['pcv1_long'] = $this -> input -> post('pcv1_long');
		$insertData['pcv2_lat'] = $this -> input -> post('pcv2_lat');
		$insertData['pcv2_long'] = $this -> input -> post('pcv2_long');
		$insertData['pcv3_lat'] = $this -> input -> post('pcv3_lat');
		$insertData['pcv3_long'] = $this -> input -> post('pcv3_long');
		$insertData['ipv_lat'] = $this -> input -> post('ipv_lat');
		$insertData['ipv_long'] = $this -> input -> post('ipv_long');
		$insertData['rota1_lat'] = $this -> input -> post('rota1_lat');
		$insertData['rota1_long'] = $this -> input -> post('rota1_long');
		$insertData['rota2_lat'] = $this -> input -> post('rota2_lat');
		$insertData['rota2_long'] = $this -> input -> post('rota2_long');
		$insertData['measles1_lat'] = $this -> input -> post('measles1_lat');
		$insertData['measles1_long'] = $this -> input -> post('measles1_long');
		$insertData['measles2_lat'] = $this -> input -> post('measles2_lat');
		$insertData['measles2_long'] = $this -> input -> post('measles2_long');
		//Vaccine Vaccination Mode keys
		$insertData['bcg_mode'] = $this -> input -> post('bcg_mode');
		$insertData['hepb_mode'] = $this -> input -> post('hepb_mode');
		$insertData['opv0_mode'] = $this -> input -> post('opv0_mode');
		$insertData['opv1_mode'] = $this -> input -> post('opv1_mode');
		$insertData['opv2_mode'] = $this -> input -> post('opv2_mode');
		$insertData['opv3_mode'] = $this -> input -> post('opv3_mode');
		$insertData['penta1_mode'] = $this -> input -> post('penta1_mode');
		$insertData['penta2_mode'] = $this -> input -> post('penta2_mode');
		$insertData['penta3_mode'] = $this -> input -> post('penta3_mode');
		$insertData['pcv1_mode'] = $this -> input -> post('pcv1_mode');
		$insertData['pcv2_mode'] = $this -> input -> post('pcv2_mode');
		$insertData['pcv3_mode'] = $this -> input -> post('pcv3_mode');
		$insertData['ipv_mode'] = $this -> input -> post('ipv_mode');
		$insertData['rota1_mode'] = $this -> input -> post('rota1_mode');
		$insertData['rota2_mode'] = $this -> input -> post('rota2_mode');
		$insertData['measles1_mode'] = $this -> input -> post('measles1_mode');
		$insertData['measles2_mode'] = $this -> input -> post('measles2_mode');
		// Outer Registered Keys
		$insertData['isoutsitefacility'] = $this -> input -> post('isoutsitefacility');
		// Other Submittion Keys
		$insertData['issynced'] = $this -> input -> post('issynced');
		// Upload Image
		if($_FILES){
			$fileName = basename($_FILES['pic']['name']);
			$fileArray = explode('.', $fileName);
			$fileExt = ".jpg";
			$date = date('Y-m-d H:i:s');
			$temp = $_FILES['pic']['tmp_name'];
			$dir_separator = DIRECTORY_SEPARATOR;
			$folder = "/assets/childs";
			$destination_path = getcwd().$folder.$dir_separator;
			$target_path = $destination_path.$fileName;
			if (move_uploaded_file($temp,$target_path)){
				$response['image_success'] = "Image uploaded!";
			}else{
				$response['image_success'] = "Image was not uploaded!".$_FILES['pic']['error'];
			}
		}else{
			$response['image_success'] = "No image found!";
		}
		// Remove Null posted keys from array
		$data=array();
		foreach($insertData as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			if($data[$key] == NULL)
				unset($data[$key]);
		}
		// Authenticate technician 
		if(authenticationbyimei($userName, $imeiNo))
		{
			// Check if child already registered
			$childAlreadyRegistered = $this -> apis -> checkChildRegistered($childRegistrationNo);
			// Update if child already registered
			if($childAlreadyRegistered)
			{
				$update = $this -> apis -> updateChildRegistrationData($data,$childRegistrationNo);
				if($update)
					$response['success'] = "yes";
			}else
			{
				// Insert new registring child
				$insert = $this -> apis -> saveNewRegisteredChildData($data);
				if($insert)
					$response['success'] = "yes";
			}
		}else
		{
			$response['success'] = "no";
			$response['message'] = "Authentication Failed!";
		}
		// Output response
		return $this->output->set_output(json_encode($response));
	}
	
	public function get_child_card_no()
	{
		$techniciancode = $this -> input -> get('techniciancode');
		$maxCardNo = getMaxCardNoforChild($techniciancode);
		$maxCardNo = ($maxCardNo + 1);
		$newCardNo = sprintf("%05d", $maxCardNo);
		$response['success'] = "yes";
		$response['cardno'] = $newCardNo;
		return $this->output->set_output(json_encode($response));
	}
	
	public function get_mother_card_no()
	{
		$techniciancode = $this -> input -> get('techniciancode');
		$maxCardNo = getMaxCardNoforMother($techniciancode);
		$newCardNo = sprintf("%05d", ($maxCardNo + 1));
		$response['success'] = "yes";
		$response['cardno'] = $newCardNo;
		return $this->output->set_output(json_encode($response));
	}
	
	public function downSyncChildrenDataFromServer()
	{
		$userName = $this -> input -> get('username');
		$imeiNo = $this -> input -> get('imei_no');
		if(authenticationbyimei($userName, $imeiNo)){ 
			$response = json_encode(array("success"=>"yes", "data"=>($userName)));
		}else{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));		
		}
		// Output response
		return $this->output->set_output($response);
	}
	
	public function register_mother()
	{
		date_default_timezone_set("Asia/Karachi");
		$userName = $techniciancode = $this -> input -> post('techniciancode');
		// Configuration Keys
		$insertData['reg_facode'] = $registeringFacilityCode = $this -> input -> post('reg_facode');
		$insertData['imei'] = $imeiNo = $this -> input -> post('imei');
		$insertData['year'] = $year = $this -> input -> post('year');
		$insertData['mother_registration_no'] = $motherRegistrationNo = $this -> input -> post('mother_registration_no');
		$insertData['cardno'] = $cardNo = $this -> input -> post('cardno');
		$insertData['techniciancode'] = $this -> input -> post('techniciancode');
		
		if($cardNo < 1)
		{
			$tempRegistrationCode = $this -> input -> post('temp_no');
			$maxCardNo = getMaxCardNoforMother($techniciancode);
			$newCardNo = sprintf("%05d", ($maxCardNo + 1));
			$insertData['mother_registration_no'] = $newRegistrationNumb = $techniciancode.'-'.$year.'-'.$newCardNo;
			$insertData['cardno'] = $newCardNo;
			$response['reg_id'] = $newRegistrationNumb;
			$response['temp_no'] = $tempRegistrationCode;
		}
		
		$insertData['procode'] = $this -> input -> post('procode');
		$insertData['distcode'] = $this -> input -> post('distcode');
		$insertData['tcode'] = $this -> input -> post('tcode');
		$insertData['uncode'] = $this -> input -> post('uncode');
		// Basic Information Keys
		$insertData['latitude'] = $this -> input -> post('latitude');
		$insertData['longitude'] = $this -> input -> post('longitude');
		$insertData['fingerprint'] = $this -> input -> post('fingerprint');
		$insertData['mother_name'] = $this -> input -> post('mother_name');
		$insertData['mother_age'] = $this -> input -> post('mother_age');
		$insertData['husband_name'] = $this -> input -> post('husband_name');
		$insertData['mother_cnic'] = $this -> input -> post('mother_cnic');
		$insertData['contactno'] = $this -> input -> post('contactno');
		$insertData['village'] = $this -> input -> post('village');
		$insertData['house'] = $this -> input -> post('house');
		// Dates for Vaccines Administered Keys
		$insertData['tt1'] = $this -> input -> post('tt1');
		$insertData['tt2'] = $this -> input -> post('tt2');
		$insertData['tt3'] = $this -> input -> post('tt3');
		$insertData['tt4'] = $this -> input -> post('tt4');
		$insertData['tt5'] = $this -> input -> post('tt5');
		// Vaccine Doses Vaccination Mode Keys
		$insertData['tt1_mode'] = $this -> input -> post('tt1_mode');
		$insertData['tt2_mode'] = $this -> input -> post('tt2_mode');
		$insertData['tt3_mode'] = $this -> input -> post('tt3_mode');
		$insertData['tt4_mode'] = $this -> input -> post('tt4_mode');
		$insertData['tt5_mode'] = $this -> input -> post('tt5_mode');
		// Vaccine Administered on Epi Center Keys
		$insertData['tt1_facode'] = $this -> input -> post('tt1_facode');
		$insertData['tt2_facode'] = $this -> input -> post('tt2_facode');
		$insertData['tt3_facode'] = $this -> input -> post('tt3_facode');
		$insertData['tt4_facode'] = $this -> input -> post('tt4_facode');
		$insertData['tt5_facode'] = $this -> input -> post('tt5_facode');
		// Vaccine Administered Latitude Longitude Keys
		$insertData['tt1_lat'] = $this -> input -> post('tt1_lat');
		$insertData['tt1_long'] = $this -> input -> post('tt1_long');
		$insertData['tt2_lat'] = $this -> input -> post('tt2_lat');
		$insertData['tt2_long'] = $this -> input -> post('tt2_long');
		$insertData['tt3_lat'] = $this -> input -> post('tt3_lat');
		$insertData['tt3_long'] = $this -> input -> post('tt3_long');
		$insertData['tt4_lat'] = $this -> input -> post('tt4_lat');
		$insertData['tt4_long'] = $this -> input -> post('tt4_long');
		$insertData['tt5_lat'] = $this -> input -> post('tt5_lat');
		$insertData['tt5_long'] = $this -> input -> post('tt5_long');
		// Outer Registered Keys
		$insertData['is_outer_registered'] = $this -> input -> post('is_outer_registered');
		// Other Submittion Keys
		$insertData['is_synced'] = $this -> input -> post('is_synced');
		// Remove Null posted keys from array
		$data=array();
		foreach($insertData as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			if($data[$key] == NULL)
				unset($data[$key]);
		}
		// Authenticate technician 
		if(authenticationbyimei($userName, $imeiNo))
		{
			// Check if mother already registered
			$motherAlreadyRegistered = $this -> apis -> checkMotherRegistered($motherRegistrationNo);
			// Update if mother already registered
			if($motherAlreadyRegistered)
			{
				$update = $this -> apis -> updateMotherRegistrationData($data,$motherRegistrationNo);
				if($update)
					$response['success'] = "yes";
			}else
			{
				// Insert new registring mother
				$insert = $this -> apis -> saveNewRegisteredMotherData($data);
				if($insert)
					$response['success'] = "yes";
			}
		}else
		{
			$response['success'] = "no";
			$response['message'] = 'Authentication Failed!';
		}
		// Output response
		return $this->output->set_output(json_encode($response));
	}
	
	public function downSyncMotherDataFromServer(){
		$userName = $this -> input -> get('username');
		$imeiNo = $this -> input -> get('imei_no');
		if(authenticationbyimei($userName, $imeiNo)){
			$response = json_encode(array("success"=>"yes", "data"=>cervmotherlist($userName)));
		}else{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));		
		}
		// Output response
		return $this->output->set_output($response);
	}
	
	public function check_in()
	{
		$insertData['techniciancode'] = $technicianCode = $this -> input -> post('techniciancode');
		$insertData['imei'] = $imeiNo = $this -> input -> post('imei');
		$insertData['checkin_time'] = date('Y-m-d H:i:s');
		$insertData['work_date'] = date('Y-m-d');
		$insertData['checkin_lat'] = $this -> input -> post('checkin_lat');
		$insertData['checkin_long'] = $this -> input -> post('checkin_long');
		if(authenticationbyimei($technicianCode, $imeiNo)){
			$result = $this -> apis -> saveTechnicianCheckinDetails($insertData);
			if($result)
				$response['success'] = 'yes';
			else{
				$response['success'] = 'no';
				$response['message'] = 'Record Saving Error!';
			}
		}else{
			$response['success'] = 'no';
			$response['message'] = 'Authentication Failed!';
		}
		return $this->output->set_output(json_encode($response));
	}
	
	public function check_out()
	{
		$technicianCode = $this -> input -> post('techniciancode');
		$imeiNo = $this -> input -> post('imei');
		$updateData['checkout_time'] = date('Y-m-d H:i:s');
		$workDate = date('Y-m-d');
		$updateData['checkout_lat'] = $this -> input -> post('checkout_lat');
		$updateData['checkout_long'] = $this -> input -> post('checkout_long');
		if(authenticationbyimei($technicianCode, $imeiNo)){
			$result = $this -> apis -> updateTechnicianCheckinDetails($updateData,$workDate,$technicianCode);
			if($result)
				$response['success'] = 'yes';
			else{
				$response['success'] = 'no';
				$response['message'] = 'Record Saving Error!';
			}
		}else{
			$response['success'] = 'no';
			$response['message'] = 'Authentication Failed!';
		}
		return $this->output->set_output(json_encode($response));
	}
	
	public function motherSearchAgainstCNIC()
	{
		$motherCnic = $this -> input -> get('mother_cnic');
		$technicianCode = $this -> input -> get('techniciancode');
		$imeiNo = $this -> input -> get('imei');
		if(authenticationbyimei($technicianCode, $imeiNo)){
			$result = searchMotherAgainstCnic($motherCnic);
			if( ! empty($result)){
				$response = $result;
				$response['success'] = 'yes';
			}
			else{
				$response['success'] = "no";
				$response['message'] = 'No Data Found!';
			}
		}else{
			$response['success'] = 'no';
			$response['message'] = 'Authentication Failed!';
		}
		return $this->output->set_output(json_encode($response));
	}
	
	public function checkinCheckoutSync()
	{
		$imeiNo = $this -> input -> post('imei');
		$technicianCode = $this -> input -> post('techniciancode');
		$workDate = $this -> input -> post('work_date');
		if(authenticationbyimei($technicianCode, $imeiNo)){
			if($this -> input -> post('checkin_time') != NULL){
				$data['imei'] = $imeiNo;
				$data['techniciancode'] = $technicianCode;
				$data['work_date'] = $workDate;
				$data['checkin_time'] = $this -> input -> post('checkin_time');
				$data['checkin_lat'] = $this -> input -> post('checkin_lat');
				$data['checkin_long'] = $this -> input -> post('checkin_long');
				$data['checkout_time'] = $this -> input -> post('checkout_time');
				$data['checkout_lat'] = $this -> input -> post('checkout_lat');
				$data['checkout_long'] = $this -> input -> post('checkout_long');
				$result = $this -> apis -> saveTechnicianCheckinDetails($data);
				if($result)
					$response['success'] = 'yes';
				else{
					$response['success'] = 'no';
					$response['message'] = 'Record Saving Error!';
				}
			}else{
				$data['checkout_time'] = $this -> input -> post('checkout_time');
				$data['checkout_lat'] = $this -> input -> post('checkout_lat');
				$data['checkout_long'] = $this -> input -> post('checkout_long');
				$result = $this -> apis -> updateTechnicianCheckinDetails($data,$workDate,$technicianCode);
				if($result)
					$response['success'] = 'yes';
				else{
					$response['success'] = 'no';
					$response['message'] = 'Record Saving Error!';
				}
			}
		}else{
			$response['success'] = 'no';
			$response['message'] = 'Authentication Failed!';
		}
		return $this->output->set_output(json_encode($response));		
	}
	
	public function child_search(){
		$technicianCode = $this -> input -> get('techniciancode');
		$imeiNo = $this -> input -> get('imei');
		
		if(authenticationbyimei($technicianCode, $imeiNo)){
			$fatherCnic = $this -> input -> get('fathercnic');
			$nameOfChild = $this -> input -> get('nameofchild');
			$fatherName = $this -> input -> get('fathername');
			$cardNo = $this -> input -> get('cardno');
			$wc = array();
			$like = array();
			if($fatherCnic && $fatherCnic != '')
				$wc['fathercnic'] = $fatherCnic;
			if($fatherName && $fatherName != ''){
				$like['key'] = 'fathername';
				$like['value'] = $fatherName;
			}
			if($nameOfChild && $nameOfChild != ''){
				$like['key'] = 'nameofchild';
				$like['value'] = $nameOfChild;
			}
			if($cardNo && $cardNo > 0)
				$wc['cardno'] = $cardNo;
			if( ! empty($wc) || ! empty($like)){
				$result['data'] = $this -> apis -> searchChildrenData($wc,$like);
				if( ! empty($result['data'])){
					$response = $result;
					$response['success'] = 'yes';
				}
				else{
					$response['success'] = "no";
					$response['message'] = 'No Data Found!';
				}
			}else{
				$response['success'] = "no";
				$response['message'] = 'No Search Parameter!';
			}
		}else{
			$response['success'] = 'no';
			$response['message'] = 'Authentication Failed!';
		}
		return $this->output->set_output(json_encode($response));
	}
	
	public function mother_search(){
		$technicianCode = $this -> input -> get('techniciancode');
		$imeiNo = $this -> input -> get('imei');
		if(authenticationbyimei($technicianCode, $imeiNo)){
			$motherCnic = $this -> input -> get('mother_cnic');
			$nameOfMother = $this -> input -> get('mother_name');
			$husbandName = $this -> input -> get('husband_name');
			$cardNo = $this -> input -> get('cardno');
			$wc = array();
			$like = array();
			if($motherCnic && $motherCnic != '')
				$wc['mother_cnic'] = $motherCnic;
			if($husbandName && $husbandName != ''){
				$like['key'] = 'husband_name';
				$like['value'] = $husbandName;
			}
			if($nameOfMother && $nameOfMother != ''){
				$like['key'] = 'mother_name';
				$like['value'] = $nameOfMother;
			}
			if($cardNo && $cardNo > 0)
				$wc['cardno'] = $cardNo;
			if( ! empty($wc) || ! empty($like)){
				$result['data'] = $this -> apis -> searchMotherData($wc,$like);
				if( ! empty($result['data'])){
					$response = $result;
					$response['success'] = 'yes';
				}
				else{
					$response['success'] = "no";
					$response['message'] = 'No Data Found!';
				}
			}else{
				$response['success'] = "no";
				$response['message'] = 'No Search Parameter!';
			}
		}else{
			$response['success'] = 'no';
			$response['message'] = 'Authentication Failed!';
		}
		return $this->output->set_output(json_encode($response));
	}
}
?>