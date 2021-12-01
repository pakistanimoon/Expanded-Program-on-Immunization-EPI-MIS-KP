<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * DiseaseSurveillance_model class.
 *
 * @extends CI_Model
 */
class DiseaseSurveillance_model extends CI_Model {
	public function __construct() 
	{
		parent::__construct();
	}
	
	function Esure_case_investigation($insertData){
		$this -> db -> insert('case_investigation_db',$insertData);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function zero_report_api($insertData){
		$this -> db -> insert('zero_report',$insertData);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function AEFI_report_api($insertData){
		$this -> db -> insert('aefi_rep',$insertData);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	
	function AFP_report_api($insertData){
		$this -> db -> insert('afp_case_investigation',$insertData);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	
	function CoronaInvestigation_report_api($insertData){
		$this -> db -> insert('corona_case_investigation_form_db',$insertData);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	
	function NNT_report_api($insertData){
		$this -> db -> insert('nnt_investigation_form',$insertData);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
}
?>