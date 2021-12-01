<?php //print_r($data);exit; ?>
<div class="container bodycontainer">
	<?php
		echo $TopInfo;
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    <th>Sr#</th>
					<!--<th>Tehsil</th>-->
					<th>Union Council</th>
					<th>Added village/Mohalla in Union Council </th>
					<th>Added village/Mohalla Population </th>
				</tr>
			</thead>
			<tbody id="tbody">
				<?php
				$count = 1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$total = array();
				if(!empty($data)){
				 	foreach($data as $key => $val)
					{
						echo "<tr class='DrillDownRow'><td class='text-center'>";
						echo $key+1;
						//echo "</td><td class='text-center'>";
						//echo $val['tehsil'];
						echo "</td><td class='text-center'>
						<input type='hidden' id='uncode' name='uncode' value='".$val['uncode']."'><input type='hidden' id='uncode' name='uncode' value='".$val['uncode']."'>
						";
						echo $val['un_name'];
						echo "</td><td class='text-center'>";
						echo $val['noofvillages'];
						echo "</td><td class='text-center'>";
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
        var code = $(this).find('input[type="hidden"][name="uncode"]').val();
		var year = '<?php echo $year; ?>';
		var distcode = '<?php echo $distcode; ?>';
		url = "<?php echo base_url();?>setup_listing/Village_Mohalla_listing?distcode="+distcode+"&uncode="+code+"&year="+year;    
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