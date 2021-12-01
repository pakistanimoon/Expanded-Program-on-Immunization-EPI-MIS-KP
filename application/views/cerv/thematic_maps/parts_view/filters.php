<?php 
	if($filter == 'OpenVialWastageRate'){ 
		if($dropout){
			$link = 'UtilizationOfServices';
		}
		else{
			$link = 'OpenVialWastageRate';
		}
		?>
	<form class="" method="post" action="<?php echo base_url(); ?>Cerv/thematic_maps/<?php echo $link; ?>">
		<?php
		if(isset($data)){
			$reportType = $data['reportType'];
			$vaccineId = $data['vaccineId'];
		}
		?> 
		
		<div class="form-group" id="vaccineDiv">
			<!-- <label class="form-group">Year Month From</label> -->
			<input type="text" name="yearmonth_from" id="yearmonth_from" class="form-control form-group dp-my" placeholder="Year Month From">
			<!-- <label class="form-group">Year Month To</label> -->
			<input type="text" name="yearmonth_to" id="yearmonth_to" class="form-control form-group dp-my" placeholder="Year Month To">
		<?php if(! $dropout){ ?>
			<!-- <label class="form-group">Vaccine</label> -->
			<select name="vaccineId" id="vaccineId" class="form-control form-group" required="required">
				<option <?php echo (isset($vaccineId) && $vaccineId == "1")?'selected="selected"':''; ?> value="1">BCG</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "2")?'selected="selected"':''; ?> value="2">Hep B-Birth</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "3")?'selected="selected"':''; ?> value="3">OPV</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "4")?'selected="selected"':''; ?> value="4">PENTA</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "5")?'selected="selected"':''; ?> value="5">Pneumococcal</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "6")?'selected="selected"':''; ?> value="6">IPV</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "7")?'selected="selected"':''; ?> value="7">Rota</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "8")?'selected="selected"':''; ?> value="8">Measles</option>
			</select>
		<?php } 
		else{ ?>
			<select name="vaccineId" id="vaccineId" class="form-control" required="required">
				<option <?php echo (isset($vaccineId) && $vaccineId == "9")?'selected="selected"':''; ?> value="9">Penta 1 - Penta 3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "18")?'selected="selected"':''; ?> value="18">Measles 1 - Measles 2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "2")?'selected="selected"':''; ?> value="2">TT 1 - TT 2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "16")?'selected="selected"':''; ?> value="16">Penta 1 - Measles 1</option>
			</select>
		<?php } ?>
		</div>
		<div class="filter_btn">
			<button type="submit" id="pre-btn" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>
<?php 
	if($filter == 'Coverage'){ 
		$link = 'CervCoverage';
		
		
		
	/* $month = (isset($data['yearmonth_from']))?$data['yearmonth_to']:'';
	//$year = (isset($data['year']))?$data['year']:'';
	$fmonth = $year.'-'.$month;
		
		$yearfrom = $data['yearmonth_from'];
		$yearto = $data['yearmonth_to'];
		
		//$date = "07/08/2015";
		//$date = explode('/', $date);
		$yearto = explode('-', $yearto);
		
		$year = $yearto[0];
		$day   = $yearto[1];
		$month  = $yearto[2];
	echo '<pre>'; print_r($month);exit; */
  
		
		
		?>
	<form class="" method="post" action="<?php echo base_url(); ?>Cerv/thematic_maps/<?php echo $link; ?>">
		<?php
		if(isset($data)){
			$reportType = $data['reportType'];
			$vaccineId = $data['vaccineId'];
		}
		
			$fmonthfrom = $data['yearmonth_from'];
		$monthfromarr = explode('-',$fmonthfrom);
		$monthfrom = $monthfromarr[1];
		$yearfrom = $monthfromarr[0];
		
		$fmonthto = $data['yearmonth_to'];
		$monthtoarr = explode('-',$fmonthto);
		$monthto = $monthtoarr[1];
		$yearto = $monthtoarr[0];
		
		
		$monthfrom = $yearfrom.'-'.$monthfrom;
		$monthto = $yearto.'-'.$monthto;
		
		?> 
		<div class="form-group" id="vaccineDiv">
			<input type="text" name="yearmonth_from" id="yearmonth_from" class="form-control form-group dp-my" placeholder="Year Month From" required="required" data-date-end-date='-1d' value="<?php echo (isset($monthfrom)?$monthfrom:'') ?>">
			<input type="text" name="yearmonth_to" id="yearmonth_to" class="form-control form-group dp-my" placeholder="Year Month To" required="required" data-date-end-date='-1d' value="<?php echo (isset($monthto)?$monthto:'') ?>">
			
			
			
			
			<select name="vaccineId" id="vaccineId" class="form-control form-group" required="required">
				<option <?php echo (isset($vaccineId) && $vaccineId == "1")?'selected="selected"':''; ?> value="1">BCG</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "2")?'selected="selected"':''; ?> value="2">Hep B-Birth</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "3")?'selected="selected"':''; ?> value="3">OPV-0</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "4")?'selected="selected"':''; ?> value="4">OPV-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "5")?'selected="selected"':''; ?> value="5">OPV-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "6")?'selected="selected"':''; ?> value="6">OPV-3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "7")?'selected="selected"':''; ?> value="7">PENTA-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "8")?'selected="selected"':''; ?> value="8">PENTA-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "9")?'selected="selected"':''; ?> value="9">PENTA-3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "10")?'selected="selected"':''; ?> value="10">PCV10-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "11")?'selected="selected"':''; ?> value="11">PCV10-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "12")?'selected="selected"':''; ?> value="12">PCV10-3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "13")?'selected="selected"':''; ?> value="13">IPV</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "14")?'selected="selected"':''; ?> value="14">Rota-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "15")?'selected="selected"':''; ?> value="15">Rota-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "16")?'selected="selected"':''; ?> value="16">Measles-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "17")?'selected="selected"':''; ?> value="17">Measles-2</option>
			</select>
		</div>
		<div class="filter_btn">
			<button type="submit" id="pre-btn" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>
