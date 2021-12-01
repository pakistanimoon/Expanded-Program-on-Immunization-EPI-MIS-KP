<div class="container bodycontainer">

	<?php echo $data['TopInfo']; ?>

	

	<div id="parent">

		<table id="fixTable"  class="table table-bordered table-hover table-striped">

			<thead>

				<tr>

					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" style="min-width: 56px;">District Code</th>

					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" style="min-width:100px;">District Name</th>

					<?php foreach($firstHeaderArray as $headername){ ?>

						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="<?php echo $secondHeaderCount; ?>"><?php echo $headername; ?></th>

					<?php } ?>

					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="<?php echo $secondHeaderCount; ?>">Grand Total</th>

				</tr>

				<tr>

					<?php 

					for($i=0;$i<=$firstHeaderCount;$i++){

						foreach($secondHeaderArray as $headername){ ?>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $headername; ?></th>
										 

					<?php 

						}

					}

					?>

				</tr>

			</thead>

			<tbody>

			<?php

				$total = array();

				foreach($totalResult as $trkey => $trvalue)

				{

					foreach($trvalue as $key => $value){

						if($key != "distcode" && $key != "districtname"){

							if(key_exists($key,$total))

							{

								$total[$key] += $value;

							}

							else

								$total[$key] = $value;

						}

					}

				}

				foreach($totalResult as $value){ ?>

					<tr>

					<?php

					foreach($value as $val){ ?>
						<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $val ?></td>
								 

					<?php

					} 

					?>

					</tr>

				<?php

				}

				echo "<tr><td></td><td  class='text-center'><strong> Total: </strong></td><td>";

				echo implode("</td><td>",$total);

				echo "</td></tr>";

			?>

			</tbody>

		</table>



	</div>





</div><!--End of page content or body-->





<!--start of footer-->

<br>

<br>



<!--JS -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>

<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">

	$(document).ready(function(){

		$("#fixTable").tableHeadFixer({"left" : 2});

	});

</script>