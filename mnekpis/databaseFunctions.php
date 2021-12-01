<?php
class DatabaseFunctions{
   
   var $host;
   var $database;
   var $username;
   var $password;
   var $dbconn;
   var $result;
   var $port;
   var $arr;
   var $rows;
   var $insertid;
   var $uploadpath;

	function DatabaseFunctions(){
		$this->host = "localhost";
		$this->database = "kpepidb";
		$this->username = "kpepiuser"; 
		$this->password = "KPEpi#987"; 
		$this->port="5432";
		$this->uploadpath='/data/For_Upload/';
   }
   
   function connectDB($db) {
     
     switch($db) {
       case ("psql"):
         $conn_string = "dbname=" . $this->database . " user=" . $this->username . " password=" . $this->password;
         $this->dbconn = pg_Connect($conn_string);
         return $this->dbconn;
         break;
      case ("mysql"):
        $this->dbconn = @mysql_connect($this->host, $this->username, $this->password);
		return $this->dbconn;
        break;
      case("mssql"):
        $this->dbconn = @mssql_connect($this->host, $this->username, $this->password);
        return $this->dbconn;
        break;
	  default:
        return 0;
      }
  }
 
  function selectDB($db) {
	
    switch($db) {
      case ("psql"):
        return 1;
        break;
      case ("mysql"):
        @mysql_select_db($this->database);
		
        return 1;
        break;
      case("mssql"):
        @mssql_select_db($this->database);
        return 1;
        break;
      default;
        return 0;
      }
  }
 
  function queryDB($db, $query, $script) {
  
  	// if u want to support multiple databases, call connectDB() and selectDB() from individual php page. 
 
  	if (!isset($this->dbconn)) {

		$this->dbconn = $this->connectDB($db);
		
		if (!$this->dbconn)
			//echo "Error";
			$this->errorHandler("Error while connecting to the database.<br><br><b>Common solutions:</b><br><br>1. Check that you haven't change default database path and name <br>2. Check your login/password information is correct<br>3. Check that you have read, modify and delete permissions over database file  <br>");
		
		$this->selectDB($db, $this->dbconn);
	}
  
    switch($db) {
      case ("psql"):
        if(!$this->result = @pg_exec($query)){
          $this->result = 0;
        }
        break;
      case ("mysql"):
        if(!$this->result = @mysql_query($query)){
          $this->result = 0;
		  if (mysql_errno())
			$this->errorHandler("Error in ".$script.": <br><br>".mysql_error()."<br><br>When executing:<br>".$query."<br>");
        }
        break;
      case("mssql"):
        if(!$this->result = @mssql_query($query)){
         // if (!empty($msql_error()))
		//	$this->errorHandler("Error in ".$script.": <br><br>".$msql_error()."<br><br>When executing:<br>".$query."<br>");
		  $this->result = 0;
        }
        break;
      default;
        $this->result = 0;
      }
	  	  
    return $this->result;
  }
 
  function returnDBarray($db, $result) {
  	
	if (!isset($this->dbconn)) {

		$this->dbconn = $this->connectDB($db);
		
		if (!$this->dbconn)
			echo "Error";
			//$this->errorHandler("Error while connecting to the database.<br><br><b>Common solutions:</b><br><br>1. Check that you haven't change default database path and name <br>2. Check your login/password information is correct<br>3. Check that you have read, modify and delete permissions over database file  <br>");
		
		$this->selectDB($db, $this->dbconn);
	}
		
    if($result != "error") {
      switch($db) {
        case ("psql"):
          if(!$this->arr = @pg_fetch_array($result)){
            $this->arr = 0;
          }
          break;
          case ("psql123"):
          if(!$this->arr = @pg_fetch_assoc($result)){
            $this->arr = 0;
          }
          break;
        case ("mysql"):
          if(!$this->arr = @mysql_fetch_array($result)){
            $this->arr = 0;
          }
          break;
        case("mssql"):
          if(!$this->arr = @mssql_fetch_array($result)){
            $this->arr = 0;
          }
          break;
        default;
          $this->arr = 0;
      }
      return $this->arr;
    }
  }
 

 function numrowsDB($db, $result) {

   switch($db) {
     case ("psql"):
       if(!$this->rows = @pg_num_rows($result)){
         return 0;
       } else {
         return $this->rows;
       }
       break;
     case ("mysql"):
       if(!$this->rows = @mysql_numrows($result)){
         return 0;
       } else {
         return $this->rows;
       }
       break;
     case("mssql"):
       if(!$rows = @mssql_num_rows($result)){
         return 0;
       } else {
         return $this->rows;
       }
       break;
     default;
       return 0;
     }
   }
    function insertidDB($db) {

   switch($db) {
      case ("mysql"):
       if(!$this->insertid = @mysql_insert_id()){
         return 0;
       } else {
         return $this->insertid;
       }
       break;    
     default;
       return 0;
     }
   }
 function errorHandler($message){
   	//print($message);
   	header("Location: http://" . $_SERVER['HTTP_HOST']. dirname($_SERVER['PHP_SELF']). "/error.php?error=".urlencode($message));
	exit();
 }
 
