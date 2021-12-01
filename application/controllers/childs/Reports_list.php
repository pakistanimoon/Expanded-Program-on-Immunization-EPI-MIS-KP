<?php
class Reports_list extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> model ('Child_list_model');
		$this -> load -> library('reportfilters');
		$this -> load -> model('Common_model');
	}
		/* function child_list(){
			$dataChild['pageTitle']	='CERV | Permanent Vaccination Register';
		//$dataChild['pageTitle']='Child Registration';
		$dataChild['data'] = $this -> child -> Child_Registration($dataChild['pageTitle']);
		$dataChild['fileToLoad'] 	= 'cervReports/permanent_vaccination_register_view';
		
		//$dataChild['fileToLoad'] = 'childs/child_registration';
		$this -> load -> view('template/reports_template',$dataChild);
	} */
	public function child_list(){ 
		//live
		//Code for Pagination
		 $page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 50; 
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cerv_child_registration";
		$data = $this ->Child_list_model ->Child_list($per_page,$startpoint);
		$wc='procode is not NULL';
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'childs/Child_list';
			$data['pageTitle'] = 'EPI-MIS | List of Child';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	// new code start
	
	
	public function child_vaccinated_search()
	{
		
		/* $childname = $this -> input -> post('nameofchild');
		
		$search = $this -> Child_list_model -> child_search($childname);
		
		 */
	
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$order = $this->input->get("order");
		$search = $this->input->get("search");
		$columns = $this->input->get("columns");
		$id = $this -> session -> pk_id;
		
		//print_r($search);exit;
		if(isset($search))
		{
			$keyword = $search['value'];
			$keyword = str_replace('_', ' ', $keyword);
			$keyword = strtolower($keyword);
			$search = "where (nameofchild LIKE '$keyword%') OR (fathername LIKE '$keyword%')";
			
		}
		else
		{
			$search = "";
		}
		$col = 0;
		$dir = "";
		if(!empty($order))
		{
			foreach($order as $o) 
			{
				$col = $o['column'];
				$dir= $o['dir'];
			}
		}

		if($dir != "desc" && $dir != "desc") {
			$dir = "desc"; 
		}

		$columns_valid = array(
			"serial",
			"cardno",
			"nameofchild",
			"dateofbirth",
			"fathername",
			"distcode",
			"tcode",
			"uncode",
			"address",
		);
		
		if(!isset($columns_valid[$col])) {
			$order = '';
		} elseif($draw == 1) {
			$order = " order by recno".' '.$dir;
		}
		else
		{
			$order = "order by ".$columns_valid[$col].' '.$dir;
		}

		$query = "
		SELECT recno,cardno,nameofchild,dateofbirth,fathername,distcode,tcode,uncode,address from cerv_child_registration 
		$search $order LIMIT {$length} OFFSET {$start}  ";
		
		$operator = $this->db->query($query);
		$data = array();
		$i=$start+1;
		foreach($operator->result() as $r) 
		{
			$data[] = array(
				"serial" => $i,
				"cardno" => $r->cardno,
				"nameofchild" => $r->nameofchild,
				"dateofbirth" => $r->dateofbirth,
				"fathername" => $r->fathername,
				"distcode" => $r->distcode,
				"tcode" => TehsilName($r->tcode),
				"uncode" => UnName($r->uncode),
				"address" => $r->address,
				"recno" => $r->recno,
			);
			$i++;
		}
		$query = "SELECT COUNT(*) AS num FROM cerv_child_registration";
		$total_mfpdb = $this->db->query($query)->row();
		$billion = array(
			"draw" => $draw,
			"recordsTotal" => $total_mfpdb->num,
			"recordsFiltered" => $total_mfpdb->num,
			"data" => $data
		);
		echo json_encode($billion);
		exit();
	}
	
	// new code 
	
	public function child_search(){
		 //print_r($_POST);exit;
		//$tcode  = $this-> input-> POST('tcode');
		$childname  = $this-> input-> POST('nameofchild');
		$childcardnbr  = $this-> input-> POST('childcardnbr');
		$fathername = $this-> input-> POST('fathername');
		$mobilenbr  = $this-> input-> POST('mobilenbr');
		$bcg        = $this-> input-> POST('bcg');
		$cnicnbr    = $this-> input-> POST('cnicnbr'); 
		
		$dateofbirth = $this-> input-> POST('dateofbirth');
		$gender = $this-> input-> POST('gender');
		$tcode  = $this-> input -> post('tcode');
		$uncode  = $this-> input -> post('uncode');
		$facode  = $this-> input -> post('facode');
		$village  = $this-> input -> post('village');
		$techniciancode  = $this-> input -> post('techniciancode');
		//print_r($bcg);exit;
		//$fathername = $this-> input-> POST('fathername');
		$data['LinkedCase'] = $this-> Child_list_model-> child_search($childname,$childcardnbr,$fathername,$mobilenbr,$bcg,$cnicnbr,$dateofbirth,$gender,$tcode,$uncode,$facode,$village,$techniciancode);
		echo json_encode($data['LinkedCase']);
		//print_r($data);exit;
		
		// new code by nasir
		
		/* $linked_epid_number = $this -> input -> post('linked_epid_number');
		$data['LinkedCase'] = $this -> Ajax_cross_notified_model -> getLinked_CaseInformation($linked_epid_number);
		//print_r($data);
		echo json_encode($data['LinkedCase']); */
		
		// new code by nasir
		
		
		
		
		
		//$result = $this->db->query();
		
		//print_r($data);exit;
		//$data ='<div class="col-md-4"><label class="radio-inline radiopop"><input '..' type="radio" name="cfc_free">NA</input></label></div><div class="col-md-4"><label class="radio-inline radiopop"><input disabled="disabled" '.$varChecked2.' type="radio" name="cfc_free">Yes</input></label></div><div class="col-md-4"><label class="radio-inline radiopop"><input disabled="disabled" '.$varChecked3.' type="radio" name="cfc_free">No</input></label></div>';
		
		/* 	foreach($result as $key => $childnames){
				
			
			$data = '<table>
							<tr>
								<th> Name of Child </th>
							</tr>
							<tr>
								<td>
								'.echo $childnames['nameofchild'].'
									</td>
							</tr>
					 </table>';
		}   */
		
		//echo $data;
	//	$data['allData'] = $result;
		
		//exit();
		
		
		/* $childname = $this -> input -> post('nameofchild');
		//print_r($childname );exit; 
		$data = $this -> Child_list_model -> child_search($childname);
		
		$data['fileToLoad'] = 'childs/Child_list';
		$data['pageTitle'] = 'EPI-MIS | Search Child List';
		$this -> load -> view('template/epi_template', $data);
		
		
	 	$data = '<option value="">--Select Technician--</option>';
		if( ! empty($technicians)){
			foreach($technicians as $key => $technician){
				$data .= '<option value="'.$technician['techniciancode'].'">'.$technician['technicianname'].'</option>';
			}
		}
		echo $data; */ 
	}
	
	// End code 
	public function child_add() {
		//echo'on working condition';exit;
		$code= $this -> session -> Province; 
		$data['data'] = $data = $this ->Child_list_model ->Child_add($code);
		$data['fileToLoad'] = 'childs/Child_add';
		$data['pageTitle'] = 'EPI-MIS | Add Child Registration Form';
		$this -> load -> view('template/epi_template', $data);
		
	}
	public function child_edit() {
		//dataEntryValidator(0);
		$recno = $this -> uri -> segment(3);
		$data = $this -> Child_list_model ->Child_edit($recno);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'childs/Child_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Child Registration Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}

	public function child_view($id)
	{
		$data['data']   = $this -> Child_list_model -> child_view($id);
		$data['fileToLoad'] = 'childs/Child_view';
		$data['pageTitle'] = 'EPI-MIS | View Child Registration Form';
		$this -> load -> view('template/epi_template', $data);
	}
 	
	public function child_add_save() {
		$reg_facode = $this -> input -> post ('facode');
		$cardno = $this -> input -> post ('cardno');
		//$techniciancode='701049001';
		/*explode for year*/
		$dateofbirth = $this -> input -> post ('dateofbirth');
		$explode_date= explode("-",$dateofbirth);
		$year=$explode_date[0];
		/*explode for child_registration_no*/
		$arr = array($reg_facode,$year,$cardno);
		$child_registration_no=implode("-",$arr);
	
				$childData = array(
					'child_registration_no' => ($child_registration_no)? $child_registration_no : Null,
					//'techniciancode' => ($techniciancode)? $techniciancode : Null,
					'year' => ($year)? $year : Null,
					'procode' => ($this -> input -> post ('procode'))? $this -> input -> post ('procode') : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'uncode' => ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null,
					'reg_facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'techniciancode' => ($this -> input -> post ('techniciancode'))? $this -> input -> post ('techniciancode') : Null,
					//'recno' => ($this -> input -> post ('recno'))? $this -> input -> post ('recno') : Null,
					'dateofbirth' => ($this -> input -> post ('dateofbirth'))? $this -> input -> post ('dateofbirth') : Null,
					'dateofdeath' => ($this -> input -> post ('dateofdeath'))? $this -> input -> post ('dateofdeath') : Null,
					'dateofrefusal' => ($this -> input -> post ('dateofrefusal'))? $this -> input -> post ('dateofrefusal') : Null,
					'gender' => ($this -> input -> post ('gender'))? $this -> input -> post ('gender') : Null,
					'cardno' => ($this -> input -> post ('cardno'))? $this -> input -> post ('cardno') : Null,
					'nameofchild' => ($this -> input -> post ('nameofchild'))? $this -> input -> post ('nameofchild') : Null,
					'villagemohallah' => ($this -> input -> post ('address'))? $this -> input -> post ('address') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'mothername' => ($this -> input -> post ('mothername'))? $this -> input -> post ('mothername') : Null,
					'mothercnic' => ($this -> input -> post ('mothercnic'))? $this -> input -> post ('mothercnic') : Null,
					'fathercnic' => ($this -> input -> post ('fathercnic'))? $this -> input -> post ('fathercnic') : Null,
					'contactno' => ($this -> input -> post ('contactno'))? $this -> input -> post ('contactno') : Null,
					'housestreet' => ($this -> input -> post ('housestreet'))? $this -> input -> post ('housestreet') : Null,
					'bcg' => ($this -> input -> post ('bcg'))? $this -> input -> post ('bcg') : Null,
					'hepb' => ($this -> input -> post ('hepb'))? $this -> input -> post ('hepb') : Null,
					'opv0' => ($this -> input -> post ('opv0'))? $this -> input -> post ('opv0') : Null,
					'opv1' => ($this -> input -> post ('opv1'))? $this -> input -> post ('opv1') : Null,
					'opv2' => ($this -> input -> post ('opv2'))? $this -> input -> post ('opv2') : Null,
					'opv3' => ($this -> input -> post ('opv3'))? $this -> input -> post ('opv3') : Null,
					'penta1' => ($this -> input -> post ('penta1'))? $this -> input -> post ('penta1') : Null,
					'penta2' => ($this -> input -> post ('penta2'))? $this -> input -> post ('penta2') : Null,
					'penta3' => ($this -> input -> post ('penta3'))? $this -> input -> post ('penta3') : Null,
					'rota1' => ($this -> input -> post ('rota1'))? $this -> input -> post ('rota1') : Null,
					'rota2' => ($this -> input -> post ('rota2'))? $this -> input -> post ('rota2') : Null,
					'pcv1' => ($this -> input -> post ('pcv1'))? $this -> input -> post ('pcv1') : Null,
					'pcv2' => ($this -> input -> post ('pcv2'))? $this -> input -> post ('pcv2') : Null,
					'pcv3' => ($this -> input -> post ('pcv3'))? $this -> input -> post ('pcv3') : Null,
					'ipv' => ($this -> input -> post ('ipv'))? $this -> input -> post ('ipv') : Null,
					'measles1' => ($this -> input -> post ('measles1'))? $this -> input -> post ('measles1') : Null,
					'measles2' => ($this -> input -> post ('measles2'))? $this -> input -> post ('measles2') : Null,
			    );
            //print_r($childData);exit;
			$data = $this -> Child_list_model -> child_add_save_model($childData);
			//print_r($data); exit;
	}
	 public function child_update() {
		$recno = $this -> input -> post ('recno');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('nameofchild',' Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('fathername',' Father Name','trim|required|alpha_spaces');
		if ($this->form_validation->run() === FALSE) 
		{
			if($recno!=''){
				$data = $this -> Child_list_model -> Child_edit($recno);
				if ($data != 0){
					$data['data'] = $data;
					$data['fileToLoad'] = 'childs/Child_edit';
					$data['pageTitle'] = 'EPI-MIS | Update Child Registration Form';
					//$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				}else{
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
		}else{
			if($this -> input -> post ('recno')){
				$childData = array(
					'procode' => ($this -> input -> post ('procode'))? $this -> input -> post ('procode') : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'uncode' => ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null,
					'reg_facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'techniciancode' => ($this -> input -> post ('techniciancode'))? $this -> input -> post ('techniciancode') : Null,
					'recno' => ($this -> input -> post ('recno'))? $this -> input -> post ('recno') : Null,
					'cardno' => ($this -> input -> post ('cardno'))? $this -> input -> post ('cardno') : Null,
					'nameofchild' => ($this -> input -> post ('nameofchild'))? $this -> input -> post ('nameofchild') : Null,
					'villagemohallah' => ($this -> input -> post ('address'))? $this -> input -> post ('address') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'housestreet' => ($this -> input -> post ('housestreet'))? $this -> input -> post ('housestreet') : Null,
					'dateofbirth' => ($this -> input -> post ('dateofbirth'))? $this -> input -> post ('dateofbirth') : Null,
					'gender' => ($this -> input -> post ('gender'))? $this -> input -> post ('gender') : Null,
					'mothername' => ($this -> input -> post ('mothername'))? $this -> input -> post ('mothername') : Null,
					'fathercnic' => ($this -> input -> post ('fathercnic'))? $this -> input -> post ('fathercnic') : Null,
					'mothercnic' => ($this -> input -> post ('mothercnic'))? $this -> input -> post ('mothercnic') : Null,
					'contactno' => ($this -> input -> post ('contactno'))? $this -> input -> post ('contactno') : Null,
					'bcg' => ($this -> input -> post ('bcg'))? $this -> input -> post ('bcg') : Null,
					'hepb' => ($this -> input -> post ('hepb'))? $this -> input -> post ('hepb') : Null,
					'opv0' => ($this -> input -> post ('opv0'))? $this -> input -> post ('opv0') : Null,
					'opv1' => ($this -> input -> post ('opv1'))? $this -> input -> post ('opv1') : Null,
					'opv2' => ($this -> input -> post ('opv2'))? $this -> input -> post ('opv2') : Null,
					'opv3' => ($this -> input -> post ('opv3'))? $this -> input -> post ('opv3') : Null,
					'penta1' => ($this -> input -> post ('penta1'))? $this -> input -> post ('penta1') : Null,
					'penta2' => ($this -> input -> post ('penta2'))? $this -> input -> post ('penta2') : Null,
					'penta3' => ($this -> input -> post ('penta3'))? $this -> input -> post ('penta3') : Null,
					'rota1' => ($this -> input -> post ('rota1'))? $this -> input -> post ('rota1') : Null,
					'rota2' => ($this -> input -> post ('rota2'))? $this -> input -> post ('rota2') : Null,
					'pcv1' => ($this -> input -> post ('pcv1'))? $this -> input -> post ('pcv1') : Null,
					'pcv2' => ($this -> input -> post ('pcv2'))? $this -> input -> post ('pcv2') : Null,
					'pcv3' => ($this -> input -> post ('pcv3'))? $this -> input -> post ('pcv3') : Null,
					'ipv' => ($this -> input -> post ('ipv'))? $this -> input -> post ('ipv') : Null,
					'measles1' => ($this -> input -> post ('measles1'))? $this -> input -> post ('measles1') : Null,
					'measles2' => ($this -> input -> post ('measles2'))? $this -> input -> post ('measles2') : Null,	
				);
				$data = $this -> Child_list_model -> Child_update($childData,$recno);
				$this -> Child_list_model -> updateSequence($recno);
				$location = base_url(). "Reports/ChildRegistrationList";
				$message="Record Updated Successfully";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
		}
	 }
 } 
	public function mother_list(){
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 50;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cerv_child_registration";
		$data = $this ->Child_list_model ->Mother_list($per_page,$startpoint);
		$wc='procode is not NULL';
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?',$wc);
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'childs/Mother_list';
			$data['pageTitle'] = 'EPI-MIS | List of Mother';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function mother_vaccinated_search()
	{
		 
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$order = $this->input->get("order");
		$search = $this->input->get("search");
		$columns = $this->input->get("columns");
		$id = $this -> session -> pk_id;
		if(isset($search))
		{
			$keyword = $search['value'];
			$keyword = str_replace('_', ' ', $keyword);
			$keyword = strtolower($keyword);
			$search = "where ((cardno LIKE '$keyword%') OR (reg_facode LIKE '$keyword%') OR (lower(mother_name) LIKE '%$keyword%'))";
		}
		else
		{
			$search = "";
		}
		$col = 0;
		$dir = "";
		if(!empty($order))
		{
			foreach($order as $o) 
			{
				$col = $o['column'];
				$dir= $o['dir'];
			}
		}

		if($dir != "asc" && $dir != "desc") {
			$dir = "asc";
		}

		$columns_valid = array(
			"serial",
			"cardno",
			"mother_name",
			"husband_name",
			"procode",
			"distcode",
			"tcode",
			"uncode",
			"recno",
		);
		
		if(!isset($columns_valid[$col])) {
			$order = '';
		} elseif($draw == 1) {
			$order = " order by recno".' '.$dir;
		}
		else
		{
			$order = "order by ".$columns_valid[$col].' '.$dir;
		}

		$query = "
		SELECT recno,cardno,mother_name,husband_name,provincename(procode) as province,districtname(distcode) as district,tehsilname(tcode) as tehsil,unname(uncode) as uc from cerv_mother_registration 
		$search $order LIMIT {$length} OFFSET {$start}  ";
		
		$operator = $this->db->query($query);
		$data = array();
		$i=$start+1;
		foreach($operator->result() as $r) 
		{		
			$data[] = array(
			
				"serial" => $i,
				"card_no" => $r->cardno,
				"mother_name" => $r->mother_name,
				"husband_name" => $r->husband_name,
				"procode" => $r->province,
				"distcode" => $r->district,
				"tcode" => $r->tehsil,
				"uncode" => $r->uc,
				"recno" => $r->recno
			);
			$i++;
		}
		$query = "SELECT COUNT(*) AS num FROM cerv_mother_registration";
		$total_mfpdb = $this->db->query($query)->row();
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $total_mfpdb->num,
			"recordsFiltered" => $total_mfpdb->num,
			"data" => $data
		);
		echo json_encode($output);
		exit();
	} 
	
	public function mother_add() {
		$code= $this -> session -> Province; 
		$data['data'] = $data = $this ->Child_list_model ->Mother_add($code);
		$data['fileToLoad'] = 'childs/Mother_add';
		$data['pageTitle'] = 'EPI-MIS | Add Mother Registration Form';
		$this -> load -> view('template/epi_template', $data);
		
	}
	
	public function mother_add_save() {
		//print_r($_POST);exit;
		//live
		//print_r($_POST);exit;
		$reg_facode = $this -> input -> post ('facode');
		$cardno = $this -> input -> post ('cardno');
		//$techniciancode='701049001';
		/*explode for year*/
		/* $dateofbirth = $this -> input -> post ('dateofbirth');
		$explode_date= explode("-",$dateofbirth);
		$year=$explode_date[0]; 
		//$year=$this -> input -> post ('mother_age');
		/*explode for child_registration_no*/
		//$year = date("Y");
		$tt1 = $this -> input -> post ('tt1');
		$explode_date= explode("-",$tt1);
		$year=$explode_date[0];
		$arr = array($reg_facode,$year,$cardno);
		$mother_registration_no=implode("-",$arr);
				$motherData = array(
					'mother_registration_no' => ($mother_registration_no)? $mother_registration_no : Null,
					//'techniciancode' => ($techniciancode)? $techniciancode : Null,
					'year' => ($year)? $year : Null,
					'procode' => ($this -> input -> post ('procode'))? $this -> input -> post ('procode') : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'uncode' => ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null,
					'reg_facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'techniciancode' => ($this -> input -> post ('techniciancode'))? $this -> input -> post ('techniciancode') : Null,
					//'recno' => ($this -> input -> post ('recno'))? $this -> input -> post ('recno') : Null,
					'mother_age' => ($this -> input -> post ('mother_age'))? $this -> input -> post ('mother_age') : Null,
					'cardno' => ($this -> input -> post ('cardno'))? $this -> input -> post ('cardno') : Null,
					'village' => ($this -> input -> post ('address'))? $this -> input -> post ('address') : Null,
					'husband_name' => ($this -> input -> post ('husband_name'))? $this -> input -> post ('husband_name') : Null,
					'mother_name' => ($this -> input -> post ('mother_name'))? $this -> input -> post ('mother_name') : Null,
					'mother_cnic' => ($this -> input -> post ('mother_cnic'))? $this -> input -> post ('mother_cnic') : Null,
					'contactno' => ($this -> input -> post ('contactno'))? $this -> input -> post ('contactno') : Null,
					'house' => ($this -> input -> post ('housestreet'))? $this -> input -> post ('housestreet') : Null,
					'tt1' => ($this -> input -> post ('tt1'))? $this -> input -> post ('tt1') : Null,
					'tt2' => ($this -> input -> post ('tt2'))? $this -> input -> post ('tt2') : Null,
					'tt3' => ($this -> input -> post ('tt3'))? $this -> input -> post ('tt3') : Null,
					'tt4' => ($this -> input -> post ('tt4'))? $this -> input -> post ('tt4') : Null,
					'tt5' => ($this -> input -> post ('tt5'))? $this -> input -> post ('tt5') : Null,
					);
				//echo "<pre>"; print_r($motherData);exit;
			$data = $this -> Child_list_model -> mother_add_save_model($motherData);
			//print_r($data); exit;
	}
	public function mother_edit() {
		//dataEntryValidator(0);
		$recno = $this -> uri -> segment(3);
		$data = $this -> Child_list_model ->Mother_edit($recno);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'childs/Mother_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Mother Registration Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function mother_view($id)
	{
		$data['data']   = $this -> Child_list_model -> mother_view($id);
		$data['fileToLoad'] = 'childs/Mother_view';
		$data['pageTitle'] = 'EPI-MIS | View Mother Registration Form';
		$this -> load -> view('template/epi_template', $data);
	}
	
	public function mother_update() {
	// echo $this -> input -> post ('recno');exit;
		$recno = $this -> input -> post ('recno');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('mother_name',' Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('husband_name',' Father Name','trim|required|alpha_spaces');
		
		if ($this->form_validation->run() === FALSE) 
		{
			if($recno!=''){
				$data = $this -> Child_list_model -> Mother_edit($recno);
				if ($data != 0){
					print_r($data);exit;
					$data['data'] = $data;
					$data['fileToLoad'] = 'childs/Mother_edit';
					$data['pageTitle'] = 'EPI-MIS | Update Mother Registration Form';
					//$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				}else{
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
		}else{
			if($this -> input -> post ('recno')){
				$motherData = array(
					//'mother_registration_no' => ($mother_registration_no)? $mother_registration_no : Null,
					//'techniciancode' => ($techniciancode)? $techniciancode : Null,
					//'year' => ($year)? $year : Null,
					'procode' => ($this -> input -> post ('procode'))? $this -> input -> post ('procode') : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'uncode' => ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null,
					'reg_facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'techniciancode' => ($this -> input -> post ('techniciancode'))? $this -> input -> post ('techniciancode') : Null,
					'recno' => ($this -> input -> post ('recno'))? $this -> input -> post ('recno') : Null,
					'mother_age' => ($this -> input -> post ('mother_age'))? $this -> input -> post ('mother_age') : Null,
					'cardno' => ($this -> input -> post ('cardno'))? $this -> input -> post ('cardno') : Null,
					'village' => ($this -> input -> post ('address'))? $this -> input -> post ('address') : Null,
					'husband_name' => ($this -> input -> post ('husband_name'))? $this -> input -> post ('husband_name') : Null,
					'mother_name' => ($this -> input -> post ('mother_name'))? $this -> input -> post ('mother_name') : Null,
					'mother_cnic' => ($this -> input -> post ('mother_cnic'))? $this -> input -> post ('mother_cnic') : Null,
					'contactno' => ($this -> input -> post ('contactno'))? $this -> input -> post ('contactno') : Null,
					'tt1' => ($this -> input -> post ('tt1'))? $this -> input -> post ('tt1') : Null,
					'tt2' => ($this -> input -> post ('tt2'))? $this -> input -> post ('tt2') : Null,
					'tt3' => ($this -> input -> post ('tt3'))? $this -> input -> post ('tt3') : Null,
					'tt4' => ($this -> input -> post ('tt4'))? $this -> input -> post ('tt4') : Null,
					'tt5' => ($this -> input -> post ('tt5'))? $this -> input -> post ('tt5') : Null
					);
				
				$data = $this -> Child_list_model -> Mother_update($motherData,$recno);
		}
	 }
 }
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}
				else
				{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
			if($data[$key] == NULL || $data[$key]=="0")
				unset($data[$key]);
		}
		return $data;
		}
	}
 
 ?>