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

<center><label style="padding:5px">Priority Vaccines Distribution (Detail)</label></center>
<table class="table table-bordered table-condensed mytable3">
						<thead>
							<tr>
								<th style="padding-top: 10px; padding-bottom: 10px;width:10%">Batch status</th>
								<th style="padding-top: 10px; padding-bottom: 10px;">Description</th>
							</tr>
						</thead>
						<tbody>
						<tr>
								<th style="padding-left:10px;"><label>Unuseable</label></th>
								<td style="padding-left:10px;">If batch is expired.</td>
						</tr>
						</tr>
							<tr>
								<th style="padding-left:10px;"><label>Priority 1</label></th>
								<td style="padding-left:10px;">If VVM stage is 2 or expiry is less than 3 months.</td>
							</tr>
							<tr>
								<th style="padding-left:10px;"><label>Priority 2</label></th>
								<td style="padding-left:10px;">If VVM stage is 1 and expiry is more than 3 months and less than 12 months.</td>
							</tr>
							<tr>
								<th style="padding-left:10px;"><label>Priority 3</label></th>
								<td style="padding-left:10px;">If VVM stage is 1 and expiry is more than 12 months.</td>
							</tr>
							
						</tbody>
					</table>

<center>
<table  class="table table-bordered table-condensed"  >
					<tr>
						<thead>
								<th style="text-align:center;"><label>Activity-Purpose</label></th>
								<th style="text-align:center;"><label>Product</label></th>
								<th style="text-align:center;"><label>Batch</label></th>
								<th style="text-align:center;"><label>Priority</label></th>
								<th style="text-align:center;"><label>Doses</label></th>
								<th style="text-align:center;"><label>Quantity</label></th>
								
						</thead>				
					</tr>
<?php	
		foreach($searchResult as $key=>$value)
		{
				echo '<tr>';
						echo '<td>';echo $value['activity_type_id'];echo '</td>';
						echo '<td>';echo $value['itemname'];echo '</td>';
						echo '<td>';echo $value['batch'];echo '</td>';
						echo '<td>';echo $value['priority'];echo '</td>';
						echo '<td>';echo $value['doses'];echo '</td>';
						echo '<td>';echo $value['sum'];echo '</td>';				
				 echo '</tr>';
		}
	echo '</table>';	
	?>
</center>