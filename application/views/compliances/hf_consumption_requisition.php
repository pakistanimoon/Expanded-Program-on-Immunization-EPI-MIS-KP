<!--start of page content or body-->
<div class="container bodycontainer">
	<?php 
		echo $TopInfo;
		if(($this-> uri-> segment(3) != '' && strlen($this-> uri-> segment(3))==3) OR isset($this-> session-> District) OR $this-> input-> post('distcode')){ ?>
			<div class="text-right">
				<table class="legends-table" style="display: inline;">
					<tbody>
						<tr>
							<td style="padding:0 20px;"><strong>Legends</strong></td>
							<td><img src="<?php echo base_url();?>/includes/images/timely.png" style="width: 20px;" > Timely &nbsp;</td>
							<td><span style="color: green; font-size: 20px;">&#10004;</span> Complete &nbsp;</td>
							<td><i class="fa fa-times" style="font-size: 20px;color: red;"></i> Not Submitted &nbsp;</td>
							<td><span style="font-size: 18px; font-weight: bolder; color: brown">NF</span> Not Functional &nbsp;</td>
						</tr>
					</tbody>					
				</table>
			</div>
	<?php } ?>			
	<?php echo $tableData; ?>

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
	$(document).ready(function(){
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
			// <?php //if(isset($data['year'])) { ?>
			// 	var year='<?php //echo $data['year']; ?>';
			// <?php //}else{ ?>
			// 	var year='<?php //echo date('Y'); ?>';
			// <?php //} ?>
			//alert(code);
			if(code.toString().length == 6){
				//url = "<?php echo base_url();?>HF-Consumption-Requisition/View/"+year+"-"+month+"/"+code;
				//url = "<?php echo base_url();?>consumption/view/"+fmonth+"/"+code;
				url = "<?php echo base_url();?>vaccination/view/"+fmonth+"/"+code;
				//alert(url);
				var win = window.open(url,'_blank');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}
		});
		$(document).on('click','.Compliance', function(){
			var code = $(this).data('value');
			if(code.toString().length == 6){
				url = "<?php echo base_url();?>System_setup/flcf_view?facode="+code;
				var win = window.open(url,'_blank'); 
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}	
			}			
		});
		$(document).on('click','.clickedReport', function(){
			var code = $(this).data('value');

			// <?php //if(isset($data['year'])) { ?>
			// 	var year='<?php echo $data['year']; ?>';
			// <?php //}else{ ?>
			// 	var year='<?php echo date('Y'); ?>';
			// <?php //} ?>
			
			<?php if(isset($data['monthfrom'])) { ?>
				var monthfrom='<?php echo $data['monthfrom']; ?>';
			<?php } ?>
			<?php if(isset($data['monthto'])) { ?>
				var monthto='<?php echo $data['monthto']; ?>';
			<?php } ?>
			
			if(code.toString().length == 3){
				url = "<?php echo base_url();?>Compliances/HF_Consumption_Requisition/"+code+"/"+monthfrom+"/"+monthto;
				var win = window.open(url,'_blank');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}			
		});
	<?php } ?>
</script>