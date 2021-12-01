<?php
	$distcode = (isset($id) && $id)?$id:null;
?>
<div class="container-fluid">
	<!-- available assets charts display here-->
	<div class="row">
		<div class="section-title" style="padding: 0px 6px; line-height:30px;">
			<span>Available cold room Equipments (Active)</span>
			<div class="pull-right">
				<?php if($distcode ==""){ ?>
				<a href="javascript:void(1);" id="equip-info-cr-table" style="color:#000000;font-size: 20px;" title="Tabular View">
					<span class="icon fa fa-table"></span>
				</a>
				
				<a href="javascript:void(1);" id="equip-info-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
					<span class="icon fa fa-pie-chart"></span>
				</a>
				<?php } ?> 
				<a href="javascript:void(1);" id="equip-info-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
					<span class="icon fa fa-bar-chart"></span>
				</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-<?php echo (!isset($districtName)?9:12); ?>">
			<div id="charts-cold-room">Your desire result will render here....</div>
		</div>
		<?php if(!isset($districtName)){ ?>
		<div class="col-md-3">
			<div id="charts-cold-room-provincial">Your desire result will render here....</div>
		</div>
		<?php } ?>
	</div>
	<!-- working statu wise charts display here-->
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Working Status Wise Cold Room Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="ws-cr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="ws-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="ws-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="ws-cr-trend">Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Store Wise Working Status of Available Cold Room </span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-ws-cr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="store-ws-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-ws-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-ws-cr-trend" data-stid="" data-stname="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Working Status Wise Cold room Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="wsw-cr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="wsw-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="wsw-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="district-ws-cr-trend" data-sttypes=""  data-sttypesid="" data-sttypestatus="" style="width:100%; height:350px; overflow:auto;" >Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Cold room Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="atw-cr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="atw-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="atw-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="atw-cr-trend" data-sttype="" >Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Cold Room Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-atw-cr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="store-atw-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-atw-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-atw-cr-trend" data-stid="" data-sttypename="" data-sttype="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Cold Room Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="atws-cr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="atws-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="atws-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="district-atw-cr-trend" style="width:100%; height:350px; overflow:auto;" data-sttypeid="" data-stsubtypeid="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Cold Room Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="yw-cr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="yw-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="yw-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="yw-cr-trend" data-sttype="">Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Cold Room Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-yw-cr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="store-yw-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-yw-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-yw-cr-trend">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Cold Room Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="yws-cr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="yws-cr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="yws-cr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="district-yw-cr-trend" style="width:100%; height:350px; overflow:auto;"  data-styear="" data-styears="">Your desire result will render here....</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		function loadColdroomEquipInfoSection(renderAt,type='stackedcolumn2d',category,dataset){
			FusionCharts.ready(function() {
				var salesChart1 = new FusionCharts({
					type: type,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: "json",
					dataSource: {
						"chart": {
							"caption": "Available cold room Equipments (Active)",
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
				loadColdroomEquipInfoSection(
					'charts-cold-room-provincial',
					'stackedcolumn2d',
					<?php echo $cold_room['categorypro']; ?>,
					<?php echo $cold_room['seriespro']; ?>
				);
	<?php 	} ?>
		$("#equip-info-cr-bar").click(function(){
			loadColdroomEquipInfoSection(
				'charts-cold-room',
				'stackedcolumn2d',<?php echo $category; ?>,
				<?php echo $seriesdata; ?>
			);
		});
		$("#equip-info-cr-bar").trigger("click");
		//==================ware house type wise chart
		var wh_type_wise_data = <?php echo $wh_type_wise; ?>;
		function loadcr_Wh_wise_Section(type='doughnut2d'){
			FusionCharts.ready(function() {
				var salesChart2 = new FusionCharts({
					type: type,
					renderAt: 'charts-cold-room',
					width: '100%',
					height: '360',
					dataFormat: "json",
					dataSource: {
					"chart": {
						"caption": "Available Cold Room Equipments (Active)",
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
						"rotateValues" : "1",
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
		$("#equip-info-cr-pie").click(function(){
			loadcr_Wh_wise_Section('doughnut2d');
		});
		$("#equip-info-cr-table").click(function(){
			equdataTable(wh_type_wise_data,'charts-cold-room','Store Level','Available Cold Room','350');
		});
		//////working status wise code======================
	function loadCRWsSection(type='column2d',table=null){
		$('#ws-cr-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'coldroom'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_wsWise_counts",
			success: function(result)
			{
				if(table)
				{
					equdataTable(result,'ws-cr-trend','Types','Available Cold Room','350'); 
				}
				else{	
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'ws-cr-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Working Status Wise Available Equipments of Cold Room (All Districts)",
								//"subCaption": "Click on column/line/slice to drill down to region wise information of respective Level",
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Numbers",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"rotateLabels": "1",
								"slantlabels": "1",
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
	/* $("#ws-cr-pie").click(function(){
		loadCRWsSection('doughnut2d');
	});
	$("#ws-cr-bar").click(function(){
		loadCRWsSection('column2d');
	});
	$("#ws-cr-bar").trigger("click");
	$("#store-ws-cr-pie").click(function(){
		wsCountgetData('1','1','refrigerator','Working Well','store-ws-cr-trend','doughnut2d');
	});
	wsCountgetData('1','1','coldroom','Working Well','store-ws-cr-trend','column2d'); */
	$("#ws-cr-pie").click(function(){
		loadCRWsSection('doughnut2d');
	});
	$("#ws-cr-bar").click(function(){
		loadCRWsSection('column2d');
	});
	$("#ws-cr-table").click(function(){
		loadCRWsSection('a','table');
	});
	$("#ws-cr-bar").trigger("click");
	
	$("#store-ws-cr-bar").click(function(){
		var stid = $('#store-ws-cr-trend').data("stid");
		var stname = $('#store-ws-cr-trend').data('stname');
		wsCountgetData('1',stid,'coldroom',stname,'store-ws-cr-trend','column2d');
	});
	$("#store-ws-cr-pie").click(function(){
		var stid = $('#store-ws-cr-trend').data("stid");
		var stname = $('#store-ws-cr-trend').data('stname');
		wsCountgetData('1',stid,'coldroom',stname,'store-ws-cr-trend','doughnut2d');
	});
	$("#store-ws-cr-table").click(function(){
		var stid = $('#store-ws-cr-trend').data("stid");
		var stname = $('#store-ws-cr-trend').data('stname');
		wsCountgetData('1',stid,'coldroom',stname,'store-ws-cr-trend','doughnut2d','Available Cold Room');
	});
	wsCountgetData('1','1','coldroom','Working Well','store-ws-cr-trend','doughnut2d');
	wsDrildwondistricts('6','1','21','Working Well','district-ws-cr-trend','column2d');
	
	// Ws all districts
	 $("#wsw-cr-bar").click(function(){
		var sttypes = $('#district-ws-cr-trend').data('sttypes');
		var sttypestatus = $('#district-ws-cr-trend').data('sttypestatus');
		var sttypesid = $('#district-ws-cr-trend').data('sttypesid');
		var stname = $('#store-ws-cr-trend').data('stname');
		wsDrildwondistricts(sttypes,sttypestatus,sttypesid,stname,'district-ws-cr-trend','column2d');
		//wsDrildwondistricts('6','1','21','Working Well','district-ws-cr-trend','column2d');
		//alert('sumayya');	
	}); 
	$("#wsw-cr-pie").click(function(){
		var sttypes = $('#district-ws-cr-trend').data('sttypes');
		var sttypestatus = $('#district-ws-cr-trend').data('sttypestatus');
		var sttypesid = $('#district-ws-cr-trend').data('sttypesid');
		var stname = $('#store-ws-cr-trend').data('stname');
		wsDrildwondistricts(sttypes,sttypestatus,sttypesid,stname,'district-ws-cr-trend','doughnut2d');
		//alert('sumayya');	
	});
	$("#wsw-cr-table").click(function(){
		var sttypes = $('#district-ws-cr-trend').data('sttypes');
		var sttypestatus = $('#district-ws-cr-trend').data('sttypestatus');
		var sttypesid = $('#district-ws-cr-trend').data('sttypesid');
		var stname = $('#store-ws-cr-trend').data('stname');
		wsDrildwondistricts(sttypes,sttypestatus,sttypesid,stname,'district-ws-cr-trend','a','Available Cold Room');
		//alert('sumayya');	yws-refg-pie
	});
		// Atw all districts	
	$("#atws-cr-bar").click(function(){
		var sttypeid = $('#district-atw-cr-trend').data("sttypeid");
		var stsubtypeid = $('#district-atw-cr-trend').data("stsubtypeid");
		var sttype = $('#district-atw-cr-trend').data("sttype");
		atwDrildwondistricts(sttypeid,'coldroom',stsubtypeid,sttype,'district-atw-cr-trend','column2d');
		//atwDrildwondistricts(sttypeid,'refrigerator',stsubtypeid,sttype,'district-atw-cr-trend','column2d');
	});
	$("#atws-cr-pie").click(function(){
		var sttypeid = $('#district-atw-cr-trend').data("sttypeid");
		var stsubtypeid = $('#district-atw-cr-trend').data("stsubtypeid");
		var sttype = $('#district-atw-cr-trend').data("sttype");
		atwDrildwondistricts(sttypeid,'coldroom',stsubtypeid,sttype,'district-atw-cr-trend','doughnut2d');
	}); 
	$("#atws-cr-table").click(function(){
		var sttypeid = $('#district-atw-cr-trend').data("sttypeid");
		var stsubtypeid = $('#district-atw-cr-trend').data("stsubtypeid");
		var sttype = $('#district-atw-cr-trend').data("sttype");
		atwDrildwondistricts(sttypeid,'coldroom',stsubtypeid,sttype,'district-atw-cr-trend','a','Available Cold Room');
		//alert('sumayya');	
	}); 
	//yw all districts
	$("#yws-cr-bar").click(function(){
		var styears = $('#district-yw-cr-trend').data("styears");
		var styear = $('#district-yw-cr-trend').data("styear");
		ywDrildwondistricts(styears,'coldroom',styear,'district-yw-cr-trend','column2d');
	});
	$("#yws-cr-pie").click(function(){
		var styears = $('#district-yw-cr-trend').data("styears");
		var styear = $('#district-yw-cr-trend').data("styear");
		ywDrildwondistricts(styears,'coldroom',styear,'district-yw-cr-trend','doughnut2d');
	});
	$("#yws-cr-table").click(function(){
		var styears = $('#district-yw-cr-trend').data("styears");
		var styear = $('#district-yw-cr-trend').data("styear");
		ywDrildwondistricts(styears,'coldroom',styear,'district-yw-cr-trend','a','Available Cold Room');
		//alert('sumayya');	yws-refg-pie
	});
	
	////////  asset type wise refrigerator
	function loadCRATWSection(type='column2d',table=null){
		$('#atw-cr-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'coldroom'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_assetType_counts",
			success: function(result)
			{
					if(table)
				{
					equdataTable(result,'atw-cr-trend','Types','Available Cold Room','350'); 
				}
				else{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'atw-cr-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Asset Type Wise Available Equipments of Cold Room (All Districts)",
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
	$("#atw-cr-pie").click(function(){
		loadCRATWSection('doughnut2d');
	});
	$("#atw-cr-bar").click(function(){
		loadCRATWSection('column2d');
	});
	$("#atw-cr-table").click(function(){
		loadCRATWSection('a','table');
	});
	
	$("#atw-cr-bar").trigger("click");
	
	//// for atw store level charts first time load
	$("#store-atw-cr-bar").click(function(){
		var stid = $('#store-atw-cr-trend').data("stid");
		var sttypename = $('#store-atw-cr-trend').data("sttypename");
		var sttype = $('#store-atw-cr-trend').data("sttype");
		atwCountgetData(stid,sttypename,sttype,'store-atw-cr-trend','column2d');
	});
	$("#store-atw-cr-pie").click(function(){
		var stid = $('#store-atw-cr-trend').data("stid");
		var sttypename = $('#store-atw-cr-trend').data("sttypename");
		var sttype = $('#store-atw-cr-trend').data("sttype");
		atwCountgetData(stid,sttypename,sttype,'store-atw-cr-trend','doughnut2d');
	});
	$("#store-atw-cr-table").click(function(){
		var stid = $('#store-atw-cr-trend').data("stid");
		var sttypename = $('#store-atw-cr-trend').data("sttypename");
		var sttype = $('#store-atw-cr-trend').data("sttype");
		atwCountgetData(stid,sttypename,sttype,'store-atw-cr-trend','doughnut2d','Available Cold Room','table');
	});

	atwCountgetData('9','coldroom','Cold Room -20c','store-atw-cr-trend','doughnut2d');
	atwDrildwondistricts('4','coldroom','9','Cold Room -20c','district-atw-cr-trend','column2d');
	
	////////  Year wise refrigerator
	function loadcrYWSection(type='column2d',table=null){
		$('#yw-cr-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'coldroom'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_ysWise_counts",
			success: function(result)
			{
				if(table)
				{
					//alert('kdghweuifdew');
					equdataTable(result,'yw-cr-trend','Year','Available Cold Room','350'); 
				}
				else{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'yw-cr-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Year Wise Available Equipments of Cold Room (All Districts)",
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
	$("#yw-cr-pie").click(function(){
		loadcrYWSection('doughnut2d');
	});
	$("#yw-cr-bar").click(function(){
		loadcrYWSection('column2d');
	});	
	$("#yw-cr-table").click(function(){
		//alert('hello');
		loadcrYWSection('a','table');
	});
	
	$("#yw-cr-bar").trigger("click");
	$("#store-yw-cr-bar").click(function(){
		var styear = $('#store-yw-cr-trend').data("styear");
		ywCountgetData(styear,'coldroom','store-yw-cr-trend','column2d');
	});
	$("#store-yw-cr-pie").click(function(){
		var styear = $('#store-yw-cr-trend').data("styear");
		ywCountgetData(styear,'coldroom','store-yw-cr-trend','doughnut2d');
	});
	$("#store-yw-cr-table").click(function(){
		var styear = $('#store-yw-cr-trend').data("styear");
		ywCountgetData(styear,'coldroom','store-yw-cr-trend','doughnut2d','Available Cold Room');
	});	
	ywCountgetData('2018','coldroom','store-yw-cr-trend','doughnut2d');
	ywDrildwondistricts('4','coldroom','2018','district-yw-cr-trend','column2d');
	});
</script>