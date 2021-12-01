<div class="container bodycontainer">
	<?php
		echo $TopInfo;
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Sr#</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Union Council</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Facilities Based Population</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Villages Based Population</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Facilities and Villages Difference</th>
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
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $val['un_name'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo isset($val['hf_based_population'])?$val['hf_based_population']:'0';
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo isset($val['village_based_population'])?$val['village_based_population']:'0';
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $val['hf_based_population'] - $val['village_based_population'];
						echo "</td></tr>";
						$count++;
					}
				}else{
					echo "<div><td style='text-align:center; border: 1px solid black;' class='text-center' colspan='6'>SORRY! Record Not Exist</td></tr>";
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
<style>
#parent {
	height: 400px;
}
#fixTable {
	width: 1800px !important;
}
</style>