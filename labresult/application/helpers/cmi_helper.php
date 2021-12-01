<?php
function getTehsils($isreturn=false,$tcode=NULL){
  $CI = & get_instance();
  $wc = "";
  $distu =$CI-> session -> userdata('distcode');
  $output = "";
  $query="Select tehsilname,tcode from tehsil where distcode='$distu' order by tcode";
  $result = $CI -> db ->query($query);
  $result1 = $result->result_array();
  foreach ($result1 as $oneteh ) {
  /* if(validation_errors() != false){
    $errorshow = set_select('tcode',$oneteh["tcode"]);
    $output .='<option value="'.$oneteh["tcode"].'"'.$errorshow.'>'.$oneteh["tehsil"].'</option>';
  } 
   else { */
   $selected = '';
   if(($tcode > 0)&&($tcode == $oneteh["tcode"]))
   {
    $selected = 'selected="selected"';
   }
   $output .= '<option value="'.$oneteh["tcode"].'" '.$selected.' >'.$oneteh["tehsilname"].'</option>';
 // }
  }
  if($isreturn)
   return $output;
  echo $output;
 }
  function getTehsils_options($isreturn=false,$tcode=NULL,$distcode=NULL){
  //$CI = & get_instance();
    $CI = & get_instance();
  $wc = "";
    $distcode =$CI-> session -> userdata('distcode');
  if($distcode){
   $wc = "distcode = '$distcode'";
  }else{
   $wc = getWC();
  }  
  $output = '<option value="0" >-- Select Tehsil--</option>';
  $query="Select tehsilname,tcode from tehsil where $wc order by tcode";
  $result = $CI -> db ->query($query);
  $result1 = $result->result_array();
  foreach ($result1 as $oneteh) { 
   $selected = '';
   if(($tcode > 0)&&($tcode == $oneteh["tcode"]))
   {
    $selected = 'selected="selected"';
   }
   $output .= '<option value="'.$oneteh["tcode"].'" '.$selected.' >'.$oneteh["tehsilname"].'</option>';
  }
  if($isreturn)
   return $output;
  echo $output;
 }
function getUCs_options($isreturn=false,$uncode=NULL){
  $CI = & get_instance();
  $wc = "";
  $distcode =$CI-> session -> userdata('distcode');
   if($distcode){
   $wc = "distcode = '$distcode'";
  }
  $output = '<option value="" >-- Select Unioncouncil--</option>';
  $query="Select unname,uncode from unioncouncil where $wc order by uncode";
  $result = $CI -> db ->query($query);
  $result1 = $result->result_array();
  foreach ($result1 as $oneteh) { 
   $selected = '';
   if(($uncode > 0)&&($uncode == $oneteh["uncode"]))
   {
    $selected = 'selected="selected"';
   }
   $output .= '<option value="'.$oneteh["uncode"].'" '.$selected.' >'.$oneteh["unname"].'</option>';
  }
  if($isreturn)
   return $output;
  echo $output;
 }
 function getFacilities_options($isreturn=false,$facode=NULL,$uncode=NULL){
  $CI = & get_instance();
  $wc = "";
   $distcode =$CI-> session -> userdata('distcode');
   if($distcode){
   $wc = "distcode = '$distcode'";
  }
/*  switch ($module) {
   case 'vaccine':
    $fmonth = date('Y-m', strtotime('first day of previous month'));
    $wc .= " AND getfstatus_vacc('$fmonth',facode::text)='F' ";
    break;
   case 'disease_surveillance':
    # code...
    break;
   default:
    # code...
    break;
  }*/
  $output = '<option value="" >--Select Facility--</option>'; 
  $query="Select facilityname,facode from facilities where $wc  order by facode";
  if($uncode != NULL)
   $query="Select facilityname,facode from facilities where uncode='$uncode' order by facode";
  $result = $CI -> db ->query($query);
  $result1 = $result->result_array();
  foreach ($result1 as $oneteh) { 
   $selected = '';
   if(($facode > 0)&&($facode == $oneteh["facode"]))
   {
    $selected = 'selected="selected"';
   }
   $output .= '<option value="'.$oneteh["facode"].'" '.$selected.' >'.$oneteh["facilityname"].'</option>';
  }
  if($isreturn)
   return $output;
  echo $output;
 }
