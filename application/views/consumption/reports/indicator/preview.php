<?php 
//$dataToReturn['data']['htmlData'] = $this->load->view("consumption/reports/indicator/tabledata",["tabledata"=>$result]);
		//$dataToReturn['data']['TopInfo'] = '';//reportsTopInfo($title, $data);
		//$dataToReturn['data']['report_source_table'] = "";//$report_table;


if($TopInfo!=''){
    echo $TopInfo;
}
  //print_r($data);exit;
  //$htmlData = str_replace('BOPV','bOPV',$htmlData);
  //echo $htmlData;
$this->load->view("consumption/reports/indicator/tabledata",["tabledata"=>$result]);  

  ?>
<?php if(!$this->input->post('export_excel'))
        { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
	$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
	$(document).ready(function(){
		$('.listing-report-table').find('tbody').find('tr:last').css('background-color','#000');
		$('.listing-report-table').find('tbody').find('tr:last').css('color','#fff');
	});
	$(document).on('click',".DrillDownRow", function(){

        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		var vacc_ind= "<?php echo (isset($data['vacc_ind']))?$data['vacc_ind']:''; ?>";
		var indicator= "<?php echo (isset($data['indicator']))?$data['indicator']:''; ?>";
		var monthfrom= "<?php echo (isset($data['monthfrom']))?$data['monthfrom']:''; ?>";
		var monthto= "<?php echo (isset($data['monthto']))?$data['monthto']:''; ?>";
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