<?php 
 

//$ccloctypeshtml = get_options_html($ccloctypes,true);

 $batchexist = (isset($draftdata) and count($draftdata["batch"]))?true:false;
 $provincesoptions = get_options_html($provinces,true,FALSE,(($batchexist && $draftdata["master"]->to_warehouse_code!=0)?substr($draftdata["master"]->to_warehouse_code,0,1):NULL));
?>
<section class="content">
    <div class="container bodycontainer">
		<div class="row">

			<div class="panel panel-default bb bt bl br" id="auto_req_panel">
				<div class="panel-heading" style="color:white">
					<!--<h4 class="panel-title" style="color:white">-->
						Automatic(System Generated) Stock Requisition
					<!--</h4>-->
				</div>
				<div class="panel-body" style="padding:8px">
					<div class="card-deck">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 animated fadeInDown card purple" style="border: 3px solid;">
							<i class="icon fa fa-adjust fa-3x"></i>
							<div class="figures" style="width:88%;">
								<div class="storewiseavail bt bb bl br hide" style="width:52%">
									<div class="bb" style="font-size: 16px;text-align: right;">
										<span style="float:left;">Facility Store</span><span id="facstoreavail" style="float:right;">5</span>
									</div>
									<div style="font-size: 16px;text-align: right;">
										<span style="float:left;">District Store</span><span id="diststoreavail" style="float:right;">10</span>
									</div>
								</div>
								<div style="width:48%;float:right">
									<div class="title" id="availablecard">0</div>
									<div class="sub-title" style="float:right">
										Available Stock 
										<span title="Available balance at selected facility according to last submitted report" class="glyphicon glyphicon-info-sign moonicon" data-container="body" data-toggle="popover" data-placement="top" data-original-title="Popover" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." rel="popover" aria-hidden="true"></span>
									</div>
								</div>
								
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 animated fadeInDown card green card" style="border: 3px solid;">
							<i class="icon fa fa-balance-scale fa-3x"></i>
							<div class="figures">
								<div class="title" id="requiredcard">0</div>
								<div class="sub-title">
									Required Stock
									<span title="Required stock at selected facility for apprx 45 days." class="glyphicon glyphicon-info-sign moonicon" aria-hidden="true"></span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 animated fadeInDown card blue card" style="border: 3px solid;">
							<i class="icon fa fa-exchange fa-3x"></i>
							<div class="figures">
								<div class="title" id="requestcard">0</div>
								<div class="sub-title">
									Stock Requisition
									<span title="Stock Needed at selected facility to fullfill basic requirement of available stock." class="glyphicon glyphicon-info-sign moonicon" aria-hidden="true"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					Stock Issue/Dispatch
				</div>
				<div class="panel-body">
					<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-info text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
					<?php echo form_open(base_url().'invnStockIssueSave',array("class"=>"form-horizontal")); ?>
						
						
						
						
						<table class="table table-bordered table-condensed tbl-im">
							<tbody>
								<tr>
									<td>
										<label>Issue No.</label>
										<input readonly="readonly" id="trans_numb" class="form-control"  type="text" value="<?php echo ($batchexist)?'TEMP':''; ?>">
									</td>
									<td style="position:relative;">
										<label>Date</label>
										<input class="form-control dpwt" name="trans_date_time"  id="trans_date_time" type="text" <?php echo ($batchexist)?'disabled="disabled" value="'.$draftdata["master"]->transaction_date.'"':' value="'.date("Y-m-d H:i:s").'"'; ?> readonly="readonly">
									</td>
									<td>
										<label>Issue Reference</label>
										<input class="form-control" name="trans_ref" id="trans_ref" type="text" <?php echo ($batchexist)?'readonly="readonly" value="'.$draftdata["master"]->transaction_reference.'"':''; ?>>
									</td>
									<td>
										<label>Purpose <span style="color:red">*</span></label>
										<select id="activity" name="activity" required="required" class="form-control" <?php echo ($batchexist)?'disabled="disabled"':''; ?>>
											<?php get_purposes(FALSE,(($batchexist)?$draftdata["master"]->stakeholder_activity_id:NULL)); ?>
										</select>
									</td>
								</tr>
								<tr>									
									<td class="storetd <?php echo ($batchexist)?'hide':''; ?>">
										<label>Store<span style="color:red">*</span></label>
										<select id="to_warehouse_type_id" name="to_warehouse_type_id" required="required" class="form-control">
											<?php get_warehouse_type_option(FALSE,NULL,(($batchexist)?$draftdata["master"]->to_warehouse_type_id:NULL),false,TRUE); ?>
										</select>
									</td>
									<td class="protd hide">
										<label>Province<span style="color:red">*</span></label>
										<select id="warehouse_province" required="required" class="form-control">
											<?php echo $provincesoptions; ?>
										</select>
									</td>
									<td class="storeloctd storeuctd <?php echo ($batchexist && $draftdata["master"]->to_warehouse_type_id==6)?'':'hide'; ?>">
										<label>Store UC<span style="color:red">*</span></label>
										<select id="uccode" name="uccode" class="form-control" <?php echo ($batchexist)?'disabled="disabled"':''; ?>>
										</select>
									</td>
									<td class="storeloctd <?php echo ($batchexist)?'':'hide'; ?>">
										<label>Store Location<span style="color:red">*</span></label>
										<select id="code"  name="code" required="required" class="form-control" <?php echo ($batchexist)?'disabled="disabled"':''; ?>>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<label>Product <span style="color:red">*</span></label>
										<select id="product" name="product" required="required" class="form-control">
										</select>
									</td>
									<td>
										<label> Manufacturer | Batch | Quantity | Priority <span style="color:red">*</span></label>
										<select id="batch" name="batch" required="required" class="form-control">
										</select>
									</td>
									<td>
										<label> Location | VVM Stage <span style="color:red">*</span></label>
										<select id="vvm_loc" name="vvm_loc" required="required" class="form-control">
											
										</select>
									</td>
									<td>
										<label> Quantity <span style="color:red">*</span></label>
										<input class="form-control" name="quantity" id="quantity" required="required" type="text" style="width: 86%;">
										<span  id="unittext" style="float: right;margin-top: -27px;">Vials</span>
										<input type="hidden" id="item_unit_id" name="item_unit_id" value="" >
									</td>
								</tr>
								<tr>
									<td>
										<label>Total available batch quantity<span style="color:red">*</span></label>
										<input class="form-control" id="available_quantity" readonly="readonly" disabled="disabled" value="" type="text">
									</td>
									<td>
										<label> Expiry Date <span style="color:red">*</span></label>
										<input class="form-control invndp" id="expiry_date" readonly="readonly" disabled="disabled" type="text">
									</td>
									<td>
										<label>Dispatch By<span style="color:red">*</span></label>
										<input class="form-control" name="unit_price" required="required" id="unit_price" type="text">
									</td>
								</tr>
							</tbody>
						</table>


						


						<div class="row">      
							<div style="text-align: right;" class="col-md-5 col-md-offset-6 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
								<button style="background:#008d4c;" type="button" id="issuebtn" class="btn btn-primary btn-md" role="button"><i class="fa fa-plus "></i> Add Issue </button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div> <!--end of panel body-->
				<div class="panel-body <?php echo ($batchexist)?'':'hide'; ?>" id="issue_panel">
					<div class="panel-heading">Issue List</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-condensed tbl-im">
								<thead>
									<tr>
										<th>Date</th>
										<th>Product</th>
										<th>Unit</th>
										<th>From Store</th>
										<th>To Store</th>
										<th>Issued</th>
										<th>Batch</th>
										<th>Expiry Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="receive_list"><?php 
									$this->load->view("inventory_management/ajax/stock_issue_list.php");?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<script type="text/javascript">
	 selectedstoreloc = '';
	
