<?php
class Setup_listing extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {

		parent::__construct();
		if(!isset($_SESSION['UserAuth']) == 'Yes' ){
				redirect(base_url());exit();
		}
		$this -> load -> model('Setup_listing_model');
	}
	

	//================ Constructor function Ends==================//
	//================************************==================//
	//================ Listing function starts==================//
	public function listing() {
		$listing_name = $this->uri->segment(3);
		//echo $listing_name;exit;
		$data = $this->Setup_listing_model->listing($listing_name);
		//print_r($data);exit;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/listing_view';
			$data['pageTitle']='EPI-MIS | Setup Listing';
			$this->load->view('template/epi_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
	}

	//================ Listing function Ends==================//
	//================************************==================//
	//================ District function starts==================//
	public function district_listing(){
		//print_r($this->input->post());exit();
		if($this->input->post('distcode')){
			redirect('Setup_listing/tehsil_listing?distcode='.$this->input->post('distcode').'&year='.$this->input->post('year'));
		}
		$listing_name = $this->uri->segment(3);
		$year = $this->input->get_post('year');
		$data = $this->Setup_listing_model->district_listing($listing_name,$year);		
		//print_r($year);exit();
		$data['data']=$data;
	    $data['year']=$year;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/district_listing_view';
			$data['pageTitle']='EPI-MIS Setup Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}

	}
	//================ District function Ends==================//
	//================************************==================//
	//================ Tehsil function starts==================//
	public function tehsil_listing() {
		$year = $this->input->get_post('year');
		//echo "danish";exit;
		$data = $this->Setup_listing_model->tehsil_listing($year);
		$data['data']=$data;
		$data['year'] = $year;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/tehsil_listing';
			$data['pageTitle']='EPI-MIS | Tehsil Listing';
			$this->load->view('template/reports_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
	}
	//================ Tehsil function Ends==================//
	//================************************==================//
	//================ Health Facility function starts==================//
	public function EPI_Centers_listing() {
		
		$year = $this->input->get_post('year');
		$data = $this->Setup_listing_model->epi_centers_listing($year);
		$data['data']=$data;
        $data['year'] = $year;		
		if($data != 0){
            $data['fileToLoad'] = 'setup_listing/epi_centers_listing';
			$data['pageTitle']='EPI-MIS | Health Facility Listing';
			$this->load->view('template/reports_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
	}
	//================ Health Facility function Ends==================//
	//================************************==================//
	//================************************==================//
	//================ VPD Centers starts==================//
	public function VPD_Centers_listing() {
		
		$year = $this->input->get_post('year');
		$data = $this->Setup_listing_model->vpd_centers_listing($year);
		$data['data']=$data;
        $data['year'] = $year;		
		if($data != 0){
            $data['fileToLoad'] = 'setup_listing/vpd_centers_listing';
			$data['pageTitle']='EPI-MIS | Health Facility Listing';
			$this->load->view('template/reports_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
	}
     //================ VPD Centers function Ends==================//
    //================************************==================//
	//================ Union function starts==================//

	public function union_council_listing() {
		$year = $this->input->get_post('year');
		//echo $year;exit;
		$data = $this->Setup_listing_model->union_council_listing($year);
		$data['data']=$data;
		$data['year'] = $year;
		if($data != 0){
            $data['fileToLoad'] = 'setup_listing/union_council_listing';
			$data['pageTitle']='EPI-MIS | Union council Listing';
			$this->load->view('template/reports_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
	}
	//================ Union function Ends==================//
	//================************************==================//
	public function	DataEntry_Operator_listing(){
		$data = $this->Setup_listing_model->DataEntry_Operator_listing();
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/DataEntry_Operator_listing';
			$data['pageTitle']='EPI-MIS | Data Entry Operator Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
	//================ Data Entry Operator function Ends==================//
	//================************************==================//
		//================ Store Keeepr function starts==================//
    public function	StoreKeeper_listing(){
		$data = $this->Setup_listing_model->StoreKeeper_listing();
		
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/StoreKeeper_listing';
			$data['pageTitle']='EPI-MIS | Store Keeper Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
	//================ Supervisor function starts==================//
    public function	supervisor_listing(){
		$data = $this->Setup_listing_model->supervisor_listing();
		$data['data']=$data;
		if($data != 0){
		    $data['fileToLoad'] = 'setup_listing/supervisor_listing';
			$data['pageTitle']='EPI-MIS | Supervisor Listing';
			$this->load->view('template/reports_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
    }
	//================ Supervisor function Ends==================//
	//================************************==================//
	//================ Technician function starts==================//
    public function	technician_listing(){
		//print_r($_POST);exit;
		//$data['year'] = $_POST['year'];
		//echo $data;exit;
	//	echo "danish";exit;
	$year = $this->input->get_post('year');
//echo $year;exit;
	$data = $this->Setup_listing_model->technician_listing($year);
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/technician_listing';
			$data['pageTitle']='EPI-MIS | Technician Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
	//================ Technician function Ends==================//
	//================************************==================//
	//================ Medical Technician function starts==================//
    public function	med_technician_listing(){
		$data = $this->Setup_listing_model->med_technician_listing();
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/med_technician_listing';
			$data['pageTitle']='EPI-MIS | Medical Technician Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
	//================ Medical Technician function Ends==================//
	//================************************==================//
	//================ Computer Operator function starts==================//
    public function	computer_operator_listing(){
		$data = $this->Setup_listing_model->computer_operator_listing();
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/computer_operator_listing';
			$data['pageTitle']='EPI-MIS | Computer Operator Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }//================ Computer Operator function starts==================//
	//================************************==================//
	//================ Generator Operator function starts==================//
    public function	generator_operator_listing(){
		$data = $this->Setup_listing_model->generator_operator_listing();
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/generator_operator_listing';
			$data['pageTitle']='EPI-MIS | Generator Operator Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
	//================ Generator Operator function Ends==================//
	//================************************==================//
	//================ Cold Chain Operator function starts==================//
    public function	cold_chain_operator_listing(){
		$data = $this->Setup_listing_model->cold_chain_operator_listing();
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/cold_chain_operator_listing';
			$data['pageTitle']='EPI-MIS | Generator Operator Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
	//================ Cold Chain Operator function Ends==================//
	//================************************==================//
	//================ District Surveillance Officer function starts==================// 
	 public function	district_surveillance_officer_listing(){
		$data = $this->Setup_listing_model->district_surveillance_officer_listing();
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/district_surveillance_officer_listing';
			$data['pageTitle']='EPI-MIS | District Surveillance Officer Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
    //================ District Surveillance Officer function Ends==================//
	//================************************==================//
	//================ Cold Chain Technician function starts==================//
    
     public function cold_chain_technician_listing(){
		 
		$data = $this->Setup_listing_model->cold_chain_technician_listing();
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/cold_chain_technician_listing';
			$data['pageTitle']='EPI-MIS | CC Technician Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
   
    }
    //================ Cold Chain Technician function Ends==================//
	//================************************==================//
	//================ Cold Chain Mechanic function starts==================//
    
     public function cold_chain_mechanic_listing(){
		$data = $this->Setup_listing_model->cold_chain_mechanic_listing();
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/cold_chain_mechanic_listing'; 
			$data['pageTitle']='EPI-MIS | Cold Chain Mechanic Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
    //================ Cold Chain Mechanic function Ends==================//
	//================************************==================//
	//================ Cold Chain Generator Operator function starts==================//
    
     public function cold_chain_generator_operator_listing(){
		$data = $this->Setup_listing_model->cold_chain_generator_operator_listing(); 
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/cold_chain_generator_operator_listing'; 
			$data['pageTitle']='EPI-MIS | Cold Chain Generator Operator Listing';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
	  //================ Cold Chain Mechanic function Ends==================//
	//================************************==================//
	//================ Cold Chain Driver function starts==================//
    
     public function cold_chain_driver_listing(){
		$data = $this->Setup_listing_model->cold_chain_driver_listing();
		$data['data']=$data;
		if($data != 0){
			$data['fileToLoad'] = 'setup_listing/cold_chain_driver_listing'; 
			$data['pageTitle']='EPI-MIS | Driver Listing';
			$this->load->view('template/reports_template',$data);   
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		} 	
    }
	//================ Cold Chain Driver function Ends==================//
	//================************************==================//
	//================ HRfunction starts==================//
    public function	hr_listing(){
		$data = $this->Setup_listing_model->hr_listing();
		$data['data']=$data;
		if($data != 0){
		    $data['fileToLoad'] = 'setup_listing/hr_listing_view';
			$data['pageTitle']='EPI-MIS | HR Listing';
			$this->load->view('template/reports_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
    }
	//================ Summary function starts==================//

       public function	summary_listing(){
		  //print_r($_REQUEST);exit;
		  // echo "danish";exit;
			$type=$this->input->get('listing');
			//echo $type;exit;
			//echo "danish";exit;
			$sup_type=$this->input->get('sup_type');
			$statustype=$this->input->get_post('status');
			$year = $this->input->get_post('year');
			//echo $year;exit;
			$data = $this->Setup_listing_model->summary_listing($type,$sup_type,$year,$statustype);
			$data['data']=$data;
			if($data != 0){
				$data['fileToLoad'] = 'setup_listing/summary_listing';
				$data['pageTitle']='EPI-MIS | Summary Listing';
				$this->load->view('template/reports_template',$data);
            }else{
				$data['message']="You must have rights to access this page.";
				$this->load->view("message",$data);
			}
    	}
	//================ Summary function Ends==================//

  

}

