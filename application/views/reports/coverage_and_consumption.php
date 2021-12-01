<div class="container bodycontainer">
	<?php
		//kp	
		//echo "<pre>"; print_r($result);exit;
		echo $data['TopInfo'];		
	?>
	<!--table for mentioning colour meaning-->
	<table data-filter="#filter" data-filter-text-only="true" style="margin-bottom: 5px;" class="table  table-hover table-striped footable table-vcenter tbl-listing footable-loaded">
		<!-- <thead>
			<tr style="background: white;color: black;">
				<th style="font-size: 20px; font-weight: bold;">Coverage & Consumption Report</th>
			</tr>				
		</thead> -->
	</table>	
	<!--table for mention colour mening-->	
	<div>
		<td>						
		</td>
	</div>
	<div id="parent" style="overflow:auto; width: 100%;">
		<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				<?php if(isset($facilitywise) AND $facilitywise == 'Yes'){ ?>
					<th rowspan="3">Facode</th>
					<th rowspan="3">Facility</th>
				<?php } else { ?>
					<th rowspan="3">Distcode</th>
					<th rowspan="3">District</th>
				<?php } ?>
					<th rowspan="3">Total Due Reports</th>
					<th rowspan="3">Coverage Submitted Reports</th>
					<th rowspan="3">Consumption Submitted Reports</th>
					<th colspan="3">BCG</th>
					<th colspan="3">Hep B</th>
					<th colspan="3">OPV</th>
					<th colspan="3">Pentavalent</th>
					<th colspan="3">PCV10</th>
					<th colspan="3">IPV</th>
					<th colspan="3">Rota</th>
					<th colspan="3">Measles</th>
					<!-- <th colspan="3">Fully Immunized</th>
					<th colspan="3">Measles 2</th> -->		
				</tr>
				<tr>
					<!-- <th rowspan="2">Doses</th> -->
					<th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th>
					<!-- <th rowspan="2">Doses</th> -->
					<th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th>
					<!-- <th rowspan="2">Doses</th> -->
					<th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th>
					<!-- <th rowspan="2">Doses</th> -->
					<th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th>
					<!-- <th rowspan="2">Doses</th> -->
					<th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th>
					<!-- <th rowspan="2">Doses</th> -->
					<th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th>
					<!-- <th rowspan="2">Doses</th> -->
					<th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th>
					<!-- <th rowspan="2">Doses</th> -->
					<th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th>
					<!-- <th rowspan="2">Doses</th> -->
					<!-- <th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th> -->
					<!-- <th rowspan="2">Doses</th> -->
					<!-- <th colspan="2">Children Vaccinated</th>
					<th rowspan="2">Difference</th> -->
				</tr>
				<tr>
					<th>Coverage</th>
					<th>Consumption</th>
					<th>Coverage</th>
					<th>Consumption</th>
					<th>Coverage</th>
					<th>Consumption</th>
					<th>Coverage</th>
					<th>Consumption</th>
					<th>Coverage</th>
					<th>Consumption</th>
					<th>Coverage</th>
					<th>Consumption</th>
					<th>Coverage</th>
					<th>Consumption</th>
					<th>Coverage</th>
					<th>Consumption</th>
					<!-- <th rowspan="2">Coverage</th>
					<th rowspan="2">Consumption</th>
					<th rowspan="2">Coverage</th>
					<th rowspan="2">Consumption</th> -->				
				</tr>
			</thead>
			<tbody id="tbody">  
				<?php
				$count =1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$total = array();
				if(!empty($data)){
					//print_r($result);
					//$priority=1;
				 	foreach($result as $val)
					{
						echo "<tr class='DrillDownRow addvalues'>";
						if(isset($val->facode)){
							echo "<td class='text-center'>".$val->facode."</td><td class='text-left'>";
							echo $val->fac_name;
							echo "<input type='hidden' value='". $val->facode ."' id='code'>";
						}
						else{
							echo "<td class='text-center'>".$val->distcode."</td><td class='text-left'>";
							echo $val->district;
							echo "<input type='hidden' value='". $val->distcode ."' id='code'>";
						}
						echo "</td>
							  <td class='text-center total_due_reports'>".$val->total_due_reports."</td>";
						echo "<td class='text-center coverage_submitted_reports'>".$val->coverage_submitted_reports."</td>";
						echo "<td class='text-center consumption_submitted_reports'>".$val->consumption_submitted_reports."</td>";

						echo "<td class='text-center bcg_from_coverage'>".$val->bcg_from_coverage."</td>";
						echo "<td class='text-center bcg_from_consumption'>".$val->bcg_from_consumption."</td>";
						echo "<td class='text-center bcg_difference'>".$val->bcg_difference."</td>";

						echo "<td class='text-center hepb_from_coverage'>".$val->hepb_from_coverage."</td>";
						echo "<td class='text-center hepb_from_consumption'>".$val->hepb_from_consumption."</td>";
						echo "<td class='text-center hepb_difference'>".$val->hepb_difference."</td>";

						echo "<td class='text-center opv_from_coverage'>".$val->opv_from_coverage."</td>";
						echo "<td class='text-center opv_from_consumption'>".$val->opv_from_consumption."</td>";
						echo "<td class='text-center opv_difference'>".$val->opv_difference."</td>";

						echo "<td class='text-center penta_from_coverage'>".$val->penta_from_coverage."</td>";
						echo "<td class='text-center penta_from_consumption'>".$val->penta_from_consumption."</td>";	
						echo "<td class='text-center penta_difference'>".$val->penta_difference."</td>";

						echo "<td class='text-center pcv10_from_coverage'>".$val->pcv10_from_coverage."</td>";
						echo "<td class='text-center pcv10_from_consumption'>".$val->pcv10_from_consumption."</td>";	
						echo "<td class='text-center pcv10_difference'>".$val->pcv10_difference."</td>";

						echo "<td class='text-center ipv_from_coverage'>".$val->ipv_from_coverage."</td>";
						echo "<td class='text-center ipv_from_consumption'>".$val->ipv_from_consumption."</td>";
						echo "<td class='text-center ipv_difference'>".$val->ipv_difference."</td>";

						echo "<td class='text-center rota_from_coverage'>".$val->rota_from_coverage."</td>";
						echo "<td class='text-center rota_from_consumption'>".$val->rota_from_consumption."</td>";
						echo "<td class='text-center rota_difference'>".$val->rota_difference."</td>";

						echo "<td class='text-center measles_from_coverage'>".$val->measles_from_coverage."</td>";
						echo "<td class='text-center measles_from_consumption'>".$val->measles_from_consumption."</td>";
						echo "<td class='text-center measles_difference'>".$val->measles_difference."</td>";

						// echo "<td class='text-center'>".$val->measles2_from_coverage."</td>";
						// echo "<td class='text-center'>".$val->measles2_from_consumption."</td>";
						// echo "<td class='text-center'>".$val->measles2_difference."</td>";

						echo "</tr>";					
					}
					if(isset($result))
					{
						echo "<tr class='DrillDownRow total' style='background: black;'>";
						echo "<td class='text-center' style='color: white;'></td>";
						echo "<td class='text-center' style='color: white;'>Total: </td>";
						//echo "<td class='text-center' style='color: white;'></td>";

						echo "<td class='text-center' id='total_due_reports' style='color: white;'></td>";
						echo "<td class='text-center' id='coverage_submitted_reports' style='color: white;'></td>";
						echo "<td class='text-center' id='consumption_submitted_reports' style='color: white;'></td>";

						echo "<td class='text-center' id='bcg_from_coverage' style='color: white;'></td>";
						echo "<td class='text-center' id='bcg_from_consumption' style='color: white;'></td>";
						echo "<td class='text-center' id='bcg_difference' style='color: white;'></td>";

						echo "<td class='text-center' id='hepb_from_coverage' style='color: white;'></td>";
						echo "<td class='text-center' id='hepb_from_consumption' style='color: white;'></td>";
						echo "<td class='text-center' id='hepb_difference' style='color: white;'></td>";

						echo "<td class='text-center' id='opv_from_coverage' style='color: white;'></td>";
						echo "<td class='text-center' id='opv_from_consumption' style='color: white;'></td>";
						echo "<td class='text-center' id='opv_difference' style='color: white;'></td>";

						echo "<td class='text-center' id='penta_from_coverage' style='color: white;'></td>";
						echo "<td class='text-center' id='penta_from_consumption' style='color: white;'></td>";	
						echo "<td class='text-center' id='penta_difference' style='color: white;'></td>";

						echo "<td class='text-center' id='pcv10_from_coverage' style='color: white;'></td>";
						echo "<td class='text-center' id='pcv10_from_consumption' style='color: white;'></td>";	
						echo "<td class='text-center' id='pcv10_difference' style='color: white;'></td>";

						echo "<td class='text-center' id='ipv_from_coverage' style='color: white;'></td>";
						echo "<td class='text-center' id='ipv_from_consumption' style='color: white;'></td>";
						echo "<td class='text-center' id='ipv_difference' style='color: white;'></td>";

						echo "<td class='text-center' id='rota_from_coverage' style='color: white;'></td>";
						echo "<td class='text-center' id='rota_from_consumption' style='color: white;'></td>";
						echo "<td class='text-center' id='rota_difference' style='color: white;'></td>";

						echo "<td class='text-center' id='measles_from_coverage' style='color: white;'></td>";
						echo "<td class='text-center' id='measles_from_consumption' style='color: white;'></td>";
						echo "<td class='text-center' id='measles_difference' style='color: white;'></td>";

						echo "</tr>";
					}
				}
				else{
					echo "<div><td colspan='6'>SORRY! Record does not exist</td></tr>";
				}
				?>
			</tbody>
		</table>
	</div>