</script>
<?php if($batchexist){?>
	<script type="text/javascript">
		var selectedstoreloc = '<?php echo $draftdata["master"]->to_warehouse_code; ?>';
		//alert(selectedstoreloc);
		store = '<?php echo $draftdata["master"]->to_warehouse_type_id; ?>';
		warehousecode = '<?php echo $draftdata["master"]->from_warehouse_code; ?>';
		if(store==6)
		ucode='<?php echo getUcCode($draftdata["master"]->to_warehouse_code);?>';
		$('#to_warehouse_type_id').trigger("change");
	
		
	</script><?php
}?>
<script type="text/javascript">
	//to hide requisition panel at load
	$("#auto_req_panel").hide();
	/* $("#moonicon").click(function(){
		$('#moonicon').popover('show');
	}); */
	$(document).on('change','#to_warehouse_type_id',function(){
		var to_warehouse_type_id = $(this).val();		
		if(to_warehouse_type_id > 0){			 
			$(".storeloctd").removeClass("hide");
		}else{
			$(".storeloctd").addClass("hide");
		}		
		if(to_warehouse_type_id>1 && to_warehouse_type_id<7){			
			$(".protd").removeClass("hide");			
			$('#warehouse_province').trigger("change");
		}else{			
			$(".protd").addClass("hide");
			get_store_locations(to_warehouse_type_id);			
		}		
		if(to_warehouse_type_id==6){			
			$(".storeuctd").removeClass("hide");			
		}else{
			$(".storeuctd").addClass("hide");
		}
	});
	
	/*cond need to set */
	//$('#to_warehouse_type_id').trigger("change");
	$(document).on('change','#warehouse_province',function(){
		var to_warehouse_type_id = $('#to_warehouse_type_id').find("option:selected").val();
		var warehouse_procode = $(this).val();
		get_store_locations(to_warehouse_type_id,warehouse_procode);
	});
	function get_store_locations(to_warehouse_type_id,warehouse_procode){
		warehouse_procode = warehouse_procode || 0;<?php 
		if($batchexist){?>
			var selectedstoreloc = '<?php echo $draftdata["master"]->to_warehouse_code; ?>';<?php
		}?>
		var fieldname='';
		if(to_warehouse_type_id==6){
			 fieldname = 'uccode';
		}else{
			 fieldname = 'code';
		}
		$("select[name="+fieldname+"]").html('');$('#'+fieldname).trigger("change");
		$.ajax({
			type: "POST",
			datatype: "JSON",
			data: {to_warehouse_type_id: to_warehouse_type_id,warehouse_procode:warehouse_procode},
			url: "<?php echo base_url("getstoreloc"); ?>",
			success: function(result){
				//alert("here");
				result = JSON.parse(result);
				$("select[name="+fieldname+"]").html(result.optionshtml);
				
				//$("select[name=uccode]").html(result.optionshtml);
				if(selectedstoreloc!==''){
				
					if(to_warehouse_type_id!=6){
					$('#'+fieldname).val(selectedstoreloc);
					}
					else
					{
						<?php if($batchexist){?>
						$('#'+fieldname).val(ucode);
						$('#code').val(selectedstoreloc);
						<?php 
						}
						?>
					}	
				}
				$('select[name='+fieldname+']').trigger("change");
			}
		});
	}
	function showAutoReqPanel(){
		var formrownum = $("#product").find("option:selected").data("formrownum");
		if(formrownum>0){
			var selectedStoreCode = $("#code").find("option:selected").val();
			var selectedStoreType = $("#to_warehouse_type_id").find("option:selected").val();
			var selectedProduct = $("#product").find("option:selected").val();
			var doses = $("#product").find("option:selected").data("doses");
			var categoryid = $("#product").find("option:selected").data("categoryid");
			if((selectedStoreType==6 || selectedStoreType==4) && selectedProduct>0 && selectedStoreCode>0){
				//get suggestion values via ajax
				$.ajax({
					type: "POST",
					datatype: "JSON",
					data: {storecode: selectedStoreCode,storetype:selectedStoreType,product:selectedProduct,rownum:formrownum,doses:doses,category:categoryid},
					url: "<?php echo base_url("autoProdRequisition"); ?>",
					success: function(result){
						result = JSON.parse(result);
						console.log(result);
						var unit = $("#product").find("option:selected").data("unittitle");
						$("#availablecard").text(result.balance+' ('+unit+')');
						$("#requiredcard").html("&#8776; "+result.required+' ('+unit+')');
						$("#requestcard").html("&#8776; "+result.requisition+' ('+unit+')');
						if (typeof result.balanceParts != "undefined") {
							var partsdata = result.balanceParts;
							$(".storewiseavail").removeClass("hide");
							$(".figures").css("display","flex");
							$("#facstoreavail").text(partsdata.facbalance);
							$("#diststoreavail").text(partsdata.distbalance);
						}else{
							$(".storewiseavail").addClass("hide");
							$(".figures").css("display","");
						}
						//display:flex;
						//to show requisition panel
						$("#auto_req_panel").show();
					}
				});
			}else{
				/* var panelTitle = '';
				var availableStock = '';
				var reqStock = '';
				var stockRequisition = ''; */
				$("#auto_req_panel").hide();
			}			
		}else{
			$("#auto_req_panel").hide();
		}
	}
	$(document).ready(function(){
		//$('[data-toggle="popover"]').popover("show");
		$(document).on('change','#activity',function(){
			var activityId = $(this).val();
			$("select[name=product]").html('');
			$.ajax({
				type: "POST",
				datatype: "JSON",
				data: {activity: activityId,createoptions:true},
				url: "<?php echo base_url("productsByActivities"); ?>",
				success: function(result){
					result = JSON.parse(result);
					$("select[name=product]").html(result.optionshtml);
					$('#product').trigger("change");
				}
			});
		});
		$(document).on('change','#uccode',function(){
			var curruc = $(this).val();
			$("select[name=code]").html('');
			$.ajax({
				type: "POST",
				datatype: "JSON",
				data: {warehouse_uccode: curruc,createoptions:true},
				url: "<?php echo base_url("getfacstoreloc"); ?>",
				success: function(result){
					result = JSON.parse(result);
					$("select[name=code]").html(result.optionshtml);
					<?php if($batchexist){?>
					$('#code').val(selectedstoreloc);
					<?php } ?>
					$('#code').trigger("change");
					
					
				}
			});
		});
		$(document).on('change','#code',function(){
			var selectedstorecode = $(this).find("option:selected").val();
			var selectedstoretype = $("#to_warehouse_type_id").find("option:selected").val();
			var currwhtype = '<?php echo $this->session->curr_wh_type; ?>';
			var currwhcode = '<?php echo $this->session->curr_wh_code; ?>';
			if(selectedstorecode==currwhcode && selectedstoretype==currwhtype){
				$(this).css("border",'1px solid red');
				alert("Please select another store!!!");
				$("#issuebtn").attr("disabled","disabled");

				$("#auto_req_panel").hide();
			}else{
				$(this).css("border",'');
				$("#issuebtn").removeAttr("disabled");
				//if(selectedstorecode>0 && selectedstoretype==6)
				//{
					showAutoReqPanel();					
				//}
			}	
		});
		$(document).on('change','#product',function(){
			var productId = $(this).val();
			//itemcatid = $("#product").find("option:selected").data("categoryid");
			itemunitid = $("#product").find("option:selected").data("unitid");
			unittitle = $("#product").find("option:selected").data("unittitle");
			transdate = $("input[name=trans_date_time]").val();
			$("select[name=batch]").html('');			
			$.ajax({
				type: "POST",
				datatype: "JSON",
				data: {product: productId,transdate: transdate,createoptions:true,stockissue:true},
				url: "<?php echo base_url("priorityDetailsByProduct"); ?>",
				success: function(result){
					result = JSON.parse(result);
					//console.log(result);
					$("select[name=batch]").html(result.mnfctrhtml);
					//$("select[name=vvm_loc]").html(result.lochtml);
					$('select[name=batch]').trigger("change");
				}
			});			
			$("#item_unit_id").val(itemunitid);
			$("#unittext").text(unittitle);
			//to show auto requisition panel
			var selectedstorecode = $(this).find("option:selected").val();
			var selectedstoretype = $("#to_warehouse_type_id").find("option:selected").val();
			//if(selectedstorecode>0 && selectedstoretype==6)
			//{
				showAutoReqPanel();					
			//}
		});
		$(document).on('change',"input[name=trans_date_time]",function(){
			$("#product").trigger("change");

		});
		$(document).on('change','#batch',function(){
			var selectedindex = $(this).find("option:selected").index();
			//$("select[name=vvm_loc] option").eq(selectedindex).prop("selected",true);location
			if($(this).find("option:selected").data("location")){
				var lochtml = '<option value="" >'+$(this).find("option:selected").data("location")+'</option>';
			}else{
				var lochtml = '';
			}
			$("select[name=vvm_loc]").html(lochtml);
			//extract quantity and show in readonly field
			var selectedtext = $(this).find("option:selected").text().trim();
			var parts = selectedtext.split(' | ');
			var avlquantity = parts[2];
			$("#available_quantity").val(avlquantity);
			$("#expiry_date").val($(this).find("option:selected").data("batchexp"));
		});
		$(document).on('blur','#quantity',function(){
			var currval = parseInt($(this).val());
			var available = parseInt($("#available_quantity").val());
			if((currval>0) && (currval<=available)){
				$(this).css("border",'');
				$("#issuebtn").removeAttr("disabled");
			}else{
				$(this).css("border",'1px solid red');
				alert("Quantity Not Valid/Available!!!");
				$("#issuebtn").attr("disabled","disabled");
			}
		});
		$('#activity').trigger("change");
		$(document).on('click','#issuebtn',function(){
			
			$.ajax({
				type: $(this).closest("form").attr("method"),
				data: $(this).closest("form").serialize(),
				url: $(this).closest("form").attr("action"),
				success: function(result){
					try {
						var output = jQuery.parseJSON(result);
						if(output.result==="false"){
							//error
							alert(output.msg);
						}else{
							alert("New Record Added Successfully!!!!");
							var totrows = $("#receive_list").find("tr").length;
							if(totrows>0){}else{$("#issue_panel").show();}
							$("#receive_list").html(result);
							$("#issue_panel").removeClass("hide");
							location.reload();
						}	
					} catch(error) {						
						alert("New Record Added Successfully!!!!");
						var totrows = $("#receive_list").find("tr").length;
						if(totrows>0){}else{$("#issue_panel").show();}
						$("#receive_list").html(result);
						$("#issue_panel").removeClass("hide");
						location.reload();
					}				
				}
			});
		});
		$(document).on('click','.actiondel',function(){
			if(confirm("Do You realy want to delete this?")){
				var batchId = $(this).data("id");
				var masterId = $(this).data("masterid");
				$.ajax({
					type: "POST",
					datatype: "JSON",
					data: {batch: batchId,master: masterId},
					url: "<?php echo base_url("delinvnIssue"); ?>",
					success: function(result){
						var output = JSON.parse(result);
						if(output.result==="false"){
							alert(output.msg);
						}else if(output.result==="true"){
							alert(output.msg);
							location.reload();
						}
					}
				});
			}
		});
		var options = {
		  format : "yyyy-mm-dd",
			color: "green"
		};
		$('.invndp').datepicker(options);
	});