/* function get_District_Name($distcode){
  $CI = & get_instance();
  $query   = "Select districtname from district where distcode = '$distcode'";
  $resultDist = $CI -> db -> query($query);
  
  if(isset($resultDist -> row()->districtname)){
    return $resultDist -> row()->districtname;
  }
   else{
    return " ";
   }
 }*/
 if(!function_exists('get_District_Name')){
  function get_District_Name($distcode){
    $CI = & get_instance();
    $query    = "Select districtname from district where distcode = '$distcode'";
    $resultDist = $CI -> db -> query($query);   
    if ($resultDist->num_rows() > 0)
    {
      return $resultDist -> row()->districtname;  
    }else{
      return '';  
    }
  }
}
 function get_Tehsil_Name($tcode){
  $CI = & get_instance();
  if (!empty($tcode)) {
    $query = "Select tehsilname from tehsil where tcode = '$tcode'";
  $resultTeh = $CI -> db -> query($query) -> row_array();
  return $resultTeh['tehsilname'];
  }
  else{
    return "";
  }

  
 }
 function get_UC_Name($uncode){
  $CI = & get_instance();
  if (!empty($uncode)) {
   $query   = "Select unname from unioncouncil where uncode = '$uncode'";
  $resultUC = $CI -> db -> query($query);
  return $resultUC -> row()->unname;
  }
  else{
    return "";
  }
  /*$query   = "Select unname from unioncouncil where uncode = '$uncode'";
  $resultUC = $CI -> db -> query($query);
  if($resultUC -> num_rows() >0)
  {
   return $resultUC -> row()->unname; 
  }
  return ""; */
 }
 if(!function_exists('get_Facility_Name')){
  function get_Facility_Name($facode){
    $CI = & get_instance();
    $query    = "Select facilityname from facilities where facode = '$facode'";
    $resultFac = $CI -> db -> query($query);   
    if ($resultFac->num_rows() > 0)
    {
      return $resultFac -> row()->facilityname;  
    }else{
      return '';  
    }
  }
}
 // if(!function_exists('get_Facility_Name')){
 //   function get_Facility_Name($facode){
 //    $CI = & get_instance();
 //    if (!empty($facode)) {
 //      $query   = "Select facilityname from facilities where facode = '$facode'";
 //    $result = $CI -> db -> query($query);
 //    return $result -> row()->facilityname;
 //    }
 //    else{
 //      return ""; 
 //    }
    /*$query   = "Select facilityname from facilities where facode = '$facode'";
    $result = $CI -> db -> query($query);
    if($result -> num_rows() >0)
    {
     return $result -> row()->facilityname;
    }
    return ""; */
