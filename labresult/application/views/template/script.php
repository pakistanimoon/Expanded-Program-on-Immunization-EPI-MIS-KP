 <script src="<?php echo base_url(); ?>includes/js/bootstrap.js"></script> 
    <script src="<?php echo base_url(); ?>includes/js/jquery.min.js"></script>
    
    <script src="<?php echo base_url(); ?>includes/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
		// $(document).on("click",".dp",function(e) {
		//    	var options = {
		//     	format : "yyyy-mm-dd",
		//     	todayHighlight: true,
		//     	autoclose: true
		//    	};
		//    	$('.dp').datepicker(options);
		//  });
		var options = {
	    	format : "yyyy-mm-dd",
	    	todayHighlight: true,
	    	autoclose: true
   	};
   	$('.dp').datepicker(options);
	});
	$(document).on("keydown",".numberclass",function(e) {
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || // Allow: Ctrl+A, Command+A
		(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: home, end, left, right, down, up
		(e.keyCode >= 35 && e.keyCode <= 40)) {// let it happen, don't do anything
			return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
			$(this).val('0');
			$(this).select();
		}
	});
	</script> 





