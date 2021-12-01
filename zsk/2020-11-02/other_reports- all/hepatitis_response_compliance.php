
<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];
/* echo $monthfrom ; 
echo $monthto ; Exit; 
print_r($allData); exit; */
		
	 ?>


	<script>
		$(document).ready(function() {
				$("#fixTable").tableHeadFixer({"left" : 5}); 
			});
	</script>
	<div id="parent" style="overflow:auto" >
			<table id="fixTable" class="table">
				<thead>
					<tr>
						<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" style="width:30px;">S #</th>-->
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" >District</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3">No. Of Cases</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="10">No. Of Children Vaccinated</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">No. of blood samples collected</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">No. of Throat/Oral Swabs Collected</th>
						<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" hidden="hidden">Year</th>-->
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" hidden="hidden">Disease</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" hidden="hidden">Month from</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" hidden="hidden">Month to</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" hidden="hidden">distcode</th>
					</tr>
					<tr>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Reported through case based surveillance</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Active search Cases</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">EPI linked Cases</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">BCG</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">OPV 0</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">PCV 10</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Panta 1</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Panta 2</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Panta 3</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">IPV</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">MSL 1</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">MSL 2</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">MSL Booster Dose</th>
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
						//echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						//echo $count;
						echo "<tr class='DrilledDown'><td style='text-align:center; border: 1px solid black;' class='text-center' data-district=".$row['district'].">";
					    echo $row['district'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['Reported through case based surveillance']; 
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['Active search Cases'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['Epi linked Cases'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['bcg'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['opv0'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['pcv10'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['penta1'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['penta2'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['penta3'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['ipv'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['measles1'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['measles2'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['Measles Booster Dose'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['No. of blood samples collected'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo $row['No. of Throat/ Oral Swabs Collected'];
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center' hidden='hidden' data-disease=".$disease.">";
						echo $disease;
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center' hidden='hidden' data-monthfrom=".$monthfrom.">";
						echo $monthfrom;
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center' hidden='hidden' data-monthto=".$monthto.">";
						echo $monthto;
						echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center' hidden='hidden' data-distcode=".$row['distcode'].">";
						echo $distcode;
						echo "</td>";
						$count++;
					}
				}else{
					echo "<div><td style='text-align:center; border: 1px solid black;' colspan='24'>SORRY! Record Not Exist</td></tr>";
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

		$('.DrilledDown').css('cursor','pointer');
		$(document).on('click',".DrilledDown", function(){
        var district = $(this).find("td:first-child").data('district');
        //var year = $year;
//echo $year , $disease;
//var year=document.getElementById("$year"); 
       // var district = $(this).find("td:first-child").data('district');
       // var year = $(this).find("td:nth-child(17)").data('year');
        var disease = $(this).find("td:nth-child(17)").data('disease');
        var monthfrom = $(this).find("td:nth-child(18)").data('monthfrom');
        var monthto = $(this).find("td:nth-child(19)").data('monthto');
        var distcode = $(this).find("td:last-child").data('distcode');
//alert(distcode);
		var url = '';
		url = "<?php echo base_url();?>Other_Reports/outbreak_report/"+distcode+"/"+disease+"/"+monthfrom+"/"+monthto;       
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