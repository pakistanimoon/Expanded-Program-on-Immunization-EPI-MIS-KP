	<?php if($this -> session -> flashdata('message')){  ?>
                          <div class="row mb3">
                            <div class="col-sm-12 filters-selection" style="Background-color:#008d4c;">
                              <div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
                            </div>
                          </div>
                        <?php } ?>
	<div class="container heading-line top-margin">
	
         <h3 class="heading-1">Adjustment Types</h3>
			<button type="button" id="addNew" style="margin-left:41%;" class="btn btn-primary add-new-1 box"><i class="fa fa-plus" aria-hidden="true"></i>Add new</button>
		  <div id="demo-1" class="collapse">
			<div class="row" style="position:relative;">
				<div class="col-md-4 coll-1" style="border: 1px solid lightgray;
			margin-left: 14px;height: 45px;padding-top: 6px;"><span class="bps">Type:</span></div>
		        <input name="idd" id="idd" type="hidden" value="">
				<div class="col-md-4 coll-2" style="border:1px solid lightgray;  height:45px; padding-top:6px"><span class="input-bps"><input style="font-size:16px; top:-1px; "id="purpose" name="purpose" type="text" class="form-control" placeholder=""></span></div>
				<div class="col-md-4 coll-3" style="width:31%;border:1px solid lightgray;  height:45px; padding-top:6px">
					<Button type = "Button" class="btn-background box1" style="margin-left:100px;" id = "save"> <span class="save-1" style="border:none;"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</span></button>
					<Button type="Button" class="btn-background box1" id = "cancel">  <span class="save-1" style="border:none;"><i class="fa fa-times" aria-hidden="true"></i>Cancel</span></button>
				</div>
			</div>
			
		  </div>
		<div class="row" style="margin-top:40px;">
						<table style="margin-top:30px; margin-bottom:20px; text-align:center;" id="example" class="table table-striped table-bordered res-1 table-responsive" cellspacing="0" width="97%" style="border: 1px solid #ccc4c4 !important; position:relative; top:-30px;">
				
        <thead>
            <tr>
                <th style="background-color:#008d4c; color:white; text-align:center">S.No</th>
                <th style="width:75%;background-color:#008d4c; color:white; text-align:center">Adjustment Type:</th>
                <th style="background:#008d4c; color:white; text-align:center">Action</th>
                
            </tr>
        </thead>
        <tbody>
		<?php $i=1; ?>
			<?php foreach($data as $key=>$val) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $val['type']; ?></td>
                <td><a style="color:#008d4c" href = "<?php echo base_url(); ?>Admin_Configuration/delete_adjustment/<?php echo $val['id']; ?>" ><i class="fa fa-times" aria-hidden="true"></i></a>
				<a data-id="<?php echo $val['id']; ?>" style="color:#008d4c" id = "edit" href = "#"  ><i class="fa fa-pencil-square" aria-hidden="true"></i></a></td>
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
		var purpose = $('#purpose').val();
		var update_id = $('#idd').val();
		//alert(purpose);
		var name = "manufacturer";
		if(purpose=="")
			alert('You are entering Invalid Purpose Type!');
		else{
			$.ajax({
				type:"POST",
				data:"purpose= "+ purpose+"&name= "+name+"&update_id="+update_id,
				url:"<?php echo base_url(); ?>Admin_Configuration/adjustment_save",
				success: function(result){
								if(result==1){
									window.location.href = '<?php echo base_url(); ?>Admin_Configuration/adjustment';
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
     url: "<?php echo base_url(); ?>Admin_Configuration/edit_adjustment",
     success: function(result){
		//alert(result);
      $('#idd').val(id);
      $('#purpose').val(result);
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