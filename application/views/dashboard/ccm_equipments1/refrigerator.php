<?php //print_r($refrigerator);exit; ?>
<div class="container-fluid">
	<!-- available assets charts display here-->
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Available Refrigerator Equipments (Active)</span>
				<div class="pull-right">
					<?php if(! isset($districtName)){ ?>
					<a href="javascript:void(1);" id="equip-info-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<?php } ?>
					<a href="javascript:void(1);" id="equip-info-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-<?php echo (!isset($districtName)?'9':'12'); ?>">
			<div id="charts-refrigerator">Your desire result will render here....</div>
		</div>
		<?php if(!isset($districtName)){ ?>
		<div class="col-md-3">
			<div id="charts-refrigerator-provincial">Your desire result will render here....</div>
		</div>
		<?php } ?>
	</div>
	<br>
	<!-- working statu wise charts display here-->
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Working Status Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="ws-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="ws-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="ws-refg-trend">Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Store Wise Working Status of Available Refrigerators </span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-ws-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-ws-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-ws-refg-trend">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Working Status Wise Refrigerators Available</span>
				<div class="pull-right">
					<!--<a href="javascript:void(1);" id="atw-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>-->
				</div>
			</div>
			<div id="district-ws-refg-trend">Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="atw-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="atw-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="atw-refg-trend">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-atw-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-atw-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-atw-refg-trend">Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Refrigerators Available</span>
				<div class="pull-right">
					<!--<a href="javascript:void(1);" id="district-atw-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="district-atw-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>-->
				</div>
			</div>
			<div id="district-atw-refg-trend">Your desire result will render here....</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		function loadREFEquipInfoSection(renderAt,type='stackedcolumn2d',category,dataset){
			FusionCharts.ready(function() {
				var salesChart1 = new FusionCharts({
					type: type,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: "json",
					dataSource: {
						"chart": {
							"caption": "Available Refrigerator Equipments (Active)",
							"subcaption": "<?php echo (isset($districtName)?$districtName:$this->session->provincename); ?>",
							"yaxisname": "Numbers",
							"linethickness": "2",
							"formatnumberscale": "1",
							"baseFont": "lato-regular",
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
							"useDataPlotColorForLabels": "1",                    
							"exportenabled": "1",
							"showBorder": "1",
							"labelDisplay": "rotate",
							"slantLabels": "1",
							//"rotateLabels": "0",
							"useEllipsesWhenOverflow":"0",
							"showLegend": "<?php echo (isset($districtName)? 0:1); ?>"
						},
						"categories": category,
						"dataset": dataset
					}
				}).render();//console.log(salesChart1);
			});
		}
	<?php	if(!isset($districtName)){ ?>
				loadREFEquipInfoSection(
					'charts-refrigerator-provincial',
					'stackedcolumn2d',
					<?php echo $refrigerator['categorypro']; ?>,
					<?php echo $refrigerator['seriespro']; ?>
				);
	<?php 	} ?>
		$("#equip-info-refg-bar").click(function(){
			loadREFEquipInfoSection(
				'charts-refrigerator',
				'stackedcolumn2d',<?php echo $category; ?>,
				<?php echo $seriesdata; ?>
			);
		});
		$("#equip-info-refg-bar").trigger("click");
		//==================ware house type wise charts
		var wh_type_wise_data = <?php echo $wh_type_wise; ?>;
		function loadrefWh_wise_Section(type='doughnut2d'){
			FusionCharts.ready(function() {
				var salesChart2 = new FusionCharts({
					type: type,
					renderAt: 'charts-refrigerator',
					width: '100%',
					height: '360',
					dataFormat: "json",
					dataSource: {
					"chart": {
						"caption": "Level Wise Equipments of Refrigerator (All Districts)",
						"subcaption": "<?php echo (isset($districtName)?$districtName:$this->session->provincename); ?>",
						"yaxisname": "Numbers",
						"linethickness": "2",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"centerLabel": " Refrigerator at $label Store",
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
						"valueFontColor": "#000000",
						"valueBgColor": "#FFFFFF",
						"valueBgAlpha": "50",
						"thousandSeparatorPosition": "3,3,3",
						"useDataPlotColorForLabels": "1",                    
						"exportenabled": "1",
						"showBorder": "1"
					  },
					"data": wh_type_wise_data
				}
				}).render();//console.log(salesChart2);
			});
		}
	$("#equip-info-refg-pie").click(function(){
		loadrefWh_wise_Section('doughnut2d');
	});
	//////working status code======================
	function loadRefgWsSection(type='column2d'){
		$('#ws-refg-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'refrigerator'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_wsWise_counts",
			success: function(result)
			{
				//work for linkeddata
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'ws-refg-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Working Status Wise Available Equipments of Refrigerators (All Districts)",
								"subCaption": "Click on column/line/slice to drill down to Store wise information of respective Level",
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Numbers",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
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
								"rotateLabels" : "1",
								"slantLabels" : "1",
								"valueFontColor": "#000000",
								"valueBgColor": "#FFFFFF",
								"valueBgAlpha": "50",
								"thousandSeparatorPosition": "3,3,3",
								"useDataPlotColorForLabels": "1",                    
								"exportenabled": "1",
								"showBorder": "1"
							},
							"data": result
						}
					})
					.render();
				});
			}
		});
	}
	$("#ws-refg-pie").click(function(){
		loadRefgWsSection('doughnut2d');
	});
	$("#ws-refg-bar").click(function(){
		loadRefgWsSection('column2d');
	});
	$("#ws-refg-bar").trigger("click");
	
	$("#store-ws-refg-bar").click(function(){
		wsCountgetData('1','1','refrigerator','Working Well','store-ws-refg-trend','column2d');
	});
	$("#store-ws-refg-pie").click(function(){
		wsCountgetData('1','1','refrigerator','Working Well','store-ws-refg-trend','doughnut2d');
	});
	wsCountgetData('1','1','refrigerator','Working Well','store-ws-refg-trend','doughnut2d');
	wsDrildwondistricts('6','1','1','Working Well','district-ws-refg-trend','column2d');
	
	////////  asset type wise refrigerator
	function loadRefgATWSection(type='column2d'){
		$('#atw-refg-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'refrigerator'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_assetType_counts",
			success: function(result)
			{
				//work for linkeddata
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'atw-refg-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Asset Type Wise Available Equipments of Refrigerators (All Districts)",
								"subCaption": "Click on column/line/slice to drill down to Store wise information of respective Level",
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Numbers",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
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
								"rotateValues" : "1",
								"rotateLabels" : "1",
								"slantLabels" : "1",
								"valueFontColor": "#000000",
								"valueBgColor": "#FFFFFF",
								"valueBgAlpha": "50",
								"thousandSeparatorPosition": "3,3,3",
								"useDataPlotColorForLabels": "1",                    
								"exportenabled": "1",
								"showBorder": "1"
							},
							"data": result
						}
					})
					.render();
				});
			}
		});
	}
	$("#atw-refg-pie").click(function(){
		loadRefgATWSection('doughnut2d');
	});
	$("#atw-refg-bar").click(function(){
		loadRefgATWSection('column2d');
	});
	$("#atw-refg-bar").trigger("click");
	
	//// for atw store level charts first time load
	$("#store-atw-refg-bar").click(function(){
		atwCountgetData('13','refrigerator','Ice Lined Refrigerator','store-atw-refg-trend','column2d');
	});
	$("#store-atw-refg-pie").click(function(){
		atwCountgetData('13','refrigerator','Ice Lined Refrigerator','store-atw-refg-trend','doughnut2d');
	});
	atwCountgetData('13','refrigerator','Ice Lined Refrigerator','store-atw-refg-trend','doughnut2d');
	
	/* $("#district-atw-refg-bar").click(function(){
		atwDrildwondistricts('4','1','13','district-atw-refg-trend','column2d');
	});
	$("#district-atw-refg-pie").click(function(){
		atwDrildwondistricts('4','1','13','district-atw-refg-trend','doughnut2d');
	}); */
	atwDrildwondistricts('4','refrigerator','13','Ice Lined Refrigerator','district-atw-refg-trend','column2d');
	});
</script>