<?php
class Custom_Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> helper('customDashboard_helper');
		$this -> load -> model('Common_model','common');
		$this -> load -> model('Customdashboard_model','dashboard');
	}
	
	public function index(){
		$data['data'] = "";
		$where['user'] = $user = $data['user'] = $this -> session -> username;
		$arrayHidids = $this -> common -> fetchall('dashboardhide',NULL,('dashboardinfo_id as hidid'),array('username'=>$user));//echo $this->db->last_query();exit;
		//$arrayHididsvals = implode(',',array_column($arrayHidids,'hidid'));
		$data['userDashboards'] = $this -> dashboard -> getDashboardtList($arrayHidids,'1',$user);
		$data['pageTitle'] = "Your Custom Dashboard";
		$data['fileToLoad'] = "customdashboard/dashboard_list";
		$this -> load -> view('template/epi_template',$data);
	}
	
	public function new_dashboard(){
		$data['data'] = "";
		$data['pageTitle'] = "Your Custom Dashboard";
		$data['fileToLoad'] = "customdashboard/mainview";
		$this -> load -> view('template/epi_template',$data);
	}
	
	public function create_dashboard(){
		$data['name'] = $this -> input -> post('dashboardname');
		$data['access_type'] = $this -> input -> post('dashboardtype');
		$data['user'] = $this -> session -> username;
		$insertedId = $this -> common -> insert_record('dashboardinfo',$data);
		/* $array['private'] = $data['type'];
		$array['username'] = $data['user'];
		$array['level'] = $this -> session -> UserLevel;
		$array['dashboardinfo_id'] = $insertedId;
		$this -> common -> insert_record('dashboard_access',$array); */
		redirect("customdashboard/Custom_Dashboard/open_dashboard/$insertedId");
	}
	
	public function open_dashboard(){
		$data['data'] = "";
		$data['dashboard_id'] = $dashboardId = $this -> uri -> segment(4);
		$data['user'] = $this -> checkCurrentDashboard('dashboardinfo',$dashboardId);
		//select all widgets details and queries against a dashboard id
		$allWidgetsDetail = $this -> dashboard -> getAllSavedWidgetsDetails($dashboardId);
		//send all detail data to function that will return widget graph based on widget type
		$data['display'] = $this -> makeWidgetDisplay($allWidgetsDetail);
		
		
		$data['pageTitle'] = "Your Custom Dashboard";
		$data['fileToLoad'] = "customdashboard/mainview";
		$this -> load -> view('template/epi_template',$data);
	}
	
	public function makeWidgetDisplay($allWidgetsDetail){
		$filterDetailId = 0;
		foreach($allWidgetsDetail as $key => $widget){
			//$dashboardId = $widget['dashboard_id'];
			$widget['user'] = $this -> checkCurrentDashboard('dashboard_widget_detail',$widget['widget_id']);
			$widget['result'] = $this -> db -> query($widget['widget_query']) -> result_array();
			if($widget['multiseries'] == 1 && $widget['noofseries'] > 1){
				$customFilterDetail = $this -> dashboard -> getWidgetFiltersDetail($widget['widget_id']);
				$widgetDetail = $this -> dashboard -> getWidgetDetail($widget['widget_id']);
				$customFilterDetailIDs = array_column($customFilterDetail,'custom_filter_detail_id');
				$customFiltersDetail = $this -> dashboard -> getCustomFiltersDetail($customFilterDetailIDs,array('multiseries'=>1));
				if( ! empty($customFiltersDetail)){
					$filterDetailId = $customFiltersDetail[0]['pk_id'];
					$widget['seriesNames'] = $this -> dashboard -> getFilterSeriesNames($filterDetailId,$widgetDetail['sub_indicator_id']);
				}
			}
			$widgetsDisplay[] = $this -> load -> view('customdashboard/widgetdisplay',$widget,TRUE);
		}//exit;
		return (isset($widgetsDisplay) && ! empty($widgetsDisplay))?$widgetsDisplay:'';
	}
	
	Public function checkCurrentDashboard($tbl,$dashboardId){
		$user = $this -> session -> username;
		$getuserInfo = $this -> common -> fetchall($tbl,NULL,('user'),array('pk_id'=>$dashboardId));
		$cuser = implode('',array_column($getuserInfo,'user'));
		if($user == $cuser)
			return true;
		else
			return false;
	}
}
?>