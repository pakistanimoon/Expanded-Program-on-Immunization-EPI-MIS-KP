<br>
<?php echo $listing_filters; ?>
<script type="text/javascript">
	$('document').ready(function(){
		$('#year option:last').prop('selected', true);
		$('#specimen_result').val('');
		$('#specimen_result').addClass('hide');	
		$('#lab_result').addClass('hide');
		var case_type = $('#case_type').val();	
		//alert(case_type);	
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				//$('#week').html(response.trim());
				$('#week_from').html(response.trim());
				$('#week_to').html(response.trim());
				var week = $('#week_from').val();
				var year = $('#year').val();
				//alert(week);
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
		var measlesOptions = {
			'0' : '--Select--',
			// 'Positive Measles' : 'Confirmed Measles',
			// 'Negative Measles' : 'Negative',
			// 'Positive Rubella' : 'Confirmed Rubella',
			// 'Death' : 'Death Cases',
			'Positive Measles' : 'Positive Measles',
			'Positive Rubella' : 'Positive Rubella',
			'Negative Measles' : 'Negative',
			
			//'Negative Rubella' : 'Negative Rubella'
		};
		var otherOptions = {
			'0' : '--Select--',
			'Positive' : 'Positive',
			'Negative' : 'Negative'
		};
		var mySelect = $('#specimen_result');
		mySelect.html('');
		if(case_type == 'Msl'){
			$.each(measlesOptions, function(val, text) {
				mySelect.append(
					$('<option></option>').val(val).html(text)
				);
			});
		}
		else{
			$.each(otherOptions, function(val, text) {
				mySelect.append(
					$('<option></option>').val(val).html(text)
				);
			});
		}
		$('#specimen_result').val('0');
		$('#specimen_result').removeClass('hide');
		$('#lab_result').removeClass('hide');
	});
		
	$(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week_from').html(response.trim());
				$('#week_to').html(response.trim());
				$('#datefrom').val('');
				$('#dateto').val('');
				/* var week = $('#week').val();
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
				}); */
				
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
				if(response != 0){
					var obj = JSON.parse(response);
					$('#datefrom').val(obj.startDate);
					$('#dateto').val(obj.EndDate);
				}else{
					$('#datefrom').val('');
					$('#dateto').val('');
				}
			}
		});
	});
/* 	 $(document).on('change','#case_type',function(){
		var case_type = $(this).val();
		var specimen_result = $('#specimen_result').val();
		if(case_type != 'Msl'){
			$('#specimen_result').val('');
			$('#specimen_result').addClass('hide');	
			$('#lab_result').addClass('hide');			
		}
		else{
			$('#specimen_result').val('0');
			$('#specimen_result').removeClass('hide');
			$('#lab_result').removeClass('hide');	
		}		
	});  */
	
	
	
	$(document).on('change','#case_type',function(){
		var case_type = $(this).val();
		var cross_notified = $('#cross_notified').val();
		if(case_type == 'AEFI' ){
			$('#cross_notified').val('');
			$('#cross_notified').addClass('hide');	
			$('#cross_notify').addClass('hide');	
			$('#specimen_result').val('');
			$('#specimen_result').addClass('hide');	
			$('#lab_result').addClass('hide');				
		}
		else{
			$('#cross_notified').val('0');
			$('#cross_notified').removeClass('hide');
			$('#cross_notify').removeClass('hide');	
			$('#specimen_result').val('0');
			$('#specimen_result').removeClass('hide');
			$('#lab_result').removeClass('hide');	
		}		
	});
	$(document).on('change','#case_type',function(){
		var case_type = $(this).val();
		var otherOptions = {
			'0' : '--Select--',
			'Positive' : 'Positive',
			'Negative' : 'Negative'
		};
		var measlesOptions = {
			'0' : '--Select--',
			// 'Positive Measles' : 'Confirmed Measles',
			// 'Negative Measles' : 'Negative',
			// 'Positive Rubella' : 'Confirmed Rubella',
			// 'Death' : 'Death Cases',
			'Positive Measles' : 'Positive Measles',
			'Negative Measles' : 'Negative',
			'Positive Rubella' : 'Positive Rubella',
			//'Negative Rubella' : 'Negative Rubella'
		};
		var mySelect = $('#specimen_result');
		mySelect.html('');
		if(case_type == 'Msl'){
			$.each(measlesOptions, function(val, text) {
				mySelect.append(
					$('<option></option>').val(val).html(text)
				);
			});
		}
		else{
			$.each(otherOptions, function(val, text) {
				mySelect.append(
					$('<option></option>').val(val).html(text)
				);
			});
		}		
	}); 
	$(document).on('change','#week_from',function(){
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
	$(document).on('change','#week_to',function(){
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
 	$(document).on('change','#week_from',function(){
		var week_from = $("#week_from :selected").val();
		if(week_from!=''){
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getEpiFromTOWeeks',
				data:'from_week='+week_from+'&year='+year,
				success: function(response){
					$('#week_to').html(response);
				}
			});
		}
	});
	$(document).on('change','#case_type',function(){
		var case_type = $(this).val();
		if(case_type == 'NT' || case_type == 'AFP'){
			console.log('asd');	
			$('#specimen_result').val('');
			$('#specimen_result').addClass('hide');	
			$('#lab_result').addClass('hide');				
		}
		else{			
			$('#specimen_result').val('0');
			$('#specimen_result').removeClass('hide');
			$('#lab_result').removeClass('hide');	
		}		
	}); 
</script>