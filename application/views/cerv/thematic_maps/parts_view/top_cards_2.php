<?php $width = isset($width) ? $width : '3';?>
<li class="clickable col-md-<?php echo $width; ?>">
  <div class="crdview_grphwrp">
    <h3><?php echo $heading; ?></h3>
    <div class="card-viewinner">
		<div class="card_viewpercent"> <?php echo $value; ?> </div>
		<div class="crdview_grphwrp_right">
		    <h3><?php echo $heading_2; ?></h3>
		    <div class="card-viewinner_right">
			<div class="card_viewpercent_right"> <?php echo $value_2; ?> </div>
		    </div>
	  	</div>
      <div class="imgcardview_2"> <img src="<?php echo base_url();?>includes/images1/<?php echo $image; ?>"> </div>
      <div class="clearfix"></div>
    </div>
  </div>
</li>