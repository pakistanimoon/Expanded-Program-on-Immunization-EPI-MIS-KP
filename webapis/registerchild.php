<?php
	date_default_timezone_set("Asia/Karachi");
 	include("databaseFunctions.php");
	$dbf = new DatabaseFunctions; 
 	include("mfunctions.php");
 	$data = file_get_contents('php://input');
	$json = json_decode($data);
	$username=$json->{'username'};
	$imei_no=$json->{'imeino'};
	$data=$json->{'data'};
	$imei=$json->{'imeino'};
	
	//print_r($_FILES);exit;
	if($_FILES){
		//////single picture upload/////
				$fileName = $_FILES['pic']['name'];
				$fileArray = explode('.', $fileName);
				$fileExt = ".jpg";//end($fileArray);
				//echo json_encode(array("success"=>$fileName));
				$date = date('Y-m-d H:i:s');
				//$fileName = "qqqo.".$fileExt;
				$temp = $_FILES['pic']['tmp_name'];
				$dir_separator = DIRECTORY_SEPARATOR;
				$folder = "/uploads/child";
				$destination_path = "/var/www/html/epikp".$folder.$dir_separator;
				$target_path = $destination_path.$fileName;
				//echo json_encode(array("success"=>$target_path));
				//echo json_encode(array("success"=>$temp));
				if (move_uploaded_file($temp,$target_path)){
					echo json_encode(array("success"=>"Uploaded"));
				}else{
					echo json_encode(array("success"=>"File was not uploaded"));
				} 
				
	////////////////			
	}else{
		echo json_encode(array("success"=>"File Not set"));		
	} 
	if(authenticationbyimei($dbf, $username, $imei_no)){
		$i=0;
		foreach($data as $levels){
			$i++;
			$fields = array();
			$values = array();
			foreach($levels as $key => $value){
				if(!is_null($value)){
					$fields[] = $key;
					$values[] = "'".$value."'";
				}
			}
			 $child_registration_no = $levels->{'child_registration_no'};
			if(checkChiledRegisted($dbf,$child_registration_no)){
				$updatequery = "UPDATE cerv_child_registration_test set (".implode(',', $fields).") = (".implode(',', $values).") where child_registration_no='".$child_registration_no."' ";
				$dbf->queryDB("psql",$updatequery,"update"); 
				echo json_encode(array("success"=>"yes"));
			}else{
				$insertquery = "insert into cerv_child_registration_test (".implode(',', $fields).") values (".implode(',', $values).") ";
				$dbf->queryDB("psql",$insertquery,"add"); 
				echo json_encode(array("success"=>"yes"));
			}
			
			
		}
			
	}else{
		echo json_encode(array("success"=>"no"));		
	} 
	function checkChiledRegisted($dbf,$child_registration_no){
		$query = "SELECT child_registration_no from cerv_child_registration_test where child_registration_no='".$child_registration_no."' ";
		$result= $dbf->queryDB("psql",$query,"check");
		$row=$dbf->returnDBarray("psql", $result);
		$child_registration_no1 = $row["child_registration_no"];
		if($child_registration_no == $child_registration_no1 ){
			return true;
		}else{
			return false;
		}
	}
	
?>