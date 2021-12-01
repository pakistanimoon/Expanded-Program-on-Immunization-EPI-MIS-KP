<br>
<?php echo $listing_filters; 
$currentYear = date('Y');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
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
				var week = $('#from_week').val();
				var year = $('#year').val();
				//alert(week);
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
					data:'epiweek='+week+'&year='+year,
					success: function(response){
						var obj = JSON.parse(response);
						$('#datefrom').val(obj.startDate);
						$('#dateto').val(obj.EndDate);//dateto
					}
				});				
			}
		});
	});
	$(document).ready(function(){
		if($('input[name=report_type]:checked').val() == "yearly"){
		$('#month').val('');
		$('#month').removeAttr('required','required');
	}
	else if($('input[name=report_type]:checked').val() == "monthly"){
		$('#month').attr('required','required');
	}else{}
		var dist = $("#distcode").val();
		if(dist>0)
			$('#typeWise').show();
		else
			$('#typeWise').hide();
		if($('#year option:last').val() == new Date().getFullYear()){
			$('#year option:last').prop('selected', true);
		}else{
			$('#year option:first').prop('selected', true);
		}
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week').html(response);
			}
		});
	});
	$(document).on('click','#report_type',function(){
		if($(this).val() == "yearly"){
			$('#month').hide();
			$('#month').val('');
			$('#month').removeAttr('required','required');
			$('#quarterly').hide();
			$('#quarterly').val('');
			$('#quarterly').removeAttr('required','required');		
		}else if($(this).val() == "quarterly"){
			$('#month').hide();
			$('#month').val('');
			$('#month').removeAttr('required','required'); 
			$('#quarterly').show();
			$('#quarterly').attr('required','required');
		}else if($(this).val() == "monthly"){
			$('#month').show();
			$('#month').attr('required','required');
			$('#quarterly').hide();
			$('#quarterly').val('');
			$('#quarterly').removeAttr('required','required');
			
		}else{}
	});
	$("#distcode").click(function(){
		var distcode = $("#distcode").val();
		if(distcode>0)
			$('#typeWise').show();
		else
			$('#typeWise').hide();
	});
	$(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				// $('#week').html(response);
				// $('#week_from').prop(0);
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
					}
				});
			}
		});
	});
	$(".dp-my").datepicker({
		autoclose: true,
		format: "mm-yyyy",
		viewMode: "months", 
		minViewMode: "months",
		orientation: "top"
	});
	$("#monthfrom").datepicker({
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$('#monthto').datepicker('setStartDate', minDate);
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
				//$('#week_to').val(obj.EndDate);
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
				$('#dateto').val(obj.EndDate);
			}
		});
	}); 
</script>