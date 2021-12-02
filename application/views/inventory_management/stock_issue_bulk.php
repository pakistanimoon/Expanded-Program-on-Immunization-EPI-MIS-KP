<?php
	$currwhtype = $this->session->curr_wh_type;
	$currwhcode = $this->session->curr_wh_code;
	$batchexist = (isset($draftdata) and count($draftdata["batch"]))?true:false;
	if($batchexist && $draftdata["master"]->to_warehouse_code!=0){
		$selectedwhcode = substr($draftdata["master"]->to_warehouse_code,0,1);
		$selectedwhtype = $draftdata["master"]->to_warehouse_type_id;
	}else if($currwhtype=="2"){
		$selectedwhcode = substr($currwhcode,0,1);
		$selectedwhtype = "4";
	}else if($currwhtype=="4"){
		$selectedwhcode = substr($currwhcode,0,1);
		$selectedwhtype = "6";
	}else {
		$selectedwhcode = substr($currwhcode,0,1);
		$selectedwhtype = NULL;
	}
	//echo $selectedwhcode.'moon'.$selectedwhtype;exit;
	$provincesoptions = get_options_html($provinces,true,FALSE,$selectedwhcode);
?>
<section class="content">
    <div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary bt bb bl br ml10 mr10">
				<div class="panel-heading">
					Stock Issue/Dispatch
				</div>
				<div class="panel-body">
