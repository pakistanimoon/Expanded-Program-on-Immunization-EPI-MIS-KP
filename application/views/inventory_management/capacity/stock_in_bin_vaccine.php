<!--For use in Highcharts -->
<?php 
$utype=$this -> session -> utype;
$data=array();
$i=0;
//print_r($graphresult);;
if(isset($graphresult)){
  foreach($graphresult as $key=>$value)
{
	    $data[$i]['name']=$value['itemname'];
		$data[$i]['y']=((int)$value['quantity']);
		
$i++;
} 
}
//print_r($data);	
?>
<label><h2>Stock In Bin - <?php get_ccm_name(false,$ccm_id);?></h2></label>
<?php if($this->session->flashdata('message')){ ?>
<div style="background-color:green;color:white"><center><label><?php echo $this->session->flashdata('message'); ?></label></center></div>
<?php } ?>
<input type="hidden" id="stock_bin" name="stock_bin" value="<?php get_ccm_name(false,$ccm_id);?>"/>
<table class="table table-bordered table-condensed mytable3" border="1" id="table">
						<thead>
							<tr>
								<th colspan="11" style="padding-top: 10px; padding-bottom: 10px;"> <label ><a style="color:white" href="<?php echo base_url();?>ccmLocStatus" >Back To Location</a></label></th>
							</tr>
							
							<tr>
								<th style="text-align:center;"><label>Sr No.</label></th>
								<th style="text-align:center;"><label>Product</label></th>
								<th style="text-align:center;"><label>Batch No.</label></th>
								<th style="text-align:center;"><label>Quantity</label></th>
								<th style="text-align:center;"><label>Doses</label></th>
								<th style="text-align:center;"><label>Expiry Date</label></th>
								<th style="text-align:center;"><label>VVM Stage</label></th>
								<th style="text-align:center;"><label>Action</label></th>
								
							</tr>
							</thead>
						<tbody>
							<?php 
							if(empty($result))
							{ ?>
								<tr>
									<td colspan="10" style="text-align:center;">
										No data available
									</td>
								</tr>
							<?php 
							}else
							{
								foreach($result as $key => $value)
								{ ?>
									<tr>
									
										<td><?php echo $key+1; ?></td>
										<td><?php echo $value['itemname']; ?></td>
										<td><?php echo $value['batch']; ?></td>
										<td><?php echo $value['quantity']; ?></td>
										<td><?php echo $value['doses']*$value['quantity']; ?></td>
										<td><?php echo $value['expiry_date']; ?></td>
										<td><?php echo $value['name']; ?></td>
										<td style="text-align:center" batch_id="<?php echo $value['pk_id']; ?>"><?php if($utype == 'DEO' || $utype == 'Store' ){ ?><button style="margin:2px;" onclick="getDetail(this)" type="button" id="addtransferbtn" class="btn btn-success btn-md" data-toggle="modal" data-target="#AddBatchModal">Transfer</button><?php }?><a class="btn btn-info btn-sm"  onclick="get_info(this)" data-id="<?php echo $value['pk_id']; ?>" data-toggle="modal" data-target="#information" ><i class="fa fa-search"></i></a></td>
									</tr>
								<?php 
								}
							} ?>
						</tbody>
					</table>
<div class="modal fade" id="AddBatchModal" role="dialog" style="display: none;">
		<div class="modal-dialog">
			<!-- Modal content-->
			<?php echo form_open(base_url().'TransferStock',array("class"=>"form-horizontal")); ?>
				<div class="modal-content">
					<div class="modal-header" height="35px">
						<h4 class="modal-title-transfer">Transfer Stock</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Product <span style="color:red;">*</span></label>
											<input class="form-control" name="product"  id="product" type="text" readonly>
									
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Batch No.<span style="color:red;">*</span></label>
										<input name="batch_numb" id="batch_numb" value="" class="form-control" required="" type="text" readonly>                           
										<input name="batch_id" type="hidden" id="batch_id" value="" class="form-control" required="" type="text" readonly>                           
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<label class="control-label">VVM Stage<span class="hide1" style="color:red;">*</span></label>
									<div class="form-group">
										<input class="form-control" name="vvm_stage" id="vvm_stage" type="text" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<label class="control-label">Available Qty<span style="color:red;">*</span></label>
									<div class="form-group">
										<input class="form-control qtycheck" name="qty" id="qty"  type="text" readonly>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<label class="control-label">Location<span style="color:red;">*</span></label>
									<div class="form-group">
										<select class="form-control" name="location" id="location" required>
										<option value=""> Select </option>
										<?php echo get_options_html($ccminfo,TRUE); ?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<label class="control-label">Qty<span style="color:red;">*</span></label>
									<div class="form-group">     
										<input class="form-control qtycheck" name="qtyadd" id="qtyadd" required type="text" >                                
									</div>
								</div>
							</div>
							
							<br>
							<div class="col-md-6" style="margin-left: 65%;">
							<input class="form-control"  name="transfer_from" id="transfer_from" value="<?php echo $ccm_id;?>" type="hidden" >                                
								<button id="btn-modalForm-submit" type="submit" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="button" class="btn-background box1" id="cancelmodal" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div>                             
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>	
<div id="information" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title">Batch Placements Detail</h4>
            </div>
            <div class="modal-body" id="batchdetailbody">
				
		</div>
		<div style="margin-left: 80%;">
					<button type="button" class="btn-background box1" id="cancelmodal" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Close</span></button>   				
				</div>
        </div>
    </div>﻿</div>	
	
					
