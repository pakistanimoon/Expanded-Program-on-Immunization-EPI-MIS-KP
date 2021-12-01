<?php 
$tableId = 'widgetname'.$pk_id; 
?>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-striped table-hover" style="margin-top:10px;">
			<thead>
				<tr style="background-color:#bdd9f5;">
					<th>Code</th>
					<th>Name</th>
					<?php 
					if($multiseries == 1){
						for($i=1;$i<=$noofseries;$i++){
					?>
						<th><?php echo (isset($seriesNames[$i-1]['series_name']))?$seriesNames[$i-1]['series_name']:'Series'.$i; ?> <?php echo getIndicatorName(false,$indicator_id); ?> for <?php echo getSubIndicatorName(false,$sub_indicator_id); ?></th>
					<?php 
						}
					}else{ ?>
						<th>Value <?php echo getIndicatorName(false,$indicator_id); ?> for <?php echo getSubIndicatorName(false,$sub_indicator_id); ?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($result as $key => $value){ ?>
					<tr>
						<td><?php echo $value['code']; ?></td>
						<td><?php echo $value['name']; ?></td>
						<?php
						if($multiseries == 1){
							for($j=0;$j<$noofseries;$j++){
								$num = $j+1;
								if(isset($seriesNames[$j]['extra_value_divider']) && $seriesNames[$j]['extra_value_divider'] > 0){
									?><td><?php echo (isset($value["value{$num}"]))?round($value["value{$num}"]/$seriesNames[$j]['extra_value_divider'],2):''; ?></td><?php 
								}
								else{
									?><td><?php echo (isset($value["value{$num}"]))?round($value["value{$num}"],2):''; ?></td><?php 
								}								
							}
						}else{ ?>
						<td><?php echo (isset($value['value']))?round($value['value'],2):''; ?></td>
						<?php } ?>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>