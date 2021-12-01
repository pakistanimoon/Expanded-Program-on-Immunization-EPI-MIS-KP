<?php
class Child_list_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Filter_model');
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> helper('indicator_functions_helper');
		$this -> load -> model('Common_model');
		$this -> load -> library('breadcrumbs');
		$this->load->helper('my_functions_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//===== Function to Create Filters for Sepecific Reports Starts Here ===========//
	function Child_list($per_page,$startpoint){
		
		$this -> breadcrumbs -> push('Home', '/');
		//$this -> breadcrumbs -> push('Manage Child', '/childs/Child_list');
        //$wc = getWC();//helper function
	    $query="select recno,cardno as childcode,nameofchild as name_of_child,villagemohallah,dateofbirth as date_of_birth,fathername as fname, housestreet as address,coalesce(unname(uncode),'') as unioncouncil,coalesce(districtname(distcode),'') as district, coalesce(tehsilname(tcode),'') as tehsil,procode as province from cerv_child_registration where deleted_at IS NULL order by submitteddate ASC LIMIT {$per_page} OFFSET {$startpoint}";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	
	// start  code 
	
	public function child_search($childname,$childcardnbr,$fathername,$mobilenbr,$bcg,$cnicnbr,$dateofbirth,$gender,$tcode,$uncode,$facode,$village,$techniciancode){
		
		//print_r($bcg);exit;
		/* $this -> db -> select('techniciancode,technicianname');
		$this -> db -> where(array('facode'=>$facode,'status'=>'Active'));
		return $this -> db -> get('techniciandb') -> result_array(); */
       /*  $query = "SELECT new as techniciancode,name as technicianname from (SELECT DISTINCT ON (code) code,code as new, * FROM hr_db_history ORDER BY code DESC, id DESC ) subquery where post_facode = '$facode' and  post_status='Active' and post_hr_sub_type_id='01'";
		$result = $this-> db-> query($query);
		return $result-> result_array(); */
		
		//$wc = " where nameofchild ='$childname' ";
		
		
		/* $wc = " Where ";
		
		 if ($childname != "") {
			$keyword = $childname['value'];
			$keyword = str_replace('_', ' ', $keyword);
			$keyword = strtolower($keyword);
			$wc .= " ((nameofchild ='$keyword')) and ";
		}
		
		if ($fathername != "") {
			$keyword = $fathername['value'];
			$keyword = str_replace('_', ' ', $keyword);
			$keyword = strtolower($keyword);
			$wc .= " ((fathername ='$keyword')) ";
		} */
		
		
		$wc = '';
		
		 if ($childname != "") {
			$wc .= " nameofchild = '" . $childname . "'  And";
		}
		
		if ($fathername != "") {
			$wc .= " fathername = '" . $fathername . "'  And";
			//$wc .= " fathername = '" . $fathername . "' ";
		} 
		
		 if ($mobilenbr != "") {
			$wc .= " contactno = '" . $mobilenbr . "'  And";
			//$wc .= "  contactno ='$mobilenbr' ";
		}  
		
		if($cnicnbr != ""){
			$wc .= " mothercnic = '" . $cnicnbr . "'  And";
			//$wc = " mothercnic = '$cnicnbr' ";
		}
		
		if($childcardnbr != ""){
			$wc .= " cardno = '" . $childcardnbr . "'  And";
			//$wc = " cardno = '$childcardnbr' ";
			
		}
		if($bcg != ""){
			$wc .= " bcg = '" . $bcg . "'  And";
			//$wc = " cardno = '$childcardnbr' ";
			
		}
		if($dateofbirth != ""){
			$wc .= " dateofbirth = '" . $dateofbirth . "'  And";
			//$wc = " dateofbirth = '$dateofbirth' ";
			
		}
		if($gender != ""){
			$wc .= " gender = '" . $gender . "'  And";
			//$wc = " dateofbirth = '$dateofbirth' ";
			
		}
		if($tcode != "" AND $tcode > 0){
			$wc .= " tcode = '" . $tcode . "'  And";
			//$wc = " dateofbirth = '$dateofbirth' ";
			
		}
		if($uncode != "" AND $uncode > 0){
			$wc .= " uncode = '" . $uncode . "'  And";
			//$wc = " dateofbirth = '$dateofbirth' ";
			
		}
		if($facode != "" AND $facode > 0){
			$wc .= " reg_facode = '" . $facode . "'  And";
			//$wc .= " reg_facode	 = '" . $facode . "'  And";
			//$wc = " dateofbirth = '$dateofbirth' ";
			
		}
		if($village != "" AND $village > 0){
			$wc .= " villagemohallah = '" . $village . "'  And";
			//$wc = " dateofbirth = '$dateofbirth' ";
			
		}
		if($techniciancode != "" AND $techniciancode > 0){
			$wc .= " techniciancode = '" . $techniciancode . "'  And";
			//$wc = " dateofbirth = '$dateofbirth' ";
			
		}
		
		$wc = rtrim($wc,'And');
		
		
		$query = "SELECT recno,cardno,nameofchild,dateofbirth,fathername,distcode,tehsilname(tcode),unname(uncode),address from cerv_child_registration Where $wc LIMIT 30 OFFSET 0 ";
		//print_r($query );
		$result = $this-> db-> query($query);		
		$data['row'] = $result-> result_array();
		return $data['row'];
	}
	
	
	// End   code 
	
		public function child_view($id){
		
		return $this -> db 
					-> select('*')
					-> where('recno',$id)
					-> get('cerv_child_registration') -> row_array();
	}
	public function Child_edit($recno){
		
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		//$this->breadcrumbs->push('Manage Child', '/childs/Child_list');
		//$this->breadcrumbs->push('Update Child', '/childs/cild_edit');
		//////////////////////////////////////////////////////////////////
		$query="select *,recno,cardno, nameofchild, dateofbirth,villagemohallah,fathername,housestreet,uncode,distcode,procode,tcode from cerv_child_registration where recno = '$recno'";
		$result = $this -> db -> query($query);
		$data['childData'] = $result -> result_array();
		return $data;
		
	}
	
	public function Child_add($code){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		//////////////////////////////////////////////////////////////////
		$query="select procode from provinces where procode = '$code'";
		$result = $this -> db -> query($query);
		$data['childData'] = $result -> result_array();
		return $data;	
	}
	
	public function Child_update($childData,$recno){
		$updateQuery = $this -> Common_model -> update_record('cerv_child_registration',$childData,array('recno'=>$recno));
		createTransactionLog("Child Registeration-DB", "Child Registeration Updated ".$recno);
	}
	
	function updateSequence($recno){
		$this -> db -> query("UPDATE cerv_child_registration SET recno=nextval('child_registration_seq') where recno = '{$recno}'");
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	 }
	 
	public function child_add_save_model($childData){
		 //print_r($childData); exit;
				$this->db->insert('cerv_child_registration',$childData);
			    //$updateQuery = $this -> Common_model -> update_record('cerv_child_registration',$childData,array('recno'=>$recno));
				createTransactionLog("Child Registeration-DB", "Child Registeration ADD ");
				$location = base_url(). "childs/Reports_list/child_add";
				$message="Record Add for Child Registeration";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
		exit();
	}
	
	public function Mother_list($per_page, $startpoint){
	    $this -> breadcrumbs -> push('Home', '/');
	    $query="select recno,cardno as mothercode,mother_name as name_of_mother,village,husband_name as hname, house as address,coalesce(unname(uncode),'') as unioncouncil,coalesce(districtname(distcode),'') as district, coalesce(tehsilname(tcode),'') as tehsil,procode as province from cerv_mother_registration order by submitted_date ASC  LIMIT {$per_page} OFFSET {$startpoint}";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		return $data;
	}
	public function Mother_add($code){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		//////////////////////////////////////////////////////////////////
		$query="select procode from provinces where procode = '$code'";
		$result = $this -> db -> query($query);
		$data['motherdData'] = $result -> result_array();
		return $data;		
	}
	public function mother_view($id){
		return $this -> db 
					-> select('recno,cardno,mother_name,husband_name,provincename(procode) as province,districtname(distcode) as district,tehsilname(tcode) as tehsil,unname(uncode) as uc,facilityname(reg_facode) as facility,technicianname(techniciancode) as technician,mother_age,mother_cnic,contactno,villagename(village) as village,house,tt1,tt2,tt3,tt4,tt5')
					-> where('recno',$id)
					-> get('cerv_mother_registration') -> row_array();
	}
	public function mother_add_save_model($motherData){
		//print_r($motherData); exit;
		$this->db->insert('cerv_mother_registration',$motherData);
		createTransactionLog("Mother Registeration-DB", "Mother Registeration ADD ");
		$location = base_url(). "childs/Reports_list/mother_add";
		$message="Record Add for Mother Registeration";
		$this -> session -> set_flashdata('message',$message);
		redirect($location);
		exit();
	}
	public function Mother_edit($recno){
		
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		//$this->breadcrumbs->push('Manage Child', '/childs/Child_list');
		//$this->breadcrumbs->push('Update Child', '/childs/cild_edit');
		//////////////////////////////////////////////////////////////////
	    	$query="select *,recno,cardno, mother_name, mother_age,village,husband_name,uncode,distcode,procode,tcode from cerv_mother_registration where recno = '$recno'";
		    $result = $this -> db -> query($query);
		    $data['childData'] = $result -> result_array();
            return $data;		
		
	}
	public function Mother_update($motherData,$recno){
		 $updateQuery = $this -> Common_model -> update_record('cerv_mother_registration',$motherData,array('recno'=>$recno));
				createTransactionLog("Child Registeration-DB", "Child Registeration Updated ".$recno);
				$location = base_url(). "Reports/motherRegistrationList";
				$message="Record Updated for Child Registeration".$recno;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);

		exit();
	} 

	
}
?>