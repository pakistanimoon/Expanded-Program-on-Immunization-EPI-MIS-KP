<?php //print_r($data);exit; kp ?>
<div class="container bodycontainer">
	<?php
		echo $TopInfo;
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Sr#</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Tehsil</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total Union Council</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Added village/Mohalla in Union Council </th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Added village/Mohalla Population </th>
				</tr>
			</thead>
			<tbody id="tbody">
				<input type='text' hidden value="<?php echo $year;  ?>" id='year'>
				<?php
				$count = 1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$total = array();
				if(!empty($data)){
				 	foreach($data as $key => $val)
					{
						echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $key+1;
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>
						<input type='hidden' id='tcode' name='tcode' value='".$val['tcode']."'>
						";
						echo $val['tehsil'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $val['totalucs'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $val['noofucwithvillagesadded'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $val['villagespopulation'];
						echo "</td></tr>";
						$count++;
					}
				}else{
					echo "<div><td colspan='6'>SORRY! Record Not Exist</td></tr>";
				}
				?>
			</tbody>
		</table>
	</div>
</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var code = $(this).find('input[type="hidden"][name="tcode"]').val();
		var year = '<?php echo $year; ?>';
		url = "<?php echo base_url();?>Population_report/village_population_not_set_uc?tcode="+code+"&year="+year;        
        /* var distcode = code.substr(0,3);
        var tcode = code.substr(0,6);
		
        var url = ''; */
		

        /* if(code.toString().length == 9){
          url = "<?php echo base_url();?>Population_report/village_population_not_set?distcode="+distcode+"&tcode="+tcode+"&uncode="+code+"&year="+year;        
        }
        else{
          url = "<?php echo base_url();?>Population_report/village_population_not_set?distcode="+distcode+"&tcode="+tcode;
        } */
        
		var win = window.open(url,'_blank');
        if(win){
          //Browser has allowed it to be opened
          win.focus();
        }else{
          //Broswer has blocked it
          alert('Please allow popups for this site');
        }
    });
	
</script>


<style>

#parent {
	height: 400px;
}
#fixTable {
	width: 1800px !important;
}
</style>