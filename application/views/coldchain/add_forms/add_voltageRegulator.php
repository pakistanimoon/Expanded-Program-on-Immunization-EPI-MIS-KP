<div class="panel panel-primary cst-label">
  <div class="panel-heading">New/Add Voltage Regulator</div>
	  <div class="panel-body">
		<form action="<?php echo base_url()?>/Coldchain/mainVoltageRegulatorSave" method="post" onsubmit="return checkRequired();" enctype="multipart/form-data">
				<?php $this -> load -> view('coldchain/add_forms/storesSection') ?>
				<div class="row" style="margin-bottom:10px"> 
							<!--<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Date"> Date <span style="color:red;">*</span></label>
											</div>
											<div class="col-md-8">
											<input type="text" id="date" name="date" class="dpcct form-control" readonly="true" />
											</div>
										</div>
								</div>-->
								<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Working">Status<span style="color:red;">*</span></label>
											</div>
											<div class="col-md-8">
												<select class="form-control" name="status" id="status_w" required>
											    <option value="1">Working well</option>
												</select>
											</div>
										</div>
								</div>
								<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="AssetSubType">Supply Year<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" id="working_since" name="working_since" class="dpcct form-control date readonly" required />
									</div>
								</div>
						</div>
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="AssetSubType">Manufacture Date<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" id="manufacturer_year" name="manufacturer_year" class="dpcct form-control date readonly" required />	
									</div>
								</div>
						</div>
								<!--<div class="col-md-4" style="display:none" id="res_hid">
								<div class="row">
									<div class="col-md-4">
										<label for="Reasons">Reasons<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<select class="form-control" name="reasons" id='reasons'>
										<?php echo getReasons(); ?>
										</select>
									</div>
								</div>
							</div>-->		
				</div><!-- row -->
				
				<input type="hidden" id="asset_type_id" name="asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
										<!--- row --->	
				<div class="row" style="margin-bottom:10px">
					<div class="col-md-4">
								<div class="row">
										<div class="col-md-4">
											<label for="Catalogue">Catalog ID <span style="color:red;">*</span></label>
										</div>
										<div class="col-md-8">
												<select class="form-control" name="Catelogue_id" id="catalogue_id_main" required>
											<option value="0" >--Select Asset--</option>
											<?php if(isset($dataModel) && $dataModel!='') {
														foreach($dataModel as $value){ ?>
															<option value="<?php echo $value['pk_id']; ?>"><?php echo $value['catalogue_id']; ?></option>
													<?php } 
													}?>
											</select>
									</div>
									<div class="col-md-2">
									<!--<button type="button" id='modalid' class="btn btn-success btn-md" data-toggle="modal" title="Add Make and Modal" data-target="#myModal" style="position:relative"> <i class="fa fa-plus"></i></button>-->
									</div>
								</div>
						</div>
						<div class="col-md-4">
								<div class="row">
	
										<div class="col-md-4">
												<label for="Quantity">Quantity<span style="color:red;">*</span></label>
										</div>
										<div class="col-md-8">
										<input type="text" name="quantity" class="form-control numberclass" placeholder="" required>
										</div>
								</div>
						</div>
						<!--<div class="col-md-4"> 
							<div class="row">
								<div class="col-md-4">
									<label for="Working Since (Year)">Working Since (Year)</label>
								</div>
								<div class="col-md-8">
									<input type="text" id="working_since" name="working_since" class="dpcct form-control" readonly="true"/>
								</div>
							</div>
						</div>-->
					</div>
					<!--Row end -->
				<div id="modelHide" class="row" style="display: none;">
					<div class="col-md-4">
						<div class="form-group">
							<label for="Make">Make <span style="color:red;">*</span></label>
							<select class="form-control" id="ccm_make_main" readonly>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Model">Model <span style="color:red;">*</span></label>
							<select class="form-control" id="ccm_model_main" readonly>
							</select>
						</div>
					</div>
			  
																   
															
				</div><!-- row -->
				<div class="text-right">	
					<div class="row">
						<div class="col-md-5 col-md-offset-7">
						<button type="submit" style="background-color:#00a65a;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
						<button type="Button" class="btn-background box1" id="cancel"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
						</div>
					</div>
				</div><!--- row --->
		</form>
		
		<!-- Modal content-->
		<div class="modal fade" id="myModal" role="dialog" style="display: none;">
			<div class="modal-dialog">
				<form class="modalForm" id="tag-form" action="" method="post" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header" height="35px">
							<h4 class="modal-title-transfer">Suggest new make and model</h4>
						</div>
						<div class="modal-body">
							<input type="hidden" id="asset_type_id" name="asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Catalogue ID <span style="color:red;">*</span></label>
										<input type="text" id="catalogue_id_popup" name="catalogue_id" class="form-control" />
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Make <span style="color:red;">*</span></label>
										<input type="text" id="ccm_make_popup" name="make_name" class="form-control" />
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Model<span style="color:red;">*</span></label>
										<input type="text" id="ccm_model_popup" name="model_name" class="form-control" />
									</div>
								</div>
							</div> <!--- row --->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Nominal Voltage (vAC)<span style="color:red">*</span></label>
										<input type="text" id="nominal_voltage" name="nominal_voltage" class="form-control numberclass nominal" placeholder="">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Continous Power(watts) </label>
										<input type="text" id="continous_power" name="continous_power" class="form-control numberclass continous">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Frequency(Hz)</label>
										<input type="text" id="frequency" name="frequency" class="form-control frequency">
									</div>
								</div>
							</div><!--- row --->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Cost(US$)<span style="color:red">*</span></label>
										<input type="text" id="product_price" name="product_price" class="form-control numberclass" placeholder="">
									</div>
								</div>
			   
		 
			  
		
								<div class="col-md-4">
									<div class="form-group">
										<label> Input&nbsp;Voltage&nbsp;Range&nbsp;(vAC) </label>
										<input type="text" id="input_voltage_range" name="input_voltage_range" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Output&nbsp;Voltage&nbsp;Range&nbsp;(vAC)</label>
										<input type="text" id="output_voltage_range" name="output_voltage_range" class="form-control">
									</div>
								</div>
							</div><!--- row --->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Phases </label>
										<div class="row" style="position:relative; top:6px;">
											<div class="col-md-6">
												<label class="radio-inline">
													<input type="radio" value="1" id="no_of_phases-1" name="no_of_phases" checked="checked">One
												</label>
											</div>
											<div class="col-md-6">
												<label class="radio-inline">
													<input type="radio" value="3" id="no_of_phases-3" name="no_of_phases">Three
												</label>
											</div>
										</div><!-- row -->
									</div>
								</div>
							</div><!--- row --->
													  
						  <div class="modal-footer">
								<button id="btn-modalForm-submit" type="Button" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="Button" class="btn-background box1" id="cancel1" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
						  </div>
						</div>
					</div>
				</form>
		</div>
	</div>
			<!-- Modal end-->
		</div>
	</div>
