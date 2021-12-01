<div class="row">
	<div class="col-12 col-md-12">
		<table class="table table-bordered plan_table">
			<thead>
				<tr>
					<td>Sr #</td>
					<td>Merged Villages</td>
					<td>Total Population</td>
				</tr>
			</thead>
			<tbody>
				<?php 
				if( ! empty($villagesMerged)){
					foreach($villagesMerged as $key => $village){ ?>
					<tr class="<?php if(checkMergerGroupIdOccurance($village['merger_group_id']) > 1){ ?>danger<?php } ?>">
						<td><?php echo $key+1; ?></td>
						<td><?php echo $village['mergername']; ?></td>
						<td><?php echo $village['totalpopulation']; ?></td>
					</tr>
				<?php 
					}
				}else{ ?>
				<tr>
					<td colspan="3">Sorry no record found!</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<form id="mergerform">
	<span class="text-danger">Please Note : This will do one merger at one time!</span>
	<div class="row">
		<div class="col-12 col-md-12">
			<table class="table table-bordered plan_table">
				<thead>
					<tr>
						<td>Sr #</td>
						<td>Villages</td>
						<td>Population</td>
						<td>Year</td>
						<td>Check villages you want to merge for this microplan</td>
					</tr>
				</thead>
				<tbody>
					<?php
					if( ! empty($villagesToMerge)){
						foreach($villagesToMerge as $key => $village){ ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $village['village']; ?></td>
							<td><?php echo $village['population']; ?></td>
							<td><?php echo $village['year']; ?></td>
							<td>
								<input type="checkbox" name="vcode[<?php echo $key; ?>]" value="<?php echo $village['vcode']; ?>">
							</td>
						</tr>
					<?php 
						}
					}else{ ?>
					<tr>
						<td colspan="5">Sorry no record found!</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<input type="hidden" id="year" name="year" value="<?php echo $year; ?>">
			<input type="hidden" id="uncode" name="uncode" value="<?php echo $uncode; ?>">
		</div>
	</div>
	<div class="row">
		<div class="col-6 col-md-6"></div>
		<div class="col-6 col-md-6">
			<button type="submit" class="btn btn-success">Merge Villages</button>
			<button type="button" id="breakMerger1" onclick="myFunction()"  class="btn btn-danger breakMerger1">Break Merger</button>
		</div>
	</div>
</form>
<script type="text/javascript">

	$('#mergerform').submit(function(e){
		e.preventDefault();
		var len = $('input[type="checkbox"]:checked').length;
		if(len < 2){
			alert('Please check atleast two villages to merge!');
		}else{
			var confrm = confirm('This will merge selected villages and their populations for selected year! Do you want to continue?');
			if(confrm === true){
				var data = $(this).serialize();
				$.ajax({
					type: "POST",
					data: data,
					url: "<?php echo base_url(); ?>Ajax_red_rec/doVillagesMerger",
					success: function(result){
						$('#mergermodalbody').html(result);
						alert('Villages have been merged successfully!');
						$("#uncode").trigger("change");
					}
				});
			}
		}
	});
	function myFunction(){
		var uncode = $('#uncode').val();
		var year = $('#year').val();
		var confrm = confirm('Do you really want to break villages merger?');
		if(confrm){
			//alert(confrm);
			$.ajax({
				type: "POST",
				data: {uncode:uncode,year:year},
				url: "<?php echo base_url(); ?>Ajax_red_rec/breakVillagesMerger",
				success: function(result){
					$('#mergermodalbody').html(result);
					
				}
			});
		}
		$("#uncode").trigger("change");
	};
</script>
