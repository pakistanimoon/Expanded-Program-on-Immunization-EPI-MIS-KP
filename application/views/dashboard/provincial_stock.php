<?php //echo json_encode($data['category']);
$regoin="";
  $reportingmonth = date('Y-m', strtotime('-1 month', time()));
if($this -> session -> UserLevel=='2'){
	$regoin="District";$val=0;//for hide/show data series legend;
}	
if($this -> session -> UserLevel=='3'){
	$regoin="Facility";$val=1;
}
if($this -> session -> UserLevel=='4'){
	$regoin="Tehsil";$val=2;
}
?>
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
		<!-- Current province Login Name here -->
				<div class="main_heading"> 
					<span class="big-screen"><?php echo $regoin;?>  Wise Inventory Stock Information</span>
					<span class="small-screen"><?php echo $regoin;?>  Wise Inventory Stock Information</span> 
				</div>
		</div>
		<div class="content_mainwraper panel" style="padding:10px;border-radius:4px;">
				<div class="row" style="margin-bottom:20px">
					<div class="col-md-8">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span>Available Stock (Vaccine)</span>
							<div class="pull-right">
								<a  style="color:#000000; cursor: pointer;"  onclick="renderTable('chart-container1','1');" style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Stacked Area View"><span ><i class="icon fa fa-area-chart" onclick="VaccineChart('stackedarea2d')"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick="VaccineChart('stackedcolumn2d')"></i></span>
								</a>
							</div>
						</div>
						<!--For Vaccines:Item Category :1--->
						<div id="chart-container1" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
					<div class="col-md-4">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span>Available Stock (Dilluent)</span>
							<div class="pull-right">
								<a  style="color:#000000; cursor: pointer;"  onclick="renderTable('chart-container3','3');" style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a    style="color:#000000; cursor: pointer;" title="Stacked Area View"><span ><i class="icon fa fa-area-chart" onclick="loadDilluentChart('stackedarea2d','false')"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick="loadDilluentChart('stackedcolumn2d',false)"></i></span>
								</a>
							</div>
						</div>
						<!--For Dilluent:Item Category :3--->
						<div id="chart-container3" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
					</div>
					
				</div>
					<div class="row" id="drillchart" style="margin-bottom:20px;display:none" >
					<div class="col-md-12">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span id="text">Available Stock </span>
							<div class="pull-right">
								<!-- for multuple chart types option-->
								<a  class="charttype" type="tabular" style="color:#000000; cursor: pointer;"  onclick="" style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a    class="charttype" type="line" style="color:#000000; cursor: pointer;" title="Line Chart View"><span ><i class="icon fa fa-line-chart" onclick=""></i></span>
								</a>
								<a   class="charttype"  type="column2d" style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick=""></i></span>
								</a>
							</div>
						</div>
						<!--For Drill down chart -->
						<div id="chart-container4" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
					</div>
					<div class="row" style="margin-bottom:20px">
					<div class="col-md-12">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span>Available Stock (Non Vaccine)</span>
							<div class="pull-right">
								<a  style="color:#000000; cursor: pointer;"  onclick="renderTable('chart-container2','2');" style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a    style="color:#000000; cursor: pointer;" title="Stacked Area View"><span ><i class="icon fa fa-area-chart" onclick="loadNonVaccineChart('stackedarea2d','false')"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick="loadNonVaccineChart('stackedcolumn2d',false)"></i></span>
								</a>
							</div>
						</div>
						<!--For Non Vaccines:Item Category :2-->
						<div id="chart-container2" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
					</div>
					<!-- HF stock out rate-->
					<div class="row" style="margin-bottom:20px">
					<div class="col-md-8">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span>HF Stock out Rate (Vaccines),According to closing balance in submitted reports of <?php echo $reportingmonth ;?> </span>
							<div class="pull-right">
								<a   style="color:#000000; cursor: pointer;"  onclick="renderTableHF('chart-container5','vaccines')" style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a    style="color:#000000; cursor: pointer;" title="Stacked Area View"><span ><i class="icon fa fa-line-chart" onclick="laodVaccineHFStockOut('line',false)"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick="laodVaccineHFStockOut('column2d',false)"></i></span>
								</a>
							</div>
						</div>
						<!--For Non Vaccines:Item Category :2-->
						<div id="chart-container5" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
						<div class="col-md-4">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span>Stock out Rate (Dilluent)</span>
							<div class="pull-right">
								<a  style="color:#000000; cursor: pointer;"  onclick="renderTableHF('chart-container7','diluents')"  style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a    style="color:#000000; cursor: pointer;" title="Stacked Area View"><span ><i class="icon fa fa-line-chart" onclick="laodDilluentHFStockOut('line','false')"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick="laodDilluentHFStockOut('line','false')"></i></span>
								</a>
							</div>
						</div>
					<!--For Non Vaccines:Item Category :2-->
						<div id="chart-container7" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
					</div>
					<div class="row" id="HFdrillchart" style="margin-bottom:20px;display:none" >
					<div class="col-md-12">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span id="textnew">HF Stock out Rate District Wise</span>
							<!-- work on it later <div class="pull-right">
								<a  class="" type="tabular" style="color:#000000; cursor: pointer;" onclick=""  style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a   class="" type="line" style="color:#000000; cursor: pointer;" title="Line  View"><span ><i class="icon fa fa-line-chart" onclick=""></i></span>
								</a>
								<a  class=""  type="column2d" style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" onclick=""></i></span>
								</a>
							</div> -->
						</div>
						<!--For Drill down chart -->
						<div id="chart-container8" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
					</div>
										<!-- HF stock out rate-->
					<div class="row" style="margin-bottom:20px">
					<div class="col-md-12">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span>HF Stock out Rate (Non Vaccines),According to closing balance in submitted reports of  <?php echo $reportingmonth ;?></span>
							<div class="pull-right">
								<a   style="color:#000000; cursor: pointer;" onclick="renderTableHF('chart-container6','nonvaccines')"  style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a    style="color:#000000; cursor: pointer;" title="Stacked Area View"><span ><i class="icon fa fa-line-chart" onclick="laodNonVaccineHFStockOut('line',false)"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick="laodNonVaccineHFStockOut('column2d',false)"></i></span>
								</a>
							</div>
						</div>
						<!--For Non Vaccines:Item Category :2-->
						<div id="chart-container6" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
					</div>
					<!-- Hf Stock out for stock Greater Than Required -->
					<div class="row" style="margin-bottom:20px">
					<div class="col-md-8">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span>HF Stock out Rate Requisition Camparison (Vaccines) <?php echo $reportingmonth ;?> </span>
							<div class="pull-right">
								<a   style="color:#000000; cursor: pointer;"  onclick="renderTableHFRequisition('chart-container9','vaccines')" style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a    style="color:#000000; cursor: pointer;" title="Stacked Area View"><span ><i class="icon fa fa-line-chart" onclick="loadvaccineHFRequired('msline',false)"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick="loadvaccineHFRequired('mscolumn2d',false)"></i></span>
								</a>
							</div>
						</div>
						<!--For Non Vaccines:Item Category :2-->
						<div id="chart-container9" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
						<div class="col-md-4">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span>Stock out Rate (Requisition )(Dilluent)</span>
							<div class="pull-right">
								<a  style="color:#000000; cursor: pointer;"  onclick="renderTableHFRequisition('chart-container10','diluents')"  style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a    style="color:#000000; cursor: pointer;" title="Stacked Area View"><span ><i class="icon fa fa-line-chart" onclick="loadDilluentHFRequired('msline','false')"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick="loadDilluentHFRequired('mscolumn2d','false')"></i></span>
								</a>
							</div>
						</div>
					<!--For Non Vaccines:Item Category :2-->
						<div id="chart-container10" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
					</div>
					<!-- For Drilldown HF stock out rate Required/Suggested-->
					<div class="row" id="HFRequisitiondrillchart" style="margin-bottom:20px;display:none" >
					<div class="col-md-12">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span id="textnewreq">HF Stock out Rate Required/Suggested Requisition District Wise</span>
							<!-- work on it later <div class="pull-right">
								<a  class="" type="tabular" style="color:#000000; cursor: pointer;" onclick=""  style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a   class="" type="line" style="color:#000000; cursor: pointer;" title="Line  View"><span ><i class="icon fa fa-line-chart" onclick=""></i></span>
								</a>
								<a  class=""  type="column2d" style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" onclick=""></i></span>
								</a>
							</div> -->
						</div>
						<!--For Drill down chart -->
						<div id="chart-container11" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
					</div>
					<div class="row" id="HF_Fac_Requisitiondrillchart" style="margin-bottom:20px;display:none" >
					<div class="col-md-12">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span id="textnewreqhf">HF Stock out Rate Required/Suggested Requisition  Facilities Wise</span>
							<!-- work on it later <div class="pull-right">
								<a  class="" type="tabular" style="color:#000000; cursor: pointer;" onclick=""  style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a   class="" type="line" style="color:#000000; cursor: pointer;" title="Line  View"><span ><i class="icon fa fa-line-chart" onclick=""></i></span>
								</a>
								<a  class=""  type="column2d" style="color:#000000; cursor: pointer;" title="Bar View"><span ><i class="icon fa fa-bar-chart" onclick=""></i></span>
								</a>
							</div> -->
						</div>
						<!--For Drill down chart -->
						<div id="chart-container13" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
					</div>
					<!-- for hf stock out requisition non vaacines -->
					<div class="row" style="margin-bottom:20px">
					<div class="col-md-12">
						<div class="section-title" style="padding: 0px 6px; line-height:30px;">
							<span>HF Stock out Rate Requisition (Non Vaccines),According to closing balance in submitted reports of  <?php echo $reportingmonth ;?></span>
							<div class="pull-right">
								<a   style="color:#000000; cursor: pointer;" onclick="renderTableHFRequisition('chart-container12','nonvaccines')"  style="color:#000000;" title="Tabular View"><span ><i class="icon fa fa-table"></i></span>
								</a>							
								<a    style="color:#000000; cursor: pointer;" title="Stacked Area View"><span ><i class="icon fa fa-line-chart" onclick="loadNonVaccineHFRequired('msline',false)"></i></span>
								</a>
								<a    style="color:#000000; cursor: pointer;" title="Line Bar View"><span ><i class="icon fa fa-bar-chart" onclick="loadNonVaccineHFRequired('mscolumn2d',false)"></i></span>
								</a>
							</div>
						</div>
						<!--For Non Vaccines:Item Category :2-->
						<div id="chart-container12" style="overflow:scroll;height:350px;border:1px solid #e2e2e2;"></div>
						</div>
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
	//Global Variables For Store Chart Data to use for Different Chart Type.
	Dilluent=NonVaccine=districtWise=itemname=itemtype=HFVaccine=HFNonVaccine=HFDilluent=itemid=DistrictWiseFacility=HFstockout=itemCategory=HFVaccineRequired=HFdilluentRequired=HfRequisitionStockOut=HFNonVaccineRequired=null;
	dataSource = {
		"chart": {
			"caption": "Total Avialable Stock in Warehouse (<?php echo $this->session->loginfrom;?>)",
			"subCaption":"Click on column/line/slice to drill down to sub level information of respective level" ,
			"yaxisname": "Vials/Pcs",
			"linethickness": "2",
			"formatnumberscale": "1",
			"baseFont": "lato-regular",
			"divLineAlpha": "40",
			"anchoralpha": "0",
			"animation": "1",
			"labelDisplay": "rotate",
			"slantLabels": "1",
			"legendborderalpha": "20",
			"drawCrossLine": "1",
			"crossLineColor": "#0d0d0d",
			"crossLineAlpha": "100",
			"tooltipGrayOutColor": "#80bfff",
			"theme": "zune",
			//"showValues" : "1",
			"valueFontColor": "#000000",
			"labelFontColor": "#000000",
			"valueBgColor": "#FFFFFF",
			"valueBgAlpha": "50",
			"thousandSeparatorPosition": "3,3,3",
			"useDataPlotColorForLabels": "1",                    
			"exportenabled": "1",
			"showBorder": "1"
		},
		"categories": [{
			"category": <?php echo json_encode($data['category']);?>
		}],
		"dataset": [{
			"seriesname": "Provincial",
			"initiallyHidden":<?php echo $val;?>,
			"data":<?php echo json_encode($data['provincial']);?>
		},
		{
			"seriesname": "District",
            <?php if($this -> session -> UserLevel=='4'){ ?>
			"initiallyHidden":<?php echo $val;?>,
			<?php }?> 
            "data": <?php echo json_encode($data['district']);?>
		},
		{
			"seriesname": "Tehsil",
			"data": <?php echo json_encode($data['tehsil']);?>
		},
		{
            "seriesname": "Facility",
			"data": <?php echo json_encode($data['facility']);?>
		}]
	};
	//Trigger chart for stackedcolumn2d
	VaccineChart('stackedcolumn2d');
	function VaccineChart(chartType){
		FusionCharts.ready(function() {
		   var myChart = new FusionCharts({
			  type:chartType,
			  renderAt: "chart-container1",
			  width: '100%',
				height: '350',
			  dataFormat: "json",
			  dataSource
		   }).render();
		});
	}
	//Function to show facility stock district wise/tehsil wise etc.
	function getDistrictWiseFacility(itemid,name,type,datatype,itemseqid,columntype,ajax)
	{
		
		$('#drillchart').show();
		if(ajax=='true')
		{
				//alert("ajaxstart");
				itemname=name;
				itemCategory=type;
				$.ajax({
					type: "POST", //columntype :district wise,tehsil wise etc
					data : {itemid:itemid,itemseqid:itemseqid,itemname:name,type:type},
					dataType: "JSON",
					async:false,
					url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand_facilities",
					success: function(result)
					{
						DistrictWiseFacility=result;
					}
				});
		}
		$('#text').attr('type','facilities');
		if(itemCategory==1)
		{
			$('#text').text('Available Stock (Vaccine)');
		}
		if(itemCategory==2)
		{
			$('#text').text('Available Stock (Non Vaccine)');
		}
		if(itemCategory==3)
		{
			$('#text').text('Available Stock (Dilluent)');
		}
		FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type:columntype,
						renderAt: "chart-container4",
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Facility Level Stock District Wise  Available Stock of "+itemname+"",
								//"subCaption": statusName,
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Vials/Pcs",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"slantlabels": "1",
								"labelDisplay": "rotate",
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
							"data": DistrictWiseFacility
						}
					})
					.render();
				});	
	}
	//function to get facility stock of district parameter
	function getDistrictFacility(itemid,name,type,columntype,itemseqid,distcode)
	{
		$('#drillchart').show();
		if(type=="1")
		{
			$('#text').text('Available Stock (Vaccine)');
		}
		if(type=="2")
		{
			$('#text').text('Available Stock (Non Vaccine)');
		}
		if(type=="3")
		{
			$('#text').text('Available Stock (Dilluent)');
		}	
		$.ajax({
			type: "POST", //columntype :district wise,tehsil wise etc
			data : {itemid:itemid,itemseqid:itemseqid,itemname:name,type:type,distcode:distcode},
			dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand_dist_facilities",
			success: function(result)
			{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type:'column2d',
						renderAt: "chart-container4",
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Facility Level Stock  Available Stock of "+name+"",
								//"subCaption": statusName,
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Vials/Pcs",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"slantlabels": "1",
								"labelDisplay": "rotate",
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
		//function to get facility stock of tehsil parameter
	function getTehsilFacilityWise(itemid,name,type,columntype,itemseqid,tcode)
	{
		$('#drillchart').show();
		if(type=="1")
		{
			$('#text').text('Available Stock (Vaccine)');
		}
		if(type=="2")
		{
			$('#text').text('Available Stock (Non Vaccine)');
		}
		if(type=="3")
		{
			$('#text').text('Available Stock (Dilluent)');
		}	
		$.ajax({
			type: "POST", //columntype :district wise,tehsil wise etc
			data : {itemid:itemid,itemseqid:itemseqid,itemname:name,type:type,tcode:tcode},
			dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand_tehsils_facilities",
			success: function(result)
			{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type:'column2d',
						renderAt: "chart-container4",
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Facility Level Stock  Available Stock of "+name+"",
								//"subCaption": statusName,
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Vials/Pcs",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"slantlabels": "1",
								"labelDisplay": "rotate",
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
	//function to get facility stock of tehsil parameter
	function getTehsilFacility(itemid,name,type,columntype,itemseqid,distcode)
	{ 
		$('#drillchart').show();
		if(type=="1")
		{
			$('#text').text('Available Stock (Vaccine)');
		}
		if(type=="2")
		{
			$('#text').text('Available Stock (Non Vaccine)');
		}
		if(type=="3")
		{
			$('#text').text('Available Stock (Dilluent)');
		}	
		$.ajax({
			type: "POST", //columntype :district wise,tehsil wise etc
			data : {itemid:itemid,itemseqid:itemseqid,itemname:name,type:type,distcode:distcode},
			dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand_tehs_facilities",
			success: function(result)
			{ 
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type:'column2d',
						renderAt: "chart-container4",
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Tehsil Level Stock  Available Stock of "+name+"",
								//"subCaption": statusName,
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Vials/Pcs",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"slantlabels": "1",
								"labelDisplay": "rotate",
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
//Function to show chart district wise detail 
	function getDistrictWise(itemid,name,type,chartType,ajax)
	{
		//console.log($(this));
		$('#drillchart').show();
		$('#text').attr('type','district');
		

		if(ajax=='true')
		{
			itemname=name;itemtype=type;itemid=itemid;
			$.ajax({
				type: "POST",
				data : {itemid:itemid,type:type},
				async:false,
				dataType: "JSON",
				url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand_districts",
				success: function(result)
				{
					districtWise=result;
				}
			});
		}
			if(itemtype=="1")
		{
			$('#text').text('Available Stock District Wise(Vaccine)');
			
		}
		if(itemtype=="2")
		{
			$('#text').text('Available Stock District Wise(Non Vaccine)');
			
		}
		if(itemtype=="3")
		{
			$('#text').text('Available Stock District Wise(Dilluent)');
			
		}
	//Fusion chart 	
					FusionCharts.ready(function() {
						var salesChart = new FusionCharts({
							type:chartType,
							renderAt: "chart-container4",
							width: '100%',
							height: '350',
							dataFormat: 'json',
							dataSource: {
								"chart": {
									"caption": "Dsitricts Wise Total Available Stock of "+itemname+"",
									//"subCaption": statusName,
									"plottooltext": "Total Available Stock at $label are <b>$dataValue</b>",
									"yaxisname": "Vials/Pcs",
									"linethickness": "2",
									"formatnumberscale": "1",
									"baseFont": "lato-regular",
									"slantlabels": "1",
									"labelDisplay": "rotate",
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
								"data": districtWise
							}
						})
						.render();
					});
	}
	//Function to show chart tehsil wise detail 
	function getTehsilWise(itemid,name,type,chartType,ajax)
	{
		////console.log($(this));
		$('#drillchart').show();
		$('#text').attr('type','tehsil');
		

		if(ajax=='true')
		{
			itemname=name;itemtype=type;itemid=itemid;
			$.ajax({
				type: "POST",
				data : {itemid:itemid,type:type},
				async:false,
				dataType: "JSON",
				url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand_tehsils",
				success: function(result)
				{
					tehsilWise=result; 
				}
			}); 
		}
			if(itemtype=="1")
		{
			$('#text').text('Available Stock Tehsil Wise(Vaccine)');
			
		}
		if(itemtype=="2")
		{
			$('#text').text('Available Stock Tehsil Wise(Non Vaccine)');
			
		}
		if(itemtype=="3")
		{
			$('#text').text('Available Stock Tehsil Wise(Dilluent)');
			
		}
	//Fusion chart 	
					FusionCharts.ready(function() {
						var salesChart = new FusionCharts({
							type:chartType,
							renderAt: "chart-container4",
							width: '100%',
							height: '350',
							dataFormat: 'json',
							dataSource: {
								"chart": {
									"caption": "Tehsils Wise Total Available Stock of "+itemname+"",
									//"subCaption": statusName,
									"plottooltext": "Total Available Stock at $label are <b>$dataValue</b>",
									"yaxisname": "Vials/Pcs",
									"linethickness": "2",
									"formatnumberscale": "1",
									"baseFont": "lato-regular",
									"slantlabels": "1",
									"labelDisplay": "rotate",
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
								"data": tehsilWise
							}
						})
						.render();
					});
	}
	//function to get facility stock tehsil wise 
	function getTehsilWiseFacility(itemid,itemseqid,columntype,type,name)
	{
		$.ajax({
			type: "POST", //columntype :district wise,tehsil wise etc
			data : {itemid:itemid,itemseqid:itemseqid,name:name,itemCategory:type},
			dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand_Tehsil_facilities",
			success: function(result)
			{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type:'column2d',
						renderAt: "chart-container4",
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Facility Level Stock "+columntype+" Wise  Available Stock of "+name+"",
								//"subCaption": statusName,
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Vials/Pcs",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"slantlabels": "1",
								"labelDisplay": "rotate",
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
	//get Facility Wise stock in hand data
	function getFacilityWiseStock(itemid,itemseqid,columntype,name,tcode,type)
	{
		$.ajax({
			type: "POST", //columntype :district wise,tehsil wise etc
			data : {itemid:itemid,itemseqid:itemseqid,tcode:tcode,name:name},
			dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand_facilities_wise",
			success: function(result)
			{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type:'column2d',
						renderAt: "chart-container4",
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "Facility  Wise  Available Stock of "+name+"",
								//"subCaption": statusName,
								"plottooltext": "Total Available Equipments at $label are <b>$dataValue</b>",
								"yaxisname": "Vials/Pcs",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"slantlabels": "1",
								"labelDisplay": "rotate",
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

	$( window ).load(function() {

			loadDilluentChart(chartType="stackedcolumn2d",ajax="true");
			loadNonVaccineChart(chartType="stackedcolumn2d",ajax="true");
			laodVaccineHFStockOut(chartType="column2d",ajax="true");
			//laodNonVaccineHFStockOut(chartType="line",ajax="true");
			laodNonVaccineHFStockOut(chartType="column2d",ajax="true");
			laodDilluentHFStockOut(chartType="column2d",ajax="true");
			//NEW HF stock out 
			loadvaccineHFRequired(chartType="mscolumn2d",ajax="true");
			loadDilluentHFRequired(chartType="mscolumn2d",ajax="true");
			loadNonVaccineHFRequired(chartType="mscolumn2d",ajax="true");
	});
	function laodVaccineHFStockOut(chartType,ajax)
	{
		if(ajax=="true")
		{
			$.ajax({
				type: "POST",
				data : {'typeofitems':'vaccines','result':'false'},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_str_stock_out_data",
				success: function(result)
				{
					//alert(result);
					HFVaccine=result;
					//console.log(result);

				}
			});
		}
		//code for chart
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:chartType,
				renderAt: "chart-container5",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource: {
					"chart": {
						"caption": "Facilities Stock out rate for specific vaccine items(<?php echo $this->session->loginfrom;?>)",
						"subCaption":"Click on column/line/slice to drill down to sub level information of respective level" ,
						"yaxisname": "Vials/Pcs",
						"linethickness": "2",
						"numberSuffix": "%",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"divLineAlpha": "40",
						"anchoralpha": "0",
						"animation": "1",
						"labelDisplay": "rotate",
						"slantLabels": "1",
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
					"data":HFVaccine
				}
			})
			.render();
		});
	}
	//hf stock rate non vaccine
	function laodNonVaccineHFStockOut(chartType,ajax)
	{		
		if(ajax=="true")
		{
			$.ajax({
				type: "POST",
				data : {'typeofitems':'nonvaccines','result':'false'},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_str_stock_out_data",
				success: function(result)
				{
					HFNonVaccine=result;
				}
			});
		}
		//code for chart
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:chartType,
				renderAt: "chart-container6",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource: {
					"chart": {
						"caption": "Facilities Stock out rate for specific Non vaccine items(<?php echo $this->session->loginfrom;?>)",
						"subCaption":"Click on column/line/slice to drill down to sub level information of respective level" ,
						"yaxisname": "Vials/Pcs",
						"linethickness": "2",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"divLineAlpha": "40",
						"anchoralpha": "0",
						"animation": "1",
						"numberSuffix": "%",
						"labelDisplay": "rotate",
						"slantLabels": "1",
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
					"data":HFNonVaccine
				}
			})
			.render();
		});
	}
	//hf stock rate non vaccine
	function laodDilluentHFStockOut(chartType,ajax)
	{			
		if(ajax=="true")
		{
			$.ajax({
				type: "POST",
				data : {'typeofitems':'diluents','result':'false'},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_str_stock_out_data",
				success: function(result)
				{
					HFDilluent=result;
				}
			});
		}
		//code for chart
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:chartType,
				renderAt: "chart-container7",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource: {
					"chart": {
						"caption": "Facilities Stock out rate for specific Dilluent items(<?php echo $this->session->loginfrom;?>)",
						"subCaption":"Click on column/line/slice to drill down to sub level information of respective level" ,
						"yaxisname": "Vials/Pcs",
						"linethickness": "2",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"divLineAlpha": "40",
						"anchoralpha": "0",
						"animation": "1",
						"numberSuffix": "%",
						"labelDisplay": "rotate",
						"slantLabels": "1",
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
					"data":HFDilluent
				}
			})
			.render();
		});
	}
	function loadDilluentChart(chartType,ajax){		
		if(ajax=="true")
		{
			$.ajax({
				type: "POST",
				data : {'itemCategory':'3','result':'false'},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand",
				success: function(result)
				{
					Dilluent=result;
				}
			});
		}
		//code for chart
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:chartType,
				renderAt: "chart-container3",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource: {
					"chart": {
						"caption": "Total Avialable Stock in Warehouse (<?php echo $this->session->loginfrom;?>)",
						"subCaption":"Click on column/line/slice to drill down to sub level information of respective level" ,
						"yaxisname": "Vials/Pcs",
						"linethickness": "2",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"divLineAlpha": "40",
						"anchoralpha": "0",
						"animation": "1",
						"labelDisplay": "rotate",
						"slantLabels": "1",
						"legendborderalpha": "20",
						"drawCrossLine": "1",
						"crossLineColor": "#0d0d0d",
						"crossLineAlpha": "100",
						"tooltipGrayOutColor": "#80bfff",
						"theme": "zune",
						//"showValues" : "1",
						"valueFontColor": "#000000",
						"labelFontColor": "#000000",
						"valueBgColor": "#FFFFFF",
						"valueBgAlpha": "50",
						"thousandSeparatorPosition": "3,3,3",
						"useDataPlotColorForLabels": "1",                    
						"exportenabled": "1",
						"showBorder": "1"
					},
					"categories": [{
						"category": Dilluent['data']['category']
					}],
					"dataset": [{
						"seriesname": "Provincial",
						"initiallyHidden":<?php echo $val;?>,
						"data":Dilluent['data']['provincial']
					},
					{
						"seriesname": "District",
                        <?php if($this -> session -> UserLevel=='4'){ ?>
			            "initiallyHidden":<?php echo $val;?>,
						<?php }?> 
                        "data": Dilluent['data']['district']
					},
					{
						"seriesname": "Tehsil",
						"data": Dilluent['data']['tehsil']
					},
					{
                        "seriesname": "Facility",
						"data": Dilluent['data']['facility']
					}]		
				}
			})
			.render();
		});
	}
	function loadNonVaccineChart(chartType,ajax)
	{
		if(ajax=="true")
		{		
			$.ajax({
				type: "POST",
				data : {'itemCategory':'2','result':'false'},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand",
				success: function(result)
				{
					//alert(result);
					NonVaccine=result;
					//console.log(result['data']['category']);
				}
			});
		}
		//load chart
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:chartType,
				renderAt: "chart-container2",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource: {
					"chart": {
						"caption": "Total Avialable Stock in Warehouse (<?php echo $this->session->loginfrom;?>)",
						"subCaption":"Click on column/line/slice to drill down to sub level information of respective level" ,
						"yaxisname": "Vials/Pcs",
						"linethickness": "2",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"divLineAlpha": "40",
						"anchoralpha": "0",
						"animation": "1",
						"labelDisplay": "rotate",
						"slantLabels": "1",
						"legendborderalpha": "20",
						"drawCrossLine": "1",
						"crossLineColor": "#0d0d0d",
						"crossLineAlpha": "100",
						"tooltipGrayOutColor": "#80bfff",
						"theme": "zune",
						//"showValues" : "1",
						"valueFontColor": "#000000",
						"labelFontColor": "#000000",
						"valueBgColor": "#FFFFFF",
						"valueBgAlpha": "50",
						"thousandSeparatorPosition": "3,3,3",
						"useDataPlotColorForLabels": "1",                    
						"exportenabled": "1",
						"showBorder": "1"
					},
					"categories": [{
							"category": NonVaccine['data']['category']
						  }],
						  "dataset": [{
							  "seriesname": "Provincial",
							  "initiallyHidden":<?php echo $val;?>,
							  "data":NonVaccine['data']['provincial']
							},
							{
							  "seriesname": "District",
                              <?php if($this -> session -> UserLevel=='4'){ ?>
			                  "initiallyHidden":<?php echo $val;?>,
							  <?php }?> 
                              "data": NonVaccine['data']['district']
							},
							{
							  "seriesname": "Tehsil",
							  "data": NonVaccine['data']['tehsil']
							},
							{
                              "seriesname": "Facility",
							  "data": NonVaccine['data']['facility']
							}
						  ]		
				}
			})
			.render();
		});
	}	
	//hf stock out rate dilluent 

	///tabular view chart data
	function renderTable(containerId,ItemCategory) 
	{
		// After the chart is rendered we export the data as CSV, parse it and then create a markup
		// equivalent to a table by parsing the exported CSV.
		var region='<?php echo $this->session-> UserLevel; ?>';
		$('#'+containerId).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		var htmlheader='<tr><th>Items</th><th>Provincial</th><th>District</th><th>Tehsil</th><th>Facility</th></tr>';
		if(region=='3')
			var htmlheader='<tr><th>Items</th><th>District</th><th>Tehsil</th><th>Facility</th></tr>';
        if(region=='4')
			var htmlheader='<tr><th>Items</th><th>District</th><th>Tehsil</th><th>Facility</th></tr>';
$.ajax({
			type: "POST",
			data : {'itemCategory':ItemCategory,'result':'false'},
			//dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_stock_in_hand_tabular",
			success: function(result)
			{
				//console.log(result);
				jsondata=JSON.parse(result);
				//console.log(jsondata.data);
				for(var data in jsondata.data)
				{
					
					var tddata=(region== '2' ?'<td>'+jsondata.data[data].province_stock+'</td>':'') ; 
					if(jsondata.data[data].facility==null) 
						jsondata.data[data].facility=0;
					htmlheader+='<tr><th>'+jsondata.data[data].name+'</th>'+tddata+'<td style="cursor:pointer" containderid='+containerId+' class="distdrilldown" id='+jsondata.data[data].id+' itemname='+jsondata.data[data].name+' >'+jsondata.data[data].district_stock+'</td><td style="cursor:pointer" containderid='+containerId+' class="tehdrilldown" id='+jsondata.data[data].id+' itemid='+jsondata.data[data].itemid+' itemname='+jsondata.data[data].name+'>'+jsondata.data[data].tehsil_stock+'</td><td style="cursor:pointer" containderid='+containerId+' class="facdrilldown" id='+jsondata.data[data].id+' itemid='+jsondata.data[data].itemid+' itemname='+jsondata.data[data].name+'>'+jsondata.data[data].facility+'</td></tr>';
				}
					$('#'+containerId).html('<table class="table table-bordered table-hover table-striped" style="padding-top: 0%; width: 100%; height: 100%; table-layout: fixed;" role="grid" width="100%" max-height="350px">'+htmlheader+'</table>');

				////console.log(htmlheader); 
			}
		});	
	}
	//function for drillchart for HF stock out rate	
	function getDistrictWiseHFStockoutRate(itemid,agg_items_id,itemname,category_id,ajax)
	{
		$('#chart-container8').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$('#HFdrillchart').show();  
		if(category_id=="1")
		{
			$('#textnew').text('HF Stock out Rate District Wise(Vaccine)');
		}
		if(category_id=="2")
		{
			$('#textnew').text('HF Stock out Rate District Wise(Non Vaccine)');
		}
		if(category_id=="3")
		{
			$('#textnew').text('HF Stock out Rate District Wise(Dilluent)');
		}
		if(ajax=="true")
		{     
			$.ajax({
				type: "POST", //columntype :district wise,tehsil wise etc
				data : {itemid:itemid,agg_items_id:agg_items_id,itemname:itemname},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_stockout_Rate_districts",
				success: function(result)
				{
					HFstockout=result;
					////console.log(HFstockout);
				}
			});
		}
		//chart 
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:'column2d',
				renderAt: "chart-container8",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource: {
					"chart": {
						"caption": "HF Stock out Rate District Wise of "+itemname+"", 
						//"subCaption": statusName,
						"plottooltext": "Total Available Stock out Rate at $label are <b>$dataValue</b>",
						"yaxisname": "Vials/Pcs",
						"linethickness": "2",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"slantlabels": "1",
						"labelDisplay": "rotate",
						"divLineAlpha": "40",
						"numberSuffix": "%",
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
					"data": HFstockout
				}
			})
			.render();
		});
		
	}
	function getFacilityWiseHFStockoutRate(itemid,agg_items_id,itemname,distcode)
	{
		$('#HFdrillchart').show();
		$('#textnew').text('HF Stock out Rate Facility Wise');
		$.ajax({
			type: "POST", //columntype :district wise,tehsil wise etc
			data : {itemid:itemid,agg_items_id:agg_items_id,itemname:itemname,distcode:distcode},
			dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_stockout_Rate_facility",
			success: function(result)
			{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type:'column2d',
						renderAt: "chart-container8",
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "HF Stock out Rate Facility  Wise of "+itemname+"", 
								//"subCaption": statusName,
								"plottooltext": "Total Available Stock out Rate at $label are <b>$dataValue</b>",
								"yaxisname": "Vials/Pcs",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"slantlabels": "1",
								"labelDisplay": "rotate",
								"divLineAlpha": "40",
								"numberSuffix": "%",
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
	//HF stock out rate tabular
	function renderTableHF(containerId,ItemCategory) 
	{
	$('#'+containerId).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		var htmlheader='<tr><th>Items</th><th>Stock Out Rate</th></tr>';
		$.ajax({
			type: "POST",
			data : {'typeofitems':ItemCategory,'result':'false'},
			//dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_str_stock_out_data_tabular",
			success: function(result)
			{
				jsondata=JSON.parse(result);
				for(var data in jsondata.data)
				{
					var stockoutrate=jsondata.data[data].stockout/jsondata.data[data].submitted;
					stockoutrate=stockoutrate.toFixed(2)*100;
					stockoutrate+="%";	
					htmlheader+='<tr><th>'+jsondata.data[data].name+'</th><td>'+stockoutrate+'</td></tr>';
				}
				$('#'+containerId).html('<table class="table table-bordered table-hover table-striped" style="padding-top: 0%; width: 100%; height: 100%; table-layout: fixed;" role="grid" width="100%" max-height="350px">'+htmlheader+'</table>');
			}
		});	
	}
	//tabular data for district wise sotck 
	function renderTableDistrictWise(containerId,arr_name)
	{
		var htmlheader="<tr><th colspan='2' style='text-align:center'>"+itemname+"</th></tr><tr><th>District Name</th><th>Vials/Pcs</th></tr>";
		for(var data in arr_name)
		{							
			htmlheader+='<tr><th>'+arr_name[data]['label']+'</th><td>'+arr_name[data]['value']+'</td></tr>';
		}
		$('#'+containerId).html('<table class="table table-bordered table-hover table-striped" style="padding-top: 0%; width: 100%; height: 100%; table-layout: fixed;" role="grid" width="100%" max-height="350px">'+htmlheader+'</table>');
	}
	$( ".charttype" ).click(function() {
		//district/facilities wise 
		var type=$('#text').attr('type');
		var charttype=$(this).attr('type');
		if(charttype=="tabular")
		{   
			if(type=="district")
				renderTableDistrictWise('chart-container4',districtWise);
			if(type=="facilities")
				renderTableDistrictWise('chart-container4',DistrictWiseFacility);
		}
		else{
			if(type=="district")
				getDistrictWise('5','BCG-20','Vaccine',charttype,'false');
			if(type=="facilities")
				getDistrictWiseFacility('5','BCG-20','1','Vaccine','1',charttype,'false');
		}  
	});
	$( ".stockouttype" ).click(function() {
		//district/facilities wise 
		//getDistrictWiseHFStockoutRate('5','BCG-20','Vaccine','column2d','false');   
	});		
	/**NEw hf stock out required chart */
	function loadvaccineHFRequired(chartType,ajax)
	{
		if(ajax=="true")
		{
			$.ajax({
				type: "POST",
				data : {'typeofitems':'vaccines','result':'false'},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_HF_stockOut_Rate_Requisition",
				success: function(result)
				{
					//alert(result);
					HFVaccineRequired=result;
					//console.log(result);

				}
			});
		}
		//code for chart
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:chartType,
				renderAt: "chart-container9",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource: HFVaccineRequired
			})
			.render();
		});
	}	
	function loadDilluentHFRequired(chartType,ajax)
	{
		if(ajax=="true")
		{
			$.ajax({
				type: "POST",
				data : {'typeofitems':'diluents','result':'false'},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_HF_stockOut_Rate_Requisition",
				success: function(result)
				{
					//alert(result);
					HFdilluentRequired=result;
					//console.log(result);

				}
			});
		}
		//code for chart
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:chartType,
				renderAt: "chart-container10",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource:HFdilluentRequired
			})
			.render();
		});
	}	
	function loadNonVaccineHFRequired(chartType,ajax)
	{
		if(ajax=="true")
		{
			$.ajax({
				type: "POST",
				data : {'typeofitems':'nonvaccines','result':'false'},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_HF_stockOut_Rate_Requisition",
				success: function(result)
				{
					//alert(result);
					HFNonVaccineRequired=result;
					//console.log(result);

				}
			});
		}
		//code for chart
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:chartType,
				renderAt: "chart-container12",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource:HFNonVaccineRequired
			})
			.render();
		});
	}
		//function for drillchart for HF stock out rate	Requisition district wise
	function getDistrictWiseHFStockoutRate_Requisition(itemid,agg_items_id,itemname,category_id,ajax,requisiton)
	{
		$('#chart-container11').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$('#HFRequisitiondrillchart').show();  
		if(category_id=="1")
		{
			$('#textnewreq').text('HF Stock out Rate '+requisiton+' Requisition  District Wise(Vaccine)');
		}
		if(category_id=="2")
		{
			$('#textnewreq').text('HF Stock out Rate  '+requisiton+' Requisition District  Wise(Non Vaccine)');
		}
		if(category_id=="3")
		{
			$('#textnewreq').text('HF Stock out Rate  '+requisiton+' Requisition District  Wise(Dilluent)');
		}
		if(ajax=="true")
		{     
			$.ajax({
				type: "POST", //columntype :district wise,tehsil wise etc
				data : {itemid:itemid,agg_items_id:agg_items_id,itemname:itemname,requisiton:requisiton,category_id:category_id},
				dataType: "JSON",
				async:false,
				url: "<?php echo base_url() ?>API/Provincial/get_stockout_Rate_Requisition_districts",
				success: function(result)
				{
					HfRequisitionStockOut=result;
					////console.log(HFstockout);
				}
			});
		}
		//chart 
		FusionCharts.ready(function() {
			var salesChart = new FusionCharts({
				type:'column2d',
				renderAt: "chart-container11",
				width: '100%',
				height: '350',
				dataFormat: 'json',
				dataSource: {
					"chart": {
					"caption": "HF Stock out Rate "+requisiton+" Requisition District Wise of "+itemname+"", 
						//"subCaption": statusName,
						"plottooltext": "Total  Stock out Rate Requisition at $label are <b>$dataValue</b>",
						"yaxisname": "Vials/Pcs",
						"linethickness": "2",
						"formatnumberscale": "1",
						"baseFont": "lato-regular",
						"slantlabels": "1",
						"labelDisplay": "rotate",
						"divLineAlpha": "40",
						"numberSuffix": "%",
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
					"data": HfRequisitionStockOut
				}
			})
			.render();
		});
		
	}
	////function for drillchart for HF stock out rate	Requisition facility wise 
	function getFacilityWiseHFStockoutRate_Requisition(itemid,agg_items_id,itemname,itemCategory,ajax,requisition,distcode,distname)
	{
		
		
		$('#HF_Fac_Requisitiondrillchart').show();
		$('#textnewreqhf').text('HF Stock out Rate Requisition Facility Wise');
		$.ajax({
			type: "POST", //columntype :district wise,tehsil wise etc
			data : {itemid:itemid,agg_items_id:agg_items_id,itemname:itemname,distcode:distcode,requisition:requisition},
			dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_stockout_Rate_Requisition_facility",
			success: function(result)
			{
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type:'column2d',
						renderAt: "chart-container13",
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "HF Stock out Rate "+requisition+" Requisition Facility  Wise of "+itemname+" ("+distname+")", 
								//"subCaption": statusName,
								"plottooltext": "Total  Stock out Rate Requisition at $label are <b>$dataValue</b>",
								"yaxisname": "Vials/Pcs",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"slantlabels": "1",
								"labelDisplay": "rotate",
								"divLineAlpha": "40",
								"numberSuffix": "%",
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
	function renderTableHFRequisition(containerId,ItemCategory) 
	{
		$('#'+containerId).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		var htmlheader='<tr><th>Items</th><th>Stock Out Greater Requisition</th><th>Stock Out Less Requisition</th></tr>';
		$.ajax({
			type: "POST",
			data : {'typeofitems':ItemCategory,'result':'false'},
			//dataType: "JSON",
			url: "<?php echo base_url() ?>API/Provincial/get_str_stock_out_requisition_data_tabular",
			success: function(result)
			{
				jsondata=JSON.parse(result);
				for(var data in jsondata.data)
				{
					var stockoutgreaterrate=jsondata.data[data].stockoutgreater/jsondata.data[data].submitted;
						stockoutgreaterrate=stockoutgreaterrate.toFixed(2)*100;
					stockoutgreaterrate+="%"
					var stockoutlessrate=jsondata.data[data].stockoutless/jsondata.data[data].submitted;
					stockoutlessrate=stockoutlessrate.toFixed(2)*100;
					stockoutlessrate+="%";	
					htmlheader+='<tr><th>'+jsondata.data[data].name+'</th><td>'+stockoutgreaterrate+'</td><td>'+stockoutlessrate+'</td></tr>';
				}
				$('#'+containerId).html('<table class="table table-bordered table-hover table-striped" style="padding-top: 0%; width: 100%; height: 100%; table-layout: fixed;" role="grid" width="100%" max-height="350px">'+htmlheader+'</table>');
			}
	});
	}
</script>	
		
	</div>
</div>		