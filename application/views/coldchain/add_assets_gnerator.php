<style>
.width-25{
	width:25px !important;
}
.width-130{
	width:80px !important;
}
a.btn{
	padding:5px;
}
</style>
<div class="container bodycontainer">
	<h3 class="page-title" style="margin-bottom: -8px;">Cold Chain Assets</h3>
  <div class="panel-body">
  <div class="row" style="position:relative;">
  <div class="tabs" style="border: 1px solid #77e588; margin-bottom: -2px;">
		<!--<ul class="nav nav-pills">
		   <?php 
		   $path= base_url();
		   $assetNameId = $assetid = $_nameform = "";
		   foreach($assetTypesActiveContainers as $val)
			{
				if($uri==$val['pk_id'])
				{
					$active="class='active'";
					$_nameform = $val['asset_type_name'];
					$assetid = $val['pk_id'];
					$assetNameId = $assetid."-".$_nameform;
				}else{
					$active="";
				}
				//echo '<li role="presentation" '.$active.'><a class="assets fa fa-table" data-id="'.$val['pk_id'].'-'.$val['asset_type_name'].'" href="'.$path.'Coldchain/Add-assets/'.$val['pk_id'].'"><i></i><span class="strong" style="padding-left:5px">'.$val['asset_type_name'].'</span></a></li>';
			}
			?>
		</ul>-->
		<ul class="nav nav-pills">
			<li role="presentation" ><a class="assets fa fa-table" data-id="1-Refrigerator" href="<?php echo base_url(); ?>Coldchain/refrigerator_list/1"><i></i><span class="strong" style="padding-left:5px">Refrigerator</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="21-Cold Room" href="<?php echo base_url(); ?>Coldchain/coldroom_list/21"><i></i><span class="strong" style="padding-left:5px">Cold Room</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="23-Voltage Regulator" href="<?php echo base_url(); ?>Coldchain/voltageregulator_list/23"><i></i><span class="strong" style="padding-left:5px">Voltage Regulator</span></a></li>
			<li role="presentation" class="active"><a class="assets fa fa-table" data-id="24-Generator" href="<?php echo base_url(); ?>Coldchain/generator_list/24"><i></i><span class="strong" style="padding-left:5px">Generator</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="25-Transport" href="<?php echo base_url(); ?>Coldchain/transport_list/25"><i></i><span class="strong" style="padding-left:5px">Transport</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="26-Vaccine Carriers" href="<?php echo base_url(); ?>Coldchain/vaccinecarriers_list/26"><i></i><span class="strong" style="padding-left:5px">Vaccine Carriers</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="27-Ice Pack" href="<?php echo base_url(); ?>Coldchain/icepack_add/27"><i></i><span class="strong" style="padding-left:5px">Ice Pack</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="33-Cold Box" href="<?php echo base_url(); ?>Coldchain/coldbox_list/33"><i></i><span class="strong" style="padding-left:5px">Cold Box</span></a></li>
		</ul>
  </div>
  </div>
