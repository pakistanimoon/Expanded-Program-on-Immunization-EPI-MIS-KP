<?php if($TopInfo){echo $TopInfo;}
					
                     echo $getListingTable; ?>

<?php  if(!$this->input->post('export_excel')){?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">

  $('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
		var disease = $(this).find("td:eq(0)").text();
		var url = '';
		 
       
		if(disease.toString().length == 3){
			var distcode = $(this).find("td:eq(0)").text();
			var disease = "<?php echo isset($_REQUEST['case_name']) ? $_REQUEST['case_name'] : $this->uri->segment('3');; ?>";
			var year = "<?php echo isset($_REQUEST['year']) ? $_REQUEST['year'] : $this->uri->segment('5'); ?>";
			var from_week = "<?php echo isset($_REQUEST['from_week']) ? $_REQUEST['from_week'] :$this->uri->segment('6'); ?>";
			var to_week = "<?php echo isset($_REQUEST['to_week']) ? $_REQUEST['to_week'] : $this->uri->segment('7'); ?>";
			url = "<?php echo base_url();?>Indicator_Reports/priority_diseases/"+disease+"/"+distcode+"/"+year+"/"+from_week+"/"+to_week;
		}else{
			var disease = $(this).find("td:eq(0)").text();
			if(disease!='0'){
				var distcode = "<?php echo isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : ''; ?>";
				var year = "<?php echo isset($_REQUEST['year']) ? $_REQUEST['year'] : $this->uri->segment('5'); ?>";
				var from_week = "<?php echo isset($_REQUEST['from_week']) ? $_REQUEST['from_week'] : 0; ?>";
				var to_week = "<?php echo isset($_REQUEST['to_week']) ? $_REQUEST['to_week'] : 0; ?>";
				url = "<?php echo base_url();?>Indicator_Reports/priority_diseases/"+disease+"/"+distcode+"/"+year+"/"+from_week+"/"+to_week;
			}
			
		}
		if(url!='' && url!='0'){
			var win = window.open(url,'_self');
		   if(win){
			  //Browser has allowed it to be opened
			  win.focus();
			}else{
			  //Broswer has blocked it
			  alert('Please allow popups for this site');
			}
		}
		
      });
  </script>
<?php }?>