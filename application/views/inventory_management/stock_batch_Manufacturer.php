<?php 
	$str1 = str_replace("'","",$data['purpose']);
	$arr1 = explode(",",$str1);
	
	$str2 = str_replace("'","",$data['category']);
	$arr2 = explode(",",$str2);
 ?>

	<center>
		<label>
			<?php if($data['distcode'] !="0"){echo "District : <span style=\"font-weight: 400;\">";echo get_District_Name($data['distcode']);} ?></span><br>
			Purpose :  <span style="font-weight: 400;">
							<?php 
								foreach($arr1 as $values){
								get_purpose_name($returnResult=FALSE,$values);echo ", ";}
							?>
							<br>
						</span>
			Category : <span style="font-weight: 400;">
							<?php 
								foreach($arr2 as $values){
								get_category_name($returnResult=FALSE,$values);echo ", ";}
							?>
						</span>
		</label>
	</center> 
<center>
<label>
Manufacturer Wise Stock Summary</label>
</center>
<center>
				<table  class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>
								
								<th rowspan="2" style="text-align:center;"><label>Product</label></th>
								<th rowspan="2" style="text-align:center;"><label>Manufacturer</label></th>
								<th colspan="2" style="text-align:center;"><label>Quantity</label></th>
							</tr>
							<tr>
								<th style="text-align:center;"><label>Vials/Pcs</label></th>
								<th  style="text-align:center;"><label>Total Doses</label></th>
							</tr>
						</thead>	


<?php
$html="";$j=1;$i=1;
if(isset($searchResult) AND count($searchResult)>0){
								foreach($searchResult as $key=>$onerow){
									?>
									<tr>
										<td style="text-align:center;"><?php echo ($j++); ?></td>
									
										<td><?php echo $onerow["itemname"]; ?></td>
										<td><?php echo $onerow["manufacturer"]; ?></td>
										<td style="text-align:center;"><?php  echo $onerow["quantity"]; ?></td>
										<td style="text-align:center;"><?php echo ($onerow["doses"]* $onerow["quantity"]); ?></td>
										
									</tr><?php
							
								
								}
}
	
?>
</center>						
</table>
<center><label style="color:red">Manufacturer wise expired stock summary</label></center>
<center>
<table class="table table-bordered table-condensed" >
										
					   <thead>
							<tr>
								<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>
								<th rowspan="2" style="text-align:center;"><label>Product</label></th>
								<th rowspan="2" style="text-align:center;"><label>Manufacturer</label></th>
								<th colspan="2" style="text-align:center;"><label>Quantity</label></th>
							</tr>
							<tr>
								<th style="text-align:center;"><label>Vials/Pcs</label></th>
								<th  style="text-align:center;"><label>Total Doses</label></th>
							</tr>
						</thead>	
								 <?php echo $html;?>
								
</table>				
</center>	
<br></br>
<label>Prepared By : </label><?php echo $this->session->username;?>
<label>Print Date : </label><?php echo date('Y-m-d');?>			 
									