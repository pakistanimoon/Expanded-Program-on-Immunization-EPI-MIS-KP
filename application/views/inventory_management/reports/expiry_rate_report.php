<?php // print_r($data); exit; ?>

 <?php 	if (!$this -> input -> post('export_excel')) {?>

<!--start of page content or body-->

<div class="container bodycontainer">

	<div class="row">

		<div class="panel panel-primary">

			<div class="panel-heading">Expiry Rate Report at <?php if(isset($wh_code)){

				if($wh_code=="all"){

				echo $store ="All Districts";

				}

				else{

				echo $store = get_store_name(TRUE,$wh_type,$wh_code);} } ?> for (<?php if(isset($monthfrom)){ echo $monthfrom; } ?>) to (<?php if(isset($monthto)){ echo $monthto; } ?>) - Vials</div>

			<div class="panel-body">

				<form class="form-horizontal">

					<table class="table table-bordered table-striped table-hover  mytable">

					<!--	<div class="panel-heading !important" style='text-align:center; font-size:14px; font-weight:bold; font-family:Helvetica; color:white;'> <?php //if($wh_type=='2'){ echo "Provincial"}elseif( ?> : Expiry Rate</div> -->

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

						<thead style="background-color:#008d4c !important;">

							<tr>

							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Product</th>

							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Received Quantity</th>

							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Expired Quantity</th>

							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Expiry Rate %</th>

							</tr>        

						</thead>

						<tbody>

								<?php

								$serial = 'A'; 

								foreach($tabledata as $key=>$row)

								{	

									$item_name=$row['item_name'];

									$quantity=$row['quantity'];

									$expired_value=$row['expired'];

									if($quantity > 0){

									$expired_percent = ($expired_value /$quantity)*100;

									}

									else{

									$expired_percent=0;

									}

									$e_percent = number_format($expired_percent, 2);

									echo '<tr>';

										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$item_name.'</td>';

										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$quantity.'</td>';

										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$expired_value.'</td>';

										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$e_percent.'</td>';

									echo '</tr>';

									$serial = 'B';

								}

								if ($serial=='A')

								{

									echo '<td colspan="4" style="text-align:center;">No data found.</td>';

								}

								?>

						</tbody>

					</table>

					 <?php 	if (!$this -> input -> post('export_excel')) {?>

					<div class="row">

						<div class="col-sm-4">

							<table class="table table-bordered table-striped">

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div class="row">

						<div style="text-align: right;" class="col-md-4 col-md-offset-8">

						</div>

					</div>    

				</form>

			</div> <!--end of panel body-->

		</div> <!--end of panel panel-primary-->

	</div><!--end of row-->

</div><!--End of page content or body-->

					 <?php }?>