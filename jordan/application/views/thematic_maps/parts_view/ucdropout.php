<div class="container-fluid">
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-6">
				<div class="section-title">
					<span>Penta 1 - Penta 3 Dropout Rate</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='dropout_monthlyfullyimm-line1'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='dropout_monthlyfullyimm-bar1'></i></span></a> 
							</div>
				</div>
				<div id="uc-dropout-graph2">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				<div class="section-title">
					<span>Penta 1 – Measles 1 Dropout Rate </span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='dropout_monthlyfullyimm-line'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='dropout_monthlyfullyimm-bar'></i></span></a> 
							</div>
				</div>
				<div id="uc-dropout-graph1">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-6">
				<div class="section-title">
					<span>Measles 1 - Measles 2 Dropout Rate</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='dropout_monthlyfullyimm-line2'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='dropout_monthlyfullyimm-bar2'></i></span></a> 
							</div>
				</div>
				<div id="uc-dropout-graph3">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				<div class="section-title">
					<span>TT 1 - TT 2 Dropout Rate</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='dropout_monthlyfullyimm-line3'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='dropout_monthlyfullyimm-bar3'></i></span></a> 
							</div>
				</div>
				<div id="uc-dropout-graph4">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<span>Rota 1 - Rota 2 Dropout Rate</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='dropout_monthlyfullyimm-line4'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='dropout_monthlyfullyimm-bar4'></i></span></a> 
							</div>
				</div>
				<div id="uc-dropout-rota1-rota2">Your desire result will render here....</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#dropout_monthlyfullyimm-line").click(function(){
		coverage_monthlyfullyimm('msline');
	});
	$("#dropout_monthlyfullyimm-bar").click(function(){
		coverage_monthlyfullyimm('mscolumn2d');
	});
	$("#dropout_monthlyfullyimm-line").trigger("click");
	function coverage_monthlyfullyimm(chartType='mscolumn2d')
	{	
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-dropout-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Dropout Rate<?php echo $distYear1; ?>",
					"subcaption":"Penta 1 - Measles 1",
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
			  "seriesname": "Penta 1 - Measles 1",
			  "data": [
				<?php foreach($penta1_measles1 as $key => $value){ ?>
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
	$("#dropout_monthlyfullyimm-line1").click(function(){
		coverage_monthlyfullyimm1('msline');
	});
	$("#dropout_monthlyfullyimm-bar1").click(function(){
		coverage_monthlyfullyimm1('mscolumn2d');
	});
	$("#dropout_monthlyfullyimm-line1").trigger("click");
	function coverage_monthlyfullyimm1(chartType='mscolumn2d')
	{	
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-dropout-graph2',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Dropout Rate<?php echo $distYear1; ?>",
					"subcaption":"Penta 1 - Penta 3",
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
					<?php foreach($penta1_penta3 as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Penta 1 - Penta 3",
			  "data": [
				<?php foreach($penta1_penta3 as $key => $value){ ?>
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
	$("#dropout_monthlyfullyimm-line2").click(function(){
		coverage_monthlyfullyimm2('msline');
	});
	$("#dropout_monthlyfullyimm-bar2").click(function(){
		coverage_monthlyfullyimm2('mscolumn2d');
	});
	$("#dropout_monthlyfullyimm-line2").trigger("click");
	function coverage_monthlyfullyimm2(chartType='mscolumn2d')
	{	
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-dropout-graph3',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Dropout Rate<?php echo $distYear1; ?>",
					"subcaption":"Measles 1 - Measles 2",
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
					<?php foreach($measles1_measles2 as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Measles 1 - Measles 2",
			  "data": [
				<?php foreach($measles1_measles2 as $key => $value){ ?>
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
	$("#dropout_monthlyfullyimm-line3").click(function(){
		coverage_monthlyfullyimm3('msline');
	});
	$("#dropout_monthlyfullyimm-bar3").click(function(){
		coverage_monthlyfullyimm3('mscolumn2d');
	});
	$("#dropout_monthlyfullyimm-line3").trigger("click");
	function coverage_monthlyfullyimm3(chartType='mscolumn2d')
	{	
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-dropout-graph4',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Dropout Rate<?php echo $distYear1; ?>",
					"subcaption":"TT 1 - TT 2",
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
					<?php foreach($tt1_tt2 as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "TT 1 - TT 2",
			  "data": [
				<?php foreach($tt1_tt2 as $key => $value){ ?>
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
	$("#dropout_monthlyfullyimm-line4").click(function(){
		coverage_monthlyfullyimm4('msline');
	});
	$("#dropout_monthlyfullyimm-bar4").click(function(){
		coverage_monthlyfullyimm4('mscolumn2d');
	});
	$("#dropout_monthlyfullyimm-line4").trigger("click");
	function coverage_monthlyfullyimm4(chartType='mscolumn2d')
	{	
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-dropout-rota1-rota2',
			width: '100%',
			height: '450',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Dropout Rate<?php echo $distYear1; ?>",
					"subcaption":"Rota 1 - Rota 2",
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
					<?php foreach($rota1_rota2 as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Rota 1 - Rota 2",
			  "data": [
				<?php foreach($rota1_rota2 as $key => $value){ ?>
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
});
</script>