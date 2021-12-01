<?php
	$distcode = (isset($id) && $id)?$id:null;
?>
<div class="container-fluid">
	<!-- available assets charts display here-->
	<div style="padding-top:10px" class="toggle">
		<div class="row">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Available Transport Equipments (Active)</span>
				<div class="pull-right">
					<?php if($distcode ==""){ ?>
				    <a href="javascript:void(1);" id="equip-info-transp-table" style="color:#000000;font-size: 20px;" title="Tabular View ">
						<span class="icon fa fa-table"></span>
					</a>
					
					<a href="javascript:void(1);" id="equip-info-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<?php } ?>
					<a href="javascript:void(1);" id="equip-info-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-<?php echo (!isset($districtName)?9:12); ?>">
				<div id="charts-transp">Your desire result will render here....</div>
			</div>
			<?php if(!isset($districtName)){ ?>
			<div class="col-md-3">
				<div id="charts-transp-provincial">Your desire result will render here....</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<!-- working statu wise charts display here-->
	<div style="padding-top:10px" class="toggle">
		<div class="row">
			<div class="col-md-6">
				<div class="section-title" style="padding: 0px 6px; line-height:30px;">
					<span>Working Status Wise Transport Available</span>
					<div class="pull-right">
						<a href="javascript:void(1);" id="ws-transp-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
						</a>
						<a href="javascript:void(1);" id="ws-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
						</a>
						<a href="javascript:void(1);" id="ws-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
							<span class="icon fa fa-bar-chart"></span>
						</a>
					</div>
				</div>
				<div id="ws-transp-trend">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				<div class="section-title" style="padding: 0px 6px; line-height:30px;">
					<span>Store Wise Working Status of Available Transport </span>
					<div class="pull-right">
						<a href="javascript:void(1);" id="store-ws-transp-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
						</a>
						<a href="javascript:void(1);" id="store-ws-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
							<span class="icon fa fa-pie-chart"></span>
						</a>
						<a href="javascript:void(1);" id="store-ws-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
							<span class="icon fa fa-bar-chart"></span>
						</a>
					</div>
				</div>
			<div id="store-ws-transp-trend" data-stastid="" data-stid="" data-sttypename="" data-stname="">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Working Status Wise Transport  Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="wsw-transp-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
						<a href="javascript:void(1);" id="wsw-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="wsw-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="district-ws-transp-trend" data-sttypes=""  data-sttypesid="" data-sttypestatus="" style="width:100%; height:350px; overflow:auto;">Your desire result will render here....</div>
		</div>
		<!-- asset type wise charts display here-->
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Transport Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="atw-transp-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="atw-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="atw-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="atw-transp-trend">Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Transport Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-atw-transp-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="store-atw-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-atw-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-atw-transp-trend" data-stid="" data-sttypename="" data-sttype="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Transport Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="atws-transp-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="atws-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="atws-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="district-atw-transp-trend" style="width:100%; height:350px; overflow:auto;" data-sttypeid=""  data-stsubtypeid="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Transport Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="yw-transp-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="yw-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="yw-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="yw-transp-trend">Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Transport Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-yw-transp-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="store-yw-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-yw-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-yw-transp-trend" data-styear="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Transport Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="yws-transp-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="yws-transp-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="yws-transp-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="district-yw-transp-trend" style="width:100%; height:350px; overflow:auto;" data-styears="">Your desire result will render here....</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		function loadTREEquipInfoSection(renderAt,type='stackedcolumn2d',category,dataset){
			FusionCharts.ready(function() {
				var salesChart1 = new FusionCharts({
					type: type,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: "json",
					dataSource: {
						"chart": {
							"caption": "Available Transport Equipments (Active)",
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
				loadTREEquipInfoSection(
					'charts-transp-provincial',
					'stackedcolumn2d',
					<?php echo $transport['categorypro']; ?>,
					<?php echo $transport['seriespro']; ?>
				);
	<?php 	} ?>
		$("#equip-info-transp-bar").click(function(){
			loadTREEquipInfoSection(
				'charts-transp',
				'stackedcolumn2d',<?php echo $category; ?>,
				<?php echo $seriesdata; ?>
			);
		});
		$("#equip-info-transp-bar").trigger("click");
		//==================ware house type wise chart
		var wh_type_wise_data = <?php echo $wh_type_wise; ?>;
		function loadTRN_Wh_wise_Section(type='doughnut2d'){
			FusionCharts.ready(function() {
				var salesChart2 = new FusionCharts({
					type: type,
					renderAt: 'charts-transp',
					width: '100%',
					height: '360',
					dataFormat: "json",
					dataSource: {
					"chart": {
						"caption": "Available Transport Equipments (Active)",
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
		$("#equip-info-transp-pie").click(function(){
			loadTRN_Wh_wise_Section('doughnut2d');
		});
		$("#equip-info-transp-table").click(function(){
			equdataTable(wh_type_wise_data,'charts-transp','Store Level','Available Transport','350');
		});
		//////working status wise code======================
	function loadtransWsSection(type='column2d',table=null){
		$('#ws-transp-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'transport'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_wsWise_counts",
			success: function(result)
			{
				if(table)
				{
					equdataTable(result,'ws-transp-trend','Types','Available Transport','350'); 
				}
				else{	
				//work for linkeddata
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'ws-transp-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Working Status Wise Available Equipments of Transport (All Districts)",
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
			}
		});
	}
	$("#ws-transp-bar").click(function(){
		loadtransWsSection('column2d');
	});
	$("#ws-transp-pie").click(function(){
		loadtransWsSection('doughnut2d');
	});
	$("#ws-transp-table").click(function(){
		loadtransWsSection('a','table');
	});
	
	$("#ws-transp-bar").trigger("click");
	
	$("#store-ws-transp-bar").click(function(){
		var stastid = $('#store-ws-transp-trend').data('stastid');
		var stid = $('#store-ws-transp-trend').data("stid");
		var sttypename = $('#store-ws-transp-trend').data('sttypename');
		var stname = $('#store-ws-transp-trend').data('stname');
		wsCountgetData(stastid,stid,sttypename,stname,'store-ws-transp-trend','column2d');
	});
	$("#store-ws-transp-pie").click(function(){
		var stastid = $('#store-ws-transp-trend').data('stastid');
		var stid = $('#store-ws-transp-trend').data("stid");
		var sttypename = $('#store-ws-transp-trend').data('sttypename');
		var stname = $('#store-ws-transp-trend').data('stname');
		wsCountgetData(stastid,stid,sttypename,stname,'store-ws-transp-trend','doughnut2d');
	});
	$("#store-ws-transp-table").click(function(){
		var stastid = $('#store-ws-transp-trend').data('stastid');
		var stid = $('#store-ws-transp-trend').data("stid");
		var sttypename = $('#store-ws-transp-trend').data('sttypename');
		var stname = $('#store-ws-transp-trend').data('stname');
		wsCountgetData(stastid,stid,sttypename,stname,'store-ws-transp-trend','doughnut2d','Available Transport','table');
	});
	wsCountgetData('25','1','transport','Working Well','store-ws-transp-trend','doughnut2d');
	wsDrildwondistricts('6','1','25','Working Well','district-ws-transp-trend','column2d');
	
	////////  asset type wise refrigerator
	function loadTransgATWSection(type='column2d',table=null){
		$('#atw-transp-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'transport'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_assetType_counts",
			success: function(result)
			{
				if(table){
					equdataTable(result,'atw-transp-trend','Asset Types','Available Transport','350'); 
				}
				else{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'atw-transp-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Asset Type Wise Available Equipments of Transport (All Districts)",
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
	$("#atw-transp-pie").click(function(){
		loadTransgATWSection('doughnut2d');
	});
	$("#atw-transp-bar").click(function(){
		loadTransgATWSection('column2d');
	});
	$("#atw-transp-table").click(function(){
		loadTransgATWSection('a','table');
	});
	$("#atw-transp-bar").trigger("click");
	
	//// for atw store level charts first time load
	$("#store-atw-transp-bar").click(function(){
		var stid = $('#store-atw-transp-trend').data("stid");
		var sttypename = $('#store-atw-transp-trend').data("sttypename");
		var sttype = $('#store-atw-transp-trend').data("sttype");
		atwCountgetData(stid,sttypename,sttype,'store-atw-transp-trend','column2d');
	});
	$("#store-atw-transp-pie").click(function(){
		var stid = $('#store-atw-transp-trend').data("stid");
		var sttypename = $('#store-atw-transp-trend').data("sttypename");
		var sttype = $('#store-atw-transp-trend').data("sttype");
		atwCountgetData(stid,sttypename,sttype,'store-atw-transp-trend','doughnut2d');
	});
	$("#store-atw-transp-table").click(function(){
		var stid = $('#store-atw-transp-trend').data("stid");
		var sttypename = $('#store-atw-transp-trend').data("sttypename");
		var sttype = $('#store-atw-transp-trend').data("sttype");
		atwCountgetData(stid,sttypename,sttype,'store-atw-transp-trend','a','Available Transport');
	});
	atwCountgetData('28','transport','Motorcycle','store-atw-transp-trend','doughnut2d');
	atwDrildwondistricts('4','transport','28','Motorcycle','district-atw-transp-trend','column2d');
	
	// Atw all districts	
	$("#atws-transp-bar").click(function(){
		//alert('hello');
		var sttypeid = $('#district-atw-transp-trend').data("sttypeid");
		var stsubtypeid = $('#district-atw-transp-trend').data("stsubtypeid");
		var sttype = $('#store-atw-transp-trend').data("sttype");
		atwDrildwondistricts(sttypeid,'transport',stsubtypeid,sttype,'district-atw-transp-trend','column2d');
	});
	$("#atws-transp-pie").click(function(){
		var sttypeid = $('#district-atw-transp-trend').data("sttypeid");
		var stsubtypeid = $('#district-atw-transp-trend').data("stsubtypeid");
		var sttype = $('#store-atw-transp-trend').data("sttype");
		atwDrildwondistricts(sttypeid,'transport',stsubtypeid,sttype,'district-atw-transp-trend','doughnut2d');
	}); 
	$("#atws-transp-table").click(function(){
		var sttypeid = $('#district-atw-transp-trend').data("sttypeid");
		var stsubtypeid = $('#district-atw-transp-trend').data("stsubtypeid");
		var sttype = $('#store-atw-transp-trend').data("sttype");
		atwDrildwondistricts(sttypeid,'transport',stsubtypeid,sttype,'district-atw-transp-trend','a','Available Transport');
	});
	
	// Ws all districts
	$("#wsw-transp-bar").click(function(){
		var sttypes = $('#district-ws-transp-trend').data('sttypes');
		var sttypestatus = $('#district-ws-transp-trend').data('sttypestatus');
		var sttypesid = $('#district-ws-transp-trend').data('sttypesid');
		var stname = $('#store-ws-transp-trend').data('stname');
		wsDrildwondistricts(sttypes,sttypestatus,sttypesid,stname,'district-ws-transp-trend','column2d');	
	});
	$("#wsw-transp-pie").click(function(){
		var sttypes = $('#district-ws-transp-trend').data('sttypes');
		var sttypestatus = $('#district-ws-transp-trend').data('sttypestatus');
		var sttypesid = $('#district-ws-transp-trend').data('sttypesid');
		var stname = $('#store-ws-transp-trend').data('stname');
		wsDrildwondistricts(sttypes,sttypestatus,sttypesid,stname,'district-ws-transp-trend','doughnut2d');
		//alert('sumayya');	
	});
	$("#wsw-transp-table").click(function(){
		var sttypes = $('#district-ws-transp-trend').data('sttypes');
		var sttypestatus = $('#district-ws-transp-trend').data('sttypestatus');
		var sttypesid = $('#district-ws-transp-trend').data('sttypesid');
		var stname = $('#store-ws-transp-trend').data('stname');
		wsDrildwondistricts(sttypes,sttypestatus,sttypesid,stname,'district-ws-transp-trend','a','Available Transport');
		//alert('sumayya');	yws-refg-pie
	});
	
	$("#yws-transp-bar").click(function(){
		var styears = $('#district-yw-transp-trend').data("styears");
		var styear = $('#store-yw-transp-trend').data("styear");
		ywDrildwondistricts(styears,'transport',styear,'district-yw-transp-trend','column2d');
	});
	$("#yws-transp-pie").click(function(){
		var styears = $('#district-yw-transp-trend').data("styears");
		var styear = $('#store-yw-transp-trend').data("styear");
		ywDrildwondistricts(styears,'transport',styear,'district-yw-transp-trend','doughnut2d');
	});
	$("#yws-transp-table").click(function(){
		var styears = $('#district-yw-transp-trend').data("styears");
		var styear = $('#store-yw-transp-trend').data("styear");
		ywDrildwondistricts(styears,'transport',styear,'district-yw-transp-trend','a','Available Transport');
		//alert('sumayya');	yws-refg-pie
	});
	
	////////  Year wise refrigerator
	function loadTransYWSection(type='column2d',table=null){
		$('#yw-transp-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'transport'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_ysWise_counts",
			success: function(result)
			{
				if(table){
					equdataTable(result,'yw-transp-trend','Year','Available Transport','350'); 
				}
				else{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'yw-transp-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Year Wise Available Equipments of Transport (All Districts)",
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
	$("#yw-transp-pie").click(function(){
		loadTransYWSection('doughnut2d');
	});
	$("#yw-transp-bar").click(function(){
		loadTransYWSection('column2d');
	});
	$("#yw-transp-table").click(function(){
		loadTransYWSection('a','table');
	});
	
	$("#yw-transp-bar").trigger("click"); 
	$("#store-yw-transp-bar").click(function(){
		var styear = $('#store-yw-transp-trend').data("styear");
		ywCountgetData(styear,'transport','store-yw-transp-trend','column2d');
	});
	$("#store-yw-transp-pie").click(function(){
		var styear = $('#store-yw-transp-trend').data("styear");
		ywCountgetData(styear,'transport','store-yw-transp-trend','doughnut2d');
	});
	$("#store-yw-transp-table").click(function(){
		var styear = $('#store-yw-transp-trend').data("styear");
		ywCountgetData(styear,'transport','store-yw-transp-trend','doughnut2d','Available Transport');
	});
	
	ywCountgetData('2018','transport','store-yw-transp-trend','doughnut2d');
	ywDrildwondistricts('4','transport','2018','district-yw-transp-trend','column2d');
	});
</script>