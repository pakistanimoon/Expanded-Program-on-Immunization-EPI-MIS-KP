<div class="row bg-secondary" style="margin-left:0px; margin-right:0px;">
	<?php
	foreach($result as $key => $val){
		switch($val['type']){
			case 'select':
				?>
				<div class="col-md-4 <?php echo $val['id']; ?>-cd">
					<strong><?php echo $val['title']; ?></strong>
					<select class="form-control <?php echo $val['class']; ?>" <?php echo $val['other_attr']; ?> id="<?php echo $val['id']; ?>-cd" name="filter[]">
						<option value="">--Select--</option>
						<?php 
							if($val['db'] == 1){
								getDbFilterDefination(false,$val['pk_id'],$val['value_column'],$val['text_column']);
							}else{
								getCustomFilterDefination(false,$val['pk_id']); 
							} 
						?>
					</select>
				</div>
				<?php
				break;
			case 'text':
				?>
				<div class="col-md-4">
					<strong><?php echo $val['title']; ?></strong>
					<input type="hidden" name="inputfilter[<?php echo $key; ?>]" value="<?php echo $val['pk_id']; ?>">
					<input type="<?php echo $val['type']; ?>" <?php echo $val['other_attr']; ?> name="<?php echo $val['name']; ?>" id="<?php echo $val['id']; ?>" class="form-control <?php echo $val['class']; ?>">
				</div>
				<?php
				break;
		}
	}
	?>
</div>
<script type="text/javascript">
	$(".dp-my").datepicker({
		autoclose: true,
		format: "yyyy-mm",
		viewMode: "months",  
		minViewMode: "months",
		orientation: "top"
	});
	
	$("#monthfrom").datepicker({
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$('#monthto').datepicker('setStartDate', minDate);
		$('#monthto').datepicker('setEndDate', new Date());
	});
	$(document).on('change','#level-cd',function(){
		var $level = $('#level-cd option:selected').text().trim();
		if($level == 'Facility'){
			$('.distcode-cd').show();
			$('#distcode-cd').val('');
			$('.tcode-cd').show();
			$('#tcode-cd').val('');
			$('.uncode-cd').show();
			$('#uncode-cd').val('');
			$('.facode-cd').show();
			$('#facode-cd').val('');
		}
		if($level == 'Unioncouncil'){
			$('.facode-cd').hide();
			$('#facode-cd').val('');
			$('.uncode-cd').show();
			$('.tcode-cd').show();
			$('.distcode-cd').show();
		}
		if($level == 'Tehsil'){
			$('.uncode-cd').hide();
			$('#uncode-cd').val('');
			$('.facode-cd').hide();
			$('#facode-cd').val('');
			$('.tcode-cd').show();
			$('.distcode-cd').show();
		}
		if($level == 'District'){
			$('.tcode-cd').hide();
			$('#tcode-cd').val('');
			$('.uncode-cd').hide();
			$('#uncode-cd').val('');
			$('.facode-cd').hide();
			$('#facode-cd').val('');
			$('.distcode-cd').show();
		}
		if($level == 'Provincial'){
			$('.distcode-cd').hide();
			$('#distcode-cd').val('');
			$('.tcode-cd').hide();
			$('#tcode-cd').val('');
			$('.uncode-cd').hide();
			$('#uncode-cd').val('');
			$('.facode-cd').hide();
			$('#facode-cd').val('');
			$('.procode-cd').show();
		}
	});
	
</script>