<br>
<?php 
	echo $listing_filters; 
	$currentYear = date('Y');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
//////for Reprt type row on top ////////
		var reportType = $("#reportType").closest('.row').show();
	    $("#filter-form").prepend(reportType);
		
		var techniciancode = $("#techniciancode").closest('.row').show();
		$( techniciancode ).insertAfter("#facode" );
		$('#techniciancode').css({"margin-left": "15px","width":"306px","margin-top":"15px"});
		$('#techniciancode-label').css({"margin-top":"15px","margin-left":"-130px"});
	
	if( $('#reportType').length )  
		{ 

		$('#uncode').closest('.row').css('display', 'none');
		$('#uncode-label').closest('.row').css('display', 'none');
		$('#facode').closest('.row').css('display', 'none');
		$('#facode-label').closest('.row').css('display', 'none');
		$('#techniciancode').closest('.row').css('display', 'none');
		$('#techniciancode-label').closest('.row').css('display', 'none'); 

 }
////////END/////////
////////For filter show and hide/////////
		$(document).on('change','#reportType',function(){
			var reportType = $(this).val();
			if(reportType == 'uc'){
				$('#uncode').closest('.row').css('display', 'block');
				$('#uncode-label').closest('.row').css('display', 'block');
				$('#facode').closest('.row').css('display', 'none');
				$('#facode-label').closest('.row').css('display', 'none');
				$('#techniciancode').closest('.row').css('display', 'none');
				$('#techniciancode-label').closest('.row').css('display', 'none');
			}
			if(reportType == 'flcf'  ){
				$('#uncode').closest('.row').css('display', 'block');
				$('#uncode-label').closest('.row').css('display', 'block');
				$('#facode').closest('.row').css('display', 'block');
				$('#facode-label').closest('.row').css('display', 'block');
				$('#techniciancode').closest('.row').css('display', 'none');
				$('#techniciancode-label').closest('.row').css('display', 'none');
			}
			if(reportType == 'techniciancode' ){
				$('#uncode').closest('.row').css('display', 'block');
				$('#uncode-label').closest('.row').css('display', 'block');
				$('#facode').closest('.row').css('display', 'block');
				$('#facode-label').closest('.row').css('display', 'block');
				$('#techniciancode').closest('.row').css('display', 'block');
				$('#techniciancode-label').closest('.row').css('display', 'block');
			}
			/*else{
				$('#acces_type').hide();
				$('#coverage_pro option[value="in_district"]').prop('selected', true);
				//$('#coverage_pro option[value="total_districts"]').prop('selected', true);
			} */		
		});
		////////END/////////
		
		////////For data entry date filter show and hide/////////
		var reportType = $("#reporttype").closest('.row').show();
	    $("#filter-form").prepend(reportType);
		$(document).on('change','#reporttype',function(){
			var reportType = $(this).val();
			alert(reportType);
			if(reportType == '2'){
				//$('#datefrom').closest('.row').css('display', 'block');
				$('#datefrom').closest('.row').css('display', 'none');
				$('#datefrom').removeAttr('required','required');
				$('#datefrom').val(0);
			}else{
				$('#datefrom').closest('.row').css('display', 'block');
				$('#datefrom').attr('required','required');
				$('#datefrom').val('');
			}
		});
		////////END///////// 
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
	$(document).on('change','#facode',function(){
		var facode = $(this).val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getFacilityTechnicians',
			data:'facode='+facode,
			success: function(response){
				$('#techniciancode').html(response);
				$('#technician').html(response);
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
	// $("#monthfrom").datepicker({
	// }).on('changeDate', function (selected) {
	// 	var minDate = new Date(selected.date.valueOf());
	// 	$('#dateto').datepicker('setStartDate', minDate);
	// });
	$("#monthfrom").datepicker({
	}).on('changeDate', function (selected) {	
		var fromDate = new Date(selected.date.valueOf());
		$('#monthto').datepicker('setStartDate', fromDate);
	});
	// if((isExists('monthto') && isExists('monthfrom'))){
	// 	$('#pre-btn').prop('disabled', true);
	// 	$(document).on('change','.dp-my',function(){
	// 		if(($('#end_month').val() !="" && $('#start_month').val() !="")){
	// 			$('#pre-btn').prop('disabled', false);
	// 		}else{
	// 			$('#pre-btn').prop('disabled', true);
	// 		}
	// 	});
	// }
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

	$('document').ready(function(){
		//$('#year option:last').prop('selected', true);
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
						$('#dateto').val(obj.EndDate);
					}
				});				
			}
		});		
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
	$(document).on('change','#from_week',function(){
		var from_week = $(this).val();
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
			data:'epiweek='+from_week+'&year='+year,
			success: function(response){
				var obj = JSON.parse(response);
				$('#datefrom').val(obj.startDate);
				//$('#to_week').val(obj.EndDate);
			}
		});
	}); 
	$(document).on('change','#to_week',function(){
		var to_week = $(this).val();
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
			data:'epiweek='+to_week+'&year='+year,
			success: function(response){
				var obj = JSON.parse(response);
				//$('#from_week').val(obj.startDate);
				$('#dateto').val(obj.EndDate);
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

 	//------------------- Compliance ---------------------//
	year = $('#compliance_year').val();		
	var year = this.value;
	var curryear = (new Date).getFullYear();
	if(year < curryear){
		$data1 = "month=13";
	}
	else{
		$data1 = "";
	}
	$.ajax({
		type: "POST",
		data: $data1,
		url: '<?php echo base_url(); ?>Ajax_calls/getReportingMonths',
		success: function(result){
			$('#start_month').html(result);
			$('#end_month').html(result);
			$("#start_month").val($("#start_month option:first").val());
			$("#end_month").val($("#end_month option:last").val());
		}
	});
	
	$(document).on('change','#compliance_year', function(){		
		var year = this.value;
		var curryear = (new Date).getFullYear();
		if(year < curryear)
		{
			$data1 = "month=13";
		}
		else{
			$data1 = "";
		}
		$.ajax({
			type: "POST",
			data: $data1,
			url: '<?php echo base_url(); ?>Ajax_calls/getReportingMonths',
			success: function(result){
				$('#start_month').html(result);
				$('#end_month').html(result);
				$("#start_month").val($("#start_month option:first").val());
				$("#end_month").val($("#end_month option:last").val());
			}
		});
	});

</script>