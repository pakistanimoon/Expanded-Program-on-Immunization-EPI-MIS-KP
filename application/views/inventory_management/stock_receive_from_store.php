<?php 
$nonccloctypeshtml = isset($nonccloctypes)?get_options_html($nonccloctypes,true):false;
$ccloctypeshtml = isset($ccloctypes)?get_options_html($ccloctypes,true):false;
$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true):false;
$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true,array("nature"=>"nature"),(validation_errors()?set_value('reason'):NULL)):false;
?>
<section class="content">
	<div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"> Stock Receive (Store)</div>
				<div class="panel-body">
					<?php echo form_open(base_url().'StockReceivefromStore',array("class"=>"form-horizontal")); ?>
						<table class="table table-condensed tbl-im" style="width: 40%;">
							<tbody>
								<tr>
									<td>
										<label style="padding:5px;"> Issue No.</label>
									</td>
									<td>
										<input class="form-control" name="stock_issue_num" id="stock_issue_num" required="required" type="text" value="<?php echo isset($issue_num)?$issue_num:NULL; ?>">
									</td>
									<td>
										<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-search "></i> Search  </button>
									</td>
								</tr>
								<?php if(isset($msg)){
									echo '<tr><td colspan="3" style="color:red">'.$msg.'</td></tr>';
								}?>
								<?php if($this -> session -> flashdata('message')){
									echo '<tr><td colspan="3" style="color:green">'.$this -> session -> flashdata('message').'</td></tr>';
								}?>
							</tbody>
						</table>
					<?php echo form_close(); ?>
					<?php if(validation_errors()){  ?>
						<div class="alert alert-warning alert-dismissible alert-xs" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Message! </strong><?php echo validation_errors(); ?>
						</div> <?php 
					} ?>
					<?php echo form_open(base_url().'StockReceivefromStoreSave',array("class"=>"form-horizontal")); ?>
						<?php if(isset($draftdata)){ ?>
							<table id="table" class="table table-bordered tbl-listing text-center">
								<thead>
									<tr>
										<th rowspan="2">S.No</th>
										<th rowspan="2">Product</th>
										<th rowspan="2">Purpose</th>
										<th rowspan="2">Batch No.</th>
										<th colspan="2">Quantity</th>	
										<th rowspan="2">Manufacturer</th>
										<th rowspan="2">Expiry Date</th>										
										<th rowspan="2">VVM Stage</th>
										<th rowspan="2">Store in</th>
										<th colspan="3">Adjusted Quantity</th>
										<th colspan="2">Received Quantity</th>
										<th rowspan="2"><input type="checkbox" class="allchkbox"/></th>
									</tr>
									<tr>									
										<th>Doses</th>
										<th>Vials/Pieces</th>
										<th>Reason</th>
										<th>Doses</th>
										<th>Vials/Pieces</th>
										<th>Doses</th>
										<th>Vials/Pieces</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$checksum = array();
									foreach($draftdata["batch"] as $key=>$onebatch){
										//$vials = $onebatch["quantity"];
										$vials = $draftdata["detail"][$key]["quantity"];
										//$doses =($onebatch["quantity"]*$onebatch["number_of_doses"]);
										$doses =($vials*$onebatch["number_of_doses"]);
										?>
										<tr data-doses="<?php echo $onebatch["number_of_doses"]; ?>" data-cat="<?php echo $onebatch["item_category_id"]; ?>">
											<td><?php echo ($key+1); ?></td>
											<td><?php echo get_product_name(true,$onebatch["item_pack_size_id"]); ?></td>
											<td><?php echo $onebatch["purpose"]; ?></td>
											<td><?php echo $onebatch["number"]; ?></td>
											<td><?php echo $doses; ?></td>
											<td><?php echo $vials; ?></td>
											<td>	<?php echo get_manufacturer_name(false,$onebatch['stakeholder_id']); ?></td>
											<td>	<?php echo $onebatch['expiry_date']; ?></td>
											
											<td>
												<?php if($draftdata["detail"][$key]["vvm_stage"]!=""){ ?>
													<select class="form-control" name="vvm_stage[<?php echo $key; ?>]">
														<?php get_prod_vvmStage_options($onebatch["item_pack_size_id"],true,$draftdata["detail"][$key]["vvm_stage"]); ?>
													</select>
												<?php }else{
													echo '';
												}?>
											</td>
											<td>
												<select class="form-control" name="location[]"><option value="">Select</option><?php echo ($onebatch["item_category_id"]==="1")?$ccloctypeshtml:$nonccloctypeshtml; ?></select>
												<input type="hidden" name="location_type[]" value="<?php echo ($onebatch["item_category_id"]==="1")?"ccm_id":"non_ccm_id"; ?>" >
											</td>
											<td><select class="form-control" name="reason[]"><option value="">Select</option><?php echo $adjsttypeshtml; ?></select></td>
											<td><input class="form-control numberclass" type="text" name="doses[]" readonly required="required"></td>
											<td><input class="form-control numberclass" type="text" name="vials[]" readonly required="required"></td>
											<td class="received_doses"><?php echo $doses; ?></td>
											<td class="received_vials"><?php echo $vials; ?></td>
											<td>
												<input class="form-control rowchkbox" type="checkbox" value="<?php echo $key; ?>" name="addit[]">
												
												<input type="hidden"  name="activity[]" value="" >
												<input type="hidden"  name="masterid[]" value="<?php echo set_value('masterid'); ?>" >
												<input type="hidden"  name="item_unit_id[]" value="" >
												<input type="hidden"  name="transactionnature[]" value="" >
												<input class="form-control" type="hidden" value="<?php echo $onebatch["pk_id"]; ?>" name="batchid[]">
											</td>
											
										</tr><?php
									}?>
									<tr>
										<td>
											<label>Remarks</label>
										</td>
										<td colspan="2">
											<input class="form-control" name="receive_remarks" id="receive_remarks" required="required" type="text">
										</td>
										<td colspan="2">
											<label>Receive Reference </label>
										</td>
										<td colspan="2">
											<input class="form-control" name="receive_ref" id="receive_ref" required="required" type="text">
										</td>
										<td>
											<label>Received Date</label>
										</td>
										<td colspan="2">
											<input class="form-control dpissue" name="receive_date" id="receive_date" type="text" value="<?php echo $draftdata["master"]->transaction_date; ?>" readonly="readonly">
										</td>
										<td>
											<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" id="receivesavebtn" role="button" disabled>Save</button>
										</td>
									</tr>
								</tbody>
							</table>
							<input type="hidden" name="searchedissuenum" value="<?php echo isset($issue_num)?$issue_num:NULL; ?>" > 
						<?php } ?>
					<?php echo form_close(); ?>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<script type="text/javascript">
	$(document).ready(function(){
		var issuedate=$('.dpissue').val();
		var sdate=new Date(issuedate);
		$('.dpissue').datetimepicker({
			format : 'yyyy-mm-dd hh:ii:ss',
			startView : 3,
			startDate:sdate,
			viewDate: new Date(),
			endDate : new Date(),
			todayHighlight : true,
			todayBtn : true
		});
		/* $(".allchkbox").click(function(){
			$('.rowchkbox').not(this).prop('checked', this.checked);
		}); */
		$(".allchkbox").click(function(){
			if(this.checked) 
			{
				$('#receivesavebtn').prop('disabled', false);
				
			}
			else
			{
				$('#receivesavebtn').prop('disabled', true);
			}
			$('.rowchkbox').not(this).prop('checked', this.checked);
		});
		//enable disables save button
		$(".rowchkbox").click(function(){
			/* if(this.checked) 
			{
				$('#receivesavebtn').prop('disabled', false);
				
			}
			else
			{
				$('#receivesavebtn').prop('disabled', true);
			} */
			var totalcheckboxes = $('input[type="checkbox"]').not('.allchkbox').length;
			var selectedcheckboxes = $('input[type="checkbox"]:checked').not('.allchkbox').length;
			if(totalcheckboxes==selectedcheckboxes){
				//alert("true");
				$('.allchkbox').prop('checked',true);
				$('#receivesavebtn').prop('disabled', false);
			}else{
				//alert("false");
				$('.allchkbox').prop('checked',false);
				$('#receivesavebtn').prop('disabled', true);
			}
			//alert($('.rowchkbox').prop('checked'));
		});
		
		/* //
		$(document).ready(function () {
     $("#btnSubmit").one('click', function (event) {  
           event.preventDefault();
           $(this).prop('disabled', true);
     });
});
		// */
		$("#receivesavebtn").click(function(event){
				
			var submitit = true;var totchecked = 0;
			$('.rowchkbox:checked').each(function(){
				var locval = $(this).closest("tr").find("select[name^=location]").val();
				 var nature=$(this).closest("tr").find("input[name^=transactionnature]").val();
				if(locval>0){
					
					var dosesval = parseInt($(this).closest("tr").find("input[name^=doses]").val());
					var availabledoses = parseInt($(this).closest("tr").find("td").eq(4).text());
					var vialsval = parseInt($(this).closest("tr").find("input[name^=vials]").val());
					
					if((dosesval > 0) && (vialsval > 0)){
						var rsnval = $(this).closest("tr").find("select[name^=reason]").val();
						if(rsnval>0 && dosesval!="" &&  vialsval!=""){}else{
							alert("Reason Must be selected.");submitit = false;
						}
						
						if(nature!="" && nature==0 )
						{
							if(availabledoses <dosesval)
							{
								alert("Adjusted Doses should be less than Available QTY. ");
								 $(this).closest('tr').find("td").eq(4).css('background-color','Red');
								submitit = false;
							}
							else
							{
								$(this).closest('tr').find("td").eq(4).css('background-color','');
							}
						}
						} 
						else
						{
							
							submitit = false;
						}
					
				}else{
					alert("Store in Location Must be selected.");submitit = false;
				}
				totchecked++;
			});
			if(totchecked>0 && submitit===true){
				//submit form
				$(this).closest('form').submit();
				/*restrict for double click */
			  event.preventDefault();
           $(this).prop('disabled', true);
		   /* end */
			}
		});
		$("input[name^=doses]").keyup(function(){
			var entereddoses = $(this).val();
			var qty=parseInt($(this).closest("tr").find("td").eq(4).text());
			var entereddoses =  (entereddoses>0)?entereddoses:0;
			var nature=$(this).closest("tr").find("input[name^=transactionnature]").val();
			if(nature!="" && nature==0)
			{
				var received_doses=qty-parseInt(entereddoses);
			}
			else
			{
				var received_doses=qty+parseInt(entereddoses);
			}
			var dosesinvials = $(this).closest("tr").data("doses");
			var vials =  (parseInt(entereddoses,10)/parseInt(dosesinvials,10));
			var vials =  (vials>0)?vials:0;
			var received_vials =  (parseInt(received_doses,10)/parseInt(dosesinvials,10));
			var received_vials =  (received_vials>0)?received_vials:0;
			//setting adjusted vials
			$(this).closest("tr").find("input[name^=vials]").val(vials);
			//setting recieved qty after adjustmnet
			var received_doses =  (received_doses>0)?received_doses:0;
			$(this).closest("tr").find("td.received_doses").text(received_doses);
			$(this).closest("tr").find("td.received_vials").text(received_vials);
			checkAdjustQty($(this),"doses");
		});
		$("input[name^=vials]").keyup(function(){
			var enteredvials = $(this).val();
			var dosesinvials = $(this).closest("tr").data("doses");
			var qty=parseInt($(this).closest("tr").find("td").eq(5).text());
			var enteredvials =  (enteredvials>0)?enteredvials:0;
			var nature=$(this).closest("tr").find("input[name^=transactionnature]").val();
			if(nature!="" && nature==0)
			{
				var received_vials=qty-parseInt(enteredvials);
			}
			else
			{
				var received_vials=qty+parseInt(enteredvials);
			}
			var doses =  (parseInt(enteredvials,10) * parseInt(dosesinvials,10));
			var doses =  (doses>0)?doses:0;
			var received_doses =  (parseInt(received_vials,10) * parseInt(dosesinvials,10));
			var received_doses =  (received_doses>0)?received_doses:0;
			//setting adjusted doses
			$(this).closest("tr").find("input[name^=doses]").val(doses);
			//setting recieved qty after adjustmnet
			var received_vials =  (received_vials>0)?received_vials:0;
			$(this).closest("tr").find("td.received_doses").text(received_doses);
			$(this).closest("tr").find("td.received_vials").text(received_vials);
			checkAdjustQty($(this),"vials");
			
		});
	});
	//fucntion fo check adjustment qty
	function checkAdjustQty(ob,qtyType)
	{
	   var entereddoses = $(ob).val();
	   var qty=null;
	    var nature=$(ob).closest("tr").find("input[name^=transactionnature]").val();
		if(nature!="" && nature==0)
		{
		if(qtyType=="doses")		 
		 qty=parseInt($(ob).closest("tr").find("td").eq(4).text());
	    else
		qty=parseInt($(ob).closest("tr").find("td").eq(5).text());
		   if(entereddoses>qty)
		   {
			   alert("Adjusted qty should be less than Available QTY.");
			   return false;
		   }
		   else
		   {
			   return true;
			}
		}
	}

	//For Adjstment Tpye
	
	
