<div class="container bodycontainer">
	<?php echo $data['TopInfo']; ?>
	
	<div id="parent">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th rowspan="2" style="min-width: 56px;">District Code</th>
					<th rowspan="2" style="min-width:100px;">District Name</th>
					<?php foreach($firstHeaderArray as $headername){ ?>
						<th colspan="<?php echo $secondHeaderCount; ?>"><?php echo $headername; ?></th>
					<?php } ?>
					<th colspan="<?php echo $secondHeaderCount; ?>">Grand Total</th>
				</tr>
				<tr>
					<?php 
					for($i=0;$i<=$firstHeaderCount;$i++){
						foreach($secondHeaderArray as $headername){ ?>
						<th><?php echo $headername; ?></th>
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
						<td><?php echo $val ?></td>
					<?php
					} 
					?>
					</tr>
				<?php
				}
				echo "<tr><td></td><td  class='text-center'><strong> Total: </strong></td><td style='background-color: grey'>";
				echo implode("</td><td style='background-color: grey'>",$total);
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