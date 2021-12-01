<?php 
if($TopInfo!=''){
	echo $TopInfo;
}
echo $htmlData; print_r($data);
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
        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		var year= "<?php echo $data['year']; ?>";
		var disease= "<?php echo $data['disease']; ?>";
		var url = "";
        if(codeLength == 3)
        {
			url = "<?php echo base_url();?>Surveillance/OUTBREAK/"+code+"/"+year+"/"+disease;
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
				var case_type = 'Measles_other';
			}else if(disease == 'afp'){
				var case_type = 'AFP';
			}else if(disease == 'diphtheria'){
				var case_type = 'Diphtheria';
			}else if(disease == 'pertussis'){
				var case_type = 'Pertussis';
			}else if(disease == 'pneumonia'){
				var case_type = 'Pneumonia';
			}else if(disease == 'childhood tb'){
				var case_type = 'Childhood TB';
			}else if(disease == 'meningitis'){
				var case_type = 'Meningitis';
			}else if(disease == 'hepatitis'){
				var case_type = 'Hepatitis';
			}
			var url = "";
			if(codeLength == 9){
				url = "<?php echo base_url();?>Linelists/Surveillance/"+code+"/"+year+"/"+weekno+"/"+case_type+"/yes";
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