<script type="text/javascript">

$(".readonly").keydown(function(e){
        e.preventDefault();
    });
	
 var res=null;
 $(document).on('change','#status_w',function(){
	// alert('hello');
	var id=$(this).val();
	if(id==3){
	//	alert('hello');
		$("#res_hid").show();
		$('#reasons').attr('required',true);
	}else{
		//alert('hello');
		$("#res_hid").hide();
		$('#reasons').attr('required',false);
	}
});
$(document).on('change','#catalogue_id_main', function(){
	var id=$(this).val();
	var mainId=$('#assets').val();
	if(id!='0'){
		$.ajax({
			type: "POST",
			data: "id="+id,
			url: "<?php echo base_url(); ?>Ajax_calls/getmodelData",
			success: function(result){
				var result= JSON.parse(result);
				$("#ccm_make_main").html("<option>"+result.allData.make_name+"</option>");
				$("#ccm_model_main").html("<option>"+result.allData.model_name+"</option>");
				$("#modelHide").slideDown(600);
			}
		});
		
	}else{
		$("#modelHide").slideUp(600);
	}
});
/* function checkCatalogue_id(catalogue_id)
{ 
	var asset_type_id=$('#asset_type_id').val();
	 $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Coldchain/checkCatalogue_id",
        data:{"catalogue_id":catalogue_id,"assetid":asset_type_id},
        success: function(response) {
        //  alert(response);
			res=response;
        },
        error: function() {
            alert('Error');
        }
		
    });
	
} */
$('#btn-modalForm-submit').on('click', function(e) {
	var catalogue_id=$('#catalogue_id_popup').val();
	var ccm_make=$('#ccm_make_popup').val();
	var ccm_model=$('#ccm_model_popup').val();
	var catalogue_id_main="";
	catalogue_id_main=catalogue_id+"-"+ccm_make+"-"+ccm_model;
	//checkCatalogue_id(catalogue_id_main);

	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Coldchain/voltageRegulatorModalSave",
        data: $('form.modalForm').serialize(),
        success: function(response) {
            if(response=='required'){
				alert("Please Fill Required Fields!");
			}else{
				$('#catalogue_id_main').html(response);
				$( "#cancel1" ).click();
			}
        }
    });  
});
/** For Nominal Voltage vAC Greater Than Zero **/
$('.nominal').on('keyup change', checknominal);
function checknominal()
{
	
		var value=$(this).val();
		if(value > 0)
		{
			$(this).css("border","");
			//$("#btn-modalForm-submit").attr("disabled", false);
			 //event.preventDefault();
           $("#btn-modalForm-submit").prop('disabled', false);
		}
		else
		{
			alert("Nominal Voltage vAC must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	
}
/** For Continous Power  Watts Greater Than Zero **/
$('.continous').on('keyup change', checkcontinous);
function checkcontinous()
{
	
		var value=$(this).val();
		if(value > 0)
		{
			$(this).css("border","");
			//$("#btn-modalForm-submit").attr("disabled", false);
			 //event.preventDefault();
           $("#btn-modalForm-submit").prop('disabled', false);
		}
		else
		{
			alert("Continous Power Watts must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	
}
/** For Frequency Hz Greater Than Zero **/
$('.frequency').on('keyup change', checkfrequency);
function checkfrequency()
{
	
		var value=$(this).val();
		if(value > 0)
		{
			$(this).css("border","");
			//$("#btn-modalForm-submit").attr("disabled", false);
			 //event.preventDefault();
           $("#btn-modalForm-submit").prop('disabled', false);
		}
		else
		{
			alert("Frequency Hz must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	
}
$('#cancel').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/voltageregulator_list/23";
	window.location.href=url;
});	
$(function () {
	$('.dpcct').datetimepicker({
		format : 'yyyy-mm-dd hh:ii:ss',
		color: "green",
		startView : 2,
		viewDate: new Date(),
		endDate : new Date(),
		todayHighlight : true,
		todayBtn : true
	});
	$(document).on("change",".dpcct",function(e) {
		var inputdate = $('#working_since').val();
		var inputdate1 = inputdate.split(" ");
		var enterdate = inputdate1[0];
		var d= new Date();
		var month = d.getMonth()+1;
		if(month < 10){
			month = "0"+month;
		}
		var currentdate = d.getFullYear() + "-" + (month) + "-" + d.getDate();
		var currnttime = d.getHours()+ "-" + d.getMinutes() + "-" + d.getSeconds();
		var dateshoul = currentdate +" "+ currnttime;
		if(enterdate > currentdate){
			alert('SORRY! Stricted For Future Entry.');
			$('#working_since').val(dateshoul);
		}						
	})
});	
</script>