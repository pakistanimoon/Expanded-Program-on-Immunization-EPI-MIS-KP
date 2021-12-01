
<!--start of page content or body-->
<div class="container bodycontainer">
	<?php 
		echo $TopInfo;
		echo $htmlData;
	?>			
</div><!--End of page content or body-->


<!--start of footer-->
<br>
<br>

<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
	$('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:eq(0)").text();
//alert(code);
        <?php if(isset($data['employee_desg'])) { ?>
			var employee_desg='<?php echo $data['employee_desg']; ?>';
			//alert(employee_desg);
		<?php } ?>
        //alert(code);
		 if(code.toString().length == 6){
			url = "<?php echo base_url();?>System_setup/flcf_view?facode="+code;
		} 
		if(code.toString().length == 3 && employee_desg == 'technician'){
			url =  "<?php echo base_url();?>setup_listing/technician_listing/"+code+"/"+employee_desg;
		}
		if(code.toString().length == 3 && employee_desg == 'med_technician'){
			url =  "<?php echo base_url();?>setup_listing/med_technician_listing/"+code+"/"+employee_desg;
		}
		if(code.toString().length == 3 && employee_desg == 'dso'){
			url =  "<?php echo base_url();?>setup_listing/district_Surveillance_Officer_listing/"+code+"/"+employee_desg;
		}
		if(code.toString().length == 6 && employee_desg == 'co'){
			url =  "<?php echo base_url();?>setup_listing/Computer_Operator_listing/"+code+"/"+employee_desg;
			//setup_listing/Computer_Operator_listing?distcode="+code+"&status=&sup_type=";
		}
		if(code.toString().length == 3 && employee_desg == 'driver'){
			url =  "<?php echo base_url();?>setup_listing/cold_Chain_Driver_listing/"+code+"/"+employee_desg;
		}
		if(code.toString().length == 3 && employee_desg == 'deo'){
			url =  "<?php echo base_url();?>setup_listing/supervisor_listing/"+code+"/"+employee_desg;
		}
		if(code.toString().length == 3 && employee_desg == 'sk'){
			url =  "<?php echo base_url();?>setup_listing/StoreKeeper_listing/"+code+"/"+employee_desg;
		}
		if(code.toString().length == 3 && employee_desg == 'supervisor'){
			url =  "<?php echo base_url();?>setup_listing/supervisor_listing?distcode="+code+"&status=&sup_type=";
		}
		var win = window.open(url,'_self');
		if(win){
			//Browser has allowed it to be opened
			win.focus();
		}else{
			//Broswer has blocked it
			alert('Please allow popups for this site');
		}
    });  
</script>