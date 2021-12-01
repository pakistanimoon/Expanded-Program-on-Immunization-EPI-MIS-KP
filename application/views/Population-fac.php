      <!-- Content Wrapper. Contains page content -->
          <div class="container">

            <div class="row">
    <div class="panel panel-primary">
           <ol class="breadcrumb">
           <!--<ul class="breadcrumb"><li><a href="http://pace-tech.com/nomi/epimis/">Home</a> <span class="divider"></span></li><li class="active"></li></ul>-->
        </ol> 
      <div class="panel-heading"> EPI Center Population Form
        </div>
		<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
        <form method="post" action="<?php echo site_url('Population/addFacilities'); ?>">
		<div class="panel-body">
            <table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing footable-loaded" data-filter="#filter" data-filter-text-only="true">
          <thead>
          <tr>
                <th class="text-center Heading">S#</th>
                <th class="text-center Heading">EPI Center Code</th>
                <th class="text-center Heading">EPI Center</th>                 
                <th class="text-center Heading">Union Council</th>  
                <th class="text-center Heading">Previous Year (<?php echo date("Y")-1;?>)</th>
                <th class="text-center Heading">Current Year Population (<?php echo date("Y");?>)</th> 
                <th class="text-center Heading">Next Year Population (<?php echo date("Y")+1;?>)<input type="checkbox" id="nextYear" onclick="EnableDisableTextBox(this)"  style="display: inline-block;vertical-align:text-bottom; margin-bottom:2px; margin-left:6px;" />
          </th>
                
				        
                <label for="nextYear">
					 
						    
					</label>
          </th>                
         </tr>    
         </thead>

<?php $index=1; ?>

            <tbody id="tbody">
            <?php foreach ($data as $i => $value) { ?>
            <tr>
				<td class='text-center Heading'><?php echo $index; ?></td>
				<td class='text-left' ><input name='facode[]' readonly value="<?php echo $value->facode; ?>" class='form-control text-center'></td>
				<td class='text-left'><input type='text' name='facility[]' value="<?php echo $value->fac_name; ?>" readonly class='form-control'></td>
				<td class='text-left' ><input readonly value="<?php echo get_UC_Name($value->uncode); ?>" class='form-control text-center'></td>
				<input type='hidden' name='uncode[]' value="<?php echo $value->uncode; ?>">
				<input type='hidden' name='tcode[]' value="<?php echo $value->tcode; ?>">
				<input type='hidden' name='distcode[]' value="<?php echo $value->distcode; ?>">
				<td class='text-center'><input readonly value='<?php if(isset($value->previous) && !empty($value->previous)){echo $value->previous;}else{ echo 0; } ?>' class='form-control text-center numberclass previous'></td>
				<td class='text-left'><input class='form-control text-center numberclass current' name='current[]' value='<?php if(isset($value->current) && !empty($value->current)){echo $value->current ;} ?>'></td>
				<td class='text-left'><input class='form-control text-center group1 numberclass next'   name='next[]' id='textNextYear' disabled='disabled' value='<?php if(isset($value->next) && !empty($value->next)){echo $value->next;} ?>'></td> 
            </tr>
            <input type='hidden' name='addeddate[]' value='<?php echo $value->addeddate; ?>'>
            <?php $index++;
          }
          ?> 
            <tr>
            	<td></td>
				<td class="text-right" colspan="3"><strong>Total: </strong></td>
				<td class="text-center"><strong><p id="previoustotal"></p></strong></td>
				<td class="text-center"><strong><p id="currenttotal"></p></strong></td>
				<td class="text-center"><strong><p id="nexttotal"></p></strong></td>
			</tr> 
            </tbody>
           </table>
            </div><!--end of body container -->
            <div class="container">
				<div class="row">
					<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
						<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button">Submit</button>
					</div>
				</div>
			</div>
        </form>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg" style="margin-top: 90px;">
        
    </div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

     <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
   <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script type="text/javascript">
    
	$('#nextYear').change(function() {
		if (this.checked) {
			$("input.group1").removeAttr("disabled");
		}
		else {
			$("input.group1").attr("disabled", true);
		}
	});
	$(document).ready(function(){
		var $previoussum = 0;
		$('.previous').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$previoussum += parseInt($(this).val());
			}
		});
		var $currentsum = 0;
		$('.current').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$currentsum += parseInt($(this).val());
			}
		});
		var $nextsum = 0;
		$('.next').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$nextsum += parseInt($(this).val());
			}
		});
		$('#previoustotal').text($previoussum);
		$('#currenttotal').text($currentsum);
		$('#nexttotal').text($nextsum);
	});
	$(document).on('keyup','.next,.current',function(){
		var $previoussum = 0;
		$('.previous').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$previoussum += parseInt($(this).val());
			}
		});
		var $currentsum = 0;
		$('.current').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$currentsum += parseInt($(this).val());
			}
		});
		var $nextsum = 0;
		$('.next').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$nextsum += parseInt($(this).val());
			}
		});
		$('#previoustotal').text($previoussum);
		$('#currenttotal').text($currentsum);
		$('#nexttotal').text($nextsum);
	});
</script>