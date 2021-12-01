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
			$nextdate = Date("Y-m-d", strtotime($selecteddate . " next day")); 
			$predate = Date("Y-m-d", strtotime($selecteddate . " previous day"));
			$date = Date("Y-m-d", strtotime($selecteddate));
		?>	
	<a href="<?php echo base_url(); ?>/childs/DailyRegisterChildReport/monthly_report/?
				reportType=<?php echo 'singledate_technicianwise'; ?>&
				monthdate=<?php echo $predate; ?>&
				distcode=<?php if (isset($distcode)){echo $distcode;}?>&
				tcode=<?php if (isset($tcode)){echo $tcode;}?>&
				uncode=<?php if (isset($uncode)){echo $uncode;}?>&
				facode=<?php if (isset($facode)){echo $facode;}?>&
				techniciancode=<?php if (isset($techniciancode)){echo $techniciancode;}?>" class="previous round"><strong>&lt;&lt; </strong>
	</a> 
		<strong>
			<?php echo $date;?>
		</strong>
	<a href="<?php echo base_url(); ?>/childs/DailyRegisterChildReport/monthly_report/?
				reportType=<?php echo 'singledate_technicianwise'; ?>&
				monthdate=<?php echo $nextdate; ?>&
				distcode=<?php if (isset($distcode)){echo $distcode;}?>&
				tcode=<?php if (isset($tcode)){echo $tcode;}?>&
				uncode=<?php if (isset($uncode)){echo $uncode;}?>&
				facode=<?php if (isset($facode)){echo $facode;}?>&
				techniciancode=<?php if (isset($techniciancode)){echo $techniciancode;}?>" class="next round"> <strong>&gt;&gt; </strong>
	</a>
</div>
	<div id="parent">
			<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th rowspan="3">Technician Code</th>	
					<th rowspan="3">Technician Name</th>
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
					<th rowspan="1">Total Child Vaccinated</th>
				</tr>			
			</thead>
			<tbody>
		<?php
			foreach($Monthlyresult as $key => $val)	
			{ ?>
					<tr class="DrillDownRow" style="cursor: pointer;">
					<td><?php echo $val['techniciancode']; ?></td> 
					<td><?php echo $val['technicianname']; ?></td>
					<td><?php echo $val['bcgcount']; ?></td>
					<td><?php echo $val['hepbcount']; ?></td>
					<td><?php echo $val['opv0count']; ?></td>
					<td><?php echo $val['opv1count']; ?></td>
					<td><?php echo $val['opv2count']; ?></td>
					<td><?php echo $val['opv3count']; ?></td>
					<td><?php echo $val['penta1count']; ?></td>
					<td><?php echo $val['penta2count']; ?></td>
					<td><?php echo $val['penta3count']; ?></td>
					<td><?php echo $val['pcv1count']; ?></td>
					<td><?php echo $val['pcv2count']; ?></td>
					<td><?php echo $val['pcv3count']; ?></td>
					<td><?php echo $val['ipvcount']; ?></td>
					<td><?php echo $val['rota1count']; ?></td>
					<td><?php echo $val['rota2count']; ?></td>
					<td><?php echo $val['measles1count']; ?></td>
					<td><?php echo $val['measles2count']; ?></td>
					<td><?php echo $val['total_children_vaccinated']; ?></td>
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
	var techniciancode = $(this).find("td:first").text();
	var monthdate = '<?php echo (isset($monthdate))?$monthdate:''; ?>'; 
	var distcode = '<?php echo (isset($distcode))?$distcode:''; ?>'; 
	var tcode = '<?php echo (isset($tcode))?$tcode:''; ?>'; 
	var uncode = '<?php echo (isset($uncode))?$uncode:''; ?>'; 
	var facode = '<?php echo (isset($facode))?$facode:''; ?>'; 
	var reportType = '0';
	var drilldownType='techniciancode';
	url = "<?php echo base_url();?>childs/DailyRegisterChildReport/monthly_report/?monthdate="+monthdate+"&distcode="+distcode+"&tcode="+tcode+"&uncode="+uncode+"&facode="+facode+"&techniciancode="+techniciancode+"&drilldownType="+drilldownType;
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