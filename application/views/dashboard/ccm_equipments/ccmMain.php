<?php //var_dump('Main Page');exit; ?>
<div class="flypanels-main">
	<div class="flypanels-topbar"> 
		<a class="flypanels-button-left icon-menu" data-panel="treemenu" href="#"><i class="fa fa-bars"></i></a>
		<h5 class="h5-heading">EPI Dashboard</h5>
		<h2 class="topbar-heading">Expanded Program on Immunization Thematic Maps Dashboard</h2>
	</div>
    <div class="header_profilewraper">
		<div class="profile_dropdown">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> <span class="fed-username"><?php echo $this -> session -> User_Name; ?></span> </button>
				<ul class="dropdown-menu signout-ul">
					<li><a href="<?php echo base_url();?>Logout"> <i class="fa fa-key" aria-hidden="true"></i> Sign out </a></li>
				</ul>
			</div>
		</div>
    </div>
<div class="flypanels-content">
	<div class="container-fluid">
		<div class="content_mainwraper">
			<div class="main_heading"> 
				<span class="big-screen"><?php echo $heading['title'] ?></span>
				<span class="small-screen"><?php echo $heading['title'] ?></span> 
			</div>
		</div>
		<div class="content_mainwraper">
			<div class="row">
				<div class="col-md-12">
					<div class="panel with-nav-tabs tabs-left">
						<div class="panel-heading zp">
							<ul class="nav nav-tabs nav-justified" style="margin-left: 16px;padding-right: 37px;">
								<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='refrigerator')?'active':'';?>"><a data-toggle="tab" data-id="1" class="q-tab" href="#refrigerator">Refrigerator</a></li>
								<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='cold_room')?'active':'';?>"><a data-toggle="tab" data-id="2" class="q-tab" href="#cold_room">Cold Room</a></li>
								<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='voltage_regulator')?'active':'';?>"><a data-toggle="tab" data-id="3" class="q-tab" href="#voltage_regulator">Voltage Regulator</a></li>
								<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='generator')?'active':'';?>"><a data-toggle="tab" data-id="4" class="q-tab" href="#generator">Generator</a></li>
								<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='transport')?'active':'';?>"><a data-toggle="tab" class="q-tab" data-id="5" href="#transport">Transport</a></li>
								<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='vaccine_carrier')?'active':'';?>"><a data-toggle="tab" class="q-tab" data-id="6" href="#vaccine_carrier">Vaccine Carriers</a></li>
								<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='ice_pack')?'active':'';?>"><a data-toggle="tab" class="q-tab" data-id="7" href="#ice_pack">Ice Pack</a></li>
								<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='cold_box')?'active':'';?>"><a data-toggle="tab" class="q-tab" data-id="8" href="#cold_box">Cold Box</a></li>
							</ul>
						</div>
						<div class="panel-body zp">
							<div class="tab-content" style="padding-top: 10px;">
								<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='refrigerator')?'active in':'';?>" id="refrigerator">
									<div class="row">
										<div class="col-md-12">
											<?php   
											 echo $refrigerator; ?>
										</div>
									</div>
								</div>
								<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='cold_room')?'active in':'';?>" id="cold_room">
									<div class="row">
										<div class="col-md-12">
											<?php echo $cold_room; ?>
										</div>
									</div>
								</div>
								<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='voltage_regulator')?'active in':'';?>" id="voltage_regulator">
									<div class="row">
										<div class="col-md-12">
											<?php echo $voltage_regulator; ?>
										</div>
									</div>
								</div>
								<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='generator')?'active in':'';?>" id="generator">
									<div class="row">
										<div class="col-md-12">
											<?php echo $generator; ?>
										</div>
									</div>
								</div>
								<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='transport')?'active in':'';?>" id="transport">
									<div class="row">
										<div class="col-md-12">
											<?php echo $transport; ?>
										</div>
									</div>
								</div>
								<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='vaccine_carrier')?'active in':'';?>" id="vaccine_carrier">
									<div class="row">
										<div class="col-md-12">
											<?php echo $vaccine_carrier; ?>
										</div>
									</div>
								</div>
								<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='ice_pack')?'active in':'';?>" id="ice_pack">
									<div class="row">
										<div class="col-md-12">
											<?php echo $ice_pack; ?>
										</div>
									</div>
								</div>
								<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='cold_box')?'active in':'';?>" id="cold_box">
									<div class="row">
										<div class="col-md-12">
											<?php echo $cold_box; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--filter bar-->