//    }
// }
function getmonthdesc($month){
	$monthdesc="";
	switch($month){
		case '1': $monthdesc="Jan";break;
		case '2': $monthdesc="Feb";break;
		case '3': $monthdesc="Mar";break;
		case '4': $monthdesc="Apr";break;
		case '5': $monthdesc="May";break;
		case '6': $monthdesc="Jun";break;
		case '7': $monthdesc="Jul";break;
		case '8': $monthdesc="Aug";break;
		case '9': $monthdesc="Sep";break;
		case '10':$monthdesc="Oct";break;
		case '11':$monthdesc="Nov";break;
		case '12':$monthdesc="Dec";break;
	}
	return $monthdesc;
}
if(!function_exists('getAllYearsOptions')){
	function getAllYearsOptions($selected=NULL){		
		$output = "";
		$years=date('Y');$output = '';
		$preyears=2013;
		for($x=$years;$x>=$preyears;$x--){
			$isSelected = ($selected && $selected==$x)?'selected="selected"':((isset($_REQUEST["year"]) && $_REQUEST["year"]==$x)?'selected="selected"':'');
			$output .= '<option value="'.$x.'" '.$isSelected.' >'.$x.'</option>';
		}
		echo $output;
	}
}
if(!function_exists('getAllMonthsOptions')){
	function getAllMonthsOptions($selected=false,$selectedYear=false){		
		$output = '<option value="0">--Select--</option>';
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$restrict = ($selectedYear && $selectedYear>0 && $selectedYear==date("Y"))?date('m'):false;
		foreach ($months as $num => $monthitem) {
			if($restrict && $restrict<$num){break;}
			$month = sprintf("%02d", $num);
			$isSelected = ($selected && $selected==$month)?'selected="selected"':((isset($_REQUEST["month"]) && $_REQUEST["month"]==$month)?'selected="selected"':'');
			$output .= '<option value="'.$month.'" '.$isSelected.' >'.$monthitem.'</option>';
		}
		echo $output;
	}
}
if(!function_exists('convertNumberToWord')){
	function convertNumberToWord($num = false)
	{
		$num = str_replace(array(',', ' '), '' , trim($num));
		if(! $num) {
			return false;
		}
		$num = (int) $num;
		$words = array();
		$list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
			'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
		);
		$list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
		$list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
			'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
			'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
		);
		$num_length = strlen($num);
		$levels = (int) (($num_length + 2) / 3);
		$max_length = $levels * 3;
		$num = substr('00' . $num, -$max_length);
		$num_levels = str_split($num, 3);
		for ($i = 0; $i < count($num_levels); $i++) {
			$levels--;
			$hundreds = (int) ($num_levels[$i] / 100);
			$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
			$tens = (int) ($num_levels[$i] % 100);
			$singles = '';
			if ( $tens < 20 ) {
				$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
			} else {
				$tens = (int)($tens / 10);
				$tens = ' ' . $list2[$tens] . ' ';
				$singles = (int) ($num_levels[$i] % 10);
				$singles = ' ' . $list1[$singles] . ' ';
			}
			$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
		} //end for loop
		$commas = count($words);
		if ($commas > 1) {
			$commas = $commas - 1;
		}
		return implode(' ', $words);
	}
}
/*
@ Author:        Nasir Israr
@ Email:         nasir@pace-tech.com
@ Function:      Dropdowns
@ Description:   Form dropdowns
*/
function getStockYearsOptions($year=NULL,$isreturn=false){
   $years = date("Y", strtotime( date( 'Y-m-01' )." -1 months"));
   $output = '';
   $preyears=2016;
   for($x=$years;$x>=$preyears;$x--){
      //$isSelected = (isset($_REQUEST["year"]) && $_REQUEST["year"]==$x)?'selected="selected"':'';
      $isSelected = (isset($year) && $year==$x)?'selected="selected"':'';
      $output .= '<option value="'.$x.'" '.$isSelected.' >'.$x.'</option>';
   }
   if($isreturn)
      return $output;
   echo $output;
}
/*
@ Author:        Nasir Israr
@ Email:         nasir@pace-tech.com
@ Function:      Dropdowns
@ Description:   Form dropdowns
*/
function getStockMonthsOptions($selected=false,$selectedYear=false){    
   // $output = '<option value="0">--Select--</option>';
   $months = array("01" => 'January', "02" => 'February', "03" => 'March', "04" => 'April', "05" => 'May', "06" => 'June', "07" => 'July', "08" => 'August', "09" => 'September', "10" => 'October', "11" => 'November', "12" => 'December');
   $restrict = ($selectedYear && $selectedYear>0 && $selectedYear==date("Y"))?date('m'):false;
   foreach ($months as $num => $monthitem) {
      if($restrict && $restrict<$num){break;}
      $month = sprintf("%02d", $num);
      $isSelected = ($selected && $selected==$month)?'selected="selected"':((isset($_REQUEST["month"]) && $_REQUEST["month"]==$month)?'selected="selected"':'');
      $output .= '<option value="'.$month.'" '.$isSelected.' >'.$monthitem.'</option>';
   }
   echo $output;
}
// function getStockMonthsOptions($selectedmonth=false,$isreturn=false){
//    $months = array("01" => 'January', "02" => 'February', "03" => 'March', "04" => 'April', "05" => 'May', "06" => 'June', "07" => 'July', "08" => 'August', "09" => 'September', "10" => 'October', "11" => 'November', "12" => 'December');
//    $output = '';
//    //$mnth = isset($_REQUEST["month"])?$_REQUEST["month"]:'';
//    $mnth = isset($selectedmonth)?$selectedmonth:'';
//    $currMyear = date("Y");
//    $prevMyear = date("Y", strtotime( date( 'Y-m-01' )." -1 months"));
//    if($currMyear==$prevMyear)
//    {
//       for ($i = 12; $i >= 1; $i--) {
//          $currM = date("m");
//          if($i>=$currM)
//          {}
//          else{
//             $isSelected = ($mnth==$i)?'selected="selected"':'';
//             $month = sprintf("%02d", $i);
//             $output .= '<option value="'.$month.'" '.$isSelected.' >'.$months[$month].'</option>';
//          }
//       }
//    }
//    else if($currMyear > $prevMyear)
//    {
//       for ($i = 12; $i >= 1; $i--) {
//          //$num = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
//          $isSelected = ($mnth==$i)?'selected="selected"':'';
//          $month = sprintf("%02d", $i);
//          $output .= '<option value="'.$month.'" '.$isSelected.' >'.$months[$month].'</option>';
//       }
//    } 
//    if($isreturn)
//       return $output;
//    echo $output;
// }
function monthname($month){   
   switch($month){
      case "01": return "January";
            break;
      case "02": return "February";
            break;
      case "03": return "March";
            break;
      case "04": return "April";
            break;
      case "05": return "May";
            break;
      case "06": return "June";
            break;
      case "07": return "July";
            break;
      case "08": return "August";
            break;
      case "09": return "September";
            break;
      case "10": return "October";
            break;
      case "11": return "November";
            break;
      case "12": return "December";          
   }
}

