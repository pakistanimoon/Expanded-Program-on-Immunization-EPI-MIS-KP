K<?php $store = '';
//echo $monthfrom;exit;
 ?>

<!--start of page content or body-->
<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"><?php 
				if(isset($invnRepType) && $invnRepType=="storewise"){
					echo 'Store Wise';
					$colname = "Store";
				}else{
					echo 'Yearly';
					$month = NULL;
					$colname = "Month";
				}?> Inventory Status Report at <?php 
				if(isset($wh_code)){
					echo $store = get_store_name(TRUE,$wh_type,$wh_code); 
				}?> <?php if(isset($year)){ echo 'for (Year: '.$year; } ?> <?php if(isset($monthfrom) && ($monthfrom!="")){
					echo '(From: '. monthname(substr(str_replace("-","",$monthfrom),4,2)); echo'-'.substr(str_replace("-","",$monthfrom),0,4); } ?><?php if(isset($monthto) && ($monthto!="")){ echo '		To: '. monthname(substr(str_replace("-","",$monthto),4,2));echo'-'.substr(str_replace("-","",$monthto),0,4); } ?>) - Transactions
			</div>
			<?php 	if (!$this -> input -> post('export_excel')) {?>
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
					</tr>
				</table>-->
<?php }?>
				<table class="table table-bordered table-condensed table-striped table-hover mytable"      border="1" >
					<thead>
						<tr>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2"><?php echo $colname; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3">Vouchers issued to <?php echo $store; ?></th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3">Vouchers issued from <?php echo $store; ?></th>
						</tr>
						<tr>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Issued</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Received</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Pending Receiving</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Issued</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Received</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Pending Receiving</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						//$titlerow = $receiverow = $issuerow = $balancerow = '';
						//print_r($reportdata);exit;
						if(!empty($reportdata)){
						foreach($reportdata as $key=>$row){
							if(isset($invnRepType) && $invnRepType=="storewise"){
								$exploded = explode("-",$row["repbyname"]);
								$firstcolval = get_store_name(TRUE,$exploded[0],$exploded[1]);
							}else{
								$firstcolval = $row["repbyname"];
							}
							/* $titlerow 	.= '<th>'.$row['name'].'</th>';
							$receiverow .= '<td>'.$row['receivebalance'].'</td>';
							$issuerow .= '<td>'.$row['issuebalance'].'</td>';
							$balancerow .= '<td>'.($row['prevbalance']+$row['receivebalance']-$row['issuebalance']).'</td>';
							*/?>
							<tr>
								<th style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $firstcolval; ?></th>
								<td style="text-align:center; border: 1px solid black;" class="text-center" <?php echo ($row["issuedme"])?'class="drilldownCell" data-class="issuedme" data-month="'.$row["repbyname"].'"':''; ?>><?php echo $row["issuedme"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center" <?php echo ($row["receivedme"])?'class="drilldownCell" data-class="receivedme" data-month="'.$row["repbyname"].'"':''; ?>><?php echo $row["receivedme"]; ?></td>
								<?php $pending = $row["issuedme"]-$row["receivedme"]; ?>
								<td style="text-align:center; border: 1px solid black;" class="text-center" <?php echo (isset($pending) && $pending>0)?'class="drilldownCell" data-class="pendingme" data-month="'.$row["repbyname"].'"':''; ?>><?php echo $pending; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center" <?php echo ($row["issuedother"])?'class="drilldownCell" data-class="issuedother" data-month="'.$row["repbyname"].'"':''; ?>><?php echo $row["issuedother"]; ?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center" <?php echo ($row["receivedother"])?'class="drilldownCell" data-class="receivedother" data-month="'.$row["repbyname"].'"':''; ?>><?php echo $row["receivedother"]; ?></td>
								<?php $pendingother = $row["issuedother"]-$row["receivedother"]; ?>
								<td style="text-align:center; border: 1px solid black;" class="text-center" <?php echo (isset($pendingother) && $pendingother>0)?'class="drilldownCell" data-class="pendingother" data-month="'.$row["repbyname"].'"':''; ?>><?php echo $pendingother; ?></td>
							</tr><?php
						}} else{?>
						<tr><td style="text-align:center; border: 1px solid black;" class="text-center" colspan="9"><center><b>No Record Found</b></center></td></tr>
						<?php }?>
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
		<?php if(isset($monthfrom) && ($monthfrom!="") && isset($monthto) && ($monthto!="") ){?>
			var monthfrom = '<?php echo $monthfrom; ?>';
			var monthto = '<?php echo $monthto; ?>';
			var distcode = '<?php echo $distcode; ?>';
			
			console.log(monthto);
			console.log(distcode);
			var storeinfo = $(this).data("month").split('-');;
			var wh_type_id=storeinfo[0];
			var month='';
			var whcode=storeinfo[1];<?php
		}else{?>
			var month = $(this).data("month");
			var whcode=0;//"<?php //echo $wh_code; ?>"
			var wh_type_id=0;//"<?php echo $wh_type; ?>"
			var monthfrom = '';
			var monthto = '';
			var distcode = '<?php echo $distcode; ?>';
			<?php
		}?>
		//alert(monthfrom);
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
				data: {wh_type_id: wh_type_id,wh_code:whcode,type:type,monthfrom:monthfrom,monthto:monthto,month:month,distcode:distcode},
				url: "<?php echo base_url("inventory_status_detail"); ?>",
				success: function(resultt){					
					result = JSON.parse(resultt);					
					if(type=="receivedme"){
					var innertable = '<tr class="expandable"><td colspan="7"><table class="table table-bordered table-condensed table-striped table-hover mytable"></thead><th>Sr #</th><th>Transaction Date</th><th>Issued On</th><th>Transaction Number</th><th>Received Voucher</th>';
					}
					else
					{
						var innertable = '<tr class="expandable"><td colspan="7"><table class="table table-bordered table-condensed table-striped table-hover mytable"></thead><th>Sr #</th><th>Transaction Date</th><th>Issued On</th><th>Transaction Number</th>';
					}
					if(type=="issuedme" || type=="receivedme" || type=="pendingme"){
						innertable+='<th>Vouchers issued from</th>';
					}else if(type=="issuedother" || type=="receivedother" || type=="pendingother"){
						innertable+='<th>Vouchers issued to</th>';
					}
					innertable += '</thead><tbody>';
					$.each(result,function(i,item){
						
						
						if(type=="receivedme"){
							var res = item["recievedvouchers"].replace(/\s+/g, '').split(',');
							console.log(res);
							var length=res.length;
							var td='<td>';
							var comma=", ";
							$.each(res,function(i,item)
							{
						      if(i==length-1)
								   comma='';// reomve comma
							 td+='<a href="<?php echo base_url("inventory/Reports/rec_voucher_detail"); ?>/'+'R'+item+'" target="_blank" >'+'R'+item+comma+'</a>';
							});
							 console.log(td);
							 td+='</td>';
							 //remove last comma,
							 
						}
						else{
							td='';
						}
						
						innertable += '<tr><td>'+(i+1)+'</td><td>'+item["transaction_date"]+'</td><td>'+item["created_date"]+'</td><td><a href="<?php echo base_url("voucher"); ?>/'+item["transaction_number"]+'" target="_blank" >'+item["transaction_number"]+'</a></td>'+td+'<td>'+item["store"]+'</td></tr>';
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