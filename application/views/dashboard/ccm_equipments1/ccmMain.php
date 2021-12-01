<?php //var_dump($refrigerator);exit; ?>
<div class="flypanels-main">
<div class="flypanels-topbar"> <a class="flypanels-button-left icon-menu" data-panel="treemenu" href="#"><i class="fa fa-bars"></i></a> <h2 class="topbar-heading">Expanded Program on Immunization Thematic Maps Dashboard</h2> </div>
<div class="header_profilewraper">
	<div class="profile_dropdown">
		<div class="dropdown">
			<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> <?php echo $this -> session -> User_Name; ?> </button>
			<ul class="dropdown-menu">
				<li><a href="<?php echo base_url();?>Logout"> <i class="fa fa-key" aria-hidden="true"></i> Sign out </a></li>
			</ul>
		</div>
	</div>
</div>
<div class="flypanels-content">
	<div class="container-fluid">
		<div class="content_mainwraper">
			<div class="main_heading"> <?php echo $heading['title']; ?> </div>
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

function drilldownfun(codeParam,asset_type_id){
	if(!(codeParam.length==3)){
		var url = "<?php echo base_url(); ?>dashboard/ColdchainEquipments/ccm_Main/"+codeParam+"/"+asset_type_id;
		window.open(url, '_blank').focus();
	}	
}
function wsCountgetData(asset_type_id='1',assetStatus='1',name='refrigerator',statusName,renderAt='store-ws-refg-trend',chartType='column2d'){
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$.ajax({
		type: "POST",
		data : {type:name,assetstatus:assetStatus,asset_type_id:asset_type_id},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_storewsWise_counts",
		success: function(result)
		{
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
	});
}
/// ======== drilldown for all districts data for provincial level(single working status)
function wsDrildwondistricts(wh_type_wise, w_status, typeId,w_statusName,renderAt='district-ws-refg-trend',chartType='column2d')
{
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$.ajax({
		type: "POST",
		data : {typecode:wh_type_wise,w_status:w_status,typeIdws:typeId},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/districtsWisewsCount",
		success: function(result)
		{
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
	});
}
//// asset type wise at store level=========================
function atwCountgetData(assetID='13',type='refrigerator',subtypeName,renderAt='store-atw-refg-trend',chartType='column2d'){
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$.ajax({
		type: "POST",
		data : {type:type,asset_typeID:assetID,subtypeName:subtypeName},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/get_cc_storeatw_counts",
		success: function(result)
		{
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
	});
}
function atwDrildwondistricts(wh_type_wise ,assetType,subTypeid,subTypeName,renderAt='district-atw-refg-trend',chartType='column2d')
{
	$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
	$.ajax({
		type: "POST",
		data : {wh_typecode:wh_type_wise,type:assetType,subTypeid:subTypeid},
		dataType: "JSON",
		url: "<?php echo base_url() ?>dashboard/ColdchainEquipments/districtsATWCount",
		success: function(result)
		{
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
	});
}
</script>