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
		if($TopInfo!=''){

			echo $TopInfo;
		} 
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

	   background-color: #ddd;

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
			
		if(isset($Monthlyresult[0]['techniciancode'])){
			$reportwise='techniciancode';

		}else{
			$reportwise='';
		}
		
		?>	
	<a href="<?php echo base_url(); ?>/childs/DailyRegisterChildReport/daily_report/?fmonth=<?php echo $premonth; ?>&distcode=<?php if(isset($distcode)){ echo $distcode;} ?>&techniciancode=<?php if(isset($techniciancode)){ echo $techniciancode;} ?> &tcode=<?php if(isset($tcode)){ echo $tcode;} ?>&uncode=<?php if(isset($uncode)){ echo $uncode;}?>&reportType=<?php if(isset($reportwise)){ echo $reportwise;}?>" class="previous round"><strong>&lt;&lt; </strong> </a> <strong><?php echo $month;?></strong>
	<a href="<?php echo base_url(); ?>/childs/DailyRegisterChildReport/daily_report/?fmonth=<?php echo $nmonth; ?>&distcode=<?php if(isset($distcode)){ echo $distcode;} ?>&techniciancode=<?php if(isset($techniciancode)){ echo $techniciancode;} ?> &tcode=<?php if(isset($tcode)){ echo $tcode;}?>&uncode=<?php if(isset($uncode)){ echo $uncode;}?>&reportType=<?php if(isset($reportwise)){ echo $reportwise;}?>" class="next round"> <strong>&gt;&gt; </strong></a>
</div>
	<div id="parent">

			<table id="fixTable" class="table table-bordered table-hover table-striped">

			<thead>

				<tr>
				<?php if(isset($techniciancode) || isset($Monthlyresult[0]['$techniciancode']) ||  isset($Monthlyresult[0]['$techniciancode'])  ){  ?>

					<th rowspan="3">Technician Code</th>	

					<th rowspan="3">Technician Name</th>


					<?php }else{ ?>

					<th rowspan="3">Submitted Date</th>	

					<?php } ?>

				</tr>
				<tr> 					

					<th rowspan="1">BCG</th>

					<th rowspan="1">HEPB</th>

					<th rowspan="1">OPV0</th>

					<th rowspan="1">OPV1</th>

					<th rowspan="1">OPV2</th>

					<th rowspan="1">OPV3</th>

					<th rowspan="1">Penta1</th>

					<th rowspan="1">Penta2</th>

					<th rowspan="1">Penta3</th>

					<th rowspan="1">PCV1</th>

					<th rowspan="1">PCV2</th>

					<th rowspan="1">PCV3</th>

					<th rowspan="1">IPV</th>

					<th rowspan="1">Rota1</th>

					<th rowspan="1">Rota2</th>

					<th rowspan="1">Measles1</th>

					<th rowspan="1">Measles2</th>

				</tr>			

			</thead>

			<tbody>

		<?php
			foreach($Monthlyresult as $key => $val)	

			{ ?>

					<tr class="DrillDownRow" style="cursor: pointer;">
					<?php if(isset($techniciancode) || isset($val['techniciancode']) ||  isset($Monthlyresult[0]['techniciancode']) ){ ?>
					<td><?php echo $val['techniciancode']; ?></td> 
						<td><?php echo $val['technician']; ?></td> 
					
					<?php }else{ ?>	
					<td><?php echo $val['submitteddate']; ?></td>
					
					<?php } ?>
					<td><?php echo $val['bcg']; ?></td>

					<td><?php echo $val['hepb']; ?></td>

					<td><?php echo $val['opv0']; ?></td>

					<td><?php echo $val['opv1']; ?></td>

					<td><?php echo $val['opv2']; ?></td>

					<td><?php echo $val['opv3']; ?></td>

					<td><?php echo $val['penta1']; ?></td>

					<td><?php echo $val['penta2']; ?></td>

					<td><?php echo $val['penta3']; ?></td>

					<td><?php echo $val['pcv1']; ?></td>

					<td><?php echo $val['pcv2']; ?></td>

					<td><?php echo $val['pcv3']; ?></td>

					<td><?php echo $val['ipv']; ?></td>

					<td><?php echo $val['rota1']; ?></td>

					<td><?php echo $val['rota2']; ?></td>

					<td><?php echo $val['measles1']; ?></td>

					<td><?php echo $val['measles2']; ?></td>

				</tr>

			<?php }?>

			</tbody>

		</table>

	</div>

