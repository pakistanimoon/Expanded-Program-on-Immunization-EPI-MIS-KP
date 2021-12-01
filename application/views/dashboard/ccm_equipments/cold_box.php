<?php
	$distcode = (isset($id) && $id)?$id:null;
?>
<div class="container-fluid">
	<!-- available assets charts display here-->
	<div style="padding-top:10px" class="toggle">
		<div class="row">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Available Vaccine Carrier Equipments (Active)</span>
				<div class="pull-right">
					<?php if($distcode ==""){ ?>
					<a href="javascript:void(1);" id="equip-info-cb-table" style="color:#000000;font-size: 20px;" title="Tabular View">
						<span class="icon fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="equip-info-cb-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<?php } ?>
					<a href="javascript:void(1);" id="equip-info-cb-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-<?php echo (!isset($districtName)?9:12); ?>">
				<div id="charts-cold-box">Your desire result will render here....</div>
			</div>
			<?php if(!isset($districtName)){ ?>
			<div class="col-md-3">
				<div id="charts-cold-box-provincial">Your desire result will render here....</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<!-- working statu wise charts display here
	<div style="padding-top:10px" class="toggle">
		<div class="row">
			<div class="col-md-6">
				<div class="section-title" style="padding: 0px 6px; line-height:30px;">
					<span>Working Status Wise Cold Room Available</span>
					<div class="pull-right">
						<a href="javascript:void(1);" id="ws-cb-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
							<span class="icon fa fa-bar-chart"></span>
						</a>
					</div>
				</div>
				<div id="ws-cold-box-trend">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				<div class="section-title" style="padding: 0px 6px; line-height:30px;">
					<span>Asset Type Wise Cold Room Available</span>
					<div class="pull-right">
						<a href="javascript:void(1);" id="atw-cb-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
							<span class="icon fa fa-bar-chart"></span>
						</a>
					</div>
				</div>
				<div id="atw-cold-box-trend">Your desire result will render here....</div>
			</div>
		</div>
	</div>-->
</div>
<script type="text/javascript">
	$(document).ready(function() {
		function loadCBEquipInfoSection(renderAt,type='stackedcolumn2d',category,dataset){
			FusionCharts.ready(function() {
				var salesChart1 = new FusionCharts({
					type: type,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: "json",
					dataSource: {
						"chart": {
							"caption": "Available Cold Box Equipments (Active)",
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
				loadCBEquipInfoSection(
					'charts-cold-box-provincial',
					'stackedcolumn2d',
					<?php echo $cold_box['categorypro']; ?>,
					<?php echo $cold_box['seriespro']; ?>
				);
	<?php 	} ?>
		$("#equip-info-cb-bar").click(function(){
			loadCBEquipInfoSection(
				'charts-cold-box',
				'stackedcolumn2d',<?php echo $category; ?>,
				<?php echo $seriesdata; ?>
			);
		});
		$("#equip-info-cb-bar").trigger("click");
		
		//==================ware house type wise chart
		var wh_type_wise_data = <?php echo $wh_type_wise; ?>;
		function loadcb_Wh_wise_Section(type='doughnut2d'){
			FusionCharts.ready(function() {
				var salesChart2 = new FusionCharts({
					type: type,
					renderAt: 'charts-cold-box',
					width: '100%',
					height: '360',
					dataFormat: "json",
					dataSource: {
					"chart": {
						"caption": "Available Cold Box Equipments (Active)",
						"subcaption": "<?php echo (isset($districtName)?$districtName:$this->session->provincename); ?>",
						"yaxisname": "Numbers",
						"linethickness": "2",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"centerLabel": "Cold Box at $label Store",
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
		$("#equip-info-cb-pie").click(function(){
			loadcb_Wh_wise_Section('doughnut2d');
		});
		$("#equip-info-cb-table").click(function(){
			equdataTable(wh_type_wise_data,'charts-cold-box','Store Level','Available Cold Box','350');
		});
		/* function loadVCWsSection(type='column2d'){
		$('#ws-cb-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'vaccinecarrier'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_wsWise_counts",
			success: function(result)
			{
				//work for linkeddata
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'ws-cold-box-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Working Status Wise Available Equipments of Cold Box (All Districts)",
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
	$("#ws-cb-bar").click(function(){
		loadVCWsSection('column2d');
	});
	$("#ws-cb-bar").trigger("click"); */
	});
</script>