<br>
<?php echo $listing_filters; 
$currentYear = date('Y');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){	
		var $dist =$("#distcode").val();
		if($dist == 0){
        $("select").children().first().remove();      	
		}
		
	});
	//$(document).ready(function(){
		/* if((isExists('monthto') && isExists('monthfrom'))){
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
				$('#week').html(response);
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
	}); */
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