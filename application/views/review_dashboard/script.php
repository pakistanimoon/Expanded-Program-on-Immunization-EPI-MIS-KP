		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="//code.highcharts.com/maps/modules/map.js"></script>
		<script src="http://code.highcharts.com/modules/exporting.js"></script>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="<?php echo base_url(); ?>review_dashboard/js/popper.min.js"></script>
		<script src="<?php echo base_url(); ?>review_dashboard/js/bootstrap.min.js"></script>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		<!-- Owl Carousel -->
		<script src="<?php echo base_url(); ?>review_dashboard/js/owl.carousel.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var d = new Date();
				var mon = d.getMonth();
				mon = '<?php if($this -> input -> get('year') && $this -> input -> get('year') < date('Y')){ ?>'+ '12' + '<?php }else{ ?>' + parseInt(mon+1) + '<?php } ?>';
				$(document).on('change','.cst-radio-filter',function(){
					var filter = $('.cst-radio-filter:checked').val();
					if(filter == 'yearly'){
						$('#year').removeAttr('disabled');
						$('#bi-year').attr('disabled','disabled');
						$('#month').attr('disabled','disabled');
						$('#quarter').attr('disabled','disabled');
					}else if(filter == 'biyearly'){
						$('#year').removeAttr('disabled');
						$('#bi-year').removeAttr('disabled');
						$('#month').attr('disabled','disabled');
						$('#quarter').attr('disabled','disabled');
					}else if(filter == 'quarterly'){
						$('#year').removeAttr('disabled');
						$('#bi-year').attr('disabled','disabled');
						$('#month').attr('disabled','disabled');
						$('#quarter').removeAttr('disabled');
					}else if(filter == 'monthly'){
						$('#year').removeAttr('disabled');
						$('#bi-year').attr('disabled','disabled');
						$('#month').removeAttr('disabled');
						$('#quarter').attr('disabled','disabled');
					}else{
						$('#year').removeAttr('disabled');
						$('#bi-year').attr('disabled','disabled');
						$('#month').attr('disabled','disabled');
						$('#quarter').attr('disabled','disabled');
					}
					if(mon < 10){
						$("#quarter option[value='4']").attr("disabled", "disabled");
						$("#bi-year option[value='2']").removeAttr("disabled", "disabled");
					}
					else if(mon < 7){
						$("#bi-year option[value='2']").attr("disabled", "disabled");
						$("#quarter option[value='3']").attr("disabled", "disabled");
						$("#quarter option[value='4']").attr("disabled", "disabled");
					}
					else if(mon < 4){
						$("#quarter option[value='2']").attr("disabled", "disabled");
						$("#quarter option[value='3']").attr("disabled", "disabled");
						$("#quarter option[value='4']").attr("disabled", "disabled");
						$("#bi-year option[value='2']").attr("disabled", "disabled");
					}else{
						$("#quarter option[value='2']").removeAttr("disabled", "disabled");
						$("#quarter option[value='3']").removeAttr("disabled", "disabled");
						$("#quarter option[value='4']").removeAttr("disabled", "disabled");
						$("#bi-year option[value='2']").removeAttr("disabled", "disabled");
					}
				});
				$('.cst-radio-filter').trigger('change');
				
				/* Get Months on year change */
				
				$(document).on('change','#year', function(){
					var year = $(this).val();
					var curryear = d.getFullYear();
					var month;
					$("#quarter option[value='1']").attr('selected','selected');
					$("#bi-year option[value='1']").attr('selected','selected');
					if(year < curryear)
					{
						month = "month=13";
					}else{
						month = "";
						mon = d.getMonth();
						mon = mon+1;
						if(mon < 10){
							$("#quarter option[value='4']").attr("disabled", "disabled");
							$("#bi-year option[value='2']").removeAttr("disabled", "disabled");
						}
						else if(mon < 7){
							$("#bi-year option[value='2']").attr("disabled", "disabled");
							$("#quarter option[value='3']").attr("disabled", "disabled");
							$("#quarter option[value='4']").attr("disabled", "disabled");
						}
						else if(mon < 4){
							$("#quarter option[value='2']").attr("disabled", "disabled");
							$("#quarter option[value='3']").attr("disabled", "disabled");
							$("#quarter option[value='4']").attr("disabled", "disabled");
							$("#bi-year option[value='2']").attr("disabled", "disabled");
						}else{
							$("#quarter option[value='2']").removeAttr("disabled", "disabled");
							$("#quarter option[value='3']").removeAttr("disabled", "disabled");
							$("#quarter option[value='4']").removeAttr("disabled", "disabled");
							$("#bi-year option[value='2']").removeAttr("disabled", "disabled");
						}
					}
					$.ajax({
						type: "POST",
						data: month,
						url: "<?php echo base_url(); ?>Ajax_calls/getMonths",
						success: function(result){
							$('#month').html(result);
						}
					});
					
				});
			});
		</script>
		<?php echo (isset($map))?$map:''; ?>
		<?php echo (isset($ranking))?$ranking:''; ?>