

<div class="container heading-line top-margin">
	<h3 class="heading-1">Cold Chain Asset</h3>
<div style="margin-right:3%;"><a href="<?php echo base_url(); ?>Coldchain/coldchain_main" class="btn green-btn" style="float:right; margin-bottom:15px; margin-left:41%;" type="btn"><i class="fa fa-plus"></i>Add New</a></div>
<!--<button type="button" a href="<?php echo base_url(); ?>Coldchain/coldchain_main" id = "" style="margin-left:41%;" class="btn btn-primary add-new-1 box" ><i class="fa fa-plus" aria-hidden="true"></i> Add new</button>-->
	<table id="example" class="table table-bordered table-condensed table-striped table-hover mytable3">       
		<thead>        
			<tr style="font-size:15px;">		
				<th style="width:6%;">Sr. No</th>				
				<th>Asset</th>	
				<th style="padding:10px;">Warehouse Name</th>		
				<th>Status</th>			
				<th>Action</th>		
			</tr>		
		</thead>        
		<tbody>      
		<?php $i=1; ?>	   
		<?php foreach($data as $key=>$val) { ?>  
			<tr>		
				<td style="text-align:center;"><?php echo $i; ?></td>			
				<td style="text-align:center;"><?php echo $val['asset_type_name']; ?></td>		
				<td style="text-align:center;"><?php echo $val['warehouse_name']; ?></td>			
				<td style="text-align:center;"><?php echo $val['status']; ?></td>			
				<td style="text-align:center;">			
				<a data-original-title="Edit" href="<?php echo base_url(); ?>Coldchain/coldchain_main_edit/<?php echo $val['asset_id'];?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>	
				<a href="<?php echo base_url(); ?>Coldchain/coldchain_main_view/<?php echo $val['asset_id']; ?>" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>	
				</td>      
			</tr>		
		<?php $i++; } ?>    
		</tbody> 
	</table>
</div>
<script type="text/javascript"> 
	$(document).ready(function() {	
		$('#example').DataTable();  	
			$("#search-word").keyup(function(){	
				search_table($(this).val());     
			});  
	});
 </script>