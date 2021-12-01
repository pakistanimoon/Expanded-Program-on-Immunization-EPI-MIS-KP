<?php
print_r($result);
/*	$arr=array();$i=0;
 echo '<table border="1" cellpadding="0">';
foreach ($result as $key=>$value){
$arr[$value['to_warehouse_code']][]['sum']=$value['sum'];
$arr[$value['to_warehouse_code']][]['id']=$value['id'];
}
echo '<pre>';print_r($arr);echo '</pre>';
 foreach ($arr as $key=>$value)
{
		//echo '<pre>';print_r($value);echo '</pre>';
		//echo $key;
		 foreach($value as $k1=>$v1){
			echo '<tr>';echo '<td>';echo $k1;echo '</td>';echo '<td>'; print_r($v1);echo '</td>';echo '</tr>';
		} 
}  */

$store='';
?>
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading">Vaccine Distribution Report at <?php if(isset($wh_code)){echo $store = get_store_name(TRUE,$wh_type,$wh_code); } ?> for (<?php if(isset($monthfrom)){ echo $monthfrom; } ?>) to (<?php if(isset($monthto)){ echo $monthto; } ?>) - Vials</div>
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
		
</div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->		