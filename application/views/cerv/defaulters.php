<div class="container bodycontainer">
	<div class="row cst-heading-row">
		<div class="col-lg-12 heading-cst-col mothly-wise-cerv-heading">
			<h3 class="heading-cst">Defaulters till date (CERV)</h3>
		</div>
	</div>
	<div class="row cst-search-row">
		<div class="col-md-4 col-md-offset-4">
			<input type="text" id="defaulters-date" class="form-control dp-my" data-date-format="yyyy-mm-dd" placeholder="Select Date">
		</div>
		<div class="col-md-4">
			<button type="button" id="get-defaulters" onclick="getDefaulters();" class="btn btn-succes">Submit</button>
		</div>
	</div>
	<div class="row" style="margin:0px;">
		<table  class="table table-striped tableuc table-condensed footable table-vcenter tbl-consolidated-uc tbl-consolidated-uc-cerv row-border  order-column" data-filter="#filter" data-filter-text-only="true">
			<thead style="height:61px;">
				<tr style="background-color: #15681E;color: #FFF;">
					<th class="text-bold">S.No</th>
					<th class="text-bold">UC Code</th>
					<th class="text-bold">UC Name</th>
					<th class="text-rotate">OPV-1</th>
					<th class="text-rotate">Rota-1</th>
					<th class="text-rotate">PVC10-1</th>
					<th class="text-rotate">Penta-1</th>
					<th class="text-rotate">OPV-2</th>
					<th class="text-rotate">Rota-2</th>
					<th class="text-rotate">PVC10-2</th>
					<th class="text-rotate">Penta-2</th>
					<th class="text-rotate">OPV-3</th>
					<th class="text-rotate">IPV</th>
					<th class="text-rotate">PVC10-3</th>
					<th class="text-rotate">Penta-3</th>
					<th class="text-rotate">Measles-1</th>
					<th class="text-rotate">Measles-2</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($defaulters as $key => $val){
				?>
				<tr data-uncode="<?php echo $val['uncode']; ?>" class="defaulter-dd">
					<td class="text-bold"><?php echo $key+1; ?></td>
					<td class="text-bold"><?php echo $val['uncode']; ?></td>
					<td class="text-bold"><?php echo $val['unname']; ?></td>
					<td><?php echo $val['opv1']; ?></td>
					<td><?php echo $val['rota1']; ?></td>
					<td><?php echo $val['pcv1']; ?></td>
					<td><?php echo $val['penta1']; ?></td>
					<td><?php echo $val['opv2']; ?></td>
					<td><?php echo $val['rota2']; ?></td>
					<td><?php echo $val['pcv2']; ?></td>
					<td><?php echo $val['penta2']; ?></td>
					<td><?php echo $val['opv3']; ?></td>
					<td><?php echo $val['ipv']; ?></td>
					<td><?php echo $val['pcv3']; ?></td>
					<td><?php echo $val['penta3']; ?></td>
					<td><?php echo $val['measles1']; ?></td>
					<td><?php echo $val['measles2']; ?></td>
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
	var base_url = '<?php echo base_url(); ?>';
	$('.defaulter-dd').css('cursor','pointer');
	$(document).ready(function(){
		$(".dp-my").datepicker({
			autoclose: true,
			format: "yyyy-mm-dd",
			orientation: "top"
		});
	});
	function getDefaulters(){
		var $defaultersDate = $('#defaulters-date').val();
		if($defaultersDate != ''){
			window.location.href = base_url+'Cerv/Dashboard/defaulters?date='+$defaultersDate;
		}else{
			alert('Please select a date to proceed!');
		}
	}
	$(document).on('click','.defaulter-dd',function(){
		var $uncode = $(this).data('uncode');
		var $url = base_url + 'Reports/ChildRegistration?defaulters=1&uncode='+$uncode;
		window.location.href = $url;
	});
</script>