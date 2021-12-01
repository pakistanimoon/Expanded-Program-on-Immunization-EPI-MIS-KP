      <!-- Content Wrapper. Contains page content -->
          <div class="container">

            <div class="row">
    <div class="panel panel-primary">
           <ol class="breadcrumb">
           <!--<ul class="breadcrumb"><li><a href="http://pace-tech.com/nomi/epimis/">Home</a> <span class="divider"></span></li><li class="active"></li></ul>-->
        </ol> 
		
      <div class="panel-heading"> Union Council Population Form
        </div>
		<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
        <div class="panel-body">
            <table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing footable-loaded" data-filter="#filter" data-filter-text-only="true">
          <thead>
          <tr>
                <th class="text-center Heading">S#</th>
                <th class="text-center Heading">Union Council</th>
                <th class="text-center Heading">UC Code</th> 
                <th class="text-center Heading">Previous Year (<?php echo date("Y")-1;?>)</th>
                <th class="text-center Heading">Current Year Population (<?php echo date("Y");?>)</th> 
                <th class="text-center Heading">Next Year Population (<?php echo date("Y")+1;?>)
				<!--<input type="checkbox" id="nextYear" onclick="EnableDisableTextBox(this)"  style="display: inline-block;vertical-align:text-bottom; margin-bottom:2px; margin-left:6px;" />-->
          </th>
                <form method="post" action="<?php echo site_url('Population/addUC'); ?>">
				        
                <label for="nextYear">
					 
						    
					</label>
          </th>                
         </tr>    
         </thead>

<?php $index=1; ?>

            <tbody id="tbody">
            <?php foreach ($data as $i => $value) { ?>
            <tr class="<?php echo substr($value->uncode,0,6);?>">
               <td class='text-center Heading'><?php echo $index; ?></td>
               <td class='text-left'><?php echo $value->un_name; ?></td>
               <td class='text-center' ><?php echo $value->uncode; ?></td>
               <td class='text-center'><span  class='previous'><?php if(isset($value->previous) && !empty($value->previous)){echo $value->previous;}else{ echo 0; } ?></span></td>
               <td class='text-center'><span class='current' name='current[]'><?php if(isset($value->current) && !empty($value->current)){echo $value->current ;} else echo 0; ?></span></td>
               <td class='text-center'><span class='next'   name='next[]'><?php if(isset($value->next) && !empty($value->next)){echo $value->next;} else echo 0; ?></span></td> 
            </tr>
            <input type='hidden' name='addeddate[]' value='<?php echo $value->addeddate; ?>'>
            <?php $index++;$tehsilcount[$i] =  substr($value->uncode,0,6);
          }
		  $finalcount = array_unique($tehsilcount);
		  $finalcount = array_values($finalcount);
		  //print_r($finalcount);exit;
          ?> 
			<tr>
				<td class="text-right" colspan="3"><strong>District Total: </strong></td>
				<td class="text-center"><strong><p id="previoustotal"></p></strong></td>
				<td class="text-center"><strong><p id="currenttotal"></p></strong></td>
				<td class="text-center"><strong><p id="nexttotal"></p></strong></td>
			</tr>
			<?php $countt = sizeof($finalcount);  for($i=0;$i<$countt;$i++) {?>
				<tr class="tehsiltotal" data-tcode="<?php echo $finalcount[$i]; ?>">
					<td class="text-right" colspan="3"><strong>Tehsil <?php echo tehsilname($finalcount[$i]); ?> Total</strong></td>
					<td class="text-center"><strong><p class="prevtot"></p></strong></td>
					<td class="text-center"><strong><p class="currtot"></p></strong></td>
					<td class="text-center"><strong><p class="nexttot"></p></strong></td>
				</tr>
				<!--<tr class="tehsiltotal" data-tcode="326002">
					<td class="text-right" colspan="3"><strong>Tehsil2 Total: </strong></td>
					<td class="text-center"><strong><p class="prevtot"></p></strong></td>
					<td class="text-center"><strong><p class="currtot"></p></strong></td>
					<td class="text-center"><strong><p class="nexttot"></p></strong></td>
				</tr>-->
			<?php }
			?>
            </tbody>
           </table>
            </div><!--end of body container 
            <div class="container">
				<div class="row">
					<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
						<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button">Submit</button>
					</div>
				</div>
			</div>-->
         </form>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
		   </div>
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
	$(document).ready(function(){dosum();});
	function dosum(){
		var distcurrsum = tehsilcurrsum = distprevsum = tehsilprevsum = distnextsum = tehsilnextsum = 0;
		$('.tehsiltotal').each(function(){
			var tcode = $(this).data("tcode");
			tehsilcurrsum = tehsilprevsum = tehsilnextsum = 0;
			$("."+tcode).each(function(){
				tehsilcurrsum+=parseInt($(this).find("span[name^=current]").text());
				distcurrsum+=parseInt($(this).find("span[name^=current]").text());
				tehsilprevsum+=parseInt($(this).find(".previous").text());
				distprevsum+=parseInt($(this).find(".previous").text());
				tehsilnextsum+=parseInt($(this).find("span[name^=next]").text());
				distnextsum+=parseInt($(this).find("span[name^=next]").text());
				tehsilcurrsum = tehsilcurrsum || 0;
				distcurrsum = distcurrsum || 0;
				tehsilprevsum = tehsilprevsum || 0;
				distprevsum = distprevsum || 0;
				tehsilnextsum = tehsilnextsum || 0;
				distnextsum = distnextsum || 0;
			});
			$(this).find(".currtot").text(tehsilcurrsum);
			$(this).find(".prevtot").text(tehsilprevsum);
			$(this).find(".nexttot").text(tehsilnextsum);
		});
		$('#currenttotal').text(distcurrsum);
		$('#previoustotal').text(distprevsum);
		$('#nexttotal').text(distnextsum);
		//alert(tsum);
		//alert(sum);
		/*var $previoussum = 0;
		$('.previous').each(function(k,v){
			$previoussum += parseInt($(this).val());
		});
		var $currentsum = 0;
		$('.current').each(function(k,v){
			$currentsum += parseInt($(this).val());
		});
		var $nextsum = 0;
		$('.next').each(function(k,v){
			$nextsum += parseInt($(this).val());
		});
		$('#previoustotal').text($previoussum);
		$('#currenttotal').text($currentsum);
		$('#nexttotal').text($nextsum);*/
	}
	/*$(document).on('blur','.next,.current',function(){
		if($(this).val.trim().length==0)
			$(this).val("0");
	});*/
	$(document).on('keyup','.next,.current',function(){
		dosum();
		/* var $previoussum = 0;
		$('.previous').each(function(k,v){
			$previoussum += parseInt($(this).val());
		});
		var $currentsum = 0;
		$('.current').each(function(k,v){
			$currentsum += parseInt($(this).val());
		});
		var $nextsum = 0;
		$('.next').each(function(k,v){
			$nextsum += parseInt($(this).val());
		});
		$('#previoustotal').text($previoussum);
		$('#currenttotal').text($currentsum);
		$('#nexttotal').text($nextsum); */
		
	});
</script>