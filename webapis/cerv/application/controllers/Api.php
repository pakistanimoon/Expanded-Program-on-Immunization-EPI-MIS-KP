<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Apis_model','apis');
		$this -> load -> helper('apis_helper');
		$this -> load -> library('notifications');
		$this->output->set_content_type('application/json');
	}
	public function downloadJson(){
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$this->load->helper('download');
		$filePath = FCPATH.'downloadChildrenDataFromServer.json';
		$data = file_get_contents($filePath);
		force_download('child_data.json', $data);
	}
	public function downloadJsonWomen(){
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$this->load->helper('download');
		$filePath = FCPATH.'downloadWomenDataFromServer.json';
		$data = file_get_contents($filePath);
		force_download('women_data.json', $data);
	}
	public function login(){
		$data = json_encode($this -> input -> post());
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');
		$token = $this -> input -> post('token');
		$imeino = $this -> input -> post('imei_no');
		$action = $this -> input -> post('action');
		$model_no = $this -> input -> post('model_no');
		//print_r($_POST); exit;
		if(authentication($username, $password)){
			updateimei($username, $imeino, $token);
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
	public function login_support(){
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('pwd');
		$token = $this -> input -> post('token');
		$imeino = $this -> input -> post('imei_no');
		//print_r($_POST); exit;
		if(authentication_support($username, $password)){
			updateimei_support($username, $imeino, $token);
			$response = json_encode(array("success"=>"yes"));
		}else{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));
		}
		return $this->output->set_output($response);
	}
	public function update_child_cardno()
	{
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		if( ! $this -> input -> post('reg_no') || ! $this -> input -> post('new_card_no') || ! $this -> input -> post('year') || ! $this -> input -> post('facode'))
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Please Provide all valid Parameters!")));
		$oldRegistrationNumber = $this -> input -> post('reg_no');
		$cardNumber = $this -> input -> post('new_card_no');
		$year = $this -> input -> post('year');
		$facode = $this -> input -> post('facode');
		$newRegistrationNumb = $facode.'-'.$year.'-'.$cardNumber;
		/* Check for existing card no */
		$alreadyExists = $this -> apis -> checkChildRegistered($newRegistrationNumb);
		if($alreadyExists){
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"New Provided Card Number Already Exists!")));
		}
		$columns = $this -> apis -> getTableColumns();
		$query = "Insert INTO cerv_child_registration
					($columns, recno, child_registration_no, cardno, reg_facode, year)
					SELECT $columns, nextval('child_registration_seq'::regclass), '$newRegistrationNumb', '$cardNumber', '$facode', '$year' from cerv_child_registration where child_registration_no='$oldRegistrationNumber'";
		$this -> apis -> replaceCardNo($query, $oldRegistrationNumber);
		$this -> apis -> updateSequence($oldRegistrationNumber);
		return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Card No Updated Successfully!", "new_card_no" => $newRegistrationNumb)));
	}
	public function register_child()
	{
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$distcode = $this -> input -> post('distcode');
		$reg_facode = $this -> input -> post('reg_facode');
		$year = $this -> input -> post('year');
		$techniciancode = $this -> input -> post('techniciancode');
		if($distcode != NULL && $reg_facode != NULL && $year != NULL && $techniciancode != NULL){}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Please Provide all Valid Parameters. District Code, Registering Facility, Year and Technician Code")));
		}
		date_default_timezone_set("Asia/Karachi");
		$userName = $this -> input -> post('username');
		// Configuration Keys
		$insertData['reg_facode'] = $registeringFacilityCode = $this -> input -> post('reg_facode');
		$insertData['year'] = $year = $this -> input -> post('year');
		$insertData['techniciancode'] = $techniciancode = $this -> input -> post('techniciancode');
		$insertData['child_registration_no'] = $childRegistrationNo = $registration_number = $this -> input -> post('child_registration_no');
		$insertData['cardno'] = $cardNo = $this -> input -> post('cardno');
		if($cardNo < 1 || $cardNo == '')
		{
			$tempRegistrationCode = $this -> input -> post('temp_no');
			$maxCardNo = getMaxCardNoforChild($registeringFacilityCode, $year);
			$newCardNo = sprintf("%05d", ($maxCardNo + 1));
			$insertData['child_registration_no'] = $newRegistrationNumb = $registeringFacilityCode.'-'.$year.'-'.$newCardNo;
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
		$insertData['dateofbirth'] = $dataofbirth = $this -> input -> post('dateofbirth');
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
		//Address Keys
		$insertData['address'] = $this -> input -> post('address');
		$insertData['address_lat'] = $this -> input -> post('address_lat');
		$insertData['address_lng'] = $this -> input -> post('address_lng');
		$insertData['next_visit_date'] = $this -> input -> post('next_visit_date');
		$insertData['shift_in_date'] = $this -> input -> post('shift_in_date');
		$insertData['shift_out_date'] = $this -> input -> post('shift_out_date');
		$insertData['dateofdeath'] = $this -> input -> post('dateofdeath');
		$insertData['dateofrefusal'] = $this -> input -> post('dateofrefusal');
		// Outer Registered Keys
		$insertData['isoutsitefacility'] = $isOuterRegistered = $this -> input -> post('isoutsitefacility');
		// Other Submittion Keys
		$insertData['issynced'] = $this -> input -> post('issynced');
		// Upload Child Image
		if($_FILES AND isset($_FILES['pic']['name']) AND ! empty($_FILES['pic']['name'])){
			$fileName = basename($_FILES['pic']['name']);
			$fileArray = explode('.', $fileName);
			$fileExt = $fileArray[1];
			$newFileName = $insertData['child_registration_no'].'.'.$fileExt;
			$date = date('Y-m-d H:i:s');
			$temp = $_FILES['pic']['tmp_name'];
			$dir_separator = DIRECTORY_SEPARATOR;
			$folder = "/assets/childs";
			$destination_path = getcwd().$folder.$dir_separator;
			$target_path = $destination_path.$fileName;
			if (move_uploaded_file($temp,$target_path)){
				rename($target_path, $destination_path.$newFileName);
				$response['image_success'] = "Child Image uploaded Successfully!";
				$response['image_path'] = $destination_path.$newFileName;
			}else{
				$response['image_success'] = "Child Image was not uploaded!".$_FILES['pic']['error'];
			}
		}else{
			$response['image_success'] = "No Child image found!";
		}
		// Upload CNIC Image
		if($_FILES AND isset($_FILES['cnicpic']['name']) AND ! empty($_FILES['cnicpic']['name'])){
			$fileName = basename($_FILES['cnicpic']['name']);
			$fileArray = explode('.', $fileName);
			$fileExt = $fileArray[1];
			$newFileName = $insertData['child_registration_no'].'.'.$fileExt;
			$date = date('Y-m-d H:i:s');
			$temp = $_FILES['cnicpic']['tmp_name'];
			$dir_separator = DIRECTORY_SEPARATOR;
			$folder = "/assets/cnic";
			$destination_path = getcwd().$folder.$dir_separator;
			$target_path = $destination_path.$fileName;
			if (move_uploaded_file($temp,$target_path)){
				rename($target_path, $destination_path.$newFileName);
				$response['cnic_image_success'] = "CNIC Image uploaded Successfully!";
				$response['cnic_image_path'] = $destination_path.$newFileName;
			}else{
				$response['cnic_image_success'] = "CNIC Image was not uploaded!".$_FILES['cnicpic']['error'];
			}
		}else{
			$response['cnic_image_success'] = "No CNIC image found!";
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
		if(authenticationbyusername($userName))
		{
			if($isOuterRegistered > 0){
				// Check if child already registered with some other technician
				$childAlreadyRegistered = $this -> apis -> checkChildRegisteredOutside($registeringFacilityCode,$cardNo,$dataofbirth);
				if($childAlreadyRegistered != false){
					$childRegistrationNo = $childAlreadyRegistered;
					$childAlreadyRegistered = true;
				}
			}
			else{
				// Check if child already registered
				$childAlreadyRegistered = $this -> apis -> checkChildRegistered($childRegistrationNo);
			}
			// Update if child already registered
			if($childAlreadyRegistered)
			{
				$update = $this -> apis -> updateChildRegistrationData($data,$childRegistrationNo);
				$this -> apis -> updateSequence($childRegistrationNo);
				if($update)
					$response['success'] = "yes";
			}else
			{
				if($this -> input -> post('is_shiftin') && $this -> input -> post('is_shiftin') == 1)
				{
					//$update = $this -> apis -> updateChildRegistrationData($data,$this -> input -> post('child_registration_no_before_shiftin'));
					//$this -> apis -> updateSequence($newRegistrationNumb);
					$oldRegistrationNumber = $this -> input -> post('child_registration_no_before_shiftin');
					//$cardNumber = $newCardNo
					//$year = $year;
					//$facode = $registeringFacilityCode;
					$newRegistrationNumb = $registeringFacilityCode.'-'.$year.'-'.$newCardNo;
					/* Check for existing card no */
					$alreadyExists = $this -> apis -> checkChildRegistered($newRegistrationNumb);
					if($alreadyExists){
						return $this->output->set_output(json_encode(array("success"=>"no","message"=>"New Provided Card Number Already Exists!")));
					}
					$columns = $this -> apis -> getTableColumns();
					$query = "Insert INTO cerv_child_registration
								($columns, recno, child_registration_no, cardno, reg_facode, year)
								SELECT $columns, nextval('child_registration_seq'::regclass), '$newRegistrationNumb', '$newCardNo', '$registeringFacilityCode', '$year' from cerv_child_registration where child_registration_no='$oldRegistrationNumber'";
					$this -> apis -> replaceCardNo($query, $oldRegistrationNumber);
					$this -> db -> update('cerv_child_registration', array('deleted_at' => NULL), array('child_registration_no' => $newRegistrationNumb));
					$this -> apis -> updateSequence($oldRegistrationNumber);
					return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Shifted In Successfully!", "child_registration_no" => $newRegistrationNumb)));
					/* if($update)
						$response['success'] = "yes"; */
				}else{
					// Insert new registring child
					$insert = $this -> apis -> saveNewRegisteredChildData($data);
					if($insert){
						$response['success'] = "yes";
						$data_support['cerv_registration_no	'] = $registration_number = (isset($childRegistrationNo)) ? $childRegistrationNo : $newRegistrationNumb;
						$data_support['imei_no'] = $imeiNo = $this -> input -> post('imei');
						$data_support['pwd'] = '12345';
						//$insert_support = $this -> apis -> saveNewRegisteredChildDatasuppport($data_support);
						if(isset($insert_support) && $insert_support)
							$response['success_support'] = "yes";
					}
				}
			}
		}else
		{
			$response['success'] = "no";
			$response['success_support'] = "no";
			$response['message'] = "Authentication Failed!";
		}
		/* send push notification */
		$title = "Testing Push Notifications";
		$message = 'Hello there you have a new notification!';
		$imageUrl = '';
		$action = isset($_POST['action'])?$_POST['action']:'';
		$send_to = 'single';
		$actionDestination = isset($_POST['action_destination'])?$_POST['action_destination']:'';
		if($actionDestination ==''){
			$action = '';
		}
		$this -> notifications -> setTitle($title);
		$this -> notifications -> setMessage($message);
		$this -> notifications -> setImage($imageUrl);
		$this -> notifications -> setAction($action);
		$this -> notifications -> setActionDestination($actionDestination);
		$firebase_token = '';//getUserFirebaseToken($registration_number);
		//echo $firebase_token;exit;
		$firebase_api = 'AIzaSyBgCGDTTvowUy1VRZOY9NnLaEKHCUpQmMk';
		//echo $firebase_api;exit;
		$topic = '';//$_POST['topic'];
		$requestData = $this -> notifications -> getNotificatin();
		//print_r($requestData);exit;
		if($send_to=='topic'){
			$fields = array(
				'to' => '/topics/' . $topic,
				'data' => $requestData,
			);
		}else{
			$fields = array(
				'to' => $firebase_token,
				'notification' => $requestData,
				'data' => $requestData,
			);
		}
		// Set POST variables
		$url = 'https://fcm.googleapis.com/fcm/send';
		$headers = array(
			'Authorization: key=' . $firebase_api,
			'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Disabling SSL Certificate support temporarily
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		// Execute post
		$result = curl_exec($ch);
		if($result === FALSE){
			die('Curl failed: ' . curl_error($ch));
		}
		//print_r($result);exit;
		// Close connection
		curl_close($ch);
		// Output response
		return $this->output->set_output(json_encode($response));
	}
	/* For New API Call -> Facility wise card no generation  */
	public function register_child_new()
	{
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
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
			$maxCardNo = getMaxCardNoforChildNew($registeringFacilityCode);
			$newCardNo = sprintf("%05d", ($maxCardNo + 1));
			$insertData['child_registration_no'] = $newRegistrationNumb = $registeringFacilityCode.'-'.$year.'-'.$newCardNo;
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
		//Address Keys
		$insertData['address'] = $this -> input -> post('address');
		$insertData['address_lat'] = $this -> input -> post('address_lat');
		$insertData['address_lng'] = $this -> input -> post('address_lng');
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
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$techniciancode = $this -> input -> get('techniciancode');
		$maxCardNo = getMaxCardNoforChildNew($techniciancode);
		$maxCardNo = ($maxCardNo + 1);
		$newCardNo = sprintf("%05d", $maxCardNo);
		$response['success'] = "yes";
		$response['cardno'] = $newCardNo;
		return $this->output->set_output(json_encode($response));
	}
	public function get_mother_card_no()
	{
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$techniciancode = $this -> input -> get('techniciancode');
		$maxCardNo = getMaxCardNoforMother($techniciancode);
		$newCardNo = sprintf("%05d", ($maxCardNo + 1));
		$response['success'] = "yes";
		$response['cardno'] = $newCardNo;
		return $this->output->set_output(json_encode($response));
	}
	public function downSyncChildrenDataFromServer()
	{
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$userName = $this -> input -> get('username');
		$lastRecordedId = $this -> input -> get('recno');
		if(authenticationbyusername($userName)){
			$response = json_encode(array("success"=>"yes", "data"=>cervchildlist($userName, $lastRecordedId)));
		}else{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));
		}
		// Output response
		return $this->output->set_output($response);
	}
	public function downloadChildrenDataFromServer()
	{
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$userName = $this -> input -> get('username');
		$recno = $this -> input -> get('recno');
		$dataToSend = array();
		if(authenticationbyusername($userName)){
			while($recno != NULL){
				$data = cervchildlist_download($userName, $recno);
				$lastKey = key( array_slice( $data, -1, 1, TRUE ) );
				if(isset($data[$lastKey]['recno'])){
					$recno = $data[$lastKey]['recno'];
					$recno = check_recno($recno);
					$dataToSend[] = $data;
				}
			}
			$response = json_encode(array("success"=>"yes", "data"=>$dataToSend));
		}else{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));
		}
		// Output response
		//print_r($dataToSend);exit;
		return $this->output->set_output($response);
	}
	public function register_mother()
	{
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$distcode = $this -> input -> post('distcode');
		$reg_facode = $this -> input -> post('reg_facode');
		$year = $this -> input -> post('year');
		$techniciancode = $this -> input -> post('techniciancode');
		if($distcode != NULL && $reg_facode != NULL && $year != NULL && $techniciancode != NULL){}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Please Provide all Valid Parameters. District Code, Registering Facility, Year and Technician Code")));
		}
		date_default_timezone_set("Asia/Karachi");
		$userName = $techniciancode = $this -> input -> post('techniciancode');
		// Configuration Keys
		$insertData['reg_facode'] = $registeringFacilityCode = $this -> input -> post('reg_facode');
		$insertData['imei'] = $imeiNo = $this -> input -> post('imei');
		$insertData['year'] = $year = $this -> input -> post('year');
		$insertData['mother_registration_no'] = $motherRegistrationNo = $this -> input -> post('mother_registration_no');
		$insertData['cardno'] = $cardNo = $this -> input -> post('cardno');
		$insertData['techniciancode'] = $this -> input -> post('techniciancode');
		if($cardNo < 1 || $cardNo == '')
		{
			$tempRegistrationCode = $this -> input -> post('temp_no');
			$maxCardNo = getMaxCardNoforMother($registeringFacilityCode, $year);
			$newCardNo = sprintf("%05d", ($maxCardNo + 1));
			$insertData['mother_registration_no'] = $newRegistrationNumb = $registeringFacilityCode.'-'.$year.'-'.$newCardNo;
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
		// Vaccine Administered by EPI Technicians
		$insertData['tt1_techniciancode'] = $this -> input -> post('tt1_techniciancode');
		$insertData['tt2_techniciancode'] = $this -> input -> post('tt2_techniciancode');
		$insertData['tt3_techniciancode'] = $this -> input -> post('tt3_techniciancode');
		$insertData['tt4_techniciancode'] = $this -> input -> post('tt4_techniciancode');
		$insertData['tt5_techniciancode'] = $this -> input -> post('tt5_techniciancode');
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
		//Address Keys
		$insertData['address'] = $this -> input -> post('address');
		$insertData['address_lat'] = $this -> input -> post('address_lat');
		$insertData['address_lng'] = $this -> input -> post('address_lng');
		$insertData['shift_in_date'] = $this -> input -> post('shift_in_date');
		$insertData['shift_out_date'] = $this -> input -> post('shift_out_date');
		$insertData['dateofdeath'] = $this -> input -> post('dateofdeath');
		$insertData['dateofrefusal'] = $this -> input -> post('dateofrefusal');
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
		if(authenticationbyusername($userName))
		{
			// Check if mother already registered
			$motherAlreadyRegistered = $this -> apis -> checkMotherRegistered($motherRegistrationNo);
			// Update if mother already registered
			if($motherAlreadyRegistered)
			{
				$update = $this -> apis -> updateMotherRegistrationData($data,$motherRegistrationNo);
				$this -> apis -> updateWomenSequence($motherRegistrationNo);
				if($update)
					$response['success'] = "yes";
			}else
			{
				if($this -> input -> post('is_shiftin') && $this -> input -> post('is_shiftin') == 1)
				{
					$update = $this -> apis -> updateMotherRegistrationData($data,$this -> input -> post('women_registration_no_before_shiftin'));
					$this -> apis -> updateWomenSequence($newRegistrationNumb);
					if($update)
						$response['success'] = "yes";
				}else{
					// Insert new registring mother
					$insert = $this -> apis -> saveNewRegisteredMotherData($data);
					if($insert)
						$response['success'] = "yes";
				}
			}
		}else
		{
			$response['success'] = "no";
			$response['message'] = 'Authentication Failed!';
		}
		// Output response
		return $this->output->set_output(json_encode($response));
	}
	/* For New API Call -> Facility wise card no generation  */
	public function register_mother_new()
	{
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
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
			$maxCardNo = getMaxCardNoforMotherNew($registeringFacilityCode);
			$newCardNo = sprintf("%05d", ($maxCardNo + 1));
			$insertData['mother_registration_no'] = $newRegistrationNumb = $registeringFacilityCode.'-'.$year.'-'.$newCardNo;
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
		//Address Keys
		$insertData['address'] = $this -> input -> post('address');
		$insertData['address_lat'] = $this -> input -> post('address_lat');
		$insertData['address_lng'] = $this -> input -> post('address_lng');
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
		if(authenticationbyusername($userName))
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
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$userName = $this -> input -> get('username');
		$lastRecordedId = $this -> input -> get('recno');
		if(authenticationbyusername($userName)){
			$response = json_encode(array("success"=>"yes", "data"=>cervmotherlist($userName, $lastRecordedId)));
		}else{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));
		}
		// Output response
		return $this->output->set_output($response);
	}
	public function downloadWomenDataFromServer()
	{
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$userName = $this -> input -> get('username');
		$recno = $this -> input -> get('recno');
		$dataToSend = array();
		if(authenticationbyusername($userName)){
			while($recno != NULL){
				$data = cervmotherlist_download($userName, $recno);
				$lastKey = key( array_slice( $data, -1, 1, TRUE ) );
				if(isset($data[$lastKey]['recno'])){
					$recno = $data[$lastKey]['recno'];
					$recno = checkwomen_recno($recno);
					$dataToSend[] = $data;
				}
			}
			$response = json_encode(array("success"=>"yes", "data"=>$dataToSend));
		}else{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));
		}
		// Output response
		//print_r($dataToSend);exit;
		return $this->output->set_output($response);
	}
	public function check_in()
	{
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$insertData['techniciancode'] = $technicianCode = $this -> input -> post('techniciancode');
		$insertData['imei'] = $imeiNo = $this -> input -> post('imei');
		$insertData['checkin_time'] = date('Y-m-d H:i:s');
		$insertData['work_date'] = date('Y-m-d');
		$insertData['checkin_lat'] = $this -> input -> post('checkin_lat');
		$insertData['checkin_long'] = $this -> input -> post('checkin_long');
		if(authenticationbyusername($technicianCode)){
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
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$technicianCode = $this -> input -> post('techniciancode');
		$imeiNo = $this -> input -> post('imei');
		$updateData['checkout_time'] = date('Y-m-d H:i:s');
		$workDate = date('Y-m-d');
		$updateData['checkout_lat'] = $this -> input -> post('checkout_lat');
		$updateData['checkout_long'] = $this -> input -> post('checkout_long');
		if(authenticationbyusername($technicianCode)){
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
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$motherCnic = $this -> input -> get('mother_cnic');
		$technicianCode = $this -> input -> get('techniciancode');
		$imeiNo = $this -> input -> get('imei');
		if(authenticationbyusername($technicianCode)){
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
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$imeiNo = $this -> input -> post('imei');
		$technicianCode = $this -> input -> post('techniciancode');
		$workDate = $this -> input -> post('work_date');
		if(authenticationbyusername($technicianCode)){
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
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$technicianCode = $this -> input -> get('techniciancode');
		$imeiNo = $this -> input -> get('imei');
		if(authenticationbyusername($technicianCode)){
			$fatherCnic = $this -> input -> get('fathercnic');
			$nameOfChild = $this -> input -> get('nameofchild');
			$fatherName = $this -> input -> get('fathername');
			$cardNo = $this -> input -> get('cardno');
			$registration_no = $this -> input -> get('child_registration_no');
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
			if($registration_no && $registration_no > 0)
			{
				$wc['child_registration_no'] = $registration_no;
			}
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
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$technicianCode = $this -> input -> get('techniciancode');
		$imeiNo = $this -> input -> get('imei');
		if(authenticationbyusername($technicianCode)){
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
	public function downSyncVaccinesRecord(){
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$technicianCode = $this -> input -> get('techniciancode');
		$imeiNo = $this -> input -> get('imei');
		if(authenticationbyusername($technicianCode)){
			$result = $this -> apis -> getVaccinesDetail();
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
	public function vaccinesDailyRegister(){
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$boolvalidated = FALSE;
		foreach($_POST['data'] as $key=> $singlerec){
			$this->form_validation->set_data($singlerec);
			$this->form_validation->set_rules('techniciancode','Technician Code','required|min_length[9]|max_length[9]');
			$this->form_validation->set_rules('facode[]','Facode','required|min_length[6]|max_length[6]');
			$this->form_validation->set_rules('batch_number[]','Batch Number','required');
			$this->form_validation->set_rules('item_id[]','Item Id','required|greater_than[0]|max_length[3]');
			$this->form_validation->set_rules('used_vials[]','Used Vials','required|numeric|trim');
			$this->form_validation->set_rules('unused_vials[]','Unused Vials','required|numeric|trim');
			$this->form_validation->set_rules('used_doses[]','Used Doses','required|numeric|trim');
			$this->form_validation->set_rules('unused_doses[]','Unused Doses','required|numeric|trim');
			$this->form_validation->set_rules('date','Date[]','trim|required|callback_valid_date[Y-m-d]');
			if ($this->form_validation->run() === FALSE)
			{
				$boolvalidated = FALSE;
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>validation_errors())));
			}
			else{
				$boolvalidated = TRUE;
				$date =$_POST['data'][$key]['date'];
				$facode =$_POST['data'][$key]['facode'];
				$fmonth = substr($date,0,7);
				$_POST['data'][$key]['fmonth']=$fmonth;
				$_POST['data'][$key]['created_date']= date('Y-m-d h:i:s');
			}
			$this->form_validation->reset_validation();
		}
		if ($boolvalidated){
			//print_r($_POST['data']); exit();
			$techniciancode = $this -> input -> post('techniciancode');
			$imeiNo = $this -> input -> post('imeiNo');
			$insertData = array();
			if(authenticationbyusername($userName))
			{
				/* foreach ($dailyData as $key => $value)
				{
					$dailyData[$key] = (($value=='')?NULL:$value);
					if($dailyData[$key] == NULL || $dailyData[$key] == 'null')
						unset($dailyData[$key]);
				}  */
				$insert = $this->db->insert_batch('vaccine_vials_daily_record', $_POST['data']);
				//print_r($insert);exit();
				$checkdata = $this -> apis -> checkmonthlyconsumption($fmonth,$facode);
				$getdata = $this -> apis -> getvaccinesDailyRegister($fmonth,$facode);
				$prevfmonth = date("Y-m",strtotime($fmonth.'-01'.' first day of previous month'));
				$fmonthparts = explode("-",$prevfmonth);
				$prevyear = $fmonthparts[0];
				$issueditems = $this-> apis -> get_issued_items("1","6",$facode,$fmonth);
				$existingitems = $this-> apis -> get_existing_items($facode,$prevfmonth);
				//$getconsumption_detaildata = $this -> apis -> get_consumption_detaildata($prevfmonth,$facode);
				//print_r($getconsumption_detaildata);exit();
				if(isset($fmonth) && isset($facode)){
					if($checkdata==1){
						$this->db->trans_start();
						$result=$this->api->consumptionmaster_detail_delete($fmonth,$facode);
						$this->db->trans_complete();
					}
					$recid=0;
					foreach($getdata as $key => $val){
						if($key===0){
							$distcode = $data['distcode'] = $val['distcode'];
							$data['fmonth'] = $val['fmonth'];
							$data['procode'] = $val['procode'];
							$data['tcode'] = $val['tcode'];
							$data['uncode'] = $val['uncode'];
							$data['facode'] = $val['facode'];
							$data['created_by'] = 'kpk'.$distcode.'_deo';
							$data['created_date'] = $data['updated_date'] = date('Y-m-d');
							$data['is_compiled'] = '0';
							//print_r($data); exit();
							$recid=$this->api->consumption_master_save($data);
						}
						if($recid>0){
							$delta['main_id'] = $recid;
							$delta['item_id'] = $val['item_id'];
							$delta['batch_doses'] = $val['batch'];
							$delta['used_doses'] = $val['used_doses'];
							$delta['used_vials'] = $val['used_vials'];
							$delta['unused_doses'] = $val['unused_doses'];
							$delta['unused_vials'] = $val['unused_vials'];
							//print_r($delta); exit();
							$result=$this->api->consumption_details_save($delta);
						}
					}
				}
				if($insert)
				{
					$response['success'] = "yes";
				}
			}
			else
			{
				$response['success'] = 'no';
				$response['message'] = 'Authentication Failed!';
			}
			return $this->output->set_output(json_encode($response));
	    }
	}
	public function valid_date($date,$format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}
	public function downSyncImageFromServer(){
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$technicianCode = $this -> input -> post('username');
		$imeiNo = $this -> input -> post('imei');
		if(authenticationbyusername($technicianCode)){
			if($this -> input -> post('reg_id'))
			{
				$name = $this -> input -> post('reg_id');
				$file = base_url(glob("assets/childs/$name.jpg"));
				$response = json_encode(array("success"=>"yes", "link"=>$file));
			}
			else
			{
				$response = json_encode(array("success"=>"no","message"=>"No Data Found!"));
			}
		}
		else
		{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));
		}
		return $this->output->set_output($response);
	}
	public function saveAefiRecord(){
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));exit;
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));exit;
		}
		$insertData['child_registration_no'] = $this -> input -> post('child_registration_no');
		$insertData['procode'] = $this -> input -> post('procode');
		$insertData['distcode'] = $this -> input -> post('distcode');
		$insertData['tcode'] = $this -> input -> post('tcode');
		$insertData['uncode'] = $this -> input -> post('uncode');
		$insertData['village'] = $this -> input -> post('village');
		$insertData['vcode'] = $this -> input -> post('vcode');
		$insertData['casename'] = $this -> input -> post('casename');
		$insertData['gender'] = $this -> input -> post('gender');
		$insertData['dob'] = $this -> input -> post('dob');
		$insertData['fathername'] = $this -> input -> post('fathername');
		$insertData['cellnumber'] = $this -> input -> post('cellnumber');
		$insertData['mc_bcg'] = $this -> input -> post('mc_bcg');
		$insertData['mc_convulsion'] = $this -> input -> post('mc_convulsion');
		$insertData['mc_severe'] = $this -> input -> post('mc_severe');
		$insertData['mc_unconscious'] = $this -> input -> post('mc_unconscious');
		$insertData['mc_abscess'] = $this -> input -> post('mc_abscess');
		$insertData['mc_respiratory'] = $this -> input -> post('mc_respiratory');
		$insertData['mc_fever'] = $this -> input -> post('mc_fever');
		$insertData['mc_swelling'] = $this -> input -> post('mc_swelling');
		$insertData['mc_rash'] = $this -> input -> post('mc_rash');
		$insertData['mc_other'] = $this -> input -> post('mc_other');
		$insertData['mc_treatment'] = $this -> input -> post('mc_treatment');
		$insertData['mc_hospitalized'] = $this -> input -> post('mc_hospitalized');
		$insertData['mc_hosp_address'] = $this -> input -> post('mc_hosp_address');
		$insertData['vacc_date'] = $this -> input -> post('vacc_date');
		$insertData['vacc_name'] = $this -> input -> post('vacc_name');
		$insertData['vacc_manufacturer'] = $this -> input -> post('vacc_manufacturer');
		$insertData['vacc_batch'] = $this -> input -> post('vacc_batch');
		$insertData['vacc_exp'] = $this -> input -> post('vacc_exp');
		$insertData['vacc_center'] = $this -> input -> post('vacc_center');
		$insertData['vacc_vaccinator'] = $this -> input -> post('vacc_vaccinator');
		$insertData['rep_person'] = $this -> input -> post('rep_person');
		$insertData['rep_desg'] = $this -> input -> post('rep_desg');
		$insertData['submitted_date'] = $submitted_date = $this -> input -> post('submitted_date');
		$weekDetails = getWeekDetails($submitted_date);
		$insertData['datefrom'] = $weekDetails -> date_from;
		$insertData['dateto'] = $weekDetails -> date_to;
		$insertData['week'] = $weekDetails -> epi_week_numb;
		$insertData['year'] = $this -> input -> post('year');
		$insertData['facode'] = $this -> input -> post('facode');
		$insertData['submitted_date'] = $this -> input -> post('submitted_date');
		$insertData['is_mobile_entry'] = 1;
		$insert = $this -> apis -> saveChildAEFIData($insertData);
		if($insert){
			return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Data Inserted Successfully!")));
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There was some error inserting the data.")));
		}
	}
	public function saveWomenAefiRecord(){
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));exit;
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));exit;
		}
		$insertData['women_registration_no'] = $this -> input -> post('women_registration_no');
		$insertData['procode'] = $this -> input -> post('procode');
		$insertData['distcode'] = $this -> input -> post('distcode');
		$insertData['tcode'] = $this -> input -> post('tcode');
		$insertData['uncode'] = $this -> input -> post('uncode');
		$insertData['village'] = $this -> input -> post('village');
		$insertData['vcode'] = $this -> input -> post('vcode');
		$insertData['casename'] = $this -> input -> post('casename');
		//$insertData['gender'] = $this -> input -> post('gender');
		$insertData['age'] = $this -> input -> post('age');
		$insertData['husbandname'] = $this -> input -> post('husbandname');
		$insertData['cellnumber'] = $this -> input -> post('cellnumber');
		//$insertData['mc_bcg'] = $this -> input -> post('mc_bcg');
		$insertData['mc_convulsion'] = $this -> input -> post('mc_convulsion');
		$insertData['mc_severe'] = $this -> input -> post('mc_severe');
		$insertData['mc_unconscious'] = $this -> input -> post('mc_unconscious');
		$insertData['mc_abscess'] = $this -> input -> post('mc_abscess');
		$insertData['mc_respiratory'] = $this -> input -> post('mc_respiratory');
		$insertData['mc_fever'] = $this -> input -> post('mc_fever');
		$insertData['mc_swelling'] = $this -> input -> post('mc_swelling');
		$insertData['mc_rash'] = $this -> input -> post('mc_rash');
		$insertData['mc_other'] = $this -> input -> post('mc_other');
		$insertData['mc_treatment'] = $this -> input -> post('mc_treatment');
		$insertData['mc_hospitalized'] = $this -> input -> post('mc_hospitalized');
		$insertData['mc_hosp_address'] = $this -> input -> post('mc_hosp_address');
		$insertData['vacc_date'] = $this -> input -> post('vacc_date');
		$insertData['vacc_name'] = $this -> input -> post('vacc_name');
		$insertData['vacc_manufacturer'] = $this -> input -> post('vacc_manufacturer');
		$insertData['vacc_batch'] = $this -> input -> post('vacc_batch');
		$insertData['vacc_exp'] = $this -> input -> post('vacc_exp');
		$insertData['vacc_center'] = $this -> input -> post('vacc_center');
		$insertData['vacc_vaccinator'] = $this -> input -> post('vacc_vaccinator');
		$insertData['rep_person'] = $this -> input -> post('rep_person');
		$insertData['rep_desg'] = $this -> input -> post('rep_desg');
		$insertData['submitted_date'] = $submitted_date = $this -> input -> post('submitted_date');
		$weekDetails = getWeekDetails($submitted_date);
		$insertData['datefrom'] = $weekDetails -> date_from;
		$insertData['dateto'] = $weekDetails -> date_to;
		$insertData['week'] = $weekDetails -> epi_week_numb;
		$insertData['year'] = $this -> input -> post('year');
		$insertData['facode'] = $this -> input -> post('facode');
		$insertData['submitted_date'] = $this -> input -> post('submitted_date');
		$insertData['is_mobile_entry'] = 1;
		$insert = $this -> apis -> saveWomenAEFIData($insertData);
		if($insert){
			return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Data Inserted Successfully!")));
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There was some error inserting the data.")));
		}
	}
	public function drawableRepositoryToSql()
	{
		$target_dir = "Android_darawable";
		if (is_dir($target_dir))
		{
			deleteDrawableRecords();
			$index = 0;
		  foreach(glob($target_dir.'/*.*') as $file)
			{
				echo basename("$file",".svg");
				echo "\n";
				$index++;
				drawableToDb(basename("$file",".svg"), (string)$index);
			}
		}
	}
	public function downSyncVillagesDataFromServer()
	{
		/* $token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		} */
		$response = json_encode(array("success"=>"yes", "data"=>villageslist()));
		return $this->output->set_output($response);
	}
	public function technicianCode_receive(){
		$technician = $this -> input -> GET('techniciancode');
		$result = $this -> apis -> techniciancode_get($technician);
		if(! empty($result)){
				$response = $result;
				$response['success'] = 'yes';
			}
		else{
				$response['success'] = "no";
				$response['message'] = 'No Data Found!';
			}
		$response = json_encode($response);
		return $this->output->set_output($response);
	}
	public function epi_weeks(){
		$token = $this -> input -> get('validate_token');
		$userName = $this -> input -> get('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
				}
			}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
			}
		$result = $this -> apis -> week_get();
		if(! empty($result)){
				$response = $result;
			}
		else{
				$response['success'] = "no";
				$response['message'] = 'No Data Found!';
			}
		$response = json_encode(array("success"=>"yes", "data"=>$response));
		return $this->output->set_output($response);
	}
	/* For New API Call -> Facility wise card no generation  */
	public function case_investigation()
	{
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$reg_facode = $this -> input -> post ('facode');
		$cardno = $this -> input -> post ('child_registration_num');
		$insertData['procode'] = $this -> input -> post('procode');
		$insertData['distcode'] = $distcode = $this -> input -> post('distcode');
		$insertData['tcode'] = $this -> input -> post('tcode');
		$insertData['uncode'] = $this -> input -> post('uncode');
		$insertData['facode'] = $this -> input -> post('facode');
		$insertData['faddress'] = $this -> input -> post('faddress');
		$insertData['year'] = $year = $this -> input -> post('year');
		$insertData['week'] = $this -> input -> post('week');
		$insertData['fweek'] = $this -> input -> post('fweek');
		$insertData['pvh_date'] = $this -> input -> post('pvh_date');
		$insertData['case_type'] = $case_type = 'Msl';
		$insertData['patient_name'] = $this -> input -> post('patient_name');
		$insertData['patient_gender'] = $this -> input -> post('patient_gender');
		$insertData['patient_fathername'] = $this -> input -> post('patient_fathername');
		$insertData['contact_numb'] = $this -> input -> post('contact_numb');
		$insertData['patient_dob'] = $this -> input -> post('patient_dob');
		$insertData['age_months'] = $this -> input -> post('age_months');
		$insertData['patient_address_procode'] =  $distcode_patient_address = $this -> input -> post('patient_address_procode');
		$insertData['patient_address_distcode'] = $this -> input -> post('patient_address_distcode');
		$insertData['patient_address_tcode'] = $this -> input -> post('patient_address_tcode');
		$insertData['patient_address_uncode'] = $this -> input -> post('patient_address_uncode');
		$insertData['clinical_representation'] = $this -> input -> post('clinical_representation');
		$insertData['complications'] = $this -> input -> post('complications');
		$insertData['date_rash_onset'] = $this -> input -> post('date_rash_onset');
		$insertData['notification_date'] = $this -> input -> post('notification_date');
		$insertData['date_investigation'] = $this -> input -> post('date_investigation');
		$insertData['doses_received'] = $this -> input -> post('doses_received');
		$insertData['last_dose_date'] = $this -> input -> post('last_dose_date');
		$insertData['travel_history'] = $this -> input -> post('travel_history');
		$insertData['th_procode'] = $this -> input -> post('th_procode');
		$insertData['th_distcode'] = $this -> input -> post('th_distcode');
		$insertData['th_tcode'] = $this -> input -> post('th_tcode');
		$insertData['th_uncode'] = $this -> input -> post('th_uncode');
		$insertData['th_muhallah'] = $this -> input -> post('th_muhallah');
		$insertData['th_province'] = $this -> input -> post('th_province');
		$insertData['th_district'] = $this -> input -> post('th_district');
		$insertData['th_tehsil'] = $this -> input -> post('th_tehsil');
		$insertData['th_uc'] = $this -> input -> post('th_uc');
		$insertData['th_muhallah'] = $this -> input -> post('th_muhallah');
		$insertData['type_specimen'] = $this -> input -> post('type_specimen');
		$insertData['date_collection'] = $this -> input -> post('date_collection');
		$insertData['date_sent_lab'] = $this -> input -> post('date_sent_lab');
		$insertData['labresult_tobesentto'] = $this -> input -> post('labresult_tobesentto');
		$insertData['investigator_name'] = $this -> input -> post('investigator_name');
		$insertData['investigator_designation'] = $this -> input -> post('investigator_designation');
		$insertData['epid_year'] = $this -> input -> post('epid_year');
		$insertData['submitted_date'] = $this -> input -> post('submitted_date');
		$insertData['editted_date'] = $this -> input -> post('editted_date');
		$insertData['clinical_competible'] = $this -> input -> post('clinical_competible');
		$insertData['specimen_quantity_adequate'] = $this -> input -> post('specimen_quantity_adequate');
		$insertData['final_classification'] = $this -> input -> post('final_classification');
		$insertData['specimen_collected'] = $this -> input -> post('specimen_collected');
		$query = "SELECT epid_code AS dcode FROM districts WHERE distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$dcode = $result['dcode'];
		$insertData['dcode'] = $dcode;
		$query = "SELECT max(case_number) AS case_number FROM case_investigation_db WHERE case_type='$case_type' AND year='$year' AND distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$fourdigit_number = sprintf('%04u', ($result['case_number'] + 1));
		$case_number = $fourdigit_number;
		$case_epi_no = "PAK/KP/".$dcode."/".$year."/".$case_type."/".$case_number;
		$insertData['case_epi_no'] = $case_epi_no;
		$insertData['case_number'] = $case_number;
		$childAlreadyRegistered = $this -> apis -> check_case_investigation_reg($cardno);
		$insertData['child_registration_num'] = $childAlreadyRegistered;
		$test = $insertData['child_registration_num'];
		if($test > 0){
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"child Registration Number Already Inserted, Kindly give some other number.")));
				}
				 else{
					$insertData['child_registration_num'] = $cardno;
				}
				$insert = $this -> apis -> case_investigation($insertData);
				if($insert){
					return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Data Inserted Successfully!")));
				}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There was some error inserting the data.")));
			}
	}
	public function getCoverageData(){
		$token = $this -> input -> GET('validate_token');
		$userName = $this -> input -> GET('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$fmonthfrom = $this-> input-> GET('fmonthfrom');
		$fmonthto = $this-> input-> GET('fmonthto');
		$uncode = $this-> input-> GET('uncode');
		$antigen = $this-> input-> GET('antigen');
		$explode_date= explode("-",$fmonthfrom);
		$year=$explode_date[0];
		$month=$explode_date[1];
		$insert = $this -> apis -> getCoverageData_monthly($fmonthfrom,$fmonthto,$uncode,$antigen,$year,$month);
		if(! empty($insert)){
				$response = $insert;
				$response = json_encode(array("success"=>"yes", "data"=>$response));
			}
		else{
				$response['success'] = "no";
				$response['message'] = 'No Data Found!';
				$response = json_encode($response);
			}
			return $this->output->set_output($response);
	}
	public function uni_pop_total(){
		$token = $this -> input -> GET('validate_token');
		$userName = $this -> input -> GET('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$day = '01';
		$month = date("m");
		$year = date("Y");
		$frequency = $this-> input-> GET('frequency');
		if($frequency == 0 ){
			$day = date("d");
		}elseif($frequency == 1){
			$month = date("m");
		}elseif($frequency == 2){
			$year = date("Y");
		}else{
			echo 'Kindy selected data';
		}
		$uncode = $this-> input-> GET('uncode');
		$insert = $this -> apis -> uni_pop_model($frequency,$year,$month,$uncode);
		if(! empty($insert)){
				$response = $insert;
				$response = json_encode(array("success"=>"yes", "data"=>$response));
			}
		else{
				$response['success'] = "no";
				$response['message'] = 'No Data Found!';
				$response = json_encode($response);
			}
			return $this->output->set_output($response);
	}
	public function open_close_vial(){
		$token = $this -> input -> GET('validate_token');
		$userName = $this -> input -> GET('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$uncode = $this-> input-> GET('uncode');
		$item_id = $this-> input-> GET('item_id');
		$year_month = $this-> input-> GET('year_month');
		$consumption_id = $item_id;
		$insert = $this -> apis -> open_close_vial($uncode,$item_id,$year_month,$consumption_id);
		if(! empty($insert)){
				$response = $insert;
				$response = json_encode(array("success"=>"yes", "data"=>$response));
			}
		else{
				$response['success'] = "no";
				$response['message'] = 'No Data Found!';
				$response = json_encode($response);
			}
			return $this->output->set_output($response);
	}
	public function fetch_aefi_rep (){
		$token = $this -> input -> GET('validate_token');
		$userName = $this -> input -> GET('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		$child_registration_no = $this-> input-> GET('child_registration_no');
		$insert = $this -> apis -> fetch_aefi_rep_record($child_registration_no);
		if(! empty($insert)){
				$response = $insert;
				$response = json_encode(array("success"=>"yes", "data"=>$response));
			}
		else{
				$response['success'] = "no";
				$response['message'] = 'No Data Found!';
				$response = json_encode($response);
			}
			return $this->output->set_output($response);
	}
	public function shift_outuc_child(){
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		if( ! $this -> input -> post('distcode') AND ! $this -> input -> post('tcode') AND ! $this -> input -> post('uncode') AND ! $this -> input -> post('shiftedout_date')){
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Please provide all valid parameters! District, Tehsil, Unioncouncil and shiftout_date is mendatory.")));
		}
		$data['from_child_registration_no'] = $child_registration_no = $this -> input -> post('child_registration_no');
		//get current district, tehsil, uc, facility details of child
		$fetchChildInfo = $this -> apis -> fetch_child_registration_info($child_registration_no);
		if( ! empty($fetchChildInfo)){
			$data['from_distcode'] = $fetchChildInfo['distcode'];
			$data['from_tcode'] = $fetchChildInfo['tcode'];
			$data['from_uncode'] = $fetchChildInfo['uncode'];
			$data['from_facode'] = $fetchChildInfo['facode'];
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Child information missing on server.")));
		}
		//get posted/shifted to district, tehsil, uc, facility, village details of child
		$data['to_distcode'] = $this -> input -> post('distcode');
		$data['to_tcode'] = $this -> input -> post('tcode');
		$data['to_uncode'] = $this -> input -> post('uncode');
		$data['to_facode'] = $this -> input -> post('facode');
		$data['shiftedout_date'] = $this -> input -> post('shiftedout_date')?$this -> input -> post('shiftedout_date'):date('Y-m-d h:i:s');
		//check if from unioncouncil is same as to unioncouncil
		if($data['from_uncode'] == $data['to_uncode']){
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Child can not be shifted to same UC.")));
		}
		//insert shift out detail in shifted out table
		$this -> db -> insert('cerv_shifted_childs_history', $data);
		$updateChildRow['shift_out_date'] = $data['shiftedout_date'];
		$this -> db -> update('cerv_child_registration', $updateChildRow, array('child_registration_no' => $child_registration_no));
		$this -> apis -> updateSequence($child_registration_no);
		return $this->output->set_output(json_encode(array("success"=>"Yes","message"=>"Shift out record inserted successfully!")));
	}
	
	public function get_all_shifted_out_childs(){
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		if( ! $this -> input -> post('uncode') ){
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Please provide Unioncouncil.")));
		}
		$uncode = $this -> input -> post('uncode');
		$data = $this -> apis -> getAllUcChilds($uncode);
		if($data != 0){
			return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Please provide Unioncouncil.","data"=>$data)));
		}else{
			return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Zero no of Childs have been shifted to your UC.")));
		}
	}
	
	public function accept_shiftedout_child(){
		$token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}
		if( ! $this -> input -> post('distcode') AND ! $this -> input -> post('tcode') AND ! $this -> input -> post('uncode') AND ! $this -> input -> post('shiftedout_date')){
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Please provide all valid parameters! District, Tehsil, Unioncouncil and shiftout_date is mendatory.")));
		}
		$data['child_registration_no'] = $child_registration_no = $this -> input -> post('child_registration_no');
		$updateData['reg_facode'] = $facode = $this -> input -> post('facode');
		$fetchChildHistoryInfo = $this -> apis -> fetch_child_history_info($child_registration_no);
		if($fetchChildHistoryInfo){
			$from_child_registration_no = $fetchChildHistoryInfo['from_child_registration_no'];
			$from_child_registration_no = explode("-",$from_child_registration_no);
			$year = $from_child_registration_no[1];
			$updateData['distcode'] = $fetchChildHistoryInfo['to_distcode'];
			$updateData['tcode'] = $fetchChildHistoryInfo['to_tcode'];
			$updateData['uncode'] = $fetchChildHistoryInfo['to_uncode'];
			$maxCardNo = getMaxCardNoforChild($facode, $year);
			$newCardNo = sprintf("%05d", ($maxCardNo + 1));
			$updateData['cardno'] = $newCardNo;
			$updateData['child_registration_no'] = $newRegistrationNumb = $facode.'-'.$year.'-'.$newCardNo;
			$this -> db -> update('cerv_child_registration',$updateData, array('child_registration_no' => $child_registration_no));
			//update history table
			$updateHistory['to_child_registration_no'] = $newRegistrationNumb;
			$updateHistory['shiftedin_date'] = date('Y-m-d h:i:s');
			$updateHistory['status'] = 1;
			$updateHistory['to_facode'] = $facode;
			$this -> db -> update('cerv_shifted_childs_history',$updateHistory,array('from_child_registration_no'=>$child_registration_no));
			$this -> apis -> updateSequence($newRegistrationNumb);
			return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Child Shifted In Successfully!")));
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"No Shiftout history found for this child")));
		}
	}	
}
?>