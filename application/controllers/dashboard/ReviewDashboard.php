<?php
class ReviewDashboard extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('dashboard/Reviewdashboard_model','review');
	}
	
	public function index()
	{
		/* Get Request Filters */
		$data['period'] = $filters['period'] = $this -> input -> get('filter')?$this -> input -> get('filter'):'yearly';
		switch($data['period']){
			case 'yearly':
				$data['year'] = $filters['year'] = $this -> input -> get('year')?$this -> input -> get('year'):date('Y',strtotime("first day of previous month"));
				break;
			case 'biyearly':
				$data['year'] = $filters['year'] = $this -> input -> get('year')?$this -> input -> get('year'):date('Y',strtotime("first day of previous month"));
				$data['biyear'] = $filters['biyear'] = $this -> input -> get('biyear')?$this -> input -> get('biyear'):currentYearHalf(date('m',strtotime("first day of previous month")));
				break;
			case 'quarterly':
				$data['year'] = $filters['year'] = $this -> input -> get('year')?$this -> input -> get('year'):date('Y',strtotime("first day of previous month"));
				$data['quarter'] = $filters['quarter'] = $this -> input -> get('quarter')?$this -> input -> get('quarter'):getQuater(date('m',strtotime("first day of previous month")));
				break;
			case 'monthly':
				$data['year'] = $filters['year'] = $this -> input -> get('year')?$this -> input -> get('year'):date('Y',strtotime("first day of previous month"));
				$data['month'] = $filters['month'] = $this -> input -> get('month')?$this -> input -> get('month'):date('m',strtotime("first day of previous month"));
				break;
			default:
				$data['year'] = $filters['year'] = $this -> input -> get('year')?$this -> input -> get('year'):date('Y',strtotime("first day of previous month"));
				break;
		}
		///for selected time period of filter
		switch($data['period']){
			case 'yearly':
				$date=$data['year'];
				break;
			case 'biyearly':
				$date=$data['year'].($data['biyear']== 1 ? ' - First Half' :' - Second Half');
				break;
			case 'quarterly':
				if($data['quarter']== 1){
					$quarter=' - Quarter 1st';
				}elseif($data['quarter']== 2){
					$quarter=' - Quarter 2nd';
				}elseif($data['quarter']== 3){
					$quarter=' - Quarter 3rd';
				}else{
					$quarter=' - Quarter 4th';
				}
				$date=$data['year'].$quarter;
				break;
			case 'monthly':
				$date=$data['year'].' - '.monthname($data['month']);
				break;
			default:
				$date=$data['year'];
				break;
		}
		///
		/*For function return values in variable to avoid reuseablility By USAMA SHER KAHN */
			$compliance_sub=$this -> complianceCount('sub',$filters);
			$compliance_due=$this -> complianceCount('due',$filters);
			$consumption_sub=$this -> complianceCount('sub',$filters,'consumptioncompliance c');
			$consumption_due=$this -> complianceCount('due',$filters,'consumptioncompliance c');
			$weeklycompliance_sub=$this -> WeeklyComplianceCount('sub',$filters,'zeroreportcompliance c');
			$weeklycompliance_due=$this -> WeeklyComplianceCount('due',$filters,'zeroreportcompliance c');
		/* Active Indicator to search for */
		$data['indicatorkey'] = $indicatorid = $filters['indicatorid'] = ($this -> input -> get('indicatorid'))?$this -> input -> get('indicatorid'):'compliances';
		$data['subindicatorkey'] = $subindicatorId = ($this -> input -> get('subindicatorid'))?$this -> input -> get('subindicatorid'):false;
		/* Left Cards Information */
		$data['leftCardsMainArray'] = array(
			'compliances' => array(
								'id' => 'compliances',
								'isactive' => ($indicatorid && $indicatorid == 'compliances')?true:false,
								'viewMainHeading' => 'Coverage Compliance data ,'.$date.'',
								'topheading' => 'Compliance',
								'bottomheading' => 'Coverage',
								'carousel' => true,
								'carouselarray' => array(
															'consumption' => array(
																	'id'=>'consumption',
																	'name'=>'Consumption',
																	'viewMainHeading' => 'Consumption Compliance data ,'.$date.'',
																	'value'=>round($consumption_sub/$consumption_due*100),
																	'topcards' => ($indicatorid == 'compliances' && $subindicatorId == 'consumption')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Due Reports','leftvalue'=>$consumption_due, 'leftvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Submitted Reports','leftvalue'=>$consumption_sub, 'leftvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Timeliness','leftvalue'=>$this -> complianceCount('tsub',$filters,'consumptioncompliance c')/$consumption_due*100, 'leftvaluetype' => 'percentage'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Completeness','leftvalue'=>$consumption_sub/$consumption_due*100, 'leftvaluetype' => 'percentage')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'compliances' && $subindicatorId == 'consumption')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"compliances","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> complianceCount('due',$filters,'consumptioncompliance c',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Consumption Compliance Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'compliances' && $subindicatorId == 'consumption')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"compliances","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> complianceCount('due',$filters,'consumptioncompliance c',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> complianceCount('due',$filters,'consumptioncompliance c',true,true,true).']',
																					'heading' => array('barName' => 'Consumption Compliance wise Ranking','subtittle' => $date)
																				):false
																),
															'zeroreport' => array(
																	'id'=>'zeroreport',
																	'name'=>'Zero Report',
																	'viewMainHeading' => 'Zero Report Compliance data ,'.$date.'',
																	//'value'=>rand(40,100),
																	'value'=>round($weeklycompliance_sub/$weeklycompliance_due*100),
																	'topcards' => ($indicatorid == 'compliances' && $subindicatorId == 'zeroreport')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Due Reports','leftvalue'=>$weeklycompliance_due, 'leftvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Submitted Reports','leftvalue'=>$weeklycompliance_sub, 'leftvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Timeliness','leftvalue'=>$this -> WeeklyComplianceCount('tsub',$filters,'zeroreportcompliance c')/$this -> WeeklyComplianceCount('due',$filters,'zeroreportcompliance c')*100, 'leftvaluetype' => 'percentage'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Completeness','leftvalue'=>$weeklycompliance_sub/$weeklycompliance_due*100, 'leftvaluetype' => 'percentage')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'compliances' && $subindicatorId == 'zeroreport')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"compliances","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> WeeklyComplianceCount('due',$filters,'zeroreportcompliance c',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Zero Report Compliance Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'compliances' && $subindicatorId == 'zeroreport')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"compliances","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> WeeklyComplianceCount('due',$filters,'zeroreportcompliance c',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> WeeklyComplianceCount('due',$filters,'zeroreportcompliance c',true,true,true).']',
																					'heading' => array('barName' => 'Zero Report Compliance wise Ranking','subtittle' => $date)
																				):false
																),
														),
								//'value' => round($this -> complianceCount('sub',$filters)/$this -> complianceCount('due',$filters)*100),
								'value' => round($compliance_sub/$compliance_due*100),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'compliances' && $subindicatorId == false)?array(
									array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Due Reports','leftvalue'=>$this -> complianceCount('due',$filters,'vaccinationcompliance c'), 'leftvaluetype' => 'number'),
									array('cardicon'=>'woman.svg','leftinfo'=>'Submitted Reports','leftvalue'=>$compliance_sub, 'leftvaluetype' => 'number'),
									array('cardicon'=>'target.svg','leftinfo'=>'Timeliness','leftvalue'=>$this -> complianceCount('tsub',$filters)/$compliance_due*100, 'leftvaluetype' => 'percentage'),
									array('cardicon'=>'target.svg','leftinfo'=>'Completeness','leftvalue'=>$compliance_sub/$compliance_due*100, 'leftvaluetype' => 'percentage')
								):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'compliances' && $subindicatorId == false)?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"compliances","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> complianceCount('due',$filters,'vaccinationcompliance c',true).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'heading' => array('mapName' => 'Coverage Compliance Thematic Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'compliances' && $subindicatorId == false)?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":"compliances","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> complianceCount('due',$filters,'vaccinationcompliance c',true,true).'}]',
												'serieses_ranking_cat' => '['.$this -> complianceCount('due',$filters,'vaccinationcompliance c',true,true,true).']',
												'heading' => array('barName' => 'Coverage Compliance wise Ranking','subtittle' => $date)
											):false
			),
			'coverages' => array(
								'id' => 'coverages',
								'isactive' => ($indicatorid && $indicatorid == 'coverages')?true:false,
								'topheading' => 'Coverage',
								'bottomheading' => 'Penta-3',
								'carousel' => true,
								'carouselarray' => array(
															'bcg' => array(
																'id'=>'bcg',
																'name'=>'BCG',
																'viewMainHeading' => 'BCG Coverage ,'.$date.'',
																'value'=>$this -> coverageData(1,$filters,'newborn','3','province'),
																'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'bcg')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(1,$filters,'maletarger_newborn','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(1,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(1,$filters,'femaletarger_newborn','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(1,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(1,$filters,'totaltarger_newborn','3','province'), 'leftvaluetype' => 'number')
																	):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'coverages' && $subindicatorId == 'bcg')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(1,$filters,'malevacination_newborn','3','province',true).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'BCG Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'bcg')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(1,$filters,'malevacination_newborn','3','province',true,true).'}]',
																				'serieses_ranking_cat' => '['.$this -> coverageData(1,$filters,'malevacination_newborn','3','province',true,true,true).']',
																				'heading' => array('barName' => 'BCG Coverage wise Ranking','subtittle' => $date)
																			):false
															),
															'hepb' =>array(
																	'id'=>'hepb',
																	'name'=>'HEP-B',
																	'viewMainHeading' => 'HEP-B Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(2,$filters,'newborn','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'hepb')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(2,$filters,'maletarger_newborn','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(2,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(2,$filters,'femaletarger_newborn','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(2,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(2,$filters,'totaltarger_newborn','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'hepb')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(2,$filters,'malevacination_newborn','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'HEP-B Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'hepb')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(2,$filters,'malevacination_newborn','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(2,$filters,'malevacination_newborn','3','province',true,true,true).']',
																					'heading' => array('barName' => 'HEP-B Coverage wise Ranking','subtittle' => $date)
																				):false
																),
															'opv0' =>array(
																	'id'=>'opv0',
																	'name'=>'OPV-0',
																	'viewMainHeading' => 'OPV-0 Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(3,$filters,'newborn','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'opv0')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(3,$filters,'maletarger_newborn','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(3,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(3,$filters,'femaletarger_newborn','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(3,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(3,$filters,'totaltarger_newborn','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'opv0')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(3,$filters,'malevacination_newborn','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'OPV-0 Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'opv0')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(3,$filters,'malevacination_newborn','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(3,$filters,'malevacination_newborn','3','province',true,true,true).']',
																					'heading' => array('barName' => 'OPV-0 Coverage wise Ranking','subtittle' => $date)
																				):false
																		
																),
															'opv1' =>array(
																	'id'=>'opv1',
																	'name'=>'OPV-I',
																	'viewMainHeading' => 'OPV-I Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(4,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'opv1')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(4,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(4,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(4,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(4,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(4,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'opv1')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(4,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'OPV-I Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'opv1')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(4,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(4,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'OPV-I Coverage wise Ranking','subtittle' => $date)
																				):false
																),
															'opv2' =>array(
																	'id'=>'opv2',
																	'name'=>'OPV-II',
																	'viewMainHeading' => 'OPV-II Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(5,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'opv2')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(5,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(5,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(5,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(5,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(5,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'opv2')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(5,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'OPV-II Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'opv2')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(5,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(5,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'OPV-II Coverage wise Ranking','subtittle' => $date)
																				):false
																),
															'opv3' =>array(
																	'id'=>'opv3',
																	'name'=>'OPV-III',
																	'viewMainHeading' => 'OPV-III Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(6,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'opv3')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(6,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(6,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(6,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(6,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(6,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'opv3')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(6,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'OPV-III Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'opv3')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(6,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(6,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'OPV-III Coverage wise Ranking','subtittle' => $date)
																				):false
																),
															'penta1' =>array(
																	'id'=>'penta1',
																	'name'=>'Penta-I',
																	'viewMainHeading' => 'Penta-I Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(7,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'penta1')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(7,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(7,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(7,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(7,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(7,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'penta1')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(7,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Penta-I Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'penta1')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(7,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(7,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'Penta-I Coverage wise Ranking','subtittle' => $date)
																				):false
																),
															'penta2' =>array(
																	'id'=>'penta2',
																	'name'=>'Penta-II',
																	'viewMainHeading' => 'Penta-II Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(8,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'penta2')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(8,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(8,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(8,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(8,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(8,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'penta2')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(8,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Penta-II Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'penta2')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(8,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(8,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'Penta-II Coverage wise Ranking','subtittle' => $date)
																				):false
																	
																),
															'penta3' =>array(
																	'id'=>'penta3',
																	'name'=>'Penta-III',
																	'viewMainHeading' => 'Penta-III Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(9,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'penta3')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(9,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(9,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(9,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(9,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(9,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'penta3')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(9,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Penta-III Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'penta3')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(9,$filters,'femalevacination_survivinginfants','3','province',true,true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(9,$filters,'femalevacination_survivinginfants','3','province',true,true).']',
																					'heading' => array('barName' => 'Penta-III Coverage wise Ranking','subtittle' => $date)
																				):false
																	
																),
															'pcv101' =>array(
																	'id'=>'pcv101',
																	'name'=>'PCV10-I',
																	'viewMainHeading' => 'PCV10-I Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(10,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'pcv101')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(10,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(10,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(10,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(10,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(10,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'pcv101')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(10,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'PCV10-I Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'pcv101')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(10,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(10,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'PCV10-I Coverage wise Ranking','subtittle' => $date)
																				):false
																),
															'pcv102' =>array(
																	'id'=>'pcv102',
																	'name'=>'PCV10-II',
																	'viewMainHeading' => 'PCV10-II Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(11,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'pcv102')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(11,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(11,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(11,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(11,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(11,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'pcv102')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(11,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'PCV10-II Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'pcv102')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(11,$filters,'femalevacination_survivinginfants','3','province',true,true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(11,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'PCV10-II Coverage wise Ranking','subtittle' => $date)
																				):false
																),
															'pcv103' =>array(
																	'id'=>'pcv103',
																	'name'=>'PCV10-III',
																	'viewMainHeading' => 'PCV10-III Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(12,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'pcv103')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(12,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(12,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(12,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(12,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(12,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'pcv103')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(12,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'PCV10-III Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'pcv103')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(12,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(12,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'PCV10-III Coverage wise Ranking','subtittle' => $date)
																				):false
																	
																),
															'ipv' =>array(
																	'id'=>'ipv',
																	'name'=>'IPV',
																	'viewMainHeading' => 'IPV Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(13,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'ipv')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(13,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(13,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(13,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(13,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(13,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'ipv')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(13,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'IPV Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'ipv')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(13,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(13,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'IPV Coverage wise Ranking','subtittle' => $date)
																				):false
																),
															'rota1' =>array(
																	'id'=>'rota1',
																	'name'=>'Rota-I',
																	'viewMainHeading' => 'Rota-I Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(14,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'rota1')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(14,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(14,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(14,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(14,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(14,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'rota1')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(14,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Rota-I Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'rota1')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(14,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(14,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'Rota-I Coverage wise Ranking','subtittle' => $date)
																	            ):false
																	
																),
															'rota2' =>array(
																	'id'=>'rota2',
																	'name'=>'Rota-II',
																	'viewMainHeading' => 'Rota-II Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(15,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'rota2')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(15,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(15,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(15,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(15,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(15,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'rota2')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(15,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Rota-II Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'rota2')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(15,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(15,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'Rota-II Coverage wise Ranking','subtittle' => $date)
																	            ):false
																	
																),
															'measles1' =>array(
																	'id'=>'measles1',
																	'name'=>'Measles-I',
																	'viewMainHeading' => 'Measles-I Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(16,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'measles1')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(16,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(16,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(16,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(16,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(16,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'measles1')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(16,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Measles-I Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'measles1')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(16,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(16,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'Measles-I Coverage wise Ranking','subtittle' => $date)
																	            ):false
																	),
															'fullyimmunized' =>array(
																	'id'=>'fullyimmunized',
																	'name'=>'Fully Immunized',
																	'viewMainHeading' => 'Fully Immunized Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(17,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'fullyimmunized')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(17,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(17,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(17,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(17,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(17,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'fullyimmunized')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(17,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Fully Immunized Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'fullyimmunized')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(17,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(17,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'Fully Immunized Coverage wise Ranking','subtittle' => $date)
																	            ):false
																	
																),
															'measles2' =>array(
																	'id'=>'measles2',
																	'name'=>'Measles-II',
																	'viewMainHeading' => 'Measles-II Coverage ,'.$date.'',
																	'value'=>$this -> coverageData(18,$filters,'survivinginfants','3','province'),
																	'topcards' => ($indicatorid == 'coverages' && $subindicatorId == 'measles2')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(18,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(18,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(18,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(18,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(18,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
																	/* Map Data for the indicator if the indicator is active */
																	'map' => ($indicatorid == 'coverages' && $subindicatorId == 'measles2')?array(
																					'id' => 'thematic-map',
																					'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(18,$filters,'malevacination_survivinginfants','3','province',true).'}]',
																					'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																					'heading' => array('mapName' => 'Penta-III Coverage Thematic Map','subtittle' => $date,'run' => 'New Run')
																				):false,
																	/* Ranking Data for the indicator if the indicator is active */
																	'ranking' => ($indicatorid == 'coverages' && $subindicatorId == 'measles2')?array(
																					'id' => 'ranking-bar',
																					'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(18,$filters,'femalevacination_survivinginfants','3','province',true,true).'}]',
																					'serieses_ranking_cat' => '['.$this -> coverageData(18,$filters,'femalevacination_survivinginfants','3','province',true,true,true).']',
																					'heading' => array('barName' => 'Penta-III Coverage wise Ranking','subtittle' => $date)
																	            ):false
																)
														),
													'value' => $this -> coverageData(9,$filters,'survivinginfants','3','province'),
													
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'coverages')?array(
																		array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Male Target','leftvalue'=>$this -> coverageData(9,$filters,'maletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Male Vaccination','rightvalue'=>$this -> coverageData(9,$filters,'malevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'woman.svg','leftinfo'=>'Female Target','leftvalue'=>$this -> coverageData(9,$filters,'femaletarger_survivinginfants','3','province'), 'leftvaluetype' => 'number','rightinfo'=>'Female Vaccination','rightvalue'=>$this -> coverageData(9,$filters,'femalevacination_newborn','3','province'), 'rightvaluetype' => 'number'),
																		array('cardicon'=>'target.svg','leftinfo'=>'Total Target','leftvalue'=>$this -> coverageData(9,$filters,'totaltarger_survivinginfants','3','province'), 'leftvaluetype' => 'number')
																	):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'coverages')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(9,$filters,'malevacination_survivinginfants','3','province',true).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'heading' => array('mapName' => 'Measle Coverage wise Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'coverages')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> coverageData(9,$filters,'malevacination_survivinginfants','3','province',true,true).'}]',
												'serieses_ranking_cat' => '['.$this -> coverageData(9,$filters,'malevacination_survivinginfants','3','province',true,true,true).']',
												'heading' => array('barName' => 'Measle Coverage wise Ranking','subtittle' => $date)
											):false
			),
			'openvialwastage' => array(
								'id' => 'openvialwastage',
								'isactive' => ($indicatorid && $indicatorid == 'openvialwastage')?true:false,
								'topheading' => 'Open Vial Wastage',
								'bottomheading' => 'Measles',
								'carousel' => true,
								'carouselarray' => array(
															'bcg20' =>array(
																			'id'=>'bcg20',
																			'name'=>'BCG-20',
																			'viewMainHeading' => 'BCG-20 Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(5,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'bcg20')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(5,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(5,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(5,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'bcg20')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(5,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":30,"color":"#0B7546","name":"0-30%"},{"from":31,"to":40,"color":"#3366ff","name":"31-40%"},{"from":41,"to":50,"color":"#EBB035","name":"41-50%"},{"from":50,"to":1000,"color":"#DD1E2F","name":">50%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":30,"color":"#0B7546","name":"0-30%"},{"from":31,"to":40,"color":"#3366ff","name":"31-40%"},{"from":41,"to":50,"color":"#EBB035","name":"41-50%"},{"from":50,"to":1000,"color":"#DD1E2F","name":">50%"}]}',
																									'heading' => array('mapName' => 'BCG-20 Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'bcg20')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(5,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(5,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'BCG-20 Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'bOPV' =>array(
																			'id'=>'bOPV',
																			'name'=>'bOPV',
																			'viewMainHeading' => 'bOPV Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(2,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'bOPV')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(2,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(2,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(2,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'bOPV')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(2,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																									'heading' => array('mapName' => 'bOPV Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'bOPV')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(2,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(2,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'bOPV Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'penta1' =>array(
																			'id'=>'penta1',
																			'name'=>'Pentavalent-1',
																			'viewMainHeading' => 'Pentavalent-1 Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(7,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'penta1')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(7,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(7,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(7,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'penta1')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(7,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":5,"to":100,"color":"#DD1E2F","name":">5%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":5,"to":100,"color":"#DD1E2F","name":">5%"}]}',
																									'heading' => array('mapName' => 'Pentavalent-1 Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'penta1')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(7,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(7,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'Pentavalent-1 Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'pvc10-2' =>array(
																			'id'=>'pvc10-2',
																			'name'=>'Pneumococcal-2 (PCV10)',
																			'viewMainHeading' => 'Pneumococcal-2 (PCV10) Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(8,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'pvc10-2')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(8,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(8,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(8,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'pvc10-2')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(8,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":100,"color":"#DD1E2F","name":">10%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":100,"color":"#DD1E2F","name":">10%"}]}',
																									'heading' => array('mapName' => 'Pneumococcal-2 (PCV10) Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'pvc10-2')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(8,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(8,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'Pneumococcal-2 (PCV10) Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'pvc10-4' =>array(
																			'id'=>'pvc10-4',
																			'name'=>'Pneumococcal-4 (PCV10)',
																			'viewMainHeading' => 'Pneumococcal-4 (PCV10) Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(90,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'pvc10-4')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(90,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(90,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(90,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active  */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'pvc10-4')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(90,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">30%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">30%"}]}',
																									'heading' => array('mapName' => 'Pneumococcal-4 (PCV10) Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'pvc10-4')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(90,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(90,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'Pneumococcal-4 (PCV10) Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'measles'=> array(
																			'id'=>'measles',
																			'name'=>'Measles-10',
																			'viewMainHeading' => 'Measles-10  Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(9,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'measles')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(9,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(9,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(9,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'measles')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(9,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#3366ff","name":"6-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#3366ff","name":"6-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																									'heading' => array('mapName' => 'Measles-10  Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'measles')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(9,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(9,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'Measles-10  Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'tt10'=>	array(
																			'id'=>'tt10',
																			'name'=>'TT-10',
																			'viewMainHeading' => 'TT-10 Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(37,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'tt10')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(37,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(37,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(37,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'tt10')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(37,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																									'heading' => array('mapName' => 'TT-10 Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'tt10')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(37,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(37,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'TT-10 Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'tt20'=>    array(
																			'id'=>'tt20',
																			'name'=>'TT-20',
																			'viewMainHeading' => 'TT-20 Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(11,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'tt20')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(11,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(11,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(11,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'tt20')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(11,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":20,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":20,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																									'heading' => array('mapName' => 'TT-20 Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'tt20')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(11,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(11,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'TT-20 Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'hepb10'=>  array(
																			'id'=>'hepb10',
																			'name'=>'Hep-B-10',
																			'viewMainHeading' => 'Hep-B-10 Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(1,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'hepb10')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(1,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(1,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(1,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'hepb10')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(1,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":5"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																									'heading' => array('mapName' => 'Hep-B-10 Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'hepb10')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(1,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(1,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'Hep-B-10 Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'hepb2'=>	array(
																			'id'=>'hepb2',
																			'name'=>'Hep-B-02',
																			'viewMainHeading' => 'Hep-B-02 Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(38,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'hepb2')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(38,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(38,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(38,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'hepb2')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(38,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":10"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																									'heading' => array('mapName' => 'Hep-B-02 Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'hepb2')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(38,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(38,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'Hep-B-02 Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'hepb'=>	array(
																			'id'=>'hepb',
																			'name'=>'Hep-B',
																			'viewMainHeading' => 'Hep-B Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(89,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'hepb')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(89,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(89,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(89,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'hepb')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(89,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":10"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																									'heading' => array('mapName' => 'Hep-B Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'hepb')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(89,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(89,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'Hep-B Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'ipv5'=>	array(
																			'id'=>'ipv5',
																			'name'=>'IPV-5',
																			'viewMainHeading' => 'IPV-5 Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(3,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'ipv5')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(3,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(3,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(3,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'ipv5')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(3,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":10"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																									'heading' => array('mapName' => 'IPV-5 Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'ipv5')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(3,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(3,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'IPV-5 Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'ipv10'=>	array(
																			'id'=>'ipv10',
																			'name'=>'IPV-10',
																			'viewMainHeading' => 'IPV-10 Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(4,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'ipv10')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(4,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(4,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(4,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'ipv10')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(4,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																									'heading' => array('mapName' => 'IPV-10 Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'ipv10')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(4,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(4,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'IPV-10 Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		),
															'rotarix'=>	array(
																			'id'=>'rotarix',
																			'name'=>'Rotarix',
																			'viewMainHeading' => 'Rotarix Open vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(12,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
																			'topcards' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'rotarix')?array(
																						array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(12,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(12,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
																						array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(12,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
																					):false,
																					/* Map Data for the indicator if the indicator is active */
																					'map' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'rotarix')?array(
																									'id' => 'thematic-map',
																									'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(12,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
																									'dataClasses' => '{"dataClasses":[{"from":0,"to":10"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																									'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																									'heading' => array('mapName' => 'Rotarix Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																								):false,
																					/* Ranking Data for the indicator if the indicator is active */
																					'ranking' => ($indicatorid == 'openvialwastage' && $subindicatorId == 'rotarix')?array(
																									'id' => 'ranking-bar',
																									'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(12,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
																									'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(12,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
																									'heading' => array('barName' => 'Rotarix Open vial wastage wise Ranking','subtittle' => $date)
																								):false
																		)
																		),
								'value'=>$this -> OpenCloseVialWastage(9,$filters,'Open Vial Wastage Rate','3','province',false,false,66),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'openvialwastage')?array(
									array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(9,$filters,'Doses Used','3','province',false,false,66), 'leftvaluetype' => 'number'),
									array('cardicon'=>'woman.svg','leftinfo'=>'Children Vaccinated','leftvalue'=>$this -> OpenCloseVialWastage(9,$filters,'Children Vaccinated','3','province',false,false,66), 'leftvaluetype' => 'number'),
									array('cardicon'=>'target.svg','leftinfo'=>'Doses Wasted','leftvalue'=>$this -> OpenCloseVialWastage(9,$filters,'Doses Wasted','3','province',false,false,66), 'leftvaluetype' => 'number')
								):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'openvialwastage')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(9,$filters,'Open Vial Wastage Rate','3','province',true,false,66).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#3366ff","name":"6-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#3366ff","name":"6-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
												'heading' => array('mapName' => 'Measles-10  Open vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'openvialwastage')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(9,$filters,'Open Vial Wastage Rate','3','province',true,true,66).'}]',
												'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(9,$filters,'Open Vial Wastage Rate','3','province',true,true,66,true).']',
												'heading' => array('barName' => 'Measles-10  Open vial wastage wise Ranking','subtittle' => $date)
											):false
			),
			'closevialwastage' => array(
								'id' => 'closevialwastage',
								'isactive' => ($indicatorid && $indicatorid == 'closevialwastage')?true:false,
								'topheading' => 'Close Vial Wastage',
								'bottomheading' => 'BCG',
								'carousel' => true,
								'carouselarray' => array(
															'bcg20' =>array(
																			'id'=>'bcg20',
																			'name'=>'BCG-20',
																			'viewMainHeading' => 'BCG-20 Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(5,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'bcg20')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(5,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(5,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(5,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'bcg20')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(5,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":30,"color":"#0B7546","name":"0-30%"},{"from":31,"to":40,"color":"#3366ff","name":"31-40%"},{"from":41,"to":50,"color":"#EBB035","name":"41-50%"},{"from":50,"to":1000,"color":"#DD1E2F","name":">50%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":30,"color":"#0B7546","name":"0-30%"},{"from":31,"to":40,"color":"#3366ff","name":"31-40%"},{"from":41,"to":50,"color":"#EBB035","name":"41-50%"},{"from":50,"to":1000,"color":"#DD1E2F","name":">50%"}]}',
																							'heading' => array('mapName' => 'BCG-20 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'bcg20')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(5,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(5,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'BCG-20 Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																			),
															
															
															
															
															'bOPV' =>array(
																			'id'=>'bOPV',
																			'name'=>'bOPV',
																			'viewMainHeading' => 'bOPV Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(2,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'bOPV')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(2,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(2,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(2,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'bOPV')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(2,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":"100%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":"100%"}]}',
																							'heading' => array('mapName' => 'bOPV Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'bOPV')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(2,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(2,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'bOPV Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'penta1'  =>array(
																			'id'=>'penta1',
																			'name'=>'Pentavalent-1',
																			'viewMainHeading' => 'Pentavalent-1 Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(7,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'penta1')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(7,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(7,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(7,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'penta1')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(7,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":5,"to":100,"color":"#DD1E2F","name":">5%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":5,"to":100,"color":"#DD1E2F","name":">5%"}]}',
																							'heading' => array('mapName' => 'Pentavalent-1 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'penta1')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(7,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(7,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'Pentavalent-1 Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'pvc10-2'  => array(
																			'id'=>'pvc10-2',
																			'name'=>'Pneumococcal-2 (PCV10)',
																			'viewMainHeading' => 'Pneumococcal-2 (PCV10) Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(8,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'pvc10-2')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(8,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(8,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(8,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'pvc10-2')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(8,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":100,"color":"#DD1E2F","name":">10%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":100,"color":"#DD1E2F","name":">10%"}]}',
																							'heading' => array('mapName' => 'Pneumococcal-2 (PCV10) Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'pvc10-2')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(8,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(8,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'Pneumococcal-2 (PCV10) Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'pvc10-4'  => array(
																			'id'=>'pvc10-4',
																			'name'=>'Pneumococcal-4 (PCV10)',
																			'viewMainHeading' => 'Pneumococcal-4 (PCV10) Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(90,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'pvc10-4')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(90,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(90,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(90,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'pvc10-4')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(90,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">30%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">30%"}]}',
																							'heading' => array('mapName' => 'Pneumococcal-4 (PCV10) Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'pvc10-4')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(90,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(90,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'Pneumococcal-4 (PCV10) Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'measles'  => array(
																			'id'=>'measles',
																			'name'=>'Measles-10',
																			'viewMainHeading' => 'Measles-10 Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(9,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'measles')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(9,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(9,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(9,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'measles')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(9,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#3366ff","name":"6-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#3366ff","name":"6-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":21,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																							'heading' => array('mapName' => 'Measles-10 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'measles')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(9,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(9,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'Measles-10 Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'tt10'  => array(
																			'id'=>'tt10',
																			'name'=>'TT-10',
																			'viewMainHeading' => 'TT-10 Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(37,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'tt10')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(37,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(37,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(37,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'tt10')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(37,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																							'heading' => array('mapName' => 'TT-10 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'tt10')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(37,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(37,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'TT-10 Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'tt20'  => array(
																			'id'=>'tt20',
																			'name'=>'TT-20',
																			'viewMainHeading' => 'TT-20 Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(11,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'tt20')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(11,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(11,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(11,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'tt20')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(11,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":20,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#EBB035","name":"11-20%"},{"from":20,"to":1000,"color":"#DD1E2F","name":">20%"}]}',
																							'heading' => array('mapName' => 'TT-20 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'tt20')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(11,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(11,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'TT-20 Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'hepb10' =>array(
																			'id'=>'hepb10',
																			'name'=>'Hep-B-10',
																			'viewMainHeading' => 'Hep-B-10 Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(1,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'hepb10')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(1,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(1,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(1,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active # */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'hepb10')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(1,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":5"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																							'heading' => array('mapName' => 'Hep-B-10 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'hepb10')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(1,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(1,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'Hep-B-10 Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'hepb2' =>	array(
																			'id'=>'hepb2',
																			'name'=>'Hep-B-02',
																			'viewMainHeading' => 'Hep-B-02 Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(1,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'hepb2')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(1,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(1,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(1,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'hepb2')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(1,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":10"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																							'heading' => array('mapName' => 'Hep-B-02 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'hepb2')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(1,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(1,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'Hep-B-02 Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'hepb' => array(
																			'id'=>'hepb',
																			'name'=>'Hep-B',
																			'viewMainHeading' => 'Hep-B Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(89,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'hepb')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(89,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(89,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(89,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'hepb')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(89,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":10"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																							'heading' => array('mapName' => 'Hep-B Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'hepb')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(89,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(89,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'Hep-B Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'ipv5' => array(
																			'id'=>'ipv5',
																			'name'=>'IPV-5',
																			'viewMainHeading' => 'IPV-5 Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(3,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'ipv5')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(3,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(3,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(3,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'ipv5')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(3,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":10"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																							'heading' => array('mapName' => 'IPV-5 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'ipv5')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(3,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(3,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'IPV-5 Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'ipv10' => array(
																			'id'=>'ipv10',
																			'name'=>'IPV-10',
																			'viewMainHeading' => 'IPV-10 Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(4,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'ipv10')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(4,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(4,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(4,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'ipv10')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(4,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":5,"color":"#0B7546","name":"0-5%"},{"from":6,"to":10,"color":"#EBB035","name":"6-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																							'heading' => array('mapName' => 'IPV-10 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'ipv10')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(4,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(4,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'IPV-10 Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		),
															'rotarix' => array(
																			'id'=>'rotarix',
																			'name'=>'Rotarix',
																			'viewMainHeading' => 'Rotarix Close vial wastage ,'.$date.'',
																			'value'=>$this -> OpenCloseVialWastage(12,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
																			'topcards' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'rotarix')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(12,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(12,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(12,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
																			/* Map Data for the indicator if the indicator is active */
																			'map' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'rotarix')?array(
																							'id' => 'thematic-map',
																							'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(12,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
																							'dataClasses' => '{"dataClasses":[{"from":0,"to":10"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																							'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":11,"to":20,"color":"#31f8dd","name":"11-20%"},{"from":21,"to":30,"color":"#EBB035","name":"21-30%"},{"from":31,"to":1000,"color":"#DD1E2F","name":">31%"}]}',
																							'heading' => array('mapName' => 'Rotarix Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
																						):false,
																			/* Ranking Data for the indicator if the indicator is active */
																			'ranking' => ($indicatorid == 'closevialwastage' && $subindicatorId == 'rotarix')?array(
																							'id' => 'ranking-bar',
																							'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(12,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
																							'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(12,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
																							'heading' => array('barName' => 'Rotarix Close vial wastage wise Ranking','subtittle' => $date)
																						):false
																		)
														),
								'value'=>$this -> OpenCloseVialWastage(5,$filters,'Close Vial Wastage Rate','3','province',false,false,67),
								'topcards' => ($indicatorid == 'closevialwastage')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Available Doses','leftvalue'=>$this -> OpenCloseVialWastage(5,$filters,'Available doses','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Doses Used','leftvalue'=>$this -> OpenCloseVialWastage(5,$filters,'Doses Used','3','province',false,false,67), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Unused Doses','leftvalue'=>$this -> OpenCloseVialWastage(5,$filters,'Unused Doses','3','province',false,false,67), 'leftvaluetype' => 'number')
																				):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'closevialwastage' )?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(5,$filters,'Close Vial Wastage Rate','3','province',true,false,67).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":30,"color":"#0B7546","name":"0-30%"},{"from":31,"to":40,"color":"#3366ff","name":"31-40%"},{"from":41,"to":50,"color":"#EBB035","name":"41-50%"},{"from":50,"to":1000,"color":"#DD1E2F","name":">50%"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":30,"color":"#0B7546","name":"0-30%"},{"from":31,"to":40,"color":"#3366ff","name":"31-40%"},{"from":41,"to":50,"color":"#EBB035","name":"41-50%"},{"from":50,"to":1000,"color":"#DD1E2F","name":">50%"}]}',
												'heading' => array('mapName' => 'BCG-20 Close vial wastage Thematic Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Map Data for the indicator if the indicator is active */
								/* 'map' => ($indicatorid == 'closevialwastage')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":[{"name":"Haripur","id":322,"path":"M442,-482C442,-482,449,-483,450,-484,452,-484,462,-491,462,-491L478,-506,481,-528,477,-535,472,-537,478,-546C478,-546,480,-547,482,-547,483,-547,487,-544,487,-544L492,-545,497,-543,497,-538,496,-534,504,-532,506,-527,521,-520,521,-507C521,-507,520,-503,520,-502,520,-501,520,-499,520,-499L522,-498,525,-501,527,-495,528,-492,536,-492,539,-487C539,-487,544,-488,545,-487,546,-487,549,-486,549,-484,549,-481,547,-476,547,-476L542,-471C542,-471,540,-468,542,-466,543,-465,555,-469,555,-469L560,-463,558,-459,560,-455C560,-455,561,-452,560,-452,559,-451,543,-445,543,-445L530,-445,525,-443,516,-436,511,-436C511,-436,503,-440,502,-441,500,-442,491,-442,491,-442L490,-446C490,-446,488,-448,491,-448,494,-448,497,-448,497,-448L499,-452C499,-452,498,-454,495,-454,493,-454,490,-453,490,-453,490,-453,490,-455,491,-455,492,-456,494,-461,494,-461,494,-461,494,-463,493,-463,492,-463,484,-464,484,-464L484,-472C484,-472,482,-475,480,-474,479,-473,471,-466,470,-465,469,-463,469,-461,469,-461,469,-461,467,-459,466,-459,464,-459,452,-460,452,-461,452,-463,453,-465,453,-466,454,-468,459,-470,459,-470,459,-470,461,-472,459,-472,458,-473,443,-475,443,-475L442,-482z","fmonth":"2018-01","value":75,"due":56,"sub":42,"timely":42},{"name":"Bannu","id":311,"path":"M60,-259,68,-263,80,-267,89,-279,95,-277,97,-274,105,-276,110,-279,118,-274,129,-284,137,-281,142,-285,147,-280,158,-284,160,-293C160,-293,153,-302,152,-303,152,-305,152,-308,152,-308L137,-312C137,-312,134,-314,133,-315,132,-317,134,-323,128,-322,123,-322,117,-318,116,-318,115,-317,105,-315,102,-315,99,-315,88,-315,88,-315L80,-317C80,-317,81,-313,80,-312,80,-310,70,-303,70,-303L71,-301C71,-301,74,-301,72,-298,70,-295,65,-292,65,-292L56,-277,53,-270,56,-268,54,-256z","fmonth":"2018-01","value":98,"due":43,"sub":42,"timely":42},{"name":"Battagram","id":325,"path":"M508,-619,511,-617,510,-612C510,-612,509,-606,508,-604,507,-602,507,-600,507,-600L506,-591,506,-586C506,-586,508,-584,509,-584,511,-583,514,-584,515,-584,515,-584,527,-586,527,-586L529,-583C529,-583,529,-580,531,-581,533,-581,538,-582,538,-582,538,-582,539,-585,539,-586,539,-588,538,-590,539,-592,539,-593,541,-596,541,-596L547,-597,554,-598,558,-611,561,-614,560,-618,564,-622,579,-621,587,-619,593,-620,593,-624,599,-626,609,-637,610,-641C610,-641,600,-642,599,-642,598,-643,595,-646,595,-646,595,-646,565,-645,563,-645,562,-644,559,-648,558,-648,557,-647,542,-646,542,-646L534,-652C534,-652,533,-655,527,-653,522,-652,508,-646,508,-646L501,-644,497,-641C497,-641,495,-640,499,-639,503,-638,509,-636,509,-636L520,-632,524,-629C524,-629,524,-627,522,-627,520,-627,514,-626,514,-626L507,-619z","fmonth":"2018-01","value":92,"due":37,"sub":34,"timely":10},{"name":"Swat","id":346,"path":"M367,-636,374,-629,377,-626,378,-622,373,-618,367,-614,363,-601,368,-600,366,-594,371,-585,383,-583,390,-586,398,-591C398,-591,409,-593,409,-593L413,-600,418,-604,424,-602C424,-602,429,-602,430,-603,430,-604,432,-608,432,-608L439,-608,445,-613C445,-613,451,-651,451,-652,451,-652,448,-655,448,-655,448,-655,447,-658,447,-659,448,-661,459,-670,459,-670L463,-672,473,-687C473,-687,467,-687,467,-690,467,-694,473,-704,473,-704L480,-706C480,-706,487,-722,484,-725,481,-727,476,-729,476,-729,476,-729,474,-731,474,-733,475,-735,477,-736,478,-737,479,-738,480,-743,479,-745,478,-746,479,-764,479,-764,479,-764,482,-768,482,-770,482,-771,482,-777,482,-778,483,-779,486,-785,486,-785L486,-809C486,-809,470,-804,468,-804,467,-804,465,-803,463,-803,462,-804,448,-807,448,-807L441,-815,434,-817C434,-817,436,-816,434,-812,431,-809,425,-805,425,-805L418,-805C418,-805,418,-800,417,-799,415,-797,413,-796,412,-795,410,-793,412,-793,406,-793,401,-793,398,-795,398,-795,398,-795,391,-782,391,-779,391,-776,392,-777,391,-775,389,-773,383,-770,383,-770,383,-770,381,-764,384,-763,387,-762,389,-763,390,-762,391,-760,400,-752,400,-752L406,-749C406,-749,411,-742,411,-741,411,-739,412,-739,411,-736,410,-733,407,-731,407,-730,407,-729,409,-725,409,-725,409,-725,411,-720,409,-720,406,-720,402,-717,402,-717,402,-717,400,-714,400,-712,400,-710,398,-708,397,-707,396,-706,398,-702,398,-702,398,-702,405,-692,404,-693,403,-694,402,-691,402,-691,402,-691,393,-691,393,-690,393,-689,391,-684,391,-684L389,-682,381,-680C381,-680,378,-680,380,-676,381,-672,383,-670,383,-668,384,-666,385,-666,382,-663,380,-660,376,-660,376,-658,376,-656,377,-656,377,-654,377,-652,376,-653,375,-650,374,-646,374,-647,374,-645,374,-643,377,-643,374,-642,371,-641,368,-639,368,-639z","fmonth":"2018-01","value":99,"due":77,"sub":76,"timely":0},{"name":"Abbottabad","id":321,"path":"M521,-520,521,-505,520,-500,522,-498,525,-501,528,-492,536,-492,539,-487,545,-487,547,-486,549,-483,547,-476,541,-470,541,-467,548,-467,555,-469,560,-463,558,-458,561,-452,567,-458,571,-456,579,-461,583,-471,590,-474,592,-480,595,-480,597,-478,607,-487,612,-488C612,-488,611,-521,610,-522,609,-524,608,-526,608,-526L606,-530,608,-534C608,-534,608,-536,607,-536,606,-536,605,-534,605,-534L601,-539C601,-539,602,-539,600,-541,598,-542,593,-550,593,-550L584,-548,580,-543C580,-543,578,-539,574,-539,571,-539,569,-535,569,-535L567,-533,563,-536C563,-536,559,-536,559,-535,559,-534,557,-524,557,-524L548,-529,543,-527,537,-526,529,-532,522,-527z","fmonth":"2018-01","value":99,"due":73,"sub":72,"timely":72},{"name":"Chitral","id":343,"path":"M287,-698,295,-700C295,-700,302,-703,302,-705,302,-706,301,-709,301,-709,301,-709,305,-716,306,-717,307,-718,312,-722,312,-722L318,-722C318,-722,320,-722,321,-725,322,-727,326,-741,326,-741L333,-743C333,-743,331,-744,331,-745,330,-747,331,-757,331,-757L345,-769,359,-773,364,-776,365,-780,364,-782,361,-783,366,-798,377,-798,377,-795,377,-793,379,-792,384,-795,398,-795,403,-793,411,-794,417,-799,418,-805,425,-805,433,-811,435,-814,434,-817,441,-828,445,-837C445,-837,447,-839,445,-840,443,-842,440,-843,439,-845,439,-846,437,-849,437,-851,437,-853,439,-855,439,-857,440,-858,440,-859,440,-861,440,-863,441,-874,441,-874L450,-881,463,-881C463,-881,467,-882,467,-883,468,-885,472,-889,474,-890,476,-891,482,-893,482,-893,482,-893,490,-900,492,-899,493,-899,496,-898,496,-901,497,-903,498,-910,499,-912,499,-913,503,-916,503,-916L517,-918C517,-918,515,-921,517,-923,519,-924,530,-930,530,-930L532,-938,535,-942,532,-949C532,-949,531,-957,532,-957,534,-957,543,-959,543,-959,543,-959,548,-962,550,-962,551,-962,564,-960,566,-960,568,-960,588,-967,588,-967L595,-968,608,-962,624,-963,627,-959,641,-959C641,-959,646,-962,647,-962,649,-962,661,-962,661,-962,661,-962,669,-959,670,-959,671,-959,676,-963,676,-963,676,-963,677,-968,675,-970,673,-971,672,-976,669,-977,667,-977,663,-977,663,-977L661,-981L648,-983C648,-983,643,-994,638,-995,634,-995,629,-997,627,-995,624,-993,619,-992,619,-992,619,-992,616,-994,611,-994,605,-994,592,-994,590,-993,587,-991,575,-989,575,-989,575,-989,568,-993,563,-992,558,-992,533,-991,533,-991L526,-988,514,-989C514,-989,514,-988,509,-986,504,-985,481,-986,479,-985,477,-984,457,-984,455,-983,454,-983,444,-981,444,-981L433,-972,416,-971,402,-968C402,-968,402,-967,400,-966,397,-966,388,-968,388,-968L381,-958C381,-958,382,-957,383,-955,383,-952,380,-951,380,-951L363,-949C363,-949,361,-947,362,-946,363,-945,367,-942,365,-941,363,-941,352,-939,352,-939L344,-936C344,-936,333,-934,333,-933,333,-931,331,-927,331,-927,331,-927,327,-923,325,-923,323,-923,316,-924,316,-924L313,-916C313,-916,313,-914,314,-913,316,-912,320,-914,320,-910,321,-906,321,-906,320,-906,318,-905,315,-903,313,-904,310,-906,297,-914,297,-914,297,-914,290,-916,288,-917,286,-918,288,-919,286,-920,283,-920,279,-918,279,-917,279,-916,278,-909,278,-909,278,-909,265,-901,266,-899,267,-898,270,-896,270,-896,270,-896,271,-893,268,-893,265,-893,246,-883,246,-883L239,-873C239,-873,229,-866,227,-864,224,-862,212,-859,211,-857,211,-855,212,-854,211,-853,210,-852,204,-848,204,-846,204,-844,202,-844,205,-842,208,-840,213,-836,215,-834,218,-833,223,-830,225,-829,226,-828,234,-830,234,-828,235,-826,235,-817,235,-817,235,-817,243,-816,243,-815,244,-814,254,-802,254,-801,254,-799,253,-798,253,-796,253,-793,256,-789,256,-789L263,-787C263,-787,265,-786,264,-785,264,-783,262,-780,262,-780L256,-771C256,-771,255,-772,257,-768,260,-764,274,-761,274,-761,274,-761,276,-760,276,-759,276,-758,273,-750,273,-750,273,-750,273,-747,273,-746,274,-745,284,-739,284,-738,284,-736,282,-733,281,-732,279,-731,268,-716,267,-715,267,-714,267,-710,267,-710L274,-704,281,-699z","fmonth":"2018-01","value":100,"due":24,"sub":24,"timely":0},{"name":"Karak","id":331,"path":"M129,-322,131,-322,132,-319,133,-315C133,-315,136,-312,137,-312,138,-312,152,-308,152,-308L152,-303,160,-293,158,-284,163,-278,166,-274,186,-272,186,-272,190,-273,191,-292C191,-292,199,-303,200,-303,202,-303,222,-310,222,-310L226,-306,234,-307,247,-309,251,-316,247,-319,243,-322,243,-325,247,-329,244,-339,240,-342,241,-347,247,-350,247,-360,240,-358,235,-358C235,-358,236,-362,235,-362,234,-362,225,-361,225,-361L220,-370C220,-370,181,-376,179,-375,177,-374,177,-371,176,-371,174,-371,150,-369,150,-369L145,-362,134,-363,127,-366,124,-365,123,-345,137,-344,142,-342,144,-338,136,-333,133,-328,129,-327z","fmonth":"2018-01","value":92,"due":36,"sub":33,"timely":0},{"name":"Tank","id":316,"path":"M19,-129,30,-138,30,-138,33,-146,63,-146C63,-146,71,-146,73,-147,74,-147,84,-148,84,-148L90,-154,90,-165,95,-172,105,-177,107,-184,108,-188,114,-192,112,-199,109,-200,104,-199,95,-207,96,-213,93,-214,87,-213,77,-217,74,-221,66,-215,65,-209,58,-200,44,-190,44,-186C44,-186,42,-183,41,-184,40,-184,25,-185,25,-185L14,-172,4,-168,0,-163,0,-157,6,-153,6,-147,10,-135z","fmonth":"2018-01","value":95,"due":19,"sub":18,"timely":18},{"name":"Shangla","id":348,"path":"M438,-607,440,-601,446,-600,447,-595,462,-598,461,-601,465,-603,468,-603,474,-600,469,-597,470,-592,471,-590,474,-585,476,-578,482,-578,487,-581,487,-588,484,-590C484,-590,483,-592,484,-593,485,-595,488,-596,488,-598,488,-600,489,-610,489,-610L493,-619,508,-620,514,-625,520,-626C520,-626,523,-626,523,-627,524,-628,522,-630,521,-631,520,-632,508,-637,508,-637L498,-639C498,-639,496,-640,497,-641,498,-642,502,-644,502,-644L504,-645,502,-651,505,-653C505,-653,505,-656,501,-656,497,-656,493,-657,493,-657L489,-663,484,-671,486,-680,479,-685,472,-687,462,-670C462,-670,460,-671,459,-670,458,-669,448,-662,447,-660,447,-658,447,-656,449,-654,450,-652,451,-654,451,-652,451,-650,445,-613,445,-613z","fmonth":"2018-01","value":100,"due":36,"sub":36,"timely":36},{"name":"Kohat","id":332,"path":"M190,-412,196,-415,206,-412,207,-407,201,-402,203,-400,204,-398,193,-397,191,-392,184,-392,187,-385,187,-382,177,-378,179,-375,220,-370,224,-362,235,-362,235,-359,241,-358,247,-360,247,-350,248,-346,254,-346,257,-343,260,-342,260,-346,265,-347,273,-341,273,-332,281,-321,295,-318,294,-327,300,-334C300,-334,303,-335,302,-338,302,-342,301,-345,301,-345,301,-345,294,-346,294,-349,294,-353,293,-359,293,-359L297,-361,297,-366,294,-368C294,-368,298,-372,300,-374,302,-375,316,-379,316,-379L321,-379C321,-379,322,-379,322,-381,322,-382,321,-385,321,-386,321,-387,333,-395,333,-395L339,-402,337,-407C337,-407,336,-409,337,-409,339,-409,341,-411,341,-411,341,-411,343,-425,343,-426,344,-428,350,-434,348,-434,346,-434,330,-436,330,-436L325,-432,315,-429,310,-431,309,-421,315,-421C315,-421,318,-419,316,-417,315,-416,311,-413,309,-412,307,-412,294,-407,290,-406,286,-404,279,-404,279,-404,279,-404,275,-402,273,-405,272,-408,270,-405,271,-408,273,-411,279,-418,279,-418,279,-418,281,-422,279,-421,277,-421,252,-419,251,-419,249,-419,245,-423,245,-423,245,-423,244,-425,243,-423,241,-422,242,-421,241,-421,240,-421,237,-423,237,-423L232,-423,230,-420,230,-418,225,-419,214,-424,208,-430,204,-435,189,-440,189,-436,191,-434,191,-428,199,-421,189,-422,182,-417z","fmonth":"2018-01","value":83,"due":52,"sub":43,"timely":36},{"name":"D.I. Khan","id":312,"path":"M19,-129C19,-127,23,-121,23,-121,23,-121,28,-103,28,-102,27,-101,26,-86,26,-85,26,-84,31,-77,31,-77L38,-73,37,-65,49,-42,53,-19,58,-2,61,3,64,3,69,-4C69,-4,80,-6,81,-7,83,-8,88,-13,88,-13,88,-13,100,-10,100,-9,101,-8,106,-8,107,-9,109,-9,111,-13,112,-13,114,-12,119,-12,119,-12L122,-7,127,-8C127,-8,127,-13,128,-14,129,-14,138,-24,138,-24,138,-24,138,-28,138,-28,139,-28,147,-30,147,-30,147,-30,147,-36,147,-37,146,-38,143,-43,143,-43L148,-44,149,-47,145,-51,148,-57,147,-65C147,-65,147,-68,147,-69,147,-70,150,-75,150,-75L154,-76,155,-80,171,-97,173,-107C173,-107,177,-110,177,-109,176,-109,179,-135,179,-135L182,-138,186,-158,193,-159,197,-165C197,-165,197,-170,196,-172,196,-174,200,-178,200,-178L204,-180,205,-184,215,-194,226,-195,227,-198C227,-198,224,-199,224,-201,224,-202,224,-203,224,-203L227,-204,226,-206,229,-218,223,-225C223,-225,220,-227,220,-225,220,-223,220,-221,220,-221,220,-221,216,-223,215,-220,215,-216,215,-216,215,-216L207,-221,198,-210,195,-210,189,-211,183,-202,141,-187,133,-183,126,-184,116,-178,105,-178,95,-172,90,-164,90,-154C90,-154,85,-147,84,-148,82,-148,68,-146,66,-146,64,-146,33,-146,33,-146,33,-146,32,-139,30,-138,29,-137,19,-129,19,-129z","fmonth":"2018-01","value":89,"due":73,"sub":65,"timely":52},{"name":"Mansehra","id":324,"path":"M497,-538,496,-534,504,-532,506,-527,521,-520,523,-528,530,-531,536,-526,547,-528,556,-524,560,-535,563,-536,566,-533,571,-538,580,-543,583,-547,590,-550,593,-550C593,-550,594,-550,595,-551,597,-552,600,-556,600,-557,600,-559,603,-582,603,-582,603,-582,612,-584,614,-584,616,-584,622,-586,622,-586L631,-585,636,-582C636,-582,639,-580,640,-582,640,-584,639,-587,640,-588,641,-590,647,-596,647,-596,647,-596,646,-599,644,-599,643,-599,640,-601,640,-601L656,-619C656,-619,657,-622,660,-622,663,-622,669,-622,669,-622L671,-626C671,-626,688,-625,688,-627,689,-629,694,-632,696,-634,698,-636,707,-639,707,-639L707,-643,713,-649,711,-656C711,-656,711,-658,713,-658,714,-659,719,-661,719,-661L717,-664,715,-668,717,-675,722,-678C722,-678,726,-686,721,-685,715,-685,706,-685,706,-685L700,-691C700,-691,694,-690,693,-688,693,-686,688,-679,688,-679L681,-677,675,-677C675,-677,673,-677,673,-675,673,-673,672,-663,672,-663,672,-663,671,-660,669,-660,668,-660,670,-660,665,-661,661,-662,646,-663,646,-663L643,-659C643,-659,642,-656,640,-656,639,-656,637,-656,636,-657,635,-658,632,-659,632,-659L622,-654C622,-654,622,-647,620,-646,619,-645,613,-643,613,-643L609,-641,610,-637,600,-626,592,-624C592,-624,594,-619,592,-619,591,-619,589,-619,586,-619,584,-619,578,-622,578,-622L564,-622,560,-618,562,-614C562,-614,558,-612,558,-610,557,-607,554,-597,554,-597,554,-597,542,-598,541,-596,540,-594,539,-592,539,-592,539,-592,539,-586,539,-585,539,-583,537,-581,536,-581,535,-581,532,-579,530,-581,528,-583,527,-586,527,-586L511,-583,511,-578,508,-575C508,-575,503,-572,503,-571,503,-570,505,-567,503,-566,502,-566,499,-563,499,-563L496,-563,493,-561C493,-561,492,-556,492,-555,492,-553,491,-553,492,-552,493,-551,493,-550,495,-549,496,-548,498,-544,498,-544z","fmonth":"2018-01","value":99,"due":71,"sub":70,"timely":6},{"name":"Kohistan","id":323,"path":"M486,-809,486,-786,482,-778,482,-768C482,-768,479,-765,479,-763,479,-761,479,-745,479,-745,479,-745,479,-742,479,-741,479,-739,477,-736,477,-736L475,-734,475,-730C475,-730,478,-728,479,-727,480,-727,484,-724,484,-724,484,-724,483,-716,483,-715,482,-713,480,-707,480,-707,480,-707,477,-705,476,-705,475,-705,473,-704,473,-704,473,-704,467,-695,467,-692,467,-689,468,-688,468,-688L475,-686,479,-684,486,-680,484,-671,490,-662,493,-658,501,-656,501,-656,505,-653,502,-651,504,-645,530,-654,533,-653,541,-646,559,-648,563,-645,595,-646,599,-642,609,-641C609,-641,620,-646,620,-646L623,-655,632,-659,637,-657C637,-657,639,-654,641,-656,643,-658,646,-663,646,-663,646,-663,652,-663,659,-662,665,-661,670,-660,670,-660,670,-660,672,-660,672,-663,672,-665,671,-675,673,-676,675,-677,677,-677,679,-677,680,-677,687,-679,687,-679,687,-679,694,-689,694,-688,693,-687,688,-695,688,-695L685,-696C685,-696,679,-694,677,-694,675,-695,669,-701,667,-701,666,-701,656,-698,656,-698L651,-707C651,-707,645,-715,645,-717,645,-720,651,-732,652,-732,653,-733,663,-740,663,-740L662,-751C662,-751,608,-755,607,-754,606,-754,595,-751,595,-751L593,-760C593,-760,590,-761,587,-764,584,-767,585,-776,581,-776,577,-776,562,-776,560,-776,558,-776,549,-783,549,-783L542,-789C542,-789,538,-794,545,-793,552,-793,558,-798,558,-798L557,-806,554,-811,547,-808C547,-808,538,-811,536,-811,534,-810,530,-808,530,-808L525,-807,521,-811,512,-807C512,-807,507,-805,506,-806,505,-806,504,-811,504,-811L493,-814z","fmonth":"2018-01","value":0,"due":8,"sub":0,"timely":0},{"name":"Mardan","id":351,"path":"M314,-548,315,-544,313,-540,312,-535,313,-532,315,-530,320,-529,324,-528,335,-508C335,-508,346,-509,346,-508,347,-507,352,-498,352,-498L381,-500,381,-511,383,-521,384,-527,392,-529,403,-528C403,-528,402,-530,402,-532,402,-533,404,-536,404,-536L405,-541,412,-544,422,-551,421,-551,418,-555,409,-559,396,-561,394,-559,383,-564C383,-564,384,-569,384,-570,383,-571,381,-573,381,-573,381,-573,371,-577,369,-577,366,-576,366,-576,366,-576L356,-568,349,-575,345,-575,337,-569,337,-560,331,-559,326,-553,319,-550z","fmonth":"2018-01","value":89,"due":79,"sub":70,"timely":70},{"name":"Peshawar","id":365,"path":"M291,-501,290,-495,292,-490,292,-487,291,-483,293,-480,301,-478,303,-477,305,-473,306,-469,305,-465,301,-459,293,-448,284,-441,272,-436C272,-436,263,-435,261,-437,260,-438,257,-439,257,-439,257,-439,256,-440,257,-443,258,-446,260,-450,259,-450,258,-450,244,-461,244,-461,244,-461,242,-462,243,-464,244,-466,248,-469,248,-469,248,-469,239,-475,239,-477,239,-479,240,-482,239,-482,238,-483,235,-487,235,-487L235,-494,232,-498C232,-498,231,-500,233,-502,234,-503,241,-510,241,-510L240,-515,250,-521,255,-516C255,-516,268,-516,269,-515,270,-514,274,-511,274,-511,274,-511,280,-511,281,-509,282,-508,288,-505,288,-505z","fmonth":"2018-01","value":100,"due":130,"sub":130,"timely":130},{"name":"Malakand","id":345,"path":"M290,-562,301,-563,302,-560,306,-556,308,-555,308,-555,314,-548,323,-552,327,-555,331,-559,337,-560,337,-569,345,-575,349,-575,356,-568,367,-576C367,-576,370,-577,371,-576,373,-576,381,-573,381,-573L385,-577,383,-583,370,-585,367,-590C367,-590,366,-593,366,-594,366,-595,368,-600,368,-600,368,-600,363,-602,360,-601,358,-600,347,-595,345,-595,343,-595,318,-595,318,-595,318,-595,313,-593,312,-593,310,-594,302,-599,302,-599,302,-599,294,-596,293,-595,292,-594,287,-591,287,-591L285,-585C285,-585,285,-583,284,-582,283,-581,281,-577,281,-577L283,-574,284,-569,287,-561z","fmonth":"2018-01","value":97,"due":37,"sub":36,"timely":0},{"name":"Swabi","id":352,"path":"M381,-499,388,-499,388,-497,387,-488,386,-486,382,-479,385,-476,386,-471,387,-467,403,-475,413,-478,420,-484,423,-484,442,-482,451,-484,463,-491,474,-502,478,-505,479,-514C479,-514,482,-527,482,-528,481,-529,477,-535,477,-535L472,-537,462,-535,446,-521,448,-519C448,-519,450,-516,448,-515,446,-514,439,-511,439,-511L419,-517C419,-517,419,-521,419,-522,420,-524,426,-530,426,-530,426,-530,425,-533,425,-534,425,-535,424,-536,425,-538,426,-539,430,-541,430,-541L430,-547,426,-549,421,-551,413,-544,405,-542C405,-542,405,-540,405,-539,405,-537,402,-533,402,-533L402,-530,403,-527,392,-529,384,-527,382,-514,380,-506z","fmonth":"2018-01","value":97,"due":67,"sub":65,"timely":54},{"name":"Hangu","id":335,"path":"M123,-346,124,-365,127,-366C127,-366,133,-363,135,-363,137,-363,145,-362,145,-362L150,-369,176,-371,179,-375,179,-375,177,-378,186,-380C186,-380,189,-384,187,-385,186,-387,184,-392,184,-392L192,-392,193,-397,204,-397,204,-400,200,-402,207,-407,206,-412,196,-415,189,-412,177,-410C177,-410,170,-404,168,-404,166,-403,160,-404,160,-404,160,-404,158,-406,154,-406,150,-406,137,-406,136,-406,135,-406,129,-410,128,-410,126,-410,122,-410,122,-410L117,-400C117,-400,122,-392,121,-392,120,-392,112,-394,112,-394L109,-391,98,-391,95,-383,92,-382,76,-381,76,-375C76,-375,81,-374,82,-373,83,-372,86,-366,86,-366L90,-358,103,-353,110,-352C110,-352,110,-349,111,-348,111,-347,115,-346,116,-345,117,-345,123,-346,123,-346z","fmonth":"2018-01","value":100,"due":20,"sub":20,"timely":20},{"name":"Buner","id":342,"path":"M383,-583,385,-577,382,-573,384,-570,383,-564,394,-560,397,-561,410,-559,418,-555,421,-551,430,-547,430,-541,426,-538,425,-536,425,-534,426,-530,419,-522,419,-518,439,-511,445,-514,448,-515,448,-519,446,-522,459,-533,465,-536,472,-538,477,-545,478,-556,474,-561,472,-564,480,-565,480,-569C480,-569,479,-572,477,-573,476,-573,475,-575,475,-575L476,-578,474,-585,470,-591,469,-597,474,-600C474,-600,468,-604,466,-603,465,-603,461,-602,461,-600,460,-599,466,-598,460,-597,453,-596,447,-595,447,-595L446,-600,440,-601,438,-607,432,-608,429,-602,422,-602,418,-604,412,-600C412,-600,410,-594,409,-593,407,-593,398,-591,398,-591L392,-587,383,-582z","fmonth":"2018-01","value":100,"due":35,"sub":35,"timely":34},{"name":"Charsadda","id":361,"path":"M250,-521,257,-516,268,-516,273,-512,280,-510,288,-505,291,-501,308,-499,311,-499,312,-494,318,-493,327,-508,334,-508,324,-528C324,-528,320,-529,318,-529,317,-529,318,-529,316,-529,314,-530,313,-532,313,-533,312,-535,312,-535,312,-538,313,-541,315,-543,315,-543L314,-548C314,-548,310,-554,308,-555,306,-555,305,-556,304,-557,303,-558,302,-558,302,-561,301,-564,301,-564,301,-564L288,-561,284,-558,283,-553,276,-551,276,-546C276,-546,273,-550,272,-549,270,-548,264,-541,264,-541,264,-541,266,-535,264,-534,262,-532,258,-529,258,-529z","fmonth":"2018-01","value":98,"due":59,"sub":58,"timely":42},{"name":"Dir Upper","id":347,"path":"M262,-669,270,-668,275,-666C275,-666,292,-664,294,-665,295,-665,303,-670,303,-670L315,-672,318,-671C318,-671,330,-657,331,-656,331,-655,330,-647,330,-647L334,-645,336,-640C336,-640,335,-638,344,-635,354,-631,355,-631,355,-631L358,-631,364,-634C364,-634,368,-634,368,-636,367,-638,368,-639,368,-639L375,-643C375,-643,373,-645,374,-647,375,-648,376,-651,376,-651L377,-654C377,-654,376,-657,376,-658,377,-659,374,-658,378,-660,381,-662,384,-665,384,-665,384,-665,384,-667,383,-668,382,-670,379,-677,379,-677,379,-677,377,-678,380,-679,383,-680,389,-682,389,-682L391,-685,394,-691,402,-692C402,-692,404,-693,403,-694,402,-695,397,-706,397,-706,397,-706,400,-710,400,-712,400,-714,402,-718,402,-718L408,-720C408,-720,410,-723,410,-724,409,-725,407,-730,407,-730,408,-731,410,-734,410,-734L411,-737,410,-743,406,-749C406,-749,401,-751,400,-752,399,-753,390,-762,390,-762L383,-764C383,-764,383,-770,383,-770,383,-770,382,-770,383,-770,384,-771,390,-775,390,-775L391,-777C391,-777,390,-778,391,-781,392,-783,398,-794,398,-794L383,-796,380,-792,377,-793C377,-793,379,-799,375,-798,371,-797,366,-799,366,-797,366,-795,361,-783,361,-783L365,-782C365,-782,366,-779,365,-777,363,-775,363,-774,361,-773,359,-772,345,-770,344,-768,342,-766,332,-757,331,-756,330,-755,330,-746,330,-746,330,-746,334,-742,333,-742,331,-742,325,-741,325,-741L324,-736,322,-727C322,-727,321,-723,320,-723,318,-722,312,-722,312,-722L305,-717,301,-709C301,-709,303,-705,302,-704,300,-703,295,-700,294,-699,292,-699,287,-698,287,-698,287,-698,287,-692,286,-692,285,-692,277,-684,277,-684L266,-679,262,-669z","fmonth":"2018-01","value":78,"due":41,"sub":32,"timely":32},{"name":"Lakki Marwat","id":313,"path":"M93,-214,96,-212,95,-207,103,-200,111,-200,112,-198,114,-192,108,-188,105,-178,117,-178,126,-184,134,-183,142,-188,183,-203,189,-211C189,-211,193,-210,194,-210,196,-210,198,-210,198,-210L207,-221C207,-221,211,-226,209,-226,207,-227,195,-237,195,-237L193,-249C193,-249,191,-252,191,-253,190,-254,190,-260,190,-260L186,-272,166,-274C166,-274,159,-285,157,-284,155,-284,146,-280,146,-280L142,-285C142,-285,138,-281,136,-281,135,-281,129,-284,129,-284L118,-274,109,-279,104,-276,97,-274,95,-277C95,-277,88,-280,88,-278,87,-277,83,-271,83,-271L80,-266,75,-265C75,-265,59,-260,60,-259,60,-258,60,-254,60,-254,60,-254,69,-245,69,-244,69,-242,82,-232,82,-232,82,-232,86,-234,86,-232,86,-230,86,-228,86,-228,86,-228,93,-214,93,-214z","fmonth":"2018-01","value":96,"due":51,"sub":49,"timely":49},{"name":"Dir Lower","id":344,"path":"M302,-599,312,-593,318,-595,324,-595,340,-595,349,-596,359,-600,361,-601C361,-601,362,-601,363,-601,363,-601,366,-613,366,-613,366,-613,367,-616,370,-617,373,-618,377,-621,377,-621,377,-621,380,-624,377,-626,374,-628,367,-636,367,-636,367,-636,363,-633,361,-632,359,-631,356,-631,354,-631,351,-631,344,-635,344,-635L336,-640,335,-645,330,-647,332,-655,326,-663,318,-672C318,-672,313,-672,309,-672,306,-671,297,-667,297,-667,297,-667,296,-665,294,-665,293,-664,273,-666,273,-666L270,-668,262,-669,265,-664,256,-658,261,-654,276,-636C276,-636,279,-632,283,-629,287,-626,300,-623,300,-623,300,-623,301,-620,303,-620,305,-619,307,-617,307,-617L302,-615C302,-615,301,-612,301,-611,301,-610,302,-599,302,-599z","fmonth":"2018-01","value":91,"due":57,"sub":52,"timely":52},{"name":"Nowshera","id":364,"path":"M310,-431,316,-430C316,-430,324,-431,325,-432,326,-433,331,-436,331,-436L339,-435,348,-434,352,-440,359,-442C359,-442,356,-447,357,-447,358,-447,363,-446,363,-446L379,-442,387,-442,387,-466,385,-476,382,-479,386,-486C386,-486,390,-499,387,-499,385,-500,372,-499,371,-499,369,-498,352,-498,352,-498L346,-508,327,-508,317,-492,312,-493C312,-493,313,-498,311,-499,309,-500,291,-501,291,-501L290,-494C290,-494,292,-492,292,-490,292,-488,292,-484,292,-484,292,-484,289,-482,292,-480,294,-479,300,-478,300,-478,300,-478,303,-478,304,-476,305,-474,306,-473,306,-471,306,-470,306,-470,306,-467,305,-465,305,-464,304,-463,304,-462,300,-457,300,-457,300,-457,299,-454,300,-452,300,-451,307,-446,307,-446L315,-446C315,-446,318,-443,318,-442,318,-441,319,-440,317,-438,315,-436,315,-430,314,-430,313,-430,310,-431,310,-431z","fmonth":"2018-01","value":82,"due":66,"sub":54,"timely":47},{"name":"Tor Ghar","id":326,"path":"M475,-578,475,-575,479,-571,480,-568,480,-566,472,-564,478,-556,477,-547,482,-547,487,-544,492,-545,496,-543,498,-539,498,-544,494,-549C494,-549,491,-552,491,-553,492,-555,493,-561,493,-561L496,-563,500,-564,504,-568,503,-572,508,-575,511,-577,511,-583C511,-583,506,-584,506,-585,506,-587,506,-588,506,-591,506,-593,506,-595,506,-598,506,-600,509,-605,509,-606,509,-608,511,-614,511,-614,511,-614,512,-616,510,-617,508,-618,507,-619,505,-619,504,-619,493,-619,493,-619L489,-611C489,-611,488,-606,488,-604,488,-603,488,-598,488,-598L484,-594C484,-594,482,-592,484,-590,485,-589,488,-588,488,-586,488,-585,487,-580,487,-580L482,-578z","fmonth":"2018-01","value":100,"due":17,"sub":17,"timely":0}]}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'heading' => array('mapName' => ' Close vial wastage Thematic Map','subtittle' => 'New Subtitle','run' => 'New Run')
											):false, */
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'closevialwastage')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> OpenCloseVialWastage(5,$filters,'Close Vial Wastage Rate','3','province',true,true,67).'}]',
												'serieses_ranking_cat' => '['.$this -> OpenCloseVialWastage(5,$filters,'Close Vial Wastage Rate','3','province',true,true,67,true).']',
												'heading' => array('barName' => 'BCG-20 Close vial wastage wise Ranking','subtittle' => $date)
											):false
			),
			'diseaseoutbreak' => array(
								'id' => 'diseaseoutbreak',
								'isactive' => ($indicatorid && $indicatorid == 'diseaseoutbreak')?true:false,
								'topheading' => 'Disease Outbreak',
								'bottomheading' => 'Measles',
								'carousel' => true,
								'carouselarray' => array(
															'Diph'=>array(
																		'id'=>'Diph',
																		'name'=>'Acute watery diarrhea < 5',
																		'viewMainHeading' => 'Acute watery diarrhea < 5 Outbreak ,'.$date.'',
																		'value'=>$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',false,false,'Total Epid'),
																		'topcards' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Diph')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Epid','leftvalue'=>$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',false,false,'Total Epid'), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Disease Cases','leftvalue'=>$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',false,false,'Disease Case'), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Total Cases','leftvalue'=>$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',false,false,'All Case'), 'leftvaluetype' => 'number')
																				):false,
																		/* Map Data for the indicator if the indicator is active */
																		'map' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Diph')?array(
																						'id' => 'thematic-map',
																						'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',true,false,'Total Epid').'}]',
																						'dataClasses' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																						'colorAxis' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																						'heading' => array('mapName' => 'Acute watery diarrhea < 5 Thematic Map','subtittle' => $date,'run' => 'New Run')
																					):false,
																		/* Ranking Data for the indicator if the indicator is active */
																		'ranking' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Diph')?array(
																						'id' => 'ranking-bar',
																						'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',true,true,'Total Epid').'}]',
																						'serieses_ranking_cat' => '['.$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',true,true,'Total Epid',true).']',
																						'heading' => array('barName' => 'Acute watery diarrhea < 5 wise Ranking','subtittle' => $date)
																					):false
																	),
															'Msl'=>array(
																		'id'=>'Msl',
																		'name'=>'Measles',
																		'viewMainHeading' => 'Measles Outbreak ,'.$date.'',
																		'value'=>$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',false,false,'Disease Case'),
																		'topcards' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Msl')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Epid','leftvalue'=>$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',false,false,'Total Epid'), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Disease Cases','leftvalue'=>$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',false,false,'Disease Case'), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Total Cases','leftvalue'=>$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',false,false,'All Case'), 'leftvaluetype' => 'number')
																				):false,
																				/* Map Data for the indicator if the indicator is active */
																		'map' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Msl')?array(
																						'id' => 'thematic-map',
																						'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',true,false,'Total Epid').'}]',
																						'dataClasses' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																						'colorAxis' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																						'heading' => array('mapName' => 'Measles Thematic Map','subtittle' => $date,'run' => 'New Run')
																					):false,
																		/* Ranking Data for the indicator if the indicator is active */
																		'ranking' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Msl')?array(
																						'id' => 'ranking-bar',
																						'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',true,true,'Total Epid').'}]',
																						'serieses_ranking_cat' => '['.$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',true,true,'Total Epid',true).']',
																						'heading' => array('barName' => 'Measles wise Ranking','subtittle' => $date)
																					):false
																	),
															'Afp'=>array(
																		'id'=>'Afp',
																		'name'=>'Acute Flacid Paralysis',
																		'viewMainHeading' => 'Acute Flacid Paralysis Outbreak ,'.$date.'',
																		'value'=>$this -> Outbreak('Afp',$filters,'afp_case_investigation','3','province',false,false,'Total Epid'),
																		'topcards' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Afp')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Epid','leftvalue'=>$this -> Outbreak('Afp',$filters,'afp_case_investigation','3','province',false,false,'Total Epid'), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Disease Cases','leftvalue'=>$this -> Outbreak('Afp',$filters,'afp_case_investigation','3','province',false,false,'Disease Case'), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Total Cases','leftvalue'=>$this -> Outbreak('Afp',$filters,'afp_case_investigation','3','province',false,false,'All Case'), 'leftvaluetype' => 'number')
																				):false,
																				/* Map Data for the indicator if the indicator is active */
																		'map' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Afp')?array(
																						'id' => 'thematic-map',
																						'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Afp',$filters,'afp_case_investigation','3','province',true,false,'Total Epid').'}]',
																						'dataClasses' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																						'colorAxis' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																						'heading' => array('mapName' => 'Acute Flacid Paralysis Thematic Map','subtittle' => $date,'run' => 'New Run')
																					):false,
																		/* Ranking Data for the indicator if the indicator is active */
																		'ranking' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Afp')?array(
																						'id' => 'ranking-bar',
																						'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Afp',$filters,'afp_case_investigation','3','province',true,true,'Total Epid').'}]',
																						'serieses_ranking_cat' => '['.$this -> Outbreak('Afp',$filters,'afp_case_investigation','3','province',true,true,'Total Epid',true).']',
																						'heading' => array('barName' => 'Acute Flacid Paralysis wise Ranking','subtittle' => $date)
																					):false
																	),
															'Nnt'=>array(
																		'id'=>'Nnt',
																		'name'=>'NNT',
																		'viewMainHeading' => 'NNT Outbreak ,'.$date.'',
																		'value'=>$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',false,false,'Total Epid'),
																		'topcards' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Nnt')?array(
																					array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Epid','leftvalue'=>$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',false,false,'Total Epid'), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'woman.svg','leftinfo'=>'Disease Cases','leftvalue'=>$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',false,false,'Disease Case'), 'leftvaluetype' => 'number'),
																					array('cardicon'=>'target.svg','leftinfo'=>'Total Cases','leftvalue'=>$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',false,false,'All Case'), 'leftvaluetype' => 'number')
																				):false,
																				/* Map Data for the indicator if the indicator is active */
																		'map' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Nnt')?array(
																						'id' => 'thematic-map',
																						'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',true,false,'Total Epid').'}]',
																						'dataClasses' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																						'colorAxis' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																						'heading' => array('mapName' => 'NNT Thematic Map','subtittle' => $date,'run' => 'New Run')
																					):false,
																		/* Ranking Data for the indicator if the indicator is active */
																		'ranking' => ($indicatorid == 'diseaseoutbreak' && $subindicatorId == 'Nnt')?array(
																						'id' => 'ranking-bar',
																						'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',true,true,'Total Epid').'}]',
																						'serieses_ranking_cat' => '['.$this -> Outbreak('Diph',$filters,'case_investigation_db','3','province',true,true,'Total Epid',true).']',
																						'heading' => array('barName' => 'NNT wise Ranking','subtittle' => $date)
																					):false
																	),
																	/* array('id'=>'','name'=>'Visceral Leishmaniasis','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Severe Acute Respiratory Illness(SARI)','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Dengue Fever','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Dengue Hemorrhagic Fever (DHF)','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Crimean Congo Hemorrhagic Fever(CCHF)','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Childhood TB','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Diphtheria','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Meningitis','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Pertussis','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Malaria','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Pneumonia','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Dog Bite','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Bloody Diarrhea','value'=>rand(40,100)),
																	array('id'=>'','name'=>'HIV/AIDS','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Typhoid','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Scabies','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Acute watery diarrhea > 5','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Acute Viral Hepatitis (Acute Jaundice Syndrome)','value'=>rand(40,100)),
																	array('id'=>'','name'=>'Others','value'=>rand(40,100)), */
								),
								'value'=>$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',false,false,'Disease Case'),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'diseaseoutbreak')?array(
																	array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Epid','leftvalue'=>$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',false,false,'Total Epid'), 'leftvaluetype' => 'number'),
																	array('cardicon'=>'woman.svg','leftinfo'=>'Disease Cases','leftvalue'=>$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',false,false,'Disease Case'), 'leftvaluetype' => 'number'),
																	array('cardicon'=>'target.svg','leftinfo'=>'Total Cases','leftvalue'=>$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',false,false,'All Case'), 'leftvaluetype' => 'number')
														):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'diseaseoutbreak')?array(
																	'id' => 'thematic-map',
																	'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',true,false,'Total Epid').'}]',
																	'dataClasses' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																	'colorAxis' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"District Without Disease OutBreak"},{"from":1,"to":1000,"color":"#DD1E2F","name":"District With Disease OutBreak"}]}',
																	'heading' => array('mapName' => 'Acute Flacid Paralysis Thematic Map','subtittle' => $date,'run' => 'New Run')
															):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'diseaseoutbreak' )?array(
																	'id' => 'ranking-bar',
																	'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',true,true,'Total Epid').'}]',
																	'serieses_ranking_cat' => '['.$this -> Outbreak('Msl',$filters,'case_investigation_db','3','province',true,true,'Total Epid',true).']',
																	'heading' => array('barName' => 'Acute Flacid Paralysis wise Ranking','subtittle' => $date)
																):false
			),
			'dropout' => array(
								'id' => 'dropout',
								'isactive' => ($indicatorid && $indicatorid == 'dropout')?true:false,
								'topheading' => 'Dropout',
								'bottomheading' => 'Penta1-Measle1',
								'carousel' => true,
								'carouselarray' => array(
													'penta1penta3'=>array(
																'id'=>'penta1penta3',
																'name'=>'Penta1-Penta3',
																'viewMainHeading' => 'Penta1-Penta3 ,'.$date.'',
																'value'=>$this -> Dropout('Penta1-Penta3 dropout Total',$filters,'3','province',false,false),
																'topcards' => ($indicatorid == 'dropout' && $subindicatorId == 'penta1penta3')?array(
																			array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Penta1-Penta3 dropout Male','leftvalue'=>$this -> Dropout('Penta1-Penta3 dropout Male',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'woman.svg','leftinfo'=>'Penta1-Penta3 dropout Female','leftvalue'=>$this -> Dropout('Penta1-Penta3 dropout Female',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'target.svg','leftinfo'=>'Penta1-Penta3 dropout Total','leftvalue'=>$this -> Dropout('Penta1-Penta3 dropout Total',$filters,'3','province',false,false), 'leftvaluetype' => 'number')
																		):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'dropout' && $subindicatorId == 'penta1penta3')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->Dropout('Penta1-Penta3 dropout Total',$filters,'3','province',true,false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																				'heading' => array('mapName' => 'Penta1-Measle1 Thematic Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'dropout' && $subindicatorId == 'penta1penta3')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Dropout('Penta1-Penta3 dropout Total',$filters,'3','province',true,true).'}]',
																				'serieses_ranking_cat' => '['.$this -> Dropout('Penta1-Penta3 dropout Total',$filters,'3','province',true,true,true).']',
																				'heading' => array('barName' => 'Penta1-Measle1 wise Ranking','subtittle' => $date)
																			):false
															),
													'penta1measles1'=>array(
																'id'=>'penta1measles1',
																'name'=>'Penta1-Measle1',
																'viewMainHeading' => 'Penta1-Measle1 ,'.$date.'',
																'value'=>$this -> Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',false,false),
																'topcards' => ($indicatorid == 'dropout' && $subindicatorId == 'penta1measles1')?array(
																			array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Penta1-Measle1 dropout Male','leftvalue'=>$this -> Dropout('Penta1-Measle1 dropout Male',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'woman.svg','leftinfo'=>'Penta1-Measle1 dropout Female','leftvalue'=>$this -> Dropout('Penta1-Measle1 dropout Female',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'target.svg','leftinfo'=>'Penta1-Measle1 dropout Total','leftvalue'=>$this -> Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',false,false), 'leftvaluetype' => 'number')
																		):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'dropout' && $subindicatorId == 'penta1measles1')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',true,false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																				'heading' => array('mapName' => 'Penta1-Measle1 Thematic Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'dropout' && $subindicatorId == 'penta1measles1')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',true,true).'}]',
																				'serieses_ranking_cat' => '['.$this -> Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',true,true,true).']',
																				'heading' => array('barName' => 'Penta1-Measle1 wise Ranking','subtittle' => $date)
																			):false
															),
													'measle1measle2'=>array(
																'id'=>'measle1measle2',
																'name'=>'Measle1-Measle2',
																'viewMainHeading' => 'Measle1-Measle2 ,'.$date.'',
																'value'=>$this -> Dropout('Measles1-Measles2 dropout Total',$filters,'3','province',false,false),
																'topcards' => ($indicatorid == 'dropout' && $subindicatorId == 'measle1measle2')?array(
																			array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Penta1-Measle1 dropout Male','leftvalue'=>$this -> Dropout('Measles1-Measles2 dropout Male',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'woman.svg','leftinfo'=>'Penta1-Measle1 dropout Female','leftvalue'=>$this -> Dropout('Measles1-Measles2 dropout Female',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'target.svg','leftinfo'=>'Penta1-Measle1 dropout Total','leftvalue'=>$this -> Dropout('Measles1-Measles2 dropout Total',$filters,'3','province',false,false), 'leftvaluetype' => 'number')
																		):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'dropout' && $subindicatorId == 'measle1measle2')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->Dropout('Measles1-Measles2 dropout Total',$filters,'3','province',true,false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																				'heading' => array('mapName' => 'Measles1-Measles2 Thematic Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'dropout' && $subindicatorId == 'measle1measle2')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Dropout('Measles1-Measles2 dropout Total',$filters,'3','province',true,true).'}]',
																				'serieses_ranking_cat' => '['.$this -> Dropout('Measles1-Measles2 dropout Total',$filters,'3','province',true,true,true).']',
																				'heading' => array('barName' => 'Measles1-Measles2 wise Ranking','subtittle' => $date)
																			):false
															),
													'tt1tt2'=>array(
																'id'=>'tt1tt2',
																'name'=>'TT1-TT2',
																'viewMainHeading' => 'TT1-TT2 ,'.$date.'',
																'value'=>$this -> Dropout('TT1-TT2 dropout Total',$filters,'3','province',false,false),
																'topcards' => ($indicatorid == 'dropout' && $subindicatorId == 'tt1tt2')?array(
																			array('cardicon'=>'manager%20(1).svg','leftinfo'=>'TT1-TT2 dropout Male','leftvalue'=>$this -> Dropout('TT1-TT2 dropout Male',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'woman.svg','leftinfo'=>'TT1-TT2 dropout Female','leftvalue'=>$this -> Dropout('TT1-TT2 dropout Female',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'target.svg','leftinfo'=>'TT1-TT2 dropout Total','leftvalue'=>$this -> Dropout('TT1-TT2 dropout Total',$filters,'3','province',false,false), 'leftvaluetype' => 'number')
																		):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'dropout' && $subindicatorId == 'tt1tt2')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->Dropout('TT1-TT2 dropout Total',$filters,'3','province',true,false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
																				'heading' => array('mapName' => 'TT1-TT2 Thematic Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'dropout' && $subindicatorId == 'tt1tt2')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Dropout('TT1-TT2 dropout Total',$filters,'3','province',true,true).'}]',
																				'serieses_ranking_cat' => '['.$this -> Dropout('TT1-TT2 dropout Total',$filters,'3','province',true,true,true).']',
																				'heading' => array('barName' => 'TT1-TT2 wise Ranking','subtittle' => $date)
																			):false
															),
															/* array('id'=>'','name'=>'Visceral Leishmaniasis','value'=>rand(40,100)),
															array('id'=>'','name'=>'Severe Acute Respiratory Illness(SARI)','value'=>rand(40,100)),
															array('id'=>'','name'=>'Dengue Fever','value'=>rand(40,100)),
															array('id'=>'','name'=>'Dengue Hemorrhagic Fever (DHF)','value'=>rand(40,100)),
															array('id'=>'','name'=>'Crimean Congo Hemorrhagic Fever(CCHF)','value'=>rand(40,100)),
															array('id'=>'','name'=>'Childhood TB','value'=>rand(40,100)),
															array('id'=>'','name'=>'Diphtheria','value'=>rand(40,100)),
															array('id'=>'','name'=>'Meningitis','value'=>rand(40,100)),
															array('id'=>'','name'=>'Pertussis','value'=>rand(40,100)),
															array('id'=>'','name'=>'Malaria','value'=>rand(40,100)),
															array('id'=>'','name'=>'Pneumonia','value'=>rand(40,100)),
															array('id'=>'','name'=>'Dog Bite','value'=>rand(40,100)),
															array('id'=>'','name'=>'Bloody Diarrhea','value'=>rand(40,100)),
															array('id'=>'','name'=>'HIV/AIDS','value'=>rand(40,100)),
															array('id'=>'','name'=>'Typhoid','value'=>rand(40,100)),
															array('id'=>'','name'=>'Scabies','value'=>rand(40,100)),
															array('id'=>'','name'=>'Acute watery diarrhea > 5','value'=>rand(40,100)),
															array('id'=>'','name'=>'Acute Viral Hepatitis (Acute Jaundice Syndrome)','value'=>rand(40,100)),
															array('id'=>'','name'=>'Others','value'=>rand(40,100)) */
														),
								'value'=>$this -> Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',false,false),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'dropout')?array(
									array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Penta1-Measle1 dropout Male','leftvalue'=>$this -> Dropout('Penta1-Measle1 dropout Male',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
									array('cardicon'=>'woman.svg','leftinfo'=>'Penta1-Measle1 dropout Female','leftvalue'=>$this -> Dropout('Penta1-Measle1 dropout Female',$filters,'3','province',false,false), 'leftvaluetype' => 'number'),
									array('cardicon'=>'target.svg','leftinfo'=>'Penta1-Measle1 dropout Total','leftvalue'=>$this -> Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',false,false), 'leftvaluetype' => 'number')
																		
								):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'dropout')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',true,false).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":10,"color":"#0B7546","name":"0-10%"},{"from":10,"to":1000,"color":"#DD1E2F","name":">10%"}]}',
												'heading' => array('mapName' => 'Penta1-Measle1 Thematic Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'dropout')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',true,true).'}]',
												'serieses_ranking_cat' => '['.$this -> Dropout('Penta1-Measle1 dropout Total',$filters,'3','province',true,true,true).']',
												'heading' => array('barName' => 'Penta1-Measle1 wise Ranking','subtittle' => $date)
											):false
			),
			'sessoinsplan' => array(
								'id' => 'sessoinsplan',
								'isactive' => ($indicatorid && $indicatorid == 'sessoinsplan')?true:false,
								'topheading' => 'Session by Vaccinator/s',
								'bottomheading' => 'Out reach',
								'carousel' => true,
								'carouselarray' => array(
													'fixedsesseion'=>array(
																'id'=>'fixedsesseion',
																'name'=>'Fixed Vaccinator Session',
																'viewMainHeading' => 'Vaccinator Session ,'.$date.'',
																'value'=>$this -> Sessionplan('fixed',$filters,'ratio','3','province',false,false),
																'topcards' => ($indicatorid == 'sessoinsplan' && $subindicatorId == 'fixedsesseion')?array(
																			array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Fixed Vaccinator Session Planned','leftvalue'=>$this -> Sessionplan('fixed',$filters,'planned','3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'woman.svg','leftinfo'=>'Fixed Vaccinator Session Held','leftvalue'=>$this -> Sessionplan('fixed',$filters,'held','3','held',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'target.svg','leftinfo'=>'Fixed Vaccinator Session Ratio','leftvalue'=>$this -> Sessionplan('fixed',$filters,'ratio','3','ratio',false,false), 'leftvaluetype' => 'number')
																		):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sessoinsplan' && $subindicatorId == 'fixedsesseion')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Sessionplan('fixed',$filters,'ratio','3','province',true,false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Fixed Vaccinator Session Thematic Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sessoinsplan' && $subindicatorId == 'fixedsesseion')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Sessionplan('fixed',$filters,'ratio','3','province',true,true).'}]',
																				'serieses_ranking_cat' => '['.$this -> Sessionplan('fixed',$filters,'ratio','3','province',true,true,true).']',
																				'heading' => array('barName' => 'Fixed Vaccinator Session wise Ranking','subtittle' => $date)
																			):false
															),
													'householdsesseion'=>array(
																'id'=>'householdsesseion',
																'name'=>'House Hold Vaccinator Session',
																'viewMainHeading' => 'House Hold Vaccinator Session ,'.$date.'',
																'value'=>$this -> Sessionplan('hh',$filters,'ratio','3','province',false,false),
																'topcards' => ($indicatorid == 'sessoinsplan' && $subindicatorId == 'householdsesseion')?array(
																			array('cardicon'=>'manager%20(1).svg','leftinfo'=>'House Hold Vaccinator Session Planned','leftvalue'=>$this -> Sessionplan('hh',$filters,'planned','3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'woman.svg','leftinfo'=>'House Hold Vaccinator Session Held','leftvalue'=>$this -> Sessionplan('hh',$filters,'held','3','held',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'target.svg','leftinfo'=>'House Hold Vaccinator Session Ratio','leftvalue'=>$this -> Sessionplan('hh',$filters,'ratio','3','ratio',false,false), 'leftvaluetype' => 'number')
																		):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sessoinsplan' && $subindicatorId == 'householdsesseion')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Sessionplan('hh',$filters,'ratio','3','province',true,false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'House Hold Vaccinator Session Thematic Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sessoinsplan' && $subindicatorId == 'householdsesseion')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Sessionplan('hh',$filters,'ratio','3','province',true,true).'}]',
																				'serieses_ranking_cat' => '['.$this -> Sessionplan('hh',$filters,'ratio','3','province',true,true,true).']',
																				'heading' => array('barName' => 'House Hold Vaccinator Session wise Ranking','subtittle' => $date)
																			):false
															),
													'mobilesesseion'=>array(
																'id'=>'mobilesesseion',
																'name'=>'Mobile Vaccinator Session',
																'viewMainHeading' => 'Mobile Vaccinator Session ,'.$date.'',
																'value'=>$this -> Sessionplan('mv',$filters,'ratio','3','province',false,false),
																'topcards' => ($indicatorid == 'sessoinsplan' && $subindicatorId == 'mobilesesseion')?array(
																			array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Mobile Vaccinator Session Planned','leftvalue'=>$this -> Sessionplan('mv',$filters,'planned','3','province',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'woman.svg','leftinfo'=>'Mobile Vaccinator Session Held','leftvalue'=>$this -> Sessionplan('mv',$filters,'held','3','held',false,false), 'leftvaluetype' => 'number'),
																			array('cardicon'=>'target.svg','leftinfo'=>'Mobile Vaccinator Session Ratio','leftvalue'=>$this -> Sessionplan('mv',$filters,'ratio','3','ratio',false,false), 'leftvaluetype' => 'number')
																		):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sessoinsplan' && $subindicatorId == 'mobilesesseion')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Sessionplan('mv',$filters,'ratio','3','province',true,false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Mobile Vaccinator Session Thematic Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sessoinsplan' && $subindicatorId == 'mobilesesseion')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Sessionplan('mv',$filters,'ratio','3','province',true,true).'}]',
																				'serieses_ranking_cat' => '['.$this -> Sessionplan('mv',$filters,'ratio','3','province',true,true,true).']',
																				'heading' => array('barName' => 'Mobile Vaccinator Session wise Ranking','subtittle' => $date)
																			):false
															),
								
								
								),
								'value' => $this -> Sessionplan('or',$filters,'ratio','3','province',false,false),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'sessoinsplan')?array(
												array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Outreach Vaccinator Session Planned','leftvalue'=>$this -> Sessionplan('or',$filters,'planned','3','province',false,false), 'leftvaluetype' => 'number'),
												array('cardicon'=>'woman.svg','leftinfo'=>'Outreach Vaccinator Session Held','leftvalue'=>$this -> Sessionplan('or',$filters,'held','3','held',false,false), 'leftvaluetype' => 'number'),
												array('cardicon'=>'target.svg','leftinfo'=>'Outreach Vaccinator Session Ratio','leftvalue'=>$this -> Sessionplan('or',$filters,'ratio','3','ratio',false,false), 'leftvaluetype' => 'number')
											):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'sessoinsplan')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Sessionplan('or',$filters,'ratio','3','province',true,false).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'heading' => array('mapName' => 'Outreach Vaccinator Session Thematic Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'sessoinsplan')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":"coverages","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> Sessionplan('or',$filters,'ratio','3','province',true,true).'}]',
												'serieses_ranking_cat' => '['.$this -> Sessionplan('or',$filters,'ratio','3','province',true,true,true).']',
												'heading' => array('barName' => 'Outreach Vaccinator Session wise Ranking','subtittle' => $date)
											):false
			)
		);
		//print_r($data['leftCardsMainArray']);exit;
		/* Right Cards Information */
		$data['rightCardsMainArray'] = array(
			'uczeroepi' => array(
								'id' => 'uczeroepi',
								'isactive' => ($indicatorid && $indicatorid == 'uczeroepi')?true:false,
								'topheading' => 'UCs without EPI Center',
								'bottomheading' => '',
								'carousel' => false,
								'carouselarray' => array(
															array('id'=>'','name'=>'DIL-Measles','value'=>rand(40,100)),
															array('id'=>'','name'=>'BCG','value'=>rand(40,100)),
															array('id'=>'','name'=>'DIL-BCG','value'=>rand(40,100)),
															array('id'=>'','name'=>'Hep','value'=>rand(40,100)),
															array('id'=>'','name'=>'bOPV','value'=>rand(40,100)),
															array('id'=>'','name'=>'Pentavalent','value'=>rand(40,100)),
															array('id'=>'','name'=>'Pneumococcal','value'=>rand(40,100)),
															array('id'=>'','name'=>'Rota','value'=>rand(40,100)),
															array('id'=>'','name'=>'IPV','value'=>rand(40,100)),
															array('id'=>'','name'=>'TT','value'=>rand(40,100)),
															array('id'=>'','name'=>'Dropper','value'=>rand(40,100)),
															array('id'=>'','name'=>'Recon. Syr 5','value'=>rand(40,100)),
															array('id'=>'','name'=>'Recon. Syr 2','value'=>rand(40,100)),
															array('id'=>'','name'=>'Syringe 2.5','value'=>rand(40,100)),
															array('id'=>'','name'=>'Syringe 5.0','value'=>rand(40,100)),
															array('id'=>'','name'=>'Vitamin A','value'=>rand(40,100)),
															array('id'=>'','name'=>'Safety Box','value'=>rand(40,100))
														),

								'value'=>$this -> UcZeroEpi('ucwithzeroepi',$filters,$code='3',$type='province',$map=false,$ranking=false),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'uczeroepi')?array(
									array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total UCs','leftvalue'=> $this ->UcZeroEpi('totaluc',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'woman.svg','leftinfo'=>'UC with attached EPI center','leftvalue'=> $this ->UcZeroEpi('ucwitattachepi',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'target.svg','leftinfo'=>'UC with zero vaccinator','leftvalue'=> $this ->UcZeroEpi('ucwithzeroepi',$filters,$code='3',$type='province',$map=false,$ranking=false))
								):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'uczeroepi')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->UcZeroEpi('ucwithzeroepi',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#0B7546","name":"Zero"},{"from":71,"to":99,"color":"#DD1E2F","name":"Greater then zero"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#0B7546","name":"Zero"},{"from":71,"to":99,"color":"#DD1E2F","name":"Greater then zero"}]}',
												'heading' => array('mapName' => 'District`s UCs without EPI Center Map','subtittle' => 'New Subtitle','run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'uczeroepi')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->UcZeroEpi('ucwithzeroepi',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
												'serieses_ranking_cat' => '['.$this ->UcZeroEpi('ucwithzeroepi',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
												'heading' => array('barName' => 'District`s UCs without EPI Center Ranking','subtittle' => 'New ranking Subtitle')
											):false
			),
			'faczerotech' => array(
								'id' => 'faczerotech',
								'isactive' => ($indicatorid && $indicatorid == 'faczerotech')?true:false,
								'topheading' => 'EPI Center without Vaccinator',
								'bottomheading' => '',
								'carousel' => false,
								/* 'carouselarray' => array(
															array('id'=>'','name'=>'Measles1-Measles2','value'=>rand(40,100)),
															array('id'=>'','name'=>'TT1-TT2','value'=>rand(40,100)),
															array('id'=>'','name'=>'Penta1-Measles1','value'=>rand(40,100)),
															array('id'=>'','name'=>'Penta3-Measles1','value'=>rand(40,100))
														), */
								'value'=>$this -> FacZeroTech('faczerotech',$filters,$code='3',$type='province',$map=false,$ranking=false),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'faczerotech')?array(
									array('cardicon'=>'manager%20(1).svg','leftinfo'=>'EPI center','leftvalue'=> $this ->FacZeroTech('totalfac',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'woman.svg','leftinfo'=>'EPI center with Vaccinator','leftvalue'=> $this ->FacZeroTech('facattachtech',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'target.svg','leftinfo'=>'EPI center without Vaccinator','leftvalue'=> $this ->FacZeroTech('faczerotech',$filters,$code='3',$type='province',$map=false,$ranking=false))
								):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'faczerotech')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->FacZeroTech('faczerotech',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"0"},{"from":1,"to":10,"color":"#3366FF","name":"1-10"},{"from":10,"to":50,"color":"#EBB035","name":"10-50"},{"from":50,"to":999999,"color":"#DD1E2F","name":">50"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":0,"color":"#0B7546","name":"0"},{"from":1,"to":10,"color":"#3366FF","name":"1-10"},{"from":10,"to":50,"color":"#EBB035","name":"10-50"},{"from":50,"to":999999,"color":"#DD1E2F","name":">50"}]}',
												'heading' => array('mapName' => 'District`s Facilities without EPI Center Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'faczerotech')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->FacZeroTech('faczerotech',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
												'serieses_ranking_cat' => '['.$this ->FacZeroTech('faczerotech',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
												'heading' => array('barName' => 'District`s Facilities without EPI Center Ranking ','subtittle' => $date)
											):false
			),
			'epizeroilr' => array(
								'id' => 'epizeroilr',
								'isactive' => ($indicatorid && $indicatorid == 'epizeroilr')?true:false,
								'topheading' => 'EPI Center Without ILR',
								'bottomheading' => '',
								'carousel' => false,
								'carouselarray' => array(
															array('id'=>'bcg','name'=>'BCG','value'=>rand(40,100)),
															array('id'=>'hepb','name'=>'HEP-B','value'=>rand(40,100)),
															array('id'=>'opv0','name'=>'OPV-0','value'=>rand(40,100)),
															array('id'=>'opv1','name'=>'OPV-I','value'=>rand(40,100)),
															array('id'=>'opv2','name'=>'OPV-II','value'=>rand(40,100)),
															array('id'=>'opv3','name'=>'OPV-III','value'=>rand(40,100)),
															array('id'=>'penta1','name'=>'Penta-I','value'=>rand(40,100)),
															array('id'=>'penta2','name'=>'Penta-II','value'=>rand(40,100)),
															array('id'=>'penta3','name'=>'Penta-III','value'=>rand(40,100)),
															array('id'=>'pcv101','name'=>'PCV10-I','value'=>rand(40,100)),
															array('id'=>'pcv102','name'=>'PCV10-II','value'=>rand(40,100)),
															array('id'=>'pcv103','name'=>'PCV10-III','value'=>rand(40,100)),
															array('id'=>'rota1','name'=>'Rota-I','value'=>rand(40,100)),
															array('id'=>'rota2','name'=>'Rota-II','value'=>rand(40,100)),
															array('id'=>'measles1','name'=>'Measles-I','value'=>rand(40,100)),
															array('id'=>'measles2','name'=>'Measles-II','value'=>rand(40,100))
														),
								'value'=>$this -> FacNoIlr('faczeroilr',$filters,$code='3',$type='province',$map=false,$ranking=false),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'epizeroilr')?array(
									array('cardicon'=>'manager%20(1).svg','leftinfo'=>'EPI center','leftvalue'=> $this ->FacNoIlr('totalfac',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'woman.svg','leftinfo'=>'EPI center with ILR','leftvalue'=> $this ->FacNoIlr('facattachilr',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'target.svg','leftinfo'=>'EPI center without ILR','leftvalue'=> $this ->FacNoIlr('faczeroilr',$filters,$code='3',$type='province',$map=false,$ranking=false))
								):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'epizeroilr')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->FacNoIlr('faczeroilr',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":0,"color":"#DD1E2F","name":"0"},{"from":1,"to":10,"color":"#3366FF","name":"1-10"},{"from":10,"to":50,"color":"#EBB035","name":"10-50"},{"from":50,"to":999999,"color":"#0B7546","name":">50"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":0,"color":"#DD1E2F","name":"0"},{"from":1,"to":10,"color":"#3366FF","name":"1-10"},{"from":10,"to":50,"color":"#EBB035","name":"10-50"},{"from":50,"to":999999,"color":"#0B7546","name":">50"}]}',
												'heading' => array('mapName' => 'District`s Facilities without ILR Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'epizeroilr')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->FacNoIlr('faczeroilr',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
												'serieses_ranking_cat' => '['.$this ->FacNoIlr('faczeroilr',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
												'heading' => array('barName' => 'District`s Facilities without ILR Ranking ','subtittle' => $date)
											):false
			),
			'vaccinatortopopulationratio' => array(
								'id' => 'vaccinatortopopulationratio',
								'isactive' => ($indicatorid && $indicatorid == 'vaccinatortopopulationratio')?true:false,
								'topheading' => 'Vaccinator to Population ratio',
								'bottomheading' => '',
								'carousel' => false,
								'value'=>$this -> VaccinatorToPopulationRatio('ratio',$filters,$code='3',$type='province',$map=false,$ranking=false),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'vaccinatortopopulationratio')?array(
									array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Population','leftvalue'=> $this ->VaccinatorToPopulationRatio('totalpop',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'woman.svg','leftinfo'=>'Total Technician','leftvalue'=> $this ->VaccinatorToPopulationRatio('totaltech',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'target.svg','leftinfo'=>'Vaccinator To Population Ratio','leftvalue'=> $this ->VaccinatorToPopulationRatio('ratio',$filters,$code='3',$type='province',$map=false,$ranking=false))
								):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'vaccinatortopopulationratio')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":" ","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> VaccinatorToPopulationRatio('ratio',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":10000,"color":"#0B7546","name":"0-10k"},{"from":10000,"to":20000,"color":"#EBB035","name":"10k-20k"},{"from":20000,"to":9999999,"color":"#DD1E2F","name":"20k and above"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":10000,"color":"#0B7546","name":"0-10k"},{"from":10000,"to":20000,"color":"#EBB035","name":"10k-20k"},{"from":20000,"to":9999999,"color":"#DD1E2F","name":"20k and above"}]}',
												'heading' => array('mapName' => 'Vaccinator To Population Ratio Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'vaccinatortopopulationratio' )?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> VaccinatorToPopulationRatio('ratio',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
												'serieses_ranking_cat' => '['.$this -> VaccinatorToPopulationRatio('ratio',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
												'heading' => array('barName' => 'Vaccinator To Population Ratio Ranking','subtittle' => $date)
											):false
			),
			'stockout' => array(
								'id' => 'stockout',
								'isactive' => ($indicatorid && $indicatorid == 'stockout')?true:false,
								'topheading' => 'Stockout Rate',
								'bottomheading' => 'Measle',
								'carousel' => true,
								'carouselarray' => array(
													'tt_stockout'=>array(
																'id'=>'tt_stockout',
																'name'=>'TT',
																'viewMainHeading' => 'TT Stockout Rate',
																'value'=>$this -> stockout(6,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'tt_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(6,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(6,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(6,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(6,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'tt_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(6,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'tt_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(6,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(6,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'recon_syr_2'=>array(
																'id'=>'recon_syr_2',
																'name'=>'Recon Syr 2',
																'viewMainHeading' => 'Recon Syr 2 Stockout Rate',
																'value'=>$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_2')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(29,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(29,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(29,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_2')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_2')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'bopv_stockout'=>array(
																'id'=>'bopv_stockout',
																'name'=>'bOPV Stockout',
																'viewMainHeading' => 'bOPV Stockout Rate',
																'value'=>$this -> stockout(15,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'bopv_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(15,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(15,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(15,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(15,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'bopv_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(15,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'bopv_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(15,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(15,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'bcg_stockout'=>array(
																'id'=>'bcg_stockout',
																'name'=>'BCG Stockout',
																'viewMainHeading' => 'BCG Stockout Rate',
																'value'=>$this -> stockout(2,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'bcg_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(2,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(2,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(2,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(2,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'bcg_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(2,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'bcg_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(2,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(2,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'dropper_stockout'=>array(
																'id'=>'dropper_stockout',
																'name'=>'Dropper',
																'viewMainHeading' => 'Dropper Stockout Rate',
																'value'=>$this -> stockout(18,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'dropper_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(18,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(18,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(18,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(18,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'dropper_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(18,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'dropper_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(18,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(18,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
														
													'pneu_stockout'=>array(
																'id'=>'pneu_stockout',
																'name'=>'Pneumococcal',
																'viewMainHeading' => 'Pneumococcal Stockout Rate',
																'value'=>$this -> stockout(4,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'pneu_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(4,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(4,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(4,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(4,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'pneu_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(4,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'pneu_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(4,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(4,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
														),
													'rota_stockout'=>array(
																'id'=>'rota_stockout',
																'name'=>'Rota',
																'viewMainHeading' => 'Rota Stockout Rate',
																'value'=>$this -> stockout(19,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'rota_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(19,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(19,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(19,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(19,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'rota_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(19,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'rota_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(19,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(19,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
														),
													'dil_bcg_stockout'=>array(
																'id'=>'dil_bcg_stockout',
																'name'=>'Dil BCG',
																'viewMainHeading' => 'Dil BCG Stockout Rate',
																'value'=>$this -> stockout(27,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'dil_bcg_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(27,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(27,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(27,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(27,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'dil_bcg_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(27,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'dil_bcg_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(27,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(27,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
														),
													'dil_measle_stockout'=>array(
																'id'=>'Dil Measle_stockout',
																'name'=>'DIL Measle',
																'viewMainHeading' => 'DIL Measle Stockout Rate',
																'value'=>$this -> stockout(28,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'dil_measle_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(28,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(28,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(28,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(28,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'dil_measle_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(28,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'dil_measle_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(28,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(28,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'measle_stockout'=>array(
																'id'=>'measle_stockout',
																'name'=>'Measle',
																'viewMainHeading' => 'Measle Stockout Rate',
																'value'=>$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'measle_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(5,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(5,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(5,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'measle_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'measle_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'recon_syr_2'=>array(
																'id'=>'recon_syr_2',
																'name'=>'Recon Syr 2',
																'viewMainHeading' => 'Recon Syr 2 Stockout Rate',
																'value'=>$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_2')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(29,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(29,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(29,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_2')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_2')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(29,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'recon_syr_50'=>array(
																'id'=>'recon_syr_50',
																'name'=>'Recon Syr 5.0',
																'viewMainHeading' => 'Recon Syr 5.0 Stockout Rate',
																'value'=>$this -> stockout(8,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_50')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(8,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(8,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(8,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(8,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_50')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(8,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_50')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(8,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(8,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'ipv_stockout'=>array(
																'id'=>'ipv_stockout',
																'name'=>'IPV',
																'viewMainHeading' => 'IPV Stockout Rate',
																'value'=>$this -> stockout(17,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'ipv_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(17,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(17,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(17,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(17,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'ipv_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(17,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'ipv_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(17,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(17,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'pentavalent_stockout'=>array(
																'id'=>'pentavalent_stockout',
																'name'=>'Pentavalent',
																'viewMainHeading' => 'Pentavalent Stockout Rate',
																'value'=>$this -> stockout(3,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'pentavalent_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(3,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(3,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(3,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(3,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'pentavalent_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(3,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'pentavalent_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(3,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(3,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'safetybox_stockout'=>array(
																'id'=>'safetybox_stockout',
																'name'=>'Safety Box',
																'viewMainHeading' => 'Safety Box Stockout Rate',
																'value'=>$this -> stockout(10,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'safetybox_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(10,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(10,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(10,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(10,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'safetybox_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(10,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'safetybox_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(10,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(10,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'vitamin_a_stockout'=>array(
																'id'=>'vitamin_a_stockout',
																'name'=>'Vitamin A',
																'viewMainHeading' => 'Vitamin A Stockout Rate',
																'value'=>$this -> stockout(12,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'vitamin_a_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(12,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(12,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(12,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(12,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'vitamin_a_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(12,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'vitamin_a_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(12,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(12,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'recon_syr_5'=>array(
																'id'=>'recon_syr_5',
																'name'=>'Recon Syr 5',
																'viewMainHeading' => 'Recon Syr 5 Stockout Rate',
																'value'=>$this -> stockout(9,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_5')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(9,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(9,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(9,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(9,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_5')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(9,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_5')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(9,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(9,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'hep_stockout'=>array(
																'id'=>'hep_stockout',
																'name'=>'Hep',
																'viewMainHeading' => 'Hep Stockout Rate',
																'value'=>$this -> stockout(20,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'hep_stockout')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(20,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(20,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(20,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(20,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'hep_stockout')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(20,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'hep_stockout')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(20,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(20,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															),
													'recon_syr_20'=>array(
																'id'=>'recon_syr_20',
																'name'=>'Recon Syr 2.0',
																'viewMainHeading' => 'Recon Syr 2.0 Stockout Rate',
																'value'=>$this -> stockout(7,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_20')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(7,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(7,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(7,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(7,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_20')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(7,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'stockout' && $subindicatorId == 'recon_syr_20')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(7,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> stockout(7,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
																			):false
															)/* ,
															array('id'=>'hepb','name'=>'HEP-B','value'=>rand(40,100)),
															array('id'=>'opv0','name'=>'OPV-0','value'=>rand(40,100)),
															array('id'=>'opv1','name'=>'OPV-I','value'=>rand(40,100)),
															array('id'=>'opv2','name'=>'OPV-II','value'=>rand(40,100)),
															array('id'=>'opv3','name'=>'OPV-III','value'=>rand(40,100)),
															array('id'=>'penta1','name'=>'Penta-I','value'=>rand(40,100)),
															array('id'=>'penta2','name'=>'Penta-II','value'=>rand(40,100)),
															array('id'=>'penta3','name'=>'Penta-III','value'=>rand(40,100)),
															array('id'=>'pcv101','name'=>'PCV10-I','value'=>rand(40,100)),
															array('id'=>'pcv102','name'=>'PCV10-II','value'=>rand(40,100)),
															array('id'=>'pcv103','name'=>'PCV10-III','value'=>rand(40,100)),
															array('id'=>'rota1','name'=>'Rota-I','value'=>rand(40,100)),
															array('id'=>'rota2','name'=>'Rota-II','value'=>rand(40,100)),
															array('id'=>'measles1','name'=>'Measles-I','value'=>rand(40,100)),
															array('id'=>'measles2','name'=>'Measles-II','value'=>rand(40,100)) */
														),
								'value'=>$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'stockout')?array(
											array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Functional Facilities','leftvalue'=>$this -> stockout(5,$filters,'due',$code='3',$type='province',$map=false,$ranking=false)),
											array('cardicon'=>'woman.svg','leftinfo'=>'Total Reports Submitted','leftvalue'=>$this -> stockout(5,$filters,'submitted',$code='3',$type='province',$map=false,$ranking=false)),
											array('cardicon'=>'target.svg','leftinfo'=>'Total Facilities Stockout','leftvalue'=>$this -> stockout(5,$filters,'stockout',$code='3',$type='province',$map=false,$ranking=false)),
											array('cardicon'=>'target.svg','leftinfo'=>'Overall Stockout Rate','leftvalue'=>$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=false,$ranking=false))
										):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'stockout')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=false).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'heading' => array('mapName' => 'Stockout Rate Post Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'stockout')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true).'}]',
												'serieses_ranking_cat' => '['.$this -> stockout(5,$filters,'stockout_rate',$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
												'heading' => array('barName' => 'Stockout Rate Post Ranking','subtittle' => $date)
											):false
			),
			'Accessandutilization' => array(
								'id' => 'Accessandutilization',
								'isactive' => ($indicatorid && $indicatorid == 'Accessandutilization')?true:false,
								'topheading' => 'Access and Utilization',
								'bottomheading' => 'Category',
								'carousel' => false,
								'carouselarray' => array(
															array('id'=>'','name'=>'Acute watery diarrhea < 5','value'=>rand(40,100)),
															array('id'=>'','name'=>'Hepatitis B(Under 5 years)','value'=>rand(40,100)),
															array('id'=>'','name'=>'Cutaneous Leishmaniosis','value'=>rand(40,100)),
															array('id'=>'','name'=>'Anthrax','value'=>rand(40,100)),	
								),
								'value'=>$this -> AccessAndUtilization('category',$filters,$code='3',$type='province',$map=false,$ranking=false),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'Accessandutilization')?array(
									array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Districts in Category 1','leftvalue'=> $this ->AccessAndUtilization('cat1sum',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'woman.svg','leftinfo'=>'Districts in Category 2','leftvalue'=> $this ->AccessAndUtilization('cat2sum',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'target.svg','leftinfo'=>'Districts in Category 3','leftvalue'=> $this ->AccessAndUtilization('cat3sum',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'target.svg','leftinfo'=>'Districts in Category 4','leftvalue'=> $this ->AccessAndUtilization('cat4sum',$filters,$code='3',$type='province',$map=false,$ranking=false))
								):false,
								/* Map Data for the indicator if the indicator is active *///#0B7546 green//#3366FF blue//#EBB035 yellow//#DD1E2F red
								'map' => ($indicatorid == 'Accessandutilization')?array(
											'id' => 'thematic-map',
											'serieses' => '[{"name":"coverages","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->AccessAndUtilization('cat1sum',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
											'dataClasses' => '{"dataClasses":[{"from":1,"to":1,"color":"#0B7546","name":"Category 1"},{"from":2,"to":2,"color":"#3366FF","name":"Category 2"},{"from":3,"to":3,"color":"#EBB035","name":"Category 3"},{"from":4,"to":4,"color":"#DD1E2F","name":"Category 4"},{"from":0,"to":0,"color":"#efefef","name":"No record"}]}',
											'colorAxis' => '{"dataClasses":[{"from":1,"to":1,"color":"#0B7546","name":"Category 1"},{"from":2,"to":2,"color":"#3366FF","name":"Category 2"},{"from":3,"to":3,"color":"#EBB035","name":"Category 3"},{"from":4,"to":4,"color":"#DD1E2F","name":"Category 4"},{"from":0,"to":0,"color":"#efefef","name":"No record"}]}',
											'heading' => array('mapName' => 'Access and Utilization Thematic Map','subtittle' => $date,'run' => 'New Run')
										):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'Accessandutilization')?array(
												'id' => 'ranking-bar',
												'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this ->AccessAndUtilization('cat1sum',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
												'serieses_ranking_cat' => '['.$this ->AccessAndUtilization('cat1sum',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
												'heading' => array('barName' => 'Access and Utilization Ranking ','subtittle' => $date)
											):false
			),
			'sanctionvsfilledpost' => array(
								'id' => 'sanctionvsfilledpost',
								'isactive' => ($indicatorid && $indicatorid == 'sanctionvsfilledpost')?true:false,
								'topheading' => 'Sanction VS Filled Post',
								'bottomheading' => 'Technician',
								'carousel' => true,
								'carouselarray' => array(
													'epicoordinator'=>array(
																'id'=>'epicoordinator',
																'name'=>'EPI Coordinator',
																'viewMainHeading' => 'EPI Coordinator',
																'value'=>$this -> SanctionedVsFilledPost('epi_coordinator','persent','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'epicoordinator')?array(
																				array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Sanction Post of EPI Coordinator','leftvalue'=>$this -> SanctionedVsFilledPost('epi_coordinator','sanctioned','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'woman.svg','leftinfo'=>'Total Filled Post of EPI Coordinator','leftvalue'=>$this -> SanctionedVsFilledPost('epi_coordinator','filled','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Total Vaccant Post of EPI Coordinator','leftvalue'=>$this -> SanctionedVsFilledPost('epi_coordinator','vaccant','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																				array('cardicon'=>'target.svg','leftinfo'=>'Sanction to Filled Ratio','leftvalue'=>$this -> SanctionedVsFilledPost('epi_coordinator','persent','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'epicoordinator')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('epi_coordinator','persent','supervisordb',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Sanction VS Filled Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'epicoordinator')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('epi_coordinator','persent','supervisordb',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> SanctionedVsFilledPost('epi_coordinator','persent','supervisordb',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Sanction VS Filled Post Ranking','subtittle' => $date)
																			):false
															),
													'DSO'=>array(
																'id'=>'DSO',
																'name'=>'District Surveillance Officer',
																'viewMainHeading' => 'District Surveillance Officer',
																'value'=>$this -> SanctionedVsFilledPost('dso','persent','dsodb',$filters,$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'DSO')?array(
																	array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Sanction Post of District Surveillance Officer','leftvalue'=>$this -> SanctionedVsFilledPost('dso','sanctioned','dsodb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'woman.svg','leftinfo'=>'Total Filled Post of District Surveillance Officer','leftvalue'=>$this -> SanctionedVsFilledPost('dso','filled','dsodb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Total Vaccant Post of District Surveillance Officer','leftvalue'=>$this -> SanctionedVsFilledPost('dso','vaccant','dsodb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Sanction to Filled Ratio','leftvalue'=>$this -> SanctionedVsFilledPost('dso','persent','dsodb',$filters,$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'DSO')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('dso','persent','dsodb',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Sanction VS Filled Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'DSO')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('dso','persent','dsodb',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> SanctionedVsFilledPost('dso','persent','dsodb',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Sanction VS Filled Post Ranking','subtittle' => $date)
																			):false
															),
													'tsv'=>array(
																'id'=>'tsv',
																'name'=>'Tehsil Superintendent Vaccinator',
																'viewMainHeading' => 'Tehsil Superintendent Vaccinator',
																'value'=>$this -> SanctionedVsFilledPost('tsv','persent','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'tsv')?array(
																	array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Sanction Post of Tehsil Superintendent Vaccinator','leftvalue'=>$this -> SanctionedVsFilledPost('tsv','sanctioned','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'woman.svg','leftinfo'=>'Total Filled Post of Tehsil Superintendent Vaccinator','leftvalue'=>$this -> SanctionedVsFilledPost('tsv','filled','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Total Vaccant Post of Tehsil Superintendent Vaccinator','leftvalue'=>$this -> SanctionedVsFilledPost('tsv','vaccant','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Sanction to Filled Ratio','leftvalue'=>$this -> SanctionedVsFilledPost('tsv','persent','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'tsv')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('tsv','persent','supervisordb',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Sanction VS Filled Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'tsv')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('tsv','persent','supervisordb',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> SanctionedVsFilledPost('tsv','persent','supervisordb',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Sanction VS Filled Post Ranking','subtittle' => $date)
																			):false
																
															),
													'asv'=>array(
																'id'=>'asv',
																'name'=>'Assistant Superintendent Vaccinator',
																'viewMainHeading' => 'Assistant Superintendent Vaccinator',
																'value'=>$this -> SanctionedVsFilledPost('asv','persent','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'asv')?array(
																	array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Sanction Post of Assistant Superintendent Vaccinator','leftvalue'=>$this -> SanctionedVsFilledPost('asv','sanctioned','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'woman.svg','leftinfo'=>'Total Filled Post of Assistant Superintendent Vaccinator','leftvalue'=>$this -> SanctionedVsFilledPost('asv','filled','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Total Vaccant Post of Assistant Superintendent Vaccinator','leftvalue'=>$this -> SanctionedVsFilledPost('asv','vaccant','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Sanction to Filled Ratio','leftvalue'=>$this -> SanctionedVsFilledPost('asv','persent','supervisordb',$filters,$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'asv')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('asv','persent','supervisordb',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Sanction VS Filled Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'asv')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('asv','persent','supervisordb',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> SanctionedVsFilledPost('asv','persent','supervisordb',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Sanction VS Filled Post Ranking','subtittle' => $date)
																			):false
																
															),
													'computer_operator'=>array(
																'id'=>'computer_operator',
																'name'=>'Computer Operator',
																'viewMainHeading' => 'Computer Operator',
																'value'=>$this -> SanctionedVsFilledPost('computer_operator','persent','codb',$filters,$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'computer_operator')?array(
																	array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Sanction Post of Computer Operator','leftvalue'=>$this -> SanctionedVsFilledPost('computer_operator','sanctioned','codb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'woman.svg','leftinfo'=>'Total Filled Post of Computer Operator','leftvalue'=>$this -> SanctionedVsFilledPost('computer_operator','filled','codb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Total Vaccant Post of Computer Operator','leftvalue'=>$this -> SanctionedVsFilledPost('computer_operator','vaccant','codb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Sanction to Filled Ratio','leftvalue'=>$this -> SanctionedVsFilledPost('computer_operator','persent','codb',$filters,$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'computer_operator')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('computer_operator','persent','codb',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Sanction VS Filled Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'computer_operator')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('computer_operator','persent','codb',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> SanctionedVsFilledPost('computer_operator','persent','codb',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Sanction VS Filled Post Ranking','subtittle' => $date)
																			):false
																
															),
													'hfincharge'=>array(
																'id'=>'hfincharge',
																'name'=>'HF Incharge',
																'viewMainHeading' => 'HF Incharge',
																'value'=>$this -> SanctionedVsFilledPost('hf_incharge','persent','med_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'hfincharge')?array(
																	array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Sanction Post of HF Incharge','leftvalue'=>$this -> SanctionedVsFilledPost('hf_incharge','sanctioned','med_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'woman.svg','leftinfo'=>'Total Filled Post of HF Incharge','leftvalue'=>$this -> SanctionedVsFilledPost('hf_incharge','filled','med_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Total Vaccant Post of HF Incharge','leftvalue'=>$this -> SanctionedVsFilledPost('hf_incharge','vaccant','med_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Sanction to Filled Ratio','leftvalue'=>$this -> SanctionedVsFilledPost('hf_incharge','persent','med_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'hfincharge')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('hf_incharge','persent','med_techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Sanction VS Filled Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'hfincharge')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('hf_incharge','persent','med_techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> SanctionedVsFilledPost('hf_incharge','persent','med_techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Sanction VS Filled Post Ranking','subtittle' => $date)
																			):false
																
															),
													'epitechnician'=>array(
																'id'=>'epitechnician',
																'name'=>'EPI Technician',
																'viewMainHeading' => 'EPI Technician',
																'value'=>$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'epitechnician')?array(
																	array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Sanction Post of EPI Technician','leftvalue'=>$this -> SanctionedVsFilledPost('epi_tech','sanctioned','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'woman.svg','leftinfo'=>'Total Filled Post of EPI Technician','leftvalue'=>$this -> SanctionedVsFilledPost('epi_tech','filled','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Total Vaccant Post of EPI Technician','leftvalue'=>$this -> SanctionedVsFilledPost('epi_tech','vaccant','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Sanction to Filled Ratio','leftvalue'=>$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'epitechnician')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Sanction VS Filled Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'epitechnician')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Sanction VS Filled Post Ranking','subtittle' => $date)
																			):false
																
															),
													'cctechnician'=>array(
																'id'=>'cctechnician',
																'name'=>'Cold Chain Technician',
																'viewMainHeading' => 'EPI Technician',
																'value'=>$this -> SanctionedVsFilledPost('cc_technician','persent','cc_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false),
																/* Indicator top cards information if the indicator is active */
																'topcards' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'cctechnician')?array(
																	array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Sanction Post of Cold Chain Technician','leftvalue'=>$this -> SanctionedVsFilledPost('cc_technician','sanctioned','cc_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'woman.svg','leftinfo'=>'Total Filled Post of Cold Chain Technician','leftvalue'=>$this -> SanctionedVsFilledPost('cc_technician','filled','cc_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Total Vaccant Post of Cold Chain Technician','leftvalue'=>$this -> SanctionedVsFilledPost('cc_technician','vaccant','cc_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
																	array('cardicon'=>'target.svg','leftinfo'=>'Sanction to Filled Ratio','leftvalue'=>$this -> SanctionedVsFilledPost('cc_technician','persent','cc_techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false))
																):false,
																/* Map Data for the indicator if the indicator is active */
																'map' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'cctechnician')?array(
																				'id' => 'thematic-map',
																				'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('cc_technician','persent','cc_techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
																				'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
																				'heading' => array('mapName' => 'Sanction VS Filled Post Map','subtittle' => $date,'run' => 'New Run')
																			):false,
																/* Ranking Data for the indicator if the indicator is active */
																'ranking' => ($indicatorid == 'sanctionvsfilledpost' && $subindicatorId == 'cctechnician')?array(
																				'id' => 'ranking-bar',
																				'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('cc_technician','persent','cc_techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
																				'serieses_ranking_cat' => '['.$this -> SanctionedVsFilledPost('cc_technician','persent','cc_techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
																				'heading' => array('barName' => 'Sanction VS Filled Post Ranking','subtittle' => $date)
																			):false
																
															)
		
														),
								'value'=>$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false),
								/* Indicator top cards information if the indicator is active */
								'topcards' => ($indicatorid == 'sanctionvsfilledpost')?array(
									array('cardicon'=>'manager%20(1).svg','leftinfo'=>'Total Sanction Post of Technician','leftvalue'=>$this -> SanctionedVsFilledPost('epi_tech','sanctioned','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'woman.svg','leftinfo'=>'Total Filled Post of Technician','leftvalue'=>$this -> SanctionedVsFilledPost('epi_tech','filled','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'target.svg','leftinfo'=>'Total Vaccant Post of Technician','leftvalue'=>$this -> SanctionedVsFilledPost('epi_tech','vaccant','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false)),
									array('cardicon'=>'target.svg','leftinfo'=>'Sanction to Filled Ratio','leftvalue'=>$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false))
								):false,
								/* Map Data for the indicator if the indicator is active */
								'map' => ($indicatorid == 'sanctionvsfilledpost')?array(
												'id' => 'thematic-map',
												'serieses' => '[{"name":"","type":"map","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=false).'}]',
												'dataClasses' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'colorAxis' => '{"dataClasses":[{"from":0,"to":70,"color":"#DD1E2F","name":"0-70%"},{"from":71,"to":99,"color":"#EBB035","name":"71-99%"},{"from":100,"to":1000,"color":"#0B7546","name":"100%"}]}',
												'heading' => array('mapName' => 'Sanction VS Filled Post Map','subtittle' => $date,'run' => 'New Run')
											):false,
								/* Ranking Data for the indicator if the indicator is active */
								'ranking' => ($indicatorid == 'sanctionvsfilledpost')?array(
													'id' => 'ranking-bar',
													'serieses_ranking' => '[{"name":" ","animation":true,"dataLabels":{"enabled":true,"align":"center"},"data":'.$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=true).'}]',
													'serieses_ranking_cat' => '['.$this -> SanctionedVsFilledPost('epi_tech','persent','techniciandb',$filters,$code='3',$type='province',$map=true,$ranking=true,$category=true).']',
													'heading' => array('barName' => 'Sanction VS Filled Post Ranking','subtittle' => $date)
												):false
			)
		);
		/* Logic to find out which array to target for map and ranking data */
		$key = array_search($indicatorid, array_column($data['leftCardsMainArray'], 'id'),true);
		if($key === false){
			$key = array_search($indicatorid, array_column($data['rightCardsMainArray'], 'id'),true);
			if($key > -1)
				$arrayToSearch = $data['rightCardsMainArray'];
		}else
			$arrayToSearch = $data['leftCardsMainArray'];
		if($subindicatorId !== false){
			$loopArray = $arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId];
			$map = (isset($arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId]['map']))?$arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId]['map']:'';
			$ranking = (isset($arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId]['ranking']))?$arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId]['ranking']:'';
			/* View Main Heading */
			$data['heading'] = (isset($arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId]['viewMainHeading']))?$arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId]['viewMainHeading']:$arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId]['name'];
		}else{
			$map = (isset($arrayToSearch[$indicatorid]['map']))?$arrayToSearch[$indicatorid]['map']:'';
			$ranking = (isset($arrayToSearch[$indicatorid]['ranking']))?$arrayToSearch[$indicatorid]['ranking']:'';
			/* View Main Heading */
			//$data['heading'] = (isset($arrayToSearch[$indicatorid]['viewMainHeading']))?$arrayToSearch[$indicatorid]['viewMainHeading']:$indicatorid;//topheading
			$data['heading'] = (isset($arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId]['viewMainHeading']))?$arrayToSearch[$indicatorid]['carouselarray'][$subindicatorId]['viewMainHeading']:$arrayToSearch[$indicatorid]['topheading'];
			
		}
		/* Map Loading */
		$data['map'] = $this -> load -> view('thematic_maps/parts_view/map',$map,TRUE);
		/* Bar Graph for ranking */
		$data['ranking'] = $this -> load -> view('thematic_maps/parts_view/bar_graph',$ranking,TRUE);
		/* Load View */
		$data['subindicatorid'] = $this->input->get("subindicatorid");;
		$data['indicatorid'] = $this->input->get("indicatorid");;
		$this -> load -> view('review_dashboard/review',$data);
	}
	
	function complianceCount($col='due',$filters,$table='vaccinationcompliance c',$map=false,$ranking=false,$category=false)
	{
		
		$startCount = 1;
		$endCount = 12;
		switch($filters['period']){
			case 'yearly':
				$startCount = 1;
				$endCount = ($filters['year'] == date('Y',strtotime('first day of previous month')))?date('n',strtotime('first day of previous month')):12;
				break;
			case 'biyearly':
				if($filters['biyear'] == 1 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
					$startCount = 1;
					$endCount = date('n',strtotime('first day of previous month'));
				}else if($filters['biyear'] == 2 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) > 6 && date('n',strtotime('first day of previous month')) < 12){
					$startCount = 7;
					$endCount = date('n',strtotime('first day of previous month'));
				}else if($filters['biyear'] == 1){
					$startCount = 1;
					$endCount = 6;
				}else if($filters['biyear'] == 2){
					$startCount = 7;
					$endCount = 12;
				}
				break;
			case 'quarterly':
				switch((int)$filters['quarter']){
					case 1:
						$startCount = 1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 3)
							$endCount = date('n',strtotime('first day of previous month'));
						else
							$endCount = 3;
						break;
					case 2:
						$startCount = 4;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6)
							$endCount = date('n',strtotime('first day of previous month'));
						else
							$endCount = 6;
						break;
					case 3:
						$startCount = 7;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 9)
							$endCount = date('n',strtotime('first day of previous month'));
						else
							$endCount = 9;
						break;
					case 4:
						$startCount = 10;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 12)
							$endCount = date('n',strtotime('first day of previous month'));
						else
							$endCount = 12;
						break;
				}
				break;
			case 'monthly':
				$startCount = (int) $filters['month'];
				$endCount = (int) $filters['month'];
				break;
			default:
				$startCount = 1;
				$endCount = 12;
				break;
		}
		$select = $sub = "sum(";
		for($startCount;$startCount<=$endCount;$startCount++){
			$select .= "c.".$col."m".$startCount."+";
			if($map){
				$sub .= "c.subm".$startCount."+";
			}
		}
		$select = rtrim($select,'+');
		$select .= ")";
		if( ! $map)
			$select .= " as tot_{$col}";
		if($map){
			$sub = rtrim($sub,'+');
			$sub .= ")";
			$select = 'round((('.$sub.')//('.$select."))*100) as val, d.distcode as code,districtname(d.distcode) as name, d.highchart_coordinates as path";
		}
		$where['c.year'] = $filters['year'];
		if($this -> session -> UserLevel == 2){
			$where['c.procode'] = $this -> session -> Province;
		}else if($this -> session -> UserLevel == 3){
			$where['c.distcode'] = $this -> session -> District;
		}
		$this -> db -> select($select);
		$this -> db -> from($table);
		if($map){
			$this -> db -> join('districts d','d.distcode=c.distcode');
			$this -> db -> group_by('d.distcode,d.highchart_coordinates');
		}
		$this -> db -> where($where);
		
		if($map){
			$compliance = $serieses = array();
			$result = $this -> db -> get() -> result_array();
			foreach($result as $i => $row){
				$serieses[$i]['name'] = $row['name'];
				$serieses[$i]['id'] = $row['code'];
				$serieses[$i]['path'] = $row['path'];
				if($ranking){
					if($row['val'] >= 100){
						$serieses[$i]['color'] = "#0B7546";
					}
					else if($row['val'] <= 99 && $row['val'] >= 71){
						$serieses[$i]['color'] = "#EBB035";
					}
					else if($row['val'] <= 70){
						$serieses[$i]['color'] = "#DD1E2F";
					}
					$serieses[$i]['y'] = $row['val'];
				}
				else
					$serieses[$i]['value'] = $row['val'];
			}
			if($ranking){
				foreach ($serieses as $key => $value) {
					$compliance[$key] = $value['y'];
				}
				array_multisort($compliance, SORT_DESC, $serieses);
			}
			if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
			}
			if($ranking){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}if($map){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}
			
		}
		$result = $this -> db -> get() -> row();
		$colname = "tot_{$col}";
		return $result -> $colname;
	}
	function WeeklyComplianceCount($col='due',$filters,$table='zeroreportcompliance c',$map=false,$ranking=false,$category=false)
	{
		//print_r($filters);exit;
		$startCount = 1;
		$endCount = 54;
		
		//echo getMonthsEpiWeeks($filters['year'],12);exit;
		switch($filters['period']){
			case 'yearly':
				$startCount = 1;
				$endCount = ($filters['year'] == date('Y',strtotime('first day of previous month')))?getMonthsEpiWeeks($filters['year'],date('n')-1):getMonthsEpiWeeks($filters['year'],12);
				break;
			case 'biyearly':
				if($filters['biyear'] == 1 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
					$startCount = 1;
					$endCount = getMonthsEpiWeeks($filters['year'],date('n')-1);
				}else if($filters['biyear'] == 2 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) > 6 && date('n',strtotime('first day of previous month')) < 12){
					$startCount = getMonthsEpiWeeks($filters['year'],7);
					$endCount = getMonthsEpiWeeks($filters['year'],date('n')-1);
				}else if($filters['biyear'] == 1){
					$startCount = 1;
					$endCount = getMonthsEpiWeeks($filters['year'],6);
				}else if($filters['biyear'] == 2){
					$startCount = getMonthsEpiWeeks($filters['year'],7);
					$endCount = getMonthsEpiWeeks($filters['year'],12);
				}
				break;
			case 'quarterly':
				switch((int)$filters['quarter']){
					case 1:
						$startCount = 1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 3)
							$endCount = getMonthsEpiWeeks($filters['year'],date('n')-1);
						else
							$endCount = getMonthsEpiWeeks($filters['year'],3);
						break;
					case 2:
						$startCount = getMonthsEpiWeeks($filters['year'],3)+1 ;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6)
							$endCount = getMonthsEpiWeeks($filters['year'],date('n')-1);
						else
							$endCount = getMonthsEpiWeeks($filters['year'],6);
						break;
					case 3:
						$startCount = getMonthsEpiWeeks($filters['year'],6)+1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 9)
							$endCount = getMonthsEpiWeeks($filters['year'],date('n')-1);
						else
							$endCount = getMonthsEpiWeeks($filters['year'],9);
						break;
					case 4:
						$startCount = getMonthsEpiWeeks($filters['year'],9)+1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 12)
							$endCount = getMonthsEpiWeeks($filters['year'],date('n')-1);
						else
							$endCount = getMonthsEpiWeeks($filters['year'],12);
						break;
				}
				break;
			case 'monthly':
				$startCount = getMonthsEpiWeeks($filters['year'],$filters['month']);
				$endCount = getMonthsEpiWeeks($filters['year'],$filters['month']);
				break;
			default:
				$startCount = getMonthsEpiWeeks($filters['year'],1);
				$endCount = getMonthsEpiWeeks($filters['year'],12);
				break;
		}
		$select = $sub = "sum(";
		for($startCount;$startCount<=$endCount;$startCount++){
			$zero=($startCount < 10)?'0':'';
			$select .= "c.".$col."wk".$zero.$startCount."+";
			if($map){
				$sub .= "c.subwk".$zero.$startCount."+";
			}
		}
		$select = rtrim($select,'+');
		$select .= ")";
		if( ! $map)
			$select .= " as tot_{$col}";
		if($map){
			$sub = rtrim($sub,'+');
			$sub .= ")";
			$select = 'round((('.$sub.')//('.$select."))*100) as val, d.distcode as code,districtname(d.distcode) as name, d.highchart_coordinates as path";
		}
		$where['c.year'] = $filters['year'];
		if($this -> session -> UserLevel == 2){
			$where['c.procode'] = $this -> session -> Province;
		}else if($this -> session -> UserLevel == 3){
			$where['c.distcode'] = $this -> session -> District;
		}
		$this -> db -> select($select);
		$this -> db -> from($table);
		if($map){
			$this -> db -> join('districts d','d.distcode=c.distcode');
			$this -> db -> group_by('d.distcode,d.highchart_coordinates');
		}
		$this -> db -> where($where);
		
		if($map){
			$compliance = $serieses = array();
			$result = $this -> db -> get() -> result_array();
			foreach($result as $i => $row){
				$serieses[$i]['name'] = $row['name'];
				$serieses[$i]['id'] = $row['code'];
				$serieses[$i]['path'] = $row['path'];
				if($ranking){
					if($row['val'] >= 100){
						$serieses[$i]['color'] = "#0B7546";
					}
					else if($row['val'] <= 99 && $row['val'] >= 71){
						$serieses[$i]['color'] = "#EBB035";
					}
					else if($row['val'] <= 70){
						$serieses[$i]['color'] = "#DD1E2F";
					}
					$serieses[$i]['y'] = $row['val'];
				}else
					$serieses[$i]['value'] = $row['val'];
			}
			if($ranking){
				foreach ($serieses as $key => $value) {
					$compliance[$key] = $value['y'];
				}
				array_multisort($compliance, SORT_DESC, $serieses);
			}
			if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
			}
			if($ranking){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}if($map){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}
		}
		$result = $this -> db -> get() -> row();
		$colname = "tot_{$col}";
		return $result -> $colname;
	}
	public function coverageData($vaccineId=9,$filters,$denominator='newborn',$code='3',$type='province',$map=false,$ranking=false,$category=false){
		$year = $filters['year'];
		$startMonth = 1;
		$endMonth = 12;
		switch($filters['period']){
			case 'yearly':
				$startMonth = 1;
				$endMonth = ($filters['year'] == date('Y',strtotime('first day of previous month')))?date('n',strtotime('first day of previous month')):12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
			case 'biyearly':
				if($filters['biyear'] == 1 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
					$startMonth = 1;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 2 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) > 6 && date('n',strtotime('first day of previous month')) < 12){
					$startMonth = 7;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 1){
					$startMonth = 1;
					$endMonth = 6;
					$where = "fmonth between '{$year}-01' AND '{$year}-06'";
				}else if($filters['biyear'] == 2){
					$startMonth = 7;
					$endMonth = 12;
					$where = "fmonth between '{$year}-07' AND '{$year}-12'";
				}
				break;
			case 'quarterly':
				switch((int)$filters['quarter']){
					case 1:
						$startMonth = 1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 3){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 3;
							$where = "fmonth between '{$year}-01' AND '{$year}-03'";
						}
						break;
					case 2:
						$startMonth = 4;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-04' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 6;
							$where = "fmonth between '{$year}-04' AND '{$year}-06'";
						}
						break;
					case 3:
						$startMonth = 7;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 9){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 9;
							$where = "fmonth between '{$year}-07' AND '{$year}-09'";
						}
						break;
					case 4:
						$startMonth = 10;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 12){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-10' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 12;
							$where = "fmonth between '{$year}-10' AND '{$year}-12'";
						}
						break;
				}
				break;
			case 'monthly':
				$startMonth = (int) $filters['month'];
				$endMonth = (int) $filters['month'];
				$month = $filters['month'];
				$where = "fmonth = '".$year.'-'.$month."'";
				break;
			default:
				$startMonth = 1;
				$endMonth = 12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
		}
		$startMonth = sprintf('%02d',$startMonth);
		$endMonth = sprintf('%02d',$endMonth);
		////////by usama /////////
		if($denominator == 'maletarger_newborn'){
			$select = "round((getmonthlytarget_specificyearr('$code',$year,$startMonth,$year,$endMonth)::numeric*51)/100) as number";
			$divider = "getmonthlytarget_specificyearr(d.distcode,{$year},{$startMonth},{$year},{$endMonth})::numeric";
		}elseif($denominator == 'femaletarger_newborn'){
			$select = "round((getmonthlytarget_specificyearr('$code',$year,$startMonth,$year,$endMonth)::numeric*49)/100) as number";
			$divider = "getmonthlytarget_specificyearr(d.distcode,{$year},{$startMonth},{$year},{$endMonth})::numeric";
		}elseif($denominator == 'totaltarger_newborn'){
			$select = "round((getmonthlytarget_specificyearr('$code',$year,$startMonth,$year,$endMonth)::numeric*100)/100) as number";
			$divider = "getmonthlytarget_specificyearr(d.distcode,{$year},{$startMonth},{$year},{$endMonth})::numeric";
		}elseif($denominator == 'malevacination_newborn'){
			$select = "round(
							sumvaccinevacination_male({$vaccineId},'{$code}','{$year}-{$startMonth}','{$year}-{$endMonth}'))  as number";
			$divider = "getmonthlytarget_specificyearr(d.distcode,{$year},{$startMonth},{$year},{$endMonth})::numeric";
		}elseif($denominator == 'femalevacination_newborn'){
			$select = "round(
							sumvaccinevacination_female({$vaccineId},'{$code}','{$year}-{$startMonth}','{$year}-{$endMonth}'))  as number";
			$divider = "getmonthlytarget_specificyearr(d.distcode,{$year},{$startMonth},{$year},{$endMonth})::numeric";
		}elseif($denominator == 'maletarger_survivinginfants'){
			$select = "round((getmonthlytarget_specificyearrsurvivinginfants('{$code}','{$type}',{$year},{$startMonth},{$year},{$endMonth})::numeric*51)/100) as number";
			$divider = "getmonthlytarget_specificyearrsurvivinginfants(d.distcode,'district',{$year},{$startMonth},{$year},{$endMonth})::numeric";
			//$divider = "getmonthlytarget_specificyearr('{$code}',{$year},{$startMonth},{$year},{$endMonth})::numeric";
		}elseif($denominator == 'femaletarger_survivinginfants'){
			$select = "round((getmonthlytarget_specificyearrsurvivinginfants('{$code}','{$type}',{$year},{$startMonth},{$year},{$endMonth})::numeric*49)/100) as number";
			$divider = "getmonthlytarget_specificyearrsurvivinginfants(d.distcode,'district',{$year},{$startMonth},{$year},{$endMonth})::numeric";
			//$divider = "getmonthlytarget_specificyearr('{$code}',{$year},{$startMonth},{$year},{$endMonth})::numeric";
		}elseif($denominator == 'totaltarger_survivinginfants'){
			$select = "round((getmonthlytarget_specificyearrsurvivinginfants('{$code}','{$type}',{$year},{$startMonth},{$year},{$endMonth})::numeric*100)/100) as number";
			$divider = "getmonthlytarget_specificyearrsurvivinginfants(d.distcode,'district',{$year},{$startMonth},{$year},{$endMonth})::numeric";
			//$divider = "getmonthlytarget_specificyearr('{$code}',{$year},{$startMonth},{$year},{$endMonth})::numeric";
		} elseif($denominator == 'malevacination_survivinginfants'){
				
				 $select = "round(
							sumvaccinevacination_male({$vaccineId},'{$code}','{$year}-{$startMonth}','{$year}-{$endMonth}'))  as number"; 
						$divider = "getmonthlytarget_specificyearrsurvivinginfants(d.distcode,'district',{$year},{$startMonth},{$year},{$endMonth})::numeric";
					//	$divider = "getmonthlytarget_specificyearr('{$code}',{$year},{$startMonth},{$year},{$endMonth})::numeric";
		}elseif($denominator == 'femalevacination_survivinginfants'){
			
			$select = "round(
							sumvaccinevacination_female({$vaccineId},'{$code}','{$year}-{$startMonth}','{$year}-{$endMonth}'))  as number";
			$divider = "getmonthlytarget_specificyearrsurvivinginfants(d.distcode,'district',{$year},{$startMonth},{$year},{$endMonth})::numeric";
			//$divider = "getmonthlytarget_specificyearr('{$code}',{$year},{$startMonth},{$year},{$endMonth})::numeric";
		} 
		else{
		////////End /////////
			$select = "round(
								(sumvaccinevacination({$vaccineId},'{$code}','{$year}-{$startMonth}','{$year}-{$endMonth}')*100) // ";
			if($denominator == 'newborn')
			{
				$select .= "getmonthlytarget_specificyearr('{$code}',{$year},{$startMonth},{$year},{$endMonth})::numeric) as number";
				//$divider = "getmonthlytarget_specificyearr('{$code}',{$year},{$startMonth},{$year},{$endMonth})::numeric)";
				
			}elseif($denominator == 'survivinginfants'){
				$select .= "getmonthlytarget_specificyearrsurvivinginfants('{$code}','{$type}',{$year},{$startMonth},{$year},{$endMonth})::numeric) as number";
				//$divider = "getmonthlytarget_specificyearrsurvivinginfants('{$code}','{$type}',{$year},{$startMonth},{$year},{$endMonth})::numeric)";
			
			
			}
		}
		$this -> db -> select($select);
		////////by usama /////////
		if($map){
			$this -> db -> select("d.distcode as code,districtname(d.distcode) as name, d.highchart_coordinates as path,round((sumvaccinevacination({$vaccineId},d.distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')*100)//{$divider}) as val");
			$this -> db -> from('fac_mvrf_db c');
			$this -> db -> join('districts d','d.distcode=c.distcode');
			$this -> db -> group_by('d.distcode,d.highchart_coordinates,d.epid_code');
			$this -> db -> order_by('d.distcode');
		}
		////////End /////////
		if($map){
			$compliance = $serieses = array();
			$result = $this -> db -> get() -> result_array();
			//echo $this->db->last_query();
			foreach($result as $i => $row){
				$serieses[$i]['name'] = $row['name'];
				$serieses[$i]['id'] = $row['code'];
				$serieses[$i]['path'] = $row['path'];
				if($ranking){
					if($row['val'] >= 100){
						$serieses[$i]['color'] = "#0B7546";
					}
					else if($row['val'] <= 99 && $row['val'] >= 71){
						$serieses[$i]['color'] = "#EBB035";
					}
					else if($row['val'] <= 70){
						$serieses[$i]['color'] = "#DD1E2F";
					}
					$serieses[$i]['y'] = $row['val'];
				}else
					$serieses[$i]['value'] = $row['val'];
			}
			if($ranking){
				foreach ($serieses as $key => $value) {
					$compliance[$key] = $value['y'];
				}
				array_multisort($compliance, SORT_DESC, $serieses);
			}
			if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
			}
			if($ranking){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}if($map){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}
		}
		$result = $this -> db -> get() -> row();
		return $result -> number;
	}
	public function OpenCloseVialWastage($vaccineId=5,$filters,$record='Open Vial Wastage',$code='3',$type='province',$map=false,$ranking=false,$indicator=66,$category=false){
		
		$year = $filters['year'];
		$startMonth = 1;
		$endMonth = 12;
		switch($filters['period']){
			case 'yearly':
				$startMonth = 1;
				$endMonth = ($filters['year'] == date('Y',strtotime('first day of previous month')))?date('n',strtotime('first day of previous month')):12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
			case 'biyearly':
				if($filters['biyear'] == 1 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
					$startMonth = 1;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 2 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) > 6 && date('n',strtotime('first day of previous month')) < 12){
					$startMonth = 7;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 1){
					$startMonth = 1;
					$endMonth = 6;
					$where = "fmonth between '{$year}-01' AND '{$year}-06'";
				}else if($filters['biyear'] == 2){
					$startMonth = 7;
					$endMonth = 12;
					$where = "fmonth between '{$year}-07' AND '{$year}-12'";
				}
				break;
			case 'quarterly':
				switch((int)$filters['quarter']){
					case 1:
						$startMonth = 1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 3){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 3;
							$where = "fmonth between '{$year}-01' AND '{$year}-03'";
						}
						break;
					case 2:
						$startMonth = 4;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-04' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 6;
							$where = "fmonth between '{$year}-04' AND '{$year}-06'";
						}
						break;
					case 3:
						$startMonth = 7;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 9){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 9;
							$where = "fmonth between '{$year}-07' AND '{$year}-09'";
						}
						break;
					case 4:
						$startMonth = 10;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 12){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-10' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 12;
							$where = "fmonth between '{$year}-10' AND '{$year}-12'";
						}
						break;
				}
				break;
			case 'monthly':
				$startMonth = (int) $filters['month'];
				$endMonth = (int) $filters['month'];
				$month = $filters['month'];
				$where = "fmonth = '".$year.'-'.$month."'";
				break;
			default:
				$startMonth = 1;
				$endMonth = 12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
		}
		$startMonth = sprintf('%02d',$startMonth);
		$endMonth = sprintf('%02d',$endMonth);
		////code by usama
		//print_r($indicator);exit;
		$this -> load -> model('Indicator_reports_model');
		$data['monthfrom']=$year.'-'.$startMonth;
		$data['monthto']=$year.'-'.$endMonth;
		$data['indicator']=$indicator;
		$data['vacc_ind']=array($vaccineId);
		//print_r($data);exit;
		////////by usama /////////
		if($map){
			$data['map']='map';
			if($indicator==66){
				$wastage='Open Vial Wastage Rate';
			}else{
				$wastage='Close Vial Wastage Rate';
			}
			//print_r($data);exit;
			$data['OpenVialWastage']=$this -> Indicator_reports_model -> consumptionIndicator($data);
			$result=$data['OpenVialWastage'];
			//print_r($result);exit;
			$compliance = $serieses = array();
			foreach($result as $i => $row){
				if ($row['code'] == '3') {
						break;    /* for kpk total result */
				}
				$serieses[$i]['name'] = $row['name'];
				$serieses[$i]['id'] = $row['distcode'];
				$serieses[$i]['path'] = getDistrict_Coordinates($row['distcode']);
				if($ranking){
					if($vaccineId==9){
						if($row[$wastage] >= 20)
							$serieses[$i]['color'] = "#DD1E2F";
						else if($row[$wastage] >= 6 && $row[$wastage] <= 10)
							$serieses[$i]['color'] = "#3366ff";
						else if($row[$wastage] >= 11 && $row[$wastage] <= 20)
							$serieses[$i]['color'] = "#EBB035";
						else if($row[$wastage] <= 5)
							$serieses[$i]['color'] = "#0B7546";
					}elseif($vaccineId==5){
						if($row[$wastage] >= 50)
							$serieses[$i]['color'] = "#DD1E2F";
						else if($row[$wastage] >= 31 && $row[$wastage] <= 40)
							$serieses[$i]['color'] = "#3366ff";
						else if($row[$wastage] >= 41 && $row[$wastage] <= 50)
							$serieses[$i]['color'] = "#EBB035";
						else if($row[$wastage] <= 30)
							$serieses[$i]['color'] = "#0B7546";
					}elseif($vaccineId==2 || $vaccineId==11){
						if($row[$wastage] >= 20)
							$serieses[$i]['color'] = "#DD1E2F";
						else if($row[$wastage] >= 11 && $row[$wastage] <= 20)
							$serieses[$i]['color'] = "#EBB035";
						else if($row[$wastage] <= 10)
							$serieses[$i]['color'] = "#0B7546";
					}elseif($vaccineId==7){
						if($row[$wastage] >= 5)
							$serieses[$i]['color'] = "#DD1E2F";
						else if($row[$wastage] <= 5)
							$serieses[$i]['color'] = "#0B7546";
					}elseif($vaccineId==90 || $vaccineId==38 || $vaccineId==89 || $vaccineId==3 || $vaccineId==12){
						if($row[$wastage] >= 30)
							$serieses[$i]['color'] = "#DD1E2F";
						else if($row[$wastage] >= 11 && $row[$wastage] <= 20)
							$serieses[$i]['color'] = "#3366ff";
						else if($row[$wastage] >= 21 && $row[$wastage] <= 30)
							$serieses[$i]['color'] = "#EBB035";
						else if($row[$wastage] <= 10)
							$serieses[$i]['color'] = "#0B7546";
					}elseif($vaccineId==8 || $vaccineId==37 || $vaccineId==1 || $vaccineId==4){
						if($row[$wastage] >= 10)
							$serieses[$i]['color'] = "#DD1E2F";
						else if($row[$wastage] >= 6 && $row[$wastage] <= 10)
							$serieses[$i]['color'] = "#EBB035";
						else if($row[$wastage] <= 5)
							$serieses[$i]['color'] = "#0B7546";
					}
					$serieses[$i]['y'] = $row[$wastage];
				}else
					$serieses[$i]['value'] = $row[$wastage];
				 
			}
			if($ranking){
				foreach ($serieses as $key => $value) {
					$compliance[$key] = $value['y'];
				}
				array_multisort($compliance, SORT_DESC, $serieses);
			}
			if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
			}
			if($ranking){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}if($map){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}
		}
		$data['OpenVialWastage']=$this -> Indicator_reports_model -> consumptionIndicator($data);
		$openvialwastagerate=end($data['OpenVialWastage']);
		$value=$openvialwastagerate[$record];
		return $value;	
	}
	function Outbreak($casetype='Msl',$filters,$table='case_investigation_db',$code='3',$type='province',$map=false,$ranking=false,$record='Total Epid',$category=false)
	{
		$startCount = 1;
		$endCount = 54;
		$year=$filters['year'];
		//echo getMonthsEpiWeeks($filters['year'],12);exit;
		switch($filters['period']){
			case 'yearly':
				$startCount = 1;
				$endCount = ($filters['year'] == date('Y',strtotime('first day of previous month')))?getMonthsEpiWeeks($filters['year'],date('n')):getMonthsEpiWeeks($filters['year'],12);
				break;
			case 'biyearly':
				if($filters['biyear'] == 1 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
					$startCount = 1;
					$endCount = getMonthsEpiWeeks($filters['year'],date('n'));
				}else if($filters['biyear'] == 2 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) > 6 && date('n',strtotime('first day of previous month')) < 12){
					$startCount = getMonthsEpiWeeks($filters['year'],7);
					$endCount = getMonthsEpiWeeks($filters['year'],date('n'));
				}else if($filters['biyear'] == 1){
					$startCount = 1;
					$endCount = getMonthsEpiWeeks($filters['year'],6);
				}else if($filters['biyear'] == 2){
					$startCount = getMonthsEpiWeeks($filters['year'],7);
					$endCount = getMonthsEpiWeeks($filters['year'],12);
				}
				break;
			case 'quarterly':
				switch((int)$filters['quarter']){
					case 1:
						$startCount = 1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 3)
							$endCount = getMonthsEpiWeeks($filters['year'],date('n'));
						else
							$endCount = getMonthsEpiWeeks($filters['year'],3);
						break;
					case 2:
						$startCount = getMonthsEpiWeeks($filters['year'],3)+1 ;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6)
							$endCount = getMonthsEpiWeeks($filters['year'],date('n'));
						else
							$endCount = getMonthsEpiWeeks($filters['year'],6);
						break;
					case 3:
						$startCount = getMonthsEpiWeeks($filters['year'],6)+1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 9)
							$endCount = getMonthsEpiWeeks($filters['year'],date('n'));
						else
							$endCount = getMonthsEpiWeeks($filters['year'],9);
						break;
					case 4:
						$startCount = getMonthsEpiWeeks($filters['year'],9)+1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 12)
							$endCount = getMonthsEpiWeeks($filters['year'],date('n'));
						else
							$endCount = getMonthsEpiWeeks($filters['year'],12);
						break;
				}
				break;
			case 'monthly':
				$startCount = getMonthsEpiWeeks($filters['year'],$filters['month']);
				$endCount = getMonthsEpiWeeks($filters['year'],$filters['month']);
				break;
			default:
				$startCount = getMonthsEpiWeeks($filters['year'],1);
				$endCount = getMonthsEpiWeeks($filters['year'],12);
				break;
		}
		/* echo $startCount;
		echo'</br>';
		echo $endCount;
		echo'</br>';
		echo $casetype;
		echo'</br>';
		echo $table; */
		//exit;
			if($casetype == 'Nnt'  ){
				$w_casetype='';
				$patient_address_uncode='nnt_uncode';
			}
			elseif($casetype == 'Afp'){
				$w_casetype='';
				$patient_address_uncode='patient_address_uncode';
			}
			else{
				$w_casetype="AND case_type = '".$casetype."'";
				$patient_address_uncode='patient_address_uncode';
			}
			//echo $w_casetype;exit;
			if($map){
					$query="SELECT districts.distcode as code,districtname(districts.distcode) as name, CASE WHEN b.outbreak > 0 THEN b.outbreak ELSE 0 END as val ,districts.highchart_coordinates as path 
							FROM districts 
								LEFT JOIN (SELECT code,SUM(outbreak) AS outbreak FROM 
												(SELECT  distcode AS code ,fweek,CASE WHEN count(*)>=5 THEN 1 ELSE 0 END AS outbreak 
													FROM {$table} 
														WHERE fweek BETWEEN '{$year}-{$startCount}' and '{$year}-{$endCount}' {$w_casetype} AND procode='{$code}' AND length({$patient_address_uncode})=9 
															GROUP BY {$patient_address_uncode},fweek,distcode order by fweek) AS a GROUP BY code) AS b 
																ON districts.distcode=b.code ORDER BY districts.distcode";
					$result=$this->db->query($query);
					$result=$result->result_array();
					//print_r($result);exit;
				$compliance = $serieses = array();
				foreach($result as $i => $row){
					$serieses[$i]['name'] = $row['name'];
					$serieses[$i]['id'] = $row['code'];
					$serieses[$i]['path'] = $row['path'];
					if($ranking){
						if($row['val'] >= 1){
							$serieses[$i]['color'] = "#DD1E2F";
						}else if($row['val'] < 1){
							$serieses[$i]['color'] = "#0B7546";
						}
						$serieses[$i]['y'] = $row['val'];
					}else
						$serieses[$i]['value'] = $row['val'];
					 
				}
				if($ranking){
					//echo'test';exit;
					foreach ($serieses as $key => $value) {
						$compliance[$key] = $value['y'];
					}
					array_multisort($compliance, SORT_DESC, $serieses);
				}
				if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
				}
				if($ranking){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}if($map){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}
			}
			
		//--select count(case_epi_no) from case_investigation_db WHERE fweek between '2018-01' and '2018-51' and case_type = 'Msl' AND procode='3';
			if($record=='Total Epid'){
				$this -> db -> select('count(case_epi_no) as totalepid');
				$this -> db -> from($table);
				$this -> db -> where("procode='{$code}' {$w_casetype}");
				where_between("fweek", "'{$year}-{$startCount}'" , "'{$year}-{$endCount}'");  
				$result = $this -> db -> get () -> result_array();
				//echo $this->db->last_query();exit;
				return $result[0]['totalepid'];
			}elseif($record=='Disease Case'){
		//--select sum(outbreak) from (SELECT  fweek,CASE WHEN count(*)>=5 THEN 1 ELSE 0 END as outbreak FROM case_investigation_db WHERE fweek between '2018-01' and '2018-51' and case_type = 'Msl' AND procode='3' AND length(patient_address_uncode)=9 group by patient_address_uncode,fweek order by fweek) as a;
				$query="SELECT CASE WHEN SUM(outbreak) > 0 THEN SUM(outbreak) ELSE 0 END as diseasecase FROM 
											(SELECT  fweek,CASE WHEN count(*)>=5 THEN 1 ELSE 0 END as outbreak 
												FROM {$table} 
													WHERE fweek between '{$year}-{$startCount}' and '{$year}-{$endCount}' {$w_casetype} AND procode='{$code}' AND length({$patient_address_uncode})=9 
														GROUP BY {$patient_address_uncode},fweek 
															ORDER BY fweek
											) AS a";
				$result=$this->db->query($query);
				$result=$result->result_array();
				//echo $this->db->last_query();exit;
				//print_r($result);exit;
				return $result[0]['diseasecase'];
			
		//--select sum(outbreak) from (SELECT  fweek,CASE WHEN count(*)>=5 THEN 1 ELSE 0 END as outbreak FROM case_investigation_db WHERE fweek between '2018-01' and '2018-51'  AND procode='3' AND length(patient_address_uncode)=9 group by patient_address_uncode,fweek order by fweek) as a;
			}elseif($record=='All Case'){
				$query="SELECT CASE WHEN SUM(outbreak) > 0 THEN SUM(outbreak) ELSE 0 END as allcase FROM 
											(SELECT  fweek,CASE WHEN count(*)>=5 THEN 1 ELSE 0 END as outbreak 
												FROM {$table} 
													WHERE fweek between '{$year}-{$startCount}' and '{$year}-{$endCount}' AND procode='{$code}' AND length({$patient_address_uncode})=9 
														GROUP BY {$patient_address_uncode},fweek 
															ORDER BY fweek
											) AS a";
				$result=$this->db->query($query);
				$result=$result->result_array();
				//print_r($result);exit;
				return $result[0]['allcase'];
			}
		
			
	}
	function UcZeroEpi($value='ucwithzeroepi',$filters,$code='3',$type='province',$map=false,$ranking=false,$category=false)
	{
		if($map){
				$query = "Select (districts.distcode) as code,districtname(districts.distcode) as name,CASE WHEN (b.uncode) > 0 THEN (b.uncode) ELSE 0 END as val, districts.highchart_coordinates as path ,b.distcode 
							From districts  LEFT JOIN (Select a.distcode, count(a.uncode) as uncode 
														FROM (SELECT distcode,uncode FROM unioncouncil WHERE uncode NOT IN (SELECT uncode FROM facilities where hf_type='e') AND procode='3' 
																ORDER BY districtname(distcode),un_name) AS a GROUP BY distcode) AS b 
																	ON districts.distcode=b.distcode  
																		ORDER BY districts.distcode";
				$data = $this -> db -> query($query);
				$result= $data->result_array();
				$compliance = $serieses = array();
				foreach($result as $i => $row){
					$serieses[$i]['name'] = $row['name'];
					$serieses[$i]['id'] = $row['code'];
					$serieses[$i]['path'] = $row['path'];
					if($ranking){
						if($row['val'] = 0){
							$serieses[$i]['color'] = "#0B7546";
							//$serieses[$i]['color'] = "#DD1E2F";
						}
						else if($row['val'] > 0){
							$serieses[$i]['color'] = "#DD1E2F";
						}
						/* else if($row['val'] <= 70){
							$serieses[$i]['color'] = "#DD1E2F";
							//$serieses[$i]['color'] = "#0B7546";
						} */
						$serieses[$i]['y'] = $row['val'];
					}else
						$serieses[$i]['value'] = $row['val'];
					 
				}
				if($ranking){
					//echo'test';exit;
					foreach ($serieses as $key => $value) {
						$compliance[$key] = $value['y'];
					}
					array_multisort($compliance, SORT_DESC, $serieses);
				}
				if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
				}
				if($ranking){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}if($map){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}
			}
			$query = "SELECT (SELECT COUNT(*) FROM unioncouncil WHERE procode='{$code}') AS totaluc,
								 (SELECT COUNT(*) FROM unioncouncil WHERE procode='{$code}' AND uncode IN (SELECT uncode FROM facilities WHERE hf_type='e')) AS ucwitattachepi, 
								 COUNT(uncode) AS ucwithzeroepi 
									FROM 
										(SELECT uncode 
											FROM unioncouncil 
												WHERE uncode NOT IN (SELECT uncode FROM facilities WHERE hf_type='e') 
													AND procode='{$code}' ) as a";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			
			if($value=='totaluc')
			return $data[0]['totaluc'];
			if($value=='ucwitattachepi')
			return $data[0]['ucwitattachepi'];
			if($value=='ucwithzeroepi')
			return $data[0]['ucwithzeroepi'];
			//echo $this->db->last_query();exit;
	}
	function FacZeroTech($value='faczerotech',$filters,$code='3',$type='province',$map=false,$ranking=false,$category=false)
	{
		if($map){
				$query = "Select districts.distcode AS code,districtname(districts.distcode) AS name,CASE WHEN (number) > 0 THEN (number) ELSE 0 END as val,districts.highchart_coordinates AS path 
							FROM districts LEFT JOIN (Select a.distcode, count(a.facode) AS number 
								FROM (SELECT distcode,facode FROM facilities 
									WHERE facode NOT IN ( SELECT DISTINCT facode FROM techniciandb WHERE status='Active')
										AND hf_type = 'e' AND procode='{$code}' ORDER BY distcode) AS a Group BY a.distcode) AS b 
											ON districts.distcode=b.distcode  ORDER BY districts.distcode";
				$data = $this -> db -> query($query);
				$result= $data->result_array();
				//echo $this->db->last_query();exit;
				$compliance = $serieses = array();
				foreach($result as $i => $row){
					$serieses[$i]['name'] = $row['name'];
					$serieses[$i]['id'] = $row['code'];
					$serieses[$i]['path'] = $row['path'];
					if($ranking){
					if($row['val'] == 0){
						$serieses[$i]['color'] = "#0B7546";
					}
					else if($row['val'] >=0 && $row['val'] <= 10){
						$serieses[$i]['color'] = "#3366FF";
					}
					else if($row['val'] >=10 && $row['val'] <= 50){
						$serieses[$i]['color'] = "#EBB035";
					}else if($row['val'] >=50){
						$serieses[$i]['color'] = "#DD1E2F";
					}
						$serieses[$i]['y'] = $row['val'];
					}else
						$serieses[$i]['value'] = $row['val'];
					 
				}
				if($ranking){
					//echo'test';exit;
					foreach ($serieses as $key => $value) {
						$compliance[$key] = $value['y'];
					}
					array_multisort($compliance, SORT_DESC, $serieses);
				}
				if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
				}
				if($ranking){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}if($map){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}
			}
			$query = "Select (SELECT count(*) FROM facilities WHERE hf_type='e' AND procode='{$code}') AS totalfac ,
								(SELECT count(*) FROM facilities WHERE hf_type='e' AND procode='{$code}' AND facode IN ( SELECT DISTINCT facode FROM techniciandb WHERE status='Active')) AS facattachtech, 
								count(a.facode) AS faczerotech 
									FROM 
										(SELECT facode,distcode FROM facilities 
											WHERE facode NOT IN ( SELECT DISTINCT facode FROM techniciandb WHERE status='Active') 
												AND hf_type = 'e' AND procode='{$code}' 
													ORDER BY districtname(distcode), fac_name ) as a;";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			if($value=='totalfac')
			return $data[0]['totalfac'];
			if($value=='facattachtech')
			return $data[0]['facattachtech'];
			if($value=='faczerotech')
			return $data[0]['faczerotech'];
			//echo $this->db->last_query();exit;
	}
	function FacNoIlr($value='faczeroilr',$filters,$code='3',$type='province',$map=false,$ranking=false,$category=false)
	{
		if($map){
				$query = "Select districts.distcode AS code,districtname(districts.distcode) AS name,CASE WHEN (number) > 0 THEN (number) ELSE 0 END as val,districts.highchart_coordinates AS path 
							FROM districts LEFT JOIN (Select a.distcode, count(a.facode) AS number 
								FROM (SELECT distcode,facode FROM facilities 
									WHERE facode IN ( select distinct(facode) from  epi_cc_coldchain_main where ccm_sub_asset_type_id=13 and facode is not null)
										AND hf_type = 'e' AND procode='{$code}' ORDER BY distcode) AS a Group BY a.distcode) AS b 
											ON districts.distcode=b.distcode  ORDER BY districts.distcode";
				$data = $this -> db -> query($query);
				$result= $data->result_array();
				//echo $this->db->last_query();exit;
				$compliance = $serieses = array();
				foreach($result as $i => $row){
					$serieses[$i]['name'] = $row['name'];
					$serieses[$i]['id'] = $row['code'];
					$serieses[$i]['path'] = $row['path'];
					if($ranking){
						if($row['val'] == 0){
						$serieses[$i]['color'] = "#DD1E2F";
					}
					else if($row['val'] >=0 && $row['val'] <= 10){
						$serieses[$i]['color'] = "#3366FF";
					}
					else if($row['val'] >=10 && $row['val'] <= 50){
						$serieses[$i]['color'] = "#EBB035";
					}else if($row['val'] >=50){
						$serieses[$i]['color'] = "#0B7546";
					}
						$serieses[$i]['y'] = $row['val'];
					}else
						$serieses[$i]['value'] = $row['val'];
					 
				}
				if($ranking){
					//echo'test';exit;
					foreach ($serieses as $key => $value) {
						$compliance[$key] = $value['y'];
					}
					array_multisort($compliance, SORT_DESC, $serieses);
				}
				if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
				}
				if($ranking){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}if($map){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}
			}
			$query = "Select (SELECT count(*) FROM facilities WHERE hf_type='e' AND procode='{$code}') AS totalfac ,
								(SELECT count(*) FROM facilities WHERE hf_type='e' AND procode='{$code}' AND facode IN ( select distinct(facode) from  epi_cc_coldchain_main where ccm_sub_asset_type_id=13 and facode is not null)) AS facattachIlr, 
								count(a.facode) AS faczeroIlr 
									FROM 
										(SELECT facode,distcode FROM facilities 
											WHERE facode NOT IN (  select distinct(facode) from  epi_cc_coldchain_main where ccm_sub_asset_type_id=13 and facode is not null) 
												AND hf_type = 'e' AND procode='{$code}' 
													ORDER BY districtname(distcode), fac_name ) as a;";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			//print_r($data);exit;
		//	echo $this->db->last_query();exit;
			//print_r($value);exit;
			if($value=='totalfac')
				return $data[0]['totalfac'];
			if($value=='facattachilr')
				return $data[0]['facattachilr'];
			if($value=='faczeroilr')
				return $data[0]['faczeroilr'];
			//echo $this->db->last_query();exit;
	}
	function VaccinatorToPopulationRatio($value='ratio',$filters,$code='3',$type='province',$map=false,$ranking=false,$category=false)
	{
		$year=$filters['year'];
		if($map){
				$query = "Select districts.distcode AS code,districtname(districts.distcode) AS name,
							CASE WHEN (ratio ) > 0 THEN (ratio ) ELSE 0 END as val,districts.highchart_coordinates AS path 
								FROM districts LEFT JOIN 
									(Select a.distcode ,ROUND(a.totalpop/a.totaltech) AS ratio FROM (SELECT dp.distcode,SUM(dp.population) AS totalpop,(SELECT COUNT(*) FROM techniciandb WHERE status='Active'  AND distcode=dp.distcode) AS totaltech  
										From districts_population dp WHERE procode='3' AND year='2019' Group BY dp.distcode) as a )AS b 
											ON districts.distcode=b.distcode ORDER BY districts.distcode";
				$data = $this -> db -> query($query);
				$result= $data->result_array();
				//echo $this->db->last_query();exit;
				$compliance = $serieses = array();
				foreach($result as $i => $row){
					$serieses[$i]['name'] = $row['name'];
					$serieses[$i]['id'] = $row['code'];
					$serieses[$i]['path'] = $row['path'];
					if($ranking){
						if($row['val'] >= 20000){
						//$serieses[$i]['color'] = "#0B7546";
						$serieses[$i]['color'] = "#DD1E2F";
					}
					else if($row['val'] <= 20000 && $row['val'] >= 10000){
						$serieses[$i]['color'] = "#EBB035";
					}
					else if($row['val'] <= 10000){
						//$serieses[$i]['color'] = "#DD1E2F";
						$serieses[$i]['color'] = "#0B7546";
					}
						$serieses[$i]['y'] = $row['val'];
					}else
						$serieses[$i]['value'] = $row['val'];
					 
				}
				if($ranking){
					//echo'test';exit;
					foreach ($serieses as $key => $value) {
						$compliance[$key] = $value['y'];
					}
					array_multisort($compliance, SORT_DESC, $serieses);
				}
				if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
				}
				if($ranking){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}if($map){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}
			}
			$query = "SELECT SUM(population) AS totalpop,
						(SELECT COUNT(*) FROM techniciandb WHERE status='Active'  ) AS totaltech ,
						ROUND(SUM(population)/(SELECT COUNT(*) FROM techniciandb WHERE status='Active' )) AS ratio 
							FROM districts_population 
								WHERE procode='{$code}' AND year='{$year}' 
									Group by procode";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			//print_r($data);exit;
		//	echo $this->db->last_query();exit;
			//print_r($value);exit;
			if($value=='totalpop')
				return $data[0]['totalpop'];
			if($value=='totaltech')
				return $data[0]['totaltech'];
			if($value=='ratio')
				return $data[0]['ratio'];
			//echo $this->db->last_query();exit;
	}
	public function AccessAndUtilization($value='cat1sum',$filters,$code='3',$type='province',$map=false,$ranking=false,$category=false){
		
		$year = $filters['year'];
		$startMonth = 1;
		$endMonth = 12;
		switch($filters['period']){
			case 'yearly':
				$startMonth = 1;
				$endMonth = ($filters['year'] == date('Y',strtotime('first day of previous month')))?date('n',strtotime('first day of previous month')):12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
			case 'biyearly':
				if($filters['biyear'] == 1 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
					$startMonth = 1;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 2 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) > 6 && date('n',strtotime('first day of previous month')) < 12){
					$startMonth = 7;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 1){
					$startMonth = 1;
					$endMonth = 6;
					$where = "fmonth between '{$year}-01' AND '{$year}-06'";
				}else if($filters['biyear'] == 2){
					$startMonth = 7;
					$endMonth = 12;
					$where = "fmonth between '{$year}-07' AND '{$year}-12'";
				}
				break;
			case 'quarterly':
				switch((int)$filters['quarter']){
					case 1:
						$startMonth = 1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 3){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 3;
							$where = "fmonth between '{$year}-01' AND '{$year}-03'";
						}
						break;
					case 2:
						$startMonth = 4;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-04' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 6;
							$where = "fmonth between '{$year}-04' AND '{$year}-06'";
						}
						break;
					case 3:
						$startMonth = 7;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 9){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 9;
							$where = "fmonth between '{$year}-07' AND '{$year}-09'";
						}
						break;
					case 4:
						$startMonth = 10;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 12){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-10' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 12;
							$where = "fmonth between '{$year}-10' AND '{$year}-12'";
						}
						break;
				}
				break;
			case 'monthly':
				$startMonth = (int) $filters['month'];
				$endMonth = (int) $filters['month'];
				$month = $filters['month'];
				$where = "fmonth = '".$year.'-'.$month."'";
				break;
			default:
				$startMonth = 1;
				$endMonth = 12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
		}
		$startMonth = sprintf('%02d',$startMonth);
		$endMonth = sprintf('%02d',$endMonth);
		if($map){
			$query = "SELECT districts.distcode AS code,districtname(districts.distcode) AS name, districts.highchart_coordinates AS path,
								(case when (cat1 > 0)then 1 else 0 end) AS cat1,
								(case when (cat2 > 0)then 1 else 0 end) AS cat2,
								(case when (cat3 > 0)then 1 else 0 end) AS cat3,
								(case when (cat4 > 0)then 1 else 0 end) AS cat4 
									FROM districts 
									LEFT JOIN  
										(SELECT distcode, 
											SUM(case when (Access >= 80) and (utilization < 10) then 1 else 0 end) AS cat1,
											SUM(case when (Access >= 80) and (utilization >= 10) then 1 else 0 end) AS cat2,
											SUM(case when (Access < 80) and (utilization < 10) then 1 else 0 end) AS cat3, 
											SUM(case when (Access < 80) and (utilization >= 10) then 1 else 0 end) AS cat4 
												FROM(select distcode, 
													round(((sumvaccinevacination(7,fac_mvrf_db.distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.distcode,'district','{$year}','{$startMonth}','{$year}','{$endMonth}') :: float,0))*100):: numeric,0) as Access, 
													round(((sumvaccinevacination(7,fac_mvrf_db.distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'):: float,0) :: numeric)*100 ,1) as utilization 
														FROM fac_mvrf_db 
														WHERE procode = '{$code}' and distcode in (select distinct distcode from unioncouncil_population where year = '{$year}') 
														GROUP by distcode order by distcode)as a group by distcode) AS b 
															ON districts.distcode=b.distcode ORDER BY districts.distcode";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			//print_r($data);exit;
			$compliance = $serieses = array();
			foreach($data as $i => $row){
				$serieses[$i]['name'] = $row['name'];
				$serieses[$i]['id'] = $row['code'];
				$serieses[$i]['path'] = $row['path'];
				if($ranking){
					
					if($row['cat1'] > 0){
						$serieses[$i]['color'] = "#0B7546";
						$test=1;
						//#0B7546 green//#3366FF blue//#EBB035 yellow//#DD1E2F red
					}
					else if($row['cat2'] > 0 ){
						$serieses[$i]['color'] = "#3366FF";
						$test=2;
					}
					else if($row['cat3'] > 0){
						$serieses[$i]['color'] = "#EBB035";
						$test=3;
					}
					else if($row['cat4'] > 0){
						$serieses[$i]['color'] = "#DD1E2F";
						$test=4;
					}else{
						$serieses[$i]['color'] = "#efefef";
						$test=0;
					}
					$serieses[$i]['y'] = $test;
				}else{
					if($row['cat1'] > 0){
						$test=1;
						//#0B7546 green//#3366FF blue//#EBB035 yellow//#DD1E2F red
					}
					else if($row['cat2'] > 0 ){
						$test=2;
					}
					else if($row['cat3'] > 0){
						$test=3;
					}
					else if($row['cat4'] > 0){
						$test=4;
					}else{
						$test=0;
					}
				}
					$serieses[$i]['value'] = $test;
			}
			if($ranking){
				foreach ($serieses as $key => $value) {
					$compliance[$key] = $value['y'];
				}
				array_multisort($compliance, SORT_DESC, $serieses);
			}
			if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
				}
				if($ranking){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}if($map){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}
		}
		//--select a.procode,a.access,a.utilization  ,case when (Access >= 80) and (utilization < 10) then 1 else 0 end as cat1 from (select procode,	 round(((sumvaccinevacination(7,fac_mvrf_db.procode,'2019-01','2019-09')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.procode,'province','2019','01','2019','09') :: float,0))*100):: numeric,0) as Access,								round(((sumvaccinevacination(7,fac_mvrf_db.procode,'2019-01','2019-09') :: numeric - sumvaccinevacination(9,fac_mvrf_db.procode,'2019-01','2019-09'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.procode,'2019-01','2019-09'):: float,0) :: numeric)*100 ,1) as utilization from fac_mvrf_db where procode = '3' and distcode in (select distinct distcode from unioncouncil_population where year = '2019') group by procode order by procode) as a group by a.procode,a.access,a.utilization;
		/* $query = "SELECT SUM(cat1) AS cat1sum,SUM(cat2) AS cat2sum,SUM(cat3) AS cat3sum,SUM(cat4) AS cat4sum 
					FROM(SELECT distcode,
							SUM(case when (Access >= 80) and (utilization < 10) then 1 else 0 end) AS cat1,
							SUM(case when (Access >= 80) and (utilization >= 10) then 1 else 0 end) AS cat2,
							SUM(case when (Access < 80) and (utilization < 10) then 1 else 0 end) AS cat3,
							SUM(case when (Access < 80) and (utilization >= 10) then 1 else 0 end) AS cat4 
								FROM(select distcode,uncode,
										round(((sumvaccinevacination(7,fac_mvrf_db.uncode,'{$year}-{$startMonth}','{$year}-{$endMonth}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.uncode,'unioncouncil','{$year}','{$startMonth}','{$year}','{$endMonth}') :: float,0))*100):: numeric,0) as Access,
										round(((sumvaccinevacination(7,fac_mvrf_db.uncode,'{$year}-{$startMonth}','{$year}-{$endMonth}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.uncode,'{$year}-{$startMonth}','{$year}-{$endMonth}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.uncode,'{$year}-{$startMonth}','{$year}-{$endMonth}'):: float,0) :: numeric)*100 ,1) as utilization 
											FROM fac_mvrf_db 
											WHERE procode = '{$code}' and distcode in (select distinct distcode from unioncouncil_population where year = '{$year}') 
											Group BY distcode,uncode order by distcode,uncode)as a group by distcode) as b"; */
				$query = "SELECT SUM(cat1) AS cat1sum,SUM(cat2) AS cat2sum,SUM(cat3) AS cat3sum,SUM(cat4) AS cat4sum 
					FROM(SELECT distcode,
							SUM(case when (Access >= 80) and (utilization < 10) then 1 else 0 end) AS cat1,
							SUM(case when (Access >= 80) and (utilization >= 10) then 1 else 0 end) AS cat2,
							SUM(case when (Access < 80) and (utilization < 10) then 1 else 0 end) AS cat3,
							SUM(case when (Access < 80) and (utilization >= 10) then 1 else 0 end) AS cat4 
								FROM(select distcode,
										round(((sumvaccinevacination(7,fac_mvrf_db.distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.distcode,'districts','{$year}','{$startMonth}','{$year}','{$endMonth}') :: float,0))*100):: numeric,0) as Access,
										round(((sumvaccinevacination(7,fac_mvrf_db.distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'):: float,0) :: numeric)*100 ,1) as utilization 
											FROM fac_mvrf_db 
											WHERE procode = '{$code}' and distcode in (select distinct distcode from unioncouncil_population where year = '{$year}') 
											Group BY distcode order by distcode)as a group by distcode) as b"; 
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			$query = "SELECT (CASE WHEN (cat1 > 0) THEN '1st' WHEN (cat2 > 0) THEN '2nd' WHEN (cat3 > 0) THEN '3rd' WHEN (cat4 > 0) THEN 'No Rec' ELSE 'No Rec' END) as category 
						FROM (SELECT 
								case when (Access >= 80) and (utilization < 10) then 1 else 0 end as cat1,
								case when (Access >= 80) and (utilization >= 10) then 1 else 0 end as cat2,
								case when (Access < 80) and (utilization < 10) then 1 else 0 end as cat3,
								case when (Access < 80) and (utilization >= 10) then 1 else 0 end as cat4 
									FROM (SELECT procode, 
										round(((sumvaccinevacination(7,fac_mvrf_db.procode,'{$year}-{$startMonth}','{$year}-{$endMonth}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.procode,'province','{$year}','{$startMonth}','{$year}','{$endMonth}') :: float,0))*100):: numeric,0) as Access, 
										round(((sumvaccinevacination(7,fac_mvrf_db.procode,'{$year}-{$startMonth}','{$year}-{$endMonth}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.procode,'{$year}-{$startMonth}','{$year}-{$endMonth}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.procode,'{$year}-{$startMonth}','{$year}-{$endMonth}'):: float,0) :: numeric)*100 ,1) as utilization 
											FROM fac_mvrf_db 
											WHERE procode = '{$code}' AND distcode IN (select distinct distcode from unioncouncil_population where year = '{$year}') 
											Group BY procode ORDER BY procode) AS a ) as b";
			$result = $this -> db -> query($query);
			$dataprovince= $result->result_array();
			if($value=='cat1sum')
				return $data[0]['cat1sum'];
			if($value=='cat2sum')
				return $data[0]['cat2sum'];
			if($value=='cat3sum')
				return $data[0]['cat3sum'];
			if($value=='cat4sum')
				return $data[0]['cat4sum'];
			if($value=='category')
				return $dataprovince[0]['category'];
			
	}
	function Dropout($record='Penta1-Measle1 dropout Total',$filters,$code='3',$type='province',$map=false,$ranking=false,$category=false)
	{
		$year = $filters['year'];
		$startMonth = 1;
		$endMonth = 12;
		switch($filters['period']){
			case 'yearly':
				$startMonth = 1;
				$endMonth = ($filters['year'] == date('Y',strtotime('first day of previous month')))?date('n',strtotime('first day of previous month')):12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
			case 'biyearly':
				if($filters['biyear'] == 1 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
					$startMonth = 1;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 2 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) > 6 && date('n',strtotime('first day of previous month')) < 12){
					$startMonth = 7;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 1){
					$startMonth = 1;
					$endMonth = 6;
					$where = "fmonth between '{$year}-01' AND '{$year}-06'";
				}else if($filters['biyear'] == 2){
					$startMonth = 7;
					$endMonth = 12;
					$where = "fmonth between '{$year}-07' AND '{$year}-12'";
				}
				break;
			case 'quarterly':
				switch((int)$filters['quarter']){
					case 1:
						$startMonth = 1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 3){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 3;
							$where = "fmonth between '{$year}-01' AND '{$year}-03'";
						}
						break;
					case 2:
						$startMonth = 4;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-04' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 6;
							$where = "fmonth between '{$year}-04' AND '{$year}-06'";
						}
						break;
					case 3:
						$startMonth = 7;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 9){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 9;
							$where = "fmonth between '{$year}-07' AND '{$year}-09'";
						}
						break;
					case 4:
						$startMonth = 10;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 12){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-10' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 12;
							$where = "fmonth between '{$year}-10' AND '{$year}-12'";
						}
						break;
				}
				break;
			case 'monthly':
				$startMonth = (int) $filters['month'];
				$endMonth = (int) $filters['month'];
				$month = $filters['month'];
				$where = "fmonth = '".$year.'-'.$month."'";
				break;
			default:
				$startMonth = 1;
				$endMonth = 12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
		}
		$startMonth = sprintf('%02d',$startMonth);
		$endMonth = sprintf('%02d',$endMonth);
		
		
		if($map){
			
			$query = "SELECT districts.distcode AS code,districtname(districts.distcode) AS name, districts.highchart_coordinates AS path,
						(case when (\"Penta1-Measle1 dropout Total\" > 0 or \"Penta1-Measle1 dropout Total\" < 0) then \"Penta1-Measle1 dropout Total\" else 0 end) as \"Penta1-Measle1 dropout Total\",
						(case when (\"Penta1-Penta3 dropout Total\" > 0 or \"Penta1-Penta3 dropout Total\" < 0) then \"Penta1-Penta3 dropout Total\" else 0 end) as \"Penta1-Penta3 dropout Total\",
						(case when (\"Measles1-Measles2 dropout Total\" > 0 or \"Measles1-Measles2 dropout Total\" < 0) then \"Measles1-Measles2 dropout Total\" else 0 end) as \"Measles1-Measles2 dropout Total\",
						(case when (\"TT1-TT2 dropout Total\" > 0 or \"TT1-TT2 dropout Total\" < 0) then \"TT1-TT2 dropout Total\" else 0 end) as \"TT1-TT2 dropout Total\"
							FROM districts 
								LEFT JOIN	(SELECT distcode , districtname(distcode), 
												ROUND((COALESCE((sum(coalesce(cri_r25_f7))+sum(coalesce(cri_r26_f7))-sum(coalesce(cri_r25_f16))-sum(coalesce(cri_r26_f16))) // NULLIF(sum(coalesce(cri_r25_f7))+sum(coalesce(cri_r26_f7)),0), 0)*100)::numeric) AS \"Penta1-Measle1 dropout Total\",
												ROUND((COALESCE((sum(coalesce(cri_r25_f7))+sum(coalesce(cri_r26_f7))-sum(coalesce(cri_r25_f9))-sum(coalesce(cri_r26_f9))) // NULLIF(sum(coalesce(cri_r25_f7))+sum(coalesce(cri_r26_f7)),0), 0)*100)::numeric) AS \"Penta1-Penta3 dropout Total\",
												ROUND((COALESCE((sum(coalesce(cri_r25_f16))+sum(coalesce(cri_r26_f16))-sum(coalesce(cri_r25_f18))-sum(coalesce(cri_r26_f18))) // NULLIF(sum(coalesce(cri_r25_f16))+sum(coalesce(cri_r26_f16)),0), 0)*100)::numeric) AS \"Measles1-Measles2 dropout Total\",
												ROUND((COALESCE((sum(coalesce(ttri_r9_f1))+sum(coalesce(ttri_r10_f1))-sum(coalesce(ttri_r9_f2))-sum(coalesce(ttri_r10_f2))) // NULLIF(sum(coalesce(ttri_r9_f1))+sum(coalesce(ttri_r10_f1)),0), 0)*100)::numeric) AS \"TT1-TT2 dropout Total\" 
													FROM fac_mvrf_db 
													WHERE fmonth BETWEEN '{$year}-{$startMonth}' AND '{$year}-{$endMonth}' 
													GROUP BY distcode ORDER BY districtname(distcode)) as a 
														ON districts.distcode=a.distcode ORDER BY districts.distcode";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			//print_r($data);exit;
			$compliance = $serieses = array();
			//$result = $this -> db -> get() -> result_array();
			foreach($data as $i => $row){
				$serieses[$i]['name'] = $row['name'];
				$serieses[$i]['id'] = $row['code'];
				$serieses[$i]['path'] = $row['path'];
				if($ranking){
					if($row[$record] >= 10){
						$serieses[$i]['color'] = "#DD1E2F";
					}else if($row[$record] <= 10){
						$serieses[$i]['color'] = "#0B7546";
					}
					$serieses[$i]['y'] = $row[$record];
				}else
					$serieses[$i]['value'] = $row[$record];
			}
			if($ranking){
				foreach ($serieses as $key => $value) {
					$compliance[$key] = $value['y'];
				}
				array_multisort($compliance, SORT_DESC, $serieses);
			}
			if($category){
			$names = array_column($serieses, 'name');
			return (json_encode($names,JSON_NUMERIC_CHECK));
			}
			if($ranking){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}if($map){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}
		}
		$query = "SELECT 
						ROUND((COALESCE((sum(coalesce(cri_r25_f7)) - sum(coalesce(cri_r25_f16))) // NULLIF(sum(coalesce(cri_r25_f7)),0), 0)*100)::numeric) AS \"Penta1-Measle1 dropout Male\",
						ROUND((COALESCE((sum(coalesce(cri_r26_f7)) - sum(coalesce(cri_r26_f16))) // NULLIF(sum(coalesce(cri_r26_f7)),0), 0)*100)::numeric) AS \"Penta1-Measle1 dropout Female\",
						ROUND((COALESCE((sum(coalesce(cri_r25_f7))+sum(coalesce(cri_r26_f7))-sum(coalesce(cri_r25_f16))-sum(coalesce(cri_r26_f16))) // NULLIF(sum(coalesce(cri_r25_f7))+sum(coalesce(cri_r26_f7)),0), 0)*100)::numeric) AS \"Penta1-Measle1 dropout Total\",
						
						ROUND((COALESCE((sum(coalesce(cri_r25_f7)) - sum(coalesce(cri_r25_f9))) // NULLIF(sum(coalesce(cri_r25_f7)),0), 0)*100)::numeric) AS \"Penta1-Penta3 dropout Male\",
						ROUND((COALESCE((sum(coalesce(cri_r26_f7)) - sum(coalesce(cri_r26_f9))) // NULLIF(sum(coalesce(cri_r26_f7)),0), 0)*100)::numeric) AS \"Penta1-Penta3 dropout Female\",
						ROUND((COALESCE((sum(coalesce(cri_r25_f7))+sum(coalesce(cri_r26_f7))-sum(coalesce(cri_r25_f9))-sum(coalesce(cri_r26_f9))) // NULLIF(sum(coalesce(cri_r25_f7))+sum(coalesce(cri_r26_f7)),0), 0)*100)::numeric) AS \"Penta1-Penta3 dropout Total\",
						
						ROUND((COALESCE((sum(coalesce(cri_r25_f16)) - sum(coalesce(cri_r25_f18))) // NULLIF(sum(coalesce(cri_r25_f16)),0), 0)*100)::numeric) AS \"Measles1-Measles2 dropout Male\",
						ROUND((COALESCE((sum(coalesce(cri_r26_f16)) - sum(coalesce(cri_r26_f18))) // NULLIF(sum(coalesce(cri_r26_f16)),0), 0)*100)::numeric) AS \"Measles1-Measles2 dropout Female\",
						ROUND((COALESCE((sum(coalesce(cri_r25_f16))+sum(coalesce(cri_r26_f16))-sum(coalesce(cri_r25_f18))-sum(coalesce(cri_r26_f18))) // NULLIF(sum(coalesce(cri_r25_f16))+sum(coalesce(cri_r26_f16)),0), 0)*100)::numeric) AS \"Measles1-Measles2 dropout Total\",
						
						ROUND((COALESCE((sum(coalesce(ttri_r9_f1)) - sum(coalesce(ttri_r9_f2))) // NULLIF(sum(coalesce(ttri_r9_f1)),0), 0)*100)::numeric) AS \"TT1-TT2 dropout Male\",
						ROUND((COALESCE((sum(coalesce(ttri_r10_f1)) - sum(coalesce(ttri_r10_f2))) // NULLIF(sum(coalesce(ttri_r10_f1)),0), 0)*100)::numeric) AS \"TT1-TT2 dropout Female\",
						ROUND((COALESCE((sum(coalesce(ttri_r9_f1))+sum(coalesce(ttri_r10_f1))-sum(coalesce(ttri_r9_f2))-sum(coalesce(ttri_r10_f2))) // NULLIF(sum(coalesce(ttri_r9_f1))+sum(coalesce(ttri_r10_f1)),0), 0)*100)::numeric) AS \"TT1-TT2 dropout Total\" 
							FROM fac_mvrf_db 
								WHERE fmonth BETWEEN '{$year}-{$startMonth}' AND '{$year}-{$endMonth}' ";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			//print_r($data);exit;
			if($record=='Penta1-Measle1 dropout Total')
				return $data[0]['Penta1-Measle1 dropout Total'];
			if($record=='Penta1-Measle1 dropout Male')
				return $data[0]['Penta1-Measle1 dropout Male'];
			if($record=='Penta1-Measle1 dropout Female')
				return $data[0]['Penta1-Measle1 dropout Female'];
			if($record=='Measles1-Measles2 dropout Total')
				return $data[0]['Measles1-Measles2 dropout Total'];
			if($record=='Measles1-Measles2 dropout Male')
				return $data[0]['Measles1-Measles2 dropout Male'];
			if($record=='Measles1-Measles2 dropout Female')
				return $data[0]['Measles1-Measles2 dropout Female'];
			if($record=='Penta1-Penta3 dropout Total')
				return $data[0]['Penta1-Penta3 dropout Total'];
			if($record=='Penta1-Penta3 dropout Male')
				return $data[0]['Penta1-Penta3 dropout Male'];
			if($record=='Penta1-Penta3 dropout Female')
				return $data[0]['Penta1-Penta3 dropout Female'];
			if($record=='TT1-TT2 dropout Total')
				return $data[0]['TT1-TT2 dropout Total'];
			if($record=='TT1-TT2 dropout Male')
				return $data[0]['TT1-TT2 dropout Male'];
			if($record=='TT1-TT2 dropout Female')
				return $data[0]['TT1-TT2 dropout Female'];
		//SELECT filled,sanctioned,round((filled//sanctioned)*100) as persent from (select distcode, count(*) as filled ,(select sum(epi_tech) from sanctioned_posts_db where distcode=techniciandb.distcode) as sanctioned from techniciandb where status='Active' group by distcode) as a
	}
	function SanctionedVsFilledPost($post='epi_tech',$value='persent',$table='techniciandb',$filters,$code='3',$type='province',$map=false,$ranking=false,$category=false)
	{
		if($map){
			if($post=='epi_coordinator'){
				$wc_type="AND supervisor_type='EPI Coordinator'";
			}elseif($post=='dsv'){
				$wc_type="AND supervisor_type='District Superintendent Vaccinator'";
			}elseif($post=='tsv'){
				$wc_type="AND supervisor_type='Tehsil Superintendent Vaccinator'";
			}elseif($post=='asv'){
				$wc_type="AND supervisor_type='Assistant Superintendent Vaccinator'";
			}else{
				$wc_type='';
			}
			
			
				$query = "SELECT (districts.distcode) as code,districtname(districts.distcode) AS name,  
							(case when round((filled//sanctioned)*100) > 0 then round((filled//sanctioned)*100) else 0 end) as val,
							districts.highchart_coordinates AS path 
								FROM districts LEFT JOIN (SELECT 
															distcode, count(*) as filled,
																(select sum({$post}) from sanctioned_posts_db where distcode={$table}.distcode) as sanctioned 
																from {$table}
																where status='Active' {$wc_type} group by distcode) as a  
																		ON districts.distcode=a.distcode ORDER BY districts.distcode";
				$data = $this -> db -> query($query);
				$result= $data->result_array();
				//print_r($result);exit;
				//echo $this->db->last_query();exit;
				$compliance = $serieses = array();
				foreach($result as $i => $row){
					$serieses[$i]['name'] = $row['name'];
					$serieses[$i]['id'] = $row['code'];
					$serieses[$i]['path'] = $row['path'];
					if($ranking){
						if($row['val'] == 0){
						$serieses[$i]['color'] = "#DD1E2F";
					}
					else if($row['val'] >=0 && $row['val'] <= 10){
						$serieses[$i]['color'] = "#3366FF";
					}
					else if($row['val'] >=10 && $row['val'] <= 50){
						$serieses[$i]['color'] = "#EBB035";
					}else if($row['val'] >=50){
						$serieses[$i]['color'] = "#0B7546";
					}
						$serieses[$i]['y'] = $row['val'];
					}else
						$serieses[$i]['value'] = $row['val'];
					 
				}
				if($ranking){
					//echo'test';exit;
					foreach ($serieses as $key => $value) {
						$compliance[$key] = $value['y'];
					}
					array_multisort($compliance, SORT_DESC, $serieses);
				}
				if($category){
				$names = array_column($serieses, 'name');
				return (json_encode($names,JSON_NUMERIC_CHECK));
				}
				if($ranking){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}if($map){
					return (json_encode($serieses,JSON_NUMERIC_CHECK));
				}
			}
			if($post=='epi_coordinator'){
				$wc_type="AND supervisor_type='EPI Coordinator'";
			}elseif($post=='dsv'){
				$wc_type="AND supervisor_type='District Superintendent Vaccinator'";
			}elseif($post=='tsv'){
				$wc_type="AND supervisor_type='Tehsil Superintendent Vaccinator'";
			}elseif($post=='asv'){
				$wc_type="AND supervisor_type='Assistant Superintendent Vaccinator'";
			}else{
				$wc_type='';
			}
			$query = "SELECT filled,sanctioned,(sanctioned-filled) as vaccant,round((filled//sanctioned)*100) as persent 
							FROM (SELECT COUNT(*) AS filled ,(select sum({$post}) from sanctioned_posts_db ) as sanctioned 
								FROM {$table}
								WHERE status='Active' {$wc_type}  ) as a";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			if($value=='filled')
				return $data[0]['filled'];
			if($value=='sanctioned')
				return $data[0]['sanctioned'];
			if($value=='vaccant')
				return $data[0]['vaccant'];
			if($value=='persent')
				return $data[0]['persent'];
	}
	public function Stockout($vaccineId=5,$filters,$value='stockout',$code='3',$type='province',$map=false,$ranking=false,$category=false){
		//print_r($filters);exit;
		$startCount = 1;
		$endCount = 12;
		$year=$filters['year'];
		switch($filters['period']){
			case 'yearly':
				$startCount = 1;
				$endCount = ($filters['year'] == date('Y',strtotime('first day of previous month')))?date('n',strtotime('first day of previous month')):12;
				break;
			case 'biyearly':
				if($filters['biyear'] == 1 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
					$startCount = 1;
					$endCount = date('n',strtotime('first day of previous month'));
				}else if($filters['biyear'] == 2 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) > 6 && date('n',strtotime('first day of previous month')) < 12){
					$startCount = 7;
					$endCount = date('n',strtotime('first day of previous month'));
				}else if($filters['biyear'] == 1){
					$startCount = 1;
					$endCount = 6;
				}else if($filters['biyear'] == 2){
					$startCount = 7;
					$endCount = 12;
				}
				break;
			case 'quarterly':
				switch((int)$filters['quarter']){
					case 1:
						$startCount = 1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 3)
							$endCount = date('n',strtotime('first day of previous month'));
						else
							$endCount = 3;
						break;
					case 2:
						$startCount = 4;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6)
							$endCount = date('n',strtotime('first day of previous month'));
						else
							$endCount = 6;
						break;
					case 3:
						$startCount = 7;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 9)
							$endCount = date('n',strtotime('first day of previous month'));
						else
							$endCount = 9;
						break;
					case 4:
						$startCount = 10;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 12)
							$endCount = date('n',strtotime('first day of previous month'));
						else
							$endCount = 12;
						break;
				}
				break;
			case 'monthly':
				$startCount = (int) $filters['month'];
				$endCount = (int) $filters['month'];
				break;
			default:
				$startCount = 1;
				$endCount = 12;
				break;
		}
		//echo $startCount;
		if($startCount < 10){
			$month='0'.$startCount;
		}else{
			$month=$startCount;
		}
		//echo$month;exit;
		$fmonth=$year.'-'. $month;
		if($map){
			
			 $query = "SELECT distcode AS code,district AS name, highchart_coordinates as path,
							get_pro_level_all_fac_stock_out_new('{epi_consumption_detail.item_id=9}','2019-09','distcode',tbl.distcode) as val 
							FROM districts tbl";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			$compliance = $serieses = array();
			foreach($data as $i => $row){
				$serieses[$i]['name'] = $row['name'];
				$serieses[$i]['id'] = $row['code'];
				$serieses[$i]['path'] = $row['path'];
				if($ranking){
				if($row['val'] >= 100){
						$serieses[$i]['color'] = "#0B7546";
					}
					else if($row['val'] <= 99 && $row['val'] >= 71){
						$serieses[$i]['color'] = "#EBB035";
					}
					else if($row['val'] <= 70){
						$serieses[$i]['color'] = "#DD1E2F";
					}
					$serieses[$i]['y'] = $row['val'];
				}else
					$serieses[$i]['value'] = $row['val'];
			}
			if($ranking){
				foreach ($serieses as $key => $value) {
					$compliance[$key] = $value['y'];
				}
				array_multisort($compliance, SORT_DESC, $serieses);
			}
			if($category){
			$names = array_column($serieses, 'name');
			return (json_encode($names,JSON_NUMERIC_CHECK));
			}
			if($ranking){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}if($map){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}
		}

			
		 $query ="select array_agg('epi_consumption_detail.item_id='||pk_id) ids from epi_item_pack_sizes where cr_table_row_numb is not NULL and epi_item_pack_sizes.item_id = $vaccineId";
		$query = $this->db->query($query);
		$itemsidarr = $query->row()->ids;
		
		if($itemsidarr){
			$wcyear = $year;
			//$monthnum = $startCount;
			$monthnum = 'duem'.ltrim($startCount, '0');
			//$selectcolumns = "distcode as code,district as name";
			$table = "districts tbl";					
			$duepart = "(SELECT sum($monthnum) FROM consumptioncompliance where year = '".$wcyear."' and procode = tbl.procode)";
			$subcode = " and procode = tbl.procode";
			$stockout = "get_pro_level_all_fac_stock_out_new('$itemsidarr','$fmonth','procode',tbl.procode)";
			$query ="
			select 
			$duepart as due,
			(SELECT count(*) FROM epi_consumption_master where fmonth = '".$fmonth."' $subcode) as submitted,
			$stockout as stockout 
			from $table GROUP BY procode";
			$result = $this->db->query($query);
			//print_r($result);exit;
			$data= $result->result_array();
			if($value=='due')
				return $data[0]['due'];
			if($value=='submitted')
				return $data[0]['submitted'];
			if($value=='stockout')
				return $data[0]['stockout'];
			if($value=='stockout_rate'){
				$stockout_rate=($data[0]['submitted']>0)?round(($data[0]['stockout']/$data[0]['submitted'])*100,2):0;
				return $stockout_rate;
			}	
		}
	}
	function Sessionplan($column='or',$filters,$record='ratio',$code='3',$type='province',$map=false,$ranking=false,$category=false)
	{
		$year = $filters['year'];
		$startMonth = 1;
		$endMonth = 12;
		switch($filters['period']){
			case 'yearly':
				$startMonth = 1;
				$endMonth = ($filters['year'] == date('Y',strtotime('first day of previous month')))?date('n',strtotime('first day of previous month')):12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
			case 'biyearly':
				if($filters['biyear'] == 1 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
					$startMonth = 1;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 2 && $filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) > 6 && date('n',strtotime('first day of previous month')) < 12){
					$startMonth = 7;
					$endMonth = date('n',strtotime('first day of previous month'));
					$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
				}else if($filters['biyear'] == 1){
					$startMonth = 1;
					$endMonth = 6;
					$where = "fmonth between '{$year}-01' AND '{$year}-06'";
				}else if($filters['biyear'] == 2){
					$startMonth = 7;
					$endMonth = 12;
					$where = "fmonth between '{$year}-07' AND '{$year}-12'";
				}
				break;
			case 'quarterly':
				switch((int)$filters['quarter']){
					case 1:
						$startMonth = 1;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 3){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-01' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 3;
							$where = "fmonth between '{$year}-01' AND '{$year}-03'";
						}
						break;
					case 2:
						$startMonth = 4;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 6){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-04' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 6;
							$where = "fmonth between '{$year}-04' AND '{$year}-06'";
						}
						break;
					case 3:
						$startMonth = 7;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 9){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-07' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 9;
							$where = "fmonth between '{$year}-07' AND '{$year}-09'";
						}
						break;
					case 4:
						$startMonth = 10;
						if($filters['year'] == date('Y',strtotime('first day of previous month')) && date('n',strtotime('first day of previous month')) < 12){
							$endMonth = date('n',strtotime('first day of previous month'));
							$where = "fmonth between '{$year}-10' AND '{$year}-".date('m',strtotime('first day of previous month'))."'";
						}else{
							$endMonth = 12;
							$where = "fmonth between '{$year}-10' AND '{$year}-12'";
						}
						break;
				}
				break;
			case 'monthly':
				$startMonth = (int) $filters['month'];
				$endMonth = (int) $filters['month'];
				$month = $filters['month'];
				$where = "fmonth = '".$year.'-'.$month."'";
				break;
			default:
				$startMonth = 1;
				$endMonth = 12;
				$where = "fmonth like '".$year.'-'."%'";
				break;
		}
		$startMonth = sprintf('%02d',$startMonth);
		$endMonth = sprintf('%02d',$endMonth);
		if($map){
			
			$query = "SELECT 
						districts.distcode as code,unname(districts.distcode) as name,(case when ( val > 0 ) then val else 0 end) as val,districts.highchart_coordinates AS path 
							FROM 
								districts 
							LEFT JOIN (SELECT distcode,round((sum({$column}_vacc_held)//sum({$column}_vacc_planned))*100) as val 
											FROM 
												fac_mvrf_db 
													WHERE 
														fmonth BETWEEN '{$year}-{$startMonth}' AND '{$year}-{$endMonth}' 
														group by distcode) as a on   districts.distcode=a.distcode";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			$compliance = $serieses = array();
			//$result = $this -> db -> get() -> result_array();
			foreach($data as $i => $row){
				$serieses[$i]['name'] = $row['name'];
				$serieses[$i]['id'] = $row['code'];
				$serieses[$i]['path'] = $row['path'];
				if($ranking){
				if($row['val'] >= 100){
						$serieses[$i]['color'] = "#0B7546";
					}
					else if($row['val'] <= 99 && $row['val'] >= 71){
						$serieses[$i]['color'] = "#EBB035";
					}
					else if($row['val'] <= 70){
						$serieses[$i]['color'] = "#DD1E2F";
					}
					$serieses[$i]['y'] = $row['val'];
				}else
					$serieses[$i]['value'] = $row['val'];
			}
			if($ranking){
				foreach ($serieses as $key => $value) {
					$compliance[$key] = $value['y'];
				}
				array_multisort($compliance, SORT_DESC, $serieses);
			}
			if($category){
			$names = array_column($serieses, 'name');
			return (json_encode($names,JSON_NUMERIC_CHECK));
			}
			if($ranking){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}if($map){
				return (json_encode($serieses,JSON_NUMERIC_CHECK));
			}
		}
		$query = "SELECT 
						sum({$column}_vacc_planned) as planned,
						sum({$column}_vacc_held) as held,
						round((sum({$column}_vacc_held)//sum({$column}_vacc_planned))*100) as ratio 
							FROM 
								fac_mvrf_db 
							WHERE 
								fmonth BETWEEN '{$year}-{$startMonth}' AND '{$year}-{$endMonth}'";
			$result = $this -> db -> query($query);
			$data= $result->result_array();
			//print_r($data);exit;
			if($record=='planned')
				return $data[0]['planned'];
			if($record=='held')
				return $data[0]['held'];
			if($record=='ratio')
				return $data[0]['ratio'];
	}
	
}
?>