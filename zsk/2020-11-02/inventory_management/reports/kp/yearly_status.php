<?php 
//kp
	$store = ''; ?>
<!--start of page content or body-->
<?php 	if (!$this -> input -> post('export_excel')) {?>
<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Monthly Stock <?php $indtitle="";if(isset($indicator)){switch($indicator){case 1:$indtitle="Issued";break;case 2:$indtitle="Received";break;case 3:$indtitle="Stock In Hand";break;}echo $indtitle; } ?> (Vials/Pieces) Report at <?php 
				if(isset($wh_code)){
					if($wh_code=="all")
					{
						echo $store="All Districts";
					}
					else{
						echo $store = get_store_name(TRUE,$wh_type,$wh_code); 
					} 
				}?> for (<?php if(isset($year)){ echo 'Year '.$year; } ?>) - Transactions
				<div class="pull-right">
					<a href="javascript:void(1);" id="graphicalview" style="color:#000000;font-size: 24px;" title="Graphical View">
						<span class="icon fa fa-bar-chart"></span>
					</a>
					<!--<img class="handland" data-original-title="Excel" onclick="document.getElementById('export-form').submit()" src="http://epimis1.pacetec.net/includes/images/excel.png" style="height:26px;" alt="img-excel" data-toggle="tooltip" title="" data-placement="bottom">-->
				</div>
			</div>
			<div class="panel-body">
				<!--<table class="table table-bordered   table-striped table-hover  mytable">
					<tr>
						<td><label>Warehouse Level</label></td> 
						<td><?php //if(isset($wh_type)){ echo get_warehouse_type_name(FALSE,$wh_type); } ?></td>
						<td><label>Warehouse Store</label></td>
						<td><?php //echo $store; ?></td>
					</tr>
					<tr>
						<td><label>Year</label></td>
						<td><?php //if(isset($year)){ echo $year; } ?></td>
						<td><label>Indicator</label></td>
						<td><?php //echo $indtitle; ?></td>
					</tr>
				</table>-->
<?php }?>
				<table class="table table-bordered table-condensed table-striped table-hover mytable" border="1">
					<thead>
						<tr>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Product</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Activity</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Jan - <?php echo $label = date("y",strtotime($year."-01-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Feb - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Mar - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Apr - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">May - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Jun - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Jul - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Aug - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Sep - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Oct - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Nov - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Dec - <?php echo $label; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						//$titlerow = $receiverow = $issuerow = $balancerow = '';
						foreach($reportdata as $key=>$row){
							$totalrow = 0;
							/* $titlerow 	.= '<th>'.$row['name'].'</th>';
							$receiverow .= '<td>'.$row['receivebalance'].'</td>';
							$issuerow .= '<td>'.$row['issuebalance'].'</td>';
							$balancerow .= '<td>'.($row['prevbalance']+$row['receivebalance']-$row['issuebalance']).'</td>';
							*/?>
							<tr>
								<th style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["item_name"]; ?> </th>
								<th style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["activity"]; ?> </th>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm1"];$totalrow += $row["totalm1"];@$totalm1 += $row["totalm1"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm2"];$totalrow += $row["totalm2"];@$totalm2 += $row["totalm2"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm3"];$totalrow += $row["totalm3"];@$totalm3 += $row["totalm3"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm4"];$totalrow += $row["totalm4"];@$totalm4 += $row["totalm4"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm5"];$totalrow += $row["totalm5"];@$totalm5 += $row["totalm5"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm6"];$totalrow += $row["totalm6"];@$totalm6 += $row["totalm6"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm7"];$totalrow += $row["totalm7"];@$totalm7 += $row["totalm7"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm8"];$totalrow += $row["totalm8"];@$totalm8 += $row["totalm8"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm9"];$totalrow += $row["totalm9"];@$totalm9 += $row["totalm9"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm10"];$totalrow += $row["totalm10"];@$totalm10 += $row["totalm10"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm11"];$totalrow += $row["totalm11"];@$totalm11 += $row["totalm11"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm12"];$totalrow += $row["totalm12"];@$totalm12 += $row["totalm12"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalrow;@$totalm13 += $totalrow; ?></td>
								<!--<td <?php //echo ($row["receive"])?'class="drilldownCell" data-class="receive" data-month="'.$row["repmonth"].'"':''; ?>><?php //echo $row["receive"]; ?></td>
								<td <?php //echo ($row["issue"])?'class="drilldownCell" data-class="issue" data-month="'.$row["repmonth"].'"':''; ?>><?php //echo $row["issue"]; ?></td>
								<td <?php //echo ($row["pending"])?'class="drilldownCell" data-class="pending" data-month="'.$row["repmonth"].'"':''; ?>><?php //echo $row["pending"]; ?></td>-->
							</tr><?php
						}
						if(!empty($reportdata)){?>
							<tr>
								<th style="text-align:center; border: 1px solid black;" class="text-center" colspan="2">Total</th>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm1; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm2; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm3; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm4; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm5; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm6; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm7; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm8; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm9; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm10; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm11; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm12; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $totalm13; ?></td>
							</tr><?php
						}?>
					</tbody>
				</table>
				<?php 	if (!$this -> input -> post('export_excel')) {?>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!--<script src="<?php //echo base_url(); ?>includes/js/tableHeadFixer.js"></script>-->
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	/* $('.drilldownCell').css('cursor','pointer');
	$(document).on('click','.drilldownCell',function(){
		var type = $(this).data("class");
		var month = $(this).data("month");
		var curRow = $(this).closest('tr');
		curRow.closest('table').find('.expandable').remove();
		if(curRow.hasClass('expanded')){
			curRow.removeClass('expanded');
		}else{
			curRow.closest('table').find('tr.expanded').removeClass('expanded');
			curRow.addClass('expanded');
			$.ajax({
				type: "POST",
				datatype: "JSON",
				data: {wh_type_id: <?php echo $wh_type; ?>,wh_code:<?php echo $wh_code; ?>,type:type,month:month},
				url: "<?php echo base_url("inventory_status_detail"); ?>",
				success: function(resultt){
					result = JSON.parse(resultt);					
					var innertable = '<tr class="expandable"><td colspan="4"><table class="table table-bordered table-condensed table-striped table-hover mytable"></thead><th>Sr #</th><th>Transaction Date</th><th>Created On</th><th>Transaction Number</th>';
					if(type=="receive" || type=="pending"){
						innertable+='<th>Receive From</th>';
					}else if(type=="issue"){
						innertable+='<th>Issue To</th>';
					}
					innertable += '</thead><tbody>';
					$.each(result,function(i,item){
						innertable += '<tr><td>'+(i+1)+'</td><td>'+item["transaction_date"]+'</td><td>'+item["created_date"]+'</td><td>'+item["transaction_number"]+'</td><td>'+item["store"]+'</td></tr>';
					});
					innertable += '</tbody></table></td></tr>';
					curRow.after(innertable);
				}
			});
		}
	}); */
	
	$("#graphicalview").click(function(){
		var curraction = $("#export-form").attr("action");
		$("#export-form").attr("action","<?php echo base_url("inventory/Charts/yearly_status"); ?>");
		$("#export-form").attr("target","_blank");
		$("#export-form").submit();
		$("#export-form").attr("action",curraction);
		$("#export-form").attr("target","");
	});
});
				<?php }?>
</script>