<?php  
//setting default period to yearly
$period=(isset($filter) && $filter!=""?$filter:'yearly');?>
<!DOCTYPE html>
<?php //print_r($exportIcons['exportIcons']);  ?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Review Dashboard</title>
		<link href="<?php echo base_url('Bulletin/includes/'); ?>/css/style.css" rel="stylesheet">
		<link href="<?php echo base_url('Bulletin/includes/'); ?>/css/bootstrap.min.css" rel="stylesheet">		
		<link href="https://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
		<link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	</head> 
	<body>
		<div class="main-wrapper">
			<section id="header">
				<div class="row header-row">
					<div class="col-md-3">
						<img src="<?php echo base_url(); ?>Bulletin/includes/images/icon.jpg" class="img-responsive" width="80px" height="80px" alt="logo" style="box-shadow:none;"/>
					</div>
					<div class="col-md-9 main-heading">
						<h2>The Expanded Program on Immunization (EPI)</h2>
						<h3 style="margin-top:8px;" class="text-muted">Review Dashboard</h3>
					</div>
				</div>
			</section>
				<section id="rev_filters">
			<div class="container">
				<div class="row" id="rev_filter">
					<form id="filter-form" method="GET" style="width:100%; display:inherit">
					<div class="col-lg-3 col-lg-offset-7">
						<input type="radio" <?php echo (isset($period) && $period=='yearly')?'checked':''; ?> class="cst-radio-filter" id="yearly" value="yearly" name="filter">
						<label for="yearly">Yearly</label>
						<input type="radio" <?php echo (isset($period) && $period=='quarterly')?'checked':''; ?> class="cst-radio-filter" id="quarterly" value="quarterly" name="filter">
						<label for="quarterly">Quarterly</label>
						<input type="radio" <?php echo (isset($period) && $period=='monthly')?'checked':''; ?> class="cst-radio-filter" id="monthly" value="monthly" name="filter">
						<input type="hidden" value="<?php if(isset($distcode)){ echo $distcode; } ?>" name="distcode">
						<label for="monthly">Monthly</label>
					</div>
					<div class="col-lg-1">
						<button value="submit" type="submit" class="btn btn-success review_btn-success">Submit</button>
					</div>
					</form>
				</div>
			</div>
		</section>
			<section id="main-section" style="margin-bottom:30px; margin-top: 10px;">
			
				<div  class="row">
					<div  id="contentt" class="col-md-12 col-highlights" style="padding-left:0px ; padding-right:0px; border-radius:5px;">
					   
						<!-- Graph 7 Div -->
						<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Vaccination Compliance Coverage</u></h3> 
							</div>
							<div class="col-md-12">
								<!--<p>Graph  coverage</p>
								<p><strong>Graph : 5</strong>  Coverage</p>-->
							</div>	
							<div class="col-md-12">
								<div id="compliance"></div>
							</div>		
						</div>
						<!-- Graph 7 Div -->
						<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Vaccine Coverage</u></h3> 
							</div>
							<div class="col-md-12">
								<!--<p>Graph  coverage</p>
								<p><strong>Graph : 5</strong>  Coverage</p>-->
							</div>	
							<div class="col-md-12">
								<div id="penta3measles1coverage"></div>
							</div>		
						</div>
						
						<!-- Graph 8 Div -->
						<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Dropout Rate</u></h3>
							</div>
							 <div class="col-md-12">
								<!--<p>Graph 6 below shows dropout for Pentavalent and Measles vaccines</p>
								<p><strong>Graph : 6</strong> Dropout Penta 1-3, Penta3-Meales1 & Measles 1-2</p>-->
							</div>	 
							<div class="col-md-12">
								<div id="dropouts"></div>
							</div>		
						</div>
						<!-- Graph 5 Div -->
						<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Fully Immunization</u></h3>
							</div>
							<div class="col-md-12">
								<!--<p>Graph 3 clearly presents the timeliness and completeness of the VPD surveillance reports</p>
								<p><strong>Graph : 3</strong> Timeliness and Completeness of the VPD Surveillance Reports</p-->
							</div>	
							<div class="col-md-12">
								<div id="fullyimmunized"></div>
							</div>		
						</div>
						<!-- Graph 6 Div -->
						<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Child Protected Birth</u></h3>
							</div>
							<div class="col-md-12">
								<!--<p>Graph 4 below shows the timeliness and completeness of coverage reports shared by Provinces</p>
								<p><strong>Graph : 4</strong> Timeliness and Completeness of Coverage Reports</p>-->
							</div>	
							<div class="col-md-12">
								<div id="childprotectedbirth"></div>
							</div>		
						</div>
						<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Access Utilization Category  </u></h3>
							</div>
							<div class="col-md-12">
								<!--<p>Graph 4 below shows the timeliness and completeness of coverage reports shared by Provinces</p>
								<p><strong>Graph : 4</strong> Timeliness and Completeness of Coverage Reports</p>-->
							</div>	
							<div class="col-md-12">
								<div id="categories"></div>
							</div>		
						</div>
						<!-- Graph 3 Div -->
						<!--<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Measles suspected cases and samples collected</u></h3>
							</div>
							<div class="col-md-12">
								<p>Graph 3 demonstrates the number of Measles suspected cases and samples collected for week <?php echo $from_week; ?>, to week <?php echo $to_week; ?>, <?php echo $year; ?> </p>
								<p><strong>Graph : 3</strong> Measles suspected cases and samples collected</p>
							</div>	
							<div class="col-md-12">
								<div id="measlessuspectedcasesandsamplecollected"></div>
							</div>		
						</div>-->
						<!-- Graph 4 Div -->
						<!--<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Age & Vaccination status of Measles cases</u></h3>
							</div>
							<div class="col-md-12">
								<p>Graph 4 below shows age & vaccination status of Measles lab cases</p>
								<p><strong>Graph : 4</strong> Age & Vaccination status of Measles cases</p>
							</div>	
							<div class="col-md-12">
								<div id="ageandvaccinationstatus"></div>
							</div>		
						</div>-->
						
						
						
						<!-- Graph 8 Div -->
						<!--<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Dropout Penta 1-3, Penta3-Meales1 & Measles 1-2</u></h3>
							</div>
							<div class="col-md-12">
								<p>Graph 6 below shows dropout for Pentavalent and Measles vaccines</p>
								<p><strong>Graph : 6</strong> Dropout Penta 1-3, Penta3-Meales1 & Measles 1-2</p>
							</div>	
							<div class="col-md-12">
								<div id="dropouts"></div>
							</div>		
						</div>-->
						<!-- Graph 9 Div -->
						<!--<div class="row" style="margin-top:30px;">
							<div class="col-md-12 rounded bg-cst">
								<h3 style="margin:0px;"><u>Rota-1 & Rota-2 Coverage</u></h3>
							</div>
							<div class="col-md-12">
								<p>Graph 7 below shows Rota-1 and Rota-2 coverage.</p>
								<p><strong>Graph : 7</strong> Rota-1 & Rota-2 Coverage</p>
							</div>	
							<div class="col-md-12">
								<div id="rota1rota2coverage"></div>
							</div>		
						</div>-->
					</div>
				</div>
				
			</section>
		</div>
		<div id="editor"></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="<?php echo base_url('Bulletin/includes/'); ?>js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url('Bulletin/'); ?>/includes/js/fusioncharts.js"></script>
		<script type="text/javascript" src="<?php echo base_url('Bulletin/'); ?>/includes/js/themes/fusioncharts.theme.fint.js"></script>
		<script type="text/javascript" src="<?php echo base_url('Bulletin/'); ?>/includes/js/themes/fusioncharts.theme.ocean.js"></script>
		<script type="text/javascript" src="<?php echo base_url('Bulletin/'); ?>/includes/js/themes/fusioncharts.theme.zune.js"></script>
		<script type="text/javascript" src="<?php echo base_url('Bulletin/'); ?>/includes/js/themes/fusioncharts.theme.carbon.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
		<script type="text/javascript">
		
			$(document).ready(function(){
				/*  vaccination compliance */
				var $chartlink1 = '<?php echo base_url(); ?>dashboard/ReviewComparison/compliances_data?year=<?php 
				echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>&filter=<?php echo $filter; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'column2d',
						renderAt: 'compliance',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink1
					}).render();
				});
				/* Province wise Coverage for measles 1 and penta 3 for comparison */
				var $chartlink2 = '<?php echo base_url(); ?>dashboard/ReviewComparison/coverage_data?year=<?php 
				echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>&filter=<?php echo $filter; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'mscolumn2d',
						renderAt: 'penta3measles1coverage',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink2
					}).render();
				});
				
				
				/* Province wise dropouts for comparison */
				var $chartlink3 = '<?php echo base_url(); ?>dashboard/ReviewComparison/dropout_data?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>&filter=<?php echo $filter; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'mscolumn2d',
						renderAt: 'dropouts',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink3
					}).render();
				});
				/* Province Wise fullyimmunized */
				var $chartlink4 = '<?php echo base_url(); ?>dashboard/ReviewComparison/fullyimmunized_data?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>&filter=<?php echo $filter; ?>';
				FusionCharts.ready(function() { 
					var revenueChart = new FusionCharts({
						type: 'column2d',
						renderAt: 'fullyimmunized',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink4
					}).render();
				});
				//child protcted birth
				 var $chartlink5 = '<?php echo base_url(); ?>dashboard/ReviewComparison/childprotectedbirth_data?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>&filter=<?php echo $filter; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'column2d',
						renderAt: 'childprotectedbirth',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink5
					}).render();
				});
				//Acces Utilization Category Wise data 
				 var $chartlink6 = '<?php echo base_url(); ?>dashboard/ReviewComparison/categorywise_data?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>&filter=<?php echo $filter; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'mscolumn2d',
						renderAt: 'categories',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink6
					}).render();
				});
				/* Multi Series Completeness and Timeliness Chart for all districts for a week */
				/* var $chartlink = '<?php echo base_url(); ?>Ajax/vaccinePreventableDiseases?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'mscolumn2d',
						renderAt: 'vaccinepreventablediseases',
						width: '100%',
						height: '334',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink
					}).render();
				}); */
				
				/* var $chartlink2 = '<?php echo base_url(); ?>Ajax/measlesSuspectedCases?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'msline',
						renderAt: 'measlessuspectedcases',
						width: '100%',
						height: '234',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink2
					}).render();
				}); */
				
				/* Multi Series Column Chart for Measles Suspected Case and their Lab result age group wise */
				/* var $chartlink3 = '<?php echo base_url(); ?>Ajax/measlesSuspectedCasesAndSampleCollected?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'mscolumn2d',
						renderAt: 'measlessuspectedcasesandsamplecollected',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink3
					}).render();
				}); */
				
				/* Doughnut Chart for Measles Cases Dose wise count for a week */
				/* var $chartlink4 = '<?php echo base_url(); ?>Ajax/ageAndVaccinationStatus?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'doughnut2d',
						renderAt: 'ageandvaccinationstatus',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink4
					}).render();
				}); */
				
				/* Province Wise Timeliness and Completeness of VPD reports */
				/* var $chartlink5 = '<?php echo base_url(); ?>Ajax/vpdTimelinessAndCompleteness?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'mscolumn2d',
						renderAt: 'vpdtimelinessandcompleteness',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink5
					}).render();
				}); */
				
				/* Province Wise Timeliness and Completeness of Coverage reports */
				/* var $chartlink6 = '<?php echo base_url(); ?>Ajax/coverageTimelinessAndCompleteness?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'mscolumn2d',
						renderAt: 'coveragetimelinessandcompleteness',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink6
					}).render();
				}); */
				
				
				
				/* Province wise ROTA-1 and ROTA-2 Coverage for comparison */
				/* var $chartlink9 = '<?php echo base_url(); ?>Ajax/rota1Rota2Coverage?year=<?php echo $year; ?>&from_week=<?php echo $from_week; ?>&to_week=<?php echo $to_week; ?>';
				FusionCharts.ready(function() {
					var revenueChart = new FusionCharts({
						type: 'mscolumn2d',
						renderAt: 'rota1rota2coverage',
						width: '100%',
						height: '400',
						containerBackgroundOpacity: "0",
						dataFormat: 'jsonurl',
						dataSource: $chartlink9
					}).render();
				}); */
			});
		</script>
	</body>
</html>