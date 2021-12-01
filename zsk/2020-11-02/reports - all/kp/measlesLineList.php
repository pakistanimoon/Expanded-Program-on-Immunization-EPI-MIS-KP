

<!--start of page content or body-->
 <div class="container bodycontainer">
	<div class="row">
		<?php 
			echo $TopInfo;
			echo $tableData;
		?>			
  </div><!--end of row-->
  </div><!--End of page content or body-->


<!--start of footer-->
<br>
<br>

<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-3.1.1.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
		$('.clickedReport').css('cursor','pointer');
		$('.mrClicked').css('cursor','pointer');
		$('.Compliance').css('cursor','pointer');
	});
	<?php if(!$this->input->post('export_excel'))
    {?>
	$(document).on('click','.mrClicked', function(){
        var code = $(this).find("td:first-child").text();
		var code1=code.toString().length;
        <?php if(isset($data['year'])) { ?>
          	var year='<?php echo $data['year']; ?>';
        <?php }else{ ?>
          	var year='<?php echo date('Y'); ?>';
        <?php } ?>
        var url = '';
		if (code.indexOf("Investigation-") >= 0)
		{
			var facode = $(this).find("td:eq(1)").text();
			code=code.replace('Investigation-', '');
			url = "<?php echo base_url();?>Data_entry/measles_view/"+facode+"/"+code;
		}
        else if(code1 == 3 || code1 == 9){
			url = "<?php echo base_url();?>Reports/MeaslesInvestigationCompliance/"+code+"/"+year;
        }
		/* url = "<?php echo base_url();?>Reports/aefi_compliance";
		$.post(url, {distcode: code,report_year:year}, function(result) {
			newpage = result;
			window.open('javascript: document.write(window.opener.newpage);','_blank');
		}); */        
        var win = window.open(url,'_self');
        if(win){
			//Browser has allowed it to be opened
			win.focus();
		}else{
			//Broswer has blocked it
			alert('Please allow popups for this site');
		}
    });
      //Compliance
  	/* $('.Compliance').on('click', function(){
		var code = $(this).data('value');
	    var distCode = 0;
	    var facode = 0;
	    var url = '';
	     <?php if(isset($data['report_year'])) { ?>
          	var year='<?php echo $data['report_year']; ?>';
        <?php } ?>
	    if(code.toString().length == 6){
	    	facode = code;
	    	url = "<?php echo base_url();?>System_setup/flcf_view?facode="+facode;
	    }
	     
	    if(code.toString().length == 3){
	    	url = "<?php echo base_url();?>Reports/flcf_vacc_coverage_compliance?distcode="+code+"&report_year="+year;
	    }
		var win = window.open(url,'_blank');
	    if(win){
	        //Browser has allowed it to be opened
	        win.focus();
	    }else{
	        //Broswer has blocked it
	        alert('Please allow popups for this site');
	    }
	}); */
<?php } ?>


</script>

