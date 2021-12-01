<?php
class Dashboard_ajax_calls extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('customDashboard_helper');
		$this -> load -> model('Customdashboard_model','ajax');
		$this -> load -> model('Common_model','common');
	}
	
	public function getWidgetIndicators(){
		$widgetId = $this -> input -> post('widgetId');
		$moduleId = $this -> input -> post('moduleId');
		$result = $this -> ajax -> getWidgetIndicators($widgetId,$moduleId);
		$output = '<option>--Select Indicator to show--</option>';
		foreach ($result as $key => $indicator) {
			if($widgetId =='2' && $indicator['pk_id'] =='8'){}
			else{
				$output .= '<option value="' . $indicator['pk_id'] . '">' . $indicator['name'] . '</option>';
			}
		}
		echo $output;
	}
	
	public function getIndicatorSubIndicators(){
		$indicatorId = $this -> input -> post('indicatorId');
		$moduleId = $this -> input -> post('moduleId');
		$result = $this -> ajax -> getIndicatorSubIndicators($indicatorId,$moduleId);
		$output = '';
		foreach ($result as $key => $subindicator) {
			$output .= '<option value="' . $subindicator['pk_id'] . '">' . $subindicator['name'] . '</option>';
		}
		echo $output;
	}
	
	public function getIndicatorFilters(){
		$indicatorId = $data['indicatorId'] = $this -> input -> post('indicatorId');
		$subIndicatorId = $this -> input -> post('subIndicatorId');
		$data['result'] = $this -> ajax -> getIndicatorFilters($indicatorId,$subIndicatorId);
		echo $this -> load -> view('customdashboard/create_filters',$data,TRUE);
	}
	
	public function saveDashboardNewWidget(){
		$data['widget_title'] = $widget_title = $this -> input -> post('widget_title');
		$data['module_id'] = $module = $this -> input -> post('module');
		$data['widget_type_id'] = $widget = $this -> input -> post('widget');
		$data['indicator_id'] = $indicator = $this -> input -> post('indicator');
		$data['sub_indicator_id'] = $subindicator = $this -> input -> post('subindicator');
		$data['dashboard_id'] = $dashboard_id = $this -> input -> post('dashboard');
		$data['user'] = $username = $this -> session -> username;
		$dashboardWidgetId = $this -> ajax -> saveDashboardNewWidget($data);
		if($this -> input -> post('filter')){
			foreach($this -> input -> post('filter') as $key => $filter){
				$dataFilters['dashboard_widget_id'] = $dashboardWidgetId;
				$filterValueParts = explode(':-:',$filter);
				if(isset($filterValueParts[0]) && $filterValueParts[0] != ''){
					$dataFilters['main_filter_id'] = (isset($filterValueParts[0]) AND $filterValueParts[0] != '')?$filterValueParts[0]:NULL;
					$dataFilters['custom_filter_detail_id'] = (isset($filterValueParts[1]) AND $filterValueParts[1] != '')?$filterValueParts[1]:NULL;
					$dataFilters['filter_select_value'] = (isset($filterValueParts[2]) AND $filterValueParts[2] != '')?$filterValueParts[2]:NULL;
					$this -> ajax -> saveWidgetFilters($dataFilters);
				}
			}
		}
		if($this -> input -> post('inputfilter')){
			foreach($this -> input -> post('inputfilter') as $ikey => $inputfilter){
				$dataInputFilters['dashboard_widget_id'] = $dashboardWidgetId;
				$dataInputFilters['main_filter_id'] = $this -> input -> post('inputfilter')[$ikey];
				$filterName = getFilterName($dataInputFilters['main_filter_id']);
				$dataInputFilters['filter_select_value'] = $this -> input -> post($filterName);
				$this -> ajax -> saveWidgetFilters($dataInputFilters);
			}
		}
		$widgetData = $this -> ajax -> makeNewWidgetQuery($dashboardWidgetId,$dashboard_id,$subindicator);
		print_r($widgetData);
	}
	
	public function deleteDashboardWidget(){
		$widgetId = $this -> input -> post('widgetId');
		$this -> ajax -> deleteDashboardWidget($widgetId);
		echo "success";
	}
	
	public function deleteDashboard(){
		$dashboardId = $this -> input -> post('dashboardId');
		$this -> ajax -> deleteDashboard($dashboardId);
		echo "success";
	}
	public function updateWidgetSort(){
		$dashboard_id = ($this -> input -> post('dashboard_id'))?$this -> input -> post('dashboard_id'):'';
		$arraySort = ($this -> input -> post('arraySort'))?$this -> input -> post('arraySort'):array();
		$table = "widget_quries";
		$return = 'array is empty!';
		foreach(($arraySort) as $key => $val){ // empty array will break the loop
			$col = array('order'=> $key);
			$wc  = array('dashboard_id' => $dashboard_id,'widget_id' => $val);
			if($dashboard_id)
				$return = $this -> ajax -> updateWidget($table,$col,$wc);
		}
		echo $return;
	}
	public function updateListingDashboards(){
		$return = false;
		$col['name'] = ($this -> input -> post('name'))?$this -> input -> post('name'):'Untitled Dashboard';
		$col['access_type'] = $this -> input -> post('type');
		$wc['pk_id'] = $this -> input -> post('dashboard_id');
		$return = $this -> ajax -> updateWidget('dashboardinfo',$col,$wc);
		if($return)
			echo "Dashboard Tittle Updated.";
		else
			echo "Incorrect Data.";
	}
	public function hideDashboard(){
		$inserted_id = 0;
		$data['username'] = $this -> session -> username;
		$data['is_hide'] = 1;
		$data['dashboardinfo_id'] = $this -> input -> post('dashboard_id');
		$inserted_id = $this -> common -> insert_record('dashboardhide',$data);
		if($inserted_id)
			echo "Now Selected Dashboard Not Available For You!";
		else
			echo "Please Check your Functionality.";
	}
}
?>