$(document).on('change','select[name^=reason]',function(){
			var nature = $(this).find("option:selected").data("nature");
			if(nature >=0)
			{
				
				$(this).closest("tr").find("input[name^=doses]").prop("readonly", false);
			//	$(this).closest("tr").find("input[name^=doses]").prop("required",'required');
				$(this).closest("tr").find("input[name^=vials]").prop("readonly", false);
				//$(this).closest("tr").find("input[name^=vials]").prop("required",'required');;
				
			}
			else
			{
				$(this).closest("tr").find("input[name^=doses]").val("");
				$(this).closest("tr").find("input[name^=vials]").val("");
				var doses=$(this).closest("tr").find("td").eq(4).text();
				var vials=$(this).closest("tr").find("td").eq(5).text();
				$(this).closest("tr").find("td.received_doses").text(doses);
				$(this).closest("tr").find("td.received_vials").text(vials);
				$(this).closest("tr").find("input[name^=doses]").val("");
				$(this).closest("tr").find("input[name^=vials]").val("");
				$(this).closest("tr").find("input[name^=doses]").prop("readonly", true);
				//$(this).closest("tr").find("input[name^=doses]").prop("required",false);
				$(this).closest("tr").find("input[name^=vials]").prop("readonly", true);
				//$(this).closest("tr").find("input[name^=vials]").prop("required",false);
			}
			//alert(nature);
			/* //$("#addbatchbtn").remove();
			if(nature=="1"){
				$("#batch").css("width","85%");
				$("#batch").css("display","inline-block");
				$("#batchtd").append('<button type="button" id="addbatchbtn" class="btn btn-success btn-md" data-toggle="modal" data-target="#AddBatchModal">New</button>');
				$("#addbatchbtn").css('float', 'right');
				$("#addbatchbtn").css('margin-right', '10px');
			}else{
				$("#batch").css("width","100%");
			}
			$("#modaltranstypeid").val($(this).find("option:selected").val());
			//unset everything
			$("#product option:selected").prop("selected", false);
			$("#product").trigger("change"); */
			$(this).closest("tr").find("input[name^=transactionnature]").val(nature);
			//$(this).find("input:[name=transactionnature]").val(nature);
		});
</script>