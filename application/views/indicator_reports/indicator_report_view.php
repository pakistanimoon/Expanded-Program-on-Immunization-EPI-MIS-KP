<?php 
if($TopInfo!=''){
     echo $TopInfo;
  }
  //print_r($data);exit;
  echo $htmlData; 
  ?>
<?php if(!$this->input->post('export_excel'))
        { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
	$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
	 
	$(document).on('click',".DrillDownRow", function(){

        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		var vacc_ind= "<?php echo $data['vacc_ind']; ?>";
		var indicator= "<?php echo $data['indicator']; ?>";
		var monthfrom= "<?php echo $data['monthfrom']; ?>";
		var monthto= "<?php echo $data['monthto']; ?>";
        if(codeLength == 3)
        {
			url = "<?php echo base_url();?>Indicator_Reports/Vaccine/"+code+"/"+monthfrom+"/"+monthto+"/"+indicator+"/"+vacc_ind;
        }
		var win = window.open(url,'_self');
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
    });
 </script>
     <?php } ?>