// if(!function_exists('getWC_Array')){
//    function getWC_Array($procode=0,$distcode=0,$facode=0,$alias=NULL){
//       $CI = & get_instance();
//       $wc = array();
//       $level = "district";
//       switch ($CI -> session -> UserLevel) {
//          case '1' :
//             # code...
//             break;
//          case '2' :
//             if (($procode > 0) && ($distcode > 0)) {
//                $wc[] = "{$alias}procode = '" . $procode . "'";
//                $wc[] = "{$alias}distcode = '" . $distcode . "'";
//             } else if ($procode > 0) {
//                $wc[] = "{$alias}procode = '" . $procode . "'";
//             }
//             break;
//          case '3' :
//             if (($procode > 0) && ($distcode > 0)) {
//                $wc[] = "{$alias}procode = '" . $procode . "'";
//                $wc[] = "{$alias}distcode = '" . $distcode . "'";
//             }
//             $level = "facility";
//             break;
//          case '4' :
//             if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
//                $wc[] = "{$alias}procode = '" . $procode . "'";
//                $wc[] = "{$alias}distcode = '" . $distcode . "'";
//                $wc[] = "{$alias}facode = '" . $facode . "'";
//             }
//             $level = "facility";
//             break;
//       }
//       return $wc;
//    }
// }

 if(!function_exists('getFacilityType')){
 function getFacilityType($isreturn=false,$fatype=NULL){
  $CI = & get_instance();
 
  $output = '';
  $query="Select DISTINCT fatype from facilities  order by fatype ASC";
  $result = $CI -> db ->query($query);
  $result1 = $result->result_array();
  foreach ($result1 as $oneteh) { 
   $selected = '';
   if($fatype == $oneteh["fatype"])
   {
    $selected = 'selected="selected"';
   }
   $output .= '<option value="'.$oneteh["fatype"].'" '.$selected.' >'.$oneteh["fatype"].'</option>';
  }
  if($isreturn)
   return $output;
  echo $output;
 }
}
 if(!function_exists('getFacility_incharge')){
 function getFacility_incharge($isreturn=false,$incharge=NULL){
  $CI = & get_instance();
 
  $output = '';
  $query="Select DISTINCT incharge from facilities  order by incharge ASC";
  $result = $CI -> db ->query($query);
  $result1 = $result->result_array();
  foreach ($result1 as $oneteh) { 
   $selected = '';
   if($incharge == $oneteh["incharge"])
   {
    $selected = 'selected="selected"';
   }
   $output .= '<option value="'.$oneteh["incharge"].'" '.$selected.' >'.$oneteh["incharge"].'</option>';
  }
  if($isreturn)
   return $output;
  echo $output;
 }
}
if(!function_exists('get_CaseType_Name')){
 function get_CaseType_Name($caseCode){
  $CI = & get_instance();
  $query   = "SELECT type_case_name from surveillance_cases_types where short_name = '$caseCode' " ;
  $resultCase = $CI -> db -> query($query);
  return $resultCase -> row()->type_case_name; 
 }
}
?>