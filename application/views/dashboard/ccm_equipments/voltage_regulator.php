<?php
	$distcode = (isset($id) && $id)?$id:null;
?>
<div class="container-fluid">
	<!-- available assets charts display here-->
	<div style="padding-top:10px" class="toggle">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title" style="padding: 0px 6px; line-height:30px;">
					<span>Available Voltage Regulator Equipments (Active)</span>
					<div class="pull-right">
						<?php if($distcode ==""){ ?>
						<a href="javascript:void(1);" id="equip-info-vr-table" style="color:#000000;font-size: 20px;" title="Tabular View">
							<span class="icon fa fa-table"></span>
						</a>
						<a href="javascript:void(1);" id="equip-info-vr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
							<span class="icon fa fa-pie-chart"></span>
						</a>
						<?php } ?>
						<a href="javascript:void(1);" id="equip-info-vr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
							<span class="icon fa fa-bar-chart"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-<?php echo (!isset($districtName)?9:12); ?>">
				<div id="charts-voltage-regulator">Your desire result will render here....</div>
			</div>
			<?php if(!isset($districtName)){ ?>
			<div class="col-md-3">
				<div id="charts-voltage-regulator-provincial">Your desire result will render here....</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Voltage Regulator Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="yw-vr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="yw-vr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="yw-vr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="yw-vr-trend">Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Years Wise Voltage Regulator Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-yw-vr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="store-yw-vr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-yw-vr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-yw-vr-trend">Your desire result will render here....</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Voltage Regulator Available</span>
				<div class="pull-right">
					<!--<a href="javascript:void(1);" id="district-yw-vr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="district-yw-vr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>-->
				</div>
			</div>
			<div id="district-yw-vr-trend">Your desire result will render here....</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		function loadVREquipInfoSection(renderAt,type='stackedcolumn2d',category,dataset){
			FusionCharts.ready(function() {
				var salesChart1 = new FusionCharts({
					type: type,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: "json",
					dataSource: {
						"chart": {
							"caption": "Available Voltage Regulator Equipments (Active)",
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
							"showLegend": "<?php echo (isset($districtName)? 0:1); ?>"
						},
						"categories": category,
						"dataset": dataset
					}
				}).render();//console.log(salesChart1);
			});
		}
	<?php	if(!isset($districtName)){ ?>
				loadVREquipInfoSection(
					'charts-voltage-regulator-provincial',
					'stackedcolumn2d',
					<?php echo $voltage_regulator['categorypro']; ?>,
					<?php echo $voltage_regulator['seriespro']; ?>
				);
	<?php 	} ?>
		$("#equip-info-vr-bar").click(function(){
			loadVREquipInfoSection(
				'charts-voltage-regulator',
				'stackedcolumn2d',<?php echo $category; ?>,
				<?php echo $seriesdata; ?>
			);
		});
		$("#equip-info-vr-bar").trigger("click");
		//==================ware house type wise chart
		var wh_type_wise_data = <?php echo $wh_type_wise; ?>;
		function loadvr_Wh_wise_Section(type='doughnut2d'){
			FusionCharts.ready(function() {
				var salesChart2 = new FusionCharts({
					type: type,
					renderAt: 'charts-voltage-regulator',
					width: '100%',
					height: '360',
					dataFormat: "json",
					dataSource: {
					"chart": {
						"caption": "Available Voltage Regulator Equipments (Active)",
						"subcaption": "<?php echo (isset($districtName)?$districtName:$this->session->provincename); ?>",
						"yaxisname": "Numbers",
						"linethickness": "2",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"centerLabel": "Cold Room at $label Store",
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
						"showBorder": "1"
					},
					"data": wh_type_wise_data
				}
				}).render();//console.log(salesChart2);
			});
		}
		$("#equip-info-vr-pie").click(function(){
			loadvr_Wh_wise_Section('doughnut2d');
		});
		$("#equip-info-vr-table").click(function(){
			equdataTable(wh_type_wise_data,'charts-voltage-regulator','Store Level','Available Voltage Regulator','350');
		});
		//////working status wise code======================
	/* function loadVRWsSection(type='column2d'){
		$('#ws-vr-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'voltageregulator'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_wsWise_counts",
			success: function(result)
			{
				//work for linkeddata
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'ws-vr-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Working Status Wise Available Equipments of Voltage Regulator (All Districts)",
								//"subCaption": "Click on column/line/slice to drill down to region wise information of respective Level",
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Numbers",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
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
	$("#ws-vr-bar").click(function(){
		loadVRWsSection('column2d');
	});
	$("#ws-vr-bar").trigger("click"); */
	
	////////  Year wise refrigerator
	function loadvrYWSection(type='column2d',table=null){
		$('#yw-vr-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'voltageregulator'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_ysWise_counts",
			success: function(result)
			{
				if(table)
				{
					//alert('kdghweuifdew');
					equdataTable(result,'yw-vr-trend','Year','Count','350'); 
				}
				else{ 
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'yw-vr-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Year Wise Available Equipments of Voltage Regulator (All Districts)",
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
			}
		});
	}
	$("#yw-vr-pie").click(function(){
		loadvrYWSection('doughnut2d');
	});
	$("#yw-vr-bar").click(function(){
		loadvrYWSection('column2d');
	});
	$("#yw-vr-table").click(function(){
		loadvrYWSection('a','table');
	});
	
	$("#yw-vr-bar").trigger("click");
	$("#store-yw-vr-bar").click(function(){
		ywCountgetData('2018','voltageregulator','store-yw-vr-trend','column2d');
	});
	$("#store-yw-vr-pie").click(function(){
		ywCountgetData('2018','voltageregulator','store-yw-vr-trend','doughnut2d');
	});
	/* $("#store-yw-vr-table").click(function(){
		ywCountgetData('2018','voltageregulator','store-yw-vr-trend','a','table');
	}); */
	
	
	ywCountgetData('2018','voltageregulator','store-yw-vr-trend','doughnut2d');
	ywDrildwondistricts('4','voltageregulator','2018','district-yw-vr-trend','column2d');
	});
</script>