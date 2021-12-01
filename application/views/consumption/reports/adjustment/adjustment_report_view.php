<?php 

//echo "<pre>"; print_r($searchResult);exit;

$store = ''; ?>
<!--start of page content or body-->
 <div class="container bodycontainer">
  <?php 	if (!$this -> input -> post('export_excel')) {?>
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading">Vaccine Consumption Adjustment Report at <?php if(isset($wh_code)){
	   if($wh_code=="all"){
	   echo $store ="All Districts";
	   }
	   else{
	   echo $store = get_store_name(TRUE,$wh_type,$wh_code);} } ?> for (<?php if(isset($monthfrom)){ echo $monthfrom; } ?>) to (<?php if(isset($monthto)){ echo $monthto; } ?>) - Vials</div>
	   

     <div class="panel-body">
       <form class="form-horizontal"> 
        <table class="table table-bordered   table-striped table-hover  mytable">
			<tr>
				
				<?php if(isset($distcode) && $distcode > 0){ echo "<td><label>District</label></td>"; echo "<td>".DistrictName($distcode)."</td>"; }  ?> 
				<?php if(isset($tcode) && $tcode > 0){ echo "<td><label>Tehsil</label></td>"; echo "<td>".get_Tehsil_Name($tcode)."</td>"; } ?>
				<?php if(isset($uncode) && $uncode > 0){ echo "<td><label>Union Council</label></td>"; echo "<td>".get_UC_Name($uncode)."</td>"; } ?>
			</tr>
			<tr>
				<?php if(isset($facode) && $facode){ echo "<td><label>Facility</label></td>"; echo "<td>".get_Facility_Name($facode)."</td>"; } ?>
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
			<th><label>Sr #</label></th>	
			<th><label>District Code</label></th>	
			<th><label>District Name</label></th>	
			<th><label>Tehsil Code</label></th>	
			<th><label>Tehsil Name</label></th>	
			<th><label>UC Code</label></th>		
			<th><label>UC Name</label></th>
			<th><label>Fa Code</label></th>
			<th><label>Facility Name</label></th>
			<th><label>Facility Month</label></th>
			<th><label>Item Name</label></th>
			<th><label>Batch Number</label></th>
			<th><label>Adjustment Name</label></th>
			<th><label>Adjustment Quantity vials</label></th>
			<th><label>Adjustment Quantity Doses</label></th>
		</tr>	
	</thead>
		<tbody>
		<?php 
		
		foreach($searchResult as $key=>$row){
		?>
				<tr>
					<td><?php echo $key+1;?></td>
					<td><?php echo $row['distcode'];?></td>
					<td><?php echo $row['distname'];?></td>
					<td><?php echo $row['tcode'];?></td>
					<td><?php echo $row['tehsilnam'];?></td>
					<td><?php echo $row['uncode'];?></td>
					<td><?php echo $row['unname'];?></td>
					<td><?php echo $row['facode'];?></td>
					<td><?php echo $row['facilityname'];?></td>
					<td><?php echo $row['fmonth'];?></td>
					<td><?php echo $row['item_name'];?></td>
					<td><?php echo $row['batch_number'];?></td>
					<td><?php echo $row['adjustmentname'];?></td>
					<td><?php echo $row['adjustment_quantity_vials'];?></td>
					<td><?php echo $row['adjustment_quantity_doses'];?></td>
				</tr>	
			<?php 
		
			
		
		 } ?>
		</tbody>
  
  </table>
  
		<?php 	if (!$this -> input -> post('export_excel')) {?>
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
<?php }?> 