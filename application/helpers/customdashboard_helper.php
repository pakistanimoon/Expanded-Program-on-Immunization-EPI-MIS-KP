<?php
/* Custom Dashboard Helper */
if( ! function_exists('getDashboardName')){
	function getDashboardName($dashboardId){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('name');
		$CI -> db -> from('dashboardinfo');
		$CI -> db -> where('pk_id',$dashboardId);
		$result = $CI -> db -> get() -> row();
		return $result -> name;
	}
}
if( ! function_exists('getModulesOptions')){
	function getModulesOptions($return=false,$module=0){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('*');
		$CI -> db -> from('epi_modules');
		$CI -> db -> where('active',1);
		$CI -> db -> order_by('pk_id','asc');
		$result = $CI -> db -> get() -> result_array();
		foreach ($result as $onemod) { 
			$selected = '';
			if(($module > 0) &&($module == $onemod["pk_id"]))
			{
				$selected = 'selected="selected"';
			} 
			$output .= '<option value="'.$onemod["pk_id"].'" '.$selected.' >'.$onemod["name"].'</option>';
		}
		if($return == true)
			return $output;
		echo $output;
	}
}
if( ! function_exists('getAllStandardWidgets')){
	function getAllStandardWidgets($return=false,$widget=0){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('*');
		$CI -> db -> from('widget_type');
		$CI -> db -> where('active',1);
		$CI -> db -> order_by('order','asc');
		$result = $CI -> db -> get() -> result_array();
		foreach ($result as $key => $onewidget) { 
			$selected = '';
			if(($widget > 0 && $widget == $onewidget["pk_id"]) || ($widget == 0 && $key == 0))
			{
				$selected = 'checked';
			}
			$output .= '
						<div class="div-radio">
							<input type="radio" id="widget-'.$onewidget['pk_id'].'" name="widget" class="widget-name" value="'.$onewidget['pk_id'].'" '.$selected.'>
							<label for="widget-'.$onewidget['pk_id'].'">
								<h3><i class="'.$onewidget['class'].'" aria-hidden="true"></i></h3>
								<h5 class="widget-h5">'.$onewidget['name'].'</h5>
							</label>
						</div>
			';
		}
		if($return == true)
			return $output;
		echo $output;
	}
}
if( ! function_exists('getDbFilterDefination')){
	function getDbFilterDefination($return=false,$filterId,$valueColumn,$textColumn){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('*');
		$CI -> db -> from('custom_filters_detail');
		$CI -> db -> where('main_filter_id',$filterId);
		$result = $CI -> db -> get() -> row();
		$CI -> db -> select("{$result->db_columns}");
		$CI -> db -> from("{$result->db_table}");
		if($CI -> session -> UserLevel == '2' && $result -> level2_enabled == 1 && $result -> level2wc_column != '')
			$CI -> db -> where("{$result->level2wc_column}","{$result->level2wc_value}");
		else if($CI -> session -> UserLevel == '3' && $result -> level3_enabled == 1 && $result -> level3wc_column != ''){
			$colval = $result->level3wc_value;
			eval("\$colval = \"$colval\";");
			$CI -> db -> where("{$result->level3wc_column}","{$colval}");
		}
		$dbResult = $CI -> db -> get() -> result_array();
		foreach($dbResult as $key => $value){
			$output .= '<option value="'.$filterId .':-:'. $result->pk_id .':-:'. $value["{$valueColumn}"].'">'.$value["{$textColumn}"].'</option>';
		}
		if($return == true)
			return $output;
		echo $output;
	}
}
if( ! function_exists('getCustomFilterDefination')){
	function getCustomFilterDefination($return=false,$filterId=0){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('*');
		$CI -> db -> from('custom_filters_detail');
		$CI -> db -> where('main_filter_id',$filterId);
		$CI -> db -> order_by('order','desc');
		$result = $CI -> db -> get() -> result_array();
		
		foreach($result as $key => $value){
			if($CI -> session -> UserLevel == '2' && $value['level2_enabled'])
				$output .= '<option value="'.$filterId .':-:'. $value['pk_id'] .':-:'. $value['select_value']. '">'.$value['select_text'].'</option>';
			else if($CI -> session -> UserLevel == '3' && $value['level3_enabled'])
				$output .= '<option value="'.$filterId .':-:'. $value['pk_id'] .':-:'. $value['select_value']. '">'.$value['select_text'].'</option>';
		}
		if($return == true)
			return $output;
		echo $output;
	}
}
if( ! function_exists('filterDetailId')){
	function filterDetailId($filterId){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('pk_id');
		$CI -> db -> from('custom_filters_detail');
		$CI -> db -> where('main_filter_id',$filterId);
		$result = $CI -> db -> get() -> row();
		return $result -> pk_id;
	}
}
if( ! function_exists('getFilterName')){
	function getFilterName($filterId){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('name');
		$CI -> db -> from('custom_filters');
		$CI -> db -> where('pk_id',$filterId);
		$result = $CI -> db -> get() -> row();
		return $result -> name;
	}
}
if( ! function_exists('getFilterTitle')){
	function getFilterTitle($filterId){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('title');
		$CI -> db -> from('custom_filters');
		$CI -> db -> where('pk_id',$filterId);
		$result = $CI -> db -> get() -> row();
		return $result -> title;
	}
}
if( ! function_exists('getFilterDetailValueText')){
	function getFilterDetailValueText($selectedvalue){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('select_text');
		$CI -> db -> from('custom_filters_detail');
		$CI -> db -> where('select_value',$selectedvalue);
		$result = $CI -> db -> get() -> row();
		return (isset($result -> select_text) && $result -> select_text != '')?$result -> select_text:$selectedvalue;
	}
}
if(!function_exists('getTableNameForSelectedIndicator')){
	function getTableNameForSelectedIndicator($subIndicatorId){
		$CI = & get_instance();
		$CI -> db -> select('result_table');
		$CI -> db -> from('sub_indicators');
		$CI -> db -> where('pk_id',$subIndicatorId);
		$result = $CI -> db -> get() -> row();
		return $result -> result_table;
	}
}
if(!function_exists('getQuerySelectColumns')){
	function getQuerySelectColumns($mainFiltersDetails,$customFiltersDetails,$subindicator){
		$CI = & get_instance();
		// select all main filter those are used for query select part
		$like = 'select';
		$result = array_filter($mainFiltersDetails, function ($item) use ($like) {
			if (stripos($item['query_part'], $like) !== false) {
				return true;
			}
			return false;
		});
		//get all ids for select query filters and then search their detail in detail array
		$result = array_column($result,'pk_id');
		foreach($customFiltersDetails as $singleDetail){
			if(in_array($singleDetail['main_filter_id'],$result) == TRUE && $singleDetail['grouped_filter'] > 0){
				$groupedFiltersOnly[] = $singleDetail;
			}
		}
		//concate grouped filters based on grouped_filter id
		$previousGroupedFilterId = NULL;
		$groupedFiltersConcateID = array();
		$i = 0;
		foreach($groupedFiltersOnly as $key => $singleFilterDetail){
			$currentGroupedFilterID = $singleFilterDetail['grouped_filter'];
			if($currentGroupedFilterID == $previousGroupedFilterId){
				//$groupedFiltersConcateID[$i] = $groupedFiltersConcateID[$i].$singleFilterDetail['pk_id'];
				$groupedFiltersConcateID[$i] .= $singleFilterDetail['pk_id'];
			}else{
				$groupedFiltersConcateID[++$i] = $singleFilterDetail['pk_id'];
			}
			$previousGroupedFilterId = $singleFilterDetail['grouped_filter'];
		}
		$CI -> db -> select("string_agg(select_columns,',') as selectcolumns");
		$CI -> db -> where_in('filters_concate_id',$groupedFiltersConcateID);
		$CI -> db -> where('sub_indicator_id',$subindicator);
		$CI -> db -> from('group_filters_info');
		$selectColumns = $CI -> db -> get() -> row();
		return $selectColumns->selectcolumns;
	}
}
if(!function_exists('getGroupFiltersInfo')){
	function getGroupFiltersInfo($mainFiltersDetails,$customFiltersDetails,$subindicator){
		$CI = & get_instance();
		// select all main filter those are used for query select part
		$like = 'select';
		$result = array_filter($mainFiltersDetails, function ($item) use ($like) {
			if (stripos($item['query_part'], $like) !== false) {
				return true;
			}
			return false;
		});
		//get all ids for select query filters and then search their detail in detail array
		$result = array_column($result,'pk_id');
		foreach($customFiltersDetails as $singleDetail){
			if(in_array($singleDetail['main_filter_id'],$result) == TRUE && $singleDetail['grouped_filter'] > 0 && ($singleDetail['groupby_column'] == NULL || $singleDetail['groupby_column'] == '')){
				$groupedFiltersOnly[] = $singleDetail;
			}
		}
		//concate grouped filters based on grouped_filter id
		
		$groupedFiltersConcateID = "";
		$i = 0;
		foreach($groupedFiltersOnly as $key => $singleFilterDetail){
			$groupedFiltersConcateID .= $singleFilterDetail['pk_id'];
		}
		$CI -> db -> select("pk_id");
		$CI -> db -> where('filters_concate_id',$groupedFiltersConcateID);
		$CI -> db -> where('sub_indicator_id',$subindicator);
		$CI -> db -> from('group_filters_info');
		$selectColumns = $CI -> db -> get() -> row();
		return $selectColumns->pk_id;
	}
}
if(!function_exists('checkformulainvolvement')){
	function checkformulainvolvement($select,$groupFilterInfoId){
		$CI = & get_instance();
		$CI -> db -> select('result_format,denominator_formula,multiplier,formula_string');
		$CI -> db -> from('group_filters_info');
		$CI -> db -> where('pk_id',$groupFilterInfoId);
		$result = $CI -> db -> get() -> row();
		$formulaString="";
		if( ! empty($result) && $result -> result_format == 'percentage' && $result -> denominator_formula == 1 && $result -> formula_string != ''){
			$formulaString = $result -> formula_string;
			$select = str_replace(" as value",'*100//'.$formulaString. '::numeric as value',$select);
		}
		return $select;
	}
}
if(!function_exists('replace_formulastring_withformula')){
	function replace_formulastring_withformula($select,$customFiltersDetails,$mainFiltersDetails,$widgetId){
		$CI = & get_instance();
		if(preg_match('(newborn)', $select) === 1) {
			$formula = searchFormulaToReplace('newborn',$customFiltersDetails,$mainFiltersDetails,$widgetId);
			$select = str_replace('newborn',$formula,$select);
		}
		if(preg_match('(survivinginfants)', $select) === 1) {
			$formula = searchFormulaToReplace('survivinginfants',$customFiltersDetails,$mainFiltersDetails,$widgetId);
			$select = str_replace('survivinginfants',$formula,$select);
		}
		if(preg_match('(plw)', $select) === 1) {
			$formula = searchFormulaToReplace('plw',$customFiltersDetails,$mainFiltersDetails,$widgetId);
			$select = str_replace('plw',$formula,$select);
		}
		return $select;
	}
}
if(!function_exists('searchFormulaToReplace')){
	function searchFormulaToReplace($formulaString,$customFiltersDetails,$mainFiltersDetails,$widgetId){
		$CI = & get_instance();
		/* get level */
		$level = getQueryGroupByPart($customFiltersDetails,$widgetId);
		$code = $level[0];
		/* get fmonth filters which will be used in formulas */
		$like = 'fmonth';
		$result = array_filter($mainFiltersDetails, function ($item) use ($like) {
			if (stripos($item['qp_columnname'], $like) !== false) {
				return true;
			}
			return false;
		});
		$mainFiltersIds = array_column($result,'pk_id');
		/* Now get their values against saved widget */
		$filterSelectValues = getWidgetSelectedValues_AgainstMainFilter($widgetId,$mainFiltersIds);
		$fmonths = array_column($filterSelectValues,'filter_select_value');
		/* sort in assending order */
		asort($fmonths);
		$startFmonth = explode('-',$fmonths[0]);
		$endFmonth = explode('-',$fmonths[1]);
		$startYear = $startFmonth[0];
		$startMonth = $startFmonth[1];
		$endYear = $endFmonth[0];
		$endMonth = $endFmonth[1];
		switch($formulaString){
			case 'newborn':
				$formula = "getmonthlytarget_specificyearr($code,$startYear,$startMonth,$endYear,$endMonth)";
				break;
			case 'survivinginfants':
				$formula = "getmonthlytarget_specificyearrsurvivinginfants($code,'',$startYear,$startMonth,$endYear,$endMonth)";
				break;
			case 'plw':
				$formula = "getmonthly_plwomen_target_specificyears($code,$startYear,$startMonth,$endYear,$endMonth)";
				break;
		}
		return $formula;
	}
}
if(!function_exists('getWidgetDetail_AgainstMainFilter')){
	function getWidgetSelectedValues_AgainstMainFilter($widgetId,$mainFilterIDs){
		$CI = & get_instance();
		//fetch all selected filters 
		$CI -> db -> select('filter_select_value');
		$CI -> db -> from('widget_filters');
		$CI -> db -> where(array('dashboard_widget_id'=>$widgetId));
		$CI -> db -> where_in('main_filter_id',$mainFilterIDs);
		$CI -> db -> order_by('main_filter_id','asc');
		return $CI -> db -> get() -> result_array();
	}
}
if(!function_exists('getQueryWhereCondition')){
	function getQueryWhereCondition($mainFiltersDetails,$widgetId){
		// select all main filter those are used for query select part
		$like = 'where';$like1="like";
		$result = array_filter($mainFiltersDetails, function ($item) use ($like,$like1) {
			if (stripos($item['query_part'], $like) !== false || stripos($item['wc_type'], $like1) !== false) {
				return true;
			}
			return false;
		});
		$result = array_sort_func($result, 'wc_type');
		$where = "";
		foreach($result as $key => $whereDetail){
			switch($whereDetail['wc_type']){
				case "between1":
					$where .= "{$whereDetail['qp_columnname']} between '".getValueAgainstFilter($whereDetail['pk_id'],$widgetId)."' and ";
					break;
				case "between2":
					$where .= "'".getValueAgainstFilter($whereDetail['pk_id'],$widgetId)."' and ";
					break;
				case "where":
					$where .= "{$whereDetail['qp_columnname']} = '".getValueAgainstFilter($whereDetail['pk_id'],$widgetId)."' and ";
					break;
				case "like":
					$where .= "{$whereDetail['qp_columnname']} like '".getValueAgainstFilter($whereDetail['pk_id'],$widgetId)."' and ";
					break;
			}
		}
		$where = rtrim($where,'and ');
		return $where;
	}
}
if(!function_exists('getQueryGroupByPart')){
	function getQueryGroupByPart($customFiltersDetails,$widgetId){
		foreach($customFiltersDetails as $key => $val){
			if($val['groupby_column'] != NULL && $val['groupby_column'] != ''){
				$groupby[] = $val['groupby_column'];
			}
		}
		return $groupby;
	}
}
if(!function_exists('array_sort_func')){
	function array_sort_func($array, $on, $order=SORT_ASC){
		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}

			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}

		return $new_array;
	}
}
if(!function_exists('getValueAgainstFilter')){
	function getValueAgainstFilter($customFilterDetailId, $widgetId){
		$CI = & get_instance();
		$CI -> db -> select('filter_select_value');
		$CI -> db -> from('widget_filters');
		$CI -> db -> where(array('main_filter_id'=>$customFilterDetailId,'dashboard_widget_id'=>$widgetId));
		$result = $CI -> db -> get() -> row();
		return $result -> filter_select_value;
	}
}
if( ! function_exists('getWidgetType')){
	function getWidgetType($return=false,$widget){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('name');
		$CI -> db -> from('widget_type');
		$CI -> db -> where('active',1);
		$CI -> db -> where('pk_id',$widget);
		$result = $CI -> db -> get() -> row();
		$output = $result -> name;
		if($return == true)
			return $output;
		echo $output;
	}
}
if( ! function_exists('getSubIndicatorName')){
	function getSubIndicatorName($return=false,$subindicator_id){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('name');
		$CI -> db -> from('sub_indicators');
		$CI -> db -> where('active',1);
		$CI -> db -> where('pk_id',$subindicator_id);
		$result = $CI -> db -> get() -> row();
		$output = $result -> name;
		if($return == true)
			return $output;
		echo $output;
	}
}
if( ! function_exists('getIndicatorName')){
	function getIndicatorName($return=false,$indicator_id){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('name');
		$CI -> db -> from('custom_indicators_defination');
		$CI -> db -> where('active',1);
		$CI -> db -> where('pk_id',$indicator_id);
		$result = $CI -> db -> get() -> row();
		$output = $result -> name;
		if($return == true)
			return $output;
		echo $output;
	}
}
if( ! function_exists('getWidgetSelectedFiltersDetail')){
	function getWidgetSelectedFiltersDetail($return=false,$widget_id){
		$CI = & get_instance();
		$result['widget_id'] = $widget_id;
		$CI -> db -> select('*');
		$CI -> db -> from('widget_filters a');
		$CI -> db -> where('dashboard_widget_id',$widget_id);
		$result['widgetDetail'] = $CI -> db -> get() -> result_array();//echo $CI-> db -> last_query();exit;
		$output = $CI -> load -> view('customdashboard/filters_view',$result,TRUE);
		if($return == true)
			return $output;
		else
			echo $output;
	}
}
if( ! function_exists('getDashboardWidgetDetail')){
	function getDashboardWidgetDetail($filterId){
		$output = "";
		$CI = & get_instance();
		$CI -> db -> select('created_datetime');
		$CI -> db -> from('dashboard_widget_detail');
		$CI -> db -> where('pk_id',$filterId);
		$result = $CI -> db -> get() -> row();
		return $result -> created_datetime;
	}
}
if(!function_exists('getYearsOptions')){
	function getYearsOptions($isreturn=false){		
		$output = "";
		$years=date('Y',strtotime("-1 month"));
		$output = '';
		if($_SESSION["Province"]==3){
			$preyears=2016;
		}
		else{
			$preyears=2018;
		}
		$output .= '<option value="" selected="selected">--Select Year--</option>';
		for($x=$years;$x>=$preyears;$x--){
			$isSelected = (isset($_REQUEST["year"]) && $_REQUEST["year"]==$x)?'selected="selected"':'';
			if(validation_errors() != false) {
				$errorShow = set_select('year',$x); 
			}
			else {
				$errorShow = '';
			}
			$output .= '<option value="'.$x.'" '.$isSelected.' '.$errorShow.'>'.$x.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
/* if( ! function_exists('getWidgetSeriesNames')){
	function getWidgetSeriesNames($return=false,$widget_id){
		$CI = & get_instance();
		$result['widget_id'] = $widget_id;
		$CI -> db -> select('*');
		$CI -> db -> from('widget_filters');
		$CI -> db -> where('dashboard_widget_id',$widget_id);
		$result['widgetDetail'] = $CI -> db -> get() -> result_array();
		if($return == true)
			return $output;
		else
			echo $output;
	}
} */
?>