<div class="filterbarwraper">
	<div id="mySidenavR" class="sidenavR">
		<a href="javascript:void(0)" class="closebtn" title="Filters" onclick="closeNavR()">×</a>
		<div class="filter_formwrp">
			<h2> Filters </h2>
			<?php 
				/*
				*	This will load filter form based on 
				*	name provided to filters array.
				*/
				//$filters['filter'] = 'AccessToHealthServices';
				//$filters['dropout'] = false;
				//$this->load->view('thematic_maps/parts_view/filters',$filters); ?>
		</div>
	</div>
	<div class="container-fluid">
		<span class="tooglebtnfilter"  onclick="openNavR()"><img src="<?php echo base_url();?>includes/images1/filericon.png"></span>
	</div>
</div>
  <!--filter bar-->
	<?php  if(!isset($_REQUEST['export_excel'])){
		if(isset($edit)){
			$this->load->view('thematic_template/script', $data['edit'] = $edit);
		}else{
			$this->load->view('thematic_template/script');
		}
	} ?>
<script type="text/javascript">
$('.minmax').click(function() {
   $('.toggle').slideToggle('slow');
});

function scrolltodivid(paramID){
	$('html,body').animate({
		scrollTop: ($("#"+paramID).offset().top)-100},
        'slow');
}
function drilldownfun(codeParam,asset_type_id){
	if(!(codeParam.length==3)){
		var url = "<?php echo base_url(); ?>dashboard/ColdchainEquipments/ccm_Main/"+codeParam+"/"+asset_type_id;
		window.open(url, '_blank').focus();
	}	
}
	function equdataTable(dataArr,divId,col,col2,height="350",statusName=null){
		if(statusName)
			statusName = "<tr style='height: 42px; font-size: 12px;'><th colspan='2' class='text-center' >"+statusName+"</th></tr>";
		else
			statusName = "";
		var row = "<table  class='table table-bordered table-hover table-striped footable table-vcenter tbl-listing dataTable no-footer' data-filter='#filter' data-filter-text-only='true' style='padding-top: 0%; width: 100%; height: "+height+"px;' role='grid' aria-describedby='myTable_info'><thead>"+statusName+"<tr style='height: 42px; font-size: 12px;'><th class='text-center' ><span style='line-height: 3;'>"+col+"</span></th><th class='text-center' ><span style='line-height: 3;'>"+col2+"</span></th></tr></thead><tbody style='text-align:center;font-size: 12px;'>";
		//alert(col);
		var url = "";
		if(jQuery.isEmptyObject(dataArr)){
			row = "<table  class='table table-bordered table-hover table-striped footable table-vcenter tbl-listing dataTable no-footer' data-filter='#filter' data-filter-text-only='true' style='padding-top: 0%; width: 100%; height: "+height+"px;' role='grid' aria-describedby='myTable_info'><thead></thead><tbody style='text-align:center;'>";
			row +="<tr><td></td><td style='padding-top: 166px;'>No data to display</td></tr>";
		}else{
			$.each( dataArr, function( key, valsec,a ) {
				if(typeof(valsec['link']) != "undefined" && valsec['link'] !== null)
					url = ' style="cursor:pointer" onclick="'+valsec['link']+'"';  
				else
					url = "";
					if(valsec['value']==a){
						row += " <tr "+url+"><td id='aaa' style='width:30%'>"+valsec['label']+"</td><td>"+a+"</td></tr>";
					}
					else {																																																																				
						row += " <tr "+url+"><td id='aaa' style='width:30%'>"+valsec['label']+"</td><td>"+valsec['value']+"</td></tr>";
					}
			});
		}
		row += "</tbody></table>";
		$('#'+divId).html(row);
		$("#"+divId).hide();
		$("#"+divId).slideDown(1000);
		
	}
