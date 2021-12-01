<?php 
//beta
    if($TopInfo!=''){
        echo $TopInfo;
    }
    //print_r($data);exit;
    echo $htmlData; 
?>
<?php if(!$this->input->post('export_excel'))
        { ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>



  
<!---script type="text/javascript">
//application\views\summary_reports\hr_summary_report.php
/* 	$('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:eq(0)").text();
alert(code);

	}); --->

  <script type="text/javascript">
	$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
	 
	$(document).on('click','.DrillDownRow', function(){
        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		var indicator= "<?php echo $data['indicator']; ?>";
		var year= "<?php echo $data['year']; ?>";
		var month =  "<?php echo isset($data['month'])?$data['month']:0; ?>";
	//alert(code);	
        if(codeLength == 3)
        { 
        	if(month > 0){
        		//alert(month);
        		url = "<?php echo base_url();?>Indicator_Reports/Disease_Drilldown/"+code+"/"+indicator+"/"+year+"/"+month;
        	}
			else{
				//aler(year);
				url = "<?php echo base_url();?>Indicator_Reports/Disease_Drilldown/"+code+"/"+indicator+"/"+year;
			}
        }
// new code for facilities wise

	/* 	if(codeLength == 9)
        { 
	
        	//url = "<?php echo base_url();?>Linelists/Surveillance?code="+code+"&year="+year;
        	url = "<?php echo base_url();?>Linelists/Surveillance/"+code+"/"+indicator+"/"+year;
        	
        }	
 */

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
    });
 </script>
     <?php } ?>