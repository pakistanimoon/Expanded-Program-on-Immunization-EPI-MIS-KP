<br>
<?php echo $listing_filters; ?>
<script type="text/javascript">
	$('#supervisor_type').on('change', function(){
		if($(this).val() == "Tehsil Superintendent Vaccinator"){
			$('#hiddenTehsilRow').removeClass('hide');
		}else{
			$('#hiddenTehsilRow').addClass('hide');
		}
	});
</script>
</html>