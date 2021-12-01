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
//ECHO "<PRE>";  print_r($data);exit;
//print_r($Monthlentry); exit();
	 ?>
	<div id="parent" style="overflow:auto">                
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="2">Un Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="2">Uc Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="2">Submit on </th>
				</tr>	
			</thead>
			<tbody id="tbody">  
				<?php
				//$techniciancode = [$childDataview]['techniciancode'];
					foreach($Monthlentry as $key => $val){
						
						if(isset($val['uncode'] ) ){
								echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'>";
								$uncode = $val['uncode'];
								echo $uncode;
								echo "<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'>";
								$unname = $val['unname'];
								echo $unname; 
								echo "<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'>";
								$submitteddate = $val['submitteddate'];
								echo $submitteddate;
						}
							echo "</tr>";
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
  </script>
