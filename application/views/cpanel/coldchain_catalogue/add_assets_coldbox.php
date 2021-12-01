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
.switch {
  position: relative;
  display: inline-block;
  width: 38px;
  height: 20px;
  top: 4px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
 height: 14px;
width: 14px;
left: -5px;
bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}
input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<div class="container bodycontainer">
	<h3 class="page-title" style="margin-bottom: -8px;">Cold Chain Catalogues</h3>
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
			<li role="presentation" ><a class="assets fa fa-table" data-id="1-Refrigerator" href="<?php echo base_url(); ?>Coldchain/Catalogue_Refrigerator_List/1"><i></i><span class="strong" style="padding-left:5px">Refrigerator</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="21-Cold Room" href="<?php echo base_url(); ?>Coldchain/Catalogue_Coldroom_List/21"><i></i><span class="strong" style="padding-left:5px">Cold Room</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="23-Voltage Regulator" href="<?php echo base_url(); ?>Coldchain/Catalogue_Voltageregulator_List/23"><i></i><span class="strong" style="padding-left:5px">Voltage Regulator</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="24-Generator" href="<?php echo base_url(); ?>Coldchain/Catalogue_Generator_List/24"><i></i><span class="strong" style="padding-left:5px">Generator</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="25-Transport" href="<?php echo base_url(); ?>Coldchain/Catalogue_Transport_List/25"><i></i><span class="strong" style="padding-left:5px">Transport</span></a></li>
			<li role="presentation" ><a class="assets fa fa-table" data-id="26-Vaccine Carriers" href="<?php echo base_url(); ?>Coldchain/Catalogue_Vaccinecarriers_List/26"><i></i><span class="strong" style="padding-left:5px">Vaccine Carriers</span></a></li>
			<li role="presentation" class="active"><a class="assets fa fa-table" data-id="33-Cold Box" href="<?php echo base_url(); ?>Coldchain/Catalogue_Coldbox_List/33"><i></i><span class="strong" style="padding-left:5px">Cold Box</span></a></li>
		</ul>
  </div>
  </div>
</div><!---- row ---->
	<!-- Filter Dropdown -->
	<div id="deorowhide">
		<div class="row" > 
			<div class="col-md-5 text-right" style="margin-left: 628px;";>
			<a href="<?php echo base_url(); ?>Coldchain/Catalogue_coldBoxAdd" data-toggle="tooltip" title="Add Catalogues">
	         <button type="button"  class="submit btn-success btn-sm pull-right" style="background:#008d4c;color:white;"><i class="fa fa-plus" aria-live="polite"></i>
		     Add Catalogues</button>	
			 </a>
			</div> 
		</div> 
	</div>	
	<!-- -->
	<?php if($this -> session -> flashdata('message')){  ?><div class="text-center" id="alert" role="alert" style="color: #fff;background-color: #3C8DBC;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
	<table id="myTable" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true"  style="padding-top:1%; border: 1px solid">
	  <thead>
		<tr>
		  <th class="text-center width-25 Heading">S#</th>
		  <th class="text-center Heading">Catalogue Name</th>
		  <th class="text-center Heading">Asset Name</th>
		  <th class="text-center Heading">Make</th>
		  <th class="text-center Heading">Model</th>
		  <th class="text-center Heading">Action</th>
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
			  <td><?php echo $row['catalogue_id'];?></td>	  
			  <td><?php echo $row['assetname'];?></td>	    
			  <td><?php echo $row['make_name'];?></td>	  
			  <td><?php echo $row['model_name'];?></td>	   
			  <td>
				<a href="<?php echo base_url(); ?>Coldchain/Catalogue_coldBoxEdit/<?php echo $row['pk_id']?>" class="btn view-btn"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit"></i></a> 
				<label class="switch">
					<input type="hidden" name="pk_id" class="pk_id" value="<?php echo $row['pk_id'];?>">						
					<input type="checkbox" class="status" id="status" checked="checked">
					<span class="slider round"></span>
				</label>
			 </td>	  
			</tr>
			
			
		<?php } ?> 
	  </tbody>
    </table>
</div>
<script type="text/javascript">
$(document).ready(function () {
	var link = "";
	var button = "";
	var editlink="";
	var columns = [
          { data: "serial",
		  orderable: false,
		  },
		  { data: "catalogue_id" },
		  { data: "assetname" },
          { data: "make_name" },
          { data: "model_name" },
		  {data: "pk_id", 
		  orderable: false,
            render : function(data, type, full) {
				link = '<?php echo base_url(); ?>Coldchain/'+full.formeditlink+'/'+data;
				editlink='<a href="'+link+'" class="btn view-btn"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit"></i></a>';
				if(full.is_active==1){
					button = '<td>'+editlink+'<input type="hidden" name="pk_id" class="pk_id" value="'+data+'"><label class="switch"><input type="checkbox" class="status" id="status" value="'+1+'" checked="checked"><span class="slider round"></span></label></td>';
				}else{
					button = '<td>'+editlink+'<input type="hidden" name="pk_id" class="pk_id" value="'+data+'"><label class="switch"><input type="checkbox" class="status" id="status" value="'+0+'" ><span class="slider round"></span></label></td>';
				}
				return button;
            } 
          }
		]; 
 
  var table = $('#myTable').DataTable({ 
		"pageLength" : 30,
        "serverSide": true,
		"lengthChange": false,
		"order": [
          [1, "desc" ]
        ],
		"ajax": {
            url : "<?php echo base_url(); ?>cpanel/coldchain_catalogue/Coldchain_catalogue/catalogue_coldchain_list",
            type : 'GET'
        },
        "columns": columns,
        dom: 'lrtips'
      });
	  
	table.search('<?php echo $assetNameId; ?>'+"-"+"").draw();
});
$(document).on('click','.status',function(){
	var status = $(this).val();
	var id=  $(this).closest("tr").find(".pk_id").val();
	if(status==1){
		status=0;
	}else{
		status=1;
	}
	var confirmalert = confirm("Are you sure?");
	if (confirmalert == true) {
		$.ajax({
			type: "POST",
			data: "id="+id+"&status="+status,
			url: "<?php echo base_url(); ?>cpanel/coldchain_catalogue/Coldchain_catalogue/status_update",
			success: function(result){
				window.location.reload();    
			}
		
		});
	}else{
		var status = $(this).val();
		if(status==1){ 
			$(this).closest("tr").find(".status").prop("checked",true);
		}else{ 
			$(this).closest("tr").find(".status").prop("checked",false);
		}
	}
});
</script>