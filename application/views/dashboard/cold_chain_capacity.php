<style>
	.capacity{ 
		/*margin-bottom: 25px;*/
		clear: both;
		border: 1px solid #77e588;
		width: 100%;
		background:inherit;
	}
	.itembox{
		height: 90px;
		position: inherit;
		margin-bottom: 15px;
	}
	.itemcontent{
		/* background-color: #578ebe; */
		background: linear-gradient(to right, #578ebe 0%,#578ebe 50%,#578ebe 50%,#578ebe 100%);
		height: inherit;
	}
	.redbg{
		background: linear-gradient(to right, #E00000 0%,#E00000 50%,#E00000 50%,#E00000 100%) !important;
		height: inherit;
	}
	.warnbg{
		background: linear-gradient(to right, #DD8521 0%,#DD8521 50%,#DD8521 50%,#DD8521 100%) !important;
		height: inherit;
	}
	.itemcontent .inner{
		height: inherit;
	}
	.capacity-body{
		padding:15px;
	}
	.capacity-stat {
		height: inherit;
		color:White;
		font-family:initial;
		cursor:pointer;
	}
	.capacity-stat .visual {
		font-size: 45px;
		padding:10px;
		opacity: 0.2;
		color: white;
		float: left;
	   /*  line-height: 35px;
		width: 80px;
		height: 80px;
		display: block;
		padding-top: 10px;
		padding-left: 15px;
		margin-bottom: 10px;*/
	}
	.capacity-stat .details {
		position: absolute;
		padding: 15px;
		float: right;
	}
	.capacity-stat .details .itemtitle {
		font-size: 20px;
		float: right;
		padding-right: 15px;
		font-weight: bold;
	}
	.capacity-stat .details .itemdetail {
		font-size: 11px;
		float: right;
		padding-right: 10px;
	}
	/*green,DD8521,E00000,red*/
</style>
<div class="container bodycontainer">
	<h3 class="page-title"><?php get_store_name(false,$this->session->curr_wh_type,$this->session->curr_wh_code);?><small> dashboard &amp; statistics</small></h3>
	<div class="row">
		<div class="col-md-12">
			<div style="border: 1px solid #77e588; margin-bottom: -2px;">
				<ul class="nav nav-pills">
					<li role="presentation" class="active"><a class="fa fa-table" href="<?php echo base_url();?>cold-chain-capacity"><i></i><span class="strong" style="padding-left:5px">Capacity By</span><span style="display:block;padding-left:20px">Utilization</span></a></li>
					<li role="presentation" ><a class="fa fa-table" href="<?php echo base_url();?>capacity-by-vaccine"><i></i><span class="strong" style="padding-left:5px">Capacity By</span><span style="display:block;padding-left:20px">Vaccine</span></a></li>
				</ul>
			</div>
			<div class="capacity">
				<div class="capacity-body row">    
					<table class="table table-bordered table-condensed col-md-6" style="width:48%;margin-left:1%;margin-right:1%;" border="1">
						<thead>
							<tr>
								<th class="text-center" style="width:10%;"><label>Sr. No.</th>
								<th class="text-center" style="width:15%;"><label>Cold Room</th>
								<th class="text-center" style="width:30%;"><label>Net Usable (Litres)</th>
								<th class="text-center" style="width:30%;"><label>Being Used (Litres)</th>
								<th class="text-center" style="width:15%;"><label>Being Used (%)</th>
							</tr>
						</thead>
						<tbody><?php 
							$index=$netsum=$usedsum=0;
							foreach($coldroom as $key=>$value){
								if($value["status"]==3){
									$classtoadd = 'redbg';
									//unset this item, it will not display in graph then
									unset($freezer[$key]);
								}else{$classtoadd = '';
									if($value["stored"]>=$value["totcapacity"]){
										$classtoadd = 'warnbg';
									}/* else{
										$classtoadd = 'someused';
										if($value["totcapacity"]){
											$percentage = (round(($value["stored"]/$value["totcapacity"])*100,2));
										}else{
											$percentage = 0;
										}
										$extra = 'data-percent="'.$percentage.'"';
									} */
								}?>
								<tr class="<?php echo $classtoadd; ?>">
									<td class="text-center"><?php echo $index=$key+1;?></td>
									<td><?php echo $value['name'];?></td>
									<td class="text-center"><?php echo $value['totcapacity'];$netsum+=$value['totcapacity'];?></td>
									<td class="text-center"><?php echo $value['stored'];$usedsum+=$value['stored'];?></td>
									<td class="text-center"><?php echo ($value['totcapacity']>0)?round(($value['stored']/$value['totcapacity'])*100,2):0;?></td>	
								</tr><?php 
							}
							if($index>0){?>
								<tr>
									<td colspan="2" class="text-center"><b>Total</b></td>
									<td class="text-center"><?php echo $netsum;?></td>
									<td class="text-center"><?php echo $usedsum;?></td>
									<td class="text-center"><?php echo ($netsum>0)?round(($usedsum/$netsum)*100,2):0;?></td>	
								</tr><?php
							}?>	
						</tbody>
					</table>
					<table class="table table-bordered table-condensed col-md-6" style="width:48%;margin-left:1%;margin-right:1%;" border="1">
						<thead>
							<tr>
								<th class="text-center" style="width:10%;"><label>Sr. No.</th>
								<th class="text-center" style="width:15%;"><label>Freezers</th>
								<th class="text-center" style="width:30%;"><label>Net Usable (Litres)</th>
								<th class="text-center" style="width:30%;"><label>Being Used (Litres)</th>
								<th class="text-center" style="width:15%;"><label>Being Used (%)</th>
							</tr>
						</thead>
						<tbody><?php 
							$index=$netsum=$usedsum=0;
							foreach($freezer as $key=>$value){
								if($value["status"]==3){
									$classtoadd = 'redbg';
									//unset this item, it will not display in graph then
									unset($freezer[$key]);
								}else{$classtoadd = '';
									if($value["stored"]>=$value["totcapacity"]){
										$classtoadd = 'warnbg';
									}/* else{
										$classtoadd = 'someused';
										if($value["totcapacity"]){
											$percentage = (round(($value["stored"]/$value["totcapacity"])*100,2));
										}else{
											$percentage = 0;
										}
										$extra = 'data-percent="'.$percentage.'"';
									} */
								}?>
								<tr class="<?php echo $classtoadd; ?>">
									<td class="text-center"><?php echo $index=$key+1;?></td>
									<td><?php echo $value['name'];?></td>
									<td class="text-center"><?php echo $value['totcapacity'];$netsum+=$value['totcapacity'];?></td>
									<td class="text-center"><?php echo $value['stored'];$usedsum+=$value['stored'];?></td>
									<td class="text-center"><?php echo ($value['totcapacity']>0)?round(($value['stored']/$value['totcapacity'])*100,2):0;?></td>	
								</tr><?php 
							}
							if($index>0){?>
								<tr>
									<td colspan="2" class="text-center"><b>Total</b></td>
									<td class="text-center"><?php echo $netsum;?></td>
									<td class="text-center"><?php echo $usedsum;?></td>
									<td class="text-center"><?php echo ($netsum>0)?round(($usedsum/$netsum)*100,2):0;?></td>	
								</tr><?php
							}?>	
						</tbody>
					</table>
					<div class="col-md-6" id="container" style="height:400px;"></div>
					<div class="col-md-6" id="container2" style="height:400px;"></div>
					<!--HighChart Graphs -->
					<script src="https://code.highcharts.com/highcharts.js"></script>
					<script src="http://code.highcharts.com/modules/exporting.js"></script>
					<!-- optional -->
					<script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
				</div>				
			</div>
		</div>	
	</div>	  	
</div>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
	/* $(function () { 
	  var myChart = Highcharts.chart('container', {
			chartData=<?php //echo json_encode($result)?>;
			console.log(chartData);
		chart: {
				type: 'column'
			},
			title: {
				text: 'Vaccine Distribution'
			},
			 xAxis: {
				categories: ['CR1', 'cR2', 'CR3']
			},
			yAxis: {
				title: {
					text: 'Fruit eaten'
				}
			},
			series: chartData
		});
	}); */
    $(document).ready(function () {
		var coldroomsdata = <?php echo json_encode($coldroom/* $result */);?>;
		var options = {
			chart: {
				renderTo: 'container',
				type: 'column'
			},
			title: {
				text: 'Vaccine Distribution'
			},
			yAxis: {
				title: {
					text: 'Litres'
				}
			},
			xAxis: {},
			series: [{},{}]
		};
		var categories = [],
        points = [],
		points2 = [];
        $.each(coldroomsdata, function(i, el) {
			categories.push(el.name);
			points.push(parseFloat(el.totcapacity));
			points2.push(parseFloat(el.stored));
        });
		options.xAxis.categories = categories;
	    options.series[0].name = 'Net Capacity';
		options.series[0].data = points;
	    options.series[1].name = 'Used Capacity';
		options.series[1].data = points2;
	    var chart = new Highcharts.Chart(options);
    });
	
	$(document).ready(function () {
		var coldroomsdata = <?php echo json_encode($freezer/* $result */);?>;
		var options = {
			chart: {
				renderTo: 'container2',
				type: 'column'
			},
			title: {
				text: 'Vaccine Distribution'
			},
			yAxis: {
				title: {
					text: 'Litres'
				}
			},
			xAxis: {},
			series: [{},{}]
		};
		var categories = [],
        points = [],
		points2 = [];
        $.each(coldroomsdata, function(i, el) {
			categories.push(el.name);
			points.push(parseFloat(el.totcapacity));
			points2.push(parseFloat(el.stored));
        });
		options.xAxis.categories = categories;
	    options.series[0].name = 'Net Capacity';
		options.series[0].data = points;
	    options.series[1].name = 'Used Capacity';
		options.series[1].data = points2;
	    var chart = new Highcharts.Chart(options);
    });
</script>