<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Measles_Case extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('utype')=='LRDEO' && $this->session->userdata('username'))  {
		$this -> load -> model('Login_model','login');
		$this -> load -> model('Measles_model','measles'); 
		$this -> load -> helper('cmi_helper'); 
		}else{
		redirect(base_url());
		}
	}

	public function add_data()
	{	$year1= date('Y');
		$distcode = $this->input->post('distcode');
		$year = $this->input->post('year');
		$case = $this->input->post('case'); 
		$data = $this -> measles -> add_data($distcode,$year,$case);
		$data['data'] = '';
		$data['selected_distcode'] = $distcode;
		if ($year) {
			$data['selected_year'] = $year ;
		}else{
			$data['selected_year'] = $year1 ;
		}
		
		$data['selected_case'] = $case ;
		$data['fileToLoad'] = 'data_entry/add_dataentry'; 
		$data['pageTitle'] = 'EPI Surveillance Lab Results'; 
		$this->load->view('template/eslr_template',$data);
	}
	public function dataentry_save()
	{			
		$id=$this->input->post('id');
		//echo $id;exit;
		$status=1;
		$surveillance = array(
			"specimen_received_date"=>(($this->input->post('specimen_received_date') != '')?$this->input->post('specimen_received_date'):NULL),
			/*"specimen_condition"=>$this->input->post('specimen_condition'),*/
			
			"quantity_adequate"=>(($this->input->post('quantity_adequate') != '')?$this->input->post('quantity_adequate'):NULL),
			
			"cold_chain_ok"=>(($this->input->post('cold_chain_ok') != '')?$this->input->post('cold_chain_ok'):NULL),
			
			"specimen_received_by"=>(($this->input->post('specimen_received_by') != '')?$this->input->post('specimen_received_by'):NULL),
			"received_by_designation"=>(($this->input->post('received_by_designation') != '')?$this->input->post('received_by_designation'):NULL),
			"lab_id_number"=>(($this->input->post('lab_id_number') != '')?$this->input->post('lab_id_number'):NULL),
			"lab_testdone_date"=>(($this->input->post('lab_testdone_date') != '')?$this->input->post('lab_testdone_date'):NULL),
			"type_of_test"=>(($this->input->post('type_of_test') != '')?$this->input->post('type_of_test'):NULL),
			"specimen_result"=>(($this->input->post('specimen_result') != '')?$this->input->post('specimen_result'):NULL),
			"comments"=>(($this->input->post('comments') != '')?$this->input->post('comments'):NULL),	
			"lab_report_sent_date"=>(($this->input->post('lab_report_sent_date') != '')?$this->input->post('lab_report_sent_date'):NULL),
			"report_sent_by"=>(($this->input->post('report_sent_by') != '')?$this->input->post('report_sent_by'):NULL),	
			"sent_by_designation"=>(($this->input->post('sent_by_designation') != '')?$this->input->post('sent_by_designation'):NULL),			
			"result_saved_date"=>date('Y-m-d'),
			"report_submit_status"=>$status
		);
		//print_r($surveillance); exit;
			if($this->input->post('quantity_adequate') == 2)
			{
				$surveillance["leakage_broken"] = $this->input->post('leakage_broken');
				$surveillance["test_possible"] = $this->input->post('test_possible');
			}
			if ($this->input->post('type_of_test') == 'Other')
			{
				$surveillance["other_specimen_lab"] = $this->input->post('other_specimen_lab');			
			}
			if ($this->input->post('specimen_result') == 'Other')
			{
				$surveillance["other_specimen_result"] = $this->input->post('other_specimen_result');
			}
				
			$this -> measles -> dataentry_save($surveillance,$id);
			redirect(base_url("Measles_Case/add_data"));
	}
	public function search_by_epid()
	{
		$data = $this -> measles -> search_by_epid();
		//print_r($data);exit;
		$data['data'] = '';
		$data['fileToLoad'] = 'data_entry/search_by_epid'; 
		$data['pageTitle'] = 'EPI Surveillance Lab Results'; 
		$this->load->view('template/eslr_template',$data);
	}
	public function search_epid_nb()
	{		
		$epid=$this->input->post('epid');
		$district=$this->input->post('district');
		$year=$this->input->post('year');
		$case=$this->input->post('case');
		$measlenumber=$this->input->post('measlenumber');			
		$case_epi_no = $epid . "/" . $district . "/" . $year. "/" . $case. "/" . $measlenumber;
		$data = $this -> measles -> search_epid_nb($case_epi_no);
		//print_r($data);exit;
		
		if ( ! empty($data['case_epi_no']) )
		{
			if(isset($data['case_epi_no'][0]['report_submit_status']) AND (int)$data['case_epi_no'][0]['report_submit_status'] == 1)
			{
				$this->session->set_flashdata('message', 'This case has already been submitted!<div id="e">
				<a class="btn btn-primary" id="btn"><i class="fa fa-pencil"></i> Edit this</a>
				</div>
				<div id="v" class="hide">
				<a class="btn btn-primary" id="btn1"><i class="fa fa-eye"></i> View this</a>
				</div>');
			}
			$data['data'] = '';
			$data['fileToLoad'] = 'data_entry/search_by_epid'; 
			$data['pageTitle'] = 'EPI Surveillance Lab Results'; 
			$this->load->view('template/eslr_template',$data);
		}else{
			$this->session->set_flashdata('message', 'This EPID Number does not exist!');
			redirect(base_url("Measles_Case/search_by_epid"));
		}
	}
		public function epid_data_save()
	{		
		$case_epi_no=$this->input->post('case_epi_no');		
		$status=1;
		$surveillance = array(
			"specimen_received_date"=>(($this->input->post('specimen_received_date') != '')?$this->input->post('specimen_received_date'):NULL),
			/*"specimen_condition"=>$this->input->post('specimen_condition'),*/			
			"quantity_adequate"=>(($this->input->post('quantity_adequate') != '')?$this->input->post('quantity_adequate'):NULL),			
			"cold_chain_ok"=>(($this->input->post('cold_chain_ok') != '')?$this->input->post('cold_chain_ok'):NULL),			
			"specimen_received_by"=>(($this->input->post('specimen_received_by') != '')?$this->input->post('specimen_received_by'):NULL),
			"received_by_designation"=>(($this->input->post('received_by_designation') != '')?$this->input->post('received_by_designation'):NULL),
			"lab_id_number"=>(($this->input->post('lab_id_number') != '')?$this->input->post('lab_id_number'):NULL),
			"lab_testdone_date"=>(($this->input->post('lab_testdone_date') != '')?$this->input->post('lab_testdone_date'):NULL),
			"type_of_test"=>(($this->input->post('type_of_test') != '')?$this->input->post('type_of_test'):NULL),
			"specimen_result"=>(($this->input->post('specimen_result') != '')?$this->input->post('specimen_result'):NULL),
			"comments"=>(($this->input->post('comments') != '')?$this->input->post('comments'):NULL),	
			"lab_report_sent_date"=>(($this->input->post('lab_report_sent_date') != '')?$this->input->post('lab_report_sent_date'):NULL),
			"report_sent_by"=>(($this->input->post('report_sent_by') != '')?$this->input->post('report_sent_by'):NULL),	
			"sent_by_designation"=>(($this->input->post('sent_by_designation') != '')?$this->input->post('sent_by_designation'):NULL),
			"result_saved_date"=>date('Y-m-d'),
			"report_submit_status"=>$status			
		);
		if($this->input->post('quantity_adequate') == 2)
			{
				$surveillance["leakage_broken"] = $this->input->post('leakage_broken');
				$surveillance["test_possible"] = $this->input->post('test_possible');
			}
			if ($this->input->post('type_of_test') == 'Other')
			{
				$surveillance["other_specimen_lab"] = $this->input->post('other_specimen_lab');			
			}
			if ($this->input->post('specimen_result') == 'Other')
			{
				$surveillance["other_specimen_result"] = $this->input->post('other_specimen_result');
			}
		$this -> measles -> epid_data_save($surveillance,$case_epi_no);
		redirect(base_url("Measles_Case/search_by_epid"));
	}
	public function edit_search_by_epid()
	{	
		$data = $this -> measles -> search_by_epid();
		//print_r($data);exit;
		$data['data'] = '';
		$data['fileToLoad'] = 'data_entry/edit_search_by_epid'; 
		$data['pageTitle'] = 'EPI Surveillance Lab Results'; 
		$this->load->view('template/eslr_template',$data);
	}	
}
?>
