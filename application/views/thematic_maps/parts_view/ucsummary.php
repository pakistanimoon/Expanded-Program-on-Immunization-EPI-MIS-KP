<?php
//print_r($totalVaccinationNumbersMale);exit
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered tbl-states">
				<thead>
					<tr>
					<?php 
					if(isset($services) && $services=="healthhouse")
					{
						$tittleServices = "Health House";
					}
					else
					{
						$tittleServices = ucfirst($services);
					}
					?>
						<td colspan="4" style="text-align: left;"><?php echo $tittleServices;?> Services <strong style="font-size:11px;"><?php echo $distYear ?></strong></td>
						<td colspan="2">
							<table style="width:100%;">
								<tr>
									<td><i class="fa fa-chevron-left" aria-hidden="true"></i></td>
									<td>Vaccine Coverage</td>
									<td><i class="fa fa-chevron-right" aria-hidden="true"></i></td>
								</tr>
							</table>
						</td>
					</tr>
				</thead>
				<tbody>
				<?php
				$servicesheld = $services."held";
				$servicesplanned = $services."planned";
				?>
					<tr>
						<td class="td-middle">
							<table class="table tbl-figures">
								<tbody>
									<tr><td class="s-bn c-green"><span class="span-digit"><?php echo ($sessionPlannedHeld->$servicesheld > 0)?$sessionPlannedHeld -> $servicesheld:0; ?></span>Session Conducted</td></tr>
									<tr><td class="c-orange"><span class="span-digit"><?php echo ($sessionPlannedHeld->$servicesplanned > 0)?$sessionPlannedHeld -> $servicesplanned:0; ?></span>Session Planned</td></tr>
								</tbody>
							</table>
						</td>
						<td class="td-middle text-center">
							<span class="span-pie-chart">
								<!--<div id="pie-first" class="svg-pie pie-teal2"></div>-->
								<div id="circle1">
									<strong class="stng-text"></strong>
									<span class="spn-text">% Conducted</span>
								</div>
							</span>
							<span class="span-pie-chart">
								<div id="circle2">
									<strong class="stng-text"></strong>
									<span class="spn-text">% Session Dropout</span>
								</div>
							</span>
						</td>
						<td class="td-middle">
							<table class="table tbl-figures">
								<tbody>
									<?php
									$servicesheld = "_{$services}_both";
									$childrenVaccinatedkey = $productsArray[$vaccineId].$servicesheld;
									$totalChildrenkey = $productsArray[$vaccineId].'_total_both';
									?>
									<!-- <tr><td class="s-bn c-indigo"><span class="span-digit"><?php //echo $totalVaccinationNumbers->$childrenVaccinatedkey; ?></span>Children Vaccinated</td></tr>
									<tr><td class="c-grey"><span class="span-digit"><?php //echo $totalVaccinationNumbers->$totalChildrenkey; ?></span>Total Target</td></tr> -->
									<tr><td class="s-bn c-indigo"><span class="span-digit"><?php echo ($totalVaccinationNumbers->$childrenVaccinatedkey!="")?$totalVaccinationNumbers->$childrenVaccinatedkey:"0"; ?></span>Children Vaccinated</td></tr>
									<tr><td class="c-grey"><span class="span-digit"><?php echo $monthly_yearly_target['totalTarget']; ?></span>Total Target</td></tr>
									<?php $percChildrenVaccinatedOnOutreach = (isset($monthly_yearly_target['totalTarget']) && $monthly_yearly_target['totalTarget'] >0)?round($totalVaccinationNumbers->$childrenVaccinatedkey*100/$monthly_yearly_target['totalTarget']):0; ?>
								</tbody>
							</table>
						</td>
						<td class="td-middle text-center">
							<span class="span-pie-chart">
								<div id="circle3">
									<strong class="stng-text"></strong>
									<span class="spn-text">% Children Vaccinated</span>
								</div>
							</span>
						</td>
						<td>
							<table class="table table-bordered tbl-figures-right s-bt0 s-bl0 s-br0">
								<tbody>
									<tr>
										<td class="s-bn">
											<table class="table tbl-figures">
												<?php 
													$services_male = "_{$services}_male";
													$services_female = "_{$services}_female";
													$maleVaccination = $productsArray[$vaccineId].$services_male;
													$femaleVaccination = $productsArray[$vaccineId].$services_female;
												?>
												<tr><td class="text-center sub-hea s-bt0 s-bl0"><?php echo $productsNameArray[$vaccineId]; ?> Monthly Coverage</td></tr>
												<tr><td class="s-bn c-red"><span class="span-digit1"><?php echo $monthly_yearly_target['totalTarget']; ?></span>Total Target</td></tr>
												<tr><td class="s-bn c-red"><span class="span-digit1"><?php echo $totalVaccinationNumbers->$childrenVaccinatedkey; ?></span>Total Vaccination</td></tr>
												<?php
												$totalTargetPercentage = (isset($monthly_yearly_target['totalTarget']) && $monthly_yearly_target['totalTarget'] >0)?round($totalVaccinationNumbers->$childrenVaccinatedkey*100/$monthly_yearly_target['totalTarget']):"";
												?>
												<tr><td class="c-green"><span class="span-digit1"><?php echo $monthly_yearly_target['totalMaleTarget']; ?></span>Male Target</td></tr>
												<tr><td class="c-green"><span class="span-digit1"><?php echo $totalVaccinationNumbersMale->$maleVaccination; ?></span>Male Vaccination</td></tr>
												<?php
												$maleTargetPercentage = (isset($monthly_yearly_target['totalMaleTarget']) && $monthly_yearly_target['totalMaleTarget'] >0)?round($totalVaccinationNumbersMale->$maleVaccination*100/$monthly_yearly_target['totalMaleTarget']):"";
												?>
												<tr><td class="c-grey"><span class="span-digit1"><?php echo $monthly_yearly_target['totalFemaleTarget']; ?></span>Female Target</td></tr>
												<tr><td class="c-grey"><span class="span-digit1"><?php echo $totalVaccinationNumbersFemale->$femaleVaccination; ?></span>Female Vaccination</td></tr>
												<?php
												$femaleTargetPercentage = (isset($monthly_yearly_target['totalFemaleTarget']) && $monthly_yearly_target['totalFemaleTarget'] >0)?round($totalVaccinationNumbersFemale->$femaleVaccination*100/$monthly_yearly_target['totalFemaleTarget']):"";
												?>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td class="td-middle s-bb0 s-bt0 text-center">
							<span class="span-pie-chart">
								<div id="circle4">
									<strong class="stng-text1"></strong>
									<span class="spn-text1">% Total Coverage</span>
								</div>
							</span>
							<span class="span-pie-chart">
								<div id="circle5">
									<strong class="stng-text1"></strong>
									<span class="spn-text1">% Male Coverage</span>
								</div>
							</span>
							<span class="span-pie-chart">
								<div id="circle6">
									<strong class="stng-text1"></strong>
									<span class="spn-text1">% Female Coverage</span>
								</div>
							</span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div><!--end of row-->
	<div style="padding-top:10px">
	<div class="row">
	<div class="col-md-6">
	<div class="section-title">
	<span>Monthly Vaccination Coverage Trends</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
	<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line'></i></span></a>
	<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar'></i></span>
		</a> 
		</div>	
		</div>
	<div id="monthly-coverage">Monthly coverage fully Immunized chart will render here...</div>
		</div>
	<div class="col-md-6">

	<div class="section-title">
	<span>Monthly Vaccination Comparison Trends</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
	<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line2'></i></span></a>
	<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar2'></i></span></a> 
		</div>
		</div>
	<div id="monthly-vaccination-target-vs-trend">Your desire result will render here....</div>
		</div>
		</div>
		</div>
	<div style="padding-top:10px">
	<div class="row">
	<div class="col-md-6">
	<div class="section-title">
	<span>Monthly Vaccination Coverage</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
	<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line3'></i></span></a>
	<a style="color:#000000; cursor: pointer;" title="Bar View"><span><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar3'></i></span></a> 
		</div>
		</div>
	<div id="summary-vaccination-coverage-second-graph1">Your desire result will render here....</div>
		</div>
	<div class="col-md-6">
	<div class="section-title">
	<span>Monthly Vaccination Comparison</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
	<a    style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line4'></i></span>
		</a>
	<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar4'></i></span></a> 
		</div>
		</div>
	<div id="summary-vaccination-coverage-third-graph1">Your desire result will render here....</div>
		</div>
		</div>
		</div>
	<div style="padding-top:10px">
	<div class="row">
	<div class="col-md-6">
	<div class="section-title">
	<span>Monthly Vaccination Coverage</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
	<a    style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line5'></i></span>
		</a>
	<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar5'></i></span></a> 
		</div>
		</div>
	<div id="summary-vaccination-coverage-fourth-graph1">Your desire result will render here....</div>
		</div>
	<div class="col-md-6">
	<div class="section-title">
	<span>Monthly Vaccination Comparison</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
	<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line6'></i></span></a>
	<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar6'></i></span></a> 
		</div>
		</div>
	<div id="monthly-vaccination-TT">Your desire result will render here....</div>
		</div>
		</div>
		</div>
	<div style="padding-top:10px">
	<div class="row">
	<div class="col-md-12">
	<div class="section-title">
	<span>Sessions Dropout Rate </span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
	<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line7'></i></span></a>
	<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar7'></i></span></a> 
		</div>
		</div>
	<div id="sessions-dropout-grapgh1">Your desire result will render here....</div>
		</div>
		</div>
		</div>
	<div style="padding-top:10px">
	<div class="row">
	<div class="col-md-12">
	<div class="section-title">
	<span>Vaccine Dropout Rate </span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
	<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line8'></i></span></a>
	<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar8'></i></span></a> 
		</div>
		</div>
	<div id="dropout-grapgh-rate">Your desire result will render here....</div>
		</div>
		</div>
	</div>
	<div style="padding-top:10px">
	<div class="row">
	<div class="col-md-12">
	<div class="section-title">
	<span>Monthly Vaccine Usage and Wastage Rates </span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
		<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line9'></i></span></a>
		<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar9'></i></span></a> 
		</div>
		</div>
		<div id="monthly-summary-usage-wastage-rate-trend">Your desire result will render here....</div>
		</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
		<div class="col-md-12">
		<div class="section-title">
	
	<span>Weekly VPDs Cases </span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
				<a    style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='summary_monthlyfullyimm-line10'></i></span>
				</a>
				<a    style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='summary_monthlyfullyimm-bar10'></i></span>
				</a> 
			</div>
			</div>
				<div id="monthly-summary-surviellnace-rate-trend">Your desire result will render here....</div>
			</div>
		</div>
	</div>
