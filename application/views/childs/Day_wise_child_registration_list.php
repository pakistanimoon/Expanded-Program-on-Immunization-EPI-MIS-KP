<style>
		td.th-heading{
		background:#8adcb6;
		}
		td label{
		margin-bottom:0px;
		}
</style>
<div class="container bodycontainer">
	<?php
		if (isset($data['TopInfo'])){
			echo $data['TopInfo'];
		}

//print_r($data['childDataview'][1]['techniciancode']);exit;

	 ?>
	<div id="month" align="center">
<style>
	   a {
	   text-decoration: none;
	   display: inline-block;
	   padding: 4px 8px;
	   text-align: "center";  
	   }
	   a:hover {
	   /* background-color: #ddd; */
	   color: black;
	   }
	  .previous {
	   visibility: visible;
	   color: #4CAF50;
	   align:"center"; 
	   }
	   .next {
	   visibility: visible;
	   color: #4CAF50;
	   }
	   .round {
	   border-radius: 50%;
	   }
</style>	
		<?php	
			$nmonth = Date("Y-m", strtotime($fmonth . " next month")); 
			$premonth = Date("Y-m", strtotime($fmonth . " previous month"));
			$month = Date("Y-m", strtotime($fmonth));
		?>	
		<a href="<?php echo base_url(); ?>/childs/DaywiseRegisterChildReport/DayWisechildRegistrationList/?
				fmonth=<?php echo $premonth; ?>" class="previous round"><strong>&lt;&lt; </strong> </a>
				
				<strong><?php echo $month;?></strong>
				
			<a href="<?php echo base_url(); ?>/childs/DaywiseRegisterChildReport/DayWisechildRegistrationList/?
				fmonth=<?php echo $nmonth; ?>" class="next round"> <strong>&gt;&gt; </strong></a>
</div>
	

	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th rowspan="2">Tecnician Code</th>
					<th rowspan="2">Tecnician Name</th>
					<?php for($day=1; $day<=30; $day++) { ?>
							<th colspan="2"><?php echo "Day-$day"; ?></th>
						
					<?Php  } ?>
				<tr>
					<?php for($i=1; $i<=30; $i++) { ?>
						<th colspan="1">Child</th>
						<th colspan="1">Women</th>
					<?Php  } ?>
	
				</tr>
				</tr>
	
			</thead>
			<tbody id="tbody">  
				<?php
				//$techniciancode = [$childDataview]['techniciancode'];
					foreach($childDataview as $key => $val){
						
						if(isset($val['technicianname'] ) ){
								echo "<tr class='DrillDownRow'><td class='text-center mrClicked' style='white-space: nowrap; font-weight:500;'>";
								$techniciancode = $val['techniciancode'];
								echo $techniciancode;
								
								echo "<td class='text-center mrClicked' style='white-space: nowrap; font-weight:500;'>";
								$technicianname = $val['technicianname'];
								echo $technicianname; 
								//$techniciancode=$val['techniciancode']	;
								
								//echo'<p class="text-center mrClicked" code="'. $val->techniciancode .'"></p>';
								$month=array();
								$mother='';
							for($day=01; $day<=30; $day++){
								$month= $val["child$day"];
								echo "<td class='text-center DrillDownRow'>";
								echo	$month;
								echo	"</td>";
								echo "<td class='text-center DrillDownRow'>";
								echo	$mother= $val["mother$day"];
								echo	"</td>";
							}
							echo "</tr>";
						}
							
					}
							


					?>
			</tbody>
		</table>
	</div>
</div><!--End of page content or body-->
<!--start of footer-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
		<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		//alert(1);
 		$("#fixTable").tableHeadFixer({"left" : 2});

		});
		$('.DrillDownRow').css('cursor','pointer');
			$('.DrillDownRow').on('click','.mrClicked', function(){
				var currentRow=$(this).closest("tr");
					var techniciancode =  currentRow.find("td:eq(0)").text();
					
					var technicianname = currentRow.find("td:eq(1)").text();    
		var code = $(this).find("td:first").text();

	//alert(code);
		var datefrom = '<?php echo (isset($fmonth))?$fmonth:0;?>';
//alert(datefrom);
		var fmonth = '<?php echo (isset($fmonth))?$fmonth:0; ?>';
		var opt = 1;
		if(code.length==9){

			techniciancode = code;
	//	alert('techniciancode');
		}
		else {

			datefrom = code;

		}


		url = "<?php echo base_url();?>childs/DailyRegisterChildReport/daily_report/?techniciancode="+techniciancode+"&datefrom="+datefrom+"&opt="+opt;

        var win = window.open(url,'_blank');

        if(win){

          //Browser has allowed it to be opened

          win.focus();

        }else{

          //Broswer has blocked it

          alert('Please allow popups for this site');

        }  
			
	
			});
	/* 	var techniciancode = '<?php echo $techniciancode;?>';
		alert(techniciancode); '<?php echo $techniciancode;?>';
		var cardno = $(this).find("input[name='child_registration_no']:eq(0)").val();

		var code = $(this).find("td:first").text();

	//alert(code);
		var datefrom = '<?php echo (isset($fmonth))?$fmonth:0;?>';
//alert(datefrom);
		var fmonth = '<?php echo (isset($fmonth))?$fmonth:0; ?>';
		if(code.length==9){

			techniciancode = code;
		alert('techniciancode');
		}
		else {

			datefrom = code;

		}


	//	url = "<?php echo base_url();?>childs/DailyRegisterChildReport/daily_report/?techniciancode="+techniciancode+"&datefrom="+datefrom;

        var win = window.open(url,'_blank');

        if(win){

          //Browser has allowed it to be opened

          win.focus();

        }else{

          //Broswer has blocked it

          alert('Please allow popups for this site');

        }  */
	
  </script>
