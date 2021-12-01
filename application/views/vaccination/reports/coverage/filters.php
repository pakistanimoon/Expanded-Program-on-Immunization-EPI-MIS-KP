<br>
<?php echo $listing_filters; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/bootstrap-multiselect.js" type="text/javascript"></script>
<link   href="<?php echo base_url(); ?>includes/css/bootstrap-multiselect.css" type="text/css" rel="stylesheet"/>
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
		function isExists(elemId){
			if($('#'+elemId).length > 0){
				return true;
			}else{
				return false;
			}
		}
		if(isExists('month')){
			$("#month").find("option:last").prop("selected", true);
		}		
		
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
		//just for some days commenting options
		$("#vaccinationType option[value='fixed']").remove();
		$("#vaccinationType option[value='outreach']").remove();
		$("#vaccinationType option[value='mobile']").remove();
		$("#vaccinationType option[value='lhw']").remove();
		$("#age_wise option[value='0to11']").remove();
		$("#age_wise option[value='12to23']").remove();
		$("#age_wise option[value='above2']").remove();
	});
</script>