<?php
	date_default_timezone_set("Asia/Karachi");
 	include("databaseFunctions.php");
	$dbf = new DatabaseFunctions; 
 	include("mfunctions.php");

 	$data = file_get_contents('php://input');
	$json = json_decode($data);
	//echo json_encode(array("success"=>$_FILES));exit;
	//print_r($_FILES['pic']['name']);exit;
	$username=$json->{'vaccinator_code'};
	$imei_no=$json->{'imei'};
	$data=$json->{'data'};
	$imei=$json->{'imeino'};
	//////single picture upload/////

				 $fileName = $_FILES['pic']['name'];
				$fileArray = explode('.', $fileName);
				$fileExt = ".jpg";//end($fileArray);
				//echo json_encode(array("success"=>$fileExt));exit;
				$date = date('Y-m-d H:i:s');
				//$fileName = "qqqo.".$fileExt;
				$temp = $_FILES['pic']['tmp_name'];
				$dir_separator = DIRECTORY_SEPARATOR;
				$folder = "/uploads/child";
				$destination_path = "/var/www/html/epiict".$folder.$dir_separator;
				$target_path = $destination_path.$fileName;
				if (move_uploaded_file($temp,$target_path) ) {
					echo json_encode(array("success"=>"Uploaded"));
						//echo "Uploaded";
				}else{
					//echo "File was not uploaded";
					echo json_encode(array("success"=>"File was not uploaded"));
				} 
				//echo json_encode(array("success"=>"Yes"));
				exit;  
	
	//////////
	//////More then one picture upload/////
//	foreach( $_FILES[ 'image' ][ 'tmp_name' ] as $index => $tmpName )
	  /* foreach($_FILES['pic']['name'] as $key => $val ){
				 $filename = $_FILES['pic']['name'][$key];
				 echo json_encode(array("success"=>$filename));
				 $fileArray = explode('.',$fileName);
                 echo json_encode(array("success"=>$fileArray));
				 $fileExt = end($fileArray);
				 echo json_encode(array("success"=>$fileExt)); */
				 //echo json_encode(array("success"=>$fileExt));
				 /* $fileName = "qaq.".$fileExt;
				 //$temp = $_FILES['pic']['tmp_name'];
				 $dir_separator = DIRECTORY_SEPARATOR;
				 $folder = "/uploads/child";
				 $destination_path = "/var/www/html/epiict".$folder.$dir_separator;
				 $target_path = $destination_path.$fileName;
				 move_uploaded_file($temp,$target_path);    */
				// print_r($filename);
				 /* $fileName = $_FILES['pic']['name'];
				$fileArray = explode('.', $fileName);
				$fileExt = end($fileArray);
				$date = date('Y-m-d H:i:s');
				$fileName = "qaq.".$fileExt;
				$temp = $_FILES['pic']['tmp_name'];
				$dir_separator = DIRECTORY_SEPARATOR;
				$folder = "/uploads/child";
				$destination_path = "/var/www/html/epiict".$folder.$dir_separator;
				$target_path = $destination_path.$fileName;
				move_uploaded_file($temp,$target_path);   
				echo json_encode(array("success"=>"Yes")); */
				// echo json_encode(array("success"=>"Yes"));
				
	//}exit;  
	/////////////end//////////////
	if(authenticationbyimei($dbf, $username, $imei_no)){
		//echo json_encode(array("success"=>"authenticationbyimei"));	exit;
		$i=0;
		foreach($data as $levels){
			//echo json_encode(array("success"=>"outer foreach"));	exit;
			$i++;
			//echo $i.": ";
			$fields = array();
			$values = array();
			foreach($levels as $key => $value){
				if(!is_null($value)){
					//echo $key."[".$i."] = ".$value."\r\n";
					$fields[] = $key;
					$values[] = "'".$value."'";
				}
				//echo json_encode(array("success"=>"iner foreach"));	exit;
			//echo $child_registration_no;
			}
			 $child_registration_no = $levels->{'child_registration_no'};
			//echo json_encode(array("child_registration_no"=>$child_registration_no));exit;
			
			
			//echo'test';exit;
			if(checkChiledRegisted($dbf,$child_registration_no)){
				//echo json_encode(array("success"=>"update"));	exit;
				$updatequery = "UPDATE cerv_child_registration_test set (".implode(',', $fields).") = (".implode(',', $values).") where child_registration_no='".$child_registration_no."' ";
				$dbf->queryDB("psql",$updatequery,"update"); 
				echo json_encode(array("success"=>"yes"));
			}else{
				//echo json_encode(array("success"=>"insert"));	exit;
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