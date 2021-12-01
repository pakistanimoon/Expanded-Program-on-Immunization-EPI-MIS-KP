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
		$(document).on('change','#reportindicator',function(){
			if (document.contains(document.getElementById("StockoutRate"))) {
				document.getElementById("StockoutRate").remove();
			}
			var selectedval = $(this).val();
			var vacchtml = '<div class="row" id="StockoutRate">'+
					'<div class="form-group">'+
						'<label class="col-xs-3 control-label" for = "vaccines" >Select Vaccine(s)</label>'+
						'<div class="col-xs-7">'+
							'<select class="form-control" name="vaccines[]" id="vaccines" multiple="multiple">';
				if(selectedval==1){
					vacchtml = vacchtml+'<?php echo get_items_options(true,FALSE,array(1,2)); ?>';
				}else if(selectedval ==2){
					vacchtml = vacchtml+'<?php echo getVaccines_options(true,1,FALSE,array(1)); ?>';
				}				
				vacchtml = vacchtml+'</select>'+
						'</div>'+
					'</div>'+
				'</div>';
			$( vacchtml).insertBefore(
				$('.content-wrapper').find('section').find('.row').find('.row:last')
			);
			$("#vaccines").multiselect('destroy');
			document.getElementById("vaccines").setAttribute("multiple", "multiple"); 
			$('#vaccines').multiselect({
				includeSelectAllOption: true,
				buttonClass: 'form-control',
				buttonWidth: '311px',
				enableFiltering: true,
				maxHeight: 118   
			});
			$('#vaccines').multiselect('rebuild');
		});
		$("#reportindicator").trigger("change");
		if(isExists('month')){
			$("#month").find("option:last").prop("selected", true);
		}
	});
</script>