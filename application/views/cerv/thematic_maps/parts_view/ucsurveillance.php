<div class="container-fluid">
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<span>Weekly Distribution of Suspected Measles Cases</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='surveillance_monthlyfullyimm-line'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='surveillance_monthlyfullyimm-bar'></i></span></a> 
							</div>
				</div>
				<div id="uc-surveillance-graph1">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<span>Weekly Distribution of AFP Cases</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='surveillance_monthlyfullyimm-line1'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='surveillance_monthlyfullyimm-bar1'></i></span></a> 
							</div>
				</div>
				<div id="surveillance-graph3">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<span>Weekly Distribution of NNT Cases</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
					<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='surveillance_monthlyfullyimm-line2'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='surveillance_monthlyfullyimm-bar2'></i></span></a> 
							</div>
				</div>
				<div id="surveillance-graph4">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<span>Weekly Distribution of Diphtheria Cases</span><strong style="font-size:11px;"><?php echo $distYear ?></strong>
						<div class="pull-right">
							<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='surveillance_monthlyfullyimm-line3'></i></span></a>
							<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='surveillance_monthlyfullyimm-bar3'></i></span></a> 
							</div>
				</div>
				<div id="surveillance-graph5">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<span>Weekly Completeness and Timeliness of Surveillance Zero Reports</span>
					<div class="pull-right">
						<a style="color:#000000; cursor: pointer;" title="Line View"><span ><i class="icon fa fa-line-chart" id='surveillance_monthlyfullyimm-line4'></i></span></a>
						<a style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" id='surveillance_monthlyfullyimm-bar4'></i></span></a> 
					</div>
				</div>
				<div id="uc-surveillance-graph2">Your desire result will render here....</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#surveillance_monthlyfullyimm-line4").click(function(){
		coverage_monthlyfullyimm4('msline');
	});
	$("#surveillance_monthlyfullyimm-bar4").click(function(){
		coverage_monthlyfullyimm4('mscolumn2d');
	});
	$("#surveillance_monthlyfullyimm-line4").trigger("click");
	function coverage_monthlyfullyimm4(chartType='mscolumn2d')
	{	
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: chartType,
			renderAt: 'uc-surveillance-graph2',
			width: '100%',
			height: '450',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Weekly Completeness and Timeliness of Surveillance Zero Report<?php echo $distYear1; ?>",
					"yaxisname": "Percentage",
					"xAxisname": "Year-Week",
					"linethickness": "2",
					"numberPostfix": "%",
					"showValues" : "1",
					"rotateValues" : "1",
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
					<?php foreach($weeklyZeroReportsTrend as $key => $value){ ?>
					{
						"label": "<?php echo $value['fweek']; ?>",
						"showverticalline": "1"
					}, 
					<?php } ?>
				]
			}],
			"dataset": [{
			  "seriesname": "Zero Report Completeness Rate",
			  "data": [
				<?php foreach($weeklyZeroReportsTrend as $key => $value){ ?>
					{
						"value": "<?php echo ($value['completed_prct'] != NULL && $value['completed_prct'] >= 0)?round($value['completed_prct']):0; ?>"
					}, 
				<?php } ?>
			  ]
			},
			{
			  "seriesname": "Zero Report Timeliness Rate",
			  "data": [
				<?php foreach($weeklyZeroReportsTrend as $key => $value){ ?>
					{
						"value": "<?php echo ($value['timely_prct'] != NULL && $value['timely_prct'] >= 0)?round($value['timely_prct']):0; ?>"
					}, 
				<?php } ?>
			  ]
			}
			
			]
			}
		})
		.render();
	});
	}

	var distYear1 = '<?php echo $distYear1; ?>';
	<?php if(!empty($weeklyOutBreakMeasles)){ ?>
	$("#surveillance_monthlyfullyimm-line").click(function(){
		getchartformated(
		'line',
		'uc-surveillance-graph1',
		'Weekly Distribution of Suspected Measles Cases'+distYear1,
		<?php echo $weeklyOutBreakMeasles; ?>
		);
	});
	$("#surveillance_monthlyfullyimm-bar").click(function(){
		getchartformated(
		'column2d',
		'uc-surveillance-graph1',
		'Weekly Distribution of Suspected Measles Cases'+distYear1,
		<?php echo $weeklyOutBreakMeasles; ?>
		);
	});
	 getchartformated(
		'column2d',
		'uc-surveillance-graph1',
		'Weekly Distribution of Suspected Measles Cases'+distYear1,
		<?php echo $weeklyOutBreakMeasles; ?>
		); 
	<?php }else{ ?>
		$('#uc-surveillance-graph1').text('SORRY! Not a Single Case Reported.');
	<?php } ?>
		<?php if(!empty($weeklyOutBreakDiphtheria)){ ?>
	$("#surveillance_monthlyfullyimm-line3").click(function(){
		getchartformated(
		'line',
		'surveillance-graph5',
		'Weekly Distribution of Suspected Measles Cases'+distYear1,
		<?php echo $weeklyOutBreakDiphtheria; ?>
		);
	});
	$("#surveillance_monthlyfullyimm-bar3").click(function(){
		getchartformated(
		'column2d',
		'surveillance-graph5',
		'Weekly Distribution of Suspected Measles Cases'+distYear1,
		<?php echo $weeklyOutBreakDiphtheria; ?>
		);
	});
	 getchartformated(
		'column2d',
		'surveillance-graph5',
		'Weekly Distribution of Suspected Measles Cases'+distYear1,
		<?php echo $weeklyOutBreakDiphtheria; ?>
		); 
	<?php }else{ ?>
		$('#surveillance-graph5').text('SORRY! Not a Single Case Reported.');
	<?php } ?>
	
	<?php if(!empty($weeklyOutBreakAFP)){ ?>
	$("#surveillance_monthlyfullyimm-line1").click(function(){
	getchartformated(
		'line',
		'surveillance-graph3',
		'Weekly Distribution of AFP Cases'+distYear1,
		<?php echo $weeklyOutBreakAFP; ?>
	);
	});
	$("#surveillance_monthlyfullyimm-bar1").click(function(){
	getchartformated(
		'column2d',
		'surveillance-graph3',
		'Weekly Distribution of AFP Cases'+distYear1,
		<?php echo $weeklyOutBreakAFP; ?>
	);
	});
	getchartformated(
		'column2d',
		'surveillance-graph3',
		'Weekly Distribution of AFP Cases'+distYear1,
		<?php echo $weeklyOutBreakAFP; ?>
	);
	<?php }else{ ?>
		$('#surveillance-graph3').text('SORRY! Not a Single Case Reported.');
	<?php } ?>
	<?php if(!empty($weeklyOutBreakNNT)){ ?>
	$("#surveillance_monthlyfullyimm-line2").click(function(){
	getchartformated(
		'line',
		'surveillance-graph4',
		'Weekly Distribution of NNT Cases'+distYear1,
		<?php echo $weeklyOutBreakNNT; ?>
	);
	});
	$("#surveillance_monthlyfullyimm-bar2").click(function(){
	getchartformated(
		'column2d',
		'surveillance-graph4',
		'Weekly Distribution of NNT Cases'+distYear1,
		<?php echo $weeklyOutBreakNNT; ?>
	);
	});
	getchartformated(
		'column2d',
		'surveillance-graph4',
		'Weekly Distribution of NNT Cases'+distYear1,
		<?php echo $weeklyOutBreakNNT; ?>
	);
	<?php }else{ ?>
		$('#surveillance-graph4').text('SORRY! Not a Single Case Reported.');
	<?php } ?>
	function getchartformated(type,renderAt,caption,data){
		FusionCharts.ready(function() {
			new FusionCharts({
				type: type,
				renderAt: renderAt,
				width: '100%',
				height: '450',
				dataFormat: 'json',
				dataSource: {
						"chart": {
							"caption": caption,
							"rotateValues" : "0",
							"plotfillhovercolor": "#6baa01",
							"showplotborder": "0",
							"xaxisname": "Year-Week",
							"labelDisplay": "rotate",
							"yaxisname": "Number Of Cases",
							"xAxisMinValue": "0",
							"xAxisMaxValue": "1",
							"yAxisMinValue": "0",
							"numdivlines": "10",
							"showvalues": "1",
							"xAxisLabelMode": "MIXED",
							"showtrendlinelabels": "0",
							//"bubbleHoverAlpha": "20",
							"plottooltext": "Measles Cases : $value",
							"exportenabled": "1",
							"exportatclient": "1",
							"exporthandler": "http://export.api3.fusioncharts.com",
							"html5exporthandler": "http://export.api3.fusioncharts.com",
							"theme": "fint"					
							},
						"data": data
						}
			}).render();
		});
	}
});
function openInNewTab(url) { alert(url);
    $("<a>").attr("href", url).attr("target", "_blank")[0].click();
}
function drilldownfun(typeCase,codeParam,yearParam,weekParam){
	var NameCode = 0;
	var distcode = 0;
	var uncode = 0;
	var tcode = 0;
	var year = yearParam;
	var week = weekParam;
	if(codeParam.length==3){
		NameCode='distcode';
		distcode = codeParam;
	}
	if(codeParam.length==9){
		NameCode='uncode';
		uncode = codeParam;
	}
	var url = "<?php echo base_url(); ?>Linelists/paginationt?distcode="+distcode+"&tcode="+tcode+"&uncode="+uncode+"&year="+year+"&week="+week+"&case_type="+typeCase+"&cross_notified=0";
	if(typeCase =="AFP" || typeCase =="NT")
	{
		var code='<input type="hidden" name="'+NameCode+'" value="' + codeParam + '">';
		var year='<input type="hidden" name="year" value="' + yearParam + '">';
		var week='<input type="hidden" name="week" value="' + weekParam + '">';
		var caseType='<input type="hidden" name="case_type" value="'+typeCase+'">';
		$('<form id="tempform" action="<?php echo base_url();?>Linelists/Surveillance" method="POST" target="_blank">'+code+year+week+caseType+'</form>').appendTo($(document.body)).submit();
	}
	else
	{
		window.open(url, '_blank').focus();
	}	
}
</script>