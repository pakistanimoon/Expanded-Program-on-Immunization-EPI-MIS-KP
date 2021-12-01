<section class="content">
<div class="container bodycontainer">  
<div class="row">
 <div class="panel panel-primary">
  <div class="panel-heading">Asset Form View</div>
   <div class="panel-body">
    <table class="table table-bordered   table-striped table-hover  mytable3">
        <tbody>
            <tr>
				<td><label>WareHouse</label></td>
				<td>
				<?php echo $data[0]['warehouse_name']; ?>
				</td>
				<td><label>Asset Type</label></td>
				<td>
				<?php echo $data[0]['asset_type_name']; ?>
				</td>
				<td><label>Auto Asset Id</label></td>
				<td>
				<?php echo $data[0]['warehouse_name']; ?>
				</td>
			</tr>
			<tr>
				<td><label>Status</label></td>
				<td>
				<?php echo $data[0]['status']; ?>
				</td>
				<td><label>Serial No. </label></td>
				<td>
				<?php echo $data[0]['serial_no']; ?>
				</td>
				<td><label>Expected Life(Years)</label></td>
				<td>
				<?php echo $data[0]['estimate_life']; ?> 
				</td>
          </tr>
		  <tr>
				<td><label>Quantity</label></td>
				<td>
				<?php echo $data[0]['quantity']; ?>
				</td>
				<td><label>Manufacturing Year</label></td>
				<td>
					 <?php echo $data[0]['manufacturer_year']; ?>
				</td>
				<td></td>
				<td></td>
          </tr>
		</tbody>
    </table>
		<div class="row">
			<hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">       
				<button style="background: #008d4c" onclick="goBack()" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Back </button>
            </div>
        </div>
    </div> <!--end of panel body-->
   </div> <!--end of panel panel-primary-->
  </div><!--end of row-->
 </div><!--end of body container-->
</section><!-- /.content -->
<script type = "text/javascript">
    function goBack() {
        window.history.back();
    }
</script>