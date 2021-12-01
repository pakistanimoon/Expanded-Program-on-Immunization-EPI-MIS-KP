<?php
class DaywiseChildreport_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	public function DaywiseChild_report($data){

	if(isset($data['fmonth']) && $data['fmonth'] != ''){
		$fmonth=$this->input->post_get('fmonth');
	}else{
		$transdate = date('Y-m');
		
		$fmonth= $transdate;
	} 
		$procode=$this->session->Province;
		$distcode=$this->session->District;
		if($distcode == ''){
			$wc="procode='".$procode."' ";
		}else{
			$wc="procode='".$procode."' and distcode='".$distcode."'";
		}
		$yearmonth = explode("-",$fmonth);
		$month = $yearmonth[1];
		$data['currentday'] = date('t',strtotime($fmonth));
		//echo $data['currentday'];
		////////start here///////
		$child_vaccine='';
		for($days=01; $days<=$data['currentday']; $days++){
			$child_vaccine.=" 
				(select count(nameofchild) 
						from cerv_child_registration 
							where techniciancode=techniciandb.techniciancode and deleted_at IS NULL and
								(bcg='".$fmonth."-".$days."' OR hepb='".$fmonth."-".$days."' 
								OR opv0='".$fmonth."-".$days."' OR opv1='".$fmonth."-".$days."' 
								OR opv2='".$fmonth."-".$days."'  OR opv3='".$fmonth."-".$days."' OR penta1='".$fmonth."-".$days."'
								OR rota1='".$fmonth."-".$days."' OR pcv1='".$fmonth."-".$days."' OR penta2='".$fmonth."-".$days."'
								OR rota2='".$fmonth."-".$days."' OR pcv2='".$fmonth."-".$days."' OR penta3='".$fmonth."-".$days."'
								OR pcv3='".$fmonth."-".$days."' OR ipv='".$fmonth."-".$days."' OR measles1='".$fmonth."-".$days."'
								OR measles2='".$fmonth."-".$days."'))
				
				 as child".$days.",";
		}
		$mother_vaccine='';
			for($days=01; $days<=$data['currentday']; $days++){
				$mother_vaccine.=" 
				(select count(mother_name) 
						from cerv_mother_registration 
							where techniciancode=techniciandb.techniciancode and 
									(tt1='".$fmonth."-".$days."' OR tt2='".$fmonth."-".$days."' 
									OR tt3='".$fmonth."-".$days."' OR tt4='".$fmonth."-".$days."' OR tt5='".$fmonth."-".$days."') 
				)
				 as mother".$days.",";
			}
		$mother_vaccine= rtrim($mother_vaccine,','); 
				
		$query="
				select techniciancode,technicianname(techniciancode),
				 ".$child_vaccine."
				 ".$mother_vaccine."
					from techniciandb where ".$wc." and techniciancode in ('701049001','702003001','702004001','702009003','702009004','702010001','702013001','702013002') order by techniciancode ASC";
		$result = $this -> db -> query($query) -> result_array();
		$subTitle = "Days Wise  Report";
		$data['subtitle'] = $subTitle;
		$data['fmonth'] = $fmonth;
		$data['TopInfo'] = reportsTopInfo($subTitle, $data);
		$data['childDataview'] = $result ;
		 return $data;
		
		
	}
}
?>