<?php
error_reporting(0);

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
		$this->database = "epikpdb";
		$this->username = "epikpuser"; 
		$this->password = "epikp#876"; 
		$this->port="5432";
		$this->uploadpath='data/For_Upload/'; 
   }    // end function DatabaseFunctions()

  function connectDB($db) {
     switch($db) {
       case ("psql"):
         $conn_string = "host=" . $this->host ." port=". $this->port ." dbname=" . $this->database . " user=" . $this->username . " password=" . $this->password;
         $this->dbconn = pg_connect($conn_string);
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
      } // end switch($db)
  }  // end function connectDB($db)
 
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
      }  // end switch($db)
  }  // end function selectDB($db)

  function queryDB($db, $query, $script) {
  	// if u want to support multiple databases, call connectDB() and selectDB() from individual php page. 
  	if (!isset($this->dbconn)) {
  		$this->dbconn = $this->connectDB($db);
  		if (!$this->dbconn)
  			$this->errorHandler("Error while connecting to the database.<br><br><b>Common solutions:</b><br><br>1. Check that you haven't change default database path and name <br>2. Check your login/password information is correct<br>3. Check that you have read, modify and delete permissions over database file  <br>");
  		$this->selectDB($db, $this->dbconn);
	  }  // end if (!isset($this->dbconn))

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
      }  // end switch($db)
    return $this->result;
  }   // end function queryDB($db, $query, $script)

  function returnDBarray($db, $result) {
  	if (!isset($this->dbconn)) {
  		$this->dbconn = $this->connectDB($db);
  		if (!$this->dbconn)
  			$this->errorHandler("Error while connecting to the database.<br><br><b>Common solutions:</b><br><br>1. Check that you haven't change default database path and name <br>2. Check your login/password information is correct<br>3. Check that you have read, modify and delete permissions over database file  <br>");
  		$this->selectDB($db, $this->dbconn);
  	} // end if (!isset($this->dbconn))
  
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
        }  // end switch($db)
        return $this->arr;
      }  // end if($result != "error")
  }  // end function returnDBarray($db, $result)

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
     }  // end switch($db)
   } // end function numrowsDB($db, $result)

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
       } // end switch($db)
   } // end function insertidDB($db)


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
     }  // end switch($db)
 }  // end function closeDB($db,$dbconn)

}

?>
