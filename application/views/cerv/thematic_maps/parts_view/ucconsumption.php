<div class="container-fluid">
<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-6">
				<div class="section-title">
				
	
		<span>Vaccine Usage and Wastage Rate Analysis</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
		
		<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='consumption_monthlyfullyimm-line'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='consumption_monthlyfullyimm-bar'></i></span></a> 
							</div>
	</div>
				<div id="uc-consumption-graph1">Your desire result will render here....</div>
			</div>
			
				<div class="col-md-6">
			<div class="section-title">
					<span>Monthly Vaccine Usage Rate</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
						<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='consumption_monthlyfullyimm-line1'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='consumption_monthlyfullyimm-bar1'></i></span></a> 
							</div>
								</div>		
				<div id="uc-consumption-graph2">Your desire result will render here....</div>
			</div>
		</div>
	</div>
		<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-6">
				<div class="section-title">
		<span>Vaccine Open & Closed Vial Wastage Rate Analysis</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
		<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='consumption_monthlyfullyimm-line2'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='consumption_monthlyfullyimm-bar2'></i></span></a> 
							</div>
	</div>
				<div id="uc-consumption-graph3">Your desire result will render here....</div>
			</div>
				<div class="col-md-6">
			<div class="section-title">
					<span>Monthly Vaccine Usage Rate</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
						<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='consumption_monthlyfullyimm-line3'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='consumption_monthlyfullyimm-bar3'></i></span></a> 
							</div>
								</div>
				<div id="uc-consumption-graph4">Your desire result will render here....</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	
	$("#consumption_monthlyfullyimm-line").click(function(){
		consumption_monthlyfullyimm('msline');
	});
	$("#consumption_monthlyfullyimm-bar").click(function(){
		consumption_monthlyfullyimm('mscolumn2d');
	});
	$("#consumption_monthlyfullyimm-line").trigger("click");
	function consumption_monthlyfullyimm(chartType='mscolumn2d')
	{
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-consumption-graph1',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccine Wastage Rate<?php echo $distYear1; ?>",
					"subcaption": "<?php echo $productsNameArray[$vaccineId]; ?> Vaccine",
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
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Vaccine Wastage Rate",
			  "data": [
				<?php foreach($vaccineWastageRate as $key => $value){ ?>
					{
						"value": "<?php echo ($value['wastage'] != NULL AND $value['wastage'] >= 0)?$value['wastage']:0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
	$("#consumption_monthlyfullyimm-line1").click(function(){
		consumption_monthlyfullyimm1('msline');
	});
	$("#consumption_monthlyfullyimm-bar1").click(function(){
		consumption_monthlyfullyimm1('mscolumn2d');
	});
	$("#consumption_monthlyfullyimm-line1").trigger("click");
	function consumption_monthlyfullyimm1(chartType='mscolumn2d')
	{
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-consumption-graph2',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Vaccine Usage Rate<?php echo $distYear1; ?>",
					"subcaption": "<?php echo $productsNameArray[$vaccineId]; ?> Vaccine",
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
					<?php foreach($vaccineUsageRate as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Vaccine Usage Rate",
			  "data": [
				<?php foreach($vaccineUsageRate as $key => $value){ ?>
					{
						"value": "<?php echo ($value['usage'] != NULL AND $value['usage'] >= 0)?$value['usage']:0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
	$("#consumption_monthlyfullyimm-line2").click(function(){
		consumption_monthlyfullyimm2('msline');
	});
	$("#consumption_monthlyfullyimm-bar2").click(function(){
		consumption_monthlyfullyimm2('mscolumn2d');
	});
	$("#consumption_monthlyfullyimm-line2").trigger("click");
	function consumption_monthlyfullyimm2(chartType='mscolumn2d')
	{
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-consumption-graph3',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Open Vial Wastage Rate<?php echo $distYear1; ?>",
					"subcaption": "<?php echo $productsNameArray[$vaccineId]; ?> Vaccine",
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
					<?php foreach($openvialWastageRate as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Open Vials Wastage Rate",
			  "data": [
				<?php foreach($openvialWastageRate as $key => $value){ ?>
					{
						"value": "<?php echo ($value['wastage'] != NULL AND $value['wastage'] >= 0)?$value['wastage']:0; ?>"
					}, 
				<?php } ?>
			  ]
			}]
			}
		})
		.render();
	});
	}
	
	$("#consumption_monthlyfullyimm-line3").click(function(){
		consumption_monthlyfullyimm3('msline');
	});
	$("#consumption_monthlyfullyimm-bar3").click(function(){
		consumption_monthlyfullyimm3('mscolumn2d');
	});
	$("#consumption_monthlyfullyimm-line3").trigger("click");
	function consumption_monthlyfullyimm3(chartType='mscolumn2d')
	{
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-consumption-graph4',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Monthly Closed Vial Wastage Rate<?php echo $distYear1; ?>",
					"subcaption": "<?php echo $productsNameArray[$vaccineId]; ?> Vaccine",
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
					<?php foreach($closedvialWastageRate as $key => $value){ ?>
					{
						"label": "<?php echo $value['fmonth']; ?>"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Closed Vials Wastage Rate",
			  "data": [
				<?php foreach($closedvialWastageRate as $key => $value){ ?>
					{
						"value": "<?php echo ($value['wastage'] != NULL AND $value['wastage'] >= 0)?$value['wastage']:0; ?>"
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