 function closeDB($db,$dbconn) {
    switch($db) {
      case ("psql"):
        if(!@pg_close($this->dbconn)){
          return 0;
        } else {
         return 1;
       }
       break;
     case ("mysql"):
       if(!@mysql_close($this->dbconn)){
         return 0;
       } else {
         return 1;
       }
       break;
     case("mssql"):
       if(!@mssql_close($this->dbconn)){
         return 0;
       } else {
         return 1;
       }
       break;
     default;
       return 0;
     }
 }
 function points($value){
 	$pos=strpos($value,".");
	if ($pos!=""){
		$pot=explode(".",$value);
		if (strlen($pot[1])==1){
			$value=$value."0";
		}
	}else{
		$value=$value.".00";
	}
	return $value;
 }
}

function newid($dbf, $id, $table)
	{
	$_query = "select max(count) as id from counter";
	$r = $dbf->queryDB("psql",$_query,"Add Forms");
	$rs = pg_fetch_row($r);
	$nextval = $rs[0];
	$newcounter = $nextval+1;
	$_query = "update counter set count = $newcounter";
	$dbf->queryDB("psql",$_query,"Add Forms");
	$level = $_SESSION[UserLevel];
	switch($level)
		{
		case '1':
			$nextval = 'N-'.($nextval+1);
			break;
		case '2':
			$nextval = 'P'.$_SESSION[Province].'-'.($nextval+1);
			break;
		case '3': 
			$nextval = 'D'.$_SESSION[District].'-'.($nextval+1);
			break;
		case '4': 
			$nextval = 'F'.$_SESSION[Facility].'-'.($nextval+1);	
			break;
		case '5': 
			$nextval = 'T'.$_SESSION[Tehsil].'-'.($nextval+1);		
			break;
			case '8':
			$nextval = 'P'.$_SESSION[Province].'-'.($nextval+1);
			break;
		}
		
	return $nextval;	
	}

function newtsessionid($dbf, $id, $table)
{
	if($id=='tsessionid' or $id=='trainerid')
	{
		$_query = "select max(count) as id, max(trainer) as tid from tscounter";
		$r = $dbf->queryDB("psql",$_query,"Add Forms");
		$rs = pg_fetch_row($r);
		
		if($id=='tsessionid')
		{
			$nextval = $rs[0];
			$newcounter = $nextval+1;
			$_query = "update tscounter set count = $newcounter";
			$dbf->queryDB("psql",$_query,"Add Forms");
		}else if($id=='trainerid')
		{
			$nextval = $rs[1];
			$newcounter = $nextval+1;
			$_query = "update tscounter set trainer = $newcounter";
			$dbf->queryDB("psql",$_query,"Add Forms");	
		}
		if(strlen($newcounter)==1)
			$nextval = "000".$newcounter;
		else if(strlen($newcounter)==2)
			$nextval = "00".$newcounter;
		else if(strlen($newcounter)==3)
			$nextval = "0".$newcounter;
	}	
	else if($id=='participantid')
	{
		$session_id=$table;
		$_query = "select count(*) as id from participants where session_id='$session_id'";
		$r = $dbf->queryDB("psql",$_query,"Add Forms");
		$rs = pg_fetch_row($r);
		$count = $rs[0];
		if($count==0)
		{
			$_query = "update tscounter set participant = 0";
			$dbf->queryDB("psql",$_query,"Add Forms");
		}
		$_query = "select max(participant) as id from tscounter";
		$r = $dbf->queryDB("psql",$_query,"Add Forms");
		$rs = pg_fetch_row($r);
		$nextval = $rs[0];
		$newcounter = $nextval+1;
		$_query = "update tscounter set participant = $newcounter";
		$dbf->queryDB("psql",$_query,"Add Forms");	
		
		if(strlen($newcounter)==1)
			$nextval = $session_id."0".$newcounter;
		else
			$nextval = $session_id . $newcounter;
			
	}
	else if($id=='cmwcode')
	{
	$District=$table;
	$_query = "select max(cmwcount) as id from tscounter";
	$r = $dbf->queryDB("psql",$_query,"Add Forms");
	$rs = pg_fetch_row($r);
	$nextval = $rs[0];
	$newcounter = $nextval+1;
	$_query = "update tscounter set cmwcount = $newcounter";
	$dbf->queryDB("psql",$_query,"Add Forms");

		if(strlen($newcounter)==1)
			$nextval = $District."00".$newcounter;
		elseif(strlen($newcounter)==2)
			$nextval = $District."0".$newcounter;
		else
			$nextval = $District . $newcounter;
	}
	return $nextval;	
}

 function user_rights($dbf, $type)
 		{
		switch($type)
			{
			case "add":
				$_query = "select rt_add from user_rights where userid = $_SESSION[Userid];";	
				$rt=$dbf->queryDB("psql",$_query,"Districts");
				$rs=$dbf->returnDBarray("psql",$rt);
				if($rs[rt_add] == '1')
					return true; 
				else 
					return false;
				break;	
			case "edit":
				$_query = "select rt_edit from user_rights where userid = $_SESSION[Userid];";	
				$rt=$dbf->queryDB("psql",$_query,"Districts");
				$rs=$dbf->returnDBarray("psql",$rt);
				if($rs[rt_edit] == '1')
					return true; 
				else 
					return false;

				break;	
			case "delete":
				$_query = "select rt_delete from user_rights where userid = $_SESSION[Userid];";	
				$rt=$dbf->queryDB("psql",$_query,"Districts");
				$rs=$dbf->returnDBarray("psql",$rt);
				if($rs[rt_delete] == '1')
					return true; 
				else 
					return false;

				break;	
			}
	
		}

?>
