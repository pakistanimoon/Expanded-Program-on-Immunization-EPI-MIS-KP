<?php //print_r($data); exit;?>
<?php 

$style='';
$offset_transfer = '';
$lableDistrict = "District";
$col="col-md-4";
$display="border:none";
if(isset($offset) && $offset=='Yes'){
	$offset_transfer = 'col-xs-offset-1';
	$lableDistrict = "Districts";
	$col="col-md-3";
	$display="";
}
if(isset($transfer)){ }else{ 
if(isset($offset) && $offset=='Yes'){ 
$style = "";
?>
<br>
<?php }else{ ?>

<div class="row" style="margin-bottom:10px">
		<div class="col-md-4">
					<div class="row">
						<div class="col-md-4">
							<label for="Placed">Placed At <span style="color:red;">*</span></label>
						</div>
					
		
	

<?php
		
		if(isset($search)){
			$checked2 = "checked='checked'";
			$checked ="";
			
		}
		else
		{
			$style = "display:none;";
			$checked = "checked='checked'";
			$checked2 ="";
		}
		$var = '<label class="radio-inline">
					<input type="radio" value="0" name="placed_at-0" class="placed_at-0" '.$checked.'>Unallocated 
				</label>';
		$var2 = '<label class="radio-inline">
					<input type="radio" value="1" name="placed_at-0" class="placed_at-0" '.$checked2.'>Select Store
				</label>'; ?>
						<div class="col-md-8">
							<?php 	if(isset($search))
								echo $var2.$var;
							else
								echo $var.$var2;?>
						</div>

			</div>
		</div>
 </div>		
<?php } } ?>
<?php if(isset($offset) && $offset=='Yes'){?>
<div id="storeSection" style="border: 1px solid rgb(246, 246, 246);border-radius: 3px;padding: 10px;
background: #fbfbfb;box-shadow: 0px 1px 4px 0px #dadada;" >
		<div class="row">
			<div class="col-md-12">
				<h2 style="margin-top: 0px;color: #008d4c;font-weight: 600;font-size: 24px;
				text-decoration: underline;margin-bottom: 4px;">Old Status</h2>
			</div>
		</div>
       <div class="row" style="margin-top:10px;">
	     <div class="col-md-3">
		    <label for="Store">Equipment Code<span style="color:red;">*</span></label>
		 </div>
		 <div class="col-md-3">
		 <span><?php echo $data[0]['ccm_user_asset_id']; ?></span>
		 </div>
		 
	     <div class="col-md-3">
		    <label for="Store">Store Level<span style="color:red;">*</span></label>
		 </div>
		 <div class="col-md-3">
		 <span><?php echo $data[0]['stroe_level']; ?></span>
		 </div>
	     </div>
		  <div class="row">
		 <div class="col-md-3">
		    <label for="Store">Warehouse Name<span style="color:red;">*</span></label>
		 </div>
		 <div class="col-md-3">
		 <span style="white-space:nowrap;"><?php echo $data[0]['storename']; ?></span>
		 </div>
		 
	   
	   </div>
	   <div class="row">
	   <div class="col-md-3">
		    <label for="Store">Make<span style="color:red;">*</span></label>
		 </div>
		 <div class="col-md-4">
		 <span><?php echo $data[0]['make_name']; ?></span>
		 </div>
	   
	   </div>
</div>
<?php }?>
	   <br>