function wsCountgetData(asset_type_id='1',assetStatus='1',name='refrigerator',statusName,renderAt='store-ws-refg-trend',chartType='column2d',table=null){
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$('#'+renderAt).data("stastid",asset_type_id);
	$('#'+renderAt).data("stid",assetStatus);
	$('#'+renderAt).data("sttypename",name);
	$('#'+renderAt).data("stname",statusName);
	$.ajax({
		type: "POST",
		data : {type:name,assetstatus:assetStatus,asset_type_id:asset_type_id,distcode:'<?php echo $id ?>'},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_storewsWise_counts",
		success: function(result)
		{ 
			if(table)
				{ 
					equdataTable(result,renderAt,'Store Level',table,'350',statusName); 
				}
				else{
				//alert(result);exit;
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: chartType,
						renderAt: renderAt,
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Store Wise Status of "+name+" (All Districts)",
								"subCaption": statusName,
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Numbers",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
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
/// ======== drilldown for all districts data for provincial level(single working status)
function wsDrildwondistricts(wh_type_wise, w_status, typeId,w_statusName,renderAt='district-ws-refg-trend',chartType='column2d',table=null)
{
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$('#'+renderAt).data("sttypes",wh_type_wise);
	$('#'+renderAt).data("sttypestatus",w_status);
	$('#'+renderAt).data("sttypesid",typeId);
	//alert(renderAt);
	$('#'+renderAt).data("stname",w_statusName);
	//alert(wh_type_wise);
	$.ajax({
		type: "POST",
		data : {typecode:wh_type_wise,w_status:w_status,typeIdws:typeId,distcode:'<?php echo $id ?>'},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/districtsWisewsCount",
		success: function(result)
		{
			if(table)
				{ 
					equdataTable(result,renderAt,'Districts',table,'350',w_statusName); 
				}
				else{
			//work for linkeddata
			FusionCharts.ready(function() {
				var salesChart = new FusionCharts({
					type: chartType,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: 'json',
					dataSource: {
						"chart": {
							"caption": "Store Wise w_statusName Refrigerator (All Districts)",
							"subCaption": w_statusName,
							"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
							"yaxisname": "Numbers",
							"linethickness": "2",
							"formatnumberscale": "1",
							"baseFont": "lato-regular",
							"divLineAlpha": "40",
							"anchoralpha": "0",
							"animation": "1",
							"slantlabels": "1",
							"legendborderalpha": "20",
							"drawCrossLine": "1",
							"crossLineColor": "#0d0d0d",
							"crossLineAlpha": "100",
							"tooltipGrayOutColor": "#80bfff",
							"theme": "zune",
							"showValues" : "1",
							"valueFontColor": "#000000",
							"labelFontColor": "#000000",
							"valueBgColor": "#FFFFFF",
							"valueBgAlpha": "50",
							"thousandSeparatorPosition": "3,3,3",
							"useDataPlotColorForLabels": "1",                    
							"exportenabled": "1",
							"showBorder": "1"
						},
						"data": result
					}
				}).render();
			});
		}
		}
	});
}
//// asset type wise at store level=========================
function atwCountgetData(assetID='13',type='refrigerator',subtypeName,renderAt='store-atw-refg-trend',chartType='column2d',table=null){
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$('#'+renderAt).data("stid",assetID);
	$('#'+renderAt).data("sttypename",type);
	$('#'+renderAt).data("sttype",subtypeName);
	$.ajax({
		type: "POST",
		data : {type:type,asset_typeID:assetID,subtypeName:subtypeName,distcode:'<?php echo $id ?>'},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_storeatw_counts",
		success: function(result)
		{
			if(table)
				{ //alert('helo');
					equdataTable(result,renderAt,'Store Level',table,'350',subtypeName); 
				}
				else{
			FusionCharts.ready(function() {
				var salesChart = new FusionCharts({
					type: chartType,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: 'json',
					dataSource: {
						"chart": {
							"caption": "Store Wise available "+type+"(All Districts)",
							"subCaption": subtypeName,
							//"subcaption": "<?php echo (isset($districtName)?$districtName:$this->session->provincename); ?>",
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
function atwDrildwondistricts(wh_type_wise ,assetType,subTypeid,subTypeName,renderAt='district-atw-refg-trend',chartType='column2d',table=null)
{
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$('#'+renderAt).data("sttypeid",wh_type_wise);
	$('#'+renderAt).data("stsubtypeid",subTypeid);
	//$('#'+renderAt).data("sttype",assetType);
	//alert(renderAt);
	$.ajax({
		type: "POST",
		data : {wh_typecode:wh_type_wise,type:assetType,subTypeid:subTypeid,distcode:'<?php echo $id ?>'},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/districtsATWCount",
		success: function(result)
		{
			if(table)
				{ 
					equdataTable(result,renderAt,'Districts',table,'350',subTypeName); 
				}
				else{
			FusionCharts.ready(function() {
				var salesChart = new FusionCharts({
					type: chartType,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: 'json',
					dataSource: {
						"chart": {
							"caption": "Store Wise Status of "+assetType+" (All Districts)",
							"subCaption": subTypeName,
							//"subcaption": "<?php echo (isset($districtName)?$districtName:$this->session->provincename); ?>",
							"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
							"yaxisname": "Numbers",
							"linethickness": "2",
							"formatnumberscale": "1",
							"baseFont": "lato-regular",
							"divLineAlpha": "40",
							"anchoralpha": "0",
							"animation": "1",
							"legendborderalpha": "20",
							"slantlabels": "1",
							"drawCrossLine": "1",
							"crossLineColor": "#0d0d0d",
							"crossLineAlpha": "100",
							"tooltipGrayOutColor": "#80bfff",
							"theme": "zune",
							"showValues" : "1",
							"valueFontColor": "#000000",
							"labelFontColor": "#000000",
							"valueBgColor": "#FFFFFF",
							"valueBgAlpha": "50",
							"thousandSeparatorPosition": "3,3,3",
							"useDataPlotColorForLabels": "1",                    
							"exportenabled": "1",
							"showBorder": "1"
						},
						"data": result
					}
				}).render();
			});
		}
		}
	});
}
//// Year wise at store level=========================
function ywCountgetData(year= null,type='refrigerator',renderAt='store-yw-refg-trend',chartType='column2d',table=null){
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$('#'+renderAt).data("styear",year);
	$.ajax({
		type: "POST",
		data : {type:type,year:year,distcode:'<?php echo $id ?>'},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_storeYW_counts",
		success: function(result)
		{
			if(table)
				{ //alert('helo');
					equdataTable(result,renderAt,'Store Level',table,'350',year); 
				}
				else{
			FusionCharts.ready(function() {
				var salesChart = new FusionCharts({
					type: chartType,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: 'json',
					dataSource: {
						"chart": {
							"caption": "Year Wise available "+type+"(All Districts)",
							"subCaption": "year: "+year,
							//"subcaption": "<?php echo (isset($districtName)?$districtName:$this->session->provincename); ?>",
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
function ywDrildwondistricts(wh_type_wise ,assetType,year,renderAt='district-yw-refg-trend',chartType='column2d',table=null)
{
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$('#'+renderAt).data("styears",wh_type_wise);
	$('#'+renderAt).data("styear",year);
	//alert(assetType);
	$.ajax({
		type: "POST",
		data : {wh_typecode:wh_type_wise,type:assetType,year:year,distcode:'<?php echo $id ?>'},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/districtsywCount",
		success: function(result)
		{
			if(table){
				equdataTable(result,renderAt,'Districts',table,'350',year); 
			}
			else{
			FusionCharts.ready(function() {
				var salesChart = new FusionCharts({
					type: chartType,
					renderAt: renderAt,
					width: '100%',
					height: '350',
					dataFormat: 'json',
					dataSource: {
						"chart": {
							"caption": "Year Wise Status of "+assetType+" (<?php echo (isset($districtName)?$districtName:'All Districts'); ?>)",
							"subCaption": "year: "+year+"<br> <?php echo ($this->session->district)?'':$this->session->provincename;?>",
							"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
							"yaxisname": "Numbers",
							"linethickness": "2",
							"formatnumberscale": "1",
							"baseFont": "lato-regular",
							"divLineAlpha": "40",
							"anchoralpha": "0",
							"animation": "1",
							"legendborderalpha": "20",
							"slantlabels": "1",
							"drawCrossLine": "1",
							"crossLineColor": "#0d0d0d",
							"crossLineAlpha": "100",
							"tooltipGrayOutColor": "#80bfff",
							"theme": "zune",
							"showValues" : "1",
							"valueFontColor": "#000000",
							"labelFontColor": "#000000",
							"valueBgColor": "#FFFFFF",
							"valueBgAlpha": "50",
							"thousandSeparatorPosition": "3,3,3",
							"useDataPlotColorForLabels": "1",                    
							"exportenabled": "1",
							"showBorder": "1"
						},
						"data": result
					}
				}).render();
				var paraID = '<?php echo (isset($scroll) && $scroll != FALSE)?$scroll:FALSE ?>';
				if(paraID){
					scrolltodivid(paraID);
				}
			});
			}
		}
	});
}
</script>