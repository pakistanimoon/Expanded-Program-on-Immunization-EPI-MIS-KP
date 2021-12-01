<style>
	<!--                       */
 /*                      */
  /*Custom Css for Model*/
   /*                  */
    /*                */
-->

.cst-modal .modal-header{
	background: #0a7745;
    color: #f1f1f1;
    font-weight: 600;
    border-left: 15px solid #086138;
	padding: 5px 15px;
}
.cst-modal h4.modal-title-transfer{
	font-weight:600;
}	
.cst-modal .form-control{
	height:30px;
	border-radius:2px;
	padding:4px 1px;
	color:#383838;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{
	padding-left:15px;
	background-color:#f7f7f7;
}
.cst-modal span.radio-opt{
	position: relative;
    top: -2px;
}

.radio-row{
	background: #10b578;
    color: white;
    padding-top: 5px;
    border-radius: 3px;
    border: 1px solid #0ea361;
    margin-right: 0px;
    margin-left: 0px;
    padding-left: 4px;
}
</style>
<div class="panel panel-primary">
  <div class="panel-heading">Add Cold Box</div>
	<div class="panel-body">
				<!-- main form start-->
				<div class="add_refrigerator inside-page">
					<form method="post" action="<?php echo base_url() ?>Coldchain/coldboxSave" onsubmit="return checkRequired();" enctype="multipart/form-data">
						<input type="hidden" name="auto_asset_id_increment" value="<?php echo $varMax; ?>" class="form-control" />
						<input type="hidden" name="asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
							<?php $this -> load -> view('coldchain/add_forms/storesSection') ?>
							<div class="row" style="margin-bottom:10px">
									<!--<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Date"> Date <span style="color:red;">*</span></label>
										</div>
											<div class="col-md-8">
												<input type="text" id="date" class="dpcct form-control" readonly="true" />
											</div>
										</div>
									</div>-->
									<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Working">Working Status<span style="color:red;">*</span></label>
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
										<input type="text" id="working_since" name="working_since" class="dpcct form-control" required readonly="true">
									</div>
								</div>
						</div>
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="AssetSubType">Manufacture Date<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" id="manufacturer_year" name="manufacturer_year" class="dpcct form-control" readonly="true">	
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
							</div>	-->
							</div>
					
					
												<!--- row --->	
				<div class="row" style="margin-bottom:10px">
					<div class="col-md-4">
								<div class="row">
										<div class="col-md-4">
											<label for="Catalogue">Catalog ID <span style="color:red;">*</span></label>
										</div>
										<div class="col-md-8">
											<select class="form-control" name="ccm_model_id" id="catalogue_id_main" required>
											<option value="" >--Select Asset--</option>
											<?php if(isset($dataModel) && $dataModel!='') {
														foreach($dataModel as $value){ ?>
															<option value="<?php echo $value['pk_id']; ?>"><?php echo $value['catalogue_id']; ?></option>
													<?php } 
													}?>
											</select>
									</div>
									<!--<div class="col-md-2">
									<button type="button" id='modalid' class="btn btn-success btn-md" data-toggle="modal" title="Add Make and Modal"  data-target="#myModal" style="position:relative"> <i class="fa fa-plus"></i></button>
								   </div>-->
								</div>
						</div>
						<div class="col-md-4">
								<div class="row">
										
										<div class="col-md-4">
												<label for="total"><span>Total Available For Vaccination Activities</span><span style="color:red;">*</span></label>
										</div>
										<div class="col-md-8">
										<input type="text" id="quantity" name="quantity" class="form-control numberclass" required>
										</div>
								</div>
						</div>
						<!--<div class="col-md-4"> 
							<div class="row">
								<div class="col-md-4">
									<label for="Working Since (Year)">Working Since (Year)</label>
								</div>
								<div class="col-md-8">
									<input type="text" id="working_since" name="working_since" class="dpcct form-control" readonly="true" />
								</div>
							</div>
						</div> -->
					</div>
					<!--Row end -->
						<div class="row visibility" style="display: none;">
					<div class="col-md-4">
								<div class="row">
										<div class="col-md-4">
										<label for="make">Make<span style="color:red;">*</span></label>
									</div>
										<div class="col-md-8">
											<select id="ccm_make_main" class="form-control" readonly>
											</select>
									</div>
								</div>
						</div>	
						<div class="col-md-4">
								<div class="row">
										<div class="col-md-4">
											<label for="Model">Model<span style="color:red;">*</span></label>
										</div>
										<div class="col-md-8">
											<select id="ccm_model_main" class="form-control" readonly>
											</select>
										</div>
								</div>
						</div>	
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="InternalDimensions">Internal Dimensions<span style="color:red;">*</span> <small class="text-success"> (Length x Width x Height)</small></label>
									</div>
										<div class="col-md-8">
												<div class="row">
												<div class="col-md-4">
													<input type="text" class="form-control" id="internal_dimension_length_main" name="Capacity" readonly placeholder="Length" title="Length" style="cursor:pointer">
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="internal_dimension_width_main" name="Capacity" readonly placeholder="Width" title="Width" style="cursor:pointer">
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="internal_dimension_height_main" name="Capacity" readonly placeholder="Height" title="Height" style="cursor:pointer">
												</div>
											</div>
										</div>
									</div>
							</div>		
						</div><!--- row --->
						<!--<div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn btn-primary btn-md" style="background:#008d4c none repeat scroll 0% 0%; float: right;"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
							</div>
						</div>-->
						<div class="text-right">
						<div class="row">
							<div class="col-md-5 col-md-offset-7">
							<button type="submit" style="background-color:#00a65a;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="Button" class="btn-background box1" id="cancel1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div>
						</div>
						<!--- row --->
						</form>	
					</div>
				</div>
				</div>
				<!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog" style="display: none;">
					<div class="modal-dialog">
					<form class="modalForm" id="tag-form" action="" method="post" enctype="multipart/form-data">
					<div class="modal-content cst-modal">
						<div class="modal-header" height="35px">
							<h4 class="modal-title-transfer">Suggest new make and model</h4>
						</div>
						<div class="modal-body">
							<div class="row">
							<div class="col-md-12">
								<div class="col-md-3">
									<div class="form-group">
										<label>Catalogue ID <span style="color:red;">*</span></label>
										<input type="text" name="catalogue_id" id="catalogue_id_popup" class="form-control" />
										<input type="hidden" id="asset_type_id" name="asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
										<input type="hidden" id="sub_asset_type_id" name="ccm_sub_asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Make <span style="color:red;">*</span></label>
										<input type="text" name="make_name" id="ccm_make_popup" class="form-control" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Model<span style="color:red;">*</span></label>
										<input type="text" name="model_name" id="ccm_model_popup" class="form-control" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Cost (US$)<span style="color:red;">*</span></label>
										<input type="text" id="product_price" name="product_price" class="form-control numberclass" />
									</div>
								</div>
							</div><!--- row --->
						</div>	
							<!-- -->
								<div class="row radio-row">
									<div class="col-md-12">
										<label class="control-label" for="dimensions">Dimensions<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
									</div>	
								</div>	
								<br>				
								<div class="form-group row">
									<div class="col-md-4"><input name="asset_dimension_length" id="asset_dimension_length_popup" value="" class="form-control numberclass dimension" placeholder="Length"  type="text">      </div>                              
									<div class="col-md-4"><input name="asset_dimension_width" id="asset_dimension_width_popup" value="" class="form-control numberclass dimension" placeholder="Width"  type="text">   </div>                                 
									<div class="col-md-4"><input name="asset_dimension_height" id="asset_dimension_height_popup" value="" class="form-control numberclass dimension" placeholder="Height"  type="text"></div>                                
								</div>
									
								<div class="row radio-row">
									<div class="col-md-12">
										<label class="control-label" for="Dimensions">Dimensions(Internal)<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
									</div>
								</div>	
								<br>
								<div class="form-group row">
									<div class="col-md-4 ">	<input name="internal_dimension_length" id="internal_dimension_length" value="" class="form-control numberclass internaldimension" placeholder="Length"  type="text">          </div>                          
									<div class="col-md-4">	<input name="internal_dimension_width" id="internal_dimension_width" value="" class="form-control numberclass internaldimension" placeholder="Width"  type="text">  </div>                                  
									<div class="col-md-4">	<input name="internal_dimension_height" id="internal_dimension_height" value="" class="form-control numberclass internaldimension" placeholder="Height"  type="text">    </div>                              
								</div>
								
								
								<div class="row radio-row">
									<div class="col-md-12">
										<label class="control-label" for="Dimensions">Dimensions(Storage)<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
									</div>
								</div>	
								<br>
								<div class="form-group row">
									<div class="col-md-4">	<input name="storage_dimension_length" id="storage_dimension_length" value="" class="form-control numberclass storagedimension" placeholder="Length"  type="text">          </div>                          
									<div class="col-md-4">	<input name="storage_dimension_width" id="storage_dimension_width" value="" class="form-control numberclass storagedimension" placeholder="Width"  type="text">  </div>                                  
									<div class="col-md-4">	<input name="storage_dimension_height" id="storage_dimension_height" value="" class="form-control numberclass storagedimension" placeholder="Height"  type="text">    </div>                              
								</div>			
								
								
							<!-- -->	
							
						<hr/>
								<div class="row">
								<div class="col-md-6 col-md-offset-6 text-right">
									<button id="btn-modalForm-submit" type="Button" class="btn-background box1" > <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
									<button type="Button" class="btn-background box1" id="cancel" data-dismiss="modal" style="margin-right:10px;"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
								</div>
								</div>
						</div>
					</div>
				   </div>
				</form>
				</div>
			<!-- Modal end-->
			
		
