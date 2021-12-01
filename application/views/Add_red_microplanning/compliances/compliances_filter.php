<br>
<?php echo $listing_filters; 
$currentYear = date('Y');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">

   $(document).ready(function(){	
		 if($('#year option:last').val() == new Date().getFullYear()){
			$('#year option:last').prop('selected', true);
		}else{
			$('#year option:first').prop('selected', true);
		}
	});
</script>