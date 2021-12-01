<br>
<?php echo $listing_filters; 
$currentYear = date('Y');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
		
		<?php if($this -> session -> UserLevel==4){ ?>
			var tcode= <?php echo $this->session->Tehsil; ?>;
			$('#tcode').val(tcode);
		<?php } ?>
		//var storelevel = $("#store_level-label").closest('.row').fadeOut();
		var storelevel = $("#store_level-label").closest('.row').show();
	    $("#filter-form").prepend(storelevel); 
		<?php if($this -> session -> UserLevel==3){ ?>
			$(window).load(function() { 
				var storelevel = $("#store_level-label").closest('.row').show();
				$("#filter-form").prepend(storelevel); 
				$('#storelevel').prepend('<option value="6" selected>Union Council</option>');
			});
		<?php } ?>
		<?php if($this -> session -> UserLevel==2){ ?>
			$("#storelevel").click(function(){
				var storelevel=$('#storelevel').val();
				if(storelevel==2){
					$('#distcode-label').hide();
					$('#distcode').hide();
				}else if(storelevel==4){
					$('#distcode-label').show();
					$('#distcode').show();
				}else if(storelevel==5){
					$('#distcode-label').show();
					$('#distcode').show();
				}else if(storelevel==6){
					$('#distcode-label').show();
					$('#distcode').show();
				}else if(storelevel== 'unallocated'){
					$('#distcode-label').show();
					$('#distcode').show();
				}else if(storelevel== ''){
					$('#distcode-label').show();
					$('#distcode').show();
				}
			});
			$(window).load(function() { 
				var storelevel = $("#store_level-label").closest('.row').show();
				$("#filter-form").prepend(storelevel); 
				$('#storelevel').prepend('<option value="4" selected>District</option>');
			});
		<?php } ?>
		//alert(storelevalue);
		//All year get
		$(".dp-year").datepicker( {
			format: "yyyy", // Notice the Extra space at the beginning
			viewMode: "years", 
			minViewMode: "years"
		});
	
    });
    
	
</script>
