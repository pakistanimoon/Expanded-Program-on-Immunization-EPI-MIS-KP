<?php 

?>
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
						<li role="presentation" ><a class="fa fa-table" href="<?php echo base_url();?>cold-chain-capacity"><i></i><span class="strong" style="padding-left:5px">Capacity By</span><span style="display:block;padding-left:20px">Utilization</span></a></li>
						<li role="presentation" class="active"><a class="fa fa-table" href="<?php echo base_url();?>capacity-by-vaccine"><i></i><span class="strong" style="padding-left:5px">Capacity By</span><span style="display:block;padding-left:20px">Vaccine</span></a></li>
					</ul>
                </div>
           	<div class="capacity">
						 <div class="capacity-body">    
							<table class="table table-bordered table-condensed " border="1">
                                            <thead>
                                                <tr>
                                                    <th><label>Sr. No.</th>
                                                    <th><label>Cold Room</th>
                                                    <th class="right"><label>Product </th>
                                                    <th alass="right"><label>Quantity (Vials)</th>
                                                   
                                                </tr>
                                            </thead>
							<tbody>	
							<?php foreach($result as $key=>$value){?>
							<tr>
								<Td><?php echo $key+1;?></td>
								<Td><?php echo $value['shortname'];?></td>
								<Td><?php echo $value['itemname'];?></td>
								<Td><?php echo $value['quantity'];?></td>
									
							</tr>
							<?php }?>	
						   </tbody>
						</table>
				<!--HighChart Testing -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<!-- optional -->
<script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
<div id="container" style="width:50%; height:500px;"></div>


			
						 </div> 
                    
					</div>
				</div>	
			</div>	
	  	
</div>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
 $(document).ready(function () {
    var JSON = <?php echo json_encode($result);?>;
console.log(JSON);
 Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Capacity By Vaccine '
    },
    xAxis: {
        categories: ['CR1', 'CR2', 'CR3', 'CR4', 'CR5']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Litres'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
   /* legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
 tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    }, */
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    }, 
    series: JSON
	}); 
	});
</script>