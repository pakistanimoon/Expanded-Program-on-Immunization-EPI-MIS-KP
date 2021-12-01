	<?php if($this -> session -> flashdata('message')){  ?>
                          <div class="row mb3">
                            <div class="col-sm-12 filters-selection" style="Background-color:#008d4c;">
                              <div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
                            </div>
                          </div>
                        <?php } ?>
						
	<div class="container heading-line top-margin">
	
         <h3 class="heading-1">EPI Stake Holder</h3>
			<button type="button" id = "addNew" style="margin-left:41%;" class="btn btn-primary add-new-1 box" ><i class="fa fa-plus" aria-hidden="true"></i>Add new</button>
		  <div id="demo-1" class="collapse">
		    <div class="row" style="width:100%; margin:0 auto;">
				
				<div class="col-md-4" style="margin-top:6px;">
				  
					<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px;width:100%;">
						<label for="Model"  style="margin:10px 0px 0xp 10px">Stake Holder :</label>
						
						<input name="idd" id="idd" type="hidden" value="">
						<input id="stakeholder" name="model" class="form-control" type="text">
					</div>
				</div>
				<div class="col-md-4" style="margin-top:6px;">
					<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px; width:100%;">
						<label for="Make" style="margin:10px 0px 0xp 10px">Perant :</label>
						 
						<select name="make_id" id="parent_id" required class="form-control">
							<option value="0" >--Select--</option>
		                        <?php
                                    foreach($data as $key=>$val){
                                ?>
                            <option value="<?php echo $val['pk_id']; ?>" ><?php echo $val['stakeholder_name']; ?></option>
                             <?php } ?>
             
						</select>
					</div>
				</div>
			</div>
			<div class="row" style="margin-top:10px;">
				<div class="col-md-4 col-md-offset-8">
				<Button type="Button" class="btn-background box1" style="margin-left:139px;" id = "save"> <span class="save-1" style="border:none; top:0px;"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</span></button>
				<Button type="Button" class="btn-background box1" id = "cancel">  <span class="save-1" style="border:none; top:0px;"><i class="fa fa-times" aria-hidden="true"></i>Cancel</span></button>
					</div>
			</div> 
		</div>
		<div class="row" style="margin-top:40px;">
						<table style="margin-top:30px; margin-bottom:20px; text-align:center;" id="example" class="table table-striped table-bordered res-1 table-responsive" cellspacing="0" width="97%" style="border: 1px solid #ccc4c4 !important; position:relative; top:-30px;">
				
        <thead>
            <tr>
                <th style="background-color:#008d4c; color:white; text-align:center">S.No</th>
                <th style="width:75%;background-color:#008d4c; color:white; text-align:center">Stake Holder Name</th>
                <th style="background:#008d4c; color:white; text-align:center">Action</th>
                
            </tr>
        </thead>
        <tbody><?php $i=1; ?>
			<?php foreach($data as $key=>$val) { ?>
            <tr>
                <td><?php echo $i; ?></td>
				<td><?php echo $val['stakeholder_name']; ?></td>
                <td><a style="color:#008d4c" href = "<?php echo base_url(); ?>Admin_Configuration/delete_stakeholder/<?php echo $val['pk_id']; ?>" ><i class="fa fa-times" aria-hidden="true"></i></a>
                <a data-id="<?php echo $val['pk_id']; ?>"  style="color:#008d4c" id = "edit" href = "#"  ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
				</td>
		   </tr>
		   <?php $i++; }	?>
        </tbody>
	 </table>
      </div>		
	</div>
<!--<script src="<?php echo base_url(); ?>includes/studentTest/js/jquery-3.1.1.min.js"></script>-->
<script src="<?php echo base_url(); ?>includes/js/custome.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!--<script src="<?php echo base_url(); ?>includes/studentTest/js/bootstrap.min.js"></script>-->
<script>
$(document).ready(function() {

     $('#example').DataTable( 
	 /* {
        "pagingType": "full_numbers"
    } */);  
 $("#search-word").keyup(function(){
 search_table($(this).val());
 });

});
</script>
<script type="text/javascript">
   $(document).on('click','#save',function(){
		var stakeholder = $('#stakeholder').val();
		var parent_id = $('#parent_id').val();
		var update_id = $('#idd').val();
		//alert(parent_id);
		var name = "manufacturer";
		if(stakeholder=="")
			alert('You are entering Invalid Name Type!');
		else{
			$.ajax({
				type:"POST",
				data:"stakeholder= "+ stakeholder+"&name= "+name+"&parent_id="+parent_id+"&update_id="+update_id,
				url:"<?php echo base_url(); ?>Admin_Configuration/stakeholder_save",
				success: function(result){
								if(result==1){
								window.location.href = '<?php echo base_url(); ?>Admin_Configuration/stakeholder';
								}else{
									alert('Something went wrong! Please Refresh your page to continue!');
								}
							}
			});
		}
	});  
	  $(document).on('click','#edit',function(){
    var id = $(this).data("id");
	//alert(id);
    $.ajax({ 
     type: "POST",
     data:"id="+id,
     async:false,
	 dataType : 'json',
     url: "<?php echo base_url(); ?>Admin_Configuration/edit_stakeholder",
     success: function(result){
		//alert(result);
      $('#idd').val(result.pk_id);
      $('#stakeholder').val(result.stakeholder_name);
	  $("#parent_id").val(result.parent_id);
	  
     }
    }); 
   }); 
	 
	$(document).on('click','#cancel',function(){
		$('#demo-1').hide();
	});
	$(document).on('click','#addNew',function(){
		$('#demo-1').show();
	});
	$(document).on('click','#edit',function(){
		$('#demo-1').show();
	});
</script>