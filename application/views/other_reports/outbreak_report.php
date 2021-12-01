<?php //kp 
if($TopInfo!=''){
	echo $TopInfo;
}
echo $htmlData;

  ?>

<?php if(!$this->input->post('export_excel'))
        { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
	$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
	 
	$(document).ready(function(){
		$('.table').find('tr').find('td').each(function(){
			$(this).addClass('text-center');
			if(parseInt($(this).text()) < 1 || $(this).text() == ''){
				$(this).text('0');
			}else{
				
			}
		});
	});

	$(document).on('click','.DrillDownRow', function(){
		//alert("aaa"); 
        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		//var monthfrom= "<?php //echo $data['monthfrom']; ?>";
		var disease= "<?php echo $data['disease']; ?>";
		var from_week= "<?php echo (isset($data['from_week']))?$data['from_week']:'01'; ?>";
		var to_week= "<?php echo (isset($data['to_week']))?$data['to_week']:lastWeek($data['year']); ?>";
		var year= "<?php echo $data['year']; ?>";
		//alert(from_week); 
	
		var url = "";
        if(codeLength == 3)
        {
			url = "<?php echo base_url();?>Surveillance/OUTBREAK/"+code+"/"+year+"/"+from_week+"/"+to_week+"/"+disease;
        } 
   //      if(codeLength == 9)
   //      {
   //      	uncode = code;
			// url = "<?php //echo base_url();?>Other_Reports/disease_outbreak_villages/"+uncode+"/"+year+"/"+disease;
   //      }
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
	$(document).on('click','td',function(){
		var tdindex = parseInt($(this).index());
		if(tdindex > 1){
			var weekno = $(this).closest('table').find('thead').find('tr').find('th:nth-child('+(tdindex+1)+')').text().split('Week ');
			
			weekno = weekno[1];
			var code = $(this).closest('tr').find("td:first-child").text();
			var codeLength=code.toString().length;
			var year= "<?php echo $data['year']; ?>";
			var disease= "<?php echo $data['disease']; ?>";
			disease = disease.replace('%20',' ');
			if(disease == 'measles'){
				var linelist_case_type = 'Msl';
			}else if(disease == 'afp'){
				var linelist_case_type = 'AFP';
			}else if(disease == 'diphtheria'){
				var linelist_case_type = 'Diph';
			}else if(disease == 'pertussis'){
				var linelist_case_type = 'Pert';
			}else if(disease == 'pneumonia'){
				var linelist_case_type = 'Pneu';
			}else if(disease == 'childhood tb'){
				var linelist_case_type = 'ChTB';
			}else if(disease == 'meningitis'){
				var linelist_case_type = 'Men';
			}else if(disease == 'hepatitis'){
				var linelist_case_type = 'HepB<5';
			}
			var url = "";
			if(codeLength == 9){
				url = "<?php echo base_url();?>Linelists/Surveillance/"+code+"/"+year+"/"+weekno+"/"+linelist_case_type+"/yes/0/outbreak";
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
			}
		}
	});
 </script>
     <?php } ?>