<script type="text/javascript">	
		$(document).ready(function()
	{

		 $('#table').DataTable({
			
			"sDom": 'lf<"centered"B>rtip',
			  buttons: [
					'copy','excel'
						],
			"columnDefs": [ { "targets": [ 3 ], "orderable": false } ]
			
		});
	});
	$('.buttons-excel').css('Backgrouncolor','green');
	
	function getDetail(ob)
	{
		var bin=$('#stock_bin').val();
		$(".modal-title-transfer").empty();
		$(".modal-title-transfer").append(" From  "+bin);
		var product=$(ob).parent().parent().find('td:eq(1)').html();
		var batch=$(ob).parent().parent().find('td:eq(2)').html();
		var qty=$(ob).parent().parent().find('td:eq(3)').html();
		var vvm_stage=$(ob).parent().parent().find('td:eq(6)').html();
		var batch_id=$(ob).parent().parent().find('td:eq(7)').attr('batch_id');
		$('#product').val(product);
		$('#batch_numb').val(batch);
		$('#qty').val(qty);
		$('#vvm_stage').val(vvm_stage);
		$('#batch_id').val(batch_id);
	}
	
	$(document).on('change','#location',function(){
		var loc=$(this).val();
		var bin=<?php echo $ccm_id;?>;
		if(loc==bin)
		{
			alert("Already in that Bin. Please Select another.! ");
		}
	});
	$(document).on('change','.qtycheck',function(){
		var qty=$('#qty').val();
		var qtyadd=$('#qtyadd').val();
		if(qtyadd>qty)
		{
			alert("Please Enter a value less than or equal to Qty Available ");
		}
	});
	$(document).on('click','#btn-modalForm-submit',function(){
	$('#location').trigger('change');
	$('.qtycheck').trigger('change');
	});
	//
	function get_info(ob)
	{
	var batch=$(ob).parent().parent().find('td:eq(2)').html();
	/*** Ajax Call to get  batch detail wise data to show in modal Table ***/
	var i=0;var total=0;
	$.ajax({
		
	type: "POST",
			datatype: "JSON",
			async:false,
			data: {batch_number: batch},
			url: "<?php echo base_url("batchInformation"); ?>",
			success: function(result){
				var data=JSON.parse(result);
				console.log(data['data']['result'].length);
				//alert(data['data']['result'].length);
				var datahtml="<table class='table table-bordered table-condensed mytable3' border='1' ><tr><th><label>Sr No.</label></th><th><label>Batch No</label></th><th><label>Cold Rooms</label></th><th><label>VVM Stage</label></th><th><label>Quantity</label></th></tr>";
				while(i < data['data']['result'].length ){
					total=+total + +data['data']['result'][i]['quantity'];
					var Srno=i+1;
				datahtml+='<tr><td>'+Srno+'</td><td>'+data['data']['result'][i]['batch']+'</td><td>'+data['data']['result'][i]['shortname']+'</td><td>'+data['data']['result'][i]['name']+'</td><td>'+data['data']['result'][i]['quantity']+'</td></tr>';
				i++;
				}
				datahtml+='<tr><th style="text-align:center;" colspan="4"><b>Total</b></th><td><b>'+total+'</b></td></tr></table>';
				//alert(datahtml);
			$('#batchdetailbody').html(datahtml);
	
	}
	});
	}
 
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>

<div class="row" style="margin-left:-10px;">
	<div class="col-md-6">
		<div id="container" style="height: 400px"></div>
	</div>
	<div class="col-md-6">
		<div id="container2" style="height: 400px"></div>
	</div>
</div>
<script>
	JSONd = <?php echo json_encode($ccminfograph);?>;
	var JSONdd = <?php echo json_encode($data);?>;
	var stored=parseInt(JSONd[0].stored);
	var totcapacity=parseInt(JSONd[0].totcapacity);
	var remaining=totcapacity-stored;
	stored=(stored/totcapacity)*100;
	
	totcapacity=(remaining/totcapacity)*100;
	
   Highcharts.chart('container', {
			chart: {
				type: 'pie',
					options3d: {
					enabled: true,
					alpha: 75,
					beta: 0,
			
							}
				},	
			title: {
					text: JSONd[0].name+' Capacity Utilization Status'
					},
			tooltip: {
       
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					},
			plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				depth: 35,
				dataLabels: {
					enabled: true,
					format: '{point.name}: <b>{point.percentage:.1f}%'
							}
				,
			colors: [
				'green', 
				'red'
					]
			
				}
		},
    series: [{
        type: 'pie',
       name: JSONd[0].name+' Capacity Utilization Status',
       
		 data: [
		{
            name: "Remaining",
            y: totcapacity,
            sliced: true,
            selected: true
        },
		{
            name:"Used",
            y: stored,
            sliced: true,
            selected: true
        }
		]
    }]
});

 Highcharts.chart('container2', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 75,
            beta: 0,
			
        }
    },
    title: {
        text: JSONd[0].name+' Vaccine Placement Status'
    },
    tooltip: {
       
		 pointFormat: '<b>{point.name}</b>: {point.percentage:.1f} %'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        type: 'pie',
       name: JSONd[0].name+' Capacity Vaccine Status',
     
		
 data:JSONdd
	}]
	});
 

</script>			

	