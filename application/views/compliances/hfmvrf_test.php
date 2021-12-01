<!--start of page content or body-->
 <div class="container bodycontainer">
		<?php 
			echo $TopInfo;
			echo $tableData;
		?>
  </div><!--End of page content or body-->

<!--start of footer-->
<br>
<br>

<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>includes/circle-progress/dist/circle-progress.js"></script>-->
 <!--fortooltip-->
<script type="text/javascript">
	$(document).ready(function(){
		//circle animation also have to change epi_reports_helper
		/*$('.circle').each(function(){
			var circlevaluepercentage = ($(this).data('percent')/100);
			var circlevalue = $(this).data('percent');
			$(this).circleProgress({
				value: circlevaluepercentage,
				size:30,
				fill:{
					gradient:["red", "orange"]
				}
			}).on('circle-animation-progress', function(event, progress) {
			  $(this).find('strong').html(parseInt(circlevalue * progress) + '<i>%</i>');
			});
			//alert($(this).data('percent'));
		});*/
	<?php if(!$this->session->District){ ?>
		$("#fixTable").tableHeadFixer({"left" : 2});
	<?php }else{ ?>
		$("#fixTable").tableHeadFixer({"left" : 3});
	<?php } ?>		
		$('.clickedReport').css('cursor','pointer');
		$('.mrClicked').css('cursor','pointer');
		$('.Compliance').css('cursor','pointer');
	});
	<?php if(!$this->input->post('export_excel')){ ?>
		$(document).on('click','.mrClicked', function(){
			var fmonth = $(this).data('fmonth');
			var code = $(this).data('value');
			var year='<?php echo $data['year']; ?>';
			// var monthfrom='<?php //echo $data['monthfrom']; ?>';
			// var monthto='<?php //echo $data['monthto']; ?>';
			var url = '';
			// alert(month);
			// alert(code);
			// alert(year);
			if(code.toString().length == 6){
				//url = "<?php echo base_url(); ?>FLCF-MVRF/View/"+code+"/"+year+"-"+month;
				url = "<?php echo base_url(); ?>FLCF-MVRF/View/"+code+"/"+fmonth;
			}
			//alert(url);
			var win = window.open(url,'_blank');
			if(win){
				//Browser has allowed it to be opened
				win.focus();
			}else{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			}
		});
		$(document).on('click','.Compliance', function(){
			var code = $(this).data('value');
			if(code.toString().length == 6){
				url = "<?php echo base_url();?>System_setup/flcf_view?facode="+code;
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
		$(document).on('click','.clickedReport', function(){
			var code = $(this).data('value');
			
			// <?php //if(isset($data['year'])) { ?>
			// 	var year='<?php //echo $data['year']; ?>';
			// <?php //}else{ ?>
			// 	var year='<?php //echo date('Y'); ?>';
			// <?php //} ?>

			<?php if(isset($data['monthfrom'])) { ?>
				var monthfrom='<?php echo $data['monthfrom']; ?>';
			<?php } ?>
			<?php if(isset($data['monthto'])) { ?>
				var monthto='<?php echo $data['monthto']; ?>';
			<?php } ?>	
				
			if(code.toString().length == 3){
				url = "<?php echo base_url();?>CompliancesTest/HFMVRFTest/"+code+"/"+monthfrom+"/"+monthto;
			}
			var win = window.open(url,'_blank');
			if(win){
				//Browser has allowed it to be opened
				win.focus();
			}else{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			}
			//view();
		});
	<?php } ?>
</script>