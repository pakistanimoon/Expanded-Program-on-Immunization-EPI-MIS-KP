<?php
class Customdashboard_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}
	
	public function getDashboardtList($arrayHidids,$Ttype=1,$user) {
		$this -> db -> select('dashinfo.pk_id,dashinfo.name as tittle,dashinfo.user,created_datetime,dashinfo.access_type as type_id,access.name as type');
		$this -> db -> from('dashboardinfo dashinfo');
		$this -> db -> join('access_types access','dashinfo.access_type=access.pk_id','Right');
		if(!empty($user))
			$this -> db -> where('dashinfo.user',$user);
		$this -> db -> or_where('dashinfo.access_type',$Ttype);
		if(!empty($arrayHidids))
			$this -> db -> where("dashinfo.pk_id NOT IN (".implode(',',array_column($arrayHidids,'hidid')).")",NULL,FALSE);
		$this -> db -> order_by('dashinfo.pk_id','asc');
		return $this -> db -> get() -> result_array();
	}
	
	public function getWidgetIndicators($widgetId,$moduleId) {
	    $this -> db -> select('cid.pk_id,cid.name');
		$this -> db -> from('custom_indicators_defination cid');
		$this -> db -> join('widget_indicators wi','wi.indicator_id=cid.pk_id');
		$this -> db -> where('wi.widget_id',$widgetId);
		$this -> db -> where('cid.module_id',$moduleId);
		$this -> db -> where('cid.active',1);
		$this -> db -> order_by('cid.order','asc');
		return $this -> db -> get() -> result_array();
	}
	
	public function getWidgetList($user){
		$this -> db -> select('dashinfo.pk_id,dashinfo.name,dashinfo.user,dashinfo.created_datetime,dashinfo.type');
		$this -> db -> from('dashboardinfo dashinfo');
		$this -> db -> join('dashboard_access dashacc','dashacc.dashboardinfo_id=dashinfo.pk_id');
		$this -> db -> where("username='{$user}' or private='0'");
		return $this -> db -> get() -> result_array();
	}
	
	public function getIndicatorSubIndicators($indicatorId,$moduleId) {
	    $this -> db -> select('pk_id,name');
		$this -> db -> from('sub_indicators');
		$this -> db -> where(array('module_id'=>$moduleId,'indicator_id'=>$indicatorId,'active'=>1));
		$this -> db -> order_by('order','asc');
		return $this -> db -> get() -> result_array();
	}
	
	public function getIndicatorFilters($indicatorId,$subIndicatorId){
		$this -> db -> select('cf.*');
		$this -> db -> from('custom_filters cf');
		$this -> db -> join('indicator_filters indf','indf.filter_id=cf.pk_id');
		$this -> db -> where(array('indf.indicator_id'=>$indicatorId,'indf.sub_indicator_id'=>$subIndicatorId));
		if($this -> session -> UserLevel == '2')
			$this -> db -> where('cf.level2_enabled',1);
		else if($this -> session -> UserLevel == '3')
			$this -> db -> where('cf.level3_enabled',1);
		$this -> db -> where('cf.active',1);
		$this -> db -> order_by('cf.pk_id','asc');
		return $this -> db -> get() -> result_array();
	}
	
	public function saveDashboardNewWidget($data){
		$this -> db -> insert('dashboard_widget_detail',$data);
		return $this -> db -> insert_id();
	}
	
	public function saveWidgetFilters($data){
		$this -> db -> insert('widget_filters',$data);
		return $this -> db -> insert_id();
	}
	
	public function makeNewWidgetQuery($widgetId,$dashboardId,$subindicator){
		//first of all get all details for a saved widget using its id
		$widgetFiltersDetail = $this -> getWidgetFiltersDetail($widgetId);
		$customFilterDetailIds = array_filter(array_column($widgetFiltersDetail,'custom_filter_detail_id'));
		//$customFilterDetailIds = implode(',',$customFilterDetailIds);
		$mainFilterIds = array_column($widgetFiltersDetail,'main_filter_id');
		//$mainFilterIds = implode(',',$mainFilterIds);
		$customFiltersDetails = $this -> getCustomFiltersDetail($customFilterDetailIds);
		$mainFiltersDetails = $this -> mainFiltersDetail($mainFilterIds);
		$select = getQuerySelectColumns($mainFiltersDetails,$customFiltersDetails,$subindicator);
		/* count for the number of series data to make a series in a way that we know if this is a single series or multiseries data */
		$seriesCount = substr_count($select,'value');
		if($seriesCount > 1){
			$widgetData['multiseries'] = 1;
			$widgetData['noofseries'] = $seriesCount;
		}
		$table = getTableNameForSelectedIndicator($subindicator);
		$where = getQueryWhereCondition($mainFiltersDetails,$widgetId);
		$groupby = getQueryGroupByPart($customFiltersDetails,$widgetId);
		/* Get id of group filters which is involve in making data columns */
		$groupFiltersInfoId = getGroupFiltersInfo($mainFiltersDetails,$customFiltersDetails,$subindicator);
		/* check for formula involvement in query if there is any then replace it with a proper formula */
		$select = checkformulainvolvement($select,$groupFiltersInfoId);
		$select = replace_formulastring_withformula($select,$customFiltersDetails,$mainFiltersDetails,$widgetId);
		$this -> db -> select($select);
		$this -> db -> from($table);
		$this -> db -> where($where);
		if( ! empty($groupby)){
			foreach($groupby as $grpby){
				$this -> db -> group_by($grpby,'asc');
			}
		}
		$data['newWidget'] = $this -> db -> get() -> result_array();
		$query = $this -> db -> last_query();
		
		//save query against widget and dashboard id in new table
		$widgetData['dashboard_id'] = $dashboardId;
		$widgetData['widget_id'] = $widgetId;
		$widgetData['widget_query'] = $query;
		$insertedId = $this -> db -> insert('widget_quries',$widgetData);
		if($insertedId > 0){
			return $data;
		}else{
			return 0;
		}
	}
	
	public function getWidgetFiltersDetail($widgetId){
		//fetch all selected filters 
		$this -> db -> select('*');
		$this -> db -> from('widget_filters');
		$this -> db -> where('dashboard_widget_id',$widgetId);
		return $this -> db -> get() -> result_array();
	}
	
	public function getCustomFiltersDetail($customFilterDetailIds,$extraWC=NULL){
		$this -> db -> select('*');
		$this -> db -> from('custom_filters_detail');
		$this -> db -> where_in('pk_id',$customFilterDetailIds);
		if($extraWC){
			$this -> db -> where($extraWC);
		}
		$this -> db -> order_by('grouped_filter','asc');
		$this -> db -> order_by('pk_id','asc');
		return $this -> db -> get() -> result_array();
	}
	
	public function mainFiltersDetail($mainFilterIds){
		$this -> db -> select('*');
		$this -> db -> from('custom_filters');
		$this -> db -> where_in('pk_id',$mainFilterIds);
		return $this -> db -> get() -> result_array();
	}
	
	public function getAllSavedWidgetsDetails($dashboardId){
		$this -> db -> select('a.*,b.widget_id,b.widget_query,b.multiseries,b.noofseries');
		$this -> db -> from('dashboard_widget_detail a');
		$this -> db -> join('widget_quries b','a.pk_id = b.widget_id');
		$this -> db ->order_by('COALESCE(cast(b.order as integer),-1)');
		$this -> db -> where('a.dashboard_id',$dashboardId);
		return $this -> db -> get() -> result_array();
	}
	
	public function deleteDashboardWidget($widgetId){
		$this -> db -> delete('widget_quries',array('widget_id' => $widgetId));
		$this -> db -> delete('widget_filters',array('dashboard_widget_id' => $widgetId));
		$this -> db -> delete('dashboard_widget_detail',array('pk_id' => $widgetId));
	}
	
	public function deleteDashboard($dashboardId){
		/* delete all quries for the dashboard */
		$this->db->trans_start();
		$this -> db -> delete('widget_quries',array('dashboard_id' => $dashboardId));
		/* delete all widgets and their filters but first delete widgets filters so we to get all widgets first */
		$widgets = $this -> getAllWidgetIdsOfDashboard($dashboardId);
		foreach($widgets as $key => $value){
			$widgetIDs[] = $value['pk_id'];
		}
		if( ! empty($widgetIDs)){
			$this -> db -> where_in('dashboard_widget_id',$widgetIDs);
			$this -> db -> delete('widget_filters');
		}
		/* delete all widgets now for the dashboard */
		$this -> db -> delete('dashboard_widget_detail',array('dashboard_id' => $dashboardId));		
		$this -> db -> delete('dashboardinfo',array('pk_id' => $dashboardId));
		$this -> db -> delete('dashboardhide',array('dashboardinfo_id' => $dashboardId));
		$this->db->trans_complete();
	}
	
	public function getAllWidgetIdsOfDashboard($dashboardId){
		$this -> db -> select('pk_id');
		$this -> db -> from('dashboard_widget_detail');
		$this -> db -> where('dashboard_id',$dashboardId);
		return $this -> db -> get() -> result_array();
	}
	
	public function getFilterSeriesNames($filterDetailId, $subIndicatorId){
		$this -> db -> select('series_name,extra_value_divider');
		$this -> db -> from('filter_series_names');
		$this -> db -> where(array('filter_detail_id' => $filterDetailId,'sub_indicator_id' => $subIndicatorId));
		$this -> db -> order_by('order','asc');
		return $this -> db -> get() -> result_array();
	}
	
	public function getWidgetDetail($widgetId){
		$this -> db -> select('*');
		$this -> db -> from('dashboard_widget_detail');
		$this -> db -> where_in('pk_id',$widgetId);
		return $this -> db -> get() -> row_array();
	}
	public function updateWidget($tbl,$col,$wc){
		return $this->db->update($tbl, $col, $wc);
	}
}
?>