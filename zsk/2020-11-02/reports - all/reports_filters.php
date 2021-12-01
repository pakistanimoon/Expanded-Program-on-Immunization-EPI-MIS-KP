


<br>
	  
<?php echo $listing_filters; 
$currentYear = date('Y');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
  
		
	   	<?php if($this -> session -> UserLevel==4){ ?>
	    var tcode= <?php echo $this->session->Tehsil; ?>;
		$('#tcode').val(tcode);
		$('#tcode').trigger("change");
		<?php } ?>
  
									
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
		if(isExists('report_type')){
			$('#pre-btn').prop('disabled', true);
			$(document).on('change','#report_type',function(){
				if($('#report_type').val() !=0){
					$('#pre-btn').prop('disabled', false);
				}else{
					$('#pre-btn').prop('disabled', true);
				}
			});
		}
		function isExists(elemId){
			if($('#'+elemId).length > 0){
				return true;
			}else{
				return false;
			}
		}
		$("#case_type option[value='AWD/Chol<5']").remove();
		$("#case_type option[value='AWD/Chol>5']").remove();
		$("#case_type option[value='B Diar']").remove();
		$("#case_type option[value='HepB<5']").remove();
		
		if($('input[name=report_type]:checked').val() == "yearly"){
			$('#month').val('');
			$('#month').removeAttr('required','required');
			//$('#quarterDiv').hide();
			//$('#quarter').removeAttr('required','required');
		}
		else if($('input[name=report_type]:checked').val() == "monthly"){
			$('#month').attr('required','required');
			//$('#quarterDiv').hide();
			//$('#quarter').removeAttr('required','required');
		}else{}
		var dist = $("#distcode").val();
		if(dist>0)
			$('#typewise').show();
		else
			$('#typewise').hide();
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
		var dist = $("#distcode").val();
        var tco = $("#tcode").val();
		if(dist>0){
			$('#typeWise').show();
			$('#in_out_coverage_dist').show();
			$('#in_out_coverage_pro').hide();			
			$('#coverage_dist').removeAttr('disabled','disabled');
			$('#coverage_pro').attr('disabled','disabled');
		}else if(tco>0){
			$('#typeWise').show();
			$('#in_out_coverage_dist').show();
			$('#in_out_coverage_pro').hide();			
			$('#coverage_dist').removeAttr('disabled','disabled');
			$('#coverage_pro').attr('disabled','disabled');
		}
		else{
			$('#typeWise').hide();
			$('#in_out_coverage_dist').hide();
			$('#in_out_coverage_pro').show();
			$('#coverage_dist').attr('disabled','disabled');
			$('#coverage_pro').removeAttr('disabled','disabled');
		}
		

	});
	$("#distcode").click(function(){
		var distcode = $("#distcode").val();
		if(distcode>0){
			$('#typeWise').show();
			$('#in_out_coverage_dist').show();
			$('#in_out_coverage_pro').hide();
			$('#coverage_dist').removeAttr('disabled','disabled');
			$('#coverage_pro').attr('disabled','disabled');
		}
		else{
			$('#typeWise').hide();
			$('#in_out_coverage_dist').hide();
			$('#in_out_coverage_pro').show();
			$('#coverage_dist').attr('disabled','disabled');
			$('#coverage_pro').removeAttr('disabled','disabled');
		}
	});
	$(document).on('change','#distcode',function(){
		var distcode = $(this).val();
		if(distcode > 0){
			$('#acces_type').show();
			$('#coverage_dist option[value="in_uc"]').prop('selected', true);
		}
		else{
			$('#acces_type').hide();
			$('#coverage_pro option[value="in_district"]').prop('selected', true);
			//$('#coverage_pro option[value="total_districts"]').prop('selected', true);
		}
		
	});
	$(document).on('click','#report_type',function(){
		if($(this).val() == "yearly"){
			$("#month").closest('.form-group').hide();
			//$('#month').hide();
			$('#month').val('');
			$('#month').removeAttr('required','required');
			$('#quarterwise').hide();
			$('#quarterly').val('');
			$('#quarterly').removeAttr('required','required');		
		}else if($(this).val() == "quarterly"){
			$("#month").closest('.form-group').hide();
			//$('#month').hide();
			$('#month').val('');
			$('#month').removeAttr('required','required'); 
			$('#quarterwise').show();
			$('#quarterly').attr('required','required');
		}else if($(this).val() == "monthly"){
			$("#month").closest('.form-group').show();
			$('#month').show();
			$('#month').attr('required','required');
			$('#quarterwise').hide();
			$('#quarterly').val('');
			$('#quarterly').removeAttr('required','required');
			
		}else{}
	});	
	$("#distcode").click(function(){
		var distcode = $("#distcode").val();
		if(distcode>0)
			$('#typewise').show();
		else
			$('#typewise').hide();
	});
	$(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week').html(response);
			}
		});
	});
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
	$(document).on('change','#period_wisee',function(){
		if($(this).val() == "quarterly"){
			/* $('#year').removeClass('hide');	
			$('#year_label').removeClass('hide');	 */
			$('#year_div').removeClass('hide');
			$('#monthfrom').val('');
			$('#monthto').val('');
			$('#monthfrom').addClass('hide');
			$('#monthfrom').removeAttr('required','required'); 
			$('#monthto').addClass('hide');
			$('#monthto').removeAttr('required','required'); 
			$('#monthfrom-label').addClass('hide');
			$('#monthto-label').addClass('hide');
			$('#pre-btn').prop('disabled', false);
						
					
		}
		else {	
			/* $('#year').val('');
			$('#year').addClass('hide');
			$('#year_label').addClass('hide'); */
			//$('#year_div').addClass('hide');
			$('#monthfrom').removeClass('hide'); 
			$('#monthto').removeClass('hide');
			$('#monthfrom-label').removeClass('hide');
			$('#monthto-label').removeClass('hide');
			
			
		}
	});
</script>
		
	
	