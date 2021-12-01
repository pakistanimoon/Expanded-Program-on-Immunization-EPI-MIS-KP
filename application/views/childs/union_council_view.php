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
		//print_r($fmonth);exit;
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
		$nmonth = Date("Y-m", strtotime($fmonth . "next month")); 
		$premonth = Date("Y-m", strtotime($fmonth . "previous month"));
		$month = Date("Y-m", strtotime($fmonth));
		
			
		?>	
		
	<a href="<?php echo base_url(); ?>/childs/DailyRegisterChildReport/union_council_report/?datefrom=<?php echo $premonth; ?>&distcode=<?php echo $distcode?>"class="previous round"><strong>&lt;&lt; </strong> </a> <strong><?php echo $month;?></strong>
	<a href="<?php echo base_url(); ?>/childs/DailyRegisterChildReport/union_council_report/?datefrom=<?php echo $nmonth; ?> "class="next round"> <strong>&gt;&gt; </strong></a>
</div>
		<div id="parent">
		<table id="fixTable" class="table table-bordered table-hover table-striped">
		<thead> <tr> 
			<th rowspan="1">DISTCODE</th>
			<th rowspan="1">DISTRICT</th>
			<th rowspan="1">UNCODE</th>
			<th rowspan="1">UC</th>
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
		</tr> </thead>
		<tbody>
			<?php
			foreach($Monthlyresult as $key => $val)	{ ?>
			<tr class="DrillDownRow" style="cursor: pointer;"> 
			<td><?php echo $val['distcode']; ?></td>
			<td><?php echo $val['district']; ?></td>
			<td><?php echo $val['uncode']; ?></td>
			<td><?php echo CrossProvince_UCName($val['uncode']); ?></td>
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
		var distcode = '<?php echo (isset($distcode))?$distcode:0; ?>';
		var tcode  = '<?php echo (isset($tcode))?$tcode:0; ?>';
		var uncode = '<?php echo (isset($uncode))?$uncode:0; ?>';
		var facode = '<?php echo (isset($facode))?$facode:0; ?>';
		var datefrom = 0;
		var fmonth = '<?php echo (isset($fmonth))?$fmonth:0; ?>';
		var code = $(this).find("td:nth-child(3)").text();
		url = "<?php echo base_url();?>Reports/ChildRegistration/?uncode="+code;
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

