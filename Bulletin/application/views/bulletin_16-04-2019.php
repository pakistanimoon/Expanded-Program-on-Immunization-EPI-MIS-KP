<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Weekly Bulletin</title>
		<link href="<?php echo base_url('includes/'); ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url('includes/'); ?>css/style.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
		<link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	</head>
	<body>
		<?php
		// $yearWeek = explode('-',$fweek);
		// $year = $yearWeek[0];
		// $week = $yearWeek[1];
		$year = $year;
		$from_week = $from_week;
		$to_week = $to_week;
		$fweekfrom = $year."-".$from_week;
		$fweekto = $year."-".$to_week;
		
		//echo $to_week;exit();
		$date1 = weekDates($fweekfrom);
		$date2 = weekDates($fweekto);
		// $duration1 = "Epidemiological Epid Week# {$from_week} to Epidemiological Epid Week# {$to_week} of {$year}";
		// $duration2 = "{$from_week} to Epid Week# {$to_week} of {$year}";
		$duration1 = "Epidemiological Epid Week# {$from_week} to Epid Week# {$to_week} of {$year}";
		$duration2 = "{$from_week} to Epid Week# {$to_week} of {$year}";

		$duration3 = "Week {$from_week} to Week {$to_week} of {$year}";
		//}
		$districtsInvolvedInSelectedWeek = noOfDistricts_SubmittedZeroReportInA_Week($year,$fweekfrom,$fweekto);
		$totalFunctionalFacilitiesInSelectedWeek = functionalFacilitiesInaWeek($year,$fweekfrom,$fweekto);
		$facilitiesInvolvedInSelectedWeek = noOfFacilitiesWithZeroReportSubmittedInaWeek($year,$fweekfrom,$fweekto);
		$weekTimeliness = totalTimelinessOfaWeek($year,$fweekfrom,$fweekto);
		$weekCompleteness = totalCompletenessOfaWeek($year,$fweekfrom,$fweekto);
		$outbreakUcs = outbreakMeaslesUnioncouncils($year,$fweekfrom,$fweekto);
		$previousWeek = getPreviousWeek($fweekto);
		$countOfoutbreakUcs = count($outbreakUcs);
		$totalCasesText = "";
		if($countOfoutbreakUcs > 0){
			if($countOfoutbreakUcs == 1)
				$outbreakText = "An outbreak of Measles has been reported in UC ";
			else
				$outbreakText = "Outbreaks of Measles have been reported in UCs ";
			$totalCases = "";
			foreach($outbreakUcs as $key => $val){
				if($countOfoutbreakUcs > 1)
					$totalCases .= sprintf('%02d',$val['total_cases']).",";
				$outbreakText .= $val['uc'].'('.$val['districtname'].'),';
				if($key+1 == $countOfoutbreakUcs){
					$outbreakText = rtrim($outbreakText,',');
					if($countOfoutbreakUcs == 1){
						$totalCases = sprintf('%02d',$val['total_cases']);
						$totalCasesText = " comprising of {$totalCases} cases.";
					}else{
						$totalCases = rtrim($totalCases,',');
						$totalCasesText = " comprising of {$totalCases} cases respectively.";
					}
				}
			}
		}else{
			//$outbreakText = "No outbreak of Measles has been reported in week {$week}.";
			$outbreakText = "No outbreak of Measles has been reported from week {$from_week} to week {$to_week}.";
		}
		?>
		<div class="main-wrapper">
			<section id="header">
				<div class="row header-row">
					<div class="col-md-3">
						<img src="<?php echo base_url('includes/'); ?>images/province_logo.png" class="img-responsive" width="100px" height="100px" alt="logo" style="box-shadow:none;"/>
					</div>
					<div class="col-md-9 main-heading">
						<h2>Weekly Epidemiological Bulletin </h2>
						<p>Vaccine Preventable Diseases In Khyber Pakhtunkhwa</p>
					</div>
				</div>
			</section>
			<section id="main-section">
				<div class="row">
					<div class="col-md-8 col-highlights">
						<p class="highlights">Highlights from <?php echo $duration1; ?></p>
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-1">
								<i class="fa fa-hand-o-right" aria-hidden="true"></i>
							</div>
							<div class="col-md-11 col-sm-10 col-xs-10">
								<strong><?php echo $districtsInvolvedInSelectedWeek; ?></strong> districts (<strong><?php echo round($districtsInvolvedInSelectedWeek*100/25).'%'; ?></strong>) in the province provided surveillance data to the EPI-MIS.
								The system is also capable of providing information about 23 priority communicable 
								disease in all districts of Khyber Pakhtunkwa.
							</div>
						</div><!-- row -->
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-1">
								<i class="fa fa-hand-o-right" aria-hidden="true"></i>
							</div>
							<div class="col-md-11 col-sm-10 col-xs-10">
								<strong><?php echo number_format($facilitiesInvolvedInSelectedWeek); ?> (<?php echo round($facilitiesInvolvedInSelectedWeek*100/$totalFunctionalFacilitiesInSelectedWeek); ?>%)</strong> health facilities from these <strong><?php echo $districtsInvolvedInSelectedWeek; ?></strong> districts provided surveillance 
								data for this epidemiological period.
							</div>
						</div><!-- row -->
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-1">
								<i class="fa fa-hand-o-right" aria-hidden="true"></i>
							</div>
							<div class="col-md-11 col-sm-10 col-xs-10">
								<?php if(25-$districtsInvolvedInSelectedWeek > 0){ ?>
								District <strong><?php echo districtNotSubmittedTheirReportInSelectWeek($from_week,$to_week); ?></strong> have not provide surveillance data to the province for this epidemiological period.
								<?php }else{ ?>
								<strong>All</strong> districts have provide surveillance data to the province for this epidemiological period.
								<?php } ?>
							</div>
						</div><!-- row -->
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-1">
								<i class="fa fa-hand-o-right" aria-hidden="true"></i>
							</div>
							<div class="col-md-11 col-sm-10 col-xs-10">
								<?php 
								$tbCases = tbCasesDetailsInaWeek($from_week,$to_week);
								$tbResultRowsCount = count($tbCases);
								if($tbResultRowsCount > 0){ ?>
									Cases of Childhood TB has been reported from following UC:<br>
									<?php foreach($tbCases as $case){
								?>
									<i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo 'UC '.$case['unname'].', District '.$case['districtname'].', Total Cases : '.$case['tb_cases']; ?><br>
								<?php }
								}else{ ?>
								Not a single case of Childhood TB has reported from any of district.
								<?php } ?>
							</div>
						</div><!-- row -->
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-1">
								<i class="fa fa-hand-o-right" aria-hidden="true"></i>
							</div>
							<div class="col-md-11 col-sm-10 col-xs-10">
								<?php echo $outbreakText.$totalCasesText; ?> Overall, <strong><?php echo number_format(totalSuspectedMeaslesCases($year)); ?></strong> suspected measles cases were reported 
								during the period from January till this Epid Week <?php echo $to_week; ?>, <?php echo $year; ?>. 
							</div>
						</div><!-- row -->
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-1">
								<i class="fa fa-hand-o-right" aria-hidden="true"></i>
							</div>
							<div class="col-md-11 col-sm-10 col-xs-10">
								KP Polio Eradication initiative reported No Confirmed polio cases during this period
							</div>
						</div><!-- row -->
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-1">
								<i class="fa fa-hand-o-right" aria-hidden="true"></i>
							</div>
							<div class="col-md-11 col-sm-10 col-xs-10">
								Rota trainings for Medical Officers, Paramedics and EPI technicians were conducted
								in District Charsadda and Kohat.
							</div>
						</div><!-- row -->
					</div>
					
					<div class="col-md-3 col-sm-12 col-xs-12" >
						<div class="row aside">
							<div class="col-md-12">
								<h3 >From Epid Week # <?php echo $duration2; ?></h3>
								<h4 class="aside-h4">System Performance</h4>
								<div class="row">
									<div class="col-md-1 col-sm-1 col-xs-1">
										<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-10">
										Completeness for weekly Zero reporting was <strong><?php echo $weekCompleteness; ?>%</strong> for
										the reporting districts
									</div>
								</div><!-- row -->
								<div class="row">
									<div class="col-md-1 col-sm-1 col-xs-1">
										<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-10">
										<strong><?php echo percentageOfDistrictsAchived100PercComplianceInaWeek($from_week,$to_week); ?>%</strong> districts achieved <strong>100%</strong> completeness while <strong><?php echo percentageOfDistrictsAchived80PercComplianceInaWeek($fweekfrom,$fweekto)->cnt; ?></strong> out of <strong>25</strong> districts achieved <strong>80%</strong> of desired benchmark for
										completeness
									</div>
								</div><!-- row -->
								<div class="row">
									<div class="col-md-1 col-sm-1 col-xs-1">
										<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-10">
										Timeliness for weekly Zero reporting from the reporting 
										districts is <strong><?php echo $weekTimeliness; ?>%</strong>
									</div>
								</div><!-- row -->
								<div class="row">
									<div class="col-md-1 col-sm-1 col-xs-1">
										<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-10">
										Zero report completeness and timeliness reporting
										rate for <strong><?php echo $duration3; ?></strong> is <strong><?php echo $weekCompleteness; ?>%</strong> and <strong><?php echo $weekTimeliness; ?>%</strong> respectively
										<!-- in comparison to <strong><?php //echo totalCompletenessOfaWeek($previousWeek); ?>%</strong>
										and <strong><?php //echo totalTimelinessOfaWeek($previousWeek); ?>%</strong> in previous Year-Week <strong><?php //echo $previousWeek; ?></strong> -->
									</div>
								</div><!-- row -->
								<div class="row">
									<div class="col-md-1 col-sm-1 col-xs-1">
										<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-10">
										AEFI Surveillance completeness and timeliness for this week
										is <strong><?php echo $weekCompleteness; ?>%</strong> and <strong><?php echo $weekTimeliness; ?>%</strong> respectively
									</div>
								</div><!-- row -->
							</div>
						</div><!-- row -->
					</div>
					<div class="row">
							<div class="col-md-8 contact">
								<span>Contact : </span>
								<p> Department of Health,EPI Section, Directorate General Health Office, Peshawar <br>
									Phone No. 091-9213849 Email. dr.harismustafa@gmail.com
								</p>
							</div>
						</div><!-- row -->
			</section>
			<section id="fig">
				<div class="row">
					<div class="col-md-12">
						<h2> AEFI & Zero Reporting - Completeness & Timeliness <?php echo $duration3; ?></h2>
						<div id="completenessTimeliness"></div>
						<!--<h2 style="background:#3ba6bf"> Week Wise Comparison Completeness & Timeliness Week <?php //echo $week; ?>,<?php //echo $year; ?></h2>
						<div id="weekWiseComparisonCompletenessTimeliness"></div>-->
						<h2 style="background:#c2912e"> Weekly zero Reporting Performance of District on Basis of Completeness & Timeliness <?php echo $duration3; ?></h2>
						<table class="table table-bordered" style="table-layout:fixed;">
							<thead>
								<tr>
									<th colspan="2">District Completeness</th>
									<th colspan="2">District Timeliness</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="background:#f5e20e;">less than 100% but greater than 80%</td>
									<td style="background:#ff3f15eb;">Below desired 80%</td>
									<td style="background:#f5e20e;">less than 100% but greater than 80%</td>
									<td style="background:#ff3f15eb;">Below desired 80%</td>
									
								</tr>
								<tr>
									<td><?php echo str_replace(',',', ',districtsWithComplianceGreaterThan80AndLessThan100($fweekfrom,$fweekto,1)); ?></td>
									<td><?php echo str_replace(',',', ',districtsWithComplianceGreaterThan80AndLessThan100($fweekfrom,$fweekto,2)); ?></td>
									<td><?php echo str_replace(',',', ',districtsWithTimelinessGreaterThan80AndLessThan100($fweekfrom,$fweekto,1)); ?></td>
									<td><?php echo str_replace(',',', ',districtsWithTimelinessGreaterThan80AndLessThan100($fweekfrom,$fweekto,2)); ?></td>
								</tr>
							</tbody>
						</table>
						<h2 style="background:#477eb5">District Wise Count of VPD's</h2>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-fig table-bordered">
									<thead>
										<tr>
											<th>District Name</th>
											<th>Suspected Measles</th>
											<th>AFP</th>
											<th>NNT</th>
											<th>Diphtheria</th>
											<th>Pertussis</th>
											<th>Childhood TB</th>
											<th>Pneumonia</th>
											<th>Meningitis</th>
											<th>Hepatitis</th>
											<th>Total VPDs Cases</th>
										</tr>
									</thead>
									<tbody>
										<?php echo countOfVPDs($fweekfrom,$fweekto); ?>
									</tbody>
									<!--<tfoot>
										<tr>
											<td>Total:</td>
											<td>11902</td>
											<td>856</td>
											<td>45</td>
											<td>121</td>
											<td>37</td>
											<td>6</td>
											<td>1</td>
										</tr>
									</tfoot>-->
								</table>
							</div>
							<!--<div class="col-md-6">
								<img src="<?php //echo base_url('includes/'); ?>images/district-wise-fig-1.png" class="img-responsive" />
							</div>-->
						</div><!-- row -->
						<div class="row">
							<div class="col-md-12">
								<div id="agewisedistributionOfmealses"></div>
								<h3>Graph showing Age wise distribution of Lab Confirmed Measles
								</h3><!-- 74% of Confirmed measles cases are below 5 years of age  -->
							</div>
							<!--<div class="col-md-6">
								<img src="<?php echo base_url('includes/'); ?>images/district-wise-fig-2.png" class="img-responsive" />
							</div>-->
						</div>
						<div class="row">
							<div class="col-md-6">
								<div id="suspectedMeaslesCasesAndLabResult"></div>
							</div>
							<div class="col-md-6">
								<div id="measlesCasesDoseWiseCount"></div>
							</div>
						</div>
						<!-- <div class="row">
							<div class="col-md-12">
								<h2>Measles Surveillance Indicator</h2>
							</div>
						</div> --><!-- row -->
						<!--<div class="row">
							<div class="col-md-12">
								<img src="<?php //echo base_url('includes/'); ?>images/measles_indecator.png" class="img-responsive" />
								<h4>16%(04/25 Districts) have achieved the benchmark of Case reporting/Non Measles Discarded Rate</h4>
							</div>
						</div>-->
					<!-- 	<div class="row">
							<div class="col-md-12">
								<img src="<?php //echo base_url('includes/'); ?>images/specimen-fig.png" class="img-responsive" />
								<h4>04%(01/25 District) have achieved the benchmark of Adequcy of Specimen Collection</h4>
							</div>
						</div> --><!-- row -->
						<div class="row">
							<div class="col-md-12">
								<span class="last"><i class="fa fa-stop" aria-hidden="true"></i> None of the District have reported any Throat Swab for viral Detection Rate, so its Zero percent for all districts.</span>
							</div>
						</div><!-- row -->
						
					</div>
				</div><!-- row -->
			</section>
		</div>





	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="<?php echo base_url('includes/'); ?>js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/fusioncharts.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/themes/fusioncharts.theme.fint.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/themes/fusioncharts.theme.ocean.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/themes/fusioncharts.theme.zune.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/themes/fusioncharts.theme.carbon.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			/* Multi Series Completeness and Timeliness Chart for all districts for a week */
			var $chartlink = '<?php echo base_url(); ?>Ajax/completenessTimelinessColumn2D?fweekfrom=<?php echo $fweekfrom; ?>&fweekto=<?php echo $fweekto; ?>';

			// var $chartlink5 = '<?php //echo base_url(); ?>Ajax/vpdTimelinessAndCompleteness?year=<?php //echo $year; ?>&from_week=<?php //echo $from_week; ?>&to_week=<?php //echo $to_week; ?>';
			//alert(<?php //echo $fweekfrom; ?>);
			FusionCharts.ready(function() {
				var revenueChart = new FusionCharts({
					type: 'mscolumn2d',
					renderAt: 'completenessTimeliness',
					width: '100%',
					height: '234',
					containerBackgroundOpacity: "0",
					dataFormat: 'jsonurl',
					dataSource: $chartlink
				}).render();
			});
			/* var $chartlink1 = '<?php //echo base_url(); ?>Ajax/weekWiseComparisonOfCompletenessTimelinessMsLine2D?fweek=<?php //echo $fweek; ?>';
			FusionCharts.ready(function() {
				var revenueChart = new FusionCharts({
					type: 'msline',
					renderAt: 'weekWiseComparisonCompletenessTimeliness',
					width: '100%',
					height: '234',
					containerBackgroundOpacity: "0",
					dataFormat: 'jsonurl',
					dataSource: $chartlink1
				}).render();
			}); */
			/* Column Chart for Measles Confirmed Cases by Lab age group wise */
			var $chartlink2 = '<?php echo base_url(); ?>Ajax/ageWiseDistributionOfLabConfirmedCases?fweekfrom=<?php echo $fweekfrom; ?>&fweekto=<?php echo $fweekto; ?>';
			FusionCharts.ready(function() {
				var revenueChart = new FusionCharts({
					type: 'column2d',
					renderAt: 'agewisedistributionOfmealses',
					width: '100%',
					height: '234',
					containerBackgroundOpacity: "0",
					dataFormat: 'jsonurl',
					dataSource: $chartlink2
				}).render();
			});
			/* Multi Series Column Chart for Measles Suspected Case and their Lab result age group wise */
			var $chartlink3 = '<?php echo base_url(); ?>Ajax/measlesSuspectedCasesWithLabResultsAgeWiseCount?fweekfrom=<?php echo $fweekfrom; ?>&fweekto=<?php echo $fweekto; ?>';
			FusionCharts.ready(function() {
				var revenueChart = new FusionCharts({
					type: 'mscolumn2d',
					renderAt: 'suspectedMeaslesCasesAndLabResult',
					width: '100%',
					height: '400',
					containerBackgroundOpacity: "0",
					dataFormat: 'jsonurl',
					dataSource: $chartlink3
				}).render();
			});
			/* Doughnut Chart for Measles Cases Dose wise count for a week */
			var $chartlink4 = '<?php echo base_url(); ?>Ajax/measlesCasesReceivedDoseWiseCount?fweekfrom=<?php echo $fweekfrom; ?>&fweekto=<?php echo $fweekto; ?>';
			FusionCharts.ready(function() {
				var revenueChart = new FusionCharts({
					type: 'doughnut2d',
					renderAt: 'measlesCasesDoseWiseCount',
					width: '100%',
					height: '400',
					containerBackgroundOpacity: "0",
					dataFormat: 'jsonurl',
					dataSource: $chartlink4
				}).render();
			});
		});
	</script>
	</body>
</html>