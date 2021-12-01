<?php $store = ''; ?>
<!--start of page content or body-->
 <div class="container bodycontainer">
  <?php 	if (!$this -> input -> post('export_excel')) {?>
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading">Vaccine Distribution Report at <?php if(isset($wh_code)){
	   if($wh_code=="all"){
	   echo $store ="All Districts";
	   }
	   else{
	   echo $store = get_store_name(TRUE,$wh_type,$wh_code);} } ?> for (<?php if(isset($monthfrom)){ echo $monthfrom; } ?>) to (<?php if(isset($monthto)){ echo $monthto; } ?>) - Vials</div>
     <div class="panel-body">
       <form class="form-horizontal"> 
        <table class="table table-bordered   table-striped table-hover  mytable">
			<tr>
				<td><label>Warehouse Level</label></td> 
				<td><?php if(isset($wh_type)){ echo get_warehouse_type_name(FALSE,$wh_type); } ?></td>
				<td><label>Warehouse Store</label></td>
				<td><?php echo $store; ?></td>
			</tr>
			<tr>
				<td><label>Month From</label></td>
				<td><?php if(isset($monthfrom)){ echo $monthfrom; } ?></td>
				<td><label>Month To</label></td>
				<td><?php if(isset($monthto)){ echo $monthto; } ?></td>
			</tr>
		</table>
  <?php }?>
  <table class="table table-bordered table-condensed table-striped table-hover mytable" border="1">
	<thead>
		<tr>				
			<th rowspan="2" ><label>Purpose</label></th>	
			<th rowspan="2" ><label>Product</label></th>	
			<th rowspan="2" ><label>Opening Balance</label></th>	
			<th rowspan="2" ><label>Received</label></th>		
			<th rowspan="2" ><label>Issue</label></th>		
			<th colspan="2" style="text-align:center;"><label>Adjustment</label></th>
			<th rowspan="2" ><label>Closing Balance</label></th>
				   
		
	   
			
		
	   
		 
		
	   
				   
		
		</tr>
		
		<tr>							
			<th ><label>Positive</label></th>		
			<th ><label>Negative</label></th>						
		</tr>	
			
			
		
		
	
			<tbody>
		<?php 
		$i = 1;
		$titlerow = $receiverow = $issuerow = $closingbalancerow = $openingbalancerow = ''; 
		foreach($reportdata as $key=>$row){
				if($i == 1 ) {
					 echo   "<tr><td style='text-align:center; font-weight: bold' rowspan='14'>".$row['activity'].'</td>';
				 }
			    else  if($i == 15 ) {
					 echo   "<td style='text-align:center; font-weight: bold' rowspan='6'>".$row['activity'].'</td>';
				 }
				else if($i >= 21 and $i < 23){
					 echo   "<td style='text-align:center; font-weight: bold' rowspan=''>".$row['activity'].'</td>';
				}
				else if($i == 23){
					 echo   "<td style='text-align:center; font-weight: bold' rowspan='5'>".$row['activity'].'</td>';
				}
				else{
					
				}
			     echo   '<td>'.$row['name'].'</td>';
			     echo   '<td>'.$row['prevbalance'].'</td>';
			     echo   '<td>'.$row['receivebalance'].'</td>';
			     echo   '<td>'.$row['issuebalance'].'</td>';	
				 echo   '<td>'.$row['adjustment_post'].'</td>';		
				 echo   '<td>'.$row['adjustment_negat'].'</td>';
				 
			     echo   '<td>'.($row['prevbalance']+$row['receivebalance']-$row['issuebalance']+$row['adjustment_post']-$row['adjustment_negat']).'</td>';
				 
				 

			
			$i++;
		//exit;		
		?>
		</tr>
		
		<?php } ?>
		</tbody>
  </thead>
  </table>
  
	<!---	<table class="table table-bordered table-condensed table-striped table-hover mytable" border="1">
			<thead>
				<tr>
					<th>Purpose</th>
				<!---	<php/*  foreach($reportdata as $key=>$row){
						echo 	$row['activity'];
					} */ ?> ----<
				</tr>
				<php 
				
				$titlerow = $receiverow = $issuerow = $closingbalancerow = $openingbalancerow = '';
				foreach($reportdata as $key=>$row){
					
					//$activity 	= '<th>' .$row['activity']. '</th>';
					//echo "<pre>"; print_r($reportdata);exit;
					
					$titlerow 	.= '<th>'.$row['name'].'</th>';
					$openingbalancerow .= '<td>'.$row['prevbalance'].'</td>';
					$receiverow .= '<td>'.$row['receivebalance'].'</td>';
					$issuerow .= '<td>'.$row['issuebalance'].'</td>';
					$closingbalancerow .= '<td>'.($row['prevbalance']+$row['receivebalance']-$row['issuebalance']).'</td>';
				} ?> 
				<tr>
					<th>Product</th>
					<php echo $titlerow; ?>
				</tr>
			</thead>
			<tbody>
			
				<tr class="drilldownview">
					<td>Opening Balance</td>
			 		<php echo $openingbalancerow; ?>
				</tr>
				<tr class="drilldownview">
					<td>Received</td>
					<php echo $receiverow; ?>
				</tr>
				<tr class="drilldownview">
					<td>Issue</td>
					<php echo $issuerow; ?>
				</tr>
				<tr class="drilldownview">
					<td>closing Balance</td>
			 		<php echo $closingbalancerow; ?>
				</tr>
			</tbody>
		</table>----->
		<?php 	if (!$this -> input -> post('export_excel')) {?>
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  
<?php
	$monthfrom	= $this->input->post('monthfrom');
	$monthto	= $this->input->post('monthto');
	$whtype		= $this->input->post('warehouse_level');
	//echo $whtype; exit;
	$whcode		= $this->input->post('warehouse_store');
	$report_type	= $this->input->post('report_type'); 
?>
</div><!--End of page content or body-->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>

$(".drilldownview").click(function () {
	
	var monthfrom = <?php echo $monthfrom; ?>;
	var monthto = <?php echo $monthto; ?>;
	var whtype = <?php echo $whtype; ?>;
	//alert('whtype'+whtype); 
	var whcode ='<?php echo $whcode; ?>';
	var report_type = <?php echo $report_type; ?>; 
	$.ajax({
	type: "POST",
	data: {monthfrom:monthfrom, monthto:monthto, whtype:whtype, whcode:whcode, report_type:report_type},
	url: "<?php echo base_url(); ?>Reports/Detail_Vacc_Distribution",
	success: function(result){
		var result = JSON.parse(result);
		var d = result.index;
		}
	});
});
	<?php }?>	
</script>