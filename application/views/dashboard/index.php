<?php $UserLevel = $this -> session -> UserLevel;?>
<style type="text/css">
    g[class$='creditgroup'] {
         display:none !important;
    }
	#abc-custom{
		height: 365px;
		overflow: scroll;
	}
</style>
<div class="container">
	<div class="row row-tiles">
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 animated fadeInDown">
			<div class="panel panel-default">
				<td><label>Year</label>
					<select id="dashyear" name="year" class="form-control">
						<?php echo getAllYearsOptionsIncludingCurrent(false); ?>
					</select>
				</td>
			</div>
		</div>
	</div>
	</br>
	<div id='indicator'>
		<?php echo $this -> load -> view('dashboard/indicatorcards', $data, TRUE); ?>
	</div>
	<div class="row animated fadeInUp">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body" style="padding:0px;">
					<div class="row">
						<div class="col-sm-12">
							<!--<table class="table table-striped table-bordered districtable" style="margin-bottom: 0px;">
								<thead>
									<tr>
										<th>#</th>
										<th>District</th>
										<th>EPI Centers</th>
										<th>Supervisors</th>
										<th>EPI Technicians</th>
										<th>HF Incharges</th>
										<th>DSO's</th>
										<th>Computer Operator</th>
										<th>Drivers</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;$totFacilities=0;$totSupervisors=0;$totTechnicians=0;$totMedTechnicians=0;$totDsos=0;$totCos=0;$totDrivers=0;
									foreach($tableInfo as $row){ ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['district']; ?></td>
										<td><span class="badge blue"><?php echo $row['tot_facilities']; ?></span></td>
										<td><span class="badge green"><?php echo $row['tot_supervisors']; ?></span></td>
										<td><span class="badge megenta"><?php echo $row['tot_technicians']; ?></span></td>
										<td><span class="badge dark"><?php echo $row['tot_medtechnicians']; ?></span></td>
										<td><span class="badge red2"><?php echo $row['tot_dsos']; ?></span></td>
										<td><span class="badge purple"><?php echo $row['tot_cos']; ?></span></td>
										<td><span class="badge yellow"><?php echo $row['tot_drivers']; ?></span></td>
										<?php
										$totFacilities 		+= $row['tot_facilities'];
										$totSupervisors 	+= $row['tot_supervisors'];
										$totTechnicians 	+= $row['tot_technicians'];
										$totMedTechnicians 	+= $row['tot_medtechnicians'];
										$totDsos 			+= $row['tot_dsos'];
										$totCos 			+= $row['tot_cos'];
										$totDrivers 		+= $row['tot_drivers'];
										?>
									</tr>
									<?php $i++; } ?>
									<tr style="background: #0003;">
										<td colspan="2" style="text-align: right;font-weight: bold;">Total</td>
										<td><span class="badge blue"><?php echo $totFacilities; ?></span></td>
										<td><span class="badge green"><?php echo $totSupervisors; ?></span></td>
										<td><span class="badge megenta"><?php echo $totTechnicians; ?></span></td>
										<td><span class="badge dark"><?php echo $totMedTechnicians; ?></span></td>
										<td><span class="badge red2"><?php echo $totDsos; ?></span></td>
										<td><span class="badge purple"><?php echo $totCos; ?></span></td>
										<td><span class="badge yellow"><?php echo $totDrivers; ?></span></td>
									</tr>
								</tbody>
							</table>-->
							<!--------HR Summary Chart--------->
							<div class="row">
								<div class="col-md-6">
									<div class="section-title" style="padding: 0px 6px; line-height:30px;background: #09B769;color: white;font-size: 16px;padding: 6px;text-align: left;">
										<span>HR Summary</span>
										<div class="pull-right">
											<a href="javascript:void(1);" id="ws-hr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
												<span class="fa fa-table"></span>
											</a>
											<a href="javascript:void(1);" id="ws-hr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
												<span class="icon fa fa-pie-chart"></span>
											</a>
											<a href="javascript:void(1);" id="ws-hr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
												<span class="icon fa fa-bar-chart"></span>
											</a>
										</div>
									</div>
									<div id="ws-hr-trend">Your desire result will render here....</div>
								</div>
							<?php if($UserLevel == 2){?>	
								<div class="col-md-6">
									<div class="section-title" style="padding: 0px 6px; line-height:30px;background: #09B769;color: white;font-size: 16px;padding: 6px;text-align: left;">
										<span>All District HR Summary</span>
										<div class="pull-right">
											<a href="javascript:void(1);" id="store-ws-hr-table" style="color:#000000;font-size: 20px;" title="Graphical View (Table)">
												<span class="fa fa-table"></span>
											</a>
											<a href="javascript:void(1);" id="store-ws-hr-pie" style="color:#000000;font-size: 20px;" title="Graphical View (Pie chart)">
												<span class="icon fa fa-pie-chart"></span>
											</a>
											<a href="javascript:void(1);" id="store-ws-hr-bar" style="color:#000000;font-size: 20px;" title="Graphical View (Bar chart)">
												<span class="icon fa fa-bar-chart"></span>
											</a>
										</div>
									</div>
									<div id="store-ws-hr-trend"  data-stastid="" data-stname="">Your desire result will render here....</div>
								</div>
							<?php }?>	
							</div>
							<!----------------->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!--end of body container-->
	<script type="text/javascript" src="http://epibeta.pacemis.com/assets/fusioncharts/fusioncharts.js"></script>
	<script type="text/javascript" src="http://epibeta.pacemis.com/assets/fusioncharts/themes/fusioncharts.theme.fint.js"></script>
	<script type="text/javascript" src="http://epibeta.pacemis.com/assets/fusioncharts/themes/fusioncharts.theme.ocean.js"></script>
	<script type="text/javascript" src="http://epibeta.pacemis.com/assets/fusioncharts/themes/fusioncharts.theme.zune.js"></script>
	<script type="text/javascript" src="http://epibeta.pacemis.com/assets/fusioncharts/themes/fusioncharts.theme.carbon.js"></script>
