<div class="panel panel-primary">
  <div class="panel-heading">Search Cold Chain Assets</div><?php //echo $id; ?>
	<div class="panel-body">
		<div class="row add_refrigerator inside-page" style="margin-bottom: 10px;">
		<form id='filter-form' onsubmit="return checkRequired();" method="post" enctype="multipart/form-data">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="Catalogue">Asset Type</label>
								<select class="form-control text-center" name="assets" id="assets">
								<!--<option value="0" >--Select Asset--</option>-->
								<optgroup label="Active Containers">
									<?php
									$isset="";
									foreach($assetTypesActiveContainers as $val)
									{
										if($val['pk_id']==$id){ $isset="selected='selected'"; }else{ $isset='';}
										echo $option="<option value='".$val['pk_id']."-".$val['asset_type_name']."' {$isset}>".$val['asset_type_name']."</option>";
									}
									?>
								</optgroup>
								<optgroup label="Passive Containers">
									<?php
									foreach($assetTypesPassiveContainers as $val)
									{
										if($val['pk_id']==$id){ $isset="selected='selected'"; }else{ $isset='';}
										echo $option="<option value='".$val['pk_id']."-".$val['asset_type_name']."' {$isset}>".$val['asset_type_name']."</option>";
									}
									?>
								</optgroup>
							</select>
							</div>
						</div>
					</div>
					<div>
						