</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<style>
	#parent {
		height: 400px;
	}
	#fixTable {
		width: 1800px !important;
	}
</style>
<script>
	$(document).ready(function() {
		//$("#fixTable").tableHeadFixer();
		$("#fixTable").tableHeadFixer({"left" : 5});
	}); 
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.DrillDownRow').css('cursor','pointer');
	});
  	$('.DrillDownRow').on('click', function(){
		var code = $(this).find("td:nth-child(2)").find('input[type=hidden]').val();
		var year = "<?php echo $year; ?>";
		var month = "<?php echo isset($month)?$month:''; ?>";
		//var type_wise = 'Unioncouncil';
		if(code.toString().length == 3){
			url = "<?php echo base_url();?>Coverage_consumption/coverage_and_consumption/"+code+"/"+year+"/"+month;
			var win = window.open(url);
			if(win){
				win.focus();
			}else{
				alert('Please allow popups for this site');
			}
		}		
	});

  	// Code for sum of each column
  	// for due reports
	var total_due_reports = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('total_due_reports');
	for(var i=0;i<tds.length;i++){
		total_due_reports += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#total_due_reports').html(total_due_reports);
	
	// for submitted coverage reports
	var coverage_submitted_reports = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('coverage_submitted_reports');
	for(var i=0;i<tds.length;i++){
		coverage_submitted_reports += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#coverage_submitted_reports').html(coverage_submitted_reports);

	// for submitted consumption reports
	var consumption_submitted_reports = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('consumption_submitted_reports');
	for(var i=0;i<tds.length;i++){
		consumption_submitted_reports += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#consumption_submitted_reports').html(consumption_submitted_reports);

	// for BCG
	var bcg_from_coverage = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('bcg_from_coverage');
	for(var i=0;i<tds.length;i++){
		bcg_from_coverage += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#bcg_from_coverage').html(bcg_from_coverage);

	var bcg_from_consumption = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('bcg_from_consumption');
	for(var i=0;i<tds.length;i++){
		bcg_from_consumption += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#bcg_from_consumption').html(bcg_from_consumption);

	var bcg_difference = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('bcg_difference');
	for(var i=0;i<tds.length;i++){
		bcg_difference += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#bcg_difference').html(bcg_difference);

	// for Hep-B
	var hepb_from_coverage = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('hepb_from_coverage');
	for(var i=0;i<tds.length;i++){
		hepb_from_coverage += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#hepb_from_coverage').html(hepb_from_coverage);

	var hepb_from_consumption = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('hepb_from_consumption');
	for(var i=0;i<tds.length;i++){
		hepb_from_consumption += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#hepb_from_consumption').html(hepb_from_consumption);

	var hepb_difference = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('hepb_difference');
	for(var i=0;i<tds.length;i++){
		hepb_difference += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#hepb_difference').html(hepb_difference);

	// for OPV
	var opv_from_coverage = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('opv_from_coverage');
	for(var i=0;i<tds.length;i++){
		opv_from_coverage += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#opv_from_coverage').html(opv_from_coverage);

	var opv_from_consumption = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('opv_from_consumption');
	for(var i=0;i<tds.length;i++){
		opv_from_consumption += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#opv_from_consumption').html(opv_from_consumption);

	var opv_difference = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('opv_difference');
	for(var i=0;i<tds.length;i++){
		opv_difference += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#opv_difference').html(opv_difference);

	// for Penta
	var penta_from_coverage = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('penta_from_coverage');
	for(var i=0;i<tds.length;i++){
		penta_from_coverage += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#penta_from_coverage').html(penta_from_coverage);

	var penta_from_consumption = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('penta_from_consumption');
	for(var i=0;i<tds.length;i++){
		penta_from_consumption += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#penta_from_consumption').html(penta_from_consumption);

	var penta_difference = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('penta_difference');
	for(var i=0;i<tds.length;i++){
		penta_difference += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#penta_difference').html(penta_difference);

	// for PCV10
	var pcv10_from_coverage = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('pcv10_from_coverage');
	for(var i=0;i<tds.length;i++){
		pcv10_from_coverage += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#pcv10_from_coverage').html(pcv10_from_coverage);

	var pcv10_from_consumption = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('pcv10_from_consumption');
	for(var i=0;i<tds.length;i++){
		pcv10_from_consumption += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#pcv10_from_consumption').html(pcv10_from_consumption);

	var pcv10_difference = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('pcv10_difference');
	for(var i=0;i<tds.length;i++){
		pcv10_difference += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#pcv10_difference').html(pcv10_difference);

	// for IPV
	var ipv_from_coverage = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('ipv_from_coverage');
	for(var i=0;i<tds.length;i++){
		ipv_from_coverage += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#ipv_from_coverage').html(ipv_from_coverage);

	var ipv_from_consumption = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('ipv_from_consumption');
	for(var i=0;i<tds.length;i++){
		ipv_from_consumption += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#ipv_from_consumption').html(ipv_from_consumption);

	var ipv_difference = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('ipv_difference');
	for(var i=0;i<tds.length;i++){
		ipv_difference += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#ipv_difference').html(ipv_difference);

	// for Rota
	var rota_from_coverage = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('rota_from_coverage');
	for(var i=0;i<tds.length;i++){
		rota_from_coverage += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#rota_from_coverage').html(rota_from_coverage);

	var rota_from_consumption = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('rota_from_consumption');
	for(var i=0;i<tds.length;i++){
		rota_from_consumption += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#rota_from_consumption').html(rota_from_consumption);

	var rota_difference = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('rota_difference');
	for(var i=0;i<tds.length;i++){
		rota_difference += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#rota_difference').html(rota_difference);

	// for Measles
	var measles_from_coverage = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('measles_from_coverage');
	for(var i=0;i<tds.length;i++){
		measles_from_coverage += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#measles_from_coverage').html(measles_from_coverage);

	var measles_from_consumption = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('measles_from_consumption');
	for(var i=0;i<tds.length;i++){
		measles_from_consumption += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#measles_from_consumption').html(measles_from_consumption);

	var measles_difference = 0;
	var table = document.getElementById("fixTable");
	var ths = table.getElementsByTagName('th');
	var tds = table.getElementsByClassName('measles_difference');
	for(var i=0;i<tds.length;i++){
		measles_difference += isNaN(tds[i].innerText)?0:parseInt(tds[i].innerText);
	}
	$('#measles_difference').html(measles_difference);
	
</script>