</div><!---- row ---->
	<!-- Filter Dropdown -->
	<?php if($uri!=27){ ?>
	<?php if($this->session->UserLevel == '3' && $this->session->utype == "DEO" )
			{ ?>
		<div id="deorowhide">
		<div class="row" > 
			<div class="col-md-1 col-sm-offset-1" >	
			<label style="text-align:center" for="Store">Store Level</label>
			</div>	
			<div class="col-md-2" >	
				<select class="form-control text-center" name="warehouse_type_id" id="warehouse_type_id" required="">
					<option value="0">--Select--</option>
					<?php if($this->session->UserLevel=='2'){ ?>
					<option value="2">Provicial</option>
					<?php } ?>
					<option value="4">District</option>
					<option value="5">Tehsil-Taluka</option>
					<option value="6">Union Council</option>
				</select>
			</div>
			<?php if($assetid =='1' || $assetid =='21' || $assetid =='23' || $assetid =='24' || $assetid =='25' || $assetid =='26' || $assetid =='33' ){ ?>
			<div class="col-md-1 ">
				<label for="Store" style="text-align:center">Working Status</label>
			</div>
			<div class="col-md-2 ">
			<select class="form-control" name="status" id="status_w" required>
					<?php echo getWorkingstatus(); ?>
				</select>
			</div>
			<div class="col-md-5 text-right" > 
			<a href="<?php echo base_url(); ?>Coldchain/generator_add" data-toggle="tooltip" title=" Add Asset">
				<button class="submit btn-success btn-sm"><i class="fa fa-plus"></i> Add Asset</button>
			</a>
			</div>
			<?php }?>
		</div> 
	</div>	
			<?php }  
			 
			 else{ ?>
	<div id="rowhide">			
		<div class="row" > 
			<div class="col-md-1 col-sm-offset-1" >	
				<label for="Store" style="text-align:center">Store Level</label>
			</div>
			<div class="col-md-2 " >
			<select class="form-control text-center" name="warehouse_type_id" id="warehouse_type_id" required="">
					<option value="0">--Select--</option>
					<?php if($this->session->UserLevel=='2'){ ?>
					<option value="2">Provicial</option>
					<?php } else {?>
                    <?php if($this->session->UserLevel!='4' and $this->session->UserLevel!='6'){ ?>
					<option value="4">District</option>
					<?php } ?>
                    <option value="5">Tehsil-Taluka</option>
					<option value="6">Union Council</option>
					<?php } ?>
				</select>
			</div>
			<!--<div class="col-md-1 disthide " style="display:none;">
				<label for="Store" style="text-align:center">Districts</label>
			</div>
			<div class="col-md-2  disthide" style="display:none;">
			<select class="form-control" name="distcode" id="distcode" required>
					<option value="">--Select--</option>
                    <?php 
					if($this->session->UserLevel=='4'){
						echo getDistricts_options(true,$this -> session -> District,"No");
					}else{
						echo getDistricts();
					}
					?>
				</select>
			</div>-->
			<?php if($assetid =='1' || $assetid =='21' || $assetid =='23' || $assetid =='24' || $assetid =='25' || $assetid =='26' || $assetid =='33' ){ ?>
			<div class="col-md-1">
				<label for="Store" style="text-align:center">Working Status</label>
			</div>
			<div class="col-md-2">
			<select class="form-control" name="status" id="status_w" required>
					<?php echo getWorkingstatus(); ?>
				</select>
			</div>
			<div class="col-md-5 text-right" >
			<a href="<?php echo base_url(); ?>Coldchain/generator_add" data-toggle="tooltip" title=" Add Asset">
				<button class="submit btn-success btn-sm"><i class="fa fa-plus"></i> Add Asset</button>
			</a>
			</div>
			<?php } 
			?>
		</div>
	</div>	
			 <?php }
	}?>
	<!-- -->
	<?php if($this -> session -> flashdata('message')){  ?><div class="text-center" id="alert" role="alert" style="color: #fff;background-color: #3C8DBC;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
	<?php if($uri==27){
				$this -> load -> view('coldchain/add_forms/add_icePack',$data);
			}else{ ?>
	
		
		
	
	<table id="myTable" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true"  style="padding-top:1%; border: 1px solid">
	  <thead>
		<tr>
		  <th class="text-center width-25 Heading">S#</th>	  
		  <?php if($assetid !='23' &&  $assetid !='26' &&  $assetid !='33'){ ?> 
		  <th class="text-center Heading">Equipment Code</th>
		  <?php } ?>
		  <th class="text-center Heading">Store Level</th>
          <th class="text-center Heading">Warehouse Code</th>
		  <th class="text-center Heading">Warehouse</th>
			 <?php
			  $count=6;
			  if($this->session->utype=='Manager'){ $count=7;?>
				<!--<th class="text-center Heading">District</th> -->
		  <?php } ?>
		  <th class="text-center Heading">Make</th>
		  <th class="text-center Heading">Model</th>
		  <?php if($assetid =='24' ||  $assetid =='25'){ ?>
		  <th class="text-center Heading">Source Supply</th>
		  <?php } ?>	
		  <?php if($assetid =='23' || $assetid =='26' || $assetid =='33'){ ?>
		  <th class="text-center Heading">Quantity</th>
		  <?php } 
		  if($assetid =='1' || $assetid =='21' ){
		  ?>
		  <th class="text-center Heading">Capacity</th>
		  <?php } 
		  if($assetid =='1' || $assetid =='21' || $assetid =='23' || $assetid =='24' || $assetid =='25' || $assetid =='26'  || $assetid =='33'){ 
		  ?>
		  <th class="text-center Heading">Working Status</th>
		  <?php } ?>
		  <th class="text-center Heading">Short Name</th>
		  <!--<th class="text-center Heading">Date</th>-->
		  <th class="text-center Heading">Action</th>
		  <!--<th class="text-center Heading"><button type="button" id="addNew" class="submit btn-success btn-sm" style="background:white none repeat scroll 0% 0%;color:green"><i class="fa fa-plus" aria-live="polite"></i>
		 Add Asset</button></th>-->
		</tr>
	  </thead>
	  <tbody id="tbody" style="text-align:center;">    
		<?php
		  $i=0;
		  foreach($refrigerator_data['refrigerator_data'] as $row){ 
			$i++;
		?>
			<tr role="row"> 
			  <td><?php echo $i; ?></td> 
			  <td><?php echo $row['ccm_user_asset_id'];?></td>	  
			  <td><?php echo $row['stroe_level'];?></td>	  
			  <td><?php echo $row['storecode'];?></td>	  
			  <td><?php echo $row['storename'];?></td>	  
			  <td><?php echo $row['make_name'];?></td>	  
			  <td><?php echo $row['model_name'];?></td>	  
			  <td><?php echo getSourceSupply($row['source_id'],TRUE);?></td>	  
			  <td><?php echo getWorkingstatus($row['status'],TRUE);?>
			  <i style="color:#446cbf;cursor:pointer;" class="fa fa-pencil" onclick="getstatusDetail(<?php echo $row['id'];?>)" role="button" id="addstatusbtn"  data-toggle="modal" data-target="#ClickBatchModal" rel="tooltip" title="Status Update"></i>
			  </td>	  
			  <td><?php echo $row['short_name'];?></td>	  
			  <td>
					<?php if( $row['warehouse_type_id']== 0){?>
						<a href="<?php echo base_url(); ?>Coldchain/generatorView/<?php echo $row['id']?>" class="btn view-btn"><i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" title="View"></i></a>
						<a href="<?php echo base_url(); ?>Coldchain/generatorEdit/<?php echo $row['id']?>" class="btn view-btn"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit"></i></a> 
						<a onclick="getDetail(<?php echo $row['id']?>,<?php echo $row['warehouse_type_id']?>)" id="addtransferbtn" class="btn view-btn" data-toggle="modal" data-target="#AddBatchModal"><i class="fas fa-hockey-puck" data-toggle="tooltip" title="Allocate"></i></a>
					<?php }else {?>
						<a href="<?php echo base_url(); ?>Coldchain/generatorView/<?php echo $row['id']?>" class="btn view-btn"><i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" title="View"></i></a>
						<a href="<?php echo base_url(); ?>Coldchain/generatorEdit/<?php echo $row['id']?>" class="btn view-btn"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit"></i></a> 
						<a onclick="getDetail(<?php echo $row['id']?>,<?php echo $row['warehouse_type_id']?>)" id="addtransferbtn" class="btn view-btn" data-toggle="modal" data-target="#AddBatchModal"><i class="fas fa-exchange-alt" data-toggle="tooltip" title="Transfer"></i></a>
					<?php }?>
			  </td>	  
			</tr>
			
			
		<?php } ?> 
	  </tbody>
    </table>
			<?php } ?>
			
		<div id="showForms" style="border: 1px solid #77e588; margin-bottom: -2px; display:none"></div>
</div>

<div class="modal fade" id="AddBatchModal" role="dialog" style="display: none;">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form class="modalForm" id="modalForm-transfer" action="" method="post" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header" height="35px">
						<h4 class="modal-title-transfer">Transfer <?php echo $_nameform; ?></h4>
					</div>
					<div class="modal-body">
							<input type="hidden" id="asset_id" name="asset_id" value=""/>
							
							<div id="transfer">
							</div>
						
						<br>
						<div class="row">
							<div class="col-md-6" style="margin-left: 65%;">
								<button id="btn-modalForm-submit-transfer" type="submit" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="button" class="btn-background box1" id="cancelmodal" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!---Pencile---->
<div class="modal fade" id="ClickBatchModal" role="dialog" style="display: none;">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form class="modalForm" id="modalForm-status" action="" method="post" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header" height="35px">
						<h4 class="modal-title-status">Status Update <?php echo $_nameform; ?></h4>
					</div>
					<div class="modal-body">
							<!--<input type="hidden" id="asset_id" name="asset_id" value=""/>-->
							
							<div id="status">
							</div>
						
						<br>
						<div class="row">
							<div class="col-md-6" style="margin-left: 65%;">
								<button id="btn-modalForm-submit-status" type="submit" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="button" class="btn-background box1" id="cancelmodal" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<script type="text/javascript">
var timeout=8000;
$('#alert').delay(timeout).fadeOut(300);
$(document).on('click','#addNew',function(){
	$('#showForms').html('');
	//$('.assetshide').css("display","none");

	var	id = "<?php echo $assetNameId; ?>";
	if(id!=0){
		$.ajax({
			type: "POST",
			data:"asset="+id,
			async:true,
			//dataType : 'json',
			url: "<?php echo base_url(); ?>Coldchain/getColdchainForms",
			success: function(result){
				$('#myTable').hide();
				$('#myTable_wrapper').hide();
				<?php if($this->session->UserLevel == '3' && $this->session->utype = "DEO")
			{ ?>
				$('#deorowhide').hide();
						<?php }?>
                	<?php if($this->session->UserLevel == '4')
			{ ?>
				$('#deorowhide').hide();
				$('#rowhide').hide();
						<?php }?>	
            <?php if($this->session->UserLevel == '2' )
					{ ?>
				$('#rowhide').hide();
                   <?php }?>
				$('#showForms').html(result);
				$('#showForms').show();
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
				
			}
		});
	}else{
		$('#myTable').show(); 
	}
	
});
//$(document).ready(function () {
	var link = "";
	var actionName = "";
	var clore = "";
	var button = "";
	var editlink="";
	var warehousename='<?php echo get_store_name(FALSE,$this->session->curr_wh_type,$this->session->curr_wh_code);?>';
	var level='<?php echo $this->session->UserLevel;?>';
	
	var columns = [
          { data: "serial",
		  orderable: false,
		  },
		  <?php if($assetid !='23' &&  $assetid !='26' &&  $assetid !='33'){ ?>
		  { data: "ccm_user_asset_id" },
		  <?php } ?>
		  { data: "warehouse_type_name" },
		  { data: "storecode" },
		  { data: "warehouse_type_id" },
		  //{ data: "district" }, 
          { data: "ccm_make_id" },
          { data: "ccm_model_id" },
		   <?php if($assetid =='24' ||  $assetid =='25'){ ?>
          { data: "source_id" },
		  <?php } ?>
         <?php if($assetid =='23' || $assetid =='26' || $assetid =='33'){ ?>
			{ data: "quantity" },
		 <?php } 
			if($assetid =='1' || $assetid =='21'){
		 ?>
		  { data: "net_capacity_20" },
			<?php } 
			if($assetid =='1' || $assetid =='21' || $assetid =='23' ||  $assetid =='24' || $assetid =='25' || $assetid =='26'  || $assetid =='33'){
			?> 
		  { data: "status", 
		   "render": function(data, type,full)
			{
              data  = '' + data + ' <i style="color:#446cbf;cursor:pointer;" class="fa fa-pencil" onclick="getstatusDetail('+full.id+')" role="button" id="addstatusbtn"  data-toggle="modal" data-target="#ClickBatchModal" rel="tooltip" title="Status Update"></i>';
			  return data ;
            }
          },
			<?php } ?>
		  { data: "short_name" },
		  //{ data: "created_date" },
		 /*  { orderable: false,
            render : function(data, type, full) {
				
				link = '<?php echo base_url(); ?>Coldchain/'+full.formeditlink+'/'+full.id;
					editlink='<a href="'+link+'" class="btn view-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
			
				if(full.used_by_stock > 0){
					
					if(level==2  && full.warehouse_type_id!=warehousename)
						editlink="";
					link = '<?php echo base_url(); ?>Coldchain/'+full.formlink+'/'+full.id;
					button = '<td><button style="margin:2px;" class="btn btn-success btn-md">In Use</button></td>';
				}else{
					
					if(level==2  && full.warehouse_type_id!=warehousename)
						editlink="";
					if(full.storetype==0){
						link = '<?php echo base_url(); ?>Coldchain/'+full.formlink+'/'+full.id;
						actionName = "Allocate";
						clore = 'background-color: cornflowerblue;';
					}else{
						link = '<?php echo base_url(); ?>Coldchain/'+full.formlink+'/'+full.id;
						actionName = "Transfer";
						clore = "background-color: cornflowerblue;";
					}
					button = '<button style="margin:2px; '+clore+'" onclick="getDetail('+full.id+','+full.storetype+')" type="button" id="addtransferbtn" class="btn btn-success btn-md" data-toggle="modal" data-target="#AddBatchModal">'+actionName+'</button>';
				}
                return button;
            } 
          }, */
		   { orderable: false,
            render : function(data, type, full) {
				
				link = '<?php echo base_url(); ?>Coldchain/'+full.formeditlink+'/'+full.id;
					editlink='<a href="'+link+'" class="btn view-btn"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit"></i></a>';
			
				/* if(full.used_by_stock > 0){
					
					if(level==2  && full.warehouse_type_id!=warehousename)
						editlink="";
					link = '<?php echo base_url(); ?>Coldchain/'+full.formlink+'/'+full.id;
					button = '<td><a href="'+link+'" class="btn view-btn"><i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" title="View"></i></a>'+editlink+'</td>';
					//button = '<td><i data-toggle="tooltip" title="In Use"></i></td>';
				}else{ */
					
					if(level==2  && full.warehouse_type_id!=warehousename)
						editlink="";
					if(full.storetype==0){
						link = '<?php echo base_url(); ?>Coldchain/'+full.formlink+'/'+full.id;
						//actionName = "Allocate";
						actionName = '<i class="fas fa-hockey-puck" data-toggle="tooltip" title="Allocate"></i>';
						clore = 'background-color: cornflowerblue;';
					}else{
						link = '<?php echo base_url(); ?>Coldchain/'+full.formlink+'/'+full.id;
						//actionName = "Transfer";
						actionName =  '<i class="fas fa-exchange-alt" data-toggle="tooltip" title="Transfer"></i>';
						clore = "background-color: cornflowerblue;";
					}
					button = '<a href="'+link+'" class="btn view-btn"><i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" title="View"></i></a>'+editlink+' <a onclick="getDetail('+full.id+','+full.storetype+')"  id="addtransferbtn" class="btn view-btn" data-toggle="modal" data-target="#AddBatchModal">'+actionName+'</a>';
				    //button = '<a onclick="getDetail('+full.id+','+full.storetype+')"  id="addtransferbtn" class="btn view-btn" data-toggle="modal" data-target="#AddBatchModal">'+actionName+'</a>';
				//}
				return button;
            } 
          } 
		   
        ]; 
 
  var table = $('#myTable').DataTable({
		"pageLength" : 30,
        "serverSide": true,
		"lengthChange": false,
		// if($('#myTable  tr > 1')){"bInfo" : false,}
		"order": [
          [1, "desc" ]
        ],
		"ajax": {
            url : "<?php echo base_url(); ?>Coldchain/coldchain_list",
            type : 'GET'
        },
        "columns": columns,
        dom: 'lrtips',
		 drawCallback: function(settings) {
			var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
			pagination.toggle(this.api().page.info().pages > 0);
			var pagelength=this.api().page.info().pages;
			//console.log(settings);
			//alert(this.api().page.info().pages);
			//var pg=1;
			if(pagelength > 0 ) {
			$(this).closest('.dataTables_wrapper').find('.dataTables_info').show();
			} 
			else
			{
			$(this).closest('.dataTables_wrapper').find('.dataTables_info').hide();
			}	
			
			
		 }
      });
	  
	  table.search('<?php echo $assetNameId; ?>'+"-"+"").draw();
	  
	$('#warehouse_type_id').on('change', function () {
		if($(this).val()=='0' || $(this).val()=='2'){
			$('.disthide').hide();
			
		}else{
			$('.disthide').show();
			
		}
		<?php if( $assetid =='23' || $assetid =='26' || $assetid =='33'){ ?>
		table.columns(3).search( this.value ).draw();
		<?php } else { ?> 
		table.columns(4).search( this.value ).draw();
		<?php }  ?>
	});
	$('#status_w').on('change', function () {
		<?php if( $assetid =='23'|| $assetid =='26' || $assetid =='33'){ ?>
		table.columns(7).search( this.value ).draw();
		<?php } else { ?>
		table.columns(8).search( this.value ).draw();
		<?php }  ?>
	});
	 $('#distcode').on('change', function () {
		 var distcode=$(this).val();
		 table.search('<?php echo $assetNameId; ?>'+"-"+distcode).draw();
	//table.columns(8).search( this.value ).draw();
    // Redraw data table, causes data to be reloaded
    //table.draw();
	}); 
$('#btn-modalForm-submit-transfer').on('click', function(e) {
	var requiredfields = checkRequired(true);
	e.preventDefault();
	if(requiredfields){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Coldchain/transfer",
			data: $('#modalForm-transfer').serialize(),
			success: function(response) {
				if(response =="required"){
					alert('Please Select Required Fields!');
				}else{
					alert(response);
					$( "#cancelmodal" ).click();
					table.search('<?php echo $assetNameId; ?>').draw();
				}
			}
		});
	}
});
//});
function getDetail(id,storetype)
{
	var title = "";
	$(".modal-title-transfer").empty();
	if(storetype==0){
		title = "Allocate";
	}
	else
	{
		title = "Transfer";
	}
	$(".modal-title-transfer").append(title+" <?php echo $_nameform; ?>");
	$("#asset_id").val(id+"-"+title+"-<?php echo $assetid;?>");
	var assetsID = '<?php echo $this -> uri -> segment(3); ?>';
	var coldcahin_name = '<?php echo $this -> uri -> segment(2); ?>';
	$.ajax({
			type: "GET",
			data:{"assetid": id,"assetsID": assetsID,"coldcahin_name": coldcahin_name},
			url: "<?php echo base_url();?>Coldchain/transferModal",
			
			success: function(result) {
				$('#transfer').html(result);
			}
		});
	

 }
