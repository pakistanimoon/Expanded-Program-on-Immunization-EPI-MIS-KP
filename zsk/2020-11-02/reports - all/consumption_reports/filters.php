<br>
<?php echo $listing_filters; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/bootstrap-multiselect.js" type="text/javascript"></script>
<link   href="<?php echo base_url(); ?>includes/css/bootstrap-multiselect.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">

	$(document).ready(function(){
		$('#procode option[value=0]').val('');
$('#procode').attr('required','required');
	   /*  <?php if($this -> session -> UserLevel==4){ ?>
	    var tcode= <?php echo $this->session->Tehsil; ?>;
		$('#tcode').val(tcode);
		$('#tcode').trigger("change");
		<?php } ?>
		 */
		if((isExists('monthto') && isExists('monthfrom'))){
			$('#pre-btn').prop('disabled', true);
			$(document).on('change','.dp-my',function(){
				if(($('#monthto').val() !="" && $('#monthfrom').val() !="")){
					$('#pre-btn').prop('disabled', false);
				}else{
					$('#pre-btn').prop('disabled', true);
				}
			});
		}
		/* if(isExists('report_type')){
			$('#pre-btn').prop('disabled', true);
			$(document).on('change','#report_type',function(){
				if($('#report_type').val() !=0){
					$('#pre-btn').prop('disabled', false);
				}else{
					$('#pre-btn').prop('disabled', true);
				}
			});
		} */
		function isExists(elemId){
			if($('#'+elemId).length > 0){
				return true;
			}else{
				return false;
			}
		}
		
		/* if($('#year option:last').val() == new Date().getFullYear()){
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
		}); */
		/* $(document).on('change','#reportPeriodnew',function(){
			var selectedType = $(this).val();
			if(selectedType == 'district'){
				$('#tcode-label').parent().parent().addClass('hide');
				$('#tcode option:first').prop('selected', true);
				$('#uncode-label').parent().parent().addClass('hide');
				$('#uncode option:first').prop('selected', true);
				$('#facode-label').parent().parent().addClass('hide');
				$('#facode option:first').prop('selected', true);
			}
			else if(selectedType == 'tehsil'){
				$('#uncode-label').parent().parent().addClass('hide');
				$('#uncode option:first').prop('selected', true);
				$('#facode-label').parent().parent().addClass('hide');
				$('#facode option:first').prop('selected', true);
				$('#tcode-label').parent().parent().removeClass('hide');
			}
			else if(selectedType == 'uc'){
				$('#facode-label').parent().parent().addClass('hide');
				$('#facode option:first').prop('selected', true);
				$('#tcode-label').parent().parent().removeClass('hide');
				$('#uncode-label').parent().parent().removeClass('hide');
			}
			else{
				$('#tcode-label').parent().parent().removeClass('hide');
				$('#uncode-label').parent().parent().removeClass('hide');
				$('#facode-label').parent().parent().removeClass('hide');
			}
		}); */
	});
	/* $(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week').html(response);
			}
		});
	}); */
	/* $(document).on('change','#from_week',function(){
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
	});  */
	/* $(document).on('change','#to_week',function(){
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
	}); */
	$(".dp-my").datepicker({
		autoclose: true,
		format: "yyyy-mm",
		startDate: '2016-01',
		viewMode: "months", 
		minViewMode: "months",
	});	
	$("#monthfrom").datepicker({
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$('#monthto').datepicker('setStartDate', minDate);
	});
	$(document).on('change','#procode',function()
	{
		var segment='<?php echo $this->uri->segment(3);?>';
		if(segment=='Indicator'){
		var procode = $(this).val();
		if(procode > 0 ){
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getIndicator_options',
			data:'procode='+procode,
			success: function(response){
				var obj = JSON.parse(response);
				$('#indicator').empty();
				$('#indicator').append(obj);
				//$('#week_to').val(obj.EndDate);
			}
		});
		//for vaccines 
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getRegVaccines_options',
			data:'procode='+procode,
			success: function(response){
				var obj = JSON.parse(response);
				$('#vacc_ind').empty();
			if(obj.msg=='master'){	//new consumption mech
				if (document.contains(document.getElementById("StockoutRate"))) {
				document.getElementById("StockoutRate").remove();
				}
						$( 
					'<div class="row" id="StockoutRate">'+
						'<div class="form-group">'+
							'<label class="col-xs-3 control-label" for = "vacc_ind" >Select Vaccine</label>'+
							'<div class="col-xs-7">'+
								'<select class="form-control" name="vacc_ind[]" id="vacc_ind" multiple="multiple">'+
									obj.res+
								'</select>'+
							'</div>'+
						'</div>'+
					'</div>' 
				).insertBefore(
					$('.content-wrapper').find('section').find('.row').find('.row:last')
				);
				$("#vacc_ind").multiselect('destroy');
				document.getElementById("vacc_ind").setAttribute("multiple", "multiple"); 
				$('#vacc_ind').multiselect({
					includeSelectAllOption: true,
					buttonClass: 'form-control',
					buttonWidth: '311px',
					enableFiltering: true,
					maxHeight: 118   
				});
				$('#vacc_ind').multiselect('rebuild');
						
						//$('#vacc_ind').append(obj);
						//$('#week_to').val(obj.EndDate);
			}
			//older consumption form_b_cr
			 else
			 {
				if (document.contains(document.getElementById("StockoutRate"))) {
				document.getElementById("StockoutRate").remove();
				}
				$('#vacc_ind').empty();
				 $( 
					'<div class="row" id="StockoutRate">'+
						'<div class="form-group">'+
							'<label class="col-xs-3 control-label" for = "vacc_ind" >Select Vaccine</label>'+
							'<div class="col-xs-7">'+
								'<select class="form-control" name="vacc_ind" id="vacc_ind" ><option value="all_vacc">Select All</option>'+
									obj.res+
								'</select>'+
							'</div>'+
						'</div>'+
					'</div>' 
				).insertBefore(
					$('.content-wrapper').find('section').find('.row').find('.row:last')
				);
			 }	
		}	
		});
		}
		//on base of province vaccine show otherwise no
		else
		{
			if (document.contains(document.getElementById("StockoutRate"))) {
				document.getElementById("StockoutRate").remove();
				}
		}
	}	
});
/* 	$(document).on('change','#indicator',function(){
		if (document.contains(document.getElementById("StockoutRate"))) {
			document.getElementById("StockoutRate").remove();
		}
		$( 
			'<div class="row" id="StockoutRate">'+
				'<div class="form-group">'+
					'<label class="col-xs-3 control-label" for = "vacc_ind" >Select Vaccine</label>'+
					'<div class="col-xs-7">'+
						'<select class="form-control" name="vacc_ind[]" id="vacc_ind" multiple="multiple">'+
							'<?php echo getVaccines_options(true,1,FALSE,array(1)); ?>'+
						'</select>'+
					'</div>'+
				'</div>'+
			'</div>' 
		).insertBefore(
			$('.content-wrapper').find('section').find('.row').find('.row:last')
		);
		$("#vacc_ind").multiselect('destroy');
		document.getElementById("vacc_ind").setAttribute("multiple", "multiple"); 
		$('#vacc_ind').multiselect({
			includeSelectAllOption: true,
			buttonClass: 'form-control',
			buttonWidth: '311px',
			enableFiltering: true,
			maxHeight: 118   
		});
		$('#vacc_ind').multiselect('rebuild');
	}); */
	//$("#indicator").trigger("change");
</script>