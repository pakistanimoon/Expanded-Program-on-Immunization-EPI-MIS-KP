
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
.heading {
	    font-size: 18px;
    background-color: #008d4c !important;
    color: white;
    padding: 10px;
}
/*green,DD8521,E00000,red*/
</style>
<div class="container bodycontainer">
		<h3 class="page-title"><?php get_store_name(false,$this->session->curr_wh_type,$this->session->curr_wh_code);?><small> dashboard &amp; statistics</small></h3>
        <div class="row">
            <div class="col-md-12">
				<div style="border: 1px solid #77e588; margin-bottom: -2px;">
					<ul class="nav nav-pills">
						<li role="presentation" ><a class="fa fa-table" href="#"><i></i><span class="strong" style="padding-left:5px">Routine</span><span style="display:block;padding-left:20px">Immunization</span></a></li>
						<li role="presentation" class="active"><a class="fa fa-table" href="<?php echo base_url();?>"><i></i><span class="strong" style="padding-left:5px">Inventory</span><span style="display:block;padding-left:20px">Management</span></a></li>
					</ul>
                </div>
           	<div class="capacity">
						 <div class="capacity-body"> 
						 <div class="row">
							<form method="post" name="im" id="im" action="<?php echo base_url();?>dashboard-provincial">
							<div class="col-md-1 text-right" style="padding-top:8px;">
								<label>Year</label>
							</div>
							<div class="col-md-2">
								<select id="year" name="year" class="form-control" required>
									<?php echo getYearsOptions(); ?>
								</select>
							</div>
							<div class="col-md-2 text-right" style="padding-top:8px;">
								<label>Reporting Month</label>
							</div>
							<div class="col-md-2">
								<select id="month" name="month" class="form-control">
									<?php getAllMonthsOptions(); ?>
								</select>
							</div>
							<div class="col-md-1 text-right" style="padding-top:8px;">
								<label>Vaccine</label>
							</div>
							<div class="col-md-2">
								<select id="product" name="product" class="form-control">
									<?php  echo get_products_by_activity();?>
								</select>
							</div>
							<div class="col-md-1">
								<button type="submit" name="submit" class="btn btn-success">GO</button>
							</div>
						 </form> 
					</div>
					<div class="row">
						<div class="col-md-12">
						<div class="widget-head">
                            <h4 class="heading glyphicons cargo"><i></i>Stock Status By Item</h4>
                        </div>	
					</div>	
					</div>
					<div class="row">
						<div class="col-md-6">
						<div id="chart" style="float:left;height:40%"></div>
					</div>
					<div class="col-md-6">
						<table class="table table-bordered table-strip">
                                     
									  <thead>
									  <tr>
											 <th colspan="4"><h2>Issue To Warehouse Name</th>
									  </tr>
                                                <tr>
                                                    <th><label>Sr. No.</th>
                                                    <th><label>Warehouse Name</th>
                                                    <th class="right"><label>Batch Name </th>
                                                    <th class="right"><label>Quantity </th>
                                                </tr>
                                            </thead>
							<tbody style="   overflow-y: auto;">	
							<?php foreach($issue_warehouse as $key=>$value){
								
								?>
							<tr>
							
								<Td><?php echo $key+1;?></td>
								<Td><?php echo $value['warehousename'];?></td>
								<Td><?php echo $value['batchname'];?></td>
								<Td><?php echo $value['sum'];?></td>
									
							</tr>
							<?php }?> 
						   </tbody>
						</table>
					</div>

					</div>
					<!-- VVM Status  -->
					<div class="row">
						<div class="col-md-12">
						<div class="widget-head">
                            <h4 class="heading glyphicons cargo"><i></i>VVM Status</h4>
                        </div>	
					</div>	
					</div>
					<div class="row">
						<div class="col-md-6">
						<div id="vvm_chart" style="float:left;height:40%"></div>
					</div>
					<div class="col-md-6">
						<table class="table table-bordered table-strip">
                                     
									  <thead>
									  <tr>
											 <th colspan="4"><h2>VVM Status</th>
									  </tr>
                                                <tr>
                                                    <th><label>Sr. No.</th>
                                                   <th class="right"><label>Batch Name </th>
                                                    <th class="right"><label>Quantity </th>
                                                </tr>
                                            </thead>
							<tbody style="   overflow-y: auto;">	
							<?php foreach($vvm_stage_status as $key=>$value){
								
								?>
							<tr>
							
								<Td><?php echo $key+1;?></td>
								<Td><?php echo $value['number'];?></td>
								<Td><?php echo $value['sum'];?></td>
									
							</tr>
							<?php }?> 
						   </tbody>
						</table>
					</div>

					</div>
						 </div>
					</div>
				</div>	
			</div>	
	  	
</div>	
<!--HighChart Testing -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<!-- optional -->
<script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>

       $(document).ready(function () {
		   var JSON = <?php echo json_encode($stock_status);?>;
		   
Highcharts.chart('chart', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Stock Status'
    },
  
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            
        }
    },
    series: [{
        name:JSON,
        colorByPoint: true,
        data: [{
            name: 'Issued',
            y:JSON,
            sliced: true,
            selected: true
        }]
    }]
});
//vvm chart
		   var JSON = <?php echo json_encode($vvm_sum);?>;
		   
Highcharts.chart('vvm_chart', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'VVM Stage Status'
    },
  
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            
        }
    },
    series: [{
        name:JSON,
        colorByPoint: true,
        data: [{
            name: 'Vvm Status',
            y:JSON,
            sliced: true,
            selected: true
        }]
    }]
});



       });
</script>	