<script type="text/javascript">
 var res=null;
$(document).on('change','#status_w',function(){
	var id=$(this).val();
	if(id==3){
		$("#res_hid").show();
		$('#reasons').attr('required',true);
	}else{
		$("#res_hid").hide();
		$('#reasons').attr('required',false);
	}
});
$(document).on('change','#catalogue_id_main', function(){
	var id=$(this).val();
	var mainId=$('#assets').val();
	if(id!=""){
		//$("#modelHide").toggle('slow');
		$.ajax({
			type: "POST",
			data: "id="+id+"&mainId="+mainId,
			url: "<?php echo base_url(); ?>Ajax_calls/getmodelData",
			success: function(result){
				var result= JSON.parse(result);
				$("#ccm_model_main").html("<option>"+result.allData.model_name+"</option>");
				$("#ccm_make_main").html("<option>"+result.allData.make_name+"</option>");
				$('#internal_dimension_length_main').val(result.allData.internal_dimension_length);
				$('#internal_dimension_width_main').val(result.allData.internal_dimension_width);
				$('#internal_dimension_height_main').val(result.allData.internal_dimension_height);
				$(".visibility").slideDown(600);
			}
		});
		
	}else{
		$(".visibility").slideUp(600);
	}
});
/* function checkCatalogue_id(catalogue_id)
{
	
	 $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Coldchain/checkCatalogue_id",
        data:{"catalogue_id":catalogue_id},
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
	e.preventDefault();
    var catalogue_id=$('#catalogue_id_popup').val();
	var ccm_make=$('#ccm_make_popup').val();
	var ccm_model=$('#ccm_model_popup').val();
	var catalogue_id_main="";
	catalogue_id_main=catalogue_id+"-"+ccm_make+"-"+ccm_model;
	//checkCatalogue_id(catalogue_id_main);
	
	$.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Coldchain/coldboxSave/TRUE",
        data: $('form.modalForm').serialize(),
        success: function(response) {
            if(response=='required'){
				alert("Please Fill Required Fields!");
			}else{
				$('#catalogue_id_main').html(response);
				$( "#cancel" ).click();
			}
        },
        error: function() {
            alert('Error');
        }
    });
    
});
/** For Dimension Liters Greater Than Zero **/
$('.dimension').on('keyup change', checkdimension);
function checkdimension()
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
			alert("Dimension must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	
}
/** For Internal Dimensions Greater Than Zero **/
$('.internaldimension').on('keyup change', checkinternaldimension);
function checkinternaldimension()
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
			alert("Internal Dimension Must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	
}
/** For Storage Dimension Liters Greater Than Zero **/
$('.storagedimension').on('keyup change', checkstoragedimension);
function checkstoragedimension()
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
			alert("Storage Dimension must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	}
$('#cancel1').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/coldbox_list/33";
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