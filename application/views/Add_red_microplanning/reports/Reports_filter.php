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
</script>