///satsus detail///
$('#btn-modalForm-submit-status').on('click', function(e) {
	//var requiredfields = checkRequired(true);
	e.preventDefault();
	//if(requiredfields){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Coldchain/status",
			data: $('#modalForm-status').serialize(),
			success: function(response) {
				alert(response);
				$( "#cancelmodal" ).click();  
				window.location.reload(); 
				/* if(response =="required"){
					alert('Please Select Required Fields!');
				}else{
					alert(response);
					$( "#cancelmodal" ).click();
					table.search('<?php echo $assetNameId; ?>').draw();
					window.location.reload(); 
				} */
			}
		});
	//}
});

function getstatusDetail(id)
{
	//var title = "";
	//$(".modal-title-status").empty();
	//$(".modal-title-status").append(title+" <?php echo $_nameform; ?>");
	//$("#asset_id").val(id+"-"+title+"-<?php echo $assetid;?>");
	$.ajax({
		
			type: "POST",
			data: "assetid="+id,
			url: "<?php echo base_url();?>Coldchain/statusModal",
			
			success: function(result) {
				$('#status').html(result);
			}
		});
	

 } 
 
$(document).on('click','#addtransferbtn',function(){
	$('#modalForm-transfer').trigger("reset");
	$("#dist_hid").hide();
	$("#tcode_hid").hide();
	$("#uncode_hid").hide();
	$("#facode_hid").hide();
	

});

</script>