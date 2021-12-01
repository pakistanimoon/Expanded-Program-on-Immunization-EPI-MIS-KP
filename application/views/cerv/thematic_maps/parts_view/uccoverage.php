<div class="container-fluid">
	<div class="row state-overview-t10">
		<div class="col-lg-4 col-sm-4">
			<div class="card">
				<div class="card-header green">
					<div class="icon">
						<i class="fa fa-user"></i>
					</div>
					<div class="title">
						<p>Targets</p>
					</div>
				</div>
				<div class="card-body green-m">
					<ul>
						<br>
						<!-- <li>Male <span><?php //echo round((round($monthlyTarget->target)*51)/100); ?></span></li>
						<li>Female <span><?php //echo round((round($monthlyTarget->target)*49)/100); ?></span></li> -->
						<li>Male <span><?php echo $monthly_yearly_target['totalMaleTarget']; ?></span></li>
						<li>Female <span><?php echo $monthly_yearly_target['totalFemaleTarget']; ?></span></li>
					</ul>
				</div>
				<div class="card-footer green-d">
					<p>Total <span><?php echo $monthly_yearly_target['totalTarget']; ?></span></p>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4">
			<div class="card">
				<div class="card-header grey">
					<div class="icon">
						<i class="fa fa-hourglass-start"></i>
					</div>
					<div class="title">
						<p>Sessions Planned</p>
					</div>
				</div>
				<div class="card-body grey-m">
					<ul>
						<li>Fixed <span><?php echo $fixedPlanned = ($sessionPlannedHeld->fixedplanned > 0)?$sessionPlannedHeld->fixedplanned:0; ?></span></li>
						<li>Outreach <span><?php echo $outreachPlanned = ($sessionPlannedHeld->outreachplanned > 0)?$sessionPlannedHeld->outreachplanned:0; ?></span></li>
						<li>LHW <span><?php echo $lhwPlanned = ($sessionPlannedHeld->healthhouseplanned > 0)?$sessionPlannedHeld->healthhouseplanned:0; ?></span></li>
					</ul>
				</div>
				<div class="card-footer grey-d">
					<p>Total <span><?php echo $fixedPlanned+$outreachPlanned+$lhwPlanned; ?></span></p>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4">
			<div class="card">
				<div class="card-header teal">
					<div class="icon">
						<i class="fa fa-hourglass-half"></i>
					</div>
					<div class="title">
						<p>Sessions Held</p>
					</div>
				</div>
				<div class="card-body teal-m">
					<ul>
						<li>Fixed <span><?php echo $fixedHeld = ($sessionPlannedHeld->fixedheld > 0)?$sessionPlannedHeld->fixedheld:0; ?></span></li>
						<li>Outreach <span><?php echo $outreachHeld = ($sessionPlannedHeld->outreachheld > 0)?$sessionPlannedHeld->outreachheld:0; ?></span></li>
						<li>LHW <span><?php echo $lhwHeld = ($sessionPlannedHeld->healthhouseheld > 0)?$sessionPlannedHeld->healthhouseheld:0; ?></span></li>
					</ul>
				</div>
				<div class="card-footer teal-d">
					<p>Total <span><?php echo $fixedHeld+$outreachHeld+$lhwHeld; ?></span></p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered tbl-states"> 
				<thead>
					<tr>
						<td rowspan="2" class="tm"><?php echo $productsNameArray[$vaccineId]; ?> Vaccination</td>
						<td colspan="3">By Vaccinator (Fixed)</td>
						<td colspan="3">By Vaccinator (Outreach)</td>
						<td colspan="3">By Vaccinator (Mobile)</td>
						<td colspan="3">By Health House (LHW)</td>
					</tr>
					<tr>
						<td>0-11 Months</td>
						<td>12-23 Months</td>
						<td>2 Years & Above</td>
						<td>0-11 Months</td>
						<td>12-23 Months</td>
						<td>2 Years & Above</td>
						<td>0-11 Months</td>
						<td>12-23 Months</td>
						<td>2 Years & Above</td>
						<td>0-11 Months</td>
						<td>12-23 Months</td>
						<td>2 Years & Above</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$genderArray = array('male','female','total');
					$ageArray = array('0to11m','12to23m','2yearsabove');
					$vaccinationByArray = array('f'=>'fixed','o'=>'outreach','m'=>'mobile','h'=>'healthhouse');
					foreach($genderArray as $genderKey => $gender){
					?>
					<tr>
						<td class="text-center"><label><?php echo ucwords($gender); ?></label></td>
						<?php
						foreach($vaccinationByArray as $vaccbyKey => $vaccinationby){ 
							foreach($ageArray as $ageKey => $age){
								if($gender == 'total'){
									$maleRenderKey = $productsArray[$vaccineId].'_'.$vaccinationby.'_'.$age.'_'.$genderArray[$genderKey-1];
									$femaleRenderKey = $productsArray[$vaccineId].'_'.$vaccinationby.'_'.$age.'_'.$genderArray[$genderKey-2];
								}else
									$renderKey = $productsArray[$vaccineId].'_'.$vaccinationby.'_'.$age.'_'.$gender;
						?>	
							<td><?php echo ($gender=='total')?$vaccinationNumbers->$maleRenderKey+$vaccinationNumbers->$femaleRenderKey:$vaccinationNumbers->$renderKey; ?></td>
						<?php 
							}
						} 
						?>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-6">
				<div class="section-title">
					<span>Fixed Sessions Dropout Rate</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
						<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line1'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar1'></i></span></a> 
							</div>
								</div>
				<div id="uc-coverage-graph1">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				<div class="section-title">
					<span>Outreach Sessions Dropout Rate</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
						<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line2'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar2'></i></span></a> 
							</div>
								</div>
				<div id="uc-coverage-graph2">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-6">
				<div class="section-title">
					<span>Health House Sessions Dropout Rate</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
						<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line3'></i></span></a>
						<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar3'></i></span></a> 
						</div>
							</div>
				<div id="uc-coverage-graph3">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				<div class="section-title">
					<span>Monthly Vaccination Coverage Trends</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
						<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line4'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar4'></i></span></a> 
				</div>
				</div>
				<div id="vaccination-coverage-first-graph1">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
	<div class="row">
	<div class="col-md-6">
	<div class="section-title">
		<span>Monthly Vaccination Coverage Trends</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
						<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line5'></i></span></a>
						<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar5'></i></span></a> 
						</div>
	</div>
				<div id="vaccination-coverage-second-graph1">Your desire result will render here....</div>
	</div>
		<div class="col-md-6">
				<div class="section-title">
					<span>Monthly Vaccination Comparison</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
						<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line6'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar6'></i></span></a> 
				</div>
				</div>
					<div id="vaccination-coverage-third-graph1">Your desire result will render here....</div>
			</div>	
		</div>
	</div>
	<div style="padding-top:10px">
	<div class="row">
	<div class="col-md-6">
	<div class="section-title">
		<span>Monthly Vaccination Coverage Trend</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
	<div class="pull-right">
		<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line7'></i></span></a>
		<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar7'></i></span></a> 
	</div>
	</div>
			<div id="vaccination-coverage-fourth-graph1">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				
				<div class="section-title">
					<span>Monthly Vaccination Comparison</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
						<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line8'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar8'></i></span></a> 
							</div>
			</div>
				<div id="vaccination-coverage-fifth-graph1">Your desire result will render here....</div>
		</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-6">
				<div class="section-title">
					<span>Monthly Vaccination Coverage Trend</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
						<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line9'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar9'></i></span></a> 
				</div>
				</div>
				<div id="vaccination-coverage-rota1_rota2">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				<div class="section-title">
					<span>Monthly Vaccination Coverage Trend</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
				<div class="pull-right">
						<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='coverage_monthlyfullyimm-line10'></i></span></a>
						<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='coverage_monthlyfullyimm-bar10'></i></span></a> 
					</div>
					</div>
				<div id="vaccination-coverage-sixth-graph1">Your desire result will render here....</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	
	$("#coverage_monthlyfullyimm-line1").click(function(){
		coverage_monthlyfullyimm1('msline');
	});
	$("#coverage_monthlyfullyimm-bar1").click(function(){
		coverage_monthlyfullyimm1('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line1").trigger("click");
	function coverage_monthlyfullyimm1(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-coverage-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Fixed Sessions Dropout Trend<?php echo $distYear1; ?>",
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
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?$value['dropout']:0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
	$("#coverage_monthlyfullyimm-line2").click(function(){
		coverage_monthlyfullyimm2('msline');
	});
	$("#coverage_monthlyfullyimm-bar2").click(function(){
		coverage_monthlyfullyimm2('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line2").trigger("click");
	function coverage_monthlyfullyimm2(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-coverage-graph2',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Outreach Sessions Dropout Trend<?php echo $distYear1; ?>",
					"linethickness": "2",
					"yaxisname": "Percentage",
					"xaxisname": "Year-Month",
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
					<?php foreach($outreachSessionsDropout as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Outreach Sessions Dropout",
			  "data": [
				<?php foreach($outreachSessionsDropout as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?$value['dropout']:0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
	$("#coverage_monthlyfullyimm-line3").click(function(){
		coverage_monthlyfullyimm3('msline');
	});
	$("#coverage_monthlyfullyimm-bar3").click(function(){
		coverage_monthlyfullyimm3('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line3").trigger("click");
	function coverage_monthlyfullyimm3(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-coverage-graph3',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Health House Sessions Dropout Trend<?php echo $distYear1; ?>",
					"linethickness": "2",
					"yaxisname": "Percentage",
					"xaxisname": "Year-Month",
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
					<?php foreach($healthhouseSessionsDropout as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Health House Sessions Dropout",
			  "data": [
				<?php foreach($healthhouseSessionsDropout as $key => $value){ ?>
					{
						"value": "<?php echo ($value['dropout'] != NULL AND $value['dropout'] >= 0)?$value['dropout']:0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
	$("#coverage_monthlyfullyimm-line4").click(function(){
		coverage_monthlyfullyimm4('msline');
	});
	$("#coverage_monthlyfullyimm-bar4").click(function(){
		coverage_monthlyfullyimm4('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line4").trigger("click");
	function coverage_monthlyfullyimm4(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'vaccination-coverage-first-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "BCG, OPV-0, Hep-B Birth",
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
			for($i=1;$i<=18;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==1 || $i==2 || $i==3){
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
	
	$("#coverage_monthlyfullyimm-line5").click(function(){
		coverage_monthlyfullyimm5('msline');
	});
	$("#coverage_monthlyfullyimm-bar5").click(function(){
		coverage_monthlyfullyimm5('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line5").trigger("click");
	function coverage_monthlyfullyimm5(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'vaccination-coverage-second-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "OPV-1, OPV-2, OPV-3",
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
			for($i=1;$i<=18;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==4 || $i==5 || $i==6){
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
	
	$("#coverage_monthlyfullyimm-line6").click(function(){
		coverage_monthlyfullyimm6('msline');
	});
	$("#coverage_monthlyfullyimm-bar6").click(function(){
		coverage_monthlyfullyimm6('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line6").trigger("click");
	function coverage_monthlyfullyimm6(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'vaccination-coverage-third-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "PENTA-1, PENTA-2, PENTA-3",
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
			for($i=1;$i<=18;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==7 || $i==8 || $i==9){
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
	
	$("#coverage_monthlyfullyimm-line7").click(function(){
		coverage_monthlyfullyimm7('msline');
	});
	$("#coverage_monthlyfullyimm-bar7").click(function(){
		coverage_monthlyfullyimm7('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line7").trigger("click");
	function coverage_monthlyfullyimm7(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'vaccination-coverage-fourth-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "PCV10-1, PCV10-2, PCV10-3",
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
			for($i=1;$i<=18;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==10 || $i==11 || $i==12){
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
	
	$("#coverage_monthlyfullyimm-line9").click(function(){
		coverage_monthlyfullyimm9('msline');
	});
	$("#coverage_monthlyfullyimm-bar9").click(function(){
		coverage_monthlyfullyimm9('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line9").trigger("click");
	function coverage_monthlyfullyimm9(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'vaccination-coverage-rota1_rota2',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "Rota-1, Rota-2",
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
			for($i=1;$i<=18;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==14 || $i==15){
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
	
	$("#coverage_monthlyfullyimm-line8").click(function(){
		coverage_monthlyfullyimm8('msline');
	});
	$("#coverage_monthlyfullyimm-bar8").click(function(){
		coverage_monthlyfullyimm8('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line8").trigger("click");
	function coverage_monthlyfullyimm8(chartType='mscolumn2d')
	{
	
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'vaccination-coverage-fifth-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Comparison<?php echo $distYear1; ?>",
					"subcaption": "Measles-1, Measles-2",
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
			for($i=1;$i<=18;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==16 || $i==18){
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
	
	$("#coverage_monthlyfullyimm-line10").click(function(){
		coverage_monthlyfullyimm10('msline');
	});
	$("#coverage_monthlyfullyimm-bar10").click(function(){
		coverage_monthlyfullyimm10('mscolumn2d');
	});
	$("#coverage_monthlyfullyimm-line10").trigger("click");
	function coverage_monthlyfullyimm10(chartType='mscolumn2d')
	{
		
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'vaccination-coverage-sixth-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccination Coverage Trend<?php echo $distYear1; ?>",
					"subcaption": "Fully Immunized",
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
			for($i=1;$i<=18;$i++){ $indexTarget="a".$i."_target";$index="a".$i."_vaccine";
				if($i==17){
			?>
			{
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
});
</script>