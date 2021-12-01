      <!-- Content Wrapper. Contains page content -->
          <div class="container">

            <div class="row">
    <div class="panel panel-primary">
           <ol class="breadcrumb">
           <ul class="breadcrumb"><li><a href="http://pace-tech.com/nomi/epimis/">Home</a> <span class="divider"></span></li><li class="active"></li></ul>
        </ol> 
      <div class="panel-heading"> Tehsil Population Form
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing footable-loaded" data-filter="#filter" data-filter-text-only="true">
          <thead>
          <tr>
                <th class="text-center Heading">S#</th>
                <th class="text-center Heading">Teshil</th>
                <th class="text-center Heading">Tehsil Code</th> 
                <th class="text-center Heading">Previous Year (<?php echo date("Y")-1;?>)</th>
                <th class="text-center Heading">Current Year Population (<?php echo date("Y");?>)</th> 
                <th class="text-center Heading">Next Year Population (<?php echo date("Y")+1;?>)<!--<input type="checkbox" id="nextYear" onclick="EnableDisableTextBox(this)"  style="display: inline-block;vertical-align:text-bottom; margin-bottom:2px; margin-left:6px;" />-->
          </th>
                <form method="post" action="<?php echo site_url('Population/addTehsil'); ?>">
				        
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
               <td class='text-left'><?php echo $value->tehsil; ?></td>
               <td class='text-center' ><?php echo $value->tcode; ?></td>
               <td class='text-center'><span class='previous'> <?php if(isset($value->previous) && !empty($value->previous)){echo $value->previous;}else{ echo 0; } ?></span></td>
               <td class='text-center'><span class='current' name='current[]' ><?php if(isset($value->current) && !empty($value->current)){echo $value->current ;} ?></span></td>
              <td class='text-center'><span class='next'   name='next[]'><?php if(isset($value->next) && !empty($value->next)){echo $value->next;} ?></span></td> 
            </tr>
            <input type='hidden' name='addeddate[]' value='<?php echo $value->addeddate; ?>'>
            <?php $index++;
          }
          ?> 
            <tr>
				<td class="text-right" colspan="3"><strong>Total: </strong></td>
				<td class="text-center"><strong><p id="previoustotal"></p></strong></td>
				<td class="text-center"><strong><p id="currenttotal"></p></strong></td>
				<td class="text-center"><strong><p id="nexttotal"></p></strong></td>
			</tr> 
            </tbody>
           </table>
            </div><!--end of body container -->
            
         </form>
		 </div>
    </div><!-- ./wrapper -->
	</div>

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
    
	$(document).ready(function(){
		var $previoussum = 0;
		$('.previous').each(function(k,v){
			if( ! isNaN(parseInt($(this).text()))){
				$previoussum += parseInt($(this).text());
			}
		});
		var $currentsum = 0;
		$('.current').each(function(k,v){
			if( ! isNaN(parseInt($(this).text()))){
				$currentsum += parseInt($(this).text());
			}
		});
		var $nextsum = 0;
		$('.next').each(function(k,v){
			if( ! isNaN(parseInt($(this).text()))){
				$nextsum += parseInt($(this).text());
			}
		});
		$('#previoustotal').text($previoussum);
		$('#currenttotal').text($currentsum);
		$('#nexttotal').text($nextsum);
	});
	$(document).on('keyup','.next,.current',function(){
		var $previoussum = 0;
		$('.previous').each(function(k,v){
			if( ! isNaN(parseInt($(this).text()))){
				$previoussum += parseInt($(this).text());
			}
		});
		var $currentsum = 0;
		$('.current').each(function(k,v){
			if( ! isNaN(parseInt($(this).text()))){
				$currentsum += parseInt($(this).text());
			}
		});
		var $nextsum = 0;
		$('.next').each(function(k,v){
			if( ! isNaN(parseInt($(this).text()))){
				$nextsum += parseInt($(this).text());
			}
		});
		$('#previoustotal').text($previoussum);
		$('#currenttotal').text($currentsum);
		$('#nexttotal').text($nextsum);
	});
</script>