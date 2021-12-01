<?php
$allmonths = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
?>
<div class="container-fluid">
	<?php /*<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered tbl-states">
				<thead>
					<tr>
					<?php 
					if(isset($services) && $services=="healthhouse")
					{
						$tittleServices = "Health House";
					}
					else
					{
						$tittleServices = ucfirst($services);
					}
					?>
						<td colspan="4" style="text-align: left;"><?php echo $tittleServices;?> Services <strong style="font-size:11px;"><?php echo $distYear ?></strong></td>
						<td colspan="2">
							<table style="width:100%;">
								<tr>
									<td><i class="fa fa-chevron-left" aria-hidden="true"></i></td>
									<td>Vaccine Coverage</td>
									<td><i class="fa fa-chevron-right" aria-hidden="true"></i></td>
								</tr>
							</table>
						</td>
					</tr>
				</thead>
				<tbody>
				<?php
				$servicesheld = $services."held";
				$servicesplanned = $services."planned";
				?>
					<tr>
						<td class="td-middle">
							<table class="table tbl-figures">
								<tbody>
									<tr><td class="s-bn c-green"><span class="span-digit"><?php echo ($sessionPlannedHeld->$servicesheld > 0)?$sessionPlannedHeld -> $servicesheld:0; ?></span>Session Conducted</td></tr>
									<tr><td class="c-orange"><span class="span-digit"><?php echo ($sessionPlannedHeld->$servicesplanned > 0)?$sessionPlannedHeld -> $servicesplanned:0; ?></span>Session Planned</td></tr>
								</tbody>
							</table>
						</td>
						<td class="td-middle text-center">
							<span class="span-pie-chart">
								<!--<div id="pie-first" class="svg-pie pie-teal2"></div>-->
								<div id="circle1">
									<strong class="stng-text"></strong>
									<span class="spn-text">% Conducted</span>
								</div>
							</span>
							<span class="span-pie-chart">
								<div id="circle2">
									<strong class="stng-text"></strong>
									<span class="spn-text">% Session Dropout</span>
								</div>
							</span>
						</td>
						<td class="td-middle">
							<table class="table tbl-figures">
								<tbody>
									<?php
									$servicesheld = "_{$services}_both";
									$childrenVaccinatedkey = $productsArray[$vaccineId].$servicesheld;
									$totalChildrenkey = $productsArray[$vaccineId].'_total_both';
									?>
									<!-- <tr><td class="s-bn c-indigo"><span class="span-digit"><?php //echo $totalVaccinationNumbers->$childrenVaccinatedkey; ?></span>Children Vaccinated</td></tr>
									<tr><td class="c-grey"><span class="span-digit"><?php //echo $totalVaccinationNumbers->$totalChildrenkey; ?></span>Total Target</td></tr> -->
									<tr><td class="s-bn c-indigo"><span class="span-digit"><?php echo ($totalVaccinationNumbers->$childrenVaccinatedkey!="")?$totalVaccinationNumbers->$childrenVaccinatedkey:"0"; ?></span>Children Vaccinated</td></tr>
									<tr><td class="c-grey"><span class="span-digit"><?php echo $monthly_yearly_target['totalTarget']; ?></span>Total Target</td></tr>
									<?php $percChildrenVaccinatedOnOutreach = (isset($monthly_yearly_target['totalTarget']) && $monthly_yearly_target['totalTarget'] >0)?round($totalVaccinationNumbers->$childrenVaccinatedkey*100/$monthly_yearly_target['totalTarget']):0; ?>
								</tbody>
							</table>
						</td>
						<td class="td-middle text-center">
							<span class="span-pie-chart">
								<div id="circle3">
									<strong class="stng-text"></strong>
									<span class="spn-text">% Children Vaccinated</span>
								</div>
							</span>
						</td>
						<td>
							<table class="table table-bordered tbl-figures-right s-bt0 s-bl0 s-br0">
								<tbody>
									<tr>
										<td class="s-bn">
											<table class="table tbl-figures">
												<?php 
													$services_male = "_{$services}_male";
													$services_female = "_{$services}_female";
													$maleVaccination = $productsArray[$vaccineId].$services_male;
													$femaleVaccination = $productsArray[$vaccineId].$services_female;
												?>
												<tr><td class="text-center sub-hea s-bt0 s-bl0"><?php echo $productsNameArray[$vaccineId]; ?> Monthly Coverage</td></tr>
												<tr><td class="s-bn c-red"><span class="span-digit1"><?php echo $monthly_yearly_target['totalTarget']; ?></span>Total Target</td></tr>
												<tr><td class="s-bn c-red"><span class="span-digit1"><?php echo $totalVaccinationNumbers->$childrenVaccinatedkey; ?></span>Total Vaccination</td></tr>
												<?php
												$totalTargetPercentage = (isset($monthly_yearly_target['totalTarget']) && $monthly_yearly_target['totalTarget'] >0)?round($totalVaccinationNumbers->$childrenVaccinatedkey*100/$monthly_yearly_target['totalTarget']):"";
												?>
												<tr><td class="c-green"><span class="span-digit1"><?php echo $monthly_yearly_target['totalMaleTarget']; ?></span>Male Target</td></tr>
												<tr><td class="c-green"><span class="span-digit1"><?php echo $totalVaccinationNumbersMale->$maleVaccination; ?></span>Male Vaccination</td></tr>
												<?php
												$maleTargetPercentage = (isset($monthly_yearly_target['totalMaleTarget']) && $monthly_yearly_target['totalMaleTarget'] >0)?round($totalVaccinationNumbersMale->$maleVaccination*100/$monthly_yearly_target['totalMaleTarget']):"";
												?>
												<tr><td class="c-grey"><span class="span-digit1"><?php echo $monthly_yearly_target['totalFemaleTarget']; ?></span>Female Target</td></tr>
												<tr><td class="c-grey"><span class="span-digit1"><?php echo $totalVaccinationNumbersFemale->$femaleVaccination; ?></span>Female Vaccination</td></tr>
												<?php
												$femaleTargetPercentage = (isset($monthly_yearly_target['totalFemaleTarget']) && $monthly_yearly_target['totalFemaleTarget'] >0)?round($totalVaccinationNumbersFemale->$femaleVaccination*100/$monthly_yearly_target['totalFemaleTarget']):"";
												?>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td class="td-middle s-bb0 s-bt0 text-center">
							<span class="span-pie-chart">
								<div id="circle4">
									<strong class="stng-text1"></strong>
									<span class="spn-text1">% Total Coverage</span>
								</div>
							</span>
							<span class="span-pie-chart">
								<div id="circle5">
									<strong class="stng-text1"></strong>
									<span class="spn-text1">% Male Coverage</span>
								</div>
							</span>
							<span class="span-pie-chart">
								<div id="circle6">
									<strong class="stng-text1"></strong>
									<span class="spn-text1">% Female Coverage</span>
								</div>
							</span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div><!--end of row-->*/?>
	<div class="section-title">
		<span>Monthly Stock <?php echo $indtitle; ?> Trends </span><strong style="font-size:11px;"><?php echo $year; ?></strong>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-6">
				<div id="summary-trend">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				<div id="summary-category-trend">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div class="section-title">
		<span>Current Available Stock Comparison </span>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-8">
				<div id="vacc_prod_curr_stock">Product wise current stock chart will render here...</div>
			</div>
			<div class="col-md-4">
				<div id="diluent_prod_curr_stock">Product wise current stock chart will render here...</div>
			</div>
		</div>
	</div>
	<div class="section-title">
		<span>Current Available Stock Comparison </span>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div id="non_vacc_prod_curr_stock">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<!--<div class="section-title">
		<span>Monthly Vaccination Coverage</span><strong style="font-size:11px;"><?php //echo $year ?></strong>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-6">
				<div id="summary-vaccination-coverage-fourth-graph1">Your desire result will render here....</div>
			</div>
			<div class="col-md-6">
				<div id="monthly-vaccination-TT">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<span>Sessions Dropout Rate </span><strong style="font-size:11px;"><?php //echo $year ?></strong>
				</div>
				<div id="sessions-dropout-grapgh1">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<span>Vaccine Dropout Rate </span><strong style="font-size:11px;"><?php //echo $year ?></strong>
				</div>
				<div id="dropout-grapgh-rate">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div class="section-title">
		<span>Monthly Vaccine Usage and Wastage Rates </span><strong style="font-size:11px;"><?php //echo $year ?></strong>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div id="monthly-summary-usage-wastage-rate-trend">Your desire result will render here....</div>
			</div>
		</div>
	</div>
	<div class="section-title">
		<span>Weekly VPDs Cases </span><strong style="font-size:11px;"><?php //echo $year ?></strong>
	</div>
	<div style="padding-top:10px">
		<div class="row">
			<div class="col-md-12">
				<div id="monthly-summary-surviellnace-rate-trend">Your desire result will render here....</div>
			</div>
		</div>
	</div>-->
