<div class="container bodycontainer">
	<?php echo $TopInfo; ?>
	<?php echo $htmlData; ?>
</div>
<!--End of page content or body-->
<!--start of footer-->
<br>
<br>
<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>

<?php if(!$this->input->post('export_excel'))
        { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
	$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
	 
	$(document).on('click','.DrillDownRow', function(){
        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		var year= "<?php echo $data['year']; ?>";
		//alert(year); 
		/* <?php if(isset($data['week']) AND $data['week'] > 0){ ?>
		var week= "<?php echo $data['week']; ?>";
		<?php }else{ ?>
		var week = 0;
		<?php } ?> */ 
		var from_week= "<?php echo (isset($data['from_week']))?$data['from_week']:'01'; ?>";
		var to_week= "<?php echo (isset($data['to_week']))?$data['to_week']:lastWeek($data['year']); ?>";
		var report_type= "fwise";
		var url = "";
        if(codeLength == 3)
        {
			url = "<?php echo base_url();?>Surveillance/VPD/"+code+"/"+year+"/"+from_week+"/"+to_week+"/"+report_type;
        }
        if(url)
        {
	        var win = window.open(url,'_blank');
	        if(win)
	        {
				//Browser has allowed it to be opened
				win.focus();
			}
			else
			{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			}
		}
    });
 </script>
     <?php } ?>