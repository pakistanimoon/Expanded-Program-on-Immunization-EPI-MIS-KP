<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];
//print_r($allData); exit;
		
	 ?>
	

	
	<div id="parent"style="overflow:auto" >
			<table id="fixTable" class="table">
				<thead>
					<tr>
						<!--<th rowspan="2" style="width:30px;">S #</th>-->
						<th rowspan="2">District</th>
						<th rowspan="2">Date of Activity</th>
						<th rowspan="2">Union Council</th>
						<th rowspan="2">Village</th>
						<th colspan="3">No. Of Cases</th>
						<th colspan="5">No. Of Children Vaccinated</th>
						<th colspan="2">Age Group selected for response</th>
						<th rowspan="2">No. of Throat/Oral Swabs Collected</th>
						<th rowspan="2">Folow Up Visit</th>
					</tr>
					<tr>
						<th>Reported through case based surveillance</th>
						<th>Active search Cases</th>
						<th>EPI linked Cases</th>
						<th>Panta 1</th>
						<th>Panta 2</th>
						<th>Panta 3</th>
						<th>TD/ DtaP/ Dt</th>
						<th>Penta Booster Dose</th>
						<th>Age Group Form (Months)</th>
						<th>Age Group To (Months)</th>
					</tr>
			
				</thead>
				<tbody>
			<?php
				$count = 1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$total = array();
				if(!empty($allData)){
				 	foreach($allData as $val=>$row)
					{
						//echo "<tr class='DrillDownRow'><td class='text-center'>";
						//echo $count;
						echo "<tr class='DrillDownRow'><td class='text-left text-nowrap'>";
					    echo $row['District'];
						echo "</td><td class='text-center text-nowrap'>";
						echo $row['Date of Actvity'];
						echo "</td><td class='text-left text-nowrap'>"; 
						echo $row['Union Council'];
						echo "</td><td class='text-left text-nowrap'>";
						echo $row['Village'];
						echo "</td><td class='text-center'>";
						echo $row['Reported through case based surveillance']; 
						echo "</td><td class='text-center'>";
						echo $row['Active search Cases'];
						echo "</td><td class='text-center'>";
						echo $row['Epi linked Cases'];
						echo "</td><td class='text-center'>";
						echo $row['Penta 1'];
						echo "</td><td class='text-center'>";
						echo $row['Penta 2'];
						echo "</td><td class='text-center'>";
						echo $row['Penta 3'];
						echo "</td><td class='text-center'>";
						echo $row['TD/DtaP/Dt'];
						echo "</td><td class='text-center'>";
						echo $row['Penta Booster Dose'];
						echo "</td><td class='text-center'>";
						echo $row['Age Group Form (Months)'];
						echo "</td><td class='text-center'>";
						echo $row['Age Group To (Months)'];
						echo "</td><td class='text-center'>";
						echo $row['No. of Throat/ Oral Swabs Collected'];
						echo "</td><td class='text-center'>";
						echo $row['Folow up Visit']; 
						$count++;
					}
				}else{
					echo "<div><td colspan='24'>SORRY! Record Not Exist</td></tr>";
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
<script src="http://epimis1.pacetec.net/includes/js/tableHeadFixer.js"></script>
<script src="http://epimis1.pacetec.net/includes/bootstrap/js/bootstrap.min.js"></script>
	 <style>
			#parent {
				height: 400px;
			}
			
			#fixTable {
				width: 1800px !important;
			}
		</style>

	<script>
		$(document).ready(function() {
				$("#fixTable").tableHeadFixer({"left" : 4}); 
			});
	</script>