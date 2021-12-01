<?php 
	$str1 = str_replace("'","",$data['purpose']);
	$arr1 = explode(",",$str1);
	
	$str2 = str_replace("'","",$data['category']);
	$arr2 = explode(",",$str2);
 ?>

			<center>
				<label>
			    <?php if($this -> session -> UserLevel==4){ ?>
					<?php if($data['tcode'] !="0"){echo "Tehsil : <span style=\"font-weight: 400;\">";echo get_Tehsil_Name($data['tcode']);} ?></span><br>
				<?php } else {?>
					<?php if($data['distcode'] !="0"){echo "District : <span style=\"font-weight: 400;\">";echo get_District_Name($data['distcode']);} ?></span><br>
				<?php } ?>	
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
<label>Batch wise stock summary</label>
</center>

<center>
<table class="table table-bordered table-condensed" >

							<tr>

								<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>

								<th rowspan="2" style="text-align:center;"><label>Product</label></th>	
								<th rowspan="2" style="text-align:center;"><label>Purpose</label></th>
								<th rowspan="2" style="text-align:center;"><label>Batch Number</label></th>																
								<th rowspan="2" style="text-align:center;"><label>Manufacturer</label></th>																
								<th rowspan="2" style="text-align:center;"><label>VVM Name</label></th>																
								<th rowspan="2" style="text-align:center;"><label>Expire Date</label></th>																
								<th rowspan="2" style="text-align:center;"><label>Quantity</label></th>																
								<th rowspan="2" style="text-align:center;"><label>VVM Type Id</label></th>																
								<th rowspan="2" style="text-align:center;"><label>Placment</label></th>																
								<th rowspan="2" style="text-align:center;"><label>Priority</label></th>

								<th colspan="3" style="text-align:center;"><label>Quantity</label></th>

							</tr>

							<tr>

							<th style="text-align:center;"><label>Vials/Pcs</label></th>

							<th style="text-align:center;"><label>Doses Per Vials</label></th>

							<th style="text-align:center;"><label>Total Doses</label></th>

							</tr>

						<?php 

						if(isset($searchResult) AND count($searchResult)>0){

								foreach($searchResult as $key=>$onerow){?>

									<tr>

										<td style="text-align:center;"><?php echo ($key+1); ?></td>

										<td><?php echo $onerow["itemname"]; ?></td>				<td><?php echo $onerow["purpose"]; ?></td>							<td><?php echo $onerow["batch"]; ?></td>										<td><?php echo $onerow["manufacturer"]; ?></td>										<td><?php echo $onerow["vvm_name"]; ?></td>										<td><?php echo $onerow["exp_date"]; ?></td>										<td><?php echo $onerow["quantity"]; ?></td>										<td><?php echo $onerow["vvm_type"]; ?></td>										<td><?php echo $onerow["placment"]; ?></td>										<td><?php echo $onerow["priority"]; ?></td>


										<td style="text-align:center;"><?php echo $onerow["quantity"]; ?></td>

										<td style="text-align:center;"><?php echo $onerow["doses"]; ?></td>

										<td style="text-align:center;"><?php echo ($onerow["doses"]*$onerow["quantity"]); ?></td>

										

										

								</tr><?php

								}

							}?>

															

</table>
</center>

