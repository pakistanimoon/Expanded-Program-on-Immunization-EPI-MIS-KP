<?php //var_dump($id);exit; 
$distcode = (isset($id) && $id)?$id:null;
$assetTypeId = (isset($asset_type_id) && $asset_type_id)?$asset_type_id:0;
?>
<div class="container-fluid">
	<!-- available assets charts display here-->
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Available Refrigerator Equipments (Active)</span>
				<div class="pull-right">
					<!--<a href="javascript:void(1);" id="equip-info-refg-map" style="color:#000000;font-size: 20px;" title="Map View">
						<span class="glyphicon glyphicon-map-marker"></span>
					</a>-->
					<?php if($distcode ==""){ ?>
					<a href="javascript:void(1);" id="equip-info-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
					
					<a href="javascript:void(1);" id="equip-info-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<?php  } ?>
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
	<!-- working status wise charts display here-->
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Working Status Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="ws-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
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
					<a href="javascript:void(1);" id="store-ws-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="store-ws-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-ws-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-ws-refg-trend"  data-stastid="" data-stid=""  data-sttypename="" data-stname="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Working Status Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-wsw-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="store-wsw-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-wsw-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>

				</div>
			</div>
			<div id="district-ws-refg-trend" data-sttypes=""  data-sttypesid="" data-sttypestatus="" style="width:100%; height:350px; overflow:auto;">Your desire result will render here....</div>
		</div>
	</div>
	<!-- asset type wise charts display here-->
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="atw-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>	
					<a href="javascript:void(1);" id="atw-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="atw-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="atw-refg-trend" style="width:100%; height:350px; overflow:auto;">Your desire result will render here....</div>
		</div> 
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-atw-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a> 
					<a href="javascript:void(1);" id="store-atw-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-atw-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-atw-refg-trend"  data-stid="" data-sttypename="" data-sttype="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Asset Type Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="atws-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="atws-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="atws-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="district-atw-refg-trend" style="width:100%; height:350px; overflow:auto;" data-sttypeid=""  data-stsubtypeid="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="yw-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="yw-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="yw-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="yw-refg-trend" style="width:100%; height:350px; overflow:auto;">Your desire result will render here....</div>
		</div>
		<div class="col-md-6">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="store-yw-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="fa fa-table"></span>
					</a> 
					<a href="javascript:void(1);" id="store-yw-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="store-yw-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="store-yw-refg-trend" data-styear="">Your desire result will render here....</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="section-title" style="padding: 0px 6px; line-height:30px;">
				<span>Year Wise Refrigerators Available</span>
				<div class="pull-right">
					<a href="javascript:void(1);" id="yws-refg-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
						<span class="icon fa fa-table"></span>
					</a>
					<a href="javascript:void(1);" id="yws-refg-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
						<span class="icon fa fa-pie-chart"></span>
					</a>
					<a href="javascript:void(1);" id="yws-refg-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
						<span class="icon fa fa-bar-chart"></span>
					</a>
				</div>
			</div>
			<div id="district-yw-refg-trend" style="width:100%; height:350px; overflow:auto;" data-styears="">Your desire result will render here....</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
	$(document).ready(function() {
		function formatter(e,ucwisemap='false'){
			var text= 'District';
			if(ucwisemap == 'true'){
				text = 'Union Council';
			}
			return text+': <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br>Available Refrigerator: <b>' + e.point.value + '</b>';
		}
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
							"useEllipsesWhenOverflow":"0",
							"showLegend": "<?php echo (isset($districtName)? 0:1); ?>"
							//"labelDisplay": "wrap"
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
		/* $("#equip-info-refg-map").click(function(){
			$.ajax({
			type: "POST",
			data : {type:'refrigerator'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/mapsSeriesdata",
			success: function(result)
			{
				$(function () {
					var ucwisemap = '<?php echo (isset($ucwisemap))?$ucwisemap:'false'; ?>';
					var id = '';
					var fmonth = '<?php echo '2018-11'; ?>';
					var dataClasses = <?php echo (isset($colorAxis))?$colorAxis:'[]'; ?>;
					var titleText = '<?php echo 'Available Refrigerator'; ?>';
					var subtitle = '<?php if(isset($heading["subtittle"])){ echo $heading["subtittle"];}?>';
					var run = '<?php echo false ; ?>';
					var casetype = '<?php echo (isset($casetype))?$casetype:""; ?>';
					$('#charts-refrigerator').highcharts('Map', {
						title: {
							text: titleText
						},
						subtitle: {
							text: subtitle
						},
						credits: {
							enabled: true,
							href: 'http://pacetec.net/',
							text: 'Pace Technologies'
						},
						mapNavigation: {
							enabled: true,
							buttonOptions: {
								verticalAlign: 'bottom'
							}
						}, 
						legend: {
							align: 'left',
							verticalAlign: 'top',
							x: 0,
							y: 70,
							floating: true,
							layout: 'vertical',
							valueDecimals: 0,
							backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255, 255, 255, 0.85)'
						},
						tooltip: {
							formatter: function () {
								return formatter(this,ucwisemap);
							}
						},
						colorAxis: result.colorAxis,
						plotOptions: {
								series: {
									events: {
										click: function (e) {
											eventHandler(e, run, fmonth, casetype);
										}
									},
									dataLabels:{
										align: 'center',
										enabled: true,
										allowOverlap : false,
										style:{
											fontSize : '8px',
											color : 'contrast'
										},
										formatter: function () {
											return this.point.name+':'+this.point.value;
										},
										backgroundColor: undefined,
										crop : false,
										overflow : "justify",
									}
								}
						},
						series: result.dataSeries,
						exporting: {
							buttons: {
								contextButton: {
									menuItems: [{
										textKey: 'downloadPNG',
										onclick: function () {
											this.exportChart({
												type : 'image/png'
											});
										}
									}, {
										textKey: 'downloadJPEG',
										onclick: function () {
											this.exportChart({
												type: 'image/jpeg'
											});
										}
									},{
										textKey: 'downloadPDF',
										onclick: function () {
											this.exportChart({
												type : 'application/pdf'
											});
										}
									}]
								}
							}
						}
					});
				});
			} 
		});
		}); */
		$("#equip-info-refg-bar").trigger("click");
		//==================ware house type wise charts
		var wh_type_wise_data = <?php echo $wh_type_wise; ?>;
		//console.log(wh_type_wise_data);
		function loadrefWh_wise_Section(type='doughnut2d'){ 
			FusionCharts.ready(function() {
				var salesChart2 = new FusionCharts({
					//console.log(salesChart2);
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
				}).render(); //console.log(wh_type_wise_data);
			});
		}
	$("#equip-info-refg-pie").click(function(){
		loadrefWh_wise_Section('doughnut2d');
	});
	  $("#equip-info-refg-table").click(function(){
		  //alert('hello');
		equdataTable(wh_type_wise_data,'charts-refrigerator','Store Level','Available Refrigerator','350');
	});
	//////working status code======================
	function loadRefgWsSection(type='column2d',table=null){
		$('#ws-refg-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'refrigerator',distcode:'<?php echo $distcode ?>'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_wsWise_counts",
			success: function(result)
			{
				if(table)
				{
					equdataTable(result,'ws-refg-trend','Types','Available Refrigerators','350'); 
				}
				else{	
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
			}
		});
	}
	//function loadTable(){
		//alert('111'); exit;
		/*function equdataTable(dataArr,divId,col,col2,height="350"){
			//alert ('111'); 
		var row = "<table  class='table table-bordered table-hover table-striped footable table-vcenter tbl-listing dataTable no-footer' data-filter='#filter' data-filter-text-only='true' style='padding-top: 0%; width: 100%; height: "+height+"px;' role='grid' aria-describedby='myTable_info'><thead><tr style='height: 42px;'><th class='text-center' ><span style='line-height: 3;'>"+col+"</span></th><th class='text-center' ><span style='line-height: 3;'>"+col2+"</span></th></tr></thead><tbody style='text-align:center;'>";
		var url = "";
		if(jQuery.isEmptyObject(dataArr)){
			row = "<table  class='table table-bordered table-hover table-striped footable table-vcenter tbl-listing dataTable no-footer' data-filter='#filter' data-filter-text-only='true' style='padding-top: 0%; width: 100%; height: "+height+"px;' role='grid' aria-describedby='myTable_info'><thead></thead><tbody style='text-align:center;'>";
			row +="<tr><td></td><td style='padding-top: 166px;'>No data to display</td></tr>";
		}else{
			$.each( dataArr, function( key, valsec ) {
				if(typeof(valsec['link']) != "undefined" && valsec['link'] !== null)
					url = ' style="cursor:pointer" onclick='+valsec['link']+'';
				else
					url = "";
				row += " <tr "+url+"><td style='width:30%'>"+valsec['label']+"</td><td>"+valsec['value']+"</td></tr>";
			});
		}
		row += "</tbody></table>";
		$('#'+divId).html(row);
		$("#"+divId).hide();
		$("#"+divId).slideDown(1000);
		
	}*/

	//} 
	
	$("#ws-refg-pie").click(function(){
		loadRefgWsSection('doughnut2d');
	});
	$("#ws-refg-bar").click(function(){
		loadRefgWsSection('column2d'); 
	});
	$("#ws-refg-table").click(function(){
		loadRefgWsSection('a','table'); 
		//alert('12333');exit;
	});
	$("#ws-refg-bar").trigger("click");
	$("#store-ws-refg-bar").click(function(){
		var stastid = $('#store-ws-refg-trend').data("stastid");
		var stid = $('#store-ws-refg-trend').data("stid");
		var sttypename = $('#store-ws-refg-trend').data('sttypename');
		var stname = $('#store-ws-refg-trend').data('stname');
		//alert( $('#store-ws-refg-trend').data("stid") );
		wsCountgetData(stastid,stid,sttypename,stname,'store-ws-refg-trend','column2d');
		//alert(wsCountgetData);
	});
	$("#store-ws-refg-pie").click(function(){
		var stastid = $('#store-ws-refg-trend').data("stastid");
		var stid = $('#store-ws-refg-trend').data("stid");
		var sttypename = $('#store-ws-refg-trend').data('sttypename');
		var stname = $('#store-ws-refg-trend').data('stname');
		wsCountgetData(stastid,stid,sttypename,stname,'store-ws-refg-trend','doughnut2d'); 
	});
	$("#store-ws-refg-table").click(function(){
		var stastid = $('#store-ws-refg-trend').data("stastid");
		var stid = $('#store-ws-refg-trend').data("stid");
		var sttypename = $('#store-ws-refg-trend').data('sttypename');
		var stname = $('#store-ws-refg-trend').data('stname');
		wsCountgetData(stastid,stid,sttypename,stname,'store-ws-refg-trend','first','Available Refrigerator')
		//alert('12333');
	});
	wsCountgetData('1','1','refrigerator','Working Well','store-ws-refg-trend','doughnut2d');
	wsDrildwondistricts('6','1','1','Working Well','district-ws-refg-trend','column2d');
	
	////////  asset type wise refrigerator
	function loadRefgATWSection(type='column2d',table=null){
		$('#atw-refg-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'refrigerator',distcode:'<?php echo $id ?>'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_assetType_counts",
			success: function(result)
			{
				if(table){
					equdataTable(result,'atw-refg-trend','Asset Types','Available Refrigerator','350'); 
				}
				else{
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
			}
		});
	}
	$("#atw-refg-pie").click(function(){
		loadRefgATWSection('doughnut2d');
	});
	$("#atw-refg-bar").click(function(){
		loadRefgATWSection('column2d');
	});
	$("#atw-refg-table").click(function(){
		loadRefgATWSection('a','table');
	});
	
	$("#atw-refg-bar").trigger("click");
	
	//// for atw store level charts first time load
	$("#store-atw-refg-bar").click(function(){
		var stid = $('#store-atw-refg-trend').data("stid");
		var sttypename = $('#store-atw-refg-trend').data("sttypename");
		var sttype = $('#store-atw-refg-trend').data("sttype");
		atwCountgetData(stid,sttypename,sttype,'store-atw-refg-trend','column2d');
	});
	$("#store-atw-refg-pie").click(function(){
		var stid = $('#store-atw-refg-trend').data("stid");
		var sttypename = $('#store-atw-refg-trend').data("sttypename");
		var sttype = $('#store-atw-refg-trend').data("sttype");
		atwCountgetData(stid,sttypename,sttype,'store-atw-refg-trend','doughnut2d');
	});
	$("#store-atw-refg-table").click(function(){
		var stid = $('#store-atw-refg-trend').data("stid");
		var sttypename = $('#store-atw-refg-trend').data("sttypename");
		var sttype = $('#store-atw-refg-trend').data("sttype");
		atwCountgetData(stid,sttypename,sttype,'store-atw-refg-trend','first','Available Refrigerator');
		//alert('123');
	});
	atwCountgetData('13','refrigerator','Ice Lined Refrigerator','store-atw-refg-trend','doughnut2d');
	atwDrildwondistricts('4','refrigerator','13','Ice Lined Refrigerator','district-atw-refg-trend','column2d');
	
	// Atw all districts	
	$("#atws-refg-bar").click(function(){
		var sttypeid = $('#district-atw-refg-trend').data("sttypeid");
		var stsubtypeid = $('#district-atw-refg-trend').data("stsubtypeid");
		var sttype = $('#store-atw-refg-trend').data("sttype");
		atwDrildwondistricts(sttypeid,'refrigerator',stsubtypeid,sttype,'district-atw-refg-trend','column2d');
	});
	$("#atws-refg-pie").click(function(){
		var sttypeid = $('#district-atw-refg-trend').data("sttypeid");
		var stsubtypeid = $('#district-atw-refg-trend').data("stsubtypeid");
		var sttype = $('#store-atw-refg-trend').data("sttype");
		atwDrildwondistricts(sttypeid,'refrigerator',stsubtypeid,sttype,'district-atw-refg-trend','doughnut2d');
	}); 
	$("#atws-refg-table").click(function(){
		var sttypeid = $('#district-atw-refg-trend').data("sttypeid");
		var stsubtypeid = $('#district-atw-refg-trend').data("stsubtypeid");
		var sttype = $('#store-atw-refg-trend').data("sttype");
		atwDrildwondistricts(sttypeid,'refrigerator',stsubtypeid,sttype,'district-atw-refg-trend','a','Available Refrigerator');
		//alert('sumayya');	
	});
	// Ws all districts
	$("#store-wsw-refg-bar").click(function(){
		//alert ('dnkad');
		var sttypes = $('#district-ws-refg-trend').data('sttypes');
		var sttypestatus = $('#district-ws-refg-trend').data('sttypestatus');
		//var sttypesid = $('#district-ws-refg-trend').data('sttypesid');
		var stname = $('#store-ws-refg-trend').data('stname');
		wsDrildwondistricts(sttypes,sttypestatus,'1',stname,'district-ws-refg-trend','column2d');
		//alert('sumayya');	
	});
	$("#store-wsw-refg-pie").click(function(){
		var sttypes = $('#district-ws-refg-trend').data('sttypes');
		var sttypestatus = $('#district-ws-refg-trend').data('sttypestatus');
		var sttypesid = $('#district-ws-refg-trend').data('sttypesid');
		var stname = $('#store-ws-refg-trend').data('stname');
		wsDrildwondistricts(sttypes,sttypestatus,sttypesid,stname,'district-ws-refg-trend','doughnut2d');
		//alert('sumayya');	
	});
	$("#store-wsw-refg-table").click(function(){
		var sttypes = $('#district-ws-refg-trend').data('sttypes');
		var sttypestatus = $('#district-ws-refg-trend').data('sttypestatus');
		var sttypesid = $('#district-ws-refg-trend').data('sttypesid');
		var stname = $('#store-ws-refg-trend').data('stname');
		wsDrildwondistricts(sttypes,sttypestatus,sttypesid,stname,'district-ws-refg-trend','a','Available Refrigerator');
		//alert('sumayya');	yws-refg-pie
	});
	
	//yw all districts
	
	$("#yws-refg-bar").click(function(){
		var styears = $('#district-yw-refg-trend').data("styears");
		var styear = $('#store-yw-refg-trend').data("styear");
		ywDrildwondistricts(styears,'refrigerator',styear,'district-yw-refg-trend','column2d');
	});
	$("#yws-refg-pie").click(function(){
		var styears = $('#district-yw-refg-trend').data("styears");
		var styear = $('#store-yw-refg-trend').data("styear");
		ywDrildwondistricts(styears,'refrigerator',styear,'district-yw-refg-trend','doughnut2d');
	});
	$("#yws-refg-table").click(function(){
		var styears = $('#district-yw-refg-trend').data("styears");
		var styear = $('#store-yw-refg-trend').data("styear");
		var sttable = $('#store-yw-refg-trend').data("sttable");
		ywDrildwondistricts(styears,'refrigerator',styear,'district-yw-refg-trend','a','Available Refrigerator');
		//alert('sumayya');	yws-refg-pie
	});
	////////  Year wise refrigerator
	function loadRefgYWSection(type='column2d',table=null){
		$('#yw-refg-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'refrigerator',distcode:'<?php echo $id ?>'},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_ysWise_counts",
			success: function(result)
			{
				if(table){
					equdataTable(result,'yw-refg-trend','Year','Available Refrigerator','350'); 
				}
				else{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'yw-refg-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Year Wise Available Equipments of Refrigerators (All Districts)",
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
	$("#yw-refg-pie").click(function(){
		loadRefgYWSection('doughnut2d');
	});
	$("#yw-refg-bar").click(function(){
		loadRefgYWSection('column2d');
	});
	$("#yw-refg-table").click(function(){
		loadRefgYWSection('a','table'); 
		//alert('12333');exit;
	});
	$("#yw-refg-bar").trigger("click");
	$("#store-yw-refg-bar").click(function(){
		var styear = $('#store-yw-refg-trend').data("styear");
		ywCountgetData(styear,'refrigerator','store-yw-refg-trend','column2d');
	});
	$("#store-yw-refg-pie").click(function(){
		var styear = $('#store-yw-refg-trend').data("styear");
		ywCountgetData(styear,'refrigerator','store-yw-refg-trend','doughnut2d');
	});
	$("#store-yw-refg-table").click(function(){
		var styear = $('#store-yw-refg-trend').data("styear");
		ywCountgetData(styear,'refrigerator','store-yw-refg-trend','doughnut2d','Available Refrigerator');
	});
	
	ywCountgetData('2018','refrigerator','store-yw-refg-trend','doughnut2d');
	ywDrildwondistricts('4','refrigerator','2018','district-yw-refg-trend','column2d');
	});
</script>