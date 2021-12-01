<br>
<?php echo $listing_filters; ?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(($this -> session -> District)) { ?>
			$("#reporttype option[value='dwise']").remove();	
		<?php } else { ?>
			$("#reporttype option[value='fwise']").remove();
		<?php } ?>
		$(".dp-my").datepicker({
			autoclose: true,
			format: "yyyy-mm",
			startDate: '2016-01',
			viewMode: "months", 
			minViewMode: "months",
			endDate: new Date()
		});
		$(".mydate").datepicker({
			autoclose: true,
			format: "yyyy-mm-dd",
			startDate: '2016-01-01',
			endDate: new Date()
		});
		$("#monthfrom").datepicker({
		}).on('changeDate', function (selected) {
			var fromDate = new Date(selected.date.valueOf());
			var toDate = new Date($("#monthto").val());
			if(toDate < fromDate){
				$('#monthto').datepicker('setStartDate', fromDate);
				$("#monthto").val('');
			}
			else if(toDate.toString()  == 'Invalid Date' ){
				$('#monthto').datepicker('setStartDate', fromDate);
			}
		});
		if($('#year option:last').val() == new Date().getFullYear()){
			$('#year option:last').prop('selected', true);
		}else{
			$('#year option:first').prop('selected', true);
		}
		$('#year option:last').prop('selected', true);
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				//$('#week').html(response.trim());
				$('#from_week').html(response.trim());
				$('#to_week').html(response.trim());
				var week = $('#week').val();
				var year = $('#year').val();
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
					data:'epiweek='+week+'&year='+year,
					success: function(response){
						var obj = JSON.parse(response);
						$('#datefrom').val(obj.startDate);
						$('#dateto').val(obj.EndDate);
						$('#toweek').val(obj.EndDate);
						$('#datefrom').attr('readonly','readonly');
						$('#datefrom').attr('disabled','disabled');
						$('#dateto').attr('readonly','readonly');
						$('#dateto').attr('disabled','disabled');
					}
				});
			}
		});
		$(document).on('change','#year',function(){
			var year = $(this).val();
			if($('#reporttype').val() != 'mwise'){
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
					data:'year='+year,
					success: function(response){
						$('#week').html(response.trim());
						var week = $('#week').val();
						var year = $('#year').val();
						$.ajax({
							type: 'POST',
							url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
							data:'epiweek='+week+'&year='+year,
							success: function(response){
								var obj = JSON.parse(response);
								$('#datefrom').val(obj.startDate);
								$('#dateto').val(obj.EndDate);
								$('#toweek').val(obj.EndDate);
							}
						});
						
					}
				});
			}
		});
		$(document).on('change','#week',function(){
			var week = $(this).val();
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
				data:'epiweek='+week+'&year='+year,
				success: function(response){
					if(response != 0){
						var obj = JSON.parse(response);
						$('#datefrom').val(obj.startDate);
						$('#dateto').val(obj.EndDate);
						$('#toweek').val(obj.EndDate);
					}else{
						$('#datefrom').val('');
						$('#dateto').val('');
						$('#toweek').val('');
					}
				}
			});
		});
	});
	$(document).on('change','#distcode',function(){
		//alert("danish");
		var distcode = $('#distcode').val();
		if(distcode>0){
			$("#reporttype option[value='dwise']").remove();
			$("#reporttype option[value='fwise']").remove();
			$("#reporttype").append('<option value="fwise">Facility Wise</option>');
		}
		else{
			$("#reporttype").append('<option value="dwise">District Wise</option>');
			$("#reporttype option[value='fwise']").remove();
		}
	});
	$(document).on('change','#reporttype',function(){
		if($(this).val() == 'mwise'){
			$('#from_week-label').val('');
			$('#datefrom').val('');
			$('#from_week').val('');
			$('#to_week-label').val('');
			$('#to_week').val('');
			$('#toweek').val('');
			$('#from_week-label').addClass('hide');
			$('#datefrom').addClass('hide');
			$('#from_week').addClass('hide');
			$('#to_week-label').addClass('hide');
			$('#to_week').addClass('hide');
			$('#toweek').addClass('hide');
		}else{
			$('#from_week-label').removeClass('hide');
			$('#datefrom').removeClass('hide');
			$('#from_week').removeClass('hide');
			$('#to_week-label').removeClass('hide');
			$('#to_week').removeClass('hide');
			$('#toweek').removeClass('hide');
		}
	});
	$(document).on('change','#indicator',function(){
		if($(this).val() == 'vaccine wise'){
			$('#disease').addClass('hide');
			$('#disease-label').addClass('hide');
			
			
		}else{
			$('#disease').removeClass('hide');
			$('#disease-label').removeClass('hide');
			
		}
	});
	
	$(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#from_week').html(response.trim());
				$('#to_week').html(response.trim());
				$('#datefrom').val('');
				$('#dateto').val('');
				// $('#from_week').html(response);
				// $('#to_week').val('');
			}
		});
	});
	$(document).on('change','#from_week',function(){
		var from_week = $("#from_week :selected").val();
		if(from_week!=''){
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getEpiFromTOWeeks',
				data:'from_week='+from_week+'&year='+year,
				success: function(response){
					$('#to_week').html(response);
					$('#toweek').val('');
				}
			});
		}
	});
	
	$(document).on('change','#from_week',function(){
		var week_from = $(this).val();
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
			data:'epiweek='+week_from+'&year='+year,
			success: function(response){
				var obj = JSON.parse(response);
				$('#datefrom').val(obj.startDate);
				//$('#toweek').val(obj.EndDate);
			}
		});
	}); 
	$(document).on('change','#to_week',function(){
		var week_to = $(this).val();
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
			data:'epiweek='+week_to+'&year='+year,
			success: function(response){
				var obj = JSON.parse(response);
				//$('#week_from').val(obj.startDate);
				$('#toweek').val(obj.EndDate);
			}
		});
	}); 
	
</script>