</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

		<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>

		<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>

		<script type="text/javascript">

		$(document).ready(function(){

		$("#fixTable").tableHeadFixer({"left" : 3});

		});

		<?php  if(!$this->input->post('export_excel')){ ?>

	

		$('.DrillDownRow').css('cursor','pointer');

		$(document).on('click',".DrillDownRow", function(){

		var submiteddate = $(this).find("td:first").text();

		

	/*	var todayTimeStamp = +new Date; // Unix timestamp in milliseconds

		var oneDayTimeStamp = 1000 * 60 * 60 * 24; // Milliseconds in a day

		var diff = todayTimeStamp - oneDayTimeStamp;

		var yesterdayDate = new Date(diff);

		var yesterdayString = yesterdayDate.getFullYear() + '-' + (yesterdayDate.getMonth() + 1) + '-' + yesterdayDate.getDate();	

      */  

		var cardno = $(this).find("input[name='child_registration_no']:eq(0)").val();

		var code = $(this).find("td:first").text();

		var distcode = '<?php echo (isset($distcode))?$distcode:0; ?>';
		var distcode_d = '<?php echo (isset($distcode_d))?$distcode_d:0; ?>';
      // alert(distcode_d);
		var tcode = '<?php echo (isset($tcode))?$tcode:0; ?>';
		var tcode_d = '<?php echo (isset($tcode_d))?$tcode_d:0; ?>';

		var uncode = '<?php echo (isset($uncode))?$uncode:0; ?>';
		var uncode_d = '<?php echo (isset($uncode_d))?$uncode_d:0; ?>';
		var facode_d = '<?php echo (isset($facode_d))?$facode_d:0; ?>';
		var techniciancode_d = '<?php echo (isset($techniciancode_d))?$techniciancode_d:0; ?>';

		var techniciancode = '<?php echo (isset($techniciancode))?$techniciancode:0; ?>';
		var typewise = '<?php echo (isset($Type))?$Type:''; ?>'; 

		var datefrom = 0;
		var opt = 1;

		var fmonth = '<?php echo (isset($fmonth))?$fmonth:0; ?>';
		if(code.length==9){

			techniciancode = code;

		}else {

			datefrom = code;

		}
		if(typewise == '' && datefrom != 0 ){
			url = "<?php echo base_url();?>childs/DailyRegisterChildReport/daily_report/?typewise="+typewise+"&datefrom="+datefrom+"&distcode_d="+distcode_d;
       
		} 
		if(distcode_d > 0 ){
			url = "<?php echo base_url();?>childs/DailyRegisterChildReport/daily_report/?techniciancode="+techniciancode+"&datefrom="+datefrom+"&tcode="+tcode+"&uncode="+uncode+"&fmonth="+fmonth+"&opt="+opt+"&distcode_d="+distcode_d+"&tcode_d="+tcode_d+"&uncode_d="+uncode_d+"&facode_d="+facode_d+"&techniciancode_d="+techniciancode_d;
		}
		else{

		url = "<?php echo base_url();?>childs/DailyRegisterChildReport/daily_report/?techniciancode="+techniciancode+"&datefrom="+datefrom+"&tcode="+tcode+"&uncode="+uncode+"&fmonth="+fmonth+"&opt="+opt;
		}
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

<?php } ?>	

</script>

