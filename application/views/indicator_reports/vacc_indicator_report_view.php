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
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/table2excel.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
         var change_class = document.getElementById("vampire");
		 $(change_class).attr("onclick","Export()");
		 
        });
        function Export() {
            $("#table1").table2excel({
                filename: "Table.xls"
            });
        }
   
	$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
	
	$(document).on('click','.DrillDownRow', function(){
        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		var reportPeriodnew= "fac";
		var indicator= "<?php echo $data['indicator']; ?>";
		//alert(indicator); exit();
		var monthfrom= "<?php echo $data['monthfrom']; ?>";
		var monthto= "<?php echo $data['monthto']; ?>";
        var tcode= "<?php echo (isset($data['tcode']))?$data['tcode']:NULL; ?>"; 		
		var facode= "<?php echo (isset($data['facode']))?$data['facode']:NULL; ?>"; 
		var uncode= "<?php echo (isset($data['uncode']))?$data['uncode']:NULL; ?>";
        if(codeLength == 3)
        {
			if(tcode > 0 && uncode > 0 && facode > 0){
				url = "<?php echo base_url();?>Indicator_Reports_New/HFMVRF/"+code+"/"+monthfrom+"/"+monthto+"/"+indicator+"/"+reportPeriodnew+"/"+facode+"/"+tcode+"/"+uncode;
		    }else if(tcode > 0 && facode !=''){
			    url = "<?php echo base_url();?>Indicator_Reports_New/HFMVRF/"+code+"/"+monthfrom+"/"+monthto+"/"+indicator+"/"+reportPeriodnew+"/null/"+tcode;
			}else{
				url = "<?php echo base_url();?>Indicator_Reports_New/HFMVRF/"+code+"/"+monthfrom+"/"+monthto+"/"+indicator+"/"+reportPeriodnew+"/null/"+tcode+"/"+uncode;
			} 
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
 <?php $this -> load -> view('indicator_reports/vacc_indicator_report_js',$data); ?>
     <?php } ?>