<script type="text/javascript">
$(document).on('change','#dashyear',function(){
	$('#showForms').html('');
	var year=$(this).val();
	var data = {year:year,ajax:true};
	if(year!=0){
		$.ajax({
			type: "POST",
			data:data,
			async:true,
			dataType : 'json',
			url: "<?php echo base_url(); ?>dashboard/Main_page/index",
			success: function(result){
				$('#indicator').html(result.cards);
			}
		});
	}
});
////////chart for HR Summary////////////
	$("#ws-hr-pie").click(function(){
		loadRefgWsSection('doughnut2d');
	});
	$("#ws-hr-bar").click(function(){
		loadRefgWsSection('column2d'); 
	});
	$("#ws-hr-table").click(function(){
		loadRefgWsSection('a','table'); 
		//alert('12333');exit;
	});
	$("#ws-hr-bar").trigger("click");
	$("#store-ws-hr-bar").click(function(){
		var stastid = $('#store-ws-hr-trend').data("stastid");
		var stname = $('#store-ws-hr-trend').data('stname');
		wsCountgetData(stastid,stname,'store-ws-hr-trend','column2d');
		//alert(wsCountgetData);
	});
	$("#store-ws-hr-pie").click(function(){
		var stastid = $('#store-ws-hr-trend').data("stastid");
		var stname = $('#store-ws-hr-trend').data('stname');
		wsCountgetData(stastid,stname,'store-ws-hr-trend','doughnut2d'); 
	});
	$("#store-ws-hr-table").click(function(){
		var stastid = $('#store-ws-hr-trend').data("stastid");
		var stname = $('#store-ws-hr-trend').data('stname');
		wsCountgetData(stastid,stname,'store-ws-hr-trend','first','table')
		//alert('12333');
	});
	wsCountgetData('01','EPI Technician','store-ws-hr-trend','doughnut2d');
	//alert(wsCountgetData);
	//////working status code======================
	function loadRefgWsSection(type='column2d',table=null){
		// alert('naveed');
		$('#ws-hr-trend').html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$.ajax({
			type: "POST",
			data : {type:'abc',chartTypeid:table},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/Main_page/getAllHRData",
			success: function(result)
			{
				if(table)
				{
					equdataTable(result,'ws-hr-trend','HR Types','Available HR','350'); 
				}
				else{	
				FusionCharts.ready(function() {
					var salesChart = new FusionCharts({
						type: type,
						renderAt: 'ws-hr-trend',
						width: '100%',
						height: '350',
						dataFormat: 'json',
						dataSource: {
							"chart": {
								"caption": "HR Summary",
								//"subCaption": "Click on column/line/slice to drill down to Store wise information of respective Level",
								"plottooltext": "Total $label are <b>$dataValue</b>",
								"yaxisname": "Numbers",
								"linethickness": "2",
								"formatnumberscale": "1",
								"baseFont": "lato-regular",
								"divLineAlpha": "40",
								"anchoralpha": "0",
								"animation": "1",
								"legendborderalpha": "20",
								"drawCrossLine": "1",
								//"crossLineColor": "#0d0d0d",
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
	////
 	function wsCountgetData(type_id='01',statusName,renderAt='store-ws-hr-trend',chartType='column2d',table=null){
		$('#'+renderAt).html('<img src="<?php echo base_url(); ?>includes/images/ajax-loader_bluenn.gif"> loading...');
		$('#'+renderAt).data("stastid",type_id);
		//alert(type_id);
		$('#'+renderAt).data("stname",statusName);
		$.ajax({
			type: "POST",
			data : {type_id:type_id,chartTypeid:table},
			dataType: "JSON",
			url: "<?php echo base_url() ?>dashboard/Main_page/getAllHRDistrictData",
			success: function(result)
			{ 
				if(table)
					{ 
						equdataTable(result,renderAt,'Districts Name','Available HR','350',statusName); 
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
									"caption": "All Districts HR Summary",
									"subCaption": statusName,
									"plottooltext": "$label District in <b>$dataValue</b>",
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
									//"crossLineColor": "#0d0d0d",
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
						.render("store-ws-hr-trend");
					});
				}
			}
		});
    } 
	function equdataTable(dataArr,divId,col,col2,height="350",statusName=null){
		if(statusName)
			statusName = "<tr style='height: 42px; font-size: 12px;'><th colspan='2' class='text-center' >"+statusName+"</th></tr>";
		else
			statusName = "";
		if(divId=="store-ws-hr-trend"){
			var row = "<div id='abc-custom'><table class='table table-bordered table-hover table-striped footable table-vcenter tbl-listing dataTable no-footer max-height-350' data-filter='#filter' data-filter-text-only='true' style='padding-top: 0%; width: 100%; height: "+height+"px;' role='grid' aria-describedby='myTable_info'><thead>"+statusName+"<tr style='height: 42px; font-size: 12px;'><th class='text-center' ><span style='line-height: 3;'>"+col+"</span></th><th class='text-center' ><span style='line-height: 3;'>"+col2+"</span></th></tr></thead><tbody  class='table-wrapper-scroll-y my-custom-scrollbar' style='text-align:center;font-size: 12px;width: 166%;'></div>";
		}else{
			var row = "<table class='table table-bordered table-hover table-striped footable table-vcenter tbl-listing dataTable no-footer' data-filter='#filter' data-filter-text-only='true' style='padding-top: 0%; width: 100%; height: "+height+"px;' role='grid' aria-describedby='myTable_info'><thead>"+statusName+"<tr style='height: 42px; font-size: 12px;'><th class='text-center' ><span style='line-height: 3;'>"+col+"</span></th><th class='text-center' ><span style='line-height: 3;'>"+col2+"</span></th></tr></thead><tbody style='text-align:center;font-size: 12px;'>";
		}
		var url = "";
		if(jQuery.isEmptyObject(dataArr)){
			row = "<table  class='table table-bordered table-hover table-striped footable table-vcenter tbl-listing dataTable no-footer' data-filter='#filter' data-filter-text-only='true' style='padding-top: 0%; width: 100%; height: "+height+"px;' role='grid' aria-describedby='myTable_info'><thead></thead><tbody style='text-align:center;'>";
			row +="<tr><td></td><td style='padding-top: 166px;'>No data to display</td></tr>";
		}else{
			$.each( dataArr, function( key, valsec,a ) { //console.log(valsec['link']);
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
	function hrReportData(distcode,type){
		//var url = '<?php echo base_url(); ?>HR_Reports/HR_Summary_Report_Detail/'+distcode+'/'+type;
		 var listing_name='hr';
		 var status='Active';
		url = "<?php echo base_url();?>setup_listing/"+listing_name+"_listing?distcode="+distcode+"&status="+status+"&sup_type="+type;
		window.open(url, '_blank');
	}
	function hrReportData_tehsil(tcode,type){
		//var url = '<?php echo base_url(); ?>HR_Reports/HR_Summary_Report_Detail/'+distcode+'/'+type;
		 var listing_name='hr';
		 var status='Active';
		url = "<?php echo base_url();?>setup_listing/"+listing_name+"_listing?tcode="+tcode+"&status="+status+"&sup_type="+type;
		window.open(url, '_blank');
	}
</script>