</div>
<br>
<?php 
$ConductedPerc = $services."ConductedPerc";
$SessionDropout = $services."SessionDropout";
?>
<script type="text/javascript">
$(document).ready(function() {
	/* Circle 1 Code */
	var value1 = <?php echo ($sessionPlannedHeld->$ConductedPerc >0)?$sessionPlannedHeld->$ConductedPerc/100:'0'; ?>;
	$('#circle1').circleProgress({
		value: value1,
		size: 50,
		thickness : 8,
		animation : { duration: 2200, easing: "circleProgressEasing" },
		fill: {
		  gradient: ["#B71C1C", "#3E2723"]
		}
	}).on('circle-animation-progress', function(event, progress) {
		$(this).find('strong').html(parseInt((value1*100) * progress) + '<i>%</i>');
    });
	/* Circle 2 Code */
	var value2 = <?php echo ($sessionPlannedHeld->$SessionDropout >0)?$sessionPlannedHeld->$SessionDropout/100:'0'; ?>;
	$('#circle2').circleProgress({
		value: value2,
		size: 50,
		thickness : 8,
		animation : { duration: 2200, easing: "circleProgressEasing" },
		fill: {
		  gradient: ["#0D47A1", "#1B5E20"]
		}
	}).on('circle-animation-progress', function(event, progress) {
		$(this).find('strong').html(parseInt((value2*100) * progress) + '<i>%</i>');
    });
	/* Circle 3 Code */
	var value3 = <?php echo $percChildrenVaccinatedOnOutreach/100; ?>;
	$('#circle3').circleProgress({
		value: value3,
		size: 70,
		thickness : 8,
		animation : { duration: 2200, easing: "circleProgressEasing" },
		fill: {
		  gradient: ["#3E2723", "#1A4D7E"]
		}
	}).on('circle-animation-progress', function(event, progress) {
		$(this).find('strong').html(parseInt((value3*100) * progress) + '<i>%</i>');
    });
	/* Circle 4 Code */
	var value4 = <?php echo ($totalTargetPercentage/100); ?>;
	//alert(value4);
	$('#circle4').circleProgress({
		value: value4,
		size: 35,
		thickness : 5,
		animation : { duration: 2200, easing: "circleProgressEasing" },
		fill: {
		  gradient: ["#1A4D7E", "#008B8B"]
		}
	}).on('circle-animation-progress', function(event, progress) {
		$(this).find('strong').html(parseInt((value4*100) * progress) + '<i>%</i>');
    });
	/* Circle 5 Code */
	var value5 = <?php echo ($maleTargetPercentage/100); ?>;
	$('#circle5').circleProgress({
		value: value5,
		size: 35,
		thickness : 5,
		animation : { duration: 2200, easing: "circleProgressEasing" },
		fill: {
		  gradient: ["#004D40", "#DB8401"]
		}
	}).on('circle-animation-progress', function(event, progress) {
		$(this).find('strong').html(parseInt((value5*100) * progress) + '<i>%</i>');
    });
	/* Circle 6 Code */
	var value6 = <?php echo ($femaleTargetPercentage/100); ?>;
	$('#circle6').circleProgress({
		value: value6,
		size: 35,
		thickness : 5,
		animation : { duration: 2200, easing: "circleProgressEasing" },
		fill: {
		  gradient: ["#0D47A1", "#004D40"]
		}
	}).on('circle-animation-progress', function(event, progress) {
		$(this).find('strong').html(parseInt((value6*100) * progress) + '<i>%</i>');
    });


// start 

	$("#summary_monthlyfullyimm-line2").click(function(){
		summary_monthlyfullyimm1('msline');
	});
	$("#summary_monthlyfullyimm-bar2").click(function(){
		summary_monthlyfullyimm1('mscolumn2d');
	});
	
	$("#summary_monthlyfullyimm-line2").trigger("click");
	function summary_monthlyfullyimm1(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'monthly-vaccination-target-vs-trend',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "PENTA-1, PENTA-3, MR-1, MR-2",
					"yaxisname": "Percentage",
					"linethickness": "2",
					"numberPostfix": "/-",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"showValues" : "1",
					"rotateValues" : "0",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
			"categories": [{
				"category": [
					<?php foreach($monthlyVaccinationTrendAllDisease as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [
			<?php  
			for($i=1;$i<=21;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==7 || $i==9 || $i==16 || $i==18){
			?>
			{
			  <?php echo vaccineName($i); ?>,
			  "data": [
				<?php foreach($monthlyVaccinationTrendAllDisease as $key => $value){ ?>
					{
						"value": "<?php echo ((isset($value[$indexTarget]) && $value[$indexTarget]!='0')?round($value[$index]*100/$value[$indexTarget]):''); ?>"
					},
				<?php } ?>
				
				]
			},
			<?php } } ?>
			]
			}
		})
		.render();
	});
	}
	
	$("#summary_monthlyfullyimm-line3").click(function(){
		summary_monthlyfullyimm3('msline');
	});
	$("#summary_monthlyfullyimm-bar3").click(function(){
		summary_monthlyfullyimm3('mscolumn2d');
	});
	$("#summary_monthlyfullyimm-line3").trigger("click");
	function summary_monthlyfullyimm3(chartType='mscolumn2d')
	{
		
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'summary-vaccination-coverage-second-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "OPV 1, Penta 1, PCV10 1, Rota 1",
					"yaxisname": "Percentage",
					"xaxisname": "Year-Month",
					"linethickness": "2",
					"numberPostfix": "/-",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"showValues" : "1",
					"rotateValues" : "0",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
			"categories": [{
				"category": [
					<?php foreach($monthlyVaccinationTrendAllDisease as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [
			<?php  
			for($i=1;$i<=21;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==4 || $i==7 || $i==10 || $i==14){
			?>
			{
			  <?php echo vaccineName($i); ?>,
			  "data": [
				<?php foreach($monthlyVaccinationTrendAllDisease as $key => $value){ ?>
					{
						"value": "<?php echo ((isset($value[$indexTarget]) && $value[$indexTarget]!='0')? round($value[$index]*100/$value[$indexTarget]):''); ?>"
					},
				<?php } ?>
				
				]
			},
			<?php } } ?>
			]
			}
		})
		.render();
	});
	
	}
	
	$("#summary_monthlyfullyimm-line4").click(function(){
		summary_monthlyfullyimm4('msline');
	});
	$("#summary_monthlyfullyimm-bar4").click(function(){
		summary_monthlyfullyimm4('mscolumn2d');
	});
	$("#summary_monthlyfullyimm-line4").trigger("click");
	function summary_monthlyfullyimm4(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'summary-vaccination-coverage-third-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "OPV 2, Penta 2, PCV10 2, Rota 2, IPV-2",
					"yaxisname": "Percentage",
					"xaxisname": "Year-Month",
					"linethickness": "2",
					"numberPostfix": "/-",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"showValues" : "1",
					"rotateValues" : "0",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
			"categories": [{
				"category": [
					<?php foreach($monthlyVaccinationTrendAllDisease as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [
			<?php  
			for($i=1;$i<=21;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==5 || $i==8 || $i==11 || $i==15 || $i==21){
			?>
			{
			  <?php echo vaccineName($i); ?>,
			  "data": [
				<?php foreach($monthlyVaccinationTrendAllDisease as $key => $value){ ?>
					{
						"value": "<?php echo ((isset($value[$indexTarget]) && $value[$indexTarget]!='0')? round($value[$index]*100/$value[$indexTarget]):''); ?>"
					},
				<?php } ?>
				
				]
			},
			<?php } } ?>
			]
			}
		})
		.render();
	});
	}
	
	$("#summary_monthlyfullyimm-line5").click(function(){
		summary_monthlyfullyimm5('msline');
	});
	$("#summary_monthlyfullyimm-bar5").click(function(){
		summary_monthlyfullyimm5('mscolumn2d');
	});
	$("#summary_monthlyfullyimm-line5").trigger("click");
	function summary_monthlyfullyimm5(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'summary-vaccination-coverage-fourth-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "OPV 3, Penta 3, PCV10 3, IPV-1, TCV ",
					"yaxisname": "Percentage",
					"xaxisname": "Year-Month",
					"linethickness": "2",
					"numberPostfix": "/-",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"showValues" : "1",
					"rotateValues" : "0",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
			"categories": [{
				"category": [
					<?php foreach($monthlyVaccinationTrendAllDisease as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [
			<?php  
			for($i=1;$i<=21;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==6 || $i==9 || $i==12 || $i==13 || $i==20){
			?>
			{
			  <?php echo vaccineName($i); ?>,
			  "data": [
				<?php foreach($monthlyVaccinationTrendAllDisease as $key => $value){ ?>
					{
						"value": "<?php echo ((isset($value[$indexTarget]) && $value[$indexTarget]!='0')? round($value[$index]*100/$value[$indexTarget]):''); ?>"
					},
				<?php } ?>
				
				]
			},
			<?php } } ?>
			]
			}
		})
		.render();
	});
	
	}
	
	$("#summary_monthlyfullyimm-line6").click(function(){
		summary_monthlyfullyimm6('msline');
	});
	$("#summary_monthlyfullyimm-bar6").click(function(){
		summary_monthlyfullyimm6('mscolumn2d');
	});
	$("#summary_monthlyfullyimm-line6").trigger("click");
	function summary_monthlyfullyimm6(chartType='mscolumn2d')
	{
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'monthly-vaccination-TT',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "TT1-1, TT-2",
					"yaxisname": "Percentage",
					"linethickness": "2",
					"numberPostfix": "/-",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"showValues" : "1",
					"rotateValues" : "0",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
			"categories": [{
				"category": [
					<?php foreach($monthlyVaccinationTrendForTT as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [
			<?php  
			for($i=1;$i<=2;$i++){ $indexTarget="tt".$i."_target";$index="tt".$i."_vaccine";?>
			{
			  <?php echo vaccineName($index); ?>,
			  "data": [
				<?php foreach($monthlyVaccinationTrendForTT as $key => $value){ ?>
					{
						"value": "<?php echo ((isset($value[$indexTarget]) && $value[$indexTarget]!='0')?round($value[$index]*100/$value[$indexTarget]):''); ?>"
					},
				<?php } ?>
				
				]
			},
			<?php } ?>
			]
			}
		})
		.render();
	});
	}
	
	// start new codding     
	
	

	$("#summary_monthlyfullyimm-line").click(function(){
		summary_monthlyfullyimm2('line');
	});
	$("#summary_monthlyfullyimm-bar").click(function(){
		summary_monthlyfullyimm2('column2d');
	});
	$("#summary_monthlyfullyimm-bar").trigger("click");
	function summary_monthlyfullyimm2(chartType='column2d')	 
	{
		var trindline = [
					{
						"line": [
							{
								"startvalue": "40",
								"endvalue": "",
								"istrendzone": "",
								"valueonright": "1",
								"color": "DD1E2F",
								"displayvalue": "0-40 %",
								"showontop": "1",
								"thickness": "2"
							},
							{
								"startvalue": "60",
								"endvalue": "",
								"istrendzone": "",
								"valueonright": "1",
								"color": "EBB035",
								"displayvalue": "41-60 %",
								"showontop": "1",
								"thickness": "2"
							},
							{
								"startvalue": "80",
								"endvalue": "",
								"istrendzone": "",
								"valueonright": "1",
								"color": "0B7546",
								"displayvalue": "61-80 %",
								"showontop": "1",
								"thickness": "2"
							},
							{
								"startvalue": "100",
								"endvalue": "",
								"istrendzone": "",
								"valueonright": "1",
								"color": "0B7546",
								"displayvalue": "100 %",
								"showontop": "1",
								"thickness": "2"
							}
						]
					}
				];
				if(chartType!='column2d'){
					trindline='';
				}
		FusionCharts.ready(function() {
			var salesChart1 = new FusionCharts({
				type: chartType,
				renderAt: 'monthly-coverage',
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource: {
					"chart": {
					"caption": "Monthly Vaccination Coverage<?php echo $distYear1; ?>",
					"subcaption": "Fully Immunized",
					"yaxisname": "Percentage",
					"linethickness": "2",
					"numberPostfix": "/-",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"showValues" : "1",
					"rotateValues" : "0",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
					 "data": [<?php foreach($monthlyVaccinationTrendForfullyimmunized as $key => $value){ ?>
								{
									"label": "<?php echo $value['fmonth']; ?>",
									"value": "<?php echo (isset($value['target']) && $value['target']!='0')?round(($value['monthlyvacc']*100)/$value['target']):''; ?>"
								}, 
							<?php } ?>],
					"trendlines": trindline
				}
			}) 
			.render();
		});
	
	}
	
 	$("#summary_monthlyfullyimm-line7").click(function(){
		summary_monthlyfullyimm7('msline');
	});
	$("#summary_monthlyfullyimm-bar7").click(function(){
		summary_monthlyfullyimm7('mscolumn2d');
	});
	$("#summary_monthlyfullyimm-line7").trigger("click");
	function summary_monthlyfullyimm7(chartType='mscolumn2d')
	{ 
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'sessions-dropout-grapgh1',
			width: '1250',
			height: '400',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Sessions Dropout Trend<?php echo $distYear1; ?>",
					"subcaption": "Fixed, Outreach, Health House",
					"yaxisname": "Percentage",
					"linethickness": "2",
					"numberPostfix": "%",
					"showValues" : "1",
					"rotateValues" : "0",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
			"categories": [{
				"category": [
					<?php foreach($fixedSessionsDropout as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Fixed Sessions Dropout",
			  "data": [
				<?php foreach($fixedSessionsDropout as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?round($value['dropout']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "Outreach Sessions Dropout",
			  "data": [
				<?php foreach($outreachSessionsDropout as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?round($value['dropout']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "Health House Sessions Dropout",
			  "data": [
				<?php foreach($healthhouseSessionsDropout as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?round($value['dropout']):0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
	$("#summary_monthlyfullyimm-line8").click(function(){
		summary_monthlyfullyimm8('msline');
	});
	$("#summary_monthlyfullyimm-bar8").click(function(){
		summary_monthlyfullyimm8('mscolumn2d');
	});
	$("#summary_monthlyfullyimm-line8").trigger("click");
	function summary_monthlyfullyimm8(chartType='mscolumn2d')
	{
		FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'dropout-grapgh-rate',
			width: '1250',
			height: '400',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Month wise Dropout Trend<?php echo $distYear1; ?>",
					"subcaption": "PENTA-I - MR-I, PENTA-I - PENTA-III, MR-I - MR-II, TT-I - TT-II, IPV-1 - IPV-2",
					"yaxisname": "Percentage",
					"linethickness": "2",
					"numberPostfix": "%",
					"showValues" : "1",
					"rotateValues" : "0",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
			"categories": [{
				"category": [
					<?php foreach($penta1_measles1 as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "PENTA-I - MR-I Dropout",
			  "data": [
				<?php foreach($penta1_measles1 as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?round($value['dropout']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "PENTA-I - PENTA-III Dropout",
			  "data": [
				<?php foreach($penta1_penta3 as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?round($value['dropout']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "MR-I - MR-II Dropout",
			  "data": [
				<?php foreach($measles1_measles2 as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?round($value['dropout']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "TT-I - TT-II Dropout",
			  "data": [
				<?php foreach($tt1_tt2 as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?round($value['dropout']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "IPV-I - IPV-II Dropout",
			  "data": [
				<?php foreach($ipv1_ipv2 as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?round($value['dropout']):0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
	$("#summary_monthlyfullyimm-line9").click(function(){
		summary_monthlyfullyimm9('msline');
	});
	$("#summary_monthlyfullyimm-bar9").click(function(){
		summary_monthlyfullyimm9('mscolumn2d');
	});
	$("#summary_monthlyfullyimm-line9").trigger("click");
	function summary_monthlyfullyimm9(chartType='mscolumn2d')
	{
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'monthly-summary-usage-wastage-rate-trend',
			width: '1250',
			height: '450',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccine Usage and Wastage Rates<?php echo $distYear1; ?>",
					"subcaption": "<?php echo $productsNameArray[$vaccineId]; ?> Vaccine",
					"yaxisname": "Percentage",
					"xaxisname": "Year-Month",
					"linethickness": "2",
					"numberPostfix": "%",
					"showValues" : "1",
					"rotateValues" : "0",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
			"categories": [{
				"category": [
					<?php foreach($vaccineWastageRate as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>",
						"showverticalline": "1"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Vaccine Wastage Rate",
			  "data": [
				<?php foreach($vaccineWastageRate as $key => $value){ ?>
					{
						"value": "<?php echo ($value['wastage'] != NULL AND $value['wastage'] >= 0)? round($value['wastage']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "Vaccine Usage Rate",
			  "data": [
				<?php foreach($vaccineUsageRate as $key => $value){ ?>
					{
						"value": "<?php echo ($value['usage'] != NULL AND $value['usage'] >= 0)?round($value['usage']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "Open Vials Wastage Rate",
			  "data": [
				<?php foreach($openvialWastageRate as $key => $value){ ?>
					{
						"value": "<?php echo ($value['wastage'] != NULL AND $value['wastage'] >= 0)?round($value['wastage']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "Closed Vials Wastage Rate",
			  "data": [
				<?php foreach($closedvialWastageRate as $key => $value){ ?>
					{
						"value": "<?php echo ($value['wastage'] != NULL AND $value['wastage'] >= 0)?round($value['wastage']):0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
	$("#summary_monthlyfullyimm-line10").click(function(){
		summary_monthlyfullyimm10('msline');
	});
	$("#summary_monthlyfullyimm-bar10").click(function(){
		summary_monthlyfullyimm10('mscolumn2d');
	});
	$("#summary_monthlyfullyimm-line10").trigger("click");
	function summary_monthlyfullyimm10(chartType='mscolumn2d')
	{
	
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'monthly-summary-surviellnace-rate-trend',
			width: '1250',
			height: '450',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Weekly VPD Cases Trend<?php echo $distYear1; ?>",
					//"subcaption": "For <?php echo $productsNameArray[$vaccineId]; ?> Vaccine",
					"yaxisname": "Cases",
					"xaxisname": "Year-Week",
					"linethickness": "2",
					"numberPostfix": "%",
					"showValues" : "1",
					"rotateValues" : "0",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
					"slantlabels": "0",
					"divLineAlpha": "40",
					"anchoralpha": "0",
					"animation": "1",
					"legendborderalpha": "20",
					"drawCrossLine": "1",
					"crossLineColor": "#0d0d0d",
					"crossLineAlpha": "100",
					"tooltipGrayOutColor": "#80bfff",
					"theme": "zune",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
			"categories": [{
				"category": [
					<?php foreach($weeklyOutBreakMeasles as $key => $value){ 
					?>
					{
						"label": "<?php echo $value['fweek']; ?>",
						"showverticalline": "1"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "MR",
			  "data": [
				<?php foreach($weeklyOutBreakMeasles as $key => $value){ ?>
					{
						"value": "<?php echo ($value['DiseasesCount'] != NULL AND $value['DiseasesCount'] >= 0)? round($value['DiseasesCount']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "AFP",
			  "data": [
				<?php foreach($weeklyOutBreakAFP as $key => $value){ ?>
					{
						"value": "<?php echo ($value['DiseasesCount'] != NULL AND $value['DiseasesCount'] >= 0)?round($value['DiseasesCount']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "NNT",
			  "data": [
				<?php foreach($weeklyOutBreakNNT as $key => $value){ ?>
					{
						"value": "<?php echo ($value['DiseasesCount'] != NULL AND $value['DiseasesCount'] >= 0)?round($value['DiseasesCount']):0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
});
</script>