</div>
<br>
<?php 
//$ConductedPerc = $services."ConductedPerc";
//$SessionDropout = $services."SessionDropout";
?>
<script type="text/javascript">
$(document).ready(function() {
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: 'msline',
			renderAt: 'summary-trend',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Activity Wise Monthly Stock <?php echo $indtitle; ?> Comparison",
					"subcaption": "<?php if(isset($year)){ echo 'Year '.$year; } ?><br><?php echo $store; ?>",
					"yaxisname": "Quantity",
					"linethickness": "2",
					//"numberPostfix": "/-",
					"formatnumberscale": "1",
					"baseFont": "lato-regular",
					//"labeldisplay": "ROTATE",
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
					"rotateValues" : "0",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					//"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"showBorder": "1"
					//"exportatclient": "1",
					//"exporthandler": "http://export.api3.fusioncharts.com",
					//"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
				"categories": [{
					"category":<?php echo '[{"label":\''.(implode("'},{\"label\":'",$allmonths)).'\'}]';?>				
				}],
				"dataset": [<?php  
					foreach($activities as $oneactivity){?>
						{
							"seriesname": '<?php echo $oneactivity; ?>',
							"data": [<?php echo json_encode($summary[$oneactivity]["monthly"]); ?>]
						},<?php 
					}?>
				]
			}
		})
		.render();
	});
	FusionCharts.ready(function() {
		var salesChart = new FusionCharts({
			type: 'msline',
			renderAt: 'summary-category-trend',
			width: '100%',
			height: '350',
			dataFormat: 'json',
			dataSource: {
				"chart": {
					"caption": "Category Wise Monthly Stock <?php echo $indtitle; ?> Comparison",
					"subcaption": "<?php if(isset($year)){ echo 'Year '.$year; } ?><br><?php echo $store; ?>",
					"yaxisname": "Quantity",
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
					"rotateValues" : "0",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"showBorder": "1"
				},
				"categories": [{
					"category":<?php echo '[{"label":\''.(implode("'},{\"label\":'",$allmonths)).'\'}]';?>				
				}],
				"dataset": [<?php  
					foreach($categories as $onecat){?>
						{
							"seriesname": '<?php echo $onecat; ?>',
							"data": [<?php echo json_encode($summary[$onecat]["monthly"]); ?>]
						},<?php 
					}?>
				]
			}
		})
		.render();
	});
	//onload
	$('#vacc_prod_curr_stock').html('<h1 class="center" style="margin-top:0px;"><img class="text-center" src="<?php echo base_url("includes/images/ajax-loader_blue.gif"); ?>"></h1>');
	$.ajax({
		type: "POST",
		dataType: "JSON",
		data: {warehouse_level:<?php echo $wh_type; ?>,warehouse_store:<?php echo $wh_code; ?>},
		url: "<?php echo base_url("inventory/charts/vacc_prod_curr_stock"); ?>",
		success: function(result)
		{
			//$('#vacc_prod_curr_stock').html(result);
			
			FusionCharts.ready(function() {
				new FusionCharts({
					type: 'column2d',
					renderAt: 'vacc_prod_curr_stock',
					width: '100%',
					height: '350',
					dataFormat: 'json',
					dataSource: {
						"chart": {
							"caption": "Product Wise (Vaccines) Current Available Stock",
							"subcaption": "<?php echo $store; ?>",
							"yaxisname": "Vials/Pieces",
							"xaxisname": "Products",
							"baseFont": "lato-regular",
							"rotatevalues": "1",
							"placevaluesinside": "1",
							//"valuefontcolor": "074868",
							"plotgradientcolor": "",
							"showcanvasborder": "1",
							//"numdivlines": "5",
							"showyaxisvalues": "1",
							//"palettecolors": "#1790E1",
							"canvasborderthickness": "1",
							"canvasbordercolor": "#074868",
							"canvasborderalpha": "30",
							"basefontcolor": "#074868",
							//"divlinecolor": "#074868",
							//"divlinealpha": "10",
							//"divlinedashed": "0",
							"theme": "zune",
							"valueFontColor": "#000000",
							"valueBgColor": "#FFFFFF",
							"valueBgAlpha": "50",
							"thousandSeparatorPosition": "3,3,3",
							//"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
							"useDataPlotColorForLabels": "1",                    
							"exportenabled": "1",
							"showBorder": "1",
							"useRoundEdges":"1"
							//"exportatclient": "1",
							//"exporthandler": "http://export.api3.fusioncharts.com",
							//"html5exporthandler": "http://export.api3.fusioncharts.com" 
						},
						"data": result
					}
				}).render();
			});
			
		}
	});
	$('#diluent_prod_curr_stock').html('<h1 class="center" style="margin-top:0px;"><img class="text-center" src="<?php echo base_url("includes/images/ajax-loader_blue.gif"); ?>"></h1>');
	$.ajax({
		type: "POST",
		dataType: "JSON",
		data: {warehouse_level:<?php echo $wh_type; ?>,warehouse_store:<?php echo $wh_code; ?>},
		url: "<?php echo base_url("inventory/charts/diluent_prod_curr_stock"); ?>",
		success: function(result)
		{
			//$('#diluent_prod_curr_stock').html(result);
			
			FusionCharts.ready(function() {
				new FusionCharts({
					type: 'column2d',
					renderAt: 'diluent_prod_curr_stock',
					width: '100%',
					height: '350',
					dataFormat: 'json',
					dataSource: {
						"chart": {
							"caption": "Product Wise (Diluents) Current Available Stock",
							"subcaption": "<?php echo $store; ?>",
							"yaxisname": "Vials/Pieces",
							"xaxisname": "Products",
							"baseFont": "lato-regular",
							"rotatevalues": "1",
							"placevaluesinside": "1",
							"plotgradientcolor": "",
							"showcanvasborder": "1",
							"showyaxisvalues": "1",
							"canvasborderthickness": "1",
							"canvasbordercolor": "#074868",
							"canvasborderalpha": "30",
							"basefontcolor": "#074868",
							"theme": "zune",
							"valueFontColor": "#000000",
							"valueBgColor": "#FFFFFF",
							"valueBgAlpha": "50",
							"thousandSeparatorPosition": "3,3,3",
							"useDataPlotColorForLabels": "1",                    
							"exportenabled": "1",
							"showBorder": "1",
							"useRoundEdges":"1"
						},
						"data": result
					}
				}).render();
			});
			
		}
	});
	$('#non_vacc_prod_curr_stock').html('<h1 class="center" style="margin-top:0px;"><img class="text-center" src="<?php echo base_url("includes/images/ajax-loader_blue.gif"); ?>"></h1>');
	$.ajax({
		type: "POST",
		dataType: "JSON",
		data: {warehouse_level:<?php echo $wh_type; ?>,warehouse_store:<?php echo $wh_code; ?>},
		url: "<?php echo base_url("inventory/charts/non_vacc_prod_curr_stock"); ?>",
		success: function(result)
		{
			//$('#non_vacc_prod_curr_stock').html(result);
			
			FusionCharts.ready(function() {
				new FusionCharts({
					type: 'column2d',
					renderAt: 'non_vacc_prod_curr_stock',
					width: '100%',
					height: '350',
					dataFormat: 'json',
					dataSource: {
						"chart": {
							"caption": "Product Wise (Non Vaccines) Current Available Stock",
							"subcaption": "<?php echo $store; ?>",
							"yaxisname": "Vials/Pieces",
							"xaxisname": "Products",
							"baseFont": "lato-regular",
							"rotatevalues": "1",
							"placevaluesinside": "1",
							"plotgradientcolor": "",
							"showcanvasborder": "1",
							"showyaxisvalues": "1",
							"canvasborderthickness": "1",
							"canvasbordercolor": "#074868",
							"canvasborderalpha": "30",
							"basefontcolor": "#074868",
							"theme": "zune",
							"valueFontColor": "#000000",
							"valueBgColor": "#FFFFFF",
							"valueBgAlpha": "50",
							"thousandSeparatorPosition": "3,3,3",
							"useDataPlotColorForLabels": "1",                    
							"exportenabled": "1",
							"showBorder": "1",
							"useRoundEdges":"1"
						},
						"data": result
					}
				}).render();
			});
			
		}
	});
});
</script>