<br>
<?php echo $listing_filters; ?>
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
		
		if($('#year option:last').val() == new Date().getFullYear()){
			$('#year option:last').prop('selected', true);
		}else{
			$('#year option:first').prop('selected', true);
		}
		<?php if($this->uri->segment(3)=="Vaccine"){ ?>
			//var index = $('#month').get(2).selectedIndex;
			//$('#month option:eq(' + index + ')').remove();
		<?php } ?>
		//alert(month);
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week').html(response);
			}
		});
		$(document).on('change','#reportPeriodnew',function(){
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
		});
		if($('#indicator option:last').val() == '63'){
			$('#indicator option:last').prop('hidden', true);
		}
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
	/*$(document).on('change','#indicator',function(){
		var indicator = $(this).val();
		var month = $('#month').val();
		alert(month);
		if(indicator == '52' || indicator == '31'){
			if(month == '0'){
				alert('Please select Month for this Indicator');
				$('#indicator').val('');
				$('#StockoutRate').val('');
				document.getElementById('StockoutRate').style.display = 'none';
			}
			
		}
	}*/

	<?php if($this->uri->segment(3)=="Vaccine"){ ?>
		$(document).on('change','#indicator',function(){
			var indicator = $(this).val();
			if(indicator == '52' || indicator == '53' || indicator == '54' || indicator == '55'){
				if (document.contains(document.getElementById("StockoutRate"))) {
					document.getElementById("StockoutRate").remove();
				} 
				$( '<div class="row" id="StockoutRate"><div class="form-group"><label class="col-xs-3 col-xs-offset-1 control-label" for = "vacc_ind" >Select Vaccine</label><div class="col-xs-7"><select class="form-control" name="vacc_ind" id="vacc_ind"><option value="all_vacc">All Vaccines</option><option value="cr_r1_f6">BCG</option><option value="cr_r2_f6">DIL BCG</option><option value="cr_r3_f6">bOPV</option><option value="cr_r4_f6">Pentavalent</option><option value="cr_r5_f6">Pneumococcal(PCV10)</option><option value="cr_r6_f6">Measles</option><option value="cr_r7_f6">DIL Measles</option><option value="cr_r8_f6">TT 10</option><option value="cr_r9_f6">TT 20</option><option value="cr_r10_f6">HBV (Birth dose)</option><option value="cr_r11_f6">IPV</option><option value="cr_r12_f6">AD Syringes 0.5 ml</option><option value="cr_r13_f6">AD Syringes 0.05 ml</option><option value="cr_r14_f6">Recon.Syringes (2 ml)</option><option value="cr_r15_f6">Recon. Syringes (5 ml)</option><option value="cr_r16_f6">Safety Boxes</option><option value="cr_r17_f6">Other</option></select></div></div></div>' ).insertBefore($('.content-wrapper').find('section').find('.row').find('.row:last'));
			}else{
				document.getElementById('StockoutRate').style.display = 'none';
				document.getElementById("StockoutRate").remove();
			}
		});
		
		$(document).ready(function(){
			
			var indicator = $('#indicator').val();
			if(indicator == '52' || indicator == '53' || indicator == '54' || indicator == '55'){
				if (document.contains(document.getElementById("StockoutRate"))) {
					document.getElementById("StockoutRate").remove();
				} 
				$( '<div class="row" id="StockoutRate"><div class="form-group"><label class="col-xs-3 col-xs-offset-1 control-label" for = "vacc_ind" >Select Vaccine</label><div class="col-xs-7"><select class="form-control" name="vacc_ind" id="vacc_ind"><option value="all_vacc">All Vaccines</option><option value="cr_r1_f6">BCG</option><option value="cr_r2_f6">DIL BCG</option><option value="cr_r3_f6">bOPV</option><option value="cr_r4_f6">Pentavalent</option><option value="cr_r5_f6">Pneumococcal(PCV10)</option><option value="cr_r6_f6">Measles</option><option value="cr_r7_f6">DIL Measles</option><option value="cr_r8_f6">TT 10</option><option value="cr_r9_f6">TT 20</option><option value="cr_r10_f6">HBV (Birth dose)</option><option value="cr_r11_f6">IPV</option><option value="cr_r12_f6">AD Syringes 0.5 ml</option><option value="cr_r13_f6">AD Syringes 0.05 ml</option><option value="cr_r14_f6">Recon.Syringes (2 ml)</option><option value="cr_r15_f6">Recon. Syringes (5 ml)</option><option value="cr_r16_f6">Safety Boxes</option><option value="cr_r17_f6">Other</option></select></div></div></div>' ).insertBefore($('.content-wrapper').find('section').find('.row').find('.row:last'));
			}else{
				document.getElementById('StockoutRate').style.display = 'none';
				document.getElementById("StockoutRate").remove();
			}
		});
	<?php } ?>
	$(".dp-my").datepicker({
		autoclose: true,
		format: "yyyy-mm",
		startDate: '2016-01',
		viewMode: "months", 
		minViewMode: "months",
		//endDate: new Date()
	});	
	$("#monthfrom").datepicker({
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$('#monthto').datepicker('setStartDate', minDate);
	});
</script>