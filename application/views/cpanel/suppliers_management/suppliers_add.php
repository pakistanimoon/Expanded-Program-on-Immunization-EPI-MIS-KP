<?php $utype=$_SESSION['utype']; ?>
<?php //print_r($userInfo); exit(); ?>
<div class="container bodycontainer">
	<div class="row">
		<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
  			<div class="panel panel-primary">
    			<ol class="breadcrumb">
          		<?php  echo $this->breadcrumbs->show();?>
       		</ol>
    			<div class="panel-heading">EPI-MIS | Suppliers Add Form</div>
  	   		<div class="panel-body">
    	   		<form name="dataform" id="dataform" action="<?php echo base_url();?>cpanel/suppliers_management/Suppliers_management/suppliers_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
						<div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1" for = "facode" >Stakeholder Name</label>
							   <div class="col-xs-3">
									<input  required name="stakeholder_name" id="stakeholder_name" placeholder="Stakeholder Name"  class="form-control " value=""/>
							  	</div>
							   <label class="col-xs-2 control-label" for = "uname" >Stakeholder Type</label>
								<div class="col-xs-3">
									<select id="stakeholder_type_id" required name="stakeholder_type_id" class="form-control" size="1" >
										<option value="">--- Select Type ---</option>
										<?php
										foreach($epi_stakeholder_types as $values){ ?>
											<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['stakeholder_type_name'] ?></option>
									<?php } ?>										
									</select>
								</div>
						   </div>
						</div>
						<div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1" for = "facode" >Stakeholder Sector</label>
							   <div class="col-xs-3">
									<select id="stakeholder_sector_id" required name="stakeholder_sector_id" class="form-control" size="1" >
										<option value="">--- Select Sector ---</option>
										<?php
										foreach($epi_stakeholder_sectors as $values){ ?>
											<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['stakeholder_sector_name'] ?></option>
									<?php } ?>										
									</select>
								</div>
							   <label class="col-xs-2 control-label" for = "uname" >Geo Level</label>
								<div class="col-xs-3">
									<select id="geo_level_id" required name="geo_level_id" class="form-control" size="1" >
										<option value="">--- Select Level ---</option>
										<?php
										foreach($epi_geo_levels as $values){ ?>
											<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['geo_level_name'] ?></option>
									<?php } ?>										
									</select>
								</div>
						   </div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-xs-2 control-label col-md-offset-1" for="coupon_question">Do you have Enter Stackholder Item?</label>
							<div class="col-xs-3">
								<input class="coupon_question" type="checkbox" name="coupon_question" value="1" /> 
								<input style="display:none" name="myInput"  type="text" id="myInput">
							</div>
							</div>
						</div>
						<hr>
						<!------------------->
						<div class="answer">
						<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
							<thead>
								<tr>
									<th id="m1"  colspan="7" class="qtr">Stackholder Item</th>
								</tr>
								<tr>
									<th>S.No.</th>
									<th>Name</th>
									<th>Item Pack | Activity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="trRow" >
								<tr>
									<td>
										<label class="srno-lbl" name="lb[]">1</label>

									</td>
									<td>
										<input type="text" class="form-control" id="pack_size_description" placeholder="Name" name="pack_size_description[]">
									</td>
									<td>
										<select id="item_pack_size_id"  name="item_pack_size_id[]" class="form-control" size="1" >
										<option value="">--- Select Item ---</option>
											<?php
												foreach($epi_item_pack_sizes as $values){ ?>
												<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['item_name'] ?></option>
											<?php } ?>										
										</select>
									</td>
									<td>
										<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
									</td>
								</tr>
							</tbody>
						</table>
						</div>
						<!------------------->
						<hr>
						<div class="row">
						   <div class="col-xs-7 cmargin22" >
								<button type="submit" id="AddUser" name="AddUser" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Add Suppliers </button>
								<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
								<a href="<?php echo base_url();?>Suppliers_management/suppliers_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
							</div>
						</div>
					</form>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body container-->

<script type="text/javascript">
	$(".answer").hide();
	$(".coupon_question").click(function() {
		if($(this).is(":checked")) {
			$(".answer").show();
			$("#myInput").val("1");
		} else {
			$(".answer").hide();
			$("#myInput").val("0");
		}
	});
	function addRow(obj){
		var row = $(obj).closest("tr").clone();
		row.find('input').val('');
			//var lastRowIndex = $('#trRow').find('tr:last').index();
			row.find("td:nth-child(1)").find('label').val('');
			row.find("td:nth-child(2)").find('input').val('');
			row.find("td:nth-child(3)").find('select').val('0');
			$(obj).closest("#trRow").append(row);
			$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
			$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
			reindex_serialnumber_and_trainingCompleted();
			
		}
	function deleteRow(obj) {
		var index = $('#trRow').find('tr:last').index();
		$(obj).closest("tr").remove();
		if(index=='1'){
			$('#trRow').find('tr:last').find('td:last').html('<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}else{
			$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}
		reindex_serialnumber_and_trainingCompleted();
	}
	//sessiontypem1
	function reindex_serialnumber_and_trainingCompleted(){
		$('#trRow > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('input').attr('name','pack_size_description['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','item_pack_size_id['+i+']');
		});
	}
</script>