<?php if(isset($offset) && $offset=='Yes'){?>	   
<div id="storeSection" style="border: 1px solid rgb(246, 246, 246);border-radius: 3px;padding: 10px;
background: #fbfbfb;box-shadow: 0px 1px 4px 0px #dadada;<?php echo $display;?>" >
<div class="row">
			<div class="col-md-12">
				<h2 style="margin-top: 0px;color: #008d4c;font-weight: 600;font-size: 24px;
				text-decoration: underline;margin-bottom: 4px;">Current Status</h2>
			</div>
		</div>
<div class="row store_hid"  style="position:relative; margin-top:5px;margin-bottom:10px;<?php echo $style; ?>">

		<div class="col-md-6">
						<div class="row">
							<div class="col-md-4">
								<label for="Store" style="position:relative;top:6px;">Store<span style="color:red;">*</span></label>
							</div>
							<div class="col-md-8 store_hid">
								<select class="form-control" name="warehouse_type_id" id="store_id" required>
									<?php if(isset($offset) && $offset=='Yes'){ ?>
										<option value="0">Select</option>
										<option value="4">District</option>
										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<?php if($this -> session -> UserLevel != '4'){ ?>
										<option value="2">Provincial</option>
										<?php }  ?>
									<?php }else{ ?> 
										<option value="0">Select</option>
										<?php
										if($this -> session -> Tehsil){ ?>

										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<?php
										}else if($this -> session -> District){ ?>
										<option value="4">District</option>
										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<?php } else { ?>
										  <option value="2">Provincial</option>
										<?php }?>
									<?php } ?>
									</select>			
							</div>					
						</div>
		</div>
		<div class="col-md-6 dist_hid" style="display:none">
						<div class="row">
							<div class="col-md-4">
								<label for="District" style="position:relative;top:6px;"><?php echo $lableDistrict; ?></label>
							</div>
							<div class="col-md-8">
									<select class="form-control" name="distcode" id="distcodeREF">
									</select>
							</div>
						</div>	
	   </div>
	<div class="col-md-6 tcode_hid" style="display:none;margin-top:5px;">
						<div class="row">
							<div class="col-md-4">
								<label for="Tehsil" style="position:relative;top:6px;">Tehsil</label>
							</div>
							<div class="col-md-8">
									<select class="form-control" name="tcode" id="tcodeREF" >
									</select>
							</div>
						</div>	
	   </div>
	   <div class="col-md-6 uncode_hid" style="display:none; margin-top:5px;">
						<div class="row">
							<div class="col-md-4">
								<label for="UNcouncil" style="position:relative;top:6px;">UCs</label>
							</div>
							<div class="col-md-8">
									<select class="form-control" name="uncode" id="uncodeREF" >
									</select>
							</div>
						</div>	
	   </div>
	   <div class="col-md-6 facode_hid" style="display:none;margin-top:5px;">
						<div class="row">
							<div class="col-md-4">
								<label for="UNcouncil" style="position:relative;top:6px;">Facilities</label>
							</div>
							<div class="col-md-8">
									<select class="form-control" name="facode" id="facode_th">
									</select>
							</div>
						</div>	
	   </div>
</div>
</div>
<?php }else{ ?>
<div id="storeSection" style="<?php echo $display;?>" >

<div class="row store_hid"  style="position:relative; margin-top:5px;margin-bottom:10px;<?php echo $style; ?>">

		<div class="col-md-4">
						<div class="row">
							<div class="col-md-4">
								<label for="Store" style="position:relative;top:6px;">Store<span style="color:red;">*</span></label>
							</div>
							<div class="col-md-8 store_hid">
								<select class="form-control" name="warehouse_type_id" id="store_id" required>
									<?php if(isset($offset) && $offset=='Yes'){ ?>
										<option value="0">Select</option>
										<option value="4">District</option>
										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<option value="2">Provincial</option>
									<?php }else{ ?>
										<option value="0">Select</option>
										<?php
										if($this -> session -> Tehsil){ ?>

										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<?php
										}else if($this -> session -> District){ ?>
										<option value="4">District</option>
										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<?php } else { ?>
										  <option value="2">Provincial</option>
										<?php }?>
									<?php } ?>
									</select>			
							</div>					
						</div>
				</div>
		<div class="col-md-4 dist_hid" style="display:none">
						<div class="row">
							<div class="col-md-4">
								<label for="District" style="position:relative;top:6px;"><?php echo $lableDistrict; ?></label>
							</div>
							<div class="col-md-8">
									<select class="form-control" name="distcode" id="distcodeREF">
									</select>
							</div>
						</div>	
	   </div>
	<div class="col-md-4 tcode_hid" style="display:none;">
						<div class="row">
							<div class="col-md-4">
								<label for="Tehsil" style="position:relative;top:6px;">Tehsil</label>
							</div>
							<div class="col-md-8">
									<select class="form-control" name="tcode" id="tcodeREF" >
									</select>
							</div>
						</div>	
	   </div>
	   <div class="col-md-4 uncode_hid" style="display:none; margin-top:5px;">
						<div class="row">
							<div class="col-md-4">
								<label for="UNcouncil" style="position:relative;top:6px;">UCs</label>
							</div>
							<div class="col-md-8">
									<select class="form-control" name="uncode" id="uncodeREF" >
									</select>
							</div>
						</div>	
	   </div>
	   <div class="col-md-4 facode_hid" style="display:none;margin-top:5px;">
						<div class="row">
							<div class="col-md-4">
								<label for="UNcouncil" style="position:relative;top:6px;">Facilities</label>
							</div>
							<div class="col-md-8">
									<select class="form-control" name="facode" id="facode_th">
									</select>
							</div>
						</div>	
	   </div>
</div>
</div>
<?php  } ?>
<script type="text/javascript">
//var formid ='<?php //echo $form; ?>';
<?php if(isset($offset) && $offset == 'Yes'){

	?>
	
$("#storeSection").slideDown(500);
<?php }?>
$(document).on("change", "input[name=placed_at-0]", function () {
    var id = $(this).val();
	if(id==1){
		$(".store_hid").slideDown(500);
		
	}else{
		$(".store_hid").slideUp(500);
		$('#distcodeREF').removeAttr("required");
		$('#tcodeREF').removeAttr("required");
		$('#uncodeREF').removeAttr("required");
		$('#facode_th').removeAttr("required");
		$("#distcodeREF").val('');
		$("#tcodeREF").val('');
		//$("#storeSection").hide();
		$("#uncodeREF").val('');
		$("#facode_th").val('');
	}
});
$(document).on('change','#store_id',function(){
	
var id = $(this).val();

			var offset='<?php echo $offset;?>';
	if(offset=='Yes'){
			
			
				/* //for Tehsil dropdown
			var distcode  = 0;
			//For PHP helper function  
			<?php $distcode=0;?>
			//alert(distcode);
			data='<?php echo getDistricts_options(false,$distcode,"Yes");?>'; */
			//for tehsil dropdown
			var distcode= '<?php echo $this->session->District; ?>';
			//For PHP helper function 
			<?php $distcode=$this->session->District;?>
			data='<?php echo getDistricts_options(false,$distcode,"No");?>';
			//alert(data);
			
			if(id==4){
						$(".dist_hid").hide();
						$(".tcode_hid").hide();
						$(".uncode_hid").hide();
						$(".facode_hid").hide();
						$("#tcodeREF").text('');
						$("#uncodeREF").text('');
						$("#facode_th").text('');
						}
					if(id!=0 && id!= 2){
		
		
						console.log(data);
			 
					if(distcode==0){ 
						$('#distcodeREF').html('<option value="0">Select</option>');
						$('#distcodeREF').append(data);
						}
					else
					{
						$('#distcodeREF').html(data);
					}	
				
				$(".dist_hid").show();
				$('#distcodeREF').attr('required',true);
				if(id==5){
					$("#tcodeREF").text('');
					$("#uncodeREF").text('');
					$("#facode_th").text('');
					$(".tcode_hid").show();
					$(".uncode_hid").hide();
					$(".facode_hid").hide();
				}
				if(id!=4){
					$('option:selected', '#distcodeREF').removeAttr("selected");
				}else{
					$("#distcodeREF option[value='']").remove();
				}
				if(id==6){
					$("#tcodeREF").text('');
					$(".tcode_hid").show();
					$("#uncodeREF").text('');
					$(".uncode_hid").show();
					$('#tcodeREF').attr('required',true);
					$('#uncodeREF').attr('required',true);
				}else{
					$('#tcodeREF').attr('required',false);
					$('#uncodeREF').attr('required',false);
				}
				
		//	}
		//for tehsil in 
		if(id==5 || id==6){
				
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#tcodeREF').html(result);
					
					if(id==5){
						$(".tcode_hid").show();
					}
					if(id==6){
						$(".tcode_hid").show();
						$("#uncodeREF").val('');
						$(".uncode_hid").show();
					}
				}
			});
				
		} 
	}
	else{
		$(".dist_hid").hide();
		$(".tcode_hid").hide();
		$(".uncode_hid").hide();
		$(".facode_hid").hide();
	}
	
				/* <?php if(isset($form) && $form=='AICP'){  ?>
	var i=0;
	$.ajax({
		type: "POST",
		data: { storeId: id, distcode: distcode },
		url: "<?php echo base_url(); ?>Coldchain/getICePacks",
		success: function(result){
			if(result){
			var result1 = JSON.parse(result);
			
				var j=2;
				for(var i=0;i<=result1.length; i++){
					$("#"+j+"quantity").val(result1[i]);
					$("#"+j+"quantity").attr('disabled',true);
					j++;
				}
				$('.button').hide();
			}else{
				$(".quantity").val('');
				$(".quantity").attr('disabled',false);
				$('.button').show();
			}
		}
	});
					<?php } ?> *//* (isset($offset) && $offset == 'No') */
} 
else{
			
			//for tehsil dropdown
			var distcode= '<?php echo $this->session->District; ?>';
			//For PHP helper function 
			<?php $distcode=$this->session->District;?>
			data='<?php echo getDistricts_options(false,$distcode,"No");?>';
			var id = $(this).val();
			if(id==4){
						$(".dist_hid").hide();
						$(".tcode_hid").hide();
						$(".uncode_hid").hide();
						$(".facode_hid").hide();
						$("#tcodeREF").text('');
						$("#uncodeREF").text('');
						$("#facode_th").text('');
					}
			if(id!=0 && id!= 2){
		
		
					console.log(data);
			 
					if(distcode==0){ 
					$('#distcodeREF').html('<option value="0">Select</option>');
					$('#distcodeREF').append(data);
						}
					else
						{
							$('#distcodeREF').html(data);
						}	
				
				$(".dist_hid").show();
				$('#distcodeREF').attr('required',true);
				if(id==5){
					$("#tcodeREF").text('');
					$("#uncodeREF").text('');
					$("#facode_th").text('');
					$(".tcode_hid").show();
					$(".uncode_hid").hide();
					$(".facode_hid").hide();
				}
				if(id!=4){
					$('option:selected', '#distcodeREF').removeAttr("selected");
				}else{
					$("#distcodeREF option[value='']").remove();
				}
				if(id==6){
					$("#tcodeREF").text('');
					$(".tcode_hid").show();
					$("#uncodeREF").text('');
					$(".uncode_hid").show();
					$('#tcodeREF').attr('required',true);
					$('#uncodeREF').attr('required',true);
				}else{
					$('#tcodeREF').attr('required',false);
					$('#uncodeREF').attr('required',false);
				}
				
		//	}
		//for tehsil in 
		if(id==5 || id==6){
				
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#tcodeREF').html(result);
					
					if(id==5){
						$(".tcode_hid").show();
					}
					if(id==6){
						$(".tcode_hid").show();
						$("#uncodeREF").val('');
						$(".uncode_hid").show();
					}
				}
			});
				
		} 
	}else{
		$(".dist_hid").hide();
		$(".tcode_hid").hide();
		$(".uncode_hid").hide();
		$(".facode_hid").hide();
	}
	
	<?php if(isset($form) && $form=='AICP'){  ?>
	var i=0;
	$.ajax({
		type: "POST",
		data: { storeId: id, distcode: distcode },
		url: "<?php echo base_url(); ?>Coldchain/getICePacks",
		success: function(result){
			if(result){
			var result1 = JSON.parse(result);
			
				var j=2;
				for(var i=0;i<=result1.length; i++){
					$("#"+j+"quantity").val(result1[i]);
					//$("#"+j+"quantity").attr('disabled',true);
					j++;
				}
				$('.button').hide();
				$("#edit_quantity").val('1');
			}else{
				$(".quantity").val('');
				$(".quantity").attr('disabled',false);
				$('.button').show();
				$("#edit_quantity").val('0');
			}
		}
	});
					<?php } ?>
	}
	
	
});
$(document).on('change','#distcodeREF', function(){
	var storeID = $("#store_id").val();
	var distcode = $('#distcodeREF').val();
	$("#tcodeREF").val('');
	if(storeID==5 || storeID==6){
		if(distcode == 0) {
		  $(".tcode_hid").hide();
		  $(".uncode_hid").hide();
		  $(".facode_hid").hide();
		}else{
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#tcodeREF').html(result);
				
					if(storeID==5){
						$(".tcode_hid").show();
					}
					if(storeID==6){
						$(".tcode_hid").show();
						$("#uncodeREF").val('');
						$(".uncode_hid").show();
					}
				}
			});
			<?php if(isset($form) && $form=='AICP'){  ?>
			var i=0;
			$.ajax({
				type: "POST",
				data: { storeId: storeID, distcode: distcode },
				url: "<?php echo base_url(); ?>Coldchain/getICePacks",
				success: function(result){
					if(result){
					var result1 = JSON.parse(result);
					
						var j=2;
						for(var i=0;i<=result1.length; i++){
							$("#"+j+"quantity").val(result1[i]);
							//$("#"+j+"quantity").attr('disabled',true);
							j++;
						}
						$('.button').hide();
						$("#edit_quantity").val('1');
					}else{
						$(".quantity").val('');
						$(".quantity").attr('disabled',false);
						$('.button').show();
						$("#edit_quantity").val('0');
					}
				}
			});
			<?php } ?>
		}
	}							
});
$(document).on('change','#tcodeREF', function(){
	
	var storeID =$('#store_id :selected').val();
	var distcode = $('#distcodeREF').val();
	var tcode = $('#tcodeREF :selected').val();
	
	if(storeID=="6"){
		$(".facode_hid").hide();
		if(tcode!="0") {
			$.ajax({
				type: "POST",
				data: "tcode="+tcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC",
				success: function(result){
					$('#uncodeREF').html(result);
					if(storeID==6){
						$(".uncode_hid").show();
					}
				}
			});
		}else{
			$(".uncode_hid").hide();
			$(".facode_hid").hide();
		}
	}
	<?php if(isset($form) && $form=='AICP'){  ?>
	var i=0;
	$.ajax({
		type: "POST",
		data: { storeId: storeID, distcode: distcode,tcode: tcode },
		url: "<?php echo base_url(); ?>Coldchain/getICePacks",
		success: function(result){
			if(result){
				var result1 = JSON.parse(result);
				var j=2;
				for(var i=0;i<=result1.length; i++){
					$("#"+j+"quantity").val(result1[i]);
					//$("#"+j+"quantity").attr('disabled',true);
					j++;
				}
				$('.button').hide();
				$("#edit_quantity").val('1');
			}else{
				$(".quantity").val('');
				$(".quantity").attr('disabled',false);
				$('.button').show();
				$("#edit_quantity").val('0');
			}
		}
	});
	<?php } ?>
});
$(document).on('change','#uncodeREF', function(){
	var storeID = $("#store_id").val();
	var uncode = $('#uncodeREF').val();
	var tcode = $('#tcodeREF').val();
	var distcode = $('#distcodeREF').val();
	if(uncode == 0) {
	  $(".facode_hid").hide();
	}else{
		$.ajax({
				type: "POST",
				data: "uncode="+uncode,
				url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
				success: function(result){
					$('#facode_th').html(result);
					$(".facode_hid").show();
				}
			});
		/* if($('#facode_th').val()==0){
			$("#facode_th option:first").val('');
			$('#facode_th').attr('required',true);
		}else{
			$('#facode_th').attr('required',false);
		} */
		<?php if(isset($form) && $form=='AICP'){  ?>
		var i=0;
		$.ajax({
			type: "POST",
			data: { storeId: storeID, distcode: distcode,tcode: tcode,uncode: uncode },
			url: "<?php echo base_url(); ?>Coldchain/getICePacks",
			success: function(result){
				if(result){
					var result1 = JSON.parse(result);
					var j=2;
					for(var i=0;i<=result1.length; i++){
						$("#"+j+"quantity").val(result1[i]);
						//$("#"+j+"quantity").attr('disabled',true);
						j++;
					}
					$('.button').hide();
					$("#edit_quantity").val('1');
				}else{
					$(".quantity").val('');
					$(".quantity").attr('disabled',false);
					$('.button').show();
					$("#edit_quantity").val('0');
				}
			}
		});
		<?php } ?>
	}
							
});
<?php if(isset($form) && $form=='AICP'){  ?>
$(document).on('change','#facode_th', function(){
	var facode = $("#facode_th").val();
	var storeID = $("#store_id").val();
	var uncode = $('#uncodeREF').val();
	var tcode = $('#tcodeREF').val();
	var distcode = $('#distcodeREF').val();
	if(facode!=0){
		var i=0;
		$.ajax({
			type: "POST",
			data: { storeId: storeID, distcode: distcode,tcode: tcode,uncode: uncode,facode: facode},
			url: "<?php echo base_url(); ?>Coldchain/getICePacks",
			success: function(result){
				if(result){
					var result1 = JSON.parse(result);
					var j=2;
					for(var i=0;i<=result1.length; i++){
						$("#"+j+"quantity").val(result1[i]);
						//$("#"+j+"quantity").attr('disabled',true);
						j++;
					}
					$('.button').hide();
					$("#edit_quantity").val('1');
				}else{
					$(".quantity").val('');
					$(".quantity").attr('disabled',false);
					$('.button').show();
					$("#edit_quantity").val('0');
				}
			}
		});
	}		
});
<?php } ?>
function checkRequired(id=false){
	var located = (id===false) ? $('input[name=placed_at-0]:checked').val() :id;
	var store_id = $('#store_id').val();
	var distcode = $('#distcodeREF').val(); 
	var tcode = $('#tcodeREF').val();
	var uncode = $('#uncodeREF').val();
	var facode = $('#facode_th').val();
	if(store_id !=0 && located==1)
	{
		if((store_id=='4' || store_id=='5' || store_id=='6') && distcode==''){
			alert('SORRY: Select the District!');
			return false;
		}else if((store_id=='5' || store_id=='6') && distcode!='' && tcode=="0"){
			alert('SORRY: Select the Tehsil!');
			return false;
		}else if((store_id=='5' || store_id=='6') && distcode!='' && tcode!="0" && uncode==""){
			alert('SORRY: Select the Uc!');
			return false;
		}else if((store_id=='5' || store_id=='6') && distcode!='' && tcode!="0" && uncode!="" && facode=="0"){
			alert('SORRY: Select the Facility!');
			return false;
		}else{
			return true;
		}
	}
	else
	{
		if(located == "1" && store_id ==0){
			alert('SORRY: Select the Store!');
			return false;
		}else{
			return true;
		}
	}
}
</script>