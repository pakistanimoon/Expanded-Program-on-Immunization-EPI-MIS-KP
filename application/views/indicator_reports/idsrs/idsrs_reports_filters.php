<br>
<?php echo $listing_filters; ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#year option:last').prop('selected', true);
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getidsrsEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#from_week').html(response);
			}
		});
	});
	$('#distcode').on('change', function(){
		var distcode = this.value;
	//to get facilities of selected UC
		if(distcode =="") {
		  $('#facode').html('');
		  //it doesn't exist
		}else{
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
				success: function(result){
					$('#facode').html(result);
					
				}
			});
			
		}
	});
	$(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getidsrsEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#from_week').html(response);
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
				$('#toweek').val(obj.EndDate);
			}
		});
	}); 
	
</script>