<?php $width = isset($width) ? $width : '3';?>
<li class="clickable col-md-<?php echo $width; ?>">
  <div class="crdview_grphwrp">
    <h3><?php echo $heading; ?></h3>
    <div class="card-viewinner">
	<div class="card_viewpercent"> <?php echo $value; ?> </div>
      <div class="imgcardview"> <img src="<?php echo base_url();?>includes/images1/<?php echo $image; ?>"> </div>
      <div class="clearfix"></div>
    </div>
  </div>
</li>