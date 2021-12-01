<div class="container bodycontainer">
	<div class="row cst-heading-row">
		<div class="col-lg-12 heading-cst-col mothly-wise-cerv-heading">
			<h3 class="heading-cst">Monthly UC wise Coverage (CERV)</h3>
		</div>
	</div>
	<div class="row cst-search-row">
		<div class="col-md-4 col-md-offset-4">
			<input type="text" id="vaccination-yearmonth" class="form-control dp-my" data-date-format="yyyy-mm" placeholder="Select Year-Month">
		</div>
		<div class="col-md-4">
			<button type="button" id="get-vaccination" onclick="getCoverage();" class="btn btn-succes">Submit</button>
		</div>
	</div>
	<div id="parent">
		<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th rowspan="2">S.No</th>
					<th rowspan="2">UC Code</th>
					<th rowspan="2">UC Name</th>
					<th colspan="3">New Born Target</th>
					<th colspan="3">Surviving Infants</th>
					<th colspan="6" style="min-width: 56px;">BCG</th>
					<th colspan="6">Hep B</th>
					<th colspan="6">OPV-0</th>
					<th colspan="6">OPV-1</th>
					<th colspan="6">OPV-2</th>
					<th colspan="6">OPV-3</th>
					<th colspan="6">Penta-1</th>
					<th colspan="6">Penta-2</th>
					<th colspan="6">Penta-3</th>
					<th colspan="6">PVC10-1</th>
					<th colspan="6">PVC10-2</th>
					<th colspan="6">PVC10-3</th>
					<th colspan="6">IPV</th>
					<th colspan="6">Rota-1</th>
					<th colspan="6">Rota-2</th>
					<th colspan="6">Measles-1</th>
					<th colspan="6">Measles-2</th>
				</tr>
				<tr>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">M</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">F</th>
					<th style="min-width:40px;">%</th>
					<th style="min-width:40px;">T</th>
					<th style="min-width:40px;">%</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($ucmonthlycoverage as $key => $val){
				?>
				<tr>
					<td class="text-bold"><?php echo $key+1; ?></td>
					<td class="text-bold"><?php echo $val['uncode']; ?></td>
					<td class="text-bold"><?php echo $val['unname']; ?></td>
					<td class="text-bold"><?php echo $val['mnewborntarget']; ?></td>
					<td class="text-bold"><?php echo $val['fnewborntarget']; ?></td>
					<td class="text-bold"><?php echo $val['tnewborntarget']; ?></td>
					<td class="text-bold"><?php echo $val['msurvivinginfantstarget']; ?></td>
					<td class="text-bold"><?php echo $val['fsurvivinginfantstarget']; ?></td>
					<td class="text-bold"><?php echo $val['tsurvivinginfantstarget']; ?></td>
					<td><?php echo $val['mbcg']; ?></td>
					<td><?php echo $val['mbcgperc']; ?></td>
					<td><?php echo $val['fbcg']; ?></td>
					<td><?php echo $val['fbcgperc']; ?></td>
					<td><?php echo $val['tbcg']; ?></td>
					<td><?php echo $val['tbcgperc']; ?></td>
					
					<td><?php echo $val['mhepb']; ?></td>
					<td><?php echo $val['mhepbperc']; ?></td>
					<td><?php echo $val['fhepb']; ?></td>
					<td><?php echo $val['fhepbperc']; ?></td>
					<td><?php echo $val['thepb']; ?></td>
					<td><?php echo $val['thepbperc']; ?></td>
					
					<td><?php echo $val['mopv0']; ?></td>
					<td><?php echo $val['mopv0perc']; ?></td>
					<td><?php echo $val['fopv0']; ?></td>
					<td><?php echo $val['fopv0perc']; ?></td>
					<td><?php echo $val['topv0']; ?></td>
					<td><?php echo $val['topv0perc']; ?></td>
					
					<td><?php echo $val['mopv1']; ?></td>
					<td><?php echo $val['mopv1perc']; ?></td>
					<td><?php echo $val['fopv1']; ?></td>
					<td><?php echo $val['fopv1perc']; ?></td>
					<td><?php echo $val['topv1']; ?></td>
					<td><?php echo $val['topv1perc']; ?></td>
					
					<td><?php echo $val['mopv2']; ?></td>
					<td><?php echo $val['mopv2perc']; ?></td>
					<td><?php echo $val['fopv2']; ?></td>
					<td><?php echo $val['fopv2perc']; ?></td>
					<td><?php echo $val['topv2']; ?></td>
					<td><?php echo $val['topv2perc']; ?></td>
					
					<td><?php echo $val['mopv3']; ?></td>
					<td><?php echo $val['mopv3perc']; ?></td>
					<td><?php echo $val['fopv3']; ?></td>
					<td><?php echo $val['fopv3perc']; ?></td>
					<td><?php echo $val['topv3']; ?></td>
					<td><?php echo $val['topv3perc']; ?></td>
					
					<td><?php echo $val['mpenta1']; ?></td>
					<td><?php echo $val['mpenta1perc']; ?></td>
					<td><?php echo $val['fpenta1']; ?></td>
					<td><?php echo $val['fpenta1perc']; ?></td>
					<td><?php echo $val['tpenta1']; ?></td>
					<td><?php echo $val['tpenta1perc']; ?></td>
					
					<td><?php echo $val['mpenta2']; ?></td>
					<td><?php echo $val['mpenta2perc']; ?></td>
					<td><?php echo $val['fpenta2']; ?></td>
					<td><?php echo $val['fpenta2perc']; ?></td>
					<td><?php echo $val['tpenta2']; ?></td>
					<td><?php echo $val['tpenta2perc']; ?></td>
					
					<td><?php echo $val['mpenta3']; ?></td>
					<td><?php echo $val['mpenta3perc']; ?></td>
					<td><?php echo $val['fpenta3']; ?></td>
					<td><?php echo $val['fpenta3perc']; ?></td>
					<td><?php echo $val['tpenta3']; ?></td>
					<td><?php echo $val['tpenta3perc']; ?></td>
					
					<td><?php echo $val['mpcv1']; ?></td>
					<td><?php echo $val['mpcv1perc']; ?></td>
					<td><?php echo $val['fpcv1']; ?></td>
					<td><?php echo $val['fpcv1perc']; ?></td>
					<td><?php echo $val['tpcv1']; ?></td>
					<td><?php echo $val['tpcv1perc']; ?></td>
					
					<td><?php echo $val['mpcv2']; ?></td>
					<td><?php echo $val['mpcv2perc']; ?></td>
					<td><?php echo $val['fpcv2']; ?></td>
					<td><?php echo $val['fpcv2perc']; ?></td>
					<td><?php echo $val['tpcv2']; ?></td>
					<td><?php echo $val['tpcv2perc']; ?></td>
					
					<td><?php echo $val['mpcv3']; ?></td>
					<td><?php echo $val['mpcv3perc']; ?></td>
					<td><?php echo $val['fpcv3']; ?></td>
					<td><?php echo $val['fpcv3perc']; ?></td>
					<td><?php echo $val['tpcv3']; ?></td>
					<td><?php echo $val['tpcv3perc']; ?></td>
					
					<td><?php echo $val['mipv']; ?></td>
					<td><?php echo $val['mipvperc']; ?></td>
					<td><?php echo $val['fipv']; ?></td>
					<td><?php echo $val['fipvperc']; ?></td>
					<td><?php echo $val['tipv']; ?></td>
					<td><?php echo $val['tipvperc']; ?></td>
					
					<td><?php echo $val['mrota1']; ?></td>
					<td><?php echo $val['mrota1perc']; ?></td>
					<td><?php echo $val['frota1']; ?></td>
					<td><?php echo $val['frota1perc']; ?></td>
					<td><?php echo $val['trota1']; ?></td>
					<td><?php echo $val['trota1perc']; ?></td>
					
					<td><?php echo $val['mrota2']; ?></td>
					<td><?php echo $val['mrota2perc']; ?></td>
					<td><?php echo $val['frota2']; ?></td>
					<td><?php echo $val['frota2perc']; ?></td>
					<td><?php echo $val['trota2']; ?></td>
					<td><?php echo $val['trota2perc']; ?></td>
					
					<td><?php echo $val['mmeasles1']; ?></td>
					<td><?php echo $val['mmeasles1perc']; ?></td>
					<td><?php echo $val['fmeasles1']; ?></td>
					<td><?php echo $val['fmeasles1perc']; ?></td>
					<td><?php echo $val['tmeasles1']; ?></td>
					<td><?php echo $val['tmeasles1perc']; ?></td>
					
					<td><?php echo $val['mmeasles2']; ?></td>
					<td><?php echo $val['mmeasles2perc']; ?></td>
					<td><?php echo $val['fmeasles2']; ?></td>
					<td><?php echo $val['fmeasles2perc']; ?></td>
					<td><?php echo $val['tmeasles2']; ?></td>
					<td><?php echo $val['tmeasles2perc']; ?></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<?php //print_r($ucmonthlycoverage); ?>
	</div>
</div>
<script type="text/javascript">
	function getCoverage(){
		var $vaccinationYearMonth = $('#vaccination-yearmonth').val();
		var base_url = '<?php echo base_url(); ?>';
		if($vaccinationYearMonth != ''){
			window.location.href = base_url+'Cerv/Dashboard/coverage?fmonth='+$vaccinationYearMonth;
		}else{
			alert('Please select a year month to proceed!');
		}
	}
	$(document).ready(function(){
		$(".dp-my").datepicker({
			autoclose: true,
			format: "yyyy-mm",
			viewMode: "months", 
			minViewMode: "months",
			orientation: "top"
		});
	});
</script>