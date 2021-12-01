<?php $store = ''; 
$yearmonth=getMonthsFromEndMonth($year.'-'.$month);
	if (!$this -> input -> post('export_excel')) {
?>
<!--start of page content or body-->
<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">Stock Movement Report  <?php echo date("M y",strtotime($year.'-'.$month."-01")); ?></div>
			<div class="panel-body">
				<table class="table table-bordered   table-striped table-hover  mytable">
					<tr>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><label>From Warehouse Store</label></td> 
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($wh_type)){
						if($wh_code=="all")
								{
									echo "All Districts";
								}
								else{
								echo get_store_name(false,$wh_type,$wh_code); }} ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><label>TO Warehouse Store</label></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($to_wh_type)){ 
								if($to_wh_code=="all")
								{
									echo "All Districts";
								}
								else{
								echo get_store_name(false,$to_wh_type,$to_wh_code); }} ?></td>
					</tr>
					<tr>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Year</label></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($year)){ echo $year; } ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Indicator</label></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($indicator)){switch($indicator){case 1:$indtitle="Issue";break;case 2:$indtitle="Receive";break;case 3:$indtitle="Stock In Hand";break;}echo $indtitle; } ?></td>
					</tr>
				</table>
	<?php }?>
				<table class="table table-bordered table-condensed table-striped table-hover mytable" border="1" >
					<thead>
						<tr>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Product</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[0]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[1]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[2]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[3]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[4]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[5]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[6]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[7]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[8]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[9]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[10]."-01")); ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;"><?php echo $label = date("M-y",strtotime($yearmonth[11]."-01")); ?></th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						//$titlerow = $receiverow = $issuerow = $balancerow = '';
						foreach($reportdata as $key=>$row){
							/* $titlerow 	.= '<th>'.$row['name'].'</th>';
							$receiverow .= '<td>'.$row['receivebalance'].'</td>';
							$issuerow .= '<td>'.$row['issuebalance'].'</td>';
							$balancerow .= '<td>'.($row['prevbalance']+$row['receivebalance']-$row['issuebalance']).'</td>';
							*/?>
							<tr>
								<th style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["item_name"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm1"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm2"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm3"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm4"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm5"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm6"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm7"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm8"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm9"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm10"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm11"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row["totalm12"]; ?></td>
								<!--<td <?php //echo ($row["receive"])?'class="drilldownCell" data-class="receive" data-month="'.$row["repmonth"].'"':''; ?>><?php echo $row["receive"]; ?></td>
								<td <?php //echo ($row["issue"])?'class="drilldownCell" data-class="issue" data-month="'.$row["repmonth"].'"':''; ?>><?php echo $row["issue"]; ?></td>
								<td <?php //echo ($row["pending"])?'class="drilldownCell" data-class="pending" data-month="'.$row["repmonth"].'"':''; ?>><?php echo $row["pending"]; ?></td>-->
							</tr><?php
						} ?>
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
	$('.drilldownCell').css('cursor','pointer');
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
	});
});
				 <?php }?>
</script>