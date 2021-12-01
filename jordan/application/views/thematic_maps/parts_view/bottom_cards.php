<?php $render = isset($render) ? $render : true; 
if($render){ ?>
<li class="col-md-3 col-sm-6 col-xs-12">
	<div class="graph_list">
	  <h2> <?php echo $heading; ?> </h2>
	  <div class="graph_img"> <img src="<?php echo base_url();?>includes/images1/<?php echo $image; ?>"> </div>
	  <div class="bar_textgraph"> <span> <?php echo $value; ?> </span> </div>
	</div>
</li>
<?php } ?>