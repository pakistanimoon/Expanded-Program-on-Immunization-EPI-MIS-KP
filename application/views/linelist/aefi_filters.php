<br>
<?php echo $listing_filters; ?>
<script type="text/javascript">
	
	$(document).ready(function(){
		$('#year option:last').prop('selected', true);
			var year = $('#year').val();
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
						}
					});
					
				}
			});
		document.getElementById("datefrom").readOnly   = true; 
		document.getElementById("dateto").readOnly  = true; 
		var year = $('#year').val();
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
						}
					});
			}
		});
	});
		////////// send module parameter  value to ajax_calls model getFacilities function//////
/* 		$(document).on('change','#uncode', function(){
		//var uncode = $(this).val();
		var module = "disease_surveillance";
		//alert(module);
	//to get facilities of selected UC
		if(uncode =="") {
		  $('#rb_facode').html('');
		  //it doesn't exist
		}else{
			$.ajax({
				type: "POST",
				data: "module="+module,
				url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
				success: function(result){
					//$('#facode').html(result);
					//set_hfcode();
				}
			});
			
		}
	}); */
	$(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week').html(response);
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
		$(document).on('change','#week',function(){
					var week = $(this).val();
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
		});
	/* $(document).on('change','#week',function(){
		var week = $(this).val();
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
	}); */
</script>