</script>
<?php if($batchexist){?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#warehouse_province').trigger("change");
			
		});
	</script><?php
}?>
<script type="text/javascript">	
	$(document).ready(function(){
		var options = {
			format : "yyyy-mm-dd",
			color: "green"
		};
		$('.dpinvn').datepicker(options);
		
	});
	$(document).on('click','#stock_issue_dispatch_list',function(){
	
		
		var url="<?php echo base_url();?>StockIssueDispatch";
		window.open(url,"_blank"); 
	});
	/* //function to chk 
	 function chkfac_db()
	{
		var uccode=$('#uccode').val();
		var facode=$('#code').val();
		var date=$('#trans_date_time').val();
		if((uccode  > 0) && (facode > 0) )
		{
			$.ajax({
			type: "GET",
			datatype: "JSON",
			data: {"uccode":uccode,"facode":facode,"tdate":date},
			url: "<?php echo base_url("chckFacIssuedb"); ?>",
			success: function(result){
				var arr=JSON.parse(result);
				console.log(arr);
				if(arr.length > 0){
				alert("Aleady added for this month Issue date. Please Change Issue Date.");
				$("#issuebtn").attr("disabled","disabled");
				}
				else
				{
					$("#issuebtn").removeAttr("disabled");
				}
			}
		});
		} 
	}  */
</script>