<?php 
	if($filter == 'fully_immunized'){ 
		$link = 'FullyImmunizedCoverage';
		?>
	<form class="" method="post" action="<?php echo base_url(); ?>Cerv/thematic_maps/<?php echo $link; ?>">
		<?php 
		if(isset($data)){
			$reportType = $data['reportType'];
			$vaccineId = $data['vaccineId'];
		}
		?> 
		
		<div class="form-group" id="vaccineDiv">
			<input type="text" name="yearmonth_from" id="yearmonth_from" class="form-control form-group dp-my" placeholder="Year Month From">
			<input type="text" name="yearmonth_to" id="yearmonth_to" class="form-control form-group dp-my" placeholder="Year Month To">
		</div>
		<div class="filter_btn">
			<button type="submit" id="pre-btn" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>
</div><script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	$(document).on('change','#vaccineindicator',function(){
		var $indicatorId = $(this).val();
		$.ajax({
			type: "POST",
			data: {indicatorid:$indicatorId},
			url: "<?php echo base_url(); ?>thematic_maps/ThematicVaccineIndicator/getActiveVaccinesOptions",
			success: function(result){
				$('#vacc_ind').html(result);
			}
		}); 
	});
	$(document).on('change','#disease',function(){
		var $diseaseId = $(this).val();
		$.ajax({
			type: "POST",
			data: {diseaseId:$diseaseId},
			url: "<?php echo base_url(); ?>thematic_maps/ThematicCountEPID/getAllSpecimenResultsOptions",
			success: function(result){
				$('#investigationResult').html(result);
			}
		}); 
	});
	$(document).ready(function(){
		//$( "#from_week" ).trigger( "change" );
		var from_week = '<?php echo isset($from_week)?$from_week:'01' ?>';
		var to_week = '<?php echo isset($to_week)?$to_week:'01' ?>';
		if(from_week!=''){
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getEpiFromTOWeeks',
				data:'from_week='+from_week+'&to_week='+to_week+'&year='+year,
				success: function(response){
					$('#to_week').html(response);
					//$('#toweek').val('');
				}
			}); 
		}
	});
	$(document).on('change','#from_week',function(){
		var from_week= $("#from_week option:selected").val();
		var to_week = '<?php echo isset($to_week)?$to_week:'01' ?>';
		if(from_week!=''){
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getEpiFromTOWeeks',
				data:'from_week='+from_week+'&to_week='+to_week+'&year='+year,
				success: function(response){
					$('#to_week').html(response);
					$('#to_week').val('');
				}
			});
		}
	});
	$(".dp-my").datepicker({
		autoclose: true,
		format: "yyyy-mm",
		viewMode: "months", 
		minViewMode: "months",
		orientation: "top"
	});
	$("#yearmonth_from").datepicker({
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$('#yearmonth_to').datepicker('setStartDate', minDate);
	});
	$('#pre-btn').prop('disabled', true);
	$(document).on('change','.dp-my',function(){
		if(($('#yearmonth_to').val() !="" && $('#yearmonth_from').val() !="")){
			$('#pre-btn').prop('disabled', false);
		}else{
			$('#pre-btn').prop('disabled', true);
		}
	});
</script>