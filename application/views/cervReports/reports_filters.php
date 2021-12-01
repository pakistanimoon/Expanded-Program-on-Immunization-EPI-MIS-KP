<br>
<?php echo $listing_filters; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
		$(document).on('change','#uncode',function(){
			var uncode = $(this).val();
			if(parseInt(uncode) > 0){
				$.ajax({ 
					type: 'POST',
					data: "uncode="+uncode,
					url: '<?php echo base_url();?>Ajax_calls/getUCTechnicians',
					success: function(data){
						$('#vaccinator').html(data);
						$('.vaccinator').removeClass('hide');
					}
				});
			}else{
				$('.vaccinator').addClass('hide');
			}
		});
		$(".dp-my").datepicker({
			autoclose: true,
			format: "yyyy-mm",
			startDate: '2016-01',
			viewMode: "months", 
			minViewMode: "months",
			endDate: new Date()
		});
		$("#monthfrom").datepicker({
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('#monthto').datepicker('setStartDate', minDate);
		});
	});
</script>