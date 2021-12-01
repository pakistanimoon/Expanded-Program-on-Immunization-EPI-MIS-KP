<?php 
class Measles_model extends CI_Model {

	public function add_data($distcode=NULL,$year1=NULL,$case=NULL)
	{	
		$year = date('Y');
		$this->db-> select('distcode,district');
		$this-> db-> from ('districts');
		$data['districts'] = $this-> db-> get()-> result_array();
		$this->db->distinct();
		$this-> db-> select ('year');
		$this-> db-> from ('case_investigation_db');
		$this->db->order_by("year", "desc");
		$data['year'] = $this-> db-> get()-> result_array();

		$this-> db-> select ('type_case_name,short_name');
		$this-> db-> from ('surveillance_cases_types');
		$data['surveillance_cases_types'] = $this-> db-> get()-> result_array();
		$this-> db-> select ('id,distcode,case_epi_no,case_type,report_submit_status,patient_name,patient_fathername,specimen_received_date,quantity_adequate,cold_chain_ok,specimen_received_by,received_by_designation,lab_id_number,lab_testdone_date,type_of_test,specimen_result,comments,lab_report_sent_date,report_sent_by,sent_by_designation,result_saved_date');
	    
		$this-> db-> from ('case_investigation_db');
		if ($distcode) { $this->db->where('distcode', $distcode); }
		if ($case) { $this->db->where('case_type', $case); }
		if ($year1) { $this->db->where('year', $year1);
		}else{ $this->db->where('year', $year); }
		$this->db->where('(report_submit_status = \'0\' OR specimen_result IS NULL OR specimen_result = \'0\')', null, false);
		$this->db->order_by("case_epi_no,districtname(distcode)", "asc");
		 $this->db->limit(50);
		$data['lab_report'] = $this-> db-> get()-> result_array();
	//echo $this->db->last_query();
		return $data;
	}
	public function dataentry_save($surveillance,$id)
	{		
		$this->db->where('id', $id);
		$this->db->update('case_investigation_db',$surveillance);
		return TRUE;		
	}
	public function search_by_epid()
	{
		$this-> db-> select ('type_case_name,short_name');
		$this-> db-> from ('surveillance_cases_types');
		//$this->db->where('report_submit_status', 0);
		$data['surveillance_cases_types'] = $this-> db-> get()-> result_array();

		$this-> db-> select ('district,epid_code');
		$this-> db-> from ('districts');
		$data['districts'] = $this-> db-> get()-> result_array();
		return $data;
	}
	public function search_epid_nb($case_epi_no)
	{	
		//$data =$this->add_data();
		$data =$this->search_by_epid();
		$this-> db-> select ('case_epi_no,case_type,report_submit_status,patient_name,patient_fathername,specimen_received_date,quantity_adequate,cold_chain_ok,specimen_received_by,received_by_designation,lab_id_number,lab_testdone_date,type_of_test,specimen_result,comments,lab_report_sent_date,report_sent_by,sent_by_designation,result_saved_date ,other_specimen_lab,other_specimen_result,leakage_broken,test_possible');
		$this-> db-> from ('case_investigation_db');
		$this->db->where('case_epi_no', $case_epi_no);
		//$this->db->where('report_submit_status', 0);
		$data['case_epi_no'] = $this-> db-> get()-> result_array();
		return $data;
	}
		public function epid_data_save($surveillance,$case_epi_no)
	{
		$this->db->where('case_epi_no', $case_epi_no);
		$this->db->update('case_investigation_db',$surveillance);
		return TRUE;		
	}
	
}
?>