<?php if($id==1){ /// for refrigerator filters?>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Asset Sub Type</label>
				<select name="ccm_sub_asset_type_id" id="ccm_asset_type_id_popup" class="form-control">
					<option value="">--Select--</option>
					<?php
						foreach($assets_sub_types as $values){ ?>
							<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['asset_type_name'] ?></option>
					<?php } ?>
				</select> 
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Source of Supply</label>
				<select class="form-control" name="source_id">
					<?php echo getSourceSupply(); ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Working Status</label>
				<select class="form-control" name="status" id="status_w" required>
					<?php echo getWorkingstatus(); ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Asset Id / Equipment Code</label>
				<input name='ccm_user_asset_id' class="form-control" type="text"/>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Catalogue ID</label>
				<input name ='catalogue_id' class="form-control" type="text"/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Make</label>
				<select class="form-control" name="ccm_make_id" id="make_name">
				<option value=''>--Select Make--</option>
				<?php foreach($makesData as $values){ ?>
							<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['make_name'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Model</label>
				<select class="form-control" name="ccm_model_id" id="model_name">
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Serial Number</label>
				<input class="form-control" name='serial_no' type="text" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Gross Capacity From</label>
				<input class="form-control" name='gross_capcity_from' type="text" />
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Gross Capacity To</label>
				<input class="form-control" name='gross_capcity_to' type="text"/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Working Since From</label>
				<input class="form-control dp" name='working_from' type="text" readonly/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Working Since To</label>
				<input class="form-control dp" name='working_to' type="text" readonly/>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if($id==21){ ?>										<!--  Cold Room filters -->
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Type</label>
				<select name="ccm_sub_asset_type_id" id="ccm_asset_type_id_popup" class="form-control">
					<option value="">--Select--</option>
					<?php
						foreach($assets_sub_types as $values){ ?>
							<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['asset_type_name'] ?></option>
					<?php } ?>
				</select> 
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Working Status</label>
				<select class="form-control" name="status" id="status_w" required>
					<?php echo getWorkingstatus(); ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Source of Supply</label>
				<select class="form-control" name="source_id">
					<?php echo getSourceSupply(); ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Number of cooling system </label>
				<input name='cooling_system' class="form-control" type="text"/>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Asset Id / Equipment Code</label>
				<input name='ccm_user_asset_id' class="form-control" type="text"/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Make</label>
				<select class="form-control" name="ccm_make_id" id="make_name">
				<option value=''>--Select Make--</option>
				<?php foreach($makesData as $values){ ?>
							<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['make_name'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Model</label>
				<select class="form-control" name="ccm_model_id" id="model_name">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Capacity From</label>
				<input class="form-control" name='gross_capcity_from' type="text" />
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Capacity To</label>
				<input class="form-control" name='gross_capcity_to' type="text"/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Year of Supply From</label>
				<input class="form-control dp" name='working_from' type="text" readonly/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Year of Supply To</label>
				<input class="form-control dp" name='working_to' type="text" readonly/>
			</div>
		</div>
	</div>
	<?php }  if($id==23 || $id==26 || $id==27 || $id==33){ ?>
												<!-- =========Voltage Regulator and Vaccine Carrier and Ice Pack(no catalogue_id)- Filters ============-->
	<div class="row">
	<?php if($id==23 || $id==26){ ?>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Catalogue ID</label>
				<input name ='catalogue_id' class="form-control" type="text"/>
			</div>
		</div>
	<?php } ?>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Make</label>
				<?php if($id!='27'){ ?>
				<select class="form-control" name="ccm_make_id" id="make_name">
				<option value=''>--Select Make--</option>
				<?php 	
							foreach($makesData as $values){ ?>
							<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['make_name'] ?></option>
					<?php 	}
						?>
				</select>
				<?php }else
						{ ?>
						<select class="form-control" name="ccm_sub_asset_type_id" id="make_name">
							<option value=''>--Select Make--</option>
							<option value='Generic'>Generic</option>
						</select>
						<?php } ?>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Model</label>
					<select class="form-control" name="ccm_model_id" id="model_name">
				</select>
			</div>
		</div>
	</div>
	<?php } if($id==24){ ?>
											<!-- =========Generator filters ============-->
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Working Status</label>
				<select class="form-control" name="status" id="status_w" required>
					<?php echo getWorkingstatus(); ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Serial Number</label>
				<input name='serial_number' class="form-control" type="text"/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Source of Supply</label>
				<select class="form-control" name="source_id">
					<?php echo getSourceSupply(); ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Asset Id / Equipment Code</label>
				<input name='ccm_user_asset_id' class="form-control" type="text"/>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Make</label>
				<select class="form-control" name="ccm_make_id" id="make_name">
				<option value=''>--Select Make--</option>
				<?php foreach($makesData as $values){ ?>
							<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['make_name'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Model</label>
				<select class="form-control" name="ccm_model_id" id="model_name">
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Year of Supply From</label>
				<input class="form-control dp" name='working_from' type="text" readonly/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Year of Supply To</label>
				<input class="form-control dp" name='working_to' type="text" readonly/>
			</div>
		</div>
	</div>
	<?php } if($id==25){ ?>
											<!-- =========Transport filters ============-->
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Transport Type</label>
				<select  class="form-control" id="ccm_sub_asset_type_id" name="ccm_sub_asset_type_id" >
					<option value="">--Select--</option>
					<?php
						foreach($assets_sub_types as $values){ ?>
							<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['asset_type_name'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Working Status</label>
				<select class="form-control" name="status" id="status_w" required>
					<?php echo getWorkingstatus(); ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Source of Supply</label>
				<select class="form-control" name="source_id">
					<?php echo getSourceSupply(); ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Fuel Type</label>
				<select  class="form-control" name="fuel_type_id">
					<?php echo getPowerSource(); ?>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Registration No</label>
				<input name='registration_no' class="form-control" type="text"/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Model">Make</label>
				<select class="form-control" name="ccm_make_id" id="make_name">
				<option value=''>--Select Make--</option>
				<?php foreach($makesData as $values){ ?>
							<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['make_name'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Model</label>
				<select class="form-control" name="ccm_model_id" id="model_name">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="AssetSubType">Manufacture Year From</label>
				<input class="form-control dp" name='manufacturer_year_from' type="text" readonly/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="Make">Manufacture Year To</label>
				<input class="form-control dp" name='manufacturer_year_to' type="text" readonly/>
			</div>
		</div>
	</div>
	<?php } ?>
						<?php $this -> load -> view('coldchain/add_forms/storesSection') ?>
						<div class="row">
							<div class="col-md-12">
								<button style="background:#008d4c; margin-left: 85%;" class="btn btn-primary btn-md search" role="button"><i class="fa fa-search "></i> Search </button>
								<button type="reset" class="btn btn-info btn-md reset" role="button"><i class="fa fa-repeat"></i> Reset </button>
							</div>
						</div><!--- row --->
				</div><!-- col-md-12 -->
			</div><!--- row --->
		</form>
	</div>

<table  class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="display: none;">
	<thead>
	  <tr>
		<th class="text-center Heading">S#</th>
		<?php if($this->session->UserLevel == 3)
				{ ?>
		<th class="text-center Heading">District</th>                
		<th class="text-center Heading">Facility</th>
			<?php } ?>
		<th class="text-center Heading">Store</th>		
		<th class="text-center Heading">Make</th>
		<th class="text-center Heading">Model</th>
		<?php if($id == 24){ ?>
			<th class="text-center Heading">Serial Number</th>
		<?php } ?>
		<?php if($id == 25 ){ ?>
			<th class="text-center Heading">Fuel Type</th>
		<?php }else{
			if($id != 23 ){
				if($id != 27 ){
					if($id != 26){
		?>
		<th class="text-center Heading">Capacity</th>
		<?php 
					}
				}
			}
		} 
		if($id != 23 ){ 
			if($id != 27 ){ 
				if($id != 26){ ?>
		<th class="text-center Heading">Working Status</th>
				<?php }
			} 
		} ?>
		<?php if($id == 27 ){ ?>
		<th class="text-center Heading">Working Quantity</th>
		<th class="text-center Heading">Total Quantity</th>
		<?php } ?>
		<th class="text-center Heading">Date</th>
		<?php if($id != 27 ){ ?>
		<th class="text-center Heading">Action</th>
		<?php }?>
	  </tr>
	</thead>
	<tbody id="tbody">
	</tbody>
</table>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {

   $(document).on("click",".search",  function (e){
      e.preventDefault();
	  $(".tbl-listing").show();
      $('#paging').html('')
      $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        $(".loading-div").show(); //show loading element
        $.ajax({
          type: "POST",
          data: $('#filter-form').serialize(),
          dataType:"json",
          url: "<?php echo base_url(); ?>Coldchain/getSearchData",
          success: function(result){
			$('#tbody').html(result.tbody);
          }
        });
        
      });
  });
  $(document).on('change','#make_name', function(){
	var id = $(this).val();
	if(id !='') {
	  $.ajax({
			type: "POST",
			data: "id="+id,
			url: "<?php echo base_url(); ?>Ajax_calls/getModelsColdroom",
			success: function(result){
				var result= JSON.parse(result);
				$('#model_name').html(result);
			}
		});
	}else{
		 $("#model_name").html('<option value="">Select First Make</option>');
	}						
  });
 $(document).on('change','#assets', function(){
	 var assetid = $(this).val();
	 var res = assetid.split("-");
	 var id= res[0];
	  var name= res[1];
	 var url = '<?php echo base_url(); ?>Coldchain/Search-assets/'+name+'/'+id;
		window.location.href = url;
});
</script>