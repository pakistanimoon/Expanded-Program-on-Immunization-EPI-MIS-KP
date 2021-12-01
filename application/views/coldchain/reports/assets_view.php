<?php //print_r($Assetresult); exit;?>

<div class="container bodycontainer">
<?php 
if($TopInfo!=''){
     echo $TopInfo;
  }
   //echo $htmlData; 
  ?>
  <div id="parent" style="overflow:auto">
		<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Equipment Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Level</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Wharehouse Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Wharehouse</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Make</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Model</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Working Status</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Asset Type</th>
				</tr>
				
			</thead>
			<tbody>
			<?php if(!$Assetresults==0){?>
			<?php foreach($Assetresults as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
					<input type = "hidden" name = "id" value = "<?php echo $val['id']; ?>" />
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['ccm_user_asset_id']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['stroe_level']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['storecode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['storename']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['make_name']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['model_name']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo (isset($val)?getWorkingstatus($val['status'],TRUe):''); ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['asset_type_name']; ?></td>
				</tr>
			<?php } ?>
			
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			</tbody>
			
		</table>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://epibeta.pacemis.com/includes/js/tableHeadFixer.js"></script>
<script src="http://epibeta.pacemis.com/includes/bootstrap/js/bootstrap.min.js"></script>
<script>
		  $(document).ready(function() {
				$("#fixTable").tableHeadFixer(); 
			}); 
			$(document).on('click',".DrillDownRow", function(){
				var code =$(this).closest('tr').eq(0).find('input').val();
				//alert(code); exit();
				var url = '';  
				url = "<?php echo base_url();?>Assets/View/"+code+"";   				
				var win = window.open(url,'_blank');
			   if(win){
				  //Browser has allowed it to be opened
				  win.focus();
				}else{
				  //Broswer has blocked it
				  alert('Please allow popups for this site');
				}
            });
	</script>