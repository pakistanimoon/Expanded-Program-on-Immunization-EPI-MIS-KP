<?php
class Ajax extends CI_Controller {
	
	public function __construct() {
		parent::__construct();		
	}
	
	public function completenessTimelinessColumn2D(){
		$result['fweek'] = $fweek = $this -> input -> get('fweek');
		$result = districtWiseCommulativeTimelinessAndCompletenessForaWeek($fweek);
		foreach($result as $key => $value){
			$categories[]['label'] = $value['district'];
			$timeliness[]['value'] = $value['commulative_timeliness'];
			$completeness[]['value'] = $value['commulative_completeness'];
		}
		$data['caption'] = "Comparison of Timeliness and Completeness for all Districts";
		$data['xAxisname'] = "Districts";
		$data['yAxisName'] = "Percentage";
		$data['numberPrefix'] = "";
		$data['paletteColors'] = "#0075c2,#1aaf5d";
		$data['trendlines'] = true;
		$data['trendlines_displayvalue'] = "80% benchmark";
		$data['trendlines_tooltext'] = "Completeness & Timeliness Benchmark";
		$data['categories'] = json_encode($categories);
		$data['serieses'][0]['seriesname'] = "Completeness";
		$data['serieses'][0]['data'] = json_encode($completeness);
		$data['serieses'][1]['seriesname'] = "Timeliness";
		$data['serieses'][1]['data'] = json_encode($timeliness);
		echo $this -> load -> view('graphs/mscolumn2d',$data,TRUE);
	}
	/* public function weekWiseComparisonOfCompletenessTimelinessMsLine2D(){
		$fweek = $this -> input -> get('fweek');
		echo $this -> load -> view('graphs/msline2d',NULL,TRUE);
	} */
	public function ageWiseDistributionOfLabConfirmedCases(){
		$result['fweek'] = $fweek = $this -> input -> get('fweek');
		$result = $this -> bulletin -> ageWiseDistributionOfLabConfirmedCases($fweek);
		$seriese[0]['label'] = "Below 9 Months";
		$seriese[0]['value'] = $result -> below9monthsperc;
		$seriese[1]['label'] = "9-23M";
		$seriese[1]['value'] = $result -> months9to23perc;
		$seriese[2]['label'] = "24-59M";
		$seriese[2]['value'] = $result -> month24to59perc;
		$seriese[3]['label'] = "60-119M";
		$seriese[3]['value'] = $result -> months60to119perc;
		$seriese[4]['label'] = ">120M";
		$seriese[4]['value'] = $result -> greaterthan120monthsperc;
		$seriese[5]['label'] = "Dont Know";
		$seriese[5]['value'] = $result -> dontknowperc;
		$data['caption'] = "Age Wise Distribution of Lab Confirmed Cases";
		$data['subCaption'] = "";
		$data['xAxisName'] = "Age Distribution";
		$data['yAxisName'] = "Percentage";
		$data['numberPrefix'] = "%";
		$data['seriese'] = json_encode($seriese);
		echo $this -> load -> view('graphs/column2d',$data,TRUE);
	}
	public function measlesSuspectedCasesWithLabResultsAgeWiseCount(){
		$result['fweek'] = $fweek = $this -> input -> get('fweek');
		$categories[0]['label'] = "Below 9 Months";
		$categories[1]['label'] = "9-23M";
		$categories[2]['label'] = "24-59M";
		$categories[3]['label'] = "60-119M";
		$categories[4]['label'] = ">120M";
		$categories[5]['label'] = "Dont Know";
		
		$result = $this -> bulletin -> ageWiseDistributionOfSuspectedAndLabResultCases($fweek);
		
		$suspectedCases[0]['value'] = $result['below9monthssc'];
		$suspectedCases[1]['value'] = $result['months9to23sc'];
		$suspectedCases[2]['value'] = $result['month24to59sc'];
		$suspectedCases[3]['value'] = $result['months60to119sc'];
		$suspectedCases[4]['value'] = $result['greaterthan120monthssc'];
		$suspectedCases[5]['value'] = $result['dontknowsc'];
		
		$positiveMeasles[0]['value'] = $result['below9monthspm'];
		$positiveMeasles[1]['value'] = $result['months9to23pm'];
		$positiveMeasles[2]['value'] = $result['month24to59pm'];
		$positiveMeasles[3]['value'] = $result['months60to119pm'];
		$positiveMeasles[4]['value'] = $result['greaterthan120monthspm'];
		$positiveMeasles[5]['value'] = $result['dontknowpm'];
		
		$positiveRubella[0]['value'] = $result['below9monthspr'];
		$positiveRubella[1]['value'] = $result['months9to23pr'];
		$positiveRubella[2]['value'] = $result['month24to59pr'];
		$positiveRubella[3]['value'] = $result['months60to119pr'];
		$positiveRubella[4]['value'] = $result['greaterthan120monthspr'];
		$positiveRubella[5]['value'] = $result['dontknowpr'];
		
		$data['caption'] = "Age Group wise count of Suspected Measles, Positive Measles and Rubella Cases";
		$data['xAxisname'] = "Age Distribution";
		$data['yAxisName'] = "Percentage";
		$data['numberPrefix'] = "";
		$data['paletteColors'] = "#e44a00,#6baa01,#9b59b6";
		$data['trendlines'] = false;
		$data['categories'] = json_encode($categories);
		$data['serieses'][0]['seriesname'] = "Suspected Cases Send to Lab";
		$data['serieses'][0]['data'] = json_encode($suspectedCases);
		$data['serieses'][1]['seriesname'] = "Positive Measles";
		$data['serieses'][1]['data'] = json_encode($positiveMeasles);
		$data['serieses'][2]['seriesname'] = "Positive Rubella";
		$data['serieses'][2]['data'] = json_encode($positiveRubella);
		echo $this -> load -> view('graphs/mscolumn2d',$data,TRUE);
	}
	public function measlesCasesReceivedDoseWiseCount(){
		$result['fweek'] = $fweek = $this -> input -> get('fweek');
		$result = $this -> bulletin -> measlesCasesReceivedDoseWiseCount($fweek);
		foreach($result as $key => $value){
			$seriese[$key]['label'] = "{$value['doses_received']} Dose";
			$seriese[$key]['value'] = $value['cnt'];
		}
		$data['caption'] = "Measles Cases Received Doses Wise Count";
		$data['subCaption'] = "";
		$data['numberPrefix'] = "";
		$data['defaultCenterLabel'] = "Doses Count";
		$data['paletteColors'] = "#e44a00,#6baa01,#9b59b6";
		$data['seriese'] = json_encode($seriese);
		echo $this -> load -> view('graphs/doughnut2d',$data,TRUE);
	}
}
?>