<?php if($this -> session -> flashdata('message')){ /* ?><div class="alert alert-info text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php */ } ?>
					<?php echo form_open(base_url().'invnStockIssueSave',array("class"=>"form-horizontal")); ?>
						<div class="row">
							<div class="col-md-3 storetd <?php echo ($batchexist)?'hide':''; ?>">
								<label>Store<span style="color:red">*</span></label>
								<select id="to_warehouse_type_id" name="to_warehouse_type_id" required="required" class="form-control">
									<?php get_warehouse_type_option(FALSE,NULL,$selectedwhtype,false,TRUE); ?>
								</select>
							</div>
							<div class="col-md-3 protd hide">
								<label>Province<span style="color:red">*</span></label>
								<select id="warehouse_province" required="required" class="form-control">
									<?php echo $provincesoptions; ?>
								</select>
							</div>
							<div class="col-md-3 storeloctd storeuctd <?php echo ($batchexist && $draftdata["master"]->to_warehouse_type_id==6)?'':'hide'; ?>">
								<label>Store UC<span style="color:red">*</span></label>
								<select id="uccode" name="uccode" class="form-control" <?php echo ($batchexist)?'disabled="disabled"':''; ?>>
								</select>
							</div>
							<div class="col-md-3 storeloctd <?php echo ($batchexist)?'':'hide'; ?>">
								<label>Store Location<span style="color:red">*</span></label>
								<select id="code"  name="code" required="required" class="form-control" <?php echo ($batchexist)?'disabled="disabled"':''; ?>>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Purpose / Activity<span style="color:red">*</span></label>
								<select id="activity" name="activity" required="required" class="form-control" <?php echo ($batchexist)?'disabled="disabled"':''; ?>>
									<?php get_purposes(FALSE,(($batchexist)?$draftdata["master"]->stakeholder_activity_id:NULL)); ?>
								</select>
							</div>
							<div class="col-md-3">
								<label>Issuance Date<span style="color:red">*</span></label>
								<input class="form-control dpwt" name="trans_date_time"  id="trans_date_time" type="text" <?php echo ($batchexist)?'disabled="disabled" value="'.$draftdata["master"]->transaction_date.'"':' value="'.date("Y-m-d H:i:s").'"'; ?> readonly="readonly">
							</div>
							<div class="col-md-3">
								<label>Reference / Issued By</label>
								<input class="form-control" name="trans_ref" id="trans_ref" type="text">
							</div>
							<div class="col-md-3" style="text-align: right;">
								<label>&nbsp;<span style="color:red">&nbsp;</span></label>
								<button style="background:#008d4c;" type="button" id="additemsbtn" class="btn btn-primary btn-md form-control" role="button"><i class="fa fa-arrow-down "></i> Add Voucher Items </button>
							</div>
						</div>
						<div class="voucheritems <?php echo ($batchexist)?'':'hide'; ?>">
							
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
		store = '<?php echo $draftdata["master"]->to_warehouse_type_id; ?>';
		warehousecode = '<?php echo $draftdata["master"]->from_warehouse_code; ?>';
		if(store==6)
		ucode='<?php echo getUcCode($draftdata["master"]->to_warehouse_code);?>';
	</script><?php
}?>
<script type="text/javascript">
	$(document).on('change','#to_warehouse_type_id',function(){
		var to_warehouse_type_id = $(this).val();		
		if(to_warehouse_type_id > 0){			 
			$(".storeloctd").removeClass("hide");
		}else{
			$(".storeloctd").addClass("hide");
		}		
		if(to_warehouse_type_id>1 && to_warehouse_type_id<7){
			$(".protd").removeClass("hide");
			//to show only current user's province
			/* if(to_warehouse_type_id==4){
				$(".protd").children('option').hide();
    			$(".protd").children("option:selected").show();
			}else{
				$(".protd").children('option').show();
			} */
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
	$(document).on('change','#warehouse_province',function(){
		var to_warehouse_type_id = $('#to_warehouse_type_id').find("option:selected").val();
		var warehouse_procode = $(this).val();
		get_store_locations(to_warehouse_type_id,warehouse_procode);
	});
	/* trigger change of warehouse type on page load */
	$('#to_warehouse_type_id').trigger("change");	
	function get_store_locations(to_warehouse_type_id,warehouse_procode){
		warehouse_procode = warehouse_procode || 0;
		<?php 
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
				result = JSON.parse(result);
				$("select[name="+fieldname+"]").html(result.optionshtml);
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
	$(document).ready(function(){
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
				$("#additemsbtn").attr("disabled","disabled");
			}else{
				$(this).css("border",'');
				$("#additemsbtn").removeAttr("disabled");
			}	
		});
		$(document).on('change','.batch',function(){
			//to remove all those lines in which product has no batch available for stock issue
			var totaloptions = $(this).find("option").length;
			if(totaloptions>0){
				if($(this).find("option:selected").data("location")){
					//var lochtml = '<option value="" >'+$(this).find("option:selected").data("location")+'</option>';
					var lochtml = $(this).find("option:selected").data("location");
				}else{
					var lochtml = '';
				}
				var locparts = lochtml.split("|");
				//$(this).closest("tr").find(".vvm_loc").html(lochtml);
				$(this).closest("tr").find(".location").html(locparts[0]);
				$(this).closest("tr").find(".vvmstage").html(locparts[1]);
				$(this).closest("tr").find(".vvm_locinput").val(lochtml);
				$(this).closest("tr").find(".expiry_date").text($(this).find("option:selected").data("batchexp"));
			}else{
				$(this).closest("tr").remove();
			}
		});
		$(document).on('click','.cloneadd',function(){
			//check if quantity is filled in this row and batch etc are selected, and more than one batch of same product exists.
			var quantityincurrrow = $(this).closest("tr").find(".quantity").val();
			var batchincurrrow = $(this).closest("tr").find(".batch").find("option:selected").val();
			var batchesofprod = $(this).closest("tr").find(".batch").find("option").length;
			if(quantityincurrrow>0 && batchincurrrow>0 && batchesofprod>0){
				var clonedhtml = $(this).closest("tr").clone();
				$(clonedhtml).find("td:first-child").find(".prodtitle").html("");
				$(clonedhtml).find(".requiredcard").html("");
				$(clonedhtml).find(".diststoreavail").html("");
				$(clonedhtml).find(".facstoreavail").html("");
				$(clonedhtml).find(".requestcard").html("");
				$(clonedhtml).find(".quantity").val("");
				$(clonedhtml).find("td:last-child").html('<button type="button" class="btn btn-danger btn-xs clonedel" data-original-title="Delete this Batch"><i class="fa fa-minus"></i></button>');
				$(this).closest("tr").after(clonedhtml);
			}else{
				alert("You can only clone row for second batch entry, either you have not filled required fields in current row or you have only 1 batch of current product available so you cannot clone row.");
			}			
		});
		$(document).on('click','.clonedel',function(){
			//check if quantity is filled in this row and batch etc are selected.
			var quantityincurrrow = $(this).closest("tr").find(".quantity").val();
			var batchincurrrow = $(this).closest("tr").find(".batch").find("option:selected").val();
			if(quantityincurrrow>0 && batchincurrrow>0){
				//confirm before deletion
				var confirmdel = confirm("This will delete current row, Do you really want to remove it?");
				if(confirmdel){
					$(this).closest("tr").remove();
				}				
			}else{
				//just delete row without confirmation
				$(this).closest("tr").remove();
			}			
		});
		var allquantitiesok = true;
		$(document).on('blur','.quantity',function(){
			var currval = parseInt($(this).val());
			//for available quantity
			var selectedtext = $(this).closest("tr").find(".batch").find("option:selected").text().trim();
			var parts = selectedtext.split(' | ');
			var avlquantity = parts[2];
			var available = avlquantity;
			if(currval){
				if((currval>0) && (currval<=available)){
					$(this).css("border",'');
					//$("#issuebtn").removeAttr("disabled");//work remaining
				}else{
					$(this).css("border",'1px solid red');
					alert("Quantity Not Valid/Available!!!");
					allquantitiesok = false;
					//$("#issuebtn").attr("disabled","disabled");//work remaining
				}
			}
		});
		$(document).on('click','#additemsbtn',function(){
			//validation about basic fields selected or not.
			var whtype		= $('#to_warehouse_type_id').val();
			var whcode		= $('#code').val();
			var activity	= $('#activity').val();
			var transdate	= $('#trans_date_time').val();
			var currdate	= '<?php echo date("Y-m-d H:i:s"); ?>';
			if(whtype>0 && whcode>0 && activity>0 && transdate<=currdate){
				//check if table already shown or not
				var eraseAll = false;
				if($(".voucheritems").hasClass("hide")){
					eraseAll = true;
				}else{
					//table already shown confirm from user to refresh.
					eraseAll = confirm("Do you want to reset all items according to new store and purpose selection?\n It will erase your selection(s) in below table.");
				}
				//freeze basic panel and allow items addition by showing items panel and disable button click
				if(eraseAll){
					$(".voucheritems").removeClass("hide");
					//ajax to get items table
					$.ajax({
						type: "post",
						data: {activity:activity,transdate:transdate,whtype:whtype,whcode:whcode},
						url: "<?php echo base_url("issuebulkitems"); ?>",
						success: function(result){
							try {
								$(".voucheritems").html(result);
								$(".voucheritems").removeClass("hide");
								//here execute batch fetching and other ajax calls
								$(".batch").trigger("change");
								//fetch requisition of all products
								showAutoReqPanel();
							} catch(error) {
								alert("Some Error in data fetching!!");
							}
						}
					});
				}
			}else{
				//show error messages, hide item details panel and unfreeze basic panel
				$(".voucheritems").addClass("hide");
				$(".voucheritems").html("");
				alert("Some Required Fields are empty, please fill them first!");
			}
		});
		$(document).on('click','#issuebtn',function(){
			$('#issuebtn').prop('disabled', true);
			//validating selected batches must not be repeat, mean one batch can be selected in one row only.
			//collect the values from all selected options;
	     	var  arr = $.map($('.batch option:selected'), function(n){
				return n.value;
			});
			var dupnotexist = true;
			var sorted_arr = arr.sort();   
        	for (var i = 0; i < sorted_arr.length - 1; i++) {
            	if (sorted_arr[i + 1] == sorted_arr[i]) {  
                	dupnotexist = false;
					alert("You have selected same batches in multiple rows, please choose one batch in a row.");
					$(".batch option:selected[value^="+sorted_arr[i]+"]").closest(".batch").css("border",'1px solid red');
					$('#issuebtn').prop('disabled', false);
					break;
           		}else{
					$(".batch option:selected[value^="+sorted_arr[i]+"]").closest(".batch").css("border",'');
				}
        	}
			if(dupnotexist){
				//validate quantities
				allquantitiesok = true;
				$(".quantity").trigger("blur");
				if(allquantitiesok){
					var urltopost = $(this).closest("form").attr("action");
					var errorproducts = [];
					$('.batch option:selected').each(function(){
						//validate if this batch has quantity in field only then save it
						var askedquantity = $(this).closest("tr").find(".quantity").val();
						if(askedquantity>0){
							$.ajax({
								type: "POST",
								async: false,
								data: {
									to_warehouse_type_id:$("#to_warehouse_type_id").find("option:selected").val(),
									code:$("#code").find("option:selected").val(),
									activity:$("#activity").find("option:selected").val(),
									trans_date_time:$("#trans_date_time").val(),
									trans_ref:$("#trans_ref").val(),
									product:$(this).closest("tr").find(".product").val(),
									batch:$(this).val(),
									vvm_loc:$(this).closest("tr").find(".vvm_loc").find("option:selected").val(),
									quantity:askedquantity,
									item_unit_id:$(this).closest("tr").find(".item_unit_id").val(),
								},
								url: urltopost,
								success: function(result){									
									var output = jQuery.parseJSON(result);
									if(output.result==="false"){
										errorproducts.push(output.msg);
										//return false;
									}		
								}
							});
						}
					});
					//some work remaining to show nice messages and make redirection process efficient
					if (errorproducts.length === 0) {
						alert("Item(s) Added in voucher Successfully!!!!");
						location.reload();
					}
					else {
						var messages = errorproducts.join("\n");
						alert("There are error(s) in adding some Item(s) to voucher!!!!\n"+messages);
						$('#issuebtn').prop('disabled', false);
					}
				}
			}
		});
		$(document).on('click','.actiondel',function(){
			if(confirm("Do You realy want to delete this?")){
				var batchId = $(this).data("id");
				var masterId = $(this).data("masterid");
				var batchnum = $(this).data("batchnum");
				$.ajax({
					type: "POST",
					datatype: "JSON",
					data: {batch: batchId,master: masterId,batchnum: batchnum},
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
		  //code  here for restrict double click on button when confirmation yes to dispacth button
			$(document).on('click','.batch_masterid',function(){
				$(this).attr("disabled","disabled");
				$(this).prop('disabled', true);
				var res=confirm('Are you sure you want to save the list?');
				if(res)
				{
					$(this).prop('disabled', true);
					$(this.form).submit();
					
				}
				else
				{
					$(this).removeAttr("disabled");
					return false;
				}
			});
		$(document).on('change','#trans_date_time',function(){
			$('#additemsbtn').trigger("click");
		});
		var options = {
		  format : "yyyy-mm-dd",
			color: "green"
		};
		$('.invndp').datepicker(options);
	});
	function showAutoReqPanel(){
		//$(".product").each(function(){
			//var productId = $(this).val();
			//var formrownum = $("#product"+productId).data("formrownum");
			//if(formrownum>0){
				var selectedStoreCode = $("#code").find("option:selected").val();
				var selectedStoreType = $("#to_warehouse_type_id").find("option:selected").val();
				//var doses = $("#product"+productId).data("doses");
				//var categoryid = $("#product"+productId).data("categoryid");
				//var trans_date_time = $("#trans_date_time").val();
				if((selectedStoreType==6 || selectedStoreType==4) /* && productId>0  */ &&selectedStoreCode>0){
					//get suggestion values via ajax
					$.ajax({
						type: "POST",
						datatype: "JSON",
						data: {storecode: selectedStoreCode, storetype: selectedStoreType},
						url: "<?php echo base_url("fetch_req_cache"); ?>",
						success: function(result){
							result = JSON.parse(result);
							//var unit = $("#product"+productId).closest("tr").find(".unittext").text();							
							if (typeof result.balanceParts == "undefined") {
								$("#rec_date").html(result[0]['rec_datetime']);
								$.each(result, function (index, value) {
									//console.log(value);
									var unit = $("#product"+value.item_id).closest("tr").find(".unittext").text();
									$("#product"+value.item_id).closest("tr").find(".availablecard").text(value.available+' '+unit);
									$("#product"+value.item_id).closest("tr").find(".requiredcard").html("&#8776; "+value.suggested+' '+unit);
									$("#product"+value.item_id).closest("tr").find(".requestcard").html("&#8776; "+value.requisition+' '+unit);
									// Get the items
									//var items = this.items; // Here 'this' points to a 'group' in 'groups'
									//console.log(value.item_id);
									// Iterate through items.
									// $.each(items, function () {
									// 	console.log(this.text); // Here 'this' points to an 'item' in 'items'
									// });
								});
							}else{
							var partsdata = result.balanceParts;
							$("#rec_date").html(partsdata['distbalance'][0]['rec_datetime']);
							//console.log(partsdata);
							//$("#product"+productId).closest("tr").find(".diststoreavail").text(partsdata.distbalance);
							//$("#product"+productId).closest("tr").find(".facstoreavail").text(partsdata.facbalance);
							$.each(partsdata.distbalance, function (index, value) {
									//console.log(value);
									var unit = $("#product"+value.item_id).closest("tr").find(".unittext").text();
									//alert(unit);
									$("#product"+value.item_id).closest("tr").find(".diststoreavail").text(value.available+' '+unit);
									$("#product"+value.item_id).closest("tr").find(".requiredcard").html("&#8776; "+value.suggested+' '+unit);
									$("#product"+value.item_id).closest("tr").find(".requestcard").html("&#8776; "+value.requisition+' '+unit);
							});
							$.each(partsdata.facbalance, function (index, value) {
									//console.log(value);
									var unit = $("#product"+value.item_id).closest("tr").find(".unittext").text();
									//alert(unit);
									$("#product"+value.item_id).closest("tr").find(".facstoreavail").text(value.facbalance+' '+unit);
							});
								
						}
						},
					
					});
				}else{
					////$("#auto_req_panel").hide();
				}			
			//}else{
				////$("#auto_req_panel").hide();
			//}
		//});
	}	
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
	function refresh(obj){
		if(confirm("Do You realy want to refresh this?")){
			var code = obj.getAttribute('data-code');
			var type = obj.getAttribute('data-type');

            $.ajax({
            type: "POST",
            url: '<?php echo base_url("/requisition_refresh"); ?>',
            data: {"storecode":code, "storetype":type},
			dataType:'json',
            success: function(data){
                //$('#311140').remove();
                //alert(data.code);
				//alert('Requisitopn refrshed');
				$('#additemsbtn').trigger("click");
			}
        });
		}
    }
</script>